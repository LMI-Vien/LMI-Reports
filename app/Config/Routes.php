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

    $routes->group('import-sell-out', static function ($routes) {
        $routes->get('/', 'Cms\Import_sell_out::index');
    });

    $routes->group('import-target-sell-out-pa', static function ($routes) {
        $routes->get('/', 'Cms\Import_target_sell_out_pa::index');
    });

    $routes->group('import-vmi', static function ($routes) {
        $routes->get('/', 'Cms\Import_vmi::index');
    });

    $routes->group('import-ba-sales-report', static function ($routes) {
        $routes->get('/', 'Cms\Import_ba_sales_report::index');
    });

    $routes->group('import-target-sales-ps', static function ($routes) {
        $routes->get('/', 'Cms\Import_target_sales_ps::index');
    });

    $routes->group('import-sales-top-list', static function ($routes) {
        $routes->get('/', 'Cms\Import_sales_top_list::index');
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

    $routes->group('brand-ambassador', static function ($routes) {
        $routes->get('/', 'Cms\Brand_Ambassador::index');
        $routes->get('get_valid_ba_data', 'Cms\Brand_Ambassador::get_valid_ba_data');
    });
    
    $routes->get('team', 'Cms\Team::index');

    $routes->get('store-branch', 'Cms\Store_Branch::index');
    $routes->get('asc', 'Cms\Asc::index');
    $routes->get('area', 'Cms\Area::index');

        //Audit trail
    $routes->group('Audit_trail/', static function ($routes) {
        $routes->get('/', 'Cms\Audit_trail::index');
    });

    //Error logs
    $routes->group('error_logs/', static function ($routes) {
        $routes->post('get_error_log_files', 'Cms\Error_logs::get_error_log_files');
        $routes->get('get_error_log_files', 'Cms\Error_logs::get_error_log_files');
        $routes->post('get_error_log_files_filter', 'Cms\Error_logs::get_error_log_files_filter');
        $routes->post('error_data', 'Cms\Error_logs::error_data');
        $routes->get('log/(:any)', 'Cms\Error_logs::log');
    });
    
    //Error logs
    $routes->group('Error_logs/', static function ($routes) {
        $routes->get('/', 'Cms\Error_logs::index');
    });
        

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