<?php

namespace App\Controllers;

use Config\Database;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
		$data['brands'] = $this->Global_model->get_brand_data("ASC", 99999, 0);
		
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

	public function set_overall_asc_preview_session() {
		$session = session();
		
		$session->set('overall_asc_preview_filters', [
			'asc'			=> $this->request->getPost('asc'),
			'area'			=> $this->request->getPost('area'),
			'brand'			=> $this->request->getPost('brand'),
			'year'			=> $this->request->getPost('year'),
			'ascname'		=> $this->request->getPost('ascname'),
			'areaname'		=> $this->request->getPost('areaname'),
			'brandname'		=> $this->request->getPost('brandname'),
			'yearname' 		=> $this->request->getPost('yearname')
		]);
		return $this->response->setJSON(['status' => 'success']);
	}

	public function overall_asc_preview() {

		$sessionFilters = session()->get('overall_asc_preview_filters');
		if (!empty($sessionFilters)) {
			$uri = current_url(true);
			$data['uri'] = $uri;
			$data['meta'] = array(
				"title"         =>  "LMI Portal",
				"description"   =>  "LMI Portal Wep application",
				"keyword"       =>  ""
			);

			$data['asc_name'] = session()->get('overall_asc_preview_filters')['ascname'];
			$data['area_name'] = session()->get('overall_asc_preview_filters')['areaname'];
			$data['brand_name'] = session()->get('overall_asc_preview_filters')['brandname'];
			$data['year_name'] = session()->get('overall_asc_preview_filters')['yearname'];

			$data['asc_val'] = session()->get('overall_asc_preview_filters')['asc'];
			$data['area_val'] = session()->get('overall_asc_preview_filters')['area'];
			$data['brand_val'] = session()->get('overall_asc_preview_filters')['brand'];
			$data['year_val'] = session()->get('overall_asc_preview_filters')['year'];

			$data['title'] = "Trade Dashboard";
			$data['PageName'] = 'Trade Dashboard';
			$data['PageUrl'] = 'Trade Dashboard';
			$data['content'] = "site/trade/overall_asc_preview.php";
			$data['js'] = array(
	                    );
	        $data['css'] = array(
	                    );
			return view("site/layout/template", $data);	

		} else {
			redirect()->to(base_url('dashboard'))->send();
			exit;
		}
	}

	public function set_asc_preview_session() {
	    $session = session();
	   
		$session->set('asc_preview_filters', [
		    'store'      => $this->request->getPost('store'),
		    'area'       => $this->request->getPost('area'),
		    'month'      => $this->request->getPost('month'),
		    'year'       => $this->request->getPost('year'),
		    'storename'      => $this->request->getPost('storename'),
		    'areaname'       => $this->request->getPost('areaname'),
		    'monthname'      => $this->request->getPost('monthname'),
		    'yearname'       => $this->request->getPost('yearname'),
		    'sort'       => $this->request->getPost('sortfield'),
		    'sort_order' => $this->request->getPost('sortorder')
		]);

	    return $this->response->setJSON(['status' => 'success']);
	}

	public function asc_preview() {

		$sessionFilters = session()->get('asc_preview_filters');
		if (!empty($sessionFilters)) {
			$uri = current_url(true);
			$data['uri'] =$uri;
			$data['meta'] = array(
				"title"         =>  "LMI Portal",
				"description"   =>  "LMI Portal Wep application",
				"keyword"       =>  ""
			);

			$data['area_name'] = session()->get('asc_preview_filters')['areaname'];
			$data['store_branch_name'] = session()->get('asc_preview_filters')['storename'];
			$data['month_name'] = session()->get('asc_preview_filters')['monthname'];
			$data['year_name'] = session()->get('asc_preview_filters')['yearname'];
			$data['area_val'] = session()->get('asc_preview_filters')['area'];
			$data['store_branch_val'] = session()->get('asc_preview_filters')['store'];
			$data['month_val'] = session()->get('asc_preview_filters')['month'];
			$data['year_val'] = session()->get('asc_preview_filters')['year'];
			$data['sort_field'] = session()->get('asc_preview_filters')['sort'];
			$data['sort_order'] = session()->get('asc_preview_filters')['sort_order'];

			$data['title'] = "Trade Dashboard";
			$data['PageName'] = 'Trade Dashboard';
			$data['PageUrl'] = 'Trade Dashboard';
			$data['content'] = "site/trade/asc_preview.php";
			$data['js'] = array(
	                    );
	        $data['css'] = array(
	                    );
			return view("site/layout/template", $data);			
		}else{
			redirect()->to(base_url('dashboard'))->send();
			exit;
		}
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
		$data['brand'] = $this->Global_model->get_brand_data("ASC", 99999, 0);
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
		$data['brand'] = $this->Global_model->get_brand_data("ASC", 99999, 0);
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
		$data['month'] = $this->Global_model->get_months();
		$data['week'] = $this->Global_model->get_weeks();
		$data['item_classification'] = $this->Global_model->get_item_classification();
		$data['title'] = "Trade Dashboard";
		$data['PageName'] = 'Trade Dashboard';
		$data['PageUrl'] = 'Trade Dashboard';
		$data['content'] = "site/trade/info_kam1.php";
		$data['asc'] = $this->Global_model->get_asc(0);
		$data['area'] = $this->Global_model->get_area(0);
		$data['brand'] = $this->Global_model->get_brand_data("ASC", 99999, 0);
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
		$data['brand_ambassador'] = $this->Global_model->get_brand_ambassador(0);
		$data['store_branch'] = $this->Global_model->get_store_branch(0);
		$data['month'] = $this->Global_model->get_months();
		$data['year'] = $this->Global_model->get_years();

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

		$data['month'] = $this->Global_model->get_months();
		$data['year'] = $this->Global_model->get_years();
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

	public function set_store_performance_preview_session() {
		$session = session();

		$session->set('store_performance_preview_filters', [
			'month'			=> $this->request->getPost('month'),
			'year'			=> $this->request->getPost('year'),
			'monthname'		=> $this->request->getPost('monthname'),
			'yearname'		=> $this->request->getPost('yearname')
		]);
		return $this->response->setJSON(['status' => 'success']);
	}

	public function store_performance_preview() {
		$sessionFilters = session()->get('store_performance_preview_filters');
		if (!empty($sessionFilters)) {
			$uri = current_url(true);
			$data['uri'] = $uri;
			$data['meta'] = array(
				"title"         =>  "LMI Portal",
				"description"   =>  "LMI Portal Wep application",
				"keyword"       =>  ""
			);

			$data['month_name'] = session()->get('store_performance_preview_filters')['monthname'];
			$data['year_name'] = session()->get('store_performance_preview_filters')['yearname'];
			$data['month_val'] = session()->get('store_performance_preview_filters')['monthname'];
			$data['year_val'] = session()->get('store_performance_preview_filters')['monthname'];

			$data['title'] = "Trade Dashboard";
			$data['PageName'] = 'Trade Dashboard';
			$data['PageUrl'] = 'Trade Dashboard';
			$data['content'] = "site/trade/overall_asc_preview.php";
			$data['js'] = array(
	                    );
	        $data['css'] = array(
	                    );
			return view("site/layout/template", $data);	

		}
	}

	public function trade_ba_view() {
		$uri = current_url(true);
		$data['uri'] =$uri;
		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);
		$data['brand_ambassador'] = $this->Global_model->get_brand_ambassador(0);
		$data['store_branch'] = $this->Global_model->get_store_branch(0);
		$data['brands'] = $this->Global_model->get_brand_data("ASC", 99999, 0);
		$data['title'] = "Trade Dashboard";
		$data['PageName'] = 'Trade Dashboard';
		$data['PageUrl'] = 'Trade Dashboard';
		$data['content'] = "site/trade/ba_view.php";
		$data['js'] = array();
        $data['css'] = array();
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
					$item_class_filter = [
						'N-New Item'
					];
		           $data = $this->Dashboard_model->getItemClassNPDHEROData($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $limit, $offset, $latest_week, $latest_month, $latest_year,$item_class_filter);
		            break;
		        case 'hero':
        			$item_class_filter = [
						'A-Top 500 Pharma/Beauty',
						//'AU-Top', to follow
						'BU-Top 300 of 65% cum sales net of Class A Pharma/Beauty',
						'B-Remaining Class B net of BU Pharma/Beauty'

					];
		            $data = $this->Dashboard_model->getItemClassNPDHEROData($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $limit, $offset, $latest_week, $latest_month, $latest_year, $item_class_filter);
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

	public function trade_overall_ba_view() {
		$uri = current_url(true);
		$data['uri'] =$uri;
		
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
		$data['content'] = "site/trade/overall_ba_view.php";
		$data['js'] = array();
        $data['css'] = array();
		return view("site/layout/template", $data);
	}

	public function trade_overall_ba()
	{	
		$month = date('m');
		$days = $this->getDaysInMonth($month, $this->getCurrentYear());
		$day = date('d');
		$tpr = $days - $day; 
		
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
	     $data = $this->Dashboard_model->tradeOverallBaData($limit, $offset, $month, $targetYear, $lyYear, $store, $area, $sort_field, $sort, $tpr, $date);
	    return $this->response->setJSON([
	        'draw' => intval($this->request->getVar('draw')),
	        'recordsTotal' => $data['total_records'],
	        'recordsFiltered' => $data['total_records'],
	        'data' => $data['data'],
	    ]);
	}


	public function trade_info_asc()
	{	
		$month = date('m');
		$days = $this->getDaysInMonth($month, $this->getCurrentYear());
		$day = date('d');
		$tpr = $days - $day; 
		
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
	     $data = $this->Dashboard_model->tradeOverallBaData($limit, $offset, $month, $targetYear, $lyYear, $store, $area, $sort_field, $sort, $tpr, $date);
	    return $this->response->setJSON([
	        'draw' => intval($this->request->getVar('draw')),
	        'recordsTotal' => $data['total_records'],
	        'recordsFiltered' => $data['total_records'],
	        'data' => $data['data'],
	    ]);
	}

	public function asc_dashboard_view()
	{
		$uri = current_url(true);
		$data['uri'] =$uri;
		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);
		$data['title'] = "Trade Dashboard";
		$data['PageName'] = 'Trade Dashboard';
		$data['PageUrl'] = 'Trade Dashboard';
		$data['content'] = "site/trade/asc_dashboard_view.php";
		$data['year'] = $this->Global_model->get_years();
		$data['asc'] = $this->Global_model->get_asc(0);
		$data['area'] = $this->Global_model->get_area(0);
		$data['brand'] = $this->Global_model->get_brand_data("ASC", 99999, 0);
		$data['store_branch'] = $this->Global_model->get_store_branch(0);
		$data['brand_ambassador'] = $this->Global_model->get_brand_ambassador(0);
		$data['js'] = array(
                    );
        $data['css'] = array(
                    );
		return view("site/layout/template", $data);
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
			'area' => $area,
			'asc' => $asc,
			'brand' => $brand,
			'ba' => $ba,
			'store' => $store,
			'year' => $year,
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
	    $type = $this->request->getPost('trade_type');
	    $withba = $this->request->getPost('withba');
		$limit = (int) $this->request->getVar('limit');
		$offset = (int) $this->request->getVar('offset');

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

		$ba = null;
		$store = null;
		if($latest_vmi_data){
			$month = $latest_vmi_data['month_id'];
			$year = $latest_vmi_data['year_id'];
		}
		if(empty($month)){
	    	$month = null;
	    }
	    switch ($type) {
	        case 'slowMoving':
	           $data = $this->Dashboard_model->asc_dashboard_table_data($year, $month, $asc, $area, 20, 30, $brand, $ba, $store, $limit, $offset, $withba);
	            break;
	        case 'overStock':
	            $data = $this->Dashboard_model->asc_dashboard_table_data($year, $month, $asc, $area, 30, null, $brand, $ba, $store, $limit, $offset, $withba);
	            break;
	        case 'npd':
	        	$item_class_filter = ['N-New Item'];
	           $data = $this->Dashboard_model->asc_dashboard_table_data_npd_hero($year, $month, $asc, $area, $brand, $ba, $store, $limit, $offset, 'npd', $item_class_filter, $withba);
	            break;
	        case 'hero':
	                $item_class_filter = [
						'A-Top 500 Pharma/Beauty',
						//'AU-Top', to follow
						'BU-Top 300 of 65% cum sales net of Class A Pharma/Beauty',
						'B-Remaining Class B net of BU Pharma/Beauty'

					];
	            $data = $this->Dashboard_model->asc_dashboard_table_data_npd_hero($year, $month, $asc, $area, $brand, $ba, $store, $limit, $offset, 'hero', $item_class_filter, $withba);
	            break;
	        default:
	        	$data = $this->Dashboard_model->asc_dashboard_table_data($year, $month, 20, 30, $brand, $ba, $store, $limit, $offset);
	    }
	    return $this->response->setJSON([
	        'draw' => intval($this->request->getVar('draw')),
	        'recordsTotal' => $data['total_records'],
	        'recordsFiltered' => $data['total_records'],
	        'data' => $data['data'],
	    ]);	
	}

	public function trade_kam_one()
	{	

	    $ba = $this->request->getVar('ba');
	    $area = $this->request->getVar('area');
	    $brand = $this->request->getVar('brand');
	    $store = $this->request->getVar('store');
	    $month = $this->request->getVar('month');
	    $week = $this->request->getVar('week');
	    $withba = $this->request->getVar('withba');
	    $itemclassi = $this->request->getVar('itemcat');
		$qty = $this->request->getVar('qty');
		$limit = (int) $this->request->getVar('limit');
		$offset = (int) $this->request->getVar('offset');
		$latest_vmi_data = $this->Dashboard_model->getLatestVmi();
		$latest_year = null;
		if($latest_vmi_data){
	    	$latest_year = $latest_vmi_data['year_id'];
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
	    if(empty($brand)){
	    	$brand = null;
	    }
	    if(empty($month)){
	    	$month = null;
	    }
	    if(empty($week)){
	    	$week = null;
	    }
	    if(empty($itemclassi)){
	    	$itemclassi = null;
	    }
	    if($withba == 'with_ba'){
	    	$withba  = true;
	    }else if($withba == 'without_ba'){
	    	$withba = true;
	    }else{
	    	$withba = null;
	    }
	    if(empty($qty)){
	    	$qty = null;
	    }
	    

	    $data = $this->Dashboard_model->getFilteredKamOneData($latest_year, $month, $week, $brand, $area, $ba, $store, $itemclassi, $limit, $offset, $withba, $qty);
	    
	    return $this->response->setJSON([
	        'draw' => intval($this->request->getVar('draw')),
	        'recordsTotal' => $data['total_records'],
	        'recordsFiltered' => $data['total_records'],
	        'data' => $data['data']
	    ]);	
	}

	public function trade_kam_two()
	{	

	    $brand_ambassador = $this->request->getVar('brand_ambassador');
	    $store_name = $this->request->getVar('store');
	    $month = $this->request->getVar('month');
	    $year = $this->request->getVar('year');
	    $sort = $this->request->getVar('sort') ?? 'ASC';
	    $sort_field = $this->request->getVar('sort_field');
		$page_limit = (int) $this->request->getVar('limit');
		$page_offset = (int) $this->request->getVar('offset');
		$type = $this->request->getPost('trade_type');

	    if(empty($brand_ambassador)){
	    	$brand_ambassador = null;
	    }
	    if(empty($store_name)){
	    	$store_name = null;
	    }
	    if(empty($month)){
	    	$month = null;
	    }

	    if(empty($year)){
	    	$year = null;
	    }

		if(empty($page_limit)) {
			$page_limit = 10;
		}
		if(empty($page_offset)) {
			$page_offset = 0;
		}

	    switch ($type) {
	        case 'slowMoving':
	           $data = $this->Dashboard_model->getKamTwoData($brand_ambassador, $store_name, $sort_field, $sort, $page_limit, $page_offset, 20, 30, $month, $year);
	            break;
	        case 'overStock':
	            $data = $this->Dashboard_model->getKamTwoData($brand_ambassador, $store_name, $sort_field, $sort, $page_limit, $page_offset, 30, null, $month, $year);
	            break;
	        case 'npd':
	        	$item_class_filter = ['N-New Item'];
	           $data = $this->Dashboard_model->getKamTwoHeroNPDData($brand_ambassador, $store_name, $sort_field, $sort, $page_limit, $page_offset, $month, $year, 'npd', $item_class_filter);
	            break;
	        case 'hero':
	                $item_class_filter = [
						'A-Top 500 Pharma/Beauty',
						//'AU-Top', to follow
						'BU-Top 300 of 65% cum sales net of Class A Pharma/Beauty',
						'B-Remaining Class B net of BU Pharma/Beauty'

					];
	            $data = $this->Dashboard_model->getKamTwoHeroNPDData($brand_ambassador, $store_name, $sort_field, $sort, $page_limit, $page_offset, $month, $year, 'hero', $item_class_filter);
	            break;
	        default:
	        	$data = $this->Dashboard_model->getKamTwoData($brand_ambassador, $store_name, $sort_field, $sort, $page_limit, $page_offset, 20, 30, $month, $year);
	    }
	    
	    return $this->response->setJSON([
	        'draw' => intval($this->request->getVar('draw')),
	        'recordsTotal' => $data['total_records'],
	        'recordsFiltered' => $data['total_records'],
	        'data' => $data['data']
	    ]);	
	}

	public function trade_store_performance()
	{	

	    $month_start = $this->request->getVar('month_start');
	    $month_end = $this->request->getVar('month_end');
	    $year = $this->request->getPost('year');
		$limit = (int) $this->request->getVar('limit');
		$offset = (int) $this->request->getVar('offset');

	    if(empty($month_start)){
	    	$month_start = 1;
	    }
	    if(empty($month_end)){
	    	$month_end = 12;
	    }
	    if(!empty($year)){
	    	$actual_year = $this->Dashboard_model->getYear($year);
	    	$selected_year = $actual_year[0]['year'];
	    }else{
	    	$selected_year = 2025;
	    }
		if(empty($limit)) {
			$limit = 10;
		}
		if(empty($offset)) {
			$offset = 0;
		}

	    $data = $this->Dashboard_model->getStorePerformance($month_start, $month_end, $selected_year, $limit, $offset);

	    return $this->response->setJSON([
	        'draw' => intval($this->request->getVar('draw')),
	        'recordsTotal' => $data['total_records'],
	        'recordsFiltered' => $data['total_records'],
	        'data' => $data['data']
	    ]);	
	}

	private function getDaysInMonth($month, $year) {
	    return cal_days_in_month(CAL_GREGORIAN, $month, $year);
	}

	private function getCurrentYear() {
	    return date("Y");
	}

	public function clear_preview_session($sessionGroup)
	{
	    $session = session();
	    $session->remove($sessionGroup);

	    return $this->response->setJSON(['status' => 'cleared']);
	}

	public function refreshPreAggregatedData(){
		//manual trigger
		$data = $this->Dashboard_model->refreshPreAggregatedData();
	}

	public function generatePdfBA()
	{
	    $sort_field = $this->request->getGet('sort_field');
	    $sort = $this->request->getGet('sort');
	    $brand = $this->request->getGet('brand');
	    $brand_ambassador = $this->request->getGet('brand_ambassador');
	    $store_name = $this->request->getGet('store_name');
	    $ba_type = $this->request->getGet('ba_type');
	    $type = $this->request->getGet('type');
	    $asc_name = $this->request->getGet('asc_name');
	    $batchSize = 10000; //  10,000 data per batch
	    $offset = 0;
	    $out_con = 'ALL';
	    $latest_vmi_data = $this->Dashboard_model->getLatestVmi();
	    
	    if ($latest_vmi_data) {
	        $latest_year = $latest_vmi_data['year_id'];
	        $latest_month = $latest_vmi_data['month_id'];
	        $latest_week = $latest_vmi_data['week_id'];

	        $brand_ambassador = $brand_ambassador ?: null;
	        $brand = $brand ?: null;
	        $store_name = $store_name ?: null;
	        $out_con = $ba_type ?: "ALL";
	        $asc_name = ($asc_name && $asc_name !== 'Please Select Brand Ambassador') ? $asc_name : "";

	        $title = 'BA_Dashboard_Report';
	        
	        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
	        $pdf->SetCreator('LMI SFA');
	        $pdf->SetAuthor('LIFESTRONG MARKETING INC.');
	        $pdf->SetTitle('BA Dashboard Report');
	        $pdf->setPrintHeader(false);
	        $pdf->setPrintFooter(false);
	        $pdf->AddPage();
	        
	        $pdf->SetFont('helvetica', '', 12);
	        $pdf->Cell(0, 10, 'LIFESTRONG MARKETING INC.', 0, 1, 'C');
	        $pdf->SetFont('helvetica', '', 10);
	        $pdf->Cell(0, 5, 'Report: BA Dashboard', 0, 1, 'C');
	        $pdf->Ln(5);

	        $pdf->SetFont('helvetica', '', 9);
	        $pdf->Cell(63, 6, 'Brand Ambassador: ' . ($brand_ambassador ?: 'ALL'), 0, 0, 'L');
	        $pdf->Cell(63, 6, 'Brand: ' . ($brand ?: 'ALL'), 0, 0, 'L');
	        $pdf->Cell(63, 6, 'Outright/Consignment: ' . ($out_con ?: 'ALL'), 0, 1, 'L');
	        
	        $pdf->Cell(63, 6, 'Store Name: ' . ($store_name ?: 'ALL'), 0, 0, 'L');
	        $pdf->Cell(63, 6, 'Area / ASC Name: ' . ($asc_name ?: ''), 0, 0, 'L');
	        $pdf->Cell(63, 6, 'Date Generated: ' . date('M d, Y, h:i:s A'), 0, 1, 'L');
	        
	        $pdf->Ln(2);
	        $pdf->Cell(0, 0, '', 'T');
	        $pdf->Ln(4);

	        $pdf->SetFont('helvetica', 'B', 10);
	        $pdf->Cell(110, 6, 'Item Name', 1, 0, 'C');
	        $pdf->Cell(15, 6, 'Quantity', 1, 0, 'C');
	        $pdf->Cell(20, 6, 'LMI Code', 1, 0, 'C');
	        $pdf->Cell(20, 6, 'RGDI Code', 1, 0, 'C');
	        $pdf->Cell(25, 6, 'Type of SKU', 1, 1, 'C');

	        $pdf->SetFont('helvetica', '', 10);

	        do {
	            switch ($type) {
	                case 'slowMoving':
	                    $data = $this->Dashboard_model->tradeInfoBa($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $batchSize, $offset, 20, 30, $latest_week, $latest_month, $latest_year);
	                    $title = 'BA_Dashboard_Report_Slow_Moving';
	                    break;
	                case 'overStock':
	                    $data = $this->Dashboard_model->tradeInfoBa($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $batchSize, $offset, 30, null, $latest_week, $latest_month, $latest_year);
	                    $title = 'BA_Dashboard_Report_Overstock';
	                    break;
	                case 'npd':
	                    $item_class_filter = ['N-New Item'];
	                    $data = $this->Dashboard_model->getItemClassNPDHEROData($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $batchSize, $offset, $latest_week, $latest_month, $latest_year, $item_class_filter);
	                    $title = 'BA_Dashboard_Report_NPD';
	                    break;
	                case 'hero':
	                    $item_class_filter = ['A-Top 500 Pharma/Beauty', 'BU-Top 300 of 65% cum sales net of Class A Pharma/Beauty', 'B-Remaining Class B net of BU Pharma/Beauty'];
	                    $data = $this->Dashboard_model->getItemClassNPDHEROData($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $batchSize, $offset, $latest_week, $latest_month, $latest_year, $item_class_filter);
	                    $title = 'BA_Dashboard_Report_HERO';
	                    break;
	                default:
	                    $data = $this->Dashboard_model->tradeInfoBa($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $batchSize, $offset, 20, 30, $latest_week, $latest_month, $latest_year);
	                    $title = 'BA_Dashboard_Report_Slow_Moving';
	            }

	            if ($data) {
	                foreach ($data['data'] as $row) {
	                    $pdf->Cell(110, 6, $row->item_name, 1, 0, 'L');
	                    $pdf->Cell(15, 6, $row->sum_total_qty, 1, 0, 'C');
	                    $pdf->Cell(20, 6, $row->lmi_itmcde, 1, 0, 'C');
	                    $pdf->Cell(20, 6, $row->rgdi_itmcde, 1, 0, 'C');
	                    $pdf->Cell(25, 6, $type, 1, 1, 'C');
	                }
	            }

	            $offset += $batchSize;

	            // Free memory
	            unset($data);
	            gc_collect_cycles(); 
	        } while (!empty($data['data']));

	        $pdf->Output($title . '.pdf', 'D');
	        exit;
	    }
	}


	public function generateExcelBA()
	{
	    $sort_field = $this->request->getGet('sort_field');
	    $sort = $this->request->getGet('sort');
	    $brand = $this->request->getGet('brand') ?: null;
	    $brand_ambassador = $this->request->getGet('brand_ambassador') ?: null;
	    $store_name = $this->request->getGet('store_name') ?: null;
	    $ba_type = $this->request->getGet('ba_type') ?: null;
	    $type = $this->request->getGet('type');
	    $asc_name = $this->request->getGet('asc_name');
	    $out_con = $ba_type ? 'ALL' : 'ALL';

	    $latest_vmi_data = $this->Dashboard_model->getLatestVmi();
	    if (!$latest_vmi_data) {
	        return;
	    }

	    $latest_year = $latest_vmi_data['year_id'];
	    $latest_month = $latest_vmi_data['month_id'];
	    $latest_week = $latest_vmi_data['week_id'];

	    $asc_name = ($asc_name === 'Please Select Brand Ambassador') ? "" : $asc_name;

	    $title = 'BA_Dashboard_Report';
	    switch ($type) {
	        case 'slowMoving':
	            $title .= '_Slow_Moving';
	            break;
	        case 'overStock':
	            $title .= '_Overstock';
	            break;
	        case 'npd':
	            $title .= '_NPD';
	            break;
	        case 'hero':
	            $title .= '_HERO';
	            break;
	    }

	    $spreadsheet = new Spreadsheet();
	    $sheet = $spreadsheet->getActiveSheet();

	    $sheet->setCellValue('A1', 'LIFESTRONG MARKETING INC.');
	    $sheet->setCellValue('A2', 'Report: BA Dashboard');
	    $sheet->mergeCells('A1:E1');
	    $sheet->mergeCells('A2:E2');

	    $sheet->setCellValue('A4', 'Brand Ambassador: ' . ($brand_ambassador ?: 'ALL'));
	    $sheet->setCellValue('B4', 'Brand: ' . ($brand ?: 'ALL'));
	    $sheet->setCellValue('C4', 'Outright/Consignment: ' . ($out_con ?: 'ALL'));

	    $sheet->setCellValue('A5', 'Store Name: ' . ($store_name ?: 'ALL'));
	    $sheet->setCellValue('B5', 'Area / ASC Name: ' . ($asc_name ?: ''));
	    $sheet->setCellValue('C5', 'Date Generated: ' . date('M d, Y, h:i:s A'));

	    $headers = ['Item Name', 'Quantity', 'LMI Code', 'RGDI Code', 'Type of SKU'];
	    $sheet->fromArray($headers, null, 'A7');
	    $sheet->getStyle('A7:E7')->getFont()->setBold(true);

	    $rowNum = 8;
	    $batchSize = 5000;
	    $offset = 0;
	    do {
	        $data = $this->Dashboard_model->tradeInfoBa(
	            $brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort,
	            $batchSize, $offset, 20, 30, $latest_week, $latest_month, $latest_year
	        );

	        if (!$data || empty($data['data'])) {
	            break;
	        }

	        foreach ($data['data'] as $row) {
	            $sheet->setCellValueExplicit('A' . $rowNum, $row->item_name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
	            $sheet->setCellValueExplicit('B' . $rowNum, $row->sum_total_qty, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
	            $sheet->setCellValueExplicit('C' . $rowNum, $row->lmi_itmcde, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
	            $sheet->setCellValueExplicit('D' . $rowNum, $row->rgdi_itmcde, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
	            $sheet->setCellValueExplicit('E' . $rowNum, $type, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
	            $rowNum++;
	        }

	        $offset += $batchSize;
	    } while (count($data['data']) === $batchSize);

	    foreach (range('A', 'E') as $columnID) {
	        $sheet->getColumnDimension($columnID)->setAutoSize(true);
	    }

	    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	    header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
	    header('Cache-Control: max-age=0');

	    $writer = new Xlsx($spreadsheet);
	    $writer->save('php://output');
	    exit;
	}

	public function generatePDFOverallASC() {
		$area = $this->request->getGet('area');
	    $asc = $this->request->getGet('asc');
	    $brand = $this->request->getGet('brand');
	    $ba = $this->request->getGet('ba');
	    $store = $this->request->getGet('store');
	    $year = $this->request->getGet('year');

		$date = null; 
	    $lookup_month = null;
	    $lyYear = 0;
	    $selected_year = null;
	    $targetYear = null;
	    $date = null;
		
	    if($year) {
	    	$actual_year = $this->Dashboard_model->getYear($year);
	    	$selected_year = $actual_year[0]['year'];
	    	$date = $actual_year[0]['year'];
	    	$targetYear = $actual_year[0]['id'];
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

		// if(array_sum($filters) != 0) {
		// 	$lySellOut = ["net_sales_january", "net_sales_february", "net_sales_march", "net_sales_april", "net_sales_may", "net_sales_june", "net_sales_july", "net_sales_august", "net_sales_september", "net_sales_october", "net_sales_november", "net_sales_december"];
			
			
		// } else {
		// 	echo print_r($data);
		// }

	    // return $this->response->setJSON([
	    //  'data' => $data['data'],
		// 	'area' => $area,
		// 	'asc' => $asc,
		// 	'brand' => $brand,
		// 	'ba' => $ba,
		// 	'store' => $store,
		// 	'year' => $year,
	    // ]);

		$filterData = [
			'Year' => $selected_year ?: "ALL",
			'Area Sales Coordinator' => $asc ?: "ALL",
			'Store' => $store ?: "ALL",
			'Area' => $area ?: "ALL",
			'Brand Ambassador' => $ba ?: "ALL",
			'Brand' => $brand ?: "ALL",
		];

		$headers = [];

		$title = 'Overall Area Sales Coordinator Dashboard Report';

		$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator('LMI SFA');
		$pdf->SetAuthor('LIFESTRONG MARKETING INC.');
		$pdf->SetTitle($title);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();

		$this->printHeader($pdf, $title);
		$this->printFilter($pdf, $filterData);

		$pdf->SetFont('helvetica', '', 9);
		
		// echo print_r($data['data'][0]);
		if(array_sum($filters) != 0) {
			$data = $this->Dashboard_model->tradeOverallBaDataASC($filters);
			
			$row = $data['data'][0];

			$pageWidth = $pdf->getPageWidth();
			$pageMargin = $pdf->getMargins();
			$width = ($pageWidth - $pageMargin['left'] - $pageMargin['right']) / 13;

			$pdf->Cell($width, 10, 'Metrics', 1, 0, 'C');
			$pdf->SetFont('helvetica', 'B', 9);
			$pdf->Cell($width, 10, 'January', 1, 0, 'C');
			$pdf->Cell($width, 10, 'February', 1, 0, 'C');
			$pdf->Cell($width, 10, 'March', 1, 0, 'C');
			$pdf->Cell($width, 10, 'April', 1, 0, 'C');
			$pdf->Cell($width, 10, 'May', 1, 0, 'C');
			$pdf->Cell($width, 10, 'June', 1, 0, 'C');
			$pdf->Cell($width, 10, 'July', 1, 0, 'C');
			$pdf->Cell($width, 10, 'August', 1, 0, 'C');
			$pdf->Cell($width, 10, 'September', 1, 0, 'C');
			$pdf->Cell($width, 10, 'October', 1, 0, 'C');
			$pdf->Cell($width, 10, 'November', 1, 0, 'C');
			$pdf->Cell($width, 10, 'December', 1, 1, 'C');

			$pdf->Cell($width, 10, 'LY Sell Out', 1, 0, 'C');
			$pdf->SetFont('helvetica', '', 9);
			$pdf->Cell($width, 10, $row->net_sales_january ? $row->net_sales_january : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->net_sales_february ? $row->net_sales_february : '0,00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->net_sales_march ? $row->net_sales_march : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->net_sales_april ? $row->net_sales_april : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->net_sales_may ? $row->net_sales_may : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->net_sales_june ? $row->net_sales_june : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->net_sales_july ? $row->net_sales_july : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->net_sales_august ? $row->net_sales_august : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->net_sales_september ? $row->net_sales_september : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->net_sales_october ? $row->net_sales_october : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->net_sales_november ? $row->net_sales_november : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->net_sales_december ? $row->net_sales_december : '0.00', 1, 1, 'C');

			$pdf->SetFont('helvetica', 'B', 9);
			$pdf->Cell($width, 10, 'Sales Report', 1, 0, 'C');
			$pdf->SetFont('helvetica', '', 9);
			$pdf->Cell($width, 10, $row->target_sales_january ? $row->target_sales_january : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->target_sales_february ? $row->target_sales_february : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->target_sales_march ? $row->target_sales_march : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->target_sales_april ? $row->target_sales_april : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->target_sales_may ? $row->target_sales_may : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->target_sales_june ? $row->target_sales_june : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->target_sales_july ? $row->target_sales_july : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->target_sales_august ? $row->target_sales_august : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->target_sales_september ? $row->target_sales_september : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->target_sales_october ? $row->target_sales_october : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->target_sales_november ? $row->target_sales_november : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->target_sales_december ? $row->target_sales_december : '0.00', 1, 1, 'C');

			$pdf->SetFont('helvetica', 'B', 9);
			$pdf->Cell($width, 10, 'Target Sales', 1, 0, 'C');
			$pdf->SetFont('helvetica', '', 9);
			$pdf->Cell($width, 10, $row->amount_january ? $row->amount_january : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->amount_february ? $row->amount_february : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->amount_march ? $row->amount_march : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->amount_april ? $row->amount_april : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->amount_may ? $row->amount_may : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->amount_june ? $row->amount_june : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->amount_july ? $row->amount_july : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->amount_august ? $row->amount_august : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->amount_september ? $row->amount_september : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->amount_october ? $row->amount_october : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->amount_november ? $row->amount_november : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->amount_december ? $row->amount_december : '0.00', 1, 1, 'C');

			$pdf->SetFont('helvetica', 'B', 9);
			$pdf->Cell($width, 10, 'Growth', 1, 0, 'C');
			$pdf->SetFont('helvetica', '', 9);
			$pdf->Cell($width, 10, $row->growth_january ? $row->growth_january : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->growth_february ? $row->growth_february : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->growth_march ? $row->growth_march : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->growth_april ? $row->growth_april : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->growth_may ? $row->growth_may : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->growth_june ? $row->growth_june : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->growth_july ? $row->growth_july : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->growth_august ? $row->growth_august : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->growth_september ? $row->growth_september : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->growth_october ? $row->growth_october : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->growth_november ? $row->growth_november : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->growth_december ? $row->growth_december : '0.00', 1, 1, 'C');

			$pdf->SetFont('helvetica', 'B', 9);
			$pdf->Cell($width, 10, '% Achieved', 1, 0, 'C');
			$pdf->SetFont('helvetica', '', 9);
			$pdf->Cell($width, 10, $row->achieved_january ? $row->achieved_january : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->achieved_february ? $row->achieved_february : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->achieved_march ? $row->achieved_march : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->achieved_april ? $row->achieved_april : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->achieved_may ? $row->achieved_may : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->achieved_june ? $row->achieved_june : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->achieved_july ? $row->achieved_july : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->achieved_august ? $row->achieved_august : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->achieved_september ? $row->achieved_september : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->achieved_october ? $row->achieved_october : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->achieved_november ? $row->achieved_november : '0.00', 1, 0, 'C');
			$pdf->Cell($width, 10, $row->achieved_december ? $row->achieved_december : '0.00', 1, 1, 'C');
		} else {
			$data = $this->Dashboard_model->overallAscSalesReport($filters);
			
			$row = $data['data'];

			$pageWidth = $pdf->getPageWidth();
			$pageMargin = $pdf->getMargins();
			$width = ($pageWidth - $pageMargin['left'] - $pageMargin['right']) / 6;

			$pdf->SetFont('helvetica', 'B', 9);
			$pdf->Cell($width, 10, "", 1, 0, 'C');
			$pdf->Cell($width, 10, "LY Sellout", 1, 0, 'C');
			$pdf->Cell($width, 10, "Sales Report", 1, 0, 'C');
			$pdf->Cell($width, 10, "Target Sales", 1, 0, 'C');
			$pdf->Cell($width, 10, "Growth", 1, 0, 'C');
			$pdf->Cell($width, 10, "% Achieved", 1, 1, 'C');

			foreach($row as $rowData) {
				// $pdf->Cell($width, 10, "", 1, 0, 'C');
				if(!empty($rowData['asc_name'])) {
					$pdf->SetFont('helvetica', 'B', 9);
					$pdf->Cell($width, 10, $rowData['asc_name'], 1, 0, 'C');
					$pdf->SetFont('helvetica', '', 9);
					$pdf->Cell($width, 10, $rowData['total_net_sales'], 1, 0, 'C');
					$pdf->Cell($width, 10, $rowData['total_amount'], 1, 0, 'C');
					$pdf->Cell($width, 10, $rowData['total_target_sales'], 1, 0, 'C');
					$pdf->Cell($width, 10, $rowData['growth'], 1, 0, 'C');
					$pdf->Cell($width, 10, $rowData['achieved'], 1, 1, 'C');
				}
			}
		}

		$pdf->Output($title . '.pdf', 'D');
		exit;
	}

	// ================================= Header for pdf export =================================
	private function printHeader($pdf, $title) {
		$pdf->SetFont('helvetica', '', 12);
		$pdf->Cell(0, 10, 'LIFESTRONG MARKETING INC.', 0, 1, 'C');
		$pdf->SetFont('helvetica', '', 10);
		$pdf->Cell(0, 5, 'Report: ' . $title, 0, 1, 'C');
		$pdf->Ln(5);
	}


	// ================================= Display filters for pdf export =================================
	private function printFilter($pdf, $filters) {
		$pdf->SetFont('helvetica', '', 9);
		
		$pageWidth = $pdf->getPageWidth();
		$pageMargin = $pdf->getMargins();
		$width = ($pageWidth - $pageMargin['left'] - $pageMargin['right']) / count($filters);

		foreach($filters as $key => $value) {
			$pdf->Cell($width, 10, $key . ": " . $value, 0, 0, 'L');
		}
		$pdf->Ln(8);

		$pdf->Cell(0, 6, 'Generated Date: ' . date('M d, Y, h:i:s A'), 0, 1, 'L');

		$pdf->Ln(2);
		$pdf->Cell(0, 0, '', 'T');
		$pdf->Ln(4);
	}

	// ================================= Display table headers for pdf export =================================
	private function printTableHeader($pdf, $headers, $columnWidth = [], $height = 10) {
		$pageWidth = $pdf->getPageWidth();
		$pageMargin = $pdf->getMargins();
		$width = ($pageWidth - $pageMargin['left'] - $pageMargin['right']) / count($headers);

		$pdf->SetFont('helvetica', 'B', 10);
		
		if($columnWidth) {
			foreach ($headers as $key => $header) {
				$width = $columnWidth[$key];
				$pdf->MultiCell($width, $height, $header, 1, 'C', false, 0);
			}
			$pdf->Ln();
		} else {
			foreach($headers as $header) {
				$pdf->MultiCell($width, $height, $header, 1, 'C', false, 0);
			}
			$pdf->Ln();
		}

	}

	// ================================= Display table data for pdf export =================================
	private function printTableData($pdf, $header, $data, $filterData, $columnWidth = []) {
		$pageWidth = $pdf->getPageWidth();
		$pageMargin = $pdf->getMargins();
		$width = ($pageWidth - $pageMargin['left'] - $pageMargin['right']) / count($header);
		$headers = array_keys($header);

		
		foreach($data['data'] as $row) {
			if($pdf->GetY() > 180) {
				$pdf->AddPage();
				$this->printHeader($pdf, "ASC Dashboard");
				$this->printFilter($pdf, $filterData);
				$this->printTableHeader($pdf, $header, $columnWidth);
			}
			
			$pdf->SetFont('helvetica', '', 10);
			foreach($headers as $head) {
				$pdf->MultiCell($width, 10, $row->$head, 1, 'L', false, 0);
			}
			$pdf->MultiCell($width, 10, '', 0, 'C', false, 1);
		}

		$pdf->Ln();
	}

	public function generatePdfASC()
	{
		$month = date('m');
		$days = $this->getDaysInMonth($month, $this->getCurrentYear());
		$day = date('d');
		$tpr = $days - $day;

		$sort_field = $this->request->getGet('sort_field');
		$sort = $this->request->getGet('sort');
		$store = $this->request->getGet('store') ?? null;
		$area = $this->request->getGet('area') ?? null;
		$month = $this->request->getGet('month') ?? null;
		$year = $this->request->getGet('year') ?? null;
		$offset = 0;
		$limit = 10;
		$formatted_month = str_pad($month, 2, '0', STR_PAD_LEFT);
		$date = null;
		$lookup_month = null;
		$lyYear = 0;
		$selected_year = null;
		$lyMonth = null;
		$targetYear = null;

		if($year) {
			$actual_year = $this->Dashboard_model->getYear($year);
			$selected_year = $actual_year[0]['year'];
			$lyYear = $selected_year - 1;
			$date = $actual_year[0]['year'];
			$targetYear = $actual_year[0]['id'];
		}

		if($month) {
			$date = $formatted_month;
			$lyMonth = $month;
		}

		if($year && $month) {
			$actual_year = $this->Dashboard_model->getYear($year);
			$date = $actual_year[0]['year'] . '-' . $formatted_month;
		}

		if(empty($area)) {
			$area = null;
		}

		if(empty($store)) {
			$store = null;
		}

		$store = $store ?: null;
		$area = $area ?: null;
		
		$title = 'ASC_Dashboard_Report';
		
		$data = $this->Dashboard_model->tradeOverallBaData($limit, $offset, $month, $targetYear, $lyYear, $store, $area, $sort_field, $sort, $tpr, $date);
		// echo var_dump($data);
		$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator('LMI SFA');
		$pdf->SetAuthor('LIFESTRONG MARKETING INC.');
		$pdf->SetTitle('ASC Dashboard Report');
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();

		$filterData = [
			"Store" => $store ?: "ALL",
			"Area" => $area ?: "ALL",
			"Month" => $month ?: "ALL",
			"Year" => $year ?: "ALL",
			"Sort By" => $sort_field ?: "ALL",
			"Sort" => $sort ?: "ALL",
		];

		$headers = [
			"rank" => "Rank",
			"area" => "Area",
			"asc_names" => "Area Sales Coordinator",
			"actual_sales" => "Actual Sales Report",
			"target_sales" => "Target",
			"percent_ach" => "% Achieved",
			"balance_to_target" => "Balance to Target",
			"target_per_remaining_days" => "Target per Remaining Days"
		];

		$this->printHeader($pdf, "ASC Dashboard");
		$this->printFilter($pdf, $filterData);
		$this->printTableHeader($pdf, $headers);
		$this->printTableData($pdf, $headers, $data, $filterData);

		$pdf->Output($title . '.pdf', 'D');
		exit;
	}

	public function generatePdfASCDashboard()
	{
		$asc = $this->request->getGet('asc');
		$area = $this->request->getGet('area');
		$brand = $this->request->getGet('brand');
		$year = $this->request->getGet('year');
		$store = $this->request->getGet('store');
		$ba = $this->request->getGet('ba');
		$type = $this->request->getGet('type');
		$withba = $this->request->getGet('withba');
		$limit = 99999;
		$offset = 0;
		
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
		
		$ba = null;
		$store = null;
		if($latest_vmi_data){
			$month = $latest_vmi_data['month_id'];
			$year = $latest_vmi_data['year_id'];
		}
		if(empty($month)){
			$month = null;
	    }

		$dataSM = $this->Dashboard_model->asc_dashboard_table_data($year, $month, $asc, $area, 20, 30, $brand, $ba, $store, $limit, $offset, $withba);
		$dataOS =  $this->Dashboard_model->asc_dashboard_table_data($year, $month, $asc, $area, 30, null, $brand, $ba, $store, $limit, $offset, $withba);
		$dataNPD = $this->Dashboard_model->asc_dashboard_table_data_npd_hero($year, $month, $asc, $area, $brand, $ba, $store, $limit, $offset, 'npd', ['N-New Item'], $withba);
		$dataHERO = $this->Dashboard_model->asc_dashboard_table_data_npd_hero($year, $month, $asc, $area, $brand, $ba, $store, $limit, $offset, 'hero', ['A-Top 500 Pharma/Beauty', 'BU-Top 300 of 65% cum sales net of Class A Pharma/Beauty', 'B-Remaining Class B net of BU Pharma/Beauty'], $withba);

		$slowMoving = [];
		foreach($dataSM['data'] as $row) {
			$slowMoving[] = (object) array_merge((array) $row, ['sku_type' => 'slowMoving']);
		}

		$overStock = [];
		foreach($dataOS['data'] as $row) {
			$overStock[] = (object) array_merge((array) $row, ['sku_type' => 'overStock']);
		}

		$npd = [];
		foreach($dataNPD['data'] as $row) {
			$npd[] = (object) array_merge((array) $row, ['sku_type' => 'npd']);
		}

		$hero = [];
		foreach($dataHERO['data'] as $row) {
			$hero[] = (object) array_merge((array) $row, ['sku_type' => 'hero']);
		}

		$data = [
			"data" => array_merge($slowMoving, $overStock, $npd, $hero)
		];

		$title = "ASC Dashboard 1";

		$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator('LMI SFA');
		$pdf->SetAuthor('LIFESTRONG MARKETING INC.');
		$pdf->SetTitle($title);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();

		$filterData = [
			"Brand Ambassador" => $ba ?: "ALL",
			"Brand" => $brand ?: "ALL",
			"Area" => $area ?: "ALL",
			"Area Sales Coordinator" => $asc ?: "ALL",
			"Store" => $store ?: "ALL",
			"Year" => $targetYear ?: "ALL",
			"With BA" => $withba
		];

		$this->printHeader($pdf, $title);
		$this->printFilter($pdf, $filterData);

		$headers = [
			"item_name" => "Item Name",
			"sum_total_qty" => "Quantity",
			"lmi_itmcde" => "LMI Code",
			"rgdi_itmcde" => "RGDI Code",
			"sku_type" => "SKU Type",
		];

		$columnWidth = [
			"item_name" => 110,
			"sum_total_qty" => 35,
			"lmi_itmcde" => 40,
			"rgdi_itmcde" => 40,
			"sku_type" => 52,
		];

		$this->printTableHeader($pdf, $headers, $columnWidth);
		// $this->printTableData($pdf, $headers, $data, $filterData);

		$pdf->SetFont('helvetica', '', 10);
		foreach($data as $key => $value) {
			foreach($value as $data) {
				$pdf->Cell(110, 10, $data->item_name, 1, 0, 'L');
				$pdf->Cell(35, 10, $data->sum_total_qty, 1, 0, 'L');
				$pdf->Cell(40, 10, $data->lmi_itmcde, 1, 0, 'L');
				$pdf->Cell(40, 10, $data->rgdi_itmcde, 1, 0, 'L');
				$pdf->Cell(52, 10, $data->sku_type, 1, 1, 'L');
				// $pdf->MultiCell(100, 10, json_encode($data), 1, 'L', false, 1);
			}
		}

		$pdf->Output($title . '.pdf', 'D');
	}

	public function generateExcelASCDashboard() {
		$asc = $this->request->getGet('asc');
		$area = $this->request->getGet('area');
		$brand = $this->request->getGet('brand');
		$year = $this->request->getGet('year');
		$store = $this->request->getGet('store');
		$ba = $this->request->getGet('ba');
		$type = $this->request->getGet('type');
		$withba = $this->request->getGet('withba');
		$limit = 99999;
		$offset = 0;
		
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
		
		$ba = null;
		$store = null;
		if($latest_vmi_data){
			$month = $latest_vmi_data['month_id'];
			$year = $latest_vmi_data['year_id'];
		}
		if(empty($month)){
			$month = null;
	    }

		$dataSM = $this->Dashboard_model->asc_dashboard_table_data($year, $month, $asc, $area, 20, 30, $brand, $ba, $store, $limit, $offset, $withba);
		$dataOS =  $this->Dashboard_model->asc_dashboard_table_data($year, $month, $asc, $area, 30, null, $brand, $ba, $store, $limit, $offset, $withba);
		$dataNPD = $this->Dashboard_model->asc_dashboard_table_data_npd_hero($year, $month, $asc, $area, $brand, $ba, $store, $limit, $offset, 'npd', ['N-New Item'], $withba);
		$dataHERO = $this->Dashboard_model->asc_dashboard_table_data_npd_hero($year, $month, $asc, $area, $brand, $ba, $store, $limit, $offset, 'hero', ['A-Top 500 Pharma/Beauty', 'BU-Top 300 of 65% cum sales net of Class A Pharma/Beauty', 'B-Remaining Class B net of BU Pharma/Beauty'], $withba);

		$slowMoving = [];
		foreach($dataSM['data'] as $row) {
			$slowMoving[] = (object) array_merge((array) $row, ['sku_type' => 'slowMoving']);
		}

		$overStock = [];
		foreach($dataOS['data'] as $row) {
			$overStock[] = (object) array_merge((array) $row, ['sku_type' => 'overStock']);
		}

		$npd = [];
		foreach($dataNPD['data'] as $row) {
			$npd[] = (object) array_merge((array) $row, ['sku_type' => 'npd']);
		}

		$hero = [];
		foreach($dataHERO['data'] as $row) {
			$hero[] = (object) array_merge((array) $row, ['sku_type' => 'hero']);
		}

		$data = [
			"data" => array_merge($slowMoving, $overStock, $npd, $hero)
		];

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$title = "ASC Dashboard 1";

		$sheet->setCellValue('A1', 'LIFESTRONG MARKETING INC.');
		$sheet->setCellValue('A2', 'Report: ' . $title);
		$sheet->mergeCells('A1:E1');
		$sheet->mergeCells('A2:E2');

		$sheet->setCellValue('A4', 'Brand Ambassador: ' . ($ba ?: 'ALL'));
		$sheet->setCellValue('B4', 'Brand: ' . ($brand ?: 'ALL'));
		$sheet->setCellValue('C4', 'Area: ' . ($area ?: 'ALL'));

		$sheet->setCellValue('A5', 'Area Sales Coordinator: ' . ($asc ?: 'ALL'));
		$sheet->setCellValue('B5', 'Store: ' . ($store ?: 'ALL'));
		$sheet->setCellValue('C5', 'Year: ' . ($year ?: 'ALL'));

		$sheet->setCellValue('A6', 'With Ba: ' . ($withba));
		$sheet->setCellValue('B6', 'Generated Date: ' . date('M d, Y, h:i:s A'));
		
		$headers = ['Item Name', 'Quantity', 'LMI Code', 'RGDI Code', 'Type of SKU'];
	    $sheet->fromArray($headers, null, 'A8');
	    $sheet->getStyle('A8:E8')->getFont()->setBold(true);

		$rowNum = 9;
		$batchSize = 5000;
		$offset = 0;

		do {
			if(!$data || empty($data['data'])) {
				break;
			}

			foreach($data['data'] as $row) {
				$sheet->setCellValueExplicit('A' . $rowNum, $row->item_name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
				$sheet->setCellValueExplicit('B' . $rowNum, $row->sum_total_qty, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
				$sheet->setCellValueExplicit('C' . $rowNum, $row->lmi_itmcde, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
				$sheet->setCellValueExplicit('D' . $rowNum, $row->rgdi_itmcde, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
				$sheet->setCellValueExplicit('E' . $rowNum, $row->sku_type, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
				$rowNum++;
			}
		} while (count($data['data']) === $batchSize);

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	    header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
	    header('Cache-Control: max-age=0');

		foreach (range('A', 'E') as $columnID) {
	        $sheet->getColumnDimension($columnID)->setAutoSize(true);
	    }

	    $writer = new Xlsx($spreadsheet);
	    $writer->save('php://output');
	    exit;
	}

	public function generateExcelASC() {
		$month = date('m');
		$days = $this->getDaysInMonth($month, $this->getCurrentYear());
		$day = date('d');
		$tpr = $days - $day;

		$sort_field = $this->request->getGet('sort_field');
		$sort = $this->request->getGet('sort');
		$store = $this->request->getGet('store') ?? null;
		$area = $this->request->getGet('area') ?? null;
		$month = $this->request->getGet('month') ?? null;
		$year = $this->request->getGet('year') ?? null;
		$formatted_month = str_pad($month, 2, '0', STR_PAD_LEFT);
		$date = null;
		$lookup_month = null;
		$lyYear = 0;
		$selected_year = null;
		$lyMonth = null;
		$targetYear = null;
		$limit = 10;
		$offset = 0;

		if($year) {
			$actual_year = $this->Dashboard_model->getYear($year);
			$selected_year = $actual_year[0]['year'];
			$lyYear = $selected_year - 1;
			$date = $actual_year[0]['year'];
			$targetYear = $actual_year[0]['id'];
		}

		if($month) {
			$date = $formatted_month;
			$lyMonth = $month;
		}

		if($year && $month) {
			$actual_year = $this->Dashboard_model->getYear($year);
			$date = $actual_year[0]['year'] . '-' . $formatted_month;
		}

		if(empty($area)) {
			$area = null;
		}

		if(empty($store)) {
			$store = null;
		}

		$store = $store ?: null;
		$area = $area ?: null;
		
		$title = 'ASC_Dashboard_Report';
		
		$data = $this->Dashboard_model->tradeOverallBaData($limit, $offset, $month, $targetYear, $lyYear, $store, $area, $sort_field, $sort, $tpr, $date);

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'LIFESTRONG MARKETING INC.');
		$sheet->setCellValue('A2', 'Report: Info for ASC');
		$sheet->mergeCells('A1:E1');
		$sheet->mergeCells('A2:E2');

		$sheet->setCellValue('A4', 'Store: ' . ($store ?: 'ALL'));
		$sheet->setCellValue('B4', 'Area: ' . ($area ?: 'ALL'));
		$sheet->setCellValue('C4', 'Sort By: ' . ($area ?: 'ALL'));

		$sheet->setCellValue('A5', 'Month: ' . ($area ?: 'ALL'));
		$sheet->setCellValue('B5', 'Year: ' . ($area ?: 'ALL'));
		$sheet->setCellValue('C5', 'Date Generated: ' . date('M d, Y, h:i:s A'));

		$headers = ["Rank", "Area", "Area Sales Coordinator", "Actual Sales Report", "Target", "% Achieved", "Balance to Target", "Target per Remaining Days"];
		$sheet->fromArray($headers, null, 'A7');
		$sheet->getStyle('A7:H7')->getFont()->setBold(true);

		$rowNum = 8;
		foreach($data['data'] as $row) {
			$sheet->setCellValueExplicit('A' . $rowNum, $row->rank, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('B' . $rowNum, $row->area, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('C' . $rowNum, $row->asc_names, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('D' . $rowNum, $row->actual_sales, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
			$sheet->setCellValueExplicit('E' . $rowNum, $row->target_sales, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
			$sheet->setCellValueExplicit('F' . $rowNum, $row->percent_ach, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
			$sheet->setCellValueExplicit('G' . $rowNum, $row->balance_to_target, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
			$sheet->setCellValueExplicit('H' . $rowNum, $row->target_per_remaining_days, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
			$rowNum++;
		}

		foreach(range('A', 'G') as $columnID) {
			$sheet->getColumnDimension($columnID)->setAutoSize(true);
		}

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	    header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
	    header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

	public function generatePdfOverallBA() {
		$sort_field = $this->request->getGet('sort_field');
		$sort = $this->request->getGet('sort');
		$store = $this->request->getGet('store');
		$area = $this->request->getGet('area');
		$select_month = $this->request->getGet('month');
		$select_year = $this->request->getGet('year');

		$selected_year = null;
		$selected_month = null;

		if($select_year) {
			$actual_year = $this->Dashboard_model->getYear($select_year);
			$selected_year = $actual_year[0]['year'];
		}

		if($select_month) {
			$actual_month = $this->Dashboard_model->getMonth($select_month);
			$selected_month = $actual_month[0]['month'];
		}
		
		$store = $store ?: null;
		$area = $area ?: null;

		$select_year = $selected_year ?: null;
		$select_month = $selected_month  ?: null;
		
		$sort_field = $sort_field ?: 'rank';
		$sort = $sort ?: 'ASC';

		$limit = 10; 
		$offset = 0;

		$month = date('m');
		$days = $this->getDaysInMonth($month, $this->getCurrentYear());
		$day = date('d');
		$tpr = $days - $day; 


		// var_dump("sort by: + $sort_field", "asc/desc: + $sort", "store: + $store", "area: + $area", "month: + $month", "year: + $year", "area: + $area");
		// die();

		$title = 'Overall BA Report';

		$filters = [
			'Store' => $store ?: "ALL",
			'Area' => $area ?: "ALL",
			'Select Year' => $selected_year ?: "ALL",
			'Select Month' => $selected_month ?: "ALL",
			'Sort Field' => $sort_field ?: 'rank',
			'Sort' => $sort ?: 'ASC'
		];

		// var_dump($filters);
		// die();

		$headers = [
			'rank' => 'Rank',
			'store_code' => 'Store Code',
			'area' => 'Area',
			'store_name' => 'Store Name',
			'actual_sales' => 'Actual Sales',
			'target_sales' => 'Target Sales',
			'percent_ach' => '% Ach',
			'balance_to_target' => 'Balance To Target',
			'possible_incentives' => 'Possible Incetives',
			'target_per_remaining_days' => 'Target Per Remaining Days',
			'ly_scanned_data' => 'LY Scanned Data',
			'brand_ambassadors' => 'Brand Ambassador',
			'ba_deployment_dates' => 'Deployment Date',
			'brands' => 'Brand',
			'growth' => 'Growth',
		];

		$headers = [
			'rank' => 'Rank',
			'store_code' => 'Store Code',
			'area' => 'Area',
			'store_name' => 'Store Name',
			'actual_sales' => 'Actual Sales',
			'target_sales' => 'Target Sales',
			'percent_ach' => '% Ach',
			'balance_to_target' => 'Balance To Target',
			'possible_incentives' => 'Possible Incentives',
			'target_per_remaining_days' => 'Target Per Remaining Days',
			'ly_scanned_data' => 'LY Scanned Data',
			'brand_ambassadors' => 'Brand Ambassador',
			'ba_deployment_dates' => 'Deployment Date',
			'brands' => 'Brand',
			'growth' => 'Growth',
		];		

		$columnWidth = [
			'rank' => 10,
			'store_code' => 15,
			'area' => 15,
			'store_name' => 25,
			'actual_sales' => 20,
			'target_sales' => 20,
			'percent_ach' => 15,
			'balance_to_target' => 20,
			'possible_incentives' => 20,
			'target_per_remaining_days' => 25,
			'ly_scanned_data' => 20,
			'brand_ambassadors' => 25,
			'ba_deployment_dates' => 20,
			'brands' => 20,
			'growth' => 15,
		];
		

		// Initialize PDF
		$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator('LMI SFA');
		$pdf->SetAuthor('LIFESTRONG MARKETING INC.');
		$pdf->SetTitle('Overall Brand Ambassador Dashboard Report');
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();

		// Header and filter information
		$this->printHeader($pdf, $title);
		$this->printFilter($pdf, $filters);

		// Table Header
		$this->printTableHeader($pdf, $headers, $columnWidth, 14);

		// Fetch data
		$data = $this->Dashboard_model->tradeOverallBaData(
			$limit, $offset, $select_month, $select_year, null, $store, $area, $sort_field, $sort, $tpr, null
		);

		if ($data) {
			$pdf->SetFont('helvetica', '', 10);

			// echo '<pre>';
			// print_r($data);
			// echo '</pre>';
			// die();
			
			foreach ($data['data'] as $row) {
				$lineHeight = 6;
			
				$cells = [
					['w' => 10,  't' => $row->rank],
					['w' => 15,  't' => $row->store_code],
					['w' => 15,  't' => $row->area],
					['w' => 25,  't' => $row->store_name],
					['w' => 20,  't' => $row->actual_sales],
					['w' => 20,  't' => $row->target_sales],
					['w' => 15,  't' => $row->percent_ach],
					['w' => 20,  't' => $row->balance_to_target],
					['w' => 20,  't' => $row->possible_incentives],
					['w' => 25,  't' => $row->target_per_remaining_days],
					['w' => 20,  't' => $row->ly_scanned_data],
					['w' => 25,  't' => $row->brand_ambassadors],
					['w' => 20,  't' => $row->ba_deployment_dates],
					['w' => 20,  't' => $row->brands],
					['w' => 15,  't' => $row->growth],
				];
				
				// Determine the max row height
				$maxLines = 1;
				foreach ($cells as $cell) {
					$lines = $pdf->getNumLines($cell['t'], $cell['w']);
					if ($lines > $maxLines) $maxLines = $lines;
				}
				$rowHeight = $lineHeight * $maxLines;
			
				// Page break if needed
				if ($pdf->GetY() + $rowHeight > $pdf->getPageHeight() - $pdf->getBreakMargin()) {
					$pdf->AddPage();
					$this->printHeader($pdf, $title);
					$this->printFilter($pdf, $filters);
					$this->printTableHeader($pdf, $headers, $columnWidth, 14);
					$pdf->SetFont('helvetica', '', 10);
				}
			
				$startX = $pdf->GetX();
				$startY = $pdf->GetY();
			
				foreach ($cells as $cell) {
					$pdf->SetXY($startX, $startY);
					$pdf->MultiCell($cell['w'], $rowHeight, $cell['t'], 1, 'C', false, 0, '', '', true, 0, false, true, $rowHeight, 'M');
					$startX += $cell['w'];
				}
			
				$pdf->Ln($rowHeight);
			}
		}

		$pdf->Output($title . '.pdf', 'D');
		exit;
	}

	public function generateExcelOverallBA(){
		$sort_field = $this->request->getGet('sort_field');
		$sort = $this->request->getGet('sort');
		$store = $this->request->getGet('store');
		$area = $this->request->getGet('area');
		$select_month = $this->request->getGet('month');
		$select_year = $this->request->getGet('year');

		$selected_year = null;
		$selected_month = null;

		if($select_year) {
			$actual_year = $this->Dashboard_model->getYear($select_year);
			$selected_year = $actual_year[0]['year'];
		}

		if($select_month) {
			$actual_month = $this->Dashboard_model->getMonth($select_month);
			$selected_month = $actual_month[0]['month'];
		}
		
		$store = $store ?: null;
		$area = $area ?: null;

		$select_year = $selected_year ?: null;
		$select_month = $selected_month  ?: null;
		
		$sort_field = $sort_field ?: 'rank';
		$sort = $sort ?: 'ASC';

		$limit = 10; 
		$offset = 0;

		$title = 'Overall BA Report';

		$spreadsheet = new Spreadsheet();
	    $sheet = $spreadsheet->getActiveSheet();

	    $sheet->setCellValue('A1', 'LIFESTRONG MARKETING INC.');
	    $sheet->setCellValue('A2', 'Report: BA Dashboard');
	    $sheet->mergeCells('A1:E1');
	    $sheet->mergeCells('A2:E2');

	    $sheet->setCellValue('A4', 'Store: ' . ($store ?: 'ALL'));
	    $sheet->setCellValue('B4', 'Area: ' . ($area ?: 'ALL'));
	    $sheet->setCellValue('C4', 'Month: ' . ($select_month ?: 'ALL'));

	    $sheet->setCellValue('A5', 'Year: ' . ($select_year ?: 'ALL'));
	    $sheet->setCellValue('B5', 'Sort By: ' . ($sort_field ?: ''));
		$sheet->setCellValue('C5', 'Sort By: ' . ($sort ?: ''));
	    $sheet->setCellValue('D5', 'Date Generated: ' . date('M d, Y, h:i:s A'));

	    $headers = ['Rank', 'Store Code', 'Area', 'Store Name', 'Actual Sales', 'Target', '% Ach', 'Balance to Target', 'Possible Incentives', 'Target per Remaining Days', 'Ly Scanned Data', 'Brand Ambassador', 'Deployed Date', 'Brand', 'Growth'];
	    $sheet->fromArray($headers, null, 'A7');
	    $sheet->getStyle('A7:O7')->getFont()->setBold(true);

	    $rowNum = 8;
	    $batchSize = 5000;
	    $offset = 0;

		$month = date('m');
		$days = $this->getDaysInMonth($month, $this->getCurrentYear());
		$day = date('d');
		$tpr = $days - $day; 

		do {
	        $data = $this->Dashboard_model->tradeOverallBaData(
				$limit, $offset, $select_month, $select_year, null, $store, $area, $sort_field, $sort, $tpr, null
			);

	        if (!$data || empty($data['data'])) {
	            break;
	        }

	        foreach ($data['data'] as $row) {
	            $sheet->setCellValueExplicit('A' . $rowNum, $row->rank, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
				$sheet->setCellValueExplicit('B' . $rowNum, $row->store_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
				$sheet->setCellValueExplicit('C' . $rowNum, $row->area, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
				$sheet->setCellValueExplicit('D' . $rowNum, $row->store_name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
				$sheet->setCellValueExplicit('E' . $rowNum, $row->actual_sales, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
				$sheet->setCellValueExplicit('F' . $rowNum, $row->target_sales, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
				$sheet->setCellValueExplicit('G' . $rowNum, $row->percent_ach, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
				$sheet->setCellValueExplicit('H' . $rowNum, $row->balance_to_target, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
				$sheet->setCellValueExplicit('I' . $rowNum, $row->possible_incentives, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
				$sheet->setCellValueExplicit('J' . $rowNum, $row->target_per_remaining_days, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
				$sheet->setCellValueExplicit('K' . $rowNum, $row->ly_scanned_data, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
				$sheet->setCellValueExplicit('L' . $rowNum, $row->brand_ambassadors, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
				$sheet->setCellValueExplicit('M' . $rowNum, $row->ba_deployment_dates, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
				$sheet->setCellValueExplicit('N' . $rowNum, $row->brands, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
				$sheet->setCellValueExplicit('O' . $rowNum, $row->growth, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);

				$rowNum++;
	        }

	        $offset += $batchSize;
	    } while (count($data['data']) === $batchSize);

		foreach (range('A', 'O') as $columnID) {
			$sheet->getColumnDimension($columnID)->setAutoSize(true);
		}

	    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	    header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
	    header('Cache-Control: max-age=0');

	    $writer = new Xlsx($spreadsheet);
	    $writer->save('php://output');
	    exit;
	}


}
