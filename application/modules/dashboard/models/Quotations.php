<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Quotations extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('auth');
		$this->load->library('lcustomer');
		$this->load->library('session');
		$this->load->model('Customers');
		$this->auth->check_user_auth();
	}
	//Count quotation
	public function count_quotation()
	{
		return $this->db->count_all("quotation");
	}
	//quotation List
	public function quotation_list()
	{
		$this->db->select('a.*,b.customer_name');
		$this->db->from('quotation a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->order_by('a.quotation','desc');
		$this->db->limit('500');
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
		$this->db->join('quotation_details d','d.product_id = a.product_id','left');
		$this->db->join('product_purchase e','e.purchase_id = b.purchase_id','left');
		$this->db->group_by('a.product_id');
		$this->db->order_by('a.product_name','asc');

		if(empty($product_id))
		{
			$this->db->where(array('a.status'=>1));
		}
		else
		{
			//Single product information 
			$this->db->where('a.product_id',$product_id);	
		}
		$query = $this->db->get();

		return $query->row();
	}

	//quotation Search Item
	public function search_inovoice_item($customer_id)
	{
		$this->db->select('a.*,b.customer_name');
		$this->db->from('quotation a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->where('b.customer_id',$customer_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//POS quotation entry
	public function pos_quotation_setup($product_id){
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
			$this->db->from('quotation_details b');
			$this->db->where('b.product_id',$product_id);
			$total_sale = $this->db->get()->row();

			

			$data2 = (object)array(
				'total_product' => ($total_purchase->total_purchase - $total_sale->total_sale), 
				'supplier_price' => $product_information->supplier_price, 
				'price' => $product_information->price, 
				'supplier_id' => $product_information->supplier_id, 
				'tax' => $product_information->tax, 
				'product_id' => $product_information->product_id, 
				'product_name' => $product_information->product_name, 
				'product_model' => $product_information->product_model, 
				'unit' => $product_information->unit, 
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
			return TRUE;
		}
	}

	//Quotation entry
	public function quotation_entry()
	{
		//Quotation entry info
		$quotation_id 		= $this->auth->generator(15);
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
		       redirect('Cquotation');
		    }
		}

		//Product existing check
		if ($product_id == null) {
			$this->session->set_userdata(array('error_message'=>display('please_select_product')));
			redirect('Cquotation/pos_quotation');
		}

		//Customer existing check
		if (($this->input->post('customer_name_others',TRUE) == null) && ($this->input->post('customer_id',TRUE) == null )) {
			$this->session->set_userdata(array('error_message'=>display('please_select_customer')));
			redirect(base_url().'Cquotation');
		}
		
		//Customer data Existence Check.
		if($this->input->post('customer_id',TRUE) == "" ){

			$customer_id=$this->auth->generator(15);
		  	//Customer  basic information adding.
			$data=array(
				'customer_id' 	=> $customer_id,
				'customer_name' => $this->input->post('customer_name_others',TRUE),
				'customer_address_1' 	=>$this->input->post('customer_name_others_address',TRUE),
				'customer_mobile' 	=> "NONE",
				'customer_email' 	=> "NONE",
				'status' 			=> 1
				);
		
			$this->Customers->customer_entry($data);
		  	//Previous balance adding -> Sending to customer model to adjust the data.
			$this->Customers->previous_balance_add(0,$customer_id);
		}
		else{
			$customer_id=$this->input->post('customer_id',TRUE);
		}

		//Data inserting into quotation table
		$data=array(
			'quotation_id'		=>	$quotation_id,
			'customer_id'		=>	$customer_id,
			'date'				=>	$this->input->post('invoice_date',TRUE),
			'total_amount'		=>	$this->input->post('grand_total_price',TRUE),
			'quotation'			=>	$this->number_generator(),
			'details'			=>	$this->input->post('details',FALSE),
			'total_discount' 	=> 	$this->input->post('total_discount',TRUE),
			'quotation_discount'=> 	$this->input->post('invoice_discount',TRUE) + $this->input->post('total_discount',TRUE),
			'service_charge'	=> 	$this->input->post('service_charge',TRUE),
			'user_id'			=>	$this->session->userdata('user_id'),
			'store_id'			=>	$this->input->post('store_id',TRUE),
			'paid_amount'		=>	$this->input->post('paid_amount',TRUE),
			'due_amount'		=>	$this->input->post('due_amount',TRUE),
			'status'			=>	1
		);
		$this->db->insert('quotation',$data);

		// Information for quotation details
		$rate 		= $this->input->post('product_rate',TRUE);
		$p_id 		= $this->input->post('product_id',TRUE);
		$total_amount = $this->input->post('total_price',TRUE);
		$discount 	= $this->input->post('discount',TRUE);
		$variants 	= $this->input->post('variant_id',TRUE);

		//Entry for Quotation Details
		for ($i=0, $n=count($quantity); $i < $n; $i++) {
			$product_quantity = $quantity[$i];
			$product_rate 	  = $rate[$i];
			$product_id 	  = $p_id[$i];
			$discount_rate 	  = $discount[$i];
			$total_price      = $total_amount[$i];
			$variant_id		  = $variants[$i];
			$supplier_rate 	  = $this->supplier_rate($product_id);
			
			$quotation_details = array(
				'quotation_details_id'	=>	$this->auth->generator(15),
				'quotation_id'			=>	$quotation_id,
				'product_id'			=>	$product_id,
				'variant_id'			=>	$variant_id,
				'store_id'				=>	$this->input->post('store_id',TRUE),
				'quantity'				=>	$product_quantity,
				'rate'					=>	$product_rate,
				'supplier_rate'         =>	$supplier_rate[0]['supplier_price'],
				'total_price'           =>	$total_price,
				'discount'           	=>	$discount_rate,
				'status'				=>	1
			);

			if(!empty($quantity))
			{
				$result = $this->db->select('*')
									->from('quotation_details')
									->where('quotation_id',$quotation_id)
									->where('product_id',$product_id)
									->where('variant_id',$variant_id)
									->get()
									->num_rows();
				if ($result > 0) {
					$this->db->set('quantity', 'quantity+'.$product_quantity, FALSE);
					$this->db->set('total_price', 'total_price+'.$total_price, FALSE);
					$this->db->where('quotation_id', $quotation_id);
					$this->db->where('product_id', $product_id);
					$this->db->where('variant_id', $variant_id);
					$this->db->update('quotation_details');
				}else{
					$this->db->insert('quotation_details',$quotation_details);
				}
			}
		}

		//Tax information
		$cgst = $this->input->post('cgst',TRUE);
		$sgst = $this->input->post('sgst',TRUE);
		$igst = $this->input->post('igst',TRUE);
		$cgst_id = $this->input->post('cgst_id',TRUE);
		$sgst_id = $this->input->post('sgst_id',TRUE);
		$igst_id = $this->input->post('igst_id',TRUE);

		//Tax collection summary for three start
		//CGST Tax Summary
		for ($i=0, $n=count($cgst); $i < $n; $i++) {
			$cgst_tax = $cgst[$i];
			$cgst_tax_id = $cgst_id[$i];
			$cgst_summary = array(
				'quot_tax_col_id'	=>	$this->auth->generator(15),
				'quotation_id'		=>	$quotation_id,
				'tax_amount' 		=> 	$cgst_tax, 
				'tax_id' 			=> 	$cgst_tax_id,
				'date'				=>	$this->input->post('invoice_date',TRUE),
			);
			if(!empty($cgst[$i])){
				$result= $this->db->select('*')
							->from('quotation_tax_col_summary')
							->where('quotation_id',$quotation_id)
							->where('tax_id',$cgst_tax_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('tax_amount', 'tax_amount+'.$cgst_tax, FALSE);
					$this->db->where('quotation_id', $quotation_id);
					$this->db->where('tax_id', $cgst_tax_id);
					$this->db->update('quotation_tax_col_summary');
				}else{
					$this->db->insert('quotation_tax_col_summary',$cgst_summary);
				}
			}
		}

		//SGST Tax Summary
		for ($i=0, $n=count($sgst); $i < $n; $i++) {
			$sgst_tax = $sgst[$i];
			$sgst_tax_id = $sgst_id[$i];
			
			$sgst_summary = array(
				'quot_tax_col_id'	=>	$this->auth->generator(15),
				'quotation_id'		=>	$quotation_id,
				'tax_amount' 		=> 	$sgst_tax, 
				'tax_id' 			=> 	$sgst_tax_id,
				'date'				=>	$this->input->post('invoice_date',TRUE),
			);
			if(!empty($sgst[$i])){
				$result= $this->db->select('*')
							->from('quotation_tax_col_summary')
							->where('quotation_id',$quotation_id)
							->where('tax_id',$sgst_tax_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('tax_amount', 'tax_amount+'.$sgst_tax, FALSE);
					$this->db->where('quotation_id', $quotation_id);
					$this->db->where('tax_id', $sgst_tax_id);
					$this->db->update('quotation_tax_col_summary');
				}else{
					$this->db->insert('quotation_tax_col_summary',$sgst_summary);
				}
			}
		}

		//IGST Tax Summary
		for ($i=0, $n=count($igst); $i < $n; $i++) {
			$igst_tax = $igst[$i];
			$igst_tax_id = $igst_id[$i];
			
			$igst_summary = array(
				'quot_tax_col_id'	=>	$this->auth->generator(15),
				'quotation_id'		=>	$quotation_id,
				'tax_amount' 		=> 	$igst_tax, 
				'tax_id' 			=> 	$igst_tax_id,
				'date'				=>	$this->input->post('invoice_date',TRUE),
			);
			if(!empty($igst[$i])){
				$result= $this->db->select('*')
							->from('quotation_tax_col_summary')
							->where('quotation_id',$quotation_id)
							->where('tax_id',$igst_tax_id)
							->get()
							->num_rows();

				if ($result > 0) {
					$this->db->set('tax_amount', 'tax_amount+'.$igst_tax, FALSE);
					$this->db->where('quotation_id', $quotation_id);
					$this->db->where('tax_id', $igst_tax_id);
					$this->db->update('quotation_tax_col_summary');
				}else{
					$this->db->insert('quotation_tax_col_summary',$igst_summary);
				}
			}
		}
		//Tax collection summary for three end

		//Tax collection details for three
		//CGST Tax Details
		for ($i=0, $n=count($cgst); $i < $n; $i++) {
			$cgst_tax 	 = $cgst[$i];
			$cgst_tax_id = $cgst_id[$i];
			$product_id  = $p_id[$i];
			$variant_id  = $variants[$i];
			$cgst_details = array(
				'quot_tax_col_de_id'=>	$this->auth->generator(15),
				'quotation_id'		=>	$quotation_id,
				'amount' 			=> 	$cgst_tax, 
				'product_id' 		=> 	$product_id, 
				'tax_id' 			=> 	$cgst_tax_id,
				'variant_id' 		=> 	$variant_id,
				'date'				=>	$this->input->post('invoice_date',TRUE),
			);
			if(!empty($cgst[$i])){

				$result= $this->db->select('*')
							->from('quotation_tax_col_details')
							->where('quotation_id',$quotation_id)
							->where('tax_id',$cgst_tax_id)
							->where('product_id',$product_id)
							->where('variant_id',$variant_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('amount', 'amount+'.$cgst_tax, FALSE);
					$this->db->where('quotation_id', $quotation_id);
					$this->db->where('tax_id', $cgst_tax_id);
					$this->db->where('variant_id', $variant_id);
					$this->db->update('quotation_tax_col_details');
				}else{
					$this->db->insert('quotation_tax_col_details',$cgst_details);
				}
			}
		}

		//SGST Tax Details
		for ($i=0, $n=count($sgst); $i < $n; $i++) {
			$sgst_tax 	 = $sgst[$i];
			$sgst_tax_id = $sgst_id[$i];
			$product_id  = $p_id[$i];
			$variant_id  = $variants[$i];
			$sgst_summary = array(
				'quot_tax_col_de_id'	=>	$this->auth->generator(15),
				'quotation_id'		=>	$quotation_id,
				'amount' 			=> 	$sgst_tax, 
				'product_id' 		=> 	$product_id, 
				'tax_id' 			=> 	$sgst_tax_id,
				'variant_id' 		=> 	$variant_id,
				'date'				=>	$this->input->post('invoice_date',TRUE),
			);
			if(!empty($sgst[$i])){
				$result= $this->db->select('*')
							->from('quotation_tax_col_details')
							->where('quotation_id',$quotation_id)
							->where('tax_id',$sgst_tax_id)
							->where('product_id',$product_id)
							->where('variant_id',$variant_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('amount', 'amount+'.$sgst_tax, FALSE);
					$this->db->where('quotation_id', $quotation_id);
					$this->db->where('tax_id', $sgst_tax_id);
					$this->db->where('variant_id', $variant_id);
					$this->db->update('quotation_tax_col_details');
				}else{
					$this->db->insert('quotation_tax_col_details',$sgst_summary);
				}
			}
		}
		//IGST Tax Details
		for ($i=0, $n=count($igst); $i < $n; $i++) {
			$igst_tax 	 = $igst[$i];
			$igst_tax_id = $igst_id[$i];
			$product_id  = $p_id[$i];
			$variant_id  = $variants[$i];
			$igst_summary = array(
				'quot_tax_col_de_id'=>	$this->auth->generator(15),
				'quotation_id'		=>	$quotation_id,
				'amount' 			=> 	$igst_tax, 
				'product_id' 		=> 	$product_id, 
				'tax_id' 			=> 	$igst_tax_id,
				'variant_id' 		=> 	$variant_id,
				'date'				=>	$this->input->post('invoice_date',TRUE),
			);
			if(!empty($igst[$i])){
				$result= $this->db->select('*')
							->from('quotation_tax_col_details')
							->where('quotation_id',$quotation_id)
							->where('tax_id',$igst_tax_id)
							->where('product_id',$product_id)
							->where('variant_id',$variant_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('amount', 'amount+'.$igst_tax, FALSE);
					$this->db->where('quotation_id', $quotation_id);
					$this->db->where('tax_id', $igst_tax_id);
					$this->db->where('variant_id', $variant_id);
					$this->db->update('quotation_tax_col_details');
				}else{
					$this->db->insert('quotation_tax_col_details',$igst_summary);
				}
			}
		}
		//Tax collection details for three

		return $quotation_id;
	}

	//update_quotation
	public function update_quotation()
	{

		//Quotation and customer info
		$quotation_id  = $this->input->post('quotation_id',TRUE);
		$customer_id   = $this->input->post('customer_id',TRUE);
		
		if($quotation_id!='')
		{
			//Data update into quotation table
			$data=array(
				'quotation_id'		=>	$quotation_id,
				'customer_id'		=>	$customer_id,
				'date'				=>	$this->input->post('invoice_date',TRUE),
				'total_amount'		=>	$this->input->post('grand_total_price',TRUE),
				'quotation'			=>	$this->input->post('quotation',TRUE),
				'total_discount' 	=> 	$this->input->post('total_discount',TRUE),
				'details' 			=> 	$this->input->post('details',FALSE),
				'quotation_discount'=> 	$this->input->post('invoice_discount',TRUE) + $this->input->post('total_discount',TRUE),
				'service_charge'	=> 	$this->input->post('service_charge',TRUE),
				'user_id'			=>	$this->session->userdata('user_id'),
				'store_id'			=>	$this->input->post('store_id',TRUE),
				'paid_amount'		=>	$this->input->post('paid_amount',TRUE),
				'due_amount'		=>	$this->input->post('due_amount',TRUE),
				'status'			=>	$this->input->post('status',TRUE),
			);
			$this->db->where('quotation_id',$quotation_id);
			$result = $this->db->delete('quotation');

			if ($result) {
				$this->db->insert('quotation',$data);
			}
		}

		//Delete old quotation details info
		if (!empty($quotation_id)) {
			$this->db->where('quotation_id',$quotation_id);
			$this->db->delete('quotation_details'); 
		}

		//Quotation details info
		$rate 			= $this->input->post('product_rate',TRUE);
		$p_id 			= $this->input->post('product_id',TRUE);
		$total_amount	= $this->input->post('total_price',TRUE);
		$discount 		= $this->input->post('discount',TRUE);
		$variants 		= $this->input->post('variant_id',TRUE);
		$quotation_d_id = $this->input->post('quotation_details_id',TRUE);
		$quantity 		= $this->input->post('product_quantity',TRUE);

		//invoice details for invoice
		for ($i=0, $n=count($quantity); $i < $n; $i++) {
			$product_quantity = $quantity[$i];
			$product_rate 	  = $rate[$i];
			$product_id 	  = $p_id[$i];
			$discount_rate 	  = $discount[$i];
			$total_price 	  = $total_amount[$i];
			$variant_id 	  = $variants[$i];
			$supplier_rate    = $this->supplier_rate($product_id);
			
			$quotation_details = array(
				'quotation_details_id'	=>	$this->auth->generator(15),
				'quotation_id'			=>	$quotation_id,
				'product_id'			=>	$product_id,
				'variant_id'			=>	$variant_id,
				'quantity'				=>	$product_quantity,
				'rate'					=>	$product_rate,
				'store_id'				=>	$this->input->post('store_id',TRUE),
				'supplier_rate'         =>	$supplier_rate[0]['supplier_price'],
				'total_price'           =>	$total_price,
				'discount'           	=>	$discount_rate,
				'status'				=>	1
			);

			if(!empty($quantity))
			{
				$result = $this->db->select('*')
									->from('quotation_details')
									->where('quotation_id',$quotation_id)
									->where('product_id',$product_id)
									->where('variant_id',$variant_id)
									->get()
									->num_rows();
				if ($result > 0) {
					$this->db->set('quantity', 'quantity+'.$product_quantity, FALSE);
					$this->db->set('total_price', 'total_price+'.$total_price, FALSE);
					$this->db->where('quotation_id', $quotation_id);
					$this->db->where('product_id', $product_id);
					$this->db->where('variant_id', $variant_id);
					$this->db->update('quotation_details');
				}else{
					$this->db->insert('quotation_details',$quotation_details);
				}
			}
		}

		//Quotation tax collection summary
		$cgst = $this->input->post('cgst',TRUE);
		$sgst = $this->input->post('sgst',TRUE);
		$igst = $this->input->post('igst',TRUE);
		$cgst_id = $this->input->post('cgst_id',TRUE);
		$sgst_id = $this->input->post('sgst_id',TRUE);
		$igst_id = $this->input->post('igst_id',TRUE);
		//Tax collection summary for three

		//Delete all tax  from summary
		$this->db->where('quotation_id',$quotation_id);
		$this->db->delete('quotation_tax_col_summary');

		//CGST Tax Summary
		for ($i=0, $n=count($cgst); $i < $n; $i++) {
			$cgst_tax = $cgst[$i];
			$cgst_tax_id = $cgst_id[$i];
			$cgst_summary = array(
				'quot_tax_col_id'	=>	$this->auth->generator(15),
				'quotation_id'		=>	$quotation_id,
				'tax_amount' 		=> 	$cgst_tax, 
				'tax_id' 			=> 	$cgst_tax_id,
				'date'				=>	$this->input->post('invoice_date',TRUE),
			);
			if(!empty($cgst[$i])){
				$result= $this->db->select('*')
							->from('quotation_tax_col_summary')
							->where('quotation_id',$quotation_id)
							->where('tax_id',$cgst_tax_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('tax_amount', 'tax_amount+'.$cgst_tax, FALSE);
					$this->db->where('quotation_id', $quotation_id);
					$this->db->where('tax_id', $cgst_tax_id);
					$this->db->update('quotation_tax_col_summary');
				}else{
					$this->db->insert('quotation_tax_col_summary',$cgst_summary);
				}
			}
		}

		//SGST Tax Summary
		for ($i=0, $n=count($sgst); $i < $n; $i++) {
			$sgst_tax 	 = $sgst[$i];
			$sgst_tax_id = $sgst_id[$i];
			
			$sgst_summary = array(
				'quot_tax_col_id'	=>	$this->auth->generator(15),
				'quotation_id'		=>	$quotation_id,
				'tax_amount' 		=> 	$sgst_tax, 
				'tax_id' 			=> 	$sgst_tax_id,
				'date'				=>	$this->input->post('invoice_date',TRUE),
			);
			if(!empty($sgst[$i])){
				$result= $this->db->select('*')
							->from('quotation_tax_col_summary')
							->where('quotation_id',$quotation_id)
							->where('tax_id',$sgst_tax_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('tax_amount', 'tax_amount+'.$sgst_tax, FALSE);
					$this->db->where('quotation_id', $quotation_id);
					$this->db->where('tax_id', $sgst_tax_id);
					$this->db->update('quotation_tax_col_summary');
				}else{
					$this->db->insert('quotation_tax_col_summary',$sgst_summary);
				}
			}
		}

		//IGST Tax Summary
		for ($i=0, $n=count($igst); $i < $n; $i++) {
			$igst_tax = $igst[$i];
			$igst_tax_id = $igst_id[$i];
			
			$igst_summary = array(
				'quot_tax_col_id'	=>	$this->auth->generator(15),
				'quotation_id'		=>	$quotation_id,
				'tax_amount' 		=> 	$igst_tax, 
				'tax_id' 			=> 	$igst_tax_id,
				'date'				=>	$this->input->post('invoice_date',TRUE),
			);
			if(!empty($igst[$i])){
				$result= $this->db->select('*')
							->from('quotation_tax_col_summary')
							->where('quotation_id',$quotation_id)
							->where('tax_id',$igst_tax_id)
							->get()
							->num_rows();

				if ($result > 0) {
					$this->db->set('tax_amount', 'tax_amount+'.$igst_tax, FALSE);
					$this->db->where('quotation_id', $quotation_id);
					$this->db->where('tax_id', $igst_tax_id);
					$this->db->update('quotation_tax_col_summary');
				}else{
					$this->db->insert('quotation_tax_col_summary',$igst_summary);
				}
			}
		}
		//Tax collection summary for three

		//Delete all tax  from summary
		$this->db->where('quotation_id',$quotation_id);
		$this->db->delete('quotation_tax_col_details');

		//Tax collection details for three
		//CGST Tax Details
		for ($i=0, $n=count($cgst); $i < $n; $i++) {
			$cgst_tax 	 = $cgst[$i];
			$cgst_tax_id = $cgst_id[$i];
			$product_id  = $p_id[$i];
			$variant_id  = $variants[$i];
			$cgst_details = array(
				'quot_tax_col_de_id'	=>	$this->auth->generator(15),
				'quotation_id'		=>	$quotation_id,
				'amount' 			=> 	$cgst_tax, 
				'product_id' 		=> 	$product_id, 
				'tax_id' 			=> 	$cgst_tax_id,
				'variant_id' 		=> 	$variant_id,
				'date'				=>	$this->input->post('invoice_date',TRUE),
			);
			if(!empty($cgst[$i])){
				$result= $this->db->select('*')
							->from('quotation_tax_col_details')
							->where('quotation_id',$quotation_id)
							->where('tax_id',$cgst_tax_id)
							->where('product_id',$product_id)
							->where('variant_id',$variant_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('amount', 'amount+'.$cgst_tax, FALSE);
					$this->db->where('quotation_id', $quotation_id);
					$this->db->where('tax_id', $cgst_tax_id);
					$this->db->where('variant_id', $variant_id);
					$this->db->update('quotation_tax_col_details');
				}else{
					$this->db->insert('quotation_tax_col_details',$cgst_details);
				}
			}
		}

		//SGST Tax Details
		for ($i=0, $n=count($sgst); $i < $n; $i++) {
			$sgst_tax 	 = $sgst[$i];
			$sgst_tax_id = $sgst_id[$i];
			$product_id  = $p_id[$i];
			$variant_id  = $variants[$i];
			$sgst_summary = array(
				'quot_tax_col_de_id'	=>	$this->auth->generator(15),
				'quotation_id'		=>	$quotation_id,
				'amount' 			=> 	$sgst_tax, 
				'product_id' 		=> 	$product_id, 
				'tax_id' 			=> 	$sgst_tax_id,
				'variant_id' 		=> 	$variant_id,
				'date'				=>	$this->input->post('invoice_date',TRUE),
			);
			if(!empty($sgst[$i])){
				$result= $this->db->select('*')
							->from('quotation_tax_col_details')
							->where('quotation_id',$quotation_id)
							->where('tax_id',$sgst_tax_id)
							->where('product_id',$product_id)
							->where('variant_id',$variant_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('amount', 'amount+'.$sgst_tax, FALSE);
					$this->db->where('quotation_id', $quotation_id);
					$this->db->where('tax_id', $sgst_tax_id);
					$this->db->where('variant_id', $variant_id);
					$this->db->update('quotation_tax_col_details');
				}else{
					$this->db->insert('quotation_tax_col_details',$sgst_summary);
				}
			}
		}

		//IGST Tax Details
		for ($i=0, $n=count($igst); $i < $n; $i++) {
			$igst_tax = $igst[$i];
			$igst_tax_id = $igst_id[$i];
			$product_id = $p_id[$i];
		
			if(!empty($igst[$i])){
				$this->db->set('amount', $igst_tax, FALSE);
				$this->db->where('product_id', $product_id);
				$this->db->where('tax_id', $igst_tax_id);
				$this->db->update('quotation_tax_col_details');
			}
		}

		for ($i=0, $n=count($igst); $i < $n; $i++) {
			$igst_tax 	 = $igst[$i];
			$igst_tax_id = $igst_id[$i];
			$product_id  = $p_id[$i];
			$variant_id  = $variants[$i];
			$igst_summary = array(
				'quot_tax_col_de_id'	=>	$this->auth->generator(15),
				'quotation_id'		=>	$quotation_id,
				'amount' 			=> 	$igst_tax, 
				'product_id' 		=> 	$product_id, 
				'tax_id' 			=> 	$igst_tax_id,
				'variant_id' 		=> 	$variant_id,
				'date'				=>	$this->input->post('invoice_date',TRUE),
			);
			if(!empty($igst[$i])){
				$result= $this->db->select('*')
							->from('quotation_tax_col_details')
							->where('quotation_id',$quotation_id)
							->where('tax_id',$igst_tax_id)
							->where('product_id',$product_id)
							->where('variant_id',$variant_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('amount', 'amount+'.$igst_tax, FALSE);
					$this->db->where('quotation_id', $quotation_id);
					$this->db->where('tax_id', $igst_tax_id);
					$this->db->where('variant_id', $variant_id);
					$this->db->update('quotation_tax_col_details');
				}else{
					$this->db->insert('quotation_tax_col_details',$igst_summary);
				}
			}
		}
		//End tax details
		return $quotation_id;
	}
	//Quotation paid to invoice
	public function quot_paid_data($quotation_id){

		//Invoice id
		$invoice_id = $this->auth->generator(15);
		$result=$this->db->select('*')
					->from('quotation')
					->where('quotation_id',$quotation_id)
					->get()
					->row();

		if ($result) {

			$data = array(
				'invoice_id' 	=> $invoice_id,
				'quotation_id' 	=> $result->quotation_id,
				'store_id' 		=> $result->store_id,
				'customer_id' 	=> $result->customer_id,
				'user_id' 		=> $result->user_id,
				'date' 			=> $result->date,
				'total_amount' 	=> $result->total_amount,
				'invoice'       => $this->invoice_number_generator(),
				'invoice_details'=> $result->details,
				'total_discount'=> $result->total_discount,
				'service_charge'=> $result->service_charge,
				'invoice_discount' => $result->quotation_discount,
				'paid_amount' 	=> $result->paid_amount,
				'due_amount' 	=> $result->due_amount,
				'status' 		=> $result->status, 
			);
			//Insert quotation data
			$quotation = $this->db->insert('invoice',$data);


			//Update to customer ledger Table 
			$data2 = array(
				'transaction_id'	=>	$this->auth->generator(15),
				'customer_id'		=>	$result->customer_id,
				'invoice_no'		=>	$invoice_id,
				'quotation_no' 		=> $result->quotation_id, 
				'date'				=>	$result->date,
				'amount'			=>	$result->total_amount,
				'status'			=>	1
			);
			$this->db->insert('customer_ledger',$data2);
		}

		if ($quotation) {

			//Quotation update
			$this->db->set('status','2');
			$this->db->where('quotation_id',$quotation_id);
			$quotation = $this->db->update('quotation');

			$quotation_details = $this->db->select('*')
									->from('quotation_details')
									->where('quotation_id',$quotation_id)
									->get()
									->result();

			//Quotation details
			if ($quotation_details) {
				foreach ($quotation_details as $details) {

					//Quotation details entry
					$data = array(
						'invoice_details_id' => $this->auth->generator(15), 
						'invoice_id' 		 => $invoice_id, 
						'product_id' 		 => $details ->product_id, 
						'variant_id'		 => $details ->variant_id, 
						'store_id'			 => $details ->store_id, 
						'quantity'			 => $details ->quantity, 
						'rate'				 => $details ->rate, 
						'supplier_rate'		 => $details ->supplier_rate, 
						'total_price'		 => $details ->total_price, 
						'discount'			 => $details ->discount, 
						'status'			 => $details ->status, 
					);
					$quotation_details = $this->db->insert('invoice_details',$data);
				}
			}

			//Tax summary entry start
			$this->db->select('*');
			$this->db->from('quotation_tax_col_summary');
			$this->db->where('quotation_id',$quotation_id);
			$query = $this->db->get();
			$tax_summary = $query->result();

			if ($tax_summary) {
				foreach ($tax_summary as $summary) {
					$tax_col_summary = array(
					 	'tax_collection_id' => $summary->quot_tax_col_id,
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
			$this->db->from('quotation_tax_col_details');
			$this->db->where('quotation_id',$quotation_id);
			$query = $this->db->get();
			$tax_details = $query->result();

			if ($tax_details) {
				foreach ($tax_details as $details) {
					$tax_col_details = array(
					 	'tax_col_de_id' 	=> $details->quot_tax_col_de_id,
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
		}
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
	//Retrieve quotation Edit Data
	public function retrieve_quotation_editdata($quotation_id)
	{
		$this->db->select('
				a.*,
				b.customer_name,
				c.*,
				c.product_id,
				d.product_name,
				d.product_model,
			');

		$this->db->from('quotation a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->join('quotation_details c','c.quotation_id = a.quotation_id');
		$this->db->join('product_information d','d.product_id = c.product_id');
		$this->db->where('a.quotation_id',$quotation_id);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Retrieve quotation_html_data
	public function retrieve_quotation_html_data($quotation_id)
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
			f.variant_name
			');
		$this->db->from('quotation a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->join('quotation_details c','c.quotation_id = a.quotation_id');
		$this->db->join('product_information d','d.product_id = c.product_id');
		$this->db->join('unit e','e.unit_id = d.unit','left');
		$this->db->join('variant f','f.variant_id = c.variant_id','left');
		$this->db->where('a.quotation_id',$quotation_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	// Delete quotation Item
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
	// Delete quotation Item
	public function delete_quotation($quotation_id)
	{	
		//Delete quotation table
		$this->db->where('quotation_id',$quotation_id);
		$this->db->delete('quotation'); 
		//Delete quotation_details table
		$this->db->where('quotation_id',$quotation_id);
		$this->db->delete('quotation_details'); 
		//Quotation tax summary delete
		$this->db->where('quotation_id',$quotation_id);
		$this->db->delete('quotation_tax_col_summary'); 
		//Quotation tax details delete
		$this->db->where('quotation_id',$quotation_id);
		$this->db->delete('quotation_tax_col_details'); 
		return true;
	}
	public function quotation_search_list($cat_id,$company_id)
	{
		$this->db->select('a.*,b.sub_category_name,c.category_name');
		$this->db->from('quotations a');
		$this->db->join('quotation_sub_category b','b.sub_category_id = a.sub_category_id');
		$this->db->join('quotation_category c','c.category_id = b.category_id');
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
		$this->db->from('quotation_details');
		$this->db->where('product_id',$product_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Get total product
	public function get_total_product($product_id){
		$this->db->select('SUM(a.quantity) as total_purchase');
		$this->db->from('product_purchase_details a');
		$this->db->where('a.product_id',$product_id);
		$total_purchase = $this->db->get()->row();

		$this->db->select('SUM(b.quantity) as total_sale');
		$this->db->from('quotation_details b');
		$this->db->where('b.product_id',$product_id);
		$total_sale = $this->db->get()->row();

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
		$this->db->join('unit','unit.unit_id = product_information.unit');
		$this->db->where(array('product_id' => $product_id,'status' => 1)); 
		$product_information = $this->db->get()->row();

		$this->db->select('tax.*,tax_product_service.product_id,tax_percentage');
		$this->db->from('tax_product_service');
		$this->db->join('tax','tax_product_service.tax_id = tax.tax_id','left');
		$this->db->where('tax_product_service.product_id',$product_id);
		$tax_information = $this->db->get()->result();


		if(!empty($tax_information)){
			foreach($tax_information as $k=>$v){
			   if ($v->tax_name == 'CGST') {
			   		$tax['cgst_tax'] = ($product_information->price * $v->tax_percentage)/100;
			   		$tax['cgst_name']	= $v->tax_name; 
			   		$tax['cgst_id']	= $v->tax_id; 
			   }elseif($v->tax_name == 'SGST'){
			   		$tax['sgst_tax'] = ($product_information->price * $v->tax_percentage)/100;
			   		$tax['sgst_name']	= $v->tax_name; 
			   		$tax['sgst_id']	= $v->tax_id; 
			   }elseif($v->tax_name == 'IGST'){
			   		$tax['igst_tax'] = ($product_information->price * $v->tax_percentage)/100;
			   		$tax['igst_name']	= $v->tax_name; 
			   		$tax['igst_id']	= $v->tax_id; 
			   }
			}
		}


		$data2 = array(
			'total_product' => ($total_purchase->total_purchase - $total_sale->total_sale), 
			'supplier_price' => $product_information->supplier_price, 
			'price' 		=> $product_information->price, 
			'variant_id' 	=> $product_information->variants, 
			'supplier_id' 	=> $product_information->supplier_id, 
			'product_name' 	=> $product_information->product_name, 
			'product_model' => $product_information->product_model, 
			'product_id' 	=> $product_information->product_id, 
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
	//QUOTATION NUMBER GENERATOR
	public function number_generator()
	{
		$this->db->select_max('quotation', 'quotation');
		$query = $this->db->get('quotation');	
		$result = $query->result_array();	
		$quotation_no = $result[0]['quotation'];
		if ($quotation_no !='') {
			$quotation_no = $quotation_no + 1;	
		}else{
			$quotation_no = 1000;
		}
		return $quotation_no;		
	}

	//INVOICE NUMBER GENERATOR
	public function invoice_number_generator()
	{
		$this->db->select_max('invoice', 'invoice');
		$query = $this->db->get('invoice');	
		$result = $query->result_array();	
		$quotation_no = $result[0]['invoice'];
		if ($quotation_no !='') {
			$quotation_no = $quotation_no + 1;	
		}else{
			$quotation_no = 1000;
		}
		return $quotation_no;		
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
} 
