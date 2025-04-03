<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\Dashboard_model;

class refreshPreAggregatedData extends BaseCommand
{
    protected $group       = 'custom';
    protected $name        = 'refresh:preaggregated';
    protected $description = 'Refresh data into tbl_vmi_pre_aggregated_data in batches';

    public function run(array $params)
    {
        $model = new Dashboard_model();
        CLI::write('Starting data refresh...', 'yellow');
        set_time_limit(0);
        $result = $model->refreshPreAggregatedData();

        CLI::write('Total records inserted: ' . $result['total_inserted'], 'green');
        CLI::write('Data inserted successfully!', 'green');
    }
}
