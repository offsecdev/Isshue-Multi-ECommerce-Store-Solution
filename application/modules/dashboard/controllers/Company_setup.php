<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Company_setup extends MX_Controller
{

    public $company_id;

    function __construct()
    {

        $this->load->library('auth');
        $this->load->library('dashboard/lcompany');
        $this->load->library('session');
        $this->load->model('dashboard/Companies');
        $this->auth->check_user_auth();
    }

    #==============Company page load===========#
    public function index()
    {
        $this->manage_company();
    }

    #===============Company Search Item===========#
    public function company_search_item()
    {
        $company_id = $this->input->post('company_id',TRUE);
        $content = $this->lcompany->company_search_item($company_id);
        $this->template_lib->full_admin_html_view($content);
    }

    #================Manage Company==============#
    public function manage_company()
    {
        $this->permission->check_label('manage_company')->read()->redirect();

        $content = $this->lcompany->company_list();
        $this->template_lib->full_admin_html_view($content);
    }

    #===============Company update form================#
    public function company_update_form($company_id)
    {   
        $this->permission->check_label('manage_company')->update()->redirect();

        $content = $this->lcompany->company_edit_data($company_id);
        $this->template_lib->full_admin_html_view($content);
    }

    #===============Company update===================#
    public function company_update()
    {
        $this->permission->check_label('manage_company')->update()->redirect();

        $company_id = $this->input->post('company_id',TRUE);
        $data = array(
            'company_id' => $company_id,
            'company_name' => $this->input->post('company_name',TRUE),
            'email' => $this->input->post('email',TRUE),
            'address' => $this->input->post('address',TRUE),
            'mobile' => $this->input->post('mobile',TRUE),
            'website' => $this->input->post('website',TRUE),
            'status' => 1
        );
        $this->Companies->update_company($data, $company_id);
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('dashboard/Company_setup/manage_company'));
    }
}