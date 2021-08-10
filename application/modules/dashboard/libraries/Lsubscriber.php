<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lsubscriber {
	//Add subscriber
	public function subscriber_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Subscribers');
		$data = array(
				'title' => display('add_subscriber')
			);
		$customerForm = $CI->parser->parse('dashboard/subscriber/add_subscriber',$data,true);
		return $customerForm;
	}

	//Retrieve  subscriber List	
	public function subscriber_list()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Subscribers');
		$subscriber_list = $CI->Subscribers->subscriber_list(); 

		$i=0;
		if(!empty($subscriber_list)){	
			foreach($subscriber_list as $k=>$v){$i++;
			   $subscriber_list[$k]['sl']=$i;
			}
		}

		$data = array(
				'title' => display('manage_subscriber'),
				'subscriber_list' => $subscriber_list,
			);
		$customerList = $CI->parser->parse('dashboard/subscriber/subscriber',$data,true);
		return $customerList;
	}

	//subscriber Edit Data
	public function subscriber_edit_data($subscriber_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Subscribers');
		$subscriber_details = $CI->Subscribers->retrieve_subscriber_editdata($subscriber_id);
	
		$data=array(
			'title' 		=> display('subscriber_update'),
			'subscriber_id' => $subscriber_details[0]['subscriber_id'],
			'email' 	=> $subscriber_details[0]['email'],
			'status' 	=> $subscriber_details[0]['status'],
			);
		$chapterList = $CI->parser->parse('dashboard/subscriber/edit_subscriber',$data,true);
		return $chapterList;
	}
}
?>