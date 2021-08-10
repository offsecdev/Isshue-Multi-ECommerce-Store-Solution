<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lsettings {
	#===============Bank list============#
	public function bank_list()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Settings');
		$bank_list = $CI->Settings->get_bank_list( );
		$i=0;
		if(!empty($bank_list)){		
			foreach($bank_list as $k=>$v){$i++;
			   $bank_list[$k]['sl']=$i;
			}
		}
		$data = array(
				'title' 	=> display('bank_list'),
				'bank_list' => $bank_list
			);
		$bankList = $CI->parser->parse('dashboard/settings/bank',$data,true);
		return $bankList;
	}
	#=============Bank show by id=======#
	public function bank_show_by_id($bank_id){
		$CI =& get_instance();
		$CI->load->model('dashboard/Settings');
		$bank_list = $CI->Settings->get_bank_by_id($bank_id);
		$data = array(
				'title' => display('bank_edit'),
				'bank_list' => $bank_list
			);
		$bankList = $CI->parser->parse('dashboard/settings/edit_bank',$data,true);
		return $bankList;
	}
	#=============Bank Update by id=======#
	public function bank_update_by_id($bank_id){
		$CI =& get_instance();
		$CI->load->model('dashboard/Settings');
		$bank_list = $CI->Settings->bank_update_by_id($bank_id);
		return true;
	}
}
?>