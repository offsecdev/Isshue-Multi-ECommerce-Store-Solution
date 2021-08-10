<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Csoft_setting extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('dashboard/lsoft_setting');

        $this->load->model(array(
            'dashboard/Soft_settings',
            'dashboard/Color_frontends',
            'dashboard/Color_backends',
        ));
        $this->auth->check_user_auth();
    }

    //Default loading for Category system.
    public function index()
    {
        $this->permission->check_label('software_settings')->update()->redirect();

        $content = $this->lsoft_setting->setting_add_form();
        $this->template_lib->full_admin_html_view($content);
    }


    // Setting Update
    public function update_setting()
    {
        $this->permission->check_label('software_settings')->update()->redirect();

        $captcha =  $this->input->post('captcha',TRUE);


        if ($_FILES['logo']['name']) {
            $config['upload_path'] = 'my-assets/image/logo/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
            $config['max_size'] = "1024";
            $config['max_width'] = "*";
            $config['max_height'] = "*";
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('logo')) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                redirect(base_url('dashboard/Csoft_setting'));
            } else {
                $image = $this->upload->data();
                $logo = "my-assets/image/logo/" . $image['file_name'];
            }
        }

        if ($_FILES['favicon']['name']) {
            $config['upload_path'] = 'my-assets/image/logo/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
            $config['max_size'] = "1024";
            $config['max_width'] = "*";
            $config['max_height'] = "*";
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('favicon')) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                redirect(base_url('dashboard/Csoft_setting'));
            } else {
                $image = $this->upload->data();
                $favicon = "my-assets/image/logo/" . $image['file_name'];
            }
        }

        if ($_FILES['invoice_logo']['name']) {
            $config['upload_path'] = 'my-assets/image/logo/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
            $config['max_size'] = "1024";
            $config['max_width'] = "*";
            $config['max_height'] = "*";
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('invoice_logo')) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                redirect(base_url('dashboard/Csoft_setting'));
            } else {
                $image = $this->upload->data();
                $invoice_logo = "my-assets/image/logo/" . $image['file_name'];
            }
        }

        $old_logo = $this->input->post('old_logo',TRUE);
        $old_invoice_logo = $this->input->post('old_invoice_logo',TRUE);
        $old_favicon = $this->input->post('old_favicon',TRUE);

        $language = $this->input->post('language',TRUE);
        $this->session->set_userdata('language', $language);

        $data = array(
            'logo' => (!empty($logo) ? $logo : $old_logo),
            'invoice_logo' => (!empty($invoice_logo) ? $invoice_logo : $old_invoice_logo),
            'favicon' => (!empty($favicon) ? $favicon : $old_favicon),
            'footer_text' => $this->input->post('footer_text',TRUE),
            'language' => $language,
            'rtr' => $this->input->post('rtr',TRUE),
            'captcha' => $captcha,
            'sms_service' => $this->input->post('sms_service',TRUE),
            'country_id' => $this->input->post('country',TRUE)
        );

        $this->Soft_settings->update_setting($data);
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('dashboard/Csoft_setting'));
    }

    
    //Email Configuration
    public function email_configuration(){
        $this->permission->check_label('email_configuration')->read()->redirect();
        $content = $this->lsoft_setting->email_configuration_form();
        $this->template_lib->full_admin_html_view($content);
    }

    //Update email configuration
    public function update_email_configuration()
    {
        $this->permission->check_label('email_configuration')->update()->redirect();
        $data = array(
            'protocol' => $this->input->post('protocol',TRUE),
            'mailtype' => $this->input->post('mailtype',TRUE),
            'smtp_host' => $this->input->post('smtp_host',TRUE),
            'smtp_port' => $this->input->post('smtp_port',TRUE),
            'sender_email' => $this->input->post('sender_email',TRUE),
            'password' => $this->input->post('password',TRUE),
        );

        $this->Soft_settings->update_email_config($data);
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('dashboard/Csoft_setting/email_configuration'));
    }

    // Send Test Email
    public function send_test_email()
    {
        $this->permission->check_label('email_configuration')->update()->redirect();

        $this->form_validation->set_rules('receiver_email', display('receiver_email'), 'trim|required|valid_email');
        if($this->form_validation->run() == TRUE) {

            $setting_detail = $this->Soft_settings->retrieve_email_editdata();

            $subject = "Test Email";
            $message = "This is a Test email!";
            $email = $this->input->post('receiver_email', TRUE);

            $config = array(
                'protocol' => $setting_detail[0]['protocol'],
                'smtp_host' => $setting_detail[0]['smtp_host'],
                'smtp_port' => $setting_detail[0]['smtp_port'],
                'smtp_user' => $setting_detail[0]['sender_email'],
                'smtp_pass' => $setting_detail[0]['password'],
                'mailtype' => $setting_detail[0]['mailtype'],
                'charset' => 'utf-8',
                'newline'   => "\r\n"
            );

            $this->load->library('email');
            $this->email->initialize($config);

            $this->email->from($setting_detail[0]['sender_email']);
            $this->email->to($email);
            $this->email->subject($subject);
            $this->email->message($message);

            if ($this->email->send()) {
                $this->session->set_userdata(array('message' => 'Email Sent successfully'));
            } else {
                $this->session->set_userdata(array('error_message' => 'Failed! Please enter valid email configuration and try again<br>'.$this->email->print_debugger()));
            }

        } 
        redirect('dashboard/Csoft_setting/email_configuration');

    }

    //Payment Configuration
    public function payment_gateway_setting(){
        $this->permission->check_label('payment_gateway_setting')->read()->redirect();

        $content = $this->lsoft_setting->payment_configuration_form();
        $this->template_lib->full_admin_html_view($content);
    }


    //Update payment configuration
    public function update_payment_gateway_setting($id = null)
    {
        $this->permission->check_label('payment_gateway_setting')->update()->redirect();

        if ($id == 3) {
            $data = array(
                'public_key' => $this->input->post('public_key',TRUE),
                'private_key' => $this->input->post('private_key',TRUE),
                'status' => $this->input->post('status',TRUE),
            );

            $this->Soft_settings->update_payment_gateway_setting_new($data, $id);
        }else if ($id == 4) {
            $data = array(
                'shop_id' => $this->input->post('shop_id',TRUE),
                'secret_key' => $this->input->post('secret_key',TRUE),
                'status' => $this->input->post('status',TRUE),
            );
            $this->Soft_settings->update_payment_gateway_setting_new($data, $id);
        } else if ($id == 5) {
            $data = array(
                'paypal_email' => $this->input->post('paypal_email',TRUE),
                'paypal_client_id' => $this->input->post('client_id',TRUE),
                'currency' => $this->input->post('currency',TRUE),
                'is_live' => $this->input->post('is_live',TRUE),
                'status' => $this->input->post('status',TRUE),
            );

            $this->Soft_settings->update_payment_gateway_setting_new($data, $id);
        } else if ($id == 6) {
            $data = array(
                'paypal_email' => $this->input->post('sslcommerz_email',TRUE),
                'shop_id' => $this->input->post('store_id',TRUE),
                'secret_key' => $this->input->post('secret_key',TRUE),
                'currency' => $this->input->post('currency',TRUE),
                'is_live' => $this->input->post('is_live',TRUE),
                'status' => $this->input->post('status',TRUE),
            );

            $this->Soft_settings->update_payment_gateway_setting_new($data, $id);
        }else{

            $data = array(
                'paypal_email' => $this->input->post('business_email',TRUE),
                'public_key' => $this->input->post('public_key',TRUE),
                'private_key' => $this->input->post('private_key',TRUE),
                'currency' => $this->input->post('currency',TRUE),
                'is_live' => $this->input->post('is_live',TRUE),
                'status' => $this->input->post('status',TRUE),
            );

            $this->Soft_settings->update_payment_gateway_setting_new($data, $id);
        }

        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('dashboard/Csoft_setting/payment_gateway_setting'));
    }

    //shwo fronted template color edit form
    public function color_setting_frontend()
    {
        $this->permission->check_label('color_setting_frontend')->update()->redirect();

        $content = $this->lsoft_setting->color_frontend_edit_form();
        $this->template_lib->full_admin_html_view($content);
    }
    //update fronend templete color
    public function update_frontend_color()
    {
        $this->permission->check_label('color_setting_frontend')->update()->redirect();

        $theme_name = $this->input->post('theme_name',TRUE);
        $data =
            [
                'color1' => $this->input->post('color1',TRUE),
                'color2' => $this->input->post('color2',TRUE),
                'color3' => $this->input->post('color3',TRUE),
                'color4' => $this->input->post('color4',TRUE),
                'color5' => $this->input->post('color5',TRUE),
            ];

        $result = $this->Color_frontends->update_color($data, $theme_name);
        if ($result) {
            $this->session->set_userdata(array('message' => display('successfully_updated')));
        }else{
            $this->session->set_userdata(array('error_message' => display('failed_try_again')));
        }
        redirect(base_url('dashboard/Csoft_setting/color_setting_frontend'));
    }
     //show backend template color edit form
    public function color_setting_backend()
    {
        $this->permission->check_label('color_setting_backend')->update()->redirect();

        $content = $this->lsoft_setting->color_backend_edit_form();
        $this->template_lib->full_admin_html_view($content);
    }

    // Get theme frontend color
    public function ajax_theme_color(){
        $this->load->model('dashboard/Color_frontends');
        $theme_name = $this->input->post('theme_name', TRUE);
        $theme_name = (!empty($theme_name)?$theme_name:'default');
        $colors = $this->Color_frontends->retrieve_color_editdata($theme_name);
        $data = array(          
            'color1'        => $colors->color1,
            'color2'        => $colors->color2,
            'color3'        => $colors->color3,         
            'color4'        => $colors->color4,         
            'color5'        => $colors->color5     
        );
        echo json_encode($data);

    }

    public function update_backend_color()
    {
        $this->permission->check_label('color_setting_backend')->update()->redirect();
        
        $data =
            [
                'color1' => $this->input->post('color1',TRUE),
                'color2' => $this->input->post('color2',TRUE),
                'color3' => $this->input->post('color3',TRUE),
                'color4' => $this->input->post('color4',TRUE),
                'color5' => $this->input->post('color5',TRUE),
            ];

        $result = $this->Color_backends->update_color($data);
        if ($result) {
            $this->session->set_userdata(array('message' => display('successfully_updated')));
            redirect(base_url('dashboard/Csoft_setting/color_setting_backend'));
        }
    }


    public function import_database()
    {
        $data = array(
            'title' => display('import_database')
        );
        $content = $this->parser->parse('dashboard/soft_setting/import_database_form',$data,true);
        $this->template_lib->full_admin_html_view($content);
    }


    /**
     *
     */
    public function import_database_data()
    {
        $hostname = $this->db->hostname;
        $username = $this->db->username;
        $password = $this->db->password;
        $database = $this->db->database;
        @$mysqli = new \mysqli(
            $hostname,
            $username,
            $password,
            $database
        );

        // Check for errors
        if (mysqli_connect_errno()) {
            echo 'fail to connect';
            return false;
        }


        if ($_FILES['import_database']['name']) {
            $config['upload_path'] = 'my-assets/db/';
            $config['allowed_types'] = '*';
            $config['max_size'] = "*";
            $config['max_width'] = "*";
            $config['max_height'] = "*";
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('import_database')) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                redirect(base_url('dashboard/Csoft_setting/import_database'));
            } else {
                $file = $this->upload->data();
                $file_url = base_url() . "my-assets/db/" . $file['file_name'];
            }
        }

        $tables = $this->db->list_tables();

        foreach ($tables as $table) {

            $this->db->truncate($table);
        }
        $templine = '';
        // Read in entire file
        $lines = file($file_url);
        foreach ($lines as $line) {
            // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || $line == '')
                continue;

            // Add this line to the current templine we are creating
            $templine .= $line;

            // If it has a semicolon at the end, it's the end of the query so can process this templine
            if (substr(trim($line), -1, 1) == ';') {
                // Perform the query
                $result = $this->db->query($templine);
                // Reset temp variable to empty
                $templine = '';
            }
        }
        if ($result) {
            unlink(getcwd() . "/my-assets/db/" . $file['file_name']);
        }
        $this->session->set_userdata(array('message' => 'Successfully Imported '));
        redirect($_SERVER['HTTP_REFERER']);
    }

}