<?php

namespace App\Models;

use CodeIgniter\Model;

class Gmodel extends Model
{
    function save_data($table, $data){
        $return = $this->db
			 	->table($table)
			 	->insert($data);
		if($return):
            return $this->db->insertID();
		else:
			return 0;
		endif;
    }

    function update_data($table,$data,$field,$where){
        $return = $this->db
                    ->table($table)
                    ->where($field, $where)
                    ->update($data);
        if($return):
            return "success";
        else:
            return "failed";
        endif;
    }

    function delete_data($table, $id){
        $return = $this->db
			 	->table($table)
				->where("id", $id)
				->delete();
		if($return):
			return "success";
		else:
			return "failed";
		endif;
    }

    function get_data_list($table, $query = null, $limit = 1, $start = 0, $select = "*", $order_field = null, $join = null, $group = null)
    {
        $builder = $this->db->table($table);
        
        $builder->select($select, FALSE);
        if($query != null){
            $builder->where($query);
        }
        
       

        if(isset($join)){
            if(count($join)> 0){
                foreach ($join as $key => $vl) {
                    foreach ($vl as $a => $b) {
                        $builder->join($b['table'], $b['param1'] . ' = ' . $b['param2'], $a);
                    }
                };
            }
        }
        
        if($order_field != null){
            foreach ($order_field as $key => $vl) {
                foreach ($vl as $a => $b) {
                    $builder->orderBy($b, $a);
                }
                
            };
        }

        $group_array = array();
        if($group != null){
            foreach ($group as $key => $value) {
                array_push($group_array, $value['field']);
            }
            $builder->groupBy($group_array);
        }
        $builder->limit($limit, $start);
        $q = $builder->get();
        return $q->getResult();
    }

    function get_data_list_count($select, $table, $query = null, $offset = 0, $join = null)
    {
        $builder = $this->db->table($table);
        $builder->select($select);
        if($query){
            $builder->where($query);
        }
        if(isset($join)){
            if(count($join)> 0){
                foreach ($join as $key => $vl) {
                    foreach ($vl as $a => $b) {
                        $builder->join($b['table'], $b['param1'] . ' = ' . $b['param2'], $a);
                    }
                };
            }
        }
        if($offset !== 0)
        {
            $builder->limit(999999);
        }
        else
        {
            $builder->limit(999999, ($offset - 1) * 999999);
        }
        return $builder->countAllResults();
    }

    function batch_sort_update_data($table,$data,$field,$where)
    {
        $return = $this->db
			 	->table($table)
                ->set('sort_order', $data)
				->where($field, $where)
			 	->update();
		if($return):
			return "success";
		else:
			return "failed";
		endif;
    }
    
    function batch_update($table,$data,$field,$where_in)
    {
        $return = $this->db
			 	->table($table)
				->whereIn($field, $where_in)
			 	->update($data);
		if($return):
			return "success";
		else:
			return "failed";
		endif;
    }
    
    function tagging_delete_data($table, $id)
    {
        $return = $this->db
			 	->table($table)
				->where("site_id", $id)
				->delete();
		if($return):
			return "success";
		else:
			return "failed";
		endif;
    }

    function tagging_delete_category_data($table, $id)
    {
        $return = $this->db
                        ->table($table)
                    ->where("product_id", $id)
                    ->delete();
                if($return):
                    return "success";
                else:
                    return "failed";
                endif;
    }

    function tagging_delete_product_data($table, $id)
    {
        $return = $this->db
                    ->table($table)
                    ->where("article_id", $id)
                    ->delete();
                if($return):
                    return "success";
                else:
                    return "failed";
                endif;
    }

    function tagging_delete_product_info_images_data($table, $id)
    {
        $return = $this->db
                    ->table($table)
                    ->where("product_info_id", $id)
                    ->delete();
                if($return):
                    return "success";
                else:
                    return "failed";
                endif;
    }

    function get_admin(){
        $builder = $this->db->table('cms_users')
                            ->whereIn('status', [1, 2]);
                    $query = $builder->get();
                    return $query->getResult();

    }

    function check_visit($unid, $type, $url, $date = null)
    {
        $builder = $this->db->table('site_analytics')
                            ->where('unid', $unid)
                            ->where('url', $url)
                            ->where('type', $type);
        if($date != null){
            $builder->like('datetime', $date);
        }
        
        $query = $builder->get();

        return $query->countAllResults();

    }

    function db_search($search_values)
    {
        $table_fields = array();
        $cumulative_results = array();

        $result = $this->db->query("
            SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE
            FROM  `INFORMATION_SCHEMA`.`COLUMNS` 
            WHERE  `TABLE_SCHEMA` =  '".$this->db->database."'
            AND `DATA_TYPE` IN ('varchar', 'char', 'text')
            ")->getResultArray();
        
        foreach ( $result  as $o ) 
        {
            $table_fields[$o['TABLE_NAME']][] = $o['COLUMN_NAME'];          
        }
        
        foreach($table_fields as $table_name => $fields)
        {
            $search_array = array();
            foreach($fields as $field)
            {
                $search_array[] = " `{$field}` LIKE '{$search_values}' ";
            }

            $search_string = implode (' OR ', $search_array);
            $query_string = "SELECT * FROM `{$table_name}` WHERE {$search_string}";
            
            $table_results = $this->db->query($query_string)->getResultArray();       
            $cumulative_results = array_merge($cumulative_results, $table_results);
        }
        
        return $cumulative_results;
    }

    function get_user_id($field = null)
    {
        $builder = $this->db->table('pckg_sign_up')
                            ->select('id')
                            ->where('sign_up_email_address', $field);
        $query = $builder->get();
        return $query->getResult();
    }

    function email_notif_enabled_admins($field = null)
    {
        $builder = $this->db->table('cms_users')
                            ->where('status', 1);
        if ($field == 'notif_contactus') {
            $builder->where('notif_contactus', 1);
        }
        if ($field == 'notif_signup') {
            $builder->where('notif_signup', 1);
        }
        $query = $builder->get();

        return $query->getResult();
    }

    function check_token_exist($token = null)
    {
        $builder = $this->db->table('pckg_sign_up')
        ->select('id')
        ->where('sign_up_token', $token)
        ->where('sign_up_status', 0);
        $query = $builder->get();
        return $query->getResult();
    }

    function activate_user($id = null)
    {
        $return = $this->db
                    ->table('pckg_sign_up')
                    ->where('id', $id)
                    ->update(array('sign_up_status' => 1,'sign_up_token'=>''));
            if($return):
            return "success";
            else:
            return "failed";
            endif;
    }

    function site_meta_og($id, $table, $field)
    {

        $full_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $builder = $this->db->table('cms_seo')
                            ->where('url', $full_url);
        $query_first = $builder->get();
        $count = $query_first->countAllResults();

        if($count > 0){
            return $query_first->getRowArray()[$field];
        }else{
            $result = $this->db->table($table)
                               ->where('id', $id);
            $query = $result->get();
            return $query->getRowArray()[$field];
        }
    } 

    function get_historical_passwords($user_id, $password)
    {
        $builder = $this->db->table('cms_historical_passwords')
                            ->where('user_id', $user_id)
                            ->where('password', $password);
        $query = $builder->get();
        return $query->getResult();
    }

    function update_package($table,$data,$field,$where)
    {
        $return = $this->db
			 	->table($table)
                ->where($field, $where, FALSE)
			 	->update($data);
		if($return):
			return "success";
		else:
			return "failed";
		endif;
    }
    function get_last_order($table_name)
    {
        $query = $this->db->query("SELECT MAX(`sort_order`) AS last_order FROM $table_name");
        $data = $query->getRow();
        return $data;
    }
    function get_data_list_report_count($select=null, $table=null,$group=null, $site_id=null, $report_type=null, $date=null){
        $builder = $this->db->table($table)
                            ->select($select)
                            ->like('created_date', $date);
        if($site_id !== null){
            //Filter by Site
            $builder->where('site_id', $site_id);
        }

        if($report_type !== null){
            //Filter by Log Type or Report Type
            $builder->where('action', $report_type);
        }
        
        $group_array = array();
        if($group != null){
            foreach ($group as $key => $value) {
                array_push($group_array, $value['field']);
            }
            $builder->groupBy($group_array);
        }

        $query = $builder->get();
        return $query->getResult();
    }

    function get_search_autocomplete_keyword_history($keyword = "", $cookie_id = null, $limit = 10) {
        $builder = $this->db->table("site_search_keywords");
        $builder->distinct();
        $builder->limit($limit);
        $builder->select("search_keywords");
        $builder->like("search_keywords", $keyword, "both");
        $builder->where("cookie_id", $cookie_id);

        $q = $builder->get();
        $array = $q->getResultArray();
        return array_column($array, "search_keywords");
    }

    function get_search_keyword_history($keyword = "", $cookie_id = null, $limit = 10) {
        $builder =  $this->db->table("site_search_keywords");
        $builder->distinct();
        $builder->limit($limit);
        $builder->select("search_keywords");
        $builder->where("cookie_id", $cookie_id);
        $builder->like("search_keywords", $keyword, "both");
        $builder->orderBy("timestamp", "DESC");

        $q = $builder->get();
        $array = $q->getResultArray();
        return array_column($array, "search_keywords");
    }

    function get_search_autocomplete_keywords($keyword = "", $limit = 10) {
        $builder =  $this->db->table("site_search_keywords");
        $builder->distinct();
        $builder->limit($limit);
        $builder->select("search_keywords");
        $builder->like("search_keywords", $keyword, "both");
        $builder->having("COUNT(search_keywords) > 10");
        
        $builder->groupBy("search_keywords");

        $q = $builder->get();
        $array = $q->getResultArray();
        return array_column($array, "search_keywords");
    }

    function get_search_autocomplete_articles($keyword = "", $limit = 10) {
        $builder =  $this->db->table("site_articles");
        $builder->distinct();
        $builder->limit($limit);
        $builder->select("title");
        $builder->like("title", $keyword, "both");
        $builder->where("status", 1);
        $builder->where("site_id", 1);
        
        $builder->orderBy("title", "ASC");

        $q = $builder->get();
        $array = $q->getResultArray();
        return array_column($array, "title");
    }

    function get_search_autocomplete_meta_keyword_articles($keyword = "", $limit = 10) {
        $builder =  $this->db->table("site_articles");
        $builder->distinct();
        $builder->limit($limit);
        $builder->select("meta_keywords");
        $builder->like("meta_keywords", $keyword, "both");
        $builder->where("status", 1);
        $builder->where("site_id", 1);
        
        $builder->orderBy("meta_keywords", "ASC");

        $q = $builder->get();
        $array = $q->getResultArray();
        $result_array = [];
        $y = 0;
        $array = array_column($array, "meta_keywords");
        $array_length = count($array) - 1;
        for ($i = 0; $i <= $array_length; $i++) {
            $temp_array = explode(", ", $array[$i]);
            $temp_array_length = count($temp_array);
            for ($x = 0; $x <= $temp_array_length - 1; $x++) {
                if (strpos(strtolower($temp_array[$x]), strtolower($keyword)) !== false) {
                    $result_array[$y] = $temp_array[$x];
                    $y++;
                }
            }
        }
        
        return $result_array;
    }

    function get_search_autocomplete_pharmacist_articles($keyword = "", $limit = 10) {
        $builder =  $this->db->table("site_pharmacist_articles");
        $builder->distinct();
        $builder->limit($limit);
        $builder->select("title");
        $builder->like("title", $keyword, "both");
        $builder->where("status", 1);
        $builder->where("site_id", 1);
        
        $builder->orderBy("title", "ASC");

        $q = $builder->get();
        $array = $q->getResultArray();
        return array_column($array, "title");
    }
    
    function get_search_autocomplete_meta_keyword_pharmacist_articles($keyword = "", $limit = 10) {
        $builder =  $this->db->table("site_pharmacist_articles");
        $builder->distinct();
        $builder->limit($limit);
        $builder->select("meta_keywords");
        $builder->like("meta_keywords", $keyword, "both");
        $builder->where("status", 1);
        $builder->where("site_id", 1);
       
        $builder->orderBy("meta_keywords", "ASC");

        $q = $builder->get();
        $array = $q->getResultArray();
        $result_array = [];
        $y = 0;
        $array = array_column($array, "meta_keywords");
        $array_length = count($array) - 1;
        for ($i = 0; $i <= $array_length; $i++) {
            $temp_array = explode(", ", $array[$i]);
            $temp_array_length = count($temp_array);
            for ($x = 0; $x <= $temp_array_length - 1; $x++) {
                if (strpos(strtolower($temp_array[$x]), strtolower($keyword)) !== false) {
                    $result_array[$y] = $temp_array[$x];
                    $y++;
                }
            }
        }
        
        return $result_array;
    }

    function get_search_autocomplete_products($keyword = "", $limit = 10) {
        $builder =  $this->db->table("site_product_info");
        $builder->distinct();
        $builder->limit($limit);
        $builder->select("product_name");
        $builder->where("REPLACE(site_product_info.product_name, '®', '') LIKE '%".$keyword."%'");
        $builder->where("status", 1);
        
        $builder->orderBy("product_name", "ASC");

        $q = $builder->get();
        $array = $q->getResultArray();
        $arr = array_column($array, "product_name");
        $arr = preg_replace("/[^a-zA-Z 0-9+\/\-\s]+/", "", $arr);			
        return $arr;
    }

    function get_search_autocomplete_products_generic_name($keyword = "", $limit = 10) {
        $builder =  $this->db->table("site_product_info");
        $builder->distinct();
        $builder->limit($limit);
        $builder->select("generic_name");
        $builder->like("generic_name", $keyword, "both");
        $builder->where("status", 1);
        
        $builder->orderBy("generic_name", "ASC");

        $q = $builder->get();
        $array = $q->getResultArray();
        $arr = array_column($array, "generic_name");
        $arr = preg_replace("/[^a-zA-Z 0-9+\/\-\s\<\>]+/", "", $arr);
        $arr = array_map("strip_tags", $arr);			
        return $arr;
    }

    function get_search_autocomplete_products_meta_keywords($keyword = "", $limit = 10) {
        $builder =  $this->db->table("site_product_info");
        $builder->distinct();
        $builder->limit($limit);
        $builder->select("meta_keyword");
        $builder->where("REPLACE(site_product_info.meta_keyword, '+', '') LIKE '%".$keyword."%'");
        $builder->where("status", 1);
        $builder->where("site_id", 1);			
        
        $builder->orderBy("meta_keyword", "ASC");

        $q = $builder->get();
        $array = $q->getResultArray();
        $result_array = [];
        $y = 0;
        $array = array_column($array, "meta_keyword");
        $array_length = count($array) - 1;
        for ($i = 0; $i <= $array_length; $i++) {
            $temp_array = explode(", ", $array[$i]);
            $temp_array_length = count($temp_array);
            for ($x = 0; $x <= $temp_array_length - 1; $x++) {
                $temp_keyword = trim(str_replace("+", "", strtolower($temp_array[$x])));
                if (strpos($temp_keyword, strtolower($keyword)) !== false) {
                    $result_array[$y] = $temp_keyword;
                    $y++;
                }
            }
        }
        
        return $result_array;
    }
}
