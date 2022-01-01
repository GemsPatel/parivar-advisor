<?php
/**
 * @package cs_: cmn_vw
 * @version 1.0
 * @author Cloud Webs Team
 * common view helper<br> 
 * layer functions which responds to both Web and REST clients  
 */



/**
 * contact us form
 */
function cmn_vw_contact()
{
	$CI =& get_instance();
	$CI->load->model('mdl_home','hom');
	$cmn_vw = array();

	$CI->form_validation->set_rules('pm_name','Full Name','trim|required');
	$CI->form_validation->set_rules('pm_email','Email Id','trim|required|valid_email');
	$CI->form_validation->set_rules('pm_phone','Phone Number','trim|required|numeric');
	$CI->form_validation->set_rules('pm_message','Message','trim|required');

	$data = array();
	if($CI->form_validation->run() == FALSE)
	{
		if( is_restClient() )
		{
			$data["type"] = "error";
			$data['msg'] = getErrorMessageFromCode('01005');
			$data["error"] = $CI->form_validation->get_errors();
		}
		else
		{
			$data = $CI->form_validation->get_errors();
			echo json_encode($data);
		}
	}
	else
	{
		if( is_restClient() )
		{
			$CI->hom->feedback();
			$data["type"] = "success";
			$data['msg'] = getLangMsg("s_msg");
		}
		else
		{
			$CI->hom->feedback();
			$data['success'] = getLangMsg("s_msg");
			echo json_encode($data);
		}
	}

	/**
	 *
	 */
	if( is_restClient() )
	{
		/**
		 * check if validation error then format error array for REST
		 */
		if( $data["type"] == "error" )
		{
			$data["eKA"] = array(); $data["eVA"] = array();
			
			if( isset($data["error"]) && !isEmptyArr($data["error"]) )
			{
				foreach ($data["error"] as $k=>$ar)
				{
					$data["eKA"][] = $k;
					$data["eVA"][] = $ar;
				}
				unset($data["error"]);
			}
		}
			
		$cmn_vw["data"] = $data;
		return $cmn_vw;
	}
	
}	

/******************************* login signup functions ***********************************/

/**
 * 
 * @return multitype:NULL Ambigous <multitype:, string, number, NULL, multitype:string , unknown>
 */
function cmn_vw_guestSignup()
{
	$CI =& get_instance();
	$CI->load->model('mdl_checkout','che');
	$cmn_vw = array();
	$returnArr = array();

	$CI->form_validation->set_rules('login_email','Email','trim|required|valid_email|callback_checkMailDuplication');
	
	//
	$data = array();
	if($CI->form_validation->run() == FALSE)
	{
		if( is_restClient() )
		{
			$data["type"] = "error";
			$data['msg'] = getErrorMessageFromCode('01005');
			$data["error"] = $CI->form_validation->get_errors();
		}
		else
		{
    		//$customer_emailid = $CI->input->post('login_email');
    			
    		$returnArr['type'] = 'error';
    		$returnArr['error'] = $CI->form_validation->get_errors();
		}

	}
	else
	{
		if( is_restClient() )
		{
			$data = $CI->che->guestSignup();
			$data["type"] = "success";
			$data['msg'] = "";
		}
		else
		{
			$returnArr = $CI->che->guestSignup();
		}
	}

	/**
	 *
	 */
	if( is_restClient() )
	{
		/**
		 * check if validation error then format error array for REST
		 */
		if( $data["type"] == "error" )
		{
			$data["eKA"] = array(); $data["eVA"] = array();
			
			if( isset($data["error"]) && !isEmptyArr($data["error"]) )
			{
				foreach ($data["error"] as $k=>$ar)
				{
					$data["eKA"][] = $k;
					$data["eVA"][] = $ar;
				}
				unset($data["error"]);
			}
		}
		else if( $data['type']=='success' )
		{
			//set all login sessions and upd cart/wish database
			$cmn_vw["lgnS"] = setLoginSessions($data['customer_id'], $data['customer_group_type'], $data['customer_emailid']);
			 
			unset($data['customer_id']);
			unset($data['customer_group_type']);
			unset($data['customer_emailid']);
		}
		
		
		$cmn_vw["data"] = $data;
		return $cmn_vw;
	}
	else 
	{
		if($returnArr['type']=='success')
		{
			//set all login sessions and upd cart/wish database
			setLoginSessions($returnArr['customer_id'], $returnArr['customer_group_type'], $returnArr['customer_emailid']);
			 
			unset($returnArr['customer_id']);
			unset($returnArr['customer_group_type']);
			unset($returnArr['customer_emailid']);
		}
		
		echo json_encode($returnArr);
	}
}


/**
 * Create Date 08-05-2015 For Use restAPI
 * Login / Signin Form
 */
function cmn_vw_login()
{
	$CI =& get_instance();
	$CI->load->model('mdl_login','lgn');
	$CI->lgn->cTable = "customer";
	$CI->lgn->cAutoId = "customer_id";

	$data = array();
	$cmn_vw = array();

	$CI->form_validation->set_rules('login_email','Email Address','trim|required|valid_email');
	$CI->form_validation->set_rules('login_password','Password','trim|required');
	
	if( is_restClient() )
	{
		if($CI->input->post() != '')
		{
		
			if($CI->form_validation->run() == FALSE)
			{
				$data["type"] = "error";
				$data['msg'] = getErrorMessageFromCode('01005');
				$data["error"] = $CI->form_validation->get_errors();
				//$returnArr['error'] = $CI->form_validation->get_errors();
			}
			else
			{
				$email = trim($CI->input->post('login_email'));
				$password   = md5($CI->input->post('login_password').$CI->config->item('encryption_key'));
		
				$response = $CI->lgn->getCustomerData($email,$password);
		
				if($response)
				{
					//On 01-05-2015 allowed login to guest and set thier type as G
					if($response['customer_group_type'] == 'U' || $response['customer_group_type'] == 'G')
					{
						if(($response['customer_emailid'] == $email) && ($response['customer_password'] == $password))
						{
							if($response['customer_status'] == '0')
							{
								//update customer group if G then to U
								checkAndUpdateGuestCustomerGroup( $response['customer_id'], $response['customer_group_type'] );
		
								//set all login sessions and upd cart/wish database
								$cmn_vw["lgnS"] = setLoginSessions($response['customer_id'], 'U', $response['customer_emailid']);
		
								$data["type"] = "success";
								$data['msg'] = getLangMsg("l_suc");
								//$returnArr['success'] = 'true';
							}
							else
							{
								//$CI->lgn->isCustomerDisabled($response);
								$data["type"] = "error";
								$data['msg'] = getErrorMessageFromCode('01002');
								$data['error'] = getErrorMessageFromCode('01002');
								//$returnArr['warning'] = getErrorMessageFromCode('01002');
							}
						}
						else
						{
							$data['type'] = "error";
							$data['msg'] = "Invalid email or password combination";
							$data['error'] = array('login_email'=>getErrorMessageFromCode('01013'));
							//$returnArr['error'] = array('login_not_match'=>getErrorMessageFromCode('01013'));
						}
					}
					elseif($response['customer_group_type'] == 'G')
					{
						$data["type"] = "error";
						$data['msg'] = getErrorMessageFromCode('01020');
						$data['error'] = getErrorMessageFromCode('01020');
						//$returnArr['warning'] = getErrorMessageFromCode('01020');
					}
					else
					{
						$data["type"] = "error";
						$data['msg'] = getErrorMessageFromCode('01015');
						$data['error'] = getErrorMessageFromCode('01015');
						//$returnArr['warning'] = getErrorMessageFromCode('01015');
					}
				}
				else
				{
					$data['type'] = "error";
					$data['msg'] = "Invalid email or password combination";
					$data['error'] = array('login_not_match'=>getErrorMessageFromCode('01013'));
					//$returnArr['error'] = array('login_not_match'=>getErrorMessageFromCode('01013'));
				}
			}
		
		}
		else
		{
			$tempI = $CI->session->userdata('customer_id'); 
			if( empty( $tempI ) || $CI->session->userdata('customer_group_type') == "C" )
			{
				$data['type'] = "error";
				$data['msg'] = getLangMsg("iin");
			}
			else
			{
				$data['type'] = "success";
				$data['msg'] = "Already logged in!";
				
				//set login sessions only for sake of REST lgnS response
				$cmn_vw["lgnS"] = setLoginSessions( $CI->session->userdata('customer_id'), $CI->session->userdata('customer_group_type'), $CI->session->userdata('customer_emailid'));
			}
		}
	}
	else 
	{
		
	}
	
	/**
	 *
	 */
	if( is_restClient() )
	{
		/**
		 * check if validation error then format error array for REST
		 */
		if( $data["type"] == "error" )
		{
			$data["eKA"] = array(); $data["eVA"] = array();
			
			if( isset($data["error"]) && !isEmptyArr($data["error"]) )
			{
				foreach ($data["error"] as $k=>$ar)
				{
					$data["eKA"][] = $k;
					$data["eVA"][] = $ar;
				}
				unset($data["error"]);
			}
		}
		else if( $data["type"] == "success" )
		{
			//set activity or contoller redirect on REST Apps
			if( !isset($data['redirect']) )
			{
				$cmn_vw['redirect'] = "invitefriend";
			}
		}
		
		$cmn_vw["data"] = $data;
		return $cmn_vw;
	}
}

/**
 * created Date 09-05-2015
 * New Register / signup form
 */
function cmn_vw_signup()
{
	$CI =& get_instance();
	$CI->load->model('mdl_login','lgn');
	$cmn_vw = array();

	$CI->form_validation->set_rules('customer_firstname','Name','trim|required');
	$CI->form_validation->set_rules('customer_emailid','Email Address','trim|required|valid_email|callback_checkMailDuplication');
	$CI->form_validation->set_rules('customer_phoneno','Phone','trim|required|numeric');
	$CI->form_validation->set_rules('customer_password','Password','trim|required|min_length[6]');
	//$CI->form_validation->set_rules('confirm_password','Confirm Password','trim|required|matches[customer_password]|min_length[3]');
	$CI->form_validation->set_rules('agree','Agree terms','trim|required');

	//
	$data = array();
	if($CI->form_validation->run() == FALSE)
	{
		if( is_restClient() )
		{
			$data["type"] = "error";
			$data['msg'] = getErrorMessageFromCode('01005');
			$data["error"] = $CI->form_validation->get_errors();
		}
		else
		{
			$data["error"] = $CI->form_validation->get_errors();
			echo json_encode($data);
			die;
		}
	}
	else
	{
		if( is_restClient() )
		{
			$cmn_vw["lgnS"] = $CI->lgn->saveNewAccount();
			$data["type"] = "success";
			$data['msg'] = getLangMsg("s_reg");
		}
		else
		{
			$CI->lgn->saveNewAccount();
			$data['success'] = 1;
			echo json_encode($data);
			die;
		}
	}
	
	/**
	 *
	 */
	if( is_restClient() )
	{
		/**
		 * check if validation error then format error array for REST
		 */
		if( $data["type"] == "error" )
		{
			$data["eKA"] = array(); $data["eVA"] = array();
			
			if( isset($data["error"]) && !isEmptyArr($data["error"]) )
			{	
				foreach ($data["error"] as $k=>$ar)
				{
					$data["eKA"][] = $k;
					$data["eVA"][] = $ar;
				}
				unset($data["error"]);
			}
		}
		$cmn_vw["data"] = $data;
		return $cmn_vw;
	}
}

/**
 * created Date 11-05-2015
 * forgot password form
 */
function cmn_vw_forgot()
{
	$CI =& get_instance();
	$CI->load->model('mdl_login','lgn');
	$CI->lgn->cTable = "customer";
	$CI->lgn->cAutoId = "customer_id";

	$cmn_vw = array();

	$CI->form_validation->set_rules('forgot_email','Email Address','trim|required|valid_email');

	$data = array();

	if(is_restClient())
	{
		if($CI->form_validation->run() == FALSE)
		{
			$data["type"] = "error";
			$data['msg'] = getErrorMessageFromCode('01005');
			$data["error"] = $CI->form_validation->get_errors();
		}
		else
		{
			$email 	  = trim($CI->input->post('forgot_email'));
			$response = $CI->lgn->getCustomerData($email);
				
			if($response && ($response['customer_emailid'] == $email))
			{
				$CI->load->helper('string');
					
				$user_pass = random_string('alnum', 6); //random generate string
				$data['customer_password'] = md5($user_pass.$CI->config->item('encryption_key'));

				$CI->db->where($CI->lgn->cAutoId,$response['customer_id'])->update($CI->lgn->cTable,$data);
					
				$data['first_name'] = $response['customer_firstname'];
				$data['last_name'] = $response['customer_lastname'];
				$data['email_address'] = $response['customer_emailid'];
				$data['text_password'] = $user_pass;
				$data['login_link'] = base_url('login');
				//getTemplateDetailAndSendMail('RESET_PASSWORD_EMAIL',$data);
					
				$subject = 'Reset Your Password at Gujcart';
				$mail_body = $CI->load->view('templates/forgot-password',$data,TRUE);
				$mail_body .= $CI->load->view('templates/footer-template',array('email_id'=>$data['email_address']),TRUE);

				sendMail($data['email_address'], $subject, $mail_body);
					
				$data["type"] = "success";
				$data['msg'] = getLangMsg("s_f_msg");
			}
			else
			{
				$data["type"] = "error";
				$data['msg'] = getErrorMessageFromCode('01015');
				$data["error"] = array('forgot_email'=>getErrorMessageFromCode('01015'));
			}
		}
	}

	/**
	 *
	 */
	if( is_restClient() )
	{
		/**
		 * check if validation error then format error array for REST
		 */
		if( $data["type"] == "error" )
		{
			$data["eKA"] = array(); $data["eVA"] = array();
			
			if( isset($data["error"]) && !isEmptyArr($data["error"]) )
			{
				foreach ($data["error"] as $k=>$ar)
				{
					$data["eKA"][] = $k;
					$data["eVA"][] = $ar;
				}
				unset($data["error"]);
			}
		}
			
		$cmn_vw["data"] = $data;

		return $cmn_vw;
	}
}

/**
 * 
 * @return multitype:Ambigous <multitype:, string, unknown, multitype:string , number, NULL>
 */
function cmn_vw_logout()
{
	$CI =& get_instance();
	$cmn_vw = array();
	$is_checkout = (int) $CI->input->get("is_checkout");
	
	$customer_id = (int)$CI->session->userdata('customer_id');
	if($customer_id!=0)
	{
		if( $is_checkout != 1 )
		{
			unsetLoginSessions();
			setFlashMessage('success','You are successfully logged out.');
		}
		else 
		{
			$cartArr = $CI->session->userdata('cartArr');
			$wishArr = $CI->session->userdata('wishArr');
			
			$data = logout('', false, false, $customer_id, $cartArr, $wishArr);
			setFlashMessage( $data["type"], $data["msg"] ); 
		}
		
		
		if( is_restClient() )
		{
			if( $is_checkout != 1 )
			{
				$cmn_vw["redirect"] = "home";
			}
			else 
			{
				$cmn_vw["redirect"] = "checkout";
			}
		}
		else 
		{}
	}
	else
	{
		if( is_restClient() )
		{
			if( $is_checkout != 1 )
			{
				$cmn_vw["redirect"] = "home";
			}
			else
			{
				$cmn_vw["redirect"] = "checkout";
			}
		}
		else 
		{}
	}
	
	return $cmn_vw;
}


/******************************* login signup functions end ***********************************/


/**
 * Create date : 15-05-2015
 * change password to restAPI / Desktop
 */
function cmn_vw_changePassword()
{
	$CI =& get_instance();
	$CI->load->model('mdl_account','ma');
	$CI->ma->cTable = 'customer';

	$cmn_vw = array();
	$CI->form_validation->set_rules('current_password','Current password','trim|required|callback_checkForOldPassword');
	$CI->form_validation->set_rules('new_password','New password','trim|required|min_length[6]');
	$CI->form_validation->set_rules('confirm_password','Confirm password','trim|required|matches[new_password]|min_length[6]');

	if($CI->form_validation->run() == FALSE)
	{
		if ( is_restClient() )
		{
			$data["type"] = "error";
			$data['msg'] = getErrorMessageFromCode('01005');
			$data["error"] = $CI->form_validation->get_errors();
		}
		else
		{
			if($_POST)
			{
				$data["error"] = $CI->form_validation->get_errors();
				echo json_encode($data);
				die;
			}
			$data['custom_page_title'] = 'Change Password';
			$data['pageName'] = 'account/change-password';
			$CI->load->view('site-layout',$data);
		}
	}
	else
	{
		if ( is_restClient() )
		{
			$CI->ma->saveChangedPassword();
			$data["type"] = "success";
			$data['msg'] = getLangMsg("cng_pass");
		}
		else
		{
			$CI->ma->saveChangedPassword();
			$data['success'] = "Your password has been changed successfully.";
			echo json_encode($data);
			die;
		}
	}

	/**
	 *
	 */
	if( is_restClient() )
	{
		/**
		 * check if validation error then format error array for REST
		 */
		if( $data["type"] == "error" )
		{
			$data["eKA"] = array(); $data["eVA"] = array();
			
			if( isset($data["error"]) && !isEmptyArr($data["error"]) )
			{
				foreach ($data["error"] as $k=>$ar)
				{
					$data["eKA"][] = $k;
					$data["eVA"][] = $ar;
				}
				unset($data["error"]);
			}
		}
		$cmn_vw["data"] = $data;
		return $cmn_vw;
	}
}

/**
 * Create date : 15-05-2015
 * InviteFriends to restAPI / Desktop
 */
function cmn_vw_invitefriend()
{
	$CI =& get_instance();
	$CI->load->model('mdl_home','hom');

	$cmn_vw = array();
	$CI->form_validation->set_rules('customer_partner_id','Email ID','trim|required|valid_email');
	$CI->form_validation->set_rules('customer_note','Tell Massage','trim|required');

	$data = array();
	if($CI->form_validation->run() == FALSE)
	{
		if ( is_restClient() )
		{
			$data["type"] = "error";
			$data['msg'] = getErrorMessageFromCode('01005');
			$data["error"] = $CI->form_validation->get_errors();
		}
		else
		{
			$data['type'] = "error";
			$data['msg'] = getErrorMessageFromCode('01005');
			$data["error"] = $CI->form_validation->get_errors();
			echo json_encode($data);
		}
	}
	else
	{
		if ( is_restClient() )
		{
			$CI->hom->inviteFriend();
			$data['type'] = "success";
			$data['msg'] = getLangMsg("invfr");
		}
		else
		{
			$CI->hom->inviteFriend();
			$data['type'] = "success";
			$data['msg'] = getLangMsg("invfr");
			echo json_encode($data);
		}
	}

	/**
	 *
	 */
	if( is_restClient() )
	{
		/**
		 * check if validation error then format error array for REST
		 */
		if( $data["type"] == "error" )
		{
			$data["eKA"] = array(); $data["eVA"] = array();
			
			if( isset($data["error"]) && !isEmptyArr($data["error"]) )
			{
				foreach ($data["error"] as $k=>$ar)
				{
					$data["eKA"][] = $k;
					$data["eVA"][] = $ar;
				}
				unset($data["error"]);
			}
		}
		$cmn_vw["data"] = $data;
		return $cmn_vw;
	}
}


/******************************* account panel functions ***********************************/

/**
 * Create date : 15-05-2015
 * Save New Address Book to restAPI / Desktop
 */
function cmn_vw_saveAddress( &$__this )
{
	$data = array();

	$cmn_vw = array();

	$__this->form_validation->set_rules('customer_address_firstname','First Name','trim|required');
	$__this->form_validation->set_rules('customer_address_address','Address','trim|required|min_length[10]');
	$__this->form_validation->set_rules('country_id','Country','trim|required');
	$__this->form_validation->set_rules('state_id','State','trim');
	$__this->form_validation->set_rules('address_city','City','trim|required');
	$__this->form_validation->set_rules('customer_address_landmark_area','Area','trim|required');
	$__this->form_validation->set_rules('pincode','Pincode','trim|required|numeric');
	$__this->form_validation->set_rules('customer_address_phone_no','Mobile No','trim|required');


	if ( is_restClient() )
	{
		if($__this->form_validation->run() == FALSE)
		{
			$data["type"] = "error";
			$data['msg'] = getErrorMessageFromCode('01005');
			$data["error"] = $__this->form_validation->get_errors();
		}
		else
		{
			$data = $__this->ma->saveAddress();
			if( $data["type"] == "_redirect" )
			{
				$cmn_vw = $data; 
				return $cmn_vw; 
			}
		}
	}
	else
	{
		if($__this->form_validation->run() == FALSE)
		{
			$data['error'] = $__this->form_validation->get_errors();
			if($data['error'])
				setFlashMessage('error',getErrorMessageFromCode('01005'));
			
			$data['mode'] = 'validation';
			$data['custom_page_title'] = 'Edit Address';
			$data['pageName'] = 'account/edit-address';
			$__this->load->view('site-layout',$data);
		}
		else
		{
			$res = $__this->ma->saveAddress();
			redirect('account/addressBook');
		}
	}

	if( is_restClient() )
	{
		/**
		 * check if validation error then format error array for REST
		 */
		if( $data["type"] == "error" )
		{
			$data["eKA"] = array(); $data["eVA"] = array();

			if( isset($data["error"]) && !isEmptyArr($data["error"]) )
			{
				foreach ($data["error"] as $k=>$ar)
				{
					$data["eKA"][] = $k;
					$data["eVA"][] = $ar;
				}
				unset($data["error"]);
			}
		}
		$cmn_vw["data"] = $data;
		return $cmn_vw;
	}
}


/**
 * 
 */
function sendTextMessage()
{
	if( isset( $_GET['is_mob'] ) && (int)$_GET['is_mob'] != 0 )
	{
		$url = 'http://api.msg91.com/api/sendhttp.php';
		$sms_content = "Test Message for ".date('d-m-Y h:m:s');
		
		$fields = array(
				'route' => urlencode(4),
				'country' => urlencode(91),
				'flash' => urlencode(0),
				'unicode' => urlencode(0),
				'campaign' => urlencode('viaSOCKET'),
				'authkey' => urlencode(MSG91_AUTH_KEY),
				'mobiles' => urlencode( $_GET['is_mob'] ),
				'message' => urlencode( $sms_content ),
				'sender' => urlencode('DMSURT')
		);
		
		
		$fields_string = "";
		
		//url-ify the data for the POST
		foreach($fields as $key=>$value)
		{
			$fields_string .= $key.'='.$value.'&';
		}
		
		rtrim($fields_string, '&');
		
		//open connection
		$ch = curl_init();
		
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		
		//execute post
		$result = curl_exec($ch);
		
		pr($result);
		//close connection
		curl_close($ch);
	}
	else
	{
		$messageContentArr = executeQuery( "SELECT c.customer_id, c.c_phoneno, c.sms_id, s.sms_content FROM customer c INNER JOIN sms s ON s.sms_id = c.sms_id WHERE is_send_sms = 1 AND c_status = 1 LIMIT 0, 200" );
		
		$mobiles = "";
		
		if( !isEmptyArr( $messageContentArr ) )
		{
			$mobiles = "8200017181, ";
			foreach ( $messageContentArr as $messageContent )
			{
				$mobiles .= $messageContent['c_phoneno'].", ";
				
				query( "UPDATE customer SET is_send_sms = 0 WHERE customer_id = ".$messageContent['customer_id'] );
			}
			
			$mobiles = rtrim( $mobiles, ", " );
		}
		
		if( !empty( $mobiles ) )
		{
			//extract data from the post
			//set POST variables
			$url = 'http://api.msg91.com/api/sendhttp.php';
			$fields = array(
					'route' => urlencode(4),
					'country' => urlencode(91),
					'flash' => urlencode(0),
					'unicode' => urlencode(0),
					'campaign' => urlencode('viaSOCKET'),
					'authkey' => urlencode(MSG91_AUTH_KEY),
					'mobiles' => urlencode($mobiles),
					'message' => urlencode($messageContentArr[0]['sms_content']),
					'sender' => urlencode('DMSURT')
			);
			
			
			$fields_string = "";
			
			//url-ify the data for the POST
			foreach($fields as $key=>$value)
			{
				$fields_string .= $key.'='.$value.'&';
			}
			
			rtrim($fields_string, '&');
			
			//open connection
			$ch = curl_init();
			
			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			
			// 			echo $fields_string;
			//execute post
			$result = curl_exec($ch);
			
			pr($result);
			//close connection
			curl_close($ch);
		}
	}
}

/******************************* account panel functions end ********************************/

function cmn_vw_getAllCustomer()
{
	$result = executeQuery( "SELECT CONCAT( c_slip_number, '-', c_firstname, ' ', c_lastname ) as c_name, customer_id FROM customer WHERE c_status = 1 ORDER BY c_firstname ASC" );
	return $result;
}

function cmn_vw_getAllSkim()
{
	$result = executeQuery( "SELECT s_name, skim_id FROM skim WHERE s_status = 1 ORDER BY s_name ASC" );
	return $result;
}

function cmn_vw_getAllRoles()
{
	$result = executeQuery( "SELECT r_name, r_id FROM roles WHERE status = 1 ORDER BY r_name ASC" );
	return $result;
}

function cmn_vw_buildTree(array $elements, $parentId = 0)
{
	$branch = array();
	
	foreach ($elements as $element)
	{
		if ($element['c_reference_id'] == $parentId)
		{
			$children = cmn_vw_buildTree($elements, $element['customer_id']);
			if ($children)
			{
				$element['children'] = $children;
			}
			$branch[] = $element;
		}
	}	
	return $branch;
}

function fetchChainTreeList($parent = 0, $user_tree_array = '', $isFindParent=false) 
{
	$CI =& get_instance();
	if (!is_array($user_tree_array))
		$user_tree_array = array();
		
	if( $isFindParent )
	{
		$rows= executeQuery( "SELECT customer_id, c_slip_number, c_reference_id, c_firstname, c_lastname, c_phoneno, c_emailid FROM customer WHERE customer_id = $parent ORDER BY customer_id ASC" );
	}
	else 
	{
		$rows= executeQuery( "SELECT customer_id, c_slip_number, c_reference_id, c_firstname, c_lastname, c_phoneno, c_emailid FROM customer WHERE c_reference_id = $parent ORDER BY customer_id ASC" );
	}
	
	if( isset( $rows ) && !empty( $rows) )
	{
		foreach ( $rows as $row ) 
		{
			$user_tree_array[] = $row;
			
			if( $isFindParent )
			{
				$user_tree_array = fetchChainTreeList( $row['c_reference_id'], $user_tree_array, $isFindParent );
			}
			else
			{
				$user_tree_array = fetchChainTreeList( $row['customer_id'], $user_tree_array, $isFindParent );
			}
		}
	}
	return $user_tree_array;
}

function chainLevel( $id )
{
	$res = array( -1=>20, 0=>0, 1=>10, 2=>4, 3=>3, 4=>1, 5=>0.50, 6=>0.50, 7=>0.25, 8=>0.25, 9=>0.20, 10=>0.15, 11=>0.15 );
	
	return $res[$id];
}

/**
 * autoload client dropdown by type any keyword in to inputbox
 */
function cmn_vw_getAutoCustomerName( $keyword )
{
	$CI =& get_instance();
	$CI->db->select( "customer.customer_id, CONCAT( customer.c_firstname, ' ', customer.c_middlename, ' ',customer.c_lastname, ':',customer.c_phoneno, '(', customer.c_slip_number, ')' ) as c_name" );
	$CI->db->from( "customer" );
	$CI->db->order_by( "customer.c_phoneno", "ASC" );
	$CI->db->like( "customer.c_firstname", $keyword);
	$CI->db->or_like( "customer.c_middlename", $keyword);
	$CI->db->or_like( "customer.c_lastname", $keyword);
	$CI->db->or_like( "customer.c_phoneno", $keyword);
	$CI->db->or_like( "customer.c_slip_number", $keyword);
	$res = $CI->db->get();
	return $res->result_array();
}

/**
 * autoload client dropdown by type any keyword in to inputbox
 */
function cmn_vw_getAutoCustomerPhoneno( $keyword )
{
	$CI =& get_instance();
	$CI->db->select( "customer.customer_id, customer.c_phoneno" );
	$CI->db->from( "customer" );
	$CI->db->order_by( "customer.c_phoneno", "ASC" );
	$CI->db->like( "customer.c_phoneno", $keyword);
	$res = $CI->db->get();
	return $res->result_array();
}