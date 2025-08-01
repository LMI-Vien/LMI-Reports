<?php

namespace App\Controllers\Cms;
use \DateTime;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class GlobalController extends BaseController
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
						if($offset == 0){
							$offset = 1;
						}
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

					// if ($table === 'tbl_vmi_grouped') {
					//     $result_data_list = $this->Global_model->get_vmi_grouped_with_latest_updated($query, $limit, ($offset - 1) * $limit);
					//     $total_count = $this->Global_model->count_vmi_grouped_with_latest_updated($query);

					//     $total_pages = $total_count > $limit ? ceil($total_count / $limit) : 1;

					//     $result_return_pagination = array(
					//         "total_record" => $total_count,
					//         "total_page"   => $total_pages
					//     );

					//     $result_return = array(
					//         "list" => $result_data_list,
					//         "pagination" => $result_return_pagination,
					//         "total_data" => count($result_data_list)
					//     );

					//     echo json_encode($result_return);
					//     break;
					// }

					if ($table === 'tbl_sales_per_store_grouped') {
					    $result_data = $this->Global_model->get_per_store_grouped($query, $limit, ($offset - 1) * $limit);
					    echo json_encode($result_data);
					    break;
					}

					$result_data = $this->Global_model->get_data_list($table, $query, $limit, ($offset - 1) * $limit, $select,$order_field,$order_type, $join, $group);

			        echo json_encode($result_data);
			    } catch (Error $e) {
	        		echo "Error displaying a list from database: " . $e->getMessage();
				}
			break;
			case 'list2':
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
					// print_r($limit);
					// die();
					$order_field = isset($_POST['order']['field'])? $_POST['order']['field'] : null;
					$order_type = isset($_POST['order']['order']) ? $_POST['order']['order']: null;
					$join = isset($_POST['join']) ? $_POST['join']: null;
					$group= isset($_POST['group']) ? $_POST['group']: null;

					if ($table === 'tbl_vmi_grouped') {
					    $result_data = $this->Global_model->get_vmi_grouped_with_latest_updated($query, $limit, ($offset - 1) * $limit);
					    echo json_encode($result_data);
					    break;
					}
					if ($table === 'tbl_sales_per_store_grouped') {
					    $result_data = $this->Global_model->get_per_store_grouped($query, $limit, ($offset - 1) * $limit);
					    echo json_encode($result_data);
					    break;
					}

					$result_data = $this->Global_model->get_data_list($table, $query, $limit, ($offset - 1) * $limit, $select,$order_field,$order_type, $join, $group);
					$total = $this->Global_model->count_data_list($table, $query, $join, $group);

			        //echo json_encode($result_data);
			        echo json_encode([
						'data' => $result_data,
						'total_records' => $total
					]);
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
			case 'get_item_class_counts':
				try {
					$result_data = $this->Global_model->get_item_class_counts();
					echo json_encode($result_data);
				} catch (Error $e) {
					echo json_encode(["error" => "Error getting a data from database: " . $e->getMessage()]);
				}
				break;
				
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
			case 'fetch_existing_new':
			    try {
			        $table = $this->request->getPost('table');
			        $selected_fields = $this->request->getPost('selected_fields');
			        $filters = $this->request->getPost('filters');
			        $field = $this->request->getPost('field') ?: null;
			        $value = $this->request->getPost('value') ?: null;
			        $status = $this->request->getPost('status') ?: false;

			        $field_filter = [];
			        if($table == "tbl_vmi"){
			        	// $field_filter = ['year', 'month', 'week', 'company'];
			        	$field_filter = ['year', 'week', 'company'];
			        }else if ($table == "tbl_sell_out_data_details"){
			        	$field_filter = ['year', 'month'];
			        } else if($table == "tbl_week_on_week_details") {
						$field_filter = ['year', 'week'];
					}
            		
			        if (empty($table) || empty($selected_fields)) {
			            echo json_encode(['status' => 'error', 'message' => 'Table or selected fields are missing.']);
			            exit;
			        }

			        $result_data = $this->Global_model->fetch_existing_new($table, $selected_fields, $filters, $field_filter, $field, $value, $status);
			        echo json_encode(['status' => 'success', 'existing' => $result_data]);
			    } catch (\Exception $e) {
			        echo json_encode(['status' => 'error', 'message' => 'Error fetching data: ' . $e->getMessage()]);
			    }
			    break;
			    //for optimization do not remove
			case 'fetch_existing2':
			    try {
			        $table = $this->request->getPost('table');
			        $selected_fields = $this->request->getPost('selected_fields');
			        $valid_data = $this->request->getPost('valid_data');
			        $status = $this->request->getPost('status') ?? false;

			        $matchFields = [
			            'store', 'item', 'item_name', 'vmi_status', 'item_class', 'supplier',
			            'c_group', 'dept', 'c_class', 'sub_class', 'on_hand', 'in_transit',
			            'year', 'month', 'week', 'company'
			        ];

			        if (empty($table) || empty($selected_fields) || empty($valid_data)) {
			            return $this->response->setJSON([
			                'status' => 'error',
			                'message' => 'Missing parameters.'
			            ]);
			        }

			        // Fetch only relevant existing records by passing the match fields & valid data
			        $result_data = $this->Global_model->fetch_existing2($table, $selected_fields, $matchFields, $valid_data, $status);

			        return $this->response->setJSON([
			            'status' => 'success',
			            'existing' => $result_data
			        ]);
			    } catch (Exception $e) {
			        return $this->response->setJSON([
			            'status' => 'error',
			            'message' => 'Error fetching data: ' . $e->getMessage()
			        ]);
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
				    $conditions = $_POST['conditions'];

				    if (!is_array($conditions) || empty($conditions)) {
				        throw new Exception("Invalid or missing conditions.");
				    }

				    $queryParts = [];
				    foreach ($conditions as $field => $value) {
				        $escapedField = $this->db->escapeString($field);
				        $escapedValue = $this->db->escape($value);
				        $queryParts[] = "$escapedField = $escapedValue";
				    }
				    $query = implode(" AND ", $queryParts);

				    $old_data = $this->Global_model->get_data_list($table, $query, 1, 0, "*", null, null, null);

				    $status = $this->Global_model->delete_where($table, $query); 
				    echo $status;

				    $this->audit_trail_controller("Delete", null, $old_data);

				} catch (Exception $e) {
				    echo "Error deleting data: " . $e->getMessage();
				}
				break;
			case 'group_update':
			    try {
			        $table = $this->request->getPost('table');
			        $conditions = json_decode($this->request->getPost('conditions'), true); 
			        $update_data = json_decode($this->request->getPost('update_data'), true); 
			        $isHistorical = $this->request->getPost('historical');

			        if (!is_array($conditions) || empty($conditions)) {
			            throw new Exception("Invalid or missing conditions.");
			        }
			        if (!is_array($update_data) || empty($update_data)) {
			            throw new Exception("Missing update data.");
			        }

			        $old_data = $this->Global_model->get_data_list($table, $conditions, 1, 0, "*", null, null, null);

			        $status = $this->Global_model->update_where($table, $update_data, $conditions);
			        echo $status;

			        if ($isHistorical) {
			            $year = $this->request->getPost('year');
			            $action = $this->request->getPost('action');
			            $remarks = $this->request->getPost('remarks');
			            $this->target_sales_per_store_approval_history($year, $action, $remarks);
			        }

			        $this->audit_trail_controller("Update", $update_data, $old_data);

			    } catch (Exception $e) {
			        echo "Error updating data: " . $e->getMessage();
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
			case 'batch_delete_with_conditions':
			    try {
			        $table = $this->request->getPost('table');
			        $conditions = $this->request->getPost('conditions'); // Now an array

			        $result_data = $this->Global_model->batch_delete_with_conditions($table, $conditions);
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
				$group = isset($_POST['group']) ? $_POST['group']: null;

				$result_data = $this->Global_model->get_data_list($table, $query, 9999999, ($offset - 1) * 9999999, $select,$order_field,$order_type, $join, $group);
				$result_return = array(
					"total_record"=> count($result_data),
					"total_page"=>ceil(count($result_data) / $limit)
				);

				echo json_encode($result_return);
				break;
			case 'batch_insert':
			    $table = $this->request->getPost('table');
			    $jsonData = $this->request->getPost('insert_batch_data');
			    $rawFlag = $this->request->getPost('get_code'); 

			    if (empty($table) || empty($jsonData)) {
			        return $this->response
			                    ->setStatusCode(400)
			                    ->setJSON(['message' => 'Table name or data is missing']);
			    }
			    $insertBatchData = is_string($jsonData)
			        ? json_decode($jsonData, true)
			        : $jsonData;

			    $getCode = filter_var($rawFlag, FILTER_VALIDATE_BOOLEAN);

			    $result = $this->Custom_model
			                   ->batch_insert($table, $insertBatchData, $getCode);

			    if ($result === false) {
			        return $this->response
			                    ->setStatusCode(500)
			                    ->setJSON(['message' => 'Database insert failed']);
			    }
			    return $this->response
			                ->setJSON([
			                   'message'  => 'success',
			                   'inserted' => $result
			                ]);

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
					// if ($status !== "failed" && !empty($status)) {
					if ($status !== "failed" && $status !== null) {
					    echo json_encode(['message' => 'success', 'inserted_ids' => $status]);
					} else {
					    echo json_encode(['message' => 'error', 'error' => 'Update failed']);
					}
			    } catch (Exception $e) {
			        echo json_encode(['message' => 'error', 'error' => $e->getMessage()]);
			    }
			    break;
			case 'get_last_code':
			    try { 
			        $table = $this->request->getPost('table');
			        $field = $this->request->getPost('field');

			        if (empty($table) || empty($field)) {
			            return $this->response->setJSON(['message' => 'error', 'error' => 'Invalid request data']);
			        }

			        $last_code = $this->Global_model->fetch_last_ba_code($table, $field); 

			        if ($last_code !== "failed" && !empty($last_code)) {
			            return $this->response->setJSON(['message' => 'success', 'last_code' => $last_code]);
			        } else {
			            return $this->response->setJSON(['message' => 'error', 'error' => 'Fetch last code failed']);
			        }
			    } catch (Exception $e) {
			        return $this->response->setJSON(['message' => 'error', 'error' => $e->getMessage()]);
			    }
			    break;
			case 'insert_or_get_header':
				$session = session();
				$data = $this->request->getPost('data');
				$year = $data['year'] ?? null;
				$week = $data['week'] ?? null;
				$company = $data['company'] ?? null;
				$created_by = $data['created_by'] ?? null;
				$created_date = $data['created_date'] ?? null;

			    $created_by = $created_by;
			    $updated_by = $session->sess_uid;
			    if (!$year || !$week || !$company) {
			        return $this->response->setJSON(['error' => 'Missing required fields.']);
			    }

			    $builder = $this->db->table('tbl_vmi_header');
			    $builder->where([
			        'year' => $year,
			        'week' => $week,
			        'company' => $company
			    ]);
			    $existing = $builder->get()->getRow();

			    if ($existing) {
				    $builder->where('id', $existing->id)->update([
				        'updated_by' => $updated_by,
				        'updated_date' => date('Y-m-d H:i:s')
				    ]);

				    return $this->response->setJSON([
					    'status' => true,
					    'id' => $existing->id,
					    'updated' => true
					]);
			    } else {
			        $header_data = [
			            'year' => $year,
			            'week' => $week,
			            'company' => $company,
			            'status' => 1,
			            'created_by' => $created_by,
			            'updated_by' => '',
			            'created_date' => date('Y-m-d H:i:s'),
			            'updated_date' => ''
			        ];
			        $builder->insert($header_data);
			        return $this->response->setJSON([
					    'status' => true,
					    'id' => $this->db->insertID()
					]);
			    }
			    break;
			case 'getYearCounts':
				try{
					$result_data = $this->Global_model->getYearCounts();
					echo json_encode($result_data);
				} catch (Error $e) {
					echo json_encode(["error" => "Error getting a data from database: " . $e->getMessage()]);
				}
			break;
			case 'getCompanyCounts':
				try{
					$result_data = $this->Global_model->getCompanyCounts();
					echo json_encode($result_data);
				} catch (Error $e) {
					echo json_encode(["error" => "Error getting a data from database: " . $e->getMessage()]);
				}
			break;
		}
		
	}

	public function audit_trail_controller($action, $new_data = null, $old_data = null)
	{
		$session = session();
		// $data2['site_id'] = isset($new_data['site_id'])?$new_data['site_id']:null;
	    $data2['user'] = $session->sess_name;
	  	$data2['action'] = strip_tags(ucwords($action));
	  	$data2['remarks'] = '';
	  	$data2['module'] =str_replace(base_url("cms") . '/', "", $_SERVER['HTTP_REFERER']); ;
	  	if($new_data != null){
	  		$data2['new_data'] = json_encode($new_data);
	  	}

	  	if($old_data != null){
	  		$data2['old_data'] = json_encode($old_data);
	  	}
	  	$data2['link'] = '-'; 
	  	$data2['ip_address'] = $this->request->getIPAddress(); 
	  	$data2['created_at'] = date('Y-m-d H:i:s'); 
	  	$this->Global_model->save_data('activity_logs',$data2);
	}

	public function target_sales_per_store_approval_history($year, $action, $remarks = null)
	{
		$session = session();
	    $data['reference_year'] = $year;
	  	$data['approver_id'] = $session->sess_uid;
	  	$data['action'] = $action;
	  	$data['remarks'] = $remarks;
	  	$data['action_date'] = date('Y-m-d H:i:s'); 
	  	$this->Global_model->save_data('tbl_target_sales_per_store_approval_history',$data);
	}

	public function audit_trail()
	{
	    $data['user'] = $session->sess_name;
	  	$data['module'] = str_replace(base_url("cms") . '/', "", rtrim($_POST['uri'],"#"));
	  	$data['ip_address'] = $this->request->getIPAddress();
	  	$data['action'] = strip_tags(ucwords($_POST['action']));
	  	$data['created_at'] = date('Y-m-d H:i:s'); 
	  	$table = 'activity_logs';
	  	$this->Global_model->save_data($table,$data);
	}

	public function get_valid_ba_data() {
	    $request = $this->request->getGet(); 
	    $responseData = [];

	    if (!empty($request['ba'])) {
	        $responseData['ba'] = $this->Global_model->get_valid_records("tbl_brand_ambassador", ['code','type']);
	    }
	    if (!empty($request['brands'])) {
	        $responseData['brands'] = $this->Global_model->get_valid_records("tbl_brand", 'brand_description');
	    }
		if (!empty($request['brandssopa'])) {
	        $responseData['brandssopa'] = $this->Global_model->get_valid_records("tbl_brand", 'brand_code');
	    }
		if (!empty($request['agencies'])) {
	        $responseData['agencies'] = $this->Global_model->get_valid_records("tbl_agency", 'code', 'agency');
	    }
		if (!empty($request['teams'])) {
	        $responseData['teams'] = $this->Global_model->get_valid_records("tbl_team", 'code', 'team_description');
	    }
	    if (!empty($request['stores'])) {
	        $responseData['stores'] = $this->Global_model->get_valid_records("tbl_store", ['code', 'description']);
	    }

	    if (!empty($request['areas'])) {
	        $responseData['areas'] = $this->Global_model->get_valid_records("tbl_area", 'code');
	    }

	    if (!empty($request['area_asc'])) {
	        $responseData['area_asc'] = $this->Global_model->get_valid_records_area_asc_group();
	    }

	    if (!empty($request['store_ba'])) {
	        $responseData['store_ba'] = $this->Global_model->get_valid_records_store_ba_group();
	    }

	    if (!empty($request['ba_area_store_brand'])) {
	        $responseData['ba_area_store_brand'] = $this->Global_model->get_valid_records_store_area_asc_ba_brand();
	    }

	    if (!empty($request['payment_group_lmi'])) {
	        $responseData['payment_group_lmi'] = $this->Global_model->get_valid_records("tbl_cus_payment_group_lmi", 'customer_group_code');
	    }

	    if (!empty($request['payment_group_rgdi'])) {
	        $responseData['payment_group_rgdi'] = $this->Global_model->get_valid_records("tbl_cus_payment_group_rgdi", 'customer_group_code');
	    }

	    //for sell out
	    if (!empty($request['customer_sku_code_lmi'])) {
	        $responseData['customer_sku_code_lmi'] = $this->Global_model->get_valid_records_tracc_data("tbl_price_code_file_2_lmi", 'cusitmcde');
	    }
	    if (!empty($request['customer_sku_code_rgdi'])) {
	        $responseData['customer_sku_code_rgdi'] = $this->Global_model->get_valid_records_tracc_data("tbl_price_code_file_2_rgdi", 'cusitmcde');
	    }

	    //target per account
	    if (!empty($request['customer_sku_code_lmi_per_account'])) {
	        $responseData['customer_sku_code_lmi_per_account'] = $this->Global_model->get_valid_records_tracc_data("tbl_price_code_file_2_lmi", 'itmcde', 'itmcde');
	    }
	    if (!empty($request['customer_sku_code_rgdi_per_account'])) {
	        $responseData['customer_sku_code_rgdi_per_account'] = $this->Global_model->get_valid_records_tracc_data("tbl_price_code_file_2_rgdi", 'itmcde', 'itmcde');
	    }

	    if (!empty($request['store_area'])) {
	        $responseData['store_area'] = $this->Global_model->get_valid_records_store_group();
	    }
		if (!empty($request['item_class'])) {
	        $responseData['item_class'] = $this->Global_model->get_valid_records("tbl_item_class", 'item_class_description');
	    }
		if (!empty($request['label_type'])) {
	        $responseData['label_type'] = $this->Global_model->dynamic_search(
				"'tbl_brand_label_type'", "''", "'id, label'", 0, 0, "''", "''", "''"
			);
	    }
	    if (!empty($request['item_classification'])) {
	        $responseData['item_classification'] = $this->Global_model->get_valid_records("tbl_item_class", 'item_class_code');
	    }
 	    return $this->response->setJSON($responseData);
	}

    public function log()
    {
        helper('activity_helper');

        $module  = $this->request->getPost('module');
        $action  = $this->request->getPost('action');
        $remarks = $this->request->getPost('remarks');
        $link = $this->request->getPost('link');
        $new_data = $this->request->getPost('new_data');
        $old_data = $this->request->getPost('old_data');

        // You can add validation here if needed

        log_activity($module, $action, $remarks, $link, $new_data, $old_data);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Activity logged successfully.'
        ]);
    }

public function save_import_log_file()
{
    $content = $this->request->getPost('content');
    $fileName = $this->request->getPost('fileName');

    if (!$content || !$fileName) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Missing content or filename.'
        ]);
    }

    $uploadPath = WRITEPATH . 'uploads/import_logs/'; // e.g., writable/uploads/import_logs/

    // 🛠️ Check if directory exists, if not create it
    if (!is_dir($uploadPath)) {
        mkdir($uploadPath, 0777, true); // <-- THIS CREATES the missing folders
    }

    $filePath = $uploadPath . $fileName;
    $base_url = base_url();
    if (file_put_contents($filePath, $content) !== false) {
        $relativePath = '/cms/uploads/download/log/' . $fileName; // relative path
        return $this->response->setJSON([
            'status' => 'success',
            'file_path' => $relativePath
        ]);
    } else {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to write file.'
        ]);
    }
    
}

public function downloadLog($filename)
{
    $filePath = WRITEPATH . 'uploads/import_logs/' . $filename;

    if (!file_exists($filePath)) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException("File not found.");
    }

    return $this->response->download($filePath, null);
}


}
