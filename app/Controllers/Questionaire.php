<?php

namespace App\Controllers;

class Questionaire extends BaseController
{
	public function index(){
		if(!$this->session->has("adminID")){
			return redirect()->to("/admin");
		}

		$sessionId = $this->session->get("adminID");
		$pageTitle = "ADMIN | STUDENT";
		$args = [
			
		];

		$data = $this->mapPageParameters(
			$sessionId,
			$pageTitle,
			$args
		);

		echo view("admin/layout/header", $data);
		echo view("admin/pages/nav",$data);
		echo view("admin/pages/questionaire", $data);
		echo view("admin/layout/footer");
	}

	public function viewQuestionaire($id){
		if(!$this->session->has("adminID")){
			return redirect()->to("/admin");
		}

		$asType = ["STUDENT","PEER","SUPERVISOR"];
		$type = $this->evalTypeModel->find($id);
		$questionaire = $this->evalQuestionModel
		->where("EVAL_TYPE_ID", $type['ID'])
		->where("IS_REMOVE", 0)
		->orderBy("ID","ASC")
		->findAll();

		$sessionId = $this->session->get("adminID");
		$pageTitle = "ADMIN | STUDENT";
		$args = [
			'id' => $id,
			'type' => $asType[$id - 1],
			'questions' => $questionaire,
		];

		$data = $this->mapPageParameters(
			$sessionId,
			$pageTitle,
			$args
		);

		echo view("admin/layout/header", $data);
		echo view("admin/pages/nav",$data);
		echo view("admin/pages/viewQuestionaire", $data);
		echo view("admin/layout/footer");
	}

	public function modify($id,$questionId){
		if(!$this->session->has("adminID")){
			return redirect()->to("/admin");
		}

		
		$asType = ["STUDENT","PEER","SUPERVISOR"];
		$question = $this->evalQuestionModel->find($questionId);

		$sessionId = $this->session->get("adminID");
		$pageTitle = "ADMIN | STUDENT";
		$args = [
			'id' => $id,
			'type' => $asType[$id - 1],
			'question' => $question,
		];

		$data = $this->mapPageParameters(
			$sessionId,
			$pageTitle,
			$args
		);

		echo view("admin/layout/header", $data);
		echo view("admin/pages/nav",$data);
		echo view("admin/pages/modifyQuestion", $data);
		echo view("admin/layout/footer");
	}

	public function edit(){
		header("Content-type:application/json");
		$qid = $this->request->getPost("id");
		$new = $this->request->getPost("question");


		$data = ["QUESTION" => $new];
		
		$this->evalQuestionModel->update($qid, $data);

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

		$sessionId = $this->session->get("adminID");
		$pageTitle = "ADMIN | STUDENT";
		$args = [
			'id' => $id,
			'type' => $asType[$id - 1],
		];

		$data = $this->mapPageParameters(
			$sessionId,
			$pageTitle,
			$args
		);

		echo view("admin/layout/header", $data);
		echo view("admin/pages/nav",$data);
		echo view("admin/pages/addQuestion", $data);
		echo view("admin/layout/footer");
	}

	public function add(){
		header("Content-type:application/json");
		$type = $this->request->getPost("type");
		$new = $this->request->getPost("question");


		$data = ["QUESTION" => $new, "EVAL_TYPE_ID" => $type];
		
		$this->evalQuestionModel->insert($data);

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
		$question = $this->evalQuestionModel->find($questionId);

		$sessionId = $this->session->get("adminID");
		$pageTitle = "ADMIN | STUDENT";
		$args = [
			'id' => $id,
			'type' => $asType[$id - 1],
			'question' => $question,
		];

		$data = $this->mapPageParameters(
			$sessionId,
			$pageTitle,
			$args
		);

		echo view("admin/layout/header", $data);
		echo view("admin/pages/nav",$data);
		echo view("admin/pages/removeQuestion", $data);
		echo view("admin/layout/footer");
	}

	public function remove(){
		header("Content-type:application/json");
		$qid = $this->request->getPost("id");

		$data = [
			'IS_REMOVE' => 1,
		];

		$this->evalQuestionModel->update($qid, $data);

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
