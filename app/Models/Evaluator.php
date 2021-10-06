<?php
namespace App\Models;
use CodeIgniter\Model;

class Evaluator extends Model{
  protected $table = 'evaluator';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['STUDENT_ID','TEACHER_ID'];
}
 ?>
