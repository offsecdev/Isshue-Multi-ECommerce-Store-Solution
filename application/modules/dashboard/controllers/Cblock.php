<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cblock extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('dashboard/lblock');
        $this->load->model('dashboard/Blocks');
        $this->auth->check_user_auth();


    }

    //Default loading for block system.
    public function index()
    {
        $this->permission->check_label('block')->read()->redirect();

        $content =$this->lblock->block_list();
        $this->template_lib->full_admin_html_view($content);
    }
    public function block_add()
    {
        $this->permission->check_label('block')->create()->redirect();

        $this->form_validation->set_rules('block_cat_id', display('category'), 'trim|required');
        $this->form_validation->set_rules('block_position', display('block_position'), 'trim|required');
        $this->form_validation->set_rules('block_style', display('block_style'), 'trim|required');

        if ($this->form_validation->run() == TRUE) {

            if ($_FILES['block_image']['name']) {

                $config['upload_path'] = './my-assets/image/block_image/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
                $config['max_size'] = "10024";
                $config['max_width'] = "0";
                $config['max_height'] = "0";
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('block_image')) {
                    $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                    redirect(base_url('dashboard/Cblock/block_add'));
                } else {
                    $image = $this->upload->data();
                    $block_image = "my-assets/image/block_image/" . $image['file_name'];
                }
            }

            $data = array(
                'block_id' => $this->auth->generator(15),
                'block_cat_id' => $this->input->post('block_cat_id',TRUE),
                'block_css' => 'null',
                'block_position' => $this->input->post('block_position',TRUE),
                'block_style' => $this->input->post('block_style'),
                'block_image' => (!empty($block_image) ? $block_image : null),
                'status' => 1
            );

            $result = $this->Blocks->block_entry($data);

            if ($result == TRUE) {

                $this->session->set_userdata(array('message' => display('successfully_added')));

                if (isset($_POST['add-block'])) {
                    redirect(base_url('dashboard/Cblock'));
                } elseif (isset($_POST['add-block-another'])) {
                    redirect(base_url('dashboard/Cblock/block_add'));
                }

            } else {
                $this->session->set_userdata(array('error_message' => display('already_exists')));
            }
        }

        $content = $this->lblock->block_add_form();
        $this->template_lib->full_admin_html_view($content);
    }
    //block Update Form
    public function block_update_form($block_id)
    {   
        $this->permission->check_label('block')->update()->redirect();

        $content = $this->lblock->block_edit_data($block_id);
        $this->template_lib->full_admin_html_view($content);
    }

    // block Update
    public function block_update($block_id = null)
    {
        $this->permission->check_label('block')->update()->redirect();


        $this->form_validation->set_rules('block_cat_id', display('category'), 'trim|required');
        $this->form_validation->set_rules('block_position', display('block_position'), 'trim|required');
        $this->form_validation->set_rules('block_style', display('block_style'), 'trim|required');

        if ($this->form_validation->run() == FALSE) {
           $this->block_update_form($block_id);
        } else {
            if ($_FILES['block_image']['name']) {

                $config['upload_path'] = './my-assets/image/block_image/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
                $config['max_size'] = "10024";
                $config['max_width'] = "0";
                $config['max_height'] = "0";
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('block_image')) {
                    $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                    redirect(base_url('dashboard/Cblock/block_update_form/'.$block_id));
                } else {
                    $image = $this->upload->data();
                    $block_image = "my-assets/image/block_image/" . $image['file_name'];
                }
            }
            $old_image = $this->input->post('old_image',TRUE);

            $data = array(
                'block_id' => $this->auth->generator(15),
                'block_cat_id' => $this->input->post('block_cat_id',TRUE),
                'block_css' => 'null',
                'block_position' => $this->input->post('block_position',TRUE),
                'block_style' => $this->input->post('block_style'),
                'block_image' => (!empty($block_image) ? $block_image : $old_image),
                'status' => 1
            );

            $result = $this->Blocks->update_block($data, $block_id);

            if ($result == TRUE) {
                $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect('dashboard/Cblock');
            } else {
                $this->session->set_userdata(array('error_message' => display('already_exists')));
                redirect('dashboard/Cblock');
            }
        }
    }

    // block Delete
    public function block_delete($block_id)
    {
        $this->permission->check_label('block')->delete()->redirect();

        $binfo = $this->db->where('block_id', $block_id)->get('block')->row();

        $result = $this->Blocks->delete_block($block_id);
        if($result){
            unlink(@$binfo->block_image);
            $this->session->set_userdata(array('message' => display('successfully_delete')));
        }else{
            $this->session->set_userdata(array('error_message' => display('failed_try_again')));
        }
        redirect('dashboard/Cblock');
    }

    //Inactive
    public function inactive($id)
    {
        $this->permission->check_label('block')->update()->redirect();

        $this->db->set('status', 0);
        $this->db->where('block_id', $id);
        $this->db->update('block');
        $this->session->set_userdata(array('error_message' => display('successfully_inactive')));
        redirect(base_url('dashboard/Cblock'));
    }

    //Active
    public function active($id)
    {
        $this->permission->check_label('block')->update()->redirect();

        $this->db->set('status', 1);
        $this->db->where('block_id', $id);
        $this->db->update('block');
        $this->session->set_userdata(array('message' => display('successfully_active')));
        redirect(base_url('dashboard/Cblock'));
    }
}