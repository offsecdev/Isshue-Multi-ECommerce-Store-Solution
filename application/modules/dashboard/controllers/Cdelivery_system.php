<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cdelivery_system extends MX_Controller{

    function __construct() {
        parent::__construct();
        $this->load->model('dashboard/Delivery_system');
    }
    public function index($page = 0)
    {
        $this->permission->check_label('manage_delivery_boy')->read()->redirect(); 

        $config["base_url"]          = base_url('dashboard/Cdelivery_system/index');
        $config["total_rows"]        = $this->Delivery_system->delivery_boys_count();
        $config["reuse_query_string"]= TRUE;
        $config["per_page"]          = 20;
        $config["uri_segment"]       = 4;
        $config["num_links"]         = 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open']    = "<ul class='pagination'>";
        $config['full_tag_close']   = "</ul>";
        $config['num_tag_open']     = '<li>';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']     = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close']    = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open']    = "<li>";
        $config['next_tag_close']   = "</li>";
        $config['prev_tag_open']    = "<li>";
        $config['prev_tagl_close']  = "</li>";
        $config['first_tag_open']   = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open']    = "<li>";
        $config['last_tagl_close']  = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $delivery_boys = $this->Delivery_system->get_delivery_boys($config["per_page"],$page);
        $links = $this->pagination->create_links();
        $data = array(
            'title' => display('manage_delivery_boy'),
            'delivery_boys' => $delivery_boys,
            'paginlink' => $links,
            'page' => $page
        );
        $content = $this->parser->parse('dashboard/delivery_system/index',$data,true);
        $this->template_lib->full_admin_html_view($content);
    }
    // delivery boy add

    public function add_delivery_boy(){
        $this->permission->check_label('add_delivery_boy')->create()->redirect(); 

        $this->form_validation->set_rules('name', display('name'), 'trim|required');
        $this->form_validation->set_rules('mobile', display('mobile'), 'trim|required');
        if($this->form_validation->run() == TRUE){
            if (!empty($_FILES['national_id']['name'])) {
                //Chapter chapter add start
                $config['upload_path']   = './my-assets/image/delivery_system/national_id/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
                $config['max_size']      = "*";
                $config['max_width']     = "*";
                $config['max_height']    = "*";
                $config['encrypt_name']  = TRUE;
                $this->upload->initialize($config);
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('national_id')){
                    $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                    redirect('dashboard/Cdelivery_system/add_delivery_boy');
                } else {
                    $image = $this->upload->data();
                    $image_url = "my-assets/image/delivery_system/national_id/" . $image['file_name'];
                    $thumb_image = $image_url;
                }
            }
            if (!empty($_FILES['driving_license']['name'])) {
                //Chapter chapter add start
                $config['upload_path']    = './my-assets/image/delivery_system/driving_license/';
                $config['allowed_types']  = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
                $config['max_size']       = "*";
                $config['max_width']      = "*";
                $config['max_height']     = "*";
                $config['encrypt_name']   = TRUE;
                $this->upload->initialize($config);
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('driving_license')){
                    $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                    redirect('dashboard/Cdelivery_system/add_delivery_boy');
                } else {
                    $image = $this->upload->data();
                    $image_url = "my-assets/image/delivery_system/driving_license/" . $image['file_name'];
                    $delivery_thumb = $image_url;
                }
            }
            $data = array(
                'name'            => $this->input->post('name', TRUE),
                'mobile'          => $this->input->post('mobile', TRUE),
                'address'         => $this->input->post('address', TRUE),
                'driving_license' => (!empty($delivery_thumb) ? $delivery_thumb : 'my-assets/image/delivery_system/driving_license/license.png'),
                'national_id'     => (!empty($thumb_image) ? $thumb_image : 'my-assets/image/delivery_system/national_id/id.png'),
                'birth_date'      => $this->input->post('birth_date', TRUE),
                'bank_name'       => $this->input->post('bank_name', TRUE),
                'account_no'      => $this->input->post('account_no', TRUE),
                'account_name'    => $this->input->post('account_name', TRUE),
                'status'          => 1,
                'created_by'      => $this->session->userdata('user_id'),
            );
            $result = $this->db->insert('delivery_boy', $data);
            if($result){
                $this->session->set_userdata(array('message' => display('successfully_added')));
                if (isset($_POST['add-item'])) {
                    redirect('dashboard/Cdelivery_system/index');
                } elseif (isset($_POST['add-item-another'])) {
                    redirect('dashboard/Cdelivery_system/add_delivery_boy');
                }
                
            }else{
                $this->session->set_userdata(array('error_message' => display('failed_try_again')));
            }
        }
        $data = array(
            'title' => display('add_delivery_boy'),
        );
        $content = $this->parser->parse('dashboard/delivery_system/add_delivery_boy',$data,true);
        $this->template_lib->full_admin_html_view($content);
    } 

    // delivery boy edit 
    public function edit_delivery_boy($delivery_boy_id){
        $this->permission->check_label('manage_delivery_boy')->update()->redirect();

        $this->form_validation->set_rules('name', display('name'), 'trim|required');
        $this->form_validation->set_rules('mobile', display('mobile'), 'trim|required');

        if($this->form_validation->run() == TRUE){
            // dd($_FILES);
            $image = null;
            if ($_FILES['national_id']['name']) {

                //Chapter chapter add start
                $config['upload_path']   = './my-assets/image/delivery_system/national_id/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
                $config['max_size']      = "*";
                $config['max_width']     = "*";
                $config['max_height']    = "*";
                $config['encrypt_name']  = TRUE;
                $this->upload->initialize($config);
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('national_id')) {
                    $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                    redirect('dashboard/Cdelivery_system/edit_delivery_boy/'.$delivery_boy_id);
                } else {
                    $image       = $this->upload->data();
                    $image_url   = "my-assets/image/delivery_system/national_id/".$image['file_name'];
                    $national_id = $image_url;
                    //Old image delete
                    $old_national_id = $this->input->post('old_national_id',TRUE);
                    $old_file        = substr($old_national_id, strrpos($old_national_id, '/') + 1);
                    @unlink(FCPATH . 'my-assets/image/delivery_system/national_id/' . $old_file);
                }
            }
            $image = null;
            if ($_FILES['driving_license']['name']) {
                //Chapter chapter add start
                $config['upload_path']   = './my-assets/image/delivery_system/driving_license/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
                $config['max_size']      = "*";
                $config['max_width']     = "*";
                $config['max_height']    = "*";
                $config['encrypt_name']  = TRUE;
                $this->upload->initialize($config);
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('driving_license')) {
                    $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                    redirect('dashboard/Cdelivery_system/edit_delivery_boy/'.$delivery_boy_id);
                } else {
                    $image           = $this->upload->data();
                    $image_url       = "my-assets/image/delivery_system/driving_license/".$image['file_name'];
                    $driving_license = $image_url;
                    //Old image delete
                    $old_driving_license = $this->input->post('old_driving_license',TRUE);
                    $old_file        = substr($old_driving_license, strrpos($old_driving_license, '/') + 1);
                    @unlink(FCPATH . 'my-assets/image/delivery_system/driving_license/' . $old_file);
                }
            }

            $old_driving_license = $this->input->post('old_driving_license',TRUE);
            $old_national_id     = $this->input->post('old_national_id',TRUE);
            $data = array(
                'name'            => $this->input->post('name', TRUE),
                'mobile'          => $this->input->post('mobile', TRUE),
                'address'         => $this->input->post('address', TRUE),
                'driving_license' => (!empty($driving_license) ? $driving_license : $old_driving_license),
                'national_id'     => (!empty($national_id) ? $national_id : $old_national_id),
                'birth_date'      => $this->input->post('birth_date', TRUE),
                'bank_name'       => $this->input->post('bank_name', TRUE),
                'account_no'      => $this->input->post('account_no', TRUE),
                'account_name'    => $this->input->post('account_name', TRUE),
                'status'          => $this->input->post('status', TRUE),
                'created_by'      => $this->session->userdata('user_id'),
            );
            $result = $this->db->update('delivery_boy', $data, array('id' => $delivery_boy_id));
            if($result){
                 $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect('dashboard/Cdelivery_system/index');
            }else{
                $this->session->set_userdata(array('error_message' => display('failed_try_again')));
            }
        }
        $delivery_boy_info = $this->Delivery_system->get_delivery_boy_info_by_id($delivery_boy_id);
        $data = array(
            'title' => display('edit_delivery_boy'),
            'delivery_boy_info' => $delivery_boy_info
        );
        $content = $this->parser->parse('dashboard/delivery_system/edit_delivery_boy',$data,true);
        $this->template_lib->full_admin_html_view($content);
    }

    public function delivery_boy_delete($delivery_boy_id)
    {
        $this->permission->check_label('manage_delivery_boy')->delete()->redirect();

        $this->Delivery_system->delivery_boy_delete($delivery_boy_id);
    }
    public function add_time_slot(){
        $this->permission->check_label('add_time_slot')->create()->redirect();

        $this->form_validation->set_rules('title', display('title'), 'trim|required');
        $this->form_validation->set_rules('from_time', display('from_time'), 'trim|required');
        $this->form_validation->set_rules('to_time', display('to_time'), 'trim|required');

        if($this->form_validation->run() == TRUE){
            $data = array(
                'title'           => $this->input->post('title', TRUE),
                'from_time'       => $this->input->post('from_time', TRUE),
                'to_time'         => $this->input->post('to_time', TRUE),
                'last_order_time' => $this->input->post('last_order_time', TRUE),
                'status'          => $this->input->post('status', TRUE),
                'created_by'      => $this->session->userdata('user_id'),
            );

            $result = $this->db->insert('delivery_time_slot', $data);
            if($result){
                $this->session->set_userdata(array('message' => display('successfully_added')));
                
                if (isset($_POST['add-item'])) {
                    redirect('dashboard/Cdelivery_system/manage_time_slot');
                } elseif (isset($_POST['add-item-another'])) {
                    redirect('dashboard/Cdelivery_system/add_time_slot');
                }
            }else{
                $this->session->set_userdata(array('error_message' => display('failed_try_again')));
            }
        }

        $data = array(
            'title' => display('add_time_slot'),
        );
        $content = $this->parser->parse('dashboard/delivery_system/add_time_slot',$data,true);
        $this->template_lib->full_admin_html_view($content);
    }

    public function manage_time_slot(){
        $this->permission->check_label('manage_time_slot')->read()->redirect();

        $config["base_url"]           = base_url('dashboard/Cdelivery_system/manage_time_slot');
        $config["total_rows"]         = $this->Delivery_system->time_slots_count();
        $config["reuse_query_string"] = TRUE;
        $config["per_page"]           = 20;
        $config["uri_segment"]        = 4;
        $config["num_links"]          = 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open']    = "<ul class='pagination'>";
        $config['full_tag_close']   = "</ul>";
        $config['num_tag_open']     = '<li>';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']     = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close']    = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open']    = "<li>";
        $config['next_tag_close']   = "</li>";
        $config['prev_tag_open']    = "<li>";
        $config['prev_tagl_close']  = "</li>";
        $config['first_tag_open']   = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open']    = "<li>";
        $config['last_tagl_close']  = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $links = $this->pagination->create_links();

        $time_slots = $this->Delivery_system->get_time_slots($config["per_page"],$page);
        $data = array(
            'title'      => display('manage_time_slot'),
            'time_slots' => $time_slots,
            'links'      => $links,
            'page'       => $page
        );
        $content = $this->parser->parse('dashboard/delivery_system/manage_time_slot',$data,true);
        $this->template_lib->full_admin_html_view($content);
    }

    // time slot edit 
    public function edit_time_slot($delivery_time_slot){
        $this->permission->check_label('manage_time_slot')->update()->redirect();

        $this->form_validation->set_rules('title', display('title'), 'trim|required');
        $this->form_validation->set_rules('from_time', display('from_time'), 'trim|required');
        $this->form_validation->set_rules('to_time', display('to_time'), 'trim|required');

        if($this->form_validation->run() == TRUE){
            $data = array(
                'title'           => $this->input->post('title', TRUE),
                'from_time'       => $this->input->post('from_time', TRUE),
                'to_time'         => $this->input->post('to_time', TRUE),
                'last_order_time' => $this->input->post('last_order_time', TRUE),
                'status'          => $this->input->post('status', TRUE),
            );
            $result = $this->db->update('delivery_time_slot', $data, array('id' => $delivery_time_slot));
            if($result){
                 $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect('dashboard/Cdelivery_system/manage_time_slot');
            }else{
                $this->session->set_userdata(array('error_message' => display('failed_try_again')));
            }
        }

        $delivery_time_slot_info = $this->Delivery_system->get_delivery_time_slot_info_by_id($delivery_time_slot);
        $data = array(
            'title' => display('edit_delivery_time_slot'),
            'delivery_time_slot_info' => $delivery_time_slot_info
        );
        $content = $this->parser->parse('dashboard/delivery_system/edit_delivery_time_slot',$data,true);
        $this->template_lib->full_admin_html_view($content);
    }

    public function time_slot_delete($time_slot)
    {
        $this->permission->check_label('manage_time_slot')->delete()->redirect();
        $this->Delivery_system->time_slot_delete($time_slot);
    }

    public function add_delivery_zone(){
        $this->permission->check_label('add_delivery_zone')->create()->redirect();

        $this->form_validation->set_rules('delivery_zone', display('delivery_zone'), 'trim|required');

        if($this->form_validation->run() == TRUE){
            $data = array(
                'delivery_zone' => $this->input->post('delivery_zone', TRUE),
                'status'        => $this->input->post('status', TRUE),
            );

            $result = $this->db->insert('delivery_zone', $data);
            if($result){
                $this->session->set_userdata(array('message' => display('successfully_added')));
                if (isset($_POST['add-item'])) {
                    redirect('dashboard/Cdelivery_system/manage_delivery_zone');
                } elseif (isset($_POST['add-item-another'])) {
                    redirect('dashboard/Cdelivery_system/add_delivery_zone');
                }
                
            }else{
                $this->session->set_userdata(array('error_message' => display('failed_try_again')));
            }
        }
        $data = array(
            'title' => display('add_delivery_zone'),
        );
        $content = $this->parser->parse('dashboard/delivery_system/delivery_zone/add_delivery_zone',$data,true);
        $this->template_lib->full_admin_html_view($content);
    }
    public function manage_delivery_zone(){
        $this->permission->check_label('manage_delivery_zone')->read()->redirect();
        $config["base_url"]           = base_url('dashboard/Cdelivery_system/manage_delivery_zone');
        $config["total_rows"]         = $this->Delivery_system->delivery_zones_count();
        $config["reuse_query_string"] = TRUE;
        $config["per_page"]           = 20;
        $config["uri_segment"]        = 4;
        $config["num_links"]          = 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open']    = "<ul class='pagination'>";
        $config['full_tag_close']   = "</ul>";
        $config['num_tag_open']     = '<li>';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']     = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close']    = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open']    = "<li>";
        $config['next_tag_close']   = "</li>";
        $config['prev_tag_open']    = "<li>";
        $config['prev_tagl_close']  = "</li>";
        $config['first_tag_open']   = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open']    = "<li>";
        $config['last_tagl_close']  = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $links = $this->pagination->create_links();

        $delivery_zones = $this->Delivery_system->get_delivery_zones($config["per_page"],$page);
        $data = array(
            'title'          => display('manage_delivery_zone'),
            'delivery_zones' => $delivery_zones,
            'links'          => $links,
            'page'           => $page
        );
        $content = $this->parser->parse('dashboard/delivery_system/delivery_zone/manage_delivery_zone',$data,true);
        $this->template_lib->full_admin_html_view($content);
    }
    public function edit_delivery_zone($delivery_zone_id){
        $this->permission->check_label('manage_delivery_zone')->update()->redirect();

        $this->form_validation->set_rules('delivery_zone', display('delivery_zone'), 'trim|required');
        if($this->form_validation->run() == TRUE){
            $data = array(
                'delivery_zone' => $this->input->post('delivery_zone', TRUE),
                'status'        => $this->input->post('status', TRUE)
            );
            $result = $this->db->update('delivery_zone', $data, array('id' => $delivery_zone_id));
            if($result){
                $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect('dashboard/Cdelivery_system/manage_delivery_zone');
            }else{
                $this->session->set_userdata(array('error_message' => display('failed_try_again')));
            }
        }
        $delivery_zone_info = $this->Delivery_system->get_delivery_zone_info_by_id($delivery_zone_id);
        $data = array(
            'title'              => display('edit_delivery_zone'),
            'delivery_zone_info' => $delivery_zone_info
        );
        $content = $this->parser->parse('dashboard/delivery_system/delivery_zone/edit_delivery_zone',$data,true);
        $this->template_lib->full_admin_html_view($content);
    }
    public function delivery_zone_delete($delivery_zone_id){
        $this->permission->check_label('manage_delivery_zone')->delete()->redirect();
        $this->Delivery_system->delivery_zone_delete($delivery_zone_id);
    }
    public function assign_delivery(){
        $this->permission->check_label('assign_delivery')->create()->redirect();
        $this->form_validation->set_rules('delivery_boy_id', display('delivery_boy_id'), 'trim|required');
        $this->form_validation->set_rules('delivery_zone_id', display('delivery_zone_id'), 'trim|required');
        $this->form_validation->set_rules('order_no[]', display('order_no[]'), 'required');
        
        if($this->form_validation->run() == TRUE){
            $delivery_assign = array(
                'delivery_boy_id'  => $this->input->post('delivery_boy_id', TRUE),
                'delivery_zone_id' => $this->input->post('delivery_zone_id', TRUE),
                'time_slot_id'     => $this->input->post('time_slot_id', TRUE),
                'created_by'       => $this->session->userdata('user_id'),
                'status'           => $this->input->post('status', TRUE),
                'completed_at'     => $this->input->post('completed_at', TRUE),
                'note'             => $this->input->post('note', TRUE),
                'status'           => $this->input->post('status', TRUE),
            );
            $result      = $this->db->insert('delivery_assign', $delivery_assign);
            $delivery_id = $this->db->insert_id();
            $orders      = $this->input->post('order_no[]', TRUE);
            foreach ($orders as $order) {
                $delivery_orders = array(
                    'delivery_id'      => $delivery_id,
                    'order_no'         => $order,
                );
                $delivery_orders = $this->db->insert('delivery_orders', $delivery_orders);
            }
            if($result){
                $this->session->set_userdata(array('message' => display('successfully_assigned')));
                if (isset($_POST['add-item'])) {
                    redirect('dashboard/Cdelivery_system/manage_assigned_delivery');
                } elseif (isset($_POST['add-item-another'])) {
                    redirect('dashboard/Cdelivery_system/assign_delivery');
                }
                
            }else{
                $this->session->set_userdata(array('error_message' => display('failed_try_again')));
            }
        }
        $delivery_boys  = $this->Delivery_system->get_active_delivery_boy();
        $delivery_zones = $this->Delivery_system->get_active_delivery_zone();
        $time_slots     = $this->Delivery_system->get_active_time_slots();
        $pending_orders = $this->Delivery_system->get_pending_orders();
        $data = array(
            'title'         => display('assign_delivery'),
            'delivery_boys' => $delivery_boys,
            'delivery_zones'=> $delivery_zones,
            'time_slots'    => $time_slots,
            'pending_orders'=> $pending_orders,
        );
        $content = $this->parser->parse('dashboard/delivery_system/assign_delivery/assign_delivery',$data,true);
        $this->template_lib->full_admin_html_view($content);
    }
    public function manage_assigned_delivery(){
        $this->permission->check_label('manage_assigned_delivery')->read()->redirect();

        $config["base_url"]           = base_url('dashboard/Cdelivery_system/manage_assigned_delivery');
        $config["total_rows"]         = $this->Delivery_system->assigned_deliveries_count();
        $config["reuse_query_string"] = TRUE;
        $config["per_page"]           = 20;
        $config["uri_segment"]        = 4;
        $config["num_links"]          = 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open']    = "<ul class='pagination'>";
        $config['full_tag_close']   = "</ul>";
        $config['num_tag_open']     = '<li>';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']     = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close']    = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open']    = "<li>";
        $config['next_tag_close']   = "</li>";
        $config['prev_tag_open']    = "<li>";
        $config['prev_tagl_close']  = "</li>";
        $config['first_tag_open']   = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open']    = "<li>";
        $config['last_tagl_close']  = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $links = $this->pagination->create_links();

        $assigned_deliveries = $this->Delivery_system->get_assigned_deliveries($config["per_page"],$page);
        $data = array(
            'title'               => display('manage_assigned_delivery'),
            'assigned_deliveries' => $assigned_deliveries,
            'links'               => $links,
            'page'                => $page
        );
        $content = $this->parser->parse('dashboard/delivery_system/assign_delivery/manage_assigned_delivery',$data,true);
        $this->template_lib->full_admin_html_view($content);
    }
    public function edit_assigned_delivery($delivery_id){
        $this->permission->check_label('manage_assigned_delivery')->update()->redirect();

        $this->form_validation->set_rules('delivery_boy_id', display('delivery_boy_id'), 'trim|required');
        $this->form_validation->set_rules('delivery_zone_id', display('delivery_zone_id'), 'trim|required');
        $this->form_validation->set_rules('order_no[]', display('order_no[]'), 'required');
        if($this->form_validation->run() == TRUE){
            $delivery_assign = array(
                'delivery_boy_id'  => $this->input->post('delivery_boy_id', TRUE),
                'delivery_zone_id' => $this->input->post('delivery_zone_id', TRUE),
                'time_slot_id'     => $this->input->post('time_slot_id', TRUE),
                'created_by'       => $this->session->userdata('user_id'),
                'status'           => $this->input->post('status', TRUE),
            );
            $result = $this->db->update('delivery_assign', $delivery_assign, array('delivery_id' => $delivery_id));
            // delete order history
            $this->db->delete('delivery_orders',array('delivery_id' => $delivery_id));

            $orders = $this->input->post('order_no[]', TRUE);
            foreach ($orders as $order) {
                $delivery_orders = array(
                    'delivery_id' => $delivery_id,
                    'order_no'    => $order,
                );
                $delivery_orders = $this->db->insert('delivery_orders', $delivery_orders);
            }
            if($result){
                $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect('dashboard/Cdelivery_system/manage_assigned_delivery');
            }else{
                $this->session->set_userdata(array('error_message' => display('failed_try_again')));
            }
        }
        $assigned_delivery_info       = $this->Delivery_system->get_assigned_delivery_info_by_id($delivery_id);
        $assigned_delivery_order_info = $this->Delivery_system->get_assigned_delivery_order_info_by_id($delivery_id);
        $delivery_orders = [];
        if (!empty($assigned_delivery_order_info)) {
            $delivery_orders = array_column($assigned_delivery_order_info, 'order_no');
        }
        $delivery_boys          = $this->Delivery_system->get_active_delivery_boy();
        $delivery_zones         = $this->Delivery_system->get_active_delivery_zone();
        $time_slots             = $this->Delivery_system->get_active_time_slots();
        $pending_orders         = $this->Delivery_system->get_pending_orders();
        $data = array(
            'title'                  => display('edit_assigned_delivery'),
            'delivery_orders'        => $delivery_orders,
            'assigned_delivery_info' => $assigned_delivery_info,
            'delivery_boys'          => $delivery_boys,
            'delivery_zones'         => $delivery_zones,
            'time_slots'             => $time_slots,
            'pending_orders'         => $pending_orders,
        );
        $content = $this->parser->parse('dashboard/delivery_system/assign_delivery/edit_assigned_delivery',$data,true);
        $this->template_lib->full_admin_html_view($content);
    }

    public function assigned_delivery_delete($delivery_id){
        $this->permission->check_label('manage_assigned_delivery')->delete()->redirect();

        // delete order history
        $this->db->delete('delivery_orders',array('delivery_id' => $delivery_id));
        $this->Delivery_system->assigned_delivery_delete($delivery_id);
    }
}