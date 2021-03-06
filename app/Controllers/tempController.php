<?php

namespace App\Controllers;

class Name extends BaseController{
  public function index(){
    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }
    // do something here

    $data = [
			'id' => $this->session->get("adminID"),
			'pageTitle' => "ADMIN | view_name",
			'baseUrl' => base_url(),
      // add some variables here
		];
    echo view("admin/layout/header", $data);
		echo view("admin/pages/nav",$data);
		echo view("admin/pages/view_name", $data);
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
