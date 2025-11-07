<?php

namespace App\Controllers;

use Config\Database;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PromoAnalysis extends BaseController
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

	public function promoTable()
	{	
		$uri = current_url(true);
		$data['uri'] = $uri;

		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);
		$data['title'] = "Promo Analysis";
		$data['PageName'] = 'Promo Analysis';
		$data['PageUrl'] = 'Promo Analysis';
		$data["breadcrumb"] = array('Promo Analysis' => base_url('promo-analysis/get-promo-table'),'Promo Analysis' => '');
		$data["source"] = "VMI / Scan Data";
		$data["source_date"] = '<span id="sourceDate">N / A</span>';
		$data["foot_note"] = '';		

		$data['content'] = "site/promo_analysis/promo_table/promo_table";
		$data['brands'] = $this->Global_model->getBrandData("ASC", 4000, 0);
		$data['brandLabel'] = $this->Global_model->getBrandLabelData(0);
		$data['months'] = $this->Global_model->getMonths();
		$data['year'] = $this->Global_model->getYears();

		$data['sku_item'] = $this->Global_model->getDistinctVmiData('sku', 20);
		$data['variants'] = $this->Global_model->getDistinctVmiData('variant', 20);
		$data['stores']   = $this->Global_model->getDistinctVmiData('store', 20);
		$data['session'] = session();
		$data['js'] = array(
			"assets/site/bundle/js/bundle.min.js",
			"assets/site/js/chart.min.js",
			"assets/site/js/common.js"
                    );
        $data['css'] = array(
        	"assets/site/bundle/css/bundle.min.css",
        	"assets/site/css/common.css"
                    );
		return view("site/layout/template", $data);
	}


	public function getPromoDataVmi(){

		// $preWeekStart = 4;
		// $preWeekEnd = 4;
		// $postWeekStart = 6;
		// $postWeekEnd = 6;
		// $latestYear = 6;
	   
		$orderDirection = strtoupper($orderDirection);
		//$skus = ['WC002', 'WC001', 'DA001'];
		$data = $this->Dashboard_model->getPromoTableVmi($preWeekStart, $preWeekEnd, $postWeekStart, $postWeekEnd, $latestYear, $orderByColumn, $orderDirection, $limit, $offset, $skus, $variantName, $brandIds, $brandLabelTypeIds, $storeCodes, $searchValue);
		
	    return $this->response->setJSON([
	        'draw' => intval($this->request->getVar('draw')),
	        'recordsTotal' => $data['total_records'],
	        'recordsFiltered' => $data['total_records'],
	        'data' => $data['data'],
	    ]);	
	}


	public function getPromoDataScannData()
	{	
		// $year = '2025';
		// $preMonthId = 1;
		// $preMonthEndId = 6;
		// $postMonthId = 7;
		// $postMonthEndId = 7;

	//	$skus = ['WC002', 'WC001', 'DA001'];
	    $data = $this->Dashboard_model->getPromoTableScannData($preMonthId, $preMonthEndId, $postMonthId, $postMonthEndId, $orderByColumn, $orderDirection, $year, $limit, $offset, $skus, $variantName, $brandIds, $brandLabelTypeIds, $storeCodes, $searchValue);

	    return $this->response->setJSON([
	        'draw' => intval($this->request->getVar('draw')),
	        'recordsTotal' => $data['total_records'],
	        'recordsFiltered' => $data['total_records'],
	        'data' => $data['data']
	    ]);
	}

	public function getPromoDataAll()
	{

		$type = $this->request->getPost('type'); // get if pdf or excel
		$type = $type === '' ? null : $type;

		$isExport = $this->request->getPost('is_export');
		$isExport = $isExport === '' ? false : $isExport ;

		$skus = $this->request->getPost('items');
		$skus = $skus === '' ? null : $skus;

		$variantName = $this->request->getPost('variant_name');
		$variantName = $variantName === '' ? null : $variantName ;

		$brandIds = $this->request->getPost('brands');
		$brandIds = $brandIds === '' ? null : $brandIds;

		$brandLabelTypeIds = $this->request->getPost('brands_label');
		$brandLabelTypeIds = $brandLabelTypeIds === '' ? null : $brandLabelTypeIds;

		$storeCodes = $this->request->getPost('store_codes');
		$storeCodes = $storeCodes === '' ? null : $storeCodes;

		$year = trim($this->request->getPost('year') ?? '');
		$year = $year === '' ? null : $year;

		$yearId = trim($this->request->getPost('year_id') ?? '');
		$yearId = $yearId === '' ? null : $yearId;

	    $preMonthId = $this->request->getVar('pre_month_start') ?? 1;
	    $preMonthEndId = $this->request->getVar('pre_month_end') ?? 12;

	    $postMonthId = $this->request->getVar('post_month_start') ?? 1;
	    $postMonthEndId = $this->request->getVar('post_month_end') ?? 12;

		$preWeekStart = trim($this->request->getPost('pre_week_start') ?? '');
		$preWeekStart = $preWeekStart === '' ? null : $preWeekStart;

		$preWeekEnd = trim($this->request->getPost('pre_week_end') ?? '');
		$preWeekEnd = $preWeekEnd === '' ? null : $preWeekEnd;

		$preWeekStartDate = trim($this->request->getPost('pre_week_start_date') ?? '');
		$preWeekStartDate = $preWeekStartDate === '' ? null : $preWeekStartDate;

		$preWeekEndDate = trim($this->request->getPost('pre_week_end_date') ?? '');
		$preWeekEndDate = $preWeekEndDate === '' ? null : $preWeekEndDate;

		$postWeekStart = trim($this->request->getPost('post_week_start') ?? '');
		$postWeekStart = $postWeekStart === '' ? null : $postWeekStart;

		$postWeekEnd = trim($this->request->getPost('post_week_end') ?? '');
		$postWeekEnd = $postWeekEnd === '' ? null : $postWeekEnd;

		$postWeekStartDate = trim($this->request->getPost('post_week_start_date') ?? '');
		$postWeekStartDate = $postWeekStartDate === '' ? null : $postWeekStartDate;

		$postWeekEndDate = trim($this->request->getPost('post_week_end_date') ?? '');
		$postWeekEndDate = $postWeekEndDate === '' ? null : $postWeekEndDate;

		$limit = $this->request->getVar('limit');
		$offset = $this->request->getVar('offset');
		$limit = is_numeric($limit) ? (int)$limit : 10;
		$offset = is_numeric($offset) ? (int)$offset : 0;

		$orderColumnIndex = $this->request->getVar('order')[0]['column'] ?? 0;
	    $orderDirection = $this->request->getVar('order')[0]['dir'] ?? 'asc';
	    $columns = $this->request->getVar('columns');
	    $orderByColumn = $columns[$orderColumnIndex]['data'] ?? 'itmcde';

	    $searchValue = trim($this->request->getVar('search')['value'] ?? '');
		$searchValue = $searchValue === '' ? null : $searchValue;
		
		// $preWeekStart = 4;
		// $preWeekEnd = 4;
		// $postWeekStart = 6;
		// $postWeekEnd = 7;
		// $yearId = 6;
		// $year = '2025';
		// $preMonthId = 1;
		// $preMonthEndId = 6;
		// $postMonthId = 7;
		// $postMonthEndId = 9;
		//print_r();

		// var_dump($skus);
		// die();
		//$skus = ['WC002', 'WC001', 'DA001'];
		//$skus = "'" . implode("','", $skus) . "'";
		// print_r($variantName);
		// die();
		//$variantName = "BODY TREATS FRMNG HYRDRGEL EYE PATCHX3S";
	    $data = $this->Dashboard_model->getPromoDataAllClickhouse($year, $yearId, $preWeekStart, $preWeekEnd, $postWeekStart, $postWeekEnd, $preMonthId, $preMonthEndId, $postMonthId, $postMonthEndId, $orderByColumn, $orderDirection, 99999999, $offset, $skus, $variantName, $brandIds, $brandLabelTypeIds, $storeCodes, $searchValue);
	    if($isExport){
	    	//call the export function here(pdf/excel)
	    	if($type === 'pdf'){
	    		//generatePdf
	    	}else{
	    		//generateExcel
	    	}
	    }else{
		    return $this->response->setJSON([
				'pre_week_days' => $data['pre_week_days'],
		        'post_week_days'=> $data['post_week_days'],
		        'pre_month_days' => $data['pre_month_days'],
		        'post_month_days' => $data['post_month_days'],
		        'data' => $data['data']
		    ]);	
	    }
	    
	}


	public function getPromoDataAllOld()
	{

		$type = $this->request->getPost('type'); // get if pdf or excel
		$type = $type === '' ? null : $type;

		$isExport = $this->request->getPost('is_export');
		$isExport = $isExport === '' ? false : $isExport ;

		$skus = $this->request->getPost('items');
		$skus = $skus === '' ? null : $skus;

		$variantName = $this->request->getPost('variant_name');
		$variantName = $variantName === '' ? null : $variantName ;

		$brandIds = $this->request->getPost('brands');
		$brandIds = $brandIds === '' ? null : $brandIds;

		$brandLabelTypeIds = $this->request->getPost('brands_label');
		$brandLabelTypeIds = $brandLabelTypeIds === '' ? null : $brandLabelTypeIds;

		$storeCodes = $this->request->getPost('store_codes');
		$storeCodes = $storeCodes === '' ? null : $storeCodes;

		$year = trim($this->request->getPost('year') ?? '');
		$year = $year === '' ? null : $year;

		$yearId = trim($this->request->getPost('year_id') ?? '');
		$yearId = $yearId === '' ? null : $yearId;

	    $preMonthId = $this->request->getVar('pre_month_start') ?? 1;
	    $preMonthEndId = $this->request->getVar('pre_month_end') ?? 12;

	    $postMonthId = $this->request->getVar('post_month_start') ?? 1;
	    $postMonthEndId = $this->request->getVar('post_month_end') ?? 12;

		$preWeekStart = trim($this->request->getPost('pre_week_start') ?? '');
		$preWeekStart = $preWeekStart === '' ? null : $preWeekStart;

		$preWeekEnd = trim($this->request->getPost('pre_week_end') ?? '');
		$preWeekEnd = $preWeekEnd === '' ? null : $preWeekEnd;

		$preWeekStartDate = trim($this->request->getPost('pre_week_start_date') ?? '');
		$preWeekStartDate = $preWeekStartDate === '' ? null : $preWeekStartDate;

		$preWeekEndDate = trim($this->request->getPost('pre_week_end_date') ?? '');
		$preWeekEndDate = $preWeekEndDate === '' ? null : $preWeekEndDate;

		$postWeekStart = trim($this->request->getPost('post_week_start') ?? '');
		$postWeekStart = $postWeekStart === '' ? null : $postWeekStart;

		$postWeekEnd = trim($this->request->getPost('post_week_end') ?? '');
		$postWeekEnd = $postWeekEnd === '' ? null : $postWeekEnd;

		$postWeekStartDate = trim($this->request->getPost('post_week_start_date') ?? '');
		$postWeekStartDate = $postWeekStartDate === '' ? null : $postWeekStartDate;

		$postWeekEndDate = trim($this->request->getPost('post_week_end_date') ?? '');
		$postWeekEndDate = $postWeekEndDate === '' ? null : $postWeekEndDate;

		$limit = $this->request->getVar('limit');
		$offset = $this->request->getVar('offset');
		$limit = is_numeric($limit) ? (int)$limit : 10;
		$offset = is_numeric($offset) ? (int)$offset : 0;

		$orderColumnIndex = $this->request->getVar('order')[0]['column'] ?? 0;
	    $orderDirection = $this->request->getVar('order')[0]['dir'] ?? 'asc';
	    $columns = $this->request->getVar('columns');
	    $orderByColumn = $columns[$orderColumnIndex]['data'] ?? 'itmcde';

	    $searchValue = trim($this->request->getVar('search')['value'] ?? '');
		$searchValue = $searchValue === '' ? null : $searchValue;
		
		// $preWeekStart = 4;
		// $preWeekEnd = 4;
		// $postWeekStart = 6;
		// $postWeekEnd = 7;
		// $yearId = 6;
		// $year = '2025';
		// $preMonthId = 1;
		// $preMonthEndId = 6;
		// $postMonthId = 7;
		// $postMonthEndId = 9;
  
		// var_dump($skus);
		// die();
		//$skus = ['WC002', 'WC001', 'DA001'];
		//$skus = "'" . implode("','", $skus) . "'";
	    $data = $this->Dashboard_model->getPromoDataAll($year, $yearId, $preWeekStart, $preWeekEnd, $postWeekStart, $postWeekEnd, $preMonthId, $preMonthEndId, $postMonthId, $postMonthEndId, $orderByColumn, $orderDirection, 99999999, $offset, $skus, $variantName, $brandIds, $brandLabelTypeIds, $storeCodes, $searchValue);
	    if($isExport){
	    	//call the export function here(pdf/excel)
	    	if($type === 'pdf'){
	    		//generatePdf
	    	}else{
	    		//generateExcel
	    	}
	    }else{
		    return $this->response->setJSON([
		        'data' => $data['data']
		    ]);	
	    }
	    
	}

	public function searchSku()
	{
	    $term = $this->request->getGet('term');
	    $limit = 30;
	    $query_items = "id > 0";

	    if (!empty($term)) {
	        $query_items .= " AND itmcde LIKE '%" . esc($term) . "%'";
	    }

	    $result = $this->Global_model->get_data_list('tbl_vmi_pre_aggregated_data', $query_items, $limit, 0, 'id, itmcde', '', '', '', 'itmcde');

	    $data = [];
	    foreach ($result as $row) {
	        $data[] = [
	            'id' => $row->itmcde,
	            'text' => $row->itmcde
	        ];
	    }

	    echo json_encode(['results' => $data]);
	}

	public function searchStore()
	{
	    $term = $this->request->getGet('term');
	    $limit = 30;
	    $query_items = "id > 0";

	    if (!empty($term)) {
	        $query_items .= " AND store_name LIKE '%" . esc($term) . "%'";
	    }

	    $result = $this->Global_model->get_data_list('tbl_vmi_pre_aggregated_data', $query_items, $limit, 0, 'id, store_code, store_name', '', '', '', 'store_code');

	    $data = [];
	    foreach ($result as $row) {
	        $data[] = [
	            'id' => $row->store_code,
	            'text' => $row->store_name
	        ];
	    }

	    echo json_encode(['results' => $data]);
	}

	public function searchVariant()
	{
	    $term = $this->request->getGet('term');
	    $limit = 30;
	    $query_items = "id > 0";

	    if (!empty($term)) {
	        $query_items .= " AND item_name LIKE '%" . esc($term) . "%'";
	    }

	    $result = $this->Global_model->get_data_list(
	        'tbl_vmi_pre_aggregated_data',
	        $query_items,
	        $limit,
	        0,
	        'id, item_name',
	        '',
	        '',
	        '',
	        'item_name'
	    );

	    $data = [];
	    foreach ($result as $row) {
	        $data[] = [
	            'id' => $row->item_name,
	            'text' => $row->item_name
	        ];
	    }

	    return $this->response->setJSON(['results' => $data]);
	}

	public function generatePdf()
	{	

	}


	public function generateExcel()
	{

	}
}
