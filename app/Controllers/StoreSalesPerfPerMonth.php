<?php

namespace App\Controllers;

use Config\Database;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StoreSalesPerfPerMonth extends BaseController
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

	public function perfPerMonth()
	{
		$uri = current_url(true);
		$data['uri'] = $uri;
		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);
		$data['title'] = "Trade Dashboard";
		$data['PageName'] = 'Trade Dashboard';
		$data['PageUrl'] = 'Trade Dashboard';
		$data["breadcrumb"] = array('Store' => base_url('store/sales-performance-per-month'),'Store Sales Performance per Month' => '');
		$data["source"] = "Actual Sales Report, Scan Data, and Target Sales";
		$data["source_date"] = 'Latest Year';	
		$data["foot_note"] = 'With BA = Actual Sales, Without BA = Scanned Data';	

		$data['content'] = "site/store/perf-per-month/sales_performance_per_month";
		$data['brand_ambassadors'] = $this->Global_model->getBrandAmbassador(0);
		$data['store_branches'] = $this->Global_model->getStoreBranchById(0);
		$data['brands'] = $this->Global_model->getBrandData("ASC", 99999, 0);
		$data['asc'] = $this->Global_model->getAsc(0);
		$data['areas'] = $this->Global_model->getArea(0);
		$data['brandLabel'] = $this->Global_model->getBrandLabelData(0);
		$data['session'] = session();
		$data['js'] = array(
			"assets/site/bundle/js/bundle.min.js",
			"assets/site/js/chart.min.js"
                    );
        $data['css'] = array(
        	"assets/site/bundle/css/bundle.min.css"
                    );
		return view("site/layout/template", $data);
	}


	public function getPerfPerMonth()
	{	
		$areaId = $this->request->getPost('area');
		$areaId = $areaId === '' ? null : $areaId;
		$ascId = $this->request->getPost('asc');
		$ascId = $ascId === '' ? null : $ascId;
		$baTypeId = $this->request->getPost('baType');
		$baTypeId = $baTypeId === '' ? null : $baTypeId;
		$baId = $this->request->getPost('ba');
		$baId = $baId === '' ? null : $baId;
		$storeId= $this->request->getPost('store');
		$storeId = $storeId === '' ? null : $storeId;
        $brandsIds = $this->request->getPost('brands');
        $brandsIds = $brandsIds === '' ? null : $brandsIds;
        $brandCategoriesIds = $this->request->getPost('brandCategories');
        $brandCategoriesIds = $brandCategoriesIds === '' ? null : $brandCategoriesIds;
        $sysPar = $this->Global_model->getSysPar();
		$years = $this->Global_model->getYears(); 

		$year_values = array_column($years, 'year'); 
		$year_id = array_column($years, 'id'); 
		$latest_year = max($year_values);
		$latest_year_id = max($year_id);
		// $storeId = null;
		// $storeCode = null;
		// $areaId = null;
		// $ascId = null;
		// $brands = null;
		//$brandsIds = [37];
		//$baId = null;
		//$baType = strval(3);
		//$brandCategoriesIds = null;
		//$baCode = null;
	    $incentiveRate = 0.015;
	    $amountPerDay = 8000;
	    $noOfDays = 0;
		if($sysPar){
			$jsonString = $sysPar[0]['brand_label_type'];
			$data = json_decode($jsonString, true);
		    $amountPerDay = $sysPar[0]['tba_amount_per_ba'];
		    $noOfDays = $sysPar[0]['tba_num_days'];
		    $target_sales = $amountPerDay * $noOfDays;
		}
		$target_sales = $amountPerDay * $noOfDays;
		// $baId = 10;
		// $storeId = 1;
		$baCode = null;

		if($baId){
			if($baId == -5 || $baId == -6){
				$baCode = null;	
			}else{
				$baCode = $this->Global_model->get_by_id('tbl_brand_ambassador', $baId);
				$baCode = $baCode[0]->code;
			}
		}
		$storeCode = null;
		if($storeId){
			$storeCode = $this->Global_model->get_by_id('tbl_store', $storeId);
			$storeCode = $storeCode[0]->code;
		}
		// print_r($storeCode);
		// die(); 	
		// $baTypeId = '3';
		// $areaId = '5';
		// $storeId = '18';
		// $storeCode = '1878';
		// $ascId = null;
		// $brands = null;
		// $brandsIds = null;
		// $baCode = null;
		// $baId = null;
		$brandCategoriesIds = null;
		if($latest_year){

		    $filters = [
			    'year' => $latest_year, 
			    'asc_id' => $ascId,    
			    'store_id' => $storeId,
			    'store_code' => $storeCode,
			    'area_id' => $areaId,
			    'ba_id' => $baId,
			    'brand_ids' => $brandsIds,
			    'brand_type_ids' => $brandCategoriesIds,
			    'ba_code' => $baCode,
			    'year_val' => $latest_year_id,
			    'ba_type' => $baTypeId,
			    'default_target' => $amountPerDay
			];
			// echo "<pre>";
			// print_r($filters);
			// die();
		    $data = $this->Dashboard_model->tradeOverallBaDataASC($filters);

		    return $this->response->setJSON([
		        'data' => $data['data']
		    ]);
		}
	}

	// ================================= Display filters for pdf export ================================
	private function printFilter($pdf, $filters, $itemBrandMap = '') {
		$pdf->SetFont('helvetica', '', 9);

		$pageWidth  = $pdf->getPageWidth();
		$pageMargin = $pdf->getMargins();
		$totalCols  = 3; // 3 columns layout
		$colWidth   = ($pageWidth - $pageMargin['left'] - $pageMargin['right']) / $totalCols;
		$labelWidth = 30; // static width for label text

		// Split filters into chunks of 3 (3 per row)
		$rows = array_chunk($filters, $totalCols, true);

		foreach ($rows as $row) {
			foreach ($row as $label => $value) {
				$pdf->SetFont('helvetica', 'B', 9);
				$pdf->Cell($labelWidth, 8, $label . ':', 0, 0, 'L');

				$pdf->SetFont('helvetica', '', 9);
				$pdf->Cell($colWidth - $labelWidth, 8, $value, 0, 0, 'L');
			}
			$pdf->Ln(8);
		}

		// Align "Item Brand" to column 1, and "Generated Date" to column 3
		$pdf->SetFont('helvetica', 'B', 9);
		$pdf->Cell($labelWidth, 8, 'Item Brand:', 0, 0, 'L');
		$pdf->SetFont('helvetica', '', 9);
		$pdf->Cell($colWidth - $labelWidth, 8, $itemBrandMap ?: 'None', 0, 0, 'L');

		// Spacer for middle column (column 2)
		$pdf->Cell($colWidth, 8, '', 0, 0);

		$pdf->SetFont('helvetica', 'B', 9);
		$pdf->Cell($labelWidth, 8, 'Generated Date:', 0, 0, 'L');
		$pdf->SetFont('helvetica', '', 9);
		$pdf->Cell($colWidth - $labelWidth, 8, date('M d, Y, h:i:s A'), 0, 1, 'L');

		$pdf->Ln(2);
		$pdf->Cell(0, 0, '', 'T');
		$pdf->Ln(4);
	}

	// ================================= Header for pdf export =================================
	private function printHeader($pdf, $title) {
		$pdf->SetFont('helvetica', '', 12);
		$pdf->Cell(0, 10, 'LIFESTRONG MARKETING INC.', 0, 1, 'C');
		$pdf->SetFont('helvetica', '', 10);
		$pdf->Cell(0, 5, 'Report: ' . $title, 0, 1, 'C');
		$pdf->Ln(5);
	}

	public function generatePdf() {	
	    $areaId = $this->getParam('area');
		$areaId = $areaId === '' ? null : $areaId;
		$ascId = $this->getParam('asc');
		$ascId = $ascId === '' ? null : $ascId;
		$baTypeId = $this->getParam('baType');
		$baTypeId = $baTypeId === '' ? null : $baTypeId;
		$baId = $this->getParam('ba');
		$baId = $baId === '' ? null : $baId;
		$storeId= $this->getParam('store');
		$storeId = $storeId === '' ? null : $storeId;
		$brandsParam = $this->getParam('brands');
		if (is_string($brandsParam) && strpos($brandsParam, ',') !== false) {
			$brands = array_map('trim', explode(',', $brandsParam));
		} elseif (is_array($brandsParam) && count($brandsParam) > 0) {
			$brands = $brandsParam;
		} elseif (!empty($brandsParam)) {
			$brands = [ $brandsParam ];
		} else {
			$brands = [];
		}

		$brandCategoriesParam = $this->getParam('brandCategories');
		if (is_string($brandCategoriesParam) && strpos($brandCategoriesParam, ',') !== false) {
			$brandCategories = array_map('trim', explode(',', $brandCategoriesParam));
		} elseif (is_array($brandCategoriesParam) && count($brandCategoriesParam) > 0) {
			$brandCategories = $brandCategoriesParam;
		} elseif (!empty($brandCategoriesParam)) {
			$brandCategories = [ $brandCategoriesParam ];
		} else {
			$brandCategories = [];
		}

        $sysPar = $this->Global_model->getSysPar();
		$years = $this->Global_model->getYears(); 
	
		$year_values = array_column($years, 'year'); 
		$year_id = array_column($years, 'id'); 
		$latest_year = max($year_values);
		$latest_year_id = max($year_id);
		
	    $incentiveRate = 0.015;
	    $amountPerDay = 8000;
	    $noOfDays = 0;
		if($sysPar){
			$jsonString = $sysPar[0]['brand_label_type'];
			$data = json_decode($jsonString, true);
		    $amountPerDay = $sysPar[0]['tba_amount_per_ba'];
		    $noOfDays = $sysPar[0]['tba_num_days'];
		    $target_sales = $amountPerDay * $noOfDays;
		}
		$target_sales = $amountPerDay * $noOfDays;

		$baCode = null;

		if($baId){
			if($baId == -5 || $baId == -6){
				$baCode = null;	
			}else{
				$baCode = $this->Global_model->get_by_id('tbl_brand_ambassador', $baId);
				$baCode = $baCode[0]->code;
			}
		}

		$storeCode = null;
		if($storeId){
			$storeCode = $this->Global_model->get_by_id('tbl_store', $storeId);
			$storeCode = $storeCode[0]->code;
		}

		$brandCategoriesIds = null;
		if($latest_year){

		    $filters = [
			    'year' => $latest_year, 
			    'asc_id' => $ascId,    
			    'store_id' => $storeId,
			    'store_code' => $storeCode,
			    'area_id' => $areaId,
			    'ba_id' => $baId,
			    'brand_ids' => $brandsParam,
			    'brand_type_ids' => $brandCategoriesIds,
			    'ba_code' => $baCode,
			    'year_val' => $latest_year_id,
			    'ba_type' => $baTypeId,
			    'default_target' => $amountPerDay
			];
		}

		$baTypeString = '';
		switch ($baTypeId) {
			case '3':
				$baTypeString = 'ALL';
				break;
			
			case '1':
				$baTypeString = "Outright";
				break;
			
			case '0':
				$baTypeString = "Consignment";
				break;
			
			default:
				$baTypeString = 'NONE';
				break;
		}

		$dv = function($value, $default = 'None') {
			if (is_array($value)) {
				return empty($value) ? $default : implode(', ', $value);
			}
			$value = trim((string)$value);
			return $value === '' ? $default : $value;
		};

		$result = $this->Global_model->dynamic_search("'tbl_area'", "''", "'description'", 0, 0, "'id:EQ=$areaId'", "''", "''");
		$areaMap = !empty($result) ? $result[0]['description'] : '';

		$result = $this->Global_model->dynamic_search("'tbl_area_sales_coordinator'", "''", "'description'", 0, 0, "'id:EQ=$ascId'", "''", "''");
		$ascMap = !empty($result) ? $result[0]['description'] : '';

		$result = $this->Global_model->dynamic_search("'tbl_brand_ambassador'", "''", "'name'", 0, 0, "'id:EQ=$baId'", "''", "''");
		$baMap = !empty($result) ? $result[0]['name'] : '';

		$result = $this->Global_model->dynamic_search("'tbl_store'", "''", "'description'", 0, 0, "'code:EQ=$storeId'", "''", "''");
		$storeMap = !empty($result) ? $result[0]['description'] : '';

		$brandsLabel = [];
		foreach ($brands as $brandsed) {
			$result  = $this->Global_model->dynamic_search("'tbl_brand'", "''", "'brand_description'", 0, 0, "'id:EQ={$brandsed}'", "''", "''");
			if (!empty($result) && isset($result[0]['brand_description'])) {
				$brandsLabel[] = $result[0]['brand_description'];
			}
		}

		$brandLabelType = [];
		foreach ($brandCategories as $brandCat) {
			$result  = $this->Global_model->dynamic_search("'tbl_brand_label_type'", "''", "'label'", 0, 0, "'id:EQ={$brandCat}'", "''", "''");
			if (!empty($result) && isset($result[0]['label'])) {
				$brandLabelType[] = $result[0]['label'];
			}
		}

		if (empty($brandLabelType)) {
			$brandLabelTypeMap = '';  
		} else {
			$brandLabelTypeMap = implode(', ', $brandLabelType);
		}

		if (empty($brandsLabel)) {
			$itemBrandMap = '';  
		} else {
			$itemBrandMap = implode(', ', $brandsLabel);
		}

		$filterData = [
			'Area'             		=> $dv($areaMap),
			'ASC'              		=> $dv($ascMap),
			'BA Type'          		=> $dv($baTypeString),
			'Brand Ambassador' 		=> $dv($baMap),
			'Store Name'	   		=> $dv($storeMap),
			'Brand Label Type'	   	=> empty($brandLabelTypeMap) ? 'None' : $brandLabelTypeMap,
			// 'Item Brand'            => empty($itemBrandMap) ? 'None' : $itemBrandMap,
		];

		$title = "Store Sales Performance Per Area";
		$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator('LMI SFA');
		$pdf->SetAuthor('LIFESTRONG MARKETING INC.');
		$pdf->SetTitle($title);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();

		$this->printHeader($pdf, $title);
		$this->printFilter($pdf, $filterData, $itemBrandMap);

		$pdf->SetFont('helvetica', '', 9);
		$result = $this->Dashboard_model->tradeOverallBaDataASC($filters);
		$rows = $result['data'];

		$pageWidth  = $pdf->getPageWidth();
		$margins    = $pdf->getMargins();
		$colWidth   = ($pageWidth - $margins['left'] - $margins['right']) / 13;

		$headers = [
			'January',
			'February',
			'March',
			'April',
			'May',
			'June',
			'July',
			'August',
			'September',
			'October',
			'November',
			'December',
		];

		$pdf->SetFont('helvetica','B',9);

		// First column: empty for label header
		$pdf->Cell($colWidth, 8, '', 1, 0, 'C');

		foreach ($headers as $i => $text) {
			$pdf->Cell($colWidth, 8, $text, 1, ($i === count($headers) - 1 ? 1 : 0), 'C');
		}

		$pdf->SetFont('helvetica','',9);
		$lineH = 4; 
		foreach ($rows as $row) {
			$rowH = 8;
			$pdf->Cell($colWidth, $rowH, 'LY Sell Out', 1, 0, 'L');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->ly_sell_out_january), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->ly_sell_out_february), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->ly_sell_out_march), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->ly_sell_out_april), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->ly_sell_out_may), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->ly_sell_out_june), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->ly_sell_out_july), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->ly_sell_out_august), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->ly_sell_out_september), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->ly_sell_out_october), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->ly_sell_out_november), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->ly_sell_out_december), 1, 1, 'C');

			$pdf->Cell($colWidth, $rowH, 'TY Sell Out', 1, 0, 'L');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->ty_sell_out_january), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->ty_sell_out_february), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->ty_sell_out_march), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->ty_sell_out_april), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->ty_sell_out_may), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->ty_sell_out_june), 1, 0, 'C'); 
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->ty_sell_out_july), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->ty_sell_out_august), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->ty_sell_out_september), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->ty_sell_out_october), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->ty_sell_out_november), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->ty_sell_out_december), 1, 1, 'C');

			$pdf->Cell($colWidth, $rowH, 'Sales Report', 1, 0, 'L');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->amount_january), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->amount_february), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->amount_march), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->amount_april), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->amount_may), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->amount_june), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->amount_july), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->amount_august), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->amount_september), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->amount_october), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->amount_november), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->amount_december), 1, 1, 'C');

			$pdf->Cell($colWidth, $rowH, 'Target Sales', 1, 0, 'L');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->target_sales_jan), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->target_sales_feb), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->target_sales_mar), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->target_sales_apr), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->target_sales_may), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->target_sales_jun), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->target_sales_jul), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->target_sales_aug), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->target_sales_sep), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->target_sales_oct), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->target_sales_nov), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->target_sales_dec), 1, 1, 'C');

			$pdf->Cell($colWidth, $rowH, '% Growth', 1, 0, 'L');
			$pdf->Cell($colWidth, $rowH, $row->growth_january, 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $row->growth_february, 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $row->growth_march, 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $row->growth_april, 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $row->growth_may, 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $row->growth_june, 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $row->growth_july, 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $row->growth_august, 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $row->growth_september, 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $row->growth_october, 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $row->growth_november, 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $row->growth_december, 1, 1, 'C');

			$pdf->Cell($colWidth, $rowH, '% Achieved', 1, 0, 'L');
			$pdf->Cell($colWidth, $rowH, $row->achieved_january, 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $row->achieved_february, 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $row->achieved_march, 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $row->achieved_april, 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $row->achieved_may, 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $row->achieved_june, 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $row->achieved_july, 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $row->achieved_august, 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $row->achieved_september, 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $row->achieved_october, 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $row->achieved_november, 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $row->achieved_december, 1, 1, 'C');
		}

		$pdf->Output($title . '.pdf', 'D');
		exit;
	}


	public function generateExcel() {
	    $areaId = $this->getParam('area');
		$areaId = $areaId === '' ? null : $areaId;
		$ascId = $this->getParam('asc');
		$ascId = $ascId === '' ? null : $ascId;
		$baTypeId = $this->getParam('baType');
		$baTypeId = $baTypeId === '' ? null : $baTypeId;
		$baId = $this->getParam('ba');
		$baId = $baId === '' ? null : $baId;
		$storeId= $this->getParam('store');
		$storeId = $storeId === '' ? null : $storeId;
        $brandsParam = $this->getParam('brands');
		if (is_string($brandsParam) && strpos($brandsParam, ',') !== false) {
			$brands = array_map('trim', explode(',', $brandsParam));
		} elseif (is_array($brandsParam) && count($brandsParam) > 0) {
			$brands = $brandsParam;
		} elseif (!empty($brandsParam)) {
			$brands = [ $brandsParam ];
		} else {
			$brands = [];
		}

		$brandCategoriesParam = $this->getParam('brandCategories');
		if (is_string($brandCategoriesParam) && strpos($brandCategoriesParam, ',') !== false) {
			$brandCategories = array_map('trim', explode(',', $brandCategoriesParam));
		} elseif (is_array($brandCategoriesParam) && count($brandCategoriesParam) > 0) {
			$brandCategories = $brandCategoriesParam;
		} elseif (!empty($brandCategoriesParam)) {
			$brandCategories = [ $brandCategoriesParam ];
		} else {
			$brandCategories = [];
		}
		
        $sysPar = $this->Global_model->getSysPar();
		$years = $this->Global_model->getYears(); 
	
		$year_values = array_column($years, 'year'); 
		$year_id = array_column($years, 'id'); 
		$latest_year = max($year_values);
		$latest_year_id = max($year_id);
		
	    $incentiveRate = 0.015;
	    $amountPerDay = 8000;
	    $noOfDays = 0;
		if($sysPar){
			$jsonString = $sysPar[0]['brand_label_type'];
			$data = json_decode($jsonString, true);
		    $amountPerDay = $sysPar[0]['tba_amount_per_ba'];
		    $noOfDays = $sysPar[0]['tba_num_days'];
		    $target_sales = $amountPerDay * $noOfDays;
		}
		$target_sales = $amountPerDay * $noOfDays;

		$baCode = null;

		if($baId){
			if($baId == -5 || $baId == -6){
				$baCode = null;	
			}else{
				$baCode = $this->Global_model->get_by_id('tbl_brand_ambassador', $baId);
				$baCode = $baCode[0]->code;
			}
		}

		$storeCode = null;
		if($storeId){
			$storeCode = $this->Global_model->get_by_id('tbl_store', $storeId);
			$storeCode = $storeCode[0]->code;
		}

		$brandCategoriesIds = null;
		if($latest_year){

		    $filters = [
			    'year' => $latest_year, 
			    'asc_id' => $ascId,    
			    'store_id' => $storeId,
			    'store_code' => $storeCode,
			    'area_id' => $areaId,
			    'ba_id' => $baId,
			    'brand_ids' => $brandsParam,
			    'brand_type_ids' => $brandCategoriesIds,
			    'ba_code' => $baCode,
			    'year_val' => $latest_year_id,
			    'ba_type' => $baTypeId,
			    'default_target' => $amountPerDay
			];
		}

		$baTypeString = '';
		switch ($baTypeId) {
			case '3':
				$baTypeString = 'ALL';
				break;
			
			case '1':
				$baTypeString = "Outright";
				break;
			
			case '0':
				$baTypeString = "Consignment";
				break;
			
			default:
				$baTypeString = 'NONE';
				break;
		}

		$result = $this->Global_model->dynamic_search("'tbl_area'", "''", "'description'", 0, 0, "'id:EQ=$areaId'", "''", "''");
		$areaMap = !empty($result) ? $result[0]['description'] : '';

		$result = $this->Global_model->dynamic_search("'tbl_area_sales_coordinator'", "''", "'description'", 0, 0, "'id:EQ=$ascId'", "''", "''");
		$ascMap = !empty($result) ? $result[0]['description'] : '';

		$result = $this->Global_model->dynamic_search("'tbl_brand_ambassador'", "''", "'name'", 0, 0, "'id:EQ=$baId'", "''", "''");
		$baMap = !empty($result) ? $result[0]['name'] : '';

		$result = $this->Global_model->dynamic_search("'tbl_store'", "''", "'description'", 0, 0, "'code:EQ=$storeId'", "''", "''");
		$storeMap = !empty($result) ? $result[0]['description'] : '';

		$brandsLabel = [];
		foreach ($brands as $brandsed) {
			$result  = $this->Global_model->dynamic_search("'tbl_brand'", "''", "'brand_description'", 0, 0, "'id:EQ={$brandsed}'", "''", "''");
			if (!empty($result) && isset($result[0]['brand_description'])) {
				$brandsLabel[] = $result[0]['brand_description'];
			}
		}

		$brandLabelType = [];
		foreach ($brandCategories as $brandCat) {
			$result  = $this->Global_model->dynamic_search("'tbl_brand_label_type'", "''", "'label'", 0, 0, "'id:EQ={$brandCat}'", "''", "''");
			if (!empty($result) && isset($result[0]['label'])) {
				$brandLabelType[] = $result[0]['label'];
			}
		}

		if (empty($brandLabelType)) {
			$brandLabelTypeMap = '';  
		} else {
			$brandLabelTypeMap = implode(', ', $brandLabelType);
		}

		if (empty($brandsLabel)) {
			$itemBrandMap = '';  
		} else {
			$itemBrandMap = implode(', ', $brandsLabel);
		}

		$title = "Store Sales Performance Per Month";
		$data = $this->Dashboard_model->tradeOverallBaDataASC($filters);
		$rows   = $data['data'];

		$spreadsheet = new Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'LIFESTRONG MARKETING INC.');
		$sheet->setCellValue('A2', 'Report: Store Sales Performance Overall');
		$sheet->mergeCells('A1:E1');
		$sheet->mergeCells('A2:E2');

		$sheet->setCellValue('A4', 'Area: '  . ($areaMap ?: 'NONE'));
		$sheet->setCellValue('B4', 'ASC: ' . ($ascMap ?: 'NONE'));
		$sheet->setCellValue('C4', 'BA Type: '. ($baTypeString     ?: 'NONE'));
		$sheet->setCellValue('D4', 'Brand Ambassador: ' . ($baMap     ?: 'NONE'));

		$sheet->setCellValue('A5', 'Store Name: ' . ($storeMap ?: 'NONE'));
		$sheet->setCellValue('B5', 'Brand Label Type: '   . ($brandLabelTypeMap   ?: 'NONE'));
		$sheet->setCellValue('C5', 'Item Brand: '        . ($itemBrandMap       ?: 'NONE'));
		$sheet->setCellValue('D5', 'Date Generated: ' . date('M d, Y, h:i:s A'));

		$headers = [
			'January',
			'February',
			'March',
			'April',
			'May',
			'June',
			'July',
			'August',
			'September',
			'October',
			'November',
			'December',
		];

		$sheet->fromArray($headers, null, 'B7');
		$sheet->setCellValue('A7', ''); // Blank first column (label placeholder)
		$sheet->getStyle('B7:M7')->getFont()->setBold(true);
		$sheet->getStyle('A8:A13')->getFont()->setBold(true);
		

		$rowNum = 8;
		foreach ($rows as $row) {
			// LY Sell Out
			$sheet->setCellValue("A{$rowNum}", 'LY Sell Out');
			$sheet->fromArray([
				$row->ly_sell_out_january,
				$row->ly_sell_out_february,
				$row->ly_sell_out_march,
				$row->ly_sell_out_april,
				$row->ly_sell_out_may,
				$row->ly_sell_out_june,
				$row->ly_sell_out_july,
				$row->ly_sell_out_august,
				$row->ly_sell_out_september,
				$row->ly_sell_out_october,
				$row->ly_sell_out_november,
				$row->ly_sell_out_december
			], null, "B{$rowNum}");
			$rowNum++;

			// TY Sell Out
			$sheet->setCellValue("A{$rowNum}", 'TY Sell Out');
			$sheet->fromArray([
				$row->ty_sell_out_january,
				$row->ty_sell_out_february,
				$row->ty_sell_out_march,
				$row->ty_sell_out_april,
				$row->ty_sell_out_may,
				$row->ty_sell_out_june,
				$row->ty_sell_out_july,
				$row->ty_sell_out_august,
				$row->ty_sell_out_september,
				$row->ty_sell_out_october,
				$row->ty_sell_out_november,
				$row->ty_sell_out_december
			], null, "B{$rowNum}");
			$rowNum++;

			// Sales Report
			$sheet->setCellValue("A{$rowNum}", 'Sales Report');
			$sheet->fromArray([
				$row->amount_january,
				$row->amount_february,
				$row->amount_march,
				$row->amount_april,
				$row->amount_may,
				$row->amount_june,
				$row->amount_july,
				$row->amount_august,
				$row->amount_september,
				$row->amount_october,
				$row->amount_november,
				$row->amount_december
			], null, "B{$rowNum}");
			$rowNum++;

			// Target Sales
			$sheet->setCellValue("A{$rowNum}", 'Target Sales');
			$sheet->fromArray([
				$row->target_sales_jan,
				$row->target_sales_feb,
				$row->target_sales_mar,
				$row->target_sales_apr,
				$row->target_sales_may,
				$row->target_sales_jun,
				$row->target_sales_jul,
				$row->target_sales_aug,
				$row->target_sales_sep,
				$row->target_sales_oct,
				$row->target_sales_nov,
				$row->target_sales_dec
			], null, "B{$rowNum}");
			$rowNum++;

			// % Growth
			$sheet->setCellValue("A{$rowNum}", '% Growth');
			$sheet->fromArray([
				$row->growth_january,
				$row->growth_february,
				$row->growth_march,
				$row->growth_april,
				$row->growth_may,
				$row->growth_june,
				$row->growth_july,
				$row->growth_august,
				$row->growth_september,
				$row->growth_october,
				$row->growth_november,
				$row->growth_december
			], null, "B{$rowNum}");
			$rowNum++;

			// % Achieved
			$sheet->setCellValue("A{$rowNum}", '% Achieved');
			$sheet->fromArray([
				$row->achieved_january,
				$row->achieved_february,
				$row->achieved_march,
				$row->achieved_april,
				$row->achieved_may,
				$row->achieved_june,
				$row->achieved_july,
				$row->achieved_august,
				$row->achieved_september,
				$row->achieved_october,
				$row->achieved_november,
				$row->achieved_december
			], null, "B{$rowNum}");
			$rowNum++;

			// Optional: empty row between groups
			$rowNum++;
		}

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

	private function getParam(string $key) {
		$v = $this->request->getVar($key);       // accepts GET or POST
		if (is_null($v)) return null;
		$v = trim((string)$v);
		return $v === '' ? null : $v;
	}

	private function parseCsvParam(?string $csv): array {
		if ($csv === null || trim($csv) === '') {
			return [];
		}
		return array_filter(
			array_map('intval', explode(',', $csv)),
			fn($i) => $i > 0
		);
	}

	private function formatTwoDecimals($value): string {
		if (is_null($value) || !is_numeric($value)) {
			$value = 0;
		}
		return number_format((float)$value, 2, '.', ',');
	}
	
}
