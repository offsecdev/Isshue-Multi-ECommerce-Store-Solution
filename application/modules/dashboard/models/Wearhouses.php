<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Wearhouses extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	//wearhouse List
	public function wearhouse_list()
	{
		$this->db->select('*');
		$this->db->from('wearhouse_set');
		$this->db->order_by('wearhouse_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
	}
	//wearhouse List
	public function warehouse_list_result()
	{
		$this->db->select('*');
		$this->db->from('wearhouse_set');
		$this->db->order_by('wearhouse_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}
		return false;
	}
	//Wearhouse List With Product
	public function wearhouse_list_with_product()
	{
		$this->db->select('
					a.wearhouse_name,
					b.*,
					SUM(b.quantity) as quantity,
					c.product_name,
					c.product_model,
					d.variant_name
			');
		$this->db->from('wearhouse_set a');
		$this->db->join('transfer b','a.wearhouse_id= b.warehouse_id','left');
		$this->db->join('product_information c','c.product_id = b.product_id');
		$this->db->join('variant d','d.variant_id = b.variant_id');
		$this->db->group_by('b.product_id');
		$this->db->group_by('b.variant_id');
		$this->db->group_by('a.wearhouse_id');
		$this->db->order_by('a.wearhouse_name','asc');
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}				
	
	public function wearhouse_select($wearhouse_id)
	{
		$this->db->select('*');
		$this->db->from('wearhouse_set');
		$this->db->where_not_in('wearhouse_id',$wearhouse_id);
		$this->db->order_by('wearhouse_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}
		return false;
	}	
	//wearhouse product list
	public function wearhouse_product_list()
	{
		$this->db->select('
			a.*,
			b.wearhouse_name,
			c.product_name,
			c.product_model,
			d.variant_name,
			e.tax
			');
		$this->db->from('wearhouse_product a');
		$this->db->join('wearhouse_set b','b.wearhouse_id = a.wearhouse_id','right');
		$this->db->join('product_information c','c.product_id = a.product_id');
		$this->db->join('variant d','d.variant_id = a.variant_id');
		$this->db->join('tax_information e','e.tax_id = a.tax_id');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//wearhouse Search Item
	public function wearhouse_search_item($wearhouse_id)
	{
		$this->db->select('*');
		$this->db->from('wearhouse');
		$this->db->where('wearhouse_id',$wearhouse_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Count wearhouse
	public function wearhouse_entry($data)
	{
		$this->db->select('*');
		$this->db->from('wearhouse_set');
		$this->db->where('wearhouse_name',$data['wearhouse_name']);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return FALSE;
		}else{
			$this->db->insert('wearhouse_set',$data);
			return TRUE;
		}
	}	
	//Wearhouse to warehouse transfer
	public function wearhouse_transfer($data,$data1){

		$warehouse_id = $data['warehouse_id'];
		$product_id   = $data['product_id'];
		$variant_id   = $data['variant_id'];
		$quantity 	  = $data['quantity'];

		$this->db->select('*,sum(quantity) as total_quantity');
		$this->db->from('transfer');
		$this->db->where('warehouse_id',$warehouse_id);
		$this->db->where('product_id',$product_id);
		$this->db->where('variant_id',$variant_id);
		$query = $this->db->get()->row();

		if ($query->total_quantity > 0) {
			$result = $this->db->insert('transfer',$data);
			$result = $this->db->insert('transfer',$data1);
			return TRUE;
		}else{
			return false;
		}
	}	
	//Warehouse to store transfer
	public function wearhouse_to_store_transfer($data,$data1){

		$warehouse_id = $data['warehouse_id'];
		$product_id   = $data['product_id'];
		$variant_id   = $data['variant_id'];
		$quantity 	  = $data['quantity'];

		$this->db->select('transfer.*,sum(quantity) as total_quantity');
		$this->db->from('transfer');
		$this->db->where('warehouse_id',$warehouse_id);
		$this->db->where('product_id',$product_id);
		$this->db->where('variant_id',$variant_id);
		$query = $this->db->get()->row();

		if ($query->total_quantity > 0) {
			$result = $this->db->insert('transfer',$data);
			$result = $this->db->insert('transfer',$data1);
			return TRUE;
		}else{
			return false;
		}
	}
	//wearhouse product entry
	public function wearhouse_product_entry($data)
	{
		$wearhouse_id 	= $data['wearhouse_id'];
		$product_id = $data['product_id'];
		$quantity = $data['quantity'];
		
		$this->db->select('*');
		$this->db->from('wearhouse_product');
		$this->db->where('wearhouse_id',$data['wearhouse_id']);
		$this->db->where('product_id',$data['product_id']);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$this->db->set('quantity', 'quantity+'.$quantity, FALSE);
			$this->db->where('wearhouse_id',$wearhouse_id);
			$this->db->where('product_id',$product_id);
			$this->db->update('wearhouse_product');
			return FALSE;
		}else{
			$this->db->insert('wearhouse_product',$data);
			return TRUE;
		}
	}
	//Retrieve wearhouse Edit Data
	public function retrieve_wearhouse_editdata($wearhouse_id)
	{
		$this->db->select('*');
		$this->db->from('wearhouse_set');
		$this->db->where('wearhouse_id',$wearhouse_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	
	//Retrieve wearhouse Product Edit Data
	public function retrieve_wearhouse_product_editdata($wearhouse_product_id)
	{
		$this->db->select('
			a.*,
			b.wearhouse_name,
			c.product_name,
			d.variant_name,
			e.tax
			');
		$this->db->from('wearhouse_product a');
		$this->db->join('wearhouse_set b','b.wearhouse_id = a.wearhouse_id');
		$this->db->join('product_information c','c.product_id = a.product_id');
		$this->db->join('variant d','d.variant_id = a.variant_id');
		$this->db->join('tax_information e','e.tax_id = a.tax_id');
		$this->db->where('a.wearhouse_product_id',$wearhouse_product_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//wearhouse list selected
	public function wearhouse_list_selected($wearhouse_id){
		$this->db->select('*');
		$this->db->from('wearhouse_set');
		$this->db->order_by('wearhouse_name','asc');
		$this->db->where('wearhouse_id',$wearhouse_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	
	//Product list selected
	public function product_list_selected($product_id){
		$this->db->select('*');
		$this->db->from('product_information');
		$this->db->where('product_id',$product_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	
	//Variant list selected
	public function variant_list_selected($variant_id){
		$this->db->select('*');
		$this->db->from('variant');
		$this->db->where('variant_id',$variant_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	
	//Tax list selected
	public function tax_list_selected($tax_id){
		$this->db->select('*');
		$this->db->from('tax_information');
		$this->db->where('tax_id',$tax_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Update Wearhouses
	public function update_wearhouse($data,$wearhouse_id)
	{
		$this->db->where('wearhouse_id',$wearhouse_id);
		$result = $this->db->update('wearhouse_set',$data);

		if ($result) {
			return true;
		}
		return false;
	}	
	//Update Wearhouses
	public function wearhouse_product_update($data,$wearhouse_product_id)
	{
		$this->db->where('wearhouse_product_id',$wearhouse_product_id);
		$result = $this->db->update('wearhouse_product',$data);

		if ($result) {
			return true;
		}
		return false;
	}
	// Delete wearhouse Item
	public function delete_wearhouse($warehouse_id)
	{
		$this->db->select('*');
		$this->db->from('transfer');
		$this->db->where('t_warehouse_id',$warehouse_id);
		$this->db->or_where('warehouse_id',$warehouse_id);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return false;
		}else{
			$this->db->where('wearhouse_id',$warehouse_id);
			$this->db->delete('wearhouse_set'); 	
			return true;
		}
	}	
	// Delete wearhouse product
	public function delete_wearhouse_product($wearhouse_product_id)
	{
		$this->db->where('wearhouse_product_id',$wearhouse_product_id);
		$this->db->delete('wearhouse_product'); 	
		return true;
	}
}