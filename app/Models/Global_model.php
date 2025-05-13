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
        // Get user record
        $builder = $this->db->table('cms_users')
                            ->select('password, salt')
                            ->where('username', $user);
        $query = $builder->get();
        $result = $query->getRow(); 

        if (!$result) {
            return null;
        }

        $salted_password = hash('sha256', $pass . $result->salt);

        if (password_verify($salted_password, $result->password)) {
            return $this->db->table('cms_users')
                            ->where('username', $user)
                            ->get()
                            ->getRow();
        } else {
            return null;
        }   
    }

    function validate_log_email($email, $pass) { 
        // Get user record
        $builder = $this->db->table('cms_users')
                            ->select('password, salt')
                            ->where('dashboard_access', 1)
                            ->where('email', $email);
        $query = $builder->get();
        $result = $query->getRow(); 

        if (!$result) {
            return null;
        }

        $salted_password = hash('sha256', $pass . $result->salt);

        if (password_verify($salted_password, $result->password)) {
            return $this->db->table('cms_users')
                            ->where('email', $email)
                            ->get()
                            ->getRow();
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

    function get_by_menu_url($url) {
        $builder = $this->db->table('site_menu')
                            ->where("menu_url", $url);
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

    public function count_data_list($table, $where = null, $join = null, $group = null)
    {
        $builder = $this->db->table($table);

        if($join != null){
            foreach ($join as $key => $vl) {
                $builder->join($vl['table'],$vl['query'],$vl['type']);
            };
        }
        if ($where) {
            $builder->where($where);
        }
        if ($group) {
            $builder->groupBy($group);
            return count($builder->get()->getResult());
        } else {
            return $builder->countAllResults();
        }
    }

    public function get_vmi_grouped_with_latest_updated($query = null, $limit = 99999, $offset = 0)
    {
        $sql = "
            SELECT *
            FROM (
                SELECT 
                    v.id,
                    c.name AS company,
                    y.year,
                    v.week AS week,
                    v.created_date,
                    v.updated_date,
                    v.year as filter_year,
                    v.week as filter_week,
                    v.company as filter_company,
                    u.name AS imported_by,
                    ROW_NUMBER() OVER (
                        PARTITION BY v.year, v.week, c.name
                        ORDER BY v.updated_date DESC
                    ) AS row_num
                FROM tbl_vmi v
                LEFT JOIN cms_users u ON u.id = v.created_by
                LEFT JOIN tbl_company c ON c.id = v.company
                LEFT JOIN tbl_year y ON y.id = v.year
                " . ($query ? "WHERE $query" : "") . "
            ) t
            WHERE row_num = 1
            LIMIT $offset, $limit
        ";

        return $this->db->query($sql)->getResult();
    }

    public function get_per_store_grouped($query = null, $limit = 99999, $offset = 0)
    {
        $sql = "
            SELECT *
            FROM (
                SELECT 
                    ps.id,
                    ps.year,
                    ps.status,
                    ps.created_date,
                    ps.updated_date,
                    y.year as filter_year,
                    u.name AS imported_by,
                    u.id AS imported_by_id,
                    ROW_NUMBER() OVER (
                        PARTITION BY ps.year, ps.status
                        ORDER BY ps.updated_date DESC
                    ) AS row_num
                FROM tbl_target_sales_per_store ps
                LEFT JOIN cms_users u ON u.id = ps.created_by
                LEFT JOIN tbl_year y ON y.id = ps.year
                " . ($query ? "WHERE $query" : "") . "
            ) t
            WHERE row_num = 1
            LIMIT $offset, $limit
        ";

        return $this->db->query($sql)->getResult();
    }

    function check_db_exist($table, $conditions = [], $limit = 1, $start = 0, $select = "*", $order_field = null, $order_type = 'asc', $join = null, $group = null, $params = [], $useOr = false, $action = null)
    {
        $builder = $this->db->table($table);
        $builder->select($select);

        if (!empty($conditions) && is_array($conditions)) {
            $totalConditions = count($conditions);

            $groupSize = max(1, $totalConditions - 1);
            if($action == "edit"){
                $groupSize = max(1, $totalConditions - 2);
            }
            
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

    function total_delete($table,$field,$where)
    {
        $return = $this->db
                ->table($table)
                ->where($field, $where)
                ->delete();
        if($return):
            return "success";
        else:
            return "failed";
        endif;
        // return "$table,$field,$where";
    }

    public function delete_where($table, $where)
    {
        try {
            return $this->db->table($table)->where($where)->delete();
        } catch (\Exception $e) {
            log_message('error', 'Delete failed: ' . $e->getMessage());
            return false;
        }
    }

    public function update_where($table, $data, array $where)
    {
        try {
            return $this->db->table($table)->where($where)->update($data);
        } catch (\Exception $e) {
            log_message('error', 'Update failed: ' . $e->getMessage());
            return false;
        }
    }

    public function batch_update($table, $data, $primaryKey, $get_code = null, $where_in = null) {
        if (empty($table) || empty($data) || empty($primaryKey) || empty($where_in)) {
            return false; // Return false instead of string for consistency
        }
        // Prepare batch update data and collect updated IDs
        $updateData = [];
        $updatedIds = []; // To store the updated primary keys 

        foreach ($data as $row) {
            if (isset($row[$primaryKey]) && in_array($row[$primaryKey], $where_in)) {
                $updateData[] = $row;

                $entry = ['id' => $row[$primaryKey]];

                // Include 'code' if required
                if ($get_code === true && isset($row['code']) || $get_code == 'true' && isset($row['code'])) {
                    $entry['code'] = $row['code'];
                }

                $updatedIds[] = $entry; // Store unique updated entries
            }
        }

        if (empty($updateData)) {
            return false;
        }

        // Perform batch update
        $result = $this->db->table($table)->updateBatch($updateData, $primaryKey);
        return $result ? $updatedIds : false;
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

    function get_admin(){
        $builder = $this->db->table('cms_users')
                            ->whereIn('status', [1, 2]);
        $query = $builder->get();
        return $query->getResult();
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

    function get_field_values($table, $field, $search_field, $ids)
    {
        if (empty($table) || empty($field) || empty($ids) || !is_array($ids)) {
            return [];
        }

        $query = $this->db->table($table)
                          ->select("id, $field") 
                          ->whereIn($search_field, $ids)
                          ->get();

        $results = [];
        foreach ($query->getResult() as $row) {
            $results[$row->id] = $row->$field;
        }

        return $results;
    }

    function list_existing($table, $selected_fields, $haystack, $needle)
    {
        if (empty($table) || empty($selected_fields)) {
            return ['status' => 'error', 'message' => 'Table or allowed fields are not set.'];
        }

        if (empty($haystack) || empty($needle)) {
            return ['status' => 'error', 'message' => 'Invalid input parameters.'];
        }

        $builder = $this->db->table($table);
        $builder->select($selected_fields);

        // Start dynamic condition building
        $builder->groupStart();
        foreach ($needle as $values) {
            $builder->orGroupStart(); // Start an OR group for each needle set
            foreach ($values as $keyIndex => $value) {
                if (isset($haystack[$keyIndex])) {
                    $builder->orWhere($haystack[$keyIndex], $value);
                    $builder->where('status >=', '0');
                }
            }
            $builder->groupEnd(); // Close OR group
        }
        $builder->groupEnd();

        $query = $builder->get();
        $existingRecords = $query->getResultArray();

        if (!empty($existingRecords)) {
            $filteredRecords = [];
            foreach ($existingRecords as $record) {
                $matchedFields = [];
                foreach ($haystack as $field) {
                    if (isset($record[$field]) && in_array($record[$field], array_column($needle, array_search($field, $haystack)))) {
                        $matchedFields[$field] = $record[$field];
                    }
                }

                if (!empty($matchedFields)) {
                    $filteredRecords[] = $matchedFields;
                }
            }

            if (!empty($filteredRecords)) {
                $errorMessage = '';
                foreach ($filteredRecords as $record) {
                    $errorMessage .= "⚠️ Existing Record Found: ";
                    foreach ($record as $field => $value) {
                        $errorMessage .= "<b>" . ucfirst($field) . ": " . esc($value) . "</b>, ";
                    }
                    $errorMessage = rtrim($errorMessage, ', ') . " ⚠️<br>";
                }

                return [
                    'status' => 'error',
                    'message' => $errorMessage,
                    'existing' => $filteredRecords
                ];
            }
        }
        return ['status' => 'success', 'message' => 'No duplicates found.'];
    }

    public function fetch_existing($table, $selected_fields, $field = null, $value = null, $status = false)
    {
        if (empty($table) || empty($selected_fields)) {
            return [];
        }

        $builder = $this->db->table($table);
        $builder->select($selected_fields);
        if($status == 'true' || $status === true){
            $builder->where('status >=', 0);            
        }

        if($field){
            $builder->where($field, $value);
        }

        return $builder->get()->getResultArray();
    }

    public function fetch_existing_new($table, $selected_fields, $filters = [], $field_filter = null, $field = null, $value = null, $status = false)
    {
        if (empty($table) || empty($selected_fields)) {
            return [];
        }

        $builder = $this->db->table($table);
        $builder->select($selected_fields);

        if ($status == 'true' || $status === true) {
            $builder->where('status >=', 0);            
        }

        if ($field) {
            $builder->where($field, $value);
        }

        if (!empty($filters)) {

            if (count($filters) === count($field_filter)) {
                $conditions = [];
                foreach ($field_filter as $index => $columnName) {
                    $conditions[$columnName] = $filters[$index]; 
                }
                $builder->groupStart()->Where($conditions)->groupEnd();
            }
        }

        $query = $builder->get();

        return $query->getResultArray();
    }


    public function fetch_existing2($table, $selected_fields, $match_fields, $valid_data, $status = false) 
    {
        if (empty($table) || empty($selected_fields) || empty($valid_data) || empty($match_fields)) {
            return [];
        }

        $builder = $this->db->table($table);
        $builder->select(array_merge(['id'], $match_fields));

        if ($status == 'true' || $status === true) {
            $builder->where('status >=', 0);            
        }

        // Use OR conditions to fetch only relevant records
        $builder->groupStart();
        foreach ($valid_data as $row) {
            $conditions = [];
            foreach ($match_fields as $field) {
                $conditions[$field] = $row[$field] ?? '';
            }
            $builder->orWhere($conditions);
        }
        $builder->groupEnd();

        return $builder->get()->getResultArray();
    }
    
    public function fetch_existing_custom($table, $select, $field = null, $value = null, $lookup_field = null)
    {
                $builder = $this->db->table($table);
                $builder->select($select);
                $builder->where($field, $value);
                $query = $builder->get();
                
                // Send back the result
                if ($query->getNumRows() > 0) {
                    $data = $query->getResultArray();
                    return json_encode(['data' => array_column($data, $lookup_field)]);
                } else {
                    return json_encode(['data' => []]);
                }
    }

    public function batch_delete($table, $field, $field_value, $where_in){
        $builder = $this->db->table($table);
        $builder->whereIn($field, $field_value);
        $result = $builder->delete();
        if ($result) {
            return json_encode(['message' => 'success']);
        } else {
            return json_encode(['message' => 'failed']);
        }
    }

    public function batch_delete_with_conditions($table, $conditions) {
        $builder = $this->db->table($table);
        foreach ($conditions as $cond) {
            if (isset($cond['field'], $cond['values']) && is_array($cond['values'])) {
                $builder->whereIn($cond['field'], $cond['values']);
            }
        }

        $result = $builder->delete();

        if ($result) {
            return json_encode(['message' => 'success']);
        } else {
            return json_encode(['message' => 'failed']);
        }
    }

    function get_valid_records($table, $columns) {
        $columns = (array) $columns;

        array_unshift($columns, 'id');

        $results = $this->db->table($table)
            ->select($columns)
            ->where('status', 1)
            ->get()
            ->getResultArray();

        return array_map(function ($row) use ($columns) {
            foreach ($columns as $column) {
                if (isset($row[$column]) && is_string($row[$column])) {
                    $row[$column] = trim($row[$column]);
                }
            }
            return $row;
        }, $results);
    }

    function get_valid_records_tracc_data($table, $column_name, $where = null) {
        $builder = $this->db->table($table)
            ->select(['recid', $column_name, 'itmcde']);
        if (!empty($where)) {
            $builder->groupBy($where);
        }else{
            $builder->where('cusitmcde !=', '');
        }

        $query = $builder->get();
        return $query->getResultArray();
    }


    // ---------------------------------------------------- EXPORT DATA TO EXCEL ----------------------------------------------------
    // ----------------------------------------------------------- Agency -----------------------------------------------------------
    function get_agency_where_in($areaCode) {
        $query = $this->db->query("CALL get_agency_where_in($areaCode)");
        return $query->getResultArray(); // Return data as an array
    }
    function get_agency($areaOffset) {
        $query = $this->db->query("CALL get_agency($areaOffset)");
        return $query->getResultArray(); // Return data as an array
    }
    function get_agency_masterfile_count() {
        $query = $this->db->query("CALL get_agency_masterfile_count()");
        return $query->getResultArray(); // Return data as an array
    }
    // ----------------------------------------------------------- Agency -----------------------------------------------------------
    // ------------------------------------------------------------ Area ------------------------------------------------------------
    function get_area_where_in($areaCode) {
        $query = $this->db->query("CALL get_area_where_in($areaCode)");
        return $query->getResultArray(); // Return data as an array
    }
    function getArea($areaOffset) {
        $query = $this->db->query("CALL SearchDynamic('tbl_area', null, 'id, description', 9999, 0, 'status:EQ=1', 'description', null)");
        return $query->getResultArray(); // Return data as an array
    }
    function get_area_masterfile_count() {
        $query = $this->db->query("CALL get_area_masterfile_count()");
        return $query->getResultArray(); // Return data as an array
    }
    function get_area_stores($areaOffset) {
        $query = $this->db->query("CALL get_area_stores($areaOffset)");
        return $query->getResultArray(); // Return data as an array
    }
    // ------------------------------------------------------------ Area ------------------------------------------------------------
    // --------------------------------------------------- Area Sales Coordinator ---------------------------------------------------
    function get_asc_where_in($ascCode) {
        $query = $this->db->query("CALL get_asc_where_in($ascCode)");
        return $query->getResultArray(); // Return data as an array
    }
    function getAsc($ascOffset) {
        $query = $this->db->query("CALL SearchDynamic('tbl_area_sales_coordinator', null, 'id, description', 9999, 0, 'status:EQ=1', 'description', null)");
        return $query->getResultArray(); // Return data as an array
    }
    function get_asc_masterfile_count() {
        $query = $this->db->query("CALL get_asc_masterfile_count()");
        return $query->getResultArray(); // Return data as an array
    }
    // --------------------------------------------------- Area Sales Coordinator ---------------------------------------------------
    // ------------------------------------------------------ Brand Ambassador ------------------------------------------------------
    function get_brand_ambassador_where_in($brandAmbassadorCode) {
        $query = $this->db->query("CALL get_brand_ambassador_where_in($brandAmbassadorCode)");
        return $query->getResultArray(); // Return data as an array
    }
    function getBrandAmbassador($brandAmbassadorOffset) {
        $select = 'id, CONCAT(code, " - ", name) AS name';
        $query = $this->db->query("CALL SearchDynamic('tbl_brand_ambassador', null, '$select', 9999, 0, 'status:EQ=1', 'name', null)");

        return $query->getResultArray(); // Return data as an array
    }
    function get_brand_ambassador_masterfile_count() {
        $query = $this->db->query("CALL get_brand_ambassador_masterfile_count()");
        return $query->getResultArray(); // Return data as an array
    }
    function get_brand_ambassador_brands($brandAmbassadorOffset) {
        $query = $this->db->query("CALL get_brand_ambassador_brands($brandAmbassadorOffset)");
        return $query->getResultArray(); // Return data as an array
    }
    // ------------------------------------------------------ Brand Ambassador ------------------------------------------------------
    // ------------------------------------------------------- Store / Branch -------------------------------------------------------
    function get_store_branch_where_in($storeBranchCode) {
        $query = $this->db->query("CALL get_store_branch_where_in($storeBranchCode)");
        return $query->getResultArray(); // Return data as an array
    }
    function getStoreBranch($storeBranchOffset) {
        $query = $this->db->query("CALL SearchDynamic('tbl_store', null, 'code AS id, description', 9999, 0, 'status:EQ=1', 'description', null)");
        return $query->getResultArray(); // Return data as an array
    }
    function get_store_branch_masterfile_count() {
        $query = $this->db->query("CALL get_store_branch_masterfile_count()");
        return $query->getResultArray(); // Return data as an array
    }
    // ------------------------------------------------------- Store / Branch -------------------------------------------------------
    // ------------------------------------------------------------ Team ------------------------------------------------------------
    function get_team_where_in($teamCode) {
        $query = $this->db->query("CALL get_team_where_in($teamCode)");
        return $query->getResultArray(); // Return data as an array
    }
    function get_team($teamOffset) {
        $query = $this->db->query("CALL get_team($teamOffset)");
        return $query->getResultArray(); // Return data as an array
    }
    function get_team_masterfile_count() {
        $query = $this->db->query("CALL get_team_masterfile_count()");
        return $query->getResultArray(); // Return data as an array
    }
    // ------------------------------------------------------------ Team ------------------------------------------------------------
    // ------------------------------------------------------- My Magnum Opus -------------------------------------------------------
    // ------------------------------------------------ The one cALL be cALL solution -----------------------------------------------
    // ------------------------------------------------------- Dynamic Search -------------------------------------------------------
    function dynamic_search($tbl_name, $join, $table_fields, $limit, $offset, $conditions, $order, $group) {
        $query = $this->db->query("CALL SearchDynamic($tbl_name, $join, $table_fields, $limit, $offset, $conditions, $order, $group)");
        return $query->getResultArray(); // Return data as an array
    }
    // ------------------------------------------------------- Dynamic Search -------------------------------------------------------
    // ------------------------------------------------ The one cALL be cALL solution -----------------------------------------------
    // ------------------------------------------------------- My Magnum Opus -------------------------------------------------------
    // ---------------------------------------------------- EXPORT DATA TO EXCEL ----------------------------------------------------
    
    function get_vmi($vmiOffset) {
        $query = $this->db->query("CALL get_vmi($vmiOffset)");
        return $query->getResultArray(); // Return data as an array
    }

    function get_vmi_where_in($vmiIds) {
        $query = $this->db->query("CALL get_vmi_where_in($vmiIds)");
        return $query->getResultArray(); // Return data as an array
    }

    function get_vmi_count() {
        $query = $this->db->query("CALL get_vmi_count()");
        return $query->getResultArray(); // Return data as an array
    }

    function get_vmi_data($vmiYear, $vmiMonth, $vmiWeek, $vmiCompany) {
        $query = $this->db->query("CALL get_vmi_data($vmiYear, $vmiMonth, $vmiWeek, $vmiCompany)");
        return $query->getResultArray(); // Return data as an array
    }

    //additional temp
    function getBrandData($order, $limit, $offset) {
        $query = $this->db->query("CALL get_brands('$order', $limit, $offset)");
        return $query->getResultArray(); // Return data as an array
    }

    function get_valid_records_store_group() {
        $results = $this->db->table('tbl_store_group sg')
            ->select('sg.id, sg.area_id, sg.store_id, a.code as area_code')
            ->join('tbl_area a', 'a.id = sg.area_id', 'left')
            ->get()
            ->getResultArray();

        return $results;
    }

    function get_valid_records_store_ba_group() {
        $results = $this->db->table('tbl_brand_ambassador_group bag')
            ->select('bag.id, bag.store_id, bag.brand_ambassador_id as ba_id, ba.code as ba_code')
            ->join('tbl_brand_ambassador ba', 'ba.id = bag.brand_ambassador_id', 'left')
            ->get()
            ->getResultArray();

            return $results;
    }

    function get_valid_records_area_asc_group() {
        $results = $this->db->table('tbl_area a')
            ->select('a.id, a.code, a.description, asc.code as asc_code, asc.id as asc_id, asc.description as asc_description')
            ->join('tbl_area_sales_coordinator asc', 'a.id = asc.area_id', 'left')
            ->get()
            ->getResultArray();

            return $results;
    }

    // function get_valid_records_ba_area_store_brand() {
    //     $builder = $this->db->table('tbl_brand_ambassador ba');
    //     $builder->select("
    //         ba.id,
    //         ba.code,
    //         ba.store AS store_id,
    //         ba.area AS area_id,
    //         ba.name AS ba_name,
    //         s.code AS store_code,
    //         a.code AS area_code,
    //         GROUP_CONCAT(b.brand_description ORDER BY b.brand_description SEPARATOR ', ') AS brands
    //     ");
    //     $builder->where('ba.status', 1);
    //     $builder->join('tbl_ba_brands bba', 'ba.id = bba.ba_id', 'left');
    //     $builder->join('tbl_brand b', 'bba.brand_id = b.id', 'left');
    //     $builder->join('tbl_store s', 'ba.store = s.id', 'left');
    //     $builder->join('tbl_area a', 'ba.area = a.id', 'left');
    //     $builder->groupBy('ba.id');

    //     $results = $builder->get()->getResultArray();

    //     return $results;
    // }

    // function get_valid_records_ba_area_store_brand() {
    //     $builder = $this->db->table('tbl_store_group sg');
    //     $builder->select("
    //         a.id AS area_id,
    //         a.description AS area_name,
    //         a.code AS area_code,
    //         asc.code AS asc_code,
    //         asc.description AS asc_name,
    //         GROUP_CONCAT(DISTINCT s.id ORDER BY s.id SEPARATOR ', ') AS store_id,
    //         GROUP_CONCAT(DISTINCT s.code ORDER BY s.code SEPARATOR ', ') AS store_code,
    //         GROUP_CONCAT(DISTINCT s.description ORDER BY s.description SEPARATOR ', ') AS store_name,
    //         GROUP_CONCAT(DISTINCT b.id ORDER BY b.id SEPARATOR ', ') AS brand_id,
    //         GROUP_CONCAT(DISTINCT b.brand_description ORDER BY b.brand_description SEPARATOR ', ') AS brand_name,
    //         GROUP_CONCAT(DISTINCT
    //             CASE
    //                 WHEN bag.brand_ambassador_id = -5 THEN '-5'
    //                 WHEN bag.brand_ambassador_id = -6 THEN '-6'
    //                 WHEN ba.status = 1 THEN ba.code
    //                 ELSE NULL
    //             END
    //             ORDER BY ba.code SEPARATOR ', '
    //         ) AS brand_ambassador_code,
    //         GROUP_CONCAT(DISTINCT
    //             CASE
    //                 WHEN bag.brand_ambassador_id = -5 THEN 'Vacant'
    //                 WHEN bag.brand_ambassador_id = -6 THEN 'Non BA'
    //                 WHEN ba.status = 1 THEN ba.name
    //                 ELSE NULL
    //             END
    //             ORDER BY ba.name SEPARATOR ', '
    //         ) AS brand_ambassador_name,
    //         GROUP_CONCAT(DISTINCT
    //                 CASE
    //                     WHEN bag.brand_ambassador_id = -5 THEN '-5'
    //                     WHEN bag.brand_ambassador_id = -6 THEN '-6'
    //                     WHEN ba.status = 1 THEN ba.id
    //                     ELSE NULL
    //                 END
    //                 ORDER BY ba.id SEPARATOR ', '
    //             ) AS brand_ambassador_id
    //     ");

    //     $builder->join('tbl_area a', 'a.id = sg.area_id', 'left');
    //     $builder->join('tbl_store s', 's.id = sg.store_id', 'left');
    //     $builder->join('tbl_brand_ambassador_group bag', 'bag.store_id = s.id', 'left');
    //     $builder->join('tbl_brand_ambassador ba', 'ba.id = bag.brand_ambassador_id', 'left');
    //     $builder->join('tbl_ba_brands bba', 'ba.id = bba.ba_id', 'left');
    //     $builder->join('tbl_brand b', 'bba.brand_id = b.id', 'left');
    //     $builder->join('tbl_area_sales_coordinator asc', 'asc.area_id = a.id', 'left');

    //     $builder->where('a.status', 1);
    //     $builder->where('s.status', 1);
    //     $builder->groupStart()
    //         ->where('asc.id IS NULL')
    //         ->orWhere('asc.status', 1)
    //     ->groupEnd();

    //     // Conditional filter: BA must be active if exists (not -5/-6)
    //     // $builder->groupStart()
    //     //     ->where('ba.id IS NULL')
    //     //     ->orWhere('ba.status', 1)
    //     // ->groupEnd();

    //     // Do not filter by ba.status to include -5 and -6

    //     $builder->groupBy('a.code');
    //     //$builder->groupBy('asc.id');

    //     return $builder->get()->getResultArray();
    // }

    function get_valid_records_ba_area_store_brand() {
        $builder = $this->db->table('tbl_store_group sg');
        $builder->select("
            a.id AS area_id,
            a.description AS area_name,
            a.code AS area_code,
            GROUP_CONCAT(DISTINCT CASE WHEN asc.status = 1 THEN asc.id ELSE NULL END SEPARATOR ', ') AS asc_id,
            GROUP_CONCAT(DISTINCT CASE WHEN asc.status = 1 THEN asc.code ELSE NULL END SEPARATOR ', ') AS asc_code,
            GROUP_CONCAT(DISTINCT CASE WHEN asc.status = 1 THEN asc.description ELSE NULL END SEPARATOR ', ') AS asc_name,

            GROUP_CONCAT(DISTINCT CASE WHEN s.status = 1 THEN s.id ELSE NULL END ORDER BY s.id SEPARATOR ', ') AS store_id,
            GROUP_CONCAT(DISTINCT CASE WHEN s.status = 1 THEN s.code ELSE NULL END ORDER BY s.code SEPARATOR ', ') AS store_code,
            GROUP_CONCAT(DISTINCT CASE WHEN s.status = 1 THEN s.description ELSE NULL END ORDER BY s.description SEPARATOR ', ') AS store_name,

            GROUP_CONCAT(DISTINCT b.id ORDER BY b.id SEPARATOR ', ') AS brand_id,
            GROUP_CONCAT(DISTINCT b.brand_description ORDER BY b.brand_description SEPARATOR ', ') AS brand_name,

            GROUP_CONCAT(DISTINCT
                CASE
                    WHEN bag.brand_ambassador_id = -5 THEN '-5'
                    WHEN bag.brand_ambassador_id = -6 THEN '-6'
                    WHEN ba.status = 1 THEN ba.code
                    ELSE NULL
                END
                ORDER BY ba.code SEPARATOR ', '
            ) AS brand_ambassador_code,

            GROUP_CONCAT(DISTINCT
                CASE
                    WHEN bag.brand_ambassador_id = -5 THEN 'Vacant'
                    WHEN bag.brand_ambassador_id = -6 THEN 'Non BA'
                    WHEN ba.status = 1 THEN ba.name
                    ELSE NULL
                END
                ORDER BY ba.name SEPARATOR ', '
            ) AS brand_ambassador_name,

            GROUP_CONCAT(DISTINCT
                CASE
                    WHEN bag.brand_ambassador_id = -5 THEN '-5'
                    WHEN bag.brand_ambassador_id = -6 THEN '-6'
                    WHEN ba.status = 1 THEN ba.id
                    ELSE NULL
                END
                ORDER BY ba.id SEPARATOR ', '
            ) AS brand_ambassador_id
        ");

        $builder->join('tbl_area a', 'a.id = sg.area_id', 'left');
        $builder->join('tbl_store s', 's.id = sg.store_id', 'left');
        $builder->join('tbl_brand_ambassador_group bag', 'bag.store_id = s.id', 'left');
        $builder->join('tbl_brand_ambassador ba', 'ba.id = bag.brand_ambassador_id', 'left');
        $builder->join('tbl_ba_brands bba', 'ba.id = bba.ba_id', 'left');
        $builder->join('tbl_brand b', 'bba.brand_id = b.id', 'left');
        $builder->join('tbl_area_sales_coordinator asc', 'asc.area_id = a.id', 'left');

        $builder->where('a.status', 1);

        $builder->groupBy('a.code');

        return $builder->get()->getResultArray();
    }

    function getWeeks() {
        $query = $this->db->query("CALL get_weeks()");
        return $query->getResultArray(); // Return data as an array
    }

    function getMonths() {
        $query = $this->db->query("CALL get_months()");
        return $query->getResultArray(); // Return data as an array
    }

    function getYears() {
        $query = $this->db->query("CALL SearchDynamic('tbl_year', null, 'id, year', 9999, 0, 'status:EQ=1', 'year', null)");
        return $query->getResultArray(); // Return data as an array
    }

    function getCompanies() {
        $query = $this->db->query("CALL SearchDynamic('tbl_company', null, 'id, name', 9999, 0, 'status:EQ=1', 'name', null)");
        return $query->getResultArray(); // Return data as an array
    }

    function getBrandLabelData() {
        $query = $this->db->query("CALL SearchDynamic('tbl_brand_label_type', null, 'id, label', 9999, 0, null, 'label', null)");
        return $query->getResultArray(); 
    }

    function getItemClassification() {
        $query = $this->db->query("CALL SearchDynamic('tbl_classification', null, 'id, item_class_code, item_class_description', 9999, 0, 'status:EQ=1', 'item_class_code', null)");
        return $query->getResultArray(); 
    }

    function get_item_class_counts() {
        $query = $this->db->query("CALL Get_Item_Class_Counts()");
        return $query->getResultArray();
    }

    // public function fetch_temp_data($limit, $page, $year, $month, $week, $company, $id)
    public function fetch_temp_data($limit, $page, $year, $week, $company, $id)
    {
        if ($page == 0) {
            $offset = 0;
        } else {
            $offset = ($page - 1) * $limit;
        }

        $baseQuery = $this->db->table('tbl_temp_vmi')
                      ->where('year', $year)
                    //   ->where('month', $month)
                      ->where('week', $week)
                      ->where('company', $company)
                      ->where('created_by', $id);

        $totalRecords = $baseQuery->countAllResults(false);

        $data = $baseQuery->limit($limit, $offset)->get()->getResultArray();

        return [
            "data" => $data,
            "totalRecords" => $totalRecords
        ];
    }

    public function delete_temp_vmi($id)
    {
        $builder = $this->db->table('tbl_temp_vmi');

        $builder->where('created_by', $id);
        $deleted = $builder->delete();

        if ($deleted) {
            return 'success';
        } else {
            return 'failed';
        }
    }

    public function fetch_scan_data($limit, $page, $filename, $id)
    {
        $offset = ($page - 1) * $limit;

        $builder = $this->db->table('tbl_sell_out_temp_space')
                      ->where('file_name', $filename)
                      ->where('created_by', $id)
                      ->orderBy('id', 'ASC')
                      ->limit($limit, $offset)
                      ->get();

        $data = $builder->getResultArray();

        $totalRecords = $this->db->table('tbl_sell_out_temp_space')
                          ->where('file_name', $filename)
                          ->where('created_by', $id)
                          ->countAllResults();

        return [
            "data" => $data,
            "totalRecords" => $totalRecords
        ];
    }

    public function delete_temp_scan($id, $filename)
    {
        $builder = $this->db->table('tbl_sell_out_temp_space');
        $builder->where('created_by', $id);
        $builder->where('file_name', $filename);
        
        $deleted = $builder->delete();

        if ($deleted) {
            return 'success';
        } else {
            return 'failed';
        }
    }

    public function fetch_last_ba_code($table, $field) {
        try {
            $query = $this->db->query("SELECT $field FROM $table ORDER BY id DESC LIMIT 1");
            $result = $query->getRow();
            return $result ? $result->$field : null;
        } catch (Exception $e) {
            return "failed";
        }
    }

    // ----------==========|| week on week scan data ||==========----------
    public function fetch_wkonwk_data($limit, $page, $filename, $id, $year, $week)
    {
        $offset = ($page - 1) * $limit;

        $builder = $this->db->table('tbl_wkonwk_temp_space')
                      ->where('file_name', $filename)
                      ->where('created_by', $id)
                      ->where('year', $year)
                      ->where('week', $week)
                      ->orderBy('id', 'ASC')
                      ->limit($limit, $offset)
                      ->get();

        $data = $builder->getResultArray();

        $totalRecords = $this->db->table('tbl_wkonwk_temp_space')
                          ->where('file_name', $filename)
                          ->where('created_by', $id)
                          ->where('year', $year)
                          ->where('week', $week)
                          ->countAllResults();

        return [
            "data" => $data,
            "totalRecords" => $totalRecords
        ];
    }

    public function delete_temp_wkonwk($id, $filename, $year, $week)
    {
        $builder = $this->db->table('tbl_wkonwk_temp_space');
        $builder->where('created_by', $id);
        $builder->where('file_name', $filename);
        $builder->where('year', $year);
        $builder->where('week', $week);
        
        $deleted = $builder->delete();

        if ($deleted) {
            return 'success';
        } else {
            return 'failed';
        }
    }

    function get_data(
        string $table,
        array $query = null,
        int $limit = 1,
        int $start = 0,
        string $select = '*',
        string $order_field = null,
        string $order_type = 'ASC',
        array $join = null,
        string|array $group = null
    ) {
        $builder = $this->db->table($table);
        $builder->select($select);

        if (!empty($query)) {
            $builder->where($query);
        }

        if (!empty($join)) {
            foreach ($join as $j) {
                if (isset($j['table'], $j['query'], $j['type'])) {
                    $builder->join($j['table'], $j['query'], $j['type']);
                }
            }
        }

        if (!empty($order_field)) {
            $safe_order_type = strtoupper($order_type) === 'DESC' ? 'DESC' : 'ASC';
            $builder->orderBy($order_field, $safe_order_type);
        }

        if (!empty($group)) {
            $builder->groupBy($group);
        }

        $builder->limit($limit, $start);

        $q = $builder->get();
        return $q->getResult();
    }

}


