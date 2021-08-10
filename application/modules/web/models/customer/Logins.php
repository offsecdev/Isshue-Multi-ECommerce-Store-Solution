<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Logins extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	//Patent Category List
	public function parent_category_list()
	{
		$this->db->select('*');
		$this->db->from('product_category');
		$this->db->where('cat_type',1);
		$this->db->where('status',1);
		$this->db->order_by('menu_pos');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}
		return false;
	}		

	//Category list
	public function category_list()
	{
		$this->db->select('*');
		$this->db->from('product_category');
		$this->db->order_by('category_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	

	//Best sales list
	public function best_sales()
	{
		$this->db->select('*');
		$this->db->from('product_information');
		$this->db->where('best_sale','1');
		$this->db->limit('6');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}
		return false;
	}		

	//Footer block
	public function footer_block()
	{
		$this->db->select('*');
		$this->db->from('web_footer');
		$this->db->order_by('position');
		$this->db->limit('4');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}
		return false;
	}	
}