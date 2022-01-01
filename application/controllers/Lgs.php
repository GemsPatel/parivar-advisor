<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lgs extends CI_Controller 
{
	var $is_ajax = false;
	var $cAutoId = '';
	var $cPrimaryId = '';
	var $cTableName= '';
	
	function lgs()
	{
		parent::__construct();
		
		$this->load->model('Model_login','mdLogin');
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
	
	public function accountSettings()
	{
		if($this->input->post('old_pass') != '' || $this->input->post('new_pass') != '' || $this->input->post('confirm_pass') != '')
		{
			$this->form_validation->set_rules('old_pass','Old password','trim|required|callback_checkAdminPassword');		
			$this->form_validation->set_rules('new_pass','New Password','trim|required|min_length[6]');
			$this->form_validation->set_rules('confirm_pass','Confirm Password','trim|required|matches[new_pass]|min_length[6]');
		}
		
		if($this->form_validation->run() == FALSE && count($_POST))
		{
			$data = $this->form_validation->get_errors();
			echo json_encode($data);
			die;
		}
		else if(count($_POST))
		{
			$this->mdLogin->saveSettings();
			$data['success'] = 1;
			echo json_encode($data);
			die;
		}
			
		$dt = $this->db->where('admin_user_id',$this->session->userdata('admin_id'))->get('admin_user')->row_array();
		$this->load->view('admin/facebox/accountSettings',$dt);
	}
	
	public function changePassword()
	{
		
		$this->form_validation->set_rules('old_password','Old password','trim|required|callback_checkAdminPassword');
		$this->form_validation->set_rules('new_password','New Password','trim|required|min_length[6]');
		$this->form_validation->set_rules('confirm_password','Confirm Password','trim|required|matches[new_password]|min_length[6]');
		
		if($this->form_validation->run() == FALSE )
		{
			$data['error']= $this->form_validation->get_errors();
		}
		else if(count($_POST))
		{
			$this->mdLogin->saveSettings();
		}
		
		$data['pageName'] = 'changePassword';
		$this->load->view('site-layout',$data);
	}
/*
+------------------------------------------------------+
	Callback function for validation in admin form while
	admin trying to changes the current password.
+------------------------------------------------------+
*/
	public function checkAdminPassword($str)
	{
		$pass = md5($str.$this->config->item('encryption_key'));
		
		$result = $this->db->where('admin_user_id',$this->session->userdata('admin_id'))->where('admin_user_password',$pass)->get('admin_user')->row_array();
		
		if(empty($result))
		{
			$this->form_validation->set_message('checkAdminPassword', "Enter Currect Old Password." );
			return FALSE;
		}
		else
			return true;
	}
	
	public function index($alias = '')
	{
		$data = array();
		
		if($this->session->userdata('admin_id'))
			redirect('dashboard');
		
		$this->form_validation->set_rules('admin_user_emailid','Email Address','trim|required|valid_email');
		$this->form_validation->set_rules('admin_user_password','Password','trim|required');
		if($this->form_validation->run() == FALSE)
		{	
			if($_POST)
			{
				$data['error'] = $this->form_validation->get_errors();
// 				setFlashMessage('error',validation_errors());
			}

			$this->load->view('login',$data);
		}
		else if($this->form_validation->run() == TRUE)
		{
				
			$admin = $this->mdLogin->validateLogin();
			
			//if invalid Login
			if( !count( $admin ) )
			{
				$data['invalid'] = "Sorry! Enter information was wrong.... OR Contact administrator!!!";
// 				setFlashMessage('error',$error);
				$this->load->view('login',$data);
			}
			else
			{
				//check domain expires
// 				$today = strtotime( date( 'Y-m-d' ) );
// 				$finish = strtotime( getField( "admin_lock_date", "admin_user", "admin_user_emailid", $admin['admin_user_emailid'] ) );
// 				$diff = $finish - $today;//difference
				
				$daysleft = 1;//floor( $diff / ( 60*60*24 ) );
				if( $daysleft> 0 )
				{
					//setting session of admin.
					$session = array( 'admin_id'=>$admin['admin_user_id'], 'admin_user'=>$admin['admin_user_emailid'], 'role_id'=>$admin['r_id'], 'admin_customer_id'=>$admin['customer_id'], 'is_login'=>$admin['is_login'] );
					setLoginSessionsAdmin($session);
					
					//setting remember me credential if selected remember me checkbox
					if($this->input->post('remember_me') == '1')
						$this->_setLoginCookie();
					
					redirect('dashboard');
				}
				else
				{
					$data['invalid'] = "Sorry! Your domain is expired.<br> Please contact administrator!!!";
					$this->load->view('login',$data);
				}
			}
		}
	}
		
	function logout()
	{
		$arr = array('admin_id'=>'','admin_user'=>'');
		unsetLoginSessionsAdmin($arr);		
		
		//unsetting cookies.
		delete_cookie('hsquare_admin');
		
		redirect('http://parivaradviser.online');
	}
	
	private function _setLoginCookie()
	{
		$this->encrypt->set_cipher(MCRYPT_GOST);
		
		$ck = array(
			'name'   => 'admin',
			'value'  => $this->encrypt->encode($this->input->post('admin_user_emailid')),
			'expire' => 86500,
			'path'   => '/',
			'prefix' => 'hsquare_',
			'secure' => FALSE
		);
		
		$this->input->set_cookie($ck);
	}
	
/**
 * @author Cloud Webs
 * @abstract function will show various nitifications to admin users
 *	
 */
	function updateNotifications()
	{
		echo json_encode($this->mdLogin->updateNotifications());
	}

/**
 * @author Cloud Webs
 * @abstract function will show various notifications list to admin users
 *	
 */
	function listNotifications()
	{
		$type = $this->input->post('type');
		$last_id = $this->input->post('last_id');
		$data['notif_data'] = $this->mdLogin->listNotifications($type,$last_id);
		$data['type'] = $type;	
		echo $this->load->view('admin/elements/header-notifications',$data);
		
	}
/*
+-----------------------------------------+
	Function will save data and send email, 
	all parameters will be in post method.
+-----------------------------------------+
*/	
	function forgotPassword()
	{
		$logType = 'V';
		// 		saveAdminLog($this->router->class, 'Forgot Password', '', '0', 0, $logType);
		$data = array();
		
		if($this->session->userdata('admin_id'))
			adminRedirect('dashboard');
			
		$this->form_validation->set_rules('forgot_email','Email Address','trim|required|valid_email');
		if($this->form_validation->run() == FALSE)
		{
			if($_POST)
				$data['error'] = $this->form_validation->get_errors();
				
				$this->load->view('forgot_password',$data);
		}
		else if($this->form_validation->run() == TRUE)
		{
			$admin = $this->mdLogin->validateEmail();
			
			//if invalid Login
			if(!count($admin))
			{
				$error = getErrorMessageFromCode('01004');
				setFlashMessage('error',$error);
				$this->load->view( 'forgot_password',$data);
			}
			else
			{
				$this->load->helper( 'string' );
				$user_pass = random_string( 'alnum', 6 ); //random generate string
				$data['admin_user_password'] = md5( $user_pass.$this->config->item( 'encryption_key' ));
				
				$this->db->where('admin_user_id',$admin['admin_user_id'])->update( "admin_user", $data );
				
				$subject = 'Reset Your Password at Admin Panel';
				$mail_body = "<p><b>Email:</b> '".$admin['admin_user_emailid']."' </p>
						  <p><b>Password:</b> '".$user_pass."' </p>
						  <p><b><a href='".base_url('lgs')."'>Click here to Login</a> </b></p>";
				
				sendMail( $admin['admin_user_emailid'], $subject, $mail_body );
				
				$data['success'] = getErrorMessageFromCode('01014');;
				// 				setFlashMessage('success',$success);
				$this->load->view('forgot_password',$data);
			}
		}
	}

	function cronSendTextMessage()
	{
		sendTextMessage();
	}
	
	function updateProfile()
	{
		$this->load->model('Mdl_users','cust');
		
		$this->cust->cAutoId = 'admin_user_id';
		$this->cust->cTableName= 'admin_user';
		
		if($this->input->get('item_id') != '' || $this->input->post('item_id') != '')
		{
			$this->cust->cPrimaryId  = _de($this->security->xss_clean($_REQUEST['item_id']));
		}
		
		$data = array();
		
		$this->form_validation->set_rules('admin_user_firstname','First Name','trim|required');
		$this->form_validation->set_rules('admin_user_lastname','Last Name','trim|required');
		$this->form_validation->set_rules('admin_user_phone_no','Phone Number','trim|required');
		
		if( !empty( $_POST['admin_user_password'] ) )
		{
			$this->form_validation->set_rules('admin_user_password','Password','trim|required|min_length[5]');
		}
		
		if( $this->input->get('profile') == 'true' )
		{
			$dt =  array();
			if($this->cust->cPrimaryId != '') // if primary id then we have to fetch those primary Id data
			{
				$dtArr = $this->cust->getData();
				$dt = $dtArr->row_array();
			}
			
			$dt['pageName'] = 'update_profile';
			$this->load->view('site-layout',$dt);
		}
		else
		{
			if($this->form_validation->run() == FALSE )
			{
				$data['error'] = $this->form_validation->get_errors();
				setFlashMessage('error',getErrorMessageFromCode('01005'));
				
				$data['pageName'] = 'update_profile';
				$this->load->view('site-layout',$data);
			}
			else // saving data to database
			{
				$this->cust->saveData();
				
				redirect( 'updateProfile?profile=true&item_id='.$this->cust->cPrimaryId);
			}
		}
	}
}