<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Delivery_system extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function get_delivery_boys($per_page = null, $page = null){
    	$this->db->select('*');
    	$this->db->from('delivery_boy');
        $this->db->limit($per_page, $page);
    	$this->db->order_by('name','desc');
    	$result = $this->db->get()->result_array();
    	return $result;
	}
    public function delivery_boys_count(){
        $this->db->select('*');
        $this->db->from('delivery_boy');
        $this->db->order_by('name','desc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }

	public function get_delivery_boy_info_by_id($delivery_boy){
		$this->db->select('*');
    	$this->db->from('delivery_boy');
    	$this->db->where('id',$delivery_boy);
    	$result = $this->db->get()->row_array();
    	return $result;
	}

	public function delivery_boy_delete($delivery_boy){
        $delivery_boy_info = $this->db->select('national_id, driving_license')->from('delivery_boy')->where('id',$delivery_boy)->get()->result();
        if($delivery_boy_info){
            @unlink(FCPATH.$delivery_boy_info->national_id);
            @unlink(FCPATH.$delivery_boy_info->driving_license);
        }
        $this->db->where('id', $delivery_boy);
        $this->db->delete('delivery_boy');
        $this->session->set_userdata(array('message' => display('successfully_delete')));
        redirect('dashboard/Cdelivery_system/index');
	}

    public function get_time_slots($per_page = null, $page = null){
        $this->db->select('*');
        $this->db->from('delivery_time_slot');
        $this->db->limit($per_page, $page);
        $this->db->order_by('id','desc');
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function time_slots_count(){
        $this->db->select('*');
        $this->db->from('delivery_time_slot');
        $this->db->order_by('id','desc');
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->num_rows();
        }
        return false;
    }



    public function get_delivery_time_slot_info_by_id($delivery_time_slot){
        $this->db->select('*');
        $this->db->from('delivery_time_slot');
        $this->db->where('id',$delivery_time_slot);
        $result = $this->db->get()->row_array();
        return $result;
    }

    public function time_slot_delete($time_slot){
        $this->db->where('id', $time_slot);
        $this->db->delete('delivery_time_slot');
        $this->session->set_userdata(array('message' => display('successfully_delete')));
        redirect('dashboard/Cdelivery_system/manage_time_slot');
    }

    public function get_delivery_boys_info(){
        $this->db->select('id,name');
        $this->db->from('delivery_boy');
        $this->db->order_by('id','desc');
        $result = $this->db->get()->result();
        return $result;
    }

    public function get_delivery_zones($per_page = null, $page = null){
        $this->db->select('*');
        $this->db->from('delivery_zone');
        $this->db->limit($per_page, $page);
        $this->db->order_by('id','desc');
        $result = $this->db->get()->result_array();
        return $result;
    }
    public function delivery_zones_count(){
        $this->db->select('*');
        $this->db->from('delivery_zone');
        $this->db->order_by('id','desc');
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->num_rows();
        }
        return false;
    }
    public function get_delivery_zone_info_by_id($delivery_zone_id){
        $this->db->select('*');
        $this->db->from('delivery_zone');
        $this->db->where('id',$delivery_zone_id);
        $result = $this->db->get()->row_array();
        return $result;
    }
    public function delivery_zone_delete($delivery_zone_id){
        $this->db->where('id', $delivery_zone_id);
        $this->db->delete('delivery_zone');
        $this->session->set_userdata(array('message' => display('successfully_delete')));
        redirect('dashboard/Cdelivery_system/manage_delivery_zone');
    }
    public function get_active_delivery_zone(){
        $this->db->select('id,delivery_zone');
        $this->db->from('delivery_zone');
        $this->db->where('status',1);
        $this->db->order_by('id','desc');
        $result = $this->db->get()->result();
        return $result;
    }
    public function get_active_delivery_boy(){
        $this->db->select('id,name');
        $this->db->from('delivery_boy');
        $this->db->where('status',1);
        $this->db->order_by('id','desc');
        $result = $this->db->get()->result();
        return $result;
    }
    public function get_pending_orders(){
        $this->db->select('*');
        $this->db->from('order a');
        $this->db->join('invoice b','a.order_id = b.order_id');
        $this->db->where('b.invoice_status','4');
        $this->db->or_where('b.invoice_status','5');
        $result = $this->db->get()->result();
        return $result;
    }
    public function get_assigned_deliveries($per_page = null, $page = null){
        $this->db->select('a.*,b.name,c.delivery_zone,d.title');
        $this->db->from('delivery_assign a');
        $this->db->join('delivery_boy b','a.delivery_boy_id = b.id');
        $this->db->join('delivery_zone c','a.delivery_zone_id = c.id');
        $this->db->join('delivery_time_slot d','a.time_slot_id = d.id');
        $this->db->limit($per_page, $page);
        $this->db->order_by('delivery_id','desc');
        $result = $this->db->get()->result_array();
        return $result;
    }
    public function assigned_deliveries_count(){
        $this->db->select('a.*,b.name,c.delivery_zone,d.title');
        $this->db->from('delivery_assign a');
        $this->db->join('delivery_boy b','a.delivery_boy_id = b.id');
        $this->db->join('delivery_zone c','a.delivery_zone_id = c.id');
        $this->db->join('delivery_time_slot d','a.time_slot_id = d.id');
        $this->db->order_by('delivery_id','desc');
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->num_rows();
        }
        return false;
    }

    public function get_active_time_slots(){
        $this->db->select('*');
        $this->db->from('delivery_time_slot');
        $this->db->where('status',1);
        $this->db->order_by('id','desc');
        $result = $this->db->get()->result();
        return $result;
    }

    public function get_assigned_orders($delivery_id){
        $this->db->select('*');
        $this->db->from('delivery_orders');
        $this->db->where('delivery_id',$delivery_id);
        $this->db->order_by('delivery_id','desc');
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_assigned_delivery_info_by_id($delivery_id)
    {
        $this->db->select('*');
        $this->db->from('delivery_assign');
        $this->db->where('delivery_id',$delivery_id);
        $result = $this->db->get()->row_array();
        return $result;
    }

    public function get_assigned_delivery_order_info_by_id($delivery_id)
    {
        $this->db->select('order_no');
        $this->db->from('delivery_orders');
        $this->db->where('delivery_id',$delivery_id);
        $result = $this->db->get()->result();
        return $result;
    }
    public function assigned_delivery_delete($delivery_id){
        $this->db->where('delivery_id', $delivery_id);
        $this->db->delete('delivery_assign');
        $this->session->set_userdata(array('message' => display('successfully_delete')));
        redirect('dashboard/Cdelivery_system/manage_assigned_delivery');
    }
    
}