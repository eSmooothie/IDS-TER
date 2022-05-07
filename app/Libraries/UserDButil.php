<?php
namespace App\Libraries;

use CodeIgniter\I18n\Time;

use \App\Models\ActivityLog;
use \App\Models\Admin;
use \App\Models\Department;
use \App\Models\DeptHistory;
use \App\Models\EvalInfo;
use \App\Models\EvalQuestion;
use \App\Models\EvalType;
use \App\Models\Evaluator;
use \App\Models\ExeCom;
use \App\Models\ExeComHistory;
use \App\Models\Rating;
use \App\Models\Report;
use \App\Models\SchoolYear;
use \App\Models\Section;
use \App\Models\SectionSubject;
use \App\Models\Student;
use \App\Models\StudentSection;
use \App\Models\StudentStatus;
use \App\Models\Subjects;
use \App\Models\Teacher;
use \App\Models\TeacherSubject;

class UserDButil{
    
    public $time;

    private $school_year_model;
    private $student_model;
    private $student_section_model;
    private $section_model;
    private $evaluator_model;
    private $section_subject_model;
    private $teacher_model;
    private $subject_model;
    private $student_status_model;
    private $teacher_subject_model;
    private $department_model;
    private $evaluator_info_model;
    private $department_history_model;
    private $execom_history_model;


    public function __construct(){
        $this->time = new Time();

        $this->school_year_model = new SchoolYear();
        $this->student_model = new Student();
        $this->student_section_model = new StudentSection();
        $this->section_model = new Section();
       
        $this->section_subject_model = new SectionSubject();
        $this->subject_model = new Subjects();
        $this->student_status_model = new StudentStatus();

        $this->teacher_model = new Teacher();
        $this->teacher_subject_model = new TeacherSubject();

        $this->department_model = new Department();

        $this->evaluator_model = new Evaluator();
        $this->evaluator_info_model = new EvalInfo();

        $this->department_history_model = new DeptHistory();
        $this->execom_history_model = new ExeComHistory();
    }

    public function is_done_evaluated($evaluator_id, $evaluated_id, $school_year_id, $evaluation_type, $subject_id = null){
      $expr = (empty($subject_id))? "`SUBJECT_ID` IS NULL": "`SUBJECT_ID` = '$subject_id'";

      $is_done = $this->evaluator_info_model
          ->where("EVALUATOR_ID", $evaluator_id)
          ->where("EVALUATED_ID", $evaluated_id)
          ->where("SCHOOL_YEAR_ID", $school_year_id)
          ->where("EVAL_TYPE_ID", $evaluation_type)
          ->where($expr)
          ->countAllResults();
  
      return ($is_done > 0)? True : False;
    }

    public function get_student_info($id){
      $curr_school_year =  $this->get_current_school_year(); // get current school year
      $student_data = $this->student_model->find($id); 
      $curr_section = $this->student_section_model
        ->where("STUDENT_ID", $student_data['ID'])
        ->where("SCHOOL_YEAR_ID", $curr_school_year['ID'])
        ->first();
  
      $student_curr_section = null;
      if(!empty($curr_section)){
        $student_curr_section = $this->section_model->find($curr_section['SECTION_ID']);
      }
  
      // retrieve student evaluator information
      $student_evaluator_id = $this->get_evaluator_id($id, True);

      // TODO: CLEAN
      $student_subjects = []; 
      $is_cleared = false;
      $done_evaluated_counter = 0;
  
      if(!empty($student_curr_section)){
        // get subjects
        $section_subject_data = $this->section_subject_model
        ->where("SECTION_ID", $student_curr_section['ID'])
        ->where("SCHOOL_YEAR_ID", $curr_school_year['ID'])
        ->findAll();
  
        foreach ($section_subject_data as $key => $subject) {
          $subject_id = $subject['SUBJECT_ID'];
          $teacher_id = $subject['TEACHER_ID'];
  
          // check if is done rating
          $is_done = $this->is_done_evaluated($student_evaluator_id, 
            $teacher_id, 
            $curr_school_year['ID'],
            1, $subject_id
          );
  
          if($is_done){
            $done_evaluated_counter += 1;
          }
  
          $teacher_data = $this->teacher_model->find($teacher_id);
          $subject_data = $this->subject_model->find($subject_id);
  
          $subject = [
            'is_done' => $is_done,
            'teacher_data' => $teacher_data,
            'subject_data' => $subject_data,
          ];
  
          array_push($student_subjects, $subject);
        }
  
        $ttl_subjects_in_section = $this->section_subject_model
        ->where("SECTION_ID", $student_curr_section['ID'])
        ->where("SCHOOL_YEAR_ID", $curr_school_year['ID'])
        ->countAllResults();
  
        $is_cleared = ($ttl_subjects_in_section == $done_evaluated_counter)? true:false;
  
        // update student status
        if($is_cleared){
          $update_status = [
            'STATUS' => 1,
            'DATE' => $this->time->now()->toDateTimeString(),
          ];
  
          $this->student_status_model
          ->where("SCHOOL_YEAR_ID", $curr_school_year['ID'])
          ->where("STUDENT_ID", $student_data['ID'])
          ->set($update_status)
          ->update();
        }
      }
  
      return [
        "personal_data" => $student_data,
        "section" => $student_curr_section,
        "evaluator_id" => $student_evaluator_id,
        "subjects" => $student_subjects,
        "status" => $is_cleared,
        "total_evaluated" => $done_evaluated_counter,
        "school_year" => $curr_school_year
      ];
    }

    public function get_teacher_info($id){
      $curr_school_year = $this->get_current_school_year();
      $teacher_data = $this->teacher_model->find($id);
      $teacher_deparment = $this->department_model->find($teacher_data['DEPARTMENT_ID']);
      // get teachers subjects teaches
      $teacher_subject_teaches = $this->teacher_subject_model
      ->select("
      `subject`.`ID` AS `ID`,
      `subject`.`DESCRIPTION` AS `NAME`,
      `school_year`.`SY` AS `SY`,
      `school_year`.`SEMESTER` AS `SEMESTER`
      ")
      ->join("`subject`","`subject`.`ID` = `tchr_subj_lst`.`SUBJECT_ID`","INNER")
      ->join("`school_year`","`school_year`.`ID` = `tchr_subj_lst`.`SCHOOL_YEAR_ID`","INNER")
      ->where("`tchr_subj_lst`.`TEACHER_ID`", $id)
      ->findAll();

      // retrieve evaluator id
      $teacher_evaluator_id = $this->get_evaluator_id($id, False);

      // get teacher colleagues
      $teacher_peers = $this->get_teacher_colleagues($id, $teacher_deparment['ID'], $teacher_evaluator_id, $curr_school_year['ID']);

      return [
        'teacher_data' => $teacher_data,
        'evaluator_id' => $teacher_evaluator_id,
        'subject_teaches' => $teacher_subject_teaches,
        'department_data' => $teacher_deparment,
        'colleagues' => $teacher_peers,
        'is_chairperson' => $this->is_chairperson($teacher_data['ID'], $teacher_data['DEPARTMENT_ID'], $curr_school_year['ID']),
        'is_principal' => $this->is_principal($teacher_data['ID'], $curr_school_year['ID']),
        'is_supervisor' => $this->is_supervisor($teacher_data['ID'], $teacher_data['DEPARTMENT_ID'], $curr_school_year['ID'])
      ];
    }

    public function get_teacher_colleagues($teacher_id, $department_id, $evaluator_id, $school_year_id){
      $teacher_colleagues = $this->teacher_model
      ->where("DEPARTMENT_ID", $department_id)
      ->notLike("ID", $teacher_id)
      ->where("ON_LEAVE", 0)
      ->findAll();

      $teacher_peers = [];
     
      foreach ($teacher_colleagues as $key => $colleague) {
        // check if X done rated Y
        $is_done = $this->is_done_evaluated($evaluator_id, $colleague['ID'], $school_year_id, 2);

        $data = [
          'is_done' => $is_done,
          'teacher' => $colleague,
        ];

        array_push($teacher_peers, $data);
      }
      
      return $teacher_peers;
    }

    public function is_chairperson($teacher_id, $department_id, $school_year_id){
      $is_chairperson = $this->department_history_model
      ->where("SCHOOL_YEAR_ID", $school_year_id)
      ->where("DEPARTMENT_ID", $department_id)
      ->where("TEACHER_ID", $teacher_id)
      ->countAllResults();

      return ($is_chairperson > 0)? True : False;
    }

    public function is_principal($teacher_id, $school_year_id){
      $is_principal = $this->execom_history_model
      ->where("SCHOOL_YEAR_ID", $school_year_id)
      ->where("EXECOM_ID", 1)
      ->where("TEACHER_ID", $teacher_id)
      ->countAllResults();

      return ($is_principal > 0)? True : False;
    }

    public function is_supervisor($teacher_id, $department_id, $school_year_id){
      return $this->is_chairperson($teacher_id, $department_id, $school_year_id) || $this->is_principal($teacher_id, $school_year_id);
    }

    public function get_evaluator_id($user_id, $is_student = True){
      $field_name = ($is_student)? "STUDENT_ID" : "TEACHER_ID";

      $evaluator_data = $this->evaluator_model
      ->where($field_name, $user_id)
      ->first();
  
      if(empty($evaluator_data)){
        $_create = [
          $field_name => $user_id,
        ];
        $this->evaluator_model->insert($_create);
        $evaluator_id = $this->evaluator_model->insertID;
      }else{
        $evaluator_id = $evaluator_data['ID'];
      }

      return $evaluator_id;
    }

    public function get_current_school_year(){
      return $this->school_year_model->orderBy("ID","DESC")->first();
    }
}