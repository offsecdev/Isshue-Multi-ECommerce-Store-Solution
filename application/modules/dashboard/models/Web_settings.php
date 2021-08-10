<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Web_settings extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	//Retrieve Data
	public function retrieve_setting_editdata()
	{
		$this->db->select('*');
		$this->db->from('web_setting');
		$this->db->where('setting_id',1);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Submit contact form
	public function submit_contact_form($data)
	{
		$this->db->insert('contact',$data);
		return true;
	}

	//Submit contact form
	public function manage_contact_form()
	{
		$this->db->select('*');
		$this->db->from('contact');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Contact update form
	public function contact_update_form($id)
	{
		$this->db->select('*');
		$this->db->from('contact');
		$this->db->where('id',$id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Update contact form
	public function update_contact_form($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('contact',$data);
		return true;
	}		

	//Delete contact form
	public function delete_contact($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('contact');
		return true;
	}

	//Setting
	public function setting()
	{
		$this->db->select('*');
		$this->db->from('web_setting');
		$this->db->where('setting_id',1);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	

	//Map Info
	public function map_info()
	{
		$this->db->select('*');
		$this->db->from('web_setting');
		$this->db->where('setting_id',1);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	

	//Update web setting form
	public function update_web_settings($id,$data)
	{
		$this->db->where('setting_id',$id);
		$result = $this->db->update('web_setting',$data);
		return $result;
	}	

	//Slider entry
	public function slider_entry($data)
	{
		$result = $this->db->insert('slider',$data);
		return $result;
	}

	//Slider list
	public function slider_list()
	{
		$this->db->select('*');
		$this->db->from('slider');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	public function home_slider_list()
	{
		$this->db->select('*');
		$this->db->from('slider');
		$this->db->where('status',1);
		$this->db->order_by('slider_position','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

//Slider list
	public function active_slider_list()
	{
		$this->db->select('*');
		$this->db->from('slider');
		$this->db->where('status','1');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Slider edit data
	public function slider_edit_data($id)
	{
		$this->db->select('*');
		$this->db->from('slider');
		$this->db->where('slider_id',$id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Update Slider
	public function update_slider($data,$slider_id)
	{
		$this->db->select('*');
		$this->db->from('slider');
		$this->db->where('slider_position',$data['slider_position']);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->db->set('slider_image',$data['slider_image']);
			$this->db->set('slider_link',$data['slider_link']);
			$this->db->set('slider_category',$data['slider_category']);
			$this->db->where('slider_id',$slider_id);
			$result = $this->db->update('slider');
		}else{
			$this->db->where('slider_id',$slider_id);
			$result = $this->db->update('slider',$data);
		}
		return $result;
	}

	//Insert add
	public function insert_add($data)
	{
		$this->db->select('*');
		$this->db->from('advertisement');
		$this->db->where('add_page',$data['add_page']);
		$this->db->where('adv_position',$data['adv_position']);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return FALSE;
		}else{
			$this->db->insert('advertisement',$data);
			return TRUE;
		}
	}

	//Add list
	public function add_list()
	{
		$this->db->select('*');
		$this->db->from('advertisement');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Slider edit data
	public function add_edit_data($id)
	{
		$this->db->select('*');
		$this->db->from('advertisement');
		$this->db->where('adv_id',$id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Update Add
	public function update_add($data,$id)
	{

		$this->db->select('*');
		$this->db->from('advertisement');
		$this->db->where('add_page',$data['add_page']);
		$this->db->where('adv_position',$data['adv_position']);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->db->set('adv_code',$data['adv_code']);
			$this->db->set('adv_type',$data['adv_type']);
			$this->db->where('adv_id',$id);
			$result = $this->db->update('advertisement');
		}else{
			$this->db->where('adv_id',$id);
			$result = $this->db->update('advertisement',$data);
		}
		return $result;
	}

	//Product Category
	public function get_all_category()
	{
		$this->db->where('status',1);
		$result = $this->db->get('product_category')->result_array();
		return $result;
	}

	// Get popular products analytics
	public function get_popular_products()
	{	
		$this->db->select('a.*,b.product_name, c.category_name');
		$this->db->from('site_analytics a');
		$this->db->join('product_information b', 'a.product_id=b.product_id','left');
		$this->db->join('product_category c', 'b.category_id=c.category_id','left');
		$this->db->order_by('a.clicks','desc');
		$this->db->group_by('a.product_id');
		$result = $this->db->get('site_analytics')->result_array();
		return $result;
	}
}