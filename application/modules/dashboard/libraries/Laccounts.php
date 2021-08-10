<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Laccounts
 {
	
	public function get_daily_closing_view()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Accounts');
		$CI->load->model('dashboard/Settings');
		
		$draw_data = array(
				'title' => display('accounts')
			);
	}
	//Retrieve  Customer List	
	public function daily_closing_list()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Accounts');
		$CI->load->model('dashboard/Soft_settings');
		$CI->load->library('dashboard/occational');
		$daily_closing_data = $CI->Accounts->get_closing_report();
        $i=0;
		if(!empty($daily_closing_data)){
			foreach($daily_closing_data as $k=>$v){
				$daily_closing_data[$k]['final_date'] = $CI->occational->dateConvert($daily_closing_data[$k]['date']);
			}
			foreach($daily_closing_data as $k=>$v){$i++;
			   $daily_closing_data[$k]['sl']=$i;
			}
		}
		$currency_details = $CI->Soft_settings->retrieve_currency_info();
       
		$data = array(
				'title'    => display('closing_report'),
				'daily_closing_data' => $daily_closing_data,
				'currency' => $currency_details[0]['currency_icon'],
            	'position' => $currency_details[0]['currency_position'],
			);
		$reportList = $CI->parser->parse('dashboard/accounts/closing_report',$data,true);
		return $reportList;
	}
	
	//Retrieve  Customer List	
	public function get_date_wise_closing_reports( $from_date,$to_date )
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Accounts');
		$CI->load->library('dashboard/occational');
		$daily_closing_data = $CI->Accounts->get_date_wise_closing_report( $from_date,$to_date );
		
		$i=0;
		if(!empty($daily_closing_data)){
			foreach($daily_closing_data as $k=>$v){
				$daily_closing_data[$k]['final_date'] = $CI->occational->dateConvert($daily_closing_data[$k]['date']);
			}
		
			foreach($daily_closing_data as $k=>$v){$i++;
			   $daily_closing_data[$k]['sl']=$i;
			}
		}
		$currency_details = $CI->Soft_settings->retrieve_currency_info();
		$data = array(
				'title' 	=> display('closing_report'),
				'daily_closing_data' => $daily_closing_data,
				'currency' => $currency_details[0]['currency_icon'],
            	'position' => $currency_details[0]['currency_position'],
			);
		$reportList = $CI->parser->parse('dashboard/accounts/closing_report',$data,true);
		return $reportList;
	}

	#============Account List=============#
	public function account_list()
	{
		$CI =& get_instance();
		$CI->load->model('dashboard/Accounts');
		$account_list = $CI->Accounts->account_list();
		$i=0;
		if(!empty($account_list)){		
			foreach($account_list as $k=>$v){$i++;
			   $account_list[$k]['sl']=$i;
			}
		}
		$data = array(
				'title' => display('manage_account'),
				'account_list' => $account_list
			);
		$bankList = $CI->parser->parse('dashboard/accounts/account_list',$data,true);
		return $bankList;
	}
}
?>