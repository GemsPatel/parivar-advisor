<?php
/**
 * @package pr_: adm_hlp 
 * @author cloud webs Team
 * @version 1.9
 * @abstract admin features helper
 */

/**
 * @author Cloud Webs
 * function check for restricted modules to be accessed by only devlopers
 */
function checkDevPermission()
{
	$CI =& get_instance();
	if( $CI->session->userdata("admin_id") != 5 && $CI->session->userdata("admin_id") != 30)
	{
		setFlashMessage('error', "Sorry! the module can be accessed by developers only.");
		adminRedirect('dashboard');
// 		adminRedirect('admin/dashboard');
	}
}

/**
 * @author Cloud Webs
 * @abstract function will check for permission of user for page where user going to be redirected  
 * if permission not available for specific page then user redirected to page where logged in admin has permission 
 * if no page available which particular user can access then user redirected to home page with message for asking to seek permission from super admin first.
 *	
 */
	function adminRedirect( $class='', $isredirect=false ) 
	{
		$CI =& get_instance();
		$class = str_replace(array(0=>'admin/',1=>'admin'),"",$class);
		if(!$isredirect)
		{
			$admin_user_id = $CI->session->userdata('admin_id');
			if($class!='')
			{
				$res = $CI->db->query("SELECT COUNT(permission_id) as Count FROM permission p 
										INNER JOIN admin_menu m ON m.admin_menu_id=p.admin_menu_id
										WHERE m.am_class_name='".$class."' AND p.admin_user_id=".$admin_user_id." AND permission_view=0 ")->row_array();
				
				if(!empty($res) && $res['Count']>=1)
				{
					$isredirect=true; 
				}
			}
		}

		if(!$isredirect)
		{
			$res = $CI->db->query("SELECT am_class_name FROM permission p 
									INNER JOIN admin_menu m ON m.admin_menu_id=p.admin_menu_id
									WHERE p.admin_user_id=".$admin_user_id." AND permission_view=0 LIMIT 1")->row_array();
									
			if(!empty($res))
			{
				$isredirect=true;					
				$class = $res['am_class_name'];
			}
		}
		
		unset($CI);
		if($isredirect)
		{
			redirect('admin/'.$class);
		}
		else
		{
			setFlashMessage('error',getErrorMessageFromCode('01021'));
			showPermissionDenied();
		}
	}

/*
 * @author   Cloud Webs
 * @abstract function will check current admin user 
 * @return true if yes else false
 */
function checkIsSuperAdmin( $is_power_admin=false )
{
	$CI = & get_instance();
	$admin_user_id = $CI->session->userdata('admin_id');
	$res;
	
	if( !$is_power_admin )
	{
		$res = $CI->db->query("SELECT COUNT(g.admin_user_group_id) as Count FROM admin_user_group g 
								INNER JOIN admin_user a ON a.admin_user_group_id=g.admin_user_group_id 
								WHERE ( admin_user_group_key='SUPER_ADMIN' OR admin_user_group_key='POWER_ADMIN' ) AND a.admin_user_id=".$admin_user_id."")->row_array();
	}
	else
	{
		$res = $CI->db->query("SELECT COUNT(g.admin_user_group_id) as Count FROM admin_user_group g 
								INNER JOIN admin_user a ON a.admin_user_group_id=g.admin_user_group_id 
								WHERE ( admin_user_group_key='POWER_ADMIN' ) AND a.admin_user_id=".$admin_user_id."")->row_array();
	}
	
	unset($CI);
	if(!empty($res) && $res['Count']>=1)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

/**
+++++++++++++++++++++++++++++++++++++++++++++++++++++
	@params : $controller  name of controller
			  $per_type name of permission type to check
			  
	@return : array
+++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
	function fetchPermission($controller)
	{
		$CI = & get_instance();
		$admin_id = $CI->session->userdata('admin_id');
		if($admin_id == '' || $admin_id == 0)
		{
			redirect('./admin');
		}
		
		$sql = "SELECT p.permission_add,p.permission_edit,p.permission_delete,p.permission_view FROM permission p INNER JOIN admin_menu m ON m.admin_menu_id=p.admin_menu_id WHERE p.admin_user_id=".$admin_id." AND m.am_class_name='".$controller."'";
		$res = $CI->db->query($sql);	
		if($res->num_rows() > 0)
		{
			$result =$res->row_array();
			unset($CI);
			return $result;
		}
		else
		{
			unset($CI);
			return '';
		}
	}
	
/**
+++++++++++++++++++++++++++++++++++++++++++++++++++++
	@params : $is_firstcall true if first time called in a recursive way
			  $name of select box
			  $optionArr option array
			  $setVal selected alue array
			  $extra property for input element
			  $i depth specifier in a multidimensional array
			  
	@return : string
+++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
	function form_dropdownMultiDimensional($is_firstcall,$name,$optionArr,$setVal='',$extra='',$i=-1)
	{
		$html = '';
		if($is_firstcall)
			$html = '<select name="'.$name.'" '.$extra.'>';
			
		$i++;
		foreach($optionArr as $k=>$ar)
		{
			if(is_array($ar))
			{
				$html .= '<optgroup label="'.str_repeat("-",$i)." ".$k.'" >';	
				$html .=  form_dropdownMultiDimensional(false,$name,$ar,$setVal,$extra='',$i);
				$html .= '</optgroup>';
			}
			else
			{
				if(is_array($setVal) && sizeof($setVal)>0)
				{
					if(in_array($k,$setVal))
						$html .= '<option value="'.$k.'" selected="selected">'.$ar.'</option>';
					else
						$html .= '<option value="'.$k.'">'.$ar.'</option>';
				}
				else
					$html .= '<option value="'.$k.'">'.$ar.'</option>';
			}
		}
		
		$html = str_replace("</select>","",$html);
		return $html."</select>";
	}

/*
+------------------------------------------------------------------+
	Function will fetch menus from database and prepare combox 
	accroding to it's level.
	$parent = Start parent id from where you want to make menu tree.
	$menuArr = Default first option value.
	$i = Level of category which will convert in (-) dash
	$encode = TRUE OR FALSE. if true then id will be base 64 encode form
+------------------------------------------------------------------+
*/
function getMultiLevelMenuDropdown($parent = 0,$menuArr = array('0'=>'---- Select Parent Category ----'), $i = -1,$encode = false,$parentName='')
{
	$CI =& get_instance();
	
	$res = $CI->db->select('category_id,category_name')->where('parent_id',$parent)->
	order_by('category_sort_order')->get('product_categories')->result_array();
				
	if(count($res) > 0 )
	{
		$i++;
		foreach($res as $r):
			if($encode == true)
				$menuArr[_en($r['category_id'])] = str_repeat(' - ',$i).$r['category_name'].$parentName;	
			else
				$menuArr[$r['category_id']] = str_repeat(' - ',$i).$r['category_name'].$parentName;	
			$menuArr = getMultiLevelMenuDropdown($r['category_id'], $menuArr, $i, $encode, $parentName." - ".$r['category_name']);
		endforeach;
		return $menuArr;
	}
	else 
		return $menuArr;
}

/* article category
+------------------------------------------------------------------+
	Function will fetch menus from database and prepare combox 
	accroding to it's level.
	$parent = Start parent id from where you want to make menu tree.
	$menuArr = Default first option value.
	$i = Level of category which will convert in (-) dash
	$encode = TRUE OR FALSE. if true then id will be base 64 encode form
+------------------------------------------------------------------+
*/
function getMultiLevelMenuDropdownArticle($parent = 0,$menuArr = array('0'=>'---- Select Parent Article Category ----'), $i = -1,$encode = false)
{
	$CI =& get_instance();
	
	$res = $CI->db->select('article_category_id,article_category_name')->where('article_category_parent_id',$parent)->
	order_by('article_category_sort_order')->get('article_category')->result_array();
	//pr($res);
	if(count($res) > 0 )
	{
		$i++;
		foreach($res as $r):
			if($encode == true)
				$menuArr[_en($r['article_category_id'])] = str_repeat(' - ',$i).$r['article_category_name'];	
			else
				$menuArr[$r['article_category_id']] = str_repeat(' - ',$i).$r['article_category_name'];	
			$menuArr = getMultiLevelMenuDropdownArticle($r['article_category_id'],$menuArr,$i,$encode);
		endforeach;
		return $menuArr;
	}
	else 
		return $menuArr;
}

function getMultiLevelAdminMenuDropdown($parent = 0,$menuArr = array('0'=>'-- Select Parent Menu --'), $i = -1,$encode = false)
{
	$CI =& get_instance();
		
	$res = $CI->db->select('admin_menu_id,am_name')->where('am_parent_id',$parent)->
	order_by('am_sort_order')->get('admin_menu')->result_array();
	
	if(count($res) > 0 )
	{
		$i++;
		foreach($res as $r):
			if($encode == true)
				$menuArr[_en($r['admin_menu_id'])] = str_repeat(' - ',$i).$r['am_name'];	
			else
				$menuArr[$r['admin_menu_id']] = str_repeat(' - ',$i).$r['am_name'];	
			$menuArr = getMultiLevelAdminMenuDropdown($r['admin_menu_id'],$menuArr,$i,$encode);
		endforeach;
		return $menuArr;
	}
	else 
		return $menuArr;
}

function getMultiLevelFrontMenuDropdown($menu_type_id=0,$parent = 0,$menuArr = array('0'=>'-- Select Parent Menu --'), $i = -1,$encode = false)
{
	$CI =& get_instance();
		
	$res = $CI->db->select('front_menu_id,front_menu_name')->where('fm_parent_id',$parent)->where('front_menu_type_id',$menu_type_id)->
	order_by('fm_sort_order')->get('front_menu')->result_array();
	
	if(count($res) > 0 )
	{
		$i++;
		foreach($res as $r):
			if($encode == true)
				$menuArr[_en($r['front_menu_id'])] = str_repeat(' - ',$i).$r['front_menu_name'];	
			else
				$menuArr[$r['front_menu_id']] = str_repeat(' - ',$i).$r['front_menu_name'];	
			$menuArr = getMultiLevelFrontMenuDropdown($menu_type_id,$r['front_menu_id'],$menuArr,$i,$encode);
		endforeach;
		return $menuArr;
	}
	else 
		return $menuArr;
}
/*

+------------------------------------------------------+
	Function will load seller dropdown array. which will 
	useful for filtering process and also for product 
	assigning
	$default - > default option value you want to put in array.
	$Ecnode - > Data will encode in base 64 or not
+------------------------------------------------------+
*/
function getSellerDropdownArr($default = array(''=>'Please select Seller'),$encode = false)
{
	$CI =& get_instance();
	
	if(!empty($default))
		$arr = $default;
	
	$CI->db->where('del_in','0');	 		
	$res = $CI->db->order_by('first_name')->get('sellers')->result_array();
	if($encode)
		foreach($res as $r)
			$arr[_en($r['seller_id'])] = $r['first_name']." ".$r['last_name'] ; 
	else
		foreach($res as $r)
			$arr[$r['seller_id']] = $r['first_name']." ".$r['last_name'] ; 
	
	return $arr;
}

/*
+------------------------------------------------------------------+
	Function will be help system to find next sort order. 
Input =>
	@params-> $inst : Object of model
			  $fieldName : Name of the sorting field
+------------------------------------------------------------------+
*/
function getSortOrder(&$inst,$field)
{
	$CI =& get_instance();
	
	if(check_db_column($inst->cTable, 'del_in'))
		$maxArr = $CI->db->select_max($field)->where('del_in','0')->get($inst->cTable)->row_array();
	else
		$maxArr = $CI->db->select_max($field)->get($inst->cTable)->row_array();
		
	$mx = ($maxArr[$field] != '') ? $maxArr[$field]+1:0;
	return $mx;
}

// Order status dropdown for admin panel
function getOrderStatusDropdown($sel='',$extra='')
{
	$CI =& get_instance();
	$res = $CI->db->where('order_status_status','0')->order_by('order_status_name')->get('order_status')->result_array();
	
	$arr = array(''=>'');
	foreach($res as $r)
		$arr[$r['order_status_id']] = $r['order_status_name']; 
		
	return form_dropdown('order_status_id',$arr,$sel,$extra);
}

// image size dropdown for admin panel
function getImageSizeDropdown($sel='')
{
	$CI =& get_instance();
	$res = $CI->db->where('image_size_status','0')->order_by('image_size_sort_order')->get('image_size')->result_array();

	$arr = array(''=>'-- Select image size --');
	foreach($res as $r)
		$arr[$r['image_size_id']] = $r['image_size_width'].' x '.$r['image_size_height'].' px'; 
		
	echo form_dropdown('image_size_id',$arr,$sel,'');
}

/*
+------------------------------------------------------------------+
	Function will fetch menus from database and prepare combox 
	accroding to it's level.
	$parent = Start parent id from where you want to make menu tree.
	$menuArr = Default first option value.
	$i = Level of category which will convert in (-) dash
	$encode = TRUE OR FALSE. if true then id will be base 64 encode form
+------------------------------------------------------------------+
*/
function getMultiLevelWithOptGroup($select,$sort,$table_name,$parent = 0,$parent_field='',$menuArr = array('0'=>'---- Select Parent Category ----'), $encode = false)
{
	
	$CI =& get_instance();

	$res = $CI->db->select($select)->where($parent_field,$parent)->
	order_by($sort)->get($table_name)->result_array();
						
	if(count($res) > 0 )
	{
		foreach($res as $r):
			$res_child = $CI->db->select($select)->where('parent_id',$r['category_id'])->order_by($sort)->get($table_name)->result_array();
			if($encode == true)
			{
				if(count($res_child) > 0)
				{
					$menuArr[$r['category_name']] = getMultiLevelWithOptGroup($select,$sort,$table_name,$r['category_id'],$parent_field,'',$encode);	
				}
				else	
				{			
					$menuArr[_en($r['category_id'])] = $r['category_name'];	
				}
			}
			else
			{
				if(count($res_child) > 0)
				{
					$menuArr[$r['category_name']] = getMultiLevelWithOptGroup($select,$sort,$table_name,$r['category_id'],$parent_field,'',$encode);	
				}
				else	
				{			
					$menuArr[$r['category_id']] = $r['category_name'];	
				}
			}
		endforeach;
		return $menuArr;
	}
	else 
		return $menuArr;
}

/*
+------------------------------------------------------------------+
	Function is save admin log. 
	@params : $className -> controller name
			  $itemName -> controller item name
			  $dbTableName -> name of db table
			  $dbTableField -> name of table field
			  $primaryId -> table primary id
			  $logType -> type of add/edit/delete
+------------------------------------------------------------------+
*/
function saveAdminLog($className, $itemName, $dbTableName, $dbTableField, $primaryId, $logType)
{
	$CI =& get_instance();
	$data = array(
			'admin_user_id' => $CI->session->userdata('admin_id'),
			'admin_class_name' => @$className,
			'module_item_name' => @$itemName,
			'module_table_name' => @$dbTableName,
			'module_table_field' => @$dbTableField,
			'module_primary_id' => @$primaryId,
			'admin_log_type' => @$logType,
			'admin_log_ip' => @$CI->input->ip_address()
			);
	
	$CI->db->insert('admin_log', $data);

}

/*
 * @author Cloud Webs
 * @abstract function will set all sessions related to login and perform other login related activity
*/
function setLoginSessionsAdmin($sessArr)
{	
	
	$CI =& get_instance();
	$CI->session->set_userdata( $sessArr ); //set session 
	saveLogins( $sessArr['admin_id'], 'A');
}

/*
author :Cloud Webs
select field in all tables where category field located
its fetch two fields from one table
*/	
function isFieldIdExist($tableArr,$field_nameArr,$cur_id,$is_like=false)
{
	$CI =& get_instance();

	foreach($tableArr as $k=>$ar)
	{
		//$sql = $CI->db->query("SELECT ".$field_nameArr[$k]." FROM ".$ar." where image_size_id = ".$cur_id."");
		if($is_like)
		{
			$sql = $CI->db->query("SELECT   ".$field_nameArr[$k]." FROM  ".$ar." where ".$field_nameArr[$k]." like '".$cur_id."' OR ".$field_nameArr[$k]." like '".$cur_id."|%' OR ".
			$field_nameArr[$k]." like '%|".$cur_id."|%' OR ".$field_nameArr[$k]." like '%|".$cur_id."'");
		}
		else
		{
			$sql = $CI->db->query("SELECT   ".$field_nameArr[$k]." FROM  ".$ar." where ".$field_nameArr[$k]."=".$cur_id."");
		}
			$get_data = $sql->num_rows();
		if($get_data > 0)
		{
			unset($CI);
			return array('type'=>'error','msg'=>'This category cannot be deleted as it is currently assigned to  '.$get_data.'&nbsp;'.ucwords(str_replace("_"," ",$ar)));
		}
	}
	unset($CI);			
	return array();
}

/*
author :Cloud Webs
select field in all tables where one field located(used in product_category model)
its fetch three  fields from one table
*/	
function isFieldIdExistMul($tableArr,$field_nameArr,$valArr)
{
	$CI =& get_instance();

	foreach($tableArr as $k=>$ar)
	{
			
		$where = "";
		foreach($field_nameArr[$k] as $key=>$val)
		{
			$where .= $val. " = '" .$valArr[$k][$key]. "' AND ";	
		}
		
		$where = substr($where,0,-4);
		//$sql = $CI->db->query("SELECT   ".$field_nameArr[$k][1]." FROM  ".$ar." ".($where!="")?" WHERE ".$where:" ");
		$sql = $CI->db->query("SELECT   ".$field_nameArr[$k][0]." FROM  ".$ar." ".(($where!="")?' WHERE '.$where:'')."");
		//echo $CI->db->last_query();
		$get_data = $sql->num_rows();
		if($get_data > 0)
		{
			unset($CI);			
			return array('type'=>'error','msg'=>'This category cannot be deleted as it is currently assigned to  '.$get_data.'&nbsp;'.ucwords(str_replace("_"," ",$ar)));
		}
	}
	unset($CI);			
	return array();
}

/**
 * @abstract Redirects user to default permission denied page if permission is not given
 */
	function showPermissionDenied()
	{
		$msg = getFlashMessage('error');
		if(empty($msg))
		{
			setFlashMessage('error',getErrorMessageFromCode('01022'));
		}
		else
		{
			setFlashMessage('error',$msg);
		}
		
		redirect('admin/lgs');
	}

	/**
	 * 
	 */
	function inventroyAttributeQuery()
	{
		return "SELECT inventory_master_specifier_id, CONCAT( ims_tab_label, ' - ', it_name ) AS ims_tab_label 
								FROM  inventory_master_specifier ims INNER JOIN inventory_type it
								ON it.inventory_type_id=ims.inventory_type_id 
								WHERE ims_status=0 AND ims_input_type IN ( ".inventroyAttributeMasterInputTypes()." ) ";
	}
	
/**
 * Checkbox Field rendering from master attributes array
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	bool
 * @param	string
 * @return	string
 */
	function form_checkboxArry($name, $product_attributeArr, $checked = FALSE, $extra = '')
	{
		$html = "";
		
		if( !isEmptyArr($product_attributeArr) )
		{
			foreach ($product_attributeArr as $k=>$ar)
			{
				$html .= form_checkbox( $name, $k, $checked, ' id="'.$name.'_'.$k.'" ').' <label for="'.$name.'_'.$k.'">'.$ar.'</label> <br>';
			}
		}
		
		return $html;
	}

	/**
	 * Radio Field rendering from master attributes array
	 *
	 * @access	public
	 * @param	mixed
	 * @param	string
	 * @param	bool
	 * @param	string
	 * @return	string
	 */
	function form_radioArry($name, $product_attributeArr, $checked = FALSE, $extra = '')
	{
		$html = "";
		
		if( !isEmptyArr($product_attributeArr) ) 
		{
			foreach ($product_attributeArr as $k=>$ar)
			{
				$html .= form_radio( $name, $k, $checked, ' id="'.$name.'_'.$k.'" ').' <label for="'.$name.'_'.$k.'">'.$ar.'</label> <br>';
			}
		}
		
		return $html;
	}
	
	/**
	 * 
	 */
	function deleteProductFromProductPrice($product_id)
	{
		query("DELETE FROM pp_pss_index_map WHERE product_id=".$product_id." ");
		query("DELETE FROM product_price_cctld WHERE product_price_id IN 
				(SELECT product_price_id FROM product_price WHERE product_id=".$product_id." ) ");
		query("DELETE FROM product_price WHERE product_id=".$product_id." ");
	}

	/**
	 *
	 */
	function deleteProduct($product_id)
	{
		query("DELETE FROM product_cctld WHERE product_id=".$product_id." ");
		query("DELETE FROM product WHERE product_id=".$product_id." ");
	}
	
	
	/***************************************** language functions ***************************************************/

	/**
	 * 
	 */
	function getCurrencyForCountryCode( $country_code )
	{
		$resCurr = executeQuery( " SELECT c.currency_id, c.currency_code, c.currency_symbol, c.currency_value
					   FROM currency c INNER JOIN country co
					   ON co.country_id=c.country_id
					   WHERE co.country_code='".COUNTRY_CODE."' AND c.currency_status=0 ");
				
		if( !empty( $resCurr ) && !empty( $resCurr[0]['currency_value'] ) )
		{
			return $resCurr[0];
		}
		else
		{
			return getDefaultCurrency();
		}
	}
	
	/***************************************** language functions end ***********************************************/
	
?>