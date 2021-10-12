<?php

namespace App\Controllers;

class Student extends BaseController
{
	public function index()
	{
		if(!$this->session->has("adminID")){
			return redirect()->to("/admin");
		}

		$data = [
			'id' => $this->session->get("adminID"),
			'pageTitle' => "ADMIN | STUDENT",
			'baseUrl' => base_url(),
		];
		
		echo view("admin/layout/header", $data);
		echo view("admin/pages/student", $data);
		echo view("admin/layout/footer");
	}
}
