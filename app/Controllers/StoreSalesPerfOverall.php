<?php

namespace App\Controllers;

use Config\Database;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StoreSalesPerfOverall extends BaseController
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

	public function perfPerOverall()
	{
		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);

		$data['month'] = $this->Global_model->getMonths();
		$data['year'] = $this->Global_model->getYears();
		$data['title'] = "Trade Dashboard";
		$data['PageName'] = 'Trade Dashboard';
		$data['PageUrl'] = 'Trade Dashboard';
		$data["breadcrumb"] = array('Store' => base_url('store/sales-overall-performance'),'Overall Stores Sales Performance' => '');
		$data["source"] = "Scan Data";
		$data["source_date"] = 'Monthly(temp)';	
		$data['content'] = "site/store/perf-overall/sales-overall-performance";
		$data['js'] = array(
                    );
        $data['css'] = array(
                    );
		return view("site/layout/template", $data);
	}


	public function getPerfPerOverall()
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

	public function generatePdf()
	{	
		//to be added
	}


	public function generateExcel()
	{
		//to be added
	}
}
