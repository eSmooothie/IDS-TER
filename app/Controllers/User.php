<?php

namespace App\Controllers;

use App\Libraries\ComputeRating;
use App\Libraries\UserDButil;
class User extends BaseController{

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
      $teacher = $this->teacher_model->find($id);

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
      $student = $this->student_model->find($id);

      // err if no record found
      if(empty($student)){
        $this->session->setFlashdata('sys_response_msg', 'Invalid ID or Password.');
        return redirect()->to("/");
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
      'personal_data' => $teacher_data['data'],
      'subject_teaches' => $teacher_data['subject_teaches'],
      'department' => $teacher_data['department_data'],
      'school_year' => $current_school_year,
      'peers' => $teacher_data['to_rate_as_peer'],
      'done_evaluated_counter' => $done_evaluated_counter,
      'num_teachers_to_rate' => $needed_to_rate,
      'is_supervisor' => $teacher_data['is_supervisor'],
      'is_chairperson' => $teacher_data['is_chairperson'],
      'is_principal' => $teacher_data['is_principal'],
		];

    $data = $this->map_page_parameters("TEACHER | DASHBOARD", $args);

    echo view("teacher/layout/header", $data);
		echo view("teacher/index.php", $data);
		echo view("teacher/layout/footer");
  }

  public function teacher_supervisor_page(){
    if(!$this->session->has("user_id")){
      return redirect()->to("/");
    }
    // do something here
    // get data
    $user_db_util = new UserDButil();

    $id = $this->session->get("user_id");
    $teacher_data = $user_db_util->get_teacher_info($id);
    $current_school_year = $user_db_util->get_current_school_year();
    $done_evaluated_counter = $user_db_util->get_total_done_evaluated($teacher_data['evaluator_id'], $current_school_year['ID']);
    $needed_to_rate = $user_db_util->get_teacher_needed_to_evaluate($id, $teacher_data['department_data']['ID'], $current_school_year['ID']);

    $teachers_to_rate = [];

		$pageTitle = "ADMIN | TEACHER";
		$args = [
      'is_cleared' => $teacher_data['is_cleared'],
      'personal_data' => $teacher_data['data'],
      'subject_teaches' => $teacher_data['subject_teaches'],
      'department' => $teacher_data['department_data'],
      'school_year' => $current_school_year,
      'to_rate' => $teacher_data['to_rate_as_supervisor'],
      'done_evaluated_counter' => $done_evaluated_counter,
      'num_teachers_to_rate' => $needed_to_rate,
      'is_supervisor' => $teacher_data['is_supervisor'],
      'is_chairperson' => $teacher_data['is_chairperson'],
      'is_principal' => $teacher_data['is_principal'],
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
    $all_school_year = $this->schoolyear_model->orderBy("ID","DESC")->findAll(); // get all school year

		$pageTitle = "TEACHER | RATING";
		$args = [
      'is_cleared' => $this->session->get('teacher_is_cleared'),
      'personal_data' => $teacher_data['data'],
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
      $response = ['ERROR_MSG' => "No permission to access."];
      return $this->setResponseFormat('json')->respond($response, 200);
    }
    $teacher_id = $this->session->get("user_id");

    // rating 
    $compute_rating = new ComputeRating();

    $student_rating = $compute_rating->get_student_rating($teacher_id, $school_year_id);
    $peer_rating = $compute_rating->get_peer_rating($teacher_id, $school_year_id);
    $supervisor_rating = $compute_rating->get_supervisor_rating($teacher_id, $school_year_id);

    $overall_rating = $compute_rating->get_overall_rating($student_rating["OVERALL"], $peer_rating["OVERALL"], $supervisor_rating["OVERALL"]);

    $school_year_info = $this->schoolyear_model->find($school_year_id);

    $response = [
      'teacher_id' => $teacher_id,
      'school_year' => $school_year_info,
      'student_rating' => $student_rating,
      'peer_rating' => $peer_rating,
      'supervisor_rating' => $supervisor_rating,
      'overall' => $overall_rating,
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

    $my_comments = $this->eval_info_model->select("
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
    $all_school_year = $this->schoolyear_model->orderBy("ID","DESC")->findAll(); // get all school year


		$pageTitle = "TEACHER | RATING";
		$args = [
      'is_cleared' => $this->session->get('teacher_is_cleared'),
      'personal_data' => $teacher_data['data'],
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

  public function teacher_analytics_download_page(){
    if(!$this->session->has("user_id")){
      return redirect()->to("/");
    }
    $user_db_util = new UserDButil();
    $id = $this->session->get("user_id"); // get session
    $teacher_data = $user_db_util->get_teacher_info($id);
    $all_school_year = $this->schoolyear_model->orderBy("ID","DESC")->findAll(); // get all school year

		$page_title = "TEACHER | DOWNLOADS";
		$args = [
      'is_cleared' => $this->session->get('teacher_is_cleared'),
      'personal_data' => $teacher_data['data'],
      'department' => $teacher_data['department_data'],
      'all_school_year' => $all_school_year,
		];

		$data = $this->map_page_parameters(
			$page_title,
			$args
		);

    echo view("teacher/layout/header", $data);
    echo view("teacher/pages/analyticsDownload", $data);
    echo view("teacher/layout/footer");
  }

  public function teacher_setting_page(){
    if(!$this->session->has("user_id")){
      return redirect()->to("/");
    }
    
    $user_db_util = new UserDButil();

    // get data
    $id = $this->session->get("user_id");
    $teacher_info = $user_db_util->get_teacher_info($id);

    $teacher_data = $teacher_info['data'];
    $department_data = $teacher_info['department_data'];

    $is_cleared = $this->session->get('teacher_is_cleared');

    $current_school_year = $user_db_util->get_current_school_year();

		$pageTitle = "ADMIN | TEACHER";
		$args = [
      'is_cleared' => $is_cleared,
      'personal_data' => $teacher_data,
      'department_data' => $department_data,
      'current_school_year' => $current_school_year,
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

    $teacher = $this->teacher_model->find($id);
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

    $this->teacher_model->update($id, $changePass);
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

    $student = $this->student_model->find($id);
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

    $this->student_model->update($id, $changePass);
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
