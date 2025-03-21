<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::login');
$routes->get('/dashboard', 'Dashboard::index');


//dashboard routes
$routes->group('trade-dashboard/', static function ($routes) {
    $routes->get('ba', 'TradeDashboard::ba');
    $routes->get('overall-ba', 'TradeDashboard::overall_ba');
    $routes->get('asc', 'TradeDashboard::asc');
    $routes->get('overall-asc', 'TradeDashboard::overall_asc');
    $routes->get('asc-dashboard-1', 'TradeDashboard::asc_dashboard');
    $routes->get('info-kam-1', 'TradeDashboard::info_kam1');
    $routes->get('info-kam-2', 'TradeDashboard::info_kam2');
    $routes->get('store-performance', 'TradeDashboard::store_performance');
    $routes->get('trade-ba', 'TradeDashboard::trade_ba');
    $routes->get('trade-overall-ba', 'TradeDashboard::trade_overall_ba');
    $routes->get('trade-info-asc', 'TradeDashboard::trade_info_asc');
    $routes->get('trade-asc-dashboard-one', 'TradeDashboard::trade_asc_dashboard_one');
    $routes->post('trade-asc-dashboard-one', 'TradeDashboard::trade_asc_dashboard_one');
    $routes->get('trade-asc-dashboard-one-tables', 'TradeDashboard::trade_asc_dashboard_one_tables');
    $routes->post('trade-asc-dashboard-one-tables', 'TradeDashboard::trade_asc_dashboard_one_tables');
    $routes->get('trade-overall-asc-sales-report', 'TradeDashboard::trade_overall_asc_sales_report');
    $routes->post('trade-overall-asc-sales-report', 'TradeDashboard::trade_overall_asc_sales_report');
    $routes->get('trade-kam-one', 'TradeDashboard::trade_kam_one');
    
    //trade_overall_asc_sales_report
});




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
        $routes->get('view/(:any)', 'Cms\Import_sell_out::view');
    });

    $routes->group('import-target-sell-out-pa', static function ($routes) {
        $routes->get('/', 'Cms\Import_target_sell_out_pa::index');
        $routes->get('view/(:any)', 'Cms\Import_target_sell_out_pa::view');
    });

    $routes->group('import-vmi', static function ($routes) {
        $routes->get('/', 'Cms\Import_vmi::index');
        $routes->get('view/(:any)', 'Cms\Import_vmi::view');
    });

    $routes->group('import-ba-sales-report', static function ($routes) {
        $routes->get('/', 'Cms\Import_ba_sales_report::index');
        $routes->get('view/(:any)', 'Cms\Import_ba_sales_report::view');
    });

    $routes->group('import-target-sales-ps', static function ($routes) {
        $routes->get('/', 'Cms\Import_target_sales_ps::index');
        $routes->get('view/(:any)', 'Cms\Import_target_sales_ps::view');
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
    });
    
    $routes->get('team', 'Cms\Team::index');

    $routes->get('store-branch', 'Cms\Store_Branch::index');

    $routes->group('area', static function ($routes) {
        $routes->get('/', 'Cms\Area::index');
    });

    $routes->group('asc', static function ($routes) {
        $routes->get('/', 'Cms\Asc::index');
    });

    $routes->get('year', 'Cms\Year::index');

    $routes->get('company', 'Cms\Company::index');

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
        
    $routes->group('global_controller/', static function ($routes) {
        $routes->post('/', 'Cms\Global_controller::index');
        $routes->get('get_valid_ba_data', 'Cms\Global_controller::get_valid_ba_data');
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

});