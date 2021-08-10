<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Color_backends extends CI_Model {

//get backend template color
	public function retrieve_color_editdata()
	{
		$this->db->select('*');
		$this->db->from('color_backends');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();	
		}
		return false;
	}
//update backent template color
	public function update_color($data)
	{
		$this->db->select('*');
		$this->db->from('color_backends');
		$query = $this->db->get()->num_rows();

		if($query){
			$this->db->where('id',1)->update('color_backends',$data);
			return true;
		}else{
			$success = $this->db->insert('color_backends',$data);
			if($success){
				return  true;				
			}else{
				return false;
			}
		}
	}

}