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

    $data = [
			'id' => $this->session->get("adminID"),
			'pageTitle' => "ADMIN | TEACHER",
			'baseUrl' => base_url(),
      'teacherData' => $teacherData,
		];

    echo view("admin/layout/header", $data);
		echo view("admin/pages/teachers", $data);
		echo view("admin/layout/footer");
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
