<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('stock_report_order_wise') ?></h1>
            <small><?php echo display('stock_report_order_wise') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('stock') ?></a></li>
                <li class="active"><?php echo display('stock_report_order_wise') ?></li>
            </ol>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('stock_report_order_wise') ?></h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div id="printableArea" class="ml_2">
                            <div class="table-responsive mt_10">
                                <table id="" class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th class="text-center"><?php echo display('sl') ?></th>
                                        <th class="text-center"><?php echo display('store_name') ?></th>
                                        <th class="text-center"><?php echo display('product_name') ?></th>
                                        <th class="text-center"><?php echo display('variant') ?></th>
                                        <th class="text-center"><?php echo display('quantity') ?></th>
                                        <th class="text-center"><?php echo display('order') ?></th>
                                        <th class="text-center"><?php echo display('stock') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if ($store_product_list) {
                                        ?>
                                        <?php foreach($store_product_list as $product):
                                            $stock =  $product['quantity'] - $product['sell']; ?>
                                            <tr>
                                                <td class="text-center"><?php echo html_escape($product['sl']) ?></td>
                                                <td class="text-center"><?php echo html_escape($product['store_name'])?></td>
                                                <td class="text-center"><a href="<?php echo base_url('dashboard/Cproduct/product_details/'.$product['product_id'])?>">
                                                        <?php echo html_escape($product['product_name'])?>-(<?php echo html_escape($product['product_model'])?>)</a></td>
                                                <td class="text-center"><?php echo html_escape($product['variant_name'])?></td>
                                                <td class="text-center"><?php echo html_escape($product['quantity'])?></td>
                                                <td class="text-center"><?php echo html_escape($product['sell'])?></td>
                                                <?php if($stock < 10){?>
                                                    <td class="text-center text-danger"><strong><?php echo html_escape($stock);?></strong></td>
                                                <?php }else{?>
                                                    <td class="text-center"><?php echo html_escape($stock);?></td>
                                                <?php }?>
                                            </tr>
                                        <?php
                                        endforeach;
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="text-center"><?php echo htmlspecialchars_decode($links); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Stock List Supplier Wise End -->
