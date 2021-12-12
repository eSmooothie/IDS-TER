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

	/**
	 * return the latest school year
	 * 
	 * @return Array $sy
	 */
	public function getCurrentSchoolYear(): array {
		$sy = $this->schoolyearModel->orderBy("ID","DESC")->first();
		return $sy;
	}

	/**
	 * map the data to be passed in the view
	 * 
	 * @param Object $sessionId, 
	 * @param String $pageTitle,
	 * @param Array $others = [],
	 * 
	 * @return Array $map
	 */
	public function mapPageParameters($sessionId, string $pageTitle, array $others = []){
		$map = [
			'sessionId' => $sessionId,
			'pageTitle' => $pageTitle,
			'baseUrl' => base_url(),
		];

		foreach($others as $key => $value){
			// do something
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

	/**
	 * Compute the rating of teacher X
	 *
	 * @param Object $teacherId
	 * @param Object $evalTypeId
	 * @param Object $schoolyearId
	 *
	 * @return Array {"rating":[],"overall":}
	 */
	public function getRating($teacherId, $evalTypeId, $schoolyearId){
		// equation
		// n : Question #
		// W[n] : Total rating recieve
		// T[n] : Total person rated
		// Q[n] : Average rate in `n` question
		// Q[n] = W[n] / T[n]

		// N : Total number of question
		// category_ov = sum(Q[n]) / N
		// overall = student_ov * .5 + peer_ov * .2 + super_ov * .3

		// get all evaluation info of teacher Y in S.Y. Z as type X
		$evaluationInfo = $this->evalInfoModel
		->where("EVALUATED_ID", $teacherId)
		->where("SCHOOL_YEAR_ID", $schoolyearId)
		->where("EVAL_TYPE_ID", $evalTypeId)
		->findAll();

		$evaluationQuestionaire = $this->evalQuestionModel->where("EVAL_TYPE_ID", $evalTypeId)
		->orderBy("ID","ASC")
		->findAll();

		$rating = [];

		// set rating
		foreach ($evaluationQuestionaire as $key => $value) {
			$questionId = $value["ID"];

			$rating[$questionId]["weight"] = 0;
			$rating[$questionId]["avg"] = 0;
			$rating[$questionId]["t"] = 0;
		}


		foreach ($evaluationInfo as $key => $info) {
			$evalInfoId = $info['ID'];

			// add all rating
			foreach ($evaluationQuestionaire as $key => $question) {
				$questionId = $question["ID"];

				$rate = $this->ratingModel->where("EVAL_QUESTION_ID", $questionId)
				->where("EVAL_INFO_ID", $evalInfoId)
				->first();

				$value = (int)$rate["RATING"];

				$rating[$questionId]["weight"] = $rating[$questionId]["weight"] + $value;
				$rating[$questionId]["t"] += 1;
			}

		}

		// Q[n] = W[n] / T[n]
		foreach ($rating as $key => $value) {
			if($rating[$key]["t"] != 0){
					$rating[$key]["avg"] = $rating[$key]["weight"] / $rating[$key]["t"];
			}
		}

		// computer over all
		// N = len(Q[n])
		// category_ov = sum(Q[n]) / N
		$sumAvg = 0;
		foreach ($rating as $key => $value) {
			$sumAvg = $value["avg"] + $sumAvg;
		}

		$overall = $sumAvg / count($rating);

		return ["RATING" => $rating, "OVERALL" => $overall];
	}

	/**
	 * Compute the overall rating of the teacher
	 * 
	 * @param Float $studentOverall
	 * @param Float $peerOverall
	 * @param Float $supervisorOverall
	 * 
	 * @return Float overall rating
	 */
	public function getOverallRating(float $studentOverall,float $peerOverall,float $supervisorOverall){
		return ($studentOverall * .5) + ($peerOverall * .2) + ($supervisorOverall * .3);
	}
}
