<?php
namespace App\Libraries;

use CodeIgniter\I18n\Time;


use \App\Models\Department;
use \App\Models\DeptHistory;
use \App\Models\EvalInfo;

use \App\Models\Evaluator;

use \App\Models\ExeComHistory;

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

      $student_subjects = []; 
      $is_cleared = false;
      $done_evaluated_counter = $this->get_total_done_evaluated($student_evaluator_id, $curr_school_year['ID']);
      
      // check if enrolled
      if(!empty($student_curr_section)){
        // get subjects
        $section_subject_data = $this->section_subject_model
        ->select("
          `teacher`.`ID` AS `TEACHER_ID`,
          `teacher`.`FN` AS `TEACHER_FN`,
          `teacher`.`LN` AS `TEACHER_LN`,
          `subject`.`ID` AS `SUBJ_ID`,
          `subject`.`DESCRIPTION` AS `SUBJ_DESC`
        ")
        ->join("`teacher`","`teacher`.`ID` = `sec_subj_lst`.`TEACHER_ID`","INNER")
        ->join("`subject`","`subject`.`ID` = `sec_subj_lst`.`SUBJECT_ID`","INNER")
        ->where("SECTION_ID", $student_curr_section['ID'])
        ->where("SCHOOL_YEAR_ID", $curr_school_year['ID'])
        ->findAll();
  
        foreach ($section_subject_data as $key => $value) {
          $subject_id = $value['SUBJ_ID'];
          $teacher_id = $value['TEACHER_ID'];
  
          // check if is done rating
          $is_done = $this->is_done_evaluated($student_evaluator_id, 
            $teacher_id, 
            $curr_school_year['ID'],
            1, $subject_id
          );
  
          $subject_data = [
            "ID" => $subject_id,
            "DESCRIPTION" => $value['SUBJ_DESC']
          ];
          
          $teacher_data = [
            "ID" => $teacher_id,
            "FN" => $value["TEACHER_FN"],
            "LN" => $value["TEACHER_LN"]
          ];

          $subject = [
            'is_done' => $is_done,
            'teacher_data' => $teacher_data,
            'subject_data' => $subject_data,
          ];
  
          array_push($student_subjects, $subject);
        }
  
        $is_cleared = $this->is_cleared($student_data['ID']);
        
        // update student status
        $update_status = [
          'STATUS' => ($is_cleared)? 1 : 0,
          'DATE' => $this->time->now()->toDateTimeString()
        ];
      
        $this->student_status_model
          ->where("SCHOOL_YEAR_ID", $curr_school_year['ID'])
          ->where("STUDENT_ID", $student_data['ID'])
          ->set($update_status)
          ->update();
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
      $to_rate_as_peer = $this->get_teacher_to_rate($id, $teacher_deparment['ID'], $teacher_evaluator_id, $curr_school_year['ID'], 2);

      // is supervisor
      $is_chairperson = $this->is_chairperson($teacher_data['ID'], $teacher_data['DEPARTMENT_ID'], $curr_school_year['ID']);
      $is_principal = $this->is_principal($teacher_data['ID'], $curr_school_year['ID']);

      $to_rate_as_supervisor = null;
      if($is_chairperson){
        $to_rate_as_supervisor = $this->get_teacher_to_rate($id, $teacher_deparment['ID'], $teacher_evaluator_id, $curr_school_year['ID'], 3);
      }else if($is_principal){
        $to_rate_as_supervisor = $this->get_teacher_to_rate($id, $teacher_deparment['ID'], $teacher_evaluator_id, $curr_school_year['ID'], 3, true);
      }

      $is_cleared = $this->is_cleared($teacher_data['ID'], false);

      return [
        'data' => $teacher_data,
        'evaluator_id' => $teacher_evaluator_id,
        'subject_teaches' => $teacher_subject_teaches,
        'department_data' => $teacher_deparment,
        'to_rate_as_peer' => $to_rate_as_peer,
        'to_rate_as_supervisor' => $to_rate_as_supervisor,
        'is_cleared' => $is_cleared,
        'is_chairperson' => $is_chairperson,
        'is_principal' => $is_principal,
        'is_supervisor' => ($is_chairperson || $is_principal),
      ];
    }

    public function get_teacher_to_rate($teacher_id, $department_id, $evaluator_id, $school_year_id, $eval_type,
      bool $is_principal = false){

      if($is_principal){
        
        $department_query = "(
          SELECT
            `dept_hist`.`DEPARTMENT_ID` AS `DEPARTMENT_ID`,
            `dept_hist`.`TEACHER_ID` AS `TEACHER_ID`,
            `department`.`NAME` AS `DEPT_NAME`
            FROM `dept_hist` 
            INNER JOIN `department` ON `department`.`ID` = `dept_hist`.`DEPARTMENT_ID`
            WHERE `SCHOOL_YEAR_ID` = '$school_year_id'
        ) as `dept_hist`";
        
        $execom_query = "(
          SELECT
            `execom_hist`.`EXECOM_ID` AS `EXECOM_ID`,
            `execom_hist`.`TEACHER_ID` AS `TEACHER_ID`,
            `execom`.`NAME` AS `EXECOM_NAME`
            FROM `execom_hist` 
            INNER JOIN `execom` ON `execom`.`ID` = `execom_hist`.`EXECOM_ID`
            WHERE `SCHOOL_YEAR_ID` = '$school_year_id' AND `execom_hist`.`EXECOM_ID` != 1
        ) as `execom_hist`";

        $eval_info_query = "(SELECT 
        `eval_info`.`ID` AS `ID`,
        `eval_info`.`EVALUATED_ID` AS `EVALUATED_ID` 
        FROM `eval_info` 
        WHERE `eval_info`.`EVALUATOR_ID` = '$evaluator_id' AND `eval_info`.`SCHOOL_YEAR_ID` = '$school_year_id'
        AND `eval_info`.`EVAL_TYPE_ID` = '$eval_type'
        ) as `eval_info`";

        $teacher_to_rate = $this->teacher_model
        ->select("
          `teacher`.`ID` AS `TEACHER_ID`,
          `teacher`.`FN` AS `TEACHER_FN`,
          `teacher`.`LN` AS `TEACHER_LN`,
          `execom_hist`.`EXECOM_ID` AS `EXECOM`,
          `dept_hist`.`DEPARTMENT_ID` AS `DEPT`,
          IF(`dept_hist`.`DEPARTMENT_ID` IS NULL, `execom_hist`.`EXECOM_NAME`, `dept_hist`.`DEPT_NAME`) AS `POSITION`,
          `eval_info`.`ID` AS `EVAL_INFO_ID`")
        ->join($department_query,"`dept_hist`.`TEACHER_ID` = `teacher`.`ID`","LEFT")
        ->join($execom_query,"`execom_hist`.`TEACHER_ID` = `teacher`.`ID`","LEFT")
        ->join($eval_info_query,"`teacher`.`ID` = `eval_info`.`EVALUATED_ID`","LEFT")
        ->where("`dept_hist`.`DEPARTMENT_ID` IS NOT NULL")
        ->orWhere("`execom_hist`.`EXECOM_ID` IS NOT NULL")
        ->findAll();

      }else{

        $check_done_evaluated_query = "(SELECT 
          `eval_info`.`ID` AS `ID`,
          `eval_info`.`EVALUATED_ID` AS `EVALUATED_ID` 
          FROM `eval_info` WHERE `eval_info`.`EVALUATOR_ID` = '$evaluator_id' AND `eval_info`.`EVAL_TYPE_ID` = '$eval_type'
          AND `eval_info`.`SCHOOL_YEAR_ID` = '$school_year_id'
          ) AS `eval_info`";

        $teacher_to_rate = $this->teacher_model
          ->select("
            `teacher`.`ID` AS `TEACHER_ID`,
            `teacher`.`FN` AS `TEACHER_FN`,
            `teacher`.`LN` AS `TEACHER_LN`,
            `eval_info`.`ID` AS `EVAL_INFO_ID`
          ")
          ->join($check_done_evaluated_query,"`eval_info`.`EVALUATED_ID` = `teacher`.`ID`","LEFT")
          ->where("`teacher`.`DEPARTMENT_ID`", $department_id)
          ->notLike("`teacher`.`ID`", $teacher_id)
          ->where("`teacher`.`ON_LEAVE`", 0)
          ->findAll();
          
      }
      
      $teacher_peers = [];
     
      foreach ($teacher_to_rate as $key => $value) {
        // check if X done rated Y
        $position = (isset($value['POSITION']))? $value['POSITION']: null;
        $is_done = null;
        $teacher = null;

        $teacher = [
          "ID" => $value['TEACHER_ID'],
          "FN" => $value['TEACHER_FN'],
          "LN" => $value['TEACHER_LN']
        ];

        $is_done = (empty($value['EVAL_INFO_ID']))? False: True;

        $data = [
          'is_done' => $is_done,
          'position' => $position,
          'teacher' => $teacher,
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

    public function get_total_done_evaluated($evaluator_id, $school_year_id){
      $done_evaluated = $this->evaluator_info_model->where("EVALUATOR_ID", $evaluator_id)
      ->where("SCHOOL_YEAR_ID", $school_year_id)
      ->countAllResults();
      return $done_evaluated;
    }

    public function get_total_number_of_colleagues($teacher_id, $department_id, $include_leave = False){
      return $this->teacher_model
        ->where("DEPARTMENT_ID", $department_id)
        ->notLike("ID", $teacher_id)
        ->where("ON_LEAVE", ($include_leave)? 1: 0)
      ->countAllResults();
    }

    public function get_student_total_subjects($student_id, $school_year_id){
      $section = $this->student_section_model
        ->where("STUDENT_ID", $student_id)
        ->where("SCHOOL_YEAR_ID", $school_year_id)
        ->first();

      $ttl_subjects_in_section = $this->section_subject_model
        ->where("SECTION_ID", $section['SECTION_ID'])
        ->where("SCHOOL_YEAR_ID", $school_year_id)
        ->countAllResults();

      return $ttl_subjects_in_section;
    }

    public function get_teacher_needed_to_evaluate($teacher_id, $department_id, $school_year_id){
      // Count number of teachers needed to rate in order mark as cleared.
      $total_peers_to_rate = $this->teacher_model
        ->where("DEPARTMENT_ID", $department_id)
        ->notLike("ID", $teacher_id)
        ->where("ON_LEAVE", 0)
        ->countAllResults();

      if($this->is_principal($teacher_id, $school_year_id)){
        $total_chairpersons = $this->department_history_model
        ->where("SCHOOL_YEAR_ID", $school_year_id)
        ->countAllResults();

        $total_execoms = $this->execom_history_model
        ->where("SCHOOL_YEAR_ID", $school_year_id)
        ->where("EXECOM_ID !=", 1)
        ->countAllResults();

        return $total_peers_to_rate + $total_chairpersons + $total_execoms;
      }else if($this->is_chairperson($teacher_id, $department_id, $school_year_id)){
        return $total_peers_to_rate * 2;
      }

      return $total_peers_to_rate;
    }

    public function is_cleared($user_id, $is_student = true){
      if(gettype($is_student) !== "boolean"){
        return -1;
      }

      $evaluator_id = $this->get_evaluator_id($user_id, $is_student);
      $current_school_year_id = $this->get_current_school_year()['ID'];
      $done_evaluated_counter = $this->get_total_done_evaluated($evaluator_id, $current_school_year_id);

      if($is_student){
        $total_to_rate = $this->get_student_total_subjects($user_id, $current_school_year_id);
      }else{
        $teacher_data = $this->teacher_model->find($user_id);
        $total_to_rate = $this->get_teacher_needed_to_evaluate($teacher_data['ID'], $teacher_data['DEPARTMENT_ID'], $current_school_year_id);
      }
      $is_cleared = intval($total_to_rate) == intval($done_evaluated_counter);
      log_message("debug","at UserDBUtil method is_cleared: user_id=$user_id ttl_subj=$total_to_rate ttl_done=$done_evaluated_counter");
      return $is_cleared;
    }
}