<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller {
 	
 	public function __construct()
 	{
 		parent::__construct();
 		$this->load->model(array(
 			'dashboard/role_model'
 		));
 		
		$this->auth->check_user_auth();
 	}

 	// Add Role
	public function index()
	{
		$this->role_add();
	}

 	public function role_add(){

 		$this->permission->check_label('role')->create()->redirect();

		/*-----------------------------------*/ 
		$this->form_validation->set_rules('role_name', display('role_name'),'required|max_length[100]|is_unique[sec_role_tbl.role_name]');
		$this->form_validation->set_rules('role_description', display('role_description'),'required|max_length[200]');


		if ($this->form_validation->run()==TRUE) {

			$rolData = array(
				'role_name' 		=> $this->input->post('role_name'),
				'role_description' 	=> $this->input->post('role_description'),
				'create_by' 		=> $this->session->userdata('user_id'),
				'date_time' 		=> date('Y-m-d h:i:s')
			);

			$this->db->insert('sec_role_tbl', $rolData);
			$role_id = $this->db->insert_id();

			/*-----------------------------------*/ 
			$module  	   = $this->input->post('module'); 
			$menu_id  	   = $this->input->post('menu_id'); 
			$create  	   = $this->input->post('create');
			$read  		   = $this->input->post('read');
			$update  	   = $this->input->post('edit');
			$delete  	   = $this->input->post('delete');
	 
	 		$new_array = array();
	 		for($m=0; $m < sizeof($module); $m++) {

				for($i=0; $i < sizeof($menu_id[$m]); $i++) {

					for($j=0; $j < sizeof($menu_id[$m][$i]); $j++ ) { 
						
						$dataStore = array(
							'role_id'   	=> $role_id,
							'menu_id'   	=> $menu_id[$m][$i][$j], 
							'can_create'   	=> (!empty($create[$m][$i][$j])?$create[$m][$i][$j]:0), 
							'can_edit'     	=> (!empty($update[$m][$i][$j])?$update[$m][$i][$j]:0), 
							'can_access'  	=> (!empty($read[$m][$i][$j])?$read[$m][$i][$j]:0), 
							'can_delete'   	=> (!empty($delete[$m][$i][$j])?$delete[$m][$i][$j]:0),
							'createby'		=> $this->session->userdata('user_id'),
							'createdate'	=> date('Y-m-d h:i:s'),
						); 

						array_push($new_array, $dataStore);

					}
				}
			}

			if ($this->role_model->create($new_array)) {
				$this->session->set_userdata('message', display('successfully_added'));
			} else {
				$this->session->set_userdata('error_message', display('please_try_again'));
			}

		} 
		$data['title']   = display('add_role');
		$data['modules'] = $this->role_model->get_role_module_list();

		$content = $this->parser->parse('dashboard/role/role_add',$data,true);
		$this->template_lib->full_admin_html_view($content);	
		
 	}

	public function role_list(){
		$this->permission->check_label('role')->read()->redirect();

		$data['title']      = display('manage_roles');
		$data['module'] 	= "dashboard";  
		$data['role_list']  = $this->db->select('*')->from('sec_role_tbl')->get()->result();
		$content = $this->parser->parse('dashboard/role/role_list',$data,true);
		$this->template_lib->full_admin_html_view($content);	 	
	}


	public function role_edit($id=null)
	{
		$this->permission->check_label('role')->update()->redirect();

		$this->form_validation->set_rules('role_name', display('role_name'),'required|max_length[100]');
		$this->form_validation->set_rules('role_description', display('role_description'),'required|max_length[200]');
		$role_id = $this->input->post('role_id');

		if ($this->form_validation->run()==TRUE) {

			$rolData = array(
				'role_name' 		=> $this->input->post('role_name', TRUE),
				'role_description' 	=> $this->input->post('role_description', TRUE)
			);
			$this->db->where('role_id',$role_id)->update('sec_role_tbl',$rolData);


			/*-----------------------------------*/ 
			$module  	   = $this->input->post('module', TRUE); 
			$menu_id  	   = $this->input->post('menu_id', TRUE); 
			$create  	   = $this->input->post('create', TRUE);
			$read  		   = $this->input->post('read', TRUE);
			$update  	   = $this->input->post('edit', TRUE);
			$delete  	   = $this->input->post('delete', TRUE);
	 
	 		$new_array = array();
	 		for($m=0; $m < sizeof($module); $m++) {

				for($i=0; $i < sizeof($menu_id[$m]); $i++) {

					for($j=0; $j < sizeof($menu_id[$m][$i]); $j++ ) { 
						$dataStore = array(
							'role_id'   => $role_id,
							'menu_id'   => $menu_id[$m][$i][$j], 
							'can_create'   => (!empty($create[$m][$i][$j])?$create[$m][$i][$j]:0), 
							'can_edit'     => (!empty($update[$m][$i][$j])?$update[$m][$i][$j]:0), 
							'can_access'   => (!empty($read[$m][$i][$j])?$read[$m][$i][$j]:0), 
							'can_delete'   => (!empty($delete[$m][$i][$j])?$delete[$m][$i][$j]:0),
							'createby'		=> $this->session->userdata('id'),
							'createdate'	=> date('Y-m-d h:i:s'),
						); 

						array_push($new_array, $dataStore);

					}
				}
			}
			// Delete and Insert role data
			if ($this->role_model->create($new_array)) {
				$this->session->set_flashdata('message', display('successfully_updated'));
			} else {
				$this->session->set_flashdata('exception', display('please_try_again'));
			}

			redirect("dashboard/role/role_list");

		}

		$modules = $this->role_model->get_role_module_list();

		$roleData = $this->db->select('*')
		->from('sec_role_tbl')
		->where('role_id',$id)
		->get()->row();

		$roleAcc = $this->db->select('sec_role_permission.*,sec_menu_item.menu_title')
		->from('sec_role_permission')
		->join('sec_menu_item','sec_menu_item.menu_id=sec_role_permission.menu_id')
		->where('role_id',$id)
		->get()->result();

		$data = array(
			'title'  => display('role_edit'),
			'modules'=> $modules,
			'roleAcc'=> $roleAcc,
			'role_id'=> $roleData->role_id,
			'role_name'=> $roleData->role_name,
			'role_description'=> $roleData->role_description,
		);
  
		$content = $this->parser->parse('dashboard/role/role_edit',$data,true);
		$this->template_lib->full_admin_html_view($content);

	}

  	public function delete_role($id=null)
	{
		$this->permission->check_label('role')->delete()->redirect();

		$delete = $this->db->where('role_id',$id)->delete('sec_role_tbl');
		$delete = $this->db->where('role_id',$id)->delete('sec_role_permission');

		if ($delete) {
			$this->session->set_userdata('message', display('delete_successfully'));
		} else {
			$this->session->set_userdata('error_message', display('please_try_again'));
		}
		redirect("dashboard/role/role_list");
	}

	public function user_access_role(){

		$this->permission->check_label('role')->create()->redirect();

		$data['title']      	= display('manage_user_roles');
		$data['module']     	= "dashboard";  
		$data['page']       	= "role/user_access_role"; 

		$data['user_access_role'] = $this->db->select('
			sec_user_access_tbl.*,
			sec_role_tbl.*,
			users.first_name,
			users.last_name
			')
		->from('sec_user_access_tbl')
		->join('users','users.user_id=sec_user_access_tbl.fk_user_id')
		->join('sec_role_tbl','sec_role_tbl.role_id=sec_user_access_tbl.fk_role_id')
		->order_by('sec_user_access_tbl.fk_user_id')
		->get()->result();

		$content = $this->parser->parse('dashboard/role/user_access_role',$data,true);
		$this->template_lib->full_admin_html_view($content);
	}

	// Role Assign
	public function role_add_to_user(){

		$this->permission->check_label('role')->create()->redirect();

		$this->form_validation->set_rules('user_id', display('user'),'trim|required');
		$this->form_validation->set_rules('role[]', display('role'),'trim|required');

		if ($this->form_validation->run()==TRUE) {

			$new_array = array();
			$role_id = $this->input->post('role', TRUE);
			$user_id = $this->input->post('user_id', TRUE);

			for($j=0; $j < sizeof($role_id); $j++ ) { 
				$rolData = array(
					'fk_role_id' 	=> $role_id[$j],
					'fk_user_id' 	=> $user_id
				);
				array_push($new_array, $rolData);
			}

			$this->db->where('fk_user_id', $user_id)->delete('sec_user_access_tbl');
			if (!empty($new_array)) {
				$this->db->insert_batch('sec_user_access_tbl', $new_array);
				$this->session->set_userdata('message', display('save_successfully'));
			}else{
				$this->session->set_userdata('error_message', display('failed_try_again'));
			}

		}

		$data['title']  = display('role_add_to_user');
		$data['module'] = "dashboard";  
		$data['role'] 	= $this->db->select('role_name,role_id')->from('sec_role_tbl')->get()->result();

		$data['user'] 	= $this->db->select('
									a.user_id,
									a.first_name,
									a.last_name
								')
								->from('users a')
								->join('user_login b','a.user_id = b.user_id','left')
								->where('b.user_type>',1)
								->get()
								->result();
								
		$content = $this->parser->parse('dashboard/role/user_role_add',$data,true);
		$this->template_lib->full_admin_html_view($content);
	}

  	public function role_edit_to_user($id=null)
	{

		$this->permission->check_label('role')->update()->redirect();

		$this->form_validation->set_rules('user_id', display('user'),'trim|required');
		$this->form_validation->set_rules('role[]', display('role'),'trim|required');

		if ($this->form_validation->run()==TRUE) {

			$new_array = array();
			$role_id = $this->input->post('role', TRUE);
			$user_id = $this->input->post('user_id', TRUE);

			for($j=0; $j < sizeof($role_id); $j++ ) { 
				$rolData = array(
					'fk_role_id' 	=> $role_id[$j],
					'fk_user_id' 	=> $user_id
				);
				array_push($new_array, $rolData);
			}

			$result = $this->db->where('fk_user_id',$user_id)->delete('sec_user_access_tbl');
			if (!empty($new_array)) {
				$this->db->insert_batch('sec_user_access_tbl', $new_array);
				$this->session->set_userdata('message', display('successfully_updated'));
			}else{
				$this->session->set_userdata('error_message', display('not_updated'));
			}
			redirect("dashboard/role/user_access_role");

		}


		$data['title']  = display('edit');

		$role	= $this->db->select('role_name,role_id')->from('sec_role_tbl')->get()->result();
		$user	= $this->db->select('a.user_id,a.first_name,a.last_name')
								->from('users a')
								->join('user_login b','a.user_id = b.user_id','left')
								->where('b.user_type >',1)
								->get()
								->result();

		$info = $this->db->select('*')->from('sec_user_access_tbl')->where('role_acc_id',$id)->get()->row();

		$data = array(
			'role' => $role, 
			'user' => $user, 
			'role_acc_id'=> $info->role_acc_id, 
			'fk_role_id' => $info->fk_role_id, 
			'fk_user_id' => $info->fk_user_id, 
			'role_assign_id' => $id 
		);

		$content = $this->parser->parse('dashboard/role/user_role_edit',$data,true);
		$this->template_lib->full_admin_html_view($content);
	}

	public function delete_access_role($id)
	{
		$this->permission->check_label('role')->delete()->redirect();

		$this->db->where('role_acc_id',$id)->delete('sec_user_access_tbl');
		$this->session->set_userdata('message', display('delete_successfully'));
		redirect("dashboard/role/user_access_role");
	}
}
