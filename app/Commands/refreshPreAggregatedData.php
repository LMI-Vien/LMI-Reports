<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\Sync_model;

class refreshPreAggregatedData extends BaseCommand
{
    protected $group       = 'custom';
    protected $name        = 'refresh:preaggregated';
    protected $description = 'Refresh VMI or Scan data in batches';

    public function run(array $params)
    {
        $type = $params[0] ?? 'all';
        $refresher = new Sync_model();
        set_time_limit(0);

        if ($type === 'scan') {
            CLI::write('Refreshing Scan Data...', 'yellow');
            $scan = $refresher->refreshScanData();
            CLI::write('Scan records inserted: ' . $scan['total_inserted'], 'green');
        } elseif ($type === 'vmi') {
            CLI::write('Refreshing VMI Data...', 'yellow');
            $vmi = $refresher->refreshVmiData();
            CLI::write('VMI records inserted: ' . $vmi['total_inserted'], 'green');
        } else {
            CLI::write('Refreshing All Data...', 'yellow');
            $all = $refresher->refreshAll();
            CLI::write('Scan records inserted: ' . $all['scan']['total_inserted'], 'green');
            CLI::write('VMI records inserted: ' . $all['vmi']['total_inserted'], 'green');
        }

        CLI::write('Data refresh complete!', 'green');
    }
}
