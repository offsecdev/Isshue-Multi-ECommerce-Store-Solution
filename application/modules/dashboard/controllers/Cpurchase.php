<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cpurchase extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->auth->check_user_auth();
        $this->load->model(array(
            'dashboard/Suppliers',
            'dashboard/Purchases',
            'dashboard/Stores',
            'dashboard/Variants',
            'dashboard/Soft_settings',
            'template/Template_model',
        ));
        $this->load->library('dashboard/occational');

    }


    //Default index function loading
    public function index()
    {
        $this->permission->check_label('add_purchase')->create()->redirect();

        $all_supplier = $this->Purchases->select_all_supplier();
        $store_list = $this->Stores->store_list();
        $get_def_store = $this->Stores->get_def_store();
        $variant_list = $this->Variants->variant_list();
        $data = array(
            'title' => display('add_purchase'),
            'all_supplier' => $all_supplier,
            'store_list' => $store_list,
            'def_store' => $get_def_store,
            'variant_list' => $variant_list,
        );
        $data['setting'] = $this->Template_model->setting();
        $data['module'] = "dashboard";
        $data['page'] = 'purchase/add_purchase_form';
        $this->parser->parse('template/layout', $data);
    }


    //Purchase Add Form
    public function manage_purchase()
    {
        $this->permission->check_label('manage_purchase')->read()->redirect();

        $purchases_list = $this->Purchases->purchase_list();
        if (!empty($purchases_list)) {
            $j = 0;
            foreach ($purchases_list as $k => $v) {
                $purchases_list[$k]['final_date'] = $this->occational->dateConvert($purchases_list[$j]['purchase_date']);
                $j++;
            }

            $i = 0;
            foreach ($purchases_list as $k => $v) {
                $i++;
                $purchases_list[$k]['sl'] = $i;
            }
        }
        $currency_details = $this->Soft_settings->retrieve_currency_info();
        $data = array(
            'title' => display('manage_purchase'),
            'purchases_list' => $purchases_list,
            'currency' => $currency_details[0]['currency_icon'],
            'position' => $currency_details[0]['currency_position'],
        );

        $data['setting'] = $this->Template_model->setting();
        $data['module'] = "dashboard";
        $data['page'] = 'purchase/purchase';
        $this->parser->parse('template/layout', $data);

    }


    //Insert Purchase and uload
    public function insert_purchase()
    {
        $this->permission->check_label('add_purchase')->create()->redirect();

        $this->Purchases->purchase_entry();
        $this->session->set_userdata(array('message' => display('successfully_added')));
        if (isset($_POST['add-purchase'])) {
            redirect(base_url('dashboard/Cpurchase/manage_purchase'));
        } elseif (isset($_POST['add-purchase-another'])) {
            redirect(base_url('dashboard/Cpurchase'));
        }
    }


    //Purchase Update Form
    public function purchase_update_form($purchase_id)
    {
        $this->permission->check_label('manage_purchase')->update()->redirect();

        $purchase_detail = $this->Purchases->retrieve_purchase_editdata($purchase_id);
        $supplier_id = $purchase_detail[0]['supplier_id'];
        $supplier_list = $this->Suppliers->supplier_list();
        $supplier_selected = $this->Suppliers->supplier_search_item($supplier_id);
        $this->load->model('Wearhouses');
        $wearhouse_list = $this->Wearhouses->wearhouse_list();
        $store_list = $this->Stores->store_list();
        $variant_list = $this->Variants->variant_list();

        if (!empty($purchase_detail)) {
            $i = 0;
            foreach ($purchase_detail as $k => $v) {
                $i++;
                $purchase_detail[$k]['sl'] = $i;
            }
        }

        $data = array(
            'title' => display('purchase_edit'),
            'purchase_id' => $purchase_detail[0]['purchase_id'],
            'invoice_no' => $purchase_detail[0]['invoice_no'],
            'supplier_name' => $purchase_detail[0]['supplier_name'],
            'supplier_id' => $purchase_detail[0]['supplier_id'],
            'grand_total' => $purchase_detail[0]['grand_total_amount'],
            'purchase_details' => $purchase_detail[0]['purchase_details'],
            'purchase_date' => $purchase_detail[0]['purchase_date'],
            'store_id' => $purchase_detail[0]['store_id'],
            'wearhouse_id' => $purchase_detail[0]['wearhouse_id'],
            'variant_id' => $purchase_detail[0]['variant_id'],
            'purchase_info' => $purchase_detail,
            'supplier_list' => $supplier_list,
            'supplier_selected' => $supplier_selected,
            'wearhouse_list' => $wearhouse_list,
            'store_list' => $store_list,
            'variant_list' => $variant_list,
        );

        $data['setting'] = $this->Template_model->setting();
        $data['module'] = "dashboard";
        $data['page'] = 'purchase/edit_purchase_form';
        $this->parser->parse('template/layout', $data);

    }


    //Purchase Update
    public function purchase_update()
    {
        $this->permission->check_label('manage_purchase')->update()->redirect();

        $this->Purchases->update_purchase();
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('dashboard/Cpurchase/manage_purchase'));
    }


    // Purchase delete
    public function purchase_delete($purchase_id)
    {
        $this->permission->check_label('manage_purchase')->delete()->redirect();
        $this->Purchases->delete_purchase($purchase_id);
        $this->session->set_userdata(array('message' => display('successfully_delete')));
        redirect('dashboard/Cpurchase/manage_purchase');
    }


    //Purchase item by search
    public function purchase_item_by_search()
    {
        $supplier_id = $this->input->post('supplier_id',TRUE);
        $purchases_list = $this->Purchases->purchase_by_search($supplier_id);
        $j = 0;
        if (!empty($purchases_list)) {
            foreach ($purchases_list as $k => $v) {
                $purchases_list[$k]['final_date'] = $this->occational->dateConvert($purchases_list[$j]['purchase_date']);
                $j++;
            }
            $i = 0;
            foreach ($purchases_list as $k => $v) {
                $i++;
                $purchases_list[$k]['sl'] = $i;
            }
        }
        $data = array(
            'purchases_list' => $purchases_list
        );
        $data['setting'] = $this->Template_model->setting();
        $data['module'] = "dashboard";
        $data['page'] = 'purchase/purchase';
        $this->parser->parse('template/layout', $data);

    }


    //Purchase search by supplier id
    public function product_search_by_supplier()
    {

        $supplier_id = $this->input->post('supplier_id',TRUE);
        $product_name = $this->input->post('product_name',TRUE);
        $product_info = $this->Suppliers->product_search_item($supplier_id, $product_name);

        $list[''] = "";
        foreach ($product_info as $value) {
            $json_product[] = array('label' => $value['product_name'] . '-(' . $value['product_model'] . ')', 'value' => $value['product_id']);
        }
        echo json_encode($json_product);
    }


    // Retrieve Purchase Data
    public function retrieve_product_data()
    {
        $product_id = $this->input->post('product_id',TRUE);
        $product_info = $this->Purchases->get_total_product($product_id);
        echo json_encode($product_info);
    }


    //Retrive right now inserted data to cretae html
    public function purchase_details_data($purchase_id)
    {
        $purchase_detail = $this->Purchases->purchase_details_data($purchase_id);

        if (!empty($purchase_detail)) {
            $i = 0;
            foreach ($purchase_detail as $k => $v) {
                $i++;
                $purchase_detail[$k]['sl'] = $i;
            }

            foreach ($purchase_detail as $k => $v) {
                $purchase_detail[$k]['convert_date'] = $this->occational->dateConvert($purchase_detail[$k]['purchase_date']);
            }

        }
        $currency_details = $this->Soft_settings->retrieve_currency_info();
        $company_info = $this->Purchases->retrieve_company();
        $data = array(
            'title' => display('purchase_ledger'),
            'purchase_id' => $purchase_detail[0]['purchase_id'],
            'purchase_details' => $purchase_detail[0]['purchase_details'],
            'supplier_name' => $purchase_detail[0]['supplier_name'],
            'final_date' => $purchase_detail[0]['convert_date'],
            'sub_total_amount' => $purchase_detail[0]['grand_total_amount'],
            'invoice_no' => $purchase_detail[0]['invoice_no'],
            'purchase_all_data' => $purchase_detail,
            'company_info' => $company_info,
            'currency' => $currency_details[0]['currency_icon'],
            'position' => $currency_details[0]['currency_position'],
        );

        $data['setting'] = $this->Template_model->setting();
        $data['module'] = "dashboard";
        $data['page'] = 'purchase/purchase_detail';
        $this->parser->parse('template/layout', $data);

    }
    // Get variant price and stock
    public function check_admin_2d_variant_info()
    {
        $product_id = $this->input->post('product_id',TRUE);
        $store_id = $this->input->post('store_id',TRUE);
        $variant_id = $this->input->post('variant_id',TRUE);
        $variant_color = $this->input->post('variant_color',TRUE);

        $stock = $this->Purchases->check_variant_wise_stock($product_id, $store_id, $variant_id, $variant_color);

        if ($stock > 0) {
            $result[0] = "yes";
            $price = $this->Purchases->check_variant_wise_price($product_id, $variant_id, $variant_color);

            $result[1] = $stock; //stock
            $result[2] = floatval($price['price']); //price
            $result[3] = 0; //discount

        } else {
            $result[0] = 'no';
        }
        echo json_encode($result);
    }


    //Stock in available
    public function available_stock()
    {

        $product_id = $this->input->post('product_id',TRUE);
        $store_id = $this->input->post('store_id',TRUE);
        $variant_id = $this->input->post('variant_id',TRUE);
        $variant_color = $this->input->post('variant_color',TRUE);

        $this->db->select('SUM(a.quantity) as total_purchase');
        $this->db->from('transfer a');
        $this->db->where('a.product_id', $product_id);
        $this->db->where('a.store_id', $store_id);
        $this->db->where('a.variant_id', $variant_id);
        if(!empty($variant_color)){
            $this->db->where('a.variant_color', $variant_color);
        }
        $total_purchase = $this->db->get()->row();

        $this->db->select('SUM(b.quantity) as total_sale');
        $this->db->from('invoice_details b');
        $this->db->where('b.product_id', $product_id);
        $this->db->where('b.store_id', $store_id);
        $this->db->where('b.variant_id', $variant_id);
        if(!empty($variant_color)){
            $this->db->where('b.variant_color', $variant_color);
        }
        $total_sale = $this->db->get()->row();

        echo $total_purchase->total_purchase - $total_sale->total_sale;
    }


    //check stock product quantity
    public function check_product_stock()
    {

        $product_id = $this->input->post('product_id',TRUE);
        $variant_id = $this->input->post('variant_id',TRUE);
        $store_id = $this->input->post('store_id',TRUE);
        $variant_color = $this->input->post('variant_color',TRUE);
        
        $this->db->select('SUM(a.quantity) as total_purchase');
        $this->db->from('transfer a');
        $this->db->where('a.product_id', $product_id);
        $this->db->where('a.variant_id', $variant_id);
         if(!empty($variant_color)){
            $this->db->where('a.variant_color', $variant_color);
        }
        $this->db->where('a.store_id', $store_id);
        $total_purchase = $this->db->get()->row();

        $this->db->select('SUM(b.quantity) as total_sale');
        $this->db->from('invoice_details b');
        $this->db->where('b.product_id', $product_id);
        $this->db->where('b.variant_id', $variant_id);
         if(!empty($variant_color)){
            $this->db->where('b.variant_color', $variant_color);
        }
        $this->db->where('b.store_id', $store_id);
        $total_sale = $this->db->get()->row();

        echo $total_purchase->total_purchase - $total_sale->total_sale;
    }


    //Wearhouse available stock check
    public function wearhouse_available_stock()
    {

        $product_id = $this->input->post('product_id',TRUE);
        $variant_id = $this->input->post('variant_id',TRUE);
        $variant_color = $this->input->post('variant_color',TRUE);
        $store_id = $this->input->post('store_id',TRUE);
        $purchase_to = $this->input->post('purchase_to');

        $this->db->select('SUM(a.quantity) as total_purchase');
        $this->db->from('transfer a');
        $this->db->where('a.product_id', $product_id);
        $this->db->where('a.variant_id', $variant_id);
        if(!empty($variant_color)){
            $this->db->where('a.variant_color', $variant_color);
        }
        $this->db->where('a.store_id', $store_id);
        $total_purchase = $this->db->get()->row();

        $this->db->select('SUM(b.quantity) as total_sale');
        $this->db->from('invoice_details b');
        $this->db->where('b.product_id', $product_id);
        $this->db->where('b.variant_id', $variant_id);
        if(!empty($variant_color)){
            $this->db->where('b.variant_color', $variant_color);
        }
        $this->db->where('b.store_id', $store_id);
        $total_sale = $this->db->get()->row();

        echo $total_purchase->total_purchase - $total_sale->total_sale;
    }

    // check default store is or not
    public function check_default_store()
    {
        $store_id =  $this->input->post('store_id', TRUE);
        $result = false;
        if(!empty($store_id)){
            $this->db->where('store_id', $store_id);
            $this->db->where('default_status', 1);
            $query = $this->db->get('store_set');
            if($query->num_rows() > 0){
                $result = TRUE;
            }
        }
        echo $result;
    }
}