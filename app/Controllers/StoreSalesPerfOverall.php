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
		$data["breadcrumb"] = array('Store' => base_url('store/sales-overall-growth'),'Overall Stores Sales Growth' => '');
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

	    $searchValue = trim($this->request->getVar('search')['value'] ?? '');
		$searchValue = $searchValue === '' ? null : $searchValue;

	    //$this->Dashboard_model->refreshPreAggregatedDataScanData();	
	    $data = $this->Dashboard_model->getStorePerformance($monthId, $monthEndId, $orderByColumn, $orderDirection, $yearId, $limit, $offset, $areaId, $ascId, $storeCode, $baId, $baTypeId, $brandCategoriesIds, $brandIds, $searchValue);

	    return $this->response->setJSON([
	        'draw' => intval($this->request->getVar('draw')),
	        'recordsTotal' => $data['total_records'],
	        'recordsFiltered' => $data['total_records'],
	        'data' => $data['data']
	    ]);
	}

	public function generatePdf() {	
		$json = $this->request->getJSON(true);
		$area              = $json['area'];
		$area = $area === '' ? null : $area;
		$asc               = $json['asc'];
		$asc = $asc === '' ? null : $asc;
		$baType            = $json['baType'];
		$baType = $baType === '' ? null : $baType;
		$brandAmbassador   = $json['ba'];
		$brandAmbassador = $brandAmbassador === '' ? null : $brandAmbassador;
		$store             = $json['store'];
		$store = $store === '' ? null : $store;
		$rawBrandCat 	   = $json['brandCategories'];
		$rawBrands         = $json['brands'];
		if (is_array($rawBrandCat)) {
			$brandCategories = implode(', ', $rawBrandCat);
		} else {
			$brandCategories = null;
		}
		if (is_array($rawBrands)) {
			$brands = implode(', ', $rawBrands);
		} else {
			$brands = null;
		}

		$year              = $json['year'];
		$monthStart        = $json['monthStart'];
		$monthEnd          = $json['monthEnd'];

		$orderColumnIndex = 'rank';
		$orderDirection   = 'asc';
		
		$searchValue = trim($json['searchValue'] ?? '');
		$searchValue = $searchValue === '' ? null : $searchValue;

		// helper closure to turn empty values into “None”
		$dv = function($value, $default = 'None') {
			if (is_array($value)) {
				return empty($value) ? $default : implode(', ', $value);
			}
			$value = trim((string)$value);
			return $value === '' ? $default : $value;
		};

		$baTypeString = '';
		switch ($baType) {
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

		$result = $json['textArea'];
		$areaMap = $result === '' ? '' : $result;
		$result = $json['textAsc'];
		$ascMap = $result === '' ? '' : $result;
		$result = $json['textBa'];
		$baMap = $result === '' ? '' : $result;
		$result = $json['textStore'];
		$storeMap = $result === '' ? '' : $result;
		$result = $json['textBrandCategories']; // multi
		if (is_array($result)) {
			$brandLabelMap = implode(', ', $result);
		} else {
			$brandLabelMap = null;
		}
		$result = $json['textBrands']; // multi
		if (is_array($result)) {
			$brandMap = implode(', ', $result);
		} else {
			$brandMap = null;
		}
		$result = $json['textMonthStart'];
		$monthStartMap = $result === '' ? '' : $result;
		$result = $json['textMonthEnd'];
		$monthEndMap = $result === '' ? '' : $result;
				
		$years = $this->Global_model->get_data_list(
			'tbl_year', null, 0, 0, 
			'year','','', '', ''
		);
		$year_values = array_column($years, 'year');
		$latest_year = !empty($year_values) ? max($year_values) : 'N/A';

		$filterData = [
			'Area'             => $dv($areaMap),
			'ASC'              => $dv($ascMap),
			'BA Type'          => $dv($baTypeString),
			'Brand Ambassador' => $dv($baMap),
			'Store Name'       => $dv($storeMap),
			'Brand Label Type' => $dv($brandLabelMap),
			'Brand Handle'	   => $dv($brandMap),
			'Year'             => $dv($year),
			'Month Range'      => ($monthStartMap && $monthEndMap) ? "$monthStartMap - $monthEndMap" : 'None',
		];

		$title = "Overall Store Sales Growth";
		$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator('LMI SFA');
		$pdf->SetAuthor('LIFESTRONG MARKETING INC.');
		$pdf->SetTitle($title);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();

		$this->printHeader($pdf, $title);
		$this->printFilter($pdf, $filterData, $latest_year);

		$pdf->SetFont('helvetica', '', 9);

		$result = $this->Dashboard_model->getStorePerformance(
			$monthStart, $monthEnd, 
			$orderColumnIndex, $orderDirection, 
			$year, 9999, 0, 
			$area, $asc, $store, 
			$brandAmbassador, $baType, $rawBrandCat, 
			$rawBrands, $searchValue
		);
		$rows = $result['data'];

		$pageWidth  = $pdf->getPageWidth();
		$margins    = $pdf->getMargins();
		$colWidth   = ($pageWidth - $margins['left'] - $margins['right']) / 6;

		$headers = [
			'Rank',
			'Store Code/Store Name',
			'LY Sell Out',
			'TY Sell Out',
			'% Growth',
			'Share of Business',
		];

		$pdf->SetFont('helvetica','B',9);
		foreach ($headers as $h) {
			$pdf->Cell($colWidth, 8, $h, 1, 0, 'C');
		}
		$pdf->Ln();

		$pdf->SetFont('helvetica','',9);

		$lineH = 4;  // mm per text line
		$role = $this->session->get('sess_site_role');
		foreach ($rows as $row) {
			$numNameLines = $pdf->getNumLines($row->store_name, $colWidth);
			$numLines = max(1, $numNameLines);
			// $rowH = $numLines * $lineH;
			$rowH = 8;
			
			$pdf->Cell($colWidth, $rowH, $row->rank,             1, 0, 'C');
			// $pdf->Cell($colWidth, 8, $row->store_name,       1, 0, 'C');
			$pdf->MultiCell(
				$colWidth,   
				$rowH,       
				$row->store_name,
				1,            // border
				'C',          // align center
				0,            // no fill
				0,            // stay to the right after (we'll end the row on the last cell)
				'', '', true  // reset height
			);

			if ($role == 7 || $role == 8) {
				$pdf->Cell($colWidth, $rowH, '-',  1, 0, 'C');
			}else{
				$pdf->Cell($colWidth, $rowH, $row->ly_scanned_data,  1, 0, 'C');
			}
			
			$pdf->Cell($colWidth, $rowH, $row->ty_scanned_data,  1, 0, 'C');
			
			if ($role == 7 || $role == 8) {
				$pdf->Cell($colWidth, $rowH, '-',  1, 0, 'C');
			}else{
				$pdf->Cell($colWidth, $rowH, $row->growth,           1, 0, 'C');
			}
			
			$pdf->Cell($colWidth, $rowH, $row->sob,              1, 1, 'C');
		}

		$pdf->Output($title . '.pdf', 'D');
		exit;
	}

	public function generateExcel() {
		$json = $this->request->getJSON(true);
		$area              = $json['area'];
		$area = $area === '' ? null : $area;
		$asc               = $json['asc'];
		$asc = $asc === '' ? null : $asc;
		$baType            = $json['baType'];
		$baType = $baType === '' ? null : $baType;
		$brandAmbassador   = $json['ba'];
		$brandAmbassador = $brandAmbassador === '' ? null : $brandAmbassador;
		$store             = $json['store'];
		$store = $store === '' ? null : $store;
		$rawBrandCat 	   = $json['brandCategories'];
		$rawBrands         = $json['brands'];
		if (is_array($rawBrandCat)) {
			$brandCategories = implode(', ', $rawBrandCat);
		} else {
			$brandCategories = null;
		}
		if (is_array($rawBrands)) {
			$brands = implode(', ', $rawBrands);
		} else {
			$brands = null;
		}

		$year              = $json['year'];
		$monthStart        = $json['monthStart'];
		$monthEnd          = $json['monthEnd'];

		$orderColumnIndex = 'rank';
		$orderDirection   = 'asc';
		
		$searchValue = trim($json['searchValue'] ?? '');
		$searchValue = $searchValue === '' ? null : $searchValue;

		$title = "Overall Store Sales Growth";
		$data = $this->Dashboard_model->getStorePerformance(
			$monthStart, $monthEnd, 
			$orderColumnIndex, $orderDirection, $year, 
			999999, 0, 
			$area, $asc, $store, 
			$brandAmbassador, $baType, $rawBrandCat, 
			$rawBrands, $searchValue
		);
		$rows   = $data['data'];

		$baTypeString = '';
		switch ($baType) {
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

		$result = $json['textArea'];
		$areaMap = $result === '' ? '' : $result;
		$result = $json['textAsc'];
		$ascMap = $result === '' ? '' : $result;
		$result = $json['textBa'];
		$baMap = $result === '' ? '' : $result;
		$result = $json['textStore'];
		$storeMap = $result === '' ? '' : $result;
		$result = $json['textBrandCategories']; // multi
		if (is_array($result)) {
			$brandLabelMap = implode(', ', $result);
		} else {
			$brandLabelMap = null;
		}
		$result = $json['textBrands']; // multi
		if (is_array($result)) {
			$brandMap = implode(', ', $result);
		} else {
			$brandMap = null;
		}
		$result = $json['textMonthStart'];
		$monthStartMap = $result === '' ? '' : $result;
		$result = $json['textMonthEnd'];
		$monthEndMap = $result === '' ? '' : $result;
				
		$years = $this->Global_model->get_data_list(
			'tbl_year', null, 0, 0, 
			'year','','', '', ''
		);
		$year_values = array_column($years, 'year');
		$latest_year = !empty($year_values) ? max($year_values) : 'N/A';

		$spreadsheet = new Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();

		$currentWeek = method_exists($this, 'getCurrentWeek') ? $this->getCurrentWeek() : null;
		$currentWeekDisplay = $currentWeek ? $currentWeek['display'] : 'Unknown Week';

		$sheet->setCellValue('A1', 'LIFESTRONG MARKETING INC.');
		$sheet->setCellValue('A2', 'Report: Overall Store Sales Growth');
		$sheet->setCellValue('A4', 'Source: Scan Data(LMI/RGDI) - ' . $latest_year);
		$sheet->setCellValue('A5', 'Current Week: ' . $currentWeekDisplay);
		$sheet->mergeCells('A1:C1');
		$sheet->mergeCells('A2:C2');

		$sheet->setCellValue('A7', 'Store: '  . ($storeMap ?: 'NONE'));
		$sheet->setCellValue('B7', 'Area: '   . ($areaMap       ?: 'NONE'));
		$sheet->setCellValue('C7', 'Sort By: '. ($ascMap        ?: 'NONE'));
		$sheet->setCellValue('D7', 'BA Type: '. ($baTypeString     ?: 'NONE'));
		$sheet->setCellValue('E7', 'Brand: ' . ($brandMap     ?: 'NONE'));
		$sheet->setCellValue('F7', 'Brand Ambassador: ' . ($baMap ?: 'NONE'));
		$sheet->setCellValue('A8', 'Brand Category: ' . ($brandLabelMap ?: 'NONE'));
		$sheet->setCellValue('B8', 'ASC: ' . ($ascMap ?: 'NONE'));

		$sheet->setCellValue('C8', 'Month Start: ' . ($monthStartMap ?: 'NONE'));
		$sheet->setCellValue('D8', 'Month End: '   . ($monthEndMap   ?: 'NONE'));
		$sheet->setCellValue('E8', 'Year: '        . ($year       ?: 'NONE'));
		$sheet->setCellValue('F8', 'Date Generated: ' . date('M d, Y, h:i:s A'));

		$headers = [
			"Rank",
			"Store Code/Store Name",
			"LY Sell Out",
			"TY Sell Out",
			"% Growth",
			"Share of Business"
		];
		$sheet->fromArray($headers, null, 'A10');
		$sheet->getStyle('A10:F10')->getFont()->setBold(true);


		$rowNum = 11;
		$role = $this->session->get('sess_site_role');
		foreach ($rows as $row) {
			$sheet->setCellValue('A'.$rowNum,$row->rank);
			$sheet->setCellValue('B'.$rowNum,$row->store_name);

			if ($role == 7 || $role == 8) {
				$sheet->setCellValue('C'.$rowNum, '-');
			}else{
				$sheet->setCellValue('C'.$rowNum, $row->ly_scanned_data);
			}

			$sheet->setCellValue('D'.$rowNum, $row->ty_scanned_data);

			if ($role == 7 || $role == 8) {
				$sheet->setCellValue('E'.$rowNum, '-');	
			}else{
				$sheet->setCellValue('E'.$rowNum, $row->growth);
			}
			
			$sheet->setCellValue('F'.$rowNum, $row->sob);

			$rowNum++;
		}

		foreach (range('A','F') as $col) {
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

	// ================================= Header for pdf export =================================
	private function printHeader($pdf, $title) {
		$pdf->SetFont('helvetica', '', 12);
		$pdf->Cell(0, 10, 'LIFESTRONG MARKETING INC.', 0, 1, 'C');
		$pdf->SetFont('helvetica', '', 10);
		$pdf->Cell(0, 5, 'Report: ' . $title, 0, 1, 'C');
		$pdf->Ln(5);
	}

	// ================================= Display filters for pdf export ================================
	private function printFilter($pdf, $filters, $latestYear = null) {
		$pdf->SetFont('helvetica', 'B', 9);
		$source = "Scan Data(LMI/RGDI) - " . ($latestYear ?? 'N/A');
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
		$pdf->Cell(66, 6, '', 0, 0);                      // Spacer ~10mm
		$pdf->Cell(0, 6, $generatedText, 0, 1, 'L');      // Remaining width for date

		$pdf->Ln(2);
		$pdf->Cell(0, 0, '', 'T');
		$pdf->Ln(4);
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
