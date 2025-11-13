<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Sync_model;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Settings;

use CodeIgniter\Psr\Cache\SimpleCache; // provided by codeigniter4/cache

class ImportSellOut extends BaseController
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
			"title"         =>  "Import Sell Out",
			"description"   =>  "Import Sell Out",
			"keyword"       =>  ""
		);
		$data['title'] = "Import Sell Out";
		$data['PageName'] = 'Import Sell Out';
		$data['PageUrl'] = 'Import Sell Out';
		$data['content'] = "cms/import/sell-out/sell_out.php";
		$data['buttons'] = ['export', 'add', 'templates', 'search'];
		$data['session'] = session(); //for frontend accessing the session data
		$data['standard'] = config('Standard');
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
        		"assets/cms/css/main_style.css",//css sa style ni master Vien
        		"assets/css/style.css"
                    );
		return view("cms/layout/template", $data);		
	}

	public function view()
	{

		$uri = current_url(true);
		$data['uri'] =$uri;

		$data['meta'] = array(
			"title"         =>  "Import Sell Out",
			"description"   =>  "Import Sell Out",
			"keyword"       =>  ""
		);
		$data['title'] = "Import Sell Out";
		$data['PageName'] = 'Import Sell Out';
		$data['PageUrl'] = 'Import Sell Out';
		$data['content'] = "cms/import/sell-out/view_sell_out.php";
		$data['buttons'] = ['search'];
		$data['session'] = session(); //for frontend accessing the session data
		$data['standard'] = config('Standard');
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
        		"assets/cms/css/main_style.css",//css sa style ni master Vien
        		"assets/css/style.css"
                    );
		return view("cms/layout/template", $data);		
	}

	public function add() {
		$uri = current_url(true);
		$data['uri'] =$uri;

		$data['meta'] = array(
			"title"         =>  "Import Sell Out",
			"description"   =>  "Import Sell Out",
			"keyword"       =>  ""
		);
		$data['title'] = "Import Sell Out";
		$data['PageName'] = 'Import Sell Out';
		$data['PageUrl'] = 'Import Sell Out';
		$data['content'] = "cms/import/sell-out/add_sell_out.php";
		$data['buttons'] = ['search'];
		$data['session'] = session(); //for frontend accessing the session data
		$data['standard'] = config('Standard');
		$data['month'] = $this->Global_model->getMonths();
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
        		"assets/cms/css/main_style.css",//css sa style ni master Vien
        		"assets/css/style.css"
                    );
		return view("cms/layout/template", $data);	
	}

	public function import_temp_scan_data() {
		try {
			$file = $this->request->getFile('file');
			$chunkIndex = $this->request->getPost('chunkIndex');
	        $totalChunks = $this->request->getPost('totalChunks');
	        $fileName = $this->request->getPost('fileName');
			//$header_id = $this->request->getPost('header_id');
			$month = $this->request->getPost('month');
			$year = $this->request->getPost('year');
			$customer_payment_group = $this->request->getPost('customer_payment_group');
			$template_id = $this->request->getPost('template_id');
			$placeholder = json_decode($this->request->getPost('placeholder'), true);

			if (!$file) {
				return $this->response->setJSON(['message' => 'No file received.']);
			}
			
			//log_message('debug', 'Chunk file received: ' . $file->getName());

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
						$allRows = [];
						$headerSkipped = false;
				
						while (($row = fgetcsv($handle, 1000, ",")) !== false) {
							if (!$headerSkipped) {
								$headerSkipped = true;
								continue; // skip header
							}
							$allRows[] = array_pad($row, 8, null); // ensure at least 8 columns
						}
				
						fclose($handle);
				
						// Remove last line if required
						if (!empty($placeholder['exclude_last_line']) && $placeholder['exclude_last_line'] === true) {
							array_pop($allRows);
						}
				
						$totalRows = count($allRows);
						$startLine = $placeholder['start_line_read'] ?? 1;
						$endLine = $totalRows - $placeholder['end_line_read'] ?? $totalRows;
				
						$counter = 0;
						$line_number = 0;
				
						foreach ($allRows as $row) {
							$counter++;
							$line_number++;
				
							if ($counter >= $startLine && $counter <= $endLine) {
								$batchData[] = [
									'created_date' => date('Y-m-d H:i:s'),
									'created_by' => $this->session->get('sess_uid'),
									'stuff' => $line_number.'_stuff',
									//'data_header_id' => $header_id,
									'month' => $month,
									'year' => $year,
									'customer_payment_group' => $customer_payment_group,
									'template_id' => $template_id,
									'file_name' => $fileName,
									'line_number' => $line_number,
									'store_code' => trim($row[$placeholder['store_code'] - 1] ?? 'Empty - '.$row[$placeholder['store_code'] - 1]), // look here
									'store_description' => trim($row[$placeholder['store_description'] - 1] ?? ''), // look here
									'sku_code' => trim($row[$placeholder['sku_code'] - 1] ?? ''), // look here
									'sku_description' => trim($row[$placeholder['sku_description'] - 1] ?? ''), // look here
									'gross_sales' => trim($row[$placeholder['gross_sales'] - 1] ?? '0'), // look here
									'quantity' => trim($row[$placeholder['quantity'] - 1] ?? '0'), // look here
									'net_sales' => trim($row[$placeholder['net_sales'] - 1] ?? '0'), // look here
								];
							}
				
							if (count($batchData) === $batchSize) {
								$this->Custom_model->batch_insert('tbl_sell_out_temp_space', $batchData);
								$totalInserted += count($batchData);
								$batchData = [];
							}
						}
				
						// Insert remaining data
						if (!empty($batchData)) {
							$this->Custom_model->batch_insert('tbl_sell_out_temp_space', $batchData);
							$totalInserted += count($batchData);
						}
					}
				} elseif (str_ends_with($fileName, '.xls') || str_ends_with($fileName, '.xlsx')) {
	                $reader = IOFactory::createReaderForFile($finalFilePath);
	                $reader->setReadDataOnly(true);
	                $spreadsheet = $reader->load($finalFilePath);
	                $worksheet = $spreadsheet->getActiveSheet();
	                $rows = $worksheet->toArray();

	                array_shift($rows); 
					$totalRows = count($rows);
	                $counter = 0;
	                $line_number = 0;
	                foreach ($rows as $row) {
	                    $row = array_pad($row, 8, null);
	                    $counter++;
	                    $line_number++;

						$startLine = $placeholder['start_line_read'] ?? 1;
						$endLine = $totalRows - $placeholder['end_line_read'] ?? $totalRows;

						if ($counter >= $startLine && $counter <= $endLine) { // look here
						
							$batchData[] = [
								'created_date' => date('Y-m-d H:i:s'),
								'created_by' => $this->session->get('sess_uid'),
								'stuff' => $line_number.'_stuff',
								//'data_header_id' => $header_id,
								'month' => $month,
								'year' => $year,
								'customer_payment_group' => $customer_payment_group,
								'template_id' => $template_id,
								'file_name' => $fileName,
								'line_number' => $line_number,
								'store_code' => trim($row[$placeholder['store_code'] - 1] ?? 'Empty - '.$row[$placeholder['store_code'] - 1]), // look here
								'store_description' => trim($row[$placeholder['store_description'] - 1] ?? ''), // look here
								'sku_code' => trim($row[$placeholder['sku_code'] - 1] ?? ''), // look here
								'sku_description' => trim($row[$placeholder['sku_description'] - 1] ?? ''), // look here
								'gross_sales' => trim($row[$placeholder['gross_sales'] - 1] ?? '0'), // look here
								'quantity' => trim($row[$placeholder['quantity'] - 1] ?? '0'), // look here
								'net_sales' => trim($row[$placeholder['net_sales'] - 1] ?? '0'), // look here
							];
						}

	                    if (count($batchData) === $batchSize) {
	                        $this->Custom_model->batch_insert('tbl_sell_out_temp_space', $batchData);
	                        $totalInserted += count($batchData);
	                        $batchData = [];
	                    }
	                }
	            } 
				elseif (str_ends_with($fileName, '.xml')) {
					$xml = simplexml_load_file($finalFilePath);	
					
					if ($xml === false) {
						return $this->response->setJSON(['message' => 'Unable to parse XML'])->setStatusCode(400);
					}

					$line_number = 0;
					foreach ($xml->document as $document) {
						foreach ($document->details->article as $article) {
							$line_number++;
							$batchData[] = [
								'created_date' => date('Y-m-d H:i:s'),
								'created_by' => $this->session->get('sess_uid'),
								'stuff' => $line_number.'_stuff',
								'month' => $month,
								'year' => $year,
								'customer_payment_group' => $customer_payment_group,
								'template_id' => $template_id,
								'file_name' => $fileName,
								'line_number' => $line_number,
								'store_code' => trim((string)$document->header->VendorCode ?? 'Empty - '.(string)$document->header->VendorCode), // look here
								'store_description' => trim((string)$document->header->VendorName ?? ''),
								'sku_code' => trim($row[$placeholder['sku_code'] - 1] ?? ''),
								'sku_description' => trim($row[$placeholder['sku_description'] - 1] ?? ''),
								'gross_sales' => trim($row[$placeholder['gross_sales'] - 1] ?? '0'),
								'quantity' => trim($row[$placeholder['quantity'] - 1] ?? '0'),
								'net_sales' => trim($row[$placeholder['net_sales'] - 1] ?? '0'),
								'sku_code' => trim((string)$article->ArticleNumber ?? ''),
								'sku_description' => trim((string)$article->BarcodeDescription ?? ''),
								'gross_sales' => trim((string)$article->TOTAL ?? '0'),
								'quantity' => trim((string)$article->Qty ?? '0'),
								'net_sales' => trim((string)$article->VAT ?? '0'),
							];

							if (count($batchData) === $batchSize) {
								$this->Custom_model->batch_insert('tbl_sell_out_temp_space', $batchData);
								$totalInserted += count($batchData);
								$batchData = [];
							}
						}
					}
				}
				else {
	                return $this->response->setJSON(['message' => 'Unsupported file format'])->setStatusCode(400);
	            }

				if (!empty($batchData)) {
	                $this->Custom_model->batch_insert('tbl_sell_out_temp_space', $batchData);
	                $totalInserted += count($batchData);
	            }

				unlink($finalFilePath);

				return $this->response->setJSON([
	                'message' => 'Upload and processing successful',
	                'total_inserted' => $totalInserted,
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
		catch (Exception $e) {
	        return $this->response->setJSON(['message' => 'Error: ' . $e->getMessage()]);
	    }
	}

	public function fetch_temp_scan_data(){
		$page = $this->request->getGet('page') ?? 1;
		$limit = $this->request->getGet('limit') ?? 1000;
		$file_name = $this->request->getGet('file_name');

		$result = $this->Global_model->fetch_scan_data($limit, $page, $file_name, $this->session->get('sess_uid'));
		return $this->response->setJSON([
			"success" => true,
			"data" => $result['data'],
			"totalRecords" => $result['totalRecords']
		]);
	}

	public function delete_temp_scan_data(){
		$month = $this->request->getPost('month');
		$year = $this->request->getPost('year');
		$result = $this->Global_model->delete_temp_scan($this->session->get('sess_uid'), $month, $year);
		echo $result;
	}

	public function update_aggregated_scan_data_old()
	{
	    $data_header_id = $this->request->getPost('data_header_id');
	    $month = $this->request->getPost('month');
	    $year = $this->request->getPost('year');

	    $refresher = new Sync_model();

	    if (!empty($data_header_id) && !empty($month) && !empty($year)) {
	        $result = $refresher->refreshScanData($data_header_id, $month, $year);

	        return $this->response->setJSON([
	            'status' => 'success',
	            'message' => 'Refresh completed',
	            'results' => $result
	        ]);
	    }

	    return $this->response->setJSON([
	        'status' => 'error',
	        'message' => 'Missing parameters: data_header_id, month, or year',
	        'results' => []
	    ]);
	}

	public function update_aggregated_scan_data()
	{
	    $data_header_id = $this->request->getPost('data_header_id');
	    $month = $this->request->getPost('month');
	    $year = $this->request->getPost('year');
	    $payment_group = $this->request->getPost('customer_payment_group');
	    $company = $this->request->getPost('company');

	    //testing data
	    // $data_header_id = 17;
	    // $month = 2;
	    // $year = 2025;
	    // $payment_group = "Watsons Personal Care Stores (Philippines) Inc.";
	    // $company = 2;

	    if (empty($data_header_id) || empty($month) || empty($year)) {
	        return $this->response->setJSON([
	            'status' => 'error',
	            'message' => 'Missing parameters: data_header_id, month, or year',
	            'results' => []
	        ]);
	    }

	    $refresher = new Sync_model();
	    $refreshResult = $refresher->refreshScanData($data_header_id, $month, $year);

	    $pythonPath = "python3"; // Use "python3" on Linux / python on windows depending on what python version you installed

	    $scriptPath = FCPATH . "../migrate_sellout_clickhouse.py"; 
	    $yearArg = escapeshellarg($year);
	    $companyArg = escapeshellarg($company);
	    $monthArg = escapeshellarg($month);
	    $paymentGroupArg = escapeshellarg($payment_group);

	    $cmd = "$pythonPath $scriptPath --year $yearArg --company $companyArg --month $monthArg --payment_group $paymentGroupArg";

	    $output = [];
	    $returnVar = 0;

	    exec($cmd, $output, $returnVar);

	    if ($returnVar !== 0) {
	        return $this->response->setJSON([
	            'status' => 'error',
	            'message' => 'ScanData migration failed',
	            'results' => $refreshResult,
	            'migration_output' => $output
	        ]);
	    }

	    return $this->response->setJSON([
	        'status' => 'success',
	        'message' => 'Refresh and migration completed successfully',
	        'results' => $refreshResult,
	        'migration_output' => $output
	    ]);
	}

	public function setHeaderCellValue(array $headers, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet, int $row = 1): void {
		foreach ($headers as $index => $header) {
			$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
			$sheet->setCellValue($colLetter . $row, $header);
		}
	}

	public function exportSpecific()
	{
	    $id = $this->request->getPost('id') ?? '1';

	    $result = $this->Global_model->get_data_list(
	        'tbl_sell_out_data_details', 
	        "data_header_id = '$id'",
	        1000000,
	        0,
	        'data_header_id, id, file_name, line_number, store_code, store_description, sku_code, sku_description, quantity, net_sales, gross_sales',
	        '',
	        '',
	        '',
	        ''
	    );

	    $result1 = $this->Global_model->get_data_list(
	        '`tbl_sell_out_data_header` a',
	        "a.id = '$id'",
	        1,
	        0,
	        'b.`month`, a.`year`, a.customer_payment_group, a.created_date, c.username, a.file_type, a.remarks',
	        '',
	        '',
	        [
	            ['table' => 'tbl_month b', 'query' => 'a.`month` = b.id', 'type' => 'left'],
	            ['table' => 'cms_users c', 'query' => 'a.created_by = c.id', 'type' => 'left']
	        ],
	        ''
	    );

	    $filename = 'Sell_Out_' . date('Ymd_His') . '.csv';

	    header('Content-Type: text/csv');
	    header("Content-Disposition: attachment; filename=\"$filename\"");
	    header('Pragma: no-cache');
	    header('Expires: 0');

	    $output = fopen('php://output', 'w');

	    fputcsv($output, ['Company Name: Lifestrong Marketing Inc.']);
	    fputcsv($output, ['Sell Out']);
	    fputcsv($output, ['Date Printed: ' . date('F j, Y g:i A')]);
	    fputcsv($output, []);

	    $created_date = (new \DateTime($result1[0]->created_date))->format('F j, Y g:i A');
	    fputcsv($output, [
	        'Month' => $result1[0]->month,
	        'Year' => $result1[0]->year,
	        'Payment Group' => $result1[0]->customer_payment_group,
	        'Created Date' => $created_date,
	        'Created By' => $result1[0]->username,
	        'File Type' => $result1[0]->file_type,
	        'Remarks' => $result1[0]->remarks,
	    ]);

	    fputcsv($output, []); 

	    fputcsv($output, [
	        'File Name', 'Store Code', 'Store Description', 'SKU Code',
	        'SKU Description', 'Gross Sales', 'Quantity', 'Net Sales'
	    ]);

	    foreach ($result as $row) {
	        fputcsv($output, [
	            $row->file_name,
	            $row->store_code,
	            $row->store_description,
	            $row->sku_code,
	            $row->sku_description,
	            $row->gross_sales,
	            $row->quantity,
	            $row->net_sales,
	        ]);
	    }

	    fclose($output);
	    exit;
	}

	public function exportBatch()
	{
	    $ids = $this->request->getPost('ids') ?? ['1', '6', '7'];
	    $filename = 'Sell_Out_Batch_' . date('Ymd_His') . '.csv';

	    header('Content-Type: text/csv');
	    header("Content-Disposition: attachment; filename=\"$filename\"");
	    header('Pragma: no-cache');
	    header('Expires: 0');

	    $output = fopen('php://output', 'w');

	    fputcsv($output, ['Company Name: Lifestrong Marketing Inc.']);
	    fputcsv($output, ['Sell Out']);
	    fputcsv($output, ['Date Printed: ' . date('F j, Y g:i A')]);
	    fputcsv($output, []); 

	    foreach ($ids as $id) {
	        $result1 = $this->Global_model->get_data_list(
	            '`tbl_sell_out_data_header` a',
	            "a.id = '$id'",
	            1,
	            0,
	            'b.`month`, a.`year`, a.customer_payment_group, a.created_date, c.username, a.file_type, a.remarks',
	            '',
	            '',
	            [
	                ['table' => 'tbl_month b', 'query' => 'a.`month` = b.id', 'type' => 'left'],
	                ['table' => 'cms_users c', 'query' => 'a.created_by = c.id', 'type' => 'left']
	            ],
	            ''
	        );

	        if (!empty($result1)) {
	            $created_date = (new \DateTime($result1[0]->created_date))->format('F j, Y g:i A');

	            fputcsv($output, [
	                'Month' => $result1[0]->month,
	                'Year' => $result1[0]->year,
	                'Payment Group' => $result1[0]->customer_payment_group,
	                'Created Date' => $created_date,
	                'Created By' => $result1[0]->username,
	                'File Type' => $result1[0]->file_type,
	                'Remarks' => $result1[0]->remarks,
	            ]);
	        }

	        fputcsv($output, [
	            'File Name',
	            'Store Code',
	            'Store Description',
	            'SKU Code',
	            'SKU Description',
	            'Gross Sales',
	            'Quantity',
	            'Net Sales'
	        ]);

	        $result = $this->Global_model->get_data_list(
	            'tbl_sell_out_data_details',
	            "data_header_id = '$id'",
	            1000000,
	            0,
	            'data_header_id, id, file_name, line_number, store_code, store_description, sku_code, sku_description, quantity, net_sales, gross_sales',
	            '',
	            '',
	            '',
	            ''
	        );

	        foreach ($result as $value) {
	            fputcsv($output, [
	                $value->file_name,
	                $value->store_code,
	                $value->store_description,
	                $value->sku_code,
	                $value->sku_description,
	                $value->gross_sales,
	                $value->quantity,
	                $value->net_sales
	            ]);
	        }
	        fputcsv($output, []);
	    }

	    fclose($output);
	    exit;
	}
}
