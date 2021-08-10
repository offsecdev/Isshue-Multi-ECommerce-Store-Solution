<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cweb_setting extends MX_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->auth->check_user_auth();
        $this->load->library('dashboard/lweb_setting');
        $this->load->model(array('dashboard/web_settings'));

    }

    //Default loading for Category system.
    public function index()
    {
        
        $this->permission->check_label('web_settings')->update()->redirect();
        $content = $this->lweb_setting->setting();
        $this->template_lib->full_admin_html_view($content);
    }

    //Default loading for Category system.
    public function contact()
    {
        $this->permission->check_label('contact_form')->create()->redirect();

        $content = $this->lweb_setting->contact_form();
        $this->template_lib->full_admin_html_view($content);
    }

    //Submit contact form
    public function submit_contact_form()
    {
        $this->permission->check_label('contact_form')->create()->redirect();

        $data = array(
            'first_name' => $this->input->post('first_name',TRUE),
            'last_name' => $this->input->post('last_name',TRUE),
            'email' => $this->input->post('email',TRUE),
            'message' => $this->input->post('message',TRUE),
        );

        $this->web_settings->submit_contact_form($data);

        $this->session->set_userdata(array('message' => display('successfully_inserted')));
        redirect(base_url('dashboard/Cweb_setting/manage_contact_form'));
    }

    //Manage contact form 
    public function manage_contact_form()
    {
        $this->permission->check_label('contact_form')->update()->redirect();

        $content = $this->lweb_setting->manage_contact_form();
        $this->template_lib->full_admin_html_view($content);
    }

    //Update contact form
    public function contact_update_form($id)
    {
        $this->permission->check_label('contact_form')->update()->redirect();

        $content = $this->lweb_setting->contact_update_form($id);
        $this->template_lib->full_admin_html_view($content);
    }


    //Update contact form
    public function update_contact_form($id)
    {
        $this->permission->check_label('contact_form')->update()->redirect();

        $data = array(
            'first_name' => $this->input->post('first_name',TRUE),
            'last_name' => $this->input->post('last_name',TRUE),
            'email' => $this->input->post('email',TRUE),
            'message' => $this->input->post('message',TRUE),
        );

        $this->web_settings->update_contact_form($id, $data);

        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('dashboard/Cweb_setting/manage_contact_form'));
    }

    // Contact Delete
    public function contact_delete($id)
    {
        $this->permission->check_label('contact_form')->delete()->redirect();

        $this->web_settings->delete_contact($id);
        $this->session->set_userdata(array('message' => display('successfully_delete')));
        redirect('dashboard/Cweb_setting/manage_contact_form');
    }

    //Setting 
    public function setting()
    {
        $this->permission->check_label('setting')->update()->redirect();

        $content = $this->lweb_setting->setting();
        $this->template_lib->full_admin_html_view($content);
    }

    //Update social link
    public function update_web_settings($id)
    {   
        $this->permission->check_label('web_settings')->update()->redirect();

        $this->load->model('web_settings');
        $setting = $this->web_settings->setting();

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
                redirect(base_url('dashboard/Cweb_setting'));
            } else {
                $image = $this->upload->data();
                $logo = "my-assets/image/logo/" . $image['file_name'];
                if (!empty($setting[0]['logo'])) {
                    unlink(FCPATH . $setting[0]['logo']);//delete present image
                }
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
                redirect(base_url('dashboard/Cweb_setting'));
            } else {
                $image = $this->upload->data();
                $favicon = "my-assets/image/logo/" . $image['file_name'];
                unlink(FCPATH . $setting[0]['favicon']);
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
                redirect(base_url('dashboard/Cweb_setting'));
            } else {
                $image = $this->upload->data();
                $invoice_logo = "my-assets/image/logo/" . $image['file_name'];
                unlink(FCPATH . $setting[0]['invoice_logo']);
            }
        }

        if ($_FILES['footer_logo']['name']) {
            $config['upload_path'] = 'my-assets/image/logo/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
            $config['max_size'] = "1024";
            $config['max_width'] = "*";
            $config['max_height'] = "*";
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('footer_logo')) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                redirect(base_url('dashboard/Cweb_setting'));
            } else {
                $image = $this->upload->data();
                $footer_logo = "my-assets/image/logo/" . $image['file_name'];
                unlink(FCPATH . $setting[0]['footer_logo']);
            }
        }

        $old_logo = $this->input->post('old_logo',TRUE);
        $old_invoice_logo = $this->input->post('old_invoice_logo',TRUE);
        $old_favicon = $this->input->post('old_favicon',TRUE);
        $old_footer_logo = $this->input->post('old_footer_logo',TRUE);

        $mob_footer = array(
            $this->input->post('footer_block_1',TRUE),
            $this->input->post('footer_block_2',TRUE),
            $this->input->post('footer_block_3',TRUE),
            $this->input->post('footer_block_4',TRUE)
        );

        $data = array(
            'logo' => (!empty($logo) ? $logo : $old_logo),
            'invoice_logo' => (!empty($invoice_logo) ? $invoice_logo : $old_invoice_logo),
            'favicon' => (!empty($favicon) ? $favicon : $old_favicon),
            'footer_logo' => (!empty($footer_logo) ? $footer_logo : $old_footer_logo),
            'footer_text' => $this->input->post('footer_text',TRUE),
            'footer_details' => $this->input->post('footer_details',TRUE),
            'google_analytics' => htmlspecialchars($this->input->post('google_analytics', false)),
            'facebook_messenger' => htmlspecialchars($this->input->post('facebook_messenger', false)),
            'meta_keyword' => $this->input->post('meta_keyword',TRUE),
            'meta_description' => $this->input->post('meta_description',TRUE),
            'app_link_status' => $this->input->post('app_link_status',TRUE),
            'pay_with_status' => $this->input->post('pay_with',TRUE),
            'map_api_key' => $this->input->post('map_api_key',TRUE),
            'map_latitude' => $this->input->post('map_latitude',TRUE),
            'map_langitude' => $this->input->post('map_langitude',TRUE),
            'mob_footer_block' => json_encode($mob_footer),
            'social_share' => $this->input->post('social_share',TRUE)
        );

        $result = $this->web_settings->update_web_settings($id, $data);

        if($result){
             $this->session->set_userdata(array('message' => display('successfully_updated')));
        }else{
             $this->session->set_userdata(array('error_message' => display('failed_try_again')));
        }
        redirect(base_url('dashboard/Cweb_setting/setting'));
    }

   //Add Slider 
    public function add_slider()
    {
        $this->permission->check_label('slider')->create()->redirect();

        $content = $this->lweb_setting->add_slider();
        $this->template_lib->full_admin_html_view($content);
    }

    //Insert slider
    public function submit_slider()
    {
        $this->permission->check_label('slider')->create()->redirect();

        $this->form_validation->set_rules('slider_link', display('slider_link'), 'trim|required');
        $this->form_validation->set_rules('slider_position', display('slider_position'), 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => display('add_slider')
            );
            $content = $this->parser->parse('dashboard/web_setting/add_slider',$data,true);
            $this->template_lib->full_admin_html_view($content);
        } else {


            //Slider image
            if ($_FILES['slider_image']['name']) {

                $config['upload_path'] = 'my-assets/image/slider/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
                $config['max_size'] = "1024";
                $config['max_width'] = "*";
                $config['max_height'] = "*";
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('slider_image')) {
                    $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                    redirect('dashboard/Cweb_setting/add_slider');
                } else {
                    $image = $this->upload->data();
                    $image_url = "my-assets/image/slider/" . $image['file_name'];
                }
            }

            $data = array(
                'slider_id' => $this->auth->generator(15),
                'slider_link' => $this->input->post('slider_link',TRUE),
                'slider_image' => $image_url,
                'slider_position' => $this->input->post('slider_position',TRUE),
                'slider_category' => $this->input->post('slider_category',TRUE),
                'status' => 1,
            );

            $result = $this->web_settings->slider_entry($data);

            if ($result) {

                $this->session->set_userdata(array('message' => display('successfully_added')));

                if (isset($_POST['add-slider'])) {
                    redirect('dashboard/Cweb_setting/manage_slider');
                } elseif (isset($_POST['add-slider-another'])) {
                    redirect('dashboard/Cweb_setting/add_slider');
                }
            } else {
                $this->session->set_userdata(array('error_message' => display('failed_try_again')));
                redirect('dashboard/Cweb_setting/add_slider');
            }
        }
    }

    //Manage Slider
    public function manage_slider()
    {
        $this->permission->check_label('slider')->read()->redirect();

        $content =$this->lweb_setting->slider_list();
        $this->template_lib->full_admin_html_view($content);
    }

    //Slider Update Form
    public function slider_update_form($slider_id)
    {   
        $this->permission->check_label('slider')->update()->redirect();

        $content = $this->lweb_setting->slider_edit_data($slider_id);
        $this->template_lib->full_admin_html_view($content);
    }

    // Slider Update
    public function update_slider($slider_id = null)
    {
        $this->permission->check_label('slider')->update()->redirect();

        $this->form_validation->set_rules('slider_link', display('slider_link'), 'trim|required');
        $this->form_validation->set_rules('slider_position', display('slider_position'), 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => display('manage_slider')
            );
            $content = $this->parser->parse('dashboard/web_setting/slider', $data, true);
            $this->template_lib->full_admin_html_view($content);
        } else {

            if (!empty($_FILES['slider_image']['name'])) {
                //Chapter chapter add start
                $config['upload_path'] = 'my-assets/image/slider/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
                $config['max_size'] = "1024";
                $config['max_width'] = "*";
                $config['max_height'] = "*";
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('slider_image')) {
                    $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                    redirect('dashboard/Cweb_setting/manage_slider');
                } else {
                    $image = $this->upload->data();
                    $image_url = "my-assets/image/slider/" . $image['file_name'];
                }
            }

            $old_image = $this->input->post('old_image',TRUE);
            $data = array(
                'slider_link' => $this->input->post('slider_link',TRUE),
                'slider_position' => $this->input->post('slider_position',TRUE),
                'slider_image' => (!empty($image_url) ? $image_url : $old_image),
                'slider_category' => $this->input->post('slider_category',TRUE)
            );

            $result = $this->web_settings->update_slider($data, $slider_id);

            if ($result == TRUE) {

                $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect(base_url('dashboard/Cweb_setting/manage_slider'));
            } else {
                $this->session->set_userdata(array('error_message' => display('failed_try_again')));
                redirect('dashboard/Cweb_setting/manage_slider');
            }
        }
    }

    //Inactive slider
    public function inactive($slider_id)
    {
        $this->permission->check_label('slider')->update()->redirect();

        $this->db->set('status', 0);
        $this->db->where('slider_id', $slider_id);
        $this->db->update('slider');
        $this->session->set_userdata(array('error_message' => display('successfully_inactive')));
        redirect(base_url('dashboard/Cweb_setting/manage_slider'));
    }

    //Active slider
    public function active($slider_id)
    {
        $this->permission->check_label('slider')->update()->redirect();

        $this->db->set('status', 1);
        $this->db->where('slider_id', $slider_id);
        $this->db->update('slider');
        $this->session->set_userdata(array('message' => display('successfully_active')));
        redirect(base_url('dashboard/Cweb_setting/manage_slider'));
    }

    //Delete slider
    public function slider_delete($slider_id)
    {
        $this->permission->check_label('slider')->delete()->redirect();

        $sliderinfo = $this->db->where('slider_id', $slider_id)->get('slider')->row();
        $this->db->where('slider_id', $slider_id);
        $result = $this->db->delete('slider');
        if($result){
            unlink(@$sliderinfo->slider_image);
            $this->session->set_userdata(array('message' => display('successfully_delete')));
        }else{
            $this->session->set_userdata(array('error_message' => display('failed_try_again')));
        }
        redirect(base_url('dashboard/Cweb_setting/manage_slider'));
    }

    #----------------Submit Add------------#
    public function submit_add()
    {
        $this->permission->check_label('advertisement')->create()->redirect();

        $this->form_validation->set_rules('add_page', display('add_page'), 'trim|required');
        $this->form_validation->set_rules('ads_position', display('ads_position'), 'trim|required');
        $this->form_validation->set_rules('ad_type', display('add_type'), 'trim|required');

        if ($this->form_validation->run() == FALSE):
            $data = array(
                'title' => display('add_advertise')
            );
            $content = $this->parser->parse('dashboard/web_setting/submit_add',$data,true);
            $this->template_lib->full_admin_html_view($content); 

        else:

            $ad_type = $this->input->post('ad_type',TRUE);
            if ($ad_type == 1):
                $data['adv_code'] = $this->input->post('add_code',FALSE);
                $data['adv_code2'] = $this->input->post('add_code2',FALSE);
                $data['adv_code3'] = $this->input->post('add_code3',FALSE);
            else:
                $data['adv_code'] = null;
                $data['adv_code2'] = null;
                $data['adv_code3'] = null;
                $data['image'] = null;
                $data['image2'] = null;
                $data['image3'] = null;
            endif;

            if ($ad_type == 2):
                //============================================
                // configure for upload
                $config = array(
                    'upload_path' => "my-assets/image/add/",
                    'allowed_types' => "gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG",
                    'overwrite' => TRUE,
                    'file_size' => '2048',
                    'encrypt_name' => true
                );
                $image_name = '';
                $image_data = array();
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('add_image')) {
                    $image_data = $this->upload->data();
                    $image_name = $image_data['file_name'];
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $image_data['full_path']; //get original image
                    $config['maintain_ratio'] = TRUE;
                    $config['height'] = '*';
                    $config['width'] = '*';
                    $this->load->library('image_lib', $config);
                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    if (!$this->image_lib->resize()) {
                        echo $this->image_lib->display_errors();
                    }
                    $filepath = base_url($config['upload_path'] . $image_name);
                    $data['adv_url'] = $add_url = $this->input->post('add_url',TRUE);
                    $data['adv_code'] = "<a href=\"$add_url\" target=\"_blank\"><img src=\"$filepath\" alt=\"image\" class=\"img-responsive\"></a>";
                    $data['image'] = $image_name;
                } else {
                    $image_name = '';
                }
                //            ========= its for file upload 2 =========
                if ($this->upload->do_upload('add_image2')) {
                    $image_dataTwo = $this->upload->data();
                    $file_upload_2 = $image_dataTwo['file_name'];
                    $filepath2 = base_url($config['upload_path'] . $file_upload_2);
                    $data['adv_url2'] = $add_url2 = $this->input->post('add_url2',TRUE);
                    $data['adv_code2'] = "<a href=\"$add_url2\" target=\"_blank\"><img src=\"$filepath2\" alt=\"\" class=\"img-responsive\"></a>";
                    $data['image2'] = $file_upload_2;
                } else {
                    $file_upload_2 = '';
                }
                //            ========= its for file upload 3 =========
                if ($this->upload->do_upload('add_image3')) {
                    $image_dataThree = $this->upload->data();
                    $file_upload_3 = $image_dataThree['file_name'];
                    $filepath3 = base_url($config['upload_path'] . $file_upload_3);
                    $data['adv_url3'] = $add_url3 = $this->input->post('add_url3',TRUE);
                    $data['adv_code3'] = "<a href=\"$add_url3\" target=\"_blank\"><img src=\"$filepath3\" alt=\"\" class=\"img-responsive\"></a>";
                    $data['image3'] = $file_upload_3;
                } else {
                    $file_upload_3 = '';

                }

            endif;

            $data['adv_id'] = $this->auth->generator(15);
            $data['add_page'] = $this->input->post('add_page',TRUE);
            $data['adv_position'] = $this->input->post('ads_position',TRUE);
            $data['adv_type'] = $this->input->post('ad_type',TRUE);
            $data['status'] = 1;
            $result = $this->web_settings->insert_add($data);
            if ($result == TRUE):
                $this->session->set_userdata(array('message' => display('successfully_added')));
                redirect('dashboard/Cweb_setting/manage_add');
            elseif ($result == FALSE):
                $this->session->set_userdata(array('error_message' => display('ads_position_already_exists')));
                redirect('dashboard/Cweb_setting/submit_add');
            endif;
        endif;
    }

    #----------------Manage Add--------------------#
    public function manage_add(){
        $this->permission->check_label('advertisement')->read()->redirect();

        $content =$this->lweb_setting->add_list();
        $this->template_lib->full_admin_html_view($content);
    }
    #---------------Edit User----------#
    public function edit_add_form($id){
        $this->permission->check_label('advertisement')->update()->redirect();

        $content = $this->lweb_setting->add_edit_data($id);
        $this->template_lib->full_admin_html_view($content);
    }


    #--------------Update Add---------------#
    public function update_add($id)
    {

        $this->permission->check_label('advertisement')->update()->redirect();

        $this->form_validation->set_rules('add_page', display('add_page'), 'trim|required');
        $this->form_validation->set_rules('ads_position', display('ads_position'), 'trim|required');
        $this->form_validation->set_rules('ad_type', display('add_type'), 'trim|required');

        if ($this->form_validation->run() == FALSE) {

            redirect('dashboard/Cweb_setting/edit_add_form/'.$id);

        } else {

            $ad_type = $this->input->post('ad_type',TRUE);
            $data['adv_code'] = $this->input->post('add_code');

            if ($ad_type == 2) {
                if (($_FILES['add_image']['name'])) {
                    $data = array();
                    $config['upload_path'] = 'my-assets/image/add/';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
                    $config['max_size'] = '100000';
                    $config['width'] = 10000;
                    $config['height'] = 10000;
                    $config['overwrite'] = FALSE;
                    $config['encrypt_name'] = true;
                    $this->upload->initialize($config);
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('add_image')) {
                        $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                        redirect('dashboard/Cweb_setting/manage_add');
                    } else {
                        $view = $this->upload->data();
                        $filepath = base_url($config['upload_path'] . $view['file_name']);
                        $data['adv_url'] = $add_url = $this->input->post('add_url',TRUE);
                        $data['adv_code'] = "<a href=\"$add_url\" target=\"_blank\"><img src=\"$filepath\" class=\"img-responsive\" alt=\"\"></a>";
                    }
                }
            }

            $data['adv_id'] = $this->auth->generator(15);
            $data['add_page'] = $this->input->post('add_page',TRUE);
            $data['adv_position'] = $this->input->post('ads_position',TRUE);
            $data['adv_type'] = $this->input->post('ad_type',TRUE);

            $result = $this->web_settings->update_add($data, $id);

            if ($result) {
                $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect('dashboard/Cweb_setting/manage_add');
            } else {
                $this->session->set_userdata(array('error_message' => display('failed_try_again')));
                redirect('dashboard/Cweb_setting/manage_add');
            }
        }
    }


    #=====Delete Advertisement======#
    public function delete_add($id)
    {
        $this->permission->check_label('advertisement')->delete()->redirect();

        $advinfo = $this->db->where('adv_id', $id)->get('advertisement')->row();
        $this->db->where('adv_id', $id);
        $result = $this->db->delete('advertisement');
        if($result){
            if(!empty($advinfo->image)) {
                unlink('my-assets/image/add/'.$advinfo->image);
            }
            if(!empty($advinfo->image2)){
                unlink('my-assets/image/add/'.$advinfo->image2);
            }
            if(!empty($advinfo->image3)){
                unlink('my-assets/image/add/'.$advinfo->image3);
            }
            $this->session->set_userdata(array('message' => display('successfully_delete')));
        }
        redirect('dashboard/Cweb_setting/manage_add');
    }


    //Inactive advertisement
    public function inactive_add($id)
    {
        $this->permission->check_label('advertisement')->update()->redirect();

        $this->db->set('status', 0);
        $this->db->where('adv_id', $id);
        $this->db->update('advertisement');
        $this->session->set_userdata(array('error_message' => display('successfully_inactive')));
        redirect(base_url('dashboard/Cweb_setting/manage_add'));
    }


    //Active advertisement
    public function active_add($id)
    {
        $this->permission->check_label('advertisement')->update()->redirect();

        $this->db->set('status', 1);
        $this->db->where('adv_id', $id);
        $this->db->update('advertisement');
        $this->session->set_userdata(array('message' => display('successfully_active')));
        redirect(base_url('dashboard/Cweb_setting/manage_add'));
    }


    public function android_apps_view()
    {
        $this->permission->check_label('android_apps')->read()->redirect();

        $content = $this->lweb_setting->android_apps_view();
        $this->template_lib->full_admin_html_view($content);
    }

    public function update_android_apps_update()
    {
        $this->permission->check_label('android_apps')->update()->redirect();

        $url = $this->input->post('apps_url');
        $data=['apps_url'=>$url];
        $this->db->update('web_setting',$data);
        return redirect('dashboard/Cweb_setting/android_apps_view');
    }
}