<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// -------------------------------------------------------------
// Paypal IPN Class
//--------------------------------------------------------------

// PayPal Data
$ci =& get_instance();
$paypal = $ci->db->select('paypal_email, currency,status, is_live')
    ->from('payment_gateway')
    ->where('used_id',5)
    ->get()
    ->row();  

$sandbox = "";

if ($paypal) {
	if ($paypal->is_live == 1) {
		$sandbox = FALSE;
	}else{
		$sandbox = TRUE;
	}
}



// Use PayPal on Sandbox or Live
$config['sandbox'] = $sandbox; // FALSE for live environment

// PayPal Business Email ID
$config['business'] = (!empty($paypal->paypal_email)?$paypal->paypal_email:'fleet_business@example.com');

// What is the default currency?
$config['paypal_lib_currency_code'] = (!empty($paypal->currency)?$paypal->currency:'USD');

// If (and where) to log ipn to file
$config['paypal_lib_ipn_log_file'] = BASEPATH . 'logs/paypal_ipn.log';
$config['paypal_lib_ipn_log'] = TRUE;

// Where are the buttons located at 
$config['paypal_lib_button_path'] = 'buttons';