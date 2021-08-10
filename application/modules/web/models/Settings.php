<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Settings extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	//About info
	public function about_info($page_id)
	{
		$default_lang  = 'english';
        $user_lang = $this->session->userdata('language');
        //set language  
        if (!empty($user_lang)) {
            $language = $user_lang; 
        } else {
            $language = $default_lang; 
        } 

		$this->db->select('*');
		$this->db->from('link_page');
		$this->db->where('page_id',$page_id);
		$this->db->where('language_id',$language);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}		

	//About_us Content Info
	public function about_content_info()
	{
		$default_lang  = 'english';
        $user_lang = $this->session->userdata('language');
        //set language  
        if (!empty($user_lang)) {
            $language = $user_lang; 
        } else {
            $language = $default_lang; 
        } 

        $this->db->select('*');
		$this->db->from('about_us');
		$this->db->where('language_id',$language);
		$this->db->order_by('position');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	
	//Our Location Content Info
	public function our_location_info()
	{
		$default_lang  = 'english';
        $user_lang = $this->session->userdata('language');
        //set language  
        if (!empty($user_lang)) {
            $language = $user_lang; 
        } else {
            $language = $default_lang; 
        } 

        $this->db->select('*');
		$this->db->from('our_location');
		$this->db->where('language_id',$language);
		$this->db->order_by('position');
		$this->db->limit('2');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//About info
	public function contact_us($page_id)
	{
		$default_lang  = 'english';
        $user_lang = $this->session->userdata('language');
        //set language  
        if (!empty($user_lang)) {
            $language = $user_lang; 
        } else {
            $language = $default_lang; 
        } 

		$this->db->select('*');
		$this->db->from('link_page');
		$this->db->where('page_id',$page_id);
		$this->db->where('language_id',$language);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	

	//About info
	public function submit_contact($data)
	{
		$result = $this->db->insert('contact',$data);
		if ($result) {
			return true;
		}
		return false;
	}	
}