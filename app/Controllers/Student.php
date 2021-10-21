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



		$sy = $this->schoolyearModel->orderBy("ID","DESC")->first(); // get current school year


		$rawStudent = $this->studentModel
		->orderBy("`LN`","ASC")
		->findAll();

		$students = [];

		foreach ($rawStudent as $key => $value) {
			$studentInfo = [
				'ID' => $value['ID'],
				'LN' => $value['LN'],
				'FN' => $value['FN'],
			];

			$studentSection = $this->studentSectionModel
			->where("STUDENT_ID", $value['ID'])
			->where("SCHOOL_YEAR_ID", $sy['ID'])
			->first();

		  $section = $this->sectionModel
			->where("ID", $studentSection['SECTION_ID'])
			->first();

			$studentInfo['section'] = (empty($section))? "NOT ENROLLED":$section['NAME'];

			// current status
			$studentStatus = $this->studentStatusModel->where("STUDENT_ID", $value['ID'])
																								->where("SCHOOL_YEAR_ID", $sy['ID'])
																								->first();

			$studentInfo['status'] = $studentStatus['STATUS'];

			array_push($students, $studentInfo);
		}


		$data = [
			'id' => $this->session->get("adminID"),
			'pageTitle' => "ADMIN | STUDENT",
			'baseUrl' => base_url(),
			'students' => $students,
		];

		$data['uploadStudentMsg'] = (!empty($this->session->getFlashData("uploadStudentMsg")))?
		 			$this->session->getFlashData("uploadStudentMsg"): null;

		echo view("admin/layout/header", $data);
		echo view("admin/pages/nav",$data);
		echo view("admin/pages/student", $data);
		echo view("admin/layout/footer");
	}

	public function viewStudent($id = false){
		if(!$this->session->has("adminID")){
			return redirect()->to("/admin");
		}
		if(!$id){
			return redirect()->to("/admin/student");
		}

		$studentData = $this->studentModel->find($id);

		$sections = $this->studentSectionModel->join("`section`","`section`.`ID` = `student_section`.`SECTION_ID`")
																					->join("`school_year`","`school_year`.`ID` = `student_section`.`SCHOOL_YEAR_ID`")
																					->where("STUDENT_ID",$id)
																					->orderBy("SCHOOL_YEAR_ID","DESC")
																					->findAll();

		$status = $this->studentStatusModel->where("STUDENT_ID", $id)
																			->orderBy("SCHOOL_YEAR_ID","DESC")
																			->findAll();

		// TODO: get student evaluation data

		$data = [
			'id' => $this->session->get("adminID"),
			'pageTitle' => "ADMIN | STUDENT",
			'baseUrl' => base_url(),
			'studentData' => $studentData,
			'sections' => $sections,
			'status' => $status,
		];

		echo view("admin/layout/header", $data);
		echo view("admin/pages/nav",$data);
		echo view("admin/pages/studentData", $data);
		echo view("admin/layout/footer");
	}

	public function addNewStudentCSV(){
		  header("Content-type:application/json");
			$upload_file = $this->request->getFile("bulkEnroll");

			$uploadPath = WRITEPATH.'uploads\\docs\\';

			// upload file
	    if($upload_file->isValid() && !$upload_file->hasMoved() && $upload_file->getClientMimeType() == "application/vnd.ms-excel"){
	      $fileName = $upload_file->getRandomName(); // generate randomName
	      $upload_file->move($uploadPath, $fileName); // move the tmp file to the folder
	    }else{
	      $response = [
	        'message' => "Invalid CSV file",
					'data' => null,
	      ];
				$this->session->setFlashData("uploadStudentMsg", $response);
	      return $this->setResponseFormat('json')->respond($response, 200);
	    }

			// read file
	    $mode = "r";
	    $filePath = $uploadPath.$fileName;
	    $file = fopen($filePath, $mode);
	    $content = fread($file, filesize($filePath));
	    $file_data = explode("\r\n",$content); // get each line

			// TODO: loop through $data, remove quotation and separate each string base on comma.
	    $validLines = [];
	    foreach ($file_data as $key => $value) {
				if(empty($value)){
					break;
				}

	      $line = explode(",", $value);
	      // check if line is valid, return error w/ line if not
				if(count($line) == 4 && !empty($line[0])
				&& !empty($line[1])
				&& !empty($line[2])
				&& !empty($line[3])
			){
					array_push($validLines, $line);
				}else{
					$response = [
		        'message' => "Invalid line",
						'data' => $line,
		      ];
					$this->session->setFlashData("uploadStudentMsg", $response);
		      return $this->setResponseFormat('json')->respond($response, 200);
				}
	    }
		  // validate enrollee id, if exist return err w/ the error id
			$newStudents = [];
			foreach ($validLines as $key => $value) {
				$studentId = $value[0];
				$studentFn = $value[2];
				$studentLn = $value[1];
				$studentSection = $value[3];

				$isExist = $this->studentModel->find($studentId);

				if(empty($isExist)){
					$studentData = [
						'ID' => $studentId,
						'LN' => $studentLn,
						'FN' => $studentFn,
						'Section' => $studentSection,
					];

					array_push($newStudents, $studentData);
				}else{
					$response = [
		        'message' => "Duplicate student id",
						'data' => $value,
		      ];
					$this->session->setFlashData("uploadStudentMsg", $response);
		      return $this->setResponseFormat('json')->respond($response, 200);
				}
			}

			$sy = $this->schoolyearModel->orderBy("ID","DESC")->first();

			// start adding
			foreach ($newStudents as $key => $value) {
				$sectionData = $this->sectionModel->where("NAME", $value['Section'])->first();
				if(empty($sectionData)){
					$response = [
		        'message' => "Section does not exist.",
						'data' => $value,
		      ];
					$this->session->setFlashData("uploadStudentMsg", $response);
		      return $this->setResponseFormat('json')->respond($response, 200);
				}


				$studentData = [
					'ID' => $value['ID'],
					'FN' => $value['FN'],
					'LN' => $value['LN'],
					'PASSWORD' => $value['Section'],
				];
				// insert student
				$this->studentModel->insert($studentData);

				$studentSection = [
					'STUDENT_ID' => $value['ID'],
					'SECTION_ID' => $sectionData['ID'],
					'SCHOOL_YEAR_ID' => $sy['ID'],
					'CREATED_AT' => $this->getCurrentDateTime(),
				];

				$this->studentSectionModel->insert($studentSection);

				$studentStatus = [
					'SCHOOL_YEAR_ID' => $sy['ID'],
					'STUDENT_ID' => $value['ID'],
					'DATE' => $this->getCurrentDateTime(),
				];

				$this->studentStatusModel->insert($studentStatus);
			}

			$data = [
				'fileName' => $fileName,
				'path' => $filePath,
				'content' => $file_data,
				'valid_lines' => $validLines,
				'newStudents' => $newStudents,
			];

		  $response = [
		    "message" => count($newStudents)." Student Enrolled",
		    "data" => "Done",
		  ];
			$this->session->setFlashData("uploadStudentMsg", $response);
		  return $this->setResponseFormat('json')->respond($response, 200);
	}
}
