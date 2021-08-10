<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lweb_setting {	

	//Contact Form
	public function contact_form()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Web_settings');

		$data = array(
			'title' => display('contact_form'),
		);
		$setting = $CI->parser->parse('dashboard/web_setting/contact_form',$data,true);
		return $setting;
	}	

	//Manage contact form
	public function manage_contact_form()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Web_settings');

		$contact_list = $CI->Web_settings->manage_contact_form();

		$data = array(
			'title' 	   => display('manage_contact'),
			'contact_list' => $contact_list,
		);
		$setting = $CI->parser->parse('dashboard/web_setting/contact',$data,true);
		return $setting;
	}

	//Contact Edit Data
	public function contact_update_form($id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Web_settings');
		$contact_details = $CI->Web_settings->contact_update_form($id);

		$data=array(
			'title' 	=> display('update_contact_form'),
			'id' 		=> $contact_details[0]['id'],
			'first_name'=> $contact_details[0]['first_name'],
			'last_name' => $contact_details[0]['last_name'],
			'email' 	=> $contact_details[0]['email'],
			'message' 	=> $contact_details[0]['message'],
			);
		$chapterList = $CI->parser->parse('dashboard/web_setting/edit_contact_form',$data,true);
		return $chapterList;
	}


	//Setting Edit Data
	public function setting()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Web_settings');
		$setting = $CI->Web_settings->setting();

		$data=array(
			'title' 	  	  => display('web_settings'),
			'logo' 	  		  => $setting[0]['logo'],
			'invoice_logo' 	  => $setting[0]['invoice_logo'],
			'favicon' 	  	  => $setting[0]['favicon'],
			'footer_logo' 	  => $setting[0]['footer_logo'],
			'footer_text' 	  => $setting[0]['footer_text'],
			'footer_details'  => $setting[0]['footer_details'],
			'google_analytics'=> $setting[0]['google_analytics'],
			'facebook_messenger'=> $setting[0]['facebook_messenger'],
			'meta_keyword'    =>$setting[0]['meta_keyword'],
			'meta_description'=> $setting[0]['meta_description'],
			'app_link_status' => $setting[0]['app_link_status'],
			'pay_with' 	  	  => $setting[0]['pay_with_status'],
			'setting_id' 	  => $setting[0]['setting_id'],
			'map_api_key' 	  => $setting[0]['map_api_key'],
			'map_latitude' 	  => $setting[0]['map_latitude'],
			'map_langitude'   => $setting[0]['map_langitude'],
			'mob_footer_block'  => $setting[0]['mob_footer_block'],
			'social_share'  => $setting[0]['social_share']
			);
		$chapterList = $CI->parser->parse('dashboard/web_setting/web_setting',$data,true);
		return $chapterList;
	}

	//Add Slider
	public function add_slider()
	{
		$CI =& get_instance();
		$categories = $CI->web_settings->get_all_category();
		$data = array(
			'title' => display('add_slider'),
			'categories' => $categories
		);
		$setting = $CI->parser->parse('dashboard/web_setting/add_slider',$data,true);
		return $setting;
	}	

	//Slider List
	public function slider_list()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Web_settings');
		$slider_list = $CI->web_settings->slider_list();

		$i=0;
		if(!empty($slider_list)){	
			foreach($slider_list as $k=>$v){$i++;
			   $slider_list[$k]['sl']=$i;
			}
		}

		$data = array(
				'title' => display('manage_slider'),
				'slider_list' => $slider_list,
			);
		$customerList = $CI->parser->parse('dashboard/web_setting/slider',$data,true);
		return $customerList;
	}

	//Slider Edit Data
	public function slider_edit_data($id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Web_settings');
		$slider_details = $CI->web_settings->slider_edit_data($id);
		$categories = $CI->web_settings->get_all_category();

		$data = array(
			'title' 	  	  => display('update_slider'),
			'slider_id' 	  => $slider_details[0]['slider_id'],
			'slider_link' 	  => $slider_details[0]['slider_link'],
			'slider_image' 	  => $slider_details[0]['slider_image'],
			'slider_position' => $slider_details[0]['slider_position'],
			'slider_category' => $slider_details[0]['slider_category'],
			'categories' => $categories
		);
		$customerList = $CI->parser->parse('dashboard/web_setting/edit_slider_form',$data,true);
		return $customerList;
	}

	//Add List
	public function add_list()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Web_settings');
		$add_list = $CI->web_settings->add_list();

		$i=0;
		if(!empty($add_list)){	
			foreach($add_list as $k=>$v){$i++;
			   $add_list[$k]['sl']=$i;
			}
		}

		$data = array(
				'title' => display('manage_advertise'),
				'add_list' => $add_list,
			);
		$customerList = $CI->parser->parse('dashboard/web_setting/advertise',$data,true);
		return $customerList;
	}

	//Add Edit Data
	public function add_edit_data($id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Web_settings');
		$add_details = $CI->web_settings->add_edit_data($id);


		$data = array(
			'title' 	  => display('update_advertise'),
			'adv_id' 	  => $add_details[0]['adv_id'],
			'add_page' 	  => $add_details[0]['add_page'],
			'adv_position'=> $add_details[0]['adv_position'],
			'adv_code' 	  => $add_details[0]['adv_code'],
			'adv_type' 	  => $add_details[0]['adv_type'],
			'advinfo' 	  => $add_details[0]
		);
		$customerList = $CI->parser->parse('dashboard/web_setting/edit_add_form',$data,true);
		return $customerList;
	}


    public function android_apps_view()
    {

        $CI =& get_instance();
        $CI->load->model('dashboard/Web_settings');
        $setting_detail = $CI->Web_settings->retrieve_setting_editdata();

        $data = array(
            'apps_url' 		=> $setting_detail[0]['apps_url']
        );
        $setting = $CI->parser->parse('dashboard/web_setting/android_apps_view',$data,true);
        return $setting;
    }
}
?>