<?php
namespace App\Models;
use CodeIgniter\Model;

class Department extends Model{
  protected $table = 'department';

  protected $primaryKey = 'id';
  protected $allowedFields = ['NAME'];
}
 ?>
