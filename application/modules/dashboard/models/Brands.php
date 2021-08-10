<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Brands extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	//customer List
	public function brand_list()
	{
		$this->db->select('*');
		$this->db->from('brand');
		$this->db->order_by('brand_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//brand Search Item
	public function brand_search_item($brand_id)
	{
		$this->db->select('*');
		$this->db->from('brand');
		$this->db->where('brand_id',$brand_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Count customer
	public function brand_entry($data)
	{
		$this->db->select('*');
		$this->db->from('brand');
		$this->db->where('status',1);
		$this->db->where('brand_name',$data['brand_name']);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return FALSE;
		}else{
			$this->db->insert('brand',$data);
			return TRUE;
		}
	}
	//Retrieve customer Edit Data
	public function retrieve_brand_editdata($brand_id)
	{
		$this->db->select('*');
		$this->db->from('brand');
		$this->db->where('brand_id',$brand_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	//Update Brands
	public function update_brand($data,$brand_id)
	{
		$this->db->where('brand_id',$brand_id);
		$result = $this->db->update('brand',$data);

		if ($result) {
			return true;
		}
		return false;
	}
	// Delete Brand Item
	public function delete_brand($brand_id)
	{
		$this->db->where('brand_id',$brand_id);
		$this->db->delete('brand'); 	
		return true;
	}
}