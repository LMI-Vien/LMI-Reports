<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MigrateSellOutToClickhouse extends BaseCommand
{
    protected $group       = 'Custom';
    protected $name        = 'migrate:sellout';
    protected $description = 'Migrates sell-out data from MariaDB to ClickHouse using a Python script.';
    protected $options = [
        'year',
        'company',
        'month',
        'payment_group'
    ];
    //to run php spark migrate:sellout --year 2025 --company 2 --month 2 --payment_group "Watsons Personal Care Stores (Philippines) Inc."

    public function run(array $params)
    {
        $year = CLI::getOption('year');
        $company = CLI::getOption('company');
        $month = CLI::getOption('month');
        $paymentGroup = CLI::getOption('payment_group');

        $pythonScript = FCPATH . '../migrate_sellout_clickhouse.py';

        $cmd = "python3 " . escapeshellarg($pythonScript);

        if ($year) $cmd .= " --year " . escapeshellarg($year);
        if ($company) $cmd .= " --company " . escapeshellarg($company);
        if ($month) $cmd .= " --month " . escapeshellarg($month);
        if ($paymentGroup) $cmd .= " --payment_group " . escapeshellarg($paymentGroup);

        CLI::write("🚀 Running migration: $cmd", 'yellow');
        passthru($cmd, $returnVar);
        CLI::write("Migration finished with status code: $returnVar", 'green');
    }
}
