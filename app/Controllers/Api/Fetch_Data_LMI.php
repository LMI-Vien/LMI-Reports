<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Sync_model;
use CodeIgniter\RESTful\ResourceController;
use Config\Database;

class Fetch_Data_LMI extends BaseController
{
	use ResponseTrait;
    protected $session;
    private $auth_token;
    protected $db;
    public function __construct()
	{
	    $this->session = session();
	    $this->auth_token = getenv('API_AUTH_TOKEN');
        helper('url');
	}

    private function check_token()
    {
        $request_token = $this->request->getHeaderLine('Authorization');

        if ($request_token !== $this->auth_token) {
            return $this->failUnauthorized('Invalid or missing token.');
        }

        return true;
    }

    public function SyncData(){
        $Sync_model = new Sync_model();
        $db = \Config\Database::connect();
        $methods = [
            'syncDataPriceCodeLMI',
            'syncDataPriceCodeRGDI',
            'syncDataitemfileLMI',
            'syncDataitemfileRGDI',
            'syncBrandData',
            'syncClassificationData',
            'syncCusPaymentGroupRgdiData',
            'syncCusPaymentGroupLmiData',
            'syncCustomerLmiData',
            'syncCustomerRgdiData'
        ];

        $results = [];
        foreach ($methods as $index => $method) {
            $start_time = microtime(true);
            $response = $Sync_model->$method();
            $end_time = microtime(true);
            $execution_time = round($end_time - $start_time, 4);

            $db->table('tbl_sync_logs')->insert([
                'method' => $method,
                'response' => json_encode($response),
                'execution_time' => $execution_time,
                'sync_date' => date('Y-m-d H:i:s'),
            ]);

            $results["message" . ($index + 1)] = $response;
    }

        return $this->respond($results);
    }
}
