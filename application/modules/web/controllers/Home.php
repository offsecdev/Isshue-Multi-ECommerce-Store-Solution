<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('web/lhome');
        $this->load->library('paypal_lib');
        $this->load->library('dashboard/occational');
        $this->load->library('Pdfgenerator');
        $this->load->model(array(
            'web/Homes',
            'web/Products_model',
            'dashboard/Web_settings',
            'dashboard/Soft_settings',
            'dashboard/Subscribers',
            'dashboard/color_frontends',
        ));
        $this->qrgenerator();

    }

    //Default loading for Home Index.
    public function index()
    {
       $content = $this->lhome->home_page();
       $this->template_lib->full_website_html_view($content);
    }

    //Submit a subcriber.
    public function add_subscribe()
    {

        $data = array(
            'subscriber_id' => $this->generator(15),
            'apply_ip' => $this->input->ip_address(),
            'email' => $this->input->post('sub_email',TRUE),
            'status' => 1
        );

        $result = $this->Subscribers->subscriber_entry($data);

        if ($result) {
            echo '2';
        } else {
            echo '3';
        }
    }

    //Add to cart
    public function add_to_cart()
    {

        $data = array(
            'id' => $this->input->post('product_id',TRUE),
            'qty' => $this->input->post('qnty',TRUE),
            'price' => $this->input->post('price',TRUE),
            'supplier_price' => $this->input->post('supplier_price',TRUE),
            'name' => clean($this->input->post('name',TRUE)),
            'discount' => $this->input->post('discount',TRUE),
            'options' => array(
                'image' => $this->input->post('image',TRUE),
                'model' => $this->input->post('model',TRUE),
                'cgst' => $this->input->post('cgst',TRUE),
                'sgst' => $this->input->post('sgst',TRUE),
                'igst' => $this->input->post('igst',TRUE),
                'cgst_id' => $this->input->post('cgst_id',TRUE),
                'sgst_id' => $this->input->post('sgst_id',TRUE),
                'igst_id' => $this->input->post('igst_id',TRUE),
            )
        );
        $result = $this->cart->insert($data);
        if ($result) {
            echo "1";
        }
    }

    //Add to cart for details
    public function add_to_cart_details()
    {

        $product_id = $this->input->post('product_id',TRUE);
        $qnty = $this->input->post('qnty',TRUE);
        $variant = $this->input->post('variant',TRUE);
        $variant_color = $this->input->post('variant_color',TRUE);

        $discount = 0;
        $onsale_price = 0;
        $cgst = 0;
        $cgst_id = 0;

        $sgst = 0;
        $sgst_id = 0;

        $igst = 0;
        $igst_id = 0;

        if ($product_id) {
            $product_details = $this->Homes->product_details($product_id);
             $this->load->model('web/Products_model');
             $price_arr =  $this->Products_model->check_variant_wise_price($product_id, $variant, $variant_color);
             $final_price = $price_arr['price'];


            if ($product_details->onsale) {
                $onsale_price = $product_details->onsale_price;
                $discount = $product_details->price - $final_price;
                $discount = (($discount > 0)?$discount:0);
            }

            //CGST product tax
            $tax_info = $this->Homes->get_product_tax_info($product_details->product_id, 'H5MQN4NXJBSDX4L');

            if (!empty($tax_info) && !empty($tax_info->tax_status)) {
                $cgst = ($tax_info->tax_percentage * $final_price) / 100;
                $cgst_id = $tax_info->tax_id;
            }

            //SGST product tax
            $tax_info = $this->Homes->get_product_tax_info($product_details->product_id, '52C2SKCKGQY6Q9J');

            if (!empty($tax_info) && !empty($tax_info->tax_status)) {
                 $sgst = ($tax_info->tax_percentage * $final_price) / 100;
                $sgst_id = $tax_info->tax_id;
            }

            //IGST product tax
            $tax_info = $this->Homes->get_product_tax_info($product_details->product_id, '5SN9PRWPN131T4V');

            if (!empty($tax_info) && !empty($tax_info->tax_status)) {
                $igst = ($tax_info->tax_percentage * $final_price) / 100;
                $igst_id = $tax_info->tax_id;
            }

            //Shopping cart validation
            $flag = TRUE;
            $dataTmp = $this->cart->contents();
            foreach ($dataTmp as $item) {

                if(!empty($variant_color)){
                  if (($item['product_id'] == $product_id) && ($item['variant'] == $variant) && ($item['variant_color'] == $variant_color)) {
                        $data = array(
                            'rowid' => $item['rowid'],
                            'qty' => $item['qty'] + $qnty
                        );
                        $this->cart->update($data);
                        $flag = FALSE;
                        break;
                    }  
                }else{
                    if (($item['product_id'] == $product_id) && ($item['variant'] == $variant)) {
                        $data = array(
                            'rowid' => $item['rowid'],
                            'qty' => $item['qty'] + $qnty
                        );
                        $this->cart->update($data);
                        $flag = FALSE;
                        break;
                    }
                }
                
            }

            if ($flag) {
                $data = array(
                    'id' => $this->generator(15),
                    'product_id' => $product_details->product_id,
                    'qty' => $qnty,
                    'price' => $final_price,
                    'actual_price' => $final_price,
                    'supplier_price' => $product_details->supplier_price,
                    'onsale_price' => $onsale_price,
                    'name' => clean($product_details->product_name),
                    'discount' => $discount,
                    'variant' => $variant,
                    'variant_color' => $variant_color,
                    'options' => array(
                        'image' => $product_details->image_thumb,
                        'model' => $product_details->product_model,
                        'cgst' => $cgst,
                        'sgst' => $sgst,
                        'igst' => $igst,
                        'cgst_id' => $cgst_id,
                        'sgst_id' => $sgst_id,
                        'igst_id' => $igst_id,
                    )
                );
                $result = $this->cart->insert($data);
            }
            echo "1";
        }
    }
    
    //Add to comparison for details
    public function add_to_comparison_details()
    {
        $product_id = $this->input->post('product_id',TRUE);
        $com_ids    = $this->session->userdata('comparison_ids');
        if (isset($com_ids) && !empty($com_ids)){
            array_push($com_ids,$product_id);
            $this->session->set_userdata(array('comparison_ids' => array_unique($com_ids)));
        }else{
            $this->session->set_userdata(array('comparison_ids' => array($product_id)));   
        }
        
        echo TRUE;
    }

    //Delete item on your comparison
    public function delete_comparison()
    {
        $comparison_id = $this->input->post('comparison_id',TRUE);
        $com_ids       = $this->session->userdata('comparison_ids');
        unset($com_ids[array_search($comparison_id, $com_ids)]);    
        $this->session->set_userdata(array('comparison_ids' => array_unique($com_ids)));
        echo "1"; 
    }

    //Delete item on your cart
    public function delete_cart()
    {
        $rowid = $this->input->post('row_id',TRUE);
        $result = $this->cart->remove($rowid);
        if ($result) {
            echo "1";
        }
    }


    //Delete item on your cart
    public function delete_cart_by_click($rowid)
    {
        $result = $this->cart->remove($rowid);
        if ($result) {
            $this->session->set_userdata(array('message' => display('successfully_updated')));
            redirect('view_cart');
        }
    }

    //Update your cart
    public function update_cart()
    {

        $inputs = $this->input->post();
        if(!empty($inputs)){

            foreach ($inputs as $input) {
                $cartinfo = $this->cart->get_item($input['rowid']);

                $stock = $this->Products_model->check_variant_wise_stock($cartinfo['variant'], $cartinfo['product_id']);

                if ($input['qty'] > $stock) {
                    $this->session->set_userdata(array('error_msg' => display('out_of_stock')));
                    redirect('view_cart');
                }
            }

            $this->cart->update($inputs);
            $this->session->set_userdata(array('message' => display('successfully_updated')));
        }
        redirect('view_cart');
    }

    //Set ship cost to cart
    public function set_ship_cost_cart()
    {

        $shipping_cost = $this->input->post('shipping_cost',TRUE);
        $ship_cost_name = $this->input->post('ship_cost_name',TRUE);
        $method_id = $this->input->post('method_id',TRUE);

        //Shipping and billing info set to session
        $first_name = $this->input->post('first_name',TRUE);
        $last_name = $this->input->post('last_name',TRUE);
        $customer_email = $this->input->post('customer_email',TRUE);
        $customer_mobile = $this->input->post('customer_mobile',TRUE);
        $customer_address_1 = $this->input->post('customer_address_1',TRUE);
        $customer_address_2 = $this->input->post('customer_address_2',TRUE);
        $company = $this->input->post('company',TRUE);
        $thisty = $this->input->post('city',TRUE);
        $zip = $this->input->post('zip',TRUE);
        $country = $this->input->post('country',TRUE);
        $state = $this->input->post('state',TRUE);
        $ac_pass = $this->input->post('ac_pass',TRUE);
        $privacy_policy = $this->input->post('privacy_policy',TRUE);
        $creat_ac = $this->input->post('creat_ac',TRUE);

        $ship_first_name = $this->input->post('ship_first_name',TRUE);
        $ship_last_name = $this->input->post('ship_last_name',TRUE);
        $ship_company = $this->input->post('ship_company',TRUE);
        $ship_mobile = $this->input->post('ship_mobile',TRUE);
        $ship_email = $this->input->post('ship_email',TRUE);
        $ship_address_1 = $this->input->post('ship_address_1',TRUE);
        $ship_address_2 = $this->input->post('ship_address_2',TRUE);
        $ship_city = $this->input->post('ship_city',TRUE);
        $ship_zip = $this->input->post('ship_zip',TRUE);
        $ship_country = $this->input->post('ship_country',TRUE);
        $ship_state = $this->input->post('ship_state',TRUE);
        $payment_method = $this->input->post('payment_method',TRUE);
        $order_details = $this->input->post('order_details',TRUE);
        $diff_ship_adrs = $this->input->post('diff_ship_adrs',TRUE);

        //Set data to session
        $this->session->set_userdata(
            array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'customer_email' => $customer_email,
                'customer_mobile' => $customer_mobile,
                'customer_address_1' => $customer_address_1,
                'customer_address_2' => $customer_address_2,
                'company' => $company,
                'city' => $thisty,
                'zip' => $zip,
                'country' => $country,
                'state' => $state,
                'ac_pass' => $ac_pass,
                'privacy_policy' => $privacy_policy,
                'creat_ac' => $creat_ac,

                'ship_first_name' => $ship_first_name,
                'ship_last_name' => $ship_last_name,
                'ship_company' => $ship_company,
                'ship_mobile' => $ship_mobile,
                'ship_email' => $ship_email,
                'ship_address_1' => $ship_address_1,
                'ship_address_2' => $ship_address_2,
                'ship_city' => $ship_city,
                'ship_zip' => $ship_zip,
                'ship_country' => $ship_country,
                'ship_state' => $ship_state,
                'payment_method' => $payment_method,
                'order_details' => $order_details,
                'cart_ship_cost' => $shipping_cost,
                'cart_ship_name' => $ship_cost_name,
                'method_id' => $method_id,
                'diff_ship_adrs' => $diff_ship_adrs,
            )
        );
        echo "1";
    }

    public function check_product_store()
    {
        $items = $this->cart->contents();

        foreach ($items as $item) {
            $stock = $this->Products_model->check_quantity_wise_stock($item['qty'], $item['product_id'],$item['variant']);
            if ($stock < $item['qty']) {
                echo "no";
            }
        }

    }

    //account_type_save
    public function account_type_save()
    {
        $account_type = $this->input->post('account_type',TRUE);
        $this->session->set_userdata('account_info', $account_type);
    }

    //Account info save
    public function account_info_save($account_id)
    {
        $selected_country_info = $this->Homes->selected_country_info();

        $first_name = $this->input->post('first_name',TRUE);
        $last_name = $this->input->post('last_name',TRUE);
        $customer_email = $this->input->post('customer_email',TRUE);
        $customer_mobile = $this->input->post('customer_mobile',TRUE);
        $customer_address_1 = $this->input->post('customer_address_1',TRUE);
        $customer_address_2 = $this->input->post('customer_address_2',TRUE);
        $company = $this->input->post('company',TRUE);
        $thisty = $this->input->post('city',TRUE);
        $zip = $this->input->post('zip',TRUE);
        $country = $this->input->post('country',TRUE);
        $state = $this->input->post('state',TRUE);
        $password = $this->input->post('password',TRUE);
        $ship_and_bill = $this->input->post('ship_and_bill',TRUE);
        $privacy_policy = $this->input->post('privacy_policy',TRUE);
        $ship_first_name = $this->input->post('ship_first_name',TRUE);
        $ship_last_name = $this->input->post('ship_last_name',TRUE);
        $ship_company = $this->input->post('ship_company',TRUE);
        $ship_mobile = $this->input->post('ship_mobile',TRUE);
        $ship_address_1 = $this->input->post('ship_address_1',TRUE);
        $ship_address_2 = $this->input->post('ship_address_2',TRUE);
        $ship_city = $this->input->post('ship_city',TRUE);
        $ship_zip = $this->input->post('ship_zip',TRUE);
        $ship_country = $this->input->post('ship_country',TRUE);
        $ship_state = $this->input->post('ship_state',TRUE);
        $payment_method = $this->input->post('payment_method',TRUE);
        $delivery_details = $this->input->post('delivery_details',FALSE);
        $payment_details = $this->input->post('payment_details',FALSE);


        if ($ship_and_bill == 1) {

            $this->session->set_userdata(
                array(
                    'account_info' => $account_id,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'customer_email' => $customer_email,
                    'customer_mobile' => $customer_mobile,
                    'customer_address_1' => $customer_address_1,
                    'customer_address_2' => $customer_address_2,
                    'company' => $company,
                    'city' => $thisty,
                    'zip' => $zip,
                    'country' => $country,
                    'state' => $state,
                    'password' => $password,
                    'ship_and_bill' => $ship_and_bill,
                    'privacy_policy' => $privacy_policy,
                    'ship_first_name' => $first_name,
                    'ship_last_name' => $last_name,
                    'ship_company' => $company,
                    'ship_mobile' => $customer_mobile,
                    'ship_address_1' => $customer_address_1,
                    'ship_address_2' => $customer_address_2,
                    'ship_city' => $thisty,
                    'ship_zip' => $zip,
                    'ship_country' => $country,
                    'ship_state' => $state,
                    'payment_method' => $payment_method,
                    'delivery_details' => $delivery_details,
                    'payment_details' => $payment_details,
                )
            );

        } else {
            $this->session->set_userdata(
                array(
                    'account_info' => $account_id,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'customer_email' => $customer_email,
                    'customer_mobile' => $customer_mobile,
                    'customer_address_1' => $customer_address_1,
                    'customer_address_2' => $customer_address_2,
                    'company' => $company,
                    'city' => $thisty,
                    'zip' => $zip,
                    'country' => $country,
                    'state' => $state,
                    'password' => $password,
                    'ship_and_bill' => $ship_and_bill,
                    'privacy_policy' => $privacy_policy,
                    'ship_first_name' => $ship_first_name,
                    'ship_last_name' => $ship_last_name,
                    'ship_company' => $ship_company,
                    'ship_mobile' => $ship_mobile,
                    'ship_address_1' => $ship_address_1,
                    'ship_address_2' => $ship_address_2,
                    'ship_city' => $ship_city,
                    'ship_zip' => $ship_zip,
                    'ship_country' => $ship_country,
                    'ship_state' => $ship_state,
                    'payment_method' => $payment_method,
                    'delivery_details' => $delivery_details,
                    'payment_details' => $payment_details,
                )
            );
        }
    }

    //Apply Coupon
    public function apply_coupon()
    {

        if ($this->user_auth->is_logged() != 1) {
            $this->session->set_userdata(array('error_message' => display('login_to_apply_coupon')));

            echo "6";
            exit();
        }

        $customer_id = $this->session->userdata('customer_id');
        $this->form_validation->set_rules('coupon_code', display('coupon_code'), 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_userdata(array('error_message' => validation_errors()));
            echo "5";
            exit;
        } else {
            $coupon_code = $this->input->post('coupon_code',TRUE);
            $result = $this->db->select('*')
                ->from('coupon')
                ->where('coupon_discount_code', $coupon_code)
                ->where('status', 1)
                ->get()
                ->row();
            $check_coupon = $this->db->select('customer_id,date,coupon')->where('customer_id', $customer_id)->where('coupon', $coupon_code)->from('order')->get()->row();

            if ($result && empty($check_coupon)) {
                $today = strtotime(date('d-m-Y'));
                $start_date = strtotime($result->start_date);
                $end_date = strtotime($result->end_date);

                $difference_date = (int)$end_date - (int)$today;

                if ($difference_date < 0) {
                    $this->session->set_userdata('error_message', display('coupon_is_expired'));
                    echo "3";
                    exit;
                }
                $diff = abs($start_date - $end_date);
                $years = floor($diff / (365 * 60 * 60 * 24));
                $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

                if ((!empty($days) || !empty($months) || !empty($years))) {
                    $this->session->set_userdata("coupon", $result->coupon_discount_code);
                    if ($result->discount_type == 1) {

                        $this->session->set_userdata('coupon_code', $result->coupon_discount_code);
                        $this->session->unset_userdata('coupon_amnt');
                        $this->session->set_userdata('coupon_amnt', $result->discount_amount);
                        $this->session->set_userdata('message', display('great_your_coupon_is_applied'));
                        echo "1";
                    } elseif ($result->discount_type == 2) {

                        $this->session->set_userdata('coupon_code', $result->coupon_discount_code);
                        $total_dis = ($this->cart->total() * $result->discount_percentage) / 100;
                        $this->session->unset_userdata('coupon_amnt');
                        $this->session->set_userdata('coupon_amnt', $total_dis);
                        $this->session->set_userdata('message', display('your_coupon_is_used'));
                        echo "2";
                    }

                } else {
                    $this->session->set_userdata('error_message', display('coupon_is_expired'));
                    echo "3";
                }
            } else {
                $this->session->set_userdata('error_message', display('invalid_coupon'));
                echo "4";
            }
        }
    }

     //Apply Coupon
    public function apply_coupon_for_discount()
    {

        if ($this->user_auth->is_logged() != 1) {
            echo "error|".display('login_to_apply_coupon');
            exit();
        }

        $customer_id = $this->session->userdata('customer_id');
        $this->form_validation->set_rules('coupon_code', display('coupon_code'), 'required');
        if ($this->form_validation->run() == FALSE) {
            echo "error|".validation_errors();
            exit;
        } else {
            $coupon_code = $this->input->post('coupon_code',TRUE);
            $result = $this->db->select('*')
                ->from('coupon')
                ->where('coupon_discount_code', $coupon_code)
                ->where('status', 1)
                ->get()
                ->row();
            $check_coupon = $this->db->select('customer_id,date,coupon')->where('customer_id', $customer_id)->where('coupon', $coupon_code)->from('order')->get()->row();

            if ($result && empty($check_coupon)) {
                $today = strtotime(date('d-m-Y'));
                $start_date = strtotime($result->start_date);
                $end_date = strtotime($result->end_date);

                $difference_date = (int)$end_date - (int)$today;

                if ($difference_date < 0) {
                    echo "error|".display('coupon_is_expired');
                    exit;
                }
                $diff = abs($start_date - $end_date);
                $years = floor($diff / (365 * 60 * 60 * 24));
                $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

                if ((!empty($days) || !empty($months) || !empty($years))) {
                    $this->session->set_userdata("coupon", $result->coupon_discount_code);
                    if ($result->discount_type == 1) {

                        $this->session->set_userdata('coupon_code', $result->coupon_discount_code);
                        $this->session->unset_userdata('coupon_amnt');
                        $this->session->set_userdata('coupon_amnt', $result->discount_amount);
                        echo "success|".$result->discount_amount."|".display('great_your_coupon_is_applied');
                        exit();
                    } elseif ($result->discount_type == 2) {

                        $this->session->set_userdata('coupon_code', $result->coupon_discount_code);
                        $total_dis = ($this->cart->total() * $result->discount_percentage) / 100;
                        $this->session->unset_userdata('coupon_amnt');
                        $this->session->set_userdata('coupon_amnt', $total_dis);
                        echo "success|".$total_dis."|".display('great_your_coupon_is_applied');
                        exit();
                    }

                } else {
                    echo "error|".display('coupon_is_expired');
                    exit();
                }
            } else {

                echo "error|".display('invalid_coupon');
                    exit();
            }
        }
    }

    //Add Wish list
    public function add_wishlist()
    {

        if (!$this->user_auth->is_logged()) {
            echo '3';
        } else {
            $data = array(
                'wishlist_id' => $this->generator(15),
                'user_id' => $this->input->post('customer_id',TRUE),
                'product_id' => $this->input->post('product_id',TRUE),
                'status' => '1',
            );
            $add_wishlist = $this->Homes->add_wishlist($data);

            if ($add_wishlist) {
                echo '1';
            } else {
                echo '2';
            }
        }
    }


    //Add Wish list
    public function remove_wishlist()
    {

        if (!$this->user_auth->is_logged()) {
            echo '3';
        } else {
            $data = array(
                'user_id' => $this->input->post('customer_id',TRUE),
                'product_id' => $this->input->post('product_id',TRUE)
            );
            $remove_wishlist = $this->Homes->remove_wishlist($data);

            if ($remove_wishlist) {
                echo '1';
            } else {
                echo '2';
            }
        }
    }

    //Add Review
    public function add_review()
    {

        if (!$this->user_auth->is_logged()) {
            echo '3';
        } else {
            $data = array(
                'product_review_id' => $this->generator(15),
                'reviewer_id' => $this->input->post('customer_id',TRUE),
                'product_id' => $this->input->post('product_id',TRUE),
                'comments' => $this->input->post('review_msg',FALSE),
                'rate' => $this->input->post('rate',TRUE),
                'status' => '0',
            );
            $add_review = $this->Homes->add_review($data);
            if ($add_review) {
                echo '1';
            } else {
                echo '2';
            }
        }
    }

    //Change Language
    public function change_language()
    {
        $language = $this->input->post('language',TRUE);

        if ($language) {
            $this->session->unset_userdata('language');
            $this->session->set_userdata('language', $language);
            echo '2';
        } else {
            echo '3';
        }
    }

    //Change Currency
    public function change_currency()
    {
        $currency_id = $this->input->post('currency_id',TRUE);

        if ($currency_id) {
            $this->session->unset_userdata('currency_new_id');
            $this->session->set_userdata('currency_new_id', $currency_id);
            echo '2';
        } else {
            echo '3';
        }
    }

    //View Cart
    public function view_cart()
    {
        $content = $this->lhome->view_cart();
        $this->template_lib->full_website_html_view($content);
    }

    //Retrive district
    public function retrive_district()
    {
        $country_id = $this->input->post('country_id',TRUE);

        if ($country_id) {
            $select_district_info = $this->Homes->select_district_info($country_id);

            $html = "";
            if ($select_district_info) {
                $html .= "<select name=\"zone_id\" id=\"input-payment-zone\" class=\"form-control\" required=\"\">";
                foreach ($select_district_info as $district) {
                    $html .= "<option value=" . $district->name . ">$district->name</option>";
                }
                $html .= "</select>";
                echo $html;
            }
        }
    }

    //Checkout
    public function checkout()
    {
        $content = $this->lhome->checkout();
        $this->template_lib->full_website_html_view($content);
    }

    //update order table to use coupon code any customer. it's active when submit checkout. It's call from submit
    private function order_coupon_update($customer_id, $order_id)
    {
        $coupon_code = $this->session->userdata('coupon_code');
        $this->db->set('coupon', $coupon_code);
        $this->db->where('customer_id', $customer_id);
        $this->db->where('order_id', $order_id);
        $this->db->update('order');
    }

    //Submit checkout
    public function submit_checkout()
    {
        $this->form_validation->set_rules('first_name', display('first_name'), 'trim|required');
        $this->form_validation->set_rules('last_name', display('last_name'), 'trim|required');
        $this->form_validation->set_rules('country', display('country'), 'trim|required');
        $this->form_validation->set_rules('customer_email', display('customer_email'), 'trim|required');
        $this->form_validation->set_rules('customer_address_1', display('customer_address_1'), 'trim|required');
        $this->form_validation->set_rules('city', display('city'), 'trim|required');
        $this->form_validation->set_rules('state', display('state'), 'trim|required');
        $this->form_validation->set_rules('customer_mobile', display('customer_mobile'), 'trim|required');
        $this->form_validation->set_rules('customer_mobile', display('customer_mobile'), 'trim|required');
        $this->form_validation->set_rules('shipping_cost', display('shipping_method'), 'trim|required');
        $this->form_validation->set_rules('payment_method', display('payment_method'), 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $content = $this->lhome->checkout();
            $this->template_lib->full_website_html_view($content);
        } else {
             

            $this->load->model('dashboard/Blocks');
            $parent_category_list = $this->Homes->parent_category_list();
            $pro_category_list = $this->Homes->category_list();
            $best_sales = $this->Homes->best_sales();
            $footer_block = $this->Homes->footer_block();
            $slider_list = $this->Web_settings->slider_list();
            $block_list = $this->Blocks->block_list();
            $currency_details = $this->Soft_settings->retrieve_currency_info();
            $Soft_settings = $this->Soft_settings->retrieve_setting_editdata();
            $languages = $this->Homes->languages();
            $currency_info = $this->Homes->currency_info();
            $selected_currency_info = $this->Homes->selected_currency_info();
            $select_home_adds = $this->Homes->select_home_adds();

            //Settings code start
            $data['category_list'] = $parent_category_list;
            $data['pro_category_list'] = $pro_category_list;
            $data['slider_list'] = $slider_list;
            $data['block_list'] = $block_list;
            $data['best_sales'] = $best_sales;
            $data['footer_block'] = $footer_block;
            $data['languages'] = $languages;
            $data['currency_info'] = $currency_info;
            $data['select_home_adds'] = $select_home_adds;
            $data['selected_cur_id'] = (($selected_currency_info->currency_id) ? $selected_currency_info->currency_id : "");
            $data['Soft_settings'] = $Soft_settings;
            $data['currency'] = $currency_details[0]['currency_icon'];
            $data['position'] = $currency_details[0]['currency_position'];
            //Setting code end

            //Payment method
            $order_id = $this->generator(15);
            $payment_method = $this->input->post('payment_method',TRUE);
            $diff_ship_adrs = $this->input->post('diff_ship_adrs',TRUE);
            $cart_total = $this->input->post('order_total_amount',TRUE);
            $this->session->set_userdata('cart_total', $cart_total);
            $this->session->set_userdata('payment_method', $payment_method);
            $coupon_amnt = $this->session->userdata('coupon_amnt');

            //Customer existing check
            $email = $this->input->post('customer_email',TRUE);
            $customer_existing_check = $this->Homes->check_customer($email);

            if ($customer_existing_check) {
                if (1 == $diff_ship_adrs) {
                    $customer_id = $customer_existing_check->customer_id;
                    $ship_country_id = $this->session->userdata('ship_country');
                    $ship_country = $this->db->select('*')
                        ->from('countries')
                        ->where('id', $ship_country_id)
                        ->get()
                        ->row();
                    $ship_short_address = $this->session->userdata('ship_city') . ',' . $this->session->userdata('ship_state') . ',' . $ship_country->name . ',' . $this->session->userdata('ship_zip');

                    //New shipping information entry for existing customer
                    $shipping = array(
                        'customer_id' => $customer_id,
                        'order_id' => $order_id,
                        'customer_name' => $this->session->userdata('ship_first_name') . ' ' . $this->session->userdata('ship_last_name'),
                        'first_name' => $this->session->userdata('ship_first_name'),
                        'last_name' => $this->session->userdata('ship_last_name'),
                        'customer_short_address' => $ship_short_address,
                        'customer_address_1' => $this->session->userdata('ship_address_1'),
                        'customer_address_2' => $this->session->userdata('ship_address_2'),
                        'city' => $this->session->userdata('ship_city'),
                        'state' => $this->session->userdata('ship_state'),
                        'country' => $this->session->userdata('ship_country'),
                        'zip' => $this->session->userdata('ship_zip'),
                        'company' => $this->session->userdata('ship_company'),
                        'customer_mobile' => $this->session->userdata('ship_mobile'),
                        'customer_email' => $this->session->userdata('customer_email'),
                    );
                    //Shipping information entry for existing customer
                    $this->Homes->shipping_entry($shipping);
                } else { //if billing and shipping address are same

                    $customer_id = $customer_existing_check->customer_id;
                    //Shipping data entry
                    $country_id = $this->session->userdata('country');
                    $country = $this->db->select('*')
                        ->from('countries')
                        ->where('id', $country_id)
                        ->get()
                        ->row();
                    $billing_short_address = $this->session->userdata('city') . ',' . $this->session->userdata('state') .
                        ',' . $country->name . ',' . $this->session->userdata('zip');


                    $billing = array(
                        'customer_id' => $customer_id,
                        'customer_name' => $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name'),
                        'first_name' => $this->session->userdata('first_name'),
                        'last_name' => $this->session->userdata('last_name'),
                        'customer_short_address' => $billing_short_address,
                        'customer_address_1' => $this->session->userdata('customer_address_1'),
                        'customer_address_2' => $this->session->userdata('customer_address_2'),
                        'city' => $this->session->userdata('city'),
                        'state' => $this->session->userdata('state'),
                        'country' => $this->session->userdata('country'),
                        'zip' => $this->session->userdata('zip'),
                        'company' => $this->session->userdata('company'),
                        'customer_mobile' => $this->session->userdata('customer_mobile'),
                        'customer_email' => $this->session->userdata('customer_email'),
                    );
                    //Shipping information entry for existing customer
                    $shipping = $billing;
                    $shipping['order_id'] = $order_id;
                    $this->Homes->shipping_entry($shipping);
                    $this->Homes->update_billing_entry($billing, $customer_existing_check->customer_id);
                }
            } else {

                //new customer Billing information entry
                $customer_id = $this->generator('15');
                $this->session->set_userdata('customer_id', $customer_id);
                $country_id = $this->session->userdata('country');
                $country = $this->db->select('*')
                    ->from('countries')
                    ->where('id', $country_id)
                    ->get()
                    ->row();

                $short_address = $this->session->userdata('city') . ',' . $this->session->userdata('state') . ',' . $country->name . ',' . $this->session->userdata('zip');

                //New customer billing info entry
                $billing = array(
                    'customer_id' => $customer_id,
                    'customer_name' => $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name'),
                    'first_name' => $this->session->userdata('first_name'),
                    'last_name' => $this->session->userdata('last_name'),
                    'customer_short_address' => $short_address,
                    'customer_address_1' => $this->session->userdata('customer_address_1'),
                    'customer_address_2' => $this->session->userdata('customer_address_2'),
                    'city' => $this->session->userdata('city'),
                    'state' => $this->session->userdata('state'),
                    'country' => $this->session->userdata('country'),
                    'zip' => $this->session->userdata('zip'),
                    'company' => $this->session->userdata('company'),
                    'customer_mobile' => $this->session->userdata('customer_mobile'),
                    'customer_email' => $this->session->userdata('customer_email'),
                    'password' => md5("gef" . $this->session->userdata('ac_pass')),
                );
                $this->Homes->billing_entry($billing);

                if (1 == $diff_ship_adrs) { //different shipping address for new customer
                    //Shipping data entry
                    $ship_country_id = $this->session->userdata('ship_country');
                    if ($ship_country_id) {
                        $shipCountryId = $ship_country_id;
                    } else {
                        $shipCountryId = $this->session->userdata('country');
                    }
                    $ship_country = $this->db->select('*')
                        ->from('countries')
                        ->where('id', $shipCountryId)
                        ->get()
                        ->row();
                    $ship_short_address = $this->session->userdata('ship_city') . ',' . $this->session->userdata('ship_state') . ',' . $ship_country->name . ',' . $this->session->userdata('ship_zip');

                    //New customer shipping entry
                    $shipping = array(
                        'customer_id' => $customer_id,
                        'order_id' => $order_id,
                        'customer_name' => $this->session->userdata('ship_first_name') . ' ' . $this->session->userdata('ship_last_name'),
                        'first_name' => $this->session->userdata('ship_first_name'),
                        'last_name' => $this->session->userdata('ship_last_name'),
                        'customer_short_address' => $ship_short_address,
                        'customer_address_1' => $this->session->userdata('ship_address_1'),
                        'customer_address_2' => $this->session->userdata('ship_address_2'),
                        'city' => $this->session->userdata('ship_city'),
                        'state' => $this->session->userdata('ship_state'),
                        'country' => $this->session->userdata('ship_country'),
                        'zip' => $this->session->userdata('ship_zip'),
                        'company' => $this->session->userdata('ship_company'),
                        'customer_mobile' => $this->session->userdata('ship_mobile'),
                        'customer_email' => $this->session->userdata('customer_email'),
                    );
                    $this->Homes->shipping_entry($shipping);
                } else {
                    //New customer billing info entry to shipping database
                    $billing = array(
                        'customer_id' => $customer_id,
                        'order_id' => $order_id,
                        'customer_name' => $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name'),
                        'first_name' => $this->session->userdata('first_name'),
                        'last_name' => $this->session->userdata('last_name'),
                        'customer_short_address' => $short_address,
                        'customer_address_1' => $this->session->userdata('customer_address_1'),
                        'customer_address_2' => $this->session->userdata('customer_address_2'),
                        'city' => $this->session->userdata('city'),
                        'state' => $this->session->userdata('state'),
                        'country' => $this->session->userdata('country'),
                        'zip' => $this->session->userdata('zip'),
                        'company' => $this->session->userdata('company'),
                        'customer_mobile' => $this->session->userdata('customer_mobile'),
                        'customer_email' => $this->session->userdata('customer_email')
                    );
                    $this->Homes->shipping_entry($billing);
                }


                $this->db->select('*');
                $this->db->from('customer_information');
                $query = $this->db->get();
                foreach ($query->result() as $row) {
                    $json_customer[] = array('label' => $row->customer_name, 'value' => $row->customer_id);
                }

                $cache_file = './my-assets/js/admin_js/json/customer.json';
                $customerList = json_encode($json_customer);
                file_put_contents($cache_file, $customerList);
            }
            
            //Cash on delivery
            if ($payment_method == 1) {
                //Order entry
                $return_order_id = $this->Homes->order_entry($customer_id, $order_id);

                if ($coupon_amnt > 0) {
                    $this->order_coupon_update($customer_id, $order_id);
                }
                $result = $this->order_inserted_data($return_order_id);

                if ($result) {

                    $this->session->set_userdata("message", display('order_placed'));
                    $this->cart->destroy();
                    redirect(base_url());
                }else{
                    $this->session->set_userdata("error_message", display('failed_try_again'));
                    redirect(base_url('checkout'));
                }
            }

            //Payment method for bitcoin
            if ($payment_method == 3) {

                #== Bit coin payment method  start ==#

                // Generated order id
                $gateway = $this->db->select('*')->from('payment_gateway')->where('id', 1)->where('status', 1)->get()->row();

                $message = "";
                require_once APPPATH . 'libraries/cryptobox/cryptobox.class.php';
                $userID = $customer_id; // place your registered userID or md5(userID) here (user1, user7, uo43DC, etc).
                // you don't need to use userID for unregistered website visitors
                // if userID is empty, system will autogenerate userID and save in cookies
                $userFormat = "COOKIE";     // save userID in cookies (or you can use IPADDRESS, SESSION)
                $orderID = $order_id;        // invoice number 22
                $amountUSD = number_format($this->session->userdata('cart_total'),2,'.','');
                // invoice amount - 2.21 USD
                $period = "NOEXPIRY";   // one time payment, not expiry
                $def_language = "en";         // default Payment Box Language
                $public_key = @$gateway->public_key;;   // from gourl.io
                $private_key = @$gateway->private_key;;  // from gourl.io

                /** PAYMENT BOX **/
                $options = array(
                    "public_key" => $public_key,        // your public key from gourl.io
                    "private_key" => $private_key,       // your private key from gourl.io
                    "webdev_key" => "DEV1124G19CFB313A993D68G453342148",                 // optional, gourl affiliate key
                    "orderID" => $orderID,           // order id or product name
                    "userID" => $userID,            // unique identifier for every user
                    "userFormat" => $userFormat,        // save userID in COOKIE, IPADDRESS or SESSION
                    "amount" => 0,                  // product price in coins OR in USD below
                    "amountUSD" => $amountUSD,         // we use product price in USD
                    "period" => $period,            // payment valid period
                    "language" => $def_language       // text on EN - english, FR - french, etc
                );

                // Initialise Payment Class
                $box = new Cryptobox ($options);

                // Coin name
                $coinName = $box->coin_name();

                // Payment Received
                if ($box->is_paid()) {
                    $text = "User will see this message during " . $period . " period after payment has been made!"; // Example
                    $text .= "<br>" . $box->amount_paid() . " " . $box->coin_label() . "  received<br>";

                } else {
                    $text = "The payment has not been made yet";
                }

                // Notification when user click on button 'Refresh'
                if (isset($_POST["cryptobox_refresh_"])) {
                    $message = "<div class='gourl_msg'>";
                    if (!$box->is_paid()) $message .= '<div style="margin:50px" class="well"><i class="fa fa-info-circle fa-3x fa-pull-left fa-border" aria-hidden="true"></i> ' . str_replace(array("%coinName%", "%coinNames%", "%coinLabel%"), array($box->coin_name(), ($box->coin_label() == 'DASH' ? $box->coin_name() : $box->coin_name() . 's'), $box->coin_label()), json_decode(CRYPTOBOX_LOCALISATION, true)[CRYPTOBOX_LANGUAGE]["msg_not_received"]) . "</div>";
                    elseif (!$box->is_processed()) {
                        // User will see this message one time after payment has been made
                        $message .= '<div style="margin:70px" class="alert alert-success" role="alert"> ' . str_replace(array("%coinName%", "%coinLabel%", "%amountPaid%"), array($box->coin_name(), $box->coin_label(), $box->amount_paid()), json_decode(CRYPTOBOX_LOCALISATION, true)[CRYPTOBOX_LANGUAGE][($box->cryptobox_type() == "paymentbox" ? "msg_received" : "msg_received2")]) . "</div>";
                        $box->set_status_processed();
                    }
                    $message .= "</div>";
                }


                //Payment received confirm
                $payment = $box->get_json_values();
                if ($payment['status'] == 'payment_received') {

                    $paydata = [
                        'pay_method' => 1,
                        'used_id' => 3,
                        'amount' => $this->session->userdata('cart_total'),
                        'customer_id' => $customer_id,
                        'order_id' => $order_id
                    ];

                    //Order entry
                    $return_order_id = $this->Homes->order_entry($customer_id, $order_id, $paydata);
                    if ($coupon_amnt > 0) {
                        $this->order_coupon_update($customer_id, $order_id);
                    }
                    $result = $this->order_inserted_data($return_order_id);
                    if ($result) {
                        $this->cart->destroy();
                    }
                }


                //Customizeable code
                $data = array(

                    //Settings code start
                    'category_list' => $parent_category_list,
                    'pro_category_list' => $pro_category_list,
                    'slider_list' => $slider_list,
                    'block_list' => $block_list,
                    'best_sales' => $best_sales,
                    'footer_block' => $footer_block,
                    'languages' => $languages,
                    'currency_info' => $currency_info,
                    'select_home_adds' => $select_home_adds,
                    'selected_cur_id' => (($selected_currency_info->currency_id) ? $selected_currency_info->currency_id : ""),
                    'Soft_settings' => $Soft_settings,
                    'currency' => $currency_details[0]['currency_icon'],
                    'position' => $currency_details[0]['currency_position'],
                    //Setting code end

                    //Bitcoin code
                    'u1' => $box->cryptobox_json_url(),
                    'u2' => intval($box->is_paid()),
                    'u3' => base_url('bitcoin-plug/'),
                    'u4' => base_url("#"),

                    'coin_name' => $box->coin_name(),
                    'message' => $message,
                    'text' => $text,
                    'title' => display('bitcoin_payment'),
                );

                #=== Bit coin payment method end ====#

                $content = $this->parser->parse('web/payment', $data, true);
                $this->template_lib->full_website_html_view($content);
            }

            //Payment method for payeer
            if ($payment_method == 4) {

                $date = new DateTime();
                $comment = $customer_id . '/buy/' . $order_id . '/' . $date->format('Y-m-d H:i:s');

                /**************************
                 * Payeer
                 **************************/
                $gateway = $this->db->select('*')->from('payment_gateway')->where('id', 2)->where('status', 1)->get()->row();

                $data['m_shop'] = @$gateway->shop_id;
                $data['m_orderid'] = $order_id;
                $data['m_amount'] = number_format($this->session->userdata('cart_total'), 2, '.', '');
                $data['m_curr'] = 'USD';
                $data['m_desc'] = base64_encode($comment);
                $data['m_key'] = @$gateway->secret_key;
                $data['user_id'] = @$customer_id;
                $data['title'] = display('payeer_payment');

                $arHash = array(
                    $data['m_shop'],
                    $data['m_orderid'],
                    $data['m_amount'],
                    $data['m_curr'],
                    $data['m_desc']
                );

                $arHash[] = $data['m_key'];
                $data['sign'] = strtoupper(hash('sha256', implode(':', $arHash)));

                $content = $this->parser->parse('web/payment', $data, true);
                $this->template_lib->full_website_html_view($content);
            }

            //Payment method for paypal
            if ($payment_method == 5) {

                $appSetting = $this->Web_settings->setting();

                 //Set variables for paypal form
                $returnURL = base_url('paypal_success');
                $cancelURL = base_url("paypal_cancel"); //payment cancel url
                $notifyURL = base_url('paypal_ipn'); //ipn url

                 //set session token
                $this->session->unset_userdata('_tran_token');
                $this->session->set_userdata(array('_tran_token' => $order_id));


                $trans_id = microtime();
                $total_amount =  $this->session->userdata('cart_total');
                
                // Add fields to paypal form
                $this->paypal_lib->add_field('return', $returnURL);
                $this->paypal_lib->add_field('cancel_return', $cancelURL);
                $this->paypal_lib->add_field('custom', $trans_id);
                $this->paypal_lib->add_field('trans_id', $trans_id);
                $this->paypal_lib->add_field('order_id', $order_id);
                $this->paypal_lib->add_field('customer_id', $customer_id);
                $this->paypal_lib->add_field('amount',  $total_amount);
                $this->paypal_lib->add_field('item_name',  'Order Payment');
                $this->paypal_lib->add_field('item_number',  $order_id);
                $this->paypal_lib->add_field('quantity', '1');
                $this->paypal_lib->add_field('currency_code',  'USD');
                $this->paypal_lib->add_field('discount_amount', '0');
                $this->paypal_lib->image(base_url($appSetting[0]['logo']));

                // Load paypal form
                $this->paypal_lib->paypal_auto_form();
            }

            //Payment method for sslcommerz
            if ($payment_method == 6) {
                $gateway = $this->db->select('*')->from('payment_gateway')->where('id', 4)->where('status', 1)->get()->row();

                $total_amount = number_format($this->session->userdata('cart_total'), 2, '.', '');


                $trans_id = "isshue" . uniqid();

                // Set Session for payment
                $paysession = array(
                    'trans_id' => $trans_id,
                    'amount' => $total_amount,
                    'currency_type' => $gateway->currency,
                    'currency_amount' => $total_amount
                );
                $this->session->set_userdata($paysession);
                $this->session->set_userdata('order_id', $order_id);


                $post_data = array();
                $post_data['store_id'] = $gateway->shop_id;
                $post_data['store_passwd'] = $gateway->secret_key;
                $post_data['total_amount'] = $total_amount;
                $post_data['currency'] = $gateway->currency;
                $post_data['tran_id'] = $trans_id;

                $post_data['success_url'] = base_url('web/home/sslcommerz_payment_success');
                $post_data['fail_url'] = base_url('web/home/sslcommerz_payment_failed');
                $post_data['cancel_url'] = base_url('web/home/sslcommerz_payment_cancel');

                # EMI INFO
                $post_data['emi_option'] = "0";

                $cus_email = $this->session->userdata('customer_email');
                $ship_email = $this->session->userdata('ship_email');

                $customer_email = (!empty($cus_email) ? $cus_email : $ship_email);


                # CUSTOMER INFORMATION
                $post_data['cus_name'] = $this->session->userdata('customer_name');
                $post_data['cus_email'] = $customer_email;
                $post_data['cus_add1'] = $this->session->userdata('customer_address_1');
                $post_data['cus_add2'] = $this->session->userdata('customer_address_1');
                $post_data['cus_city'] = $this->session->userdata('city');
                $post_data['cus_state'] = $this->session->userdata('state');
                $post_data['cus_postcode'] = $this->session->userdata('zip');
                $post_data['cus_country'] = $this->session->userdata('country');
                $post_data['cus_phone'] = $this->session->userdata('customer_mobile');


                # OPTIONAL PARAMETERS
                $post_data['value_a'] = $order_id;
                $post_data['value_b'] = "";
                $post_data['value_c'] = $customer_id;
                $post_data['value_d'] = "";

                $product_amount = '';
                $post_data['product_amount'] = '';

                // check is live pay or sandbox
                if(!empty($gateway->is_live)){
                    $direct_api_url = "https://securepay.sslcommerz.com/gwprocess/v3/api.php";
                }else{
                    $direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v3/api.php";
                }

                # REQUEST SEND TO SSLCOMMERZ
                $handle = curl_init();
                curl_setopt($handle, CURLOPT_URL, $direct_api_url);
                curl_setopt($handle, CURLOPT_TIMEOUT, 30);
                curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($handle, CURLOPT_POST, 1);
                curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, TRUE); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC

                $content = curl_exec($handle);

                $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

                if ($code == 200 && !(curl_errno($handle))) {
                    curl_close($handle);
                    $sslcommerzResponse = $content;
                } else {
                    curl_close($handle);
                    echo "FAILED TO CONNECT WITH SSLCOMMERZ API";
                    exit;
                }

                # PARSE THE JSON RESPONSE
                $sslcz = json_decode($sslcommerzResponse, true);


                if (isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL'] != "") {
                    echo "<script>window.location.href = '" . $sslcz['GatewayPageURL'] . "';</script>";
                    exit;
                } else {
                    if(!empty($sslcz) && !empty($sslcz['failedreason'])){
                        $err_msg = $sslcz['failedreason'];
                    }else{
                        $err_msg = 'Payment Configuration error! Return JSON Data parsing error!';
                    }
                    $this->session->set_userdata('error_message', $err_msg);
                   redirect(base_url());
                }

            }

            // Dynamic Payment Gateway Module
            if($payment_method > 6) {
                $payGateway = $this->Homes->get_payment_gateway_by_id($payment_method);
                if(!empty($payGateway)){

                    $is_module = $this->check_is_module_enabled($payGateway->module_id);

                    if($is_module && $payGateway->status)
                    {
                        $cart_total = $this->session->userdata('cart_total');
                        $customer_name = $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name');

                        $paydata = array(
                            'pgw_id' => $payGateway->used_id,
                            'pgw_cart_total' => $cart_total,
                            'pgw_order_id' => $order_id,
                            'pgw_customer_id' => $customer_id,
                            'pgw_customer_name' => $customer_name
                        );

                        $this->session->set_userdata($paydata);

                        $moduleName = $payGateway->module_id;
                        redirect($moduleName.'/'.$moduleName.'/payment_process');
                    }

                }else{
                    $this->session->set_userdata('error_message', 'Invalid Payment Gateway!');
                }
            }
        }
    }

    // Check module enabled or not
    public function check_is_module_enabled($module_id)
    {
        if (file_exists(APPPATH . 'modules/' . $module_id . '/config/config.php')){
            $is_module = $this->db->where('directory', $module_id)->where('status', 1)->get('module')->num_rows();
            if($is_module > 0){
                return true;
            }
        }
        return false;
    }

    // Start of Dynamic Payment Gateway Module response
    public function paygateway_payment_status()
    {
        $getData = $this->input->get();
        if(!empty($getData) && !empty($getData['pgw_cart_total']) && !empty($getData['txn_id'])) {

            $order_id = $getData['pgw_order_id'];
            $customer_id = $getData['pgw_customer_id'];
            $amount = $getData['pgw_cart_total'];
            $txn_id = $getData['txn_id'];

            $transdata = [
                'payment_method' => $getData['pgw_id'],
                'used_id' => $getData['pgw_id'],
                'customer_id' => $customer_id,
                'order_id' => $order_id,
                'trans_id' => $getData['txn_id'],
                'amount' => $amount,
                'store_amount' => $amount,
                'status' => '1',
                'trans_date' => date('Y-m-d'),
                'currency' => $getData['paid_amount_currency']
            ];

            //pass the transaction data to view 
            $return_order_id = $this->Homes->order_entry($customer_id, $order_id, $transdata);
            $coupon_amnt = $this->session->userdata('coupon_amnt');
            if ($coupon_amnt > 0) {
                $this->order_coupon_update($customer_id, $order_id);
            }
            $result = $this->order_inserted_data($return_order_id);

            if ($result) {
                $this->session->set_userdata('message', display('product_successfully_order'));
                $this->cart->destroy();

                $paydata = array('pgw_id','pgw_cart_total','pgw_order_id','pgw_customer_id','pgw_customer_name');
                $this->session->unset_userdata($paydata);

            }else{
                $this->session->set_userdata('error_message', 'Order Failed! Contact with Admin. Your payment transaction id is '.$txn_id);
            }

        }else{
            $this->session->set_userdata('error_message', 'Payment Failed! Please try again.');
        }
        redirect(base_url());
    }
    // End of dynamic payment gateway module response


    public function sslcommerz_payment_success()
    {

        if(isset($_POST) && !empty($_POST)){

            $postdata = $_POST;
            $customer_id = $postdata['value_c'];
            $order_id = $postdata['value_a'];
            $txn_id = $postdata['tran_id'];

            $paydata = [
                'pay_method' => 4,
                'used_id' => 6,
                'customer_id' => $postdata['value_c'],
                'order_id' => $postdata['value_a'],
                'trans_id' => $postdata['tran_id'],
                'amount' => $postdata['amount'],
                'store_amount' => $postdata['store_amount'],
                'status' => $postdata['status'],
                'trans_date' => $postdata['tran_date'],
                'currency' => $postdata['currency'],
                'order_no' => $postdata['value_b'],
                'val_id' => $postdata['val_id'],
                'card_type' => $postdata['card_type'],
                'card_no' => $postdata['card_no'],
                'bank_tran_id' => $postdata['bank_tran_id'],
                'card_issuer' => $postdata['card_issuer'],
                'card_brand' => $postdata['card_brand'],
                'card_issuer_country' => $postdata['card_issuer_country'],
                'card_issuer_country_code' => $postdata['card_issuer_country_code'],
                'store_id' => $postdata['store_id'],
                'verify_sign' => $postdata['verify_sign'],
                'verify_key' => $postdata['verify_key'],
                'verify_sign_sha2' => $postdata['verify_sign_sha2'],
                'currency_type' => $postdata['currency_type'],
                'currency_rate' => $postdata['currency_rate'],
                'base_fair' => $postdata['base_fair'],
                'risk_level' => $postdata['risk_level'],
                'risk_title' => $postdata['risk_title']
            ];

            //Order entry
            $return_order_id = $this->Homes->order_entry($customer_id, $order_id, $paydata);

            $coupon_amnt = $this->session->userdata('coupon_amnt');
            if ($coupon_amnt > 0) {
                $this->order_coupon_update($customer_id, $order_id);
            }
            $result = $this->order_inserted_data($return_order_id);

            if ($result) {
                $this->cart->destroy();
                $this->session->set_userdata('message', display('product_successfully_order'));
                $this->cart->destroy();
            }else{
                $this->session->set_userdata('error_message', 'Order Failed! Contact with Admin. Your SSLCOMMERZ transaction id is '.$txn_id);
            }
            redirect(base_url());
        } else{
            $this->sslcommerz_payment_failed();
        }
    }

    public function sslcommerz_payment_cancel()
    {
        $this->session->set_userdata('error_message', display('transaction_cancel'));
        redirect(base_url());
    }

    public function sslcommerz_payment_failed()
    {
        $this->session->set_userdata('error_message', display('transaction_faild'));
        redirect(base_url());
    }

    public function payeerSuccess()
    {
        //Redirect value from get method
        $request = $this->input->get();
        $order_id = $request['m_orderid'];
        $customer_id = $this->session->userdata('customer_id');
        $amount = $this->session->userdata('cart_total');

        $transdata = [
                'pay_method' => 2,
                'used_id' => 4,
                'customer_id' => $customer_id,
                'order_id' => $order_id,
                'trans_id' => '',
                'amount' => $amount,
                'store_amount' => $amount,
                'status' => '1',
                'trans_date' => date('Y-m-d'),
                'currency' => 'USD'
            ];

        //Order entry
        $return_order_id = $this->Homes->order_entry($customer_id, $order_id, $transdata);

        $coupon_amnt = $this->session->userdata('coupon_amnt');
        if ($coupon_amnt > 0) {
            $this->order_coupon_update($customer_id, $order_id);
        }
        $result = $this->order_inserted_data($return_order_id);

        if ($result) {
            $this->cart->destroy();
            $this->session->set_userdata('message', display('product_successfully_order'));
            redirect(base_url());
        }
    }

    //Payeer fail
    public function payeerFail()
    {
        $this->session->set_userdata('error_message', display('order_cancel'));
        redirect(base_url());
    }

    //Paypal success
    public function paypal_success()
    {
        $data['title'] = display('order');
        #--------------------------------------

        $order_id = @$_GET['item_number'];
        //session token
        $token = $this->session->userdata('_tran_token');
        if ($token != $order_id) {
            redirect('paypal_cancel');
        }

        if(!empty($_GET['item_number']) && !empty($_GET['tx']) && !empty($_GET['amt']) && !empty($_GET['cc']) && !empty($_GET['st'])){

            // Get transaction information from URL 
             $item_number = $_GET['item_number'];  
             $txn_id = $_GET['tx']; 
             $payment_gross = $_GET['amt']; 
             $currency_code = $_GET['cc']; 
             $payment_status = $_GET['st']; 
             $customer_id = $_GET['customer_id']; 
             $order_id = $_GET['order_id']; 
             // Get product info from the URL

            $transdata = [
                'pay_method' => 3,
                'used_id' => 5,
                'customer_id' => $_GET['customer_id'],
                'order_id' => $_GET['order_id'],
                'trans_id' => $_GET['trans_id'],
                'amount' => $_GET['amt'],
                'store_amount' => $_GET['amt'],
                'status' => $_GET['st'],
                'trans_date' => date('Y-m-d'),
                'currency' => 'USD'
            ];

            //pass the transaction data to view 
            $return_order_id = $this->Homes->order_entry($customer_id, $order_id, $transdata);
            $coupon_amnt = $this->session->userdata('coupon_amnt');
            if ($coupon_amnt > 0) {
                $this->order_coupon_update($customer_id, $order_id);
            }
            $result = $this->order_inserted_data($return_order_id);

            if ($result) {
                $this->session->set_userdata('message', display('product_successfully_order'));
                $this->cart->destroy();
            }else{
                $this->session->set_userdata('error_message', 'Order Failed! Contact with Admin. Your paypal transaction id is '.$txn_id);
            }
            redirect(base_url());


         }else{
            redirect('paypal_cancel');
         }

    }

    //Paypal cancel
    public function paypal_cancel($order_id = null)
    {
        $this->session->set_userdata('error_message', display('transaction_faild'));
        redirect(base_url());
    }

    /*
    * Add this ipn url to your paypal account
    * Profile and Settings > My selling tools > 
    * Instant Payment Notification (IPN) > update 
    * Notification URL: (eg:- http://domain.com/web/home/ipn/)
    * Receive IPN messages (Enabled) 
    */
    public function paypal_ipn()
    {
        //paypal return transaction details array
        $paypalInfo = $this->input->post();

        if(!empty($paypalInfo)){

            $data['user_id'] = $paypalInfo['custom'];
            $data['product_id'] = $paypalInfo["item_number"];
            $data['txn_id'] = $paypalInfo["txn_id"];
            $data['payment_gross'] = $paypalInfo["mc_gross"];
            $data['currency_code'] = $paypalInfo["mc_currency"];
            $data['payer_email'] = $paypalInfo["payer_email"];
            $data['payment_status'] = $paypalInfo["payment_status"];

            $paypalURL = $this->paypal_lib->paypal_url;
            $result = $this->paypal_lib->curlPost($paypalURL, $paypalInfo);

            //check whether the payment is verified
            if (preg_match("/VERIFIED/i", $result)) {
                //insert the transaction data into the database
                $this->load->model('paypal_model');
                $this->paypal_model->insertTransaction($data);
            }
        }
    }


     //Retrive right now inserted data to create html
    public function order_inserted_data($order_id)
    {
        return $content = $this->lhome->order_html_data($order_id);
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

        if ($this->email->send()) {
            $this->session->set_userdata(array('message' => display('email_send_to_customer')));
            return true;
        } else {
            return false;
        }
    }

    //QR-Code Generator
    public function qrgenerator()
    {
        $this->load->library('ciqrcode');
        $config['cacheable'] = true; //boolean, the default is true
        $config['cachedir'] = ''; //string, the default is application/cache/
        $config['errorlog'] = ''; //string, the default is application/logs/
        $config['quality'] = true; //boolean, the default is true
        $config['size'] = '1024'; //interger, the default is 1024
        $config['black'] = array(224, 255, 255); // array, default is array(255,255,255)
        $config['white'] = array(70, 130, 180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
        //Create QR code image create

        $params['data'] = 'https://play.google.com/store/apps/details?id=com.bdtask.isshue&site=' . base_url() . '&valid=Isshue';
        $params['level'] = 'H';
        $params['size'] = 10;
        $image_name = 'isshue_qr.png';
        $params['savename'] = FCPATH . 'my-assets/image/qr/' . $image_name;
        $this->ciqrcode->generate($params);
        return true;
    }
    //This function is used to Generate Key
    public function generator($lenth)
    {
        $number = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "N", "M", "O", "P", "Q", "R", "S", "U", "V", "T", "W", "X", "Y", "Z", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

        for ($i = 0; $i < $lenth; $i++) {
            $rand_value = rand(0, 34);
            $rand_number = $number["$rand_value"];

            if (empty($con)) {
                $con = $rand_number;
            } else {
                $con = "$con" . "$rand_number";
            }
        }
        return $con;
    }

    public function quick_view_product()
    {
        $default_currency_id = $this->session->userdata('currency_id');
        $currency_new_id = $this->session->userdata('currency_new_id');
        if (empty($currency_new_id)) {
            $result = $cur_info = $this->db->select('*')
                ->from('currency_info')
                ->where('default_status', '1')
                ->get()
                ->row();
            $currency_new_id = $result->currency_id;
        }

        if (!empty($currency_new_id)) {
            $cur_info = $this->db->select('*')
                ->from('currency_info')
                ->where('currency_id', $currency_new_id)
                ->get()
                ->row();

            $target_con_rate = $cur_info->convertion_rate;
            $position1 = $cur_info->currency_position;
            $currency1 = $cur_info->currency_icon;
        }


        $product_id = $this->input->post('product_id',TRUE);

        $this->load->model('web/Products_model');
        $product_info = $this->Products_model->product_info($product_id);
        $stock = $this->Products_model->stock_report_single_item_by_store($product_id);


        $cur_price    = $product_info->price;
        $onsale       = $product_info->onsale;
        $onsale_price = $product_info->onsale_price;
        $default_color = '';

        if($product_info->variant_price){
            $varprices = $this->Products_model->get_variant_prices($product_id, $product_info->variants, $product_info->default_variant);
            if(!empty($varprices)){
                $cur_price        = $varprices['price'];
                $default_color = $varprices['var_color_id'];
            }
        }

        $is_affiliate = 0;
        if(check_module_status('affiliate_products') == 1){
            $is_affiliate = 1;
        }

        $html = '';
        $html .= '<div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <a href="#" data-dismiss="modal" class="class pull-right"><span
                                                class="glyphicon glyphicon-remove"></span></a>
                                    <h3 class="modal-title">' . html_escape($product_info->product_name) . '</h3>
                                    <input type="hidden" name="product_id" id="product_id" value="'.$product_id.'">
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-xs-5 product_img">
                                            <img src="' . base_url() . $product_info->image_thumb . '" class="img-responsive">
                                        </div>
                                        <div class="col-xs-7">
                                            <div class="product-summary-content">
                                                <div class="product-summary">';
        if ($onsale == 1 && !empty(@$onsale_price)) {
            $html .= '<span class="product-price">
                                                <span class="price-amount">
                                                    <span class="amount-details var_amount">';

            if ($target_con_rate > 1) {
                $price1 = $onsale_price * $target_con_rate;
                $html .= ($product_info->position1 == 0) ? $currency1 . " " . number_format($price1, 2, ".", ",") : number_format($price1, 2, ".", ",") . " " . $currency1;
            }
            if ($target_con_rate <= 1) {
                $price2 = $onsale_price * $target_con_rate;
                $html .= ($position1 == 0) ? $currency1 . " " . number_format($price2, 2, ".", ",") : number_format($price2, 2, ".", ",") . " " . $currency1;
            }

            $html .= '</span>
            <del><span class="amount2 regular_price">';

            if ($target_con_rate > 1) {
                $price = $cur_price * $target_con_rate;
                $html .= (($position1 == 0) ? $currency1 . " " . number_format($price, 2, ".", ",") : number_format($price, 2, ".", ",") . " " . $currency1);
            }

            if ($target_con_rate <= 1) {
                $price = $cur_price * $target_con_rate;
                $html .= (($position1 == 0) ? $currency1 . " " . number_format($price, 2, ".", ",") : number_format($price, 2, ".", ",") . " " . $currency1);
            }

            $html .= '</span></del>
                                                    <span class="amount"> </span>
                                                </span>
                                            </span>';

        } else {

            $html .= '<span class="product-price">
                                                <span class="price-amount">
                                                    <ins><span class="amount-details var_amount">';

            if ($target_con_rate > 1) {
                $price = $cur_price * $target_con_rate;
                $html .= (($position1 == 0) ? $currency1 . " " . number_format($price, 2, ".", ",") : number_format($price, 2, ".", ",") . " " . $currency1);
            }

            if ($target_con_rate <= 1) {
                $price = $cur_price * $target_con_rate;
                $html .= (($position1 == 0) ? $currency1 . " " . number_format($price, 2, ".", ",") : number_format($price, 2, ".", ",") . " " . $currency1);
            }

            $html .= '</span></ins>
                                                    <span class="amount"> </span>
                                                </span>
                                            </span>';

        }

        $html .= '</div>
                <ul class="summary-header">
                    <li>';

                   if(!($is_affiliate == 1)){ 
                        $html .= '<p class="stock"><label>'.display('status').':</label>
                            <input type="hidden" value="'.html_escape($stock).'" id="stok">';
                            if ($stock > 0) {
                                $html .= '<span>'.display('in_stock').'</span>';
                            } else {
                                $html .= '<span class="required">'.display('out_of_stock').'</span>';
                            }
                        $html .= '</p>';
                    }

                $html .= '</li>
                            </ul>
                            <div class="short-description">' . htmlspecialchars_decode($product_info->product_details);

                            if (!empty($product_info->variants)) {

                        $html .= '<div class="product_size">';
                            $var_types = [];
                            $exploded = explode(',', $product_info->variants);
                            $this->db->select('*');
                            $this->db->from('variant');
                            $this->db->where_in('variant_id', $exploded);
                            $this->db->order_by('variant_name', 'asc');
                            $vresult = $this->db->get()->result();

                            $var_types = array_column($vresult, 'variant_type');

                            $html .= '<div class="form-group">
                                <div style="display: inline-block; vertical-align: top;">
                                    <label for="select_size1" class="variant-label">' . display("product_size") . '<span
                                            style="color: red;font-size: 1.8em;"
                                        >*</span> :
                                    </label>
                                </div>
                                 <div style="display: inline-block">'.
                                    form_open('#').'
                                        <select id="select_size1" required="" class="form-control select">
                                            <option value="0">Select</option>';

                                            foreach ($vresult as $vitem) {
                                                if($vitem->variant_type=='size'){
                                            

                                                    $html .= '<option value="' . $vitem->variant_id . '" '.(($vitem->variant_id == $product_info->default_variant)?"selected":""); 
                                                    $html .= '>' . html_escape($vitem->variant_name) . '</option>';

                                                }
                                            }

                                    $html .= '</select>'.form_close().'
                                </div>
                            </div>
                        </div>';

                        if(in_array('color', $var_types)){
                            $html .= '<div class="product-color mb-3">';
                                    foreach ($vresult as $vitem) {
                                        if($vitem->variant_type=='color'){

                                            if(empty($default_color)){
                                                $default_color = $vitem->variant_id;  // Set default color if not getting
                                            }
                                            
                                    $html .= '<input type="radio" class="product_colors" name="select_color" id="color_'.$vitem->variant_id.'" value="'.$vitem->variant_id.'" onclick="select_color_variant(\''.html_escape($product_id).'\',\''.html_escape($vitem->variant_id).'\', \''.html_escape($product_info->default_variant).'\')" '.(($vitem->variant_id == $default_color)?'checked="checked"':"").'>
                                    <label class="mb-0" for="color_'.$vitem->variant_id.'"><span class="color_code" style="background: '.(!empty($vitem->color_code)?$vitem->color_code:strtolower($vitem->variant_name)).'"></span></label>';

                                  } }

                            $html .= '</div>';
                            } }
                        $html .= '<input type="hidden" name="color_variant_id" id="color_variant_id" value="'.@$default_color.'"></div>'.
                        form_open('', array('class'=>'cart-row')).'
                                <div class="cart_counter">                                   
                                    <button onclick="var result = document.getElementById(\'sst\'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 1 ) result.value--;return false;"
                                            class="reduced items-count" type="button">                                        
                                        <span class="qty qty-minus" data-dir="dwn">-</span>
                                    </button>
                                    <input type="text" name="qty" id="sst" data-product-id="' . $product_id . '" maxlength="12" value="1"
                                           title="' . display("quantity") . '" class="input-text qty form-control text-center single-product-id" min="1">
                                    <button onclick="var result = document.getElementById(\'sst\'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                                            class="increase items-count" type="button">                                       
                                        <span class="qty qty-plus" data-dir="up">+</span>
                                    </button>
                                </div>';


        if ($stock > 0) {
            $html .= '<a href="javascript:void(0)" onclick="cart_btn(' . $product_id . ')" class="cart-btn" type="submit">' . display("add_to_cart") . '</a>';
        }
        $html .= '<a href="javascript:void(0)" class="add-wishlist wishlist" data-toggle="tooltip"
                                   data-placement="top"
                                   title="' . display("wishlist") . '" name="' . $product_id . '"><i class="lnr lnr-heart"></i></a>
                                   <a href="javascript:void(0)" class="add-compare comparison" onclick="comparison_btn('. $product_id .')" title="Compare">
                                    <i class="lnr lnr-chart-bars"></i>
                                </a>
                            '.form_close().'
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
        echo $html;
    }

    //Delete all cart data
    public function clear_cart()
    {
        $this->session->unset_userdata(array('coupon_id','coupon_amnt'));
        $this->cart->destroy();
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect('view_cart');
    }

    // Track order
    public function track_my_order()
    {
        $this->form_validation->set_rules('order_email', display('email'), 'trim|required|valid_email');
        $this->form_validation->set_rules('order_number', display('order_no'), 'trim|required');

        $order_detail = [];
        if($this->form_validation->run() == TRUE)
        {
            $this->load->model('dashboard/Orders');
            $this->load->model('web/Homes');
            $this->load->model('dashboard/Soft_settings');
            $this->load->library('dashboard/occational');
            $order_email = $this->input->post('order_email', TRUE);
            $order_number = $this->input->post('order_number', TRUE);
            $order_detail = $this->Homes->get_order_html_data($order_email, $order_number);
        }
        $content = $this->lhome->track_my_order($order_detail);
        $this->template_lib->full_website_html_view($content);
    }

    public function comparison(){
        $this->load->model('dashboard/Themes');
        $this->load->model('web/Products_model');
        $theme   = $this->Themes->get_theme();
        $data    = $this->Products_model->comparison();
        $content = $this->lhome->compare_product($data);
        $this->template_lib->full_website_html_view($content);
    }
 
}