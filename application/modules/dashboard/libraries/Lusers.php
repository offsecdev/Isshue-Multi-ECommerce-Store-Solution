<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lusers {

	#==============user list================#
	public function user_list()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Userm');
		$CI->load->model('dashboard/Stores');
		$user_list = $CI->Userm->user_list();
		$i=0;
		if(!empty($user_list)){	
			foreach($user_list as $k=>$v){$i++;
			   $user_list[$k]['sl']=$i;
			}
		}

		$data = array(
				'title' => display('manage_users'),
				'user_list' => $user_list,
			);
		$userList = $CI->parser->parse('dashboard/users/user',$data,true);
		return $userList;
	}
	#=============User Search item===============#
	public function user_search_item($user_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Userm');
		$user_list = $CI->Userm->user_search_item($user_id);
		$i=0;
		foreach($user_list as $k=>$v){$i++;
           $user_list[$k]['sl']=$i;
		}
		$data = array(
				'title' => 'User Search Items',
				'user_list' => $user_list
			);
		$userList = $CI->parser->parse('dashboard/users/user',$data,true);
		return $userList;
	}
	#==============User add form===========#
	public function user_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Userm');
		$CI->load->model('dashboard/Stores');
		$store_list = $CI->Stores->store_list();
		$data = array(
				'title' => display('add_user'),
				'store_list' => $store_list,
			);
		$userForm = $CI->parser->parse('dashboard/users/add_user_form',$data,true);
		return $userForm;
	}
	#================Insert user==========#
	public function insert_user($data)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Userm');
        $result = $CI->Userm->user_entry($data);
        if ($result) {
        	return true;
        }else{
        	return false;
        }
	}
	#===============User edit form==============#
	public function user_edit_data($user_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Userm');
		$CI->load->model('dashboard/Stores');
		$user_detail = $CI->Userm->retrieve_user_editdata($user_id);
		$store_list  = $CI->Stores->store_list();
		$data=array(
			'title' 		=> display('manage_users'),
			'user_id' 		=> $user_detail[0]['user_id'],
			'store_id' 		=> $user_detail[0]['store_id'],
			'first_name' 	=> $user_detail[0]['first_name'],
			'last_name' 	=> $user_detail[0]['last_name'],
			'username' 		=> $user_detail[0]['username'],
			'user_type' 	=> $user_detail[0]['user_type'],
			'password' 		=> $user_detail[0]['password'],
			'status' 		=> $user_detail[0]['status'],
			'store_list' 	=> $store_list,
			);
	
		$companyList = $CI->parser->parse('dashboard/users/edit_users_form',$data,true);
		return $companyList;
	}
}
?>