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
    $sy = $this->schoolyearModel->orderBy("ID","DESC")->first(); // get current school year
    $sectionData = $this->sectionModel->where("ID", $sectionId)->first();
    $subjects = $this->sectionSubjectModel->where("SECTION_ID", $sectionId)->findAll();
    $studentsInSec = $this->studentSectionModel->where("SECTION_ID", $sectionId)
                                          ->where("SCHOOL_YEAR_ID",$sy['ID'])
                                          ->findAll();
    $students = [];
    foreach ($studentsInSec as $key => $student) {
      $studentID = $student['STUDENT_ID'];

      // check if there is a record for current school year
      $studStatus = $this->studentStatusModel->where("STUDENT_ID", $studentID)
                                            ->where("SCHOOL_YEAR_ID", $sy['ID'])
                                            ->first();
      if(empty($studStatus)){
        // if none, create one
        $updateStatus = [
          'SCHOOL_YEAR_ID' => $sy['ID'],
          'STUDENT_ID' => $studentID,
          'DATE' => $this->getCurrentDateTime(),
        ];
        $this->studentStatusModel->insert($updateStatus);
      }
      $studentData = $this->studentModel->select(
                                          "`student`.`ID` AS `ID`,
                                           `student`.`FN` AS `FN`,
                                           `student`.`LN` AS `LN`,
                                           `student`.`IS_ACTIVE` AS `IS_ACTIVE`,
                                           `stud_status`.`STATUS` AS `STATUS`,
                                           `stud_status`.`SCHOOL_YEAR_ID` AS `SCHOOL_YEAR_ID`,
                                           `stud_status`.`DATE` AS `DATE`
                                          "
                                        )
                                        ->join("`stud_status`",
                                               "`stud_status`.`STUDENT_ID` = `student`.`ID`",
                                               "LEFT")
                                        // ->where("`stud_status`.`SCHOOL_YEAR_ID`",$sy['ID'])
                                        ->orderBy("`stud_status`.`STATUS`","DESC")
                                        ->find($studentID);

      array_push($students, $studentData);
    }

    $data = [
      'id' => $this->session->get("adminID"),
      'pageTitle' => "ADMIN | SECTION",
      'baseUrl' => base_url(),
      'sectionData' => $sectionData,
      'subjects' => $subjects,
      'students' => $students,
      'schoolyear' => $sy,
    ];

    echo view("admin/layout/header", $data);
    echo view("admin/pages/viewSection", $data);
    echo view("admin/layout/footer");
  }

  public function editSection($gradeLv = false, $sectionId = false){
    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }

    if(!$gradeLv || !$sectionId){
      return redirect()->to("/admin/section");
    }
    $sy = $this->schoolyearModel->orderBy("ID","DESC")->first(); // get current school year
    $sectionData = $this->sectionModel->where("ID", $sectionId)->first();
    $studentsInSec = $this->studentSectionModel->where("SECTION_ID", $sectionId)
                                          ->where("SCHOOL_YEAR_ID",$sy['ID'])
                                          ->findAll();
    $allStudents = $this->studentModel->findAll();
    $data = [
      'id' => $this->session->get("adminID"),
      'pageTitle' => "ADMIN | SECTION",
      'baseUrl' => base_url(),
      'sectionData' => $sectionData,
      'schoolyear' => $sy,
      'students' => $studentsInSec,
      'allStudents' => $allStudents,
    ];

    if(!empty($this->session->getFlashData('enroll'))){
      $data['enrollStudentStatus'] = $this->session->getFlashData('enroll');
    }else{
      $data['enrollStudentStatus'] = false;
    }

    echo view("admin/layout/header", $data);
    echo view("admin/pages/editSection", $data);
    echo view("admin/layout/footer");
  }

  public function enrollStudents(){
    header("Content-type:application/json");
    $enrollee = $this->request->getPost("enrollee");
    $sectionId = $this->request->getPost("id");
    // get current school year
    $sy = $this->schoolyearModel->orderBy("ID","DESC")->first();

    // check if student x is already enrolled in curr s.y
    $remove = [];
    foreach ($enrollee as $key => $value) {
      $check = $this->studentSectionModel->where("STUDENT_ID", $value)
                                        ->where("SCHOOL_YEAR_ID", $sy['ID'])
                                        ->first();
      if(!empty($check)){
        // remove
        array_push($remove, $value);
        unset($enrollee[$key]);
      }
    }

    // enroll student
    $enrolled = [];
    foreach ($enrollee as $key => $value) {
      $enroll = [
        'STUDENT_ID' => $value,
        'SECTION_ID' => $sectionId,
        'SCHOOL_YEAR_ID' => $sy['ID'],
        'CREATED_AT' => $this->getCurrentDateTime(),
      ];
      array_push($enrolled, $value);
      $this->studentSectionModel->insert($enroll);
    }
    $data = [
      'enrolled' => $enrolled,
      'remove' => $remove,
      'sy' => $sy,
    ];

    $this->session->setFlashdata("enroll", $data);

    $response = [
      "message" => "OK",
      "data" => $data,
    ];
    return $this->setResponseFormat('json')->respond($response, 200);
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
