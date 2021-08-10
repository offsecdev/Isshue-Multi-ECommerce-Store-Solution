<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Our_location extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	//Our Location List
	public function our_location_list()
	{
		$this->db->select('*');
		$this->db->from('our_location');
		$this->db->order_by('location_id','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Our Location Search Item
	public function our_location_search_item($our_location_id)
	{
		$this->db->select('*');
		$this->db->from('our_location');
		$this->db->where('our_location_id',$our_location_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Our Location entry
	public function our_location_entry($data)
	{
		$this->db->insert('our_location',$data);
		return TRUE;
	}

	//Retrieve Our Location Edit Data
	public function retrieve_our_location_editdata($position)
	{
		$this->db->select('*');
		$this->db->from('our_location');
		$this->db->where('position',$position);
		$this->db->order_by('language_id');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	//Update Our Location
	public function update_our_location($data,$position,$language_id)
	{
		$this->db->set('headline',$data['headline']);
		$this->db->set('details',$data['details']);
		$this->db->where('language_id',$language_id);
		$this->db->where('position',$position);
		$result = $this->db->update('our_location');

		if (array_key_exists("position",$data)) {
			$this->db->set('position',$data['position']);
			$this->db->where('position',$position);
			$result = $this->db->update('our_location');
		}

		if ($result) {
			return true;
		}
		return false;
	}	

	// Delete Our Location Item
	public function delete_our_location($position)
	{
		$this->db->where('position',$position);
		$this->db->delete('our_location'); 	
		return true;
	}
}