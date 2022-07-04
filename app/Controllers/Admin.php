<?php

namespace App\Controllers;

use App\Libraries\UserDButil;
class Admin extends BaseController
{
	public function index(){		
		echo view("admin/index");
	}

	public function dashboard(){
		if(!$this->session->has("adminID")){
			return redirect()->to("/admin");
		}
		$school_year = $this->schoolyear_model->orderBy("ID","DESC")->first();
		$curr_school_year_id = $school_year['ID'];

		$countStudents = $this->student_model->countAll();
		$countTeacher = $this->teacher_model->countAll();

		$ttl_subj_in_sec_sql = "(
			SELECT 
				`SECTION_ID` AS `SECTION_ID`,
				COUNT(*) AS `TTL`
			FROM 
			`sec_subj_lst` 
			WHERE `SCHOOL_YEAR_ID`='$curr_school_year_id'
			GROUP BY `SECTION_ID`
			) AS `TTL_SUBJ`";

		$to_config_section = $this->section_model
		->select("
			`section`.`ID` AS `SECTION_ID`,
			`section`.`GRADE_LV` AS `SECTION_GRADE_LV`,
			`section`.`NAME` AS `SECTION_NAME`,
			`TTL_SUBJ`.`TTL` AS `TTL_SUBJ`")
		->join($ttl_subj_in_sec_sql,"`section`.`ID` = `TTL_SUBJ`.`SECTION_ID`","LEFT")
		->where("`TTL_SUBJ`.`TTL` IS NULL")
		->where("`section`.`IS_ACTIVE`",1)
		->findAll();

		$pageTitle = "ADMIN | DASHBOARD";
		$args = [
			'school_year' => $school_year,
			'countStudent' => $countStudents,
			'countTeacher' => $countTeacher,
			'to_config_section' => $to_config_section,
		];

		$data = $this->map_page_parameters(
			$pageTitle,
			$args
		);

		echo view("admin/layout/header", $data);
		echo view("admin/pages/dashboard", $data);
		echo view("admin/layout/footer");
	}

	public function school_year_is_exist(){
		header("Content-type:application/json");
		$from = $this->request->getGet("start_yr");
		$to = $this->request->getGet("end_yr");

		$to_match = "$from-$to";
		$match_school_year = $this->schoolyear_model
		->like('SY',$to_match)
		->findAll();

		$response = [
			'check_start_yr' => $from,
			'check_end_yr' => $to,
			'matches' => $match_school_year,
		];
		return $this->setResponseFormat('json')->respond($response, 200);
	}

	public function new_school_year(){
		header("Content-type:application/json");
		if(!$this->request->isAJAX()){
			$response["status_code"] = 400;
			$response["message"] = "Not an AJAX request.";
			return $this->setResponseFormat('json')->respond($response, 200);
		}

		$start_yr = $this->request->getPost("start_yr");
		$end_yr = $this->request->getPost("end_yr");
		$semester = $this->request->getPost("semester");

		$is_retain_teacher_subject = !empty($this->request->getPost("is_retain_teacher_subj"));
		$is_retain_student_sec = !empty($this->request->getPost("is_retain_stud_sec"));
		$is_retain_dept_chair = !empty($this->request->getPost("is_retain_dept_chair"));
		$is_retain_execom = !empty($this->request->getPost("is_retain_execom"));

		$curr_school_year_id = $this->schoolyear_model->orderBy("ID","DESC")->first()['ID'];

		$status_code = 200;
		$message = [];
		// create new school year
		$start_yr = explode("-", $start_yr);
		$start_yr = $start_yr[0];

		$end_yr = explode("-", $end_yr);
		$end_yr = $end_yr[0];

		$new_school_year = [
			"SY" => "$start_yr-$end_yr",
			"SEMESTER" => $semester
		];

		$this->schoolyear_model->insert($new_school_year);
		$new_school_year_id = $this->schoolyear_model->insertID;
		
		if($is_retain_teacher_subject){
			$query = $this->teacher_subject_model
			->select("
				TEACHER_ID,
				SUBJECT_ID,
				$new_school_year_id AS `SCHOOL_YEAR_ID`
			")
			->where("SCHOOL_YEAR_ID", $curr_school_year_id)
			->findAll();

			// update all teacher handled subject
			if(!empty($query)){
				$this->teacher_subject_model->insertBatch($query);
			}else{
				$status_code = 500;
				array_push($message, ["retain_teacher_subject"=>"Failed: No data from previous school year."]);
			}
		}

		if($is_retain_student_sec){
			$query = $this->student_section_model
			->select("
				STUDENT_ID,
				SECTION_ID,
				$new_school_year_id AS `SCHOOL_YEAR_ID`
			")
			->where("SCHOOL_YEAR_ID", $curr_school_year_id)
			->findAll();

			// update all student section
			if(!empty($query)){
				$this->student_section_model->insertBatch($query);
			}else{
				$status_code = 500;
				array_push($message, ["retain_student_section"=>"Failed: No data from previous school year."]);
			}
		}

		if($is_retain_dept_chair){
			$query = $this->department_history_model
			->select("
				DEPARTMENT_ID,
				TEACHER_ID,
				$new_school_year_id AS `SCHOOL_YEAR_ID`
			")
			->where("SCHOOL_YEAR_ID", $curr_school_year_id)
			->findAll();

			// update all dept
			if(!empty($query)){
				$this->department_history_model->insertBatch($query);
			}else{
				$status_code = 500;
				array_push($message, ["retain_dept_chairperson"=>"Failed: No data from previous school year."]);
			}
		}

		if($is_retain_execom){
			$query = $this->execom_history_model
			->select("
				EXECOM_ID,
				TEACHER_ID,
				$new_school_year_id AS `SCHOOL_YEAR_ID`
			")
			->where("SCHOOL_YEAR_ID", $curr_school_year_id)
			->findAll();

			// update all teacher handled subject
			if(!empty($query)){
				$this->execom_history_model->insertBatch($query);
			}else{
				$status_code = 500;
				array_push($message, ["retain_execom"=>"Failed: No data from previous school year."]);
			}
		}

		if($status_code == 500){
			$this->schoolyear_model->delete(["ID"=>$new_school_year_id]);
			array_push($message, ["schoolyear"=>"Failed: Abort creating new schoolyear due to errors."]);
		}

		// create new clearance for all students in database
		log_message("info","at Admin.new_school_year: Creating new clearances for all student.");
		$query = $this->student_status_model
		->select("
			0 AS `STATUS`,
			$new_school_year_id AS `SCHOOL_YEAR_ID`,
			STUDENT_ID
		")->where("SCHOOL_YEAR_ID", $curr_school_year_id)
		->findAll();

		if(!empty($query)){
			$this->student_status_model->insertBatch($query);
		}else{
			$status_code = 500;
			array_push($message, ["create_student_status"=>"Failed: No data from previous school year."]);
		}

		var_dump($query);
		sleep(2);

		$response = [
			"status_code" => $status_code,
			"err_message" => $message,
		];

		return $this->setResponseFormat('json')->respond($response, 200);
	}

	public function verify_credentials(){
		header("Content-type:application/json");
		$username = $this->request->getPost("username");
		$password = $this->request->getPost("password");
		$admin = $this->admin_model
		->where("username", $username)
		->where("password", $password)
		->first();

		$is_exist = !empty($admin);

		if($is_exist){
			$this->session->set("adminID",$admin['ID']);
		}

		$response = [
			"message" => "OK",
			"data" => $is_exist,
		];

		return $this->setResponseFormat('json')->respond($response, 200);
	}
}
