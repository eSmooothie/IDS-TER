<?php

namespace App\Controllers;

// public function newSection(){
//   header("Content-type:application/json");
//   $response = [
//     "message" => "OK",
//     "data" => $data,
//   ];
//   return $this->setResponseFormat('json')->respond($response, 200);
// }

class Section extends BaseController{

  public function index(){
    if($this->session->has("adminID")){
      $gradeLevel = [];

      for ($i=7; $i <= 12 ; $i++) {
        $sections = $this->sectionModel->where("GRADE_LV", $i)->findAll();
        $gradeLevel[$i] = $sections;
      }

      $data = [
        'id' => $this->session->get("adminID"),
        'pageTitle' => "ADMIN | SECTION",
        'baseUrl' => base_url(),
        'gradeLevel' => $gradeLevel,
      ];
      echo view("admin/layout/header", $data);
      echo view("admin/pages/section", $data);
      echo view("admin/layout/footer");
    }else{
      return redirect()->to("/admin");
    }
  }

  public function viewSection($gradeLv = false, $sectionId = false){
    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }

    if(!$gradeLv || !$sectionId){
      return redirect()->to("/admin/section");
    }
    $sy = $this->schoolyearModel->orderBy("ID","DESC")->first(); // get current school year
    $sectionData = $this->sectionModel->where("ID", $sectionId)->first();
    $subjects = $this->sectionSubjectModel->where("SECTION_ID", $sectionId)->findAll();
    $studentsInSec = $this->studentSectionModel->where("SECTION_ID", $sectionId)
                                          ->where("SCHOOL_YEAR_ID",$sy['ID'])
                                          ->findAll();
    $students = [];
    foreach ($studentsInSec as $key => $student) {
      $studentID = $student['STUDENT_ID'];

      // check if there is a record for current school year
      $studStatus = $this->studentStatusModel->where("STUDENT_ID", $studentID)
                                            ->where("SCHOOL_YEAR_ID", $sy['ID'])
                                            ->first();
      if(empty($studStatus)){
        // if none, create one
        $updateStatus = [
          'SCHOOL_YEAR_ID' => $sy['ID'],
          'STUDENT_ID' => $studentID,
          'DATE' => $this->getCurrentDateTime(),
        ];
        $this->studentStatusModel->insert($updateStatus);
      }
      $studentData = $this->studentModel->select(
                                          "`student`.`ID` AS `ID`,
                                           `student`.`FN` AS `FN`,
                                           `student`.`LN` AS `LN`,
                                           `student`.`IS_ACTIVE` AS `IS_ACTIVE`,
                                           `stud_status`.`STATUS` AS `STATUS`,
                                           `stud_status`.`SCHOOL_YEAR_ID` AS `SCHOOL_YEAR_ID`,
                                           `stud_status`.`DATE` AS `DATE`
                                          "
                                        )
                                        ->join("`stud_status`",
                                               "`stud_status`.`STUDENT_ID` = `student`.`ID`",
                                               "LEFT")
                                        // ->where("`stud_status`.`SCHOOL_YEAR_ID`",$sy['ID'])
                                        ->orderBy("`stud_status`.`STATUS`","DESC")
                                        ->find($studentID);

      array_push($students, $studentData);
    }

    $data = [
      'id' => $this->session->get("adminID"),
      'pageTitle' => "ADMIN | SECTION",
      'baseUrl' => base_url(),
      'sectionData' => $sectionData,
      'subjects' => $subjects,
      'students' => $students,
      'schoolyear' => $sy,
    ];

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
    $sy = $this->schoolyearModel->orderBy("ID","DESC")->first(); // get current school year
    $sectionData = $this->sectionModel->where("ID", $sectionId)->first();
    $studentsInSec = $this->studentSectionModel->where("SECTION_ID", $sectionId)
                                          ->where("SCHOOL_YEAR_ID",$sy['ID'])
                                          ->findAll();
    $allStudents = $this->studentModel->findAll();
    // get teacher and its subject teaches
    $allTeachers = [];
    $teachers = $this->teacherModel->findAll();
    foreach ($teachers as $key => $value) {
      $id = $value['ID'];
      $fn = $value['FN'];
      $ln = $value['LN'];
      $subjects = $this->teacherSubjectModel->where("TEACHER_ID", $id)
                                          ->findAll();
      $subjectTeaches = [];
      foreach ($subjects as $key => $val) {
        $subjectId = $val['SUBJECT_ID'];
        $subjectData = $this->subjectModel->find($subjectId);

        array_push($subjectTeaches, $subjectData);
      }
      $teacherData = [
        'ID' => $id,
        'FN' => $fn,
        'LN' => $ln,
        'subjects' => $subjectTeaches,
      ];

      array_push($allTeachers, $teacherData);
    }


    $sectionSubjects = [];
    $sectionSubjectsTeacher = $this->sectionSubjectModel->where("SECTION_ID", $sectionId)
                                                      ->where("SCHOOL_YEAR_ID", $sy['ID'])
                                                      ->findAll();
    foreach ($sectionSubjectsTeacher as $key => $rawData) {
      $subjectId = $rawData['SUBJECT_ID'];
      $teacherId = $rawData['TEACHER_ID'];

      $subjectData = $this->subjectModel->find($subjectId);
      $teacherData = $this->teacherModel->find($teacherId);

      $sectionSubject = [
        'teacherData' => $teacherData,
        'subjectData' => $subjectData,
      ];

      array_push($sectionSubjects, $sectionSubject);
    }

    $data = [
      'id' => $this->session->get("adminID"),
      'pageTitle' => "ADMIN | SECTION",
      'baseUrl' => base_url(),
      'sectionData' => $sectionData,
      'schoolyear' => $sy,
      'students' => $studentsInSec,
      'allStudents' => $allStudents,
      'teachers' => $allTeachers,
      'sectionSubjects' => $sectionSubjects,
    ];

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
    $sy = $this->schoolyearModel->orderBy("ID","DESC")->first();

    // check if student x is already enrolled in curr s.y
    $remove = [];
    foreach ($enrollee as $key => $value) {
      $check = $this->studentSectionModel->where("STUDENT_ID", $value)
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
      $this->studentSectionModel->insert($enroll);
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
      $isExist = $this->studentModel->find($id);
      if($isExist){
        array_push($existStudent, $id);
      }else{
        array_push($notExistStudents, $value);
      }
    }
    $this->session->setFlashdata("invalidStudentId", $notExistStudents);

    // get current school year
    $sy = $this->schoolyearModel->orderBy("ID","DESC")->first();

    // check if student x is already enrolled in curr s.y
    $remove = [];
    foreach ($existStudent as $key => $studentId) {
      $check = $this->studentSectionModel->where("STUDENT_ID", $studentId)
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

      $this->studentSectionModel->insert($enroll);
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

      $sy = $this->schoolyearModel->orderBy("ID","DESC")->first();

      $currentSubject = $this->sectionSubjectModel->where("SECTION_ID", $sectionId)
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
      $this->sectionSubjectModel->where("SECTION_ID", $sectionId)
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
        $this->sectionSubjectModel->insert($insert);
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

    $this->sectionModel->insert($data);

    $response = [
      "message" => "OK",
      "data" => $data,
    ];
    return $this->setResponseFormat('json')->respond($response, 200);
  }
}
