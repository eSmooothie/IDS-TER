<?php
namespace App\Models;
use CodeIgniter\Model;

class EvalQuestion extends Model{
  protected $table = 'eval_question';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['QUESTION','EVAL_TYPE_ID'];
}
 ?>
