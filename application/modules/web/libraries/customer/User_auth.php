<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_auth {

	//Login....
	public function login($email,$password)
	{
		$CI =& get_instance();
		$result = $this->check_valid_user($email,$password);
        if ($result)
		{
			//customer activity data start
			$CI->db->select('*');
	        $CI->db->from('customer_activities');
	        $CI->db->where('customer_id', $result[0]['customer_id']);
	        $activities = $CI->db->get();
	        $customer_activities = $activities->result_array();

	        if(!empty($customer_activities)){
	        	$customer_activities_data = array(
					'login_count'   => ($customer_activities[0]['login_count']+1),
		        	);
	        	$ca_result = $CI->db->update('customer_activities',$customer_activities_data, array('customer_id' => $result[0]['customer_id']));
	        }else{
	        	$customer_activities_data = array(
					'customer_id' 	=> $result[0]['customer_id'],
					'login_count'   => 1,
		        	);
	        	$ca_result = $CI->db->insert('customer_activities',$customer_activities_data);
	        }
	        //customer activity data end

			$key = md5(time());
			$key = str_replace("1", "z", $key);
			$key = str_replace("2", "J", $key);
			$key = str_replace("3", "y", $key);
			$key = str_replace("4", "R", $key);
			$key = str_replace("5", "Kd", $key);
			$key = str_replace("6", "jX", $key);
			$key = str_replace("7", "dH", $key);
			$key = str_replace("8", "p", $key);
			$key = str_replace("9", "Uf", $key);
			$key = str_replace("0", "eXnyiKFj", $key);
			$customer_sid_web = substr($key, rand(0, 3), rand(28, 32));
			
			// codeigniter session stored data			
			$user_data = array(
				'customer_sid_web' 	=> $customer_sid_web,
				'customer_id' 	=> $result[0]['customer_id'],
				'customer_name' => $result[0]['first_name']." ".$result[0]['last_name'],
				//customer shipping info
				'first_name'   => $result[0]['first_name'], 
			 	'last_name'    => $result[0]['last_name'], 
			 	'customer_email'  => $result[0]['customer_email'], 
			 	'customer_mobile' => $result[0]['customer_mobile'], 
			 	'customer_address_1'  => $result[0]['customer_address_1'], 
			 	'customer_address_2'  => $result[0]['customer_address_2'], 
			 	'company'  	=> $result[0]['company'], 
			 	'city'  	=> $result[0]['city'], 
			 	'zip'  		=> $result[0]['zip'], 
			 	'country'  	=> $result[0]['country'], 
			 	'state'  	=> $result[0]['state'], 
			 	'password'  => $result[0]['last_name'], 
			);

          	$CI->session->set_userdata($user_data);
           	return TRUE;
		}else{
			return FALSE;
        }
	}

	//Check valid user
	function check_valid_user($email,$password)
	{ 	
		$CI 		=& get_instance();
		$password 	= md5("gef".$password);
        $CI->db->where(array('customer_email'=>$email,'password'=>$password));
		$query 		= $CI->db->get('customer_information');
		$result 	=  $query->result_array();

		if (count($result) == 1)
		{
			$CI->db->select('*');
			$CI->db->from('customer_information');
			$CI->db->where('customer_id',$result[0]['customer_id']);
			$query = $CI->db->get();
			return $query->result_array();
		}
		return false;
	}

	//Check if is logged....
	public function is_logged()
	{
		$CI =& get_instance();
        if($CI->session->userdata('customer_sid_web'))
		{
			return true;
		}
		return false;
	}

	//Logout....
	public function logout()
	{
		$CI =& get_instance();
		$user_data = array(
				'customer_sid_web','customer_id','customer_name','customer_email','first_name','last_name','customer_address_1','customer_address_2','city','state','country','zip','company','customer_mobile','customer_email','password'
			);
        $CI->session->unset_userdata($user_data);
        $CI->session->sess_destroy();
		return true;
	}

	//Check for logged in user is Admin or not.
	public function is_admin()
	{
		$CI =& get_instance();
        if ($CI->session->userdata('user_type')==1 || $CI->session->userdata('user_type')==2)
		{
			return true;
		}
		return false;
	}

	//Check custoemr auth
	function check_customer_auth($url='')
	{   
        if($url==''){$url = base_url('login');}

		$CI =& get_instance();
        if ((!$this->is_logged()))
		{ 
			$this->logout();
			$error = display('you_are_not_authorised');
			$CI->session->set_userdata(array('error_message'=>$error));
            redirect($url,'refresh'); exit;
        }
	}
	
	//This function is used to Generate Key
	public function generator($lenth)
	{
		$number=array("A","B","C","D","E","F","G","H","I","J","K","L","N","M","O","P","Q","R","S","U","V","T","W","X","Y","Z","1","2","3","4","5","6","7","8","9","0");
	
		for($i=0; $i<$lenth; $i++)
		{
			$rand_value=rand(0,34);
			$rand_number=$number["$rand_value"];
		
			if(empty($con))
			{ 
				$con=$rand_number;
			}
			else
			{
				$con="$con"."$rand_number";
			}
		}
		return $con;
	}
}
?>