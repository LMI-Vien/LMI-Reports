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


}
