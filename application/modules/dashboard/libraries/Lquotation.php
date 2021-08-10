<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lquotation {

	//Quotation Add Form
	public function quotation_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('Quotations');
		$CI->load->model('Stores');
		$CI->load->model('Variants');

		$store_list = $CI->Stores->store_list();
		$variant_list = $CI->Variants->variant_list();
		$terminal_list    = $CI->Quotations->terminal_list();
	
		$data = array(
				'title' 		=> display('new_quotation'),
				'store_list' 	=> $store_list,
				'variant_list' 	=> $variant_list,
				'terminal_list' => $terminal_list,
			);
		$quotationForm = $CI->parser->parse('quotation/add_quotation_form',$data,true);
		return $quotationForm;
	}
	//Insert quotation
	public function insert_quotation($data)
	{
		$CI =& get_instance();
		$CI->load->model('Quotations');
        $CI->Quotations->quotation_entry($data);
		return true;
	}
	//quotation Edit Data
	public function quotation_edit_data($quotation_id)
	{
		$CI =& get_instance();
		$CI->load->model('Quotations');
		$CI->load->model('Stores');
		$quotation_detail = $CI->Quotations->retrieve_quotation_editdata($quotation_id);
		$store_id 		  = $quotation_detail[0]['store_id'];
		$store_list 	  = $CI->Stores->store_list();
		$store_list_selected = $CI->Stores->store_list_selected($store_id);
		$terminal_list    = $CI->Quotations->terminal_list();

		$i=0;
		foreach($quotation_detail as $k=>$v){$i++;
		   $quotation_detail[$k]['sl']=$i;
		}

		$data=array(
			'title'				=> 	display('quotation_update'),
			'quotation_id'		=>	$quotation_detail[0]['quotation_id'],
			'customer_id'		=>	$quotation_detail[0]['customer_id'],
			'store_id'			=>	$quotation_detail[0]['store_id'],
			'customer_name'		=>	$quotation_detail[0]['customer_name'],
			'date'				=>	$quotation_detail[0]['date'],
			'quotation'			=>	$quotation_detail[0]['quotation'],
			'total_amount'		=>	$quotation_detail[0]['total_amount'],
			'paid_amount'		=>	$quotation_detail[0]['paid_amount'],
			'due_amount'		=>	$quotation_detail[0]['due_amount'],
			'total_discount'	=>	$quotation_detail[0]['total_discount'],
			'quotation_discount'	=>	$quotation_detail[0]['quotation_discount'],
			'service_charge'	=>	$quotation_detail[0]['service_charge'],
			'details'			=>	$quotation_detail[0]['details'],
			'status'			=>	$quotation_detail[0]['status'],
			'quotation_all_data'=>	$quotation_detail,
			'store_list'		=>	$store_list,
			'store_list_selected'=>	$store_list_selected,
			'terminal_list'     =>	$terminal_list,
			);
		$chapterList = $CI->parser->parse('quotation/edit_quotation_form',$data,true);
		return $chapterList;
	}
	//Quotation html Data
	public function quotation_html_data($quotation_id)
	{
		$CI =& get_instance();
		$CI->load->model('Quotations');
		$CI->load->model('Soft_settings');
		$CI->load->library('occational');
		$CI->load->library('Pdfgenerator');
		$quotation_detail = $CI->Quotations->retrieve_quotation_html_data($quotation_id);

		$subTotal_quantity = 0;
		$subTotal_cartoon = 0;
		$subTotal_discount = 0;

		if(!empty($quotation_detail)){
			foreach($quotation_detail as $k=>$v){
				$quotation_detail[$k]['final_date'] = $CI->occational->dateConvert($quotation_detail[$k]['date']);
				$subTotal_quantity = $subTotal_quantity+$quotation_detail[$k]['quantity'];
			}
			$i=0;
			foreach($quotation_detail as $k=>$v){$i++;
			   $quotation_detail[$k]['sl']=$i;
			}
		}

		$currency_details = $CI->Soft_settings->retrieve_currency_info();
		$company_info = $CI->Quotations->retrieve_company();
		$data=array(
			'title'				=>	display('quotation_details'),
			'quotation_id'		=>	$quotation_detail[0]['quotation_id'],
			'quotation_no'		=>	$quotation_detail[0]['quotation'],
			'details'			=>	$quotation_detail[0]['details'],
			'customer_name'		=>	$quotation_detail[0]['customer_name'],
			'customer_mobile'	=>	$quotation_detail[0]['customer_mobile'],
			'customer_email'	=>	$quotation_detail[0]['customer_email'],
			'customer_address'	=>	$quotation_detail[0]['customer_short_address'],
			'final_date'		=>	$quotation_detail[0]['final_date'],
			'total_amount'		=>	$quotation_detail[0]['total_amount'],
			'quotation_discount'=>	$quotation_detail[0]['quotation_discount'],
			'service_charge'	=>	$quotation_detail[0]['service_charge'],
			'paid_amount'		=>	$quotation_detail[0]['paid_amount'],
			'due_amount'		=>	$quotation_detail[0]['due_amount'],
			'subTotal_quantity'	=>	$subTotal_quantity,
			'quotation_all_data'=>	$quotation_detail,
			'company_info'		=>	$company_info,
			'currency' 			=> $currency_details[0]['currency_icon'],
			'position' 			=> $currency_details[0]['currency_position'],
			);

		$chapterList = $CI->parser->parse('quotation/quotation_pdf',$data,true);

		//PDF Generator 
		$CI->load->library('pdfgenerator');
        $file_path = $CI->pdfgenerator->generate_order($quotation_id, $chapterList);

	    //File path save to database
	    $CI->db->set('file_path',base_url($file_path));
	    $CI->db->where('quotation_id',$quotation_id);
	    $CI->db->update('quotation');

	    $send_email = '';
	    if (!empty($data['customer_email'])) {
	    	$send_email = $this->setmail($data['customer_email'],$file_path);
	    }

	    if ($send_email != null) {
	    	return true;
	    }else{
	    	return false;
	    }
	}
	//Send Customer Email with invoice
	public function setmail($email,$file_path)
	{

		$CI =& get_instance();
		$CI->load->model('Soft_settings');
		$setting_detail = $CI->Soft_settings->retrieve_email_editdata();

		$subject = display("quotation_information");
		$message = display("quotation_info_details").'<br>'.base_url();

	    $config = Array(
	      	'protocol' 		=> $setting_detail[0]['protocol'],
	      	'smtp_host' 	=> $setting_detail[0]['smtp_host'],
	      	'smtp_port' 	=> $setting_detail[0]['smtp_port'],
	      	'smtp_user' 	=> $setting_detail[0]['sender_email'], 
	      	'smtp_pass' 	=> $setting_detail[0]['password'], 
	      	'mailtype' 		=> $setting_detail[0]['mailtype'],
	      	'charset' 		=> 'utf-8'
	    );
	    
	    $CI->load->library('email');
        $CI->email->initialize($config);

	    $CI->email->set_newline("\r\n");
	    $CI->email->from($setting_detail[0]['sender_email']);
	    $CI->email->to($email);
	    $CI->email->subject($subject);
	    $CI->email->message($message);
	    $CI->email->attach($file_path);

	   	$check_email = $this->test_input($email);
		if (filter_var($check_email, FILTER_VALIDATE_EMAIL)) {
		    if($CI->email->send())
		    {
		      	$CI->session->set_userdata(array('message'=>display('email_send_to_customer')));
		      	return true;
		    }else{
		    	
				$CI->session->set_userdata(array('error_message'=> display('email_not_send')));
		     	redirect(base_url('Cquotation/manage_quotation'));
		    }
		}else{
			$CI->session->set_userdata(array('message'=>display('successfully_added')));
		    redirect(base_url('Cquotation/manage_quotation'));
		}
	}

	//Email testing for email
	public function test_input($data) {
	  	$data = trim($data);
	  	$data = stripslashes($data);
	  	$data = htmlspecialchars($data);
	  	return $data;
	}
	
	//Retrieve quotation List
	public function quotation_list()
	{
		$CI =& get_instance();
		$CI->load->model('Quotations');
		$CI->load->model('Soft_settings');
		$CI->load->library('occational');
		
		$quotations_list = $CI->Quotations->quotation_list();

		if(!empty($quotations_list)){
			foreach($quotations_list as $k=>$v){
				$quotations_list[$k]['final_date'] = $CI->occational->dateConvert($quotations_list[$k]['date']);
			}
			$i=0;
			foreach($quotations_list as $k=>$v){$i++;
			   $quotations_list[$k]['sl']=$i;
			}
		}

		$currency_details = $CI->Soft_settings->retrieve_currency_info();
		$data = array(
				'title'    => display('manage_quotation'),
				'quotations_list' => $quotations_list,
				'currency' => $currency_details[0]['currency_icon'],
				'position' => $currency_details[0]['currency_position'],
			);
		$quotationList = $CI->parser->parse('quotation/quotation',$data,true);
		return $quotationList;
	}
	//Pos quotation add form
	public function pos_quotation_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('Quotations');
		$CI->load->model('Stores');
		$customer_details = $CI->Quotations->pos_customer_setup();
		$product_list 	  = $CI->Quotations->product_list();
		$category_list	  = $CI->Quotations->category_list();
		$customer_list	  = $CI->Quotations->customer_list();
		$store_list   	  = $CI->Quotations->store_list();
		$terminal_list    = $CI->Quotations->terminal_list();

		$data = array(
				'title' 		=> display('add_pos_quotation'),
				'sidebar_collapse' => 'sidebar-collapse',
				'product_list' 	=> $product_list,
				'category_list' => $category_list,
				'customer_details' => $customer_details,
				'customer_list' => $customer_list,
				'store_list' 	=> $store_list,
				'terminal_list' => $terminal_list,
			);
		$quotationForm = $CI->parser->parse('quotation/add_pos_quotation_form',$data,true);
		return $quotationForm;
	}

	//Quotation Details Data
	public function quotation_details_data($quotation_id)
	{
		$CI =& get_instance();
		$CI->load->model('quotations');
		$CI->load->model('Soft_settings');
		$CI->load->library('occational');
		$CI->load->library('Pdfgenerator');
		$quotation_detail = $CI->quotations->retrieve_quotation_html_data($quotation_id);

		$subTotal_quantity 	= 0;
		$subTotal_cartoon 	= 0;
		$subTotal_discount 	= 0;

		if(!empty($quotation_detail)){
			foreach($quotation_detail as $k=>$v){
				$quotation_detail[$k]['final_date'] = $CI->occational->dateConvert($quotation_detail[$k]['date']);
				$subTotal_quantity = $subTotal_quantity+$quotation_detail[$k]['quantity'];
			}
			$i=0;
			foreach($quotation_detail as $k=>$v){$i++;
			   $quotation_detail[$k]['sl']=$i;
			}
		}

		$currency_details = $CI->Soft_settings->retrieve_currency_info();
		$company_info = $CI->quotations->retrieve_company();
		$data=array(
			'title'				=>	display('quotation_details'),
			'quotation_id'			=>	$quotation_detail[0]['quotation_id'],
			'quotation_no'			=>	$quotation_detail[0]['quotation'],
			'customer_address'	=>	$quotation_detail[0]['customer_short_address'],
			'customer_name'		=>	$quotation_detail[0]['customer_name'],
			'customer_mobile'	=>	$quotation_detail[0]['customer_mobile'],
			'customer_email'	=>	$quotation_detail[0]['customer_email'],
			'final_date'		=>	$quotation_detail[0]['final_date'],
			'total_amount'		=>	$quotation_detail[0]['total_amount'],
			'quotation_discount' 	=>	$quotation_detail[0]['quotation_discount'],
			'service_charge' 	=>	$quotation_detail[0]['service_charge'],
			'paid_amount'		=>	$quotation_detail[0]['paid_amount'],
			'due_amount'		=>	$quotation_detail[0]['due_amount'],
			'details'			=>	$quotation_detail[0]['details'],
			'subTotal_quantity'	=>	$subTotal_quantity,
			'quotation_all_data' 	=>	$quotation_detail,
			'company_info'		=>	$company_info,
			'currency' 			=> 	$currency_details[0]['currency_icon'],
			'position' 			=> 	$currency_details[0]['currency_position'],
			);

		$chapterList = $CI->parser->parse('quotation/quotation_html',$data,true);
		return $chapterList;
	}

	//POS quotation html Data
	public function pos_quotation_html_data($quotation_id)
	{
		$CI =& get_instance();
		$CI->load->model('Quotations');
		$CI->load->model('Soft_settings');
		$CI->load->library('occational');
		$quotation_detail = $CI->Quotations->retrieve_quotation_html_data($quotation_id);
		$subTotal_quantity = 0;
		$subTotal_cartoon = 0;
		$subTotal_discount = 0;

		if(!empty($quotation_detail)){
			foreach($quotation_detail as $k=>$v){
				$quotation_detail[$k]['final_date'] = $CI->occational->dateConvert($quotation_detail[$k]['date']);
				$subTotal_quantity = $subTotal_quantity+$quotation_detail[$k]['quantity'];
			}
			$i=0;
			foreach($quotation_detail as $k=>$v){$i++;
			   $quotation_detail[$k]['sl']=$i;
			}
		}

		$currency_details = $CI->Soft_settings->retrieve_currency_info();
		$company_info = $CI->Quotations->retrieve_company();
		$data=array(
			'title'				=>	display('quotation_details'),
			'quotation_id'		=>	$quotation_detail[0]['quotation_id'],
			'quotation_no'		=>	$quotation_detail[0]['quotation'],
			'customer_name'		=>	$quotation_detail[0]['customer_name'],
			'customer_address'	=>	$quotation_detail[0]['customer_short_address'],
			'customer_mobile'	=>	$quotation_detail[0]['customer_mobile'],
			'customer_email'	=>	$quotation_detail[0]['customer_email'],
			'final_date'		=>	$quotation_detail[0]['final_date'],
			'total_amount'		=>	$quotation_detail[0]['total_amount'],
			'subTotal_discount'	=>	$quotation_detail[0]['total_discount'],
			'paid_amount'		=>	$quotation_detail[0]['paid_amount'],
			'due_amount'		=>	$quotation_detail[0]['due_amount'],
			'subTotal_quantity'	=>	$subTotal_quantity,
			'quotation_all_data'=>	$quotation_detail,
			'company_info'		=>	$company_info,
			'currency' 			=> $currency_details[0]['currency_icon'],
			'position' 			=> $currency_details[0]['currency_position'],
			);
		$chapterList = $CI->parser->parse('quotation/pos_quotation_html',$data,true);
		return $chapterList;
	}
}
?>