<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_reviews extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	
	//product_review List
	public function product_review_list()
	{
		$this->db->select('a.*,b.product_name,b.product_model,c.first_name,c.last_name');
		$this->db->from('product_review a');
		$this->db->join('product_information b','b.product_id = a.product_id');
		$this->db->join('customer_information c','c.customer_id = a.reviewer_id');
		$this->db->group_by('a.product_review_id');
		$this->db->order_by('b.product_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	

	//dashboard product reviews 
	public function d_product_reviews()
	{
		$this->db->select('a.*,b.product_name,b.product_model,c.first_name,c.last_name,c.customer_name');
		$this->db->from('product_review a');
		$this->db->join('product_information b','b.product_id = a.product_id');
		$this->db->join('customer_information c','c.customer_id = a.reviewer_id');
		$this->db->group_by('a.product_review_id');
		$this->db->order_by('a.date_time','desc');
		$this->db->limit(5);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//product_review Search Item
	public function product_review_search_item($product_review_id)
	{
		$this->db->select('*');
		$this->db->from('product_review');
		$this->db->where('product_review_id',$product_review_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Count product_review
	public function product_review_entry($data)
	{
		$result = $this->db->insert('product_review',$data);
	
		if ($result) {
			return TRUE;
		}else{
			return FALSE;
		}
	}
	//Retrieve product_review Edit Data
	public function retrieve_product_review_editdata($product_review_id)
	{
		$this->db->select('*');
		$this->db->from('product_review');
		$this->db->where('product_review_id',$product_review_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	//Update Product Reviews
	public function update_product_review($data,$product_review_id)
	{

		$this->db->where('product_review_id',$product_review_id);
		$result = $this->db->update('product_review',$data);
		return TRUE;
	}
	// Delete product_review Item
	public function delete_product_review($product_review_id)
	{
		$this->db->where('product_review_id',$product_review_id);
		$this->db->delete('product_review'); 	
		return true;
	}
}