<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Model_login extends CI_Model {
	
/*
++++++++++++++++++++++++++++++++++++++++++++++++++++
	Function validate the user credential. and if exist 
	then return whole array.
++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
	public function validateLogin()
	{
		$username = $this->input->post('admin_user_emailid');
		$password = (md5($this->input->post('admin_user_password').$this->config->item('encryption_key')));

		$user = $this->db->where( 'admin_user_emailid', $username )
						->where( 'admin_user_password', $password )
						->where( 'admin_user_status', 1 )
						->get( 'admin_user' )
						->row_array();
// 		echo $this->db->last_query();pr($user);die;
		return $user;
	}
/*
++++++++++++++++++++++++++++++++++++++++++++++++++++
	Function Will save admin username and password.
++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
	public function saveSettings()
	{
		if($this->input->post('new_password') != '') // if password inserted by admin 
			$data['admin_user_password'] = md5($this->input->post('new_password').$this->config->item('encryption_key'));		
	
		//updating information to database
		$this->db->where('admin_user_id',$this->session->userdata('admin_id'))->update('admin_user',$data);
	}
	
	/*
	 ++++++++++++++++++++++++++++++++++++++++++++++++++++
	 Function validate the user credential. and if exist
	 then return whole array.
	 ++++++++++++++++++++++++++++++++++++++++++++++++++++
	 */
	public function validateEmail()
	{
		$username = $this->input->post('forgot_email');
		$user = $this->db->where('admin_user_emailid',$username)->get('admin_user')->row_array();
		//echo $this->db->last_query();pr($user);die;
		return $user;
	}

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */