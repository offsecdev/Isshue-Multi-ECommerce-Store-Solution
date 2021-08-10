<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Galleries extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	//image List
	public function image_list()
	{
		$this->db->select('*');
		$this->db->from('image_gallery');
		$this->db->join('product_information','image_gallery.product_id = product_information.product_id');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//image Search Item
	public function image_search_item($image_id)
	{
		$this->db->select('*');
		$this->db->from('image');
		$this->db->where('image_id',$image_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Insert image
	public function image_entry($data)
	{
		$result = $this->db->insert('image_gallery',$data);
		if ($result) {
			return TRUE;
		}else{
			return FALSE;
		}
	}
	//Retrieve image Edit Data
	public function retrieve_image_editdata($image_id)
	{
		$this->db->select('*');
		$this->db->from('image_gallery');
		$this->db->join('product_information','image_gallery.product_id = product_information.product_id');
		$this->db->where('image_gallery.image_gallery_id',$image_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Selected product
	public function selected_product($product_id){
		$result = $this->db->select('*')
							->from('product_information')
							->where('product_id',$product_id)
							->get()
							->result();
		return $result;
	}
	
	//Update Galleries
	public function update_image($data,$image_id)
	{
		$this->db->where('image_gallery_id',$image_id);
		$result = $this->db->update('image_gallery',$data);

		if ($result) {
			return true;
		}
		return false;
	}

	//Update Galleries
	public function update_gallery_image($data,$image_url)
	{
		$this->db->where('image_url',$image_url);
		$result = $this->db->update('image_gallery',$data);

		if ($result) {
			return true;
		}
		return false;
	}
	// Delete image Item
	public function delete_image($image_gallery_id)
	{
		$image_name =  $this->db->select('image_url')
            ->from('image_gallery')
            ->where('image_gallery_id',$image_gallery_id)
            ->get()
            ->result();
        if($image_name){
            unlink(FCPATH.$image_name->image_url);
        }
		$this->db->where('image_gallery_id',$image_gallery_id);
		$this->db->delete('image_gallery');
		return true;
	}

    public function get_gallery_images($product_id)
    {
        $result = $this->db->select('*')->from('image_gallery')->where('product_id',$product_id)->get()->result();
        return $result;
    }
}