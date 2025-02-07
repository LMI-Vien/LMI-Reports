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
        $query = $builder->get();

        return $query->getResult();
    }

    function get_historical_passwords($user_id, $password)
    {
        $builder = $this->db->table('cms_historical_passwords')
                            ->where('user_id', $user_id)
                            ->where('password', $password);
        $query = $builder->get();
        return $query->getResult();
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
}
