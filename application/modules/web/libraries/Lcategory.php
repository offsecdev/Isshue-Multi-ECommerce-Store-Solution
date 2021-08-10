<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lcategory
{

    //Category product
    public function category_product($cat_id, $links, $per_page, $page, $price_range = null, $size = null, $brand = null, $rate = null)
    {
        $CI =& get_instance();
        $CI->load->model('web/Categories');

        $CI->load->model('web/Homes');
        $CI->load->model('dashboard/web_settings');
        $CI->load->model('dashboard/Soft_settings');
        $CI->load->model('dashboard/Blocks');
        $CI->load->model('dashboard/Variants');
        $CI->load->model('dashboard/Themes');
        $theme = $CI->Themes->get_theme();
        $max_value = 0;
        $min_value = 0;
        $category_product = $CI->Categories->category_product($cat_id, $per_page, $page, $price_range, $size, $brand, $rate);
        $category = $CI->Categories->select_single_category($cat_id);

        $categoryList = $CI->Homes->parent_category_list();
        $pro_category_list = $CI->Homes->category_list();
        $best_sales = $CI->Homes->best_sales();
        $footer_block = $CI->Homes->footer_block();
        $block_list = $CI->Blocks->block_list();
        $currency_details = $CI->Soft_settings->retrieve_currency_info();
        $Soft_settings = $CI->Soft_settings->retrieve_setting_editdata();
        $languages = $CI->Homes->languages();
        $currency_info = $CI->Homes->currency_info();
        $selected_currency_info = $CI->Homes->selected_currency_info();
        $selected_default_currency_info = $CI->Homes->selected_default_currency_info();
        $variant_list = $CI->Variants->category_wise_variant_list($cat_id);
        $max_value = $CI->Categories->select_max_value_of_cat_pro($cat_id, 1);
        $min_value = $CI->Categories->select_max_value_of_cat_pro($cat_id, 0);
        $select_category_adds = $CI->Homes->select_category_adds();
        //Max value and min value
        if ($max_value == $min_value) {
            $min_value = 0;
        }

        //Price range
        $from_price = 0;
        $to_price = 0;
        if (!(empty($price_range))) {
            $ex = explode("-", $price_range);
            $from_price = $ex[0];
            $to_price = $ex[1];
        }

        if (empty($category_product)) {
            $total = 0;
        } else {
            $total = count($category_product);
        }

        $data = array(
            'title' => $category[0]['category_name'],
            'category_product' => $category_product,
            'pro_category_list' => $pro_category_list,
            'category_id' => $cat_id,
            'total' => $total,
            'keyword' => $category[0]['category_name'],
            'category_list' => $categoryList,
            'block_list' => $block_list,
            'best_sales' => $best_sales,
            'footer_block' => $footer_block,
            'Soft_settings' => $Soft_settings,
            'languages' => $languages,
            'currency_info' => $currency_info,
            'default_currency_icon' => $selected_default_currency_info->currency_icon,
            'selected_cur_id' => (($selected_currency_info->currency_id) ? $selected_currency_info->currency_id : ""),
            'category_name' => $category[0]['category_name'],
            'currency' => $currency_details[0]['currency_icon'],
            'position' => $currency_details[0]['currency_position'],
            'links' => $links,
            'variant_list' => $variant_list,
            'max_value' => (!empty($max_value) ? $max_value : 0),
            'min_value' => (!empty($min_value) ? $min_value : 0),
            'from_price' => $from_price,
            'to_price' => $to_price,
            'select_category_adds' => $select_category_adds
        );
        $HomeForm = $CI->parser->parse('web/themes/' . $theme . '/category', $data, true);
        return $HomeForm;
    }

    //Category wise product
    public function category_wise_product($cat_id, $links, $per_page, $page)
    {
        $CI =& get_instance();
        $CI->load->model('web/Categories');
        $CI->load->model('web/Homes');
        $CI->load->model('dashboard/web_settings');
        $CI->load->model('dashboard/Soft_settings');
        $CI->load->model('dashboard/Blocks');
        $CI->load->model('dashboard/Themes');
        $theme = $CI->Themes->get_theme();
        $max_value = 0;
        $min_value = 0;

        $category_wise_product = $CI->Categories->category_wise_product($cat_id, $per_page, $page);
        $category = $CI->Categories->select_single_category($cat_id);

        $categoryList = $CI->Homes->parent_category_list();
        $best_sales = $CI->Homes->best_sales();
        $footer_block = $CI->Homes->footer_block();
        $block_list = $CI->Blocks->block_list();
        $pro_category_list = $CI->Homes->category_list();
        $currency_details = $CI->Soft_settings->retrieve_currency_info();
        $Soft_settings = $CI->Soft_settings->retrieve_setting_editdata();
        $languages = $CI->Homes->languages();
        $currency_info = $CI->Homes->currency_info();
        $selected_currency_info = $CI->Homes->selected_currency_info();
        $max_value = $CI->Categories->select_max_value_of_pro($cat_id);
        $min_value = $CI->Categories->select_min_value_of_pro($cat_id);
        $select_category_product = $CI->Categories->select_category_product();
        $selected_default_currency_info = $CI->Homes->selected_default_currency_info();
        $select_category_adds = $CI->Homes->select_category_adds();

        //Max value and min value
        if ($max_value == $min_value) {
            $min_value = 0;
        }

        //Price range
        $from_price = 0;
        $to_price = 0;
        if (!(empty($price_range))) {
            $ex = explode("-", $price_range);
            $from_price = $ex[0];
            $to_price = $ex[1];
        }

        if (empty($category_wise_product)) {
            $total = 0;
        } else {
            $total = count($category_wise_product);
        }

        $data = array(
            'title'                  => display('category_wise_product'),
            'category_wise_product'  => $category_wise_product,
            'category_name'          => $category[0]['category_name'],
            'category_id'            => $category[0]['category_id'],
            'category_list'          => $categoryList,
            'total'                  => $total,
            'block_list'             => $block_list,
            'best_sales'             => $best_sales,
            'footer_block'           => $footer_block,
            'pro_category_list'      => $pro_category_list,
            'Soft_settings'          => $Soft_settings,
            'languages'              => $languages,
            'currency_info'          => $currency_info,
            'default_currency_icon'  => $selected_default_currency_info->currency_icon,
            'selected_cur_id'        => (($selected_currency_info->currency_id) ? $selected_currency_info->currency_id : ""),
            'select_category_product'=> $select_category_product,
            'max_value'              => $max_value[0]['price'],
            'min_value'              => $min_value[0]['price'],
            'from_price'             => $from_price,
            'to_price'               => $to_price,
            'currency'               => $currency_details[0]['currency_icon'],
            'position'               => $currency_details[0]['currency_position'],
            'links'                  => $links,
            'select_category_adds'   => $select_category_adds
        );
        $HomeForm = $CI->parser->parse('web/themes/' . $theme . '/category', $data, true);
        return $HomeForm;
    }

    //Retrieve  category List
    public function category_list()
    {
        $CI =& get_instance();
        $CI->load->model('web/Categories');
        $category_list = $CI->Categories->category_list();  //It will get only Credit category
        $i = 0;
        $total = 0;
        if (!empty($category_list)) {
            foreach ($category_list as $k => $v) {
                $i++;
                $category_list[$k]['sl'] = $i;
            }
        }
        $data = array(
            'title' => 'Categories List',
            'category_list' => $category_list,
        );
        $categoryList = $CI->parser->parse('dashboard/category/category', $data, true);
        return $categoryList;
    }

    //category Edit Data
    public function category_edit_data($category_id)
    {
        $CI =& get_instance();
        $CI->load->model('web/Categories');
        $category_detail = $CI->Categories->retrieve_category_editdata($category_id);
        $data = array(
            'category_id' => $category_detail[0]['category_id'],
            'category_name' => $category_detail[0]['category_name'],
            'status' => $category_detail[0]['status']
        );
        $chapterList = $CI->parser->parse('dashboard/category/edit_category_form', $data, true);
        return $chapterList;
    }

    //Category product search
    public function category_product_search($product_name, $filter = [])
    {

        $CI =& get_instance();
        $CI->load->model('web/Categories');
        $CI->load->model('web/Homes');
        $CI->load->model('dashboard/web_settings');
        $CI->load->model('dashboard/Soft_settings');
        $CI->load->model('dashboard/Blocks');
        $CI->load->model('dashboard/Themes');
        $CI->load->model('dashboard/Variants');
        $CI->load->model('dashboard/Search_history');
        $theme = $CI->Themes->get_theme();

        $category_product = $CI->Categories->retrieve_category_product($product_name,$filter);
        $brand_list = $CI->Categories->get_filter_brand_list($product_name);

        $categoryList = $CI->Homes->parent_category_list();
        $best_sales = $CI->Homes->best_sales();
        $footer_block = $CI->Homes->footer_block();
        $block_list = $CI->Blocks->block_list();
        $currency_details = $CI->Soft_settings->retrieve_currency_info();
        $pro_category_list = $CI->Homes->category_list();

        $languages = $CI->Homes->languages();
        $currency_info = $CI->Homes->currency_info();
        $selected_currency_info = $CI->Homes->selected_currency_info();
        $Soft_settings = $CI->Soft_settings->retrieve_setting_editdata();
        $select_category_adds = $CI->Homes->select_category_adds();

        $selected_default_currency_info = $CI->Homes->selected_default_currency_info();
        if (empty($category_product)) {
            $total = 0;
        } else {
            $total = count($category_product);
        }
        $search_data = array(
            'keyword' => $product_name,
            'results' => $total,
        );
        $insert_search = $CI->Search_history->insert_search_history($search_data);
        $data = array(
            'title' => display('category_product_search'),
            'category_product' => $category_product,
            'brand_list' => $brand_list,
            'keyword' => $product_name,
            'after_search' => 'after_search',
            'total' => $total,
            'category_list' => $categoryList,
            'block_list' => $block_list,
            'best_sales' => $best_sales,
            'footer_block' => $footer_block,
            'pro_category_list' => $pro_category_list,
            'category_name' => $category_name = '',
            'currency' => $currency_details[0]['currency_icon'],
            'position' => $currency_details[0]['currency_position'],
            'links' => '',
            'Soft_settings' => $Soft_settings,
            'languages' => $languages,
            'currency_info' => $currency_info,
            'select_category_adds' => $select_category_adds,
            'max_value' => 0,
            'min_value' => 0,
            'from_price' => 0,
            'to_price' => 0,
            'category_id'=>'',
            'default_currency_icon' => $selected_default_currency_info->currency_icon,
            'selected_cur_id' => (($selected_currency_info->currency_id) ? $selected_currency_info->currency_id : ""),
        );
        $categoryList = $CI->parser->parse('web/themes/' . $theme . '/product_search', $data, true);
        return $categoryList;
    }
    
    //Category product search
    public function search_catproduct_lib($filter = [])
    {

        $CI =& get_instance();
        $CI->load->model('web/Categories');
        $CI->load->model('web/Homes');
        $CI->load->model('dashboard/web_settings');
        $CI->load->model('dashboard/Soft_settings');
        $CI->load->model('dashboard/Themes');
        $theme = $CI->Themes->get_theme();

        $product_name = $filter['product_name'];
        $category_id = $filter['category_id'];

        $category_product = $CI->Categories->get_category_product($filter);
        $categoryList = $CI->Homes->parent_category_list();
        $footer_block = $CI->Homes->footer_block();
        $currency_details = $CI->Soft_settings->retrieve_currency_info();
        $pro_category_list = $CI->Homes->category_list();

        $languages = $CI->Homes->languages();
        $currency_info = $CI->Homes->currency_info();
        $selected_currency_info = $CI->Homes->selected_currency_info();
        $Soft_settings = $CI->Soft_settings->retrieve_setting_editdata();
        $select_category_adds = $CI->Homes->select_category_adds();

        $selected_default_currency_info = $CI->Homes->selected_default_currency_info();
        if (empty($category_product)) {
            $total = 0;
        } else {
            $total = count($category_product);
        }

        $data = array(
            'title' => display('category_product_search'),
            'category_product' => $category_product,
            'keyword' => $product_name,
            'category_id'=>$category_id,
            'after_search' => 'after_search',
            'total' => $total,
            'category_list' => $categoryList,
            'footer_block' => $footer_block,
            'pro_category_list' => $pro_category_list,
            'category_name' => $category_name = '',
            'currency' => $currency_details[0]['currency_icon'],
            'position' => $currency_details[0]['currency_position'],
            'links' => '',
            'Soft_settings' => $Soft_settings,
            'languages' => $languages,
            'currency_info' => $currency_info,
            'select_category_adds' => $select_category_adds,
            'max_value' => 1000,
            'min_value' => 0,
            'from_price' => 0,
            'to_price' => 1000,
            'default_currency_icon' => $selected_default_currency_info->currency_icon,
            'selected_cur_id' => (($selected_currency_info->currency_id) ? $selected_currency_info->currency_id : ""),
        );
        $categoryList = $CI->parser->parse('web/themes/' . $theme . '/category', $data, true);
        return $categoryList;
    }
}

?>