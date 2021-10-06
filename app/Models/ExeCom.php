<?php
namespace App\Models;
use CodeIgniter\Model;

class ExeCom extends Model{
  protected $table = 'execom';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['NAME'];
}
 ?>
