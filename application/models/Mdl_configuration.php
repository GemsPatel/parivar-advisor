<?php
class Mdl_configuration extends CI_Model
{
	var $cTableName = '';
	var $cAutoId = '';
	var $cPrimaryId = '';
	var $cCategory = '';
	
	function getData()
	{
		if($this->cPrimaryId == "")
		{
			$f = $this->input->get('f');
			$s = $this->input->get('s');
			
			if($f !='' && $s != '' && check_db_column($this->cTableName,$f))
				$this->db->order_by($f,$s);
			else
				$this->db->order_by($this->cAutoId,'ASC');
		}
		else if($this->cPrimaryId != '')
		{
			$this->db->where( $this->cTableName.".".$this->cAutoId, $this->cPrimaryId);
		}
					
		$res = $this->db->get($this->cTableName);
		//echo $this->db->last_query();
		return $res;
		
	}
	
	function saveData()
	{	
		$data = $this->input->post();
		unset($data['item_id']);
		
		$this->db->set('modified_date', 'NOW()', FALSE);

		//if primary id set then we have to make update query
		$log_name = ( isset( $data["config_key"] ) ? $data["config_key"] : "config_id: ". $this->cPrimaryId );
		if($this->cPrimaryId != '')
		{
			$this->db->where($this->cAutoId,$this->cPrimaryId)->update($this->cTableName,$data);
			$last_id = $this->cPrimaryId;
			$logType = 'E';
		}
		else // insert new row
		{
			$data['config_key'] = strtoupper($data['config_key']);
			$this->db->insert($this->cTableName,$data);
			$last_id = $this->db->insert_id();
			$logType = 'A';
		}
		
		setFlashMessage('success','Configuration has been '.(($this->cPrimaryId != '') ? 'updated': 'inserted').' successfully.');		
	}
}