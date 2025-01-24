<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::login');
$routes->get('/dashboard', 'Dashboard::index');


//sample API 
$routes->get('/api/send_system_info', 'Dashboard::send_system_info');
$routes->get('/api/get_users', 'Dashboard::get_users');

$routes->group('login/', static function ($routes) {
    $routes->get('/', 'Login::login');
    $routes->post('auth', 'Login::auth');
    $routes->get('logout', 'Login::logout');
    $routes->get('sign_out', 'Login::sign_out');
});

// ============================CMS START=========================================
$routes->group('cms/', static function ($routes) { 
	$routes->get('/', 'Cms\Login::login');
    $routes->get('registration', 'Cms\Login::registration');
    $routes->get('home', 'Cms\Home::index');
    $routes->get('users', 'Cms\User::index'); 
    $routes->get('sample', 'Cms\Roles::index'); //testing only
    // $routes->get('site-menu', 'Cms\Site_menu::index');
    $routes->group('site-menu/', static function ($routes) {
        $routes->get('/', 'Cms\Site_menu::index');
        $routes->get('menu/(:num)/(:any)', 'Cms\Site_menu::index/(:num)/(:any)');
        $routes->get('menu_add/(:num)/(:any)', 'Cms\Site_menu::menu_add');
        $routes->get('menu_update/(:num)', 'Cms\Site_menu::menu_update');
    });
    $routes->get('roles', 'Cms\Role::index');
    $routes->get('agency', 'Cms\Agency::index');
    $routes->get('brand-ambassador', 'Cms\Brand_Ambassador::index');
    $routes->get('team', 'Cms\Team::index');

    $routes->get('store-branch', 'Cms\Store_Branch::index');

    $routes->group('login/', static function ($routes) {
        $routes->get('/', 'Cms\Login::login');
        $routes->get('forgot', 'Cms\Login::forgot');
        $routes->get('unset_session', 'Cms\Login::unset_session');
        $routes->get('reset_password/(:any)', 'Cms\Login::reset_password');
        $routes->get('sign_out', 'Cms\Login::sign_out');
        $routes->post('validate_log', 'Cms\Login::validate_log');
    });

    $routes->group('/', ['filter' => 'middleware_dynamic'], static function ($routes) {

        $routes->group('Error_logs/', static function ($routes) {
            $routes->get('/', 'Cms\Error_logs::index');
        });
	});

    $routes->post('global_controller', 'cms\Global_controller::index');
});