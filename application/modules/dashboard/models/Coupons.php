<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Coupons extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	//coupon List
	public function coupon_list()
	{
		$this->db->select('*');
		$this->db->from('coupon');
		$this->db->order_by('coupon_id','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//coupon Search Item
	public function coupon_search_item($coupon_id)
	{
		$this->db->select('*');
		$this->db->from('coupon');
		$this->db->where('coupon_id',$coupon_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Count customer
	public function coupon_entry($data)
	{
		$this->db->insert('coupon',$data);
		return TRUE;
	}
	//Retrieve customer Edit Data
	public function retrieve_coupon_editdata($coupon_id)
	{
		$this->db->select('*');
		$this->db->from('coupon');
		$this->db->where('coupon_id',$coupon_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	//Update Coupons
	public function update_coupon($data,$coupon_id)
	{
		$this->db->where('coupon_id',$coupon_id);
		$result = $this->db->update('coupon',$data);
		if ($result) {
			return true;
		}
		return false;
	}
	// Delete coupon Item
	public function delete_coupon($coupon_id)
	{
		$this->db->where('coupon_id',$coupon_id);
		$this->db->delete('coupon'); 	
		return true;
	}
}