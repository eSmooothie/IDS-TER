<?php
namespace App\Models;
use CodeIgniter\Model;

class Rating extends Model{
  protected $table = 'rating';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['RATING','EVAL_QUESTION_ID','EVAL_INFO_ID'];
}
 ?>
