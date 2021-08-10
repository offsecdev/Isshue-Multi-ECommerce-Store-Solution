<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pay_withs extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function pay_with_list(){
		$this->db->select('*');
		$this->db->from('pay_withs');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	public function pay_with_list_for_homepage(){
		$this->db->select('*');
		$this->db->from('pay_withs');
		$this->db->where('status',1);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}


	public function retrieve_pay_with_editdata($id){
		$this->db->select('*');
		$this->db->from('pay_withs');
		$this->db->where('id',$id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

//update pay with module
	public function update($data,$id)
	{
		$this->db->where('id',$id);
		$result = $this->db->update('pay_withs',$data);
		if ($result) {
			return true;
		}
		return false;
	}


	public function delete($id)
	{

		// get file name
		$this->db->select('image');
		$this->db->from('pay_withs');
		$this->db->where('id',$id);
		$query = $this->db->get();
		$image_name= $query->row();


		//delete data from database
		$this->db->where('id',$id);
		$result=$this->db->delete('pay_withs'); 	
		if($result)
		{
			unlink(FCPATH."my-assets/image/pay_with/".$image_name->image); //delete file from folder
		}
		return true;
	}

	
}