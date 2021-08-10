<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$CI =& get_instance();
?>

<input type="hidden" name="customer_id" id="customer_id" value="<?php echo $this->session->userdata('customer_id') ?>">
<div class="page-breadcrumbs">
<div class="container">
<ol class="breadcrumb">
<li><a href="<?php echo base_url() ?>"><?php echo display('home') ?></a></li>
<li>
<a href="<?php echo base_url('category/p/' . remove_space($category_name) . '/' . $category_id) ?>"><?php echo html_escape($category_name); ?></a>
</li>
<li class="active"><?php echo html_escape($product_name); ?></li>
</ol>
</div>
</div>
<!-- /.End of page breadcrumbs -->

<?php if (!empty($select_details_adds)) {
foreach ($select_details_adds as $ads):
if (1 == $ads->adv_position && !empty($ads->adv_code) && empty($ads->adv_code2) && empty($ads->adv_code3)) {
?>
<div class="details-adds">
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <?php echo $ads->adv_code; ?>
        </div>
    </div>
</div>
</div>

<?php } else if (1 == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && empty($ads->adv_code3)) { ?>

<div class="details-adds">
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

<?php } else if (1 == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && !empty($ads->adv_code3)) { ?>

<div class="details-adds">
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

<div class="product-details-content">
<div class="product-details-inner">
<div class="container">
<div class="row">
<div class="col-sm-12">
    <div class="product-header align-items-center">
        <div class="col-sm-8">
            <h1 class="product-title"><?php echo html_escape($product_name) ?></h1>
            <ul class="entry-meta">
                <li class="meta-brand"> <?php echo display('brand') ?> : <a
                            href="<?php echo base_url('brand_product/list/' . $brand_id) ?>"
                            class="meta-value"><?php
                        echo html_escape($brand_name) ?></a></li>
                <li>
                    <div class="product-rating">
                        <?php
                        $result = $this->db->select('sum(rate) as rates')
                            ->from('product_review')
                            ->where('product_id', $product_id)
                            ->get()
                            ->row();
                        $rater = $this->db->select('rate')
                            ->from('product_review')
                            ->where('product_id', $product_id)
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
                </li>
                <li class="meta-sku"><?php echo display('product_model') ?> : <span
                            class="meta-value"> <?php echo html_escape($product_model); ?> </span></li>
            </ul>
        </div>
        <div class="col-sm-4">
            <?php if(isset($web_settings[0]['social_share']) && !empty($web_settings[0]['social_share'])){ ?>
             <!-- AddToAny BEGIN -->
            <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
                <a class="a2a_button_facebook"></a>
                <a class="a2a_button_whatsapp"></a>
                <a class="a2a_button_twitter"></a>
                <a class="a2a_button_linkedin"></a>
                <a class="a2a_button_telegram"></a>
                <a class="a2a_button_pinterest"></a>
                <a class="a2a_button_skype"></a>
                <a class="a2a_button_copy_link"></a>
            </div>
            <script async src="https://static.addtoany.com/menu/page.js"></script>
            <?php } ?>

        </div>
    </div>
</div>
</div>
<div class="row">
<div class="col-sm-6">
    <div class="wrapper">
        <div class="product-images">
            <div class="row">
                <div class="col-xs-3 col-sm-2">
                    <ul class="thumb-nav">
                        <li><img src="<?php echo base_url() . $image_thumb; ?>" alt="product image">
                        </li>
                        <?php
                        if ($product_gallery_img) {
                            foreach ($product_gallery_img as $gallery) {
                                ?>
                                <li><img src="<?php echo base_url() . $gallery->image_url ?>"
                                         alt="<?php echo display('image') ?>"></li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div class="col-xs-9 col-sm-10">
                    <!-- Begin Product Images Slider -->
                    <div class="main-img-slider">
                        <figure>
                            <a href="<?php echo base_url() . $image_large_details; ?>"
                               data-size="1400x1400">
                                <img class="" src="<?php echo base_url() . $image_large_details; ?>"
                                     data-lazy="<?php echo base_url() . $image_large_details; ?>"
                                     data-zoom-image="<?php echo base_url() . $image_large_details; ?>"
                                     alt="<?php echo display('image') ?>"/>
                            </a>
                        </figure>
                        <?php

                        if ($product_gallery_img) {
                            foreach ($product_gallery_img as $gallery_tab_img) {
                                ?>
                                <figure>
                                    <a href="<?php echo base_url() . $gallery_tab_img->img_thumb ?>"
                                       data-size="1400x1400">
                                        <img class=""
                                             src="<?php echo base_url() . $gallery_tab_img->image_url ?>"
                                             data-lazy="<?php echo base_url() . $gallery_tab_img->image_url ?>"
                                             data-zoom-image="<?php echo base_url() . $gallery_tab_img->image_url ?>"
                                             alt="<?php echo display('image') ?>"/>
                                    </a>
                                </figure>

                                <?php
                            }
                        }
                        ?>
                    </div>
                    <?php if ($video) { ?>
                        <div class="product-video-btn">
                            <a class="popup-youtube"
                               href="<?php echo html_escape($video); ?>"><span><?php echo display('watch_video'); ?></span></a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
            <!-- Background of PhotoSwipe. It's a separate element, as animating opacity is faster than rgba(). -->
            <div class="pswp__bg"></div>
            <!-- Slides wrapper with overflow:hidden. -->
            <div class="pswp__scroll-wrap">
                <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
                <div class="pswp__container">
                    <!-- don't modify these 3 pswp__item elements, data is added later on -->
                    <div class="pswp__item"></div>
                    <div class="pswp__item"></div>
                    <div class="pswp__item"></div>
                </div>
                <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
                <div class="pswp__ui pswp__ui--hidden">
                    <div class="pswp__top-bar">
                        <!--  Controls are self-explanatory. Order can be changed. -->
                        <div class="pswp__counter"></div>
                        <button class="pswp__button pswp__button--close"
                                title="Close (Esc)"></button>
                        <button class="pswp__button pswp__button--share" title="Share"></button>
                        <button class="pswp__button pswp__button--fs"
                                title="Toggle fullscreen"></button>
                        <button class="pswp__button pswp__button--zoom"
                                title="Zoom in/out"></button>
                        <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
                        <!-- element will get class pswp__preloader-active when preloader is running -->
                        <div class="pswp__preloader">
                            <div class="pswp__preloader__icn">
                                <div class="pswp__preloader__cut">
                                    <div class="pswp__preloader__donut"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  /.pswp__top-bar -->
                    <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                        <div class="pswp__share-tooltip"></div>
                    </div>
                    <button class="pswp__button pswp__button--arrow--left"
                            title="Previous (arrow left)"></button>
                    <button class="pswp__button pswp__button--arrow--right"
                            title="Next (arrow right)"></button>

                    <div class="pswp__caption">
                        <div class="pswp__caption__center"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--  End product zoom  -->
    </div>
    <!-- wrapper -->
</div>

<div class="col-sm-6">
    <input type="hidden" name="model" id="model" value="<?php echo html_escape($product_model) ?>">
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
    <div class="product-summary-content">
        <div class="product-summary">
            <?php
            if ($onsale) {
                ?>
                <div class="product-price">
                    <span class="var_amount">

                    <?php

                    if ($target_con_rate > 1) {
                        $onsale_price = $onsale_price * $target_con_rate;
                        echo(($position1 == 0) ? $currency1 . " " . number_format($onsale_price, 2, '.', ',') : number_format($onsale_price, 2, '.', ',') . " " . $currency1);
                    }

                    if ($target_con_rate <= 1) {
                        $onsale_price = $onsale_price * $target_con_rate;
                        echo(($position1 == 0) ? $currency1 . " " . number_format($onsale_price, 2, '.', ',') : number_format($onsale_price, 2, '.', ',') . " " . $currency1);
                    }
                    ?>
                    </span>
                    <input type="hidden" id="price" name="price"
                           value="<?php echo html_escape($onsale_price) ?>">
                </div>
                <?php
            } else {
                ?>
                <div class="product-price">
                    <span class="var_amount">
                    <?php
                    if ($target_con_rate > 1) {
                        $price = $price * $target_con_rate;
                        echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                    }

                    if ($target_con_rate <= 1) {
                        $price = $price * $target_con_rate;
                        echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                    }
                    ?>
                    </span>
                    <input type="hidden" id="price" name="price" value="<?php echo html_escape($price) ?>">
                </div>

                <?php
            }
            ?>
        </div>
        <ul class="summary-header">
            <li>
                <?php if(!($is_affiliate == 1)){ ?>
                    <p class="stock">
                        <label><?php echo display('status') ?>:</label>
                        <input type="hidden" value="<?php echo html_escape($stok) ?>" id="stok">
                        <?php if ($stok > 0) { ?>
                        <span>
                            <?php echo display('in_stock'); ?>
                        </span>
                        <?php  } else { ?>
                        <span class="required">
                            <?php echo display('out_of_stock'); ?>
                        </span>
                        <?php } ?>
                    </p>    
                <?php } ?>
            </li>
        </ul>
        <div class="short-description">

            <p><?php echo character_limiter(strip_tags($product_details), 200); ?></p>
            <!--  /.End of product color selector -->
            <?php if ($variant) { ?>
                <?php
                    $var_types = [];
                    if (!empty($variant)) {
                        $exploded = explode(',', $variant);
                        $this->db->select('*');
                        $this->db->from('variant');
                        $this->db->where_in('variant_id', $exploded);
                        $this->db->order_by('variant_name', 'asc');
                        $vresult = $this->db->get()->result();

                        $var_types = array_column($vresult, 'variant_type');
                    }
                 ?>

                <div class="product_size p_1e">
                <?php echo form_open('#', array('class' => 'form-inline')); ?>

                        <div class="form-group ">
                            <div class="prod_size_div">
                                <label for="select_size1"
                                       class="variant-label"><?php echo display('product_size') ?>
                                    <span class="required_star"
                                    >*</span> :
                                </label>
                            </div>

                            <div class="dis_inbl">
                                <select id="select_size1" onchange="select_variant(<?php echo html_escape($product_id) ?>)" required="" class="form-control select">
                                    <option value="0"><?php echo display('select') ?></option>
                                     <?php
                                        foreach ($vresult as $vitem) {
                                            if($vitem->variant_type=='size'){
                                    ?>
                                    <option value="<?php echo html_escape($vitem->variant_id) ?>" <?php echo (($vitem->variant_id == $default_variant)?"selected":"") ?>><?php echo html_escape($vitem->variant_name) ?></option>

                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>

                 <?php if(in_array('color', $var_types)){ ?>
                    <div class="product-color mb-3">
                        <?php 
                            foreach ($vresult as $vitem) {
                                if($vitem->variant_type=='color'){
                                    if(empty($default_color)){
                                        $default_color = $vitem->variant_id;  // Set default color if not getting
                                    }
                                    ?>
                            <input type="radio" class="product_colors" name="select_color" id="color_<?php echo $vitem->variant_id; ?>" value="<?php echo $vitem->variant_id; ?>" onclick="select_color_variant(<?php echo html_escape($product_id) ?>,'<?php echo  html_escape($vitem->variant_id) ?>', '<?php echo html_escape($default_variant); ?>')" <?php echo (($vitem->variant_id == $default_color)?'checked="checked"':"") ?>>
                            <label class="mb-0" for="color_<?php echo $vitem->variant_id; ?>"><span class="color_code" style="background: <?php echo (!empty($vitem->color_code)?$vitem->color_code:strtolower($vitem->variant_name)) ?>"></span></label>

                        <?php } }?>

                    </div>
                <?php  }  ?>




                <?php } ?>
            <!--  /.End of product Size -->
        </div>
        <?php echo form_open('', array('class' => 'cart-row')); ?>
            <?php if(!($is_affiliate == 1)){ ?>
                <div class="cart_counter">
                    <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 1 ) result.value--;return false;"
                            class="reduced items-count" type="button">
                        <span class="qty qty-minus" data-dir="dwn">-</span>
                    </button>
                    <input type="text" name="qty" id="sst" maxlength="12" value="1"
                           title="<?php echo display('quantity') ?>"
                           class="input-text qty form-control text-center" min="1">
                    <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                            class="increase items-count" type="button">
                        <span class="qty qty-plus" data-dir="up">+</span>
                    </button>
                </div>
            <?php } ?>


            <?php if ($stok > 0) { ?>
            <a href="javascript:void(0)" onclick="cart_btn(<?php echo html_escape($product_id) ?>)" class="cart-btn" type="submit"><?php echo display('add_to_cart') ?>
            </a>
            <?php }if($is_affiliate == 1){ ?>
            <a href="<?php echo html_escape($affiliate_url) ?>" target ="0" class="cart-btn" type="submit"><?php echo display('buy_now') ?>
            <?php } ?>
            <a href="javascript:void(0)" class="add-wishlist wishlist" data-toggle="tooltip" data-placement="top" title="<?php echo display('wishlist') ?>" name="<?php echo html_escape($product_id) ?>">
               <i class="lnr lnr-heart"></i>
            </a>
            <p class="add-wishlist" onclick="comparison_btn(<?php echo html_escape($product_id) ?>)" title="<?php echo display('compare') ?>" >
               <i class="lnr lnr-chart-bars"></i>
            </p>
        <?php echo form_close(); ?>
            
        <input type="hidden" id="product_id" name="product_id" value="<?php echo html_escape($product_id) ?>">
    </div>
</div>
</div>
</div>
</div>

<?php if (!empty($select_details_adds)) {
foreach ($select_details_adds as $ads):
if (2 == $ads->adv_position && !empty($ads->adv_code) && empty($ads->adv_code2) && empty($ads->adv_code3)) {
?>
<div class="details-adds">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <?php echo $ads->adv_code; ?>
            </div>
        </div>
    </div>
</div>

<?php } else if (2 == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && empty($ads->adv_code3)) { ?>

<div class="details-adds">
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

<?php } else if (2 == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && !empty($ads->adv_code3)) { ?>

<div class="details-adds">
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
<div class="similar-products-content">
<div class="container">
<h3 class="title-widget color36"><span class="color3 color36"><?php echo display('similar_products')
    ?></span></h3>
<div class="products-slide">
<?php
if ($related_product) {
    foreach ($related_product as $product) {
        ?>
        <div class="product-box">
            <div class="imagebox">
                <a href="<?php echo base_url('product_details/' . remove_space($product->product_name) . '/' . $product->product_id) ?>">
                    <h3 class="product-name"><?php echo html_escape($product->product_name) ?></h3>
                    <div class="product-thumb">
                        <img src="<?php echo base_url() . $product->image_thumb ?>"
                             data-src="<?php echo base_url() . $product->image_thumb ?>" alt="">
                    </div>
                </a>

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

                <div class="price-cart">
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
                            </span><!-- /.Price -->
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
                            </span><!-- /.Price -->
                        <?php
                    }
                    ?>
                    <div class="rating_stars">
                        <div class="rating-wrap">
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
                        <div class="total-rating">(<?php echo htmlspecialchars_decode($rater) ?>)</div>
                    </div><!-- Rating -->
                </div>
                <div class="box-bottom">
                    <div class="btn-add-cart">
                        <a  href="javascript:void(0)" onclick="add_to_cart_item('<?php echo $product->product_id; ?>', '<?php echo remove_space($product->product_name); ?>', '<?php echo $product->default_variant; ?>', <?php echo $product->variant_price; ?>);">
                            <img src="<?php echo base_url() . '/assets/website/image/add-cart.png' ?>"
                                 alt=""><?php echo display('add_to_cart') ?>
                        </a>
                    </div>
                    <div class="compare-wishlist">
                        <a href="javascript:void(0)"
                               onclick="comparison_btn(<?php echo html_escape($product->product_id) ?>)"
                               title="<?php echo display('compare') ?>" >
                               <i class="lnr lnr-chart-bars"></i> <?php echo display('compare') ?>
                        </a>
                        <a href="javascript:void(0)" class="wishlist" title=""
                           name="<?php echo html_escape($product->product_id) ?>">
                            <img src="<?php echo base_url() .'/assets/website/image/wishlist.png' ?>"
                                 alt=""><?php echo display('wishlist'); ?>
                        </a>
                    </div>
                </div><!-- /.box-bottom -->
            </div>
        </div>
    <?php }
}
?>
</div>
</div>
</div>
<!--    =============================-->

<?php
$total_rate = 0;
$result = $this->db->select('sum(rate) as rates')
->from('product_review')
->where('product_id', $product_id)
->get()
->row();
$rater = $this->db->select('rate')
->from('product_review')
->where('product_id', $product_id)
->get()
->num_rows();
if ($result->rates != null) {
$total_rate = $result->rates / $rater;
}
?>
<div class="product-details-tab">
<div class="text-center">
<ul class="nav nav-tabs">
<li><a href="#tab2default" data-toggle="tab"><?php echo display('feedback') ?>
        (<?php echo htmlspecialchars_decode($rater) ?>)
    </a></li>
<li  class="active"><a href="#tab3default" data-toggle="tab"><?php echo display('description') ?></a></li>
<li><a href="#tab1default" data-toggle="tab"><?php echo display('specification') ?></a></li>
</ul>
</div>
<div class="tab-content">
<div class="tab-pane fade" id="tab1default">
<div class="container">
    <?php if ($specification != '') {
        echo htmlspecialchars_decode($specification);
    } ?>
</div>
</div>
<div class="tab-pane fade" id="tab2default">
<div class="container">
    <div class="row">
        <div class="col-sm-7 content">
            <div class="rating-block-wrapper">
                <h3 class="title"><?php echo display('ratings_and_reviews') ?></h3>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="rating-block text-center">
                            <h4><?php echo display('avg_user_rating') ?></h4>
                            <div class="rating-point center-block">
                                <i class="glyphicon glyphicon-star color35"></i>
                                <h3>
                                    <?php
                                    if ($total_rate) {
                                        echo number_format("$total_rate", 1, ".", ".");
                                    } else {
                                        echo "0";
                                    }
                                    ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="rating-position">
                            <h4><?php echo display('rating_breakdown') ?></h4>
                            <div class="rating-dimension">
                                <div class="rating-quantity">
                                    <div><?php echo display('5') ?> <span
                                                class="glyphicon glyphicon-star"></span></div>
                                </div>
                                <div class="rating-percent">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success width_100p"
                                             role="progressbar" aria-valuenow="5" aria-valuemin="0"
                                             aria-valuemax="5" >
                                            <span class="sr-only"><?php echo display('100_percent_complete'); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="user-rating">
                                    <?php
                                    echo $this->Products_model->get_total_five_start_rating($product_id, 5);
                                    ?>
                                </div>
                            </div><!-- /.End of rating dimension -->
                            <div class="rating-dimension">
                                <div class="rating-quantity">
                                    <div><?php echo display('4') ?> <span
                                                class="glyphicon glyphicon-star"></span></div>
                                </div>
                                <div class="rating-percent">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary width_80p"
                                             role="progressbar" aria-valuenow="5" aria-valuemin="0"
                                             aria-valuemax="5">
                                            <span class="sr-only"><?php echo display('80_percent_complete'); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="user-rating">
                                    <?php
                                    echo $this->Products_model->get_total_five_start_rating($product_id, 4);
                                    ?></div>
                            </div><!-- /.End of rating dimension -->
                            <div class="rating-dimension">
                                <div class="rating-quantity">
                                    <div><?php echo display('3') ?> <span
                                                class="glyphicon glyphicon-star"></span></div>
                                </div>
                                <div class="rating-percent">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-info width_60p"
                                             role="progressbar"
                                             aria-valuenow="5" aria-valuemin="0" aria-valuemax="5">
                                            <span class="sr-only"><?php echo display('60_percent_complete'); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="user-rating"> <?php
                                    echo $this->Products_model->get_total_five_start_rating($product_id, 3);
                                    ?></div>
                            </div><!-- /.End of rating dimension -->
                            <div class="rating-dimension">
                                <div class="rating-quantity">
                                    <div><?php echo display('2') ?> <span
                                                class="glyphicon glyphicon-star"></span></div>
                                </div>
                                <div class="rating-percent">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-warning width_40p"
                                             role="progressbar" aria-valuenow="5" aria-valuemin="0"
                                             aria-valuemax="5">
                                            <span class="sr-only"><?php echo display('40_percent_complete'); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="user-rating"> <?php
                                    echo $this->Products_model->get_total_five_start_rating($product_id, 2);
                                    ?></div>
                            </div><!-- /.End of rating dimension -->
                            <div class="rating-dimension">
                                <div class="rating-quantity">
                                    <div><?php echo display('1') ?> <span
                                                class="glyphicon glyphicon-star"></span></div>
                                </div>
                                <div class="rating-percent">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-danger width_20p"
                                             role="progressbar"
                                             aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" >
                                            <span class="sr-only"><?php echo display('20_percent_complete'); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="user-rating"> <?php echo $this->Products_model->get_total_five_start_rating($product_id, 1); ?></div>
                            </div><!-- /.End of rating dimension -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="review-block-wrapper">
                <?php
                if ($review_list) {
                    foreach ($review_list as $review) :
                        $customer_id = $review->reviewer_id;
                        ?>
                        <div class="review-block loadMoreicon">
                            <div class="review-block-rate">
                                <button type="button" class="btn
                                    <?php
                                if ($review->rate == 5) {
                                    echo("btn-success");
                                } elseif ($review->rate == 4) {
                                    echo("btn-info");
                                } elseif ($review->rate == 3) {
                                    echo("btn-warning");
                                } elseif ($review->rate == 2) {
                                    echo("btn-danger");
                                } else {
                                    echo("btn-danger");
                                }
                                ?> btn-xs" aria-label="Left Align">
                                    <?php echo html_escape($review->rate); ?> <span
                                            class="glyphicon glyphicon-star"
                                            aria-hidden="true"></span>
                                </button>
                            </div>

                            <div class="review-block-description"><?php echo html_escape($review->comments); ?></div>
                            <div class="review-meta-row align-items-center justify-content-between">
                                <div>
                                    <span class="review-block-name">
                                        <?php
                                        $get_customer_name = $this->Products_model->get_customer_name($customer_id);
                                        if ($get_customer_name) {
                                            echo html_escape($get_customer_name->customer_name);
                                        }
                                        ?>
                                    </span>
                                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                                    <span class="review-block-date">
                                        <?php
                                        echo date('d M Y', strtotime($review->date_time));
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php
                    endforeach;
                }
                ?>
                <div class="review-footer">
                    <div class="view-all-review">
                        <a href="javascript:void(0)"
                           id="loadMore"><?php echo display('view_more') ?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-5 rightSidebar">
            <div class="review-content">
                <div class="review-product-info">
                    <h4 class="review-product-name"><?php echo html_escape($product_name) ?></h4>
                    <div class="review-product-brand"><?php echo html_escape($category_name) ?></div>
                </div>
                <?php echo form_open('', array('class' => 'review-form')); ?>
                    <div class="rating-content">
                        <label for="input-1" class="control-label"><?php echo display('rate_it') ?>:
                            *</label>
                        <input type="text" id="input-1" name="rating" class="rating rating-loading"
                               data-min="0" data-max="5" data-step="1" value="2">
                    </div>

                    <div class="form-group">
                        <label><?php echo display('review') ?> *</label>
                        <textarea class="form-control" name="review_msg"
                                  placeholder="<?php echo display('review') ?>" rows="5"
                                  id="review_msg"></textarea>
                    </div>
                    <input type="button" id="review_submit" class="btn btn-warning review color4 color36" value="<?php echo display('submit') ?>">
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Rating or review product -->
<div class="tab-pane fade in active" id="tab3default">
<div class="container">
    <div class="product-description">
        <?php if ($description) {
            echo htmlspecialchars_decode($description);
        } ?>
    </div>
    <!-- /.End of product description -->
</div>
</div>
</div>
</div>

</div>

<!--  ==============================  -->


<?php if (!empty($select_details_adds)) {
foreach ($select_details_adds as $ads):
if (3 == $ads->adv_position && !empty($ads->adv_code) && empty($ads->adv_code2) && empty($ads->adv_code3)) {
?>
<div class="details-adds">
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <?php echo $ads->adv_code; ?>
        </div>
    </div>
</div>
</div>

<?php } else if (3 == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && empty($ads->adv_code3)) { ?>

<div class="details-adds">
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

<?php } else if (3 == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && !empty($ads->adv_code3)) { ?>

<div class="details-adds">
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
if ($best_sales_category) {
?>
<div class="similar-products-content">
<div class="container">
<h3 class="title-widget color36"><span
        class="color3 color36 segment-title"><?php echo display('you_may_alo_be_interested_in')
    ?></span></h3>
<div class="products-slide">
<?php
if ($best_sales_category) {
    foreach ($best_sales_category as $product) {
        ?>
        <div class="product-box">
            <div class="imagebox">
                        <span class="product-cat"><a
                                    href="<?php echo base_url('category/p/' . remove_space($product->category_name) . '/'
                                        . $product->category_id) ?>"><?php echo html_escape($product->category_name) ?></a></span>
                <a href="<?php echo base_url('product_details/' . remove_space($product->product_name) . '/' . $product->product_id) ?>">
                    <h3 class="product-name"><?php echo html_escape($product->product_name) ?></h3>
                    <div class="product-thumb">
                        <img src="<?php echo base_url() ?>assets/website/image/loader.svg"
                             data-src="<?php echo base_url() . $product->image_thumb ?>" alt="">
                    </div>
                </a>
                <span>
                      <b>
                        <?php
                        if ($product->brand_name) {
                            echo html_escape($product->brand_name);
                        } else {
                            echo html_escape($product->product_name);
                        }
                        ?>
                    </b>
                </span>
                <div class="price-cart">
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

                    <?php if ($product->onsale == 1 && !empty($product->offer_price)) { ?>
                        <span class="price">
                            <span class="price-amount">
                                <ins><span class="amount">
                                    <?php
                                    $price = $product->offer_price * $target_con_rate;
                                    echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                    ?>
                                </span></ins>
                                <del><span class="amount">
                                    <?php
                                    $price = $product->price * $target_con_rate;
                                    echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                    ?>
                                </span></del>
                            </span>
                        </span>
                        <?php
                    } else {
                        ?>
                        <span class="price">
                            <span class="price-amount">
                                <ins><span class="amount">
                                    <?php
                                    $price = $product->price * $target_con_rate;
                                    echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                    ?>
                                </span></ins>
                            </span>
                        </span>
                        <?php
                    }
                    ?>
                    <div class="rating_stars">
                        <div class="rating-wrap color35">
                            <?php
                            $result = $this->db->select('sum(rate) as rates')
                                ->from('product_review')
                                ->where('product_id', $product_id)
                                ->get()
                                ->row();

                            $rater = $this->db->select('rate')
                                ->from('product_review')
                                ->where('product_id', $product_id)
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
                        <div class="total-rating">(<?php echo htmlspecialchars_decode($rater) ?>)</div>
                    </div><!-- Rating -->
                </div><!-- /.price-add-to-cart -->
                <div class="box-bottom">
                    
                    <div class="btn-add-cart">
                        <a  href="javascript:void(0)" onclick="add_to_cart_item('<?php echo $product->product_id; ?>', '<?php echo remove_space($product->product_name); ?>', '<?php echo $product->default_variant; ?>', <?php echo $product->variant_price; ?>);">
                            <img src="<?php echo base_url('assets/website/image/add-cart.png') ?>"
                                 alt=""><?php echo display('add_to_cart') ?>
                        </a>
                    </div>
                    
                    <div class="compare-wishlist">
                        <a href="javascript:void(0)"
                           onclick="comparison_btn(<?php echo html_escape($product->product_id) ?>)"
                           title="<?php echo display('compare') ?>" >
                           <i class="lnr lnr-chart-bars"></i> <?php echo display('compare') ?>
                        </a>
                        <a href="javascript:void(0)" class="wishlist" title=""
                           name="<?php echo html_escape($product->product_id) ?>">
                            <img src="<?php echo base_url('assets/website/image/wishlist.png') ?>"
                                 alt=""><?php echo display('wishlist') ?>
                        </a>
                    </div>
                </div><!-- /.box-bottom -->
            </div>
        </div>
        <?php
    }
}
?>
</div>
</div>
</div>
<?php
}
?>
<?php if (!empty($select_details_adds)) {
foreach ($select_details_adds as $ads):
if (4 == $ads->adv_position && !empty($ads->adv_code) && empty($ads->adv_code2) && empty($ads->adv_code3)) {
?>
<div class="details-adds">
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <?php echo $ads->adv_code; ?>
        </div>
    </div>
</div>
</div>

<?php } else if (4 == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && empty($ads->adv_code3)) { ?>

<div class="details-adds">
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

<?php } else if (4 == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && !empty($ads->adv_code3)) { ?>

<div class="details-adds">
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

<input type="hidden" id="color_variant_id" value="<?php echo @$default_color; ?>">