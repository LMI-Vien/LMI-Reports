<?php

namespace App\Controllers;

use Config\Database;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PromoAnalysis extends BaseController
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

	public function promoTable()
	{	
		$uri = current_url(true);
		$data['uri'] = $uri;

		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);
		$data['title'] = "Promo Analysis";
		$data['PageName'] = 'Promo Analysis';
		$data['PageUrl'] = 'Promo Analysis';
		$data["breadcrumb"] = array('Promo Analysis' => base_url('promo-analysis/get-promo-table'),'Promo Analysis' => '');
		$data["source"] = "VMI / Scan Data";
		$data["source_date"] = '<span id="sourceDate">N / A</span>';
		$data["foot_note"] = '';		

		$data['content'] = "site/promo_analysis/promo_table/promo_table";
		$data['brands'] = $this->Global_model->getBrandData("ASC", 4000, 0);
		$data['brandLabel'] = $this->Global_model->getBrandLabelData(0);
		$data['months'] = $this->Global_model->getMonths();
		$data['year'] = $this->Global_model->getYears();

		$data['sku_item'] = $this->Global_model->getDistinctVmiDataClickhouse('sku', 20);
		$data['variants'] = $this->Global_model->getDistinctVmiDataClickhouse('variant', 20);
		$data['stores']   = $this->Global_model->getDistinctVmiDataClickhouse('store', 20);

		// print_r($data['stores']);
		// die();
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

	public function getPromoDataVmi(){

		// $preWeekStart = 4;
		// $preWeekEnd = 4;
		// $postWeekStart = 6;
		// $postWeekEnd = 6;
		// $latestYear = 6;
	   
		$orderDirection = strtoupper($orderDirection);
		//$skus = ['WC002', 'WC001', 'DA001'];
		$data = $this->Dashboard_model->getPromoTableVmi($preWeekStart, $preWeekEnd, $postWeekStart, $postWeekEnd, $latestYear, $orderByColumn, $orderDirection, $limit, $offset, $skus, $variantName, $brandIds, $brandLabelTypeIds, $storeCodes, $searchValue);
		
	    return $this->response->setJSON([
	        'draw' => intval($this->request->getVar('draw')),
	        'recordsTotal' => $data['total_records'],
	        'recordsFiltered' => $data['total_records'],
	        'data' => $data['data'],
	    ]);	
	}

	public function getPromoDataScannData()
	{	
		// $year = '2025';
		// $preMonthId = 1;
		// $preMonthEndId = 6;
		// $postMonthId = 7;
		// $postMonthEndId = 7;
	    //	$skus = ['WC002', 'WC001', 'DA001'];
	    $data = $this->Dashboard_model->getPromoTableScannData($preMonthId, $preMonthEndId, $postMonthId, $postMonthEndId, $orderByColumn, $orderDirection, $year, $limit, $offset, $skus, $variantName, $brandIds, $brandLabelTypeIds, $storeCodes, $searchValue);

	    return $this->response->setJSON([
	        'draw' => intval($this->request->getVar('draw')),
	        'recordsTotal' => $data['total_records'],
	        'recordsFiltered' => $data['total_records'],
	        'data' => $data['data']
	    ]);
	}

	public function getPromoDataAll()
	{
		$input = [];
		$contentType = $this->request->getHeaderLine('Content-Type');
		if (strpos($contentType, 'application/json') !== false) {
		    $input = $this->request->getJSON(true) ?? [];
		} else {
		    $input = $this->request->getPost() ?? [];
		}

	    $type = $input['type'] ?? 0;
	    $isExport = $input['is_export'] === true;

		$skus = $input['items'] ?? null;
		$variantName = $input['variant_name'] ?? null;
		$brandIds = $input['brands'] ?? null;
		$brandText = $input['brands_text'] ?? null;
		$brandsLabelsText = $input['brands_label_text'] ?? null;
		$brandLabelTypeIds = $input['brands_label'] ?? null;

		$storeCodes = $input['store_codes'] ?? null;
		$storeCodesText = $input['store_codes_text'] ?? null;

		$year = $input['year'] ?? null;
		$yearId = $input['year_id'] ?? null;

		$preMonthId = $input['pre_month_start'] ?? 1;
		$preMonthStartText = $input['pre_month_start_text'] ?? null;
		$preMonthEndId = $input['pre_month_end'] ?? 12;
		$preMonthEndText = $input['pre_month_end_text'] ?? null;

		$postMonthId = $input['post_month_start'] ?? 1;
		$postMonthStartText = $input['post_month_start_text'] ?? null;
		$postMonthEndId = $input['post_month_end'] ?? 12;
		$postMonthEndText = $input['post_month_end_text'] ?? null;

		$preWeekStart = $input['pre_week_start'] ?? null;
		$preWeekEnd = $input['pre_week_end'] ?? null;
		$preWeekStartDate = $input['pre_week_start_date'] ?? null;
		$preWeekEndDate = $input['pre_week_end_date'] ?? null;

		$postWeekStart = $input['post_week_start'] ?? null;
		$postWeekEnd = $input['post_week_end'] ?? null;
		$postWeekStartDate = $input['post_week_start_date'] ?? null;
		$postWeekEndDate = $input['post_week_end_date'] ?? null;

	    $orderColumnIndex = $this->request->getVar('order')[0]['column'] ?? 0;
	    $orderDirection = $this->request->getVar('order')[0]['dir'] ?? 'asc';
	    $columns = $this->request->getVar('columns');
	    $orderByColumn = $columns[$orderColumnIndex]['data'] ?? 'itmcde';
	    $searchValue = trim($this->request->getVar('search')['value'] ?? '') ?: null;

	    $data = $this->Dashboard_model->getPromoDataAllClickhouse(
	        $year, $yearId,
	        $preWeekStart, $preWeekEnd,
	        $postWeekStart, $postWeekEnd,
	        $preMonthId, $preMonthEndId,
	        $postMonthId, $postMonthEndId,
	        $orderByColumn, $orderDirection,
	        99999999, 0,
	        $skus, $variantName, $brandIds,
	        $brandLabelTypeIds, $storeCodes,
	        $searchValue
	    );

	    if ($isExport) {
	        $filter = [
	            'year' => $year,
	            'yearId' => $yearId,
	            'sku' => $skus,
	            'brandIds' => $brandIds,
	            'brandText' => $brandText,
	            'variantName' => $variantName,
	            'brandsLabelsText' => $brandsLabelsText,
	            'storeCodesText' => $storeCodesText,
	            'preMonthId' => $preMonthId,
	            'preMonthStartText' => $preMonthStartText,
	            'preMonthEndId' => $preMonthEndId,
	            'preMonthEndText' => $preMonthEndText,
	            'postMonthId' => $postMonthId,
	            'postMonthStartText' => $postMonthStartText,
	            'postMonthEndId' => $postMonthEndId,
	            'postMonthEndText' => $postMonthEndText,
	            'preWeekStart' => $preWeekStart,
	            'preWeekEnd' => $preWeekEnd,
	            'preWeekStartDate' => $preWeekStartDate,
	            'preWeekEndDate' => $preWeekEndDate,
	            'postWeekStart' => $postWeekStart,
	            'postWeekEnd' => $postWeekEnd,
	            'postWeekStartDate' => $postWeekStartDate,
	            'postWeekEndDate' => $postWeekEndDate,
	        ];

	        if ($type == 1) {
	            return $this->generatePdf($filter, $data);
	        } else {
	            return $this->generateExcel($filter, $data);
	        }
	    }

	    return $this->response->setJSON([
	        'pre_week_days' => $data['pre_week_days'],
	        'post_week_days'=> $data['post_week_days'],
	        'pre_month_days' => $data['pre_month_days'],
	        'post_month_days' => $data['post_month_days'],
	        'data' => $data['data']
	    ]);
	}

	public function generateExcel($filter, $data) {
	    $dv = function($value, $default = 'None') {
	        if (is_array($value)) {
	            return empty($value) ? $default : implode(', ', $value);
	        }
	        $value = trim((string)$value);
	        return $value === '' ? $default : $value;
	    };

	    $title = "Promo Analysis";
	    $rows = $data['data'];

	    $year = $filter['year'];
	    $latest_year = !empty($year) ? $year : 'N/A';

	    $skuMap = $dv($filter['sku']);
	    $brandsMap = $dv($filter['brandText']);
	    $brandsLabelMap = $dv($filter['brandsLabelsText']);
	    $storeCodeMap = $dv($filter['storeCodesText']);
	    $variantMap = $dv($filter['variantName']);

	    $filterData = [
	        'SKU' => $skuMap,
	        'Variant' => $variantMap,
	        'Brand' => $brandsMap,
	        'Label Type' => $brandsLabelMap,
	        'Store Name' => $storeCodeMap,
	        'Year' => $dv($filter['year']),
	        'Scanned Data Pre Period Range' => ($filter['preMonthId'] && $filter['preMonthEndId']) ? $filter['preMonthId'] . ' - ' . $filter['preMonthEndId'] : 'None',
	        'Scanned Data Post Period Range' => ($filter['postMonthId'] && $filter['postMonthEndId']) ? $filter['postMonthId'] . ' - ' . $filter['postMonthEndId'] : 'None',
	        'VMI Pre Period Range' => ($filter['preWeekStartDate'] && $filter['preWeekEndDate']) ? $filter['preWeekStartDate'] . ' - ' . $filter['preWeekEndDate'] : 'None',
	        'VMI Post Period Range' => ($filter['postWeekStartDate'] && $filter['postWeekEndDate']) ? $filter['postWeekStartDate'] . ' - ' . $filter['postWeekEndDate'] : 'None',
	    ];

	    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
	    $sheet = $spreadsheet->getActiveSheet();

	    $sheet->setCellValue('A1', 'LIFESTRONG MARKETING INC.');
	    $sheet->setCellValue('A2', 'Report: ' . $title);
	    $sheet->mergeCells('A1:C1');
	    $sheet->mergeCells('A2:C2');

	    $sheet->setCellValue('A4', 'Source: VMI/Scan Data (LMI/RGDI) - ' . $latest_year);
	    $sheet->setCellValue('A5', 'Date Generated: ' . date('M d, Y, h:i:s A'));

	    $sheet->setCellValue('A7', 'SKU: ' . $filterData['SKU']);
	    $sheet->setCellValue('B7', 'Variant: ' . $filterData['Variant']);
	    $sheet->setCellValue('C7', 'Brand: ' . $filterData['Brand']);
	    $sheet->setCellValue('D7', 'Label Type: ' . $filterData['Label Type']);
	    $sheet->setCellValue('E7', 'Store Name: ' . $filterData['Store Name']);
	    $sheet->setCellValue('F7', 'Year: ' . $filterData['Year']);

	    $sheet->setCellValue('A8', 'Scanned Data Pre Period Range: ' . $filterData['Scanned Data Pre Period Range']);
	    $sheet->setCellValue('B8', 'Scanned Data Post Period Range: ' . $filterData['Scanned Data Post Period Range']);
	    $sheet->setCellValue('C8', 'VMI Pre Period Range: ' . $filterData['VMI Pre Period Range']);
	    $sheet->setCellValue('D8', 'VMI Post Period Range: ' . $filterData['VMI Post Period Range']);

        $preWeekDays = $data['pre_week_days'];
        $postWeekDays = $data['post_week_days'];
        $preMonthDays = $data['pre_month_days'];
        $postMonthDays = $data['post_month_days'];

		$headers = [
			'SKU',
			'Variant',
			'PRE ' .$preWeekDays. ' (W'.$filter['preWeekStart'].' - W'.$filter['preWeekEnd'].')',
			'POST ' .$postWeekDays. ' (W'.$filter['postWeekStart'].' - W'.$filter['postWeekEnd'].')',
			'POST ' .$postWeekDays. ' vs PRE '.$preWeekDays,
			'PRE '.$preMonthDays. '( '.$filter['preMonthStartText'].' - '.$filter['preMonthEndText'].')',
			'POST '.$postMonthDays. '( '.$filter['postMonthStartText'].' - '.$filter['postMonthEndText'].')',
			'POST '.$postMonthDays.' vs PRE '.$preMonthDays,
		];

	    $sheet->fromArray($headers, null, 'A10');
	    $sheet->getStyle('A10:H10')->getFont()->setBold(true);

	    $rowNum = 11;
	    $totalPreVMI = $totalPostVMI = $totalPreScan = $totalPostScan = 0;

	    foreach ($rows as $row) {
	        $totalPreVMI += floatval($row['pre_vmi']);
	        $totalPostVMI += floatval($row['post_vmi']);
	        $totalPreScan += floatval($row['pre_sales']);
	        $totalPostScan += floatval($row['post_sales']);

	        $sheet->setCellValue("A{$rowNum}", $row['itmcde']);
	        $sheet->setCellValue("B{$rowNum}", $row['item_name']);
	        $sheet->setCellValue("C{$rowNum}", $row['pre_vmi']);
	        $sheet->setCellValue("D{$rowNum}", $row['post_vmi']);
	        $this->styleValueWithColor($sheet, "E{$rowNum}", $row['adv_vmi']);
	        $sheet->setCellValue("F{$rowNum}", $row['pre_sales']);
	        $sheet->setCellValue("G{$rowNum}", $row['post_sales']);
	        $this->styleValueWithColor($sheet, "H{$rowNum}", $row['ads_sales']);
	        $rowNum++;
	    }

	    $totalPrePostVMI = ($totalPreVMI != 0) ? (($totalPostVMI - $totalPreVMI) / $totalPreVMI) * 100 : 0;
	    $totalPrePostScan = ($totalPreScan != 0) ? (($totalPostScan - $totalPreScan) / $totalPreScan) * 100 : 0;

	    $sheet->setCellValue("A{$rowNum}", "Total:");
	    $sheet->mergeCells("A{$rowNum}:B{$rowNum}");
	    $sheet->setCellValue("C{$rowNum}", number_format($totalPreVMI, 2));
	    $sheet->setCellValue("D{$rowNum}", number_format($totalPostVMI, 2));
	    $this->styleValueWithColor($sheet, "E{$rowNum}", $totalPrePostVMI, true);
	    $sheet->setCellValue("F{$rowNum}", number_format($totalPreScan, 2));
	    $sheet->setCellValue("G{$rowNum}", number_format($totalPostScan, 2));
	    $this->styleValueWithColor($sheet, "H{$rowNum}", $totalPrePostScan, true);



	    foreach (range('A','H') as $col) {
	        $sheet->getColumnDimension($col)->setAutoSize(true);
	    }

	    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	    header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
	    header('Cache-Control: max-age=0');

	    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
	    $writer->save('php://output');
	    exit;
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

	public function generatePdf($filter, $data){    

	    $dv = function($value, $default = 'None') {
	        if (is_array($value)) {
	            return empty($value) ? $default : implode(', ', $value);
	        }
	        $value = trim((string)$value);
	        return $value === '' ? $default : $value;
	    };

	    $latest_year = $dv($filter['year'], 'N/A');

	    $skuMap = is_array($filter['sku']) ? implode(', ', $filter['sku']) : $filter['sku'];
	    $brandsMap = $dv($filter['brandText']);
	    $brandsLabelMap = $dv($filter['brandsLabelsText']);
	    $storeCodeMap = $dv($filter['storeCodesText']);

	    $filterData = [
	        'SKU' => $dv($skuMap),
	        'Variant' => $dv($filter['variantName']),
	        'Brand' => $dv($brandsMap),
	        'Label Type' => $dv($brandsLabelMap),
	        'Store Name' => $dv($storeCodeMap),
	        'Year' => $latest_year,
	        'Scanned Data Pre Period Range' => $dv(
	            ($filter['preMonthId'] ?? null) . ' - ' . ($filter['preMonthEndId'] ?? null),
	            'None'
	        ),
	        'Scanned Data Post Period Range' => $dv(
	            ($filter['postMonthId'] ?? null) . ' - ' . ($filter['postMonthEndId'] ?? null),
	            'None'
	        ),
	        'VMI Pre Period Range' => $dv(
	            ($filter['preWeekStartDate'] ?? null) . ' - ' . ($filter['preWeekEndDate'] ?? null),
	            'None'
	        ),
	        'VMI Post Period Range' => $dv(
	            ($filter['postWeekStartDate'] ?? null) . ' - ' . ($filter['postWeekEndDate'] ?? null),
	            'None'
	        ),
	    ];

	    $title = "Promo Analysis";
	    $pdf = new \App\Libraries\TCPDFLib('L','mm','A4', true, 'UTF-8', false, false);
	    $pdf->SetCreator('LMI SFA');
	    $pdf->SetAuthor('LIFESTRONG MARKETING INC.');
	    $pdf->SetTitle($title);
	    $pdf->setPrintHeader(false);
	    $pdf->setPrintFooter(true);
	    $pdf->AddPage();

	    $this->printHeader($pdf, $title);
	    $this->printFilter($pdf, $filterData, $latest_year);

	    $pdf->SetFont('dejavusans', '', 9);

	    $rows = $data['data'] ?? [];

	    $pageWidth = $pdf->getPageWidth();
	    $margins = $pdf->getMargins();
	    $colWidth = ($pageWidth - $margins['left'] - $margins['right']) / 8;

	    $preWeekDays = $dv($data['pre_week_days'], 'N/A');
	    $postWeekDays = $dv($data['post_week_days'], 'N/A');
	    $preMonthDays = $dv($data['pre_month_days'], 'N/A');
	    $postMonthDays = $dv($data['post_month_days'], 'N/A');

	    $headers = [
	        'SKU',
	        'Variant',
	        'PRE ' . $preWeekDays . ' ( W' . $dv($filter['preWeekStart'], 'N/A') . ' - W' . $dv($filter['preWeekEnd'], 'N/A') . ')',
	        'POST ' . $postWeekDays . ' ( W' . $dv($filter['postWeekStart'], 'N/A') . ' - W' . $dv($filter['postWeekEnd'], 'N/A') . ')',
	        'POST ' . $postWeekDays . ' vs PRE ' . $preWeekDays,
	        'PRE ' . $preMonthDays . ' ( ' . $dv($filter['preMonthStartText'], 'N/A') . ' - ' . $dv($filter['preMonthEndText'], 'N/A') . ')',
	        'POST ' . $postMonthDays . ' ( ' . $dv($filter['postMonthStartText'], 'N/A') . ' - ' . $dv($filter['postMonthEndText'], 'N/A') . ')',
	        'POST ' . $postMonthDays . ' vs PRE ' . $preMonthDays,
	    ];

	    $pdf->Ln(2);
	    $pdf->SetFont('dejavusans','B',9);
	    $lineHeight = 4;
	    $colWidths = [30,60,30,30,30,40,30,20];

	    foreach ($headers as $i => $h) {
	        $pdf->MultiCell(
	            $colWidths[$i], 0, $h, 1, 'C', 0, 0, '', '', true, 0, false, true, $lineHeight, 'M'
	        );
	        $pdf->SetX($pdf->GetX());
	    }
	    $pdf->Ln($lineHeight * 3);

	    $pdf->SetFont('dejavusans','',9);
	    $totalPreVMI = $totalPostVMI = $totalPreScan = $totalPostScan = 0;

	    foreach ($rows as $row) {
	        $preVMI = floatval($dv($row['pre_vmi'], 0));
	        $postVMI = floatval($dv($row['post_vmi'], 0));
	        $preSales = floatval($dv($row['pre_sales'], 0));
	        $postSales = floatval($dv($row['post_sales'], 0));

	        $totalPreVMI += $preVMI;
	        $totalPostVMI += $postVMI;
	        $totalPreScan += $preSales;
	        $totalPostScan += $postSales;

	        $numLines = $pdf->getNumLines($dv($row['item_name']), $colWidth);
	        $rowH = max(8, $numLines * 4);

	        $pdf->Cell($colWidths[0], $rowH, $dv($row['itmcde']), 1, 0, 'C');
	        $x = $pdf->GetX();
	        $y = $pdf->GetY();

	        $pdf->MultiCell($colWidths[1], $rowH, $dv($row['item_name']), 1, 'C', 0, 0);
	        $pdf->SetXY($x + $colWidths[1], $y);

	        $pdf->Cell($colWidths[2], $rowH, $preVMI, 1, 0, 'C');
	        $pdf->Cell($colWidths[3], $rowH, $postVMI, 1, 0, 'C');
	        $pdf->Cell($colWidths[4], $rowH, $this->pdfColoredText($pdf, $row['adv_vmi']), 1, 0, 'C');
	        $pdf->SetTextColor(0,0,0);
	        $pdf->Cell($colWidths[5], $rowH, $preSales, 1, 0, 'C');
	        $pdf->Cell($colWidths[6], $rowH, $postSales, 1, 0, 'C');
	        $pdf->Cell($colWidths[7], $rowH, $this->pdfColoredText($pdf, $row['ads_sales']), 1, 1, 'C');
	        $pdf->SetTextColor(0,0,0);
	    }

	    $totalPrePostVMI = $totalPreVMI ? (($totalPostVMI - $totalPreVMI) / $totalPreVMI) * 100 : 0;
	    $totalPrePostScan = $totalPreScan ? (($totalPostScan - $totalPreScan) / $totalPreScan) * 100 : 0;

	    $pdf->Ln(2);
	    $pdf->SetFont('dejavusans','B',9);
	    $pdf->Cell($colWidths[0] + $colWidths[1], 10, "Total:", 1, 0, 'R');

	    $pdf->Cell($colWidths[2], 10, number_format($totalPreVMI,2), 1, 0, 'C');
	    $pdf->Cell($colWidths[3], 10, number_format($totalPostVMI,2), 1, 0, 'C');
	    $pdf->Cell($colWidths[4], 10, $this->pdfColoredText($pdf, $totalPrePostVMI), 1, 0, 'C');
		$pdf->SetTextColor(0,0,0);
	    $pdf->Cell($colWidths[5], 10, number_format($totalPreScan,2), 1, 0, 'C');
	    $pdf->Cell($colWidths[6], 10, number_format($totalPostScan,2), 1, 0, 'C');
	    $pdf->Cell($colWidths[7], 10, $this->pdfColoredText($pdf, $totalPrePostScan), 1, 1, 'C');
		$pdf->SetTextColor(0,0,0);

	    $pdf->SetFont('dejavusans','',9);
	    $pdf->Output($title . '.pdf', 'D');
	    exit;
	}

	private function styleValueWithColor($sheet, $cell, $value, $isPercent = false)
	{
	    $num = floatval($value);

	    if ($num == 0) {
	        $sheet->setCellValue($cell, "");
	        $sheet->getStyle($cell)->getFont()->getColor()->setARGB('000000');
	        return;
	    }

	    $display = $isPercent
	        ? number_format($num, 2) . "%"
	        : number_format($num, 2);

	    $color = '';
	    $arrow = "";

	    if ($num > 0) {
	        $color = '00A000';
	        $arrow = " ▲ +";
	    } elseif ($num < 0) {
	        $color = 'FF0000';
	        $arrow = " ▼";
	    }

	    $sheet->setCellValue($cell, $arrow . $display);

	    $sheet->getStyle($cell)->getFont()->getColor()->setARGB($color);
	}


	private function pdfColoredText($pdf, $value)
	{
	    $num = floatval($value);

	    if ($num == 0) {
	        $pdf->SetTextColor(0, 0, 0);
	        return "";
	    }

	    $arrow = "";

	    if ($num > 0) {
	        $pdf->SetTextColor(0, 150, 0); 
	        $arrow = " ↑ +";
	    } elseif ($num < 0) {
	        $pdf->SetTextColor(255, 0, 0); 
	        $arrow = " ↓";
	    }

	    return $arrow . number_format($num, 2) . "%";
	}



	public function searchSku()
	{
	    $term = $this->request->getGet('term');
	    $limit = 20;

	    $ch = new \App\Libraries\ClickhouseClient();

	    $params = [
	        'limit' => (int)$limit,
	    ];

	    $sql = "
	        SELECT DISTINCT itmcde
	        FROM sfa_db.tbl_vmi_pre_aggregated_data
	        WHERE itmcde IS NOT NULL AND TRIM(itmcde) != ''
	        " . (!empty($term) ? "AND itmcde ILIKE {term:String}" : "") . "
	        ORDER BY itmcde ASC
	        LIMIT {limit:Int32}
	        FORMAT JSON
	    ";

	    if (!empty($term)) {
	        $params['term'] = '%' . $term . '%';
	    }

	    $rows = $ch->query($sql, $params);

	    $data = [];
	    foreach ($rows as $row) {
	        $data[] = [
	            'id' => $row['itmcde'],
	            'text' => $row['itmcde']
	        ];
	    }

	    return $this->response->setJSON(['results' => $data]);
	}

	public function searchStore()
	{
	    $term = $this->request->getGet('term');
	    $limit = 10;

	    $ch = new \App\Libraries\ClickhouseClient();

	    $params = [
	        'limit' => (int)$limit,
	    ];

	    $sql = "
	        SELECT DISTINCT store_code, store_name
	        FROM sfa_db.tbl_vmi_pre_aggregated_data
	        WHERE store_code IS NOT NULL AND TRIM(store_code) != ''
	        " . (!empty($term) ? "AND store_name ILIKE {term:String}" : "") . "
	        ORDER BY store_code ASC
	        LIMIT {limit:Int32}
	        FORMAT JSON
	    ";

	    if (!empty($term)) {
	        $params['term'] = '%' . $term . '%';
	    }

	    $rows = $ch->query($sql, $params);

	    $data = [];
	    foreach ($rows as $row) {
	        $data[] = [
	            'id' => $row['store_code'],
	            'text' => $row['store_name']
	        ];
	    }

	    return $this->response->setJSON(['results' => $data]);
	}

	public function searchVariant()
	{
	    $term = $this->request->getGet('term');
	    $limit = 20;

	    $ch = new \App\Libraries\ClickhouseClient();

	    $params = [
	        'limit' => (int)$limit,
	    ];

	    $sql = "
	        SELECT DISTINCT item_name
	        FROM sfa_db.tbl_vmi_pre_aggregated_data
	        WHERE item_name IS NOT NULL AND TRIM(item_name) != ''
	        " . (!empty($term) ? "AND item_name ILIKE {term:String}" : "") . "
	        ORDER BY item_name ASC
	        LIMIT {limit:Int32}
	        FORMAT JSON
	    ";

	    if (!empty($term)) {
	        $params['term'] = '%' . $term . '%';
	    }

	    $rows = $ch->query($sql, $params);

	    $data = [];
	    foreach ($rows as $row) {
	        $data[] = [
	            'id' => $row['item_name'],
	            'text' => $row['item_name']
	        ];
	    }

	    return $this->response->setJSON(['results' => $data]);
	}

	// ================================= Header for pdf export =================================
	private function printHeader($pdf, $title) {
		$logoPath = FCPATH . 'assets/img/lifestrong_white_bg.webp';
		if (file_exists($logoPath)) {
			$pdf->Image($logoPath, 15, 5, 50); // (file, x, y, width), adjust position if needed
		}

		$pdf->SetFont('helvetica', 'B', 15);
		$pdf->Cell(0, 10, 'LIFESTRONG MARKETING INC.', 0, 1, 'C');
		$pdf->SetFont('helvetica', '', 10);
		$pdf->Cell(0, 5, 'Report: ' . $title, 0, 1, 'C');
		$pdf->Ln(5);
	}

	private function printFilter($pdf, $filters) {
		$pdf->SetFont('helvetica', '', 9);
		$source = "VMI/Scann Data (LMI/RGDI)";
		$pdf->MultiCell(0, 8, "Source: " . $source, 0, 'C', 0, 1, '', '', true);

		$pdf->SetFont('helvetica', '', 9);
		$pdf->Ln(2);

		$pageWidth  = $pdf->getPageWidth();
		$pageMargin = $pdf->getMargins();
		$usableWidth 	= $pageWidth - $pageMargin['left'] - $pageMargin['right'];

		$perRow   = ceil(count($filters) / 2);
		$colWidth = $usableWidth / $perRow;
		$rows = array_chunk($filters, $perRow, true);

		$generatedAt = date('M d, Y, h:i:s A');

		foreach ($rows as $rowFilters) {
			$currentX = $pdf->GetX();
			$currentY = $pdf->GetY();

			$cellBaseHeight = 4;
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

		$pdf->Ln(2);
		$pdf->writeHTMLCell(
			0, 6, '', '',
			"<b>Generated Date:</b> {$generatedAt}",
			0, 1, false, true, 'L', true
		);

		$pdf->Ln(2);
		$pdf->Cell(0, 0, '', 'T');
		$pdf->Ln(4);
	}

	//for table comparison in local and prod
    public function compareTable()
    {
        $db1 = \Config\Database::connect('default');
        $db2 = \Config\Database::connect('db2');

        $forge1 = \Config\Database::forge('default');
        $forge2 = \Config\Database::forge('db2');

        $output = [];

        $tables1 = $db1->listTables();
        $tables2 = $db2->listTables();

        $output['tables_missing_in_db2'] = array_diff($tables1, $tables2);
        $output['tables_missing_in_db1'] = array_diff($tables2, $tables1);
        $commonTables = array_intersect($tables1, $tables2);

        $output['column_differences'] = [];

        foreach ($commonTables as $table) {
            $fields1 = $db1->getFieldData($table);
            $fields2 = $db2->getFieldData($table);

            $cols1 = array_map(fn($f) => $f->name, $fields1);
            $cols2 = array_map(fn($f) => $f->name, $fields2);

            $missingInDb2 = array_diff($cols1, $cols2);
            $missingInDb1 = array_diff($cols2, $cols1);

            if ($missingInDb1 || $missingInDb2) {
                $output['column_differences'][$table] = [
                    'missing_in_db2' => $missingInDb2,
                    'missing_in_db1' => $missingInDb1
                ];
            }
        }

        return $this->response->setJSON($output);
    }
}
