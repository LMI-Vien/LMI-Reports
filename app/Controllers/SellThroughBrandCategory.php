<?php

namespace App\Controllers;

use Config\Database;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SellThroughBrandCategory extends BaseController
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

	public function byBrandCategory()
	{
		$uri = current_url(true);
		$data['uri'] = $uri;

		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);
		$data['title'] = "Sell Through By Brand Category";
		$data['PageName'] = 'Sell Through By Brand Category';
		$data['PageUrl'] = 'Sell Through By Brand Category';
		$data["breadcrumb"] = array('Sell Through' => base_url('sell-through/by-brand-category'),'Sell Through By Brand Category' => '');
		$data["source"] = "Actual Sales Report, Scan Data, and Target Sales";
		$data["source_date"] = '';	
		$data["foot_note"] = '';	

		$data['content'] = "site/sell_through/by_brand_category/by_brand_category";
		$sales_query = "status > 0";
		$data['sales_group'] = $this->Global_model->get_data_list('tbl_pricelist_masterfile', $sales_query, 0, 0, 'id, description','','', '', '');
		$data['sales_group'] = json_decode(json_encode($data['sales_group']), true);
		$brand_cat_query = "status > 0";
		$data['brand_categories'] = $this->Global_model->get_data_list('tbl_classification', $brand_cat_query, 0, 0, 'id, item_class_description','','', '', '');
		$data['brand_categories'] = json_decode(json_encode($data['brand_categories']), true);
		$data['months'] = $this->Global_model->getMonths();
		$data['year'] = $this->Global_model->getYears();
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

	public function getByBrandCategory()
	{
		$source = $this->request->getPost('source');
		$source = $source === '' ? null : $source;

		$brandCategoryId = $this->request->getPost('brand_category');
		$brandCategoryId = $brandCategoryId === '' ? null : $brandCategoryId;

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

		$type = $this->request->getPost('type');
		$type = $type === '' ? null : $type;

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
			    $data = $this->Dashboard_model->getSellThroughScannDataByCategory($year, $monthStart, $monthEnd, $searchValue, $brandCategoryId, $salesGroup, $subSalesGroup, $orderByColumn, $orderDirection, $limit, $offset, $type, $measure);
				
	            break;
	        case 'week_on_week':
			    $data = $this->Dashboard_model->getSellThroughWeekOnWeekByCategory($year, $yearId, $weekStart, $weekEnd, $weekStartDate, $weekEndDate, $searchValue, $brandCategoryId, $salesGroup, $subSalesGroup, $orderByColumn, $orderDirection, $limit, $offset, $type, $measure);
				
	            break;
	        case 'winsight':
				$weekStart = str_pad($weekStart, 2, '0', STR_PAD_LEFT);
			    $weekStart = $year.$weekStart;

			    $weekEnd = str_pad($weekEnd, 2, '0', STR_PAD_LEFT);
			    $weekEnd = $year.$weekEnd;
			    $data = $this->Dashboard_model->getSellThroughWinsightByCategory($year, $yearId, $weekStart, $weekEnd, $weekStartDate, $weekEndDate, $searchValue, $brandCategoryId, $salesGroup, $subSalesGroup, $orderByColumn, $orderDirection, $limit, $offset, $type, $measure);
				
				break;
	        default:
	       		//test data
	        	// $type = 1;
	        	// $measure = 'qty';
	        	// $year = 2025;
	        	// $monthStart = 1;
	        	// $monthEnd = 11;
	        	$data = $this->Dashboard_model->getSellThroughScannDataByCategory($year, $monthStart, $monthEnd, $searchValue, $brandCategoryId, $salesGroup, $subSalesGroup, $orderByColumn, $orderDirection, $limit, $offset, $type, $measure);
				
	    }

	    if($data){
	    	return $this->response->setJSON([
		        'draw' => intval($this->request->getVar('draw')),
		        'recordsTotal' => $data['total_records'],
		        'recordsFiltered' => $data['total_records'],
		        'data' => $data['data']
		    ]);
	    }else{
	    	return $this->response->setJSON([
		        'draw' => intval($this->request->getVar('draw')),
		        'recordsTotal' => 0,
		        'recordsFiltered' => 0,
		        'data' => []
		    ]);
	    }

	}

	// ================================= Display filters for pdf export ================================
	private function printFilter($pdf, $filters, $itemBrandMap = '', $latestYear = null) {
	}

	// ================================= Header for pdf export =================================
	private function printHeader($pdf, $title) {
		$logoPath = FCPATH . 'assets/img/lifestrong_white_bg.webp';
		if (file_exists($logoPath)) {
			$pdf->Image($logoPath, 15, 5, 50);
		}
		
		$pdf->SetFont('helvetica', 'B', 15);
		$pdf->Cell(0, 10, 'LIFESTRONG MARKETING INC.', 0, 1, 'C');
		$pdf->SetFont('helvetica', '', 10);
		$pdf->Cell(0, 5, 'Report: ' . $title, 0, 1, 'C');
		$pdf->Ln(5);
	}

	public function generatePdf() {	
		exit;
	}

	public function generateExcel() {
		exit;
	}

	private function formatTwoDecimals($value): string {
		if (is_null($value) || !is_numeric($value)) {
			$value = 0;
		}
		return number_format((float)$value, 2, '.', ',');
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

    public function getSubSalesGroup(){
    	$pricelist_id = $this->request->getPost('sales_group');
    	//$pricelist_id = 1;
    	if($pricelist_id){
			$query = "c.status > 0 AND c.pricelist_id = ".$pricelist_id;
			$select = "c.code, c.description";

	        $join = [
	        	[
		            'table' => 'tbl_cus_sellout_indicator si',
		            'query' => 'c.code = si.cus_code',
		            'type'  => 'INNER'
	        	]
	    	];

			$data = $this->Global_model->get_data_list('tbl_customer_list c', $query, 99999, 0, $select,'','', $join, '');
			echo json_encode($data);
	    }
    }
	
}
