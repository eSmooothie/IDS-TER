<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

// model
use \App\Models\ActivityLog;
use \App\Models\Admin;
use \App\Models\Department;
use \App\Models\DeptHistory;
use \App\Models\EvalInfo;
use \App\Models\EvalQuestion;
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
	protected $helpers = [];

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
		$this->adminModel = new Admin();
		$this->departmentModel = new Department();
		$this->departmentHistoryModel = new DeptHistory();
		$this->evalInfoModel = new EvalInfo();
		$this->evalQuestionModel = new EvalQuestion();
		$this->evalTypeModel = new EvalType();
		$this->evaluatorModel = new Evaluator();
		$this->execomModel = new ExeCom();
		$this->execomHistoryModel = new ExeComHistory();
		$this->ratingModel = new Rating();
		$this->reportModel = new Report();
		$this->schoolyearModel = new SchoolYear();
		$this->sectionModel = new Section();
		$this->sectionSubjectModel = new SectionSubject();
		$this->studentModel = new Student();
		$this->studentSectionModel = new StudentSection();
		$this->studentStatusModel = new StudentStatus();
		$this->subjectModel = new Subjects();
		$this->teacherSubjectModel = new TeacherSubject();
		$this->teacherModel = new Teacher();

		// preload services
		$this->session = \Config\Services::session();
		$this->uri = service('uri');
		$this->time = new Time();
		$this->queryBuilder	= \Config\Database::connect();

	}
}
