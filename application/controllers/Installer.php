<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Installer extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

	public function index(){
		//Checking if env file exists then will come here after installation
		if (file_exists(FCPATH.'install/flag/env') || is_dir(FCPATH.'install')) {
			
			$data['title'] = 'Installer Remove';

			$this->load->view('installer/installer_remove', $data);

		}else{

			redirect(base_url());
		}
	}

	public function remove_installer(){
		// Remove the installer
		if($this->remove_installer_now()){

			$data['title'] = 'Launch Application';

			$this->load->view('installer/launch_application', $data);

		}else{

			// If installer can't be removed then redirect in same page where instructions gievn to delete manually

			if (file_exists(FCPATH.'install/flag/env') || is_dir(FCPATH.'install')) {
				
				$data['title'] = 'Remove Installer Manually';

				$this->session->set_userdata(array('error_msg' => "You don't have permission to delete the installer."));

				$this->load->view('installer/installer_remove', $data);
				
			}else{
				
				redirect(base_url());
			}
			
		}
	}

	private function remove_installer_now(){

	// Check if env file exists

	if (file_exists(FCPATH.'install/flag/env')) {

		$dirPath = FCPATH.'install';
		
		if($this->delete_dir($dirPath)){
			return true;
		}else{
			return false;
		}
		
	 }
	 return false;

	}

	private function delete_dir($dirPath){

		$dir = opendir($dirPath);

		while (false !== ($file = readdir($dir))) {
		    if (($file != '.') && ($file != '..')) {
		        if (is_dir($dirPath . '/' . $file)) {
		            $this->delete_dir($dirPath . '/' . $file);
		        } else {
		            unlink($dirPath . '/' . $file);
		        }
		    }
		}
		closedir($dir);

		if(rmdir($dirPath)){
		 	return true;
		 }else{
		 	return false;
		 }
	}

	//Getting data from system/core/compat/index.html
	public function get_core_data(){

		if (file_exists(SYSDIR.'/core/compat/index.html')) {

			$respo = file_get_contents(SYSDIR.'/core/compat/index.html');

			echo $respo;

		}else{

			$err['msg'] = "error";
			echo json_encode($err);
		}
		
	}

}