<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Deposits extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	//Count deposit
	public function count_deposit()
	{
		return $this->db->count_all("head_office_deposit");
	}
	//deposit List
	public function deposit_list($limit,$page)
	{
		$this->db->select('*');
		$this->db->from('head_office_deposit');
		$this->db->limit($limit, $page);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Count deposit
	public function deposit_entry($data)
	{
		$this->db->insert('head_office_deposit',$data);
	
	}
	//Retrieve deposit Edit Data
	public function retrieve_deposit_editdata($deposit_id)
	{
		$this->db->select('*');
		$this->db->from('head_office_deposit');
		$this->db->where('deposit_id',$deposit_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Update Categories
	public function update_deposit($data,$deposit_id)
	{
		$this->db->where('deposit_id',$deposit_id);
		$this->db->update('head_office_deposit',$data);
	}

}