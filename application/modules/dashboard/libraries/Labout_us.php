<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Labout_us {
	//Add about_us
	public function about_us_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/About_us');
		$CI->load->model('web/Homes');

		$languages = $CI->Homes->languages();

		$data = array(
				'title' 	=> display('add_about_us'),
				'languages' => $languages
			);

		$customerForm = $CI->parser->parse('dashboard/about_us/add_about_us',$data,true);
		return $customerForm;
	}

	//Retrieve  about_us List	
	public function about_us_list()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/About_us');
		$about_us_list = $CI->About_us->about_us_list(); 

		$i=0;
		if(!empty($about_us_list)){	
			foreach($about_us_list as $k=>$v){$i++;
			   $about_us_list[$k]['sl']=$i;
			}
		}

		$data = array(
				'title' => display('manage_about_us'),
				'about_us_list' => $about_us_list,
			);
		$customerList = $CI->parser->parse('dashboard/about_us/about_us',$data,true);
		return $customerList;
	}

	//about_us Edit Data
	public function about_us_edit_data($content_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/About_us');
		$CI->load->model('web/Homes');
		$about_us_details = $CI->About_us->retrieve_about_us_editdata($content_id);

		$languages = $CI->Homes->languages();
	
		$data=array(
			'title' 	   => display('about_us_update'),
			'content_id'   => $about_us_details[0]['content_id'],
			'language_id'  => $about_us_details[0]['language_id'],
			'headline'     => $about_us_details[0]['headline'],
			'icon'         => $about_us_details[0]['icon'],
			'details' 	   => $about_us_details[0]['details'],
			'position' 	   => $about_us_details[0]['position'],
			'about_us_details'    => $about_us_details,
			'languages'    => $languages,
			);

		$chapterList = $CI->parser->parse('dashboard/about_us/edit_about_us',$data,true);
		return $chapterList;
	}
}
?>