<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<h2>Edit Receipt</h2>
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/customer.js.php" ></script>
<div class="form-container">
    <?php echo form_open_multipart("creceipt/receipt_update", array( 'class' => 'form-vertical','id' => 'insert_receipt','name' => 'insert_receipt')); ?>
        <legend>Receipt detail</legend>
		<?php $date = date('Y-m-d'); ?>
        <div class="row-fluid">
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="invoice_date">Date:</label>
                    <div class="controls">
                        <input type="text" class="span10" value="{date}" id="receipt_date" name="receipt_date" required />
                    </div>
                </div>
            </div>
            <div class="span8">
            	<div class="control-group">
                    <label class="control-label">Description:</label>
                    <div class="controls">
                        <textarea class="span6 input-description" tabindex="1" id="description" name="description" placeholder="Optional detail about this receipt" required>{description}</textarea>
                    </div>
                </div>
            </div>
        </div>
		<div class="row-fluid">
			<div class="control-group">
				<label class="control-label">Customer Name</label>
				<div class="controls">
					<input type="text" name="customer_name" value="{customer_name}" class="span3 customerSelection" placeholder='Type Customer Name' id="customer_name" >
					<input type="hidden" class="customer_hidden_value" value="{customer_id}" name="customer_id" id="SchoolHiddenId"/>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Amount</label>
				<div class="controls">
					<input type="text" class="span3" value="{amount}" name="amount" placeholder="Amount" required />
					<input type="hidden" value="{receipt_no}" name="receipt_no"  />
				</div>
			</div>
        </div>
        <div class="form-actions">
            <input type="submit" id="add-receipt" class="btn btn-primary btn-large" name="add-receipt" value="Save Changes" />
        </div>
    <?php echo form_close(); ?>
</div>
