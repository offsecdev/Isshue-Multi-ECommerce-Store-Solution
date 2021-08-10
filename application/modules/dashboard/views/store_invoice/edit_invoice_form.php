<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Customer js php -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/customer.js.php" ></script>
<!-- Product invoice js -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/store_invoice.js.php" ></script>
<!-- Invoice js -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/invoice.js" type="text/javascript"></script>


<!-- Edit Invoice Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('invoice_edit') ?></h1>
            <small><?php echo display('invoice_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('invoice') ?></a></li>
                <li class="active"><?php echo display('invoice_edit') ?></li>
            </ol>
        </div>
    </section>

    <section class="content">
        <!-- Invoice report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('invoice_edit') ?></h4>
                        </div>
                    </div>
                    <?php echo form_open('dashboard/Store_invoice/invoice_update',array('class' => 'form-vertical','id'=>'validate' ))?>
                    <div class="panel-body">
             
                        <div class="row">
                        	<div class="col-sm-6" id="">
                                <div class="form-group row">
                                    <label for="customer_name" class="col-sm-4 col-form-label"><?php echo display('customer_name') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                       <input type="text" name="customer_name" value="{customer_name}" class="form-control customerSelection" placeholder='<?php echo display('customer_name') ?>' required id="customer_name" required>
										<input type="hidden" class="customer_hidden_value" name="customer_id" value="{customer_id}" id="SchoolHiddenId"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" id="store">
                                <div class="form-group row">
                                    <label for="store_id" class="col-sm-4 col-form-label">
                                    <?php echo display('store') ?>
                                     <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                       <select class="form-control" name="store_id" id="store_id">
                                           <option value=""></option>
                                           {store_list}
                                           <option value="{store_id}">{store_name}</option>
                                           {/store_list}
                                           {store_list_selected}
                                           <option value="{store_id}" selected="">{store_name}</option>
                                           {/store_list_selected}
                                       </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                        	<div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="datepicker" class="col-sm-4 col-form-label"><?php echo display('date') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input type="text" tabindex="3" class="form-control datepicker" name="invoice_date" value="{date}" id="date"  required />
                                    </div>
                                </div>
                            </div>
                        </div>

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
										<th class="text-center"><?php echo display('discount') ?> <i class="text-danger">*</i></th>
										<th class="text-center"><?php echo display('total') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center"><?php echo display('action') ?></th>
									</tr>
								</thead>


<tbody id="addinvoiceItem">
    <?php
    $i=0;
    if ($invoice_all_data) {
    foreach ($invoice_all_data as $value) {

        $i++;
        $cgst = null;
        $sgst = null;
        $igst = null;

        $sgst_tax_amount = 0;
        $cgst_tax_amount = 0;
        $igst_tax_amount = 0;

        $cgst_value = $this->db->select('tcd.tax_id, tcd.amount, tcd.product_id, t.tax_name')
            ->from('tax_collection_details AS tcd')
            ->join('tax AS t', 't.tax_id = tcd.tax_id', 'left')
            ->where('tcd.product_id',$value['product_id'])
            ->where('tcd.invoice_id',$value['invoice_id']) 
            ->where('tcd.variant_id',$value['variant_id'])
            ->where('t.tax_id','H5MQN4NXJBSDX4L') 
            ->get()
            ->row();
        
        $sgst_value = $this->db->select('tcd.tax_id, tcd.amount, tcd.product_id, t.tax_name')
            ->from('tax_collection_details AS tcd')
            ->join('tax AS t', 't.tax_id = tcd.tax_id', 'left')
            ->where('tcd.product_id',$value['product_id'])
            ->where('tcd.invoice_id',$value['invoice_id']) 
            ->where('tcd.variant_id',$value['variant_id'])
            ->where('t.tax_id','52C2SKCKGQY6Q9J') 
            ->get()
            ->row();
        
        $igst_value = $this->db->select('tcd.tax_id, tcd.amount, tcd.product_id, t.tax_name')
            ->from('tax_collection_details AS tcd')
            ->join('tax AS t', 't.tax_id = tcd.tax_id', 'left')
            ->where('tcd.product_id',$value['product_id'])
            ->where('tcd.invoice_id',$value['invoice_id']) 
            ->where('tcd.variant_id',$value['variant_id'])
            ->where('t.tax_id','5SN9PRWPN131T4V') 
            ->get()
            ->row();

        $cgst    = (!empty($cgst_value->tax_name)?$cgst_value->amount:null);
        $sgst    = (!empty($sgst_value->tax_name)?$sgst_value->amount:null);
        $igst    = (!empty($igst_value->tax_name)?$igst_value->amount:null);
        $cgst_id = (!empty($cgst_value->tax_id)?$cgst_value->tax_id:null);
        $sgst_id = (!empty($sgst_value->tax_id)?$sgst_value->tax_id:null);
        $igst_id = (!empty($igst_value->tax_id)?$igst_value->tax_id:null);

        $cgst_tax = $this->db->select('tcd.tax_id, tcd.tax_amount, t.tax_name')
            ->from('tax_collection_summary AS tcd')
            ->join('tax AS t', 't.tax_id = tcd.tax_id', 'left')
            ->where('tcd.invoice_id',$value['invoice_id']) 
            ->where('t.tax_id','H5MQN4NXJBSDX4L') 
            ->get()
            ->row();

        $sgst_tax = $this->db->select('tcd.tax_id, tcd.tax_amount, t.tax_name')
            ->from('tax_collection_summary AS tcd')
            ->join('tax AS t', 't.tax_id = tcd.tax_id', 'left')
            ->where('tcd.invoice_id',$value['invoice_id']) 
            ->where('t.tax_id','52C2SKCKGQY6Q9J') 
            ->get()
            ->row();

        $igst_tax = $this->db->select('tcd.tax_id, tcd.tax_amount, t.tax_name')
            ->from('tax_collection_summary AS tcd')
            ->join('tax AS t', 't.tax_id = tcd.tax_id', 'left')
            ->where('tcd.invoice_id',$value['invoice_id']) 
            ->where('t.tax_id','5SN9PRWPN131T4V') 
            ->get()
            ->row();

        $cgst_tax_amount = (!empty($cgst_tax->tax_name)?$cgst_tax->tax_amount:0);
        $sgst_tax_amount = (!empty($sgst_tax->tax_name)?$sgst_tax->tax_amount:0);
        $igst_tax_amount = (!empty($igst_tax->tax_name)?$igst_tax->tax_amount:0);

        //Tax basic price
        $this->db->select('tax.*,tax_product_service.product_id,tax_percentage');
        $this->db->from('tax_product_service');
        $this->db->join('tax','tax_product_service.tax_id = tax.tax_id','left');
        $this->db->where('tax_product_service.product_id',$value['product_id']);
        $tax_information = $this->db->get()->result();

        if(!empty($tax_information)){
            foreach($tax_information as $k=>$v){
               if ($v->tax_id == 'H5MQN4NXJBSDX4L') {
                    $tax['cgst_tax'] = ($v->tax_percentage)/100;
                    $tax['cgst_name']= $v->tax_name; 
                    $tax['cgst_id']  = $v->tax_id; 
               }elseif($v->tax_id == '52C2SKCKGQY6Q9J'){
                    $tax['sgst_tax'] = ($v->tax_percentage)/100;
                    $tax['sgst_name']= $v->tax_name; 
                    $tax['sgst_id']  = $v->tax_id; 
               }elseif($v->tax_id == '5SN9PRWPN131T4V'){
                    $tax['igst_tax'] = ($v->tax_percentage)/100;
                    $tax['igst_name']   = $v->tax_name; 
                    $tax['igst_id'] = $v->tax_id; 
               }
            }
        }

        //Variant for per product
        $this->db->select('a.variants');
        $this->db->from('product_information a');
        $this->db->where(array('a.product_id' => $value['product_id'],'a.status' => 1)); 
        $product_information = $this->db->get()->row();
        $exploded = explode(',',$product_information->variants);

        //Stock available check from purchase
        $this->db->select('SUM(a.quantity) as total_purchase');
        $this->db->from('product_purchase_details a');
        $this->db->where('a.product_id',$value['product_id']);
        $this->db->where('a.variant_id',$value['variant_id']);
        $this->db->where('a.store_id',$value['store_id']);
        $total_purchase = $this->db->get()->row();

        //Stock available check from invoice
        $this->db->select('SUM(b.quantity) as total_sale');
        $this->db->from('invoice_details b');
        $this->db->where('b.product_id',$value['product_id']);
        $this->db->where('b.variant_id',$value['variant_id']);
        $this->db->where('b.store_id',$value['store_id']);
        $total_sale = $this->db->get()->row();
    ?>
	<tr>
		<td>
            <input type="text" name="product_name" required class="form-control product_name productSelection" onkeyup="invoice_productList(<?php echo $i?>);" placeholder="<?php echo display('product_name') ?>" id="product_name_<?php echo $i?>" tabindex="5" value="<?php echo html_escape($value['product_name']).'-('.html_escape($value['product_model'])?>)">

            <input type="hidden" class="autocomplete_hidden_value product_id_<?php echo $i?>" name="product_id[]" id="" value="<?php echo html_escape($value['product_id'])?>" />

            <input type="hidden" class="sl" value="<?php echo $i?>">
		</td>
        <td class="text-center">
            <select name="variant_id[]" id="variant_id_<?php echo $i?>" class="form-control variant_id width_100p" required="">
                <option value=""></option>
            <?php
            if ($exploded) {
                foreach ($exploded as $elem) {
                    $this->db->select('*');
                    $this->db->from('variant');
                    $this->db->where('variant_id',$elem);
                    $this->db->order_by('variant_name','asc');
                    $result = $this->db->get()->row();
            ?>
                <option value="<?php echo html_escape($result->variant_id)?>" <?php if($value['variant_id'] == $result->variant_id){echo "selected";}?>><?php echo html_escape($result->variant_name)?></option>
            <?php
                }
            }
            ?>
            </select>
        </td>
        <td>
            <input type="text" name="available_quantity[]" id="avl_qntt_<?php echo $i?>" class="form-control text-right available_quantity_<?php echo $i?>" placeholder="0" readonly="" value="<?php echo $total_purchase->total_purchase - $total_sale->total_sale?>"/>
        </td>
        <td>
            <input type="text" id="" class="form-control text-right unit_<?php echo $i?>" value="<?php echo html_escape($value['unit'])?>" readonly="" />
        </td>
		<td class="text-right">
			<input type="number" name="product_quantity[]" onkeyup="quantity_calculate(<?php echo $i?>);" onchange="quantity_calculate(<?php echo $i?>);" value="<?php echo html_escape($value['quantity'])?>" id="total_qntt_<?php echo $i?>" class="form-control text-right" min="1" required="" />
		</td>
		<td>
			<input type="number" name="product_rate[]" onkeyup="quantity_calculate(<?php echo $i?>);" onchange="quantity_calculate(<?php echo $i?>);" value="<?php echo html_escape($value['rate'])?>" id="price_item_<?php echo $i?>" class="price_item<?php echo $i?> form-control text-right" required="" min="0" />
		</td>
		<td>
			<input type="number" name="discount[]" onkeyup="quantity_calculate(<?php echo $i?>);" onchange="quantity_calculate(<?php echo $i?>);" id="discount_<?php echo $i?>" class="form-control text-right" placeholder="Discount" value="<?php echo html_escape($value['discount'])?>" min="0" />
		</td>
		<td>
			<input class="total_price form-control text-right" type="text" name="total_price[]" id="total_price_<?php echo $i?>" value="<?php echo html_escape($value['total_price'])?>" readonly="readonly" />
			<input type="hidden" name="invoice_details_id[]" id="invoice_details_id" value="<?php echo html_escape($value['invoice_details_id'])?>"/>
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
                <input type="hidden" id="cgst_<?php echo $i?>" class="cgst" value="<?php echo (!empty($tax['cgst_tax'])?$tax['cgst_tax']:null)?>"/> 
                <input type="hidden" id="total_cgst_<?php echo $i?>" class="total_cgst" name="cgst[]" value="<?php echo html_escape($cgst)?>"/> 
                <input type="hidden" name="cgst_id[]" id="cgst_id_<?php echo $i?>" value="<?php echo $cgst_id?>">
            <?php } if ($tax['sgst_status'] ==1) { ?> 
                <input type="hidden" id="sgst_<?php echo $i?>" class="sgst" value="<?php echo (!empty($tax['sgst_tax'])?$tax['sgst_tax']:null)?>"/>
                <input type="hidden" id="total_sgst_<?php echo $i?>" class="total_sgst" name="sgst[]" value="<?php echo html_escape($sgst)?>"/>
                <input type="hidden" name="sgst_id[]" id="sgst_id_<?php echo $i?>" value="<?php echo $sgst_id?>">
            <?php } if ($tax['igst_status'] ==1) { ?>
                <input type="hidden" id="igst_<?php echo $i?>" class="igst" value="<?php echo (!empty($tax['igst_tax'])?$tax['igst_tax']:null)?>"/>
                <input type="hidden" id="total_igst_<?php echo $i?>" class="total_igst" name="igst[]" value="<?php echo html_escape($igst)?>"/>
                <input type="hidden" name="igst_id[]" id="igst_id_<?php echo $i?>" value="<?php echo html_escape($igst_id)?>">
            <?php } ?>
            <!-- Tax calculate end -->

            <input type="hidden" id="total_discount_<?php echo $i?>" class="" />
            <input type="hidden" id="all_discount_<?php echo $i?>" class="total_discount" value="<?php echo $value['discount'] * $value['quantity']?>"/>
            <!-- Discount calculate end -->

            <button class="btn btn-danger text-right" type="button" value="<?php echo display('delete')?>" onclick="deleteRow(this)"><?php echo display('delete')?></button>
        </td>
	</tr>
    <?php
        }
    }
    ?>
</tbody>

<tfoot>

    <?php if ($tax['cgst_status'] ==1) { ?>
    <tr>
        <td class="text-right" colspan="7"><b><?php echo html_escape($tax['cgst_name']) ?>:</b></td>
        <td class="text-right">
            <input type="text" id="total_cgst" class="form-control text-right" name="total_cgst" value="<?php echo  html_escape($cgst_tax_amount)?>" readonly="readonly" />
        </td>
    </tr>
    <?php } if ($tax['sgst_status'] ==1) { ?>       
    <tr>
        <td class="text-right" colspan="7"><b><?php echo html_escape($tax['sgst_name']) ?>:</b></td>
        <td class="text-right">
            <input type="text" id="total_sgst" class="form-control text-right" name="total_sgst" value="<?php echo  html_escape($sgst_tax_amount)?>" readonly="readonly" />
        </td>
    </tr> 
    <?php } if ($tax['igst_status'] ==1) { ?>   
    <tr>
        <td class="text-right" colspan="7"><b><?php echo html_escape($tax['igst_name']) ?>:</b></td>
        <td class="text-right">
            <input type="text" id="total_igst" class="form-control text-right" name="total_igst" value="<?php echo  html_escape($igst_tax_amount)?>" readonly="readonly" />
        </td>
    </tr>
    <?php } ?>

    <tr>
        <td colspan="5"  rowspan="4">
            <label for="invoice_details" class=""><?php echo display('invoice_details')?></label>
            <textarea class="form-control" name="invoice_details" id="invoice_details" rows="6" placeholder="<?php echo display('invoice_details')?>">{invoice_details}</textarea>
        </td>

        <td class="text-right" colspan="2"><b><?php echo display('product_discount') ?>:</b></td>
        <td class="text-right">
            <input type="text" id="total_discount_ammount" class="form-control text-right" name="total_discount" readonly="readonly" value="{total_discount}" />
        </td>
    </tr>
    <tr>
        <td class="text-right" colspan="2"><b><?php echo display('invoice_discount') ?>:</b></td>
        <td class="text-right">
            <input type="text" id="invoice_discount" class="form-control text-right" name="invoice_discount" value="<?php if($invoice_discount){ echo $invoice_discount - $total_discount;}?>" onkeyup="quantity_calculate(1);" onchange="quantity_calculate(1);" placeholder="0.00"/>
        </td>
    </tr>
    <tr>
        <td class="text-right" colspan="2"><b><?php echo display('service_charge') ?>:</b></td>
        <td class="text-right">
            <input type="text" id="service_charge" class="form-control text-right" name="service_charge" value="<?php echo html_escape($service_charge)?>" onkeyup="calculateSum();" onchange="calculateSum();" placeholder="0.00"/>
        </td>
    </tr>

    <tr>
        <td colspan="2"  class="text-right"><b><?php echo display('grand_total') ?>:</b></td>
        <td class="text-right">
            <input type="text" id="grandTotal" class="form-control text-right" name="grand_total_price" value="{total_amount}" readonly="readonly" />
        </td>
    </tr>
    <tr>
        <td align="center">
            <input type="button" class="btn btn-info" name="add-invoice-item"  onClick="addInputField('addinvoiceItem');" value="<?php echo display('add_new_item') ?>" />
            <input  class="btn btn-warning" name="" value="<?php echo display('full_paid') ?>" tabindex="15" onclick="full_paid();" type="button">


            <input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/>
            <input type="hidden" name="invoice_id" id="invoice_id" value="{invoice_id}"/>
            <input type="hidden" name="invoice" id="invoice" value="{invoice}"/>
            <input type="hidden" name="invoice_status" id="invoice_status" value="{invoice_status}"/>

        </td>
        <td class="text-right" colspan="6"><b><?php echo display('paid_ammount') ?>:</b></td>
        <td class="text-right">
            <input type="text" id="paidAmount" 
            onkeyup="invoice_paidamount();"  class="form-control text-right" name="paid_amount" value="{paid_amount}" />
        </td>
    </tr>
    <tr>
        <td align="center" class="width_220">
            <input type="button" id="add-invoice" class="btn btn-primary payment_button" value="<?php echo display('payment') ?>"/>
            <input type="submit" id="add-invoice" class="btn btn-success btn-large" name="add-invoice" value="<?php echo display('update') ?>" />
        </td>
      
        <td class="text-right" colspan="6"><b><?php echo display('due') ?>:</b></td>
        <td class="text-right">
            <input type="text" id="dueAmmount" class="form-control text-right" name="due_amount" value="{due_amount}" readonly="readonly"/>
        </td>
    </tr>

    <!-- Payment method -->
    <tr class="payment_method none">
        <td colspan="7">
             <div class="row">
                <div class="col-sm-7">
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
                <div class="col-sm-7">
                    <div class="form-group row">
                        <label for="card_type" class="col-sm-4 col-form-label"><?php echo display('card_type') ?>: </label>
                        <div class="col-sm-8">
                          <select class="form-control" name="card_type" id="card_type" >
                                <option value="Credit Card"><?php echo display('credit_card')?></option>
                                <option value="Debit Card"><?php echo display('debit_card')?></option>
                                <option value="Master Card"><?php echo display('master_card')?></option>
                                <option value="Amex"><?php echo display('amex')?></option value="Credit Cart">
                                <option value="Visa"><?php echo display('visa')?></option value="Credit Cart">
                                <option value="Paypal"><?php echo display('paypal')?></option>
                                <option value="Others"><?php echo display('others')?></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-7">
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
<!-- Edit Invoice End -->
<input type="hidden" id="cgst_status" value="<?php echo html_escape($tax['cgst_status']); ?>">
<input type="hidden" id="sgst_status" value="<?php echo html_escape($tax['sgst_status']); ?>">
<input type="hidden" id="igst_status" value="<?php echo html_escape($tax['igst_status']); ?>">
<script src="<?php echo MOD_URL.'dashboard/assets/js/edit_invoice_form.js'; ?>"></script>
