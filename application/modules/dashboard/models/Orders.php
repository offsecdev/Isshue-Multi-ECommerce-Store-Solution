<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Orders extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('dashboard/lcustomer');
        $this->load->library('session');
        $this->load->model('dashboard/Customers');
    }
    //Count order
    public function count_order()
    {
        return $this->db->count_all("order");
    }
    // Count order list
    public function count_order_list($filter = [])
    {
        $this->db->select('a.order_id');
        $this->db->from('order a');
        $this->db->join('customer_information b','b.customer_id = a.customer_id','left');

        if(!empty($filter['order_no'])){
            $this->db->where('a.order', $filter['order_no']);
        }
        if(!empty($filter['customer_name'])){
            $this->db->like('b.customer_name', $filter['customer_name'], 'both');
        }

        if(!empty($filter['order_date'])){
            $this->db->where('a.date', date('m-d-Y', strtotime($filter['order_date'])));
        }
        if(!empty($filter['invoice_status'])){
            $this->db->join('invoice c','c.order_id = a.order_id','left');
             if(($filter['invoice_status']=='3')){
                $this->db->where('c.invoice_status', 3);
                $this->db->or_where('c.invoice_status IS NULL');
            }else{
                $this->db->where('c.invoice_status', $filter['invoice_status']);
            }
        }

        $query = $this->db->get();
        return $query->num_rows();
    }

    //order List
    public function order_list($filter = [], $page, $per_page)
    {
        $this->db->select('a.*,b.customer_name, IFNULL(c.invoice_status,0) as invoice_status');
        $this->db->from('order a');
        $this->db->join('customer_information b','b.customer_id = a.customer_id','left');
        $this->db->join('invoice c','c.order_id = a.order_id','left');


        if(!empty($filter['order_no'])){
            $this->db->where('a.order', $filter['order_no']);
        }
        if(!empty($filter['customer_name'])){
            $this->db->like('b.customer_name', $filter['customer_name'], 'both');
        }

        if(!empty($filter['order_date'])){
            $this->db->where('a.date', date('m-d-Y', strtotime($filter['order_date'])));
        }

        if(!empty($filter['invoice_status'])){
             if(($filter['invoice_status']=='3')){
                $this->db->where('c.invoice_status', 3);
                $this->db->or_where('c.invoice_status IS NULL');
            }else{
                $this->db->where('c.invoice_status', $filter['invoice_status']);
            }
        }


        $this->db->order_by('a.order','desc');
        $this->db->limit($per_page, $page );
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Stock Report by date
    public function stock_report_bydate($product_id)
    {
        $this->db->select("
			SUM(d.quantity) as 'totalSalesQnty',
			SUM(b.quantity) as 'totalPurchaseQnty',
			(sum(b.quantity) - sum(d.quantity)) as stock
			");

        $this->db->from('product_information a');
        $this->db->join('product_purchase_details b','b.product_id = a.product_id','left');
        $this->db->join('order_details d','d.product_id = a.product_id','left');
        $this->db->join('product_purchase e','e.purchase_id = b.purchase_id','left');
        $this->db->group_by('a.product_id');
        $this->db->order_by('a.product_name','asc');

        if(empty($product_id))
        {
            $this->db->where(array('a.status'=>1));
        }else{
            //Single product information
            $this->db->where('a.product_id',$product_id);
        }
        $query = $this->db->get();
        return $query->row();
    }

    //order Search Item
    public function search_inovoice_item($customer_id)
    {
        $this->db->select('a.*,b.customer_name');
        $this->db->from('order a');
        $this->db->join('customer_information b','b.customer_id = a.customer_id');
        $this->db->where('b.customer_id',$customer_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //POS order entry
    public function pos_order_setup($product_id){
        $product_information = $this->db->select('*')
            ->from('product_information')
            ->where('product_id',$product_id)
            ->get()
            ->row();

        if ($product_information != null) {

            $this->db->select('SUM(a.quantity) as total_purchase');
            $this->db->from('product_purchase_details a');
            $this->db->where('a.product_id',$product_id);
            $total_purchase = $this->db->get()->row();

            $this->db->select('SUM(b.quantity) as total_sale');
            $this->db->from('order_details b');
            $this->db->where('b.product_id',$product_id);
            $total_sale = $this->db->get()->row();



            $data2 = (object)array(
                'total_product' => ($total_purchase->total_purchase - $total_sale->total_sale),
                'supplier_price' => $product_information->supplier_price,
                'price' 		 => $product_information->price,
                'supplier_id' 	 => $product_information->supplier_id,
                'tax'			 => $product_information->tax,
                'product_id'	 => $product_information->product_id,
                'product_name'	 => $product_information->product_name,
                'product_model'	 => $product_information->product_model,
                'unit'			 => $product_information->unit,
            );

            return $data2;
        }else{
            return false;
        }
    }
    //POS customer setup
    public function pos_customer_setup(){
        $query= $this->db->select('*')
            ->from('customer_information')
            ->where('customer_name','Walking Customer')
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }else{
            return false;
        }
    }
    //POS customer list
    public function customer_list(){
        $query= $this->db->select('*')
            ->from('customer_information')
            ->where('customer_name !=','Walking Customer')
            ->order_by('customer_name','asc')
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }else{
            return false;
        }
    }
    //Customer entry
    public function customer_entry($data){

        $this->db->select('*');
        $this->db->from('customer_information');
        $this->db->where('customer_name',$data['customer_name']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return FALSE;
        }else{
            $this->db->insert('customer_information',$data);

            $this->db->select('*');
            $this->db->from('customer_information');
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $json_customer[] = array('label'=>$row->customer_name,'value'=>$row->customer_id);
            }
            $cache_file ='./my-assets/js/admin_js/json/customer.json';
            $customerList = json_encode($json_customer);
            file_put_contents($cache_file,$customerList);
            $this->session->set_userdata(array('message'=>display('successfully_added')));
            return TRUE;
        }
    }

    //order entry
    public function order_entry()
    {
        //Order information
        $order_id 			= $this->auth->generator(15);
        $quantity 			= $this->input->post('product_quantity',TRUE);
        $available_quantity = $this->input->post('available_quantity',TRUE);
        $product_id 		= $this->input->post('product_id',TRUE);

        //Stock availability check
        $result = array();
        foreach($available_quantity as $k => $v)
        {
            if($v < $quantity[$k])
            {
                $this->session->set_userdata(array('error_message'=>display('you_can_not_buy_greater_than_available_cartoon')));
                redirect('dashboard/Corder');
            }
        }

        //Product existing check
        if ($product_id == null) {
            $this->session->set_userdata(array('error_message'=>display('please_select_product')));
            redirect('dashboard/Corder');
        }

        //Customer existing check
        if (($this->input->post('customer_name_others',TRUE) == null) && ($this->input->post('customer_id',TRUE) == null )) {
            $this->session->set_userdata(array('error_message'=>display('please_select_customer')));
            redirect(base_url().'dashboard/Corder');
        }

        //Customer data Existence Check.
        if($this->input->post('customer_id',TRUE) == "" ){

            $customer_id=$this->auth->generator(15);
            //Customer  basic information adding.
            $data=array(
                'customer_id' 	=> $customer_id,
                'customer_name' => $this->input->post('customer_name_others',TRUE),
                'customer_short_address' 	=>$this->input->post('customer_name_others_address',TRUE),
                'customer_mobile' 	=> "NONE",
                'customer_email' 	=> "NONE",
                'status' 			=> 1
            );

            $result = $this->Customers->customer_entry($data);
            if ($result == false) {
                $this->session->set_userdata(array('error_message'=>display('already_exists')));
                redirect('dashboard/Corder/manage_order');
            }
            //Previous balance adding -> Sending to customer model to adjust the data.
            $this->Customers->previous_balance_add(0,$customer_id);
        }
        else{
            $customer_id=$this->input->post('customer_id',TRUE);
        }


        $this->session->set_userdata('customerId',$customer_id);
        //Data inserting into order table
        $data=array(
            'order_id'			=>	$order_id,
            'customer_id'		=>	$customer_id,
            'date'				=>	$this->input->post('invoice_date',TRUE),
            'total_amount'		=>	$this->input->post('grand_total_price',TRUE),
            'order'				=>	$this->number_generator_order(),
            'total_discount' 	=> 	$this->input->post('total_discount',TRUE),
            'order_discount' 	=> 	$this->input->post('invoice_discount',TRUE) + $this->input->post('total_discount',TRUE),
            'service_charge' 	=> 	$this->input->post('service_charge',TRUE),
            'user_id'			=>	$this->session->userdata('user_id'),
            'store_id'			=>	$this->input->post('store_id',TRUE),
            'details'			=>	$this->input->post('details'),
            'paid_amount'		=>	$this->input->post('paid_amount',TRUE),
            'due_amount'		=>	$this->input->post('due_amount',TRUE),
            'status'			=>	1
        );
        $this->db->insert('order',$data);

        //Order details info
        $rate 		= $this->input->post('product_rate',TRUE);
        $p_id 		= $this->input->post('product_id',TRUE);
        $total_amount = $this->input->post('total_price',TRUE);
        $discount 	= $this->input->post('discount',TRUE);
        $variants 	= $this->input->post('variant_id',TRUE);
        $color_variants   = $this->input->post('color_variant',TRUE);

        //Order details entry
        for ($i=0, $n=count($p_id); $i < $n; $i++) {
            $product_quantity = $quantity[$i];
            $product_rate 	  = $rate[$i];
            $product_id 	  = $p_id[$i];
            $discount_rate    = $discount[$i];
            $total_price      = $total_amount[$i];
            $variant_id       = $variants[$i];
            $variant_color    = $color_variants[$i];
            $supplier_rate    = $this->supplier_rate($product_id);

            $order_details = array(
                'order_details_id'	=>	$this->auth->generator(15),
                'order_id'			=>	$order_id,
                'product_id'		=>	$product_id,
                'variant_id'		=>	$variant_id,
                'variant_color'     =>  $variant_color,
                'store_id'			=>	$this->input->post('store_id',TRUE),
                'quantity'			=>	$product_quantity,
                'rate'				=>	$product_rate,
                'supplier_rate'     =>	$supplier_rate[0]['supplier_price'],
                'total_price'       =>	$total_price,
                'discount'          =>	$discount_rate,
                'status'			=>	1
            );

            if(!empty($quantity))
            {
                $this->db->select('*');
                $this->db->from('order_details');
                $this->db->where('order_id',$order_id);
                $this->db->where('product_id',$product_id);
                $this->db->where('variant_id',$variant_id);
                if(!empty($variant_color)){
                    $this->db->where('variant_color',$variant_color);
                }
                $query = $this->db->get();
                $result = $query->num_rows();
                if ($result > 0) {
                    $this->db->set('quantity', 'quantity+'.$product_quantity, FALSE);
                    $this->db->set('total_price', 'total_price+'.$total_price, FALSE);
                    $this->db->where('order_id', $order_id);
                    $this->db->where('product_id', $product_id);
                    $this->db->where('variant_id', $variant_id);
                    if(!empty($variant_color)){
                        $this->db->where('variant_color',$variant_color);
                    }
                    $this->db->update('order_details');
                }else{
                    $this->db->insert('order_details',$order_details);
                }
            }
        }

        //Tax info
        $cgst = $this->input->post('cgst',TRUE);
        $sgst = $this->input->post('sgst',TRUE);
        $igst = $this->input->post('igst',TRUE);
        $cgst_id = $this->input->post('cgst_id',TRUE);
        $sgst_id = $this->input->post('sgst_id',TRUE);
        $igst_id = $this->input->post('igst_id',TRUE);

        //Tax collection summary for three
        //CGST tax info
        if(!empty($cgst)){
        for ($i=0, $n=count($cgst); $i < $n; $i++) {
            $cgst_tax = $cgst[$i];
            $cgst_tax_id = $cgst_id[$i];
            $cgst_summary = array(
                'order_tax_col_id'	=>	$this->auth->generator(15),
                'order_id'		=>	$order_id,
                'tax_amount' 		=> 	$cgst_tax,
                'tax_id' 			=> 	$cgst_tax_id,
                'date'				=>	$this->input->post('invoice_date',TRUE),
            );
            if(!empty($cgst[$i])){
                $result= $this->db->select('*')
                    ->from('order_tax_col_summary')
                    ->where('order_id',$order_id)
                    ->where('tax_id',$cgst_tax_id)
                    ->get()
                    ->num_rows();
                if ($result > 0) {
                    $this->db->set('tax_amount', 'tax_amount+'.$cgst_tax, FALSE);
                    $this->db->where('order_id', $order_id);
                    $this->db->where('tax_id', $cgst_tax_id);
                    $this->db->update('order_tax_col_summary');
                }else{
                    $this->db->insert('order_tax_col_summary',$cgst_summary);
                }
            }
        }
        }

        //SGST tax info
        if(!empty($sgst)){
        for ($i=0, $n=count($sgst); $i < $n; $i++) {
            $sgst_tax = $sgst[$i];
            $sgst_tax_id = $sgst_id[$i];

            $sgst_summary = array(
                'order_tax_col_id'	=>	$this->auth->generator(15),
                'order_id'		=>	$order_id,
                'tax_amount' 		=> 	$sgst_tax,
                'tax_id' 			=> 	$sgst_tax_id,
                'date'				=>	$this->input->post('invoice_date',TRUE),
            );
            if(!empty($sgst[$i])){
                $result= $this->db->select('*')
                    ->from('order_tax_col_summary')
                    ->where('order_id',$order_id)
                    ->where('tax_id',$sgst_tax_id)
                    ->get()
                    ->num_rows();
                if ($result > 0) {
                    $this->db->set('tax_amount', 'tax_amount+'.$sgst_tax, FALSE);
                    $this->db->where('order_id', $order_id);
                    $this->db->where('tax_id', $sgst_tax_id);
                    $this->db->update('order_tax_col_summary');
                }else{
                    $this->db->insert('order_tax_col_summary',$sgst_summary);
                }
            }
        }
        }

        //IGST tax info
        if(!empty($igst)){
        for ($i=0, $n=count($igst); $i < $n; $i++) {
            $igst_tax = $igst[$i];
            $igst_tax_id = $igst_id[$i];

            $igst_summary = array(
                'order_tax_col_id'	=>	$this->auth->generator(15),
                'order_id'		=>	$order_id,
                'tax_amount' 		=> 	$igst_tax,
                'tax_id' 			=> 	$igst_tax_id,
                'date'				=>	$this->input->post('invoice_date',TRUE),
            );
            if(!empty($igst[$i])){
                $result= $this->db->select('*')
                    ->from('order_tax_col_summary')
                    ->where('order_id',$order_id)
                    ->where('tax_id',$igst_tax_id)
                    ->get()
                    ->num_rows();

                if ($result > 0) {
                    $this->db->set('tax_amount', 'tax_amount+'.$igst_tax, FALSE);
                    $this->db->where('order_id', $order_id);
                    $this->db->where('tax_id', $igst_tax_id);
                    $this->db->update('order_tax_col_summary');
                }else{
                    $this->db->insert('order_tax_col_summary',$igst_summary);
                }
            }
        }
        }
        //Tax collection summary for three

        //Tax collection details for three
        //CGST tax info
        if(!empty($cgst)){
        for ($i=0, $n=count($cgst); $i < $n; $i++) {
            $cgst_tax 	 = $cgst[$i];
            $cgst_tax_id = $cgst_id[$i];
            $product_id  = $p_id[$i];
            $variant_id  = $variants[$i];
            $cgst_details = array(
                'order_tax_col_de_id'=>	$this->auth->generator(15),
                'order_id'			=>	$order_id,
                'amount' 			=> 	$cgst_tax,
                'product_id' 		=> 	$product_id,
                'tax_id' 			=> 	$cgst_tax_id,
                'variant_id' 		=> 	$variant_id,
                'date'				=>	$this->input->post('invoice_date',TRUE),
            );
            if(!empty($cgst[$i])){

                $result= $this->db->select('*')
                    ->from('order_tax_col_details')
                    ->where('order_id',$order_id)
                    ->where('tax_id',$cgst_tax_id)
                    ->where('product_id',$product_id)
                    ->where('variant_id',$variant_id)
                    ->get()
                    ->num_rows();
                if ($result > 0) {
                    $this->db->set('amount', 'amount+'.$cgst_tax, FALSE);
                    $this->db->where('order_id', $order_id);
                    $this->db->where('tax_id', $cgst_tax_id);
                    $this->db->where('variant_id', $variant_id);
                    $this->db->update('order_tax_col_details');
                }else{
                    $this->db->insert('order_tax_col_details',$cgst_details);
                }
            }
        }
        }

        //SGST tax info
        if(!empty($sgst)){
        for ($i=0, $n=count($sgst); $i < $n; $i++) {
            $sgst_tax 	 = $sgst[$i];
            $sgst_tax_id = $sgst_id[$i];
            $product_id  = $p_id[$i];
            $variant_id  = $variants[$i];
            $sgst_summary = array(
                'order_tax_col_de_id'	=>	$this->auth->generator(15),
                'order_id'			=>	$order_id,
                'amount' 			=> 	$sgst_tax,
                'product_id' 		=> 	$product_id,
                'tax_id' 			=> 	$sgst_tax_id,
                'variant_id' 		=> 	$variant_id,
                'date'				=>	$this->input->post('invoice_date',TRUE),
            );
            if(!empty($sgst[$i])){
                $result= $this->db->select('*')
                    ->from('order_tax_col_details')
                    ->where('order_id',$order_id)
                    ->where('tax_id',$sgst_tax_id)
                    ->where('product_id',$product_id)
                    ->where('variant_id',$variant_id)
                    ->get()
                    ->num_rows();
                if ($result > 0) {
                    $this->db->set('amount', 'amount+'.$sgst_tax, FALSE);
                    $this->db->where('order_id', $order_id);
                    $this->db->where('tax_id', $sgst_tax_id);
                    $this->db->where('variant_id', $variant_id);
                    $this->db->update('order_tax_col_details');
                }else{
                    $this->db->insert('order_tax_col_details',$sgst_summary);
                }
            }
        }
        }

        //IGST tax info
        if(!empty($igst)){
        for ($i=0, $n=count($igst); $i < $n; $i++) {
            $igst_tax 	 = $igst[$i];
            $igst_tax_id = $igst_id[$i];
            $product_id  = $p_id[$i];
            $variant_id  = $variants[$i];
            $igst_summary = array(
                'order_tax_col_de_id'=>	$this->auth->generator(15),
                'order_id'			=>	$order_id,
                'amount' 			=> 	$igst_tax,
                'product_id' 		=> 	$product_id,
                'tax_id' 			=> 	$igst_tax_id,
                'variant_id' 		=> 	$variant_id,
                'date'				=>	$this->input->post('invoice_date',TRUE),
            );
            if(!empty($igst[$i])){
                $result= $this->db->select('*')
                    ->from('order_tax_col_details')
                    ->where('order_id',$order_id)
                    ->where('tax_id',$igst_tax_id)
                    ->where('product_id',$product_id)
                    ->where('variant_id',$variant_id)
                    ->get()
                    ->num_rows();
                if ($result > 0) {
                    $this->db->set('amount', 'amount+'.$igst_tax, FALSE);
                    $this->db->where('order_id', $order_id);
                    $this->db->where('tax_id', $igst_tax_id);
                    $this->db->where('variant_id', $variant_id);
                    $this->db->update('order_tax_col_details');
                }else{
                    $this->db->insert('order_tax_col_details',$igst_summary);
                }
            }
        }
        }
        //Tax collection details for three
        return $order_id;
    }

    //update_order
    public function update_order()
    {
        //Order information
        $order_id  	 = $this->input->post('order_id',TRUE);
        $customer_id = $this->input->post('customer_id',TRUE);

        if($order_id!='')
        {
            //Data update into order table
            $data=array(
                'order_id'			=>	$order_id,
                'customer_id'		=>	$customer_id,
                'date'				=>	$this->input->post('invoice_date',TRUE),
                'total_amount'		=>	$this->input->post('grand_total_price',TRUE),
                'order'				=>	$this->input->post('order',TRUE),
                'total_discount' 	=> 	$this->input->post('total_discount',TRUE),
                'order_discount' 	=> 	(int)$this->input->post('invoice_discount',TRUE) + (int)$this->input->post('total_discount',TRUE),
                'service_charge' 	=> 	$this->input->post('service_charge',TRUE),
                'user_id'			=>	$this->session->userdata('user_id'),
                'store_id'			=>	$this->input->post('store_id',TRUE),
                'paid_amount'		=>	$this->input->post('paid_amount',TRUE),
                'due_amount'		=>	$this->input->post('due_amount',TRUE),
                'status'			=>	$this->input->post('status',TRUE),
            );

            $this->db->where('order_id',$order_id);
            $result = $this->db->delete('order');

            if ($result) {
                $this->db->insert('order',$data);
            }
        }

        //Order details info
        $rate 		= $this->input->post('product_rate',TRUE);
        $p_id 		= $this->input->post('product_id',TRUE);
        $total_amount = $this->input->post('total_price',TRUE);
        $discount 	= $this->input->post('discount',TRUE);
        $variants 	= $this->input->post('variant_id',TRUE);
        $color_variants   = $this->input->post('color_variant',TRUE);
        $order_d_id = $this->input->post('order_details_id',TRUE);
        $quantity 	= $this->input->post('product_quantity',TRUE);

        //Delete old invoice info
        if (!empty($order_id)) {
            $this->db->where('order_id',$order_id);
            $this->db->delete('order_details');
        }

        //Order details for entry
        if(!empty($p_id)){
        for ($i=0, $n=count($p_id); $i < $n; $i++) {
            $product_quantity = $quantity[$i];
            $product_rate 	  = $rate[$i];
            $product_id 	  = $p_id[$i];
            $discount_rate 	  = $discount[$i];
            $total_price 	  = $total_amount[$i];
            $variant_id 	  = $variants[$i];
            $variant_color    = (!empty($color_variants[$i])?$color_variants[$i]:NULL);
            $supplier_rate    = $this->supplier_rate($product_id);

            $order_details = array(
                'order_details_id'	=>	$this->auth->generator(15),
                'order_id'		=>	$order_id,
                'product_id'	=>	$product_id,
                'variant_id'	=>	$variant_id,
                'variant_color' =>  $variant_color,
                'quantity'		=>	$product_quantity,
                'rate'			=>	$product_rate,
                'store_id'		=>	$this->input->post('store_id',TRUE),
                'supplier_rate' =>	$supplier_rate[0]['supplier_price'],
                'total_price'   =>	$total_price,
                'discount'      =>	$discount_rate,
                'status'		=>	1
            );

            if(!empty($p_id))
            {
                $this->db->select('order_details_id');
                $this->db->from('order_details');
                $this->db->where('order_id',$order_id);
                $this->db->where('product_id',$product_id);
                $this->db->where('variant_id',$variant_id);
                if(!empty($variant_color)){
                    $this->db->where('variant_color',$variant_color);
                }
                $query = $this->db->get();
                $result = $query->num_rows();

                if ($result > 0) {
                    $this->db->set('quantity', 'quantity+'.$product_quantity, FALSE);
                    $this->db->set('total_price', 'total_price+'.$total_price, FALSE);
                    $this->db->where('order_id', $order_id);
                    $this->db->where('product_id', $product_id);
                    $this->db->where('variant_id', $variant_id);
                    if(!empty($variant_color)){
                        $this->db->where('variant_color', $variant_color);
                    }
                    $this->db->update('order_details');
                }else{
                    $this->db->insert('order_details',$order_details);
                }
            }
        }
}
        //Tax info
        $cgst = $this->input->post('cgst',TRUE);
        $sgst = $this->input->post('sgst',TRUE);
        $igst = $this->input->post('igst',TRUE);
        $cgst_id = $this->input->post('cgst_id',TRUE);
        $sgst_id = $this->input->post('sgst_id',TRUE);
        $igst_id = $this->input->post('igst_id',TRUE);

        //Tax collection summary for three

        //Delete all tax  from summary
        $this->db->where('order_id',$order_id);
        $this->db->delete('order_tax_col_summary');

        //CGST Tax Summary
        if(!empty($cgst)){
        for ($i=0, $n=count($cgst); $i < $n; $i++) {
            $cgst_tax = $cgst[$i];
            $cgst_tax_id = $cgst_id[$i];
            $cgst_summary = array(
                'order_tax_col_id'	=>	$this->auth->generator(15),
                'order_id'			=>	$order_id,
                'tax_amount' 		=> 	$cgst_tax,
                'tax_id' 			=> 	$cgst_tax_id,
                'date'				=>	$this->input->post('invoice_date',TRUE),
            );
            if(!empty($cgst[$i])){
                $result= $this->db->select('*')
                    ->from('order_tax_col_summary')
                    ->where('order_id',$order_id)
                    ->where('tax_id',$cgst_tax_id)
                    ->get()
                    ->num_rows();
                if ($result > 0) {
                    $this->db->set('tax_amount', 'tax_amount+'.$cgst_tax, FALSE);
                    $this->db->where('order_id', $order_id);
                    $this->db->where('tax_id', $cgst_tax_id);
                    $this->db->update('order_tax_col_summary');
                }else{
                    $this->db->insert('order_tax_col_summary',$cgst_summary);
                }
            }
        }
}
        //SGST Tax Summary
if(!empty($sgst)){
        for ($i=0, $n=count($sgst); $i < $n; $i++) {
            $sgst_tax = $sgst[$i];
            $sgst_tax_id = $sgst_id[$i];

            $sgst_summary = array(
                'order_tax_col_id'	=>	$this->auth->generator(15),
                'order_id'			=>	$order_id,
                'tax_amount' 		=> 	$sgst_tax,
                'tax_id' 			=> 	$sgst_tax_id,
                'date'				=>	$this->input->post('invoice_date',TRUE),
            );
            if(!empty($sgst[$i])){
                $result= $this->db->select('*')
                    ->from('order_tax_col_summary')
                    ->where('order_id',$order_id)
                    ->where('tax_id',$sgst_tax_id)
                    ->get()
                    ->num_rows();
                if ($result > 0) {
                    $this->db->set('tax_amount', 'tax_amount+'.$sgst_tax, FALSE);
                    $this->db->where('order_id', $order_id);
                    $this->db->where('tax_id', $sgst_tax_id);
                    $this->db->update('order_tax_col_summary');
                }else{
                    $this->db->insert('order_tax_col_summary',$sgst_summary);
                }
            }
        }
}
        //IGST Tax Summary
if(!empty($igst)){
        for ($i=0, $n=count($igst); $i < $n; $i++) {
            $igst_tax = $igst[$i];
            $igst_tax_id = $igst_id[$i];

            $igst_summary = array(
                'order_tax_col_id'	=>	$this->auth->generator(15),
                'order_id'		=>	$order_id,
                'tax_amount' 		=> 	$igst_tax,
                'tax_id' 			=> 	$igst_tax_id,
                'date'				=>	$this->input->post('invoice_date',TRUE),
            );
            if(!empty($igst[$i])){
                $result= $this->db->select('*')
                    ->from('order_tax_col_summary')
                    ->where('order_id',$order_id)
                    ->where('tax_id',$igst_tax_id)
                    ->get()
                    ->num_rows();

                if ($result > 0) {
                    $this->db->set('tax_amount', 'tax_amount+'.$igst_tax, FALSE);
                    $this->db->where('order_id', $order_id);
                    $this->db->where('tax_id', $igst_tax_id);
                    $this->db->update('order_tax_col_summary');
                }else{
                    $this->db->insert('order_tax_col_summary',$igst_summary);
                }
            }
        }
    }
        //Tax collection summary for three


        //Tax collection details for three

        //Delete all tax  from summary
        $this->db->where('order_id',$order_id);
        $this->db->delete('order_tax_col_details');

        //CGST Tax Details
        if(!empty($cgst)){
        for ($i=0, $n=count($cgst); $i < $n; $i++) {
            $cgst_tax 	 = $cgst[$i];
            $cgst_tax_id = $cgst_id[$i];
            $product_id  = $p_id[$i];
            $variant_id  = $variants[$i];
            $cgst_details = array(
                'order_tax_col_de_id'=>	$this->auth->generator(15),
                'order_id'			=>	$order_id,
                'amount' 			=> 	$cgst_tax,
                'product_id' 		=> 	$product_id,
                'tax_id' 			=> 	$cgst_tax_id,
                'variant_id' 		=> 	$variant_id,
                'date'				=>	$this->input->post('invoice_date',TRUE),
            );
            if(!empty($cgst[$i])){
                $result= $this->db->select('*')
                    ->from('order_tax_col_details')
                    ->where('order_id',$order_id)
                    ->where('tax_id',$cgst_tax_id)
                    ->where('product_id',$product_id)
                    ->where('variant_id',$variant_id)
                    ->get()
                    ->num_rows();
                if ($result > 0) {
                    $this->db->set('amount', 'amount+'.$cgst_tax, FALSE);
                    $this->db->where('order_id', $order_id);
                    $this->db->where('tax_id', $cgst_tax_id);
                    $this->db->where('variant_id', $variant_id);
                    $this->db->update('order_tax_col_details');
                }else{
                    $this->db->insert('order_tax_col_details',$cgst_details);
                }
            }
        }
}
        //SGST Tax Details
if(!empty($sgst)){
        for ($i=0, $n=count($sgst); $i < $n; $i++) {
            $sgst_tax 	 = $sgst[$i];
            $sgst_tax_id = $sgst_id[$i];
            $product_id  = $p_id[$i];
            $variant_id  = $variants[$i];
            $sgst_summary = array(
                'order_tax_col_de_id'	=>	$this->auth->generator(15),
                'order_id'		=>	$order_id,
                'amount' 			=> 	$sgst_tax,
                'product_id' 		=> 	$product_id,
                'tax_id' 			=> 	$sgst_tax_id,
                'variant_id' 		=> 	$variant_id,
                'date'				=>	$this->input->post('invoice_date',TRUE),
            );
            if(!empty($sgst[$i])){
                $result= $this->db->select('*')
                    ->from('order_tax_col_details')
                    ->where('order_id',$order_id)
                    ->where('tax_id',$sgst_tax_id)
                    ->where('product_id',$product_id)
                    ->where('variant_id',$variant_id)
                    ->get()
                    ->num_rows();
                if ($result > 0) {
                    $this->db->set('amount', 'amount+'.$sgst_tax, FALSE);
                    $this->db->where('order_id', $order_id);
                    $this->db->where('tax_id', $sgst_tax_id);
                    $this->db->where('variant_id', $variant_id);
                    $this->db->update('order_tax_col_details');
                }else{
                    $this->db->insert('order_tax_col_details',$sgst_summary);
                }
            }
        }
}
        //IGST Tax Details
if(!empty($igst)){
        for ($i=0, $n=count($igst); $i < $n; $i++) {
            $igst_tax 	 = $igst[$i];
            $igst_tax_id = $igst_id[$i];
            $product_id  = $p_id[$i];
            $variant_id  = $variants[$i];
            $igst_summary = array(
                'order_tax_col_de_id'=>	$this->auth->generator(15),
                'order_id'		=>	$order_id,
                'amount' 			=> 	$igst_tax,
                'product_id' 		=> 	$product_id,
                'tax_id' 			=> 	$igst_tax_id,
                'variant_id' 		=> 	$variant_id,
                'date'				=>	$this->input->post('invoice_date',TRUE),
            );
            if(!empty($igst[$i])){
                $result= $this->db->select('*')
                    ->from('order_tax_col_details')
                    ->where('order_id',$order_id)
                    ->where('tax_id',$igst_tax_id)
                    ->where('product_id',$product_id)
                    ->where('variant_id',$variant_id)
                    ->get()
                    ->num_rows();
                if ($result > 0) {
                    $this->db->set('amount', 'amount+'.$igst_tax, FALSE);
                    $this->db->where('order_id', $order_id);
                    $this->db->where('tax_id', $igst_tax_id);
                    $this->db->where('variant_id', $variant_id);
                    $this->db->update('order_tax_col_details');
                }else{
                    $this->db->insert('order_tax_col_details',$igst_summary);
                }
            }
        }
    }
        //End tax details
        return $order_id;
    }
    //order paid to invoice
    public function order_paid_data($order_id){

        $invoice_id = $this->auth->generator(15);
        $result=$this->db->select('*')
            ->from('order')
            ->where('order_id',$order_id)
            ->get()
            ->row();
        if ($result) {

            $data = array(
                'invoice_id' 	=> $invoice_id,
                'order_id' 		=> $result->order_id,
                'customer_id' 	=> $result->customer_id,
                'store_id' 		=> $result->store_id,
                'user_id' 		=> $result->user_id,
                'date' 			=> $result->date,
                'total_amount' 	=> $result->total_amount,
                'invoice'       => $this->number_generator(),
                'total_discount'=> $result->total_discount,
                'invoice_discount' => $result->order_discount,
                'service_charge' => $result->service_charge,
                'paid_amount' 	=> $result->paid_amount,
                'due_amount' 	=> $result->due_amount,
                'status' 		=> $result->status,
            );
            $this->db->insert('invoice',$data);


            //Update to customer ledger Table
            $data2 = array(
                'transaction_id'	=>	$this->auth->generator(15),
                'customer_id'		=>	$result->customer_id,
                'invoice_no'		=>	$invoice_id,
                'order_no' 			=>  $result->order_id,
                'date'				=>	$result->date,
                'amount'			=>	$result->total_amount,
                'status'			=>	1
            );
            $ledger = $this->db->insert('customer_ledger',$data2);
        }


        if ($ledger) {

            //order update
            $this->db->set('status','2');
            $this->db->where('order_id',$order_id);
            $order = $this->db->update('order');

            $order_details=$this->db->select('*')
                ->from('order_details')
                ->where('order_id',$order_id)
                ->get()
                ->result();

            if ($order_details) {
                foreach ($order_details as $details) {
                    $invoice_details = array(
                        'invoice_details_id' => $this->auth->generator(15),
                        'invoice_id' 		 => $invoice_id,
                        'product_id' 		 => $details->product_id,
                        'variant_id'		 => $details->variant_id,
                        'variant_color'      => $details->variant_color,
                        'store_id'		 	 => $details->store_id,
                        'quantity'			 => $details->quantity,
                        'rate'				 => $details->rate,
                        'supplier_rate'		 => $details->supplier_rate,
                        'total_price'		 => $details->total_price,
                        'discount'			 => $details->discount,
                        'status'			 => $details->status,
                    );

                    $order_details = $this->db->insert('invoice_details',$invoice_details);
                }
            }
        }

        //Tax summary entry start
        $this->db->select('*');
        $this->db->from('order_tax_col_summary');
        $this->db->where('order_id',$order_id);
        $query = $this->db->get();
        $tax_summary = $query->result();

        if ($tax_summary) {
            foreach ($tax_summary as $summary) {
                $tax_col_summary = array(
                    'tax_collection_id' => $summary->order_tax_col_id,
                    'invoice_id' 		=> $invoice_id,
                    'tax_id' 			=> $summary->tax_id,
                    'tax_amount' 		=> $summary->tax_amount,
                    'date' 				=> $summary->date,
                );
                $this->db->insert('tax_collection_summary',$tax_col_summary);
            }
        }
        //Tax summary entry end

        //Tax details entry start
        $this->db->select('*');
        $this->db->from('order_tax_col_details');
        $this->db->where('order_id',$order_id);
        $query = $this->db->get();
        $tax_details = $query->result();

        if ($tax_details) {
            foreach ($tax_details as $details) {
                $tax_col_details = array(
                    'tax_col_de_id' 	=> $details->order_tax_col_de_id,
                    'invoice_id' 		=> $invoice_id,
                    'product_id' 		=> $details->product_id,
                    'variant_id' 		=> $details->variant_id,
                    'tax_id' 			=> $details->tax_id,
                    'amount' 			=> $details->amount,
                    'date' 				=> $details->date,
                );
                $this->db->insert('tax_collection_details',$tax_col_details);
            }
        }
        //Tax details entry end
        return true;
    }
    //Store List
    public function store_list()
    {
        $this->db->select('*');
        $this->db->from('store_set');
        $this->db->order_by('store_name','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    //Terminal List
    public function terminal_list()
    {
        $this->db->select('*');
        $this->db->from('terminal_payment');
        $this->db->order_by('terminal_name','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //Get Supplier rate of a product
    public function supplier_rate($product_id)
    {
        $this->db->select('supplier_price');
        $this->db->from('product_information');
        $this->db->where(array('product_id' => $product_id));
        $query = $this->db->get();
        return $query->result_array();

    }
    //Retrieve order Edit Data
    public function retrieve_order_editdata($order_id)
    {
        $this->db->select('
			a.*,
			b.customer_name,
			c.*,
			c.product_id,
			d.product_name,
			d.product_model,
			a.status
			');

        $this->db->from('order a');
        $this->db->join('customer_information b','b.customer_id = a.customer_id');
        $this->db->join('order_details c','c.order_id = a.order_id');
        $this->db->join('product_information d','d.product_id = c.product_id');
        $this->db->where('a.order_id',$order_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Retrieve order_html_data
    public function retrieve_order_html_data($order_id)
    {
        $details_page =  $this->uri->segment(2);

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
			g.customer_name as ship_customer_name,
			g.first_name as ship_first_name, g.last_name as ship_last_name,
			g.customer_short_address as ship_customer_short_address,
			g.customer_address_1 as ship_customer_address_1,
			g.customer_address_2 as ship_customer_address_2,
			g.customer_mobile as ship_customer_mobile,
			g.customer_email as ship_customer_email,
			g.city as ship_city,
			g.state as ship_state,
			g.country as ship_country,
			g.zip as ship_zip,
			g.company as ship_company
			');
        $this->db->from('order a');
        $this->db->join('customer_information b','b.customer_id = a.customer_id');
        $this->db->join('shipping_info g','g.customer_id = a.customer_id');
        $this->db->join('order_details c','c.order_id = a.order_id');
        $this->db->join('product_information d','d.product_id = c.product_id');
        $this->db->join('unit e','e.unit_id = d.unit','left');
        $this->db->join('variant f','f.variant_id = c.variant_id','left');
        $this->db->where('a.order_id',$order_id);
       if($details_page == 'order_details_data') {
           $this->db->where('g.order_id', $order_id);
       }
        $this->db->group_by('c.product_id, c.order_details_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();

        }
        return false;
    }
    // Delete order Item
    public function retrieve_product_data($product_id)
    {
        $this->db->select('supplier_price,price,supplier_id,tax');
        $this->db->from('product_information');
        $this->db->where(array('product_id' => $product_id,'status' => 1));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    //Retrieve company Edit Data
    public function retrieve_company()
    {
        $this->db->select('*');
        $this->db->from('company_information');
        $this->db->limit('1');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    // Delete order Item
    public function delete_order($order_id)
    {

        $invoice = $this->db->select('invoice_id')->where('order_id',$order_id)->from('invoice')->get()->row();
        $invoice_id = @$invoice->invoice_id;

        //Delete order table
        $this->db->where('order_id',$order_id);
        $this->db->delete('order');
        //Delete order_details table
        $this->db->where('order_id',$order_id);
        $this->db->delete('order_details');
        //Order tax summary delete
        $this->db->where('order_id',$order_id);
        $this->db->delete('order_tax_col_summary');
        //Order tax details delete
        $this->db->where('order_id',$order_id);
        $this->db->delete('order_tax_col_details');

        if($invoice_id){
            //invoice details delete
            $this->db->where('invoice_id',$invoice_id);
            $this->db->delete('invoice_details');

            //invoice  delete
            $this->db->where('invoice_id',$invoice_id);
            $this->db->delete('invoice');
            //customer ledger
            $this->db->where('invoice_no',$invoice_id);
            $this->db->delete('customer_ledger');

            //tax_collection_summary
            $this->db->where('invoice_id',$invoice_id);
            $this->db->delete('tax_collection_summary');

            //tax_collection_details
            $this->db->where('invoice_id',$invoice_id);
            $this->db->delete('tax_collection_details');
        }
        return true;
    }
    public function order_search_list($cat_id,$company_id)
    {
        $this->db->select('a.*,b.sub_category_name,c.category_name');
        $this->db->from('orders a');
        $this->db->join('order_sub_category b','b.sub_category_id = a.sub_category_id');
        $this->db->join('order_category c','c.category_id = b.category_id');
        $this->db->where('a.sister_company_id',$company_id);
        $this->db->where('c.category_id',$cat_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    // GET TOTAL PURCHASE PRODUCT
    public function get_total_purchase_item($product_id)
    {
        $this->db->select('SUM(quantity) as total_purchase');
        $this->db->from('product_purchase_details');
        $this->db->where('product_id',$product_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    // GET TOTAL SALES PRODUCT
    public function get_total_sales_item($product_id)
    {
        $this->db->select('SUM(quantity) as total_sale');
        $this->db->from('order_details');
        $this->db->where('product_id',$product_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Get total product
    public function get_total_product($product_id){
        $this->db->select('
			product_name,
			product_id,
			supplier_price,
			price,
			supplier_id,
			unit,
			variants,
			product_model,
			unit.unit_short_name
			');
        $this->db->from('product_information');
        $this->db->join('unit','unit.unit_id = product_information.unit','left');
        $this->db->where(array('product_id' => $product_id,'status' => 1));
        $product_information = $this->db->get()->row();

        $html = $colorhtml = "";
        if (!empty($product_information->variants)) {
            $exploded = explode(',',$product_information->variants);

            $this->db->select('*');
            $this->db->from('variant');
            $this->db->where_in('variant_id',$exploded);
            $this->db->order_by('variant_name','asc');
            $variant_list = $this->db->get()->result();
            $var_types = array_column($variant_list, 'variant_type');

            $html .= '<option value=""></option>';
            foreach ($variant_list as $varitem) {

                if($varitem->variant_type=='size'){
                    $html .="<option value=".$varitem->variant_id.">".$varitem->variant_name."</option>";
                }
            }

            if(in_array('color',$var_types)) {
                $colorhtml .="<option value=''></option>";
                foreach ($variant_list as $varitem2) {
                    if($varitem2->variant_type=='color'){
                        $colorhtml .="<option value=".$varitem2->variant_id.">".$varitem2->variant_name."</option>";
                    }
                }
            }

        }

        $this->db->select('tax.*,tax_product_service.product_id,tax_percentage');
        $this->db->from('tax_product_service');
        $this->db->join('tax','tax_product_service.tax_id = tax.tax_id','left');
        $this->db->where('tax_product_service.product_id',$product_id);
        $tax_information = $this->db->get()->result();

        //New tax calculation for discount
        if(!empty($tax_information)){
            foreach($tax_information as $k=>$v){
                if ($v->tax_id == 'H5MQN4NXJBSDX4L') {
                    $tax['cgst_tax'] 	= ($v->tax_percentage)/100;
                    $tax['cgst_name']	= $v->tax_name;
                    $tax['cgst_id']	 	= $v->tax_id;
                }elseif($v->tax_id == '52C2SKCKGQY6Q9J'){
                    $tax['sgst_tax'] 	= ($v->tax_percentage)/100;
                    $tax['sgst_name']	= $v->tax_name;
                    $tax['sgst_id']	 	= $v->tax_id;
                }elseif($v->tax_id == '5SN9PRWPN131T4V'){
                    $tax['igst_tax'] 	= ($v->tax_percentage)/100;
                    $tax['igst_name']	= $v->tax_name;
                    $tax['igst_id']		= $v->tax_id;
                }
            }
        }

        $purchase = $this->db->select("SUM(quantity) as totalPurchaseQnty")
            ->from('product_purchase_details')
            ->where('product_id',$product_id)
            ->get()
            ->row();

        $sales = $this->db->select("SUM(quantity) as totalSalesQnty")
            ->from('invoice_details')
            ->where('product_id',$product_id)
            ->get()
            ->row();

        $stock = $purchase->totalPurchaseQnty - $sales->totalSalesQnty;


        $data2 = array(
            'total_product'	=> $stock,
            'supplier_price'=> $product_information->supplier_price,
            'price' 		=> $product_information->price,
            'variant_id' 	=> $product_information->variants,
            'supplier_id' 	=> $product_information->supplier_id,
            'product_name' 	=> $product_information->product_name,
            'product_model' => $product_information->product_model,
            'product_id' 	=> $product_information->product_id,
            'variant' 		=> $html,
            'colorhtml'       => $colorhtml,
            'sgst_tax' 		=> (!empty($tax['sgst_tax'])?$tax['sgst_tax']:null),
            'cgst_tax' 		=> (!empty($tax['cgst_tax'])?$tax['cgst_tax']:null),
            'igst_tax' 		=> (!empty($tax['igst_tax'])?$tax['igst_tax']:null),
            'cgst_id' 		=> (!empty($tax['cgst_id'])?$tax['cgst_id']:null),
            'sgst_id' 		=> (!empty($tax['sgst_id'])?$tax['sgst_id']:null),
            'igst_id' 		=> (!empty($tax['igst_id'])?$tax['igst_id']:null),
            'unit' 			=> $product_information->unit_short_name,
        );

        return $data2;
    }

    //This function is used to Generate Key
    public function generator($lenth)
    {
        $number=array("1","2","3","4","5","6","7","8","9");

        for($i=0; $i<$lenth; $i++)
        {
            $rand_value=rand(0,8);
            $rand_number=$number["$rand_value"];

            if(empty($con))
            {
                $con=$rand_number;
            }
            else
            {
                $con="$con"."$rand_number";}
        }
        return $con;
    }
    //NUMBER GENERATOR
    public function number_generator()
    {
        $this->db->select_max('invoice', 'invoice_no');
        $query 		= $this->db->get('invoice');
        $result 	= $query->result_array();
        $order_no 	= $result[0]['invoice_no'];
        if ($order_no !='') {
            $order_no = $order_no + 1;
        }else{
            $order_no = 1000;
        }
        return $order_no;
    }

    //NUMBER GENERATOR FOR ORDER
    public function number_generator_order()
    {
        $this->db->select_max('order', 'order_no');
        $query    = $this->db->get('order');
        $result   = $query->result_array();
        $order_no = $result[0]['order_no'];
        if ($order_no !='') {
            $order_no = $order_no + 1;
        }else{
            $order_no = 1000;
        }
        return $order_no;
    }
    //Product List
    public function product_list()
    {
        $query=$this->db->select('
				supplier_information.*,
				product_information.*,
				product_category.category_name
				')

            ->from('product_information')
            ->join('supplier_information', 'product_information.supplier_id = supplier_information.supplier_id','left')
            ->join('product_category','product_category.category_id = product_information.category_id','left')
            ->group_by('product_information.product_id')
            ->order_by('product_information.product_name','asc')
            ->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    //Category List
    public function category_list()
    {
        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->where('status',1);
        $this->db->order_by('category_name','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }else{
            return false;
        }
    }

    //Product Search
    public function product_search($product_name,$category_id)
    {

        $this->db->select('*');
        $this->db->from('product_information');
        if (!empty($product_name)) {
            $this->db->like('product_name', $product_name, 'both');
        }

        if (!empty($category_id)) {
            $this->db->where('category_id',$category_id);
        }

        $this->db->where('status',1);
        $this->db->order_by('product_name','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }else{
            return false;
        }
    }

    // Order payment info
    public function get_order_payinfo($order_id)
    {
        return $this->db->select('a.*, b.agent as payment_method')
            ->from('order_payment a')
            ->join('payment_gateway b', 'a.payment_id=b.used_id','left')
            ->where('a.order_id', $order_id)
            ->get()->row_array();


    }

    //Best Sale Product
    public function best_sale_product()
    {
        $today    = date("m-d-Y");
        $fromdate = date("m-d-Y",strtotime("-30 days"));

        $product_ids = $this->db->query("SELECT COUNT(a.order_id) as order_count, c.product_name 
                    FROM order_details a
                    LEFT JOIN product_information c
                    ON a.product_id = c.product_id
                    LEFT JOIN `order` b
                    ON a.order_id = b.order_id
                    WHERE DATE(b.date) BETWEEN '".$fromdate."' AND '".$today."'
                    GROUP BY a.product_id ORDER BY order_count DESC LIMIT 5")->result_array();
        if (!empty($product_ids)) {
            return $product_ids;
        }
    }

    public function all_best_sale_product($from_date = false,$to_date = false, $product_id = false){
        $from = date("Y-m-d",strtotime($from_date));
        $to   = date("Y-m-d",strtotime($to_date));
        if(!empty($from_date) && !empty($to_date) && !empty($product_id)){
            $product_ids = $this->db->query("SELECT COUNT(a.order_id) as order_count, c.product_name 
                    FROM order_details a
                    LEFT JOIN product_information c
                    ON a.product_id = c.product_id
                    LEFT JOIN `order` b
                    ON a.order_id = b.order_id
                    WHERE DATE(b.created_at) BETWEEN '".$from."' AND '".$to."' AND c.product_id = '".$product_id."'
                    GROUP BY a.product_id ORDER BY order_count DESC")->result_array();

        }elseif(empty($from_date) && empty($to_date) && !empty($product_id)){
            $product_ids = $this->db->query("SELECT COUNT(a.order_id) as order_count, c.product_name 
                    FROM order_details a
                    LEFT JOIN product_information c
                    ON a.product_id = c.product_id
                    LEFT JOIN `order` b
                    ON a.order_id = b.order_id
                    WHERE c.product_id = '".$product_id."'
                    GROUP BY a.product_id ORDER BY order_count DESC")->result_array();
        }elseif(!empty($from_date) && !empty($to_date) && empty($product_id)){
            $product_ids = $this->db->query("SELECT COUNT(a.order_id) as order_count, c.product_name 
                    FROM order_details a
                    LEFT JOIN product_information c
                    ON a.product_id = c.product_id
                    LEFT JOIN `order` b
                    ON a.order_id = b.order_id
                    WHERE DATE(b.created_at) BETWEEN '".$from."' AND '".$to."'
                    GROUP BY a.product_id ORDER BY order_count DESC")->result_array();
        }else{
            $to          = date("Y-m-d");
            $from        = date("Y-m-d",strtotime("-30 days"));
            $product_ids = $this->db->query("SELECT COUNT(a.order_id) as order_count, c.product_name 
                    FROM order_details a
                    LEFT JOIN product_information c
                    ON a.product_id = c.product_id
                    LEFT JOIN `order` b
                    ON a.order_id = b.order_id
                    WHERE DATE(b.created_at) BETWEEN '".$from."' AND '".$to."'
                    GROUP BY a.product_id ORDER BY order_count DESC")->result_array();
        }
        if (!empty($product_ids)) {
            return $product_ids;
        }
    }
}
