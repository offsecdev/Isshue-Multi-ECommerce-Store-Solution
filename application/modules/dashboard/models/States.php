<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class States extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function count_states($filter = [])
    {
    	$this->db->select('id');
    	$this->db->from('states');

    	if(!empty($filter['country'])){
    		$this->db->where('country_id', $filter['country']);
    	}
    	if(!empty($filter['state'])){
    		$this->db->like('name', $filter['state'], 'both');
    	}
    	$result = $this->db->count_all_results();
    	return $result;
    }

    public function get_states($limit = 20, $start = 0, $filter = [])
    {
    	$this->db->select('a.*, b.name as country_name');
    	$this->db->from('states a');
    	$this->db->join('countries b','a.country_id=b.id','left');
    	if(!empty($filter['country'])){
    		$this->db->where('a.country_id', $filter['country']);
    	}
    	if(!empty($filter['state'])){
    		$this->db->like('a.name', $filter['state'], 'both');
    	}
    	$this->db->limit($limit, $start);
    	$this->db->order_by('a.id','desc');
    	$result = $this->db->get()->result_array();
    	return $result;
    }

    public function get_stateinfo_by_id($state_id)
    {
    	$this->db->select('*');
    	$this->db->from('states');
    	$this->db->where('id',$state_id);
    	$result = $this->db->get()->row_array();
    	return $result;
    }

    public function get_country_list()
    {
    	$this->db->order_by('name','asc');
    	$result = $this->db->get('countries')->result_array();
    	return $result;
    }
}