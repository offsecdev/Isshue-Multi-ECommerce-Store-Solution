<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lwishlist {
	//Add wishlist
	public function wishlist_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('Wishlists');
		$CI->load->model('Products');
		$product_list = $CI->Products->product_list(); 

		$data = array(
				'title' 	   => display('add_wishlist'),
				'product_list' => $product_list,
			);
		$customerForm = $CI->parser->parse('wishlist/add_wishlist',$data,true);
		return $customerForm;
	}

	//Retrieve wishlist List	
	public function wishlist_list()
	{
		$CI =& get_instance();
		$CI->load->model('Wishlists');
		$wishlist_list = $CI->Wishlists->wishlist_list(); 

		$i=0;
		if(!empty($wishlist_list)){	
			foreach($wishlist_list as $k=>$v){$i++;
			   $wishlist_list[$k]['sl']=$i;
			}
		}

		$data = array(
				'title' => display('manage_wishlist'),
				'wishlist_list' => $wishlist_list,
			);
		$customerList = $CI->parser->parse('wishlist/wishlist',$data,true);
		return $customerList;
	}

	//wishlist Edit Data
	public function wishlist_edit_data($wishlist_id)
	{
		$CI =& get_instance();
		$CI->load->model('Wishlists');
		$CI->load->model('Products');
		$wishlist_details = $CI->Wishlists->retrieve_wishlist_editdata($wishlist_id);
		$product_id = $wishlist_details[0]['product_id'];
		$selected_product = $CI->Products->product_search_item($product_id);
		$product_list = $CI->Products->product_list();
	
		$data=array(
			'title' 		=> display('wishlist_update'),
			'wishlist_id' 	=> $wishlist_details[0]['wishlist_id'],
			'product_id' 	=> $wishlist_details[0]['product_id'],
			'selected_product' 	=> $selected_product,
			'product_list' 	=> $product_list,
			);
		$chapterList = $CI->parser->parse('wishlist/edit_wishlist',$data,true);
		return $chapterList;
	}
}
?>