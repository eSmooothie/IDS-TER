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
    // check if supervisor / execom
    $department = $this->departmentModel->find($teacher['DEPARTMENT_ID']);


    $rating = [
      'student' => 0,
      'peer' => 0,
      'supervisor' => 0,
    ];

    $this->generatePDF($rating, $department, $sy, $teacher);
  }

  private function generatePDF($rating, $department,  $schoolyear, $teacher, $supervisor = null, $withComment = false){
    $pdf = new FPDF();

    $pdf->AddPage();

    $pageWidth = $pdf->GetPageWidth();
    $pageHeight = $pdf->GetPageHeight();
    // start header
    $this->pdfHeader($pdf, $department, $schoolyear);
    // thead
    $pdf->Cell($pageWidth / 8, 14, "Question #",1,0,'C');
    $pdf->Cell(0, 7, "Rating",1,2,'C');
    $pdf->Cell($pageWidth / 4, 7, "Student",1,0,'C');
    $pdf->Cell($pageWidth / 4, 7, "Peer",1,0,'C');
    $pdf->Cell(0, 7, "Supervisor",1,1,'C');
    // tbody
    for ($i=1; $i <= 21; $i++) {
      $student_rate = rand(90,99);
      $peer_rate = rand(90,99);
      $supervisor_rate = rand(90,99);

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
    $pdf->Cell(((3 * $pageWidth) / 16), 7, "99",1,0,'C');
    $pdf->Cell(30);
    $pdf->Cell((3 * $pageWidth) / 8, 7, "TEACHER","0",1,'C');
    // peer
    $pdf->Cell(((3 * $pageWidth) / 16), 7, "Peer",1,0,'C');
    $pdf->Cell(((3 * $pageWidth) / 16), 7, "98",1,1,'C');
    // supervisor
    $pdf->Cell(((3 * $pageWidth) / 16), 7, "Supervisor",1,0,'C');
    $pdf->Cell(((3 * $pageWidth) / 16), 7, "97",1,0,'C');
    $pdf->Cell(30);
    $pdf->Cell((3 * $pageWidth) / 8, 7, "TEACHER NAME","B:1",1,'C');
    // overall
    $pdf->Cell(((3 * $pageWidth) / 16), 7, "Overall",1,0,'C');
    $pdf->Cell(((3 * $pageWidth) / 16), 7, "97",1,0,'C');
    $pdf->Cell(30);
    $pdf->Cell((3 * $pageWidth) / 8, 7, "Supervisor","0",1,'C');

    // generate comment
    

    $this->response->setHeader('Content-Type', 'application/pdf');
    $pdf->Output();
  }

  private function pdfHeader($pdf, $department, $schoolyear){
    $pageWidth = $pdf->GetPageWidth();
    $pageHeight = $pdf->GetPageHeight();

    $pdf->SetFont('Arial','B',12);
    $pdf->SetAutoPageBreak(true);
    $pdf->Image(FCPATH.'assets\img\iit.png',($pageWidth / 32) * 2,12,20,20);
    $pdf->Image(FCPATH.'assets\img\ced.jpg',($pageWidth / 32) * 27 ,12,20,20);
    $pdf->Cell(0, 6, "MSU-IIT INTEGRATED DEVELOPMENTAL SCHOOL",0,2,'C');
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(0, 6, "Teaching Efficiency Rating",0,2,'C');
    $pdf->Cell(0, 6, "{$department['NAME']}",0,2,'C');
    $pdf->Cell(0, 6, "SY: {$schoolyear['SY']} Semester: {$schoolyear['SEMESTER']}",0,2,'C');
    $pdf->Ln();$pdf->Ln();
  }
}
