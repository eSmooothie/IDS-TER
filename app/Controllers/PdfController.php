<?php

namespace App\Controllers;

use App\Libraries\ComputeRating;
use App\Libraries\UserDButil;
use FPDF;

// TODO: Optimize 
class PdfController extends BaseController{
  public function index($sy = false){
    if(!$this->session->has("user_id")){
      return redirect()->to("/");
    }

    if(!$sy){
      return redirect()->to("/");
    }

    $id = $this->session->get("user_id");

    $data = [
      'document_name' =>  "$id-$sy",
      'sy' => $sy,
      'id' => $id,
      'baseUrl' => FCPATH,
    ];
    return view('evaluation/pdf/format', $data);
  }

  function individual_admin($school_year_id = false, $teacher_id = false){
    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }
    if(!$school_year_id || !$teacher_id){
      return redirect()->to("/");
    }

    $user_db_util = new UserDButil();

    $id = $this->session->get("user_id");
    $school_year = $this->schoolyearModel->find($school_year_id);
    $teacher_data = $user_db_util->get_teacher_info($teacher_id);

    $department = $teacher_data['department_data'];

    $supervisor = null;

    if($teacher_data['is_supervisor']){
      $principal = $this->execomHistoryModel->where("EXECOM_ID", 1)
      ->where("SCHOOL_YEAR_ID", $school_year_id)
      ->first();

      $supervisor = $this->teacherModel->find($principal['TEACHER_ID']);
    }else{
      $chairperson = $this->departmentHistoryModel->where("DEPARTMENT_ID", $department['ID'])
      ->where("SCHOOL_YEAR_ID", $school_year_id)
      ->first();

      if(!empty($chairperson)){
        $supervisor = $this->teacherModel->find($chairperson['TEACHER_ID']);
      }
    }

    $compute_rating = new ComputeRating();

    $student_rating = $compute_rating->get_student_rating($teacher_id, $school_year_id);
    $peer_rating = $compute_rating->get_peer_rating($teacher_id, $school_year_id);
    $supervisor_rating = $compute_rating->get_supervisor_rating($teacher_id, $school_year_id);

    $overall_rating = $compute_rating->get_overall_rating($student_rating["OVERALL"], $peer_rating["OVERALL"], $supervisor_rating["OVERALL"]);

    $rating = [
      'student' => $student_rating,
      'peer' => $peer_rating,
      'supervisor' => $supervisor_rating,
      'overall' => $overall_rating,
    ];

    $page_title = $teacher_data['data']['ID']."_".$school_year['SY']."_".$school_year['SEMESTER'];
    $this->generatePDF($rating, $department, $school_year, $teacher_data['data'], $supervisor, true, $page_title);
  }

  function individual($school_year_id = false){
    if(!$this->session->has("user_id")){
      return redirect()->to("/");
    }

    if(!$school_year_id){
      return redirect()->to("/");
    }

    $user_db_util = new UserDButil();

    $id = $this->session->get("user_id");
    $school_year = $this->schoolyearModel->find($school_year_id);
    $teacher_data = $user_db_util->get_teacher_info($id);

    $department = $teacher_data['department_data'];

    $supervisor = null;

    if($teacher_data['is_supervisor']){
      $principal = $this->execomHistoryModel->where("EXECOM_ID", 1)
      ->where("SCHOOL_YEAR_ID", $school_year_id)
      ->first();

      $supervisor = $this->teacherModel->find($principal['TEACHER_ID']);
    }else{
      $chairperson = $this->departmentHistoryModel->where("DEPARTMENT_ID", $department['ID'])
      ->where("SCHOOL_YEAR_ID", $school_year_id)
      ->first();

      if(!empty($chairperson)){
        $supervisor = $this->teacherModel->find($chairperson['TEACHER_ID']);
      }
    }

    $compute_rating = new ComputeRating();

    $student_rating = $compute_rating->get_student_rating($id, $school_year_id);
    $peer_rating = $compute_rating->get_peer_rating($id, $school_year_id);
    $supervisor_rating = $compute_rating->get_supervisor_rating($id, $school_year_id);

    $overall_rating = $compute_rating->get_overall_rating($student_rating["OVERALL"], $peer_rating["OVERALL"], $supervisor_rating["OVERALL"]);

    $rating = [
      'student' => $student_rating,
      'peer' => $peer_rating,
      'supervisor' => $supervisor_rating,
      'overall' => $overall_rating,
    ];

    $page_title = "My Rating";
    $this->generatePDF($rating, $department, $school_year, $teacher_data['data'], $supervisor, true, $page_title);
  }

  function bulk_pdf_per_department($school_year_id = false, $department_id = false){
    $pdf = new FPDF();
    $user_db_util = new UserDButil();
    $compute_rating = new ComputeRating();

    if(!$this->session->has("adminID")){
      return redirect()->to("/admin");
    }
    if(!$school_year_id || !$department_id){
      return redirect()->to("/");
    }

    $department = $this->departmentModel->find($department_id);
    $school_year = $this->schoolyearModel->find($school_year_id);
    $teachers = $this->teacherModel->where("DEPARTMENT_ID", $department_id)->findAll();

    foreach ($teachers as $key => $value) {
      $teacher_id = $value['ID'];


      $teacher = $user_db_util->get_teacher_info($teacher_id);

      $supervisor = null;

      if($teacher['is_supervisor']){
        $principal = $this->execomHistoryModel->where("EXECOM_ID", 1)
        ->where("SCHOOL_YEAR_ID", $school_year_id)
        ->first();

        $supervisor = $this->teacherModel->find($principal['TEACHER_ID']);
      }else{
        $chairperson = $this->departmentHistoryModel->where("DEPARTMENT_ID", $department['ID'])
        ->where("SCHOOL_YEAR_ID", $school_year_id)
        ->first();

        if(!empty($chairperson)){
          $supervisor = $this->teacherModel->find($chairperson['TEACHER_ID']);
        }
      }


      $student_rating = $compute_rating->get_student_rating($teacher_id, $school_year_id);
      $peer_rating = $compute_rating->get_peer_rating($teacher_id, $school_year_id);
      $supervisor_rating = $compute_rating->get_supervisor_rating($teacher_id, $school_year_id);

      $overall_rating = $compute_rating->get_overall_rating($student_rating["OVERALL"], $peer_rating["OVERALL"], $supervisor_rating["OVERALL"]);

      $rating = [
        'student' => $student_rating,
        'peer' => $peer_rating,
        'supervisor' => $supervisor_rating,
        'overall' => $overall_rating,
      ];

      // print_r($teacher);
      $this->generateMultiplePDF($pdf, $rating, $department, $school_year, $teacher['data'], $supervisor, false);
    }
    
    $this->response->setHeader('Content-Type', 'application/pdf');
    $docs_title = $department['NAME']."_".$school_year['SY']."_".$school_year['SEMESTER'];
    $pdf->Output('I',$docs_title);
    $pdf->Close();
  }


  private function generatePDF($rating, $department,  $school_year, $teacher, $supervisor = null, $with_comment = false, $page_title = ""){
    $pdf = new FPDF();
    $pdf->setTitle($page_title);
    $pdf->AddPage();

    $pageWidth = $pdf->GetPageWidth();
    $pageHeight = $pdf->GetPageHeight();
    $pdf->SetFont('Arial','',12);
    // start header
    $this->pdfHeader($pdf, $department, $school_year);
    // thead
    $pdf->Cell($pageWidth / 8, 14, "Question #",1,0,'C');
    $pdf->Cell(0, 7, "Rating",1,2,'C');
    $pdf->Cell($pageWidth / 4, 7, "Student",1,0,'C');
    $pdf->Cell($pageWidth / 4, 7, "Peer",1,0,'C');
    $pdf->Cell(0, 7, "Supervisor",1,1,'C');
    // tbody
    $ratings = [];

    $student_overall = round($rating["student"]["OVERALL"], 2);
    $peer_overall = round($rating["peer"]["OVERALL"], 2);
    $supervisor_overall = round($rating["supervisor"]["OVERALL"], 2);

    $overall_rating = round($rating["overall"], 2);

    $n = 1; // question number
    foreach ($rating["student"]["RATING"] as $key => $value) {
      $ratings[$n]["STUDENT"] = round($value["avg_rate"], 2);
      $n += 1;
    }
    $n = 1;
    foreach ($rating["peer"]["RATING"] as $key => $value) {
      $ratings[$n]["PEER"] = round($value["avg_rate"], 2);
      $n += 1;
    }
    $n = 1;
    foreach ($rating["supervisor"]["RATING"] as $key => $value) {
      $ratings[$n]["SUPERVISOR"] = round($value["avg_rate"], 2);
      $n += 1;
    }

    for ($i=1; $i < $n; $i++) {
      $student_rate = (!empty($ratings[$i]["STUDENT"]))? $ratings[$i]["STUDENT"]:"";
      $peer_rate = $ratings[$i]["PEER"];
      $supervisor_rate = $ratings[$i]["SUPERVISOR"];

      $pdf->Cell($pageWidth / 8, 7, "$i",1,0,'C');
      $pdf->Cell($pageWidth / 4, 7, "$student_rate",1,0,'C');
      $pdf->Cell($pageWidth / 4, 7, "$peer_rate",1,0,'C');
      $pdf->Cell(0, 7, "$supervisor_rate",1,1,'C');
    }

    $pdf->Ln();$pdf->Ln();$pdf->Ln();
    // summary
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(($pageWidth / 4) + ($pageWidth / 8), 7, "Summary",1,0,'C');
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(30);
    $pdf->Cell((3 * $pageWidth) / 8, 7, "{$teacher['FN']} {$teacher['LN']}","B:1",1,'C');
    // student
    $pdf->Cell(((3 * $pageWidth) / 16), 7, "Student",1,0,'C');
    $pdf->Cell(((3 * $pageWidth) / 16), 7, "$student_overall",1,0,'C');
    $pdf->Cell(30);
    $pdf->Cell((3 * $pageWidth) / 8, 7, "TEACHER","0",1,'C');
    // peer
    $pdf->Cell(((3 * $pageWidth) / 16), 7, "Peer",1,0,'C');
    $pdf->Cell(((3 * $pageWidth) / 16), 7, "$peer_overall",1,1,'C');
    // supervisor
    $pdf->Cell(((3 * $pageWidth) / 16), 7, "Supervisor",1,0,'C');
    $pdf->Cell(((3 * $pageWidth) / 16), 7, "$supervisor_overall",1,0,'C');
    $pdf->Cell(30);

    $name = (!empty($supervisor))? "{$supervisor['FN']} {$supervisor['LN']}":"";

    $pdf->Cell((3 * $pageWidth) / 8, 7, "$name","B:1",1,'C');
    // overall
    $pdf->Cell(((3 * $pageWidth) / 16), 7, "Overall",1,0,'C');
    $pdf->Cell(((3 * $pageWidth) / 16), 7, "$overall_rating",1,0,'C');
    $pdf->Cell(30);
    $pdf->Cell((3 * $pageWidth) / 8, 7, "Supervisor","0",1,'C');

    // generate comment
    if($with_comment){
      $this->generateComments($pdf, $department, $school_year, $teacher);
    }

    $this->response->setHeader('Content-Type', 'application/pdf');
    $pdf->Output('I',$page_title);
  }

  private function generateMultiplePDF($pdf, $rating, $department,  $school_year, $teacher, $supervisor = null, $with_comment = false){
    $pdf->AddPage();

    $pageWidth = $pdf->GetPageWidth();
    $pageHeight = $pdf->GetPageHeight();
    $pdf->SetFont('Arial','',12);
    // start header
    $this->pdfHeader($pdf, $department, $school_year);
    // thead
    $pdf->Cell($pageWidth / 8, 14, "Question #",1,0,'C');
    $pdf->Cell(0, 7, "Rating",1,2,'C');
    $pdf->Cell($pageWidth / 4, 7, "Student",1,0,'C');
    $pdf->Cell($pageWidth / 4, 7, "Peer",1,0,'C');
    $pdf->Cell(0, 7, "Supervisor",1,1,'C');
    // tbody
    $ratings = [];

    $studentOverall = round($rating["student"]["OVERALL"], 2);
    $peerOverall = round($rating["peer"]["OVERALL"], 2);
    $supervisorOverall = round($rating["supervisor"]["OVERALL"], 2);

    $overall_rating = round($rating['overall'], 2);

    $n = 1; // question number
    foreach ($rating["student"]["RATING"] as $key => $value) {
      $ratings[$n]["STUDENT"] = round($value["avg"], 2);
      $n += 1;
    }
    $n = 1;
    foreach ($rating["peer"]["RATING"] as $key => $value) {
      $ratings[$n]["PEER"] = round($value["avg"], 2);
      $n += 1;
    }
    $n = 1;
    foreach ($rating["supervisor"]["RATING"] as $key => $value) {
      $ratings[$n]["SUPERVISOR"] = round($value["avg"], 2);
      $n += 1;
    }

    for ($i=1; $i < $n; $i++) {
      $student_rate = (!empty($ratings[$i]["STUDENT"]))? $ratings[$i]["STUDENT"]:"";
      $peer_rate = $ratings[$i]["PEER"];
      $supervisor_rate = $ratings[$i]["SUPERVISOR"];

      $pdf->Cell($pageWidth / 8, 7, "$i",1,0,'C');
      $pdf->Cell($pageWidth / 4, 7, "$student_rate",1,0,'C');
      $pdf->Cell($pageWidth / 4, 7, "$peer_rate",1,0,'C');
      $pdf->Cell(0, 7, "$supervisor_rate",1,1,'C');
    }

    $pdf->Ln();$pdf->Ln();$pdf->Ln();
    // summary
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(($pageWidth / 4) + ($pageWidth / 8), 7, "Summary",1,0,'C');
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(30);
    $pdf->Cell((3 * $pageWidth) / 8, 7, "{$teacher['FN']} {$teacher['LN']}","B:1",1,'C');
    // student
    $pdf->Cell(((3 * $pageWidth) / 16), 7, "Student",1,0,'C');
    $pdf->Cell(((3 * $pageWidth) / 16), 7, "$studentOverall",1,0,'C');
    $pdf->Cell(30);
    $pdf->Cell((3 * $pageWidth) / 8, 7, "TEACHER","0",1,'C');
    // peer
    $pdf->Cell(((3 * $pageWidth) / 16), 7, "Peer",1,0,'C');
    $pdf->Cell(((3 * $pageWidth) / 16), 7, "$peerOverall",1,1,'C');
    // supervisor
    $pdf->Cell(((3 * $pageWidth) / 16), 7, "Supervisor",1,0,'C');
    $pdf->Cell(((3 * $pageWidth) / 16), 7, "$supervisorOverall",1,0,'C');
    $pdf->Cell(30);

    $name = (!empty($supervisor))? "{$supervisor['FN']} {$supervisor['LN']}":"";

    $pdf->Cell((3 * $pageWidth) / 8, 7, "$name","B:1",1,'C');
    // overall
    $pdf->Cell(((3 * $pageWidth) / 16), 7, "Overall",1,0,'C');
    $pdf->Cell(((3 * $pageWidth) / 16), 7, "$overall_rating",1,0,'C');
    $pdf->Cell(30);
    $pdf->Cell((3 * $pageWidth) / 8, 7, "Supervisor","0",1,'C');

    // generate comment
    if($with_comment){
      $this->generateComments($pdf, $department, $school_year, $teacher);
    }
  }

  private function generateComments($pdf, $department, $school_year, $teacher){
    $pdf->AddPage();
    $pageWidth = $pdf->GetPageWidth();
    $pageHeight = $pdf->GetPageHeight();
    $pdf->SetFont('Arial','',12);
    // start header
    $this->pdfHeader($pdf, $department, $school_year);

    // thead
    $pdf->Cell(0, 7, "Comments","B",2,'C');
    $pdf->Cell(0, 7, "",0,2,'C');
    // tbody

    // comments
    $evalinfo = $this->evalInfoModel->where("EVALUATED_ID", $teacher['ID'])
    ->where("SCHOOL_YEAR_ID", $school_year['ID'])
    ->where("EVAL_TYPE_ID", 1)
    ->findAll();

    foreach ($evalinfo as $key => $value) {
      $comment = $value['COMMENT'];

      if(!empty($comment)){
        $comment = utf8_decode($comment);
        $pdf->MultiCell(0, 7, "$comment","B",'J');
        $pdf->Cell(0, 7, "",0,2,'C');
      }
    }

  }

  private function pdfHeader($pdf, $department, $school_year){
    $pageWidth = $pdf->GetPageWidth();
    $pageHeight = $pdf->GetPageHeight();

    $pdf->SetFont('Arial','B',12);
    $pdf->SetAutoPageBreak(true);
    $pdf->Image(FCPATH.'assets/img/iit.png',($pageWidth / 32) * 2,12,20,20);
    $pdf->Image(FCPATH.'assets/img/ced.jpg',($pageWidth / 32) * 27 ,12,20,20);
    $pdf->Cell(0, 6, "MSU-IIT INTEGRATED DEVELOPMENTAL SCHOOL",0,2,'C');
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(0, 6, "Teaching Efficiency Rating",0,2,'C');
    $pdf->Cell(0, 6, "{$department['NAME']}",0,2,'C');
    $pdf->Cell(0, 6, "SY: {$school_year['SY']} Semester: {$school_year['SEMESTER']}",0,2,'C');
    $pdf->Ln();$pdf->Ln();
  }
}
