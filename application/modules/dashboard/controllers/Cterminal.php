<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cterminal extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('lterminal');
        $this->load->model('Terminals');
        $this->auth->check_user_auth();
    }

    //Default loading for terminal system.
    public function index()
    {
        $content = $this->lterminal->terminal_add_form();
        $this->template_lib->full_admin_html_view($content);
    }

    //Insert terminal
    public function insert_terminal()
    {

        $this->form_validation->set_rules('terminal_name', display('terminal_name'), 'trim|required');
        $this->form_validation->set_rules('terminal_company', display('terminal_company'), 'trim|required');
        $this->form_validation->set_rules('terminal_bank_account', display('terminal_bank_account'), 'trim|required');
        $this->form_validation->set_rules('customer_care_phone_no', display('customer_care_phone_no'), 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => display('add_terminal')
            );
            $content = $this->parser->parse('terminal/add_terminal', $data, true);
            $this->template_lib->full_admin_html_view($content);
        } else {
            $data = array(
                'pay_terminal_id' => $this->auth->generator(15),
                'terminal_name' => $this->input->post('terminal_name',TRUE),
                'terminal_provider_company' => $this->input->post('terminal_company',TRUE),
                'linked_bank_account_no' => $this->input->post('terminal_bank_account',TRUE),
                'customer_care_phone_no' => $this->input->post('customer_care_phone_no',TRUE),
            );

            $result = $this->Terminals->terminal_entry($data);

            if ($result == TRUE) {

                $this->session->set_userdata(array('message' => display('successfully_added')));

                if (isset($_POST['add-terminal'])) {
                    redirect(base_url('Cterminal/manage_terminal'));
                } elseif (isset($_POST['add-terminal-another'])) {
                    redirect(base_url('Cterminal'));
                }

            } else {
                $this->session->set_userdata(array('error_message' => display('already_inserted')));
                redirect(base_url('Cterminal'));
            }
        }
    }

    //Manage terminal
    public function manage_terminal()
    {
        $content = $this->lterminal->terminal_list();
        $this->template_lib->full_admin_html_view($content);;
    }

    //terminal Update Form
    public function terminal_update_form($terminal_id)
    {
        $content = $this->lterminal->terminal_edit_data($terminal_id);
        $this->menu = array('label' => 'Edit terminal', 'url' => 'Ccustomer');
        $this->template_lib->full_admin_html_view($content);
    }

    // terminal Update
    public function terminal_update($terminal_id = null)
    {

        $this->form_validation->set_rules('terminal_name', display('terminal_name'), 'trim|required');
        $this->form_validation->set_rules('terminal_company', display('terminal_company'), 'trim|required');
        $this->form_validation->set_rules('terminal_bank_account', display('terminal_bank_account'), 'trim|required');
        $this->form_validation->set_rules('customer_care_phone_no', display('customer_care_phone_no'), 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => display('manage_terminal')
            );
            $content = $this->parser->parse('terminal/manage_terminal', $data, true);
            $this->template_lib->full_admin_html_view($content);
        } else {

            $data = array(
                'terminal_name' => $this->input->post('terminal_name',TRUE),
                'terminal_provider_company' => $this->input->post('terminal_company',TRUE),
                'linked_bank_account_no' => $this->input->post('terminal_bank_account',TRUE),
                'customer_care_phone_no' => $this->input->post('customer_care_phone_no',TRUE),
            );

            $result = $this->Terminals->update_terminal($data, $terminal_id);

            if ($result == TRUE) {
                $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect('Cterminal/manage_terminal');
            } else {
                $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect('Cterminal/manage_terminal');
            }
        }
    }

    // terminal Delete
    public function terminal_delete($terminal_id)
    {
        $this->Terminals->delete_terminal($terminal_id);
        $this->session->set_userdata(array('message' => display('successfully_delete')));
        redirect('Cterminal/manage_terminal');
    }
}