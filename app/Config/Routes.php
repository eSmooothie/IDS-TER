<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

// admin
$routes->get('/admin','Admin::index');
$routes->post("/admin/login",'Admin::verifyCredentials');

$routes->get("/admin/dashboard","Admin::dashboard");
$routes->post("/admin/schoolyear/new","Admin::addSchoolYear");
// admin:section
$routes->get("/admin/section","Section::index");
$routes->post("/admin/section/new","Section::newSection");
$routes->get("/admin/section/grade/(:num)/(:num)","Section::viewSection/$1/$2");
$routes->get("/admin/section/grade/(:num)/(:num)/edit","Section::editSection/$1/$2");
$routes->post("/admin/section/student/enroll","Section::enrollStudents");
$routes->post("/admin/section/student/enroll/csv","Section::enrollStudentsCSV");
$routes->post("/admin/section/subject/update","Section::updateSubject");
$routes->post("/admin/section/update","Section::updateSection");
$routes->post("/admin/section/remove","Section::removeSection");
// admin:students
$routes->get("/admin/student","Student::index");
$routes->post("/admin/student/add/csv","Student::addNewStudentCSV");
$routes->get("/admin/student/view/(:any)", "Student::viewStudent/$1");
// admin:teacher
$routes->get("/admin/teacher","Teacher::index");
$routes->get("/admin/teacher/view/(:segment)","Teacher::viewTeacher/$1");
$routes->get("/admin/teacher/view/(:segment)/edit","Teacher::editTeacher/$1");
$routes->post("/admin/teacher/editProfileInfo","Teacher::editProfileInfo");
$routes->post("/admin/teacher/editPassword","Teacher::editPassword");
$routes->post("/admin/teacher/addSubject","Teacher::addSubject");
$routes->post("/admin/teacher/add","Teacher::add");
// admin:department
$routes->get("/admin/department","Department::index");
$routes->get("/admin/department/view/(:segment)","Department::view/$1");
$routes->get("/admin/department/view/(:segment)/edit","Department::edit/$1");
$routes->post("/admin/department/change/name","Department::changeName");
$routes->post("/admin/department/change/chairperson", "Department::changeChairperson");
// admin::subject
$routes->get("/admin/subject","Subject::index");
$routes->post("/admin/subject/add","Subject::add");
// admin::execom
$routes->get("/admin/execom","Execom::index");
$routes->get("/admin/execom/change/(:num)","Execom::change/$1");
$routes->post("/admin/execom/update","Execom::assign");
// user::
$routes->post("/user/login","User::login");
// user::teacher
$routes->get("/user/teacher","User::teacher");
$routes->get("/user/teacher/rate/supervisor","User::supervisor");
$routes->get("/user/teacher/analytics/rating","User::analyticsRating");
$routes->get("/user/teacher/analytics/comment","User::analyticsComment");
$routes->get("/user/teacher/analytics/download","User::analyticsDownload");
// evaluation
$routes->get("/evaluate/peer/(:segment)","Evaluation::peer/$1");
$routes->get("/evaluate/student/(:segment)","Evaluation::student/$1");
$routes->get("/evaluate/supervisor/(:segment)","Evaluation::supervisor/$1");

$routes->post("/evaluate/submit","Evaluation::submit");

if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
