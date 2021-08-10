<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ltax {

	//Retrieve  tax List	
	public function tax_list()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Taxs');
		$tax_list = $CI->Taxs->tax_product_list(); 

		$i=0;
		if(!empty($tax_list)){	
			foreach($tax_list as $k=>$v){$i++;
			   $tax_list[$k]['sl']=$i;
			}
		}

		$data = array(
				'title' => display('manage_tax'),
				'tax_list' => $tax_list,
			);
		$customerList = $CI->parser->parse('dashboard/tax/tax',$data,true);
		return $customerList;
	}

	//tax Edit Data
	public function tax_edit_data($t_p_s_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Taxs');
		$tax_details 	= $CI->Taxs->retrieve_tax_editdata($t_p_s_id);

		$product_list 	= $CI->Taxs->product_list();
		$tax_list 		= $CI->Taxs->tax_list();

		$tax_id 		= $tax_details[0]['tax_id'];
		$product_id 	= $tax_details[0]['product_id'];

		$selected_tax = $CI->Taxs->selected_tax($tax_id);
		$selected_product = $CI->Taxs->selected_product($product_id);

		$data=array(
			'title' 		=> display('tax_edit'),
			't_p_s_id' 		=> $t_p_s_id,
			'tax_list' 		=> $tax_list,
			'selected_tax' 	=> $selected_tax,
			'selected_product' 	=> $selected_product,
			'product_list' 	=> $product_list,
			'tax_id' 		=> $tax_details[0]['tax_id'],
			'tax_name' 		=> $tax_details[0]['tax_name'],
			'tax_percentage'=> $tax_details[0]['tax_percentage'],
			);
		$chapterList = $CI->parser->parse('dashboard/tax/edit_tax',$data,true);
		return $chapterList;
	}	

	//tax Edit Data
	public function tax_product_update_form($t_p_s_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Taxs');
		$tax_details 	= $CI->Taxs->retrieve_tax_editdata($t_p_s_id);

		$product_list 	= $CI->Taxs->product_list();
		$tax_list 		= $CI->Taxs->tax_list();

		$tax_id 		= $tax_details[0]['tax_id'];
		$product_id 	= $tax_details[0]['product_id'];

		$selected_tax = $CI->Taxs->selected_tax($tax_id);
		$selected_product = $CI->Taxs->selected_product($product_id);

		$data=array(
			'title' 		=> display('tax_edit'),
			't_p_s_id' 		=> $t_p_s_id,
			'tax_list' 		=> $tax_list,
			'selected_tax' 	=> $selected_tax,
			'selected_product' 	=> $selected_product,
			'product_list' 	=> $product_list,
			'tax_id' 		=> $tax_details[0]['tax_id'],
			'tax_name' 		=> $tax_details[0]['tax_name'],
			'tax_percentage'=> $tax_details[0]['tax_percentage'],
			);
		$chapterList = $CI->parser->parse('dashboard/tax/edit_product_tax',$data,true);
		return $chapterList;
	}
	//Tax product service
	public function tax_product_service(){
		$CI =& get_instance();
		$CI->load->model('dashboard/Taxs');
		$product_list = $CI->Taxs->product_list();
		$tax_list = $CI->Taxs->tax_list_except_empty();

		$data=array(
			'title' 		=> display('tax_product_service'),
			'product_list' 	=> $product_list,
			'tax_list' 		=> $tax_list,
			);
		$chapterList = $CI->parser->parse('dashboard/tax/tax_product_service',$data,true);
		return $chapterList;
	}	

	//Tax setting
	public function tax_setting(){
		$CI =& get_instance();
		$CI->load->model('dashboard/Taxs');
		$tax_list 	= $CI->Taxs->tax_list(); 

		$data=array(
			'title' 		=> display('tax_setting'),
			'tax_list' 		=> $tax_list,
			);
		$chapterList = $CI->parser->parse('dashboard/tax/tax_setting',$data,true);
		return $chapterList;
	}
}
?>