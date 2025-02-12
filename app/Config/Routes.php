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
    $routes->post('validate_log', 'Login::validate_log');
    $routes->get('logout', 'Login::logout');
    $routes->get('sign_out', 'Login::sign_out');
});

// ============================CMS START=========================================
$routes->group('cms/', static function ($routes) { 
	$routes->get('/', 'Cms\Login::login');
    $routes->get('registration', 'Cms\Login::registration');
    $routes->get('home', 'Cms\Home::index');
    //$routes->get('users', 'Cms\User::index'); 
    $routes->group('users/', static function ($routes) {
        $routes->get('/', 'Cms\User::index');
        $routes->post('save_user', 'Cms\User::save_user');
        $routes->post('update_user', 'Cms\User::update_user');
    });
    $routes->get('sample', 'Cms\Roles::index');

    $routes->group('site-menu/', static function ($routes) {
        $routes->get('/', 'Cms\Site_menu::index');
        $routes->get('menu/(:num)/(:any)', 'Cms\Site_menu::index/(:num)/(:any)');
        $routes->get('menu_add/(:num)/(:any)', 'Cms\Site_menu::menu_add');
        $routes->get('menu_update/(:num)', 'Cms\Site_menu::menu_update');
    });

    $routes->group('cms-menu', static function ($routes) {
        $routes->get('/', 'Cms\Cms_menu::index');
        $routes->get('menu/(:num)/(:any)', 'Cms\Cms_menu::index/(:num)/(:any)');
        $routes->get('menu_add/(:num)/(:any)', 'Cms\Cms_menu::menu_add');
        $routes->get('menu_update/(:num)', 'Cms\Cms_menu::menu_update');
    });

    $routes->group('cms_preference/', static function ($routes) {
        $routes->get('get_logo', 'Cms\Cms_preference::get_logo');
        $routes->get('get_menu', 'Cms\Cms_preference::get_menu');
        $routes->get('get_title', 'Cms\Cms_preference::get_title');
        //$routes->get('get_custom_theme', 'Cms\Cms_preference::get_custom_theme');
        $routes->get('get_site_menu', 'Cms\Cms_preference::get_site_menu');
    });

    $routes->group('roles/', static function ($routes) {
        $routes->get('/', 'Cms\Role::index');
        $routes->post('menu_insert', 'Cms\Role::menu_insert');
        $routes->post('menu_update', 'Cms\Role::menu_update');
        $routes->post('delete_role_tagging', 'Cms\Role::delete_role_tagging');
    });
    
    $routes->get('agency', 'Cms\Agency::index');
    $routes->get('brand-ambassador', 'Cms\Brand_Ambassador::index');
    $routes->get('team', 'Cms\Team::index');

    $routes->get('store-branch', 'Cms\Store_Branch::index');
    $routes->get('asc', 'Cms\Asc::index');
    $routes->get('area', 'Cms\Area::index');

    $routes->group('login/', static function ($routes) {
        $routes->get('/', 'Cms\Login::login');
        $routes->get('forgot', 'Cms\Login::forgot');
        $routes->get('unset_session', 'Cms\Login::unset_session');
        $routes->get('reset_password/(:any)', 'Cms\Login::reset_password');
        $routes->get('sign_out', 'Cms\Login::sign_out');
        $routes->post('validate_log', 'Cms\Login::validate_log');

        $routes->get('testing', 'Cms\Login::testing');
    });

    $routes->group('/', ['filter' => 'middleware_dynamic'], static function ($routes) {

        $routes->group('Error_logs/', static function ($routes) {
            $routes->get('/', 'Cms\Error_logs::index');
        });
	});

    $routes->post('global_controller', 'cms\Global_controller::index');
});