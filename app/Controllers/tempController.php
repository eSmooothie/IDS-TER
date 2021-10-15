<?php

namespace App\Controllers;

class Name extends BaseController{
  public function index(){
    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }
    // do something here
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
