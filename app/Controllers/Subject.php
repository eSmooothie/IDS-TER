<?php

namespace App\Controllers;

class Subject extends BaseController{
  public function index(){
    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }
    // do something here
    $subject = $this->subject_model->findAll();

    $pageTitle = "ADMIN | SUBJECT";
    $args = [
      'subjects' => $subject,
    ];
    $data = $this->map_page_parameters($pageTitle, $args);

    echo view("admin/layout/header", $data);
		echo view("admin/pages/subject", $data);
		echo view("admin/layout/footer");
  }

  public function add(){
    header("Content-type:application/json");
    // do something here
    $name = $this->request->getPost("subjectName");

    // {end}
    $data = [
      'DESCRIPTION' => $name,
    ];

    $this->subject_model->insert($data);

    $response = [
      "message" => "OK",
      "data" => $data,
    ];
    return $this->setResponseFormat('json')->respond($response, 200);
  }
}
