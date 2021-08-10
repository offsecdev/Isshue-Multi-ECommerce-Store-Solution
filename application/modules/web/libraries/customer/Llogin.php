<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Llogin {

	//Home Page Load Here
	public function login_page()
	{
		$CI =& get_instance();
		$CI->load->model('web/customer/Logins');
		$CI->load->model('web/Homes');
		$CI->load->model('dashboard/web_settings');
		$CI->load->model('dashboard/Soft_settings');
		$CI->load->model('dashboard/Blocks');
        $CI->load->model('dashboard/Themes');
        $theme = $CI->Themes->get_theme();
		$parent_category_list 	= $CI->Logins->parent_category_list();
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

		$data = array(
			'title' 		=> display('login'),
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
		$HomeForm = $CI->parser->parse('web/themes/'.$theme.'/login',$data,true);
		return $HomeForm;
	}	

	//Checkout
	public function checkout()
	{
		$CI =& get_instance();
		$CI->load->model('web/customer/Logins');
		$CI->load->model('dashboard/web_settings');
		$CI->load->model('dashboard/Soft_settings');
		$CI->load->model('dashboard/Blocks');
		$CI->load->model('dashboard/Themes');
        $theme = $CI->Themes->get_theme();
        
		$parent_category_list 	= $CI->Logins->parent_category_list();
		$pro_category_list 		= $CI->Logins->category_list();
		$best_sales 			= $CI->Logins->best_sales();
		$footer_block 			= $CI->Logins->footer_block();
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
		$HomeForm = $CI->parser->parse('web/themes/'.$theme.'/checkout',$data,true);
		return $HomeForm;
	}
	//Retrieve  category List	
	public function category_list()
	{
		$CI =& get_instance();
		$CI->load->model('web/customer/Logins');
		$category_list = $CI->Logins->category_list();  //It will get only Credit categorys
		$i=0;
		$total=0;
		if(!empty($category_list)){	
			foreach($category_list as $k=>$v){$i++;
				$category_list[$k]['sl']=$i;
			}
		}
		$data = array(
			'title' 		=> display('category_list'),
			'category_list' => $category_list,
		);
		$categoryList = $CI->parser->parse('dashboard/category/category',$data,true);
		return $categoryList;
	}

	//Category Edit Data
	public function category_edit_data($category_id)
	{
		$CI =& get_instance();
		$CI->load->model('web/customer/Logins');
		$category_detail = $CI->Logins->retrieve_category_editdata($category_id);
		$data=array(
			'category_id' 			=> $category_detail[0]['category_id'],
			'category_name' 		=> $category_detail[0]['category_name'],
			'status' 				=> $category_detail[0]['status']
		);
		$chapterList = $CI->parser->parse('dashboard/category/edit_category_form',$data,true);
		return $chapterList;
	}

    public function forget_password_form()
    {
        $CI =& get_instance();
        $CI->load->model('web/customer/Signups');
        $CI->load->model('web/Homes');
        $CI->load->model('dashboard/web_settings');
        $CI->load->model('dashboard/Soft_settings');
        $CI->load->model('dashboard/Blocks');
        $CI->load->model('dashboard/themes');
        $theme = $CI->themes->get_theme();

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
            'title' 		=> display('forget_password'),
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

         $forget_page = APPPATH.'modules/web/views/themes/'.$theme.'/forget_password.php';
        if(file_exists($forget_page)){
            $HomeForm = $CI->parser->parse('web/themes/'.$theme.'/forget_password',$data,true);
        }else{
            $HomeForm = $CI->parser->parse('web/customer/forget_password',$data,true);
        }
        return $HomeForm;
    }

	
}
?>