<?php
namespace App\Models;
use CodeIgniter\Model;

class DeptHistory extends Model{
  protected $table = 'dept_hist';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['SCHOOL_YEAR_ID','DEPARTMENT_ID','TEACHER_ID'];
}
 ?>
