<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lstore {
	//Add store
	public function store_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Stores');
		$data = array(
				'title' => display('add_store')
			);
		$customerForm = $CI->parser->parse('dashboard/store/add_store',$data,true);
		return $customerForm;
	}	
	//Add store product
	public function store_transfer_form()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Stores');
		$CI->load->model('dashboard/Products');
		$CI->load->model('dashboard/Variants');
		$store_list   = $CI->Stores->store_list();
		$variant_list = $CI->Variants->variant_list();
		$data = array(
				'title' 		=> display('store_product_transfer'),
				'store_list' 	=> $store_list,
				'variant_list' 	=> $variant_list,
			);
		$store_product = $CI->parser->parse('dashboard/store/store_product_transfer',$data,true);
		return $store_product;
	}

	//Retrieve  store List	
	public function store_list()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Stores');
		$store_list = $CI->Stores->store_list(); 

		$i=0;
		if(!empty($store_list)){	
			foreach($store_list as $k=>$v){$i++;
			   $store_list[$k]['sl']=$i;
			}
		}

		$data = array(
				'title' => display('manage_store'),
				'store_list' => $store_list,
			);
		$customerList = $CI->parser->parse('dashboard/store/store',$data,true);
		return $customerList;
	}

	//Retrieve  store product List	
	public function store_product_list()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Stores');
		$store_product_list = $CI->Stores->store_product_list(); 

		$data = array(
				'title' => display('manage_store_product'),
				'store_product_list' => $store_product_list,
			);
		$customerList = $CI->parser->parse('dashboard/store/manage_store_product',$data,true);
		return $customerList;
	}

	//store Edit Data
	public function store_edit_data($store_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Stores');
		$store_details = $CI->Stores->retrieve_store_editdata($store_id);	
		$data=array(
			'title' 		=> display('store_edit'),
			'store_id' 		=> $store_details[0]['store_id'],
			'store_name' 	=> $store_details[0]['store_name'],
			'store_address' => $store_details[0]['store_address'],
			'default_status' => $store_details[0]['default_status']
			);
		$chapterList = $CI->parser->parse('dashboard/store/edit_store',$data,true);
		return $chapterList;
	}	
	//Store Product Edit Data
	public function store_product_edit_data($store_product_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Stores');
		$CI->load->model('dashboard/Products');
		$CI->load->model('dashboard/Variants');
		$store_details = $CI->Stores->retrieve_store_product_editdata($store_product_id);

		$store_id = $store_details[0]['store_id'];
		$product_id = $store_details[0]['product_id'];
		$variant_id = $store_details[0]['variant_id'];


		$store_list   = $CI->Stores->store_list();
		$product_list = $CI->Products->product_list();
		$variant_list = $CI->Variants->variant_list();

		$store_list_selected = $CI->Stores->store_list_selected($store_id);
		$product_list_selected = $CI->Stores->product_list_selected($product_id);
		$variant_list_selected = $CI->Stores->variant_list_selected($variant_id);

		
		$data=array(
			'title' 		=> display('store_product_edit'),
			'store_product_id' 	=> $store_details[0]['store_product_id'],
			'quantity' 	=> $store_details[0]['quantity'],
			'store_list' => $store_list,
			'product_list' => $product_list,
			'variant_list' => $variant_list,
			'store_list_selected' => $store_list_selected,
			'product_list_selected' => $product_list_selected,
			'variant_list_selected' => $variant_list_selected,
			);
		$chapterList = $CI->parser->parse('dashboard/store/edit_store_product',$data,true);
		return $chapterList;
	}
}
?>