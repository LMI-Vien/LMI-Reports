<?php

namespace App\Models;

use CodeIgniter\Model;

class Dashboard_model extends Model
{
	//backup
	// public function tradeInfoBa($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $page_limit, $page_offset, $minWeeks, $maxWeeks, $week, $month, $year){
	// 	$builder = $this->db->query('CALL get_ba_dashboard(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
	//    		$brand,
	// 	    $brand_ambassador, 
	// 	    $store_name,
	// 	    $ba_type,
	// 	    $sort_field,
	// 	    $sort,
	// 	    $page_limit,
	// 	    $page_offset,
	// 	    $minWeeks,
	// 	    $maxWeeks,
	// 	    $week,
	// 	    $month,
	// 	    $year
	// 	]);
	// 	$data = $builder->getResultArray();
	//     $total_records = isset($data[0]['total_records']) ? $data[0]['total_records'] : 0;

	//     return [
	//         'total_records' => $total_records,
	//         'data' => $data
	//     ];
	// }

	// public function getItemClassData($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $limit, $offset, $week, $month, $year) {
	//     $query = $this->db->query('CALL get_ba_dashboard_npd(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
	//         $brand, 
	//         $brand_ambassador, 
	//         $store_name, 
	//         $ba_type,
	//         $sort_field,
	//         $sort, 
	//         $limit, 
	//         $offset,
	//         $week,
	// 	    $month,
	// 	    $year
	//     ]);

	//     $data = $query->getResultArray();
	//     $totalRecords = count($data) > 0 ? $data[0]['total_records'] : 0;

	//     return [
	//         'total_records' => $totalRecords,
	//         'data' => $data
	//     ];
	// }

	// public function getHeroItemsData($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $limit, $offset, $week, $month, $year) {
	//     $query = $this->db->query('CALL get_ba_dashboard_hero(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
	//         $brand, 
	//         $brand_ambassador, 
	//         $store_name, 
	//         $ba_type,
	//         $sort_field,
	//         $sort, 
	//         $limit, 
	//         $offset,
	// 	    $week,
	// 	    $month,
	// 	    $year
	//     ]);

	//     $data = $query->getResultArray();
	//     $totalRecords = count($data) > 0 ? $data[0]['total_records'] : 0;

	//     return [
	//         'total_records' => $totalRecords,
	//         'data' => $data
	//     ];
	// }

	//working na to need to update the passed filters
	public function tradeInfoBa($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $page_limit, $page_offset, $minWeeks, $maxWeeks, $week, $month, $year){

	    $valid_sort_fields = ['item_name', 'sum_total_qty'];

	    if (!in_array($sort_field, $valid_sort_fields)) {
	        $sort_field = 'item_name'; 
	    }

	    if ($sort !== 'ASC' && $sort !== 'DESC') {
	        $sort = 'ASC'; 
	    }
	    $sql = "
	        SELECT 
	            vmi.id,
	            vmi.item,
	            vmi.item_name,
	            vmi.lmi_itmcde,
	            vmi.rgdi_itmcde,
	            SUM(vmi.total_qty) AS sum_total_qty,
                SUM(vmi.average_sales_unit) AS sum_ave_sales,
	            ROUND(
	                CASE 
	                    WHEN SUM(vmi.average_sales_unit) > 0 
	                    THEN SUM(vmi.total_qty) / SUM(vmi.average_sales_unit) 
	                    ELSE 0 
	                END, 2
	            ) AS weeks,
	            vmi.ambassador_names,
	            vmi.ba_types,
	            vmi.brands,
	            vmi.asc_name,
	            vmi.store_name,
	            COUNT(*) OVER() AS total_records
	        FROM tbl_vmi_pre_aggregated_data vmi
		      WHERE (? IS NULL OR FIND_IN_SET(?, brands) > 0)
		        AND (? IS NULL OR FIND_IN_SET(?, ambassador_names) > 0)
		        AND (? IS NULL OR store_name = ?)
				AND (
				    (? = 3 AND ba_types IN (0,1))
				    OR (? = 0 AND ba_types IN (0))
				    OR (? = 1 AND ba_types IN (1))
				)
		        AND vmi.status = 1
		        AND vmi.week = ?
		        AND vmi.month = ?
		        AND vmi.year = ?
		        GROUP BY vmi.item
	        HAVING weeks > ?
	        AND (? IS NULL OR weeks < ?)
	        ORDER BY $sort_field $sort
	        LIMIT ? OFFSET ?
	    ";

		$params = [
		    $brand ?: NULL, $brand ?: NULL,  
		    $brand_ambassador ?: NULL, $brand_ambassador ?: NULL, 
		    $store_name ?: NULL, $store_name ?: NULL, 
		    $ba_type ?: 0, $ba_type ?: 0, $ba_type ?: 0, 
		    $week ?: NULL, 
		    $month ?: NULL, 
		    $year ?: NULL, 
		    $minWeeks ?: NULL,  
		    $maxWeeks ?: NULL, $maxWeeks ?: NULL,
		    (int) $page_limit, (int)  $page_offset
		];

	    $query = $this->db->query($sql, $params);
		$data = $query->getResult();
		$totalRecords = isset($data[0]->total_records) ? $data[0]->total_records : 0;

		return [
		    'total_records' => $totalRecords,
		    'data' => $data
		];

	}

	public function getItemClassNPDHEROData($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $page_limit, $page_offset, $week, $month, $year, $item_class_filter) {

	    $valid_sort_fields = ['item_name', 'sum_total_qty'];

	    if (!in_array($sort_field, $valid_sort_fields)) {
	        $sort_field = 'item_name';
	    }

	    if ($sort !== 'ASC' && $sort !== 'DESC') {
	        $sort = 'ASC';
	    }
	    $sql = "
	        SELECT 
	            vmi.id,
	            vmi.item,
	            vmi.item_name,
	            vmi.lmi_itmcde,
	            vmi.rgdi_itmcde,
	            SUM(vmi.total_qty) AS sum_total_qty,
                SUM(vmi.average_sales_unit) AS sum_ave_sales,
	            ROUND(
	                CASE 
	                    WHEN SUM(vmi.average_sales_unit) > 0 
	                    THEN SUM(vmi.total_qty) / SUM(vmi.average_sales_unit) 
	                    ELSE 0 
	                END, 2
	            ) AS weeks,
	            vmi.ambassador_names,
	            vmi.ba_types,
	            vmi.brands,
	            vmi.asc_name,
	            vmi.store_name,
	            COUNT(*) OVER() AS total_records
	        FROM tbl_vmi_pre_aggregated_data vmi
		      WHERE (? IS NULL OR FIND_IN_SET(?, brands) > 0)
		        AND (? IS NULL OR FIND_IN_SET(?, ambassador_names) > 0)
		        AND (? IS NULL OR store_name = ?)
		        AND vmi.item_class IN (" . implode(",", array_fill(0, count($item_class_filter), "?")) . ")
				AND (
				    (? = 3 AND ba_types IN (0,1))
				    OR (? = 0 AND ba_types IN (0))
				    OR (? = 1 AND ba_types IN (1))
				)
		        AND vmi.status = 1
		        AND vmi.week = ?
		        AND vmi.month = ?
		        AND vmi.year = ?
		        GROUP BY vmi.item
		   	  ORDER BY $sort_field $sort
	        LIMIT ? OFFSET ?
	    ";

	    $params = array_merge([
	        $brand ?: NULL, $brand ?: NULL,  
	        $brand_ambassador ?: NULL, $brand_ambassador ?: NULL, 
	        $store_name ?: NULL, $store_name ?: NULL, 
	    ], $item_class_filter, [ 
	        $ba_type ?: 0, $ba_type ?: 0, $ba_type ?: 0, 
	        $week ?: NULL, 
	        $month ?: NULL, 
	        $year ?: NULL, 
	        (int) $page_limit, (int)  $page_offset
	    ]);

	    $query = $this->db->query($sql, $params);
		$data = $query->getResult();
		$totalRecords = isset($data[0]->total_records) ? $data[0]->total_records : 0;

		return [
		    'total_records' => $totalRecords,
		    'data' => $data
		];
	}

	public function getLatestVmi($year = null) {
	    $builder = $this->db->table('tbl_vmi v')
	        // ->select('y.id as year_id, m.id as month_id, w.id as week_id')
			->select('y.id as year_id, y.year, m.id as month_id, m.month, w.id as week_id, w.name as week_name')
	        ->where('v.status', 1)
	        ->join('tbl_week w', 'v.week = w.id')
	        ->join('tbl_month m', 'v.month = m.id')
	        ->join('tbl_year y', 'v.year = y.id')
	        ->orderBy('y.year', 'DESC')
	        ->orderBy('m.month', 'DESC')
	        ->orderBy('w.name', 'DESC')
	        ->limit(1);

	    if (!empty($year)) {
	        $builder->where('v.year', $year);
	    }

	    return $builder->get()->getRowArray();
	}


   	public function getMonth($id){
        $results = $this->db->table('tbl_month')
            ->select('id, month')
            ->where('id', $id)
            ->get()
            ->getResultArray();

            return $results;
    }

   	public function getYear($id){
        $results = $this->db->table('tbl_year')
            ->select('id, year')
            ->where('id', $id)
            ->get()
            ->getResultArray();

            return $results;
    }

	public function tradeOverallBaData($limit, $offset, $month = null, $targetYear = null, $lyYear = null, $storeid = null, $areaid = null, $sortField = 'percent_ach', $sortOrder = 'ASC', $remainingDays = null, $salesDate = null) {

	    $allowedSortFields = ['rank', 'asc_names', 'area', 'store_name', 'actual_sales', 'target_sales', 'percent_ach', 'balance_to_target', 'possible_incentives', 'target_per_remaining_days', 'ly_scanned_data', 'growth'];
	    if (!in_array($sortField, $allowedSortFields)) {
	        $sortField = 'rank';
	    }

	    $sql = "
	    WITH sales AS (
	        SELECT 
	            s.area_id,  
	            s.store_id,
	            COALESCE(SUM(s.amount), 0) AS actual_sales,
	            GROUP_CONCAT(DISTINCT b.brand_description ORDER BY b.brand_description SEPARATOR ', ') AS brands,
	            GROUP_CONCAT(DISTINCT ba.name ORDER BY ba.name SEPARATOR ', ') AS brand_ambassadors,
	            GROUP_CONCAT(DISTINCT a_asc.description ORDER BY a_asc.description SEPARATOR ', ') AS asc_names,
	            GROUP_CONCAT(DISTINCT ba.deployment_date ORDER BY ba.deployment_date SEPARATOR ', ') AS ba_deployment_dates
	        FROM tbl_ba_sales_report s
	        LEFT JOIN tbl_brand_ambassador ba ON ba.area = s.area_id AND ba.store = s.store_id
            LEFT JOIN tbl_ba_brands bb ON ba.id = bb.ba_id
            LEFT JOIN tbl_brand b ON b.id = bb.brand_id
	        LEFT JOIN tbl_area_sales_coordinator a_asc ON a_asc.area_id = s.area_id
	        WHERE (? IS NULL OR s.date LIKE CONCAT(?, '%'))
	        GROUP BY s.area_id, s.store_id
	    ),
	    targets AS (
	        SELECT 
	             TRIM(t.location) AS store_id,
	            SUM(COALESCE(
	                CASE 
	                    WHEN ? = 1 THEN t.january
	                    WHEN ? = 2 THEN t.february
	                    WHEN ? = 3 THEN t.march
	                    WHEN ? = 4 THEN t.april
	                    WHEN ? = 5 THEN t.may
	                    WHEN ? = 6 THEN t.june
	                    WHEN ? = 7 THEN t.july
	                    WHEN ? = 8 THEN t.august
	                    WHEN ? = 9 THEN t.september
	                    WHEN ? = 10 THEN t.october
	                    WHEN ? = 11 THEN t.november
	                    WHEN ? = 12 THEN t.december
	                END, 0)
	            ) AS target_sales
	        FROM tbl_target_sales_per_store t
	        WHERE (? IS NULL OR t.year = ?)
	        GROUP BY t.location
	    ),
	    ly_scanned AS (
	        SELECT 
	            so.store_code,
	            SUM(COALESCE(so.net_sales, 0)) AS ly_scanned_data
	        FROM tbl_sell_out_data_details so
	        WHERE (? IS NULL OR so.year = ?) 
	          AND (? IS NULL OR so.month = ?)
	        GROUP BY so.store_code
	    ),
	    store_mapping AS (
	        SELECT 
	            a.id AS area_id,
	            a.description AS area,
	            s.id AS store_id,
	            s.description AS store_name,
	            s.code AS store_code
	        FROM tbl_store s
	        JOIN tbl_store_group sg ON s.id = sg.store_id
	        JOIN tbl_area a ON sg.area_id = a.id
	        WHERE (? IS NULL OR s.id = ?) 
	          AND (? IS NULL OR a.id = ?)
	    )
	    SELECT 
	        ROW_NUMBER() OVER (ORDER BY percent_ach DESC) AS rank,
	        sm.store_id,
	        sm.store_code,
	        sm.area,
	        sm.store_name,
	        COALESCE(s.actual_sales, 0) AS actual_sales,
	        COALESCE(t.target_sales, 0) AS target_sales,
	        ROUND((COALESCE(s.actual_sales, 0) / NULLIF(t.target_sales, 0)) * 100, 2) AS percent_ach,
	        COALESCE(t.target_sales, 0) - COALESCE(s.actual_sales, 0) AS balance_to_target,
	        (COALESCE(s.actual_sales, 0) * 0.01) AS possible_incentives,
	        CASE 
	            WHEN ? > 0 THEN CEIL((COALESCE(t.target_sales, 0) - COALESCE(s.actual_sales, 0)) / ?)
	            ELSE NULL
	        END AS target_per_remaining_days,
	        s.store_id,
	        s.brand_ambassadors,
	        s.asc_names,
	        s.ba_deployment_dates,
	        s.brands,
	        COUNT(s.store_id) OVER() AS total_records,
	        COALESCE(ly.ly_scanned_data, 0) AS ly_scanned_data,
	        ROUND((COALESCE(s.actual_sales, 0) / NULLIF(ly.ly_scanned_data, 0)), 2) AS growth
	    FROM store_mapping sm
	    INNER JOIN sales s ON sm.area_id = s.area_id AND sm.store_id = s.store_id
	    LEFT JOIN targets t ON TRIM(sm.store_id) = TRIM(t.store_id)
	    LEFT JOIN ly_scanned ly ON sm.store_code = ly.store_code
	    ORDER BY $sortField $sortOrder
	    LIMIT ? OFFSET ?
	    ";

	    $params = [
	        $salesDate, $salesDate,  
	        $month, $month, $month, $month, $month, $month, 
	        $month, $month, $month, $month, $month, $month, 
	        $targetYear, $targetYear,  
	        $lyYear, $lyYear, $month, $month,  
	        $storeid, $storeid, $areaid, $areaid,  
	        $remainingDays, $remainingDays,  
	        (int) $limit, (int) $offset  
	    ];


	    $query = $this->db->query($sql, $params);
		$data = $query->getResult();
		$totalRecords = count($data);

		return [
		    'total_records' => $totalRecords,
		    'data' => $data
		];

	}

	public function tradeOverallBaDataASC($filters = []) {

		$whereClausesSR = [];
		$whereClausesSODD = [];
		$whereClausesTSPS = [];
    	$params = [];

	    if (!empty($filters['asc_id'])) {
	        $whereClausesSR[] = "(a_asc.id = :asc_id:)";
	        $whereClausesSODD[] = "(a_asc.id = :asc_id:)";
	        $whereClausesTSPS[] = "(a_asc.id = :asc_id:)";
	        $params['asc_id'] = $filters['asc_id'];
	    }
	    if (!empty($filters['area_id'])) {
	        $whereClausesSR[] = "(ar.id = :area_id: OR ba.area = :area_id: OR s.area_id = :area_id:)";
	        $whereClausesSODD[] = "(ar.id = :area_id:)";
	        $whereClausesTSPS[] = "(ar.id = :area_id:)";
	        $params['area_id'] = $filters['area_id'];
	    }
	    if (!empty($filters['brand_id'])) {
	        $whereClausesSR[] = "(b.id = :brand_id: OR s.brand = :brand_id:)";
	        $whereClausesSODD[] = "(b.id = :brand_id:)";
	        $whereClausesTSPS[] = "(b.id = :brand_id:)";
	        $params['brand_id'] = $filters['brand_id'];
	    }
	    if (!empty($filters['store_id'])) {
	        $whereClausesSR[] = "(st.id = :store_id: OR ba.store = :store_id: OR s.store_id = :store_id:)";
	        $whereClausesSODD[] = "(st.id = :store_id: OR ba.store = :store_id:)";
	        $whereClausesTSPS[] = "(st.id = :store_id: OR ba.store = :store_id:)";
	        $params['store_id'] = $filters['store_id'];
	    }
	    if (!empty($filters['ba_id'])) {
	        $whereClausesSR[] = "(ba.id = :ba_id: OR s.ba_id = :ba_id:)";
	        $whereClausesSODD[] = "(ba.id = :ba_id:)";
	        $whereClausesTSPS[] = "(ba.id = :ba_id:)";
	        $params['ba_id'] = $filters['ba_id'];
	    }

	if (!empty($filters['year'])) {
	    $year = $filters['year'];
	    $nextYear = $year + 1;
	    $LastYear = $year - 1;
	    $whereClausesSR[] = "(s.date >= '$year-01-01' AND s.date < '$nextYear-01-01')";
	    $whereClausesSODD[] = "(sodd.year = '$LastYear')";
	}	
	if (!empty($filters['year_val'])) {
		$year = $filters['year_val'];
		$whereClausesTSPS[] = "(tsps.year = '$year')";	
	}	 

	$whereSQLSR = !empty($whereClausesSR) ? "WHERE " . implode(" AND ", $whereClausesSR) : "";
	$whereSQLSODD = !empty($whereClausesSODD) ? "WHERE " . implode(" AND ", $whereClausesSODD) : "";
	$whereSQLTSPS = !empty($whereClausesTSPS) ? "WHERE " . implode(" AND ", $whereClausesTSPS) : "";
	    $sql = "
	        WITH monthly_totals AS (
			    SELECT 
			        -- SUM(DISTINCT CASE WHEN MONTH(s.date) = 1 THEN s.amount ELSE 0 END) AS amount_january,
			        -- SUM(DISTINCT CASE 
			        --     WHEN MONTH(s.date) = 2 THEN s.amount 
			        --     ELSE 0 
			        -- END) AS amount_february,
			        
			        -- SUM(DISTINCT CASE 
			        --     WHEN MONTH(s.date) = 3 THEN s.amount 
			        --     ELSE 0 
			        -- END) AS amount_march,
			        
			        -- SUM(DISTINCT CASE 
			        --     WHEN MONTH(s.date) = 4 THEN s.amount 
			        --     ELSE 0 
			        -- END) AS amount_april,
			        
			        -- SUM(DISTINCT CASE 
			        --     WHEN MONTH(s.date) = 5 THEN s.amount 
			        --     ELSE 0 
			        -- END) AS amount_may,
			        
			        -- SUM(DISTINCT CASE 
			        --     WHEN MONTH(s.date) = 6 THEN s.amount 
			        --     ELSE 0 
			        -- END) AS amount_june,
			        
			        -- SUM(DISTINCT CASE 
			        --     WHEN MONTH(s.date) = 7 THEN s.amount 
			        --     ELSE 0 
			        -- END) AS amount_july,
			        
			        -- SUM(DISTINCT CASE 
			        --     WHEN MONTH(s.date) = 8 THEN s.amount 
			        --     ELSE 0 
			        -- END) AS amount_august,
			        
			        -- SUM(DISTINCT CASE 
			        --     WHEN MONTH(s.date) = 9 THEN s.amount 
			        --     ELSE 0 
			        -- END) AS amount_september,
			        
			        -- SUM(DISTINCT CASE 
			        --     WHEN MONTH(s.date) = 10 THEN s.amount 
			        --     ELSE 0 
			        -- END) AS amount_october,
			        
			        -- SUM(DISTINCT CASE 
			        --     WHEN MONTH(s.date) = 11 THEN s.amount 
			        --     ELSE 0 
			        -- END) AS amount_november,
			        
			        -- SUM(DISTINCT CASE 
			        --     WHEN MONTH(s.date) = 12 THEN s.amount 
			        --     ELSE 0 
			        -- END) AS amount_december,
					SUM(DISTINCT CASE WHEN MONTH(s.date) = 1 THEN 0 ELSE 0 END) AS amount_january,
			        SUM(DISTINCT CASE 
			            WHEN MONTH(s.date) = 2 THEN 0 
			            ELSE 0 
			        END) AS amount_february,
			        
			        SUM(DISTINCT CASE 
			            WHEN MONTH(s.date) = 3 THEN 0 
			            ELSE 0 
			        END) AS amount_march,
			        
			        SUM(DISTINCT CASE 
			            WHEN MONTH(s.date) = 4 THEN 0
			            ELSE 0 
			        END) AS amount_april,
			        
			        SUM(DISTINCT CASE 
			            WHEN MONTH(s.date) = 5 THEN 0
			            ELSE 0 
			        END) AS amount_may,
			        
			        SUM(DISTINCT CASE 
			            WHEN MONTH(s.date) = 6 THEN 0
			            ELSE 0 
			        END) AS amount_june,
			        
			        SUM(DISTINCT CASE 
			            WHEN MONTH(s.date) = 7 THEN 0
			            ELSE 0 
			        END) AS amount_july,
			        
			        SUM(DISTINCT CASE 
			            WHEN MONTH(s.date) = 8 THEN 0
			            ELSE 0 
			        END) AS amount_august,
			        
			        SUM(DISTINCT CASE 
			            WHEN MONTH(s.date) = 9 THEN 0 
			            ELSE 0 
			        END) AS amount_september,
			        
			        SUM(DISTINCT CASE 
			            WHEN MONTH(s.date) = 10 THEN 0
			            ELSE 0 
			        END) AS amount_october,
			        
			        SUM(DISTINCT CASE 
			            WHEN MONTH(s.date) = 11 THEN 0
			            ELSE 0 
			        END) AS amount_november,
			        
			        SUM(DISTINCT CASE 
			            WHEN MONTH(s.date) = 12 THEN 0
			            ELSE 0 
			        END) AS amount_december,
                	GROUP_CONCAT(DISTINCT b.brand_description ORDER BY b.brand_description SEPARATOR ', ') AS ba_sales_brands,
		            GROUP_CONCAT(DISTINCT ba.name ORDER BY ba.name SEPARATOR ', ') AS ba_sales_brand_ambassadors,
		            GROUP_CONCAT(DISTINCT a_asc.description ORDER BY a_asc.description SEPARATOR ', ') AS ba_sales_asc_names,
		            GROUP_CONCAT(DISTINCT st.description ORDER BY st.description SEPARATOR ', ') AS ba_sales_stores,
		            GROUP_CONCAT(DISTINCT ar.description ORDER BY ar.description SEPARATOR ', ') AS ba_sales_areas
	            FROM tbl_ba_sales_report s
	            LEFT JOIN tbl_brand b ON s.brand = b.id
	            LEFT JOIN tbl_store st ON s.store_id = st.id
		        LEFT JOIN tbl_brand_ambassador ba ON ba.id = s.ba_id
		        LEFT JOIN tbl_area a ON ba.area = a.id
		        LEFT JOIN tbl_area_sales_coordinator a_asc ON a.id = a_asc.area_id
		        LEFT JOIN tbl_area ar ON s.area_id = ar.id
				$whereSQLSR
			        
	        ),
	        net_sales_totals AS (
            SELECT 
                -- ROUND(SUM(CASE WHEN sodd.month = 1 THEN sodd.net_sales ELSE 0 END), 2) AS net_sales_january,
                -- ROUND(SUM(CASE WHEN sodd.month = 2 THEN sodd.net_sales ELSE 0 END), 2) AS net_sales_february,
                -- ROUND(SUM(CASE WHEN sodd.month = 3 THEN sodd.net_sales ELSE 0 END), 2) AS net_sales_march,
                -- ROUND(SUM(CASE WHEN sodd.month = 4 THEN sodd.net_sales ELSE 0 END), 2) AS net_sales_april,
                -- ROUND(SUM(CASE WHEN sodd.month = 5 THEN sodd.net_sales ELSE 0 END), 2) AS net_sales_may,
                -- ROUND(SUM(CASE WHEN sodd.month = 6 THEN sodd.net_sales ELSE 0 END), 2) AS net_sales_june,
                -- ROUND(SUM(CASE WHEN sodd.month = 7 THEN sodd.net_sales ELSE 0 END), 2) AS net_sales_july,
                -- ROUND(SUM(CASE WHEN sodd.month = 8 THEN sodd.net_sales ELSE 0 END), 2) AS net_sales_august,
                -- ROUND(SUM(CASE WHEN sodd.month = 9 THEN sodd.net_sales ELSE 0 END), 2) AS net_sales_september,
                -- ROUND(SUM(CASE WHEN sodd.month = 10 THEN sodd.net_sales ELSE 0 END), 2) AS net_sales_october,
                -- ROUND(SUM(CASE WHEN sodd.month = 11 THEN sodd.net_sales ELSE 0 END), 2) AS net_sales_november,
                -- ROUND(SUM(CASE WHEN sodd.month = 12 THEN sodd.net_sales ELSE 0 END), 2) AS net_sales_december,

                ROUND(SUM(0), 0) AS net_sales_january,
                ROUND(SUM(0), 0) AS net_sales_february,
                ROUND(SUM(0), 0) AS net_sales_march,
                ROUND(SUM(0), 0) AS net_sales_april,
                ROUND(SUM(0), 0) AS net_sales_may,
                ROUND(SUM(0), 0) AS net_sales_june,
                ROUND(SUM(0), 0) AS net_sales_july,
                ROUND(SUM(0), 0) AS net_sales_august,
                ROUND(SUM(0), 0) AS net_sales_september,
                ROUND(SUM(0), 0) AS net_sales_october,
                ROUND(SUM(0), 0) AS net_sales_november,
                ROUND(SUM(0), 0) AS net_sales_december,
                -- bd.brand_ambassadors AS net_sales_brand_ambassadors,
                -- bd.ba_types AS net_sales_ba_types,
                -- bd.ba_deployment_dates AS net_sales_ba_deployment_dates,
                -- bd.brands AS net_sales_brands,
                -- st.description AS net_sales_stores,
                -- bd.asc_name AS net_sales_asc_names,
                -- bd.area_name AS net_sales_areas

            	GROUP_CONCAT(DISTINCT b.brand_description ORDER BY b.brand_description SEPARATOR ', ') AS net_sales_brands,
	            GROUP_CONCAT(DISTINCT ba.name ORDER BY ba.name SEPARATOR ', ') AS net_sales_brand_ambassadors,
	            GROUP_CONCAT(DISTINCT a_asc.description ORDER BY a_asc.description SEPARATOR ', ') AS net_sales_asc_names,
	            GROUP_CONCAT(DISTINCT st.description ORDER BY st.description SEPARATOR ', ') AS net_sales_stores,
	            GROUP_CONCAT(DISTINCT ar.description ORDER BY ar.description SEPARATOR ', ') AS net_sales_areas
	        FROM tbl_sell_out_data_details sodd
	        LEFT JOIN tbl_store st ON st.code = sodd.store_code
	        LEFT JOIN tbl_brand_ambassador ba ON st.id = ba.store
            LEFT JOIN tbl_ba_brands bb ON ba.id = bb.ba_id
            LEFT JOIN tbl_brand b ON b.id = bb.brand_id
            LEFT JOIN tbl_area ar ON ba.area = ar.id
            LEFT JOIN tbl_area_sales_coordinator a_asc ON ar.id = a_asc.area_id
	        $whereSQLSODD
	        ),
	        target_sales_totals AS (
            SELECT 
                -- COALESCE(SUM(tsps.january), 0) AS target_sales_january,
                -- COALESCE(SUM(tsps.february), 0) AS target_sales_february,
                -- COALESCE(SUM(tsps.march), 0) AS target_sales_march,
                -- COALESCE(SUM(tsps.april), 0) AS target_sales_april,
                -- COALESCE(SUM(tsps.may), 0) AS target_sales_may,
                -- COALESCE(SUM(tsps.june), 0) AS target_sales_june,
                -- COALESCE(SUM(tsps.july), 0) AS target_sales_july,
                -- COALESCE(SUM(tsps.august), 0) AS target_sales_august,
                -- COALESCE(SUM(tsps.september), 0) AS target_sales_september,
                -- COALESCE(SUM(tsps.october), 0) AS target_sales_october,
                -- COALESCE(SUM(tsps.november), 0) AS target_sales_november,
                -- COALESCE(SUM(tsps.december), 0) AS target_sales_december,
 				COALESCE(SUM(0), 0) AS target_sales_january,
                COALESCE(SUM(0), 0) AS target_sales_february,
                COALESCE(SUM(0), 0) AS target_sales_march,
                COALESCE(SUM(0), 0) AS target_sales_april,
                COALESCE(SUM(0), 0) AS target_sales_may,
                COALESCE(SUM(0), 0) AS target_sales_june,
                COALESCE(SUM(0), 0) AS target_sales_july,
                COALESCE(SUM(0), 0) AS target_sales_august,
                COALESCE(SUM(0), 0) AS target_sales_september,
                COALESCE(SUM(0), 0) AS target_sales_october,
                COALESCE(SUM(0), 0) AS target_sales_november,
                COALESCE(SUM(0), 0) AS target_sales_december,
                GROUP_CONCAT(DISTINCT st.description ORDER BY st.description SEPARATOR ', ') AS tsps_stores,
                GROUP_CONCAT(DISTINCT b.brand_description ORDER BY b.brand_description SEPARATOR ', ') AS tsps_brands,
        		GROUP_CONCAT(DISTINCT ba.name ORDER BY ba.name SEPARATOR ', ') AS tsps_brand_ambassadors,
        		GROUP_CONCAT(DISTINCT a_asc.description ORDER BY a_asc.description SEPARATOR ', ') AS tsps_asc_names,
        		GROUP_CONCAT(DISTINCT ar.description ORDER BY ar.description SEPARATOR ', ') AS tsps_areas
	        FROM tbl_target_sales_per_store tsps
	        LEFT JOIN tbl_store st ON st.id = tsps.location
	        LEFT JOIN tbl_brand_ambassador ba ON ba.code = tsps.ba_code
	        LEFT JOIN tbl_ba_brands bb ON ba.id = bb.ba_id
	        LEFT JOIN tbl_brand b ON b.id = bb.brand_id
	        LEFT JOIN tbl_area ar ON ba.area = ar.id
	        LEFT JOIN tbl_area_sales_coordinator a_asc ON ar.id = a_asc.area_id
	        $whereSQLTSPS
	        )
	        SELECT
        		nst.*,
        		mt.*,
        		tst.*,
        		ROUND(mt.amount_january / NULLIF(nst.net_sales_january, 0), 2) AS growth_january,
			    ROUND(mt.amount_february / NULLIF(nst.net_sales_february, 0), 2) AS growth_february,
			    ROUND(mt.amount_march / NULLIF(nst.net_sales_march, 0), 2) AS growth_march,
			    ROUND(mt.amount_april / NULLIF(nst.net_sales_april, 0), 2) AS growth_april,
			    ROUND(mt.amount_may / NULLIF(nst.net_sales_may, 0), 2) AS growth_may,
			    ROUND(mt.amount_june / NULLIF(nst.net_sales_june, 0), 2) AS growth_june,
			    ROUND(mt.amount_july / NULLIF(nst.net_sales_july, 0), 2) AS growth_july,
			    ROUND(mt.amount_august / NULLIF(nst.net_sales_august, 0), 2) AS growth_august,
			    ROUND(mt.amount_september / NULLIF(nst.net_sales_september, 0), 2) AS growth_september,
			    ROUND(mt.amount_october / NULLIF(nst.net_sales_october, 0), 2) AS growth_october,
			    ROUND(mt.amount_november / NULLIF(nst.net_sales_november, 0), 2) AS growth_november,
			    ROUND(mt.amount_december / NULLIF(nst.net_sales_december, 0), 2) AS growth_december,
			    ROUND((mt.amount_january / NULLIF(tst.target_sales_january, 0)) * 100, 2) AS achieved_january,
			    ROUND((mt.amount_february / NULLIF(tst.target_sales_february, 0)) * 100, 2) AS achieved_february,
			    ROUND((mt.amount_march / NULLIF(tst.target_sales_march, 0)) * 100, 2) AS achieved_march,
			    ROUND((mt.amount_april / NULLIF(tst.target_sales_april, 0)) * 100, 2) AS achieved_april,
			    ROUND((mt.amount_may / NULLIF(tst.target_sales_may, 0)) * 100, 2) AS achieved_may,
			    ROUND((mt.amount_june / NULLIF(tst.target_sales_june, 0)) * 100, 2) AS achieved_june,
			    ROUND((mt.amount_july / NULLIF(tst.target_sales_july, 0)) * 100, 2) AS achieved_july,
			    ROUND((mt.amount_august / NULLIF(tst.target_sales_august, 0)) * 100, 2) AS achieved_august,
			    ROUND((mt.amount_september / NULLIF(tst.target_sales_september, 0)) * 100, 2) AS achieved_september,
			    ROUND((mt.amount_october / NULLIF(tst.target_sales_october, 0)) * 100, 2) AS achieved_october,
			    ROUND((mt.amount_november / NULLIF(tst.target_sales_november, 0)) * 100, 2) AS achieved_november,
			    ROUND((mt.amount_december / NULLIF(tst.target_sales_december, 0)) * 100, 2) AS achieved_december
	        FROM monthly_totals mt, net_sales_totals nst, target_sales_totals tst
	    ";

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();

	    return [
	        'data' => $data
	    ];
	}

	public function overallAscSalesReport($filters = [])
	{
	    $whereClausesSR = [];
	    $whereClausesSODD = [];
	    $whereClausesTSPS = [];
	    $params = [];

	    if (!empty($filters['asc_id'])) {
	        $whereClausesSR[] = "(a_asc.id = :asc_id:)";
	        $whereClausesSODD[] = "(a_asc.id = :asc_id:)";
	        $whereClausesTSPS[] = "(a_asc.id = :asc_id:)";
	        $params['asc_id'] = $filters['asc_id'];
	    }
	    if (!empty($filters['area_id'])) {
	        $whereClausesSR[] = "(ar.id = :area_id: OR ba.area = :area_id: OR s.area_id = :area_id:)";
	        $whereClausesSODD[] = "(ar.id = :area_id:)";
	        $whereClausesTSPS[] = "(ar.id = :area_id:)";
	        $params['area_id'] = $filters['area_id'];
	    }
	    if (!empty($filters['brand_id'])) {
	        $whereClausesSR[] = "(b.id = :brand_id: OR s.brand = :brand_id:)";
	        $whereClausesSODD[] = "(b.id = :brand_id:)";
	        $whereClausesTSPS[] = "(b.id = :brand_id:)";
	        $params['brand_id'] = $filters['brand_id'];
	    }
	    if (!empty($filters['store_id'])) {
	        $whereClausesSR[] = "(st.id = :store_id: OR ba.store = :store_id: OR s.store_id = :store_id:)";
	        $whereClausesSODD[] = "(st.id = :store_id: OR ba.store = :store_id:)";
	        $whereClausesTSPS[] = "(st.id = :store_id: OR ba.store = :store_id:)";
	        $params['store_id'] = $filters['store_id'];
	    }
	    if (!empty($filters['ba_id'])) {
	        $whereClausesSR[] = "(ba.id = :ba_id: OR s.ba_id = :ba_id:)";
	        $whereClausesSODD[] = "(ba.id = :ba_id:)";
	        $whereClausesTSPS[] = "(ba.id = :ba_id:)";
	        $params['ba_id'] = $filters['ba_id'];
	    }
	    if (!empty($filters['year'])) {
	        $year = $filters['year'];
	        $nextYear = $year + 1;
	        $LastYear = $year - 1;
	        $whereClausesSR[] = "(s.date >= '$year-01-01' AND s.date < '$nextYear-01-01')";
	        $whereClausesSODD[] = "(sodd.year = '$LastYear')";
	    }
	    if (!empty($filters['year_val'])) {
	        $year = $filters['year_val'];
	        $whereClausesTSPS[] = "(tsps.year = '$year')";
	    }

	    $whereSQLSR = !empty($whereClausesSR) ? "WHERE " . implode(" AND ", $whereClausesSR) : "";
	    $whereSQLSODD = !empty($whereClausesSODD) ? "WHERE " . implode(" AND ", $whereClausesSODD) : "";
	    $whereSQLTSPS = !empty($whereClausesTSPS) ? "WHERE " . implode(" AND ", $whereClausesTSPS) : "";

	    $sql = "
	        WITH monthly_totals AS (
	            SELECT
	                a_asc.description AS asc_name,
	                SUM(s.amount) AS total_amount
	            FROM tbl_ba_sales_report s
	            LEFT JOIN tbl_brand b ON s.brand = b.id
	            LEFT JOIN tbl_area_sales_coordinator a_asc ON a_asc.area_id = s.area_id
	            LEFT JOIN tbl_store st ON s.store_id = st.id
	            LEFT JOIN tbl_area ar ON s.area_id = ar.id
	            $whereSQLSR
	            GROUP BY a_asc.description
	        ),
	        net_sales_totals AS (
	            SELECT
	                a_asc.description AS asc_name,
	                SUM(sodd.net_sales) AS total_net_sales
	            FROM tbl_sell_out_data_details sodd
	            LEFT JOIN tbl_store st ON st.code = sodd.store_code
	            LEFT JOIN tbl_brand_ambassador ba ON ba.store = st.id
	            LEFT JOIN tbl_ba_brands bb ON ba.id = bb.ba_id
	            LEFT JOIN tbl_brand b ON bb.brand_id = b.id
	            LEFT JOIN tbl_area_sales_coordinator a_asc ON ba.area = a_asc.area_id
	            LEFT JOIN tbl_area ar ON ar.id = a_asc.area_id
	            $whereSQLSODD
	            GROUP BY a_asc.description
	        ),
	        target_sales_totals AS (
	            SELECT
	                a_asc.description AS asc_name,
	                SUM(COALESCE(tsps.january, 0) + COALESCE(tsps.february, 0) + COALESCE(tsps.march, 0) + 
	                    COALESCE(tsps.april, 0) + COALESCE(tsps.may, 0) + COALESCE(tsps.june, 0) + 
	                    COALESCE(tsps.july, 0) + COALESCE(tsps.august, 0) + COALESCE(tsps.september, 0) + 
	                    COALESCE(tsps.october, 0) + COALESCE(tsps.november, 0) + COALESCE(tsps.december, 0)) 
	                AS total_target_sales
	            FROM tbl_target_sales_per_store tsps
	            LEFT JOIN tbl_store st ON st.id = tsps.location
	            LEFT JOIN tbl_brand_ambassador ba ON ba.store = st.id
	            LEFT JOIN tbl_ba_brands bb ON ba.id = bb.ba_id
	            LEFT JOIN tbl_brand b ON bb.brand_id = b.id
	            LEFT JOIN tbl_area_sales_coordinator a_asc ON ba.area = a_asc.area_id
	            LEFT JOIN tbl_area ar ON ar.id = a_asc.area_id
	            $whereSQLTSPS
	            GROUP BY a_asc.description
	        )
	        SELECT
	            mt.asc_name,
	            mt.total_amount,
	            nst.total_net_sales,
	            tst.total_target_sales,
	            (mt.total_amount - nst.total_net_sales) AS growth,
	            CASE 
	                WHEN tst.total_target_sales > 0 THEN (mt.total_amount / tst.total_target_sales) * 100 
	                ELSE 0 
	            END AS achieved
	        FROM monthly_totals mt
	        LEFT JOIN net_sales_totals nst ON mt.asc_name = nst.asc_name
	        LEFT JOIN target_sales_totals tst ON mt.asc_name = tst.asc_name;
	    ";

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResultArray();

	    return [
	        'data' => $data
	    ];
	}

	public function asc_dashboard_table_data($year, $month, $asc, $area, $minWeeks, $maxWeeks, $brand, $brand_ambassador, $store_name, $page_limit, $page_offset, $withba = false)
	{
	    // $year = intval($year);
	    // $month = intval($month);
	    
	    // // Get previous month and year
	    // $prevMonth = ($month == 1) ? 12 : $month - 1;
	    // $pprevMonth = ($month == 1) ? 12 : $month - 2;
	    // $prevYear = ($month == 1) ? $year - 1 : $year;

	    // $sql = "
	    // WITH ranked_weeks AS (
	    //     SELECT 
	    //         vmi.item, 
	    //         vmi.week, 
	    //         vmi.year, 
	    //         vmi.month,
	    //         SUM(vmi.on_hand + vmi.in_transit) AS total_week_qty,
	    //         ROW_NUMBER() OVER (PARTITION BY vmi.item ORDER BY vmi.year DESC, vmi.month DESC, vmi.week DESC) AS week_rank
	    //     FROM tbl_vmi vmi
	    //     WHERE vmi.status = 1
	    //       AND ((vmi.year = ? AND vmi.month = ?) OR (vmi.year = ? AND vmi.month = ?) OR (vmi.year = ? AND vmi.month = ?))
	    //     GROUP BY vmi.item, vmi.week, vmi.year, vmi.month
	    // ),
	    // selected_weeks AS (
	    //     SELECT 
	    //         item, 
	    //         week, 
	    //         year, 
	    //         month, 
	    //         total_week_qty,
	    //         CASE 
	    //             WHEN month = ? AND year = ? THEN 'current'
	    //             ELSE 'previous'
	    //         END AS week_type
	    //     FROM ranked_weeks
	    //     WHERE week_rank <= 3
	    // ),
	    // aggregated_vmi AS (
	    //     SELECT 
	    //         item,
	    //         item_name,
	    //         SUM(on_hand) AS total_on_hand,
	    //         SUM(in_transit) AS total_in_transit,
	    //         SUM(on_hand + in_transit) AS sum_total_qty,
	    //         SUM(average_sales_unit) AS sum_ave_sales,
	    //         ROUND(
	    //             CASE 
	    //                 WHEN SUM(average_sales_unit) > 0 
	    //                 THEN SUM(on_hand + in_transit) / SUM(average_sales_unit) 
	    //                 ELSE 0 
	    //             END, 2
	    //         ) AS weeks
	    //     FROM tbl_vmi
	    //     WHERE status = 1
	    //     AND month = ? AND year = ?  -- Ensure year filter is applied here
	    //     GROUP BY item, item_name
	    // ),
	    // item_brands AS (
	    //     SELECT DISTINCT 
	    //         tv.item,
	    //         GROUP_CONCAT(DISTINCT ba.name ORDER BY ba.name SEPARATOR ', ') AS ambassador_names,
	    //         GROUP_CONCAT(DISTINCT b.brand_description ORDER BY b.brand_description SEPARATOR ', ') AS brands,
	    //         GROUP_CONCAT(DISTINCT s.description ORDER BY s.description SEPARATOR ', ') AS store_names
	    //     FROM tbl_vmi tv
	    //     LEFT JOIN tbl_brand_ambassador ba ON tv.store = ba.store
	    //     LEFT JOIN tbl_store s ON ba.store = s.id
	    //     LEFT JOIN tbl_ba_brands bb ON ba.id = bb.ba_id
	    //     LEFT JOIN tbl_brand b ON b.id = bb.brand_id
	    //     GROUP BY tv.item
	    // )
	    // SELECT 
	    //     vmi.item,
	    //     vmi.item_name,
	    //     vmi.total_on_hand,
	    //     vmi.total_in_transit,
	    //     vmi.sum_total_qty,
	    //     vmi.sum_ave_sales,
	    //     vmi.weeks,
	    //     ib.ambassador_names,
	    //     ib.brands,
	    //     ib.store_names,
	    //     CONCAT(
	    //         '[', GROUP_CONCAT(
	    //             DISTINCT 
	    //             CASE 
	    //                 WHEN sw.week_type = 'current' 
	    //                 THEN CONCAT('{\"week\":', sw.week, ',\"qty\":', sw.total_week_qty, '}')
	    //                 ELSE CONCAT('{\"old_week\":', sw.week, ',\"qty\":', sw.total_week_qty, '}')
	    //             END
	    //             ORDER BY sw.year DESC, sw.month DESC, sw.week DESC SEPARATOR ', '
	    //         ), ']'
	    //     ) AS last_3_weeks_total,
	    //     COUNT(*) OVER() AS total_records
	    // FROM aggregated_vmi vmi
	    // LEFT JOIN selected_weeks sw ON vmi.item = sw.item
	    // LEFT JOIN item_brands ib ON vmi.item = ib.item
	    // WHERE (? IS NULL OR ib.brands LIKE ?)
	    //   AND (? IS NULL OR ib.ambassador_names LIKE ?)
	    //   AND (? IS NULL OR ib.store_names LIKE ?)
	    //   " . ($withba ? " AND ib.ambassador_names IS NOT NULL AND ib.ambassador_names <> ''" : " AND (ib.ambassador_names IS NULL OR ib.ambassador_names = '')") . "
	    // GROUP BY vmi.item, vmi.item_name, ib.ambassador_names, ib.brands, ib.store_names
	    // HAVING weeks > ?
	    //    AND (? IS NULL OR weeks < ?)
	    // LIMIT ? OFFSET ?";

	    // $params = [
	    //     $year, $month, $year, $pprevMonth, $prevYear, $prevMonth,
	    //     $month, $year, 
	    //     $month, $year, 
	    //     $brand ? "%$brand%" : NULL, $brand ? "%$brand%" : NULL, 
	    //     $brand_ambassador ? "%$brand_ambassador%" : NULL, $brand_ambassador ? "%$brand_ambassador%" : NULL, 
	    //     $store_name ? "%$store_name%" : NULL, $store_name ? "%$store_name%" : NULL, 
	    //     $minWeeks, $maxWeeks, $maxWeeks, 
	    //     $page_limit, $page_offset
	    // ];

	    // $query = $this->db->query($sql, $params);
		// $data = $query->getResult();
		// $totalRecords = count($data);

		// return [
		//     'total_records' => $totalRecords,
		//     'data' => $data
		// ];

	    $year = intval($year);
	    $month = intval($month);

	    $availableWeeksQuery = "
	        SELECT DISTINCT week 
	        FROM tbl_vmi_pre_aggregated_data 
	        WHERE month = ? AND year = ? 
	        ORDER BY week DESC
	    ";

	    $availableWeeksResult = $this->db->query($availableWeeksQuery, [$month, $year])->getResultArray();
	    $availableWeeks = array_column($availableWeeksResult, 'week');

	    $recentWeeks = array_slice($availableWeeks, 0, 3);

	    while (count($recentWeeks) < 3) {
	        $recentWeeks[] = null;
	    }

	    $sql = "
	        SELECT 
	            vmi.id,
	            vmi.item,
	            vmi.item_name,
	            vmi.lmi_itmcde,
	            vmi.rgdi_itmcde,
	            SUM(vmi.total_qty) AS sum_total_qty,
	            SUM(vmi.average_sales_unit) AS sum_ave_sales,
	            ROUND(
	                CASE 
	                    WHEN SUM(vmi.average_sales_unit) > 0 
	                    THEN SUM(vmi.total_qty) / SUM(vmi.average_sales_unit) 
	                    ELSE 0 
	                END, 2
	            ) AS weeks,
	            SUM(CASE WHEN vmi.week = ? THEN vmi.total_qty ELSE 0 END) AS week_3,
	            SUM(CASE WHEN vmi.week = ? THEN vmi.total_qty ELSE 0 END) AS week_2,
	            SUM(CASE WHEN vmi.week = ? THEN vmi.total_qty ELSE 0 END) AS week_1,
	            vmi.ambassador_names,
	            vmi.ba_types,
	            vmi.brands,
	            vmi.asc_name,
	            vmi.store_name,
	            COUNT(*) OVER() AS total_records
	        FROM tbl_vmi_pre_aggregated_data vmi
	        WHERE (? IS NULL OR FIND_IN_SET(?, ambassador_names) > 0)
			  AND (? IS NULL OR FIND_IN_SET(?, brands) > 0)
			  AND (? IS NULL OR store_name = ?)
			  AND (? IS NULL OR asc_name = ?)
			  AND (? IS NULL OR area_name = ?)
	          AND vmi.status = 1
	          AND vmi.week IN (?, ?, ?)
	          AND vmi.month = ?
	          AND vmi.year = ?
	          " . ($withba === true ? " AND vmi.ambassador_names IS NOT NULL AND vmi.ambassador_names <> ''" : ($withba === false ? " AND (vmi.ambassador_names IS NULL OR vmi.ambassador_names = '')" : "")) . "
	        GROUP BY vmi.item
	        HAVING weeks > ?
	        AND (? IS NULL OR weeks < ?)
	        LIMIT ? OFFSET ?
	    ";

	    $params = array_merge([
	        $recentWeeks[0], $recentWeeks[1], $recentWeeks[2],
	        $brand_ambassador ?: NULL, $brand_ambassador ?: NULL,
	        $brand ?: NULL, $brand ?: NULL, 
	        $store_name ?: NULL, $store_name ?: NULL,
	        $asc ?: NULL, $asc ?: NULL, 
	        $area ?: NULL, $area ?: NULL, 
	        $recentWeeks[0], $recentWeeks[1], $recentWeeks[2],
	        $month ?: NULL, 
	        $year ?: NULL,
	        $minWeeks, $maxWeeks, $maxWeeks, 
	        (int) $page_limit, (int) $page_offset
	    ]);

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();
	    $totalRecords = isset($data[0]->total_records) ? $data[0]->total_records : 0;

	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

	public function asc_dashboard_table_data_npd_hero($year, $month, $asc, $area, $brand, $brand_ambassador, $store_name, $page_limit, $page_offset, $type, $item_class_filter, $withba = false) {

	    // $year = intval($year);
	    // $month = intval($month);
	    
	    // // Get previous month and year
	    // $prevMonth = ($month == 1) ? 12 : $month - 1;
	    // $pprevMonth = ($month == 1) ? 12 : $month - 2;
	    // $prevYear = ($month == 1) ? $year - 1 : $year;
	    // // Determine the item_class condition based on type
	    // $itemClassCondition = ($type == 'npd') 
	    //     ? "AND item_class LIKE 'N-New Item%'" 
	    //     : "AND (item_class LIKE 'A-%' OR item_class LIKE 'AU-%' OR item_class LIKE 'B-%' OR item_class LIKE 'BU-%')";
	    
	    // $sql = "
	    // WITH ranked_weeks AS (
	    //     SELECT 
	    //         vmi.item, 
	    //         vmi.week, 
	    //         vmi.year, 
	    //         vmi.month,
	    //         SUM(vmi.on_hand + vmi.in_transit) AS total_week_qty,
	    //         ROW_NUMBER() OVER (PARTITION BY vmi.item ORDER BY vmi.year DESC, vmi.month DESC, vmi.week DESC) AS week_rank
	    //     FROM tbl_vmi vmi
	    //     WHERE vmi.status = 1
	    //       $itemClassCondition
	    //       AND ((vmi.year = ? AND vmi.month = ?) OR (vmi.year = ? AND vmi.month = ?) OR (vmi.year = ? AND vmi.month = ?))
	    //     GROUP BY vmi.item, vmi.week, vmi.year, vmi.month
	    // ),
	    // selected_weeks AS (
	    //     SELECT 
	    //         item, 
	    //         week, 
	    //         year, 
	    //         month, 
	    //         total_week_qty,
	    //         CASE 
	    //             WHEN month = ? AND year = ? THEN 'current'
	    //             ELSE 'previous'
	    //         END AS week_type
	    //     FROM ranked_weeks
	    //     WHERE week_rank <= 3
	    // ),
	    // aggregated_vmi AS (
	    //     SELECT 
	    //         item,
	    //         item_name,
	    //         item_class,
	    //         SUM(on_hand) AS total_on_hand,
	    //         SUM(in_transit) AS total_in_transit,
	    //         SUM(on_hand + in_transit) AS sum_total_qty,
	    //         SUM(average_sales_unit) AS sum_ave_sales
	    //     FROM tbl_vmi
	    //     WHERE status = 1
	    //     AND month = ? AND year = ?
	    //     $itemClassCondition
		//     GROUP BY item, item_name, item_class
	    // ),
	    // item_brands AS (
	    //     SELECT DISTINCT 
	    //         tv.item,
	    //         GROUP_CONCAT(DISTINCT ba.name ORDER BY ba.name SEPARATOR ', ') AS ambassador_names,
	    //         GROUP_CONCAT(DISTINCT b.brand_description ORDER BY b.brand_description SEPARATOR ', ') AS brands,
	    //         GROUP_CONCAT(DISTINCT s.description ORDER BY s.description SEPARATOR ', ') AS store_names
	    //     FROM tbl_vmi tv
	    //     LEFT JOIN tbl_brand_ambassador ba ON tv.store = ba.store
	    //     LEFT JOIN tbl_store s ON ba.store = s.id
	    //     LEFT JOIN tbl_ba_brands bb ON ba.id = bb.ba_id
	    //     LEFT JOIN tbl_brand b ON b.id = bb.brand_id
	    //     GROUP BY tv.item
	    // )
	    // SELECT 
	    //     vmi.item,
	    //     vmi.item_name,
	    //     vmi.total_on_hand,
	    //     vmi.total_in_transit,
	    //     vmi.sum_total_qty,
	    //     vmi.sum_ave_sales,
	    //     ib.ambassador_names,
	    //     ib.brands,
	    //     ib.store_names,
	    //     CONCAT(
	    //         '[', GROUP_CONCAT(
	    //             DISTINCT 
	    //             CASE 
	    //                 WHEN sw.week_type = 'current' 
	    //                 THEN CONCAT('{\"week\":', sw.week, ',\"qty\":', sw.total_week_qty, '}')
	    //                 ELSE CONCAT('{\"old_week\":', sw.week, ',\"qty\":', sw.total_week_qty, '}')
	    //             END
	    //             ORDER BY sw.year DESC, sw.month DESC, sw.week DESC SEPARATOR ', '
	    //         ), ']'
	    //     ) AS last_3_weeks_total,
	    //     GROUP_CONCAT(DISTINCT vmi.item_class ORDER BY vmi.item_class SEPARATOR ', ') AS item_classes,
	    //     COUNT(*) OVER() AS total_records
	    // FROM aggregated_vmi vmi
	    // LEFT JOIN selected_weeks sw ON vmi.item = sw.item
	    // LEFT JOIN item_brands ib ON vmi.item = ib.item
	    // WHERE (? IS NULL OR ib.brands LIKE ?)
	    //   AND (? IS NULL OR ib.ambassador_names LIKE ?)
	    //   AND (? IS NULL OR ib.store_names LIKE ?)
	    //   " . ($withba ? " AND ib.ambassador_names IS NOT NULL AND ib.ambassador_names <> ''" : " AND (ib.ambassador_names IS NULL OR ib.ambassador_names = '')") . "
	    // GROUP BY vmi.item, vmi.item_name, ib.ambassador_names, ib.brands, ib.store_names, vmi.item_class
	    // LIMIT ? OFFSET ?";

	    // $params = [
	    //     $year, $month, $year, $pprevMonth, $prevYear, $prevMonth,
	    //     $month, $year, 
	    //     $month, $year, 
	    //     $brand ? "%$brand%" : NULL, $brand ? "%$brand%" : NULL, 
	    //     $brand_ambassador ? "%$brand_ambassador%" : NULL, $brand_ambassador ? "%$brand_ambassador%" : NULL, 
	    //     $store_name ? "%$store_name%" : NULL, $store_name ? "%$store_name%" : NULL, 
	    //     $page_limit, $page_offset
	    // ];

	    // $query = $this->db->query($sql, $params);
		// $data = $query->getResult();
		// $totalRecords = count($data);

		// return [
		//     'total_records' => $totalRecords,
		//     'data' => $data
		// ];

	    $year = intval($year);
	    $month = intval($month);

	    $availableWeeksQuery = "
	        SELECT DISTINCT week 
	        FROM tbl_vmi_pre_aggregated_data 
	        WHERE month = ? AND year = ? 
	        ORDER BY week DESC
	    ";

	    $availableWeeksResult = $this->db->query($availableWeeksQuery, [$month, $year])->getResultArray();
	    $availableWeeks = array_column($availableWeeksResult, 'week');

	    $recentWeeks = array_slice($availableWeeks, 0, 3);

	    while (count($recentWeeks) < 3) {
	        $recentWeeks[] = null;
	    }

	    $sql = "
	        SELECT 
	            vmi.id,
	            vmi.item,
	            vmi.item_name,
	            vmi.lmi_itmcde,
	            vmi.rgdi_itmcde,
	            SUM(vmi.total_qty) AS sum_total_qty,
	            SUM(vmi.average_sales_unit) AS sum_ave_sales,
	            SUM(CASE WHEN vmi.week = ? THEN vmi.total_qty ELSE 0 END) AS week_3,
	            SUM(CASE WHEN vmi.week = ? THEN vmi.total_qty ELSE 0 END) AS week_2,
	            SUM(CASE WHEN vmi.week = ? THEN vmi.total_qty ELSE 0 END) AS week_1,
	            vmi.ambassador_names,
	            vmi.ba_types,
	            vmi.brands,
	            vmi.asc_name,
	            vmi.store_name,
	            COUNT(*) OVER() AS total_records
	        FROM tbl_vmi_pre_aggregated_data vmi
	        WHERE (? IS NULL OR FIND_IN_SET(?, ambassador_names) > 0)
	          AND vmi.item_class IN (" . implode(",", array_fill(0, count($item_class_filter), "?")) . ")
			  AND (? IS NULL OR FIND_IN_SET(?, brands) > 0)
			  AND (? IS NULL OR store_name = ?)
			  AND (? IS NULL OR asc_name = ?)
			  AND (? IS NULL OR area_name = ?)
	          AND vmi.status = 1
	          AND vmi.week IN (?, ?, ?)
	          AND vmi.month = ?
	          AND vmi.year = ?
	          " . ($withba === true ? " AND vmi.ambassador_names IS NOT NULL AND vmi.ambassador_names <> ''" : ($withba === false ? " AND (vmi.ambassador_names IS NULL OR vmi.ambassador_names = '')" : "")) . "
	        GROUP BY vmi.item
	        LIMIT ? OFFSET ?
	    ";

	    $params = array_merge([
	        $recentWeeks[0], $recentWeeks[1], $recentWeeks[2],
	        $brand_ambassador ?: NULL, $brand_ambassador ?: NULL,
	        ], $item_class_filter, [ 
	        $brand ?: NULL, $brand ?: NULL, 
	        $store_name ?: NULL, $store_name ?: NULL,
	        $asc ?: NULL, $asc ?: NULL, 
	        $area ?: NULL, $area ?: NULL, 
	        $recentWeeks[0], $recentWeeks[1], $recentWeeks[2],
	        $month ?: NULL, 
	        $year ?: NULL, 
	        (int) $page_limit, (int) $page_offset
	    ]);

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();
	    $totalRecords = isset($data[0]->total_records) ? $data[0]->total_records : 0;

	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

	public function getKamOneData($year, $month, $week, $brand, $brand_ambassador, $store_name, $page_limit, $page_offset, $withba = false)
	{
	    $year = intval($year);
	    $month = intval($month);
	    $week = intval($week);
		$sql = "

		    WITH brand_data AS (
		         SELECT 
		             ba.store AS store_id,
		             a_asc.description AS asc_name,
		             a.description as area_name,
		             GROUP_CONCAT(DISTINCT ba.name ORDER BY ba.name SEPARATOR ', ') AS ambassador_names,
		             GROUP_CONCAT(DISTINCT b.brand_description ORDER BY b.brand_description SEPARATOR ', ') AS brands
		         FROM tbl_brand_ambassador ba
		           LEFT JOIN tbl_ba_brands bb ON ba.id = bb.ba_id
		           LEFT JOIN tbl_brand b ON b.id = bb.brand_id
		           LEFT JOIN tbl_area a ON ba.area = a.id
		           LEFT JOIN tbl_area_sales_coordinator a_asc ON a.id = a_asc.area_id
		         GROUP BY ba.store
		     ), item_brands AS (
		        SELECT
		            tv.id,
		            tv.item,
		            tv.item_name,
		            tv.on_hand,
		            tv.in_transit,
		            tv.item_class,
		            tv.store,
		            bd.ambassador_names,
		            bd.brands,
		            s.description AS store_name,
		            bd.asc_name,
		            bd.area_name
		        FROM tbl_vmi tv
		        LEFT JOIN tbl_store s ON tv.store = s.id
		        LEFT JOIN tbl_store_group sg ON s.id = sg.store_id
		        LEFT JOIN brand_data bd ON s.id = bd.store_id
		        GROUP BY tv.id
		    )
		    SELECT 
		        ib.id,
		        ib.item,
		        ib.item_name,
		        ib.item_class,
		        ib.store,
		        ib.on_hand + ib.in_transit AS total_qty,
		        ib.ambassador_names,
		        ib.brands,
		        ib.store_name,
		        ib.asc_name,
		        ib.area_name,
		        COUNT(*) OVER() AS total_records
		    FROM item_brands ib
		       WHERE (? IS NULL OR ib.brands = ?)
		       AND (? IS NULL OR ib.ambassador_names = ?)
		       AND (? IS NULL OR ib.store_name = ?)
		       AND (? IS NULL OR ?)
		       AND (? IS NULL OR ?)
		       AND (? IS NULL OR ?)
		       " . ($withba === true ? " AND ib.ambassador_names IS NOT NULL AND ib.ambassador_names <> ''" : ($withba === false ? " AND (ib.ambassador_names IS NULL OR ib.ambassador_names = '')" : "")) . "
		       ORDER BY ib.id
		       LIMIT ? OFFSET ?
		    ";

		$params = [
		    $brand ?: NULL, $brand ?: NULL,
		    $brand_ambassador ?: NULL, $brand_ambassador ?: NULL, 
		    $store_name ?: NULL, $store_name ?: NULL, 
		    $week ?: NULL, $week ?: NULL, 
		    $month ?: NULL, $month ?: NULL, 
		    $year ?: NULL, $year ?: NULL, 
		    $page_limit, $page_offset
		];

		$query = $this->db->query($sql, $params);
		$data = $query->getResult();
		$totalRecords = $data ? $data[0]->total_records : 0;

		return [
		    'total_records' => $totalRecords,
		    'data' => $data
		];
	}

	public function getFilteredKamOneData($year, $month, $week, $brand, $area, $ba, $store_name, $itemclassi, $page_limit, $page_offset, $withba = false, $qty = null)
	{

	    $year = intval($year);
	    $month = intval($month);
	    $week = intval($week);

	    $sql = "
	        SELECT 
	            id,
	            item,
	            item_name,
	            item_class,
	            store_id,
	            total_qty,
	            ambassador_names,
	            brands,
	            store_name,
	            asc_name,
	            area_name,
	            lmi_itmclass,
	            rgdi_itmclass,
	            COUNT(*) OVER() AS total_records
	        FROM tbl_vmi_pre_aggregated_data
	        WHERE (? IS NULL OR FIND_IN_SET(?, brands) > 0)
	          AND (? IS NULL OR area_name = ?)
	          AND (? IS NULL OR FIND_IN_SET(?, ambassador_names) > 0)
	          AND (? IS NULL OR store_name = ?)
	          AND (? IS NULL OR lmi_itmclass = ? OR rgdi_itmclass = ?)
	          AND week = ?
	          AND month = ?
	          AND year = ?
	          AND (? IS NULL OR total_qty <= ?)
	          " . ($withba === true ? " AND ambassador_names IS NOT NULL AND ambassador_names <> ''" : ($withba === false ? " AND (ambassador_names IS NULL OR ambassador_names = '')" : "")) . "
	          ORDER BY id
	        LIMIT ? OFFSET ?";

	    $params = [
	        $brand ?: NULL, $brand ?: NULL,  
	        $area ?: NULL, $area ?: NULL,  
	        $ba ?: NULL, $ba ?: NULL, 
	        $store_name ?: NULL, $store_name ?: NULL, 
	        $itemclassi ?: NULL, $itemclassi ?: NULL, $itemclassi ?: NULL, 
	        $week ?: NULL,
	        $month ?: NULL,
	        $year ?: NULL,
	        $qty ?: NULL, $qty ?: NULL, 
	        $page_limit, $page_offset
	    ];

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();
	    $totalRecords = $data ? $data[0]->total_records : 0;
		//echo $this->db->getLastQuery();
	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

	public function getKamTwoData($brand_ambassador, $store_name, $sort_field, $sort, $page_limit, $page_offset, $minWeeks, $maxWeeks, $month, $year) {
	    $valid_sort_fields = ['item_name', 'sum_total_qty', 'week_1', 'week_2', 'week_3'];

	    if (!in_array($sort_field, $valid_sort_fields)) {
	        $sort_field = 'item_name'; 
	    }

	    if ($sort !== 'ASC' && $sort !== 'DESC') {
	        $sort = 'ASC'; 
	    }

	    $availableWeeksQuery = "
	        SELECT DISTINCT week 
	        FROM tbl_vmi_pre_aggregated_data 
	        WHERE month = ? AND year = ? 
	        ORDER BY week DESC
	    ";

	    $availableWeeksResult = $this->db->query($availableWeeksQuery, [$month, $year])->getResultArray();
	    $availableWeeks = array_column($availableWeeksResult, 'week');

	    $recentWeeks = array_slice($availableWeeks, 0, 3);

	    while (count($recentWeeks) < 3) {
	        $recentWeeks[] = null;
	    }

	    $sql = "
	        SELECT 
	            vmi.id,
	            vmi.item,
	            vmi.item_name,
	            vmi.lmi_itmcde,
	            vmi.rgdi_itmcde,
	            SUM(vmi.total_qty) AS sum_total_qty,
	            SUM(vmi.average_sales_unit) AS sum_ave_sales,
	            ROUND(
	                CASE 
	                    WHEN SUM(vmi.average_sales_unit) > 0 
	                    THEN SUM(vmi.total_qty) / SUM(vmi.average_sales_unit) 
	                    ELSE 0 
	                END, 2
	            ) AS weeks,
	            -- Consolidate data for the selected 3 weeks
	            SUM(CASE WHEN vmi.week = ? THEN vmi.total_qty ELSE 0 END) AS week_3,
	            SUM(CASE WHEN vmi.week = ? THEN vmi.total_qty ELSE 0 END) AS week_2,
	            SUM(CASE WHEN vmi.week = ? THEN vmi.total_qty ELSE 0 END) AS week_1,
	            vmi.ambassador_names,
	            vmi.ba_types,
	            vmi.brands,
	            vmi.asc_name,
	            vmi.store_name,
	            COUNT(*) OVER() AS total_records
	        FROM tbl_vmi_pre_aggregated_data vmi
	        WHERE (? IS NULL OR FIND_IN_SET(?, ambassador_names) > 0)
	          AND (? IS NULL OR store_name = ?)
	          AND vmi.status = 1
	          AND vmi.week IN (?, ?, ?)
	          AND vmi.month = ?
	          AND vmi.year = ?
	        GROUP BY vmi.item
	        HAVING weeks > ?
	          AND (? IS NULL OR weeks < ?)
	        ORDER BY $sort_field $sort
	        LIMIT ? OFFSET ?
	    ";

	    $params = array_merge([
	        $recentWeeks[0], $recentWeeks[1], $recentWeeks[2],
	        $brand_ambassador ?: NULL, $brand_ambassador ?: NULL, 
	        $store_name ?: NULL, $store_name ?: NULL, 
	        $recentWeeks[0], $recentWeeks[1], $recentWeeks[2],
	        $month ?: NULL, 
	        $year ?: NULL, 
	        $minWeeks ?: NULL,  
	        $maxWeeks ?: NULL, $maxWeeks ?: NULL,
	        (int) $page_limit, (int) $page_offset
	    ]);

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();
	    $totalRecords = isset($data[0]->total_records) ? $data[0]->total_records : 0;

	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

	public function getKamTwoHeroNPDData($brand_ambassador, $store_name, $sort_field, $sort, $page_limit, $page_offset, $month, $year, $module, $item_class_filter) {
	    $valid_sort_fields = ['item_name', 'sum_total_qty'];

	    if (!in_array($sort_field, $valid_sort_fields)) {
	        $sort_field = 'item_name'; 
	    }

	    if ($sort !== 'ASC' && $sort !== 'DESC') {
	        $sort = 'ASC'; 
	    }

	    $availableWeeksQuery = "
	        SELECT DISTINCT week 
	        FROM tbl_vmi_pre_aggregated_data 
	        WHERE month = ? AND year = ? 
	        ORDER BY week DESC
	    ";

	    $availableWeeksResult = $this->db->query($availableWeeksQuery, [$month, $year])->getResultArray();
	    $availableWeeks = array_column($availableWeeksResult, 'week');

	    $recentWeeks = array_slice($availableWeeks, 0, 3);

	    while (count($recentWeeks) < 3) {
	        $recentWeeks[] = null;
	    }

	    $sql = "
	        SELECT 
	            vmi.id,
	            vmi.item,
	            vmi.item_name,
	            vmi.lmi_itmcde,
	            vmi.rgdi_itmcde,
	            SUM(vmi.total_qty) AS sum_total_qty,
	            SUM(vmi.average_sales_unit) AS sum_ave_sales,
	            ROUND(
	                CASE 
	                    WHEN SUM(vmi.average_sales_unit) > 0 
	                    THEN SUM(vmi.total_qty) / SUM(vmi.average_sales_unit) 
	                    ELSE 0 
	                END, 2
	            ) AS weeks,
	            -- Consolidate data for the selected 3 weeks
	            SUM(CASE WHEN vmi.week = ? THEN vmi.total_qty ELSE 0 END) AS week_3,
	            SUM(CASE WHEN vmi.week = ? THEN vmi.total_qty ELSE 0 END) AS week_2,
	            SUM(CASE WHEN vmi.week = ? THEN vmi.total_qty ELSE 0 END) AS week_1,
	            vmi.week AS trans_date,
	            vmi.ambassador_names,
	            vmi.ba_types,
	            vmi.brands,
	            vmi.asc_name,
	            vmi.store_name,
	            COUNT(*) OVER() AS total_records
	        FROM tbl_vmi_pre_aggregated_data vmi
	        WHERE (? IS NULL OR FIND_IN_SET(?, ambassador_names) > 0)
	          AND (? IS NULL OR store_name = ?)
	          AND vmi.item_class IN (" . implode(",", array_fill(0, count($item_class_filter), "?")) . ")
	          AND vmi.status = 1
	          AND vmi.week IN (?, ?, ?)
	          AND vmi.month = ?
	          AND vmi.year = ?
	        GROUP BY vmi.item
	        ORDER BY $sort_field $sort
	        LIMIT ? OFFSET ?
	    ";

	    $params = array_merge([
	        $recentWeeks[0], $recentWeeks[1], $recentWeeks[2],
	        $brand_ambassador ?: NULL, $brand_ambassador ?: NULL, 
	        $store_name ?: NULL, $store_name ?: NULL, 
	        ], $item_class_filter, [ 
	        $recentWeeks[0], $recentWeeks[1], $recentWeeks[2],
	        $month ?: NULL, 
	        $year ?: NULL, 
	        (int) $page_limit, (int) $page_offset
	    ]);

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();
	    $totalRecords = isset($data[0]->total_records) ? $data[0]->total_records : 0;

	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

	public function getStorePerformance($month_start, $month_end, $year, $limit, $offset)
	{

		$last_year = $year - 1; 

	    $sql = "
	        WITH ly_scanned AS (
	            SELECT 
	                ly_so.store_code,
	                SUM(COALESCE(ly_so.net_sales, 0)) AS ly_scanned_data
	            FROM tbl_sell_out_data_details ly_so
	            WHERE (? IS NULL OR ly_so.year = ?) 
	              AND (? IS NULL OR ly_so.month BETWEEN ? AND ?)
	            GROUP BY ly_so.store_code
	        ),
	        ty_scanned AS (
	            SELECT 
	                ty_so.store_code,
	                SUM(COALESCE(ty_so.net_sales, 0)) AS ty_scanned_data
	            FROM tbl_sell_out_data_details ty_so
	            WHERE (? IS NULL OR ty_so.year = ?) 
	              AND (? IS NULL OR ty_so.month BETWEEN ? AND ?)
	            GROUP BY ty_so.store_code
	        ),
	        vmi_total_qty AS (
	            SELECT 
	                vmi.store_id,
	                vmi.store_code,
	                SUM(vmi.total_qty) AS vmi_total_qty_data
	            FROM tbl_vmi_pre_aggregated_data vmi
	            WHERE (? IS NULL OR vmi.year = ?)
	              AND (? IS NULL OR vmi.month BETWEEN ? AND ?)
	            GROUP BY vmi.store_id
	        ),
	        total_ty AS (
	            SELECT SUM(COALESCE(ty.ty_scanned_data, 0)) AS total_ty_sales
	            FROM ty_scanned ty
	        ),
	        distinct_store_count AS (
	            SELECT COUNT(DISTINCT store_code) AS total_unique_store_codes
	            FROM tbl_sell_out_data_details
	        )
	        SELECT 
	            ROW_NUMBER() OVER (ORDER BY (COALESCE(ty.ty_scanned_data, 0) / NULLIF(tt.total_ty_sales, 0)) DESC) AS rank,
	            so.store_code,
	            MAX(s.description) AS store_name,
	            COALESCE(ly.ly_scanned_data, 0) AS ly_scanned_data,
	            COALESCE(ty.ty_scanned_data, 0) AS ty_scanned_data,
	            COALESCE(tq.vmi_total_qty_data, 0) AS vmi_total_qty_data,
	            ROUND(COALESCE(ty.ty_scanned_data, 0) / NULLIF(COALESCE(tq.vmi_total_qty_data, 0), 0) * 100, 2) AS sell_through,
	            ROUND(COALESCE(ty.ty_scanned_data, 0) / NULLIF(tt.total_ty_sales, 0) * 100, 2) AS contribution,
	            COUNT(*) OVER() AS total_records
	        FROM tbl_sell_out_data_details so
	        LEFT JOIN ly_scanned ly ON so.store_code = ly.store_code
	        LEFT JOIN ty_scanned ty ON so.store_code = ty.store_code
	        LEFT JOIN vmi_total_qty tq ON so.store_code = tq.store_code
	        LEFT JOIN tbl_store s ON so.store_code = s.code
	        CROSS JOIN total_ty tt
	        CROSS JOIN distinct_store_count dsc
	        WHERE (? IS NULL OR so.year = ?)
	        AND (? IS NULL OR so.month BETWEEN ? AND ?)
	        GROUP BY so.store_code, ly.ly_scanned_data, ty.ty_scanned_data, tq.vmi_total_qty_data, tt.total_ty_sales, dsc.total_unique_store_codes
	        ORDER BY rank ASC
	        LIMIT ? OFFSET ?;
	    ";

	    $params = [
	        $last_year ?: NULL, $last_year ?: NULL,
	        $month_start ?: NULL, $month_start ?: NULL, $month_end ?: NULL,
	        $year ?: NULL, $year ?: NULL,
	        $month_start ?: NULL, $month_start ?: NULL, $month_end ?: NULL,
	        $year ?: NULL, $year ?: NULL,
	        $month_start ?: NULL, $month_start ?: NULL, $month_end ?: NULL,
	        $year ?: NULL, $year ?: NULL,
	        $month_start ?: NULL, $month_start ?: NULL, $month_end ?: NULL,
	        $limit, $offset
	    ];

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();
	    $totalRecords = $data ? $data[0]->total_records : 0;

	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

	public function refreshPreAggregatedData()
	{
	    $sql = "
	        WITH brand_data AS (
	            SELECT 
	                ba.store AS store_id,
	                a_asc.description AS asc_name,
	                a.description as area_name,
	                GROUP_CONCAT(DISTINCT ba.type ORDER BY ba.type SEPARATOR ', ') AS ba_types,
	                GROUP_CONCAT(DISTINCT ba.deployment_date ORDER BY ba.deployment_date SEPARATOR ', ') AS ba_deployment_dates,
	                GROUP_CONCAT(DISTINCT ba.name ORDER BY ba.name SEPARATOR ', ') AS ambassador_names,
	                GROUP_CONCAT(DISTINCT b.brand_description ORDER BY b.brand_description SEPARATOR ', ') AS brands
	            FROM tbl_brand_ambassador ba
	            LEFT JOIN tbl_ba_brands bb ON ba.id = bb.ba_id
	            LEFT JOIN tbl_brand b ON b.id = bb.brand_id
	            LEFT JOIN tbl_area a ON ba.area = a.id
	            LEFT JOIN tbl_area_sales_coordinator a_asc ON a.id = a_asc.area_id
	            WHERE ba.status >= 0
	            GROUP BY ba.store
	        ), item_brands AS (
	            SELECT
	                tv.id,
	                tv.item,
	                tv.item_name,
	                tv.vmi_status,
	                tv.supplier,
	                tv.average_sales_unit,
	                tv.on_hand,
	                tv.in_transit,
	                tv.item_class,
	                tv.store as store_id,
	                tv.year,
	                tv.month,
	                tv.week,
	                tv.company,
	                tv.status,
	                bd.ambassador_names,
	                bd.ba_types,
	                bd.ba_deployment_dates,
	                bd.brands,
	                s.description AS store_name,
	                bd.asc_name,
	                bd.area_name,
	                pclmi.itmcde AS lmi_itmcde,
	                pcrgdi.itmcde AS rgdi_itmcde,
	                iflmi.itmclacde AS lmi_itmclass,
	                ifrgdi.itmclacde AS rgdi_itmclass
	            FROM tbl_vmi tv
	            LEFT JOIN tbl_store s ON tv.store = s.id
	            LEFT JOIN tbl_store_group sg ON s.id = sg.store_id
	            LEFT JOIN brand_data bd ON s.id = bd.store_id
				LEFT JOIN tbl_price_code_file_2_lmi pclmi ON tv.item = pclmi.cusitmcde AND tv.company = 2
    			LEFT JOIN tbl_price_code_file_2_rgdi pcrgdi ON tv.item = pcrgdi.cusitmcde AND tv.company = 1
   				LEFT JOIN tbl_itemfile_lmi iflmi ON pclmi.itmcde = iflmi.itmcde AND tv.company = 2
    			LEFT JOIN tbl_itemfile_rgdi ifrgdi ON pcrgdi.itmcde = ifrgdi.itmcde AND tv.company = 1
	            GROUP BY tv.id
	        )
	        SELECT 
	            ib.id,
	            ib.item,
	            ib.item_name,
	            ib.vmi_status,
	            ib.supplier,
	            ib.average_sales_unit,
	            ib.item_class,
	            ib.store_id,
	            ib.on_hand + ib.in_transit AS total_qty,
	            ib.ambassador_names,
	            ib.ba_types,
	            ib.ba_deployment_dates,
	            ib.lmi_itmcde,
	            ib.rgdi_itmcde,
	            ib.lmi_itmclass,
	            ib.rgdi_itmclass,
	            ib.brands,
	            ib.store_name,
	            ib.asc_name,
	            ib.area_name,
	            ib.year,
	            ib.month,
	            ib.week,
	            ib.company,
	            ib.status
	        FROM item_brands ib
	    ";

	    $query = $this->db->query($sql);
	    $allData = $query->getResultArray();

	    $this->db->query("TRUNCATE TABLE tbl_vmi_pre_aggregated_data");

	    $batchSize = 10000;
	    $chunks = array_chunk($allData, $batchSize);

	    foreach ($chunks as $chunk) {
	        $this->db->table('tbl_vmi_pre_aggregated_data')->insertBatch($chunk);
	    }

	    return [
	        'total_inserted' => count($allData)
	    ];
	}

    public function updateConsolidatedData()
    {
        $this->db->query("TRUNCATE TABLE tbl_trade_db_overall_ba");

        $insertQuery = "
            INSERT INTO tbl_trade_db_overall_ba (
                area_id, area, store_code, store_name, actual_sales, date, brands, target, arch,
                balance_to_target, possible_incentives, target_per_rem_days, ly_scanned_data,
                brand_ambassador_name, ba_deployment_date, rank, growth
            )
            SELECT 
                aggregated_sps.area_id,
                tbl_area.description as area,
                tbl_store.code as store_code,
                tbl_store.description as store_name,
                aggregated_sps.actual_sales,
                aggregated_sps.date,
                GROUP_CONCAT(DISTINCT tbl_brand.brand_description ORDER BY tbl_brand.brand_description SEPARATOR ', ') AS brands,
                COALESCE(SUM(tbl_target_sales_per_store.january), 0) AS target,
                ROUND((aggregated_sps.actual_sales / NULLIF(COALESCE(SUM(tbl_target_sales_per_store.january), 0), 0)) * 100, 2) AS arch,
                COALESCE(SUM(tbl_target_sales_per_store.january), 0) - aggregated_sps.actual_sales AS balance_to_target,
                COALESCE(aggregated_sps.actual_sales, 0) * 0.01 AS possible_incentives,
                CEIL((COALESCE(SUM(tbl_target_sales_per_store.january), 0) - aggregated_sps.actual_sales) / NULLIF(25, 0)) AS target_per_rem_days,
                ROUND(COALESCE(SUM(tbl_sell_out_data_details.net_sales), 0), 2) AS ly_scanned_data,
                tbl_brand_ambassador.name AS brand_ambassador_name,
                tbl_brand_ambassador.deployment_date AS ba_deployment_date,
                ROW_NUMBER() OVER (
                    ORDER BY 
                        CASE 
                            WHEN aggregated_sps.actual_sales IS NULL OR aggregated_sps.actual_sales = 0 
                            THEN NULL
                            ELSE ROUND((aggregated_sps.actual_sales / NULLIF(COALESCE(SUM(tbl_target_sales_per_store.january), 0), 0)) * 100, 2)
                        END DESC
                ) AS rank,
                ROUND(COALESCE(aggregated_sps.actual_sales, 0) / NULLIF(SUM(tbl_sell_out_data_details.net_sales), 0), 2) AS growth
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
            LEFT JOIN tbl_target_sales_per_store ON tbl_ba_sales_report.store_id = tbl_target_sales_per_store.location
            INNER JOIN tbl_brand_ambassador ON tbl_ba_sales_report.ba_id = tbl_brand_ambassador.id
            LEFT JOIN tbl_sell_out_data_details ON tbl_ba_sales_report.store_id = tbl_sell_out_data_details.store_code
            GROUP BY aggregated_sps.area_id
        ";

        $db->query($insertQuery);

        session()->setFlashdata('success', 'Sales data has been updated successfully.');
        $message = "success";
    	return $message;
    }

    public function getCounts()
    {
        $companyCount = $this->db->table('tbl_company')->countAllResults(); 
        $areaCount = $this->db->table('tbl_area')->countAllResults(); 
        $storeCount = $this->db->table('tbl_store')->countAllResults(); 
        $agencyCount = $this->db->table('tbl_agency')->countAllResults(); 
        $BaCount = $this->db->table('tbl_brand_ambassador')->countAllResults(); 
        $AscCount = $this->db->table('tbl_area_sales_coordinator')->countAllResults(); 
		$TeamCount = $this->db->table('tbl_team')->countAllResults(); 

        return [
            'company' => $companyCount,
            'area' => $areaCount,
            'store' => $storeCount,
            'agency' => $agencyCount,
            'ba' => $BaCount,
            'asc' => $AscCount,
            'team' => $TeamCount
        ];
    }

}
