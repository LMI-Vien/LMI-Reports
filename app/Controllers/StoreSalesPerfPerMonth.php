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
		$years = $this->Global_model->getYears(); 

		$year_values = array_column($years, 'year'); 
		$year_id = array_column($years, 'id'); 
		$latest_year = max($year_values);

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
		$data["source_date"] = $latest_year;	
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
		//$brandCategoriesIds = null;
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
		    $data = $this->Dashboard_model->storeSalesPerfPerMonth($filters);

		    return $this->response->setJSON([
		        'data' => $data['data']
		    ]);
		}
	}

	// ================================= Display filters for pdf export ================================
	private function printFilter($pdf, $filters, $itemBrandMap = '', $latestYear = null) {
		$pdf->SetFont('helvetica', 'B', 9);
		$source = "Actual Sales Report, Scan Data, and Target Sales - " . ($latestYear ?? 'N/A');
		$pdf->MultiCell(0, 8, "Source: " . $source, 0, 'C', 0, 1, '', '', true);

		$pdf->SetFont('helvetica', '', 9);
		$pdf->Ln(2);

		$pageWidth  = $pdf->getPageWidth();
		$margins    = $pdf->getMargins();
		$perRow     = ceil(count($filters) / 2);
		$colWidth   = ($pageWidth - $margins['left'] - $margins['right']) / $perRow;

		// — compute bottom‐line values —
		$currentWeek = method_exists($this, 'getCurrentWeek') ? $this->getCurrentWeek()['display'] : 'Unknown Week';
		$generatedAt = date('M d, Y, h:i:s A');

		// — print filters in two rows, with bold keys via HTML —
		$lineHeight = 7; 
		$rows = array_chunk($filters, $perRow, true);
		foreach ($rows as $rowFilters) {
			// 1) figure out tallest cell
			$maxLines = 0;
			foreach ($rowFilters as $k => $v) {
				$maxLines = max(
					$maxLines,
					$pdf->getNumLines("<b>{$k}:</b> {$v}", $colWidth)
				);
			}

			// 2) render each as HTML (bold key, normal value)
			foreach ($rowFilters as $k => $v) {
				$pdf->MultiCell(
					$colWidth,
					$lineHeight,
					"<b>{$k}:</b> {$v}",
					0,    // no border
					'L',  // left align
					0,    // no fill
					0,    // stay on same line
					'', '',  // x/y
					true, // reset height
					0,    // stretch
					true  // isHTML!
				);
			}

			// 3) drop down by full height
			$pdf->Ln($maxLines * $lineHeight);
		}

		// — pull the bottom line up a bit if you like —
		$pdf->SetY($pdf->GetY() - 7);

		// — now print Item Brand / Current Week / Generated Date in one row —
		$pdf->writeHTMLCell(
			60, 6, '', '',
			"<b>Item Brand:</b> " . ($itemBrandMap ?: 'None'),
			0, 0, false, true, 'L', true
		);
		$pdf->Cell(32, 6, '', 0, 0); // small spacer
		$pdf->writeHTMLCell(
			60, 6, '', '',
			"<b>Current Week:</b> {$currentWeek}",
			0, 0, false, true, 'L', true
		);
		$pdf->Cell(33, 6, '', 0, 0); // small spacer
		$pdf->writeHTMLCell(
			0, 6, '', '',
			"<b>Generated Date:</b> {$generatedAt}",
			0, 1, false, true, 'L', true
		);

		$pdf->Ln(2);
		$pdf->Cell(0, 0, '', 'T');
		$pdf->Ln(4);
	}

	// ================================= Header for pdf export =================================
	private function printHeader($pdf, $title) {
		$logoPath = FCPATH . 'assets/img/lifestrong_white_bg.webp';
		if (file_exists($logoPath)) {
			$pdf->Image($logoPath, 15, 5, 50); // (file, x, y, width), adjust position if needed
		}
		
		$pdf->SetFont('helvetica', 'B', 15);
		$pdf->Cell(0, 10, 'LIFESTRONG MARKETING INC.', 0, 1, 'C');
		$pdf->SetFont('helvetica', '', 10);
		$pdf->Cell(0, 5, 'Report: ' . $title, 0, 1, 'C');
		$pdf->Ln(5);
	}

	public function generatePdf() {	
        $json = $this->request->getJSON(true);

	    $areaId = $json['area'];
		$areaId = $areaId === '' ? null : $areaId;
		$ascId = $json['asc'];
		$ascId = $ascId === '' ? null : $ascId;
		$baTypeId = $json['baType'];
		$baTypeId = $baTypeId === '' ? null : $baTypeId;
		$baId = $json['ba'];
		$baId = $baId === '' ? null : $baId;
		$storeId= $json['store'];
		$storeId = $storeId === '' ? null : $storeId;
		$brandsParam = $json['brands'];
		if (is_string($brandsParam) && strpos($brandsParam, ',') !== false) {
			$brands = array_map('trim', explode(',', $brandsParam));
		} elseif (is_array($brandsParam) && count($brandsParam) > 0) {
			$brands = $brandsParam;
		} elseif (!empty($brandsParam)) {
			$brands = [ $brandsParam ];
		} else {
			$brands = [];
		}

		$brandCategoriesParam = $json['brandCategories'];
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

		$areaMap = $json['areaMap'];
		$ascMap = $json['ascMap'];
		$baMap = $json['baMap'];
		$storeMap = $json['storeMap'];
		$result = $json['brandLabelTypeMap'];
		if (is_array($result)) {
			$brandLabelTypeMap = implode(', ', $result);
		} else {
			$brandLabelTypeMap = '';
		}
		$result = $json['itemBrandMap'];
		if (is_array($result)) {
			$itemBrandMap = implode(', ', $result);
		} else {
			$itemBrandMap = '';
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

		$title = "Store Sales Performance per Month";
		$pdf = new \App\Libraries\TCPDFLib('L','mm','A4', true, 'UTF-8', false, false);
		$pdf->SetCreator('LMI SFA');
		$pdf->SetAuthor('LIFESTRONG MARKETING INC.');
		$pdf->SetTitle($title);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(true);
		$pdf->AddPage();

		$this->printHeader($pdf, $title);
		$this->printFilter($pdf, $filterData, $itemBrandMap, $latest_year);

		$pdf->SetFont('helvetica', '', 9);
		$result = $this->Dashboard_model->storeSalesPerfPerMonth($filters);
		$rows = $result['data'];

		$pageWidth  = $pdf->getPageWidth();
		$margins    = $pdf->getMargins();
		$colWidth   = ($pageWidth - $margins['left'] - $margins['right']) / 14;

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
			'Total',
		];

		$pdf->SetFont('helvetica','B',9);

		// First column: empty for label header
		$pdf->Cell($colWidth, 8, '', 1, 0, 'C');

		foreach ($headers as $i => $text) {
			$pdf->Cell($colWidth, 8, $text, 1, ($i === count($headers) - 1 ? 1 : 0), 'C');
		}

		$pdf->SetFont('helvetica','',9);
		$lineH = 4; 
		$role = $this->session->get('sess_site_role');
		foreach ($rows as $row) {
			$rowH = 8;
			$pdf->SetFont('helvetica', '', 7);
			$pdf->Cell($colWidth, $rowH, 'LY Sell Out', 1, 0, 'L');

			if ($role == 7 || $role == 8) {
				$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals('-'), 1, 0, 'C');
				$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals('-'), 1, 0, 'C');
				$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals('-'), 1, 0, 'C');
				$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals('-'), 1, 0, 'C');
				$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals('-'), 1, 0, 'C');
				$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals('-'), 1, 0, 'C');
				$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals('-'), 1, 0, 'C');
				$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals('-'), 1, 0, 'C');
				$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals('-'), 1, 0, 'C');
				$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals('-'), 1, 0, 'C');
				$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals('-'), 1, 0, 'C');
				$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals('-'), 1, 0, 'C');
				$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals('-'), 1, 1, 'C');
			}else{
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
				$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->ly_sell_out_december), 1, 0, 'C');
				$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->total_ly_sell_out), 1, 1, 'C');
			}

			$pdf->SetFont('helvetica', '', 7);
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
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->ty_sell_out_december), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->total_ty_sell_out), 1, 1, 'C');

			$pdf->SetFont('helvetica', '', 7);
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
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->amount_december), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->total_amount), 1, 1, 'C');

			$pdf->SetFont('helvetica', '', 7);
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
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->target_sales_dec), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->total_target), 1, 1, 'C');

			$pdf->SetFont('helvetica', '', 7);
			$pdf->MultiCell($colWidth, $rowH, "Balance\nTo Target", 1, 'L', false, 0);
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->balance_to_target_jan), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->balance_to_target_feb), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->balance_to_target_mar), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->balance_to_target_apr), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->balance_to_target_may), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->balance_to_target_jun), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->balance_to_target_jul), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->balance_to_target_aug), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->balance_to_target_sep), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->balance_to_target_oct), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->balance_to_target_nov), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->balance_to_target_dec), 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $this->formatTwoDecimals($row->total_balance_to_target), 1, 1, 'C');

			if ($role == 7 || $role == 8) {
				$pdf->Cell($colWidth, $rowH, '% Growth', 1, 0, 'L');
				$pdf->Cell($colWidth, $rowH, '-', 1, 0, 'C');
				$pdf->Cell($colWidth, $rowH, '-', 1, 0, 'C');
				$pdf->Cell($colWidth, $rowH, '-', 1, 0, 'C');
				$pdf->Cell($colWidth, $rowH, '-', 1, 0, 'C');
				$pdf->Cell($colWidth, $rowH, '-', 1, 0, 'C');
				$pdf->Cell($colWidth, $rowH, '-', 1, 0, 'C');
				$pdf->Cell($colWidth, $rowH, '-', 1, 0, 'C');
				$pdf->Cell($colWidth, $rowH, '-', 1, 0, 'C');
				$pdf->Cell($colWidth, $rowH, '-', 1, 0, 'C');
				$pdf->Cell($colWidth, $rowH, '-', 1, 0, 'C');
				$pdf->Cell($colWidth, $rowH, '-', 1, 0, 'C');
				$pdf->Cell($colWidth, $rowH, '-', 1, 0, 'C');
				$pdf->Cell($colWidth, $rowH, '-', 1, 1, 'C');
			}else{
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
				$pdf->Cell($colWidth, $rowH, $row->growth_december, 1, 0, 'C');
				$pdf->Cell($colWidth, $rowH, '-', 1, 1, 'C');
			}

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
			$pdf->Cell($colWidth, $rowH, $row->achieved_december, 1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, '-', 1, 1, 'C');
		}
		$pdf->Output($title . '.pdf', 'D');
		exit;
	}


	public function generateExcel() {
        $json = $this->request->getJSON(true);

	    $areaId = $json['area'];
		$areaId = $areaId === '' ? null : $areaId;
		$ascId = $json['asc'];
		$ascId = $ascId === '' ? null : $ascId;
		$baTypeId = $json['baType'];
		$baTypeId = $baTypeId === '' ? null : $baTypeId;
		$baId = $json['ba'];
		$baId = $baId === '' ? null : $baId;
		$storeId= $json['store'];
		$storeId = $storeId === '' ? null : $storeId;
        $brandsParam = $json['brands'];
		if (is_string($brandsParam) && strpos($brandsParam, ',') !== false) {
			$brands = array_map('trim', explode(',', $brandsParam));
		} elseif (is_array($brandsParam) && count($brandsParam) > 0) {
			$brands = $brandsParam;
		} elseif (!empty($brandsParam)) {
			$brands = [ $brandsParam ];
		} else {
			$brands = [];
		}

		$brandCategoriesParam = $json['brandCategories'];
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

		$areaMap = $json['areaMap'];
		$ascMap = $json['ascMap'];
		$baMap = $json['baMap'];
		$storeMap = $json['storeMap'];
		$result = $json['brandLabelTypeMap'];
		if (is_array($result)) {
			$brandLabelTypeMap = implode(', ', $result);
		} else {
			$brandLabelTypeMap = '';
		}
		$result = $json['itemBrandMap'];
		if (is_array($result)) {
			$itemBrandMap = implode(', ', $result);
		} else {
			$itemBrandMap = '';
		}

		$title = "Store Sales Performance per Month";
		$data = $this->Dashboard_model->storeSalesPerfPerMonth($filters);
		$rows   = $data['data'];

		$spreadsheet = new Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();

		$currentWeek = method_exists($this, 'getCurrentWeek') ? $this->getCurrentWeek() : null;
		$currentWeekDisplay = $currentWeek ? $currentWeek['display'] : 'Unknown Week';

		$sheet->setCellValue('A1', 'LIFESTRONG MARKETING INC.');
		$sheet->setCellValue('A2', 'Report: Store Sales Performance Overall');
		$sheet->setCellValue('A4', 'Source: Actual Sales Report, Scan Data, and Target Sales - ' . $latest_year);
		$sheet->setCellValue('A5', 'Current Week: ' . $currentWeekDisplay);
		$sheet->mergeCells('A1:C1');
		$sheet->mergeCells('A2:C2');

		$sheet->setCellValue('A7', 'Area: '  . ($areaMap ?: 'NONE'));
		$sheet->setCellValue('B7', 'ASC: ' . ($ascMap ?: 'NONE'));
		$sheet->setCellValue('C7', 'BA Type: '. ($baTypeString     ?: 'NONE'));
		$sheet->setCellValue('D7', 'Brand Ambassador: ' . ($baMap     ?: 'NONE'));

		$sheet->setCellValue('A8', 'Store Name: ' . ($storeMap ?: 'NONE'));
		$sheet->setCellValue('B8', 'Brand Label Type: '   . ($brandLabelTypeMap   ?: 'NONE'));
		$sheet->setCellValue('C8', 'Item Brand: '        . ($itemBrandMap       ?: 'NONE'));
		$sheet->setCellValue('D8', 'Date Generated: ' . date('M d, Y, h:i:s A'));

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
			'Total',
		];

		$sheet->fromArray($headers, null, 'B10');
		$sheet->setCellValue('A10', ''); // Blank first column (label placeholder)
		$sheet->getStyle('B10:N10')->getFont()->setBold(true);
		$sheet->getStyle('A11:A17')->getFont()->setBold(true);
		

		$rowNum = 11;
		$role = $this->session->get('sess_site_role');

		foreach ($rows as $row) {
		    // LY Sell Out
		    $sheet->setCellValue("A{$rowNum}", 'LY Sell Out');
		    if ($role == 7 || $role == 8) {
		        $sheet->fromArray(array_fill(0, 13, '-'), null, "B{$rowNum}");
		    } else {
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
		            $row->ly_sell_out_december,
		            $row->total_ly_sell_out
		        ], null, "B{$rowNum}");
		    }
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
		        $row->ty_sell_out_december,
		        $row->total_ty_sell_out
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
		        $row->amount_december,
		        $row->total_amount
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
		        $row->target_sales_dec,
		        $row->total_target
		    ], null, "B{$rowNum}");
		    $rowNum++;

		    // Balance To Target
		    $sheet->setCellValue("A{$rowNum}", 'Balance To Target');
		    $sheet->fromArray([
		        $row->balance_to_target_jan,
		        $row->balance_to_target_feb,
		        $row->balance_to_target_mar,
		        $row->balance_to_target_apr,
		        $row->balance_to_target_may,
		        $row->balance_to_target_jun,
		        $row->balance_to_target_jul,
		        $row->balance_to_target_aug,
		        $row->balance_to_target_sep,
		        $row->balance_to_target_oct,
		        $row->balance_to_target_nov,
		        $row->balance_to_target_dec,
		        $row->total_balance_to_target
		    ], null, "B{$rowNum}");
		    $rowNum++;

		    // % Growth
		    $sheet->setCellValue("A{$rowNum}", '% Growth');
		    if ($role == 7 || $role == 8) {
		        $sheet->fromArray(array_fill(0, 12, '-'), null, "B{$rowNum}");
		    } else {
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
		    }
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
		        $row->achieved_december,
		        '-'
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

	private function formatTwoDecimals($value): string {
		if (is_null($value) || !is_numeric($value)) {
			$value = 0;
		}
		return number_format((float)$value, 2, '.', ',');
	}

	private function getCalendarWeeks($year) {
		$weeks = [];

		// ISO week 1 always contains January 4
		$date = new \DateTime();
		$date->setDate($year, 1, 4);

		// Move to the Monday of that week
		$dayOfWeek = (int)$date->format('N'); // 1 (Mon) to 7 (Sun)
		$date->modify('-' . ($dayOfWeek - 1) . ' days'); // Go back to Monday

		$weekNumber = 1;

		while ((int)$date->format('o') <= $year) {
			$weekStart = clone $date;
			$weekEnd = clone $date;
			$weekEnd->modify('+6 days');

			if ((int)$weekStart->format('o') > $year) break;

			$weeks[] = [
				'id'      => $weekNumber,
				'display' => 'Week ' . $weekNumber . ' (' . $weekStart->format('Y-m-d') . ' - ' . $weekEnd->format('Y-m-d') . ')',
				'week'    => $weekNumber,
				'start'   => $weekStart->format('Y-m-d'),
				'end'     => $weekEnd->format('Y-m-d'),
			];

			$date->modify('+7 days');
			$weekNumber++;
		}

		return $weeks;
	}


    private function getCurrentWeek($year = null) {
        if ($year === null) {
            $year = (int)date('Y');
        }

        $weeks = $this->getCalendarWeeks($year);
        $today = date('Y-m-d');

        foreach ($weeks as $week) {
            if ($today >= $week['start'] && $today <= $week['end']) {
                return $week;
            }
        }

        return null;
    }
	
}
