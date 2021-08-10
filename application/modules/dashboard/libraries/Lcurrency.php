<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lcurrency {
	//Add currency
	public function currency_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Currencies');
		$data = array(
				'title' => display('add_currency')
			);
		$customerForm = $CI->parser->parse('dashboard/currency/add_currency',$data,true);
		return $customerForm;
	}

	//Retrieve  currency List	
	public function currency_list()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Currencies');
		$currency_list = $CI->Currencies->currency_list(); 

		$i=0;
		if(!empty($currency_list)){	
			foreach($currency_list as $k=>$v){$i++;
			   $currency_list[$k]['sl']=$i;
			}
		}

		$data = array(
				'title' => display('manage_currency'),
				'currency_list' => $currency_list,
			);
		$customerList = $CI->parser->parse('dashboard/currency/currency',$data,true);
		return $customerList;
	}

	//currency Edit Data
	public function currency_edit_data($currency_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Currencies');
		$currency_details = $CI->Currencies->retrieve_currency_editdata($currency_id);
	
		$data=array(
			'title' 			=> display('currency_edit'),
			'currency_id' 		=> $currency_details[0]['currency_id'],
			'currency_name' 	=> $currency_details[0]['currency_name'],
			'currency_icon' 	=> $currency_details[0]['currency_icon'],
			'currency_position' => $currency_details[0]['currency_position'],
			'convertion_rate' 	=> $currency_details[0]['convertion_rate'],
			'default_status' 	=> $currency_details[0]['default_status']
			);
		$chapterList = $CI->parser->parse('dashboard/currency/edit_currency',$data,true);
		return $chapterList;
	}
}
?>