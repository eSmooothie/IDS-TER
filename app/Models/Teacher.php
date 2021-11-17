<?php
namespace App\Models;
use CodeIgniter\Model;

class Teacher extends Model{
  protected $table = 'teacher';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['ID','LN','FN','PASSWORD','MOBILE_NO','IS_LECTURER','PROFILE_PICTURE','DEPARTMENT_ID','ON_LEAVE'];
}
 ?>
