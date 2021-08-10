<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customer_activities extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function new_customers(){
		$today         = date("Y-m-d");
        $fromdate      = date("Y-m-d",strtotime("-30 days"));
        $new_customers = $this->db->query("SELECT COUNT(customer_id) as new_customers
	                     FROM customer_information
	                     WHERE DATE(created_at) BETWEEN '".$fromdate."' AND '".$today."'")->row();
        if (!empty($new_customers)) {
            return $new_customers;
        }else{
        	return 0;
        }
	}
	public function date_array(){
		$yms = array();
		$now = date('Y-m');
		for($i = 11; $i >= 0; $i--) {
		    $ym = date('Ym', strtotime($now . " -$i month"));
		    $yms[] = $ym;
		}
		return $yms;
	}

	public function monthly_new_customers($date_array){
		$monthly_new_customers = array();
		foreach($date_array as $year_month){
			$new_customer = $this->db->query("
				SELECT COUNT(customer_id) as new_customers, IFNULL(EXTRACT(YEAR_MONTH FROM  created_at),$year_month) as month
	            FROM customer_information
	            WHERE EXTRACT(YEAR_MONTH FROM  created_at) = ".$year_month." 
	            ")->row();
			$monthly_new_customers[] = $new_customer;
		}

        if (!empty($monthly_new_customers)) {
            return $monthly_new_customers;
        }else{
        	return 0;
        }
	}
	public function monthly_returning_customers($date_array){
		$monthly_returning_customers = array();

		foreach($date_array as $year_month){
        	$returning_customers = $this->db->query("SELECT COUNT(DISTINCT a.customer_id) as returning_customers,IFNULL(EXTRACT(YEAR_MONTH FROM  b.created_at),$year_month) as month
	        					FROM customer_information a, `order` b
			                    WHERE a.customer_id = b.customer_id
			                    AND EXTRACT(YEAR_MONTH FROM  a.created_at) < $year_month
	                    		AND EXTRACT(YEAR_MONTH FROM  b.created_at) = $year_month")->row();
        	$monthly_returning_customers[] = $returning_customers;
    	}
        if (!empty($monthly_returning_customers)){
            return $monthly_returning_customers;
        }else{
        	return 0;
        }
	}

	public function returning_customers(){
		$today              = date("Y-m-d");
        $fromdate           = date("Y-m-d",strtotime("-30 days"));
        $returning_customers= $this->db->query("SELECT COUNT(DISTINCT a.customer_id) as returning_customers
	        					FROM customer_information a, `order` b
			                    WHERE a.customer_id = b.customer_id
			                    AND DATE(a.created_at) NOT BETWEEN '".$fromdate."' AND '".$today."'
	                    		AND DATE(b.created_at) BETWEEN '".$fromdate."' AND '".$today."'")->row();
        if (!empty($returning_customers)) {
            return $returning_customers;
        }else{
        	return 0;
        }
	}

	public function average_spending_per_visit(){
		$total_visit        = $this->db->query("SELECT SUM(login_count) as total_login_count
	                        FROM customer_activities")->row();
		$total_login_count  = $total_visit->total_login_count;
		$total_purchase     = $this->db->query("SELECT SUM(total_amount) as total_purchase
	                        FROM `order`")->row();
		$sum                = $total_purchase->total_purchase;
		
		if(!($sum<=0) && !($total_login_count<=0)){
			$average_spending_per_visit = $sum/$total_login_count;
		}else{
			$average_spending_per_visit = 0;
		}

        if (!empty($average_spending_per_visit)) {
            return $average_spending_per_visit;
        }
	}

	public function average_visits_per_customer(){
		$total_visit        = $this->db->query("SELECT SUM(login_count) as total_login_count
	                        FROM customer_activities")->row();
		$total_login_count  = $total_visit->total_login_count;
		$total_customer     = $this->db->query("SELECT Count(customer_id) as total_customer
	                        FROM `customer_information`")->row();
		$sum                = $total_customer->total_customer;

		if(!($sum<=0) && !($total_login_count<=0)){
			$average_spending_per_visit = $total_login_count/$sum;
		}else{
			$average_spending_per_visit = 0;
		}

        if (!empty($average_spending_per_visit)) {
            return $average_spending_per_visit;
        }
		
	}
	
	public function positive_review_count(){
		$positive_review_count = $this->db->query("SELECT COUNT(DISTINCT reviewer_id) as positive_review_count
	        					FROM product_review")->row();
		$count = $positive_review_count->positive_review_count;
		if (!empty($positive_review_count)) {
            return $count;
        }else{
        	return 0;
        }

	}
	
}