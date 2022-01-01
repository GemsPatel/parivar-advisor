<?php
class Mdl_bonus extends CI_Model
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
			$c_firstname = $this->input->get('c_name');
			$fromDate = $this->input->get('dateFrom');
			$toDate = $this->input->get('dateTo');
			
			if($fromDate && $toDate)
			{
				$this->db->where('DATE_FORMAT('.$this->cTableName.'.c_created_date,"%Y-%m-%d") BETWEEN "'.formatDate('Y-m-d', $fromDate ).'" and "'.formatDate('Y-m-d', $toDate ).'"','',FALSE);
			}
			
			if(isset($c_firstname) && $c_firstname!= "")
			{
				$this->db->like('c_firstname', $c_firstname);
				$this->db->or_like('c_lastname', $c_firstname);
				$this->db->or_like('c_middlename', $c_firstname);
			}
			
			if($f !='' && $s != '' && check_db_column($this->cTableName,$f))
				$this->db->order_by($f,$s);
			else
				$this->db->order_by($this->cAutoId,"DESC");
		}
		else if($this->cPrimaryId != '')
		{
			$this->db->where( $this->cTableName.".".$this->cAutoId, $this->cPrimaryId);
		}
		
		$this->db->join('customer c', 'c.customer_id = '.$this->cTableName.'.customer_id', 'LEFT');
					
		$res = $this->db->get($this->cTableName);
// 		echo $this->db->last_query();die;
		return $res;
		
	}
	
	function saveData()
	{	
		$id = $this->input->post('id');
		
		$getResult = exeQuery( "SELECT * FROM bonus_map WHERE bonus_map_id = ".$id );
		
		unset( $getResult['bm_created_date'] );
		unset( $getResult['bm_modified_date'] );
		
		$this->db->insert( 'bonus_map_print', $getResult );
	
		$updateBonus['level_1'] = 0;
		$updateBonus['level_2'] = 0;
		$updateBonus['level_3'] = 0;
		$updateBonus['level_4'] = 0;
		$updateBonus['level_5'] = 0;
		
		$this->db->set('bm_modified_date', 'NOW()', FALSE);
		$this->db->where( $this->cAutoId, $id )->update( "bonus_map", $updateBonus );
		
		$returnArr['type'] ='success';
		$returnArr['msg'] = $id."records has been proccess successfully.";
		
		echo json_encode($returnArr);
	}
	
	function getBonusPrintData()
	{
		$this->db->where( $this->cAutoId, $this->cPrimaryId );
// 		$this->db->join('customer c', 'c.customer_id = bmp.customer_id', 'LEFT');
		$res = $this->db->get( "bonus_map_print" );
		return $res;
	}
}