<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Customer js php -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/customer.js.php" ></script>
<!-- Product invoice js -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/product_customer_order.js.php" ></script>
<!-- invoice js -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/invoice.js" type="text/javascript"></script>

<!-- Add new order start -->
<div class="content-wrapper">
<section class="content-header">
<div class="header-icon">
<i class="pe-7s-note2"></i>
</div>
<div class="header-title">
<h1><?php echo display('order') ?></h1>
<small><?php echo display('new_order') ?></small>
<ol class="breadcrumb">
    <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
    <li><a href="#"><?php echo display('order') ?></a></li>
    <li class="active"><?php echo display('order') ?></li>
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
      <a href="<?php echo base_url('customer/order/manage_order')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_order')?></a>
    </div>
</div>
</div>

<!--Add order -->
<div class="row">
<div class="col-sm-12">
    <div class="panel panel-bd lobidrag">
        <div class="panel-heading">
            <div class="panel-title">
                <h4><?php echo display('order') ?></h4>
            </div>
        </div>
        <?php echo form_open_multipart('customer/insert_order',array('class' => 'form-vertical', 'id' => 'validate'))?>
        <div class="panel-body">

            <!-- Input hidden value start-->
            <?php 
                
date_default_timezone_set(DEF_TIMEZONE); $date = date('m-d-Y'); 
                $result = $this->db->select('*')
                                ->from('store_set')
                                ->where('default_status','1')
                                ->get()
                                ->row();
            ?>
            <input type="hidden" name="invoice_date" value="<?php echo html_escape($date); ?>" />
            <input type="hidden" name="customer_id" value="<?php echo $this->session->userdata('customer_id')?>">
            <input type="hidden" name="store_id" id="store_id" value="<?php echo html_escape($result->store_id)?>">
            <!-- Input hidden value end-->


            <div class="table-responsive mt_10">
                <table class="table table-bordered table-hover" id="normalinvoice">
                    <thead>
                        <tr>
                            <th class="text-center"><?php echo display('item_information') ?> <i class="text-danger">*</i></th>
                            <th class="text-center" width="130"><?php echo display('variant') ?> <i class="text-danger">*</i></th>
                            <th class="text-center"><?php echo display('available_quantity') ?></th>
                            <th class="text-center"><?php echo display('unit') ?></th>
                            <th class="text-center"><?php echo display('quantity') ?> <i class="text-danger">*</i></th>
                            <th class="text-center"><?php echo display('rate') ?> <i class="text-danger">*</i></th>
                            <th class="text-center"><?php echo display('discount') ?> </th>
                            <th class="text-center"><?php echo display('total') ?> <i class="text-danger">*</i></th>
                            <th class="text-center"><?php echo display('action') ?></th>
                        </tr>
                    </thead>
                    <tbody id="addinvoiceItem">
                        <tr>
                            <td>
                                <input type="text" name="product_name" onkeyup="invoice_productList(1);" class="form-control productSelection" placeholder='<?php echo display('product_name') ?>' required="" id="product_name" >

                                <input type="hidden" class="autocomplete_hidden_value product_id_1" name="product_id[]" id="SchoolHiddenId"/>

                                <input type="hidden" class="sl" value="1">

                                <input type="hidden" class="baseUrl" value="<?php echo base_url();?>" />
                            </td>
                            <td class="text-center">
                                <div class="variant_id_div">
                                    <select name="variant_id[]" id="variant_id_1" class="form-control variant_id width_100p" required="">
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div>
                                    <select name="color_variant[]" id="variant_color_id_1" class="form-control color_variant width_100p">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </td> 
                            <td>
                                <input type="text" name="available_quantity[]" id="avl_qntt_1" class="form-control text-right available_quantity_1" value="0" readonly="1" readonly="" />
                            </td>
                            <td>
                                <input type="text" id="" class="form-control text-right unit_1" value="<?php echo display('none')?>" readonly=""  readonly="" />
                            </td>
                            <td>
                                <input type="number" name="product_quantity[]" onkeyup="quantity_calculate(1);" onchange="quantity_calculate(1);" id="total_qntt_1" class="form-control text-right" value="1" min="1" required="" />
                            </td>
                            <td>
                                <input type="number" name="product_rate[]" onkeyup="quantity_calculate(1);" onchange="quantity_calculate(1);" placeholder="0.00" id="price_item_1" class="price_item1 form-control text-right" required="" min="0" readonly="" />
                            </td>
                            <!-- Discount -->
                            <td>
                                <input type="number" name="discount[]" onkeyup="quantity_calculate(1);" onchange="quantity_calculate(1);" id="discount_1" class="form-control text-right" placeholder="0.00" min="0" readonly="" />
                            </td>
                           
                            <td>
                                <input class="total_price form-control text-right" type="text" name="total_price[]" id="total_price_1" placeholder="0.00" readonly="readonly" readonly="" />
                            </td>

                            <td>
<?php
//Tax basic info
$this->db->select('*');
$this->db->from('tax');
$this->db->order_by('tax_name','asc');
$tax_information = $this->db->get()->result();

if(!empty($tax_information)){
foreach($tax_information as $k=>$v){
if ($v->tax_id == 'H5MQN4NXJBSDX4L') {
    $tax['cgst_name']= $v->tax_name; 
    $tax['cgst_id']  = $v->tax_id; 
    $tax['cgst_status']  = $v->status; 
}elseif($v->tax_id == '52C2SKCKGQY6Q9J'){
    $tax['sgst_name']= $v->tax_name; 
    $tax['sgst_id']  = $v->tax_id; 
    $tax['sgst_status']  = $v->status; 
}elseif($v->tax_id == '5SN9PRWPN131T4V'){
    $tax['igst_name']   = $v->tax_name; 
    $tax['igst_id']     = $v->tax_id; 
    $tax['igst_status'] = $v->status; 
}
}
}
?>

<!-- Tax calculate start-->
<?php if ($tax['cgst_status'] ==1) { ?>
<input type="hidden" id="cgst_1" class="cgst"/> 
<input type="hidden" id="total_cgst_1" class="total_cgst" name="cgst[]" /> 
<input type="hidden" name="cgst_id[]" id="cgst_id_1">
<?php } if ($tax['sgst_status'] ==1) { ?>  
<input type="hidden" id="sgst_1" class="sgst"/>
<input type="hidden" id="total_sgst_1" class="total_sgst" name="sgst[]"/>
<input type="hidden" name="sgst_id[]" id="sgst_id_1">
<?php } if ($tax['igst_status'] ==1) { ?>   
<input type="hidden" id="igst_1" class="igst"/>
<input type="hidden" id="total_igst_1" class="total_igst" name="igst[]"/>
<input type="hidden" name="igst_id[]" id="igst_id_1">
<?php } ?>
<!-- Tax calculate end -->

<!-- Discount calculate start-->
<input type="hidden" id="total_discount_1" class="" />
<input type="hidden" id="all_discount_1" class="total_discount"/>
<!-- Discount calculate end -->

                                <button class="btn btn-danger text-right" type="button" value="<?php echo display('delete')?>" onclick="deleteRow(this)"><?php echo display('delete')?>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <?php if ($tax['cgst_status'] == 1) { ?>
                        <tr>

                            <td class="text-right" colspan="7"><b><?php echo html_escape($tax['cgst_name']) ?>:</b></td>
                            <td class="text-right">
                                <input type="text" id="total_cgst" class="form-control text-right" name="total_cgst" placeholder="0.00" readonly="readonly" readonly="" />
                            </td>
                        </tr> 
                        <?php } if ($tax['sgst_status'] ==1) { ?>        
                        <tr>
                            <td  class="text-right" colspan="7"><b><?php echo html_escape($tax['sgst_name']) ?>:</b></td>
                            <td class="text-right">
                                <input type="text" id="total_sgst" class="form-control text-right" name="total_sgst" placeholder="0.00" readonly="readonly" readonly="" />
                            </td>
                        </tr>  
                        <?php } if ($tax['igst_status'] ==1) { ?>   
                        <tr>
                            <td  class="text-right" colspan="7"><b><?php echo html_escape($tax['igst_name']) ?>:</b></td>
                            <td class="text-right">
                                <input type="text" id="total_igst" class="form-control text-right" name="total_igst" placeholder="0.00" readonly="readonly" readonly="" />
                            </td>
                        </tr>
                        <?php } ?> 
                        <tr>
                            <td  class="text-right" colspan="7"><b><?php echo display('product_discount') ?>:</b></td>
                            <td class="text-right">
                                <input type="text" id="total_discount_ammount" class="form-control text-right" name="total_discount" placeholder="0.00" readonly="readonly"  readonly="" />
                            </td>
                        </tr>        
                        <tr>
                            <td  class="text-right" colspan="7"><b><?php echo display('invoice_discount') ?>:</b></td>
                            <td class="text-right">
                                <input type="text" id="invoice_discount" class="form-control text-right" name="invoice_discount" placeholder="0.00" onkeyup="quantity_calculate(1);" onchange="quantity_calculate(1);" readonly="" />
                            </td>
                        </tr>
                        <tr>
                            <td  class="text-right" colspan="7"><b><?php echo display('service_charge') ?>:</b></td>
                            <td class="text-right">
                                <input type="text" id="service_charge" class="form-control text-right" name="service_charge" placeholder="0.00" onkeyup="calculateSum();" onchange="calculateSum();" readonly="" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7"  class="text-right"><b><?php echo display('grand_total') ?>:</b></td>
                            <td class="text-right">
                                <input type="text" id="grandTotal" class="form-control text-right" name="grand_total_price" placeholder="0.00" readonly="readonly"  readonly="" />
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                               
                            </td>
                            <td class="text-right" colspan="6"><b><?php echo display('paid_ammount') ?>:</b></td>
                            <td class="text-right">
                                <input type="text" id="paidAmount" 
                                onkeyup="invoice_paidamount();" class="form-control text-right" name="paid_amount" placeholder="0.00"  readonly="" />
                            </td>
                        </tr>
                        <tr>
                            <td align="center" class="width_220">

                                <input type="button" id="add-invoice-item" class="btn btn-info" name="add-invoice-item"  onClick="addInputField('addinvoiceItem','<?php echo html_escape(@$tax['cgst_status']) ?>','<?php echo html_escape(@$tax['sgst_status']) ?>','<?php echo html_escape(@$tax['igst_status']) ?>')" value="<?php echo display('add_new_item') ?>" />

                                <input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/>

                                <input type="submit" id="add-invoice" class="btn btn-success" name="add-invoice" value="<?php echo display('submit') ?>" />
                            </td>
                          
                            <td class="text-right" colspan="6"><b><?php echo display('due') ?>:</b></td>
                            <td class="text-right">
                                <input type="text" id="dueAmmount" class="form-control text-right" name="due_amount" placeholder="0.00" readonly="readonly" readonly="" />
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
