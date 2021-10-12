<?php

namespace App\Controllers;

class Student extends BaseController
{
	public function index()
	{
		if(!$this->session->has("adminID")){
			return redirect()->to("/admin");
		}

		$studentData = $this->studentModel->orderBy("LN","ASC")->findAll();
		$sy = $this->schoolyearModel->orderBy("ID","DESC")->first(); // get current school year
		$students = [];

		foreach ($studentData as $key => $value) {
			$studentInfo = [
				'ID' => $value['ID'],
				'LN' => $value['LN'],
				'FN' => $value['FN'],
			];

			// get latest section
			$studentSection = $this->studentSectionModel->where("STUDENT_ID", $value['ID'])
																									->where("SCHOOL_YEAR_ID", $sy['ID'])
																									->first();

		  $section = $this->sectionModel->where("ID", $studentSection['SECTION_ID'])->first();
			$studentInfo['section'] = $section['NAME'];

			// current status
			$studentStatus = $this->studentStatusModel->where("STUDENT_ID", $value['ID'])
																								->where("SCHOOL_YEAR_ID", $sy['ID'])
																								->first();

			$studentInfo['status'] = $studentStatus['STATUS'];

			array_push($students, $studentInfo);
		}

		$data = [
			'id' => $this->session->get("adminID"),
			'pageTitle' => "ADMIN | STUDENT",
			'baseUrl' => base_url(),
			'students' => $students,
		];

		echo view("admin/layout/header", $data);
		echo view("admin/pages/student", $data);
		echo view("admin/layout/footer");
	}
}
