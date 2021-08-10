<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cgallery extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('dashboard/lgallery');
        $this->load->model('dashboard/Galleries');

    }


    //Default loading for image system.
    public function index()
    {
        $this->permission->check_label('add_product_image')->create()->redirect();

        $content = $this->lgallery->image_add_form();
        $this->template_lib->full_admin_html_view($content);
    }

    //Insert image
    public function insert_image()
    {
        $this->permission->check_label('add_product_image')->create()->redirect();


        $this->form_validation->set_rules('product_id', display('product_name'), 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {

            if ($_FILES['image']['name']) {
                $config['upload_path'] = './my-assets/image/gallery/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
                $config['max_size'] = "1024";
                $config['max_width'] = "*";
                $config['max_height'] = "*";
                $config['encrypt_name'] = TRUE;

                $this->upload->initialize($config);
                if (!$this->upload->do_upload('image')) {
                    $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                    redirect(base_url('dashboard/Cgallery'));
                } else {
                    $image = $this->upload->data();
                    $image_image = "my-assets/image/gallery/" . $image['file_name'];

                    //Resize image config
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $image['full_path'];
                    $config['maintain_ratio'] = FALSE;
                    $config['width'] = 400;
                    $config['height'] = 400;
                    $config['new_image'] = 'my-assets/image/gallery/thumb/' . $image['file_name'];
                    $this->upload->initialize($config);
                    $this->load->library('image_lib', $config);
                    $resize = $this->image_lib->resize();
                    //Resize image config

                    $thumb_image = $config['new_image'];
                }
            }

            $data = array(
                'image_gallery_id' => $this->auth->generator(15),
                'product_id' => $this->input->post('product_id',TRUE),
                'image_url' => (!empty($image_image) ? $image_image : null),
                'img_thumb' => (!empty($thumb_image) ? $thumb_image : null),
            );

            $result = $this->Galleries->image_entry($data);

            if ($result == TRUE) {

                $this->session->set_userdata(array('message' => display('successfully_added')));

                if (isset($_POST['add-image'])) {
                    redirect(base_url('dashboard/Cgallery/manage_image'));
                } elseif (isset($_POST['add-image-another'])) {
                    redirect(base_url('dashboard/Cgallery'));
                }

            } else {
                $this->session->set_userdata(array('error_message' => display('already_inserted')));
                redirect(base_url('dashboard/Cgallery'));
            }
        }
    }

    //Manage image
    public function manage_image()
    {
        $this->permission->check_label('manage_product_image')->read()->redirect();

        $content =$this->lgallery->image_list();
        $this->template_lib->full_admin_html_view($content);;
    }
    //image Update Form
    public function image_update_form($image_id)
    {   
        $this->permission->check_label('manage_product_image')->update()->redirect();

        $content = $this->lgallery->image_edit_data($image_id);
        $this->template_lib->full_admin_html_view($content);
    }

    // image Update
    public function image_update($image_id = null)
    {
        $this->permission->check_label('manage_product_image')->update()->redirect();

        $this->form_validation->set_rules('product_id', display('product_name'), 'trim|required');

        if ($this->form_validation->run() == FALSE) {
           $data = array(
                'title' => display('manage_image')
            );
            $content = $this->parser->parse('dashboard/image/manage_image',$data,true);
            $this->template_lib->full_admin_html_view($content);
        } else {
            if ($_FILES['image']['name']) {

                $config['upload_path'] = './my-assets/image/gallery/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
                $config['max_size'] = "1024";
                $config['max_width'] = "*";
                $config['max_height'] = "*";
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('image')) {
                    $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                    redirect(base_url('dashboard/Cgallery'));
                } else {
                    $image = $this->upload->data();
                    $image_image = "my-assets/image/gallery/" . $image['file_name'];

                    //Resize image config
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $image['full_path'];
                    $config['maintain_ratio'] = FALSE;
                    $config['width'] = 400;
                    $config['height'] = 400;
                    $config['new_image'] = 'my-assets/image/gallery/thumb/' . $image['file_name'];
                    $this->upload->initialize($config);
                    $this->load->library('image_lib', $config);
                    $resize = $this->image_lib->resize();
                    //Resize image config
                    $thumb_image = $config['new_image'];

                    //Old image delete
                    $old_image = $this->input->post('old_image',TRUE);
                    $old_file = substr($old_image, strrpos($old_image, '/') + 1);
                    @unlink(FCPATH . 'my-assets/image/gallery/' . $old_file);

                    //Thumb image delete
                    $old_img_thumb = $this->input->post('old_img_thumb',TRUE);
                    $old_file_thumb = substr($old_img_thumb, strrpos($old_img_thumb, '/') + 1);
                    @unlink(FCPATH . 'my-assets/image/gallery/thumb/' . $old_file_thumb);
                }
            }

            $old_image = $this->input->post('old_image',TRUE);
            $old_img_thumb = $this->input->post('old_img_thumb',TRUE);

            $data = array(
                'product_id' => $this->input->post('product_id',TRUE),
                'image_url' => (!empty($image_image) ? $image_image : $old_image),
                'img_thumb' => (!empty($thumb_image) ? $thumb_image : $old_img_thumb),
            );

            $result = $this->Galleries->update_image($data, $image_id);

            if ($result == TRUE) {
                $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect('dashboard/Cgallery/manage_image');
            } else {
                $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect('dashboard/Cgallery/manage_image');
            }
        }
    }

    // image Delete
    public function image_delete($image_gallery_id)
    {
        $this->permission->check_label('manage_product_image')->delete()->redirect();

        $this->Galleries->delete_image($image_gallery_id);
        $this->session->set_userdata(array('message' => display('successfully_delete')));
        redirect('dashboard/Cgallery/manage_image');
    }
}