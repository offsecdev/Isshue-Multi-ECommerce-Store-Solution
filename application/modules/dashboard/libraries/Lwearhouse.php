<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lwearhouse {
	//Add wearhouse
	public function wearhouse_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('Wearhouses');
		$data = array(
				'title' => display('add_wearhouse')
			);
		$customerForm = $CI->parser->parse('wearhouse/add_wearhouse',$data,true);
		return $customerForm;
	}	
	//Add wearhouse product
	public function wearhouse_transfer_form()
	{
		$CI =& get_instance();
		$CI->load->model('Wearhouses');
		$CI->load->model('Products');
		$CI->load->model('Variants');
		$wearhouse_list   = $CI->Wearhouses->wearhouse_list();
		$product_list = $CI->Products->product_list();
		$variant_list = $CI->Variants->variant_list();

		$data = array(
				'title' => display('wearhouse_transfer'),
				'wearhouse_list' => $wearhouse_list,
				'product_list' => $product_list,
				'variant_list' => $variant_list,
			);
		$wearhouse_product = $CI->parser->parse('wearhouse/wearhouse_transfer',$data,true);
		return $wearhouse_product;
	}

	//Retrieve  wearhouse List	
	public function wearhouse_list()
	{
		$CI =& get_instance();
		$CI->load->model('Wearhouses');
		$wearhouse_list = $CI->Wearhouses->wearhouse_list();

		$i=0;
		if(!empty($wearhouse_list)){	
			foreach($wearhouse_list as $k=>$v){$i++;
			   $wearhouse_list[$k]['sl']=$i;
			}
		}

		$data = array(
				'title' => display('manage_wearhouse'),
				'wearhouse_list' => $wearhouse_list,
			);
		$customerList = $CI->parser->parse('wearhouse/wearhouse',$data,true);
		return $customerList;
	}

	//Retrieve  wearhouse product List	
	public function wearhouse_product_list()
	{
		$CI =& get_instance();
		$CI->load->model('Wearhouses');
		$wearhouse_product_list = $CI->Wearhouses->wearhouse_list_with_product(); 

		$i=0;
		if(!empty($wearhouse_product_list)){	
			foreach($wearhouse_product_list as $k=>$v){$i++;
			   $wearhouse_product_list[$k]['sl']=$i;
			}
		}

		$data = array(
				'title' => display('manage_wearhouse_product'),
				'wearhouse_product_list' => $wearhouse_product_list,
			);
		$customerList = $CI->parser->parse('wearhouse/manage_wearhosue_product',$data,true);
		return $customerList;
	}

	//wearhouse Edit Data
	public function wearhouse_edit_data($wearhouse_id)
	{
		$CI =& get_instance();
		$CI->load->model('Wearhouses');
		$wearhouse_details = $CI->Wearhouses->retrieve_wearhouse_editdata($wearhouse_id);
	
		$data=array(
			'title' 		=> display('wearhouse_edit'),
			'wearhouse_id' 		=> $wearhouse_details[0]['wearhouse_id'],
			'wearhouse_name' 	=> $wearhouse_details[0]['wearhouse_name'],
			'wearhouse_address' => $wearhouse_details[0]['wearhouse_address']
			);
		$chapterList = $CI->parser->parse('wearhouse/edit_wearhouse',$data,true);
		return $chapterList;
	}	
	//wearhouse Product Edit Data
	public function wearhouse_product_edit_data($wearhouse_product_id)
	{
		$CI =& get_instance();
		$CI->load->model('Wearhouses');
		$CI->load->model('Products');
		$CI->load->model('Variants');
		$wearhouse_details = $CI->Wearhouses->retrieve_wearhouse_product_editdata($wearhouse_product_id);

		$wearhouse_id = $wearhouse_details[0]['wearhouse_id'];
		$product_id = $wearhouse_details[0]['product_id'];
		$variant_id = $wearhouse_details[0]['variant_id'];
		$tax_id = $wearhouse_details[0]['tax_id'];


		$wearhouse_list   = $CI->Wearhouses->wearhouse_list();
		$product_list = $CI->Products->product_list();
		$variant_list = $CI->Variants->variant_list();
		$tax_list = $CI->Wearhouses->tax_list();

		$wearhouse_list_selected = $CI->Wearhouses->wearhouse_list_selected($wearhouse_id);
		$product_list_selected = $CI->Wearhouses->product_list_selected($product_id);
		$variant_list_selected = $CI->Wearhouses->variant_list_selected($variant_id);
		$tax_list_selected = $CI->Wearhouses->tax_list_selected($tax_id);

		
		$data=array(
			'title' 		=> display('wearhouse_product_edit'),
			'wearhouse_product_id' 	=> $wearhouse_details[0]['wearhouse_product_id'],
			'quantity' 	=> $wearhouse_details[0]['quantity'],
			'wearhouse_list' => $wearhouse_list,
			'product_list' => $product_list,
			'variant_list' => $variant_list,
			'tax_list' => $tax_list,
			'wearhouse_list_selected' => $wearhouse_list_selected,
			'product_list_selected' => $product_list_selected,
			'variant_list_selected' => $variant_list_selected,
			'tax_list_selected' => $tax_list_selected,
			);
		$chapterList = $CI->parser->parse('wearhouse/edit_wearhouse_product',$data,true);
		return $chapterList;
	}
}
?>