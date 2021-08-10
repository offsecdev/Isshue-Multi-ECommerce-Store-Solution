<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    //Select max price of a category product
    public function select_max_value_of_cat_pro($cat_id = null, $val = null)
    {
        $arr2 = array();
        $lang_id = 0;
        $user_lang = $this->session->userdata('language');
        if (empty($user_lang)) {
            $lang_id = 'english';
        } else {
            $lang_id = $user_lang;
        }
        $sort = $this->input->get('sort',TRUE);

        if ($sort == 'best_sale') {
            $this->db->select('c.*,             
                e.brand_name,
                f.first_name,
                f.last_name
                ');
            $this->db->from('order a');
            $this->db->join('seller_order b', 'a.order_id = b.order_id');
            $this->db->join('product_information c', 'c.product_id = b.product_id', 'left');
            $this->db->join('brand e', 'e.brand_id = c.brand_id', 'left');
            $this->db->join('seller_information f', 'f.seller_id = c.seller_id', 'left');
            $this->db->where('b.category_id', $cat_id);
            $this->db->group_by('b.product_id');
            $query = $this->db->get();
            $w_cat_pro = $query->result_array();
        } else {

            $this->db->select('a.*');
            $this->db->from('product_information a');
            $this->db->join('brand c', 'c.brand_id = a.brand_id', 'left');
            $this->db->where('a.category_id', $cat_id);
            $query = $this->db->get();
            $w_cat_pro = $query->result_array();
            //First category
            $first_cat = $this->db->select('*')
                ->from('product_category')
                ->where('parent_category_id', $cat_id)
                ->where('cat_type', 2)
                ->get()
                ->result();
            if ($first_cat) {
                foreach ($first_cat as $f_cat) {

                    $this->db->select('a.*');
                    $this->db->from('product_information a');
                    $this->db->join('brand c', 'c.brand_id = a.brand_id', 'left');
                    $this->db->where('a.category_id', $f_cat->category_id);
                    $this->db->where('a.status', 2);
                    $query = $this->db->get();
                    $first_cat_pro = $query->result_array();

                    if ($first_cat_pro) {
                        foreach ($first_cat_pro as $f_cat_pro) {
                            array_push($w_cat_pro, $f_cat_pro);
                        }
                    }

                    // Second category
                    $second_cat = $this->db->select('*')
                        ->from('product_category')
                        ->where('parent_category_id', $f_cat->category_id)
                        ->where('cat_type', 2)
                        ->get()
                        ->result();
                    if ($second_cat) {
                        foreach ($second_cat as $s_cat) {

                            $this->db->select('a.*');
                            $this->db->from('product_information a');
                            $this->db->join('brand c', 'c.brand_id = a.brand_id', 'left');
                            $this->db->where('a.category_id', $s_cat->category_id);
                            $this->db->where('a.status', 2);
                            $query = $this->db->get();
                            $sec_cat_pro = $query->result_array();

                            if ($sec_cat_pro) {
                                foreach ($sec_cat_pro as $s_cat_pro) {
                                    array_push($w_cat_pro, $s_cat_pro);
                                }
                            }

                            //Third category
                            $third_cat = $this->db->select('*')
                                ->from('product_category')
                                ->where('parent_category_id', $s_cat->category_id)
                                ->where('cat_type', 2)
                                ->get()
                                ->result();

                            if ($third_cat) {
                                foreach ($third_cat as $t_cat) {
                                    $this->db->select('a.*');
                                    $this->db->from('product_information a');
                                    $this->db->join('brand c', 'c.brand_id = a.brand_id', 'left');
                                    $this->db->where('a.category_id', $t_cat->category_id);
                                    $query = $this->db->get();
                                    $thrd_cat_pro = $query->result_array();

                                    if ($thrd_cat_pro) {
                                        foreach ($thrd_cat_pro as $t_cat_pro) {
                                            array_push($w_cat_pro, $t_cat_pro);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

        }

        if ($val == 1) {
            return $pro = $this->Categories->maxValueInArray($w_cat_pro, 'price');
        } else {
            return $pro = $this->Categories->min_by_key($w_cat_pro, 'price');
        }
    }


    public function maxValueInArray($array, $keyToSearch)
    {
        $currentMax = NULL;
        foreach ($array as $arr) {
            foreach ($arr as $key => $value) {
                if ($key == $keyToSearch && ($value >= $currentMax)) {
                    $currentMax = $value;
                }
            }
        }

        return $currentMax;
    }

    //Minvalue by array key
    public function min_by_key($arr = null, $key = null)
    {
        $min = array();
        foreach ($arr as $val) {
            if (!isset($val[$key]) and is_array($val)) {
                $min2 = min_by_key($val, $key);
                $min[$min2] = 1;
            } elseif (!isset($val[$key]) and !is_array($val)) {
                return false;
            } elseif (isset($val[$key])) {
                $min[$val[$key]] = 1;
            }
        }
        if (count($min) > 0) {
            return min(array_keys($min));
        } else {
            return 0;
        }
    }

    public function all_child_category($category_id)
    {
        $categories_ids[] = $category_id;
        $categories = $this->db->select('category_id')->from('product_category')->where('parent_category_id', $category_id)->get()->result_array();
        foreach ($categories as $key => $category) {
            $categories_ids[] = $category['category_id'];
            $categories2 = $this->db->select('category_id')->from('product_category')->where('parent_category_id', $category['category_id'])->get()->result_array();
            foreach ($categories2 as $key2 => $category2) {
                $categories_ids[] = $category2['category_id'];
                $categories3 = $this->db->select('category_id')->from('product_category')->where('parent_category_id', $category2['category_id'])->get()->result_array();
                foreach ($categories3 as $key3 => $category3) {
                    $categories_ids[] = $category3['category_id'];
                    $categories4 = $this->db->select('category_id')->from('product_category')->where('parent_category_id', $category3['category_id'])->get()->result_array();
                    foreach ($categories4 as $key4 => $category4) {
                        $categories_ids[] = $category4['category_id'];
                    }
                }
            }
        }
        return $categories_ids;
    }

    //Category product
    public function category_product($cat_id, $per_page, $page, $price_range = null, $size = null, $brand=null, $rate=null)
    {

        $category_ids = $this->all_child_category($cat_id);
        $all_brand = (explode("--", $brand));
        array_shift($all_brand);

        $this->db->select('a.*,b.category_name');
        $this->db->from('product_information a');
        $this->db->join('product_category b', 'a.category_id=b.category_id');
        $this->db->where_in('a.category_id', $category_ids);
        if(empty($rate)){
            $this->db->limit($per_page, $page);
        }
        $this->db->order_by('product_name');
        if ($price_range) {
            $ex = explode("-", $price_range);
            $from = $ex[0];
            $to = $ex[1];
            $this->db->where('a.price >=', $from);
            $this->db->where('a.price <=', $to);
        }
        if ($size) {
            $this->db->like('a.variants', $size);
        }
        if ($all_brand) {
            $this->db->where_in('a.brand_id', $all_brand);
        }
        $query = $this->db->get();

        $w_cat_pro = $query->result();

        if ($rate) {
            $w_cat_pro = $this->get_rating_product($w_cat_pro, $rate);
        }
        return $w_cat_pro;
    }

    //Get rating product by rate
    public function get_rating_product($w_cat_pro = '', $rate = '')
    {
        $rate = explode('-', $rate);
        $rate = $rate[0];
        $n_cat_pro = array();

        if ($w_cat_pro) {
            foreach ($w_cat_pro as $product) {
                $rater = $this->get_total_rater_by_product_id($product->product_id);
                $result = $this->get_total_rate_by_product_id($product->product_id);
                if ($rater) {
                    $total_rate = $result->rates / $rater;
                    if ($total_rate >= $rate) {
                        $this->db->select('a.*,c.brand_name,d.*');
                        $this->db->from('product_information a');
                        $this->db->join('brand c', 'c.brand_id = a.brand_id', 'left');
                        $this->db->join('product_category d', 'd.category_id = a.category_id', 'left');
                        $this->db->where('a.product_id', $product->product_id);
                        $query = $this->db->get();
                        $third_cat_pro = $query->result();

                        if ($third_cat_pro) {
                            foreach ($third_cat_pro as $t_cat_pro) {
                                array_push($n_cat_pro, $t_cat_pro);
                            }
                        }
                    }
                }
            }
            return $n_cat_pro;
        } else {
            return $w_cat_pro;
        }
    }

    //Get total rater by product id
    public function get_total_rater_by_product_id($product_id = null)
    {
        $rater = $this->db->select('rate')
            ->from('product_review')
            ->where('product_id', $product_id)
            ->where('status', 1)
            ->get()
            ->num_rows();
        return $rater;
    }

    //Get total rate by product id
    public function get_total_rate_by_product_id($product_id = null)
    {
        $rate = $this->db->select('sum(rate) as rates')
            ->from('product_review')
            ->where('product_id', $product_id)
            ->get()
            ->row();
        return $rate;
    }

    //Select all sub category no of product to show category page
    public function select_total_sub_cat_no_of_pro($cat_id = null)
    {

        $total_pro = 0;
        $this->db->select('a.*');
        $this->db->from('product_information a');
        $this->db->join('brand c', 'c.brand_id = a.brand_id', 'left');
        $this->db->where('a.category_id', $cat_id);

        $query = $this->db->get();
        $parent_cat = $query->num_rows();

        $total_pro = $total_pro + $parent_cat;
        $sec_cat = $this->db->select('*')
            ->from('product_category')
            ->where('parent_category_id', $cat_id)
            ->get()
            ->result();
        if ($sec_cat) {
            foreach ($sec_cat as $s_cat) {
                $this->db->select('a.*');
                $this->db->from('product_information a');
                $this->db->join('brand c', 'c.brand_id = a.brand_id', 'left');
                $this->db->where('a.category_id', $s_cat->category_id);
                $query = $this->db->get();
                $sct = $query->num_rows();

                $total_pro = $total_pro + $sct;
                if ($s_cat) {
                    $last_cat = $this->db->select('*')
                        ->from('product_category')
                        ->where('parent_category_id', $s_cat->category_id)
                        ->get()
                        ->result();
                    if ($last_cat) {
                        foreach ($last_cat as $l_ct) {
                            $this->db->select('a.*');
                            $this->db->from('product_information a');
                            $this->db->join('brand c', 'c.brand_id = a.brand_id', 'left');
                            $this->db->where('a.category_id', $l_ct->category_id);
                            $query = $this->db->get();
                            $lct = $query->num_rows();
                            $total_pro = $total_pro + $lct;
                        }
                    }
                }
            }
        }
        return $total_pro;
    }

    //Select single category
    public function select_single_category_by_id($cat_id)
    {
        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->where('category_id', $cat_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    //Category wise product
    public function category_wise_product($cat_id, $per_page, $page)
    {
        $this->db->select('*');
        $this->db->from('product_information');
        $this->db->where('category_id',$cat_id);
        $this->db->limit($per_page,$page);
        $this->db->order_by('product_name');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    //Select all sub category brand info
    public function select_sub_cat_brand_info($cat_id = '')
    {

        $this->db->select('a.brand_id,a.category_id');
        $this->db->from('product_information a');
        $this->db->where('a.category_id', $cat_id);
        $query = $this->db->get();
        $brand_ids = $query->result_array();
        $brand_ids = array_column($brand_ids, 'brand_id');
        $unique_brand_id = array_unique(array_filter($brand_ids));

        if (!empty($unique_brand_id)) {
            $this->db->select('*');
            $this->db->from('brand');
            $this->db->where_in('brand_id', $unique_brand_id);
            $query = $this->db->get();
            $w_cat_pro = $query->result_array();


            //First category
            $first_cat = $this->db->select('*')
                ->from('product_category')
                ->where('parent_category_id', $cat_id)
                ->where('cat_type', 2)
                ->get()
                ->result();
            if ($first_cat) {
                foreach ($first_cat as $f_cat) {

                    $this->db->select('a.brand_id,a.category_id');
                    $this->db->from('product_information a');
                    $this->db->where('a.category_id', $f_cat->category_id);
                    $this->db->where('a.status', 2);
                    $query = $this->db->get();
                    $first_cat_pro_brand_ids = $query->result_array();
                    $first_cat_pro_brand_ids = array_column($first_cat_pro_brand_ids, 'brand_id');
                    $first_cat_pro_unique_brand_ids = array_unique(array_filter($first_cat_pro_brand_ids));
                    if (!empty($first_cat_pro_unique_brand_ids)) {
                        $this->db->select('*');
                        $this->db->from('brand');
                        $this->db->where_in('brand_id', $first_cat_pro_unique_brand_ids);
                        $query = $this->db->get();
                        $first_cat_pro = $query->result_array();
                    } else {
                        $first_cat_pro = [];
                    }


                    if ($first_cat_pro) {
                        foreach ($first_cat_pro as $f_cat_pro) {
                            array_push($w_cat_pro, $f_cat_pro);
                        }
                    }

                    // Second category
                    $second_cat = $this->db->select('*')
                        ->from('product_category')
                        ->where('parent_category_id', $f_cat->category_id)
                        ->where('cat_type', 2)
                        ->get()
                        ->result();
                    if ($second_cat) {
                        foreach ($second_cat as $s_cat) {

                            $this->db->select('a.brand_id,a.category_id');
                            $this->db->from('product_information a');
                            $this->db->where('a.category_id', $s_cat->category_id);
                            $this->db->where('a.status', 2);
                            $query = $this->db->get();
                            $sec_cat_pro_brand_ids = $query->result_array();

                            $sec_cat_pro_brand_ids = array_column($sec_cat_pro_brand_ids, 'brand_id');
                            $sec_cat_pro_unique_brand_ids = array_unique(array_filter($sec_cat_pro_brand_ids));
                            if (!empty($sec_cat_pro_unique_brand_ids)) {

                                $this->db->select('*');
                                $this->db->from('brand');
                                $this->db->where_in('brand_id', $sec_cat_pro_unique_brand_ids);
                                $query = $this->db->get();
                                $sec_cat_pro = $query->result_array();
                            } else {
                                $sec_cat_pro = [];
                            }


                            if ($sec_cat_pro) {
                                foreach ($sec_cat_pro as $s_cat_pro) {
                                    array_push($w_cat_pro, $s_cat_pro);
                                }
                            }

                            //Third category
                            $third_cat = $this->db->select('*')
                                ->from('product_category')
                                ->where('parent_category_id', $s_cat->category_id)
                                ->where('cat_type', 2)
                                ->get()
                                ->result();

                            if ($third_cat) {
                                foreach ($third_cat as $t_cat) {

                                    $this->db->select('a.brand_id,a.category_id');
                                    $this->db->from('product_information a');
                                    $this->db->where('a.category_id', $t_cat->category_id);
                                    $query = $this->db->get();
                                    $thrd_cat_pro_brand_ids = $query->result_array();

                                    $thrd_cat_pro_brand_ids = array_column($thrd_cat_pro_brand_ids, 'brand_id');
                                    $thrd_cat_pro_unique_brand_ids = array_unique(array_filter($thrd_cat_pro_brand_ids));
                                    if (!empty($thrd_cat_pro_unique_brand_ids)) {
                                        $this->db->select('*');
                                        $this->db->from('brand');
                                        $this->db->where_in('brand_id', $thrd_cat_pro_unique_brand_ids);
                                        $query = $this->db->get();
                                        $thrd_cat_pro = $query->result_array();
                                    } else {
                                        $thrd_cat_pro = [];
                                    }


                                    if ($thrd_cat_pro) {
                                        foreach ($thrd_cat_pro as $t_cat_pro) {
                                            array_push($w_cat_pro, $t_cat_pro);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return $this->unique_multidim_array($w_cat_pro, 'brand_id');
        } else {
            return 0;
        }
    }


    //Multidimentional array unique
    public function unique_multidim_array($array, $key)
    {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach ($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }

    //Category price range product
    public function cat_price_range_pro($min, $max, $cat_id)
    {
        $this->db->select('*');
        $this->db->from('product_information');
        $this->db->where('category_id', $cat_id);
        $this->db->where('price >=', $min);
        $this->db->where('price <=', $max);
        $this->db->order_by('product_name');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    //Category wise product count
    public function category_wise_product_count($cat_id)
    {
        $this->db->select('*');
        $this->db->from('product_information');
        $this->db->where('category_id', $cat_id);
        $this->db->order_by('product_name');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }

    //Select single category
    public function select_single_category($cat_id)
    {
        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->where('category_id', $cat_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Category product list count
    public function cat_product_list_count($cat_id, $filter = [])
    {
        $category_ids = $this->all_child_category($cat_id);
        $all_brand = (explode("--", $filter['brand']));
        array_shift($all_brand);

        $this->db->select('*');
        $this->db->from('product_information');
        $this->db->where_in('category_id', $category_ids);
        if(!empty($filter['size'])){
            $this->db->like('variants', $filter['size']);
        }
        if(!empty($filter['price_range'])){
            $ex = explode("-", $filter['price_range']);
            $from = $ex[0];
            $to = $ex[1];
            $this->db->where('price >=', $from);
            $this->db->where('price <=', $to);
        }
        if(!empty($all_brand)){
            $this->db->where_in('brand_id', $all_brand);
        }

        $query = $this->db->get();

        if (!empty($filter['rate'])) {
            $ratevals = $query->result();
            $w_cat_pro = $this->get_rating_product($ratevals, $filter['rate']);
            return count($w_cat_pro);

        }

        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }
    
    //Get category product
    public function get_category_product($filter = [])
    {
        $this->db->select('a.*,b.category_name');
        $this->db->from('product_information a');
        $this->db->join('product_category b', 'a.category_id=b.category_id','left');

        if(!empty($filter['category_id'])){
            $this->db->where('a.category_id', $filter['category_id']);
        }
        if(!empty($filter['product_name'])){
            $this->db->like('a.product_name', $filter['product_name'], 'both');
        }
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    //Retrive category product
    public function retrieve_category_product($product_name, $filter = [])
    {
        $this->db->select('a.*,b.category_name');
        $this->db->from('product_information a');
        $this->db->join('product_category b', 'a.category_id=b.category_id');
        $this->db->like('a.product_name', $product_name, 'both');

        if(!empty($filter['brand'])){
            $all_brand = (explode("--", $filter['brand']));
            $this->db->where_in('a.brand_id', $all_brand);
        }

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    //Retrive category product
    public function get_filter_brand_list($product_name)
    {
        $this->db->select('b.brand_id, b.brand_name');
        $this->db->from('product_information a');
        $this->db->join('brand b', 'a.brand_id=b.brand_id','left');
        $this->db->like('a.product_name', $product_name, 'both');
        $this->db->group_by('a.brand_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Retrive category product ajax
    public function category_product_search_ajax($cat_id, $product_name)
    {
        $this->db->select('*');
        $this->db->from('product_information');
        if ($cat_id != 'all') {
            $this->db->where('category_id', $cat_id);
        }
        $this->db->like('product_name', $product_name, 'both');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    //Select max value of product
    public function select_max_value_of_pro($cat_id)
    {
        $this->db->select_max('price');
        $this->db->from('product_information');
        $this->db->where('product_information.category_id', $cat_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Select min value of product
    public function select_min_value_of_pro($cat_id)
    {
        $this->db->select_min('price');
        $this->db->from('product_information');
        $this->db->where('product_information.category_id', $cat_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Select categories product
    public function select_category_product()
    {
        $this->db->select('*');
        $this->db->from('advertisement');
        $this->db->where('add_page', 'category');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }


    //Select all sub category brand info
    public function select_sub_cat_brand_info_search($cat_id='',$search_key='')
    {

        $this->db->select('c.*,a.category_id');
        $this->db->from('product_information a');
        $this->db->join('brand c','c.brand_id = a.brand_id','left');
        $this->db->where('a.category_id',$cat_id);
        $this->db->where('a.status',1);
        $this->db->like('c.brand_name', $search_key, 'both');
        $this->db->group_by('a.brand_id');

        $query = $this->db->get();
        $w_cat_pro = $query->result_array();

        //First category
        $first_cat= $this->db->select('*')
            ->from('product_category')
            ->where('parent_category_id',$cat_id)
            ->where('cat_type',2)
            ->get()
            ->result();
        if ($first_cat) {
            foreach ($first_cat as $f_cat) {

                $this->db->select('c.*,a.category_id');
                $this->db->from('product_information a');
                $this->db->join('brand c','c.brand_id = a.brand_id','left');
                $this->db->where('a.category_id',$f_cat->category_id);
                $this->db->where('a.status',1);
                $this->db->like('c.brand_name', $search_key, 'both');
                $this->db->group_by('a.brand_id');

                $query = $this->db->get();
                $first_cat_pro = $query->result_array();

                if ($first_cat_pro) {
                    foreach ($first_cat_pro as $f_cat_pro) {
                        array_push($w_cat_pro, $f_cat_pro);
                    }
                }

                // Second category
                $second_cat = $this->db->select('*')
                    ->from('product_category')
                    ->where('parent_category_id',$f_cat->category_id)
                    ->where('cat_type',2)
                    ->get()
                    ->result();
                if ($second_cat) {
                    foreach ($second_cat as $s_cat) {

                        $this->db->select('c.*,a.category_id');
                        $this->db->from('product_information a');
                        $this->db->join('brand c','c.brand_id = a.brand_id','left');
                        $this->db->where('a.category_id',$s_cat->category_id);
                        $this->db->where('a.status',1);
                        $this->db->like('c.brand_name', $search_key, 'both');
                        $this->db->group_by('a.brand_id');

                        $query = $this->db->get();
                        $sec_cat_pro = $query->result_array();

                        if ($sec_cat_pro) {
                            foreach ($sec_cat_pro as $s_cat_pro) {
                                array_push($w_cat_pro, $s_cat_pro);
                            }
                        }

                        //Third category
                        $third_cat = $this->db->select('*')
                            ->from('product_category')
                            ->where('parent_category_id',$s_cat->category_id)
                            ->where('cat_type',2)
                            ->get()
                            ->result();

                        if ($third_cat) {
                            foreach ($third_cat as $t_cat) {

                                $this->db->select('c.*,a.category_id');
                                $this->db->from('product_information a');
                                $this->db->join('brand c','c.brand_id = a.brand_id','left');
                                $this->db->where('a.category_id',$t_cat->category_id);
                                $this->db->where('a.status',1);
                                $this->db->like('c.brand_name', $search_key, 'both');
                                $this->db->group_by('a.brand_id');

                                $query = $this->db->get();
                                $thrd_cat_pro = $query->result_array();

                                if ($thrd_cat_pro) {
                                    foreach ($thrd_cat_pro as $t_cat_pro) {
                                        array_push($w_cat_pro, $t_cat_pro);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return  $this->unique_multidim_array($w_cat_pro,'brand_id');
    }

    //Select brand product
    public function total_brand_pro($brand_id=null,$cat_id=null)
    {
        $total_pro = 0;
        $lang_id = 0;



        $this->db->select('count(a.product_id) as total');
        $this->db->from('product_information a');
        $this->db->where('a.category_id',$cat_id);
        $this->db->where('a.brand_id',$brand_id);
        $this->db->group_by('a.brand_id');
        $this->db->where('a.status',1);

        $query = $this->db->get();
        $parent_cat = $query->num_rows();
        $total_pro = $total_pro+$parent_cat;

        $sec_cat = $this->db->select('*')
            ->from('product_category')
            ->where('parent_category_id',$cat_id)
            ->get()
            ->result();
        if ($sec_cat) {
            foreach ($sec_cat as $s_cat) {
                $this->db->select('count(a.product_id) as total');
                $this->db->from('product_information a');
                $this->db->where('a.category_id',$s_cat->category_id);
                $this->db->where('a.brand_id',$brand_id);
                $this->db->group_by('a.brand_id');
                $this->db->where('a.status',1);

                $query = $this->db->get();
                $sct = $query->num_rows();

                $total_pro = $total_pro+$sct;
                if ($s_cat) {
                    $last_cat = $this->db->select('*')
                        ->from('product_category')
                        ->where('parent_category_id',$s_cat->category_id)
                        ->get()
                        ->result();

                    if ($last_cat) {
                        foreach ($last_cat as $l_ct) {
                            $this->db->select('count(a.product_id) as total');
                            $this->db->from('product_information a');
                            $this->db->where('a.category_id',$l_ct->category_id);
                            $this->db->where('a.brand_id',$brand_id);
                            $this->db->group_by('a.brand_id');
                            $this->db->where('a.status',1);

                            $query = $this->db->get();
                            $lct = $query->num_rows();

                            $total_pro = $total_pro+$lct;
                        }
                    }
                }
            }
        }
        return $total_pro;
    }
}