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
		$data['brandLabel'] = $this->Global_model->getBrandLabelData(0);
		$data['itemClassi'] = $this->Global_model->getItemClassification();
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

		$itemCatId = trim($this->request->getPost('itemCategory') ?? '');
		$itemCatId = $itemCatId === '' ? null : $itemCatId;

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
	    $orderByColumn = $columns[$orderColumnIndex]['data'] ?? 'item_name';

		$sysPar = $this->Global_model->getSysPar();
		$npdSku = [];
		$heroSku = [];
		$skuMin = 20;
		$skuMin = 30;
	    $ItemClasses = null;
	    $itemCatId = null;

		if($sysPar){
			$jsonStringHero = $sysPar[0]['hero_sku'];
			$dataHero = json_decode($jsonStringHero, true);
			$heroSku = array_map(fn($item) => $item['item_class_description'], $dataHero);
			$jsonStringNpd = $sysPar[0]['new_item_sku'];
			$dataNpd = json_decode($jsonStringNpd, true);
			$npdSku = array_map(fn($item) => $item['item_class_description'], $dataNpd);
		    $skuMin = $sysPar[0]['sm_sku_min'];
		    $skuMax = $sysPar[0]['sm_sku_max'];
		    $skuMin = 1;
		}
			$orderDirection = strtoupper($orderDirection);
			if(intval($source) === 3){
			    switch ($type) {
			        case 'slowMoving':
			            $data = $this->Dashboard_model->getDataWeekAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMin, $skuMax, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCatId);
			            break;
			        case 'overStock':
			            $data = $this->Dashboard_model->getDataWeekAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMax, null, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCatId);
			            break;
			        case 'npd':
						$itemClassFilter = $npdSku;
			           $data = $this->Dashboard_model->getDataWeekAllNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $ItemClasses, $itemCatId);
			            break;
			        case 'hero':
	        			$itemClassFilter = $heroSku;
			            $data = $this->Dashboard_model->getDataWeekAllNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $ItemClasses, $itemCatId);
			            break;
			        default:
			        	$data = $this->Dashboard_model->getDataWeekAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMin, $skuMax, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCatId);
			    }
			}else{
			    switch ($type) {
			        case 'slowMoving':
			            $data = $this->Dashboard_model->getDataVmiAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMin, $skuMax, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCatId);
			            break;
			        case 'overStock':
			            $data = $this->Dashboard_model->getDataVmiAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMax, null, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCatId);
			            break;
			        case 'npd':
						$itemClassFilter = $npdSku;
			           $data = $this->Dashboard_model->getDataVmiNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $ItemClasses, $itemCatId);
			            break;
			        case 'hero':
	        			$itemClassFilter = $heroSku;
			            $data = $this->Dashboard_model->getDataVmiNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $ItemClasses, $itemCatId);
			            break;
			        default:
			        	$data = $this->Dashboard_model->getDataVmiAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMin, $skuMax, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCatId);
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
		$ItemClasses = $this->getParam('itemClass');
		$ItemClasses = $ItemClasses === '' ? null : $ItemClasses;

		$itemCatId = trim($this->getParam('itemCategory') ?? '');
		$itemCatId = $itemCatId === '' ? null : $itemCatId;

		$weekStart = trim($this->getParam('weekFrom') ?? '');
		$weekStart = $weekStart === '' ? null : $weekStart;

		$weekEnd = trim($this->getParam('weekTo') ?? '');
		$weekEnd = $weekEnd === '' ? null : $weekEnd;

		$latestYear = trim($this->getParam('year') ?? '');
		$latestYear = $latestYear === '' ? null : $latestYear;

		$source = trim($this->getParam('source') ?? '');
		$source = $source === '' ? null : $source;

		// 2) Parse "type" (inventory status) as an array (possibly comma-separated)
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

		$limit = 99999;
		$offset = 0;

		$orderColumnIndex = $this->request->getVar('order')[0]['column'] ?? 0;
		$orderDirection   = $this->request->getVar('order')[0]['dir']    ?? 'desc';
		$columns          = $this->request->getVar('columns');
		$orderByColumn    = $columns[$orderColumnIndex]['data'] ?? 'item_name';

		$sysPar  = $this->Global_model->getSysPar();
		$npdSku  = [];
		$heroSku = [];
		$skuMin  = 20;
		$skuMax  = null;

		if ($sysPar) {
			$jsonStringHero = $sysPar[0]['hero_sku'];
			$dataHero       = json_decode($jsonStringHero, true);
			$heroSku        = array_map(fn($item) => $item['item_class_description'], $dataHero);

			$jsonStringNpd = $sysPar[0]['new_item_sku'];
			$dataNpd       = json_decode($jsonStringNpd, true);
			$npdSku        = array_map(fn($item) => $item['item_class_description'], $dataNpd);

			$skuMin = $sysPar[0]['sm_sku_min'];
			$skuMax = $sysPar[0]['sm_sku_max'];
			$skuMin = 1;
		}

		$allRows = [];
		foreach ($typeList as $statusType) {
			$statusType = trim($statusType);
			$dir        = strtoupper($orderDirection);

			if (intval($source) === 3) {
				switch ($statusType) {
					case 'slowMoving':
			            $data = $this->Dashboard_model->getDataWeekAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMin, $skuMax, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCatId);
						break;
					case 'overStock':
			            $data = $this->Dashboard_model->getDataWeekAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMax, null, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCatId);
			            break;
					 case 'npd':
						$itemClassFilter = $npdSku;
			           $data = $this->Dashboard_model->getDataWeekAllNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $ItemClasses, $itemCatId);
			            break;
			        case 'hero':
	        			$itemClassFilter = $heroSku;
			            $data = $this->Dashboard_model->getDataWeekAllNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $ItemClasses, $itemCatId);
			            break;
					default:
						continue 2;
				}
			} else {
				switch ($statusType) {
					case 'slowMoving':
			            $data = $this->Dashboard_model->getDataVmiAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMin, $skuMax, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCatId);
			            break;
			        case 'overStock':
			            $data = $this->Dashboard_model->getDataVmiAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMax, null, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCatId);
			            break;
			        case 'npd':
						$itemClassFilter = $npdSku;
			           $data = $this->Dashboard_model->getDataVmiNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $ItemClasses, $itemCatId);
			            break;
			        case 'hero':
	        			$itemClassFilter = $heroSku;
			            $data = $this->Dashboard_model->getDataVmiNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $ItemClasses, $itemCatId);
			            break;
					default:
						continue 2;
				}
			}

			$partialRows = $partial['data'] ?? [];
			foreach ($partialRows as $r) {
				$r->inventory_status = $statusType;
				$allRows[]           = $r;
			}
		}

		$rows = $allRows; 

		$title = "Week by Week Stock Data of all Stores";
		$pdf   = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator('LMI SFA');
		$pdf->SetAuthor('LIFESTRONG MARKETING INC.');
		$pdf->SetTitle($title);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();

		$this->printHeader($pdf, $title);

		$statusLabel = empty($typeList) ? 'None' : implode(', ', $typeList);
		$filterData  = [
			'Item Classes'     => $ItemClasses   ?? 'None',
			'Item Category'    => $itemCatId     ?? 'None',
			'Inventory Status' => $statusLabel,
			'Week From'        => $weekStart     ?? 'None',
			'Week To'          => $weekEnd       ?? 'None',
			'Year'             => $latestYear    ?? 'None',
			'Source'           => $source        ?? 'None',
		];
		$this->printFilter($pdf, $filterData);

		$weekCols = [];
		if ($weekStart !== null && $weekEnd !== null) {
			$startNum = (int)$weekStart;
			$endNum   = (int)$weekEnd;
			for ($w = $startNum; $w <= $endNum; $w++) {
				$weekCols[] = "Week $w";
			}
		}

		if (count($typeList) === 1 && $typeList[0] === 'hero') {
			$headers = ['LMI/RGDI Code', 'SKU Name', 'Item Class', 'Inventory Status'];
		} else {
			$headers = array_merge(
				['LMI/RGDI Code', 'SKU Name', 'Item Class'],
				$weekCols,
				['Inventory Status']
			);
		}

		$pageWidth    = $pdf->getPageWidth();
		$margins      = $pdf->getMargins();
		$usableW      = $pageWidth - $margins['left'] - $margins['right'];
		$colCount     = count($headers);
		$colWidth     = $usableW / $colCount;
		$headerHeight = 8;  
		$rowHeight    = 8;  
		$lineHeight   = 4;  

		$pdf->SetFont('helvetica', 'B', 9);
		$startX = $pdf->GetX();
		foreach ($headers as $idx => $txt) {
			$isLastCell = ($idx === $colCount - 1) ? 1 : 0;
			$pdf->Cell(
				$colWidth,
				$headerHeight,
				$txt,
				1,
				$isLastCell,
				'C'
			);
		}

		$pdf->SetFont('helvetica', '', 9);
		foreach ($rows as $row) {
			$pdf->SetXY($startX, $pdf->GetY());

			if ($row->inventory_status === 'hero' && count($weekCols) > 0) {
				$pdf->Cell($colWidth, $rowHeight, $row->item, 1, 0, 'C');

				// 2) SKU Name (wrapped using MultiCell, then reposition)
				$x_after_col2 = $pdf->GetX();
				$y_current    = $pdf->GetY();
				$pdf->MultiCell(
					$colWidth,       // column width
					$lineHeight,     // line height
					$row->item_name, // content
					1,               // draw border
					'L',             // left‐align text
					0,               // no fill
					0,               // ln=0 (we reposition after)
					'',              // x (auto)
					'',              // y (auto)
					true,            // reset auto height
					0,               // no stretch
					false,           // not HTML
					true,            // autopadding
					$rowHeight,      // force total height = rowHeight
					'M',             // vertical align = middle
					true             // fit text if too tall
				);
				// Move to the top-left of the next column
				$pdf->SetXY($x_after_col2 + $colWidth, $y_current);

				// 3) Item Class
				$pdf->Cell($colWidth, $rowHeight, $row->itmcde, 1, 0, 'C');

				// 4 … (3 + N): print N blank week columns
				foreach ($weekCols as $wc) {
					$pdf->Cell($colWidth, $rowHeight, '', 1, 0, 'C');
				}

				// Last: Inventory Status
				$pdf->Cell(
					$colWidth,
					$rowHeight,
					ucfirst($row->inventory_status),
					1,
					1,
					'C'
				);
				continue;
			}

			// Case B: Pure "hero"-only export (no week columns at all)
			if ($row->inventory_status === 'hero') {
				// 1) LMI/RGDI Code
				$pdf->Cell($colWidth, $rowHeight, $row->item, 1, 0, 'C');

				// 2) SKU Name (wrapped using MultiCell, then reposition)
				$x_after_col2 = $pdf->GetX();
				$y_current    = $pdf->GetY();
				$pdf->MultiCell(
					$colWidth,
					$lineHeight,
					$row->item_name,
					1,
					'L',
					0,
					0,
					'',
					'',
					true,
					0,
					false,
					true,
					$rowHeight,
					'M',
					true
				);
				$pdf->SetXY($x_after_col2 + $colWidth, $y_current);

				// 3) Item Class
				$pdf->Cell($colWidth, $rowHeight, $row->itmcde, 1, 0, 'C');

				// 4) Inventory Status
				$pdf->Cell(
					$colWidth,
					$rowHeight,
					ucfirst($row->inventory_status),
					1,
					1,
					'C'
				);
				continue;
			}

			// Case C: slowMoving / overStock / npd (these have week columns)
			// 1) LMI/RGDI Code
			$pdf->Cell($colWidth, $rowHeight, $row->item, 1, 0, 'C');

			// 2) SKU Name (wrapped using MultiCell, then reposition)
			$x_after_col2 = $pdf->GetX();
			$y_current    = $pdf->GetY();
			$pdf->MultiCell(
				$colWidth,
				$lineHeight,
				$row->item_name,
				1,
				'L',
				0,
				0,
				'',
				'',
				true,
				0,
				false,
				true,
				$rowHeight,
				'M',
				true
			);
			$pdf->SetXY($x_after_col2 + $colWidth, $y_current);

			// 3) Item Class
			$pdf->Cell($colWidth, $rowHeight, $row->itmcde, 1, 0, 'C');

			// 4…(3+N): Week columns
			foreach ($weekCols as $wc) {
				$wkNum = (int) str_replace('Week ', '', $wc);
				$field = "week_" . $wkNum;
				$value = property_exists($row, $field) ? $row->$field : 0;
				$formattedValue = $this->formatComma($value);
				$pdf->Cell($colWidth, $rowHeight, $formattedValue, 1, 0, 'C');
			}

			// Last: Inventory Status
			$pdf->Cell(
				$colWidth,
				$rowHeight,
				ucfirst($row->inventory_status),
				1,
				1,
				'C'
			);
		}

		$pdf->Output($title . '.pdf', 'D');
		exit;
	}

	// public function generateExcel() {
	// 	$ItemClasses = $this->getParam('itemClass');
	// 	$ItemClasses = $ItemClasses === '' ? null : $ItemClasses;

	// 	$itemCatId = trim($this->getParam('itemCategory') ?? '');
	// 	$itemCatId = $itemCatId === '' ? null : $itemCatId;

	// 	$weekStart = trim($this->getParam('weekFrom') ?? '');
	// 	$weekStart = $weekStart === '' ? null : $weekStart;

	// 	$weekEnd = trim($this->getParam('weekTo') ?? '');
	// 	$weekEnd = $weekEnd === '' ? null : $weekEnd;

	// 	$latestYear = trim($this->getParam('year') ?? '');
	// 	$latestYear = $latestYear === '' ? null : $latestYear;

	// 	$source = trim($this->getParam('source') ?? '');
	// 	$source = $source === '' ? null : $source;

	// 	// 2) Parse "type" (inventory status) as an array (possibly comma-separated)
	// 	$typeParam = $this->getParam('type');
	// 	if (is_string($typeParam) && strpos($typeParam, ',') !== false) {
	// 		$typeList = array_map('trim', explode(',', $typeParam));
	// 	} elseif (is_array($typeParam) && count($typeParam) > 0) {
	// 		$typeList = $typeParam;
	// 	} elseif (!empty($typeParam)) {
	// 		$typeList = [ $typeParam ];
	// 	} else {
	// 		$typeList = [];
	// 	}

	// 	$limit = 99999;
	// 	$offset = 0;

	// 	$orderColumnIndex = $this->request->getVar('order')[0]['column'] ?? 0;
	// 	$orderDirection   = $this->request->getVar('order')[0]['dir']    ?? 'desc';
	// 	$columns          = $this->request->getVar('columns');
	// 	$orderByColumn    = $columns[$orderColumnIndex]['data'] ?? 'item_name';

	// 	$sysPar  = $this->Global_model->getSysPar();
	// 	$npdSku  = [];
	// 	$heroSku = [];
	// 	$skuMin  = 1;
	// 	$skuMax  = null;

	// 	if ($sysPar) {
	// 		$jsonStringHero = $sysPar[0]['hero_sku'];
	// 		$dataHero       = json_decode($jsonStringHero, true);
	// 		$heroSku        = array_map(fn($item) => $item['item_class_description'], $dataHero);

	// 		$jsonStringNpd = $sysPar[0]['new_item_sku'];
	// 		$dataNpd       = json_decode($jsonStringNpd, true);
	// 		$npdSku        = array_map(fn($item) => $item['item_class_description'], $dataNpd);

	// 		$skuMin = $sysPar[0]['sm_sku_min'];
	// 		$skuMax = $sysPar[0]['sm_sku_max'];
	// 		$skuMin = 1; 
	// 	}

	// 	$allRows = [];
	// 	foreach ($typeList as $statusType) {
	// 		$statusType = trim($statusType);
	// 		$dir        = strtoupper($orderDirection);

	// 		if (intval($source) === 3) {
	// 			switch ($statusType) {
	// 				case 'slowMoving':
	// 		            $data = $this->Dashboard_model->getDataWeekAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMin, $skuMax, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCatId);
	// 					break;
	// 				case 'overStock':
	// 		            $data = $this->Dashboard_model->getDataWeekAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMax, null, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCatId);
	// 		            break;
	// 				 case 'npd':
	// 					$itemClassFilter = $npdSku;
	// 		           $data = $this->Dashboard_model->getDataWeekAllNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $ItemClasses, $itemCatId);
	// 		            break;
	// 		        case 'hero':
	//         			$itemClassFilter = $heroSku;
	// 		            $data = $this->Dashboard_model->getDataWeekAllNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $ItemClasses, $itemCatId);
	// 		            break;
	// 				default:
	// 					continue 2;
	// 			}
	// 		} else {
	// 			switch ($statusType) {
	// 				case 'slowMoving':
	// 		            $data = $this->Dashboard_model->getDataVmiAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMin, $skuMax, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCatId);
	// 		            break;
	// 		        case 'overStock':
	// 		            $data = $this->Dashboard_model->getDataVmiAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMax, null, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCatId);
	// 		            break;
	// 		        case 'npd':
	// 					$itemClassFilter = $npdSku;
	// 		           $data = $this->Dashboard_model->getDataVmiNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $ItemClasses, $itemCatId);
	// 		            break;
	// 		        case 'hero':
	//         			$itemClassFilter = $heroSku;
	// 		            $data = $this->Dashboard_model->getDataVmiNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $ItemClasses, $itemCatId);
	// 		            break;
	// 				default:
	// 					continue 2;
	// 			}
	// 		}

	// 		$partialRows = $data['data'] ?? [];
	// 		foreach ($partialRows as $r) {
	// 			$r->inventory_status = $statusType;
	// 			$allRows[]           = $r;
	// 		}
	// 	}

	// 	$rows = $allRows; 

	// 	// 6) Build dynamic "Week X" columns
	// 	$weekCols = [];
	// 	if ($weekStart !== null && $weekEnd !== null) {
	// 		$startNum = (int)$weekStart;
	// 		$endNum   = (int)$weekEnd;
	// 		for ($w = $startNum; $w <= $endNum; $w++) {
	// 			$weekCols[] = "Week $w";
	// 		}
	// 	}

	// 	if (count($typeList) === 1 && $typeList[0] === 'hero') {
	// 		$headers = ['LMI/RGDI Code', 'SKU Name', 'Item Class', 'Inventory Status'];
	// 	} else {
	// 		$headers = array_merge(
	// 			['LMI/RGDI Code', 'SKU Name', 'Item Class'],
	// 			$weekCols,
	// 			['Inventory Status']
	// 		);
	// 	}

	// 	$result = $this->Global_model->dynamic_search("'tbl_year'", "''", "'year'", 0, 0, "'id:EQ=$latestYear'", "''", "''");
	// 	$yearMap = !empty($result) ? $result[0]['year'] : '';

	// 	if ($source == 2 ) {
	// 		$sourceMap = "VMI";
	// 	} elseif ($source == 3) { 
	// 		$sourceMap = "Week by Week"; 
	// 	} else {
	// 		$sourceMap = "No Source";
	// 	}

	// 	$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
	// 	$sheet       = $spreadsheet->getActiveSheet();

	// 	$sheet->setCellValue('A1', 'LIFESTRONG MARKETING INC.');
	// 	$sheet->setCellValue('A2', 'Report: Week by Week Stock Data of all Stores');
	// 	$sheet->mergeCells('A1:E1');
	// 	$sheet->mergeCells('A2:E2');

	// 	$sheet->setCellValue('A4', 'Item Class:');
	// 	$sheet->setCellValue('B4', $ItemClasses ?? 'None');
	// 	$sheet->setCellValue('C4', 'Inventory Status:');
	// 	$sheet->setCellValue('D4', empty($typeList) ? 'None' : implode(', ', $typeList));

	// 	$sheet->setCellValue('A5', 'Week From:');
	// 	$sheet->setCellValue('B5', $weekStart ?? 'None');
	// 	$sheet->setCellValue('C5', 'Week To:');
	// 	$sheet->setCellValue('D5', $weekEnd ?? 'None');

	// 	$sheet->setCellValue('A6', 'Year:');
	// 	$sheet->setCellValue('B6', $latestYear ?? 'None');
	// 	$sheet->setCellValue('C6', 'Source:');
	// 	$sheet->setCellValue('D6', $source ?? 'None');
	// 	$sheet->setCellValue('E6', 'Generated: ' . date('M d, Y, h:i:s A'));

	// 	$sheet->setCellValue('A4', 'Item Class:');
	// 	$sheet->setCellValue('B4', $ItemClasses ?? 'None');
	// 	$sheet->setCellValue('C4', 'Inventory Status:');
	// 	$sheet->setCellValue('D4', empty($typeList) ? 'None' : implode(', ', $typeList));

	// 	$sheet->setCellValue('A5', 'Week From:');
	// 	$sheet->setCellValue('B5', $weekStart ?? 'None');
	// 	$sheet->setCellValue('C5', 'Week To:');
	// 	$sheet->setCellValue('D5', $weekEnd ?? 'None');

	// 	$sheet->setCellValue('A6', 'Year:');
	// 	$sheet->setCellValue('B6', $yearMap ?? 'None');
	// 	$sheet->setCellValue('C6', 'Source:');
	// 	$sheet->setCellValue('D6', 'Source: ' . ($sourceMap));
	// 	$sheet->setCellValue('E6', 'Generated: ' . date('M d, Y, h:i:s A'));

	// 	$headerRow = 8;
	// 	$lastCol   = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($headers));
	// 	foreach ($headers as $i => $headerText) {
	// 		$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i + 1);
	// 		$sheet->setCellValue($colLetter . $headerRow, $headerText);
	// 	}

	// 	$sheet->getStyle("A{$headerRow}:{$lastCol}{$headerRow}")
	// 		->getFont()
	// 		->setBold(true);

	// 	// 11) Write data rows starting at row 9
	// 	$rowNum = $headerRow + 1; // = 9
	// 	foreach ($rows as $row) {
	// 		$colIndex = 1;

	// 		// A) LMI/RGDI Code
	// 		$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
	// 		$sheet->setCellValue($colLetter . $rowNum, $row->item);

	// 		// B) SKU Name
	// 		$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
	// 		$sheet->setCellValue($colLetter . $rowNum, $row->item_name);

	// 		// C) Item Class
	// 		$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
	// 		$sheet->setCellValue($colLetter . $rowNum, $row->itmcde);

	// 		// D…(week columns) – skip if a pure “hero” export
	// 		if (!(count($typeList) === 1 && $typeList[0] === 'hero')) {
	// 			foreach ($weekCols as $wc) {
	// 				$wkNum = (int) str_replace('Week ', '', $wc);
	// 				$field = "week_" . $wkNum;
	// 				$value = property_exists($row, $field) ? $row->$field : 0;

	// 				$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
	// 				$sheet->setCellValue($colLetter . $rowNum, $value);
	// 			}
	// 		}

	// 		// Inventory Status
	// 		$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
	// 		$sheet->setCellValue($colLetter . $rowNum, ucfirst($row->inventory_status));

	// 		$rowNum++;
	// 	}

	// 	$title = "Week by Week Stock Data of all Stores";
	// 	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	// 	header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
	// 	header('Cache-Control: max-age=0');

	// 	$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
	// 	$writer->save('php://output');
	// 	exit;
	// }

	public function generateExcel() {
		// 1) Read filter parameters from request
		$ItemClasses = $this->getParam('itemClass');
		$ItemClasses = $ItemClasses === '' ? null : $ItemClasses;

		$itemCatId = trim($this->getParam('itemCategory') ?? '');
		$itemCatId = $itemCatId === '' ? null : $itemCatId;

		$weekStart = trim($this->getParam('weekFrom') ?? '');
		$weekStart = $weekStart === '' ? null : $weekStart;

		$weekEnd = trim($this->getParam('weekTo') ?? '');
		$weekEnd = $weekEnd === '' ? null : $weekEnd;

		$latestYear = trim($this->getParam('year') ?? '');
		$latestYear = $latestYear === '' ? null : $latestYear;

		$source = trim($this->getParam('source') ?? '');
		$source = $source === '' ? null : $source;

		// 2) Parse "type" (inventory status) as an array (possibly comma-separated)
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

		$limit = 99999;
		$offset = 0;
		$orderColumnIndex = $this->request->getVar('order')[0]['column'] ?? 0;
		$orderDirection   = $this->request->getVar('order')[0]['dir']    ?? 'desc';
		$columns          = $this->request->getVar('columns');
		$orderByColumn    = $columns[$orderColumnIndex]['data'] ?? 'item_name';

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

		$allRows = [];
		foreach ($typeList as $statusType) {
			$statusType = trim($statusType);
			$dir        = strtoupper($orderDirection);

			if (intval($source) === 3) {
				switch ($statusType) {
					case 'slowMoving':
						$data = $this->Dashboard_model->getDataWeekAllStore($limit, $offset, $orderByColumn, $dir, $skuMin, $skuMax, $weekStart, $weekEnd,$latestYear, $ItemClasses, $itemCatId);
						break;
					case 'overStock':
						$data = $this->Dashboard_model->getDataWeekAllStore($limit, $offset, $orderByColumn, $dir, $skuMax, null, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCatId);
						break;
					case 'npd':
						$itemClassFilter = $npdSku;
			           $data = $this->Dashboard_model->getDataWeekAllNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $ItemClasses, $itemCatId);
			            break;
					case 'hero':
	        			$itemClassFilter = $heroSku;
			            $data = $this->Dashboard_model->getDataWeekAllNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $ItemClasses, $itemCatId);
			            break;
					default:
						continue 2;
				}
			} else {
				switch ($statusType) {
					case 'slowMoving':
			            $data = $this->Dashboard_model->getDataVmiAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMin, $skuMax, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCatId);
			            break;
			        case 'overStock':
			            $data = $this->Dashboard_model->getDataVmiAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMax, null, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCatId);
			            break;
			        case 'npd':
						$itemClassFilter = $npdSku;
			           $data = $this->Dashboard_model->getDataVmiNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $ItemClasses, $itemCatId);
			            break;
			        case 'hero':
	        			$itemClassFilter = $heroSku;
			            $data = $this->Dashboard_model->getDataVmiNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $ItemClasses, $itemCatId);
			            break;
					default:
						continue 2;
				}
			}

			$partialRows = $data['data'] ?? [];
			foreach ($partialRows as $r) {
				$r->inventory_status = $statusType;
				$allRows[]           = $r;
			}
		}

		$rows = $allRows;

		$weekCols = [];
		if (!(count($typeList) === 1 && $typeList[0] === 'hero')
			&& $weekStart !== null
			&& $weekEnd !== null
		) {
			$startNum = (int)$weekStart;
			$endNum   = (int)$weekEnd;
			for ($w = $startNum; $w <= $endNum; $w++) {
				$weekCols[] = "Week $w";
			}
		}

		if (count($typeList) === 1 && $typeList[0] === 'hero') {
			$headers = ['LMI/RGDI Code', 'SKU Name', 'Item Class', 'Inventory Status'];
		} else {
			$headers = array_merge(
				['LMI/RGDI Code', 'SKU Name', 'Item Class'],
				$weekCols,
				['Inventory Status']
			);
		}

		$result  = $this->Global_model->dynamic_search("'tbl_year'", "''", "'year'", 0, 0, "'id:EQ=$latestYear'", "''", "''");
		$yearMap = !empty($result) ? $result[0]['year'] : '';

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
		$sheet->setCellValue('B4', $ItemClasses ?? 'None');
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

		$headerRow = 8;
		$lastCol   = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($headers));
		foreach ($headers as $i => $headerText) {
			$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i + 1);
			$sheet->setCellValue($colLetter . $headerRow, $headerText);
		}
		$sheet->getStyle("A{$headerRow}:{$lastCol}{$headerRow}")
			->getFont()
			->setBold(true);

		$rowNum = $headerRow + 1;
		foreach ($rows as $row) {
			$colIndex = 1;

			// A) LMI/RGDI Code
			$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
			$sheet->setCellValue($colLetter . $rowNum, $row->item);

			// B) SKU Name
			$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
			$sheet->setCellValue($colLetter . $rowNum, $row->item_name);

			// C) Item Class
			$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
			$sheet->setCellValue($colLetter . $rowNum, $row->itmcde);

			// D…(week columns) – only if not “hero”-only
			// if (!(count($typeList) === 1 && $typeList[0] === 'hero')) {
			// 	foreach ($weekCols as $wc) {
			// 		$wkNum = (int) str_replace('Week ', '', $wc);
			// 		$field = "week_" . $wkNum;
			// 		$value = property_exists($row, $field) ? $row->$field : 0;

			// 		$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
			// 		$sheet->setCellValue($colLetter . $rowNum, $value);
			// 	}
			// }
			if ($row->inventory_status !== 'hero') {
				foreach ($weekCols as $wc) {
					$wkNum = (int) str_replace('Week ', '', $wc);
					$field = "week_" . $wkNum;
					$value = property_exists($row, $field) ? $row->$field : 0;

					$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
					$sheet->setCellValue($colLetter . $rowNum, $value);
				}
			} else {
				// If this is a hero row, still “consume” the same number of columns
				// (so Inventory Status ends up in the correct place),
				// but leave them blank:
				for ($i = 0; $i < count($weekCols); $i++) {
					$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
					$sheet->setCellValue($colLetter . $rowNum, '');
				}
			}

			// Inventory Status (last column)
			$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
			$sheet->setCellValue($colLetter . $rowNum, ucfirst($row->inventory_status));

			$rowNum++;
		}

		$title = "Week by Week Stock Data of all Stores";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}


	
    



}
