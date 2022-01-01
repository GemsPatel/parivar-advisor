<?php
class Mdl_users extends CI_Model
{
	var $cTableName = '';
	var $cAutoId = '';
	var $cPrimaryId = '';
	
	function getData()
	{
		if($this->cPrimaryId == "")
		{
			$f = $this->input->get('f');
			$s = $this->input->get('s');
			$status_filter = $this->input->get('status_filter');
			$name = $this->input->get('name_filter');
			$phoneno = $this->input->get('mobile_filter');
			$r_id = $this->input->get('r_id');
			
// 			if(isset($status_filter) && $status_filter != "")
// 				$this->db->where('customer_status LIKE \''.$status_filter.'\' ');
			
			if(isset($name) && $name!= "")
			{
				$this->db->like($this->cTableName.'.admin_user_firstname', $name);
				$this->db->or_like($this->cTableName.'.admin_user_lastname', $name);
			}
			
			if(isset($phoneno) && $phoneno!= "")
				$this->db->where($this->cTableName.'.admin_user_phone_no LIKE \'%'.$phoneno.'%\' ');
			
			if(isset($r_id) && $r_id!= "")
				$this->db->where($this->cTableName.'.r_id', $r_id );
			
			$this->db->where($this->cTableName.'.is_login', 1 );
			
// 			$this->db->where($this->cTableName.'.admin_user_id', '!=', 1 );
// 			$this->db->where($this->cTableName.'.admin_user_id', '!=', 2 );
				
			if($f !='' && $s != '' )
				$this->db->order_by($f,$s);
			else
				$this->db->order_by($this->cAutoId,'DESC');
		}
		else if($this->cPrimaryId != '')
		{
			$this->db->where($this->cAutoId,$this->cPrimaryId);
		}
		
		$this->db->join('roles r', 'r.r_id = '.$this->cTableName.'.r_id', 'LEFT');
		$res = $this->db->get($this->cTableName);
		
		return $res;
	}

	function getAllCustomer()
	{
		$result = executeQuery( "SELECT CONCAT( c_firstname, ' ', c_lastname ) as c_name, customer_id FROM customer WHERE c_status = 1" );
		return $result;
	}

	function saveData()
	{
		$data = $this->input->post();
		
		unset($data['item_id']);
		
		if( !empty( $_FILES['admin_profile_image']['name'] ) )
		{
			$data['admin_profile_image'] = uploadFolder('admin_profile_image', 'image', 'profileImage');
		}
		
		if( !empty( $_POST['admin_user_password'] ) )
		{
			$data['admin_user_password'] = md5( $this->input->post('admin_user_password').$this->config->item( 'encryption_key' ) );
		}
		
		//if primary id set then we have to make update query
		if( $this->cPrimaryId != '' )
		{
			if( empty( $data['admin_user_password'] ) )
			{
				unset( $data['admin_user_password'] );
			}
			
			$this->db->set('admin_user_modified_date', 'NOW()', FALSE);
			$this->db->where($this->cAutoId,$this->cPrimaryId)->update($this->cTableName,$data);
			$last_id = $this->cPrimaryId;
			$logType = 'E';
			
		}
		else // insert new row
		{
			$this->db->insert($this->cTableName,$data);
			$last_id = $this->db->insert_id();
			$logType = 'A';
		}

		setFlashMessage('success','Customer has been '.(($this->cPrimaryId != '' ) ? 'updated': 'inserted').' successfully.');
	}
/*
+----------------------------------------------------------+
	Deleting item. hadle both request get and post.
	with single delete and multiple delete.
	@prams : $ids -> integer or array
+----------------------------------------------------------+
*/	
	function deleteData($ids)
	{
		$returnArr = array();
		if($ids)
		{
			$id = $ids;
// 			foreach($ids as $id)
// 			{
// 				$tabNameArr = array('0'=>'orders','1'=>'customer_account_manage','2'=>'private_message');
// 				$fieldNameArr = array('0'=>'customer_id','1'=>'customer_id','2'=>'customer_id');
// 				$res=isImageIdExist($tabNameArr,$fieldNameArr,$id);
				
// 				if(sizeof($res)>0)
// 				{
// 					echo json_encode($res);	
// 					return;
// 				}
// 				else
// 				{
				
// 					$getName = getField('c_firstname', $this->cTableName, $this->cAutoId, $id);
// 					saveAdminLog($this->router->class, @$getName, $this->cTableName, $this->cAutoId, $id, 'D');
// 					$this->db->where_in($this->cAutoId,$id)->delete($this->cTableNameA);

					if( $id == 1 || $id == 2 )
					{
						$returnArr['type'] ='error';
						$returnArr['msg'] = "Sorry You are not elligible for this record";
					}
					else
					{
						$this->db->where_in( $this->cAutoId, $id )->delete($this->cTableName);
						$returnArr['type'] ='success';
						$returnArr['msg'] = count($ids)." records has been deleted successfully.";
					}
					
// 				}
// 			}
		}
		else{
			$returnArr['type'] ='error';
			$returnArr['msg'] = "Please select at least 1 item.";
		}
		echo json_encode($returnArr);
	}
/*
+-----------------------------------------+
	Update status for enabled/disabled
	@params : post array of ids, status
+-----------------------------------------+
*/	
	function updateStatus()
	{
		$status = $this->input->post('status');
		$cat_id = $this->input->post('cat_id');
		
		$data['c_status'] = $status;
		$this->db->where($this->cAutoId,$cat_id);
		$this->db->update($this->cTable,$data);
// 		echo $this->db->last_query();die;
		
	}
}