<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('CustomerFront');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'CustomerFront::index');

$routes->get('services', 'Page::services');
$routes->get('packages', 'Page::packages');
$routes->get('regis', 'Page::regis');
$routes->get('about', 'Page::about');
$routes->get('testimonials', 'Page::testimonials');
$routes->get('partner', 'Page::partner');
$routes->get('terms_of_use', 'Page::terms_of_use');
$routes->get('contact_us', 'Page::contact_us');
$routes->match(['get', 'post'],'forgot_password', 'User::forgot_password');
$routes->match(['get', 'post'],'reset_password(:any)', 'User::reset_password/$1');
$routes->get('signup', 'Page::signup');
$routes->get('signup/select_package', 'Page::select_package');
$routes->get('signup/choose_partnership', 'Page::choose_partnership');
$routes->get('signup/choose_payment_plan', 'Page::choose_payment_plan');
$routes->match(['get', 'post'],'signup/confirm_plan', 'Page::confirm_plan');
$routes->get('signup/successfull', 'Page::successfull');

$routes->get('plans', 'Page::plans');
$routes->get('micro_plans', 'Page::micro_plans');
$routes->get('mega', 'Page::mega');
$routes->get('logout', 'User::logout');
$routes->match(['get', 'post'],'feedback', 'Page::feedback');
$routes->match(['get', 'post'],'invite_friend/(:any)', 'Page::invite_friend/$1');
$routes->match(['get', 'post'],'admin/refer_and_earn/(:any)', 'Profile::refer_and_earn/$1');
$routes->get('test_mail', 'Page::test_mail');


// Admin Dashboard
$routes->post('login', 'User::validate_credentials');
$routes->get('login_view', 'Page::login');
$routes->post('register', 'User::create_member');
$routes->get('admin', 'Profile::index');
$routes->get('admin/logout', 'User::logout');
$routes->get('admin/start', 'Profile::start');
$routes->get('admin/select_package', 'Profile::select_package');
$routes->match(['get', 'post'],'admin/share_products', 'Profile::share_products');
$routes->get('admin/package', 'Profile::package');
$routes->get('admin/select_plan', 'Profile::select_plan');
$routes->match(['get', 'post'],'admin/confirm_plan', 'Profile::confirm_plan');
$routes->get('admin/package_selected_successfully', 'Profile::package_selected_successfully');
$routes->match(['get', 'post'],'admin/request-fund', 'Profile::request_fund');
$routes->match(['get', 'post'],'admin/kyc', 'Profile::kyc');
$routes->match(['get', 'post'],'admin/profile', 'Profile::profile');
$routes->match(['get', 'post'],'admin/update_profile', 'Profile::update_profile');


/*Distributor Level Information*/
$routes->match(['get', 'post'],'admin/DistributorLevelInformation', 'DistributorLevelInformation::index');

$routes->get('admin/installments', 'Profile::installments');
$routes->get('admin/mypurchases', 'Profile::mypurchases');

$routes->get('admin/travelcenter', 'Profile::travelcenter');
$routes->get('admin/businesscenter', 'Profile::businesscenter');
$routes->get('admin/mysales', 'Profile::mysales');
$routes->get('admin/teamsales', 'Profile::teamsales');

$routes->get('admin/bonus', 'Profile::bonus');
$routes->get('admin/reward', 'Profile::reward');
$routes->get('admin/myincome', 'Profile::myincome');
$routes->get('admin/teamincome', 'Profile::teamincome');


// APIs
$routes->get('admin/get_notification', 'Profile::teamincome');
$routes->post('api/get_partnership', 'Api::get_partnership');
$routes->post('api/set_partnership', 'Api::set_partnership');
$routes->post('api/notification', 'Api::notification');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
