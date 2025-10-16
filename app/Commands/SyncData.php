<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\Sync_model;
use Config\Database;

class SyncData extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'custom';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'sync:data';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Synchronizes data asynchronously.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'command:name [arguments] [options]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $syncModel = new Sync_model();
        $db = Database::connect();

        $methodParams = [
            'syncDataPriceCodeLMI'       => ['Watsons', 5000],
            'syncDataPriceCodeRGDI'      => ['Watsons', 5000],
            'syncDataitemfileLMI'        => ['Inventory', ['Packaging Materials'], 5000],
            'syncDataitemfileRGDI'       => ['Inventory', ['Packaging Materials'], 5000],
            'syncBrandData'              => [5000],
            'syncBrandLabelData'         => [5000],
            'syncBrandTermData'         => [5000],
            'syncClassificationData'     => [5000],
            'syncSubClassificationData'  => [5000],
            'syncDeptData'               => [5000],
            'syncMerchData'              => [5000],
            'syncCusPaymentGroupRgdiData'=> ['Watsons Personal Care Stores', 5000],
            'syncCusPaymentGroupLmiData' => ['Watsons Personal Care Stores', 5000],
            'syncCustomerLmiData'        => ['Watsons', 5000],
            'syncCustomerRgdiData'       => ['Watsons', 5000],
            'syncSalesFile2AllData' => [5000],
            'syncAllItemUnitFileLMIRGDIData' => [5000],
            'syncSalesFileConsignmentAllData' => [5000]

        ];

        $methods = [
            'syncDataPriceCodeLMI',
            'syncDataPriceCodeRGDI',
            'syncDataitemfileLMI',
            'syncDataitemfileRGDI',
            'syncBrandData',
            'syncBrandLabelData',
            'syncBrandTermData',
            'syncClassificationData',
            'syncSubClassificationData',
            'syncDeptData',
            'syncMerchData',
            'syncCusPaymentGroupRgdiData',
            'syncCusPaymentGroupLmiData',
            'syncCustomerLmiData',
            'syncCustomerRgdiData',         
            'syncSalesFile2AllData',
            'syncAllItemUnitFileLMIRGDIData',
            'syncSalesFileConsignmentAllData'


        ];

        $results = [];

        foreach ($methods as $index => $method) {
            $start_time = microtime(true);

            try {
                // Call with or without parameters
                if (isset($methodParams[$method])) {
                    $response = call_user_func_array([$syncModel, $method], $methodParams[$method]);
                } else {
                    $response = $syncModel->$method();
                }

                $status = 'success';
                $errorMessage = null;
            } catch (\Exception $e) {
                $status = 'error';
                $response = null;
                $errorMessage = $e->getMessage();
            }

            $end_time = microtime(true);
            $execution_time = round($end_time - $start_time, 4);

            $db->table('tbl_sync_logs')->insert([
                'method'         => $method,
                'response'       => json_encode($response),
                'execution_time' => $execution_time,
                'sync_date'      => date('Y-m-d H:i:s'),
            ]);

            $results["message" . ($index + 1)] = $status === 'success' ? $response : "Error: $errorMessage";

            if ($status === 'success') {
                CLI::write("$method completed in $execution_time sec", 'green');
            } else {
                CLI::write("$method failed: $errorMessage", 'red');
            }
        }

        CLI::write("Data Sync Completed!", 'green');
    }

}
