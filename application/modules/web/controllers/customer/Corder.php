<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Corder extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->user_auth->check_customer_auth();
        $this->load->library('web/customer/Lorder');
        $this->load->model([
            'web/customer/Orders',
            'dashboard/Soft_settings'
        ]);

        $this->load->library('occational');
    }

    //Index page load first
    public function index()
    {
        $content = $this->lorder->order_add_form();
        $this->template_lib->full_customer_html_view($content);
    }

    //Add new order
    public function new_order()
    {
        $data = array(
            'title' => display('new_order'),
        );

        $data['Soft_settings'] = $this->Soft_settings->retrieve_setting_editdata();
        $data['module'] = "web";
        $data['page'] = "customer/order/add_order_form";
        $this->parser->parse('customer/customer_html_template', $data);

    }

    //Insert order
    public function insert_order()
    {
        $order_id = $this->Orders->order_entry();
        $this->session->set_userdata(array('message' => display('successfully_added')));
        $this->order_inserted_data($order_id);
        redirect(base_url('web/customer/Corder/manage_order'));
    }

    //Retrive right now inserted data to cretae html
    public function order_inserted_data($order_id)
    {


        $order_detail = $this->Orders->retrieve_order_html_data($order_id);

        $subTotal_quantity = 0;
        $subTotal_cartoon = 0;
        $subTotal_discount = 0;

        if (!empty($order_detail)) {
            foreach ($order_detail as $k => $v) {
                $order_detail[$k]['final_date'] = $this->occational->dateConvert($order_detail[$k]['date']);
                $subTotal_quantity = $subTotal_quantity + $order_detail[$k]['quantity'];
            }
            $i = 0;
            foreach ($order_detail as $k => $v) {
                $i++;
                $order_detail[$k]['sl'] = $i;
            }
        }

        $currency_details = $this->Soft_settings->retrieve_currency_info();
        $company_info = $this->Orders->retrieve_company();
        $data = array(
            'title' => display('order_details'),
            'order_id' => $order_detail[0]['order_id'],
            'order_no' => $order_detail[0]['order'],
            'customer_name' => $order_detail[0]['customer_name'],
            'customer_mobile' => $order_detail[0]['customer_mobile'],
            'customer_email' => $order_detail[0]['customer_email'],
            'customer_address' => $order_detail[0]['customer_short_address'],
            'final_date' => $order_detail[0]['final_date'],
            'total_amount' => $order_detail[0]['total_amount'],
            'order_discount' => $order_detail[0]['order_discount'],
            'paid_amount' => $order_detail[0]['paid_amount'],
            'due_amount' => $order_detail[0]['due_amount'],
            'details' => $order_detail[0]['details'],
            'subTotal_quantity' => $subTotal_quantity,
            'order_all_data' => $order_detail,
            'company_info' => $company_info,
            'currency' => $currency_details[0]['currency_icon'],
            'position' => $currency_details[0]['currency_position'],
        );


        $data['Soft_settings'] = $this->Soft_settings->retrieve_setting_editdata();
        $data['module'] = "web";
        $data['page'] = "customer/order/order_pdf";
        $chapterList = $this->parser->parse('customer/customer_html_template', $data, true);

        $this->load->library('pdfgenerator');
        $file_path = $this->pdfgenerator->generate_order($order_id, $chapterList);

        //File path save to database
        $this->db->set('file_path', base_url($file_path));
        $this->db->where('order_id', $order_id);
        $this->db->update('order');

        $send_email = '';
        if (!empty($data['customer_email'])) {
            $send_email = $this->setmail($data['customer_email'], $file_path);
        }

        if ($send_email != null) {
            return true;
        } else {
            return false;
        }


    }


    //Send Customer Email with invoice
    public function setmail($email, $file_path)
    {


        $setting_detail = $this->Soft_settings->retrieve_email_editdata();

        $subject = display("order_information");
        $message = display("order_info_details") . '<br>' . base_url();

        $config = array(
            'protocol' => $setting_detail[0]['protocol'],
            'smtp_host' => $setting_detail[0]['smtp_host'],
            'smtp_port' => $setting_detail[0]['smtp_port'],
            'smtp_user' => $setting_detail[0]['sender_email'],
            'smtp_pass' => $setting_detail[0]['password'],
            'mailtype' => $setting_detail[0]['mailtype'],
            'charset' => 'utf-8'
        );

        $this->load->library('email');
        $this->email->initialize($config);

        $this->email->set_newline("\r\n");
        $this->email->from($setting_detail[0]['sender_email']);
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->attach($file_path);

        $check_email = $this->test_input($email);
        if (filter_var($check_email, FILTER_VALIDATE_EMAIL)) {
            if ($this->email->send()) {
                $this->session->set_userdata(array('message' => display('email_send_to_customer')));
                return true;
            } else {
                $this->session->set_userdata(array('error_message' => display('email_not_send')));
                redirect(base_url('web/customer/Corder/manage_order'));
            }
        } else {
            $this->session->set_userdata(array('message' => display('successfully_added')));
            return true;
        }
    }

//Email testing for email
    public function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Retrive product data
    public function retrieve_product_data()
    {
        $product_id = $this->input->post('product_id',TRUE);
        $product_info = $this->Orders->get_total_product($product_id);
        echo json_encode($product_info);
    }

    // Get variant price and stock
    public function check_customer_2d_variant_info()
    {
        $product_id = $this->input->post('product_id',TRUE);
        $store_id = $this->input->post('store_id',TRUE);
        $variant_id = $this->input->post('variant_id',TRUE);
        $variant_color = $this->input->post('variant_color',TRUE);

        $stock = $this->Orders->check_variant_wise_stock($product_id, $store_id, $variant_id, $variant_color);

        if ($stock > 0) {
            $result[0] = "yes";
            $price = $this->Orders->check_variant_wise_price($product_id, $variant_id, $variant_color);

            $result[1] = $stock; //stock
            $result[2] = floatval($price['price']); //price
            $result[3] = 0; //discount

        } else {
            $result[0] = 'no';
        }
        echo json_encode($result);
    }


    //Stock available check
    public function available_stock()
    {

        $product_id = $this->input->post('product_id',TRUE);
        $variant_id = $this->input->post('variant_id',TRUE);
        $store_id = $this->input->post('store_id',TRUE);

        $this->db->select('SUM(a.quantity) as total_purchase');
        $this->db->from('product_purchase_details a');
        $this->db->where('a.product_id', $product_id);
        $this->db->where('a.variant_id', $variant_id);
        $this->db->where('a.store_id', $store_id);
        $total_purchase = $this->db->get()->row();

        $this->db->select('SUM(b.quantity) as total_sale');
        $this->db->from('invoice_details b');
        $this->db->where('b.product_id', $product_id);
        $this->db->where('b.variant_id', $variant_id);
        $this->db->where('b.store_id', $store_id);
        $total_sale = $this->db->get()->row();

        echo $total_purchase->total_purchase - $total_sale->total_sale;
    }

    //Manage order
    public function manage_order()
    {
        $content = $this->lorder->order_list();
        $this->template_lib->full_customer_html_view($content);
    }

}