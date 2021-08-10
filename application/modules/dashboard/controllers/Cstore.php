<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cstore extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('dashboard/lstore');
        $this->load->model('dashboard/Stores');
        $this->load->model('dashboard/Wearhouses');
        $this->load->model('dashboard/Variants');
        $this->auth->check_user_auth();
    }

    //Default loading for store system.
    public function index()
    {
        $this->permission->check_label('store_add')->create()->redirect();
        $content = $this->lstore->store_add_form();
        $this->template_lib->full_admin_html_view($content);
    }

    //Insert store
    public function insert_store()
    {
        $this->permission->check_label('store_add')->create()->redirect();

        $this->form_validation->set_rules('store_name', display('store_name'), 'trim|required');
        $this->form_validation->set_rules('store_address', display('store_address'), 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => display('add_store')
            );
            $content = $this->parser->parse('dashboard/store/add_store', $data, true);
            $this->template_lib->full_admin_html_view($content);
        } else {
            $data = array(
                'store_id' => $this->auth->generator(15),
                'store_name' => $this->input->post('store_name',TRUE),
                'store_address' => $this->input->post('store_address',TRUE),
                'default_status' => $this->input->post('default_status',TRUE)
            );

            $result = $this->Stores->store_entry($data);

            if ($result == TRUE) {

                $this->session->set_userdata(array('message' => display('successfully_added')));

                if (isset($_POST['add-store'])) {
                    redirect('dashboard/Cstore/manage_store');
                } elseif (isset($_POST['add-store-another'])) {
                    redirect('dashboard/Cstore');
                }

            } else {
                redirect('dashboard/Cstore');
            }
        }
    }

    //Manage store
    public function manage_store()
    {
        $this->permission->check_label('manage_store')->read()->redirect();
        $content = $this->lstore->store_list();
        $this->template_lib->full_admin_html_view($content);;
    }

    //Store Update Form
    public function store_update_form($store_id)
    {
        $this->permission->check_label('manage_store')->update()->redirect();
        $content = $this->lstore->store_edit_data($store_id);
        $this->menu = array('label' => 'Edit store', 'url' => 'Ccustomer');
        $this->template_lib->full_admin_html_view($content);
    }

    // Store Update
    public function store_update($store_id = null)
    {
        $this->permission->check_label('manage_store')->update()->redirect();
        $this->form_validation->set_rules('store_name', display('store_name'), 'trim|required');
        $this->form_validation->set_rules('store_address', display('store_address'), 'trim|required');
        $this->form_validation->set_rules('default_status', display('default_status'), 'trim|required');

        if ($this->form_validation->run() == TRUE) {

            $data = array(
                'store_name' => $this->input->post('store_name',TRUE),
                'store_address' => $this->input->post('store_address',TRUE),
                'default_status' => $this->input->post('default_status',TRUE),
            );

            $result = $this->Stores->update_store($data, $store_id);

            if ($result == TRUE) {
                $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect('dashboard/Cstore/manage_store');
            } else {
                redirect('dashboard/Cstore/manage_store');
            }
        }
        $this->store_update_form($store_id);
    }

     //Store Product
    public function store_transfer()
    {
        $this->permission->check_label('store_transfer')->update()->redirect();

        $content = $this->lstore->store_transfer_form();
        $this->template_lib->full_admin_html_view($content);
    }


    //Store transfer select
    public function store_transfer_select()
    {

        $this->load->model('dashboard/Products');
        $store_id = $this->input->post('store_id',TRUE);
        $product_lists = $this->Products->get_product_list_by_store($store_id);
        $store_list = $this->Stores->store_select($store_id);


        $stores = '';
        $stores .= "<select class=\"form-control -js-example-basic-single\" id=\"store\" name=\"t_store_id\" required=\"\" >";
        $stores .= "<option>Select Store</option>";
        if(!empty($store_list)){
        foreach ($store_list as $store) {
            $stores .= "<option value=" . $store->store_id . ">" . $store->store_name . "</option>";
        }
        }
        $stores .= "</select>";

        $products = '';
        $products .= "<select class=\"form-control \" id=\"product_name\" name=\"product_id\" required=\"\" >";
        $products .= "<option>Select Product</option>";
        if(!empty($product_lists)){
        foreach ($product_lists as $product_list) {
            $products .= "<option value=" . $product_list['product_id'] . ">" . $product_list['product_name'] . "-(" .
                $product_list['product_model'] . ")"
                . "</option>";
        }
        }
        $products .= "</select>";

        $result['stores'] = $stores;
        $result['products'] = $products;
        echo json_encode($result);

    }


//get variant by existing purched product
    public function get_variant_by_store()
    {
        $store_id = $this->input->post('store_id',TRUE);
        $product_id = $this->input->post('product_id',TRUE);

        $this->db->select('a.*');
        $this->db->from('variant a');
        $this->db->join('transfer b', 'a.variant_id=b.variant_id');
        $this->db->where('b.store_id =', $store_id);
        $this->db->where('b.product_id =', $product_id);
        $this->db->group_by('a.variant_id');
        $variants = $this->db->get()->result();

        $this->db->select('a.*');
        $this->db->from('variant a');
        $this->db->join('transfer b', 'a.variant_id=b.variant_color');
        $this->db->where('b.store_id =', $store_id);
        $this->db->where('b.product_id =', $product_id);
        $this->db->group_by('a.variant_id');
        $variant_color = $this->db->get()->result();

        $variant_html = $variant_colorhtml = '<option value=""></option>';

        foreach ($variants as $variant) {
            $variant_html .= "<option value=" . $variant->variant_id . ">" . $variant->variant_name . "</option>";
        }

        if(!empty($variant_color)){
            foreach ($variant_color as $cvariant) {
                $variant_colorhtml .= "<option value=" . $cvariant->variant_id . ">" . $cvariant->variant_name . "</option>";
            }
        }

        echo json_encode(array(
            'variant_html' => $variant_html,
            'variant_colorhtml' => $variant_colorhtml
        ));


    }


    //Insert store product
    public function insert_store_product()
    {
        $this->permission->check_label('store_transfer')->update()->redirect();

        $quantity = $this->input->post('quantity',TRUE);

        $data = array(
            'transfer_id' => $this->auth->generator(15),
            'store_id' => $this->input->post('store_id',TRUE),
            'product_id' => $this->input->post('product_id',TRUE),
            'variant_id' => $this->input->post('variant_id',TRUE),
            'variant_color' => $this->input->post('variant_color',TRUE),
            'quantity' => "-" . $quantity,
            'transfer_by' => $this->session->userdata('user_id'),
            't_store_id' => $this->input->post('t_store_id',TRUE),
            'date_time' => date("m-d-Y"),
            'status' => 1,
        );

        $data1 = array(
            'transfer_id' => $this->auth->generator(15),
            'store_id' => $this->input->post('t_store_id',TRUE),
            'product_id' => $this->input->post('product_id',TRUE),
            'variant_id' => $this->input->post('variant_id',TRUE),
            'variant_color' => $this->input->post('variant_color',TRUE),
            'quantity' => $quantity,
            'transfer_by' => $this->session->userdata('user_id'),
            't_store_id' => $this->input->post('store_id',TRUE),
            'date_time' => date("m-d-Y"),
        );

        $result = $this->Stores->store_transfer($data, $data1);

        if ($result == TRUE) {
            $this->session->set_userdata(array('message' => display('successfully_inserted')));
            if (isset($_POST['add-store'])) {
                redirect(base_url('dashboard/Cstore/manage_store_product'));
            } elseif (isset($_POST['add-store-another'])) {
                redirect(base_url('dashboard/Cstore/store_transfer'));
            }
        } else {
            $this->session->set_userdata(array('error_message' => display('product_is_not_available_please_purchase_product')));
            redirect('dashboard/Cstore/store_transfer');
        }

    }

    // Manage store
    public function manage_store_product()
    {
        $this->permission->check_label('manage_store_product')->update()->redirect();

        $content = $this->lstore->store_product_list();
        $this->template_lib->full_admin_html_view($content);;
    }

    //Store Product Update Form
    public function store_product_update_form($store_product_id)
    {
        $this->permission->check_label('manage_store_product')->update()->redirect();

        $content = $this->lstore->store_product_edit_data($store_product_id);
        $this->template_lib->full_admin_html_view($content);
    }


    // Store Product Update
    public function store_product_update($store_product_id = null)
    {
        $this->permission->check_label('manage_store_product')->update()->redirect();

        $this->form_validation->set_rules('store_name', display('store_name'), 'trim|required');
        $this->form_validation->set_rules('product_name', display('product_name'), 'trim|required');
        $this->form_validation->set_rules('variant', display('variant'), 'trim|required');
        $this->form_validation->set_rules('quantity', display('quantity'), 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => display('add_store')
            );
            $content = $this->parser->parse('dashboard/store/add_store', $data, true);
            $this->template_lib->full_admin_html_view($content);
        } else {

            $data = array(
                'store_id' => $this->input->post('store_name',TRUE),
                'product_id' => $this->input->post('product_name',TRUE),
                'variant_id' => $this->input->post('variant',TRUE),
                'quantity' => $this->input->post('quantity',TRUE),
            );


            $result = $this->Stores->store_product_update($data, $store_product_id);
            if ($result == TRUE) {
                $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect('dashboard/Cstore/manage_store_product_product');
            } else {
                $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect('dashboard/Cstore/manage_store_product_product');
            }
        }
    }

    // Store Delete
    public function store_delete($store_id)
    {
        $this->permission->check_label('manage_store')->delete()->redirect();

        $result = $this->Stores->delete_store($store_id);
        if ($result == 1) {
            $this->session->set_userdata(array('message' => display('successfully_delete')));
            redirect('dashboard/Cstore/manage_store');
        } elseif ($result === 'default') {
            $this->session->set_userdata(array('error_message' => display('you_cant_delete_this_is_default_store')));
            redirect('dashboard/Cstore/manage_store');
        } else {
            $this->session->set_userdata(array('error_message' => display('you_cant_delete_this_is_in_calculate_system')));
            redirect('dashboard/Cstore/manage_store');
        }
    }

    // store product Delete
    public function store_product_delete()
    {
        $this->permission->check_label('manage_store_product')->delete()->redirect();

        $store_product_id = $this->input->post('store_product_id',TRUE);
        $this->Stores->delete_store_product($store_product_id);
        $this->session->set_userdata(array('message' => display('successfully_delete')));
        return true;
    }

    // Update status of store
    public function update_status($store_id)
    {
        $this->db->set('default_status', 1)
            ->where('store_id', $store_id)
            ->update('store_set');

        $this->db->set('default_status', 0)
            ->where('store_id !=', $store_id)
            ->update('store_set');

        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect('dashboard/Cstore/manage_store');

    }

    //Add Store CSV
    public function add_store_csv()
    {
        $this->permission->check_label('import_store_csv')->create()->redirect();

        $CI =& get_instance();
        $data = array(
            'title' => display('import_store_csv')
        );
        $content = $CI->parser->parse('dashboard/store/add_store_csv', $data, true);
        $this->template_lib->full_admin_html_view($content);
    }


    //CSV Upload File
    function uploadCsv()
    {
        $this->permission->check_label('import_store_csv')->create()->redirect();

        $count = 0;
        $fp = fopen($_FILES['upload_csv_file']['tmp_name'], 'r') or die("can't open file");

        if (($handle = fopen($_FILES['upload_csv_file']['tmp_name'], 'r')) !== FALSE) {

            while ($csv_line = fgetcsv($fp, 1024)) {
                //keep this if condition if you want to remove the first row
                for ($i = 0, $j = count($csv_line); $i < $j; $i++) {
                    $insert_csv = array();
                    $insert_csv['store_name'] = (!empty($csv_line[0]) ? $csv_line[0] : null);
                    $insert_csv['store_address'] = (!empty($csv_line[1]) ? $csv_line[1] : null);
                    $insert_csv['status'] = (!empty($csv_line[2]) ? $csv_line[2] : 0);
                }

                $data = array(
                    'store_id' => $this->auth->generator(10),
                    'store_name' => $insert_csv['store_name'],
                    'store_address' => $insert_csv['store_address'],
                    'default_status' => $insert_csv['status'],
                );

                if ($count > 0) {
                    $result = $this->db->select('*')
                        ->from('store_set')
                        ->where('store_name', $data['store_name'])
                        ->get()
                        ->num_rows();

                    if ($result == 0 && !empty($data['store_name']) && $data['default_status'] == 0) {
                        $this->db->insert('store_set', $data);
                        $this->session->set_userdata(array('message' => display('successfully_added')));
                    } else {
                        $this->db->set('store_name', $data['store_name']);
                        $this->db->where('store_name', $data['store_name']);
                        $this->db->update('store_set');
                        $this->session->set_userdata(array('error_message' => display('default_store_already_exists')));
                    }
                }
                $count++;
            }
        }

        fclose($fp) or die("Can't close file");
        if (isset($_POST['add-store'])) {
            redirect(base_url('dashboard/Cstore/manage_store'));
            exit;
        } elseif (isset($_POST['add-store-another'])) {
            redirect(base_url('dashboard/Cstore'));
            exit;
        }
    }
}