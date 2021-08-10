<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lgallery {
	//Add image
	public function image_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Galleries');
		$CI->load->model('dashboard/Products');
		$product_list = $CI->Products->product_list(); 

		$data = array(
				'title' 	   => display('add_image'),
				'product_list' => $product_list,
			);
		$customerForm = $CI->parser->parse('dashboard/image/add_image',$data,true);
		return $customerForm;
	}

	//Retrieve  image List	
	public function image_list()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Galleries');
		$image_list = $CI->Galleries->image_list(); 

		$data = array(
				'title' => display('manage_image'),
				'image_list' => $image_list,
			);
		$customerList = $CI->parser->parse('dashboard/image/image',$data,true);
		return $customerList;
	}

	//image Edit Data
	public function image_edit_data($image_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Galleries');
		$CI->load->model('dashboard/Products');
		$image_details = $CI->Galleries->retrieve_image_editdata($image_id);
		$product_list = $CI->Products->product_list(); 

		$product_id = $image_details[0]['product_id'];
		$selected_product = $CI->Galleries->selected_product($product_id);

		$data=array(
			'title' 		=> display('image_edit'),
			'image_gallery_id' => $image_details[0]['image_gallery_id'],
			'image_url' 	=> $image_details[0]['image_url'],
			'img_thumb' 	=> $image_details[0]['img_thumb'],
			'product_list' 	=> $product_list,
			'selected_product' 	=> $selected_product,
			);
		$chapterList = $CI->parser->parse('dashboard/image/edit_image',$data,true);
		return $chapterList;
	}
}
?>