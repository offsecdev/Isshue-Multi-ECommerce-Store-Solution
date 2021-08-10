<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Purchase Payment Ledger Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('purchase_ledger') ?></h1>
	        <small><?php echo display('purchase_ledger') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('purchase') ?></a></li>
	            <li class="active"><?php echo display('purchase_ledger') ?></li>
	        </ol>
	    </div>
	</section>

	<!-- Invoice information -->
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
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('invoice_information') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
	  					<div class="ft_left">
							<th width="100%" colspan="5" class="fw_normal" >
				        	{company_info}
				        	<h5> <u> {company_name}</u> </h5> 
				        	{/company_info}
				        	 <?php echo display('supplier_name') ?> : &nbsp;<span class="fw_normal">{supplier_name}</span>  <span class="supp_name"><?php echo display('supplier_invoice') ?> </span> <br />
				            <?php echo display('date')?> :&nbsp;{final_date} <br /><?php echo display('invoice_no') ?> :&nbsp; {invoice_no}<br> {purchase_details} <span class="ft_right"><?php echo display('print_date') ?> : <?php echo date("m/d/Y h:i:s");?> </span>
				            </th>
						</div>
		            </div>
		        </div>
		    </div>
		</div>

		<!-- Purchase Ledger -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('invoice_information') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th><?php echo display('product_name') ?></th>
										<th><?php echo display('variant') ?></th>
										<th><?php echo display('quantity') ?></th>
										<th><?php echo display('rate') ?></th>
										<th><?php echo display('total_ammount') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($purchase_all_data) {
								?>
								{purchase_all_data}
									<tr>
										<td>{sl}</td>
										<td>
											<a href="<?php echo base_url().'dashboard/Cproduct/product_details/{product_id}'; ?>">
											{product_name}-({product_model}) <i class="fa fa-shopping-bag pull-right" aria-hidden="true"></i>
											</a>
										</td>
										<td>{variant_name}</td>
										<td class="text-right">{quantity}</td>
										<td class="text-right"><?php echo (($position==0)?"$currency {rate}":"{rate} $currency") ?></td>
										<td class="text-right pr_20"><?php echo (($position==0)?"$currency {total_amount}":"{total_amount} $currency") ?></td>
									</tr>
								{/purchase_all_data}
									<?php } ?>
								</tbody>
								<tfoot>
									<tr>
										<td class="text-right" colspan="5"><b><?php echo display('grand_total') ?>:</b></td>
										<td class="text-right pr_20" ><?php echo (($position==0)?"$currency {sub_total_amount}":"{sub_total_amount} $currency") ?></td>
									</tr>
								</tfoot>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Purchase ledger End  -->