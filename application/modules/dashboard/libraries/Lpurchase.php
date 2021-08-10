<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lpurchase {

	//Purchase add form
	public function purchase_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Purchases');
		$CI->load->model('dashboard/Stores');
		$CI->load->model('dashboard/Variants'); 
		$all_supplier 	= $CI->Purchases->select_all_supplier();
		$store_list 	= $CI->Stores->store_list();
		$variant_list 	= $CI->Variants->variant_list();

		$data = array(
				'title'			 => display('add_purchase'),
				'all_supplier' 	 => $all_supplier,
				'store_list' 	 => $store_list,
				'variant_list'	 => $variant_list,
			);
		
		$purchaseForm = $CI->parser->parse('purchase/add_purchase_form',$data,true);
		return $purchaseForm;
	}

	//Insert purchase item
	public function insert_purchase($data)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Purchases');
        $CI->Purchases->purchase_entry($data);
		return true;
	}

	// Purchase List
	public function purchase_list()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Purchases');
		$CI->load->model('dashboard/Soft_settings');
		$CI->load->library('dashboard/occational');
		$purchases_list = $CI->Purchases->purchase_list();
		if(!empty($purchases_list)){	
			$j=0;
			foreach($purchases_list as $k=>$v){
				$purchases_list[$k]['final_date'] = $CI->occational->dateConvert($purchases_list[$j]['purchase_date']);
			  $j++;
			}
		
			$i=0;
			foreach($purchases_list as $k=>$v){$i++;
			   $purchases_list[$k]['sl']=$i;
			}
		}
		$currency_details = $CI->Soft_settings->retrieve_currency_info();
		$data = array(
				'title' => display('manage_purchase'),
				'purchases_list' => $purchases_list,
				'currency' => $currency_details[0]['currency_icon'],
				'position' => $currency_details[0]['currency_position'],
			);

		$purchaseList = $CI->parser->parse('purchase/purchase',$data,true);
		return $purchaseList;
	}

	//Purchase Edit Data
	public function purchase_edit_data($purchase_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Purchases');
		$CI->load->model('dashboard/Suppliers');
		$CI->load->model('dashboard/Wearhouses');
		$CI->load->model('dashboard/Stores');
		$CI->load->model('dashboard/Variants');

		$purchase_detail 	= $CI->Purchases->retrieve_purchase_editdata($purchase_id);
		$supplier_id 		= $purchase_detail[0]['supplier_id'];
		$supplier_list 		= $CI->Suppliers->supplier_list();
		$supplier_selected 	= $CI->Suppliers->supplier_search_item($supplier_id);

		$wearhouse_list = $CI->Wearhouses->wearhouse_list();
		$store_list 	= $CI->Stores->store_list();
		$variant_list 	= $CI->Variants->variant_list();

		if(!empty($purchase_detail)){
			$i=0;
			foreach($purchase_detail as $k=>$v){$i++;
			   $purchase_detail[$k]['sl']=$i;
			}
		}
		
		$data=array(
			'title'				=> display('purchase_edit'),
			'purchase_id'		=>	$purchase_detail[0]['purchase_id'],
			'invoice_no'		=>	$purchase_detail[0]['invoice_no'],
			'supplier_name'		=>	$purchase_detail[0]['supplier_name'],
			'supplier_id'		=>	$purchase_detail[0]['supplier_id'],
			'grand_total'		=>	$purchase_detail[0]['grand_total_amount'],
			'purchase_details'	=>	$purchase_detail[0]['purchase_details'],
			'purchase_date'		=>	$purchase_detail[0]['purchase_date'],
			'store_id'			=>	$purchase_detail[0]['store_id'],
			'wearhouse_id'		=>	$purchase_detail[0]['wearhouse_id'],
			'variant_id'		=>	$purchase_detail[0]['variant_id'],
			'purchase_info'		=>	$purchase_detail,
			'supplier_list'		=>	$supplier_list,
			'supplier_selected'	=>	$supplier_selected,
			'wearhouse_list'	=>	$wearhouse_list,
			'store_list'		=>	$store_list,
			'variant_list'		=>	$variant_list,
			);
		$chapterList = $CI->parser->parse('purchase/edit_purchase_form',$data,true);
		return $chapterList;
	}
	//Purchase Item By Search
	public function purchase_by_search($supplier_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Purchases');
		$CI->load->library('dashboard/occational');
		$purchases_list = $CI->Purchases->purchase_by_search($supplier_id);
		$j=0;
		if(!empty($purchases_list)){
			foreach($purchases_list as $k=>$v){
				$purchases_list[$k]['final_date'] = $CI->occational->dateConvert($purchases_list[$j]['purchase_date']);
			  $j++;
			}
			$i=0;
			foreach($purchases_list as $k=>$v){$i++;
			   $purchases_list[$k]['sl']=$i;
			}
		}
		$data = array(
				'purchases_list' => $purchases_list
			);
		$purchaseList = $CI->parser->parse('purchase/purchase',$data,true);
		return $purchaseList;
	}	
	//Search purchase list
	public function purchase_search_list($cat_id,$company_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Purchases');
		$category_list = $CI->Purchases->retrieve_category_list();
		$purchases_list = $CI->Purchases->purchase_search_list($cat_id,$company_id);
		$data = array(
				'title' => display('manage_purchase'),
				'purchases_list' => $purchases_list,
				'category_list' => $category_list
			);
		$purchaseList = $CI->parser->parse('purchase/purchase',$data,true);
		return $purchaseList;
	}
	//Purchase details Data
	public function purchase_details_data($purchase_id)
	{
	
		$CI =& get_instance();
		$CI->load->model('dashboard/Purchases');
		$CI->load->model('dashboard/Soft_settings');
		$CI->load->library('dashboard/occational');
	
		$purchase_detail = $CI->Purchases->purchase_details_data($purchase_id);
		if(!empty($purchase_detail)){
			$i = 0;
			foreach($purchase_detail as $k=>$v){$i++;
			   $purchase_detail[$k]['sl']=$i;
			}
			
			foreach($purchase_detail as $k=>$v){
			   $purchase_detail[$k]['convert_date'] = $CI->occational->dateConvert($purchase_detail[$k]['purchase_date']);
			}
			
		}
		$currency_details = $CI->Soft_settings->retrieve_currency_info();
		$company_info = $CI->Purchases->retrieve_company();
		$data=array(
			'title'				=> 	display('purchase_ledger'),
			'purchase_id'		=>	$purchase_detail[0]['purchase_id'],
			'purchase_details'	=>	$purchase_detail[0]['purchase_details'],
			'supplier_name'		=>	$purchase_detail[0]['supplier_name'],
			'final_date'		=>	$purchase_detail[0]['convert_date'],
			'sub_total_amount'	=>	$purchase_detail[0]['grand_total_amount'],
			'invoice_no'		=>	$purchase_detail[0]['invoice_no'],
			'purchase_all_data'	=>	$purchase_detail,
			'company_info'		=>	$company_info,
			'currency' 			=> 	$currency_details[0]['currency_icon'],
			'position' 			=> 	$currency_details[0]['currency_position'],
			);
		$chapterList = $CI->parser->parse('purchase/purchase_detail',$data,true);
		return $chapterList;
	}
}
?>