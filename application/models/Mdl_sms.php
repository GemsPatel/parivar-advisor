<?php
class Mdl_sms extends CI_Model
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
			
			if($f !='' && $s != '' )
				$this->db->order_by($f,$s);
			else
				$this->db->order_by($this->cAutoId,'DESC');
		}
		else if($this->cPrimaryId != '')
		{
			$this->db->where($this->cAutoId,$this->cPrimaryId);
		}
					
		$res = $this->db->get($this->cTableName);
		//echo $this->db->last_query();
		return $res;
	}
	
	function saveData()
	{
		$data = $this->input->post();
		
		$sms['sms_content'] = $data['sms_content'];

		//if primary id set then we have to make update query
		if($this->cPrimaryId != '')
		{
			$this->db->set('sms_modified_date', 'NOW()', FALSE);
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
		
		$send['is_send_sms'] = 1;
		$send['sms_id'] = $last_id;
		$this->db->set('c_modified_date', 'NOW()', FALSE);
		$this->db->where( "c_status", 1 )->update( "customer", $send );

		setFlashMessage('success','Customer has been '.(($this->cPrimaryId != '' && $this->cPrimaryIdA != '') ? 'updated': 'inserted').' successfully.');
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
				
// 					$getName = getField('customer_firstname', $this->cTableName, $this->cAutoId, $id);
// 					saveAdminLog($this->router->class, @$getName, $this->cTableName, $this->cAutoId, $id, 'D');
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
		
		$data['customer_status'] = $status;
		$this->db->where($this->cAutoId,$cat_id);
		$this->db->update($this->cTable,$data);
		//echo $this->db->last_query();
		
	}

}