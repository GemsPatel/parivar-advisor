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
			$customer_id = $this->input->get('customer_id');
			$c_firstname = "";//$this->input->get('c_firstname_filter');
			$c_phoneno = $this->input->get('c_phoneno_filter');
			$c_slip_number= $this->input->get('c_slip_number');
			
			$fromDate = $this->input->get('dateFrom');
			$toDate = $this->input->get('dateTo');
			
			if($fromDate && $toDate)
			{
				$this->db->where('DATE_FORMAT('.$this->cTableName.'.c_created_date,"%Y-%m-%d") BETWEEN "'.formatDate('Y-m-d', $fromDate ).'" and "'.formatDate('Y-m-d', $toDate ).'"','',FALSE);
			}
			
			if( isset($customer_id) && !empty( $customer_id ) )
				$this->db->where('customer_id', $customer_id );
			
			if(isset($status_filter) && $status_filter != "")
				$this->db->where('customer_status LIKE \''.$status_filter.'\' ');
				
			if(isset($c_firstname) && $c_firstname!= "")
			{
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
// 		echo $this->db->last_query();die;
		return $res;
	}
	
	function getCommissionData()
	{
		if($this->cPrimaryId == "")
		{
			$c_slip_number= $this->input->get('c_slip_number');
			
			if(isset($c_slip_number) && $c_slip_number!= "")
				$this->db->where('c_slip_number LIKE \'%'.$c_slip_number.'%\' ');
				
			$this->db->order_by( $this->cTableName.'.'.$this->cAutoId, 'DESC' );
									
			if( (int)$this->session->userdata('is_login') == 2 )
			{
				$this->db->where( $this->cTableName.'.'.$this->cAutoId, (int)$this->session->userdata('admin_customer_id') );
			}
		}
		
		$this->db->select( $this->cTableName.".*, cpm.*" );
		$this->db->from( $this->cTableName );
		$this->db->join('customer_pay_map cpm', 'cpm.customer_id = '.$this->cTableName.'.customer_id' );
		$this->db->group_by( "cpm.customer_id" );
		
		$res = $this->db->get();
		return $res;
	}
	
	function getCustomerDiscountData()
	{
		$this->db->select( "*" );
		$this->db->from( "customer_discount_map" );
// 		$this->db->join('customer_pay_map cpm', 'cpm.customer_id = '.$this->cTableName.'.customer_id' );
		$this->db->where( 'reference_customer_id', (int)$this->session->userdata('admin_customer_id') );
		$this->db->where( 'level != 0' );
		$this->db->order_by( 'discount', 'DESC' );
		
		$res = $this->db->get();
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
		$customer['c_phoneno'] = $data['c_phoneno'];

		unset($data['item_id']);
		unset( $data['c_customer_reference_id'] );
		
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
			
			//send new customer registeration sms
			sendParivarSMS( $customer['c_phoneno'], "Thank you for registering to the Parivar Advisor website. Please open this link http://admin.parivaradviser.online and check your account details. your email:".$data['c_emailid']." and password:".$data['c_firstname']);
		}
		
		setFlashMessage('success','Customer has been '.( ($this->cPrimaryId != '' && $this->cPrimaryIdA != '') ? 'updated': 'inserted').' successfully.');
	}
	
	function savePaymentData()
	{
		$data['customer_id'] = _de( $this->input->post('item_id') );
		$data['cpm_payment'] = $this->input->post('cpm_payment');
		
		$this->db->insert( "customer_payment_map", $data );
		
		//Send Payment Approved MEssage
		$mobile = getField( "c_phoneno" , "customer", "customer_id", $data['customer_id']);
		sendParivarSMS($mobile, "Congrats. Rs. ".$data['cpm_payment']." successfully added at http://parivaradviser.online/.");
		
		$this->updateCommission( $data['customer_id'], $data['cpm_payment']);
	}
	
	/*
	 +-----------------------------------------+
	 Update status for enabled/disabled
	 @params : post array of ids, status
	 +-----------------------------------------+
	 */
	function updateCPMPayment()
	{
		$newPayment = $this->input->post('cpm_payment');
		$oldPayment = $this->input->post('oldPayment');
		$cpm_id = $this->input->post('cpm_id');
		$customer_id = $this->input->post('item_id');
		
		$data['cpm_payment'] = $newPayment;
		$this->db->where( "cpm_id", $cpm_id );
		$this->db->update( "customer_payment_map", $data );
		
		if( $oldPayment < $newPayment)
		{
			$this->updateCommission( $customer_id, ( $newPayment - $oldPayment ) );
		}
	}
	
	/*
	 * 
	 */
	function updateCommission( $customer_id, $payment)
	{
		$parent_id = getField( "c_reference_id" , "customer", "customer_id", $customer_id );
		
		if( !empty( $parent_id) )
		{
			$commissionArr = fetchChainTreeList( $parent_id, '', true );
			
			if( count( $commissionArr ) >0 )
			{
				$newLevel = 0;
				$cpm_payment = 0;
				foreach ( $commissionArr as $commission )
				{
					if( $newLevel <=11 )
					{
						$newLevel++;
						$cpm_payment = chainLevel( $newLevel );
					}
					
					$cpm['customer_id'] = $commission['customer_id'];
					$cpm['level'] = $cpm_payment;
					$cpm['cpm_payment'] = ( $payment * $cpm_payment) / 100;
					$cpm['reference_customer_id'] = $commission['customer_id'];
					
					$this->db->insert( "customer_pay_map", $cpm);
				}
			}
		}
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
			
			//customer table
			$getName = getField('c_firstname', $this->cTableName, $this->cAutoId, $id);
			$this->db->where_in($this->cAutoId,$id )->delete($this->cTableName);
			
			//customer bonus map
			$this->db->where_in( "customer_id",$id )->delete( "bonus_map" );
			
			//customer bonus print
			$this->db->where_in( "customer_id",$id )->delete( "bonus_map_print" );
			
			//customer_discount_map
			$this->db->where_in( "customer_id",$id )->delete( "customer_discount_map" );
			
			//admin_user
			$this->db->where_in( "customer_id",$id )->delete( "admin_user" );
			
			//customer_payment_map
			$this->db->where_in( "customer_id",$id )->delete( "customer_payment_map" );
			
			//customer_pay_map
			$this->db->where_in( "customer_id",$id )->delete( "customer_pay_map" );
			
			$returnArr['type'] ='success';
			$returnArr['msg'] = count($ids)." records has been deleted successfully.";
		}
		else
		{
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
	
	function updatePayment()
	{
		$pay = $this->input->post('pay');
		$paid = $this->input->post('paid');
		$id = $this->input->post('id');
		
		$data['c_commission_pay_amt'] = ( $paid + $pay );
		$this->db->where($this->cAutoId,$id);
		$this->db->update($this->cTable,$data);
		
		//Send commission data
		$phone = getField( "c_phoneno" , "customer", "customer_id", $id );
		sendParivarSMS( $phone, "Congrats. Your commission Rs. ".$pay." process completed." );
		
// 		$returnArr['type'] ='success';
// 		$returnArr['msg'] = "Records has been updated successfully.";
		
// 		echo json_encode($returnArr);die;
	}

	function createChainReference( $reference_id, $old_reference_id, $last_id, $level = 0, $isRecursive = false )//, $isLevelINC=true
	{
		$parent_reference_id = getField( "c_reference_id" , "customer", "customer_id", $reference_id);
		
		if( !empty( $parent_reference_id) )
		{
			return $this->insertDiscountLevelMap( $reference_id, $old_reference_id, $last_id, $level, $parent_reference_id, true );
		}
		else
		{
			return $this->insertDiscountLevelMap( $reference_id, $old_reference_id, $last_id, $level, 0, false );
		}
	}
	
	function insertDiscountLevelMap( $reference_id, $old_reference_id, $last_id, $level=0, $parent_reference_id=0, $isRecursive = false )//, $isLevelINC=true
	{
		if( !checkIfRowExist( "SELECT cdm_id FROM customer_discount_map WHERE customer_id = ".$reference_id." AND reference_customer_id =".$old_reference_id) );
		{
			$discount = 0;
			$level+=1;
// 			if( $isLevelINC )
			{
				if( $level <=11 )
				{
					$isLevelINC = false;
					$discount = chainLevel( $level );
					
					$map['customer_id'] = $last_id;
					$map['reference_customer_id'] = $reference_id;
					$map['discount'] = $discount;
					$map['level'] = $level;
					$this->db->insert( "customer_discount_map", $map );
					//echo $this->db->last_query()."<br>";
					//insert customer bonus level
					if( $level > 0 && $level <= 5 )
					{
						$insertData['level_1'] = $insertData['level_2'] = $insertData['level_3'] = $insertData['level_4'] = $insertData['level_5'] = 0;
						//$insertData['level_'.$level] = $level;
						$insertData['customer_id'] = $last_id;
						
						$row = exeQuery( "SELECT bonus_map_id FROM bonus_map where customer_id = ".$reference_id);
						if( !empty( $row['bonus_map_id'] ) )
							$this->db->query( "UPDATE `bonus_map` SET `level_".$level."`=`level_".$level."`+1 WHERE `bonus_map_id`=".$row['bonus_map_id'] );
						else
							$this->db->insert( 'bonus_map', $insertData);
						
						$mobile = getField( "c_phoneno" , "customer", "customer_id", $old_reference_id );
						sendParivarSMS( $mobile, "Congrats. Someone has joined under you. From: http://parivaradviser.online/. Helpline: + 91- 9104191019");
						//echo $this->db->last_query()."<br>";
					}
				}
			}
			
			if( $isRecursive )
			{
				$this->createChainReference( $parent_reference_id, $reference_id, $last_id, $level );//, $isLevelINC
			}
		}
		
		return true;
	}
}