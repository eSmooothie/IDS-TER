<?php
namespace App\Models;
use CodeIgniter\Model;

class Section extends Model{
  protected $table = 'section';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['GRADE_LV','NAME','IS_ACTIVE','HAS_RNI','DATE'];
}
 ?>
