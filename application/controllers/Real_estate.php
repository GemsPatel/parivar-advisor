<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Real_estate extends CI_Controller {
	
	/**
	 * Get All Data from this method.
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->load->view('real_estate_people');
	}
	
	function list_ajax()
	{
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$referenceName = $this->input->get("reference_name");
		$customerName = $this->input->get("customer_name");
		$c_slip_number= $this->input->get("c_slip_number");
		$contactNo = $this->input->get("contact");
		$startDate= $this->input->get("startDate");
		$endDate = $this->input->get("endDate");
		
		$id = $this->input->get("id");
		
		if( isset( $id ) && !empty( $id ) )
		{
			$this->db->where('customer_id', $id );
		}
		
		if( isset( $referenceName ) && !empty( $referenceName ) )
		{
			$this->db->like('c_firstname', $referenceName );
			$this->db->or_like('c_lastname', $referenceName );
			$this->db->or_like('c_middlename', $referenceName );
		}
		
		if( isset( $customerName ) && !empty( $customerName ) )
		{
			$this->db->like('c_firstname', $customerName);
			$this->db->or_like('c_lastname', $customerName);
			$this->db->or_like('c_middlename', $customerName);
		}
		
		if( isset( $contactNo ) && !empty( $contactNo ) )
			$this->db->where('c_phoneno LIKE \'%'.$contactNo.'\' ');
		
		if( isset( $c_slip_number) && !empty( $c_slip_number) )
			$this->db->where('c_slip_number LIKE \'%'.$c_slip_number.'\' ');
		
// 		$startDate = ( $startDate != 'Invalid' ) ? date( 'Y-m-d', strtotime( $startDate) ) : '';
		
		if( isset( $startDate ) && !empty( $endDate ) )
		{
// 			$monday = strtotime("last monday");
// 			$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
			
// 			$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
			
// 			$startDate = date("Y-m-d",$monday);
// 			$endDate = date("Y-m-d",$sunday);
			
			$this->db->where( 'c_created_date >=', $startDate );
			$this->db->where( 'c_created_date <=', $endDate );
		}
		
		$this->db->order_by( "customer_id", 'DESC' );		
		$query = $this->db->get("customer");
		$dataArr = $query->result_array();
		
		$data = array();
		
		if( count( $dataArr ) >0 )
		{
			foreach( $dataArr as $r )
			{	
				$reference = exeQuery( "SELECT CONCAT( c_firstname, ' ', c_middlename, ' ', c_lastname ) as reference FROM customer WHERE customer_id = ".$r['c_reference_id'] );
				
				$checkbox = '<th class="text-center hide"> 
								<div class="icheckbox_flat-green" style="position: relative;" id="div_'.$r['customer_id'].'" onclick="checkboxClick('.$r['customer_id'].')">
									<input type="checkbox" class="flat hide" id="'.$r['customer_id'].'" name="validate[]" value="'.$r['customer_id'].'">
								</div>
							</th>';

				$reference = '<td><a style="text-decoration: none; cursor:pointer;" data-toggle="modal" data-target="#reference-item" onclick="getReferenceData('.$r['c_reference_id'].')">'.$reference['reference'].'</a></td>';
				
				$data[] = array(
// 						$checkbox,
						$r['customer_id'],
						$r['c_slip_number'],
						$r['c_firstname']." ".$r['c_middlename']." ".$r['c_lastname'],
						$r['c_emailid'],
						$r['c_phoneno'],
						$r['c_city']." ".$r['c_state']." ".$r['c_pincode'],
						$reference,
						$r['c_book_amt'],
						$r['c_created_date']
				);
			}
		}
		
		$result = array(
				"draw" => $draw,
				"recordsTotal" => count( $dataArr ),
				"recordsFiltered" => count( $dataArr ),
				"data" => $data
		);
		
		echo json_encode( $result );die;
	}
	
	public function getRecord()
	{
		$referenceName = $this->input->get("reference_name");
		$customerName = $this->input->get("customer_name");
		$contactNo = $this->input->get("contact");
		
		if( isset( $referenceName) && !empty( $referenceName) )
		{
			$this->db->like('c_firstname', $referenceName );
			$this->db->or_like('c_lastname', $referenceName );
		}
		
		if( isset( $customerName) && !empty( $customerName) )
		{
			$this->db->like('c_firstname', $customerName);
			$this->db->or_like('c_lastname', $customerName);
		}
		
		if( isset( $contactNo) && !empty( $contactNo) )
		{
			$this->db->where('c_phoneno LIKE \'%'.$contactNo.'\' ');
		}
		
		$this->db->limit( 5, ( $this->input->get( "page", 1 ) - 1) * 5 );
		$this->db->order_by( "customer_id", 'DESC' );
		$query = $this->db->get("customer");
		$dataArr = $query->result();

		$data['total'] = $this->db->count_all("customer");
		
		foreach ( $dataArr as $k=>$arr )
		{
			$reference = exeQuery( "SELECT CONCAT( c_firstname, ' ', c_lastname ) as reference FROM customer WHERE customer_id = ".$arr->c_reference_id );
			
			$data['data'][$k]['customer_id']= $arr->customer_id;
			$data['data'][$k]['c_slip_number']= $arr->c_slip_number;
			$data['data'][$k]['c_reference_id']= $arr->c_reference_id;
			$data['data'][$k]['c_reference']= ( $reference['reference'] ) ? $reference['reference'] : '-';
			$data['data'][$k]['c_firstname']= $arr->c_firstname;
			$data['data'][$k]['c_lastname']= $arr->c_lastname;
			$data['data'][$k]['c_emailid']= $arr->c_emailid;
			$data['data'][$k]['c_phoneno']= $arr->c_phoneno;
			$data['data'][$k]['c_city']= $arr->c_city;
			$data['data'][$k]['c_state']= $arr->c_state;
			$data['data'][$k]['c_pincode']= $arr->c_pincode;
			$data['data'][$k]['c_paid']= $arr->c_paid;
			$data['data'][$k]['c_created_date']= $arr->c_created_date;
		}
		
		echo json_encode($data);
	}
	
	/**
	 * Get customer reference record
	 */
	public function getReferenceRecord()
	{
		$this->db->where( 'c_reference_id', $this->input->get("id"));
		
		$query = $this->db->get("customer");
		$data['data'] = $query->result();
		$data['total'] = $this->db->count_all("customer");
		
		echo json_encode($data);
	}
	
	public function getRecordById()
	{
		$id = $this->input->get( 'id' );
		$this->db->where('customer_id', $id);
		$query = $this->db->get("customer");
		$data['data'] = $query->result();
		echo json_encode($data);
	}
	
	/**
	 * Store Data from this method.
	 *
	 * @return Response
	 */
	public function store()
	{
		$insert = $this->input->post();
		$this->db->insert('customer', $insert);
		
		$this->index();
// 		$id = $this->db->insert_id();
// 		$q = $this->db->get_where('customer', array('customer_id' => $id));
		
// 		echo json_encode($q->row());
	}
	
	/**
	 * Edit Data from this method.
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		$q = $this->db->get_where('customer', array('customer_id' => $id));
		echo json_encode($q->result());
	}
	
	
	/**
	 * Update Data from this method.
	 *
	 * @return Response
	 */
	public function update($id)
	{
		$insert = $this->input->post();
		$this->db->where('customer_id', $id);
		$this->db->update('customer', $insert);
		$q = $this->db->get_where('customer', array('customer_id' => $id));
		
		echo json_encode($insert);
	}
	
	/**
	 * Delete Data from this method.
	 *
	 * @return Response
	 */
	public function delete($id)
	{
		$this->db->where('customer_id', $id);
		$this->db->delete('customer');
		
		echo json_encode(['success'=>true]);
	}
}