<?php
namespace App\Models;
use CodeIgniter\Model;

class TeacherSubject extends Model{
  protected $table = 'tchr_subj_lst';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['TEACHER_ID','SUBJECT_ID','SCHOOL_YEAR_ID'];
}
 ?>
