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
		$data['store_branches'] = $this->Global_model->getStoreBranchById(0);
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

		$sysPar = $this->Global_model->getSysPar();
		$areaId = trim($this->request->getPost('area'));
		$areaId = $areaId === '' ? null : $areaId;
		$ascId = trim($this->request->getPost('asc'));
		$ascId = $ascId === '' ? null : $ascId;
		$baTypeId = trim($this->request->getPost('baType'));
		$baTypeId = $baTypeId === '' ? null : $baTypeId;
		$baId = trim($this->request->getPost('ba'));
		$baId = $baId === '' ? null : $baId;
		$storeId= trim($this->request->getPost('store'));
		$storeId = $storeId === '' ? null : $storeId;
        $brandIds = $this->request->getPost('brands');
        $brandIds = $brandIds === '' ? null : $brandIds;
	    $year = $this->request->getPost('year')?? 0;            
	    $monthId = $this->request->getVar('month_start') ?? 1;
	    $monthEndId = $this->request->getVar('month_end') ?? 12;
		$limit = $this->request->getVar('limit');
		$offset = $this->request->getVar('offset');
		$limit = is_numeric($limit) ? (int)$limit : 10;
		$offset = is_numeric($offset) ? (int)$offset : 0;

	    $formatted_month = str_pad($monthId, 2, '0', STR_PAD_LEFT);
	    $date = null; 
	    $lookup_month = null;
	    $lyYear = 0;
	    $tyYear = 0;
	    $selected_year = null;
	    $lyMonth = null;
	    $date = null;

	    if($year){
	    	$actual_year = $this->Dashboard_model->getYear($year);
	    	$yearId = $actual_year[0]['id'];
	    	$selected_year = $actual_year[0]['year'];
	    	$lyYear = $selected_year - 1;
	    	$tyYear = $selected_year;
	    	$date = $actual_year[0]['year'];
	    	$targetYear = $actual_year[0]['year'];
	    }

	    if($monthEndId){
	    	$date = $formatted_month;
	    	$lyMonth = $monthId;
	    }
	    
	    $days = null;
	    $tpr = 0;
	    $month = date('m');

		if($year && $monthId){
	    	$actual_year = $this->Dashboard_model->getYear($year);
	    	$date = $actual_year[0]['year'] . "-" . $formatted_month;
		    if(intval($monthId) === intval($month)){
				$days = $this->getDaysInMonth($monthId, $this->getCurrentYear());
			}
	    }

	    if($days){
			$day = date('d');
			$tpr = $days - $day; 
	    }

	    $brandIds = $this->request->getPost('brands');
        $brandIds = $brandIds === '' ? null : $brandIds;

		$orderColumnIndex = $this->request->getVar('order')[0]['column'] ?? 0;
	    $orderDirection = $this->request->getVar('order')[0]['dir'] ?? 'asc';
	    $columns = $this->request->getVar('columns');
	    $orderByColumn = $columns[$orderColumnIndex]['data'] ?? 'store_name';

		$searchValue = trim($this->request->getVar('search')['value'] ?? '');
		$searchValue = $searchValue === '' ? null : $searchValue;

		if($sysPar){
			$jsonString = $sysPar[0]['brand_label_type'];
			$data = json_decode($jsonString, true);
			$brand_category = array_map(fn($item) => (int) $item['id'], $data);
		    $incentiveRate = $sysPar[0]['sales_incentives'];
		    $amountPerDay = $sysPar[0]['tba_amount_per_ba'];
		    $noOfDays = $sysPar[0]['tba_num_days'];
		    $target_sales = $amountPerDay * $noOfDays;
		}else{
			$brand_category = null;
		    $incentiveRate = 0.015;
		    $amountPerDay = 8000;
		    $noOfDays = 0;
		    
		}
		$target_sales = $amountPerDay * $noOfDays;
		// $lyYear = 2024;
		// $tyYear = 2025;
		// $baId = 78;
		// $yearId = 6;
		// $monthId = 4;
		// $monthEndId = 4;
		// $brandIds = [37];
		// $date = "2025-04";
		// $baTypeId = 3;
		// print_r($target_sales);
		// die();

	    $data = $this->Dashboard_model->salesPerformancePerBa($limit, $offset, $orderByColumn, $orderDirection, $target_sales, $incentiveRate, $monthId, $monthEndId, $lyYear, $tyYear, $yearId, $storeId, $areaId, $ascId, $baId, $baTypeId, $tpr, $brand_category, $brandIds, $searchValue);

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
		$json = $this->request->getJSON(true); 
		$sysPar = $this->Global_model->getSysPar();
		$areaId = trim($json['area']);
		$areaId = $areaId === '' ? null : $areaId;
		
		$ascId = trim($json['asc']);
		$ascId = $ascId === '' ? null : $ascId;
		
		$baTypeId = trim($json['baType']);
		$baTypeId = $baTypeId === '' ? null : $baTypeId;
		
		$baId = $json['ba'];
		$baId = $baId === '' ? null : $baId;
		
		$storeId= trim($json['store']); //change this to store_id
		$storeId = $storeId === '' ? null : $storeId;
		
        $brandIds = $json['brands'];
        $brandIds = $brandIds === '' ? null : $brandIds;
		
	    $year = $json['year']?? 0;            
	    $monthId = $json['month_start'] ?? 1;
	    $monthEndId = $json['month_end'] ?? 12;
		
		$limit = $json['limit'];
		$limit = is_numeric($limit) ? (int)$limit : 10;
		
		$offset = $json['offset'];
		$offset = is_numeric($offset) ? (int)$offset : 0;
		// echo json_encode($json); die();
		
	    $formatted_month = str_pad($monthId, 2, '0', STR_PAD_LEFT);
	    $date = null; 
	    $lookup_month = null;
	    $lyYear = 0;
	    $tyYear = 0;
	    $selected_year = null;
	    $lyMonth = null;
	    $date = null;

	    if($year){
	    	$actual_year = $this->Dashboard_model->getYear($year);
	    	$yearId = $actual_year[0]['id'];
	    	$selected_year = $actual_year[0]['year'];
	    	$lyYear = $selected_year - 1;
	    	$tyYear = $selected_year;
	    	$date = $actual_year[0]['year'];
	    	$targetYear = $actual_year[0]['year'];
	    }

	    if($monthEndId){
	    	$date = $formatted_month;
	    	$lyMonth = $monthId;
	    }
	    
	    $days = null;
	    $tpr = 0;
	    $month = date('m');

		if($year && $monthId){
	    	$actual_year = $this->Dashboard_model->getYear($year);
	    	$date = $actual_year[0]['year'] . "-" . $formatted_month;
		    if(intval($monthId) === intval($month)){
				$days = $this->getDaysInMonth($monthId, $this->getCurrentYear());
			}
	    }

	    if($days){
			$day = date('d');
			$tpr = $days - $day; 
	    }

	    $brandIds = $json['brands'];
        $brandIds = $brandIds === [] ? null : $brandIds;
		
		$searchValue = trim($json['searchValue']);
		$searchValue = $searchValue === '' ? null : $searchValue;
		
		$orderColumnIndex = $json['order'][0]['column'] ?? 0;
	    $orderDirection = $json['order'][0]['dir'] ?? 'asc';
	    $orderByColumn = 'store_name';
		// echo json_encode($json); die();

		if($sysPar){
			$jsonString = $sysPar[0]['brand_label_type'];
			$data = json_decode($jsonString, true);
			$brand_category = array_map(fn($item) => (int) $item['id'], $data);
		    $incentiveRate = $sysPar[0]['sales_incentives'];
		    $amountPerDay = $sysPar[0]['tba_amount_per_ba'];
		    $noOfDays = $sysPar[0]['tba_num_days'];
		    $target_sales = $amountPerDay * $noOfDays;
		}else{
			$brand_category = null;
		    $incentiveRate = 0.015;
		    $amountPerDay = 8000;
		    $noOfDays = 0;
		}
		$target_sales = $amountPerDay * $noOfDays;

		$dv = function($value, $default = 'None') {
			if (is_array($value)) {
				return empty($value) ? $default : implode(', ', $value);
			}
			$value = trim((string)$value);
			return $value === '' ? $default : $value;
		};

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
		
		$result = $this->Global_model->dynamic_search("'tbl_store'", "''", "'description'", 0, 0, "'id:EQ=$storeId'", "''", "''");
		$storeMap = !empty($result) ? $result[0]['description'] : '';
		
		$result = $this->Global_model->dynamic_search("'tbl_brand'", "''", "'brand_description'", 0, 0, "'id:EQ=$brandIds'", "''", "''");
		$brandMap = !empty($result) ? $result[0]['brand_description'] : '';
		
		$result = $this->Global_model->dynamic_search("'tbl_month'", "''", "'month'", 0, 0, "'id:EQ=$monthId'", "''", "''");
		$monthStartMap = !empty($result) ? $result[0]['month'] : '';
		
		$result = $this->Global_model->dynamic_search("'tbl_month'", "''", "'month'", 0, 0, "'id:EQ=$monthEndId'", "''", "''");
		$monthEndMap = !empty($result) ? $result[0]['month'] : '';

		$filterData = [
			'Area'             => $dv($areaMap),
			'ASC'              => $dv($ascMap),
			'BA Type'          => $dv($baTypeString),
			'Brand Ambassador' => $dv($baMap),
			'Store Name'       => $dv($storeMap),
			'Brand Handle'	   => $dv($brandMap),
			'Year'             => $dv($year),
			'Month Range'      => ($monthStartMap && $monthEndMap) ? "$monthStartMap $year - $monthEndMap $year" : 'None',
		];

		$title = "Store Sales Performance per Brand Ambassador";
		$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator('LMI SFA');
		$pdf->SetAuthor('LIFESTRONG MARKETING INC.');
		$pdf->SetTitle($title);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();

		$this->printHeader($pdf, $title);
		$this->printFilter($pdf, $filterData);

		$pdf->SetFont('helvetica', '', 9);

		$result = $this->Dashboard_model->
		salesPerformancePerBa($limit, $offset, $orderByColumn, $orderDirection, $target_sales, $incentiveRate, $monthId, $monthEndId, $lyYear, $tyYear, $yearId, $storeId, 
		$areaId, $ascId, $baId, $baTypeId, $tpr, $brand_category, $brandIds, $searchValue);

		$rows = $result['data'];

		$pageWidth  = $pdf->getPageWidth();
		$margins    = $pdf->getMargins();
		$colWidth   = ($pageWidth - $margins['left'] - $margins['right']) / 14;

		$headers = [
			"Rank",
			"Area",
			"Store",
			"BA",
			"Deploy Date",
			"Brand",
			"LY Data",
			"Actual SR",
			"Target",
			"% Achieved",
			"% Growth",
			"Balance",
			"Incentives",
			"Day Remain"
		];

		$pdf->SetFont('helvetica','B',9);
		foreach ($headers as $h) {
			$pdf->Cell($colWidth, 8, $h, 1, 0, 'C');
		}
		$pdf->Ln();

		$pdf->SetFont('helvetica','',9);

		$lineH = 4;  // mm per text line
		foreach ($rows as $row) {
			$cells = [
				$row->rank,
				$row->area_name,
				$row->store_name,
				$row->ba_name,
				$this->formatDate($row->ba_deployment_date),
				$row->brand_name,
				($this->session->get('sess_site_role') == 7 || $this->session->get('sess_site_role') == 8) ? '-' : $this->formatTwoDecimals($row->ly_scanned_data),
				$this->formatTwoDecimals($row->actual_sales),
				$this->formatTwoDecimals($row->target_sales),
				$row->percent_ach,
				($this->session->get('sess_site_role') == 7 || $this->session->get('sess_site_role') == 8) ? '-' : $row->growth,
				$this->formatTwoDecimals($row->balance_to_target),
				$this->formatTwoDecimals($row->possible_incentives),
				$this->formatTwoDecimals($row->target_per_remaining_days)
			];

			$numLinesArray = array_map(function($text) use ($pdf, $colWidth) {
				return $pdf->getNumLines($text, $colWidth);
			}, $cells);

			$maxLines = max($numLinesArray);
			$rowHeight = $maxLines * $lineH;

			$pageHeight = $pdf->getPageHeight();
			$bottomMargin = $pdf->getBreakMargin();
			$currentY = $pdf->GetY();

			if ($currentY + $rowHeight > ($pageHeight - $bottomMargin)) {
				$pdf->AddPage();
			}

			foreach ($cells as $index => $text) {
				$isLast = $index === count($cells) - 1;
				$pdf->MultiCell(
					$colWidth,
					$rowHeight,
					$text,
					1,
					'C',
					0,
					$isLast ? 1 : 0
				);
			}
		}

		$pdf->Output($title . '.pdf', 'D');
		exit;
	}

	// ================================= Header for pdf export =================================
	private function printHeader($pdf, $title) {
		$pdf->SetFont('helvetica', '', 12);
		$pdf->Cell(0, 10, 'LIFESTRONG MARKETING INC.', 0, 1, 'C');
		$pdf->SetFont('helvetica', '', 10);
		$pdf->Cell(0, 5, 'Report: ' . $title, 0, 1, 'C');
		$pdf->Ln(5);
	}

	// ================================= Display filters for pdf export ================================
	private function printFilter($pdf, $filters) {
		$pdf->SetFont('helvetica', 'B', 9);
		$source = "Actual Sales Report, Scan Data and Target Sales Per Store (LMI/RGDI)";
		$pdf->MultiCell(0, 8, "Source: " . $source, 0, 'C', 0, 1, '', '', true);

		$pdf->SetFont('helvetica', '', 9);
		$pdf->Ln(2);

		$pageWidth  = $pdf->getPageWidth();
		$pageMargin = $pdf->getMargins();
		$perRow   = ceil(count($filters) / 2);
		$colWidth = ($pageWidth - $pageMargin['left'] - $pageMargin['right']) / $perRow;

		// split into two “rows”
		$rows = array_chunk($filters, $perRow, true);

		foreach ($rows as $rowFilters) {
			foreach ($rowFilters as $key => $value) {
				// $pdf->Cell($colWidth, 8, "{$key}: {$value}", 0, 0, 'L');
				$pdf->MultiCell(
					$colWidth,   
					8,       
					"{$key}: {$value}",
					0,            // border
					'L',          // align center
					0,            // no fill
					0,            // stay to the right after (we'll end the row on the last cell)
					'', '', true  // reset height
				);
			}
			$pdf->Ln(8);
		}

		$currentWeek = method_exists($this, 'getCurrentWeek') ? $this->getCurrentWeek() : null;
		$currentWeekDisplay = $currentWeek ? $currentWeek['display'] : 'Unknown Week';

		$currentWeekText = 'Current Week: ' . $currentWeekDisplay;
		$generatedText   = 'Generated Date: ' . date('M d, Y, h:i:s A');

		// Adjust spacing manually between them
		$pdf->Cell(100, 6, $currentWeekText, 0, 0, 'L');  // Width ~100mm for week
		$pdf->Cell(38, 6, '', 0, 0);                      // Spacer ~10mm
		$pdf->Cell(0, 6, $generatedText, 0, 1, 'L');      // Remaining width for date

		$pdf->Ln(2);
		$pdf->Cell(0, 0, '', 'T');
		$pdf->Ln(4);
	}

	public function generateExcel()
	{	
		$sysPar = $this->Global_model->getSysPar();
		$areaId = trim($this->request->getGet('area'));
		$areaId = $areaId === '' ? null : $areaId;

		$ascId = trim($this->request->getGet('asc'));
		$ascId = $ascId === '' ? null : $ascId;

		$baTypeId = trim($this->request->getGet('baType'));
		$baTypeId = $baTypeId === '' ? null : $baTypeId;

		$baId = trim($this->request->getGet('ba'));
		$baId = $baId === '' ? null : $baId;

		$storeId= trim($this->request->getGet('store')); //change this to store_id
		$storeId = $storeId === '' ? null : $storeId;

        $brandIds = $this->request->getGet('brands');
        $brandIds = $brandIds === '' ? null : $brandIds;

	    $year = $this->request->getGet('year')?? 0;            
	    $monthId = $this->request->getVar('month_start') ?? 1;
	    $monthEndId = $this->request->getVar('month_end') ?? 12;

		$limit = $this->request->getVar('limit');
		$limit = is_numeric($limit) ? (int)$limit : 10;

		$offset = $this->request->getVar('offset');
		$offset = is_numeric($offset) ? (int)$offset : 0;

	    $formatted_month = str_pad($monthId, 2, '0', STR_PAD_LEFT);
	    $date = null; 
	    $lookup_month = null;
	    $lyYear = 0;
	    $tyYear = 0;
	    $selected_year = null;
	    $lyMonth = null;
	    $date = null;

	    if($year){
	    	$actual_year = $this->Dashboard_model->getYear($year);
	    	$yearId = $actual_year[0]['id'];
	    	$selected_year = $actual_year[0]['year'];
	    	$lyYear = $selected_year - 1;
	    	$tyYear = $selected_year;
	    	$date = $actual_year[0]['year'];
	    	$targetYear = $actual_year[0]['year'];
	    }

	    if($monthEndId){
	    	$date = $formatted_month;
	    	$lyMonth = $monthId;
	    }
	    
	    $days = null;
	    $tpr = 0;
	    $month = date('m');

		if($year && $monthId){
	    	$actual_year = $this->Dashboard_model->getYear($year);
	    	$date = $actual_year[0]['year'] . "-" . $formatted_month;
		    if(intval($monthId) === intval($month)){
				$days = $this->getDaysInMonth($monthId, $this->getCurrentYear());
			}
	    }

	    if($days){
			$day = date('d');
			$tpr = $days - $day; 
	    }
	    
	    $brandIds = $this->request->getGet('brands');
        $brandIds = $brandIds === '' ? null : $brandIds;

		$searchValue = trim($this->request->getGet('searchValue'));
		$searchValue = $searchValue === '' ? null : $searchValue;

		$orderColumnIndex = $this->request->getVar('order')[0]['column'] ?? 0;
	    $orderDirection = $this->request->getVar('order')[0]['dir'] ?? 'asc';
	    $columns = $this->request->getVar('columns');
	    $orderByColumn = $columns[$orderColumnIndex]['data'] ?? 'store_name';

		if($sysPar){
			$jsonString = $sysPar[0]['brand_label_type'];
			$data = json_decode($jsonString, true);
			$brand_category = array_map(fn($item) => (int) $item['id'], $data);
		    $incentiveRate = $sysPar[0]['sales_incentives'];
		    $amountPerDay = $sysPar[0]['tba_amount_per_ba'];
		    $noOfDays = $sysPar[0]['tba_num_days'];
		    $target_sales = $amountPerDay * $noOfDays;
		}else{
			$brand_category = null;
		    $incentiveRate = 0.015;
		    $amountPerDay = 8000;
		    $noOfDays = 0;
		    
		}
		$target_sales = $amountPerDay * $noOfDays;

	    $data = $this->Dashboard_model->salesPerformancePerBa($limit, $offset, $orderByColumn, $orderDirection, $target_sales, $incentiveRate, $monthId, $monthEndId, $lyYear, $tyYear, $yearId, $storeId, $areaId, $ascId, $baId, $baTypeId, $tpr, $brand_category, $brandIds, $searchValue);
		
		$title = "Store Sales Performance per Brand Ambassador";
		$rows = $data['data'];

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

		$result = $this->Global_model->dynamic_search("'tbl_store'", "''", "'description'", 0, 0, "'id:EQ=$storeId'", "''", "''");
		$storeMap = !empty($result) ? $result[0]['description'] : '';

		$result = $this->Global_model->dynamic_search("'tbl_brand'", "''", "'brand_description'", 0, 0, "'id:EQ=$brandIds'", "''", "''");
		$brandMap = !empty($result) ? $result[0]['brand_description'] : '';

		$result = $this->Global_model->dynamic_search("'tbl_month'", "''", "'month'", 0, 0, "'id:EQ=$monthId'", "''", "''");
		$monthStartMap = !empty($result) ? $result[0]['month'] : '';

		$result = $this->Global_model->dynamic_search("'tbl_month'", "''", "'month'", 0, 0, "'id:EQ=$monthEndId'", "''", "''");
		$monthEndMap = !empty($result) ? $result[0]['month'] : '';

		$spreadsheet = new Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();

		$currentWeek = $this->getCurrentWeek();
		$currentWeekDisplay = $currentWeek ? $currentWeek['display'] : 'Unknown Week';

		$sheet->setCellValue('A1', 'LIFESTRONG MARKETING INC.');
		$sheet->setCellValue('A2', 'Report: Store Sales Performance per Brand Ambassador');
		$sheet->setCellValue('A4', 'Source: Actual Sales Report, Scan Data and Target Sales Per Store (LMI/RGDI)');
		$sheet->setCellValue('A5', 'Current Week: ' . $currentWeekDisplay);
		$sheet->mergeCells('A1:C1');
		$sheet->mergeCells('A2:C2');
		

		$sheet->setCellValue('A7', 'Area: '   . ($areaMap ?: 'NONE'));
		$sheet->setCellValue('A8', 'ASC: ' . ($ascMap ?: 'NONE'));

		$sheet->setCellValue('B7', 'BA Type: '. ($baTypeString ?: 'NONE'));
		$sheet->setCellValue('B8', 'BA: ' . ($baMap ?: 'NONE'));

		$sheet->setCellValue('C7', 'Store: '  . ($storeMap ?: 'NONE'));
		$sheet->setCellValue('C8', 'Brand: ' . ($brandMap ?: 'NONE'));

		$sheet->setCellValue('D7', 'Month Start: ' . ($monthStartMap ?: 'NONE'));
		$sheet->setCellValue('D8', 'Month End: '   . ($monthEndMap ?: 'NONE'));

		$sheet->setCellValue('E7', 'Year: '        . ($year ?: 'NONE'));
		$sheet->setCellValue('E8', 'Date Generated: ' . date('M d, Y, h:i:s A'));

		$headers = [
			"Rank",
			"Area",
			"Store Code / Store Name",
			"Brand Ambassador",
			"Deployed Date",
			"Brand Handle",
			"LY Scanned Data",
			"Actual Sales Report",
			"Target",
			"% Achieved",
			"% Growth",
			"Balance to Target",
			"Possible Incentives",
			"Target per Remaining Days"
		];
		$sheet->fromArray($headers, null, 'A10');
		$sheet->getStyle('A10:N10')->getFont()->setBold(true);

		$rowNum = 11;
		$role = $this->session->get('sess_site_role');
		foreach ($rows as $row) {
			$sheet->setCellValue('A'.$rowNum,$row->rank);
			$sheet->setCellValue('B'.$rowNum,$row->area_name);
			$sheet->setCellValue('C'.$rowNum,$row->store_name);
			$sheet->setCellValue('D'.$rowNum,$row->ba_name);
			$sheet->setCellValue('E'.$rowNum,$row->ba_deployment_date);
			$sheet->setCellValue('F'.$rowNum,$row->brand_name);			
			if ($role == 7 || $role == 8) {
				$sheet->setCellValue('G'.'-');
			}else{
				$sheet->setCellValue('G'.$rowNum,$row->ly_scanned_data);
			}
			$sheet->setCellValue('H'.$rowNum,$row->actual_sales);
			$sheet->setCellValue('I'.$rowNum,$row->target_sales);
			$sheet->setCellValue('J'.$rowNum,$row->percent_ach);
			if ($role == 7 || $role == 8) {
				$sheet->setCellValue('K'.'-');
			}else{
				$sheet->setCellValue('K'.$rowNum,$row->growth);
			}
			$sheet->setCellValue('L'.$rowNum,$row->balance_to_target);
			$sheet->setCellValue('M'.$rowNum,$row->possible_incentives);
			$sheet->setCellValue('N'.$rowNum,$row->target_per_remaining_days);

			$rowNum++;
		}

		foreach (range('A','N') as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
		}

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
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

	private function formatTwoDecimals($value): string {
		if (is_null($value) || !is_numeric($value)) {
			$value = 0;
		}
		return number_format((float)$value, 2, '.', ',');
	}

	private function formatDate($dateStr) {
		if (empty($dateStr) || $dateStr === '0000-00-00') return '-';
		$timestamp = strtotime($dateStr);
		return date('M-d-y', $timestamp);
	}

}
