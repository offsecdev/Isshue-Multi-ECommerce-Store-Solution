<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lproduct_review {
	//Add product_review
	public function product_review_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Product_reviews');
		$CI->load->model('dashboard/Products');

		$product_list = $CI->Products->product_list(); 

		$data = array(
				'title' => display('add_product_review'),
				'product_list' => $product_list,
			);
		$customerForm = $CI->parser->parse('dashboard/product_review/add_product_review',$data,true);
		return $customerForm;
	}

	//Retrieve  product_review List	
	public function product_review_list()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Product_reviews');
		$product_review_list 	  = $CI->Product_reviews->product_review_list(); 
		
		$i=0;
		if(!empty($product_review_list)){	
			foreach($product_review_list as $k=>$v){$i++;
			   $product_review_list[$k]['sl']=$i;
			}
		}

		$data = array(
				'title' => display('manage_product_review'),
				'product_review_list' => $product_review_list,
			);
		$customerList = $CI->parser->parse('dashboard/product_review/product_review',$data,true);
		return $customerList;
	}

	//product_review Edit Data
	public function product_review_edit_data($product_review_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Product_reviews');
		$CI->load->model('dashboard/Products');

		$product_review_details = $CI->Product_reviews->retrieve_product_review_editdata($product_review_id);
		$product_id = $product_review_details[0]['product_id'];
		$product_selected = $CI->Products->product_search_item($product_id);
		$product_list = $CI->Products->product_list(); 
	
		$data=array(
			'title' 		=> display('product_review_edit'),
			'product_review_id' 		=> $product_review_details[0]['product_review_id'],
			'comments' 		=> $product_review_details[0]['comments'],
			'rate' 			=> $product_review_details[0]['rate'],
			'product_selected' => $product_selected,
			'product_list' => $product_list,
			);
		$chapterList = $CI->parser->parse('dashboard/product_review/edit_product_review',$data,true);
		return $chapterList;
	}
}
?>