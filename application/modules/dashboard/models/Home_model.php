<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {


	public function checkUser($data = array())
	{
		return $this->db->select("
				user.id, 
				CONCAT_WS(' ', user.firstname, user.lastname) AS fullname,
				user.email, 
				user.image, 
				user.last_login,
				user.last_logout, 
				user.ip_address, 
				user.status, 
				user.is_admin, 
				IF (user.is_admin=1, 'Admin', 'User') as user_level
			")
			->from('user')
			->where('email', $data['email'])
			->where('password', md5($data['password']))
			->get();
	}

	public function userPermission($id = null)
	{
		return $this->db->select("
			module.controller, 
			module_permission.fk_module_id, 
			module_permission.create, 
			module_permission.read, 
			module_permission.update, 
			module_permission.delete
			")
			->from('module_permission')
			->join('module', 'module.id = module_permission.fk_module_id', 'full')
			->where('module_permission.fk_user_id', $id)
			->get()
			->result();
	}


	public function last_login($id = null)
	{
		return $this->db->set('last_login', date('Y-m-d H:i:s'))
			->set('ip_address', $this->input->ip_address())
			->where('id',$this->session->userdata('id'))
			->update('user');
	}

	public function last_logout($id = null)
	{
		return $this->db->set('last_logout', date('Y-m-d H:i:s'))
			->where('id', $this->session->userdata('id'))
			->update('user');
	}

	public function profile($id = null)
	{
		return $this->db->select("
			*, 
				CONCAT_WS(' ', firstname, lastname) AS fullname,
				IF (user.is_admin=1, 'Admin', 'User') as user_level
			")
			->from("user")
			->where("id", $id)
			->get()
			->row();
	}

	public function setting($data = array())
	{
		return $this->db->where('id', $data['id'])
			->update('user', $data);
	}

}
 