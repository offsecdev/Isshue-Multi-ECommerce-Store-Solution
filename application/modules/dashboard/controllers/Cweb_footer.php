<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cweb_footer extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('dashboard/lweb_footer');
        $this->load->model(array(
            'dashboard/Web_footers'
        ));
        $this->auth->check_user_auth();
    }

    //Default loading for web_footer system.
    public function index()
    {
        $this->permission->check_label('web_footer')->create()->redirect();

        $content = $this->lweb_footer->web_footer_add_form();
        $this->template_lib->full_admin_html_view($content);
    }

    //Insert web_footer
    public function insert_web_footer()
    {
        $this->permission->check_label('web_footer')->create()->redirect();
        
        $this->form_validation->set_rules('headlines', display('headlines'), 'trim|required');
        $this->form_validation->set_rules('details', display('details'), 'trim|required');
        $this->form_validation->set_rules('position', display('position'), 'trim|required');

        if ($this->form_validation->run() == FALSE) {

            $data = array(
                'title' => display('add_web_footer'),
            );
            $content = $this->parser->parse('dashboard/web_footer/add_web_footer',$data,true);
            $this->template_lib->full_admin_html_view($content);


        } else {
            $data = array(
                'footer_section_id' => $this->auth->generator(15),
                'headlines' => $this->input->post('headlines',TRUE),
                'details' => $this->input->post('details',TRUE),
                'position' => $this->input->post('position',TRUE),
                'status' => 1,
            );

            $result = $this->Web_footers->web_footer_entry($data);

            if ($result == TRUE) {

                $this->session->set_userdata(array('message' => display('successfully_added')));

                if (isset($_POST['add-web_footer'])) {
                    redirect(base_url('dashboard/Cweb_footer/manage_web_footer'));
                } elseif (isset($_POST['add-web_footer-another'])) {
                    redirect(base_url('dashboard/Cweb_footer'));
                }

            } else {
                $this->session->set_userdata(array('error_message' => display('already_exists')));
                redirect(base_url('dashboard/Cweb_footer'));
            }
        }
    }

    //Manage web_footer
    public function manage_web_footer()
    {
        $this->permission->check_label('web_footer')->read()->redirect();

        $content =$this->lweb_footer->web_footer_list();
        $this->template_lib->full_admin_html_view($content);;
    }
    //web_footer Update Form
    public function web_footer_update_form($footer_section_id)
    { 
        $this->permission->check_label('web_footer')->update()->redirect();  
        $content = $this->lweb_footer->web_footer_edit_data($footer_section_id);
        $this->template_lib->full_admin_html_view($content);
    }

    // web_footer Update
    public function web_footer_update($footer_section_id = null)
    {

        $this->permission->check_label('web_footer')->update()->redirect();

        $this->form_validation->set_rules('headlines', display('headlines'), 'trim|required');
        $this->form_validation->set_rules('details', display('details'), 'trim|required');
        $this->form_validation->set_rules('position', display('position'), 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => display('add_web_footer'),
            );
            $content = $this->parser->parse('dashboard/web_footer/add_web_footer',$data,true);
            $this->template_lib->full_admin_html_view($content);

        } else {
            $data = array(
                'headlines' => $this->input->post('headlines',TRUE),
                'details' => $this->input->post('details',TRUE),
                'position' => $this->input->post('position',TRUE),
            );

            $result = $this->Web_footers->update_web_footer($data, $footer_section_id);

            if ($result == TRUE) {
                $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect('dashboard/Cweb_footer/manage_web_footer');
            } else {
                $this->session->set_userdata(array('error_message' => display('already_exists')));
                redirect('dashboard/Cweb_footer/manage_web_footer');
            }
        }
    }

    // web_footer Delete
    public function web_footer_delete($footer_section_id)
    {
        $this->permission->check_label('web_footer')->delete()->redirect();

        $this->Web_footers->delete_web_footer($footer_section_id);
        $this->session->set_userdata(array('message' => display('successfully_delete')));
        redirect('dashboard/Cweb_footer/manage_web_footer');
    }

    //Inactive
    public function inactive($id)
    {
        $this->permission->check_label('web_footer')->update()->redirect();

        $this->db->set('status', 0);
        $this->db->where('footer_section_id', $id);
        $this->db->update('web_footer');
        $this->session->set_userdata(array('error_message' => display('successfully_inactive')));
        redirect(base_url('dashboard/Cweb_footer/manage_web_footer'));
    }

    //Active
    public function active($id)
    {
        $this->permission->check_label('web_footer')->update()->redirect();

        $this->db->set('status', 1);
        $this->db->where('footer_section_id', $id);
        $this->db->update('web_footer');
        $this->session->set_userdata(array('message' => display('successfully_active')));
        redirect(base_url('dashboard/Cweb_footer/manage_web_footer'));
    }


}