<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *  ... Please MODIFY this file ... 
 *
 *
 *  YOUR MYSQL DATABASE DETAILS
 *
 */

 define("DB_HOST", 	$this->db->hostname);		// hostname
 define("DB_USER", 	$this->db->username);		// database username
 define("DB_PASSWORD", 	$this->db->password);	// database password
 define("DB_NAME", 	$this->db->database);		// database name



/**
 *  ARRAY OF ALL YOUR CRYPTOBOX PRIVATE KEYS
 *  Place values from your gourl.io signup page
 *  array("your_privatekey_for_box1", "your_privatekey_for_box2 (otional), etc...");
 */
 $ci =& get_instance();
 $gateway = $ci->db->select('*')->from('payment_gateway')->where('id',1)->where('status',1)->get()->row();

 $cryptobox_private_keys = array("$gateway->private_key");






 define("CRYPTOBOX_PRIVATE_KEYS", implode("^", $cryptobox_private_keys));
 unset($cryptobox_private_keys); 

?>