<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchases extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	//Count purchase
	public function count_purchase()
	{
		$this->db->select('a.*,b.supplier_name');
		$this->db->from('product_purchase a');
		$this->db->join('supplier_information b','b.supplier_id = a.supplier_id');
		return $query=$this->db->get()->num_rows();
	}
	//purchase List
	public function purchase_list()
	{
		$this->db->select('a.*,b.supplier_name');
		$this->db->from('product_purchase a');
		$this->db->join('supplier_information b','b.supplier_id = a.supplier_id');
		$this->db->order_by('a.purchase_date','desc');
		$this->db->order_by('purchase_id','desc');
		$this->db->limit('500');
		$query = $this->db->get();
		
		$last_query =  $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Select All Supplier List
	public function select_all_supplier()
	{
		$query = $this->db->select('*')
					->from('supplier_information')
					->where('status','1')
					->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Purchase Search  List
	public function purchase_by_search($supplier_id)
	{
		$this->db->select('a.*,b.supplier_name');
		$this->db->from('product_purchase a');
		$this->db->join('supplier_information b','b.supplier_id = a.supplier_id');
		$this->db->where('b.supplier_id',$supplier_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Purchase entry
	public function purchase_entry()
	{
		//Generator purchase id
		$purchase_id = $this->auth->generator(15);		
		$p_id 		 = $this->input->post('product_id',TRUE);
		$supplier_id = $this->input->post('supplier_id',TRUE);
		$quantity 	= $this->input->post('product_quantity',TRUE);
		$variant_id = $this->input->post('variant_id',TRUE);
		$color_variant = $this->input->post('color_variant',TRUE);
		
		// Supplier & product id relation ship checker.
		for ($i=0, $n=count($p_id); $i < $n; $i++) {
			$product_id = $p_id[$i];
			$value 		= $this->product_supplier_check($product_id,$supplier_id);
			if($value == 0){
			  	$this->session->set_userdata(array('error_message'=> display("product_and_supplier_did_not_match")));
			  	redirect(base_url('dashboard/Cpurchase'));
			}
		}

		//Variant id required check
		$result = array();
		foreach($p_id as $k => $v)
		{
		    if(empty($variant_id[$k]))
		    {
		       	$this->session->set_userdata(array('error_message'=>display('variant_is_required')));
		      	redirect('dashboard/Cpurchase');
		    }
		}

		//Add Product To Purchase Table
		$data=array(
			'purchase_id'			=>	$purchase_id,
			'invoice_no'			=>	$this->input->post('invoice_no',TRUE),
			'supplier_id'			=>	$this->input->post('supplier_id',TRUE),
			'store_id'				=>	$this->input->post('store_id',TRUE),
			'wearhouse_id'			=>	'',
			'grand_total_amount'	=>	$this->input->post('grand_total_price',TRUE),
			'purchase_date'			=>	$this->input->post('purchase_date',TRUE),
			'purchase_details'		=>	$this->input->post('purchase_details'),
			'user_id'				=>	$this->session->userdata('user_id'),
			'status'				=>	1
		);
		$this->db->insert('product_purchase',$data);
		
		//Add Product To Supplier Ledger
		$ledger=array(
			'transaction_id'		=>	$this->auth->generator(15),
			'purchase_id'			=>	$purchase_id,
			'invoice_no'			=>	$this->input->post('invoice_no',TRUE),
			'supplier_id'			=>	$this->input->post('supplier_id',TRUE),
			'amount'				=>	$this->input->post('grand_total_price',TRUE),
			'date'					=>	$this->input->post('purchase_date',TRUE),
			'description'			=>	$this->input->post('purchase_details',FALSE),
			'status'				=>	1
		);
		$this->db->insert('supplier_ledger',$ledger);
		
		//Product Purchase Details
		$rate 		= $this->input->post('product_rate',TRUE);
		$t_price 	= $this->input->post('total_price',TRUE);
		
		for ($i=0, $n=count($p_id); $i < $n; $i++) {
			$product_quantity = $quantity[$i];
			$product_rate = $rate[$i];
			$product_id = $p_id[$i];
			$total_price = $t_price[$i];
			$variant = $variant_id[$i];
			$variant_color = $color_variant[$i];
			
			$data1 = array(
				'purchase_detail_id'	=>	$this->auth->generator(15),
				'purchase_id'			=>	$purchase_id,
				'product_id'			=>	$product_id,
				'wearhouse_id'			=>	'',
				'store_id'				=>	$this->input->post('store_id',TRUE),
				'quantity'				=>	$product_quantity,
				'rate'					=>	$product_rate,
				'total_amount'			=>	$total_price,
				'variant_id'			=>	$variant,
				'variant_color'			=>	(!empty($variant_color)?$variant_color:NULL),
				'status'				=>	1
			);

			if(!empty($quantity))
			{
				$this->db->insert('product_purchase_details',$data1);
			}

				$store=array(
					'transfer_id'	=>	$this->auth->generator(15),
					'purchase_id'	=>	$purchase_id,
					'store_id'		=>	$this->input->post('store_id',TRUE),
					'product_id'	=>	$product_id,
					'variant_id'	=>	$variant,
					'variant_color'	=>	(!empty($variant_color)?$variant_color:NULL),
					'date_time'		=>	$this->input->post('purchase_date',TRUE),
					'quantity'		=>	$product_quantity,
					'status'		=>  3
				);

				if(!empty($quantity))
				{

					$this->db->insert('transfer',$store);
				}

		}


		// Woocommerce module stock update
		$woocom_stock = $this->input->post('woocom_stock',TRUE);
		if(check_module_status('woocommerce') && ($woocom_stock=='1')) {

        	$this->load->library('woocommerce/woolib/woo_lib');
        	$this->load->model('woocommerce/woo_model');
            $this->woo_lib->connection();
            $def_store = $this->woo_model->get_def_store();
            
            $woo_stock = [];
        	for ($i=0, $n=count($p_id); $i < $n; $i++) {
				$product_quantity = $quantity[$i];
				$product_id = $p_id[$i];
				$variant = $variant_id[$i];
				$fulldata = $woo_data = [];
				$product_stock = 0;
				

				$prodinfo = $this->woo_model->get_product_sync_by_local_id($product_id);

				if(!empty($prodinfo))
				{
					if($prodinfo->woo_product_type == 'variable')
					{

						$varinfo = $this->woo_model->get_variant_sync_by_local($product_id, $variant);

						if(!empty($varinfo->woo_product_id) && !empty($varinfo->woo_variant_id)){

						 	$product_stock = $this->woo_model->get_product_stock($def_store->store_id, $product_id, $variant);

								$woo_data[] = array(
							 		'id' => $varinfo->woo_variant_id,
							 		'manage_stock' => TRUE,
							 		'stock_quantity' => $product_stock,
							 		'stock_status' => (intval($product_stock)>0?'instock':'outofstock')
							 	);

							 	if(!empty($woo_data)){
									$fulldata['update'] = $woo_data;
									$woovarinfo = $this->woo_lib->post_request(array('param'=> 'products/'.$varinfo->woo_product_id.'/variations/batch'), $fulldata);
								}
						}

					}else{

						$pdef_info = $this->woo_model->get_product_variant_info($product_id);

						if(!empty($pdef_info)){

							$product_stock = $this->woo_model->get_product_stock($def_store->store_id, $product_id, $pdef_info->default_variant);

							$woo_stock[] = array(
		                        'id' => $prodinfo->woo_product_id,
		                        'manage_stock' => TRUE,
		                        'stock_quantity' => $product_stock,
		                        'stock_status' => (intval($product_stock)>0?'instock':'outofstock')
		                    );
						}
					}
				}
			}
			if(!empty($woo_stock)){ //update global stock
                $this->woo_lib->post_request(array('param'=> 'products/batch'), array('update' => $woo_stock));
            }
        }


		return true;
	}
	//Retrieve purchase Edit Data
	public function retrieve_purchase_editdata($purchase_id)
	{
		$this->db->select('a.*,b.*,c.product_id,c.product_name,c.product_model,d.supplier_id,d.supplier_name');
		$this->db->from('product_purchase a');
		$this->db->join('product_purchase_details b','b.purchase_id =a.purchase_id');
		$this->db->join('product_information c','c.product_id =b.product_id');
		$this->db->join('supplier_information d','d.supplier_id = a.supplier_id');
		$this->db->where('a.purchase_id',$purchase_id);
		$this->db->order_by('a.purchase_details','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Update Purchase
	public function update_purchase()
	{
		//Generator purchase id
		$purchase_id = $this->input->post('purchase_id',TRUE);
		
		$p_id 		 = $this->input->post('product_id',TRUE);
		$supplier_id = $this->input->post('supplier_id',TRUE);
		$variants	 = $this->input->post('variant_id',TRUE);
		$variant_colors	 = $this->input->post('color_variant',TRUE);

		//Supplier & product id relation ship checker.
		for ($i=0, $n=count($p_id); $i < $n; $i++) {
			$product_id = $p_id[$i];
			$value 		= $this->product_supplier_check($product_id,$supplier_id);
			if($value == 0){
			  	$this->session->set_userdata('error_message' , display("product_and_supplier_did_not_match"));
			  	redirect('dashboard/Cpurchase');
			}
		}

		//Variant id required check
		$result = array();
		foreach($p_id as $k => $v)
		{
		    if(empty($variants[$k]))
		    {
		       	$this->session->set_userdata(array('error_message'=>display('variant_is_required')));
		      	redirect('dashboard/Cpurchase');
		    }
		}

		//Update Product Purchase Table
		$data=array(
			'purchase_id'			=>	$purchase_id,
			'invoice_no'			=>	$this->input->post('invoice_no',TRUE),
			'supplier_id'			=>	$this->input->post('supplier_id',TRUE),
			'store_id'				=>	$this->input->post('store_id',TRUE),
			'wearhouse_id'			=>	'',
			'grand_total_amount'	=>	$this->input->post('grand_total_price',TRUE),
			'purchase_date'			=>	$this->input->post('purchase_date',TRUE),
			'purchase_details'		=>	$this->input->post('purchase_details',FALSE),
			'user_id'				=>	$this->session->userdata('user_id'),
			'status'				=>	1
		);

		$this->db->where('purchase_id',$purchase_id);
		$result = $this->db->delete('product_purchase');

		if ($result) {
			$this->db->insert('product_purchase',$data);
		}

		//Add Product To Supplier Ledger
		$ledger=array(
			'invoice_no'			=>	$this->input->post('invoice_no',TRUE),
			'supplier_id'			=>	$this->input->post('supplier_id',TRUE),
			'amount'				=>	$this->input->post('grand_total_price',TRUE),
			'date'					=>	$this->input->post('purchase_date',TRUE),
			'description'			=>	$this->input->post('purchase_details',FALSE),
			'status'				=>	1
		);
		$this->db->where('purchase_id',$purchase_id);
		$this->db->update('supplier_ledger',$ledger);

		//Delete old purchase details info
		if (!empty($purchase_id)) {
			$this->db->where('purchase_id',$purchase_id);
			$this->db->delete('product_purchase_details'); 

			//Delete transfer data from transfer
			$this->db->where('purchase_id',$purchase_id);
			$this->db->delete('transfer');
		}
		
		//Product Purchase Details
		$rate 				= $this->input->post('product_rate',TRUE);
		$quantity 			= $this->input->post('product_quantity',TRUE);
		$t_price 			= $this->input->post('total_price',TRUE);
		$purchase_detail_id = $this->input->post('purchase_detail_id',TRUE);

		for ($i=0, $n=count($p_id); $i < $n; $i++) {
			$product_quantity = $quantity[$i];
			$product_rate 	  = $rate[$i];
			$product_id 	  = $p_id[$i];
			$total_price 	  = $t_price[$i];
			$variant_id 	  = $variants[$i];
			$variant_color 	  = (!empty($variant_colors[$i])?$variant_colors[$i]:NULL);
			
			$data1 = array(
				'purchase_detail_id'	=>	$this->auth->generator(15),
				'purchase_id'			=>	$purchase_id,
				'product_id'			=>	$product_id,
				'store_id'				=>	$this->input->post('store_id',TRUE),
				'wearhouse_id'			=>	'',
				'variant_id'			=>	$variant_id,
				'variant_color'			=>	$variant_color,
				'quantity'				=>	$product_quantity,
				'rate'					=>	$product_rate,
				'total_amount'			=>	$total_price,
				'status'				=>	1
			);

			if(!empty($quantity))
			{
				$this->db->insert('product_purchase_details',$data1);
			}
				$store=array(
					'transfer_id'	=>	$this->auth->generator(15),
					'purchase_id'	=>	$purchase_id,
					'store_id'		=>	$this->input->post('store_id',TRUE),
					'product_id'	=>	$product_id,
					'variant_id'	=>	$variant_id,
					'variant_color'	=>	$variant_color,
					'date_time'		=>	$this->input->post('purchase_date',TRUE),
					'quantity'		=>	$product_quantity,
					'status'		=>  3
				);

				$this->db->insert('transfer',$store);
		}


		// Woocommerce Stock update
		$woocom_stock = $this->input->post('woocom_stock',TRUE);
		if(check_module_status('woocommerce') && ($woocom_stock=='1')) {

        	$this->load->library('woocommerce/woolib/woo_lib');
        	$this->load->model('woocommerce/woo_model');
            $this->woo_lib->connection();
            $def_store = $this->woo_model->get_def_store();
            
            $woo_stock = [];
        	for ($i=0, $n=count($p_id); $i < $n; $i++) {
				$product_quantity = $quantity[$i];
				$product_id = $p_id[$i];
				$variant = $variants[$i];
				$fulldata = $woo_data = [];
				$product_stock = 0;


				$prodinfo = $this->woo_model->get_product_sync_by_local_id($product_id);

				if(!empty($prodinfo))
				{
					if($prodinfo->woo_product_type == 'variable')
					{

						$varinfo = $this->woo_model->get_variant_sync_by_local($product_id, $variant);

						if(!empty($varinfo->woo_product_id) && !empty($varinfo->woo_variant_id)){

						 	$product_stock = $this->woo_model->get_product_stock($def_store->store_id, $product_id, $variant);

								$woo_data[] = array(
							 		'id' => $varinfo->woo_variant_id,
							 		'manage_stock' => TRUE,
							 		'stock_quantity' => $product_stock,
							 		'stock_status' => (intval($product_stock)>0?'instock':'outofstock')
							 	);

							 	if(!empty($woo_data)){
									$fulldata['update'] = $woo_data;
									$woovarinfo = $this->woo_lib->post_request(array('param'=> 'products/'.$varinfo->woo_product_id.'/variations/batch'), $fulldata);
								}
						}

					}else{

						$pdef_info = $this->woo_model->get_product_variant_info($product_id);

						if(!empty($pdef_info)){

							$product_stock = $this->woo_model->get_product_stock($def_store->store_id, $product_id, $pdef_info->default_variant);

							$woo_stock[] = array(
		                        'id' => $prodinfo->woo_product_id,
		                        'manage_stock' => TRUE,
		                        'stock_quantity' => $product_stock,
		                        'stock_status' => (intval($product_stock)>0?'instock':'outofstock')
		                    );
						}
					}
				}
			}
			if(!empty($woo_stock)){ //update global stock
                $this->woo_lib->post_request(array('param'=> 'products/batch'), array('update' => $woo_stock));
            }
        }
        
		return true;
	}

	//Get total product
	public function get_total_product($product_id){

		$this->db->select('*');
		$this->db->from('product_information');
		$this->db->where(array('product_information.product_id' => $product_id,'product_information.status' => 1)); 
		$product_information = $this->db->get()->row();

		$html = $colorhtml = "";
		if ($product_information->variants) {
			$exploded = explode(',',$product_information->variants);

			$this->db->select('*');
	        $this->db->from('variant');
	        $this->db->where_in('variant_id',$exploded);
	        $this->db->order_by('variant_name','asc');
	        $variant_list = $this->db->get()->result();
	        $var_types = array_column($variant_list, 'variant_type');


			$html .="<select id=\"variant_id\" class=\"form-control variant_id\" required=\"\" style=\"width:200px\">
	                    <option value=\"\">".display('select_variant')."</option>";
	        foreach ($variant_list as $varitem) {

	        	if($varitem->variant_type=='size'){
		        	$html .="<option value=".$varitem->variant_id.">".$varitem->variant_name."</option>";
		        }
	    	}
	    	$html .="</select>";


	    	if(in_array('color',$var_types)) {
	    		$colorhtml .="<option value=''></option>";
                foreach ($variant_list as $varitem2) {
                	if($varitem2->variant_type=='color'){
			        	$colorhtml .="<option value=".$varitem2->variant_id.">".$varitem2->variant_name."</option>";
			        }
                }
	    	}

	    }
    	

		$data2 = array( 
			'product_id' 		=> $product_information->product_id, 
			'supplier_price'    => $product_information->supplier_price, 
			'variant'    		=> $html, 
			'variant_color'    	=> $colorhtml
		);

		return $data2;
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
	// Delete purchase Item
	public function delete_purchase($purchase_id)
	{
		//Delete product_purchase table
		$this->db->where('purchase_id',$purchase_id);
		$this->db->delete('product_purchase'); 
		//Delete product_purchase_details table
		$this->db->where('purchase_id',$purchase_id);
		$this->db->delete('product_purchase_details');
		//Delete transer info table
		$this->db->where('purchase_id',$purchase_id);
		$this->db->delete('transfer');
		return true;
	}
	public function purchase_search_list($cat_id,$company_id)
	{
		$this->db->select('a.*,b.sub_category_name,c.category_name');
		$this->db->from('purchases a');
		$this->db->join('purchase_sub_category b','b.sub_category_id = a.sub_category_id');
		$this->db->join('purchase_category c','c.category_id = b.category_id');
		$this->db->where('a.sister_company_id',$company_id);
		$this->db->where('c.category_id',$cat_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Retrieve purchase_details_data
	public function purchase_details_data($purchase_id)
	{
		$this->db->select('a.*,b.*,c.*,d.product_id,d.product_name,d.product_model,f.variant_name');
		$this->db->from('product_purchase a');
		$this->db->join('supplier_information b','b.supplier_id = a.supplier_id');
		$this->db->join('product_purchase_details c','c.purchase_id = a.purchase_id');
		$this->db->join('product_information d','d.product_id = c.product_id');
		$this->db->join('variant f','f.variant_id = c.variant_id');
		$this->db->where('a.purchase_id',$purchase_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	//This function will check the product & supplier relationship.
	public function product_supplier_check($product_id,$supplier_id)
	{
	 	$this->db->select('*');
	  	$this->db->from('product_information');
	  	$this->db->where('product_id',$product_id);
	  	$this->db->where('supplier_id',$supplier_id);	
	  	$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return true;	
		}
		return 0;
	}
	//This function is used to Generate Key
	public function generator($lenth)
	{
		$number=array("A","B","C","D","E","F","G","H","I","J","K","L","N","M","O","P","Q","R","S","U","V","T","W","X","Y","Z","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","1","2","3","4","5","6","7","8","9","0");
	
		for($i=0; $i<$lenth; $i++)
		{
			$rand_value=rand(0,61);
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


	// Get variant stock info
	public function check_variant_wise_stock($product_id, $store_id, $variant_id, $variant_color = false)
	{

		$this->db->select("SUM(quantity) as totalPurchaseQnty");
		$this->db->from('transfer');
		$this->db->where('product_id',$product_id);
		$this->db->where('variant_id',$variant_id);
        if(!empty($variant_color)){
             $this->db->where('variant_color',$variant_color);
        }
		$this->db->where('store_id',$store_id);
		$purchase = $this->db->get()->row();

		$this->db->select("SUM(quantity) as totalSalesQnty");
		$this->db->from('invoice_details');
		$this->db->where('product_id',$product_id);
		$this->db->where('variant_id',$variant_id);
        if(!empty($variant_color)){
             $this->db->where('variant_color',$variant_color);
        }
		$this->db->where('store_id',$store_id);
		$sales = $this->db->get()->row();

		$stock = $purchase->totalPurchaseQnty - $sales->totalSalesQnty;
        return $stock;
	}

	// check variant wise product price
	public function check_variant_wise_price($product_id, $variant_id, $variant_color = false)
    {
        $pinfo = $this->db->select('price, onsale, onsale_price, variant_price')
                ->from('product_information')
                ->where('product_id', $product_id)
                ->get()->row();

        if($pinfo->variant_price){

            $this->db->select('price');
            $this->db->from('product_variants');
            $this->db->where('product_id', $product_id);
            $this->db->where('var_size_id', $variant_id);
            if(!empty($variant_color)){
                $this->db->where('var_color_id', $variant_color);
            }else{
                $this->db->where("var_color_id IS NULL");
            }
            $varprice = $this->db->get()->row();

            if(!empty($varprice)){
                $price_arr['price'] = $varprice->price;
                $price_arr['regular_price'] = $pinfo->price;
            }else{
                 if(!empty($pinfo->onsale) && !empty($pinfo->onsale_price)){
                    $price_arr['price'] = $pinfo->onsale_price;
                    $price_arr['regular_price'] = $pinfo->price;
                }else{
                    $price_arr['price'] = $price_arr['regular_price'] = $pinfo->price;
                }
            }


        } else{

            if(!empty($pinfo->onsale) && !empty($pinfo->onsale_price)){
                $price_arr['price'] = $pinfo->onsale_price;
                $price_arr['regular_price'] = $pinfo->price;
            }else{
                $price_arr['price'] = $price_arr['regular_price'] = $pinfo->price;
            }
        }

        return $price_arr;

    }
}