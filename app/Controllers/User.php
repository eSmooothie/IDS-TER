<?php

namespace App\Controllers;

class User extends BaseController{
  public function index_temp(){
    if(!$this->session->has("userID")){
      return redirect()->to("/");
    }
    // do something here

    $data = [
			'id' => $this->session->get("userID"),
			'pageTitle' => "user_type | view_name",
			'baseUrl' => base_url(),
      // add some variables here
		];
    echo view("user_folder/layout/header", $data);
		echo view("user_folder/pages/view_name", $data);
		echo view("user_folder/layout/footer");
  }
  // general
  public function login(){
    header("Content-type:application/json");
    // do something here
    $as = $this->request->getPost("logInAs");
    $id = $this->request->getPost("username");
    $pass = $this->request->getPost("password");

    // check if inputted id is valid
    $pattern = "/^\d{4}(-)(\d{1,}|\d{4})$/";
    $isValid = preg_match($pattern,$id);
    if(!$isValid){
      $response = [
        "message" => "Invalid ID or Password",
        "data" => null,
      ];
      return $this->setResponseFormat('json')->respond($response, 200);
    }

    $isTeacher = false;
    if(strcmp($as,"teacher") === 0){
      $isTeacher = true;
    }

    if($isTeacher){
      // get info

      $teacher = $this->teacherModel->find($id);

      // err if no record found
      if(empty($teacher)){
        $response = [
          "message" => "Invalid ID or Password",
          "data" => null,
        ];
        return $this->setResponseFormat('json')->respond($response, 200);
      }

      $passwordMatch = password_verify($pass, $teacher['PASSWORD']);

      // err if password does not match
      if(!$passwordMatch){
        $response = [
          "message" => "Invalid ID or Password",
          "data" => null,
        ];
        return $this->setResponseFormat('json')->respond($response, 200);
      }

      $this->session->set("userID", $teacher['ID']);
    }else{
      $student = $this->studentModel->find($id);

      // err if no record found
      if(empty($student)){
        $response = [
          "message" => "Invalid ID or Password",
          "data" => null,
        ];
        return $this->setResponseFormat('json')->respond($response, 200);
      }

      $passwordMatch = (strcmp($pass, $student['PASSWORD']) === 0)? true:false;

      // err if password does not match
      if(!$passwordMatch){
        $response = [
          "message" => "Invalid ID or Password",
          "data" => null,
        ];
        return $this->setResponseFormat('json')->respond($response, 200);
      }

      $this->session->set("userID", $student['ID']);
    }
    // {end}

    $response = [
      "message" => "OK",
      "data" => $isTeacher,
    ];
    return $this->setResponseFormat('json')->respond($response, 200);
  }

  // teacher
  public function teacher(){
    if(!$this->session->has("userID")){
      return redirect()->to("/");
    }
    // do something here
    // get data
    $id = $this->session->get("userID");
    $sy = $this->schoolyearModel->orderBy("ID","DESC")->first();
    $myData = $this->teacherModel->find($id);
    $myDept = $this->departmentModel->find($myData['DEPARTMENT_ID']);
    // get subjects
    $mySubjects = $this->teacherSubjectModel
    ->select("
    `subject`.`ID` AS `ID`,
    `subject`.`DESCRIPTION` AS `NAME`,
    `school_year`.`SY` AS `SY`,
    `school_year`.`SEMESTER` AS `SEMESTER`
    ")
    ->join("`subject`","`subject`.`ID` = `tchr_subj_lst`.`SUBJECT_ID`","INNER")
    ->join("`school_year`","`school_year`.`ID` = `tchr_subj_lst`.`SCHOOL_YEAR_ID`","INNER")
    ->where("`tchr_subj_lst`.`TEACHER_ID`", $id)
    ->findAll();

    // get colleagues
    $colleagues = $this->teacherModel
    ->where("DEPARTMENT_ID", $myData['DEPARTMENT_ID'])
    ->where("ID !=", $id)
    ->where("IS_LECTURER", 0)
    ->findAll();

    $peer = [];

    $doneEvaluatedCounter = 0;

    foreach ($colleagues as $key => $colleague) {
      // check if X done rated Y
      $evaluator = $this->evaluatorModel
      ->where("TEACHER_ID", $id)
      ->first();

      if(empty($evaluator)){
        // if no evaluator id, create one
        $create_evaluator_id = [
          'TEACHER_ID' => $id,
        ];

        $this->evaluatorModel->insert($create_evaluator_id);
        $myEvaluatorId = $this->evaluatorModel->insertID;
      }else{
        $myEvaluatorId = $evaluator['ID'];
      }
      $isDone = $this->evalInfoModel
      ->where("EVALUATOR_ID", $myEvaluatorId)
      ->where("EVALUATED_ID", $colleague['ID'])
      ->where("SCHOOL_YEAR_ID", $sy['ID'])
      ->where("EVAL_TYPE_ID", 2)
      ->countAllResults();

      $d = [
        'isDone' => ($isDone > 0)? true: false,
        'teacher' => $colleague,
      ];

      $doneEvaluatedCounter = ($isDone > 0)? $doneEvaluatedCounter + 1: $doneEvaluatedCounter;

      array_push($peer, $d);
    }


    // check if a supervisor
    $isChairperson = $this->departmentHistoryModel
    ->where("SCHOOL_YEAR_ID", $sy['ID'])
    ->where("DEPARTMENT_ID", $myData['DEPARTMENT_ID'])
    ->where("TEACHER_ID", $myData['ID'])
    ->countAllResults();

    $isPrincipal = $this->execomHistoryModel
    ->where("SCHOOL_YEAR_ID", $sy['ID'])
    ->where("EXECOM_ID", 1)
    ->where("TEACHER_ID", $myData['ID'])
    ->countAllResults();

    $isSupervisor = ($isChairperson > 0 || $isPrincipal > 0)? true: false;

    $data = [
			'id' => $this->session->get("userID"),
			'pageTitle' => "TEACHER | DASHBOARD",
			'baseUrl' => base_url(),
      // add some variables here
      'myData' => $myData,
      'mySubject' => $mySubjects,
      'myDept' => $myDept,
      'sy' => $sy,
      'peer' => $peer,
      'evaluatedCounter' => $doneEvaluatedCounter,
      'isSupervisor' => $isSupervisor,
      'isChairperson' => $isChairperson ,
      'isPrincipal' => $isPrincipal ,
		];

    echo view("teacher/layout/header", $data);
		echo view("teacher/index.php", $data);
		echo view("teacher/layout/footer");
  }

  public function supervisor(){
    if(!$this->session->has("userID")){
      return redirect()->to("/");
    }
    // do something here
    // get data
    $id = $this->session->get("userID");
    $sy = $this->schoolyearModel->orderBy("ID","DESC")->first();
    $myData = $this->teacherModel->find($id);
    $myDept = $this->departmentModel->find($myData['DEPARTMENT_ID']);
    // check if a supervisor
    $isChairperson = $this->departmentHistoryModel
    ->where("SCHOOL_YEAR_ID", $sy['ID'])
    ->where("DEPARTMENT_ID", $myData['DEPARTMENT_ID'])
    ->where("TEACHER_ID", $myData['ID'])
    ->countAllResults();

    $isPrincipal = $this->execomHistoryModel
    ->where("SCHOOL_YEAR_ID", $sy['ID'])
    ->where("EXECOM_ID", 1)
    ->where("TEACHER_ID", $myData['ID'])
    ->countAllResults();

    $teachers = [];

    if($isChairperson){
      // get colleagues
      $colleagues = $this->teacherModel
      ->where("DEPARTMENT_ID", $myData['DEPARTMENT_ID'])
      ->where("ID !=", $id)
      ->where("IS_LECTURER", 0)
      ->findAll();

      foreach ($colleagues as $key => $colleague) {
        // check if done rated
        $evaluator = $this->evaluatorModel
        ->where("TEACHER_ID", $id)
        ->first();

        if(empty($evaluator)){
          // if no evaluator id, create one
          $create_evaluator_id = [
            'TEACHER_ID' => $id,
          ];

          $this->evaluatorModel->insert($create_evaluator_id);
          $myEvaluatorId = $this->evaluatorModel->insertID;
        }else{
          $myEvaluatorId = $evaluator['ID'];
        }
        $isDone = $this->evalInfoModel
        ->where("EVALUATOR_ID", $myEvaluatorId)
        ->where("EVALUATED_ID", $colleague['ID'])
        ->where("SCHOOL_YEAR_ID", $sy['ID'])
        ->where("EVAL_TYPE_ID", 3)
        ->countAllResults();

        $d = [
          'isDone' => ($isDone > 0)? true: false,
          'teacher' => $colleague,
        ];

        array_push($teachers, $d);
      }
    }else if($isPrincipal){
      // get all chairperson
      $chairpersons = $this->departmentHistoryModel
      ->where("SCHOOL_YEAR_ID", $sy['ID'])
      ->findAll();

      foreach ($chairpersons as $key => $value) {
        // check if done rated
        $evaluator = $this->evaluatorModel
        ->where("TEACHER_ID", $id)
        ->first();

        if(empty($evaluator)){
          // if no evaluator id, create one
          $create_evaluator_id = [
            'TEACHER_ID' => $id,
          ];

          $this->evaluatorModel->insert($create_evaluator_id);
          $myEvaluatorId = $this->evaluatorModel->insertID;
        }else{
          $myEvaluatorId = $evaluator['ID'];
        }
        $isDone = $this->evalInfoModel
        ->where("EVALUATOR_ID", $myEvaluatorId)
        ->where("EVALUATED_ID", $value['TEACHER_ID'])
        ->where("SCHOOL_YEAR_ID", $sy['ID'])
        ->where("EVAL_TYPE_ID", 3)
        ->countAllResults();

        $dept = $this->departmentModel->find($value['DEPARTMENT_ID']);
        $teacher = $this->teacherModel->find($value['TEACHER_ID']);
        $d = [
          'isDone' => ($isDone > 0)? true: false,
          'position' => $dept['NAME'],
          'teacher' => $teacher,
        ];

        array_push($teachers, $d);
      }

      $execom = $this->execomHistoryModel
      ->where("SCHOOL_YEAR_ID", $sy['ID'])
      ->where("EXECOM_ID !=", 1)
      ->findAll();

      foreach ($execom as $key => $value) {
        // check if done rated
        $evaluator = $this->evaluatorModel
        ->where("TEACHER_ID", $id)
        ->first();

        if(empty($evaluator)){
          // if no evaluator id, create one
          $create_evaluator_id = [
            'TEACHER_ID' => $id,
          ];

          $this->evaluatorModel->insert($create_evaluator_id);
          $myEvaluatorId = $this->evaluatorModel->insertID;
        }else{
          $myEvaluatorId = $evaluator['ID'];
        }
        $isDone = $this->evalInfoModel
        ->where("EVALUATOR_ID", $myEvaluatorId)
        ->where("EVALUATED_ID", $value['TEACHER_ID'])
        ->where("SCHOOL_YEAR_ID", $sy['ID'])
        ->where("EVAL_TYPE_ID", 3)
        ->countAllResults();

        $execom = $this->execomModel->find($value['EXECOM_ID']);
        $teacher = $this->teacherModel->find($value['TEACHER_ID']);
        $d = [
          'isDone' => ($isDone > 0)? true: false,
          'position' => $execom['NAME'],
          'teacher' => $teacher,
        ];

        array_push($teachers, $d);
      }
    }

    $isSupervisor = ($isChairperson > 0 || $isPrincipal > 0)? true: false;

    $data = [
      'id' => $this->session->get("userID"),
      'pageTitle' => "TEACHER | DASHBOARD",
      'baseUrl' => base_url(),
      // add some variables here
      'myData' => $myData,
      'myDept' => $myDept,
      'sy' => $sy,
      'teachers' => $teachers,
      'isSupervisor' => $isSupervisor,
      'isChairperson' => $isChairperson ,
      'isPrincipal' => $isPrincipal ,
    ];

    echo view("teacher/layout/header", $data);
    echo view("teacher/pages/supervisor", $data);
    echo view("teacher/layout/footer");
  }

  public function analyticsRating(){
    if(!$this->session->has("userID")){
      return redirect()->to("/");
    }
    $id = $this->session->get("userID");
    $sy = $this->schoolyearModel->orderBy("ID","DESC")->first();
    $myData = $this->teacherModel->find($id);
    $myDept = $this->departmentModel->find($myData['DEPARTMENT_ID']);
    $schoolyears = $this->schoolyearModel->orderBy("ID","DESC")->findAll();

    // rating
    $studentRating = $this->getRating($id, 1, $schoolyears[0]["ID"]);
    $peerRating = $this->getRating($id, 2, $schoolyears[0]["ID"]);
    $supervisorRating = $this->getRating($id, 3, $schoolyears[0]["ID"]);

    $totalOverall = $this->getOverallRating($studentRating["OVERALL"], $peerRating["OVERALL"], $supervisorRating["OVERALL"]);

    // equation
    // n : Question #
    // W[n] : Total rating recieve
    // T[n] : Total person rated
    // Q[n] : Average rate in `n` question
    // Q[n] = W[n] / T[n]

    // N : Total number of question
    // category_ov = sum(Q[n]) / N
    // overall = student_ov * .5 + peer_ov * .2 + super_ov * .3

    $data = [
			'id' => $this->session->get("userID"),
			'pageTitle' => "TEACHER | ANALYTICS",
			'baseUrl' => base_url(),
      // add some variables here
      'myData' => $myData,
      'myDept' => $myDept,
      'sy' => $sy,
      'schoolyears' => $schoolyears,
      'studentRating' => $studentRating,
      'peerRating' => $peerRating,
      'supervisorRating' => $supervisorRating,
      'totalOverall' => $totalOverall,
		];
    echo view("teacher/layout/header", $data);
    echo view("teacher/pages/analyticsRating", $data);
    echo view("teacher/layout/footer");
  }

  public function analyticsComment(){
    if(!$this->session->has("userID")){
      return redirect()->to("/");
    }
    $id = $this->session->get("userID");
    $sy = $this->schoolyearModel->orderBy("ID","DESC")->first();
    $myData = $this->teacherModel->find($id);
    $myDept = $this->departmentModel->find($myData['DEPARTMENT_ID']);

    $schoolyears = $this->schoolyearModel->orderBy("ID","DESC")->findAll();

    $evalinfo = $this->evalInfoModel->where("EVALUATED_ID", $id)
    ->where("SCHOOL_YEAR_ID", $sy['ID'])
    ->where("EVAL_TYPE_ID", 1)
    ->findAll();

    $comments = [];
    foreach ($evalinfo as $key => $value) {
      $comment = $value['COMMENT'];

      if(!empty($comment)){
        $data = [
          'ID' => $key,
          'COMMENT' => $comment,
        ];
        array_push($comments, $data);
      }
    }

    $data = [
      'id' => $this->session->get("userID"),
      'pageTitle' => "TEACHER | ANALYTICS",
      'baseUrl' => base_url(),
      // add some variables here
      'myData' => $myData,
      'myDept' => $myDept,
      'sy' => $sy,
      'schoolyears' => $schoolyears,
      'comments' => $comments,
    ];
    echo view("teacher/layout/header", $data);
    echo view("teacher/pages/analyticsComments", $data);
    echo view("teacher/layout/footer");
  }

  public function analyticsDownload(){
    if(!$this->session->has("userID")){
      return redirect()->to("/");
    }
    $id = $this->session->get("userID");
    $sy = $this->schoolyearModel->orderBy("ID","DESC")->findAll();
    $myData = $this->teacherModel->find($id);
    $myDept = $this->departmentModel->find($myData['DEPARTMENT_ID']);

    $data = [
      'id' => $this->session->get("userID"),
      'pageTitle' => "TEACHER | ANALYTICS",
      'baseUrl' => base_url(),
      // add some variables here
      'myData' => $myData,
      'myDept' => $myDept,
      'sy' => $sy,
    ];
    echo view("teacher/layout/header", $data);
    echo view("teacher/pages/analyticsDownload", $data);
    echo view("teacher/layout/footer");
  }

  public function teacherSetting(){
    if(!$this->session->has("userID")){
      return redirect()->to("/");
    }
    // do something here
    // get data
    $id = $this->session->get("userID");
    $sy = $this->schoolyearModel->orderBy("ID","DESC")->first();
    $myData = $this->teacherModel->find($id);
    $myDept = $this->departmentModel->find($myData['DEPARTMENT_ID']);
    // get subjects
    $mySubjects = $this->teacherSubjectModel
    ->select("
    `subject`.`ID` AS `ID`,
    `subject`.`DESCRIPTION` AS `NAME`,
    `school_year`.`SY` AS `SY`,
    `school_year`.`SEMESTER` AS `SEMESTER`
    ")
    ->join("`subject`","`subject`.`ID` = `tchr_subj_lst`.`SUBJECT_ID`","INNER")
    ->join("`school_year`","`school_year`.`ID` = `tchr_subj_lst`.`SCHOOL_YEAR_ID`","INNER")
    ->where("`tchr_subj_lst`.`TEACHER_ID`", $id)
    ->findAll();

    $data = [
      'id' => $this->session->get("userID"),
      'pageTitle' => "TEACHER | SETTINGS",
      'baseUrl' => base_url(),
      // add some variables here
      'myData' => $myData,
      'mySubject' => $mySubjects,
      'myDept' => $myDept,
      'sy' => $sy,
    ];
    echo view("teacher/layout/header", $data);
    echo view("teacher/pages/settings", $data);
    echo view("teacher/layout/footer");
  }

  public function updateTeacherPassword(){
    header("Content-type:application/json");
    // do something here
    $id = $this->session->get("userID");
    $oldPassword = $this->request->getPost("oldPass");
    $newPassword = $this->request->getPost("confirmPass");

    $teacher = $this->teacherModel->find($id);
    $currentPassword = $teacher['PASSWORD'];

    $isMatch = password_verify($oldPassword, $currentPassword);

    if(!$isMatch){
      $response = [
        "message" => "Invalid old password",
        "data" => null,
      ];

      return $this->setResponseFormat('json')->respond($response, 200);
    }


    $passwordhash = password_hash($newPassword, PASSWORD_DEFAULT);

    $changePass = [
      'PASSWORD' => $passwordhash,
    ];

    $this->teacherModel->update($id, $changePass);
    // {end}
    $data = [
      'id' => $id,
      'isMatch' => $isMatch,
    ];

    $response = [
      "message" => "Change password successfully",
      "data" => $data,
    ];

    return $this->setResponseFormat('json')->respond($response, 200);
  }

  // student
  public function student(){
    if(!$this->session->has("userID")){
      return redirect()->to("/");
    }
    // do something here
    $id = $this->session->get("userID");
    $sy = $this->schoolyearModel->orderBy("ID","DESC")->first();
    $myData = $this->studentModel->find($id);
    $currSection = $this->studentSectionModel
    ->where("STUDENT_ID", $myData['ID'])
    ->where("SCHOOL_YEAR_ID", $sy['ID'])
    ->first();

    if(!empty($currSection)){
      $mySection = $this->sectionModel->find($currSection['SECTION_ID']);
    }else{
      $mySection = null;
    }


    $evaluator = $this->evaluatorModel
    ->where("STUDENT_ID", $myData['ID'])
    ->first();

    if(empty($evaluator)){
      $_create = [
        'STUDENT_ID' => $id,
      ];
      $this->evaluatorModel->insert($_create);
      $evaluator_id = $this->evaluatorModel->insertID;
    }else{
      $evaluator_id = $evaluator['ID'];
    }

    $subjects = [];
    $isCleared = false;
    $count_isDone = 0;
    if(!empty($mySection)){
      // get subjects
      $sectionSubject = $this->sectionSubjectModel
      ->where("SECTION_ID", $mySection['ID'])
      ->where("SCHOOL_YEAR_ID", $sy['ID'])
      ->findAll();

      foreach ($sectionSubject as $key => $subject) {
        $subject_id = $subject['SUBJECT_ID'];
        $teacher_id = $subject['TEACHER_ID'];

        // check if is done rating
        $isDone = $this->evalInfoModel
        ->where("EVALUATOR_ID", $evaluator_id)
        ->where("EVALUATED_ID", $teacher_id)
        ->where("SUBJECT_ID", $subject_id)
        ->where("SCHOOL_YEAR_ID", $sy['ID'])
        ->where("EVAL_TYPE_ID", 1)
        ->countAllResults();

        if($isDone > 0){
          $count_isDone += 1;
        }

        $teacherData = $this->teacherModel->find($teacher_id);
        $subjectData = $this->subjectModel->find($subject_id);

        $add = [
          'isDone' => ($isDone > 0)? true:false,
          'teacher' => $teacherData,
          'subject' => $subjectData,
        ];

        array_push($subjects, $add);
      }

      $count_sectionSubject = $this->sectionSubjectModel
      ->where("SECTION_ID", $mySection['ID'])
      ->where("SCHOOL_YEAR_ID", $sy['ID'])
      ->countAllResults();

      $isCleared = ($count_sectionSubject == $count_isDone)? true:false;

      if($isCleared){
        $updateStatus = [
          'STATUS' => 1,
          'DATE' => $this->getCurrentDateTime(),
        ];

        $this->studentStatusModel
        ->where("SCHOOL_YEAR_ID", $sy['ID'])
        ->where("STUDENT_ID", $myData['ID'])
        ->set($updateStatus)
        ->update();
      }
    }
    $data = [
      'id' => $this->session->get("userID"),
      'pageTitle' => "STUDENT | DASHBOARD",
      'baseUrl' => base_url(),
      // add some variables here
      'myData' => $myData,
      'sy' => $sy,
      'mySection' => $mySection,
      'subjects' => $subjects,
      'isCleared' => $isCleared,
      'ttlEvaluated' => $count_isDone,
    ];
    echo view("student/layout/header", $data);
    echo view("student/index", $data);
    echo view("student/layout/footer");
  }

  public function studentSetting(){
    if(!$this->session->has("userID")){
      return redirect()->to("/");
    }
    // do something here
    $id = $this->session->get("userID");
    $sy = $this->schoolyearModel->orderBy("ID","DESC")->first();
    $myData = $this->studentModel->find($id);
    $currSection = $this->studentSectionModel
    ->where("STUDENT_ID", $myData['ID'])
    ->where("SCHOOL_YEAR_ID", $sy['ID'])
    ->first();

    if(!empty($currSection)){
      $mySection = $this->sectionModel->find($currSection['SECTION_ID']);
    }else{
      $mySection = null;
    }

    $data = [
      'id' => $this->session->get("userID"),
      'pageTitle' => "STUDENT | SETTINGS",
      'baseUrl' => base_url(),
      // add some variables here
      'myData' => $myData,
      'sy' => $sy,
      'mySection' => $mySection,
    ];
    echo view("student/layout/header", $data);
    echo view("student/pages/settings", $data);
    echo view("student/layout/footer");
  }

  public function updateStudentPassword(){
    header("Content-type:application/json");
    // do something here
    $id = $this->session->get("userID");
    $oldPassword = $this->request->getPost("oldPass");
    $newPassword = $this->request->getPost("confirmPass");

    $student = $this->studentModel->find($id);
    $currentPassword = $student['PASSWORD'];

    $isMatch = (strcmp($oldPassword, $currentPassword) === 0)? true: false;

    if(!$isMatch){
      $response = [
        "message" => "Invalid old password",
        "data" => null,
      ];

      return $this->setResponseFormat('json')->respond($response, 200);
    }


    $password = $newPassword;

    $changePass = [
      'PASSWORD' => $password,
    ];

    $this->studentModel->update($id, $changePass);
    // {end}
    $data = [
      'id' => $id,
      'isMatch' => $isMatch,
    ];

    $response = [
      "message" => "Change password successfully",
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
