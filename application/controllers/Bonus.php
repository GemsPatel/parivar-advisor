<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bonus extends CI_controller {
	
	var $is_ajax = false;
	var $cAutoId = 'bonus_map_id';
	var $cPrimaryId = '';
	var $cTable = 'bonus_map';
	var $controller = 'bonus';
	var $is_post = false;
	var $per_add = 1;
	var $per_edit = 1;
	var $per_delete = 1;
	var $per_view = 1;
	
	//parent constructor will load model inside it
	function Bonus()
	{
		parent::__construct();
		
		if( !$this->session->userdata('admin_id') )
			redirect('lgs');
		
		$this->load->model('Mdl_bonus','bns');
		$this->bns->cTableName = $this->cTable;
		$this->bns->cAutoId = $this->cAutoId; 
		$this->is_ajax = $this->input->is_ajax_request();
		
		if($this->input->get('item_id') != '' || $this->input->post('item_id') != '')
			$this->cPrimaryId  = $this->bns->cPrimaryId = _de($this->security->xss_clean($_REQUEST['item_id']));
		
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
		$num = $this->bns->getData();
		$data = pagiationData($this->controller,$num->num_rows(),$start,3);
		
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
	
	function bonusForm()
	{
		$this->bns->saveData();
	}
	
	function bonusPrint()
	{
		$dtArr = $this->bns->getBonusPrintData();
		$data['listArr'] = $dtArr->result_array();
		
		$data['pageName'] = $this->controller.'/'.$this->controller.'_print';
		$this->load->view('site-layout',$data);
	}
	
	function bonusFrontPrint()
	{
		$dtArr = $this->bns->getBonusPrintData();
		$data['listArr'] = $dtArr->result_array();
		$this->load->view( 'template/bonus_print', $data );
	}
	
	function export()
	{
// 		$res = $this->db->get($this->cTable);
		$listArr = executeQuery( "SELECT reference_customer_id, COUNT( level ) as total, level FROM customer_discount_map WHERE level <=5 GROUP BY reference_customer_id, level" );//$res->result_array();
		
		$ext = "xls";
		$col= array(array_keys($listArr[0]));
		$col= $col[0];
		exportExcel( "Bonus_".date('d-m-Y h-i-s').'.'.$ext, $col, $listArr, $ext );
		die;
	}
}