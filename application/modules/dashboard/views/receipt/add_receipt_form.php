<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<h2>New Receipt</h2>
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/customer.js.php" ></script>
<script src="<?php echo MOD_URL.'dashboard/assets/js/add_receipt_form.js'; ?>"></script>

<div class="form-container">
	<?php echo form_open_multipart("creceipt/insert_receipt", array( 'class' => 'form-vertical','id' => 'insert_receipt','name' => 'insert_receipt')); ?>

        <legend>Receipt detail</legend>
		<?php $date = date('Y-m-d'); ?>
        <div class="row-fluid">
            <div class="span3">
                <div class="control-group">
                    <label class="control-label" for="invoice_date">Date:</label>
                    <div class="controls">
                        <input type="text" class="span10" value="<?php echo $date; ?>" id="receipt_date" name="receipt_date" required />
                    </div>
                </div>
            </div>
            <div class="span8">
            	<div class="control-group">
                    <label class="control-label">Description:</label>
                    <div class="controls">
                        <textarea class="span6 input-description" tabindex="1" id="description" name="description" placeholder="Optional detail about this receipt" required></textarea>
                    </div>
                </div>
            </div>
        </div>
		<div class="row-fluid">
			<div class="control-group">
				<label class="control-label">Customer Name</label>
				<div class="controls">
					<input type="text" name="customer_name" class="span3 customerSelection" placeholder='Type Customer Name' id="customer_name" >
					<input type="hidden" class="customer_hidden_value" name="customer_id" id="SchoolHiddenId"/>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Payment Type</label>
				<div class="controls">
					<div class="radioField"><input type="radio" value="1" name="payment_type" required /> Cash </div>
					<div class="radioField"><input type="radio" value="2" name="payment_type" required /> Cheque </div>
				</div>
			</div><br/><br/>
			<div class="control-group checque_type none">
				<label class="control-label">Checque Number</label>
				<div class="controls">
					<input type="text" class="span3" name="cheque_no" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Amount</label>
				<div class="controls">
					<input type="text" class="span3" name="amount" placeholder="Amount" required />
				</div>
			</div>
        </div>
        <div class="form-actions">
            <input type="submit" id="add-receipt" class="btn btn-primary btn-large" name="add-receipt" value="Save" />
            <input type="submit" value="Save and add another one" name="add-receipt-another" class="btn btn-large" id="add-receipt-another">
        </div>
    <?php echo form_close(); ?>
</div>
