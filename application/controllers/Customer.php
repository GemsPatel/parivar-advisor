<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customer extends CI_controller {
	
	var $is_ajax = false;
	var $cAutoId = 'customer_id';
	var $cPrimaryId = '';
	var $cTable = 'customer';
	var $controller = 'customer';
	var $is_post = false;
	var $per_add = 1;
	var $per_edit = 1;
	var $per_delete = 1;
	var $per_view = 1;
	
	//parent constructor will load model inside it
	function Customer()
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
/**
+----------------------------------------------------+
	check permission for user
+----------------------------------------------------+
*/
	function chk_permission()
	{
		$per =  fetchPermission($this->controller);
		if(!empty($per))
		{
			$this->per_add = @$per['permission_add'];		
			$this->per_edit = @$per['permission_edit'];		
			$this->per_delete = @$per['permission_delete'];		
			$this->per_view = @$per['permission_view'];		
		}
		else 
		{
			showPermissionDenied();
		}
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
	
	function customerEmail($str)
	{
		if($this->cPrimaryId)
			$this->db->where($this->cAutoId." !=",$this->cPrimaryId);
			
		$c = $this->db->where('c_emailid',$str)->get($this->cTable)->num_rows();
		if($c > 0)
		{
			$this->form_validation->set_message('customerEmail', 'This '.$str.' already exist in database, please try different.');
			return false;
		}
		else
		return true;
	}
	
	function customerPhone($str)
	{
		$c = $this->db->where('c_phoneno',$str)->get($this->cTable)->num_rows();
		
		if($c > 0)
		{
			$this->form_validation->set_message('customerPhone', 'This '.$str.' already exist in database, please try different.');
			return false;
		}
		else
			return true;
	}
	
	function customerSlipID($str)
	{
		$c = $this->db->where('c_slip_number',$str)->get($this->cTable)->num_rows();
		
		if($c > 0)
		{
			$this->form_validation->set_message('customerSlipID', 'This '.$str.' already exist in database, please try different.');
			return false;
		}
		else
			return true;
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
		
		if( $data['total_rows'] == 1 && ( isset( $_GET['c_slip_number'] ) && !empty( $_GET['c_slip_number'] ) ) )
		{
			redirect( $this->controller.'/'.$this->controller.'PaymentForm?edit=true&item_id='._en( $data['listArr'][0]['customer_id']) );
		}
		else 
		{
			if($this->is_ajax)
			{
				$this->load->view( $this->controller.'/ajax_html_data',$data);
			}
			else
			{
				$data['pageName'] = $this->controller.'/'.$this->controller.'_list';
				$this->load->view('site-layout',$data);
			}
		}
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
	function customerForm()
	{		
		$data = array();
		
		$this->form_validation->set_rules('c_slip_number','Slip Number','trim|required|callback_customerSlipID');
		$this->form_validation->set_rules('c_firstname','First Name','trim|required');
		$this->form_validation->set_rules('c_lastname','Last Name','trim|required');
		$this->form_validation->set_rules('c_book_amt','Book Amount','trim|required');
		$this->form_validation->set_rules('c_address','Address','trim|required');
		$this->form_validation->set_rules('c_city','City','trim|required');
		$this->form_validation->set_rules('c_state','State','trim|required');
		$this->form_validation->set_rules('c_pincode','Pincode','trim|required');
		$this->form_validation->set_rules('c_emailid','Customer Email Id','trim|required|valid_email|callback_customerEmail');
		$this->form_validation->set_rules('c_phoneno','Customer Phone No','trim|required|numeric');//|callback_customerPhone
		$this->form_validation->set_rules('skim_id','Skim Name','trim|required');
		$this->form_validation->set_rules('c_plot_size','Size','trim|required');
		$this->form_validation->set_rules('c_book_amt','Booking','trim|required');
		$this->form_validation->set_rules('c_total_amt','Total','trim|required');
		$this->form_validation->set_rules('c_payment_option','Total Amount','trim|required');
		
		if( isset( $_POST['c_payment_option']) && $_POST['c_payment_option'] == 2 )
		{
			$this->form_validation->set_rules('c_bank_name','Bank Name','trim|required');
			$this->form_validation->set_rules('c_check_number','Check Number','trim|required');
		}
		
		if( $this->input->get('edit') == 'true' )
		{
			$dt =  array();
			if($this->cPrimaryId != '') // if primary id then we have to fetch those primary Id data
			{
				$dtArr = $this->cust->getData();
				$dt = $dtArr->row_array();
			}
			
			$dt['pageName'] = $this->controller.'/'.$this->controller.'_form';
			$this->load->view('site-layout',$dt);
		}
		else if( $this->input->get('show') == 'true' )
		{
			$dt =  array();
			if($this->cPrimaryId != '') // if primary id then we have to fetch those primary Id data
			{
				$dtArr = $this->cust->getData();
				$dt = $dtArr->row_array();
			}
			
			$dt['pageName'] = $this->controller.'/'.$this->controller.'_show';
			$this->load->view('site-layout',$dt);
		}
		else
		{
			$this->is_post = true;
			if($this->form_validation->run() == FALSE )
			{
				$data['error'] = $this->form_validation->get_errors();
				setFlashMessage('error',getErrorMessageFromCode('01005'));
				
				$data['pageName'] = $this->controller.'/'.$this->controller.'_form';
				$this->load->view('site-layout',$data);
			}
			else // saving data to database
			{
				
				$this->cust->cPrimaryId = $this->cPrimaryId; // setting variable to model
				$this->cust->saveData();
				
				redirect($this->controller);
			}
		}
		
	}
	
	/*
	 +-----------------------------------------+
	 Function will save data, all parameters
	 will be in post method.
	 +-----------------------------------------+
	 */
	function customerPaymentForm()
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
			
			redirect( $this->controller );//.'/'.$this->controller.'PaymentForm?edit=true&item_id='._en( $this->cPrimaryId )
		}
	}
	
	/*
	 +-----------------------------------------+
	 Update Payment Thrasuld for by mistake insert
	 @params : post of ids,payment
	 +-----------------------------------------+
	 */
	function customerUpdateCPMPayment()
	{
		$this->cust->updateCPMPayment();
		redirect( $this->controller.'/'.$this->controller.'PaymentForm?edit=true&item_id='._en( $_POST['item_id'] ) );
	}
	
	function customerGraph()
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
	
	function customerPrint()
	{
		$data = array();
		$data['refArr'] = array();
		
		$data['customerId'] = $customerId = (int)_de( $this->input->get( 'item_id' ) );
		
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
/*
+-----------------------------------------+
	Delete data, single and multiple
	 from single function call.
	@params : Item id. OR post array of	ids
+-----------------------------------------+
*/
/*
 * @author   Cloud Webs
 * @abstract function will load city as per state selected
 */
	function loadCityAjax()
	{
		$state_id = $this->input->post('state_id');
		if(!empty($state_id))
		{
			echo loadCity($state_id);
		}
		else
		{
			echo '<option value="">- Select State First -</option>';	
		}
	}
/*
 * @author   Cloud Webs
 * @abstract function will load area as per city selected
 */
	function loadAreaAjax()
	{
		$city_name = $this->input->post('city_name');
		$state_id = $this->input->post('sta_id');
		if($city_name!='' && $state_id)
		{
			echo loadArea($city_name,$state_id);
		}
		else
		{
			echo '<option value="">- Select City First -</option>';	
		}
	}

/*
 * @author   Cloud Webs
 * @abstract function will load pincode as per area selected
 */
	function loadPincodeAjax()
	{
		$area_name = $this->input->post('area_name');
		$city_name = $this->input->post('city_name');
		$state_id = $this->input->post('sta_id');
		if($area_name!='')
		{
			echo json_encode(loadPincode($area_name,$city_name,$state_id));
		}
		else
		{
			return json_encode(array('pincode_id'=>'','pincode'=>''));	
		}
	}
		
	function deleteData()
	{	
// 		if($this->per_delete == 0)
// 		{
			$ids = $this->input->post('id');
			$this->cust->deleteData($ids);
// 		}
// 		else
// 			echo json_encode(array('type'=>'error','msg'=>getErrorMessageFromCode('01009')));
	}
/*
+-----------------------------------------+
	Update status for enabled/disabled
	@params : post array of ids,status
+-----------------------------------------+
*/	
	function updateStatus()
	{
		$this->cust->updateStatus();
// 		else
// 			echo json_encode(array('type'=>'error','msg'=>getErrorMessageFromCode('01008')));	
	}
/*
+-----------------------------------------+
	This Function will product information 
	downloaded and create csv/xls file.
+-----------------------------------------+
*/	
	function exportData()
	{
		$res = $this->db->get($this->cTable);
		$listArr = $res->result_array();
		
		$ext = $this->input->post($this->controller.'_export');
		$col= array(array_keys($listArr[0]));
		$col= $col[0];
		exportExcel($this->cTable.'_'.date('Y-m-d').'.'.$ext, $col, $listArr, $ext);
		die;
	}
	/*
* @abstract fetch state as per country id passed
* 
*/
	function getState()
	{
		$countryid = $this->input->post('country_id');
		$name = $this->input->post('name');
		echo loadStateDropdown($name,$countryid);
	}
	

/**
 * @author Cloud Webs
 * @abstract add address in customer page
 */
	function addAddress()
	{
		$dt['address_row'] = $this->input->post('address_row');
		$add_form =  $this->load->view($this->controller.'/add_address',$dt, TRUE);
// 		$add_form =  $this->load->view('admin/'.$this->controller.'/add_address',$dt, TRUE);
		echo $add_form;
	}
	

}