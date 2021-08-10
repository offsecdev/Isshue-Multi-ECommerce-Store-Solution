<div class="bg-gray py-5">
    <div class="container">
        <div class="row align-items-center justify-content-center justify-content-sm-between mb-5 mb-sm-2">
            <div class="col-12 col-sm-auto text-center text-sm-left mb-2 mb-sm-0">
                <a href="<?php echo base_url() . 'category/p/' . remove_space($block['category_name']) . '/' . $block['block_cat_id']; ?>" class="text-black"><h3 class="category-headding fs-23"><?php echo html_escape($cat_pro[0]->category_name) ?></h3></a>
            </div>
            <div class="col-8 col-sm-5 col-md-4 col-lg-3">
                <?php echo form_open('web/Category/search_catproduct', array('method' => 'GET')) ?>
                <div class="input-group-overlay">
                    <div class="input-group-prepend-overlay">
                        <button class="input-group-text" type="submit"><i data-feather="search"></i></button>
                    </div>
                    <input class="form-control prepended-form-control appended-form-control" name="product_name" type="text" placeholder="<?php echo display('search') ?>...." />
                    <input type="hidden" name="category_id" value="<?php echo html_escape($block['block_cat_id']) ?>">
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
        <div class="headding-border position-relative mb-4 d-none d-sm-block"></div>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="display-item_one" role="tabpanel" aria-labelledby="display-item_one--tab">
                <div class="row">
                    <?php
                    $counter=1;
                    foreach ($cat_pro as $product) { 
                    if($counter <= 4){

                        $prodlink =  base_url('/product/' . remove_space($product->product_name) . '/' . $product->product_id);
                        if($counter == 1){
                        ?>

                        <div class="col-md-5 col-lg-6">
                            <div class="img-area position-relative bg-white border p-4 p-lg-5 mb-3 mb-md-0">
                                <div class="img-area_header mb-2">
                                    <p class="mb-1"><?php echo html_escape($cat_pro[0]->category_name) ?></p>
                                    <h3 class="img-area_header--title fs-27 mb-0"><?php echo html_escape($product->product_name) ?></h3>
                                     <?php
                                        $offer_pertge = 0;
                                        if ($product->onsale == 1 && !empty($product->onsale_price)) {
                                            $save_amount =  ($product->price - $product->onsale_price) ;
                                            $offer_pertge = (($save_amount/$product->price)*100);
                                        }
                                        if($offer_pertge > 0){
                                        ?>

                                    <div class="product-offer-label d-flex align-items-center justify-content-center text-white flex-column position-absolute shadow">
                                        
                                        <span class="font-weight-500 fs-23 mb-1"><?php echo ceil($offer_pertge); ?>%</span> 
                                        <small class="fs-16"><?php echo display('offers')  ?></small>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="img">
                                    <a href="<?php echo $prodlink; ?>">
                                    <?php if (@getimagesize($product->image_thumb) === false) { ?>
                                        <img src="<?php echo base_url() . '/my-assets/image/no-image.jpg' ?>" class="img-fluid" alt="<?php echo html_escape($product->product_name) ?>">
                                        <?php } else { ?>
                                            <img class="img-fluid" src="<?php echo base_url() . $product->image_thumb ?>" alt="<?php echo html_escape($product->product_name) ?>">
                                        <?php } ?>
                                    </a>
                                </div>
                                <div class="text-block">
                                    <p class="body-copy  text-block_des fs-17 text-black-50 overflow-hidden"><?php echo strip_tags(htmlspecialchars_decode($product->product_details)); ?>
                                    </p>
                                    
                                    <div class="link"><a href="<?php echo $prodlink; ?>" class="link-text font-weight-500 text-uppercase"><?php echo display('details')  ?></a></div>
                                </div>
                            </div>
                        </div>
                        <?php }else { ?>

                        <?php if($counter==2){ ?>

                        <div class="col-md-7 col-lg-6">
                            <div class="list-area">
                        <?php } ?>

                                <div class="item position-relative bg-white border text-center float-left mb-3">
                                    <div class="img">
                                        <a href="<?php echo $prodlink; ?>">
                                            <?php if (@getimagesize($product->image_thumb) === false) { ?>
                                            <img src="<?php echo base_url() . '/my-assets/image/no-image.jpg' ?>" alt="image">
                                        <?php } else { ?>
                                            <img  src="<?php echo base_url() . $product->image_thumb ?>" alt="image">
                                        <?php } ?> 
                                        </a>
                                    </div>
                                    <div class="info-area">
                                        <div class="model-name">
                                            <a href="<?php echo $prodlink; ?>"><?php echo html_escape($product->product_name) ?></a> 
                                        </div>
                                        <div class="star-rating justify-content-center mt-3">
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
                                        <!--Product price area-->
                                        <div class="price-area d-flex align-items-center justify-content-center mb-2">
                                        <?php
                                        $old_price = $save_amount = 0;
                                        if ($product->onsale == 1 && !empty($product->onsale_price)) {
                                                $price_val = $product->onsale_price * $target_con_rate;
                                                $old_price =  $product->price;
                                                $save_amount =  ($product->price - $product->onsale_price) ;
                                            }else{
                                                $price_val = $product->price * $target_con_rate;
                                            } ?>


                                            <div class="purchase-price">
                                                <div class="price font-weight-500"><?php 
                                                echo  (($position1 == 0) ? $currency1 . number_format($price_val, 2, '.', ',') : number_format($price_val, 2, '.', ',') . $currency1);?></div>
                                            </div>
                                            <?php if($old_price){ ?>
                                            <div class="product-price ml-2">
                                                <del class="price"><span class="d-none">Previous price</span>
                                                    <?php 
                                                echo  (($position1 == 0) ? $currency1 . number_format($old_price, 2, '.', ',') : number_format($old_price, 2, '.', ',') . $currency1);?>

                                                </del> 
                                                <?php if($save_amount > 0){ ?>
                                                <div class="legal">Save <?php 
                                                echo  (($position1 == 0) ? $currency1 . number_format($save_amount, 2, '.', ',') : number_format($save_amount, 2, '.', ',') . $currency1);?>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <a href="javascript:void(0)" class="btn btn-soft-primary btn-pill add-to-cart font-weight-500 d-inline-flex align-items-center mt-2 color412" onclick="add_to_cart_item('<?php echo $product->product_id;?>', '<?php echo remove_space($product->product_name);?>', '<?php echo $product->default_variant; ?>', <?php echo $product->variant_price; ?>)">
                                            <i data-feather="shopping-cart" class="mr-2"></i><?php echo display('add_to_cart'); ?>
                                        </a>	
                                    </div>
                                </div>



                        <?php if($counter==4){ ?>
                            </div>
                        </div>
                        <?php } ?>

                        <?php }
                         }
                         $counter++; 
                     } ?>
                </div>
            </div>
        </div>
    </div>
</div>