<?php include_once(dirname(__FILE__).'/functions/functions.php'); ?>
<?php
$CI =& get_instance();
$CI->load->model('dashboard/Themes');
$theme = $CI->Themes->get_theme();
?>
<div class="container">
    <!--Breadcrumb-->
    <nav aria-label="breadcrumb" class="my-2">
        <ol class="breadcrumb d-inline-flex mb-0">
            <li class="breadcrumb-item align-items-center"><a href="<?php echo base_url() ?>" class="d-flex align-items-center"><i data-feather="home" class="mr-2"></i><?php echo display('home') ?></a></li>
            <li class="breadcrumb-item align-items-center"><a href="<?php echo base_url('category/p/' . remove_space($category_name) . '/' . $category_id) ?>" class="d-flex align-items-center"><?php echo html_escape($category_name); ?></a></li>
            <li class="breadcrumb-item align-items-center active" aria-current="page"><?php echo html_escape($product_name); ?></li>
        </ol>
    </nav>
</div>
<?php $this->load->view('adv/details_adv1', array('adv_position' => 1)); ?>

<div class="product-details-inner mb-5">
    <div class="container">
        <div class="product-header row no-gutters align-items-center border-bottom pb-2 mb-5">
            <div class="col-md-8">
                <h1 class="product-title fs-23 font-weight-400 mb-3"><?php echo html_escape($product_name) ?></h1>
                <ul class="entry-meta d-flex flex-wrap align-items-center font-weight-500 list-unstyled m-0">
                    <li class="meta-brand position-relative px-2 px-md-3"> <?php echo display('brand') ?>: <a href="<?php echo base_url('brand_product/list/' . $brand_id) ?>" class="meta-value"><?php echo html_escape($brand_name) ?></a></li>
                    <li class="position-relative px-2 px-md-3">
                        <div class="product-rating d-flex align-items-center">
                            
                            <div class="star-rating mb-0 mr-1">
                                <?php
                                 $result = $this->db->select('IFNULL(SUM(rate),0) as t_rates, count(rate) as t_reviewer')
                                     ->from('product_review')
                                    ->where('product_id', $product_id)
                                    ->where('status', 1)
                                    ->get()
                                    ->row();
                                    $p_review = (!empty($result->t_reviewer)?$result->t_rates / $result->t_reviewer:0);
                                    for($s=1; $s<=5; $s++){

                                        if($s <= floor($p_review)) {
                                            echo '<i class="fas fa-star"></i>';
                                        } else if($s == ceil($p_review)) {
                                            echo '<i class="fas fa-star-half-alt"></i>';
                                        }else{
                                            echo '<i class="far fa-star"></i>';
                                        }
                                    }
                                ?>
                            </div>
                            <a href="#" class="review-link text-muted font-weight-400 fs-14">
                                (<span class="count"><?php echo (!empty($result->t_reviewer)?$result->t_reviewer:0); ?></span> <?php echo display('review'); ?>)
                            </a>
                        </div>
                    </li>
                    <li class="meta-sku position-relative px-2 px-md-3"> <?php echo display('model') ?>: <span class="meta-value"><?php echo html_escape($product_model); ?></span></li>
                </ul>
            </div>
            <div class="col-md-4 mt-4 mt-md-0">
                <div class="text-md-right d-flex justify-content-md-end">
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
                <!-- /.End of social link -->
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="wrapper">
                    <!-- Product Images & Alternates -->
                    <div class="product-images">
                        <div class="row">
                            <div class="col-3 col-sm-2">
                                <!-- Begin product thumb nav -->
                                <ul class="thumb-nav">
                                    <li><img src="<?php echo base_url() . $image_thumb; ?>" alt="<?php echo display('image') ?>"></li>
                                    <?php
                                        if (!empty($product_gallery_img)) {
                                            foreach ($product_gallery_img as $gallery) {
                                                ?>
                                                <li><img src="<?php echo base_url() . $gallery->image_url ?>" alt="<?php echo display('image') ?>"></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                </ul>
                                <!-- End product thumb nav -->
                            </div>
                            <div class="col-9 col-sm-10">
                                <!-- Begin Product Images Slider -->
                                <div class="main-img-slider">
                                    <figure>
                                        <a href="<?php echo base_url() . $image_large_details; ?>" data-size="1400x1400">
                                            <img class="" src="<?php echo base_url() . $image_large_details; ?>" data-lazy="<?php echo base_url() . $image_large_details; ?>" data-zoom-image="<?php echo base_url() . $image_large_details; ?>"  alt="<?php echo display('image') ?>" />
                                        </a>
                                    </figure>
                                    <?php
                                    if ($product_gallery_img) {
                                        foreach ($product_gallery_img as $gallery_tab_img) {
                                            ?>
                                    <figure>
                                        <a href="<?php echo base_url() . $gallery_tab_img->image_url ?>" data-size="1400x1400">
                                            <img class="" src="<?php echo base_url() . $gallery_tab_img->image_url ?>" data-lazy="<?php echo base_url() . $gallery_tab_img->image_url ?>" data-zoom-image="<?php echo base_url() . $gallery_tab_img->image_url ?>"  alt="<?php echo display('image') ?>" />
                                        </a>
                                    </figure>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                                <!-- End Product Images Slider -->
                                <?php if ($video) { ?>
                                <div class="product-video-btn mx-3 my-3">
                                    <a class="popup-youtube d-flex align-items-center justify-content-center" href="<?php echo html_escape($video); ?>">
                                        <div class="product-video-icon bg-primary text-white d-flex align-items-center justify-content-center rounded-pill mr-2"> <i data-feather="video"></i></div>
                                        <span class="text-dark font-weight-500"><?php echo display('watch_video'); ?></span></a>
                                </div>
                                <!-- /.End of product video button -->
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!-- End Product Images & Alternates -->
                    <!-- Begin Product Image Zoom -->
                    <!-- This should live at bottom of page before closing body tag So that it renders on top of all page elements. -->
                    <!-- Root element of PhotoSwipe. Must have class pswp. -->
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
                                    <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                                    <button class="pswp__button pswp__button--share" title="Share"></button>
                                    <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                                    <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
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
                                <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
                                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>

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
            <div class="col-md-6">
                <div class="product-summary-content pl-md-4">
                    <div class="product-price-summary">
                        <?php if ($onsale) { ?>

                        <ins class="fs-29 d-inline-block">
                            <span class="amount var_amount">
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
                            <input type="hidden" id="price" name="price" value="<?php echo html_escape($onsale_price) ?>">
                        </ins>
                        <del class="Price-discount fs-14 text-black-50 font-weight-600 pl-1 price_discount">
                            <span class="amount regular_price">
                                <?php echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1); ?>
                            </span>
                        </del>
                        <?php $save_amount =  ($price - $onsale_price);
                        if($save_amount > 0){
                         ?>
                        <span class="sale fs-14 font-weight-500 ml-1 price_discount">(-<span class="save_perct"><?php echo ceil((($save_amount/$price)*100)) ?></span>%)</span>
                        <?php } ?>

                    <?php } else { ?>
                        <ins class="fs-29 d-inline-block">
                            <span class="amount var_amount">
                                
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
                    </ins>
                    <?php }  ?>
                    </div>
                    <ul class="summary-header d-flex flex-wrap align-items-center list-unstyled  border-bottom font-weight-600 pb-2">
                        <li class="position-relative px-2 px-md-3">
                            <?php if(!($is_affiliate == 1)){ ?>
                            <div class="stock">
                                <label class="text-dark pr-1 font-weight-500 mb-0"><?php echo display('status') ?>:</label>
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
                            </div>
                            <?php } ?>
                        </li>
                    </ul>
                    <div class="short-description">
                        <p><?php echo character_limiter(strip_tags($product_details), 200); ?></p>

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
                         <?php if(in_array('color', $var_types)){ ?>
                        <div class="product-color mb-3">
                            <h5 class="fs-16 font-weight-500 mb-2"><?php echo display('color') ?>:</h5>
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

                        <div class="product-size mb-3">
                            <h5 class="fs-16 font-weight-500 mb-2"><?php echo display('product_size') ?>:</h5>
                            <?php

                                foreach ($vresult as $vitem) {
                                    if($vitem->variant_type=='size'){
                                    ?>

                                    <input class="d-none product_variants" type="radio" name="select_size1" id="<?php echo html_escape($vitem->variant_id) ?>" value="<?php echo html_escape($vitem->variant_id) ?>" onclick="select_variant(<?php echo html_escape($product_id) ?>,'<?php echo  html_escape($vitem->variant_id) ?>')"  <?php echo (($vitem->variant_id == $default_variant)?'checked="checked"':'') ?>>
                                    <label class="mr-1" for="<?php echo html_escape($vitem->variant_id) ?>"><span class="size d-block bg-transparent border text-uppercase font-weight-500 fs-13 text-muted rounded"><?php echo html_escape($vitem->variant_name) ?></span></label>

                                    <?php
                                } }
                            
                            ?>
                        </div>
                        <!--  /.End of product Size -->
                    </div>
                    <?php echo form_open('#', array('class' => 'cart-row d-flex align-items-center')); ?>
                        <?php if(!($is_affiliate == 1)){ ?>
                        <div class="num-block skin-2">
                            <div class="num-in d-flex bg-white border mr-2">
                                <span class="minus position-relative dis reduced"></span>
                                <input type="text" name="qty" id="sst" class="in-num text-center border-0 qty" value="1" readonly="">
                                <span class="plus position-relative increase"></span>
                            </div>
                        </div>
                        <?php } ?>


                        <?php if ($stok > 0) { ?>
                        <a href="javascript:void(0)" class="btn btn-primary cart-btn text-uppercase fs-12 font-weight-500 mr-2 cart-btn color4 color46" onclick="cart_btn(<?php echo html_escape($product_id) ?>)"><?php echo display('add_to_cart') ?></a>
                        <?php }if($is_affiliate == 1){ ?>
                            <a href="<?php echo html_escape($affiliate_url) ?>" class="btn btn-primary text-uppercase fs-12 font-weight-500 mr-2 color4 color46" target = "0"><?php echo display('buy_now')?></a>
                        <?php } ?>
                        <a href="javascript:void(0)" class="add-wishlist wishlist d-flex align-items-center justify-content-center" data-toggle="tooltip" data-placement="top" 
                            title="<?php echo display('wishlist') ?>" name="<?php echo html_escape($product_id) ?>">
                            <i data-feather="heart"></i>
                        </a>
                        <a href="javascript:void(0)" class="add-wishlist d-flex align-items-center justify-content-center" data-toggle="tooltip" data-placement="top"
                           onclick="comparison_btn(<?php echo html_escape($product_id) ?>)"
                           title="<?php echo display('compare') ?>" >
                           <i data-feather="repeat"></i>
                        </a>
                    <?php echo form_close(); ?>
                    <div class="product-meta pt-2 border-top mt-2">
                        <div class="posted-in mb-1">
                            <strong class="font-weight-500 mr-1"><?php echo display('category') ?>: </strong>
                            <a href="<?php echo base_url() . 'category/p/' . remove_space($category_name) . '/' . $category_id; ?>"><?php echo html_escape($category_name); ?></a>
                        </div>
                        <?php if (!empty($tag)) { ?>
                        <div class="tag-as">
                            <strong class="font-weight-500 mr-1"><?php echo display('tag') ?>: </strong>
                            <?php 
                            rtrim($tag, ',');
                            $tags = explode(',', $tag);
                            $i=1;
                            foreach ($tags as $tagval) {
                                echo (($i > 1)?',':''); $i++ ?>
                                <a href="javascript:void(0)"  class="text-black-50"><?php echo html_escape($tagval); ?></a> 
                            <?php } ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Advertisement 2 -->
<?php $this->load->view('adv/details_adv1', array('adv_position' => 2)); ?>

<div class="container">
    <ul class="nav nav-tabs justify-content-center mb-4 border-bottom" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="true"><?php echo display('reviews') ?></a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="specification-tab" data-toggle="tab" href="#specification" role="tab" aria-controls="specification" aria-selected="false"><?php echo display('specification') ?></a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="false"><?php echo display('description') ?></a>
        </li>
    </ul>
    <div class="tab-content border p-4 rounded" id="myTabContent">
        <div class="tab-pane fade show active" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">

            <div class="rating-block-wrapper">
                <h3 class="title fs-21 mb-4"><?php echo display('rating_and_reviews') ?></h3>
                <div class="row align-items-center">
                    <div class="col-sm-3">
                        <div class="rating-block text-center">
                            <h4 class="mb-4 fs-21"><?php echo display('average_user_rating') ?></h4>
                            <div class="rating-point position-relative ml-auto mr-auto">
                                <i data-feather="star"></i>
                                <h3 class="position-absolute mb-0 fs-18 text-primary"><?php
                                    if (!empty($p_review)) {
                                        echo number_format($p_review, 1, ".", ".");
                                    } else {
                                        echo "0";
                                    }
                                    ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="rating-position">
                            <h4 class="mb-4 fs-21"><?php echo display('rating_breakdown') ?></h4>
                            <div class="rating-dimension d-flex mb-2">
                                <div class="rating-quantity d-flex align-items-center mr-2">
                                    <?php echo display('5') ?> 
                                    <div class="star-rating ml-1 mb-0">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                                <div class="rating-percent w-100 mr-2">
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="user-rating">
                                    <?php
                                    echo $this->Products_model->get_total_five_start_rating($product_id, 5);
                                    ?>
                                </div>
                            </div><!-- /.End of rating dimension -->
                            <div class="rating-dimension d-flex mb-2">
                                <div class="rating-quantity d-flex align-items-center mr-2">
                                    <?php echo display('4') ?> 
                                    <div class="star-rating ml-1 mb-0">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                </div>
                                <div class="rating-percent w-100 mr-2">
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="user-rating">
                                <?php echo $this->Products_model->get_total_five_start_rating($product_id, 4);
                                    ?></div>
                            </div><!-- /.End of rating dimension -->
                            <div class="rating-dimension d-flex mb-2">
                                <div class="rating-quantity d-flex align-items-center mr-2">
                                    <?php echo display('3') ?> 
                                    <div class="star-rating ml-1 mb-0">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                </div>
                                <div class="rating-percent w-100 mr-2">
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="user-rating"><?php echo $this->Products_model->get_total_five_start_rating($product_id,3);
                                    ?></div>
                            </div><!-- /.End of rating dimension -->
                            <div class="rating-dimension d-flex mb-2">
                                <div class="rating-quantity d-flex align-items-center mr-2">
                                    <?php echo display('2') ?> 
                                    <div class="star-rating ml-1 mb-0">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                </div>
                                <div class="rating-percent w-100 mr-2">
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="user-rating"><?php echo $this->Products_model->get_total_five_start_rating($product_id, 2);
                                    ?></div>
                            </div><!-- /.End of rating dimension -->
                            <div class="rating-dimension d-flex">
                                <div class="rating-quantity d-flex align-items-center mr-2">
                                    <?php echo display('1') ?> 
                                    <div class="star-rating ml-1 mb-0">
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                </div>
                                <div class="rating-percent w-100 mr-2">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: 20%">
                                            <span class="sr-only">20% Complete (primary)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="user-rating"><?php echo $this->Products_model->get_total_five_start_rating($product_id, 1);
                                    ?></div>
                            </div><!-- /.End of rating dimension -->
                        </div>
                    </div>          
                </div>  
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-sm-7 content">
                    <div class="review-block-wrapper mb-5">
                        <?php
                        if ($review_list) {
                            foreach ($review_list as $review) :
                            $customer_id = $review->reviewer_id;
                        ?>
                        <div class="review-block py-4 border-bottom">
                            <div class="review-block-rate fs-14 mb-3 d-inline-block mr-2">
                                <button type="button" class="btn <?php
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
                                ?>  d-flex align-items-center py-0 px-2 fs-14">
                                    <?php echo html_escape($review->rate); ?> <i class="fas fa-star fs-12 ml-1"></i>
                                </button>
                            </div>
                            <h5 class="review-block-title fs-17 font-weight-500 d-inline-block"><?php
                                $get_customer_name = $this->Products_model->get_customer_name($customer_id);
                                if ($get_customer_name) {
                                    echo html_escape($get_customer_name->customer_name);
                                }
                                ?> <i class="fa fa-check-circle" aria-hidden="true"></i>
                                    <span class="review-block-date text-black-50 fs-12 ml-2"><?php echo date('d M Y', strtotime($review->date_time));
                                        ?></span></h5>
                            <p class="review-block-description"><?php echo html_escape($review->comments); ?>
                            </p>
                        </div>
                        <?php
                            endforeach;
                        }
                        ?>
                    </div>
                </div>
                <div class="col-sm-5 pl-lg-5 rightSidebar">
                    <div class="review-content mb-5">   
                    <?php echo form_open('', array('class' => 'review-form')); ?>                                  
                        <div class="review-product-info">
                            <h4 class="review-product-name"><?php echo html_escape($product_name) ?></h4>
                            <div class="review-product-brand text-primary"><?php echo html_escape($category_name) ?></div>
                        </div>
                        <div class="rating-content d-flex align-items-center">
                            <label for="score" class="control-label mb-0 font-weight-500"><?php echo display('rate_it') ?>: *</label>
                            <div id="rating" class="ml-2"></div>
                        </div>
                            <div class="form-group">
                                <label class="font-weight-500"><?php echo display('review') ?> *</label>
                                <textarea class="form-control" placeholder="<?php echo display('review') ?>" name="review_msg" 
                                  id="review_msg" rows="5"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary submit_review  color4 color46"><?php echo display('send_your_review') ?></button>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="specification" role="tabpanel" aria-labelledby="specification-tab">
            <div class="specs-details">
                <?php if (!empty($specification)) {
                    echo htmlspecialchars_decode($specification);
                } ?>
            </div>
        </div>
        <div class="tab-pane fade" id="description" role="tabpanel" aria-labelledby="description-tab">
             <?php if (!empty($description)) {
                    echo htmlspecialchars_decode($description);
                } ?>
        </div>
    </div>
</div>

<!-- Advertisement 3 -->
<?php $this->load->view('adv/details_adv1', array('adv_position' => 3)); ?>


<!--Related product-->
<?php if (!empty($best_sales_category)) { ?>
<div class="container py-5">
    <h3 class="mb-4 fs-21"><?php echo display('you_may_alo_be_interested_in')
    ?></h3>
    <div class="row">
        <?php 
        $bpro=1;
        foreach ($best_sales_category as $product) {
        if($bpro <= 12){
         ?>
        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
            <div class="deals-item-inner bg-white overflow-hidden border mb-3">
                <a href="<?php echo base_url('product/' . remove_space($product->product_name) . '/' . $product->product_id) ?>">
                    <div class="item-image">
                        <img src="<?php echo base_url() . $product->image_thumb ?>" class="img-fluid" alt="">
                    </div>
                    <div class="item-details position-relative">
                        <h3 class="item-details-title overflow-hidden font-weight-400 mt-2 mb-0 fs-13"><?php echo html_escape($product->product_name) ?></h3>

                        <div class="star-rating">
                            <?php
                             $result = $this->db->select('IFNULL(SUM(rate),0) as t_rates, count(rate) as t_reviewer')
                             ->from('product_review')
                            ->where('product_id', $product->product_id)
                            ->where('status', 1)
                            ->get()
                            ->row();
                            $p_review = (!empty($result->t_reviewer)?$result->t_rates / $result->t_reviewer:0);
                            for($s=1; $s<=5; $s++){

                                if($s <= floor($p_review)) {
                                    echo '<i class="fas fa-star"></i>';
                                } else if($s == ceil($p_review)) {
                                    echo '<i class="fas fa-star-half-alt"></i>';
                                }else{
                                    echo '<i class="far fa-star"></i>';
                                }
                            }
                        ?>
                        </div>
                        <div class="product-price font-weight-bolder font-italic">
                            <?php

                            if ($product->onsale == 1 && !empty($product->onsale_price)) {
                                $price_val = $product->onsale_price * $target_con_rate;
                            }else{
                                $price_val = $product->price * $target_con_rate;
                            }

                            echo  (($position1 == 0) ? $currency1 . number_format($price_val, 2, '.', ',') : number_format($price_val, 2, '.', ',') . $currency1); ?> / <?php echo display('unit') ?>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <?php } else { break; }  ?>
        <?php $bpro++; } ?>
    </div>
</div>
<?php } ?>

<!-- Advertisement 4 -->
<?php $this->load->view('adv/details_adv1', array('adv_position' => 4)); ?>

<input type="hidden" id="product_id" value="<?php echo $product_id; ?>">
<input type="hidden" id="variant_id" value="<?php echo $default_variant; ?>">
<input type="hidden" id="color_variant_id" value="<?php echo @$default_color; ?>">
<input type="hidden" id="theme_url" value="<?php echo THEME_URL.$theme; ?>">