<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Sync_model;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ImportVmi extends BaseController
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
			"title"         =>  "Import VMI",
			"description"   =>  "Import VMI",
			"keyword"       =>  ""
		);
		$data['title'] = "Import VMI";
		$data['PageName'] = 'Import VMI';
		$data['PageUrl'] = 'Import VMI';
		$data['content'] = "cms/import/vmi/vmi.php";
		$data['buttons'] = ['import', 'search'];
		$latestVmiData = $this->Dashboard_model->getLatestVmi();
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
        		"assets/cms/css/main_style.css",
        		"assets/css/style.css"
                    );
		return view("cms/layout/template", $data);		
	}
	public function view()
	{

		$uri = current_url(true);
		$data['uri'] =$uri;

		$data['meta'] = array(
			"title"         =>  "Import VMI",
			"description"   =>  "Import VMI",
			"keyword"       =>  ""
		);
		$data['title'] = "Import VMI";
		$data['PageName'] = 'Import VMI';
		$data['PageUrl'] = 'Import VMI';
		$data['content'] = "cms/import/vmi/view_vmi.php";
		$data['buttons'] = ['search'];
		$data['session'] = session();

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
        		"assets/cms/css/main_style.css",
        		"assets/css/style.css"
                    );
		return view("cms/layout/template", $data);		
	}

	public function import_temp_vmi_data()
	{
	    try {
	        $file = $this->request->getFile('file');
	        $chunkIndex = $this->request->getPost('chunkIndex');
	        $totalChunks = $this->request->getPost('totalChunks');
	        $fileName = $this->request->getPost('fileName');
	        $year = $this->request->getPost('inp_year');
	        // $month = $this->request->getPost('inp_month');
	        $week = $this->request->getPost('inp_week');
	        $company = $this->request->getPost('inp_company');

	        if (!$file->isValid()) {
	            return $this->response->setJSON(['message' => 'Invalid file'])->setStatusCode(400);
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
	                    while (($row = fgetcsv($handle, 1000, ",")) !== false) {
	                        if (!$headerSkipped) {
	                            $headerSkipped = true;
	                            continue; 
	                        }
	                        $row = array_pad($row, 13, null);

	                        $batchData[] = [
	                            'store' => trim($row[0] ?? null),
	                            'item' => trim($row[1] ?? null),
	                            'item_name' => trim($row[2] ?? null),
	                            'vmi_status' => trim($row[3] ?? null),
	                            'item_class' => trim($row[4] ?? null),
	                            'supplier' => trim($row[5] ?? null),
	                            'group' => trim($row[6] ?? 0),
	                            'dept' => trim($row[7] ?? 0),
	                            'class' => trim($row[8] ?? 0),
	                            'sub_class' => trim($row[9] ?? 0),
	                            'on_hand' => trim($row[10]) ? $row[10] : 0,
	                            'in_transit' => trim($row[11]) ? $row[11] : 0,
	                            'average_sales_unit' => trim($row[12]) ? $row[12] : 0.00,
	                            'year' => $year,
	                            'week' => $week,
	                            'company' => $company,
	                            'created_date' => date('Y-m-d H:i:s'),
	                            'created_by' => $this->session->get('sess_uid')
	                        ];

	                        if (count($batchData) === $batchSize) {
	                            $this->Custom_model->batch_insert('tbl_temp_vmi', $batchData);
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

	                foreach ($rows as $row) {
	                    $row = array_pad($row, 13, null);
	                    $batchData[] = [
	                            'store' => trim($row[0] ?? null),
	                            'item' => trim($row[1] ?? null),
	                            'item_name' => trim($row[2] ?? null),
	                            'vmi_status' => trim($row[3] ?? null),
	                            'item_class' => trim($row[4] ?? null),
	                            'supplier' => trim($row[5] ?? null),
	                            'group' => trim($row[6] ?? 0),
	                            'dept' => trim($row[7] ?? 0),
	                            'class' => trim($row[8] ?? 0),
	                            'sub_class' => trim($row[9] ?? 0),
	                            'on_hand' => trim($row[10]) ? $row[10] : 0,
	                            'in_transit' => trim($row[11]) ? $row[11] : 0,
	                            'average_sales_unit' => trim($row[12]) ? $row[12] : 0.00,
	                            'year' => $year,
	                            'week' => $week,
	                            'company' => $company,
	                            'created_date' => date('Y-m-d H:i:s'),
	                            'created_by' => $this->session->get('sess_uid')
	                    ];

	                    if (count($batchData) === $batchSize) {
	                        $this->Custom_model->batch_insert('tbl_temp_vmi', $batchData);
	                        $totalInserted += count($batchData);
	                        $batchData = [];
	                    }
	                }
	            } else {
	                return $this->response->setJSON(['message' => 'Unsupported file format'])->setStatusCode(400);
	            }

	            if (!empty($batchData)) {
	                $this->Custom_model->batch_insert('tbl_temp_vmi', $batchData);
	                $totalInserted += count($batchData);
	            }

	            unlink($finalFilePath);

	            return $this->response->setJSON([
	                'message' => 'Upload and processing successful',
	                'total_inserted' => $totalInserted
	            ]);
	        }

	        return $this->response->setJSON([
	            'message' => 'Chunk uploaded successfully',
	            'chunkIndex' => $chunkIndex,
	            'totalChunks' => $totalChunks
	        ]);
	    } catch (Exception $e) {
	        return $this->response->setJSON(['message' => 'Error: ' . $e->getMessage()]);
	    }
	}

	public function fetch_temp_vmi_data(){
		    $page = $this->request->getGet('page') ?? 1;
    		$limit = $this->request->getGet('limit') ?? 1000;
    		$year = $this->request->getGet('inp_year') ?? '';
    		$week = $this->request->getGet('inp_week') ?? '';
    		$company = $this->request->getGet('inp_company') ?? '';

    		$result = $this->Global_model->fetch_temp_data($limit, $page, $year, $week, $company, $this->session->get('sess_uid'));
		    return $this->response->setJSON([
		        "success" => true,
		        "data" => $result['data'],
		        "totalRecords" => $result['totalRecords']
		    ]);
	}

	public function delete_temp_vmi_data(){
		$result = $this->Global_model->delete_temp_vmi($this->session->get('sess_uid'));
		echo $result;
	}

	public function update_aggregated_vmi_data()
	{
	    $week = $this->request->getPost('week');
	    $company = $this->request->getPost('company');
	    $year = $this->request->getPost('year');

	    $refresher = new Sync_model();

	    if (!empty($week) && !empty($company) && !empty($year)) {
	        $result = $refresher->refreshVmiData($week, $year, $company);

	        return $this->response->setJSON([
	            'status' => 'success',
	            'message' => 'Refresh completed',
	            'results' => $result
	        ]);
	    }

	    return $this->response->setJSON([
	        'status' => 'error',
	        'message' => 'Missing parameters: week, company, or year',
	        'results' => []
	    ]);
	}

	public function generateExcel()
	{

	    $company = $this->request->getPost('company');
	    $year = $this->request->getPost('year');
	    $week = $this->request->getPost('week');
	    $filename = 'vmi_export_' . date('Ymd_His') . '.zip';
	    session()->set('pending_export_file', $filename);
	    // Clean up old logs
    	$this->cleanupLogs();
	    $sparkPath = escapeshellarg(ROOTPATH . 'spark'); 

	    $cmd = "php {$sparkPath} export:vmi {$company} {$year} {$week} {$filename}";
	    // Temporarily disable logging
	    $log = WRITEPATH . 'logs/export_' . time() . '.log';
	    exec("nohup $cmd > $log 2>&1 &");
	    return $this->response->setJSON([
	        'status' => 'started',
	        'filename' => $filename
	    ]);
	}

	private function cleanupLogs()
	{
	    $logDir = WRITEPATH . 'logs/';
	    $logFiles = glob($logDir . 'export_*.log');

	    foreach ($logFiles as $file) {
	        //if (filemtime($file) < time() - 2 * 24 * 60 * 60) {
	            unlink($file);
	        //}
	    }
	}

    public function check($filename)
    {
        $path = WRITEPATH . 'exports/' . $filename;
        return $this->response->setJSON([
            'ready' => file_exists($path)
        ]);
    }

	public function download($filename)
	{
	    $expected = session()->get('pending_export_file');

	    // if ($expected !== $filename) {
	    //     return $this->response->setStatusCode(403)->setBody('Unauthorized download attempt.');
	    // }

	    $path = WRITEPATH . 'exports/' . basename($filename);
	    if (!file_exists($path)) {
	        return $this->response->setStatusCode(404)->setBody('File not found.');
	    }

	    session()->remove('pending_export_file');

	    //$response = $this->response->download($path, null);
	    $response = $this->response
    		->setHeader('Content-Type', 'application/zip')
    		->download($path, null);

	    register_shutdown_function(function () use ($path) {
	        if (file_exists($path)) {
	            unlink($path);
	        }
	    });

	    return $response;
	}

	public function checkPendingDownload()
	{
	    $filename = session()->get('pending_export_file');

	    if ($filename && file_exists(WRITEPATH . 'exports/' . $filename)) {
	        // Clear the session flag once file exists
	        session()->remove('pending_export_file');
	        return $this->response->setJSON(['ready' => true, 'filename' => $filename]);
	    }

	    return $this->response->setJSON(['ready' => false]);
	}

	public function setHeaderCellValue(array $headers, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet, int $row = 1): void {
		foreach ($headers as $index => $header) {
			$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
			$sheet->setCellValue($colLetter . $row, $header);
		}
	}
	public function exportSpecific() {
		$company = $this->request->getPost('company') ?? '1';
		$year    = $this->request->getPost('year') ?? '1';
		$week    = $this->request->getPost('week') ?? '1';

		$select = '';
		$select .= 's.description, v.item, v.item_name, v.item_class, v.supplier, v.`c_group`, v.dept, v.c_class as classification, ';
		$select .= 'v.sub_class, v.on_hand, v.in_transit, v.average_sales_unit, v.company, v.vmi_status, v.year, v.week';
		$result = $this->Global_model->get_data_list(
			'tbl_vmi v', 
			"v.company = $company AND v.year = $year AND week = $week",
			999999999, 
			// 9,
			0, 
			$select,
			'', 
			'', 
			[
				[ 'table' => 'tbl_company c', 'query' => 'v.company = c.id', 'type' => 'left' ],
				[ 'table' => 'tbl_year y', 'query' => 'v.year = y.id', 'type' => 'left' ],
				[ 'table' => 'tbl_store s', 'query' => 's.id = v.store', 'type' => 'left' ]
			], 
			''
		);

		$spreadsheet = new Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'Company Name: Lifestrong Marketing Inc.');
		$sheet->setCellValue('A2', 'VMI');
		$sheet->setCellValue('A3', 'Date Printed: ' . (new \DateTime())->format('Y-m-d h:i A'));

		$header = [
			"Store", "Item", "Item Name", "VMI Status", "Item Class", "Supplier", "Group", "Dept",
			"Class", "Sub Class", "On Hand", "In Transit", "Ave Sales Unit"
		];
		$this->setHeaderCellValue($header, $sheet, 5);

		$currentRow = 6;

		foreach ($result as $value) {
			$header = [
				$value->description, $value->item, $value->item_name, $value->vmi_status, $value->item_class,
				$value->supplier, $value->c_group, $value->dept, $value->classification,
				$value->sub_class, $value->on_hand, $value->in_transit, $value->average_sales_unit
			];
			$this->setHeaderCellValue($header, $sheet, $currentRow);
			$currentRow++;
		}

		$title = "VMI";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}
}
