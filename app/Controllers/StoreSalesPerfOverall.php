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
		$data["breadcrumb"] = array('Store' => base_url('store/sales-overall-performance'),'Overall Stores Sales Performance' => '');
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

	    //$this->Dashboard_model->refreshPreAggregatedDataScanData();	
	    $data = $this->Dashboard_model->getStorePerformance($monthId, $monthEndId, $yearId, $limit, $offset, $areaId, $ascId, $storeCode, $baId, $baTypeId, $brandCategoriesIds, $brandIds, $orderByColumn, $orderDirection);

	    return $this->response->setJSON([
	        'draw' => intval($this->request->getVar('draw')),
	        'recordsTotal' => $data['total_records'],
	        'recordsFiltered' => $data['total_records'],
	        'data' => $data['data']
	    ]);
	}

	public function generatePdf()
	{	
		//to be added
		$brandAmbassador = $this->request->getGet('brandAmbassador');
		$storeBranch = $this->request->getGet('storeBranch');
		$brands = $this->request->getGet('brands');
		$area = $this->request->getGet('area');
		$asc = $this->request->getGet('asc');
		$year = $this->request->getGet('year');
		$monthStart = $this->request->getGet('monthStart');
		$monthEnd = $this->request->getGet('monthEnd');
		$baType = $this->request->getGet('baType');
		$brandCat = $this->request->getGet('brandCat');

		$order = $this->request->getVar('order')[0] ?? [];
		$orderColumnIndex = isset($order['column']) 
			? (int) $order['column'] 
			: 0;
		$orderDirection   = isset($order['dir']) && in_array(strtolower($order['dir']), ['asc','desc'])
			? strtolower($order['dir'])
			: 'asc';

		// helper closure to turn empty values into “None”
		$dv = function($value, $default = 'None') {
			if (is_array($value)) {
				return empty($value) ? $default : implode(', ', $value);
			}
			$value = trim((string)$value);
			return $value === '' ? $default : $value;
		};

		$filterData = [
			'Area'             => $dv($area),
			'ASC'              => $dv($asc),
			'BA Type'          => $dv($baType),
			'Brand Ambassador' => $dv($brandAmbassador),
			'Store Name'       => $dv($storeBranch),
			'Brand Label Type' => $dv($brandCat),
			'Brand Handle'	   => $dv($brands),
			'Year'             => $dv($year),
			'Month Range'      => ($monthStart && $monthEnd) ? sprintf('%02d – %02d', $monthStart, $monthEnd) : 'None',
		];

		$title = "Store Sales Performance Overall";
		$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator('LMI SFA');
		$pdf->SetAuthor('LIFESTRONG MARKETING INC.');
		$pdf->SetTitle($title);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();

		$this->printHeader($pdf, $title);
		$this->printFilter($pdf, $filterData);

		$pdf->SetFont('helvetica', '', 9);

		$result = $this->Dashboard_model->getStorePerformance($monthStart, $monthEnd, $year, 9999, 0, $area, $asc, $storeBranch, $brandAmbassador, null, [], [], $orderColumnIndex, $orderDirection);
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
		foreach ($rows as $row) {
			$numNameLines = $pdf->getNumLines($row->store_name, $colWidth);
			$numLines = max(1, $numNameLines);
			$rowH = $numLines * $lineH;
			
			$pdf->Cell($colWidth, $rowH, $row->rank,             1, 0, 'C');
			// $pdf->Cell($colWidth, 8, $row->store_name,       1, 0, 'C');
			$pdf->MultiCell(
				$colWidth,   
				$lineH,       
				$row->store_name,
				1,            // border
				'C',          // align center
				0,            // no fill
				0,            // stay to the right after (we'll end the row on the last cell)
				'', '', true  // reset height
			);
			$pdf->Cell($colWidth, $rowH, $row->ly_scanned_data,  1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $row->ty_scanned_data,  1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $row->growth,           1, 0, 'C');
			$pdf->Cell($colWidth, $rowH, $row->sob,              1, 1, 'C');
		}

		$pdf->Output($title . '.pdf', 'D');
		exit;
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


	public function generateExcel()
	{
		//to be added
		$brandAmbassador = $this->request->getGet('brandAmbassador');
		$storeBranch     = $this->request->getGet('storeBranch');
		$brands          = $this->request->getGet('brands');
		$area            = $this->request->getGet('area');
		$asc             = $this->request->getGet('asc');
		$year            = $this->request->getGet('year');
		$monthStart      = $this->request->getGet('monthStart');
		$monthEnd        = $this->request->getGet('monthEnd');
		$baType          = $this->request->getGet('baType');
		$brandCat        = $this->request->getGet('brandCat');
		$limit           = 99999;
		$offset          = 0;

		$order = $this->request->getVar('order')[0] ?? [];
		$orderColumnIndex = isset($order['column']) 
			? (int) $order['column'] 
			: 0;
		$orderDirection   = isset($order['dir']) && in_array(strtolower($order['dir']), ['asc','desc'])
			? strtolower($order['dir'])
			: 'asc';

		$title = "Store Sales Performance Overall";
		$result = $this->Dashboard_model
					->getStorePerformance($monthStart, $monthEnd, $year, $limit, $offset, $area, $asc, $storeBranch, $brandAmbassador, null, [], [], $orderColumnIndex, $orderDirection);
		$rows   = $result['data'];

		$spreadsheet = new Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'LIFESTRONG MARKETING INC.');
		$sheet->setCellValue('A2', 'Report: Store Sales Performance Overall');
		$sheet->mergeCells('A1:E1');
		$sheet->mergeCells('A2:E2');

		$sheet->setCellValue('A4', 'Store: '  . ($storeBranch ?: 'NONE'));
		$sheet->setCellValue('B4', 'Area: '   . ($area       ?: 'NONE'));
		$sheet->setCellValue('C4', 'Sort By: '. ($asc        ?: 'NONE'));
		$sheet->setCellValue('D4', 'BA Type: '. ($baType     ?: 'NONE'));
		$sheet->setCellValue('E4', 'Brand: ' . ($brands     ?: 'NONE'));
		$sheet->setCellValue('F4', 'Brand Ambassador: ' . ($brandAmbassador ?: 'NONE'));
		$sheet->setCellValue('A5', 'Brand Category: ' . ($brandCat ?: 'NONE'));
		$sheet->setCellValue('B5', 'ASC: ' . ($asc ?: 'NONE'));
		$sheet->setCellValue('C5', 'BA: ' . ($baType ?: 'NONE'));

		$sheet->setCellValue('D5', 'Month Start: ' . ($monthStart ?: 'NONE'));
		$sheet->setCellValue('E5', 'Month End: '   . ($monthEnd   ?: 'NONE'));
		$sheet->setCellValue('F5', 'Year: '        . ($year       ?: 'NONE'));
		$sheet->setCellValue('A6', 'Date Generated: ' . date('M d, Y, h:i:s A'));

		$headers = [
			"Rank",
			"Store Code/Store Name",
			"LY Sell Out",
			"TY Sell Out",
			"% Growth",
			"Share of Business"
		];
		$sheet->fromArray($headers, null, 'A8');
		$sheet->getStyle('A8:F8')->getFont()->setBold(true);


		$rowNum = 9;
		foreach ($rows as $row) {
			$sheet->setCellValue('A'.$rowNum,$row->rank);
			$sheet->setCellValue('B'.$rowNum,$row->store_name);
			$sheet->setCellValue('C'.$rowNum, $row->ly_scanned_data);
			$sheet->setCellValue('D'.$rowNum, $row->ty_scanned_data);
			$sheet->setCellValue('E'.$rowNum, $row->growth);
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
}
