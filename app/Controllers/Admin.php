<?php

namespace App\Controllers;

class Admin extends BaseController
{
	public function index()
	{
    $data = [
      'pageTitle' => "IDS | TER",
    ];
		echo view("admin/layout/header",$data);
    echo view("admin/index");
    echo view("admin/layout/footer");
	}

  public function dashboard(){
    if($this->session->has("adminID")){
      $data = [
        'id' => $this->session->get("adminID"),
        'pageTitle' => "ADMIN | DASHBOARD",
				'baseUrl' => base_url(),
      ];
      echo view("admin/layout/header", $data);
      echo view("admin/pages/dashboard", $data);
      echo view("admin/layout/footer");
    }else{
      return redirect()->to("/admin");
    }
  }

  public function verifyCredentials(){
    header("Content-type:application/json");
    $username = $this->request->getPost("username");
    $password = $this->request->getPost("password");
    $admin = $this->adminModel->where("username", $username)
                              ->where("password", $password)
                              ->first();

    $data = (!empty($admin))? true:false;
    if(!empty($admin)){
      $this->session->set("adminID",$admin['ID']);
    }
    $response = [
      "message" => "OK",
      "data" => $data,
    ];
    return $this->setResponseFormat('json')->respond($response, 200);
  }
}


// public function verifyCredentials(){
//   header("Content-type:application/json");
  // $response = [
  //   "message" => "OK",
  //   "data" => $data,
  // ];
//   return $this->setResponseFormat('json')->respond($response, 200);
// }
