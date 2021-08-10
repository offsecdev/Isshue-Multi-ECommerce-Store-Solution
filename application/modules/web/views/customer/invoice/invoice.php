<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage Invoice Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_invoice') ?></h1>
	        <small><?php echo display('manage_your_invoice') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('invoice') ?></a></li>
	            <li class="active"><?php echo display('manage_invoice') ?></li>
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

		<!-- Manage Invoice report -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_invoice') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
		                    	<thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th><?php echo display('invoice_no') ?></th>
										<th><?php echo display('customer_name') ?></th>
										<th><?php echo display('date') ?></th>
										<th><?php echo display('total_amount') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php if ($invoices_list) { ?>
								{invoices_list}
									<tr>
										<td>{sl}</td>
										<td>
											<a href="<?php echo base_url('customer/invoice/invoice_inserted_data/{invoice_id}'); ?>">
											{invoice}
											</a>
										</td>
										<td>{customer_name}</td>
										<td>{final_date}</td>
										<td class="text-right"><?php echo (($position==0)?"$currency {total_amount}":"{total_amount} $currency") ?></td>
									</tr>
								{/invoices_list}
								<?php } ?>
								</tbody>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Manage Invoice End -->