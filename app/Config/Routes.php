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

if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
