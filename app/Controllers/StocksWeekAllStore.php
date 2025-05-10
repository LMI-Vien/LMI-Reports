<?php

namespace App\Controllers;

use Config\Database;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StocksWeekAllStore extends BaseController
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

	public function dataWeekAllStore()
	{
		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);

		$data['title'] = "Trade Dashboard";
		$data['PageName'] = 'Trade Dashboard';
		$data['PageUrl'] = 'Trade Dashboard';
		$data["breadcrumb"] = array('Stocks' => base_url('stocks/data-week-all-store'),'Week by Week Stock Data of all Stores' => '');
		$data["source"] = "VMI";
		$data["source_date"] = '';
		$data['content'] = "site/stocks/week-all-store/data_week_all_store";
		$data['brand_ambassador'] = $this->Global_model->getBrandAmbassador(0);
		$data['store_branch'] = $this->Global_model->getStoreBranch(0);
		$data['month'] = $this->Global_model->getMonths();
		$data['year'] = $this->Global_model->getYears();
		$data['session'] = session();
		$data['js'] = array(
			"assets/site/bundle/js/bundle.min.js"
                    );
        $data['css'] = array(
        	"assets/site/bundle/css/bundle.min.css"
                    );
		return view("site/layout/template", $data);
	}

	public function getDataWeekAllStore()
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
