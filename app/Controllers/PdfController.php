<?php

namespace App\Controllers;

class PdfController extends BaseController{
  public function index(){
      return view('evaluation/pdf/format');
  }

  function individual($teacher_id = false, $schoolyear = false){
      $dompdf = new \Dompdf\Dompdf();
      $dompdf->loadHtml(view('evaluation/pdf/test'));
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->render();
      $dompdf->stream();
  }
}
