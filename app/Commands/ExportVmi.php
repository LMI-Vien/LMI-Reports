<?php
namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\Global_model;
use ZipArchive;

class ExportVmi extends BaseCommand
{
    protected $group       = 'custom';
    protected $name        = 'export:vmi';
    protected $description = 'Export VMI data to CSV and zip it if large';

    public function run(array $params)
    {
        $cleanForCsv = function ($value) {
            return preg_replace('/[\x00-\x1F\x7F]/u', '', $value);
        };

        $company  = $params[0] ?? null;
        $year     = $params[1] ?? null;
        $week     = $params[2] ?? null;
        $zipFile  = $params[3] ?? ('vmi_export_' . date('Ymd_His') . '.zip');

        $query = ($company && $year && $week)
            ? "v.year = {$year} AND v.week = {$week} AND v.company = {$company}"
            : "v.id >= 1";

        $select = "v.item, v.item_name, v.vmi_status, v.item_class, v.supplier, v.c_group, v.dept, v.c_class, v.sub_class, v.on_hand, v.in_transit, v.average_sales_unit, s.description as store_name, s.code as store_code";

        $join = [[
            'table' => 'tbl_store s',
            'query' => 'v.store = s.id',
            'type'  => 'left'
        ]];

        $exportPath = WRITEPATH . 'exports';
        if (!is_dir($exportPath)) {
            mkdir($exportPath, 0777, true);
        }

        $model = new Global_model();
        $batchSize = 1000000;
        $offset = 0;
        $part = 1;
        $csvFiles = [];

        do {
            $batch = $model->get_data_list("tbl_vmi v", $query, $batchSize, $offset, $select, "v.year", "desc", $join, null);
            if (!$batch) break;

            $partFilename = str_replace('.zip', '', $zipFile) . "_part{$part}.csv";
            $filePath = $exportPath . DIRECTORY_SEPARATOR . $partFilename;
            $handle = fopen($filePath, 'w');
            fwrite($handle, "\xEF\xBB\xBF"); // UTF-8 BOM

            // Write headers
            $headers = ['Store Code', 'Store Name', 'Item', 'Item Name', 'VMI Status', 'Item Class', 'Supplier', 'Group', 'Dept', 'Class', 'Sub Class', 'On Hand', 'In Transit', 'Ave Sales Unit'];
            fputcsv($handle, $headers);

            foreach ($batch as $row) {
                fputcsv($handle, array_map($cleanForCsv, [
                    $row->store_code,
                    $row->store_name,
                    $row->item,
                    $row->item_name,
                    $row->vmi_status,
                    $row->item_class,
                    $row->supplier,
                    $row->c_group,
                    $row->dept,
                    $row->c_class,
                    $row->sub_class,
                    $row->on_hand,
                    $row->in_transit,
                    $row->average_sales_unit,
                ]));
            }

            fclose($handle);
            $csvFiles[] = $filePath;

            $offset += $batchSize;
            $part++;
            unset($batch);
            gc_collect_cycles();

        } while (true);

        // Create ZIP
        $zipPath = $exportPath . DIRECTORY_SEPARATOR . $zipFile;
        $zip = new ZipArchive();

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($csvFiles as $csv) {
                $zip->addFile($csv, basename($csv));
            }
            $zip->close();

            // Clean up CSV parts after zipping
            foreach ($csvFiles as $csv) {
                unlink($csv);
            }

            CLI::write("Export completed: {$zipFile}", 'green');
        } else {
            CLI::error("Failed to create ZIP file: {$zipPath}");
        }
    }
}
