<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lblock {
	//Add block
	public function block_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Blocks');
		$CI->load->model('dashboard/Categories');

		$category_list = $CI->Categories->category_list(); 

		$data = array(
				'title' => display('add_block'),
				'category_list' => $category_list,
			);
		$customerForm = $CI->parser->parse('dashboard/block/add_block',$data,true);
		return $customerForm;
	}

	//Retrieve  block List	
	public function block_list()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Blocks');
		$block_list = $CI->Blocks->block_list(); 

		$i=0;
		if(!empty($block_list)){	
			foreach($block_list as $k=>$v){$i++;
			   $block_list[$k]['sl']=$i;
			}
		}

		$data = array(
				'title' => display('manage_block'),
				'block_list' => $block_list,
			);
		$customerList = $CI->parser->parse('dashboard/block/block',$data,true);
		return $customerList;
	}

	//block Edit Data
	public function block_edit_data($block_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Blocks');
		$CI->load->model('dashboard/Categories');
		$category_list = $CI->Categories->category_list();

		$block_details = $CI->Blocks->retrieve_block_editdata($block_id);
		$cat_id = $block_details[0]['block_cat_id'];
		$category_selected = $CI->Categories->category_search_item($cat_id);
	
		$data=array(
			'title' 		=> display('block_edit'),
			'block_id' 		=> $block_details[0]['block_id'],
			'block_cat_id' 	=> $block_details[0]['block_cat_id'],
			'block_css' 	=> $block_details[0]['block_css'],
			'block_position'=> $block_details[0]['block_position'],
			'block_style' 	=> $block_details[0]['block_style'],
			'block_image' 	=> $block_details[0]['block_image'],
			'status' 		=> $block_details[0]['status'],
			'category_list' => $category_list,
			'category_selected' => $category_selected,
			);
		$chapterList = $CI->parser->parse('dashboard/block/edit_block',$data,true);
		return $chapterList;
	}
}
?>