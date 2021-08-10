<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Product js php -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/product.js.php" ></script>

<script src="<?php echo MOD_URL.'dashboard/assets/js/print.js'; ?>"></script>


<!-- Stock List Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('stock_report') ?></h1>
	        <small><?php echo display('all_stock_report') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('stock') ?></a></li>
	            <li class="active"><?php echo display('stock_report') ?></li>
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

		<div class="row">
            <div class="col-sm-12">
                <div class="column">
                	<?php if($this->permission->check_label('stock_report_supplier_wise')->read()->access()){ ?>
                  	<a href="<?php echo base_url('dashboard/Creport/stock_report_supplier_wise')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"></i> <?php echo display('stock_report_supplier_wise')?></a>
	                <?php } ?>
	                <?php if($this->permission->check_label('stock_report_product_wise')->read()->access()){ ?>
                    <a href="<?php echo base_url('dashboard/Creport/stock_report_product_wise')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"></i> <?php echo display('stock_report_product_wise')?></a>
                	<?php } ?>
                	<?php if($this->permission->check_label('stock_report_store_wise')->read()->access()){ ?>
                  	<a href="<?php echo base_url('dashboard/Creport/stock_report_store_wise')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"></i> <?php echo display('stock_report_store_wise')?></a>
                  	<?php } ?>
                </div>
            </div>
        </div>

		<!-- Manage Product report -->
		<div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body">
						<?php echo form_open('dashboard/Creport',array('class' => 'form-inline', ));?>
							<?php  date_default_timezone_set(DEF_TIMEZONE); $today = date('Y-m-d'); ?>
							<label class="select"><?php echo display('search_by_product') ?>:</label>
							<input name="product_name" onclick="producstList();" class="form-control productSelection" placeholder="<?php echo display('product_name') ?>" id="product_name" required="" aria-required="true" type="text">
							<input class="autocomplete_hidden_value" name="product_id" id="SchoolHiddenId" type="hidden">
		                    <label class="select"><?php echo display('date') ?></label>
							<input type="text" name="stock_date" value="<?php echo $today; ?>" class="form-control productSelection datepicker"/>
							<button type="submit" class="btn btn-primary"><?php echo display('search') ?></button>
		                	<a  class="btn btn-warning" href="#" onclick="printDiv('printableArea')"><?php echo display('print') ?></a>
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
		                    <h4><?php echo display('stock_report') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
						<div id="printableArea" class="ml_2">

							<div class="text-center">
								{company_info}
								<h3>{company_name} </h3>
								<h4>{address} </h4>
								{/company_info}

								<h4> <?php echo display('stock_date') ?> : {date} </h4>
								<h4> <?php echo display('print_date') ?>: <?php echo date("m/d/Y h:i:s"); ?> </h4>
							</div>

			                <div class="table-responsive mt_10">
			                    <table id="" class="table table-bordered table-striped table-hover">
			                        <thead>
										<tr>
											<th class="text-center"><?php echo display('sl') ?></th>
											<th class="text-center"><?php echo display('product_name') ?></th>
											<th class="text-center"><?php echo display('category') ?></th>
											<th class="text-center"><?php echo display('unit') ?></th>
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
											<td>
												<a href="<?php echo base_url().'dashboard/Cproduct/product_details/{product_id}'; ?>">

                                                     {product_name}-({product_model}) <i class="fa fa-shopping-bag pull-right" aria-hidden="true"></i>
												</a>
											</td>
											<td>{category_name}</td>
											<td>{unit_name}</td>
											<td class="text-center"><?php echo (($position==0)?"$currency {price}":"{price} $currency") ?></td>
											<td class="text-center"><?php echo (($position==0)?"$currency {supplier_price}":"{supplier_price} $currency") ?></td>
											<td align="center">{totalPrhcsCtn}</td>
											<td align="center">{totalSalesCtn}</td>
											<td align="center">{stok_quantity_cartoon}</td>

										</tr>
									{/stok_report}
									<?php
									}
									?>
									</tbody>
			                    </table>
			                </div>
			            </div>
		                <div class="text-center">
		                	 <?php if (isset($link)) { echo $link ;} ?>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Stock List End -->