<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Sales Report Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('transfer_report') ?></h1>
	        <small><?php echo display('transfer_report') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="index.html"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('report') ?></a></li>
	            <li class="active"><?php echo display('transfer_report') ?></li>
	        </ol>
	    </div>
	</section>

	<section class="content">

		<div class="row">
            <div class="col-sm-12">
                <div class="column">
                	<?php if($this->permission->check_label('sales_report')->read()->access()){ ?>
                		<a href="<?php echo base_url('Admin_dashboard/todays_sales_report')?>" class="btn btn-info m-b-5 m-r-2">
                			<i class="ti-align-justify"> </i><?php echo display('sales_report')?>
                		</a>
	                <?php } ?>
                </div>
            </div>
        </div>

		<!-- Sales report -->
		<div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 
		                <?php echo form_open('Admin_dashboard/transfer_report',array('class' => 'form-inline'))?>
		                    <div class="form-group">
		                        <label for="from_date"><?php echo display('start_date') ?>:</label>
		                        <input type="text" name="from_date" class="form-control datepicker" id="from_date" placeholder="<?php echo display('start_date') ?>" >
		                    </div> 

		                    <div class="form-group">
		                        <label for="to_date"><?php echo display('end_date') ?>:</label>
		                        <input type="text" name="to_date" class="form-control datepicker" id="to_date" placeholder="<?php echo display('end_date') ?>">
		                    </div>  

		                    <button type="submit" class="btn btn-success"><?php echo display('search') ?></button>
		               <?php echo form_close()?>
		            </div>
		        </div>
		    </div>
	    </div>

	    <!-- Store to store transfer -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('store_to_store_transfer') ?> </h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
		                        <thead>
		                            <tr>
		                                <th><?php echo display('date') ?></th>
										<th><?php echo display('store') ?></th>
										<th><?php echo display('to_store') ?></th>
										<th><?php echo display('product') ?></th>
										<th><?php echo display('variant') ?></th>
										<th><?php echo display('quantity') ?></th>
		                            </tr>
		                        </thead>
		                        <tbody>
		                        <?php
		                        	if ($store_to_store_transfer) {
		                        ?>
		                            {store_to_store_transfer}
									<tr>
										<td>{date_time}</td>
										<td>{store_name}</td>
										<td>{t_store_name}</td>
										<td>{product_name}</td>
										<td>{variant_name}</td>
										<td>{quantity}</td>
									</tr>
									{/store_to_store_transfer}
								<?php
									}
								?>
		                        </tbody>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>

		<!-- Store to warehouse transfer -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('store_to_warehouse_transfer') ?> </h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample3" class="table table-bordered table-striped table-hover">
		                        <thead>
		                            <tr>
		                                <th><?php echo display('date') ?></th>
										<th><?php echo display('store') ?></th>
										<th><?php echo display('wearhouse') ?></th>
										<th><?php echo display('product') ?></th>
										<th><?php echo display('variant') ?></th>
										<th><?php echo display('quantity') ?></th>
		                            </tr>
		                        </thead>
		                        <tbody>
		                        <?php
		                        	if ($store_to_warehouse_transfer) {
		                        ?>
		                            {store_to_warehouse_transfer}
									<tr>
										<td>{date_time}</td>
										<td>{store_name}</td>
										<td>{t_wearhouse_name}</td>
										<td>{product_name}</td>
										<td>{variant_name}</td>
										<td>{quantity}</td>
									</tr>
									{/store_to_warehouse_transfer}
								<?php
									}
								?>
		                        </tbody>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>

		<!-- Warehouse to store transfer -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('warehouse_to_store_transfer') ?> </h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample4" class="table table-bordered table-striped table-hover">
		                        <thead>
		                            <tr>
		                                <th><?php echo display('date') ?></th>
										<th><?php echo display('wearhouse') ?></th>
										<th><?php echo display('store') ?></th>
										<th><?php echo display('product') ?></th>
										<th><?php echo display('variant') ?></th>
										<th><?php echo display('quantity') ?></th>
		                            </tr>
		                        </thead>
		                        <tbody>
		                        <?php
		                        	if ($warehouse_to_store_transfer) {
		                        ?>
		                            {warehouse_to_store_transfer}
									<tr>
										<td>{date_time}</td>
										<td>{wearhouse_name}</td>
										<td>{store_name}</td>
										<td>{product_name}</td>
										<td>{variant_name}</td>
										<td>{quantity}</td>
									</tr>
									{/warehouse_to_store_transfer}
								<?php
									}
								?>
		                        </tbody>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>


		<!-- Warehouse to warehouse transfer -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('warehouse_to_warehouse_transfer') ?> </h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample5" class="table table-bordered table-striped table-hover">
		                        <thead>
		                            <tr>
		                                <th><?php echo display('date') ?></th>
										<th><?php echo display('wearhouse') ?></th>
										<th><?php echo display('t_wearhouse') ?></th>
										<th><?php echo display('product') ?></th>
										<th><?php echo display('variant') ?></th>
										<th><?php echo display('quantity') ?></th>
		                            </tr>
		                        </thead>
		                        <tbody>
		                        <?php
		                        	if ($warehouse_to_warehouse_transfer) {
		                        ?>
		                            {warehouse_to_warehouse_transfer}
									<tr>
										<td>{date_time}</td>
										<td>{wearhouse_name}</td>
										<td>{t_wearhouse_name}</td>
										<td>{product_name}</td>
										<td>{variant_name}</td>
										<td>{quantity}</td>
									</tr>
									{/warehouse_to_warehouse_transfer}
								<?php
									}
								?>
		                        </tbody>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Sales Report End -->