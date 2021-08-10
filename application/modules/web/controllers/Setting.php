<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('web/Settings');
        $this->load->library('web/Lsetting');

    }

    //Default loading for Setting Index.
    public function index()
    {
        $content = $this->lsetting->setting_page();
        $this->template_lib->full_website_html_view($content);
    }       

    //About us
    public function about_us()
    {
        $content = $this->lsetting->about_us('1');
        $this->template_lib->full_website_html_view($content);
    }   

    //Delivery info us
    public function delivery_info()
    {
        $content = $this->lsetting->delivery_info('3');
        $this->template_lib->full_website_html_view($content);
    }   

    //Privacy info us
    public function privacy_policy()
    {
        $content = $this->lsetting->privacy_policy('4');
        $this->template_lib->full_website_html_view($content);
    }   

    //Terms and conditon
    public function terms_condition()
    {
        $content = $this->lsetting->terms_condition('5');
        $this->template_lib->full_website_html_view($content);
    }       

    //Help
    public function help()
    {
        $content = $this->lsetting->help('6');
        $this->template_lib->full_website_html_view($content);
    }       

    //Contact Us
    public function contact_us()
    {
        $content = $this->lsetting->contact_us();
        $this->template_lib->full_website_html_view($content);
    }   

    //Submit Contact Us
    public function submit_contact()
    {

        $this->form_validation->set_rules('first_name', display('first_name'), 'trim|required');
        $this->form_validation->set_rules('last_name', display('last_name'), 'trim|required');
        $this->form_validation->set_rules('email', display('email'), 'trim|required');
        $this->form_validation->set_rules('message', display('details'), 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_userdata(array('error_message' => validation_errors()));
            redirect('contact_us');
        } else {

            $data = array(
                'id' => $this->auth->generator(15),
                'first_name' => $this->input->post('first_name',TRUE),
                'last_name' => $this->input->post('last_name',TRUE),
                'email' => $this->input->post('email',TRUE),
                'message' => $this->input->post('message',FALSE),
            );

            $result = $this->Settings->submit_contact($data);

            if ($result == TRUE) {
                $this->session->set_userdata(array('message' => display('successfully_added')));
                redirect(base_url('contact_us'));
            } else {
                $this->session->set_userdata(array('error_message' => display('already_exists')));
                redirect(base_url('contact_us'));
            }
        }
    }

    //Default loading for Setting Details.
    public function setting_details($p_id)
    {
        $content = $this->lsetting->setting_details($p_id);
        $this->template_lib->full_website_html_view($content);
    }


    //Submit a subscriber.
    public function add_subscribe()
    {
        $data = array(
            'subscriber_id' => $this->generator(15),
            'apply_ip' => $this->input->ip_address(),
            'email' => $this->input->post('sub_email',TRUE),
            'status' => 1
        );

        $result = $this->Subscribers->subscriber_entry($data);

        if ($result) {
            echo "2";
        } else {
            echo "3";
        }
    }

    //This function is used to Generate Key
    public function generator($lenth)
    {
        $number = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "N", "M", "O", "P", "Q", "R", "S", "U", "V", "T", "W", "X", "Y", "Z", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

        for ($i = 0; $i < $lenth; $i++) {
            $rand_value = rand(0, 34);
            $rand_number = $number["$rand_value"];

            if (empty($con)) {
                $con = $rand_number;
            } else {
                $con = "$con" . "$rand_number";
            }
        }
        return $con;
    }
}