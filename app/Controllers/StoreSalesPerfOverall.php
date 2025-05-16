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
		$data["breadcrumb"] = array('Store' => base_url('store/sales-overall-performance'),'Overall Stores Sales Performance' => '');
		$data["source"] = "Scan Data(LMI/RGDI)";
		$data["source_date"] = '<span id="sourceDate">N / A</span>';	
		$data['content'] = "site/store/perf-overall/sales_overall_performance";
		$data['session'] = session();
		$data['js'] = array(
			"assets/site/bundle/js/bundle.min.js"
                    );
        $data['css'] = array(
        	"assets/site/bundle/css/bundle.min.css"
                    );
		return view("site/layout/template", $data);
	}


	public function getPerfPerOverall()
	{	
		$areaId = trim($this->request->getPost('area'));
		$areaId = $areaId === '' ? null : $areaId;
		$ascId = trim($this->request->getPost('asc'));
		$ascId = $ascId === '' ? null : $ascId;
		$baTypeId = trim($this->request->getPost('baType'));
		$baTypeId = $baTypeId === '' ? null : $baTypeId;
		$baId = trim($this->request->getPost('ba'));
		$baId = $baId === '' ? null : $baId;
		$storeCode = trim($this->request->getPost('store'));
		$storeCode = $storeCode === '' ? null : $storeCode;
        $brandCategoriesIds = $this->request->getPost('brandCategories');
        $brandCategoriesIds = $brandCategoriesIds === '' ? null : $brandCategoriesIds;
        $brandIds = $this->request->getPost('brands');
        $brandIds = $brandIds === '' ? null : $brandIds;
	    $yearId = $this->request->getPost('year')?? 0;            
	    $monthId = $this->request->getVar('month_start') ?? 1;
	    $monthEndId = $this->request->getVar('month_end') ?? 12;
		$limit = $this->request->getVar('limit');
		$offset = $this->request->getVar('offset');
		$limit = is_numeric($limit) ? (int)$limit : 10;
		$offset = is_numeric($offset) ? (int)$offset : 0;

		$orderColumnIndex = $this->request->getVar('order')[0]['column'] ?? 0;
	    $orderDirection = $this->request->getVar('order')[0]['dir'] ?? 'asc';
	    $columns = $this->request->getVar('columns');
	    $orderByColumn = $columns[$orderColumnIndex]['data'] ?? 'store_name';

	    //$this->Dashboard_model->refreshPreAggregatedDataScanData();	
	    $data = $this->Dashboard_model->getStorePerformance($monthId, $monthEndId, $yearId, $limit, $offset, $areaId, $ascId, $storeCode, $baId, $baTypeId, $brandCategoriesIds, $brandIds, $orderByColumn, $orderDirection);

	    return $this->response->setJSON([
	        'draw' => intval($this->request->getVar('draw')),
	        'recordsTotal' => $data['total_records'],
	        'recordsFiltered' => $data['total_records'],
	        'data' => $data['data']
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
