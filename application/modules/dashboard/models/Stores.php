<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Stores extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	//Store List
	public function store_list()
	{
		$this->db->select('*');
		$this->db->from('store_set');
		$this->db->order_by('store_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}		
	//Store Select List
	public function store_select($store_id)
	{
		$this->db->select('*');
		$this->db->from('store_set');
		$this->db->where_not_in('store_id',$store_id);
		$this->db->order_by('store_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}
		return false;
	}	
	//Store List Result
	public function store_list_result()
	{
		$this->db->select('*');
		$this->db->from('store_set');
		$this->db->order_by('store_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}
		return false;
	}	
	
	//Store to store transfer
	public function store_transfer($data,$data1){


		$store_id 	  = $data['store_id'];
		$product_id   = $data['product_id'];
		$variant_id   = $data['variant_id'];
		$quantity 	  = $data['quantity'];

		$this->db->select('transfer.*,sum(quantity) as total_quantity');
		$this->db->from('transfer');
		$this->db->where('store_id',$store_id);
		$this->db->where('product_id',$product_id);
		$this->db->where('variant_id',$variant_id);
		if(!empty($data['variant_color'])){
			$this->db->where('variant_color',$data['variant_color']);
		}
		$query = $this->db->get()->row();

		if ($query->total_quantity > 0) {
			$result = $this->db->insert('transfer',$data);
			$result = $this->db->insert('transfer',$data1);
			return TRUE;
		}else{
			return false;
		}
	}	
	//Store to Wearhouse transfer
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

	//Store product list
	public function store_product_list()
	{
		$this->db->select('
				a.store_name,
				b.*,
				SUM(b.quantity) as quantity,
				c.product_name,
				c.product_model,
				d.variant_name,
				e.variant_name as variant_color_name
			');
		$this->db->from('store_set a');
		$this->db->join('transfer b','a.store_id= b.store_id','left');
		$this->db->join('product_information c','c.product_id = b.product_id');
		$this->db->join('variant d','d.variant_id = b.variant_id');
		$this->db->join('variant e','e.variant_id = b.variant_color','left');
		$this->db->group_by('b.product_id');
		$this->db->group_by('b.variant_id');
		$this->db->group_by('a.store_id');
		$this->db->order_by('a.store_name','asc');
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//store Search Item
	public function store_search_item($store_id)
	{
		$this->db->select('*');
		$this->db->from('store');
		$this->db->where('store_id',$store_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Count Store
	public function store_entry($data)
	{
		if ($data['default_status']==1) {
			$this->db->select('*');
			$this->db->from('store_set');
			$this->db->where('default_status',1);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				$this->session->set_userdata(array('error_message'=>display('default_store_already_exists')));
				return FALSE;
			}else{
				$this->db->insert('store_set',$data);
				return TRUE;
			}
		}else{
			$this->db->select('*');
			$this->db->from('store_set');
			$this->db->where('store_name',$data['store_name']);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				$this->session->set_userdata(array('error_message'=>display('store_name_already_exists')));
				return FALSE;
			}else{
				$this->db->insert('store_set',$data);
				return TRUE;
			}
		}
	}	

	//Update Stores
	public function update_store($data,$store_id)
	{

		if ($data['default_status']==1) {
			$this->db->select('*');
			$this->db->from('store_set');
			$this->db->where('default_status',1);
			$this->db->where('store_id !=',$store_id);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				$this->session->set_userdata(array('error_message'=>display('default_store_already_exists')));
				return FALSE;
			}else{
				$this->db->where('store_id',$store_id);
				$result = $this->db->update('store_set',$data);
				return TRUE;
			}
		}else{
			$this->db->select('*');
			$this->db->from('store_set');
			$this->db->where('store_name',$data['store_name']);
			$this->db->where('store_id !=',$store_id);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				$this->session->set_userdata(array('error_message'=>display('store_name_already_exists')));
				return FALSE;
			}else{
				$this->db->where('store_id',$store_id);
				$result = $this->db->update('store_set',$data);
				return TRUE;
			}
		}
	}	

	//Store product entry
	public function store_product_entry($data)
	{
		$store_id 	= $data['store_id'];
		$product_id = $data['product_id'];
		$quantity = $data['quantity'];
		
		$this->db->select('*');
		$this->db->from('store_product');
		$this->db->where('store_id',$data['store_id']);
		$this->db->where('product_id',$data['product_id']);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$this->db->set('quantity', 'quantity+'.$quantity, FALSE);
			$this->db->where('store_id',$store_id);
			$this->db->where('product_id',$product_id);
			$this->db->update('store_product');
			return FALSE;
		}else{
			$this->db->insert('store_product',$data);
			return TRUE;
		}
	}
	//Retrieve Store Edit Data
	public function retrieve_store_editdata($store_id)
	{
		$this->db->select('*');
		$this->db->from('store_set');
		$this->db->where('store_id',$store_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	
	//Retrieve Store Product Edit Data
	public function retrieve_store_product_editdata($store_product_id)
	{
		$this->db->select('
			a.*,
			b.store_name,
			c.product_name,
			d.variant_name
			');
		$this->db->from('store_product a');
		$this->db->join('store_set b','b.store_id = a.store_id');
		$this->db->join('product_information c','c.product_id = a.product_id');
		$this->db->join('variant d','d.variant_id = a.variant_id');
		$this->db->where('a.store_product_id',$store_product_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Store list selected
	public function store_list_selected($store_id){
		$this->db->select('*');
		$this->db->from('store_set');
		$this->db->order_by('store_name','asc');
		$this->db->where('store_id',$store_id);
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
	//Update Stores
	public function store_product_update($data,$store_product_id)
	{
		$this->db->where('store_product_id',$store_product_id);
		$result = $this->db->update('store_product',$data);

		if ($result) {
			return true;
		}
		return false;
	}
	// Delete store Item
	public function delete_store($store_id)
	{

		$this->db->select('*');
		$this->db->from('transfer');
		$this->db->where('t_store_id',$store_id);
		$this->db->or_where('store_id',$store_id);
		$query = $this->db->get();

        $default =  $this->db->select('*')->from('store_set')->where('store_id',$store_id)->get()->row();

        if ($query->num_rows() > 0) {
			return false;
		}elseif($default->default_status == 1){
            return 'default';
        } else{
			$this->db->where('store_id',$store_id);
			$this->db->delete('store_set'); 	
			return true;
		}
	}	
	// Delete store product
	public function delete_store_product($store_product_id)
	{
		$this->db->where('store_product_id',$store_product_id);
		$this->db->delete('store_product'); 	
		return true;
	}

	 // Get default store info
    public function get_def_store()
    {
        $this->db->select('*');
        $this->db->from('store_set');
        $this->db->where('default_status',1);
        $result = $this->db->get()->row_array();
        return $result;
    }
}