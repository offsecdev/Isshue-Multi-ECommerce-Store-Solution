<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lreceipt {
	// Retrieve  receipt List From DB 
	public function receipt_list($limit,$page,$links)
	{
		$CI =& get_instance();
		$CI->load->model('Receipts');
		$CI->load->library('occational');
		$receipt_list = $CI->Receipts->receipt_list($limit,$page);
		if(!empty($receipt_list)){
			$i=$page;
			foreach($receipt_list as $k=>$v){$i++;
			   $receipt_list[$k]['sl']=$i;
			}
			foreach($receipt_list as $k=>$v){
				$receipt_list[$k]['final_date'] = $CI->occational->dateConvert($receipt_list[$k]['date']);
			}
		}
		$data = array(
				'title' => 'Receipt List',
				'receipt_list' => $receipt_list,
				'links' => $links
			);
		$receiptList = $CI->parser->parse('receipt/receipt',$data,true);
		return $receiptList;
	}
	//Search Receipt By Customer Name
	public function search_receipt_item($customer_id)
	{
		$CI =& get_instance();
		$CI->load->model('Receipts');
		$CI->load->library('occational');
		$receipt_list = $CI->Receipts->search_receipt_item($customer_id);
		if(!empty($receipt_list)){
			$i=0;
			foreach($receipt_list as $k=>$v){$i++;
			   $receipt_list[$k]['sl']=$i;
			}
			foreach($receipt_list as $k=>$v){
				$receipt_list[$k]['final_date'] = $CI->occational->dateConvert($receipt_list[$k]['date']);
			}
		}
		$data = array(
				'title' => 'Receipt List',
				'receipt_list' => $receipt_list
			);
		$receiptList = $CI->parser->parse('receipt/receipt',$data,true);
		return $receiptList;
	}
	//Sub Category Add
	public function receipt_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('Receipts');
		$data = array(
				'title' => 'Add receipt'
			);
		$receiptForm = $CI->parser->parse('receipt/add_receipt_form',$data,true);
		return $receiptForm;
	}
	public function insert_receipt($data)
	{
		$CI =& get_instance();
		$CI->load->model('Receipts');
        $CI->Receipts->receipt_entry($data);
		return true;
	}
	//receipt Edit Data
	public function receipt_edit_data($receipt_id)
	{
		$CI =& get_instance();
		$CI->load->model('Receipts');
		$receipt_detail = $CI->Receipts->retrieve_receipt_editdata($receipt_id);	
		$data=array(
			'transaction_id' => $receipt_detail[0]['transaction_id'],
			'customer_id' 	=> $receipt_detail[0]['customer_id'],
			'customer_name' => $receipt_detail[0]['customer_name'],
			'description' 	=> $receipt_detail[0]['description'],
			'receipt_no' 	=> $receipt_detail[0]['receipt_no'],
			'amount' 		=> $receipt_detail[0]['amount'],
			'date' 		=> $receipt_detail[0]['date']
		);
		$chapterList = $CI->parser->parse('receipt/edit_receipt_form',$data,true);
		return $chapterList;
	}
	//Search receipt
	public function receipt_search_list($cat_id,$company_id)
	{
		$CI =& get_instance();
		$CI->load->model('Receipts');
		$category_list = $CI->Receipts->retrieve_category_list();
		$receipts_list = $CI->Receipts->receipt_search_list($cat_id,$company_id);
		$data = array(
				'title' => 'Receipts List',
				'receipts_list' => $receipts_list,
				'category_list' => $category_list
			);
		$receiptList = $CI->parser->parse('receipt/receipt',$data,true);
		return $receiptList;
	}
}
?>