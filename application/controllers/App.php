<?php 
class App extends CI_Controller {
    
    public function __construct()
 	{
 		parent::__construct();
 		header('Content-Type: application/json');
 	}


	//Index is loading first
	public function index(){
		$json[] = array(
			'status' => "OK"
		);
		echo json_encode(array('json' => $json),JSON_UNESCAPED_UNICODE);
	}
	
    //User login
	public function login()
	{
		$email 	  = $this->input->get('email');
		$password = $this->input->get('password');

		if (empty($email) || empty($password))
		{
			$json[] = array(
				'error' => "Please fill up all required field !"
			);
			echo json_encode(array('user_info' => $json),JSON_UNESCAPED_UNICODE);
		}else{
			$password = md5("gef".$password);
	        $this->db->where(array('customer_email'=>$email,'password'=>$password,'status'=>1));
			$query    = $this->db->get('customer_information');
			$result   =  $query->row();

			if (count($result) > 0)
			{
				$json[] = array(
					'auth-status' => 'true',
					'user_id'	  => $result->customer_id
				);
				echo $json_encode = json_encode(array('user_info' => $json),JSON_UNESCAPED_UNICODE);
			}else{
				$json[] = array(
					'auth-status' => 'false',
					'user_id'	  => (!empty($result->customer_id)?$result->customer_id:null)
				);
				echo $json_encode = json_encode(array('user_info' => $json),JSON_UNESCAPED_UNICODE);
			}
		}
	}

	//User Registration
	public function registration(){
		$full_name  = $this->input->get('full_name');
		$email 		= $this->input->get('email');
		$password 	= $this->input->get('password');

		if (empty($full_name) || empty($email) || empty($password)) {
			$json[] = array(
				'error' => "Please fillup all required field !", 
			);
			echo $json_encode = json_encode(array('registration_info' => $json),JSON_UNESCAPED_UNICODE);
		}else{
			$check_email = $this->test_input($email);
			if (filter_var($check_email, FILTER_VALIDATE_EMAIL)) {
				//Email existing check
				$customer = $this->db->select('*')
						->from('customer_information')
						->where('customer_email',$email)
						->get()
						->num_rows();

				if ($customer > 0) {
					$json[] = array(
						'error'  => 'Email already exists !'
					);
					echo $json_encode = json_encode(array('registration_info' => $json),JSON_UNESCAPED_UNICODE);
				}else{
					$data = array(
						'customer_id' 	=> $this->generator(15),
						'customer_name' => $full_name,
						'first_name' => $full_name,
						'customer_email'=> $email,
						'password' 		=> md5("gef".$password),
						'status' 		=> 1,
					);
					$result = $this->db->insert('customer_information',$data);
					if ($result) {
						$json[] = array(
							'user_id' => $data['customer_id'], 
							'status'  => 'true'
						);
						echo $json_encode = json_encode(array('registration_info' => $json),JSON_UNESCAPED_UNICODE);
					}
				}
			}else{
				$json[] = array(
					'error' => "Email is not validate!", 
				);
				echo $json_encode = json_encode(array('registration_info' => $json),JSON_UNESCAPED_UNICODE);
			}
		}
	}

	//Email testing
	public function test_input($data) {
	  	$data = trim($data);
	  	$data = stripslashes($data);
	  	$data = htmlspecialchars($data);
	  	return $data;
	}
	// Show all category upto 2 level
	public function categorylist(){

		$main_cats = $this->db->query('Select category_id as id,category_name as name,cat_favicon as image, cat_image as big_image from product_category WHERE cat_type = 1 AND status=1')->result_array();

		$full_cats = array();

		if(!empty($main_cats)){

			$subcats_list = $this->db->query('Select category_id as id,category_name as name,cat_favicon as image, cat_image as big_image , parent_category_id from product_category WHERE cat_type = 2 AND status=1')->result_array();

			foreach ($main_cats as $maincat) {
				$sub_cat1_arr = array();

					foreach ($subcats_list as $subcat1) {

							$sub_cat2_arr = array();
							foreach ($subcats_list as $subcat2) {
								if(strtoupper($subcat2['parent_category_id'])  == strtoupper($subcat1['id'])) {
									$sub_cat2_arr[] = $subcat2;
								}
							}
							$subcat1['categoriesleveltwo'] = $sub_cat2_arr;

							if(strtoupper($subcat1['parent_category_id'])  == strtoupper($maincat['id'])) {
									$sub_cat1_arr[] = $subcat1;
								}

					}
					$maincat['categorieslevelone'] = $sub_cat1_arr;
					$full_cats[] = $maincat;

			}

		}

		echo json_encode(array('category_info' => $full_cats),JSON_UNESCAPED_UNICODE);
	}

	//Return product list category wise
	public function productlist(){
		$category_id = $this->input->get('category');

		if (!empty($category_id)) {

			$all_cat_ids = array($category_id);

			$child_cats = $this->db->select('category_id')->where('parent_category_id', $category_id)->get('product_category')->result_array();

			if(!empty($child_cats)){
				$child_cat_ids = array_column($child_cats, 'category_id');
				$all_cat_ids = array_merge($all_cat_ids, $child_cat_ids);
			}
			$productlist = $this->db->select('*')
					->from('product_information')
					->where_in('category_id',$all_cat_ids)
					->limit('50')
					->order_by('id','desc')
					->get()
					->result();
		}else{
			$productlist = $this->db->select('*')
					->from('product_information')
					->limit('50')
					->order_by('id','desc')
					->get()
					->result();
		}

		if ($productlist) {
			foreach ($productlist as $product) {

				$product_rating = $this->rating_calculator($product->product_id);
				
				$json[] = array(
					'id' 			=> $product->product_id,
					'name'			=> (!empty($product->product_name)?$product->product_name:null),
					'cat_id'		=> (!empty($product->category_id)?$product->category_id:null),
					'price'			=> (!empty($product->price)?$product->price:null),
					'model'			=> (!empty($product->product_model)?$product->product_model:null),
					'image_thumb'	=> (!empty($product->image_thumb)?$product->image_thumb:null),
					'product_details'	=> (!empty($product->product_details)?$product->product_details:null),
					'description'	=> (!empty($product->description)?$product->description:null),
					'variants'		=> (!empty($product->variants)?$product->variants:null),
					'onsale'		=> (!empty($product->onsale)?$product->onsale:null),
					'best_sale'		=> (!empty($product->best_sale)?$product->best_sale:null),
					'onsale_price'	=> (!empty($product->onsale_price)?$product->onsale_price:null),
					'image_large_details'	=> (!empty($product->image_large_details)?$product->image_large_details:null),
					'rating'		=> (!empty($product_rating)?$product_rating:0)
				);
			}
			echo $json_encode = json_encode(array('product_info' => $json),JSON_UNESCAPED_UNICODE);
		}else{
			$json[] = array(
				'error' => "Product not found !", 
			);
			echo $json_encode = json_encode(array('product_info' => $json),JSON_UNESCAPED_UNICODE);
		}
	}

	//Customer info
	public function customer_info($customer_id=null){
		return $this->db->select('customer_name')
				->from('customer_information')
				->where('customer_id',$customer_id)
				->get()
				->row();
	}

	//Review list
	public function review_list(){
		$product_id  = $this->input->get('product_id');
		$review_list = $this->db->select('*')
						->from('product_review')
						->where('product_id',$product_id)
						->get()
						->result();
		if ($review_list) {
			foreach ($review_list as $review) {
				$review_name = $this->customer_info($review->reviewer_id);
				$json[] = array(
						'product_review_id' => $review->product_review_id,
						'product_id' 		=> $review->product_id,
						'reviewer_id' 		=> $review->reviewer_id,
						'reviewer_name' 	=> (!empty($review_name)?$review_name->customer_name:null),
						'comments' 			=> $review->comments,
						'rate' 				=> $review->rate,
				);
			}
			echo $json_encode = json_encode(array('review_info' => $json),JSON_UNESCAPED_UNICODE);
		}else{
			$json[] = array(
				'error' => "No review found!", 
			);
			echo $json_encode = json_encode(array('review_info' => $json),JSON_UNESCAPED_UNICODE);
		}
	}

	//Review entry
	public function review_entry(){

		$get_review_data = file_get_contents('php://input');
        $review_info   = json_decode($get_review_data);
        if ($review_info) {
	        foreach ($review_info as $reviewInfo) {

	        	$data = array(
	        		'product_review_id'=> $this->generator(15),
	        		'product_id' 	=> $reviewInfo->product_id,
	        		'reviewer_id' 	=> $reviewInfo->user_id,
	        		'comments' 		=> $reviewInfo->comments,
	        		'rate' 			=> $reviewInfo->rate,
	        		'status' 		=> '1',
	        	);

	        	$result = $this->db->select('*')
			        			->from('product_review')
			        			->where('product_id',$data['product_id'])
			        			->where('reviewer_id',$data['reviewer_id'])
			        			->get()
			        			->num_rows();

			    if ($result > 0) {
			     	$json[] = array(
						'status' => "false", 
						'error' => "You are already reviwed !", 
					);
					echo $json_encode = json_encode(array('review_info' => $json),JSON_UNESCAPED_UNICODE);
			    }else{
			    	$result = $this->db->insert('product_review',$data);
			    	if ($result) {
				    	$json[] = array(
							'status' => "true", 
							'success' => "You are reviewed successfully.", 
						);
						echo $json_encode = json_encode(array('review_info' => $json),JSON_UNESCAPED_UNICODE);
			    	}
			    }

	        }
	    }
	}

	//Rating calculator
	public function rating_calculator($product_id=null){
		
           $result = $this->db->select('sum(rate) as rates')
                                ->from('product_review')
                                ->where('product_id',$product_id)
                                ->get()
                                ->row();

            $rater = $this->db->select('rate')
                                ->from('product_review')
                                ->where('product_id',$product_id)
                                ->get()
                                ->num_rows();
            if ($rater) {
            	return $total_rate = $result->rates/$rater;
            }else{
            	return 0;
            }
	}

	//Slider list
	public function slider_list(){
		$this->db->select('*');
		$this->db->from('slider');
		$this->db->where('status',1);
		$this->db->order_by('slider_position','asc');
		$query = $this->db->get();

		if($query->result()){
			foreach ($query->result() as $slider) {
				$json[] = array(
					'slider_id' 	 => $slider->slider_id, 
					'slider_link' 	 => $slider->slider_link, 
					'slider_image'   => base_url().$slider->slider_image, 
					'slider_position'=> $slider->slider_position, 
					'slider_category'=> $slider->slider_category, 
					'status'=> $slider->status
				);
			}
			echo $json_encode = json_encode(array('slider_info' => $json),JSON_UNESCAPED_UNICODE);
		}else{
			$json[] = array(
					'status' => "false", 
					'error' => "Slider not found !", 
				);
			echo $json_encode = json_encode(array('slider_info' => $json),JSON_UNESCAPED_UNICODE);
		}
	}

	//Best sale product list
	public function best_sale(){

			$productlist = $this->db->select('*')
									->from('product_information')
									->where('best_sale',1)
									->order_by('id','desc')
									->get()
									->result();

			if ($productlist) {
				foreach ($productlist as $product) {
					
					$product_rating = $this->rating_calculator($product->product_id);
					$json[] = array(
						'id' 			=> $product->product_id,
						'name'			=> (!empty($product->product_name)?$product->product_name:null),
						'cat_id'		=> (!empty($product->category_id)?$product->category_id:null),
						'price'			=> (!empty($product->price)?$product->price:null),
						'model'			=> (!empty($product->product_model)?$product->product_model:null),
						'image_thumb'	=> (!empty($product->image_thumb)?$product->image_thumb:null),
						'product_details'	=> (!empty($product->product_details)?$product->product_details:null),
						'description'	=> (!empty($product->description)?$product->description:null),
						'variants'		=> (!empty($product->variants)?$product->variants:null),
						'onsale'		=> (!empty($product->onsale)?$product->onsale:null),
						'best_sale'		=> (!empty($product->best_sale)?$product->best_sale:null),
						'onsale_price'	=> (!empty($product->onsale_price)?$product->onsale_price:null),
						'image_large_details'	=> (!empty($product->image_large_details)?$product->image_large_details:null),
						'rating'	=> (!empty($product_rating)?$product_rating:0)
					);
				}
				echo $json_encode = json_encode(array('product_info' => $json),JSON_UNESCAPED_UNICODE);
			}else{
				$json[] = array(
					'error' => "Product not found !", 
				);
				echo $json_encode = json_encode(array('product_info' => $json),JSON_UNESCAPED_UNICODE);
			}

	}

	//Search product list
	public function search(){
		$keyword = $this->input->get('keyword');
		if (!empty($keyword)) {
			$searchlist = $this->db->select('*')
					->from('product_information')
					->like('product_name',$keyword)
					->or_like('product_model',$keyword)
					->get()
					->result();

			if ($searchlist) {
				foreach ($searchlist as $search) {
					$product_rating = $this->rating_calculator($search->product_id);
					$json[] = array(
						'id' 			=> $search->product_id,
						'name'			=> (!empty($search->product_name)?$search->product_name:null),
						'cat_id'		=> (!empty($search->category_id)?$search->category_id:null),
						'price'			=> (!empty($search->price)?$search->price:null),
						'model'			=> (!empty($search->product_model)?$search->product_model:null),
						'image_thumb'	=> (!empty($search->image_thumb)?$search->image_thumb:null),
						'product_details'	=> (!empty($search->product_details)?$search->product_details:null),
						'description'	=> (!empty($search->description)?$search->description:null),
						'variants'		=> (!empty($search->variants)?$search->variants:null),
						'onsale'		=> (!empty($search->onsale)?$search->onsale:null),
						'onsale_price'	=> (!empty($search->onsale_price)?$search->onsale_price:null),
						'image_large_details'	=> (!empty($search->image_large_details)?$search->image_large_details:null),
						'rating'		=> (!empty($product_rating)?$product_rating:0),
					);
				}
				echo $json_encode = json_encode(array('product_info' => $json),JSON_UNESCAPED_UNICODE);
			}else{
				$json[] = array(
					'error' => "Product not found !", 
				);
				echo $json_encode = json_encode(array('product_info' => $json),JSON_UNESCAPED_UNICODE);
			}
		}else{
			$json[] = array(
					'error' => "Please enter search keyword.", 
				);
			echo $json_encode = json_encode(array('product_info' => $json),JSON_UNESCAPED_UNICODE);
		}
	}

	//Variant name
	public function variant(){
		$variant_id = $this->input->get('variant_id');
		$result = $this->db->select('*')
				->from('variant')
				->where('variant_id',$variant_id)
				->get()
				->row();

		if($result){
			$json[] = array(
					'variant_name' => $result->variant_name, 
					'variant_id'   => $result->variant_id, 
				);
			echo $json_encode = json_encode(array('variant_info' => $json),JSON_UNESCAPED_UNICODE);
		}else{
			$json[] = array(
					'error' => "Variant not found !", 
				);
			echo $json_encode = json_encode(array('variant_info' => $json),JSON_UNESCAPED_UNICODE);
		}
	}

	//Product stock check
	public function stock(){
		$variant_id = $this->input->get('variant_id');
		$product_id = $this->input->get('product_id');

		if (empty($variant_id) || empty($product_id)) {
			$json[] = array(
					'error' => "Please fillup all required field !", 
				);
			echo $json_encode = json_encode(array('stock_info' => $json),JSON_UNESCAPED_UNICODE);
		}else{

			$store = $this->db->select('*')
					->from('store_set')
					->where('default_status','1')
					->get()
					->row();
			
			if ($store) {

				$this->db->select("
					b.*,
					sum(b.quantity) as totalPrhcsCtn
				");

				$this->db->from('product_purchase_details b');
				$this->db->where('b.store_id', $store->store_id);
				$this->db->where('b.variant_id',$variant_id);
				$this->db->where('b.product_id',$product_id);
				$query = $this->db->get();
				$purchase_details = $query->result_array();

				if ($purchase_details) {
					foreach ($purchase_details as $purchase) {

						$sales = $this->db->select("
								sum(quantity) as totalSalesQnty,
							")
									->from('invoice_details')
									->where('product_id',$purchase['product_id'])
									->where('variant_id',$purchase['variant_id'])
									->where('store_id',$purchase['store_id'])
									->get()
									->row();
						
						$stock_info = ($purchase['totalPrhcsCtn']-$sales->totalSalesQnty);
					}

					if ($stock_info > 0) {
						$json[] = array(
							'status' => 'true', 
							'stock'  => $stock_info, 
						);
						echo $json_encode = json_encode(array('stock_info' => $json),JSON_UNESCAPED_UNICODE);
					}else{
						$json[] = array(
							'status' => 'false', 
							'stock'  => '0', 
						);
						echo $json_encode = json_encode(array('stock_info' => $json),JSON_UNESCAPED_UNICODE);
					}
				}else{
					$json[] = array(
						'status' => 'false', 
						'stock'  => '0', 
					);
					echo $json_encode = json_encode(array('stock_info' => $json),JSON_UNESCAPED_UNICODE);
				}

			}else{
				$json[] = array(
					'error' => "Please set default store !", 
				);
				echo $json_encode = json_encode(array('stock_info' => $json),JSON_UNESCAPED_UNICODE);
			}
		}
	}

	//User information view
	public function user_info(){
		$user_id = $this->input->get('user_id');

		if ($user_id) {
			$customer = $this->db->select('*')
							->from('customer_information')
							->where('customer_id',$user_id)
							->get()
							->row();
			if ($customer) {

				$json[] = array(
					'customer_id' 	=> $customer->customer_id,
					'name' 			=> $customer->customer_name,
					'first_name' 	=> $customer->first_name,
					'last_name' 	=> $customer->last_name,
					'email' 		=> $customer->customer_email,
					'address_1' 	=> $customer->customer_address_1,
					'address_2' 	=> $customer->customer_address_2,
					'city' 			=> $customer->city,
					'state' 		=> $customer->state,
					'country' 		=> $customer->country,
					'zip' 			=> $customer->zip,
					'mobile' 		=> $customer->customer_mobile,
					'image' 		=> $customer->image,
					'company' 		=> $customer->company,
					'password' 		=> $customer->password,
				);
				echo $json_encode = json_encode(array('user_info' => $json),JSON_UNESCAPED_UNICODE);
			}else{
				$json[] = array(
					'error' => "User not found !", 
				);
				echo $json_encode = json_encode(array('user_info' => $json),JSON_UNESCAPED_UNICODE);
			}
		}else{
			$json[] = array(
				'error' => "Please enter user ID !", 
			);
			echo $json_encode = json_encode(array('user_info' => $json),JSON_UNESCAPED_UNICODE);
		}
	}

	//User information update
	public function user_update(){
		$customer_id = $this->input->get('user_id');
		$full_name   = $this->input->get('full_name');
		$first_name  = $this->input->get('first_name'); 
		$last_name   = $this->input->get('last_name'); 
		$email   	 = $this->input->get('email'); 
		$address_1   = $this->input->get('address_1'); 
		$address_2   = $this->input->get('address_2'); 
		$city   	 = $this->input->get('city'); 
		$state   	 = $this->input->get('state'); 
		$country_id  = $this->input->get('country'); 
		$zip     	 = $this->input->get('zip'); 
		$mobile      = $this->input->get('mobile'); 
		$image       = $this->input->get('image'); 
		$company     = $this->input->get('company'); 
		$password    = $this->input->get('password');
		$old_password= $this->input->get('old_password');

		if ($customer_id) {

			$country_info = $this->db->select('*')
								->from('countries')
								->where('id',$country_id)
								->get()
								->row();

			$valid_user = $this->db->select('*')
							->from('customer_information')
							->where('customer_id',$customer_id)
							->where('password',$old_password)
							->get()
							->num_rows();
			if ($valid_user > 0) {

				$customer_info = array(
					'customer_name' 	=> $full_name, 
					'first_name'		=> $first_name, 
					'last_name' 		=> $last_name, 
					'customer_email' 	=> $email, 
					'customer_short_address' => $city.','.$state.','.(!empty($country_info->name)?$country_info->name:null).','.$zip, 
					'customer_address_1'=> $address_1, 
					'customer_address_2'=> $address_2, 
					'city' 				=> $city, 
					'state' 			=> $state, 
					'country' 			=> (!empty($country_id)?$country_id:null), 
					'zip' 				=> $zip, 
					'customer_mobile' 	=> $mobile, 
					'image' 			=> $image, 
					'company' 			=> $company, 
					'password' 			=> (!empty($password)?md5("gef".$password):$old_password), 
				);

				$this->db->where('customer_id',$customer_id);
				$result = $this->db->update('customer_information',$customer_info);
				if ($result) {
					$json[] = array(
						'status'  => "true", 
						'success' => "User information update successfully !", 
					);
					echo $json_encode = json_encode(array('user_info' => $json),JSON_UNESCAPED_UNICODE);
				}else{
					$json[] = array(
						'status' => "false", 
						'error'  => "User information not updated !", 
					);
					echo $json_encode = json_encode(array('user_info' => $json),JSON_UNESCAPED_UNICODE);
				}
			}else{
				$json[] = array(
						'status' => "false", 
						'error'  => "Old password is not correct !", 
					);
				echo $json_encode = json_encode(array('user_info' => $json),JSON_UNESCAPED_UNICODE);
			}
		}
	}

	//Deleviry method list
	public function shipping_list(){
		$deleviry_info = $this->db->select('*')
				->from('shipping_method')
				->get()
				->result();

		if ($deleviry_info) {
			foreach ($deleviry_info as $delivery) {
				$json[] = array(
					'id' 		=> $delivery->method_id,
					'name'		=> $delivery->method_name,
					'details'	=> $delivery->details,
					'charge_amount'	=> $delivery->charge_amount,
					'position'	=> $delivery->position,
				);
			}
			echo $json_encode = json_encode(array('deleviry_info' => $json),JSON_UNESCAPED_UNICODE);
		}else{
			$json[] = array(
					'status' => "false", 
					'error'  => "Delivery method not found !", 
				);
			echo $json_encode = json_encode(array('deleviry_info' => $json),JSON_UNESCAPED_UNICODE);
		}
	}

	//Wishlist info
	public function wishlist(){
		$user_id 	= $this->input->get('user_id');
		$product_id = $this->input->get('product_id');


		if (!empty($user_id) && !empty($product_id)) {

			$result = $this->db->select('*')
					->from('wishlist')
					->where('user_id',$user_id)
					->where('product_id',$product_id)
					->get()
					->num_rows();

			if ($result >0 ) {
				$json[] = array(
					'status'    => 'false', 
					'error'   => 'Product already added to wishlist !', 
				);
				echo $json_encode = json_encode(array('wishlist_info' => $json),JSON_UNESCAPED_UNICODE);
			}else{
				$data = array(
					'wishlist_id' => $this->generator('10'), 
					'user_id' => $user_id, 
					'product_id' => $product_id, 
				);
				$wishlist = $this->db->insert('wishlist',$data);
				if ($wishlist) {
					$json[] = array(
						'status'    => 'true', 
						'success'   => 'Product added to wishlist.', 
					);
					echo $json_encode = json_encode(array('wishlist_info' => $json),JSON_UNESCAPED_UNICODE);
				}else{
					$json[] = array(
						'status' => "false", 
						'error'  => "Wishlist not found !", 
					);
					echo $json_encode = json_encode(array('wishlist_info' => $json),JSON_UNESCAPED_UNICODE);
				}
			}
		}elseif (!empty($user_id)) {

			$wishlist = $this->db->select('a.*,b.*')
							->from('wishlist a')
							->join('product_information b','a.product_id = b.product_id')
							->where('a.user_id',$user_id)
							->get()
							->result();

			if ($wishlist) {
				foreach ($wishlist as $list) {
					
				    $product_rating = $this->rating_calculator( $list->product_id);
					$json[] = array(
						'wishlist_id' => $list->wishlist_id, 
						'product_id'  => $list->product_id, 
						'user_id'     => $list->user_id, 
						'name'		  => (!empty($list->product_name)?$list->product_name:null),
						'cat_id'	  => (!empty($list->category_id)?$list->category_id:null),
						'price'		  => (!empty($list->price)?$list->price:null),
						'model'		  => (!empty($list->product_model)?$list->product_model:null),
						'image_thumb' => (!empty($list->image_thumb)?$list->image_thumb:null),
						'product_details' => (!empty($list->product_details)?$list->product_details:null),
						'description' => (!empty($list->description)?$list->description:null),
						'variants'	  => (!empty($list->variants)?$list->variants:null),
						'onsale'	  => (!empty($list->onsale)?$list->onsale:null),
						'onsale_price'=> (!empty($list->onsale_price)?$list->onsale_price:null),
						'image_large_details'	=> (!empty($list->image_large_details)?$list->image_large_details:null),
						'rating'	=> (!empty($product_rating)?$product_rating:0),
					);
				}
				echo $json_encode = json_encode(array('wishlist_info' => $json),JSON_UNESCAPED_UNICODE);
			}else{
				$json[] = array(
					'status' => "false", 
					'error'  => "Wishlist not found !", 
				);
				echo $json_encode = json_encode(array('wishlist_info' => $json),JSON_UNESCAPED_UNICODE);
			}
		}else{
			$wishlist = $this->db->select('*')
							->from('wishlist')
							->get()
							->result();
			if ($wishlist) {
				foreach ($wishlist as $list) {
					$json[] = array(
						'wishlist_id' => $list->wishlist_id, 
						'product_id'  => $list->product_id, 
						'user_id'     => $list->user_id, 
					);
				}
				echo $json_encode = json_encode(array('wishlist_info' => $json),JSON_UNESCAPED_UNICODE);
			}else{
				$json[] = array(
					'status' => "false", 
					'error'  => "Wishlist not found !", 
				);
				echo $json_encode = json_encode(array('wishlist_info' => $json),JSON_UNESCAPED_UNICODE);
			}
		}

	}

	//Wishlist remove/delete
	public function wishlist_remove(){
		$wishlist_id = $this->input->get('wishlist_id');
		if ($wishlist_id) {
			$result = $this->db->where('wishlist_id',$wishlist_id)
					->delete('wishlist');
			if ($result) {
				$json[] = array(
					'status' => "true", 
					'success'=> "Wishlist delete successfully.", 
				);
				echo $json_encode = json_encode(array('wishlist_info' => $json),JSON_UNESCAPED_UNICODE);
			}else{
				$json[] = array(
					'status' => "false", 
					'error'  => "Wishlist not delete !", 
				);
				echo $json_encode = json_encode(array('wishlist_info' => $json),JSON_UNESCAPED_UNICODE);
			}
		}
	}

	//County list
	public function country_list(){
		$country_list = $this->db->select('*')
								->from('countries')
								->get()
								->result();
		if ($country_list) {
			foreach ($country_list as $country) {
				$json[] = array(
					'id' 		=> $country->id, 
					'sortname'  => $country->sortname, 
					'name'     	=> $country->name, 
					'phonecode' => $country->phonecode, 
				);
			}
			echo $json_encode = json_encode(array('country_info' => $json),JSON_UNESCAPED_UNICODE);
		}else{
			$json[] = array(
					'status' => "false", 
					'error'  => "Country not found !", 
				);
			echo $json_encode = json_encode(array('country_info' => $json),JSON_UNESCAPED_UNICODE);
		}
	}

	//County via id
	public function country_info(){
	    
	    $id = $this->input->get('id');
	    
		$country_list = $this->db->select('*')
								->from('countries')
								->where('id',$id)
								->get()
								->result();
		if ($country_list) {
			foreach ($country_list as $country) {
				$json[] = array(
					'id' 		=> $country->id, 
					'sortname'  => $country->sortname, 
					'name'     	=> $country->name, 
					'phonecode' => $country->phonecode, 
				);
			}
			echo $json_encode = json_encode(array('country_info' => $json),JSON_UNESCAPED_UNICODE);
		}else{
			$json[] = array(
					'status' => "false", 
					'error'  => "Country not found !", 
				);
			echo $json_encode = json_encode(array('country_info' => $json),JSON_UNESCAPED_UNICODE);
		}
	}

	//State list
	public function state_list(){
		$country_id = $this->input->get('country_id');

		$state_list = $this->db->select('*')
								->from('states')
								->where('country_id',$country_id)
								->get()
								->result();

		if ($state_list) {
			foreach ($state_list as $state) {
				$json[] = array(
					'id' 		 => $state->id, 
					'name'  	 => $state->name, 
					'country_id' => $state->country_id, 
				);
			}
			echo $json_encode = json_encode(array('state_info' => $json),JSON_UNESCAPED_UNICODE);
		}else{
			$json[] = array(
					'status' => "false", 
					'error'  => "State not found !", 
				);
			echo $json_encode = json_encode(array('state_info' => $json),JSON_UNESCAPED_UNICODE);
		}
	}

	//Get Supplier rate of a product
	public function supplier_rate($product_id)
	{
		$this->db->select('supplier_price');
		$this->db->from('product_information');
		$this->db->where(array('product_id' => $product_id)); 
		$query = $this->db->get();
		return $query->row();
	}

	//Checkout process
	public function checkout(){

		$get_order_data = file_get_contents('php://input');
        $order_info = json_decode($get_order_data);

		if ($order_info) {
			$order_id 	  =  $this->generator(15);

			// Select country from country table
			$country_info = $this->db->select('*')
							->from('countries')
							->where('id',$order_info->shippingInfo->country)
							->get()
							->row();

			// Shipping info entry
			$ship_info = array(
				'customer_id' 	=> $order_info->orderInfo->userId, 
				'order_id'    	=> $order_id, 
				'customer_name' => $order_info->shippingInfo->fullname, 
				'customer_short_address'   => $order_info->shippingInfo->city.",".$order_info->shippingInfo->state.",".$country_info->name.",".$order_info->shippingInfo->zip, 
				'customer_address_1'   => $order_info->shippingInfo->Address, 
				'customer_mobile'      => $order_info->shippingInfo->phone, 
				'customer_email'=> $order_info->shippingInfo->email, 
				'city'   		=> $order_info->shippingInfo->city, 
				'state'   		=> $order_info->shippingInfo->state, 
				'country'  		=> $order_info->shippingInfo->country, 
				'zip'   		=> $order_info->shippingInfo->zip, 
				'company'   	=> $order_info->shippingInfo->company, 
			);

			if ($order_info->orderInfo->shippingBillingStatus == 1) {
				//Update billing info
				$this->db->set('customer_name',$ship_info["customer_name"])
						->set('customer_short_address',$ship_info["customer_short_address"])
						->set('customer_address_1',$ship_info["customer_address_1"])
						->set('customer_mobile',$ship_info["customer_mobile"])
						->set('customer_email',$ship_info["customer_email"])
						->set('city',$ship_info["city"])
						->set('state',$ship_info["state"])
						->set('country',$ship_info["country"])
						->set('zip',$ship_info["zip"])
						->set('company',$ship_info["company"])
						->where('customer_id',$order_info->orderInfo->userId)
						->update('customer_information');

				$customer_info = $this->db->select('*')
						->from('shipping_info')
						->where('customer_id',$order_info->orderInfo->userId)
						->get()
						->num_rows();
				if ($customer_info > 0) {
					$this->db->where('customer_id',$order_info->orderInfo->userId)
							->update('shipping_info',$ship_info);
				}else{
					$this->db->insert('shipping_info',$ship_info);
				}
				
			}else{

				// Billing info entry
				$billing_country = $this->db->select('*')
							->from('countries')
							->where('id',$order_info->billingInfo->country)
							->get()
							->row();

				$bill_info = array(
					'customer_id' 	=> $order_info->orderInfo->userId, 
					'order_id'    	=> $order_id, 
					'customer_name' => $order_info->billingInfo->fullname, 
					'customer_short_address'   => $order_info->billingInfo->city.",".$order_info->billingInfo->state.",".$billing_country->name.",".$order_info->billingInfo->zip, 
					'customer_address_1'   => $order_info->billingInfo->Address, 
					'customer_mobile'      => $order_info->billingInfo->phone, 
					'customer_email'=> $order_info->billingInfo->email, 
					'city'   		=> $order_info->billingInfo->city, 
					'state'   		=> $order_info->billingInfo->state, 
					'country'  		=> $order_info->billingInfo->country, 
					'zip'   		=> $order_info->billingInfo->zip, 
					'company'   	=> $order_info->billingInfo->company, 
				);

				$this->db->set('customer_name',$bill_info["customer_name"])
						->set('customer_short_address',$bill_info["customer_short_address"])
						->set('customer_address_1',$bill_info["customer_address_1"])
						->set('customer_mobile',$bill_info["customer_mobile"])
						->set('customer_email',$bill_info["customer_email"])
						->set('city',$bill_info["city"])
						->set('state',$bill_info["state"])
						->set('country',$bill_info["country"])
						->set('zip',$bill_info["zip"])
						->set('company',$bill_info["company"])
						->where('customer_id',$order_info->orderInfo->userId)
						->update('customer_information');

				$customer_info = $this->db->select('*')
						->from('shipping_info')
						->where('customer_id',$order_info->orderInfo->userId)
						->get()
						->num_rows();
				if ($customer_info > 0) {
					$this->db->where('customer_id',$order_info->orderInfo->userId)
							->update('shipping_info',$ship_info);
				}else{
					$this->db->insert('shipping_info',$ship_info);
				}
			}

			$paid_amount = 0;
			$due_amount  = 0;

			if ($order_info->orderInfo->paidStatus == 1) {
				$paid_amount = $order_info->orderInfo->totalAmount;
			}else{
				$due_amount = $order_info->orderInfo->totalAmount;
			}

			//For order entry
			$data = array(
				'order_id'			=>	$order_id,
				'customer_id'		=>	$order_info->orderInfo->userId,
				'date'				=>	date('d-m-Y'),
				'total_amount'		=>	$order_info->orderInfo->totalAmount,
				'order'				=>	$this->number_generator_order(),
				'total_discount' 	=> 	$order_info->orderInfo->totalDiscount,
				'service_charge' 	=> 	$order_info->orderInfo->serviceCharge,
				'store_id'			=>	$this->default_store(),
				'details'			=>	$order_info->orderInfo->details,
				'paid_amount'		=>	$paid_amount,
				'due_amount'		=>	$due_amount,
				'status'			=>	1
			);
			$this->db->insert('order',$data);

			//Order details
			if ($order_info->orderInfo->cartItems) {
				foreach ($order_info->orderInfo->cartItems as $order) {

					$product_id 	  	= 	$order->cartItemProductId;
					$variant_id 	  	= 	$order->cartItemProductVariantId;
					$quantity 			= 	$order->cartItemProductQuantity;
					$product_rate 	 	= 	$order->cartItemProductPrice;
					$total_price 	 	= 	$order->cartItemTotalPrice;
					$discount 	  	 	= 	$order->cartItemDiscountPerProduct;
					$supplier_rate    	= 	$this->supplier_rate($product_id);

					//For order details entry
					$order_details = array(
						'order_details_id'	=> 	$this->generator(15),
						'order_id'			=>	$order_id,
						'product_id'		=>	$product_id,
						'variant_id'		=>	$variant_id,
						'store_id'			=>	$this->default_store(),
						'quantity'			=>	$quantity,
						'rate'				=>	$product_rate,
						'supplier_rate'     =>	$supplier_rate->supplier_price,
						'total_price'       =>	$total_price,
						'discount'          =>	$discount,
						'status'			=>	1
					);

					if(!empty($quantity))
					{
						$result = $this->db->select('*')
											->from('order_details')
											->where('order_id',$order_id)
											->where('product_id',$product_id)
											->where('variant_id',$variant_id)
											->get()
											->num_rows();
						if ($result > 0) {
							$this->db->set('quantity', 'quantity+'.$quantity, FALSE);
							$this->db->set('total_price', 'total_price+'.$total_price, FALSE);
							$this->db->where('order_id', $order_id);
							$this->db->where('product_id', $product_id);
							$this->db->where('variant_id', $variant_id);
							$this->db->update('order_details');
						}else{
							$this->db->insert('order_details',$order_details);
						}
					}

					$cgst_tax = $this->calculate_cgst_tax($product_id,$product_rate,$order_id,$quantity,$variant_id);
					$sgst_tax = $this->calculate_sgst_tax($product_id,$product_rate,$order_id,$quantity,$variant_id);
					$igst_tax = $this->calculate_igst_tax($product_id,$product_rate,$order_id,$quantity,$variant_id);
				}
			}

			//Send invoice email to customer
			$this->load->model('dashboard/Orders');
			$this->load->model('dashboard/Soft_settings');
			$this->load->library('dashboard/occational');
			$order_detail = $this->Orders->retrieve_order_html_data($order_id);

			$subTotal_quantity 	= 0;
			$subTotal_cartoon 	= 0;
			$subTotal_discount 	= 0;

			if(!empty($order_detail)){
				foreach($order_detail as $k=>$v){
					$order_detail[$k]['final_date'] = $this->occational->dateConvert($order_detail[$k]['date']);
					$subTotal_quantity = $subTotal_quantity+$order_detail[$k]['quantity'];
				}
				$i=0;
				foreach($order_detail as $k=>$v){$i++;
				   $order_detail[$k]['sl']=$i;
				}
			}

			$currency_details = $this->Soft_settings->retrieve_currency_info();
			$company_info 	  = $this->Orders->retrieve_company();

			$data = array(
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

			$chapterList = $this->parser->parse('dashboard/order/order_pdf',$data,true);

			//PDF Generator 
			$this->load->library('pdfgenerator');
        	$file_path = $this->pdfgenerator->generate_order($order_id, $chapterList);


		    //File path save to database
		    $this->db->set('file_path',base_url($file_path));
		    $this->db->where('order_id',$order_id);
		    $this->db->update('order');

		    $send_email = '';
		    if (!empty($data['customer_email'])) {
		    	$send_email = $this->setmail($data['customer_email'],$file_path);
		    }

		    if ($send_email) {
		    	//Return order information
				$json[] = array(
						'status'   => "true", 
						'order_id' => $order_id, 
						'success'  => "Product orderd successfully !", 
					);
				echo $json_encode = json_encode(array('order_status' => $json),JSON_UNESCAPED_UNICODE);
		    }else{
		    	//Return order information
				$json[] = array(
						'status'   => "true", 
						'order_id' => $order_id, 
						'error'  => "Email not send !", 
					);
				echo $json_encode = json_encode(array('order_status' => $json),JSON_UNESCAPED_UNICODE);
		    }
		}else{
			//Return order information
			$json[] = array(
					'status'   => "false",
					'error'  => "Product orderd failed !", 
				);
			echo $json_encode = json_encode(array('order_status' => $json),JSON_UNESCAPED_UNICODE);
		}
	}

	//Send Customer Email with invoice
	public function setmail($email,$file_path)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Soft_settings');
		$setting_detail = $CI->Soft_settings->retrieve_email_editdata();

		$subject = display("order_information");
		$message = display("order_info_details").'<br>'.base_url();

	    $config = Array(
	      	'protocol' 		=> $setting_detail[0]['protocol'],
	      	'smtp_host' 	=> $setting_detail[0]['smtp_host'],
	      	'smtp_port' 	=> $setting_detail[0]['smtp_port'],
	      	'smtp_user' 	=> $setting_detail[0]['sender_email'], 
	      	'smtp_pass' 	=> $setting_detail[0]['password'], 
	      	'mailtype' 		=> $setting_detail[0]['mailtype'],
	      	'charset' 		=> 'utf-8',
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
		      	return true;
		    }else{
		     	return false;
		    }
		}else{
			return true;
		}
	}

	//Paypal setting
	public function paypal_setting(){
		$result = $this->db->select('*')
						->from('payment_gateway')
						->where('id',3)
						->get()
						->row();

		if ($result) {
			$json[] = array(
				'paypal_email'		=> $result->paypal_email,
				'paypal_client_id'	=> $result->paypal_client_id,
				'currency'			=> $result->currency,
			);
			echo $json_encode = json_encode(array('paypal_info' => $json),JSON_UNESCAPED_UNICODE);
		}else{
			$json[] = array(
					'status' => false, 
					'error' => 'No paypal settings found !', 
				);
			echo $json_encode = json_encode(array('paypal_info' => $json),JSON_UNESCAPED_UNICODE);
		}
	}

	//Payment setting
	public function payment_setting($payment_id = false){
		$this->db->select('*');
		$this->db->from('payment_gateway');
		if(!empty($payment_id)){
			$this->db->where('used_id',$payment_id);
		}
		$result = $this->db->get()->result();

		if ($result) {

			$json = $result;
			echo $json_encode = json_encode(array('payment_info' => $json),JSON_UNESCAPED_UNICODE);
		}else{
			$json[] = array(
					'status' => false, 
					'error' => 'No paypal settings found !', 
				);
			echo $json_encode = json_encode(array('paypal_info' => $json),JSON_UNESCAPED_UNICODE);
		}
	}


	//Order info
	public function order_info(){
		$customer_id = $this->input->get('user_id');
	
		if ($customer_id) {
			$order_info= $this->db->select('*')
								->from('order')
								->where('customer_id',$customer_id)
								->order_by('order','desc')
								->get()
								->result();

			if ($order_info) {
				foreach ($order_info as $order) {

					$status = 0;
					$order_status = $this->get_invoice_status($order->order_id);

					if ($order_status) {
						$status =  $order_status->invoice_status;
						if ($status  == 1) {
							$status = "Shipped";
						}elseif($status  == 2){
							$status = "Cancel";
						}elseif ($status  == 3) {
							$status = "Pending";
						}elseif ($status  == 4) {
							$status = "Complete";
						}elseif ($status  == 5) {
							$status = "Processing";
						}elseif ($status  == 6) {
							$status = "Return";
						}else{
							$status = "Pending";
						}
					}else{
						$status = "Pending";
					}

					//Return order information
					$json[] = array(
						'order_id' 		=> $order->order_id, 
						'customer_id' 	=> $order->customer_id, 
						'store_id' 		=> $order->store_id, 
						'date' 			=> $order->date, 
						'total_amount' 	=> $order->total_amount,
						'details' 		=> $order->details,
						'total_discount'=> $order->total_discount,
						'service_charge'=> $order->service_charge,
						'paid_amount'	=> $order->paid_amount,
						'due_amount'	=> $order->due_amount,
						'status'		=> $status,
					);
				}
				echo $json_encode = json_encode(array('order_info' => $json),JSON_UNESCAPED_UNICODE);
			}
		}else{
			//Return order information
			$json[] = array(
					'status' => false, 
					'error' => 'No order found !', 
				);
			echo $json_encode = json_encode(array('order_info' => $json),JSON_UNESCAPED_UNICODE);
		}
	}

	//Invoice status
	public function get_invoice_status($order_id = null){
		return $this->db->select('invoice_status')
						->from('invoice')
						->where('order_id',$order_id)
						->get()
						->row();
	}

	//Image Gallery
	public function image_gallery(){
		$product_id = $this->input->get('product_id');

		if ($product_id) {
			$image_details = $this->db->select('*')
									->from('image_gallery')
									->where('product_id',$product_id)
									->get()
									->result();
			if ($image_details) {
				foreach ($image_details as $image) {
					$json[] = array(
						'image_gallery_id'	=>	$image->image_gallery_id,
						'product_id'		=>	$image->product_id,
						'image'				=>	$image->image_url,
						'img_thumb'			=>	$image->img_thumb,
					);
				}
				echo $json_encode = json_encode(array('image_info' => $json),JSON_UNESCAPED_UNICODE);
			}else{
				$json[] = array(
					'status'   => "false",
					'error'  => "Image not found !", 
				);
				echo $json_encode = json_encode(array('image_info' => $json),JSON_UNESCAPED_UNICODE);
			}
		}else{
			$json[] = array(
					'status'   => "false",
					'error'  => "Please enter product id !", 
				);
			echo $json_encode = json_encode(array('image_info' => $json),JSON_UNESCAPED_UNICODE);
		}
	}

	//Order Details
	public function order_details(){
		$order_id = $this->input->get('order_id');

		if ($order_id) {
			$order_details = $this->db->select('a.*,b.product_name,b.image_thumb,c.variant_name')
								->from('order_details a')
								->join('product_information b','a.product_id = b.product_id')
								->join('variant c','a.variant_id = c.variant_id')
								->where('order_id',$order_id)
								->get()
								->result();

			if ($order_details) {
				foreach ($order_details as $order) {
			
					//Return order information
					$json[] = array(
						'order_id' 		=> $order->order_id, 
						'product_name' 	=> $order->product_name, 
						'product_image' => $order->image_thumb, 
						'store_id' 		=> $order->store_id, 
						'variant_name' 	=> $order->variant_name, 
						'quantity' 		=> $order->quantity,
						'rate' 			=> $order->rate,
						'total_price'   => $order->total_price,
						'discount'		=> $order->discount,
					);
				}
				echo $json_encode = json_encode(array('order_details' => $json),JSON_UNESCAPED_UNICODE);
			}
		}else{
			//Return order information
			$json[] = array(
					'status' => false, 
					'error' => 'No order details found !', 
				);
			echo $json_encode = json_encode(array('order_details' => $json),JSON_UNESCAPED_UNICODE);
		}
	}

	//Default store search
	public function default_store(){
		$store = $this->db->select('*')
					->from('store_set')
					->where('default_status','1')
					->get()
					->row();
		return $store->store_id;
	}

	//Calculate cgst tax by product and tax id
	public function calculate_cgst_tax($product_id=null,$product_rate=null,$order_id=null,$quantity,$variant_id=null){
		$percentage = $this->db->select('*')
					->from('tax_product_service')
					->where('product_id',$product_id)
					->where('tax_id','H5MQN4NXJBSDX4L')
					->get()
					->row();
		if ($percentage) {
			$tax_amount = ($product_rate * $percentage->tax_percentage / 100) * $quantity;

			//CGST Tax summary
			$cgst_summary = array(
				'order_tax_col_id'	=>	$this->generator(15),
				'order_id'			=>	$order_id,
				'tax_amount' 		=> 	$tax_amount, 
				'tax_id' 			=> 	$percentage->tax_id,
				'date'				=>	date('d-m-Y'),
			);
			if(!empty($tax_amount)){
				$result= $this->db->select('*')
							->from('order_tax_col_summary')
							->where('order_id',$order_id)
							->where('tax_id',$percentage->tax_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('tax_amount', 'tax_amount+'.$tax_amount, FALSE);
					$this->db->where('order_id', $order_id);
					$this->db->where('tax_id', $percentage->tax_id);
					$this->db->update('order_tax_col_summary');
				}else{
					$this->db->insert('order_tax_col_summary',$cgst_summary);
				}
			}

			//CGST tax info
			$cgst_details = array(
				'order_tax_col_de_id'=>	$this->generator(15),
				'order_id'			=>	$order_id,
				'amount' 			=> 	$tax_amount, 
				'product_id' 		=> 	$product_id, 
				'tax_id' 			=> 	$percentage->tax_id,
				'variant_id' 		=> 	$variant_id,
				'date'				=>	date('d-m-Y'),
			);
			if(!empty($tax_amount)){
				$result= $this->db->select('*')
							->from('order_tax_col_details')
							->where('order_id',$order_id)
							->where('tax_id',$percentage->tax_id)
							->where('product_id',$product_id)
							->where('variant_id',$variant_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('amount', 'amount+'.$tax_amount, FALSE);
					$this->db->where('order_id', $order_id);
					$this->db->where('tax_id', $percentage->tax_id);
					$this->db->where('variant_id', $variant_id);
					$this->db->where('product_id', $product_id);
					$this->db->update('order_tax_col_details');
				}else{
					$this->db->insert('order_tax_col_details',$cgst_details);
				}
			}
		}
	}	

	//Calculate sgst by product and tax id
	public function calculate_sgst_tax($product_id=null,$product_rate=null,$order_id=null,$quantity,$variant_id=null){
		$percentage = $this->db->select('*')
					->from('tax_product_service')
					->where('product_id',$product_id)
					->where('tax_id','52C2SKCKGQY6Q9J')
					->get()
					->row();
		if ($percentage) {
			$tax_amount = ($product_rate * $percentage->tax_percentage / 100) * $quantity;


			//Sgst tax summary
			$sgst_summary = array(
				'order_tax_col_id'	=>	$this->generator(15),
				'order_id'			=>	$order_id,
				'tax_amount' 		=> 	$tax_amount, 
				'tax_id' 			=> 	$percentage->tax_id,
				'date'				=>	date('d-m-Y'),
			);
			if(!empty($tax_amount)){
				$result= $this->db->select('*')
							->from('order_tax_col_summary')
							->where('order_id',$order_id)
							->where('tax_id',$percentage->tax_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('tax_amount', 'tax_amount+'.$tax_amount, FALSE);
					$this->db->where('order_id', $order_id);
					$this->db->where('tax_id', $percentage->tax_id);
					$this->db->update('order_tax_col_summary');
				}else{
					$this->db->insert('order_tax_col_summary',$sgst_summary);
				}
			}

			//SGST tax details
			$sgst_summary = array(
				'order_tax_col_de_id'	=>	$this->generator(15),
				'order_id'			=>	$order_id,
				'amount' 			=> 	$tax_amount, 
				'product_id' 		=> 	$product_id, 
				'tax_id' 			=> 	$percentage->tax_id,
				'variant_id' 		=> 	$variant_id,
				'date'				=>	date('d-m-Y'),
			);
			if(!empty($tax_amount)){
				$result= $this->db->select('*')
							->from('order_tax_col_details')
							->where('order_id',$order_id)
							->where('tax_id',$percentage->tax_id)
							->where('product_id',$product_id)
							->where('variant_id',$variant_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('amount', 'amount+'.$tax_amount, FALSE);
					$this->db->where('order_id', $order_id);
					$this->db->where('tax_id', $percentage->tax_id);
					$this->db->where('variant_id', $variant_id);
					$this->db->where('product_id', $product_id);
					$this->db->update('order_tax_col_details');
				}else{
					$this->db->insert('order_tax_col_details',$sgst_summary);
				}
			}
		}
	}	

	//Calculate igst by product and tax id
	public function calculate_igst_tax($product_id=null,$product_rate=null,$order_id=null,$quantity,$variant_id=null){
		$percentage = $this->db->select('*')
					->from('tax_product_service')
					->where('product_id',$product_id)
					->where('tax_id','5SN9PRWPN131T4V')
					->get()
					->row();
		if ($percentage) {
			$tax_amount = ($product_rate * $percentage->tax_percentage / 100) * $quantity;
			
			//IGST tax summary
			$igst_summary = array(
				'order_tax_col_id'	=>	$this->generator(15),
				'order_id'			=>	$order_id,
				'tax_amount' 		=> 	$tax_amount, 
				'tax_id' 			=> 	$percentage->tax_id,
				'date'				=>	date('d-m-Y'),
			);
			if(!empty($tax_amount)){
				$result= $this->db->select('*')
							->from('order_tax_col_summary')
							->where('order_id',$order_id)
							->where('tax_id',$percentage->tax_id)
							->get()
							->num_rows();

				if ($result > 0) {
					$this->db->set('tax_amount', 'tax_amount+'.$tax_amount, FALSE);
					$this->db->where('order_id', $order_id);
					$this->db->where('tax_id', $percentage->tax_id);
					$this->db->update('order_tax_col_summary');
				}else{
					$this->db->insert('order_tax_col_summary',$igst_summary);
				}
			}

			//IGST tax details
			$igst_summary = array(
				'order_tax_col_de_id'=>	$this->generator(15),
				'order_id'			=>	$order_id,
				'amount' 			=> 	$tax_amount, 
				'product_id' 		=> 	$product_id, 
				'tax_id' 			=> 	$percentage->tax_id,
				'variant_id' 		=> 	$variant_id,
				'date'				=>	date('d-m-Y'),
			);

			if(!empty($tax_amount)){
				$result= $this->db->select('*')
							->from('order_tax_col_details')
							->where('order_id',$order_id)
							->where('tax_id',$percentage->tax_id)
							->where('product_id',$product_id)
							->where('variant_id',$variant_id)
							->get()
							->num_rows();
				if ($result > 0) {
					$this->db->set('amount', 'amount+'.$tax_amount, FALSE);
					$this->db->where('order_id', $order_id);
					$this->db->where('tax_id', $percentage->tax_id);
					$this->db->where('variant_id', $variant_id);
					$this->db->where('product_id', $product_id);
					$this->db->update('order_tax_col_details');
				}else{
					$this->db->insert('order_tax_col_details',$igst_summary);
				}
			}
		}
	}

	//Tax info by product id
	public function tax_info(){

	    $product_info = file_get_contents('php://input');
        $product_info = json_decode($product_info);
   
		if ($product_info) {
			foreach ($product_info->idsForTaxes as $product) {
		    	foreach($product->ids as $p){
		    	    
    				$tax_info = $this->db->select('SUM(a.tax_percentage) as total_tax,b.*')
    									->from('tax_product_service a')
    									->join('product_information b','a.product_id = b.product_id')
    									->where('a.product_id',$p)
    									->get()
    									->row();
    				$price = 0;
    				if ($tax_info->onsale == 1) {
    					$price = $tax_info->onsale_price;
    				}else{
    					$price = $tax_info->price;
    				}
    				$json[] = array(
    					'product_id'  => $tax_info->product_id, 
    					'tax_amount'  => $tax_info->total_tax * $price / 100, 
    				);
		    	}
			
			}
			echo $json_encode = json_encode(array('tax_info' => $json),JSON_UNESCAPED_UNICODE);
		}else{
	    	$json[] = array(
				'product_id'  =>'none',
			);
			
			echo $json_encode = json_encode(array('tax_info' => $json),JSON_UNESCAPED_UNICODE);
		}
	}
	
	//Web setting
	public function web_setting(){
		$result = $this->db->select('logo')
				->from('web_setting')
				->where('setting_id',1)
				->get()
				->row();

		if ($result) {
			$json[] = array(
					'logo'  => $result->logo,
				);
				
			echo $json_encode = json_encode(array('setting_info' => $json),JSON_UNESCAPED_UNICODE);
		}else{
			$json[] = array(
					'status' => 'false',
					'error'  => 'No logo found !',
				);
				
			echo $json_encode = json_encode(array('setting_info' => $json),JSON_UNESCAPED_UNICODE);
		}
	}
	
	//Currency list
	public function currency_list(){
		$currency_info = $this->db->select('*')
							->from('currency_info')
							->get()
							->result();
		if ($currency_info) {
			foreach ($currency_info as $currency_info) {
				$json[] = array(
					'currency_id'	=>	$currency_info->currency_id,
					'currency_name'	=>	$currency_info->currency_name,
					'currency_icon'	=>	$currency_info->currency_icon,
					'currency_position'	=>	$currency_info->currency_position,
					'convertion_rate'=>	$currency_info->convertion_rate,
					'default_status' =>	$currency_info->default_status,
				);
			}
			echo $json_encode = json_encode(array('currency_info' => $json),JSON_UNESCAPED_UNICODE);
		}else{
			$json[] = array(
				'error'  => 'No currency found !',
			);
			echo $json_encode = json_encode(array('currency_info' => $json),JSON_UNESCAPED_UNICODE);
		}
	}

	//This function is used to Generate Key
	public function generator($lenth)
	{
		$number=array("A","B","C","D","E","F","G","H","I","J","K","L","N","M","O","P","Q","R","S","U","V","T","W","X","Y","Z","1","2","3","4","5","6","7","8","9","0");
	
		for($i=0; $i<$lenth; $i++)
		{
			$rand_value=rand(0,34);
			$rand_number=$number["$rand_value"];
		
			if(empty($con)){ 
				$con = $rand_number;
			}else{
				$con = "$con"."$rand_number";
			}
		}
		return $con;
	}

	//NUMBER GENERATOR FOR ORDER
	public function number_generator_order()
	{
		$this->db->select_max('order', 'order_no');
		$query = $this->db->get('order');	
		$result = $query->result_array();	
		$order_no = $result[0]['order_no'];
		if ($order_no !='') {
			$order_no = $order_no + 1;	
		}else{
			$order_no = 1000;
		}
		return $order_no;		
	}
}