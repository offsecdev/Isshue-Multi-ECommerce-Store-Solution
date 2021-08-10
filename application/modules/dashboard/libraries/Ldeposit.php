<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ldeposit {
	// Retrieve  deposit List From DB 
	public function deposit_list($limit,$page,$links)
	{
		$CI =& get_instance();
		$CI->load->model('Deposits');
		$CI->load->library('occational');
		$deposits_list = $CI->Deposits->deposit_list($limit,$page);
		if(!empty($deposits_list)){
			$i=$page;
			foreach($deposits_list as $k=>$v){$i++;
			   $deposits_list[$k]['sl']=$i;
			}
			$j=0;
			foreach($deposits_list as $k=>$v){
				$deposits_list[$k]['final_date'] = $CI->occational->dateConvert($deposits_list[$j]['date']);
			  $j++;
			}
		}
		$data = array(
				'title' => 'Deposits List',
				'deposits_list' => $deposits_list,
				'links' => $links
			);
		$depositList = $CI->parser->parse('deposit/deposit',$data,true);
		return $depositList;
	}
	//Sub Category Add
	public function deposit_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('Deposits');
		$data = array(
				'title' => 'Add deposit'
			);
		$depositForm = $CI->parser->parse('deposit/add_deposit_form',$data,true);
		return $depositForm;
	}
	public function insert_deposit($data)
	{
		$CI =& get_instance();
		$CI->load->model('Deposits');
        $CI->Deposits->deposit_entry($data);
		return true;
	}
	//deposit Edit Data
	public function deposit_edit_data($deposit_id)
	{
		$CI =& get_instance();
		$CI->load->model('Deposits');
		$deposit_detail = $CI->Deposits->retrieve_deposit_editdata($deposit_id);
		$data=array(
			'deposit_id' 	=> $deposit_detail[0]['deposit_id'],
			'date' 			=> $deposit_detail[0]['date'],
			'description' 	=> $deposit_detail[0]['description'],
			'amount' 		=> $deposit_detail[0]['amount']
		);
		$chapterList = $CI->parser->parse('deposit/edit_deposit_form',$data,true);
		return $chapterList;
	}
	//Search deposit
	public function deposit_search_list($cat_id,$company_id)
	{
		$CI =& get_instance();
		$CI->load->model('Deposits');
		$category_list = $CI->Deposits->retrieve_category_list();
		$deposits_list = $CI->Deposits->deposit_search_list($cat_id,$company_id);
		$data = array(
				'title' => 'deposits List',
				'deposits_list' => $deposits_list,
				'category_list' => $category_list
			);
		$depositList = $CI->parser->parse('deposit/deposit',$data,true);
		return $depositList;
	}
}
?>