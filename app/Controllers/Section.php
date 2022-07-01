<?php

namespace App\Controllers;
class Section extends BaseController{

  public function index(){
    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }

    $gradeLevel = [];

    for ($i=7; $i <= 12 ; $i++) {
      $sections = $this->section_model->where("GRADE_LV", $i)
                                    ->where("IS_ACTIVE", 1)
                                    ->findAll();
      $gradeLevel[$i] = $sections;
    }
    
		$pageTitle = "ADMIN | SECTION";
		$args = [
      'gradeLevel' => $gradeLevel,
		];

		$data = $this->map_page_parameters(
			$pageTitle,
			$args
		);

    echo view("admin/layout/header", $data);
    echo view("admin/pages/section", $data);
    echo view("admin/layout/footer");
  }

  public function viewSection($gradeLv = false, $sectionId = false){
    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }

    if(!$gradeLv || !$sectionId){
      return redirect()->to("/admin/section");
    }
    $sy = $this->schoolyear_model->orderBy("ID","DESC")->first(); // get current school year
    $sectionData = $this->section_model->where("ID", $sectionId)->first();

    $sectionSubject = $this->section_subject_model
    ->select("
      `subject`.`ID` AS `SUBJECT_ID`,
      `subject`.`DESCRIPTION` AS `SUBJECT_DESC`,
      `teacher`.`ID` AS `TEACHER_ID`,
      `teacher`.`LN` AS `TEACHER_LN`,
      `teacher`.`FN` AS `TEACHER_FN`
    ")
    ->join("`subject`","`subject`.`ID` = `sec_subj_lst`.`SUBJECT_ID`","INNER")
    ->join("`teacher`","`teacher`.`ID` = `sec_subj_lst`.`TEACHER_ID`","INNER")
    ->where("SECTION_ID", $sectionId)
    ->where("SCHOOL_YEAR_ID", $sy['ID'])
    ->findAll();

    $studentsInSec = $this->student_section_model
    ->select("
      `student`.`ID` AS `STUDENT_ID`,
      `student`.`LN` AS `STUDENT_LN`,
      `student`.`FN` AS `STUDENT_FN`,
      `student`.`IS_ACTIVE` AS `IS_ACTIVE`,
      `stud_status`.`STATUS` AS `STATUS`
    ")
    ->join("`student`","`student`.`ID` = `student_section`.`STUDENT_ID`","INNER")
    ->join("`stud_status`","`student`.`ID` = `stud_status`.`STUDENT_ID`","INNER")
    ->where("`student_section`.`SECTION_ID`", $sectionId)
    ->where("`student_section`.`SCHOOL_YEAR_ID`", $sy['ID'])
    ->where("`stud_status`.`SCHOOL_YEAR_ID`", $sy['ID'])
    ->findAll();

    
		$pageTitle = "ADMIN | SECTION";
		$args = [
      'sectionData' => $sectionData,
      'subjects' => $sectionSubject,
      'students' => $studentsInSec,
      'schoolyear' => $sy,
		];

		$data = $this->map_page_parameters(
			$pageTitle,
			$args
		);

    echo view("admin/layout/header", $data);
    echo view("admin/pages/viewSection", $data);
    echo view("admin/layout/footer");
  }

  public function editSection($gradeLv = false, $sectionId = false){
    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }

    if(!$gradeLv || !$sectionId){
      return redirect()->to("/admin/section");
    }
    
    $sy = $this->schoolyear_model->orderBy("ID","DESC")->first(); // get current school year
    $sectionData = $this->section_model->where("ID", $sectionId)->first();
    
    $studentsInSec = $this->student_section_model
    ->where("SECTION_ID", $sectionId)
    ->where("SCHOOL_YEAR_ID", $sy['ID'])
    ->findAll();

    $allStudents = $this->student_model->findAll();
    // get teacher and its subject teaches
    $allTeachers = $this->teacher_subject_model
    ->select("
      `tchr_subj_lst`.`ID` AS `TCHR_SUBJ_LIST`,
      `teacher`.`ID` AS `TEACHER_ID`,
      `teacher`.`LN` AS `TEACHER_LN`,
      `teacher`.`FN` AS `TEACHER_FN`,
      `subject`.`ID` AS `SUBJECT_ID`,
      `subject`.`DESCRIPTION` AS `SUBJECT_DESCRIPTION`
    ")
    ->join("`teacher`","`teacher`.`ID` = `tchr_subj_lst`.`TEACHER_ID`","INNER")
    ->join("`subject`","`subject`.`ID` = `tchr_subj_lst`.`SUBJECT_ID`","INNER")
    ->where("`tchr_subj_lst`.`SCHOOL_YEAR_ID`", $sy['ID'])
    ->findAll();

    $sectionSubjects = $this->section_subject_model
    ->select("
      `sec_subj_lst`.`ID` AS `ID`,
      `teacher`.`ID` AS `TEACHER_ID`,
      `teacher`.`LN` AS `TEACHER_LN`,
      `teacher`.`FN` AS `TEACHER_FN`,
      `subject`.`ID` AS `SUBJECT_ID`,
      `subject`.`DESCRIPTION` AS `SUBJECT_DESCRIPTION`
    ")
    ->join("`teacher`","`teacher`.`ID` = `sec_subj_lst`.`TEACHER_ID`","INNER")
    ->join("`subject`","`subject`.`ID` = `sec_subj_lst`.`SUBJECT_ID`","INNER")
    ->where("SECTION_ID", $sectionId)
    ->where("SCHOOL_YEAR_ID", $sy['ID'])
    ->findAll();

    
		$pageTitle = "ADMIN | SECTION";
		$args = [
      'sectionData' => $sectionData,
      'schoolyear' => $sy,
      'students' => $studentsInSec,
      'allStudents' => $allStudents,
      'teachers' => $allTeachers,
      'sectionSubjects' => $sectionSubjects,
		];

		$data = $this->map_page_parameters(
			$pageTitle,
			$args
		);

    // status
    if(!empty($this->session->getFlashData('enroll'))){
      $data['enrollStudentStatus'] = $this->session->getFlashData('enroll');
    }else{
      $data['enrollStudentStatus'] = false;
    }
    if(!empty($this->session->getFlashData('invalidRows'))){
      $data['invalidRows'] = $this->session->getFlashData('invalidRows');
    }else{
      $data['invalidRows'] = false;
    }
    if(!empty($this->session->getFlashData('invalidStudentId'))){
      $data['invalidStudentId'] = $this->session->getFlashData('invalidStudentId');
    }else{
      $data['invalidStudentId'] = false;
    }
    if(!empty($this->session->getFlashData('removeStudent'))){
      $data['removeStudent'] = $this->session->getFlashData('removeStudent');
    }else{
      $data['removeStudent'] = false;
    }
    if(!empty($this->session->getFlashData('enrolledStudent'))){
      $data['enrolledStudent'] = $this->session->getFlashData('enrolledStudent');
    }else{
      $data['enrolledStudent'] = false;
    }

    echo view("admin/layout/header", $data);
    echo view("admin/pages/editSection", $data);
    echo view("admin/layout/footer");
  }

  public function enrollStudents(){
    header("Content-type:application/json");
    $enrollee = $this->request->getPost("enrollee");
    $sectionId = $this->request->getPost("id");
    // get current school year
    $sy = $this->schoolyear_model->orderBy("ID","DESC")->first();

    // check if student x is already enrolled in curr s.y
    $remove = [];
    foreach ($enrollee as $key => $value) {
      $check = $this->student_section_model->where("STUDENT_ID", $value)
                                        ->where("SCHOOL_YEAR_ID", $sy['ID'])
                                        ->first();
      if(!empty($check)){
        // remove
        array_push($remove, $value);
        unset($enrollee[$key]);
      }
    }

    // enroll student
    $enrolled = [];
    foreach ($enrollee as $key => $value) {
      $enroll = [
        'STUDENT_ID' => $value,
        'SECTION_ID' => $sectionId,
        'SCHOOL_YEAR_ID' => $sy['ID'],
        'CREATED_AT' => $this->getCurrentDateTime(),
      ];
      array_push($enrolled, $value);
      $this->student_section_model->insert($enroll);
    }

    $data = [
      'enrolled' => $enrolled,
      'remove' => $remove,
      'sy' => $sy,
    ];

    $this->session->setFlashdata("enroll", $data);

    $response = [
      "message" => "OK",
      "data" => $data,
    ];
    return $this->setResponseFormat('json')->respond($response, 200);
  }

  public function enrollStudentsCSV(){
    header("Content-type:application/json");
    $csvFile = $this->request->getFile("csvFile");
    $sectionId = $this->request->getPost("sectionId");

    $uploadPath = WRITEPATH.'uploads/docs/';

    // upload file
    if($csvFile->isValid() && !$csvFile->hasMoved() && $csvFile->getClientMimeType() == "application/vnd.ms-excel"){
      $fileName = $csvFile->getRandomName();
      $csvFile->move($uploadPath, $fileName);
    }else{
      $response = [
        'message' => "Invalid CSV file",
      ];
      return $this->setResponseFormat('json')->respond($response, 500);
    }
    // read file
    $mode = "r";
    $filePath = $uploadPath.$fileName;
    $file = fopen($filePath,$mode);
    $content = fread($file, filesize($filePath));
    $data = explode("\r\n",$content); // get each line

    // TODO: loop through $data, remove quotation and separate each string base on comma.
    $enrolleeData = [];
    $invalidRows = [];
    foreach ($data as $key => $value) {
      $enroll = explode(",", $value);
      if(count($enroll) == 3 && !empty($enroll[0])){
        array_push($enrolleeData, $enroll);
      }else{
        if($key != count($data) - 1){
          $row = ['key' => $key, 'line' => $value];
          array_push($invalidRows, $row);
        }
      }
    }
    $this->session->setFlashdata("invalidRows",$invalidRows);

    // validate enrollee id
    $existStudent = [];
    $notExistStudents = [];
    foreach ($enrolleeData as $key => $value) {
      $id = $value[0]; // get only the id
      // check if id exist in db
      $isExist = $this->student_model->find($id);
      if($isExist){
        array_push($existStudent, $id);
      }else{
        array_push($notExistStudents, $value);
      }
    }
    $this->session->setFlashdata("invalidStudentId", $notExistStudents);

    // get current school year
    $sy = $this->schoolyear_model->orderBy("ID","DESC")->first();

    // check if student x is already enrolled in curr s.y
    $remove = [];
    foreach ($existStudent as $key => $studentId) {
      $check = $this->student_section_model->where("STUDENT_ID", $studentId)
                                        ->where("SCHOOL_YEAR_ID", $sy['ID'])
                                        ->first();
      if(!empty($check)){
        // remove
        array_push($remove, $studentId);
        unset($existStudent[$key]);
      }
    }
    $this->session->setFlashdata("removeStudent", $remove);

    // start enrolling
    foreach ($existStudent as $key => $studentId) {
      $enroll = [
        'STUDENT_ID' => $studentId,
        'SECTION_ID' => $sectionId,
        'SCHOOL_YEAR_ID' => $sy['ID'],
        'CREATED_AT' => $this->getCurrentDateTime(),
      ];

      $this->student_section_model->insert($enroll);
    }
    $this->session->setFlashdata("enrolledStudent", $existStudent);

    $data = [
      "sectionId" => $sectionId,
      "S.Y" => $sy,
      "fileName" => $fileName,
      "filePath" => $filePath,
      "content" => $content,
      "data" => $data,
      "enrollee" => $enrolleeData,
      "invalid_row" => $invalidRows,
      "existStudent" => $existStudent,
      "doesNotExistStudent" => $notExistStudents,
    ];

    $response = [
      "message" => "OK",
      "data" => $data,
    ];

    return $this->setResponseFormat('json')->respond($response, 200);
  }

  public function updateSubject(){
      header("Content-type:application/json");
      $teachers = $this->request->getPost("teachers[]");
      $subjects = $this->request->getPost("subjects[]");
      $sectionId = $this->request->getPost("sectionId");

      $sy = $this->schoolyear_model->orderBy("ID","DESC")->first();

      $currentSubject = $this->section_subject_model->where("SECTION_ID", $sectionId)
                                                  ->where("SCHOOL_YEAR_ID", $sy['ID'])
                                                  ->findAll();
      $toAdd = [];
      for ($i=0; $i < count($teachers); $i++) {
        $add = [
          'TEACHER_ID' => $teachers[$i],
          'SUBJECT_ID' => $subjects[$i],
        ];
        array_push($toAdd, $add);
      }

      // delete existing record
      $this->section_subject_model->where("SECTION_ID", $sectionId)
                                          ->where("SCHOOL_YEAR_ID", $sy['ID'])
                                          ->delete();
      // start adding subject
      foreach ($toAdd as $key => $value) {

        $teacherId = $value['TEACHER_ID'];
        $subjectId = $value['SUBJECT_ID'];

        $insert = [
          'SECTION_ID' => $sectionId,
          'SUBJECT_ID' => $subjectId,
          'TEACHER_ID' => $teacherId,
          'SCHOOL_YEAR_ID' => $sy['ID'],
        ];
        $this->section_subject_model->insert($insert);
      }

      $data = [
        'toAdd' => $toAdd,
        'currentSubject' => $currentSubject,
      ];

      $response = [
        "message" => "OK",
        "data" => $data,
      ];
      return $this->setResponseFormat('json')->respond($response, 200);
  }

  public function updateSection(){
      header("Content-type:application/json");
      $sectionId = $this->request->getPost("sectionId");
      $newSectionName = $this->request->getPost("sectionName");
      $newGradeLv = $this->request->getPost("gradeLevel");
      $hasRNI = $this->request->getPost("hasRNI");

      // if data is not empty update
      $newData = [];
      if(!empty($newSectionName)){
        $newData['NAME'] = $newSectionName;
      }
      if(!empty($newGradeLv)){
        $newData['GRADE_LV'] = $newGradeLv;
      }

      $newData['HAS_RNI'] = (!empty($hasRNI))? 1:0;


      if(!empty($newData)){
        $this->section_model->update($sectionId, $newData);
      }

      $data = [
        'name' => $newSectionName,
        'gradeLv' => $newGradeLv,
        'hasRNI' => $hasRNI,
      ];
      $response = [
        "message" => "OK",
        "data" => $data,
      ];
      return $this->setResponseFormat('json')->respond($response, 200);
  }

  public function removeSection(){
      header("Content-type:application/json");
      $sectionId = $this->request->getPost("sectionID");
      $confirmatioName = $this->request->getPost("removeSectionName");

      // query section
      $sectionData = $this->section_model->find($sectionId);
      $isMatch = ($sectionData['NAME'] === $confirmatioName)? true : false;

      if($isMatch){
        $inActive = [
          'IS_ACTIVE' => 0,
        ];
        $this->section_model->update($sectionId, $inActive);
      }

      $data = [
        'sectionData' => $sectionData,
        'inputtedName' => $confirmatioName,
        'isMatch' => $isMatch,
      ];

      $response = [
        "message" => "OK",
        "data" => $isMatch,
      ];

      return $this->setResponseFormat('json')->respond($response, 200);
  }

  public function newSection(){
    header("Content-type:application/json");
    $gradeLevel = $this->request->getPost("gradeLevel");
    $sectionName = $this->request->getPost("sectionName");
    $hasRNI = $this->request->getPost("hasRNI");

    $data = [
      'GRADE_LV' => (int)$gradeLevel,
      'NAME' => $sectionName,
      'HAS_RNI' => ($hasRNI == "on")? 1 : 0,
      'DATE' => $this->getCurrentDateTime(),
    ];

    $this->section_model->insert($data);

    $response = [
      "message" => "OK",
      "data" => $data,
    ];
    return $this->setResponseFormat('json')->respond($response, 200);
  }
}
