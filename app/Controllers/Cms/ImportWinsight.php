<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Sync_model;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ImportWinsight extends BaseController
{
    protected $session;

    public function __construct()
	{
	    $this->session = session();
	    if (!$this->session->get('sess_uid')) {
	        redirect()->to(base_url('cms/login'))->send();
	        exit;
	    }
	}

	public function index()
	{
		$data['meta'] = array(
			"title"         =>  "Import Winsight",
			"description"   =>  "Import Winsight",
			"keyword"       =>  ""
		);
		$data['title'] = "Import Winsight";
		$data['PageName'] = 'Import Winsight';
		$data['PageUrl'] = 'Import Winsight';
		$data['content'] = "cms/import/winsight/winsight.php";
		$data['buttons'] = ['add', 'search'];
		$data['session'] = session();
		$data['standard'] = config('Standard');
        $data['month'] = $this->Global_model->getMonths();
        $data['year'] = $this->Global_model->getYears();
		$data['js'] = array(
            "assets/js/xlsx.full.min.js",
            "assets/js/bootstrap.min.js",
            "assets/js/adminlte.min.js",
            "assets/js/moment.js",
            "assets/js/xlsx.full.min.js"
        );
        $data['css'] = array(
            "assets/css/bootstrap.min.css",
            "assets/css/adminlte.min.css",
            "assets/css/all.min.css",
            "assets/cms/css/main_style.css",
            "assets/css/style.css"
        );
		return view("cms/layout/template", $data);		
	}

    public function importTempWinsight() {
        try {
            $file = $this->request->getFile('file');
			$chunkIndex = $this->request->getPost('chunkIndex');
	        $totalChunks = $this->request->getPost('totalChunks');
	        $fileName = $this->request->getPost('fileName');
            $uniqueId = uniqid();
			
			if (!$file) {
				return $this->response->setJSON(['message' => 'No file received.']);
			}

			$tempDir = WRITEPATH . 'uploads/temp_chunks/';
	        if (!is_dir($tempDir)) {
	            mkdir($tempDir, 0777, true);
	        }		

	        foreach (glob($tempDir . '*') as $tempFile) {
	            if (filemtime($tempFile) < time() - 86400) { // 86400 seconds = 1 day
	                unlink($tempFile);
	            }
	        }

			$tempFilePath = $tempDir . $fileName . "_part_" . $chunkIndex;
			$file->move($tempDir, $fileName . "_part_" . $chunkIndex);

			if (!file_exists($tempFilePath)) {
				return $this->response->setJSON(['message' => "Error saving chunk $chunkIndex"]);
			}

			if ($chunkIndex + 1 == $totalChunks) {
				$finalFilePath = $tempDir . $fileName;
	            $finalFile = fopen($finalFilePath, 'wb');

	            for ($i = 0; $i < $totalChunks; $i++) {
	                $chunkPath = $tempDir . $fileName . "_part_" . $i;
	                $chunkContent = file_get_contents($chunkPath);
	                fwrite($finalFile, $chunkContent);
	                unlink($chunkPath); 
	            }

	            fclose($finalFile);

	            $batchSize = 20000;
	            $batchData = [];
	            $totalInserted = 0;

	            if (str_ends_with($fileName, '.csv')) {
					$handle = fopen($finalFilePath, 'r');
					if ($handle !== false) {
						$headerSkipped = false;
						$counter = 0;
						$line_number = 0;
						while (($row = fgetcsv($handle, 1000, ",")) !== false) {
							if (!$headerSkipped) {
								$headerSkipped = true;
								continue; 
							}
							$row = array_pad($row, 19, null); 
							$counter++;
							$line_number++;
				
							if ($counter >= 1) { 
								$batchData[] = [
									'created_date' => date('Y-m-d H:i:s'),
									'created_by' => $this->session->get('sess_uid'),
									'stuff' => $line_number . '_stuff',
									'file_name' => pathinfo($fileName, PATHINFO_FILENAME),
									'line_number' => $line_number,
                                    'bu_name' => trim($row[0] ?? ''), 
                                    'supplier' => trim($row[1] ?? ''), 
                                    'brand_name' => trim($row[2] ?? ''), 
                                    'product_id' => trim($row[3] ?? ''),
                                    'product_name' => trim($row[4] ?? ''), 
                                    'cat_1' => trim($row[5] ?? ''),
                                    'cat_2' => trim($row[6] ?? ''), 
                                    'cat_3' => trim($row[7] ?? ''), 
                                    'cat_4' => trim($row[8] ?? ''), 
                                    'year' => trim($row[9] ?? ''), 
                                    'month' => substr(trim($row[10] ?? ''),-2), 
                                    'week' => trim($row[11] ?? ''), 
									'date' => trim($row[12] ?? ''), 
                                    'online_offline' => trim($row[13] ?? ''), 
                                    'store_format' => trim($row[14] ?? ''), 
                                    'store_segment' => trim($row[15] ?? ''), 
                                    'gross_sales' => trim($row[16] ?? ''), 
                                    'net_sales' => trim($row[17] ?? ''), 
                                    'sales_qty' => trim($row[18] ?? ''), 
                                    'barcode' => trim($row[19] ?? ''),
                                    'uid' => $uniqueId
								];
							}
				
							if (count($batchData) === $batchSize) {
								$this->Custom_model->batch_insert('tbl_winsight_temp_space', $batchData);
								$totalInserted += count($batchData);
								$batchData = [];
							}
						}
						fclose($handle);
					}
				} elseif (str_ends_with($fileName, '.xls') || str_ends_with($fileName, '.xlsx')) {
	                $reader = IOFactory::createReaderForFile($finalFilePath);
	                $reader->setReadDataOnly(true);
	                $spreadsheet = $reader->load($finalFilePath);
	                $worksheet = $spreadsheet->getActiveSheet();
	                $rows = $worksheet->toArray();

	                array_shift($rows); 
	                $counter = 0;
	                $line_number = 0;
	                foreach ($rows as $row) {
	                    $row = array_pad($row, 19, null);
	                    $counter++;
	                    $line_number++;
						if ($counter >= 1) {
							$batchData[] = [
                                'created_date' => date('Y-m-d H:i:s'),
                                'created_by' => $this->session->get('sess_uid'),
                                'stuff' => $line_number . '_stuff',
                                'file_name' => pathinfo($fileName, PATHINFO_FILENAME),
                                'line_number' => $line_number,
                                'bu_name' => trim($row[0] ?? ''), 
                                'supplier' => trim($row[1] ?? ''), 
                                'brand_name' => trim($row[2] ?? ''), 
                                'product_id' => trim($row[3] ?? ''),
                                'product_name' => trim($row[4] ?? ''), 
                                'cat_1' => trim($row[5] ?? ''),
                                'cat_2' => trim($row[6] ?? ''), 
                                'cat_3' => trim($row[7] ?? ''), 
                                'cat_4' => trim($row[8] ?? ''), 
                                'year' => trim($row[9] ?? ''), 
                                'month' => substr(trim($row[10] ?? ''),-2), 
                                'week' => trim($row[11] ?? ''), 
                                'date' => trim($row[12] ?? ''), 
								'online_offline' => trim($row[13] ?? ''), 
								'store_format' => trim($row[14] ?? ''), 
								'store_segment' => trim($row[15] ?? ''), 
								'gross_sales' => trim($row[16] ?? ''), 
								'net_sales' => trim($row[17] ?? ''), 
								'sales_qty' => trim($row[18] ?? ''), 
								'barcode' => trim($row[19] ?? ''),
								'uid' => $uniqueId
							];
						}

	                    if (count($batchData) === $batchSize) {
	                        $this->Custom_model->batch_insert('tbl_winsight_temp_space', $batchData);
	                        $totalInserted += count($batchData);
	                        $batchData = [];
	                    }
	                }
	            } else {
	                return $this->response->setJSON(['message' => 'Unsupported file format'])->setStatusCode(400);
	            }

				if (!empty($batchData)) {
	                $this->Custom_model->batch_insert('tbl_winsight_temp_space', $batchData);
	                $totalInserted += count($batchData);
	            }

				unlink($finalFilePath);

				return $this->response->setJSON([
	                'message' => 'Upload and processing successful',
	                'total_inserted' => $totalInserted,
                    'uid' => $uniqueId,
					'addtnl' => [
						'year' => $batchData[0]['year'],
						'month' => $batchData[0]['month'],
						'week' => $batchData[0]['week'],
					]
	            ]);
			} else {
				return $this->response->setJSON([
					'file' => $file,
					'chunkIndex' => $chunkIndex,
					'totalChunks' => $totalChunks,
					'fileName' => $fileName,
				]);
			}
        }
        catch (\Exception $e) {
	        return $this->response->setJSON(['message' => 'Error: ' . $e->getMessage()]);
	    };
    }

    public function fetchTempWinsight() {
        $page = $this->request->getGet('page') ?? 1;
		$limit = $this->request->getGet('limit') ?? 1000;
		$file_name = $this->request->getGet('file_name');
		$uid = $this->request->getGet('uid');

		$result = $this->Global_model->fetch_winsight_data($limit, $page, $file_name, $this->session->get('sess_uid'), $uid);
		return $this->response->setJSON([
			"trap" => $file_name,
			"success" => true,
			"data" => $result['data'],
			"totalRecords" => $result['totalRecords']
		]);
    }

	public function deleteTempWinsight() {
		$uid = $this->request->getPost('uid');
		$fileName = $this->request->getPost('fileName');
		$result = $this->Global_model->delete_temp_winsight($this->session->get('sess_uid'), $uid, $fileName);
		echo $result;
	}

	public function exportWinsight() {
		$id = $this->request->getPost('id') ?? '1';

		$select = '';
		$select .= 'header_id, file_name, line_number,';
		$select .= 'bu_name, supplier, brand_name, product_id, product_name,';
		$select .= 'cat_1, cat_2, cat_3, cat_4,';
		$select .= 'year, month, week, date,';
		$select .= 'online_offline, store_format, store_segment, ';
		$select .= 'gross_sales, net_sales, sales_qty, barcode';

		$result = $this->Global_model->get_data_list(
			'tbl_winsight_details', "header_id = '$id'", 999999999, 0, 
			$select, '', '', '', ''
		);

		$result1 = $this->Global_model->get_data_list(
			'tbl_winsight_header as a', "a.id = '$id'", 1, 0, 
			'a.id, a.created_date, b.username, a.file_name, a.status, a.year, a.month, a.week', '', '', 
			[
				[ 'table' => 'cms_users as b', 'query' => 'a.created_by = b.id', 'type' => 'left' ],
			], ''
		);

		$spreadsheet = new Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'Year');
		$sheet->setCellValue('B1', $result1[0]->year);
		$sheet->setCellValue('A2', 'Month');
		$sheet->setCellValue('B2', $result1[0]->month);
		$sheet->setCellValue('A3', 'Week');
		$sheet->setCellValue('B3', $result1[0]->week);
		$sheet->setCellValue('A4', 'Import Date: ');
		$sheet->setCellValue('B4', $result1[0]->created_date);
		$sheet->setCellValue('A5', 'Import File Name: ');
		$sheet->setCellValue('B5', $result1[0]->file_name);
		$sheet->setCellValue('A6', 'Date Printed: ');
		$sheet->setCellValue('B6', (new \DateTime())->format('Y-m-d h:i A'));

		function setHeaderCellValue(array $headers, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet, int $row = 8): void {
			foreach ($headers as $index => $header) {
				$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
				$sheet->setCellValue($colLetter . $row, $header);
			}
		}

		$headers = [ 
			"BU Name", "Supplier", "Brand Name", "Product ID (Customer Item Code)", "Product Name",
			"Category 1 (Item Classification)", "Category 2 (Sub Classification)", "Category 3 (Department)", "Category 4 (Merch. Category)",
			"Year", "Month", "Week", "Date",
			"Online/ Offline", "Store Format", "Store Segment",
			"Gross Sales", "Net Sales", "Sales Qty", "Barcode"
		];
		setHeaderCellValue($headers, $sheet);

		$currentRow = 9;
		foreach ($result as $value) {
			$headers = [
				$value->bu_name, $value->supplier, $value->brand_name, $value->product_id, $value->product_name,
				$value->cat_1, $value->cat_2, $value->cat_3, $value->cat_4,
				$value->year, $value->month, $value->week, $value->date,
				$value->online_offline, $value->store_format, $value->store_segment,
				$value->gross_sales, $value->net_sales, $value->sales_qty, $value->barcode
			];
			setHeaderCellValue($headers, $sheet, $currentRow);
			$currentRow++;
		}

		$title = "Winsight File";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}
}