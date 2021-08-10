<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php 
    $is_aff = false;
    if(check_module_status('affiliate_products') == 1){
        $is_aff = true;
    }
?>
<!-- ========== Page Header Area ========== -->
<section class="page_header">
<div class="container">
<div class="row m0 page_header_inner">
    <h2 class="page_title"><?php echo display('category') ?></h2>
    <ol class="breadcrumb m0 p0">
        <li class="breadcrumb-item"><a href="<?php echo base_url() ?>"><?php echo display('home') ?></a></li>
        <li class="breadcrumb-item active"><?php echo html_escape($category_name) ?></li>
    </ol>
</div>
</div>
</section>
<!--========== End Page Header Area ==========-->
<section class="overview_area wow fadeInUp">
<div class="container">
<div class="row m0 overview_inner">
    <?php
    if ($select_category_adds) {
        foreach ($select_category_adds as $adds) {
            if ($adds->adv_position == 1 && $adds->status == 1) {
                echo $adds->adv_code;
            }
        }
    }
    ?>
</div>
</div>
</section>
<!--========== Product Category  ===========-->
<section class="product_category">
<div class="container">
<div class="row product_category_inner container_section">
    <div class="col-lg-3 col-md-5">

        <div class="price_range">
            <p>
                <?php echo display('price_range') ?>:<span id="amount"></span>
            </p>
            <div id="slider-range"></div>
            <?php echo form_open('')?>

                <input type="hidden" id="amount1">
                <input type="hidden" id="amount2">
            <?php echo form_close(); ?>
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

        <div class="row m0 db bg_gray best_sale">
            <h4 class="heading-2 color3"><?php echo display('best_sales') ?></h4>
            <?php
            $this->db->select('*');
            $this->db->from('product_information');
            $this->db->where('best_sale', '1');
            $this->db->where('category_id', $category_id);
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
                                    <p class="current color35">
                                        <?php
                                        if ($target_con_rate > 1) {
                                            $price = $sales->onsale_price * $target_con_rate;
                                            echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                        }

                                        if ($target_con_rate <= 1) {
                                            $price = $sales->onsale_price * $target_con_rate;
                                            echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                        }
                                        ?>
                                    </p>
                                    <p class="previous">

                                        <?php
                                        if ($target_con_rate > 1) {
                                            $price = $sales->price * $target_con_rate;
                                            echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                        }

                                        if ($target_con_rate <= 1) {
                                            $price = $sales->price * $target_con_rate;
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
                                            $price = $sales->price * $target_con_rate;
                                            echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                        }

                                        if ($target_con_rate <= 1) {
                                            $price = $sales->price * $target_con_rate;
                                            echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                        }
                                        ?>
                                    </p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <div class="row m0 db banner_area">
            <?php
            if ($select_category_product) {
                foreach ($select_category_product as $adds) {
                    if ($adds->adv_position == 1) {
                        echo $adds->adv_code;
                    }
                }
            }
            ?>
        </div>
    </div>
    <input type="hidden" name="category_id" id="category_id" value="<?php echo html_escape($this->uri->segment(2)) ?>">
    <div class="col-lg-9 col-md-7">
        <div class="product_inner">
            <div class="row slider_style">
                <?php
                if ($category_wise_product) {
                    foreach ($category_wise_product as $product) {
                        ?>
                        <div class="col-lg-3 col-sm-6 single_product_item">
                            <div class="item item_category">
                                <div class="item_inner">
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
                                                <a href="javascript:void(0)" class="compare"
                                                    onclick="comparison_btn(<?php echo html_escape($product->product_id) ?>)">
                                                    <i class="fa fa-balance-scale"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="wishlist"
                                                   name="<?php echo html_escape($product->product_id) ?>"><i
                                                            class="fa fa-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="<?php echo $product->image_thumb ?>"
                                                   data-lightbox="image-1"><i class="fa fa-search"></i></a>
                                            </li>
                                            <li>
                                                <a href="<?php echo base_url('category_product/' . $product->category_id) ?>"><i
                                                            class="fa fa-arrows"></i></a>
                                            </li>
                                        </ul>
                                        <div class="addtocard">
                                            <?php echo form_open('')?>
                                                <input type="hidden" value="1">
                                                <a href="<?php echo base_url('product_details/' . remove_space($product->product_name) . '/' . $product->product_id) ?>">
                                                    <button type="button"
                                                            class="cart_button color2"><?php echo display('add_to_cart') ?></button>
                                                </a>
                                            <?php echo form_close(); ?>
                                            <?php if($is_aff){ 
                                                    if($product->is_affiliate == 1 ){ ?>
                                                        <a href="<?php echo html_escape($product->affiliate_url) ?>" target="0">
                                                            <button type="button" class="cart_button color2"><?php echo display('buy_now') ?></button>
                                                        </a>
                                                <?php }else{ ?> 
                                                    <?php echo form_open('');?>
                                                        <input type="hidden" value="1">
                                                        <a href="<?php echo base_url('product_details/' . remove_space($product->product_name) . '/' . $product->product_id) ?>">
                                                            <button type="button" class="cart_button color2"><?php echo display('add_to_cart') ?></button>
                                                        </a>
                                                    <?php echo form_close(); ?>
                                                <?php } }else{ ?>
                                                    <?php echo form_open('');?>
                                                        <input type="hidden" value="1">
                                                        <a href="<?php echo base_url('product_details/' . remove_space($product->product_name) . '/' . $product->product_id) ?>">
                                                            <button type="button" class="cart_button color2"><?php echo display('add_to_cart') ?></button>
                                                        </a>
                                                    <?php echo form_close(); ?>
                                                <?php }  ?>
                                        </div>
                                    </div>
                                    <span><?php echo display('new') ?></span>
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
</div>
</section>
<!-- ======== End Product Category ========== -->
<section class="overview_area wow fadeInUp">
<div class="container">
<div class="row m0 overview_inner">
    <?php
    if ($select_category_adds) {
        foreach ($select_category_adds as $adds) {
            if ($adds->adv_position == 2 && $adds->status == 1) {
                echo $adds->adv_code;
            }
        }
    }
    ?>
</div>
</div>
</section>
<input type="hidden" id="min_value" value="<?php echo html_escape($min_value)?>">
<input type="hidden" id="max_value" value="<?php echo html_escape($max_value)?>">
<input type="hidden" name="from_price" id="from_price" value="<?php echo html_escape($from_price) ?>">
<input type="hidden" name="to_price" id="to_price" value="<?php echo html_escape($to_price) ?>">
<input type="hidden" id="default_currency_icon" value="<?php echo html_escape($default_currency_icon)?>">