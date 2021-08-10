<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php 
    $is_aff = false;
    if(check_module_status('affiliate_products') == 1){
        $is_aff = true;
    }
?>
<?php 
$CI =& get_instance();
$theme = $CI->Themes->get_theme();
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
<div class="container">
<div class="content-row">
<div class="col col-1 hidden-xs hidden-sm pr-15">
<nav class="vertical-menu-content">
<h3 class="promotion-title color3 color36"><i
class="fa fa-list-ul"></i> <?php echo display('all_categories') ?></h3>
<ul class="list-group vertical-menu yamm make-absolute color36">
<?php
if ($category_list) {
$i = 1;
foreach ($category_list as $parent_category) {
$sub_parent_cat = $this->db->select('*')
->from('product_category')
->where('parent_category_id', $parent_category->category_id)
->order_by('menu_pos')
->get()
->result();
if (10 == $i) {
break;
}
?>

<li class="width-md menu-item menu-item-has-children animate-dropdown dropdown">
<a title="<?php echo html_escape($parent_category->category_name) ?>" data-hover="dropdown"
href="<?php
echo base_url('category/p/' . remove_space($parent_category->category_name) . '/' . $parent_category->category_id) ?>"
data-toggle="<?php if ($sub_parent_cat) {
   echo "dropdown";
} else {
   echo "";
} ?>" class="dropdown-toggle text-capitalize" aria-haspopup="true"><span
        class=""><img
            src="<?php echo base_url() . $parent_category->cat_favicon ?>"
            height="15"
            width="16"></span> <?php echo html_escape($parent_category->category_name) ?>
<div class="hover-fix"></div>
</a>
<?php
if ($sub_parent_cat) {
?>
<ul role="menu" class="dropdown-menu">
    <li class="menu-item animate-dropdown menu-item-object-static_block">
        <div class="yamm-content">
            <div class="row">
                <?php foreach ($sub_parent_cat as $parent_cat) { ?>
                    <div class="col-sm-6">
                        <div class="column-inner">
                            <ul class="nav-categories">
                                <li class="nav-title">
                                    <a href="<?php echo base_url('category/p/' . remove_space($parent_cat->category_name) . '/' . $parent_cat->category_id) ?>"><?php echo html_escape($parent_cat->category_name) ?></a>
                                </li>
                                <?php
                                $sub_cat = $this->db->select('*')
                                    ->from('product_category')
                                    ->where('parent_category_id', $parent_cat->category_id)
                                    ->order_by('menu_pos')
                                    ->get()
                                    ->result();
                                if ($sub_cat) {
                                    foreach ($sub_cat as $s_p_cat) {
                                        ?>
                                        <li>
                                            <a href="<?php echo base_url('category/p/' . remove_space($s_p_cat->category_name) . '/' . $s_p_cat->category_id) ?>"><?php echo html_escape($s_p_cat->category_name )?></a>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </li>
</ul>
<?php } ?>
</li>
<?php
$i++;
}
}
?>
<li class="width-md menu-item menu-item-has-children animate-dropdown dropdown">
<a title="<?php echo display('all_categories') ?>" data-hover="dropdown"
href="#"
data-toggle="<?php if ($category_list) {
echo "dropdown";
} else {
echo "";
} ?>" class="dropdown-toggle text-capitalize" aria-haspopup="true"><span
class=""><i class="fa fa-bars" aria-hidden="true"></i>
</span> <?php echo display('all_categories') ?>
<div class="hover-fix"></div>
</a>
<?php if ($category_list) { ?>
<ul role="menu" class="dropdown-menu">
<li class="menu-item animate-dropdown menu-item-object-static_block">
<div class="yamm-content">
    <div class="row">
        <?php foreach ($category_list as $parent_cat) { ?>
            <div class="col-sm-6">
                <div class="column-inner">
                    <ul class="nav-categories">
                        <li class="nav-title">
                            <a href="<?php echo base_url('category/p/' . remove_space($parent_cat->category_name) . '/' . $parent_cat->category_id) ?>"><?php echo html_escape($parent_cat->category_name) ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
</li>
</ul>
<?php } ?>
</ul>
</nav>
</div>
<div class="col col-2">
<div class="slider">
<?php
if ($slider_list) {
foreach ($slider_list as $slider) {

?>
<div class="item">
<a href="<?php echo html_escape($slider['slider_link']) ?>" target="_blank">
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
<!-- /.End of slider -->
</div>
<div class="col col-3 promotion-product-content hidden-xs hidden-md">
<h3 class="promotion-title color3 color36"><a href="#"><?php echo display('buy_now_promotion')
?></a></h3>
<div class="promotion-wrapper">
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
if ($promotion_product) {
foreach ($promotion_product as $product) {
?>
<div class="promotion-product">
<a class="media"
href="<?php echo base_url('product_details/' . remove_space($product->product_name) . '/' . $product->product_id) ?>">
<div class="media-left">
<?php if (@getimagesize($product->image_thumb) === false) { ?>
    <img src="<?php echo base_url() . '/my-assets/image/no-image.jpg' ?>"
         class="media-object"
         alt="image">
<?php } else { ?>

    <img src="<?php echo base_url() . $product->image_thumb ?>"
         class="media-object"
         alt="<?php echo html_escape($product->product_name) ?>">
<?php } ?>
</div>
<div class="media-body">
<h4 class="product-title"><?php echo html_escape($product->product_name) ?></h4>
<?php if ($product->onsale_price) { ?>
    <div class="offer color3">

        <?php 
        echo html_escape(($position1 == 0) ? $currency1 . " " . number_format($product->onsale_price, 2, '.', ',') : number_format($product->onsale_price, 2, '.', ',') . " " . $currency1); ?>
    </div>
<?php } ?>
</div>
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

<?php if (!empty($select_home_adds)) {
foreach ($select_home_adds as $ads):
if (1 == $ads->adv_position && !empty($ads->adv_code) && empty($ads->adv_code2) && empty($ads->adv_code3)) {
?>
<div class="banner-content">
<div class="container">
<div class="row">
<div class="col-xs-12">
<?php echo $ads->adv_code; ?>
</div>
</div>
</div>
</div>

<?php } else if (1 == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && empty($ads->adv_code3)) { ?>

<div class="banner-content">
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

<div class="banner-content">
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

<div class="container">
<div class="products-content">
<div class="products-content m_2e_0">
<div class="header-title">
<ul>
<li class="title-name color35">
<h1 class="ml9">
    <span class="text-wrapper">
        <span class="text-uppercase"><?php echo display('best_sale_product') ?>
            </span>
    </span>
</h1>
</li>
</ul>
</div>

<?php
if ($best_sales) { ?>
<div class="tab-pane product-tab-pane active" id="product-tab-1">
<div class="products-slide">
<?php foreach ($best_sales as $product) { ?>
<div class="product-box">
<div class="imagebox">
        <span class="product-cat"><a
                    href="<?php echo base_url('category/p/' . remove_space($product->category_name) . '/' .
                        $product->category_id) ?>"><?php echo html_escape($product->category_name) ?></a>
        </span>
<a href="<?php echo base_url('/product_details/' . remove_space($product->product_name) . '/' . $product->product_id) ?>">
    <h3 class="product-name"><?php echo html_escape($product->product_name) ?></h3>
    <div class="product-thumb">
        <?php if (@getimagesize($product->image_thumb) === false) { ?>
            <img src="<?php echo base_url() . '/my-assets/image/no-image.jpg' ?>"
                 class="media-object"
                 alt="image">
        <?php } else { ?>
            <img src="<?php echo base_url() ?>assets/website/image/loader.svg"
                 data-src="<?php echo base_url() . $product->image_thumb ?>"
                 alt="image">
        <?php } ?>
    </div>
</a>
<div>
    <b>
        <?php
        if ($product->brand_name != null) {
            echo html_escape($product->brand_name);
        } else {
            echo html_escape($product->product_name);
        }
        ?>
    </b>
</div>
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
            <ins>
                <span class="amount">
                    <?php
                    if ($target_con_rate > 1) {
                        $onsale_price = $product->onsale_price * $target_con_rate;
                        echo(($position1 == 0) ? $currency1 . " " . number_format
                            ($onsale_price, 2, '.', ',') : number_format
                            ($onsale_price,
                                2, '.', ',') . " " . $currency1);
                    }

                    if ($target_con_rate <= 1) {
                        $onsale_price = $product->onsale_price * $target_con_rate;
                        echo(($position1 == 0) ? $currency1 . " " . number_format($onsale_price, 2, '.', ',') : number_format($onsale_price, 2, '.', ',') . " " . $currency1);
                    }
                    ?>
                </span>
            </ins>
            <del>
                <span class="amount">
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
                </span>
            </del>
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
</div><!-- /.price-add-to-cart -->

<div class="box-bottom">

    <div class="btn-add-cart">
    <?php if($is_aff){ 
        if($product->is_affiliate == 1 ){ ?>
            <a href="<?php echo html_escape( $product->affiliate_url) ?>" target="0">
                <img src="<?php echo base_url() . 'application/modules/web/views/themes/' . $theme . '/assets/img/add-cart.png' ?>" alt="image"><?php echo display('buy_now') ?>
            </a>
    <?php }else{ ?> 
        <a  href="javascript:void(0)" onclick="add_to_cart_item('<?php echo $product->product_id; ?>', '<?php echo remove_space($product->product_name); ?>', '<?php echo $product->default_variant; ?>', <?php echo $product->variant_price; ?>);">
            <img src="<?php echo base_url() . 'application/modules/web/views/themes/' . $theme . '/assets/img/add-cart.png' ?>" alt="image"><?php echo display('add_to_cart') ?>
        </a>
    <?php } }else{ ?>
        <a  href="javascript:void(0)" onclick="add_to_cart_item('<?php echo $product->product_id; ?>', '<?php echo remove_space($product->product_name); ?>', '<?php echo $product->default_variant; ?>', <?php echo $product->variant_price; ?>);">
            <img src="<?php echo base_url() . 'application/modules/web/views/themes/' . $theme . '/assets/img/add-cart.png' ?>" alt="image"><?php echo display('add_to_cart') ?>
        </a>
    <?php }  ?>
     </div>
    <div class="compare-wishlist">
        <a href="javascript:void(0)"
               onclick="comparison_btn(<?php echo html_escape($product->product_id) ?>)"
               title="<?php echo display('compare') ?>" >
               <i class="lnr lnr-chart-bars"></i> <?php echo display('compare') ?>
        </a>
        <a href="javascript:void(0)" class="wishlist" title="" name="<?php echo html_escape($product->product_id) ?>">
            <img src="<?php echo base_url() . 'application/modules/web/views/themes/' . $theme . '/assets/img/wishlist.png' ?>" alt="image"><?php echo display('wishlist') ?>
        </a> 
    </div>
</div><!-- /.box-bottom -->
</div>
</div>
<!-- /.End of product box -->
<?php } ?>
</div>
<!-- /.End of products slide -->
</div>
<?php } ?>

</div>

<?php if (!empty($select_home_adds)) {
foreach ($select_home_adds as $ads):
if (2 == $ads->adv_position && !empty($ads->adv_code) && empty($ads->adv_code2) && empty($ads->adv_code3)) {
?>
<div class="banner-content">
<div class="col-xs-12 m_2e_0">
<?php echo $ads->adv_code; ?>
</div>
</div>

<?php } else if (2 == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && empty($ads->adv_code3)) { ?>

<div class="banner-content row">
<div class="col-xs-6">
<?php echo $ads->adv_code; ?>
</div>
<div class="col-xs-6">
<?php echo $ads->adv_code2; ?>
</div>
</div>

<?php } else if (2 == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && !empty($ads->adv_code3)) { ?>

<div class="banner-content row">
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
<?php } ?>
<?php
endforeach;
} ?>

<div class="products-content m_2e_0">
<div class="header-title">
<ul>
<li class="title-name color35">
<h1 class="ml9">
<span class="text-wrapper">
<span class="text-uppercase"><?php echo display('most_popular_product') ?></span>
</span>
</h1>
</li>
</ul>
</div>
<?php
if ($most_popular_product) { ?>
<div class="tab-pane product-tab-pane" id="product-tab-2">
<div class="products-slide">
<?php
foreach ($most_popular_product as $product) {
?>
<div class="product-box">
<div class="imagebox">
        <span class="product-cat"><a
                    href="<?php echo base_url('category/p/' . remove_space($product->category_name) . '/' .
                        $product->category_id) ?>"><?php echo html_escape($product->category_name) ?></a></span>
<a href="<?php echo base_url('product_details/' . remove_space($product->category_name) . '/' . $product->product_id) ?>">
    <h3 class="product-name"><?php echo html_escape($product->product_name) ?></h3>
    <div class="product-thumb">
        <?php if (@getimagesize($product->image_thumb) === false) { ?>
            <img src="<?php echo base_url() . '/my-assets/image/no-image.jpg' ?>"
                 class="media-object"
                 alt="image">
        <?php } else { ?>
            <img src="<?php echo base_url() . 'application/modules/web/views/themes/' . $theme . '/assets/img/loader.svg' ?>"
                 data-src="<?php echo base_url() . $product->image_thumb ?>"
                 alt="image">
        <?php } ?>
    </div>
</a>
<div>
    <b>
        <?php
        if ($product->brand_name) {
            echo html_escape($product->brand_name);
        } else {
            echo html_escape($product->product_name);
        }
        ?>
    </b>
</div>
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
</div><!-- /.price-add-to-cart -->
<div class="box-bottom">
    <div class="btn-add-cart">
        <?php if($is_aff){ 
            if($product->is_affiliate == 1 ){ ?>
                <a href="<?php echo html_escape( $product->affiliate_url) ?>" target="0">
                    <img src="<?php echo base_url() . 'application/modules/web/views/themes/' . $theme . '/assets/img/add-cart.png' ?>" alt="image"><?php echo display('buy_now') ?>
                </a>
        <?php }else{ ?> 
            <a  href="javascript:void(0)" onclick="add_to_cart_item('<?php echo $product->product_id; ?>', '<?php echo remove_space($product->product_name); ?>', '<?php echo $product->default_variant; ?>', <?php echo $product->variant_price; ?>);">
                <img src="<?php echo base_url() . 'application/modules/web/views/themes/' . $theme . '/assets/img/add-cart.png' ?>" alt="image"><?php echo display('add_to_cart') ?>
            </a>
        <?php } }else{ ?>
            <a  href="javascript:void(0)" onclick="add_to_cart_item('<?php echo $product->product_id; ?>', '<?php echo remove_space($product->product_name); ?>', '<?php echo $product->default_variant; ?>', <?php echo $product->variant_price; ?>);">
                <img src="<?php echo base_url() . 'application/modules/web/views/themes/' . $theme . '/assets/img/add-cart.png' ?>" alt="image"><?php echo display('add_to_cart') ?>
            </a>
        <?php }  ?>
    </div>
    <div class="compare-wishlist">
        <a href="javascript:void(0)"
               onclick="comparison_btn(<?php echo html_escape($product->product_id) ?>)"
               title="<?php echo display('compare') ?>" >
               <i class="lnr lnr-chart-bars"></i> <?php echo display('compare') ?>
        </a>
        <a href="javascript:void(0)" class="wishlist" title=""
           name="<?php echo html_escape($product->product_id) ?>">
            <img src="<?php echo base_url() . 'application/modules/web/views/themes/' . $theme . '/assets/img/wishlist.png' ?>"
                 alt="image"><?php echo display('wishlist') ?>
        </a>
    </div>
</div><!-- /.box-bottom -->
</div>
</div>
<!-- /.End of product box -->
<?php
}
?>
</div>
</div>
<?php }

?>


</div>


<?php
if ($block_list) {
foreach ($block_list as $block) :?>
<?php if (!empty($select_home_adds)) {
foreach ($select_home_adds as $ads):
if ($block['block_position'] + 2 == $ads->adv_position && !empty($ads->adv_code) && empty($ads->adv_code2) && empty($ads->adv_code3)) {
?>
<div class="banner-content">

<div class="row">
<div class="col-xs-12">
    <?php echo $ads->adv_code; ?>
</div>
</div>

</div>

<?php } else if ($block['block_position'] + 2 == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && empty($ads->adv_code3)) { ?>

<div class="banner-content">

<div class="row">
<div class="col-xs-6">
    <?php echo $ads->adv_code; ?>
</div>
<div class="col-xs-6">
    <?php echo $ads->adv_code2; ?>
</div>
</div>

</div>

<?php } else if ($block['block_position'] + 2 == $ads->adv_position && !empty($ads->adv_code) && !empty($ads->adv_code2) && !empty($ads->adv_code3)) { ?>

<div class="banner-content">

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
<?php
endforeach;
} ?>

<?php
if ($block['block_style'] == 1) {
$get_sub_category_list = $this->Homes->get_sub_category_list($block['block_cat_id']);
$category_list_by_id = $this->Homes->category_list_by_id($block['block_cat_id']);
if ($get_sub_category_list) { ?>
<div class="products-content">
<div class="header-title">
<ul>
<li class="title-name color35">
    <img class="cat-icon lnr"
         src="<?php echo base_url() . $category_list_by_id->cat_favicon; ?>"
         height="20"
         width="20" alt="category favicon">
    <h1 class="ml9">
    <span class="text-wrapper">
        <span class="-letters"><?php echo html_escape($category_list_by_id->category_name);
            ?></span>
    </span>
    </h1>
    <i class="fa fa-angle-right" aria-hidden="true"></i>
</li>
</ul>
</div>
<!-- /.End of header title -->
<div class="products-row">
<div class="category-col">
<div class="brand-slider -slider-ht">
    <?php
    $c_end = 6;
    $count = 0;
    $category_info = $this->db->select('brand_id')
        ->from('product_information')
        ->where('category_id', $block['block_cat_id'])
        ->distinct('brand_id')
        ->get()
        ->result_array();

    if (empty($category_info) || $category_info) {
        $get_sub_category_list_array = [];
        foreach ($get_sub_category_list as $v_get_sub_category_list) {
            $get_sub_category_list_array[] .= $v_get_sub_category_list['category_id'];
        }
        $sub_category_brand = $this->db->select('brand_id')
            ->from('product_information')
            ->where_in('category_id', $get_sub_category_list_array)
            ->distinct('brand_id')
            ->get()
            ->result_array();
        $category_info = array_unique(array_merge($category_info, $sub_category_brand), SORT_REGULAR);
        $category_info = array_filter(array_column($category_info, 'brand_id'));
    }

    $num = count($category_info) / 6;
    $of = 0;
    for ($i = 0; $i < ceil($num); $i++) {
        ?>
        <div class="brand-cat">
            <?php
            $category_info = $this->db->select('brand_id')
                ->from('product_information')
                ->where('category_id', $block['block_cat_id'])
                ->limit($c_end, $count)
                ->distinct('brand_id')
                ->get()
                ->result_array();
            if (empty($category_info) || $category_info) {
                $get_sub_category_list_array = [];
                foreach ($get_sub_category_list as $v_get_sub_category_list) {
                    $get_sub_category_list_array[] .= $v_get_sub_category_list['category_id'];
                }
                $sub_category_brand = $this->db->select('brand_id')
                    ->from('product_information')
                    ->where_in('category_id', $get_sub_category_list_array)
                    ->limit($c_end, $count)
                    ->distinct('brand_id')
                    ->get()
                    ->result_array();
                $category_info = array_unique(array_merge($category_info, $sub_category_brand), SORT_REGULAR);
                $category_info = array_filter(array_column($category_info, 'brand_id'));
            }


            foreach ($category_info as $category) :
                $brand = $this->db->select('*')
                    ->from('brand')
                    ->where('brand_id', $category)
                    ->get()
                    ->row();
                if ($brand) {
                    ?>
                    <a href="<?php echo base_url('brand_product/list/' . $brand->brand_id) ?>"
                       title="<?php echo html_escape($brand->brand_name) ?>">
                        <img src="<?php echo base_url() . $brand->brand_image ?>"
                             class="img-responsive center-block"
                             alt="<?php echo html_escape($brand->brand_name); ?>">
                    </a>
                    <?php
                }
                $of++;
            endforeach;
            ?>
        </div>
        <?php
        $count += 6;
    }
    ?>
</div>
<!-- /.End of brand slider -->
</div>
<div class="banner-col">
<a href="<?php echo base_url() . 'category/p/' . remove_space($category_list_by_id->category_name) . '/' . $category_list_by_id->category_id; ?>">
    <img src="<?php echo $category_list_by_id->cat_image; ?>"
         class="img-responsive" alt="category image">
</a>
</div>

<div class="home-category-col">
<ul class="products">
    <?php
    $i = 1;
    foreach ($get_sub_category_list as $subCategoryList):
        if ($i == 5) {
            break;
        }
        $i++;
        ?>
        <li class="col-xs-6 col-sm-6">
            <a href="<?php echo base_url('category/p/' . remove_space($subCategoryList['category_name']) . '/' . $subCategoryList['category_id']) ?>"
               class="product-cat-box">
                <div class="product-cat-content">
                    <img src="<?php echo base_url()
                        . 'application/modules/web/views/themes/' .
                        $theme . '/assets/img/cat-bg.png'; ?>"
                         class="img-responsive
                    center-block cat-bg-img" alt="image">
                    <img src="<?php echo base_url() . $subCategoryList['cat_image'] ?>"
                         class="img-responsive center-block cat-main-img"
                         alt="category image">
                    <h5 class="cat-title"><?php echo html_escape($subCategoryList['category_name']); ?></h5>
                </div>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
</div>
</div>
</div>

<?php
}
} elseif ($block['block_style'] == 2) {
$get_sub_category_list = $this->Homes->get_sub_category_list($block['block_cat_id']);
$category_list_by_id = $this->Homes->category_list_by_id($block['block_cat_id']);

if ($get_sub_category_list) { ?>
<div class="products-content">
<div class="header-title">
<ul>
<li class="title-name color35">
    <img class="cat-icon lnr"
         src="<?php echo base_url(). $category_list_by_id->cat_favicon; ?>"
         height="20"
         width="20">
    <h1 class="ml9">
    <span class="text-wrapper">
        <span class="-letters"><?php echo html_escape($category_list_by_id->category_name);
            ?></span>
    </span>
    </h1>
    <i class="fa fa-angle-right" aria-hidden="true"></i>
</li>


</ul>
</div>

<div class="products-row">
<div class="category-col">
<div class="brand-slider slider-ht">
    <?php
    $c_end = 6;
    $count = 0;
    $category_info = $this->db->select('brand_id')
        ->from('product_information')
        ->where('category_id', $block['block_cat_id'])
        ->distinct('brand_id')
        ->get()
        ->result_array();

    if (empty($category_info) || $category_info) {
        $get_sub_category_list_array = [];
        foreach ($get_sub_category_list as $v_get_sub_category_list) {
            $get_sub_category_list_array[] .= $v_get_sub_category_list['category_id'];
        }
        $sub_category_brand = $this->db->select('brand_id')
            ->from('product_information')
            ->where_in('category_id', $get_sub_category_list_array)
            ->distinct('brand_id')
            ->get()
            ->result_array();
        $category_info = array_unique(array_merge($category_info, $sub_category_brand), SORT_REGULAR);
        $category_info = array_filter(array_column($category_info, 'brand_id'));

    }
    $num = count($category_info) / 6;
    for ($i = 0; $i < ceil($num); $i++) {
        ?>
        <div class="brand-cat">
            <?php
            $category_info = $this->db->select('brand_id')
                ->from('product_information')
                ->where('category_id', $block['block_cat_id'])
                ->limit($c_end, $count)
                ->distinct('brand_id')
                ->get()
                ->result_array();
            if (empty($category_info) || $category_info) {
                $get_sub_category_list_array = [];
                foreach ($get_sub_category_list as $v_get_sub_category_list) {
                    $get_sub_category_list_array[] .= $v_get_sub_category_list['category_id'];
                }
                $sub_category_brand = $this->db->select('brand_id')
                    ->from('product_information')
                    ->where_in('category_id', $get_sub_category_list_array)
                    ->limit($c_end, $count)
                    ->distinct('brand_id')
                    ->get()
                    ->result_array();
                $category_info = array_unique(array_merge($category_info, $sub_category_brand), SORT_REGULAR);
                $category_info = array_filter(array_column($category_info, 'brand_id'));
            }
            $of = 1;
            foreach ($category_info as $category) {
                $brand = $this->db->select('*')
                    ->from('brand')
                    ->where('brand_id', $category)
                    ->get()
                    ->row();
                if ($brand) {
                    ?>
                    <a href="<?php echo base_url('brand_product/list/' . $brand->brand_id) ?>"
                       title="<?php echo html_escape($brand->brand_name) ?>"><img
                                src="<?php echo $brand->brand_image ?>"
                                class="img-responsive center-block"
                                alt="<?php echo html_escape($brand->brand_name) ?>"></a>
                    <?php
                }
                $of++;
            }
            ?>
        </div>
        <?php
        $count += 6;
    }
    ?>
</div>
</div>

<div class="product-col">
<ul class="products">
    <?php
    $i = 1;
    foreach ($get_sub_category_list as $subCategoryList):
        if ($i == 9) {
            break;
        }
        $i++;
        ?>
        <li class="col-xs-6 col-sm-3">
            <a href="<?php echo base_url('category/p/' . remove_space($subCategoryList['category_name']) . '/' . $subCategoryList['category_id']) ?>"
               class="product-cat-box">
                <div class="product-cat-content">
                    <img src="<?php echo base_url()
                        . 'application/modules/web/views/themes/' .
                        $theme . '/assets/img/cat-bg.png'; ?>"
                         class="img-responsive
                    center-block cat-bg-img" alt="image">
                    <img src="<?php echo
                        base_url() . $subCategoryList['cat_image'] ?>"
                         class="img-responsive center-block cat-main-img"
                         alt="category image">
                    <h5 class="cat-title"><?php echo html_escape($subCategoryList['category_name']);
                        ?></h5>
                </div>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
</div>
</div>
</div>
<?php
}
}
endforeach;
}
?>
</div>
</div><!-- container main content -->
<div class="brand-cat-content hidden-xs">
<div class="container">

<div class="row brand-cat-inner m-0">
<div class="brand-cat-left">
<img src="<?php echo base_url() . 'application/modules/web/views/themes/' . $theme
. '/assets/img/icon/001-product.png' ?>" alt="image">
<div><?php echo display('brand_of_the_week') ?></div>
</div>
<div class="brand-cat-right">
<div class="row m-0">
<?php
$brands = $this->Homes->get_this_week_brand();
if ($brands):
foreach ($brands as $brand):
?>
<div class="col-xs-4 col-sm-2 logo-item">
<a href="
<?php echo base_url('brand_product/list/' . $brand->brand_id) ?>"
target="_blank"><img class="img-responsive center-block"
                    src="<?php
                    echo html_escape($brand->brand_image) ?>" alt="image"></a>
</div>
<?php
endforeach;
endif;
?>
</div>
</div>
</div>

</div>
</div>
<!--  /.End of Products Brands -->
<div class="variable-slider">
<div class="container">
<div class="variable-width">
<?php foreach ($category_list as $category): ?>
<div class="variable-item">
<a href="<?php echo base_url() . 'category/p/' . remove_space($category->category_name) . '/' . $category->category_id; ?>"
class="cat-box">
<h5 class="cat-title"><?php echo html_escape($category->category_name); ?></h5>
<img src="<?php echo base_url() . $category->cat_image; ?>" class="img-responsive"
alt="image">
</a>
</div>
<?php endforeach; ?>
</div>
</div>
</div>

<div class="mobile-brand">
<div class="container">
<h3 class="title"><?php echo display('shop_of_the_week') ?></h3>
<div class="brand-slider2">
<?php
$brands = $this->Homes->get_this_week_brand();
if ($brands):
foreach ($brands as $brand):
?>

<div class="brand-item">
<a href="<?php echo base_url('brand_product/list/' . $brand->brand_id) ?>">
<img src="<?php
echo base_url() . $brand->brand_image ?>" class="img-responsive" alt="image"></a>
</div>
<?php
endforeach;
endif;
?>

</div>
</div>
</div>
<!-- /.End of mobile brand -->
<div class="featured">
<div class="container">
<div class="row">
<?php
$shop_of_the_weeks = $this->Homes->get_this_week_sell_product();
foreach ($shop_of_the_weeks as $shop_of_the_week):
?>
<div class="col-xs-6 pr">
<div class="featured-box">
<a class="media"
href="<?php echo base_url() . 'product_details/' . remove_space($shop_of_the_week->product_name) . '/'
. $shop_of_the_week->product_id; ?>">
<div class="media-body">
<span class="featured-title"><?php echo html_escape($shop_of_the_week->product_name); ?></span>

</div>
<div class="media-right">
<img src="<?php echo html_escape($shop_of_the_week->image_thumb); ?>" class="media-object"
 alt="image">
</div>
</a>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
</div>
<!-- /.End of featured -->
<?php if ($best_sales) {
?>

<div class="variable-slider">
<div class="container">
<h3 class="title"><?php echo display('best_sales') ?></h3>
<div class="variable-slider">
<div class="container">
<div class="variable-width">
<?php
foreach ($best_sales as $product) {
?>
<div class="variable-item">
<a href="<?php echo base_url('product_details/' . remove_space($product->product_name) . '/' . $product->product_id) ?>"
class="cat-box">
<h5 class="cat-title"><?php echo html_escape($product->product_name) ?></h5>
<img src="<?php echo base_url() . $product->image_thumb ?>"
     class="img-responsive"
     alt="image">
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
</div><!-- /.price-add-to-cart -->
</a>
</div>
<?php } ?>
</div>
</div>
</div>
</div>
</div>

<?php }

if ($block_list) {
foreach ($block_list as $block) :
if ($block['block_style'] == 1) {
$get_sub_category_list = $this->Homes->get_sub_category_list($block['block_cat_id']);
$category_list_by_id = $this->Homes->category_list_by_id($block['block_cat_id']);
if ($get_sub_category_list) { ?>
<div class="variable-slider">
<div class="container">
<div class="text-center mobile-block-category-title">
        <span class="-letters"><?php echo html_escape($category_list_by_id->category_name);
            ?></span>
</div>
<div class="variable-width">
<?php foreach ($get_sub_category_list as $category): ?>
<div class="variable-item">
<a href="<?php echo base_url() . 'category/p/' . remove_space($category['category_name']) . '/' . $category['category_id']; ?>"
   class="cat-box">
    <h5 class="cat-title"><?php echo html_escape($category['category_name']); ?></h5>
    <img src="<?php echo base_url() . $category['cat_image']; ?>"
         class="img-responsive"
         alt="image">
</a>
</div>
<?php endforeach; ?>
</div>
</div>
</div>
<?php }
}
?>
<?php
if ($block['block_style'] == 2) {
$get_sub_category_list = $this->Homes->get_sub_category_list($block['block_cat_id']);
$category_list_by_id = $this->Homes->category_list_by_id($block['block_cat_id']);
if ($get_sub_category_list) { ?>
<div class="variable-slider">
<div class="container">
<div class="text-center mobile-block-category-title">
<span class="-letters"><?php echo html_escape($category_list_by_id->category_name);
?></span>
</div>
<div class="variable-width">
<?php foreach ($get_sub_category_list as $category): ?>
<div class="variable-item">
<a href="<?php echo base_url() . 'category/p/' . remove_space($category['category_name']) . '/' . $category['category_id']; ?>"
   class="cat-box">
    <h5 class="cat-title"><?php echo html_escape($category['category_name']); ?></h5>
    <img src="<?php echo base_url() . $category['cat_image']; ?>"
         class="img-responsive"
         alt="image">
</a>
</div>
<?php endforeach; ?>
</div>
</div>
</div>
<?php }
}
endforeach;
}
?>
</div>


