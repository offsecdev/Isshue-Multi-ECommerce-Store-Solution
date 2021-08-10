<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cstate extends MX_Controller{

    function __construct() {
        parent::__construct();
        $this->load->model('dashboard/States');
        $this->auth->check_user_auth();
    }
    public function index($page = 0)
    {
        $this->permission->check_label('manage_states')->read()->redirect();

        $filter = array(
            'country' => $this->input->get('country', TRUE),
            'state' => $this->input->get('state', TRUE)
        );

        $config["base_url"] = base_url('dashboard/cstate/index');
        $config["total_rows"] = $this->States->count_states($filter);
        $config["reuse_query_string"] = TRUE;
        $config["per_page"] = 20;
        $config["uri_segment"] = 4;
        $config["num_links"] = 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $links = $this->pagination->create_links();

        $states = $this->States->get_states($config["per_page"], $page, $filter);
        $countries = $this->States->get_country_list();
        $data = array(
            'title' => display('states'),
            'states' => $states,
            'countries' => $countries,
            'links' => $links, 
            'page' => $page
        );
        $content = $this->parser->parse('dashboard/state/state_list',$data,true);
        $this->template_lib->full_admin_html_view($content);
    }
    // State add
    public function state_add(){
        $this->permission->check_label('add_state')->create()->redirect();

        $this->form_validation->set_rules('country', display('country'), 'trim|required');
        $this->form_validation->set_rules('state', display('state'), 'trim|required');

        if($this->form_validation->run() == TRUE){
            $data = array(
                'name' => $this->input->post('state', TRUE),
                'country_id' => $this->input->post('country', TRUE)
            );
            $result = $this->db->insert('states', $data);
            if($result){
                 $this->session->set_userdata(array('message' => display('successfully_added')));

                if (isset($_POST['add-item'])) {
                    redirect('dashboard/cstate');
                } elseif (isset($_POST['add-item-another'])) {
                    redirect('dashboard/cstate/state_add');
                }
            }else{
                $this->session->set_userdata(array('error_message' => display('failed_try_again')));
            }
        }

        $countries = $this->States->get_country_list();
        $data = array(
            'title' => display('states'),
            'countries' => $countries
        );
        $content = $this->parser->parse('dashboard/state/state_add',$data,true);
        $this->template_lib->full_admin_html_view($content);
    }

    // State add
    public function state_edit($state_id){
        $this->permission->check_label('manage_states')->update()->redirect();

        $this->form_validation->set_rules('country', display('country'), 'trim|required');
        $this->form_validation->set_rules('state', display('state'), 'trim|required');

        if($this->form_validation->run() == TRUE){
            $data = array(
                'name' => $this->input->post('state', TRUE),
                'country_id' => $this->input->post('country', TRUE)
            );
            $result = $this->db->update('states', $data, array('id' => $state_id));
            if($result){
                 $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect('dashboard/cstate');
            }else{
                $this->session->set_userdata(array('error_message' => display('failed_try_again')));
            }
        }

        $stateinfo = $this->States->get_stateinfo_by_id($state_id);
        $countries = $this->States->get_country_list();
        $data = array(
            'title' => display('states'),
            'countries' => $countries,
            'stateinfo' => $stateinfo
        );
        $content = $this->parser->parse('dashboard/state/state_edit',$data,true);
        $this->template_lib->full_admin_html_view($content);
    }

    public function state_delete($state_id)
    {
        $this->permission->check_label('manage_states')->delete()->redirect();
        
        $result = $this->db->delete('states', array('id' => $state_id));

        if($result){
             $this->session->set_userdata(array('message' => display('successfully_delete')));
        }else{
            $this->session->set_userdata(array('error_message' => display('failed_try_again')));
        }
        redirect('dashboard/cstate');
    }
}