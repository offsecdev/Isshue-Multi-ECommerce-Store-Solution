<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php 
    $is_aff = false;
    if(check_module_status('affiliate_products') == 1){
        $is_aff = true;
    }
 ?>
<?php
$CI =& get_instance();
?>
<div class="page-breadcrumbs">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>"><?php echo display('home') ?></a></li>
            <li class="active"><?php echo html_escape($brand_name) ?></li>
        </ol>
    </div>
</div>
<input type="hidden" name="price_min_value" id="price_min_value" value="<?php echo html_escape($min_value) ?>">
<input type="hidden" name="price_max_value" id="price_max_value" value="<?php echo html_escape($max_value) ?>">
<input type="hidden" name="from_price" id="from_price" value="<?php echo html_escape($from_price) ?>">
<input type="hidden" name="to_price" id="to_price" value="<?php echo html_escape($to_price) ?>">
<input type="hidden" name="default_currency_icon" id="default_currency_icon"
       value="<?php echo html_escape($default_currency_icon) ?>">
<!-- /.End of page breadcrumbs -->
<div class="category-content hidden-xs">
    <div class="container">
        <div class="row">
            <div class="col-sm-3 leftSidebar hidden-xs">
                <div class="sidebar-widget">
                    <!-- /.End of accessories -->
                    <div class="sidebar-widget-title">
                        <?php
                        if ($max_value) {
                            ?>
                            <div class="price-Pips">
                                 <?php echo form_open('', array('id' => 'priceForm')); ?>
                                    <h3 class="sidebar-title"><?php echo display('by_price') ?></h3>
                                    <input type="text" class="price-range" value="price-range" name="price-range"/>
                                <?php echo form_close(); ?>
                            </div>
                            <?php
                        }
                        if ($variant_list) {
                            ?>
                            <div class="product-size">
                                <h3 class="sidebar-title"><?php echo display('by_variant') ?>:</h3>
                                <?php
                                if ($variant_list) {
                                    $i = 1;
                                    foreach ($variant_list as $variant) {
                                        ?>
                                        <input type="radio" class="size1" name="size" id="<?php echo $i ?>" value="<?php
                                        $currentURL = current_url();
                                        $params = $_SERVER['QUERY_STRING'];
                                        $size = $this->input->get('size',TRUE);
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
                                                    class="size"><?php echo html_escape($variant['variant_name']) ?></span></label>
                                        <?php
                                        $i++;
                                    }
                                }
                                ?>
                            </div>
                            <!--  /.End of product color selector -->
                            <?php
                        }
                        $lang_id = 0;
                        $user_lang = $this->session->userdata('language');
                        if (empty($user_lang)) {
                            $lang_id = 'english';
                        } else {
                            $lang_id = $user_lang;
                        }
                        ?>
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
                                            <span class="count">(<?php echo display('4-5') ?>)</span>
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
                                            <span class="count">(<?php echo display('3-5') ?>)</span>
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
                                            <span class="count">(<?php echo display('2-5'); ?>)</span>
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
                                            <span class="count">(<?php echo display('1-5'); ?>)</span>
                                        </a>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <!--  /.End of review rating -->

                    </div>
                </div>
            </div>
            <div class="col-sm-9 content">
                <div class="filter-row align-items-center justify-content-between">
                    <div class="filter-title">
                        <h1><?php echo html_escape($brand_name) . ' - ' ?></h1>
                        <span>
                        <?php
                        echo $item = count($brand_product);
                        if ($item <= 0) {
                            echo " " . display('item_found');
                        } elseif ($item > 0) {
                            echo " " . display('items');
                        }
                        ?>
                        </span>
                    </div>
                </div>
                <!-- /.End of filter summary -->
                <div class="row mr-0">
                    <?php
                    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
                    $total = count($brand_product); //total items in array
                    $limit = 16; //per page
                    $totalPages = ceil($total / $limit); //calculate total pages
                    $page = max($page, 1); //get 1 page when $_GET['page'] <= 0
                    $page = min($page, $totalPages); //get last page when $_GET['page'] > $totalPages
                    $offset = ($page - 1) * $limit;
                    if ($offset < 0) $offset = 0;

                    $brand_product = array_slice($brand_product, $offset, $limit);

                    if ($brand_product) {
                        foreach ($brand_product as $product) {
                            $select_single_category = $this->Categories->select_single_category_by_id($product['category_id']);
                            ?>
                            <div class="col-xs-6 col-sm-4 col-md-3 pa-0">
                                <div class="product-box">
                                    <div class="imagebox">
                                        <span class="product-cat"><a
                                                    href="<?php echo base_url('category/p/' . remove_space($product['product_name']) . '/' . $product['category_id']) ?>"><?php echo @$select_single_category->category_name ?></a></span>
                                        <a href="<?php echo base_url('product_details/' . remove_space($product['product_name']) . '/' . $product['product_id']) ?>">
                                            <h3 class="product-name"><?php echo html_escape($product['product_name']) ?></h3>
                                            <div class="product-thumb">
                                                <img src="<?php echo base_url() ?>assets/website/image/loader.svg"
                                                     data-src="<?php echo base_url() . $product['image_thumb'] ?>"
                                                     alt="">
                                            </div>
                                        </a>
                                        <span>
                                    <b>
                                    <?php
                                    if ($product['brand_name']) {
                                        echo html_escape($product['brand_name']);
                                    } else {
                                        echo html_escape($product['first_name'] . ' ' . $product['last_name']);
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

                                            <?php if ($product['onsale'] == 1 && !empty($product['onsale_price'])) { ?>
                                                <span class="price">
                                        <span class="price-amount">
                                            <ins><span class="amount">
                                            <?php
                                            if ($target_con_rate > 1) {
                                                $price = $product['onsale_price'] * $target_con_rate;
                                                echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                            }

                                            if ($target_con_rate <= 1) {
                                                $price = $product['onsale_price'] * $target_con_rate;
                                                echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                            }
                                            ?>
                                            </span></ins>
                                            <del><span class="amount">
                                            <?php
                                            if ($target_con_rate > 1) {
                                                $price = $product['price'] * $target_con_rate;
                                                echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                            }

                                            if ($target_con_rate <= 1) {
                                                $price = $product['price'] * $target_con_rate;
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
                                                $price = $product['price'] * $target_con_rate;
                                                echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                            }

                                            if ($target_con_rate <= 1) {
                                                $price = $product['price'] * $target_con_rate;
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
                                                <div class="total-rating">(<?php echo htmlspecialchars_decode($rater) ?>)</div>
                                            </div><!-- Rating -->
                                        </div><!-- /.price-add-to-cart -->
                                        <div class="box-bottom">
                                            <div class="btn-add-cart">

                                                <?php if($is_aff){ if($product['is_affiliate'] == 1 ){ ?>
                                                        <a href="<?php echo html_escape($product['affiliate_url']) ?>" target="0">
                                                            <img src="<?php echo base_url('assets/website/image/add-cart.png') ?>" alt=""><?php echo display('buy_now') ?>
                                                        </a>
                                                <?php }else{ ?> 
                                                    <a  href="javascript:void(0)" onclick="add_to_cart_item('<?php echo $product['product_id']; ?>', '<?php echo remove_space($product['product_name']); ?>', '<?php echo $product['default_variant']; ?>', <?php echo $product['variant_price']; ?>);">
                                                        <img src="<?php echo base_url('assets/website/image/add-cart.png') ?>" alt=""><?php echo display('add_to_cart') ?>
                                                    </a>
                                                <?php } }else{ ?>
                                                    <a  href="javascript:void(0)" onclick="add_to_cart_item('<?php echo $product['product_id']; ?>', '<?php echo remove_space($product['product_name']); ?>', '<?php echo $product['default_variant']; ?>', <?php echo $product['variant_price']; ?>);">
                                                        <img src="<?php echo base_url('assets/website/image/add-cart.png') ?>" alt=""><?php echo display('add_to_cart') ?>
                                                    </a>
                                                <?php }  ?>

                                            </div>
                                            <div class="compare-wishlist">
                                                <a href="javascript:void(0)" class="wishlist" title=""
                                                   name="<?php echo html_escape($product['product_id']) ?>">
                                                    <img src="<?php echo base_url('assets/website/image/wishlist.png') ?>" alt=""><?php echo display('wishlist') ?>
                                                </a>
                                            </div>
                                        </div><!-- /.box-bottom -->
                                    </div>
                                </div>
                                <!-- /.End of product box -->
                            </div>
                        <?php }
                    } ?>
                    <?php
                    if ($total > 0) {
                        ?>
                        <div class="col-xs-12 col-sm-12">
                            <div class="pagination-widget">
                                <?php
                                $start = (($page - $total) > 0) ? $page - $total : 1;
                                $end = (($page + $total) < $totalPages) ? $page + $total : $totalPages;

                                $html = '<ul class="pagination">';
                                $class = ($page == 1) ? "disabled" : "";
                                $html .= '<li class="' . $class . '"><a href="?page=' . ($page - 1) . '">⇽</a></li>';

                                if ($start > 1) {
                                    $html .= '<li><a href="?page=1">1</a></li>';
                                    $html .= '<li class="disabled"><span>...</span></li>';
                                }

                                for ($i = $start; $i <= $end; $i++) {
                                    $class = ($page == $i) ? "active" : "";
                                    $html .= '<li class="' . $class . '"><a href="?page=' . $i . '">' . $i . '</a></li>';
                                }

                                if ($end < $totalPages) {
                                    $html .= '<li class="disabled"><span>...</span></li>';
                                    $html .= '<li><a href="?page=' . $totalPages . '">' . $totalPages . '</a></li>';
                                }

                                $class = ($page == $totalPages) ? "disabled" : "";
                                $html .= '<li class="' . $class . '"><a href="?page=' . ($page + 1) . '">⇾</a></li>';

                                echo $html .= '</ul>';
                                ?>
                            </div>
                        </div>
                        <!-- /.End of pagination -->
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.End of category content -->
<div class="category-mobile">
    <div class="mobile-filter-nav align-items-center justify-content-between">

        <div class="col-xs-12 filter text-center">
            <button type="button" class="" data-toggle="modal" data-target=".filter-modal"><i class="fa fa-filter"
                                                                                              aria-hidden="true"></i><?php echo display('filter') ?>
            </button>
        </div>
    </div>
    <div class="modal filter-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="sidebar-widget-title">
                    <?php
                    if ($max_value) {
                        ?>
                        <div class="price-Pips">
                            <?php echo form_open('', array('id' => 'priceForm1')); ?>
                                <h3 class="sidebar-title"><?php echo display('by_price') ?></h3>
                                <input type="text" class="price-range" value="price-range" name="price-range"/>
                            <?php echo form_close(); ?>
                        </div>
                        <?php
                    }
                    if ($variant_list) {
                        ?>
                        <div class="product-size">
                            <h3 class="sidebar-title"><?php echo display('by_variant') ?>:</h3>
                            <?php
                            if ($variant_list) {
                                $i = 1;
                                foreach ($variant_list as $variant) {
                                    ?>
                                    <input type="radio" class="size1" name="size" id="<?php echo $i ?>" value="<?php
                                    $currentURL = current_url();
                                    $params = $_SERVER['QUERY_STRING'];
                                    $size = $this->input->get('size',TRUE);
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
                                                class="size"><?php echo html_escape($variant['variant_name']) ?></span></label>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                        </div>
                        <!--  /.End of product color selector -->
                        <?php
                    }
                    $lang_id = 0;
                    $user_lang = $this->session->userdata('language');
                    if (empty($user_lang)) {
                        $lang_id = 'english';
                    } else {
                        $lang_id = $user_lang;
                    }
                    ?>
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
                                        <span class="count">(<?php echo display('4-5') ?>)</span>
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
                                        <span class="count">(<?php echo display('3-5') ?>)</span>
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
                                        <span class="count">(<?php echo display('2-5') ?>)</span>
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
                                        <span class="count">(<?php echo display('1-5') ?>)</span>
                                    </a>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <ul class="category">
        <?php
        if ($brand_product) {
            foreach ($brand_product as $product) {
                $select_single_category = $this->Categories->select_single_category_by_id($product['category_id']);
                ?>
                <li class="col-xs-4">
                    <div class="product-box">
                        <div class="imagebox">
                            <span class="product-cat"><a
                                        href="<?php echo base_url('category/p/' . remove_space($product['product_name']) . '/' . $product['category_id']) ?>"><?php echo html_escape($select_single_category->category_name) ?></a></span>
                            <a href="<?php echo base_url('product_details/' . remove_space($product['product_name']) . '/' . $product['product_id']) ?>">
                                <h3 class="product-name"><?php echo html_escape($product['product_name']) ?></h3>
                                <div class="product-thumb">
                                    <img src="<?php echo base_url() ?>assets/website/image/loader.svg"
                                         data-src="<?php echo base_url() . $product['image_thumb'] ?>" alt="">
                                </div>
                            </a>
                            <span>
                        <b>
                        <?php
                        if ($product['brand_name']) {
                            echo html_escape($product['brand_name']);
                        } else {
                            echo html_escape($product['first_name'] . ' ' . $product['last_name']);
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

                                <?php if ($product['onsale'] == 1 && !empty($product['onsale_price'])) { ?>
                                    <span class="price">
                            <span class="price-amount">
                                <ins><span class="amount">
                                <?php
                                if ($target_con_rate > 1) {
                                    $price = $product['onsale_price'] * $target_con_rate;
                                    echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                }

                                if ($target_con_rate <= 1) {
                                    $price = $product['onsale_price'] * $target_con_rate;
                                    echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                }
                                ?>
                                </span></ins>
                                <del><span class="amount">
                                <?php
                                if ($target_con_rate > 1) {
                                    $price = $product['price'] * $target_con_rate;
                                    echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                }

                                if ($target_con_rate <= 1) {
                                    $price = $product['price'] * $target_con_rate;
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
                                    $price = $product['price'] * $target_con_rate;
                                    echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                }

                                if ($target_con_rate <= 1) {
                                    $price = $product['price'] * $target_con_rate;
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
                                    <div class="total-rating">(<?php echo htmlspecialchars_decode($rater) ?>)</div>
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
        <?php
        if ($links) {
            ?>
            <div class="col-xs-12 col-sm-12">
                <div class="pagination-widget">
                    <?php echo htmlspecialchars_decode($links); ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>


