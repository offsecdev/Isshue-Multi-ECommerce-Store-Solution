<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class About_us extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	//About Us List
	public function about_us_list()
	{
		$this->db->select('*');
		$this->db->from('about_us');
		$this->db->order_by('content_id','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//about_us Search Item
	public function about_us_search_item($about_us_id)
	{
		$this->db->select('*');
		$this->db->from('about_us');
		$this->db->where('about_us_id',$about_us_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//About us entry
	public function about_us_entry($data)
	{
		$this->db->insert('about_us',$data);
		return TRUE;
	}

	//Retrieve About Us Edit Data
	public function retrieve_about_us_editdata($position)
	{
		$this->db->select('*');
		$this->db->from('about_us');
		$this->db->where('position',$position);
		$this->db->order_by('language_id');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	//Update About_us
	public function update_about_us($data,$position,$language_id)
	{
		$this->db->set('headline',$data['headline']);
		$this->db->set('icon',$data['icon']);
		$this->db->set('details',$data['details']);
		$this->db->where('language_id',$language_id);
		$this->db->where('position',$position);
		$result = $this->db->update('about_us');


		if (array_key_exists('position', $data)) {
			$this->db->set('position',$data['position']);
			$this->db->where('position',$position);
			$result = $this->db->update('about_us');
		}

		if ($result) {
			return true;
		}
		return false;
	}	

	// Delete about_us Item
	public function delete_about_us($position)
	{
		$this->db->where('position',$position);
		$this->db->delete('about_us'); 	
		return true;
	}
}