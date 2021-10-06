<?php
namespace App\Models;
use CodeIgniter\Model;

class EvalInfo extends Model{
  protected $table = 'eval_info';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['EVALUATOR_ID','EVALUATED_ID','SUBJECT_ID','DATE_EVALUATED','COMMENT','SCHOOL_YEAR_ID','EVAL_TYPE_ID'];
}
 ?>
