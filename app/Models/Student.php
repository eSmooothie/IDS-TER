<?php
namespace App\Models;
use CodeIgniter\Model;

class Student extends Model{
  protected $table = 'student';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['LN','FN','PASSWORD','IS_ACTIVE','PROFILE_PICTURE'];
}
 ?>
