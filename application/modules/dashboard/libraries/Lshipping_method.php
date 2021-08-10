<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lshipping_method {
	//Add shipping_method
	public function shipping_method_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Shipping_methods');
		$CI->load->model('dashboard/Categories');

		$category_list = $CI->Categories->category_list(); 

		$data = array(
				'title' => display('add_shipping_method'),
				'category_list' => $category_list,
			);
		$customerForm = $CI->parser->parse('dashboard/shipping_method/add_shipping_method',$data,true);
		return $customerForm;
	}

	//Retrieve shipping_method List	
	public function shipping_method_list()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Shipping_methods');
		$shipping_method_list = $CI->Shipping_methods->shipping_method_list(); 

		$i=0;
		if(!empty($shipping_method_list)){	
			foreach($shipping_method_list as $k=>$v){$i++;
			   $shipping_method_list[$k]['sl']=$i;
			}
		}

		$data = array(
				'title' => display('manage_shipping_method'),
				'shipping_method_list' => $shipping_method_list,
			);
		$customerList = $CI->parser->parse('dashboard/shipping_method/shipping_method',$data,true);
		return $customerList;
	}

	//shipping_method Edit Data
	public function shipping_method_edit_data($method_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Shipping_methods');
		$CI->load->model('dashboard/Categories');
		$category_list = $CI->Categories->category_list();

		$shipping_method_details = $CI->Shipping_methods->retrieve_shipping_method_editdata($method_id);
	
		$data=array(
			'title' 		=> display('shipping_method_edit'),
			'method_id' 	=> $shipping_method_details[0]['method_id'],
			'method_name' 	=> $shipping_method_details[0]['method_name'],
			'details' 		=> $shipping_method_details[0]['details'],
			'charge_amount' => $shipping_method_details[0]['charge_amount'],
			'position' 		=> $shipping_method_details[0]['position'],
			
			);
		$chapterList = $CI->parser->parse('dashboard/shipping_method/edit_shipping_method',$data,true);
		return $chapterList;
	}
}
?>