<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lsetting {

	//About us info
	public function about_us($page_id)
	{
		$CI =& get_instance();
		$CI->load->model('web/customer/Logins');
		$CI->load->model('web/Homes');
		$CI->load->model('dashboard/web_settings');
		$CI->load->model('dashboard/Soft_settings');
		$CI->load->model('dashboard/Blocks');
		$CI->load->model('web/Settings');
		$CI->load->model('dashboard/Themes');
		$theme= $CI->Themes->get_theme();

		$parent_category_list 	= $CI->Homes->parent_category_list();;
		$pro_category_list 		= $CI->Logins->category_list();
		$best_sales 			= $CI->Logins->best_sales();
		$footer_block 			= $CI->Logins->footer_block();
		$slider_list 			= $CI->web_settings->slider_list();
		$block_list 			= $CI->Blocks->block_list(); 
		$currency_details 		= $CI->Soft_settings->retrieve_currency_info();

		$Soft_settings 			= $CI->Soft_settings->retrieve_setting_editdata();
		$languages 				= $CI->Homes->languages();
		$currency_info 			= $CI->Homes->currency_info();
		$selected_currency_info = $CI->Homes->selected_currency_info();
		$about_us_info 			= $CI->Settings->about_info($page_id);
		$about_content_info 	= $CI->Settings->about_content_info();

		$data = array(
				'title' 		=> display('about_us'),
				'category_list' => $parent_category_list,
				'pro_category_list' => $pro_category_list,
				'slider_list' 	=> $slider_list,
				'block_list' 	=> $block_list,
				'best_sales' 	=> $best_sales,
				'footer_block' 	=> $footer_block,
				'Soft_settings' => $Soft_settings,
				'languages' 	=> $languages,
				'currency_info' => $currency_info,
				'about_content_info' => $about_content_info,
				'page_id' 		=> $about_us_info[0]['page_id'],
				'headlines' 	=> $about_us_info[0]['headlines'],
				'image' 		=> $about_us_info[0]['image'],
				'details' 		=> $about_us_info[0]['details'],
				'selected_cur_id' => (($selected_currency_info->currency_id)?$selected_currency_info->currency_id:""),
				'currency' 		=> $currency_details[0]['currency_icon'],
				'position' 		=> $currency_details[0]['currency_position'],
			);
		$HomeForm = $CI->parser->parse('web/themes/'.$theme.'/about_us',$data,true);
		return $HomeForm;
	}	

	//Delivery info
	public function delivery_info($page_id)
	{
		$CI =& get_instance();
		$CI->load->model('web/customer/Logins');
		$CI->load->model('web/Homes');
		$CI->load->model('dashboard/web_settings');
		$CI->load->model('dashboard/Soft_settings');
		$CI->load->model('dashboard/Blocks');
		$CI->load->model('web/Settings');
        $CI->load->model('dashboard/Themes');
        $theme= $CI->Themes->get_theme();
		$parent_category_list 	= $CI->Homes->parent_category_list();;
		$pro_category_list 		= $CI->Logins->category_list();
		$best_sales 			= $CI->Logins->best_sales();
		$footer_block 			= $CI->Logins->footer_block();
		$slider_list 			= $CI->web_settings->slider_list();
		$block_list 			= $CI->Blocks->block_list(); 
		$currency_details 		= $CI->Soft_settings->retrieve_currency_info();

		$Soft_settings 			= $CI->Soft_settings->retrieve_setting_editdata();
		$languages 				= $CI->Homes->languages();
		$currency_info 			= $CI->Homes->currency_info();
		$selected_currency_info = $CI->Homes->selected_currency_info();
		$about_us_info 			= $CI->Settings->about_info($page_id);

		$data = array(
				'title' 		=> display('delivery_info'),
				'category_list' => $parent_category_list,
				'pro_category_list' => $pro_category_list,
				'slider_list' 	=> $slider_list,
				'block_list' 	=> $block_list,
				'best_sales' 	=> $best_sales,
				'footer_block' 	=> $footer_block,
				'Soft_settings' => $Soft_settings,
				'languages' 	=> $languages,
				'currency_info' => $currency_info,
				'page_id' 		=> $about_us_info[0]['page_id'],
				'headlines' 	=> $about_us_info[0]['headlines'],
				'image' 		=> $about_us_info[0]['image'],
				'details' 		=> $about_us_info[0]['details'],
				'selected_cur_id' => (($selected_currency_info->currency_id)?$selected_currency_info->currency_id:""),
				'currency' 		=> $currency_details[0]['currency_icon'],
				'position' 		=> $currency_details[0]['currency_position'],
			);
		$HomeForm = $CI->parser->parse('web/themes/'.$theme.'/delivery_info',$data,true);
		return $HomeForm;
	}	

	//Privacy Policy
	public function privacy_policy($page_id)
	{
		$CI =& get_instance();
		$CI->load->model('web/customer/Logins');
		$CI->load->model('web/Homes');
		$CI->load->model('dashboard/web_settings');
		$CI->load->model('dashboard/Soft_settings');
		$CI->load->model('dashboard/Blocks');
		$CI->load->model('web/Settings');
        $CI->load->model('dashboard/Themes');
        $theme= $CI->Themes->get_theme();
		$parent_category_list 	= $CI->Homes->parent_category_list();
		$pro_category_list 		= $CI->Logins->category_list();
		$best_sales 			= $CI->Logins->best_sales();
		$footer_block 			= $CI->Logins->footer_block();
		$slider_list 			= $CI->web_settings->slider_list();
		$block_list 			= $CI->Blocks->block_list(); 
		$currency_details 		= $CI->Soft_settings->retrieve_currency_info();

		$Soft_settings 			= $CI->Soft_settings->retrieve_setting_editdata();
		$languages 				= $CI->Homes->languages();
		$currency_info 			= $CI->Homes->currency_info();
		$selected_currency_info = $CI->Homes->selected_currency_info();
		$about_us_info 			= $CI->Settings->about_info($page_id);

		$data = array(
				'title' 		=> display('privacy_policy'),
				'category_list' => $parent_category_list,
				'pro_category_list' => $pro_category_list,
				'slider_list' 	=> $slider_list,
				'block_list' 	=> $block_list,
				'best_sales' 	=> $best_sales,
				'footer_block' 	=> $footer_block,
				'Soft_settings' => $Soft_settings,
				'languages' 	=> $languages,
				'currency_info' => $currency_info,
				'page_id' 		=> $about_us_info[0]['page_id'],
				'headlines' 	=> $about_us_info[0]['headlines'],
				'image' 		=> $about_us_info[0]['image'],
				'details' 		=> $about_us_info[0]['details'],
				'selected_cur_id' => (($selected_currency_info->currency_id)?$selected_currency_info->currency_id:""),
				'currency' 		=> $currency_details[0]['currency_icon'],
				'position' 		=> $currency_details[0]['currency_position'],
			);
		$HomeForm = $CI->parser->parse('web/themes/'.$theme.'/privacy_policy',$data,true);
		return $HomeForm;
	}	

	//Terms and condition
	public function terms_condition($page_id)
	{
		$CI =& get_instance();
		$CI->load->model('web/customer/Logins');
		$CI->load->model('web/Homes');
		$CI->load->model('dashboard/web_settings');
		$CI->load->model('dashboard/Soft_settings');
		$CI->load->model('dashboard/Blocks');
		$CI->load->model('web/Settings');
        $CI->load->model('dashboard/Themes');
        $theme= $CI->Themes->get_theme();
		$parent_category_list 	= $CI->Homes->parent_category_list();
		$pro_category_list 		= $CI->Logins->category_list();
		$best_sales 			= $CI->Logins->best_sales();
		$footer_block 			= $CI->Logins->footer_block();
		$slider_list 			= $CI->web_settings->slider_list();
		$block_list 			= $CI->Blocks->block_list(); 
		$currency_details 		= $CI->Soft_settings->retrieve_currency_info();

		$Soft_settings 			= $CI->Soft_settings->retrieve_setting_editdata();
		$languages 				= $CI->Homes->languages();
		$currency_info 			= $CI->Homes->currency_info();
		$selected_currency_info = $CI->Homes->selected_currency_info();
		$about_us_info 			= $CI->Settings->about_info($page_id);

		$data = array(
				'title' 		=> display('terms_condition'),
				'category_list' => $parent_category_list,
				'pro_category_list' => $pro_category_list,
				'slider_list' 	=> $slider_list,
				'block_list' 	=> $block_list,
				'best_sales' 	=> $best_sales,
				'footer_block' 	=> $footer_block,
				'Soft_settings' => $Soft_settings,
				'languages' 	=> $languages,
				'currency_info' => $currency_info,
				'page_id' 		=> $about_us_info[0]['page_id'],
				'headlines' 	=> $about_us_info[0]['headlines'],
				'image' 		=> $about_us_info[0]['image'],
				'details' 		=> $about_us_info[0]['details'],
				'selected_cur_id' => (($selected_currency_info->currency_id)?$selected_currency_info->currency_id:""),
				'currency' 		=> $currency_details[0]['currency_icon'],
				'position' 		=> $currency_details[0]['currency_position'],
			);
		$HomeForm = $CI->parser->parse('web/themes/'.$theme.'/terms_condition',$data,true);
		return $HomeForm;
	}	

	//Help
	public function help($page_id)
	{
		$CI =& get_instance();
		$CI->load->model('web/customer/Logins');
		$CI->load->model('web/Homes');
		$CI->load->model('dashboard/web_settings');
		$CI->load->model('dashboard/Soft_settings');
		$CI->load->model('dashboard/Blocks');
		$CI->load->model('web/Settings');
        $CI->load->model('dashboard/Themes');
        $theme= $CI->Themes->get_theme();
		$parent_category_list 	= $CI->Homes->parent_category_list();
		$pro_category_list 		= $CI->Logins->category_list();
		$best_sales 			= $CI->Logins->best_sales();
		$footer_block 			= $CI->Logins->footer_block();
		$slider_list 			= $CI->web_settings->slider_list();
		$block_list 			= $CI->Blocks->block_list(); 
		$currency_details 		= $CI->Soft_settings->retrieve_currency_info();

		$Soft_settings 			= $CI->Soft_settings->retrieve_setting_editdata();
		$languages 				= $CI->Homes->languages();
		$currency_info 			= $CI->Homes->currency_info();
		$selected_currency_info = $CI->Homes->selected_currency_info();
		$about_us_info 			= $CI->Settings->about_info($page_id);

		$data = array(
				'title' 		=> display('help'),
				'category_list' => $parent_category_list,
				'pro_category_list' => $pro_category_list,
				'slider_list' 	=> $slider_list,
				'block_list' 	=> $block_list,
				'best_sales' 	=> $best_sales,
				'footer_block' 	=> $footer_block,
				'Soft_settings' => $Soft_settings,
				'languages' 	=> $languages,
				'currency_info' => $currency_info,
				'page_id' 		=> $about_us_info[0]['page_id'],
				'headlines' 	=> $about_us_info[0]['headlines'],
				'image' 		=> $about_us_info[0]['image'],
				'details' 		=> $about_us_info[0]['details'],
				'selected_cur_id' => (($selected_currency_info->currency_id)?$selected_currency_info->currency_id:""),
				'currency' 		=> $currency_details[0]['currency_icon'],
				'position' 		=> $currency_details[0]['currency_position'],
			);
		$HomeForm = $CI->parser->parse('web/themes/'.$theme.'/help',$data,true);
		return $HomeForm;
	}	

	//Contact us
	public function contact_us()
	{
		$CI =& get_instance();
		$CI->load->model('web/customer/Logins');
		$CI->load->model('web/Homes');
		$CI->load->model('dashboard/web_settings');
		$CI->load->model('dashboard/Soft_settings');
		$CI->load->model('dashboard/Blocks');
		$CI->load->model('web/Settings');
        $CI->load->model('dashboard/Themes');
        $theme= $CI->Themes->get_theme();
		$parent_category_list 	= $CI->Homes->parent_category_list();
		$pro_category_list 		= $CI->Logins->category_list();
		$best_sales 			= $CI->Logins->best_sales();
		$footer_block 			= $CI->Logins->footer_block();
		$slider_list 			= $CI->web_settings->slider_list();
		$block_list 			= $CI->Blocks->block_list(); 
		$currency_details 		= $CI->Soft_settings->retrieve_currency_info();

		$Soft_settings 			= $CI->Soft_settings->retrieve_setting_editdata();
		$languages 				= $CI->Homes->languages();
		$currency_info 			= $CI->Homes->currency_info();
		$map_info 				= $CI->web_settings->map_info();
		$selected_currency_info = $CI->Homes->selected_currency_info();
		$our_location_info 		= $CI->Settings->our_location_info();

		$data = array(
				'title' 		=> display('contact_us'),
				'category_list' => $parent_category_list,
				'pro_category_list' => $pro_category_list,
				'slider_list' 	=> $slider_list,
				'block_list' 	=> $block_list,
				'best_sales' 	=> $best_sales,
				'footer_block' 	=> $footer_block,
				'Soft_settings' => $Soft_settings,
				'languages' 	=> $languages,
				'currency_info' => $currency_info,
				'map_info' 		=> $map_info,
				'our_location_info' => $our_location_info,
				'selected_cur_id' => (($selected_currency_info->currency_id)?$selected_currency_info->currency_id:""),
				'currency' 		=> $currency_details[0]['currency_icon'],
				'position' 		=> $currency_details[0]['currency_position'],
			);
		$HomeForm = $CI->parser->parse('web/themes/'.$theme.'/contact_us',$data,true);
		return $HomeForm;
	}
}
?>