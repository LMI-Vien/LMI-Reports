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

	public function tradeOverallBaData($store = null, $area = null, $month = null, $year = null, $sort_field = null, $sort = 'ASC', $limit = 10, $offset = 0, $parameter_from_function = 25)
	{
	    $subquery = $this->db->table('tbl_ba_sales_report')
	        ->select("area_id,  SUM(amount) AS actual_sales, COUNT(*) OVER() AS total_records")
	        ->where('status', 1)
	        //->where('status', 1) add date
	        ->groupBy('area_id')
	        ->getCompiledSelect();

	    $query = $this->db->table("($subquery) AS aggregated_sps")
	        ->select("
	            aggregated_sps.area_id,
	            tbl_area.description as area,
	            tbl_store.code as store_code,
	            tbl_store.description as store,
	            aggregated_sps.actual_sales,
	            aggregated_sps.total_records,
	            GROUP_CONCAT(DISTINCT tbl_brand.brand_description ORDER BY tbl_brand.brand_description SEPARATOR ', ') AS brands,
	            SUM(tbl_target_sales_per_store.january) AS target,
	            ROUND((aggregated_sps.actual_sales / NULLIF(COALESCE(SUM(tbl_target_sales_per_store.january), 0), 0)) * 100, 2) AS arch,
	            COALESCE(SUM(tbl_target_sales_per_store.january), 0) - aggregated_sps.actual_sales AS balance_to_target,
	            COALESCE(aggregated_sps.actual_sales, 0) * 0.01 AS possible_incentives,
	            CEIL((COALESCE(SUM(tbl_target_sales_per_store.january), 0) - aggregated_sps.actual_sales) / NULLIF($parameter_from_function, 0)) AS target_per_rem_days,
	            ROUND(COALESCE(SUM(tbl_sell_out_data_details.net_sales), 0), 2) AS ly_scanned_data,
	            tbl_brand_ambassador.name as brand_ambassador_name,
	            tbl_brand_ambassador.deployment_date as ba_deployment_date,
	            DENSE_RANK() OVER (ORDER BY ROUND((aggregated_sps.actual_sales / NULLIF(COALESCE(SUM(tbl_target_sales_per_store.january), 0), 0)) * 100, 2) DESC) AS rank,
	            COALESCE(aggregated_sps.actual_sales, 0) / COALESCE(SUM(tbl_sell_out_data_details.net_sales), 0) AS growth
	        ")
	        ->join('tbl_ba_sales_report', 'aggregated_sps.area_id = tbl_ba_sales_report.area_id', 'left')
	        ->join('tbl_store', 'tbl_ba_sales_report.store_id = tbl_store.id', 'left')
	        ->join('tbl_area', 'tbl_ba_sales_report.area_id = tbl_area.id', 'left')
	        ->join('tbl_brand', 'tbl_ba_sales_report.brand = tbl_brand.id', 'left')
	        ->join('tbl_target_sales_per_store', 'tbl_ba_sales_report.store_id = tbl_target_sales_per_store.location', 'left')
	        ->join('tbl_brand_ambassador', 'tbl_ba_sales_report.ba_id = tbl_brand_ambassador.id', 'left')

	        //check the store code or store_id to be confirmed
	        ->join('tbl_sell_out_data_details', 'tbl_ba_sales_report.store_id = tbl_sell_out_data_details.store_code', 'left')
	        	
	        //add filter by month and year tbl_sell_out_data_details
	        //add filter by month and year tbl_target_sales_per_store
	       // ->where('tbl_sell_out_data_details.', 1)
	        ->groupBy('aggregated_sps.area_id')
	        ->orderBy('aggregated_sps.area_id', $sort)
	        ->limit($limit, $offset);

	    //return $query->get()->getResult();
        $data = $query->get()->getResult();
        // print_r($data[0]->total_records);
        // die();
  	    $totalRecords = count($data) > 0 ? $data[0]->total_records : 0;

	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

}
