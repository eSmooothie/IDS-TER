<?php
namespace App\Models;
use CodeIgniter\Model;

class ActivityLog extends Model{
  protected $table = 'activity_log';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['DESCRIPTION','DATE','ADMIN_ID','STUDENT_ID','TEACHER_ID'];
}
 ?>
