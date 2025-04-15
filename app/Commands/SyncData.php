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

        // Define parameters per method
        $methodParams = [
            'syncDataPriceCodeLMI'       => [5000, 'Watsons Personal Inc'],
            'syncDataPriceCodeRGDI'      => [5000, 'Watsons Personal Inc'],
            'syncDataitemfileLMI'        => [5000, 'Inventory', ['Packaging Materials']],
            'syncDataitemfileRGDI'       => [5000, 'Inventory', ['Packaging Materials']],
            'syncCusPaymentGroupRgdiData'=> [5000, 'Watsons Personal Inc'],
            'syncCusPaymentGroupLmiData' => [5000, 'Watsons Personal Inc'],
            'syncCustomerLmiData'        => [5000, 'Watsons Personal Inc'],
            'syncCustomerRgdiData'       => [5000, 'Watsons Personal Inc']
            // Methods like syncBrandData, syncClassificationData don't require parameters
        ];

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
