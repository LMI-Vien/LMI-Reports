<?php

namespace App\Controllers;

use Config\Database;

class TradeDashboard extends BaseController
{
    protected $session;
    public function __construct()
	{
	    $this->session = session();
	    if (!$this->session->get('sess_site_uid')) {
	        redirect()->to(base_url('login'))->send();
	        exit;
	    }
	}

	public function ba()
	{	
		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);
		$data['brand_ambassador'] = $this->Global_model->get_brand_ambassador(0);
		$data['store_branch'] = $this->Global_model->get_store_branch(0);
		$data['brands'] = $this->Global_model->get_brand_data("ASC", 10, 0);
		
		$data['title'] = "Trade Dashboard";
		$data['PageName'] = 'Trade Dashboard';
		$data['PageUrl'] = 'Trade Dashboard';
		$data['content'] = "site/trade/ba.php";
		$data['js'] = array(
                    );
        $data['css'] = array(
                    );
		return view("site/layout/template", $data);
	}

	public function overall_ba()
	{
		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);

		$data['area'] = $this->Global_model->get_area(0);
		$data['store_branch'] = $this->Global_model->get_store_branch(0);
		$data['month'] = $this->Global_model->get_months();
		$data['year'] = $this->Global_model->get_years();

		$data['title'] = "Trade Dashboard";
		$data['PageName'] = 'Trade Dashboard';
		$data['PageUrl'] = 'Trade Dashboard';
		$data['content'] = "site/trade/overall_ba.php";
		$data['js'] = array(
                    );
        $data['css'] = array(
                    );
		return view("site/layout/template", $data);
	}

	public function asc()
	{
		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);

		$data['area'] = $this->Global_model->get_area(0);
		$data['store_branch'] = $this->Global_model->get_store_branch(0);
		$data['month'] = $this->Global_model->get_months();
		$data['year'] = $this->Global_model->get_years();

		$data['title'] = "Trade Dashboard";
		$data['PageName'] = 'Trade Dashboard';
		$data['PageUrl'] = 'Trade Dashboard';
		$data['content'] = "site/trade/asc.php";
		$data['js'] = array(
                    );
        $data['css'] = array(
                    );
		return view("site/layout/template", $data);
	}

	public function overall_asc()
	{
		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);

		$data['year'] = $this->Global_model->get_years();
		$data['title'] = "Trade Dashboard";
		$data['PageName'] = 'Trade Dashboard';
		$data['PageUrl'] = 'Trade Dashboard';
		$data['content'] = "site/trade/overall_asc.php";
		$data['asc'] = $this->Global_model->get_asc(0);
		$data['area'] = $this->Global_model->get_area(0);
		$data['brand'] = $this->Global_model->get_brand_data("ASC", 10, 0);
		$data['js'] = array(
                    );
        $data['css'] = array(
                    );
		return view("site/layout/template", $data);
	}

	public function asc_dashboard()
	{
		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);
		$data['year'] = $this->Global_model->get_years();
		$data['title'] = "Trade Dashboard";
		$data['PageName'] = 'Trade Dashboard';
		$data['PageUrl'] = 'Trade Dashboard';
		$data['content'] = "site/trade/asc_dashboard.php";
		$data['asc'] = $this->Global_model->get_asc(0);
		$data['area'] = $this->Global_model->get_area(0);
		$data['brand'] = $this->Global_model->get_brand_data("ASC", 10, 0);
		$data['store_branch'] = $this->Global_model->get_store_branch(0);
		$data['brand_ambassador'] = $this->Global_model->get_brand_ambassador(0);
		$data['js'] = array(
                    );
        $data['css'] = array(
                    );
		return view("site/layout/template", $data);
	}

	public function info_kam1()
	{
		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);
		$data['title'] = "Trade Dashboard";
		$data['PageName'] = 'Trade Dashboard';
		$data['PageUrl'] = 'Trade Dashboard';
		$data['content'] = "site/trade/info_kam1.php";
		$data['asc'] = $this->Global_model->get_asc(0);
		$data['area'] = $this->Global_model->get_area(0);
		$data['brand'] = $this->Global_model->get_brand_data("ASC", 10, 0);
		$data['store_branch'] = $this->Global_model->get_store_branch(0);
		$data['brand_ambassador'] = $this->Global_model->get_brand_ambassador(0);
		$data['js'] = array(
                    );
        $data['css'] = array(
                    );
		return view("site/layout/template", $data);
	}

	public function info_kam2()
	{
		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);
		$data['title'] = "Trade Dashboard";
		$data['PageName'] = 'Trade Dashboard';
		$data['PageUrl'] = 'Trade Dashboard';
		$data['content'] = "site/trade/info_kam2.php";
		$data['asc'] = $this->Global_model->get_asc(0);
		$data['area'] = $this->Global_model->get_area(0);
		$data['brand'] = $this->Global_model->get_brand_data("ASC", 10, 0);
		$data['store_branch'] = $this->Global_model->get_store_branch(0);
		$data['brand_ambassador'] = $this->Global_model->get_brand_ambassador(0);
		$data['js'] = array(
                    );
        $data['css'] = array(
                    );
		return view("site/layout/template", $data);
	}

	public function store_performance()
	{
		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);
		$data['title'] = "Trade Dashboard";
		$data['PageName'] = 'Trade Dashboard';
		$data['PageUrl'] = 'Trade Dashboard';
		$data['content'] = "site/trade/store_performance.php";
		$data['js'] = array(
                    );
        $data['css'] = array(
                    );
		return view("site/layout/template", $data);
	}

	public function trade_ba()
	{

	    $limit = $this->request->getVar('limit') ?? 10;
	    $offset = $this->request->getVar('offset') ?? 0;
	    $type = $this->request->getVar('type');
	    $brand = $this->request->getVar('brand');
	    $ba_type = $this->request->getVar('ba_type');
	    $brand_ambassador = $this->request->getVar('brand_ambassador');
	    $store_name = $this->request->getVar('store_name');
	    $sort = $this->request->getVar('sort') ?? 'ASC';
	    $sort_field = $this->request->getVar('sort_field');

	    $latest_vmi_data = $this->Dashboard_model->getLatestVmi();
	    if($latest_vmi_data){
	    	$latest_year = $latest_vmi_data['year_id'];
	    	$latest_month = $latest_vmi_data['month_id'];
	    	$latest_week = $latest_vmi_data['week_id'];

		    if($brand_ambassador){
		    	$brand_ambassador = $brand_ambassador;
		    }else{
		    	$brand_ambassador = null;
		    }
			if($brand){
		    	$brand = $brand;
		    }else{
		    	$brand = null;
		    }
			if($store_name){
		    	$store_name = $store_name;
		    }else{
		    	$store_name = null;
		    }

		    switch ($type) {
		        case 'slowMoving':
		            $data = $this->Dashboard_model->tradeInfoBa($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $limit, $offset, 20, 30, $latest_week, $latest_month, $latest_year);
		            break;
		        case 'overStock':
		            $data = $this->Dashboard_model->tradeInfoBa($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $limit, $offset, 30, null, $latest_week, $latest_month, $latest_year);
		            break;
		        case 'npd':
		           $data = $this->Dashboard_model->getItemClassData($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $limit, $offset, $latest_week, $latest_month, $latest_year);
		            break;
		        case 'hero':
		            $data = $this->Dashboard_model->getHeroItemsData($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $limit, $offset, $latest_week, $latest_month, $latest_year);
		            break;
		        default:
		        	$data = $this->Dashboard_model->tradeInfoBa($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $limit, $offset, 20, 30, $latest_week, $latest_month, $latest_year);
		    }

		    return $this->response->setJSON([
		        'draw' => intval($this->request->getVar('draw')),
		        'recordsTotal' => $data['total_records'],
		        'recordsFiltered' => $data['total_records'],
		        'data' => $data['data'],
		    ]);	
		    
	    }else{
			return $this->response->setJSON([
		        'draw' => intval($this->request->getVar('draw')),
		        'recordsTotal' => 0,
		        'recordsFiltered' => 0,
		        'data' => [],
		    ]);	
	    }
	}

	public function trade_overall_ba()
	{	
		$days = $this->getDaysInMonth(2, $this->getCurrentYear());

	    $limit = $this->request->getVar('limit') ?? 10;
	    $offset = $this->request->getVar('offset') ?? 0;
	    $month = $this->request->getVar('month');
	    $year = $this->request->getVar('year');
	    $area = $this->request->getVar('area');
	    $store = $this->request->getVar('store');
	    $sort = $this->request->getVar('sort') ?? 'ASC';
	    $sort_field = $this->request->getVar('sort_field');
	    $formatted_month = str_pad($month, 2, '0', STR_PAD_LEFT);
	    $date = null; 
	    $lookup_month = null;
	    $lyYear = 0;
	    $selected_year = null;
	    $lyMonth = null;
	    $targetYear = null;
	    $date = null;

	    if($year){
	    	$actual_year = $this->Dashboard_model->getYear($year);
	    	$selected_year = $actual_year[0]['year'];
	    	$lyYear = $selected_year - 1;
	    	$date = $actual_year[0]['year'];
	    	$targetYear = $actual_year[0]['id'];
	    }

	    if($month){
	    	$date = $formatted_month;
	    	$lyMonth = $month;
	    }

		if($year && $month){
	    	$actual_year = $this->Dashboard_model->getYear($year);
	    	$date = $actual_year[0]['year'] . "-" . $formatted_month;
	    }

	    if(empty($area)){
	    	$area = null;
	    }
	    if(empty($store)){
	    	$store = null;
	    }
	     $data = $this->Dashboard_model->tradeOverallBaData($limit, $offset, $month, $targetYear, $lyYear, $store, $area, $sort_field, $sort, $days, $date);
	    return $this->response->setJSON([
	        'draw' => intval($this->request->getVar('draw')),
	        'recordsTotal' => $data['total_records'],
	        'recordsFiltered' => $data['total_records'],
	        'data' => $data['data'],
	    ]);
	}


	public function trade_info_asc()
	{	
		$days = $this->getDaysInMonth(2, $this->getCurrentYear());

	    $limit = $this->request->getVar('limit') ?? 10;
	    $offset = $this->request->getVar('offset') ?? 0;
	    $month = $this->request->getVar('month');
	    $year = $this->request->getVar('year');
	    $area = $this->request->getVar('area');
	    $store = $this->request->getVar('store');
	    $sort = $this->request->getVar('sort') ?? 'ASC';
	    $sort_field = $this->request->getVar('sort_field');
	    $formatted_month = str_pad($month, 2, '0', STR_PAD_LEFT);
	    $date = null; 
	    $lookup_month = null;
	    $lyYear = 0;
	    $selected_year = null;
	    $lyMonth = null;
	    $targetYear = null;
	    $date = null;

	    if($year){
	    	$actual_year = $this->Dashboard_model->getYear($year);
	    	$selected_year = $actual_year[0]['year'];
	    	$lyYear = $selected_year - 1;
	    	$date = $actual_year[0]['year'];
	    	$targetYear = $actual_year[0]['id'];
	    }

	    if($month){
	    	$date = $formatted_month;
	    	$lyMonth = $month;
	    }

		if($year && $month){
	    	$actual_year = $this->Dashboard_model->getYear($year);
	    	$date = $actual_year[0]['year'] . "-" . $formatted_month;
	    }

	    if(empty($area)){
	    	$area = null;
	    }
	    if(empty($store)){
	    	$store = null;
	    }
	     $data = $this->Dashboard_model->tradeOverallBaData($limit, $offset, $month, $targetYear, $lyYear, $store, $area, $sort_field, $sort, $days, $date);
	    return $this->response->setJSON([
	        'draw' => intval($this->request->getVar('draw')),
	        'recordsTotal' => $data['total_records'],
	        'recordsFiltered' => $data['total_records'],
	        'data' => $data['data'],
	    ]);
	}

	public function trade_asc_dashboard_one()
	{	
	    $area = $this->request->getPost('area');
	    $asc = $this->request->getPost('asc');
	    $brand = $this->request->getPost('brand');
	    $ba = $this->request->getPost('ba');
	    $store = $this->request->getPost('store');
	    $year = $this->request->getPost('year');

	    $date = null; 
	    $lookup_month = null;
	    $lyYear = 0;
	    $selected_year = null;
	    $targetYear = null;
	    $date = null;
	    if($year){
	    	$actual_year = $this->Dashboard_model->getYear($year);
	    	$selected_year = $actual_year[0]['year'];
	    	$date = $actual_year[0]['year'];
	    	$targetYear = $actual_year[0]['id'];
	    }

	    if(empty($area)){
	    	$area = null;
	    }
	    if(empty($store)){
	    	$store = null;
	    }
	    $filters = [
		    'year' => $selected_year, 
		    'asc_id' => $asc,    
		    'store_id' => $store,
		    'area_id' => $area,
		    'ba_id' => $ba,
		    'brand_id' => $brand,
		    'year_val' => $targetYear
		];
	    $data = $this->Dashboard_model->tradeOverallBaDataASC($filters);
	    return $this->response->setJSON([
	        'data' => $data['data'],
	    ]);
	}

	public function trade_overall_asc_sales_report()
	{	
	    $area = $this->request->getPost('area');
	    $asc = $this->request->getPost('asc');
	    $brand = $this->request->getPost('brand');
	    $year = $this->request->getPost('year');

	    $date = null; 
	    $lookup_month = null;
	    $lyYear = 0;
	    $selected_year = null;
	    $targetYear = null;
	    $date = null;
	    if($year){
	    	$actual_year = $this->Dashboard_model->getYear($year);
	    	$selected_year = $actual_year[0]['year'];
	    	$date = $actual_year[0]['year'];
	    	$targetYear = $actual_year[0]['id'];
	    }

	    if(empty($area)){
	    	$area = null;
	    }
	    if(empty($store)){
	    	$store = null;
	    }
	    $filters = [
		    'year' => $selected_year, 
		    'asc_id' => $asc,    
		    'area_id' => $area,
		    'brand_id' => $brand,
		    'year_val' => $targetYear
		];
	    $data = $this->Dashboard_model->overallAscSalesReport($filters);
	    return $this->response->setJSON([
	        'data' => $data['data'],
	    ]);
	}

	public function trade_asc_dashboard_one_tables()
	{	
	    $area = $this->request->getPost('area');
	    $asc = $this->request->getPost('asc');
	    $brand = $this->request->getPost('brand');
	    $ba = $this->request->getPost('ba');
	    $store = $this->request->getPost('store');
	    $year = $this->request->getPost('year');
	    $type = $this->request->getPost('type');
	    $withba = $this->request->getPost('withba');


	    $date = null; 
	    $lookup_month = null;
	    $lyYear = 0;
	    $selected_year = null;
	    $targetYear = null;
	    $date = null;
	    if($year){
	    	$actual_year = $this->Dashboard_model->getYear($year);
	    	$selected_year = $actual_year[0]['year'];
	    	$date = $actual_year[0]['year'];
	    	$targetYear = $actual_year[0]['id'];
	    }
	    if(empty($area)){
	    	$area = null;
	    }
	    if(empty($store)){
	    	$store = null;
	    }
	    if(empty($ba)){
	    	$ba = null;
	    }
	    if(empty($year)){
	    	$year = null;
	    }
	    if(empty($area)){
	    	$area = null;
	    }
	    if($withba == 'with_ba'){
	    	$withba  = true;
	    }else{
	    	$withba = false;
	    }

		$latest_vmi_data = $this->Dashboard_model->getLatestVmi($year);
		$month = null;
		if($latest_vmi_data){
			$month = $latest_vmi_data['month_id'];
			$year = $latest_vmi_data['year_id'];
		}
		if(empty($month)){
	    	$month = null;
	    }

	    switch ($type) {
	        case 'slowMoving':
	           $data = $this->Dashboard_model->asc_dashboard_table_data($year, $month, 20, 30, $brand, $ba, $store, 10, 0, $withba);
	            break;
	        case 'overStock':
	            $data = $this->Dashboard_model->asc_dashboard_table_data($year, $month, 30, null, $brand, $ba, $store, 10, 0, $withba);
	            break;
	        case 'npd':
	           $data = $this->Dashboard_model->asc_dashboard_table_data_npd_hero($year, $month, $brand, $ba, $store, 10, 0, 'npd', $withba);
	            break;
	        case 'hero':
	            $data = $this->Dashboard_model->asc_dashboard_table_data_npd_hero($year, $month, $brand, $ba, $store, 10, 0, 'hero', $withba);
	            break;
	        default:
	        	$data = $this->Dashboard_model->asc_dashboard_table_data($year, $month, 20, 30, $brand, $ba, $store, 10, 0);
	    }
	    return $this->response->setJSON([
	        'draw' => intval($this->request->getVar('draw')),
	        'recordsTotal' => $data['total_records'],
	        'recordsFiltered' => $data['total_records'],
	        'data' => $data['data'],
	    ]);	
	}

	private function getDaysInMonth($month, $year) {
	    return cal_days_in_month(CAL_GREGORIAN, $month, $year);
	}

	private function getCurrentYear() {
	    return date("Y");
	}

}
