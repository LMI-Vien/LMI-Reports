<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Database;

class UpdateTradeDashboardOverallBa extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'overalldashboardba:update';
    protected $description = 'Updates the consolidated trade dashboard overall ba table';

    public function run(array $params)
    {
        $db = Database::connect();
        $db->query("TRUNCATE TABLE tbl_trade_db_overall_ba");
        $query = "
        INSERT INTO tbl_trade_db_overall_ba (
            area_id, area, store_code, store_name, actual_sales, asc_name, date, brands, possible_incentives, ly_scanned_data, brand_ambassador_name, ba_deployment_date, month_ts_per_store_january, month_ts_per_store_february, month_ts_per_store_march, month_ts_per_store_april, month_ts_per_store_may, month_ts_per_store_june, month_ts_per_store_july, month_ts_per_store_august, month_ts_per_store_september, month_ts_per_store_october, month_ts_per_store_november, month_ts_per_store_december, yr_ts_per_store, ly_month_sell_out, ly_year_sell_out
        )
        SELECT 
            aggregated_sps.area_id,
            tbl_area.description as area,
            tbl_store.code as store_code,
            tbl_store.description as store_name,
            aggregated_sps.actual_sales,
            tbl_area_sales_coordinator.description AS asc_name,
            aggregated_sps.date,
            GROUP_CONCAT(DISTINCT tbl_brand.brand_description ORDER BY tbl_brand.brand_description SEPARATOR ', ') AS brands,
            COALESCE(aggregated_sps.actual_sales, 0) * 0.01 AS possible_incentives,
            tbl_sell_out_data_details.net_sales AS ly_scanned_data,
            tbl_brand_ambassador.name AS brand_ambassador_name,
            tbl_brand_ambassador.deployment_date AS ba_deployment_date,
            -- ROUND(COALESCE(aggregated_sps.actual_sales, 0) / NULLIF(SUM(tbl_sell_out_data_details.net_sales), 0), 2) AS growth,
            COALESCE(SUM(tbl_target_sales_per_store.january), 0) AS month_ts_per_store_january,
            COALESCE(SUM(tbl_target_sales_per_store.february), 0) AS month_ts_per_store_february,
            COALESCE(SUM(tbl_target_sales_per_store.march), 0) AS month_ts_per_store_march,
            COALESCE(SUM(tbl_target_sales_per_store.april), 0) AS month_ts_per_store_april,
            COALESCE(SUM(tbl_target_sales_per_store.may), 0) AS month_ts_per_store_may,
            COALESCE(SUM(tbl_target_sales_per_store.june), 0) AS month_ts_per_store_june,
            COALESCE(SUM(tbl_target_sales_per_store.july), 0) AS month_ts_per_store_july,
            COALESCE(SUM(tbl_target_sales_per_store.august), 0) AS month_ts_per_store_august,
            COALESCE(SUM(tbl_target_sales_per_store.september), 0) AS month_ts_per_store_september,
            COALESCE(SUM(tbl_target_sales_per_store.october), 0) AS month_ts_per_store_october,
            COALESCE(SUM(tbl_target_sales_per_store.november), 0) AS month_ts_per_store_november,
            COALESCE(SUM(tbl_target_sales_per_store.december), 0) AS month_ts_per_store_december,
            tbl_target_sales_per_store.year AS yr_ts_per_store,
            tbl_sell_out_data_details.month AS ly_month_sell_out,
            tbl_sell_out_data_details.year AS ly_year_sell_out
        FROM (
            SELECT area_id, SUM(amount) AS actual_sales, date
            FROM tbl_ba_sales_report
            WHERE status = 1
            GROUP BY area_id
        ) AS aggregated_sps
        LEFT JOIN tbl_ba_sales_report ON aggregated_sps.area_id = tbl_ba_sales_report.area_id
        INNER JOIN tbl_store ON tbl_ba_sales_report.store_id = tbl_store.id
        INNER JOIN tbl_area ON tbl_ba_sales_report.area_id = tbl_area.id
        LEFT JOIN tbl_brand ON tbl_ba_sales_report.brand = tbl_brand.id
        LEFT JOIN tbl_area_sales_coordinator ON aggregated_sps.area_id = tbl_area_sales_coordinator.area_id
        LEFT JOIN tbl_target_sales_per_store ON tbl_ba_sales_report.store_id = tbl_target_sales_per_store.location
        INNER JOIN tbl_brand_ambassador ON tbl_ba_sales_report.ba_id = tbl_brand_ambassador.id
        LEFT JOIN tbl_sell_out_data_details ON tbl_store.code = tbl_sell_out_data_details.store_code
        GROUP BY aggregated_sps.area_id
        ON DUPLICATE KEY UPDATE
            actual_sales = VALUES(actual_sales),
            asc_name = VALUES(asc_name),
            date = VALUES(date),
            brands = VALUES(brands),
            possible_incentives = VALUES(possible_incentives),
            ly_scanned_data = VALUES(ly_scanned_data),
            brand_ambassador_name = VALUES(brand_ambassador_name),
            ba_deployment_date = VALUES(ba_deployment_date),
            -- growth = VALUES(growth),
            month_ts_per_store_january = VALUES(month_ts_per_store_january),
            month_ts_per_store_february = VALUES(month_ts_per_store_february),
            month_ts_per_store_march = VALUES(month_ts_per_store_march),
            month_ts_per_store_april = VALUES(month_ts_per_store_april),
            month_ts_per_store_may = VALUES(month_ts_per_store_may),
            month_ts_per_store_june = VALUES(month_ts_per_store_june),
            month_ts_per_store_july = VALUES(month_ts_per_store_july),
            month_ts_per_store_august = VALUES(month_ts_per_store_august),
            month_ts_per_store_september = VALUES(month_ts_per_store_september),
            month_ts_per_store_october = VALUES(month_ts_per_store_october),
            month_ts_per_store_november = VALUES(month_ts_per_store_november),
            month_ts_per_store_december = VALUES(month_ts_per_store_december),
            yr_ts_per_store = VALUES(yr_ts_per_store),
            ly_month_sell_out = VALUES(ly_month_sell_out),
            ly_year_sell_out = VALUES(ly_year_sell_out),
            updated_at = CURRENT_TIMESTAMP;
        ";

        if ($db->query($query)) {
            CLI::write('Consolidated trade dashboard overall ba updated successfully.', 'green');
        } else {
            CLI::write('Failed to update trade dashboard overall ba data.', 'red');
        }
    }
}