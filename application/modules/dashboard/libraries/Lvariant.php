<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lvariant
{
    //Add variant
    public function variant_add_form()
    {
        $CI =& get_instance();
        $CI->load->model('dashboard/Variants');
        $CI->load->model('dashboard/Categories');
        $categories = $CI->Categories->category_list();
        $data = array(
            'title' => display('add_variant'),
            'categories' => $categories
        );
        $customerForm = $CI->parser->parse('dashboard/variant/add_variant', $data, true);
        return $customerForm;
    }

    //Retrieve  variant List
    public function variant_list()
    {
        $CI =& get_instance();
        $CI->load->model('dashboard/Variants');
        $variant_list = $CI->Variants->variant_list();

        $i = 0;
        if (!empty($variant_list)) {
            foreach ($variant_list as $k => $v) {
                $i++;
                $variant_list[$k]['sl'] = $i;
            }
        }

        $data = array(
            'title' => display('manage_variant'),
            'variant_list' => $variant_list,
        );
        $customerList = $CI->parser->parse('dashboard/variant/variant', $data, true);
        return $customerList;
    }

    //variant Edit Data
    public function variant_edit_data($variant_id)
    {
        $CI =& get_instance();
        $CI->load->model('dashboard/Variants');
        $CI->load->model('dashboard/Categories');
        $categories = $CI->Categories->category_list();
        $variant_details = $CI->Variants->retrieve_variant_editdata($variant_id);

        $category_ids= $CI->db->query("select category_id from category_variant  where variant_id='".$variant_id."'")->result_array();
        $cids= array_column($category_ids,'category_id');

        $data = array(
            'title' => display('variant_edit'),
            'variant_id' => $variant_details[0]['variant_id'],
            'variant_name' => $variant_details[0]['variant_name'],
            'variant_type' => $variant_details[0]['variant_type'],
            'color_code' => $variant_details[0]['color_code'],
            'status' => $variant_details[0]['status'],
            'categories'=> $categories,
            'category_variants'=> $cids
        );
        $chapterList = $CI->parser->parse('dashboard/variant/edit_variant', $data, true);
        return $chapterList;
    }
}

?>