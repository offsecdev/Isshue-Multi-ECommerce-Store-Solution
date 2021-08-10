<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Seo_tools extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('dashboard/lweb_setting');
        $this->load->model(array('dashboard/web_settings'));
        $this->auth->check_user_auth();

    }

    //Default loading for Category system.
    public function index()
    {
        $this->permission->check_label('role')->seo_tools()->redirect();

        $content = $this->lweb_setting->setting();
        $this->template_lib->full_admin_html_view($content);
    }

     //Popular Products
    public function popular_products()
    {
        $this->permission->check_label('popular_products')->read()->redirect();

        $this->form_validation->set_rules('google_analytics', display('google_analytics'), 'trim|required');

        if($this->form_validation->run() == TRUE)
        {
            $update_sett = array(
                'google_analytics'=> $this->input->post('google_analytics', FALSE)
            );
            $result = $this->db->update('web_setting', $update_sett, array('setting_id' => 1));
            if($result){
                $this->session->set_userdata('message' , display('successfully_updated'));
            }else{
                $this->session->set_userdata('error_message' , display('failed_try_again'));
            }
        }

        $web_settings = $this->web_settings->setting();
        $popular_products = $this->web_settings->get_popular_products();
        $data=array(
            'title'      => display('popular_products'),
            'web_settings'   =>$web_settings,
            'popular_products'   =>$popular_products
        );
        $data['module'] = 'dashboard';
        $data['page'] = 'web_seo_tools/popular_products';
        echo Modules::run('template/layout', $data);
    } 


    //Google Analytics
    public function google_analytics()
    {
        $this->permission->check_label('google_analytics')->read()->redirect();

        $this->form_validation->set_rules('google_analytics', display('google_analytics'), 'trim|required');

        if($this->form_validation->run() == TRUE)
        {
            $update_sett = array(
                'google_analytics'=> $this->input->post('google_analytics', FALSE)
            );
            $result = $this->db->update('web_setting', $update_sett, array('setting_id' => 1));
            if($result){
                $this->session->set_userdata('message' , display('successfully_updated'));
            }else{
                $this->session->set_userdata('error_message' , display('failed_try_again'));
            }
        }

        $meta_setting = $this->web_settings->setting();
        $data=array(
            'title'      => display('google_analytics'),
            'meta_setting'   =>$meta_setting
        );
        $data['module'] = 'dashboard';
        $data['page'] = 'web_seo_tools/google_analytics';
        echo Modules::run('template/layout', $data);
    } 

    //Webiste Meta information
    public function website_meta_keywords()
    {
        $this->permission->check_label('website_meta_keywords')->read()->redirect();

        $this->form_validation->set_rules('meta_keywords', display('meta_keywords'), 'trim|required');
        $this->form_validation->set_rules('meta_description', display('meta_description'), 'trim|required');

        if($this->form_validation->run() == TRUE)
        {
            $update_sett = array(
                'meta_keyword'=> $this->input->post('meta_keywords', TRUE),
                'meta_description'=> $this->input->post('meta_description', TRUE)
            );
            $result = $this->db->update('web_setting', $update_sett, array('setting_id' => 1));
            if($result){
                $this->session->set_userdata('message' , display('successfully_updated'));
            }else{
                $this->session->set_userdata('error_message' , display('failed_try_again'));
            }
        }

        $meta_setting = $this->web_settings->setting();
        $data=array(
            'title'      => display('website_meta_keywords'),
            'meta_setting'   =>$meta_setting
        );
        $data['module'] = 'dashboard';
        $data['page'] = 'web_seo_tools/meta_keywords';
        echo Modules::run('template/layout', $data);
    }

}