<?php

namespace App\Controllers;

// public function newSection(){
//   header("Content-type:application/json");
//   $response = [
//     "message" => "OK",
//     "data" => $data,
//   ];
//   return $this->setResponseFormat('json')->respond($response, 200);
// }

class Section extends BaseController{

  public function index(){
    if($this->session->has("adminID")){
      $gradeLevel = [];

      for ($i=7; $i <= 12 ; $i++) {
        $sections = $this->sectionModel->where("GRADE_LV", $i)->findAll();
        $gradeLevel[$i] = $sections;
      }

      $data = [
        'id' => $this->session->get("adminID"),
        'pageTitle' => "ADMIN | SECTION",
        'baseUrl' => base_url(),
        'gradeLevel' => $gradeLevel,
      ];
      echo view("admin/layout/header", $data);
      echo view("admin/pages/section", $data);
      echo view("admin/layout/footer");
    }else{
      return redirect()->to("/admin");
    }
  }

  public function viewSection($gradeLv = false, $sectionId = false){
    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }

    if(!$gradeLv || !$sectionId){
      return redirect()->to("/admin/section");
    }

    $data = [
      'id' => $this->session->get("adminID"),
      'pageTitle' => "ADMIN | SECTION",
      'baseUrl' => base_url(),
      'gradeLv' => $gradeLv,
      'sectionId' => $sectionId,
    ];

    echo view("admin/layout/header", $data);
    echo view("admin/pages/viewSection", $data);
    echo view("admin/layout/footer");
  }

  public function newSection(){
    header("Content-type:application/json");
    $gradeLevel = $this->request->getPost("gradeLevel");
    $sectionName = $this->request->getPost("sectionName");
    $hasRNI = $this->request->getPost("hasRNI");

    $data = [
      'GRADE_LV' => (int)$gradeLevel,
      'NAME' => $sectionName,
      'HAS_RNI' => ($hasRNI == "on")? 1 : 0,
      'DATE' => $this->getCurrentDateTime(),
    ];

    $this->sectionModel->insert($data);

    $response = [
      "message" => "OK",
      "data" => $data,
    ];
    return $this->setResponseFormat('json')->respond($response, 200);
  }
}
