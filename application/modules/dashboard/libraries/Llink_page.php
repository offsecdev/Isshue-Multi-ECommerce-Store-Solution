<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Llink_page {
	//Add link_page
	public function link_page_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Link_pages');
		$CI->load->model('web/Homes');

		$languages = $CI->Homes->languages();

		$data = array(
				'title' 	=> display('add_link_page'),
				'languages' => $languages
			);

		$customerForm = $CI->parser->parse('dashboard/link_page/add_link_page',$data,true);
		return $customerForm;
	}

	//Retrieve  link_page List	
	public function link_page_list()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Link_pages');
		$link_page_list = $CI->Link_pages->link_page_list(); 

		$i=0;
		if(!empty($link_page_list)){	
			foreach($link_page_list as $k=>$v){$i++;
			   $link_page_list[$k]['sl']=$i;
			}
		}

		$data = array(
				'title' => display('manage_link_page'),
				'link_page_list' => $link_page_list,
			);
		$customerList = $CI->parser->parse('dashboard/link_page/link_page',$data,true);
		return $customerList;
	}

	//link_page Edit Data
	public function link_page_edit_data($page_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Link_pages');
		$CI->load->model('web/Homes');
		$link_page_details = $CI->Link_pages->retrieve_link_page_editdata($page_id);

		$languages = $CI->Homes->languages();
	
		$data=array(
			'title' 	   => display('link_page_update'),
			'link_page_id' => $link_page_details[0]['link_page_id'],
			'page_id' 	   => $link_page_details[0]['page_id'],
			'language_id'  => $link_page_details[0]['language_id'],
			'headlines'    => $link_page_details[0]['headlines'],
			'image' 	   => $link_page_details[0]['image'],
			'details' 	   => $link_page_details[0]['details'],
			'link_page_details' => $link_page_details,
			'languages'    => $languages,
			);
		$chapterList = $CI->parser->parse('dashboard/link_page/edit_link_page',$data,true);
		return $chapterList;
	}
}
?>