<?php
class Mdl_customer extends CI_Model
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
			$c_firstname = $this->input->get('c_firstname_filter');
			$c_phoneno = $this->input->get('c_phoneno_filter');
			$c_slip_number= $this->input->get('c_slip_number');
			
			$fromDate = $this->input->get('dateFrom');
			$toDate = $this->input->get('dateto');
			
			if($fromDate && $toDate)
				$this->db->where('DATE_FORMAT('.$this->cTableName.'.c_created_date,"%Y-%m-%d") BETWEEN "'.$fromDate.'" and "'.$toDate.'"','',FALSE);
			
			if(isset($status_filter) && $status_filter != "")
				$this->db->where('customer_status LIKE \''.$status_filter.'\' ');
			
			if(isset($c_firstname) && $c_firstname!= "")
			{
// 				$this->db->where('c_firstname LIKE \'%'.$c_firstname.'%\' ');
				$this->db->like('c_firstname', $c_firstname);
				$this->db->or_like('c_lastname', $c_firstname);
				$this->db->or_like('c_middlename', $c_firstname);
			}
			
			if(isset($c_phoneno) && $c_phoneno!= "")
				$this->db->where('c_phoneno LIKE \'%'.$c_phoneno.'%\' ');
			
			if(isset($c_slip_number) && $c_slip_number!= "")
				$this->db->where('c_slip_number LIKE \'%'.$c_slip_number.'%\' ');
			
			if($f !='' && $s != '' )
				$this->db->order_by($f,$s);
			else
				$this->db->order_by($this->cAutoId,'DESC');
			
			if( (int)$this->session->userdata('is_login') == 2 )
			{
				$this->db->where( $this->cAutoId, (int)$this->session->userdata('admin_customer_id') );
			}
		}
		else if($this->cPrimaryId != '')
		{
			$this->db->where($this->cAutoId,$this->cPrimaryId);
		}
					
		$res = $this->db->get($this->cTableName);
// 		echo $this->db->last_query();
		return $res;
	}
	
	function getPaymentData()
	{
		$this->db->where($this->cAutoId,$this->cPrimaryId);
		$res = $this->db->get( "customer_payment_map" );
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
		
		$customer['c_firstname'] = $data['c_firstname'];
		$customer['c_lastname'] = $data['c_lastname'];
// 		$customer['customer_emailid'] = $this->input->post('customer_emailid');
		$customer['c_phoneno'] = $data['c_phoneno'];
// 		$data['customer_status'] = $this->input->post('customer_status');

		unset($data['item_id']);

		//if primary id set then we have to make update query
		if($this->cPrimaryId != '')
		{
			$this->db->set('c_modified_date', 'NOW()', FALSE);
			$this->db->where($this->cAutoId,$this->cPrimaryId)->update($this->cTableName,$data);
			$last_id = $this->cPrimaryId;
			$logType = 'E';
			
		}
		else // insert new row
		{
			$this->db->insert($this->cTableName,$data);
			$last_id = $this->db->insert_id();
			
			$map['customer_id'] = $last_id;
			$map['reference_customer_id'] = $last_id;
			$map['discount'] = 10;
			$map['level'] = 0;
			$this->db->insert( "customer_discount_map", $map );
			
			if( isset( $data['c_reference_id'] ) && !empty( $data['c_reference_id'] ) )
			{
				$this->createChainReference( $data['c_reference_id'], $last_id, $last_id );
			}
			
			$admin['r_id'] = 3;
			$admin['customer_id'] = $last_id;
			$admin['admin_user_firstname'] = $data['c_firstname'];
			$admin['admin_user_lastname'] = $data['c_lastname'];
			$admin['admin_user_emailid'] = $data['c_emailid'];
			$admin['admin_user_phone_no'] = $data['c_phoneno'];
			$admin['admin_user_password'] = md5( $data['c_firstname'].$this->config->item( 'encryption_key' ) );
			$admin['is_login'] = 2;
			$admin['admin_user_status'] = 1;
			$this->db->insert( "admin_user", $admin);
			
			$logType = 'A';
		}

		setFlashMessage('success','Customer has been '.(($this->cPrimaryId != '' && $this->cPrimaryIdA != '') ? 'updated': 'inserted').' successfully.');
	}
	
	function savePaymentData()
	{
		$data['customer_id'] = _de( $this->input->post('item_id') );
		$data['cpm_payment'] = $this->input->post('cpm_payment');
		
		$this->db->insert( "customer_payment_map", $data );
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
				
					$getName = getField('c_firstname', $this->cTableName, $this->cAutoId, $id);
// 					saveAdminLog($this->router->class, @$getName, $this->cTableName, $this->cAutoId, $id, 'D');
// 					$this->db->where_in($this->cAutoId,$id)->delete($this->cTableNameA);
					$this->db->where_in($this->cAutoId,$id)->delete($this->cTableName);
					$returnArr['type'] ='success';
					$returnArr['msg'] = count($ids)." records has been deleted successfully.";
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

	function createChainReference( $reference_id, $old_reference_id, $last_id, $level = 1 )
	{
// 		$getTotalCustomer = getField( "count( cdm_id )" , "customer_discount_map", "customer_id", $reference_id );
		
// 		if( $getTotalCustomer < 5 )
		{
			$parent_reference_id = getField( "c_reference_id" , "customer", "customer_id", $reference_id);
// 			echo "1: ".$this->db->last_query()."<br>";
			
			if( !empty( $parent_reference_id) )
			{
				if( !checkIfRowExist( "SELECT cdm_id FROM customer_discount_map WHERE customer_id = ".$reference_id." AND reference_customer_id =".$old_reference_id) );
				{
					$map['customer_id'] = $reference_id;
					$map['reference_customer_id'] = $last_id;
					$map['discount'] = chainLevel( ( $level < 5 ) ? $level : 0 );
					$map['level'] = ( $level < 5 ) ? $level : 0 ;
// 					$map['discount'] = chainLevel( $getTotalCustomer );
// 					$map['level'] = (int)$getTotalCustomer;
					$this->db->insert( "customer_discount_map", $map );
					
// 					$data['discount'] = $map['discount'];
// 					$this->db->where( "customer_id", $reference_id );
// 					$this->db->update( "customer_discount_map", $data );
					
					$level+=1;
					
					$this->createChainReference( $parent_reference_id, $reference_id, $last_id, $level );
				}
				return true;
			}
			else
			{
				if( !checkIfRowExist( "SELECT cdm_id FROM customer_discount_map WHERE customer_id = ".$reference_id." AND reference_customer_id =".$last_id) );
				{
					$map['customer_id'] = $reference_id;
					$map['reference_customer_id'] = $last_id;
					$map['discount'] = chainLevel( ( $level < 5 ) ? $level : 0 );
					$map['level'] = ( $level < 5 ) ? $level : 0 ;
// 					$map['discount'] = chainLevel( $getTotalCustomer );
// 					$map['level'] = (int)$getTotalCustomer;
					$this->db->insert( "customer_discount_map", $map );
					
// 					$data['discount'] = $map['discount'];
// 					$this->db->where( "customer_id", $reference_id );
// 					$this->db->update( "customer_discount_map", $data );
				}
			}
			return true;
		}
		return true;
	}
}