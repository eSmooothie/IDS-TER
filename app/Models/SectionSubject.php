<?php
namespace App\Models;
use CodeIgniter\Model;

class SectionSubject extends Model{
  protected $table = 'sec_subj_lst';

  protected $primaryKey = 'ID';
  protected $allowedFields = ['SECTION_ID','TEACHER_ID','SCHOOL_YEAR_ID'];
}
 ?>
