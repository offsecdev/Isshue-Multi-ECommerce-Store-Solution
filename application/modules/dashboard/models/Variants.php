<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Variants extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	//customer List
	public function variant_list()
	{
		$this->db->select('*');
		$this->db->from('variant');
		$this->db->order_by('variant_name','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

    public function category_wise_variant_list($cat_id)
    {
        $this->db->select('cv.variant_id,v.*');
        $this->db->from('category_variant cv');
        $this->db->where('cv.category_id =',$cat_id);
        $this->db->join('variant v','cv.variant_id = v.variant_id','left');
        $this->db->order_by('v.variant_name','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
             return $query->result_array();
        }
        return false;
    }
	//variant Search Item
	public function variant_search_item($variant_id)
	{
		$this->db->select('*');
		$this->db->from('variant');
		$this->db->where('variant_id',$variant_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Count customer
	public function variant_entry($data)
	{
		$this->db->select('*');
		$this->db->from('variant');
		$this->db->where('status',1);
		$this->db->where('variant_name',$data['variant_name']);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return FALSE;
		}else{
			$this->db->insert('variant',$data);
			return TRUE;
		}
	}
	//Retrieve customer Edit Data
	public function retrieve_variant_editdata($variant_id)
	{
		$this->db->select('*');
		$this->db->from('variant');
		$this->db->where('variant_id',$variant_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	//Update variants
	public function update_variant($data,$variant_id)
	{
		$this->db->where('variant_id',$variant_id);
		$result = $this->db->update('variant',$data);

		if ($result) {
			return true;
		}
		return false;
	}
	// Delete variant Item
	public function delete_variant($variant_id)
	{
		$this->db->where('variant_id',$variant_id);
		$this->db->delete('variant'); 	
		return true;
	}
}