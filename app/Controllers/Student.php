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

		$sessionId = $this->session->get("adminID");
		$pageTitle = "ADMIN | STUDENT";
		$args = [
			
		];

		$data = $this->mapPageParameters(
			$sessionId,
			$pageTitle,
			$args
		);

		echo view("admin/layout/header", $data);
		echo view("admin/pages/nav",$data);
		echo view("admin/pages/student", $data);
		echo view("admin/layout/footer");
	}

	public function getStudents(){
		header("Content-type:application/json");
		
		$pageNumber = $this->request->getGet("pageNumber");
		$keyword = $this->request->getGet("keyword");

		$sy = $this->schoolyearModel->orderBy("ID","DESC")->first(); // get current school year

		if(!empty($keyword)){
			$searchExpression = "`STUDENT`.`ID` LIKE '%$keyword%' OR ".
			"`STUDENT`.`FN` LIKE '%$keyword%' OR ".
			"`STUDENT`.`LN` LIKE '%$keyword%' OR ".
			"`SECTION`.`NAME` LIKE '%$keyword%' AND ".
			"";
		}else{
			$searchExpression = "`STUD_STATUS`.`SCHOOL_YEAR_ID` = '{$sy['ID']}'";
		}

		$student_section = "(SELECT * FROM `STUDENT_SECTION` WHERE `STUDENT_SECTION`.`SCHOOL_YEAR_ID` = '".$sy['ID']."') AS `STUDENT_SECTION`";
		$student_status = "(SELECT `STUDENT_ID`, `STATUS` FROM `STUD_STATUS` WHERE `STUD_STATUS`.`SCHOOL_YEAR_ID` = '".$sy['ID']."') AS `STUDENT_STATUS`";
		$students = $this->studentModel
		->select("
			`STUDENT`.`ID` AS `STUDENT_ID`,
			`STUDENT`.`LN` AS `STUDENT_LN`,
			`STUDENT`.`FN` AS `STUDENT_FN`,
			`SECTION`.`NAME` AS `SECTION_NAME`,
			`STUDENT_STATUS`.`STATUS` AS `STATUS`
		")
		->join($student_section,"`STUDENT_SECTION`.`STUDENT_ID` = `STUDENT`.`ID`","LEFT")
		->join("`SECTION`","`STUDENT_SECTION`.`SECTION_ID` = `SECTION`.`ID`","LEFT")
		->join($student_status,"`STUDENT_STATUS`.`STUDENT_ID` = `STUDENT`.`ID`","LEFT")
		// ->where($searchExpression)
		->orderBy("`STUDENT`.`LN`","ASC")
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

	public function viewStudent($id = false){
		if(!$this->session->has("adminID")){
			return redirect()->to("/admin");
		}
		if(!$id){
			return redirect()->to("/admin/student");
		}

		$studentData = $this->studentModel->find($id);

		$sections = $this->studentSectionModel
		->select("
			`student_section`.`ID` AS `STUDENT_SECTION_ID`,
			`section`.`ID` AS `SECTION_ID`,
			`section`.`NAME` AS `SECTION_NAME`,
			`section`.`GRADE_LV` AS `SECTION_GRADE_LV`,
			`school_year`.`ID` AS `SCHOOL_YEAR_ID`,
			`school_year`.`SY` AS `SY`,
			`school_year`.`SEMESTER` AS `SEMESTER`,
			`stud_status`.`STATUS` AS `STATUS`
		")
		->join("`stud_status`","`stud_status`.`STUDENT_ID` = `student_section`.`STUDENT_ID` AND `stud_status`.`SCHOOL_YEAR_ID` = `student_section`.`SCHOOL_YEAR_ID`")
		->join("`section`","`section`.`ID` = `student_section`.`SECTION_ID`")
		->join("`school_year`","`school_year`.`ID` = `student_section`.`SCHOOL_YEAR_ID`")
		->where("`student_section`.`STUDENT_ID`",$id)
		->orderBy("`student_section`.`SCHOOL_YEAR_ID`","DESC")
		->findAll();

		$status = $this->studentStatusModel->where("STUDENT_ID", $id)
		->orderBy("SCHOOL_YEAR_ID","DESC")
		->findAll();

		$sessionId = $this->session->get("adminID");
		$pageTitle = "ADMIN | STUDENT";
		$args = [
			'base_url' => base_url(),
			'studentData' => $studentData,
			'sections' => $sections,
			'status' => $status,
		];

		$data = $this->mapPageParameters(
			$sessionId,
			$pageTitle,
			$args
		);

		echo view("admin/layout/header", $data);
		echo view("admin/pages/nav",$data);
		echo view("admin/pages/studentData", $data);
		echo view("admin/layout/footer");
	}

	public function addStudent(){
		if(!$this->session->has("adminID")){
			return redirect()->to("/admin");
		}

		$sections = $this->sectionModel->where('IS_ACTIVE',1)
		->orderBy("NAME","ASC")
		->findAll();

		$sessionId = $this->session->get("adminID");
		$pageTitle = "ADMIN | STUDENT";
		$args = [
			'sections' => $sections,
		];

		$data = $this->mapPageParameters(
			$sessionId,
			$pageTitle,
			$args
		);

		echo view("admin/layout/header", $data);
		echo view("admin/pages/nav",$data);
		echo view("admin/pages/addStudent", $data);
		echo view("admin/layout/footer");
	}

	public function addNewStudentIndividual(){
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

	public function addNewStudentCSV(){
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

			$this->studentModel->insert($studentData);

			// add Y student to X section
			$sectionData = $this->sectionModel->where("NAME", $section)->first();
			$studentSection = [
				'STUDENT_ID' => $id,
				'SECTION_ID' => $sectionData['ID'],
				'SCHOOL_YEAR_ID' => $this->getCurrentSchoolYear()['ID'],
				'CREATED_AT' => $this->getCurrentDateTime(),
			];

			$this->studentSectionModel->insert($studentSection);

			// add Y student status
			$studentStatus = [
				'STUDENT_ID' => $id,
				'SCHOOL_YEAR_ID' => $this->getCurrentSchoolYear()['ID'],
				'DATE' => $this->getCurrentDateTime(),	
			];

			$this->studentStatusModel->insert($studentStatus);
		}
	}

	private function isIDExist(string $studentId){
		$isExist = $this->studentModel->find($studentId);

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
		$isExist = $this->studentModel->find($studentId);

		if(!empty($isExist)){
			return false;
		}

		// check if section exist
		$section = trim($student[3]);
		$isExist = $this->sectionModel->where("NAME", $section)->first();

		if(empty($isExist)){
			return false;
		}

		return true;
	}
}
