<?php
namespace App\Models;
use CodeIgniter\Model;

class Subjects extends Model{
  protected $table = 'subject';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['DESCRIPTION','DATE'];
}
 ?>
