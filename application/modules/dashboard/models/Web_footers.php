<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Web_footers extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	//web_footer List
	public function web_footer_list()
	{
		$this->db->select('*');
		$this->db->from('web_footer');
		$this->db->order_by('position','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//web_footer Search Item
	public function web_footer_search_item($footer_section_id)
	{
		$this->db->select('*');
		$this->db->from('web_footer');
		$this->db->where('footer_section_id',$footer_section_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Count customer
	public function web_footer_entry($data)
	{
		$this->db->select('*');
		$this->db->from('web_footer');
		$this->db->where('status',1);
		$this->db->where('position',$data['position']);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return FALSE;
		}else{
			$this->db->insert('web_footer',$data);
			return TRUE;
		}
	}
	//Retrieve customer Edit Data
	public function retrieve_web_footer_editdata($footer_section_id)
	{
		$this->db->select('*');
		$this->db->from('web_footer');
		$this->db->where('footer_section_id',$footer_section_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	//Update Web_footers
	public function update_web_footer($data,$footer_section_id)
	{
		$this->db->select('*');
		$this->db->from('web_footer');
		$this->db->where('position',$data['position']);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->db->set('headlines',$data['headlines']);
			$this->db->set('details',$data['details']);
			$this->db->where('footer_section_id',$footer_section_id);
			$result = $this->db->update('web_footer');
			return true;
		}else{
			$this->db->where('footer_section_id',$footer_section_id);
			$result = $this->db->update('web_footer',$data);
			return true;
		}
	}
	// Delete web_footer Item
	public function delete_web_footer($footer_section_id)
	{
		$this->db->where('footer_section_id',$footer_section_id);
		$this->db->delete('web_footer'); 	
		return true;
	}
}