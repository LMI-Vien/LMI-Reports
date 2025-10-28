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
		$data["source"] = "Scan Data";
		$data["source_date"] = '<span id="sourceDate">N / A</span>';
		$data["foot_note"] = '';	

		$data['content'] = "site/sell_through/by_brand_category/by_brand_category";
		$sales_query = "status > 0";
		$data['sales_group'] = $this->Global_model->get_data_list('tbl_pricelist_masterfile', $sales_query, 0, 0, 'id, description','','', '', '');
		$data['sales_group'] = json_decode(json_encode($data['sales_group']), true);
		
		$brand_cat_query = "status > 0"; //classification table
		$data['brand_categories'] = $this->Global_model->get_data_list('tbl_classification', $brand_cat_query, 0, 0, 'id, item_class_description','','', '', '');
		$data['brand_categories'] = json_decode(json_encode($data['brand_categories']), true);

		$brand_sub_cat_query = "status > 0"; //sub classification table
		$data['brand_sub_categories'] = $this->Global_model->get_data_list('tbl_sub_classification', $brand_sub_cat_query, 0, 0, 'id, item_sub_class_code','','', '', '');
		$data['brand_sub_categories'] = json_decode(json_encode($data['brand_sub_categories']), true);

		$dept_query = "status > 0"; //item department table
		$data['item_department'] = $this->Global_model->get_data_list('tbl_item_department', $dept_query, 0, 0, 'id, item_department_code','','', '', '');
		$data['item_department'] = json_decode(json_encode($data['item_department']), true);

		$merh_cat_query = "status > 0"; //merchandise category table 
		$data['merch_categories'] = $this->Global_model->get_data_list('tbl_item_merchandise_category', $merh_cat_query, 0, 0, 'id, item_mech_cat_code','','', '', '');
		$data['merch_categories'] = json_decode(json_encode($data['merch_categories']), true);

		$cat_query = "status > 0"; //label category table 
		$data['categories'] = $this->Global_model->get_data_list('tbl_label_category_list', $cat_query, 0, 0, 'id, description','','', '', '');
		$data['categories'] = json_decode(json_encode($data['categories']), true);


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

		$subBrandCategoryId = $this->request->getPost('sub_brand_category');
		$subBrandCategoryId = $subBrandCategoryId === '' ? null : $subBrandCategoryId;

		$categoryId = $this->request->getPost('category');
		$categoryId = $categoryId === '' ? null : $categoryId;

		$itemDeptId = $this->request->getPost('item_department');
		$itemDeptId = $itemDeptId === '' ? null : $itemDeptId;

		$merchCatId = $this->request->getPost('merch_category');
		$merchCatId = $merchCatId === '' ? null : $merchCatId;

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
			    $data = $this->Dashboard_model->getSellThroughScannDataByCategory($year, $monthStart, $monthEnd, $searchValue, $brandCategoryId ,$subBrandCategoryId, $categoryId, $itemDeptId, $merchCatId, $salesGroup, $subSalesGroup, $orderByColumn, $orderDirection, $limit, $offset, $type, $measure);
				
	            break;
	        case 'week_on_week':
			    $data = $this->Dashboard_model->getSellThroughWeekOnWeekByCategory($year, $yearId, $weekStart, $weekEnd, $weekStartDate, $weekEndDate, $searchValue, $brandCategoryId ,$subBrandCategoryId, $categoryId, $itemDeptId, $merchCatId, $salesGroup, $subSalesGroup, $watsonsPaymentGroup, $orderByColumn, $orderDirection, $limit, $offset, $type, $measure);
				
	            break;
	        case 'winsight':
				$weekStart = str_pad($weekStart, 2, '0', STR_PAD_LEFT);
			    $weekStart = $year.$weekStart;

			    $weekEnd = str_pad($weekEnd, 2, '0', STR_PAD_LEFT);
			    $weekEnd = $year.$weekEnd;
			    $data = $this->Dashboard_model->getSellThroughWinsightByCategory($year, $yearId, $weekStart, $weekEnd, $weekStartDate, $weekEndDate, $searchValue, $brandCategoryId ,$subBrandCategoryId, $categoryId, $itemDeptId, $merchCatId, $salesGroup, $subSalesGroup, $watsonsPaymentGroup, $orderByColumn, $orderDirection, $limit, $offset, $type, $measure);
				
				break;
	        default:
	       		//test data
	        	// $type = 1;
	        	// $measure = 'qty';
	        	// $year = 2025;
	        	// $monthStart = 1;
	        	// $monthEnd = 11;
	        	$data = $this->Dashboard_model->getSellThroughScannDataByCategory($year, $monthStart, $monthEnd, $searchValue, $brandCategoryId ,$subBrandCategoryId, $categoryId, $itemDeptId, $merchCatId, $salesGroup, $subSalesGroup, $orderByColumn, $orderDirection, $limit, $offset, $type, $measure);
				
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
	private function printFilter($pdf, $filters) {
		$pdf->SetFont('helvetica', 'B', 9);
		$source = $filters['Source'] ?? 'None';
		$pdf->MultiCell(0, 8, 'Source: ' . $source, 0, 'C', 0, 1, '', '', true);

		// 2) Grid of remaining filters (two rows auto-spread)
		$pdf->SetFont('helvetica', '', 9);
		$pdf->Ln(2);

		// Exclude Source from grid
		$gridFilters = $filters;
		unset($gridFilters['Source']);

		if (!empty($gridFilters)) {
			$pageWidth  = $pdf->getPageWidth();
			$margins    = $pdf->getMargins();
			$perRow     = ceil(count($gridFilters) / 2); // 2 rows
			$colWidth   = ($pageWidth - $margins['left'] - $margins['right']) / $perRow;
			$lineHeight = 5;

			// chunk into two rows
			$rows = array_chunk($gridFilters, $perRow, true);

			foreach ($rows as $rowFilters) {
				// a) compute required height
				$maxLines = 0;
				foreach ($rowFilters as $key => $value) {
					$text = '<b>' . htmlspecialchars((string)$key) . ':</b> ' . htmlspecialchars(is_array($value) ? implode(', ', $value) : (string)$value);
					$num  = $pdf->getNumLines($text, $colWidth);
					$maxLines = max($maxLines, $num);
				}

				// b) render the row
				foreach ($rowFilters as $key => $value) {
					$text = '<b>' . htmlspecialchars((string)$key) . ':</b> ' . htmlspecialchars(is_array($value) ? implode(', ', $value) : (string)$value);
					$pdf->MultiCell(
						$colWidth, $lineHeight, $text,
						0, 'L', 0, 0, '', '', true, 0, true
					);
				}

				// c) move down by the computed height
				$pdf->Ln($maxLines * $lineHeight);
			}

			// tighten spacing slightly
			$pdf->SetY($pdf->GetY() - 3);
		}

		// 3) Footer: Generated Date on the very left
		$pdf->SetFont('helvetica', '', 9);
		$generatedAt = date('M d, Y, h:i:s A');
		$pdf->writeHTMLCell(
			0, 6, '', '',
			'<b>Generated Date:</b> ' . htmlspecialchars($generatedAt),
			0, 1, false, true, 'L', true
		);

		// Divider line
		$pdf->Ln(2);
		$pdf->Cell(0, 0, '', 'T');
		$pdf->Ln(4);
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
		$json = $this->request->getJSON(true);

		$source              = ($json['source']              ?? null) ?: null;

		$brandCategoryId     = ($json['brand_category']      ?? null) ?: null;
		$brandCategoryText   = ($json['brand_category_text'] ?? null) ?: null;

		$subBrandCategoryId    = ($json['sub_brand_category']      ?? null) ?: null;
		$subBrandCategoryText  = ($json['sub_brand_category_text'] ?? null) ?: null;

		$categoryId        = ($json['category']       ?? null) ?: null;
		$categoryText      = ($json['category_text']  ?? null) ?: null;

		$itemDeptId        = ($json['item_department']      ?? null) ?: null;
		$itemDeptText      = ($json['item_department_text'] ?? null) ?: null;

		$merchCatId        = ($json['merch_category']      ?? null) ?: null;
		$merchCatText      = ($json['merch_category_text'] ?? null) ?: null;

		$year              = trim($json['year']      ?? '') ?: null;
		$yearId            = trim($json['year_id']   ?? '') ?: null;

		$monthStart        = trim($json['month_start'] ?? '') ?: null;
		$monthEnd          = trim($json['month_end']   ?? '') ?: null;

		$weekStart         = trim($json['week_start'] ?? '') ?: null;
		$weekEnd           = trim($json['week_end']   ?? '') ?: null;

		$weekStartDate     = trim($json['week_start_date'] ?? '') ?: null;
		$weekEndDate       = trim($json['week_end_date']   ?? '') ?: null;

		$salesGroup        = trim($json['sales_group'] ?? '') ?: null;
		$salesGroupText    = ($json['sales_group_text'] ?? null) ?: null;

		$subSalesGroup     = trim($json['sub_sales_grouptype'] ?? '') ?: null;

		$type              = ($json['type']    ?? null) ?: null;
		$measure           = ($json['measure'] ?? null) ?: null;

		$searchValue		 =($json['search_value'] 		 ?? null) ?: null;

		$orderByColumn  = $json['order_by']  ?? null; 
    	$orderDirection = isset($json['order_dir']) ? strtoupper($json['order_dir']) : null;

		// Sys params
		$sysPar = $this->Global_model->getSysPar();
		$watsonsPaymentGroup = $sysPar[0]['watsons_payment_group'] ?? '';

		// Search
		if (!empty($json['search'])) {
			if (is_array($json['search']) && array_key_exists('value', $json['search'])) {
				$searchValue = trim((string)$json['search']['value']) ?: null;
			} elseif (is_string($json['search'])) {
				$searchValue = trim($json['search']) ?: null;
			}
		}

		// Pagination override for export
		$limit  = 999999;
		$offset = 0;

		// Special handling for winsight weeks
		if ($source === 'winsight') {
			if ($weekStart !== null && $year !== null) {
				$weekStart = str_pad($weekStart, 2, '0', STR_PAD_LEFT);
				$weekStart = $year.$weekStart;
			}
			if ($weekEnd !== null && $year !== null) {
				$weekEnd = str_pad($weekEnd, 2, '0', STR_PAD_LEFT);
				$weekEnd = $year.$weekEnd;
			}
		}

		// Fetch data based on source
		switch ($source) {
			case 'scann_data':
				$data = $this->Dashboard_model->getSellThroughScannDataByCategory(
					$year, $monthStart, $monthEnd,
					$searchValue,
					$brandCategoryId, $subBrandCategoryId,
					$categoryId, $itemDeptId, $merchCatId,
					$salesGroup, $subSalesGroup,
					$orderByColumn, $orderDirection,
					$limit, $offset,
					$type, $measure
				);
				break;

			case 'week_on_week':
				$data = $this->Dashboard_model->getSellThroughWeekOnWeekByCategory(
					$year, $yearId,
					$weekStart, $weekEnd,
					$weekStartDate, $weekEndDate,
					$searchValue,
					$brandCategoryId, $subBrandCategoryId,
					$categoryId, $itemDeptId, $merchCatId,
					$salesGroup, $subSalesGroup,
					$watsonsPaymentGroup,
					$orderByColumn, $orderDirection,
					$limit, $offset,
					$type, $measure
				);
				break;

			case 'winsight':
				// after transforming weekStart/weekEnd above
				$data = $this->Dashboard_model->getSellThroughWinsightByCategory(
					$year, $yearId,
					$weekStart, $weekEnd,
					$weekStartDate, $weekEndDate,
					$searchValue,
					$brandCategoryId, $subBrandCategoryId,
					$categoryId, $itemDeptId, $merchCatId,
					$salesGroup, $subSalesGroup,
					$watsonsPaymentGroup,
					$orderByColumn, $orderDirection,
					$limit, $offset,
					$type, $measure
				);
				break;

			default:
				$data = $this->Dashboard_model->getSellThroughScannDataByCategory(
					$year, $monthStart, $monthEnd,
					$searchValue,
					$brandCategoryId, $subBrandCategoryId,
					$categoryId, $itemDeptId, $merchCatId,
					$salesGroup, $subSalesGroup,
					$orderByColumn, $orderDirection,
					$limit, $offset,
					$type, $measure
				);
				break;
		}

		$rows = $data['data'] ?? [];
		
		$title = 'Sell-Through by Brand Category';
		if ($source === 'scann_data')   $title .= ' (Scan Data)';
		if ($source === 'week_on_week') $title .= ' (Week-on-Week)';
		if ($source === 'winsight')     $title .= ' (Winsight)';

		$filterData = [
			'Source'                 => $source ?? 'None',
			'Year'                   => $year ?? 'None',
			'Month Range'            => ($monthStart && $monthEnd) ? ($monthStart.' - '.$monthEnd) : 'None',
			'Week Range'             => ($weekStart && $weekEnd) ? ($weekStart.' - '.$weekEnd) : 'None',
			'Week Dates'             => ($weekStartDate && $weekEndDate) ? ($weekStartDate.' to '.$weekEndDate) : 'None',

			// groups
			'Sales Group'            => $salesGroupText ?: ($salesGroup ?: 'None'),
			'Sub Sales Group'        => $subSalesGroup   ?: 'None',

			// category breakdown
			'Label Type Category'                    => $brandCategoryText     ?: ($brandCategoryId     ?: 'None'),
			'Category 1 (Item Classification)'       => $categoryText          ?: ($categoryId          ?: 'None'),
			'Category 2 (Item Sub Classification)'   => $subBrandCategoryText  ?: ($subBrandCategoryId  ?: 'None'),
			'Category 3 (Item Department)'           => $itemDeptText          ?: ($itemDeptId          ?: 'None'),
			'Category 4 (Item Merchandise Category)' => $merchCatText          ?: ($merchCatId          ?: 'None'),

			// measure context
			'Type'                   => $type ?? 'None',
			'Measure'                => $measure ?? 'None',
		];

		$pdf = new \App\Libraries\TCPDFLib('L','mm','A4', true, 'UTF-8', false, false);
		$pdf->SetCreator('LMI SFA');
		$pdf->SetAuthor('LIFESTRONG MARKETING INC.');
		$pdf->SetTitle($title);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(true);
		$pdf->AddPage();

		$this->printHeader($pdf, $title);
		$this->printFilter($pdf, $filterData);

		$pageWidth  = $pdf->getPageWidth();
		$margins    = $pdf->getMargins();
		$colWidth   = ($pageWidth - $margins['left'] - $margins['right']) / 9;

		$headers = [
			"Rank",
			"Label Type Category",
			"Category 1 (Item Classification)",
			"Category 2 (Item Sub Classification)",
			"Category 3 (Item Department)",
			"Category 4 (Item Merchandise Category)",
			"Sell In (Qty)",
			"Sell Out (Qty)",
			"Sell Out Ratio"
		];

		$pdf->SetFont('helvetica','B',9);
		$headerHeight = 14;
		foreach ($headers as $i => $h) {
			$isLast = ($i === count($headers) - 1);
			$pdf->MultiCell(
				$colWidth,        // width
				$headerHeight,    // height for the header cell
				$h,               // text
				1,                // border
				'C',              // align
				0,                // fill (0 = no background, avoids the black bar)
				$isLast ? 1 : 0,  // line break after last header cell
				'',               // x (auto)
				'',               // y (auto)
				true,             // reset height
				0,                // stretch
				false,            // isHTML
				true,             // auto padding
				$headerHeight,    // maxh (allows wrapping within header cell)
				'M',              // vertical align
				false             // fitcell (no shrink; wrap instead)
			);
		}
		$pdf->SetFont('helvetica','',9);

		$lineH = 4;  // mm per text line
		$fixedRowHeight = 12;

		foreach ($rows as $row) {
			$cells = [
				$row->rank,
				$row->label_category,
				$row->brand_category,
				$row->sub_classification,
				$row->item_department,
				$row->item_merchandise,
				$this->formatComma($row->sell_in),
				$this->formatComma($row->sell_out),
				$row->sell_out_ratio
			];

			$numLinesArray = array_map(function($text) use ($pdf, $colWidth) {
				return $pdf->getNumLines($text, $colWidth);
			}, $cells);

			$maxLines = max($numLinesArray);
			$rowHeight = $maxLines * $lineH;

			$pageHeight = $pdf->getPageHeight();
			$bottomMargin = $pdf->getBreakMargin();
			$currentY = $pdf->GetY();

			if ($currentY + $rowHeight > ($pageHeight - $bottomMargin)) {
				$pdf->AddPage();
			}

			foreach ($cells as $colIndex => $text) {
				$isLastCol = ($colIndex === count($cells) - 1);
				$pdf->MultiCell(
					$colWidth,          // width of the cell
					$fixedRowHeight,    // *fixed* height
					$text,              // content
					1,                  // border
					'C',                // horizontal align (C=center)
					0,                  // fill?
					$isLastCol ? 1 : 0, // ln: move to next line only at end of row
					'',                 // x (auto)
					'',                 // y (auto)
					true,               // reset height (reseth)
					0,                  // stretch mode (0 = disabled)
					false,              // isHTML
					true,               // auto padding
					$fixedRowHeight,    // **maxh** = same as height
					'M',                // **valign** middle
					true                // **fitcell**: shrink text to fit
				);
			}
		}

		$pdf->Output($title . '.pdf', 'D');
		exit;
	}

	public function generateExcel() {
		$json = $this->request->getJSON(true);

		$source              = ($json['source']              ?? null) ?: null;

		$brandCategoryId     = ($json['brand_category']      ?? null) ?: null;
		$brandCategoryText   = ($json['brand_category_text'] ?? null) ?: null;

		$subBrandCategoryId    = ($json['sub_brand_category']      ?? null) ?: null;
		$subBrandCategoryText  = ($json['sub_brand_category_text'] ?? null) ?: null;

		$categoryId          = ($json['category']            ?? null) ?: null;
		$categoryText        = ($json['category_text']       ?? null) ?: null;

		$itemDeptId          = ($json['item_department']     ?? null) ?: null;
		$itemDeptText        = ($json['item_department_text']?? null) ?: null;

		$merchCatId          = ($json['merch_category']      ?? null) ?: null;
		$merchCatText        = ($json['merch_category_text'] ?? null) ?: null;

		$year                = trim($json['year']            ?? '') ?: null;
		$yearId              = trim($json['year_id']         ?? '') ?: null;

		$monthStart          = trim($json['month_start']     ?? '') ?: null;
		$monthEnd            = trim($json['month_end']       ?? '') ?: null;

		$weekStart           = trim($json['week_start']      ?? '') ?: null;
		$weekEnd             = trim($json['week_end']        ?? '') ?: null;

		$weekStartDate       = trim($json['week_start_date'] ?? '') ?: null;
		$weekEndDate         = trim($json['week_end_date']   ?? '') ?: null;

		$salesGroup          = trim($json['sales_group']     ?? '') ?: null;
		$salesGroupText      = ($json['sales_group_text']    ?? null) ?: null;

		$subSalesGroup       = trim($json['sub_sales_grouptype'] ?? '') ?: null;

		$type                = ($json['type']                ?? null) ?: null;
		$measure             = ($json['measure']             ?? null) ?: null;

		$searchValue		 =($json['search_value'] 		 ?? null) ?: null;

		$orderByColumn  = $json['order_by']  ?? null;             
		$orderDirection = isset($json['order_dir']) ? strtoupper($json['order_dir']) : null;

		// Sys params
		$sysPar = $this->Global_model->getSysPar();
		$watsonsPaymentGroup = $sysPar[0]['watsons_payment_group'] ?? '';

		// $searchValue = null;
		if (!empty($json['search'])) {
			if (is_array($json['search']) && array_key_exists('value', $json['search'])) {
				$searchValue = trim((string)$json['search']['value']) ?: null;
			} elseif (is_string($json['search'])) {
				$searchValue = trim($json['search']) ?: null;
			}
		}

		$limit  = 999999;
		$offset = 0;

		if ($source === 'winsight') {
			if ($weekStart !== null && $year !== null) {
				$weekStart = str_pad($weekStart, 2, '0', STR_PAD_LEFT);
				$weekStart = $year.$weekStart;
			}
			if ($weekEnd !== null && $year !== null) {
				$weekEnd = str_pad($weekEnd, 2, '0', STR_PAD_LEFT);
				$weekEnd = $year.$weekEnd;
			}
		}

		switch ($source) {
			case 'scann_data':
				$data = $this->Dashboard_model->getSellThroughScannDataByCategory(
					$year, $monthStart, $monthEnd,
					$searchValue,
					$brandCategoryId, $subBrandCategoryId,
					$categoryId, $itemDeptId, $merchCatId,
					$salesGroup, $subSalesGroup,
					$orderByColumn, $orderDirection,
					$limit, $offset,
					$type, $measure
				);
				break;

			case 'week_on_week':
				$data = $this->Dashboard_model->getSellThroughWeekOnWeekByCategory(
					$year, $yearId,
					$weekStart, $weekEnd,
					$weekStartDate, $weekEndDate,
					$searchValue,
					$brandCategoryId, $subBrandCategoryId,
					$categoryId, $itemDeptId, $merchCatId,
					$salesGroup, $subSalesGroup,
					$watsonsPaymentGroup,
					$orderByColumn, $orderDirection,
					$limit, $offset,
					$type, $measure
				);
				break;

			case 'winsight':
				$data = $this->Dashboard_model->getSellThroughWinsightByCategory(
					$year, $yearId,
					$weekStart, $weekEnd,
					$weekStartDate, $weekEndDate,
					$searchValue,
					$brandCategoryId, $subBrandCategoryId,
					$categoryId, $itemDeptId, $merchCatId,
					$salesGroup, $subSalesGroup,
					$watsonsPaymentGroup,
					$orderByColumn, $orderDirection,
					$limit, $offset,
					$type, $measure
				);
				break;

			default:
				$data = $this->Dashboard_model->getSellThroughScannDataByCategory(
					$year, $monthStart, $monthEnd,
					$searchValue,
					$brandCategoryId, $subBrandCategoryId,
					$categoryId, $itemDeptId, $merchCatId,
					$salesGroup, $subSalesGroup,
					$orderByColumn, $orderDirection,
					$limit, $offset,
					$type, $measure
				);
				break;
		}

		$rows = $data['data'] ?? [];

		$title = 'Sell-Through by Brand Category';

		$spreadsheet = new Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'LIFESTRONG MARKETING INC.');
		$sheet->setCellValue('A2', 'Report: Sell-Through by Brand');
		$sheet->setCellValue('A4', 'Source: '        . ($source ?: 'NONE'));
		$sheet->mergeCells('A1:C1');
		$sheet->mergeCells('A2:C2');

		$sheet->setCellValue('A6', 'Year: ' . ($year ?: 'NONE'));
		$sheet->setCellValue('A7', 'Month Range: ' . (($monthStart && $monthEnd) ? ($monthStart.' - '.$monthEnd) : 'None'));

		$sheet->setCellValue('B6', 'Week Range: ' . (($weekStart && $weekEnd) ? ($weekStart.' - '.$weekEnd) : 'None'));
		$sheet->setCellValue('B7', 'Week Dates: ' . (($weekStartDate && $weekEndDate) ? ($weekStartDate.' to '.$weekEndDate) : 'None'));

		$sheet->setCellValue('C6', 'Sales Group: ' . ($salesGroupText ?: ($salesGroup ?: 'NONE')));
		$sheet->setCellValue('C7', 'Sub Sales Group: ' . ($subSalesGroup ?: 'NONE'));

		$sheet->setCellValue('D6', 'Measure: ' . ($measure ?: 'NONE'));
		$sheet->setCellValue('D7', 'Label Type Category: ' . ($brandCategoryText ?: ($brandCategoryId ?: 'NONE')));

		$sheet->setCellValue('E6', 'Category 1: ' . ($categoryText ?: ($categoryId ?: 'NONE')));
		$sheet->setCellValue('E7', 'Category 2: ' . ($subBrandCategoryText ?: ($subBrandCategoryId ?: 'NONE')));

		$sheet->setCellValue('F6', 'Category 3: ' . ($itemDeptText ?: ($itemDeptId ?: 'NONE')));
		$sheet->setCellValue('F7', 'Category 4: ' . ($merchCatText ?: ($merchCatId ?: 'NONE')));

		$sheet->setCellValue('G7', 'Date Generated: ' . date('M d, Y, h:i:s A'));
		
		$headers = [
			"Rank",
			"Label Type Category",
			"Category 1 (Item Classification)",
			"Category 2 (Item Sub Classification)",
			"Category 3 (Item Department)",
			"Category 4 (Item Merchandise Category)",
			"Sell In (Qty)",
			"Sell Out (Qty)",
			"Sell Out Ratio"
		];
		$sheet->fromArray($headers, null, 'A9');
		$sheet->getStyle('A9:I9')->getFont()->setBold(true);

		$rowNum = 10;

		foreach ($rows as $row) {
			$sheet->setCellValue('A'.$rowNum,$row->rank);
			$sheet->setCellValue('B'.$rowNum,$row->label_category);
			$sheet->setCellValue('C'.$rowNum,$row->brand_category);
			$sheet->setCellValue('D'.$rowNum,$row->sub_classification);
			$sheet->setCellValue('E'.$rowNum,$row->item_department);
			$sheet->setCellValue('F'.$rowNum,$row->item_merchandise);
			$sheet->setCellValue('G'.$rowNum,$row->sell_in);
			$sheet->setCellValue('H'.$rowNum,$row->sell_out);
			$sheet->setCellValue('I'.$rowNum,$row->sell_out_ratio);

			$rowNum++;
		}

		foreach (range('A','N') as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
		}

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

	private function formatTwoDecimals($value): string {
		if (is_null($value) || !is_numeric($value)) {
			$value = 0;
		}
		return number_format((float)$value, 2, '.', ',');
	}

	private function formatComma($value): string {
		if (!is_numeric($value)) {
			return (string)$value;
		}
		return number_format((float)$value, 0, '.', ',');
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
