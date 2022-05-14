<?php

namespace App\Controllers;

use App\Libraries\UserDButil;
class User extends BaseController{

  public function index_temp(){
    if(!$this->session->has("user_id")){
      return redirect()->to("/");
    }

    $data = [
			'id' => $this->session->get("user_id"),
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
    $as = $this->request->getPost("logInAs");
    $id = $this->request->getPost("username");
    $pass = $this->request->getPost("password");

    // check if inputted id is valid
    $pattern = "/^\d{4}(-)(\d{1,}|\d{4})$/";
    $isValid = preg_match($pattern,$id);
    if(!$isValid){
      $this->session->setFlashdata('sys_response_msg', 'Invalid ID or Password.');
      return redirect()->to("/");
    }

    $isTeacher = false;
    if(strcmp($as, "teacher") === 0){
      $isTeacher = true;
    }

    if($isTeacher){
      // get info
      $teacher = $this->teacherModel->find($id);

      // err if no record found
      if(empty($teacher)){
        $this->session->setFlashdata('sys_response_msg', 'Invalid ID or Password.');
        return redirect()->to("/");
      }

      $passwordMatch = password_verify($pass, $teacher['PASSWORD']);

      // err if password does not match
      if(!$passwordMatch){
        $this->session->setFlashdata('sys_response_msg', 'Invalid ID or Password.');
        return redirect()->to("/");
      }

      $this->session->set("user_id", $teacher['ID']);

      // check if teacher is already cleared.


      return redirect()->to("/user/teacher");
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
        $this->session->setFlashdata('sys_response_msg', 'Invalid ID or Password.');
        return redirect()->to("/");
      }

      $this->session->set("user_id", $student['ID']);
      return redirect()->to("/user/student");
    }
    // {end}
    return redirect()->to("/");
  }

  // teacher
  public function teacher_page(){
    if(!$this->session->has("user_id")){
      return redirect()->to("/");
    }

    $user_db_util = new UserDButil();

    // get data
    $id = $this->session->get("user_id");
    $current_school_year = $user_db_util->get_current_school_year();
    $teacher_data = $user_db_util->get_teacher_info($id);

    $done_evaluated_counter = $user_db_util->get_total_done_evaluated($teacher_data['evaluator_id'], $current_school_year['ID']);
    $needed_to_rate = $user_db_util->get_teacher_needed_to_evaluate($id, $teacher_data['department_data']['ID'], $current_school_year['ID']);
    $this->session->set('teacher_is_cleared', $teacher_data['is_cleared']);

    $args = [
      'is_cleared' => $teacher_data['is_cleared'],
      'personal_data' => $teacher_data['teacher_data'],
      'subject_teaches' => $teacher_data['subject_teaches'],
      'department' => $teacher_data['department_data'],
      'school_year' => $current_school_year,
      'colleagues' => $teacher_data['colleagues'],
      'done_evaluated_counter' => $done_evaluated_counter,
      'teachers_to_rate' => $needed_to_rate,
      'is_supervisor' => $teacher_data['is_supervisor'],
      'is_chairperson' => $teacher_data['is_chairperson'],
      'is_principal' => $teacher_data['is_principal'],
		];

    $data = $this->map_page_parameters("TEACHER | DASHBOARD", $args);

    echo view("teacher/layout/header", $data);
		echo view("teacher/index.php", $data);
		echo view("teacher/layout/footer");
  }

  public function supervisor(){
    if(!$this->session->has("user_id")){
      return redirect()->to("/");
    }
    // do something here
    // get data
    $id = $this->session->get("user_id");
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

    $evaluatedCounter = 0;

    if($isChairperson){
      // get colleagues
      $colleagues = $this->teacherModel
      ->where("DEPARTMENT_ID", $myData['DEPARTMENT_ID'])
      ->where("ID !=", $id)
      ->where("ON_LEAVE", 0)
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

        $evaluatedCounter = ($isDone > 0)? $evaluatedCounter + 1:$evaluatedCounter;

        $d = [
          'isDone' => ($isDone > 0)? true: false,
          'teacher' => $colleague,
        ];

        array_push($teachers, $d);
      }

    }
    else if($isPrincipal){
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

        $evaluatedCounter = ($isDone > 0)? $evaluatedCounter + 1:$evaluatedCounter;

        $d = [
          'isDone' => ($isDone > 0)? true: false,
          'position' => $dept['NAME'],
          'teacher' => $teacher,
        ];

        array_push($teachers, $d);
      }

      // get all execom
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

        $evaluatedCounter = ($isDone > 0)? $evaluatedCounter + 1:$evaluatedCounter;

        $d = [
          'isDone' => ($isDone > 0)? true: false,
          'position' => $execom['NAME'],
          'teacher' => $teacher,
        ];

        array_push($teachers, $d);
      }
    }

    $isSupervisor = ($isChairperson > 0 || $isPrincipal > 0)? true: false;

    $doneEvaluatedCounter = $this->evalInfoModel->where("EVALUATOR_ID", $myEvaluatorId)
    ->where("SCHOOL_YEAR_ID", $sy['ID'])
    ->countAllResults();


    $totalPeers = $this->teacherModel
    ->where("DEPARTMENT_ID", $myData['DEPARTMENT_ID'])
    ->where("ID !=", $id)
    ->where("ON_LEAVE", 0)
    ->countAllResults();

    $TeacherstoRate = $totalPeers;
    if($isPrincipal){
      $totalChairpersons = $this->departmentHistoryModel
      ->where("SCHOOL_YEAR_ID", $sy['ID'])
      ->countAllResults();

      $totalExecoms = $this->execomHistoryModel
      ->where("SCHOOL_YEAR_ID", $sy['ID'])
      ->where("EXECOM_ID !=", 1)
      ->countAllResults();

      $TeacherstoRate = $TeacherstoRate + $totalChairpersons + $totalExecoms;
    }
    else if($isChairperson){
      $colleagues = $this->teacherModel
      ->where("DEPARTMENT_ID", $myData['DEPARTMENT_ID'])
      ->where("ID !=", $id)
      ->where("ON_LEAVE", 0)
      ->countAllResults();

      $TeacherstoRate = $TeacherstoRate + $colleagues;
    }

		$pageTitle = "ADMIN | TEACHER";
		$args = [
      'isCleared' => $doneEvaluatedCounter == $TeacherstoRate,
      'myData' => $myData,
      'myDept' => $myDept,
      'sy' => $sy,
      'teachers' => $teachers,
      'evaluatedCounter' => $evaluatedCounter,
      'isSupervisor' => $isSupervisor,
      'isChairperson' => $isChairperson ,
      'isPrincipal' => $isPrincipal ,
		];

		$data = $this->map_page_parameters(
			$pageTitle,
			$args
		);

    echo view("teacher/layout/header", $data);
    echo view("teacher/pages/supervisor", $data);
    echo view("teacher/layout/footer");
  }

  public function teacher_analytics_rating_page(){
    // check if session exist
    if(!$this->session->has("user_id")){
      return redirect()->to("/");
    }

    $user_db_util = new UserDButil();

    $id = $this->session->get("user_id"); // get session
    $teacher_data = $user_db_util->get_teacher_info($id);
    $all_school_year = $this->schoolyearModel->orderBy("ID","DESC")->findAll(); // get all school year

		$pageTitle = "TEACHER | RATING";
		$args = [
      'is_cleared' => $this->session->get('teacher_is_cleared'),
      'personal_data' => $teacher_data['teacher_data'],
      'department' => $teacher_data['department_data'],
      'all_school_years' => $all_school_year,
		];

		$data = $this->map_page_parameters(
			$pageTitle,
			$args
		);
    
    echo view("teacher/layout/header", $data);
    echo view("teacher/pages/analyticsRating", $data);
    echo view("teacher/layout/footer");
  }

  public function get_teacher_rating(String $school_year_id){
    header("Content-type:application/json");
    $response = [];
    // check if session exist
    if(!$this->session->has("user_id")){
      $response = ['ERROR' => "No session set"];
      return $this->setResponseFormat('json')->respond($response, 200);
    }
    $teacherId = $this->session->get("user_id");

    // rating 
    $studentRating = $this->getRating($teacherId, 1, $school_year_id);
    $peerRating = $this->getRating($teacherId, 2, $school_year_id);
    $supervisorRating = $this->getRating($teacherId, 3, $school_year_id);

    $totalOverall = $this->getOverallRating($studentRating["OVERALL"], $peerRating["OVERALL"], $supervisorRating["OVERALL"]);

    $schoolyearInfo = $this->schoolyearModel->find($school_year_id);

    $response = [
      'teacher_id' => $teacherId,
      'school_year' => $schoolyearInfo,
      'student_rating' => $studentRating,
      'peer_rating' => $peerRating,
      'supervisor_rating' => $supervisorRating,
      'overall' => $totalOverall,
    ];

    return $this->setResponseFormat('json')->respond($response, 200);
  }

  public function get_teacher_feedbacks(String $school_year_id){
    header("Content-type:application/json");
    $response = [];
    // check if session exist
    if(!$this->session->has("user_id")){
      $response = ['ERROR' => "No session set"];
      return $this->setResponseFormat('json')->respond($response, 200);
    }
    $teacherId = $this->session->get("user_id");

    $my_comments = $this->evalInfoModel->select("
      `COMMENT`
    ")->where("`EVALUATED_ID`", $teacherId)
    ->where("`COMMENT` IS NOT NULL")
    ->where("`COMMENT` <> ''")
    ->where("`COMMENT` <> ' \\r\\n'")
    ->where("`SCHOOL_YEAR_ID`", $school_year_id)
    ->orderBy("ID","DESC")
    ->findAll();

    $response = [
      'teacher_id' => $teacherId,
      'comments' => $my_comments,
    ];

    return $this->setResponseFormat('json')->respond($response, 200);
  }

  public function teacher_analytics_comment_page(){
    if(!$this->session->has("user_id")){
      return redirect()->to("/");
    }

    $user_db_util = new UserDButil();
    $id = $this->session->get("user_id"); // get session
    $teacher_data = $user_db_util->get_teacher_info($id);
    $all_school_year = $this->schoolyearModel->orderBy("ID","DESC")->findAll(); // get all school year


		$pageTitle = "TEACHER | RATING";
		$args = [
      'is_cleared' => $this->session->get('teacher_is_cleared'),
      'personal_data' => $teacher_data['teacher_data'],
      'department' => $teacher_data['department_data'],
      'all_school_years' => $all_school_year,
		];

		$data = $this->map_page_parameters(
			$pageTitle,
			$args
		);

    echo view("teacher/layout/header", $data);
    echo view("teacher/pages/analyticsComments", $data);
    echo view("teacher/layout/footer");
  }

  public function analyticsDownload(){
    if(!$this->session->has("user_id")){
      return redirect()->to("/");
    }
    $id = $this->session->get("user_id");
    $sy = $this->schoolyearModel->orderBy("ID","DESC")->findAll();
    $myData = $this->teacherModel->find($id);
    $myDept = $this->departmentModel->find($myData['DEPARTMENT_ID']);

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

    // check if a supervisor
    $isChairperson = $this->departmentHistoryModel
    ->where("SCHOOL_YEAR_ID", $sy[0]['ID'])
    ->where("DEPARTMENT_ID", $myData['DEPARTMENT_ID'])
    ->where("TEACHER_ID", $myData['ID'])
    ->countAllResults();

    $isPrincipal = $this->execomHistoryModel
    ->where("SCHOOL_YEAR_ID", $sy[0]['ID'])
    ->where("EXECOM_ID", 1)
    ->where("TEACHER_ID", $myData['ID'])
    ->countAllResults();

    $doneEvaluatedCounter = $this->evalInfoModel->where("EVALUATOR_ID", $myEvaluatorId)
    ->where("SCHOOL_YEAR_ID", $sy[0]['ID'])
    ->countAllResults();


    $totalPeers = $this->teacherModel
    ->where("DEPARTMENT_ID", $myData['DEPARTMENT_ID'])
    ->where("ID !=", $id)
    ->where("ON_LEAVE", 0)
    ->countAllResults();

    $TeacherstoRate = $totalPeers;
    if($isPrincipal){
      $totalChairpersons = $this->departmentHistoryModel
      ->where("SCHOOL_YEAR_ID", $sy[0]['ID'])
      ->countAllResults();

      $totalExecoms = $this->execomHistoryModel
      ->where("SCHOOL_YEAR_ID", $sy[0]['ID'])
      ->where("EXECOM_ID !=", 1)
      ->countAllResults();

      $TeacherstoRate = $TeacherstoRate + $totalChairpersons + $totalExecoms;
    }
    else if($isChairperson){
      $colleagues = $this->teacherModel
      ->where("DEPARTMENT_ID", $myData['DEPARTMENT_ID'])
      ->where("ID !=", $id)
      ->where("ON_LEAVE", 0)
      ->countAllResults();

      $TeacherstoRate = $TeacherstoRate + $colleagues;
    }

		$page_title = "TEACHER | DOWNLOADS";
		$args = [
      'isCleared' => $doneEvaluatedCounter == $TeacherstoRate,
      'myData' => $myData,
      'myDept' => $myDept,
      'sy' => $sy,
		];

		$data = $this->map_page_parameters(
			$page_title,
			$args
		);

    echo view("teacher/layout/header", $data);
    echo view("teacher/pages/analyticsDownload", $data);
    echo view("teacher/layout/footer");
  }

  public function teacherSetting(){
    if(!$this->session->has("user_id")){
      return redirect()->to("/");
    }
    // do something here
    // get data
    $id = $this->session->get("user_id");
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

    $doneEvaluatedCounter = $this->evalInfoModel->where("EVALUATOR_ID", $myEvaluatorId)
    ->where("SCHOOL_YEAR_ID", $sy['ID'])
    ->countAllResults();


    $totalPeers = $this->teacherModel
    ->where("DEPARTMENT_ID", $myData['DEPARTMENT_ID'])
    ->where("ID !=", $id)
    ->where("ON_LEAVE", 0)
    ->countAllResults();

    $TeacherstoRate = $totalPeers;
    if($isPrincipal){
      $totalChairpersons = $this->departmentHistoryModel
      ->where("SCHOOL_YEAR_ID", $sy['ID'])
      ->countAllResults();

      $totalExecoms = $this->execomHistoryModel
      ->where("SCHOOL_YEAR_ID", $sy['ID'])
      ->where("EXECOM_ID !=", 1)
      ->countAllResults();

      $TeacherstoRate = $TeacherstoRate + $totalChairpersons + $totalExecoms;
    }
    else if($isChairperson){
      $colleagues = $this->teacherModel
      ->where("DEPARTMENT_ID", $myData['DEPARTMENT_ID'])
      ->where("ID !=", $id)
      ->where("ON_LEAVE", 0)
      ->countAllResults();

      $TeacherstoRate = $TeacherstoRate + $colleagues;
    }

		$pageTitle = "ADMIN | TEACHER";
		$args = [
      'isCleared' => $doneEvaluatedCounter == $TeacherstoRate,
      'myData' => $myData,
      'myDept' => $myDept,
      'sy' => $sy,
		];

		$data = $this->map_page_parameters(
			$pageTitle,
			$args
		);

    echo view("teacher/layout/header", $data);
    echo view("teacher/pages/settings", $data);
    echo view("teacher/layout/footer");
  }

  public function updateTeacherPassword(){
    header("Content-type:application/json");
    // do something here
    $id = $this->session->get("user_id");
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
  public function student_page(){
    // check if their is a session
    if(!$this->session->has("user_id")){
      return redirect()->to("/");
    }

    $user_db_util = new UserDButil();

    // get user information
    $student_data = $user_db_util->get_student_info($this->session->get("user_id"));

    $args = [
      'student_data' => $student_data['personal_data'],
      'school_year' => $student_data['school_year'],
      'student_section' => $student_data['section'],
      'student_subjects' => $student_data['subjects'],
      'student_status' => $student_data['status'],
      'done_evaluated_counter' => $student_data['total_evaluated'],
    ];

    $data = $this->map_page_parameters("STUDENT | DASHBOARD", $args);

    echo view("student/layout/header", $data);
    echo view("student/index", $data);
    echo view("student/layout/footer");
  }

  public function student_settings_page(){
    if(!$this->session->has("user_id")){
      return redirect()->to("/");
    }

    $user_db_util = new UserDButil();

    // get user information
    $student_data = $user_db_util->get_student_info($this->session->get("user_id"));

    $args = [
      'student_data' => $student_data['personal_data'],
      'school_year' => $student_data['school_year'],
      'student_section' => $student_data['section'],
    ];

    $data = $this->map_page_parameters("STUDENT | SETTINGS", $args);

    echo view("student/layout/header", $data);
    echo view("student/pages/settings", $data);
    echo view("student/layout/footer");
  }

  public function update_student_password(){
    header("Content-type:application/json");
    
    $id = $this->session->get("user_id");
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
}
