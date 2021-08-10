<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Manage Category Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('best_sale_product') ?></h1>
	        <small><?php echo display('all_best_sale_product') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li class="active"><?php echo display('best_sale_product') ?></li>
	        </ol>
	    </div>
	</section>

	<section class="content">
		<!-- Manage Category -->
		<div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 
		                <?php echo form_open('dashboard/Admin_dashboard/monthly_best_sale_product',array('method'=>'GET', 'class' => 'form-inline'))?>
		                    <div class="form-group">
		                        <label for="from_date"><?php echo display('product_name') ?>:</label>
		                        <input type="text" name="product_name" class="form-control product_name productSelection" onkeyup="find_product(1)" placeholder="<?php echo display('product_name') ?>" id="product_name_1" tabindex="5" >
		                        <input type="hidden" name="product_id" id="product_id">
		                    </div>
		                    <div class="form-group">
		                        <label for="from_date"><?php echo display('start_date') ?>:</label>
		                        <input type="text" autocomplete="off" name="from_date" value="<?php echo set_value('from_date',$this->input->get('from_date', true)) ?>" class="form-control datepicker" id="from_date" placeholder="<?php echo display('start_date') ?>">
		                    </div> 
		                    <div class="form-group">
		                        <label for="to_date"><?php echo display('end_date') ?>:</label>
		                        <input type="text" autocomplete="off" name="to_date" value="<?php echo set_value('from_date',$this->input->get('to_date', true)) ?>"  class="form-control datepicker" id="to_date" placeholder="<?php echo display('end_date') ?>">
		                    </div>  
		                    <button type="submit" class="btn btn-success"><?php echo display('search') ?></button>
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
		                    <h4><?php echo display('best_sale_product') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th class="text-center"><?php echo display('product') ?></th>
										<th class="text-center"><?php echo display('orders_count') ?></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if(!empty($best_sale_products)){
									$i=1;
									foreach($best_sale_products as $best_sale_product){?>
                                        <tr>
                                        	<td><?php echo $i++; ?></td>
                                            <td><?php echo html_escape($best_sale_product['product_name']) ?></td>
                                            <td><?php echo html_escape($best_sale_product['order_count']) ?></td>
                                        </tr>
                                    <?php }	
									} ?>
								</tbody>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Manage Category End -->
<script src="<?php echo MOD_URL.'dashboard/assets/js/all_best_sale_product.js';?>"></script>