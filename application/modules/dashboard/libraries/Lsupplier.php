<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lsupplier {

	//Supplier Add Form
	public function supplier_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Suppliers');
		$data = array(
				'title' => 'Add Supplier'
			);
		$supplierForm = $CI->parser->parse('supplier/add_supplier_form',$data,true);
		return $supplierForm;
	}
	//Supplier List
	public function supplier_list()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Suppliers');
		$suppliers_list = $CI->Suppliers->supplier_list();
		$i=0;
		if(!empty($suppliers_list)){	
			foreach($suppliers_list as $k=>$v){$i++;
			   $suppliers_list[$k]['sl']=$i;
			}
		}
		$data = array(
				'title' => display('manage_supplier'),
				'suppliers_list' => $suppliers_list,
			);
		$supplierList = $CI->parser->parse('supplier/supplier',$data,true);
		return $supplierList;
	}
	//Supplier Search Item
	public function supplier_search_item($supplier_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Suppliers');
		$suppliers_list = $CI->Suppliers->supplier_search_item($supplier_id);
		$i=0;
		if ($suppliers_list) {
			foreach($suppliers_list as $k=>$v){$i++;
           $suppliers_list[$k]['sl']=$i;
			}
			$data = array(
					'title' => 'Suppliers Search Items',
					'suppliers_list' => $suppliers_list
				);
			$supplierList = $CI->parser->parse('supplier/supplier',$data,true);
			return $supplierList;
		}else{
			redirect('dashboard/Csupplier/manage_supplier');
		}
	}
	//Product search by supplier
	public function product_by_search(){
		$CI =& get_instance();
		$CI->load->model('dashboard/Suppliers');
		$suppliers_list = $CI->Suppliers->product_search_item($supplier_id);
		$i=0;
		foreach($suppliers_list as $k=>$v){$i++;
           $suppliers_list[$k]['sl']=$i;
		}
		$data = array(
				'title' => 'Suppliers Search Items',
				'suppliers_list' => $suppliers_list
			);
		$supplierList = $CI->parser->parse('supplier/supplier',$data,true);
		return $supplierList;
	}
	//Insert new supplier
	public function insert_supplier($data)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Suppliers');
        $result = $CI->Suppliers->supplier_entry($data);
		if ($result == TRUE) {
			return TRUE;
		}else{
			return FALSE;
		}
	}
	//supplier Edit Data
	public function supplier_edit_data($supplier_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Suppliers');
		$supplier_detail = $CI->Suppliers->retrieve_supplier_editdata($supplier_id);
		$data=array(
			'supplier_id' 	=> $supplier_detail[0]['supplier_id'],
			'supplier_name' => $supplier_detail[0]['supplier_name'],
			'address' 		=> $supplier_detail[0]['address'],
			'email' 		=> $supplier_detail[0]['email'],
			'mobile' 		=> $supplier_detail[0]['mobile'],
			'details' 		=> $supplier_detail[0]['details'],
			'status' 		=> $supplier_detail[0]['status']
			);
		$chapterList = $CI->parser->parse('supplier/edit_supplier_form',$data,true);
		return $chapterList;
	}
	//Supplier Details Data
	public function supplier_detail_data($supplier_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Suppliers');
		$CI->load->model('dashboard/Soft_settings');
		$CI->load->library('occational');
		$supplier_detail = $CI->Suppliers->supplier_personal_data($supplier_id);
		$purchase_info 	= $CI->Suppliers->supplier_purchase_data($supplier_id);
		$total_amount = 0;
		if(!empty($purchase_info)){
			foreach($purchase_info as $k=>$v){
				$purchase_info[$k]['final_date'] = $CI->occational->dateConvert($purchase_info[$k]['purchase_date']);
				$total_amount = $total_amount+$purchase_info[$k]['grand_total_amount'];
			}
		}
		$currency_details = $CI->Soft_settings->retrieve_currency_info();
		$data=array(
			'supplier_id' 		=> $supplier_detail[0]['supplier_id'],
			'supplier_name' 	=> $supplier_detail[0]['supplier_name'],
			'supplier_address' 	=> $supplier_detail[0]['address'],
			'supplier_mobile' 	=> $supplier_detail[0]['mobile'],
			'details' 			=> $supplier_detail[0]['details'],
			'total_amount' 		=> number_format($total_amount, 2, '.', ','),
			'purchase_info' 	=> $purchase_info,
			'currency' 			=> $currency_details[0]['currency_icon'],
			'position' 			=> $currency_details[0]['currency_position'],		
			);
		$chapterList = $CI->parser->parse('supplier/supplier_details',$data,true);
		return $chapterList;
	}
	//Supplier Sales Data
	public function supplier_sales_data($supplier_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Suppliers');
		$CI->load->library('occational');
		$supplier_detail = $CI->Suppliers->supplier_personal_data($supplier_id);
		$sales_info 	= $CI->Suppliers->supplier_sales_data($supplier_id,null);
		
		if(!empty($sales_info)){
			foreach($sales_info as $k=>$v){
				$sales_info[$k]['date'] = $CI->occational->dateConvert($sales_info[$k]['date']);
			}
		}
		$data=array(
			'supplier_id' 		=> $supplier_detail[0]['supplier_id'],
			'supplier_name' 	=> $supplier_detail[0]['supplier_name'],
			'supplier_address' 	=> $supplier_detail[0]['address'],
			'supplier_mobile' 	=> $supplier_detail[0]['mobile'],
			'details' 			=> $supplier_detail[0]['details'],
			'sales_info' 		=> $sales_info,

			);
		$sales_report = $CI->parser->parse('supplier/supplier_sales_report',$data,true);
		return $sales_report;
	}
	//Ledger Book Maintaining information....
	public function supplier_ledger($supplier_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Suppliers');
		$CI->load->model('Soft_settings');
		$CI->load->library('occational');
		$supplier_details = $CI->Suppliers->supplier_personal_data($supplier_id);
		$ledger 	= $CI->Suppliers->suppliers_ledger($supplier_id);
		$summary 	= $CI->Suppliers->suppliers_transection_summary($supplier_id);
	
		$balance = 0;
		if(!empty($ledger)){
			foreach($ledger as $index=>$value){
				$ledger[$index]['final_date'] = $CI->occational->dateConvert($ledger[$index]['date']);
				
				if(!empty($ledger[$index]['invoice_no'])or  $ledger[$index]['invoice_no']=="NA")
				{
					$ledger[$index]['credit']=$ledger[$index]['amount'];
					$ledger[$index]['balance']=$balance-$ledger[$index]['amount'];
					$ledger[$index]['debit']="";
					$balance=$ledger[$index]['balance'];
				}
				else
				{
					$ledger[$index]['debit']=$ledger[$index]['amount'];
					$ledger[$index]['balance']=$balance+$ledger[$index]['amount'];
					$ledger[$index]['credit']="";
					$balance=$ledger[$index]['balance'];
				}
				
			}
		}
		$currency_details = $CI->Soft_settings->retrieve_currency_info();
		$data=array(
			'title' 			=> display('supplier_ledger'),
			'supplier_id' 		=> $supplier_details[0]['supplier_id'],
			'supplier_name' 	=> $supplier_details[0]['supplier_name'],
			'ledger' 			=> $ledger,
			'total_credit'		=> number_format($summary[0][0]['total_credit'], 2, '.', ','),
			'total_debit'		=> number_format($summary[1][0]['total_debit'], 2, '.', ','),
			'total_balance'		=> number_format($summary[1][0]['total_debit']-$summary[0][0]['total_credit'], 2, '.', ','),
			'currency' 			=> $currency_details[0]['currency_icon'],
			'position' 			=> $currency_details[0]['currency_position'],
			);
			
		$singlecustomerdetails = $CI->parser->parse('supplier/supplier_ledger',$data,true);
		return $singlecustomerdetails;
	}	

	//Ledger report Maintaining information....
	public function supplier_ledger_report($supplier_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Suppliers');
		$CI->load->model('dashboard/Soft_settings');
		$CI->load->library('dashboard/occational');
		$supplier_details = $CI->Suppliers->supplier_personal_data($supplier_id);
		$ledger 	= $CI->Suppliers->suppliers_ledger($supplier_id);
		$summary 	= $CI->Suppliers->suppliers_transection_summary($supplier_id);
		$suppliers_list = $CI->Suppliers->supplier_list();
		$balance = 0;
		if(!empty($ledger)){
			foreach($ledger as $index=>$value){
				$ledger[$index]['final_date'] = $CI->occational->dateConvert($ledger[$index]['date']);
				
				if(!empty($ledger[$index]['invoice_no'])or  $ledger[$index]['invoice_no']=="NA")
				{
					$ledger[$index]['credit']=$ledger[$index]['amount'];
					$ledger[$index]['balance']=$balance-$ledger[$index]['amount'];
					$ledger[$index]['debit']="";
					$balance=$ledger[$index]['balance'];
				}
				else
				{
					$ledger[$index]['debit']=$ledger[$index]['amount'];
					$ledger[$index]['balance']=$balance+$ledger[$index]['amount'];
					$ledger[$index]['credit']="";
					$balance=$ledger[$index]['balance'];
				}
				
			}
		}
		
		$currency_details = $CI->Soft_settings->retrieve_currency_info();
		$data=array(
			'title' 	=> display('supplier_ledger'),
			'supplier_id' 		=> $supplier_details[0]['supplier_id'],
			'supplier_name' 	=> $supplier_details[0]['supplier_name'],
			'ledger' 			=> $ledger,
			'suppliers_list' 	=> $suppliers_list,
			'total_credit'		=> $summary[0][0]['total_credit'],
			'total_debit'		=> $summary[1][0]['total_debit'],
			'total_balance'		=> $summary[1][0]['total_debit']-$summary[0][0]['total_credit'],
			'currency' 			=> $currency_details[0]['currency_icon'],
			'position' 			=> $currency_details[0]['currency_position'],
			);

		$singlecustomerdetails = $CI->parser->parse('supplier/supplier_ledger_report',$data,true);
		return $singlecustomerdetails;
	}
	
	//Search supplier list
	public function supplier_search_list($cat_id,$company_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Suppliers');
		$category_list 	= $CI->Suppliers->retrieve_category_list();
		$suppliers_list = $CI->Suppliers->supplier_search_list($cat_id,$company_id);
		$data = array(
				'title' => display('manage_supplier'),
				'suppliers_list' => $suppliers_list,
				'category_list' => $category_list
			);
		$supplierList = $CI->parser->parse('supplier/supplier',$data,true);
		return $supplierList;
	}
}
?>