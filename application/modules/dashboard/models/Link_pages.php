<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Link_pages extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	//link_page List
	public function link_page_list()
	{
		$this->db->select('*');
		$this->db->from('link_page');
		$this->db->order_by('link_page_id','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//link_page Search Item
	public function link_page_search_item($link_page_id)
	{
		$this->db->select('*');
		$this->db->from('link_page');
		$this->db->where('link_page_id',$link_page_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Count customer
	public function link_page_entry($data)
	{
		$this->db->insert('link_page',$data);
		return TRUE;
	}
	//Retrieve customer Edit Data
	public function retrieve_link_page_editdata($page_id)
	{
		$this->db->select('*');
		$this->db->from('link_page');
		$this->db->where('page_id',$page_id);
		$this->db->order_by('language_id');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	//Update Link_pages
	public function update_link_page($data,$link_page_id)
	{
		$this->db->where('link_page_id',$link_page_id);
		$result = $this->db->update('link_page',$data);
		if ($result) {
			return true;
		}
		return false;
	}
	// Delete link_page Item
	public function delete_link_page($link_page_id)
	{
		$this->db->where('link_page_id',$link_page_id);
		$result = $this->db->delete('link_page'); 	
		return $result;
	}
}