<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php 
    $is_aff = false;
    if(check_module_status('affiliate_products') == 1){
        $is_aff = true;
    }
?>
<!-- /.End of header -->
<div class="page-breadcrumbs">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href=""><?php echo display('home'); ?></a></li>
            <li class="active"><?php echo display('compare_product'); ?></li>
        </ol>
    </div>
</div>
<!-- /.End of page breadcrumbs --> 
<div class="container pb-5 mb-2">
            <div class="table-responsive">
                <!--Compare Table-->
                <table class="table table-bordered table-fixed table-compare" style="min-width: 45rem;">
                    <thead>
                        <tr>
                            <th class="text-center align-middle">
                                <?php echo display('product'); ?>
                            </th>
                            <?php
                            if ($this->session->userdata('comparison_ids')) {
                                foreach ($comparison_products as $comparison):  
                            ?>
                            <td class="text-center px-4 pb-4">
                                <a class="d-inline-block mb-3" href="<?php echo base_url('product_details/' . remove_space($comparison['product_name']) . '/' . $comparison['product_id']) ?>">
                                    <img src="<?php echo base_url().$comparison['image_thumb'] ?>" width="150" alt="product image">
                                </a>
                                <h3 class="product-title fs-18">
                                    <a href="<?php echo base_url('product_details/' . remove_space($comparison['product_name']) . '/' . $comparison['product_id']) ?>" class="text-primary">
                                        <?php echo html_escape($comparison['product_name']); ?>
                                    </a>
                                </h3>
                                <div class="product-rating align-items-center justify-content-center mb-3">
                                    <div class="star-rating mb-0 justify-content-center">
                                        <?php
                                        $result = $this->db->select('sum(rate) as rates')
                                            ->from('product_review')
                                            ->where('product_id', $comparison['product_id'])
                                            ->get()
                                            ->row();
                                        $rater = $this->db->select('rate')
                                            ->from('product_review')
                                            ->where('product_id', $comparison['product_id'])
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
                            </td>
                            <?php endforeach; } ?>

                        </tr>
                    </thead>
                    <tbody id="summary" data-filter="target">
                        <tr class="bg-gray">
                            <th class="text-uppercase align-middle"><?php echo display('name'); ?></th>
                            <?php
                            if ($this->session->userdata('comparison_ids')) {
                                foreach ($comparison_products as $comparison):  
                            ?>
                            <td><span class="text-dark font-weight-medium text-dark"><?php echo html_escape($comparison['product_name']); ?></span></td>
                            <?php endforeach; } ?>
                        </tr>
                        <tr>
                            <th class="text-uppercase align-middle"><?php echo display('model'); ?></th>
                            <?php
                            if ($this->session->userdata('comparison_ids')) {
                                foreach ($comparison_products as $comparison):  
                            ?>
                            <td>
                                <?php echo html_escape($comparison['product_model']); ?>   
                            </td>
                            <?php endforeach; } ?>
                        </tr>
                        <tr>
                            <th class="text-uppercase align-middle"><?php echo display('category'); ?></th>
                            <?php
                            if ($this->session->userdata('comparison_ids')) {
                                foreach ($comparison_products as $comparison):  
                            ?>
                            <td>
                                <?php echo $comparison['category_name']; ?>   
                            </td>
                            <?php endforeach; } ?>
                        </tr>
                        <tr>
                            <th class="text-uppercase align-middle"><?php echo display('price'); ?></th>
                            <?php
                            if ($this->session->userdata('comparison_ids')) {
                                foreach ($comparison_products as $comparison):  
                            ?>
                            <td>
                                <?php echo(($position == 0) ? $currency . ' ' . $this->cart->format_number($comparison['price']) : $this->cart->format_number($comparison['price']) . ' ' . $currency) ?>   
                            </td>
                            <?php endforeach; } ?>
                        </tr>
                        <tr>
                            <th class="text-uppercase align-middle"><?php echo display('brand'); ?></th>
                            <?php
                            if ($this->session->userdata('comparison_ids')) {
                                foreach ($comparison_products as $comparison):  
                            ?>
                            <td>
                                <?php echo html_escape($comparison['brand_name']); ?>   
                            </td>
                            <?php endforeach; } ?>
                        </tr>
                        <?php
                        if(!empty($comparison_products)){
                            $unit_arr = array_filter(array_column($comparison_products, 'unit'));
                            if(!empty($unit_arr)){
                        
                        ?>
                        <tr>
                            <th class="text-uppercase align-middle"><?php echo display('unit'); ?></th>
                            <?php
                                foreach ($comparison_products as $comparison):  
                            ?>
                            <td>
                                <?php echo html_escape($comparison['unit']); ?>   
                            </td>
                            <?php endforeach;  ?>
                        </tr>
                        <?php } } ?>
                        <tr>
                            <th class="text-uppercase align-middle"><?php echo display('variant'); ?></th>
                            <?php
                            if ($this->session->userdata('comparison_ids')) {
                                foreach ($comparison_products as $comparison):  
                            ?>
                            <td>
                                <p>
                                    <?php  
                                        $variants = explode(",",$comparison['variants']);
                                        $result="";
                                        foreach($variants as $variant) :
                                        $this->db->select('variant.variant_name');
                                        $this->db->from('variant');
                                        $this->db->where('variant_id',$variant);
                                        $query = $this->db->get();
                                        $variant = $query->row();
                                        $result.=$variant->variant_name.', '; 
                                        endforeach;
                                        $trimmed=rtrim($result, ', ');
                                        echo $trimmed;
                                    ?>
                                </p>  
                            </td>
                            <?php endforeach; } ?>
                        </tr>
                        <tr>
                            <th class="text-uppercase align-middle"><?php echo display('description'); ?></th>
                            <?php
                            if ($this->session->userdata('comparison_ids')) {
                                foreach ($comparison_products as $comparison):  
                            ?>
                            <td>
                                <?php echo character_limiter(strip_tags(htmlspecialchars_decode($comparison['description'])),200); ?>   
                            </td>
                            <?php endforeach; } ?>
                        </tr>
                        <tr>
                            <th class="text-uppercase align-middle"><?php echo display('action'); ?></th>
                            <?php
                            if ($this->session->userdata('comparison_ids')) {
                                foreach ($comparison_products as $comparison):  
                            ?>
                            <td class="align-center">
                                <?php if($is_aff){ 
                                    if($comparison['is_affiliate'] == 1 ){ ?>
                                        <a class="btn btn-warning btn-sm" title="<?php echo display('buy_now'); ?>" href="<?php echo html_escape($comparison['affiliate_url']) ?>" target="0">
                                            <i class="fa fa-shopping-cart"></i>
                                        </a>
                                <?php }else{ ?> 
                                    <a  href="javascript:void(0)" title="<?php echo display('add_to_cart'); ?>" class="btn btn-info btn-sm" onclick="add_to_cart_item('<?php echo $comparison['product_id']; ?>', '<?php echo remove_space($comparison['product_name']); ?>', '<?php echo $comparison['default_variant']; ?>', <?php echo $comparison['variant_price']; ?>);">
                                        <i class="fa fa-shopping-cart"></i>
                                    </a>
                                <?php } }else{ ?>
                                    <a  href="javascript:void(0)" class="btn btn-info btn-sm" onclick="add_to_cart_item('<?php echo $comparison['product_id']; ?>', '<?php echo remove_space($comparison['product_name']); ?>', '<?php echo $comparison['default_variant']; ?>', <?php echo $comparison['variant_price']; ?>);">
                                        <i class="fa fa-shopping-cart"></i>
                                    </a>
                                <?php }  ?>
                                <a  href="javascript:void(0)" class="delete_comparison btn btn-danger btn-sm" name="<?php echo $comparison['product_id'] ?>">
                                    <i class="fa fa-trash"></i>
                                </a>   
                            </td>
                            <?php endforeach; } ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
<!-- .cd-products-comparison-table -->
    