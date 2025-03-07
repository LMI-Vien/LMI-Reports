<?php

namespace App\Controllers\Cms;
use \DateTime;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Global_controller extends BaseController
{
    public function index()
	{
		switch ($_POST['event']) { 

			case 'list_pagination':
					try { 
						$query = $_POST['query'];
						$table = $_POST['table']; 
						$select =  $_POST['select'];

						if(strpos($select, '*') !== false){
							$data = array('message' => "Asterisk is not allowed!");
							echo json_encode($data);
							break;
						}

						$limit = isset($_POST['limit'])? $_POST['limit'] : 99999;
						$offset = isset($_POST['offset'])? $_POST['offset'] : 1;
						$order_field = isset($_POST['order']['field'])? $_POST['order']['field'] : null;
						$order_type = isset($_POST['order']['order']) ? $_POST['order']['order']: null;
						$join = isset($_POST['join']) ? $_POST['join']: null;
						$group= isset($_POST['group']) ? $_POST['group']: null;

						$result_data_list = $this->Global_model->get_data_list($table, $query, $limit, ($offset - 1) * $limit, $select,$order_field,$order_type, $join, $group);
						$count_data = $this->Global_model->get_data_list($table, $query,null, null, $select,$order_field,$order_type, $join, $group);
						$result_data_pagination = $this->Global_model->get_data_list_count($select,$table, $query ,$offset, $join);
						
						$result_return_pagination= array(
							"total_record"=> $result_data_pagination,
							"total_page"=> $result_data_pagination>$limit ? ceil($result_data_pagination / $limit) : 0
						);
						
						$result_return = array (
							"list" => $result_data_list,
							"pagination" => $result_return_pagination,
							"total_data" => count($count_data)
						);
						
						echo json_encode($result_return);
					} catch (Error $e) {
						echo "Error displaying a list from database: " . $e->getMessage();
					}
				break;
				
			case 'list':
				try {
					$query = $_POST['query'];
					$table = $_POST['table']; 
					$select =  $_POST['select'];
					$isChangePassword = isset($_POST['isChangePassword']) ? $_POST['isChangePassword'] : "false";
					$users_table = array("cms_users", "cms_historical_passwords");

					if (in_array($table, $users_table) && $isChangePassword == "true") {
						$salt = $this->Global_model->get_password_salt($_POST['id']);
						$password = hash("sha256", $_POST['password']);
						$salted_password = hash("sha256", $password.$salt);

						if ($table == "cms_historical_passwords") {
							$query = "user_id = ". $_POST['id'] ." and password = '". $salted_password ."'";
						} else {
							$query = "id = ". $_POST['id'] ." and password = '". $salted_password ."'";
						}						
					}

					if(strpos($select, '*') !== false){
						$data = array('message' => "Asterisk is not allowed!");
						echo json_encode($data);
						break;
					}

					$limit = isset($_POST['limit'])? $_POST['limit'] : 99999;
					$offset = isset($_POST['offset'])? $_POST['offset'] : 1;
					$order_field = isset($_POST['order']['field'])? $_POST['order']['field'] : null;
					$order_type = isset($_POST['order']['order']) ? $_POST['order']['order']: null;
					$join = isset($_POST['join']) ? $_POST['join']: null;
					$group= isset($_POST['group']) ? $_POST['group']: null;

					$result_data = $this->Global_model->get_data_list($table, $query, $limit, ($offset - 1) * $limit, $select,$order_field,$order_type, $join, $group);

			        echo json_encode($result_data);
			    } catch (Error $e) {
	        		echo "Error displaying a list from database: " . $e->getMessage();
				}
			break;
			case 'check_db_exist':
			    try {
			        $table = $_POST['table']; 
			        $select = $_POST['select'];
			        $limit = isset($_POST['limit']) ? $_POST['limit'] : 99999;
			        $offset = isset($_POST['offset']) ? $_POST['offset'] : 1;
			        $order_field = isset($_POST['order']['field']) ? $_POST['order']['field'] : null;
			        $order_type = isset($_POST['order']['order']) ? $_POST['order']['order'] : null;
			        $join = isset($_POST['join']) ? $_POST['join'] : null;
			        $group = isset($_POST['group']) ? $_POST['group'] : null;
			        $use_or = $_POST['use_or']; 
			        $action = $_POST['action']; 

			        if (strpos($select, '*') !== false) {
			            echo json_encode(['message' => "Asterisk is not allowed!"]);
			            break;
			        }
			        $conditions = [];
			        if (!empty($_POST['query'])) {
			            $conditions = $_POST['query'];
			        }

			        if (isset($_POST['params'])) {
			            $params = $_POST['params'];
			        } else {
			            $params = [];
			        }

			        $result_data = $this->Global_model->check_db_exist($table, $conditions, $limit, ($offset - 1) * $limit, $select, $order_field, $order_type, $join, $group, $params, $use_or, $action);
			        echo json_encode($result_data);

			    } catch (Error $e) {
			        echo json_encode(["error" => "Error displaying a list from database: " . $e->getMessage()]);
			    }
			    break;
			case 'get_field_values':
					try {
						$table = $this->request->getPost('table');
						$select = $this->request->getPost('select');
						$search_field = $this->request->getPost('search_field');
						$ids = $this->request->getPost('ids');
	
						$result_data = $this->Global_model->get_field_values($table, $select, $search_field, $ids);
						echo json_encode($result_data);
					} catch (Error $e) {
						echo json_encode(["error" => "Error getting a data from database: " . $e->getMessage()]);
					}
					break;
			case 'list_existing':
					try {
						$table = $this->request->getPost('table');
						$selected_fields = $this->request->getPost('selected_fields');
						$haystack = $this->request->getPost('haystack');
						$needle = $this->request->getPost('needle');
	
						$result_data = $this->Global_model->list_existing($table, $selected_fields, $haystack, $needle);
						echo json_encode($result_data);
					} catch (Error $e) {
						echo json_encode(["error" => "Error getting a data from database: " . $e->getMessage()]);
					}
					break;
			// ---------------------------------------------------- EXPORT DATA TO EXCEL ----------------------------------------------------
			// ----------------------------------------------------------- Agency -----------------------------------------------------------
			case 'get_agency_where_in':
				try {
					$agencyCode = $this->request->getPost('agency_codes');
					$result_data = $this->Global_model->get_agency_where_in($agencyCode);
					echo json_encode($result_data);
				} catch (Error $e) {
					echo json_encode(["error" => "Error getting a data from database: " . $e->getMessage()]);
				}
				break;
			case 'get_agency':
				try {
					$agencyOffset = $this->request->getPost('agency_offset');
					$result_data = $this->Global_model->get_agency($agencyOffset);
					echo json_encode($result_data);
				} catch (Error $e) {
					echo json_encode(["error" => "Error getting a data from database: " . $e->getMessage()]);
				}
				break;
			case 'get_agency_count':
				try {
					$result_data = $this->Global_model->get_agency_masterfile_count();
					echo json_encode($result_data);
				} catch (Error $e) {
					echo json_encode(["error" => "Error getting a data from database: " . $e->getMessage()]);
				}
				break;
			// ----------------------------------------------------------- Agency -----------------------------------------------------------
			// ------------------------------------------------------------ Area ------------------------------------------------------------
			case 'get_area_where_in':
				try {
					$areaCode = $this->request->getPost('area_codes');
					$result_data = $this->Global_model->get_area_where_in($areaCode);
					echo json_encode($result_data);
				} catch (Error $e) {
					echo json_encode(["error" => "Error getting a data from database: " . $e->getMessage()]);
				}
				break;
			case 'get_area':
				try {
					$areaOffset = $this->request->getPost('area_offset');
					$result_data = $this->Global_model->get_area($areaOffset);
					echo json_encode($result_data);
				} catch (Error $e) {
					echo json_encode(["error" => "Error getting a data from database: " . $e->getMessage()]);
				}
				break;
			case 'get_area_count':
				try {
					$result_data = $this->Global_model->get_area_masterfile_count();
					echo json_encode($result_data);
				} catch (Error $e) {
					echo json_encode(["error" => "Error getting a data from database: " . $e->getMessage()]);
				}
				break;
			case 'get_area_stores':
				try {
					$areaOffset = $this->request->getPost('area_offset');
					$result_data = $this->Global_model->get_area_stores($areaOffset);
					echo json_encode($result_data);
				} catch (Error $e) {
					echo json_encode(["error" => "Error getting a data from database: " . $e->getMessage()]);
				}
				break;
			// ------------------------------------------------------------ Area ------------------------------------------------------------
			// --------------------------------------------------- Area Sales Coordinator ---------------------------------------------------
			case 'get_asc_where_in':
				try {
					$ascCode = $this->request->getPost('asc_codes');
					$result_data = $this->Global_model->get_asc_where_in($ascCode);
					echo json_encode($result_data);
				} catch (Error $e) {
					echo json_encode(["error" => "Error getting a data from database: " . $e->getMessage()]);
				}
				break;
			case 'get_asc':
				try {
					$ascOffset = $this->request->getPost('asc_offset');
					$result_data = $this->Global_model->get_asc($ascOffset);
					echo json_encode($result_data);
				} catch (Error $e) {
					echo json_encode(["error" => "Error getting a data from database: " . $e->getMessage()]);
				}
				break;
			case 'get_asc_count':
				try {
					$result_data = $this->Global_model->get_asc_masterfile_count();
					echo json_encode($result_data);
				} catch (Error $e) {
					echo json_encode(["error" => "Error getting a data from database: " . $e->getMessage()]);
				}
				break;
			// --------------------------------------------------- Area Sales Coordinator ---------------------------------------------------
			// ------------------------------------------------------ Brand Ambassador ------------------------------------------------------
			case 'get_brand_ambassador_where_in':
				try {
					$brandAmbassadorCode = $this->request->getPost('brand_ambassador_codes');
					$result_data = $this->Global_model->get_brand_ambassador_where_in($brandAmbassadorCode);
					echo json_encode($result_data);
				} catch (Error $e) {
					echo json_encode(["error" => "Error getting a data from database: " . $e->getMessage()]);
				}
				break;
			case 'get_brand_ambassador':
				try {
					$brandAmbassadorOffset = $this->request->getPost('brand_ambassador_offset');
					$result_data = $this->Global_model->get_brand_ambassador($brandAmbassadorOffset);
					echo json_encode($result_data);
				} catch (Error $e) {
					echo json_encode(["error" => "Error getting a data from database: " . $e->getMessage()]);
				}
				break;
			case 'get_brand_ambassador_count':
				try {
					$result_data = $this->Global_model->get_brand_ambassador_masterfile_count();
					echo json_encode($result_data);
				} catch (Error $e) {
					echo json_encode(["error" => "Error getting a data from database: " . $e->getMessage()]);
				}
				break;
			case 'get_brand_ambassador_brands':
				try {
					$brandAmbassadorOffset = $this->request->getPost('brand_ambassador_offset');
					$result_data = $this->Global_model->get_brand_ambassador_brands($brandAmbassadorOffset);
					echo json_encode($result_data);
				} catch (Error $e) {
					echo json_encode(["error" => "Error getting a data from database: " . $e->getMessage()]);
				}
				break;
			// ------------------------------------------------------ Brand Ambassador ------------------------------------------------------
			// ------------------------------------------------------- Store / Branch -------------------------------------------------------
			case 'get_store_branch_where_in':
				try {
					$storeBranchCode = $this->request->getPost('store_branch_codes');
					$result_data = $this->Global_model->get_store_branch_where_in($storeBranchCode);
					echo json_encode($result_data);
				} catch (Error $e) {
					echo json_encode(["error" => "Error getting a data from database: " . $e->getMessage()]);
				}
				break;
			case 'get_store_branch':
				try {
					$storeBranchOffset = $this->request->getPost('store_branch_offset');
					$result_data = $this->Global_model->get_store_branch($storeBranchOffset);
					echo json_encode($result_data);
				} catch (Error $e) {
					echo json_encode(["error" => "Error getting a data from database: " . $e->getMessage()]);
				}
				break;
			case 'get_store_branch_count':
				try {
					$result_data = $this->Global_model->get_store_branch_masterfile_count();
					echo json_encode($result_data);
				} catch (Error $e) {
					echo json_encode(["error" => "Error getting a data from database: " . $e->getMessage()]);
				}
				break;
			// ------------------------------------------------------- Store / Branch -------------------------------------------------------
			// ------------------------------------------------------------ Team ------------------------------------------------------------
			case 'get_team_where_in':
				try {
					$teamCode = $this->request->getPost('team_codes');
					$result_data = $this->Global_model->get_team_where_in($teamCode);
					echo json_encode($result_data);
				} catch (Error $e) {
					echo json_encode(["error" => "Error getting a data from database: " . $e->getMessage()]);
				}
				break;
			case 'get_team':
				try {
					$teamOffset = $this->request->getPost('team_offset');
					$result_data = $this->Global_model->get_team($teamOffset);
					echo json_encode($result_data);
				} catch (Error $e) {
					echo json_encode(["error" => "Error getting a data from database: " . $e->getMessage()]);
				}
				break;
			case 'get_team_count':
				try {
					$result_data = $this->Global_model->get_team_masterfile_count();
					echo json_encode($result_data);
				} catch (Error $e) {
					echo json_encode(["error" => "Error getting a data from database: " . $e->getMessage()]);
				}
				break;
			// ------------------------------------------------------------ Team ------------------------------------------------------------
			// ------------------------------------------------------- My Magnum Opus -------------------------------------------------------
			// ------------------------------------------------ The one cALL be cALL solution -----------------------------------------------
			// ------------------------------------------------------- Dynamic Search -------------------------------------------------------
			case 'dynamic_search':
				try {
					$tbl_name = $this->request->getPost('tbl_name');
					$table_fields = $this->request->getPost('table_fields');
					$join = $this->request->getPost('join');
					$limit = $this->request->getPost('limit');
					$offset = $this->request->getPost('offset');
					$conditions = $this->request->getPost('conditions');
					$order = $this->request->getPost('order');
					$group = $this->request->getPost('group');
					$result_data = $this->Global_model->dynamic_search($tbl_name, $join, $table_fields, $limit, $offset, $conditions, $order, $group);
					echo json_encode($result_data);
				} catch (Error $e) {
					echo json_encode(["error" => "Error getting a data from database: " . $e->getMessage()]);
				}
				break;
			// ------------------------------------------------------- Dynamic Search -------------------------------------------------------
			// ------------------------------------------------ The one cALL be cALL solution -----------------------------------------------
			// ------------------------------------------------------- My Magnum Opus -------------------------------------------------------
			// ---------------------------------------------------- EXPORT DATA TO EXCEL ----------------------------------------------------
			
			case 'fetch_existing':
			    try {
			        $table = $this->request->getPost('table');
			        $selected_fields = $this->request->getPost('selected_fields');
			        $field = $this->request->getPost('field') ?: null;
			        $value = $this->request->getPost('value') ?: null;
			        $status = $this->request->getPost('status') ?: false;
			        if (empty($table) || empty($selected_fields)) {
			            echo json_encode(['status' => 'error', 'message' => 'Table or selected fields are missing.']);
			            exit;
			        }

			        $result_data = $this->Global_model->fetch_existing($table, $selected_fields, $field, $value, $status);
			        echo json_encode(['status' => 'success', 'existing' => $result_data]);
			    } catch (Exception $e) {
			        echo json_encode(['status' => 'error', 'message' => 'Error fetching data: ' . $e->getMessage()]);
			    }
			    break; 
			case 'fetch_existing_custom':    
		    try {
		        // Get the ba_id from the post request
		        //$ba_id = $this->request->getPost('ba_id');
 				$table = $this->request->getPost('table');
			    $select = $this->request->getPost('select');
			    $field = $this->request->getPost('field');
			    $value = $this->request->getPost('value');
			    $lookup_field = $this->request->getPost('lookup_field');
		        

		        $result_data = $this->Global_model->fetch_existing_custom($table, $select, $field, $value, $lookup_field);
		        echo $result_data;
		    } catch (Exception $e) {
		        echo json_encode(['error' => $e->getMessage()]);
		    }
		    break;
			case 'insert':
				try { 
					$table = $_POST['table'];
					$data = $_POST['data'];


					$id = $this->Global_model->save_data($table,$data);
					$this->audit_trail_controller("Create", $data);
					echo json_encode(["ID" => $id]);
				} catch (Exception $e) {
	        		echo "Error adding data: " . $e->getMessage();
				}
			break;

			case 'update':
				try { 
					$table = $_POST['table'];
					$field = $_POST['field'];
					$where = $_POST['where'];
					$data = $_POST['data'];
	
					//get old data for audit trail
					$query = $field . " = " . $where;
					$old_data = $this->Global_model->get_data_list($table, $query, 1, 0, "*" ,null,null,null);
					
					//update new data
					$status = $this->Global_model->update_data($table,$data,$field,$where);
					echo $status;	

					//insert audit trail	 
	                if(isset($data['status'])){
	                    if($data['status'] == -2){
	                        $this->audit_trail_controller("Delete", $data, $old_data);    
	                    } else {
	                        $this->audit_trail_controller("Update", $data, $old_data);
	                    }
	                } else {
	                	$this->audit_trail_controller("Update", $data, $old_data);
	                }
	            } catch (Exception $e) {
	        		echo "Error updating data: " . $e->getMessage();
				}
			break;

			case 'total_delete':
			try { 
				$table = $_POST['table'];
				$field = $_POST['field'];
				$where = $_POST['where'];

				// echo json_encode(['debug' => "$table,$field,$where"]);

				// Get old data for audit trail before deletion
				$query = "$field = '$where'";
				$old_data = $this->Global_model->get_data_list($table, $query, 1, 0, "*", null, null, null);

				// Perform delete operation
				$status = $this->Global_model->total_delete($table, $field, $where);
				echo $status;

				// Insert audit trail for deletion
				$this->audit_trail_controller("Delete", null, $old_data);
			} catch (Exception $e) {
				echo "Error deleting data: " . $e->getMessage();
			}
			break;
			case 'batch_delete':
			    try {

			    	$table = $this->request->getPost('table');
			        $field = $this->request->getPost('field');
			        $field_value = $this->request->getPost('field_value');
			        $where_in = $this->request->getPost('where_in');

			        $result_data = $this->Global_model->batch_delete($table, $field, $field_value, $where_in);
		        	echo $result_data;
			    } catch (Exception $e) {
			        echo json_encode(['error' => $e->getMessage()]);
			    }
			break;
			case 'batch_sort_update':
			try { 	
				$table = $_POST['table'];
				$field = $_POST['field'];
				$datas = $_POST['data'];
				
                foreach ($datas as $key) {
					$where = $key['id'];
					$data =  $key['sort_order'];
					//update new data
					$status = $this->Global_model->batch_sort_update_data($table,$data,$field,$where);
					echo $data . '<br>';
				}

				echo $status;	
				
				
			} catch (Exception $e) {
				echo "Error updating data: " . $e->getMessage();
			}
			break;

			case 'delete':
				try { 
					$table = $_POST['table'];
					$id = "";
					$old_data = "";

					if(isset($_POST['site_id'])) {
						$id = $_POST['site_id'];
						$status = $this->Global_model->tagging_delete_data($table,$id);
					}
					else {
						$id = $_POST['id'];
						//get old data for audit trail
						$query = "id = " . $id;
						$old_data = $this->Global_model->get_data_list($table, $query, 1, 0, "*" ,null,null,null);
						//delete data
						$status = $this->Global_model->delete_data($table,$id);
					}
					echo $status;

					if($old_data)
					{ //deletion of tagging data will not log in audit trail - chan
						$this->audit_trail_controller("Remove", null, $old_data);
					}
				} catch (Exception $e) {
	        		echo "Error deleting data: " . $e->getMessage();
				}
			break;

			case 'pagination':
				$query = $_POST['query'];
				$table = $_POST['table'];
				$select =  $_POST['select'];

				if(strpos($select, '*') !== false){
					$data = array('message' => "Asterisk is not allowed!");
					echo json_encode($data);
					break;
				}
				
				$limit = isset($_POST['limit'])? $_POST['limit'] : 99999;
				$offset = 1;
				$order_field = isset($_POST['order']['field'])? $_POST['order']['field'] : null;
				$order_type = isset($_POST['order']['order']) ? $_POST['order']['order']: null;
				$join = isset($_POST['join']) ? $_POST['join']: null;

				$result_data = $this->Global_model->get_data_list($table, $query, 9999999, ($offset - 1) * 9999999, $select,$order_field,$order_type, $join);
				$result_return = array(
					"total_record"=> count($result_data),
					"total_page"=>ceil(count($result_data) / $limit)
				);

				echo json_encode($result_return);
				break;

			case 'batch_insert':
			    try {
			        $table = $this->request->getPost('table');
			        $insertBatchData = $this->request->getPost('insert_batch_data');
			        $get_code = $this->request->getPost('get_code');//true or false lang pang return ng code 

			        if (empty($table) || empty($insertBatchData)) {
			            return $this->response->setJSON([
			                "message" => "Table name or data is missing"
			            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
			        }

			        // Perform batch insert and get the number of inserted rows
			        $insertedCount = $this->Custom_model->batch_insert($table, $insertBatchData, $get_code);

			        if ($insertedCount === false) {
			            return $this->response->setJSON([
			                "message" => "Database insert failed"
			            ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
			        }
					if (is_array($insertedCount)) {
					    $message = 'success';
					} else {
					    $message = 'error';
					}
			        return $this->response->setJSON([
			            "message" => $message,
			            "inserted" => $insertedCount
			        ]);

			    } catch (Exception $e) {
			        return $this->response->setJSON([
			            "message" => "Error updating data: " . $e->getMessage()
			        ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
			    }

					break;

			case 'get_last_inserted_code':
		        try {
		            // Fetch the last inserted code
		          //  $table = $this->request->getPost('table');
		            $lastCode = $this->Custom_model->get_last_inserted_code('tbl_area_sales_coordinator');

		            return $this->response->setJSON([
		                'message' => 'success',
		                'last_code' => $lastCode
		            ]);
		        } catch (\Exception $e) {
		            return $this->response->setJSON([
		                'message' => 'error',
		                'error' => $e->getMessage()
		            ]);
		        }

					break;
			case 'batch_update':
			    try { 
			        $table = $this->request->getPost('table');
			        $primaryKey = $this->request->getPost('field');
			        $where_in = $this->request->getPost('where_in');
			        $data = $this->request->getPost('data');
			        $get_code = $this->request->getPost('get_code');

			        if (empty($table) || empty($primaryKey) || empty($where_in) || empty($data)) {
			            return $this->response->setJSON(['message' => 'error', 'error' => 'Invalid request data']);
			        }

			        // Perform batch update
			        $status = $this->Global_model->batch_update($table, $data, $primaryKey, $get_code, $where_in);
			        
			        // Send response
					if ($status !== "failed" && !empty($status)) {
					    echo json_encode(['message' => 'success', 'inserted_ids' => $status]);
					} else {
					    echo json_encode(['message' => 'error', 'error' => 'Update failed']);
					}
			    } catch (Exception $e) {
			        echo json_encode(['message' => 'error', 'error' => $e->getMessage()]);
			    }
			    break;
		
		}
		
	}

	public function audit_trail_controller($action, $new_data = null, $old_data = null)
	{
		$session = session();
		$data2['site_id'] = isset($new_data['site_id'])?$new_data['site_id']:null;
	    $data2['user_id'] = $session->sess_uid;
	  	$data2['url'] =str_replace(base_url("cms") . '/', "", $_SERVER['HTTP_REFERER']); ;
	  	$data2['action'] = strip_tags(ucwords($action));
	  	if($new_data != null){
	  		$data2['new_data'] = json_encode($new_data);
	  	}

	  	if($old_data != null){
	  		$data2['old_data'] = json_encode($old_data);
	  	}
	  	
	  	$data2['created_date'] = date('Y-m-d H:i:s'); 
	  	$this->Global_model->save_data('cms_audit_trail',$data2);
	}

	public function audit_trail()
	{
	    $data['user_id'] = $session->sess_uid;
	  	$data['url'] =str_replace(base_url("cms") . '/', "", rtrim($_POST['uri'],"#")); ;
	  	$data['action'] = strip_tags(ucwords($_POST['action']));
	  	$data['created_date'] = date('Y-m-d H:i:s'); 
	  	$table = 'cms_audit_trail';
	  	$this->Global_model->save_data($table,$data);
	}
}
