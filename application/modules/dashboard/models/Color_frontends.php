<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Color_frontends extends CI_Model
{

//get frontend template color
    public function retrieve_color_editdata($theme = 'default')
    {
        $this->db->select('*');
        $this->db->from('color_frontends');
        $this->db->where('theme', $theme);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

//update frontend template color
    public function update_color($data, $theme_name='default')
    {
        $this->db->where('theme', $theme_name);
        $this->db->update('color_frontends', $data);
        return true;
    }

}