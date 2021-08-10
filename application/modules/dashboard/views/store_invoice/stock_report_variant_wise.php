<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Product js php -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/product.js.php" ></script>
<script src="<?php echo MOD_URL.'dashboard/assets/js/print.js'; ?>"></script>

<!-- Stock List Supplier Wise Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('stock_report_store_wise') ?></h1>
	        <small><?php echo display('stock_report_store_wise') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('stock') ?></a></li>
	            <li class="active"><?php echo display('stock_report_store_wise') ?></li>
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
            $validatio_error = validation_errors();
            if (($error_message || $validatio_error)) {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $error_message ?>                    
            <?php echo $validatio_error ?>                    
        </div>
        <?php 
            $this->session->unset_userdata('error_message');
            }
        ?>

		<!-- Stock report variant wise -->
		<div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 

						<?php echo form_open('dashboard/Store_invoice/stock_report',array('class' => '','id' => 'validate' ));?>
							<?php 
							date_default_timezone_set(DEF_TIMEZONE);
							 $today = date('Y-m-d'); ?>

	                        <!-- input hidden value -->
	                        <input type="hidden" name="store_id" id="store_id" value="<?php echo $this->session->userdata('store_id')?>">


		                    <div class="form-group row">
		                        <label for="supplier_name" class="col-sm-2 col-form-label"><?php echo display('start_date') ?>:</label>
		                        <div class="col-sm-4">
			                        <input type="text" name="from_date" class="form-control datepicker1" id="from_date" placeholder="<?php echo display('start_date') ?>" >
			                    </div>
		                    </div> 

		                    <div class="form-group row">
		                        <label or="supplier_name" class="col-sm-2 col-form-label"><?php echo display('end_date') ?>:</label>
		                        <div class="col-sm-4">
			                        <input type="text" name="to_date" class="form-control datepicker1" id="to_date" value="<?php echo $today?>" placeholder="<?php echo display('end_date') ?>">
			                    </div>
		                    </div>   

	                        <div class="form-group row">
	                            <label for="supplier_name" class="col-sm-3 col-form-label"></label>
	                            <div class="col-sm-6">
	                                <button type="submit" class="btn btn-primary"><?php echo display('search') ?></button>
		                			<a  class="btn btn-warning" href="#" onclick="printDiv('printableArea')"><?php echo display('print') ?></a>
	                            </div>
	                        </div>
			            <?php echo form_close()?>
		            </div>
		        </div>
		    </div>
	    </div>

		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('stock_report_store_wise') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
						<div id="printableArea" class="ml_2">
							<?php if ($company_info) { ?>
							<div class="text-center">				
								{company_info}
								<h3> {company_name} </h3>
								<h4><?php echo display('address') ?> : {address} </h4>
								<h4 ><?php echo display('mobile') ?> : {mobile} </h4>
								{/company_info}
								<h4> <?php echo display('print_date') ?>: <?php echo date("m/d/Y h:i:s"); ?> </h4>
								<h3><?php echo ucwords(@$stok_report[0]['store_name']);?></h3>
							</div>
							<?php } ?>
			                <div class="table-responsive mt_10">
			                    <table id="" class="table table-bordered table-striped table-hover">
			                        <thead>
										<tr>
											<th class="text-center"><?php echo display('sl') ?></th>
											<th class="text-center"><?php echo display('product_name') ?></th>
											
											<th class="text-center"><?php echo display('variant') ?></th>
											<th class="text-center"><?php echo display('sell_price') ?></th>
											<th class="text-center"><?php echo display('supplier_price') ?></th>
											<th class="text-center"><?php echo display('purchase_date') ?></th>
											<th class="text-center"><?php echo display('purchase') ?></th>
											<th class="text-center"><?php echo display('sell') ?></th>
											<th class="text-center"><?php echo display('stock') ?></th>
										</tr>
									</thead>
									<tbody>
									<?php if ($stok_report) { ?>
									{stok_report}
										<tr>
											<td align="center">{sl}</td>
											<td align="center">{product_name}-({product_model})</td>
											
											<td align="center">{variant_name}</td>
											<td class="text-center"><?php echo (($position==0)?"$currency {price}":"{price} $currency") ?></td>
											<td class="text-center"><?php echo (($position==0)?"$currency {supplier_price}":"{supplier_price} $currency") ?></td>
											<td align="center">{date_time}</td>
											<td align="center">{in_qnty}</td>
											<td align="center">{out_qnty}</td>
											<td align="center">{stok_quantity}</td>
										</tr>
									{/stok_report}
									<?php } ?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="8" align="right"><b><?php echo display('grand_total')?>:</b></td>
											<td align="center"><b>{sub_total_stock}</td>
										</tr>
									</tfoot>
			                    </table>
			                </div>
			            </div>
		                <div class="text-center"><?php echo htmlspecialchars_decode($links); ?></div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Stock List Supplier Wise End -->
<script src="<?php echo MOD_URL.'dashboard/assets/js/store_report_variant_wise.js'; ?>"></script>

