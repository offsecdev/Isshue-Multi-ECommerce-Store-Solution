<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Userm extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	#============Count Company=============#
	public function count_user()
	{
		return $this->db->count_all("users");
	}
	#=============User List=============#
	public function user_list()
	{
		$this->db->select('users.*,user_login.*,store_set.store_name');
		$this->db->from('user_login');
		$this->db->join('users', 'users.user_id = user_login.user_id');
		$this->db->join('store_set', 'store_set.store_id = user_login.store_id','left');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	#==============User search list==============#
	public function user_search_item($user_id)
	{
		$this->db->select('users.*,user_login.user_type');
		$this->db->from('user_login');
		$this->db->join('users', 'users.user_id = user_login.user_id'); 
		$this->db->where('users.user_id',$user_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	#============Insert user to database========#
	public function user_entry($data)
	{
		$user_id = generator(15);

		$users= array(
				'user_id'	 => $user_id,
				'first_name' => $data['first_name'], 
				'last_name' => $data['last_name'],
				'logo' 		=> $data['logo'],
				'status' 	=> $data['status'],
			);
		$this->db->insert('users',$users);

		$user_login = array(
				'user_id'	=> $user_id,
				'username' 	=> $data['email'], 
				'store_id' 	=> $data['store_id'], 
				'password' 	=> $data['password'], 
				'user_type' => $data['user_type'], 
				'status' 	=> $data['status'], 
			);

		$this->db->select('*');
		$this->db->from('user_login');
		$this->db->where('username',$user_login['username']);
		$this->db->where('status',1);
		$query = $this->db->get();
		$result = $query->num_rows();

		if ($result > 0 ) {
			return false;
		}else{
			$this->db->insert('user_login',$user_login);
			$this->db->select('*');
			$this->db->from('users');
			$this->db->where('status',1);

			$query = $this->db->get();
			foreach ($query->result() as $row) {
				$json_product[] = array('label'=>$row->first_name,'value'=>$row->user_id);
			}
			$cache_file = './my-assets/js/admin_js/json/user.json';
			$productList = json_encode($json_product);
			file_put_contents($cache_file,$productList);
			return true;
		}
	}
	#==============User edit data===============#
	public function retrieve_user_editdata($user_id)
	{

		$this->db->select('users.*,user_login.*');
		$this->db->from('user_login');
		$this->db->join('users', 'users.user_id = user_login.user_id'); 
		$this->db->where('users.user_id',$user_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	#==============Update company==================#
	public function update_user($user_id)
	{

		$data=array(
			'first_name'  	=> $this->input->post('first_name',TRUE),
			'last_name' 	=> $this->input->post('last_name',TRUE),
			'status' 	    => $this->input->post('status',TRUE)
			);

		$this->db->where('user_id',$user_id);
		$this->db->update('users',$data);

		$old_password = $this->input->post('old_password',TRUE);
		$new_password = $this->input->post('password',TRUE);

		$user_login = array(
			'username' 	=> $this->input->post('username',TRUE),
			'store_id' 	=> $this->input->post('store_id',TRUE),
			'password' 	=> 	(!empty($new_password)?md5("gef".$new_password):$old_password),
			'status' 	=> $this->input->post('status',TRUE),
			'user_type' => $this->input->post('user_type',TRUE)
		);

		$this->db->where('user_id',$user_id);
		$this->db->update('user_login',$user_login);

		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('status',1);
		$query = $this->db->get();
		foreach ($query->result() as $row) {
			$json_product[] = array('label'=>$row->first_name,'value'=>$row->user_id);
		}
		$cache_file = './my-assets/js/admin_js/json/user.json';
		$productList = json_encode($json_product);
		file_put_contents($cache_file,$productList);
		return true;
	}
	#===========Delete user item========#
	public function delete_user($user_id)
	{
		$this->db->where('user_id',$user_id);
		$this->db->delete('users'); 

		$this->db->where('user_id',$user_id);
		$this->db->delete('user_login');

		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('status',1);
		$query = $this->db->get();
		foreach ($query->result() as $row) {
			$json_product[] = array('label'=>$row->first_name,'value'=>$row->user_id);
		}
		$cache_file = './my-assets/js/admin_js/json/user.json';
		$productList = json_encode($json_product);
		file_put_contents($cache_file,$productList);
		return true;
	}
}