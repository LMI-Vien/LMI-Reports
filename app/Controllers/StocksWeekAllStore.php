<?php

namespace App\Controllers;

use Config\Database;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StocksWeekAllStore extends BaseController
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

	public function dataWeekAllStore()
	{
		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);

		$data['title'] = "Trade Dashboard";
		$data['PageName'] = 'Trade Dashboard';
		$data['PageUrl'] = 'Trade Dashboard';
		$data["breadcrumb"] = array('Stocks' => base_url('stocks/data-week-all-store'),'Week by Week Stock Data of all Stores' => '');
		$data["source"] = '<span id="sourceDate">VMI/WEEK on Week Sales N / A</span>';
		$data['content'] = "site/stocks/week-all-store/data_week_all_store";
		$data['itemClassi'] = $this->Global_model->getItemClassification();
		$data['traccItemClassi'] = $this->Global_model->getTraccItemClassification();
		$data['year'] = $this->Global_model->getYears();
		$data['session'] = session();
		$data['js'] = array(
			"assets/site/bundle/js/bundle.min.js",
			"assets/site/js/common.js"
                    );
        $data['css'] = array(
        	"assets/site/bundle/css/bundle.min.css",
        	"assets/site/css/common.css"
                    );
		return view("site/layout/template", $data);
	}

	public function getDataWeekAllStore()
	{	
		$ItemClasses = $this->request->getPost('itemClass');
		$ItemClasses = $ItemClasses === '' ? null : $ItemClasses;

		$itemCat = trim($this->request->getPost('itemCategory') ?? '');
		$itemCat = $itemCat === '' ? null : $itemCat;

		$weekStart = trim($this->request->getPost('weekFrom') ?? '');
		$weekStart = $weekStart === '' ? null : $weekStart;

		$weekEnd = trim($this->request->getPost('weekTo') ?? '');
		$weekEnd = $weekEnd === '' ? null : $weekEnd;

		$latestYear = trim($this->request->getPost('year') ?? '');
		$latestYear = $latestYear === '' ? null : $latestYear;

		$source = trim($this->request->getPost('source') ?? '');
		$source = $source === '' ? null : $source;

		$type = $this->request->getPost('type');
		$type = $type === '' ? null : $type;

		$limit = $this->request->getVar('limit');
		$offset = $this->request->getVar('offset');
		$limit = is_numeric($limit) ? (int)$limit : 10;
		$offset = is_numeric($offset) ? (int)$offset : 0;

		$orderColumnIndex = $this->request->getVar('order')[0]['column'] ?? 0;
	    $orderDirection = $this->request->getVar('order')[0]['dir'] ?? 'desc';
	    $columns = $this->request->getVar('columns');
	    $orderByColumn = $columns[$orderColumnIndex]['data'] ?? 'itmcde';

	    $searchValue = trim($this->request->getVar('search')['value'] ?? '');
		$searchValue = $searchValue === '' ? null : $searchValue;

		$sysPar = $this->Global_model->getSysPar();
		$npdSku = [];
		$heroSku = [];
		$skuMin = 20;
		$skuMax = 30;

		// $limit = 10;
		// $source = 2;
		// $type = 'slowMoving';
		// // $weekStart = 1;
		// // $weekEnd = 5;
		// // $latestYear = 6;
	   
		if($sysPar){
			$jsonStringHero = $sysPar[0]['hero_sku'];
			$dataHero = json_decode($jsonStringHero, true);
			$heroSku = array_map(fn($item) => $item['id'], $dataHero);
			$jsonStringNpd = $sysPar[0]['new_item_sku'];
			$dataNpd = json_decode($jsonStringNpd, true);
			$npdSku = array_map(fn($item) => $item['id'], $dataNpd);
		    $skuMin = $sysPar[0]['sm_sku_min'];
		    $skuMax = $sysPar[0]['sm_sku_max'];
		}
			$orderDirection = strtoupper($orderDirection);
			if(intval($source) === 3){
			    switch ($type) {
			        case 'slowMoving':
			            $data = $this->Dashboard_model->getDataWeekAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMin, $skuMax, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCat, $searchValue);
			            break;
			        case 'overStock':
			            $data = $this->Dashboard_model->getDataWeekAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMax, null, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCat, $searchValue);
			            break;
			        case 'npd':
						$itemClassFilter = $npdSku;
			           $data = $this->Dashboard_model->getDataWeekAllNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $ItemClasses, $itemCat, $searchValue);
			            break;
			        case 'hero':
	        			$itemClassFilter = $heroSku;
			            $data = $this->Dashboard_model->getDataWeekAllNPDHERO(
							$limit, $offset, 
							$orderByColumn, $orderDirection, 
							$weekStart, $weekEnd, $latestYear, 
							$itemClassFilter, $ItemClasses, $itemCat, 
							$searchValue
						);
			            break;
			        default:
			        	$data = $this->Dashboard_model->getDataWeekAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMin, $skuMax, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCat, $searchValue);
			    }
			}else{
			    switch ($type) {
			        case 'slowMoving':
			            $data = $this->Dashboard_model->getDataVmiAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMin, $skuMax, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCat, $searchValue);
			            break;
			        case 'overStock':
			            $data = $this->Dashboard_model->getDataVmiAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMax, null, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCat, $searchValue);
			            break;
			        case 'npd':
						$itemClassFilter = $npdSku;
			           $data = $this->Dashboard_model->getDataVmiNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $ItemClasses, $itemCat, $searchValue);
			            break;
			        case 'hero':
	        			$itemClassFilter = $heroSku;
			            $data = $this->Dashboard_model->getDataVmiNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $ItemClasses, $itemCat, $searchValue);
			            break;
			        default:
			        	$data = $this->Dashboard_model->getDataVmiAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMin, $skuMax, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCat, $searchValue);
			    }
			}
			
		    return $this->response->setJSON([
		        'draw' => intval($this->request->getVar('draw')),
		        'recordsTotal' => $data['total_records'],
		        'recordsFiltered' => $data['total_records'],
		        'data' => $data['data'],
		    ]);	
	}

	// ================================= Display filters for pdf export ================================
	private function printFilter($pdf, $filters) {
		$pdf->SetFont('helvetica', '', 9);

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
					1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M', true
				);
			}
			$pdf->Ln(8);
		}

		$pdf->Cell(0, 6, 'Generated Date: ' . date('M d, Y, h:i:s A'), 0, 1, 'L');
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

	private function getParam(string $key) {
		$v = $this->request->getVar($key);       // accepts GET or POST
		if (is_null($v)) return null;
		$v = trim((string)$v);
		return $v === '' ? null : $v;
	}

	private function formatComma($value): string {
		if (!is_numeric($value)) {
			return (string)$value;
		}
		return number_format((float)$value, 0, '.', ',');
	}

	public function generatePdf() {
		$json = $this->request->getJSON(true); 
		$ItemClasses = $json['itemClass'];
		if ($ItemClasses === null || $ItemClasses === '') {
			$ItemClasses = [];
		} else {
			$ItemClasses = explode(',', $ItemClasses);
		}

		$itemCat = trim($json['itemCategory'] ?? '');
		$itemCat = $itemCat === '' ? null : $itemCat;

		$weekStart = trim($json['weekFrom'] ?? '');
		$weekStart = $weekStart === '' ? null : $weekStart;

		$weekEnd = trim($json['weekTo'] ?? '');
		$weekEnd = $weekEnd === '' ? null : $weekEnd;

		$latestYear = trim($json['year'] ?? '');
		$latestYear = $latestYear === '' ? null : $latestYear;

		$source = trim($json['source'] ?? '');
		$source = $source === '' ? null : $source;

		$type = $json['type'];
		$typeArray = $type === '' ? [] : explode(',', $type);

		$limit = 999999999;
		$offset = 0;

		$allOrders  = $json['order']   ?? [];
		$allColumns = $json['columns'] ?? [];

	    $orderDirection = $json['order'][0]['dir'] ?? 'desc';

		$tableSlowMoving = trim($json['table_slowMoving'] ?? '');
		$tableSlowMoving = $tableSlowMoving === '' ? null : $tableSlowMoving;

		$tableHero = trim($json['table_hero'] ?? '');
		$tableHero = $tableHero === '' ? null : $tableHero;

		$tableNpd = trim($json['table_npd'] ?? '');
		$tableNpd = $tableNpd === '' ? null : $tableNpd;

		$tableOverStock = trim($json['table_overStock'] ?? '');
		$tableOverStock = $tableOverStock === '' ? null : $tableOverStock;

		$itmclstxt = trim($json['itmclstxt'] ?? '');
		$itmclstxt = $itmclstxt === '' ? null : $itmclstxt;

		$yrtxt = trim($json['yrtxt'] ?? '');
		$yrtxt = $yrtxt === '' ? null : $yrtxt;

		$typeList = trim($json['typeList'] ?? '');
		$typeList = $typeList === '' ? null : $typeList;

		$sysPar = $this->Global_model->getSysPar();
		$npdSku = [];
		$heroSku = [];
		$skuMin = 20;
		$skuMax = 30;

		if($sysPar){
			$jsonStringHero = $sysPar[0]['hero_sku'];
			$dataHero = json_decode($jsonStringHero, true);
			$heroSku = array_map(fn($item) => $item['id'], $dataHero);
			$jsonStringNpd = $sysPar[0]['new_item_sku'];
			$dataNpd = json_decode($jsonStringNpd, true);
			$npdSku = array_map(fn($item) => $item['id'], $dataNpd);
		    $skuMin = $sysPar[0]['sm_sku_min'];
		    $skuMax = $sysPar[0]['sm_sku_max'];
		}

		$weekCols = [];
		$isHeroOnly = (count($typeArray) === 1 && $typeArray[0] === 'hero');

		if (!$isHeroOnly && $weekStart !== null && $weekEnd !== null) {
			$startNum = (int) $weekStart;
			$endNum   = (int) $weekEnd;

			// Identify the last 3 week numbers
			$lastWeeks = range(max($endNum - 2, $startNum), $endNum); // Ensures no negative or overflow

			for ($w = $startNum; $w <= $endNum; $w++) {
				if (in_array($w, $lastWeeks)) {
					$weekCols[] = "Class_$w";
				}
				$weekCols[] = "Week $w";
			}

			$weekCols = array_reverse($weekCols);
		}
		
		$title = "Week by Week Stock Data of all Stores";
		$pdf   = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator('LMI SFA');
		$pdf->SetAuthor('LIFESTRONG MARKETING INC.');
		$pdf->SetTitle($title);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();

		if ($source == 2) {
			$sourceMap = "VMI";
		} elseif ($source == 3) {
			$sourceMap = "Week on Week (Sell Out)";
		} else {
			$sourceMap = "No Source";
		}

		$statusLabel = empty($typeArray) ? 'None' : implode(', ', $typeArray);
		$filterData  = [
			'Item Classes'     => empty($itmclstxt) ? 'None' : $itmclstxt,
			'Item Category'    => $itemCat      ?? 'None',
			'Inventory Status' => $typeList,
			'Week From'        => $weekStart      ?? 'None',
			'Week To'          => $weekEnd        ?? 'None',
			'Year'             => $yrtxt 		  ?? 'None',
			'Source'           => $sourceMap,
		];

		$this->printHeader($pdf, $title);
		$this->printFilter($pdf, $filterData);

		$orderDirection = strtoupper($orderDirection);
		
		foreach ($typeArray as $key => $type) {
			// Add a new page if not the first section
			if ($key > 0) {
				$pdf->AddPage();
			}

			// Print “section header” (Inventory Status)
			$pdf->SetFont('helvetica', 'B', 10);
			$pdf->Cell(0, 6, "Inventory Status: " . ucfirst($type), 0, 1, 'L');
			$pdf->Ln(2);

			$allOrders  = $json['order']   ?? [];
			if (isset($allOrders[$key])) {
			// We have a client‐side order[] block for this section
			$ord = $allOrders[$key];
			$orderColumnIndex = intval($ord['column'] ?? 0);
			$orderDirection   = strtoupper($ord['dir']    ?? 'DESC');

			if (
				isset($allColumns[$key])
				&& isset($allColumns[$key][$orderColumnIndex]['data'])
			) {
				$orderByColumn = $allColumns[$key][$orderColumnIndex]['data'];
			} else {
				// Fallback if the specified column index doesn’t exist
				$orderByColumn = 'item_name';
			}
			} else {
				// No order[] for this section → use default
				$orderByColumn  = 'item_name';
				$orderDirection = 'DESC';
			}

			$data = null;
			if(intval($source) === 3){
				switch ($type) {
					case 'slowMoving':
						$label = 'Slow Moving';
						$data = $this->Dashboard_model->getDataWeekAllStore(
							$limit, $offset, $orderByColumn, $orderDirection, 
							$skuMin, $skuMax, $weekStart, $weekEnd, $latestYear, 
							$ItemClasses, $itemCat, $tableSlowMoving
						);
						break;
					case 'overStock':
						$label = 'Overstock';
						$data = $this->Dashboard_model->getDataWeekAllStore(
							$limit, $offset, $orderByColumn, $orderDirection, 
							$skuMax, null, $weekStart, $weekEnd, $latestYear, 
							$ItemClasses, $itemCat, $tableOverStock
						);
						break;
					case 'npd':
						$label = 'NPD';
						$itemClassFilter = $npdSku;
					    $data = $this->Dashboard_model->getDataWeekAllNPDHERO(
							$limit, $offset, $orderByColumn, $orderDirection, 
							$weekStart, $weekEnd, $latestYear, 
							$itemClassFilter, $ItemClasses, $itemCat, 
							$tableNpd
						);
						break;
					case 'hero':
						$label = 'Hero SKUs';
						$itemClassFilter = $heroSku;
						$data = $this->Dashboard_model->getDataWeekAllNPDHERO(
							$limit, $offset, $orderByColumn, $orderDirection, 
							$weekStart, $weekEnd, $latestYear, 
							$itemClassFilter, $ItemClasses, $itemCat, 
							$tableHero
						);
						break;
					default:
						$data = $this->Dashboard_model->getDataWeekAllStore(
							$limit, $offset, $orderByColumn, $orderDirection, 
							$skuMin, $skuMax, $weekStart, $weekEnd, $latestYear, 
							$ItemClasses, $itemCat, ""
						);
				}
			}else{
				switch ($type) {
					case 'slowMoving':
						$label = 'Slow Moving';
						$data = $this->Dashboard_model->getDataVmiAllStore(
							$limit, $offset, $orderByColumn, $orderDirection, 
							$skuMin, $skuMax, $weekStart, $weekEnd, 
							$latestYear, $ItemClasses, $itemCat, $tableSlowMoving
						);
						break;
					case 'overStock':
						$label = 'Overstock';
						$data = $this->Dashboard_model->getDataVmiAllStore(
							$limit, $offset, $orderByColumn, $orderDirection, 
							$skuMax, null, $weekStart, $weekEnd, 
							$latestYear, $ItemClasses, $itemCat, $tableOverStock
						);
						break;
					case 'npd':
						$label = 'NPD';
						$itemClassFilter = $npdSku;
					   	$data = $this->Dashboard_model->getDataVmiNPDHERO(
							$limit, $offset, 
							$orderByColumn, $orderDirection, 
							$weekStart, $weekEnd, $latestYear, 
							$itemClassFilter, $ItemClasses, $itemCat, 
							$tableNpd
						);
						break;
					case 'hero':
						$label = 'Hero SKUs';
						$itemClassFilter = $heroSku;
						$data = $this->Dashboard_model->getDataVmiNPDHERO(
							$limit, $offset, 
							$orderByColumn, $orderDirection, 
							$weekStart, $weekEnd, $latestYear, 
							$itemClassFilter, $ItemClasses, $itemCat, 
							$tableHero
						);
						break;
					default:
						$data = $this->Dashboard_model->getDataVmiAllStore(
							$limit, $offset, $orderByColumn, $orderDirection, 
							$skuMin, $skuMax, $weekStart, $weekEnd, 
							$latestYear, $ItemClasses, $itemCat, ""
						);
				}
			}

			$isHeroSection = ($type === 'hero');
			if ($isHeroSection) {
				$headers = [
					'SKU Code',
					'SKU Name',
					'LMI/RGDI Code',
				];
			} else {
				$headers = array_merge(
					['SKU Code', 'SKU Name', 'LMI/RGDI Code'],
					$weekCols
				);
			}

			$pageWidth = $pdf->getPageWidth();
			$margins   = $pdf->getMargins();
			$usableW   = $pageWidth - $margins['left'] - $margins['right'];

			$colCount = count($headers);
			$colWidth = $usableW / $colCount;
			
			$pdf->SetFont('helvetica', 'B', 9);
			$colCount = count($headers);
			$colWidth = $usableW / $colCount;
			foreach ($headers as $h) {
				$headerCol = explode('_', $h);
				if ($headerCol[0] == "Class") {
					$pdf->Cell($colWidth, 8, $headerCol[0], 1, 0, 'C');
				} else {
					// $pdf->Cell($colWidth, 8, $h, 1, 0, 'C');
					$pdf->MultiCell(
						$colWidth,
						8,
						$h,
						1, 'L', 0, 0, '', '', true, 0, false, true, 8, 'M', true
					);
				}
			}
			$pdf->Ln();
			$pdf->SetFont('helvetica', '', 9);

			$rowHeight  = 8;
			$lineHeight = 4;
			$pageHeight   = $pdf->getPageHeight();
			$bottomMargin = $pdf->getMargins()['bottom'];
			$bottomLimit  = $pageHeight - $bottomMargin - $rowHeight;

			foreach ($data['data'] as $row) {
				$currentY = $pdf->GetY();

				// If the next row won't fit, add a new page (no headers or titles)
				if ($currentY > $bottomLimit) {
					$pdf->AddPage();
				}

				// A) Column 1: SKU Code
				$currX = $pdf->GetX();
				$currY = $pdf->GetY();
				$pdf->Cell($colWidth, $rowHeight, $row->item, 1, 0, 'C');

				// B) Column 2: SKU Name (wrapped)
				$pdf->MultiCell(
					$colWidth,
					$lineHeight,
					$row->item_name,
					1, 'L', 0, 0, '', '', true, 0, false, true, $rowHeight, 'M', true
				);

				// C) Column 3: LMI/RGDI Code
				$pdf->SetXY($currX + $colWidth * 2, $currY);
				$pdf->Cell($colWidth, $rowHeight, $row->itmcde, 1, 0, 'C');

				// D) Week columns if not hero
				if (!$isHeroSection) {
					foreach ($weekCols as $key => $wc) {
						$colString = explode('_', $wc);
						$wkNum = (int) str_replace('Week ', '', $wc);
						$field = "week_{$wkNum}";
						$val   = property_exists($row, $field) ? $row->$field : 0;
						$fmt   = $this->formatComma($val);

						if ($colString[0] == "Class") {
							$classField = "item_class_week_{$colString[1]}";
							$classVal = property_exists($row, $classField) ? $row->$classField : '';
							$pdf->MultiCell(
								$colWidth,
								$lineHeight,
								$classVal,
								1, 'L', 0, 0, '', '', true, 0, false, true, $rowHeight, 'M', true
							);
						} else {
							$pdf->Cell($colWidth, $rowHeight, $fmt, 1, 0, 'C');
						}
					}
				}

				$pdf->Ln();
			}
		}

		$pdf->Output($title . '.pdf', 'D');
		exit;
	}

	public function generateExcel() {
		$json = $this->request->getJSON(true); 
		
		$ItemClasses = $json['itemClass'];
		if ($ItemClasses === null || $ItemClasses === '') {
			$ItemClasses = [];
		} else {
			$ItemClasses = explode(',', $ItemClasses);
		}

		$itemCat = trim($json['itemCategory'] ?? '');
		$itemCat = $itemCat === '' ? null : $itemCat;

		$weekStart = trim($json['weekFrom'] ?? '');
		$weekStart = $weekStart === '' ? null : $weekStart;

		$weekEnd = trim($json['weekTo'] ?? '');
		$weekEnd = $weekEnd === '' ? null : $weekEnd;

		$latestYear = trim($json['year'] ?? '');
		$latestYear = $latestYear === '' ? null : $latestYear;

		$source = trim($json['source'] ?? '');
		$source = $source === '' ? null : $source;

		$type = $json['type'];
		$typeArray = $type === '' ? [] : explode(',', $type);

		$limit = 999999999;
		$offset = 0;
		
		$allOrders  = $json['order']   ?? [];
		$allColumns = $json['columns'] ?? [];

		$orderDirection = $json['order'][0]['dir'] ?? 'DESC';

		$tableSlowMoving = trim($json['table_slowMoving'] ?? '');
		$tableSlowMoving = $tableSlowMoving === '' ? null : $tableSlowMoving;

		$tableHero = trim($json['table_hero'] ?? '');
		$tableHero = $tableHero === '' ? null : $tableHero;

		$tableNpd = trim($json['table_npd'] ?? '');
		$tableNpd = $tableNpd === '' ? null : $tableNpd;

		$tableOverStock = trim($json['table_overStock'] ?? '');
		$tableOverStock = $tableOverStock === '' ? null : $tableOverStock;

		$itmclstxt = trim($json['itmclstxt'] ?? '');
		$itmclstxt = $itmclstxt === '' ? null : $itmclstxt;

		$yrtxt = trim($json['yrtxt'] ?? '');
		$yrtxt = $yrtxt === '' ? null : $yrtxt;

		$typeList = trim($json['typeList'] ?? '');
		$typeList = $typeList === '' ? null : $typeList;

		$sysPar = $this->Global_model->getSysPar();
		$npdSku = [];
		$heroSku = [];
		$skuMin = 20;
		$skuMax = 30;

		if($sysPar){
			$jsonStringHero = $sysPar[0]['hero_sku'];
			$dataHero = json_decode($jsonStringHero, true);
			$heroSku = array_map(fn($item) => $item['id'], $dataHero);
			$jsonStringNpd = $sysPar[0]['new_item_sku'];
			$dataNpd = json_decode($jsonStringNpd, true);
			$npdSku = array_map(fn($item) => $item['id'], $dataNpd);
		    $skuMin = $sysPar[0]['sm_sku_min'];
		    $skuMax = $sysPar[0]['sm_sku_max'];
		}

		$weekCols = [];
		$isHeroOnly = (count($typeArray) === 1 && $typeArray[0] === 'hero');

		if (!$isHeroOnly && $weekStart !== null && $weekEnd !== null) {
			$startNum = (int)$weekStart;
			$endNum   = (int)$weekEnd;
			for ($w = $startNum; $w <= $endNum; $w++) {
				$weekCols[] = "Class_$w";
				$weekCols[] = "Week $w";
			}
			$weekCols = array_reverse($weekCols);
		}

		$rowNum = 8;

		if ($source == 2) {
			$sourceMap = "VMI";
		} elseif ($source == 3) {
			$sourceMap = "Week on Week (Sell Out)";
		} else {
			$sourceMap = "No Source";
		}

		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'LIFESTRONG MARKETING INC.');
		$sheet->setCellValue('A2', 'Report: Week by Week Stock Data of all Stores');
		$sheet->mergeCells('A1:E1');
		$sheet->mergeCells('A2:E2');

		$sheet->setCellValue('A4', 'Item Class:');
		$sheet->setCellValue('B4', empty($itmclstxt) ? 'None' : $itmclstxt);
		$sheet->setCellValue('C4', 'Inventory Status:');
		$sheet->setCellValue('D4', empty($typeList) ? 'None' : $typeList);

		$sheet->setCellValue('A5', 'Week From:');
		$sheet->setCellValue('B5', $weekStart ?? 'None');
		$sheet->setCellValue('C5', 'Week To:');
		$sheet->setCellValue('D5', $weekEnd ?? 'None');

		$sheet->setCellValue('A6', 'Year:');
		$sheet->setCellValue('B6', $yrtxt ?: 'None');
		$sheet->setCellValue('C6', 'Source:');
		$sheet->setCellValue('D6', $sourceMap);
		$sheet->setCellValue('E6', 'Generated: ' . date('M d, Y, h:i:s A'));
		
		foreach ($typeArray as $key => $type) {
			$allOrders  = $json['order'] ?? [];
			if (isset($allOrders[$key])) {
				// We have a client‐side order[] block for this section
				$ord = $allOrders[$key];
				$orderColumnIndex = intval($ord['column'] ?? 0);
				$orderDirection   = strtoupper($ord['dir']    ?? 'DESC');

				if (
					isset($allColumns[$key])
					&& isset($allColumns[$key][$orderColumnIndex]['data'])
				) {
					$orderByColumn = $allColumns[$key][$orderColumnIndex]['data'];
				} else {
					// Fallback if the specified column index doesn’t exist
					$orderByColumn = 'item_name';
				}
			} else {
				// No order[] for this section → use default
				$orderByColumn  = 'item_name';
				$orderDirection = 'DESC';
			}

			$data = null;

			if(intval($source) === 3){
				switch ($type) {
					case 'slowMoving':
						$label = 'Slow Moving';
						$data = $this->Dashboard_model->getDataWeekAllStore(
							$limit, $offset, $orderByColumn, $orderDirection, 
							$skuMin, $skuMax, $weekStart, $weekEnd, $latestYear, 
							$ItemClasses, $itemCat, $tableSlowMoving
						);
						break;
					case 'overStock':
						$label = 'Overstock';
						$data = $this->Dashboard_model->getDataWeekAllStore(
							$limit, $offset, $orderByColumn, $orderDirection, 
							$skuMax, null, $weekStart, $weekEnd, $latestYear, 
							$ItemClasses, $itemCat, $tableOverStock
						);
						break;
					case 'npd':
						$label = 'NPD';
						$itemClassFilter = $npdSku;
					    $data = $this->Dashboard_model->getDataWeekAllNPDHERO(
							$limit, $offset, $orderByColumn, $orderDirection, 
							$weekStart, $weekEnd, $latestYear, 
							$itemClassFilter, $ItemClasses, $itemCat, 
							$tableNpd
						);
						break;
					case 'hero':
						$label = 'Hero SKUs';
						$itemClassFilter = $heroSku;
						$data = $this->Dashboard_model->getDataWeekAllNPDHERO(
							$limit, $offset, $orderByColumn, $orderDirection, 
							$weekStart, $weekEnd, $latestYear, 
							$itemClassFilter, $ItemClasses, $itemCat, 
							$tableHero
						);
						break;
					default:
						$data = $this->Dashboard_model->getDataWeekAllStore(
							$limit, $offset, $orderByColumn, $orderDirection, 
							$skuMin, $skuMax, $weekStart, $weekEnd, $latestYear, 
							$ItemClasses, $itemCat, ""
						);
				}
			}else{
				switch ($type) {
					case 'slowMoving':
						$label = 'Slow Moving';
						$data = $this->Dashboard_model->getDataVmiAllStore(
							$limit, $offset, $orderByColumn, $orderDirection, 
							$skuMin, $skuMax, $weekStart, $weekEnd, 
							$latestYear, $ItemClasses, $itemCat, $tableSlowMoving
						);
						break;
					case 'overStock':
						$label = 'Overstock';
						$data = $this->Dashboard_model->getDataVmiAllStore(
							$limit, $offset, $orderByColumn, $orderDirection, 
							$skuMax, null, $weekStart, $weekEnd, 
							$latestYear, $ItemClasses, $itemCat, $tableOverStock
						);
						break;
					case 'npd':
						$label = 'NPD';
						$itemClassFilter = $npdSku;
					   	$data = $this->Dashboard_model->getDataVmiNPDHERO(
							$limit, $offset, 
							$orderByColumn, $orderDirection, 
							$weekStart, $weekEnd, $latestYear, 
							$itemClassFilter, $ItemClasses, $itemCat, 
							$tableNpd
						);
						break;
					case 'hero':
						$label = 'Hero SKUs';
						$itemClassFilter = $heroSku;
						$data = $this->Dashboard_model->getDataVmiNPDHERO(
							$limit, $offset, 
							$orderByColumn, $orderDirection, 
							$weekStart, $weekEnd, $latestYear, 
							$itemClassFilter, $ItemClasses, $itemCat, 
							$tableHero
						);
						break;
					default:
						$data = $this->Dashboard_model->getDataVmiAllStore(
							$limit, $offset, $orderByColumn, $orderDirection, 
							$skuMin, $skuMax, $weekStart, $weekEnd, 
							$latestYear, $ItemClasses, $itemCat, ""
						);
				}
			}

			if ($type === 'hero') {
				$sectionHeaders = ['LMI/RGDI Code', 'SKU Name', 'Item Class'];
			} else {
				$sectionHeaders = array_merge(
					['LMI/RGDI Code', 'SKU Name', 'Item Class'],
					$weekCols
				);
			}

			$numCols = count($sectionHeaders);
			$lastCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($numCols);

			// Write the “Inventory Status: <StatusType>” row 
			$sheet->mergeCells("A{$rowNum}:{$lastCol}{$rowNum}");
			$sheet->setCellValue("A{$rowNum}", "Inventory Status: " . ucfirst($type));
			$sheet->getStyle("A{$rowNum}")
				->getFont()
				->setBold(true);

			$rowNum++;

			// Write the column‐header row for this section
			foreach ($sectionHeaders as $i => $headerText) {
				$headerCol = explode('_', $headerText);
				$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i + 1);
				if ($headerCol[0] == "Class") {
					$sheet->setCellValue($colLetter . $rowNum, $headerCol[0]);
				} else {
					$sheet->setCellValue($colLetter . $rowNum, $headerText);
				}
			}
			$sheet->getStyle("A{$rowNum}:{$lastCol}{$rowNum}")
				->getFont()
				->setBold(true);

			$rowNum++;

			foreach ($data['data'] as $row) {
				// echo json_encode($row)."<br>";
				$colIndex = 1;

				// LMI/RGDI Code
				$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
				$sheet->setCellValue($colLetter . $rowNum, $row->item);

				// SKU Name
				$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
				$sheet->setCellValue($colLetter . $rowNum, $row->item_name);

				// Item Class (itmcde)
				$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
				$sheet->setCellValue($colLetter . $rowNum, $row->itmcde);

				// Week columns, if this is not “hero”
				if ($type !== 'hero') {
					foreach ($weekCols as $wc) {
						$colString = explode('_', $wc);
						$wkNum = (int) str_replace('Week ', '', $wc);
						$field = "week_{$wkNum}";
						$value = property_exists($row, $field) ? $row->$field : 0;

						if ($colString[0] == "Class") {
							$classField = "item_class_week_{$colString[1]}";
							$classVal = property_exists($row, $classField) ? $row->$classField : '';
							$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
							$sheet->setCellValue($colLetter . $rowNum, $classVal);
						} else {
							$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
							$sheet->setCellValue($colLetter . $rowNum, $value);
						}
					}
				}

				$rowNum++;
			}
			$rowNum++;
		}

		$filename = "Week by Week Stock Data of all Stores.xlsx";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"{$filename}\"");
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

}
