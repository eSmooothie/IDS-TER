<?php
namespace App\Models;
use CodeIgniter\Model;

class StudentStatus extends Model{
  protected $table = 'stud_status';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['STATUS','SCHOOL_YEAR_ID','STUDENT_ID','DATE'];
}
 ?>
