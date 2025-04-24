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

		$data['area'] = $this->Global_model->getArea(0);
		$data['store_branch'] = $this->Global_model->getStoreBranch(0);
		$data['month'] = $this->Global_model->getMonths();
		$data['year'] = $this->Global_model->getYears();
		$data['title'] = "Trade Dashboard";
		$data['PageName'] = 'Trade Dashboard';
		$data['PageUrl'] = 'Trade Dashboard';

		$data["breadcrumb"] = array('Store' => base_url('store/sales-performance-per-ba'),'Store Sales Performance per Brand Ambassador' => '');
		$data["source"] = "Actual Sales Report / Scan Data";
		$data["source_date"] = 'Monthly(temp)';	
		$data['content'] = "site/store/perf-per-ba/sales-performance-per-ba";
		$data['js'] = array(
                    );
        $data['css'] = array(
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
	     $data = $this->Dashboard_model->tradeOverallBaData($limit, $offset, $month, $targetYear, $lyYear, $store, $area, $sort_field, $sort, $tpr, $date);
	    // return $this->response->setJSON([
	    //     'draw' => intval($this->request->getVar('draw')),
	    //     'recordsTotal' => $data['total_records'],
	    //     'recordsFiltered' => $data['total_records'],
	    //     'data' => $data['data'],
	    // ]);
	    return $this->response->setJSON([
	        'draw' => intval($this->request->getVar('draw')),
	        'recordsTotal' => 0,
	        'recordsFiltered' => 0,
	        'data' => []
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
