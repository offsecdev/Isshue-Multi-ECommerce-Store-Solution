<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_auth extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array(
            'dashboard/auth_model', 'dashboard/Soft_settings'
        ));

        $this->load->helper('captcha');
        $this->load->helper('security');
    }


    public function index()
    {


        if ($this->session->userdata('isLogIn'))
            redirect('Admin_dashboard');

        $settings = $this->Soft_settings->retrieve_setting_editdata();


        #-------------------------------------#
        $this->form_validation->set_rules('email', display('email'), 'trim|required|valid_email');
        $this->form_validation->set_rules('password', display('password'), 'trim|required');

        #-------------------------------------#
        if ($this->form_validation->run() == TRUE) {

            if($settings[0]['captcha']){

                $newCaptcha = $this->input->post('captcha', TRUE);
                $oldCaptcha = $this->session->userdata('captcha');
                if ($newCaptcha !== $oldCaptcha) {
                    $this->session->set_userdata(array('error_message' => display('please_enter_valid_captcha')));
                    redirect('admin');
                }

                $this->session->unset_userdata('captcha');
            }


            $username = $this->input->post('email',TRUE);
            $password = $this->input->post('password',TRUE);

            if ($username == '' || $password == '' || $this->auth->login($username, $password) === FALSE) {
                $error = display('wrong_username_or_password');
            }
            if ($error != '') {
                $this->session->set_userdata(array('error_message' => $error));
                $this->output->set_header("Location: " . base_url() . 'admin', TRUE, 302);
            } else {
                redirect('Admin_dashboard');
            }


        } else {

            if($settings[0]['captcha']){

                $captcha = create_captcha(array(
                    'img_path' => './assets/img/captcha/',
                    'img_url' => base_url('assets/img/captcha/'),
                    'font_path' => './assets/fonts/captcha.ttf',
                    'img_width' => '328',
                    'img_height' => 64,
                    'expiration' => 7200,
                    'word_length' => 4,
                    'font_size' => 36,
                    'img_id' => 'Imageid',
                    'pool' => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
                    // White background and border, black text and red grid
                    'colors' => array(
                        'background' => array(255, 255, 255),
                        'border' => array(228, 229, 231),
                        'text' => array(49, 141, 1),
                        'grid' => array(241, 243, 246)
                    )
                ));

                $data['captcha_word'] = @$captcha['word'];
                $data['captcha_image'] = @$captcha['image'];
                $this->session->set_userdata('captcha', $captcha['word']);

            }


            $data['title'] = display('login');
            echo Modules::run('template/login', $data);
        }
    }


    #==============Valid user check=======#
    public function do_login()
    {

        $error = '';
        $setting_detail = $this->Soft_settings->retrieve_setting_editdata();

        if (($setting_detail[0]['captcha'] == 0) && (!empty($setting_detail[0]['secret_key'])) && (!empty($setting_detail[0]['site_key']))) {
            $this->form_validation->set_rules('g-recaptcha-response', 'recaptcha validation', 'required|callback_validate_captcha');
            $this->form_validation->set_message('validate_captcha', 'Please check the captcha form');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_userdata(array('error_message' => display('please_enter_valid_captcha')));
                $this->output->set_header("Location: " . base_url() . 'admin', TRUE, 302);
            } else {
                $username = $this->input->post('username',TRUE);
                $password = $this->input->post('password',TRUE);

                if ($username == '' || $password == '' || $this->auth->login($username, $password) === FALSE) {
                    $error = display('wrong_username_or_password');
                }
                if ($error != '') {
                    $this->session->set_userdata(array('error_message' => $error));
                    $this->output->set_header("Location: " . base_url() . 'admin', TRUE, 302);
                } else {
                    $this->output->set_header("Location: " . base_url('admin'), TRUE, 302);
                }
            }
        } else {
            $username = $this->input->post('email',TRUE);
            $password = $this->input->post('password',TRUE);

            if ($username == '' || $password == '' || $this->auth->login($username, $password) === FALSE) {

                $error = display('wrong_username_or_password');
            }
            if ($error != '') {
                $this->session->set_userdata(array('error_message' => $error));
                $this->output->set_header("Location: " . base_url() . 'admin', TRUE, 302);
            } else {
                redirect('Admin_dashboard');
            }
        }
    }

    //Valid captcha check
    function validate_captcha()
    {
        $setting_detail = $this->Soft_settings->retrieve_setting_editdata();
        $captcha = $this->input->post('g-recaptcha-response',TRUE);
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $setting_detail[0]['secret_key'] . ".&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
        if ($response . 'success' == false) {
            return FALSE;
        } else {
            return TRUE;
        }
    }




    public function logout()
    {
        //update database status
        $this->auth_model->last_logout();
        //destroy session
        $this->session->sess_destroy();
        redirect('admin');
    }


    //Check for logged in user is Admin or not.
    public function is_admin()
    {

        if ($this->session->userdata('user_type') == 1 || $this->session->userdata('user_type') == 2) {
            return true;
        }
        return false;
    }

    //Check for logged in user is Admin or not.
    public function is_store()
    {
        if ($this->session->userdata('user_type') == 4) {
            return true;
        }
        return false;
    }

    //Check admin auth
    function check_admin_auth($url = '')
    {
        if ($url == '') {
            $url = base_url() . 'admin';
        }
        if ((!$this->is_logged()) || (!$this->is_admin())) {
            $this->logout();
            $error = display('you_are_not_authorised');
            $this->session->set_userdata(array('error_message' => $error));
            redirect($url, 'refresh');
            exit;
        }
    }

    //Check store auth
    function check_store_auth($url = '')
    {
        if ($url == '') {
            $url = base_url() . 'admin';
        }
        if ((!$this->is_logged()) || (!$this->is_store())) {
            $this->logout();
            $error = display('you_are_not_authorised');
            $this->session->set_userdata(array('error_message' => $error));
            redirect($url, 'refresh');
            exit;
        }
    }

    //Check admin and store auth
    function check_admin_store_auth($url = '')
    {
        if ($url == '') {
            $url = base_url() . 'admin';
        }
        if ((!$this->is_logged()) && (!$this->is_admin()) && (!$this->is_store())) {
            $this->logout();
            $error = display('you_are_not_authorised');
            $this->session->set_userdata(array('error_message' => $error));
            redirect($url, 'refresh');
            exit;
        } else {
            return true;
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
