<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cvariant extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('dashboard/lvariant');
        $this->load->model('dashboard/Variants');
        $this->auth->check_user_auth();
    }
     //Default loading for variant system.
    public function index()
    {
        $this->permission->check_label('add_variant')->create()->redirect();

        $content = $this->lvariant->variant_add_form();
        $this->template_lib->full_admin_html_view($content);
    }

    //Insert variant
    public function insert_variant()
    {

        $this->permission->check_label('add_variant')->create()->redirect();

        $this->form_validation->set_rules('variant_name', display('variant_name'), 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => display('add_variant')
            );
            $content = $this->parser->parse('variant/add_variant', $data, true);
            $this->template_lib->full_admin_html_view($content);
        } else {
            $category_ids = $this->input->post('category_id',TRUE);
            $variant_id = $this->auth->generator(15);
            $data = array(
                'variant_id' => $variant_id,
                'variant_name' => $this->input->post('variant_name',TRUE),
                'variant_type' => $this->input->post('variant_type',TRUE),
                'color_code' => $this->input->post('color_code',TRUE),
                'status' => 1
            );

            $result = $this->Variants->variant_entry($data);
            foreach ($category_ids as $category_id):
                $this->db->query("INSERT INTO `category_variant` (`category_id`, `variant_id`, `created_at`, `updated_at`) VALUES (" . $this->db->escape($category_id) . ", " . $this->db->escape($variant_id) . ", now(), now())");
            endforeach;
            if ($result == TRUE) {

                $this->session->set_userdata(array('message' => display('successfully_added')));

                if (isset($_POST['add-variant'])) {
                    redirect(base_url('dashboard/Cvariant/manage_variant'));
                } elseif (isset($_POST['add-variant-another'])) {
                    redirect(base_url('dashboard/Cvariant'));
                }

            } else {
                $this->session->set_userdata(array('error_message' => display('already_inserted')));
                redirect(base_url('dashboard/Cvariant'));
            }
        }
    }

    //Manage variant
    public function manage_variant()
    {
        $this->permission->check_label('manage_variant')->read()->redirect();

        $content = $this->lvariant->variant_list();
        $this->template_lib->full_admin_html_view($content);;
    }

    //variant Update Form
    public function variant_update_form($variant_id)
    {
        $this->permission->check_label('manage_variant')->update()->redirect();

        $content = $this->lvariant->variant_edit_data($variant_id);
        $this->template_lib->full_admin_html_view($content);
    }

    // variant Update
    public function variant_update($variant_id = null)
    {
        $this->permission->check_label('manage_variant')->update()->redirect();

        $this->form_validation->set_rules('variant_name', display('variant_name'), 'trim|required');
        $this->form_validation->set_rules('variant_type', display('variant_type'), 'trim|required');

        if ($this->form_validation->run() == TRUE) {

            $category_ids = $this->input->post('category_id',TRUE);
            $data = array(
                'variant_name' => $this->input->post('variant_name',TRUE),
                'variant_type' => $this->input->post('variant_type',TRUE),
                'color_code' => $this->input->post('color_code',TRUE),
                'status' => $this->input->post('status',TRUE),
            );

            $result = $this->Variants->update_variant($data, $variant_id);
            $this->db->query("delete from category_variant where variant_id=" . $this->db->escape($variant_id));
            foreach ($category_ids as $category_id):
                $this->db->query("INSERT INTO `category_variant` (`category_id`, `variant_id`, `created_at`, `updated_at`) VALUES (" . $this->db->escape($category_id) . ", " . $this->db->escape($variant_id) . ", now(), now())");
            endforeach;

            if ($result == TRUE) {
                $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect('dashboard/Cvariant/manage_variant');
            } else {
                $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect('dashboard/Cvariant/manage_variant');
            }
        }

        $content = $this->lvariant->variant_edit_data($variant_id);
        $this->template_lib->full_admin_html_view($content);
    }

    // Variant Delete
    public function variant_delete($variant_id)
    {
        $this->permission->check_label('manage_variant')->delete()->redirect();

        $result = $this->Variants->delete_variant($variant_id);
        if ($result) {
            $this->session->set_userdata(array('message' => display('successfully_delete')));
            redirect('dashboard/Cvariant/manage_variant');
        }
    }
}