<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cproduct_review extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->auth->check_user_auth();
        $this->load->library('dashboard/lproduct_review');
        $this->load->model('dashboard/Product_reviews');
    }

    //Default loading for product_review system.
    public function index()
    {
        $this->permission->check_label('product_review')->read()->redirect();
        $content =$this->lproduct_review->product_review_list();
        $this->template_lib->full_admin_html_view($content);
    }
    
    //Manage product_review
    public function manage_product_review()
    {
        $this->permission->check_label('product_review')->read()->redirect();
        $content =$this->lproduct_review->product_review_list();
        $this->template_lib->full_admin_html_view($content);;
    }
    //product_review Update Form
    public function product_review_update_form($product_review_id)
    {   
        $this->permission->check_label('product_review')->update()->redirect();

        $content = $this->lproduct_review->product_review_edit_data($product_review_id);
        $this->template_lib->full_admin_html_view($content);
    }

    // product_review Update
    public function product_review_update($product_review_id = null)
    {
        $this->permission->check_label('product_review')->update()->redirect();

        $this->form_validation->set_rules('product_id', display('product_name'), 'trim|required');
        $this->form_validation->set_rules('comments', display('comments'), 'trim|required');
        $this->form_validation->set_rules('rate', display('rate'), 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => display('add_product_review')
            );
            $content = $this->parser->parse('dashboard/product_review/add_product_review',$data,true);
            $this->template_lib->full_admin_html_view($content);

        } else {

            $data = array(
                'product_id' => $this->input->post('product_id',TRUE),
                'comments' => $this->input->post('comments',TRUE),
                'rate' => $this->input->post('rate',TRUE),
            );

            $result = $this->Product_reviews->update_product_review($data, $product_review_id);

            if ($result == TRUE) {
                $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect('dashboard/Cproduct_review/manage_product_review');
            } else {
                $this->session->set_userdata(array('error_message' => display('already_exists')));
                redirect('dashboard/Cproduct_review/manage_product_review');
            }
        }
    }

    // product_review Delete
    public function product_review_delete()
    {
        $this->permission->check_label('product_review')->delete()->redirect();

        $product_review_id = $this->input->post('product_review_id',TRUE);
        $this->Product_reviews->delete_product_review($product_review_id);
        $this->session->set_userdata(array('message' => display('successfully_delete')));
        return true;

    }

    //Inactive
    public function inactive($id)
    {
        $this->permission->check_label('product_review')->update()->redirect();

        $this->db->set('status', 0);
        $this->db->where('product_review_id', $id);
        $this->db->update('product_review');
        $this->session->set_userdata(array('error_message' => display('successfully_inactive')));
        redirect(base_url('dashboard/Cproduct_review/manage_product_review'));
    }

    //Active
    public function active($id)
    {
        $this->permission->check_label('product_review')->update()->redirect();

        $this->db->set('status', 1);
        $this->db->where('product_review_id', $id);
        $this->db->update('product_review');
        $this->session->set_userdata(array('message' => display('successfully_active')));
        redirect(base_url('dashboard/Cproduct_review/manage_product_review'));
    }
}