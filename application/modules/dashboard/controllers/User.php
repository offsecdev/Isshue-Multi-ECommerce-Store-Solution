<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('dashboard/lusers');
        $this->load->library('session');
        $this->load->model('dashboard/Userm');
        $this->auth->check_user_auth();
    }

    #==============User page load============#
    public function index()
    {
        $this->permission->check_label('add_user')->create()->redirect();

        $content = $this->lusers->user_add_form();
        $this->template_lib->full_admin_html_view($content);
    }

    #===============User Search Item===========#
    public function user_search_item()
    {   
        $user_id = $this->input->post('user_id', TRUE);
        $content = $this->lusers->user_search_item($user_id);
        $this->template_lib->full_admin_html_view($content);
    }

    #================Manage User===============#
    public function manage_user()
    {
        $this->permission->check_label('manage_users')->read()->redirect();

        $content = $this->lusers->user_list();
        $this->template_lib->full_admin_html_view($content);
    }


#==============Insert User==============#
    public function insert_user()
    {
        $this->permission->check_label('add_user')->create()->redirect();

        $this->form_validation->set_rules('first_name', display('first_name'), 'trim|required');
        $this->form_validation->set_rules('last_name', display('last_name'), 'trim|required');
        $this->form_validation->set_rules('email', display('email'), 'trim|required');
        $this->form_validation->set_rules('password', display('password'), 'trim|required');
        $this->form_validation->set_rules('user_type', display('user_type'), 'trim|required');
        if($this->form_validation->run() == TRUE){
                $data = array(
                'first_name' => $this->input->post('first_name',TRUE),
                'last_name' => $this->input->post('last_name',TRUE),
                'email' => $this->input->post('email',TRUE),
                'password' => md5("gef" . $this->input->post('password',TRUE)),
                'user_type' => $this->input->post('user_type',TRUE),
                'store_id' => $this->input->post('store_id',TRUE),
                'logo' => base_url('assets/website/image/login.png'),
                'status' => 1
            );
            $result = $this->Userm->user_entry($data);
            if ($result) {
                $this->session->set_userdata(array('message' => display('successfully_added')));
                if (isset($_POST['add-user'])) {
                    redirect('dashboard/User/manage_user');
                } elseif (isset($_POST['add-user-another'])) {
                    redirect(base_url('dashboard/User'));
                }
            } else {
                $this->session->set_userdata(array('error_message' => display('already_exists')));
                redirect(base_url('dashboard/User/manage_user'));
            }
        }
        $this->index();
        
    }


    public function email_check($email, $id)
    {
        $emailExists = $this->db->select('email')
            ->where('email', $email)
            ->where_not_in('id', $id)
            ->get('User')
            ->num_rows();

        if ($emailExists > 0) {
            $this->form_validation->set_message('email_check', 'The {field} is already registered.');
            return false;
        } else {
            return true;
        }
    }


    public function form($id = null)
    {
        $this->permission->check_label('add_user')->redirect();

        $data['title'] = display('add_user');
        /*-----------------------------------*/
        $this->form_validation->set_rules('firstname', display('firstname'), 'required|max_length[50]');
        $this->form_validation->set_rules('lastname', display('lastname'), 'required|max_length[50]');
        #------------------------#
        if (!empty($id)) {
            $this->form_validation->set_rules('email', display('email'), "required|valid_email|max_length[100]");
        } else {
            $this->form_validation->set_rules('email', display('email'), 'required|valid_email|is_unique[user.email]|max_length[100]');
        }
        #------------------------#
        $this->form_validation->set_rules('password', display('password'), 'required|max_length[32]|md5');
        $this->form_validation->set_rules('about', display('about'), 'max_length[1000]');
        $this->form_validation->set_rules('status', display('status'), 'required|max_length[1]');
        /*-----------------------------------*/
        $config['upload_path'] = './assets/img/user/';
        $config['allowed_types'] = 'gif|jpg|png';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
            $data = $this->upload->data();
            $image = $config['upload_path'] . $data['file_name'];

            $config['image_library'] = 'gd2';
            $config['source_image'] = $image;
            $config['create_thumb'] = false;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 115;
            $config['height'] = 90;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $this->session->set_flashdata('message', display('image_upload_successfully'));
        }
        /*-----------------------------------*/
        $data['dashboard/User'] = (object)$userLevelData = array(
            'id' => $this->input->post('id',TRUE),
            'firstname' => $this->input->post('firstname',TRUE),
            'lastname' => $this->input->post('lastname',TRUE),
            'email' => $this->input->post('email',TRUE),
            'password' => md5($this->input->post('password',TRUE)),
            'about' => $this->input->post('about', true),
            'image' => (!empty($image) ? $image : $this->input->post('old_image',TRUE)),
            'last_login' => null,
            'last_logout' => null,
            'ip_address' => null,
            'status' => $this->input->post('status',TRUE),
            'is_admin' => 0
        );

        /*-----------------------------------*/
        if ($this->form_validation->run()) {

            if (empty($userLevelData['image'])) {
                $this->session->set_flashdata('exception', $this->upload->display_errors());
            }

            if (empty($userLevelData['id'])) {
                if ($this->user_model->create($userLevelData)) {
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
                redirect("dashboard/user/form/");

            } else {
                if ($this->user_model->update($userLevelData)) {
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }

                redirect("dashboard/user/form/$id");
            }


        } else {
            $data['module'] = "dashboard";
            $data['page'] = "user/form";
            if (!empty($id))
                $data['User'] = $this->user_model->single($id);
            echo Modules::run('template/layout', $data);
        }
    }

    public function delete($id = null)
    {
        $this->permission->check_label('manage_users')->delete()->redirect();

        if ($this->user_model->delete($id)) {
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            $this->session->set_flashdata('exception', display('please_try_again'));
        }

        redirect("dashboard/user/index");
    }

    #===============User update form================#
    public function user_update_form($user_id)
    {
        $this->permission->check_label('manage_users')->update()->redirect();

        $this->form_validation->set_rules('first_name', display('first_name'), 'trim|required');
        $this->form_validation->set_rules('last_name', display('last_name'), 'trim|required');
        $this->form_validation->set_rules('username', display('email'), 'trim|required');
        $this->form_validation->set_rules('user_type', display('user_type'), 'trim|required');

        if($this->form_validation->run() == TRUE){
            $user_id = $this->input->post('user_id',TRUE);

            $this->Userm->update_user($user_id);
            $this->session->set_userdata(array('message' => display('successfully_updated')));
            redirect(base_url('dashboard/user/manage_user'));
        }

        $content = $this->lusers->user_edit_data($user_id);
        $this->template_lib->full_admin_html_view($content);

    }


    #============User delete===========#
    public function user_delete($user_id)
    {
        $this->permission->check_label('manage_users')->create()->redirect();

        $this->Userm->delete_user($user_id);
        $this->session->set_userdata(array('message' => display('successfully_delete')));
        redirect('dashboard/User/manage_user');
    }

}
