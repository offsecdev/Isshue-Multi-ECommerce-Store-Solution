<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('web/customer/Lsignup');
        $this->load->model('web/customer/Signups');
        $this->load->model('dashboard/Subscribers');
        $this->load->model('web/Homes');
        $this->load->model('dashboard/web_settings');
        $this->load->model('dashboard/Soft_settings');
        $this->load->model('dashboard/Blocks');
        $this->load->model('dashboard/themes');
        $this->load->model('dashboard/color_frontends');
        $this->load->model('dashboard/Orders');
        $this->load->model('template/Template_model');
        $this->load->model('dashboard/companies');
        $this->load->model('dashboard/pay_withs');
    }

    //Default loading for Home Index.
    public function index()
    {
        if ($this->user_auth->is_logged()) {
            $this->output->set_header("Location: " . base_url('customer/customer_dashboard'), TRUE, 302);
        }

        $parent_category_list = $this->Homes->parent_category_list();
        $pro_category_list = $this->Homes->category_list();
        $best_sales = $this->Signups->best_sales();
        $footer_block = $this->Signups->footer_block();
        $slider_list = $this->web_settings->slider_list();
        $block_list = $this->Blocks->block_list();
        $currency_details = $this->Soft_settings->retrieve_currency_info();

        $Soft_settings = $this->Soft_settings->retrieve_setting_editdata();
        $languages = $this->Homes->languages();
        $currency_info = $this->Homes->currency_info();
        $selected_currency_info = $this->Homes->selected_currency_info();

        $data = array(
            'title' => display('sign_up'),
            'category_list' => $parent_category_list,
            'pro_category_list' => $pro_category_list,
            'slider_list' => $slider_list,
            'block_list' => $block_list,
            'best_sales' => $best_sales,
            'footer_block' => $footer_block,
            'Soft_settings' => $Soft_settings,
            'languages' => $languages,
            'currency_info' => $currency_info,
            'selected_cur_id' => (($selected_currency_info->currency_id) ? $selected_currency_info->currency_id : ""),
            'currency' => $currency_details[0]['currency_icon'],
            'position' => $currency_details[0]['currency_position'],
        );

        $data['theme'] = $this->themes->get_theme(); //return only name

        $signup_page = APPPATH.'modules/web/views/themes/'.$data['theme'].'/signup.php';
        if(file_exists($signup_page)){
            $content = $this->parser->parse('web/themes/'.$data['theme'].'/signup',$data,true);
            $this->template_lib->full_website_html_view($content);
        }else{

            $data['colors'] = $this->color_frontends->retrieve_color_editdata();
            $data['company_info'] = $this->companies->company_list();
            $data['Web_settings'] = $this->web_settings->retrieve_setting_editdata();
            $data['pay_withs'] = $this->pay_withs->pay_with_list_for_homepage();
            $data['module'] = "web";
            $data['page'] = "customer/signup";
            $this->load->view('themes/' . $data['theme'] . '/website_html_template', $data);
        }
    }

    //Submit a user signup.
    public function user_signup()
    {
        $this->form_validation->set_rules('first_name', display('first_name'), 'trim|required');
        $this->form_validation->set_rules('email', display('email'), 'trim|required|is_unique[customer_information.customer_email]');
        $this->form_validation->set_rules('phone', display('phone'), 'trim|required');
        $this->form_validation->set_rules('password', display('password'), 'trim|required');

        if($this->form_validation->run() == TRUE){
            $data = array(
                'customer_id' => $this->generator(15),
                'first_name' => $this->input->post('first_name',TRUE),
                'last_name' => $this->input->post('last_name',TRUE),
                'customer_name' => $this->input->post('first_name',TRUE) . ' ' . $this->input->post('last_name',TRUE),
                'customer_email' => $this->input->post('email',TRUE),
                'customer_mobile' => $this->input->post('phone',TRUE),
                'image' => 'assets/dist/img/user.png',
                'password' => md5("gef" . $this->input->post('password',TRUE)),
                'status' => 1
            );

            $result = $this->Signups->user_signup($data);
            if ($result) {

                $this->session->set_userdata(array(
                    'message' => display('you_have_successfully_signup'),
                    'customer_email' => $this->input->post('email',TRUE),
                ));

                $email = $this->input->post('email',TRUE);
                $password = $this->input->post('password',TRUE);
                $login = $this->user_auth->login($email, $password);
                redirect('customer/customer_dashboard');
                
            } else {
                $this->session->set_userdata(array('error_message' => display('you_have_not_sign_up')));
            }
        }

        $this->index();
        
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


    public function check_existing_user()
    {
        $user_email = $this->input->post('user_email',TRUE);
        $result = $this->db->select('customer_email')->from('customer_information')->where('customer_email', $user_email)->get()->result();
        if (!empty($result)) {
            echo 1;
        } else {
            echo 2;
        }
    }
}