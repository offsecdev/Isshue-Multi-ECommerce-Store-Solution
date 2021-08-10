<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Product js php -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/product.js.php" ></script>

<script src="<?php echo MOD_URL.'dashboard/assets/js/print.js'; ?>"></script>

<!-- Stock List Supplier Wise Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('stock_report_store_wise') ?></h1>
            <small><?php echo display('stock_report_store_wise') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('stock') ?></a></li>
                <li class="active"><?php echo display('stock_report_store_wise') ?></li>
            </ol>
        </div>
    </section>

    <section class="content">


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


        <div class="row">
            <div class="col-sm-12">
                <div class="column">
                    <?php if($this->permission->check_label('stock_report')->read()->access()){ ?>
                    <a href="<?php echo base_url('dashboard/Creport')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i><?php echo display('stock_report')?></a>
                    <?php }if($this->permission->check_label('stock_report_product_wise')->read()->access()){ ?>
                    <a href="<?php echo base_url('dashboard/Creport/stock_report_product_wise')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i><?php echo display('stock_report_product_wise')?></a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <?php 
        date_default_timezone_set(DEF_TIMEZONE);
         $today = date('Y-m-d');
        $this_month = date('Y-m-01');
        ?>

        <!-- Stock report supplier wise -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <?php echo form_open('dashboard/Creport/stock_report_store_wise',array('class' => '','id' => 'validate'
                        ,'method'=>'GET'));?>
                        

                        <div class="form-group row">
                            <label for="store_id" class="col-sm-2 col-form-label"><?php echo display('store')?>:</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="store_id" id="store_id"  required="">
                                    <option value=""></option>
                                    <?php foreach ($store_list as $single_store):
                                        if(1 == $single_store['default_status']){
                                            ?>

                                            <option selected value="<?php echo html_escape($single_store['store_id'])?>">
                                                <?php echo html_escape($single_store['store_name'])?>
                                            </option>
                                        <?php }else{?>
                                            <option value="<?php echo html_escape($single_store['store_id'])?>">
                                                <?php echo html_escape($single_store['store_name'])?>
                                            </option>
                                        <?php } endforeach;?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="product_id" class="col-sm-2 col-form-label"><?php echo display('product') ?>:</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="product_id" id="product_id"  required="">
                                    <option value=""></option>
                                    <?php foreach ($product_list as $product_item){ ?>
                                        <option value="<?php echo $product_item['product_id'] ?>" <?php echo (($product_item['product_id']==@$_GET['product_id'])?'selected':'') ?>><?php echo $product_item['product_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="from_date" class="col-sm-2 col-form-label"><?php echo display('start_date') ?>:</label>
                            <div class="col-sm-4">
                                <input type="text" name="from_date" class="form-control datepicker1"
                                       id="from_date" value="<?php echo $getID = $this->input->get('from_date',TRUE) ? $this->input->get('from_date',TRUE) : $this_month; ?>" placeholder="<?php echo
                                display('start_date') ?>" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="to_date" class="col-sm-2 col-form-label"><?php echo display('end_date') ?>:</label>
                            <div class="col-sm-4">
                                <input type="text" name="to_date" class="form-control datepicker1" id="to_date" value="<?php echo $getID = $this->input->get('to_date',TRUE) ? $this->input->get('to_date',TRUE) : $today; ?>" placeholder="<?php echo display('end_date') ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="supplier_name" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-primary"><?php echo display('search') ?></button>
                                <a  class="btn btn-warning" href="#" onclick="printDiv('printableArea')"><?php echo display('print') ?></a>
                            </div>
                        </div>
                        <?php echo form_close()?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('stock_report_store_wise') ?></h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div id="printableArea" class="ml_2">
                            <?php
                            if ($company_info) {
                                ?>
                                <div class="text-center">
                                    {company_info}
                                    <h3> {company_name} </h3>
                                    <h4><?php echo display('address') ?> : {address} </h4>
                                    <h4 ><?php echo display('mobile') ?> : {mobile} </h4>
                                    {/company_info}
                                    <h4> <?php echo display('print_date') ?>: <?php echo date("m/d/Y h:i:s"); ?> </h4>
                                    <h4 class="uppercase"><b><?php echo ucfirst(@$stok_report[0]['store_name'])?></b></h4>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="table-responsive mt_10">
                                <table id="" class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th class="text-center"><?php echo display('sl') ?></th>
                                        <th class="text-center" width="30%"><?php echo display('product_name') ?></th>
                                        <th class="text-center"><?php echo display('variant') ?></th>
                                        <th class="text-center"><?php echo display('sell_price') ?></th>
                                        <th class="text-center"><?php echo display('supplier_price') ?></th>
                                        <th class="text-center"><?php echo display('purchase') ?></th>
                                        <th class="text-center"><?php echo display('sell') ?></th>
                                        <th class="text-center"><?php echo display('transfer_quantity') ?></th>
                                        <th class="text-center"><?php echo display('receive_quantity') ?></th>
                                        <th class="text-center"><?php echo display('stock') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if (!empty($stok_report)) {
                                        foreach ($stok_report as $stock) {
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $stock['sl']; ?></td>
                                            <td align="center">
                                                <a href="<?php echo base_url().'dashboard/Cproduct/product_details/'.$stock['product_id']; ?>"> <?php echo $stock['product_name']; ?> - (<?php echo $stock['product_model']; ?>) <i class="fa fa-shopping-bag pull-right" aria-hidden="true"></i>
                                                </a>
                                            </td>

                                            <td align="center"><?php echo $stock['variant_name'].(!empty($stock['variant_color'])?', '.$stock['variant_color_name']:''); ?> </td>
                                            <td class="text-center"><?php echo (($position==0)?"$currency ".$stock['price']:$stock['price']." $currency") ?></td>
                                            <td class="text-center"><?php echo (($position==0)?"$currency ".$stock['supplier_price']:$stock['supplier_price']." $currency") ?></td>
                                            <td align="center"><?php echo $stock['in_qnty']; ?></td>
                                            <td align="center"><?php echo $stock['out_qnty']; ?></td>
                                            <td align="center"><?php echo $stock['issue_qty']; ?></td>
                                            <td align="center"><?php echo $stock['rec_qty']; ?></td>
                                            <td align="center"><?php echo $stock['stok_quantity']; ?></td>
                                        </tr>
                                        <?php } } ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="9" align="right"><b><?php echo display('grand_total')?>:</b></td>
                                        <td align="center"><b>{sub_total_stock}</td>

                                    </tr>
                                    </tfoot>
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
<script src="<?php echo MOD_URL.'dashboard/assets/js/stock_report_variant_wise.js'; ?>"></script>
