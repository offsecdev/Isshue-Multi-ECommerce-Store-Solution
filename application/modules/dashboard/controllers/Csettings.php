<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Csettings extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('dashboard/lsettings');
        $this->load->library('auth');
        $this->load->library('dashboard/session');
        $this->load->model('dashboard/Settings');
        $this->auth->check_user_auth();
        $this->template_lib->current_menu = 'settings';

    }

    public function index()
    {
        $this->permission->check_label('add_new_bank')->create()->redirect();

        $data=array('title'=> display('add_new_bank'));
        $content = $this->parser->parse('dashboard/settings/new_bank',$data,true);
        $this->template_lib->full_admin_html_view($content);
    }


    #================Add new bank==============#
    public function add_new_bank()
    {
        $this->permission->check_label('add_new_bank')->create()->redirect();

        $data = array(
            'bank_id' => $this->auth->generator(10),
            'bank_name' => $this->input->post('bank_name',TRUE),
            'ac_name' => $this->input->post('ac_name',TRUE),
            'branch' => $this->input->post('branch',TRUE),
            'ac_number' => $this->input->post('ac_number',TRUE),
            'status' => 0
        );
        $invoice_id = $this->Settings->bank_entry($data);
        $this->session->set_userdata(array('message' => display('successfully_added')));

        if (isset($_POST['add-bank'])) {
            redirect(base_url('dashboard/Csettings/bank_list'));
        } elseif (isset($_POST['add-bank-another'])) {
            redirect(base_url('dashboard/Csettings'));
        }
    }

    #==============Bank list============#
    public function bank_list()
    {
        $this->permission->check_label('manage_bank')->read()->redirect();

        $content = $this->lsettings->bank_list( );
        $this->template_lib->full_admin_html_view($content);
    }
    #=============Bank edit==============#
    public function edit_bank($bank_id)
    {
        $this->permission->check_label('manage_bank')->update()->redirect();

        $content = $this->lsettings->bank_show_by_id($bank_id);
        $this->template_lib->full_admin_html_view($content);
    }
    #============Update Bank=============#
    public function update_bank($bank_id)
    {
        $this->permission->check_label('manage_bank')->update()->redirect();

        $bank_list = $this->Settings->bank_update_by_id($bank_id);
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect('dashboard/Csettings/bank_list');
    }
}