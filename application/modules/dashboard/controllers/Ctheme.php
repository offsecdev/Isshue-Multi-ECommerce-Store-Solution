<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ctheme extends MX_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model(array(
            'dashboard/Themes'
        ));
        $this->auth->check_user_auth();

    }

    public function index()
    {
        $theme = $this->Themes->get_theme();
        $themes = $this->Themes->get_themes();
        $data = [
            'theme' => $theme,
            'themes' => $themes
        ];
        $content = $this->parser->parse('theme/index', $data, true);
        $this->template_lib->full_admin_html_view($content);
    }

    public function active_theme($name)
    {
        $this->db->set('status', 1)->where('name', $name)->update('themes');
        $this->db->set('status', 0)->where('name !=', $name)->update('themes');
        $sdata['message'] = display("theme_active_successfully");
        $this->session->set_userdata($sdata);
        redirect('dashboard/Ctheme');
    }

    #------------------------------------
    # To upload new theme
    #------------------------------------
    public function upload_new_theme()
    {
        $filename = $_FILES["new_theme"]["name"];
        $source = $_FILES["new_theme"]["tmp_name"];
        $type = $_FILES["new_theme"]["type"];
        $target_dir = 'application/modules/web/views/themes';
        $theme_name = trim($this->input->post('theme_name',TRUE));
        // naming for theme
        if ($theme_name !== '') {
            $space_exist = preg_match('/\s/', $theme_name);
            if ($space_exist > 0) {
                $dir = str_replace(' ', '_', $theme_name);
                $target_dir = 'application/modules/web/views/themes/';
            } else {
                $dir = $theme_name;
                $target_dir = 'application/modules/web/views/themes/';
            }
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
            redirect('dashboard/Ctheme');
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
                $this->Themes->store($dir); //insert store name into database
                $sdata['message'] = display("theme_uploaded_successfully");
            } else {
                $sdata['exception'] = display("there_was_a_problem_with_the_upload");
            }
            $this->session->set_userdata($sdata);
            redirect('dashboard/Ctheme');
        }

    }
}