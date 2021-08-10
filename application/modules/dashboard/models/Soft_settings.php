<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Soft_settings extends CI_Model {

	private $table  = "language";
	private $phrase = "phrase";


	public function __construct()
	{
		parent::__construct();
	}

	//Retrieve setting edit data
	public function retrieve_setting_editdata()
	{
		$this->db->select('*');
		$this->db->from('soft_setting');
		$this->db->where('setting_id',1);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Retrieve currency info
	public function retrieve_currency_info()
	{
		$this->db->select('*');
		$this->db->from('currency_info');
		$this->db->where('default_status',1);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	//Update setting
	public function update_setting($data)
	{
		$this->db->where('setting_id',1);
		$this->db->update('soft_setting',$data);
		return true;
	}

	//Language
	public function languages()
	{ 
		if ($this->db->table_exists($this->table)) { 
			$fields = $this->db->field_data($this->table);
			$i = 1;
			foreach ($fields as $field)
			{  
				if ($i++ > 2)
					$result[$field->name] = ucfirst($field->name);
			}

			if (!empty($result)) return $result;
		}else {
			return false; 
		}
	}

    	//Retrive Email Data
	public function retrieve_email_editdata(){
		$this->db->select('*');
		$this->db->from('email_configuration');
		$this->db->where('email_id',1);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

    	//Retrive sms Data
	public function retrieve_sms_editdata(){
		$this->db->select('*');
		$this->db->from('sms_configuration');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

// get sms getway
	public function retrieve_active_getway(){
		$this->db->select('*');
		$this->db->from('sms_configuration');
		$this->db->where('status',1);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();	
		}
		return false;
	}

    //Update Email
	public function update_email_config($data)
	{
		$this->db->where('email_id',1);
		$this->db->update('email_configuration',$data);
		return true;
	}  


	//Retrive payment edit data
	public function retrieve_payment_editdata()
	{
		$this->db->select('*');
		$this->db->from('payment_gateway');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Payment gateway update
	public function update_payment_gateway_setting($data,$id)
	{
		$this->db->where('id',$id);
		$this->db->update('payment_gateway',$data);
		return true;
	}  

	//Payment gateway update
	public function update_payment_gateway_setting_new($data,$used_id)
	{
		$this->db->where('used_id',$used_id);
		$this->db->update('payment_gateway',$data);
		return true;
	} 

	// Get country list
	public function get_country_list()
	{
		$this->db->order_by('name','asc');
		return $this->db->get('countries')->result_array();
	} 
}