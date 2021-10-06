<?php
namespace App\Models;
use CodeIgniter\Model;

class Name extends Model{
  protected $table = 'tbl_name';

  protected $primaryKey = 'id';
  protected $allowedFields = ['col_nm'];
}
 ?>
