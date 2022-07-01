<?php

namespace App\Controllers;

class Execom extends BaseController{
  public function index(){
    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }

    $current_schoolyear = $this->schoolyear_model->orderBy("ID","DESC")->first();

    $current_schoolyear_id = $current_schoolyear['ID'];

    $subquery = "(SELECT 
    `execom_hist`.`EXECOM_ID` AS `EXECOM_ID`,
    `execom_hist`.`SCHOOL_YEAR_ID` AS `SY_ID`,
    `execom_hist`.`TEACHER_ID` AS `TEACHER_ID`,
    `teacher`.`LN` AS `TEACHER_LN`,
    `teacher`.`FN` AS `TEACHER_FN`
    FROM 
    `execom_hist`
    INNER JOIN `teacher` ON `teacher`.`ID` = `execom_hist`.`TEACHER_ID`
    WHERE 
    `execom_hist`.`SCHOOL_YEAR_ID` = '$current_schoolyear_id'
    ) AS `appointee`";

    $execom = $this->execom_model
    ->select("
      `execom`.`ID` AS `ID`,
      `execom`.`NAME` AS `POSITION`,
      `appointee`.`TEACHER_ID` AS `TEACHER_ID`,
      `appointee`.`TEACHER_LN` AS `TEACHER_LN`,
      `appointee`.`TEACHER_FN` AS `TEACHER_FN`
    ")
    ->join($subquery, "`execom`.`ID` = `appointee`.`EXECOM_ID`", "LEFT")
    ->findAll();

    
		$pageTitle = "ADMIN | EXECOM";
		$args = [
      'execom' => $execom,
      'current_schoolyear' => $current_schoolyear,
		];

		$data = $this->map_page_parameters(
			$pageTitle,
			$args
		);

    echo view("admin/layout/header", $data);
		echo view("admin/pages/execom", $data);
		echo view("admin/layout/footer");
  }

  public function change($execom_id = false){
    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }

    if(!$execom_id){
      return redirect()->to("/admin/execom");
    }
    // do something here
    $current_school_year = $this->schoolyear_model->orderBy("ID","DESC")->first();

    $execom = $this->execom_model->find($execom_id);

    $formerAssign = $this->execom_history_model
    ->select("
      `execom_hist`.`EXECOM_ID` AS `EXECOM_ID`,
      `execom_hist`.`SCHOOL_YEAR_ID` AS `SY_ID`,
      `execom_hist`.`TEACHER_ID` AS `TEACHER_ID`,
      `teacher`.`LN` AS `TEACHER_LN`,
      `teacher`.`FN` AS `TEACHER_FN`
    ")
    ->join("`teacher`","`teacher`.`ID` = `execom_hist`.`TEACHER_ID`","INNER")
    ->where("`execom_hist`.`EXECOM_ID`", $execom_id)
    ->orderby("`execom_hist`.`SCHOOL_YEAR_ID`","DESC")
    ->findAll();

    $currentAssign = $formerAssign[0];

    $teachers = $this->teacher_model->orderBy("LN","ASC")->findAll();

		$pageTitle = "ADMIN | EXECOM";
		$args = [
      'teachers' => $teachers,
      'execom' => $execom,
      'currentAssign' => $currentAssign,
      'school_year' => $current_school_year,
      'formerAssign' => $formerAssign,
		];

		$data = $this->map_page_parameters(
			$pageTitle,
			$args
		);

    echo view("admin/layout/header", $data);
    echo view("admin/pages/editExecom", $data);
    echo view("admin/layout/footer");
  }

  public function assign(){
    header("Content-type:application/json");
    // do something here
    $id = $this->request->getPost("id");
    $teacher_id = $this->request->getPost("teacher");
    $sy = $this->schoolyear_model->orderBy("ID","DESC")->first();

    $isExist = $this->execom_history_model
    ->where("EXECOM_ID", $id)
    ->where("SCHOOL_YEAR_ID", $sy['ID'])
    ->first();

    if(!empty($isExist)){
      $this->execom_history_model
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

      $this->execom_history_model->insert($data);
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
