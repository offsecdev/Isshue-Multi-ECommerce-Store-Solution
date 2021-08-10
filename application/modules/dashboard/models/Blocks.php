<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Blocks extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	//block List
	public function block_list()
	{
		$this->db->select('block.*,product_category.category_name');
		$this->db->from('block');
		$this->db->join('product_category','block.block_cat_id = product_category.category_id');
		$this->db->order_by('block_position');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	public function block_list_for_home_page()
	{
		$this->db->select('block.*,product_category.category_name');
		$this->db->from('block');
		$this->db->join('product_category','block.block_cat_id = product_category.category_id');
		$this->db->where('block.status',1);
		$this->db->order_by('block_position');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}
		return false;
	}
	//block Search Item
	public function block_search_item($block_id)
	{
		$this->db->select('*');
		$this->db->from('block');
		$this->db->where('block_id',$block_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Count block
	public function block_entry($data)
	{
		$this->db->select('*');
		$this->db->from('block');
		$this->db->where('status',1);
		$this->db->where('block_position',$data['block_position']);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return FALSE;
		}else{
			$this->db->insert('block',$data);
			return TRUE;
		}
	}
	//Retrieve block Edit Data
	public function retrieve_block_editdata($block_id)
	{
		$this->db->select('*');
		$this->db->from('block');
		$this->db->where('block_id',$block_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	//Update Blocks
	public function update_block($data,$block_id)
	{
		$this->db->select('*');
		$this->db->from('block');
		$this->db->where('block_position',$data['block_position']);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->db->set('block_cat_id',$data['block_cat_id']);
			$this->db->set('block_css',$data['block_css']);
			$this->db->set('block_style',$data['block_style']);
			$this->db->set('block_image',$data['block_image']);
			$this->db->where('block_id',$block_id);
			$result = $this->db->update('block',$data);
			return TRUE;
		}else{
			$this->db->where('block_id',$block_id);
			$result = $this->db->update('block',$data);
			return TRUE;
		}


		exit();
	}
	// Delete block Item
	public function delete_block($block_id)
	{
		
		$this->db->where('block_id',$block_id);
		$result = $this->db->delete('block'); 	
		return $result;
	}
}