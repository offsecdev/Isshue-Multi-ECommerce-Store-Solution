<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Payment type select by js start-->
<style>
    <?php
    if ($wearhouse_id) {
        echo "#store_hide{display:none;}";
    }else{
        echo "#wearhouse_hide{display:none;}";
    }
    ?>
</style>
<!-- Edit Purchase Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('purchase_edit') ?></h1>
            <small><?php echo display('purchase_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('purchase') ?></a></li>
                <li class="active"><?php echo display('purchase_edit') ?></li>
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

        <!-- Purchase report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('purchase_edit') ?></h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('dashboard/Cpurchase/purchase_update',array('class' => 'form-vertical', 'id' => 'validate'))?>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="description" class="col-sm-3 col-form-label"><?php echo display('supplier') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
                                        <!-- js-example-basic-single -->
                                        <select name="supplier_id" id="supplier_id" class="form-control " required=""> 
                                            {supplier_list}
                                            <option value="{supplier_id}">{supplier_name}</option>
                                            {/supplier_list}
                                            {supplier_selected}
                                            <option selected value="{supplier_id}">{supplier_name} </option>
                                            {/supplier_selected}
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <a href="<?php echo base_url('dashboard/Csupplier'); ?>"><?php echo display('add_supplier') ?></a>
                                    </div>
                                </div> 
                            </div>

                             <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="product_name" class="col-sm-4 col-form-label"><?php echo display('purchase_date') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input type="text" tabindex="3" class="form-control datepicker" name="purchase_date" value="{purchase_date}" required />
                                        <input type="hidden" name="purchase_id" value="{purchase_id}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                             <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="product_name" class="col-sm-3 col-form-label"><?php echo display('invoice_no') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-9">
                                        <input type="text" tabindex="3" class="form-control" name="invoice_no" placeholder="<?php echo display('invoice_no') ?>" required value="{invoice_no}" />
                                    </div>
                                </div>
                            </div>
                           
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="adress" class="col-sm-4 col-form-label"><?php echo display('details') ?></label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" tabindex="1" id="adress" name="purchase_details" placeholder=" <?php echo display('details') ?>">{purchase_details}</textarea>
                                    </div>
                                </div> 
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6" id="-store_hide">
                                <div class="form-group row">
                                    <label for="store_id" class="col-sm-3 col-form-label"><?php echo display('purchase_to') ?>
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-9">
                                        <select name="store_id" id="store_id" class="form-control width_100p" required="">
                                            <option value=""></option> 
                                            <?php
                                            if ($store_list) {
                                                foreach ($store_list as $store) {
                                            ?>
                                            <option value="<?php echo html_escape($store['store_id'])?>" <?php if ($store['store_id'] == $store_id) {echo "selected";}?>><?php echo html_escape($store['store_name'])?></option>
                                                   <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                        if(check_module_status('woocommerce')) {
                            $defstore_status = $this->db->where('store_id', $store_id)->where('default_status',1)->get('store_set');
                        ?>
                        <div id="store_stock_update" class="<?php echo (($defstore_status->num_rows() > 0)?'':'none'); ?>">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="store_id" class="col-sm-3 col-form-label"><?php echo display('stock') ?>
                                        </label>
                                        <div class="col-sm-9">
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
                                        <th class="text-center"><?php echo display('action') ?> </th>
                                    </tr>
                                </thead>
                				<tbody id="addPurchaseItem">
                                <?php
                                if($purchase_info){
                                    foreach ($purchase_info as $purchase) {

                                        //Stock available qty variant wise
                                        $this->db->select('SUM(a.quantity) as total_purchase');
                                        $this->db->from('product_purchase_details a');
                                        $this->db->where('a.product_id',$purchase['product_id']);
                                        $this->db->where('a.variant_id',$purchase['variant_id']);
                                        if (!empty($purchase['wearhouse_id'])) {
                                        $this->db->where('a.wearhouse_id',$purchase['wearhouse_id']);
                                        }else{
                                        $this->db->where('a.store_id',$purchase['store_id']);
                                        }
                                        $total_purchase = $this->db->get()->row();

                                        //Total purchase
                                        $this->db->select('SUM(b.quantity) as total_sale');
                                        $this->db->from('invoice_details b');
                                        $this->db->where('b.product_id',$purchase['product_id']);
                                        $this->db->where('b.variant_id',$purchase['variant_id']);

                                        if (!empty($purchase['wearhouse_id'])) {
                                        $this->db->where('b.status',1);
                                        }else{
                                        $this->db->where('b.store_id',$purchase['store_id']);
                                        }
                                        $total_sale = $this->db->get()->row();

                                        //Variant for per product
                                        $this->db->select('a.variants');
                                        $this->db->from('product_information a');
                                        $this->db->where(array('a.product_id' => $purchase['product_id'],'a.status' => 1)); 
                                        $product_information = $this->db->get()->row();
                                        $exploded = explode(',',$product_information->variants);

                                        $this->db->select('*');
                                        $this->db->from('variant');
                                        $this->db->where_in('variant_id',$exploded);
                                        $this->db->order_by('variant_name','asc');
                                        $pvariants = $this->db->get()->result_array();
                                        $vtypes_arr = array_column($pvariants, 'variant_type');

                                ?>
        							<tr>
        								<td>
                                            <input type="text" name="product_name" required class="form-control product_name productSelection" onkeyup="product_pur_or_list(<?php echo $purchase['sl']?>);" placeholder="<?php echo display('product_name') ?>" id="product_name_<?php echo $purchase['sl']?>" tabindex="5" value="<?php echo $purchase['product_name'].'-('.$purchase['product_model']?>)">

                                            <input type="hidden" class="autocomplete_hidden_value product_id_<?php echo $purchase['sl']?>" name="product_id[]" id="" value="<?php echo html_escape($purchase['product_id'])?>" />

                                            <input type="hidden" class="sl" value="<?php echo $purchase['sl']?>">
                                        </td>

                                        <td class="text-center">
                                            <div class="variant_id_div">
                                                <select name="variant_id[]" id="variant_id_<?php echo $purchase['sl']?>" class="form-control variant_id width_100p" required="">
                                                    <option value=""></option>
                                                <?php
                                                if(!empty($pvariants)){
                                                    foreach ($pvariants as $vitem) {
                                                        if($vitem['variant_type'] == 'size'){
                                                ?>
                                                <option value="<?php echo html_escape($vitem['variant_id'])?>" <?php if($purchase['variant_id'] == $vitem['variant_id']){echo "selected";}?>><?php echo html_escape($vitem['variant_name'])?></option>
                                                <?php 
                                                        }
                                                    }
                                                }
                                                ?>
                                                </select>
                                            </div>
                                            <?php if(in_array('color', $vtypes_arr)){ ?>
                                            <div>
                                                <select name="color_variant[]" id="color_variant_<?php echo $purchase['sl']?>" class="form-control color_variant width_100p">
                                                    <option value=""></option>
                                               <?php
                                                if(!empty($pvariants)){
                                                    foreach ($pvariants as $vitem) {
                                                        if($vitem['variant_type'] == 'color'){
                                                ?>
                                                <option value="<?php echo html_escape($vitem['variant_id'])?>" <?php if($purchase['variant_color'] == $vitem['variant_id']){echo "selected";}?>><?php echo html_escape($vitem['variant_name'])?></option>
                                                <?php 
                                                        }
                                                    }
                                                }
                                                ?>
                                                </select>
                                            <?php }else{ ?>
                                                <input type="hidden" name="color_variant[]" id="variant_color_id<?php echo $purchase['sl']?>">
                                            <?php } ?>
                                            </div>
                                        </td> 

                                        <td class="text-right">
                                            <input type="number" id="avl_qntt_<?php echo $purchase['sl']?>" class="form-control text-right" placeholder="0" readonly value="<?php echo html_escape($total_purchase->total_purchase - $total_sale->total_sale);?>"/>
                                        </td>  

                                        <td class="text-right">
                                            <input type="number" name="product_quantity[]" onkeyup="calculate_add_purchase(<?php echo $purchase['sl']?>);" onchange="calculate_add_purchase(<?php echo $purchase['sl']?>);" id="total_qntt_<?php echo $purchase['sl']?>"  class="form-control text-right" placeholder="0" value="<?php echo html_escape($purchase['quantity'])?>" min="0" required/>
                                        </td>
                                        <td>
                                            <input type="number" name="product_rate[]" value="<?php echo html_escape($purchase['rate'])?>"  id="price_item_<?php echo $purchase['sl']?>" class="price_item<?php echo $purchase['sl']?> text-right form-control" onkeyup="calculate_add_purchase(<?php echo $purchase['sl']?>);" onchange="calculate_add_purchase(<?php echo $purchase['sl']?>);" placeholder="0.00" min="0" required/>
                                        </td>
                                        <td class="text-right">
                                            <input class="total_price text-right form-control" value="<?php echo html_escape($purchase['total_amount'])?>" type="text" name="total_price[]" id="total_price_<?php echo $purchase['sl']?>" readonly="readonly" />
                                        
        									<input type="hidden" name="purchase_detail_id[]" value="<?php echo html_escape($purchase['purchase_detail_id'])?>"/>
        								</td>
                                        <td>
                                            <button class="btn btn-danger text-right" type="button" value="<?php echo display('delete')?>" onclick="deleteRow(this)"><?php echo display('delete')?></button>
                                        </td>
        							</tr>
                                <?php
                                    }
                                }
                                ?>
        						</tbody>
        						<tfoot>
        							<tr>
        								<td colspan="4">

                                            <input type="button" id="add-invoice-item" class="btn -btn-info color4 color5" name="add-invoice-item"  onClick="addPurchaseOrderField('addPurchaseItem');" value="<?php echo display('add_new_item') ?>" />

                                            <input type="submit" id="add-purchase" class="btn btn-success btn-large" name="add-purchase" value="<?php echo display('save_changes') ?>" />
                                            <input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/>                        
                                        </td>
        								<td class="text-right"  ><b><?php echo display('grand_total') ?>:</b></td>
        								<td class="text-right">
                                            <input type="text" id="grandTotal" value="{grand_total}" class="text-right form-control" name="grand_total_price" value="0.00" readonly="readonly" />
        								</td>
        							</tr>
        						</tfoot>
                            </table>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Edit Purchase End -->
<script src="<?php echo MOD_URL.'dashboard/assets/js/edit_purchase_form.js'; ?>"></script>

