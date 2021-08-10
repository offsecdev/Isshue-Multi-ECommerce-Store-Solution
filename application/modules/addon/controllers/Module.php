<?php
/*
 * @System      : Software Addon Module
 * @developer   : Md.Mamun Khan Sabuj
 * @E-mail      : mamun.sabuj24@gmail.com
 * @datetime    : 10-10-2020
 * @version     : Version 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Module extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'module_model',
            'addons_model'
        ));

        $this->auth->check_user_auth();
    }

    public function index()
    {

        $modulesnames = $this->addons_model->get_downloaded_modules();
        $json_module = $this->addons_model->search_available_modules();

        $live_modules = [];
        if(!empty($json_module)){
            $live_modules = json_decode($json_module);
        }

        $data['live_modules'] = $live_modules;
        $data['downloaded'] = $modulesnames;

        $data['title'] = display('module_list');
        $data['module'] = "addon";
        $data['page'] = "module/list";
        echo Modules::run('template/layout', $data);
    }


    public function upload()
    {

      $this->form_validation->set_rules('purchase_key', display('purchase_key'), 'trim|required');
      if(empty($_FILES)) {
        $this->form_validation->set_rules('module', display('module'), 'trim|required');
      }

      if ($this->form_validation->run() == TRUE) {


          $purchase_key = trim($this->input->post('purchase_key',TRUE));

          $getdata = "item=module&purchase_key=".$purchase_key;

          // Check purchase key 
          $response = $this->addons_model->verify_zip_upload($getdata);

          if(!empty($response) && ($response->status == 'valid')) {

                $config['upload_path'] = './application/modules/';
                $config['allowed_types'] = 'zip|rar|gz';
                $this->load->library('upload');
                $this->upload->initialize($config);
                $overwrite = $this->input->post('overwrite',TRUE);
                $overwrite = (($overwrite != null) ? $overwrite : false);

                if ($this->upload->do_upload('module')) {
                    $data = $this->upload->data();
                    $filePath = $config['upload_path'] . $data['file_name'];

                    $this->load->library('unzip');
                    $result = $this->unzip->extract($filePath, $config['upload_path'], true, $overwrite);
                    if ($result->status) {
                        // Module Json File
                        $this->create_module_json();

                        $this->session->set_flashdata('message', $result->message);
                    } else {
                        $this->session->set_flashdata('exception', $result->message);
                    }
                } else {
                    $this->session->set_flashdata('exception', $this->upload->display_errors());
                }
                redirect("addon/module");
            }else{
                $this->session->set_flashdata('exception',display("invalid_purchase_key"));
                redirect('addon/module');
            }
        }

        $this->index();
    }


    public function install()
    {
        $this->form_validation->set_rules('name', display('module_name'), 'required|max_length[50]');
        $this->form_validation->set_rules('description', display('description'), 'trim|max_length[500]');
        $this->form_validation->set_rules('image', display('image'), 'required|max_length[100]');
        $this->form_validation->set_rules('directory', display('module'), 'required|max_length[100]|is_unique[module.directory]');
        $this->form_validation->set_message('is_unique', 'The %s is already installed');
        /*-----------------------------------*/
        $directory = $this->input->post('directory');

        /*-----------ADD TO MODULE--------------*/
        $moduleData = array(
            'id' => $this->input->post('id',TRUE),
            'name' => $this->input->post('name',TRUE),
            'description' => $this->input->post('description',FALSE),
            'image' => $this->input->post('image',TRUE),
            'directory' => $directory,
            'status' => 1
        );
        /*-----------------------------------*/
        if ($this->form_validation->run()) {

            /*----------MODULE INSTALL------------*/
            // IMPORT DATABASE
            $dbPath = APPPATH . 'modules/' . $directory . '/assets/data/database.sql';
            $configPath = APPPATH . 'modules/' . $directory . '/config/config.php';
            if (file_exists($dbPath) && file_exists($configPath)) {
                $isi_file = file_get_contents($dbPath);
                $string_query = rtrim($isi_file, "\n;");
                $array_query = explode(";", $string_query);
                $newQuery = null;
                $succe = array();
                $error = null;
                $sl = 1;

                @include($configPath);

                if (($HmvcConfig[$directory]["_database"] === true) && !empty($HmvcConfig[$directory]["_tables"]) && is_array($HmvcConfig[$directory]["_tables"]) && sizeof($HmvcConfig[$directory]["_tables"]) > 0) {

                    // Tables data
                    foreach ($HmvcConfig[$directory]["_tables"] as $key => $table) {

                        foreach ($array_query as $key2 => $query) {

                            if (is_int(strpos($query, "`$table`"))) {
                                $succe[] = $table;
                                $newQuery .= $query . ";";
                                unset($HmvcConfig[$directory]["_tables"][$key]);
                                unset($array_query[$key2]);
                                break;
                            } else {
                                $error .= "`$table`";
                                unset($HmvcConfig[$directory]["_tables"][$key]);
                                break;
                            }
                        }
                    }

                    if (strlen($error) > 0) {
                        $this->session->set_flashdata('exception', $error . display('tables_are_not_available_in_database'));
                        redirect("addon/module");
                    } else {
                        $n_query = rtrim($newQuery, "\n;");
                        $n_query = explode(";", $n_query);
                        $i = 0;
                        foreach ($n_query as $sql) {
                            if (!$this->db->table_exists($succe[$i++])) {
                                $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
                                $this->db->query($sql);
                                $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
                            }
                        }

                        /*----------ADD TO MODULE ------------*/
                        if ($this->module_model->create($moduleData)) {
                            // add a install flag
                            @file_put_contents(
                                APPPATH . 'modules/' . $directory . '/assets/data/env',
                                date('d-m-Y')
                            );

                            $this->session->set_flashdata('message', display('module_added_successfully'));
                        } else {
                            $this->session->set_flashdata('exception', display('please_try_again'));
                        }
                    }
                } else if ($HmvcConfig[$directory]["_database"] === false) {
                    /*----------ADD TO MODULE ------------*/
                    if ($this->module_model->create($moduleData)) {
                        // add a install flag
                        @file_put_contents(
                            APPPATH . 'modules/' . $directory . '/assets/data/env',
                            date('d-m-Y')
                        );

                        $this->session->set_flashdata('message', display('module_added_successfully'));
                    } else {
                        $this->session->set_flashdata('exception', display('please_try_again'));
                    }
                } else {
                    $this->session->set_flashdata('exception', display('no_tables_are_registered_in_config'));
                }

                 // Data insert/update into existing table
                if ($HmvcConfig[$directory]["_extra_query"] === true) {
                    $extra_query = APPPATH . 'modules/' . $directory . '/assets/data/install.sql';
                    if (file_exists($extra_query) && file_exists($configPath)) {

                        $equery_file = file_get_contents($extra_query);
                        $equery_string = trim($equery_file);
                        
                        if(!empty($equery_string)){

                            $equery_list = explode(";", $equery_string);
                            $this->db->trans_start();
                            foreach ($equery_list as $equery_item) {
                                if(!empty($equery_item)){
                                    $this->db->query($equery_item);
                                }
                            }
                            $this->db->trans_complete();
                        }
                    }
                }


            } else {
                $this->session->set_flashdata('exception', display('please_try_again'));
            }
            redirect("addon/module");

        } else {
            $this->session->set_flashdata('exception', validation_errors());
        }
        redirect("addon/module");
    }

    // Uninstall Module
    public function uninstall($dirPath = null, $action = null)
    {
        $directory = $dirPath;
        $basePath = "application/modules/";
        $dirPath = $basePath . urldecode($dirPath);

        if (is_dir($dirPath) && $dirPath != $basePath) {

            /*-------DELETE MODULE DATABASE---------*/
            $configPath = APPPATH . 'modules/' . $directory . '/config/config.php';
            if (file_exists($configPath)) {

                @include($configPath);

                if (!empty($HmvcConfig[$directory]["_tables"]) && is_array($HmvcConfig[$directory]["_tables"]) && sizeof($HmvcConfig[$directory]["_tables"]) > 0) {

                    foreach ($HmvcConfig[$directory]["_tables"] as $table) {
                        if ($this->db->table_exists($table)) {
                            $this->db->query("DROP TABLE `$table`");
                        }
                    }
                }
            }

            // Uninstall Extra query
            if ($HmvcConfig[$directory]["_extra_query"] === true) {
                $extra_query = APPPATH . 'modules/' . $directory . '/assets/data/uninstall.sql';
                if (file_exists($extra_query) && file_exists($configPath)) {

                    $equery_file = file_get_contents($extra_query);
                    $equery_string = trim($equery_file);
                    
                    if(!empty($equery_string)){

                        $equery_list = explode(";", $equery_string);
                        $this->db->trans_start();
                        foreach ($equery_list as $equery_item) {
                            if(!empty($equery_item)){
                                $this->db->query($equery_item);
                            }
                        }
                        $this->db->trans_complete();
                    }
                }
            }


            if ($action == "delete") {
                $this->delete_dir($dirPath);
            }
            /*-------DELETE FROM MODULE LIST---------*/
            $this->module_model->delete_by_directory($directory);
            //delete the install flag
            if (file_exists(APPPATH . 'modules/' . $directory . '/assets/data/env'))
                @unlink(APPPATH . 'modules/' . $directory . '/assets/data/env');

            $this->session->set_flashdata('message', display('delete_successfully'));


        } else if (is_file($dirPath) && $dirPath != $basePath) {
            if (unlink($dirPath)) {
                $this->session->set_flashdata('message', display('delete_successfully'));
            } else {
                $this->session->set_flashdata('exception', display('please_try_again'));
            }
        } else {
            $this->session->set_flashdata('exception', display('please_try_again'));
        }

        redirect($_SERVER['HTTP_REFERER']);
    }

    // Change Module Status
    public function status($id = null, $action = null)
    {
        $action = ($action == 'active' ? 1 : 0);

        $data = array(
            'id' => $id,
            'status' => $action
        );

        if ($this->module_model->update($data)) {
            $this->session->set_flashdata('message', display('update_successfully'));
        } else {
            $this->session->set_flashdata('exception', display('please_try_again'));
        }

        redirect($_SERVER['HTTP_REFERER']);
    }


    public function delete_dir($dirPath)
    {
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
        rmdir($dirPath);
        // Module Json File
        $this->create_module_json();
        return true;
    }

      // Download Module
    public function download_module(){


      $data = array(
          'title'  => display('download')
      );
      $content = $this->parser->parse('module/download',$data,true);
      $this->template_lib->full_admin_html_view($content);
    }

    // Unzip Files
    private function unzip_files($zip_file)
    {

      $path = pathinfo( realpath( $zip_file ), PATHINFO_DIRNAME );

      $zip = new ZipArchive;
      $res = $zip->open($zip_file);
      if ($res === TRUE) {
          $zip->extractTo( $path );
          $zip->close();
      }
      return $res;

    }

    // Create Module Json File
    private function create_module_json()
    {
      $path = 'application/modules/';
      $map = directory_map($path);
      $HmvcMenu = array();
      if (is_array($map) && sizeof($map) > 0){
          foreach ($map as $key => $value) {
              $menu = str_replace("\\", '/', $path . $key . 'config/menu.php');
              if (file_exists($menu)) {
                  @include($menu);
              }
          }
      }

      if (isset($HmvcMenu) && $HmvcMenu != null && sizeof($HmvcMenu) > 0){
        foreach ($HmvcMenu as $moduleName => $moduleData) {
          $jsonvalue[] = array('label'=>$moduleName,'value'=>$moduleName);
        }
        $cache_file ='./my-assets/js/admin_js/json/addon.json';
        $itemlist = json_encode($jsonvalue);
        file_put_contents($cache_file,$itemlist);
      }

    }


    // Verify Module
    public function verify_download_request() {


      $purchase_key = $this->input->post('purchase_key',TRUE);
      $itemtype = $this->input->post('itemtype',TRUE);

      if(!empty($purchase_key) && !empty($itemtype)) {

        $getdata = "item=module&purchase_key=".trim($purchase_key);

        $result = $this->addons_model->send_download_request($getdata);


          if ($result->status == 'valid') {

            $filename = "New_module_".time().'.zip';
            $destination = APPPATH.'modules/'.$filename;
            $copydata = copy($result->download_url, $destination);

            if($copydata) 
            {
              // unzip files
              $unzip = $this->unzip_files($destination);
              if($unzip) {
                unlink($destination);

                // Module Json File
                $this->create_module_json();

                $this->session->set_flashdata('message', "Downloaded Successfully");
                echo TRUE;
                exit();
              
              }

            }
          } 
      } 
      $this->session->set_flashdata('exception', "Invalid Request");
      echo false;

    }


}
