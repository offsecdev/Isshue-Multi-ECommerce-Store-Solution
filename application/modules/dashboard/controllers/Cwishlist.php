<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cwishlist extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('dashboard/lwishlist');
        $this->load->model('dashboard/Wishlists');
        $this->load->model('dashboard/Products');
        $this->auth->check_user_auth();

    }

    //Default loading for wishlist system.
    public function index()
    {
        $this->permission->check_label('wishlist')->create()->redirect();

        $content = $this->lwishlist->wishlist_add_form();
        $this->template_lib->full_admin_html_view($content);
    }


    //Insert wishlist
    public function insert_wishlist()
    {
        $this->permission->check_label('wishlist')->create()->redirect();

        $this->form_validation->set_rules('product_id', display('product_name'), 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $product_list = $CI->Products->product_list(); 
            $data = array(
                'title'        => display('add_wishlist'),
                'product_list' => $product_list,
            );
            $content = $this->parser->parse('dashboard/wishlist/add_wishlist',$data,true);
            $this->template_lib->full_admin_html_view($content);

        } else {
            $data = array(
                'wishlist_id' => $this->auth->generator(15),
                'user_id' => $this->session->userdata('user_id'),
                'product_id' => $this->input->post('product_id',TRUE),
                'status' => 1
            );

            $result = $this->Wishlists->wishlist_entry($data);

            if ($result == TRUE) {

                $this->session->set_userdata(array('message' => display('successfully_added')));

                if (isset($_POST['add-wishlist'])) {
                    redirect(base_url('dashboard/Cwishlist/manage_wishlist'));
                } elseif (isset($_POST['add-wishlist-another'])) {
                    redirect(base_url('dashboard/Cwishlist'));
                }

            } else {
                $this->session->set_userdata(array('error_message' => display('already_inserted')));
                redirect(base_url('dashboard/Cwishlist'));
            }
        }
    }

    //Manage wishlist
    public function manage_wishlist()
    {
        $this->permission->check_label('wishlist')->read()->redirect();

        $content =$this->lwishlist->wishlist_list();
        $this->template_lib->full_admin_html_view($content);;
    }
    //wishlist Update Form
    public function wishlist_update_form($wishlist_id)
    {   
        $this->permission->check_label('wishlist')->read()->redirect();

        $content = $this->lwishlist->wishlist_edit_data($wishlist_id);
        $this->template_lib->full_admin_html_view($content);
    }


    // wishlist Update
    public function wishlist_update($wishlist_id = null)
    {
        $this->permission->check_label('wishlist')->update()->redirect();

        $this->form_validation->set_rules('product_id', display('product_name'), 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => display('add_wishlist')
            );
            $content = $this->parser->parse('dashboard/wishlist/add_wishlist',$data,true);
            $this->template_lib->full_admin_html_view($content);
        } else {
            $data = array(
                'product_id' => $this->input->post('product_id',TRUE),
            );

            $result = $this->Wishlists->update_wishlist($data, $wishlist_id);

            if ($result == TRUE) {
                $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect('dashboard/Cwishlist/manage_wishlist');
            } else {
                $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect('dashboard/Cwishlist/manage_wishlist');
            }
        }
    }


    // wishlist Delete
    public function wishlist_delete($wishlist_id)
    {
        $this->permission->check_label('wishlist')->delete()->redirect();

        $this->Wishlists->delete_wishlist($wishlist_id);
        $this->session->set_userdata(array('message' => display('successfully_delete')));
        redirect('dashboard/Cwishlist/manage_wishlist');
    }

    //Inactive
    public function inactive($id)
    {
        $this->permission->check_label('wishlist')->update()->redirect();

        $this->db->set('status', 0);
        $this->db->where('wishlist_id', $id);
        $this->db->update('wishlist');
        $this->session->set_userdata(array('error_message' => display('successfully_inactive')));
        redirect(base_url('dashboard/Cwishlist/manage_wishlist'));
    }

    //Active
    public function active($id)
    {
        $this->permission->check_label('wishlist')->update()->redirect();

        $this->db->set('status', 1);
        $this->db->where('wishlist_id', $id);
        $this->db->update('wishlist');
        $this->session->set_userdata(array('message' => display('successfully_active')));
        redirect(base_url('dashboard/Cwishlist/manage_wishlist'));
    }
}