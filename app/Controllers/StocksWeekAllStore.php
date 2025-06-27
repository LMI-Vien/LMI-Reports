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
			"assets/site/bundle/js/bundle.min.js"
                    );
        $data['css'] = array(
        	"assets/site/bundle/css/bundle.min.css"
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
		$skuMin = 30;
	    //$ItemClasses = null;
	    //$itemCat = null;

		if($sysPar){
			$jsonStringHero = $sysPar[0]['hero_sku'];
			$dataHero = json_decode($jsonStringHero, true);
			$heroSku = array_map(fn($item) => $item['id'], $dataHero);
			$jsonStringNpd = $sysPar[0]['new_item_sku'];
			$dataNpd = json_decode($jsonStringNpd, true);
			$npdSku = array_map(fn($item) => $item['id'], $dataNpd);
		    $skuMin = $sysPar[0]['sm_sku_min'];
		    $skuMax = $sysPar[0]['sm_sku_max'];
		    $skuMin = 1;
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
			            $data = $this->Dashboard_model->getDataWeekAllNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $ItemClasses, $itemCat, $searchValue);
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
				$pdf->Cell($colWidth, 8, "{$key}: {$value}", 0, 0, 'L');
			}
			$pdf->Ln(8);
		}

		$pdf->Cell(0, 6, 'Generated Date: ' . date('M d, Y, h:i:s A'), 0, 1, 'L');
		$pdf->Ln(2);
		$pdf->Cell(0, 0, '', 'T');
		$pdf->Ln(4);
	}

	// MULTICELL printFilter
	// private function printFilter($pdf, $filters) {
	// 	// — Set font and sizing —
	// 	$pdf->SetFont('helvetica', '', 9);

	// 	// Compute usable page width (total width minus left/right margins)
	// 	$pageWidth  = $pdf->getPageWidth();
	// 	$pageMargin = $pdf->getMargins();
	// 	$usableWidth = $pageWidth - $pageMargin['left'] - $pageMargin['right'];

	// 	// We want two “rows” of filters (i.e. split the filters array into 2 chunks)
	// 	$perRow   = ceil(count($filters) / 2);
	// 	$colWidth = $usableWidth / $perRow;  // width of each column in that row

	// 	// Split $filters into two sub‐arrays (each of length $perRow, except maybe the last)
	// 	$rows = array_chunk($filters, $perRow, true);

	// 	foreach ($rows as $rowFilters) {
	// 		// Before we output anything, figure out how tall this row needs to be:
	// 		//   for each cell, ask TCPDF “how many lines would {$key}: {$value} take,
	// 		//   if wrapped inside $colWidth?” → then pick the maximum.
	// 		$currentX = $pdf->GetX();
	// 		$currentY = $pdf->GetY();

	// 		$cellBaseHeight = 5;    // base height per line
	// 		$maxLines       = 1;

	// 		foreach ($rowFilters as $key => $value) {
	// 			$txt = "{$key}: {$value}";
	// 			// getNumLines() returns “how many lines of text” TCPDF would use
	// 			// if you put $txt into a cell of width $colWidth.
	// 			$numLines = $pdf->getNumLines($txt, $colWidth);
	// 			if ($numLines > $maxLines) {
	// 				$maxLines = $numLines;
	// 			}
	// 		}

	// 		// Now $rowHeight is tall enough to fit the longest‐wrapping cell
	// 		$rowHeight = $cellBaseHeight * $maxLines;

	// 		// Print every filter (as a MultiCell) at the same Y, stepping X by $colWidth.
	// 		$x = $currentX;
	// 		foreach ($rowFilters as $key => $value) {
	// 			$txt = "{$key}: {$value}";

	// 			$pdf->MultiCell(
	// 				$colWidth,        // cell width
	// 				$cellBaseHeight,  // cell height per line
	// 				$txt,             // the text
	// 				0,                // no border
	// 				'L',              // left align
	// 				false,            // no fill
	// 				0,                // set ln=0 so it does NOT move down after each call
	// 				$x,               // x position (absolute)
	// 				$currentY,        // y position (absolute)
	// 				true,             // reset pointer after call (important for absolute positioning)
	// 				0,                // stretch
	// 				false,            // is HTML?
	// 				true,             // autopadding
	// 				$rowHeight,       // maximum height allowed for this cell
	// 				'T',              // align text to top of this $rowHeight
	// 				false             // is a “max height” enforced
	// 			);

	// 			// move right by one column width, ready for next cell
	// 			$x += $colWidth;
	// 		}

	// 		// After outputting all columns in this row, move down by rowHeight:
	// 		$pdf->Ln($rowHeight);
	// 	}

	// 	$pdf->Cell(0, 6, 'Generated Date: ' . date('M d, Y, h:i:s A'), 0, 1, 'L');
	// 	$pdf->Ln(2);
	// 	$pdf->Cell(0, 0, '', 'T');
	// 	$pdf->Ln(4);
	// }

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
		$itemClassParam = $this->getParam('itemClass');
		if (is_string($itemClassParam) && strpos($itemClassParam, ',') !== false) {
			$itemClassList = array_map('trim', explode(',', $itemClassParam));
		} elseif (is_array($itemClassParam) && count($itemClassParam) > 0) {
			$itemClassList = $itemClassParam;
		} elseif (!empty($itemClassParam)) {
			$itemClassList = [ $itemClassParam ];
		} else {
			$itemClassList = [];
		}

		$itemCatId  = trim($this->getParam('itemCategory')  ?? '');
		$itemCatId  = ($itemCatId === '') ? null : $itemCatId;
		$weekStart  = trim($this->getParam('weekFrom')     ?? '');
		$weekStart  = ($weekStart === '') ? null : $weekStart;
		$weekEnd    = trim($this->getParam('weekTo')       ?? '');
		$weekEnd    = ($weekEnd === '') ? null : $weekEnd;
		$latestYear = trim($this->getParam('year')         ?? '');
		$latestYear = ($latestYear === '') ? null : $latestYear;
		$source     = trim($this->getParam('source')       ?? '');
		$source     = ($source === '') ? null : $source;

		$typeParam = $this->getParam('type');
		if (is_string($typeParam) && strpos($typeParam, ',') !== false) {
			$typeList = array_map('trim', explode(',', $typeParam));
		} elseif (is_array($typeParam) && count($typeParam) > 0) {
			$typeList = $typeParam;
		} elseif (!empty($typeParam)) {
			$typeList = [ $typeParam ];
		} else {
			$typeList = [];
		}

		$sysPar  = $this->Global_model->getSysPar();
		$npdSku  = [];
		$heroSku = [];
		$skuMin  = 1;
		$skuMax  = null;

		if ($sysPar) {
			$dataHero = json_decode($sysPar[0]['hero_sku'], true);
			$heroSku  = array_map(fn($item) => $item['item_class_description'], $dataHero);

			$dataNpd  = json_decode($sysPar[0]['new_item_sku'], true);
			$npdSku   = array_map(fn($item) => $item['item_class_description'], $dataNpd);

			$skuMin = $sysPar[0]['sm_sku_min'];
			$skuMax = $sysPar[0]['sm_sku_max'];
			$skuMin = 1;
		}

		$limit  = 99999;
		$offset = 0;

		$allOrders  = $this->request->getVar('order')   ?? [];
		$allColumns = $this->request->getVar('columns') ?? [];

		// Build dynamic "Week X" columns (needed for headers later)
		$weekCols   = [];
		$isHeroOnly = (count($typeList) === 1 && $typeList[0] === 'hero');
		if (! $isHeroOnly && $weekStart !== null && $weekEnd !== null) {
			$startNum = (int) $weekStart;
			$endNum   = (int) $weekEnd;
			for ($w = $startNum; $w <= $endNum; $w++) {
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

		$result  = $this->Global_model->dynamic_search("'tbl_year'", "''", "'year'", 0, 0, "'id:EQ=$latestYear'", "''", "''");
		$yearMap = !empty($result) ? $result[0]['year'] : '';

		$itemClassCodes = [];
		foreach ($itemClassList as $oneClassId) {
			$result  = $this->Global_model->dynamic_search("'tbl_item_class'", "''", "'item_class_code'", 0, 0, "'id:EQ={$oneClassId}'", "''", "''");
			if (!empty($result) && isset($result[0]['item_class_code'])) {
				$itemClassCodes[] = $result[0]['item_class_code'];
			}
		}

		if (empty($itemClassCodes)) {
			$itemClassMap = '';  
		} else {
			$itemClassMap = implode(', ', $itemClassCodes);
		}

		if ($source == 2) {
			$sourceMap = "VMI";
		} elseif ($source == 3) {
			$sourceMap = "Week by Week";
		} else {
			$sourceMap = "No Source";
		}

		$statusLabel = empty($typeList) ? 'None' : implode(', ', $typeList);
		$filterData  = [
			'Item Classes'     => empty($itemClassMap) ? 'None' : $itemClassMap,
			'Item Category'    => $itemCatId      ?? 'None',
			'Inventory Status' => $statusLabel,
			'Week From'        => $weekStart      ?? 'None',
			'Week To'          => $weekEnd        ?? 'None',
			'Year'             => $yearMap 		  ?? 'None',
			'Source'           => $sourceMap,
		];
		$this->printHeader($pdf, $title);
		$this->printFilter($pdf, $filterData);

		// Compute “usableW” just once
		$pageWidth = $pdf->getPageWidth();
		$margins   = $pdf->getMargins();
		$usableW   = $pageWidth - $margins['left'] - $margins['right'];

	
		// For each status in $typeList, output a separate page‐section
		foreach ($typeList as $sectionIndex => $singleType) {
			// Add a new page if not the first section
			if ($sectionIndex > 0) {
				$pdf->AddPage();
			}

			// Print “section header” (Inventory Status)
			$pdf->SetFont('helvetica', 'B', 10);
			$pdf->Cell(0, 6, "Inventory Status: " . ucfirst($singleType), 0, 1, 'L');
			$pdf->Ln(2);

			$isHeroSection = ($singleType === 'hero');
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

			// Determine this section’s sorting (using order[$sectionIndex], columns[$sectionIndex])
			if (isset($allOrders[$sectionIndex])) {
				// We have a client‐side order[] block for this section
				$ord = $allOrders[$sectionIndex];
				$orderColumnIndex = intval($ord['column'] ?? 0);
				$orderDirection   = strtoupper($ord['dir']    ?? 'DESC');

				if (
					isset($allColumns[$sectionIndex])
					&& isset($allColumns[$sectionIndex][$orderColumnIndex]['data'])
				) {
					$orderByColumn = $allColumns[$sectionIndex][$orderColumnIndex]['data'];
				} else {
					// Fallback if the specified column index doesn’t exist
					$orderByColumn = 'item_name';
				}
			} else {
				// No order[] for this section → use default
				$orderByColumn  = 'item_name';
				$orderDirection = 'DESC';
			}

			$fetchLimit  = $limit;
			$fetchOffset = $offset;

			if (intval($source) === 3) {
				switch ($singleType) {
					case 'slowMoving':
						$data = $this->Dashboard_model->getDataWeekAllStore($fetchLimit, $fetchOffset, $orderByColumn, $orderDirection, $skuMin, $skuMax, $weekStart, $weekEnd, $latestYear, $itemClassList, $itemCatId);
						break;
					case 'overStock':
						$data = $this->Dashboard_model->getDataWeekAllStore($fetchLimit, $fetchOffset, $orderByColumn, $orderDirection, $skuMax, null, $weekStart, $weekEnd, $latestYear, $itemClassList, $itemCatId);
						break;
					case 'npd':
						$itemClassFilter = $npdSku;
						$data = $this->Dashboard_model->getDataWeekAllNPDHERO($fetchLimit, $fetchOffset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $itemClassList, $itemCatId);
						break;
					case 'hero':
						$itemClassFilter = $heroSku;
						$data = $this->Dashboard_model->getDataWeekAllNPDHERO($fetchLimit, $fetchOffset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $itemClassList, $itemCatId);
						break;
					default:
						$data = ['data' => []];
						break;
				}
			} else {
				switch ($singleType) {
					case 'slowMoving':
						$data = $this->Dashboard_model->getDataVmiAllStore($fetchLimit, $fetchOffset, $orderByColumn, $orderDirection, $skuMin, $skuMax, $weekStart, $weekEnd, $latestYear, $itemClassList, $itemCatId);
						break;
					case 'overStock':
						$data = $this->Dashboard_model->getDataVmiAllStore($fetchLimit, $fetchOffset, $orderByColumn, $orderDirection, $skuMax, null, $weekStart, $weekEnd, $latestYear, $itemClassList, $itemCatId);
						break;
					case 'npd':
						$itemClassFilter = $npdSku;
						$data = $this->Dashboard_model->getDataVmiNPDHERO($fetchLimit, $fetchOffset, $orderByColumn, $orderDirection,$weekStart, $weekEnd, $latestYear, $itemClassFilter, $itemClassList, $itemCatId);
						break;
					case 'hero':
						$itemClassFilter = $heroSku;
						$data = $this->Dashboard_model->getDataVmiNPDHERO($fetchLimit, $fetchOffset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $itemClassList, $itemCatId);
						break;
					default:
						$data = ['data' => []];
						break;
				}
			}

			$rows = $data['data'] ?? [];

			$pdf->SetFont('helvetica', 'B', 9);
			$colCount = count($headers);
			$colWidth = $usableW / $colCount;
			foreach ($headers as $h) {
				$pdf->Cell($colWidth, 8, $h, 1, 0, 'C');
			}
			$pdf->Ln();
			$pdf->SetFont('helvetica', '', 9);

			$rowHeight  = 8;
			$lineHeight = 4;
			$pageHeight   = $pdf->getPageHeight();
			$bottomMargin = $pdf->getMargins()['bottom'];
			$bottomLimit  = $pageHeight - $bottomMargin - $rowHeight;

			foreach ($rows as $row) {
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
					foreach ($weekCols as $wc) {
						$wkNum = (int) str_replace('Week ', '', $wc);
						$field = "week_{$wkNum}";
						$val   = property_exists($row, $field) ? $row->$field : 0;
						$fmt   = $this->formatComma($val);
						$pdf->Cell($colWidth, $rowHeight, $fmt, 1, 0, 'C');
					}
				}

				$pdf->Ln();
			}
		}

		$pdf->Output($title . '.pdf', 'D');
		exit;
	}

	public function generateExcel() {
		$itemClassParam = $this->getParam('itemClass');
		if (is_string($itemClassParam) && strpos($itemClassParam, ',') !== false) {
			$itemClassList = array_map('trim', explode(',', $itemClassParam));
		} elseif (is_array($itemClassParam) && count($itemClassParam) > 0) {
			$itemClassList = $itemClassParam;
		} elseif (!empty($itemClassParam)) {
			$itemClassList = [ $itemClassParam ];
		} else {
			$itemClassList = [];
		}

		$itemCatId = trim($this->getParam('itemCategory') ?? '');
		$itemCatId = ($itemCatId === '') ? null : $itemCatId;

		$weekStart = trim($this->getParam('weekFrom') ?? '');
		$weekStart = ($weekStart === '') ? null : $weekStart;

		$weekEnd = trim($this->getParam('weekTo') ?? '');
		$weekEnd = ($weekEnd === '') ? null : $weekEnd;

		$latestYear = trim($this->getParam('year') ?? '');
		$latestYear = ($latestYear === '') ? null : $latestYear;

		$source = trim($this->getParam('source') ?? '');
		$source = ($source === '') ? null : $source;

		$typeParam = $this->getParam('type');
		if (is_string($typeParam) && strpos($typeParam, ',') !== false) {
			$typeList = array_map('trim', explode(',', $typeParam));
		} elseif (is_array($typeParam) && count($typeParam) > 0) {
			$typeList = $typeParam;
		} elseif (!empty($typeParam)) {
			$typeList = [ $typeParam ];
		} else {
			$typeList = [];
		}

		$limit  = 99999;
		$offset = 0;

		$allOrders  = $this->request->getVar('order')   ?? [];
		$allColumns = $this->request->getVar('columns') ?? [];

		$sysPar  = $this->Global_model->getSysPar();
		$npdSku  = [];
		$heroSku = [];
		$skuMin  = 1;
		$skuMax  = null;

		if ($sysPar) {
			$dataHero = json_decode($sysPar[0]['hero_sku'], true);
			$heroSku  = array_map(fn($item) => $item['item_class_description'], $dataHero);

			$dataNpd = json_decode($sysPar[0]['new_item_sku'], true);
			$npdSku  = array_map(fn($item) => $item['item_class_description'], $dataNpd);

			$skuMin = $sysPar[0]['sm_sku_min'];
			$skuMax = $sysPar[0]['sm_sku_max'];
			$skuMin = 1;
		}

		// Build dynamic "Week X" column names (for non-hero sections)
		$weekCols   = [];
		$isHeroOnly = (count($typeList) === 1 && $typeList[0] === 'hero');
		if (!$isHeroOnly && $weekStart !== null && $weekEnd !== null) {
			$startNum = (int)$weekStart;
			$endNum   = (int)$weekEnd;
			for ($w = $startNum; $w <= $endNum; $w++) {
				$weekCols[] = "Week $w";
			}
			$weekCols = array_reverse($weekCols);
		}

		$result  = $this->Global_model->dynamic_search("'tbl_year'", "''", "'year'", 0, 0, "'id:EQ=$latestYear'", "''", "''");
		$yearMap = !empty($result) ? $result[0]['year'] : '';

		$itemClassCodes = [];
		foreach ($itemClassList as $oneClassId) {
			$result  = $this->Global_model->dynamic_search("'tbl_item_class'", "''", "'item_class_code'", 0, 0, "'id:EQ={$oneClassId}'", "''", "''");
			if (!empty($result) && isset($result[0]['item_class_code'])) {
				$itemClassCodes[] = $result[0]['item_class_code'];
			}
		}

		if (empty($itemClassCodes)) {
			$itemClassMap = '';  
		} else {
			$itemClassMap = implode(', ', $itemClassCodes);
		}

		if ($source == 2) {
			$sourceMap = "VMI";
		} elseif ($source == 3) {
			$sourceMap = "Week by Week";
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
		$sheet->setCellValue('B4', empty($itemClassMap) ? 'None' : $itemClassMap);
		$sheet->setCellValue('C4', 'Inventory Status:');
		$sheet->setCellValue('D4', empty($typeList) ? 'None' : implode(', ', $typeList));

		$sheet->setCellValue('A5', 'Week From:');
		$sheet->setCellValue('B5', $weekStart ?? 'None');
		$sheet->setCellValue('C5', 'Week To:');
		$sheet->setCellValue('D5', $weekEnd ?? 'None');

		$sheet->setCellValue('A6', 'Year:');
		$sheet->setCellValue('B6', $yearMap ?: 'None');
		$sheet->setCellValue('C6', 'Source:');
		$sheet->setCellValue('D6', $sourceMap);
		$sheet->setCellValue('E6', 'Generated: ' . date('M d, Y, h:i:s A'));

		// Starting row for writing data sections
		$rowNum = 8;

		// For each inventory status in $typeList, fetch + write its own block
		// (no separate worksheet, just a blank row between sections)
		foreach ($typeList as $sectionIndex => $statusType) {
			$statusType = trim($statusType);

			// Determine this section’s ORDER BY column & direction
			if (isset($allOrders[$sectionIndex])) {
				$ord               = $allOrders[$sectionIndex];
				$orderColumnIndex  = intval($ord['column'] ?? 0);
				$orderDirection    = strtoupper($ord['dir']    ?? 'DESC');

				if (
					isset($allColumns[$sectionIndex]) &&
					isset($allColumns[$sectionIndex][$orderColumnIndex]['data'])
				) {
					$orderByColumn = $allColumns[$sectionIndex][$orderColumnIndex]['data'];
				} else {
					// Fallback if the index is missing
					$orderByColumn = 'item_name';
				}
			} else {
				// Default if no ordering for this section
				$orderByColumn  = 'item_name';
				$orderDirection = 'DESC';
			}

			if (intval($source) === 3) {
				switch ($statusType) {
					case 'slowMoving':
						$data = $this->Dashboard_model->getDataWeekAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMin, $skuMax, $weekStart, $weekEnd, $latestYear, $itemClassList, $itemCatId);
						break;
					case 'overStock':
						$data = $this->Dashboard_model->getDataWeekAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMax, null, $weekStart, $weekEnd, $latestYear,$itemClassList, $itemCatId);
						break;
					case 'npd':
						$itemClassFilter = $npdSku;
						$data = $this->Dashboard_model->getDataWeekAllNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $itemClassList, $itemCatId);
						break;
					case 'hero':
						$itemClassFilter = $heroSku;
						$data = $this->Dashboard_model->getDataWeekAllNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $itemClassList, $itemCatId);
						break;
					default:
						// Skip if an unexpected statusType
						continue 2;
				}
			} else {
				switch ($statusType) {
					case 'slowMoving':
						$data = $this->Dashboard_model->getDataVmiAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMin, $skuMax, $weekStart, $weekEnd, $latestYear, $itemClassList, $itemCatId);
						break;
					case 'overStock':
						$data = $this->Dashboard_model->getDataVmiAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMax, null, $weekStart, $weekEnd, $latestYear, $itemClassList, $itemCatId);
						break;
					case 'npd':
						$itemClassFilter = $npdSku;
						$data = $this->Dashboard_model->getDataVmiNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $itemClassList, $itemCatId);
						break;
					case 'hero':
						$itemClassFilter = $heroSku;
						$data = $this->Dashboard_model->getDataVmiNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $itemClassList, $itemCatId);
						break;
					default:
						continue 2;
				}
			}

			$partialRows = $data['data'] ?? [];

			if ($statusType === 'hero') {
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
			$sheet->setCellValue("A{$rowNum}", "Inventory Status: " . ucfirst($statusType));
			$sheet->getStyle("A{$rowNum}")
				->getFont()
				->setBold(true);

			$rowNum++;

			// Write the column‐header row for this section
			foreach ($sectionHeaders as $i => $headerText) {
				$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i + 1);
				$sheet->setCellValue($colLetter . $rowNum, $headerText);
			}
			$sheet->getStyle("A{$rowNum}:{$lastCol}{$rowNum}")
				->getFont()
				->setBold(true);

			$rowNum++;

			// Write each data row for this section
			foreach ($partialRows as $r) {
				$colIndex = 1;

				// LMI/RGDI Code
				$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
				$sheet->setCellValue($colLetter . $rowNum, $r->item);

				// SKU Name
				$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
				$sheet->setCellValue($colLetter . $rowNum, $r->item_name);

				// Item Class (itmcde)
				$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
				$sheet->setCellValue($colLetter . $rowNum, $r->itmcde);

				// Week columns, if this is not “hero”
				if ($statusType !== 'hero') {
					foreach ($weekCols as $wc) {
						$wkNum = (int) str_replace('Week ', '', $wc);
						$field = "week_{$wkNum}";
						$value = property_exists($r, $field) ? $r->$field : 0;

						$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
						$sheet->setCellValue($colLetter . $rowNum, $value);
					}
				}

				$rowNum++;
			}
			// Leave one blank row before the next section
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
