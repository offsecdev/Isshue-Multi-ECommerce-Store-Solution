<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Shipping_methods extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	//Count shipping_method
	public function shipping_method_entry($data)
	{
		$this->db->select('*');
		$this->db->from('shipping_method');
		$this->db->where('position',$data['position']);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return FALSE;
		}else{
			$this->db->insert('shipping_method',$data);
			return TRUE;
		}
	}

	//shipping_method List
	public function shipping_method_list()
	{
		$this->db->select('*');
		$this->db->from('shipping_method');
		$this->db->order_by('position');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//shipping_method Search Item
	public function shipping_method_search_item($shipping_method_id)
	{
		$this->db->select('*');
		$this->db->from('shipping_method');
		$this->db->where('method_id',$shipping_method_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Retrieve shipping_method Edit Data
	public function retrieve_shipping_method_editdata($method_id)
	{
		$this->db->select('*');
		$this->db->from('shipping_method');
		$this->db->where('method_id',$method_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	//Update Shipping_methods
	public function update_shipping_method($data,$method_id)
	{

		$this->db->select('*');
		$this->db->from('shipping_method');
		$this->db->where('position',$data['position']);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->db->set('method_name',$data['method_name']);
			$this->db->set('details',$data['details']);
			$this->db->set('charge_amount',$data['charge_amount']);
			$this->db->where('method_id',$method_id);
			$result = $this->db->update('shipping_method');
		}else{
			$this->db->where('method_id',$method_id);
			$result = $this->db->update('shipping_method',$data);
		}
		return $result;
	}
	// Delete shipping_method Item
	public function delete_shipping_method($method_id)
	{
		$this->db->where('method_id',$method_id);
		$result = $this->db->delete('shipping_method'); 	
		return $result;
	}
}