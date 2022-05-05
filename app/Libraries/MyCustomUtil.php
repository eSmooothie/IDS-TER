<?php
namespace App\Libraries;

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

class MyCustomUtil{
    
    public function is_done_evaluated($evaluator_id, $evaluated_id, $school_year_id, $evaluation_type, $subject_id = null){
        $eval_info_model = new EvalInfo();

        $expr = (empty($subject_id))? "'SUBJECT_ID' IS NULL": "'SUBJECT_ID' = '$subject_id'";

        $is_done = $eval_info_model
            ->where("EVALUATOR_ID", $evaluator_id)
            ->where("EVALUATED_ID", $evaluated_id)
            ->where("SCHOOL_YEAR_ID", $school_year_id)
            ->where("EVAL_TYPE_ID", $evaluation_type)
            ->where($expr)
            ->countAllResults();
    
          return ($is_done > 0)? True : False;
      }
}