<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Linvoice {
		//Retrieve  Invoice List
	public function invoice_list()
	{
		$CI =& get_instance();
		$CI->load->model('web/customer/Invoices');
		$CI->load->model('dashboard/Soft_settings');
		$CI->load->library('dashboard/occational');
		
		$invoices_list = $CI->Invoices->invoice_list();
		if(!empty($invoices_list)){
			foreach($invoices_list as $k=>$v){
				$invoices_list[$k]['final_date'] = $CI->occational->dateConvert($invoices_list[$k]['date']);
			}
			$i=0;
			foreach($invoices_list as $k=>$v){$i++;
			   $invoices_list[$k]['sl']=$i;
			}
		}
		$currency_details = $CI->Soft_settings->retrieve_currency_info();
		$data = array(
				'title' => display('manage_invoice'),
				'invoices_list' => $invoices_list,
				'currency' => $currency_details[0]['currency_icon'],
				'position' => $currency_details[0]['currency_position'],
			);
		$invoiceList = $CI->parser->parse('web/customer/invoice/invoice',$data,true);
		return $invoiceList;
	}

	//Invoice html Data
	public function invoice_html_data($invoice_id)
	{
		$CI =& get_instance();
		$CI->load->model('web/customer/Invoices');
		$CI->load->model('web/customer/Orders');
		$CI->load->model('dashboard/Soft_settings');
		$CI->load->model('dashboard/Shipping_methods');
		$CI->load->library('dashboard/occational');
		$invoice_detail = $CI->Invoices->retrieve_invoice_html_data($invoice_id);

 		$shipping_method = $CI->Shipping_methods->shipping_method_search_item($invoice_detail[0]['shipping_method']);

		$subTotal_quantity = 0;
		$subTotal_cartoon = 0;
		$subTotal_discount = 0;

		if(!empty($invoice_detail)){
			foreach($invoice_detail as $k=>$v){
				$invoice_detail[$k]['final_date'] = $CI->occational->dateConvert($invoice_detail[$k]['date']);
				$subTotal_quantity = $subTotal_quantity+$invoice_detail[$k]['quantity'];
			}
			$i=0;
			foreach($invoice_detail as $k=>$v){$i++;
			   $invoice_detail[$k]['sl']=$i;
			}
		}

		$currency_details = $CI->Soft_settings->retrieve_currency_info();
		$company_info = $CI->Orders->retrieve_company();
		$data=array(
			'title'				=>	display('invoice_details'),
			'invoice_id'		=>	$invoice_detail[0]['invoice_id'],
			'invoice_no'		=>	$invoice_detail[0]['invoice'],
			'customer_name'		=>	$invoice_detail[0]['customer_name'],
			'customer_mobile'	=>	$invoice_detail[0]['customer_mobile'],
			'customer_email'	=>	$invoice_detail[0]['customer_email'],
			'final_date'		=>	$invoice_detail[0]['final_date'],
			'total_amount'		=>	$invoice_detail[0]['total_amount'],
			'invoice_discount'	=>	$invoice_detail[0]['invoice_discount'],
			'total_discount'	=>	$invoice_detail[0]['total_discount'],
			'service_charge'	=>	$invoice_detail[0]['service_charge'],
			'shipping_charge'	=>	$invoice_detail[0]['shipping_charge'],
			'shipping_method'	=>  $shipping_method[0]['method_name'],
			'paid_amount'		=>	$invoice_detail[0]['paid_amount'],
			'due_amount'		=>	$invoice_detail[0]['due_amount'],
			'details'			=>	$invoice_detail[0]['invoice_details'],
			'subTotal_quantity'	=>	$subTotal_quantity,
			'invoice_all_data'	=>	$invoice_detail,
			'company_info'		=>	$company_info,
			'currency' 			=> $currency_details[0]['currency_icon'],
			'position' 			=> $currency_details[0]['currency_position'],
			);

		$chapterList = $CI->parser->parse('web/customer/invoice/invoice_html',$data,true);
		return $chapterList;
	}
}
?>