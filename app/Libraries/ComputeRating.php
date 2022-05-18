<?php
namespace App\Libraries;

// equation
// n : Question #
// W[n] : Total rating recieve
// T[n] : Total person rated
// Q[n] : Average rate in `n` question
// Q[n] = W[n] / T[n]

// N : Total number of question
// category_ov = sum(Q[n]) / N
// overall = student_ov * .5 + peer_ov * .2 + super_ov * .3

// get all evaluation info of teacher Y in S.Y. Z as type X

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

class ComputeRating{

    private $evaluation_info_model;
    private $evaluation_question_model;
    private $rating_model;

    public function __construct(){
        $this->evaluation_info_model = new EvalInfo();
        $this->evaluation_question_model = new EvalQuestion();
        $this->rating_model = new Rating();
    }

    /**
	 * Compute the rating of teacher X
	 *
	 * @param Object $teacher_id
	 * @param Object $eval_type_id (1|2|3)
	 * @param Object $school_year_id
	 *
	 * @return Array {"rating":[],"overall":}
	 */
	public function get_rating($teacher_id, $eval_type_id, $school_year_id){
		
		$eval_info_table = "(SELECT `eval_info`.`ID` as `ID` FROM `eval_info` 
        WHERE `EVALUATED_ID` LIKE '$teacher_id' AND
        `EVAL_TYPE_ID` = '$eval_type_id' AND
        `SCHOOL_YEAR_ID` = '$school_year_id') as `a`
        ";

        $questions = $this->evaluation_question_model->where("EVAL_TYPE_ID", $eval_type_id)
        ->where("IS_REMOVE", 0)
        ->orderBy("ID","ASC")
        ->findAll();

        $Qn = []; // list of all average rate per question

        foreach ($questions as $data => $value){
            $question_id = $value['ID'];

            $result = $this->rating_model
            ->select("AVG(`rating`.`RATING`) * 10 AS `Qn`")
            ->join($eval_info_table, '`a`.`ID` = `rating`.`EVAL_INFO_ID`', 'inner')
            ->where('`rating`.`EVAL_QUESTION_ID`', $question_id)->first();

            array_push($Qn, ['question_id' => $question_id, 'avg_rate' => $result['Qn']]);
        }

        $overall = $this->total_rate_recieved($Qn) / count($Qn);

        return ["RATING" => $Qn, "OVERALL" => $overall];
	}

    public function get_student_rating($teacher_id, $school_year_id){
        $eval_info_table = "(SELECT `eval_info`.`ID` as `ID` FROM `eval_info` 
        WHERE `EVALUATED_ID` LIKE '$teacher_id' AND
        `EVAL_TYPE_ID` = '1' AND
        `SCHOOL_YEAR_ID` = '$school_year_id') as `a`
        ";

        $questions = $this->evaluation_question_model->where("EVAL_TYPE_ID", 1)
        ->where("IS_REMOVE", 0)
        ->orderBy("ID","ASC")
        ->findAll();

        $Qn = []; // list of all average rate per question

        foreach ($questions as $data => $value){
            $question_id = $value['ID'];

            $result = $this->rating_model
            ->select("AVG(`rating`.`RATING`) * 10 AS `Qn`")
            ->join($eval_info_table, '`a`.`ID` = `rating`.`EVAL_INFO_ID`', 'inner')
            ->where('`rating`.`EVAL_QUESTION_ID`', $question_id)->first();

            array_push($Qn, ['question_id' => $question_id, 'avg_rate' => $result['Qn']]);
        }

        $overall = $this->total_rate_recieved($Qn) / count($Qn);

        return ["RATING" => $Qn, "OVERALL" => $overall];
    }
    
    public function get_peer_rating($teacher_id, $school_year_id){
        $eval_info_table = "(SELECT `eval_info`.`ID` as `ID` FROM `eval_info` 
        WHERE `EVALUATED_ID` LIKE '$teacher_id' AND
        `EVAL_TYPE_ID` = '2' AND
        `SCHOOL_YEAR_ID` = '$school_year_id') as `a`
        ";

        $questions = $this->evaluation_question_model->where("EVAL_TYPE_ID", 2)
        ->where("IS_REMOVE", 0)
        ->orderBy("ID","ASC")
        ->findAll();

        $Qn = []; // list of all average rate per question

        foreach ($questions as $data => $value){
            $question_id = $value['ID'];

            $result = $this->rating_model
            ->select("AVG(`rating`.`RATING`) * 10 AS `Qn`")
            ->join($eval_info_table, '`a`.`ID` = `rating`.`EVAL_INFO_ID`', 'inner')
            ->where('`rating`.`EVAL_QUESTION_ID`', $question_id)->first();

            array_push($Qn, ['question_id' => $question_id, 'avg_rate' => $result['Qn']]);
        }

        $overall = $this->total_rate_recieved($Qn) / count($Qn);

        return ["RATING" => $Qn, "OVERALL" => $overall];
    }

    public function get_supervisor_rating($teacher_id, $school_year_id){
        $eval_info_table = "(SELECT `eval_info`.`ID` as `ID` FROM `eval_info` 
        WHERE `EVALUATED_ID` LIKE '$teacher_id' AND
        `EVAL_TYPE_ID` = '3' AND
        `SCHOOL_YEAR_ID` = '$school_year_id') as `a`
        ";

        $questions = $this->evaluation_question_model->where("EVAL_TYPE_ID", 3)
        ->where("IS_REMOVE", 0)
        ->orderBy("ID","ASC")
        ->findAll();

        $Qn = []; // list of all average rate per question

        foreach ($questions as $data => $value){
            $question_id = $value['ID'];

            $result = $this->rating_model
            ->select("AVG(`rating`.`RATING`) * 10 AS `Qn`")
            ->join($eval_info_table, '`a`.`ID` = `rating`.`EVAL_INFO_ID`', 'inner')
            ->where('`rating`.`EVAL_QUESTION_ID`', $question_id)->first();

            array_push($Qn, ['question_id' => $question_id, 'avg_rate' => $result['Qn']]);
        }

        $overall = $this->total_rate_recieved($Qn) / count($Qn);

        return ["RATING" => $Qn, "OVERALL" => $overall];
    }
	/**
	 * Compute the overall rating of the teacher
	 * 
	 * @param Float $studentOverall
	 * @param Float $peerOverall
	 * @param Float $supervisorOverall
	 * 
	 * @return Float overall rating
	 */
	public function get_overall_rating(float $student_overall, float $peer_0verall, float $supervisor_overall){
		return ($student_overall * .5) + ($peer_0verall * .2) + ($supervisor_overall * .3);
	}

    private function total_rate_recieved(array $arr){
        $sum = 0;
        foreach($arr as $key => $fields){
            $sum += $fields['avg_rate'];
        }

        return $sum;
    }
}