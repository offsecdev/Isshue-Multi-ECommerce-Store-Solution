<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Units extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	//unit List
	public function unit_list()
	{
		$this->db->select('*');
		$this->db->from('unit');
		$this->db->order_by('unit_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//unit Search Item
	public function unit_search_item($unit_id)
	{
		$this->db->select('*');
		$this->db->from('unit');
		$this->db->where('unit_id',$unit_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Insert unit
	public function unit_entry($data)
	{
		$this->db->select('*');
		$this->db->from('unit');
		$this->db->where('unit_name',$data['unit_name']);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return FALSE;
		}else{
			$this->db->insert('unit',$data);
			return TRUE;
		}
	}
	//Retrieve unit Edit Data
	public function retrieve_unit_editdata($unit_id)
	{
		$this->db->select('*');
		$this->db->from('unit');
		$this->db->where('unit_id',$unit_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	//Update Units
	public function update_unit($data,$unit_id)
	{
		$this->db->where('unit_id',$unit_id);
		$result = $this->db->update('unit',$data);

		if ($result) {
			return true;
		}
		return false;
	}
	// Delete unit Item
	public function delete_unit($unit_id)
	{
		$this->db->where('unit_id',$unit_id);
		$this->db->delete('unit'); 	
		return true;
	}
}