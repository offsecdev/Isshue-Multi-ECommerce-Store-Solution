<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Category extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'dashboard/web_settings',
            'dashboard/Soft_settings',
            'dashboard/companies',
            'dashboard/color_frontends',
            'dashboard/themes',
            'dashboard/Blocks',
            'dashboard/brands',
            'dashboard/pay_withs',
            'dashboard/Variants',
            'web/Homes',
            'web/Categories',
        ));

        $this->load->library('web/lcategory');

    }

    //Single category product
    public function category_product($cat_id, $brand = null)
    {
        if (is_numeric($brand)) {
            $brand = '';
        }
        $price_range = $this->input->get('price',TRUE);
        $size = $this->input->get('size',TRUE);
        $rate = $this->input->get('rate',TRUE);
        $filter = array(
            'price_range' => $price_range,
            'size' => $size,
            'rate' => $rate,
            'brand' => $brand
        );
        #
        #pagination starts
        #
        $config["base_url"] = base_url('category/' . $cat_id);
        $config["total_rows"] = $this->Categories->cat_product_list_count($cat_id, $filter);
        $config["per_page"] = 20;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination justify-content-center'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = "<li class='page-item'>";
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='page-item active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li class='page-item'>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li class='page-item'>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li class='page-item'>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li class='page-item'>";
        $config['last_tagl_close'] = "</li>";
        $config['prev_link'] = 'Previous';
        $config['next_link'] = 'Next';
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #  

        $content = $this->lcategory->category_product($cat_id,$links,$config["per_page"],$page,$price_range,$size, $brand,$rate);
        $this->template_lib->full_website_html_view($content);

    }

    //Category wise product
    public function category_wise_product($cat_id)
    {
        #
        #pagination starts
        #
        $config["base_url"] = base_url('category_product/' . $cat_id);
        $config["total_rows"] = $this->Categories->category_wise_product_count($cat_id);
        $config["per_page"] = 16;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination justify-content-center'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = "<li class='page-item'>";
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='page-item'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li class='page-item'>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li class='page-item'>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li class='page-item'>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li class='page-item'>";
        $config['last_tagl_close'] = "</li>";
        $config['prev_link'] = 'Previous';
        $config['next_link'] = 'Next';
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #  
        $content = $this->lcategory->category_wise_product($cat_id,$links,$config["per_page"],$page);
        $this->template_lib->full_website_html_view($content);

    }

    //Category and price range product
    public function category_price_wise_product()
    {

        $this->load->model('Soft_settings');
        $min = $this->input->post('new_min',TRUE);
        $max = $this->input->post('new_max',TRUE);
        $category_id = $this->input->post('category_id',TRUE);

        $cat_price_range_pro = $this->Categories->cat_price_range_pro($min, $max, $category_id);
        $currency_details = $this->Soft_settings->retrieve_currency_info();

        $currency = $currency_details[0]['currency_icon'];
        $position = $currency_details[0]['currency_position'];

        //Currency wise price change
        $default_currency_id = $this->session->userdata('currency_id');
        $currency_new_id = $this->session->userdata('currency_new_id');

        if (empty($currency_new_id)) {
            $result = $cur_info = $this->db->select('*')
                ->from('currency_info')
                ->where('default_status', '1')
                ->get()
                ->row();
            $currency_new_id = $result->currency_id;
        }

        if (!empty($currency_new_id)) {
            $cur_info = $this->db->select('*')
                ->from('currency_info')
                ->where('currency_id', $currency_new_id)
                ->get()
                ->row();

            $target_con_rate = $cur_info->convertion_rate;
            $position1 = $cur_info->currency_position;
            $currency1 = $cur_info->currency_icon;
        }
        //Currency wise price change

        $html = "";
        if ($cat_price_range_pro) {
            foreach ($cat_price_range_pro as $product) {

                $html .= "<div class=\"col-lg-3 col-sm-6 single_product_item\">
                    <div class=\"item item_category\">
                        <div class=\"item_inner\">
                            <div class=\"item_image\">
	                            <a href='" . base_url('product_details/' . $product->product_id) . "'>
	                                <img src='" . base_url() . $product->image_thumb . "' alt=\"product-image\">
	                            </a>
                            </div>
                            <div class=\"item_info\">
                                <h6>$product->product_name</h6>
                                <div class=\"rating_area\">
                                    <div class=\"rate-container\">";

                $result = $this->db->select('sum(rate) as rates')
                    ->from('product_review')
                    ->where('product_id', $product->product_id)
                    ->get()
                    ->row();

                $rater = $this->db->select('rate')
                    ->from('product_review')
                    ->where('product_id', $product->product_id)
                    ->get()
                    ->num_rows();

                if ($result->rates != null) {
                    $total_rate = $result->rates / $rater;
                    if (gettype($total_rate) == 'integer') {
                        for ($t = 1; $t <= $total_rate; $t++) {
                            $html .= "<i class=\"fa fa-star\"></i>";
                        }
                        for ($tt = $total_rate; $tt < 5; $tt++) {
                            $html .= "<i class=\"fa fa-star-o\"></i>";
                        }
                    } elseif (gettype($total_rate) == 'double') {
                        $pieces = explode(".", $total_rate);
                        for ($q = 1; $q <= $pieces[0]; $q++) {
                            $html .= "<i class=\"fa fa-star\"></i>";
                            if ($pieces[0] == $q) {
                                $html .= "<i class=\"fa fa-star-half-o\"></i>";
                                for ($qq = $pieces[0]; $qq < 4; $qq++) {
                                    $html .= "<i class=\"fa fa-star-o\"></i>";
                                }
                            }
                        }

                    } else {
                        for ($w = 0; $w <= 4; $w++) {
                            $html .= "<i class=\"fa fa-star-o\"></i>";
                        }
                    }
                } else {
                    for ($o = 0; $o <= 4; $o++) {
                        $html .= "<i class=\"fa fa-star-o\"></i>";
                    }
                }

                $html .= "</div>";
                $html .= "</div>";

                if ($product->onsale == 1 && !empty($product->onsale_price)) {
                    $html .= "<div class=\"product_cost\">";
                    $html .= "<p class=\"current\">";
                    if ($target_con_rate > 1) {
                        $price = $product->onsale_price * $target_con_rate;
                        $html .= (($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                    }

                    if ($target_con_rate <= 1) {
                        $price = $product->onsale_price * $target_con_rate;
                        $html .= (($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                    }
                    $html .= "</p>";

                    $html .= "<p class=\"previous\">";

                    if ($target_con_rate > 1) {
                        $price = $product->price * $target_con_rate;
                        $html .= (($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                    }

                    if ($target_con_rate <= 1) {
                        $price = $product->price * $target_con_rate;
                        $html .= (($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                    }
                    $html .= "</p>";
                    $html .= "</div>";

                } else {

                    $html .= "<div class=\"product_cost\">
                                    <p class=\"current\">";
                    if ($target_con_rate > 1) {
                        $price = $product->price * $target_con_rate;
                        $html .= (($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                    }

                    if ($target_con_rate <= 1) {
                        $price = $product->price * $target_con_rate;
                        $html .= (($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                    }
                    $html .= "</p>
                                </div>";
                }

                $html .= "</div>
                            <div class=\"item_hover\">
                                <ul class=\"nav\">
                                    <li>
                                        <a href=\"#\" class=\"wishlist\" name='" . $product->product_id . "'><i class=\"fa fa-heart\"></i></a>
                                    </li>
                                    <li>
                                        <a href=" . $product->image_thumb . " data-lightbox=\"image-1\"><i class=\"fa fa-search\"></i></a>
                                    </li>
                                    <li>
                                        <a href=" . base_url('category_product/' . $product->category_id) . "><i class=\"fa fa-arrows\"></i></a>
                                    </li>
                                </ul>
                                <div class=\"addtocard\">".form_open('');

                $html .= "<input type=\"hidden\" id=\"sst\" value=\"1\">";

                $html .= "<a href=" . base_url('product_details/' . $product->product_id) . "><button type=\"button\" class=\"cart_button\">" . display("add_to_cart") . "</button></a>
                                    ".form_close()."
                                </div>
                            </div>
                        </div>
                    </div>
                </div>";
            }
            echo @$html;
        }
    }

    //Category wise product search.
    public function category_product_search()
    {

        $product_name = $this->input->get('product_name',TRUE);
        if(empty($product_name)){
            $product_name = "space";
        }
        $filter = array(
            'brand' => $this->input->get('brand',TRUE)
        );
        $content = $this->lcategory->category_product_search($product_name, $filter);
        
        $this->template_lib->full_website_html_view($content);

    }
    
    // Search Catwise product
    public function search_catproduct()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('product_name', display('product'), 'trim|required');
        $this->form_validation->set_rules('category_id', display('category'), 'trim|required');

        if ($this->form_validation->run() == TRUE)
        {
            $category_id = $this->input->get('category_id',TRUE);
            $product_name = $this->input->get('product_name',TRUE);
            $filter = array(
                'category_id' => $category_id,
                'product_name' => $product_name
            );
            $content = $this->lcategory->search_catproduct_lib($filter);
            $this->template_lib->full_website_html_view($content);
        }else{
            redirect(base_url());
        }
    }

    //Category wise product search by ajax.
    public function category_product_search_ajax()
    {
        $category_id = $this->input->post('category_id',TRUE);
        $product_name = $this->input->post('product_name',TRUE);
        $product_info = $this->Categories->category_product_search_ajax($category_id, $product_name);

        if (!empty($product_info)) {
            echo "<style>";
            if (count($product_info) < 8) {
                echo ".scrollbar{float: left;height: auto;overflow-y: scroll;}.force-overflow{
                min-height: auto;}";
            } else {
                echo ".scrollbar{float: left;height: 250px;overflow-y: scroll;}.force-overflow{
                min-height: 250px;}";
            }
            echo "#style-1::-webkit-scrollbar-track{
                -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
                border-radius: 0;
                background-color: #F5F5F5;
            }
            #style-1::-webkit-scrollbar{
                width: 5px;
                background-color: #F5F5F5;
            }

            #style-1::-webkit-scrollbar-thumb{
                border-radius: 0;
                -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
                background-color: #00a652;
            }</style>";
            echo '<ul class="search_results_inner force-overflow">';
            $i = 1;
            foreach ($product_info as $value) {
                echo '<li class="single_results"><a href="' . base_url() . 'product_details/' . $value->product_id . '">' . $value->product_name . ' (' . $value->product_model . ')</a></li>';
            }
            echo '<ul>';
        }
    }

    //Submit a subcriber.
    public function add_subscribe()
    {
        $data = array(
            'subscriber_id' => $this->generator(15),
            'apply_ip' => $this->input->ip_address(),
            'email' => $this->input->post('sub_email',TRUE),
            'status' => 1
        );

        $result = $this->Subscribers->subscriber_entry($data);

        if ($result) {
            echo "2";
        } else {
            echo "3";
        }
    }

    //This function is used to Generate Key
    public function generator($lenth)
    {
        $number = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "N", "M", "O", "P", "Q", "R", "S", "U", "V", "T", "W", "X", "Y", "Z", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

        for ($i = 0; $i < $lenth; $i++) {
            $rand_value = rand(0, 34);
            $rand_number = $number["$rand_value"];

            if (empty($con)) {
                $con = $rand_number;
            } else {
                $con = "$con" . "$rand_number";
            }
        }
        return $con;
    }


    //Brand wise product search from category page
    public function brand_search()
    {
        $search_key = $this->input->post('search_key',TRUE);
        $category_id = $this->input->post('category_id',TRUE);
        $query_string = $this->input->post('query_string',TRUE);
        $brand_url_ids = $this->input->post('brand_url_ids',TRUE);

        $brand_info = $this->Categories->select_sub_cat_brand_info_search($category_id, $search_key);
        if ($brand_info) {
            echo "<div class=\"brand-cat-scroll\">";
            $i = 1;
            if ($brand_url_ids) {
                $all_brand = (explode("--", $brand_url_ids));
                $lastElementKey = count($all_brand);
            } else {
                $lastElementKey = 0;
            }

            foreach ($brand_info as $brand_in) {

                echo "<div class=\"checkbox checkbox-success\">";
                echo "<input id=\"brand$i\" type=\"checkbox\" class=\"brand_class\" name=\"brand\" value='";
                $target_id = $brand_in['brand_id'];
                if (strpos($brand_url_ids, $target_id) !== false) {
                    if ($lastElementKey == 1) {
                        $output = preg_replace("/" . $target_id . "/", "", $brand_url_ids);
                        echo base_url("category") . "/" . $category_id . $query_string;
                    } else {
                        if (strpos($brand_url_ids, $target_id . "--") !== false) {
                            $output = preg_replace("/" . $target_id . "--/", "", $brand_url_ids);
                        } else {
                            $output = preg_replace("/--" . $target_id . "/", "", $brand_url_ids);
                        }
                        echo base_url("category") . "/" . $category_id . "/" . $output . $query_string;
                    }
                } else {
                    if ($lastElementKey == 0) {
                        echo base_url("category") . "/" . $category_id . "/" . $brand_url_ids . $target_id . $query_string;
                    } else {
                        echo base_url("category") . "/" . $category_id . "/" . $brand_url_ids . "--" . $target_id . $query_string;
                    }
                }
                echo "'";
                if (strpos($brand_url_ids, $target_id) !== false) {
                    echo 'checked';
                }
                echo ">";
                echo "<label for='brand" . $i . "'>" . $brand_in['brand_name'] . "<span>(" . $this->Categories->total_brand_pro($brand_in['brand_id'], $category_id) . ")</span></label>";
                echo "</div>";
                $i++;
            }
            echo "</div>";
        }
    }
}