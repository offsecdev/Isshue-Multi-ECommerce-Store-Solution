<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cinvoice extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->auth->check_user_auth();
        $this->load->model(array('dashboard/Invoices'));
        $this->load->library('dashboard/linvoice');
        $this->load->library('dashboard/occational');
    }

    //Default invoice add from loading
    public function index()
    {
        $this->new_invoice();
    }

    //Add new invoice
    public function new_invoice()
    {
        $this->permission->check_label('new_sale')->create()->redirect();

        $this->load->model(array(
            'dashboard/Stores',
            'dashboard/Variants',
            'dashboard/Customers',
            'dashboard/Shipping_methods'
        ));
        $store_list = $this->Stores->store_list();
        $variant_list = $this->Variants->variant_list();
        $shipping_methods = $this->Shipping_methods->shipping_method_list();
        $customer = $this->Customers->customer_list();

        $data = array(
            'title' => display('new_invoice'),
            'store_list' => $store_list,
            'variant_list' => $variant_list,
            'customer' => $customer[0],
            'shipping_methods' => $shipping_methods
        );

        $data['module'] = "dashboard";
        $data['page'] = "invoice/add_invoice_form";
        echo Modules::run('template/layout', $data);
    }

    public function manage_invoice()
    {
        $this->permission->check_label('manage_sale')->read()->redirect();

        $filter = array(
            'invoice_no' => $this->input->get('invoice_no', TRUE),
            'customer_id' => $this->input->get('customer_id', TRUE),
            'date' => $this->input->get('date', TRUE),
            'invoice_status' => $this->input->get('invoice_status', TRUE)
        );
        $config["base_url"]    = base_url('dashboard/Cinvoice/manage_invoice');
        $config["total_rows"]  = $this->Invoices->count_invoice_list($filter);
        $config["per_page"]    = 20;
        $config["uri_segment"] = 4;
        $config["num_links"]   = 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open']    = "<ul class='pagination'>";
        $config['full_tag_close']   = "</ul>";
        $config['num_tag_open']     = '<li>';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']     = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close']    = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open']    = "<li>";
        $config['next_tag_close']   = "</li>";
        $config['prev_tag_open']    = "<li>";
        $config['prev_tagl_close']  = "</li>";
        $config['first_tag_open']   = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open']    = "<li>";
        $config['last_tagl_close']  = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $links = $this->pagination->create_links();
        $invoices_list = $this->Invoices->get_invoice_list($filter, $page, $config["per_page"]);
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
        $this->load->model(array('dashboard/Soft_settings','dashboard/Customers'));
        $currency_details = $this->Soft_settings->retrieve_currency_info();
        $data = array(
            'title'         => display('manage_invoice'),
            'invoices_list' => $invoices_list,
            'currency'      => $currency_details[0]['currency_icon'],
            'position'      => $currency_details[0]['currency_position'],
            'links'         => $links
        );

        $data['module'] = "dashboard";
        $data['page']   = "invoice/invoice";
        echo Modules::run('template/layout', $data);

    }

    //Insert new invoice
    public function insert_invoice()
    {

        $invoice_id = $this->Invoices->invoice_entry();
        $this->session->set_userdata(array('message' => display('successfully_added')));
        if ($this->input->post('pos',TRUE) === 'pos') {
            redirect('dashboard/Cinvoice/pos_invoice_inserted_data_redirect/' . $invoice_id . '?place=pos');
        }else{
            redirect('dashboard/Cinvoice/invoice_inserted_data/'. $invoice_id);
        }
    }

    //Invoice Update Form
    public function invoice_update_form($invoice_id)
    {
        $this->permission->check_label('manage_sale')->update()->redirect();

        $content = $this->linvoice->invoice_edit_data($invoice_id);
        $this->template_lib->full_admin_html_view($content);

    }

    // Invoice Update
    public function invoice_update()
    {
        $this->permission->check_label('manage_sale')->update()->redirect();

        $invoice_id = $this->Invoices->update_invoice();
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect('dashboard/cinvoice/invoice_inserted_data/'.$invoice_id);
    }

    //Retrive right now inserted data to cretae html
    public function invoice_inserted_data($invoice_id)
    {
        $this->permission->check_label('new_sale')->redirect();

        $content = $this->linvoice->invoice_html_data($invoice_id);
        $this->template_lib->full_admin_html_view($content);

    }

    //POS invoice page load
    public function pos_invoice()
    {
        $this->permission->check_label('pos_sale')->read()->redirect();

         $content = $this->linvoice->pos_invoice_add_form();
        $this->template_lib->full_admin_html_view($content);
    }

    //Insert pos invoice
    public function insert_pos_invoice()
    {

        $product_id = $this->input->post('product_id',TRUE);
        $stok_report = $this->Invoices->stock_report_bydate_pos($product_id);

        if ($stok_report > 0) {
            $product_details = $this->Invoices->get_total_product($product_id);
            $html = "";
            if (!empty($product_details['variant'])) {
                $html = $product_details['variant'];
            }


            $tr = " ";
            $order = " ";
            $bill = " ";
            if (!empty($product_details)) {
                $product_id = $this->auth->generator(5);

                 $colorhtml = '';
                if (!empty($product_details['colorhtml'])) {
                    $colorhtml = "<select name=\"color_variant[]\" id=\"variant_color_" . $product_id . "\" class=\"form-control variant_color width_80\" >" . $product_details['colorhtml'] . "</select>";
                }

                $tr .= "<tr id='" . $product_id . "'>
				<th id=\"product_name_" . $product_id . "\">" . $product_details['product_name'] . "</th>

				<td>
				<script>
				$(\"select.form-control:not(.dont-select-me)\").select2({
					placeholder: \"Select option\",
					allowClear: true
					});
					</script>
					<input type=\"hidden\" class=\"sl\" value=" . $product_id . ">
					<input type=\"hidden\" class=\"product_id_" . $product_id . "\" value=" . $product_details['product_id'] . ">
					<select name=\"variant_id[]\" id=\"variant_id_" . $product_id . "\" class=\"form-control variant_id width_80\" required=\"\">" . $html . "</select> 
                    ".$colorhtml."
					</td>
					<td>
					<input type=\"text\" name=\"available_quantity[]\" id=\"avl_qntt_" . $product_id . "\" 
                class=\"form-control text-right width_60  available_quantity_" . $product_id . "\" value=\"0\" readonly=\"readonly\"/>
					</td>
					<td width=\"\">
					<input type=\"hidden\" class=\"form-control product_id_" . $product_id . "\" name=\"product_id[]\" value = '" . $product_details['product_id'] . "' id=\"product_id_" . $product_id . "\"/>

					<input type=\"text\" name=\"product_rate[]\" value='" . $product_details['price'] . "' id=\"price_item_" . $product_id . "\" class=\"price_item width_60" . $product_id . " form-control text-right\" min=\"0\" readonly=\"readonly\"/>

					<input type=\"hidden\" name=\"\" id=\"\" class=\"form-control text-right unit_" . $product_id . "\" value='" . $product_details['unit'] . "' readonly=\"readonly\" />

					<input type=\"hidden\" name=\"discount[]\" id=\"discount_" . $product_id . "\" class=\"form-control text-right\" value ='" . $product_details['discount'] . "' min=\"0\"/>
					</td>
					<td scope=\"row\">
					<input type=\"number\" name=\"product_quantity[]\"   onchange=\"quantity_limit('" . $product_id . "')\" onkeyup=\"quantity_calculate('"
                    . $product_id . "');\" onchange=\"quantity_calculate('" . $product_id . "');\" id=\"total_qntt_" . $product_id . "\" class=\"form-control text-right width_50\" value=\"1\" min=\"1\"/>
					</td>
					<td width=\"\">
					<input class=\"total_price form-control text-right width_70\" type=\"text\" name=\"total_price[]\" id=\"total_price_" . $product_id . "\" value='" . $product_details['price'] . "'  readonly=\"readonly\"/>
					</td>

					<td width:\"300\">";

                $this->db->select('*');
                $this->db->from('tax');
                $this->db->order_by('tax_name', 'asc');
                $tax_information = $this->db->get()->result();

                if (!empty($tax_information)) {
                    foreach ($tax_information as $k => $v) {
                        if ($v->tax_id == 'H5MQN4NXJBSDX4L') {
                            $tax['cgst_name'] = $v->tax_name;
                            $tax['cgst_id'] = $v->tax_id;
                            $tax['cgst_status'] = $v->status;
                        } elseif ($v->tax_id == '52C2SKCKGQY6Q9J') {
                            $tax['sgst_name'] = $v->tax_name;
                            $tax['sgst_id'] = $v->tax_id;
                            $tax['sgst_status'] = $v->status;
                        } elseif ($v->tax_id == '5SN9PRWPN131T4V') {
                            $tax['igst_name'] = $v->tax_name;
                            $tax['igst_id'] = $v->tax_id;
                            $tax['igst_status'] = $v->status;
                        }
                    }
                }

                if ($tax['cgst_status'] == 1) {

                    $tr .= "<input type=\"hidden\" id=\"cgst_" . $product_id . "\" class=\"cgst\" value='" . $product_details['cgst_tax'] . "'/>
						<input type=\"hidden\" id=\"total_cgst_" . $product_id . "\" class=\"total_cgst\" name=\"cgst[]\" value='" . $product_details['cgst_tax'] * $product_details['price'] . "'/>
						<input type=\"hidden\" name=\"cgst_id[]\" id=\"cgst_id_" . $product_id . "\" value='" . $product_details['cgst_id'] . "'/>";
                }
                if ($tax['sgst_status'] == 1) {

                    $tr .= "<input type=\"hidden\" id=\"sgst_" . $product_id . "\" class=\"sgst\" value='" . $product_details['sgst_tax'] . "'/>
						<input type=\"hidden\" id=\"total_sgst_" . $product_id . "\" class=\"total_sgst\" name=\"sgst[]\" value='" . $product_details['sgst_tax'] * $product_details['price'] . "'/>
						<input type=\"hidden\" name=\"sgst_id[]\" id=\"sgst_id_" . $product_id . "\" value='" . $product_details['sgst_id'] . "'/>";
                }
                if ($tax['igst_status'] == 1) {

                    $tr .= "<input type=\"hidden\" id=\"igst_" . $product_id . "\" class=\"igst\" value='" . $product_details['igst_tax'] . "'/>
						<input type=\"hidden\" id=\"total_igst_" . $product_id . "\" class=\"total_igst\" name=\"igst[]\" value='" . $product_details['igst_tax'] * $product_details['price'] . "'/>
						<input type=\"hidden\" name=\"igst_id[]\" id=\"igst_id_" . $product_id . "\" value='" . $product_details['igst_id'] . "'/>";
                }

                $tr .= "<input type=\"hidden\" id=\"total_discount_" . $product_id . "\" class=\"\" />
					<input type=\"hidden\" id=\"all_discount_" . $product_id . "\" class=\"total_discount\"/>



					<a href=\"#\" class=\"ajax_modal btn btn-primary btn-xs m-r-2\" data-toggle=\"modal\" data-target=\"#myModal\"><i class=\"fa fa-pencil\" data-toggle=\"tooltip\" data-placement=\"left\" title='" . display('edit') . "'></i></a>

					<a href=\"#\" class=\"btn btn-danger btn-xs\" data-toggle=\"tooltip\" data-placement=\"top\" title='" . display('delete') . "' onclick=\"deletePosRow('" . $product_id . "')\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></a>
					</td>
					</tr>";

                $order .= "<tr class='" . $product_id . "' data-item-id='" . $product_id . "'>
					<td>0</td>
					<td>" . $product_details['product_model'] . "-" . $product_details['product_name'] . "</td>
					<td id='quantity_" . $product_id . "'>[ 1 ]</td>
					</tr>";

                $bill .= "<tr class='" . $product_id . "' data-item-id='" . $product_id . "'>
					<td>0</td>
					<td colspan=\"2\" class=\"no-border\">" . $product_details['product_model'] . "-" . $product_details['product_name'] . "</td>
					<td class='qnt_price_" . $product_id . "'>(1 x " . $product_details['price'] . ")</td>
					<td class='total_price_bill_" . $product_id . " text-right'>" . $product_details['price'] . "</td>
					</tr>";

                echo json_encode(array(
                    'item' => $tr,
                    'order' => $order,
                    'bill' => $bill,
                    'product_id' => $product_id
                ));
            } else {
                echo json_encode(array(
                    'item' => 0
                ));
            }
        } else {
            echo json_encode(array(
                'item' => 0
            ));
        }
    }

    //Retrive right now inserted data to cretae html
    public function pos_invoice_inserted_data($invoice_id)
    {
        $this->permission->check_label('pos_sale')->read()->redirect();

        $content = $this->linvoice->pos_invoice_html_data($invoice_id);
        $this->template_lib->full_admin_html_view($content);
    }

    public function pos_invoice_inserted_data_redirect($invoice_id)
    {
        $this->permission->check_label('pos_sale')->read()->redirect();

        $this->load->library('dashboard/linvoice');
        $this->linvoice->pos_invoice_html_data_redirect($invoice_id);

    }

    // Retrieve product data
    public function retrieve_product_data()
    {
        $product_id = $this->input->post('product_id',TRUE);
        $product_info = $this->Invoices->get_total_product($product_id);
        echo json_encode($product_info);
    }

    // Invoice Delete
    public function invoice_delete($invoice_id)
    {
        $this->permission->check_label('manage_sale')->delete()->redirect();

        $result = $this->Invoices->delete_invoice($invoice_id);
        if ($result) {
            $this->session->set_userdata(array('message' => display('successfully_delete')));
        }else{
            $this->session->set_userdata(array('error_message' => display('failed_try_again')));
        }
        redirect('dashboard/Cinvoice/manage_invoice');
    }

    //AJAX INVOICE STOCK Check
    public function product_stock_check($product_id)
    {

        $purchase_stocks = $this->Invoices->get_total_purchase_item($product_id);
        $total_purchase = 0;
        if (!empty($purchase_stocks)) {
            foreach ($purchase_stocks as $k => $v) {
                $total_purchase = ($total_purchase + $purchase_stocks[$k]['quantity']);
            }
        }
        $sales_stocks = $this->Invoices->get_total_sales_item($product_id);
        $total_sales = 0;
        if (!empty($sales_stocks)) {
            foreach ($sales_stocks as $k => $v) {
                $total_sales = ($total_sales + $sales_stocks[$k]['quantity']);
            }
        }

        $final_total = ($total_purchase - $total_sales);
        return $final_total;
    }

    //Search product by product name and category
    public function search_product()
    {
        $product_name = $this->input->post('product_name',TRUE);
        $category_id = $this->input->post('category_id',TRUE);
        $product_search = $this->Invoices->product_search($product_name, $category_id);
        $base_url = base_url();
        if ($product_search) {
            foreach ($product_search as $product) {
                echo "<div class=\"col-xs-6 col-sm-4 col-md-2 col-p-3\">";
                echo "<div class=\"panel panel-bd product-panel select_product\">";
                echo "<div class=\"panel-body\">";
                echo "<img src=\"$base_url$product->image_thumb\" class=\"img-responsive\" alt=\"\">";
                echo "<input type=\"hidden\" name=\"select_product_id\" class=\"select_product_id\" value='" . $product->product_id . "'>";
                echo "</div>";
                echo "<div class=\"panel-footer\">$product->product_name - ($product->product_model)</div>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "420";
        }
    }

    //Insert new customer
    public function insert_customer()
    {

        $customer_id = generator(15);
        //Customer  basic information adding.
        $data = array(
            'customer_id' => $customer_id,
            'customer_name' => $this->input->post('customer_name',TRUE),
            'customer_mobile' => $this->input->post('mobile',TRUE),
            'customer_email' => $this->input->post('email',TRUE),
            'status' => 1
        );

        $result = $this->Invoices->customer_entry($data);
        if ($result == TRUE) {
            $this->session->set_userdata(array('message' => display('successfully_added')));
            redirect(base_url('dashboard/Cinvoice/pos_invoice'));
        } else {
            $this->session->set_userdata(array('error_message' => display('already_exists')));
            redirect(base_url('dashboard/Cinvoice/pos_invoice'));
        }
    }

    //Update status
    public function update_status($invoice_id)
    {

        $this->load->model('dashboard/Soft_settings');

        $invoice_status = $this->input->post('invoice_status',TRUE);
        $order_no = $this->input->post('order_no',TRUE);
        $order_id = $this->input->post('order_id',TRUE);
        $customer_id = $this->input->post('customer_id',TRUE);

        if ($invoice_status == 1) {
            $invoice_status_text = "Shipped";//for send sms

        };

        if ($invoice_status == 5) {
            $invoice_status_text = "Processing"; //for send sms
        };


        if (($invoice_status == 6) || ($invoice_status == 2)) { //6== product return or cancel
            //Delete order table
            $this->db->where('order_id', $order_id);
            $this->db->delete('order');
            //Delete order_details table
            $this->db->where('order_id', $order_id);
            $this->db->delete('order_details');
            //Order tax summary delete
            $this->db->where('order_id', $order_id);
            $this->db->delete('order_tax_col_summary');
            //Order tax details delete
            $this->db->where('order_id', $order_id);
            $this->db->delete('order_tax_col_details');

            //invoice details delete
            $this->db->where('invoice_id', $invoice_id);
            $this->db->delete('invoice_details');

            //invoice  delete
            $this->db->where('invoice_id', $invoice_id);
            $this->db->delete('invoice');
            //customer ledger
            $this->db->where('invoice_no', $invoice_id);
            $this->db->delete('customer_ledger');

            //tax_collection_summary
            $this->db->where('invoice_id', $invoice_id);
            $this->db->delete('tax_collection_summary');

            //tax_collection_details
            $this->db->where('invoice_id', $invoice_id);
            $this->db->delete('tax_collection_details');
            $this->session->set_userdata(array('message' => display('successfully_delete')));
            redirect(base_url('dashboard/Cinvoice/manage_invoice'));
        };


        //Update invoice status
        $this->db->set('invoice_status', $invoice_status);
        $this->db->where('invoice_id', $invoice_id);
        $result = $this->db->update('invoice');

        // Woocommerce stock update if order invoice is completed
         if ($invoice_status == 4) {
            if(check_module_status('woocommerce')) {
                $this->load->library('woocommerce/woolib/woo_lib');
                $this->load->model('woocommerce/woo_model');
                $this->woo_lib->connection();
                // Check woo setting to update stock for local selling
                $woo_sett = $this->woo_model->get_settings();
                if(isset($woo_sett['woo_stock_update']) && !empty($woo_sett['woo_stock_update']))
                {
                    $invinfo = $this->woo_model->get_invoice_info_by_id($invoice_id); // get invoice info
                    if(!empty($invinfo) && !empty($invinfo->default_status)){  // Stock update only for default store
                        $invdetails = $this->woo_model->get_invoice_details_by_id($invoice_id); // invoice details

                        //inv details with sync data
                        if(!empty($invdetails)) {
                            $woo_stock = [];
                            foreach ($invdetails as $invitem) {
                                if(!empty($invitem->woo_product_id)){

                                    $prod_stock = $this->woo_model->get_product_stock($invinfo->store_id, $invitem->product_id, $invitem->variant_id);
                                    if($invitem->woo_product_type=='variable') {  //If the product type is variable
                                        

                                        $varinfo = $this->woo_model->get_varsync_by_localvar($invitem->woo_product_id, $invitem->variant_id);
                                        if(!empty($varinfo->woo_variant_id)){

                                            $varstock = array(
                                                'manage_stock' => TRUE,
                                                'stock_quantity' => $prod_stock,
                                                'stock_status' => ($prod_stock>0?'instock':'outofstock')
                                            );
                                            $this->woo_lib->put_request(array('param'=> 'products/'.$invitem->woo_product_id.'/variations/'.$varinfo->woo_variant_id), $varstock);
                                        }
                                    }else{
                                        $woo_stock[] = array(
                                            'id' => $invitem->woo_product_id,
                                            'manage_stock' => TRUE,
                                            'stock_quantity' => $prod_stock,
                                            'stock_status' => ($prod_stock>0?'instock':'outofstock')
                                        );
                                    }
                                }
                            }

                            if(!empty($woo_stock)){ //update global stock
                                $this->woo_lib->post_request(array('param'=> 'products/batch'), array('update' => $woo_stock));
                            }
                        }
                    }
                }

                // woo order status update
                $woo_ordersync = $this->woo_model->get_ordersync_byid($order_id);
                if(isset($woo_ordersync->woo_order_id) && !empty($woo_ordersync->woo_order_id))
                {
                    $sync_order_data = array(
                        'status' => 'completed'
                    );
                    $this->woo_lib->put_request(array('param'=> 'orders/'.$woo_ordersync->woo_order_id), $sync_order_data);
                }
            }
        }

        $setting_detail = $this->Soft_settings->retrieve_email_editdata();
        $sms_service = $this->Soft_settings->retrieve_setting_editdata();

        if ($result === true) {
            if ($sms_service[0]['sms_service'] == 1) {
                if ($invoice_status_text == "Processing" || $invoice_status_text == "Shipped") {
                    $this->load->model('web/Homes');
                    $this->Homes->send_sms($order_no, $customer_id, $invoice_status_text);//$invoice_status is type in send_sms method
                }
            }
            $subject = display("invoice_status");
            $message = $this->input->post('add_note',TRUE);

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
            $this->email->to($this->input->post('customer_email',TRUE));
            $this->email->subject($subject);
            $this->email->message($message);

            $email = $this->test_input($this->input->post('customer_email',TRUE));
            $server_status = serverAliveOrNot($setting_detail[0]['smtp_host'], $setting_detail[0]['smtp_port']);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if ($server_status && $this->email->send()) {
                    $this->session->set_userdata(array('message' => display('email_send_to_customer')));
                    redirect(base_url('dashboard/Cinvoice/manage_invoice'));
                } else {
                    $this->session->set_userdata(array('error_message' => display('email_not_send')));
                    redirect(base_url('dashboard/Cinvoice/manage_invoice'));
                }
            } else {
                $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect(base_url('dashboard/Cinvoice/manage_invoice'));
            }
        } else {
            $this->session->set_userdata(array('error_message' => display('ooops_something_went_wrong')));
            redirect(base_url('dashboard/Cinvoice/manage_invoice'));
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

    //Search Inovoice Item
    public function search_inovoice_item()
    {

        $customer_id = $this->input->post('customer_id',TRUE);
        $content = $this->linvoice->search_inovoice_item($customer_id);
        $this->template_lib->full_admin_html_view($content);
    }

    //This function is used to Generate Key
    public function generator($lenth)
    {
        $number = array("1", "2", "3", "4", "5", "6", "7", "8", "9");

        for ($i = 0; $i < $lenth; $i++) {
            $rand_value = rand(0, 8);
            $rand_number = $number["$rand_value"];

            if (empty($con)) {
                $con = $rand_number;
            } else {
                $con = "$con" . "$rand_number";
            }
        }
        return $con;
    }


    public function get_pos_product()
    {

        $per_page = $this->input->post('per_page',TRUE);
        $limit = $this->input->post('limit',TRUE);

        $products = $this->db->select('
                    a.product_id,a.product_name,a.price,a.image_thumb,a.variants,a.product_model,
                    c.category_name,c.category_id
                ')
            ->from('product_information a')
            ->join('product_category c', 'c.category_id = a.category_id', 'left')
            ->group_by('a.product_id')
            ->order_by('a.product_name', 'asc')
            ->limit($per_page, $limit)
            ->get()
            ->result();
        $html = '';

        foreach ($products as $product) {
            $html .= '<div class="col-xs-6 col-sm-4 col-md-2 col-p-3">
                    <div class="panel panel-bd product-panel select_product">
                        <div class="panel-body">
                            <img src="' . base_url() . $product->image_thumb . '"
                                 class="img-responsive"
                                 alt="">
                            <input type="hidden" name="select_product_id" class="select_product_id"
                                   value="' . $product->product_id . '">
                        </div>
                        <div class="panel-footer">' . $product->product_name . '-(' . $product->product_model . ')' . '</div>
                    </div>
                </div>';
        }

        echo $html;


    }
}