<?php

namespace App\Models;

use CodeIgniter\Model;

class Dashboard_model extends Model
{

	public function dataPerStore($pageLimit, $pageOffset, $minWeeks, $maxWeeks, $week, $year, $brandIds = null, $baId = null, $baType = null, $areaId = null, $ascId = null, $storeId = null, $companyId = 3, $ItemClassIds = null, $itemCatId = null)
	{
		$baType = ($baType !== null) ? strval($baType) : null;
	    $storeFilterConditions = [];

	    if (!empty($baId)) {
	        $baIds = array_map('intval', preg_split('/\s*or\s*/i', $baId));
	        $baConds = array_map(fn($id) => "FIND_IN_SET($id, v.ba_ids)", $baIds);
	        $storeFilterConditions[] = '(' . implode(' OR ', $baConds) . ')';
	    }

		if (!empty($brandIds)) {
		    $brandIds = array_map('intval', $brandIds);
		    $brandConds = array_map(fn($id) => "FIND_IN_SET($id, v.brand_ids)", $brandIds);
		    $storeFilterConditions[] = '(' . implode(' OR ', $brandConds) . ')';
		}

		$storeFilterConditionsVmi = [];
		if (!empty($ItemClassIds)) {
		    $ItemClassIds = array_map('trim', $ItemClassIds); // remove any leading/trailing spaces
		    $ItemClassIdsConds = array_map(fn($class) => "FIND_IN_SET(" . db_connect()->escape($class) . ", vmi.item_class)", $ItemClassIds);
		    $storeFilterConditionsVmi[] = '(' . implode(' OR ', $ItemClassIdsConds) . ')';
		}


	    $storeFilterSQL = !empty($storeFilterConditions)
	        ? 'WHERE ' . implode(' AND ', $storeFilterConditions)
	        : '';

	    $storeFilterSQLVmi = !empty($storeFilterConditionsVmi)
		    ? ' AND ' . implode(' AND ', $storeFilterConditionsVmi)
		    : '';

	    $sort_field = 'sum_total_qty';
	    $sort = 'DESC';

	    $baTypeFilter = ($baType !== null && $baType != 3) ? ' AND v.ba_types = ?' : '';
	    $baTypeParams = ($baType !== null && $baType != 3) ? [$baType] : [];

	    $companyIdFilter = ($companyId !== null && $companyId != 3) ? ' AND v.company = ?' : '';
	    $companyIdParams = ($companyId !== null && $companyId != 3) ? [$companyId] : [];

	    $storeFilter = ($storeId !== null) ? ' AND v.store_id = ?' : '';
	    $storeParams = ($storeId !== null) ? [$storeId] : [];

	    // Same filters for main query (alias vmi instead of v)
	    $baTypeFilterVmi = str_replace('v.', 'vmi.', $baTypeFilter);
		$companyIdFilterVmi = str_replace('v.', 'vmi.', $companyIdFilter);
	    $storeFilterVmi = str_replace('v.', 'vmi.', $storeFilter);

		$ascIdFilter = '';
		$ascIdFilterVmi = '';
		$ascIdParams = [];

		if ($ascId !== null) {
		    $ascIdFilter = ' AND v.asc_id = ?';
		    $ascIdFilterVmi = ' AND vmi.asc_id = ?';
		    $ascIdParams = [$ascId];
		}

		$itemCatIdFilter = '';
		$itemCatIdFilterVmi = '';
		$itemCatIdParams = [];

		if ($itemCatId !== null) {
		    $itemCatIdFilter = ' AND v.brand_type_id = ?';
		    $itemCatIdFilterVmi = ' AND vmi.brand_type_id = ?';
		    $itemCatIdParams = [$itemCatId];
		}

		$areaIdFilter = '';
		$areaIdFilterVmi = '';
		$areaIdParams = [];

		if ($areaId !== null) {
		    $areaIdFilter = ' AND v.area_id = ?';
		    $areaIdFilterVmi = ' AND vmi.area_id = ?';
		    $areaIdParams = [$areaId];
		}

	    $sql = "
	        WITH filtered_stores AS (
	            SELECT DISTINCT v.store_id
	            FROM tbl_vmi_pre_aggregated_data v
	            WHERE v.week = ?
	              AND v.year = ?
	              {$ascIdFilter}
	              {$areaIdFilter}
	              {$itemCatIdFilter}
	              $baTypeFilter
	              $companyIdFilter
	              $storeFilter
	        ),
	        store_matches AS (
	            SELECT fs.store_id
	            FROM filtered_stores fs
	            JOIN tbl_vmi_pre_aggregated_data v ON fs.store_id = v.store_id
	            $storeFilterSQL
	            GROUP BY fs.store_id
	        )
	        SELECT 
	            vmi.item,
	            vmi.item_name,
	            vmi.area_id,
	            vmi.itmcde,
	            vmi.item_class,
	            vmi.brand_type_id, 
	            GROUP_CONCAT(DISTINCT vmi.company) AS company,
	            COALESCE(NULLIF(vmi.itmcde, ''), 'N / A') AS itmcde,
	            FORMAT(SUM(vmi.total_qty), 2) AS sum_total_qty,
	            SUM(vmi.average_sales_unit) AS sum_ave_sales,
	            FORMAT( SUM(vmi.total_qty) / SUM(vmi.average_sales_unit), 2) AS swc,
	            ROUND(
	                CASE 
	                    WHEN SUM(vmi.average_sales_unit) > 0 
	                    THEN SUM(vmi.total_qty) / SUM(vmi.average_sales_unit) 
	                    ELSE 0 
	                END, 2
	            ) AS weeks,
				GROUP_CONCAT(DISTINCT vmi.ba_ids) AS ba_ids,
				GROUP_CONCAT(DISTINCT CASE WHEN vmi.ba_types IS NOT NULL AND vmi.ba_types != '' THEN vmi.ba_types END) AS ba_types,
				GROUP_CONCAT(DISTINCT vmi.brand_ids) AS brand_ids,
				GROUP_CONCAT(DISTINCT vmi.asc_id) AS asc_ids,
				GROUP_CONCAT(DISTINCT vmi.store_id) AS store_ids,
	            COUNT(*) OVER() AS total_records
	        FROM tbl_vmi_pre_aggregated_data vmi
	        JOIN store_matches sm ON vmi.store_id = sm.store_id
	        WHERE vmi.week = ?
	          AND vmi.year = ?
	          {$ascIdFilterVmi}
	          {$areaIdFilterVmi}
	          {$itemCatIdFilterVmi}
	          $baTypeFilterVmi
	          $companyIdFilterVmi
	          $storeFilterVmi
	          $storeFilterSQLVmi
	        GROUP BY vmi.item
	        HAVING weeks > ?
	           AND (? IS NULL OR weeks < ?)
	        ORDER BY $sort_field $sort
	        LIMIT ? OFFSET ?
	    ";

		$params = [];

		$params[] = $week;
		$params[] = $year;
		if ($ascId !== null) $params[] = $ascId;
		if ($areaId !== null) $params[] = $areaId;
		if ($itemCatId !== null) $params[] = $itemCatId;
		$params = array_merge($params, $baTypeParams, $companyIdParams, $storeParams);

		# Params for main SELECT
		$params[] = $week;
		$params[] = $year;
		if ($ascId !== null) $params[] = $ascId;
		if ($areaId !== null) $params[] = $areaId;
		if ($itemCatId !== null) $params[] = $itemCatId;
		$params = array_merge($params, $baTypeParams, $companyIdParams, $storeParams);


	    $params = array_merge($params, [$minWeeks, $maxWeeks, $maxWeeks, (int)$pageLimit, (int)$pageOffset]);

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();
	    $totalRecords = isset($data[0]->total_records) ? $data[0]->total_records : 0;

	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

	public function getItemClassNPDHEROData($pageLimit, $pageOffset, $week, $year, $brandIds = null, $baId = null, $baType = null, $areaId = null, $ascId = null, $storeId = null, $ItemClassIdsFilter = null, $companyId = 3, $ItemClassIds = null, $itemCatId = null) {

		$baType = ($baType !== null) ? strval($baType) : null;
	    $storeFilterConditions = [];

	    if (!empty($baId)) {
	        $baIds = array_map('intval', preg_split('/\s*or\s*/i', $baId));
	        $baConds = array_map(fn($id) => "FIND_IN_SET($id, v.ba_ids)", $baIds);
	        $storeFilterConditions[] = '(' . implode(' OR ', $baConds) . ')';
	    }

	    if (!empty($brandIds)) {
	        $brandIds = array_map('intval', $brandIds);
	        $brandConds = array_map(fn($id) => "FIND_IN_SET($id, v.brand_ids)", $brandIds);
	        $storeFilterConditions[] = '(' . implode(' OR ', $brandConds) . ')';
	    }

		$storeFilterConditionsVmi = [];
		if (!empty($ItemClassIds)) {
		    $ItemClassIds = array_map('trim', $ItemClassIds); // remove any leading/trailing spaces
		    $ItemClassIdsConds = array_map(fn($class) => "FIND_IN_SET(" . db_connect()->escape($class) . ", vmi.item_class)", $ItemClassIds);
		    $storeFilterConditionsVmi[] = '(' . implode(' OR ', $ItemClassIdsConds) . ')';
		}

	    $storeFilterSQL = !empty($storeFilterConditions)
	        ? 'WHERE ' . implode(' AND ', $storeFilterConditions)
	        : '';

	    $storeFilterSQLVmi = !empty($storeFilterConditionsVmi)
		    ? ' AND ' . implode(' AND ', $storeFilterConditionsVmi)
		    : '';

	    $sort_field = 'sum_total_qty';
	    $sort = 'DESC';

	    $ItemClassIdsPlaceholder = '';
	    $ItemClassIdsParams = [];
	    if (!empty($ItemClassIdsFilter)) {
	        $ItemClassIdsPlaceholder = ' AND v.item_class IN (' . implode(',', array_fill(0, count($ItemClassIdsFilter), '?')) . ')';
	        $ItemClassIdsParams = $ItemClassIdsFilter;
	    }

	    $baTypeFilter = ($baType !== null && $baType != 3) ? ' AND v.ba_types = ?' : '';
	    $baTypeParams = ($baType !== null && $baType != 3) ? [$baType] : [];

	    $companyIdFilter = ($companyId !== null && $companyId != 3) ? ' AND v.company = ?' : '';
	    $companyIdParams = ($companyId !== null && $companyId != 3) ? [$companyId] : [];

	    $storeFilter = ($storeId !== null) ? ' AND v.store_id = ?' : '';
	    $storeParams = ($storeId !== null) ? [$storeId] : [];

	    $ItemClassIdsPlaceholderVmi = str_replace('v.', 'vmi.', $ItemClassIdsPlaceholder);
		$companyIdFilterVmi = str_replace('v.', 'vmi.', $companyIdFilter);
	    $baTypeFilterVmi = str_replace('v.', 'vmi.', $baTypeFilter);
	    $storeFilterVmi = str_replace('v.', 'vmi.', $storeFilter);

		$ascIdFilter = '';
		$ascIdFilterVmi = '';
		$ascIdParams = [];

		if ($ascId !== null) {
		    $ascIdFilter = ' AND v.asc_id = ?';
		    $ascIdFilterVmi = ' AND vmi.asc_id = ?';
		    $ascIdParams = [$ascId];
		}

		$itemCatIdFilter = '';
		$itemCatIdFilterVmi = '';
		$itemCatIdParams = [];

		if ($itemCatId !== null) {
		    $itemCatIdFilter = ' AND v.brand_type_id = ?';
		    $itemCatIdFilterVmi = ' AND vmi.brand_type_id = ?';
		    $itemCatIdParams = [$itemCatId];
		}


		$areaIdFilter = '';
		$areaIdFilterVmi = '';
		$areaIdParams = [];

		if ($areaId !== null) {
		    $areaIdFilter = ' AND v.area_id = ?';
		    $areaIdFilterVmi = ' AND vmi.area_id = ?';
		    $areaIdParams = [$areaId];
		}

	    $sql = "
	        WITH filtered_stores AS (
	            SELECT DISTINCT v.store_id
	            FROM tbl_vmi_pre_aggregated_data v
	            WHERE v.week = ?
	              AND v.year = ?
	              {$ascIdFilter}
	              {$areaIdFilter}
	              {$itemCatIdFilter}
	              $ItemClassIdsPlaceholder
	              $baTypeFilter
	              $companyIdFilter
	              $storeFilter
	        ),
	        store_matches AS (
	            SELECT fs.store_id
	            FROM filtered_stores fs
	            JOIN tbl_vmi_pre_aggregated_data v ON fs.store_id = v.store_id
	            $storeFilterSQL
	            GROUP BY fs.store_id
	        )
	        SELECT 
	            vmi.item,
	            vmi.item_name,
	            vmi.item_class,
	            vmi.area_id,
	            vmi.itmcde,
	            vmi.item_class,
	            vmi.brand_type_id, 
	            GROUP_CONCAT(DISTINCT vmi.company) AS company,
	            COALESCE(NULLIF(vmi.itmcde, ''), 'N / A') AS itmcde,
	            FORMAT(SUM(vmi.total_qty), 2) AS sum_total_qty,
	            SUM(vmi.average_sales_unit) AS sum_ave_sales,
	            FORMAT( SUM(vmi.total_qty) / SUM(vmi.average_sales_unit), 2) AS swc,
	            ROUND(
	                CASE 
	                    WHEN SUM(vmi.average_sales_unit) > 0 
	                    THEN SUM(vmi.total_qty) / SUM(vmi.average_sales_unit) 
	                    ELSE 0 
	                END, 2
	            ) AS weeks,
				GROUP_CONCAT(DISTINCT vmi.ba_ids) AS ba_ids,
				GROUP_CONCAT(DISTINCT CASE WHEN vmi.ba_types IS NOT NULL AND vmi.ba_types != '' THEN vmi.ba_types END) AS ba_types,
				GROUP_CONCAT(DISTINCT vmi.brand_ids) AS brand_ids,
				GROUP_CONCAT(DISTINCT vmi.asc_id) AS asc_ids,
				GROUP_CONCAT(DISTINCT vmi.store_id) AS store_ids,
	            COUNT(*) OVER() AS total_records
	        FROM tbl_vmi_pre_aggregated_data vmi
	        JOIN store_matches sm ON vmi.store_id = sm.store_id
	        WHERE vmi.week = ?
	          AND vmi.year = ?
	          {$ascIdFilterVmi}
	          {$areaIdFilterVmi}
	          {$itemCatIdFilterVmi}
	          $ItemClassIdsPlaceholderVmi
	          $baTypeFilterVmi
	          $companyIdFilterVmi
	          $storeFilterVmi
	          $storeFilterSQLVmi
	        GROUP BY vmi.item
	        ORDER BY $sort_field $sort
	        LIMIT ? OFFSET ?
	    ";

		$params = [];

		$params[] = $week;
		$params[] = $year;
		if ($ascId !== null) $params[] = $ascId;
		if ($areaId !== null) $params[] = $areaId;
		if ($itemCatId !== null) $params[] = $itemCatId;
		$params = array_merge($params, $ItemClassIdsParams, $baTypeParams, $companyIdParams, $storeParams);

		# Params for main SELECT
		$params[] = $week;
		$params[] = $year;
		if ($ascId !== null) $params[] = $ascId;
		if ($areaId !== null) $params[] = $areaId;
		if ($itemCatId !== null) $params[] = $itemCatId;
		$params = array_merge($params, $ItemClassIdsParams, $baTypeParams, $companyIdParams, $storeParams);

		# Pagination
		$params[] = (int)$pageLimit;
		$params[] = (int)$pageOffset;

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
			->select('y.id as year_id, y.year, c.id as company_id, c.name as company_name, v.week AS week_id')
	        ->where('v.status', 1)
	        ->join('tbl_company c', 'v.company = c.id')
	        ->join('tbl_year y', 'v.year = y.id')
	        ->orderBy('y.year', 'DESC')
	        ->orderBy('v.week', 'DESC')
	        ->orderBy('c.name', 'DESC')
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

   	public function getYear($year){
        $results = $this->db->table('tbl_year')
            ->select('id, year')
            ->where('year', $year)
            ->get()
            ->getResultArray();

            return $results;
    }

	public function salesPerformancePerBa($limit, $offset, $orderByColumn, $orderDirection, $target_sales, $incentiveRate, $monthFrom = null, $monthTo = null, $lyYear = null, $tyYear = null, $yearId = null, $storeid = null, $areaid = null, $ascid = null, $baid = null, $baTypeId = null, $remainingDays = null, $brand_category = null, $brandIds = null)
	{
		$range = ($monthTo - $monthFrom) + 1;
		$startDate = $tyYear .'-'. $monthFrom . '-01';
		$endDate = $tyYear .'-'. $monthTo . '-31';
		$brandIds = is_array($brandIds) ? $brandIds : [];

		$additionalWhere = [];
		$brandTypeCondition = '';
		if (!empty($brand_category)) {
		    $escapedCats = array_map('intval', $brand_category);
		    $brandTypeCondition .= ' AND brand_type_id IN (' . implode(',', $escapedCats) . ')';
		    
		}


	    $allowedOrderColumns = ['rank', 'store_id', 'store_code', 'actual_sales', 'target_sales', 'percent_ach', 'balance_to_target', 'possible_incentives', 'target_per_remaining_days', 'ly_scanned_data', 'growth'];
	    $allowedOrderDirections = ['ASC', 'DESC'];

	    if (!in_array($orderByColumn, $allowedOrderColumns)) {
	        $orderByColumn = 'rank';
	    }

	    if (!in_array(strtoupper($orderDirection), $allowedOrderDirections)) {
	        $orderDirection = 'ASC';
	    }

		$baTypeCondition = '';
		$baTypeConditionASR = '';
		if (!is_null($baTypeId) && intval($baTypeId) !== 3) {
		    $baTypeCondition = 'AND t.ba_types = ?';
		    $baTypeConditionASR = 'AND ba_type = ?';
		    $brandTypeCondition .= " AND CAST(brand_term_id AS UNSIGNED) = ? ";
	        $brandTypeCondition .= " AND CAST(ba_types AS UNSIGNED) = ? ";
        	//$brandTypeCondition .= " AND CAST(ba_type AS UNSIGNED) = ? ";
		}

		$monthColumns = [
		    1 => 'january', 2 => 'february', 3 => 'march', 4 => 'april',
		    5 => 'may', 6 => 'june', 7 => 'july', 8 => 'august',
		    9 => 'september', 10 => 'october', 11 => 'november', 12 => 'december'
		];

		$targetSalesSum = [];
		$params = [];

		for ($m = $monthFrom; $m <= $monthTo; $m++) {
		    if (isset($monthColumns[$m])) {
		        $targetSalesSum[] = "COALESCE(t." . $monthColumns[$m] . ", 0)";
		    }
		}
		$targetSalesSQL = implode(' + ', $targetSalesSum);

	    $sql = "
	    WITH ly_scanned AS (
	        SELECT 
	            store_code,
	            company,
	            itmcde,
	            brncde,
	            brand_type_id,
	            SUM(COALESCE(gross_sales, 0)) AS ly_scanned_data
	        FROM tbl_sell_out_pre_aggregated_data
	        WHERE (? IS NULL OR year = ?) 
	          AND (? IS NULL OR month BETWEEN ? AND ?)
	          $brandTypeCondition
	        GROUP BY store_code
	    ),
		targets AS (
		    SELECT 
		        t.location AS location,
		        t.ba_code,
		        (SELECT GROUP_CONCAT(DISTINCT ba2.type)
		         FROM tbl_brand_ambassador ba2 
		         WHERE FIND_IN_SET(ba2.code, t.ba_code)) AS target_ba_types,
		        SUM($targetSalesSQL) AS target_sales
		    FROM tbl_target_sales_per_store t
		    WHERE (? IS NULL OR t.year = ?)
		    		AND t.status = 1
			$baTypeCondition
		    GROUP BY t.location, t.ba_code, t.year
		)
		SELECT
		    ROW_NUMBER() OVER (ORDER BY percent_ach DESC) AS rank,
		    s.brand,
		    s.area_id,
		    s.asc_id,
		    d_asc.description AS asc_name,
		    a.description AS area_name,
		    s.ba_id,
		    t.ba_code,
		    ba.type,
		    t.target_ba_types,
		    (LENGTH(t.ba_code) - LENGTH(REPLACE(t.ba_code, ',', '')) + 1) AS ba_count,
		    ly.company,
		    ly.brand_type_id,
		    s.store_id,
		    GROUP_CONCAT(DISTINCT b.brand_description ORDER BY b.brand_description SEPARATOR ', ') AS brand_name,
		    st.code AS store_code,
		    CONCAT(MAX(st.code), ' - ', st.description) AS store_name,
		    a.description AS area_name,
		    ba.name AS ba_name,
		    ba.deployment_date AS ba_deployment_date, 

		    sd.actual_sales,

		    CASE
		        WHEN ba.type = 0 THEN FORMAT(? * ?, 2)
		        WHEN t.target_ba_types = 1 AND 
		             (LENGTH(t.ba_code) - LENGTH(REPLACE(t.ba_code, ',', '')) + 1) >= 2 THEN 
		            FORMAT(
		                ROUND(
		                    (COALESCE(t.target_sales, 0) * 1.3) / 
		                    NULLIF((LENGTH(t.ba_code) - LENGTH(REPLACE(t.ba_code, ',', '')) + 1), 0), 
		                2), 2
		            )
		        WHEN t.target_ba_types = 1 THEN FORMAT(COALESCE(t.target_sales, 0), 2)
		        WHEN t.target_ba_types = 0 THEN FORMAT(?, 2)
		        ELSE FORMAT(COALESCE(t.target_sales, 0), 2)
		    END AS target_sales,

		    ROUND(sd.actual_sales * ?, 2) AS possible_incentives,

		    ROUND((
		        CASE 
		            WHEN t.target_ba_types = 1 AND 
		                 (LENGTH(t.ba_code) - LENGTH(REPLACE(t.ba_code, ',', '')) + 1) >= 2 THEN 
		                (COALESCE(t.target_sales, 0) * 1.3) / 
		                NULLIF((LENGTH(t.ba_code) - LENGTH(REPLACE(t.ba_code, ',', '')) + 1), 0)
		            WHEN t.target_ba_types = 1 THEN COALESCE(t.target_sales, 0)
		            WHEN t.target_ba_types = 0 THEN ?
		            ELSE COALESCE(t.target_sales, 0)
		        END - sd.actual_sales), 2
		    ) AS balance_to_target,

		    ROUND(
		        sd.actual_sales / 
		        NULLIF((
		            CASE 
		                WHEN t.target_ba_types = 1 AND 
		                     (LENGTH(t.ba_code) - LENGTH(REPLACE(t.ba_code, ',', '')) + 1) >= 2 THEN 
		                    (COALESCE(t.target_sales, 0) * 1.3) / 
		                    NULLIF((LENGTH(t.ba_code) - LENGTH(REPLACE(t.ba_code, ',', '')) + 1), 0)
		                WHEN t.target_ba_types = 1 THEN COALESCE(t.target_sales, 0)
		                WHEN t.target_ba_types = 0 THEN ?
		                ELSE COALESCE(t.target_sales, 0)
		            END
		        ), 0) * 100, 2
		    ) AS percent_ach,

		    FORMAT(
		        CASE 
		            WHEN t.ba_code IS NOT NULL AND t.ba_code != '' THEN 
		                ROUND(COALESCE(ly.ly_scanned_data, 0) / 
		                     (LENGTH(t.ba_code) - LENGTH(REPLACE(t.ba_code, ',', '')) + 1), 2)
		            ELSE COALESCE(ly.ly_scanned_data, 0)
		        END, 2
		    ) AS ly_scanned_data,

		    CASE 
		        WHEN t.ba_code IS NOT NULL AND t.ba_code != '' THEN
		            ROUND(
		                (sd.actual_sales /
		                NULLIF(
		                    COALESCE(ly.ly_scanned_data, 0) / 
		                    (LENGTH(t.ba_code) - LENGTH(REPLACE(t.ba_code, ',', '')) + 1), 
		                0)) * 100, 2)
		        ELSE
		            ROUND((sd.actual_sales / NULLIF(ly.ly_scanned_data, 0)) * 100, 2)
		    END AS growth,

		    CASE 
		        WHEN ? > 0 THEN CEIL((
		            CASE 
		                WHEN t.target_ba_types = 1 AND 
		                     (LENGTH(t.ba_code) - LENGTH(REPLACE(t.ba_code, ',', '')) + 1) >= 2 THEN 
		                    (COALESCE(t.target_sales, 0) * 1.3) / 
		                    NULLIF((LENGTH(t.ba_code) - LENGTH(REPLACE(t.ba_code, ',', '')) + 1), 0)
		                WHEN t.target_ba_types = 1 THEN COALESCE(t.target_sales, 0)
		                WHEN t.target_ba_types = 0 THEN ?
		                ELSE COALESCE(t.target_sales, 0)
		            END - sd.actual_sales) / ?
		        )
		        ELSE NULL
		    END AS target_per_remaining_days,

		    COUNT(*) OVER() AS total_records

		FROM (
		    SELECT 
		        store_id,
		        ba_id,
		        area_id,
		        SUM(COALESCE(amount, 0)) AS actual_sales
		    FROM tbl_ba_sales_report
		    WHERE (? IS NULL OR date BETWEEN ? AND ?)
		      AND (? IS NULL OR area_id = ?)
		      AND (? IS NULL OR store_id = ?)
		      AND (? IS NULL OR asc_id = ?)
		      AND (? IS NULL OR ba_id = ?)
		      $baTypeConditionASR
		    GROUP BY store_id, ba_id, area_id
		) AS sd

		LEFT JOIN tbl_ba_sales_report s ON s.store_id = sd.store_id AND s.ba_id = sd.ba_id AND s.area_id = sd.area_id
		LEFT JOIN tbl_store st ON st.id = s.store_id
		LEFT JOIN tbl_area a ON a.id = s.area_id
		LEFT JOIN tbl_brand_ambassador ba ON ba.id = s.ba_id
		LEFT JOIN ly_scanned ly ON s.store_code = ly.store_code
		LEFT JOIN targets t ON s.store_code = t.location
		LEFT JOIN tbl_ba_brands bb ON ba.id = bb.ba_id
		LEFT JOIN tbl_brand b ON b.id = bb.brand_id
		LEFT JOIN tbl_area_sales_coordinator d_asc ON s.asc_id = d_asc.id

		WHERE (" . (empty($brandIds) ? "1=1" : "b.id IN (" . implode(',', array_fill(0, count($brandIds), '?')) . ")") . ")

		GROUP BY s.store_id, s.ba_id, s.area_id

		ORDER BY {$orderByColumn} {$orderDirection}
		LIMIT ? OFFSET ?

	    ";

		$params = [
		    $lyYear, $lyYear, 
		    $monthFrom, $monthFrom, $monthTo,
		];

		if (!is_null($baTypeId) && intval($baTypeId) !== 3) {
		    $params[] = $baTypeId;
		    $params[] = $baTypeId;
		}

	    $params[] = $yearId;
	    $params[] = $yearId;

		if (!is_null($baTypeId) && intval($baTypeId) !== 3) {
		    $params[] = $baTypeId;
		}

		$params[] = $range;
		$params[] = $target_sales; 
	    $params[] = $target_sales;
	    $params[] = $incentiveRate;  
	    $params[] = $target_sales; 
	    $params[] = $target_sales;
	    $params[] = $remainingDays; 
	    $params[] = $target_sales;  
	    $params[] = $remainingDays;
	    $params[] = $startDate;
	    $params[] = $startDate;
	    $params[] = $endDate; 
	    $params[] = $areaid;
	    $params[] = $areaid;
	    $params[] = $storeid;
	    $params[] = $storeid;
	    $params[] = $ascid;
	    $params[] = $ascid;
	    $params[] = $baid;
	    $params[] = $baid;

		if (!is_null($baTypeId) && intval($baTypeId) !== 3) {
		    $params[] = $baTypeId;
		}

		if (!empty($brandIds)) {
		    $params = array_merge($params, $brandIds);
		}

		$params[] = (int) $limit;
		$params[] = (int) $offset;

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();
	    $totalRecords = $data ? $data[0]->total_records : 0;

		//$finalQuery = $this->interpolateQuery($sql, $params);
		//echo $finalQuery; // Review it in your logs or browser
	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

	public function salesPerformancePerArea(
	    $limit, $offset, $orderByColumn, $orderDirection, $target_sales, $incentiveRate, 
	    $monthFrom = null, $monthTo = null, $lyYear = null, $tyYear = null, $yearId = null, 
	    $storeid = null, $areaid = null, $ascid = null, $baid = null, $baTypeId = null, 
	    $remainingDays = null, $brand_category = null, $brandIds = null
	) {
	    $startDate = $tyYear . '-' . $monthFrom . '-01';
	    $endDate = $tyYear . '-' . $monthTo . '-31';
	    $brandIds = is_array($brandIds) ? $brandIds : [];

	    $additionalWhere = [];
	    $brandTypeCondition = '';
	    if (!empty($brand_category)) {
	        $escapedCats = array_map('intval', $brand_category);
	        $brandTypeCondition .= ' AND brand_type_id IN (' . implode(',', $escapedCats) . ')';
	    }

	    $allowedOrderColumns = ['rank', 'store_id', 'store_code', 'actual_sales', 'target_sales', 'percent_ach', 'balance_to_target', 'possible_incentives', 'target_per_remaining_days', 'ly_scanned_data', 'growth'];
	    $allowedOrderDirections = ['ASC', 'DESC'];

	    if (!in_array($orderByColumn, $allowedOrderColumns)) {
	        $orderByColumn = 'rank';
	    }
	    if (!in_array(strtoupper($orderDirection), $allowedOrderDirections)) {
	        $orderDirection = 'ASC';
	    }

	    $baTypeCondition = '';
	    $baTypeConditionASR = '';
		if (!is_null($baTypeId) && intval($baTypeId) !== 3) {
			$baTypeCondition = 'AND t.ba_types = ?';
		    $baTypeConditionASR = 'AND ba_type = ?';
		    $brandTypeCondition .= " AND CAST(brand_term_id AS UNSIGNED) = ? ";
	        $brandTypeCondition .= " AND CAST(ba_types AS UNSIGNED) = ? ";
		}

	    $monthColumns = [
	        1 => 'january', 2 => 'february', 3 => 'march', 4 => 'april',
	        5 => 'may', 6 => 'june', 7 => 'july', 8 => 'august',
	        9 => 'september', 10 => 'october', 11 => 'november', 12 => 'december'
	    ];

	    $targetSalesSum = [];
	    for ($m = $monthFrom; $m <= $monthTo; $m++) {
	        if (isset($monthColumns[$m])) {
	            $targetSalesSum[] = "COALESCE(t." . $monthColumns[$m] . ", 0)";
	        }
	    }
	    $targetSalesSQL = implode(' + ', $targetSalesSum);

	    $sql = "
	    WITH ly_scanned AS (
	        SELECT
	            area_id,
	            store_code,
	            company,
	            brand_type_id,
	            SUM(COALESCE(gross_sales, 0)) AS ly_scanned_data
	        FROM tbl_sell_out_pre_aggregated_data
	        WHERE (? IS NULL OR year = ?) 
	          AND (? IS NULL OR month BETWEEN ? AND ?)
	          $brandTypeCondition
	          AND (" . (empty($brandIds) ? "1=1" : "brand_id IN (" . implode(',', array_fill(0, count($brandIds), '?')) . ")") . ")
	        GROUP BY area_id
	    ),
	    targets AS (
	        SELECT 
	            t.area_id,
	            t.ba_types,
	            t.ba_code,
	            (SELECT GROUP_CONCAT(DISTINCT ba2.type)
	             FROM tbl_brand_ambassador ba2 
	             WHERE FIND_IN_SET(ba2.code, t.ba_code)) AS target_ba_types,
	            SUM(
	                CASE 
	                    WHEN ? = 3 THEN
	                        CASE 
	                            WHEN t.ba_types = 0 AND (LENGTH(t.ba_code) - LENGTH(REPLACE(t.ba_code, ',', '')) + 1) >= 2 THEN ? * 2
	                            WHEN t.ba_types = 0 THEN ?
	                            WHEN t.ba_types = 1 AND (LENGTH(t.ba_code) - LENGTH(REPLACE(t.ba_code, ',', '')) + 1) >= 2 THEN $targetSalesSQL * 1.3
	                            WHEN t.ba_types = 1 THEN $targetSalesSQL
	                            WHEN t.ba_types = 3 THEN $targetSalesSQL
	                            ELSE 0
	                        END
	                    WHEN ? = 1 AND t.ba_types = 1 AND (LENGTH(t.ba_code) - LENGTH(REPLACE(t.ba_code, ',', '')) + 1) >= 2 THEN $targetSalesSQL * 1.3
	                    WHEN ? = 1 AND t.ba_types = 1 THEN $targetSalesSQL
	                    WHEN ? = 0 AND t.ba_types = 0 AND (LENGTH(t.ba_code) - LENGTH(REPLACE(t.ba_code, ',', '')) + 1) >= 2 THEN ? * 2
	                    WHEN ? = 0 AND t.ba_types = 0 THEN ?
	                    ELSE 0
	                END
	            ) AS target_sales
	        FROM tbl_target_sales_per_store t
	        WHERE (? IS NULL OR t.year = ?)
	          AND t.status = 1
	          $baTypeCondition
	        GROUP BY t.area_id, t.status
	    )
	    SELECT
	        ROW_NUMBER() OVER (ORDER BY percent_ach DESC) AS rank,
	        s.brand,
	        s.area_id,
	        s.asc_id,
	        d_asc.description AS asc_name,
	        a.description AS area_name,
	        s.ba_id,
	        t.ba_code,
	        t.target_ba_types,
	        (LENGTH(t.ba_code) - LENGTH(REPLACE(t.ba_code, ',', '')) + 1) AS ba_count,
	        ly.company,
	        ly.brand_type_id,
	        s.store_id,
	        GROUP_CONCAT(DISTINCT b.brand_description ORDER BY b.brand_description SEPARATOR ', ') AS brand_name,
	        st.code AS store_code,
	        CONCAT(MAX(st.code), ' - ', st.description) AS store_name,
	        a.description AS area_name,
	        ba.name AS ba_name,
	        ba.deployment_date AS ba_deployment_date, 
	        sd.actual_sales,
	        FORMAT(t.target_sales, 2) AS target_sales, 
	        ROUND(COALESCE(SUM(sd.actual_sales), 0) * ?, 2) AS possible_incentives,
	        ROUND(COALESCE(t.target_sales, 0) - COALESCE(SUM(sd.actual_sales), 0), 2) AS balance_to_target,
	        ROUND(
	            COALESCE(SUM(sd.actual_sales), 0) / NULLIF(COALESCE(t.target_sales, 0), 0) * 100, 2
	        ) AS percent_ach,
	        FORMAT(COALESCE(ly.ly_scanned_data, 0),2) AS ly_scanned_data,
	        ROUND(
	            (COALESCE(SUM(sd.actual_sales), 0) / NULLIF(ly.ly_scanned_data, 0)) * 100,
	            2
	        ) AS growth,
	        CASE 
	          WHEN ? > 0 THEN CEIL((
				ROUND(COALESCE(t.target_sales, 0) - COALESCE(SUM(sd.actual_sales), 0), 2)
	          ) / ?)
	          ELSE NULL
	        END AS target_per_remaining_days,
	        COUNT(*) OVER() AS total_records
		FROM (
		    SELECT 
		        store_id,
		        ba_id,
		        area_id,
		        SUM(COALESCE(amount, 0)) AS actual_sales
		    FROM tbl_ba_sales_report
		    WHERE (? IS NULL OR date BETWEEN ? AND ?)
		      AND (? IS NULL OR area_id = ?)
		      AND (? IS NULL OR store_id = ?)
		      AND (? IS NULL OR asc_id = ?)
		      AND (? IS NULL OR ba_id = ?)
		      $baTypeConditionASR
		      AND (" . (empty($brandIds) ? "1=1" : "brand IN (" . implode(',', array_fill(0, count($brandIds), '?')) . ")") . ")
		    GROUP BY area_id
		) AS sd
		LEFT JOIN tbl_ba_sales_report s ON s.store_id = sd.store_id AND s.ba_id = sd.ba_id AND s.area_id = sd.area_id
	    LEFT JOIN tbl_store st ON st.id = s.store_id
	    LEFT JOIN tbl_area a ON a.id = s.area_id
	    LEFT JOIN tbl_brand_ambassador ba ON ba.id = s.ba_id
	    LEFT JOIN ly_scanned ly ON s.area_id = ly.area_id
	    LEFT JOIN targets t ON s.area_id = t.area_id
	    LEFT JOIN tbl_ba_brands bb ON ba.id = bb.ba_id
	    LEFT JOIN tbl_brand b ON b.id = bb.brand_id
	    LEFT JOIN tbl_area_sales_coordinator d_asc ON s.asc_id = d_asc.id
	    GROUP BY s.area_id
	    ORDER BY {$orderByColumn} {$orderDirection}
	    LIMIT ? OFFSET ?
	    ";

	    $params = [
	        $lyYear, $lyYear, 
	        $monthFrom, $monthFrom, $monthTo,
	    ];

	    if (!is_null($baTypeId) && intval($baTypeId) !== 3) {
	        $params[] = $baTypeId;
	        $params[] = $baTypeId;
	    }

	    if (!empty($brandIds)) {
	        foreach ($brandIds as $bid) {
	            $params[] = $bid;
	        }
	    }

	    $params[] = $baTypeId;
	    $params[] = $target_sales;
	    $params[] = $target_sales;
	    $params[] = $baTypeId;
	    $params[] = $baTypeId;
	    $params[] = $baTypeId;
	    $params[] = $target_sales;
	    $params[] = $baTypeId;
	    $params[] = $target_sales;
	    $params[] = $yearId;
	    $params[] = $yearId;

	    if (!is_null($baTypeId) && intval($baTypeId) !== 3) {
	        $params[] = $baTypeId;
	    }

	    $params[] = $incentiveRate;
	    $params[] = $remainingDays;
	    $params[] = $remainingDays;
	    $params[] = $startDate;
	    $params[] = $startDate;
	    $params[] = $endDate;
	    $params[] = $areaid;
	    $params[] = $areaid;
	    $params[] = $storeid;
	    $params[] = $storeid;
	    $params[] = $ascid;
	    $params[] = $ascid;
	    $params[] = $baid;
	    $params[] = $baid;

	    if (!is_null($baTypeId) && intval($baTypeId) !== 3) {
	        $params[] = $baTypeId;
	    }

	    if (!empty($brandIds)) {
	        foreach ($brandIds as $bid) {
	            $params[] = $bid;
	        }
	    }

	    $params[] = $limit;
	    $params[] = $offset;

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();
	    $totalRecords = $data ? $data[0]->total_records : 0;
		// $finalQuery = $this->interpolateQuery($sql, $params);
		// echo $finalQuery; // Review it in your logs or browser

	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

	function interpolateQuery($query, $params) {
	    $escaped = array_map(function ($param) {
	        return is_numeric($param) ? $param : "'" . addslashes($param) . "'";
	    }, $params);
	    
	    foreach ($escaped as $param) {
	        $query = preg_replace('/\?/', $param, $query, 1);
	    }
	    return $query;
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

	public function getStorePerformance(
	    $month_start, $month_end, $orderByColumn, $orderDirection, $year, $limit, $offset,
	    $area_id = null, $asc_id = null, $store_code = null,
	    $ba_id = null, $ba_type = null,
	    $brand_category = null, $brands = null
	) {
	    $last_year = $year - 1;
	    $allowedOrderColumns = ['rank', 'store_code', 'ty_scanned_data', 'ly_scanned_data', 'growth', 'sob'];
	    $allowedOrderDirections = ['ASC', 'DESC'];

	    if (!in_array($orderByColumn, $allowedOrderColumns)) {
	        $orderByColumn = 'rank';
	    }

	    if (!in_array(strtoupper($orderDirection), $allowedOrderDirections)) {
	        $orderDirection = 'ASC';
	    }

	    $additionalWhere = [];
	    $brandTypeCondition = '';
		if ($ba_id !== null) {
		    $baIds = array_map('intval', preg_split('/\s*or\s*/i', $ba_id));

		    $baConditions = array_map(fn($id) => "FIND_IN_SET($id, so.ba_ids)", $baIds);

		    $additionalWhere[] = '(' . implode(' OR ', $baConditions) . ')';
		}

		if ($ba_type !== null && $ba_type != 3) {
		    $additionalWhere[] = 'so.ba_types IN (' . intval($ba_type) . ')';
		}

		if (!empty($brand_category)) {
		    $escapedCats = array_map('intval', $brand_category);
		    $brandTypeCondition = ' AND brand_type_id IN (' . implode(',', $escapedCats) . ')';
		}

		if (!empty($brands)) {
		    $brandConditions = array_map(fn($id) => "FIND_IN_SET($id, so.brand_ids)", $brands);
		    $additionalWhere[] = '(' . implode(' OR ', $brandConditions) . ')';
		}

	    $additionalWhereSQL = !empty($additionalWhere) ? ' AND ' . implode(' AND ', $additionalWhere) : '';

	    $sql = "
	        WITH ly_scanned AS (
	            SELECT store_code, SUM(COALESCE(gross_sales, 0)) AS ly_scanned_data
	            FROM tbl_sell_out_pre_aggregated_data
	            WHERE (? IS NULL OR year = ?)
	              AND (? IS NULL OR month BETWEEN ? AND ?)
	              $brandTypeCondition
	            GROUP BY store_code
	        ),
	        ty_scanned AS (
	            SELECT store_code, SUM(COALESCE(gross_sales, 0)) AS ty_scanned_data
	            FROM tbl_sell_out_pre_aggregated_data
	            WHERE (? IS NULL OR year = ?)
	              AND (? IS NULL OR month BETWEEN ? AND ?)
	              $brandTypeCondition
	            GROUP BY store_code
	        ),
	        total_ty AS (
	            SELECT SUM(COALESCE(ty_scanned_data, 0)) AS total_ty_sales FROM ty_scanned
	        ),
	        distinct_store_count AS (
	            SELECT COUNT(DISTINCT store_code) AS total_unique_store_codes
	            FROM tbl_sell_out_pre_aggregated_data
	        )
	        SELECT 
	            ROW_NUMBER() OVER (ORDER BY (COALESCE(ty.ty_scanned_data, 0) / NULLIF(tt.total_ty_sales, 0)) DESC) AS rank,
	            so.id,
	            so.year,
	            so.month,
	            so.store_code,
	            so.ba_ids,
	            so.ba_types,
	            so.brand_ids,
	            so.area_id,
	            so.asc_id,
	            so.company,
	            so.brand_type_id,
	            CONCAT(MAX(so.store_code), ' - ', s.description) AS store_name,
	            FORMAT(COALESCE(ty.ty_scanned_data, 0), 2) AS ty_scanned_data,
	            FORMAT(COALESCE(ly.ly_scanned_data, 0), 2) AS ly_scanned_data,
	            CASE 
	                WHEN ly.ly_scanned_data IS NULL OR ty.ty_scanned_data IS NULL THEN ''
	                WHEN COALESCE(ly.ly_scanned_data, 0) = 0 THEN ''
	                ELSE ROUND((ty.ty_scanned_data - ly.ly_scanned_data) / NULLIF(ly.ly_scanned_data, 0) * 100, 2)
	            END AS growth,
	            ROUND(COALESCE(ty.ty_scanned_data, 0) / NULLIF(tt.total_ty_sales, 0) * 100, 2) AS sob,
	            COUNT(*) OVER() AS total_records
	        FROM tbl_sell_out_pre_aggregated_data so
	        LEFT JOIN ly_scanned ly ON so.store_code = ly.store_code
	        LEFT JOIN ty_scanned ty ON so.store_code = ty.store_code
	        LEFT JOIN tbl_store s ON so.store_code = s.code
	        CROSS JOIN total_ty tt
	        CROSS JOIN distinct_store_count dsc
	        WHERE (? IS NULL OR so.year = ?)
	          AND (? IS NULL OR so.month BETWEEN ? AND ?)
	          AND (? IS NULL OR so.area_id = ?)
	          AND (? IS NULL OR so.asc_id = ?)
	          AND (? IS NULL OR so.store_code = ?)
	          $additionalWhereSQL
	        GROUP BY so.store_code, ly.ly_scanned_data, ty.ty_scanned_data, tt.total_ty_sales, dsc.total_unique_store_codes
	        ORDER BY {$orderByColumn} {$orderDirection}
	        LIMIT ? OFFSET ?;
	    ";

	    $params = array_merge(
	        [$last_year, $last_year, $month_start, $month_start, $month_end],

	        [$year, $year, $month_start, $month_start, $month_end],

	        [
	            $year, $year,
	            $month_start, $month_start, $month_end,
	            $area_id, $area_id,
	            $asc_id, $asc_id,
	            $store_code, $store_code
	        ],

	        [$limit, $offset]
	    );

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();
	    $totalRecords = $data ? $data[0]->total_records : 0;

	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
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
