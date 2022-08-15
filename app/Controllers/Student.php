<?php

namespace App\Controllers;
// public function newSection(){
//   header("Content-type:application/json");
//   $data = [];
//   $response = [
//     "message" => "OK",
//     "data" => $data,
//   ];
//   return $this->setResponseFormat('json')->respond($response, 200);
// }
class Student extends BaseController
{
	public function index(){
		if(!$this->session->has("adminID")){
			return redirect()->to("/admin");
		}

		$pageTitle = "ADMIN | STUDENT";
		$args = [];

		$data = $this->map_page_parameters(
			$pageTitle,
			$args
		);

		echo view("admin/layout/header", $data);
		echo view("admin/pages/student", $data);
		echo view("admin/layout/footer");
	}

	public function get_students(){
		header("Content-type:application/json");
		if(!$this->session->has("adminID")){
			$response = [
				"message" => "Invalid API call."
			];
			return $this->setResponseFormat('json')->respond($response, 400);
		}

		$pageNumber = $this->request->getGet("pageNumber");
		$keyword = $this->request->getGet("keyword");

		$sy = $this->schoolyear_model->orderBy("ID","DESC")->first(); // get current school year
		$curr_schoolyear_id = $sy['ID'];
		$searchExpression = "`student`.`ID` IS NOT NULL";
		if(!empty($keyword)){
			$searchExpression = "`student`.`ID` LIKE '%$keyword%' OR ".
			"`student`.`FN` LIKE '%$keyword%' OR ".
			"`student`.`LN` LIKE '%$keyword%' OR ".
			"`section`.`NAME` LIKE '%$keyword%'";
		}

		$student_section = "(SELECT `SECTION_ID`,`STUDENT_ID` FROM `student_section` WHERE `student_section`.`SCHOOL_YEAR_ID` = '$curr_schoolyear_id') AS `STUDENT_SECTION`";
		$student_status = "(SELECT `STUDENT_ID`, `STATUS` FROM `stud_status` WHERE `stud_status`.`SCHOOL_YEAR_ID` = '$curr_schoolyear_id') AS `STUDENT_STATUS`";
		$students = $this->student_model
		->select("
			`student`.`ID` AS `STUDENT_ID`,
			`student`.`LN` AS `STUDENT_LN`,
			`student`.`FN` AS `STUDENT_FN`,
			`section`.`NAME` AS `SECTION_NAME`,
			`STUDENT_STATUS`.`STATUS` AS `STATUS`
		")
		->join($student_section,"`STUDENT_SECTION`.`STUDENT_ID` = `student`.`ID`","LEFT")
		->join("`section`","`STUDENT_SECTION`.`SECTION_ID` = `section`.`ID`","LEFT")
		->join($student_status,"`STUDENT_STATUS`.`STUDENT_ID` = `student`.`ID`","LEFT")
		->where($searchExpression)
		->orderBy("`student`.`LN`","ASC")
		->findAll(20,$pageNumber * 20);

		$data = $students;

		$response = [
			"pageNumber" => $pageNumber,
			"keyword" => $keyword,
			"message" => "OK",
			"data" => $data,
		];
		return $this->setResponseFormat('json')->respond($response, 200);
	}

	public function view_student_page($id = false){
		if(!$this->session->has("adminID")){
			return redirect()->to("/admin");
		}
		if(!$id){
			return redirect()->to("/admin/student");
		}

		$studentData = $this->student_model->find($id);

		$student_section_sql = "(
			SELECT `student_section`.`ID` AS `ID`,
				`student_section`.`STUDENT_ID` AS `STUDENT_ID`,
				`student_section`.`SCHOOL_YEAR_ID` AS `SCHOOL_YEAR_ID`,
				`section`.`NAME` AS `SEC_NAME`,
				`section`.`GRADE_LV` AS `SEC_GRADE_LV`
			FROM
				`student_section`
			INNER JOIN `section` ON `section`.`ID` = `student_section`.`SECTION_ID`
			WHERE
				`student_section`.`STUDENT_ID` = '$id'
		) AS `sec`";

		$sections = $this->schoolyear_model
		->select("
			`school_year`.`ID` AS `SCHOOL_YEAR_ID`,
			`school_year`.`SY` AS `SY`,
			`school_year`.`SEMESTER` AS `SEMESTER`,
			`sec`.`SEC_NAME` AS `SECTION_NAME`,
			`sec`.`SEC_GRADE_LV` AS `SECTION_GRADE_LV`,
			`stud_status`.`STATUS` AS `STATUS`
		")
		->join($student_section_sql,"`sec`.`SCHOOL_YEAR_ID` = `school_year`.`ID`","LEFT")
		->join("`stud_status`","`stud_status`.`STUDENT_ID` = `sec`.`STUDENT_ID` AND `stud_status`.`SCHOOL_YEAR_ID` = `school_year`.`ID`", "LEFT")
		->orderBy("`school_year`.`ID`","DESC")
		->findAll();

		$pageTitle = "ADMIN | STUDENT";
		$args = [
			'base_url' => base_url(),
			'studentData' => $studentData,
			'sections' => $sections,
		];

		$data = $this->map_page_parameters(
			$pageTitle,
			$args
		);

		echo view("admin/layout/header", $data);
		echo view("admin/pages/studentData", $data);
		echo view("admin/layout/footer");
	}

	public function add_student_page(){
		if(!$this->session->has("adminID")){
			return redirect()->to("/admin");
		}

		$sections = $this->section_model
		->where('IS_ACTIVE',1)
		->orderBy("NAME","ASC")
		->findAll();

		$pageTitle = "ADMIN | STUDENT";

		$args = [
			'sections' => $sections,
		];

		$data = $this->map_page_parameters(
			$pageTitle,
			$args
		);

		echo view("admin/layout/header", $data);
		echo view("admin/pages/addStudent", $data);
		echo view("admin/layout/footer");
	}

	public function add_new_student_individual(){
		// process individual enrollment
		header("Content-type:application/json");
		$studentId = $this->request->getPost("id");
		$studentFN = $this->request->getPost("fn");
		$studentLN = $this->request->getPost("ln");
		$studentSection = $this->request->getPost("section");
		$enroll = $studentId.", ". 
				$studentLN.", ". 
				$studentFN.", ".
				$studentSection;
		// validate
		$isExist = $this->isIDExist($studentId);
		if(!$isExist){
			$this->enrollStudent([$enroll]);
		}

		$response = [
			'message' => (!$isExist)? "SUCCESS":"FAILED",
			'data' => $enroll,
		];
		return $this->setResponseFormat('json')->respond($response, 200);
	}

	public function add_new_student_csv(){
		header("Content-type:application/json");
		$upload_file = $this->request->getFile("bulkEnroll");

		// upload file
		$fileName = $this->uploadFile($upload_file);
		
		if($fileName == null){
			$response = [
				'message' => "Upload failed.",
				'data' => null,
			];
			$this->session->setFlashData("uploadStudentMsg", $response);
			return $this->setResponseFormat('json')->respond($response, 200);
		}
	    
		// read file
	    $content = (string)$this->readCSV($fileName);
	    $data = explode("\r\n", $content); // get each line	
		
		$studentList = [
			'success' => [],
			'fail' => [],
		];
		
		for ($i=0; $i < sizeof($data); $i++) { 
			$student = $data[$i];

			// split
			$info = explode(",", $student);

			// -------- validation ----------
			$isValid = $this->validateStudent($info);

			if($isValid){
				array_push($studentList['success'], $student);
			}else{
				array_push($studentList['fail'], $student);
			}
		}

		$toEnroll = $studentList['success'];

		$this->enrollStudent($toEnroll);

		$response = [
			'studentList' => $studentList,
		];
		

		return $this->setResponseFormat('json')->respond($response, 200);
	}

	private function enrollStudent($studentList){
		for ($i=0; $i < sizeof($studentList); $i++) { 
			$student = $studentList[$i];

			// split
			$info = explode(",", $student);

			$id = trim($info[0]);
			$ln = trim($info[1]);
			$fn = trim($info[2]);
			$section = trim($info[3]);

			// insert new student
			$studentData = [
				'ID' => $id,
				'FN' => $fn,
				'LN' => $ln,
				'PASSWORD' => strtoupper($section),
			];

			$this->student_model->insert($studentData);

			// add Y student to X section
			$sectionData = $this->section_model->where("NAME", $section)->first();
			$studentSection = [
				'STUDENT_ID' => $id,
				'SECTION_ID' => $sectionData['ID'],
				'SCHOOL_YEAR_ID' => $this->getCurrentSchoolYear()['ID'],
				'CREATED_AT' => $this->getCurrentDateTime(),
			];

			$this->student_section_model->insert($studentSection);

			// add Y student status
			$studentStatus = [
				'STUDENT_ID' => $id,
				'SCHOOL_YEAR_ID' => $this->getCurrentSchoolYear()['ID'],
				'DATE' => $this->getCurrentDateTime(),	
			];

			$this->student_status_model->insert($studentStatus);
		}
	}

	private function isIDExist(string $studentId){
		$isExist = $this->student_model->find($studentId);

		if(empty($isExist)){
			return false;
		}

		return true;
	}

	private function validateStudent(array $student){
		// check len
		if(sizeof($student) != 4){
			return false;
		}
		// check if index is not empty
		$isEmpty = false;
		for ($j=0; $j < sizeof($student); $j++) { 
			if(empty($student[$j])){
				$isEmpty = true;
				break;
			}
		}

		if($isEmpty){
			return false;
		}

		// check studentid if exist
		$studentId = trim($student[0]);
		$isExist = $this->student_model->find($studentId);

		if(!empty($isExist)){
			return false;
		}

		// check if section exist
		$section = trim($student[3]);
		$isExist = $this->section_model->where("NAME", $section)->first();

		if(empty($isExist)){
			return false;
		}

		return true;
	}
}
