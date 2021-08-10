<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Csms_setting extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('dashboard/lsoft_setting');
        $this->load->model('dashboard/Sms_setting_model');
        $this->auth->check_user_auth();

    }


    //sms Configuration
    public function sms_configuration()
    {
        $this->permission->check_label('sms_configuration')->update()->redirect();

        $content = $this->lsoft_setting->sms_configuration_form();
        $this->template_lib->full_admin_html_view($content);

    }

    //Update sms configuration
    public function update_sms_configuration()
    {
        $this->permission->check_label('sms_configuration')->update()->redirect();

        $status = $this->input->post('status',TRUE);

        $data = array(
            'id' => $this->input->post('id',TRUE),
            'user_name' => $this->input->post('user_name',TRUE),
            'password' => $this->input->post('password',TRUE),
            'sms_from' => $this->input->post('sms_from',TRUE),
            'userid' => $this->input->post('userid',TRUE),
            'status' => $status,
        );

        $this->Sms_setting_model->update_sms_config($data);
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('dashboard/Csms_setting/sms_configuration'));
    }


    /*
|--------------------------------------
|   sms sms_template
|--------------------------------------
*/
    public function sms_template()
    {
        $this->permission->check_label('sms_template')->read()->redirect();

        $data['template'] = $this->Sms_setting_model->template_list();
        $data['title'] = display('sms_template');
        $content = $this->load->view('dashboard/sms/sms_template', $data, true);
        $this->template_lib->full_admin_html_view($content);

    }


    //save sms template
    public function save_sms_template()
    {
        $this->permission->check_label('sms_template')->create()->redirect();

        $data = array(
            'template_name' => $this->input->post('template_name',TRUE),
            'type' => $this->input->post('type',TRUE),
            'message' => $this->input->post('message',TRUE),
        );

        $this->Sms_setting_model->save_sms_template($data);
        $this->session->set_userdata(array('message' => display('successfully_inserted')));
        redirect(base_url('dashboard/Csms_setting/sms_template'));
    }

    //delete template
    public function delete_template($id)
    {
        $this->permission->check_label('sms_template')->delete()->redirect();

        $this->db->where('id', $id)->delete('sms_template');
        $this->session->set_flashdata('message', display('delete_successfully'));
        redirect('dashboard/Csms_setting/sms_template');
    }

    public function template_update()
    {
        $this->permission->check_label('sms_template')->update()->redirect();
        
        $data = array(
            'template_name' => $this->input->post('template_name',TRUE),
            'type' => $this->input->post('type',TRUE),
            'message' => $this->input->post('message',TRUE),
        );
        $this->Sms_setting_model->template_update($data);
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('dashboard/Csms_setting/sms_template'));
    }

    public function set_default_template($id = null, $status = null)
    {
        $this->db->set('default_status', (($status == 1) ? 0 : 1))
            ->where('id', $id)
            ->update('sms_template');
        $this->session->set_flashdata('message', display('successfully_updated'));
        redirect('dashboard/Csms_setting/sms_template');
    }

}