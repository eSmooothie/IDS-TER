<?php
namespace App\Models;
use CodeIgniter\Model;

class EvalType extends Model{
  protected $table = 'eval_type';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['DESCRIPTION'];
}
 ?>
