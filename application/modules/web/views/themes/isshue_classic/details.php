<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>



<section id="default" class="product_details">

<?php if (!empty($select_details_adds)) {
foreach ($select_details_adds as $ads):
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
<div class="container">
<div class="row product_details_inner">
    <div class="col-xl-5 col-md-6">
        <!--========== Product zoom Area ==========-->
        <div class="row m0 product_zoom">
            <!-- Tab panes -->
            <div class="col-md-12">
            <div class="tab-content">
                <div class="tab-pane active" id="product1" role="tabpanel">
                    <div class="easyzoom easyzoom--adjacent">
                        <a href="<?php echo base_url() . $image_large_details ?>">
                            <img src="<?php echo base_url() . $image_thumb ?>" alt="productImage" class="img img-responsive isshue-detail-img">
                        </a>
                    </div>
                </div>
                <?php
                if ($product_gallery_img) {
                    foreach ($product_gallery_img as $gallery) {
                        ?>
                        <div class="tab-pane" id="product_<?php echo $gallery->image_gallery_id ?>"
                             role="tabpanel">
                            <div class="easyzoom easyzoom--adjacent product_img">
                                <a href="<?php echo base_url() . $gallery->image_url ?>">
                                    <img src="<?php echo base_url() . $gallery->image_url ?>"
                                         alt="productImage" class="img img-responsive">
                                </a>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            </div>
            <!-- Nav tabs -->
            <div>
                <ul class="nav nav-pills" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#product1" role="tab">
                            <img src="<?php echo base_url() . $image_thumb ?>" alt="" class="img_thumb">
                        </a>
                        <input type="hidden" name="image" id="image"
                               value="<?php echo base_url() . $image_thumb ?>">
                    </li>
                    <?php
                    if ($product_gallery_img) {
                        foreach ($product_gallery_img as $gallery_tab_img) {
                            ?>

                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab"
                                   href="#product_<?php echo $gallery_tab_img->image_gallery_id ?>" role="tab">
                                    <img src="<?php echo base_url() . $gallery_tab_img->image_url ?>" alt="" class="img_thumb">
                                </a>
                            </li>
                            <?php
                        }
                    }
                    ?>

                     <?php if ($video) { ?>
                        <li class="nav-item product-video-btn">
                            <a class="popup-youtube"
                               href="<?php echo html_escape($video); ?>"><span><?php echo display('watch_video'); ?></span></a>
                        </li>
                    <?php } ?>

                </ul>
            </div>
        </div>
        <!--======== End Product zoom Area ========-->
    </div>
    <div class="col-xl-7 col-md-6">
        <div class="row db m0 product_info">
            <ol class="breadcrumb m0 p0">
                <li class="breadcrumb-item"><a
                            href="<?php echo base_url(); ?>"><?php echo display('home') ?></a></li>
                <li class="breadcrumb-item"><a
                            href="<?php echo base_url('category_product/' . $category_id) ?>"><?php echo html_escape($category_name) ?></a>
                </li>
                <li class="breadcrumb-item active"><?php echo html_escape($product_name) ?></li>
            </ol>
            <h2><?php echo html_escape($product_name) ?></h2>
            <input type="hidden" name="name" id="name" value="<?php echo html_escape($product_name) ?>">
            <div class="rating_area">
                <div class="rate-container">
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
            </div>
            <?php if (!empty($product_details)) { ?>
                <p class="about_product"><?php echo character_limiter(strip_tags($product_details), 200); ?> </p>
            <?php } ?>
            <div class="product_type">
                <p><?php echo display('product_type') ?> : <span><?php echo html_escape($type) ?></span></p>
                <?php if(!($is_affiliate == 1)){ ?>
                    <p><?php echo display('availability') ?> : 
                    <input type="hidden" value="<?php echo html_escape($stok) ?>" id="stok">
                    <?php if ($stok > 0) { ?>
                    <span>
                        <?php echo display('in_stock'); ?>
                    </span>
                    <?php  } else { ?>
                    <span class="text-danger">
                        <?php echo display('out_of_stock'); ?>
                    </span>
                    <?php } ?>
                    </p>
                <?php } ?>

                <p><?php echo display('product_model') ?> : <span> <?php echo html_escape($product_model) ?></span></p>
                <p><?php echo display('brand') ?> : <span> <a
                            href="<?php echo base_url('brand_product/list/' . $brand_id) ?>"
                            class="meta-value"><?php
                        echo html_escape($brand_name) ?></a></span></p>

                <input type="hidden" name="model" id="model" value="<?php echo html_escape($product_model) ?>">
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
            if ($onsale) {
                ?>
                <div class="product_cost">
                    <span><?php echo display('price_of_product') ?> : </span>
                    <div class="current">
                        <p class="color35 var_amount">
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
                        </p>

                        <input type="hidden" id="price" name="price" value="<?php echo html_escape($onsale_price) ?>">
                    </div>
                    <div class="previous">
                        <del class="regular_price">
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
                        </del>

                        <input type="hidden" id="discount" name="discount" value="<?php echo html_escape($price - $onsale_price) ?>">
                    </div>
                </div>
                <?php
            } else {
                ?>
                <div class="product_cost">
                    <span><?php echo display('price_of_product') ?> : </span>
                    <div class="current">
                        <p class="color35 var_amount">
                            <?php
                            if ($target_con_rate > 1) {
                                $price = $price * $target_con_rate;
                                echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                            }

                            if ($target_con_rate <= 1) {
                                $price = $price * $target_con_rate;
                                echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                            }
                            ?></p>
                        <input type="hidden" id="price" name="price" value="<?php echo html_escape($price) ?>">
                    </div>
                </div>
                <?php
            }
            if ($variant) { ?>
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

                <div class="product_size">
                    <span><?php echo display('product_size') ?> * : </span>
                    <?php echo form_open('#')?>
                        <select id="select_size1" onchange="select_variant(<?php echo html_escape($product_id) ?>)"
                                required="" class="form-control">
                            <option value="0">Select</option>
                             <?php
                                foreach ($vresult as $vitem) {
                                    if($vitem->variant_type=='size'){
                                ?>
                            <option value="<?php echo html_escape($vitem->variant_id) ?>" <?php echo (($vitem->variant_id == $default_variant)?"selected":"") ?>><?php echo html_escape($vitem->variant_name) ?></option>

                            <?php } } ?>
                        </select>
                    <?php echo form_close(); ?>
                </div>

                 <?php if(in_array('color', $var_types)){ ?>
                    <div class="product-color mb-3">
                        <div class="var_color_box">
                            <span><?php echo display('color') ?> : </span>
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

                    </div>
                <?php  }  ?>


                <?php } ?>
            <?php if(!($is_affiliate == 1)){ ?>
                <div class="cart_counter">
                    <label><?php echo display('quantity') ?> : </label>
                    <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 1 ) result.value--;return false;"
                            class="reduced items-count" type="button">
                        <i class="fa fa-angle-down"></i>
                    </button>
                    <input type="text" name="qty" id="sst" maxlength="12" value="1"
                           title="<?php echo display('quantity') ?>" class="input-text qty" min="1">
                    <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                            class="increase items-count" type="button">
                        <i class="fa fa-angle-up"></i>
                    </button>
                </div>
            <?php } ?>


            <input type="hidden" id="product_id" name="product_id" value="<?php echo html_escape($product_id) ?>">
            
            <div class="detail-action">
                <?php
                    if ($stok > 0) {
                ?>
                <a href="javascript:void(0)" id="cart_btn" class="cart_btn color3" onclick="cart_btn(<?php echo html_escape($product_id) ?>)">
                    <i class="fa fa-shopping-cart"></i><?php echo display('add_to_cart') ?>
                </a>
                <?php }if($is_affiliate == 1){ ?>
                <a href="<?php echo html_escape($affiliate_url) ?>" class="cart_btn color3" target="0">
                    <i class="fa fa-shopping-cart"></i><?php echo display('buy_now') ?>
                </a>  
                <?php } ?>
                <a href="javascript:void(0)" id="compare_btn" title="<?php echo display('compare'); ?>" class="compare_btn"onclick="comparison_btn(<?php echo html_escape($product_id) ?>)">
                    <i class="fa fa-balance-scale"></i>
                </a>
            </div>
            <div class="product_share">
                <?php if(isset($web_settings[0]['social_share']) && !empty($web_settings[0]['social_share'])){ ?>
                <!-- AddToAny BEGIN -->
                <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                    <a class="a2a_button_facebook"></a>
                    <a class="a2a_button_whatsapp"></a>
                    <a class="a2a_button_twitter"></a>
                    <a class="a2a_button_linkedin"></a>
                    <a class="a2a_button_telegram"></a>
                    <a class="a2a_button_pinterest"></a>
                    <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
                </div>
                <script async src="https://static.addtoany.com/menu/page.js"></script>
                <?php  } ?>

            </div>
        </div>
    </div>
</div>
</div>
</section>
<!--======= End Product Details =======-->
<?php if (!empty($select_details_adds)) {
foreach ($select_details_adds as $ads):
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
<!--========== Product Review Area ==========-->
<section class="product_review_area">
<div class="container">
<div class="row m0 db product_review">
    <!-- Nav tabs -->
    <ul class="nav nav-pills" role="tablist">
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#reviews"
               role="tab"><?php echo display('review') ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link  active" data-toggle="tab" href="#description"
               role="tab"><?php echo display('description') ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tags" role="tab"><?php echo display('tag') ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#specifications"
               role="tab"><?php echo display('specification') ?></a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane" id="reviews" role="tabpanel">
            <div class="review_form row">
                <?php if ($review) { ?>
                    <div class="col-md-6">
                        <div class="row m0 db need_review">
                            <?php if ($review) {
                                echo htmlspecialchars_decode($review);
                            } ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="col-md-6">
                    <div class="review_message">
                        <h3><?php echo display('review_this_product') ?></h3>
                        <div class="star_part">
                            <input type="hidden" name="input-1" id="input-1" value="2">
                        <span>    
                            <a class="review_star star-1" href="javascript:void(0)" name="1">
                                <i class="fa fa-star"></i>
                            </a>
                            <a class="review_star star-2 active" href="javascript:void(0)" name="2">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </a>
                            <a class="review_star star-3" href="javascript:void(0)" name="3">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </a>
                            <a class="review_star star-4" href="javascript:void(0)" name="4">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </a>
                            <a class="review_star star-5" href="javascript:void(0)" name="5">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </a>
                        </span>
                        </div>
                        <div class="row msg_part">
                            <div class="col-md-12">
                            <textarea class="form-control" placeholder="Your Message"
                                      id="review_msg"></textarea>
                            </div>
                            <div class="col-md-12">
                                <a href="javascript:void(0)"
                                   class="review"><?php echo display('submit') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane active" id="description" role="tabpanel">
            <div class="row">
                <?php if ($description) {
                    echo htmlspecialchars_decode($description);
                } ?>
            </div>
        </div>
        <div class="tab-pane" id="tags" role="tabpanel">
            <?php
            if ($tag) {
                $exploded = explode(',', $tag);
                foreach ($exploded as $elem) {
                    ?>
                    <a href="javascript:void(0);" class="nav"><?php echo htmlspecialchars_decode($elem) ?></a>
                    <?php
                }
            }
            ?>
        </div>
        <div class="tab-pane" id="specifications" role="tabpanel">
            <div class="row">
                <?php if ($specification) {
                    echo htmlspecialchars_decode($specification);
                } ?>
            </div>
        </div>
    </div>
</div>
</div>
</section>
<!--========= End Product Review Area =========-->

<?php if (!empty($select_details_adds)) {
foreach ($select_details_adds as $ads):
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
<!--========== Electronics Product Area ==========-->
<?php if ($related_product) { ?>
<section class="product_area wow fadeInUp">
<div class="container">
<div class="row db m0 product_inner">
    <div class="heading">
        <h2 class="bg_gray"><?php echo display('related_products') ?></h2>
    </div>
    <div class="owl-carousel product_slider slider_style">
        <?php
        
            foreach ($related_product as $product) {
                ?>
                <div class="item">
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
                                    <p class="current color5">
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
                                    <p class="current color5">
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
                                    <a href="<?php echo base_url() . $product->image_thumb ?>"
                                       data-lightbox="image-1"><i
                                                class="fa fa-search"></i></a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('product_details/' . remove_space($product->product_name) . '/' . $product->product_id) ?>"
                                       title="Product Details"><i class="fa fa-arrows"></i></a>
                                </li>
                            </ul>
                            <div class="addtocard">
                                <?php echo form_open('')?>
                                    <input type="hidden" name=""
                                           id="product_id_<?php echo html_escape($product->product_id) ?>"
                                           class="product_id"
                                           value="<?php echo html_escape($product->product_id) ?>">

                                    <?php if ($product->onsale == 1 && !empty($product->onsale_price)) { ?>
                                        <input type="hidden" name="price"
                                               id="price_<?php echo html_escape($product->product_id) ?>"
                                               value="<?php echo html_escape($product->onsale_price) ?>">
                                        <input type="hidden" name="discount"
                                               id="discount_<?php echo html_escape($product->product_id) ?>"
                                               value="<?php echo html_escape($product->price - $product->onsale_price) ?>">
                                    <?php } else { ?>
                                        <input type="hidden" name="price"
                                               id="price_<?php echo html_escape($product->product_id) ?>"
                                               value="<?php echo html_escape($product->price) ?>">
                                    <?php } ?>

                                    <input type="hidden" name="qnty"
                                           id="qnty_<?php echo html_escape($product->product_id) ?>" value="1">
                                    <input type="hidden" name="image"
                                           id="image_<?php echo html_escape($product->product_id) ?>"
                                           value="<?php echo html_escape($product->image_thumb) ?>">
                                    <input type="hidden" name="name"
                                           id="name_<?php echo html_escape($product->product_id) ?>"
                                           value="<?php echo html_escape($product->product_name) ?>">
                                    <input type="hidden" name="model"
                                           id="model_<?php echo html_escape($product->product_id) ?>"
                                           value="<?php echo html_escape($product->product_model) ?>">
                                    <input type="hidden" name="supplier_price"
                                           id="supplier_price_<?php echo html_escape($product->product_id) ?>"
                                           value="<?php echo html_escape($product->supplier_price) ?>">


                                    <?php
                                    $this->db->select('*');
                                    $this->db->from('tax_product_service');
                                    $this->db->where('product_id', $product->product_id);
                                    $this->db->where('tax_id', 'H5MQN4NXJBSDX4L');
                                    $tax_info = $this->db->get()->row();

                                    if (!empty($tax_info)) {
                                        ?>

                                        <?php if ($product->onsale == 1 && !empty($product->onsale_price)) {
                                            $cgst = ($tax_info->tax_percentage * $product->onsale_price) / 100;
                                            ?>
                                            <input type="hidden" name="cgst"
                                                   id="cgst_<?php echo html_escape($product->product_id) ?>"
                                                   value="<?php echo html_escape($cgst) ?>">
                                            <input type="hidden" name="cgst_id"
                                                   id="cgst_id_<?php echo html_escape($product->product_id) ?>"
                                                   value="<?php echo html_escape($tax_info->tax_id) ?>">
                                        <?php } else {
                                            $cgst = ($tax_info->tax_percentage * $product->price) / 100;
                                            ?>
                                            <input type="hidden" name="cgst"
                                                   id="cgst_<?php echo html_escape($product->product_id) ?>"
                                                   value="<?php echo html_escape($cgst) ?>">
                                            <input type="hidden" name="cgst_id"
                                                   id="cgst_id_<?php echo html_escape($product->product_id) ?>"
                                                   value="<?php echo html_escape($tax_info->tax_id) ?>">
                                        <?php } ?>

                                    <?php } ?>

                                    <?php
                                    $this->db->select('*');
                                    $this->db->from('tax_product_service');
                                    $this->db->where('product_id', $product->product_id);
                                    $this->db->where('tax_id', '52C2SKCKGQY6Q9J');
                                    $tax_info = $this->db->get()->row();

                                    if (!empty($tax_info)) {
                                        ?>

                                        <?php if ($product->onsale == 1 && !empty($product->onsale_price)) {
                                            $sgst = ($tax_info->tax_percentage * $product->onsale_price) / 100;
                                            ?>
                                            <input type="hidden" name="sgst"
                                                   id="sgst_<?php echo html_escape($product->product_id) ?>" class=""
                                                   value="<?php echo html_escape($sgst) ?>">
                                            <input type="hidden" name="sgst_id"
                                                   id="sgst_id_<?php echo html_escape($product->product_id) ?>"
                                                   value="<?php echo html_escape($tax_info->tax_id) ?>">
                                        <?php } else {
                                            $sgst = ($tax_info->tax_percentage * $product->price) / 100;
                                            ?>
                                            <input type="hidden" name="sgst"
                                                   id="sgst_<?php echo html_escape($product->product_id) ?>" class=""
                                                   value="<?php echo html_escape($sgst) ?>">
                                            <input type="hidden" name="sgst_id"
                                                   id="sgst_id_<?php echo html_escape($product->product_id) ?>"
                                                   value="<?php echo html_escape($tax_info->tax_id) ?>">
                                        <?php } ?>

                                    <?php } ?>

                                    <?php
                                    $this->db->select('*');
                                    $this->db->from('tax_product_service');
                                    $this->db->where('product_id', $product->product_id);
                                    $this->db->where('tax_id', '5SN9PRWPN131T4V');
                                    $tax_info = $this->db->get()->row();

                                    if (!empty($tax_info)) {
                                        ?>

                                        <?php if ($product->onsale == 1 && !empty($product->onsale_price)) {
                                            $igst = ($tax_info->tax_percentage * $product->onsale_price) / 100;
                                            ?>
                                            <input type="hidden" name="igst"
                                                   id="igst_<?php echo html_escape($product->product_id) ?>" class=""
                                                   value="<?php echo html_escape($igst) ?>">
                                            <input type="hidden" name="igst_id"
                                                   id="igst_id_<?php echo html_escape($product->product_id) ?>"
                                                   value="<?php echo html_escape($tax_info->tax_id) ?>">
                                        <?php } else {
                                            $igst = ($tax_info->tax_percentage * $product->price) / 100;
                                            ?>
                                            <input type="hidden" name="igst"
                                                   id="igst_<?php echo html_escape($product->product_id) ?>" class=""
                                                   value="<?php echo html_escape($igst) ?>">
                                            <input type="hidden" name="igst_id"
                                                   id="igst_id_<?php echo html_escape($product->product_id) ?>"
                                                   value="<?php echo html_escape($tax_info->tax_id) ?>">
                                        <?php } ?>

                                    <?php } ?>
                                    <!-- Tax collection information end-->
                                    
                                    <a href="javascript:void(0)" onclick="add_to_cart_item('<?php echo $product->product_id; ?>', '<?php echo remove_space($product->product_name); ?>', '<?php echo $product->default_variant; ?>', <?php echo $product->variant_price; ?>);">
                                        <button type="button" class="cart_button color2"><?php echo display('add_to_cart')
                                            ?></button>
                                    </a>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        
        ?>
    </div>
</div>
</div>
</section>
<?php } ?>
<!-- ========== End Electronics Product Area ========== -->
<?php if (!empty($select_details_adds)) {
foreach ($select_details_adds as $ads):
if (4 == $ads->adv_position && !empty($ads->adv_code) && empty($ads->adv_code2) && empty($ads->adv_code3)) {
?>
<section class="overview_area wow fadeInUp">
    <div class="container">
        <div class="row overview_inner">
            <div class="col-sm-12">
                <?php echo $ads->adv_code; ?>
            </div>
        </div>
</section>
<?php } else if (4 == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && empty($ads->adv_code3)) { ?>
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
<?php } else if (4 == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && !empty($ads->adv_code3)) { ?>
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
<input type="hidden" id="color_variant_id" value="<?php echo @$default_color; ?>">