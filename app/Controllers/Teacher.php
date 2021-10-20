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

    $department = $this->departmentModel->findAll();

    $data = [
			'id' => $this->session->get("adminID"),
			'pageTitle' => "ADMIN | TEACHER",
			'baseUrl' => base_url(),
      'teacherData' => $teacherData,
      'departmentData' => $department,
		];

    echo view("admin/layout/header", $data);
		echo view("admin/pages/teachers", $data);
		echo view("admin/layout/footer");
  }

  public function viewTeacher($id = false){
    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }
    if(!$id){
      return redirect()->to("/admin/teacher/");
    }
    // do something
    $teacherData = $this->teacherModel
    ->select("
    `teacher`.`ID` AS `ID`,
    `teacher`.`FN` AS `FN`,
    `teacher`.`LN` AS `LN`,
    `teacher`.`MOBILE_NO` AS `MOBILE_NO`,
    `teacher`.`PROFILE_PICTURE` AS `PROFILE_PICTURE`,
    `teacher`.`IS_LECTURER` AS `IS_LECTURER`,
    `department`.`ID` AS `DEPARTMENT_ID`,
    `department`.`NAME` AS `DEPARTMENT`
    ")
    ->join("`department`","`department`.`ID` = `teacher`.`DEPARTMENT_ID`","LEFT")
    ->find($id);

    $data = [
      'id' => $this->session->get("adminID"),
      'pageTitle' => "ADMIN | TEACHER",
      'baseUrl' => base_url(),
      'teacherData' => $teacherData,

    ];
    echo view("admin/layout/header", $data);
    echo view("admin/pages/viewTeacher", $data);
    echo view("admin/layout/footer");
  }

  public function editTeacher($id = false){
    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }
    if(!$id){
      return redirect()->to("/admin/teacher/");
    }
    // do something
    // get teacher data
    $teacherData = $this->teacherModel
    ->select("
    `teacher`.`ID` AS `ID`,
    `teacher`.`FN` AS `FN`,
    `teacher`.`LN` AS `LN`,
    `teacher`.`MOBILE_NO` AS `MOBILE_NO`,
    `teacher`.`PROFILE_PICTURE` AS `PROFILE_PICTURE`,
    `teacher`.`IS_LECTURER` AS `IS_LECTURER`,
    `department`.`ID` AS `DEPARTMENT_ID`,
    `department`.`NAME` AS `DEPARTMENT`
    ")
    ->join("`department`","`department`.`ID` = `teacher`.`DEPARTMENT_ID`","LEFT")
    ->find($id);

    // get current teacher subject
    $currSY = $this->schoolyearModel->orderBy("ID","DESC")->first();
    $currentSubjects = $this->teacherSubjectModel
    ->select("
    `subject`.`ID` AS `ID`,
    `subject`.`DESCRIPTION` AS `DESCRIPTION`,
    ")
    ->join("`subject`","`subject`.`ID` = `tchr_subj_lst`.`SUBJECT_ID`","INNER")
    ->where("SCHOOL_YEAR_ID", $currSY['ID'])
    ->where("TEACHER_ID", $id)
    ->findAll();

    if(empty($currentSubjects)){
      $schoolYear = $this->schoolyearModel->findAll();
      $currSY = null;
      foreach ($schoolYear as $key => $value) {
        $sy_id = $value['ID'];
        $currentSubjects = $this->teacherSubjectModel
        ->select("
        `subject`.`ID` AS `ID`,
        `subject`.`DESCRIPTION` AS `DESCRIPTION`,
        ")
        ->join("`subject`","`subject`.`ID` = `tchr_subj_lst`.`SUBJECT_ID`","INNER")
        ->where("SCHOOL_YEAR_ID", $sy_id)
        ->where("TEACHER_ID", $id)
        ->findAll();

        if(!empty($currentSubjects)){
          $currSY = $schoolYear[$key];
          break;
        }
      }
    }
    // get all subject
    $subjects = $this->subjectModel->findAll();

    $data = [
      'id' => $this->session->get("adminID"),
      'pageTitle' => "ADMIN | TEACHER",
      'baseUrl' => base_url(),
      'teacherData' => $teacherData,
      'teacherSubjects' => $currentSubjects,
      'currSySubject' => $currSY,
      'subjects' => $subjects,
    ];

    if(!empty($this->session->getFlashData("update"))){
      $data['formMessage'] = $this->session->getFlashData("update");
    }else{
      $data['formMessage'] = null;
    }

    if(!empty($this->session->getFlashData("update1"))){
      $data['passwordFormMessage'] = $this->session->getFlashData("update1");
    }else{
      $data['passwordFormMessage'] = null;
    }

    if(!empty($this->session->getFlashData("update2"))){
      $data['subjectFormMessage'] = $this->session->getFlashData("update2");
    }else{
      $data['subjectFormMessage'] = null;
    }
    echo view("admin/layout/header", $data);
    echo view("admin/pages/editTeacher", $data);
    echo view("admin/layout/footer");
  }

  public function add(){
    header("Content-type:application/json");
    // do something here
    $id = $this->request->getPost("id");
    $fn = $this->request->getPost("fn");
    $ln = $this->request->getPost("ln");
    $isLecturer = $this->request->getPost("isLecturer");
    $password = $this->request->getPost("password");
    $mobileNumber = $this->request->getPost("mobileNumber");
    $department = $this->request->getPost("department");

    // check if inputted id is valid
    $pattern = "/^\d{4}(-)(\d{1,}|\d{4})$/";
    $isValid = preg_match($pattern,$id);

    if(!$isValid){
      $response = [
        "message" => "Invalid ID format",
        "data" => null,
      ];
      return $this->setResponseFormat('json')->respond($response, 202);
    }

    // check if id is already exist.
    $isExist = $this->teacherModel->find($id);
    if($isExist){
      $response = [
        "message" => "ID already exist.",
        "data" => null,
      ];
      return $this->setResponseFormat('json')->respond($response, 202);
    }

    // hash password
    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    $teacherData = [
      'ID' => $id,
      'FN' => $fn,
      'LN' => $ln,
      'PASSWORD' => $hash_password,
      'MOBILE_NO' => $mobileNumber,
      'DEPARTMENT_ID' => $department,
      'IS_LECTURER' => (empty($isLecturer))? 0:1,
    ];

    $this->teacherModel->insert($teacherData);

     // {end}
    $data = [];
    $response = [
      "message" => "OK",
      "data" => null,
    ];
    return $this->setResponseFormat('json')->respond($response, 200);
  }

  public function editProfileInfo(){
    header("Content-type:application/json");
    // do something here
    $id = $this->request->getPost("id");
    $fn = $this->request->getPost("fn");
    $ln = $this->request->getPost("ln");
    $mobileNumber = $this->request->getPost("mobileNumber");
    $isLecturer = $this->request->getPost("isLecturer");

    $updateData = [];
    if(!empty($fn)){
      $updateData['FN'] = $fn;
    }
    if(!empty($ln)){
      $updateData['LN'] = $ln;
    }
    if(!empty($mobileNumber)){
      $updateData['MOBILE_NUMBER'] = $mobileNumber;
    }
    $updateData['IS_LECTURER'] = (empty($isLecturer))? 0:1;

    $this->teacherModel->update($id, $updateData);
    // {end}
    $data = [
      'updateData' => $updateData,
    ];
    $response = [
      "message" => "Success",
      "data" => $data,
    ];

    $this->session->setFlashData("update",$response);
    return $this->setResponseFormat('json')->respond($response, 200);
  }

  public function editPassword(){
    header("Content-type:application/json");
    // do something here
    $id = $this->request->getPost("id");
    $old = $this->request->getPost("oldPassword");
    $new = $this->request->getPost("newPassword");
    $re = $this->request->getPost("confirmPassword");

    $teacherData = $this->teacherModel->find($id);

    if(!password_verify($old, $teacherData['PASSWORD'])){
      $response = [
        "message" => "WRONG PASSWORD",
        "data" => null,
      ];
      $this->session->setFlashData("update1",$response);
      return $this->setResponseFormat('json')->respond($response, 200);
    }
    if(empty($new) || empty($re)){
      $response = [
        "message" => "PASSWORD MUST NOT BE EMPTY",
        "data" => null,
      ];
      $this->session->setFlashData("update1",$response);
      return $this->setResponseFormat('json')->respond($response, 200);
    }
    if(strcmp($new, $re) != 0){
      $response = [
        "message" => "NEW AND CONFIRM PASSWORD DID NOT MATCH",
        "data" => null,
      ];
      $this->session->setFlashData("update1",$response);
      return $this->setResponseFormat('json')->respond($response, 200);
    }

    $hash_password = password_hash($new, PASSWORD_DEFAULT);
    $update = [
      'PASSWORD' => $hash_password,
    ];

    $this->teacherModel->update($id, $update);
    // {end}
    $data = [];
    $response = [
      "message" => "OK",
      "data" => $data,
    ];
    $this->session->setFlashData("update1",$response);
    return $this->setResponseFormat('json')->respond($response, 200);
  }

  public function addSubject(){
    header("Content-type:application/json");
    // do something here
    $id = $this->request->getPost("id");
    $subjects = $this->request->getPost("subjects[]");

    $currSY = $this->schoolyearModel->orderBy("ID","DESC")->first();

    // delete current all subjects
    $this->teacherSubjectModel
    ->where("TEACHER_ID", $id)
    ->where("SCHOOL_YEAR_ID", $currSY['ID'])
    ->delete();

    foreach ($subjects as $key => $subjectId) {
      $isExist = $this->teacherSubjectModel
      ->where("TEACHER_ID", $id)
      ->where("SUBJECT_ID", $subjectId)
      ->where("SCHOOL_YEAR_ID", $currSY['ID'])
      ->findAll();

      if(empty($isExist)){
        $add = [
          'TEACHER_ID' => $id,
          'SUBJECT_ID' => $subjectId,
          'SCHOOL_YEAR_ID' => $currSY['ID'],
        ];

        $this->teacherSubjectModel->insert($add);
      }
    }
    // {end}
    $data = [
      'id' => $id,
      'subject' => $subjects,
    ];
    $response = [
      "message" => "Done",
      "data" => $data,
    ];

    $this->session->setFlashData("update2",$response);
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
