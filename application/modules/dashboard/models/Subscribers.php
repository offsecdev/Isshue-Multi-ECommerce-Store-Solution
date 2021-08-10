<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Subscribers extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	//customer List
	public function subscriber_list()
	{
		$this->db->select('*');
		$this->db->from('subscriber');
		$this->db->order_by('subscriber_id','desc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//subscriber Search Item
	public function subscriber_search_item($subscriber_id)
	{
		$this->db->select('*');
		$this->db->from('subscriber');
		$this->db->where('subscriber_id',$subscriber_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}


	//Count customer
	public function subscriber_entry($data)
	{
		$this->db->select('*');
		$this->db->from('subscriber');
		$this->db->where('email',$data['email']);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return FALSE;
		}else{
			$this->db->insert('subscriber',$data);
			return TRUE;
		}
	}


	//Retrieve customer Edit Data
	public function retrieve_subscriber_editdata($subscriber_id)
	{
		$this->db->select('*');
		$this->db->from('subscriber');
		$this->db->where('subscriber_id',$subscriber_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	//Update Subscribers
	public function update_subscriber($data,$subscriber_id)
	{
		$this->db->set('email',$data['email']);
		$this->db->where('subscriber_id',$subscriber_id);
		$result = $this->db->update('subscriber',$data);

		if ($result) {
			return true;
		}
		return false;
	}


	// Delete subscriber Item
	public function delete_subscriber($subscriber_id)
	{
		$this->db->where('subscriber_id',$subscriber_id);
		$this->db->delete('subscriber'); 	
		return true;
	}

	
}