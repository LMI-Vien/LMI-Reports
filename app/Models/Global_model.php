<?php

namespace App\Models;

use CodeIgniter\Model;

class Global_model extends Model
{
    function check_sess() {
        $session = session();
        if($session->sess_user !='') { 
            return true;
        } else {
            return false;
        }
    }

    function validate_log($user, $pass) { 
        $builder = $this->db->table('cms_users')
                            ->select('password, salt')
                            ->where('username', $user);
        $query = $builder->get();
        $result = $query->getResult();

		if($pass.$result[0]->salt!=''){
            $saltedpassword = hash('sha256', $pass.'89B6089108oI0409');
        }else{
            $saltedpassword = '';
        }


        $storedpass = $result[0]->password;
        $options = ['cost' => 12];

        $hash = password_hash($saltedpassword, PASSWORD_DEFAULT, $options);
     
        if (password_verify($storedpass, $hash)) {
            $selectQuery = $this->db->table('cms_users')
                                    ->where('username', $user)
                                    ->where('password', $storedpass); 

            $fquery = $selectQuery->get();
            return $fquery->getResult();
        } else {
            return null;
        }	
         
    }

    function validate_log_report_user($user, $pass) { 
        $builder = $this->db->table('tbl_report_users')
                            ->select('password')
                            ->where('email', $user);
        $query = $builder->get();
        $result = $query->getResult();
        $saltedpassword = hash('sha256', $pass.'89B6089108oI0409');
            
        if($result){
            $storedpass = $result[0]->password;
            $options = ['cost' => 12];
            $hash = password_hash($saltedpassword, PASSWORD_DEFAULT, $options);
            if (password_verify($storedpass, $hash)){
                $selectQuery = $this->db->table('tbl_report_users')
                                        ->where('email', $user)
                                        ->where('password', $storedpass); 

                $fquery = $selectQuery->get();
                return $fquery->getResult();
            }else{
                return null;
            } 
        }else{
            return null;
        }
    }

    function check_user($user){
        $builder = $this->db->table('cms_users')
                            ->select('id,username,status,user_error_logs,user_block_logs,user_lock_time,email,role')
                            ->where('username', $user)
                            ->where('status >= ', 0);
        $query = $builder->get();
        return $query->getResult();
    }

    function check_email($email)
    {
        
        $builder = $this->db->table('cms_users')
                            ->where('email', $email)
                            ->where('status', 1);	
        $query = $builder->get();
        return $query->getResult();

    }

    function check_password($password, $user_id)
    {
        $builder = $this->db->table('cms_users')
                            ->where('id', $user_id)
                            ->where('password', $password)
                            ->where('status', 1);	
        $query = $builder->get();
        return $query->getResult();

    }

    function is_activated($username, $password)
    {
        $builder = $this->db->table('cms_users')
                            ->select('password, salt')
                            ->where('username', $username);
        $query = $builder->get();
        $result = $query->getResult();

        $saltedpassword = hash('sha256', $password.$result[0]->salt);
        $storedpass = $result[0]->password;
        $options = ['cost' => 12];

        $hash = password_hash($saltedpassword, PASSWORD_DEFAULT, $options);
        if (password_verify($storedpass, $hash)) {
            
            $selectQuery = $this->db->table('cms_users')
                                    ->where('username', $username)
                                    ->where('password', $storedpass)
                                    ->where('status', 1);
            $fquery = $selectQuery->get();

            return $fquery->getResult();
        } else {
            return null;
        }	
    }
    
    function get_by_id($table, $id) {
        $builder = $this->db->table($table)
                            ->where("id", $id);
        $q = $builder->get();
        return $q->getResult();
    }

    function get_by_site_id($table, $id) {
        $builder = $this->db->table($table)
                            ->where("site_id", $id);
        $q = $builder->get();
        return $q->getResult();
    }
    function get_by_list_where_not_in($table,$ids,$where=null)
    {
        $builder = $this->db->table($table);
        if($where)
        {
            $builder->where($where);
        }
        $builder->whereNotIn('id', $ids);

        $query  = $builder->get();

        return $query->getResult();

    }

    function get_list_query_sort($table, $query,$orderBy,$sort)
    {
        
        $builder = $this->db->table($table)
                            ->where($query)
                            ->orderBy($orderBy,$sort);
        $q = $builder->get();
        return $q->getResult();
    }

    function get_list_all($table)
    {
        $builder = $this->db->table($table);
        $q = $builder->get();
        return $q->getResult();
    }

    function get_list_query($table, $query)
    {
        
        $builder = $this->db->table($table)
                            ->where($query);
        $q = $builder->get();
        return $q->getResult();
    }

    function get_list_menu($table, $query)
    {
        
        $builder = $this->db->table($table)
                            ->where($query)
                            ->orderBy("sort_order","asc");
        $q = $builder->get();
        return $q->getResult();
    }

    function get_users_model($table)
    {
        
        $builder = $this->db->table($table)
                            ->where('status >=',0);
        $q = $builder->get();
        return $q->getResult();
    }
    
    function get_data_list($table, $query = null, $limit = 1, $start = 0, $select = "*", $order_field = null, $order_type = asc, $join = null, $group = null)
    {
        $builder = $this->db->table($table);
        $builder->select($select);
        if($query != null){
            $builder->where($query);
        }
        if($join != null){
            foreach ($join as $key => $vl) {
                $builder->join($vl['table'],$vl['query'],$vl['type']);
            };
        }
        if($order_field != null){
            $builder->orderBy($order_field, $order_type);
        }

        if($group != null){
            $builder->groupBy($group);
        }
        $builder->limit($limit, $start);
        $q = $builder->get();
        return $q->getResult();
    }

    function check_db_exist($table, $conditions = [], $limit = 1, $start = 0, $select = "*", $order_field = null, $order_type = 'asc', $join = null, $group = null, $params = [], $useOr = false)
    {
        $builder = $this->db->table($table);
        $builder->select($select);

        if (!empty($conditions) && is_array($conditions)) {
            $totalConditions = count($conditions);

            $groupSize = max(1, $totalConditions - 2);
            $groupedConditions = array_slice($conditions, 0, $groupSize);
            $remainingConditions = array_slice($conditions, $groupSize);

            if (!empty($groupedConditions)) {
                $builder->groupStart();
                foreach ($groupedConditions as $index => $condition) {
                    if ($index === 0) {
                        $builder->where($condition[0], $condition[1]);
                    } else {
                        if ($useOr == 'true') {
                            $builder->orWhere($condition[0], $condition[1]);
                        } else {
                            $builder->where($condition[0], $condition[1]);
                        }
                    }
                }
                $builder->groupEnd();
            }

            foreach ($remainingConditions as $condition) {
                $builder->where($condition[0], $condition[1]);
            }
        }
        
        if ($join != null) {
            foreach ($join as $vl) {
                $builder->join($vl['table'], $vl['query'], $vl['type']);
            }
        }

        if ($order_field != null) {
            $builder->orderBy($order_field, $order_type);
        }

        if ($group != null) {
            $builder->groupBy($group);
        }

        $builder->limit($limit, $start);
        $query = $builder->getCompiledSelect();
        $q = $this->db->query($query, $params);

        return $q->getResult();
    }

    function get_data_list_count($select, $table, $query = null, $offset = 0, $join = null)
    {
        $builder = $this->db->table($table);
        $builder->select($select);
        if($query){
            $builder->where($query);
        }
        
        if($join){
            foreach ($join as $key => $vl) {
                $builder->join($vl['table'],$vl['query'],$vl['type']);
            };
        }
        $builder->limit(999999, ($offset - 1) * 999999);
        return $builder->countAllResults();
    }

    function save_data($table, $data)
    {
        $return = $this->db
			 	->table($table)
			 	->insert($data);
		if($return):
            return $this->db->insertID();
		else:
			return "failed";
		endif;
    }

    function update_data($table,$data,$field,$where)
    {
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
    
    function delete_data($table, $id)
    {
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

    function tagging_delete_sub_ingredients($table, $id)
    {
        $return = $this->db
                        ->table($table)
                        ->where("ingredient_id", $id)
                        ->delete();
                if($return):
                    return "success";
                else:
                    return "failed";
                endif;
    }

    function tagging_delete_causes_preventions($table, $id)
    {
        $return = $this->db
                        ->table($table)
                        ->where("symptoms_id", $id)
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

    function tagging_delete_saf_product_data($table, $id)
    {
        $return = $this->db
                            ->table($table)
                            ->where("saf_id", $id)
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

    function tagging_delete_promo_media($table, $id)
    {
        $return = $this->db
                        ->table($table)
                        ->where("promo_id", $id)
                        ->delete();
                if($return):
                    return "success";
                else:
                    return "failed";
                endif;
    }

    function tagging_delete_product_variant_related_data($table, $id){
        $return = $this->db
                ->table($table)
                ->where("product_variant_id", $id)
                ->delete();
        if($return):
            $updated_status = $this->db
                ->table($table)
                ->where("related_product_variant_id", $id)
                ->delete();
                if($updated_status){
                    return "success";
                }else{
                    return "failed";
                }
        else:
            return "failed";
        endif;
    }

    function tagging_delete_email_recipient($table, $id)
    {
        $return = $this->db
                        ->table($table)
                        ->where("email_id", $id)
                        ->delete();
                if($return):
                    return "success";
                else:
                    return "failed";
                endif;
    }

    function tagging_delete_product_subnav($table, $id)
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

    function tagging_delete_related_product($table, $id)
    {
        $return = $this->db
                        ->table($table)
                        ->where("related_product_variant_id", $id)
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
        $query = $this->db->get();
        return $query->getResult();
    }

    function site_meta_og($id, $table, $field)
    {
        $full_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $selectQuery = $this->db->table('cms_seo')
                                ->where('url', $full_url);
        $query_first = $selectQuery->get("cms_seo");
        $count = $query_first->countAllResults();

        if($count > 0){
            return $query_first->getRowArray()[$field];
        }else{
            $builder = $this->db->table($table)
                                ->where('id', $id);
            $query = $builder->get();
            return $query->getRowArray()[$field];
        }
    } 

    function get_historical_passwords($user_id, $password)
    {
        $builder = $this->db->table('cms_users')
                            ->select('salt')
                            ->where('id', $user_id);
        $query  = $builder->get();
        $result = $query->getResult();
        $saltedpassword = hash('sha256', $password.$result[0]->salt);

        $builder2 = $this->db->table('cms_historical_passwords')
                            ->where('user_id', $user_id)
                            ->where('password', $saltedpassword);
        $fquery = $builder2->get();
        return $fquery->getResult();
    }

    function update_package($table,$data,$field,$where)
    {
        $return = $this->db
                            ->table($table)
                            ->set($data)
                            ->where($field, $where)
                            ->update();
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

    function get_menu($default = TRUE)
    {
        $builder = $this->db->table("site_menu");
        $builder->select("id, menu_url, menu_name, menu_parent_id, menu_type, url_behavior");
        if($default) {
            $builder->where("default_menu", 0);
        }
        $builder->where("status", 1);
        $builder->orderBy("sort_order", "ASC");

        return $builder->get()->getResultArray();
    }

    function get_site_icon($site_id)
    {
        $builder =  $this->db->table("site_information")   
                            ->select("site_logo")
                            ->where("site_id", $site_id);
        return $builder->get()->getRowArray()["site_logo"];
    }

    function get_site_id($site_name)
    {
        $builder =  $this->db->table('cms_sites')
                            ->select('id')
                            ->where('site_url', $site_name)
                            ->where('status', 1);
        $row = $builder->get()->getRow();

        if(isset($row)) {
            return $row->id;
        }else{
            return 0;
        }
        
    }

    function get_site_name($site_id)
    {
        $builder = $this->db->table('cms_sites')
                            ->select('id, site_name')
                            ->where('id', $site_id)
                            ->where('status', 1);
        $row = $builder->get()->getRow();
        if(isset($row)) {
            return $row->site_name;
        }else{
            return 0;
        }
    }

    function get_password_salt($user_id) {
        $builder = $this->db->table('cms_users')
                            ->select('salt')
                            ->where('id', $user_id);
        $query  = $builder->get();
        $result = $query->getResult();
        return $result[0]->salt;
    }

    function get_cookie_banner_notification() {
        $builder = $this->db->table('site_information')
                            ->select('site_cookie_notif_message')
                            ->where('id', 1);
        $query  = $builder->get();
        $result = $query->getResult();
        return $result[0]->site_cookie_notif_message;
    }
    function list_tables()
	{
		return $this->db->listTables();
	}

	function list_fields($table)
	{
		return $this->db->getFieldNames($table);
	}
    function check_field($table, $field, $path)
	{
		$builder = $this->db->table($table);
		$builder->like($field, $path);
		$query = $builder->get();
		return $query->getNumRows();
	}
    function count_list($table)
	{
		$builder = $this->db->table($table);
		$query = $builder->get();
		return $query->getNumRows();
	}

    public function get_site_url($site_id)
    {
        $builder = $this->db->table('cms_sites');
    
        $builder->select('id, site_url');
        $builder->where('id', $site_id);
        $builder->where('status', 1);

        $row = $builder->get()->getRowArray();
        
        if (!empty($row) && isset($row['site_url'])) {
            return $row['site_url'];
        } else {
            return 0;
        }
    }

    function get_field_values($table, $field, $ids)
    {
        if (empty($table) || empty($field) || empty($ids) || !is_array($ids)) {
            return [];
        }

        $query = $this->db->table($table)
                          ->select("id, $field") 
                          ->whereIn('id', $ids)
                          ->get();

        $results = [];
        foreach ($query->getResult() as $row) {
            $results[$row->id] = $row->$field;
        }

        return $results;
    }
    
    function list_existing($table, $selected_fields, $haystack, $needle)
    {
        
    }

}
