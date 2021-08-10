<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lweb_footer {
	//Add Web Footer
	public function web_footer_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Web_footers');
		$CI->load->model('dashboard/Products');
		$product_list = $CI->Products->product_list(); 

		$data = array(
				'title' 	   => display('add_web_footer'),
				'product_list' => $product_list,
			);

		$customerForm = $CI->parser->parse('dashboard/web_footer/add_web_footer',$data,true);
		return $customerForm;
	}

	//Retrieve Web Footer List	
	public function web_footer_list()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Web_footers');
		$web_footer_list = $CI->Web_footers->web_footer_list(); 

		$i=0;
		if(!empty($web_footer_list)){	
			foreach($web_footer_list as $k=>$v){$i++;
			   $web_footer_list[$k]['sl']=$i;
			}
		}

		$data = array(
				'title' => display('manage_web_footer'),
				'web_footer_list' => $web_footer_list,
			);
		$customerList = $CI->parser->parse('dashboard/web_footer/web_footer',$data,true);
		return $customerList;
	}

	//Web Footer Edit Data
	public function web_footer_edit_data($footer_section_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Web_footers');
		$CI->load->model('dashboard/Products');
		$web_footer_details = $CI->Web_footers->retrieve_web_footer_editdata($footer_section_id);
	
		$data=array(
			'title' 			=> display('web_footer_update'),
			'footer_section_id' => $web_footer_details[0]['footer_section_id'],
			'headlines' 		=> $web_footer_details[0]['headlines'],
			'details' 			=> $web_footer_details[0]['details'],
			'position' 			=> $web_footer_details[0]['position'],
			);
		$chapterList = $CI->parser->parse('dashboard/web_footer/edit_web_footer',$data,true);
		return $chapterList;
	}
}
?>