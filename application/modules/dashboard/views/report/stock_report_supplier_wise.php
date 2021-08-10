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
	        <h1><?php echo display('stock_report_supplier_wise') ?></h1>
	        <small><?php echo display('stock_report_supplier_wise') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('stock') ?></a></li>
	            <li class="active"><?php echo display('stock_report_supplier_wise') ?></li>
	        </ol>
	    </div>
	</section>

	<section class="content">
		<div class="row">
            <div class="col-sm-12">
                <div class="column">
                	<?php if($this->permission->check_label('stock_report')->read()->access()){ ?>
                  	<a href="<?php echo base_url('dashboard/Creport')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i><?php echo display('stock_report')?></a> 
                  	<?php } ?> 
                  	<?php $this->permission->check_label('stock_report_product_wise')->read()->access() ?>
                  	<a href="<?php echo base_url('dashboard/Creport/stock_report_product_wise')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i><?php echo display('stock_report_product_wise')?></a>  
                </div>
            </div>
        </div>


		<!-- Stock report supplier wise -->
		<div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 

						<?php echo form_open('dashboard/Creport/stock_report_supplier_wise',array('class' => '','id' => 'validate' ));?>

							<?php 
							date_default_timezone_set(DEF_TIMEZONE); 
							$today = date('m-d-Y'); ?>

                            <div class="form-group row">
	                            <label for="supplier_name" class="col-sm-2 col-form-label"><?php echo display('select_supplier')?>:</label>
	                            <div class="col-sm-4">
	                                <select class="form-control" name="supplier_id" id="supplier_name"  required="">
	                                <option value=""></option>
			                        {supplier_list}
			                        <option value="{supplier_id}">{supplier_name}</option>
			                        {/supplier_list}
			                        </select>
	                            </div>
	                        </div>  

	                        <div class="form-group row">
	                            <label for="supplier_name" class="col-sm-2 col-form-label"><?php echo display('date') ?>:</label>
	                            <div class="col-sm-4">
	                                <input type="text" name="stock_date" value="<?php echo $today; ?>" class="form-control productSelection datepicker" required/>
	                            </div>
	                        </div>

	                        <div class="form-group row">
	                            <label for="supplier_name" class="col-sm-2 col-form-label"></label>
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
		                    <h4><?php echo display('stock_report_supplier_wise') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
						<div id="printableArea" class="ml_2">
							<?php
								if ($supplier_info) {
							?>
							<div class="text-center">				
								{supplier_info}
								<h3> {supplier_name} </h3>
								<h4><?php echo display('address') ?> : {address} </h4>
								<h4 ><?php echo display('phone') ?> : {mobile} </h4>
								{/supplier_info}
								<h4> <?php echo display('product_model') ?> : {product_model} </h4>
								<h4> <?php echo display('stock_date') ?> : {date} </h4>
								<h4> <?php echo display('print_date') ?>: <?php echo date("m/d/Y h:i:s"); ?> </h4>
							</div>
							<?php
								}
							?>
			                <div class="table-responsive mt_10">
			                    <table id="" class="table table-bordered table-striped table-hover">
			                        <thead>
										<tr>
											<th class="text-center"><?php echo display('sl') ?></th>
											<th class="text-center"><?php echo display('product_name') ?></th>
											<th class="text-center"><?php echo display('sell_price') ?></th>
											<th class="text-center"><?php echo display('supplier_price') ?></th>
											<th class="text-center"><?php echo display('in_quantity') ?></th>
											<th class="text-center"><?php echo display('out_quantity') ?></th>
											<th class="text-center"><?php echo display('stock') ?></th>
										</tr>
									</thead>
									<tbody>
									<?php
										if ($stok_report) {
									?>
									{stok_report}
										<tr>
											<td>{sl}</td>
											<td align="center">
												<a href="<?php echo base_url().'dashboard/Cproduct/product_details/{product_id}'; ?>">
                                                     {product_name}-({product_model}) <i class="fa fa-shopping-bag pull-right" aria-hidden="true"></i>
												</a>	
											</td>
											<td class="text-center"><?php echo (($position==0)?"$currency {price}":"{price} $currency") ?></td>
											<td class="text-center"><?php echo (($position==0)?"$currency {supplier_price}":"{supplier_price} $currency") ?></td>
											<td align="center">{in_qnty}</td>
											<td align="center">{out_qnty}</td>
											<td align="center">{stok_quantity}</td>
										</tr>
									{/stok_report}
									<?php
										}
									?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="6" align="right"><b><?php echo display('grand_total')?>:</b></td>
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