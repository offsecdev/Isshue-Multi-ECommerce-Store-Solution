<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*
* ---------------how to use-----------------
* ------------------------------------------
* Developed by <mamun.sabuj24@gmail.com>
*
* $autoload['helper'] =  array('lang');

* display a language
* echo display('helloworld'); 

* display language list
* $lang = languageList(); 
* ------------------------------------------
*
*/


if (!function_exists('display')) {

    function display($text = null)
    {
        $ci =& get_instance();
        $ci->load->database();
        $table  = 'language';
        $phrase = 'phrase';
        $setting_table = 'soft_setting';
        
        //set language  
        $data = $ci->db->get($setting_table)->row();
        if (!empty($data->language)) {
            $default_lang = $data->language; 
        }else{
            $default_lang  = 'english';
        }

        $user_lang = $ci->session->userdata('language');
        if (!empty($user_lang)) {
            $language = $user_lang; 
        } else {
            $language = $default_lang; 
            $ci->session->set_userdata('language',$language);
        } 
 
        if (!empty($text)) {

            if ($ci->db->table_exists($table)) { 

                if ($ci->db->field_exists($phrase, $table)) { 

                    if ($ci->db->field_exists($language, $table)) {

                        $row = $ci->db->select($language)
                              ->from($table)
                              ->where($phrase, $text)
                              ->get()
                              ->row(); 

                        if (!empty($row->$language)) {
                            return html_escape($row->$language);
                        } else {
                            return false;
                        }

                    } else {
                        return false;
                    }

                } else {
                    return false;
                }

            } else {
                return false;
            }            
        } else {
            return false;
        }  

    }
 
}

