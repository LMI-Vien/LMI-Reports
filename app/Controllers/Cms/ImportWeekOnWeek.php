<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Libraries\TCPDFLib;
use App\Models\Sync_model;

class ImportWeekOnWeek extends BaseController
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
			"title"         =>  "Import Week on Week",
			"description"   =>  "Import Week on Week",
			"keyword"       =>  ""
		);
		$data['title'] = "Import Week on Week";
		$data['PageName'] = 'Import Week on Week';
		$data['PageUrl'] = 'Import Week on Week';
		$data['content'] = "cms/import/week-on-week/week_on_week.php";
		$data['buttons'] = ['add', 'search'];
		$data['session'] = session(); //for frontend accessing the session data
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
        		"assets/cms/css/main_style.css",//css sa style ni master Vien
        		"assets/css/style.css"
                    );
		return view("cms/layout/template", $data);		
	}

	public function importTempWeekOnWeekData()
	{
		try {
			$file = $this->request->getFile('file');
			$chunkIndex = $this->request->getPost('chunkIndex');
	        $totalChunks = $this->request->getPost('totalChunks');
	        $fileName = $this->request->getPost('fileName');
			$year = $this->request->getPost('year');
			$week = $this->request->getPost('week');
			// print_r($year);
			// die();
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
						$headerSkipped = false;
						$counter = 0;
						$line_number = 0;
						while (($row = fgetcsv($handle, 1000, ",")) !== false) {
							if (!$headerSkipped) {
								$headerSkipped = true;
								continue; 
							}
							$row = array_pad($row, 12, null); // ensure same number of columns as in Excel case
							$counter++;
							$line_number++;
				
							if ($counter >= 4) { // start from 5th row (0-based logic with header already skipped)
								$batchData[] = [
									'created_date' => date('Y-m-d H:i:s'),
									'created_by' => $this->session->get('sess_uid'),
									'stuff' => $line_number . '_stuff',
									'file_name' => $fileName,
									'line_number' => $line_number,
									'year' => $year,
									'week' => $week,
									'item' => trim($row[0] ?? ''),
									'item_name' => trim($row[1] ?? ''),
									'label_type' => trim($row[2] ?? ''),
									'status' => trim($row[3] ?? ''),
									'item_class' => trim($row[4] ?? ''),
									'pog_store' => trim($row[6] ?? ''),
									'quantity' => trim($row[7] ?? ''),
									'soh' => trim($row[8] ?? ''),
									'ave_weekly_sales' => trim($row[9] ?? ''),
									'weeks_cover' => trim($row[10] ?? ''),
								];
							}
				
							if (count($batchData) === $batchSize) {
								$this->Custom_model->batch_insert('tbl_wkonwk_temp_space', $batchData);
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
	                    $row = array_pad($row, 12, null);
	                    $counter++;
	                    $line_number++;
						if ($counter >= 5 - 1) { // look here
							$batchData[] = [
								'created_date' => date('Y-m-d H:i:s'),
								'created_by' => $this->session->get('sess_uid'),
								'stuff' => $line_number.'_stuff',
								'file_name' => $fileName,
								'line_number' => $line_number,
								'year' => $year,
								'week' => $week,
								'item' => trim($row[0] ?? ''), // look here
								'item_name' => trim($row[1] ?? ''), // look here
								'label_type' => trim($row[2] ?? ''), // look here
								'status' => trim($row[3] ?? ''), // look here
								'item_class' => trim($row[4] ?? ''), // look here
								'pog_store' => trim($row[6] ?? ''), // look here
								'quantity' => trim($row[7] ?? ''), // look here
								'soh' => trim($row[8] ?? ''), // look here
								'ave_weekly_sales' => trim($row[9] ?? ''), // look here
								'weeks_cover' => trim($row[10] ?? ''), // look here
							];
						}

	                    if (count($batchData) === $batchSize) {
	                        $this->Custom_model->batch_insert('tbl_wkonwk_temp_space', $batchData);
	                        $totalInserted += count($batchData);
	                        $batchData = [];
	                    }
	                }
	            } else {
	                return $this->response->setJSON(['message' => 'Unsupported file format'])->setStatusCode(400);
	            }

				if (!empty($batchData)) {
	                $this->Custom_model->batch_insert('tbl_wkonwk_temp_space', $batchData);
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
		catch (\Exception $e) {
	        return $this->response->setJSON(['message' => 'Error: ' . $e->getMessage()]);
	    }
	}

	public function fetchTempWeekOnWeekData(){
		$page = $this->request->getGet('page') ?? 1;
		$limit = $this->request->getGet('limit') ?? 1000;
		$file_name = $this->request->getGet('file_name');
		$year = $this->request->getGet('year');
		$week = $this->request->getGet('week');

		$result = $this->Global_model->fetch_wkonwk_data($limit, $page, $file_name, $this->session->get('sess_uid'), $year, $week);
		return $this->response->setJSON([
			"success" => true,
			"data" => $result['data'],
			"totalRecords" => $result['totalRecords']
		]);
	}

	public function deleteTempWeekOnWeekData(){
		$year = $this->request->getPost('year');
		$week = $this->request->getPost('week');
		$result = $this->Global_model->delete_temp_wkonwk($this->session->get('sess_uid'), $year, $week);
		echo $result;
	}

	public function updateAggregatedWoWData()
	{
	    $dataHeaderId = $this->request->getPost('data_header_id');
	    $week = $this->request->getPost('week');
	    $year = $this->request->getPost('year');

	    $refresher = new Sync_model();

	    if (!empty($dataHeaderId) && !empty($week) && !empty($year)) {
	        $result = $refresher->refreshVmiWoWData($dataHeaderId, $week, $year);

	        return $this->response->setJSON([
	            'status' => 'success',
	            'message' => 'Refresh completed',
	            'results' => $result
	        ]);
	    }

	    return $this->response->setJSON([
	        'status' => 'error',
	        'message' => 'Missing parameters: data_header_id, week, or year',
	        'results' => []
	    ]);
	}

	public function printWeekOnWeekData()
	{
		$id = $this->request->getGet('selected_id');

		$header_tbl_name = "'tbl_week_on_week_header a'";
		$header_join = "'LEFT JOIN tbl_year b on a.year = b.id left join cms_users c on a.created_by = c.id'";
		$header_table_fields = "'a.id, b.year, c.username, a.created_date, a.week, a.file_name'";
		$header_limit = 1;
		$header_offset = 0;
		$header_conditions = "'a.id:EQ=$id'";
		$header_order = "''";
		$header_group = "''";

		$header_result = $this->Global_model->dynamic_search(
			$header_tbl_name,
			$header_join,
			$header_table_fields,
			$header_limit,
			$header_offset,
			$header_conditions,
			$header_order,
			$header_group
		);

		$tbl_name = "'tbl_week_on_week_details'";
		$join = "''";
		$table_fields = "'item, item_name, label_type, status, item_class, pog_store, quantity, soh, ave_weekly_sales, weeks_cover'";
		$limit = 1000;
		$offset = 0;
		$conditions = "'header_id:EQ=$id'";
		$order = "''";
		$group = "''";

		$result = $this->Global_model->dynamic_search(
			$tbl_name,
			$join,
			$table_fields,
			$limit,
			$offset,
			$conditions,
			$order,
			$group
		);

		$pdf = new \App\Libraries\TCPDFLib();
		$pageWidth = $pdf->getPageWidth();
		$pageMargin = $pdf->getMargins();
		$width = ($pageWidth - $pageMargin['left'] - $pageMargin['right']) / 7;

		$headerTitle = '';

		$pdf->AddPage();
		$pdf->SetFont('helvetica', 'B', 12);

		foreach ($header_result as $key => $value) {
			$pdf->MultiCell(500, 0, "Year: ".$value['year'], 0, '', false, 1, 10, 10);
			$pdf->MultiCell(500, 0, "Week: ".$value['week'], 0, '', false, 1, 10, 15);
			$pdf->MultiCell(500, 0, "Import Date: ".$value['created_date'], 0, '', false, 1, 10, 20);
			$pdf->MultiCell(500, 0, "Import File Name: ".$value['file_name'], 0, '', false, 1, 10, 25);
			$headerTitle = $value['file_name'];
		}

		$pdf->MultiCell($width, 10, "Item", 0, '', false, 1, 10, 35);
		$pdf->MultiCell($width, 10, "Item Name", 0, '', false, 1, 10 + ($width * 1), 35);
		$pdf->MultiCell($width, 10, "Label Type", 0, '', false, 1, 10 + ($width * 2), 35);
		$pdf->MultiCell($width, 10, "Status", 0, '', false, 1, 10 + ($width * 3), 35);
		$pdf->MultiCell($width, 10, "Item Class", 0, '', false, 1, 10 + ($width * 4), 35);
		$pdf->MultiCell($width, 10, "POG Store", 0, '', false, 1, 10 + ($width * 5), 35);
		$pdf->MultiCell($width, 10, "Quantity", 0, '', false, 1, 10 + ($width * 6), 35);
		$pdf->MultiCell($width, 10, "SOH", 0, '', false, 1, 10 + ($width * 6), 35);
		$pdf->MultiCell($width, 10, "Ave Weekly Sales", 0, '', false, 1, 10 + ($width * 6), 35);
		$pdf->MultiCell($width, 10, "Weeks Cover", 0, '', false, 1, 10 + ($width * 6), 35);

		$h = 45;
		$pdf->SetFont('helvetica', '', 9);
		foreach ($result as $key => $value) {
			$rowHeight = 10;
			
			if ($h + $rowHeight * 7 > $pdf->getPageHeight() - $pdf->getMargins()['bottom']) {
				$pdf->AddPage();
				$pdf->SetFont('helvetica', 'B', 12);

				foreach ($header_result as $key => $value) {
					$pdf->MultiCell(500, 0, "Year: ".$value['year'], 0, '', false, 1, 10, 10);
					$pdf->MultiCell(500, 0, "Week: ".$value['week'], 0, '', false, 1, 10, 15);
					$pdf->MultiCell(500, 0, "Import Date: ".$value['created_date'], 0, '', false, 1, 10, 20);
					$pdf->MultiCell(500, 0, "Import File Name: ".$value['file_name'], 0, '', false, 1, 10, 25);
				}

				$pdf->MultiCell($width, 10, "Item", 0, '', false, 1, 10, 35);
				$pdf->MultiCell($width, 10, "Item Name", 0, '', false, 1, 10 + ($width * 1), 35);
				$pdf->MultiCell($width, 10, "Label Type", 0, '', false, 1, 10 + ($width * 2), 35);
				$pdf->MultiCell($width, 10, "Status", 0, '', false, 1, 10 + ($width * 3), 35);
				$pdf->MultiCell($width, 10, "Item Class", 0, '', false, 1, 10 + ($width * 4), 35);
				$pdf->MultiCell($width, 10, "POG Store", 0, '', false, 1, 10 + ($width * 5), 35);
				$pdf->MultiCell($width, 10, "Quantity", 0, '', false, 1, 10 + ($width * 6), 35);
				$pdf->MultiCell($width, 10, "SOH", 0, '', false, 1, 10 + ($width * 6), 35);
				$pdf->MultiCell($width, 10, "Ave Weekly Sales", 0, '', false, 1, 10 + ($width * 6), 35);
				$pdf->MultiCell($width, 10, "Weeks Cover", 0, '', false, 1, 10 + ($width * 6), 35);

				$h = 30;
				$pdf->SetFont('helvetica', '', 9);
			}

			$pdf->MultiCell($width, $rowHeight, ($value['item'] ?? ''), 0, '', false, 1, 10, $h);
			$pdf->MultiCell($width, $rowHeight, ($value['item_name'] ?? ''), 0, '', false, 1, 10 + ($width * 1), $h);
			$pdf->MultiCell($width, $rowHeight, ($value['label_type'] ?? ''), 0, '', false, 1, 10 + ($width * 2), $h);
			$pdf->MultiCell($width, $rowHeight, ($value['status'] ?? ''), 0, '', false, 1, 10 + ($width * 3), $h);
			$pdf->MultiCell($width, $rowHeight, ($value['item_class'] ?? ''), 0, '', false, 1, 10 + ($width * 4), $h);
			$pdf->MultiCell($width, $rowHeight, ($value['pog_store'] ?? ''), 0, '', false, 1, 10 + ($width * 5), $h);
			$pdf->MultiCell($width, $rowHeight, ($value['quantity'] ?? ''), 0, '', false, 1, 10 + ($width * 6), $h);
			$pdf->MultiCell($width, $rowHeight, ($value['soh'] ?? ''), 0, '', false, 1, 10 + ($width * 6), $h);
			$pdf->MultiCell($width, $rowHeight, ($value['ave_weekly_sales'] ?? ''), 0, '', false, 1, 10 + ($width * 6), $h);
			$pdf->MultiCell($width, $rowHeight, ($value['weeks_cover'] ?? ''), 0, '', false, 1, 10 + ($width * 6), $h);

			$h += $rowHeight * 2;
		}

		$currentDateTime = date('Y-m-d H:i:s');
		$pdf->Output("Sales File - {$headerTitle} - {$currentDateTime}.pdf", 'D');
		exit;
	}
}