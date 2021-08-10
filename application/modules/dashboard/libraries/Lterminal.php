<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lterminal {
	//Add terminal
	public function terminal_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('Terminals');
		$data = array(
				'title' => display('add_terminal')
			);
		$customerForm = $CI->parser->parse('terminal/add_terminal',$data,true);
		return $customerForm;
	}

	//Retrieve terminal List	
	public function terminal_list()
	{
		$CI =& get_instance();
		$CI->load->model('Terminals');
		$terminal_list = $CI->Terminals->terminal_list(); 

		$i=0;
		if(!empty($terminal_list)){	
			foreach($terminal_list as $k=>$v){$i++;
			   $terminal_list[$k]['sl']=$i;
			}
		}

		$data = array(
				'title' => display('manage_terminal'),
				'terminal_list' => $terminal_list,
			);
		$customerList = $CI->parser->parse('terminal/terminal',$data,true);
		return $customerList;
	}

	//terminal Edit Data
	public function terminal_edit_data($terminal_id)
	{
		$CI =& get_instance();
		$CI->load->model('Terminals');
		$terminal_details = $CI->Terminals->retrieve_terminal_editdata($terminal_id);
	
		$data=array(
			'title' 					=> display('terminal_edit'),
			'pay_terminal_id' 			=> $terminal_details[0]['pay_terminal_id'],
			'terminal_name' 			=> $terminal_details[0]['terminal_name'],
			'terminal_provider_company'	=> $terminal_details[0]['terminal_provider_company'],
			'linked_bank_account_no' 	=> $terminal_details[0]['linked_bank_account_no'],
			'customer_care_phone_no' 	=> $terminal_details[0]['customer_care_phone_no']
			);
		$chapterList = $CI->parser->parse('terminal/edit_terminal',$data,true);
		return $chapterList;
	}
}
?>