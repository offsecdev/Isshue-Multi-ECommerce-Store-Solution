<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lsignup {

	//Home Page Load Here
	public function signup_page()
	{
		$CI =& get_instance();
		$CI->load->model('web/customer/Signups');
		$CI->load->model('web/Homes');
		$CI->load->model('web_settings');
		$CI->load->model('Soft_settings');
		$CI->load->model('Blocks');
        $parent_category_list 	= $CI->Homes->parent_category_list();
        $pro_category_list 		= $CI->Homes->category_list();
		$best_sales 			= $CI->Signups->best_sales();
		$footer_block 			= $CI->Signups->footer_block();
		$slider_list 			= $CI->web_settings->slider_list();
		$block_list 			= $CI->Blocks->block_list(); 
		$currency_details 		= $CI->Soft_settings->retrieve_currency_info();

		$Soft_settings 			= $CI->Soft_settings->retrieve_setting_editdata();
		$languages 				= $CI->Homes->languages();
		$currency_info 			= $CI->Homes->currency_info();
		$selected_currency_info = $CI->Homes->selected_currency_info();

		$data = array(
				'title' 		=> display('sign_up'),
				'category_list' => $parent_category_list,
				'pro_category_list' => $pro_category_list,
				'slider_list' 	=> $slider_list,
				'block_list' 	=> $block_list,
				'best_sales' 	=> $best_sales,
				'footer_block' 	=> $footer_block,
				'Soft_settings' => $Soft_settings,
				'languages' 	=> $languages,
				'currency_info' => $currency_info,
				'selected_cur_id' => (($selected_currency_info->currency_id)?$selected_currency_info->currency_id:""),
				'currency' 		=> $currency_details[0]['currency_icon'],
				'position' 		=> $currency_details[0]['currency_position'],
			);
		$HomeForm = $CI->parser->parse('web/customer/signup',$data,true);
		return $HomeForm;
	}	

	//Checkout
	public function checkout()
	{
		$CI =& get_instance();
		$CI->load->model('web/customer/Signups');
		$CI->load->model('web_settings');
		$CI->load->model('Soft_settings');
		$CI->load->model('Blocks');
		$parent_category_list 	= $CI->Signups->parent_category_list();
		$pro_category_list 		= $CI->Signups->category_list();
		$best_sales 			= $CI->Signups->best_sales();
		$footer_block 			= $CI->Signups->footer_block();
		$slider_list 			= $CI->web_settings->slider_list();
		$block_list 			= $CI->Blocks->block_list(); 
		$currency_details 		= $CI->Soft_settings->retrieve_currency_info();

		$data = array(
				'title' 		=> display('checkout'),
				'category_list' => $parent_category_list,
				'pro_category_list' => $pro_category_list,
				'slider_list' 	=> $slider_list,
				'block_list' 	=> $block_list,
				'best_sales' 	=> $best_sales,
				'footer_block' 	=> $footer_block,
				'currency' 		=> $currency_details[0]['currency_icon'],
				'position' 		=> $currency_details[0]['currency_position'],
			);
		$HomeForm = $CI->parser->parse('web/checkout',$data,true);
		return $HomeForm;
	}
	//Retrieve  category List	
	public function category_list()
	{
		$CI =& get_instance();
		$CI->load->model('web/customer/Signups');
		$category_list = $CI->Signups->category_list();  //It will get only Credit categorys
		$i=0;
		$total=0;
		if(!empty($category_list)){	
			foreach($category_list as $k=>$v){$i++;
			   $category_list[$k]['sl']=$i;
			}
		}
		$data = array(
				'title' 		=> 'Categories List',
				'category_list' => $category_list,
			);
		$categoryList = $CI->parser->parse('category/category',$data,true);
		return $categoryList;
	}
	//Category Edit Data
	public function category_edit_data($category_id)
	{
		$CI =& get_instance();
		$CI->load->model('web/customer/Signups');
		$category_detail = $CI->Signups->retrieve_category_editdata($category_id);
		$data=array(
			'category_id' 			=> $category_detail[0]['category_id'],
			'category_name' 		=> $category_detail[0]['category_name'],
			'status' 				=> $category_detail[0]['status']
			);
		$chapterList = $CI->parser->parse('category/edit_category_form',$data,true);
		return $chapterList;
	}
}
?>