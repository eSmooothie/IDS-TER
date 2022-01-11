<?php

namespace App\Controllers;

class Execom extends BaseController{
  public function index(){
    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }

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
    `execom_hist`.`SCHOOL_YEAR_ID` = '3'
    ) AS `b`";

    $execom = $this->execomModel
    ->select("
    `execom`.`ID` AS `ID`,
    `execom`.`NAME` AS `POSITION`,
    `b`.`TEACHER_ID` AS `TEACHER_ID`,
    `b`.`TEACHER_LN` AS `TEACHER_LN`,
    `b`.`TEACHER_FN` AS `TEACHER_FN`
    ")
    ->join($subquery, "`execom`.`ID` = `b`.`EXECOM_ID`", "LEFT")
    ->findAll();

    $sessionId = $this->session->get("adminID");
		$pageTitle = "ADMIN | TEACHER";
		$args = [
      'execom' => $execom,
		];

		$data = $this->mapPageParameters(
			$sessionId,
			$pageTitle,
			$args
		);

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

    $formerAssign = $this->execomHistoryModel
    ->select("
    `execom_hist`.`EXECOM_ID` AS `EXECOM_ID`,
    `execom_hist`.`SCHOOL_YEAR_ID` AS `SY_ID`,
    `execom_hist`.`TEACHER_ID` AS `TEACHER_ID`,
    `teacher`.`LN` AS `TEACHER_LN`,
    `teacher`.`FN` AS `TEACHER_FN`
    ")
    ->join("`teacher`","`teacher`.`ID` = `execom_hist`.`TEACHER_ID`","INNER")
    ->where("`execom_hist`.`EXECOM_ID`", $id)
    ->orderby("`execom_hist`.`SCHOOL_YEAR_ID`","DESC")
    ->findAll();

    $teachers = $this->teacherModel->orderBy("LN","ASC")->findAll();

    $sessionId = $this->session->get("adminID");
		$pageTitle = "ADMIN | TEACHER";
		$args = [
      'teachers' => $teachers,
      'execom' => $execom,
      'currentAssign' => $currentAssign,
      'school_year' => $sy,
      'formerAssign' => $formerAssign,
		];

		$data = $this->mapPageParameters(
			$sessionId,
			$pageTitle,
			$args
		);

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
