<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Newfile extends BaseController
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
			"title"         =>  "Newfile",
			"description"   =>  "Newfile",
			"keyword"       =>  ""
		);
		$data['title'] = "Newfile";
		$data['PageName'] = 'Newfile';
		$data['PageUrl'] = 'Newfile';
		$data['buttons'] = [];
		$data['content'] = "cms/newfile/newfile.php";
		$data['session'] = session(); //for frontend accessing the session data
		$data['js'] = array(
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
			$header_id = $this->request->getPost('header_id');
			$month = $this->request->getPost('month');
			$year = $this->request->getPost('year');
			$customer_payment_group = $this->request->getPost('customer_payment_group');
			$template_id = $this->request->getPost('template_id');

			if (!$file) {
				return $this->response->setJSON(['message' => 'No file received.']);
			}
			
			log_message('debug', 'Chunk file received: ' . $file->getName());

			$tempDir = WRITEPATH . 'uploads/temp_chunks/';
			
			$tempFilePath = $tempDir . $fileName . "_part_" . $chunkIndex;
			$file->move($tempDir, $fileName . "_part_" . $chunkIndex);

			if (!file_exists($tempFilePath)) {
				log_message('error', "Chunk not saved: $tempFilePath");
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

				if (true) {
					$reader = IOFactory::createReaderForFile($finalFilePath);
	                $reader->setReadDataOnly(true);
	                $spreadsheet = $reader->load($finalFilePath);
	                $worksheet = $spreadsheet->getActiveSheet();
	                $rows = $worksheet->toArray();

	                array_shift($rows); 

	                foreach ($rows as $index => $row) {
						$row = array_pad($row, 8, null);

						if ($index >= 5) {
							$linenum = $index-4;
							$batchData[] = [
								'created_date' => date('Y-m-d H:i:s'),
								'created_by' => $this->session->get('sess_uid'),
								'stuff' => $linenum."_stuff",
								'data_header_id' => $header_id,
								'month' => $month,
								'year' => $year,
								'customer_payment_group' => $customer_payment_group,
								'template_id' => $template_id,
								'file_name' => $fileName,
								'line_number' => $linenum,
								'store_code' => trim($row[1] ?? null),
								'store_description' => trim($row[2] ?? null),
								'sku_code' => trim($row[3] ?? null),
								'sku_description' => trim($row[4] ?? null),
								'gross_sales' => trim($row[5] ?? null),
								'quantity' => trim($row[6] ?? null),
								'net_sales' => trim($row[7] ?? null),
							];
							
							if (count($batchData) === $batchSize) {
								$this->Custom_model->batch_insert('tbl_sell_out_temp_space', $batchData);
								$totalInserted += count($batchData);
								$batchData = [];
							}
						}
					}
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
		$file_name = $this->request->getPost('file_name');
		$result = $this->Global_model->delete_temp_scan($this->session->get('sess_uid'), $file_name);
		echo $file_name;
	}

}
