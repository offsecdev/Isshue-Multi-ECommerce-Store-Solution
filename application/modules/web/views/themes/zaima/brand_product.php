<?php include_once(dirname(__FILE__).'/functions/functions.php'); ?>
<div class="container py-5">
    <div class="row">
        <div class="col-md-3 d-none d-lg-block leftSidebar mb-3 pr-xl-4">
            <?php
                if ($max_value) {
                ?>
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
                }
                if ($variant_list) {
                    ?>
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h2 class="mb-0 fs-17"><?php echo display('by_variant') ?></h2>
                    <i data-feather="sliders" class="card-header_icon"></i>
                </div>
                <div class="card-body">
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
                            ?>" <?php echo (($size == $variant['variant_id'])?"checked":""); ?>/>
                            <label for="<?php echo $i ?>"><span class="size"><?php echo html_escape($variant['variant_name']) ?></span></label>
                            <?php
                            $i++;
                        }
                    }
                    ?>
                </div>
            </div>


            <?php } ?>

        </div>
        <div class="col-lg-9 mainContent category-content">
            <div class="filter-row d-flex align-items-center justify-content-between mb-2">
                <div class="filter-title">
                    <h1 class="fs-21 mb-0 d-inline-block"><?php echo html_escape($brand_name); ?></h1>
                    <span class="text-black-50">- <?php echo count($brand_product); ?> <?php echo display('items') ?></span>
                </div>

                <a class="btn btn-warning color3 color36 white_color" href="<?php echo base_url() ?>"><i class="far fa-hand-point-left"></i> <?php echo display('back_to_home') ?></a>
            </div>
            <div class="row">
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

                <div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">
                    <div class="feature-card card mb-3">
                        <div class="card-body">
                            <a href="<?php echo base_url('product_details/' . remove_space($product['product_name']) . '/' . $product['product_id']) ?>" class="product-img d-block">
                                <?php if (@getimagesize($product['image_thumb']) === false) { ?>
                                <img src="<?php echo base_url() . '/my-assets/image/no-image.jpg' ?>" class="media-object img-fluid"
                                     alt="<?php echo html_escape($product['product_name']) ?>">
                                <?php } else { ?>
                                    <img class="img-fluid" src="<?php echo base_url() . $product['image_thumb'] ?>" alt="<?php echo html_escape($product['product_name']) ?>">
                                <?php } ?>
                            </a>
                            <h3 class="product-name fs-15 font-weight-600 overflow-hidden mt-2">
                                <a href="<?php echo base_url('product_details/' . remove_space($product['product_name']) . '/' . $product['product_id']) ?>" class="text-black"><?php echo html_escape($product['product_name']) ?></a>
                            </h3>
                            <div class="star-rating">
                                <?php
                                 $result = $this->db->select('IFNULL(SUM(rate),0) as t_rates, count(rate) as t_reviewer')
                                 ->from('product_review')
                                ->where('product_id', $product['product_id'])
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

                            if ($product['onsale'] == 1 && !empty($product['onsale_price'])) {
                                $price_val = $product['onsale_price'] * $target_con_rate;
                            }else{
                                $price_val = $product['price'] * $target_con_rate;
                            }

                            echo  (($position1 == 0) ? $currency1 . number_format($price_val, 2, '.', ',') : number_format($price_val, 2, '.', ',') . $currency1); ?> / <?php echo display('unit') ?></div>
                        </div>
                    </div>
                </div>
            <?php } }  ?>
            </div>
            <?php if($total > $limit){ ?>
            <div class="pt-2">

                <nav class="pagination border-top d-flex align-items-center justify-content-between">
                    <div class="column">
                        <?php
                        $currurl = base_url('brand_product/list/'.$brand_id);
                        $start = (($page - $total) > 0) ? $page - $total : 1;
                        $end = (($page + $total) < $totalPages) ? $page + $total : $totalPages;

                        $html = '<ul class="pages">';
                        $class = ($page == 1) ? "disabled" : "";
                        $html .= '<li class="' . $class . '"><a href="'.$currurl.'?page=' . ($page - 1) . '">⇽</a></li>';

                        if ($start > 1) {
                            $html .= '<li><a href="'.$currurl.'?page=1">1</a></li>';
                            $html .= '<li class="disabled"><span>...</span></li>';
                        }

                        for ($i = $start; $i <= $end; $i++) {
                            $class = ($page == $i) ? "active" : "";
                            $html .= '<li class="' . $class . '"><a href="'.$currurl.'?page=' . $i . '">' . $i . '</a></li>';
                        }

                        if ($end < $totalPages) {
                            $html .= '<li class="disabled"><span>...</span></li>';
                            $html .= '<li><a href="'.$currurl.'?page=' . $totalPages . '">' . $totalPages . '</a></li>';
                        }

                        $class = ($page == $totalPages) ? "disabled" : "";
                        $html .= '<li class="' . $class . '"><a href="'.$currurl.'?page=' . ($page + 1) . '">⇾</a></li>';

                        echo $html .= '</ul>';
                        ?>
                    </div>
                    <div class="column text-right hidden-xs-down"><a class="btn btn-primary btn-sm" href="<?php echo $currurl.'?page=' . ($page + 1); ?>">Next&nbsp;<i class="icon-arrow-right"></i></a></div>
                </nav>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<input type="hidden" name="price_min_value" id="price_min_value" value="<?php echo html_escape($min_value) ?>">
<input type="hidden" name="price_max_value" id="price_max_value" value="<?php echo (!empty($max_value)?html_escape($max_value):10000) ?>">
<input type="hidden" name="from_price" id="from_price" value="<?php echo html_escape($from_price) ?>">
<input type="hidden" name="to_price" id="to_price" value="<?php echo html_escape($to_price) ?>">
<input type="hidden" name="default_currency_icon" id="default_currency_icon" value="<?php echo (!empty($default_currency_icon)?html_escape($default_currency_icon):$currency1) ?>">
<input type="hidden" name="query_string" id="query_string" value="<?php echo $this->input->server('QUERY_STRING'); ?>">