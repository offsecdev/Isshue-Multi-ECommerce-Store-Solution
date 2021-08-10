<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Currencies extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	//customer List
	public function currency_list()
	{
		$this->db->select('*');
		$this->db->from('currency_info');
		$this->db->order_by('currency_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//currency Search Item
	public function currency_search_item($currency_id)
	{
		$this->db->select('*');
		$this->db->from('currency');
		$this->db->where('currency_id',$currency_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Currency entry
	public function currency_entry($data)
	{
		//Code for default status entry
		if ($data['default_status'] == 1 ) {
			$this->db->select('*');
			$this->db->from('currency_info');
			$this->db->where('default_status',1);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return FALSE;
			}else{
				$this->db->insert('currency_info',$data);
				return TRUE;
			}
		}else{
			$this->db->insert('currency_info',$data);
			return TRUE;
		}
	}
	//Retrieve currency Edit Data
	public function retrieve_currency_editdata($currency_id)
	{
		$this->db->select('*');
		$this->db->from('currency_info');
		$this->db->where('currency_id',$currency_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	//Update currency
	public function update_currency($data,$currency_id)
	{
		if ($data['default_status'] == 1 ) {
			$this->db->select('*');
			$this->db->from('currency_info');
			$this->db->where('default_status',1);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {

				$this->db->select('*');
				$this->db->from('currency_info');
				$this->db->where('default_status','1');
				$this->db->where('currency_id',$currency_id);
				$query = $this->db->get();

				if ($query->num_rows() > 0) {
					$this->db->where('currency_id',$currency_id);
					$result = $this->db->update('currency_info',$data);
					return TRUE;
				}else{
					return FALSE;
				}
			}else{
				$this->db->where('currency_id',$currency_id);
				$result = $this->db->update('currency_info',$data);
				return TRUE;
			}
		}else{
			$this->db->where('currency_id',$currency_id);
			$result = $this->db->update('currency_info',$data);
			return TRUE;
		}
	}

	// Delete currency item
	public function delete_currency($currency_id)
	{

		$result = $this->db->select('*')
							->from('currency_info')
							->where('currency_id',$currency_id)
							->get()
							->row();

		if ($result->default_status == 1) {
			return false;
		}else{
			$this->db->where('currency_id',$currency_id);
			$this->db->delete('currency_info'); 	
			return true;
		}
	}
}