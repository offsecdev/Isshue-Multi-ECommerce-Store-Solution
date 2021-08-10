<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Store to store report -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('store_to_store_transfer') ?></h1>
	        <small><?php echo display('store_to_store_transfer') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="index.html"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('report') ?></a></li>
	            <li class="active"><?php echo display('store_to_store_transfer') ?></li>
	        </ol>
	    </div>
	</section>

	<section class="content">

		<div class="row">
            <div class="col-sm-12">
                <div class="column">
                	<?php if($this->permission->check_label('sales_report')->read()->access()){ ?>
                	<a href="<?php echo base_url('dashboard/Admin_dashboard/todays_sales_report')?>" class="btn -btn-info color4 color5 m-b-5 m-r-2">
                		<i class="ti-align-justify"> </i><?php echo display('sales_report')?>
                	</a>
          			<?php } ?>
                </div>
            </div>
        </div>

		<!-- Store To Store -->
		<div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 
		                <?php echo form_open('dashboard/Admin_dashboard/store_to_store_transfer',array('method' => 'GET'))?>
		               		<?php 
							date_default_timezone_set(DEF_TIMEZONE); 
							$today = date('Y-m-d'); ?>

							<div class="col-sm-3">
								<label for="from_store" class="col-form-label"><?php echo display('store') ?>:</label>
								<select class="form-control" name="from_store" id="from_store"  required="">
	                                <option value=""></option>
			                        {store_list}
			                        <option value="{store_id}">{store_name}</option>
			                        {/store_list}
			                    </select>
							</div>
							<div class="col-sm-3">
								<label for="to_store" class="col-form-label"><?php echo display('to_store') ?>:</label>
								<select class="form-control" name="to_store" id="to_store"  required="">
	                                <option value=""></option>
			                        {store_list}
			                        <option value="{store_id}">{store_name}</option>
			                        {/store_list}
			                    </select>
							</div>
							<div class="col-sm-4">
								<label for="from_date" class="col-form-label"><?php echo display('date') ?>:</label>
								<div class="input-group">
									<input type="text" name="from_date" class="form-control datepicker" id="from_date" placeholder="<?php echo display('start_date') ?>" autocomplete="off"  value="<?php echo set_value('from_date') ?>">
									<div class="input-group-addon">to</div>
									<input type="text" name="to_date" class="form-control datepicker" id="to_date" value="<?php echo $today?>" placeholder="<?php echo display('end_date') ?>" autocomplete="off"  value="<?php echo set_value('to_date') ?>">
								</div>
							</div>
							<div class="col-sm-2">
								<button type="submit" class="btn btn-success" style="margin-top: 27px;"><?php echo display('search') ?></button>
							</div>
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
		                        	foreach ($store_to_store_transfer as $report) {
		                        ?>
									<tr>
										<td><?php echo html_escape($report['date_time'])?></td>
										<td><?php echo html_escape($report['store_name'])?></td>
										<td><?php echo html_escape($report['t_store_name'])?></td>
										<td><?php echo html_escape($report['product_name'].'-('.$report['product_model'].')')?></td>
										<td><?php echo html_escape($report['variant_name'])?></td>
										<td><?php echo abs($report['quantity'])?></td>
									</tr>
								<?php
									}
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
<!-- Store To Store End -->