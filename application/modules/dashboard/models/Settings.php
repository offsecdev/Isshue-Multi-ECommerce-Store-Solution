<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Settings extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	//Bank list
	public function get_bank_list()
	{
		$this->db->select('*');
		$this->db->from('bank_add');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Get bank by id
	public function get_bank_by_id($bank_id)
	{
		$this->db->select('*');
		$this->db->from('bank_add');
		$this->db->where('bank_id',$bank_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Bank update by id
	public function bank_update_by_id($bank_id)
	{
		$data = array(
			'bank_name'	=>	$this->input->post('bank_name',TRUE),
			'ac_name'	=>	$this->input->post('ac_name',TRUE),
			'branch'	=>	$this->input->post('branch',TRUE),
			'ac_number' =>	$this->input->post('ac_number',TRUE),
		);
		$this->db->where('bank_id',$bank_id);
		$this->db->update('bank_add',$data); 
		return true;
	}
	//Bank entry
	public function bank_entry( $data )
	{
		$this->db->insert('bank_add',$data);
	}
}