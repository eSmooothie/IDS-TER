<?php
namespace App\Models;
use CodeIgniter\Model;

class ExeComHistory extends Model{
  protected $table = 'execom_hist';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['SCHOOL_YEAR_ID','EXECOM_ID','TEACHER_ID'];
}
 ?>
