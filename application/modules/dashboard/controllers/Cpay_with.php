<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cpay_with extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->auth->check_user_auth();
        $this->load->library('dashboard/lpay_with');
        $this->load->model('dashboard/pay_withs');
    }

    //show all item list 
    public function index()
    {
        $this->permission->check_label('manage_pay_with')->read()->redirect();
        $content = $this->lpay_with->pay_with_list();       
        $this->template_lib->full_admin_html_view($content);
    }


    //insert pay with image in to  the database
    public function create()
    {
        $this->permission->check_label('manage_pay_with')->create()->redirect();

        $this->form_validation->set_rules('title', display('title'), 'required');
        if(empty($_FILES['image']['name'])){

            $this->form_validation->set_rules('image', display('image'), 'required');
        }
        if($this->form_validation->run() == TRUE){
            if ($_FILES['image']['name']) {
                $config['upload_path'] = './my-assets/image/pay_with/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
                $config['max_size'] = "1024";
                $config['max_width'] = "*";
                $config['max_height'] = "*";
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('image')) {
                    $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                    redirect(base_url('dashboard/Cpay_with'));
                } else {
                    $image = $this->upload->data();
                    $pay_with_image = $image['file_name'];
                }
            }

            $data = array(
                'title' => $this->input->post('title',TRUE),
                'image' => $pay_with_image,
                'link' => $this->input->post('link',TRUE),
                'status' => $this->input->post('status',TRUE)
            );

            $result = $this->db->insert('pay_withs', $data);

            if ($result == TRUE) {
                $this->session->set_userdata(array('message' => display('successfully_added')));
                return redirect('dashboard/Cpay_with');
            }


        }
        $content = $this->lpay_with->pay_with_add_form();
        $this->template_lib->full_admin_html_view($content);
        
    }


    public function edit($id)
    {
        $this->permission->check_label('manage_pay_with')->update()->redirect();

        $this->form_validation->set_rules('title', display('title'), 'required');
        if(empty($_FILES['image']['name']) && empty($this->input->post('old_image'))) {

            $this->form_validation->set_rules('image', display('image'), 'required');
        }
        if($this->form_validation->run() == TRUE){

            if ($_FILES['image']['name']) {
                $config['upload_path'] = './my-assets/image/pay_with/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
                $config['max_size'] = "1024";
                $config['max_width'] = "*";
                $config['max_height'] = "*";
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('image')) {
                    $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                    redirect(base_url('dashboard/Cpay_with'));
                } else {
                    $image = $this->upload->data();
                    $image = $image['file_name'];
                }
            }
            $old_image = $this->input->post('old_image',TRUE);

            $data = array(
                'title' => $this->input->post('title',TRUE),
                'image' => (!empty($image) ? $image : $old_image),
                'link' => $this->input->post('link',TRUE),
                'status' => $this->input->post('status',TRUE)
            );

            $result = $this->pay_withs->update($data, $id);
            if (!empty($image)) {
                unlink(FCPATH . "my-assets/image/pay_with/" . $old_image);//delete current image
            }
            if ($result == TRUE) {
                $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect('dashboard/Cpay_with');
            }
        }
        $content = $this->lpay_with->pay_with_edit_form($id);
        $this->template_lib->full_admin_html_view($content);

    }


    public function delete($id)
    {
        $this->permission->check_label('manage_pay_with')->delete()->redirect();

        $this->pay_withs->delete($id);
        $this->session->set_userdata(array('message' => display('successfully_delete')));
        redirect('dashboard/Cpay_with');
    }

}