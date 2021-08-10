<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Store_invoices extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Customers');
	}
	//Count invoice
	public function count_invoice()
	{
		return $this->db->count_all("invoice");
	}
	//invoice List
	public function invoice_list()
	{
		$store_id = $this->session->userdata('store_id');

		$this->db->select('a.*,b.*');
		$this->db->from('invoice a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->order_by('a.invoice','desc');
		$this->db->where('a.store_id',$store_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//POS customer setup to show  add pos invoice page 
	public function pos_customer_setup(){
			$query= $this->db->select('a.customer_id,a.customer_name')
						->from('customer_information a')
						->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}else{
			return false;
		}
	}
	//Customer list to show  add pos invoice page 
	public function customer_list(){
		$query= $this->db->select('a.customer_id,a.customer_name')
						->from('customer_information a')
						->where('a.customer_name !=','Walking Customer')
						->order_by('customer_name','asc')
						->get();
		if ($query->num_rows() > 0) {
			return $query->result();	
		}else{
			return false;
		}
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
		$this->db->join('invoice_details d','d.product_id = a.product_id','left');
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


	//Stock Report by date
	public function stock_report_bydate_pos($product_id)
	{
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

		return $stock = $purchase->totalPurchaseQnty - $sales->totalSalesQnty;
	}

	//Invoice entry
	public function invoice_entry()
	{
		//Invoice entry info
		$invoice_id 		= $this->auth->generator(15);
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
		       redirect('dashboard/Store_invoice');
		    }
		}

		//Product existing check
		if ($product_id == null) {
			$this->session->set_userdata(array('error_message'=>display('please_select_product')));
			redirect('dashboard/Store_invoice');
		}

		//Customer existing check
		if (($this->input->post('customer_name_others',TRUE) == null) && ($this->input->post('customer_id',TRUE) == null )) {
			$this->session->set_userdata(array('error_message'=>display('please_select_customer')));
			redirect(base_url().'dashboard/Store_invoice');
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

		//Full or partial Payment record.
		if($this->input->post('paid_amount',TRUE) > 0)
		{
			//Insert to customer_ledger Table 
			$data2 = array(
				'transaction_id'	=>	$this->auth->generator(15),
				'customer_id'		=>	$customer_id,
				'receipt_no'		=>	$this->auth->generator(15),
				'date'				=>	$this->input->post('invoice_date',TRUE),
				'amount'			=>	$this->input->post('paid_amount',TRUE),
				'payment_type'		=>	1,
				'description'		=>	'ITP',
				'status'			=>	1
			);
			$this->db->insert('customer_ledger',$data2);
		}

		//Data inserting into invoice table
		$data=array(
			'invoice_id'		=>	$invoice_id,
			'customer_id'		=>	$customer_id,
			'date'				=>	$this->input->post('invoice_date',TRUE),
			'total_amount'		=>	$this->input->post('grand_total_price',TRUE),
			'invoice'			=>	$this->number_generator(),
			'total_discount' 	=> 	$this->input->post('total_discount',TRUE),
			'invoice_discount' 	=> 	$this->input->post('invoice_discount',TRUE) + $this->input->post('total_discount',TRUE),
			'service_charge' 	=> 	$this->input->post('service_charge',TRUE),
			'user_id'			=>	$this->session->userdata('user_id'),
			'store_id'			=>	$this->session->userdata('store_id'),
			'paid_amount'		=>	$this->input->post('paid_amount',TRUE),
			'due_amount'		=>	$this->input->post('due_amount',TRUE),
			'invoice_details'	=>	$this->input->post('invoice_details',FALSE),
			'status'			=>	1
		);
		$this->db->insert('invoice',$data);
		
		//Insert to customer ledger Table 
		$data2 = array(
			'transaction_id'	=>	$this->auth->generator(15),
			'customer_id'		=>	$customer_id,
			'invoice_no'		=>	$invoice_id,
			'date'				=>	$this->input->post('invoice_date',TRUE),
			'amount'			=>	$this->input->post('grand_total_price',TRUE),
			'status'			=>	1
		);
		$this->db->insert('customer_ledger',$data2);

		//Insert payment method
		$terminal 	= $this->input->post('terminal',TRUE);
		$card_type 	= $this->input->post('card_type',TRUE);
		$card_no 	= $this->input->post('card_no',TRUE);
		if ($card_no != null) {
			$data3 = array(
			'cardpayment_id'=>	$this->auth->generator(15),
			'terminal_id'	=>	$terminal,
			'card_type'		=>	$card_type,
			'card_no'		=>	$card_no,
			'amount'		=>	$this->input->post('grand_total_price',TRUE),
			'invoice_id'	=>	$invoice_id,
			'date'			=>	$this->input->post('invoice_date',TRUE),
			);
			$this->db->insert('cardpayment',$data3);
		}

		//Invoice details info
		$rate 		= $this->input->post('product_rate',TRUE);
		$p_id 		= $this->input->post('product_id',TRUE);
		$total_amount = $this->input->post('total_price',TRUE);
		$discount 	= $this->input->post('discount',TRUE);
		$variants 	= $this->input->post('variant_id',TRUE);

		//Invoice details for invoice
		for ($i=0, $n=count($quantity); $i < $n; $i++) {
			$product_quantity = $quantity[$i];
			$product_rate 	  = $rate[$i];
			$product_id 	  = $p_id[$i];
			$discount_rate    = $discount[$i];
			$total_price      = $total_amount[$i];
			$variant_id       = $variants[$i];
			$supplier_rate	  = $this->supplier_rate($product_id);
			
			$invoice_details = array(
				'invoice_details_id'	=>	$this->auth->generator(15),
				'invoice_id'			=>	$invoice_id,
				'product_id'			=>	$product_id,
				'variant_id'			=>	$variant_id,
				'store_id'				=>	$this->session->userdata('store_id'),
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
									->from('invoice_details')
									->where('invoice_id',$invoice_id)
									->where('product_id',$product_id)
									->where('variant_id',$variant_id)
									->get()
									->num_rows();
				if ($result > 0) {
					$this->db->set('quantity', 'quantity+'.$product_quantity, FALSE);
					$this->db->set('total_price', 'total_price+'.$total_price, FALSE);
					$this->db->where('invoice_id', $invoice_id);
					$this->db->where('product_id', $product_id);
					$this->db->where('variant_id', $variant_id);
					$this->db->update('invoice_details');
				}else{
					$this->db->insert('invoice_details',$invoice_details);
				}
			}
		}

		//Tax information
		$cgst 	 = $this->input->post('cgst',TRUE);
		$sgst 	 = $this->input->post('sgst',TRUE);
		$igst 	 = $this->input->post('igst',TRUE);
		$cgst_id = $this->input->post('cgst_id',TRUE);
		$sgst_id = $this->input->post('sgst_id',TRUE);
		$igst_id = $this->input->post('igst_id',TRUE);

		//Tax collection summary for three start

		//CGST tax info
		for ($i=0, $n=count($cgst); $i < $n; $i++) {
			$cgst_tax = $cgst[$i];
			$cgst_tax_id = $cgst_id[$i];
			$cgst_summary = array(
				'tax_collection_id'	=>	$this->auth->generator(15),
				'invoice_id'		=>	$invoice_id,
				'tax_amount' 		=> 	$cgst_tax, 
				'tax_id' 			=> 	$cgst_tax_id,
				'date'				=>	$this->input->post('invoice_date',TRUE),
			);
			if(!empty($cgst[$i])){
				$result= $this->db->select('*')
							->from('tax_collection_summary')
							->where('invoice_id',$invoice_id)
							->where('tax_id',$cgst_tax_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('tax_amount', 'tax_amount+'.$cgst_tax, FALSE);
					$this->db->where('invoice_id', $invoice_id);
					$this->db->where('tax_id', $cgst_tax_id);
					$this->db->update('tax_collection_summary');
				}else{
					$this->db->insert('tax_collection_summary',$cgst_summary);
				}
			}
		}

		//SGST tax info
		for ($i=0, $n=count($sgst); $i < $n; $i++) {
			$sgst_tax = $sgst[$i];
			$sgst_tax_id = $sgst_id[$i];
			
			$sgst_summary = array(
				'tax_collection_id'	=>	$this->auth->generator(15),
				'invoice_id'		=>	$invoice_id,
				'tax_amount' 		=> 	$sgst_tax, 
				'tax_id' 			=> 	$sgst_tax_id,
				'date'				=>	$this->input->post('invoice_date',TRUE),
			);
			if(!empty($sgst[$i])){
				$result= $this->db->select('*')
							->from('tax_collection_summary')
							->where('invoice_id',$invoice_id)
							->where('tax_id',$sgst_tax_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('tax_amount', 'tax_amount+'.$sgst_tax, FALSE);
					$this->db->where('invoice_id', $invoice_id);
					$this->db->where('tax_id', $sgst_tax_id);
					$this->db->update('tax_collection_summary');
				}else{
					$this->db->insert('tax_collection_summary',$sgst_summary);
				}
			}
		}

		//IGST tax info
       	for ($i=0, $n=count($igst); $i < $n; $i++) {
			$igst_tax = $igst[$i];
			$igst_tax_id = $igst_id[$i];
			
			$igst_summary = array(
				'tax_collection_id'	=>	$this->auth->generator(15),
				'invoice_id'		=>	$invoice_id,
				'tax_amount' 		=> 	$igst_tax, 
				'tax_id' 			=> 	$igst_tax_id,
				'date'				=>	$this->input->post('invoice_date',TRUE),
			);
			if(!empty($igst[$i])){
				$result= $this->db->select('*')
							->from('tax_collection_summary')
							->where('invoice_id',$invoice_id)
							->where('tax_id',$igst_tax_id)
							->get()
							->num_rows();

				if ($result > 0) {
					$this->db->set('tax_amount', 'tax_amount+'.$igst_tax, FALSE);
					$this->db->where('invoice_id', $invoice_id);
					$this->db->where('tax_id', $igst_tax_id);
					$this->db->update('tax_collection_summary');
				}else{
					$this->db->insert('tax_collection_summary',$igst_summary);
				}
			}
		}
		//Tax collection summary for three end

		//Tax collection details for three start
		//CGST tax info
		for ($i=0, $n=count($cgst); $i < $n; $i++) {
			$cgst_tax 	 = $cgst[$i];
			$cgst_tax_id = $cgst_id[$i];
			$product_id  = $p_id[$i];
			$variant_id  = $variants[$i];
			$cgst_details = array(
				'tax_col_de_id'		=>	$this->auth->generator(15),
				'invoice_id'		=>	$invoice_id,
				'amount' 			=> 	$cgst_tax, 
				'product_id' 		=> 	$product_id, 
				'tax_id' 			=> 	$cgst_tax_id,
				'variant_id' 		=> 	$variant_id,
				'date'				=>	$this->input->post('invoice_date',TRUE),
			);
			if(!empty($cgst[$i])){

				$result= $this->db->select('*')
							->from('tax_collection_details')
							->where('invoice_id',$invoice_id)
							->where('tax_id',$cgst_tax_id)
							->where('product_id',$product_id)
							->where('variant_id',$variant_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('amount', 'amount+'.$cgst_tax, FALSE);
					$this->db->where('invoice_id', $invoice_id);
					$this->db->where('tax_id', $cgst_tax_id);
					$this->db->where('variant_id', $variant_id);
					$this->db->update('tax_collection_details');
				}else{
					$this->db->insert('tax_collection_details',$cgst_details);
				}
			}
		}

		//SGST tax info
		for ($i=0, $n=count($sgst); $i < $n; $i++) {
			$sgst_tax 	 = $sgst[$i];
			$sgst_tax_id = $sgst_id[$i];
			$product_id  = $p_id[$i];
			$variant_id  = $variants[$i];
			$sgst_summary = array(
				'tax_col_de_id'	=>	$this->auth->generator(15),
				'invoice_id'		=>	$invoice_id,
				'amount' 			=> 	$sgst_tax, 
				'product_id' 		=> 	$product_id, 
				'tax_id' 			=> 	$sgst_tax_id,
				'variant_id' 		=> 	$variant_id,
				'date'				=>	$this->input->post('invoice_date',TRUE),
			);
			if(!empty($sgst[$i])){
				$result= $this->db->select('*')
							->from('tax_collection_details')
							->where('invoice_id',$invoice_id)
							->where('tax_id',$sgst_tax_id)
							->where('product_id',$product_id)
							->where('variant_id',$variant_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('amount', 'amount+'.$sgst_tax, FALSE);
					$this->db->where('invoice_id', $invoice_id);
					$this->db->where('tax_id', $sgst_tax_id);
					$this->db->where('variant_id', $variant_id);
					$this->db->update('tax_collection_details');
				}else{
					$this->db->insert('tax_collection_details',$sgst_summary);
				}
			}
		}

		// IGST tax info
       	for ($i=0, $n=count($igst); $i < $n; $i++) {
			$igst_tax 	 = $igst[$i];
			$igst_tax_id = $igst_id[$i];
			$product_id  = $p_id[$i];
			$variant_id  = $variants[$i];
			$igst_summary = array(
				'tax_col_de_id'		=>	$this->auth->generator(15),
				'invoice_id'		=>	$invoice_id,
				'amount' 			=> 	$igst_tax, 
				'product_id' 		=> 	$product_id, 
				'tax_id' 			=> 	$igst_tax_id,
				'variant_id' 		=> 	$variant_id,
				'date'				=>	$this->input->post('invoice_date',TRUE),
			);
			if(!empty($igst[$i])){
				$result= $this->db->select('*')
							->from('tax_collection_details')
							->where('invoice_id',$invoice_id)
							->where('tax_id',$igst_tax_id)
							->where('product_id',$product_id)
							->where('variant_id',$variant_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('amount', 'amount+'.$igst_tax, FALSE);
					$this->db->where('invoice_id', $invoice_id);
					$this->db->where('tax_id', $igst_tax_id);
					$this->db->where('variant_id', $variant_id);
					$this->db->update('tax_collection_details');
				}else{
					$this->db->insert('tax_collection_details',$igst_summary);
				}
			}
		}
		//Tax collection details for three end
		return $invoice_id;
	}

	//Update Invoice
	public function update_invoice()
	{
		//Invoice and customer info
		$invoice_id  = $this->input->post('invoice_id',TRUE);
		$customer_id = $this->input->post('customer_id',TRUE);
		$quantity 	 = $this->input->post('product_quantity',TRUE);
		$available_quantity = $this->input->post('available_quantity',TRUE);

		//Stock availability check
		$result = array();
		foreach($available_quantity as $k => $v)
		{
		    if($v < $quantity[$k])
		    {
		       $this->session->set_userdata(array('error_message'=>display('you_can_not_buy_greater_than_available_cartoon')));
		       redirect('dashboard/Store_invoice/manage_invoice');
		    }
		}
		
		if($invoice_id!='')
		{
			//Data update into invoice table
			$data=array(
				'invoice_id'		=>	$invoice_id,
				'customer_id'		=>	$customer_id,
				'date'				=>	$this->input->post('invoice_date',TRUE),
				'total_amount'		=>	$this->input->post('grand_total_price',TRUE),
				'invoice'			=>	$this->input->post('invoice',TRUE),
				'total_discount' 	=> 	$this->input->post('total_discount',TRUE),
				'invoice_discount' 	=> 	$this->input->post('invoice_discount',TRUE) + $this->input->post('total_discount',TRUE),
				'service_charge' 	=> 	$this->input->post('service_charge',TRUE),
				'user_id'			=>	$this->session->userdata('user_id'),
				'store_id'			=>	$this->session->userdata('store_id'),
				'paid_amount'		=>	$this->input->post('paid_amount',TRUE),
				'due_amount'		=>	$this->input->post('due_amount',TRUE),
				'invoice_details'   =>	$this->input->post('invoice_details',FALSE),
				'invoice_status'   	=>	$this->input->post('invoice_status',TRUE),
				'status'			=>	1
			);
			$this->db->where('invoice_id',$invoice_id);
			$result = $this->db->delete('invoice');

			if ($result) {
				$this->db->insert('invoice',$data);
			}

			//Update to customer ledger Table 
			$data2 = array(
				'customer_id'		=>	$customer_id,
				'invoice_no'		=>	$invoice_id,
				'date'				=>	$this->input->post('invoice_date',TRUE),
				'amount'			=>	$this->input->post('grand_total_price',TRUE),
				'status'			=>	1
			);
			$this->db->where('invoice_no',$invoice_id);
			$this->db->update('customer_ledger',$data2);  
		}

		//Insert payment method
		$terminal 	= $this->input->post('terminal',TRUE);
		$card_type 	= $this->input->post('card_type',TRUE);
		$card_no 	= $this->input->post('card_no',TRUE);
		if ($card_no != null) {
			$data3 = array(
			'terminal_id'	=>	$terminal,
			'card_type'		=>	$card_type,
			'card_no'		=>	$card_no,
			'amount'		=>	$this->input->post('grand_total_price',TRUE),
			'invoice_id'	=>	$invoice_id,
			'date'			=>	$this->input->post('invoice_date',TRUE),
			);
			$this->db->where('invoice_id',$invoice_id);
			$this->db->update('cardpayment',$data3); 
		}
		
		//Delete old invoice info
		if (!empty($invoice_id)) {
			$this->db->where('invoice_id',$invoice_id);
			$this->db->delete('invoice_details'); 
		}

		//Invoice details for inovoice
		$invoice_d_id 	= $this->input->post('invoice_details_id',TRUE);
		$rate 			= $this->input->post('product_rate',TRUE);
		$p_id 			= $this->input->post('product_id',TRUE);
		$total_amount 	= $this->input->post('total_price',TRUE);
		$discount 		= $this->input->post('discount',TRUE);
		$variants 		= $this->input->post('variant_id',TRUE);

		//Invoice details for invoice
		for ($i=0, $n=count($p_id); $i < $n; $i++) {
			$product_quantity = $quantity[$i];
			$product_rate 	  = $rate[$i];
			$product_id 	  = $p_id[$i];
			$discount_rate 	  = $discount[$i];
			$total_price 	  = $total_amount[$i];
			$variant_id 	  = $variants[$i];
			$invoice_detail_id= (!empty($invoice_d_id[$i])?$invoice_d_id[$i]:null);
			$supplier_rate    = $this->supplier_rate($product_id);
			
			$invoice_details = array(
				'invoice_details_id'	=>	$this->auth->generator(15),
				'invoice_id'			=>	$invoice_id,
				'product_id'			=>	$product_id,
				'variant_id'			=>	$variant_id,
				'store_id'				=>	$this->session->userdata('store_id'),
				'quantity'				=>	$product_quantity,
				'rate'					=>	$product_rate,
				'supplier_rate'         =>	$supplier_rate[0]['supplier_price'],
				'total_price'           =>	$total_price,
				'discount'           	=>	$discount_rate,
				'status'				=>	1
			);

			if(!empty($p_id))
			{
				$result = $this->db->select('*')
									->from('invoice_details')
									->where('invoice_id',$invoice_id)
									->where('product_id',$product_id)
									->where('variant_id',$variant_id)
									->get()
									->num_rows();
				if ($result > 0) {
					$this->db->set('quantity', 'quantity+'.$product_quantity, FALSE);
					$this->db->set('total_price', 'total_price+'.$total_price, FALSE);
					$this->db->where('invoice_id', $invoice_id);
					$this->db->where('product_id', $product_id);
					$this->db->where('variant_id', $variant_id);
					$this->db->update('invoice_details');
				}else{
					$this->db->insert('invoice_details',$invoice_details);
				}
			}
		}

		//Tax information
		$cgst 	 = $this->input->post('cgst',TRUE);
		$sgst 	 = $this->input->post('sgst',TRUE);
		$igst 	 = $this->input->post('igst',TRUE);
		$cgst_id = $this->input->post('cgst_id',TRUE);
		$sgst_id = $this->input->post('sgst_id',TRUE);
		$igst_id = $this->input->post('igst_id',TRUE);

		//Tax collection summary for three start


		//Delete all tax  from summary
		$this->db->where('invoice_id',$invoice_id);
		$this->db->delete('tax_collection_summary');

		//CGST tax info
		for ($i=0, $n=count($cgst); $i < $n; $i++) {
			$cgst_tax = $cgst[$i];
			$cgst_tax_id = $cgst_id[$i];
			$cgst_summary = array(
				'tax_collection_id'	=>	$this->auth->generator(15),
				'invoice_id'		=>	$invoice_id,
				'tax_amount' 		=> 	$cgst_tax, 
				'tax_id' 			=> 	$cgst_tax_id,
				'date'				=>	$this->input->post('invoice_date',TRUE),
			);
			if(!empty($cgst[$i])){
				$result= $this->db->select('*')
							->from('tax_collection_summary')
							->where('invoice_id',$invoice_id)
							->where('tax_id',$cgst_tax_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('tax_amount', 'tax_amount+'.$cgst_tax, FALSE);
					$this->db->where('invoice_id', $invoice_id);
					$this->db->where('tax_id', $cgst_tax_id);
					$this->db->update('tax_collection_summary');
				}else{
					$this->db->insert('tax_collection_summary',$cgst_summary);
				}
			}
		}

		//SGST tax info
		for ($i=0, $n=count($sgst); $i < $n; $i++) {
			$sgst_tax = $sgst[$i];
			$sgst_tax_id = $sgst_id[$i];
			
			$sgst_summary = array(
				'tax_collection_id'	=>	$this->auth->generator(15),
				'invoice_id'		=>	$invoice_id,
				'tax_amount' 		=> 	$sgst_tax, 
				'tax_id' 			=> 	$sgst_tax_id,
				'date'				=>	$this->input->post('invoice_date',TRUE),
			);
			if(!empty($sgst[$i])){
				$result= $this->db->select('*')
							->from('tax_collection_summary')
							->where('invoice_id',$invoice_id)
							->where('tax_id',$sgst_tax_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('tax_amount', 'tax_amount+'.$sgst_tax, FALSE);
					$this->db->where('invoice_id', $invoice_id);
					$this->db->where('tax_id', $sgst_tax_id);
					$this->db->update('tax_collection_summary');
				}else{
					$this->db->insert('tax_collection_summary',$sgst_summary);
				}
			}
		}

		//IGST tax info
       	for ($i=0, $n=count($igst); $i < $n; $i++) {
			$igst_tax = $igst[$i];
			$igst_tax_id = $igst_id[$i];
			
			$igst_summary = array(
				'tax_collection_id'	=>	$this->auth->generator(15),
				'invoice_id'		=>	$invoice_id,
				'tax_amount' 		=> 	$igst_tax, 
				'tax_id' 			=> 	$igst_tax_id,
				'date'				=>	$this->input->post('invoice_date',TRUE),
			);
			if(!empty($igst[$i])){
				$result= $this->db->select('*')
							->from('tax_collection_summary')
							->where('invoice_id',$invoice_id)
							->where('tax_id',$igst_tax_id)
							->get()
							->num_rows();

				if ($result > 0) {
					$this->db->set('tax_amount', 'tax_amount+'.$igst_tax, FALSE);
					$this->db->where('invoice_id', $invoice_id);
					$this->db->where('tax_id', $igst_tax_id);
					$this->db->update('tax_collection_summary');
				}else{
					$this->db->insert('tax_collection_summary',$igst_summary);
				}
			}
		}
		//Tax collection summary for three end

		//Delete all tax  from summary
		$this->db->where('invoice_id',$invoice_id);
		$this->db->delete('tax_collection_details');

		//Tax collection details for three start
		//CGST tax info
		for ($i=0, $n=count($cgst); $i < $n; $i++) {
			$cgst_tax 	 = $cgst[$i];
			$cgst_tax_id = $cgst_id[$i];
			$product_id  = $p_id[$i];
			$variant_id  = $variants[$i];
			$cgst_details = array(
				'tax_col_de_id'		=>	$this->auth->generator(15),
				'invoice_id'		=>	$invoice_id,
				'amount' 			=> 	$cgst_tax, 
				'product_id' 		=> 	$product_id, 
				'tax_id' 			=> 	$cgst_tax_id,
				'variant_id' 		=> 	$variant_id,
				'date'				=>	$this->input->post('invoice_date',TRUE),
			);
			if(!empty($cgst[$i])){

				$result= $this->db->select('*')
							->from('tax_collection_details')
							->where('invoice_id',$invoice_id)
							->where('tax_id',$cgst_tax_id)
							->where('product_id',$product_id)
							->where('variant_id',$variant_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('amount', 'amount+'.$cgst_tax, FALSE);
					$this->db->where('invoice_id', $invoice_id);
					$this->db->where('tax_id', $cgst_tax_id);
					$this->db->where('variant_id', $variant_id);
					$this->db->update('tax_collection_details');
				}else{
					$this->db->insert('tax_collection_details',$cgst_details);
				}
			}
		}

		//SGST tax info
		for ($i=0, $n=count($sgst); $i < $n; $i++) {
			$sgst_tax 	 = $sgst[$i];
			$sgst_tax_id = $sgst_id[$i];
			$product_id  = $p_id[$i];
			$variant_id  = $variants[$i];
			$sgst_summary = array(
				'tax_col_de_id'	=>	$this->auth->generator(15),
				'invoice_id'		=>	$invoice_id,
				'amount' 			=> 	$sgst_tax, 
				'product_id' 		=> 	$product_id, 
				'tax_id' 			=> 	$sgst_tax_id,
				'variant_id' 		=> 	$variant_id,
				'date'				=>	$this->input->post('invoice_date',TRUE),
			);
			if(!empty($sgst[$i])){
				$result= $this->db->select('*')
							->from('tax_collection_details')
							->where('invoice_id',$invoice_id)
							->where('tax_id',$sgst_tax_id)
							->where('product_id',$product_id)
							->where('variant_id',$variant_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('amount', 'amount+'.$sgst_tax, FALSE);
					$this->db->where('invoice_id', $invoice_id);
					$this->db->where('tax_id', $sgst_tax_id);
					$this->db->where('variant_id', $variant_id);
					$this->db->update('tax_collection_details');
				}else{
					$this->db->insert('tax_collection_details',$sgst_summary);
				}
			}
		}

		// IGST tax info
       	for ($i=0, $n=count($igst); $i < $n; $i++) {
			$igst_tax 	 = $igst[$i];
			$igst_tax_id = $igst_id[$i];
			$product_id  = $p_id[$i];
			$variant_id  = $variants[$i];
			$igst_summary = array(
				'tax_col_de_id'		=>	$this->auth->generator(15),
				'invoice_id'		=>	$invoice_id,
				'amount' 			=> 	$igst_tax, 
				'product_id' 		=> 	$product_id, 
				'tax_id' 			=> 	$igst_tax_id,
				'variant_id' 		=> 	$variant_id,
				'date'				=>	$this->input->post('invoice_date',TRUE),
			);
			if(!empty($igst[$i])){
				$result= $this->db->select('*')
							->from('tax_collection_details')
							->where('invoice_id',$invoice_id)
							->where('tax_id',$igst_tax_id)
							->where('product_id',$product_id)
							->where('variant_id',$variant_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('amount', 'amount+'.$igst_tax, FALSE);
					$this->db->where('invoice_id', $invoice_id);
					$this->db->where('tax_id', $igst_tax_id);
					$this->db->where('variant_id', $variant_id);
					$this->db->update('tax_collection_details');
				}else{
					$this->db->insert('tax_collection_details',$igst_summary);
				}
			}
		}
		//Tax collection details for three end
		return $invoice_id;
	}


	//Stock report variant by date
	public function stock_report_variant_bydate($from_date,$to_date,$store_id,$perpage,$page){
	$this->db->select("
				a.product_name,
				a.unit,
				a.product_id,
				a.price,
				a.supplier_price,
				a.product_model,
				c.category_name,
				sum(b.quantity) as totalPrhcsCtn,
				b.date_time,
				g.variant_name,
				g.variant_id,
				h.store_name,
				h.store_id,
			");
        $wh= "date_format( str_to_date( date_time, '%m-%d-%Y' ) , '%Y-%m-%d' ) Between '".$from_date."' AND'".$to_date."'";

		$this->db->from('product_information a');
		$this->db->join('transfer b','b.product_id = a.product_id','left');
		$this->db->join('product_category c' ,'c.category_id = a.category_id');
		$this->db->join('variant g','g.variant_id = b.variant_id','left');
		$this->db->join('store_set h','h.store_id = b.store_id');
		$this->db->where('b.store_id =',$store_id);
		$this->db->group_by('a.product_id');
		$this->db->group_by('g.variant_id');
		$this->db->group_by('h.store_id');
		$this->db->order_by('a.product_name','asc');

		if(empty($from_date))
		{
			$this->db->where('a.status',1);
		}
		else
		{
			$this->db->where('a.status',1);
            $this->db->where($wh);
			$this->db->where('b.store_id',$store_id);
		}
		$this->db->limit($perpage,$page);


		$query = $this->db->get();
		return $query->result_array();
	}	

	//Counter of unique product histor which has been affected
	public function stock_report_variant_bydate_count($from_date,$to_date,$store_id)
	{
		$this->db->select("
				a.product_name,
				a.unit,
				a.product_id,
				a.price,
				a.supplier_price,
				a.product_model,
				c.category_name,
				sum(b.quantity) as 'totalPrhcsCtn',
				e.purchase_date as purchase_date,
				g.variant_name,
				g.variant_id,
			");

		$this->db->from('product_information a');
		$this->db->join('product_purchase_details b','b.product_id = a.product_id','left');
		$this->db->join('product_category c' ,'c.category_id = a.category_id');
		$this->db->join('product_purchase e','e.purchase_id = b.purchase_id');
		$this->db->join('unit f','f.unit_id = a.unit','left');
		$this->db->join('variant g','g.variant_id = b.variant_id');
		$this->db->group_by('g.variant_id');
		$this->db->order_by('a.product_name','asc');

		if(empty($store_id))
		{
			$this->db->where(array('a.status'=>1));
		}else
		{
			$this->db->where('a.status',1);
			$this->db->where('e.purchase_date >=', $from_date);
			$this->db->where('e.purchase_date <=', $to_date);
			$this->db->where('b.store_id',$store_id);	
		}
		$query = $this->db->get();
		return $query->num_rows();
	}

	//invoice Search Item
	public function search_inovoice_item($customer_id)
	{
		$this->db->select('a.*,b.customer_name');
		$this->db->from('invoice a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->where('b.customer_id',$customer_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//POS invoice entry
	public function pos_invoice_setup($product_id){
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
			$this->db->from('invoice_details b');
			$this->db->where('b.product_id',$product_id);
			$total_sale = $this->db->get()->row();

			$data2 = (object)array(
				'total_product' 	=> ($total_purchase->total_purchase - $total_sale->total_sale), 
				'supplier_price' 	=> $product_information->supplier_price, 
				'price' 			=> $product_information->price, 
				'supplier_id' 		=> $product_information->supplier_id, 
				'tax' 				=> $product_information->tax, 
				'product_id' 		=> $product_information->product_id, 
				'product_name' 		=> $product_information->product_name, 
				'product_model' 	=> $product_information->product_model, 
				'unit' 				=> $product_information->unit, 
				);

			return $data2;
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

	//Store List to show  add pos invoice page 
	public function store_list()
	{
		$this->db->select('a.store_id,a.store_name');
		$this->db->from('store_set a');
		$this->db->order_by('a.store_name','asc');
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
	//Retrieve invoice Edit Data
	public function retrieve_invoice_editdata($invoice_id)
	{
		$this->db->select('
				a.*,
				b.customer_name,
				c.*,
				c.product_id,
				d.product_name,
				d.product_model,
				e.unit_short_name as unit,
			');

		$this->db->from('invoice a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->join('invoice_details c','c.invoice_id = a.invoice_id');
		$this->db->join('product_information d','d.product_id = c.product_id');
		$this->db->join('unit e','e.unit_id = d.unit','left');
		$this->db->where('a.invoice_id',$invoice_id);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Retrieve invoice_html_data
	public function retrieve_invoice_html_data($invoice_id)
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
		$this->db->from('invoice a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->join('invoice_details c','c.invoice_id = a.invoice_id');
		$this->db->join('product_information d','d.product_id = c.product_id');
		$this->db->join('unit e','e.unit_id = d.unit','left');
		$this->db->join('variant f','f.variant_id = c.variant_id','left');
		$this->db->where('a.invoice_id',$invoice_id);
		$this->db->order_by('d.product_name');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	// Delete invoice Item
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
	// Delete invoice Item
	public function delete_invoice($invoice_id)
	{	
		//Delete Invoice table
		$this->db->where('invoice_id',$invoice_id);
		$this->db->delete('invoice'); 
		//Delete invoice_details table
		$this->db->where('invoice_id',$invoice_id);
		$this->db->delete('invoice_details'); 	
		//Delete invoice_tax smmary table
		$this->db->where('invoice_id',$invoice_id);
		$this->db->delete('tax_collection_summary');	
		//Delete invoice_tax details table
		$this->db->where('invoice_id',$invoice_id);
		$this->db->delete('tax_collection_details'); 

		return true;
	}
	public function invoice_search_list($cat_id,$company_id)
	{
		$this->db->select('a.*,b.sub_category_name,c.category_name');
		$this->db->from('invoices a');
		$this->db->join('invoice_sub_category b','b.sub_category_id = a.sub_category_id');
		$this->db->join('invoice_category c','c.category_id = b.category_id');
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
		$this->db->from('invoice_details');
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
			onsale,
			onsale_price,
			unit.unit_short_name
			');
		$this->db->from('product_information');
		$this->db->join('unit','unit.unit_id = product_information.unit','left');
		$this->db->where(array('product_id' => $product_id,'status' => 1)); 
		$product_information = $this->db->get()->row();

		$html = "";
		if (!empty($product_information->variants)) {
			$exploded = explode(',',$product_information->variants);
			$html .="<option>".display('select_variant')."</option>";
	        foreach ($exploded as $elem) {
		        $this->db->select('*');
		        $this->db->from('variant');
		        $this->db->where('variant_id',$elem);
		        $this->db->order_by('variant_name','asc');
		        $result = $this->db->get()->row();

		        $html .="<option value=".$result->variant_id.">".$result->variant_name."</option>";
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
		
		$discount = "";
		if ($product_information->onsale == 1) {
			$discount = ($product_information->price - $product_information->onsale_price);
		}

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
			'discount' 		=> $discount, 
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
		$query = $this->db->get('invoice');	
		$result = $query->result_array();	
		$invoice_no = $result[0]['invoice_no'];
		if ($invoice_no !='') {
			$invoice_no = $invoice_no + 1;	
		}else{
			$invoice_no = 1000;
		}
		return $invoice_no;		
	}

	//Product List
	public function product_list()
	{
	$query=$this->db->select('
					a.product_id,a.product_name,a.price,a.image_thumb,a.variants,a.product_model,
					b.supplier_id,b.supplier_name,
					c.category_name,c.category_id
				')

				->from('product_information a')
				->join('supplier_information b', 'a.supplier_id = b.supplier_id','left')
				->join('product_category c','c.category_id = a.category_id','left')
				->group_by('a.product_id')
				->order_by('a.product_name','asc')
				->get();

		if ($query->num_rows() > 0) {
		 	return $query->result();	
		}
		return false;
	}
	//Category List
	public function category_list()
	{
		$this->db->select('a.category_id,a.category_name');
		$this->db->from('product_category a');
		$this->db->where('a.status',1);
		$this->db->order_by('a. category_name','asc');
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
			$this->db->or_like('product_model', $product_name, 'both');
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


	public function tax_info(){
		
 	$this->db->select('*');
    $this->db->from('tax');
    $this->db->order_by('tax_name','asc');
    $tax_information = $this->db->get()->result();

    	return $tax_information;    

	}



}