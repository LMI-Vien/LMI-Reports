<?php

namespace App\Models;

use CodeIgniter\Model;
use DateTime;

class Dashboard_model extends Model
{

	public function dataPerStore(
	    $pageLimit, $pageOffset, $orderByColumn, $orderDirection, $minWeeks, $maxWeeks, $week, $year, $brands = null, $baId = null, $baType = null, $areaId = null, $ascId = null, $storeId = null, $companyId = 3, $ItemClasses = null, $itemCat = null, $searchValue = null) {
	    $params = [];
	    $where = "WHERE vmi.week = ? AND vmi.year = ?";
	    $params[] = $week;
	    $params[] = $year;

	    if ($ascId !== null) {
	        $where .= " AND vmi.asc_id = ?";
	        $params[] = $ascId;
	    }

	    if ($areaId !== null) {
	        $where .= " AND vmi.area_id = ?";
	        $params[] = $areaId;
	    }

	    if ($itemCat !== null) {
	        $where .= " AND vmi.itmclacde = ?";
	        $params[] = $itemCat;
	    }

	    if ($storeId !== null) {
	        $where .= " AND vmi.store_id = ?";
	        $params[] = $storeId;
	    }

	    if ($baType !== null && $baType != 3) {
	        $where .= " AND vmi.ba_types = ?";
	        $params[] = $baType;
	    }

		if (!empty($baId)) {
		    $baIds = array_map('intval', preg_split('/\s*or\s*/i', $baId));
		    $baConds = array_map(fn($id) => "FIND_IN_SET($id, vmi.ba_ids)", $baIds);
		    $where .= ' AND (' . implode(' OR ', $baConds) . ')';
		}

	    if ($companyId !== null && $companyId != 3) {
	        $where .= " AND vmi.company = ?";
	        $params[] = $companyId;
	    }

	    if (!empty($brands)) {
	        $brands = array_map('trim', $brands);
	        $brandConditions = [];
	        foreach ($brands as $brand) {
	            $brandConditions[] = "FIND_IN_SET(" . db_connect()->escape($brand) . ", vmi.brncde)";
	        }
	        $where .= " AND (" . implode(' OR ', $brandConditions) . ")";
	    }

	    if (!empty($ItemClasses)) {
	        $ItemClasses = array_map('trim', $ItemClasses);
	        $classConditions = [];
	        foreach ($ItemClasses as $class) {
	            $classConditions[] = "FIND_IN_SET(" . db_connect()->escape($class) . ", vmi.item_class_id)";
	        }
	        $where .= " AND (" . implode(' OR ', $classConditions) . ")";
	    }

	    $sql = "
	        SELECT 
	            vmi.item,
	            COALESCE(vmi.itmdsc, vmi.item_name) AS item_name,
	            vmi.area_id,
	            vmi.itmcde,
	            vmi.item_class,
	            ic.item_class_description AS item_class_name,
	            vmi.brand_type_id,
	            GROUP_CONCAT(DISTINCT vmi.company) AS company,
	            COALESCE(NULLIF(vmi.itmcde, ''), 'N / A') AS itmcde,
	            SUM(vmi.total_qty) AS total_qty,
	            SUM(vmi.average_sales_unit) AS avg_sales,
	            GROUP_CONCAT(DISTINCT vmi.ba_ids) AS ba_ids,
	            GROUP_CONCAT(DISTINCT vmi.ba_types) AS ba_types,
	            GROUP_CONCAT(DISTINCT vmi.brand_ids) AS brand_ids,
	            GROUP_CONCAT(DISTINCT vmi.asc_id) AS asc_ids,
	            GROUP_CONCAT(DISTINCT vmi.store_id) AS store_ids
	        FROM tbl_vmi_pre_aggregated_data vmi
	        LEFT JOIN tbl_item_class ic ON vmi.item_class_id = ic.id
	        $where
	        GROUP BY vmi.item
	    ";

	    $rawData = $this->db->query($sql, $params)->getResult();

	    $pivoted = [];
	    foreach ($rawData as $row) {
	        $swc = ($row->avg_sales > 0) ? round($row->total_qty / $row->avg_sales, 2) : 0;
	        if ($swc > $minWeeks && ($maxWeeks === null || $swc <= $maxWeeks)) {
	            $pivoted[] = [
	                'item'            => $row->item,
	                'item_name'       => $row->item_name,
	                'itmcde'          => $row->itmcde,
	                'item_class'      => $row->item_class,
	                'item_class_name'      => $row->item_class_name,
	                'sum_total_qty'       => (float)$row->total_qty,
	                'sum_ave_sales'       => (float)$row->avg_sales,
	                'swc'             => $swc,
	                'ba_ids'          => $row->ba_ids,
	                'ba_types'        => $row->ba_types,
	                'brand_ids'       => $row->brand_ids,
	                'asc_ids'         => $row->asc_ids,
	                'store_ids'       => $row->store_ids
	            ];
	        }
	    }

	    if (!empty($searchValue)) {
	        $searchValue = strtolower($searchValue);
	        $pivoted = array_filter($pivoted, function ($item) use ($searchValue) {
	            return strpos(strtolower($item['item']), $searchValue) !== false
	                || strpos(strtolower($item['item_name']), $searchValue) !== false
	                || strpos(strtolower($item['itmcde']), $searchValue) !== false;
	        });
	    }

	    $allowedOrderColumns = ['sum_total_qty', 'item', 'item_name', 'itmcde', 'sum_ave_sales', 'swc'];
	    if (!in_array($orderByColumn, $allowedOrderColumns)) {
	        $orderByColumn = 'sum_total_qty';
	    }
	    $orderDirection = strtoupper($orderDirection);
	    if (!in_array($orderDirection, ['ASC', 'DESC'])) {
	        $orderDirection = 'DESC';
	    }

	    usort($pivoted, function ($a, $b) use ($orderByColumn, $orderDirection) {
	        if ($a[$orderByColumn] == $b[$orderByColumn]) return 0;
	        return ($orderDirection === 'ASC')
	            ? ($a[$orderByColumn] < $b[$orderByColumn] ? -1 : 1)
	            : ($a[$orderByColumn] > $b[$orderByColumn] ? -1 : 1);
	    });

	    $totalRecords = count($pivoted);
	    $pagedData = array_slice(array_values($pivoted), (int)$pageOffset, (int)$pageLimit);

	    return [
	        'total_records' => $totalRecords,
	        'data'          => $pagedData
	    ];
	}

	public function getItemClassNPDHEROData(
	    $pageLimit, $pageOffset, $orderByColumn, $orderDirection, $week, $year, $brands = null, $baId = null, $baType = null, $areaId = null, $ascId = null, $storeId = null, $ItemClassIdsFilter = null, $companyId = 3, $ItemClasses = null, $itemCat = null, $searchValue = null) {
	    $params = [];
	    $where = "WHERE vmi.week = ? AND vmi.year = ?";
	    $params[] = $week;
	    $params[] = $year;

	    if ($ascId !== null) {
	        $where .= " AND vmi.asc_id = ?";
	        $params[] = $ascId;
	    }
	    if ($areaId !== null) {
	        $where .= " AND vmi.area_id = ?";
	        $params[] = $areaId;
	    }
	    if ($itemCat !== null) {
	        $where .= " AND vmi.itmclacde = ?";
	        $params[] = $itemCat;
	    }
	    if ($storeId !== null) {
	        $where .= " AND vmi.store_id = ?";
	        $params[] = $storeId;
	    }
	    if ($baType !== null && $baType != 3) {
	        $where .= " AND vmi.ba_types = ?";
	        $params[] = $baType;
	    }

		if (!empty($baId)) {
		    $baIds = array_map('intval', preg_split('/\s*or\s*/i', $baId));
		    $baConds = array_map(fn($id) => "FIND_IN_SET($id, vmi.ba_ids)", $baIds);
		    $where .= ' AND (' . implode(' OR ', $baConds) . ')';
		}

	    if ($companyId !== null && $companyId != 3) {
	        $where .= " AND vmi.company = ?";
	        $params[] = $companyId;
	    }
	    
	    if (!empty($brands)) {
	        $brands = array_map('trim', $brands);
	        $brandConditions = [];
	        foreach ($brands as $brand) {
	            $brandConditions[] = "FIND_IN_SET(" . db_connect()->escape($brand) . ", vmi.brncde)";
	        }
	        $where .= " AND (" . implode(' OR ', $brandConditions) . ")";
	    }
	    if (!empty($ItemClasses)) {
	        $ItemClasses = array_map('trim', $ItemClasses);
	        $classConditions = [];
	        foreach ($ItemClasses as $class) {
	            $classConditions[] = "FIND_IN_SET(" . db_connect()->escape($class) . ", vmi.item_class_id)";
	        }
	        $where .= " AND (" . implode(' OR ', $classConditions) . ")";
	    }
	    if (!empty($ItemClassIdsFilter)) {
	        $placeholders = implode(',', array_fill(0, count($ItemClassIdsFilter), '?'));
	        $where .= " AND vmi.item_class_id IN ($placeholders)";
	        $params = array_merge($params, $ItemClassIdsFilter);
	    }

	    $sql = "
	        SELECT 
	            vmi.item,
	            COALESCE(vmi.itmdsc, vmi.item_name) AS item_name,
	            vmi.area_id,
	            vmi.itmcde,
	            vmi.item_class,
	            ic.item_class_description AS item_class_name,
	            vmi.brand_type_id, 
	            GROUP_CONCAT(DISTINCT vmi.company) AS company,
	            COALESCE(NULLIF(vmi.itmcde, ''), 'N / A') AS itmcde,
	            SUM(vmi.total_qty) AS total_qty,
	            SUM(vmi.average_sales_unit) AS avg_sales,
	            GROUP_CONCAT(DISTINCT vmi.ba_ids) AS ba_ids,
	            GROUP_CONCAT(DISTINCT vmi.ba_types) AS ba_types,
	            GROUP_CONCAT(DISTINCT vmi.brand_ids) AS brand_ids,
	            GROUP_CONCAT(DISTINCT vmi.asc_id) AS asc_ids,
	            GROUP_CONCAT(DISTINCT vmi.store_id) AS store_ids
	        FROM tbl_vmi_pre_aggregated_data vmi
	        LEFT JOIN tbl_item_class ic ON vmi.item_class_id = ic.id
	        $where
	        GROUP BY vmi.item
	    ";

	    $rawData = $this->db->query($sql, $params)->getResult();
	    $pivoted = [];
	    foreach ($rawData as $row) {
	        $swc = ($row->avg_sales > 0) ? round($row->total_qty / $row->avg_sales, 2) : 0;
	        $pivoted[] = [
	            'item'            => $row->item,
	            'item_name'       => $row->item_name,
	            'itmcde'          => $row->itmcde,
                'item_class'      => $row->item_class,
                'item_class_name'      => $row->item_class_name,
                'sum_total_qty'       => (float)$row->total_qty,
                'sum_ave_sales'       => (float)$row->avg_sales,
                'swc'             => $swc,
	            'ba_ids'          => $row->ba_ids,
	            'ba_types'        => $row->ba_types,
	            'brand_ids'       => $row->brand_ids,
	            'asc_ids'         => $row->asc_ids,
	            'store_ids'       => $row->store_ids
	        ];
	    }

	    if (!empty($searchValue)) {
	        $searchValue = strtolower($searchValue);
	        $pivoted = array_filter($pivoted, function ($item) use ($searchValue) {
	            return strpos(strtolower($item['item']), $searchValue) !== false
	                || strpos(strtolower($item['item_name']), $searchValue) !== false
	                || strpos(strtolower($item['itmcde']), $searchValue) !== false;
	        });
	    }

	    $allowedOrderColumns = ['sum_total_qty', 'item', 'item_name', 'itmcde', 'sum_ave_sales', 'swc'];
	    if (!in_array($orderByColumn, $allowedOrderColumns)) {
	        $orderByColumn = 'sum_total_qty';
	    }
	    $orderDirection = strtoupper($orderDirection);
	    if (!in_array($orderDirection, ['ASC', 'DESC'])) {
	        $orderDirection = 'DESC';
	    }

	    usort($pivoted, function ($a, $b) use ($orderByColumn, $orderDirection) {
	        if ($a[$orderByColumn] == $b[$orderByColumn]) return 0;
	        return ($orderDirection === 'ASC')
	            ? ($a[$orderByColumn] < $b[$orderByColumn] ? -1 : 1)
	            : ($a[$orderByColumn] > $b[$orderByColumn] ? -1 : 1);
	    });

	    $totalRecords = count($pivoted);
	    $pagedData = array_slice(array_values($pivoted), (int)$pageOffset, (int)$pageLimit);

	    return [
	        'total_records' => $totalRecords,
	        'data'          => $pagedData
	    ];
	}

	public function getLatestVmi($year = null) {
	    $builder = $this->db->table('tbl_vmi_header vh')
	        ->select('y.id as year_id, y.year, c.id as company_id, c.name as company_name, vh.week AS week_id')
	        ->join('tbl_company c', 'vh.company = c.id')
	        ->join('tbl_year y', 'vh.year = y.id');

	    $builder->where('vh.status', 1);
	    if (!empty($year)) {
	        $builder->where('vh.year', $year);
	    }

	    $builder->orderBy('y.year', 'DESC');
	    $builder->orderBy('vh.week', 'DESC');
	    $builder->limit(1);

	    return $builder->get()->getRowArray();
	}

	public function getLatestWeekOnWeek($year = null) {
		$builder = $this->db->table('tbl_week_on_week_header wh')
			->select('wh.id, wh.year, wh.week, y.year as year')
			->join('tbl_year y', 'wh.year = y.id');

		if ($year !== null) {
			$builder->where('wh.year', $year)
					->orderBy('wh.week', 'DESC');
		} else {
			$builder->orderBy('wh.year', 'DESC')
					->orderBy('wh.week', 'DESC');
		}
		$builder->limit(1);

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

	public function salesPerformancePerBa($limit, $offset, $orderByColumn, $orderDirection, $target_sales, $incentiveRate, $monthFrom = null, $monthTo = null, $lyYear = null, $tyYear = null, $yearId = null, $storeid = null, $areaid = null, $ascid = null, $baid = null, $baTypeId = null, $remainingDays = null, $brand_category = null, $brandIds = null, $searchValue = null)
	{
		$range = ($monthTo - $monthFrom) + 1;
		$startDate = $tyYear .'-'. $monthFrom . '-01';
		$endDate = $tyYear .'-'. $monthTo . '-31';
		$brandIds = is_array($brandIds) ? $brandIds : [];

		$searchColumns = [
		    'a.description',        // area
		    'st.description',       // store
		    'ba.name',              // ba
		    'b.brand_description'   // brand
		];

		$searchHavingClause = '';
		$searchParams = [];

	    if (!empty($searchValue)) {
	        $likeConditions = array_map(fn($col) => "$col LIKE ?", $searchColumns);
	        $searchHavingClause = ' AND (' . implode(' OR ', $likeConditions) . ')';
	        foreach ($searchColumns as $_) {
	            $searchParams[] = '%' . $searchValue . '%';
	        }
	    }

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

			CASE
			    WHEN ROUND((
			        CASE 
			            WHEN ba.type = 0 THEN (? * ?)
			            WHEN t.target_ba_types = 1 AND 
			                 (LENGTH(t.ba_code) - LENGTH(REPLACE(t.ba_code, ',', '')) + 1) >= 2 THEN 
			                (COALESCE(t.target_sales, 0) * 1.3) / 
			                NULLIF((LENGTH(t.ba_code) - LENGTH(REPLACE(t.ba_code, ',', '')) + 1), 0)
			            WHEN t.target_ba_types = 1 THEN COALESCE(t.target_sales, 0)
			            WHEN t.target_ba_types = 0 THEN ?
			            ELSE COALESCE(t.target_sales, 0)
			        END - sd.actual_sales), 2
			    ) < 0 THEN 0
			    ELSE ROUND((
			        CASE 
			            WHEN ba.type = 0 THEN (? * ?)
			            WHEN t.target_ba_types = 1 AND 
			                 (LENGTH(t.ba_code) - LENGTH(REPLACE(t.ba_code, ',', '')) + 1) >= 2 THEN 
			                (COALESCE(t.target_sales, 0) * 1.3) / 
			                NULLIF((LENGTH(t.ba_code) - LENGTH(REPLACE(t.ba_code, ',', '')) + 1), 0)
			            WHEN t.target_ba_types = 1 THEN COALESCE(t.target_sales, 0)
			            WHEN t.target_ba_types = 0 THEN ?
			            ELSE COALESCE(t.target_sales, 0)
			        END - sd.actual_sales), 2
			    )
			END AS balance_to_target,


			ROUND(
			    sd.actual_sales / 
			    NULLIF((
			        CASE 
			            WHEN ba.type = 0 THEN (? * ?)
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
			            WHEN ba.type = 0 THEN (? * ?)
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
		$searchHavingClause
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
		$params[] = $range;
		$params[] = $target_sales; 
	    $params[] = $target_sales; 
		$params[] = $range;
		$params[] = $target_sales; 
	    $params[] = $target_sales; 
		$params[] = $range;
		$params[] = $target_sales; 
	    $params[] = $target_sales;
	    $params[] = $remainingDays; 
	    $params[] = $target_sales;  
	    $params[] = $remainingDays;
		$params[] = $range;
		$params[] = $target_sales; 
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

		if (!empty($searchParams)) {
		    $params = array_merge($params, $searchParams);
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
	    $remainingDays = null, $brand_category = null, $brandIds = null, $searchValue = null) {
	    $startDate = $tyYear . '-' . $monthFrom . '-01';
	    $endDate = $tyYear . '-' . $monthTo . '-31';
	    $brandIds = is_array($brandIds) ? $brandIds : [];

		// $roleId = session()->sess_site_role ?? null;
		// $maskedLyScannedField = ($roleId == 7 || $roleId == 8)
		//     ? "'-' AS ly_scanned_data"
		//     : "FORMAT(COALESCE(ly.ly_scanned_data, 0), 2) AS ly_scanned_data";

	    $searchColumns = [
	        'a.description',        //area
	        'd_asc.description'      //asc
	    ];

	    $searchHavingClause = '';
	    $searchParams = [];

		if (!empty($searchValue)) {
		    $likeConditions = array_map(fn($col) => "$col LIKE ?", $searchColumns);
		    $searchHavingClause = ' HAVING ' . implode(' OR ', $likeConditions);
		    foreach ($searchColumns as $_) {
		        $searchParams[] = '%' . $searchValue . '%';
		    }
		}

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
	        ROUND(COALESCE(sd.actual_sales, 0) * ?, 2) AS possible_incentives,
	        CASE 
			    WHEN COALESCE(t.target_sales, 0) - COALESCE(sd.actual_sales, 0) < 0 THEN 0
			    ELSE ROUND(COALESCE(t.target_sales, 0) - COALESCE(sd.actual_sales, 0), 2)
			END AS balance_to_target,
	        ROUND(
	            COALESCE(sd.actual_sales, 0) / NULLIF(COALESCE(t.target_sales, 0), 0) * 100, 2
	        ) AS percent_ach,
	        FORMAT(COALESCE(ly.ly_scanned_data, 0), 2) AS ly_scanned_data,
	        ROUND(
	            (COALESCE(sd.actual_sales, 0) / NULLIF(ly.ly_scanned_data, 0)) * 100,
	            2
	        ) AS growth,
	        CASE 
	          WHEN ? > 0 THEN CEIL((
				ROUND(COALESCE(t.target_sales, 0) - COALESCE(sd.actual_sales, 0), 2)
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
	    $searchHavingClause
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

		if (!empty($searchParams)) {
		    $params = array_merge($params, $searchParams);
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

	public function storeSalesPerfPerMonth(array $filters = [])
	{
	    $params = [];
	    $whereClausesASR = [];
	    $whereClausesLYSO = [];
	    $whereClausesTYSO = [];
	    $whereClausesTS = [];

	    if (!empty($filters['asc_id'])) {
	        $whereClausesASR[] = "(s.asc_id = :asc_id:)";
	        $whereClausesLYSO[] = "(asc_id = :asc_id:)";
	        $whereClausesTYSO[] = "(asc_id = :asc_id:)";
	        $whereClausesTS[] = "(asc_id = :asc_id:)";
	        $params['asc_id'] = $filters['asc_id'];
	    }
	    if (!empty($filters['area_id'])) {
	        $whereClausesASR[] = "(s.area_id = :area_id:)";
	        $whereClausesLYSO[] = "(area_id = :area_id:)";
	        $whereClausesTYSO[] = "(area_id = :area_id:)";
	        $whereClausesTS[] = "(area_id = :area_id:)";
	        $params['area_id'] = $filters['area_id'];
	    }

	    $brandFindSetConditions = [];
	    if (!empty($filters['brand_ids']) && is_array($filters['brand_ids'])) {
	        $brandPlaceholders = [];
	        foreach ($filters['brand_ids'] as $i => $id) {
	            $key = "brand_id_$i";
	            $brandPlaceholders[] = ":$key:";
	            $brandFindSetConditions[] = "FIND_IN_SET(:$key:, brand_ids)";
	            $params[$key] = $id;
	        }
	        $whereClausesASR[] = "s.brand IN (" . implode(',', $brandPlaceholders) . ")"; //single brand 
	        $whereClausesLYSO[] = "brand_id IN (" . implode(',', $brandPlaceholders) . ")"; //single brand 
	        $whereClausesTYSO[] = "brand_id IN (" . implode(',', $brandPlaceholders) . ")";//single brand 
	        //$whereClausesTS[] = '(' . implode(' OR ', $brandFindSetConditions) . ')';//multiple brand comma separated brand 
	     //   $whereClausesTS[] = "FIND_IN_SET(:brand_ids:, brand_ids)";
	    }

	    if (!empty($filters['brand_type_ids']) && is_array($filters['brand_type_ids'])) {
	        $brandTypePlaceholders = [];
	        foreach ($filters['brand_type_ids'] as $i => $id) {
	            $key = "brand_type_ids_$i";
	            $brandTypePlaceholders[] = ":$key:";
	            $params[$key] = $id;
	        }
	        $whereClausesLYSO[] = "brand_type_id IN (" . implode(',', $brandTypePlaceholders) . ")";
	        $whereClausesTYSO[] = "brand_type_id IN (" . implode(',', $brandTypePlaceholders) . ")";
	        $whereClausesASR[] = "blt.category_id IN (" . implode(',', $brandTypePlaceholders) . ")";
	    }

	    if (!empty($filters['store_id'])) {
	        $whereClausesASR[] = "(s.store_id = :store_id:)";
	        $params['store_id'] = $filters['store_id'];
	    }

	    if (!empty($filters['store_code'])) {
	        $whereClausesLYSO[] = "(store_code = :store_code:)";
	        $whereClausesTYSO[] = "(store_code = :store_code:)";
	        $whereClausesTS[] = "(location = :store_code:)";
	        $params['store_code'] = $filters['store_code'];
	    }

	    if (!empty($filters['ba_id'])) {
	        $whereClausesASR[] = "(s.ba_id = :ba_id:)";
	        $whereClausesLYSO[] = "FIND_IN_SET(:ba_id:, ba_ids)";
	        $whereClausesTYSO[] = "FIND_IN_SET(:ba_id:, ba_ids)";
	        $params['ba_id'] = $filters['ba_id'];
	    }

	    if (!empty($filters['ba_code'])) {
	        $whereClausesTS[] = "FIND_IN_SET(:ba_code:, ba_code)";
	        $params['ba_code'] = $filters['ba_code'];
	    }

	    $baType = $filters['ba_type'] ?? null;
	    if (isset($baType) && $baType !== '3') {
	        $whereClausesASR[] = "(s.ba_type = :ba_type:)";
	        $whereClausesLYSO[] = "(ba_types = :ba_type:)";
	        $whereClausesTYSO[] = "(ba_types = :ba_type:)";
	        $whereClausesTS[] = "(ba_types = :ba_type:)";
	        $params['ba_type'] = $baType;
	    }

	    if (!empty($filters['year'])) {
	        $year = $filters['year'];
	        $year_id = $filters['year_val'];
	        $nextYear = $year + 1;
	        $LastYear = $year - 1;
	        $whereClausesASR[] = "(s.date >= '$year-01-01' AND s.date < '$nextYear-01-01')";
	        $whereClausesLYSO[] = "(year = '$LastYear')";
	        $whereClausesTYSO[] = "(year = '$year')";
	        $whereClausesTS[] = "(year = $year_id) AND status = 1";
	    }
	    $whereSQLASR = !empty($whereClausesASR) ? "WHERE " . implode(" AND ", $whereClausesASR) : "";
	    $whereSQLLYSO = !empty($whereClausesLYSO) ? "WHERE " . implode(" AND ", $whereClausesLYSO) : "";
	    $whereSQLTYSO = !empty($whereClausesTYSO) ? "WHERE " . implode(" AND ", $whereClausesTYSO) : "";
	    $whereSQLTS = !empty($whereClausesTS) ? "WHERE " . implode(" AND ", $whereClausesTS) : "";

	    $defaultTarget = (int)($filters['default_target'] ?? 8000);
	    $params['default_target'] = $defaultTarget;
	    $params['ba_code_list'] = $filters['ba_code'] ?? '';

		 $params['ba_id'] = isset($filters['ba_id']) 
	     ? (is_array($filters['ba_id']) ? implode(',', $filters['ba_id']) : (string)$filters['ba_id']) 
		     : '';
		// // Ensure ba_type is set, even if it’s null
		 $params['ba_type'] = $baType ?? null;


		$targetSalesSelect = implode(", ", array_map(function ($m, $c) use ($baType) {
		    $alias = "target_sales_" . strtolower(substr($c, 0, 3));

		    if ((string)$baType === '3') {
		        return "
		        COALESCE(SUM(
		            CASE
		                WHEN ba_types = 0 THEN :default_target:
		                WHEN ba_types = 1 THEN 
		                    CASE
		                        WHEN (LENGTH(ba_code) - LENGTH(REPLACE(ba_code, ',', '')) + 1) >= 2 THEN {$c} * 1.3
		                        ELSE {$c}
		                    END
		                WHEN ba_types = 3 THEN {$c}
		                ELSE 0
		            END
		        ), 0) AS {$alias}";
		    } elseif ((string)$baType === '0') {
		        return "
		        COALESCE(SUM(
		            CASE
		                WHEN ba_types = 0 THEN :default_target:
		                ELSE 0
		            END
		        ), 0) AS {$alias}";
		    } elseif ((string)$baType === '1') {
		        return "
		        COALESCE(SUM(
		            CASE
		                WHEN ba_types = 1 THEN 
		                    CASE
		                        WHEN (LENGTH(ba_code) - LENGTH(REPLACE(ba_code, ',', '')) + 1) >= 2 THEN {$c} * 1.3
		                        ELSE {$c}
		                    END
		                ELSE 0
		            END
		        ), 0) AS {$alias}";
		    } else {
		        return "
		        COALESCE(SUM(
		            CASE
		                WHEN FIND_IN_SET(ba_code, :ba_code_list:) THEN {$c}
		                ELSE 0
		            END
		        ), 0) AS {$alias}";
		    }
		}, range(1, 12), [
		    'january','february','march','april','may','june',
		    'july','august','september','october','november','december'
		]));

	    $sql = "
	    WITH monthly_totals AS (
	      SELECT
	      	blt.category_id,
	        SUM(CASE WHEN MONTH(s.date) = 1 THEN amount ELSE 0 END) AS amount_january,
	        SUM(CASE WHEN MONTH(s.date) = 2 THEN amount ELSE 0 END) AS amount_february,
	        SUM(CASE WHEN MONTH(s.date) = 3 THEN amount ELSE 0 END) AS amount_march,
	        SUM(CASE WHEN MONTH(s.date) = 4 THEN amount ELSE 0 END) AS amount_april,
	        SUM(CASE WHEN MONTH(s.date) = 5 THEN amount ELSE 0 END) AS amount_may,
	        SUM(CASE WHEN MONTH(s.date) = 6 THEN amount ELSE 0 END) AS amount_june,
	        SUM(CASE WHEN MONTH(s.date) = 7 THEN amount ELSE 0 END) AS amount_july,
	        SUM(CASE WHEN MONTH(s.date) = 8 THEN amount ELSE 0 END) AS amount_august,
	        SUM(CASE WHEN MONTH(s.date) = 9 THEN amount ELSE 0 END) AS amount_september,
	        SUM(CASE WHEN MONTH(s.date) = 10 THEN amount ELSE 0 END) AS amount_october,
	        SUM(CASE WHEN MONTH(s.date) = 11 THEN amount ELSE 0 END) AS amount_november,
	        SUM(CASE WHEN MONTH(s.date) = 12 THEN amount ELSE 0 END) AS amount_december
	      FROM tbl_ba_sales_report s
	      LEFT JOIN tbl_brand blt ON s.brand = blt.id
	      $whereSQLASR
	    ),
	    ly_sell_out_totals AS (
	      SELECT " . implode(", ", array_map(fn($m) =>
	        "ROUND(SUM(CASE WHEN month={$m} THEN net_sales ELSE 0 END), 2) AS ly_sell_out_" . strtolower(date('F', mktime(0, 0, 0, $m, 1))),
	      range(1, 12))) . "
	      FROM tbl_sell_out_pre_aggregated_data
	      $whereSQLLYSO
	    ),
	    ty_sell_out_totals AS (
	      SELECT " . implode(", ", array_map(fn($m) =>
	        "ROUND(SUM(CASE WHEN month={$m} THEN net_sales ELSE 0 END), 2) AS ty_sell_out_" . strtolower(date('F', mktime(0, 0, 0, $m, 1))),
	      range(1, 12))) . "
	      FROM tbl_sell_out_pre_aggregated_data
	      $whereSQLTYSO
	    ),
	    target_sales_totals AS (
	      SELECT $targetSalesSelect
	      FROM tbl_target_sales_per_store
	      $whereSQLTS
	    )
	    SELECT *,
	    	ROUND(
			    COALESCE(amount_january, 0) + COALESCE(amount_february, 0) + COALESCE(amount_march, 0) +
			    COALESCE(amount_april, 0) + COALESCE(amount_may, 0) + COALESCE(amount_june, 0) +
			    COALESCE(amount_july, 0) + COALESCE(amount_august, 0) + COALESCE(amount_september, 0) +
			    COALESCE(amount_october, 0) + COALESCE(amount_november, 0) + COALESCE(amount_december, 0)
			  , 2) AS total_amount,
			ROUND((
			    COALESCE(l.ly_sell_out_january,0) + COALESCE(l.ly_sell_out_february,0) + COALESCE(l.ly_sell_out_march,0) +
			    COALESCE(l.ly_sell_out_april,0) + COALESCE(l.ly_sell_out_may,0) + COALESCE(l.ly_sell_out_june,0) +
			    COALESCE(l.ly_sell_out_july,0) + COALESCE(l.ly_sell_out_august,0) + COALESCE(l.ly_sell_out_september,0) +
			    COALESCE(l.ly_sell_out_october,0) + COALESCE(l.ly_sell_out_november,0) + COALESCE(l.ly_sell_out_december,0)
			), 2) AS total_ly_sell_out,
			ROUND((
			    COALESCE(t.ty_sell_out_january,0) + COALESCE(t.ty_sell_out_february,0) + COALESCE(t.ty_sell_out_march,0) +
			    COALESCE(t.ty_sell_out_april,0) + COALESCE(t.ty_sell_out_may,0) + COALESCE(t.ty_sell_out_june,0) +
			    COALESCE(t.ty_sell_out_july,0) + COALESCE(t.ty_sell_out_august,0) + COALESCE(t.ty_sell_out_september,0) +
			    COALESCE(t.ty_sell_out_october,0) + COALESCE(t.ty_sell_out_november,0) + COALESCE(t.ty_sell_out_december,0)
			), 2) AS total_ty_sell_out,
			ROUND((
			    COALESCE(ts.target_sales_jan,0) + COALESCE(ts.target_sales_feb,0) + COALESCE(ts.target_sales_mar,0) +
			    COALESCE(ts.target_sales_apr,0) + COALESCE(ts.target_sales_may,0) + COALESCE(ts.target_sales_jun,0) +
			    COALESCE(ts.target_sales_jul,0) + COALESCE(ts.target_sales_aug,0) + COALESCE(ts.target_sales_sep,0) +
			    COALESCE(ts.target_sales_oct,0) + COALESCE(ts.target_sales_nov,0) + COALESCE(ts.target_sales_dec,0)
			), 2) AS total_target,

			CASE WHEN l.ly_sell_out_january = 0 OR l.ly_sell_out_january IS NULL
			     THEN 'N/A'
			     ELSE ROUND((t.ty_sell_out_january - l.ly_sell_out_january) / l.ly_sell_out_january * 100, 2)
			END AS growth_january,

			CASE WHEN l.ly_sell_out_february = 0 OR l.ly_sell_out_february IS NULL
			     THEN 'N/A'
			     ELSE ROUND((t.ty_sell_out_february - l.ly_sell_out_february) / l.ly_sell_out_february * 100, 2)
			END AS growth_february,

			CASE WHEN l.ly_sell_out_march = 0 OR l.ly_sell_out_march IS NULL
			     THEN 'N/A'
			     ELSE ROUND((t.ty_sell_out_march - l.ly_sell_out_march) / l.ly_sell_out_march * 100, 2)
			END AS growth_march,

			CASE WHEN l.ly_sell_out_april = 0 OR l.ly_sell_out_april IS NULL
			     THEN 'N/A'
			     ELSE ROUND((t.ty_sell_out_april - l.ly_sell_out_april) / l.ly_sell_out_april * 100, 2)
			END AS growth_april,

			CASE WHEN l.ly_sell_out_may = 0 OR l.ly_sell_out_may IS NULL
			     THEN 'N/A'
			     ELSE ROUND((t.ty_sell_out_may - l.ly_sell_out_may) / l.ly_sell_out_may * 100, 2)
			END AS growth_may,

			CASE WHEN l.ly_sell_out_june = 0 OR l.ly_sell_out_june IS NULL
			     THEN 'N/A'
			     ELSE ROUND((t.ty_sell_out_june - l.ly_sell_out_june) / l.ly_sell_out_june * 100, 2)
			END AS growth_june,

			CASE WHEN l.ly_sell_out_july = 0 OR l.ly_sell_out_july IS NULL
			     THEN 'N/A'
			     ELSE ROUND((t.ty_sell_out_july - l.ly_sell_out_july) / l.ly_sell_out_july * 100, 2)
			END AS growth_july,

			CASE WHEN l.ly_sell_out_august = 0 OR l.ly_sell_out_august IS NULL
			     THEN 'N/A'
			     ELSE ROUND((t.ty_sell_out_august - l.ly_sell_out_august) / l.ly_sell_out_august * 100, 2)
			END AS growth_august,

			CASE WHEN l.ly_sell_out_september = 0 OR l.ly_sell_out_september IS NULL
			     THEN 'N/A'
			     ELSE ROUND((t.ty_sell_out_september - l.ly_sell_out_september) / l.ly_sell_out_september * 100, 2)
			END AS growth_september,

			CASE WHEN l.ly_sell_out_october = 0 OR l.ly_sell_out_october IS NULL
			     THEN 'N/A'
			     ELSE ROUND((t.ty_sell_out_october - l.ly_sell_out_october) / l.ly_sell_out_october * 100, 2)
			END AS growth_october,

			CASE WHEN l.ly_sell_out_november = 0 OR l.ly_sell_out_november IS NULL
			     THEN 'N/A'
			     ELSE ROUND((t.ty_sell_out_november - l.ly_sell_out_november) / l.ly_sell_out_november * 100, 2)
			END AS growth_november,

			CASE WHEN l.ly_sell_out_december = 0 OR l.ly_sell_out_december IS NULL
			     THEN 'N/A'
			     ELSE ROUND((t.ty_sell_out_december - l.ly_sell_out_december) / l.ly_sell_out_december * 100, 2)
			END AS growth_december,
	        SUM(ts.target_sales_jan - mt.amount_january) AS balance_to_target_jan,
			SUM(ts.target_sales_feb - mt.amount_february) AS balance_to_target_feb,
			SUM(ts.target_sales_mar - mt.amount_march) AS balance_to_target_mar,
			SUM(ts.target_sales_apr - mt.amount_april) AS balance_to_target_apr,
			SUM(ts.target_sales_may - mt.amount_may) AS balance_to_target_may,
			SUM(ts.target_sales_jun - mt.amount_june) AS balance_to_target_jun,
			SUM(ts.target_sales_jul - mt.amount_july) AS balance_to_target_jul,
			SUM(ts.target_sales_aug - mt.amount_august) AS balance_to_target_aug,
			SUM(ts.target_sales_sep - mt.amount_september) AS balance_to_target_sep,
			SUM(ts.target_sales_oct - mt.amount_october) AS balance_to_target_oct,
			SUM(ts.target_sales_nov - mt.amount_november) AS balance_to_target_nov,
			SUM(ts.target_sales_dec - mt.amount_december) AS balance_to_target_dec,
			ROUND((
			    COALESCE(ts.target_sales_jan - mt.amount_january) + COALESCE(ts.target_sales_feb - mt.amount_february) +
			    COALESCE(ts.target_sales_mar - mt.amount_march) + COALESCE(ts.target_sales_apr - mt.amount_april) + COALESCE(ts.target_sales_may - mt.amount_may) +
			    COALESCE(ts.target_sales_jun - mt.amount_june) + COALESCE(ts.target_sales_jul - mt.amount_july) + COALESCE(ts.target_sales_aug - mt.amount_august) +
			    COALESCE(ts.target_sales_sep - mt.amount_september) + COALESCE(ts.target_sales_oct - mt.amount_october) + COALESCE(ts.target_sales_nov - mt.amount_november) + COALESCE(ts.target_sales_dec - mt.amount_december)
			), 2) AS total_balance_to_target,
			CASE 
			    WHEN FIND_IN_SET('-5', :ba_id:) OR FIND_IN_SET('-6', :ba_id:) THEN 
			        CASE 
			            WHEN ts.target_sales_jan = 0 OR ts.target_sales_jan IS NULL THEN 'N/A'
			            ELSE ROUND((t.ty_sell_out_january / ts.target_sales_jan) * 100, 2)
			        END

			    WHEN :ba_type: IN (0, 1) THEN 
			        CASE 
			            WHEN ts.target_sales_jan = 0 OR ts.target_sales_jan IS NULL THEN 'N/A'
			            ELSE ROUND((mt.amount_january / ts.target_sales_jan) * 100, 2)
			        END

			    WHEN :ba_type: = 3 THEN 
			        CASE 
			            WHEN ts.target_sales_jan = 0 OR ts.target_sales_jan IS NULL THEN 'N/A'
			            ELSE ROUND(((t.ty_sell_out_january + mt.amount_january) / ts.target_sales_jan) * 100, 2)
			        END

			    ELSE 'N/A'
			END AS achieved_january,
			CASE 
			    WHEN FIND_IN_SET('-5', :ba_id:) OR FIND_IN_SET('-6', :ba_id:) THEN 
			        CASE 
			            WHEN ts.target_sales_feb = 0 OR ts.target_sales_feb IS NULL THEN 'N/A'
			            ELSE ROUND((t.ty_sell_out_february / ts.target_sales_feb) * 100, 2)
			        END

			    WHEN :ba_type: IN (0, 1) THEN 
			        CASE 
			            WHEN ts.target_sales_feb = 0 OR ts.target_sales_feb IS NULL THEN 'N/A'
			            ELSE ROUND((mt.amount_february / ts.target_sales_feb) * 100, 2)
			        END

			    WHEN :ba_type: = 3 THEN 
			        CASE 
			            WHEN ts.target_sales_feb = 0 OR ts.target_sales_feb IS NULL THEN 'N/A'
			            ELSE ROUND(((t.ty_sell_out_february + mt.amount_february) / ts.target_sales_feb) * 100, 2)
			        END

			    ELSE 'N/A'
			END AS achieved_february,
			CASE 
			    WHEN FIND_IN_SET('-5', :ba_id:) OR FIND_IN_SET('-6', :ba_id:) THEN 
			        CASE 
			            WHEN ts.target_sales_mar = 0 OR ts.target_sales_mar IS NULL THEN 'N/A'
			            ELSE ROUND((t.ty_sell_out_march / ts.target_sales_mar) * 100, 2)
			        END

			    WHEN :ba_type: IN (0, 1) THEN 
			        CASE 
			            WHEN ts.target_sales_mar = 0 OR ts.target_sales_mar IS NULL THEN 'N/A'
			            ELSE ROUND((mt.amount_march / ts.target_sales_mar) * 100, 2)
			        END

			    WHEN :ba_type: = 3 THEN 
			        CASE 
			            WHEN ts.target_sales_mar = 0 OR ts.target_sales_mar IS NULL THEN 'N/A'
			            ELSE ROUND(((t.ty_sell_out_march + mt.amount_march) / ts.target_sales_mar) * 100, 2)
			        END

			    ELSE 'N/A'
			END AS achieved_march,
			CASE 
			    WHEN FIND_IN_SET('-5', :ba_id:) OR FIND_IN_SET('-6', :ba_id:) THEN 
			        CASE 
			            WHEN ts.target_sales_apr = 0 OR ts.target_sales_apr IS NULL THEN 'N/A'
			            ELSE ROUND((t.ty_sell_out_april / ts.target_sales_apr) * 100, 2)
			        END

			    WHEN :ba_type: IN (0, 1) THEN 
			        CASE 
			            WHEN ts.target_sales_apr = 0 OR ts.target_sales_apr IS NULL THEN 'N/A'
			            ELSE ROUND((mt.amount_april / ts.target_sales_apr) * 100, 2)
			        END

			    WHEN :ba_type: = 3 THEN 
			        CASE 
			            WHEN ts.target_sales_apr = 0 OR ts.target_sales_apr IS NULL THEN 'N/A'
			            ELSE ROUND(((t.ty_sell_out_april + mt.amount_april) / ts.target_sales_apr) * 100, 2)
			        END

			    ELSE 'N/A'
			END AS achieved_april,
			CASE 
			    WHEN FIND_IN_SET('-5', :ba_id:) OR FIND_IN_SET('-6', :ba_id:) THEN 
			        CASE 
			            WHEN ts.target_sales_may = 0 OR ts.target_sales_may IS NULL THEN 'N/A'
			            ELSE ROUND((t.ty_sell_out_may / ts.target_sales_may) * 100, 2)
			        END

			    WHEN :ba_type: IN (0, 1) THEN 
			        CASE 
			            WHEN ts.target_sales_may = 0 OR ts.target_sales_may IS NULL THEN 'N/A'
			            ELSE ROUND((mt.amount_may / ts.target_sales_may) * 100, 2)
			        END

			    WHEN :ba_type: = 3 THEN 
			        CASE 
			            WHEN ts.target_sales_may = 0 OR ts.target_sales_may IS NULL THEN 'N/A'
			            ELSE ROUND(((t.ty_sell_out_may + mt.amount_may) / ts.target_sales_may) * 100, 2)
			        END

			    ELSE 'N/A'
			END AS achieved_may,
			CASE 
			    WHEN FIND_IN_SET('-5', :ba_id:) OR FIND_IN_SET('-6', :ba_id:) THEN 
			        CASE 
			            WHEN ts.target_sales_jun = 0 OR ts.target_sales_jun IS NULL THEN 'N/A'
			            ELSE ROUND((t.ty_sell_out_june / ts.target_sales_jun) * 100, 2)
			        END

			    WHEN :ba_type: IN (0, 1) THEN 
			        CASE 
			            WHEN ts.target_sales_jun = 0 OR ts.target_sales_jun IS NULL THEN 'N/A'
			            ELSE ROUND((mt.amount_june / ts.target_sales_jun) * 100, 2)
			        END

			    WHEN :ba_type: = 3 THEN 
			        CASE 
			            WHEN ts.target_sales_jun = 0 OR ts.target_sales_jun IS NULL THEN 'N/A'
			            ELSE ROUND(((t.ty_sell_out_june + mt.amount_june) / ts.target_sales_jun) * 100, 2)
			        END

			    ELSE 'N/A'
			END AS achieved_june,
			CASE 
			    WHEN FIND_IN_SET('-5', :ba_id:) OR FIND_IN_SET('-6', :ba_id:) THEN 
			        CASE 
			            WHEN ts.target_sales_jul = 0 OR ts.target_sales_jul IS NULL THEN 'N/A'
			            ELSE ROUND((t.ty_sell_out_july / ts.target_sales_jul) * 100, 2)
			        END

			    WHEN :ba_type: IN (0, 1) THEN 
			        CASE 
			            WHEN ts.target_sales_jul = 0 OR ts.target_sales_jul IS NULL THEN 'N/A'
			            ELSE ROUND((mt.amount_july / ts.target_sales_jul) * 100, 2)
			        END

			    WHEN :ba_type: = 3 THEN 
			        CASE 
			            WHEN ts.target_sales_jul = 0 OR ts.target_sales_jul IS NULL THEN 'N/A'
			            ELSE ROUND(((t.ty_sell_out_july + mt.amount_july) / ts.target_sales_jul) * 100, 2)
			        END

			    ELSE 'N/A'
			END AS achieved_july,
			CASE 
			    WHEN FIND_IN_SET('-5', :ba_id:) OR FIND_IN_SET('-6', :ba_id:) THEN 
			        CASE 
			            WHEN ts.target_sales_aug = 0 OR ts.target_sales_aug IS NULL THEN 'N/A'
			            ELSE ROUND((t.ty_sell_out_august / ts.target_sales_aug) * 100, 2)
			        END

			    WHEN :ba_type: IN (0, 1) THEN 
			        CASE 
			            WHEN ts.target_sales_aug = 0 OR ts.target_sales_aug IS NULL THEN 'N/A'
			            ELSE ROUND((mt.amount_august / ts.target_sales_aug) * 100, 2)
			        END

			    WHEN :ba_type: = 3 THEN 
			        CASE 
			            WHEN ts.target_sales_aug = 0 OR ts.target_sales_aug IS NULL THEN 'N/A'
			            ELSE ROUND(((t.ty_sell_out_august + mt.amount_august) / ts.target_sales_aug) * 100, 2)
			        END

			    ELSE 'N/A'
			END AS achieved_august,
			CASE 
			    WHEN FIND_IN_SET('-5', :ba_id:) OR FIND_IN_SET('-6', :ba_id:) THEN 
			        CASE 
			            WHEN ts.target_sales_sep = 0 OR ts.target_sales_sep IS NULL THEN 'N/A'
			            ELSE ROUND((t.ty_sell_out_september / ts.target_sales_sep) * 100, 2)
			        END

			    WHEN :ba_type: IN (0, 1) THEN 
			        CASE 
			            WHEN ts.target_sales_sep = 0 OR ts.target_sales_sep IS NULL THEN 'N/A'
			            ELSE ROUND((mt.amount_september / ts.target_sales_sep) * 100, 2)
			        END

			    WHEN :ba_type: = 3 THEN 
			        CASE 
			            WHEN ts.target_sales_sep = 0 OR ts.target_sales_sep IS NULL THEN 'N/A'
			            ELSE ROUND(((t.ty_sell_out_september + mt.amount_september) / ts.target_sales_sep) * 100, 2)
			        END

			    ELSE 'N/A'
			END AS achieved_september,
			CASE 
			    WHEN FIND_IN_SET('-5', :ba_id:) OR FIND_IN_SET('-6', :ba_id:) THEN 
			        CASE 
			            WHEN ts.target_sales_oct = 0 OR ts.target_sales_oct IS NULL THEN 'N/A'
			            ELSE ROUND((t.ty_sell_out_october / ts.target_sales_oct) * 100, 2)
			        END

			    WHEN :ba_type: IN (0, 1) THEN 
			        CASE 
			            WHEN ts.target_sales_oct = 0 OR ts.target_sales_oct IS NULL THEN 'N/A'
			            ELSE ROUND((mt.amount_october / ts.target_sales_oct) * 100, 2)
			        END

			    WHEN :ba_type: = 3 THEN 
			        CASE 
			            WHEN ts.target_sales_oct = 0 OR ts.target_sales_oct IS NULL THEN 'N/A'
			            ELSE ROUND(((t.ty_sell_out_october + mt.amount_october) / ts.target_sales_oct) * 100, 2)
			        END

			    ELSE 'N/A'
			END AS achieved_october,
			CASE 
			    WHEN FIND_IN_SET('-5', :ba_id:) OR FIND_IN_SET('-6', :ba_id:) THEN 
			        CASE 
			            WHEN ts.target_sales_nov = 0 OR ts.target_sales_nov IS NULL THEN 'N/A'
			            ELSE ROUND((t.ty_sell_out_november / ts.target_sales_nov) * 100, 2)
			        END

			    WHEN :ba_type: IN (0, 1) THEN 
			        CASE 
			            WHEN ts.target_sales_nov = 0 OR ts.target_sales_nov IS NULL THEN 'N/A'
			            ELSE ROUND((mt.amount_november / ts.target_sales_nov) * 100, 2)
			        END

			    WHEN :ba_type: = 3 THEN 
			        CASE 
			            WHEN ts.target_sales_nov = 0 OR ts.target_sales_nov IS NULL THEN 'N/A'
			            ELSE ROUND(((t.ty_sell_out_november + mt.amount_november) / ts.target_sales_nov) * 100, 2)
			        END

			    ELSE 'N/A'
			END AS achieved_november,
			CASE 
			    WHEN FIND_IN_SET('-5', :ba_id:) OR FIND_IN_SET('-6', :ba_id:) THEN 
			        CASE 
			            WHEN ts.target_sales_dec = 0 OR ts.target_sales_dec IS NULL THEN 'N/A'
			            ELSE ROUND((t.ty_sell_out_december / ts.target_sales_dec) * 100, 2)
			        END

			    WHEN :ba_type: IN (0, 1) THEN 
			        CASE 
			            WHEN ts.target_sales_dec = 0 OR ts.target_sales_dec IS NULL THEN 'N/A'
			            ELSE ROUND((mt.amount_december / ts.target_sales_dec) * 100, 2)
			        END

			    WHEN :ba_type: = 3 THEN 
			        CASE 
			            WHEN ts.target_sales_dec = 0 OR ts.target_sales_dec IS NULL THEN 'N/A'
			            ELSE ROUND(((t.ty_sell_out_december + mt.amount_december) / ts.target_sales_dec) * 100, 2)
			        END

			    ELSE 'N/A'
			END AS achieved_december

	    FROM monthly_totals mt
	    CROSS JOIN ly_sell_out_totals l
	    CROSS JOIN ty_sell_out_totals t
	    CROSS JOIN target_sales_totals ts;
	    ";
	    $query = $this->db->query($sql, $params);
	    return ['data' => $query->getResult()];
	}

	public function getDataVmiAllStore($pageLimit, $pageOffset, $orderByColumn, $orderDirection, $minWeeks, $maxWeeks, $weekStart, $weekEnd, $year, $ItemClasses = null, $itemCat = null, $searchValue = null)
	{
	    $storeFilterConditionsVmi = [];

	    $searchColumns = [
	        'vmi.item',
	        'vmi.itmdsc',
	        'vmi.itmcde'
	    ];

	    $searchHavingClause = '';
	    $searchParams = [];

	    if (!empty($searchValue)) {
	        $likeConditions = array_map(fn($col) => "$col LIKE ?", $searchColumns);
	        $searchHavingClause = ' AND (' . implode(' OR ', $likeConditions) . ')';
	        foreach ($searchColumns as $_) {
	            $searchParams[] = '%' . $searchValue . '%';
	        }
	    }

	    if (!empty($ItemClasses)) {
	        $ItemClasses = array_map('trim', $ItemClasses);
	        $ItemClassesConds = array_map(fn($class) => "FIND_IN_SET(" . db_connect()->escape($class) . ", vmi.item_class_id)", $ItemClasses);
	        $storeFilterConditionsVmi[] = '(' . implode(' OR ', $ItemClassesConds) . ')';
	    }

	    $allowedOrderColumns = ['sum_total_qty', 'item', 'itmdsc', 'itmcde', 'average_sales_unit', 'swc', 'week_1', 'week_2', 'week_3', 'week_4', 'week_5', 'week_6', 'week_7', 'week_8', 'week_9', 'week_10', 'week_11', 'week_12', 'week_13', 'week_14', 'week_15', 'week_16', 'week_17', 'week_18', 'week_19', 'week_20', 'week_21', 'week_22', 'week_23', 'week_24', 'week_25', 'week_26', 'week_27', 'week_28', 'week_29', 'week_30', 'week_31', 'week_32', 'week_34', 'week_35', 'week_36', 'week_37', 'week_38', 'week_39', 'week_40', 'week_41', 'week_42', 'week_43', 'week_44', 'week_45', 'week_46', 'week_47', 'week_48', 'week_49', 'week_51', 'week_52', 'week_53'];
	    $allowedOrderDirections = ['ASC', 'DESC'];

	    if (!in_array($orderByColumn, $allowedOrderColumns)) {
	        $orderByColumn = 'week_' . $weekEnd;
	    }

	    if (!in_array(strtoupper($orderDirection), $allowedOrderDirections)) {
	        $orderDirection = 'DESC';
	    }

	    $storeFilterSQLVmi = !empty($storeFilterConditionsVmi) ? ' AND ' . implode(' AND ', $storeFilterConditionsVmi) : '';

	    $itemCatFilterVmi = '';
	    $itemCatParams = [];

	    if ($itemCat !== null) {
	        $itemCatFilterVmi = ' AND vmi.itmclacde = ?';
	        $itemCatParams = [$itemCat];
	    }

	    $weekColumns = '';
	    $itemClassColumns = '';
	    for ($w = $weekStart; $w <= $weekEnd; $w++) {
	        $weekColumns .= ", SUM(CASE WHEN vmi.week = $w THEN vmi.total_qty ELSE 0 END) AS week_$w\n";
	        $itemClassColumns .= ", MAX(CASE WHEN vmi.week = $w THEN ic.item_class_description ELSE NULL END) AS item_class_week_$w\n";
	    }

	    $sql = "
	        SELECT 
	            vmi.item,
	            COALESCE(vmi.itmdsc, vmi.item_name) AS item_name,
	            vmi.itmcde,
	            MAX(ic.item_class_description) AS item_class,
	            vmi.brand_type_id, 
	            GROUP_CONCAT(DISTINCT vmi.company) AS company,
	            COALESCE(NULLIF(vmi.itmcde, ''), 'N / A') AS itmcde,
	            FORMAT(SUM(vmi.total_qty), 2) AS sum_total_qty,
	            FORMAT(SUM(vmi.total_qty) / NULLIF(SUM(vmi.average_sales_unit), 0), 2) AS swc,
	            ROUND(
	                CASE 
	                    WHEN SUM(vmi.average_sales_unit) > 0 
	                    THEN SUM(vmi.total_qty) / SUM(vmi.average_sales_unit) 
	                    ELSE 0 
	                END, 2
	            ) AS weeks,
	            COUNT(*) OVER() AS total_records
	            {$weekColumns}
	            {$itemClassColumns}
	        FROM tbl_vmi_pre_aggregated_data vmi
	        LEFT JOIN tbl_item_class ic ON vmi.item_class_id = ic.id
	        WHERE vmi.week BETWEEN ? AND ?
	          AND vmi.year = ?
	          {$itemCatFilterVmi}
	          $storeFilterSQLVmi
	        GROUP BY vmi.item
	        HAVING weeks > ?
	           AND (? IS NULL OR weeks <= ?)
	           {$searchHavingClause}
	        ORDER BY {$orderByColumn} {$orderDirection}
	        LIMIT ? OFFSET ?
	    ";

	    $params = [];

	    // Filters
	    $params[] = $weekStart;
	    $params[] = $weekEnd;
	    $params[] = $year;
	    $params = array_merge($params, $itemCatParams);

	    $params[] = $minWeeks;
	    $params[] = $maxWeeks;
	    $params[] = $maxWeeks;
	    $params = array_merge($params, $searchParams);
	    $params[] = (int)$pageLimit;
	    $params[] = (int)$pageOffset;
	    //$params = array_merge($params, [$minWeeks, $maxWeeks, $maxWeeks, (int)$pageLimit, (int)$pageOffset]);

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();
	    $totalRecords = isset($data[0]->total_records) ? $data[0]->total_records : 0;
	    //$finalQuery = $this->interpolateQuery2($sql, $params);
	    // echo $finalQuery;
	    // die();
	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

	public function getDataVmiNPDHERO($pageLimit, $pageOffset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $year, $ItemClassIdsFilter = null, $ItemClasses = null, $itemCat = null, $searchValue = null) {

		$storeFilterConditionsVmi = [];

	    $searchColumns = [
	        'vmi.item',
	        'vmi.itmdsc',
	        'vmi.itmcde'
	    ];

	    $searchHavingClause = '';
	    $searchParams = [];

	    if (!empty($searchValue)) {
	        $likeConditions = array_map(fn($col) => "$col LIKE ?", $searchColumns);
	        $searchHavingClause = ' AND (' . implode(' OR ', $likeConditions) . ')';
	        foreach ($searchColumns as $_) {
	            $searchParams[] = '%' . $searchValue . '%';
	        }
	    }

		if (!empty($ItemClasses)) {
		    $ItemClasses = array_map('trim', $ItemClasses);
		    $ItemClassesConds = array_map(fn($class) => "FIND_IN_SET(" . db_connect()->escape($class) . ", vmi.item_class_id)", $ItemClasses);
		    $storeFilterConditionsVmi[] = '(' . implode(' OR ', $ItemClassesConds) . ')';
		}

	    $allowedOrderColumns = ['item', 'itmdsc', 'itmcde', 'average_sales_unit', 'swc', 'week_1', 'week_2', 'week_3', 'week_4', 'week_5', 'week_6', 'week_7', 'week_8', 'week_9', 'week_10', 'week_11', 'week_12', 'week_13', 'week_14', 'week_15', 'week_16', 'week_17', 'week_18', 'week_19', 'week_20', 'week_21', 'week_22', 'week_23', 'week_24', 'week_25', 'week_26', 'week_27', 'week_28', 'week_29', 'week_30', 'week_31', 'week_32', 'week_34', 'week_35', 'week_36', 'week_37', 'week_38', 'week_39', 'week_40', 'week_41', 'week_42', 'week_43', 'week_44', 'week_45', 'week_46', 'week_47', 'week_48', 'week_49', 'week_51', 'week_52', 'week_53'];
	    $allowedOrderDirections = ['ASC', 'DESC'];


	    if (!in_array($orderByColumn, $allowedOrderColumns)) {
	        $orderByColumn = 'week_' . $weekEnd;
	    }

	    if (!in_array(strtoupper($orderDirection), $allowedOrderDirections)) {
	        $orderDirection = 'DESC';
	    }

	    $storeFilterSQLVmi = !empty($storeFilterConditionsVmi)
		    ? ' AND ' . implode(' AND ', $storeFilterConditionsVmi)
		    : '';

	    $ItemClassIdsPlaceholder = '';
	    $ItemClassIdsParams = [];
	    if (!empty($ItemClassIdsFilter)) {
	        $ItemClassIdsPlaceholder = ' AND vmi.item_class_id IN (' . implode(',', array_fill(0, count($ItemClassIdsFilter), '?')) . ')';
	        $ItemClassIdsParams = $ItemClassIdsFilter;
	    }

		$itemCatFilterVmi = '';
		$itemCatParams = [];

		if ($itemCat !== null) {
		    $itemCatFilterVmi = ' AND vmi.itmclacde = ?';
		    $itemCatParams = [$itemCat];
		}

	    $weekColumns = '';
	    $itemClassColumns = '';
	    for ($w = $weekStart; $w <= $weekEnd; $w++) {
	        $weekColumns .= ", SUM(CASE WHEN vmi.week = $w THEN vmi.total_qty ELSE 0 END) AS week_$w\n";
	        $itemClassColumns .= ", MAX(CASE WHEN vmi.week = $w THEN ic.item_class_description ELSE NULL END) AS item_class_week_$w\n";
	    }

	    $sql = "
	        SELECT 
	            vmi.item,
	            COALESCE(vmi.itmdsc, vmi.item_name) AS item_name,
	            ic.item_class_description AS item_class_name,
	            vmi.itmcde,
	            vmi.brand_type_id, 
	            GROUP_CONCAT(DISTINCT vmi.company) AS company,
	            COALESCE(NULLIF(vmi.itmcde, ''), 'N / A') AS itmcde,
	            FORMAT(SUM(vmi.total_qty), 2) AS sum_total_qty,
	            FORMAT(SUM(vmi.total_qty) / NULLIF(SUM(vmi.average_sales_unit), 0), 2) AS swc,
	            ROUND(
	                CASE 
	                    WHEN SUM(vmi.average_sales_unit) > 0 
	                    THEN SUM(vmi.total_qty) / SUM(vmi.average_sales_unit) 
	                    ELSE 0 
	                END, 2
	            ) AS weeks,
	            COUNT(*) OVER() AS total_records
	            {$weekColumns}
	            {$itemClassColumns}
	        FROM tbl_vmi_pre_aggregated_data vmi
	        LEFT JOIN tbl_item_class ic ON vmi.item_class_id = ic.id
	        WHERE vmi.week BETWEEN ? AND ?
	          AND vmi.year = ?
	          {$itemCatFilterVmi}
	          {$ItemClassIdsPlaceholder}
	          {$storeFilterSQLVmi}
	        GROUP BY vmi.item
        	HAVING 1=1
		    	{$searchHavingClause}
	        ORDER BY {$orderByColumn} {$orderDirection}
	        LIMIT ? OFFSET ?
	    ";

		$params = [];

	    $params[] = $weekStart;
	    $params[] = $weekEnd;
		$params[] = $year;

		if ($itemCat !== null) $params[] = $itemCat;
		$params = array_merge($params, $ItemClassIdsParams);

		$params = array_merge($params, $searchParams);
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

	public function getDataWeekAllStore($pageLimit, $pageOffset, $orderByColumn, $orderDirection, $minWeeks, $maxWeeks, $weekStart, $weekEnd, $year, $ItemClasses = null, $itemCat = null, $searchValue = null)
	{
	    $storeFilterConditionsWow = [];

	    $searchColumns = [
	        'wow.item',
	        'wow.itmdsc',
	        'wow.itmcde'
	    ];

	    $searchHavingClause = '';
	    $searchParams = [];

	    if (!empty($searchValue)) {
	        $likeConditions = array_map(fn($col) => "$col LIKE ?", $searchColumns);
	        $searchHavingClause = ' AND (' . implode(' OR ', $likeConditions) . ')';
	        foreach ($searchColumns as $_) {
	            $searchParams[] = '%' . $searchValue . '%';
	        }
	    }

	    if (!empty($ItemClasses)) {
	        $ItemClasses = array_map('trim', $ItemClasses);
	        $ItemClassesConds = array_map(fn($class) => "FIND_IN_SET(" . db_connect()->escape($class) . ", wow.item_class)", $ItemClasses);
	        $storeFilterConditionsWow[] = '(' . implode(' OR ', $ItemClassesConds) . ')';
	    }

	    $allowedOrderColumns = ['sum_total_qty', 'item', 'itmdsc', 'itmcde', 'average_sales_unit', 'swc', 'week_1', 'week_2', 'week_3', 'week_4', 'week_5', 'week_6', 'week_7', 'week_8', 'week_9', 'week_10', 'week_11', 'week_12', 'week_13', 'week_14', 'week_15', 'week_16', 'week_17', 'week_18', 'week_19', 'week_20', 'week_21', 'week_22', 'week_23', 'week_24', 'week_25', 'week_26', 'week_27', 'week_28', 'week_29', 'week_30', 'week_31', 'week_32', 'week_34', 'week_35', 'week_36', 'week_37', 'week_38', 'week_39', 'week_40', 'week_41', 'week_42', 'week_43', 'week_44', 'week_45', 'week_46', 'week_47', 'week_48', 'week_49', 'week_51', 'week_52', 'week_53'];
	    $allowedOrderDirections = ['ASC', 'DESC'];

	    if (!in_array($orderByColumn, $allowedOrderColumns)) {
	        $orderByColumn = 'week_' . $weekEnd;
	    }

	    if (!in_array(strtoupper($orderDirection), $allowedOrderDirections)) {
	        $orderDirection = 'DESC';
	    }

	    $storeFilterSQLWow = !empty($storeFilterConditionsWow) ? ' AND ' . implode(' AND ', $storeFilterConditionsWow) : '';

	    $itemCatFilterWow = '';
	    $itemCatParams = [];

	    if ($itemCat !== null) {
	        $itemCatFilterWow = ' AND wow.itmclacde = ?';
	        $itemCatParams = [$itemCat];
	    }

	    $weekColumns = '';
	    $itemClassColumns = '';
	    for ($w = $weekStart; $w <= $weekEnd; $w++) {
	        $weekColumns .= ", SUM(CASE WHEN wow.week = $w THEN wow.quantity ELSE 0 END) AS week_$w\n";
	        $itemClassColumns .= ", MAX(CASE WHEN wow.week = $w THEN ic.item_class_description ELSE NULL END) AS item_class_week_$w\n";
	    }

	    $sql = "
	        SELECT 
	            wow.item,
	            COALESCE(wow.itmdsc, wow.item_name) AS item_name,
	            wow.itmcde,
	            ic.item_class_description AS item_class_name,
	            wow.brand_type_id, 
	            COALESCE(NULLIF(wow.itmcde, ''), 'N / A') AS itmcde,
	            FORMAT(SUM(wow.quantity), 2) AS sum_total_qty,
	            FORMAT(SUM(wow.quantity) / NULLIF(SUM(wow.ave_weekly_sales), 0), 2) AS swc,
	            ROUND(
	                CASE 
	                    WHEN SUM(wow.ave_weekly_sales) > 0 
	                    THEN SUM(wow.quantity) / SUM(wow.ave_weekly_sales) 
	                    ELSE 0 
	                END, 2
	            ) AS weeks,
	            COUNT(*) OVER() AS total_records
	            {$weekColumns}
	            {$itemClassColumns}	
	        FROM tbl_week_on_week_vmi_pre_aggregated_data wow
	        LEFT JOIN tbl_item_class ic ON wow.item_class = ic.id
	        WHERE wow.week BETWEEN ? AND ?
	          AND wow.year = ?
	          {$itemCatFilterWow}
	          $storeFilterSQLWow
	        GROUP BY wow.item
	        HAVING weeks > ?
	           AND (? IS NULL OR weeks <= ?)
	           {$searchHavingClause}
	        ORDER BY {$orderByColumn} {$orderDirection}
	        LIMIT ? OFFSET ?
	    ";

	    $params = [];

	    // Filters
	    $params[] = $weekStart;
	    $params[] = $weekEnd;
	    $params[] = $year;
	    $params = array_merge($params, $itemCatParams);

	    $params[] = $minWeeks;
	    $params[] = $maxWeeks;
	    $params[] = $maxWeeks;
	    $params = array_merge($params, $searchParams);
	    $params[] = (int)$pageLimit;
	    $params[] = (int)$pageOffset;
	    //$params = array_merge($params, [$minWeeks, $maxWeeks, $maxWeeks, (int)$pageLimit, (int)$pageOffset]);

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();
	    $totalRecords = isset($data[0]->total_records) ? $data[0]->total_records : 0;

	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

	public function getDataWeekAllNPDHERO($pageLimit, $pageOffset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $year, $ItemClassIdsFilter = null, $ItemClasses = null, $itemCat = null, $searchValue = null) {

		$storeFilterConditionsVmi = [];

	    $searchColumns = [
	        'wow.item',
	        'wow.itmdsc',
	        'wow.itmcde'
	    ];

	    $searchHavingClause = '';
	    $searchParams = [];

	    if (!empty($searchValue)) {
	        $likeConditions = array_map(fn($col) => "$col LIKE ?", $searchColumns);
	        $searchHavingClause = ' AND (' . implode(' OR ', $likeConditions) . ')';
	        foreach ($searchColumns as $_) {
	            $searchParams[] = '%' . $searchValue . '%';
	        }
	    }

		if (!empty($ItemClasses)) {
		    $ItemClasses = array_map('trim', $ItemClasses);
		    $ItemClassesConds = array_map(fn($class) => "FIND_IN_SET(" . db_connect()->escape($class) . ", wow.item_class)", $ItemClasses);
		    $storeFilterConditionsVmi[] = '(' . implode(' OR ', $ItemClassesConds) . ')';
		}

	    $allowedOrderColumns = ['item', 'itmdsc', 'itmcde', 'average_sales_unit', 'swc', 'week_1', 'week_2', 'week_3', 'week_4', 'week_5', 'week_6', 'week_7', 'week_8', 'week_9', 'week_10', 'week_11', 'week_12', 'week_13', 'week_14', 'week_15', 'week_16', 'week_17', 'week_18', 'week_19', 'week_20', 'week_21', 'week_22', 'week_23', 'week_24', 'week_25', 'week_26', 'week_27', 'week_28', 'week_29', 'week_30', 'week_31', 'week_32', 'week_34', 'week_35', 'week_36', 'week_37', 'week_38', 'week_39', 'week_40', 'week_41', 'week_42', 'week_43', 'week_44', 'week_45', 'week_46', 'week_47', 'week_48', 'week_49', 'week_51', 'week_52', 'week_53'];
	    $allowedOrderDirections = ['ASC', 'DESC'];


	    if (!in_array($orderByColumn, $allowedOrderColumns)) {
	        $orderByColumn = 'week_' . $weekEnd;
	    }

	    if (!in_array(strtoupper($orderDirection), $allowedOrderDirections)) {
	        $orderDirection = 'DESC';
	    }


	    $storeFilterSQLVmi = !empty($storeFilterConditionsVmi)
		    ? ' AND ' . implode(' AND ', $storeFilterConditionsVmi)
		    : '';

	    $ItemClassIdsPlaceholder = '';
	    $ItemClassIdsParams = [];
	    if (!empty($ItemClassIdsFilter)) {
	        $ItemClassIdsPlaceholder = ' AND wow.item_class IN (' . implode(',', array_fill(0, count($ItemClassIdsFilter), '?')) . ')';
	        $ItemClassIdsParams = $ItemClassIdsFilter;
	    }

		$itemCatFilterVmi = '';
		$itemCatParams = [];

		if ($itemCat !== null) {
		    $itemCatFilterVmi = ' AND wow.itmclacde = ?';
		    $itemCatParams = [$itemCat];
		}

	    $weekColumns = '';
	    $itemClassColumns = '';
	    for ($w = $weekStart; $w <= $weekEnd; $w++) {
	        $weekColumns .= ", SUM(CASE WHEN wow.week = $w THEN wow.quantity ELSE 0 END) AS week_$w\n";
	        $itemClassColumns .= ", MAX(CASE WHEN wow.week = $w THEN ic.item_class_description ELSE NULL END) AS item_class_week_$w\n";
	    }

	    $sql = "
	        SELECT 
	            wow.item,
	            COALESCE(wow.itmdsc, wow.item_name) AS item_name,
	            ic.item_class_description AS item_class_name,
	            wow.itmcde,
	            wow.brand_type_id, 
	            COALESCE(NULLIF(wow.itmcde, ''), 'N / A') AS itmcde,
	            FORMAT(SUM(wow.quantity), 2) AS sum_total_qty,
	            FORMAT(SUM(wow.quantity) / NULLIF(SUM(wow.ave_weekly_sales), 0), 2) AS swc,
	            ROUND(
	                CASE 
	                    WHEN SUM(wow.ave_weekly_sales) > 0 
	                    THEN SUM(wow.quantity) / SUM(wow.ave_weekly_sales) 
	                    ELSE 0 
	                END, 2
	            ) AS weeks,
	            COUNT(*) OVER() AS total_records
	            {$weekColumns}
	            {$itemClassColumns}
	        FROM tbl_week_on_week_vmi_pre_aggregated_data wow
	        LEFT JOIN tbl_item_class ic ON wow.item_class = ic.id
	        WHERE wow.week BETWEEN ? AND ?
	          AND wow.year = ?
	          {$itemCatFilterVmi}
	          {$ItemClassIdsPlaceholder}
	          {$storeFilterSQLVmi}
	        GROUP BY wow.item
			HAVING 1=1
			    {$searchHavingClause}
	        ORDER BY {$orderByColumn} {$orderDirection}
	        LIMIT ? OFFSET ?
	    ";

		$params = [];

	    $params[] = $weekStart;
	    $params[] = $weekEnd;
		$params[] = $year;

		if ($itemCat !== null) $params[] = $itemCat;
		$params = array_merge($params, $ItemClassIdsParams);
		$params = array_merge($params, $searchParams);
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

	public function getStorePerformance(
	    $month_start, $month_end, $orderByColumn, $orderDirection, $year, $limit, $offset,
	    $area_id = null, $asc_id = null, $store_code = null,
	    $ba_id = null, $ba_type = null,
	    $brand_category = null, $brands = null, $searchValue = null) {
	    $last_year = $year - 1;
	    $allowedOrderColumns = ['rank', 'store_code', 'ty_scanned_data', 'ly_scanned_data', 'growth', 'sob'];
	    $allowedOrderDirections = ['ASC', 'DESC'];

		$searchColumns = [
		    'store_name',       // store
		];

		$searchHavingClause = '';
		$searchParams = [];

		if (!empty($searchValue)) {
		    $likeConditions = array_map(fn($col) => "$col LIKE ?", $searchColumns);
		    $searchHavingClause = ' HAVING ' . implode(' OR ', $likeConditions);
		    foreach ($searchColumns as $_) {
		        $searchParams[] = '%' . $searchValue . '%';
		    }
		}

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
				    WHEN ly.ly_scanned_data IS NULL OR ty.ty_scanned_data IS NULL THEN NULL
				    WHEN COALESCE(ly.ly_scanned_data, 0) = 0 THEN NULL
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
	        $searchHavingClause
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
	        ]
	    );

	    $params = array_merge($params, $searchParams);

	    // Pagination
	    $params[] = (int)$limit;
	    $params[] = (int)$offset;

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();
	    $totalRecords = $data ? $data[0]->total_records : 0;

	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

	public function getSellThroughScannDataBySku(
	    $year = null, 
	    $monthStart = null, 
	    $monthEnd = null, 
	    $searchValue = null,
	    $ItemIds = [],
	    $brandIds = [],
	    $brandTypeIds = [], 
	    $brandCategoryIds = [], 
	    $salesGroup = null, 
	    $subSalesGroup = null, 
	    $orderByColumn = 'rank', 
	    $orderDirection = 'DESC', 
	    $limit = 100, 
	    $offset = 0, 
	    $sellInType = 3,
	    $measure = 'qty'
	) {
	    $allowedOrderColumns = ['rank', 'itmcde', 'customer_sku', 'item_description', 'brand_category', 'brand', 'sell_in', 'sell_out', 'sell_out_ratio'];
	    $allowedOrderDirections = ['ASC', 'DESC'];

	    $searchColumns = [
	        'LOWER(itmcde)',
	        'LOWER(customer_sku)',
	        'LOWER(item_description)',
	        'LOWER(brand)',
	        'LOWER(brand_category)',
	    ];

	    $searchClause = '';
	    $searchParams = [];

	    if (!empty($searchValue)) {
	        $likeConditions = array_map(fn($col) => "$col LIKE ?", $searchColumns);
	        $searchClause = 'WHERE ' . implode(' OR ', $likeConditions);
	        foreach ($searchColumns as $_) {
	            $searchParams[] = '%' . strtolower($searchValue) . '%';
	        }
	    }

	    if (!in_array($orderByColumn, $allowedOrderColumns)) {
	        $orderByColumn = 'sell_out_ratio';
	    }

	    if (!in_array(strtoupper($orderDirection), $allowedOrderDirections)) {
	        $orderDirection = 'DESC';
	    }

	    $skuFilter = '';
	    $skuParams = [];
	    if (!empty($ItemIds)) {
	        $placeholders = implode(',', array_fill(0, count($ItemIds), '?'));
	        $skuFilter = "AND so.itmcde IN ($placeholders)";
	        $skuParams = $ItemIds;
	    }

	    $brandFilter = '';
	    $brandParams = [];
	    if (!empty($brandIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandIds), '?'));
	        $brandFilter = "AND so.brand_id IN ($placeholders)";
	        $brandParams = $brandIds;
	    }

	    $brandCategoryFilter = '';
	    $brandCategoryParams = [];
	    if (!empty($brandCategoryIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandCategoryIds), '?'));
	        $brandCategoryFilter = "AND so.item_class_id IN ($placeholders)";
	        $brandCategoryParams = $brandCategoryIds;
	    }

	    $brandLabelTypeFilter = '';
	    $brandLabelTypeParams = [];
	    if (!empty($brandTypeIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandTypeIds), '?'));
	        $brandLabelTypeFilter = "AND so.brand_type_id IN ($placeholders)";
	        $brandLabelTypeParams = $brandTypeIds;
	    }	    

	    $skuFilterOutright = $skuFilterConsignment = '';
	    if (!empty($ItemIds)) {
	        $placeholders = implode(',', array_fill(0, count($ItemIds), '?'));
	        $skuFilterOutright = "AND s.itmcde IN ($placeholders)";
	        $skuFilterConsignment = "AND s.itmcde IN ($placeholders)";
	    }

	    $brandFilterOutright = $brandFilterConsignment = '';
	    if (!empty($brandIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandIds), '?'));
	        $brandFilterOutright = "AND s.brand_id IN ($placeholders)";
	        $brandFilterConsignment = "AND s.brand_id IN ($placeholders)";
	    }

	    $brandCategoryFilterOutright = $brandCategoryFilterConsignment = '';
	    if (!empty($brandCategoryIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandCategoryIds), '?'));
	        $brandCategoryFilterOutright = "AND s.brand_category_id IN ($placeholders)";
	        $brandCategoryFilterConsignment = "AND s.brand_category_id IN ($placeholders)";
	    }

	    $brandLabelTypeFilterOutright = $brandLabelTypeFilterConsignment = '';
	    if (!empty($brandTypeIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandTypeIds), '?'));
	        $brandLabelTypeFilterOutright = "AND s.brand_label_type_id IN ($placeholders)";
	        $brandLabelTypeFilterConsignment = "AND s.brand_label_type_id IN ($placeholders)";
	    }

		if ($subSalesGroup) {
		    $sellOutExpr = $measure === 'amount'
		        ? "ROUND(so.quantity * 
		            IF(
		                mp.effectivity_date <= CURRENT_DATE(),
		                IFNULL(cp.net_price, IFNULL(so.net_price, 0)),
		                IFNULL(hp.net_price, IFNULL(so.net_price, 0))
		            )
		        , 2)"
		        : "ROUND(so.quantity, 0)";

		    $sellOutExpr2 = $sellOutExpr;
		} else {
		    $sellOutExpr = $measure === 'amount'
		        ? "ROUND(so.quantity * IFNULL(so.net_price, 0), 2)"
		        : "ROUND(so.quantity, 0)";

		    $sellOutExpr2 = $sellOutExpr;
		}
			    
	    $outrightExpr = $measure === 'amount'
	        ? "ROUND(SUM(s.extprc), 2)"
	        : "ROUND(SUM(s.itmqty * IFNULL(u.conver, 1)), 0)";

	    $consignmentExpr = $measure === 'amount'
	        ? "ROUND(SUM(s.amt), 2)"
	        : "ROUND(SUM(s.itmqty * IFNULL(u.conver, 1)), 0)";

		if ($measure === "amount") {
		    $sellInExpr = ($sellInType == 1 
		        ? "ROUND(IFNULL(o.total_qty, 0), 2)"
		        : ($sellInType == 0
		            ? "ROUND(IFNULL(c.total_qty, 0), 2)"
		            : "ROUND(IFNULL(o.total_qty, 0) + IFNULL(c.total_qty, 0), 2)")
		    );
		} else {
		    $sellInExpr = ($sellInType == 1 
		        ? "ROUND(IFNULL(o.total_qty, 0), 0)"
		        : ($sellInType == 0
		            ? "ROUND(IFNULL(c.total_qty, 0), 0)"
		            : "ROUND(IFNULL(o.total_qty, 0) + IFNULL(c.total_qty, 0), 0)")
		    );
		}

		$sql = "
	        WITH aggregated AS (
			    SELECT
			        sub.itmcde,
			        sub.brand_id,
			        sub.customer_payment_group,
			        sub.item_description,
			        sub.cust_item_code,
			        GROUP_CONCAT(DISTINCT sub.brand_type_id) AS brand_type_id,
			        GROUP_CONCAT(DISTINCT sub.item_class_id) AS brand_category_id,
			        SUM(sub.quantity) AS sell_out
			    FROM (
			        SELECT
			            so.itmcde,
			            so.brand_id,
			            so.customer_payment_group,
			            so.brand_type_id,
			            mp.item_description,
			            mp.cust_item_code,
			            so.item_class_id,
						$sellOutExpr AS quantity
			        FROM tbl_sell_out_pre_aggregated_data so
			        INNER JOIN tbl_main_pricelist mp
			            ON so.itmcde = mp.item_code
			            
			        LEFT JOIN tbl_customer_pricelist cp
			            ON so.itmcde = cp.item_code
			        LEFT JOIN tbl_historical_sub_pricelist hp
		            ON cp.id = hp.customer_id
			        WHERE mp.status = 1 
			          AND (? IS NULL OR so.year = ?)
			          AND (? IS NULL OR so.month BETWEEN ? AND ?)
			          $skuFilter
			          $brandFilter
			          $brandCategoryFilter
			          $brandLabelTypeFilter
			          AND (? IS NULL OR so.customer_payment_group = ? AND mp.customer_payment_group = ?)
				    ) AS sub
			    GROUP BY sub.itmcde
		    ),
	        outright AS (
	            SELECT 
	                s.itmcde,
	                s.brand_id,
	                s.brand_label_type_id,
	                s.brand_category_id,
	                $outrightExpr AS total_qty
	            FROM tbl_item_salesfile2_all s
	            LEFT JOIN (
	                SELECT itmcde, untmea, brand_id, brand_label_type_id, brand_category_id, MAX(conver) AS conver
	                FROM tbl_item_unit_file_all
	                GROUP BY itmcde, untmea
	            ) u 
	              ON s.itmcde = u.itmcde
	             AND s.untmea = u.untmea
	            WHERE s.trncde = 'SAL'
	              AND (s.dettyp <> 'C' OR s.dettyp IS NULL)
	              AND (? IS NULL OR YEAR(s.trndte) = ?)
	              AND (? IS NULL OR MONTH(s.trndte) BETWEEN ? AND ?)
	              AND (? IS NULL OR s.customer_group = ?)
	              AND (? IS NULL OR s.cuscde = ?)
	              $skuFilterOutright
	              $brandFilterOutright
	              $brandCategoryFilterOutright
	              $brandLabelTypeFilterOutright
	              AND EXISTS (
	                  SELECT 1 
	                  FROM tbl_cus_sellout_indicator ci
	                  WHERE ci.cus_code = s.cuscde
	              )
	            GROUP BY s.itmcde
	        ),
	        consignment AS (
	            SELECT 
	                s.itmcde,
	                s.brand_id,
	                s.brand_label_type_id,
	                s.brand_category_id,
	                $consignmentExpr AS total_qty
	            FROM tbl_item_salesfile_consignment_all s
	            LEFT JOIN (
	                SELECT itmcde, untmea, brand_id, brand_label_type_id, brand_category_id, MAX(conver) AS conver
	                FROM tbl_item_unit_file_all
	                GROUP BY itmcde, untmea
	            ) u 
	              ON s.itmcde = u.itmcde
	              AND s.untmea = u.untmea
	            WHERE (? IS NULL OR YEAR(s.trndte) = ?)
	              AND (? IS NULL OR MONTH(s.trndte) BETWEEN ? AND ?)
	              AND (? IS NULL OR s.customer_group = ?)
	              AND (? IS NULL OR s.cuscde = ?)
	              $skuFilterConsignment
	              $brandFilterConsignment
	              $brandCategoryFilterConsignment
	              $brandLabelTypeFilterConsignment
	              AND EXISTS (
	                  SELECT 1 
	                  FROM tbl_cus_sellout_indicator ci
	                  WHERE ci.cus_code = s.cuscde
	              )
	            GROUP BY s.itmcde
	        ),
	        final_data AS (
	            SELECT
	                a.itmcde,
	                a.customer_payment_group,
	                a.brand_id,
	                a.brand_type_id,
	                a.brand_category_id,
	                pm.id AS pricelist_masterfile_id,
	                pm.description AS pricelist_group,
	                a.item_description AS item_description,
	                a.cust_item_code AS customer_sku,
	                br.brand_description AS brand,
	                blt.label AS brand_label,
	                cl.item_class_description AS brand_category,
	                $sellInExpr AS sell_in,
	                a.sell_out,
	                CASE 
	                    WHEN $sellInExpr > 0 
	                    THEN CAST(ROUND((a.sell_out / $sellInExpr) * 100, 2) AS DECIMAL(10,2))
	                    ELSE 0
	                END AS sell_out_ratio,
	                COUNT(*) OVER() AS total_records
	            FROM aggregated a
	            INNER JOIN tbl_pricelist_masterfile pm
	                ON a.customer_payment_group = pm.description
	            LEFT JOIN outright o
	                ON a.itmcde = o.itmcde
	            LEFT JOIN consignment c
	                ON a.itmcde = c.itmcde 
	            LEFT JOIN tbl_brand br
	                ON a.brand_id = br.id
	            LEFT JOIN tbl_classification cl
	                ON a.brand_category_id = cl.id
	            LEFT JOIN tbl_brand_label_type blt
	                ON br.category_id = blt.id
	        )
	        SELECT 
	            ROW_NUMBER() OVER(ORDER BY sell_out_ratio DESC) AS rank,
	            itmcde,
	            customer_payment_group,
	            pricelist_masterfile_id,
	            pricelist_group,
	            item_description,
	            customer_sku,
	            sell_in,
	            sell_out,
	            sell_out_ratio,
	            brand,
	            brand_label,
	            brand_category,
	            total_records
	        FROM final_data
	        $searchClause
	        ORDER BY {$orderByColumn} {$orderDirection}
	        LIMIT ? OFFSET ?;
	    ";

	    $params = [
	        $year, $year,
	        $monthStart, $monthStart, $monthEnd,
	    ];
	    $params = array_merge($params, $skuParams, $brandParams, $brandCategoryParams, $brandLabelTypeParams);
	    $params = array_merge($params, [
	        $salesGroup, $salesGroup, $salesGroup,
	        // outright
	        $year, $year,
	        $monthStart, $monthStart, $monthEnd,
	        $salesGroup, $salesGroup,
	        $subSalesGroup, $subSalesGroup,
	    ]);
	    $params = array_merge($params, $skuParams, $brandParams, $brandCategoryParams, $brandLabelTypeParams);
	    $params = array_merge($params, [
	        // consignment
	        $year, $year,
	        $monthStart, $monthStart, $monthEnd,
	        $salesGroup, $salesGroup,
	        $subSalesGroup, $subSalesGroup,
	    ]);
	    $params = array_merge($params, $skuParams, $brandParams, $brandCategoryParams, $brandLabelTypeParams);
	    $params = array_merge($params, $searchParams);

	    $params[] = (int)$limit;
	    $params[] = (int)$offset;

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();
	    $totalRecords = $data ? $data[0]->total_records : 0;
		//$finalQuery = $this->interpolateQuery($sql, $params);
		// echo $finalQuery;
		// die();	   
	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

	public function getSellThroughWeekOnWeekBySku(
	    $year = null, 
	    $yearId = null, 
	    $weekStart = null, 
	    $weekEnd = null,
		$weekStartDate = null,
		$weekEndDate= null,
	    $searchValue = null,
	    $ItemIds = [],
	    $brandIds = [],
	    $brandTypeIds = [], 
	    $brandCategoryIds = [], 
	    $salesGroup = null, 
	    $subSalesGroup = null,
	    $watsonsPaymentGroup = null,
	    $orderByColumn = 'rank', 
	    $orderDirection = 'DESC', 
	    $limit = 100, 
	    $offset = 0, 
	    $sellInType = 3,
	    $measure = 'qty'
	) {
	    $allowedOrderColumns = ['rank', 'itmcde', 'customer_sku', 'item_description', 'brand_category', 'brand', 'sell_in', 'sell_out', 'sell_out_ratio'];
	    $allowedOrderDirections = ['ASC', 'DESC'];

	    $searchColumns = [
	        'LOWER(itmcde)',
	        'LOWER(customer_sku)',
	        'LOWER(item_description)',
	        'LOWER(brand)',
	        'LOWER(brand_category)',
	    ];

	    $searchClause = '';
	    $searchParams = [];

	    if (!empty($searchValue)) {
	        $likeConditions = array_map(fn($col) => "$col LIKE ?", $searchColumns);
	        $searchClause = 'WHERE ' . implode(' OR ', $likeConditions);
	        foreach ($searchColumns as $_) {
	            $searchParams[] = '%' . strtolower($searchValue) . '%';
	        }
	    }

	    if (!in_array($orderByColumn, $allowedOrderColumns)) {
	        $orderByColumn = 'sell_out_ratio';
	    }

	    if (!in_array(strtoupper($orderDirection), $allowedOrderDirections)) {
	        $orderDirection = 'DESC';
	    }

	    $skuFilter = '';
	    $skuParams = [];
	    if (!empty($ItemIds)) {
	        $placeholders = implode(',', array_fill(0, count($ItemIds), '?'));
	        $skuFilter = "AND wow.itmcde IN ($placeholders)";
	        $skuParams = $ItemIds;
	    }

	    $brandFilter = '';
	    $brandParams = [];
	    if (!empty($brandIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandIds), '?'));
	        $brandFilter = "AND wow.tracc_brand_id IN ($placeholders)";
	        $brandParams = $brandIds;
	    }

	    $brandCategoryFilter = '';
	    $brandCategoryParams = [];
	    if (!empty($brandCategoryIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandCategoryIds), '?'));
	        $brandCategoryFilter = "AND wow.item_class_id IN ($placeholders)";
	        $brandCategoryParams = $brandCategoryIds;
	    }

	    $brandLabelTypeFilter = '';
	    $brandLabelTypeParams = [];
	    if (!empty($brandTypeIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandTypeIds), '?'));
	        $brandLabelTypeFilter = "AND wow.brand_type_id IN ($placeholders)";
	        $brandLabelTypeParams = $brandTypeIds;
	    }	

	    $skuFilterOutright = $skuFilterConsignment = '';
	    if (!empty($ItemIds)) {
	        $placeholders = implode(',', array_fill(0, count($ItemIds), '?'));
	        $skuFilterOutright = "AND s.itmcde IN ($placeholders)";
	        $skuFilterConsignment = "AND s.itmcde IN ($placeholders)";
	    }

	    $brandFilterOutright = $brandFilterConsignment = '';
	    if (!empty($brandIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandIds), '?'));
	        $brandFilterOutright = "AND s.brand_id IN ($placeholders)";
	        $brandFilterConsignment = "AND s.brand_id IN ($placeholders)";
	    }

	    $brandCategoryFilterOutright = $brandCategoryFilterConsignment = '';
	    if (!empty($brandCategoryIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandCategoryIds), '?'));
	        $brandCategoryFilterOutright = "AND s.brand_category_id IN ($placeholders)";
	        $brandCategoryFilterConsignment = "AND s.brand_category_id IN ($placeholders)";
	    }

	    $brandLabelTypeFilterOutright = $brandLabelTypeFilterConsignment = '';
	    if (!empty($brandTypeIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandTypeIds), '?'));
	        $brandLabelTypeFilterOutright = "AND s.brand_label_type_id IN ($placeholders)";
	        $brandLabelTypeFilterConsignment = "AND s.brand_label_type_id IN ($placeholders)";
	    }

		if ($subSalesGroup) {
		    $sellOutExpr = $measure === 'amount'
		        ? "ROUND(wow.quantity * 
		            IF(
		                mp.effectivity_date <= CURRENT_DATE(),
		                IFNULL(cp.net_price, IFNULL(wow.net_price, 0)),
		                IFNULL(hp.net_price, IFNULL(wow.net_price, 0))
		            )
		        , 2)"
		        : "ROUND(wow.quantity, 0)";

		    $sellOutExpr2 = $sellOutExpr;
		} else {
		    $sellOutExpr = $measure === 'amount'
		        ? "ROUND(wow.quantity * IFNULL(wow.net_price, 0), 2)"
		        : "ROUND(wow.quantity, 0)";

		    $sellOutExpr2 = $sellOutExpr;
		}
	    
	    $outrightExpr = $measure === 'amount'
	        ? "ROUND(SUM(s.extprc), 2)"
	        : "ROUND(SUM(s.itmqty * IFNULL(u.conver, 1)), 0)";

	    $consignmentExpr = $measure === 'amount'
	        ? "ROUND(SUM(s.amt), 2)"
	        : "ROUND(SUM(s.itmqty * IFNULL(u.conver, 1)), 0)";

		if ($measure === "amount") {
		    $sellInExpr = ($sellInType == 1 
		        ? "ROUND(IFNULL(o.total_qty, 0), 2)"
		        : ($sellInType == 0
		            ? "ROUND(IFNULL(c.total_qty, 0), 2)"
		            : "ROUND(IFNULL(o.total_qty, 0) + IFNULL(c.total_qty, 0), 2)")
		    );
		} else {
		    $sellInExpr = ($sellInType == 1 
		        ? "ROUND(IFNULL(o.total_qty, 0), 0)"
		        : ($sellInType == 0
		            ? "ROUND(IFNULL(c.total_qty, 0), 0)"
		            : "ROUND(IFNULL(o.total_qty, 0) + IFNULL(c.total_qty, 0), 0)")
		    );
		}

		$sql = "
	        WITH aggregated AS (
			    SELECT
			        sub.itmcde,
			        sub.tracc_brand_id AS brand_id,
			        sub.item_description,
			        sub.cust_item_code,
			        GROUP_CONCAT(DISTINCT sub.brand_type_id) AS brand_type_id,
			        GROUP_CONCAT(DISTINCT sub.item_class_id) AS brand_category_id,
			        SUM(sub.quantity) AS sell_out
			    FROM (
			        SELECT
			            wow.itmcde,
			            wow.tracc_brand_id,
			            wow.brand_type_id,
			            mp.item_description,
			            mp.cust_item_code,
			            wow.item_class_id,
			            $sellOutExpr AS quantity
			        FROM tbl_week_on_week_vmi_pre_aggregated_data wow
			        INNER JOIN tbl_main_pricelist mp
			            ON wow.itmcde = mp.item_code
			            
			        LEFT JOIN tbl_customer_pricelist cp
			            ON wow.itmcde = cp.item_code

			        LEFT JOIN tbl_historical_sub_pricelist hp
			            ON cp.id = hp.customer_id

			        WHERE mp.status = 1
			          AND (? IS NULL OR wow.year = ?)
			          AND (? IS NULL OR wow.week BETWEEN ? AND ?)
			          AND (? IS NULL OR mp.customer_payment_group = ?)
		          $skuFilter
		          $brandFilter
		          $brandCategoryFilter
		          $brandLabelTypeFilter
			    ) AS sub
			    GROUP BY sub.itmcde
			),
	        outright AS (
	            SELECT 
	                s.itmcde,
	                s.brand_id,
	                s.brand_label_type_id,
	                s.brand_category_id,
	                $outrightExpr AS total_qty
	            FROM tbl_item_salesfile2_all s
	            LEFT JOIN (
	                SELECT itmcde, untmea, brand_id, brand_label_type_id, brand_category_id, MAX(conver) AS conver
	                FROM tbl_item_unit_file_all
	                GROUP BY itmcde, untmea
	            ) u 
	              ON s.itmcde = u.itmcde
	             AND s.untmea = u.untmea
	            WHERE s.trncde = 'SAL'
	              AND (s.dettyp <> 'C' OR s.dettyp IS NULL)
	              AND (? IS NULL OR s.trndte BETWEEN ? AND ?)
	              AND (? IS NULL OR s.customer_group = ?)
	              AND (? IS NULL OR s.cuscde = ?)
	              $skuFilterOutright
	              $brandFilterOutright
	              $brandCategoryFilterOutright
	              $brandLabelTypeFilterOutright
	              AND EXISTS (
	                  SELECT 1 
	                  FROM tbl_cus_sellout_indicator ci
	                  WHERE ci.cus_code = s.cuscde
	              )
	            GROUP BY s.itmcde
	        ),
	        consignment AS (
	            SELECT 
	                s.itmcde,
	                s.brand_id,
	                s.brand_label_type_id,
	                s.brand_category_id,
	                $consignmentExpr AS total_qty
	            FROM tbl_item_salesfile_consignment_all s
	            LEFT JOIN (
	                SELECT itmcde, untmea, brand_id, brand_label_type_id, brand_category_id, MAX(conver) AS conver
	                FROM tbl_item_unit_file_all
	                GROUP BY itmcde, untmea
	            ) u 
	              ON s.itmcde = u.itmcde
	              AND s.untmea = u.untmea
	            WHERE (? IS NULL OR s.trndte BETWEEN ? AND ?)
	              AND (? IS NULL OR s.customer_group = ?)
	              AND (? IS NULL OR s.cuscde = ?)
	              $skuFilterConsignment
	              $brandFilterConsignment
	              $brandCategoryFilterConsignment
	              $brandLabelTypeFilterConsignment
	              AND EXISTS (
	                  SELECT 1 
	                  FROM tbl_cus_sellout_indicator ci
	                  WHERE ci.cus_code = s.cuscde
	              )
	            GROUP BY s.itmcde
	        ),
	        final_data AS (
	            SELECT
	                a.itmcde,
	                a.brand_id,
	                a.brand_type_id,
	                a.brand_category_id,
	                a.item_description AS item_description,
	                a.cust_item_code AS customer_sku,
	                br.brand_description AS brand,
	                blt.label AS brand_label,
	                cl.item_class_description AS brand_category,
	                $sellInExpr AS sell_in,
	                a.sell_out,
	                CASE 
	                    WHEN $sellInExpr > 0 
	                    THEN CAST(ROUND((a.sell_out / $sellInExpr) * 100, 2) AS DECIMAL(10,2))
	                    ELSE 0
	                END AS sell_out_ratio,
	                COUNT(*) OVER() AS total_records
	            FROM aggregated a
	            LEFT JOIN outright o
	                ON a.itmcde = o.itmcde
	            LEFT JOIN consignment c
	                ON a.itmcde = c.itmcde 
	            LEFT JOIN tbl_brand br
	                ON a.brand_id = br.id
	            LEFT JOIN tbl_classification cl
	                ON a.brand_category_id = cl.id
	            LEFT JOIN tbl_brand_label_type blt
	                ON br.category_id = blt.id
	        )
	        SELECT 
	            ROW_NUMBER() OVER(ORDER BY sell_out_ratio DESC) AS rank,
	            itmcde,
	            item_description,
	            customer_sku,
	            sell_in,
	            sell_out,
	            sell_out_ratio,
	            brand,
	            brand_label,
	            brand_category,
	            total_records
	        FROM final_data
	        $searchClause
	        ORDER BY {$orderByColumn} {$orderDirection}
	        LIMIT ? OFFSET ?;
	    ";

	    $params = [
	        $yearId, $yearId,
	        $weekStart, $weekStart, $weekEnd,
	        $watsonsPaymentGroup, $watsonsPaymentGroup,
	    ];
	    $params = array_merge($params, $skuParams, $brandParams, $brandCategoryParams, $brandLabelTypeParams);
	    $params = array_merge($params, [
	        // outright
	        //$year, $year,
	        $weekStartDate, $weekStartDate, $weekEndDate,
	        $salesGroup, $salesGroup,
	        $subSalesGroup, $subSalesGroup,
	    ]);
	    $params = array_merge($params, $skuParams, $brandParams, $brandCategoryParams, $brandLabelTypeParams);
	    $params = array_merge($params, [
	        // consignment
	        //$year, $year,
	        $weekStartDate, $weekStartDate, $weekEndDate,
	        $salesGroup, $salesGroup,
	        $subSalesGroup, $subSalesGroup,
	    ]);
	    $params = array_merge($params, $skuParams, $brandParams, $brandCategoryParams, $brandLabelTypeParams);
	    $params = array_merge($params, $searchParams);

	    $params[] = (int)$limit;
	    $params[] = (int)$offset;

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();
	    $totalRecords = $data ? $data[0]->total_records : 0;
		//$finalQuery = $this->interpolateQuery($sql, $params);
		// echo $finalQuery;
		// die();	   
	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}
	
	public function getSellThroughWinsightBySku(
	    $year = null, 
	    $yearId = null, 
	    $weekStart = null, 
	    $weekEnd = null,
		$weekStartDate = null,
		$weekEndDate= null,
	    $searchValue = null,
	    $ItemIds = [],
	    $brandIds = [],
	    $brandTypeIds = [],
	    $brandCategoryIds = [], 
	    $salesGroup = null, 
	    $subSalesGroup = null, 
	    $watsonsPaymentGroup = null, 
	    $orderByColumn = 'rank', 
	    $orderDirection = 'DESC', 
	    $limit = 100, 
	    $offset = 0, 
	    $sellInType = 3,
	    $measure = 'qty'
	) {

	    $allowedOrderColumns = ['rank', 'itmcde', 'customer_sku', 'item_description', 'brand_category', 'brand', 'sell_in', 'sell_out', 'sell_out_ratio'];
	    $allowedOrderDirections = ['ASC', 'DESC'];

	    $searchColumns = [
	        'LOWER(itmcde)',
	        'LOWER(customer_sku)',
	        'LOWER(item_description)',
	        'LOWER(brand)',
	        'LOWER(brand_category)',
	    ];

	    $searchClause = '';
	    $searchParams = [];

	    if (!empty($searchValue)) {
	        $likeConditions = array_map(fn($col) => "$col LIKE ?", $searchColumns);
	        $searchClause = 'WHERE ' . implode(' OR ', $likeConditions);
	        foreach ($searchColumns as $_) {
	            $searchParams[] = '%' . strtolower($searchValue) . '%';
	        }
	    }

	    if (!in_array($orderByColumn, $allowedOrderColumns)) {
	        $orderByColumn = 'sell_out_ratio';
	    }

	    if (!in_array(strtoupper($orderDirection), $allowedOrderDirections)) {
	        $orderDirection = 'DESC';
	    }

	    $skuFilter = '';
	    $skuParams = [];
	    if (!empty($ItemIds)) {
	        $placeholders = implode(',', array_fill(0, count($ItemIds), '?'));
	        $skuFilter = "AND wd.item_code IN ($placeholders)";
	        $skuParams = $ItemIds;
	    }

	    $brandFilter = '';
	    $brandParams = [];
	    if (!empty($brandIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandIds), '?'));
	        $brandFilter = "AND wd.brand_id IN ($placeholders)";
	        $brandParams = $brandIds;
	    }

	    $brandCategoryFilter = '';
	    $brandCategoryParams = [];
	    if (!empty($brandCategoryIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandCategoryIds), '?'));
	        $brandCategoryFilter = "AND wd.category_1_id IN ($placeholders)";
	        $brandCategoryParams = $brandCategoryIds;
	    }

		$brandLabelTypeFilter = '';
	    $brandLabelTypeParams = [];
	    if (!empty($brandTypeIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandTypeIds), '?'));
	        $brandLabelTypeFilter = "AND wd.brand_label_type_id IN ($placeholders)";
	        $brandLabelTypeParams = $brandTypeIds;
	    }	        

	    $skuFilterOutright = $skuFilterConsignment = '';
	    if (!empty($ItemIds)) {
	        $placeholders = implode(',', array_fill(0, count($ItemIds), '?'));
	        $skuFilterOutright = "AND s.itmcde IN ($placeholders)";
	        $skuFilterConsignment = "AND s.itmcde IN ($placeholders)";
	    }

	    $brandFilterOutright = $brandFilterConsignment = '';
	    if (!empty($brandIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandIds), '?'));
	        $brandFilterOutright = "AND s.brand_id IN ($placeholders)";
	        $brandFilterConsignment = "AND s.brand_id IN ($placeholders)";
	    }

	    $brandCategoryFilterOutright = $brandCategoryFilterConsignment = '';
	    if (!empty($brandCategoryIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandCategoryIds), '?'));
	        $brandCategoryFilterOutright = "AND s.brand_category_id IN ($placeholders)";
	        $brandCategoryFilterConsignment = "AND s.brand_category_id IN ($placeholders)";
	    }

	    $brandLabelTypeFilterOutright = $brandLabelTypeFilterConsignment = '';
	    if (!empty($brandTypeIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandTypeIds), '?'));
	        $brandLabelTypeFilterOutright = "AND s.brand_label_type_id IN ($placeholders)";
	        $brandLabelTypeFilterConsignment = "AND s.brand_label_type_id IN ($placeholders)";
	    }

		if ($subSalesGroup) {
		    $sellOutExpr = $measure === 'amount'
		        ? "ROUND(wd.sales_qty * 
		            IF(
		                mp.effectivity_date <= CURRENT_DATE(),
		                IFNULL(cp.net_price, IFNULL(wd.net_price, 0)),
		                IFNULL(hp.net_price, IFNULL(wd.net_price, 0))
		            )
		        , 2)"
		        : "ROUND(wd.sales_qty, 0)";

		    $sellOutExpr2 = $sellOutExpr;
		} else {
		    $sellOutExpr = $measure === 'amount'
		        ? "ROUND(wd.sales_qty * IFNULL(wd.net_price, 0), 2)"
		        : "ROUND(wd.sales_qty, 0)";

		    $sellOutExpr2 = $sellOutExpr;
		}
	    
	    $outrightExpr = $measure === 'amount'
	        ? "ROUND(SUM(s.extprc), 2)"
	        : "ROUND(SUM(s.itmqty * IFNULL(u.conver, 1)), 0)";

	    $consignmentExpr = $measure === 'amount'
	        ? "ROUND(SUM(s.amt), 2)"
	        : "ROUND(SUM(s.itmqty * IFNULL(u.conver, 1)), 0)";

		if ($measure === "amount") {
		    $sellInExpr = ($sellInType == 1 
		        ? "ROUND(IFNULL(o.total_qty, 0), 2)"
		        : ($sellInType == 0
		            ? "ROUND(IFNULL(c.total_qty, 0), 2)"
		            : "ROUND(IFNULL(o.total_qty, 0) + IFNULL(c.total_qty, 0), 2)")
		    );
		} else {
		    $sellInExpr = ($sellInType == 1 
		        ? "ROUND(IFNULL(o.total_qty, 0), 0)"
		        : ($sellInType == 0
		            ? "ROUND(IFNULL(c.total_qty, 0), 0)"
		            : "ROUND(IFNULL(o.total_qty, 0) + IFNULL(c.total_qty, 0), 0)")
		    );
		}

		$sql = "
	        WITH aggregated AS (
			    SELECT
			        sub.item_code AS itmcde,
			        sub.brand_id,
			        sub.item_description,
			        sub.cust_item_code,
			        GROUP_CONCAT(DISTINCT sub.brand_label_type_id) AS brand_type_id,
			        GROUP_CONCAT(DISTINCT sub.category_1_id) AS brand_category_id,
			        SUM(sub.sales_qty) AS sell_out
			    FROM (
				    SELECT
			            wd.item_code,
			            wd.brand_id,
			            wd.brand_label_type_id,
			            mp.item_description,
			            mp.cust_item_code,
			            wd.category_1_id,
			            $sellOutExpr AS sales_qty
			        FROM tbl_winsight_details wd
			        INNER JOIN tbl_main_pricelist mp
			            ON wd.item_code = mp.item_code
			            
			        LEFT JOIN tbl_customer_pricelist cp
			            ON wd.item_code = cp.item_code

			        LEFT JOIN tbl_historical_sub_pricelist hp
			            ON cp.id = hp.customer_id

			        WHERE mp.status = 1
			          AND (? IS NULL OR wd.year = ?)
			          AND (? IS NULL OR wd.week BETWEEN ? AND ?)
			          AND (? IS NULL OR mp.customer_payment_group = ?)
			          $skuFilter
			          $brandFilter
			          $brandCategoryFilter 
			          $brandLabelTypeFilter
			    ) AS sub
			    GROUP BY sub.item_code
			),
	        outright AS (
	            SELECT 
	                s.itmcde,
	                s.brand_id,
	                s.brand_label_type_id,
	                s.brand_category_id,
	                $outrightExpr AS total_qty
	            FROM tbl_item_salesfile2_all s
	            LEFT JOIN (
	                SELECT itmcde, untmea, brand_id, brand_label_type_id, brand_category_id, MAX(conver) AS conver
	                FROM tbl_item_unit_file_all
	                GROUP BY itmcde, untmea
	            ) u 
	              ON s.itmcde = u.itmcde
	             AND s.untmea = u.untmea
	            WHERE s.trncde = 'SAL'
	              AND (s.dettyp <> 'C' OR s.dettyp IS NULL)
	              AND (? IS NULL OR s.trndte BETWEEN ? AND ?)
	              AND (? IS NULL OR s.customer_group = ?)
	              AND (? IS NULL OR s.cuscde = ?)
	              $skuFilterOutright
	              $brandFilterOutright
	              $brandCategoryFilterOutright
	              $brandLabelTypeFilterOutright
	              AND EXISTS (
	                  SELECT 1 
	                  FROM tbl_cus_sellout_indicator ci
	                  WHERE ci.cus_code = s.cuscde
	              )
	            GROUP BY s.itmcde
	        ),
	        consignment AS (
	            SELECT 
	                s.itmcde,
	                s.brand_id,
	                s.brand_label_type_id,
	                s.brand_category_id,
	                $consignmentExpr AS total_qty
	            FROM tbl_item_salesfile_consignment_all s
	            LEFT JOIN (
	                SELECT itmcde, untmea, brand_id, brand_label_type_id, brand_category_id, MAX(conver) AS conver
	                FROM tbl_item_unit_file_all
	                GROUP BY itmcde, untmea
	            ) u 
	              ON s.itmcde = u.itmcde
	              AND s.untmea = u.untmea
	            WHERE (? IS NULL OR s.trndte BETWEEN ? AND ?)
	              AND (? IS NULL OR s.customer_group = ?)
	              AND (? IS NULL OR s.cuscde = ?)
	              $skuFilterConsignment
	              $brandFilterConsignment
	              $brandCategoryFilterConsignment
	              $brandLabelTypeFilterConsignment
	              AND EXISTS (
	                  SELECT 1 
	                  FROM tbl_cus_sellout_indicator ci
	                  WHERE ci.cus_code = s.cuscde
	              )
	            GROUP BY s.itmcde
	        ),
	        final_data AS (
	            SELECT
	                a.itmcde,
	                a.brand_id,
	                a.brand_type_id,
	                a.brand_category_id,
	                a.item_description AS item_description,
	                a.cust_item_code AS customer_sku,
	                br.brand_description AS brand,
	                blt.label AS brand_label,
	                cl.item_class_description AS brand_category,
	                $sellInExpr AS sell_in,
	                a.sell_out,
	                CASE 
	                    WHEN $sellInExpr > 0 
	                    THEN CAST(ROUND((a.sell_out / $sellInExpr) * 100, 2) AS DECIMAL(10,2))
	                    ELSE 0
	                END AS sell_out_ratio,
	                COUNT(*) OVER() AS total_records
	            FROM aggregated a
	            LEFT JOIN outright o
	                ON a.itmcde = o.itmcde
	            LEFT JOIN consignment c
	                ON a.itmcde = c.itmcde 
	            LEFT JOIN tbl_brand br
	                ON a.brand_id = br.id
	            LEFT JOIN tbl_classification cl
	                ON a.brand_category_id = cl.id
	            LEFT JOIN tbl_brand_label_type blt
	                ON br.category_id = blt.id
	        )
	        SELECT 
	            ROW_NUMBER() OVER(ORDER BY sell_out_ratio DESC) AS rank,
	            itmcde,
	            item_description,
	            customer_sku,
	            sell_in,
	            sell_out,
	            sell_out_ratio,
	            brand,
	            brand_label,
	            brand_category,
	            total_records
	        FROM final_data
	        $searchClause
	        ORDER BY {$orderByColumn} {$orderDirection}
	        LIMIT ? OFFSET ?;
	    ";

	    $params = [
	        $year, $year,
	        $weekStart, $weekStart, $weekEnd,
	        $watsonsPaymentGroup, $watsonsPaymentGroup,
	    ];
	    $params = array_merge($params, $skuParams, $brandParams, $brandCategoryParams, $brandLabelTypeParams);
	    $params = array_merge($params, [
	        // outright
	        //$year, $year,
	        $weekStartDate, $weekStartDate, $weekEndDate,
	        $salesGroup, $salesGroup,
	        $subSalesGroup, $subSalesGroup,
	    ]);
	    $params = array_merge($params, $skuParams, $brandParams, $brandCategoryParams, $brandLabelTypeParams);
	    $params = array_merge($params, [
	        // consignment
	        //$year, $year,
	        $weekStartDate, $weekStartDate, $weekEndDate,
	        $salesGroup, $salesGroup,
	        $subSalesGroup, $subSalesGroup,
	    ]);
	    $params = array_merge($params, $skuParams, $brandParams, $brandCategoryParams, $brandLabelTypeParams);
	    $params = array_merge($params, $searchParams);

	    $params[] = (int)$limit;
	    $params[] = (int)$offset;

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();
	    $totalRecords = $data ? $data[0]->total_records : 0;
		//$finalQuery = $this->interpolateQuery($sql, $params);
		//echo $finalQuery; 
		//die();	   
	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

	public function getSellThroughScannDataByBrand(
	    $year = null, 
	    $monthStart = null, 
	    $monthEnd = null, 
	    $searchValue = null,
	    $brandIds = [],
	    $brandTypeIds = [], 
	    $salesGroup = null, 
	    $subSalesGroup = null, 
	    $orderByColumn = 'rank', 
	    $orderDirection = 'DESC', 
	    $limit = 100, 
	    $offset = 0, 
	    $sellInType = 3,
	    $measure = 'qty'
	) {
	    $allowedOrderColumns = ['rank', 'brand', 'sell_in', 'sell_out', 'sell_out_ratio'];
	    $allowedOrderDirections = ['ASC', 'DESC'];

	    $searchColumns = ['LOWER(brand)'];
	    $searchClause = '';
	    $searchParams = [];

	    if (!empty($searchValue)) {
	        $likeConditions = array_map(fn($col) => "$col LIKE ?", $searchColumns);
	        $searchClause = 'WHERE ' . implode(' OR ', $likeConditions);
	        foreach ($searchColumns as $_) {
	            $searchParams[] = '%' . strtolower($searchValue) . '%';
	        }
	    }

	    if (!in_array($orderByColumn, $allowedOrderColumns)) $orderByColumn = 'sell_out_ratio';
	    if (!in_array(strtoupper($orderDirection), $allowedOrderDirections)) $orderDirection = 'DESC';

	    $brandFilter = '';
	    $brandParams = [];
	    if (!empty($brandIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandIds), '?'));
	        $brandFilter = "AND so.brand_id IN ($placeholders)";
	        $brandParams = $brandIds;
	    }

	    $brandLabelTypeFilter = '';
	    $brandLabelTypeParams = [];
	    if (!empty($brandTypeIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandTypeIds), '?'));
	        $brandLabelTypeFilter = "AND so.brand_type_id IN ($placeholders)";
	        $brandLabelTypeParams = $brandTypeIds;
	    }	  

	    $brandFilterOutright = $brandFilterConsignment = '';
	    if (!empty($brandIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandIds), '?'));
	        $brandFilterOutright = "AND s.brand_id IN ($placeholders)";
	        $brandFilterConsignment = "AND s.brand_id IN ($placeholders)";
	    }

	    $brandLabelTypeFilterOutright = $brandLabelTypeFilterConsignment = '';
	    if (!empty($brandTypeIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandTypeIds), '?'));
	        $brandLabelTypeFilterOutright = "AND s.brand_label_type_id IN ($placeholders)";
	        $brandLabelTypeFilterConsignment = "AND s.brand_label_type_id IN ($placeholders)";
	    } 

		if ($subSalesGroup) {
		    $sellOutExpr = $measure === 'amount'
		        ? "ROUND(so.quantity * 
		            IF(
		                mp.effectivity_date <= CURRENT_DATE(),
		                IFNULL(cp.net_price, IFNULL(so.net_price, 0)),
		                IFNULL(hp.net_price, IFNULL(so.net_price, 0))
		            )
		        , 2)"
		        : "ROUND(so.quantity, 0)";

		    $sellOutExpr2 = $sellOutExpr;
		} else {
		    $sellOutExpr = $measure === 'amount'
		        ? "ROUND(so.quantity * IFNULL(so.net_price, 0), 2)"
		        : "ROUND(so.quantity, 0)";

		    $sellOutExpr2 = $sellOutExpr;
		}
	    
	    $outrightExpr = $measure === 'amount'
	        ? "ROUND(SUM(s.extprc), 2)"
	        : "ROUND(SUM(s.itmqty * IFNULL(u.conver, 1)), 0)";

	    $consignmentExpr = $measure === 'amount'
	        ? "ROUND(SUM(s.amt), 2)"
	        : "ROUND(SUM(s.itmqty * IFNULL(u.conver, 1)), 0)";

		if ($measure === "amount") {
		    $sellInExpr = ($sellInType == 1 
		        ? "ROUND(IFNULL(o.total_qty, 0), 2)"
		        : ($sellInType == 0
		            ? "ROUND(IFNULL(c.total_qty, 0), 2)"
		            : "ROUND(IFNULL(o.total_qty, 0) + IFNULL(c.total_qty, 0), 2)")
		    );
		} else {
		    $sellInExpr = ($sellInType == 1 
		        ? "ROUND(IFNULL(o.total_qty, 0), 0)"
		        : ($sellInType == 0
		            ? "ROUND(IFNULL(c.total_qty, 0), 0)"
		            : "ROUND(IFNULL(o.total_qty, 0) + IFNULL(c.total_qty, 0), 0)")
		    );
		}

	    $sql = "
	        WITH aggregated AS (
			    SELECT
			        sub.brand_id,
			        sub.customer_payment_group,
			        GROUP_CONCAT(DISTINCT sub.brand_type_id) AS brand_type_id,
			        GROUP_CONCAT(DISTINCT sub.item_class_id) AS brand_category_id,
			        SUM(sub.quantity) AS sell_out
			    FROM (
			        SELECT
		                so.brand_id,
		                so.customer_payment_group,
		                so.brand_type_id,
		                so.item_class_id,
			            $sellOutExpr AS quantity
		            FROM tbl_sell_out_pre_aggregated_data so
		            INNER JOIN (SELECT DISTINCT brand_id, customer_payment_group FROM tbl_main_pricelist WHERE status = 1) mp
			            ON so.brand_id = mp.brand_id

			        LEFT JOIN (SELECT DISTINCT brand_id, id FROM tbl_customer_pricelist) cp
			            ON so.brand_id = cp.brand_id

			        LEFT JOIN (SELECT DISTINCT customer_id FROM tbl_historical_sub_pricelist) hp
		            ON cp.id = hp.customer_id

	            	WHERE (? IS NULL OR so.year = ?)
		              AND (? IS NULL OR so.month BETWEEN ? AND ?)
		              $brandFilter
		              $brandLabelTypeFilter
		              AND (? IS NULL OR (so.customer_payment_group = ? AND mp.customer_payment_group = ?))
			    ) AS sub
			    GROUP BY sub.brand_id
			),
	        outright AS (
	            SELECT 
	                s.brand_id,
	                s.brand_label_type_id,
	                s.brand_category_id,
	                s.cusdsc,
	                $outrightExpr AS total_qty
	            FROM tbl_item_salesfile2_all s
	            LEFT JOIN (
	                SELECT untmea, brand_id, brand_label_type_id, brand_category_id, MAX(conver) AS conver
	                FROM tbl_item_unit_file_all
	                GROUP BY brand_id, untmea
	            ) u 
	              ON s.brand_id = u.brand_id
	             AND s.untmea = u.untmea
	            WHERE s.trncde = 'SAL'
	              AND (s.dettyp <> 'C' OR s.dettyp IS NULL)
	              AND (? IS NULL OR YEAR(s.trndte) = ?)
	              AND (? IS NULL OR MONTH(s.trndte) BETWEEN ? AND ?)
	              AND (? IS NULL OR s.customer_group = ?)
	              AND (? IS NULL OR s.cuscde = ?)
	              $brandFilterOutright
	              $brandLabelTypeFilterOutright
	              AND EXISTS (
	                  SELECT 1 FROM tbl_cus_sellout_indicator ci WHERE ci.cus_code = s.cuscde
	              )
	            GROUP BY s.brand_id
	        ),
	        consignment AS (
	            SELECT 
	                s.brand_id,
	                s.brand_label_type_id,
	                s.brand_category_id,
	                s.cusdsc,
	                $consignmentExpr AS total_qty
	            FROM tbl_item_salesfile_consignment_all s
	            LEFT JOIN (
	                SELECT untmea, brand_id, brand_label_type_id, brand_category_id, MAX(conver) AS conver
	                FROM tbl_item_unit_file_all
	                GROUP BY brand_id, untmea
	            ) u 
	              ON s.brand_id = u.brand_id
	             AND s.untmea = u.untmea

	            WHERE (? IS NULL OR YEAR(s.trndte) = ?)
	              AND (? IS NULL OR MONTH(s.trndte) BETWEEN ? AND ?)
	              AND (? IS NULL OR s.customer_group = ?)
	              AND (? IS NULL OR s.cuscde = ?)
	              $brandFilterConsignment
	              $brandLabelTypeFilterConsignment
	              AND EXISTS (
	                  SELECT 1 FROM tbl_cus_sellout_indicator ci WHERE ci.cus_code = s.cuscde
	              )
	            GROUP BY s.brand_id
	        ),
	        final_data AS (
	            SELECT
	                a.customer_payment_group,
	                a.brand_id,
	                a.brand_type_id,
	                a.brand_category_id,
	                br.brand_description AS brand,
	                blt.label AS brand_label,
	                cl.item_class_description AS brand_category,
	                $sellInExpr AS sell_in,
	                a.sell_out,
	                CASE 
	                    WHEN $sellInExpr > 0 
	                    THEN CAST(ROUND((a.sell_out / $sellInExpr) * 100, 2) AS DECIMAL(10,2))
	                    ELSE 0
	                END AS sell_out_ratio,
	                COUNT(*) OVER() AS total_records
	            FROM aggregated a
	            LEFT JOIN outright o
	                ON a.brand_id = o.brand_id 
	            LEFT JOIN consignment c
	                ON a.brand_id = c.brand_id 
	            LEFT JOIN tbl_brand br
	                ON a.brand_id = br.id
	            LEFT JOIN tbl_classification cl
	                ON a.brand_category_id = cl.id
	            LEFT JOIN tbl_brand_label_type blt
	                ON br.category_id = blt.id
	        )
	        SELECT 
	            ROW_NUMBER() OVER(ORDER BY sell_out_ratio DESC) AS rank,
	            brand_id,
	            customer_payment_group,
	            brand,
	            brand_label,
	            brand_category,
	            sell_in,
	            sell_out,
	            sell_out_ratio,
	            total_records
	        FROM final_data
	        $searchClause
	        ORDER BY {$orderByColumn} {$orderDirection}
	        LIMIT ? OFFSET ?;
	    ";

	    $params = [
	        $year, $year,
	        $monthStart, $monthStart, $monthEnd,
	    ];
	    $params = array_merge($params, $brandParams, $brandLabelTypeParams);
	    $params = array_merge($params, [
	        $salesGroup, $salesGroup, $salesGroup,
	        // outright
	        $year, $year,
	        $monthStart, $monthStart, $monthEnd,
	        $salesGroup, $salesGroup,
	        $subSalesGroup, $subSalesGroup,
	    ]);
	    $params = array_merge($params, $brandParams, $brandLabelTypeParams);
	    $params = array_merge($params, [
	        // consignment
	        $year, $year,
	        $monthStart, $monthStart, $monthEnd,
	        $salesGroup, $salesGroup,
	        $subSalesGroup, $subSalesGroup,
	    ]);
	    $params = array_merge($params, $brandParams, $brandLabelTypeParams);
	    $params = array_merge($params, $searchParams);
	    $params[] = (int)$limit;
	    $params[] = (int)$offset;

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();
	    $totalRecords = $data ? $data[0]->total_records : 0;

	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

	public function getSellThroughWeekOnWeekByBrand(
	    $year = null, 
	    $yearId = null, 
	    $weekStart = null, 
	    $weekEnd = null,
		$weekStartDate = null,
		$weekEndDate= null,
	    $searchValue = null,
	    $brandIds = [],
	    $brandTypeIds = [],
	    $salesGroup = null, 
	    $subSalesGroup = null,
	    $watsonsPaymentGroup = null,
	    $orderByColumn = 'rank', 
	    $orderDirection = 'DESC', 
	    $limit = 100, 
	    $offset = 0, 
	    $sellInType = 3,
	    $measure = 'qty'
	) {
	    $allowedOrderColumns = ['rank', 'brand', 'sell_in', 'sell_out', 'sell_out_ratio'];
	    $allowedOrderDirections = ['ASC', 'DESC'];

	    $searchColumns = ['LOWER(brand)'];
	    $searchClause = '';
	    $searchParams = [];

	    if (!empty($searchValue)) {
	        $likeConditions = array_map(fn($col) => "$col LIKE ?", $searchColumns);
	        $searchClause = 'WHERE ' . implode(' OR ', $likeConditions);
	        foreach ($searchColumns as $_) {
	            $searchParams[] = '%' . strtolower($searchValue) . '%';
	        }
	    }

	    if (!in_array($orderByColumn, $allowedOrderColumns)) $orderByColumn = 'sell_out_ratio';
	    if (!in_array(strtoupper($orderDirection), $allowedOrderDirections)) $orderDirection = 'DESC';

	    $brandFilter = '';
	    $brandParams = [];
	    if (!empty($brandIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandIds), '?'));
	        $brandFilter = "AND wow.tracc_brand_id IN ($placeholders)";
	        $brandParams = $brandIds;
	    }

	    $brandLabelTypeFilter = '';
	    $brandLabelTypeParams = [];
	    if (!empty($brandTypeIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandTypeIds), '?'));
	        $brandLabelTypeFilter = "AND wow.brand_type_id IN ($placeholders)";
	        $brandLabelTypeParams = $brandTypeIds;
	    }	    

	    $brandFilterOutright = $brandFilterConsignment = '';
	    if (!empty($brandIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandIds), '?'));
	        $brandFilterOutright = "AND s.brand_id IN ($placeholders)";
	        $brandFilterConsignment = "AND s.brand_id IN ($placeholders)";
	    }

	    $brandLabelTypeFilterOutright = $brandLabelTypeFilterConsignment = '';
	    if (!empty($brandTypeIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandTypeIds), '?'));
	        $brandLabelTypeFilterOutright = "AND s.brand_label_type_id IN ($placeholders)";
	        $brandLabelTypeFilterConsignment = "AND s.brand_label_type_id IN ($placeholders)";
	    }

		if ($subSalesGroup) {
		    $sellOutExpr = $measure === 'amount'
		        ? "ROUND(wow.quantity * 
		            IF(
		                mp.effectivity_date <= CURRENT_DATE(),
		                IFNULL(cp.net_price, IFNULL(wow.net_price, 0)),
		                IFNULL(hp.net_price, IFNULL(wow.net_price, 0))
		            )
		        , 2)"
		        : "ROUND(wow.quantity, 0)";

		    $sellOutExpr2 = $sellOutExpr;
		} else {
		    $sellOutExpr = $measure === 'amount'
		        ? "ROUND(wow.quantity * IFNULL(wow.net_price, 0), 2)"
		        : "ROUND(wow.quantity, 0)";

		    $sellOutExpr2 = $sellOutExpr;
		}
	    
	    $outrightExpr = $measure === 'amount'
	        ? "ROUND(SUM(s.extprc), 2)"
	        : "ROUND(SUM(s.itmqty * IFNULL(u.conver, 1)), 0)";

	    $consignmentExpr = $measure === 'amount'
	        ? "ROUND(SUM(s.amt), 2)"
	        : "ROUND(SUM(s.itmqty * IFNULL(u.conver, 1)), 0)";

		if ($measure === "amount") {
		    $sellInExpr = ($sellInType == 1 
		        ? "ROUND(IFNULL(o.total_qty, 0), 2)"
		        : ($sellInType == 0
		            ? "ROUND(IFNULL(c.total_qty, 0), 2)"
		            : "ROUND(IFNULL(o.total_qty, 0) + IFNULL(c.total_qty, 0), 2)")
		    );
		} else {
		    $sellInExpr = ($sellInType == 1 
		        ? "ROUND(IFNULL(o.total_qty, 0), 0)"
		        : ($sellInType == 0
		            ? "ROUND(IFNULL(c.total_qty, 0), 0)"
		            : "ROUND(IFNULL(o.total_qty, 0) + IFNULL(c.total_qty, 0), 0)")
		    );
		}

	    $sql = "
	        WITH aggregated AS (
			    SELECT
			        sub.tracc_brand_id AS brand_id,
			        GROUP_CONCAT(DISTINCT sub.brand_type_id) AS brand_type_id,
			        GROUP_CONCAT(DISTINCT sub.item_class_id) AS brand_category_id,
			        SUM(sub.quantity) AS sell_out
			    FROM (
		            SELECT
		                wow.tracc_brand_id,
		                wow.brand_type_id,
		                wow.item_class_id,
			            $sellOutExpr AS quantity
		            FROM tbl_week_on_week_vmi_pre_aggregated_data wow
		            INNER JOIN (SELECT DISTINCT brand_id, customer_payment_group FROM tbl_main_pricelist WHERE status = 1) mp
			            ON wow.tracc_brand_id = mp.brand_id

			        LEFT JOIN (SELECT DISTINCT brand_id, id FROM tbl_customer_pricelist) cp
			            ON wow.tracc_brand_id = cp.brand_id

			        LEFT JOIN (SELECT DISTINCT customer_id FROM tbl_historical_sub_pricelist) hp
			            ON cp.id = hp.customer_id
			        WHERE (? IS NULL OR wow.year = ?)
			          AND (? IS NULL OR wow.week BETWEEN ? AND ?)
			          $brandFilter
			          $brandLabelTypeFilter
			          AND (? IS NULL OR mp.customer_payment_group = ?)
			    ) AS sub
	            GROUP BY sub.tracc_brand_id
	        ),
	        outright AS (
	            SELECT 
	                s.brand_id,
	                s.brand_label_type_id,
	                s.brand_category_id,
	                s.cusdsc,
	                $outrightExpr AS total_qty
	            FROM tbl_item_salesfile2_all s
	            LEFT JOIN (
	                SELECT untmea, brand_id, brand_label_type_id, brand_category_id, MAX(conver) AS conver
	                FROM tbl_item_unit_file_all
	                GROUP BY brand_id, untmea
	            ) u 
	              ON s.brand_id = u.brand_id
	             AND s.untmea = u.untmea
	            WHERE s.trncde = 'SAL'
	              AND (s.dettyp <> 'C' OR s.dettyp IS NULL)
	              AND (? IS NULL OR s.trndte BETWEEN ? AND ?)
	              AND (? IS NULL OR s.customer_group = ?)
	              AND (? IS NULL OR s.cuscde = ?)
	              $brandFilterOutright
	              $brandLabelTypeFilterOutright
	              AND EXISTS (
	                  SELECT 1 FROM tbl_cus_sellout_indicator ci WHERE ci.cus_code = s.cuscde
	              )
	            GROUP BY s.brand_id
	        ),
	        consignment AS (
	            SELECT 
	                s.brand_id,
	                s.brand_label_type_id,
	                s.brand_category_id,
	                s.cusdsc,
	                $consignmentExpr AS total_qty
	            FROM tbl_item_salesfile_consignment_all s
	            LEFT JOIN (
	                SELECT untmea, brand_id, brand_label_type_id, brand_category_id, MAX(conver) AS conver
	                FROM tbl_item_unit_file_all
	                GROUP BY brand_id, untmea
	            ) u 
	              ON s.brand_id = u.brand_id
	             AND s.untmea = u.untmea

	            WHERE (? IS NULL OR s.trndte BETWEEN ? AND ?)
	              AND (? IS NULL OR s.customer_group = ?)
	              AND (? IS NULL OR s.cuscde = ?)
	              $brandFilterConsignment
	              $brandLabelTypeFilterConsignment
	              AND EXISTS (
	                  SELECT 1 FROM tbl_cus_sellout_indicator ci WHERE ci.cus_code = s.cuscde
	              )
	            GROUP BY s.brand_id
	        ),
	        final_data AS (
	            SELECT
	                a.brand_id,
	                a.brand_type_id,
	                a.brand_category_id,
	                br.brand_description AS brand,
	                blt.label AS brand_label,
	                cl.item_class_description AS brand_category,
	                $sellInExpr AS sell_in,
	                a.sell_out,
	                CASE 
	                    WHEN $sellInExpr > 0 
	                    THEN CAST(ROUND((a.sell_out / $sellInExpr) * 100, 2) AS DECIMAL(10,2))
	                    ELSE 0
	                END AS sell_out_ratio,
	                COUNT(*) OVER() AS total_records
	            FROM aggregated a
	            LEFT JOIN outright o
	                ON a.brand_id = o.brand_id 
	            LEFT JOIN consignment c
	                ON a.brand_id = c.brand_id 
	            LEFT JOIN tbl_brand br
	                ON a.brand_id = br.id
	            LEFT JOIN tbl_classification cl
	                ON a.brand_category_id = cl.id
	            LEFT JOIN tbl_brand_label_type blt
	                ON br.category_id = blt.id
	        )
	        SELECT 
	            ROW_NUMBER() OVER(ORDER BY sell_out_ratio DESC) AS rank,
	            brand_id,
	            brand,
	            brand_label,
	            brand_category,
	            sell_in,
	            sell_out,
	            sell_out_ratio,
	            total_records
	        FROM final_data
	        $searchClause
	        ORDER BY {$orderByColumn} {$orderDirection}
	        LIMIT ? OFFSET ?;
	    ";

	    $params = [
	        $yearId, $yearId,
	        $weekStart, $weekStart, $weekEnd,
	    ];
	    $params = array_merge($params, $brandParams, $brandLabelTypeParams);
	    $params = array_merge($params, [
	        $watsonsPaymentGroup, $watsonsPaymentGroup,
	        // outright
	        //$year, $year,
	        $weekStartDate, $weekStartDate, $weekEndDate,
	        $salesGroup, $salesGroup,
	        $subSalesGroup, $subSalesGroup,
	    ]);
	    $params = array_merge($params, $brandParams, $brandLabelTypeParams);
	    $params = array_merge($params, [
	        // consignment
	        //$year, $year,
	        $weekStartDate, $weekStartDate, $weekEndDate,
	        $salesGroup, $salesGroup,
	        $subSalesGroup, $subSalesGroup,
	    ]);
	    $params = array_merge($params, $brandParams, $brandLabelTypeParams);
	    $params = array_merge($params, $searchParams);
	    $params[] = (int)$limit;
	    $params[] = (int)$offset;

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();
	    $totalRecords = $data ? $data[0]->total_records : 0;

	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

	public function getSellThroughWinsightByBrand(
	    $year = null, 
	    $yearId = null, 
	    $weekStart = null, 
	    $weekEnd = null,
		$weekStartDate = null,
		$weekEndDate= null,
	    $searchValue = null,
	    $brandIds = [],
	    $brandTypeIds = [],
	    $salesGroup = null, 
	    $subSalesGroup = null, 
	    $watsonsPaymentGroup = null,
	    $orderByColumn = 'rank', 
	    $orderDirection = 'DESC', 
	    $limit = 100, 
	    $offset = 0, 
	    $sellInType = 3,
	    $measure = 'qty'
	) {
	    $allowedOrderColumns = ['rank', 'brand', 'sell_in', 'sell_out', 'sell_out_ratio'];
	    $allowedOrderDirections = ['ASC', 'DESC'];

	    $searchColumns = ['LOWER(brand)'];
	    $searchClause = '';
	    $searchParams = [];

	    if (!empty($searchValue)) {
	        $likeConditions = array_map(fn($col) => "$col LIKE ?", $searchColumns);
	        $searchClause = 'WHERE ' . implode(' OR ', $likeConditions);
	        foreach ($searchColumns as $_) {
	            $searchParams[] = '%' . strtolower($searchValue) . '%';
	        }
	    }

	    if (!in_array($orderByColumn, $allowedOrderColumns)) $orderByColumn = 'sell_out_ratio';
	    if (!in_array(strtoupper($orderDirection), $allowedOrderDirections)) $orderDirection = 'DESC';

	    $brandFilter = '';
	    $brandParams = [];
	    if (!empty($brandIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandIds), '?'));
	        $brandFilter = "AND wd.brand_id IN ($placeholders)";
	        $brandParams = $brandIds;
	    }

	    $brandLabelTypeFilter = '';
	    $brandLabelTypeParams = [];
	    if (!empty($brandTypeIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandTypeIds), '?'));
	        $brandLabelTypeFilter = "AND wd.brand_label_type_id IN ($placeholders)";
	        $brandLabelTypeParams = $brandTypeIds;
	    }	    

	    $brandFilterOutright = $brandFilterConsignment = '';
	    if (!empty($brandIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandIds), '?'));
	        $brandFilterOutright = "AND s.brand_id IN ($placeholders)";
	        $brandFilterConsignment = "AND s.brand_id IN ($placeholders)";
	    }

	    $brandLabelTypeFilterOutright = $brandLabelTypeFilterConsignment = '';
	    if (!empty($brandTypeIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandTypeIds), '?'));
	        $brandLabelTypeFilterOutright = "AND s.brand_label_type_id IN ($placeholders)";
	        $brandLabelTypeFilterConsignment = "AND s.brand_label_type_id IN ($placeholders)";
	    }

		if ($subSalesGroup) {
		    $sellOutExpr = $measure === 'amount'
		        ? "ROUND(wd.sales_qty * 
		            IF(
		                mp.effectivity_date <= CURRENT_DATE(),
		                IFNULL(cp.net_price, IFNULL(wd.net_price, 0)),
		                IFNULL(hp.net_price, IFNULL(wd.net_price, 0))
		            )
		        , 2)"
		        : "ROUND(wd.sales_qty, 0)";

		    $sellOutExpr2 = $sellOutExpr;
		} else {
		    $sellOutExpr = $measure === 'amount'
		        ? "ROUND(wd.sales_qty * IFNULL(wd.net_price, 0), 2)"
		        : "wd.sales_qty";

		    $sellOutExpr2 = $sellOutExpr;
		}
	    
	    $outrightExpr = $measure === 'amount'
	        ? "ROUND(SUM(s.extprc), 2)"
	        : "ROUND(SUM(s.itmqty * IFNULL(u.conver, 1)), 0)";

	    $consignmentExpr = $measure === 'amount'
	        ? "ROUND(SUM(s.amt), 2)"
	        : "ROUND(SUM(s.itmqty * IFNULL(u.conver, 1)), 0)";

		if ($measure === "amount") {
		    $sellInExpr = ($sellInType == 1 
		        ? "ROUND(IFNULL(o.total_qty, 0), 2)"
		        : ($sellInType == 0
		            ? "ROUND(IFNULL(c.total_qty, 0), 2)"
		            : "ROUND(IFNULL(o.total_qty, 0) + IFNULL(c.total_qty, 0), 2)")
		    );
		} else {
		    $sellInExpr = ($sellInType == 1 
		        ? "ROUND(IFNULL(o.total_qty, 0), 0)"
		        : ($sellInType == 0
		            ? "ROUND(IFNULL(c.total_qty, 0), 0)"
		            : "ROUND(IFNULL(o.total_qty, 0) + IFNULL(c.total_qty, 0), 0)")
		    );
		}

	    $sql = "
	        WITH aggregated AS (
			    SELECT
			        sub.brand_id,
			        GROUP_CONCAT(DISTINCT sub.brand_label_type_id) AS brand_type_id,
			        GROUP_CONCAT(DISTINCT sub.category_1_id) AS brand_category_id,
			        SUM(sub.sales_qty) AS sell_out
			    FROM (
			        SELECT
			            wd.brand_id,
			            wd.brand_label_type_id,
			            wd.category_1_id,
			            $sellOutExpr AS sales_qty
			        FROM tbl_winsight_details wd
			        INNER JOIN (SELECT DISTINCT brand_id, customer_payment_group FROM tbl_main_pricelist WHERE status = 1) mp
			            ON wd.brand_id = mp.brand_id
			        LEFT JOIN (SELECT DISTINCT brand_id, id FROM tbl_customer_pricelist) cp
			            ON wd.brand_id = cp.brand_id
			        LEFT JOIN (SELECT DISTINCT customer_id FROM tbl_historical_sub_pricelist) hp
			            ON cp.id = hp.customer_id
			        WHERE (? IS NULL OR wd.year = ?)
			          AND (? IS NULL OR wd.week BETWEEN ? AND ?)
			          $brandFilter
			          $brandLabelTypeFilter
			          AND (? IS NULL OR mp.customer_payment_group = ?)
			    ) AS sub
			    GROUP BY sub.brand_id
			),
	        outright AS (
	            SELECT 
	                s.brand_id,
	                s.brand_label_type_id,
	                s.brand_category_id,
	                s.cusdsc,
	                $outrightExpr AS total_qty
	            FROM tbl_item_salesfile2_all s
	            LEFT JOIN (
	                SELECT untmea, brand_id, brand_label_type_id, brand_category_id, MAX(conver) AS conver
	                FROM tbl_item_unit_file_all
	                GROUP BY brand_id, untmea
	            ) u 
	              ON s.brand_id = u.brand_id
	             AND s.untmea = u.untmea
	            WHERE s.trncde = 'SAL'
	              AND (s.dettyp <> 'C' OR s.dettyp IS NULL)
	              AND (? IS NULL OR s.trndte BETWEEN ? AND ?)
	              AND (? IS NULL OR s.customer_group = ?)
	              AND (? IS NULL OR s.cuscde = ?)
	              $brandFilterOutright
	              $brandLabelTypeFilterOutright
	              AND EXISTS (
	                  SELECT 1 FROM tbl_cus_sellout_indicator ci WHERE ci.cus_code = s.cuscde
	              )
	            GROUP BY s.brand_id
	        ),
	        consignment AS (
	            SELECT 
	                s.brand_id,
	                s.brand_label_type_id,
	                s.brand_category_id,
	                s.cusdsc,
	                $consignmentExpr AS total_qty
	            FROM tbl_item_salesfile_consignment_all s
	            LEFT JOIN (
	                SELECT untmea, brand_id, brand_label_type_id, brand_category_id, MAX(conver) AS conver
	                FROM tbl_item_unit_file_all
	                GROUP BY brand_id, untmea
	            ) u 
	              ON s.brand_id = u.brand_id
	             AND s.untmea = u.untmea

	            WHERE (? IS NULL OR s.trndte BETWEEN ? AND ?)
	              AND (? IS NULL OR s.customer_group = ?)
	              AND (? IS NULL OR s.cuscde = ?)
	              $brandFilterConsignment
	              $brandLabelTypeFilterConsignment
	              AND EXISTS (
	                  SELECT 1 FROM tbl_cus_sellout_indicator ci WHERE ci.cus_code = s.cuscde
	              )
	            GROUP BY s.brand_id
	        ),
	        final_data AS (
	            SELECT
	                a.brand_id,
	                a.brand_type_id,
	                a.brand_category_id,
	                br.brand_description AS brand,
	                blt.label AS brand_label,
	                cl.item_class_description AS brand_category,
	                $sellInExpr AS sell_in,
	                a.sell_out,
	                CASE 
	                    WHEN $sellInExpr > 0 
	                    THEN CAST(ROUND((a.sell_out / $sellInExpr) * 100, 2) AS DECIMAL(10,2))
	                    ELSE 0
	                END AS sell_out_ratio,
	                COUNT(*) OVER() AS total_records
	            FROM aggregated a
	            LEFT JOIN outright o
	                ON a.brand_id = o.brand_id 
	            LEFT JOIN consignment c
	                ON a.brand_id = c.brand_id 
	            LEFT JOIN tbl_brand br
	                ON a.brand_id = br.id
	            LEFT JOIN tbl_classification cl
	                ON a.brand_category_id = cl.id
	            LEFT JOIN tbl_brand_label_type blt
	                ON br.category_id = blt.id
	        )
	        SELECT 
	            ROW_NUMBER() OVER(ORDER BY sell_out_ratio DESC) AS rank,
	            brand_id,
	            brand,
	            brand_label,
	            brand_category,
	            sell_in,
	            sell_out,
	            sell_out_ratio,
	            total_records
	        FROM final_data
	        $searchClause
	        ORDER BY {$orderByColumn} {$orderDirection}
	        LIMIT ? OFFSET ?;
	    ";

	    $params = [
	        $year, $year,
	        $weekStart, $weekStart, $weekEnd,
	    ];
	    $params = array_merge($params, $brandParams, $brandLabelTypeParams);
	    $params = array_merge($params, [
	        $watsonsPaymentGroup, $watsonsPaymentGroup,
	        // outright
	        //$year, $year,
	        $weekStartDate, $weekStartDate, $weekEndDate,
	        $salesGroup, $salesGroup,
	        $subSalesGroup, $subSalesGroup,
	    ]);
	    $params = array_merge($params, $brandParams, $brandLabelTypeParams);
	    $params = array_merge($params, [
	        // consignment
	        //$year, $year,
	        $weekStartDate, $weekStartDate, $weekEndDate,
	        $salesGroup, $salesGroup,
	        $subSalesGroup, $subSalesGroup,
	    ]);
	    $params = array_merge($params, $brandParams, $brandLabelTypeParams);
	    $params = array_merge($params, $searchParams);
	    $params[] = (int)$limit;
	    $params[] = (int)$offset;

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();
	    $totalRecords = $data ? $data[0]->total_records : 0;

	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

	public function getSellThroughScannDataBrandLabel(
	    $year = null, 
	    $monthStart = null, 
	    $monthEnd = null, 
	    $searchValue = null,
	    $brandTypeIds = [],
	    $salesGroup = null, 
	    $subSalesGroup = null, 
	    $orderByColumn = 'rank', 
	    $orderDirection = 'DESC', 
	    $limit = 100, 
	    $offset = 0, 
	    $sellInType = 3,
	    $measure = 'qty'
	) {
	    $allowedOrderColumns = ['rank', 'brand_type', 'sell_in', 'sell_out', 'sell_out_ratio'];
	    $allowedOrderDirections = ['ASC', 'DESC'];

	    $searchColumns = ['LOWER(brand_type)'];
	    $searchClause = '';
	    $searchParams = [];

	    if (!empty($searchValue)) {
	        $likeConditions = array_map(fn($col) => "$col LIKE ?", $searchColumns);
	        $searchClause = 'WHERE ' . implode(' OR ', $likeConditions);
	        foreach ($searchColumns as $_) {
	            $searchParams[] = '%' . strtolower($searchValue) . '%';
	        }
	    }

	    if (!in_array($orderByColumn, $allowedOrderColumns)) $orderByColumn = 'sell_out_ratio';
	    if (!in_array(strtoupper($orderDirection), $allowedOrderDirections)) $orderDirection = 'DESC';

	    $brandTypeFilter = '';
	    $brandTypeParams = [];
	    if (!empty($brandTypeIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandTypeIds), '?'));
	        $brandTypeFilter = "AND so.brand_type_id IN ($placeholders)";
	        $brandTypeParams = $brandTypeIds;
	    }

	    $brandTypeFilterOutright = $brandTypeFilterConsignment = '';
	    if (!empty($brandTypeIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandTypeIds), '?'));
	        $brandTypeFilterOutright = "AND s.brand_label_type_id IN ($placeholders)";
	        $brandTypeFilterConsignment = "AND s.brand_label_type_id IN ($placeholders)";
	    }

		if ($subSalesGroup) {
		    $sellOutExpr = $measure === 'amount'
		        ? "ROUND(so.quantity * 
		            IF(
		                mp.effectivity_date <= CURRENT_DATE(),
		                IFNULL(cp.net_price, IFNULL(so.net_price, 0)),
		                IFNULL(hp.net_price, IFNULL(so.net_price, 0))
		            )
		        , 2)"
		        : "ROUND(so.quantity, 0)";

		    $sellOutExpr2 = $sellOutExpr;
		} else {
		    $sellOutExpr = $measure === 'amount'
		        ? "ROUND(so.quantity * IFNULL(so.net_price, 0), 2)"
		        : "ROUND(so.quantity, 0)";

		    $sellOutExpr2 = $sellOutExpr;
		}
	    
	    $outrightExpr = $measure === 'amount'
	        ? "ROUND(SUM(s.extprc), 2)"
	        : "ROUND(SUM(s.itmqty * IFNULL(u.conver, 1)), 0)";

	    $consignmentExpr = $measure === 'amount'
	        ? "ROUND(SUM(s.amt), 2)"
	        : "ROUND(SUM(s.itmqty * IFNULL(u.conver, 1)), 0)";

		if ($measure === "amount") {
		    $sellInExpr = ($sellInType == 1 
		        ? "ROUND(IFNULL(o.total_qty, 0), 2)"
		        : ($sellInType == 0
		            ? "ROUND(IFNULL(c.total_qty, 0), 2)"
		            : "ROUND(IFNULL(o.total_qty, 0) + IFNULL(c.total_qty, 0), 2)")
		    );
		} else {
		    $sellInExpr = ($sellInType == 1 
		        ? "ROUND(IFNULL(o.total_qty, 0), 0)"
		        : ($sellInType == 0
		            ? "ROUND(IFNULL(c.total_qty, 0), 0)"
		            : "ROUND(IFNULL(o.total_qty, 0) + IFNULL(c.total_qty, 0), 0)")
		    );
		}

	    $sql = "
	        WITH aggregated AS (
			    SELECT
			        sub.customer_payment_group,
			        GROUP_CONCAT(DISTINCT sub.brand_type_id) AS brand_type_id,
			        GROUP_CONCAT(DISTINCT sub.item_class_id) AS brand_category_id,
			        SUM(sub.quantity) AS sell_out
			    FROM (
			        SELECT
		                so.brand_type_id,
		                so.customer_payment_group,
		                so.item_class_id,
			            $sellOutExpr AS quantity
		            FROM tbl_sell_out_pre_aggregated_data so
		            INNER JOIN (SELECT DISTINCT brand_label_type_id, customer_payment_group FROM tbl_main_pricelist WHERE status = 1) mp
			            ON so.brand_type_id = mp.brand_label_type_id
			            AND so.customer_payment_group = mp.customer_payment_group

			        LEFT JOIN (SELECT DISTINCT brand_label_type_id, id, customer_payment_group FROM tbl_customer_pricelist) cp
						ON so.brand_type_id = cp.brand_label_type_id
			           AND so.customer_payment_group = cp.customer_payment_group

			        LEFT JOIN (SELECT DISTINCT customer_id FROM tbl_historical_sub_pricelist) hp
			            ON cp.id = hp.customer_id

		            WHERE (? IS NULL OR so.year = ?)
		              AND (? IS NULL OR so.month BETWEEN ? AND ?)
		              $brandTypeFilter
		              AND (? IS NULL OR (so.customer_payment_group = ? AND mp.customer_payment_group = ?))
			    ) AS sub
			    GROUP BY sub.brand_type_id
			),
	        outright AS (
	            SELECT 
	                s.brand_label_type_id AS brand_type_id,
	                s.brand_category_id,
	                $outrightExpr AS total_qty
	            FROM tbl_item_salesfile2_all s
	            LEFT JOIN (
	                SELECT untmea, brand_label_type_id, brand_category_id, MAX(conver) AS conver
	                FROM tbl_item_unit_file_all
	                GROUP BY brand_label_type_id, untmea
	            ) u 
	              ON s.brand_label_type_id = u.brand_label_type_id 
	             AND s.untmea = u.untmea
	            WHERE s.trncde = 'SAL'
	              AND (s.dettyp <> 'C' OR s.dettyp IS NULL)
	              AND (? IS NULL OR YEAR(s.trndte) = ?)
	              AND (? IS NULL OR MONTH(s.trndte) BETWEEN ? AND ?)
	              AND (? IS NULL OR s.customer_group = ?)
	              AND (? IS NULL OR s.cuscde = ?)
	              $brandTypeFilterOutright
	              AND EXISTS (SELECT 1 FROM tbl_cus_sellout_indicator ci WHERE ci.cus_code = s.cuscde)
	            GROUP BY s.brand_label_type_id
	        ),
	        consignment AS (
	            SELECT 
	                s.brand_label_type_id AS brand_type_id,
	                s.brand_category_id,
	                $consignmentExpr AS total_qty
	            FROM tbl_item_salesfile_consignment_all s
	            LEFT JOIN (
	                SELECT untmea, brand_label_type_id, brand_category_id, MAX(conver) AS conver
	                FROM tbl_item_unit_file_all
	                GROUP BY brand_label_type_id, untmea
	            ) u 
	              ON s.brand_label_type_id = u.brand_label_type_id 
	             AND s.untmea = u.untmea
	            WHERE (? IS NULL OR YEAR(s.trndte) = ?)
	              AND (? IS NULL OR MONTH(s.trndte) BETWEEN ? AND ?)
	              AND (? IS NULL OR s.customer_group = ?)
	              AND (? IS NULL OR s.cuscde = ?)
	              $brandTypeFilterConsignment
	              AND EXISTS (SELECT 1 FROM tbl_cus_sellout_indicator ci WHERE ci.cus_code = s.cuscde)
	            GROUP BY s.brand_label_type_id
	        ),
			final_data AS (
			    SELECT
			        a.customer_payment_group,
			        a.brand_type_id,
			        blt.label AS brand_type,
			        SUM($sellInExpr) AS sell_in,
			        SUM(a.sell_out) AS sell_out,
			        CASE 
			            WHEN SUM($sellInExpr) > 0 THEN ROUND((SUM(a.sell_out) / SUM($sellInExpr)) * 100, 2)
			            ELSE 0
			        END AS sell_out_ratio,
			        COUNT(*) OVER() AS total_records
			    FROM aggregated a
	            LEFT JOIN outright o
	                ON a.brand_type_id = o.brand_type_id 
	            LEFT JOIN consignment c
	                ON a.brand_type_id = c.brand_type_id 
	            LEFT JOIN tbl_brand_label_type blt
	                ON a.brand_type_id = blt.id
	            GROUP BY a.brand_type_id, a.customer_payment_group, blt.label
			)
	        SELECT 
	            ROW_NUMBER() OVER(ORDER BY sell_out_ratio DESC) AS rank,
	            brand_type,
	            customer_payment_group,
	            sell_in,
	            sell_out,
	            sell_out_ratio,
	            total_records
	        FROM final_data
	        $searchClause
	        ORDER BY {$orderByColumn} {$orderDirection}
	        LIMIT ? OFFSET ?;
	    ";

	    $params = [
	        $year, $year,
	        $monthStart, $monthStart, $monthEnd,
	    ];
	    $params = array_merge($params, $brandTypeParams);
	    $params = array_merge($params, [
	        $salesGroup, $salesGroup, $salesGroup,
	        // outright
	        $year, $year,
	        $monthStart, $monthStart, $monthEnd,
	        $salesGroup, $salesGroup,
	        $subSalesGroup, $subSalesGroup,
	    ]);
	    $params = array_merge($params, $brandTypeParams);
	    $params = array_merge($params, [
	        // consignment
	        $year, $year,
	        $monthStart, $monthStart, $monthEnd,
	        $salesGroup, $salesGroup,
	        $subSalesGroup, $subSalesGroup,
	    ]);
	    $params = array_merge($params, $brandTypeParams);
	    $params = array_merge($params, $searchParams);
	    $params[] = (int)$limit;
	    $params[] = (int)$offset;

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();
	    $totalRecords = $data ? $data[0]->total_records : 0;

	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

	public function getSellThroughWeekOnWeekBrandLabel(
	    $year = null, 
	    $yearId = null, 
	    $weekStart = null, 
	    $weekEnd = null,
		$weekStartDate = null,
		$weekEndDate= null,
	    $searchValue = null,
	    $brandTypeIds = [],
	    $salesGroup = null, 
	    $subSalesGroup = null,
	    $watsonsPaymentGroup = null,
	    $orderByColumn = 'rank', 
	    $orderDirection = 'DESC', 
	    $limit = 100, 
	    $offset = 0, 
	    $sellInType = 3,
	    $measure = 'qty'
	) {
	    $allowedOrderColumns = ['rank', 'brand_type', 'sell_in', 'sell_out', 'sell_out_ratio'];
	    $allowedOrderDirections = ['ASC', 'DESC'];

	    $searchColumns = ['LOWER(brand_type)'];
	    $searchClause = '';
	    $searchParams = [];

	    if (!empty($searchValue)) {
	        $likeConditions = array_map(fn($col) => "$col LIKE ?", $searchColumns);
	        $searchClause = 'WHERE ' . implode(' OR ', $likeConditions);
	        foreach ($searchColumns as $_) {
	            $searchParams[] = '%' . strtolower($searchValue) . '%';
	        }
	    }

	    if (!in_array($orderByColumn, $allowedOrderColumns)) $orderByColumn = 'sell_out_ratio';
	    if (!in_array(strtoupper($orderDirection), $allowedOrderDirections)) $orderDirection = 'DESC';

	    $brandTypeFilter = '';
	    $brandTypeParams = [];
	    if (!empty($brandTypeIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandTypeIds), '?'));
	        $brandTypeFilter = "AND wow.brand_type_id IN ($placeholders)";
	        $brandTypeParams = $brandTypeIds;
	    }

	    $brandTypeFilterOutright = $brandTypeFilterConsignment = '';
	    if (!empty($brandTypeIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandTypeIds), '?'));
	        $brandTypeFilterOutright = "AND s.brand_label_type_id IN ($placeholders)";
	        $brandTypeFilterConsignment = "AND s.brand_label_type_id IN ($placeholders)";
	    }

		if ($subSalesGroup) {
		    $sellOutExpr = $measure === 'amount'
		        ? "ROUND(wow.quantity * 
		            IF(
		                mp.effectivity_date <= CURRENT_DATE(),
		                IFNULL(cp.net_price, IFNULL(wow.net_price, 0)),
		                IFNULL(hp.net_price, IFNULL(wow.net_price, 0))
		            )
		        , 2)"
		        : "ROUND(SUM(wow.quantity), 0)";

		    $sellOutExpr2 = $sellOutExpr;
		} else {
		    $sellOutExpr = $measure === 'amount'
		        ? "ROUND(wow.quantity * IFNULL(wow.net_price, 0), 2)"
		        : "ROUND(wow.quantity, 0)";

		    $sellOutExpr2 = $sellOutExpr;
		}

	    $outrightExpr = $measure === 'amount'
	        ? "ROUND(SUM(s.extprc), 2)"
	        : "ROUND(SUM(s.itmqty * IFNULL(u.conver, 1)), 0)";

	    $consignmentExpr = $measure === 'amount'
	        ? "ROUND(SUM(s.amt), 2)"
	        : "ROUND(SUM(s.itmqty * IFNULL(u.conver, 1)), 0)";

		if ($measure === "amount") {
		    $sellInExpr = ($sellInType == 1 
		        ? "ROUND(IFNULL(o.total_qty, 0), 2)"
		        : ($sellInType == 0
		            ? "ROUND(IFNULL(c.total_qty, 0), 2)"
		            : "ROUND(IFNULL(o.total_qty, 0) + IFNULL(c.total_qty, 0), 2)")
		    );
		} else {
		    $sellInExpr = ($sellInType == 1 
		        ? "ROUND(IFNULL(o.total_qty, 0), 0)"
		        : ($sellInType == 0
		            ? "ROUND(IFNULL(c.total_qty, 0), 0)"
		            : "ROUND(IFNULL(o.total_qty, 0) + IFNULL(c.total_qty, 0), 0)")
		    );
		}

	    $sql = "
	        WITH aggregated AS (
			    SELECT
			        GROUP_CONCAT(DISTINCT sub.brand_type_id) AS brand_type_id,
			        GROUP_CONCAT(DISTINCT sub.item_class_id) AS brand_category_id,
			        SUM(sub.quantity) AS sell_out
			    FROM (
			        SELECT
		                wow.brand_type_id,
		                wow.item_class_id,
			            $sellOutExpr AS quantity
			        FROM tbl_week_on_week_vmi_pre_aggregated_data wow
			        INNER JOIN (SELECT DISTINCT brand_label_type_id, customer_payment_group FROM tbl_main_pricelist WHERE status = 1) mp
			            ON wow.brand_type_id = mp.brand_label_type_id

			        LEFT JOIN (SELECT DISTINCT brand_label_type_id, id, customer_payment_group FROM tbl_customer_pricelist) cp
			            ON wow.brand_type_id = cp.brand_label_type_id

			        LEFT JOIN (SELECT DISTINCT customer_id FROM tbl_historical_sub_pricelist) hp
			            ON cp.id = hp.customer_id

		            WHERE (? IS NULL OR wow.year = ?)
		              AND (? IS NULL OR wow.week BETWEEN ? AND ?)
		              AND (? IS NULL OR mp.customer_payment_group = ?)
		              $brandTypeFilter
			    ) AS sub
			    GROUP BY sub.brand_type_id
			),
	        outright AS (
	            SELECT 
	                s.brand_label_type_id AS brand_type_id,
	                s.brand_category_id,
	                $outrightExpr AS total_qty
	            FROM tbl_item_salesfile2_all s
	            LEFT JOIN (
	                SELECT untmea, brand_label_type_id, brand_category_id, MAX(conver) AS conver
	                FROM tbl_item_unit_file_all
	                GROUP BY brand_label_type_id, untmea
	            ) u 
	              ON s.brand_label_type_id = u.brand_label_type_id 
	             AND s.untmea = u.untmea
	            WHERE s.trncde = 'SAL'
	              AND (s.dettyp <> 'C' OR s.dettyp IS NULL)
	              AND (? IS NULL OR s.trndte BETWEEN ? AND ?)
	              AND (? IS NULL OR s.customer_group = ?)
	              AND (? IS NULL OR s.cuscde = ?)
	              $brandTypeFilterOutright
	              AND EXISTS (SELECT 1 FROM tbl_cus_sellout_indicator ci WHERE ci.cus_code = s.cuscde)
	            GROUP BY s.brand_label_type_id
	        ),
	        consignment AS (
	            SELECT 
	                s.brand_label_type_id AS brand_type_id,
	                s.brand_category_id,
	                $consignmentExpr AS total_qty
	            FROM tbl_item_salesfile_consignment_all s
	            LEFT JOIN (
	                SELECT untmea, brand_label_type_id, brand_category_id, MAX(conver) AS conver
	                FROM tbl_item_unit_file_all
	                GROUP BY brand_label_type_id, untmea
	            ) u 
	              ON s.brand_label_type_id = u.brand_label_type_id 
	             AND s.untmea = u.untmea
	            WHERE (? IS NULL OR s.trndte BETWEEN ? AND ?)
	              AND (? IS NULL OR s.customer_group = ?)
	              AND (? IS NULL OR s.cuscde = ?)
	              $brandTypeFilterConsignment
	              AND EXISTS (SELECT 1 FROM tbl_cus_sellout_indicator ci WHERE ci.cus_code = s.cuscde)
	            GROUP BY s.brand_label_type_id
	        ),
			final_data AS (
			    SELECT
			        a.brand_type_id,
			        blt.label AS brand_type,
			        SUM($sellInExpr) AS sell_in,
			        SUM(a.sell_out) AS sell_out,
			        CASE 
			            WHEN SUM($sellInExpr) > 0
			            THEN CAST(ROUND((a.sell_out / $sellInExpr) * 100, 2) AS DECIMAL(10,2))
			            ELSE 0
			        END AS sell_out_ratio,
			        COUNT(*) OVER() AS total_records
			    FROM aggregated a
	            LEFT JOIN outright o
	                ON a.brand_type_id = o.brand_type_id 
	            LEFT JOIN consignment c
	                ON a.brand_type_id = c.brand_type_id 
	            LEFT JOIN tbl_brand_label_type blt
	                ON a.brand_type_id = blt.id
	            GROUP BY a.brand_type_id, blt.label
			)
	        SELECT 
	            ROW_NUMBER() OVER(ORDER BY sell_out_ratio DESC) AS rank,
	            brand_type,
	            sell_in,
	            sell_out,
	            sell_out_ratio,
	            total_records
	        FROM final_data
	        $searchClause
	        ORDER BY {$orderByColumn} {$orderDirection}
	        LIMIT ? OFFSET ?;
	    ";

	    $params = [
	        $yearId, $yearId,
	        $weekStart, $weekStart, $weekEnd,
	        $watsonsPaymentGroup, $watsonsPaymentGroup,
	    ];
	    $params = array_merge($params, $brandTypeParams);
	    $params = array_merge($params, [
	        // outright
	        //$year, $year,
	        $weekStartDate, $weekStartDate, $weekEndDate,
	        $salesGroup, $salesGroup,
	        $subSalesGroup, $subSalesGroup,
	    ]);
	    $params = array_merge($params, $brandTypeParams);
	    $params = array_merge($params, [
	        // consignment
	        //$year, $year,
	        $weekStartDate, $weekStartDate, $weekEndDate,
	        $salesGroup, $salesGroup,
	        $subSalesGroup, $subSalesGroup,
	    ]);
	    $params = array_merge($params, $brandTypeParams);
	    $params = array_merge($params, $searchParams);
	    $params[] = (int)$limit;
	    $params[] = (int)$offset;

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();
	    $totalRecords = $data ? $data[0]->total_records : 0;

	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

	public function getSellThroughWinsightBrandLabel(
	    $year = null, 
	    $yearId = null, 
	    $weekStart = null, 
	    $weekEnd = null,
		$weekStartDate = null,
		$weekEndDate= null,
	    $searchValue = null,
	    $brandTypeIds = [],
	    $salesGroup = null, 
	    $subSalesGroup = null, 
	    $watsonsPaymentGroup = null,
	    $orderByColumn = 'rank', 
	    $orderDirection = 'DESC', 
	    $limit = 100, 
	    $offset = 0, 
	    $sellInType = 3,
	    $measure = 'qty'
	) {
	    $allowedOrderColumns = ['rank', 'brand_type', 'sell_in', 'sell_out', 'sell_out_ratio'];
	    $allowedOrderDirections = ['ASC', 'DESC'];

	    $searchColumns = ['LOWER(brand_type)'];
	    $searchClause = '';
	    $searchParams = [];

	    if (!empty($searchValue)) {
	        $likeConditions = array_map(fn($col) => "$col LIKE ?", $searchColumns);
	        $searchClause = 'WHERE ' . implode(' OR ', $likeConditions);
	        foreach ($searchColumns as $_) {
	            $searchParams[] = '%' . strtolower($searchValue) . '%';
	        }
	    }

	    if (!in_array($orderByColumn, $allowedOrderColumns)) $orderByColumn = 'sell_out_ratio';
	    if (!in_array(strtoupper($orderDirection), $allowedOrderDirections)) $orderDirection = 'DESC';

	    $brandTypeFilter = '';
	    $brandTypeParams = [];
	    if (!empty($brandTypeIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandTypeIds), '?'));
	        $brandTypeFilter = "AND wd.brand_label_type_id IN ($placeholders)";
	        $brandTypeParams = $brandTypeIds;
	    }

	    $brandTypeFilterOutright = $brandTypeFilterConsignment = '';
	    if (!empty($brandTypeIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandTypeIds), '?'));
	        $brandTypeFilterOutright = "AND s.brand_label_type_id IN ($placeholders)";
	        $brandTypeFilterConsignment = "AND s.brand_label_type_id IN ($placeholders)";
	    }

		if ($subSalesGroup) {
		    $sellOutExpr = $measure === 'amount'
		        ? "ROUND(wd.sales_qty * 
		            IF(
		                mp.effectivity_date <= CURRENT_DATE(),
		                IFNULL(cp.net_price, IFNULL(wd.net_price, 0)),
		                IFNULL(hp.net_price, IFNULL(wd.net_price, 0))
		            )
		        , 2)"
		        : "ROUND(wd.sales_qty, 0)";

		    $sellOutExpr2 = $sellOutExpr;
		} else {
		    $sellOutExpr = $measure === 'amount'
		        ? "ROUND(wd.sales_qty * IFNULL(wd.net_price, 0), 2)"
		        : "ROUND(wd.sales_qty, 0)";

		    $sellOutExpr2 = $sellOutExpr;
		}

	    $outrightExpr = $measure === 'amount'
	        ? "ROUND(SUM(s.extprc), 2)"
	        : "ROUND(SUM(s.itmqty * IFNULL(u.conver, 1)), 0)";

	    $consignmentExpr = $measure === 'amount'
	        ? "ROUND(SUM(s.amt), 2)"
	        : "ROUND(SUM(s.itmqty * IFNULL(u.conver, 1)), 0)";

		if ($measure === "amount") {
		    $sellInExpr = ($sellInType == 1 
		        ? "ROUND(IFNULL(o.total_qty, 0), 2)"
		        : ($sellInType == 0
		            ? "ROUND(IFNULL(c.total_qty, 0), 2)"
		            : "ROUND(IFNULL(o.total_qty, 0) + IFNULL(c.total_qty, 0), 2)")
		    );
		} else {
		    $sellInExpr = ($sellInType == 1 
		        ? "ROUND(IFNULL(o.total_qty, 0), 0)"
		        : ($sellInType == 0
		            ? "ROUND(IFNULL(c.total_qty, 0), 0)"
		            : "ROUND(IFNULL(o.total_qty, 0) + IFNULL(c.total_qty, 0), 0)")
		    );
		}

	    $sql = "
	        WITH aggregated AS (
			    SELECT
			        GROUP_CONCAT(DISTINCT sub.brand_label_type_id) AS brand_type_id,
			        GROUP_CONCAT(DISTINCT sub.category_1_id) AS brand_category_id,
			        SUM(sub.sales_qty) AS sell_out
			    FROM (
			        SELECT
		                wd.brand_label_type_id,
		                wd.category_1_id,
			            $sellOutExpr AS sales_qty
		            FROM tbl_winsight_details wd
			        INNER JOIN (SELECT DISTINCT brand_label_type_id, customer_payment_group FROM tbl_main_pricelist WHERE status = 1) mp
			            ON wd.brand_label_type_id = mp.brand_label_type_id

			        LEFT JOIN (SELECT DISTINCT brand_label_type_id, id, customer_payment_group FROM tbl_customer_pricelist) cp
			            ON wd.brand_label_type_id = cp.brand_label_type_id

			        LEFT JOIN (SELECT DISTINCT customer_id FROM tbl_historical_sub_pricelist) hp
			            ON cp.id = hp.customer_id

		            WHERE (? IS NULL OR wd.year = ?)
		              AND (? IS NULL OR wd.week BETWEEN ? AND ?)
		              AND (? IS NULL OR mp.customer_payment_group = ?)
		              $brandTypeFilter
			    ) AS sub
			    GROUP BY sub.brand_label_type_id
			),
	        outright AS (
	            SELECT 
	                s.brand_label_type_id AS brand_type_id,
	                s.brand_category_id,
	                $outrightExpr AS total_qty
	            FROM tbl_item_salesfile2_all s
	            LEFT JOIN (
	                SELECT untmea, brand_label_type_id, brand_category_id, MAX(conver) AS conver
	                FROM tbl_item_unit_file_all
	                GROUP BY brand_label_type_id, untmea
	            ) u 
	              ON s.brand_label_type_id = u.brand_label_type_id 
	             AND s.untmea = u.untmea
	            WHERE s.trncde = 'SAL'
	              AND (s.dettyp <> 'C' OR s.dettyp IS NULL)
	              AND (? IS NULL OR s.trndte BETWEEN ? AND ?)
	              AND (? IS NULL OR s.customer_group = ?)
	              AND (? IS NULL OR s.cuscde = ?)
	              $brandTypeFilterOutright
	              AND EXISTS (SELECT 1 FROM tbl_cus_sellout_indicator ci WHERE ci.cus_code = s.cuscde)
	            GROUP BY s.brand_label_type_id
	        ),
	        consignment AS (
	            SELECT 
	                s.brand_label_type_id AS brand_type_id,
	                s.brand_category_id,
	                $consignmentExpr AS total_qty
	            FROM tbl_item_salesfile_consignment_all s
	            LEFT JOIN (
	                SELECT untmea, brand_label_type_id, brand_category_id, MAX(conver) AS conver
	                FROM tbl_item_unit_file_all
	                GROUP BY brand_label_type_id, untmea
	            ) u 
	              ON s.brand_label_type_id = u.brand_label_type_id 
	             AND s.untmea = u.untmea
	            WHERE (? IS NULL OR s.trndte BETWEEN ? AND ?)
	              AND (? IS NULL OR s.customer_group = ?)
	              AND (? IS NULL OR s.cuscde = ?)
	              $brandTypeFilterConsignment
	              AND EXISTS (SELECT 1 FROM tbl_cus_sellout_indicator ci WHERE ci.cus_code = s.cuscde)
	            GROUP BY s.brand_label_type_id
	        ),
			final_data AS (
			    SELECT
			        a.brand_type_id,
			        blt.label AS brand_type,
			        SUM($sellInExpr) AS sell_in,
			        SUM(a.sell_out) AS sell_out,
			        CASE 
			            WHEN SUM($sellInExpr) > 0 
			            THEN CAST(ROUND((a.sell_out / $sellInExpr) * 100, 2) AS DECIMAL(10,2))
			            ELSE 0
			        END AS sell_out_ratio,
			        COUNT(*) OVER() AS total_records
			    FROM aggregated a
	            LEFT JOIN outright o
	                ON a.brand_type_id = o.brand_type_id 
	            LEFT JOIN consignment c
	                ON a.brand_type_id = c.brand_type_id 
	            LEFT JOIN tbl_brand_label_type blt
	                ON a.brand_type_id = blt.id
	            GROUP BY a.brand_type_id, blt.label
			)
	        SELECT 
	            ROW_NUMBER() OVER(ORDER BY sell_out_ratio DESC) AS rank,
	            brand_type,
	            sell_in,
	            sell_out,
	            sell_out_ratio,
	            total_records
	        FROM final_data
	        $searchClause
	        ORDER BY {$orderByColumn} {$orderDirection}
	        LIMIT ? OFFSET ?;
	    ";

	    $params = [
	        $year, $year,
	        $weekStart, $weekStart, $weekEnd,
	        $watsonsPaymentGroup, $watsonsPaymentGroup,
	    ];
	    $params = array_merge($params, $brandTypeParams);
	    $params = array_merge($params, [
	        // outright
	        //$year, $year,
	        $weekStartDate, $weekStartDate, $weekEndDate,
	        $salesGroup, $salesGroup,
	        $subSalesGroup, $subSalesGroup,
	    ]);
	    $params = array_merge($params, $brandTypeParams);
	    $params = array_merge($params, [
	        // consignment
	        //$year, $year,
	        $weekStartDate, $weekStartDate, $weekEndDate,
	        $salesGroup, $salesGroup,
	        $subSalesGroup, $subSalesGroup,
	    ]);
	    $params = array_merge($params, $brandTypeParams);
	    $params = array_merge($params, $searchParams);
	    $params[] = (int)$limit;
	    $params[] = (int)$offset;

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();
	    $totalRecords = $data ? $data[0]->total_records : 0;

	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

	public function getSellThroughScannDataByCategory(
	    $year = null, 
	    $monthStart = null, 
	    $monthEnd = null, 
	    $searchValue = null,
	    $brandCategoryIds = [],  
	    $subBrandCategoryIds = [],
	    $categoryIds = [], 
	    $itemDeptIds = [], 
	    $merchCatIds = [],  
	    $salesGroup = null, 
	    $subSalesGroup = null, 
	    $orderByColumn = 'rank', 
	    $orderDirection = 'DESC', 
	    $limit = 100, 
	    $offset = 0, 
	    $sellInType = 3,
	    $measure = 'qty'
	) {
		//brand_category = item classfication
	    $allowedOrderColumns = ['rank', 'brand_category', 'label_category', 'sub_classification', 'item_department', 'item_merchandise', 'sell_in', 'sell_out', 'sell_out_ratio'];
	    $allowedOrderDirections = ['ASC', 'DESC'];

	    $searchColumns = [
	    	'LOWER(brand_category)',
	    	'LOWER(label_category)',
	    	'LOWER(sub_classification)',
	    	'LOWER(item_department)',
	    	'LOWER(item_merchandise)'
	    	];
	    $searchClause = '';
	    $searchParams = [];

	    if (!empty($searchValue)) {
	        $likeConditions = array_map(fn($col) => "$col LIKE ?", $searchColumns);
	        $searchClause = 'WHERE ' . implode(' OR ', $likeConditions);
	        foreach ($searchColumns as $_) {
	            $searchParams[] = '%' . strtolower($searchValue) . '%';
	        }
	    }

	    if (!in_array($orderByColumn, $allowedOrderColumns)) {
	        $orderByColumn = 'sell_out_ratio';
	    }
	    if (!in_array(strtoupper($orderDirection), $allowedOrderDirections)) {
	        $orderDirection = 'DESC';
	    }

	    $brandCategoryFilter = '';
	    $brandCategoryParams = [];
	    if (!empty($brandCategoryIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandCategoryIds), '?'));
	        $brandCategoryFilter = "AND so.item_class_id IN ($placeholders)";
	        $brandCategoryParams = $brandCategoryIds;
	    }

	    $subBrandCategoryFilter = '';
	    $subBrandCategoryParams = [];
	    if (!empty($subBrandCategoryIds)) {
	        $placeholders = implode(',', array_fill(0, count($subBrandCategoryIds), '?'));
	        $subBrandCategoryFilter = "AND so.category_2_id IN ($placeholders)";
	        $subBrandCategoryParams = $subBrandCategoryIds;
	    }

	    $categoryFilter = '';
	    $categoryParams = [];
	    if (!empty($categoryIds)) {
	        $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));
	        $categoryFilter = "AND so.label_type_category_id IN ($placeholders)";
	        $categoryParams = $categoryIds;
	    }	

	    $itemDeptFilter = '';
	    $itemDeptParams = [];
	    if (!empty($itemDeptIds)) {
	        $placeholders = implode(',', array_fill(0, count($itemDeptIds), '?'));
	        $itemDeptFilter = "AND so.category_3_id IN ($placeholders)";
	        $itemDeptParams = $itemDeptIds;
	    }

	    $merchCatFilter = '';
	    $merchCatParams = [];
	    if (!empty($merchCatIds)) {
	        $placeholders = implode(',', array_fill(0, count($merchCatIds), '?'));
	        $merchCatFilter = "AND so.category_4_id IN ($placeholders)";
	        $merchCatParams = $merchCatIds;
	    }	

	    $brandCategoryFilterOutright = $brandCategoryFilterConsignment = '';
	    if (!empty($brandCategoryIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandCategoryIds), '?'));
	        $brandCategoryFilterOutright = "AND s.brand_category_id IN ($placeholders)";
	        $brandCategoryFilterConsignment = "AND s.brand_category_id IN ($placeholders)";
	    }	

	    $subBrandCategoryFilterOutright = $subBrandCategoryFilterConsignment = '';
	    if (!empty($subBrandCategoryIds)) {
	        $placeholders = implode(',', array_fill(0, count($subBrandCategoryIds), '?'));
	        $subBrandCategoryFilterOutright = "AND s.category_2_id IN ($placeholders)";
	        $subBrandCategoryFilterConsignment = "AND s.category_2_id IN ($placeholders)";
	    }	

	    $categoryFilterOutright = $categoryFilterConsignment = '';
	    if (!empty($categoryIds)) {
	        $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));
	        $categoryFilterOutright = "AND s.label_type_category_id IN ($placeholders)";
	        $categoryFilterConsignment = "AND s.label_type_category_id IN ($placeholders)";
	    }

	    $itemDeptFilterOutright = $itemDeptFilterConsignment = '';
	    if (!empty($itemDeptIds)) {
	        $placeholders = implode(',', array_fill(0, count($itemDeptIds), '?'));
	        $itemDeptFilterOutright = "AND s.category_3_id IN ($placeholders)";
	        $itemDeptFilterConsignment = "AND s.category_3_id IN ($placeholders)";
	    }	

	    $merchCatFilterOutright = $merchCatFilterConsignment = '';
	    if (!empty($merchCatIds)) {
	        $placeholders = implode(',', array_fill(0, count($merchCatIds), '?'));
	        $merchCatFilterOutright = "AND s.category_4_id IN ($placeholders)";
	        $merchCatFilterConsignment = "AND s.category_4_id IN ($placeholders)";
	    }	

		if ($subSalesGroup) {
		    $sellOutExpr = $measure === 'amount'
		        ? "ROUND(so.quantity * 
		            IF(
		                mp.effectivity_date <= CURRENT_DATE(),
		                IFNULL(cp.net_price, IFNULL(so.net_price, 0)),
		                IFNULL(hp.net_price, IFNULL(so.net_price, 0))
		            )
		        , 2)"
		        : "ROUND(so.quantity, 0)";

		    $sellOutExpr2 = $sellOutExpr;
		} else {
		    $sellOutExpr = $measure === 'amount'
		        ? "ROUND(so.quantity * IFNULL(so.net_price, 0), 2)"
		        : "ROUND(so.quantity, 0)";

		    $sellOutExpr2 = $sellOutExpr;
		}
	    
	    $outrightExpr = $measure === 'amount'
	        ? "ROUND(SUM(s.extprc), 2)"
	        : "ROUND(SUM(s.itmqty * IFNULL(u.conver, 1)), 0)";

	    $consignmentExpr = $measure === 'amount'
	        ? "ROUND(SUM(s.amt), 2)"
	        : "ROUND(SUM(s.itmqty * IFNULL(u.conver, 1)), 0)";

		if ($measure === "amount") {
		    $sellInExpr = ($sellInType == 1 
		        ? "ROUND(IFNULL(o.total_qty, 0), 2)"
		        : ($sellInType == 0
		            ? "ROUND(IFNULL(c.total_qty, 0), 2)"
		            : "ROUND(IFNULL(o.total_qty, 0) + IFNULL(c.total_qty, 0), 2)")
		    );
		} else {
		    $sellInExpr = ($sellInType == 1 
		        ? "ROUND(IFNULL(o.total_qty, 0), 0)"
		        : ($sellInType == 0
		            ? "ROUND(IFNULL(c.total_qty, 0), 0)"
		            : "ROUND(IFNULL(o.total_qty, 0) + IFNULL(c.total_qty, 0), 0)")
		    );
		}

	    $sql = "
	        WITH aggregated AS (
			    SELECT
			        sub.customer_payment_group,
			        sub.label_type_category_id,
			        sub.category_2_id,
			        sub.category_3_id,
			        sub.category_4_id,
			        sub.item_class_id AS brand_category_id,
			        SUM(sub.quantity) AS sell_out
			    FROM (
			        SELECT 
		                so.customer_payment_group,
		                so.label_type_category_id,
		                so.item_class_id,
		                so.category_2_id,
		                so.category_3_id,
		                so.category_4_id,
			            $sellOutExpr AS quantity
		            FROM tbl_sell_out_pre_aggregated_data so
			        INNER JOIN (SELECT DISTINCT category_1_id, label_type_category_id, category_2_id, category_3_id, category_4_id, customer_payment_group FROM tbl_main_pricelist WHERE status = 1) mp
			            ON so.item_class_id = mp.category_1_id
			            AND so.customer_payment_group = mp.customer_payment_group
			            AND so.label_type_category_id = mp.label_type_category_id
			            AND so.category_2_id = mp.category_2_id
			            AND so.category_3_id = mp.category_3_id
			            AND so.category_4_id = mp.category_4_id

			        LEFT JOIN (SELECT DISTINCT category_1_id, label_type_category_id, category_2_id, category_3_id, category_4_id, id, customer_payment_group FROM tbl_customer_pricelist) cp
			            ON so.item_class_id = cp.category_1_id
			           AND so.customer_payment_group = cp.customer_payment_group
					   AND so.label_type_category_id = mp.label_type_category_id
					   AND so.category_2_id = mp.category_2_id
					   AND so.category_3_id = mp.category_3_id
					   AND so.category_4_id = mp.category_4_id

			        LEFT JOIN (SELECT DISTINCT customer_id FROM tbl_historical_sub_pricelist) hp
			            ON cp.id = hp.customer_id

		            WHERE (? IS NULL OR so.year = ?)
		              AND (? IS NULL OR so.month BETWEEN ? AND ?)
		              AND (? IS NULL OR (so.customer_payment_group = ? AND mp.customer_payment_group = ?))
		              	$brandCategoryFilter
						$subBrandCategoryFilter
						$categoryFilter
						$itemDeptFilter
						$merchCatFilter
			    ) AS sub
			    GROUP BY sub.item_class_id, sub.label_type_category_id, sub.category_2_id, sub.category_3_id, sub.category_4_id
			),
	        outright AS (
	            SELECT 
	                s.brand_category_id,
	                s.label_type_category_id,
	                s.category_2_id,
	                s.category_3_id,
	                s.category_4_id,
	                $outrightExpr AS total_qty
	            FROM tbl_item_salesfile2_all s
	            LEFT JOIN (
	                SELECT untmea, brand_category_id, label_type_category_id, category_2_id, category_3_id, category_4_id, MAX(conver) AS conver
	                FROM tbl_item_unit_file_all
	                GROUP BY brand_category_id, untmea, label_type_category_id, category_2_id, category_3_id, category_4_id
		            ) u 
		              ON s.brand_category_id = u.brand_category_id
		             AND s.untmea = u.untmea
		             AND s.label_type_category_id = u.label_type_category_id
		             AND s.category_2_id = u.category_2_id
		             AND s.category_3_id = u.category_3_id
		             AND s.category_4_id = u.category_4_id
		            WHERE s.trncde = 'SAL'
		              AND (s.dettyp <> 'C' OR s.dettyp IS NULL)
		              AND (? IS NULL OR YEAR(s.trndte) = ?)
		              AND (? IS NULL OR MONTH(s.trndte) BETWEEN ? AND ?)
		              AND (? IS NULL OR s.customer_group = ?)
		              AND (? IS NULL OR s.cuscde = ?)
					  $brandCategoryFilterOutright
					  $subBrandCategoryFilterOutright
					  $categoryFilterOutright
					  $itemDeptFilterOutright
					  $merchCatFilterOutright
	              AND EXISTS (
	                  SELECT 1 
	                  FROM tbl_cus_sellout_indicator ci
	                  WHERE ci.cus_code = s.cuscde
	              )
	            GROUP BY s.brand_category_id, s.label_type_category_id, s.category_2_id, s.category_3_id, s.category_4_id
	        ),
	        consignment AS (
	            SELECT 
	                s.brand_category_id,
	                s.label_type_category_id,
	                s.category_2_id,
	                s.category_3_id,
	                s.category_4_id,
	                $consignmentExpr AS total_qty
	            FROM tbl_item_salesfile_consignment_all s
	            LEFT JOIN (
	                SELECT untmea, brand_category_id, label_type_category_id, category_2_id, category_3_id, category_4_id, MAX(conver) AS conver
	                FROM tbl_item_unit_file_all
	                GROUP BY brand_category_id, untmea, label_type_category_id, category_2_id, category_3_id, category_4_id
		            ) u 
		              ON s.brand_category_id = u.brand_category_id
		             AND s.untmea = u.untmea
		             AND s.label_type_category_id = u.label_type_category_id
		             AND s.category_2_id = u.category_2_id
		             AND s.category_3_id = u.category_3_id
		             AND s.category_4_id = u.category_4_id
		            WHERE (? IS NULL OR YEAR(s.trndte) = ?)
		              AND (? IS NULL OR MONTH(s.trndte) BETWEEN ? AND ?)
					  AND (? IS NULL OR s.customer_group = ?)
					  AND (? IS NULL OR s.cuscde = ?)
					  $brandCategoryFilterConsignment
					  $subBrandCategoryFilterConsignment
					  $categoryFilterConsignment
					  $itemDeptFilterConsignment
					  $merchCatFilterConsignment
		              AND EXISTS (
		                  SELECT 1 
		                  FROM tbl_cus_sellout_indicator ci
		                  WHERE ci.cus_code = s.cuscde
		              )
	            GROUP BY s.brand_category_id, s.label_type_category_id, s.category_2_id, s.category_3_id, s.category_4_id
	        ),
	        final_data AS (
	            SELECT
	                a.customer_payment_group,
	                a.brand_category_id,
	                lcl.description AS label_category,
	                sc.item_sub_class_code AS sub_classification,
	                id.item_department_code AS item_department,
	                imc.item_mech_cat_code AS item_merchandise,
	                cl.item_class_description AS brand_category,
	                $sellInExpr AS sell_in,
	                a.sell_out,
	                CASE 
	                    WHEN $sellInExpr > 0 
	                    THEN CAST(ROUND((a.sell_out / $sellInExpr) * 100, 2) AS DECIMAL(10,2))
	                    ELSE 0
	                END AS sell_out_ratio,
	                COUNT(*) OVER() AS total_records
	            FROM aggregated a
	            LEFT JOIN outright o
	                  ON a.brand_category_id = o.brand_category_id
					 AND a.label_type_category_id = o.label_type_category_id
					 AND a.category_2_id = o.category_2_id
					 AND a.category_3_id = o.category_3_id
					 AND a.category_4_id = o.category_4_id
	            LEFT JOIN consignment c
					  ON a.brand_category_id = c.brand_category_id
					 AND a.label_type_category_id = c.label_type_category_id
					 AND a.category_2_id = c.category_2_id
					 AND a.category_3_id = c.category_3_id
					 AND a.category_4_id = c.category_4_id
	            LEFT JOIN tbl_classification cl
	                ON a.brand_category_id = cl.id
	            LEFT JOIN tbl_label_category_list lcl
	                ON a.label_type_category_id = lcl.id
	            LEFT JOIN tbl_sub_classification sc
	                ON a.category_2_id = sc.id
	            LEFT JOIN tbl_item_department id
	                ON a.category_3_id = id.id
	            LEFT JOIN tbl_item_merchandise_category imc
	                ON a.category_4_id = imc.id


	        )
	        SELECT 
	            ROW_NUMBER() OVER(ORDER BY sell_out_ratio DESC) AS rank,
	            label_category,
	            sub_classification,
	            item_department,
	            item_merchandise,
	            customer_payment_group,
	            brand_category,
	            sell_in,
	            sell_out,
	            sell_out_ratio,
	            total_records
	        FROM final_data
	        $searchClause
	        ORDER BY {$orderByColumn} {$orderDirection}
	        LIMIT ? OFFSET ?
	    ";

	    $params = [
	        $year, $year,
	        $monthStart, $monthStart, $monthEnd,
	        $salesGroup, $salesGroup, $salesGroup,
	    ];
	    $params = array_merge($params, $brandCategoryParams, $subBrandCategoryParams, $categoryParams, $itemDeptParams, $merchCatParams);
	    $params = array_merge($params, [
	        // outright
	        $year, $year,
	        $monthStart, $monthStart, $monthEnd,
	        $salesGroup, $salesGroup,
	        $subSalesGroup, $subSalesGroup,
	    ]);
	    $params = array_merge($params, $brandCategoryParams, $subBrandCategoryParams, $categoryParams, $itemDeptParams, $merchCatParams);
	    $params = array_merge($params, [
	        // consignment
	        $year, $year,
	        $monthStart, $monthStart, $monthEnd,
	        $salesGroup, $salesGroup,
	        $subSalesGroup, $subSalesGroup,
	    ]);
	    $params = array_merge($params, $brandCategoryParams, $subBrandCategoryParams, $categoryParams, $itemDeptParams, $merchCatParams);
	    $params = array_merge($params, $searchParams);
	    $params[] = (int)$limit;
	    $params[] = (int)$offset;

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();
	    $totalRecords = $data ? $data[0]->total_records : 0;

	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

	public function getSellThroughWeekOnWeekByCategory(
	    $year = null, 
	    $yearId = null, 
	    $weekStart = null, 
	    $weekEnd = null,
		$weekStartDate = null,
		$weekEndDate= null,
	    $searchValue = null,
	    $brandCategoryIds = [],  
	    $subBrandCategoryIds = [],
	    $categoryIds = [], 
	    $itemDeptIds = [], 
	    $merchCatIds = [],  
	    $salesGroup = null, 
	    $subSalesGroup = null,
	    $watsonsPaymentGroup = null,
	    $orderByColumn = 'rank', 
	    $orderDirection = 'DESC', 
	    $limit = 100, 
	    $offset = 0, 
	    $sellInType = 3,
	    $measure = 'qty'
	) {

	    $allowedOrderColumns = ['rank', 'brand_category', 'label_category', 'sub_classification', 'item_department', 'item_merchandise', 'sell_in', 'sell_out', 'sell_out_ratio'];
	    $allowedOrderDirections = ['ASC', 'DESC'];

	    $searchColumns = [
	    	'LOWER(brand_category)',
	    	'LOWER(label_category)',
	    	'LOWER(sub_classification)',
	    	'LOWER(item_department)',
	    	'LOWER(item_merchandise)'
	    	];
	    $searchClause = '';
	    $searchParams = [];

	    if (!empty($searchValue)) {
	        $likeConditions = array_map(fn($col) => "$col LIKE ?", $searchColumns);
	        $searchClause = 'WHERE ' . implode(' OR ', $likeConditions);
	        foreach ($searchColumns as $_) {
	            $searchParams[] = '%' . strtolower($searchValue) . '%';
	        }
	    }

	    if (!in_array($orderByColumn, $allowedOrderColumns)) {
	        $orderByColumn = 'sell_out_ratio';
	    }
	    if (!in_array(strtoupper($orderDirection), $allowedOrderDirections)) {
	        $orderDirection = 'DESC';
	    }

	    $brandCategoryFilter = '';
	    $brandCategoryParams = [];
	    if (!empty($brandCategoryIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandCategoryIds), '?'));
	        $brandCategoryFilter = "AND wow.item_class_id IN ($placeholders)";
	        $brandCategoryParams = $brandCategoryIds;
	    }

	    $subBrandCategoryFilter = '';
	    $subBrandCategoryParams = [];
	    if (!empty($subBrandCategoryIds)) {
	        $placeholders = implode(',', array_fill(0, count($subBrandCategoryIds), '?'));
	        $subBrandCategoryFilter = "AND wow.category_2_id IN ($placeholders)";
	        $subBrandCategoryParams = $subBrandCategoryIds;
	    }

	    $categoryFilter = '';
	    $categoryParams = [];
	    if (!empty($categoryIds)) {
	        $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));
	        $categoryFilter = "AND wow.label_type_category_id IN ($placeholders)";
	        $categoryParams = $categoryIds;
	    }	

	    $itemDeptFilter = '';
	    $itemDeptParams = [];
	    if (!empty($itemDeptIds)) {
	        $placeholders = implode(',', array_fill(0, count($itemDeptIds), '?'));
	        $itemDeptFilter = "AND wow.category_3_id IN ($placeholders)";
	        $itemDeptParams = $itemDeptIds;
	    }

	    $merchCatFilter = '';
	    $merchCatParams = [];
	    if (!empty($merchCatIds)) {
	        $placeholders = implode(',', array_fill(0, count($merchCatIds), '?'));
	        $merchCatFilter = "AND wow.category_4_id IN ($placeholders)";
	        $merchCatParams = $merchCatIds;
	    }	

	    $brandCategoryFilterOutright = $brandCategoryFilterConsignment = '';
	    if (!empty($brandCategoryIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandCategoryIds), '?'));
	        $brandCategoryFilterOutright = "AND s.brand_category_id IN ($placeholders)";
	        $brandCategoryFilterConsignment = "AND s.brand_category_id IN ($placeholders)";
	    }	

	    $subBrandCategoryFilterOutright = $subBrandCategoryFilterConsignment = '';
	    if (!empty($subBrandCategoryIds)) {
	        $placeholders = implode(',', array_fill(0, count($subBrandCategoryIds), '?'));
	        $subBrandCategoryFilterOutright = "AND s.category_2_id IN ($placeholders)";
	        $subBrandCategoryFilterConsignment = "AND s.category_2_id IN ($placeholders)";
	    }	

	    $categoryFilterOutright = $categoryFilterConsignment = '';
	    if (!empty($categoryIds)) {
	        $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));
	        $categoryFilterOutright = "AND s.label_type_category_id IN ($placeholders)";
	        $categoryFilterConsignment = "AND s.label_type_category_id IN ($placeholders)";
	    }

	    $itemDeptFilterOutright = $itemDeptFilterConsignment = '';
	    if (!empty($itemDeptIds)) {
	        $placeholders = implode(',', array_fill(0, count($itemDeptIds), '?'));
	        $itemDeptFilterOutright = "AND s.category_3_id IN ($placeholders)";
	        $itemDeptFilterConsignment = "AND s.category_3_id IN ($placeholders)";
	    }	

	    $merchCatFilterOutright = $merchCatFilterConsignment = '';
	    if (!empty($merchCatIds)) {
	        $placeholders = implode(',', array_fill(0, count($merchCatIds), '?'));
	        $merchCatFilterOutright = "AND s.category_4_id IN ($placeholders)";
	        $merchCatFilterConsignment = "AND s.category_4_id IN ($placeholders)";
	    }	

		if ($subSalesGroup) {
		    $sellOutExpr = $measure === 'amount'
		        ? "ROUND(wow.quantity * 
		            IF(
		                mp.effectivity_date <= CURRENT_DATE(),
		                IFNULL(cp.net_price, IFNULL(wow.net_price, 0)),
		                IFNULL(hp.net_price, IFNULL(wow.net_price, 0))
		            )
		        , 2)"
		        : "ROUND(wow.quantity, 0)";

		    $sellOutExpr2 = $sellOutExpr;
		} else {
		    $sellOutExpr = $measure === 'amount'
		        ? "ROUND(wow.quantity * IFNULL(wow.net_price, 0), 2)"
		        : "ROUND(wow.quantity, 0)";

		    $sellOutExpr2 = $sellOutExpr;
		}
	    
	    $outrightExpr = $measure === 'amount'
	        ? "ROUND(SUM(s.extprc), 2)"
	        : "ROUND(SUM(s.itmqty * IFNULL(u.conver, 1)), 0)";

	    $consignmentExpr = $measure === 'amount'
	        ? "ROUND(SUM(s.amt), 2)"
	        : "ROUND(SUM(s.itmqty * IFNULL(u.conver, 1)), 0)";

		if ($measure === "amount") {
		    $sellInExpr = ($sellInType == 1 
		        ? "ROUND(IFNULL(o.total_qty, 0), 2)"
		        : ($sellInType == 0
		            ? "ROUND(IFNULL(c.total_qty, 0), 2)"
		            : "ROUND(IFNULL(o.total_qty, 0) + IFNULL(c.total_qty, 0), 2)")
		    );
		} else {
		    $sellInExpr = ($sellInType == 1 
		        ? "ROUND(IFNULL(o.total_qty, 0), 0)"
		        : ($sellInType == 0
		            ? "ROUND(IFNULL(c.total_qty, 0), 0)"
		            : "ROUND(IFNULL(o.total_qty, 0) + IFNULL(c.total_qty, 0), 0)")
		    );
		}

	    $sql = "
	        WITH aggregated AS (
			    SELECT
			        sub.label_type_category_id,
			        sub.category_2_id,
			        sub.category_3_id,
			        sub.category_4_id,
			        sub.item_class_id AS brand_category_id,
			        SUM(sub.quantity) AS sell_out
			    FROM (
			        SELECT
			        	wow.label_type_category_id,
		                wow.item_class_id,
		                wow.category_2_id,
		                wow.category_3_id,
		                wow.category_4_id,
			            $sellOutExpr AS quantity
			        FROM tbl_week_on_week_vmi_pre_aggregated_data wow
			        INNER JOIN (SELECT DISTINCT category_1_id, label_type_category_id, category_2_id, category_3_id, category_4_id, customer_payment_group FROM tbl_main_pricelist WHERE status = 1) mp
			            ON wow.item_class_id = mp.category_1_id
					   AND wow.label_type_category_id = mp.label_type_category_id
					   AND wow.category_2_id = mp.category_2_id
					   AND wow.category_3_id = mp.category_3_id
					   AND wow.category_4_id = mp.category_4_id

			        LEFT JOIN (SELECT DISTINCT category_1_id, label_type_category_id, category_2_id, category_3_id, category_4_id, id FROM tbl_customer_pricelist) cp
			            ON wow.item_class_id = cp.category_1_id
			           AND wow.label_type_category_id = mp.label_type_category_id
					   AND wow.category_2_id = mp.category_2_id
					   AND wow.category_3_id = mp.category_3_id
					   AND wow.category_4_id = mp.category_4_id

			        LEFT JOIN (SELECT DISTINCT customer_id FROM tbl_historical_sub_pricelist) hp
			            ON cp.id = hp.customer_id
			       
		            WHERE (? IS NULL OR wow.year = ?)
		              AND (? IS NULL OR wow.week BETWEEN ? AND ?)
		              AND (? IS NULL OR mp.customer_payment_group = ?)
		              	$brandCategoryFilter
						$subBrandCategoryFilter
						$categoryFilter
						$itemDeptFilter
						$merchCatFilter
			    ) AS sub
			    GROUP BY sub.item_class_id, sub.label_type_category_id, sub.category_2_id, sub.category_3_id, sub.category_4_id
	        ),
	        outright AS (
	            SELECT 
	                s.brand_category_id,
	                s.label_type_category_id,
	                s.category_2_id,
	                s.category_3_id,
	                s.category_4_id,
	                $outrightExpr AS total_qty
	            FROM tbl_item_salesfile2_all s
	            LEFT JOIN (
	                SELECT untmea, brand_category_id, label_type_category_id, category_2_id, category_3_id, category_4_id, MAX(conver) AS conver
	                FROM tbl_item_unit_file_all
	                GROUP BY brand_category_id, untmea
		            ) u 
		              ON s.brand_category_id = u.brand_category_id
		             AND s.untmea = u.untmea
		            WHERE s.trncde = 'SAL'
		              AND (s.dettyp <> 'C' OR s.dettyp IS NULL)
		              AND (? IS NULL OR s.trndte BETWEEN ? AND ?)
		              AND (? IS NULL OR s.customer_group = ?)
		              AND (? IS NULL OR s.cuscde = ?)
		              $brandCategoryFilterOutright
					  $subBrandCategoryFilterOutright
					  $categoryFilterOutright
					  $itemDeptFilterOutright
					  $merchCatFilterOutright
	              AND EXISTS (
	                  SELECT 1 
	                  FROM tbl_cus_sellout_indicator ci
	                  WHERE ci.cus_code = s.cuscde
	              )
	            GROUP BY s.brand_category_id, s.label_type_category_id, s.category_2_id, s.category_3_id, s.category_4_id
	        ),
	        consignment AS (
	            SELECT 
	                s.brand_category_id,
	                s.label_type_category_id,
	                s.category_2_id,
	                s.category_3_id,
	                s.category_4_id,
	                $consignmentExpr AS total_qty
	            FROM tbl_item_salesfile_consignment_all s
	            LEFT JOIN (
	                SELECT untmea, brand_category_id, label_type_category_id, category_2_id, category_3_id, category_4_id, MAX(conver) AS conver
	                FROM tbl_item_unit_file_all
	                GROUP BY brand_category_id, untmea, label_type_category_id, category_2_id, category_3_id, category_4_id
		            ) u 
		              ON s.brand_category_id = u.brand_category_id
		             AND s.untmea = u.untmea
		            WHERE (? IS NULL OR s.trndte BETWEEN ? AND ?)
					  AND (? IS NULL OR s.customer_group = ?)
					  AND (? IS NULL OR s.cuscde = ?)
					  $brandCategoryFilterConsignment
					  $subBrandCategoryFilterConsignment
					  $categoryFilterConsignment
					  $itemDeptFilterConsignment
					  $merchCatFilterConsignment
		              AND EXISTS (
		                  SELECT 1 
		                  FROM tbl_cus_sellout_indicator ci
		                  WHERE ci.cus_code = s.cuscde
		              )
	            GROUP BY s.brand_category_id, s.label_type_category_id, s.category_2_id, s.category_3_id, s.category_4_id
	        ),
	        final_data AS (
	            SELECT
	                a.brand_category_id,
	                lcl.description AS label_category,
	                sc.item_sub_class_code AS sub_classification,
	                id.item_department_code AS item_department,
	                imc.item_mech_cat_code AS item_merchandise,
	                cl.item_class_description AS brand_category,
	                $sellInExpr AS sell_in,
	                a.sell_out,
	                CASE 
	                    WHEN $sellInExpr > 0 
	                    THEN CAST(ROUND((a.sell_out / $sellInExpr) * 100, 2) AS DECIMAL(10,2))
	                    ELSE 0
	                END AS sell_out_ratio,
	                COUNT(*) OVER() AS total_records
	            FROM aggregated a
	            LEFT JOIN outright o
	                  ON a.brand_category_id = o.brand_category_id
					 AND a.label_type_category_id = o.label_type_category_id
					 AND a.category_2_id = o.category_2_id
					 AND a.category_3_id = o.category_3_id
					 AND a.category_4_id = o.category_4_id
	            LEFT JOIN consignment c
					  ON a.brand_category_id = c.brand_category_id
					 AND a.label_type_category_id = c.label_type_category_id
					 AND a.category_2_id = c.category_2_id
					 AND a.category_3_id = c.category_3_id
					 AND a.category_4_id = c.category_4_id
	            LEFT JOIN tbl_classification cl
	                ON a.brand_category_id = cl.id
	            LEFT JOIN tbl_label_category_list lcl
	                ON a.label_type_category_id = lcl.id
	            LEFT JOIN tbl_sub_classification sc
	                ON a.category_2_id = sc.id
	            LEFT JOIN tbl_item_department id
	                ON a.category_3_id = id.id
	            LEFT JOIN tbl_item_merchandise_category imc
	                ON a.category_4_id = imc.id
	        )
	        SELECT 
	            ROW_NUMBER() OVER(ORDER BY sell_out_ratio DESC) AS rank,
	            label_category,
	            sub_classification,
	            item_department,
	            item_merchandise,
	            brand_category,
	            sell_in,
	            sell_out,
	            sell_out_ratio,
	            total_records
	        FROM final_data
	        $searchClause
	        ORDER BY {$orderByColumn} {$orderDirection}
	        LIMIT ? OFFSET ?
	    ";
	    $params = [
	        $yearId, $yearId,
	        $weekStart, $weekStart, $weekEnd,
	        $watsonsPaymentGroup, $watsonsPaymentGroup,
	    ];
	    $params = array_merge($params, $brandCategoryParams, $subBrandCategoryParams, $categoryParams, $itemDeptParams, $merchCatParams);
	    $params = array_merge($params, [
	        // outright
	        $weekStartDate, $weekStartDate, $weekEndDate,
	        $salesGroup, $salesGroup,
	        $subSalesGroup, $subSalesGroup,
	    ]);
	    $params = array_merge($params, $brandCategoryParams, $subBrandCategoryParams, $categoryParams, $itemDeptParams, $merchCatParams);
	    $params = array_merge($params, [
	        // consignment
	        $weekStartDate, $weekStartDate, $weekEndDate,
	        $salesGroup, $salesGroup,
	        $subSalesGroup, $subSalesGroup,
	    ]);
	    $params = array_merge($params, $brandCategoryParams, $subBrandCategoryParams, $categoryParams, $itemDeptParams, $merchCatParams);
	    $params = array_merge($params, $searchParams);
	    $params[] = (int)$limit;
	    $params[] = (int)$offset;

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();
	    $totalRecords = $data ? $data[0]->total_records : 0;	   
	    // $finalQuery = $this->interpolateQuery($sql, $params);
	    // echo $finalQuery;
	    // die();
	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

	public function getSellThroughWinsightByCategory(
	    $year = null, 
	    $yearId = null, 
	    $weekStart = null, 
	    $weekEnd = null,
		$weekStartDate = null,
		$weekEndDate= null,
	    $searchValue = null,
	    $brandCategoryIds = [],  
	    $subBrandCategoryIds = [],
	    $categoryIds = [], 
	    $itemDeptIds = [], 
	    $merchCatIds = [],   
	    $salesGroup = null, 
	    $subSalesGroup = null, 
	    $watsonsPaymentGroup = null,
	    $orderByColumn = 'rank', 
	    $orderDirection = 'DESC', 
	    $limit = 100, 
	    $offset = 0, 
	    $sellInType = 3,
	    $measure = 'qty'
	) {

	    $allowedOrderColumns = ['rank', 'brand_category', 'label_category', 'sub_classification', 'item_department', 'item_merchandise', 'sell_in', 'sell_out', 'sell_out_ratio'];
	    $allowedOrderDirections = ['ASC', 'DESC'];

	    $searchColumns = [
	    	'LOWER(brand_category)',
	    	'LOWER(label_category)',
	    	'LOWER(sub_classification)',
	    	'LOWER(item_department)',
	    	'LOWER(item_merchandise)'
	    	];
	    $searchClause = '';
	    $searchParams = [];

	    if (!empty($searchValue)) {
	        $likeConditions = array_map(fn($col) => "$col LIKE ?", $searchColumns);
	        $searchClause = 'WHERE ' . implode(' OR ', $likeConditions);
	        foreach ($searchColumns as $_) {
	            $searchParams[] = '%' . strtolower($searchValue) . '%';
	        }
	    }

	    if (!in_array($orderByColumn, $allowedOrderColumns)) {
	        $orderByColumn = 'sell_out_ratio';
	    }
	    if (!in_array(strtoupper($orderDirection), $allowedOrderDirections)) {
	        $orderDirection = 'DESC';
	    }

	    $brandCategoryFilter = '';
	    $brandCategoryParams = [];
	    if (!empty($brandCategoryIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandCategoryIds), '?'));
	        $brandCategoryFilter = "AND wd.category_1_id IN ($placeholders)";
	        $brandCategoryParams = $brandCategoryIds;
	    }

	    $subBrandCategoryFilter = '';
	    $subBrandCategoryParams = [];
	    if (!empty($subBrandCategoryIds)) {
	        $placeholders = implode(',', array_fill(0, count($subBrandCategoryIds), '?'));
	        $subBrandCategoryFilter = "AND wd.category_2_id IN ($placeholders)";
	        $subBrandCategoryParams = $subBrandCategoryIds;
	    }

	    $categoryFilter = '';
	    $categoryParams = [];
	    if (!empty($categoryIds)) {
	        $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));
	        $categoryFilter = "AND wd.label_type_category_id IN ($placeholders)";
	        $categoryParams = $categoryIds;
	    }	

	    $itemDeptFilter = '';
	    $itemDeptParams = [];
	    if (!empty($itemDeptIds)) {
	        $placeholders = implode(',', array_fill(0, count($itemDeptIds), '?'));
	        $itemDeptFilter = "AND wd.category_3_id IN ($placeholders)";
	        $itemDeptParams = $itemDeptIds;
	    }

	    $merchCatFilter = '';
	    $merchCatParams = [];
	    if (!empty($merchCatIds)) {
	        $placeholders = implode(',', array_fill(0, count($merchCatIds), '?'));
	        $merchCatFilter = "AND wd.category_4_id IN ($placeholders)";
	        $merchCatParams = $merchCatIds;
	    }	

	    $brandCategoryFilterOutright = $brandCategoryFilterConsignment = '';
	    if (!empty($brandCategoryIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandCategoryIds), '?'));
	        $brandCategoryFilterOutright = "AND s.brand_category_id IN ($placeholders)";
	        $brandCategoryFilterConsignment = "AND s.brand_category_id IN ($placeholders)";
	    }	

	    $subBrandCategoryFilterOutright = $subBrandCategoryFilterConsignment = '';
	    if (!empty($subBrandCategoryIds)) {
	        $placeholders = implode(',', array_fill(0, count($subBrandCategoryIds), '?'));
	        $subBrandCategoryFilterOutright = "AND s.category_2_id IN ($placeholders)";
	        $subBrandCategoryFilterConsignment = "AND s.category_2_id IN ($placeholders)";
	    }	

	    $categoryFilterOutright = $categoryFilterConsignment = '';
	    if (!empty($categoryIds)) {
	        $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));
	        $categoryFilterOutright = "AND s.label_type_category_id IN ($placeholders)";
	        $categoryFilterConsignment = "AND s.label_type_category_id IN ($placeholders)";
	    }

	    $itemDeptFilterOutright = $itemDeptFilterConsignment = '';
	    if (!empty($itemDeptIds)) {
	        $placeholders = implode(',', array_fill(0, count($itemDeptIds), '?'));
	        $itemDeptFilterOutright = "AND s.category_3_id IN ($placeholders)";
	        $itemDeptFilterConsignment = "AND s.category_3_id IN ($placeholders)";
	    }	

	    $merchCatFilterOutright = $merchCatFilterConsignment = '';
	    if (!empty($merchCatIds)) {
	        $placeholders = implode(',', array_fill(0, count($merchCatIds), '?'));
	        $merchCatFilterOutright = "AND s.category_4_id IN ($placeholders)";
	        $merchCatFilterConsignment = "AND s.category_4_id IN ($placeholders)";
	    }	

		if ($subSalesGroup) {
		    $sellOutExpr = $measure === 'amount'
		        ? "ROUND(wd.sales_qty * 
		            IF(
		                mp.effectivity_date <= CURRENT_DATE(),
		                IFNULL(cp.net_price, IFNULL(wd.net_price, 0)),
		                IFNULL(hp.net_price, IFNULL(wd.net_price, 0))
		            )
		        , 2)"
		        : "ROUND(wd.sales_qty, 0)";

		    $sellOutExpr2 = $sellOutExpr;
		} else {
		    $sellOutExpr = $measure === 'amount'
		        ? "ROUND(wd.sales_qty * IFNULL(wd.net_price, 0), 2)"
		        : "ROUND(wd.sales_qty, 0)";

		    $sellOutExpr2 = $sellOutExpr;
		}
	    
	    $outrightExpr = $measure === 'amount'
	        ? "ROUND(SUM(s.extprc), 2)"
	        : "ROUND(SUM(s.itmqty * IFNULL(u.conver, 1)), 0)";

	    $consignmentExpr = $measure === 'amount'
	        ? "ROUND(SUM(s.amt), 2)"
	        : "ROUND(SUM(s.itmqty * IFNULL(u.conver, 1)), 0)";

		if ($measure === "amount") {
		    $sellInExpr = ($sellInType == 1 
		        ? "ROUND(IFNULL(o.total_qty, 0), 2)"
		        : ($sellInType == 0
		            ? "ROUND(IFNULL(c.total_qty, 0), 2)"
		            : "ROUND(IFNULL(o.total_qty, 0) + IFNULL(c.total_qty, 0), 2)")
		    );
		} else {
		    $sellInExpr = ($sellInType == 1 
		        ? "ROUND(IFNULL(o.total_qty, 0), 0)"
		        : ($sellInType == 0
		            ? "ROUND(IFNULL(c.total_qty, 0), 0)"
		            : "ROUND(IFNULL(o.total_qty, 0) + IFNULL(c.total_qty, 0), 0)")
		    );
		}

	    $sql = "
	        WITH aggregated AS (
			    SELECT
			    	sub.label_type_category_id,
			        sub.category_2_id,
			        sub.category_3_id,
			        sub.category_4_id,
			        sub.category_1_id AS brand_category_id,
			        SUM(sub.sales_qty) AS sell_out
			    FROM (
			        SELECT
		                wd.category_1_id,
		                wd.label_type_category_id,
		                wd.category_2_id,
		                wd.category_3_id,
		                wd.category_4_id,
			            $sellOutExpr AS sales_qty
		            FROM tbl_winsight_details wd
			        INNER JOIN (SELECT DISTINCT category_1_id, label_type_category_id, category_2_id, category_3_id, category_4_id, customer_payment_group FROM tbl_main_pricelist WHERE status = 1) mp
			            ON wd.category_1_id = mp.category_1_id
			            AND wd.label_type_category_id = mp.label_type_category_id
			            AND wd.category_2_id = mp.category_2_id
			            AND wd.category_3_id = mp.category_3_id
			            AND wd.category_4_id = mp.category_4_id
			        LEFT JOIN (SELECT DISTINCT category_1_id, label_type_category_id, category_2_id, category_3_id, category_4_id, id FROM tbl_customer_pricelist) cp
			            ON wd.category_1_id = cp.category_1_id
			            AND wd.label_type_category_id = mp.label_type_category_id
			            AND wd.category_2_id = mp.category_2_id
			            AND wd.category_3_id = mp.category_3_id
			            AND wd.category_4_id = mp.category_4_id

			        LEFT JOIN (SELECT DISTINCT customer_id FROM tbl_historical_sub_pricelist) hp
			            ON cp.id = hp.customer_id

		            WHERE (? IS NULL OR wd.year = ?)
		              AND (? IS NULL OR wd.week BETWEEN ? AND ?)
		              AND (? IS NULL OR mp.customer_payment_group = ?)
		              	$brandCategoryFilter
						$subBrandCategoryFilter
						$categoryFilter
						$itemDeptFilter
						$merchCatFilter

			    ) AS sub
			    GROUP BY sub.category_1_id, sub.label_type_category_id, sub.category_2_id, sub.category_3_id, sub.category_4_id
	        ),
	        outright AS (
	            SELECT 
	                s.brand_category_id,
	                s.label_type_category_id,
	                s.category_2_id,
	                s.category_3_id,
	                s.category_4_id,
	                $outrightExpr AS total_qty
	            FROM tbl_item_salesfile2_all s
	            LEFT JOIN (
	                SELECT untmea, brand_category_id, label_type_category_id, category_2_id, category_3_id, category_4_id, MAX(conver) AS conver
	                FROM tbl_item_unit_file_all
	                GROUP BY brand_category_id, untmea, label_type_category_id, category_2_id, category_3_id, category_4_id
		            ) u 
		              ON s.brand_category_id = u.brand_category_id
		             AND s.untmea = u.untmea
		             AND s.label_type_category_id = u.label_type_category_id
		             AND s.category_2_id = u.category_2_id
		             AND s.category_3_id = u.category_3_id
		             AND s.category_4_id = u.category_4_id
		            WHERE s.trncde = 'SAL'
		              AND (s.dettyp <> 'C' OR s.dettyp IS NULL)
		              AND (? IS NULL OR s.trndte BETWEEN ? AND ?)
		              AND (? IS NULL OR s.customer_group = ?)
		              AND (? IS NULL OR s.cuscde = ?)
					  $brandCategoryFilterOutright
					  $subBrandCategoryFilterOutright
					  $categoryFilterOutright
					  $itemDeptFilterOutright
					  $merchCatFilterOutright
	              AND EXISTS (
	                  SELECT 1 
	                  FROM tbl_cus_sellout_indicator ci
	                  WHERE ci.cus_code = s.cuscde
	              )
	            GROUP BY s.brand_category_id, s.label_type_category_id, s.category_2_id, s.category_3_id, s.category_4_id
	        ),
	        consignment AS (
	            SELECT 
	                s.brand_category_id,
	                s.label_type_category_id,
	                s.category_2_id,
	                s.category_3_id,
	                s.category_4_id,
	                $consignmentExpr AS total_qty
	            FROM tbl_item_salesfile_consignment_all s
	            LEFT JOIN (
	                SELECT untmea, brand_category_id, label_type_category_id, category_2_id, category_3_id, category_4_id, MAX(conver) AS conver
	                FROM tbl_item_unit_file_all
	                GROUP BY brand_category_id, untmea, label_type_category_id, category_2_id, category_3_id, category_4_id
		            ) u 
		              ON s.brand_category_id = u.brand_category_id
		             AND s.untmea = u.untmea
		             AND s.label_type_category_id = u.label_type_category_id
		             AND s.category_2_id = u.category_2_id
		             AND s.category_3_id = u.category_3_id
		             AND s.category_4_id = u.category_4_id
		            WHERE (? IS NULL OR s.trndte BETWEEN ? AND ?)
					  AND (? IS NULL OR s.customer_group = ?)
					  AND (? IS NULL OR s.cuscde = ?)
					  $brandCategoryFilterConsignment
					  $subBrandCategoryFilterConsignment
					  $categoryFilterConsignment
					  $itemDeptFilterConsignment
					  $merchCatFilterConsignment					  
		              AND EXISTS (
		                  SELECT 1 
		                  FROM tbl_cus_sellout_indicator ci
		                  WHERE ci.cus_code = s.cuscde
		              )
	            GROUP BY s.brand_category_id, s.label_type_category_id, s.category_2_id, s.category_3_id, s.category_4_id
	        ),
	        final_data AS (
	            SELECT
	                a.brand_category_id,
	                lcl.description AS label_category,
	                sc.item_sub_class_code AS sub_classification,
	                id.item_department_code AS item_department,
	                imc.item_mech_cat_code AS item_merchandise,
	                cl.item_class_description AS brand_category,
	                $sellInExpr AS sell_in,
	                a.sell_out,
	                CASE 
	                    WHEN $sellInExpr > 0 
	                    THEN CAST(ROUND((a.sell_out / $sellInExpr) * 100, 2) AS DECIMAL(10,2))
	                    ELSE 0
	                END AS sell_out_ratio,
	                COUNT(*) OVER() AS total_records
	            FROM aggregated a
	            LEFT JOIN outright o
	                  ON a.brand_category_id = o.brand_category_id
					 AND a.label_type_category_id = o.label_type_category_id
					 AND a.category_2_id = o.category_2_id
					 AND a.category_3_id = o.category_3_id
					 AND a.category_4_id = o.category_4_id
	            LEFT JOIN consignment c
					  ON a.brand_category_id = c.brand_category_id
					 AND a.label_type_category_id = c.label_type_category_id
					 AND a.category_2_id = c.category_2_id
					 AND a.category_3_id = c.category_3_id
					 AND a.category_4_id = c.category_4_id
	            LEFT JOIN tbl_classification cl
	                ON a.brand_category_id = cl.id
	            LEFT JOIN tbl_label_category_list lcl
	                ON a.label_type_category_id = lcl.id
	            LEFT JOIN tbl_sub_classification sc
	                ON a.category_2_id = sc.id
	            LEFT JOIN tbl_item_department id
	                ON a.category_3_id = id.id
	            LEFT JOIN tbl_item_merchandise_category imc
	                ON a.category_4_id = imc.id
	        )
	        SELECT 
	            ROW_NUMBER() OVER(ORDER BY sell_out_ratio DESC) AS rank,
	            label_category,
	            sub_classification,
	            item_department,
	            item_merchandise,
	            brand_category,
	            sell_in,
	            sell_out,
	            sell_out_ratio,
	            total_records
	        FROM final_data
	        $searchClause
	        ORDER BY {$orderByColumn} {$orderDirection}
	        LIMIT ? OFFSET ?
	    ";

	    $params = [
	        $year, $year,
	        $weekStart, $weekStart, $weekEnd,
	        $watsonsPaymentGroup, $watsonsPaymentGroup,
	    ];
		$params = array_merge($params, $brandCategoryParams, $subBrandCategoryParams, $categoryParams, $itemDeptParams, $merchCatParams);
	    $params = array_merge($params, [
	        // outright
	        $weekStartDate, $weekStartDate, $weekEndDate,
	        $salesGroup, $salesGroup,
	        $subSalesGroup, $subSalesGroup,
	    ]);
	    $params = array_merge($params, $brandCategoryParams, $subBrandCategoryParams, $categoryParams, $itemDeptParams, $merchCatParams);
	    $params = array_merge($params, [
	        // consignment
	        $weekStartDate, $weekStartDate, $weekEndDate,
	        $salesGroup, $salesGroup,
	        $subSalesGroup, $subSalesGroup,
	    ]);
	    $params = array_merge($params, $brandCategoryParams, $subBrandCategoryParams, $categoryParams, $itemDeptParams, $merchCatParams);

	    $params = array_merge($params, $searchParams);
	    $params[] = (int)$limit;
	    $params[] = (int)$offset;

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();
	    $totalRecords = $data ? $data[0]->total_records : 0;

	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

	public function getPromoTableVmi(
		$preWeekStart,
		$preWeekEnd,
		$postWeekStart,
		$postWeekEnd,
		$year,
		$orderByColumn,
		$orderDirection,
		$pageLimit,
		$pageOffset,
		$skus = [],
	    $variantName = null,
	    $brandIds = [],
	    $brandLabelTypeIds = [],
	    $storeCodes = [], 
		$searchValue = null
	){

	    $searchColumns = [
	        'item',
	        'itmdsc',
	        'itmcde'
	    ];
    	$allowedOrderColumns = ['sum_total_qty', 'item', 'itmdsc', 'itmcde'];
	    $allowedOrderDirections = ['ASC', 'DESC'];
	    $searchHavingClause = '';
	    $searchParams = [];

	    if (!empty($searchValue)) {
	        $likeConditions = array_map(fn($col) => "$col LIKE ?", $searchColumns);
	        $searchHavingClause = ' AND (' . implode(' OR ', $likeConditions) . ')';
	        foreach ($searchColumns as $_) {
	            $searchParams[] = '%' . $searchValue . '%';
	        }
	    }

	    if (!in_array($orderByColumn, $allowedOrderColumns)) {
	        $orderByColumn = 'itmcde';
	    }

	    if (!in_array(strtoupper($orderDirection), $allowedOrderDirections)) {
	        $orderDirection = 'ASC';
	    }

	    $skuFilter = '';
	    $skuParams = [];
	    if (!empty($skus)) {
	        $placeholders = implode(',', array_fill(0, count($skus), '?'));
	        $skuFilter = "AND vmi.itmcde IN ($placeholders)";
	        $skuParams = $skus;
	    }

	    $brandFilter = '';
	    $brandParams = [];
	    if (!empty($brandIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandIds), '?'));
	        $brandFilter = "AND vmi.tracc_brand_id IN ($placeholders)";
	        $brandParams = $brandIds;
	    }

	    $brandLabelFilter = '';
	    $brandLabelParams = [];
	    if (!empty($brandLabelTypeIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandLabelTypeIds), '?'));
	        $brandLabelFilter = "AND vmi.brand_type_id IN ($placeholders)";
	        $brandLabelParams = $brandLabelTypeIds;
	    }

	    $storeCodeFilter = '';
	    $storeCodeParams = [];
	    if (!empty($storeCodes)) {
	        $placeholders = implode(',', array_fill(0, count($storeCodes), '?'));
	        $storeCodeFilter = "AND vmi.store_code IN ($placeholders)";
	        $storeCodeParams = $storeCodes;
	    }

		$preDays = ($preWeekEnd - $preWeekStart + 1) * 7;
	    $postDays = ($postWeekEnd - $postWeekStart + 1) * 7;

    $sql = "
        SELECT 
            vmi.itmcde,
            vmi.item_name AS item_name,
            vmi.brand_type_id,
            $preDays AS pre_week_days,
            $postDays AS post_week_days,
            ROUND(SUM(CASE 
                WHEN vmi.week BETWEEN ? AND ? 
                THEN vmi.on_hand 
                ELSE 0 
            END) / ?, 2) AS pre,

            ROUND(SUM(CASE 
                WHEN vmi.week BETWEEN ? AND ? 
                THEN vmi.on_hand 
                ELSE 0 
            END) / ?, 2) AS post,
            ROUND(
                CASE 
                    WHEN SUM(CASE WHEN vmi.week BETWEEN ? AND ? THEN vmi.on_hand ELSE 0 END) = 0 THEN 0
                    ELSE 
                        ((SUM(CASE WHEN vmi.week BETWEEN ? AND ? THEN vmi.on_hand ELSE 0 END) / ?) /
                         (SUM(CASE WHEN vmi.week BETWEEN ? AND ? THEN vmi.on_hand ELSE 0 END) / ?)) * 100
                END
            , 2) AS adv,

            COUNT(*) OVER() AS total_records
	        FROM tbl_vmi_pre_aggregated_data vmi
	        WHERE (? IS NULL OR vmi.year = ? AND vmi.itmcde IS NOT NULL)
	        	AND (? IS NULL OR vmi.item_name = ?)
	            $skuFilter
	            $brandFilter
	            $brandLabelFilter
	            $storeCodeFilter
	        GROUP BY vmi.itmcde
	           {$searchHavingClause}
	        ORDER BY {$orderByColumn} {$orderDirection}
	        LIMIT ? OFFSET ?
	    ";

	    $params = [
	        $preWeekStart, $preWeekEnd, $preDays,
	        $postWeekStart, $postWeekEnd, $postDays,
	        $postWeekStart, $postWeekEnd,
	        $postWeekStart, $postWeekEnd, $postDays,
	        $preWeekStart, $preWeekEnd, $preDays,
	      
	        $year, $year,
	        $variantName, $variantName, 
	    ];

	    $params = array_merge($params, $skuParams, $brandParams, $brandLabelParams, $storeCodeParams);
	    $params = array_merge($params, $searchParams);
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

	public function getPromoTableScannData(
	    $preMonthStart,
	    $preMonthEnd,
	    $postMonthStart,
	    $postMonthEnd,
	    $orderByColumn,
	    $orderDirection,
	    $year,
	    $limit,
	    $offset,
	    $skus = [],
	    $variantName = null,
	    $brandIds = [],
	    $brandLabelTypeIds = [],
	    $storeCodes = [],
	    $searchValue = null
	) {

	    $allowedOrderColumns = ['itmcde', 'itmdsc'];
	    $allowedOrderDirections = ['ASC', 'DESC'];
	    $searchColumns = ['itmcde', 'itmdsc'];
	    $searchHavingClause = '';
	    $searchParams = [];

	    if (!empty($searchValue)) {
	        $likeConditions = array_map(fn($col) => "$col LIKE ?", $searchColumns);
	        $searchHavingClause = ' HAVING ' . implode(' OR ', $likeConditions);
	        foreach ($searchColumns as $_) {
	            $searchParams[] = '%' . $searchValue . '%';
	        }
	    }

	    if (!in_array($orderByColumn, $allowedOrderColumns)) {
	        $orderByColumn = 'itmcde';
	    }
	    if (!in_array(strtoupper($orderDirection), $allowedOrderDirections)) {
	        $orderDirection = 'ASC';
	    }

	    $skuFilter = '';
	    $skuParams = [];
	    if (!empty($skus)) {
	        $placeholders = implode(',', array_fill(0, count($skus), '?'));
	        $skuFilter = "AND so.itmcde IN ($placeholders)";
	        $skuParams = $skus;
	    }

	    $brandFilter = '';
	    $brandParams = [];
	    if (!empty($brandIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandIds), '?'));
	        $brandFilter = "AND so.brand_id IN ($placeholders)";
	        $brandParams = $brandIds;
	    }

	    $brandLabelFilter = '';
	    $brandLabelParams = [];
	    if (!empty($brandLabelTypeIds)) {
	        $placeholders = implode(',', array_fill(0, count($brandLabelTypeIds), '?'));
	        $brandLabelFilter = "AND so.brand_type_id IN ($placeholders)";
	        $brandLabelParams = $brandLabelTypeIds;
	    }

	    $storeCodeFilter = '';
	    $storeCodeParams = [];
	    if (!empty($storeCodes)) {
	        $placeholders = implode(',', array_fill(0, count($storeCodes), '?'));
	        $storeCodeFilter = "AND so.store_code IN ($placeholders)";
	        $storeCodeParams = $storeCodes;
	    }

		$preStartDate  = new DateTime($year . '-' . str_pad($preMonthStart, 2, '0', STR_PAD_LEFT) . '-01');
		$preEndDate    = new DateTime($year . '-' . str_pad($preMonthEnd, 2, '0', STR_PAD_LEFT) . '-' . cal_days_in_month(CAL_GREGORIAN, $preMonthEnd, $year));
		$preDays       = $preStartDate->diff($preEndDate)->days + 1;
	    
		$postStartDate = new DateTime($year . '-' . str_pad($postMonthStart, 2, '0', STR_PAD_LEFT) . '-01');
		$postEndDate   = new DateTime($year . '-' . str_pad($postMonthEnd, 2, '0', STR_PAD_LEFT) . '-' . cal_days_in_month(CAL_GREGORIAN, $postMonthEnd, $year));
		$postDays      = $postStartDate->diff($postEndDate)->days + 1;

	    $sql = "
	        SELECT 
			    so.itmcde,
			    $preDays AS pre_month_days,
			    $postDays AS post_month_days,	
			    ROUND(SUM(CASE 
			        WHEN so.year = ? AND so.month BETWEEN ? AND ? 
			        THEN so.gross_sales ELSE 0 END) / ?, 2) AS pre,
			    ROUND(SUM(CASE 
			        WHEN so.year = ? AND so.month BETWEEN ? AND ? 
			        THEN so.gross_sales ELSE 0 END) / ?, 2) AS post,
			    ROUND(
			        CASE 
			            WHEN SUM(CASE WHEN so.year = ? AND so.month BETWEEN ? AND ? THEN so.gross_sales ELSE 0 END) = 0
			            THEN 0
			            ELSE (
			                (SUM(CASE WHEN so.year = ? AND so.month BETWEEN ? AND ? THEN so.gross_sales ELSE 0 END) / ?) /
			                (SUM(CASE WHEN so.year = ? AND so.month BETWEEN ? AND ? THEN so.gross_sales ELSE 0 END) / ?) * 100
			            )
			        END, 2
			    ) AS ads,
	            COUNT(*) OVER() AS total_records
	        FROM tbl_sell_out_pre_aggregated_data so
	        WHERE (? IS NULL OR so.year = ? AND so.itmcde IS NOT NULL)
	            $skuFilter
	            $brandFilter
	            $brandLabelFilter
	            $storeCodeFilter
	        GROUP BY so.itmcde
	        $searchHavingClause
	        ORDER BY {$orderByColumn} {$orderDirection}
	        LIMIT ? OFFSET ?;
	    ";

	    $params = [
		    $year, $preMonthStart, $preMonthEnd, $preDays,
		    $year, $postMonthStart, $postMonthEnd, $postDays,
		    $year, $preMonthStart, $preMonthEnd,
		    $year, $postMonthStart, $postMonthEnd, $postDays,
    		$year, $preMonthStart, $preMonthEnd, $preDays,
	        $year, $year
	    ];

	    $params = array_merge($params, $skuParams, $brandParams, $brandLabelParams, $storeCodeParams);
	    $params = array_merge($params, $searchParams);

	    $params[] = (int)$limit;
	    $params[] = (int)$offset;

	    $query = $this->db->query($sql, $params);
	    $data = $query->getResult();
	    $totalRecords = $data ? $data[0]->total_records : 0;
		// $finalQuery = $this->interpolateQuery($sql, $params);
		// echo $finalQuery;
		// die();	
	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

	public function getPromoDataAll(
	    $year,
	    $yearId,
	    $preWeekStart,
	    $preWeekEnd,
	    $postWeekStart,
	    $postWeekEnd,
	    $preMonthStart,
	    $preMonthEnd,
	    $postMonthStart,
	    $postMonthEnd,
	    $orderByColumn,
	    $orderDirection,
	    $pageLimit,
	    $pageOffset,
	    $skus = [],
	    $variantName = null,
	    $brandIds = [],
	    $brandLabelTypeIds = [],
	    $storeCodes = [],
	    $searchValue = null
	) {
	    $vmiData = $this->getPromoTableVmi(
			$preWeekStart,
			$preWeekEnd,
			$postWeekStart,
			$postWeekEnd,
			$yearId,
			$orderByColumn,
			$orderDirection,
			$pageLimit,
			$pageOffset,
			$skus,
		    $variantName,
		    $brandIds,
		    $brandLabelTypeIds,
		    $storeCodes, 
			$searchValue
	    );

	    $sellOutData = $this->getPromoTableScannData(
		    $preMonthStart,
		    $preMonthEnd,
		    $postMonthStart,
		    $postMonthEnd,
		    $orderByColumn,
		    $orderDirection,
		    $year,
		    $pageLimit,
		    $pageOffset,
		    $skus,
		    $variantName,
		    $brandIds,
		    $brandLabelTypeIds,
		    $storeCodes,
		    $searchValue
	    );

	    $vmiMap = [];
	    foreach ($vmiData['data'] as $row) {
	        $vmiMap[$row->itmcde] = $row;
	    }

	    $combined = [];
	    foreach ($sellOutData['data'] as $sRow) {
	        $itmcde = $sRow->itmcde;
	        if (isset($vmiMap[$itmcde])) {
	            $vRow = $vmiMap[$itmcde];

	            $combined[] = (object)[
	                'itmcde' => $itmcde,
	                'item_name' => $vRow->item_name ?? null,

	                'pre_vmi'  => $vRow->pre ?? 0,
	                'post_vmi' => $vRow->post ?? 0,
	                'adv_vmi'  => $vRow->adv ?? 0,
	                'pre_week_days'  => $vRow->pre_week_days ?? 0,
	                'post_week_days'  => $vRow->post_week_days ?? 0,

	                'pre_sales'  => $sRow->pre ?? 0,
	                'post_sales' => $sRow->post ?? 0,
	                'ads_sales'  => $sRow->ads ?? 0,
	                'pre_month_days'  => $sRow->pre_month_days ?? 0,
	                'post_month_days'  => $sRow->post_month_days ?? 0,
	            ];
	        }
	    }

	    usort($combined, function ($a, $b) use ($orderByColumn, $orderDirection) {
	        $valA = $a->{$orderByColumn} ?? '';
	        $valB = $b->{$orderByColumn} ?? '';

	        $comparison = is_numeric($valA) && is_numeric($valB)
	            ? ($valA <=> $valB)
	            : strcmp($valA, $valB);

	        return strtoupper($orderDirection) === 'DESC' ? -$comparison : $comparison;
	    });

	    $totalRecords = count($combined);
	    //$pagedData = array_slice($combined, $pageOffset, $pageLimit);

	    return [
	        'total_records' => $totalRecords,
	        'data' => $combined
	    ];
	}

	public function getPromoDataAllClickhouse(
	    $year,
	    $yearId,
	    $preWeekStart,
	    $preWeekEnd,
	    $postWeekStart,
	    $postWeekEnd,
	    $preMonthStart,
	    $preMonthEnd,
	    $postMonthStart,
	    $postMonthEnd,
	    $orderByColumn,
	    $orderDirection,
	    $pageLimit,
	    $pageOffset,
	    $skus = [],
	    $variantName = null,
	    $brandIds = [],
	    $brandLabelTypeIds = [],
	    $storeCodes = [],
	    $searchValue = null
	) {
	    $allowedOrderColumns = ['itmcde', 'item_name', 'pre_sales', 'post_sales', 'ads_sales', 'pre_vmi', 'post_vmi', 'adv_vmi'];
	    $allowedOrderDirections = ['ASC', 'DESC'];

	    if (!in_array($orderByColumn, $allowedOrderColumns)) $orderByColumn = 'itmcde';
	    if (!in_array(strtoupper($orderDirection), $allowedOrderDirections)) $orderDirection = 'ASC';

	    $filters = [];

	    // if (!empty($variantName)) {
	    //     $filters[] = "vmi.item_name = '" . addslashes($variantName) . "'";
	    // }

		if (!empty($variantName)) {
		    $filters[] = "item_name = {variant:String}";
		    $params['variant'] = $variantName;
		}

	    if (!empty($searchValue)) {
	        $searchEscaped = addslashes($searchValue);
	        $filters[] = "(itmcde ILIKE '%$searchEscaped%' OR item_name ILIKE '%$searchEscaped%')";
	    }

	    $filterSql = !empty($filters) ? 'AND ' . implode(' AND ', $filters) : '';

	    $skuFilter = '';
	    if (!empty($skus)) {
	        $cleanSkus = array_map('trim', $skus);
	        $skuFilter = "AND itmcde IN ('" . implode("','", $cleanSkus) . "')";
	    }

	 	$brandFilter = '';
	 	$brandFilter2 = '';
	    if (!empty($brandIds)) {
	    	$cleanBrands = array_map('trim', $brandIds);
	        $brandFilter = "AND tracc_brand_id IN ('" . implode("','", $cleanBrands) . "')";
	        $brandFilter2 = "AND brand_id IN ('" . implode("','", $cleanBrands) . "')";
	    }

	    $brandLabelTypeFilter = '';
	    if (!empty($brandLabelTypeIds)) {
	    	$cleanBrandLabelTypes = array_map('trim', $brandLabelTypeIds);
	        $brandLabelTypeFilter = "AND brand_type_id IN ('" . implode("','", $cleanBrandLabelTypes) . "')";
	    }

	    $storeCodeFilter = '';
	    if (!empty($storeCodes)) {
	    	$cleanStoreCodes = array_map('trim', $storeCodes);
	        $storeCodeFilter = "AND store_code IN ('" . implode("','", $cleanStoreCodes) . "')";
	    }

	    $preDays = ($preWeekEnd - $preWeekStart + 1) * 7;
	    $postDays = ($postWeekEnd - $postWeekStart + 1) * 7;

	    $preStartDate  = new DateTime("$year-" . str_pad($preMonthStart, 2, '0', STR_PAD_LEFT) . "-01");
	    $preEndDate    = new DateTime("$year-" . str_pad($preMonthEnd, 2, '0', STR_PAD_LEFT) . "-" . cal_days_in_month(CAL_GREGORIAN, $preMonthEnd, $year));
	    $preMonthDays  = $preStartDate->diff($preEndDate)->days + 1;

	    $postStartDate = new DateTime("$year-" . str_pad($postMonthStart, 2, '0', STR_PAD_LEFT) . "-01");
	    $postEndDate   = new DateTime("$year-" . str_pad($postMonthEnd, 2, '0', STR_PAD_LEFT) . "-" . cal_days_in_month(CAL_GREGORIAN, $postMonthEnd, $year));
	    $postMonthDays = $postStartDate->diff($postEndDate)->days + 1;

	    $sql = "
	    SELECT
	        any(vmi.itmcde) AS itmcde,
	        any(vmi.item_name_agg) AS item_name,
	        any(vmi.pre_vmi) AS pre_vmi,
	        any(vmi.post_vmi) AS post_vmi,
	        any(vmi.adv_vmi) AS adv_vmi,
	        any(so.pre_sales) AS pre_sales,
	        any(so.post_sales) AS post_sales,
	        any(so.ads_sales) AS ads_sales
	    FROM
	    (
		SELECT 
		    itmcde,
		    any(item_name) AS item_name_agg,

		    round(SUM(CASE WHEN week BETWEEN {preWeekStart:Int32} AND {preWeekEnd:Int32} THEN on_hand ELSE 0 END) / {preDays:Int32}, 2) AS pre_vmi,
		    round(SUM(CASE WHEN week BETWEEN {postWeekStart:Int32} AND {postWeekEnd:Int32} THEN on_hand ELSE 0 END) / {postDays:Int32}, 2) AS post_vmi,
		    round(
		        IF(
		            round(SUM(CASE WHEN week BETWEEN {preWeekStart:Int32} AND {preWeekEnd:Int32} THEN on_hand ELSE 0 END) / {preDays:Int32}, 2) = 0,
		            0,
		            (
		                (
		                    round(SUM(CASE WHEN week BETWEEN {postWeekStart:Int32} AND {postWeekEnd:Int32} THEN on_hand ELSE 0 END) / {postDays:Int32}, 2)
		                    -
		                    round(SUM(CASE WHEN week BETWEEN {preWeekStart:Int32} AND {preWeekEnd:Int32} THEN on_hand ELSE 0 END) / {preDays:Int32}, 2)
		                )
		                /
		                round(SUM(CASE WHEN week BETWEEN {preWeekStart:Int32} AND {preWeekEnd:Int32} THEN on_hand ELSE 0 END) / {preDays:Int32}, 2)
		            ) * 100
		        ),
		    2) AS adv_vmi
	        FROM sfa_db.tbl_vmi_pre_aggregated_data
	        WHERE year = {yearId:Int32}
	        AND itmcde IS NOT NULL AND itmcde != ''
	        $skuFilter
	        $brandFilter
	        $brandLabelTypeFilter
	        $storeCodeFilter
	        $filterSql
	        GROUP BY itmcde
	    ) AS vmi
	    LEFT JOIN
	    (
		SELECT 
		    itmcde,
		    round(SUM(CASE WHEN month BETWEEN {preMonthStart:Int32} AND {preMonthEnd:Int32} THEN gross_sales ELSE 0 END) / {preMonthDays:Int32}, 2) AS pre_sales,
		    round(SUM(CASE WHEN month BETWEEN {postMonthStart:Int32} AND {postMonthEnd:Int32} THEN gross_sales ELSE 0 END) / {postMonthDays:Int32}, 2) AS post_sales,
		    round(
		        IF(
		            round(SUM(CASE WHEN month BETWEEN {preMonthStart:Int32} AND {preMonthEnd:Int32} THEN gross_sales ELSE 0 END) / {preMonthDays:Int32}, 2) = 0,
		            0,
		            (
		                (
		                    round(SUM(CASE WHEN month BETWEEN {postMonthStart:Int32} AND {postMonthEnd:Int32} THEN gross_sales ELSE 0 END) / {postMonthDays:Int32}, 2)
		                    -
		                    round(SUM(CASE WHEN month BETWEEN {preMonthStart:Int32} AND {preMonthEnd:Int32} THEN gross_sales ELSE 0 END) / {preMonthDays:Int32}, 2)
		                )
		                /
		                round(SUM(CASE WHEN month BETWEEN {preMonthStart:Int32} AND {preMonthEnd:Int32} THEN gross_sales ELSE 0 END) / {preMonthDays:Int32}, 2)
		            ) * 100
		        ),
		    2) AS ads_sales
	        FROM sfa_db.tbl_sell_out_pre_aggregated_data
	        WHERE year = {year:Int32}
	        $brandFilter2
	        $brandLabelTypeFilter
	        $storeCodeFilter
	        GROUP BY itmcde
	    ) AS so
	    ON vmi.itmcde = so.itmcde
	    GROUP BY vmi.itmcde
	    ORDER BY $orderByColumn $orderDirection
	    LIMIT {limit:Int32} OFFSET {offset:Int32}
	    FORMAT JSON
	    ";

	    $params = [
	        'year' => (int)$year,
	        'yearId' => (int)$yearId,
	        'preWeekStart' => (int)$preWeekStart,
	        'preWeekEnd' => (int)$preWeekEnd,
	        'postWeekStart' => (int)$postWeekStart,
	        'postWeekEnd' => (int)$postWeekEnd,
	        'preMonthStart' => (int)$preMonthStart,
	        'preMonthEnd' => (int)$preMonthEnd,
	        'postMonthStart' => (int)$postMonthStart,
	        'postMonthEnd' => (int)$postMonthEnd,
	        'preDays' => (int)$preDays,
	        'postDays' => (int)$postDays,
	        'preMonthDays' => (int)$preMonthDays,
	        'postMonthDays' => (int)$postMonthDays,
	        'limit' => (int)$pageLimit,
	        'offset' => (int)$pageOffset,
	        'variant' => $variantName,
	    ];

	    $ch = new \App\Libraries\ClickhouseClient();
	    $rows = $ch->query($sql, $params);

	    return [
	        'pre_week_days' => $preDays,
	        'post_week_days'=> $postDays,
	        'pre_month_days' => $preMonthDays,
	        'post_month_days' => $postMonthDays,
	        'data' => $rows
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
