<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php 
    $is_aff = false;
    if(check_module_status('affiliate_products') == 1){
        $is_aff = true;
    }
?>
<!--========== Page Header Area ==========-->
<?php if (!empty($select_category_adds)) {
    foreach ($select_category_adds as $ads):
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
<section class="page_header">
    <div class="container">
        <div class="row m0 page_header_inner">
            <h5><?php echo html_escape($total) . " ";
                echo display('search_items');
                echo " \"$keyword \""; ?> </h5>
            <a class="btn btn-warning color3 mt-3" href="<?php echo base_url() ?>"><i class="fa fa-hand-o-left"
                                                                                      aria-hidden="true"></i>
                <?php echo display('back_to_home') ?></a>
        </div>
    </div>
</section>
<!--========== End Page Header Area ==========-->

<?php
if (!(empty($category_product))) {
    ?>

    <!--========== Product Category Area ==========-->
    <section class="product_category">
        <div class="container">
            <div class="product_category_inner container_section">
                <div class="product_inner">
                    <div class="row m0 slider_style">
                        <?php

                        if ($category_product) {
                            foreach ($category_product as $product) {
                                ?>
                                <div class="col-xl-3 col-lg-4 col-sm-6 single_product_item">
                                    <div class="item item_shadow">
                                        <div class="item_image">
                                            <a href="<?php echo base_url('product_details/' . remove_space($product->product_name) . '/' . $product->product_id) ?>">
                                                <img src="<?php echo base_url() . $product->image_thumb ?>"
                                                     alt="product-image">
                                            </a>
                                        </div>
                                        <div class="item_info">
                                            <h6><?php echo html_escape($product->product_name) ?></h6>
                                            <div class="rating_area">
                                                <div class="rate-container">
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

                                            <?php if ($product->onsale == 1 && !empty($product->onsale_price)) { ?>
                                                <div class="product_cost">
                                                    <p class="current">
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
                                                    </p>
                                                    <p class="previous">
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
                                                    </p>
                                                </div>
                                            <?php } else { ?>
                                                <div class="product_cost">
                                                    <p class="current">
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
                                                    </p>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="item_hover">
                                            <ul class="nav">
                                                <li>
                                                    <a href="javascript:void(0)" class="compare" onclick="comparison_btn(<?php echo html_escape($product->product_id) ?>)">
                                                        <i class="fa fa-balance-scale"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="wishlist" name="<?php echo html_escape($product->product_id) ?>">
                                                       <i class="fa fa-heart"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo base_url() . $product->image_thumb ?>" data-lightbox="image-1">
                                                       <i class="fa fa-search"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo base_url('category_product/' . $product->category_id) ?>">
                                                        <i class="fa fa-arrows"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="addtocard">
                                                <?php if($is_aff){ 
                                                    if($product->is_affiliate == 1 ){ ?>
                                                        <a href="<?php echo html_escape($product->affiliate_url) ?>" target="0">
                                                            <button type="button" class="cart_button color2"><?php echo display('buy_now') ?></button>
                                                        </a>
                                                <?php }else{ ?> 
                                                    <?php echo form_open('');?>
                                                        <input type="hidden" id="sst" value="1">
                                                        <a href="javascript:void(0)" onclick="add_to_cart_item('<?php echo $product->product_id; ?>', '<?php echo remove_space($product->product_name); ?>', '<?php echo $product->default_variant; ?>', <?php echo $product->variant_price; ?>);">
                                                            <button type="button" class="cart_button color2"><?php echo display('add_to_cart') ?></button>
                                                        </a>
                                                    <?php echo form_close(); ?>
                                                <?php } }else{ ?>
                                                    <?php echo form_open('');?>
                                                        <input type="hidden" id="sst" value="1">
                                                        <a href="javascript:void(0)" onclick="add_to_cart_item('<?php echo $product->product_id; ?>', '<?php echo remove_space($product->product_name); ?>', '<?php echo $product->default_variant; ?>', <?php echo $product->variant_price; ?>);">
                                                            <button type="button" class="cart_button color2"><?php echo display('add_to_cart') ?></button>
                                                        </a>
                                                    <?php echo form_close(); ?>
                                                <?php }  ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <nav aria-label="page navigation example">
                        <?php echo htmlspecialchars_decode($links); ?>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!--========== End Product Category Area ==========-->
    <?php
} else {
    ?>
    <!--========== Category Product Empty ==========-->
    <section class="shopping_cart_area">
        <div class="container">
            <div class="row db empty_cart">
                <img src="<?php echo base_url() ?>assets/website/image/oops.png" alt="oops image">
                <h2 class="page_title"><?php echo display('category_product_not_found') ?></h2>
            </div>
        </div>
    </section>
    <!--========== Category Product Empty ==========-->
    <?php
}
?>
<?php if (!empty($select_category_adds)) {
    foreach ($select_category_adds as $ads):
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
                    <h4><?php echo display('sign_up_for_news_and') ?> <span><?php echo display('offers') ?></span></h4>
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
                            <button class="btn btn-default subscribe color3" type="button" id="smt_btn"><i class="fa
                            fa-search"></i></button>
                        </span>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>
<!--========= End Newsletter Area =========-->
<?php if (!empty($select_category_adds)) {
    foreach ($select_category_adds as $ads):
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

