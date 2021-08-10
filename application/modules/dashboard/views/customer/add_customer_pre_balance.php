<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Previous balance adjustment start -->
<h2>Previous Balance Adjustment</h2>
<div class="form-container">
	<?php echo form_open_multipart("dashboard/Ccustomer/insert_customer", array('class' => 'form-vertical', 'id' => 'insert_customer', 'name' => 'insert_product')); ?>

        <legend>Previous Balance Adjustment</legend>
        <div class="row-fluid">
			<table class="table table-condensed table-striped">
				<thead>
					<tr>
						<th class="span5 text-right">Customer Name</th> 
						<th class="span5 text-right">Previous Balance</th>
					</tr>
				</thead>
				<tbody id="form-actions">
					<tr class="">
						<td class="span5">
							<input type="number" tabindex="2" class="span13" name="customer_name" placeholder="Customer Name" required />
						</td>
						<td class="span5">
							<input type="number" tabindex="3" class="span13" name="pre_balance" placeholder="Previous Balance" required />
						</td>
					</tr>
				</tbody>
			</table>
        </div>
        <div class="form-actions">
            <input type="submit" id="add-customer" class="btn btn-primary btn-large" name="add-customer" value="Save" />
            <input type="submit" value="Save and add another one" name="add-customer-another" class="btn btn-large" id="add-customer-another">
        </div>
    <?php echo form_close() ?>
</div>
<!-- Previous balance adjustment start -->