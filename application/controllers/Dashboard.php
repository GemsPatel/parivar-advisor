<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller 
{
	var $is_ajax = false;
	var $cAutoId = 'customer_id';
	var $cPrimaryId = '';
	var $cTable = 'customer';
	var $controller = 'dashboard';
	var $is_post = false;
	var $per_add = 1;
	var $per_edit = 1;
	var $per_delete = 1;
	var $per_view = 1;
	
	function Dashboard()
	{
		parent::__construct();
		
		if( !$this->session->userdata('admin_id'))
			redirect('lgs');
		
		$this->load->model('Mdl_customer','cust');
		$this->cust->cTableName = $this->cTable;
		$this->cust->cAutoId = $this->cAutoId;
		$this->is_ajax = $this->input->is_ajax_request();
// 		$this->load->model('mdl_home','hom');
	}
	
	/*
	 +-----------------------------------------+
	 This function will remap url for admin,
	 and remove unnecesary name from url.
	 For example : if we don't want index
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
	
	public function index( $start = 0)
	{
		$data['customer_id'] = (int)$this->session->userdata('admin_customer_id');
		
		//Customer Report
		$data['last_day'] = exeQuery( "SELECT Count(customer_id) as last_day FROM customer WHERE c_created_date BETWEEN CURDATE() - INTERVAL 1 DAY AND CURDATE()" );
		$data['last_month'] = exeQuery( "SELECT Count(customer_id) as last_month FROM customer WHERE YEAR(c_created_date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(c_created_date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) ");
		$data['current_year'] = exeQuery( "SELECT Count(customer_id) as current_year FROM customer WHERE YEAR(c_created_date) = YEAR(CURDATE()) " );
		$data['total'] = exeQuery( "SELECT Count(customer_id) as total FROM customer" );
		
		//Payment Report
// 		$data['paymemt_last_day'] = exeQuery( "SELECT SUM(cpm_payment) as last_day FROM customer_payment_map WHERE cmp_created_date BETWEEN CURDATE() - INTERVAL 1 DAY AND CURDATE()" );
// 		$data['paymemt_last_month'] = exeQuery( "SELECT SUM(cpm_payment) as last_month FROM customer_payment_map WHERE YEAR(cmp_created_date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(cmp_created_date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) ");
// 		$data['paymemt_current_year'] = exeQuery( "SELECT SUM(cpm_payment) as current_year FROM customer_payment_map WHERE YEAR(cmp_created_date) = YEAR(CURDATE()) " );
// 		$data['paymemt_total'] = exeQuery( "SELECT SUM(cpm_payment) as total FROM customer_payment_map" );
		
		//Payment Commission Report
		$data['commission_last_day'] = exeQuery( "SELECT SUM(cpm_payment) as last_day FROM customer_pay_map WHERE cmp_created_date BETWEEN CURDATE() - INTERVAL 1 DAY AND CURDATE()" );
		$data['commission_last_month'] = exeQuery( "SELECT SUM(cpm_payment) as last_month FROM customer_pay_map WHERE YEAR(cmp_created_date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(cmp_created_date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) ");
		$data['commission_current_year'] = exeQuery( "SELECT SUM(cpm_payment) as current_year FROM customer_pay_map WHERE YEAR(cmp_created_date) = YEAR(CURDATE()) " );
		$data['commission_total'] = exeQuery( "SELECT SUM(cpm_payment) as total FROM customer_pay_map" );
		
		
		// Payment
		$data['resultPayment'] = $data['result'] = $data['listArr'] = array();
		
		if( (int)$this->session->userdata('is_login') == 2 )
		{
			$data['result'] = cmn_vw_buildTree( fetchChainTreeList( $data['customer_id']), $data['customer_id']);
			
			$this->db->where( "customer_id", $data['customer_id'] );
			$res = $this->db->get( "customer_payment_map" );
			$data['listArr'] = $res->result_array();
			
			$data['resultPayment'] = executeQuery( "SELECT c.customer_id, COUNT( cpm.cpm_payment ) as total_evm, SUM( cpm.cpm_payment ) as total_payment, c_slip_number as slip_number, c.c_book_amt, c.c_total_amt, CONCAT( c_firstname, ' ', c_lastname ) as customer_name, c.c_phoneno as phone_no, c_commission_pay_amt as commission
								FROM customer c
								LEFT JOIN customer_payment_map cpm ON cpm.customer_id = c.customer_id" );
		}
		
		//Commission Report
		$num = $this->cust->getCustomerDiscountData();
		$paymentChainArr = pagiationData($this->controller,$num->num_rows(),$start,3);
		
		$paymentChainArr['start'] = $start;
		$paymentChainArr['total_records'] = $num->num_rows();
		$paymentChainArr['per_page_drop'] = per_page_drop();
		$paymentChainArr['srt'] = $this->input->get('s'); // sort order
		$paymentChainArr['field'] = $this->input->get('f'); // sort field name
		
		if($this->is_ajax)
		{
			$this->load->view( 'commission_report_ajax_html_data',$paymentChainArr);
		}
		else
		{
			$data['paymentChainArr'] = $paymentChainArr;
			$data['pageName'] = 'dashboard';
			$this->load->view('site-layout',$data);
		}
	}
}
