<?php

namespace App\Controllers;

class Admin extends BaseController
{
	public function index(){
		$data = $this->map_page_parameters("IDS | TER");
		
		echo view("admin/layout/header",$data);
		echo view("admin/index");
		echo view("admin/layout/footer");
	}

	public function dashboard(){
		if(!$this->session->has("adminID")){
			return redirect()->to("/admin");
		}
		$school_year = $this->schoolyearModel->orderBy("ID","DESC")->first();

		$countStudents = $this->studentModel->countAll();
		$countTeacher = $this->teacherModel->countAll();

		
		$sessionId = $this->session->get("adminID");
		$pageTitle = "ADMIN | DASHBOARD";
		$args = [
			'school_year' => $school_year,
			'countStudent' => $countStudents,
			'countTeacher' => $countTeacher,
		];

		$data = $this->map_page_parameters(
			$pageTitle,
			$args
		);

		echo view("admin/layout/header", $data);
		echo view("admin/pages/dashboard", $data);
		echo view("admin/layout/footer");
	}

	public function addSchoolYear(){
		header("Content-type:application/json");
		// do something here
		$from = $this->request->getPost("from");
		$to = $this->request->getPost("to");
		$semester = $this->request->getPost("semester");

		$from = (int)substr($from, 0, 4);
		$to = (int)substr($to,0,4);

		if($from >= $to){
			$response = [
				"message" => "Invalid school year",
				"data" => null,
			];
			return $this->setResponseFormat('json')->respond($response, 200);
		}

		$sy = "$from-$to";

		$allSy = $this->schoolyearModel->findAll();
		$isExist = null;
		foreach ($allSy as $key => $value) {
			if(strcmp($sy, $value['SY']) == 0 && $value['SEMESTER'] == $semester){
				$isExist = 1;
				break;
			}
		}

		if(!empty($isExist)){
			$response = [
				"message" => "$from-$to:$semester already exist.",
				"data" => null,
			];
			return $this->setResponseFormat('json')->respond($response, 200);
		}
		$add = [
			'SY' => $sy,
			'SEMESTER' => $semester,
		];

		$this->schoolyearModel->insert($add);

		// add
		// {end}
		$data = [
			'from' => $from,
			'to' => $to,
			'semester' => $semester,
		];
		$response = [
			"message" => "OK",
			"data" => $data,
		];
		return $this->setResponseFormat('json')->respond($response, 200);
	}

	public function verifyCredentials(){
		header("Content-type:application/json");
		$username = $this->request->getPost("username");
		$password = $this->request->getPost("password");
		$admin = $this->adminModel->where("username", $username)
								->where("password", $password)
								->first();

		$data = (!empty($admin))? true:false;
		if(!empty($admin)){
		$this->session->set("adminID",$admin['ID']);
		}
		$response = [
		"message" => "OK",
		"data" => $data,
		];
		return $this->setResponseFormat('json')->respond($response, 200);
	}
}


// public function verifyCredentials(){
//   header("Content-type:application/json");
  // $response = [
  //   "message" => "OK",
  //   "data" => $data,
  // ];
//   return $this->setResponseFormat('json')->respond($response, 200);
// }
