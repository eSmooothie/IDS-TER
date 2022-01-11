<?php

namespace App\Controllers;

class Evaluation extends BaseController{
  public function peer($evaluated = false){
    if(!$this->session->has("userID")){
      return redirect()->to("/");
    }

    if(!$evaluated){
      return redirect()->to("/");
    }
    // do something here
    $id = $this->session->get("userID");
    $evaluator = $this->evaluatorModel
    ->where("TEACHER_ID", $id)
    ->first();

    if(empty($evaluator)){
      $create = [
        'TEACHER_ID' => $id,
      ];
      $this->evaluatorModel->insert($create);
      $evaluator_id = $this->evaluatorModel->insertID;
    }else{
      $evaluator_id = $evaluator['ID'];
    }

    // check if done rated
    $sy = $this->schoolyearModel->orderBy("ID","DESC")->first();

    $isExist = $this->evalInfoModel
    ->where("EVALUATOR_ID", $evaluator_id)
    ->where("EVALUATED_ID", $evaluated)
    ->where("SCHOOL_YEAR_ID", $sy['ID'])
    ->where("EVAL_TYPE_ID", 2)
    ->countAllResults();

    $questions = $this->evalQuestionModel
    ->where("EVAL_TYPE_ID", 2)
    ->where("IS_REMOVE", 0)
    ->orderBy("ID","ASC")
    ->findAll();

    $teacher = $this->teacherModel->find($evaluated);

    $data = [
			'id' => $this->session->get("userID"),
			'pageTitle' => "EVALUATE | PEER",
			'baseUrl' => base_url(),
      // add some variables here
      'evaluator_id' => $evaluator_id,
      'evaluated' => $teacher,
      'isDone' => ($isExist > 0)? true: false,
      'questions' => $questions,
		];
    echo view("evaluation/layout/header", $data);
    echo view("evaluation/peer", $data);
		echo view("evaluation/layout/footer");
  }

  public function student($evaluated = false, $subject = false){
    if(!$this->session->has("userID")){
      return redirect()->to("/");
    }

    if(!$evaluated || !$subject){
      return redirect()->to("/");
    }
    // do something here
    $id = $this->session->get("userID");
    $evaluator = $this->evaluatorModel
    ->where("STUDENT_ID", $id)
    ->first();

    if(empty($evaluator)){
      $create = [
        'STUDENT_ID' => $id,
      ];
      $this->evaluatorModel->insert($create);
      $evaluator_id = $this->evaluatorModel->insertID;
    }else{
      $evaluator_id = $evaluator['ID'];
    }

    // check if done rated
    $sy = $this->schoolyearModel->orderBy("ID","DESC")->first();


    $isExist = $this->evalInfoModel
    ->where("EVALUATOR_ID", $evaluator_id)
    ->where("EVALUATED_ID", $evaluated)
    ->where("SUBJECT_ID", $subject)
    ->where("SCHOOL_YEAR_ID", $sy['ID'])
    ->where("EVAL_TYPE_ID", 1)
    ->countAllResults();

    $questions = $this->evalQuestionModel
    ->where("EVAL_TYPE_ID", 1)
    ->where("IS_REMOVE", 0)
    ->orderBy("ID","ASC")
    ->findAll();

    $teacher = $this->teacherModel->find($evaluated);

    $data = [
      'id' => $this->session->get("userID"),
      'pageTitle' => "EVALUATE | STUDENT",
      'baseUrl' => base_url(),
      // add some variables here
      'evaluator_id' => $evaluator_id,
      'subject_id' => $subject,
      'evaluated' => $teacher,
      'isDone' => ($isExist > 0)? true: false,
      'questions' => $questions,
    ];
    echo view("evaluation/layout/header", $data);
    echo view("evaluation/student", $data);
    echo view("evaluation/layout/footer");
  }

  public function supervisor($evaluated = false){
    if(!$this->session->has("userID")){
      return redirect()->to("/");
    }

    if(!$evaluated){
      return redirect()->to("/");
    }
    // do something here
    $id = $this->session->get("userID");
    $evaluator = $this->evaluatorModel
    ->where("TEACHER_ID", $id)
    ->first();

    if(empty($evaluator)){
      $create = [
        'TEACHER_ID' => $id,
      ];
      $this->evaluatorModel->insert($create);
      $evaluator_id = $this->evaluatorModel->insertID;
    }else{
      $evaluator_id = $evaluator['ID'];
    }

    // check if done rated
    $sy = $this->schoolyearModel->orderBy("ID","DESC")->first();

    $isExist = $this->evalInfoModel
    ->where("EVALUATOR_ID", $evaluator_id)
    ->where("EVALUATED_ID", $evaluated)
    ->where("SCHOOL_YEAR_ID", $sy['ID'])
    ->where("EVAL_TYPE_ID", 3)
    ->countAllResults();

    $questions = $this->evalQuestionModel
    ->where("EVAL_TYPE_ID", 3)
    ->where("IS_REMOVE", 0)
    ->orderBy("ID","ASC")
    ->findAll();

    $teacher = $this->teacherModel->find($evaluated);

    $data = [
			'id' => $this->session->get("userID"),
			'pageTitle' => "EVALUATE | SUPERVISOR",
			'baseUrl' => base_url(),
      // add some variables here
      'evaluator_id' => $evaluator_id,
      'evaluated' => $teacher,
      'isDone' => ($isExist > 0)? true: false,
      'questions' => $questions,
		];
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
    $sy = $this->schoolyearModel->orderBy("ID","DESC")->first();

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

    $this->evalInfoModel->insert($eval_info);
    $eval_info_id =  $this->evalInfoModel->insertID;

    // get the rating
    $ratings = [];
    $questions = $this->evalQuestionModel
    ->where("EVAL_TYPE_ID", $eval_type_id)
    ->findAll();

    foreach ($questions as $key => $value) {
      $qid = $value['ID'];

      $r = $this->request->getPost($qid);

      $rate = [
        'EVAL_QUESTION_ID' => $qid,
        'RATING' => $r,
        'EVAL_INFO_ID' => $eval_info_id,
      ];

      $this->ratingModel->insert($rate);

      array_push($ratings, $rate);
    }

    // {end}
    $data = [
      'evaluator' => $evaluator_id,
      'evaluated' => $evaluated_id,
      'eval_type' => $eval_type_id,
      'rating' => $ratings,
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
