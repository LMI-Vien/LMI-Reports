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
		
		// print_r($data);
		// die();
		$data['title'] = "Trade Dashboard";
		$data['PageName'] = 'Trade Dashboard';
		$data['PageUrl'] = 'Trade Dashboard';
		$data['content'] = "site/trade/ba.php";
		$data['js'] = array(
			// "assets/js/jquery-3.7.1.min.js",
			// "assets/js/moment.min.js",
			// "assets/js/jquery.tablesorter.min.js",
			// "assets/js/daterangepicker.min.js",
			// "assets/js/bootstrap.min.js",
			// "assets/site/js/custom.js",
			// "assets/site/js/charts.js"
                    );
        $data['css'] = array(
        	// "assets/css/bootstrap.min.css",
			// "assets/site/css/dashboard/style-common.css",
			// "assets/site/css/dashboard/style-header.css",
			// "assets/site/css/all.min.css",
			// "assets/site/css/css.css",
			//"assets/site/css/dashboard/style-footer.css",
			//"assets/site/css/dashboard/dashboard.css"
			//"assets//css/daterangepicker.css"
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
		$data['weeks'] = $this->Global_model->get_weeks();
		// print_r($data);
		// die();
		$data['title'] = "Trade Dashboard";
		$data['PageName'] = 'Trade Dashboard';
		$data['PageUrl'] = 'Trade Dashboard';
		$data['content'] = "site/trade/overall_ba.php";
		$data['js'] = array(
			// "assets/js/jquery-3.7.1.min.js",
			// "assets/js/moment.min.js",
			// "assets/js/jquery.tablesorter.min.js",
			// "assets/js/daterangepicker.min.js",
			// "assets/js/bootstrap.min.js",
			// "assets/site/js/custom.js",
			// "assets/site/js/charts.js"
                    );
        $data['css'] = array(
        	// "assets/css/bootstrap.min.css",
			// "assets/site/css/dashboard/style-common.css",
			// "assets/site/css/dashboard/style-header.css",
			// "assets/site/css/all.min.css",
			// "assets/site/css/css.css",
			//"assets/site/css/dashboard/style-footer.css",
			//"assets/site/css/dashboard/dashboard.css"
			//"assets//css/daterangepicker.css"
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
		$data['title'] = "Trade Dashboard";
		$data['PageName'] = 'Trade Dashboard';
		$data['PageUrl'] = 'Trade Dashboard';
		$data['content'] = "site/trade/asc.php";
		$data['store_branch'] = $this->Global_model->get_store_branch(0);
		$data['area'] = $this->Global_model->get_area(0);
		$data['js'] = array(
			// "assets/js/jquery-3.7.1.min.js",
			// "assets/js/moment.min.js",
			// "assets/js/jquery.tablesorter.min.js",
			// "assets/js/daterangepicker.min.js",
			// "assets/js/bootstrap.min.js",
			// "assets/site/js/custom.js",
			// "assets/site/js/charts.js"
                    );
        $data['css'] = array(
        	// "assets/css/bootstrap.min.css",
			// "assets/site/css/dashboard/style-common.css",
			// "assets/site/css/dashboard/style-header.css",
			// "assets/site/css/all.min.css",
			// "assets/site/css/css.css",
			//"assets/site/css/dashboard/style-footer.css",
			//"assets/site/css/dashboard/dashboard.css"
			//"assets//css/daterangepicker.css"
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
		$data['title'] = "Trade Dashboard";
		$data['PageName'] = 'Trade Dashboard';
		$data['PageUrl'] = 'Trade Dashboard';
		$data['content'] = "site/trade/overall_asc.php";
		$data['asc'] = $this->Global_model->get_asc(0);
		$data['area'] = $this->Global_model->get_area(0);
		$data['brand'] = $this->Global_model->get_brand_data("ASC", 10, 0);
		$data['js'] = array(
			// "assets/js/jquery-3.7.1.min.js",
			// "assets/js/moment.min.js",
			// "assets/js/jquery.tablesorter.min.js",
			// "assets/js/daterangepicker.min.js",
			// "assets/js/bootstrap.min.js",
			// "assets/site/js/custom.js",
			// "assets/site/js/charts.js"
                    );
        $data['css'] = array(
        	// "assets/css/bootstrap.min.css",
			// "assets/site/css/dashboard/style-common.css",
			// "assets/site/css/dashboard/style-header.css",
			// "assets/site/css/all.min.css",
			// "assets/site/css/css.css",
			//"assets/site/css/dashboard/style-footer.css",
			//"assets/site/css/dashboard/dashboard.css"
			//"assets//css/daterangepicker.css"
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
			// "assets/js/jquery-3.7.1.min.js",
			// "assets/js/moment.min.js",
			// "assets/js/jquery.tablesorter.min.js",
			// "assets/js/daterangepicker.min.js",
			// "assets/js/bootstrap.min.js",
			// "assets/site/js/custom.js",
			// "assets/site/js/charts.js"
                    );
        $data['css'] = array(
        	// "assets/css/bootstrap.min.css",
			// "assets/site/css/dashboard/style-common.css",
			// "assets/site/css/dashboard/style-header.css",
			// "assets/site/css/all.min.css",
			// "assets/site/css/css.css",
			//"assets/site/css/dashboard/style-footer.css",
			//"assets/site/css/dashboard/dashboard.css"
			//"assets//css/daterangepicker.css"
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
			// "assets/js/jquery-3.7.1.min.js",
			// "assets/js/moment.min.js",
			// "assets/js/jquery.tablesorter.min.js",
			// "assets/js/daterangepicker.min.js",
			// "assets/js/bootstrap.min.js",
			// "assets/site/js/custom.js",
			// "assets/site/js/charts.js"
                    );
        $data['css'] = array(
        	// "assets/css/bootstrap.min.css",
			// "assets/site/css/dashboard/style-common.css",
			// "assets/site/css/dashboard/style-header.css",
			// "assets/site/css/all.min.css",
			// "assets/site/css/css.css",
			//"assets/site/css/dashboard/style-footer.css",
			//"assets/site/css/dashboard/dashboard.css"
			//"assets//css/daterangepicker.css"
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
			// "assets/js/jquery-3.7.1.min.js",
			// "assets/js/moment.min.js",
			// "assets/js/jquery.tablesorter.min.js",
			// "assets/js/daterangepicker.min.js",
			// "assets/js/bootstrap.min.js",
			// "assets/site/js/custom.js",
			// "assets/site/js/charts.js"
                    );
        $data['css'] = array(
        	// "assets/css/bootstrap.min.css",
			// "assets/site/css/dashboard/style-common.css",
			// "assets/site/css/dashboard/style-header.css",
			// "assets/site/css/all.min.css",
			// "assets/site/css/css.css",
			//"assets/site/css/dashboard/style-footer.css",
			//"assets/site/css/dashboard/dashboard.css"
			//"assets//css/daterangepicker.css"
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
			// "assets/js/jquery-3.7.1.min.js",
			// "assets/js/moment.min.js",
			// "assets/js/jquery.tablesorter.min.js",
			// "assets/js/daterangepicker.min.js",
			// "assets/js/bootstrap.min.js",
			// "assets/site/js/custom.js",
			// "assets/site/js/charts.js"
                    );
        $data['css'] = array(
        	// "assets/css/bootstrap.min.css",
			// "assets/site/css/dashboard/style-common.css",
			// "assets/site/css/dashboard/style-header.css",
			// "assets/site/css/all.min.css",
			// "assets/site/css/css.css",
			//"assets/site/css/dashboard/style-footer.css",
			//"assets/site/css/dashboard/dashboard.css"
			//"assets//css/daterangepicker.css"
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
	    //echo $sort_field;

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
	    }
	}

	public function trade_overall_ba()
	{
	    $limit = $this->request->getVar('limit') ?? 10;
	    $offset = $this->request->getVar('offset') ?? 0;
	    $store = $this->request->getVar('store');
	    $area = $this->request->getVar('area');
	    $month = $this->request->getVar('month');
	    $year = $this->request->getVar('year');
	    $sort = $this->request->getVar('sort') ?? 'ASC';
	    $sort_field = $this->request->getVar('sort_field');



	    $data = $this->Dashboard_model->tradeOverallBaData(null, null, null, null, null, 'ASC', 10, 0);
	    //echo "<pre>";
	    // print_r($data);
	    // die();
	    //echo $sort_field;

	   // if($latest_vmi_data){

		    return $this->response->setJSON([
		        'draw' => intval($this->request->getVar('draw')),
		        'recordsTotal' => $data['total_records'],
		        'recordsFiltered' => $data['total_records'],
		        'data' => $data['data'],
		    ]);
	   // }
	}

}
