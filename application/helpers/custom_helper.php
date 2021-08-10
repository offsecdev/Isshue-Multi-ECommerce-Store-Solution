<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('remove_space')){
    function remove_space($str, $limit = false) {
        if ($limit) {
            $str = mb_substr($str, 0, $limit, "utf-8");
        }
        $text = html_entity_decode($str, ENT_QUOTES, 'UTF-8');
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        // trim
        $text = trim($text, '-');
        return $text;
    }
}
if ( ! function_exists('get_unspace_text'))
{
    function get_unspace_text($var = '')    {
       $string = str_replace(' ','_', $var);
        return preg_replace('/[^A-Za-z0-9\_]/', '', $string);
    }
}

if ( ! function_exists('remove_hyphen'))
{
    function remove_hyphen($var = '')    {
     return  $string = str_replace('-',' ', $var);
    }
}

if(!function_exists('dd')){
    function dd($data=''){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        exit();
    }
}

if(!function_exists('d')){
    function d($data=''){
        echo "<pre>";
        print_r($data);
        echo "</pre>";        
    }
}
//remove special character
function clean($string) {
    return preg_replace('/[^A-Za-z0-9\-\ ]/', '', $string); // Removes special chars.
}

//This function is used to Generate Key
    function generator($lenth)
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
            $con="$con"."$rand_number";}
        }
        return $con;
    }
    
if ( ! function_exists('serverAliveOrNot')){

    function serverAliveOrNot($host = '', $port = 80){
        if(empty($host)){
            $host = base_url();
        }
        $socket = fsockopen($host, $port, $errno, $errstr, 15);
          if(!$socket)
          {
            return false;
          }
          else
          {
            return true;
          }
    }
}

    
if ( ! function_exists('check_module_status')){
    function check_module_status($module){
       $CI =& get_instance();
       $result = $CI->db->where('directory',$module)->where('status',1)->get('module')->num_rows();
       if($result>0){
        return TRUE;
       }else{
        return FALSE;
       }
    }
}

if ( ! function_exists('get_amount')){
    function get_amount($amount){
       $CI =& get_instance();

       $currency_new_id = $CI->session->userdata('currency_new_id');
        $target_con_rate = 1;
        $position1 = 0;
        $currency1 = '$';

        if (empty($currency_new_id)) {
            $curinfo = $cur_info = $CI->db->select('*')
                ->from('currency_info')
                ->where('default_status', '1')
                ->get()
                ->row();
            $currency_new_id = $curinfo->currency_id;
        }

        
        if (!empty($currency_new_id)) {
            $cur_info = $CI->db->select('*')
                ->from('currency_info')
                ->where('currency_id', $currency_new_id)
                ->get()
                ->row();

            $target_con_rate = $cur_info->convertion_rate;
            $position1 = $cur_info->currency_position;
            $currency1 = $cur_info->currency_icon;
        }

        if ($target_con_rate > 1) {
            $amount = $amount * $target_con_rate;
            $con_amount = (($position1 == 0) ? $currency1 . " " . number_format($amount, 2, '.', ',') : number_format($amount, 2, '.', ',') . " " . $currency1);
        }

        if ($target_con_rate <= 1) {
            $amount = $amount * $target_con_rate;
            $con_amount = (($position1 == 0) ? $currency1 . " " . number_format($amount, 2, '.', ',') : number_format($amount, 2, '.', ',') . " " . $currency1);
        }
        return $con_amount;
    }
}