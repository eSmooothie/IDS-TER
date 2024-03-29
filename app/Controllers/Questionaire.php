<?php

namespace App\Controllers;

class Questionaire extends BaseController
{
	public function index(){
		if(!$this->session->has("adminID")){
			return redirect()->to("/admin");
		}

		
		$pageTitle = "ADMIN | STUDENT";
		$args = [
			
		];

		$data = $this->map_page_parameters(
			$pageTitle,
			$args
		);

		echo view("admin/layout/header", $data);

		echo view("admin/pages/questionaire", $data);
		echo view("admin/layout/footer");
	}

	public function viewQuestionaire($id){
		if(!$this->session->has("adminID")){
			return redirect()->to("/admin");
		}

		$asType = ["STUDENT","PEER","SUPERVISOR"];
		$type = $this->eval_type_model->find($id);
		$questionaire = $this->eval_question_model
		->where("EVAL_TYPE_ID", $type['ID'])
		->where("IS_REMOVE", 0)
		->orderBy("ID","ASC")
		->findAll();

		
		$pageTitle = "ADMIN | STUDENT";
		$args = [
			'id' => $id,
			'type' => $asType[$id - 1],
			'questions' => $questionaire,
		];

		$data = $this->map_page_parameters(
			
			$pageTitle,
			$args
		);

		echo view("admin/layout/header", $data);

		echo view("admin/pages/viewQuestionaire", $data);
		echo view("admin/layout/footer");
	}

	public function modify($id,$questionId){
		if(!$this->session->has("adminID")){
			return redirect()->to("/admin");
		}

		
		$asType = ["STUDENT","PEER","SUPERVISOR"];
		$question = $this->eval_question_model->find($questionId);

		
		$pageTitle = "ADMIN | STUDENT";
		$args = [
			'id' => $id,
			'type' => $asType[$id - 1],
			'question' => $question,
		];

		$data = $this->map_page_parameters(
			
			$pageTitle,
			$args
		);

		echo view("admin/layout/header", $data);

		echo view("admin/pages/modifyQuestion", $data);
		echo view("admin/layout/footer");
	}

	public function edit(){
		header("Content-type:application/json");
		$qid = $this->request->getPost("id");
		$new = $this->request->getPost("question");


		$data = ["QUESTION" => $new];
		
		$this->eval_question_model->update($qid, $data);

		$response = [
			"message" => "OK",
			"data" => $data,
		];
		return $this->setResponseFormat('json')->respond($response, 200);
	}

	public function addPage($id){
		if(!$this->session->has("adminID")){
			return redirect()->to("/admin");
		}

		
		$asType = ["STUDENT","PEER","SUPERVISOR"];

		
		$pageTitle = "ADMIN | STUDENT";
		$args = [
			'id' => $id,
			'type' => $asType[$id - 1],
		];

		$data = $this->map_page_parameters(
			
			$pageTitle,
			$args
		);

		echo view("admin/layout/header", $data);

		echo view("admin/pages/addQuestion", $data);
		echo view("admin/layout/footer");
	}

	public function add(){
		header("Content-type:application/json");
		$type = $this->request->getPost("type");
		$new = $this->request->getPost("question");


		$data = ["QUESTION" => $new, "EVAL_TYPE_ID" => $type];
		
		$this->eval_question_model->insert($data);

		$response = [
			"message" => "OK",
			"data" => $data,
		];
		return $this->setResponseFormat('json')->respond($response, 200);
	}

	public function removePage($id,$questionId){
		if(!$this->session->has("adminID")){
			return redirect()->to("/admin");
		}

		
		$asType = ["STUDENT","PEER","SUPERVISOR"];
		$question = $this->eval_question_model->find($questionId);

		
		$pageTitle = "ADMIN | STUDENT";
		$args = [
			'id' => $id,
			'type' => $asType[$id - 1],
			'question' => $question,
		];

		$data = $this->map_page_parameters(
			
			$pageTitle,
			$args
		);

		echo view("admin/layout/header", $data);

		echo view("admin/pages/removeQuestion", $data);
		echo view("admin/layout/footer");
	}

	public function remove(){
		header("Content-type:application/json");
		$qid = $this->request->getPost("id");

		$data = [
			'IS_REMOVE' => 1,
		];

		$this->eval_question_model->update($qid, $data);

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
