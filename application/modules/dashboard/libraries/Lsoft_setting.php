<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lsoft_setting {
	//Setting add form
	public function setting_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Soft_settings');
		$setting_detail = $CI->Soft_settings->retrieve_setting_editdata();
		$language 		= $CI->Soft_settings->languages();
		$country_list 	= $CI->Soft_settings->get_country_list();
		$ses_lang 		= $CI->session->userdata('language');

		$data = array(
			'title' 		=> display('update_setting'),
			'logo' 			=> $setting_detail[0]['logo'],
			'invoice_logo' 	=> $setting_detail[0]['invoice_logo'],
			'favicon'		=> $setting_detail[0]['favicon'],
			'footer_text'	=> $setting_detail[0]['footer_text'],
			'language'		=> $language,
			'ses_lang'		=> $ses_lang,
			'rtr'			=> $setting_detail[0]['rtr'],
			'captcha'		=> $setting_detail[0]['captcha'],
			'site_key'		=> $setting_detail[0]['site_key'],
			'secret_key'	=> $setting_detail[0]['secret_key'],
			'sms_service'	=> $setting_detail[0]['sms_service'],
			'country_id'	=> $setting_detail[0]['country_id'],
			'country_list'	=> $country_list
		);
		$setting = $CI->parser->parse('dashboard/soft_setting/soft_setting',$data,true);
		return $setting;
	}

	//Email config update form
	public function email_configuration_form(){
		$CI =& get_instance();
		$CI->load->model('dashboard/Soft_settings');
		$setting_detail = $CI->Soft_settings->retrieve_email_editdata();
		$data = array(
			'title' 		=> display('email_configuration'),
			'email_id' 		=> $setting_detail[0]['email_id'],
			'protocol' 		=> $setting_detail[0]['protocol'],
			'mailtype'		=> $setting_detail[0]['mailtype'],
			'smtp_host'		=> $setting_detail[0]['smtp_host'],
			'smtp_port'		=> $setting_detail[0]['smtp_port'],
			'sender_email'	=> $setting_detail[0]['sender_email'],
			'password'		=> $setting_detail[0]['password'],
		);
		$setting = $CI->parser->parse('dashboard/soft_setting/email_configuration',$data,true);
		return $setting;
	}	


	//sms config update form for sending sms
	public function sms_configuration_form(){
		$CI =& get_instance();
		$CI->load->model('dashboard/Soft_settings');
		$setting_detail = $CI->Soft_settings->retrieve_sms_editdata();
		$data = array(
			'gateways' => $setting_detail	
		);
		
		$setting = $CI->parser->parse('dashboard/sms/sms_configuration',$data,true);
		return $setting;
	}	

	//Payment config update form
	public function payment_configuration_form(){
		$CI =& get_instance();
		$CI->load->model('dashboard/Soft_settings');
		$setting_detail = $CI->Soft_settings->retrieve_payment_editdata();

		$currency_list = array(
			'USD' => '(USD) U.S. Dollar', 
			'EUR' => '(EUR) Euro', 
			'AUD' => '(AUD) Australian Dollar',
			'CAD' => '(CAD) Canadian Dollar',
			'CZK' => '(CZK) Czech Koruna',
			'DKK' => '(DKK) Danish Krone',
			'HKD' => '(HKD) Hong Kong Dollar',
			'MXN' => '(MXN) Mexican Peso',
			'NOK' => '(NOK) Norwegian Krone',
			'NZD' => '(NZD) New Zealand Dollar',
			'PHP' => '(PHP) Philippine Peso',
			'PLN' => '(PLN) Polish Zloty',
			'BRL' => '(BRL) Brazilian Real',
			'HUF' => '(HUF) Hungarian Forint',
			'ILS' => '(ILS) Israeli New Sheqel',
			'JPY' => '(JPY) Japanese Yen',
			'MYR' => '(MYR) Malaysian Ringgit',
			'GBP' => '(GBP) Pound Sterling',
			'SGD' => '(SGD) Singapore Dollar',
			'SEK' => '(SEK) Swedish Krona',
			'CHF' => '(CHF) Swiss Franc',
			'TWD' => '(TWD) Taiwan New Dollar',
			'THB' => '(THB) Thai Baht',
			'BDT' => '(BDT) Bangladeshi Taka',
		);
		$data = array(
			'title' 		=> display('payment_gateway_setting'),
			'setting_detail'=> $setting_detail,
			'currency_list' => $currency_list,
		);
		$setting = $CI->parser->parse('dashboard/soft_setting/payment_gateway_setting',$data,true);
		return $setting;
	}



	//front end color edit form
	public function color_frontend_edit_form(){
		$CI =& get_instance();
		$CI->load->model('dashboard/Color_frontends');
		$CI->load->model('dashboard/Themes');
		$themes = $CI->Themes->get_themes();
		$active_theme = $CI->Themes->get_theme();
		$colors = $CI->Color_frontends->retrieve_color_editdata($active_theme);

		$data = array(			
			'themelist' 	=> $themes,
			'active_theme' 	=> $colors->theme,
			'color1' 		=> $colors->color1,
			'color2' 		=> $colors->color2,
			'color3' 		=> $colors->color3,			
			'color4' 		=> $colors->color4,			
			'color5' 		=> $colors->color5,			
		);
		$setting = $CI->parser->parse('dashboard/soft_setting/color_frontend',$data,true);
		return $setting;
	}
		//front end color edit form
	public function color_backend_edit_form()
	{
        $CI =& get_instance();
		$CI->load->model('dashboard/Color_backends');
		$colors = $CI->Color_backends->retrieve_color_editdata();
		
		$data = array(			
			'color1' 		=> @$colors->color1,
			'color2' 		=> @$colors->color2,
			'color3' 		=> @$colors->color3,			
			'color4' 		=> @$colors->color4,			
			'color5' 		=> @$colors->color5,			
		);
		$setting = $CI->parser->parse('dashboard/soft_setting/color_backend',$data,true);
		return $setting;
	}
}
?>