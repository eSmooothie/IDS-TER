<?php
namespace App\Models;
use CodeIgniter\Model;

class StudentSection extends Model{
  protected $table = 'student_section';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['STUDENT_ID','SECTION_ID','SCHOOL_YEAR_ID','CREATED_AT'];
}
 ?>
