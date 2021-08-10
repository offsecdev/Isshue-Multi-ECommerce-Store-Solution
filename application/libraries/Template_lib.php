<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Template_lib{

	//Admin Html View....
	public function full_admin_html_view($content){
	
		$CI =& get_instance();
		$CI->load->model('template/template_model');
		$data['content'] = $content;

		$id = $CI->session->userdata('id');
		$data['notifications'] = $CI->template_model->notifications($id);
		$data['quick_messages'] = $CI->template_model->messages($id);
		$data['setting'] = $CI->template_model->setting();
		$content = $CI->parser->parse('template/admin_html_template',$data);
	}	

	//Customer Html View....
	public function full_customer_html_view($content){

        $CI =& get_instance();
		$CI->load->model(array('dashboard/Soft_settings'));
		$data['template_lib'] = 'yes';
		$data['content'] = $content;
		$data['Soft_settings'] = $CI->Soft_settings->retrieve_setting_editdata();
		$content = $CI->parser->parse('web/customer/customer_html_template',$data);

	}
	
	//Theme Html View....
	public function full_website_html_view($content){

		$CI =& get_instance();
		$CI->load->model(array('template/template_model','dashboard/Products','dashboard/Themes','dashboard/Web_settings','dashboard/color_frontends','dashboard/pay_withs'));

		$data['template_lib'] = 'yes';
		$data['content'] = $content;
		$data['Web_settings'] = $CI->Web_settings->retrieve_setting_editdata();
		$data['colors'] = $CI->color_frontends->retrieve_color_editdata();
		$data['theme'] = $CI->Themes->get_theme();
		$data['pay_withs'] = $CI->pay_withs->pay_with_list_for_homepage();

		$data['company_info']=$CI->Products->retrieve_company();
		$content = $CI->load->view('web/themes/' . $data['theme'] . '/website_html_template', $data);

	}

}

