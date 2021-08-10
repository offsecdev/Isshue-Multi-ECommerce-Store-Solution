<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ctax extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('dashboard/ltax');
        $this->load->model('dashboard/Taxs');
        $this->auth->check_user_auth();
    }

    //Default loading for tax system.
    public function index()
    {
        $this->permission->check_label('tax_product_service')->create()->redirect();
        $data = array(
            'title' => display('add_tax')
        );
        $content = $this->parser->parse('dashboard/tax/tax_product_service',$data,true);
        $this->template_lib->full_admin_html_view($content);
    }

    //Insert tax product service
    public function insert_tax_product_service()
    {
         $this->permission->check_label('manage_product_tax')->create()->redirect();

        $this->form_validation->set_rules('tax_id', display('tax_name'), 'trim|required');
        $this->form_validation->set_rules('product_id', display('product_name'), 'trim|required');
        $this->form_validation->set_rules('tax_percentage', display('tax_percentage'), 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => display('add_tax')
            );
            $content = $this->parser->parse('dashboard/tax/tax_product_service',$data,true);
            $this->template_lib->full_admin_html_view($content);
        } else {
            $data = array(
                't_p_s_id' => $this->auth->generator(15),
                'product_id' => $this->input->post('product_id',TRUE),
                'tax_id' => $this->input->post('tax_id',TRUE),
                'tax_percentage' => $this->input->post('tax_percentage',TRUE),
            );

            $result = $this->Taxs->tax_product_entry($data);

            if ($result == TRUE) {

                $this->session->set_userdata(array('message' => display('successfully_added')));
                if (isset($_POST['add-tax'])) {
                    redirect(('dashboard/Ctax/manage_tax'));
                } elseif (isset($_POST['add-tax-another'])) {
                    redirect(('dashboard/Ctax/tax_product_service'));
                }

            } else {
                $this->session->set_userdata(array('error_message' => display('already_inserted')));
                redirect(('dashboard/Ctax/tax_product_service'));
            }
        }
    }

    //Manage tax
    public function manage_tax()
    {
        $this->permission->check_label('manage_product_tax')->read()->redirect();

        $content =$this->ltax->tax_list();
        $this->template_lib->full_admin_html_view($content);
    }
    //tax Update Form
    public function tax_product_update_form($tax_id)
    {
        $this->permission->check_label('manage_product_tax')->update()->redirect();

        $content = $this->ltax->tax_product_update_form($tax_id);
        $this->template_lib->full_admin_html_view($content);
    }


    // tax Update
    public function tax_update($t_p_s_id = null)
    {
        $this->permission->check_label('manage_product_tax')->update()->redirect();

        $this->form_validation->set_rules('tax_id', display('tax_name'), 'trim|required');
        $this->form_validation->set_rules('product_id', display('product_name'), 'trim|required');
        $this->form_validation->set_rules('tax_percentage', display('tax_percentage'), 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => display('add_tax')
            );
            $content = $this->parser->parse('dashboard/tax/add_tax',$data,true);
            $this->template_lib->full_admin_html_view($content);
        } else {

            $data = array(
                'product_id' => $this->input->post('product_id',TRUE),
                'tax_id' => $this->input->post('tax_id',TRUE),
                'tax_percentage' => $this->input->post('tax_percentage',TRUE),
            );

            $result = $this->Taxs->tax_product_update($data, $t_p_s_id);

            if ($result == TRUE) {
                $this->session->set_userdata(array('message' => display('successfully_added')));
                redirect('dashboard/Ctax/manage_tax');
            } else {
                $this->session->set_userdata(array('error_message' => display('already_inserted')));
                redirect(('dashboard/Ctax/tax_product_service'));
            }
        }
    }


    //Tax product service
    public function tax_product_service(){
        $this->permission->check_label('manage_product_tax')->read()->redirect();

        $content =$this->ltax->tax_product_service();
        $this->template_lib->full_admin_html_view($content);
    }

    // tax Delete
    public function tax_delete($t_p_s_id)
    {
        $this->permission->check_label('manage_product_tax')->delete()->redirect();

        $this->Taxs->delete_tax($t_p_s_id);
        $this->session->set_userdata(array('message' => display('successfully_delete')));
        redirect('dashboard/Ctax/manage_tax');
    }

    //Tax setting
    public function tax_setting(){
        
        $this->permission->check_label('tax_setting')->read()->redirect();

        $content =$this->ltax->tax_setting();
        $this->template_lib->full_admin_html_view($content);
    }

    //Tax inactive
    public function inactive_tax()
    {
        $this->permission->check_label('tax_setting')->read()->redirect();

        $tax_id = $this->input->post('tax_id',TRUE);
        $tax_name = $this->input->post('tax_name',TRUE);

        $tax_inactive = $this->db->set('tax_name', $tax_name)
            ->set('status', 0)
            ->where('tax_id', $tax_id)
            ->update('tax');

        if ($tax_inactive) {
            echo "1";
        }
    }

    //Tax active
    public function active_tax()
    {
        $this->permission->check_label('tax_setting')->read()->redirect();

        $tax_id = $this->input->post('tax_id',TRUE);
        $tax_name = $this->input->post('tax_name',TRUE);

        $tax_active = $this->db->set('tax_name', $tax_name)
            ->set('status', 1)
            ->where('tax_id', $tax_id)
            ->update('tax');

        if ($tax_active) {
            echo "1";
        }
    }

    //Tax update
    public function update_tax()
    {
        $this->permission->check_label('tax_setting')->read()->redirect();
        
        $tax_id = $this->input->post('id',TRUE);
        $tax_name = $this->input->post('value',TRUE);

        $result = $this->db->set('tax_name', $tax_name)
            ->where('tax_id', $tax_id)
            ->update('tax');

        if ($result) {
            echo $tax_name;
        }
    }
}