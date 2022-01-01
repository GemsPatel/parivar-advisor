<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Emi extends CI_controller {
	
	var $is_ajax = false;
	var $cAutoId = 'customer_id';
	var $cPrimaryId = '';
	var $cTable = 'customer';
	var $controller = 'emi';
	var $is_post = false;
	var $per_add = 1;
	var $per_edit = 1;
	var $per_delete = 1;
	var $per_view = 1;
	
	//parent constructor will load model inside it
	function Emi()
	{
		parent::__construct();
		
		if( !$this->session->userdata('admin_id') )
			redirect('lgs');
		
		$this->load->model('Mdl_customer','cust');
		$this->cust->cTableName = $this->cTable;
		$this->cust->cAutoId = $this->cAutoId; 
		$this->is_ajax = $this->input->is_ajax_request();
		
		if($this->input->get('item_id') != '' || $this->input->post('item_id') != '')
			$this->cPrimaryId  = $this->cust->cPrimaryId = _de($this->security->xss_clean($_REQUEST['item_id']));
		
// 		$this->chk_permission();	
	}

/*
+-----------------------------------------+
	This function will remap url for admin,
	and remove unnecesary name from url.
	For exaconle : if we don't want index
	strgin in url while listin item, we can 
	remove it using this function
+-----------------------------------------+
*/	
	function _remap($method,$params)
	{
		if(method_exists($this,$method))
			return call_user_func_array(array($this, $method), $params);
		else
		{
			$para[0] = $method;
			
			if(count($params) > 0)
				$para = array_merge($para,$params);
			
			//here we are going to call out custom function for load specific menu.
			call_user_func_array(array($this,'index'),$para);
		}
	}
	
	
	
	function index($start = 0)
	{
		$num = $this->cust->getData();
		$data = pagiationData($this->controller,$num->num_rows(),$start,3);
		//echo $this->db->last_query();
		
		$data['start'] = $start;
		$data['total_records'] = $num->num_rows();
		$data['per_page_drop'] = per_page_drop();
		$data['srt'] = $this->input->get('s'); // sort order
		$data['field'] = $this->input->get('f'); // sort field name
		
		
		if( isset( $_GET['c_slip_number']) && $_GET['c_slip_number'] )
		{
			if( $data['total_rows'] == 1 )
			{
// 				redirect( $this->controller.'/'.$this->controller.'PaymentForm?edit=true&item_id='._en( $data['listArr'][0]['customer_id']) );
// 				$data['pageName'] = $this->controller.'/'.$this->controller.'_list';
// 				$this->load->view('site-layout',$data);
				$this->cPrimaryId = $data['listArr'][0]['customer_id'];
				$this->emiPaymentForm();
			}
		}
		else 
		{
			$data = array();
			$data['pageName'] = $this->controller.'/'.$this->controller.'_list';
			$this->load->view('site-layout',$data);
		}
		
// 		else 
// 		{
// 			if($this->is_ajax)
// 			{
// 				$this->load->view( $this->controller.'/ajax_html_data',$data);
// 			}
// 			else
// 			{
// 				$data['pageName'] = $this->controller.'/'.$this->controller.'_list';
// 				$this->load->view('site-layout',$data);
// 			}
// 		}
	}
	
	function getReport( )
	{
		$dtArr = $this->cust->getData();
		$data['listArr'] = $dtArr->result_array();

		$this->load->view('template/customer_report', $data );
	}

	/*
	 +-----------------------------------------+
	 Function will save data, all parameters
	 will be in post method.
	 +-----------------------------------------+
	 */
	function emiPaymentForm()
	{
		$data = array();
		
		$this->form_validation->set_rules('cpm_payment','Payment','trim|required');
		
		$this->is_post = true;
		if($this->form_validation->run() == FALSE )
		{
			$data['error'] = $this->form_validation->get_errors();
			setFlashMessage('error',getErrorMessageFromCode('01005'));
			
			if($this->cPrimaryId != '') // if primary id then we have to fetch those primary Id data
			{
				$dtArr = $this->cust->getPaymentData();
				$data['listArr'] = $dtArr->result_array();
			}
			
			$data['pageName'] = $this->controller.'/'.$this->controller.'_payment_form';
			$this->load->view('site-layout',$data);
		}
		else // saving data to database
		{
			
			$this->cust->cPrimaryId = $this->cPrimaryId; // setting variable to model
			$this->cust->savePaymentData();
			
			redirect($this->controller.'/'.$this->controller.'PaymentForm?edit=true&item_id='._en( $this->cPrimaryId ) );
		}
	}
	
	function emiGraph()
	{
		$data = array();
		$data['customer_id'] = $customerId = (int)_de( $this->input->get( 'item_id' ) );
		
		$data['result'] = cmn_vw_buildTree( fetchChainTreeList( $customerId ), $customerId );
		
// 		if( $customerId )
// 		{
// 			$rows = executeQuery( "SELECT * FROM customer WHERE c_reference_id = ".$customerId );
// 			if( isset( $rows ) && !empty( $rows) )
// 			{
// 				$data['result'] = cmn_vw_buildTree( $rows, $customerId );
// 			}
// 		}
		
		$data['pageName'] = $this->controller.'/'.$this->controller.'_graph';
		$this->load->view('site-layout',$data);
	}
	
	function emiPrint()
	{
		$data = array();
		$data['refArr'] = array();
		
		$customerId = (int)_de( $this->input->get( 'item_id' ) );
		
		if( $customerId )
		{
			$rows = executeQuery( "SELECT * FROM customer WHERE c_reference_id = ".$customerId );
			if( isset( $rows ) && !empty( $rows) )
			{
				$data['refArr'] = cmn_vw_buildTree( $rows, $customerId );
			}
		}
		
		$dtArr = $this->cust->getPaymentData();
		$data['payArr'] = $dtArr->result_array();
		
		$dtArr = $this->cust->getData();
		$data['custArr'] = $dtArr->result_array();
		
		$this->load->view( 'template/customer_graph_print', $data );
	}
}