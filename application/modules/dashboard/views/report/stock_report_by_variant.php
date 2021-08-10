<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Product js php -->
<script src="<?php echo base_url() ?>my-assets/js/admin_js/json/product.js.php"></script>


<!-- Stock List Supplier Wise Start -->
<div class="content-wrapper">
<section class="content-header">
<div class="header-icon">
    <i class="pe-7s-note2"></i>
</div>
<div class="header-title">
    <h1><?php echo display('stock_report_variant_wise') ?></h1>
    <small><?php echo display('stock_report_variant_wise') ?></small>
    <ol class="breadcrumb">
        <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
        <li><a href="#"><?php echo display('stock') ?></a></li>
        <li class="active"><?php echo display('stock_report_variant_wise') ?></li>
    </ol>
</div>
</section>

<section class="content">
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4><?php echo display('stock_report_variant_wise') ?></h4>
                </div>
            </div>
            <div class="panel-body">
                <div id="printableArea" class="ml_2">
                    <div class="table-responsive mt_10">
                        <table id="" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th class="text-center"><?php echo display('product_name') ?></th>
                                <th class="text-center"><?php echo display('variant_name') ?></th>
                                <th class="text-center"><?php echo display('purchase') ?></th>
                                <th class="text-center"><?php echo display('sales') ?></th>
                                <th class="text-center"><?php echo display('stock') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if ($products) {
                                $i = 1;
                                $total_purchase=0;
                                $total_sale=0;
                                $total_stock=0;
                                ?>
                                <?php $total_variant = count($products); ?>
                                <?php foreach ($products as $product): ?>
                                    <?php foreach ($product as $v_product): ?>
                                        <tr>
                                            <?php if (1 == $i) { ?>
                                                <td rowspan="<?php echo html_escape($total_variant); ?>"><?php echo html_escape($product_name); ?></td>
                                            <?php }
                                            $i++; ?>
                                            <td align="center"><?php echo html_escape($v_product['variant_name']) ?></td>
                                            <td align="center"><?php echo html_escape($v_product['totalPurchaseQnty']); $total_purchase+= $v_product['totalPurchaseQnty'];?></td>
                                            <td align="center"><?php echo html_escape($v_product['totalSalesQty']); $total_sale+=$v_product['totalSalesQty']; ?></td>
                                            <td align="center"><?php echo $v_product['totalPurchaseQnty'] - $v_product['totalSalesQty']; $total_stock+=($v_product['totalPurchaseQnty'] - $v_product['totalSalesQty']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                                <?php
                            }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="2" align="right"><b><?php echo display('grand_total')?>:</b></td>
                                <td align="center"><b><?php echo html_escape($total_purchase);?></td>
                                <td align="center"><b><?php echo html_escape($total_sale);?></td>
                                <td align="center"><b><?php echo html_escape($total_stock);?></td>

                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
</div>
<!-- Stock List Supplier Wise End -->

