<?php

namespace App\Controllers;

use Config\Database;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StocksPerStore extends BaseController
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

	public function dataPerStore()
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

		$data['brand_ambassadors'] = $this->Global_model->getBrandAmbassador(0);
		$data['store_branches'] = $this->Global_model->getStoreBranchById(0);
		$data['brands'] = $this->Global_model->getBrandData("ASC", 99999, 0);
		$data['asc'] = $this->Global_model->getAsc(0);
		$data['areas'] = $this->Global_model->getArea(0);
		
		$data['title'] = "Trade Dashboard";
		$data['page_name'] = 'Trade Dashboard';
		$data['page_url'] = 'Trade Dashboard';
		$data["breadcrumb"] = array('Stocks' => base_url('stocks/data-per-store'),'Stock Data per Area or Store' => '');
		$data["source"] = "VMI (LMI/RGDI)";
		$data["source_date"] = '<span id="sourceDate">N / A</span>';
		$data["date"] = $sourceDate;	
		$data["latestWeek"] = $latestWeek;
		$data['content'] = "site/stocks/per-store/data_per_store";
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


	public function getDataPerStore()
	{

		$areaId = trim($this->request->getPost('area') ?? '');
		$areaId = $areaId === '' ? null : $areaId;

		$ascId = trim($this->request->getPost('asc') ?? '');
		$ascId = $ascId === '' ? null : $ascId;

		$baTypeId = trim($this->request->getPost('baType') ?? '');
		$baTypeId = $baTypeId === '' ? null : $baTypeId;

		$baId = trim($this->request->getPost('ba') ?? '');
		$baId = $baId === '' ? null : $baId;

		$storeId = trim($this->request->getPost('store') ?? '');
		$storeId = $storeId === '' ? null : $storeId;

		$brands = $this->request->getPost('brands');
		$brands = $brands === '' ? null : $brands;

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
		$skuMax = 30;
	    $companyId = null;
	    $ItemClasses = null;
	    $itemCatId = null;
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
		    // $type = 'npd';
		    // $areaId = null;
		    // $ascId = null;
		    // $baTypeId = 3;
		    // $baId = null;
		    // $storeId = 30;
		    // $brands = null;
		    // $limit = 10;
		    // $offset = 0;
		    // echo $offset;
		    //$latestYear = 6;
	    	//$latestWeek = 4;

		    $orderDirection = strtoupper($orderDirection);
		    switch ($type) {
		        case 'slowMoving':
		            $data = $this->Dashboard_model->dataPerStore($limit, $offset, $orderByColumn, $orderDirection, $skuMin, $skuMax, $latestWeek, $latestYear, $brands, $baId, $baTypeId, $areaId, $ascId, $storeId, $companyId, $ItemClasses, $itemCatId, $searchValue);
		            break;
		        case 'overStock':
		            $data = $this->Dashboard_model->dataPerStore($limit, $offset, $orderByColumn, $orderDirection, $skuMax, null, $latestWeek, $latestYear, $brands, $baId, $baTypeId, $areaId, $ascId, $storeId, $companyId, $ItemClasses, $itemCatId, $searchValue);
		            break;
		        case 'npd':
					$itemClassFilter = $npdSku;
		           $data = $this->Dashboard_model->getItemClassNPDHEROData($limit, $offset, $orderByColumn, $orderDirection, $latestWeek, $latestYear, $brands, $baId, $baTypeId, $areaId, $ascId, $storeId, $itemClassFilter, $companyId, $ItemClasses, $itemCatId, $searchValue);
		            break;
		        case 'hero':
        			$itemClassFilter = $heroSku;
		            $data = $this->Dashboard_model->getItemClassNPDHEROData($limit, $offset, $orderByColumn, $orderDirection, $latestWeek, $latestYear, $brands, $baId, $baTypeId, $areaId, $ascId, $storeId, $itemClassFilter, $companyId, $ItemClasses, $itemCatId, $searchValue);
		            break;
		        default:
		        	$data = $this->Dashboard_model->dataPerStore($limit, $offset, $orderByColumn, $orderDirection,$skuMin, $skuMax, $latestWeek, $latestYear, $brands, $baId, $baTypeId, $areaId, $ascId, $storeId, $companyId, $ItemClasses, $itemCatId, $searchValue);
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

	public function generatePdf()
	{	
		$json = $this->request->getJSON(true); 
		$areaId = trim($json['area'] ?? '');
		$areaId = $areaId === '' ? null : $areaId;

		$areaText = trim($json['areaText'] ?? '');
		$areaText = $areaText === '' ? null : $areaText;

		$ascId = trim($json['asc'] ?? '');
		$ascId = $ascId === '' ? null : $ascId;

		$ascText = trim($json['ascText'] ?? '');
		$ascText = $ascText === '' ? null : $ascText;

		$baTypeId = trim($json['baType'] ?? '');
		$baTypeId = $baTypeId === '' ? null : $baTypeId;

		$baId = trim($json['ba'] ?? '');
		$baId = $baId === '' ? null : $baId;

		$baText = trim($json['baText'] ?? '');
		$baText = $baText === '' ? null : $baText;

		$storeId = trim($json['store'] ?? '');
		$storeId = $storeId === '' ? null : $storeId;

		$storeText = trim($json['storeText'] ?? '');
		$storeText = $storeText === '' ? null : $storeText;

		$brands = json_decode($json['brands']) ?? null;
		$brands = $brands === [] ? null : $brands;
		
		$types = json_decode($json['types'], true);
		if (!$types || !is_array($types)) {
			$types = ['hero']; // fallback
		}

		$limit = 99999; // use a really huge number to include everything
		$offset = 0;

		$orderColumnIndex = $json['orderIndex'] ?? 0;
	    $orderDirection = $json['orderDir'] ?? 'desc';
	    $columns = $json['columns'] ?? '';
	    $orderByColumn = $columns[$orderColumnIndex]['data'] ?? 'sum_total_qty';
		
	    $tableSlowMoving = trim($json['table_slowMoving'] ?? '');
		$tableSlowMoving = $tableSlowMoving === '' ? null : $tableSlowMoving;
		
		$tableHero = trim($json['table_hero'] ?? '');
		$tableHero = $tableHero === '' ? null : $tableHero;
		
		$tableNpd = trim($json['table_npd'] ?? '');
		$tableNpd = $tableNpd === '' ? null : $tableNpd;
		
		$tableOverStock = trim($json['table_overStock'] ?? '');
		$tableOverStock = $tableOverStock === '' ? null : $tableOverStock;


		$latestVmiData = $this->Dashboard_model->getLatestVmi();
		$sysPar = $this->Global_model->getSysPar();
		$npdSku = [];
		$heroSku = [];
		$skuMin = 20;
		$skuMax = 30;
	    $companyId = null;
	    $ItemClasses = null;
	    $itemCatId = null;
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
		    $orderDirection = strtoupper($orderDirection);

			$allData = [];

			foreach ($types as $type) {
				$offset = 0;
				$data = null;
				$label = '';
				$itemClassFilter = [];

				switch ($type) {
					case 'slowMoving':
						$label = 'Slow Moving';
						$data = $this->Dashboard_model->dataPerStore(
							$limit, $offset, $orderByColumn, $orderDirection, 
							$skuMin, $skuMax, $latestWeek, $latestYear, 
							$brands, $baId, $baTypeId, $areaId, 
							$ascId, $storeId, $companyId, $ItemClasses, 
							$itemCatId, $tableSlowMoving
						);
						break;

					case 'overStock':
						$label = 'Overstock';
						$data = $this->Dashboard_model->dataPerStore(
							$limit, $offset, $orderByColumn, $orderDirection, 
							$skuMax, null, $latestWeek, $latestYear, 
							$brands, $baId, $baTypeId, $areaId, 
							$ascId, $storeId, $companyId, $ItemClasses, 
							$itemCatId, $tableOverStock
						);
						break;

					case 'npd':
						$label = 'NPD';
						$itemClassFilter = $npdSku;
						$data = $this->Dashboard_model->getItemClassNPDHEROData(
							$limit, $offset, $orderByColumn, $orderDirection, 
							$latestWeek, $latestYear, $brands, $baId, 
							$baTypeId, $areaId, $ascId, $storeId, 
							$itemClassFilter, $companyId, $ItemClasses, $itemCatId, 
							$tableNpd
						);
						break;

					case 'hero':
						$label = 'Hero SKUs';
						$itemClassFilter = $heroSku;
						$data = $this->Dashboard_model->getItemClassNPDHEROData(
							$limit, $offset, $orderByColumn, $orderDirection, 
							$latestWeek, $latestYear, $brands, $baId, 
							$baTypeId, $areaId, $ascId, $storeId, 
							$itemClassFilter, $companyId, $ItemClasses, $itemCatId, 
							$tableHero
						);
						break;

					default:
						$data = $this->Dashboard_model->dataPerStore(
							$limit, $offset, $orderByColumn, $orderDirection,
							$skuMin, $skuMax, $latestWeek, $latestYear, 
							$brands, $baId, $baTypeId, $areaId, 
							$ascId, $storeId, $companyId, $ItemClasses, 
							$itemCatId, ""
						);
						break;
				}

				if (!empty($data['data'])) {
					$allData[] = [
						'type' => $type,
						'label' => $label,
						'rows' => $data['data']
					];
				}

				unset($data);
				gc_collect_cycles();
			}
	    }
	    
		$title = 'Stock_Data_per_Store_' . date('Ymd_His');
		
		$pdf = new \App\Libraries\TCPDFLib('P','mm','A4', true, 'UTF-8', false, false);
		$pdf->SetCreator('LMI SFA');
		$pdf->SetAuthor('LIFESTRONG MARKETING INC.');
		$pdf->SetTitle('BA Dashboard Report');
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(true);
		$pdf->AddPage();

		$logoPath = FCPATH . 'assets/img/lifestrong_white_bg.webp';
		if (file_exists($logoPath)) {
			// (x, y, width)
			$pdf->Image($logoPath, 15, 5, 45);
		}
		
		$pdf->SetFont('helvetica', 'B', 15);
		$pdf->Cell(0, 10, 'LIFESTRONG MARKETING INC.', 0, 1, 'C');
		$pdf->SetFont('helvetica', '', 10);
		$pdf->Cell(0, 5, 'Report: Stock Data per Area or Store', 0, 1, 'C');
		$pdf->Ln(5);

		if ($baId == -5) {
			$brand_ambassador = 'Vacant';
		} elseif ($baId == -6) {
			$brand_ambassador = 'Non BA';
		} else {
			$brand_ambassador = $baText;
		}

		$selectedBrands = $brands ? implode(', ', $brands) : 'ALL';

		$baTypeLabels = [
			'0' => 'Consignment',
			'1' => 'Outright',
			'3' => 'All',
		];

		$baLabels = $baTypeLabels[$baTypeId] ?? 'All';

		$asc  = $ascText  ?: '';
		$area = $areaText ?: '';

		// build a simple key→value array for our two rows of filters
		$filters = [
			'Brand Ambassador'     => $brand_ambassador ?: 'ALL',
			'Brand'                => $selectedBrands,
			'Outright/Consignment' => $baLabels,
			'Store Name'           => $storeText ?: 'ALL',
			'Area / ASC Name'      => trim("{$area} / {$asc}") ?: 'ALL',
		];

		$pdf->SetFont('helvetica', '', 9);

		$pageWidth   = $pdf->getPageWidth();
		$margins     = $pdf->getMargins();
		$usableWidth = $pageWidth - $margins['left'] - $margins['right'];
		$perRow       = ceil(count($filters) / 2);
		$colWidth     = $usableWidth / $perRow;
		$rows         = array_chunk($filters, $perRow, true);

		$cellBaseHeight = 4;
		foreach ($rows as $rowFilters) {
			$currentX = $pdf->GetX();
			$currentY = $pdf->GetY();

			$maxLines = 1;
			foreach ($rowFilters as $key => $value) {
				$plain    = strip_tags("<b>{$key}:</b> {$value}");
				$lines    = $pdf->getNumLines($plain, $colWidth);
				$maxLines = max($maxLines, $lines);
			}
			$rowHeight = $maxLines * $cellBaseHeight;

			$x = $currentX;
			foreach ($rowFilters as $key => $value) {
				$html = '<b>' . htmlspecialchars($key) . ':</b> '
					. htmlspecialchars($value);

				$pdf->MultiCell(
					$colWidth,        // width
					$cellBaseHeight,  // nominal line height
					$html,            // HTML text
					0,                // no border
					'L',              // left align
					false,            // no fill
					0,                // stay on same line
					$x,               // x
					$currentY,        // y
					true,             // reset height
					0,                // stretch
					true,             // isHTML = true
					true,             // autopadding
					$rowHeight,       // max height
					'T',              // valign: top
					false             // fitcell
				);
				$x += $colWidth;
			}

			$pdf->Ln($rowHeight);
		}

		$generatedAt = date('M d, Y, h:i:s A');
		$pdf->Ln(2);
		$pdf->writeHTMLCell(
			0, 6, '', '',
			'<b>Generated Date:</b> ' . $generatedAt,
			0, 1, false, true, 'L', true
		);
		$pdf->Ln(2);
		$pdf->Cell(0, 0, '', 'T');
		$pdf->Ln(4);

		$pdf->SetFont('helvetica', '', 10);

		foreach ($allData as $section) {
			$pdf->SetFont('helvetica', 'B', 10);
			$pdf->Cell(0, 6, $section['label'], 0, 1, 'L');

			if ($section['label'] === "Hero SKUs") {
				$pdf->SetFont('helvetica', 'B', 10);
				$pdf->Cell(35, 6, 'LMI/RGDI Code', 1, 0, 'C');
				$pdf->Cell(30, 6, 'SKU', 1, 0, 'C');
				$pdf->Cell(95, 6, 'SKU Name', 1, 0, 'C');
				$pdf->Cell(30, 6, 'SKU Type', 1, 1, 'C');
				foreach ($section['rows'] as $row) {
					$row = (object) $row;
				    $pdf->SetFont('helvetica', '', 10);
				    $itemCode = (isset($row->itmcde) && !empty($row->itmcde)) ? $row->itmcde : '';
				    $item = (isset($row->item) && !empty($row->item)) ? $row->item : '';
				    $itemName = (isset($row->item_name) && !empty($row->item_name)) ? $row->item_name : '';
				    $pdf->Cell(35, 6, $itemCode, 1, 0, 'C');
				    $pdf->Cell(30, 6, $item, 1, 0, 'C');
				    $pdf->MultiCell(95, 6, $itemName, 1, 'L', 0, 0, '', '', true, 0, false, true, 6, 'M', true);
				    $pdf->MultiCell(30, 6, $section['label'], 1, 'L', 0, 1, '', '', true, 0, false, true, 6, 'M', true);
				}
			} else {
				$pdf->SetFont('helvetica', 'B', 10);
				$pdf->Cell(30, 6, 'LMI/RGDI Code', 1, 0, 'C');
				$pdf->Cell(25, 6, 'SKU', 1, 0, 'C');
				$pdf->Cell(95, 6, 'SKU Name', 1, 0, 'C');
				$pdf->Cell(20, 6, 'Quantity', 1, 0, 'C');
				$pdf->Cell(20, 6, 'SKU Type', 1, 1, 'C');

				foreach ($section['rows'] as $row) {
					$row = (object) $row;
					$pdf->SetFont('helvetica', '', 10);
				    $itemCode = (isset($row->itmcde) && !empty($row->itmcde)) ? $row->itmcde : '';
				    $item = (isset($row->item) && !empty($row->item)) ? $row->item : '';
				    $itemName = (isset($row->item_name) && !empty($row->item_name)) ? $row->item_name : '';
				    $sumTotal = (isset($row->sum_total_qty) && !empty($row->sum_total_qty)) ? $row->sum_total_qty : '';
					$pdf->Cell(30, 6, $itemCode, 1, 0, 'C');
					$pdf->Cell(25, 6, $item, 1, 0, 'C');
					$pdf->MultiCell(95, 6, $itemName, 1, 'L', 0, 0, '', '', true, 0, false, true, 6, 'M', true);
					$pdf->Cell(20, 6, intval($sumTotal), 1, 0, 'C');
					$pdf->MultiCell(20, 6, $section['label'], 1, 'L', 0, 1, '', '', true, 0, false, true, 6, 'M', true);
				}
			}

		}

		$pdf->Output($title . '.pdf', 'D');
		exit;
	}


	public function generateExcel()
	{
		$json = $this->request->getJSON(true); 
		$areaId = trim($json['area'] ?? '');
		$areaId = $areaId === '' ? null : $areaId;

		$areaText = trim($json['areaText'] ?? '');
		$areaText = $areaText === '' ? null : $areaText;

		$ascId = trim($json['asc'] ?? '');
		$ascId = $ascId === '' ? null : $ascId;

		$ascText = trim($json['ascText'] ?? '');
		$ascText = $ascText === '' ? null : $ascText;

		$baTypeId = trim($json['baType'] ?? '');
		$baTypeId = $baTypeId === '' ? null : $baTypeId;

		$baId = trim($json['ba'] ?? '');
		$baId = $baId === '' ? null : $baId;

		$baText = trim($json['baText'] ?? '');
		$baText = $baText === '' ? null : $baText;

		$storeId = trim($json['store'] ?? '');
		$storeId = $storeId === '' ? null : $storeId;

		$storeText = trim($json['storeText'] ?? '');
		$storeText = $storeText === '' ? null : $storeText;

		$brands = json_decode($json['brands']) ?? null;
		$brands = $brands === [] ? null : $brands;
		
		$types = json_decode($json['types'], true);
		if (!$types || !is_array($types)) {
			$types = ['hero']; // fallback
		}

		$limit = 99999; // use a really huge number to include everything
		$offset = 0;

		$orderColumnIndex = $json['orderIndex'] ?? 0;
	    $orderDirection = $json['orderDir'] ?? 'desc';
	    $columns = $json['columns'] ?? '';
	    $orderByColumn = $columns[$orderColumnIndex]['data'] ?? 'sum_total_qty';
		
	    $tableSlowMoving = trim($json['table_slowMoving'] ?? '');
		$tableSlowMoving = $tableSlowMoving === '' ? null : $tableSlowMoving;
		
		$tableHero = trim($json['table_hero'] ?? '');
		$tableHero = $tableHero === '' ? null : $tableHero;
		
		$tableNpd = trim($json['table_npd'] ?? '');
		$tableNpd = $tableNpd === '' ? null : $tableNpd;
		
		$tableOverStock = trim($json['table_overStock'] ?? '');
		$tableOverStock = $tableOverStock === '' ? null : $tableOverStock;

		$latestVmiData = $this->Dashboard_model->getLatestVmi();
		$sysPar = $this->Global_model->getSysPar();
		$npdSku = [];
		$heroSku = [];
		$skuMin = 20;
		$skuMax = 30;
	    $companyId = null;
	    $ItemClasses = null;
	    $itemCatId = null;
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
		    $orderDirection = strtoupper($orderDirection);

			$allData = [];

			foreach ($types as $type) {
				$offset = 0;
				$data = null;
				$label = '';
				$itemClassFilter = [];

				switch ($type) {
					case 'slowMoving':
						$label = 'Slow Moving';
						$data = $this->Dashboard_model->dataPerStore(
							$limit, $offset, $orderByColumn, $orderDirection, 
							$skuMin, $skuMax, $latestWeek, $latestYear, 
							$brands, $baId, $baTypeId, $areaId, 
							$ascId, $storeId, $companyId, $ItemClasses, 
							$itemCatId, $tableSlowMoving
						);
						break;

					case 'overStock':
						$label = 'Overstock';
						$data = $this->Dashboard_model->dataPerStore(
							$limit, $offset, $orderByColumn, $orderDirection, 
							$skuMax, null, $latestWeek, $latestYear, 
							$brands, $baId, $baTypeId, $areaId, 
							$ascId, $storeId, $companyId, $ItemClasses, 
							$itemCatId, $tableOverStock
						);
						break;

					case 'npd':
						$label = 'NPD';
						$itemClassFilter = $npdSku;
						$data = $this->Dashboard_model->getItemClassNPDHEROData(
							$limit, $offset, $orderByColumn, $orderDirection, 
							$latestWeek, $latestYear, $brands, $baId, 
							$baTypeId, $areaId, $ascId, $storeId, 
							$itemClassFilter, $companyId, $ItemClasses, $itemCatId, 
							$tableNpd
						);
						break;

					case 'hero':
						$label = 'Hero SKUs';
						$itemClassFilter = $heroSku;
						$data = $this->Dashboard_model->getItemClassNPDHEROData(
							$limit, $offset, $orderByColumn, $orderDirection, 
							$latestWeek, $latestYear, $brands, $baId, 
							$baTypeId, $areaId, $ascId, $storeId, 
							$itemClassFilter, $companyId, $ItemClasses, $itemCatId, 
							$tableHero
						);
						break;

					default:
						$data = $this->Dashboard_model->dataPerStore(
							$limit, $offset, $orderByColumn, $orderDirection,
							$skuMin, $skuMax, $latestWeek, $latestYear, 
							$brands, $baId, $baTypeId, $areaId, 
							$ascId, $storeId, $companyId, $ItemClasses, 
							$itemCatId, ""
						);
						break;
				}

				if (!empty($data['data'])) {
					$allData[] = [
						'type' => $type,
						'label' => $label,
						'rows' => $data['data']
					];
				}

				unset($data);
				gc_collect_cycles();
			}
	    }

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'LIFESTRONG MARKETING INC.');
		$sheet->setCellValue('A2', 'Report: Stock Data per Area or Store');
		$sheet->mergeCells('A1:E1');
		$sheet->mergeCells('A2:E2');

		$rowNum = 8;
		foreach ($allData as $section) {
			$headers = ['LMI/RGDI Code', 'SKU', 'SKU Name', 'Quantity', 'SKU Type'];
			$sheet->fromArray($headers, null, 'A7');
			$sheet->getStyle('A7:E7')->getFont()->setBold(true);

			if ($baId == -5) {
				$brand_ambassador = 'Vacant';
			} elseif ($baId == -6) {
				$brand_ambassador = 'Non BA';
			} else {
				$brand_ambassador = $baText;
			}
			$sheet->setCellValue('A4', 'Brand Ambassador: ' . ($brand_ambassador ?: 'ALL'));
			$selectedBrands = '';
			if($brands){
				$selectedBrands = implode(", ", $brands);
				
			}

			$sheet->setCellValue('B4', 'Brand: ' . ($selectedBrands ?: 'ALL'));

			$baTypeLabels = [
				'0' => 'Consignment',
				'1' => 'Outright',
				'3' => 'All',
			];

			$baLabels = isset($baTypeLabels[$baTypeId]) ? $baTypeLabels[$baTypeId] : 'All';
			$sheet->setCellValue('C4', 'Outright/Consignment: '.$baTypeLabels[$baTypeId]);

			$sheet->setCellValue('A5', 'Store Name: ' . ($storeText ?: 'ALL'));
			$asc = isset($ascText) ? $ascText . ' - ' . $ascText : null;
			$area = isset($areaText) ? $areaText . ' - ' . $areaText : null;

			$sheet->setCellValue('B5', 'Area / ASC Name: ' . ($area . '/'. $asc ?: ''));
			$sheet->setCellValue('C5', 'Date Generated: ' . date('M d, Y, h:i:s A'));

			if ($section['label'] === "Hero SKUs") {
				foreach ($section['rows'] as $row) {
					$row = (object) $row;
					$sheet->setCellValueExplicit('A' . $rowNum, $row->itmcde, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
					$sheet->setCellValueExplicit('B' . $rowNum, $row->item, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
					$sheet->setCellValueExplicit('C' . $rowNum, $row->item_name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
					$sheet->setCellValueExplicit('E' . $rowNum, $section['label'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
					$rowNum+=1;
				}
			} else {
				foreach ($section['rows'] as $row) {
					$row = (object) $row;
					$sheet->setCellValueExplicit('A' . $rowNum, $row->itmcde, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
					$sheet->setCellValueExplicit('B' . $rowNum, $row->item, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
					$sheet->setCellValueExplicit('C' . $rowNum, $row->item_name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
					$sheet->setCellValueExplicit('D' . $rowNum, intval($row->sum_total_qty), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
					$sheet->setCellValueExplicit('E' . $rowNum, $section['label'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
					$rowNum+=1;
				}
			}

		}

		$title = 'Stock_Data_per_Store_' . date('Ymd_His');

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}
}
