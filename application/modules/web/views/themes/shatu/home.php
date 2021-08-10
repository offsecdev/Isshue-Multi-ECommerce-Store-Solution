<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
    $is_aff = false;
    if(check_module_status('affiliate_products') == 1){
        $is_aff = true;
    }
?>

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

<div class="page-content">
    <div class="container"> 
        <!-- Alert Message -->
        <?php
            $message = $this->session->userdata('message');
            if (isset($message)) {
        ?>
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $message ?>                    
        </div>
        <?php 
            $this->session->unset_userdata('message');
            }
            $error_message = $this->session->userdata('error_message');
            $validatio_error = validation_errors();
            if (($error_message || $validatio_error)) {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $error_message ?>                    
            <?php echo $validatio_error ?>                    
        </div>
        <?php 
            $this->session->unset_userdata('error_message');
            }
        ?>
    </div>

<div class="container-fluid">
<div class="row">
<div class="col col-md-12 px-0">
<div class="slider">
<?php
if ($slider_list) {
foreach ($slider_list as $slider) {
?>
<div class="item">
<a href="<?php echo $slider['slider_link'] ?>" target="_blank">
    <?php if (@getimagesize($slider['slider_image']) === false) { ?>
        <img src="<?php echo base_url() . 'my-assets/image/no-image.jpg' ?>"
             class="media-object"
             alt="image">
    <?php } else { ?>
        <img src="<?php echo base_url() . $slider['slider_image'] ?>"
             class="img-responsive slider-img"
             alt="sliderImage">
    <?php } ?>
</a>
</div>
<?php
}
}
?>
</div>
</div>
</div>
</div>

<!-- Overview Area -->
<section class="overview_area hidden-xs">
<div class="container">
<div class="row overview_inner">
<div class="col-md-3 col-sm-6">
<div class="single_overview">
<div class="overview_icon">
<i class="fa fa-truck color33"></i>
</div>
<div class="overview_details">
<h4><?php echo display('free_shipping'); ?></h4>
<h6><?php echo display('from_newyork'); ?></h6>
</div>
</div>
</div>
<div class="col-md-3 col-sm-6">
<div class="single_overview">
<div class="overview_icon">
<i class="fa fa-money color33"></i>
</div>
<div class="overview_details">
<h4><?php echo display('cash_on_delivery'); ?></h4>
<h6><?php echo display('the_internet_tend_to_repeat'); ?></h6>
</div>
</div>
</div>
<div class="col-md-3 col-sm-6">
<div class="single_overview">
<div class="overview_icon">
<i class="fa fa-undo color33"></i>
</div>
<div class="overview_details">
<h4><?php echo display('45_days_return'); ?></h4>
<h6><?php echo display('making_it_look_like_readable'); ?></h6>
</div>
</div>
</div>
<div class="col-md-3 col-sm-6">
<div class="single_overview">
<div class="overview_icon">
<i class="fa fa-clock-o color33"></i>
</div>
<div class="overview_details">
<h4><?php echo display('opening_all_week'); ?></h4>
<h6><?php echo display('8am_9pm'); ?></h6>
</div>
</div>
</div>
</div>
</div>
</section>

<?php
if ($block_list) {
foreach ($block_list as $block) {
$cat_pro = $this->db->select('a.*,b.category_name,b.category_id')
->from('product_information a')
->join('product_category b', 'a.category_id = b.category_id', 'left')
->where('a.category_id', $block['block_cat_id'])
->get()
->result_array();

if ($cat_pro) {
if ($block['block_style'] == 2) {
?>
<section class="product_area mb-40 mt-xs-40">
<div class="container">
<div class="product_inner">
<div class="sec_heading">
    <h2 class="sec_title color3"><?php echo html_escape($cat_pro[0]['category_name']) ?></h2>
</div>
<div class="owl-carousel product_slider product_col5_slider slider-nav">
    <?php foreach ($cat_pro as $product): 
        ?>
        <div class="item boxed">
            <div class="item_inner">
                <a href="<?php echo base_url() . 'product_details/' . remove_space($product['product_name']) . '/' . $product['product_id']; ?>"
                   class="item_title2">
                    <div class="item_image">
                        <img src="<?php echo base_url() . $product['image_thumb'] ?>"
                             alt="product-image">
                    </div>
                </a>
                <div class="item_info text-center">
                    <a href="<?php echo base_url() . 'category/p/' . remove_space($product['category_name']) . '/' . $product['category_id']; ?>"
                       class="item_title2">
                        <p class="category-name"><?php echo html_escape($cat_pro[0]['category_name']) ?></p>
                    </a>
                    <a href="<?php echo base_url() . 'product_details/' . remove_space($product['product_name']) . '/' . $product['product_id']; ?>"
                       class="item_title2"><?php echo html_escape($product['product_name']) ?></a>
                    <div class="rating_stars">
                        <div class="rating-wrap m-0-auto">
                            <?php
                            $result = $this->db->select('sum(rate) as rates')
                                ->from('product_review')
                                ->where('product_id', $product['product_id'])
                                ->get()
                                ->row();

                            $rater = $this->db->select('rate')
                                ->from('product_review')
                                ->where('product_id', $product['product_id'])
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
                        <!-- End Rating wrap -->
                    </div>
                    <?php if ($product['onsale'] == 1 && !empty($product['onsale_price'])) { ?>
                        <div class="product_cost">
                            <p class="current color35">
                                <?php
                                if ($target_con_rate > 1) {
                                    $price = $product['onsale_price'] * $target_con_rate;
                                    echo (($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                }

                                if ($target_con_rate <= 1) {
                                    $price = $product['onsale_price'] * $target_con_rate;
                                    echo (($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                }
                                ?>
                            </p>
                            <p class="previous">
                                <del>
                                    <?php
                                    if ($target_con_rate > 1) {
                                        $price = $product['price'] * $target_con_rate;
                                        echo (($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                    }

                                    if ($target_con_rate <= 1) {
                                        $price = $product['price'] * $target_con_rate;
                                        echo (($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                    }
                                    ?>
                                </del>
                            </p>
                        </div>
                    <?php } else { ?>
                        <div class="product_cost">
                            <p class="current color35">
                                <?php

                                if ($target_con_rate > 1) {
                                    $price = $product['price'] * $target_con_rate;
                                    echo (($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                }

                                if ($target_con_rate <= 1) {
                                    $price = $product['price'] * $target_con_rate;
                                    echo (($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                }
                                ?>
                            </p>
                        </div>
                    <?php } ?>
                    <div class="hover_content">
                        <ul class="nav">
                            <li>
                                <a href="javascript:void(0)"
                                    onclick="comparison_btn(<?php echo html_escape($product['product_id']) ?>)"
                                    title="<?php echo display('compare') ?>" >
                                    <i class="lnr lnr-chart-bars"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="wishlist" name="<?php echo $product['product_id'] ?>" title="<?php echo display('add_to_wishlist') ?>">
                                   <i class="fa fa-heart"></i>
                               </a>
                            </li>
                            <li>
                                <?php if($is_aff){ 
                                    if($product['is_affiliate'] == 1 ){ ?>
                                        <a id="affiliate_btn" href="<?php echo html_escape( $product['affiliate_url']) ?>" target="0" title="<?php echo display('buy_now') ?>">
                                            <i class="fa fa-shopping-bag"></i>
                                        </a>
                                <?php }else{ ?> 
                                    <a href="javascript:void(0)" title="<?php echo display('add_to_cart') ?>" onclick="add_to_cart_item(<?php echo $product['product_id'] . ', \'' . remove_space($product['product_name']) . '\','; echo ($product['default_variant']) ? '\'' . $product['default_variant'] . '\'' : '\'nai\''; ?>, <?php echo $product['variant_price']; ?>)">
                                        <i class="fa fa-shopping-bag"></i>
                                    </a>
                                <?php } }else{ ?>
                                    <a href="javascript:void(0)" title="<?php echo display('add_to_cart') ?>" onclick="add_to_cart_item(<?php echo $product['product_id'] . ', \'' . remove_space($product['product_name']) . '\','; echo ($product['default_variant']) ? '\'' . $product['default_variant'] . '\'' : '\'nai\''; ?>, <?php echo $product['variant_price']; ?>)">
                                        <i class="fa fa-shopping-bag"></i>
                                    </a>
                                <?php }  ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</div>
</div>
</section>
<?php if (!empty($select_home_adds)) {
foreach ($select_home_adds as $ads):
if ($block['block_position'] == $ads->adv_position && !empty($ads->adv_code) && empty($ads->adv_code2) && empty($ads->adv_code3)) {
?>
<div class="my-40">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <?php echo $ads->adv_code; ?>
            </div>
        </div>
    </div>
</div>

<?php } else if ($block['block_position'] == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && empty($ads->adv_code3)) { ?>

<div class="my-40">
    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                <?php echo $ads->adv_code; ?>
            </div>
            <div class="col-xs-6">
                <?php echo $ads->adv_code2; ?>
            </div>
        </div>
    </div>
</div>

<?php } else if ($block['block_position'] == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && !empty($ads->adv_code3)) { ?>

<div class="my-40">
    <div class="container">
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
</div>
<?php } ?>
<?php
endforeach;
} ?>
<?php
}
if ($block['block_style'] == 1) {
?>
<div class="modal fade product_view hidden-xs" id="product_view">
</div>
<section class="product_category my-50">
<div class="container">
<div class="row">
<div class="col-lg-3 col-md-4 col-sm-5 hidden-xs">
    <div class="row m-0 top_deals">
        <div class="category-heading sec-border mb-30">
            <h4 class="sec-title m-0"><?php echo display('best_sales') ?></h4>
        </div>
        <?php
        $this->db->select('*');
        $this->db->from('product_information');
        $this->db->where('best_sale', '1');
        $this->db->where('category_id', $cat_pro[0]['category_id']);
        $this->db->order_by('id', 'desc');
        $this->db->limit(3);
        $query = $this->db->get();
        $best_category_sale = $query->result();

        if ($best_category_sale) {
            foreach ($best_category_sale as $sales) {
                ?>
                <div class="d-flex active mb-25">
                    <img class="mr-15 w-70"
                         src="<?php echo base_url() . $sales->image_thumb ?>"
                         alt="product image">
                    <div class="cat-desc">
                        <a href="<?php echo base_url('product_details/' . remove_space($sales->product_name) . '/' . $sales->product_id) ?>"
                           class="item-title"><?php echo html_escape($sales->product_name) ?></a>
                        <?php if ($sales->onsale == 1 && !empty($sales->onsale_price)) { ?>
                            <div class="product_cost">
                                <p class="current color35"><?php echo (($position == 0) ? $currency ." ".number_format($sales->onsale_price, 2, '.', ',') : number_format($sales->onsale_price, 2, '.', ',') . $currency) ?></p>
                                <p class="previous">
                                    <del><?php echo (($position == 0) ? $currency . number_format($sales->price, 2, '.', ',') : number_format($sales->price, 2, '.', ',') . $currency) ?></del>
                                </p>
                            </div>
                        <?php } else { ?>
                            <div class="product_cost">
                                <p class="current color35"><?php echo (($position == 0) ? $currency ." ". number_format($sales->price, 2, '.', ',') : number_format($sales->price, 2, '.', ',') . $currency) ?></p>
                            </div>
                        <?php } ?>

                        <div class="rating_stars">
                            <div class="rating-wrap">
                                <?php
                                $result = $this->db->select('sum(rate) as rates')
                                    ->from('product_review')
                                    ->where('product_id', $sales->product_id)
                                    ->get()
                                    ->row();

                                $rater = $this->db->select('rate')
                                    ->from('product_review')
                                    ->where('product_id', $sales->product_id)
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
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
</div>

<div class="col-lg-9 col-md-8 col-sm-7">
    <div class="row m-0 product_inner">
        <div class="category-heading sec-border mb-30">
            <h4 class="sec-title m-0"><?php echo html_escape($block['category_name']); ?></h4>
        </div>
        <div class="owl-carousel product_col4_slider product2_slider slider_nav">
            <?php for ($i = 0; $i < count($cat_pro); $i++) { ?>
                <div class="item hover-me">
                    <div class="item_inner">
                        <div class="item_image">
                            <img src="<?php echo base_url() . $cat_pro[$i]['image_thumb'] ?>"
                                 alt="product-image">
                            <div class="hover-info">
                                <ul class="nav">
                                    <li class="hidden-xs">
                                        <a href="#"
                                           onclick="quick_view(<?php echo html_escape($cat_pro[$i]['product_id']); ?>)"
                                           class="btn-s2"
                                           data-toggle="modal"
                                           data-target="#product_view"><span><?php echo display('quick_view'); ?></span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                            <div class="hover-box">
                                <ul class="nav">
                                    <li>
                                        <a href="javascript:void(0)"
                                            onclick="comparison_btn(<?php echo html_escape($product['product_id']) ?>)"
                                            title="<?php echo display('compare') ?>" >
                                            <i class="lnr lnr-chart-bars"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="wishlist"
                                           name="<?php echo $cat_pro[$i]['product_id'] ?>"
                                           title="<?php echo display('add_to_wishlist') ?>">
                                           <i class="fa fa-heart"></i>
                                       </a>
                                    </li>
                                    <li>
                                       <?php if($is_aff){ 
                                            if($cat_pro[$i]['is_affiliate'] == 1 ){ ?>
                                                <a id="affiliate_btn" href="<?php echo html_escape( $cat_pro[$i]['affiliate_url']) ?>" target="0" title="<?php echo display('buy_now') ?>">
                                                    <i class="fa fa-shopping-bag"></i>
                                                </a>
                                        <?php }else{ ?> 
                                            <a href="javascript:void(0)" title="<?php echo display('add_to_cart') ?>" onclick="add_to_cart_item(<?php echo $cat_pro[$i]['product_id'] . ', \'' . remove_space($cat_pro[$i]['product_name']) . '\','; echo ($cat_pro[$i]['default_variant']) ? '\'' . $cat_pro[$i]['default_variant'] . '\'' : '\'nai\''; ?>, <?php echo $cat_pro[$i]['variant_price']; ?>)">
                                                <i class="fa fa-shopping-bag"></i>
                                            </a>
                                        <?php } }else{ ?>
                                            <a href="javascript:void(0)" title="<?php echo display('add_to_cart') ?>" onclick="add_to_cart_item(<?php echo $cat_pro[$i]['product_id'] . ', \'' . remove_space($cat_pro[$i]['product_name']) . '\','; echo ($cat_pro[$i]['default_variant']) ? '\'' . $cat_pro[$i]['default_variant'] . '\'' : '\'nai\''; ?>, <?php echo $cat_pro[$i]['variant_price']; ?>)">
                                                <i class="fa fa-shopping-bag"></i>
                                            </a>
                                        <?php }  ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="item_info text-center">
                            <div class="rating_stars mb-5">
                                <div class="rating-wrap m-0-auto">
                                    <?php
                                    $result = $this->db->select('sum(rate) as rates')
                                        ->from('product_review')
                                        ->where('product_id', $cat_pro[$i]['product_id'])
                                        ->get()
                                        ->row();

                                    $rater = $this->db->select('rate')
                                        ->from('product_review')
                                        ->where('product_id', $cat_pro[$i]['product_id'])
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
                            <a href="<?php echo base_url('product_details/' . remove_space($cat_pro[$i]['product_name']) . '/' . $cat_pro[$i]['product_id']) ?>"
                               class="item_title"><?php echo $cat_pro[$i]['product_name'] ?></a>
                            <?php if ($cat_pro[$i]['onsale'] == 1 && !empty($cat_pro[$i]['onsale_price'])) { ?>
                                <div class="product_cost">
                                    <p class="current color35">
                                        <?php
                                        if ($target_con_rate > 1) {
                                            $price = $cat_pro[$i]['onsale_price'] * $target_con_rate;
                                            echo (($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                        }

                                        if ($target_con_rate <= 1) {
                                            $price = $cat_pro[$i]['onsale_price'] * $target_con_rate;
                                            echo (($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                        }
                                        ?>
                                    </p>
                                    <p class="previous">
                                        <del>
                                            <?php
                                            if ($target_con_rate > 1) {
                                                $price = $cat_pro[$i]['price'] * $target_con_rate;
                                                echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                            }

                                            if ($target_con_rate <= 1) {
                                                $price = $cat_pro[$i]['price'] * $target_con_rate;
                                                echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                            }
                                            ?>
                                        </del>
                                    </p>
                                </div>
                            <?php } else { ?>
                                <div class="product_cost">
                                    <p class="current color35">
                                        <?php
                                        if ($target_con_rate > 1) {
                                            $price = $cat_pro[$i]['price'] * $target_con_rate;
                                            echo (($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                        }

                                        if ($target_con_rate <= 1) {
                                            $price = $cat_pro[$i]['price'] * $target_con_rate;
                                            echo (($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                        }
                                        ?>
                                    </p>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
</div>
</div>
</section>
<?php if (!empty($select_home_adds)) {
foreach ($select_home_adds as $ads):
if ($block['block_position'] == $ads->adv_position && !empty($ads->adv_code) && empty($ads->adv_code2) && empty($ads->adv_code3)) {
?>
<div class="my-40">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <?php echo $ads->adv_code; ?>
            </div>
        </div>
    </div>
</div>

<?php } else if ($block['block_position'] == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && empty($ads->adv_code3)) { ?>

<div class="my-40">
    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                <?php echo $ads->adv_code; ?>
            </div>
            <div class="col-xs-6">
                <?php echo $ads->adv_code2; ?>
            </div>
        </div>
    </div>
</div>

<?php } else if ($block['block_position'] == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && !empty($ads->adv_code3)) { ?>
<div class="my-40">
    <div class="container">
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
</div>
<?php } ?>
<?php
endforeach;
} ?>

<?php
}
}
}
}
?>

<?php if(!empty($brands)){ ?>
<div class="brand-cat-content">
<div class="container-full">
<div class="brand-logo">
<div class="row">
<div class="brand_slider owl-carousel nav-style2">
<?php 
foreach ($brands as $brand) { ?>
<div class="item logo-item">
<a href="<?php echo base_url() . "brand_product/list/" . $brand['brand_id']; ?>"
   target="_blank">
    <img class="img-responsive center-block" src="<?php echo $brand['brand_image']; ?>"
         alt="brand image"></a>
</div>
<?php } ?>
</div>
</div>
</div>
</div>
</div>
<?php } ?>
</div>