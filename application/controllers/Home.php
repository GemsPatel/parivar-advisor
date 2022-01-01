<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller 
{
	function home()
	{
		parent::__construct();
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
// 	function _remap($method,$params)
// 	{
// 		if(method_exists($this,$method))
// 			return call_user_func_array(array($this, $method), $params);
// 		else
// 		{
// 			$para[0] = $method;
			
// 			if(count($params) > 0)
// 				$para = array_merge($para,$params);
				
// 			//here we are going to call out custom function for load specific menu.
// 			call_user_func_array(array($this,'index'),$para);
// 		}
// 	}
	
	public function index()
	{
		$data['pageName'] = 'dashboard';
		$this->load->view('site-layout',$data);
	}
	
	function displayTree()
	{
		$rows = executeQuery( "SELECT customer_id, c_reference_id FROM customer WHERE c_status = 1");
		
		$result = cmn_vw_buildTree( $rows );
		
		pr($result);
	}
	
	function buildTree(array $elements, $parentId = 0) 
	{
		$branch = array();
		
		foreach ($elements as $element) 
		{
			if ($element['c_reference_id'] == $parentId) 
			{
				$children = $this->buildTree($elements, $element['customer_id']);
				if ($children) 
				{
					$element['children'] = $children;
				}
				$branch[] = $element;
			}
		}
		
		return $branch;
	}
	
	/**
	 * @author Cloud Webs
	 * @abstract Autocomplete Client from database using name on listing page
	 */
	function getAutoCustomerName()
	{
		$keyword=$this->input->post('keyword');
		$data = cmn_vw_getAutoCustomerName( $keyword );
		echo json_encode($data);
	}
	
	/**
	 * @author Cloud Webs
	 * @abstract Autocomplete Client from database using name on listing page
	 */
	function getAutoCustomerPhoneno()
	{
		$keyword=$this->input->post('keyword');
		$data = cmn_vw_getAutoCustomerPhoneno( $keyword );
		echo json_encode($data);
	}
}
