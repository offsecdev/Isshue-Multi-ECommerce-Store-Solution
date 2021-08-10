<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php 
    $is_aff = false;
    if(check_module_status('affiliate_products') == 1){
        $is_aff = true;
    }
 ?>
<!--========= Slider Area =======-->
<section class="slider_area">
    <div class="container"> 
        <div class="row">
            <div class="col-lg-9 offset-lg-3">

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
    </div>
    </div>
<div class="container">
<div class="row">
<div class="col-lg-9 offset-lg-3">
<div class="slider_inner home2_slider">
<div class="owl-carousel main_slider">
<?php
if ($slider_list) {
foreach ($slider_list as $slider) {
    if ($slider['status'] == 1) {
        ?>
        <div class="item">
            <a href="<?php echo $slider['slider_link'] ?>" target="_blank">
                <img src="<?php echo base_url() . $slider['slider_image'] ?>"
                     alt="sliderImage">
            </a>
        </div>
        <?php
    }
}
}
?>
</div>
</div>
</div>
</div>
</div>
</section>
<!--======= End Slider Area =======-->

<!--========== Overview Area ==========-->

<?php if (!empty($select_home_adds)) {
foreach ($select_home_adds as $ads):
if (1 == $ads->adv_position && !empty($ads->adv_code) && empty($ads->adv_code2) && empty($ads->adv_code3)) {
?>
<section class="overview_area wow fadeInUp">
<div class="container">
<div class="row overview_inner">
<div class="col-sm-12">
<?php echo $ads->adv_code; ?>
</div>
</div>
</section>


<?php } else if (1 == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && empty($ads->adv_code3)) { ?>

<section class="overview_area wow fadeInUp">
<div class="container">
<div class="row overview_inner">
<div class="col-sm-6">
<?php echo $ads->adv_code; ?>
</div>

<div class="col-sm-6">
<?php echo $ads->adv_code2; ?>
</div>
</div>
</section>


<?php } else if (1 == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && !empty($ads->adv_code3)) { ?>

<section class="overview_area wow fadeInUp">
<div class="container">
<div class="row overview_inner">
<div class="col-sm-4">
<?php echo $ads->adv_code; ?>
</div>
<div class="col-sm-4">
<?php echo $ads->adv_code2; ?>
</div>
<div class="col-sm-4">
<?php echo $ads->adv_code3; ?>
</div>
</div>
</section>

<?php } ?>
<?php
endforeach;
} ?>

<!--========== End Overview Area ==========-->
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

    if ($currency_new_id) {
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
if ($block_list) {
foreach ($block_list as $block) {
$cat_pro = $this->db->select('a.*,b.category_name,b.category_id')
->from('product_information a')
->join('product_category b', 'a.category_id = b.category_id', 'left')
->where('a.category_id', $block['block_cat_id'])
->get()
->result_array();
if ($cat_pro) {
if ($block['block_style'] == 1) {
?>
<!--========== Featured Product Area ==========-->
<section class="product_area wow fadeInUp">
<div class="container">
<div class="row db m0 product_inner">
<div class="heading">
    <h2 class="bg_gray "><?php echo html_escape($cat_pro[0]['category_name']) ?></h2>
</div>
<div class="owl-carousel product_slider slider_style">
    <?php for ($i = 0; $i < count($cat_pro); $i++) { ?>
        <div class="item">
            <div class="item_inner">
                <div class="item_image">
                    <a href="<?php echo base_url('product_details/' . remove_space($cat_pro[$i]['product_name']) . '/' . $cat_pro[$i]['product_id']) ?>">
                        <img src="<?php echo base_url() . $cat_pro[$i]['image_thumb'] ?>"
                             alt="product-image">
                    </a>
                </div>
                <div class="item_info">
                    <h6><?php echo html_escape($cat_pro[$i]['product_name']) ?></h6>
                    <div class="rating_area">
                        <div class="rate-container">
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

                   

                    <?php if ($cat_pro[$i]['onsale'] == 1 && !empty($cat_pro[$i]['onsale_price'])) { ?>
                        <div class="product_cost">
                            <p class="current color5">

                                <?php
                                if ($target_con_rate > 1) {
                                    $price = $cat_pro[$i]['onsale_price'] * $target_con_rate;
                                    echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                }

                                if ($target_con_rate <= 1) {
                                    $price = $cat_pro[$i]['onsale_price'] * $target_con_rate;
                                    echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                }
                                ?>
                            </p>
                            <p class="previous">
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
                            </p>
                        </div>
                    <?php } else { ?>
                        <div class="product_cost">
                            <p class="current color5">
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
                            </p>
                        </div>
                    <?php } ?>
                </div>
                <div class="item_hover">
                    <ul class="nav">
                        <li>
                            <a href="javascript:void(0)" class="compare"
                                onclick="comparison_btn(<?php echo html_escape($cat_pro[$i]['product_id']) ?>)">
                                <i class="fa fa-balance-scale"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="wishlist"
                               name="<?php echo html_escape($cat_pro[$i]['product_id']) ?>"
                               title="<?php echo display('add_to_wishlist') ?>"><i
                                        class="fa fa-heart"></i></a>
                        </li>
                        <li>
                            <a href="<?php echo $cat_pro[$i]['image_thumb'] ?>"
                               data-lightbox="image-1"
                               title="<?php echo display('quick_view') ?>"><i
                                        class="fa fa-search"></i></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('category_product/' . $cat_pro[$i]['category_id']) ?>"
                               title="<?php echo display('category_wise_product') ?>"><i
                                        class="fa fa-arrows"></i></a>
                        </li>
                    </ul>
                    
                    <div class="addtocard">
                        <?php if($is_aff){ 
                            if($cat_pro[$i]['is_affiliate'] == 1 ){ ?>
                                <a href="<?php echo html_escape($cat_pro[$i]['affiliate_url']) ?>" target="0">
                                    <button type="button" class="cart_button color2"><?php echo display('buy_now') ?></button>
                                </a>
                        <?php }else{ ?> 
                            <?php echo form_open('');?>
                                <input type="hidden" id="sst" value="1">
                                <a href="javascript:void(0)" onclick="add_to_cart_item('<?php echo $cat_pro[$i]['product_id']; ?>', '<?php echo remove_space($cat_pro[$i]['product_name']); ?>', '<?php echo $cat_pro[$i]['default_variant']; ?>', <?php echo $cat_pro[$i]['variant_price']; ?>);">
                                    <button type="button" class="cart_button color2"><?php echo display('add_to_cart') ?></button>
                                </a>
                            <?php echo form_close(); ?>
                        <?php } }else{ ?>
                            <?php echo form_open('');?>
                                <input type="hidden" id="sst" value="1">
                                <a href="javascript:void(0)" onclick="add_to_cart_item('<?php echo $cat_pro[$i]['product_id']; ?>', '<?php echo remove_space($cat_pro[$i]['product_name']); ?>', '<?php echo $cat_pro[$i]['default_variant']; ?>', <?php echo $cat_pro[$i]['variant_price']; ?>);">
                                    <button type="button" class="cart_button color2"><?php echo display('add_to_cart') ?></button>
                                </a>
                            <?php echo form_close(); ?>
                        <?php }  ?>
                    </div>
                    
                </div>
            </div>
        </div>
    <?php } ?>
</div>
</div>
</div>
</section>

<!--========== End Featured Product Area ==========-->
<?php
} else {
?>
<!--========== Product Category Area ==========-->
<section class="product_category">
<div class="container">
<div class="row product_category_inner container_section">
<div class="col-xl-3 col-lg-4 col-md-5">
    <div class="row m0 db best_sale bg_gray">
        <h4 class="heading-2 color3"><?php echo display('best_sales') ?></h4>
        <?php
        $this->db->select('*');
        $this->db->from('product_information');
        $this->db->where('best_sale', '1');
        $this->db->where('category_id', $cat_pro[0]['category_id']);
        $this->db->order_by('id', 'desc');
        $this->db->limit('6');
        $query = $this->db->get();
        $best_category_sale = $query->result();

        if ($best_category_sale) {
            foreach ($best_category_sale as $sales) {
                ?>
                <div class="media single_product">
                    <img class="d-flex" src="<?php echo base_url() . $sales->image_thumb ?>"
                         alt="product image">
                    <div class="media-body">
                        <a href="<?php echo base_url('product_details/' . remove_space($sales->product_name) . '/' . $sales->product_id) ?>"><?php echo html_escape($sales->product_name) ?></a>
                        <?php if ($sales->onsale == 1 && !empty($sales->onsale_price)) { ?>
                            <div class="product_cost">
                                <p class="current color35"><?php echo(($position1 == 0) ? $currency1 ." ". number_format
                                        ($sales->onsale_price, 2, '.', ',') : number_format($sales->onsale_price, 2, '.', ',') . $currency1) ?></p>
                                <p class="previous"><?php echo(($position1 == 0) ? $currency1 ." ". number_format($sales->price, 2, '.', ',') : number_format($sales->price, 2, '.', ',') . $currency1) ?></p>
                            </div>
                        <?php } else { ?>
                            <div class="product_cost">
                                <p class="current color35"><?php echo(($position1 == 0) ? $currency1 ." ". number_format
                                        ($sales->price, 2, '.', ',') : number_format($sales->price, 2, '.', ',') . $currency1) ?></p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
</div>

<div class="col-xl-9 col-lg-8 col-md-7">
    <div class="row db m0 product_inner">
        <div class="heading mt0">
            <h2 class="bg_gray"><?php echo html_escape($cat_pro[0]['category_name']) ?></h2>
        </div>
        <div class="slider_style owl-carousel category_slider">
            <?php for ($i = 0; $i < count($cat_pro); $i++) { ?>
                <div class="item">
                    <div class="item_inner">
                        <div class="item_image">
                            <a href="<?php echo base_url('product_details/' . remove_space($cat_pro[$i]['product_name']) . '/' . $cat_pro[$i]['product_id']) ?>">
                                <img src="<?php echo base_url() . $cat_pro[$i]['image_thumb'] ?>"
                                     alt="product-image">
                            </a>
                        </div>
                        <div class="item_info">
                            <h6><?php echo html_escape($cat_pro[$i]['product_name']) ?></h6>
                            <div class="rating_area">
                                <div class="rate-container">
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

                            <?php if ($cat_pro[$i]['onsale'] == 1 && !empty($cat_pro[$i]['onsale_price'])) { ?>
                                <div class="product_cost">
                                    <p class="current color35">
                                        <?php
                                        if ($target_con_rate > 1) {
                                            $price = $cat_pro[$i]['onsale_price'] * $target_con_rate;
                                            echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                        }

                                        if ($target_con_rate <= 1) {
                                            $price = $cat_pro[$i]['onsale_price'] * $target_con_rate;
                                            echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                        }
                                        ?>
                                    </p>
                                    <p class="previous">
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
                                    </p>
                                </div>
                            <?php } else { ?>
                                <div class="product_cost">
                                    <p class="current color35">
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
                                    </p>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="item_hover">
                            <ul class="nav">
                                <li>
                                    <a href="javascript:void(0)" class="compare"
                                        onclick="comparison_btn(<?php echo html_escape($cat_pro[$i]['product_id']) ?>)">
                                        <i class="fa fa-balance-scale"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="wishlist"
                                       name="<?php echo html_escape($cat_pro[$i]['product_id']) ?>"
                                       title="<?php echo display('add_to_wishlist') ?>"><i
                                                class="fa fa-heart"></i></a>
                                </li>
                                <li>
                                    <a href="<?php echo $cat_pro[$i]['image_thumb'] ?>"
                                       data-lightbox="image-1"
                                       title="<?php echo display('quick_view') ?>"><i
                                                class="fa fa-search"></i></a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('category_product/' . $cat_pro[$i]['category_id']) ?>"
                                       title="<?php echo display('category_wise_product') ?>"><i
                                                class="fa fa-arrows"></i></a>
                                </li>
                            </ul>
                            <div class="addtocard">
                                <div class="addtocard">
                                    <?php if($is_aff){ 
                                        if($cat_pro[$i]['is_affiliate'] == 1 ){ ?>
                                            <a href="<?php echo html_escape($cat_pro[$i]['affiliate_url']) ?>" target="0">
                                                <button type="button" class="cart_button color2"><?php echo display('buy_now') ?></button>
                                            </a>
                                    <?php }else{ ?> 
                                        <?php echo form_open('');?>
                                            <input type="hidden" id="sst" value="1">
                                            <a href="javascript:void(0)" onclick="add_to_cart_item('<?php echo $cat_pro[$i]['product_id']; ?>', '<?php echo remove_space($cat_pro[$i]['product_name']); ?>', '<?php echo $cat_pro[$i]['default_variant']; ?>', <?php echo $cat_pro[$i]['variant_price']; ?>);">
                                                <button type="button" class="cart_button color2"><?php echo display('add_to_cart') ?></button>
                                            </a>
                                        <?php echo form_close(); ?>
                                    <?php } }else{ ?>
                                        <?php echo form_open('');?>
                                            <input type="hidden" id="sst" value="1">
                                            <a href="javascript:void(0)" onclick="add_to_cart_item('<?php echo $cat_pro[$i]['product_id']; ?>', '<?php echo remove_space($cat_pro[$i]['product_name']); ?>', '<?php echo $cat_pro[$i]['default_variant']; ?>', <?php echo $cat_pro[$i]['variant_price']; ?>);">
                                                <button type="button" class="cart_button color2"><?php echo display('add_to_cart') ?></button>
                                            </a>
                                        <?php echo form_close(); ?>
                                    <?php }  ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
    if (!empty($block['block_image'])) {
        ?>
        <div class="row db m0 banner_area">
            <a href="#">
                <img src="<?php echo base_url() . $block['block_image'] ?>" alt="image">
            </a>
        </div>
        <?php
    }
    ?>
</div>
</div>
</div>
</section>
<!--========== End Product Category Area ==========-->
<?php
}
}
}
}
?>

<?php if (!empty($select_home_adds)) {
foreach ($select_home_adds as $ads):
if (2 == $ads->adv_position && !empty($ads->adv_code) && empty($ads->adv_code2) && empty($ads->adv_code3)) {
?>
<section class="overview_area wow fadeInUp">
<div class="container">
<div class="row overview_inner">
<div class="col-sm-12">
<?php echo $ads->adv_code; ?>
</div>
</div>
</section>


<?php } else if (2 == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && empty($ads->adv_code3)) { ?>

<section class="overview_area wow fadeInUp">
<div class="container">
<div class="row overview_inner">
<div class="col-sm-6">
<?php echo $ads->adv_code; ?>
</div>

<div class="col-sm-6">
<?php echo $ads->adv_code2; ?>
</div>
</div>
</section>


<?php } else if (2 == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && !empty($ads->adv_code3)) { ?>

<section class="overview_area wow fadeInUp">
<div class="container">
<div class="row overview_inner">
<div class="col-sm-4">
<?php echo $ads->adv_code; ?>
</div>
<div class="col-sm-4">
<?php echo $ads->adv_code2; ?>
</div>
<div class="col-sm-4">
<?php echo $ads->adv_code3; ?>
</div>
</div>
</section>

<?php } ?>
<?php
endforeach;
} ?>


<!--=========== Newsletter Area ===========-->
<section class="newsletter_area">
<div class="container">
<div class="row m0 newsletter_inner bg_gray">
<div class="col-lg-6 col-xl-5">
<div class="row m0 newsletter_left_area">
<h4><?php echo display('subscribe_for_news_and') ?> <span
    class="color5"><?php echo display('offers') ?></span></h4>
<h6><?php echo display('you_may_unsubscribe_at_any_time') ?></h6>
</div>
</div>
<div class="col-lg-6 col-xl-7">
<div id="sub_msg"></div>
<?php echo form_open('', array('class' => 'row m0 newsletter_form'))?>
<div class="input-group">
<input type="email" class="form-control" placeholder="<?php echo display('enter_your_email') ?>"
   required="" id="sub_email">
<span class="input-group-btn">
<button class="btn btn-default subscribe color4" type="button" id="smt_btn"><i class="fa
 fa-paper-plane"></i></button>
</span>
</div>
<?php echo form_close(); ?>
</div>
</div>
</div>
</section>
<!--========= End Newsletter Area =========-->

<?php if (!empty($select_home_adds)) {
foreach ($select_home_adds as $ads):
if (3 == $ads->adv_position && !empty($ads->adv_code) && empty($ads->adv_code2) && empty($ads->adv_code3)) {
?>
<section class="overview_area wow fadeInUp">
<div class="container">
<div class="row overview_inner">
<div class="col-sm-12">
<?php echo $ads->adv_code; ?>
</div>
</div>
</section>


<?php } else if (3 == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && empty($ads->adv_code3)) { ?>

<section class="overview_area wow fadeInUp">
<div class="container">
<div class="row overview_inner">
<div class="col-sm-6">
<?php echo $ads->adv_code; ?>
</div>

<div class="col-sm-6">
<?php echo $ads->adv_code2; ?>
</div>
</div>
</section>


<?php } else if (3 == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && !empty($ads->adv_code3)) { ?>

<section class="overview_area wow fadeInUp">
<div class="container">
<div class="row overview_inner">
<div class="col-sm-4">
<?php echo $ads->adv_code; ?>
</div>
<div class="col-sm-4">
<?php echo $ads->adv_code2; ?>
</div>
<div class="col-sm-4">
<?php echo $ads->adv_code3; ?>
</div>
</div>
</section>

<?php } ?>
<?php
endforeach;
} ?>

