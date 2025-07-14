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
		$data['content'] = "site/stocks/per-store/data_per_store";
		$data['session'] = session();
		$data['js'] = array(
			"assets/site/bundle/js/bundle.min.js"
                    );
        $data['css'] = array(
        	"assets/site/bundle/css/bundle.min.css"
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
		    // $storeId = '1001';
		    // $brands = null;
		    // $limit = 10;
		    // $offset = 0;
		    // echo $offset;
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
		$areaId = trim($this->request->getGet('area') ?? '');
		$areaId = $areaId === '' ? null : $areaId;

		$ascId = trim($this->request->getGet('asc') ?? '');
		$ascId = $ascId === '' ? null : $ascId;

		$baTypeId = trim($this->request->getGet('baType') ?? '');
		$baTypeId = $baTypeId === '' ? null : $baTypeId;

		$baId = trim($this->request->getGet('ba') ?? '');
		$baId = $baId === '' ? null : $baId;

		$storeId = trim($this->request->getGet('store') ?? '');
		$storeId = $storeId === '' ? null : $storeId;

		$brands = $this->request->getGet('brands');
		$brands = $brands === '' ? null : $brands;

		$types = json_decode($this->request->getGet('types'), true);
		if (!$types || !is_array($types)) {
			$types = ['hero']; // fallback
		}

		$limit = 99999; // use a really huge number to include everything
		$offset = 0;

		$orderColumnIndex = $this->request->getGet('orderIndex') ?? 0;
	    $orderDirection = $this->request->getGet('orderDir') ?? 'desc';
	    $columns = json_decode($this->request->getGet('columns'), true);
	    $orderByColumn = $columns[$orderColumnIndex]['data'] ?? 'sum_total_qty';

	    $tableSlowMoving = trim($this->request->getGet('table_slowMoving') ?? '');
		$tableSlowMoving = $tableSlowMoving === '' ? null : $tableSlowMoving;

		$tableHero = trim($this->request->getGet('table_hero') ?? '');
		$tableHero = $tableHero === '' ? null : $tableHero;

		$tableNpd = trim($this->request->getGet('table_npd') ?? '');
		$tableNpd = $tableNpd === '' ? null : $tableNpd;

		$tableOverStock = trim($this->request->getGet('table_overStock') ?? '');
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
		
		$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator('LMI SFA');
		$pdf->SetAuthor('LIFESTRONG MARKETING INC.');
		$pdf->SetTitle('BA Dashboard Report');
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		
		$pdf->SetFont('helvetica', '', 12);
		$pdf->Cell(0, 10, 'LIFESTRONG MARKETING INC.', 0, 1, 'C');
		$pdf->SetFont('helvetica', '', 10);
		$pdf->Cell(0, 5, 'Report: Stock Data per Area or Store', 0, 1, 'C');
		$pdf->Ln(5);

		$pdf->SetFont('helvetica', '', 9);
		if ($baId == -5) {
			$brand_ambassador = 'Vacant';
		} elseif ($baId == -6) {
			$brand_ambassador = 'Non BA';
		} else {
			$brand_ambassador_data = $this->Global_model->dynamic_search(
				"'tbl_brand_ambassador'", "''", "'name'", 1, 0, "'id:EQ=$baId'", "''", "''"
			);
			$brand_ambassador = isset($brand_ambassador_data[0]['name']) ? $brand_ambassador_data[0]['name'] : null;
		}
		$pdf->Cell(63, 6, 'Brand Ambassador: ' . ($brand_ambassador ?: 'ALL'), 0, 0, 'L');
		$selectedBrands = '';
		if($brands){
			$selectedBrands = implode(", ", $brands);
			
		}
		$pdf->Cell(63, 6, 'Brand: ' . ($selectedBrands ?: 'ALL'), 0, 0, 'L');

		$baTypeLabels = [
			'0' => 'Consignment',
			'1' => 'Outright',
			'3' => 'All',
		];
		$baLabels = isset($baTypeLabels[$baTypeId]) ? $baTypeLabels[$baTypeId] : 'All';
		$pdf->Cell(63, 6, 'Outright/Consignment: '.$baLabels, 0, 1, 'L');

		$store_data = $this->Global_model->dynamic_search("'tbl_store'", "''", "'description'", 1, 0, "'id:EQ=$storeId'", "''", "''");
		$store = isset($store_data[0]['description']) ? $store_data[0]['description'] : null;
		$pdf->Cell(63, 6, 'Store Name: ' . ($store ?: 'ALL'), 0, 0, 'L');

		$asc_data = $this->Global_model->dynamic_search("'tbl_area_sales_coordinator'", "''", "'description'", 1, 0, "'id:EQ=$ascId'", "''", "''");
		$asc = isset($asc_data[0]['description']) ? $asc_data[0]['description'] : null;
		$pdf->Cell(63, 6, 'Area / ASC Name: ' . ($asc ?: ''), 0, 0, 'L');
		$pdf->Cell(63, 6, 'Date Generated: ' . date('M d, Y, h:i:s A'), 0, 1, 'L');
		
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
					$pdf->SetFont('helvetica', '', 10);
					$pdf->Cell(35, 6, $row->itmcde, 1, 0, 'C');
					$pdf->Cell(30, 6, $row->item, 1, 0, 'C');
					$pdf->MultiCell(95, 6, $row->item_name, 1, 'L', 0, 0, '', '', true, 0, false, true, 6, 'M', true);
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
					$pdf->SetFont('helvetica', '', 10);
					$pdf->Cell(30, 6, $row->itmcde, 1, 0, 'C');
					$pdf->Cell(25, 6, $row->item, 1, 0, 'C');
					$pdf->MultiCell(95, 6, $row->item_name, 1, 'L', 0, 0, '', '', true, 0, false, true, 6, 'M', true);
					$pdf->Cell(20, 6, intval($row->sum_total_qty), 1, 0, 'C');
					$pdf->MultiCell(20, 6, $section['label'], 1, 'L', 0, 1, '', '', true, 0, false, true, 6, 'M', true);
				}
			}

		}

		$pdf->Output($title . '.pdf', 'D');
		exit;
	}


	public function generateExcel()
	{
		$areaId = trim($this->request->getGet('area') ?? '');
		$areaId = $areaId === '' ? null : $areaId;

		$ascId = trim($this->request->getGet('asc') ?? '');
		$ascId = $ascId === '' ? null : $ascId;

		$baTypeId = trim($this->request->getGet('baType') ?? '');
		$baTypeId = $baTypeId === '' ? null : $baTypeId;

		$baId = trim($this->request->getGet('ba') ?? '');
		$baId = $baId === '' ? null : $baId;

		$storeId = trim($this->request->getGet('store') ?? '');
		$storeId = $storeId === '' ? null : $storeId;

		$brands = $this->request->getGet('brands');
		$brands = $brands === '' ? null : $brands;

		$types = json_decode($this->request->getGet('types'), true);
		if (!$types || !is_array($types)) {
			$types = ['hero']; // fallback
		}

		$limit = 99999; // use a really huge number to include everything
		$offset = 0;

		$orderColumnIndex = $this->request->getGet('orderIndex') ?? 0;
	    $orderDirection = $this->request->getGet('orderDir') ?? 'desc';
	    $columns = json_decode($this->request->getGet('columns'), true);
	    $orderByColumn = $columns[$orderColumnIndex]['data'] ?? 'sum_total_qty';

	    $tableSlowMoving = trim($this->request->getGet('table_slowMoving') ?? '');
		$tableSlowMoving = $tableSlowMoving === '' ? null : $tableSlowMoving;

		$tableHero = trim($this->request->getGet('table_hero') ?? '');
		$tableHero = $tableHero === '' ? null : $tableHero;

		$tableNpd = trim($this->request->getGet('table_npd') ?? '');
		$tableNpd = $tableNpd === '' ? null : $tableNpd;

		$tableOverStock = trim($this->request->getGet('table_overStock') ?? '');
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
				$brand_ambassador_data = $this->Global_model->dynamic_search(
					"'tbl_brand_ambassador'", "''", "'name'", 1, 0, "'id:EQ=$baId'", "''", "''"
				);
				$brand_ambassador = isset($brand_ambassador_data[0]['name']) ? $brand_ambassador_data[0]['name'] : null;
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

			$store_data = $this->Global_model->dynamic_search("'tbl_store'", "''", "'description'", 1, 0, "'id:EQ=$storeId'", "''", "''");
			$store = isset($store_data[0]['description']) ? $store_data[0]['description'] : null;
			$sheet->setCellValue('A5', 'Store Name: ' . ($store ?: 'ALL'));

			$asc_data = $this->Global_model->dynamic_search("'tbl_area_sales_coordinator'", "''", "'description'", 1, 0, "'id:EQ=$ascId'", "''", "''");
			$asc = isset($asc_data[0]['description']) ? $asc_data[0]['description'] : null;
			$sheet->setCellValue('B5', 'Area / ASC Name: ' . ($asc ?: ''));
			$sheet->setCellValue('C5', 'Date Generated: ' . date('M d, Y, h:i:s A'));

			if ($section['label'] === "Hero SKUs") {
				foreach ($section['rows'] as $row) {
					$sheet->setCellValueExplicit('A' . $rowNum, $row->itmcde, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
					$sheet->setCellValueExplicit('B' . $rowNum, $row->item, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
					$sheet->setCellValueExplicit('C' . $rowNum, $row->item_name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
					$sheet->setCellValueExplicit('E' . $rowNum, $section['label'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
					$rowNum+=1;
				}
			} else {
				foreach ($section['rows'] as $row) {
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
