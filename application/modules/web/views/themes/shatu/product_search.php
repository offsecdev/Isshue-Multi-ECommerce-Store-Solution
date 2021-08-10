<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php 
    $is_aff = false;
    if(check_module_status('affiliate_products') == 1){
        $is_aff = true;
    }
?>
<?php
$CI =& get_instance();
$CI->load->model('dashboard/Themes');
$theme = $CI->Themes->get_theme();
?>
<div class="page-breadcrumbs">
<div class="container">
<ol class="breadcrumb">
<li><a href="<?php echo base_url() ?>"><?php echo display('home') ?></a></li>
<?php if (empty($after_search)) { ?>
    <li>
        <a href="<?php echo base_url('category/p/' . remove_space($category_name) . '/' . $category_id) ?>"><?php echo
            $category_name ?></a></li>
<?php } ?>
</ol>
</div>
</div>
<div class="category-content hidden-xs">
<div class="container">
<div class="row">
<div class="<?php if (!empty($after_search)) { ?> '' <?php } else { ?>col-sm-3 <?php } ?> leftSidebar hidden-xs">
    <?php if (!empty($category_id)): ?>
        <div class="sidebar-widget">
            <?php
            $sub_category = $this->Homes->get_sub_category($category_id);
            if (!empty($sub_category)) {
                ?>
                <div class="accessories">
                    <h3 class="sidebar-title"> <?php echo html_escape($category_name) ?></h3>
                    <ul class="subcategories">
                        <?php
                        if ($sub_category) {
                            $i = 1;
                            foreach ($sub_category as $cat) {
                                if ($i == 11) break;
                                $no_of_pro = $this->Categories->select_total_sub_cat_no_of_pro($cat['category_id']);
                                ?>
                                <li>
                                    <a href="<?php echo base_url('category/p/' . remove_space($cat['category_name']) . '/' . $cat['category_id']) ?>">
                                        <i class="fa fa-angle-right"></i>
                                        <span class="name"><?php echo html_escape($cat['category_name']) ?></span>
                                        <span class="total">(<?php echo html_escape($no_of_pro); ?>)</span>
                                    </a>
                                </li>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </ul>
                </div>
            <?php } ?>
            <div class="sidebar-widget-title">
                <?php
                if (!empty($max_value)) {
                    ?>
                    <div class="price-Pips">
                        <?php echo form_open('', array('id' => 'priceForm')); ?> 
                            <h3 class="sidebar-title"><?php echo display('by_price') ?></h3>
                            <input type="text" class="price-range" value="price-range" name="price-range"/>
                        <?php echo form_close(); ?>
                    </div>
                    <?php
                }
                if (!empty($variant_list)) {
                    ?>
                    <div class="product-size">
                        <h3 class="sidebar-title"><?php echo display('by_variant') ?>:</h3>
                        <?php
                        $currentURL = current_url();
                        $params = $_SERVER['QUERY_STRING'];
                        $size = $this->input->get('size',TRUE);
                        if ($variant_list) {
                            $i = 1;
                            foreach ($variant_list as $variant) {
                                ?>
                                <input type="radio" class="size1" name="size" id="<?php echo $i ?>"
                                       value="<?php
                                       if ($params) {
                                           if ($size) {
                                               $new_param = str_replace("size=" . $size, "size=" . $variant['variant_id'], $params);
                                               echo $fullURL = $currentURL . '?' . $new_param;
                                           } else {
                                               echo $fullURL = $currentURL . '?' . $params . '&size=' . $variant['variant_id'];
                                           }
                                       } else {
                                           echo $fullURL = $currentURL . '?size=' . $variant['variant_id'];
                                       }
                                       ?>" <?php if ($size == $variant['variant_id']) {
                                    echo "checked";
                                } ?>/>
                                <label for="<?php echo $i ?>"><span
                                            class="size1"><?php echo html_escape($variant['variant_name']) ?></span></label>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </div>
                    <?php
                } ?>
                <?php
                $brand_info = $this->Categories->select_sub_cat_brand_info($category_id);
                if ($brand_info) {
                    ?>
                    <div class="filter-nav brand-cat-widget">
                        <h3 class="sidebar-title"><?php echo display('by_brand') ?>:</h3>
                        <div class="search_layered_nav sidebar-search">
                            <input class="form-control brand_search" type="text"
                                   placeholder="<?php echo display('brand_search') ?>">
                        </div>
                        <div class="brand-cat-scroll">
                            <?php
                            $i = 1;
                            $query_string = '';
                            $query_string = $this->input->server('QUERY_STRING');
                            if ($query_string) {
                                $query_string = '?' . $this->input->server('QUERY_STRING');
                            } else {
                                $query_string = '';
                            }
                            $brand_url_ids = $this->uri->segment('3');
                            if ($brand_url_ids) {
                                $all_brand = (explode("--", $brand_url_ids));
                                $lastElementKey = count($all_brand);
                            } else {
                                $lastElementKey = 0;
                            }
                            foreach ($brand_info as $brand_in) {
                                if ($brand_in['brand_id']) {
                                    ?>
                                    <div class="checkbox checkbox-success">
                                        <input id="brand<?php echo $i ?>" type="checkbox"
                                               class="brand_class" name="brand" value="<?php
                                        $target_id = $brand_in['brand_id'];
                                        if (strpos($brand_url_ids, $target_id) !== false) {
                                            if ($lastElementKey == 1) {
                                                $output = preg_replace('/' . $target_id . '/', '', $brand_url_ids);
                                                echo base_url('category') . '/' . $category_id . $query_string;
                                            } else {
                                                if (strpos($brand_url_ids, $target_id . '--') !== false) {
                                                    $output = preg_replace('/' . $target_id . '--/', '', $brand_url_ids);
                                                } else {
                                                    $output = preg_replace('/--' . $target_id . '/', '', $brand_url_ids);
                                                }
                                                echo base_url('category') . '/' . $category_id . '/' . $output . $query_string;
                                            }
                                        } else {
                                            if ($lastElementKey == 0) {
                                                echo base_url('category') . '/' . $category_id . '/' . $brand_url_ids . $target_id . $query_string;
                                            } else {
                                                echo base_url('category') . '/' . $category_id . '/' . $brand_url_ids . '--' . $target_id . $query_string;
                                            }
                                        }
                                        ?>" <?php
                                        if (strpos($brand_url_ids, $target_id) !== false) {
                                            echo 'checked';
                                        }
                                        ?>>
                                        <label for="brand<?php echo $i ?>"><?php echo html_escape($brand_in['brand_name']) ?> </label>
                                    </div>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="row">
                    <div class="banner-content">
                        <div class="container">
                            <?php
                            if ($select_category_adds) {
                                foreach ($select_category_adds as $adds) {
                                    if ($adds->adv_position == 3) {
                                        echo $adds->adv_code;
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="sidebar-review">
                    <h3 class="sidebar-title"><?php echo display('rating') ?>:</h3>
                    <div class="checkbox checkbox-success">
                        <input id="rating1" type="checkbox" class="check_value" value="<?php
                        $currentURL = current_url();
                        $params = $_SERVER['QUERY_STRING'];
                        $rate = $this->input->get('rate',TRUE);
                        if ($params) {
                            if ($rate) {
                                $new_param = str_replace("rate=" . $rate, "rate=4-5", $params);
                                echo $fullURL = $currentURL . '?' . $new_param;
                            } else {
                                echo $fullURL = $currentURL . '?' . $params . '&rate=4-5';
                            }
                        } else {
                            echo $fullURL = $currentURL . '?rate=4-5';
                        }
                        ?>" <?php if ($this->input->get('rate',TRUE) == '4-5') {
                            echo("checked");
                        } ?>>
                        <label for="rating1">
                    <span class="product-rating">
                        <span class="star-rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-o"></i>
                        </span>
                        <a href="javascript:void(0)" class="review-link">
                            <span class="count">(<?php echo display('4') . '-' . display('5'); ?>)</span>
                        </a>
                    </span>
                        </label>
                    </div>
                    <div class="checkbox checkbox-success">
                        <input id="rating2" type="checkbox" class="check_value" value="<?php
                        $currentURL = current_url();
                        $params = $_SERVER['QUERY_STRING'];
                        $rate = $this->input->get('rate',TRUE);
                        if ($params) {
                            if ($rate) {
                                $new_param = str_replace("rate=" . $rate, "rate=3-5", $params);
                                echo $fullURL = $currentURL . '?' . $new_param;
                            } else {
                                echo $fullURL = $currentURL . '?' . $params . '&rate=3-5';
                            }
                        } else {
                            echo $fullURL = $currentURL . '?rate=3-5';
                        }
                        ?>" <?php if ($this->input->get('rate',TRUE) == '3-5') {
                            echo("checked");
                        } ?>>
                        <label for="rating2">
                    <span class="product-rating">
                        <span class="star-rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                        </span>
                        <a href="javascript:void(0)" class="review-link">
                            <span class="count">(<?php echo display('3') . '-' . display('5'); ?>)</span>
                        </a>
                    </span>
                        </label>
                    </div>
                    <div class="checkbox checkbox-success">
                        <input id="rating3" type="checkbox" class="check_value" value="<?php
                        $currentURL = current_url();
                        $params = $_SERVER['QUERY_STRING'];
                        $rate = $this->input->get('rate',TRUE);
                        if ($params) {
                            if ($rate) {
                                $new_param = str_replace("rate=" . $rate, "rate=2-5", $params);
                                echo $fullURL = $currentURL . '?' . $new_param;
                            } else {
                                echo $fullURL = $currentURL . '?' . $params . '&rate=2-5';
                            }
                        } else {
                            echo $fullURL = $currentURL . '?rate=2-5';
                        }
                        ?>" <?php if ($this->input->get('rate',TRUE) == '2-5') {
                            echo("checked");
                        } ?>>
                        <label for="rating3">
                    <span class="product-rating">
                        <span class="star-rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                        </span>
                        <a href="javascript:void(0)" class="review-link">
                            <span class="count">(<?php echo display('2') . '-' . display('5'); ?>)</span>
                        </a>
                    </span>
                        </label>
                    </div>
                    <div class="checkbox checkbox-success">
                        <input id="rating4" type="checkbox" class="check_value" value="<?php
                        $currentURL = current_url();
                        $params = $_SERVER['QUERY_STRING'];
                        $rate = $this->input->get('rate',TRUE);
                        if ($params) {
                            if ($rate) {
                                $new_param = str_replace("rate=" . $rate, "rate=1-5", $params);
                                echo $fullURL = $currentURL . '?' . $new_param;
                            } else {
                                echo $fullURL = $currentURL . '?' . $params . '&rate=1-5';
                            }
                        } else {
                            echo $fullURL = $currentURL . '?rate=1-5';
                        }
                        ?>" <?php if ($this->input->get('rate',TRUE) == '1-5') {
                            echo("checked");
                        } ?>>
                        <label for="rating4">
                    <span class="product-rating">
                        <span class="star-rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                        </span>
                        <a href="javascript:void(0)" class="review-link">
                            <span class="count">(<?php echo display('1') . '-' . display('5'); ?>)</span>
                        </a>
                    </span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<div class=" <?php if (!empty($after_search)) { ?> col-sm-12 after-search-product-block<?php } else { ?>col-sm-9 <?php } ?> content">
    <?php
    if ($select_category_adds) { ?>
        <div class="banner-content mt_20">
            <?php
            foreach ($select_category_adds as $ads) {
                if (1 == $ads->adv_position && !empty($ads->adv_code) && empty($ads->adv_code2) && empty($ads->adv_code3)) {
                    ?>
                    <div class="my-40">
                        <div class="row">
                            <div class="col-xs-12">
                                <?php echo $ads->adv_code; ?>
                            </div>
                        </div>
                    </div>
                <?php } else if (1 == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && empty($ads->adv_code3)) { ?>
                    <div class="my-40">
                        <div class="row">
                            <div class="col-xs-6">
                                <?php echo $ads->adv_code; ?>
                            </div>
                            <div class="col-xs-6">
                                <?php echo $ads->adv_code2; ?>
                            </div>
                        </div>
                    </div>

                <?php } else if (1 == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && !empty($ads->adv_code3)) { ?>
                    <div class="my-40">
                        <div class="row">
                            <div class="col-xs-4">
                                <?php echo $ads->adv_code; ?>
                            </div>
                            <div class="col-xs-4">
                                <?php echo $ads->adv_code2; ?>
                            </div>
                            <div class="col-xs-4">
                                <?php echo $ads->adv_code3; ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    <?php } ?>
    <div class="">
        <div class="filter-row align-items-center justify-content-between">
            <div class="filter-title">
                <?php if (!empty($after_search)) { ?>

                    <h3><?php echo html_escape($total) . " ";
                        echo display('search_items');
                        echo
                        " \" $keyword \" ";
                        ?> </h3>
                <?php } else { ?>
                    <h1><?php echo html_escape($category_name); ?></h1>
                    <span>- <?php echo html_escape($total); ?> <?php echo display('items') ?></span>
                <?php } ?>
            </div>
            <a class="btn btn-warning color4" href="<?php echo base_url() ?>"><i class="fa fa-hand-o-left"
                                                                                 aria-hidden="true"></i>
                <?php echo display('back_to_home') ?></a>
        </div>
        <div class="row product_slider">
            <?php
            if ($category_product) {
                foreach ($category_product as $product) {
                    ?>
                    <div class="col-xs-6 col-sm-6 col-lg-3 col-md-4 pr-0">
                        <div class="item boxed mb-16">
                            <div class="item_inner pos-rel">
                                <a href="<?php echo base_url('product_details/' . remove_space($product->product_name) . '/'
                                    . $product->product_id) ?>" class="item_title2">
                                    <div class="item_image">
                                        <img src="<?php echo base_url() . $product->image_thumb ?>"
                                             alt="product-image">
                                    </div>
                                </a>
                                <div class="item_info text-center">
                                    <a href="<?php echo base_url('category/p/' . remove_space($product->category_name) . '/'
                                        . $product->category_id) ?>">
                                        <p class="category-name text-capitalize"><?php echo html_escape($product->category_name);
                                            ?></p>
                                    </a>
                                    <a href="<?php echo base_url('product_details/' . remove_space($product->product_name) . '/'
                                        . $product->product_id) ?>"
                                       class="item_title2"><?php echo html_escape($product->product_name) ?></a>
                                    <div class="rating_stars">
                                        <div class="rating-wrap m-0-auto">
                                            <?php
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
                                                        echo "<i class=\"fa fa-star\"></i>";
                                                    }
                                                    for ($tt = $total_rate; $tt < 5; $tt++) {
                                                        echo "<i class=\"fa fa-star-o\"></i>";
                                                    }
                                                } elseif (gettype($total_rate) == 'double') {
                                                    $pieces = explode(".", $total_rate);
                                                    for ($q = 1; $q <= $pieces[0]; $q++) {
                                                        echo "<i class=\"fa fa-star\"></i>";
                                                        if ($pieces[0] == $q) {
                                                            echo "<i class=\"fa fa-star-half-o\"></i>";
                                                            for ($qq = $pieces[0]; $qq < 4; $qq++) {
                                                                echo "<i class=\"fa fa-star-o\"></i>";
                                                            }
                                                        }
                                                    }

                                                } else {
                                                    for ($w = 0; $w <= 4; $w++) {
                                                        echo "<i class=\"fa fa-star-o\"></i>";
                                                    }
                                                }
                                            } else {
                                                for ($o = 0; $o <= 4; $o++) {
                                                    echo "<i class=\"fa fa-star-o\"></i>";
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
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
                                    ?>

                                    <?php
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
                                    ?>

                                    <?php if ($product->onsale == 1 && !empty($product->onsale_price)) { ?>
                                        <span class="price">
                                    <span class="price-amount">
                                        <ins><span class="amount">
                                        <?php

                                        if ($target_con_rate > 1) {
                                            $price = $product->onsale_price * $target_con_rate;
                                            echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                        }
                                        if ($target_con_rate <= 1) {
                                            $price = $product->onsale_price * $target_con_rate;
                                            echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                        }
                                        ?>
                                        </span></ins>
                                        <del><span class="amount">
                                        <?php
                                        if ($target_con_rate > 1) {
                                            $price = $product->price * $target_con_rate;
                                            echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                        }

                                        if ($target_con_rate <= 1) {
                                            $price = $product->price * $target_con_rate;
                                            echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                        }
                                        ?>
                                        </span></del>
                                        <span class="amount"> </span>
                                    </span>
                                </span>
                                        <?php
                                    } else {
                                        ?>
                                        <span class="price">
                                    <span class="price-amount">
                                        <ins><span class="amount">
                                           <?php
                                           if ($target_con_rate > 1) {
                                               $price = $product->price * $target_con_rate;
                                               echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                           }

                                           if ($target_con_rate <= 1) {
                                               $price = $product->price * $target_con_rate;
                                               echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                           }
                                           ?>
                                        </span></ins>
                                        <span class="amount"> </span>
                                    </span>
                                </span>
                                        <?php
                                    }
                                    ?>
                                    <div class="hover_content">
                                        <ul class="nav">
                                            <li>
                                                <a href="javascript:void(0)"
                                                    onclick="comparison_btn(<?php echo html_escape($product->product_id) ?>)"
                                                    title="<?php echo display('compare') ?>" >
                                                    <i class="lnr lnr-chart-bars"></i> 
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="wishlist"
                                                   name="<?php echo $product->product_id; ?>"
                                                   title="<?php echo display('add_to_wishlist') ?>">
                                                   <i class="fa fa-heart"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <?php if($is_aff){ 
                                                    if($product->is_affiliate == 1 ){ ?>
                                                        <a href="<?php echo html_escape($product->affiliate_url) ?>" id="affiliate_btn" title="<?php echo display('buy_now'); ?>" target="0">
                                                            <i class="fa fa-shopping-bag"></i>
                                                        </a>
                                                <?php }else{ ?> 
                                                    <a  href="javascript:void(0)" title="<?php echo display('add_to_cart') ?>" 
                                                    onclick="add_to_cart_item('<?php echo $product->product_id; ?>','<?php echo  remove_space($product->product_name);?>', '<?php echo html_escape($product->default_variant); ?>', <?php echo $product->variant_price; ?>)">
                                                        <i class="fa fa-shopping-bag"></i>
                                                    </a>
                                                <?php } }else{ ?>
                                                    <a  href="javascript:void(0)" title="<?php echo display('add_to_cart') ?>" 
                                                    onclick="add_to_cart_item('<?php echo $product->product_id; ?>','<?php echo  remove_space($product->product_name);?>', '<?php echo html_escape($product->default_variant); ?>', <?php echo $product->variant_price; ?>)">
                                                        <i class="fa fa-shopping-bag"></i>
                                                    </a>
                                                <?php }  ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
            <div class="col-xs-12 col-sm-12">
                <div class="pagination-widget">
                    <?php echo htmlspecialchars_decode($links); ?>
                </div>
            </div>
            <?php
            if ($select_category_adds) { ?>
                <div class="banner-content mt_20">
                    <?php
                    foreach ($select_category_adds as $ads) {
                        if (2 == $ads->adv_position && !empty($ads->adv_code) && empty($ads->adv_code2) && empty($ads->adv_code3)) {
                            ?>
                            <div class="my-40">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <?php echo $ads->adv_code; ?>
                                    </div>
                                </div>
                            </div>

                        <?php } else if (2 == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && empty($ads->adv_code3)) { ?>

                            <div class="my-40">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <?php echo $ads->adv_code; ?>
                                    </div>
                                    <div class="col-xs-6">
                                        <?php echo $ads->adv_code2; ?>
                                    </div>
                                </div>
                            </div>
                        <?php } else if (2 == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && !empty($ads->adv_code3)) { ?>
                            <div class="my-40">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <?php echo $ads->adv_code; ?>
                                    </div>
                                    <div class="col-xs-4">
                                        <?php echo $ads->adv_code2; ?>
                                    </div>
                                    <div class="col-xs-4">
                                        <?php echo $ads->adv_code3; ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
</div>
</div>
</div>


<div class="category-mobile">
<div class="page-title">
<h2 class="title"><?php echo html_escape($category_name) ?></h2>
<h5 class="sub-title"><?php echo html_escape($total); ?><?php echo display('items') ?></h5>
</div>
<ul class="category">
<?php
if ($category_product) {
foreach ($category_product as $product) {
    ?>
    <li class="col-xs-4 col-vxs-6">
        <div class="item boxed mb-16">
            <div class="item_inner pos-rel">
                <a href="<?php echo base_url('product_details/' . remove_space($product->product_name) . '/'
                    . $product->product_id) ?>" class="item_title2">
                    <div class="item_image">
                        <img src="<?php echo base_url() . $product->image_thumb ?>" class="m-0-auto d-block"
                             alt="product-image">
                    </div>
                </a>
                <div class="item_info text-center">
                    <a href="<?php echo base_url('category/p/' . remove_space($product->category_name) . '/'
                        . $product->category_id) ?>">
                        <p class="category-name"><?php echo html_escape($product->category_name); ?></p>
                    </a>
                    <a href="<?php echo base_url('product_details/' . remove_space($product->product_name) . '/'
                        . $product->product_id) ?>"
                       class="item_title2"><?php echo html_escape($product->product_name) ?></a>
                    <div class="rating_stars">
                        <div class="rating-wrap m-0-auto">
                            <?php
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
                                        echo "<i class=\"fa fa-star\"></i>";
                                    }
                                    for ($tt = $total_rate; $tt < 5; $tt++) {
                                        echo "<i class=\"fa fa-star-o\"></i>";
                                    }
                                } elseif (gettype($total_rate) == 'double') {
                                    $pieces = explode(".", $total_rate);
                                    for ($q = 1; $q <= $pieces[0]; $q++) {
                                        echo "<i class=\"fa fa-star\"></i>";
                                        if ($pieces[0] == $q) {
                                            echo "<i class=\"fa fa-star-half-o\"></i>";
                                            for ($qq = $pieces[0]; $qq < 4; $qq++) {
                                                echo "<i class=\"fa fa-star-o\"></i>";
                                            }
                                        }
                                    }

                                } else {
                                    for ($w = 0; $w <= 4; $w++) {
                                        echo "<i class=\"fa fa-star-o\"></i>";
                                    }
                                }
                            } else {
                                for ($o = 0; $o <= 4; $o++) {
                                    echo "<i class=\"fa fa-star-o\"></i>";
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <?php
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
                    ?>

                    <?php
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
                    ?>

                    <?php if ($product->onsale == 1 && !empty($product->onsale_price)) { ?>
                        <span class="price">
                            <span class="price-amount">
                                <ins><span class="amount">
                                <?php

                                if ($target_con_rate > 1) {
                                    $price = $product->onsale_price * $target_con_rate;
                                    echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                }
                                if ($target_con_rate <= 1) {
                                    $price = $product->onsale_price * $target_con_rate;
                                    echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                }
                                ?>
                                </span></ins>
                                <del><span class="amount">
                                <?php
                                if ($target_con_rate > 1) {
                                    $price = $product->price * $target_con_rate;
                                    echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                }

                                if ($target_con_rate <= 1) {
                                    $price = $product->price * $target_con_rate;
                                    echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                }
                                ?>
                                </span></del>
                                <span class="amount"> </span>
                            </span>
                        </span>
                        <?php
                    } else {
                        ?>
                        <span class="price">
                            <span class="price-amount">
                                <ins><span class="amount">
                                   <?php
                                   if ($target_con_rate > 1) {
                                       $price = $product->price * $target_con_rate;
                                       echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                   }

                                   if ($target_con_rate <= 1) {
                                       $price = $product->price * $target_con_rate;
                                       echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                   }
                                   ?>
                                </span></ins>
                                <span class="amount"> </span>
                            </span>
                        </span>
                        <?php
                    }
                    ?>
                    <div class="hover_content">
                        <ul class="nav">
                            <li>
                                <a href="#" class="wishlist" name="<?php echo html_escape($product->product_id); ?>"
                                   title="<?php echo display('add_to_wishlist') ?>"><i
                                            class="fa fa-heart"></i></a>
                            </li>
                            <li>
                               <?php if($is_aff){ 
                                    if($product->is_affiliate == 1 ){ ?>
                                        <a href="<?php echo html_escape($product->affiliate_url) ?>" id="affiliate_btn" title="<?php echo display('buy_now'); ?>" target="0">
                                            <i class="fa fa-shopping-bag"></i>
                                        </a>
                                <?php }else{ ?> 
                                    <a href="javascript:void(0)" onclick="add_to_cart_item('<?php echo $product->product_id; ?>','<?php echo  remove_space($product->product_name);?>', '<?php echo html_escape($product->default_variant); ?>', <?php echo $product->variant_price; ?>)">
                                       <i class="fa fa-shopping-bag"></i>
                                    </a>
                                <?php } }else{ ?>
                                    <a href="javascript:void(0)" onclick="add_to_cart_item('<?php echo $product->product_id; ?>','<?php echo  remove_space($product->product_name);?>', '<?php echo html_escape($product->default_variant); ?>', <?php echo $product->variant_price; ?>)">
                                       <i class="fa fa-shopping-bag"></i>
                                    </a>
                                <?php }  ?>
                           </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </li>

    <?php
}
}
?>


</ul>
<div class="pagination-widget">
<?php echo htmlspecialchars_decode($links); ?>
</div>
</div>
<!-- End OF category Mobile -->
<input type="hidden" name="category_id" id="category_id" value="<?php echo html_escape($category_id) ?>">
<input type="hidden" name="query_string" id="query_string"
   value="<?php echo $this->input->server('QUERY_STRING'); ?>">
<input type="hidden" name="brand_url_ids" id="brand_url_ids" value="<?php echo $this->uri->segment('3') ?>">
</div>
<input type="hidden" name="price_min_value" id="price_min_value" value="<?php echo html_escape($min_value) ?>">
<input type="hidden" name="price_max_value" id="price_max_value" value="<?php echo html_escape($max_value) ?>">
<input type="hidden" name="from_price" id="from_price" value="<?php echo html_escape($from_price) ?>">
<input type="hidden" name="to_price" id="to_price" value="<?php echo html_escape($to_price) ?>">
<input type="hidden" name="default_currency_icon" id="default_currency_icon"
       value="<?php echo html_escape($default_currency_icon) ?>">
