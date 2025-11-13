<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MigrateVMIToClickhouse extends BaseCommand
{
    protected $group       = 'Custom';
    protected $name        = 'migrate:vmi';
    protected $description = 'Migrates VMI data from MariaDB to ClickHouse using a Python script.';
    protected $options = [
        'year',
        'week',
        'company'
    ];

    //to run php spark migrate:vmi --year 2 --week 4 --company 2    

    public function run(array $params)
    {
        $year = CLI::getOption('year');
        $company = CLI::getOption('company');
        $week = CLI::getOption('week');
        // print_r($week);
        // die();

        $pythonScript = FCPATH . '../migrate_vmi_clickhouse.py';

        $cmd = "python3 " . escapeshellarg($pythonScript);

        if ($year) $cmd .= " --year " . escapeshellarg($year);
        if ($week) $cmd .= " --week " . escapeshellarg($week);
        if ($company) $cmd .= " --company " . escapeshellarg($company);

        CLI::write("🚀 Running VMI migration: $cmd", 'yellow');

        passthru($cmd, $returnVar);

        CLI::write("Migration finished with status code: $returnVar", 'green');

    }
}
