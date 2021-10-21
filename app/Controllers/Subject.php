<?php

namespace App\Controllers;

class Subject extends BaseController{
  public function index(){
    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }
    // do something here
    $subject = $this->subjectModel->findAll();

    $data = [
			'id' => $this->session->get("adminID"),
			'pageTitle' => "ADMIN | SUBJECT",
			'baseUrl' => base_url(),
      'subjects' => $subject,
		];

    echo view("admin/layout/header", $data);
		echo view("admin/pages/nav",$data);
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

    $this->subjectModel->insert($data);

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
