<?php

namespace App\Controllers;
use CodeIgniter\I18n\Time;
class Teacher extends BaseController{
  
  public function index(){
    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }
    // do something
    $teacherData = $this->teacher_model->select("
                                            `teacher`.`ID` AS `ID`,
                                            `teacher`.`LN` AS `LN`,
                                            `teacher`.`FN` AS `FN`,
                                            `teacher`.`IS_LECTURER` AS `IS_LECTURER`,
                                            `teacher`.`ON_LEAVE` AS `ON_LEAVE`,
                                            `department`.`NAME` AS `DEPARTMENT_NAME`
                                          ")
                                      ->join("`department`",
                                          "`department`.`ID` = `teacher`.`DEPARTMENT_ID`","LEFT")
                                          ->orderBy("LN","ASC")
                                          ->findAll();

    $department = $this->department_model->findAll();

		$pageTitle = "ADMIN | TEACHER";
		$args = [
      'teacher_data' => $teacherData,
      'department_data' => $department,
		];

		$data = $this->map_page_parameters(
			$pageTitle,
			$args
		);

    echo view("admin/layout/header", $data);
		echo view("admin/pages/teachers", $data);
		echo view("admin/layout/footer");
  }

  public function view_teacher_page($id = false){
    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }
    if(!$id){
      return redirect()->to("/admin/teacher/");
    }
    // do something
    $teacherData = $this->teacher_model
    ->select("
      `teacher`.`ID` AS `ID`,
      `teacher`.`FN` AS `FN`,
      `teacher`.`LN` AS `LN`,
      `teacher`.`MOBILE_NO` AS `MOBILE_NO`,
      `teacher`.`PROFILE_PICTURE` AS `PROFILE_PICTURE`,
      `teacher`.`IS_LECTURER` AS `IS_LECTURER`,
      `teacher`.`ON_LEAVE` AS `ON_LEAVE`,
      `department`.`ID` AS `DEPARTMENT_ID`,
      `department`.`NAME` AS `DEPARTMENT`")
    ->join("`department`","`department`.`ID` = `teacher`.`DEPARTMENT_ID`","LEFT")
    ->find($id);

    // get teacher subjects
    $subjectHandles = $this->teacher_subject_model->select("
      `tchr_subj_lst`.`ID` AS `ID`,
      `subject`.`DESCRIPTION` AS `SUBJECT_NAME`,
      `school_year`.`SY` AS `YEAR`,
      `school_year`.`SEMESTER` AS `SEMESTER`")
    ->join("`subject`","`tchr_subj_lst`.`SUBJECT_ID` = `subject`.`ID`","LEFT")
    ->join("`school_year`","`tchr_subj_lst`.`SCHOOL_YEAR_ID` = `school_year`.`ID`","LEFT")
    ->where("`tchr_subj_lst`.`TEACHER_ID` =", $id)
    ->orderBy("`ID`","DESC")
    ->findAll();

		$pageTitle = "ADMIN | TEACHER";
		$args = [
      'teacherData' => $teacherData,
      'subjectHandles' => $subjectHandles,
		];

		$data = $this->map_page_parameters(
			$pageTitle,
			$args
		);

    echo view("admin/layout/header", $data);
    echo view("admin/pages/viewTeacher", $data);
    echo view("admin/layout/footer");
  }

  public function edit_teacher_page($id = false){
    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }
    if(!$id){
      return redirect()->to("/admin/teacher/");
    }
    // get teacher data
    $teacherData = $this->teacher_model
    ->select("
    `teacher`.`ID` AS `ID`,
    `teacher`.`FN` AS `FN`,
    `teacher`.`LN` AS `LN`,
    `teacher`.`MOBILE_NO` AS `MOBILE_NO`,
    `teacher`.`PROFILE_PICTURE` AS `PROFILE_PICTURE`,
    `teacher`.`IS_LECTURER` AS `IS_LECTURER`,
    `teacher`.`ON_LEAVE` AS `ON_LEAVE`,
    `department`.`ID` AS `DEPARTMENT_ID`,
    `department`.`NAME` AS `DEPARTMENT`
    ")
    ->join("`department`","`department`.`ID` = `teacher`.`DEPARTMENT_ID`","LEFT")
    ->find($id);

    // get current teacher subject
    $currSY = $this->schoolyear_model->orderBy("ID","DESC")->first();
    $currentSubjects = $this->teacher_subject_model
    ->select("
    `subject`.`ID` AS `ID`,
    `subject`.`DESCRIPTION` AS `DESCRIPTION`
    ")
    ->join("`subject`","`subject`.`ID` = `tchr_subj_lst`.`SUBJECT_ID`","INNER")
    ->where("SCHOOL_YEAR_ID", $currSY['ID'])
    ->where("TEACHER_ID", $id)
    ->findAll();

    $subjectSY = null;

    if(empty($currentSubjects)){
      $schoolYear = $this->schoolyear_model->findAll();
      foreach ($schoolYear as $key => $value) {
        $sy_id = $value['ID'];
        $currentSubjects = $this->teacher_subject_model
        ->select("
        `subject`.`ID` AS `ID`,
        `subject`.`DESCRIPTION` AS `DESCRIPTION`,
        ")
        ->join("`subject`","`subject`.`ID` = `tchr_subj_lst`.`SUBJECT_ID`","INNER")
        ->where("SCHOOL_YEAR_ID", $sy_id)
        ->where("TEACHER_ID", $id)
        ->findAll();

        if(!empty($currentSubjects)){
          $subjectSY = $schoolYear[$key];
          break;
        }
      }
    }else{
      $subjectSY = $currSY;
    }
  
    // get all subject
    $subjects = $this->subject_model->findAll();

    $departments = $this->department_model->findAll();

		$pageTitle = "ADMIN | TEACHER";
		$args = [
      'teacherData' => $teacherData,
      'teacherSubjects' => $currentSubjects,
      'currSY' => $currSY,
      'currSySubject' => $subjectSY,
      'subjects' => $subjects,
      'departments' => $departments,
		];

		$data = $this->map_page_parameters(
			$pageTitle,
			$args
		);

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

  public function download_teacher_evaluation_page($id = false){
    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }
    if(!$id){
      return redirect()->to("/admin/teacher/");
    }
    // do something
    // get teacher data
    $teacherData = $this->teacher_model
    ->select("
    `teacher`.`ID` AS `ID`,
    `teacher`.`FN` AS `FN`,
    `teacher`.`LN` AS `LN`,
    `teacher`.`MOBILE_NO` AS `MOBILE_NO`,
    `teacher`.`PROFILE_PICTURE` AS `PROFILE_PICTURE`,
    `teacher`.`IS_LECTURER` AS `IS_LECTURER`,
    `teacher`.`ON_LEAVE` AS `ON_LEAVE`,
    `department`.`ID` AS `DEPARTMENT_ID`,
    `department`.`NAME` AS `DEPARTMENT`
    ")
    ->join("`department`","`department`.`ID` = `teacher`.`DEPARTMENT_ID`","LEFT")
    ->find($id);

    // get current teacher subject
    $currSY = $this->schoolyear_model->orderBy("ID","DESC")->first();
    $currentSubjects = $this->teacher_subject_model
    ->select("
    `subject`.`ID` AS `ID`,
    `subject`.`DESCRIPTION` AS `DESCRIPTION`,
    ")
    ->join("`subject`","`subject`.`ID` = `tchr_subj_lst`.`SUBJECT_ID`","INNER")
    ->where("SCHOOL_YEAR_ID", $currSY['ID'])
    ->where("TEACHER_ID", $id)
    ->findAll();

    $subjectSY = null;

    if(empty($currentSubjects)){
      $schoolYear = $this->schoolyear_model->findAll();
      foreach ($schoolYear as $key => $value) {
        $sy_id = $value['ID'];
        $currentSubjects = $this->teacher_subject_model
        ->select("
        `subject`.`ID` AS `ID`,
        `subject`.`DESCRIPTION` AS `DESCRIPTION`,
        ")
        ->join("`subject`","`subject`.`ID` = `tchr_subj_lst`.`SUBJECT_ID`","INNER")
        ->where("SCHOOL_YEAR_ID", $sy_id)
        ->where("TEACHER_ID", $id)
        ->findAll();

        if(!empty($currentSubjects)){
          $subjectSY = $schoolYear[$key];
          break;
        }
      }
    }
    // get all subject
    $subjects = $this->subject_model->findAll();

    $departments = $this->department_model->findAll();

    $sy = $this->schoolyear_model->orderBy("ID","DESC")->findAll();

		$pageTitle = "ADMIN | TEACHER";
		$args = [
      'teacherData' => $teacherData,
      'teacherSubjects' => $currentSubjects,
      'currSY' => $currSY,
      'currSySubject' => $subjectSY,
      'subjects' => $subjects,
      'departments' => $departments,
      'sy' => $sy,
		];

		$data = $this->map_page_parameters(
			$pageTitle,
			$args
		);

    echo view("admin/layout/header", $data);
    echo view("admin/pages/downloadTeacherEval", $data);
    echo view("admin/layout/footer");
  }

  public function add_teacher(){
    header("Content-type:application/json");
    // do something here
    $id = $this->request->getPost("id");
    $fn = $this->request->getPost("fn");
    $ln = $this->request->getPost("ln");
    $is_lecturer = $this->request->getPost("is_lecturer");
    $password = $this->request->getPost("password");
    $mobile_number = $this->request->getPost("mobile_number");
    $department = $this->request->getPost("department");

    // check if inputted id is valid
    $pattern = "/^\d{4}(-)(\d{1,}|\d{4})$/";
    $isValid = preg_match($pattern,$id);

    if(!$isValid){
      $response = [
        "status_code" => 400,
        "message" => "Invalid ID format",
        "data" => null,
      ];
      return $this->setResponseFormat('json')->respond($response, 200);
    }

    // check if id is already exist.
    $isExist = $this->teacher_model->find($id);
    if($isExist){
      $response = [
        "status_code" => 400,
        "message" => "ID#$id already exist.",
        "data" => null,
      ];
      return $this->setResponseFormat('json')->respond($response, 200);
    }

    // hash password
    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    $teacherData = [
      'ID' => $id,
      'FN' => $fn,
      'LN' => $ln,
      'PASSWORD' => $hash_password,
      'MOBILE_NO' => $mobile_number,
      'DEPARTMENT_ID' => $department,
      'IS_LECTURER' => $is_lecturer,
    ];

    $this->teacher_model->insert($teacherData);

     // {end}
    $data = [];
    $response = [
      "status_code" => 200,
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
    $onLeave = $this->request->getPost("onLeave");

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
    $updateData['ON_LEAVE'] = (empty($onLeave))? 0:1;
    $updateData['IS_LECTURER'] = (empty($isLecturer))? 0:1;

    $this->teacher_model->update($id, $updateData);
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

    $teacherData = $this->teacher_model->find($id);

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

    $this->teacher_model->update($id, $update);
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

    $currSY = $this->schoolyear_model->orderBy("ID","DESC")->first();

    // delete current all subjects
    $this->teacher_subject_model
    ->where("TEACHER_ID", $id)
    ->where("SCHOOL_YEAR_ID", $currSY['ID'])
    ->delete();

    foreach ($subjects as $key => $subjectId) {
      $isExist = $this->teacher_subject_model
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

        $this->teacher_subject_model->insert($add);
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

  public function editDepartment(){
    header("Content-type:application/json");
    // do something here
    $newDeptId = $this->request->getPost("updateDepartment");
    $id = $this->request->getPost("id");

    $updateData = [
      'DEPARTMENT_ID' => $newDeptId,
    ];

    $this->teacher_model->update($id, $updateData);

    // {end}
    $data = [
      "newDept" => $newDeptId,
      "id" => $id,
    ];
    $response = [
      "message" => "OK",
      "data" => $data,
    ];
    return $this->setResponseFormat('json')->respond($response, 200);
  }

  public function recentActivity($id = false){
    header("Content-type:application/json");
    if(!$id){
      $response = [
        "message" => "Error",
        "data" => "Bad Request",
      ];
      return $this->setResponseFormat('json')->respond($response, 400);
    }

    $interval = 30;

    $evaluator = $this->evaluator_model->where("TEACHER_ID", $id)->first();

    if(empty($evaluator)){
      $data = [
        'TEACHER_ID' => $id
      ];

      $this->evaluator_model->insert($data);
      $evaluator_id = $this->evaluator_model->insertID;
    }else{
      $evaluator_id = $evaluator['ID'];
    }
    $upperBound = $this->getCurrentDateTime();
    $min = new Time("-30 days");
    $lowerBound = $min->toDateTimeString();

    $where = "EVALUATOR_ID LIKE '$evaluator_id' AND DATE_EVALUATED BETWEEN '$lowerBound' AND '$upperBound'";
    $eval_info = $this->eval_info_model
    ->select("
      `eval_info`.`ID` AS `EVAL_INFO_ID`,
      `teacher`.`ID` AS `TEACHER_ID`,
      `teacher`.`FN` AS `FN`,
      `teacher`.`LN` AS `LN`,
      `eval_info`.`DATE_EVALUATED` AS `DATE_EVALUATED`
    ")
    ->join("`teacher`","`teacher`.`ID` = `eval_info`.`EVALUATED_ID`","INNER")
    ->where($where)
    ->orderBy("`EVAL_INFO_ID`","DESC")
    ->findAll();
    // {end}
    $data = [
      'id' => $id,
      'evaluator_id' => $evaluator_id,
      'activities' => $eval_info,
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
