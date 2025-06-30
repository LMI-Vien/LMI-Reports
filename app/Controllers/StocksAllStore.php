<?php

namespace App\Controllers;

use Config\Database;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StocksAllStore extends BaseController
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

	public function dataAllStore()
	{	
		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);
	    $latestVmiData = $this->Dashboard_model->getLatestVmi();
	    $latestWeek = '';
	    $latestYear = '';
	    $sourceDate = 'N / A';
	    if($latestVmiData){
	    	$latestYear = $latestVmiData['year'];
	    	$latestWeek = $latestVmiData['week_id'];
	    	$sourceDate = $latestVmiData['year'] . ' Calendar Week '. $latestWeek;
		}

		$data['title'] = "Trade Dashboard";
		$data['PageUrl'] = 'Trade Dashboard';
		$siteMenuData = $this->Global_model->get_by_menu_url('stocks/data-all-store');
		if($siteMenuData){
			$data["breadcrumb"] = array('Stocks' => base_url('stocks/data-all-store'), $siteMenuData[0]->menu_name => '');
			$data["source"] = "VMI (LMI/RGDI)";
			$data["source_date"] = '<span id="sourceDate">N / A</span>';
			$data["date"] = $sourceDate;	
			$data["pageName"] = $siteMenuData[0]->menu_name;			
		}else{
			$data["breadcrumb"] = array('Stocks' => base_url('stocks/data-all-store'),'Overall Stock Data of all Stores' => '');
			$data["source"] = "VMI (LMI/RGDI)";
			$data["source_date"] = '<span id="sourceDate">N / A</span>';
			$data["date"] = $sourceDate;	
			$data["pageName"] = '';			
		}

		$data['content'] = "site/stocks/all-store/data_all_store";
		$data['company'] = $this->Global_model->getCompanies(0);
		$data['itemClassi'] = $this->Global_model->getItemClassification();
		$data['traccItemClassi'] = $this->Global_model->getTraccItemClassification();
		$data['month'] = $this->Global_model->getMonths();
		$data['session'] = session();
		$data['js'] = array(
			"assets/site/bundle/js/bundle.min.js"
                    );
        $data['css'] = array(
        	"assets/site/bundle/css/bundle.min.css"
                    );
		return view("site/layout/template", $data);
	}

	public function getDataAllStore()
	{	
		$areaId = null;
		$ascId = null;
		$baTypeId = null;
		$baId = null;
		$storeId = null;
		$brands = null;

		$ItemClasses = $this->request->getPost('itemClass');
		$ItemClasses = $ItemClasses === '' ? null : $ItemClasses;

		$itemCat = trim($this->request->getPost('itemCategory') ?? '');
		$itemCat = $itemCat === '' ? null : $itemCat;

		$companyId = trim($this->request->getPost('company') ?? '');
		$companyId = $companyId === '' ? null : $companyId;

		$type = $this->request->getPost('type');
		$type = $type === '' ? null : $type;

		$limit = $this->request->getVar('limit');
		$offset = $this->request->getVar('offset');
		$limit = is_numeric($limit) ? (int)$limit : 10;
		$offset = is_numeric($offset) ? (int)$offset : 0;

		$orderColumnIndex = $this->request->getVar('order')[0]['column'] ?? 0;
	    $orderDirection = $this->request->getVar('order')[0]['dir'] ?? 'desc';
	    $columns = $this->request->getVar('columns');
	    $orderByColumn = $columns[$orderColumnIndex]['data'] ?? 'sum_total_qty';
	    
		$searchValue = trim($this->request->getVar('search')['value'] ?? '');
		$searchValue = $searchValue === '' ? null : $searchValue;

		$latestVmiData = $this->Dashboard_model->getLatestVmi();
		$sysPar = $this->Global_model->getSysPar();
		$npdSku = [];
		$heroSku = [];
		$skuMin = 20;
		$skuMin = 30;
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

	    if($latestVmiData){
	    	$latestYear = $latestVmiData['year_id'];
	    	$latestWeek = $latestVmiData['week_id'];
	    	//temp
		    //$type = 'npd';
		    // $areaId = null;
		    // $ascId = null;
		    // $baTypeId = 3;
		    // $baId = null;
		    // $storeId = '1001';
		    // $brands = null;
		    // $limit = 10;
		    // $offset = 0;
		    //$companyId = 3;
		    //$ItemClasses = ['C-Class C - Others', 'N-New Item'];
		    //$itemCat = 9;
		    $orderDirection = strtoupper($orderDirection);
		    switch ($type) {
		        case 'slowMoving':
		            $data = $this->Dashboard_model->dataPerStore($limit, $offset, $orderByColumn, $orderDirection, $skuMin, $skuMax, $latestWeek, $latestYear, $brands, $baId, $baTypeId, $areaId, $ascId, $storeId, $companyId, $ItemClasses, $itemCat, $searchValue);
		            break;
		        case 'overStock':
		            $data = $this->Dashboard_model->dataPerStore($limit, $offset, $orderByColumn, $orderDirection, $skuMax, null, $latestWeek, $latestYear, $brands, $baId, $baTypeId, $areaId, $ascId, $storeId, $companyId, $ItemClasses, $itemCat, $searchValue);
		            break;
		        case 'npd':
					$itemClassFilter = $npdSku;
		           $data = $this->Dashboard_model->getItemClassNPDHEROData($limit, $offset, $orderByColumn, $orderDirection, $latestWeek, $latestYear, $brands, $baId, $baTypeId, $areaId, $ascId, $storeId, $itemClassFilter, $companyId, $ItemClasses, $itemCat, $searchValue);
		            break;
		        case 'hero':
        			$itemClassFilter = $heroSku;
		            $data = $this->Dashboard_model->getItemClassNPDHEROData($limit, $offset, $orderByColumn, $orderDirection, $latestWeek, $latestYear, $brands, $baId, $baTypeId, $areaId, $ascId, $storeId, $itemClassFilter, $companyId, $ItemClasses, $itemCat, $searchValue);
		            break;
		        default:
		        	$data = $this->Dashboard_model->dataPerStore($limit, $offset, $orderByColumn, $orderDirection, $skuMin, $skuMax, $latestWeek, $latestYear, $brands, $baId, $baTypeId, $areaId, $ascId, $storeId, $companyId, $ItemClasses, $itemCat, $searchValue);
		    }

		    return $this->response->setJSON([
		        'draw' => intval($this->request->getVar('draw')),
		        'recordsTotal' => $data['total_records'],
		        'recordsFiltered' => $data['total_records'],
		        'data' => $data['data'],
		    ]);	
			
	    }else{
			return $this->response->setJSON([
		        'draw' => intval($this->request->getVar('draw')),
		        'recordsTotal' => 0,
		        'recordsFiltered' => 0,
		        'data' => [],
		    ]);	
	    }
	}

	public function generatePdf() {
		$areaId    = null;
		$ascId     = null;
		$baTypeId  = null;
		$baId      = null;
		$storeId   = null;
		$brands    = null;

		// 1) Parse itemClass to array
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

		$itemCatId = trim($this->getParam('itemLabelCat') ?? '');
		$itemCatId = $itemCatId === '' ? null : $itemCatId;

		$companyId = trim($this->getParam('vendorName') ?? '');
		$companyId = $companyId === '' ? null : $companyId;

		// 2) Parse inventoryStatus to array
		$typeParamRaw = $this->getParam('inventoryStatus');
		if (is_string($typeParamRaw) && strpos($typeParamRaw, ',') !== false) {
			$typeList = array_map('trim', explode(',', $typeParamRaw));
		} elseif (is_array($typeParamRaw) && count($typeParamRaw) > 0) {
			$typeList = $typeParamRaw;
		} elseif (!empty($typeParamRaw)) {
			$typeList = [ $typeParamRaw ];
		} else {
			$typeList = [];
		}

		$searchParams = $this->getParam('search') ?? [];
		$searchValue = [];
		if (is_array($searchParams)) {
			foreach ($searchParams as $key => $value) {
				$val = trim((string)$value);
				if ($val !== '') {
					$searchValue[$key] = $val;
				}
			}
		}

		$latestVmiData = $this->Dashboard_model->getLatestVmi();
		$sysPar         = $this->Global_model->getSysPar();
		$npdSku         = [];
		$heroSku        = [];
		$skuMin         = 20;
		$skuMax         = 30;

		if ($sysPar) {
			$jsonStringHero = $sysPar[0]['hero_sku'];
			$dataHero = json_decode($jsonStringHero, true);
			$heroSku = array_map(fn($item) => $item['id'], $dataHero);

			$jsonStringNpd = $sysPar[0]['new_item_sku'];
			$dataNpd = json_decode($jsonStringNpd, true);
			$npdSku = array_map(fn($item) => $item['id'], $dataNpd);

			$skuMin = $sysPar[0]['sm_sku_min'];
			$skuMax = $sysPar[0]['sm_sku_max'];
		}

		$title = "Overall Stock Data of All Stores";
		$pdf   = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator('LMI SFA');
		$pdf->SetAuthor('LIFESTRONG MARKETING INC.');
		$pdf->SetTitle($title);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();

		$result  = $this->Global_model->dynamic_search("'tbl_company'", "''", "'name'", 0, 0, "'id:EQ=$companyId'", "''", "''");
		$vendorMap = !empty($result) ? $result[0]['name'] : '';

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

		$filterData = [
			'Item Classes'     => empty($itemClassMap) ? 'None' : $itemClassMap,
			'Item Category'    => $itemCatId      ?? 'None',
			'Inventory Status' => empty($typeList) ? 'None' : implode(', ', $typeList),
			'Vendor'           => $vendorMap      ?? 'None',
		];

		$this->printHeader($pdf, $title);
		$this->printFilter($pdf, $filterData);

		//
		// 3) For each status in $typeList, output a separate page‐section
		//
		foreach ($typeList as $sectionIndex => $singleType) {
			// If this is NOT the very first section, add a new page:
			if ($sectionIndex > 0) {
				$pdf->AddPage();
			}

			// 3a) Print a “section header” such as “Inventory Status: SlowMoving”
			$pdf->SetFont('helvetica', 'B', 10);
			$pdf->Cell(0, 6, "Inventory Status: " . ucfirst($singleType), 0, 1, 'L');
			$pdf->Ln(2);

			// 3b) Decide which columns to use (hero vs. non-hero), excluding “Inventory Status” column
			$isHeroSection = ($singleType === 'hero');
			if ($isHeroSection) {
				$headers = [
					'LMI/RGDI Code',
					'SKU',
					'SKU Name',
					'Item Class',
					'Ave Sales Unit',
					'SWC',
				];
			} else {
				$headers = [
					'LMI/RGDI Code',
					'SKU',
					'SKU Name',
					'Item Class',
					'Total Quantity',
					'Ave Sales Unit',
					'SWC',
				];
			}

			// 3c) Fetch data for exactly this one status
			// $orderColumnIndex = $this->request->getVar("order")[$sectionIndex]['column'] ?? 0;
			// $orderDirection   = $this->request->getVar("order")[$sectionIndex]['dir']    ?? 'desc';

			// $columnsParam = $this->request->getVar('columns') ?? [];
			// if (isset($columnsParam[$orderColumnIndex]['data'])) {
			// 	$orderByColumn = $columnsParam[$orderColumnIndex]['data'];
			// } else {
			// 	// fallback if JS did not send a matching index
			// 	$orderByColumn = 'sum_total_qty';
			// }

			$ord     = $this->request->getVar("order")[$sectionIndex] ?? [];
			$orderColumnIndex = $ord['column'] ?? 0;
			$orderDirection   = strtoupper($ord['dir'] ?? 'desc');

			// If JS sent us "colData", use it directly as the column NAME:
			if (!empty($ord['colData'])) {
				$orderByColumn = $ord['colData'];
			} else {
				// Otherwise fall back to the old columns[…] array
				$columnsParam = $this->request->getVar('columns') ?? [];
				if (isset($columnsParam[$orderColumnIndex]['data'])) {
					$orderByColumn = $columnsParam[$orderColumnIndex]['data'];
				} else {
					$orderByColumn = 'sum_total_qty';
				}
			}

			$limit  = 99999;
			$offset = 0;

			$currentSearchTerm = $searchValue[strtolower($singleType)] ?? null;

			if ($latestVmiData) {
				$latestYear = $latestVmiData['year_id'];
				$latestWeek = $latestVmiData['week_id'];
				$orderDirection = strtoupper($orderDirection);

				switch ($singleType) {
					case 'slowMoving':
						$data = $this->Dashboard_model->dataPerStore($limit, $offset, $orderByColumn, $orderDirection, $skuMin, $skuMax, $latestWeek, $latestYear, $brands, $baId, $baTypeId, $areaId, $ascId, $storeId, $companyId, $itemClassList, $itemCatId, $currentSearchTerm);
						break;
					case 'overStock':
						$data = $this->Dashboard_model->dataPerStore($limit, $offset, $orderByColumn, $orderDirection, $skuMax, null, $latestWeek, $latestYear, $brands, $baId, $baTypeId, $areaId, $ascId, $storeId, $companyId, $itemClassList, $itemCatId, $currentSearchTerm);
						break;
					case 'npd':
						$itemClassFilter = $npdSku;
						$data = $this->Dashboard_model->getItemClassNPDHEROData($limit, $offset, $orderByColumn, $orderDirection, $latestWeek, $latestYear, $brands, $baId, $baTypeId, $areaId, $ascId, $storeId, $itemClassFilter, $companyId, $itemClassList, $itemCatId, $currentSearchTerm);
						break;
					case 'hero':
						$itemClassFilter = $heroSku;
						$data = $this->Dashboard_model->getItemClassNPDHEROData($limit, $offset, $orderByColumn, $orderDirection, $latestWeek, $latestYear, $brands, $baId, $baTypeId, $areaId, $ascId, $storeId, $itemClassFilter, $companyId, $itemClassList, $itemCatId, $currentSearchTerm);
						break;
					default:
						$data = $this->Dashboard_model->dataPerStore($limit, $offset, $orderByColumn, $orderDirection, $skuMin, $skuMax,$latestWeek, $latestYear, $brands, $baId, $baTypeId, $areaId, $ascId, $storeId,$companyId, $itemClassList, $itemCatId, $currentSearchTerm);
						break;
				}
			} else {
				$data = [ 'data' => [] ];
			}

			// 3d) Grab the rows for this single status
			$rows = $data['data'] ?? [];

			// 3e) Draw the column‐headers for this section’s table
			$pdf->SetFont('helvetica', 'B', 9);
			$pageWidth = $pdf->getPageWidth();
			$margins   = $pdf->getMargins();
			$usableW   = $pageWidth - $margins['left'] - $margins['right'];
			$colCount  = count($headers);
			$colWidth  = $usableW / $colCount;

			foreach ($headers as $h) {
				$pdf->Cell($colWidth, 8, $h, 1, 0, 'C');
			}
			$pdf->Ln();
			$pdf->SetFont('helvetica', '', 9);

			// 3f) Print each row—without an “Inventory Status” column
			$rowHeight  = 8;
			$lineHeight = 4;

			foreach ($rows as $row) {
				if ($singleType === 'hero') {
					// HERO rows: no “Total Quantity” column
					$pdf->Cell($colWidth, $rowHeight, $row->itmcde, 1, 0, 'C');
					$pdf->Cell($colWidth, $rowHeight, $row->item,   1, 0, 'C');

					$pdf->MultiCell(
						$colWidth,
						$lineHeight,
						$row->item_name,
						1, 'L', 0, 0, '', '', true, 0, false, true, $rowHeight, 'M', true
					);
					$pdf->MultiCell(
						$colWidth,
						$lineHeight,
						$row->item_class,
						1, 'L', 0, 0, '', '', true, 0, false, true, $rowHeight, 'M', true
					);
					$pdf->Cell($colWidth, $rowHeight, $this->formatTwoDecimals($row->sum_ave_sales), 1, 0, 'C');
					$pdf->Cell($colWidth, $rowHeight, $row->swc,           1, 1, 'C');
				} else {
					// Non‐hero rows (slowMoving / overStock / npd):
					$pdf->Cell($colWidth, $rowHeight, $row->itmcde,       1, 0, 'C');
					$pdf->Cell($colWidth, $rowHeight, $row->item,         1, 0, 'C');

					$pdf->MultiCell(
						$colWidth,
						$lineHeight,
						$row->item_name,
						1, 'L', 0, 0, '', '', true, 0, false, true, $rowHeight, 'M', true
					);
					$pdf->MultiCell(
						$colWidth,
						$lineHeight,
						$row->item_class,
						1, 'L', 0, 0, '', '', true, 0, false, true, $rowHeight, 'M', true
					);
					$pdf->Cell($colWidth, $rowHeight, $this->formatTwoDecimals($row->sum_total_qty), 1, 0, 'C');
					$pdf->Cell($colWidth, $rowHeight, $row->sum_ave_sales, 1, 0, 'C');
					$pdf->Cell($colWidth, $rowHeight, $row->swc,           1, 1, 'C');
				}
			}
		}

		$pdf->Output($title . '.pdf', 'D');
		exit;
	}

	public function generateExcel() {
		$areaId    = null;
		$ascId     = null;
		$baTypeId  = null;
		$baId      = null;
		$storeId   = null;
		$brands    = null;


		$itemClassParam = $this->getParam('itemClass');
		if (is_string($itemClassParam) && strpos($itemClassParam, ',') !== false) {
			$itemClassList = array_map('trim', explode(',', $itemClassParam));
		}
		elseif (is_array($itemClassParam) && count($itemClassParam) > 0) {
			$itemClassList = $itemClassParam;
		}
		elseif (!empty($itemClassParam)) {
			$itemClassList = [ $itemClassParam ];
		}
		else {
			$itemClassList = [];
		}

		$itemCatId = trim($this->getParam('itemLabelCat') ?? '');
		$itemCatId = ($itemCatId === '') ? null : $itemCatId;

		$companyId = trim($this->getParam('vendorName') ?? '');
		$companyId = ($companyId === '') ? null : $companyId;

		$typeParamRaw = $this->getParam('inventoryStatus');
		if (is_string($typeParamRaw) && strpos($typeParamRaw, ',') !== false) {
			$typeList = array_map('trim', explode(',', $typeParamRaw));
		}
		elseif (is_array($typeParamRaw) && count($typeParamRaw) > 0) {
			$typeList = $typeParamRaw;
		}
		elseif (!empty($typeParamRaw)) {
			$typeList = [ $typeParamRaw ];
		}
		else {
			$typeList = [];
		}

		$searchParams = $this->getParam('search') ?? [];
		$searchValue = [];
		if (is_array($searchParams)) {
			foreach ($searchParams as $key => $value) {
				$val = trim((string)$value);
				if ($val !== '') {
					$searchValue[$key] = $val;
				}
			}
		}

		$latestVmiData = $this->Dashboard_model->getLatestVmi();
		$sysPar        = $this->Global_model->getSysPar();
		$npdSku        = [];
		$heroSku       = [];
		$skuMin        = 20;
		$skuMax        = 30;

		if ($sysPar) {
			$jsonStringHero = $sysPar[0]['hero_sku'];
			$dataHero = json_decode($jsonStringHero, true);
			$heroSku = array_map(fn($item) => $item['id'], $dataHero);

			$jsonStringNpd = $sysPar[0]['new_item_sku'];
			$dataNpd = json_decode($jsonStringNpd, true);
			$npdSku = array_map(fn($item) => $item['id'], $dataNpd);

			$skuMin = $sysPar[0]['sm_sku_min'];
			$skuMax = $sysPar[0]['sm_sku_max'];
		}

		$result  = $this->Global_model->dynamic_search("'tbl_company'", "''", "'name'", 0, 0, "'id:EQ=$companyId'", "''", "''");
		$vendorMap = !empty($result) ? $result[0]['name'] : '';

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

		$spreadsheet = new Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();

		$currentWeek = $this->getCurrentWeek();
		$currentWeekDisplay = $currentWeek ? $currentWeek['display'] : 'Unknown Week';

		$sheet->setCellValue('A1', 'LIFESTRONG MARKETING INC.');
		$sheet->setCellValue('A2', 'Report: Overall Stock Data of All Stores');
		$sheet->setCellValue('A4', 'Source: VMI (LMI/RGDI)');
		$sheet->setCellValue('A5', 'Current Week: ' . $currentWeekDisplay);
		$sheet->mergeCells('A1:C1');
		$sheet->mergeCells('A2:C2');

		$sheet->setCellValue('A7', 'Item Class:');
		$sheet->setCellValue('B7', empty($itemClassMap) ? 'None' : $itemClassMap);
		$sheet->setCellValue('C7', 'Inventory Category:');
		$sheet->setCellValue('D7', $itemCatId      ?? 'None');

		$sheet->setCellValue('A8', 'Inventory Status:');
		$sheet->setCellValue('B8', implode(', ', $typeList) ?: 'None');
		$sheet->setCellValue('C8', 'Vendor:');
		$sheet->setCellValue('D8', $vendorMap      ?? 'None');

		$sheet->setCellValue('A9', 'Generated: ' . date('M d, Y, h:i:s A'));

		$currentRow = 11;

		foreach ($typeList as $sectionIndex => $singleType) {
			// 6a) If not the very first block, leave a blank row
			if ($sectionIndex > 0) {
				$currentRow += 2; // one blank row between sections
			}


			$sheet->setCellValue('A' . $currentRow, 'Inventory Status: ' . ucfirst($singleType));
			$sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);

			$currentRow += 2; // leave one row after the section header

			$isHeroSection = ($singleType === 'hero');
			if ($isHeroSection) {
				$headers = [
					'LMI/RGDI Code',
					'SKU',
					'SKU Name',
					'Item Class',
					'Ave Sales Unit',
					'SWC',
				];
			} else {
				$headers = [
					'LMI/RGDI Code',
					'SKU',
					'SKU Name',
					'Item Class',
					'Total Quantity',
					'Ave Sales Unit',
					'SWC',
				];
			}

			$colLetter = 'A';
			foreach ($headers as $headerText) {
				$sheet->setCellValue($colLetter . $currentRow, $headerText);
				// Bold the header
				$sheet->getStyle($colLetter . $currentRow)->getFont()->setBold(true);
				$colLetter++;
			}

			$currentRow++; // move to first data row

			//----------------------------------------------------------------
			// 6d) Determine the requested sort column & direction for this status
			//----------------------------------------------------------------
			// “order” comes from JS as: order[sectionIndex][column], order[sectionIndex][dir], order[sectionIndex][colData]
			$ord = $this->request->getVar('order')[$sectionIndex] ?? [];
			$orderColumnIndex = $ord['column'] ?? 0;
			$orderDirection   = strtoupper($ord['dir'] ?? 'desc');

			// If JS provided “colData”, trust it as the actual field name
			if (!empty($ord['colData'])) {
				$orderByColumn = $ord['colData'];
			} else {
				// fallback to the old “columns[…]” method
				$columnsParam = $this->request->getVar('columns') ?? [];
				if (isset($columnsParam[$orderColumnIndex]['data'])) {
					$orderByColumn = $columnsParam[$orderColumnIndex]['data'];
				} else {
					$orderByColumn = 'sum_total_qty';
				}
			}

			$limit  = 99999;
			$offset = 0;

			$currentSearchTerm = $searchValue[strtolower($singleType)] ?? null;

			if ($latestVmiData) {
				$latestYear = $latestVmiData['year_id'];
				$latestWeek = $latestVmiData['week_id'];

				switch ($singleType) {
					case 'slowMoving':
						$data = $this->Dashboard_model->dataPerStore($limit, $offset, $orderByColumn, $orderDirection, $skuMin, $skuMax, $latestWeek, $latestYear, $brands, $baId, $baTypeId, $areaId, $ascId, $storeId, $companyId, $itemClassList, $itemCatId, $currentSearchTerm);
					break;

					case 'overStock':
						$data = $this->Dashboard_model->dataPerStore($limit, $offset, $orderByColumn, $orderDirection, $skuMax, null, $latestWeek, $latestYear, $brands, $baId, $baTypeId, $areaId, $ascId, $storeId, $companyId, $itemClassList, $itemCatId, $currentSearchTerm);
					break;

					case 'npd':
						$itemClassFilter = $npdSku;
						$data = $this->Dashboard_model->getItemClassNPDHEROData($limit, $offset, $orderByColumn, $orderDirection, $latestWeek, $latestYear, $brands, $baId, $baTypeId, $areaId, $ascId, $storeId, $itemClassFilter, $companyId, $itemClassList, $itemCatId, $currentSearchTerm);
					break;

					case 'hero':
						$itemClassFilter = $heroSku;
						$data = $this->Dashboard_model->getItemClassNPDHEROData($limit, $offset, $orderByColumn, $orderDirection, $latestWeek, $latestYear, $brands, $baId, $baTypeId, $areaId, $ascId, $storeId, $itemClassFilter, $companyId, $itemClassList, $itemCatId, $currentSearchTerm);
					break;

					default:
						$data = $this->Dashboard_model->dataPerStore($limit, $offset, $orderByColumn, $orderDirection, $skuMin, $skuMax, $latestWeek, $latestYear, $brands, $baId, $baTypeId, $areaId, $ascId, $storeId, $companyId, $itemClassList, $itemCatId, $currentSearchTerm);
					break;
				}
			} else {
				$data = [ 'data' => [] ];
			}

			$rows = $data['data'] ?? [];

			//----------------------------------------------------------------
			// 6f) Write each row into Excel under the header we just created
			//----------------------------------------------------------------
			foreach ($rows as $row) {
				$colIndex = 1; // 1==A, 2==B, etc.

				// LMI/RGDI Code
				$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
				$sheet->setCellValue($colLetter . $currentRow, $row->itmcde);

				// SKU
				$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
				$sheet->setCellValue($colLetter . $currentRow, $row->item);

				// SKU Name
				$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
				$sheet->setCellValue($colLetter . $currentRow, $row->item_name);

				// Item Class
				$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
				$sheet->setCellValue($colLetter . $currentRow, $row->item_class);

				if (!$isHeroSection) {
					// Total Quantity
					$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
					$sheet->setCellValue($colLetter . $currentRow, $row->sum_total_qty);
				}

				// Ave Sales Unit
				$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
				$sheet->setCellValue($colLetter . $currentRow, $row->sum_ave_sales);

				// SWC
				$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex++);
				$sheet->setCellValue($colLetter . $currentRow, $row->swc);

				$currentRow++;
			}
		}

		$title = "Overall Stock Data of All Stores";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

	// ================================= Display filters for pdf export ================================
	private function printFilter($pdf, $filters) {
		$pdf->SetFont('helvetica', '', 9);
		$source = "VMI (LMI/RGDI)";
		$pdf->MultiCell(0, 8, "Source: " . $source, 0, 'C', 0, 1, '', '', true);

		$pdf->SetFont('helvetica', '', 9);
		$pdf->Ln(2);

		$pageWidth  = $pdf->getPageWidth();
		$pageMargin = $pdf->getMargins();
		$usableWidth = $pageWidth - $pageMargin['left'] - $pageMargin['right'];

		$perRow   = ceil(count($filters) / 2);
		$colWidth = $usableWidth / $perRow; 

		$rows = array_chunk($filters, $perRow, true);

		foreach ($rows as $rowFilters) {
			$currentX = $pdf->GetX();
			$currentY = $pdf->GetY();

			$cellBaseHeight = 5;  
			$maxLines       = 1;

			foreach ($rowFilters as $key => $value) {
				$txt = "{$key}: {$value}";
				$numLines = $pdf->getNumLines($txt, $colWidth);
				if ($numLines > $maxLines) {
					$maxLines = $numLines;
				}
			}

			$rowHeight = $cellBaseHeight * $maxLines;

			$x = $currentX;
			foreach ($rowFilters as $key => $value) {
				$txt = "{$key}: {$value}";

				$pdf->MultiCell(
					$colWidth,        
					$cellBaseHeight,  
					$txt,             
					0,               
					'L',              
					false,            
					0,                
					$x,               
					$currentY,        
					true,             
					0,                
					false,           
					true,             
					$rowHeight,      
					'T',              
					false             
				);

				$x += $colWidth;
			}

			$pdf->Ln($rowHeight);
		}

		$currentWeek = method_exists($this, 'getCurrentWeek') ? $this->getCurrentWeek() : null;
		$currentWeekDisplay = $currentWeek ? $currentWeek['display'] : 'Unknown Week';

		$currentWeekText = 'Current Week: ' . $currentWeekDisplay;
		$generatedText   = 'Generated Date: ' . date('M d, Y, h:i:s A');

		$pdf->Cell(100, 6, $currentWeekText, 0, 0, 'L');  
		$pdf->Cell(38, 6, '', 0, 0);                      
		$pdf->Cell(0, 6, $generatedText, 0, 1, 'L');

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
		$v = $this->request->getVar($key);
		if (is_null($v)) {
			return null;
		}

		if (is_array($v)) {
			return $v;
		}

		$v = trim((string)$v);
		return $v === '' ? null : $v;
	}

	private function formatComma($value): string {
		if (!is_numeric($value)) {
			return (string)$value;
		}
		return number_format((float)$value, 0, '.', ',');
	}

	private function formatTwoDecimals($value): string {
		if (is_null($value) || !is_numeric($value)) {
			$value = 0;
		}
		return number_format((float)$value, 2, '.', ',');
	}

	private function getCalendarWeeks($year) {
		$weeks = [];

		$date = new \DateTime();
		$date->setDate($year, 1, 4);

		$dayOfWeek = (int)$date->format('N');
		$date->modify('-' . ($dayOfWeek - 1) . ' days');

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
