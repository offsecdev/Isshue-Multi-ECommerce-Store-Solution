<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Wishlists extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	//Wishlist List
	public function wishlist_list()
	{
		$this->db->select('a.*,b.product_name,b.product_model,c.first_name,c.last_name');
		$this->db->from('wishlist a');
		$this->db->join('product_information b','b.product_id = a.product_id');
		$this->db->join('users c','c.user_id = a.user_id');
		$this->db->order_by('wishlist_id','desc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//wishlist Search Item
	public function wishlist_search_item($wishlist_id)
	{
		$this->db->select('*');
		$this->db->from('wishlist');
		$this->db->where('wishlist_id',$wishlist_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Count customer
	public function wishlist_entry($data)
	{
		$this->db->select('*');
		$this->db->from('wishlist');
		$this->db->where('status',1);
		$this->db->where('product_id',$data['product_id']);
		$this->db->where('user_id',$data['user_id']);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return FALSE;
		}else{
			$this->db->insert('wishlist',$data);
			return TRUE;
		}
	}
	//Retrieve customer Edit Data
	public function retrieve_wishlist_editdata($wishlist_id)
	{
		$this->db->select('*');
		$this->db->from('wishlist');
		$this->db->where('wishlist_id',$wishlist_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	//Update Wishlists
	public function update_wishlist($data,$wishlist_id)
	{
		$this->db->set('product_id',$data['product_id']);
		$this->db->where('wishlist_id',$wishlist_id);
		$result = $this->db->update('wishlist',$data);

		if ($result) {
			return true;
		}
		return false;
	}
	// Delete wishlist Item
	public function delete_wishlist($wishlist_id)
	{
		$this->db->where('wishlist_id',$wishlist_id);
		$this->db->delete('wishlist'); 	
		return true;
	}
}