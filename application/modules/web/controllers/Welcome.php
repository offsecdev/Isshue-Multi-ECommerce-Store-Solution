<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('web/Lhome');

    }


    public function index()
    {
    $content = $this->lhome->home_page();
       $this->template_lib->full_website_html_view($content);
    }


}
