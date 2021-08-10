<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lunit {
	//Add unit
	public function unit_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Units');
		$data = array(
				'title' => display('add_unit')
			);
		$customerForm = $CI->parser->parse('dashboard/unit/add_unit',$data,true);
		return $customerForm;
	}

	//Retrieve unit List	
	public function unit_list()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Units');
		$unit_list = $CI->Units->unit_list(); 

		$i=0;
		if(!empty($unit_list)){	
			foreach($unit_list as $k=>$v){$i++;
			   $unit_list[$k]['sl']=$i;
			}
		}

		$data = array(
				'title' => display('manage_unit'),
				'unit_list' => $unit_list,
			);
		$customerList = $CI->parser->parse('dashboard/unit/unit',$data,true);
		return $customerList;
	}

	//unit Edit Data
	public function unit_edit_data($unit_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Units');
		$unit_details = $CI->Units->retrieve_unit_editdata($unit_id);

		$data=array(
			'title' 		=> display('unit_edit'),
			'unit_id' 		=> $unit_details[0]['unit_id'],
			'unit_name' 	=> $unit_details[0]['unit_name'],
			'unit_short_name' 	=> $unit_details[0]['unit_short_name'],
			);
		$chapterList = $CI->parser->parse('dashboard/unit/edit_unit',$data,true);
		return $chapterList;
	}
}
?>