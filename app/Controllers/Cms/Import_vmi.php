<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Import_vmi extends BaseController
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

    // public function import()
    // {
    //     helper(['form', 'filesystem']);

    //     $file = $this->request->getFile('file');

    //     if (!$file || !$file->isValid()) {
    //         return $this->respond(['status' => 'error', 'message' => 'Invalid file upload.'], 400);
    //     }

    //     // Read Excel File
    //     $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getTempName());
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $data = $sheet->toArray(null, true, true, true); // Converts to an array

    //     if (empty($data)) {
    //         return $this->respond(['status' => 'error', 'message' => 'File contains no data.'], 400);
    //     }

    //     // Validate and Process Data
    //     $response = $this->validateAndProcessData($data);

    //     return $this->respond($response);
    // }

public function import_testing()
{
    try {
        $file = $this->request->getFile('file');
        $chunkIndex = $this->request->getPost('chunkIndex');
        $totalChunks = $this->request->getPost('totalChunks');
        $fileName = $this->request->getPost('fileName');

        if (!$file->isValid()) {
            return $this->response->setJSON(['message' => 'Invalid file'])->setStatusCode(400);
        }

        // Temporary storage for chunks
        $tempDir = WRITEPATH . 'uploads/temp_chunks/';
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        // Save each chunk to a temporary file
        $tempFilePath = $tempDir . $fileName . "_part_" . $chunkIndex;
        $file->move($tempDir, $fileName . "_part_" . $chunkIndex);

        // If all chunks are received, merge them
        if ($chunkIndex + 1 == $totalChunks) {
            $finalFilePath = $tempDir . $fileName;
            $finalFile = fopen($finalFilePath, 'wb');

            for ($i = 0; $i < $totalChunks; $i++) {
                $chunkPath = $tempDir . $fileName . "_part_" . $i;
                $chunkContent = file_get_contents($chunkPath);
                fwrite($finalFile, $chunkContent);
                unlink($chunkPath); // Delete chunk after merging
            }

            fclose($finalFile);

            // Process CSV or Excel file after merging (STREAMING)
            $batchSize = 20000;
            $batchData = [];
            $totalInserted = 0;

            if (str_ends_with($fileName, '.csv')) {
                // ✅ Stream CSV Processing (doesn't load full file into memory)
                $handle = fopen($finalFilePath, 'r');
                if ($handle !== false) {
                    $headerSkipped = false; // Ensure first row (header) is skipped
                    while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                        if (!$headerSkipped) {
                            $headerSkipped = true;
                            continue; // Skip the first row (header)
                        }

                        // Ensure row has exactly 13 columns
                        $row = array_pad($row, 13, null);

                        $batchData[] = [
                            'store' => trim($row[0] ?? null),
                            'item' => trim($row[1] ?? null),
                            'item_name' => trim($row[2] ?? null),
                            'vmi_status' => trim($row[3] ?? null),
                            'item_class' => trim($row[4] ?? null),
                            'supplier' => trim($row[5] ?? null),
                            'group' => trim($row[6] ?? null),
                            'dept' => trim($row[7] ?? null),
                            'class' => trim($row[8] ?? null),
                            'sub_class' => trim($row[9] ?? null),
                            'on_hand' => is_numeric($row[10]) ? $row[10] : null,
                            'in_transit' => is_numeric($row[11]) ? $row[11] : null,
                            'average_sales_unit' => is_numeric($row[12]) ? $row[12] : null
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
                // ✅ Stream Excel Processing
                $reader = IOFactory::createReaderForFile($finalFilePath);
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($finalFilePath);
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();

                array_shift($rows); // Remove header

                foreach ($rows as $row) {
                    // Ensure row has exactly 13 columns
                    $row = array_pad($row, 13, null);

                    $batchData[] = [
                        'store' => trim($row[0] ?? null),
                        'item' => trim($row[1] ?? null),
                        'item_name' => trim($row[2] ?? null),
                        'vmi_status' => trim($row[3] ?? null),
                        'item_class' => trim($row[4] ?? null),
                        'supplier' => trim($row[5] ?? null),
                        'group' => trim($row[6] ?? null),
                        'dept' => trim($row[7] ?? null),
                        'class' => trim($row[8] ?? null),
                        'sub_class' => trim($row[9] ?? null),
                        'on_hand' => is_numeric($row[10]) ? $row[10] : null,
                        'in_transit' => is_numeric($row[11]) ? $row[11] : null,
                        'average_sales_unit' => is_numeric($row[12]) ? $row[12] : null
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

            unlink($finalFilePath); // Delete the merged file after processing

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



	public function import()
	{
	    helper(['form', 'filesystem']);

	    $file = $this->request->getFile('file');
	    if (!$file || !$file->isValid()) {
	        return $this->respond(['status' => 'error', 'message' => 'Invalid file upload.'], 400);
	    }

	    // Read Excel File
	    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getTempName());
	    $sheet = $spreadsheet->getActiveSheet();
	    $data = $sheet->toArray(null, true, true, true); // Converts to an array

	    if (empty($data)) {
	        return $this->respond(['status' => 'error', 'message' => 'File contains no data.'], 400);
	    }

	    // Process in Chunks
	    $batchSize = 5000; // Process 10,000 rows at a time
	    $chunks = array_chunk($data, $batchSize);
	    
	    foreach ($chunks as $chunk) {
	        $response = $this->validateAndProcessData($chunk);
	        
	        if ($response['status'] === 'error') {
	            return $this->respond($response);
	        }
	    }

	    return $this->respond(['status' => 'success', 'message' => 'Data imported successfully!']);
	}

	private function validateAndProcessData($data)
	{
	    $validData = [];
	    $errors = [];
	    $itemsToCheck = [];
	    $lineNumber = 1;

	    foreach ($data as $row) {
	        $lineNumber++;
	        $rowData = [
	            'store'        => trim($row['A'] ?? ''),
	            'item'         => trim($row['B'] ?? ''),
	            'item_name'    => trim($row['C'] ?? ''),
	            'vmi_status'   => strtolower(trim($row['D'] ?? '')),
	            'item_class'   => trim($row['E'] ?? ''),
	            'supplier'     => trim($row['F'] ?? ''),
	            'group'        => trim($row['G'] ?? ''),
	            'dept'         => trim($row['H'] ?? ''),
	            'class'        => trim($row['I'] ?? ''),
	            'sub_class'    => trim($row['J'] ?? ''),
	            'on_hand'      => trim($row['K'] ?? ''),
	            'in_transit'   => trim($row['L'] ?? ''),
	            'ave_sales_unit' => trim($row['M'] ?? ''),
	            'created_by'   => trim($row['N'] ?? ''),
	            'created_date' => trim($row['O'] ?? '')
	        ];

	        // Collect items to check existence in database
	        $itemsToCheck[] = $rowData['item'];

	        // Validate Data (Minimal validation to avoid slow loops)
	        if (empty($rowData['store']) || empty($rowData['item']) || empty($rowData['item_name']) || !is_numeric($rowData['supplier'])) {
	            $errors[] = "⚠️ Invalid data at line #$lineNumber";
	        }

	        if (empty($errors)) {
	            $validData[] = $rowData;
	        }
	    }

	    if (!empty($errors)) {
	        return ['status' => 'error', 'errors' => $errors];
	    }
	    print_r($validData);
	    die();

	    // // Check for existing items in one query
	    // $existingItems = $this->globalModel->getExistingItems('tbl_vmi', 'item', $itemsToCheck);

	    // $insertData = [];
	    // $updateData = [];
	    // foreach ($validData as $row) {
	    //     if (in_array($row['item'], $existingItems)) {
	    //         $updateData[] = $row;
	    //     } else {
	    //         $insertData[] = $row;
	    //     }
	    // }

	    // // Batch Insert
	    // if (!empty($insertData)) {
	    //     $this->customModel->batch_insert('tbl_vmi', $insertData, false);
	    // }

	    // // Batch Update
	    // if (!empty($updateData)) {
	    //     $this->globalModel->batch_update('tbl_vmi', $updateData, 'item', false, array_column($updateData, 'item'));
	    // }

	    return ['status' => 'success'];
	}

	public function fetch_temp_vmi_data(){
		    $page = $this->request->getGet('page') ?? 1;
    		$limit = $this->request->getGet('limit') ?? 1000;
    		$result = $this->Global_model->fetch_temp_data($limit, $page);
 			// print_r($result);
 			// die();
		    return $this->response->setJSON([
		        "success" => true,
		        "data" => $result['data'],
		        "totalRecords" => $result['totalRecords']
		    ]);
	}


}
