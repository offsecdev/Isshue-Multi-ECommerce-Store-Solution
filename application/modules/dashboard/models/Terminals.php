<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Terminals extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	//customer List
	public function terminal_list()
	{
		$this->db->select('*');
		$this->db->from('terminal_payment');
		$this->db->order_by('terminal_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//terminal Search Item
	public function terminal_search_item($terminal_id)
	{
		$this->db->select('*');
		$this->db->from('terminal_payment');
		$this->db->where('terminal_id',$terminal_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Count customer
	public function terminal_entry($data)
	{
		$this->db->select('*');
		$this->db->from('terminal_payment');
		$this->db->where('terminal_name',$data['terminal_name']);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return FALSE;
		}else{
			$this->db->insert('terminal_payment',$data);
			return TRUE;
		}
	}
	//Retrieve customer Edit Data
	public function retrieve_terminal_editdata($terminal_id)
	{
		$this->db->select('*');
		$this->db->from('terminal_payment');
		$this->db->where('pay_terminal_id',$terminal_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	//Update Terminals
	public function update_terminal($data,$terminal_id)
	{
		$this->db->where('pay_terminal_id',$terminal_id);
		$result = $this->db->update('terminal_payment',$data);

		if ($result) {
			return true;
		}
		return false;
	}
	// Delete terminal Item
	public function delete_terminal($terminal_id)
	{
		$this->db->where('pay_terminal_id',$terminal_id);
		$this->db->delete('terminal_payment'); 	
		return true;
	}
}