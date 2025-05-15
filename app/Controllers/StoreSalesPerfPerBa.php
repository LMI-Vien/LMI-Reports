<?php

namespace App\Controllers;

use Config\Database;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StoreSalesPerfPerBa extends BaseController
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

	public function perfPerBa()
	{
		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);

		$data['months'] = $this->Global_model->getMonths();
		$data['year'] = $this->Global_model->getYears();
		$data['brand_ambassadors'] = $this->Global_model->getBrandAmbassador(0);
		$data['store_branches'] = $this->Global_model->getStoreBranch(0);
		$data['brands'] = $this->Global_model->getBrandData("ASC", 99999, 0);
		$data['asc'] = $this->Global_model->getAsc(0);
		$data['areas'] = $this->Global_model->getArea(0);
		$data['brandLabel'] = $this->Global_model->getBrandLabelData(0);
		$data['title'] = "Trade Dashboard";
		$data['PageName'] = 'Trade Dashboard';
		$data['PageUrl'] = 'Trade Dashboard';

		$data["breadcrumb"] = array('Store' => base_url('store/sales-performance-per-ba'),'Store Sales Performance per Brand Ambassador' => '');
		$data["source"] = "Actual Sales Report, Scan Data and Target Sales Per Store (LMI/RGDI)";
		$data["source_date"] = '<span id="sourceDate">N / A</span>';	
		$data['content'] = "site/store/perf-per-ba/sales_performance_per_ba";
		$data['session'] = session();
		$data['js'] = array(
			"assets/site/bundle/js/bundle.min.js"
                    );
        $data['css'] = array(
        	"assets/site/bundle/css/bundle.min.css"
                    );
		return view("site/layout/template", $data);
	}

	public function getPerfPerBa()
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
	    $lyYear = 2020;
	    $targetYear = 2020;
	    $month = 1;
	    // print_r($store);
	    // print_r($area);
	    // die();
	    //dito param para sa category brand
	    $date = "2025-03";



	    //get these values from syspar
	    //$brand_category = [9];
	    $brand_category = null;
	    $incentiveRate = 0.015;
	    $data = $this->Dashboard_model->tradeOverallBaData($limit, $offset, $incentiveRate, $month, $targetYear, $lyYear, $store, $area, $sort_field, $sort, $tpr, $date, $brand_category);

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

	public function generatePdf()
	{	
		//to follow
	}

	public function generateExcel()
	{
		//to follow
	}
}
