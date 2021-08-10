<div class="pt-5 pb-3">
    <div class="container">
        <div class="row">
            <?php if (!empty($best_sales)) { ?>

            <div class="col-md-4 col-sm-6 mb-3 mb-md-0">
                <h3 class="category-headding"><?php echo display('best_sale_product') ?></h3>
                <div class="headding-border"></div>
                <div class="feature-category owl-carousel owl-theme">
                    <?php
                    $counter=0;
                    $totalitems=count($best_sales);
                     foreach ($best_sales as $product) {
                        echo (($counter%5==0)?'<div class="feature-item widget">':'');
                     ?>
                    <div class="media mb-3">
                        <?php $prodlink = base_url('/product_details/' . remove_space($product->product_name) . '/' . $product->product_id) ?>
                        <a class="entry-thumb d-block position-relative bg-white border mr-3" href="<?php echo $prodlink; ?>">

                            <?php if (@getimagesize($product->image_thumb) === false) { ?>
                                <img src="<?php echo base_url() . '/my-assets/image/no-image.jpg' ?>" alt="image" width="64">
                            <?php } else { ?>
                                <img  src="<?php echo base_url() . $product->image_thumb ?>" alt="image" width="64">
                            <?php } ?>
                        </a>
                        <div class="media-body">
                            <h6 class="entry-title fs-16 font-weight-500 product-name overflow-hidden"><a href="<?php echo $prodlink; ?>" class="d-block"><?php echo html_escape($product->product_name) ?></a></h6>
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
                            <p class="entry-meta">
                                <?php
                                if ($product->onsale == 1 && !empty($product->onsale_price)) {
                                    $price_val = $product->onsale_price * $target_con_rate;
                                }else{
                                    $price_val = $product->price * $target_con_rate;
                                }

                                echo  (($position1 == 0) ? $currency1 . number_format($price_val, 2, '.', ',') : number_format($price_val, 2, '.', ',') . $currency1); ?>

                            </p>
                        </div>
                    </div>
                    <?php  echo ((($counter%5==4)||($counter == $totalitems-1))?'</div>':''); ?>
                    <?php  $counter++;  } ?>
                </div>
            </div>
            <?php } ?>

            <?php
            $latest_products = $this->db->select('*')->from('product_information')->where('status','1')->order_by('id','desc')->limit(15)->get()->result();
            if(!empty($latest_products)){
             ?>
            <div class="col-md-4 col-sm-6 mb-3 mb-md-0">
                <h3 class="category-headding "><?php echo display('new_product') ?></h3>
                <div class="headding-border"></div>
                <div class="feature-category owl-carousel owl-theme">
                    <?php 
                    $counter=0;
                    $totalitems=count($latest_products);
                    foreach ($latest_products as $product) {
                    echo (($counter%5==0)?'<div class="feature-item widget">':'');
                     ?>
                    <div class="media mb-3">
                        <?php $prodlink = base_url('/product_details/' . remove_space($product->product_name) . '/' . $product->product_id) ?>
                        <a class="entry-thumb d-block position-relative bg-white border mr-3" href="<?php echo $prodlink; ?>">
                            <?php if (@getimagesize($product->image_thumb) === false) { ?>
                                <img src="<?php echo base_url() . '/my-assets/image/no-image.jpg' ?>" alt="image" width="64">
                            <?php } else { ?>
                                <img  src="<?php echo base_url() . $product->image_thumb ?>" alt="image" width="64">
                            <?php } ?>
                        </a>
                        <div class="media-body">
                            <h6 class="entry-title fs-16 font-weight-500 product-name overflow-hidden"><a href="<?php echo $prodlink; ?>" class="d-block"><?php echo html_escape($product->product_name) ?></a></h6>
                            <div class="star-rating">
                                <?php
                                 $result = $this->db->select('IFNULL(SUM(rate),0) as t_rates, count(rate) as t_reviewer')
                                         ->from('product_review')
                                        ->where('product_id', $product->product_id)
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
                            <p class="entry-meta">
                                <?php
                                if ($product->onsale == 1 && !empty($product->onsale_price)) {
                                    $price_val = $product->onsale_price * $target_con_rate;
                                }else{
                                    $price_val = $product->price * $target_con_rate;
                                }

                                echo  (($position1 == 0) ? $currency1 . number_format($price_val, 2, '.', ',') : number_format($price_val, 2, '.', ',') . $currency1); ?>
                            </p>
                        </div>
                    </div>
                    <?php  echo ((($counter%5==4)||($counter == $totalitems-1))?'</div>':''); ?>
                    <?php  $counter++;  } ?>
                </div>
            </div>
            <?php } ?>
            <?php if (!empty($most_popular_product)) { ?>
            <div class="col-md-4 col-sm-6">
                <h3 class="category-headding "><?php echo display('most_popular_product') ?></h3>
                <div class="headding-border"></div>
                <div class="feature-category owl-carousel owl-theme">
                    <?php 
                    $counter=0;
                    $totalitems=count($most_popular_product);
                    foreach ($most_popular_product as $product) {
                    echo (($counter%5==0)?'<div class="feature-item widget">':'');
                     ?>
                    <?php $prodlink = base_url('/product_details/' . remove_space($product->product_name) . '/' . $product->product_id) ?>
                    <div class="media mb-3">
                        <a class="entry-thumb d-block position-relative bg-white border mr-3" href="<?php echo $prodlink; ?>">
                            <?php if (@getimagesize($product->image_thumb) === false) { ?>
                                <img src="<?php echo base_url() . '/my-assets/image/no-image.jpg' ?>" width="64" alt="image">
                            <?php } else { ?>
                                <img width="64" src="<?php echo base_url() . $product->image_thumb ?>" alt="image">
                            <?php } ?>
                        </a>
                        <div class="media-body">
                            <h6 class="entry-title fs-16 font-weight-500 product-name overflow-hidden"><a href="<?php echo $prodlink; ?>" class="d-block"><?php echo html_escape($product->product_name) ?></a></h6>
                            <div class="star-rating">
                                 <?php
                                     $result = $this->db->select('IFNULL(SUM(rate),0) as t_rates, count(rate) as t_reviewer')
                                     ->from('product_review')
                                    ->where('product_id', $product->product_id)
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
                            <p class="entry-meta">
                                <?php
                                if ($product->onsale == 1 && !empty($product->onsale_price)) {
                                    $price_val = $product->onsale_price * $target_con_rate;
                                ?>
                                <del class="text-muted mr-1">
                                    <?php echo  (($position1 == 0) ? $currency1 . number_format($price_val, 2, '.', ',') : number_format($price_val, 2, '.', ',') . $currency1); ?>
                                </del>
                                <?php 
                                }else{
                                    $price_val = $product->price * $target_con_rate;
                                }

                                echo  (($position1 == 0) ? $currency1 . number_format($price_val, 2, '.', ',') : number_format($price_val, 2, '.', ',') . $currency1);
                                ?>


                            </p>
                        </div>
                    </div>
                    <?php  echo ((($counter%5==4)||($counter == $totalitems-1))?'</div>':''); ?>
                    <?php  $counter++;  } ?>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>