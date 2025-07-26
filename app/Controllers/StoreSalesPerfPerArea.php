<?php

namespace App\Controllers;

use Config\Database;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StoreSalesPerfPerArea extends BaseController
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

	public function perfPerArea()
	{
		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);

		$data['months'] = $this->Global_model->getMonths();
		$data['year'] = $this->Global_model->getYears();
		$data['store_branches'] = $this->Global_model->getStoreBranch(0);
		$data['brands'] = $this->Global_model->getBrandData("ASC", 99999, 0);
		$data['asc'] = $this->Global_model->getAsc(0);
		$data['areas'] = $this->Global_model->getArea(0);
		$data['title'] = "Trade Dashboard";
		$data['PageName'] = 'Trade Dashboard';
		$data['PageUrl'] = 'Trade Dashboard';

		$data["breadcrumb"] = array('Store' => base_url('store/sales-performance-per-area'),'Store Sales Performance per Area' => '');
		$data["source"] = "Actual Sales Report / Scan Data (LMI/RGDI)";
		$data["source_date"] = '<span id="sourceDate">N / A</span>';	
		$data['content'] = "site/store/perf-per-area/sales_performance_per_area";
		$data['session'] = session();
		$data['js'] = array(
			"assets/site/bundle/js/bundle.min.js"
                    );
        $data['css'] = array(
        	"assets/site/bundle/css/bundle.min.css"
                    );
		return view("site/layout/template", $data);
	}

	public function getPerfPerArea()
	{	
		$sysPar = $this->Global_model->getSysPar();
		$areaId = trim($this->request->getPost('area'));
		$areaId = $areaId === '' ? null : $areaId;
		$ascId = trim($this->request->getPost('asc'));
		$ascId = $ascId === '' ? null : $ascId;
		$baTypeId = trim($this->request->getPost('baType'));
		$baTypeId = $baTypeId === '' ? null : $baTypeId;
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

	    if(empty($area)){
	    	$area = null;
	    }
	    if(empty($store)){
	    	$store = null;
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
		// $yearId = 6;
		// $monthId = 4;
		// $monthEndId = 4;
		// $lyYear = 2024;
		// $tyYear = 2025;
		// $date = "2025-04";
		// echo $year.'sdfsd';
		// die();
		//$areaId = 5;
		//$baTypeId = 3;
		$storeId = null;
		$baId = null;
	    $data = $this->Dashboard_model->salesPerformancePerArea($limit, $offset, $orderByColumn, $orderDirection, $target_sales, $incentiveRate, $monthId, $monthEndId, $lyYear, $tyYear, $yearId, $storeId, $areaId, $ascId, $baId, $baTypeId, $tpr, $brand_category, $brandIds, $searchValue);

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

	private function formatTwoDecimals($value): string {
		if (!is_numeric($value) || $value == 0) {
			return '0.00';
		}
		return number_format((float)$value, 2, '.', ',');
	}

	private function formatComma($value): string {
		if (!is_numeric($value)) {
			return (string)$value;
		}
		return number_format((float)$value, 0, '.', ',');
	}

	// ================================= Display filters for pdf export ================================
	private function printFilter($pdf, $filters) {
		$pdf->SetFont('helvetica', 'B', 9);
		$source = "Actual Sales Report / Scan Data (LMI/RGDI)";
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
				$pdf->Cell($colWidth, 8, "{$key}: {$value}", 0, 0, 'L');
			}
			$pdf->Ln(8);
		}

		$currentWeek = method_exists($this, 'getCurrentWeek') ? $this->getCurrentWeek() : null;
		$currentWeekDisplay = $currentWeek ? $currentWeek['display'] : 'Unknown Week';

		$currentWeekText = 'Current Week: ' . $currentWeekDisplay;
		$generatedText   = 'Generated Date: ' . date('M d, Y, h:i:s A');

		// Adjust spacing manually between them
		$pdf->Cell(100, 6, $currentWeekText, 0, 0, 'L');  // Width ~100mm for week
		$pdf->Cell(85, 6, '', 0, 0);                      // Spacer ~10mm
		$pdf->Cell(0, 6, $generatedText, 0, 1, 'L');      // Remaining width for date

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
		$json = $this->request->getJSON(true);
		$sysPar = $this->Global_model->getSysPar();
		$areaId = $json['area'];
		$areaId = $areaId === '' ? null : $areaId;
		$ascId = $json['asc'];
		$ascId = $ascId === '' ? null : $ascId;
		$baTypeId = $json['baType'];
		$baTypeId = $baTypeId === '' ? null : $baTypeId;
        $brandIds = $json['brands'];
        $brandIds = $brandIds === '' ? null : $brandIds;
	    $year = $json['year']?? 0;  
		$yearId = null;          
	    $monthId = $json['monthStart'] ?? 1;
	    $monthEndId = $json['monthEnd'] ?? 12;
		$limit = 99999;
		$offset = 0;

	    $lyYear = 0;
	    $tyYear = 0;
	    $selected_year = null;

		if($year){
	    	$actual_year = $this->Dashboard_model->getYear($year);
	    	$yearId = $actual_year[0]['id'];
	    	$selected_year = $actual_year[0]['year'];
	    	$lyYear = $selected_year - 1;
	    	$tyYear = $selected_year;
	    }

		$days = null;
	    $tpr = 0;
	    $month = date('m');

		if($year && $monthId){
	    	$actual_year = $this->Dashboard_model->getYear($year);
		    if(intval($monthId) === intval($month)){
				$days = $this->getDaysInMonth($monthId, $this->getCurrentYear());
			}
	    }

		if($days){
			$day = date('d');
			$tpr = $days - $day; 
	    }

	    if(empty($area)){
	    	$area = null;
	    }
	    if(empty($store)){
	    	$store = null;
	    }
	    $brandIds = $json['brands'];
        $brandIds = $brandIds === '' ? null : $brandIds;

		$orderColumnIndex = $json['order'][0]['column'] ?? 0;
	    $orderDirection = $json['order'][0]['dir'] ?? 'asc';

		$searchValue = trim($json['searchValue'] ?? '');
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

		$storeId = null;
		$baId = null;

		// helper closure to turn empty values into “None”
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
		
		$areaMap = $json['textArea'];
		$ascMap = $json['textAsc'];
		$result = $json['brandList'];
		if (is_array($result)) {
			$brandMap = implode(', ', $result);
		} else {
			$brandMap = '';
		}
		$monthStartMap = $json['textMonthStart'];
		$monthEndMap = $json['textMonthEnd'];

		$filterData = [
			'Area'             => $dv($areaMap),
			'ASC'              => $dv($ascMap),
			'BA Type'          => $dv($baTypeString),
			'Item Brand'	   => $dv($brandMap),
			'Year'             => $dv($year),
			'Month Range'      => ($monthStartMap && $monthEndMap) ? "$monthStartMap - $monthEndMap" : 'None',
		];

		$title = "Store Sales Performance per Area";
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
		$result = $this->Dashboard_model->salesPerformancePerArea(
			$limit, $offset, $orderColumnIndex, $orderDirection, 
			$target_sales, $incentiveRate, $monthId, $monthEndId, 
			$lyYear, $tyYear, $yearId, $storeId, 
			$areaId, $ascId, $baId, $baTypeId, 
			$tpr, $brand_category, $brandIds, $searchValue
		);
		$rows = $result['data'];

		$pageWidth  = $pdf->getPageWidth();
		$margins    = $pdf->getMargins();
		$colWidth   = ($pageWidth - $margins['left'] - $margins['right']) / 10;

		$headers = [
			'Rank',
			'Area',
			'Area Sales Coordinator',
			'LY Scan Data',
			'Actual Sales Report',
			'Target',
			'% Achieved',
			'% Growth',
			'Balance to Target',
			'Target Per Remaining Days',
		];

		$pdf->SetFont('helvetica','B',9);
		foreach ($headers as $i => $text) {
			$isLast = $i === count($headers) - 1 ? 1 : 0;
			$pdf->MultiCell(
				$colWidth,   // cell width
				8,           // cell height
				$text,       // header text
				1,           // border
				'C',         // center align
				0,           // no fill
				$isLast,     // Ln: 0 = stay on same line, 1 = move to next line after
				'', '',      // x/y position (auto)
				true         // reset the last cell height if needed
			);
		}

		$pdf->SetFont('helvetica','',9);
		$lineH = 4; 
		$role = $this->session->get('sess_site_role');
		foreach ($rows as $row) {
			$numNameLines = $pdf->getNumLines($row->store_name, $colWidth);
			$numLines = max(1, $numNameLines);
			$rowH = 8;

			$formatBalanceToTarget         = $this->formatTwoDecimals($row->balance_to_target);
			$formatTargetPerRemainingDays  = $this->formatComma($row->target_per_remaining_days);
			$formatActualSalesReport    	= $this->formatTwoDecimals($row->actual_sales);	
			$formatTargetSalesTarget		= $row->target_sales;
			
			// rank 
			$pdf->Cell($colWidth, $rowH, $row->rank, 1, 0, 'C');
			// area
			$pdf->MultiCell($colWidth, $rowH, $row->area_name, 1, 'C', 0, 0, '', '', true);
			// area sales coordinator 
			$pdf->MultiCell($colWidth, $rowH, $row->asc_name, 1, 'C', 0, 0, '', '', true);
			// ly scan data
			if ($role == 7 || $role == 8) {
				$pdf->Cell($colWidth, $rowH, '-', 1, 0, 'C');	
			}else{
				$pdf->Cell($colWidth, $rowH, $row->ly_scanned_data, 1, 0, 'C');
			}
			// actual sales report
			$pdf->Cell($colWidth, $rowH, $formatActualSalesReport, 1, 0, 'C');
			// target
			$pdf->Cell($colWidth, $rowH, $formatTargetSalesTarget, 1, 0, 'C');
			// achieve 
			$pdf->Cell($colWidth, $rowH, $row->percent_ach, 1, 0, 'C');
			// growth
			if ($role == 7 || $role == 8) {
				$pdf->Cell($colWidth, $rowH, '-', 1, 0, 'C');	
			}else{
				$pdf->Cell($colWidth, $rowH, $row->growth, 1, 0, 'C');
			}
			// balance to target
			$pdf->Cell($colWidth, $rowH, $formatBalanceToTarget, 1, 0, 'C');
			// target per remaining days
			$pdf->Cell($colWidth, $rowH, $formatTargetPerRemainingDays, 1, 1, 'C');
		}

		$pdf->Output($title . '.pdf', 'D');
		exit;
	}

	public function generateExcel() {
        $json = $this->request->getJSON(true);
		$sysPar = $this->Global_model->getSysPar();
		$areaId = $json['area'];
		$areaId = $areaId === '' ? null : $areaId;
		$ascId = $json['asc'];
		$ascId = $ascId === '' ? null : $ascId;
		$baTypeId = $json['baType'];
		$baTypeId = $baTypeId === '' ? null : $baTypeId;
        $brandIds = $json['brands'];
        $brandIds = $brandIds === '' ? null : $brandIds;
	    $year = $json['year']?? 0;  
		$yearId = null;          
	    $monthId = $json['monthStart'] ?? 1;
	    $monthEndId = $json['monthEnd'] ?? 12;
		$limit = 99999;
		$offset = 0;

	    $lyYear = 0;
	    $tyYear = 0;
	    $selected_year = null;

		if($year){
	    	$actual_year = $this->Dashboard_model->getYear($year);
	    	$yearId = $actual_year[0]['id'];
	    	$selected_year = $actual_year[0]['year'];
	    	$lyYear = $selected_year - 1;
	    	$tyYear = $selected_year;
	    }

		$days = null;
	    $tpr = 0;
	    $month = date('m');

		if($year && $monthId){
	    	$actual_year = $this->Dashboard_model->getYear($year);
		    if(intval($monthId) === intval($month)){
				$days = $this->getDaysInMonth($monthId, $this->getCurrentYear());
			}
	    }

		if($days){
			$day = date('d');
			$tpr = $days - $day; 
	    }

	    if(empty($area)){
	    	$area = null;
	    }
	    if(empty($store)){
	    	$store = null;
	    }
	    $brandIds = $json['brands'];
        $brandIds = $brandIds === '' ? null : $brandIds;

		$orderColumnIndex = $json['order'][0]['column'] ?? 0;
	    $orderDirection = $json['order'][0]['dir'] ?? 'asc';

		$searchValue = trim($json['searchValue'] ?? '');
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

		$storeId = null;
		$baId = null;

		$title = "Store Sales Performance per Area";
		$data = $this->Dashboard_model->salesPerformancePerArea(
            $limit, $offset, $orderColumnIndex, $orderDirection, 
            $target_sales, $incentiveRate, $monthId, $monthEndId, 
            $lyYear, $tyYear, $yearId, $storeId, 
            $areaId, $ascId, $baId, $baTypeId, 
            $tpr, $brand_category, $brandIds, $searchValue
        );
		$rows   = $data['data'];

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

		$areaMap = $json['textArea'];
		$ascMap = $json['textAsc'];
		$result = $json['brandList'];
		if (is_array($result)) {
			$brandMap = implode(', ', $result);
		} else {
			$brandMap = '';
		}
		$monthStartMap = $json['textMonthStart'];
		$monthEndMap = $json['textMonthEnd'];;

		$spreadsheet = new Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();

		$currentWeek = $this->getCurrentWeek();
		$currentWeekDisplay = $currentWeek ? $currentWeek['display'] : 'Unknown Week';

		$sheet->setCellValue('A1', 'LIFESTRONG MARKETING INC.');
		$sheet->setCellValue('A2', 'Report: Store Sales Performance Overall');
		$sheet->setCellValue('A4', 'Source: Actual Sales Report / Scan Data (LMI/RGDI)');
		$sheet->setCellValue('A5', 'Current Week: ' . $currentWeekDisplay);
		$sheet->mergeCells('A1:C1');
		$sheet->mergeCells('A2:C2');

		$sheet->setCellValue('A7', 'Area: '  . ($areaMap ?: 'NONE'));
		$sheet->setCellValue('B7', 'ASC: ' . ($ascMap ?: 'NONE'));
		$sheet->setCellValue('C7', 'BA Type: '. ($baTypeString     ?: 'NONE'));
		$sheet->setCellValue('D7', 'Brand: ' . ($brandMap     ?: 'NONE'));

		$sheet->setCellValue('A8', 'Month Start: ' . ($monthStartMap ?: 'NONE'));
		$sheet->setCellValue('B8', 'Month End: '   . ($monthEndMap   ?: 'NONE'));
		$sheet->setCellValue('C8', 'Year: '        . ($year       ?: 'NONE'));
		$sheet->setCellValue('D8', 'Date Generated: ' . date('M d, Y, h:i:s A'));

		$headers = [
			'Rank',
			'Area',
			'Area Sales Coordinator',
			'LY Scan Data',
			'Actual Sales Report',
			'Target',
			'% Achieved',
			'% Growth',
			'Balance to Target',
			'Target Per Remaining Days',
		];

		$sheet->fromArray($headers, null, 'A10');
		$sheet->getStyle('A10:J10')->getFont()->setBold(true);

		$rowNum = 11;
		$role = $this->session->get('sess_site_role');
		foreach ($rows as $row) {
			$sheet->setCellValue('A'.$rowNum,$row->rank);
			$sheet->setCellValue('B'.$rowNum,$row->area_name);
			$sheet->setCellValue('C'.$rowNum, $row->asc_name);
			if ($role == 7 || $role == 8) {
				$sheet->setCellValue('D'.$rowNum, '-');
			}else{
				$sheet->setCellValue('D'.$rowNum, $row->ly_scanned_data);
			}
			$sheet->setCellValue('E'.$rowNum, $row->actual_sales);
			$sheet->setCellValue('F'.$rowNum, $row->target_sales);
			$sheet->setCellValue('G'.$rowNum, $row->percent_ach);
			if ($role == 7 || $role == 8) {
				$sheet->setCellValue('H'.$rowNum, '-');
			}else{
				$sheet->setCellValue('H'.$rowNum, $row->growth);
			}
			$sheet->setCellValue('I'.$rowNum, $row->balance_to_target);
			$sheet->setCellValue('J'.$rowNum, $row->target_per_remaining_days);

			$rowNum++;
		}

		foreach (range('A','J') as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
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
