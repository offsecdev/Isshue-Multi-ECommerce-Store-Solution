<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Search_history extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function search_histries(){
		$query = $this->db->select('*')
            ->from('search_history')
            ->order_by('hits','DESC')
            ->limit(5)
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
	}
	//insert Search History
	public function insert_search_history($search_data)
	{
		$this->db->select('*');
		$this->db->from('search_history');
		$this->db->where('keyword',$search_data['keyword']);
		$query = $this->db->get()->result();
		if (count($query) > 0) {
			$this->db->set('hits',($query[0]->hits)+1);
			$this->db->set('results',$query[0]->results);
			$this->db->where('keyword',$query[0]->keyword);
			$result = $this->db->update('search_history');
			return TRUE;
		}else{
			$search_data['hits'] = 1;
			$this->db->insert('search_history',$search_data);
			return TRUE;
		}
	}

	public function all_search_histries(){
		$query = $this->db->select('*')
            ->from('search_history')
            ->order_by('hits','DESC')
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
	}
}