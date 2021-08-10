<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<link rel="stylesheet" href="<?php echo MOD_URL.'dashboard/assets/css/dashboard.css' ?>">


<!-- Add New Purchase Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_purchase') ?></h1>
            <small><?php echo display('add_new_purchase') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('purchase') ?></a></li>
                <li class="active"><?php echo display('add_purchase') ?></li>
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
        <div class="row">
            <div class="col-sm-12">
                <div class="column">
                    <?php if($this->permission->check_label('manage_purchase')->read()->access()){ ?>
                        <a href="<?php echo base_url('dashboard/Cpurchase/manage_purchase')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_purchase')?></a>  
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- Add New Purchase -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_purchase') ?></h4>
                        </div>
                    </div>

                    <div class="panel-body">
                    <?php echo form_open_multipart('dashboard/Cpurchase/insert_purchase',array('class' => 'form-vertical', 'id' => 'validate','name' => 'insert_purchase'))?>
                        
                        <div class="row">
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="supplier_sss" class="col-sm-4 col-form-label"><?php echo display('supplier') ?>
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-5">
                                        <select name="supplier_id" id="supplier_id" class="form-control " required=""> 
                                            <option value=""><?php echo display('select_one') ?></option>
                                            {all_supplier}
                                            <option value="{supplier_id}">{supplier_name}</option>
                                            {/all_supplier}
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <a href="<?php echo base_url('dashboard/Csupplier'); ?>"><?php echo display('add_supplier') ?></a>
                                    </div>
                                </div> 
                            </div>

                             <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label"><?php echo display('purchase_date') ?>
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <?php $date = date('m-d-Y'); ?>
                                        <input type="text" tabindex="3" class="form-control datepicker" name="purchase_date" value="<?php echo $date; ?>" id="date" required />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="invoice_no" class="col-sm-4 col-form-label"><?php echo display('invoice_no') ?>
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" tabindex="3" class="form-control" name="invoice_no" placeholder="<?php echo display('invoice_no') ?>" id="invoice_no" required />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="adress" class="col-sm-4 col-form-label"><?php echo display('details') ?>
                                    </label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" tabindex="1" id="adress" name="purchase_details" placeholder=" <?php echo display('details') ?>" rows="1"></textarea>
                                    </div>
                                </div> 
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6" id="-store_hide">
                                <div class="form-group row">
                                    <label for="store_id" class="col-sm-4 col-form-label"><?php echo display('purchase_to') ?>
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <select name="store_id" id="store_id" class="form-control width_100p" required="">
                                            <option value=""></option> 
                                            <?php foreach($store_list as $store):?>
                                            <option value="<?php echo html_escape($store['store_id'])?>" <?php echo ((@$def_store['store_id']==$store['store_id'])?'selected':'') ?>><?php echo html_escape($store['store_name']);?></option>
                                           <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php  if(check_module_status('woocommerce')) { ?>
                        <div id="store_stock_update" class="<?php echo (!empty($def_store['store_id'])?'':'none') ?>">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="store_id" class="col-sm-4 col-form-label"><?php echo display('stock') ?>
                                        </label>
                                        <div class="col-sm-8">
                                          <div class="checkbox checkbox-success">
                                            <input id="checkbox2" name="woocom_stock" value="1" type="checkbox">
                                            <label for="checkbox2"><?php echo display('update_woocommerce_stock') ?></label>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            "use strict";
                            $(document).ready(function(){
                                $('#store_id').on('change', function(){
                                    var store_id = $(this).val();
                                    var csrf_test_name=  $("#CSRF_TOKEN").val();
                                    $.ajax({
                                        url: base_url+'dashboard/Cpurchase/check_default_store',
                                        method: 'post',
                                        data: {
                                            csrf_test_name:csrf_test_name,
                                            store_id:store_id
                                        },
                                        success: function( data ) {
                                            if(data){
                                                $('#store_stock_update').show();
                                            }else{
                                                $('#store_stock_update').hide();
                                            }
                                        }
                                    });
                                });
                            });
                            
                        </script>
                        <?php } ?>

                        <div class="table-responsive mt_10">
                            <table class="table table-bordered table-hover" id="purchaseTable">
                                <thead>
                                    <tr>
                                        <th class="text-center"><?php echo display('item_information') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center" width="130"><?php echo display('variant') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center"><?php echo display('available_quantity') ?> </th>
                                        <th class="text-center"><?php echo display('quantity') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center"><?php echo display('rate') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center"><?php echo display('total') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center"><?php echo display('delete') ?> </th>
                                    </tr>
                                </thead>
                                <tbody id="addPurchaseItem">
                                    <tr>
                                        <td>
                                            <input type="text" name="product_name" required class="form-control product_name productSelection" onkeyup="product_pur_or_list(1);" placeholder="<?php echo display('product_name') ?>" id="product_name_1" tabindex="5" >

                                            <input type="hidden" class="autocomplete_hidden_value product_id_1" name="product_id[]" id="SchoolHiddenId"/>

                                            <input type="hidden" class="sl" value="1">
                                        </td>

                                        <td class="text-center">
                                            <div class="variant_id_div">
                                                <select name="variant_id[]" id="variant_id_1" class="form-control variant_id width_100p" required="">
                                                    <?php foreach($variant_list as $variant):?>
                                                    <option value="<?php echo html_escape($variant['variant_id'])?>"><?php echo html_escape($variant['variant_name'])?></option>
                                                <?php endforeach;?>
                                                </select>
                                            </div>
                                            <div id="color_variant_area_1">
                                                 <select name="color_variant[]" id="color_variant_1" class="form-control color_variant width_100p">
                                                    <option value=""></option>
                                                 </select>
                                            </div>
                                        </td>  

                                        <td class="text-right">
                                            <input type="number" id="avl_qntt_1" class="form-control text-right" placeholder="0" readonly />
                                        </td>

                                        <td class="text-right">
                                            <input type="number" name="product_quantity[]" id="total_qntt_1" onkeyup="calculate_add_purchase('1')" onchange="calculate_add_purchase('1')" class="form-control text-right" placeholder="0" min="0" required="" />
                                        </td>
                                        <td>
                                            <input type="number" name="product_rate[]"  id="price_item_1" class="price_item1 text-right form-control" placeholder="0.00" onkeyup="calculate_add_purchase('1')" onchange="calculate_add_purchase('1')" min="0"/>
                                        </td>
                                        <td class="text-right">
                                            <input class="total_price text-right form-control" type="text" name="total_price[]" id="total_price_1" placeholder="0.00" readonly="readonly" />
                                        </td>
                                        <td>
                                            <button  class="btn btn-danger text-right" type="button" value="<?php echo display('delete')?>" onclick="deleteRow(this)"><?php echo display('delete')?></button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">
                                            <input type="button" id="add-invoice-item" class="btn -btn-info color4 color5" name="add-invoice-item"  onClick="addPurchaseOrderField('addPurchaseItem');" value="<?php echo display('add_new_item') ?>" />

                                            <input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/>
                                        </td>
                                        <td class="text-right"><b><?php echo display('grand_total') ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="grandTotal" class="text-right form-control" name="grand_total_price" placeholder ="0.00" readonly="readonly" />
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <input type="submit" id="add-purchase" class="btn btn-primary btn-large" name="add-purchase" value="<?php echo display('submit') ?>" />
                                <input type="submit" value="<?php echo display('submit_and_add_another') ?>" name="add-purchase-another" class="btn btn-large btn-success" id="add-purchase-another">
                            </div>
                        </div>
                    <?php echo form_close()?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add New Purchase End -->
<script src="<?php echo MOD_URL.'dashboard/assets/js/add_purchase_form.js'; ?>"></script>
