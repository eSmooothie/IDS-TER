<?php

namespace App\Controllers;

class Execom extends BaseController{
  public function index(){
    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }
    // do something here

    $currSy = $this->schoolyearModel->orderBy("ID","DESC")->first();
    $rawData = $this->execomModel->findAll();

    $execom = [];

    foreach ($rawData as $key => $value) {

      $teacher = $this->execomHistoryModel
      ->select("
      `teacher`.`ID` AS `ID`,
      `teacher`.`FN` AS `FN`,
      `teacher`.`LN` AS `LN`
      ")
      ->join("`teacher`","`teacher`.`ID` = `execom_hist`.`TEACHER_ID`","INNER")
      ->where("`execom_hist`.`EXECOM_ID`", $value['ID'])
      ->where("`execom_hist`.`SCHOOL_YEAR_ID`", $currSy['ID'])
      ->first();

      $d = [
        'ID' => $value['ID'],
        'POSITION' => $value['NAME'],
        'ASSIGN' => $teacher,
      ];

      array_push($execom, $d);
    }

    $data = [
			'id' => $this->session->get("adminID"),
			'pageTitle' => "ADMIN | EXECOM",
			'baseUrl' => base_url(),
      // add some variables here
      'execom' => $execom,
		];
    echo view("admin/layout/header", $data);
		echo view("admin/pages/nav",$data);
		echo view("admin/pages/execom", $data);
		echo view("admin/layout/footer");
  }

  public function change($id = false){
    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }

    if(!$id){
      return redirect()->to("/admin/execom");
    }
    // do something here
    $sy = $this->schoolyearModel->orderBy("ID","DESC")->first();
    $execom = $this->execomModel->find($id);
    $currentAssign = $this->execomHistoryModel
    ->where("EXECOM_ID", $id)
    ->where("SCHOOL_YEAR_ID", $sy['ID'])
    ->first();

    $teachers = $this->teacherModel->orderBy("LN","ASC")->findAll();

    $data = [
      'id' => $this->session->get("adminID"),
      'pageTitle' => "ADMIN | EXECOM",
      'baseUrl' => base_url(),
      // add some variables here
      'teachers' => $teachers,
      'execom' => $execom,
      'currentAssign' => $currentAssign,
      'school_year' => $sy,
    ];
    echo view("admin/layout/header", $data);
    echo view("admin/pages/nav",$data);
    echo view("admin/pages/editExecom", $data);
    echo view("admin/layout/footer");
  }

  public function assign(){
    header("Content-type:application/json");
    // do something here
    $id = $this->request->getPost("id");
    $teacher_id = $this->request->getPost("teacher");
    $sy = $this->schoolyearModel->orderBy("ID","DESC")->first();

    $isExist = $this->execomHistoryModel
    ->where("EXECOM_ID", $id)
    ->where("SCHOOL_YEAR_ID", $sy['ID'])
    ->first();

    if(!empty($isExist)){
      $this->execomHistoryModel
      ->where("EXECOM_ID", $id)
      ->where("SCHOOL_YEAR_ID", $sy['ID'])
      ->set("TEACHER_ID", $teacher_id)
      ->update();
    }else{
      $data = [
        'EXECOM_ID' => $id,
        'TEACHER_ID' => $teacher_id,
        'SCHOOL_YEAR_ID' => $sy['ID'],
      ];

      $this->execomHistoryModel->insert($data);
    }
    // {end}
    $data = [
      'EXECOM_ID' => $id,
      'TEACHER_ID' => $teacher_id,
      'SCHOOL_YEAR_ID' => $sy['ID']
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
