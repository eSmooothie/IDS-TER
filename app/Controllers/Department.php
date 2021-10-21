<?php

namespace App\Controllers;

class Department extends BaseController{
  public function index(){
    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }
    $currSY = $this->schoolyearModel->orderBy("ID","DESC")->first();

    $rawDept = $this->departmentModel->findAll();

    $department = [];

    foreach ($rawDept as $key => $value) {
      $deptId = $value['ID'];
      $deptName = $value['NAME'];

      $currChairperson = $this->departmentHistoryModel
      ->select("
      `teacher`.`ID` AS `ID`,
      `teacher`.`FN` AS `FN`,
      `teacher`.`LN` AS `LN`
      ")
      ->join("teacher","`teacher`.`ID` = `dept_hist`.`TEACHER_ID`","INNER")
      ->where("`dept_hist`.`SCHOOL_YEAR_ID`", $currSY['ID'])
      ->where("`dept_hist`.`DEPARTMENT_ID`", $deptId)
      ->first();

      $deptInfo = [
        'ID' => $deptId,
        'NAME' => $deptName,
        'CHAIRPERSON' => $currChairperson,
      ];

      array_push($department, $deptInfo);
    }

    // do something here
    $data = [
      'id' => $this->session->get("adminID"),
      'pageTitle' => "ADMIN | DEPARTMENT",
      'baseUrl' => base_url(),
      'department' => $department,
    ];

    echo view("admin/layout/header",$data);
    echo view("admin/pages/nav",$data);
    echo view("admin/pages/department",$data);
    echo view("admin/layout/footer");
  }

  public function view($id = false){
    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }
    if(!$id){
      return redirect()->to("/admin/department");
    }

    $school_year = $this->schoolyearModel->orderBy("ID","DESC")->findAll();

    if(!empty($this->session->getFlashData("viewChairperson"))){
      $sy = $this->session->getFlashData("viewChairperson");
    }else{
      $sy = $school_year[0]['ID'];
    }

    $chairperson = $this->departmentHistoryModel
    ->select("
    `teacher`.`ID` AS `ID`,
    `teacher`.`FN` AS `FN`,
    `teacher`.`LN` AS `LN`
    ")
    ->join("teacher","`teacher`.`ID` = `dept_hist`.`TEACHER_ID`","INNER")
    ->where("`dept_hist`.`SCHOOL_YEAR_ID`", $sy)
    ->where("`dept_hist`.`DEPARTMENT_ID`", $id)
    ->first();

    $teacher = $this->teacherModel->where("DEPARTMENT_ID",$id)->findAll();
    $department = $this->departmentModel->find($id);
    // do something here
    $data = [
      'id' => $this->session->get("adminID"),
      'pageTitle' => "ADMIN | DEPARTMENT",
      'baseUrl' => base_url(),
      'department' => $department,
      'teachers' => $teacher,
      'chairperson' => $chairperson,
      'school_year' => $school_year,
    ];

    echo view("admin/layout/header",$data);
    echo view("admin/pages/nav",$data);
    echo view("admin/pages/viewDepartment",$data);
    echo view("admin/layout/footer");
  }

  public function edit($id = false){
    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }
    if(!$id){
      return redirect()->to("/admin/department");
    }

    $school_year = $this->schoolyearModel->orderBy("ID","DESC")->findAll();

    if(!empty($this->session->getFlashData("viewChairperson"))){
      $sy = $this->session->getFlashData("viewChairperson");
    }else{
      $sy = $school_year[0]['ID'];
    }

    $chairperson = $this->departmentHistoryModel
    ->select("
    `teacher`.`ID` AS `ID`,
    `teacher`.`FN` AS `FN`,
    `teacher`.`LN` AS `LN`
    ")
    ->join("teacher","`teacher`.`ID` = `dept_hist`.`TEACHER_ID`","INNER")
    ->where("`dept_hist`.`SCHOOL_YEAR_ID`", $sy)
    ->where("`dept_hist`.`DEPARTMENT_ID`", $id)
    ->first();

    $department = $this->departmentModel->find($id);
    $teachers = $this->teacherModel->where("DEPARTMENT_ID",$id)->findAll();
    // do something here
    $data = [
      'id' => $this->session->get("adminID"),
      'pageTitle' => "ADMIN | DEPARTMENT",
      'baseUrl' => base_url(),
      'department' => $department,
      'chairperson' => $chairperson,
      'teachers' => $teachers,
    ];

    echo view("admin/layout/header",$data);
    echo view("admin/pages/nav",$data);
    echo view("admin/pages/editDepartment",$data);
    echo view("admin/layout/footer");
  }

  public function changeName(){
    header("Content-type:application/json");
    // do something here
    $id = $this->request->getPost("id");
    $name = $this->request->getPost("changeName");

    $update = [
      'NAME' => $name,
    ];
    $this->departmentModel->update($id, $update);
    // {end}
    $data = [
      'id' => $id,
      'name' => $name,
    ];
    $response = [
      "message" => "OK",
      "data" => $data,
    ];
    return $this->setResponseFormat('json')->respond($response, 200);
  }

  public function changeChairperson(){
    header("Content-type:application/json");
    // do something here
    $id = $this->request->getPost("id");
    $chairperson = $this->request->getPost("chairperson");

    $sy = $this->schoolyearModel->orderBy("ID","DESC")->first();

    $this->departmentHistoryModel
    ->where("DEPARTMENT_ID", $id)
    ->where("SCHOOL_YEAR_ID", $sy['ID'])
    ->set("TEACHER_ID", $chairperson)
    ->update();
    
    // {end}
    $data = [
      'id' => $id,
      'chairperson' => $chairperson,
    ];
    $response = [
      "message" => "OK",
      "data" => $data,
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
