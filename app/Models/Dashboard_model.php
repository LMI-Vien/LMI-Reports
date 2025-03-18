<?php

namespace App\Models;

use CodeIgniter\Model;

class Dashboard_model extends Model
{

	public function tradeInfoBaBackup($brand, $brand_ambassador, $store_name, $ba_type, $sort = 'ASC', $limit, $offset, $minWeeks, $maxWeeks = null)
	{
	    $subquery = $this->db->table('tbl_vmi')
	        ->select("
	            item,
	            item_name,
	            SUM(on_hand) AS total_on_hand,
	            SUM(in_transit) AS total_in_transit,
	            SUM(on_hand + in_transit) AS sum_total_qty,
	            SUM(average_sales_unit) AS sum_ave_sales,
	            ROUND(SUM(on_hand + in_transit) / NULLIF(SUM(average_sales_unit), 0), 2) AS weeks
	        ")
	        ->where('status', 1)
	        ->groupBy('item')  
	        ->having('weeks >', $minWeeks)
	        ->getCompiledSelect();

	    $query = $this->db->table("($subquery) AS aggregated_vmi")
	        ->select("
	            aggregated_vmi.item,
	            aggregated_vmi.item_name,
	            aggregated_vmi.total_on_hand,
	            aggregated_vmi.total_in_transit,
	            aggregated_vmi.sum_total_qty,
	            aggregated_vmi.sum_ave_sales,
	            aggregated_vmi.weeks,
	            GROUP_CONCAT(DISTINCT tbl_brand_ambassador.name ORDER BY tbl_brand_ambassador.name SEPARATOR ', ') AS ambassador_names,
	            GROUP_CONCAT(DISTINCT tbl_brand.brand_description ORDER BY tbl_brand.brand_description SEPARATOR ', ') AS brands,
	            GROUP_CONCAT(DISTINCT tbl_store.description ORDER BY tbl_store.description SEPARATOR ', ') AS store_names
	        ")
	        ->join('tbl_vmi', 'aggregated_vmi.item = tbl_vmi.item', 'left')
	        ->join('tbl_brand_ambassador', 'tbl_vmi.store = tbl_brand_ambassador.store', 'left')
	        ->join('tbl_store', 'tbl_brand_ambassador.store = tbl_store.id', 'left')
	        ->join('tbl_ba_brands', 'tbl_brand_ambassador.id = tbl_ba_brands.ba_id', 'left')
	        ->join('tbl_brand', 'tbl_brand.id = tbl_ba_brands.brand_id', 'left')
	        ->groupBy('aggregated_vmi.item')
	        ->orderBy('aggregated_vmi.item_name', $sort);

	    // Apply filters
	    if (!empty($brand)) {
	        $query->where('tbl_brand.brand_description LIKE', '%' . $brand . '%');
	    }

	    if (!empty($brand_ambassador)) {
	        $query->where('tbl_brand_ambassador.name LIKE', '%' . $brand_ambassador . '%');
	    }

	    if (!empty($store_name)) {
	        $query->where('tbl_store.description LIKE', '%' . $store_name . '%');
	    }

	    if (!empty($ba_type && $ba_type !== 3)) {
	        $query->where('tbl_brand_ambassador.type', $ba_type); // Filter by type
	    }

	    $query->limit($limit, $offset);
	    return $query->get()->getResult();
	}


	public function getHeroItemsDataBackup($brand, $brand_ambassador, $store_name, $ba_type, $sort, $limit, $offset)
	{

		$subquery = $this->db->table('tbl_vmi')
		    ->select("
		        item,
		        item_name
		    ")
		    ->where('status', 1)
		   	->where('item_class LIKE', 'A-Top%')  // Match all entries that start with 'A-Top'
	        ->orWhere('item_class LIKE', 'AU-Top%')  // Match all entries that start with 'AU-Top'
	        ->orWhere('item_class LIKE', 'BU-Top%')
		    ->groupBy('item')  
		    ->getCompiledSelect();

			$query = $this->db->table("($subquery) AS aggregated_vmi")
		    ->select("
		        aggregated_vmi.item,
		        aggregated_vmi.item_name
		    ")
		    ->join('tbl_vmi', 'aggregated_vmi.item = tbl_vmi.item', 'left')
		    ->join('tbl_brand_ambassador', 'tbl_vmi.store = tbl_brand_ambassador.store', 'left')
		    ->join('tbl_store', 'tbl_brand_ambassador.store = tbl_store.id', 'left')
		    ->join('tbl_ba_brands', 'tbl_brand_ambassador.id = tbl_ba_brands.ba_id', 'left')
		    ->join('tbl_brand', 'tbl_brand.id = tbl_ba_brands.brand_id', 'left')

		    ->groupBy('aggregated_vmi.item')
		    ->orderBy('aggregated_vmi.item_name', $sort);

			if (!empty($brand)) {
			    $query->where('tbl_brand.brand_description LIKE', '%' . $brand . '%');
			}

			if (!empty($brand_ambassador)) {
			    $query->where('tbl_brand_ambassador.name LIKE', '%' . $brand_ambassador . '%');
			}

			if (!empty($store_name)) {
			    $query->where('tbl_store.description LIKE', '%' . $store_name . '%');
			}

		    if (!empty($ba_type && $ba_type !== 3)) {
		        $query->where('tbl_brand_ambassador.type', $ba_type); // Filter by type
		    }

			$query->limit($limit, $offset);
			return $query->get()->getResult();
	}

	public function getItemClassDataBackup($brand, $brand_ambassador, $store_name, $ba_type, $sort, $limit, $offset)
	{

		$subquery = $this->db->table('tbl_vmi')
		    ->select("
		        item,
		        item_name,
		        SUM(on_hand) AS total_on_hand,
		        SUM(in_transit) AS total_in_transit,
		        SUM(on_hand + in_transit) AS sum_total_qty,
		        SUM(average_sales_unit) AS sum_ave_sales,
		        ROUND(SUM(on_hand + in_transit) / NULLIF(SUM(average_sales_unit), 0), 2) AS weeks
		    ")
		    ->where('status', 1)
		   	->where('item_class LIKE', 'N-New Item%')
		    ->groupBy('item')  
		    ->getCompiledSelect();

			$query = $this->db->table("($subquery) AS aggregated_vmi")
		    ->select("
		        aggregated_vmi.item,
		        aggregated_vmi.item_name,
		        aggregated_vmi.total_on_hand,
		        aggregated_vmi.total_in_transit,
		        aggregated_vmi.sum_total_qty,
		        aggregated_vmi.sum_ave_sales,
		        aggregated_vmi.weeks,
		        GROUP_CONCAT(DISTINCT tbl_brand_ambassador.name ORDER BY tbl_brand_ambassador.name SEPARATOR ', ') AS ambassador_names,
		        GROUP_CONCAT(DISTINCT tbl_brand.brand_description ORDER BY tbl_brand.brand_description SEPARATOR ', ') AS brands,
		        GROUP_CONCAT(DISTINCT tbl_store.description ORDER BY tbl_store.description SEPARATOR ', ') AS store_names
		    ")
		    ->join('tbl_vmi', 'aggregated_vmi.item = tbl_vmi.item', 'left')
		    ->join('tbl_brand_ambassador', 'tbl_vmi.store = tbl_brand_ambassador.store', 'left')
		    ->join('tbl_store', 'tbl_brand_ambassador.store = tbl_store.id', 'left')
		    ->join('tbl_ba_brands', 'tbl_brand_ambassador.id = tbl_ba_brands.ba_id', 'left')
		    ->join('tbl_brand', 'tbl_brand.id = tbl_ba_brands.brand_id', 'left')

		    ->groupBy('aggregated_vmi.item')
		    ->orderBy('aggregated_vmi.item_name', $sort);

			if (!empty($brand)) {
			    $query->where('tbl_brand.brand_description LIKE', '%' . $brand . '%');
			}

			if (!empty($brand_ambassador)) {
			    $query->where('tbl_brand_ambassador.name LIKE', '%' . $brand_ambassador . '%');
			}

			if (!empty($store_name)) {
			    $query->where('tbl_store.description LIKE', '%' . $store_name . '%');
			}

		    if (!empty($ba_type && $ba_type !== 3)) {
		        $query->where('tbl_brand_ambassador.type', $ba_type); // Filter by type
		    }

			$query->limit($limit, $offset);
			return $query->get()->getResult();
	}

	public function tradeInfoBa($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $page_limit, $page_offset, $minWeeks, $maxWeeks, $week, $month, $year){
		$builder = $this->db->query('CALL get_ba_dashboard(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
	   		$brand,
		    $brand_ambassador, 
		    $store_name,
		    $ba_type,
		    $sort_field,
		    $sort,
		    $page_limit,
		    $page_offset,
		    $minWeeks,
		    $maxWeeks,
		    $week,
		    $month,
		    $year
		]);
		$data = $builder->getResultArray();
	    $total_records = isset($data[0]['total_records']) ? $data[0]['total_records'] : 0;

	    return [
	        'total_records' => $total_records,
	        'data' => $data
	    ];
	}

	public function getItemClassData($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $limit, $offset, $week, $month, $year) {
	    $query = $this->db->query('CALL get_ba_dashboard_npd(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
	        $brand, 
	        $brand_ambassador, 
	        $store_name, 
	        $ba_type,
	        $sort_field,
	        $sort, 
	        $limit, 
	        $offset,
	        $week,
		    $month,
		    $year
	    ]);

	    $data = $query->getResultArray();
	    $totalRecords = count($data) > 0 ? $data[0]['total_records'] : 0;

	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

	public function getHeroItemsData($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $limit, $offset, $week, $month, $year) {
	    $query = $this->db->query('CALL get_ba_dashboard_hero(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
	        $brand, 
	        $brand_ambassador, 
	        $store_name, 
	        $ba_type,
	        $sort_field,
	        $sort, 
	        $limit, 
	        $offset,
		    $week,
		    $month,
		    $year
	    ]);

	    $data = $query->getResultArray();
	    $totalRecords = count($data) > 0 ? $data[0]['total_records'] : 0;

	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

   	public function getLatestVmi(){
        $builder = $this->db->table('tbl_vmi v')
            ->select('y.id as year_id, m.id as month_id, w.id as week_id')
            ->where('v.status', 1)
            ->join('tbl_week w', 'v.week = w.id')
            ->join('tbl_month m', 'v.month = m.id')
            ->join('tbl_year y', 'v.year = y.id')
            ->orderBy('y.year', 'DESC')
            ->orderBy('m.month', 'DESC')
            ->orderBy('w.name', 'DESC')
            ->limit(1);

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

    //actual
	// public function tradeOverallBaData($store = null, $area = null, $date = null, $sort_field = null, $sort = 'ASC', $limit = 10, $offset = 0, $parameter_from_function = 25)
	// {
	//     // Step 1: Optimized subquery for actual sales
	//     $subquery = $this->db->table('tbl_ba_sales_report')
	//         ->select("area_id, SUM(amount) AS actual_sales, date")
	//         ->where('status', 1)
	//         ->groupBy('area_id')
	//         ->getCompiledSelect();

	//     // Step 2: Main query with proper ranking and sorting
	//     $query = $this->db->table("($subquery) AS aggregated_sps")
	//         ->select("
	//             aggregated_sps.area_id,
	//             tbl_area.description as area,
	//             tbl_store.code as store_code,
	//             tbl_store.description as store_name,
	//             aggregated_sps.actual_sales,
	//             aggregated_sps.date,
	//             COUNT(tbl_ba_sales_report.area_id) OVER() AS total_records,
	//             GROUP_CONCAT(DISTINCT tbl_brand.brand_description ORDER BY tbl_brand.brand_description SEPARATOR ', ') AS brands,
	//             COALESCE(SUM(tbl_target_sales_per_store.january), 0) AS target,
	//             ROUND((aggregated_sps.actual_sales / NULLIF(COALESCE(SUM(tbl_target_sales_per_store.january), 0), 0)) * 100, 2) AS arch,
	//             COALESCE(SUM(tbl_target_sales_per_store.january), 0) - aggregated_sps.actual_sales AS balance_to_target,
	//             COALESCE(aggregated_sps.actual_sales, 0) * 0.01 AS possible_incentives,
	//             CEIL((COALESCE(SUM(tbl_target_sales_per_store.january), 0) - aggregated_sps.actual_sales) / NULLIF($parameter_from_function, 0)) AS target_per_rem_days,
	//             ROUND(COALESCE(SUM(tbl_sell_out_data_details.net_sales), 0), 2) AS ly_scanned_data,
	//             tbl_brand_ambassador.name AS brand_ambassador_name,
	//             tbl_brand_ambassador.deployment_date AS ba_deployment_date,
	//             ROW_NUMBER() OVER (
	//                 ORDER BY 
	//                     CASE 
	//                         WHEN aggregated_sps.actual_sales IS NULL OR aggregated_sps.actual_sales = 0 
	//                         THEN NULL
	//                         ELSE ROUND((aggregated_sps.actual_sales / NULLIF(COALESCE(SUM(tbl_target_sales_per_store.january), 0), 0)) * 100, 2)
	//                     END DESC
	//             ) AS rank,
	//             ROUND(COALESCE(aggregated_sps.actual_sales, 0) / NULLIF(SUM(tbl_sell_out_data_details.net_sales), 0), 2) AS growth
	//         ")
	//         ->join('tbl_ba_sales_report', 'aggregated_sps.area_id = tbl_ba_sales_report.area_id', 'left')
	//         ->join('tbl_store', 'tbl_ba_sales_report.store_id = tbl_store.id', 'inner')
	//         ->join('tbl_area', 'tbl_ba_sales_report.area_id = tbl_area.id', 'inner')
	//         ->join('tbl_brand', 'tbl_ba_sales_report.brand = tbl_brand.id', 'left')
	//         ->join('tbl_target_sales_per_store', 'tbl_ba_sales_report.store_id = tbl_target_sales_per_store.location', 'left')
	//         ->join('tbl_brand_ambassador', 'tbl_ba_sales_report.ba_id = tbl_brand_ambassador.id', 'inner')
	//         ->join('tbl_sell_out_data_details', 'tbl_ba_sales_report.store_id = tbl_sell_out_data_details.store_code', 'left')
	//         ->groupBy('aggregated_sps.area_id');

	//     if (!empty($store)) {
	//         $query->where('tbl_store.id', $store);
	//     }

	//     if (!empty($area)) {
	//         $query->where('tbl_area.id', $area);
	//     }

	//     if (!empty($date)) {
	//         //$query->where('aggregated_sps.date LIKE', '%' . $date . '%');
	//     }

	//     if (in_array($sort_field, ['rank', 'store_code', 'area', 'store', 'actual_sales', 'target', 'arch', 'balance_to_target', 'possible_incentives', 'target_per_rem_days'])) {
	//         $query->orderBy($sort_field, $sort);
	//     } else {
	//         $query->orderBy('rank', 'ASC'); 
	//     }

	//     $query->limit($limit, $offset);

	//     $data = $query->get()->getResult();

	//     $totalRecords = count($data) > 0 ? $data[0]->total_records : 0;

	//     return [
	//         'total_records' => $totalRecords,
	//         'data' => $data
	//     ];
	// }

	public function tradeOverallBaData($limit, $offset, $month = null, $targetYear = null, $lyYear = null, $storeid = null, $areaid = null, $sortField = 'percent_ach', $sortOrder = 'ASC', $remainingDays = null, $salesDate = null) {

	    $allowedSortFields = ['rank', 'store_code', 'area', 'store_name', 'actual_sales', 'target_sales', 'percent_ach', 'balance_to_target', 'possible_incentives', 'target_per_remaining_days', 'ly_scanned_data', 'growth'];
	    if (!in_array($sortField, $allowedSortFields)) {
	        $sortField = 'actual_sales';
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
	            MIN(ba.deployment_date) AS deployment_date
	        FROM tbl_ba_sales_report s
	        LEFT JOIN tbl_brand b ON s.brand = b.id
	        LEFT JOIN tbl_brand_ambassador ba ON ba.area = s.area_id AND ba.store = s.store_id
	        LEFT JOIN tbl_area_sales_coordinator a_asc ON a_asc.area_id = s.area_id
	        WHERE (? IS NULL OR s.date LIKE CONCAT(?, '%'))
	        GROUP BY s.area_id, s.store_id
	    ),
	    targets AS (
	        SELECT 
	             TRIM(t.location) AS store_code,
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
	        s.deployment_date,
	        s.brands,
	        COUNT(s.store_id) OVER() AS total_records,
	        COALESCE(ly.ly_scanned_data, 0) AS ly_scanned_data,
	        ROUND((COALESCE(s.actual_sales, 0) / NULLIF(ly.ly_scanned_data, 0)), 2) AS growth
	    FROM store_mapping sm
	    INNER JOIN sales s ON sm.area_id = s.area_id AND sm.store_id = s.store_id
	    LEFT JOIN targets t ON TRIM(sm.store_code) = TRIM(t.store_code)
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
	   //echo 'asdsad';
	   // die();
	   
	}	
	if (!empty($filters['year_val'])) {
		$year = $filters['year_val'];
		$whereClausesTSPS[] = "(tsps.year = '$year')";	
	}	 

	$whereSQLSR = !empty($whereClausesSR) ? "WHERE " . implode(" AND ", $whereClausesSR) : "";
	$whereSQLSODD = !empty($whereClausesSODD) ? "WHERE " . implode(" AND ", $whereClausesSODD) : "";
	$whereSQLTSPS = !empty($whereClausesTSPS) ? "WHERE " . implode(" AND ", $whereClausesTSPS) : "";
	// print_r($whereSQLSODD);
	// die();
	    $sql = "
	        WITH monthly_totals AS (
			    SELECT 
			        SUM(DISTINCT CASE WHEN MONTH(s.date) = 1 THEN s.amount ELSE 0 END) AS amount_january,
			        SUM(DISTINCT CASE 
			            WHEN MONTH(s.date) = 2 THEN s.amount 
			            ELSE 0 
			        END) AS amount_february,
			        
			        SUM(DISTINCT CASE 
			            WHEN MONTH(s.date) = 3 THEN s.amount 
			            ELSE 0 
			        END) AS amount_march,
			        
			        SUM(DISTINCT CASE 
			            WHEN MONTH(s.date) = 4 THEN s.amount 
			            ELSE 0 
			        END) AS amount_april,
			        
			        SUM(DISTINCT CASE 
			            WHEN MONTH(s.date) = 5 THEN s.amount 
			            ELSE 0 
			        END) AS amount_may,
			        
			        SUM(DISTINCT CASE 
			            WHEN MONTH(s.date) = 6 THEN s.amount 
			            ELSE 0 
			        END) AS amount_june,
			        
			        SUM(DISTINCT CASE 
			            WHEN MONTH(s.date) = 7 THEN s.amount 
			            ELSE 0 
			        END) AS amount_july,
			        
			        SUM(DISTINCT CASE 
			            WHEN MONTH(s.date) = 8 THEN s.amount 
			            ELSE 0 
			        END) AS amount_august,
			        
			        SUM(DISTINCT CASE 
			            WHEN MONTH(s.date) = 9 THEN s.amount 
			            ELSE 0 
			        END) AS amount_september,
			        
			        SUM(DISTINCT CASE 
			            WHEN MONTH(s.date) = 10 THEN s.amount 
			            ELSE 0 
			        END) AS amount_october,
			        
			        SUM(DISTINCT CASE 
			            WHEN MONTH(s.date) = 11 THEN s.amount 
			            ELSE 0 
			        END) AS amount_november,
			        
			        SUM(DISTINCT CASE 
			            WHEN MONTH(s.date) = 12 THEN s.amount 
			            ELSE 0 
			        END) AS amount_december,
                	GROUP_CONCAT(DISTINCT b.brand_description ORDER BY b.brand_description SEPARATOR ', ') AS brands,
		            GROUP_CONCAT(DISTINCT ba.name ORDER BY ba.name SEPARATOR ', ') AS brand_ambassadors,
		            GROUP_CONCAT(DISTINCT a_asc.description ORDER BY a_asc.description SEPARATOR ', ') AS asc_names,
		            GROUP_CONCAT(DISTINCT st.description ORDER BY st.description SEPARATOR ', ') AS bsr_stores,
		            GROUP_CONCAT(DISTINCT ar.description ORDER BY ar.description SEPARATOR ', ') AS bsr_areas
	            FROM tbl_ba_sales_report s
	            LEFT JOIN tbl_brand b ON s.brand = b.id
		        LEFT JOIN tbl_brand_ambassador ba ON ba.area = s.area_id AND ba.store = s.store_id
		        LEFT JOIN tbl_area_sales_coordinator a_asc ON a_asc.area_id = s.area_id
		        LEFT JOIN tbl_store st ON s.store_id = st.id
		        LEFT JOIN tbl_area ar ON s.area_id = ar.id
				$whereSQLSR
			        
	        ),
	        net_sales_totals AS (
            SELECT 
                ROUND(SUM(CASE WHEN sodd.month = 1 THEN sodd.net_sales ELSE 0 END), 2) AS net_sales_january,
                ROUND(SUM(CASE WHEN sodd.month = 2 THEN sodd.net_sales ELSE 0 END), 2) AS net_sales_february,
                ROUND(SUM(CASE WHEN sodd.month = 3 THEN sodd.net_sales ELSE 0 END), 2) AS net_sales_march,
                ROUND(SUM(CASE WHEN sodd.month = 4 THEN sodd.net_sales ELSE 0 END), 2) AS net_sales_april,
                ROUND(SUM(CASE WHEN sodd.month = 5 THEN sodd.net_sales ELSE 0 END), 2) AS net_sales_may,
                ROUND(SUM(CASE WHEN sodd.month = 6 THEN sodd.net_sales ELSE 0 END), 2) AS net_sales_june,
                ROUND(SUM(CASE WHEN sodd.month = 7 THEN sodd.net_sales ELSE 0 END), 2) AS net_sales_july,
                ROUND(SUM(CASE WHEN sodd.month = 8 THEN sodd.net_sales ELSE 0 END), 2) AS net_sales_august,
                ROUND(SUM(CASE WHEN sodd.month = 9 THEN sodd.net_sales ELSE 0 END), 2) AS net_sales_september,
                ROUND(SUM(CASE WHEN sodd.month = 10 THEN sodd.net_sales ELSE 0 END), 2) AS net_sales_october,
                ROUND(SUM(CASE WHEN sodd.month = 11 THEN sodd.net_sales ELSE 0 END), 2) AS net_sales_november,
                ROUND(SUM(CASE WHEN sodd.month = 12 THEN sodd.net_sales ELSE 0 END), 2) AS net_sales_december,
                GROUP_CONCAT(DISTINCT st.description ORDER BY st.description SEPARATOR ', ') AS sodd_stores,
                GROUP_CONCAT(DISTINCT b.brand_description ORDER BY b.brand_description SEPARATOR ', ') AS sodd_brands,
        		GROUP_CONCAT(DISTINCT ba.name ORDER BY ba.name SEPARATOR ', ') AS sodd_brand_ambassadors,
        		GROUP_CONCAT(DISTINCT a_asc.description ORDER BY a_asc.description SEPARATOR ', ') AS sodd_asc_names,
        		GROUP_CONCAT(DISTINCT ar.description ORDER BY ar.description SEPARATOR ', ') AS sodd_areas
	        FROM tbl_sell_out_data_details sodd
	        LEFT JOIN tbl_store st ON st.code = sodd.store_code
	        LEFT JOIN tbl_brand_ambassador ba ON ba.store = st.id
	        LEFT JOIN tbl_ba_brands bb ON ba.id = bb.ba_id
	        LEFT JOIN tbl_brand b ON bb.brand_id = b.id
	        LEFT JOIN tbl_area_sales_coordinator a_asc ON ba.area = a_asc.area_id
	        LEFT JOIN tbl_area ar ON ar.id = a_asc.area_id
	        $whereSQLSODD
	        ),
	        target_sales_totals AS (
            SELECT 
                COALESCE(SUM(tsps.january), 0) AS target_sales_january,
                COALESCE(SUM(tsps.february), 0) AS target_sales_february,
                COALESCE(SUM(tsps.march), 0) AS target_sales_march,
                COALESCE(SUM(tsps.april), 0) AS target_sales_april,
                COALESCE(SUM(tsps.may), 0) AS target_sales_may,
                COALESCE(SUM(tsps.june), 0) AS target_sales_june,
                COALESCE(SUM(tsps.july), 0) AS target_sales_july,
                COALESCE(SUM(tsps.august), 0) AS target_sales_august,
                COALESCE(SUM(tsps.september), 0) AS target_sales_september,
                COALESCE(SUM(tsps.october), 0) AS target_sales_october,
                COALESCE(SUM(tsps.november), 0) AS target_sales_november,
                COALESCE(SUM(tsps.december), 0) AS target_sales_december,
                GROUP_CONCAT(DISTINCT st.description ORDER BY st.description SEPARATOR ', ') AS tsps_stores,
                GROUP_CONCAT(DISTINCT b.brand_description ORDER BY b.brand_description SEPARATOR ', ') AS tsps_brands,
        		GROUP_CONCAT(DISTINCT ba.name ORDER BY ba.name SEPARATOR ', ') AS tsps_brand_ambassadors,
        		GROUP_CONCAT(DISTINCT a_asc.description ORDER BY a_asc.description SEPARATOR ', ') AS tsps_asc_names,
        		GROUP_CONCAT(DISTINCT ar.description ORDER BY ar.description SEPARATOR ', ') AS tsps_areas
	        FROM tbl_target_sales_per_store tsps
	        LEFT JOIN tbl_store st ON st.code = tsps.location
	        LEFT JOIN tbl_brand_ambassador ba ON ba.store = st.id
	        LEFT JOIN tbl_ba_brands bb ON ba.id = bb.ba_id
	        LEFT JOIN tbl_brand b ON bb.brand_id = b.id
	        LEFT JOIN tbl_area_sales_coordinator a_asc ON ba.area = a_asc.area_id
	        LEFT JOIN tbl_area ar ON ar.id = a_asc.area_id
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

	    // Execute query
	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();

	    return [
	        'data' => $data
	    ];
	}

	public function asctest2($year, $minWeeks, $maxWeeks, $brand, $brand_ambassador, $store_name, $ba_type, $page_limit, $page_offset)
	{
	    $sql = "
	        WITH aggregated_vmi AS (
	            SELECT 
	                item,
	                item_name,
	                SUM(on_hand) AS total_on_hand,
	                SUM(in_transit) AS total_in_transit,
	                SUM(on_hand + in_transit) AS sum_total_qty,
	                SUM(average_sales_unit) AS sum_ave_sales,
	                ROUND(
	                    CASE 
	                        WHEN SUM(average_sales_unit) > 0 
	                        THEN SUM(on_hand + in_transit) / SUM(average_sales_unit) 
	                        ELSE 0 
	                    END, 2
	                ) AS weeks
	            FROM tbl_vmi
	            WHERE status = 1
	              AND year = ?
	            GROUP BY item
	            HAVING weeks > ?
	              AND (? IS NULL OR weeks < ?)
	        )
	        SELECT 
	            vmi.item,
	            vmi.item_name,
	            vmi.total_on_hand,
	            vmi.total_in_transit,
	            vmi.sum_total_qty,
	            vmi.sum_ave_sales,
	            vmi.weeks,
	            GROUP_CONCAT(DISTINCT ba.name ORDER BY ba.name SEPARATOR ', ') AS ambassador_names,
	            GROUP_CONCAT(DISTINCT b.brand_description ORDER BY b.brand_description SEPARATOR ', ') AS brands,
	            GROUP_CONCAT(DISTINCT s.description ORDER BY s.description SEPARATOR ', ') AS store_names,
	            COUNT(*) OVER() AS total_records
	        FROM aggregated_vmi vmi
	        LEFT JOIN tbl_vmi tv ON vmi.item = tv.item
	        LEFT JOIN tbl_brand_ambassador ba ON tv.store = ba.store
	        LEFT JOIN tbl_store s ON ba.store = s.id
	        LEFT JOIN tbl_ba_brands bb ON ba.id = bb.ba_id
	        LEFT JOIN tbl_brand b ON b.id = bb.brand_id
	        WHERE (? IS NULL OR b.id = ?)
	          AND (? IS NULL OR ba.id = ?)
	          AND (? IS NULL OR s.id = ?)
	          AND (? = 3 OR ba.type = ?)
	        GROUP BY vmi.item, vmi.item_name
	        LIMIT ? OFFSET ?";

	    $params = [
	        $year, $minWeeks, $maxWeeks, $maxWeeks, 
	        $brand, $brand, 
	        $brand_ambassador, $brand_ambassador, 
	        $store_name, $store_name, 
	        $ba_type, $ba_type, 
	        $page_limit, $page_offset
	    ];

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();

	    return [
	        'data' => $data
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

}
