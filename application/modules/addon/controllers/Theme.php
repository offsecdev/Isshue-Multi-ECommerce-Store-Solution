<?php
/*
 * @System      : Software Addon Module
 * @developer   : Md.Mamun Khan Sabuj
 * @E-mail      : mamun.sabuj24@gmail.com
 * @datetime    : 10-10-2020
 * @version     : Version 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');
class Theme extends MX_Controller {

  private $theme_tbl = 'themes';
  private $theme_location = APPPATH.'modules/web/views/themes/';

	function __construct() {
      	parent::__construct();
      	$this->load->model(array('themes_model', 'addons_model'));
        $this->auth->check_user_auth();
    }
    public function index()
    {
        $active_theme = $this->themes_model->get_theme();
        $themes = $this->themes_model->get_themes();

        $installed_themes = $this->themes_model->get_installed_themes_ids();
        $json_theme = $this->addons_model->search_available_themes();

        $new_items = [];
        if(!empty($json_theme)){
          $new_items = json_decode($json_theme);
        }

        $data = array(
            'title'       => display('themes'), 
            'active_theme' => $active_theme,
            'themes' => $themes,
            'new_items' => $new_items,
            'installed' => $installed_themes
        );
        $content = $this->parser->parse('theme/list', $data, true);
        $this->template_lib->full_admin_html_view($content);
    }

    public function active_theme($name)
    {
        $this->db->set('status', 1)->where('name', $name)->update('themes');
        $this->db->set('status', 0)->where('name !=', $name)->update('themes');
        $sdata['message'] = display("theme_active_successfully");
        $this->session->set_flashdata($sdata);
        redirect('addon/theme');
    }

    #------------------------------------
    # To upload new theme
    #------------------------------------
    public function upload_new_theme()
    {

      $this->form_validation->set_rules('purchase_key', display('purchase_key'), 'trim|required');
      $this->form_validation->set_rules('theme_name', display('theme_name'), 'trim|required');

      if(empty($_FILES)) {
        $this->form_validation->set_rules('new_theme', display('upload'), 'trim|required');
      }
      
      if ($this->form_validation->run() == TRUE) {


          $purchase_key = trim($this->input->post('purchase_key',TRUE));
          $theme_name = trim($this->input->post('theme_name',TRUE));

          $getdata = "item=theme&purchase_key=".$purchase_key;

          // Check purchase key 
          $response = $this->addons_model->verify_zip_upload($getdata);
          if(!empty($response) && ($response->status == 'valid')) {

            $filename = $_FILES["new_theme"]["name"];
            $source = $_FILES["new_theme"]["tmp_name"];
            $type = $_FILES["new_theme"]["type"];
            $target_dir = 'application/modules/web/views/themes';
            
            // naming for theme
            if ($theme_name !== '') {

              $dir = get_unspace_text(strtolower($theme_name));
              $target_dir = 'application/modules/web/views/themes/';
            }

            ini_set('memory_limit', '800M');
            ini_set('upload_max_filesize', '800M');
            ini_set('post_max_size', '800M');
            ini_set('max_input_time', 3600);
            ini_set('max_execution_time', 3600);

            $config = array();
            $config['upload_path'] = './application/modules/web/views/themes/';
            $config['allowed_types'] = '*';
            $config['max_size'] = 480000;
            $config['overwrite'] = FALSE;
            $config['encrypt_name'] = FALSE;

            $this->upload->initialize($config);
            if (!$this->upload->do_upload('new_theme')) {
                $sdata['exception'] = display("the_theme_has_not_uploaded");
                redirect('addon/theme');
            } else {
                $data = array('upload_data' => $this->upload->data());
                $name = explode(".", $filename);
                $zip = new ZipArchive();
                $x = $zip->open($source);
                if ($x === true) {
                    $zip->extractTo($target_dir . '/' . $dir . '/'); // place in the directory with same name
                    $zip->close();
                    @unlink($target_dir . '/' . $filename); // delete zip file
                    chmod($target_dir . $dir, 0777); //change uploaded file permission
                    $this->themes_model->store($dir); //insert store name into database
                    $sdata['message'] = display("theme_uploaded_successfully");
                } else {
                    $sdata['exception'] = display("there_was_a_problem_with_the_upload");
                }
                $this->session->set_flashdata($sdata);
                redirect('addon/theme');
            }
          }else{
            $this->session->set_flashdata('exception',display("invalid_purchase_key"));
            redirect('addon/theme');
          }
        }

        $this->index();
        

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

    // Download Theme
    public function download_theme(){

      $data = array(
          'title'       => display('themes')
      );
      $content = $this->parser->parse('theme/download',$data,true);
      $this->template_lib->full_admin_html_view($content);

    }

    // Verify Theme Purchase
    public function verify_theme_download() {


      $purchase_key = trim($this->input->post('purchase_key',TRUE));

      if(!empty($purchase_key)){

        $getdata = "item=theme&purchase_key=".$purchase_key;

        $result = $this->addons_model->purchase_new_theme($getdata);

          if ($result->status == 'valid') {

            $filename = "New_theme_".time().'.zip';
            $destination = $this->theme_location.$filename;
            $copydata = copy($result->download_url, $destination);

            if($copydata) 
            {
              // unzip files
              $unzip = $this->unzip_files($destination);
              if($unzip) {
                unlink($destination);

                $tdata = array(
                  'name' => $result->identity,
                  'status' => 0
                );
                $result = $this->db->insert($this->theme_tbl, $tdata);

                if($result){
                  $this->session->set_flashdata('message', display('downloaded_successfully'));
                      echo TRUE;
                      exit();
                }
              }
            }
        } 
      } 
      $this->session->set_flashdata('error_message', display('failed_try_again'));
      echo false;
    }

     
     // Recursivly Delete a whole directory
     private function delete_dir($dirPath)
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
        return true;
    }


    // Theme Delete
    public function theme_delete()
    {
      $theme_name = $this->input->post('theme',TRUE);
      $result = false;
      if(!empty($theme_name)){
        $result = $this->db->delete('themes', array('name' => $theme_name));
        if($result){
          $theme_path = $this->theme_location.$theme_name;
          $this->delete_dir($theme_path);
        }
      }
      echo $result;
    }

  }