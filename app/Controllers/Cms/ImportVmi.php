<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Sync_model;

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
		$data['buttons'] = ['search', 'import', 'export'];
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
			"title"         =>  "Import VMI",
			"description"   =>  "Import VMI",
			"keyword"       =>  ""
		);
		$data['title'] = "Import VMI";
		$data['PageName'] = 'Import VMI';
		$data['PageUrl'] = 'Import VMI';
		$data['content'] = "cms/import/vmi/view_vmi.php";
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
	                            // 'month' => $month,
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
	                            // 'month' => $month,
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
    		// $month = $this->request->getGet('inp_month') ?? '';
    		$week = $this->request->getGet('inp_week') ?? '';
    		$company = $this->request->getGet('inp_company') ?? '';

    		// $result = $this->Global_model->fetch_temp_data($limit, $page, $year, $month, $week, $company, $this->session->get('sess_uid'));
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

}
