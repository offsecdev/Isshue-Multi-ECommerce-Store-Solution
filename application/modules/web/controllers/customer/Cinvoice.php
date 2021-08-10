<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cinvoice extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model([
            'web/customer/Invoices',
            'web/customer/Orders',
            'dashboard/Soft_settings',
            'dashboard/Shipping_methods',

        ]);
        $this->load->library('occational');
        $this->load->library('web/customer/linvoice');
        $this->user_auth->check_customer_auth();
    }

    //Cinvoice default index load
    public function index()
    {
        $content = $this->linvoice->invoice_add_form();
        $this->template_lib->full_customer_html_view($content);
    }

    //Manage invoice
    public function manage_invoice()
    {


        $invoices_list = $this->Invoices->invoice_list();
        if (!empty($invoices_list)) {
            foreach ($invoices_list as $k => $v) {
                $invoices_list[$k]['final_date'] = $this->occational->dateConvert($invoices_list[$k]['date']);
            }
            $i = 0;
            foreach ($invoices_list as $k => $v) {
                $i++;
                $invoices_list[$k]['sl'] = $i;
            }
        }
        $currency_details = $this->Soft_settings->retrieve_currency_info();
        $Soft_settings = $this->Soft_settings->retrieve_setting_editdata();
        $data = array(
            'title' => display('manage_invoice'),
            'invoices_list' => $invoices_list,
            'currency' => $currency_details[0]['currency_icon'],
            'position' => $currency_details[0]['currency_position'],
            'Soft_settings' => $Soft_settings,
        );

        $data['module'] = "web";
        $data['page'] = "customer/invoice/invoice";
        $this->parser->parse('customer/customer_html_template', $data);


    }

    //Retrive right now inserted data to cretae html
    public function invoice_inserted_data($invoice_id)
    {

        $invoice_detail = $this->Invoices->retrieve_invoice_html_data($invoice_id);

        $shipping_method = $this->Shipping_methods->shipping_method_search_item($invoice_detail[0]['shipping_method']);

        $subTotal_quantity = 0;
        $subTotal_cartoon = 0;
        $subTotal_discount = 0;

        if (!empty($invoice_detail)) {
            foreach ($invoice_detail as $k => $v) {
                $invoice_detail[$k]['final_date'] = $this->occational->dateConvert($invoice_detail[$k]['date']);
                $subTotal_quantity = $subTotal_quantity + $invoice_detail[$k]['quantity'];
            }
            $i = 0;
            foreach ($invoice_detail as $k => $v) {
                $i++;
                $invoice_detail[$k]['sl'] = $i;
            }
        }

        $currency_details = $this->Soft_settings->retrieve_currency_info();
        $company_info = $this->Orders->retrieve_company();
        $data = array(
            'title' => display('invoice_details'),
            'invoice_id' => $invoice_detail[0]['invoice_id'],
            'invoice_no' => $invoice_detail[0]['invoice'],
            'customer_name' => $invoice_detail[0]['customer_name'],
            'customer_mobile' => $invoice_detail[0]['customer_mobile'],
            'customer_email' => $invoice_detail[0]['customer_email'],
            'final_date' => $invoice_detail[0]['final_date'],
            'total_amount' => $invoice_detail[0]['total_amount'],
            'invoice_discount' => $invoice_detail[0]['invoice_discount'],
            'total_discount' => $invoice_detail[0]['total_discount'],
            'service_charge' => $invoice_detail[0]['service_charge'],
            'shipping_charge' => $invoice_detail[0]['shipping_charge'],
            'shipping_method' => $shipping_method[0]['method_name'],
            'paid_amount' => $invoice_detail[0]['paid_amount'],
            'due_amount' => $invoice_detail[0]['due_amount'],
            'details' => $invoice_detail[0]['invoice_details'],
            'subTotal_quantity' => $subTotal_quantity,
            'invoice_all_data' => $invoice_detail,
            'company_info' => $company_info,
            'currency' => $currency_details[0]['currency_icon'],
            'position' => $currency_details[0]['currency_position'],
            'Soft_settings' => $this->Soft_settings->retrieve_setting_editdata()
        );

        $data['module'] = "web";
        $data['page'] = "customer/invoice/invoice_html";
        $this->parser->parse('customer/customer_html_template', $data);

    }
}