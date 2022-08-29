<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use CodeIgniter\I18n\Time;

use CodeIgniter\API\ResponseTrait;
// model
use \App\Models\ActivityLog;
use \App\Models\Admin;
use \App\Models\Department;
use \App\Models\DeptHistory;
use \App\Models\EvalInfo;
use \App\Models\EvalQuestion;
use \App\Models\EvalType;
use \App\Models\Evaluator;
use \App\Models\ExeCom;
use \App\Models\ExeComHistory;
use \App\Models\Rating;
use \App\Models\Report;
use \App\Models\SchoolYear;
use \App\Models\Section;
use \App\Models\SectionSubject;
use \App\Models\Student;
use \App\Models\StudentSection;
use \App\Models\StudentStatus;
use \App\Models\Subjects;
use \App\Models\Teacher;
use \App\Models\TeacherSubject;

class BaseController extends Controller
{
	protected $activityLogModel;
	protected $admin_model;
	protected $department_model;
	protected $department_history_model;
	protected $eval_info_model;
	protected $eval_question_model;
	protected $eval_type_model;
	protected $evaluator_model;
	protected $execom_model;
	protected $execom_history_model;

	protected $rating_model;
	protected $report_model;

	protected $schoolyear_model;

	protected $section_model;

	protected $section_subject_model;

	protected $student_model;
	protected $student_section_model;
	protected $student_status_model;

	protected $subject_model;
	protected $teacher_subject_model;
	protected $teacher_model;
	
	use ResponseTrait;
	/**
	 * Instance of the main Request object.
	 *
	 * @var IncomingRequest|CLIRequest
	 */
	protected $request;

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['url','filesystem'];

	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);


		$this->activityLogModel = new ActivityLog();
		$this->admin_model = new Admin();
		$this->department_model = new Department();
		$this->department_history_model = new DeptHistory();

		$this->eval_info_model = new EvalInfo();
		$this->eval_question_model = new EvalQuestion();
		$this->eval_type_model = new EvalType();
		$this->evaluator_model = new Evaluator();

		$this->execom_model = new ExeCom();
		$this->execom_history_model = new ExeComHistory();

		$this->rating_model = new Rating();
		$this->report_model = new Report();

		$this->schoolyear_model = new SchoolYear();

		$this->section_model = new Section();

		$this->section_subject_model = new SectionSubject();

		$this->student_model = new Student();
		$this->student_section_model = new StudentSection();
		$this->student_status_model = new StudentStatus();

		$this->subject_model = new Subjects();
		$this->teacher_subject_model = new TeacherSubject();
		$this->teacher_model = new Teacher();

		// preload services
		$this->session = \Config\Services::session();
		$this->uri = service('uri');
		$this->time = new Time();
		$this->queryBuilder	= \Config\Database::connect();

	}

	/**
	 * return the latest school year
	 * 
	 * @return Array $sy
	 */
	public function getCurrentSchoolYear(): array {
		$sy = $this->schoolyear_model->orderBy("ID","DESC")->first();
		return $sy;
	}

	/**
	 * map the data to be passed in the view
	 * 
	 * @param String $pageTitle,
	 * @param Array $others = [],
	 * 
	 * @return Array $map
	 */
	public function map_page_parameters(string $pageTitle, array $others = []){
		$map = [
			'page_title' => $pageTitle,
			'base_url' => base_url(),
		];

		foreach($others as $key => $value){
			$map[$key] = $value;
		}

		return $map;
	}

	/**
	 * return the system current time.
	 */
	public function getCurrentDateTime(){
		return $this->time->now()->toDateTimeString();
	}

	/**
	 * Generate a random name and
	 * upload the file into the writable folder.
	 * 
	 * @param Object $file
	 * 
	 * @return String filename
	 */
	public function uploadFile($file){
		$uploadPath = WRITEPATH.'uploads\\docs\\';

		// upload file
	    if($file->isValid() && !$file->hasMoved()){
			$fileName = $file->getRandomName(); // generate randomName
			$file->move($uploadPath, $fileName); // move the tmp file to the folder
		}else{
			return null;
		}

		return $fileName;
	}

	/**
	 * Read the csv file in the writable folder.
	 * 
	 * @param String $fileName
	 * 
	 * @return Object $content
	 */
	public function readCSV(string $fileName){
		$mode = "r";
		$uploadPath = WRITEPATH.'uploads\\docs\\';
	    $filePath = $uploadPath.$fileName;
	    $file = fopen($filePath, $mode);
	    $content = fread($file, filesize($filePath));

		return $content;
	}

}
