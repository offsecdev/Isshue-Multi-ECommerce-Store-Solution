<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage order Start -->
<div class="content-wrapper">
	<section class="content-header">
		<div class="header-icon">
			<i class="pe-7s-note2"></i>
		</div>
		<div class="header-title">
			<h1><?php echo display('manage_order') ?></h1>
			<small><?php echo display('manage_order') ?></small>
			<ol class="breadcrumb">
				<li>
					<a href="#">
						<i class="pe-7s-home"></i> 
						<?php echo display('home') ?>
					</a>
				</li>
				<li>
					<a href="#">
						<?php echo display('order') ?>
					</a>
				</li>
				<li class="active">
					<?php echo display('manage_order') ?>
				</li>
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
					<?php  if($this->permission->check_label('new_order')->create()->access()){ ?>
						<a href="<?php echo base_url('dashboard/Corder/new_order')?>" class="btn btn-info color4 color5 m-b-5 m-r-2">
							<i class="ti-plus"></i> <?php echo display('new_order')?>
						</a>
					<?php } if($this->permission->check_label('pos_sale')->access()){ ?>
						<a href="<?php echo base_url('dashboard/Cinvoice/pos_invoice')?>" class="btn btn-primary m-b-5 m-r-2">
							<i class="ti-align-justify"></i> <?php echo display('pos_invoice')?>
						</a>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 
		                <?php echo form_open("", array( 'method' => 'GET')); ?>
		                    <div class="col-sm-2">
		                        <div class="form-group">
		                            <label class="control-label"><?php echo display('order_no')?>:</label>
		                            <input type="text" class="form-control" name="order_no" value="<?php echo set_value('order_no', @$_GET['order_no']) ?>" placeholder='<?php echo display('order_no') ?>'>
		                        </div>
		                    </div>
		                    <div class="col-sm-2">
		                        <div class="form-group row">
		                            <label for="customer_name"
		                                   class="control-label"><?php echo display('customer_name') ?> <i class="text-danger">*</i></label>

		                                <input type="text" size="100" value="<?php echo html_escape(@$_GET['customer_name']); ?>" name="customer_name" class="customerSelection form-control" placeholder='<?php echo display('customer_name') ?>' id="customer_name"
		                                       />
		                        </div>
		                    </div>
		                    <div class="col-sm-2">
		                        <div class="form-group">
		                            <label class="control-label"><?php echo display('date')?>:</label>
		                            <input type="text" class="form-control datepicker " name="date" value="<?php echo set_value('date', @$_GET['date']) ?>"  placeholder='<?php echo display('date') ?>' autocomplete="off">
		                        </div>
		                    </div>
		                    <div class="col-sm-2">
		                        <div class="form-group">
		                            <label class="control-label"><?php echo display('status')?>:</label>
		                            <select class="form-control" name="invoice_status">
		                                <option value=""></option>
		                                <option value="1" <?php if (@$_GET['invoice_status'] == '1'){echo "selected";}?>><?php echo display('shipped')?></option>
		                                <option value="2" <?php if (@$_GET['invoice_status'] == '2'){echo "selected";}?>><?php echo display('cancel')?></option>
		                                <option value="3" <?php if (@$_GET['invoice_status'] == '3' || @$_GET['invoice_status'] == '0'){echo "selected";}?>><?php echo display('pending')?></option>
		                                <option value="4" <?php if (@$_GET['invoice_status'] == '4'){echo "selected";}?>><?php echo display('complete')?></option>
		                                <option value="5" <?php if (@$_GET['invoice_status'] == '5'){echo "selected";}?>><?php echo display('processing')?></option>
		                                <option value="6" <?php if (@$_GET['invoice_status'] == '6'){echo "selected";}?>><?php echo display('return')?></option>
		                            </select>
		                        </div>
		                    </div>
		                    <div class="col-sm-2">
		                        <div class="form-group">
		                           <button type="submit" class="btn btn-primary filter_btn"><?php echo display('search')?></button>
		                        </div>
		                    </div>
		                    
		                <?php echo form_close(); ?>                 
		            </div>
		        </div>
		    </div>
		</div>


	<!-- Manage order report -->
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-bd lobidrag">
				<div class="panel-heading">
					<div class="panel-title">
						<h4><?php echo display('manage_order') ?></h4>
					</div>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table id="dataTableExample3" class="table table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th><?php echo display('sl') ?></th>
									<th><?php echo display('order_no') ?></th>
									<th><?php echo display('customer_name') ?></th>
									<th><?php echo display('date') ?></th>
									<th><?php echo display('total_amount') ?></th>
									<th><?php echo display('status') ?></th>
									<th><?php echo display('action') ?></th>
								</tr>
							</thead>
							<tbody>
								<?php
								if ($orders_list) {
									foreach ($orders_list as $order) {
										?>
										<tr>
											<td><?php echo $order['sl']?></td>
											<td>
												<a href="<?php echo base_url().'dashboard/Corder/order_details_data/'.$order['order_id'] ?>">
				                                     <?php echo html_escape($order['order'])?> <i class="fa fa-tasks pull-right" aria-hidden="true"></i>
											</a>
										</td>
										<td>
											<a href="<?php echo base_url().'dashboard/Ccustomer/customerledger/'.$order['customer_id']; ?>">
				                                 <?php echo html_escape($order['customer_name'])?> <i class="fa fa-user pull-right" aria-hidden="true"></i></a>
										</td>
										<td><?php echo html_escape($order['final_date'])?></td>
										<td  class="text-right" ><?php echo (($position==0)?$currency.' '.$order['total_amount']:$order['total_amount'].' '.$currency) ?></td>
										<td class="text-center">
											<?php 
											if($order['invoice_status'] == '0'){
												echo "<label class='label label-warning'>".display('pending')."</label>";
											}else if($order['invoice_status'] == '1'){
												echo "<label class='label label-primary'>".display('shipped')."</label>";
											}else if($order['invoice_status'] == '2'){
												echo "<label class='label label-danger'>".display('cancel')."</label>";
											}else if($order['invoice_status'] == '3'){
												echo "<label class='label label-warning'>".display('pending')."</label>";
											}else if($order['invoice_status'] == '4'){
												echo "<label class='label label-success'>".display('complete')."</label>";
											}else if($order['invoice_status'] == '5'){
												echo "<label class='label label-info'>".display('processing')."</label>";
											}else if($order['invoice_status'] == '6'){
												echo "<label class='label label-danger'>".display('return')."</label>";
											}
											?>
										</td>
										<td>
											<center>
												<?php echo form_open()?>
												<?php if ($order['status'] == 1) { ?>
													<?php  if($this->permission->check_label('new_sale')->create()->access()){ ?>
													<a href="<?php echo base_url().'dashboard/Corder/order_paid_data/'.$order['order_id']; ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('invoice') ?>"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
												<?php } }else{ ?>
													<a href="javascript:void(0)" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('invoiced') ?>"><i class="fa fa-check" aria-hidden="true"></i></a>
												<?php } ?>
												<a href="<?php echo base_url('dashboard/Corder/order_details_pdf/'.$order['order_id'])?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('download') ?>" ><i class="fa fa-download" aria-hidden="true"></i></a>
												<?php  if($this->permission->check_label('manage_order')->update()->access()){ ?>
												<a href="<?php echo base_url().'dashboard/Corder/order_update_form/'.$order['order_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
												<?php } if($this->permission->check_label('manage_order')->delete()->access()){ ?>
												<a href="<?php echo base_url('dashboard/Corder/order_delete/'.$order['order_id'])?>" class="btn btn-danger btn-sm"  onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
												<?php } ?>
												<?php echo form_close()?>
											</center>
										</td>
									</tr>
									<?php
								}
							}
							?>
						</tbody>
						</table>
					</div>
					<div class="text-right">
						<?php echo htmlspecialchars_decode($links); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
</div>
<!-- Manage order End -->