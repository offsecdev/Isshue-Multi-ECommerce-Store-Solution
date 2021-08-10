<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Homes extends CI_Model
{

    private $table = "language";
    private $phrase = "phrase";

    public function __construct()
    {
        parent::__construct();
    }

    //Parent Category List
    public function parent_category_list()
    {
        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->where('cat_type', 1);
        $this->db->where('status', 1);
        $this->db->order_by('menu_pos');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    //Category list
    public function category_list()
    {
        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->order_by('category_name', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    // retrieve all product that are all sell in this week to show mobile view
    public function get_this_week_sell_product()
    {
        $today = date('m-d-Y');
        $week = date('m-d-Y', strtotime('-7 days'));
        $product_ids = $this->db->select('product_id')
            ->from('invoice a')
            ->join('invoice_details b', 'a.invoice_id=b.invoice_id')
            ->where('a.date>=', $week)
            ->where('a.date<=', $today)
            ->get()
            ->result_array();
        $product_ids = array_column($product_ids, 'product_id');
        $unique_product_ids = array_unique(array_filter($product_ids));
        if (!empty($unique_product_ids)) {
            $result = $this->db->select('*')
                ->from('product_information')
                ->where_in('product_id', $unique_product_ids)
                ->get()
                ->result();
            return $result;
        } else {
            return $result = [];
        }
    }

    //Best sales list
    public function best_sales()
    {
        $this->db->select('a.*,b.category_name,c.brand_name');
        $this->db->from('product_information a');
        $this->db->join('product_category b', 'a.category_id=b.category_id');
        $this->db->join('brand c', 'a.brand_id=c.brand_id', 'left');
        $this->db->where('best_sale', '1');
        $this->db->order_by('id', 'desc');
        $this->db->limit('6');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

//All sub category list
    public function get_sub_category($category_id)
    {
        $main_cat = array();
        $sub_cate_gory = $this->db->select('*')
            ->from('product_category')
            ->where('parent_category_id', $category_id)
            ->order_by('menu_pos')
            ->where('cat_type', 2)
            ->get()
            ->result();

        if ($sub_cate_gory) {
            foreach ($sub_cate_gory as $s_category) {
                $sub_cat = array();

                if ($s_category) {
                    $parent_cat = array(
                        'category_id' => $s_category->category_id,
                        'category_name' => $s_category->category_name,
                    );

                    $l_category = $this->db->select('*')
                        ->from('product_category')
                        ->where('parent_category_id', $s_category->category_id)
                        ->order_by('menu_pos')
                        ->where('cat_type', 2)
                        ->get()
                        ->result();

                    if ($l_category) {
                        foreach ($l_category as $category) {
                            if ($category) {
                                $data = array(
                                    'category_id' => $category->category_id,
                                    'category_name' => $category->category_name,
                                );
                                array_push($sub_cat, $data);
                            }
                        }
                    }
                }

                $parent_cat['categorieslevelone'] = $sub_cat;
                array_push($main_cat, $parent_cat);
            }
        }
        return $main_cat;
    }

    //show this week sales product brand on home page
    public function get_this_week_brand()
    {
        $today = date('m-d-Y');
        $week = date('m-d-Y', strtotime('-7 days'));

        
        $brand_ids = $this->db->select('brand_id')
            ->from('invoice a')
            ->join('invoice_details b', 'a.invoice_id=b.invoice_id')
            ->join('product_information c', 'b.product_id=c.product_id')
            ->where("STR_TO_DATE(a.date,'%m-%d-%Y') BETWEEN DATE('".$week."') AND DATE('".$today."')")
            ->get()
            ->result_array();
        $brand_ids = array_column($brand_ids, 'brand_id');
        $unique_brand_id = array_unique(array_filter($brand_ids));
        if (!empty($unique_brand_id)) {
            $result = $this->db->select('*')
                ->from('brand')
                ->where_in('brand_id', $unique_brand_id)
                ->get()
                ->result();
            return $result;
        } else {
            $result = $this->db->select('*')
                ->from('brand')
                ->limit(12)
                ->get()
                ->result();
            return $result;
        }

    }

    //Get all subcategory list
    public function get_sub_category_list($category_id)
    {
        $main_cat = array();
        $sub_cate_gory = $this->db->select('*')
            ->from('product_category')
            ->where('parent_category_id', $category_id)
            ->order_by('menu_pos')
            ->where('cat_type', 2)
            ->limit(8)
            ->get()
            ->result();

        if ($sub_cate_gory) {
            foreach ($sub_cate_gory as $s_category) {
                $parent_cat = array(
                    'category_id' => $s_category->category_id,
                    'category_name' => $s_category->category_name,
                    'menu_pos' => $s_category->menu_pos,
                    'cat_favicon' => $s_category->cat_favicon,
                    'cat_image' => $s_category->cat_image,
                );

                $l_category = $this->db->select('*')
                    ->from('product_category')
                    ->where('parent_category_id', $s_category->category_id)
                    ->order_by('menu_pos')
                    ->where('cat_type', 2)
                    ->limit(8)
                    ->get()
                    ->result();

                if ($l_category) {
                    foreach ($l_category as $category) {
                        $data = array(
                            'category_id' => $category->category_id,
                            'category_name' => $category->category_name,
                            'menu_pos' => $category->menu_pos,
                            'cat_favicon' => $category->cat_favicon,
                            'cat_image' => $category->cat_image,
                        );
                        array_push($main_cat, $data);
                    }

                }
                array_push($main_cat, $parent_cat);
            }
        }
        return $main_cat;
    }

    //Category list by id
    public function category_list_by_id($category_id = null)
    {
        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->where('category_id', $category_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    //One level subcategory list
    public function get_one_level_sub_category($category_id)
    {
        $main_cat = array();
        $sub_cate_gory = $this->db->select('*')
            ->from('product_category')
            ->where('parent_category_id', $category_id)
            ->order_by('menu_pos')
            ->where('cat_type', 2)
            ->get()
            ->result();

        if ($sub_cate_gory) {
            foreach ($sub_cate_gory as $s_category) {
                if ($s_category) {
                    $parent_cat = array(
                        'category_id' => $s_category->category_id,
                        'category_name' => $s_category->category_name,
                    );
                }
                array_push($main_cat, $parent_cat);
            }
        }
        return $main_cat;
    }

    //Get one level featured category
    public function get_one_level_featured_category($category_id)
    {
        $main_cat = array();
        $sub_cate_gory = $this->db->select('*')
            ->from('product_category')
            ->where('parent_category_id', $category_id)
            ->order_by('menu_pos')
            ->where('cat_type', 2)
            ->limit(12)
            ->get()
            ->result();

        if ($sub_cate_gory) {
            foreach ($sub_cate_gory as $s_category) {
                $parent_cat = array(
                    'category_id' => $s_category->category_id,
                    'category_name' => $s_category->category_name,
                    'menu_pos' => $s_category->menu_pos,
                    'cat_image' => $s_category->cat_image,
                );
                array_push($main_cat, $parent_cat);
            }
        }
        return $main_cat;
    }

    public function most_popular_product()
    {
        $product_ids = $this->db->query('SELECT DISTINCT product_id FROM `order_details`')->result_array();

        $product_ids = array_column($product_ids, 'product_id');
        if (!empty($product_ids)) {
            $result = $this->db->select('
    pi.*, pc.*,b.brand_name')
                ->from('product_information as pi')
                ->join('product_category as pc', 'pc.category_id = pi.category_id')
                ->join('brand as b', 'b.brand_id=pi.brand_id')
                ->where_in('pi.product_id', $product_ids)
                ->limit(15)
                ->get()
                ->result();
            if ($result) {
                return $result;
            }
            return false;
        }
        
    }


    //Footer block
    public function footer_block()
    {
        $this->db->select('*');
        $this->db->from('web_footer');
        $this->db->where('status',1);
        $this->db->order_by('position');
        $this->db->limit('2');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    //Add Wishlist
    public function add_wishlist($data)
    {

        $user_id = $data['user_id'];
        $product_id = $data['product_id'];

        $this->db->select('*');
        $this->db->from('wishlist');
        $this->db->where('user_id', $data['user_id']);
        $this->db->where('product_id', $data['product_id']);
        $this->db->where('status', 1);
        $query = $this->db->get();
        $r = $query->num_rows();

        if ($r > 0) {
            return false;
        } else {
            $result = $this->db->insert('wishlist', $data);
            return true;
        }
    }

    //Add Wishlist
    public function remove_wishlist($data)
    {
        $user_id = $data['user_id'];
        $product_id = $data['product_id'];
        $this->db->where('user_id', $user_id);
        $this->db->where('product_id', $product_id);
        $this->db->delete('wishlist');
        return true;
    }

    //Add Review
    public function add_review($data)
    {
        $reviewer_id = $data['reviewer_id'];
        $product_id = $data['product_id'];

        $this->db->select('*');
        $this->db->from('product_review');
        $this->db->where('reviewer_id', $data['reviewer_id']);
        $this->db->where('product_id', $data['product_id']);
        $query = $this->db->get();
        $r = $query->num_rows();

        if ($r > 0) {
            return false;
        } else {
            $this->db->insert('product_review', $data);
            return true;
        }
    }

    //Currency info
    public function currency_info()
    {
        $this->db->select('*');
        $this->db->from('currency_info');
        $this->db->order_by('currency_name');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    //Selected currency info
    public function selected_currency_info()
    {
        $cur_id = $this->session->userdata('currency_id');
        if (!empty($cur_id)) {
            $this->db->select('*');
            $this->db->from('currency_info');
            $this->db->where('currency_id', $cur_id);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->row();
            } else {
                return false;
            }
        } else {
            $this->db->select('*');
            $this->db->from('currency_info');
            $this->db->where('default_status', '1');
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->row();
            } else {
                return false;
            }
        }
        return false;
    }

    //Select default currency info
    function selected_default_currency_info()
    {
        $this->db->select('*');
        $this->db->from('currency_info');
        $this->db->where('default_status', '1');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return 0;
    }

    //Selecte country info
    public function selected_country_info()
    {
        $this->db->select('*');
        $this->db->from('countries');
        $this->db->order_by('id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    //Selecte district info
    public function select_district_info($country_id)
    {
        $this->db->select('*');
        $this->db->from('states');
        $this->db->where('country_id', $country_id);
        $this->db->order_by('id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    //Selecte shipping method
    public function select_shipping_method()
    {
        $this->db->select('*');
        $this->db->from('shipping_method');
        $this->db->order_by('position');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    //Ship And Bill Entry
    public function ship_and_bill_entry($data)
    {
        $bill = $this->db->insert('customer_information', $data);
        if ($bill) {
            $result = $this->db->insert('shipping_info', $data);
            return true;
        }
        return false;
    }

    //Billing Entry
    public function billing_entry($data)
    {
        $bill = $this->db->insert('customer_information', $data);
        if ($bill) {
            return true;
        }
        return false;
    }

    //Shipping Entry
    public function shipping_entry($data)
    {

        $result = $this->db->insert('shipping_info', $data);
        if ($result) {
            return true;
        }
        return false;
    }

//when any customer will purchase a product his information will be updated
    public function update_billing_entry($data, $customer_id)
    {
        $this->db->where('customer_id', $customer_id);
        $this->db->update('customer_information', $data);
    }

    //Select state by country
    public function select_state_country()
    {

        $country_id = $this->session->userdata('country');

        $this->db->select('*');
        $this->db->from('states');
        $this->db->where('country_id', $country_id);
        $this->db->order_by('name');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;

        $result = $this->db->insert('shipping_info', $data);
        if ($result) {
            return true;
        }
        return false;
    }

 //Select state by country
    public function get_country_state($country_id)
    {

        $this->db->select('*');
        $this->db->from('states');
        $this->db->where('country_id', $country_id);
        $this->db->order_by('name');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;

    }

    public function get_country_name($country_id)
    {
        $this->db->select('*');
        $this->db->from('countries');
        $this->db->where('id', $country_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    //Select ship state by country
    public function select_ship_state_country()
    {

        $ship_country = $this->session->userdata('ship_country');

        $this->db->select('*');
        $this->db->from('states');
        $this->db->where('country_id', $ship_country);
        $this->db->order_by('name');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;

        $result = $this->db->insert('shipping_info', $data);
        if ($result) {
            return true;
        }
        return false;
    }

    //Customer existing check
    public function check_customer($email)
    {
        $this->db->select('*');
        $this->db->from('customer_information');
        $this->db->where('customer_email', $email);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    //Select home adds
    public function select_home_adds()
    {
        $this->db->select('*');
        $this->db->from('advertisement');
        $this->db->where('add_page', 'home');
        $this->db->where('status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    //get category page  adds
    public function select_category_adds()
    {
        $this->db->select('*');
        $this->db->from('advertisement');
        $this->db->where('add_page', 'category');
        $this->db->where('status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    //get details page  adds
    public function select_details_adds()
    {
        $this->db->select('*');
        $this->db->from('advertisement');
        $this->db->where('add_page', 'details');
        $this->db->where('status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    //Product Details
    public function product_details($product_id)
    {
        $this->db->select('*');
        $this->db->from('product_information');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }


//send sms after order completed
    public function send_sms($order_no = null, $customer_id = null, $type = null)
    {

        $CI =& get_instance();
        $CI->load->model('dashboard/Soft_settings');
        $gateway = $CI->Soft_settings->retrieve_active_getway();
        $sms_template = $CI->db->select('*')->from('sms_template')->where('type', $type)->get()->row();
        $sms = $CI->db->select('*')->from('sms_configuration')->where('status','1')->get()->row();
        $customer_info = $CI->db->select('customer_mobile')->from('customer_information')->where('customer_id', $customer_id)->get()->row();
        if (1 == $gateway->id) {

            /****************************
             * SMSRank Gateway Setup
             ****************************/

            $sms_type = strtolower($sms_template->type);
            if ($sms_type == "order" || $sms_type == "processing" || $sms_type == "shipped") {
                $message = str_replace('{id}', $order_no, $sms_template->message);
            }


            $url = "http://api.smsrank.com/sms/1/text/singles";
            $username = $sms->user_name;
            $password = base64_encode($sms->password);
            $message = base64_encode($message);
            $recipients = $customer_info->customer_mobile;

            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, "$url?username=$username&password=$password&to=$recipients&text=$message");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';
            curl_setopt($curl, CURLOPT_USERAGENT, $agent);
            $output = json_decode(curl_exec($curl), true);
            return true;
            curl_close($curl);
        }

        if (2 == $gateway->id) {
            /****************************
             * nexmo Gateway Setup
             ****************************/
            $api = $sms->user_name;
            $secret_key = $sms->password;
            $message = $sms_template->message;
            $from = $sms->sms_from;


            $data = array(
                'from' => $from,
                'text' => $message,
                'to' => $customer_info->customer_mobile
            );

            require_once APPPATH . 'libraries/nexmo/vendor/autoload.php';

            $basic = new \Nexmo\Client\Credentials\Basic($api, $secret_key);
            $client = new \Nexmo\Client($basic);

            $message = $client->message()->send($data);

            if (!$message) {
                return json_encode(array(
                    'status' => false,
                    'message' => 'Curl error: '
                ));
            } else {
                return json_encode(array(
                    'status' => true,
                    'message' => "success: "
                ));
            }


        }

        if (3 == $gateway->id) {
            /****************************
             * budgetsms Gateway Setup
             ****************************/
            $message = $sms_template->message;
            $from = $sms->sms_from;
            $userid = $sms->userid;
            $username = $sms->user_name;
            $handle = $sms->password;

            $data = array(
                'handle' => $handle,
                'username' => $username,
                'userid' => $userid,
                'from' => $from,
                'msg' => $message,
                'to' => $customer_info->customer_mobile
            );

            $url = "https://api.budgetsms.net/sendsms/?";
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($curl);

            if (curl_errno($curl)) {
                return json_encode(array(
                    'status' => false,
                    'message' => 'Curl error: ' . curl_error($curl)
                ));
            } else {
                return json_encode(array(
                    'status' => true,
                    'message' => "success: " . $response
                ));
            }

            curl_close($curl);


        }

    }

    //Order entry
    public function order_entry($customer_id, $order_id, $transdata = [])
    {

        //Retrive default store
        $default_store = $this->db->select('store_id')
            ->from('store_set')
            ->where('default_status', '1')
            ->get()
            ->row();

        $payment_method = $this->session->userdata('payment_method');
        if ($payment_method == 1) {
            //Data inserting into order table
            $data = array(
                'order_id' => $order_id,
                'customer_id' => $customer_id,
                'store_id' => (!empty($default_store->store_id) ? $default_store->store_id : null),
                'date' => date("m-d-Y"),
                'total_amount' => $this->session->userdata('cart_total'),
                'order' => $order = $this->number_generator_order(),
                'total_discount' => $this->session->userdata('total_discount'),
                'order_discount' => $this->session->userdata('total_discount'),
                'due_amount' => $this->session->userdata('cart_total'),
                'service_charge' => $this->session->userdata('cart_ship_cost'),
                'coupon' => ($this->session->userdata('coupon_code')) ? $this->session->userdata('coupon_code') : '',
                'status' => 1
            );
            //Data inserting into order table for payment gateway
            $this->db->insert('order', $data);

        }else if(in_array($payment_method, [3,4,5,6])) {
            // If payment paid by payment gateway

            $due_amount = $paid_amount = 0;
            if(!empty($transdata) && !empty($transdata['amount'])){
                $paid_amount  = $transdata['amount'];
            }else{
                $due_amount = $this->session->userdata('cart_total');
            }
            $data = array(
                'order_id' => $order_id,
                'customer_id' => $customer_id,
                'store_id' => (!empty($default_store->store_id) ? $default_store->store_id : null),
                'date' => date("m-d-Y"),
                'total_amount' => $this->session->userdata('cart_total'),
                'order' => $order = $this->number_generator_order(),
                'total_discount' => $this->session->userdata('total_discount'),
                'order_discount' => $this->session->userdata('total_discount'),
                'paid_amount' => $paid_amount,
                'due_amount' => $due_amount,
                'service_charge' => $this->session->userdata('cart_ship_cost'),
                'status' => 1
            );
            $this->db->insert('order', $data);
        
        } else {

            $due_amount = $paid_amount = 0;
            if(!empty($transdata) && !empty($transdata['amount'])){
                $paid_amount  = $transdata['amount'];
            }else{
                $due_amount = $this->session->userdata('cart_total');
            }

            
            //Data inserting into order table for payment gateway
            $data = array(
                'order_id' => $order_id,
                'customer_id' => $customer_id,
                'store_id' => (!empty($default_store->store_id) ? $default_store->store_id : null),
                'date' => date("m-d-Y"),
                'total_amount' => $this->session->userdata('cart_total'),
                'order' => $order = $this->number_generator_order(),
                'total_discount' => $this->session->userdata('total_discount'),
                'order_discount' => $this->session->userdata('total_discount'),
                'paid_amount' => $paid_amount,
                'due_amount' => $due_amount,
                'service_charge' => $this->session->userdata('cart_ship_cost'),
                'status' => 1
            );
            $this->db->insert('order', $data);
        }

        //Delivery method entry
        $data = array(
            'order_delivery_id' => $this->auth->generator(15),
            'delivery_id' => $this->session->userdata('method_id'),
            'order_id' => $order_id,
            'details' => $this->session->userdata('delivery_details'),
        );

        $this->db->insert('order_delivery', $data);

        //Delivery order payment entry
        $data = array(
            'order_payment_id' => $this->auth->generator(15),
            'payment_id' => $this->session->userdata('payment_method'),
            'order_id' => $order_id,
            'details' => $this->session->userdata('payment_details'),
        );
        $this->db->insert('order_payment', $data);

        //Insert order to order details
        if ($this->cart->contents()) {
            foreach ($this->cart->contents() as $items) {
                $order_details = array(
                    'order_details_id' => $this->auth->generator(15),
                    'order_id' => $order_id,
                    'product_id' => $items['product_id'],
                    'variant_id' => $items['variant'],
                    'variant_color' => (!empty($items['variant_color'])?$items['variant_color']:NULL),
                    'store_id' => (!empty($default_store->store_id) ? $default_store->store_id : null),
                    'quantity' => $items['qty'],
                    'rate' => $items['actual_price'],
                    'supplier_rate' => $items['supplier_price'],
                    'total_price' => $items['actual_price'] * $items['qty'],
                    'discount' => $items['discount'],
                    'status' => 1
                );

                if (!empty($items)) {
                    $this->db->insert('order_details', $order_details);
                }

                //CGST Tax summary
                $cgst_summary = array(
                    'order_tax_col_id' => $this->auth->generator(15),
                    'order_id' => $order_id,
                    'tax_amount' => $items['options']['cgst'] * $items['qty'],
                    'tax_id' => $items['options']['cgst_id'],
                    'date' => date("m-d-Y"),
                );

                if (!empty($items['options']['cgst_id'])) {
                    $result = $this->db->select('*')
                        ->from('order_tax_col_summary')
                        ->where('order_id', $order_id)
                        ->where('tax_id', $items['options']['cgst_id'])
                        ->get()
                        ->num_rows();

                    if ($result > 0) {
                        $this->db->set('tax_amount', 'tax_amount+' . $items['options']['cgst'] * $items['qty'], FALSE);
                        $this->db->where('order_id', $order_id);
                        $this->db->where('tax_id', $items['options']['cgst_id']);
                        $this->db->update('order_tax_col_summary');
                    } else {
                        $this->db->insert('order_tax_col_summary', $cgst_summary);
                    }
                }
                //CGST Summary End

                //IGST Tax summary
                $igst_summary = array(
                    'order_tax_col_id' => $this->auth->generator(15),
                    'order_id' => $order_id,
                    'tax_amount' => $items['options']['igst'] * $items['qty'],
                    'tax_id' => $items['options']['igst_id'],
                    'date' => date("m-d-Y"),
                );

                if (!empty($items['options']['igst_id'])) {
                    $result = $this->db->select('*')
                        ->from('order_tax_col_summary')
                        ->where('order_id', $order_id)
                        ->where('tax_id', $items['options']['igst_id'])
                        ->get()
                        ->num_rows();

                    if ($result > 0) {
                        $this->db->set('tax_amount', 'tax_amount+' . $items['options']['igst'] * $items['qty'], FALSE);
                        $this->db->where('order_id', $order_id);
                        $this->db->where('tax_id', $items['options']['igst_id']);
                        $this->db->update('order_tax_col_summary');
                    } else {
                        $this->db->insert('order_tax_col_summary', $igst_summary);
                    }
                }
                //IGST Tax summary end

                //SGST Tax summary
                $sgst_summary = array(
                    'order_tax_col_id' => $this->auth->generator(15),
                    'order_id' => $order_id,
                    'tax_amount' => $items['options']['sgst'] * $items['qty'],
                    'tax_id' => $items['options']['sgst_id'],
                    'date' => date("m-d-Y"),
                );

                if (!empty($items['options']['sgst_id'])) {
                    $result = $this->db->select('*')
                        ->from('order_tax_col_summary')
                        ->where('order_id', $order_id)
                        ->where('tax_id', $items['options']['sgst_id'])
                        ->get()
                        ->num_rows();

                    if ($result > 0) {
                        $this->db->set('tax_amount', 'tax_amount+' . $items['options']['sgst'] * $items['qty'], FALSE);
                        $this->db->where('order_id', $order_id);
                        $this->db->where('tax_id', $items['options']['sgst_id']);
                        $this->db->update('order_tax_col_summary');
                    } else {
                        $this->db->insert('order_tax_col_summary', $sgst_summary);
                    }
                }
                //SGST Tax summary end

                //CGST Details
                $cgst_details = array(
                    'order_tax_col_de_id' => $this->auth->generator(15),
                    'order_id' => $order_id,
                    'amount' => $items['options']['cgst'] * $items['qty'],
                    'product_id' => $items['product_id'],
                    'tax_id' => $items['options']['cgst_id'],
                    'variant_id' => $items['variant'],
                    'date' => date("m-d-Y"),
                );
                if (!empty($items['options']['cgst_id'])) {
                    $this->db->insert('order_tax_col_details', $cgst_details);
                }
                //CGST Details End

                //IGST Details
                $igst_details = array(
                    'order_tax_col_de_id' => $this->auth->generator(15),
                    'order_id' => $order_id,
                    'amount' => $items['options']['igst'] * $items['qty'],
                    'product_id' => $items['product_id'],
                    'tax_id' => $items['options']['igst_id'],
                    'variant_id' => $items['variant'],
                    'date' => date("m-d-Y"),
                );
                if (!empty($items['options']['igst_id'])) {
                    $this->db->insert('order_tax_col_details', $igst_details);
                }
                //IGST Details End

                //SGST Details
                $sgst_details = array(
                    'order_tax_col_de_id' => $this->auth->generator(15),
                    'order_id' => $order_id,
                    'amount' => $items['options']['sgst'] * $items['qty'],
                    'product_id' => $items['product_id'],
                    'tax_id' => $items['options']['sgst_id'],
                    'variant_id' => $items['variant'],
                    'date' => date("m-d-Y"),
                );
                if (!empty($items['options']['sgst_id'])) {
                    $this->db->insert('order_tax_col_details', $sgst_details);
                }
                //SGST Details End
            }
        }
        
        $sms_status = $this->db->select('sms_service')->from('soft_setting')->get()->result_array();
        if ($sms_status[0]['sms_service'] == 1) {
            $this->send_sms($order, $customer_id, $type = "Order");
        }
        return $order_id;
    }

    //Retrieve order_html_data
    public function retrieve_order_html_data($order_id)
    {
        $this->db->select('
        a.*,
        b.*,
        c.*,
        d.product_id,
        d.product_name,
        d.product_details,
        d.product_model,d.unit,
        e.unit_short_name,
        f.variant_name,
        a.details
        ');
        $this->db->from('order a');
        $this->db->join('customer_information b', 'b.customer_id = a.customer_id');
        $this->db->join('order_details c', 'c.order_id = a.order_id');
        $this->db->join('product_information d', 'd.product_id = c.product_id');
        $this->db->join('unit e', 'e.unit_id = d.unit', 'left');
        $this->db->join('variant f', 'f.variant_id = c.variant_id', 'left');
        $this->db->where('a.order_id', $order_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }


    //NUMBER GENERATOR FOR ORDER
    public function number_generator_order()
    {
        $this->db->select_max('order', 'order_no');
        $query = $this->db->get('order');
        $result = $query->result_array();
        $order_no = $result[0]['order_no'];
        if ($order_no != '') {
            $order_no = $order_no + 1;
        } else {
            $order_no = 1000;
        }
        return $order_no;
    }

    //Retrive all language
    public function languages()
    {
        if ($this->db->table_exists($this->table)) {

            $fields = $this->db->field_data($this->table);

            $i = 1;
            foreach ($fields as $field) {
                if ($i++ > 2)
                    $result[$field->name] = ucfirst($field->name);
            }

            if (!empty($result)) return $result;

        } else {
            return false;
        }
    }

    //Payment status
    public function payment_status($id = null)
    {
        return $payeer_result = $this->db->select('*')
            ->from('payment_gateway')
            ->where('id', $id)
            ->get()
            ->row();

    }

    // Enabled tax list
    public function get_enabled_tax_list()
    {
        $this->db->where('status', 1);
        $result = $this->db->get('tax')->result();
        return $result;
    }

    // Check Product Tax Status
    public function get_product_tax_info($product_id, $tax_id)
    {
        $this->db->select('a.*, b.status as tax_status');
        $this->db->from('tax_product_service a');
        $this->db->join('tax b','b.tax_id=a.tax_id','left');
        $this->db->where('a.product_id', $product_id);
        $this->db->where('a.tax_id', $tax_id);
        $tax_info = $this->db->get()->row();
        return $tax_info;
    }

    //Payment status
    public function get_payment_gateway_list()
    {
        $result = $this->db->select('*')
            ->from('payment_gateway')
            ->where('status','1')
            ->order_by('id','asc')
            ->get()
            ->result_array();
        return $result;
    }

    // Get payment method info by used ID
    public function get_payment_gateway_by_id($payment_method)
    {
        $result = $this->db->select('*')
            ->from('payment_gateway')
            ->where('status','1')
            ->where('used_id',$payment_method)
            ->get()
            ->row();
        return $result;
    }


    // Web order details
    public function get_order_html_data($order_email, $order_number)
    {
        $this->db->select('
            a.*,
            b.*,
            c.*,
            d.product_id,
            d.product_name,
            d.product_details,
            d.product_model,d.unit,
            e.unit_short_name,
            f.variant_name,
            g.variant_name as variant_color_name,
            a.details
            ');
        $this->db->from('order a');
        $this->db->join('customer_information b','b.customer_id = a.customer_id', 'left');
        $this->db->join('order_details c','c.order_id = a.order_id', 'left');
        $this->db->join('product_information d','d.product_id = c.product_id', 'left');
        $this->db->join('unit e','e.unit_id = d.unit','left', 'left');
        $this->db->join('variant f','f.variant_id = c.variant_id','left');
        $this->db->join('variant g','g.variant_id = c.variant_color','left');
        $this->db->where('a.order',$order_number);
        $this->db->where('b.customer_email',$order_email);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();  
        }
        return false;
    }

     // Order payment info
    public function get_order_payinfo($order_id=false)
    {
        if(empty($order_id))
            return false;

        return $this->db->select('a.*, b.agent as payment_method')
            ->from('order_payment a')
            ->join('payment_gateway b', 'a.payment_id=b.used_id','left')
            ->where('a.order_id', $order_id)
            ->get()->row_array();


    }

    // order status
    public function get_order_stutus($order_id=false)
    {
        if(empty($order_id))
            return false;

        $invinfo = $this->db->select('invoice_status')
            ->from('invoice')
            ->where('order_id', $order_id)
            ->get()->row();
        if(!empty($invinfo->invoice_status)){
            return $invinfo->invoice_status;
        }else{
            return false;
        }
    }

    //brand List
    public function get_brand_list()
    {
        $this->db->select('*');
        $this->db->from('brand');
        $this->db->where('status','1');
        $this->db->order_by('brand_name','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();  
        }
        return false;
    }

    // Insert Product visit analytics
    public function insert_product_page_visit($product_id)
    {
        $result = $this->db->query("INSERT INTO `site_analytics` (product_id,clicks) VALUES ('".$product_id."',1) ON DUPLICATE KEY UPDATE clicks = clicks+1");
        return $result;
    }

}