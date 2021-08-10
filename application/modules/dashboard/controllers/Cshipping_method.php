<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cshipping_method extends MX_Controller
{

    function __construct() {
      parent::__construct();
        $this->load->library('dashboard/lshipping_method');
        $this->load->model('dashboard/Shipping_methods');
        $this->auth->check_user_auth();
    }
    //Default loading for shipping_method system.
    public function index()
    {
        $this->permission->check_label('shipping_method')->create()->redirect();

        $content = $this->lshipping_method->shipping_method_add_form();
        $this->template_lib->full_admin_html_view($content);
    }

    //Insert shipping_method
    public function insert_shipping_method()
    {
        $this->permission->check_label('shipping_method')->create()->redirect();

        $this->form_validation->set_rules('position', display('position'), 'trim|required');
        $this->form_validation->set_rules('method_name', display('name'), 'trim|required');
        $this->form_validation->set_rules('details', display('details'), 'trim');
        $this->form_validation->set_rules('charge_amount', display('ammount'), 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => display('add_shipping_method')
            );
            $content = $this->parser->parse('dashboard/shipping_method/add_shipping_method',$data,true);
            $this->template_lib->full_admin_html_view($content);

        } else {

            $data = array(
                'method_id' => $this->auth->generator(15),
                'position' => $this->input->post('position',TRUE),
                'method_name' => $this->input->post('method_name',TRUE),
                'details' => $this->input->post('details',TRUE),
                'charge_amount' => $this->input->post('charge_amount',TRUE),
            );

            $result = $this->Shipping_methods->shipping_method_entry($data);

            if ($result == TRUE) {

                $this->session->set_userdata(array('message' => display('successfully_added')));

                if (isset($_POST['add-shipping_method'])) {
                    redirect(base_url('dashboard/Cshipping_method/manage_shipping_method'));
                } elseif (isset($_POST['add-shipping_method-another'])) {
                    redirect(base_url('dashboard/Cshipping_method'));
                }

            } else {
                $this->session->set_userdata(array('error_message' => display('already_exists')));
                redirect(base_url('dashboard/Cshipping_method'));
            }
        }
    }

    //Manage shipping_method
    public function manage_shipping_method()
    {
        $this->permission->check_label('shipping_method')->read()->redirect();

        $content =$this->lshipping_method->shipping_method_list();
        $this->template_lib->full_admin_html_view($content);;
    }
    //shipping_method Update Form
    public function shipping_method_update_form($method_id)
    {  
        $this->permission->check_label('shipping_method')->update()->redirect();

        $content = $this->lshipping_method->shipping_method_edit_data($method_id);
        $this->template_lib->full_admin_html_view($content);
    }

    // shipping_method Update
    public function shipping_method_update($method_id = null)
    {
        $this->permission->check_label('shipping_method')->update()->redirect();

        $this->form_validation->set_rules('position', display('position'), 'trim|required');
        $this->form_validation->set_rules('method_name', display('name'), 'trim|required');
        $this->form_validation->set_rules('details', display('details'), 'trim');
        $this->form_validation->set_rules('charge_amount', display('ammount'), 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $content = $this->lshipping_method->shipping_method_edit_data($method_id);
            $this->template_lib->full_admin_html_view($content);

        } else {
            $data = array(
                'position' => $this->input->post('position',TRUE),
                'method_name' => $this->input->post('method_name',TRUE),
                'details' => $this->input->post('details',TRUE),
                'charge_amount' => $this->input->post('charge_amount',TRUE),
            );

            $result = $this->Shipping_methods->update_shipping_method($data, $method_id);

            if ($result == TRUE) {
                $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect('dashboard/Cshipping_method/manage_shipping_method');
            } else {
                $this->session->set_userdata(array('error_message' => display('position_already_exists')));
                redirect('dashboard/Cshipping_method/manage_shipping_method');
            }
        }
    }

    // shipping_method Delete
    public function shipping_method_delete($method_id)
    {
        $this->permission->check_label('shipping_method')->delete()->redirect();

        $result = $this->Shipping_methods->delete_shipping_method($method_id);
        if($result){
            $this->session->set_userdata(array('message' => display('successfully_delete')));
        }else{
            $this->session->set_userdata(array('error_message' => display('failed_try_again')));
        }
        redirect('dashboard/Cshipping_method/manage_shipping_method');
    }

    //Inactive
    public function inactive($id)
    {
        $this->permission->check_label('shipping_method')->update()->redirect();

        $this->db->set('status', 0);
        $this->db->where('shipping_method_id', $id);
        $this->db->update('shipping_method');
        $this->session->set_userdata(array('error_message' => display('successfully_inactive')));
        redirect(base_url('dashboard/Cshipping_method/manage_shipping_method'));
    }

    //Active
    public function active($id)
    {
        $this->permission->check_label('shipping_method')->update()->redirect();

        $this->db->set('status', 1);
        $this->db->where('shipping_method_id', $id);
        $this->db->update('shipping_method');
        $this->session->set_userdata(array('message' => display('successfully_active')));
        redirect(base_url('dashboard/Cshipping_method/manage_shipping_method'));
    }
}