<?php

namespace App\Controllers;

use App\Libraries\UserDButil;

class Evaluation extends BaseController{
  public function peer($evaluated = false){
    if(!$this->session->has("user_id")){
      return redirect()->to("/");
    }

    if(!$evaluated){
      return redirect()->to("/");
    }
    // do something here
    $id = $this->session->get("user_id");
    $evaluator = $this->evaluator_model
    ->where("TEACHER_ID", $id)
    ->first();

    if(empty($evaluator)){
      $create = [
        'TEACHER_ID' => $id,
      ];
      $this->evaluator_model->insert($create);
      $evaluator_id = $this->evaluator_model->insertID;
    }else{
      $evaluator_id = $evaluator['ID'];
    }

    // check if done rated
    $sy = $this->schoolyear_model->orderBy("ID","DESC")->first();

    $isExist = $this->eval_info_model
    ->where("EVALUATOR_ID", $evaluator_id)
    ->where("EVALUATED_ID", $evaluated)
    ->where("SCHOOL_YEAR_ID", $sy['ID'])
    ->where("EVAL_TYPE_ID", 2)
    ->countAllResults();

    $questions = $this->eval_question_model
    ->where("EVAL_TYPE_ID", 2)
    ->where("IS_REMOVE", 0)
    ->orderBy("ID","ASC")
    ->findAll();

    $teacher = $this->teacher_model->find($evaluated);

    $args = [
      'evaluator_id' => $evaluator_id,
      'evaluated' => $teacher,
      'isDone' => ($isExist > 0)? true: false,
      'questions' => $questions,
    ];

    $data = $this->map_page_parameters("EVALUATE | PEER", $args);

    echo view("evaluation/layout/header", $data);
    echo view("evaluation/peer", $data);
		echo view("evaluation/layout/footer");
  }

  public function student($evaluated_id = false, $subject_id = false){
    if(!$this->session->has("user_id")){
      return redirect()->to("/");
    }

    if(!$evaluated_id || !$subject_id){
      return redirect()->to("/");
    }
    
    $user_db_util = new UserDButil();

    $student_id = $this->session->get("user_id");
    $evaluator = $this->evaluator_model
    ->where("STUDENT_ID", $student_id)
    ->first();

    if(empty($evaluator)){
      $create = [
        'STUDENT_ID' => $student_id,
      ];
      $this->evaluator_model->insert($create);
      $evaluator_id = $this->evaluator_model->insertID;
    }else{
      $evaluator_id = $evaluator['ID'];
    }

    // check if done rated
    $curr_school_year = $this->schoolyear_model->orderBy("ID","DESC")->first();

    $is_done = $user_db_util->is_done_evaluated($evaluator_id, $evaluated_id, $curr_school_year['ID'], 1, $subject_id);

    $questions = $this->eval_question_model
    ->where("EVAL_TYPE_ID", 1)
    ->where("IS_REMOVE", 0)
    ->orderBy("ID","ASC")
    ->findAll();

    $teacher = $this->teacher_model->find($evaluated_id);

    $args = [
      'evaluator_id' => $evaluator_id,
      'subject_id' => $subject_id,
      'evaluated_data' => $teacher,
      'is_done' => $is_done,
      'questions' => $questions,
    ];

    $data = $this->map_page_parameters("EVALUATE | STUDENT", $args);

    echo view("evaluation/layout/header", $data);
    echo view("evaluation/student", $data);
    echo view("evaluation/layout/footer");
  }

  public function supervisor($evaluated = false){
    if(!$this->session->has("user_id")){
      return redirect()->to("/");
    }

    if(!$evaluated){
      return redirect()->to("/");
    }
    // do something here
    $id = $this->session->get("user_id");
    $evaluator = $this->evaluator_model
    ->where("TEACHER_ID", $id)
    ->first();

    if(empty($evaluator)){
      $create = [
        'TEACHER_ID' => $id,
      ];
      $this->evaluator_model->insert($create);
      $evaluator_id = $this->evaluator_model->insertID;
    }else{
      $evaluator_id = $evaluator['ID'];
    }

    // check if done rated
    $sy = $this->schoolyear_model->orderBy("ID","DESC")->first();

    $isExist = $this->eval_info_model
    ->where("EVALUATOR_ID", $evaluator_id)
    ->where("EVALUATED_ID", $evaluated)
    ->where("SCHOOL_YEAR_ID", $sy['ID'])
    ->where("EVAL_TYPE_ID", 3)
    ->countAllResults();

    $questions = $this->eval_question_model
    ->where("EVAL_TYPE_ID", 3)
    ->where("IS_REMOVE", 0)
    ->orderBy("ID","ASC")
    ->findAll();

    $teacher = $this->teacher_model->find($evaluated);

    $args = [
      'evaluator_id' => $evaluator_id,
      'evaluated' => $teacher,
      'isDone' => ($isExist > 0)? true: false,
      'questions' => $questions,
		];

    $data = $this->map_page_parameters("EVALUATE | SUPERVISOR", $args);

    echo view("evaluation/layout/header", $data);
    echo view("evaluation/supervisor", $data);
		echo view("evaluation/layout/footer");
  }

  public function submit(){
    header("Content-type:application/json");
    // do something here
    $evaluator_id = $this->request->getPost("evaluator_id");
    $evaluated_id = $this->request->getPost("evaluated_id");
    $eval_type_id = $this->request->getPost("eval_type");

    // create eval info
    $sy = $this->schoolyear_model->orderBy("ID","DESC")->first();

    $eval_info = [
      'EVALUATOR_ID' => $evaluator_id,
      'EVALUATED_ID' => $evaluated_id,
      'DATE_EVALUATED' => $this->getCurrentDateTime(),
      'SCHOOL_YEAR_ID' => $sy['ID'],
      'EVAL_TYPE_ID' => $eval_type_id,
    ];

    if($eval_type_id == 1){
      $subject_id = $this->request->getPost("subject");
      $eval_info['SUBJECT_ID'] = $subject_id;
      $comment = $this->request->getPost("comment");
      $eval_info['COMMENT'] = $comment;
    }

    $this->eval_info_model->insert($eval_info);
    $eval_info_id =  $this->eval_info_model->insertID;

    // get the rating
    $ratings = [];
    $questions = $this->eval_question_model
    ->where("EVAL_TYPE_ID", $eval_type_id)
    ->where("IS_REMOVE","0")
    ->findAll();

    foreach ($questions as $key => $value) {
      $qid = $value['ID'];

      $r = $this->request->getPost($qid);

      $rate = [
        'EVAL_QUESTION_ID' => $qid,
        'RATING' => $r,
        'EVAL_INFO_ID' => $eval_info_id,
      ];

      $this->rating_model->insert($rate);

      array_push($ratings, $rate);
    }

    log_message("debug","at evaluation.submit: eval_type:$eval_type_id");
    if($eval_type_id == 1){
      $this->count_student_evaluated($evaluator_id);
    }

    // {end}
    $data = [
      'evaluator' => $evaluator_id,
      'evaluated' => $evaluated_id,
      'eval_type' => $eval_type_id,
      'rating' => $ratings,
      'comment' => (isset($comment))? $comment : null,
    ];

    $response = [
      "message" => "OK",
      "data" => $data,
    ];
    return $this->setResponseFormat('json')->respond($response, 200);
  }

  private function count_student_evaluated($evaluator_id){
    $user_db_util = new UserDButil();

    $user_id = $this->session->get("user_id");

    $is_cleared = $user_db_util->is_cleared($user_id);
    
    log_message("debug","at evaluation.count_student_evaluated: user_id:$user_id is_cleared:$is_cleared");

    $curr_school_year = $user_db_util->get_current_school_year();
    // update student status
    $update_status = [
      'STATUS' => ($is_cleared)? 1 : 0,
      'DATE' => $this->time->now()->toDateTimeString()
    ];
  
    $this->student_status_model
      ->where("SCHOOL_YEAR_ID", $curr_school_year['ID'])
      ->where("STUDENT_ID", $user_id)
      ->set($update_status)
      ->update();
  }
}
