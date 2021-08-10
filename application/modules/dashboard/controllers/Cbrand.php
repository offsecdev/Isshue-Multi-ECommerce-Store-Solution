<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cbrand extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('dashboard/lbrand');
        $this->load->model('dashboard/Brands');
        $this->auth->check_user_auth();

    }

    public function index()
    {
        $this->permission->check_label('add_brand')->create()->redirect();

        $content = $this->lbrand->brand_add_form();
        $this->template_lib->full_admin_html_view($content);
    }

    //Insert brand
    public function insert_brand()
    {
        $this->permission->check_label('add_brand')->create()->redirect();

        $this->form_validation->set_rules('brand_name', display('brand_name'), 'trim|required');
        $this->form_validation->set_rules('website', display('website'), 'trim|valid_url');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => display('add_brand')
            );
            $content = $this->parser->parse('brand/add_brand', $data, true);
            $this->template_lib->full_admin_html_view($content);
        } else {
            if ($_FILES['brand_image']['name']) {
                $config['upload_path'] = './my-assets/image/brand_image/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
                $config['max_size'] = "1024";
                $config['max_width'] = "*";
                $config['max_height'] = "*";
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('brand_image')) {
                    $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                    redirect(base_url('dashboard/Cbrand'));
                } else {
                    $image = $this->upload->data();
                    $brand_image = "my-assets/image/brand_image/" . $image['file_name'];
                }
            }

            $data = array(
                'brand_id' => $this->auth->generator(15),
                'brand_name' => $this->input->post('brand_name',TRUE),
                'brand_image' => (!empty($brand_image) ? $brand_image : null),
                'website' => $this->input->post('website',TRUE),
                'status' => 1
            );

            $result = $this->Brands->brand_entry($data);

            if ($result == TRUE) {

                $this->session->set_userdata(array('message' => display('successfully_added')));

                if (isset($_POST['add-brand'])) {
                    redirect(base_url('dashboard/Cbrand/manage_brand'));
                } elseif (isset($_POST['add-brand-another'])) {
                    redirect(base_url('dashboard/Cbrand'));
                }

            } else {
                $this->session->set_userdata(array('error_message' => display('already_inserted')));
                redirect(base_url('dashboard/Cbrand'));
            }
        }
    }

    //Manage Brand
    public function manage_brand()
    {
        $this->permission->check_label('manage_brand')->read()->redirect();

        $content =$this->lbrand->brand_list();
        $this->template_lib->full_admin_html_view($content);;
    }
    //Brand Update Form
    public function brand_update_form($brand_id)
    {   
        $this->permission->check_label('manage_brand')->update()->redirect();

        $content = $this->lbrand->brand_edit_data($brand_id);
        $this->template_lib->full_admin_html_view($content);
    }

    // Brand Update
    public function brand_update($brand_id = null)
    {
        $this->permission->check_label('manage_brand')->update()->redirect();

        $this->form_validation->set_rules('brand_name', display('brand_name'), 'trim|required');
        $this->form_validation->set_rules('website', display('website'), 'trim|valid_url');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => display('manage_brand')
            );
            $content = $this->parser->parse('brand/manage_brand', $data, true);
            $this->template_lib->full_admin_html_view($content);
        } else {
            if ($_FILES['brand_image']['name']) {

                $config['upload_path'] = './my-assets/image/brand_image/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
                $config['max_size'] = "1024";
                $config['max_width'] = "*";
                $config['max_height'] = "*";
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('brand_image')) {
                    $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                    redirect(base_url('dashboard/Cbrand'));
                } else {
                    $image = $this->upload->data();
                    $brand_image = "my-assets/image/brand_image/" . $image['file_name'];
                }
            }
            $old_image = $this->input->post('old_image',TRUE);

            $data = array(
                'brand_id' => $brand_id,
                'brand_name' => $this->input->post('brand_name',TRUE),
                'brand_image' => (!empty($brand_image) ? $brand_image : $old_image),
                'website' => $this->input->post('website',TRUE),
                'status' => $this->input->post('status',TRUE),
            );

            $result = $this->Brands->update_brand($data, $brand_id);

            if ($result == TRUE) {
                $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect('dashboard/Cbrand/manage_brand');
            } else {
                $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect('dashboard/Cbrand/manage_brand');
            }
        }
    }


    // Brand Delete
    public function brand_delete($brand_id)
    {
        $this->permission->check_label('manage_brand')->delete()->redirect();

        $this->Brands->delete_brand($brand_id);
        $this->session->set_userdata(array('message' => display('successfully_delete')));
        redirect('dashboard/Cbrand/manage_brand');
    }
}