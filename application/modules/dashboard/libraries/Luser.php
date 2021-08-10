<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Luser {
	//Update user profile
	public function edit_profile_form()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Users');
		$edit_data = $CI->Users->profile_edit_data();	
		$data = array(
				'title' 	 => display('update_profile'),
				'first_name' => $edit_data[0]['first_name'],
				'last_name'  => $edit_data[0]['last_name'],
				'user_name'  => $edit_data[0]['username'],
				'logo' 		 => $edit_data[0]['logo']
			);	
		$profile_data = $CI->parser->parse('dashboard/user/edit_profile',$data,true);
		return $profile_data;
	}
}
?>