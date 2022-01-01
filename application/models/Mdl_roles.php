<?php
class Mdl_roles extends CI_Model
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
// 		echo $this->db->last_query();
		return $res;
	}

	function saveData()
	{
		$data = $this->input->post();
		
		unset($data['item_id']);

		//if primary id set then we have to make update query
		if($this->cPrimaryId != '')
		{
			$this->db->set('modified_date', 'NOW()', FALSE);
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
				
			$this->db->where_in($this->cAutoId,$id)->delete($this->cTableName);
			$returnArr['type'] ='success';
			$returnArr['msg'] = count($ids)." records has been deleted successfully.";
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