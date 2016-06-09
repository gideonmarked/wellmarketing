<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

// $route['account/(:any)'] = '';
$route['account'] = 'account/index';
$route['tnmadmin'] = 'tnmadmin';
$route['tnmadmin/pending'] = 'tnmadmin/pending_entries';
$route['tnmadmin/approve/(:any)'] = 'tnmadmin/approve_entry/$1';
$route['tnmadmin/approve-payout/(:any)'] = 'tnmadmin/approve_payout/$1';
$route['tnmadmin/tickets/(:any)'] = 'tnmadmin/tickets/$1';
$route['tnmadmin/ticket-owners'] = 'tnmadmin/ticket_owners';
$route['tnmadmin/leadership-bonus'] = 'tnmadmin/leadership_bonus';
$route['tnmadmin/payouts'] = 'tnmadmin/payouts';
$route['tnmadmin/news'] = 'tnmadmin/news';
$route['tnmadmin/finance'] = 'tnmadmin/finance';
$route['tnmadmin/repeat-order'] = 'tnmadmin/repeat_order';
$route['tnmadmin/members'] = 'tnmadmin/members';
$route['tnmadmin/members/(:any)'] = 'tnmadmin/members/$1';
$route['tnmadmin/test'] = 'tnmadmin/test';


$route['account/signup'] = 'account/signup';
$route['account/signentry'] = 'account/signentry';
$route['account/signin'] = 'account/signin';
$route['account/settings'] = 'account/settings';
$route['account/login/(:any)'] = 'account/login/$1';
$route['account/logout'] = 'account/logout';
$route['account/verify'] = 'account/verify';
$route['account/unilevel/(:any)'] = 'account/unilevel/$1';
$route['account/home'] = 'account/home';
$route['account/test/(:any)'] = 'account/test/$1';
$route['account/finance'] = 'account/finance';
$route['account/matrixfinance'] = 'account/matrixfinance';
$route['account/unilevel'] = 'account/unilevel';
$route['account/matrix'] = 'account/matrix';
$route['account/matrix/(:any)'] = 'account/matrix/$1';
$route['account/request-payout/(:any)'] = 'account/request_payout/$1';
$route['account/repeat-order'] = 'account/repeat_order';

$route['news'] = 'news/index';

$route['company'] = 'company/index';
$route['company/profile'] = 'company/profile';
$route['company/offices'] = 'company/offices';
$route['company/contactus'] = 'company/contactus';

$route['products'] = 'products/index';
$route['products/item/(:any)'] = 'products/item/$1';

$route['default_controller'] = 'pages/view';
$route['(:any)'] = 'pages/view/$1';
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */