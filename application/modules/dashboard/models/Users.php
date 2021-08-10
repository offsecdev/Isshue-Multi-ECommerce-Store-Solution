<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	//Check valid user
	function check_valid_user($username,$password)
	{

		$fullpassword = md5("gef".$password);
        $this->db->where(array('username'=>$username,'password'=>$fullpassword,'status'=>1));
		$query = $this->db->get('user_login');
		$result =  $query->result_array();

		if (count($result) == 1)
		{
			$user_id = $result[0]['user_id'];
			
			$this->db->select('a.*,b.*');
			$this->db->from('user_login a');
			$this->db->join('users b','b.user_id = a.user_id');
			$this->db->where('a.user_id',$user_id);
			$query = $this->db->get();
			return $query->result_array();
		}
		return false;
	}

	// Get User Permission
	public function getUserPermission($id = null)
	{
		$acc_tbl = $this->db->select('*')->from('sec_user_access_tbl')->where('fk_user_id',$id)->get()->result();

		if($acc_tbl!=NULL){
			$role_id = [];
			foreach ($acc_tbl as $key => $value) {
				$role_id[] = $value->fk_role_id;
			}

			return	$result = $this->db->select("
					sec_role_permission.role_id, 
					sec_role_permission.menu_id, 
					IF(SUM(sec_role_permission.can_create)>=1,1,0) AS 'create', 
					IF(SUM(sec_role_permission.can_access)>=1,1,0) AS 'read', 
					IF(SUM(sec_role_permission.can_edit)>=1,1,0) AS 'update', 
					IF(SUM(sec_role_permission.can_delete)>=1,1,0) AS 'delete',
					sec_menu_item.menu_title,
					sec_menu_item.page_url,
					sec_menu_item.module
					")
					->from('sec_role_permission')
					->join('sec_menu_item', 'sec_menu_item.menu_id = sec_role_permission.menu_id', 'full')
					->where_in('sec_role_permission.role_id', $role_id)
					->group_by('sec_role_permission.menu_id')
					->group_start()
						->where('can_create', 1)
						->or_where('can_access', 1)
						->or_where('can_edit', 1)
						->or_where('can_delete', 1)
					->group_end()
					->get()
					->result();
			}
		else {
			return 0;
		}
	}


	/*
	**User registration
	*/
	public function user_registration()
	{
		$birth_day 	 = $this->input->post('birth_day',TRUE);
		$birth_month = $this->input->post('birth_month',TRUE);
		$birth_year  = $this->input->post('birth_year',TRUE);
		$dbo         = $birth_year.'-'.$birth_month.'-'.$birth_day;
	
		$data1=array(
			'user_id'			=>	null,
			'first_name'		=>	$this->input->post('first_name',TRUE),
			'last_name'			=>	$this->input->post('last_name',TRUE),
			'gender'			=>	$this->input->post('user_sex',TRUE),
			'date_of_birth'		=>	$dbo ,
			'status'			=>	1
			);
		$this->db->insert('users',$data1);
        $insert_id = $this->db->insert_id();
		//Inset user Login table 
		
		$password = $this->input->post('password',TRUE);
		$password = md5("ctgs".$password);
		
		$data = array(
			'user_id'			=>	1,//$insert_id ,
			'username'			=>	$this->input->post('username',TRUE),
			'password'		    =>	$password,
			'user_type'			=>	2,
			'security_code'		=>  '',
			'status'			=>	0
			);
		$this->db->insert('user_login',$data);
	}
	public function profile_edit_data()
	{
		$user_id = $this->session->userdata('user_id');
		$this->db->select('a.*,b.username');
		$this->db->from('users a');
		$this->db->join('user_login b','b.user_id = a.user_id');
		$this->db->where('a.user_id',$user_id);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Update Profile
	public function profile_update()
	{
		$this->load->library('upload');
        $old_logo = $this->input->post('old_logo',TRUE);

	    if (($_FILES['logo']['name'])) {
            $files = $_FILES;
            $config=array();
            $config['upload_path'] ='assets/dist/img/profile_picture/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
            $config['max_size']      = '1024';
            $config['max_width']     = '*';
            $config['max_height']    = '*';
            $config['overwrite']     = FALSE;
            $config['encrypt_name']     = true; 

            $this->upload->initialize($config);
            if (!$this->upload->do_upload('logo')) {
                $sdata['error_message'] = $this->upload->display_errors();
                $this->session->set_userdata($sdata);
                redirect('Admin_dashboard/edit_profile');
            } else {
                $view =$this->upload->data();
                $logo=$config['upload_path'].$view['file_name'];
                 $this->session->set_userdata('logo',$logo);
                @unlink($old_logo);
            }
        }



		$user_id = $this->session->userdata('user_id');
		$first_name = $this->input->post('first_name',TRUE);
		$last_name = $this->input->post('last_name',TRUE);
		$user_name = $this->input->post('user_name',TRUE);
		$new_logo = (!empty($logo)?$logo:$old_logo);

		return $this->db->query("UPDATE `users` AS `a`,`user_login` AS `b` SET `a`.`first_name` = ".$this->db->escape($first_name).", `a`.`last_name` = ".$this->db->escape($last_name).", `b`.`username` = ".$this->db->escape($user_name).",`a`.`logo` = ".$this->db->escape($new_logo)." WHERE `a`.`user_id` = ".$this->db->escape($user_id)." AND `a`.`user_id` = `b`.`user_id`");
	}
	//Change Password
	public function change_password($email,$old_password,$new_password)
	{
		$user_name = md5("gef".$new_password);
		$password = md5("gef".$old_password);
        $this->db->where(array('username'=>$email,'password'=>$password,'status'=>1));
		$query = $this->db->get('user_login');
		$result =  $query->result_array();
		
		if (count($result) == 1)
		{	
			$this->db->set('password',$user_name);
			$this->db->where('password',$password);
			$this->db->where('username',$email);
			$this->db->update('user_login');

			return true;
		}
		return false;
	}

}