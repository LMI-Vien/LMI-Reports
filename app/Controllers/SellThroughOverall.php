<?php

namespace App\Controllers;

use Config\Database;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SellThroughOverall extends BaseController
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

	public function overall()
	{
		$uri = current_url(true);
		$data['uri'] = $uri;

		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);
		$data['title'] = "Sell Through Overall";
		$data['PageName'] = 'Sell Through Overall';
		$data['PageUrl'] = 'Sell Through Overall';
		$data["breadcrumb"] = array('Sell Through' => base_url('sell-through/overall'),'Sell Through Overall' => '');
		$data["source"] = "Scan Data";
		$data["source_date"] = '<span id="sourceDate">N / A</span>';
		$data["foot_note"] = '';	
		$data['content'] = "site/sell_through/overall/overall";
		$data['brands'] = $this->Global_model->getBrandData("ASC", 99999, 0);
		$data['brandLabel'] = $this->Global_model->getBrandLabelData(0);
		$data['months'] = $this->Global_model->getMonths();
		$data['year'] = $this->Global_model->getYears();
		$sales_query = "status > 0";
		$data['sales_group'] = $this->Global_model->get_data_list('tbl_pricelist_masterfile', $sales_query, 0, 0, 'id, description','','', '', '');
		$data['sales_group'] = json_decode(json_encode($data['sales_group']), true);
		$brand_cat_query = "status > 0";
		$data['brand_categories'] = $this->Global_model->get_data_list('tbl_classification', $brand_cat_query, 0, 0, 'id, item_class_description','','', '', '');
		$data['brand_categories'] = json_decode(json_encode($data['brand_categories']), true);
		$data['session'] = session();
		$data['js'] = array(
			"assets/site/bundle/js/bundle.min.js",
			"assets/site/js/chart.min.js",
			"assets/site/js/common.js"
                    );
        $data['css'] = array(
        	"assets/site/bundle/css/bundle.min.css",
        	"assets/site/css/common.css"
                    );
		return view("site/layout/template", $data);
	}

	public function getOverall()
	{
		$source = $this->request->getPost('source');
		$source = $source === '' ? null : $source;

		$ItemIds = $this->request->getPost('items');
		$ItemIds = $ItemIds === '' ? null : $ItemIds;

		$brandIds = $this->request->getPost('brands');
		$brandIds = $brandIds === '' ? null : $brandIds;

		$brandTypeIds = $this->request->getPost('brands_label');
		$brandTypeIds = $brandTypeIds === '' ? null : $brandTypeIds;

		$brandCategoryIds = $this->request->getPost('brand_categories');
		$brandCategoryIds = $brandCategoryIds === '' ? null : $brandCategoryIds;

		$year = trim($this->request->getPost('year') ?? '');
		$year = $year === '' ? null : $year;

		$yearId = trim($this->request->getPost('year_id') ?? '');
		$yearId = $yearId === '' ? null : $yearId;

		$monthStart = trim($this->request->getPost('month_start') ?? '');
		$monthStart = $monthStart === '' ? null : $monthStart;

		$monthEnd = trim($this->request->getPost('month_end') ?? '');
		$monthEnd = $monthEnd === '' ? null : $monthEnd;

		$weekStart = trim($this->request->getPost('week_start') ?? '');
		$weekStart = $weekStart === '' ? null : $weekStart;

		$weekEnd = trim($this->request->getPost('week_end') ?? '');
		$weekEnd = $weekEnd === '' ? null : $weekEnd;

		$weekStartDate = trim($this->request->getPost('week_start_date') ?? '');
		$weekStartDate = $weekStartDate === '' ? null : $weekStartDate;

		$weekEndDate = trim($this->request->getPost('week_end_date') ?? '');
		$weekEndDate = $weekEndDate === '' ? null : $weekEndDate;

		$salesGroup = trim($this->request->getPost('sales_group') ?? '');
		$salesGroup = $salesGroup === '' ? null : $salesGroup;
		
		$subSalesGroup = trim($this->request->getPost('sub_sales_group') ?? '');
		$subSalesGroup = $subSalesGroup === '' ? null : $subSalesGroup;

		$sysPar = $this->Global_model->getSysPar();
		$watsonsPaymentGroup = '';
		if($sysPar){
			$watsonsPaymentGroup = $sysPar[0]['watsons_payment_group'];
		}

		$type = $this->request->getPost('type');
		$type = $type === '' ? 3 : $type;

		$measure = $this->request->getPost('measure');
		$measure = $measure === '' ? null : $measure;

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
    	$data = [];
    	
	    switch ($source) {
	        case 'scann_data':
			    $data = $this->Dashboard_model->getSellThroughScannDataBySku($year, $monthStart, $monthEnd, $searchValue, $ItemIds, $brandIds, $brandTypeIds, $brandCategoryIds, $salesGroup, $subSalesGroup, $orderByColumn, $orderDirection,  $limit, $offset, $type, $measure);
				
	            break;
	        case 'week_on_week':
			    $data = $this->Dashboard_model->getSellThroughWeekOnWeekBySku($year, $yearId, $weekStart, $weekEnd, $weekStartDate, $weekEndDate, $searchValue, $ItemIds, $brandIds, $brandTypeIds, $brandCategoryIds, $salesGroup, $subSalesGroup, $watsonsPaymentGroup, $orderByColumn, $orderDirection, $limit, $offset, $type, $measure);
				
	            break;
	        case 'winsight':
				$weekStart = str_pad($weekStart, 2, '0', STR_PAD_LEFT);
			    $weekStart = $year.$weekStart;

			    $weekEnd = str_pad($weekEnd, 2, '0', STR_PAD_LEFT);
			    $weekEnd = $year.$weekEnd;
			    $data = $this->Dashboard_model->getSellThroughWinsightBySku($year, $yearId, $weekStart, $weekEnd, $weekStartDate, $weekEndDate, $searchValue, $ItemIds, $brandIds, $brandTypeIds, $brandCategoryIds, $salesGroup, $subSalesGroup, $watsonsPaymentGroup, $orderByColumn, $orderDirection, $limit, $offset, $type, $measure);
				
				break;
	        default:
	        	$data = $this->Dashboard_model->getSellThroughScannDataBySku($year, $monthStart, $monthEnd, $searchValue, $ItemIds, $brandIds, $brandTypeIds, $brandCategoryIds, $salesGroup, $subSalesGroup, $orderByColumn, $orderDirection, $limit, $offset, $type, $measure);
				
	    }

	    if($data){
	    	return $this->response->setJSON([
				'debug' => $this->request->getPost(),
		        'draw' => intval($this->request->getVar('draw')),
		        'recordsTotal' => $data['total_records'],
		        'recordsFiltered' => $data['total_records'],
		        'data' => $data['data']
		    ]);
	    }else{
	    	return $this->response->setJSON([
				'debug' => $this->request->getPost(),
		        'draw' => intval($this->request->getVar('draw')),
		        'recordsTotal' => 0,
		        'recordsFiltered' => 0,
		        'data' => []
		    ]);
	    }
	}

	public function generatePdf() {
		$json = $this->request->getJSON(true);
		// echo json_encode(['data'=>$json]); exit;
		$year = '';
		$year = trim($json['year'] ?? '');
		$year = $year === '' ? null : $year;

		$yearId = ''; 
		$yearId = trim($json['year_id'] ?? '');
		$yearId = $yearId === '' ? null : $yearId;

		$weekStart = ''; 
		$weekStart = trim($json['week_start'] ?? '');
		$weekStart = $weekStart === '' ? null : $weekStart;
		
		$weekEnd = ''; 
		$weekEnd = trim($json['week_end'] ?? '');
		$weekEnd = $weekEnd === '' ? null : $weekEnd;

		$weekStartDate = ''; 
		$weekStartDate = trim($json['week_start_date'] ?? '');
		$weekStartDate = $weekStartDate === '' ? null : $weekStartDate;
		
		$weekEndDate = '';
		$weekEndDate = trim($json['week_end_date'] ?? '');
		$weekEndDate = $weekEndDate === '' ? null : $weekEndDate;
		
		$monthStart = '';
		$monthStart = trim($json['month_start'] ?? '');
		$monthStart = $monthStart === '' ? null : $monthStart;
		
		$monthEnd = '';
		$monthEnd = trim($json['month_end'] ?? '');
		$monthEnd = $monthEnd === '' ? null : $monthEnd;
		
		$searchValue = '';
		$searchValue = trim($json['search'] ?? '');
		$searchValue = $searchValue === '' ? null : $searchValue;

		$quarter = '';
		$quarter = trim($json['quarter'] ?? '');
		$quarter = $quarter === '' ? null : $quarter;

		$ytd = '';
		$ytd = trim($json['ytd'] ?? '');
		$ytd = $ytd === '' ? null : $ytd;
		
		$ItemIds = '';
		$ItemIds = trim($json['items'] ?? '');
		$ItemIds = $ItemIds === '' ? null : $ItemIds;
		
		$brandIds = '';
		$brandIds = $json['brands'] ?? '';
		$brandIds = $brandIds === '' ? null : $brandIds;
		
		$brandTypeIds = ''; 
		$brandTypeIds = $json['brands_label'] ?? '';
		$brandTypeIds = $brandTypeIds === '' ? null : $brandTypeIds;
		
		$brandCategoryIds = ''; 
		$brandCategoryIds = $json['brand_categories'] ?? '';
		$brandCategoryIds = $brandCategoryIds === '' ? null : $brandCategoryIds;

		$brandsText = '';
		$brandsText = trim($json['brands_text'] ?? '');
		$brandsText = $brandsText === '' ? null : $brandsText;

		$brandCategoriesText = '';
		$brandCategoriesText = trim($json['brand_categories_text'] ?? '');
		$brandCategoriesText = $brandCategoriesText === '' ? null : $brandCategoriesText;

		$brandsLabelText = '';
		$brandsLabelText = trim($json['brands_label_text'] ?? '');
		$brandsLabelText = $brandsLabelText === '' ? null : $brandsLabelText;
		
		$salesGroup = ''; 
		$salesGroup = trim($json['sales_group'] ?? '');
		$salesGroup = $salesGroup === '' ? null : $salesGroup;
		
		$subSalesGroup = ''; 
		$subSalesGroup = trim($json['sub_sales_group'] ?? '');
		$subSalesGroup = $subSalesGroup === '' ? null : $subSalesGroup;
		
		$sysPar = $this->Global_model->getSysPar();
		$watsonsPaymentGroup = '';
		if($sysPar){
			$watsonsPaymentGroup = $sysPar[0]['watsons_payment_group'];
		}
		
		$orderByColumn = 'rank';
		$orderDirection = 'ASC';
		$limit = 999999;
		$offset = 0;
		
		$type = ''; 
		$type = trim($json['type'] ?? '');
		$type = $type === '' ? null : $type;
		
		$measure = '';
		$measure = trim($json['measure'] ?? '');
		$measure = $measure === '' ? null : $measure;
		
		$source = '';
		$source = trim($json['source'] ?? '');
		$source = $source === '' ? null : $source;

		switch ($source) {
	        case 'scann_data':
				$source =  "SCAN DATA";
			    $data = $this->Dashboard_model->getSellThroughScannDataBySku($year, $monthStart, $monthEnd, $searchValue, $ItemIds, $brandIds, $brandTypeIds, $brandCategoryIds, $salesGroup, $subSalesGroup, $orderByColumn, $orderDirection,  $limit, $offset, $type, $measure);
				
	            break;
	        case 'week_on_week':
				$source =  "WEEK ON WEEK";
			    $data = $this->Dashboard_model->getSellThroughWeekOnWeekBySku($year, $yearId, $weekStart, $weekEnd, $weekStartDate, $weekEndDate, $searchValue, $ItemIds, $brandIds, $brandTypeIds, $brandCategoryIds, $salesGroup, $subSalesGroup, $watsonsPaymentGroup, $orderByColumn, $orderDirection,  $limit, $offset, $type, $measure);
				
	            break;
	        case 'winsight':
				$source =  "WINSIGHT";
				$weekStart = str_pad($weekStart, 2, '0', STR_PAD_LEFT);
			    $weekStart = $year.$weekStart;

			    $weekEnd = str_pad($weekEnd, 2, '0', STR_PAD_LEFT);
			    $weekEnd = $year.$weekEnd;
			    $data = $this->Dashboard_model->getSellThroughWinsightBySku($year, $yearId, $weekStart, $weekEnd, $weekStartDate, $weekEndDate, $searchValue, $ItemIds, $brandIds, $brandTypeIds, $brandCategoryIds, $salesGroup, $subSalesGroup, $watsonsPaymentGroup, $orderByColumn, $orderDirection,  $limit, $offset, $type, $measure);
				
				break;
	        default:
	        	$data = $this->Dashboard_model->getSellThroughScannDataBySku($year, $monthStart, $monthEnd, $searchValue, $ItemIds, $brandIds, $brandTypeIds, $brandCategoryIds, $salesGroup, $subSalesGroup, $orderByColumn, $orderDirection,  $limit, $offset, $type, $measure);
				
	    }
		
		// echo json_encode($data); exit;
		// echo json_encode($json); exit;

		$title = 'Sell_Through_Overall' . date('Ymd_His');
		
		$pdf = new \App\Libraries\TCPDFLib('P','mm','A4', true, 'UTF-8', false, false);
		$pdf->SetCreator('LMI SFA');
		$pdf->SetAuthor('LIFESTRONG MARKETING INC.');
		$pdf->SetTitle('BA Dashboard Report');
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(true);
		$pdf->AddPage();
		
		$logoPath = FCPATH . 'assets/img/lifestrong_white_bg.webp';
		if (file_exists($logoPath)) {
			$pdf->Image($logoPath, 15, 5, 45);
		}
		
		$pdf->SetFont('helvetica', 'B', 15);
		$pdf->Cell(0, 10, 'LIFESTRONG MARKETING INC.', 0, 1, 'C');
		$pdf->SetFont('helvetica', '', 10);
		$pdf->Cell(0, 5, 'Report: Sell Through - Overall', 0, 1, 'C');
		$pdf->Ln(5);

		if ($brandsText === 'Please select...') { $brandsText = ''; }
		if ($brandCategoriesText === 'Please select...') { $brandCategoriesText = ''; }
		if ($brandsLabelText === 'Please select...') { $brandsLabelText = ''; }

		if ($weekStart !== '') { $weekStart = 'Week ' . substr($weekStart, 4, 2); }
		if ($weekEnd !== '') { $weekEnd = 'Week ' . substr($weekEnd, 4, 2); }

		if ($source === 'SCAN DATA') {
			$periodLabelStart = 'Month From';
			$periodLabelEnd   = 'Month To';

			$monthLookup = $this->Global_model->get_valid_records("tbl_month", ['month']);

			$periodStart = $monthLookup[$monthStart-1]['month'];
			$periodEnd   = $monthLookup[$monthEnd-1]['month'];
		} else {
			$periodLabelStart = 'Week From';
			$periodLabelEnd   = 'Week To';

			$periodStart = $weekStart;
			$periodEnd   = $weekEnd;
		}

		$filterData = [
			'Data Source' 				=> $source,
			'Measure'					=> $measure === 'qty' ? 'Quantity' : 'Amount',
			'Year' 						=> $year,
			'Quarter' 					=> $quarter,
			$periodLabelStart           => $periodStart,
			$periodLabelEnd             => $periodEnd,
			'YTD' 						=> $ytd === 'yes' ? 'YES' : 'NO',
			'Brand' 					=> $brandsText,
			'Brand Category' 			=> $brandCategoriesText,
			'Label Type' 				=> $brandsLabelText,
			'Sales Group' 				=> $salesGroup,
			'Sub Sales Group' 			=> $subSalesGroup,
			'Outright / Consignment' 	=> $type == 1 ? 'Outright' : ($type == 2 ? 'Consignment' : 'All'),
		];
		$this->printFilter($pdf, $filterData);
		$pdf->Ln(2);

		$pdf->SetFont('helvetica', 'B', 10);
		$pdf->MultiCell(10, 6, 'Rank', 1, 'C', 0, 0, '', '', true, 0, false, true, 6, 'M', true);
		$pdf->MultiCell(20, 6, 'LMI/RGDI Code', 1, 'L', 0, 0, '', '', true, 0, false, true, 6, 'M', true);
		$pdf->MultiCell(30, 6, 'Customer SKU', 1, 'C', 0, 0, '', '', true, 0, false, true, 6, 'M', true);
		$pdf->MultiCell(60, 6, 'Item Description', 1, 'C', 0, 0, '', '', true, 0, false, true, 6, 'M', true);
		$pdf->MultiCell(15, 6, 'Brand', 1, 'C', 0, 0, '', '', true, 0, false, true, 6, 'M', true);
		$pdf->MultiCell(15, 6, 'Brand Category', 1, 'C', 0, 0, '', '', true, 0, false, true, 6, 'M', true);
		$pdf->MultiCell(15, 6, 'Sell In', 1, 'C', 0, 0, '', '', true, 0, false, true, 6, 'M', true);
		$pdf->MultiCell(15, 6, 'Sell Out', 1, 'C', 0, 0, '', '', true, 0, false, true, 6, 'M', true);
		$pdf->MultiCell(15, 6, 'Sell Out Ratio', 1, 'C', 0, 1, '', '', true, 0, false, true, 6, 'M', true);

		$pdf->SetFont('helvetica', '', 10);
		$allData = $data['data'];
		if ($allData == []) {
			$pdf->SetFont('helvetica', '', 10);
			$pdf->MultiCell(195, 6, "No data available in table", 1, 'C', 0, 1, '', '', true, 0, false, true, 6, 'M', true);
		}
		foreach ($allData as $row) {
			$row = (object) $row;
			$pdf->SetFont('helvetica', '', 10);

			$rank = (isset($row->rank) && !empty($row->rank)) ? $row->rank : '';
			$itmcde = (isset($row->itmcde) && !empty($row->itmcde)) ? $row->itmcde : '';
			$customer_sku = (isset($row->customer_sku) && !empty($row->customer_sku)) ? $row->customer_sku : '';
			$item_description = (isset($row->item_description) && !empty($row->item_description)) ? $row->item_description : '';
			$brand = (isset($row->brand) && !empty($row->brand)) ? $row->brand : '';
			$brand_category = (isset($row->brand_category) && !empty($row->brand_category)) ? $row->brand_category : '';
			$sell_in = (isset($row->sell_in) && !empty($row->sell_in)) ? $row->sell_in : 0;
			$sell_out = (isset($row->sell_out) && !empty($row->sell_out)) ? $row->sell_out : 0;
			$sell_out_ratio = (isset($row->sell_out_ratio) && !empty($row->sell_out_ratio)) ? $row->sell_out_ratio : 0;

			$pdf->MultiCell(10, 6, $rank, 1, 'C', 0, 0, '', '', true, 0, false, true, 6, 'M', true);
			$pdf->MultiCell(20, 6, $itmcde, 1, 'C', 0, 0, '', '', true, 0, false, true, 6, 'M', true);
			$pdf->MultiCell(30, 6, $customer_sku, 1, 'C', 0, 0, '', '', true, 0, false, true, 6, 'M', true);
			$pdf->MultiCell(60, 6, $item_description, 1, 'L', 0, 0, '', '', true, 0, false, true, 6, 'M', true);
			$pdf->MultiCell(15, 6, $brand, 1, 'C', 0, 0, '', '', true, 0, false, true, 6, 'M', true);
			$pdf->MultiCell(15, 6, $brand_category, 1, 'C', 0, 0, '', '', true, 0, false, true, 6, 'M', true);
			$pdf->MultiCell(15, 6, $sell_in, 1, 'C', 0, 0, '', '', true, 0, false, true, 6, 'M', true);
			$pdf->MultiCell(15, 6, $sell_out, 1, 'C', 0, 0, '', '', true, 0, false, true, 6, 'M', true);
			$pdf->MultiCell(15, 6, $sell_out_ratio, 1, 'C', 0, 1, '', '', true, 0, false, true, 6, 'M', true);
		}

		$pdf->SetFont('helvetica', '', 9);
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

		$pdf->Output($title . '.pdf', 'D');
		exit;
	}

	public function generateExcel() {
		$json = $this->request->getJSON(true);
		$weekStart = trim($json['week_start'] ?? '');
		$weekStart = $weekStart === '' ? null : $weekStart;

		$weekEnd = trim($json['week_end'] ?? '');
		$weekEnd = $weekEnd === '' ? null : $weekEnd;

		$year = trim($json['year'] ?? '');
		$year = $year === '' ? null : $year;

		$yearId = trim($json['year_id'] ?? '');
		$yearId = $yearId === '' ? null : $yearId;

		$weekStartDate = trim($json['week_start_date'] ?? '');
		$weekStartDate = $weekStartDate === '' ? null : $weekStartDate;

		$weekEndDate = trim($json['week_end_date'] ?? '');
		$weekEndDate = $weekEndDate === '' ? null : $weekEndDate;

		$searchValue = trim($json['search'] ?? '');
		$searchValue = $searchValue === '' ? null : $searchValue;

		$quarter = '';
		$quarter = trim($json['quarter'] ?? '');
		$quarter = $quarter === '' ? null : $quarter;

		$ytd = '';
		$ytd = trim($json['ytd'] ?? '');
		$ytd = $ytd === '' ? null : $ytd;
		
		$ItemIds = '';
		$ItemIds = trim($json['items'] ?? '');
		$ItemIds = $ItemIds === '' ? null : $ItemIds;
		
		$brandIds = '';
		$brandIds = $json['brands'] ?? '';
		$brandIds = $brandIds === '' ? null : $brandIds;
		
		$brandTypeIds = ''; 
		$brandTypeIds = $json['brands_label'] ?? '';
		$brandTypeIds = $brandTypeIds === '' ? null : $brandTypeIds;
		
		$brandCategoryIds = ''; 
		$brandCategoryIds = $json['brand_categories'] ?? '';
		$brandCategoryIds = $brandCategoryIds === '' ? null : $brandCategoryIds;

		$brandsText = '';
		$brandsText = trim($json['brands_text'] ?? '');
		$brandsText = $brandsText === '' ? null : $brandsText;

		$brandCategoriesText = '';
		$brandCategoriesText = trim($json['brand_categories_text'] ?? '');
		$brandCategoriesText = $brandCategoriesText === '' ? null : $brandCategoriesText;

		$brandsLabelText = '';
		$brandsLabelText = trim($json['brands_label_text'] ?? '');
		$brandsLabelText = $brandsLabelText === '' ? null : $brandsLabelText;

		$salesGroup = trim($json['sales_group'] ?? '');
		$salesGroup = $salesGroup === '' ? null : $salesGroup;
		
		$subSalesGroup = trim($json['sub_sales_group'] ?? '');
		$subSalesGroup = $subSalesGroup === '' ? null : $subSalesGroup;
		
		$source = trim($json['source'] ?? '');
		$source = $source === '' ? null : $source;

		$monthStart = trim($json['month_start'] ?? '');
		$monthStart = $monthStart === '' ? null : $monthStart;

		$monthEnd = trim($json['month_end'] ?? '');
		$monthEnd = $monthEnd === '' ? null : $monthEnd;
		
		$orderByColumn = 'rank';
		$orderDirection = 'ASC';
		$limit = 999999;
		$offset = 0;
		$type = 3;
		$measure = trim($json['measure'] ?? '');
		$measure = $measure === '' ? null : $measure;

		$sysPar = $this->Global_model->getSysPar();
		$watsonsPaymentGroup = '';
		if($sysPar){
			$watsonsPaymentGroup = $sysPar[0]['watsons_payment_group'];
		}

		$data['data'] = null;
		switch ($source) {
	        case 'scann_data':
				$source =  "SCAN DATA";
				$weekStart = str_pad($weekStart, 2, '0', STR_PAD_LEFT);
				$weekStart = $year.$weekStart;

				$weekEnd = str_pad($weekEnd, 2, '0', STR_PAD_LEFT);
				$weekEnd = $year.$weekEnd;

			    $data = $this->Dashboard_model->getSellThroughScannDataBySku(
					$year, $monthStart, $monthEnd, $searchValue, 
					$ItemIds, $brandIds, $brandTypeIds, $brandCategoryIds, 
					$salesGroup, $subSalesGroup, $orderByColumn, $orderDirection, 
					$limit, $offset, $type, $measure
				);
	            break;
	        case 'week_on_week':
				$source =  "WEEK ON WEEK";
			    $data = $this->Dashboard_model->getSellThroughWeekOnWeekBySku(
					$year, $yearId, $weekStart, $weekEnd, $weekStartDate, $weekEndDate, 
					$searchValue, $ItemIds, $brandIds, $brandTypeIds, $brandCategoryIds, 
					$salesGroup, $subSalesGroup, $watsonsPaymentGroup, $orderByColumn, $orderDirection, 
					$limit, $offset, $type, $measure
				);
	            break;
	        case 'winsight':
				$source =  "WINSIGHT";
				$weekStart = str_pad($weekStart, 2, '0', STR_PAD_LEFT);
				$weekStart = $year.$weekStart;

				$weekEnd = str_pad($weekEnd, 2, '0', STR_PAD_LEFT);
				$weekEnd = $year.$weekEnd;

				$data = $this->Dashboard_model->getSellThroughWinsightBySku(
					$year, $yearId, $weekStart, $weekEnd, $weekStartDate, $weekEndDate, 
					$searchValue, $ItemIds, $brandIds, $brandTypeIds, $brandCategoryIds,
					$salesGroup, $subSalesGroup, $watsonsPaymentGroup, $orderByColumn, $orderDirection, 
					$limit, $offset, $type, $measure
				);
				break;
	        default:
				$weekStart = str_pad($weekStart, 2, '0', STR_PAD_LEFT);
				$weekStart = $year.$weekStart;

				$weekEnd = str_pad($weekEnd, 2, '0', STR_PAD_LEFT);
				$weekEnd = $year.$weekEnd;

	        	$data = $this->Dashboard_model->getSellThroughScannDataBySku(
					$year, $monthStart, $monthEnd, $searchValue, 
					$ItemIds, $brandIds, $brandTypeIds, $brandCategoryIds, 
					$salesGroup, $subSalesGroup, $orderByColumn, $orderDirection, 
					$limit, $offset, $type, $measure
				);
	    }

		// echo json_encode($data); 
		// exit;

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'LIFESTRONG MARKETING INC.');
		$sheet->setCellValue('A2', 'Report: Sell Through - Overall');
		$sheet->mergeCells('A1:E1');
		$sheet->mergeCells('A2:E2');
		
		if ($brandsText === 'Please select...') { $brandsText = ''; }
		if ($brandCategoriesText === 'Please select...') { $brandCategoriesText = ''; }
		if ($brandsLabelText === 'Please select...') { $brandsLabelText = ''; }

		if ($weekStart !== '') { $weekStart = 'Week ' . substr($weekStart, 4, 2); }
		if ($weekEnd !== '') { $weekEnd = 'Week ' . substr($weekEnd, 4, 2); }

		$sheet->setCellValueExplicit('A3', "Data Source: $source", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

		if ($source === 'SCAN DATA') {
			$periodLabelStart = 'Month From';
			$periodLabelEnd   = 'Month To';

			$monthLookup = $this->Global_model->get_valid_records("tbl_month", ['month']);

			$periodStart = $monthLookup[$monthStart-1]['month'];
			$periodEnd   = $monthLookup[$monthEnd-1]['month'];
		} else {
			$periodLabelStart = 'Week From';
			$periodLabelEnd   = 'Week To';

			$periodStart = $weekStart;
			$periodEnd   = $weekEnd;
		}

		$filterData = [
			// 'Data Source' 				=> $source,

			'Measure'					=> $measure === 'qty' ? 'Quantity' : 'Amount',
			'Year' 						=> $year,
			'Quarter' 					=> $quarter,
			$periodLabelStart            => $periodStart,
			$periodLabelEnd              => $periodEnd,
			'YTD' 						=> $ytd === 'yes' ? 'YES' : 'NO',

			'Brand' 					=> $brandsText,
			'Brand Category' 			=> $brandCategoriesText,
			'Label Type' 				=> $brandsLabelText,
			'Sales Group' 				=> $salesGroup,
			'Sub Sales Group' 			=> $subSalesGroup,
			'Outright / Consignment' 	=> $type == 1 ? 'Outright' : ($type == 2 ? 'Consignment' : 'All'),
		];

		$this->writeHeader($sheet, $filterData);
		
		$sheet->setCellValueExplicit('A8', "Rank", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
		$sheet->setCellValueExplicit('B8', "LMI/RGDI Code", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
		$sheet->setCellValueExplicit('C8', "Customer SKU", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
		$sheet->setCellValueExplicit('D8', "Item Description", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
		$sheet->setCellValueExplicit('E8', "Brand", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
		$sheet->setCellValueExplicit('F8', "Brand Category", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
		$sheet->setCellValueExplicit('G8', "Sell In", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
		$sheet->setCellValueExplicit('H8', "Sell Out", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
		$sheet->setCellValueExplicit('J8', "Sell Out Ratio", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

		$rowNum = 9;
		
		$allData = $data['data'];
		foreach ($allData as $row) {
			$row = (object) $row;

			$rank = (isset($row->rank) && !empty($row->rank)) ? $row->rank : '';
			$itmcde = (isset($row->itmcde) && !empty($row->itmcde)) ? $row->itmcde : '';
			$customer_sku = (isset($row->customer_sku) && !empty($row->customer_sku)) ? $row->customer_sku : '';
			$item_description = (isset($row->item_description) && !empty($row->item_description)) ? $row->item_description : '';
			$brand = (isset($row->brand) && !empty($row->brand)) ? $row->brand : '';
			$brand_category = (isset($row->brand_category) && !empty($row->brand_category)) ? $row->brand_category : '';
			$sell_in = (isset($row->sell_in) && !empty($row->sell_in)) ? $row->sell_in : 0;
			$sell_out = (isset($row->sell_out) && !empty($row->sell_out)) ? $row->sell_out : 0;
			$sell_out_ratio = (isset($row->sell_out_ratio) && !empty($row->sell_out_ratio)) ? $row->sell_out_ratio : 0;

			$sheet->setCellValueExplicit('A' . $rowNum, $rank, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('B' . $rowNum, $itmcde, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('C' . $rowNum, $customer_sku, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('D' . $rowNum, $item_description, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('E' . $rowNum, $brand, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('F' . $rowNum, $brand_category, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('G' . $rowNum, $sell_in, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('H' . $rowNum, $sell_out, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('J' . $rowNum, $sell_out_ratio, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$rowNum+=1;
		}

		$title = 'SELL_THROUGH_OVERALL' . date('Ymd_His');

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');

		exit;
	}

	private function printFilter($pdf, $filters) {
		$pageWidth  	= $pdf->getPageWidth();
		$pageMargin 	= $pdf->getMargins();
		$usableWidth 	= $pageWidth - $pageMargin['left'] - $pageMargin['right'];

		$perRow   = ceil(count($filters) / 2);
		$colWidth = $usableWidth / $perRow;

		$rows = array_chunk($filters, $perRow, true);

		foreach ($rows as $rowFilters) {
			$currentX = $pdf->GetX();
			$currentY = $pdf->GetY();

			$cellBaseHeight = 5;
			$maxLines       = 1;

			foreach ($rowFilters as $key => $value) {
				$html     = "<b>{$key}:</b> {$value}";
				$plainTxt = strip_tags($html);
				$numLines = $pdf->getNumLines($plainTxt, $colWidth);
				$maxLines = max($maxLines, $numLines);
			}
			$rowHeight = $cellBaseHeight * $maxLines;

			$x = $currentX;
			foreach ($rowFilters as $key => $value) {
				$html = "<b>" . htmlspecialchars($key) . ":</b> " . htmlspecialchars($value);

				$pdf->MultiCell(
					$colWidth,        // width
					$cellBaseHeight,  // nominal line height
					$html,            // HTML text
					0,                // no border
					'L',              // left align
					false,            // no fill
					0,                // ln = stay on same line
					$x,               // x position
					$currentY,        // y position
					true,             // reset height
					0,                // stretch
					true,             // **isHTML = true**  
					true,             // autopadding
					$rowHeight,       // max height
					'T',              // valign = top
					false             // fitcell
				);

				$x += $colWidth;
			}

			$pdf->Ln($rowHeight);
		}
	}

	private function writeHeader($sheet, $filterData, $columnsPerRow = 6, $startRow = 5, $startCol = 'A') {
		$col = $startCol;
		$row = $startRow;
		$counter = 0;

		foreach ($filterData as $key => $value) {
			$sheet->setCellValue($col . $row, $key . ': ' . $value);

			$counter++;
			if ($counter % $columnsPerRow === 0) {
				$row++;
				$col = $startCol;
			} else {
				$col++;
			}
		}
	}
}
