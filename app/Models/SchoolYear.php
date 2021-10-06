<?php
namespace App\Models;
use CodeIgniter\Model;

class SchoolYear extends Model{
  protected $table = 'school_year';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['S.Y','SEMESTER'];
}
 ?>
