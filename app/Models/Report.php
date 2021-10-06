<?php
namespace App\Models;
use CodeIgniter\Model;

class Report extends Model{
  protected $table = 'report';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['DESCRIPTION','IMG_PATH','DATE_CREATED','IS_DONE','STUDENT_ID','TEACHER_ID'];
}
 ?>
