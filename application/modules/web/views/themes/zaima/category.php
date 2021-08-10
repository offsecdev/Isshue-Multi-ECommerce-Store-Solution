<?php include_once(dirname(__FILE__).'/functions/functions.php'); ?>

<?php $this->load->view('adv/category_adv1', array('adv_position' => 1)); ?>

<div class="container py-4">
    <div class="row">
        <div class="<?php echo (!empty($after_search)?'col-md-3':'col-md-3') ?> d-none d-lg-block leftSidebar mb-3 pr-xl-4">
            <?php
                $sub_category = $this->Homes->get_sub_category($category_id);
                if (!empty($sub_category)) { ?>
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h2 class="mb-0 fs-17"><?php echo html_escape($category_name) ?></h2>
                    <i data-feather="sliders" class="card-header_icon"></i>
                </div>
                
                <div class="card-body">
                    <ul class="subcategories list-unstyled">
                        <?php
                        if ($sub_category) {
                            $i = 1;
                            foreach ($sub_category as $cat) {
                                if ($i == 11) break;
                                $no_of_pro = $this->Categories->select_total_sub_cat_no_of_pro($cat['category_id']);
                                ?>

                        <li>
                            <a href="<?php echo base_url('category/p/' . remove_space($cat['category_name']) . '/' . $cat['category_id']) ?>" class="d-flex align-items-center mb-2 text-black">
                                <i data-feather="chevron-right" class="mr-1"></i>
                                <span class="name"><?php echo html_escape($cat['category_name']) ?></span>
                                <span class="total fs-12 text-black-50 ml-2">(<?php echo html_escape($no_of_pro); ?>)</span>
                            </a>
                        </li>
                        <?php
                                $i++;
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <?php } ?>
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h2 class="mb-0 fs-17"><?php echo display('price') ?></h2>
                    <i data-feather="sliders" class="card-header_icon"></i>
                </div>
                <div class="card-body">
                    <?php echo form_open('', array('id' => 'priceForm')); ?>

                    <input type="text" class="price-range" value="price-range" name="price-range"/>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <?php
            $brand_info = $this->Categories->select_sub_cat_brand_info($category_id);
            if ($brand_info) { ?>

            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h2 class="mb-0 fs-17"><?php echo display('brand') ?></h2>
                    <i data-feather="sliders" class="card-header_icon"></i>
                </div>
                <div class="card-body">
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
                    <div class="custom-control custom-checkbox mb-2">

                        <input id="brand<?php echo $i ?>" type="checkbox"
                                               class="brand_class custom-control-input" name="brand" value="<?php
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


                        <label class="custom-control-label" for="brand<?php echo $i ?>">
                            <?php echo html_escape($brand_in['brand_name']) ?><span class="count text-muted fs-12 ml-1"></span>
                        </label>
                    </div>
                     <?php
                            $i++;
                        }
                    }
                    ?>
                </div>
            </div>
            <?php } ?>

            <?php $this->load->view('adv/category_adv2', array('adv_position' => 3)); ?>


        </div>
        <div class="<?php echo (!empty($after_search)?'col-md-9':'col-md-9') ?> mainContent category-content">

            <div class="filter-row d-flex align-items-center justify-content-between mb-2">
                <div class="filter-title">
                    <?php if (!empty($after_search)) { ?>
                        <h1 class="fs-21 mb-0 d-inline-block">
                            <?php echo html_escape($total) . " ".display('search_items').'"'.$keyword.'"';
                            ?>
                    </h1>
                    <?php } else { ?>
                    <h1 class="fs-21 mb-0 d-inline-block"><?php echo html_escape($category_name); ?></h1>
                    <span class="text-black-50">- <?php echo html_escape($total); ?> <?php echo display('items') ?></span>
                    <?php } ?>
                </div>

                <a class="btn btn-warning color4 color46 text-white" href="<?php echo base_url() ?>"><i class="far fa-hand-point-left"></i> <?php echo display('back_to_home') ?></a>
            </div>
            <div class="row">
                <?php
            if (!empty($category_product)) {
                foreach ($category_product as $product) {
                    ?>

                <div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">
                    <div class="feature-card card mb-3">
                        <div class="card-body">
                            <a href="<?php echo base_url('product/' . remove_space($product->product_name) . '/' . $product->product_id) ?>" class="product-img d-block">
                                <?php if (@getimagesize($product->image_thumb) === false) { ?>
                                <img src="<?php echo base_url() . '/my-assets/image/no-image.jpg' ?>" class="media-object img-fluid"
                                     alt="<?php echo html_escape($product->product_name) ?>">
                                <?php } else { ?>
                                    <img class="img-fluid" src="<?php echo base_url() . $product->image_thumb ?>" alt="<?php echo html_escape($product->product_name) ?>">
                                <?php } ?>
                            </a>
                            <h3 class="product-name fs-15 font-weight-600 overflow-hidden mt-2">
                                <a href="<?php echo base_url('product/' . remove_space($product->product_name) . '/'. $product->product_id) ?>" class="text-black"><?php echo html_escape($product->product_name) ?></a>
                            </h3>
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

                            echo  (($position1 == 0) ? $currency1 . number_format($price_val, 2, '.', ',') : number_format($price_val, 2, '.', ',') . $currency1); ?> / <?php echo display('unit') ?></div>
                        </div>
                    </div>
                </div>
            <?php } }else{  ?>
                <div class="col-md-12 text-center">
                    <h3 class='text-muted mt-3'><?php echo display('category_product_not_found');?></h3>
                <?php } ?>
                </div>
                <div class="pt-2">
                    <!-- Pagination-->
                    <div class="pagination d-flex align-items-center">
                        <div class="column">
                            <?php echo htmlspecialchars_decode($links); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('adv/category_adv1', array('adv_position' => 2)); ?>

<!-- End OF category Mobile -->
<input type="hidden" name="category_id" id="category_id" value="<?php echo html_escape($category_id) ?>">
<input type="hidden" name="query_string" id="query_string" value="<?php echo $this->input->server('QUERY_STRING'); ?>">
<input type="hidden" name="brand_url_ids" id="brand_url_ids" value="<?php echo $this->uri->segment('3') ?>">
</div>
<input type="hidden" name="price_min_value" id="price_min_value" value="<?php echo html_escape($min_value) ?>">
<input type="hidden" name="price_max_value" id="price_max_value" value="<?php echo (!empty($max_value)?html_escape($max_value):10000) ?>">
<input type="hidden" name="from_price" id="from_price" value="<?php echo html_escape($from_price) ?>">
<input type="hidden" name="to_price" id="to_price" value="<?php echo html_escape($to_price) ?>">
<input type="hidden" name="default_currency_icon" id="default_currency_icon" value="<?php echo (!empty($default_currency_icon)?html_escape($default_currency_icon):$currency1) ?>">
