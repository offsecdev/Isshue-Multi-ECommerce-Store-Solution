<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lour_location {
	//Add our_location
	public function our_location_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Our_location');
		$CI->load->model('web/Homes');

		$languages = $CI->Homes->languages();

		$data = array(
				'title' 	=> display('add_our_location'),
				'languages' => $languages
			);

		$customerForm = $CI->parser->parse('dashboard/our_location/add_our_location',$data,true);
		return $customerForm;
	}

	//Retrieve  Our Location List	
	public function our_location_list()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Our_location');
		$our_location_list = $CI->Our_location->our_location_list(); 

		$i=0;
		if(!empty($our_location_list)){	
			foreach($our_location_list as $k=>$v){$i++;
			   $our_location_list[$k]['sl']=$i;
			}
		}

		$data = array(
				'title' => display('manage_our_location'),
				'our_location_list' => $our_location_list,
			);
		$customerList = $CI->parser->parse('dashboard/our_location/our_location',$data,true);
		return $customerList;
	}

	//Our Location Edit Data
	public function our_location_edit_data($position)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Our_location');
		$CI->load->model('web/Homes');
		$our_location_details = $CI->Our_location->retrieve_our_location_editdata($position);

		$languages = $CI->Homes->languages();
	
		$data=array(
			'title' 	   => display('our_location_update'),
			'location_id'  => $our_location_details[0]['location_id'],
			'language_id'  => $our_location_details[0]['language_id'],
			'headline'     => $our_location_details[0]['headline'],
			'details' 	   => $our_location_details[0]['details'],
			'position' 	   => $our_location_details[0]['position'],
			'our_location_details'    => $our_location_details,
			'languages'    => $languages,
			);

		$chapterList = $CI->parser->parse('dashboard/our_location/edit_our_location',$data,true);
		return $chapterList;
	}
}
?>