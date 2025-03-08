<?php

namespace App\Models;

use CodeIgniter\Model;

class Dashboard_model extends Model
{

	public function tradeInfoBa($brand, $brand_ambassador, $store_name, $ba_type, $sort = 'ASC', $limit, $offset, $minWeeks, $maxWeeks = null)
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


	public function getHeroItemsData($brand, $brand_ambassador, $store_name, $ba_type, $sort, $limit, $offset)
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

	public function getItemClassData($brand, $brand_ambassador, $store_name, $ba_type, $sort, $limit, $offset)
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

	public function testing_langv1($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $page_limit, $page_offset, $minWeeks, $maxWeeks, $week, $month, $year){
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

	public function getItemClassDatav2($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $limit, $offset) {
	    $query = $this->db->query('CALL get_ba_dashboard_npd(?, ?, ?, ?, ?, ?, ?, ?)', [
	        $brand, 
	        $brand_ambassador, 
	        $store_name, 
	        $ba_type,
	        $sort_field,
	        $sort, 
	        $limit, 
	        $offset
	    ]);

	    $data = $query->getResultArray();
	    $totalRecords = count($data) > 0 ? $data[0]['total_records'] : 0;

	    return [
	        'total_records' => $totalRecords,
	        'data' => $data
	    ];
	}

	public function getHeroItemsDatav2($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $limit, $offset) {
	    $query = $this->db->query('CALL get_ba_dashboard_hero(?, ?, ?, ?, ?, ?, ?, ?)', [
	        $brand, 
	        $brand_ambassador, 
	        $store_name, 
	        $ba_type,
	        $sort_field,
	        $sort, 
	        $limit, 
	        $offset
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

}
