<?php

namespace App\Controllers;

use Config\Database;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StocksAllStore extends BaseController
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

	public function dataAllStore()
	{	

	// log_activity('Inventory', 'Sync', 'Successfully Sync Tracc to Ginee Inventory!
	// Saving Time : 
	// Start : 2025-01-09 03:38:08 PM
	// End : 2025-01-09 03:38:09 PM
	// Duration : 0 Hours, 0 Minutes, 1 Seconds.
	// Process Items : 
	// Date Encoded : 2025-01-09
	// Date Modified : 2025-01-09

	// Details
	// SKU Code	Item Description	Warehouse Location	Tracc Inventory	Ginee Inventory	
	// CD020	Cathy Doll Aqua Non Greasy Body Sun Serum SPF50 10ml	ONLINE	337	252	
	// CD021	Cathy Doll Aura Whitening Serum Foam Cleanser 100ml	ONLINE	180	20
	// ');

		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);
		$data['month'] = $this->Global_model->getMonths();
		$data['week'] = $this->Global_model->getWeeks();
		$data['itemClassi'] = $this->Global_model->getItemClassification();
		$data['title'] = "Trade Dashboard";
		$data['PageUrl'] = 'Trade Dashboard';
		$siteMenuData = $this->Global_model->get_by_menu_url('stocks/data-all-store');
		if($siteMenuData){
			$data["breadcrumb"] = array('Stocks' => base_url('stocks/data-all-store'), $siteMenuData[0]->menu_name => '');
			//static
			$data["source"] = "VMI";
			//get recent week
			$data["source_date"] = 'Calendar week 1';
			$data["pageName"] = $siteMenuData[0]->menu_name;			
		}else{
			$data["breadcrumb"] = array('Stocks' => base_url('stocks/data-all-store'),'Overall Stock Data of all Stores' => '');
			$data["source"] = "VMI";
			$data["source_date"] = 'Calendar week 1';
			$data["pageName"] = '';			
		}

		$data['content'] = "site/stocks/all-store/data_all_store";
		$data['asc'] = $this->Global_model->getAsc(0);
		$data['area'] = $this->Global_model->getArea(0);
		$data['brand'] = $this->Global_model->getBrandData("ASC", 99999, 0);
		$data['store_branch'] = $this->Global_model->getStoreBranch(0);
		$data['brandAmbassador'] = $this->Global_model->getBrandAmbassador(0);
		$data['company'] = $this->Global_model->getCompanies(0);
		$data['brandLabel'] = $this->Global_model->getBrandLabelData(0);
		$data['session'] = session();
		$data['js'] = array(
			"assets/site/bundle/js/bundle.min.js"
                    );
        $data['css'] = array(
        	"assets/site/bundle/css/bundle.min.css"
                    );
		return view("site/layout/template", $data);
	}

	public function getDataAllStore()
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
	    
	    // return $this->response->setJSON([
	    //     'draw' => intval($this->request->getVar('draw')),
	    //     'recordsTotal' => $data['total_records'],
	    //     'recordsFiltered' => $data['total_records'],
	    //     'data' => $data['data']
	    // ]);	
	    return $this->response->setJSON([
	        'draw' => intval($this->request->getVar('draw')),
	        'recordsTotal' => 0,
	        'recordsFiltered' => 0,
	        'data' => []
	    ]);	
	}

}
