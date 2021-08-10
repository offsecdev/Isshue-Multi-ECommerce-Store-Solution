<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lcoupon {
	//Add coupon
	public function coupon_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Coupons');

		$data = array(
				'title' 	=> display('add_coupon'),
			);

		$couponForm = $CI->parser->parse('dashboard/coupon/add_coupon',$data,true);
		return $couponForm;
	}

	//Retrieve coupon List	
	public function coupon_list()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Coupons');
		$coupon_list = $CI->Coupons->coupon_list(); 

		$i=0;
		if(!empty($coupon_list)){	
			foreach($coupon_list as $k=>$v){$i++;
			   $coupon_list[$k]['sl']=$i;
			}
		}

		$data = array(
				'title' => display('manage_coupon'),
				'coupon_list' => $coupon_list,
			);
		$couponList = $CI->parser->parse('dashboard/coupon/coupon',$data,true);
		return $couponList;
	}

	//coupon Edit Data
	public function coupon_edit_data($coupon_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Coupons');
		$coupon_details = $CI->Coupons->retrieve_coupon_editdata($coupon_id);

	
		$data=array(
			'title' 		=> display('coupon_update'),
			'coupon_id' 	=> $coupon_details[0]['coupon_id'],
			'coupon_name'	=> $coupon_details[0]['coupon_name'],
			'coupon_discount_code'=> $coupon_details[0]['coupon_discount_code'],
			'discount_amount'=> $coupon_details[0]['discount_amount'],
			'discount_percentage' => $coupon_details[0]['discount_percentage'],
			'start_date' 	 => $coupon_details[0]['start_date'],
			'end_date' 		 => $coupon_details[0]['end_date'],
			'discount_type'  => $coupon_details[0]['discount_type'],
			);
		$couponEdit = $CI->parser->parse('dashboard/coupon/edit_coupon',$data,true);
		return $couponEdit;
	}
}
?>