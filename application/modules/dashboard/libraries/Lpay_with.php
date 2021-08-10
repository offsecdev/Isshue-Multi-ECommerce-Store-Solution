<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lpay_with {

	public function __construct(){

	}

	public function pay_with_list(){
		
		$CI =& get_instance();
		$CI->load->model('dashboard/pay_withs');
		$pay_with_lists = $CI->pay_withs->pay_with_list(); 
		$data=[
			'pay_with_lists'=>$pay_with_lists
		];
		$pay_with_lists = $CI->parser->parse('dashboard/pay_with/index',$data,true);
		return $pay_with_lists;
	}


	public function pay_with_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/pay_withs');
		$data = array(
			'title' => display('add_pay_with')
		);
		$pay_with = $CI->parser->parse('dashboard/pay_with/create',$data,true);
		return $pay_with;
	}


	public function pay_with_edit_form($id)
	{

		$CI =& get_instance();
		$CI->load->model('dashboard/pay_withs');
		$pay_with_details = $CI->pay_withs->retrieve_pay_with_editdata($id);

		$data=array(
			'id' 	=> $pay_with_details[0]['id'],
			'title' 	=> $pay_with_details[0]['title'],
			'image' 	=> $pay_with_details[0]['image'],
			'link' 	=> $pay_with_details[0]['link'],
			'status' 	=> $pay_with_details[0]['status']
		);
		$pay_with_data = $CI->parser->parse('dashboard/pay_with/edit',$data,true);
		return $pay_with_data;
	}


}