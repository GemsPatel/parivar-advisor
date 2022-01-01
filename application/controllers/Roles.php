<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Roles extends CI_controller {
	
	var $is_ajax = false;
	var $cAutoId = 'r_id';
	var $cPrimaryId = '';
	var $cTable = 'roles';
	var $controller = 'roles';
	var $is_post = false;
	var $per_add = 1;
	var $per_edit = 1;
	var $per_delete = 1;
	var $per_view = 1;
	
	//parent constructor will load model inside it
	function Roles()
	{
		parent::__construct();
		
		if( !$this->session->userdata('admin_id') )
			redirect('lgs');
		
		$this->load->model('Mdl_roles','cust');
		$this->cust->cTableName = $this->cTable;
		$this->cust->cAutoId = $this->cAutoId; 
		$this->is_ajax = $this->input->is_ajax_request();
		
		if($this->input->get('item_id') != '' || $this->input->post('item_id') != '')
			$this->cPrimaryId  = $this->cust->cPrimaryId = _de($this->security->xss_clean($_REQUEST['item_id']));
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
/*
+-----------------------------------------+
	Function will save data, all parameters 
	will be in post method.
+-----------------------------------------+
*/
	function rolesForm()
	{		
		$data = array();
		
		$this->form_validation->set_rules('r_name','Role','trim|required');
		
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
	function deleteData()
	{	
		$ids = $this->input->post('id');
		$this->cust->deleteData($ids);
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
	}
}