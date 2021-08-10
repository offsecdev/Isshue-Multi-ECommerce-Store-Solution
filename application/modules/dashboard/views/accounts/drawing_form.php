<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Drawing from start -->
<div class="form-container">
	<?php echo form_open_multipart('dashboard/Cclosing/add_drawing_entry', array('class' => 'form-vertical', 'id' => 'insert_deposit', 'name' => 'insert_deposit')); ?>
		<div class="lblFieldContnr">
			<div class="lblContnr">Title</div>
			<div class="fieldContnr">
				<input type="text" id="title" name="title" required />
			</div>
		</div>
		<div class="lblFieldContnr">
			<div class="lblContnr">Description</div>
			<div class="fieldContnr">
				<textarea name="description" required ></textarea>
			</div>
		</div>
		<div class="lblFieldContnr">
			<div class="lblContnr">Amount</div>
			<div class="fieldContnr">
				<input type="number" id="amount" name="amount" required />
			</div>
		</div>
		<div class="lblFieldContnr">
			<div class="lblContnr"></div>
			<div class="fieldContnr">
				<input type="submit" id="add-deposit" class="btn btn-primary" name="add-deposit" value="Save" required />
			</div>
		</div>
		<?php echo form_close() ?>
</div>
<!-- Drawing from end -->
