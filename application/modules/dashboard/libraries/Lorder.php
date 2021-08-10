<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lorder {

    //Order Add Form
    public function order_add_form()
    {
        $CI =& get_instance();
        $CI->load->model('dashboard/Orders');
        $CI->load->model('dashboard/Stores');
        $CI->load->model('dashboard/Variants');

        $store_list 		= $CI->Stores->store_list();
        $variant_list 		= $CI->Variants->variant_list();
        $terminal_list    	= $CI->Orders->terminal_list();

        $data = array(
            'title' 		=> display('new_order'),
            'store_list' 	=> $store_list,
            'variant_list' 	=> $variant_list,
            'terminal_list' => $terminal_list,
        );
        $orderForm = $CI->parser->parse('dashboard/order/add_order_form',$data,true);
        return $orderForm;
    }

    //Retrieve  order List
    public function order_list($filter=[], $page, $per_page, $links = false)
    {
        $CI =& get_instance();
        $CI->load->model('dashboard/Orders');
        $CI->load->model('dashboard/Soft_settings');
        $CI->load->library('dashboard/occational');

        $orders_list = $CI->Orders->order_list($filter, $page, $per_page);

        if(!empty($orders_list)){
            foreach($orders_list as $k=>$v){
                $orders_list[$k]['final_date'] = $CI->occational->dateConvert($orders_list[$k]['date']);
            }
            $i=0;
            foreach($orders_list as $k=>$v){$i++;
                $orders_list[$k]['sl']=$i;
            }
        }

        $currency_details = $CI->Soft_settings->retrieve_currency_info();
        $data = array(
            'title'    => display('manage_order'),
            'orders_list' => $orders_list,
            'links' => $links,
            'currency' => $currency_details[0]['currency_icon'],
            'position' => $currency_details[0]['currency_position'],
        );
        $orderList = $CI->parser->parse('dashboard/order/order',$data,true);
        return $orderList;
    }
    //Insert order
    public function insert_order($data)
    {
        $CI =& get_instance();
        $CI->load->model('Orders');
        $CI->Orders->order_entry($data);
        return true;
    }
    //order Edit Data
    public function order_edit_data($order_id)
    {
        $CI =& get_instance();
        $CI->load->model('dashboard/Orders');
        $CI->load->model('dashboard/Stores');
        $order_detail 	  = $CI->Orders->retrieve_order_editdata($order_id);
        $store_id 		  = $order_detail[0]['store_id'];
        $store_list 	  = $CI->Stores->store_list();
        $store_list_selected = $CI->Stores->store_list_selected($store_id);
        $terminal_list    = $CI->Orders->terminal_list();

        $i=0;
        foreach($order_detail as $k=>$v){$i++;
            $order_detail[$k]['sl']=$i;
        }

        $data=array(
            'title'				=> 	display('order_update'),
            'order_id'			=>	$order_detail[0]['order_id'],
            'customer_id'		=>	$order_detail[0]['customer_id'],
            'store_id'			=>	$order_detail[0]['store_id'],
            'customer_name'		=>	$order_detail[0]['customer_name'],
            'date'				=>	$order_detail[0]['date'],
            'total_amount'		=>	$order_detail[0]['total_amount'],
            'paid_amount'		=>	$order_detail[0]['paid_amount'],
            'due_amount'		=>	$order_detail[0]['due_amount'],
            'total_discount'	=>	$order_detail[0]['total_discount'],
            'order_discount'	=>	$order_detail[0]['order_discount'],
            'service_charge'	=>	$order_detail[0]['service_charge'],
            'details'			=>	$order_detail[0]['details'],
            'order'				=>	$order_detail[0]['order'],
            'status'			=>	$order_detail[0]['status'],
            'order_all_data'	=>	$order_detail,
            'store_list'		=>	$store_list,
            'store_list_selected'=>	$store_list_selected,
            'terminal_list'     =>	$terminal_list,
        );

        $chapterList = $CI->parser->parse('dashboard/order/edit_order_form',$data,true);
        return $chapterList;
    }
    //Order Html Data
    public function order_html_data($order_id)
    {
        $CI =& get_instance();
        $CI->load->model('dashboard/Orders');
        $CI->load->model('dashboard/Soft_settings');
        $CI->load->library('dashboard/occational');
        $CI->load->library('Pdfgenerator');
        $order_detail = $CI->Orders->retrieve_order_html_data($order_id);
        $subTotal_quantity 	= 0;
        $subTotal_cartoon 	= 0;
        $subTotal_discount 	= 0;

        if(!empty($order_detail)){
            foreach($order_detail as $k=>$v){
                $order_detail[$k]['final_date'] = $CI->occational->dateConvert($order_detail[$k]['date']);
                $subTotal_quantity = $subTotal_quantity+$order_detail[$k]['quantity'];
            }
            $i=0;
            foreach($order_detail as $k=>$v){$i++;
                $order_detail[$k]['sl']=$i;
            }
        }

        $currency_details = $CI->Soft_settings->retrieve_currency_info();
        $company_info = $CI->Orders->retrieve_company();
        $data=array(
            'title'				=>	display('order_details'),
            'order_id'			=>	$order_detail[0]['order_id'],
            'order_no'			=>	$order_detail[0]['order'],
            'customer_address'	=>	$order_detail[0]['customer_short_address'],
            'customer_name'		=>	$order_detail[0]['customer_name'],
            'customer_mobile'	=>	$order_detail[0]['customer_mobile'],
            'customer_email'	=>	$order_detail[0]['customer_email'],
            'final_date'		=>	$order_detail[0]['final_date'],
            'total_amount'		=>	$order_detail[0]['total_amount'],
            'order_discount' 	=>	$order_detail[0]['order_discount'],
            'service_charge' 	=>	$order_detail[0]['service_charge'],
            'paid_amount'		=>	$order_detail[0]['paid_amount'],
            'due_amount'		=>	$order_detail[0]['due_amount'],
            'details'			=>	$order_detail[0]['details'],
            'subTotal_quantity'	=>	$subTotal_quantity,
            'order_all_data' 	=>	$order_detail,
            'company_info'		=>	$company_info,
            'currency' 			=> 	$currency_details[0]['currency_icon'],
            'position' 			=> 	$currency_details[0]['currency_position'],
        );

        $chapterList = $CI->parser->parse('dashboard/order/order_pdf',$data,true);

        $CI->load->library('pdfgenerator');
        $file_path = $CI->pdfgenerator->generate_order($order_id, $chapterList);

        //File path save to database
        $CI->db->set('file_path',base_url($file_path));
        $CI->db->where('order_id',$order_id);
        $CI->db->update('order');

        $send_email = '';
        if (!empty($data['customer_email'])) {
            $send_email = $this->setmail($data['customer_email'],$file_path);
        }

        if ($send_email != null) {
            return true;
        }else{
            return false;
        }
    }

    //Send Customer Email with invoice
    public function setmail($email,$file_path)
    {

        $CI =& get_instance();
        $CI->load->model('Soft_settings');
        $setting_detail = $CI->Soft_settings->retrieve_email_editdata();

        $server_status = serverAliveOrNot($setting_detail[0]['smtp_host'], $setting_detail[0]['smtp_port']);
        if(!$server_status){
            $CI->session->set_userdata(array('error_message'=> display('email_not_send')));
            return true;
        }

        $subject = display("order_information");
        $message = display("order_info_details").'<br>'.base_url();

        $config = Array(
            'protocol' 		=> $setting_detail[0]['protocol'],
            'smtp_host' 	=> $setting_detail[0]['smtp_host'],
            'smtp_port' 	=> $setting_detail[0]['smtp_port'],
            'smtp_user' 	=> $setting_detail[0]['sender_email'],
            'smtp_pass' 	=> $setting_detail[0]['password'],
            'mailtype' 		=> $setting_detail[0]['mailtype'],
            'charset' 		=> 'utf-8'
        );

        $CI->load->library('email');
        $CI->email->initialize($config);

        $CI->email->set_newline("\r\n");
        $CI->email->from($setting_detail[0]['sender_email']);
        $CI->email->to($email);
        $CI->email->subject($subject);
        $CI->email->message($message);
        $CI->email->attach($file_path);

        $check_email = $this->test_input($email);
        if (filter_var($check_email, FILTER_VALIDATE_EMAIL)) {
            if($CI->email->send())
            {
                $CI->session->set_userdata(array('message'=>display('email_send_to_customer')));
                return true;
            }else{
                $CI->session->set_userdata(array('error_message'=> display('email_not_send')));
                redirect(base_url('dashboard/Corder/manage_order'));
            }
        }else{
            $CI->session->set_userdata(array('message'=>display('successfully_added')));
            redirect(base_url('dashboard/Corder/manage_order'));
        }
    }

    //Email testing for email
    public function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    //Order Details Data
    public function order_details_data($order_id)
    {
        $CI =& get_instance();
        $CI->load->model('dashboard/Orders');
        $CI->load->model('dashboard/Soft_settings');
        $CI->load->library('dashboard/occational');
        $CI->load->library('Pdfgenerator');
        $order_detail = $CI->Orders->retrieve_order_html_data($order_id);

        $payinfo = $CI->Orders->get_order_payinfo($order_id);

        $subTotal_quantity 	= 0;
        $subTotal_cartoon 	= 0;
        $subTotal_discount 	= 0;

        if(!empty($order_detail)){
            foreach($order_detail as $k=>$v){
                $order_detail[$k]['final_date'] = $CI->occational->dateConvert($order_detail[$k]['date']);
                $subTotal_quantity = $subTotal_quantity+$order_detail[$k]['quantity'];
            }
            $i=0;
            foreach($order_detail as $k=>$v){$i++;
                $order_detail[$k]['sl']=$i;
            }
        }

        $currency_details = $CI->Soft_settings->retrieve_currency_info();
        $company_info = $CI->Orders->retrieve_company();
        $data=array(
            'title'				=>	display('order_details'),
            'order_id'			=>	$order_detail[0]['order_id'],
            'order_no'			=>	$order_detail[0]['order'],
            'customer_address'	=>	$order_detail[0]['customer_short_address'],
            'ship_customer_short_address'	=>	$order_detail[0]['ship_customer_short_address'],
            'ship_customer_name'		=>	$order_detail[0]['ship_customer_name'],
            'customer_name'		=>	$order_detail[0]['customer_name'],
            'customer_mobile'	=>	$order_detail[0]['customer_mobile'],
            'ship_customer_mobile'	=>	$order_detail[0]['ship_customer_mobile'],
            'customer_email'	=>	$order_detail[0]['customer_email'],
            'ship_customer_email'	=>	$order_detail[0]['ship_customer_email'],
            'final_date'		=>	$order_detail[0]['final_date'],
            'total_amount'		=>	$order_detail[0]['total_amount'],
            'order_discount' 	=>	$order_detail[0]['order_discount'],
            'service_charge' 	=>	$order_detail[0]['service_charge'],
            'paid_amount'		=>	$order_detail[0]['paid_amount'],
            'due_amount'		=>	$order_detail[0]['due_amount'],
            'details'			=>	$order_detail[0]['details'],
            'subTotal_quantity'	=>	$subTotal_quantity,
            'order_all_data' 	=>	$order_detail,
            'company_info'		=>	$company_info,
            'currency' 			=> 	$currency_details[0]['currency_icon'],
            'position' 			=> 	$currency_details[0]['currency_position'],
            'payinfo'          =>  $payinfo
        );

        $chapterList = $CI->parser->parse('dashboard/order/order_html',$data,true);
        return $chapterList;
    }

    //POS order html Data
    public function pos_order_html_data($order_id)
    {
        $CI =& get_instance();
        $CI->load->model('dashboard/Orders');
        $CI->load->model('dashboard/Soft_settings');
        $CI->load->library('dashboard/occational');
        $order_detail = $CI->Orders->retrieve_order_html_data($order_id);
        $subTotal_quantity = 0;
        $subTotal_cartoon = 0;
        $subTotal_discount = 0;

        if(!empty($order_detail)){
            foreach($order_detail as $k=>$v){
                $order_detail[$k]['final_date'] = $CI->occational->dateConvert($order_detail[$k]['date']);
                $subTotal_quantity = $subTotal_quantity+$order_detail[$k]['quantity'];
            }
            $i=0;
            foreach($order_detail as $k=>$v){$i++;
                $order_detail[$k]['sl']=$i;
            }
        }

        $currency_details = $CI->Soft_settings->retrieve_currency_info();
        $company_info = $CI->Orders->retrieve_company();
        $data=array(
            'title'				=> display('order_detail'),
            'order_id'			=>	$order_detail[0]['order_id'],
            'order_no'			=>	$order_detail[0]['order'],
            'customer_name'		=>	$order_detail[0]['customer_name'],
            'customer_address'	=>	$order_detail[0]['customer_short_address'],
            'customer_mobile'	=>	$order_detail[0]['customer_mobile'],
            'customer_email'	=>	$order_detail[0]['customer_email'],
            'final_date'		=>	$order_detail[0]['final_date'],
            'total_amount'		=>	$order_detail[0]['total_amount'],
            'subTotal_discount'	=>	$order_detail[0]['total_discount'],
            'paid_amount'		=>	$order_detail[0]['paid_amount'],
            'due_amount'		=>	$order_detail[0]['due_amount'],
            'subTotal_quantity'	=>	$subTotal_quantity,
            'order_all_data' 	=>	$order_detail,
            'company_info'		=>	$company_info,
            'currency' 			=> $currency_details[0]['currency_icon'],
            'position' 			=> $currency_details[0]['currency_position'],
        );
        $chapterList = $CI->parser->parse('dashboard/order/pos_order_html',$data,true);
        return $chapterList;
    }
}
?>