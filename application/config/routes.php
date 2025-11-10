<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['upload-image'] = 'Page';
$route['store-image'] = 'Page/upload';
$route['Accounting/getStudentDetailsWithFees'] = 'Accounting/getStudentDetailsWithFees';
$route['Page/getSubcategories'] = 'Page/getSubcategories';
$route['Settings/get_subjects_by_yearlevel1'] = 'Settings/get_subjects_by_yearlevel1';
$route['Settings/get_subjects_by_yearlevel_strand_sem'] = 'Settings/get_subjects_by_yearlevel_strand_sem';
$route['Accounting/viewStudentBalanceForm/(:any)/(:any)'] = 'Accounting/viewStudentBalanceForm/$1/$2';
$route['Page/massUpdateMonthlySchedule'] = 'Page/massUpdateMonthlySchedule';



$route['Masterlist/saveRegistrarGrades']   = 'Masterlist/saveRegistrarGrades';
$route['Masterlist/updateRegistrarGrades'] = 'Masterlist/updateRegistrarGrades';


$route['Masterlist/toggleLock'] = 'Masterlist/toggleLock';
$route['shs_report/logo/(:any)'] = 'Shs_report/logo/$1';
$route['shs_report/rc_upload/(:any)'] = 'Shs_report/rc_upload/$1';


$route['Overdues/yearlevels'] = 'Overdues/yearlevels';
$route['Overdues/save_batch'] = 'Overdues/save_batch';


$route['Page/recalcMonthlySchedule'] = 'Page/recalcMonthlySchedule';