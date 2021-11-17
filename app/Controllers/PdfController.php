<?php

namespace App\Controllers;
use FPDF;

class PdfController extends BaseController{
  public function index($sy = false){
    if(!$this->session->has("userID")){
      return redirect()->to("/");
    }

    if(!$sy){
      return redirect()->to("/");
    }

    $id = $this->session->get("userID");

    $data = [
      'document_name' =>  "$id-$sy",
      'sy' => $sy,
      'id' => $id,
      'baseUrl' => FCPATH,
    ];
    return view('evaluation/pdf/format', $data);
  }

  function individual($schoolyear = false){
    if(!$this->session->has("userID")){
      return redirect()->to("/");
    }

    if(!$schoolyear){
      return redirect()->to("/");
    }

    $id = $this->session->get("userID");
    $sy = $this->schoolyearModel->find($schoolyear);
    $teacher = $this->teacherModel->find($id);

    $department = $this->departmentModel->find($teacher['DEPARTMENT_ID']);

    $supervisor = null;
    // check if supervisor / execom
    $isLecturer = $teacher['IS_LECTURER'];
    if(!$isLecturer){
      // check if teacher X is execom or supervisor
      $isExecom = $this->execomHistoryModel->where("TEACHER_ID", $id)
      ->where("EXECOM_ID !=", 1)
      ->where("SCHOOL_YEAR_ID", $sy['ID'])
      ->countAllResults();

      $isChairperson = $this->departmentHistoryModel->where("TEACHER_ID", $id)
      ->where("SCHOOL_YEAR_ID", $sy['ID'])
      ->countAllResults();

      if($isExecom > 0 || $isChairperson > 0){
        $principal = $this->execomHistoryModel->where("EXECOM_ID", 1)
        ->where("SCHOOL_YEAR_ID", $sy['ID'])
        ->first();

        $supervisor = $this->teacherModel->find($principal['TEACHER_ID']);
      }else{
        $chairperson = $this->departmentHistoryModel->where("DEPARTMENT_ID", $department['ID'])
        ->where("SCHOOL_YEAR_ID", $sy['ID'])
        ->first();

        if(!empty($chairperson)){
          $supervisor = $this->teacherModel->find($chairperson['TEACHER_ID']);
        }
      }
    }

    $studentRating = $this->getRating($id, 1, $sy["ID"]);
    $peerRating = $this->getRating($id, 2, $sy["ID"]);
    $supervisorRating = $this->getRating($id, 3, $sy["ID"]);

    $totalOverall = $this->getOverallRating($studentRating["OVERALL"], $peerRating["OVERALL"], $supervisorRating["OVERALL"]);

    $rating = [
      'student' => $studentRating,
      'peer' => $peerRating,
      'supervisor' => $supervisorRating,
      'overall' => $totalOverall,
    ];


    $this->generatePDF($rating, $department, $sy, $teacher, $supervisor, true);
  }

  private function generatePDF($rating, $department,  $schoolyear, $teacher, $supervisor = null, $withComment = false){
    $pdf = new FPDF();

    $pdf->AddPage();

    $pageWidth = $pdf->GetPageWidth();
    $pageHeight = $pdf->GetPageHeight();
    $pdf->SetFont('Arial','',12);
    // start header
    $this->pdfHeader($pdf, $department, $schoolyear);
    // thead
    $pdf->Cell($pageWidth / 8, 14, "Question #",1,0,'C');
    $pdf->Cell(0, 7, "Rating",1,2,'C');
    $pdf->Cell($pageWidth / 4, 7, "Student",1,0,'C');
    $pdf->Cell($pageWidth / 4, 7, "Peer",1,0,'C');
    $pdf->Cell(0, 7, "Supervisor",1,1,'C');
    // tbody
    $ratings = [];

    $studentOverall = round($rating["student"]["OVERALL"] * 10, 2);
    $peerOverall = round($rating["peer"]["OVERALL"] * 10, 2);
    $supervisorOverall = round($rating["supervisor"]["OVERALL"] * 10, 2);

    $totalOverall = round($this->getOverallRating($studentOverall, $peerOverall, $supervisorOverall), 2);

    $n = 1; // question number
    foreach ($rating["student"]["RATING"] as $key => $value) {
      $ratings[$n]["STUDENT"] = round($value["avg"] * 10, 2);
      $n += 1;
    }
    $n = 1;
    foreach ($rating["peer"]["RATING"] as $key => $value) {
      $ratings[$n]["PEER"] = round($value["avg"] * 10, 2);
      $n += 1;
    }
    $n = 1;
    foreach ($rating["supervisor"]["RATING"] as $key => $value) {
      $ratings[$n]["SUPERVISOR"] = round($value["avg"] * 10, 2);
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
    $pdf->Cell(((3 * $pageWidth) / 16), 7, "$totalOverall",1,0,'C');
    $pdf->Cell(30);
    $pdf->Cell((3 * $pageWidth) / 8, 7, "Supervisor","0",1,'C');

    // generate comment
    if($withComment){
      $this->generateComments($pdf, $department, $schoolyear, $teacher);
    }

    $this->response->setHeader('Content-Type', 'application/pdf');
    $pdf->Output();
  }

  private function generateComments($pdf, $department, $schoolyear, $teacher){
    $pdf->AddPage();
    $pageWidth = $pdf->GetPageWidth();
    $pageHeight = $pdf->GetPageHeight();
    $pdf->SetFont('Arial','',12);
    // start header
    $this->pdfHeader($pdf, $department, $schoolyear);

    // thead
    $pdf->Cell(0, 7, "Comments","B",2,'C');
    $pdf->Cell(0, 7, "",0,2,'C');
    // tbody

    // comments
    $evalinfo = $this->evalInfoModel->where("EVALUATED_ID", $teacher['ID'])
    ->where("SCHOOL_YEAR_ID", $schoolyear['ID'])
    ->where("EVAL_TYPE_ID", 1)
    ->findAll();

    foreach ($evalinfo as $key => $value) {
      $comment = $value['COMMENT'];

      if(!empty($comment)){
        $pdf->MultiCell(0, 7, "$comment","B",'J');
        $pdf->Cell(0, 7, "",0,2,'C');
      }
    }

  }

  private function pdfHeader($pdf, $department, $schoolyear){
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
    $pdf->Cell(0, 6, "SY: {$schoolyear['SY']} Semester: {$schoolyear['SEMESTER']}",0,2,'C');
    $pdf->Ln();$pdf->Ln();
  }
}
