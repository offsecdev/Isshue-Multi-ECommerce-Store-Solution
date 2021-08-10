<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Themes extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
//insert theme into database
    public function store($name)
    {
        $data=[
            'name'=>$name,
            'status'=>0
        ];
        $this->db->insert('themes',$data);
        return TRUE;
    }
    //get default theme
    public function get_theme()
    {
        $theme = $this->db->select('name')->from('themes')->where('status',1)->get()->row();
        return $theme->name;
    }

    //get all theme
    public function get_themes()
    {
        $themes = $this->db->select('*')->from('themes')->get()->result();
        return $themes;
    }

}