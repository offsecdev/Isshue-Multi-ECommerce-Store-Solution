<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ccoupon extends MX_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->library('dashboard/lcoupon');
        $this->load->model('dashboard/Coupons');
        $this->auth->check_user_auth();

    }

    //Default loading for coupon system.
    public function index()
    {
        $this->permission->check_label('coupon')->create()->redirect();

        $content = $this->lcoupon->coupon_add_form();
        $this->template_lib->full_admin_html_view($content);
    }

    //Insert coupon
    public function insert_coupon()
    {
        $this->permission->check_label('coupon')->create()->redirect();

        $this->form_validation->set_rules('coupon_name', display('coupon_name'), 'trim|required');
        $this->form_validation->set_rules('discount_type', display('discount_type'), 'trim|required');
        $this->form_validation->set_rules('start_date', display('start_date'), 'trim|required');
        $this->form_validation->set_rules('end_date', display('end_date'), 'trim|required');

        $discount_type = $this->input->post('discount_type',TRUE);
        if ($discount_type == 1) {

            $this->form_validation->set_rules('discount_amount', display('discount_amount'), 'trim|required|numeric');
        } else {

            $this->form_validation->set_rules('discount_percentage', display('discount_percentage'), 'trim|required|numeric');
        }
        

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => display('add_coupon'),
            );
            $content = $this->parser->parse('coupon/add_coupon',$data,true);
            $this->template_lib->full_admin_html_view($content);
        } else {
            $discount_type = $this->input->post('discount_type',TRUE);
            if ($discount_type == 1) {
                $discount_amount = $this->input->post('discount_amount',TRUE);
            } else {
                $discount_percentage = $this->input->post('discount_percentage',TRUE);
            }

            $start_date = date('d-m-Y', strtotime($this->input->post('start_date',TRUE)));
            $end_date = date('d-m-Y', strtotime($this->input->post('end_date',TRUE)));

            $data = array(
                'coupon_id' => $this->auth->generator(15),
                'coupon_name' => $this->input->post('coupon_name',TRUE),
                'coupon_discount_code' => $this->auth->generator(5),
                'discount_type' => $this->input->post('discount_type',TRUE),
                'discount_amount' => (!empty($discount_amount) ? $discount_amount : null),
                'discount_percentage' => (!empty($discount_percentage) ? $discount_percentage : null),
                'start_date' => $start_date,
                'end_date' => $end_date,
                'status' => 1,
            );

            $result = $this->Coupons->coupon_entry($data);

            if ($result == TRUE) {

                $this->session->set_userdata(array('message' => display('successfully_added')));

                if (isset($_POST['add-coupon'])) {
                    redirect(base_url('dashboard/Ccoupon/manage_coupon'));
                } elseif (isset($_POST['add-coupon-another'])) {
                    redirect(base_url('dashboard/Ccoupon'));
                }

            } else {
                $this->session->set_userdata(array('error_message' => display('already_exists')));
                redirect(base_url('dashboard/Ccoupon'));
            }
        }
    }

    //Manage coupon
    public function manage_coupon()
    {
        $this->permission->check_label('coupon')->read()->redirect();

        $content =$this->lcoupon->coupon_list();
        $this->template_lib->full_admin_html_view($content);;
    }
    //coupon Update Form
    public function coupon_update_form($coupon_id)
    {   
        $this->permission->check_label('coupon')->update()->redirect();

        $content = $this->lcoupon->coupon_edit_data($coupon_id);
        $this->template_lib->full_admin_html_view($content);
    }

    // coupon Update
    public function coupon_update($coupon_id = null)
    {
        $this->permission->check_label('coupon')->update()->redirect();

        $this->form_validation->set_rules('coupon_name', display('coupon_name'), 'trim|required');
        $this->form_validation->set_rules('discount_type', display('discount_type'), 'trim|required');
        $this->form_validation->set_rules('start_date', display('start_date'), 'trim|required');
        $this->form_validation->set_rules('end_date', display('end_date'), 'trim|required');

        $discount_type = $this->input->post('discount_type',TRUE);
        if ($discount_type == 1) {

            $this->form_validation->set_rules('discount_amount', display('discount_amount'), 'trim|required|numeric');
        } else {

            $this->form_validation->set_rules('discount_percentage', display('discount_percentage'), 'trim|required|numeric');
        }


        if ($this->form_validation->run() == FALSE) {
            $this->coupon_update_form($coupon_id);

        } else {
            $discount_type = $this->input->post('discount_type',TRUE);
            if ($discount_type == 1) {
                $discount_amount = $this->input->post('discount_amount',TRUE);
            } else {
                $discount_percentage = $this->input->post('discount_percentage');
            }

            $start_date = date('d-m-Y', strtotime($this->input->post('start_date',TRUE)));
            $end_date = date('d-m-Y', strtotime($this->input->post('end_date',TRUE)));

            $data = array(
                'coupon_name' => $this->input->post('coupon_name',TRUE),
                'discount_type' => $this->input->post('discount_type',TRUE),
                'discount_amount' => (!empty($discount_amount) ? $discount_amount : null),
                'discount_percentage' => (!empty($discount_percentage) ? $discount_percentage : null),
                'start_date' => $start_date,
                'end_date' => $end_date,
                'status' => 1,
            );

            $result = $this->Coupons->update_coupon($data, $coupon_id);

            if ($result == TRUE) {
                $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect('dashboard/Ccoupon/manage_coupon');
            } else {
                $this->session->set_userdata(array('error_message' => display('already_exists')));
                redirect('dashboard/Ccoupon/manage_coupon');
            }
        }
    }

    // coupon Delete
    public function coupon_delete($coupon_id)
    {
        $this->permission->check_label('coupon')->delete()->redirect();

        $this->Coupons->delete_coupon($coupon_id);
        $this->session->set_userdata(array('message' => display('successfully_delete')));
        redirect('dashboard/Ccoupon/manage_coupon');
    }

    //Inactive
    public function inactive($id)
    {
        $this->permission->check_label('coupon')->update()->redirect();

        $this->db->set('status', 0);
        $this->db->where('coupon_id', $id);
        $this->db->update('coupon');
        $this->session->set_userdata(array('error_message' => display('successfully_inactive')));
        redirect(base_url('dashboard/Ccoupon/manage_coupon'));
    }

    //Active
    public function active($id)
    {
        $this->permission->check_label('coupon')->update()->redirect();
        
        $this->db->set('status', 1);
        $this->db->where('coupon_id', $id);
        $this->db->update('coupon');
        $this->session->set_userdata(array('message' => display('successfully_active')));
        redirect(base_url('dashboard/Ccoupon/manage_coupon'));
    }
}