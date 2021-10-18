<?php

namespace App\Controllers;

class Teacher extends BaseController{
  public function index(){
    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }
    // do something
    $teacherData = $this->teacherModel->select("
                                            `teacher`.`ID` AS `ID`,
                                            `teacher`.`LN` AS `LN`,
                                            `teacher`.`FN` AS `FN`,
                                            `teacher`.`IS_LECTURER` AS `IS_LECTURER`,
                                            `department`.`NAME` AS `DEPARTMENT_NAME`
                                          ")
                                      ->join("`department`",
                                          "`department`.`ID` = `teacher`.`DEPARTMENT_ID`","LEFT")
                                          ->orderBy("LN","ASC")
                                          ->findAll();

    $department = $this->departmentModel->findAll();

    $data = [
			'id' => $this->session->get("adminID"),
			'pageTitle' => "ADMIN | TEACHER",
			'baseUrl' => base_url(),
      'teacherData' => $teacherData,
      'departmentData' => $department,
		];

    echo view("admin/layout/header", $data);
		echo view("admin/pages/teachers", $data);
		echo view("admin/layout/footer");
  }

  public function viewTeacher($id = false){
    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }
    if(!$id){
      return redirect()->to("/admin/teacher/");
    }
    // do something
    $teacherData = $this->teacherModel
    ->select("
    `teacher`.`ID` AS `ID`,
    `teacher`.`FN` AS `FN`,
    `teacher`.`LN` AS `LN`,
    `teacher`.`MOBILE_NO` AS `MOBILE_NO`,
    `teacher`.`PROFILE_PICTURE` AS `PROFILE_PICTURE`,
    `teacher`.`IS_LECTURER` AS `IS_LECTURER`,
    `department`.`ID` AS `DEPARTMENT_ID`,
    `department`.`NAME` AS `DEPARTMENT`
    ")
    ->join("`department`","`department`.`ID` = `teacher`.`DEPARTMENT_ID`","LEFT")
    ->find($id);

    $data = [
      'id' => $this->session->get("adminID"),
      'pageTitle' => "ADMIN | TEACHER",
      'baseUrl' => base_url(),
      'teacherData' => $teacherData,

    ];
    echo view("admin/layout/header", $data);
    echo view("admin/pages/viewTeacher", $data);
    echo view("admin/layout/footer");
  }

  public function add(){
    header("Content-type:application/json");
    // do something here
    $id = $this->request->getPost("id");
    $fn = $this->request->getPost("fn");
    $ln = $this->request->getPost("ln");
    $isLecturer = $this->request->getPost("isLecturer");
    $password = $this->request->getPost("password");
    $mobileNumber = $this->request->getPost("mobileNumber");
    $department = $this->request->getPost("department");

    // check if inputted id is valid
    $pattern = "/^\d{4}(-)(\d{1,}|\d{4})$/";
    $isValid = preg_match($pattern,$id);

    if(!$isValid){
      $response = [
        "message" => "Invalid ID format",
        "data" => null,
      ];
      return $this->setResponseFormat('json')->respond($response, 202);
    }

    // check if id is already exist.
    $isExist = $this->teacherModel->find($id);
    if($isExist){
      $response = [
        "message" => "ID already exist.",
        "data" => null,
      ];
      return $this->setResponseFormat('json')->respond($response, 202);
    }

    // hash password
    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    $teacherData = [
      'ID' => $id,
      'FN' => $fn,
      'LN' => $ln,
      'PASSWORD' => $hash_password,
      'MOBILE_NO' => $mobileNumber,
      'DEPARTMENT_ID' => $department,
      'IS_LECTURER' => (empty($isLecturer))? 0:1,
    ];

    $this->teacherModel->insert($teacherData);

     // {end}
    $data = [];
    $response = [
      "message" => "OK",
      "data" => null,
    ];
    return $this->setResponseFormat('json')->respond($response, 200);
  }

  public function func_name(){
    header("Content-type:application/json");
    // do something here

    // {end}
    $data = [];
    $response = [
      "message" => "OK",
      "data" => $data,
    ];
    return $this->setResponseFormat('json')->respond($response, 200);
  }
}
