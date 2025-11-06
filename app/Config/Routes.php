<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::login');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/dashboard/get-counts', 'Dashboard::getCounts');
$routes->post('/dashboard/get-ba-asc-name', 'Dashboard::get_ba_asc_name');
$routes->post('/dashboard/export-announcement-pdf', 'Dashboard::exportAnnouncementPdf');
$routes->post('/dashboard/export-announcement-excel', 'Dashboard::exportAnnouncementExcel');

$routes->group('stocks/', static function ($routes) {
    //per store
    $routes->get('data-per-store', 'StocksPerStore::dataPerStore');
    $routes->post('get-data-per-store', 'StocksPerStore::getDataPerStore');
    $routes->get('get-data-per-store', 'StocksPerStore::getDataPerStore');
    $routes->post('per-store-generate-pdf', 'StocksPerStore::generatePdf');
    $routes->post('per-store-generate-excel-ba', 'StocksPerStore::generateExcel');

    //all store
    $routes->get('data-all-store', 'StocksAllStore::dataAllStore');
    $routes->get('get-data-all-store', 'StocksAllStore::GetdataAllStore');
    $routes->post('get-data-all-store', 'StocksAllStore::GetdataAllStore');
    $routes->post('all-store-generate-pdf', 'StocksAllStore::generatePdf');
    $routes->post('all-store-generate-excel', 'StocksAllStore::generateExcel');

    //week all store
    $routes->get('data-week-all-store', 'StocksWeekAllStore::dataWeekAllStore');
    $routes->get('get-data-week-all-store', 'StocksWeekAllStore::GetDataWeekAllStore');
    $routes->post('get-data-week-all-store', 'StocksWeekAllStore::GetDataWeekAllStore');
    $routes->post('stocks-week-all-store-generate-pdf', 'StocksWeekAllStore::generatePdf');
    $routes->post('stocks-week-all-store-generate-excel', 'StocksWeekAllStore::generateExcel');
});

$routes->group('store/', static function ($routes) {
    //per ba
    $routes->get('sales-performance-per-ba', 'StoreSalesPerfPerBa::perfPerBa');
    $routes->post('get-sales-performance-per-ba', 'StoreSalesPerfPerBa::getPerfPerBa');
    $routes->get('get-sales-performance-per-ba', 'StoreSalesPerfPerBa::getPerfPerBa');
    $routes->match(['GET', 'POST'], 'per-ba-generate-pdf', 'StoreSalesPerfPerBa::generatePdf');
    $routes->match(['GET', 'POST'], 'per-ba-generate-excel-ba', 'StoreSalesPerfPerBa::generateExcel');

    //per area
    $routes->get('sales-performance-per-area', 'StoreSalesPerfPerArea::perfPerArea');
    $routes->get('get-sales-performance-per-area', 'StoreSalesPerfPerArea::getPerfPerArea');
    $routes->post('get-sales-performance-per-area', 'StoreSalesPerfPerArea::getPerfPerArea');
    $routes->post('per-area-generate-pdf', 'StoreSalesPerfPerArea::generatePdf');
    $routes->post('per-area-generate-excel', 'StoreSalesPerfPerArea::generateExcel');

    //per month
    $routes->get('sales-performance-per-month', 'StoreSalesPerfPerMonth::perfPerMonth');
    $routes->get('get-sales-performance-per-month', 'StoreSalesPerfPerMonth::getPerfPerMonth');
    $routes->post('get-sales-performance-per-month', 'StoreSalesPerfPerMonth::getPerfPerMonth');
    $routes->post('get-sales-performance-per-table', 'StoreSalesPerfPerMonth::getPerfPerTable');
    $routes->post('per-month-generate-pdf', 'StoreSalesPerfPerMonth::generatePdf');
    $routes->post('per-month-generate-excel', 'StoreSalesPerfPerMonth::generateExcel');

    //overall
    $routes->get('sales-overall-growth', 'StoreSalesPerfOverall::perfPerOverall');
    $routes->post('get-sales-overall-growth', 'StoreSalesPerfOverall::getPerfPerOverall');
    $routes->get('get-sales-overall-growth', 'StoreSalesPerfOverall::getPerfPerOverall');
    $routes->post('overall-growth-generate-pdf', 'StoreSalesPerfOverall::generatePdf');
    $routes->post('overall-growth-generate-excel', 'StoreSalesPerfOverall::generateExcel');
});

$routes->group('sell-through/', static function ($routes) {
    //by brand
    $routes->get('by-brand', 'SellThroughBrand::byBrand');
    $routes->post('get-by-brand', 'SellThroughBrand::getByBrand');
    $routes->get('get-by-brand', 'SellThroughBrand::getByBrand');
    $routes->match(['GET', 'POST'], 'by-brand-generate-pdf', 'SellThroughBrand::generatePdf');
    $routes->match(['GET', 'POST'], 'by-brand-generate-excel-ba', 'SellThroughBrand::generateExcel');

    //by brand cat
    $routes->get('by-brand-category', 'SellThroughBrandCategory::byBrandCategory');
    $routes->post('get-by-brand-category', 'SellThroughBrandCategory::getByBrandCategory');
    $routes->get('get-by-brand-category', 'SellThroughBrandCategory::getByBrandCategory');
    $routes->match(['GET', 'POST'], 'by-brand-category-generate-pdf', 'SellThroughBrandCategory::generatePdf');
    $routes->match(['GET', 'POST'], 'by-brand-category-generate-excel-ba', 'SellThroughBrandCategory::generateExcel');

    //by sku
    $routes->get('by-sku', 'SellThroughBySku::bySku');
    $routes->post('get-by-sku', 'SellThroughBySku::getBysku');
    $routes->get('get-by-sku', 'SellThroughBySku::getBysku');
    $routes->post('get-sub-sales-group', 'SellThroughBySku::getSubSalesGroup');
    $routes->get('get-sub-sales-group', 'SellThroughBySku::getSubSalesGroup');
    
    $routes->match(['GET', 'POST'], 'by-sku-generate-pdf', 'SellThroughBySku::generatePdf');
    $routes->match(['GET', 'POST'], 'by-sku-generate-excel-ba', 'SellThroughBySku::generateExcel');

    //by brand label type
    $routes->get('by-brand-label-type', 'SellThroughBrandLabelType::byBrandLabelType');
    $routes->post('get-by-brand-label-type', 'SellThroughBrandLabelType::getByBrandLabelType');
    $routes->get('get-by-brand-label-type', 'SellThroughBrandLabelType::getByBrandLabelType');
    $routes->match(['GET', 'POST'], 'by-brand-label-type-generate-pdf', 'SellThroughBrandLabelType::generatePdf');
    $routes->match(['GET', 'POST'], 'by-brand-label-type-generate-excel-ba', 'SellThroughBrandLabelType::generateExcel');

    //by overall
    $routes->get('overall', 'SellThroughOverall::overall');
    $routes->post('get-overall', 'SellThroughOverall::getOverall');
    $routes->get('get-overall', 'SellThroughOverall::getOverall');
    $routes->match(['GET', 'POST'], 'by-overall-generate-pdf', 'SellThroughOverall::generatePdf');
    $routes->match(['GET', 'POST'], 'by-overall-generate-excel-ba', 'SellThroughOverall::generateExcel');
});

$routes->group('promo-analysis/', static function ($routes) {
    $routes->get('promo-table', 'PromoAnalysis::promoTable');
    $routes->post('get-promo-table', 'PromoAnalysis::getPromoData');
    $routes->get('get-promo-table', 'PromoAnalysis::getPromoData');

    $routes->post('get-promo-table-scann-data', 'PromoAnalysis::getPromoDataScannData');
    $routes->post('get-promo-table-vmi', 'PromoAnalysis::getPromoTableVmi');
    $routes->post('get-promo-table-all', 'PromoAnalysis::getPromoDataAll');
    $routes->get('get-promo-table-all', 'PromoAnalysis::getPromoDataAll');
    $routes->get('get-promo-table-all-old', 'PromoAnalysis::getPromoDataAllOld');
    
    $routes->get('search-sku', 'PromoAnalysis::searchSku');
    $routes->get('search-store', 'PromoAnalysis::searchStore');
    $routes->get('search-variant', 'PromoAnalysis::searchVariant');
    
    $routes->match(['GET', 'POST'], 'promo-table-generate-pdf', 'PromoAnalysis::generatePdf');
    $routes->match(['GET', 'POST'], 'promo-table-generate-excel-ba', 'PromoAnalysis::generateExcel');
});

//sample API 
$routes->get('/api/send_system_info', 'Dashboard::send_system_info');
$routes->get('/api/get_users', 'Dashboard::get_users');
$routes->get('/api/get-tracc-data-sync', 'Api\FetchDataLMI::SyncData');

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
        $routes->get('/', 'Cms\SiteMenu::index');
        $routes->get('menu/(:num)/(:any)', 'Cms\SiteMenu::index/(:num)/(:any)');
        $routes->get('menu_add/(:num)/(:any)', 'Cms\SiteMenu::menu_add');
        $routes->get('menu_update/(:num)', 'Cms\SiteMenu::menu_update');
    });

    $routes->group('cms-menu', static function ($routes) {
        $routes->get('/', 'Cms\CmsMenu::index');
        $routes->get('menu/(:num)/(:any)', 'Cms\CmsMenu::index/(:num)/(:any)');
        $routes->get('menu_add/(:num)/(:any)', 'Cms\CmsMenu::menu_add');
        $routes->get('menu_update/(:num)', 'Cms\CmsMenu::menu_update');
    });

    $routes->group('import-sell-out', static function ($routes) {
        $routes->get('/', 'Cms\ImportSellOut::index');
        $routes->get('view/(:any)', 'Cms\ImportSellOut::view');
        $routes->get('add/(:any)', 'Cms\ImportSellOut::add');
        $routes->post('update-aggregated-scan-data', 'Cms\ImportSellOut::update_aggregated_scan_data');
        $routes->match(['GET', 'POST'], 'import-temp-scan-data', 'Cms\ImportSellOut::import_temp_scan_data');
        $routes->match(['GET', 'POST'], 'fetch-temp-scan-data', 'Cms\ImportSellOut::fetch_temp_scan_data');
        $routes->match(['GET', 'POST'], 'delete-temp-scan-data', 'Cms\ImportSellOut::delete_temp_scan_data');
        $routes->match(['GET', 'POST'], 'export', 'Cms\ImportSellOut::exportSpecific');
        $routes->match(['GET', 'POST'], 'batch-export', 'Cms\ImportSellOut::exportBatch');
    });

    $routes->group('import-week-on-week', static function ($routes) {
        $routes->get('/', 'Cms\ImportWeekOnWeek::index');
        $routes->match(['GET', 'POST'], 'import-temp-wkonwk-data', 'Cms\ImportWeekOnWeek::importTempWeekOnWeekData');
        $routes->match(['GET', 'POST'], 'fetch-temp-wkonwk-data', 'Cms\ImportWeekOnWeek::fetchTempWeekOnWeekData');
        $routes->match(['GET', 'POST'], 'delete-temp-wkonwk-data', 'Cms\ImportWeekOnWeek::deleteTempWeekOnWeekData');
        $routes->post('update-aggregated-week-vmi-data', 'Cms\ImportWeekOnWeek::updateAggregatedWoWData');
        $routes->match(['GET', 'POST'], 'print-temp-wkonwk-data', 'Cms\ImportWeekOnWeek::printWeekOnWeekData');
        $routes->match(['GET', 'POST'], 'delete-wkonwk-data', 'Cms\ImportWeekOnWeek::deleteWeekOnWeekData');
        $routes->match(['GET', 'POST'], 'export', 'Cms\ImportWeekOnWeek::exportSpecific');
    });

    $routes->group('import-target-sell-out-pa', static function ($routes) {
        $routes->get('/', 'Cms\ImportTargetSellOutPa::index');
        $routes->get('view/(:any)', 'Cms\ImportTargetSellOutPa::view');
        $routes->match(['GET', 'POST'], 'export', 'Cms\ImportTargetSellOutPa::exportSpecific');
        $routes->match(['GET', 'POST'], 'batch-export', 'Cms\ImportTargetSellOutPa::exportBatch');
        $routes->match(['GET', 'POST'], 'all-export', 'Cms\ImportTargetSellOutPa::exportAll');
    });

    $routes->group('import-vmi', static function ($routes) {
        $routes->get('/', 'Cms\ImportVmi::index');
        $routes->get('view/(:any)', 'Cms\ImportVmi::view');
        $routes->get('fetch-temp-vmi-data', 'Cms\ImportVmi::fetch_temp_vmi_data');
        $routes->post('import-temp-vmi-data', 'Cms\ImportVmi::import_temp_vmi_data');
        $routes->post('update-aggregated-vmi-data', 'Cms\ImportVmi::update_aggregated_vmi_data');
        $routes->post('delete-temp-vmi-data', 'Cms\ImportVmi::delete_temp_vmi_data');

        $routes->post('generate-excel', 'Cms\ImportVmi::generateExcel');
        $routes->get('generate-excel', 'Cms\ImportVmi::generateExcel');

        $routes->get('download/(:any)', 'Cms\ImportVmi::download/$1');
        $routes->get('pending', 'Cms\ImportVmi::checkPendingDownload');

        $routes->match(['GET', 'POST'], 'export', 'Cms\ImportVmi::exportSpecific');
    });

    $routes->group('import-ba-sales-report', static function ($routes) {
        $routes->get('/', 'Cms\ImportBaSalesReport::index');
        $routes->get('view/(:any)', 'Cms\ImportBaSalesReport::view');
        $routes->match(['GET', 'POST'], 'export', 'Cms\ImportBaSalesReport::exportSpecific');
        $routes->match(['GET', 'POST'], 'filter-export', 'Cms\ImportBaSalesReport::exportFilter');
        $routes->match(['GET', 'POST'], 'export-all', 'Cms\ImportBaSalesReport::exportAll');
    });

    $routes->group('import-target-sales-ps', static function ($routes) {
        $routes->get('/', 'Cms\ImportTargetSalesPs::index');
        $routes->get('view/(:any)', 'Cms\ImportTargetSalesPs::view');
        $routes->match(['GET', 'POST'], 'export', 'Cms\ImportTargetSalesPs::exportSpecific');
        $routes->match(['GET', 'POST'], 'filter-export', 'Cms\ImportTargetSalesPs::exportFilter');
        $routes->match(['GET', 'POST'], 'export-all', 'Cms\ImportTargetSalesPs::exportAll');
    });

    $routes->group('import-winsight', static function ($routes) {
        $routes->get('/', 'Cms\ImportWinsight::index');
        $routes->match(['GET', 'POST'], 'import-temp-winsight-data', 'Cms\ImportWinsight::importTempWinsight');
        $routes->match(['GET', 'POST'], 'fetch-temp-winsight-data', 'Cms\ImportWinsight::fetchTempWinsight');
        $routes->match(['GET', 'POST'], 'delete-temp-winsight-data', 'Cms\ImportWinsight::deleteTempWinsight');
        $routes->match(['GET', 'POST'], 'view/(:any)', 'Cms\ImportWinsight::view');
        $routes->match(['GET', 'POST'], 'export-winsight-data', 'Cms\ImportWinsight::exportWinsight');
    }); 

    $routes->group('cms-preference/', static function ($routes) {
        $routes->get('get-logo', 'Cms\CmsPreference::get_logo');
        $routes->get('get-menu', 'Cms\CmsPreference::get_menu');
        $routes->get('get-title', 'Cms\CmsPreference::get_title');
        $routes->get('get-site-menu', 'Cms\CmsPreference::get_site_menu');
        $routes->get('get-pending-approvals', 'Cms\CmsPreference::getPendingApprovals');
    });

    $routes->group('roles/', static function ($routes) {
        $routes->get('/', 'Cms\Role::index');
        $routes->post('menu-insert', 'Cms\Role::menu_insert');
        $routes->post('menu-update', 'Cms\Role::menu_update');
        $routes->post('delete-role-tagging', 'Cms\Role::delete_role_tagging');
    });
    
    $routes->group('agency', static function ($routes) {
        $routes->get('/', 'Cms\Agency::index');
        $routes->match(['GET', 'POST'], 'export-agency', 'Cms\Agency::export_agency');
    });

    $routes->group('label-category', static function ($routes) {
        $routes->get('/', 'Cms\LabelCategory::index');
        $routes->match(['GET', 'POST'], 'export-label-category', 'Cms\LabelCategory::exportLabelCategory');
    });

    $routes->group('pricelist-masterfile', static function ($routes) {
        $routes->get('/', 'Cms\PricelistMasterfile::index');
        $routes->get('pricelist-details/(:any)', 'Cms\PricelistMasterfile::pricelistDetails/$1');
        $routes->get('customer-details-pricelist/(:num)/(:num)', 'Cms\PricelistMasterfile::customerPricelistDetails/$1/$2');
       // $routes->post('pull-from-main',    'Cms\PricelistMasterfile::pullFromMain');
        $routes->post('refresh-from-main', 'Cms\PricelistMasterfile::refreshFromMain');
        $routes->match(['GET', 'POST'], 'merged-customers', 'Cms\PricelistMasterfile::getMergedCustomers');
        $routes->match(['GET', 'POST'], 'merged-items', 'Cms\PricelistMasterfile::getMergedItemFile');
        $routes->match(['GET', 'POST'], 'export-pricelist-mf', 'Cms\PricelistMasterfile::exportMotherPricelist');
        $routes->match(['GET', 'POST'], 'export-pricelist-details', 'Cms\PricelistMasterfile::exportPricelistDetails');
    });

    $routes->group('store-segment', static function ($routes) {
        $routes->get('/', 'Cms\StoreSegment::index');
        $routes->match(['GET', 'POST'], 'export-store-segment', 'Cms\StoreSegment::exportStoreSegment');
    });

    $routes->group('customer-sellout-indicator', static function ($routes) {
        $routes->get('/', 'Cms\CustomerSellOutIndicator::index');
        $routes->match(['GET', 'POST'], 'merged-customers', 'Cms\CustomerSellOutIndicator::getMergedCustomers');
        $routes->match(['GET', 'POST'], 'export-customer-sellout-indicator', 'Cms\CustomerSellOutIndicator::exportCustomerSellOutIndicator');
    });


    $routes->group('brand-ambassador', static function ($routes) {
        $routes->get('/', 'Cms\BrandAmbassador::index');
        $routes->match(['GET', 'POST'], 'export-ba', 'Cms\BrandAmbassador::export_ba');
    });
    
    $routes->group('team', static function ($routes) {
        $routes->get('/', 'Cms\Team::index');
        $routes->match(['GET', 'POST'], 'export-team', 'Cms\Team::export_team');
    });

    $routes->group('store-branch', static function ($routes) {
        $routes->get('/', 'Cms\StoreBranch::index');
        $routes->match(['GET', 'POST'], 'export-store', 'Cms\StoreBranch::export_store');
    });

    $routes->group('area', static function ($routes) {
        $routes->get('/', 'Cms\Area::index');
        $routes->get('get-latest-area-code', 'Cms\Area::get_latest_area_code');
        $routes->get('get-existing-area-data', 'Cms\Area::get_existing_area_data');
        $routes->match(['GET', 'POST'], 'export-area', 'Cms\Area::export_area');
        
    });

    $routes->group('asc', static function ($routes) {
        $routes->get('/', 'Cms\Asc::index');
        $routes->match(['GET', 'POST'], 'export-asc', 'Cms\Asc::export_asc');
    });

    $routes->get('year', 'Cms\Year::index');

    $routes->get('company', 'Cms\Company::index');

    $routes->get('item-class', 'Cms\ItemClass::index');

    $routes->get('system-parameter', 'Cms\SystemParameter::index');

    $routes->get('announcement', 'Cms\Announcement::index');

    //Audit trail
    $routes->group('audit-logs/', static function ($routes) {
        $routes->get('/', 'Cms\AuditTrail::index');
    });

    //Error logs
    $routes->group('error-logs/', static function ($routes) {
        $routes->get('/', 'Cms\ErrorLogs::index');
        $routes->post('get-error-log-files', 'Cms\ErrorLogs::get_error_log_files');
        $routes->get('get_error-log-files', 'Cms\ErrorLogs::get_error_log_files');
        $routes->post('get-error-log-files-filter', 'Cms\ErrorLogs::get_error_log_files_filter');
        $routes->post('error-data', 'Cms\ErrorLogs::error_data');
        $routes->get('log/(:any)', 'Cms\ErrorLogs::log');
    });
        
    $routes->group('global_controller/', static function ($routes) {
        $routes->post('/', 'Cms\GlobalController::index');
        $routes->get('get_valid_ba_data', 'Cms\GlobalController::get_valid_ba_data');
        $routes->post('log', 'Cms\GlobalController::log');
        $routes->post('log', 'Cms\GlobalController::log');
        $routes->post('save_import_log_file', 'Cms\GlobalController::save_import_log_file');
        $routes->post('save_import_log_file', 'Cms\GlobalController::save_import_log_file');    
        
    });

    $routes->group('uploads/', static function ($routes) {
        $routes->get('download/log/(:any)', 'Cms\GlobalController::downloadLog/$1');   
    });
    
    $routes->group('login/', static function ($routes) {
        $routes->get('/', 'Cms\Login::login');
        $routes->get('forgot', 'Cms\Login::forgot');
        $routes->get('unset_session', 'Cms\Login::unset_session');
        $routes->get('reset_password/(:any)', 'Cms\Login::reset_password');
        $routes->get('sign_out', 'Cms\Login::sign_out');
        $routes->post('validate_log', 'Cms\Login::validate_log');
    });

    $routes->group('/', ['filter' => 'middleware_dynamic'], static function ($routes) {
        $routes->group('error-logs/', static function ($routes) {
            $routes->get('/', 'Cms\ErrorLogs::index');
        });
	});
});

$routes->set404Override('App\Controllers\ErrorHandler::show404');