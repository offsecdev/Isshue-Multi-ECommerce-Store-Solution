<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Taxs extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }


    //tax List
    public function tax_list()
    {
        $this->db->select('*');
        $this->db->from('tax');
        $this->db->order_by('tax_name','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }


    //show only full of data has any row, that items.
    public function tax_list_except_empty()
    {
        $this->db->select('*');
        $this->db->from('tax');
        $this->db->where('tax_name !=','');
        $this->db->where('status =',1);
        $this->db->order_by('tax_name','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Tax Product List
    public function tax_product_list()
    {
        $this->db->select('*');
        $this->db->from('tax');
        $this->db->join('tax_product_service','tax.tax_id = tax_product_service.tax_id');
        $this->db->join('product_information','product_information.product_id = tax_product_service.product_id');
        $this->db->order_by('tax_name','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }


    //Product List
    public function product_list()
    {
        $this->db->select('*');
        $this->db->from('product_information');
        $this->db->order_by('product_name','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }


    //tax Search Item
    public function tax_search_item($tax_id)
    {
        $this->db->select('*');
        $this->db->from('tax');
        $this->db->where('tax_id',$tax_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }


    //Insert tax
    public function tax_entry($data)
    {
        $this->db->select('*');
        $this->db->from('tax');
        $this->db->where('tax_name',$data['tax_name']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return FALSE;
        }else{
            $this->db->insert('tax',$data);
            return TRUE;
        }
    }


    //Insert tax product
    public function tax_product_entry($data)
    {
        $this->db->select('*');
        $this->db->from('tax_product_service');
        $this->db->where('tax_id',$data['tax_id']);
        $this->db->where('product_id',$data['product_id']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return FALSE;
        }else{
            $this->db->insert('tax_product_service',$data);
            return TRUE;
        }
    }


    //Retrieve tax Edit Data
    public function retrieve_tax_editdata($t_p_s_id)
    {
        $this->db->select('*');
        $this->db->from('tax');
        $this->db->join('tax_product_service','tax.tax_id = tax_product_service.tax_id');
        $this->db->join('product_information','product_information.product_id = tax_product_service.product_id');
        $this->db->where('tax_product_service.t_p_s_id',$t_p_s_id);
        $this->db->order_by('tax_name','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }


    //Update tax Data
    public function tax_product_update($data,$t_p_s_id)
    {

        $this->db->where('t_p_s_id',$t_p_s_id);
        $result = $this->db->update('tax_product_service',$data);

        if ($result) {
            return TRUE;
        }
        return false;
    }


    //Selected product
    public function selected_product($product_id){
        return $result = $this->db->select('*')
            ->from('product_information')
            ->where('product_id',$product_id)
            ->get()
            ->result();
    }



    //Selected tax
    public function selected_tax($tax_id){
        return $result = $this->db->select('*')
            ->from('tax')
            ->where('tax_id',$tax_id)
            ->get()
            ->result();
    }

    //Update Taxs
    public function update_tax($data,$tax_id)
    {
        $this->db->where('tax_id',$tax_id);
        $result = $this->db->update('tax',$data);

        if ($result) {
            return true;
        }
        return false;
    }


    // Delete tax Item
    public function delete_tax($t_p_s_id)
    {
        $this->db->where('t_p_s_id',$t_p_s_id);
        $this->db->delete('tax_product_service');
        return true;
    }
    
}