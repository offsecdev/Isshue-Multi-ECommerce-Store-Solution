<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Addons_model extends CI_Model {

	private $product_key = '21576648';
	private $api_url = "https://store.bdtask.com/api/products";
    private $access_key = "3b32166232ca4e50bcde73a98ec6a96c25d59567";
    private $header;
	

	public function __construct()
	{
		parent::__construct();
		$this->header = array(
            "Content-Type: application/json",
            "Authorization: Bearer ".$this->access_key
        );
	}

	// Get all modules
	public function get_modules()
	{
		$this->db->order_by('display_name','asc');
		return $this->db->get('module')->result_array();

	}

    // Get module info by ID
    public function get_module_by_id($module_id)
    {
        $this->db->where('id', $module_id);
        $result = $this->db->get('module')->row();
        return $result;
    }
    // get all active modules
    public function get_active_module_names()
    {
        $this->db->where('status',1);
        $result = $this->db->get('module')->result_array();

        $modules = [];
        if(!empty($result)){
            $modules = array_column($result, 'module_name');
        }
        return $modules;

    }

	//Update module status
	public function update_module_status($module_id, $module_status = 0)
	{
		return $this->db->update('module', array('status' => $module_status), array('id' => $module_id));

	}

	// Send Curl request
	public function send_curl_request($url){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;

    }

    public function curl_post_request($clause)
    {

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $clause->url);
        curl_setopt($curl,CURLOPT_POSTFIELDS, $clause->postdata);
        curl_setopt( $curl, CURLOPT_HTTPHEADER, $this->header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        //Set the user agent
        $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';
        curl_setopt($curl, CURLOPT_USERAGENT, $agent);
        $output = curl_exec($curl);
        curl_close($curl);


        if ($output === FALSE) {

            $result = json_encode(['error' => 'An error has occurred: ' . curl_error($curl) . PHP_EOL]);

        } else {

            $result = $output;
        }

        return $result;
    }


    // Get availble modules 
    public function search_available_modules(){

        $new_module = $this->session->userdata('add_new_module');
        if(isset($new_module) && !empty($new_module)){
            return $new_module;
        }else{
            $module_url = $this->api_url."/modules/".$this->product_key;
            $result = $this->send_curl_request($module_url);
            $this->session->set_userdata('add_new_module', $result);
            return $result;
        }

    }

    // Get availble themes 
    public function search_available_themes(){
        $new_themes = $this->session->userdata('add_new_theme');
        if(isset($new_themes) && !empty($new_themes)){
            return $new_themes;
        }else{

            $theme_url = $this->api_url."/themes?product_key=".$this->product_key."&access_key=".$this->access_key;
        	$result = $this->send_curl_request($theme_url);
            $this->session->set_userdata('add_new_theme', $result);
            return $result;
        }
    }

     // Send New Module download request
    public function send_download_request($getdata)
    {
        $url = $this->api_url."/download_module?".$getdata."&access_key=".$this->access_key;

        $return = $this->send_curl_request($url);
        
        return json_decode($return);

    }

     // Purchse New Theme
    public function purchase_new_theme($getdata)
    {

        $url = $this->api_url."/download_theme?".$getdata."&access_key=".$this->access_key;

        $return = $this->send_curl_request($url);
        
        return json_decode($return);

    } 

    //Get Downloaded Modules 
    public function get_downloaded_modules()
    {
         $path = 'application/modules/';
          $map = directory_map($path);
          $modnames = array();
          if (is_array($map) && sizeof($map) > 0){
            $modnames = array_filter(array_keys($map));
            $modnames = preg_replace('/\W/', '', $modnames);
          }
          return $modnames;
    }

    // Get all module ids
    public function get_installed_module_names()
    {
        $this->db->select('name');
        $modules = $this->db->get('module')->result_array();
        $modulenames = array_column(@$modules, 'name');
        return $modulenames;
    }

    // Verify Theme zip upload
    public function verify_zip_upload($getdata)
    {

        $url = $this->api_url."/verify_zip_upload?".$getdata."&access_key=".$this->access_key;

        $return = $this->send_curl_request($url);
        
        return json_decode($return);

    }

}