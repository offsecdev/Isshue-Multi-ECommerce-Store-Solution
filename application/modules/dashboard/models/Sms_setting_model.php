<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_setting_model extends CI_model {


	//get template list
	public function template_list(){
		return $data = $this->db->select('*')
		->from('sms_template')
		->get()
		->result();
	}

	public function save_sms_template($data){
		$result = $this->db->insert('sms_template',$data);
		return $result;
	}
//update template
	public function template_update($data){
		$id = $this->input->post('id',TRUE);
		$result=$this->db->where('id',$id)->update('sms_template',$data);
		return $result;
	}


	public function update_sms_config($data)
	{
		$id = $this->input->post('id',TRUE);
		if($id){
			$this->db->where('id',$id);
            $result = $this->db->update('sms_configuration',$data);

			$this->db->set('status',0)
            ->where('id !=', $id)
            ->update('sms_configuration');
			return $result;
		}else{
			$result = $this->db->insert('sms_configuration',$data);
			return $result;
		}

	}   


} 	 