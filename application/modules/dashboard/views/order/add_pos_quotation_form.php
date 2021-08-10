<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<!-- Customer js php -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/customer.js.php" ></script>
<!-- Product invoice js -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/product_invoice.js.php" ></script>
<!-- Invoice js -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/invoice.js" type="text/javascript"></script>
<!-- Order CSS -->
<link rel="stylesheet" href="<?php echo MOD_URL.'dashboard/assets/css/dashboard.css' ?>">

<!-- Add New Invoice Start -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<div class="header-icon"><i class="pe-7s-close"></i></div>
<div class="header-title">
    <h1><?php echo display('pos_invoice')?></h1>
    <small><?php echo display('new_pos_invoice')?></small>
    <ol class="breadcrumb">
        <li><a href="#"><?php echo display('home')?></a></li>
        <li class="active"><?php echo display('pos_invoice')?></li>
    </ol>
</div>
</section>
<!-- Main content -->
<div class="content">
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
    if (isset($error_message)) {
?>
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?php echo $error_message ?>                    
</div>
<?php 
    $this->session->unset_userdata('error_message');
    }
?>

<!-- Print order for customer -->
<div id="order_tbl">
    <span id="order_span">
        
    </span>

    <table id="order-table" class="prT table table-striped mb_0" width="100%">
        <tbody>
            
        </tbody>
    </table>
</div>
<!-- End Print order for customer -->

<!-- Print bill for customer -->
<div id="bill_tbl">
    <span id="bill_span">
       
    </span>
    <table id="bill-table" width="100%" class="prT table table-striped mb_0">
        <tbody>
            
        </tbody>
    </table>
    <table id="bill-total-table" class="prT table mb_0" width="100%">
        <tbody>
            <tr class="bold">
                <td><?php echo display('total_cgst')?></td>
                <td class="total_cgst_bill text-right" >0</td>
            </tr>      
            <tr class="bold">
                <td><?php echo display('total_sgst')?></td>
                <td class="total_sgst_bill text-right">0</td>
            </tr>
            <tr class="bold">
                <td><?php echo display('total_igst')?></td>
                <td class="total_igst_bill text-right">0</td>
            </tr>    
            <tr class="bold">
                <td><?php echo display('total_discount')?></td>
                <td class="total_discount_bill text-right">0</td>
            </tr>
            <tr class="bold">
                <td class=""><?php echo display('grand_total')?></td>
                <td class="total_bill  text-right">00</td>
            </tr>
            <tr class="bold">
                <td><?php echo display('items')?></td>
                <td class="item_bill  text-right">0</td>
            </tr>
        </tbody>
    </table>
    <span id="bill_footer"><p class="text-center"><br><?php echo display('merchant_copy')?></p></span>
</div>
<!-- End Print bill for customer -->


<?php echo form_open('Cinvoice/insert_customer', array('class' => 'form-vertical','id' => 'validate'))?>
    <div class="modal fade modal-warning" id="client-info" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title"><?php echo display('add_customer')?></h3>
                </div>
                
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label"><?php echo display('name') ?> <i class="text-danger">*</i></label>
                        <div class="col-sm-6">
                            <input class="form-control simple-control" name ="customer_name" id="name" type="text" placeholder="<?php echo display('customer_name') ?>"  required="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label"><?php echo display('email') ?> <i class="text-danger">*</i></label>
                        <div class="col-sm-6">
                            <input class="form-control" name ="email" id="email" type="email" placeholder="<?php echo display('customer_email') ?>"  required="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="mobile" class="col-sm-3 col-form-label"><?php echo display('mobile') ?> <i class="text-danger">*</i></label>
                        <div class="col-sm-6">
                            <input class="form-control" name ="mobile" id="mobile" type="number" placeholder="<?php echo display('customer_mobile') ?>"  required="" min="0">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="address " class="col-sm-3 col-form-label"><?php echo display('address') ?></label>
                        <div class="col-sm-6">
                            <textarea class="form-control" name="address" id="address " rows="3" placeholder="<?php echo display('customer_address') ?>"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo display('close')?> </button>
                    <button type="submit" class="btn btn-success"><?php echo display('submit')?> </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php echo form_close(); ?>

<div class="modal fade modal-warning" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title"></h3>
            </div>
            <?php echo form_open("", array('id' => 'updateCart')); ?>
                <div class="modal-body">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th class="width_25p"><?php echo display('price')?></th>
                                <th class="width_25p"><span id="net_price" class="price"></span></th>
                            </tr>
                        </tbody>
                    </table>
      
                    <div class="form-group row">
                        <label for="available_quantity" class="col-sm-4 col-form-label"><?php echo display('available_quantity')?></label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" id="available_quantity" placeholder="<?php echo display('available_quantity')?>" name="available_quantity" readonly="readonly">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="unit" class="col-sm-4 col-form-label"><?php echo display('unit')?></label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" id="unit" placeholder="<?php echo display('unit')?>" name="unit" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="<?php echo display('quantity')?>" class="col-sm-4 col-form-label"><?php echo display('quantity')?> <span class="color-red">*</span></label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" id="<?php echo display('quantity')?>" name="quantity">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="<?php echo display('rate')?>" class="col-sm-4 col-form-label"><?php echo display('rate')?> <span class="color-red">*</span></label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" id="<?php echo display('rate')?>" name="rate">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="<?php echo display('discount')?>" class="col-sm-4 col-form-label"><?php echo display('discount')?></label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" id="<?php echo display('discount')?>" placeholder="<?php echo display('discount')?>" name="discount">
                        </div>
                    </div>
                    <input type="hidden" name="rowID">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo display('close')?></button>
                    <button type="submit" class="btn btn-success"><?php echo display('save_changes')?></button>
                </div>
            <?php echo form_close() ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="row">
    <div class="col-sm-8">
        <?php echo form_open("", array('class' => 'navbar-search', 'method' => 'GET')); ?>

            <label class="sr-only screen-reader-text" for="search"><?php echo display('search')?>:</label>
            <div class="input-group">
                <input type="text" id="product_name" class="form-control search-field" dir="ltr" value="" name="s" placeholder="<?php echo display('search_by_product')?>" />

                <div class="input-group-addon search-categories">
                    <select name='category_id' id='category_id' class='postform resizeselect form-control' >
                        <option value='0' selected='selected'>All Categories</option>
                    <?php
                    if ($category_list) {
                        foreach ($category_list as $category) {
                        ?>
                        <option value="<?php echo html_escape($category->category_id)?>"><?php echo html_escape($category->category_name)?></option>
                        <?php
                        }
                    }
                    ?>
                    </select>
                </div>
                <div class="input-group-btn">
                    <button type="button" class="btn btn-secondary" id="search_button"><i class="ti-search"></i></button>
                </div>
            </div>
        <?php echo form_close() ?>
        <div class="product-grid">
            <div class="row row-m-3" id="product_search">
            <?php
            if ($product_list) {
                foreach ($product_list as $product) {
            ?>
                <div class="col-xs-6 col-sm-4 col-md-2 col-p-3">
                    <div class="panel panel-bd product-panel select_product">
                        <div class="panel-body">
                            <img src="<?php echo $product->image_thumb?>" class="img-responsive" alt="">
                            <input type="hidden" name="select_product_id" class="select_product_id" value="<?php echo html_escape($product->product_id)?>">
                        </div>
                        <div class="panel-footer"><?php echo html_escape($product->product_model .'-'. $product->product_name)?></div>
                    </div>
                </div>
            <?php
                }
            }
            ?>
            </div>
        </div>
    </div>   
    <div class="col-sm-4">
    <?php echo form_open_multipart('Cinvoice/insert_invoice',array('class' => 'form-vertical', 'id' => 'validate'))?>
        <div class="panel panel-bd">
            <div class="panel-body">
                <div class="client-add">
                    <div class="form-group">
                        <label for="customer_name"><?php echo display('customer_name')?> <span class="color-red">*</span></label>
                        <select id="customer_name" class="form-control" name="customer_id" required="">
                            <?php
                            if ($customer_details) {
                                foreach ($customer_details as $customer) {
                                ?>
                                    <option value="<?php echo html_escape($customer->customer_id)?>"><?php echo html_escape($customer->customer_name)?></option>
                                <?php
                                }
                            }
                            ?>
                            <optgroup label="Others">
                            <?php
                            if ($customer_list) {
                                foreach ($customer_list as $customer_det) {
                                ?>
                                    <option value="<?php echo html_escape($customer_det->customer_id)?>"><?php echo html_escape($customer_det->customer_name)?></option>
                                <?php
                                }
                            }
                            ?>
                            </optgroup>
                        </select>
                    </div>
                    <a href="#" class="client-add-btn" aria-hidden="true" data-toggle="modal" data-target="#client-info"><i class="ti-plus m-r-2"></i><?php echo display('new_customer')?> </a>
                </div>

                <div class="form-group">
                    <label for="store_name"><?php echo display('store_name')?> <span class="color-red">*</span></label>
                    <select id="store_name" class="form-control" name="store_id" required="">
                        <option value=""></option>
                        <?php
                        if ($store_list) {
                            foreach ($store_list as $store) {
                            ?>
                                <option value="<?php echo html_escape($store->store_id)?>"><?php echo html_escape($store->store_name)?></option>
                            <?php
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <input type="text" name="product_name" class="form-control" placeholder='<?php echo display('barcode_qrcode_scan_here') ?>' id="add_item" autocomplete='off'>
                    <?php 
date_default_timezone_set(DEF_TIMEZONE); $date = date('m-d-Y'); ?>
                    <input class="form-control" type="hidden" id="invoice_date" name="invoice_date" required value="<?php echo html_escape($date); ?>" />
                    <input type="hidden" id="product_value" name="">
                </div>
                
                <div class="product-list">
                    <div class="table-responsive">
                        <table class="table table-bordered" border="1" width="100%" id="addinvoice">
                            <thead>
                                <tr>
                                    <th><?php echo display('item')?></th>
                                    <th><?php echo display('price')?></th>
                                    <th><?php echo display('quantity')?></th>
                                    <th><?php echo display('total')?></th>
                                    <th width="19%"><?php echo display('action')?></th>
                                </tr>
                            </thead>
                            <tbody class="itemNumber">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="table-responsive total-price">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row"><?php echo display('item') ?></th>
                                <td id="item-number">0</td>
                                <th><?php echo display('total_cgst') ?></th>
                                <td><input type="text" id="total_cgst" class="form-control text-right" name="total_cgst" tabindex="-1" value="0.00" readonly="readonly" /></td>
                            </tr>
                            <tr>
                                <th scope="row"><?php echo display('total_sgst') ?></th>
                                <td><input type="text" id="total_sgst" class="form-control text-right" name="total_sgst" tabindex="-1" value="0.00" readonly="readonly" /></td>
                                <th><?php echo display('total_igst') ?></th>
                                <td><input type="text" id="total_igst" class="form-control text-right" name="total_igst" tabindex="-1" value="0.00" readonly="readonly" /></td>
                            </tr>
                            <tr>
                                <th scope="row"><?php echo display('total_discount') ?></th>
                                <td><input type="text" id="total_discount_ammount" class="form-control text-right" name="total_discount" tabindex="-1" value="0.00" readonly="readonly" /></td>
                                
                                <th><?php echo display('invoice_discount') ?></th>
                                <td><input type="text" id="invoice_discount" class="form-control text-right" name="invoice_discount" tabindex="-1" value="0.00" onkeyup="quantity_calculate(1);" onchange="quantity_calculate(1);"/></td>
                            </tr>

                            <tr>
                                <th><?php echo display('grand_total') ?></th>
                                <td><input type="text" id="grandTotal" tabindex="-1" class="form-control text-right" name="grand_total_price" value="0.00" readonly="readonly" /></td>
                                <th scope="row"><?php echo display('paid_ammount') ?></th>
                                <td>
                                    <input type="text" id="paidAmount" 
                                    onkeyup="invoice_paidamount();"  tabindex="-1" class="form-control text-right" name="paid_amount" value="0.00" />
                                 </td>
                                
                            </tr>

                             <tr>
                                <th><?php echo display('due') ?></th>
                                <td><input type="text" id="dueAmmount" class="form-control text-right" name="due_amount" value="0.00" readonly="readonly"/></td>
                                <th></th>
                                <td></td>
                            </tr>

                            <!-- Payment method -->
                            <tr class="payment_method none">
                                <td colspan="7">
                                     <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label for="terminal" class="col-sm-4 col-form-label"><?php echo display('terminal') ?>:</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" name="terminal" id="terminal" required="">
                                                    <option value=""></option>
                                                        {terminal_list}
                                                        <option value="{pay_terminal_id}">{terminal_name}</option>
                                                        {/terminal_list}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label for="card_type" class="col-sm-4 col-form-label"><?php echo display('card_type') ?>: </label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" name="card_type" id="card_type" required="">
                                                        <option>Credit Card</option>
                                                        <option>Debit Card</option>
                                                        <option>Master Card</option>
                                                        <option>Amex</option>
                                                        <option>Visa</option>
                                                        <option>Paypal</option>
                                                        <option>Others</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                            <label for="card_no" class="col-sm-4 col-form-label"><?php echo display('card_no') ?>:</label>
                                                <div class="col-sm-8">
                                                <input class="form-control" type="text" name="card_no" id="card_no" placeholder="<?php echo display('card_no') ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <button type="button" class="btn btn-info m-b-5" onclick="printDiv('order_tbl')"><?php echo display('print_order')?></button>
                <button type="button" class="btn btn-success m-b-5" onclick="printDiv('bill_tbl')"><?php echo display('print_bill')?></button>
                <input  class="btn btn-warning m-b-5" value="<?php echo display('full_paid') ?>" onclick="full_paid();" type="button">
                <button type="button" class="btn btn-purple m-b-5 payment_button"><?php echo display('payment')?></button>
                <button type="button" class="btn btn-danger m-b-5"><?php echo display('cancel')?></button>
                <button type="submit" class="btn btn-purple m-b-5"><?php echo display('submit')?></button>
            </div>
        </div>
    <?php echo form_close();?>
    </div>
</div>
</div> 
<!-- /.content -->
</div>
<!-- POS Invoice Report End -->


<input type="hidden" id="user_name" value="<?php echo $this->session->userdata('user_name'); ?>">
<script src="<?php echo MOD_URL.'dashboard/assets/js/add_pos_quotation_form.js'; ?>"></script>
