<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Product details page start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('product_ledger') ?></h1>
	        <small><?php echo display('product_sales_and_purchase_report') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('report') ?></a></li>
	            <li class="active"><?php echo display('product_ledger') ?></li>
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

	    <div class="row">
            <div class="col-sm-12">
                <div class="column">
                <?php if($this->permission->check_label('add_product')->create()->access()){ ?>
                  	<a href="<?php echo base_url('dashboard/Cproduct')?>" class="btn -btn-info color4 color5 m-b-5 m-r-2"><i class="ti-plus"> </i><?php echo display('add_product')?></a>
                <?php }if($this->permission->check_label('import_product_csv')->create()->access()){ ?>
                  	<a href="<?php echo base_url('dashboard/Cproduct/add_product_csv')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i><?php echo display('import_product_csv')?></a>
                <?php } ?>
                <?php if($this->permission->check_label('manage_product')->read()->access()){ ?>
                  	<a href="<?php echo base_url('dashboard/Cproduct/manage_product')?>" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i><?php echo display('manage_product')?></a>
                <?php } ?>

                </div>
            </div>
        </div>

	    <div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 
		            	<?php echo form_open("dashboard/Cproduct/product_details_single"); ?>
		                    <div class="form-group row">
		                        <label for="product_id" class="col-sm-2"><?php echo display('select_product')?>:</label>
		                        <div class="col-sm-6">
			                        <select class="form-control" name="product_id" id="product_id">
			                        <?php foreach($product_list as $product){ ?>
			                       
	                                    <option value=""></option>
			                        	<option value="<?php echo html_escape($product['product_id']) ?>"><?php echo html_escape($product['product_name']) ?>-(<?php echo html_escape($product['product_model']) ?>)</option>
			                       <?php } ?>
			                        </select>
		                    	</div>
		                    	<div class="col-sm-2">
		                    		<button type="submit" class="btn btn-success"><?php echo display('search')?></button>
		                    		
		                    	</div>
		                    </div>
		                    
		               <?php echo form_close(); ?>		            
		            </div>
		        </div>
		    </div>
	    </div>

		<?php
		if ($product_name) {
		?>
	    <!-- Product details -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('product_details') ?> </h4>
		                </div>
		            </div>
		            <div class="panel-body">
						<h2><span class="fw_normal"><?php echo display('product_name') ?>: </span><span class="color_005580"><?php echo html_escape($product_name); ?></span></h2>
						<h4><span class="fw_normal"><?php echo display('model') ?>:</span> <span class="color_005580"><?php echo html_escape($product_model) ?></span></h4>
						<h4><span class="fw_normal"><?php echo display('price') ?>:</span> <span class="color_005580"> 
						<?php echo (($position==0)? $currency." ".$price: $price." ".$currency) ?></span></h4>
						<table class="table">
							<tr>
								<th><?php echo display('total_purchase') ?> = <span class="color_red"><?php echo html_escape($total_purchase) ?></span></th>
								<th><?php echo display('total_sales') ?> = <span class="color_red"><?php echo html_escape($total_sales); ?></span></th>
								<th><?php echo display('stock') ?> = <span class="color_red"><?php echo html_escape($stock); ?></span></th>
							</tr>
						</table>
		            </div>
		        </div>
		    </div>
		</div>

		<!-- Total Purchase report -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('purchase_report') ?> </h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
				            	<thead>
									<tr>
										<th><?php echo display('date') ?></th>
										<th><?php echo display('invoice_no') ?></th>
										<th><?php echo display('supplier_name') ?></th>
										<th><?php echo display('quantity') ?></th>
										<th><?php echo display('rate') ?></th>
										<th class="text-right"><?php echo display('total_ammount') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($purchaseData) {
								?>
								<?php foreach($purchaseData as $purchase){ ?>
									<tr>
										<td><?php echo html_escape($purchase['final_date']);?></td>
										<td>
											<a href="<?php echo base_url().'dashboard/Cpurchase/purchase_details_data/'.$purchase["purchase_id"]; ?>"><?php echo html_escape($purchase['invoice_no']) ?> <i class="fa fa-tasks pull-right" aria-hidden="true"></i>
											</a>
										</td>
										<td>
											<a href="<?php echo base_url().'dashboard/Csupplier/supplier_details/'.$purchase["supplier_id"]; ?>"><?php echo html_escape($purchase['supplier_name']) ?> <i class="fa fa-user pull-right" aria-hidden="true"></i></a>
										</td>
										<td><?php echo html_escape($purchase['quantity']); ?></td>
										<td><?php echo (($position==0)? $currency." ".$purchase['rate']:$purchase['rate']." ".$currency) ?></td>
										<td class="text-right"> <?php echo (($position==0)? $currency." ".$purchase['total_amount']:$purchase['total_amount']." ".$currency) ?></td>
									</tr>
							
								<?php
									}
								}
								?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="3" class="text-right"><b><?php echo display('grand_total') ?></b></td>
										<td><?php echo html_escape($total_purchase); ?></td>
										<td></td>
										<td class="text-right"><b> <?php echo (($position==0)? $currency." ".$purchaseTotalAmount : $purchaseTotalAmount." ".$currency) ?></b></td>
									</tr>
								</tfoot>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>

		<!--Total sales report -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('sales_report') ?> </h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample3" class="table table-bordered table-striped table-hover">
		             			<thead>
									<tr>
										<th><?php echo display('date') ?></th>
										<th><?php echo display('invoice_no') ?></th>
										<th><?php echo display('customer_name') ?></th>
										<th><?php echo display('quantity') ?></th>
										<th><?php echo display('rate') ?></th>
										<th class="text-right"><?php echo display('total_ammount') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($salesData) {
										foreach($salesData as $sales){
								?>
								
									<tr>
										<td><?php echo html_escape($sales['final_date']); ?></td>
										<td>
											<a href="<?php echo base_url().'dashboard/Cinvoice/invoice_inserted_data/'.$sales['invoice_id']; ?>"><?php echo html_escape($sales['invoice_id']) ?>
												 <i class="fa fa-tasks pull-right" aria-hidden="true"></i>
                                            </a>
										</td>
										<td>
											<a href="<?php echo base_url().'dashboard/Ccustomer/customer_ledger/'.$sales['customer_id']; ?>"><?php echo html_escape($sales['customer_name']); ?> <i class="fa fa-user pull-right" aria-hidden="true"></i></a>
										</td>
										<td><?php echo html_escape($sales['quantity']); ?></td>
										<td> <?php echo (($position==0)? $currency." ".$sales['rate'] :$sales['rate']." ".$currency) ?></td>
										<td class="text-right"> <?php echo (($position==0)? $currency." ".$sales['total_price'] : $sales['total_price']." ".$currency) ?></td>
									</tr>
								
								<?php
									}
								}
								?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="3" class="text-right"><b><?php echo display('grand_total') ?></b></td>
										<td><?php echo html_escape($total_sales); ?></td>
										<td>&nbsp;</td>
										<td class="text-right"><b> <?php echo (($position==0)?$currency." ".$salesTotalAmount : $salesTotalAmount." ".$currency) ?></b></td>
									</tr>
								</tfoot>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
		<?php
		}
		?>

	</section>
</div>
<!-- Product details page end