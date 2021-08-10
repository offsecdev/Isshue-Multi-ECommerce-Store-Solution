<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ccurrency extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->auth->check_user_auth();
        $this->load->library('dashboard/lcurrency');
        $this->load->model('dashboard/Currencies');
    }

    //Default loading for currency system.
    public function index()
    {
        $this->permission->check_label('add_currency')->create()->redirect();

        $content = $this->lcurrency->currency_add_form();
        $this->template_lib->full_admin_html_view($content);
    }

    //Insert currency
    public function insert_currency()
    {
        $this->permission->check_label('add_currency')->create()->redirect();

        $this->form_validation->set_rules('currency_name', display('currency_name'), 'trim|required');
        $this->form_validation->set_rules('currency_icon', display('currency_icon'), 'trim|required');
        $this->form_validation->set_rules('currency_position', display('currency_position'), 'trim|required');
        $this->form_validation->set_rules('conversion_rate', display('conversion_rate'), 'trim|required');
        $this->form_validation->set_rules('default_status', display('default_status'), 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => display('add_currency')
            );
            $content = $this->parser->parse('dashboard/currency/add_currency',$data,true);
            $this->template_lib->full_admin_html_view($content);

        } else {

            $data = array(
                'currency_id' => $this->auth->generator(15),
                'currency_name' => $this->input->post('currency_name',TRUE),
                'currency_icon' => $this->input->post('currency_icon',TRUE),
                'currency_position' => $this->input->post('currency_position',TRUE),
                'convertion_rate' => $this->input->post('conversion_rate',TRUE),
                'default_status' => $this->input->post('default_status',TRUE),
            );

            $result = $this->Currencies->currency_entry($data);

            //This code for default status set in session start
            $this->db->select('*');
            $this->db->from('currency_info');
            $this->db->where('default_status', 1);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $ses = $query->row();

                $sess_data = array(
                    'currency_id' => $ses->currency_id,
                    'currency_position' => $ses->currency_position,
                );
                $this->session->unset_userdata('currency_id', 'currency_position');
                $this->session->set_userdata($sess_data);
            } else {
                $this->session->unset_userdata('currency_id', 'currency_position');
            }
            //This code for default status set in session end

            if ($result == TRUE) {

                $this->session->set_userdata(array('message' => display('successfully_added')));

                if (isset($_POST['add-currency'])) {
                    redirect(base_url('dashboard/Ccurrency/manage_currency'));
                } elseif (isset($_POST['add-currency-another'])) {
                    redirect(base_url('dashboard/Ccurrency'));
                }

            } else {
                $this->session->set_userdata(array('error_message' => display('default_status_already_exists')));
                redirect('dashboard/Ccurrency');
            }
        }
    }

   //Manage currency
    public function manage_currency()
    {
        $this->permission->check_label('manage_currency')->read()->redirect();

        $content =$this->lcurrency->currency_list();
        $this->template_lib->full_admin_html_view($content);;
    }
    //Currency Update Form
    public function currency_update_form($currency_id)
    {   
        $this->permission->check_label('manage_currency')->update()->redirect();

        $content = $this->lcurrency->currency_edit_data($currency_id);
        $this->template_lib->full_admin_html_view($content);
    }

    // Currency Update
    public function currency_update($currency_id = null)
    {
        $this->permission->check_label('manage_currency')->update()->redirect();

        $this->form_validation->set_rules('currency_name', display('currency_name'), 'trim|required');
        $this->form_validation->set_rules('currency_icon', display('currency_icon'), 'trim|required');
        $this->form_validation->set_rules('currency_position', display('currency_position'), 'trim|required');
        $this->form_validation->set_rules('conversion_rate', display('conversion_rate'), 'trim|required');
        $this->form_validation->set_rules('default_status', display('default_status'), 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => display('add_currency')
            );
            $content = $this->parser->parse('dashboard/currency/add_currency',$data,true);
            $this->template_lib->full_admin_html_view($content);
        } else {

            $data = array(
                'currency_name' => $this->input->post('currency_name',TRUE),
                'currency_icon' => $this->input->post('currency_icon',TRUE),
                'currency_position' => $this->input->post('currency_position',TRUE),
                'convertion_rate' => $this->input->post('conversion_rate',TRUE),
                'default_status' => $this->input->post('default_status',TRUE),
            );

            $result = $this->Currencies->update_currency($data, $currency_id);

            //This code for default status set in session start
            $this->db->select('*');
            $this->db->from('currency_info');
            $this->db->where('default_status', 1);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $ses = $query->row();

                $sess_data = array(
                    'currency_id' => $ses->currency_id,
                    'currency_position' => $ses->currency_position,
                );
                $this->session->unset_userdata('currency_id', 'currency_position');
                $this->session->set_userdata($sess_data);
            } else {
                $this->session->unset_userdata('currency_id', 'currency_position');
            }
            //This code for default status set in session end

            if ($result == TRUE) {
                $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect('dashboard/Ccurrency/manage_currency');
            } else {
                $this->session->set_userdata(array('error_message' => display('default_status_already_exists')));
                redirect('dashboard/Ccurrency/manage_currency');
            }
        }
    }

    // Currency Delete
    public function currency_delete($currency_id)
    {
        $this->permission->check_label('manage_currency')->delete()->redirect();

        $currency = $this->Currencies->delete_currency($currency_id);

        if ($currency) {
            $this->session->set_userdata(array('message' => display('successfully_delete')));
            redirect('dashboard/Ccurrency/manage_currency');
        } else {
            $this->session->set_userdata(array('error_message' => display('you_cant_delete_this_is_default_currency')));
            redirect('dashboard/Ccurrency/manage_currency');
        }
    }
}