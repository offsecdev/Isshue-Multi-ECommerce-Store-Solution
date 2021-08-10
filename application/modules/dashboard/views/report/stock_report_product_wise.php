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
	        <h1><?php echo display('stock_report_product_wise') ?></h1>
	        <small><?php echo display('stock_report_product_wise') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('stock') ?></a></li>
	            <li class="active"><?php echo display('stock_report_product_wise') ?></li>
	        </ol>
	    </div>
	</section>

	<section class="content">

		<div class="row">
            <div class="col-sm-12">
                <div class="column">
                <?php if($this->permission->check_label('stock_report')->read()->access()){ ?>
                  	<a href="<?php echo base_url('dashboard/Creport')?>" class="btn btn-success m-b-5 m-r-2">
                  		<i class="ti-align-justify"> </i><?php echo display('stock_report')?>
                  	</a>  
                <?php }if($this->permission->check_label('stock_report_supplier_wise')->read()->access()){ ?>
                  	<a href="<?php echo base_url('dashboard/Creport/stock_report_supplier_wise')?>" class="btn btn-success m-b-5 m-r-2">
                  		<i class="ti-align-justify"> </i> <?php echo display('stock_report_supplier_wise')?>
                  	</a>  
                <?php }if($this->permission->check_label('stock_report_store_wise')->read()->access()){ ?>
                  	<a href="<?php echo base_url('dashboard/Creport/stock_report_store_wise')?>" class="btn btn-success m-b-5 m-r-2">
                  		<i class="ti-align-justify"> </i> <?php echo display('stock_report_store_wise')?>
                  	</a>
	            <?php } ?>
                </div>
            </div>
        </div>


		<!-- Manage Product report -->
		<div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 
						<?php echo form_open('dashboard/Creport/stock_report_product_wise',array('class' => 'form-vertical','id' => 'validate' ));?>
						<?php 
						date_default_timezone_set(DEF_TIMEZONE);
						 $today = date('Y-m-d');
						  ?>

						<div class="form-group row">
                            <label for="supplier_id" class="col-sm-3 col-form-label"><?php echo display('select_supplier')?>: <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" id="supplier_id" name="supplier_id" required="">
                            	<option value=""><?php echo display('select_one')?></option>
                            	{supplier_list}
                                <option value="{supplier_id}">{supplier_name} </option>
                                {/supplier_list}
                            </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="product_id" class="col-sm-3 col-form-label"><?php echo display('select_product')?>: <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" id="product_id" name="product_id" required="">
	                            
	                            </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="from_date" class="col-sm-3 col-form-label"><?php echo display('from') ?>: <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" id="from_date" name="from_date" value="<?php echo $today; ?>" class="form-control datepicker" required/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="to_date" class="col-sm-3 col-form-label"><?php echo display('to') ?>: <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                               <input type="text" id="to_date" name="to_date" value="<?php echo $today; ?>" class="form-control datepicker" required/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="" class="col-sm-5 col-form-label"></label>
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
		                    <h4><?php echo display('stock_report_product_wise') ?></h4>
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
								<h4><?php echo display('product_model')?>:{product_model}</h4>
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
											<th class="text-center"><?php echo display('date') ?></th>
											<th class="text-center"><?php echo display('product_model') ?></th>
											<th class="text-center"><?php echo display('price') ?></th>
											<th class="text-center"><?php echo display('in_quantity') ?></th>
											<th class="text-center"><?php echo display('out_quantity') ?></th>
											<th class="text-center"><?php echo display('in_amount') ?></th>
											<th class="text-center"><?php echo display('out_amount') ?></th>
											<th class="text-center"><?php echo display('stock') ?></th>
										</tr>
									</thead>
									<tbody>
									<?php
									if ($stok_report) {
									?>
									{stok_report}
										<tr>
											<td>{date}</td>
											<td align="center">
												<a href="<?php echo base_url().'dashboard/Cproduct/product_details/{product_id}'; ?>" title="total stock report">{product_name}-({product_model}) </a>
                                                <a href="<?php echo base_url().'dashboard/Creport/stock_by_variant/{product_id}'; ?>"><i class="fa fa-shopping-bag pull-right" title="stock report variant wise" aria-hidden="true"></i></a>

                                            </td>
											<td class="text-center"><?php echo (($position==0)?"$currency {supplier_price}":"{supplier_price} $currency") ?></td>
										
											<td align="center">{totalPurchaseQnty}</td>
											<td align="center">{totalSalesQnty}</td>
											<td align="center"><?php echo (($position==0)?"$currency {in_taka}":"{in_taka} $currency") ?></td>
											<td align="center"><?php echo (($position==0)?"$currency {out_taka}":"{out_taka} $currency") ?></td>
											<td align="center">{stok_quantity_cartoon}</td>
										</tr>
									{/stok_report}
									<?php
									}
									?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="3" align="right"><b><?php echo display('grand_total')?>:</b></td>
											<td align="center"><b>{SubTotalinQnty}</b></td>

											<td align="center"><b>{SubTotaloutQnty}</b></td>

											<td align="center"><b><?php echo (($position==0)?"$currency {sub_total_in_taka}":"{sub_total_in_taka} $currency") ?></b></td>

											<td align="center"><b><?php echo (($position==0)?"$currency {sub_total_out_taka}":"{sub_total_out_taka} $currency") ?></b></td>

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

<script src="<?php echo MOD_URL.'dashboard/assets/js/stock_report_product_wise.js'; ?>"></script>
