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
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('order') ?></a></li>
	            <li class="active"><?php echo display('manage_order') ?></li>
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
                  	<a href="<?php echo base_url('customer/order')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('new_order')?></a>
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
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
		                    	<thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th><?php echo display('order_no') ?></th>
										<th><?php echo display('date') ?></th>
										<th><?php echo display('total_amount') ?></th>
										<th><?php echo display('service_charge') ?></th>
										<th><?php echo display('paid') ?></th>
										<th><?php echo display('due') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
								if ($orders_list) {
									foreach ($orders_list as $order) {
								?>
									<tr>
										<td><?php echo html_escape($order['sl'])?></td>
										<td><?php echo html_escape($order['order'])?></td>
										<td><?php echo html_escape($order['final_date'])?></td>
										<td class="text-right"><?php echo (($position==0)?$currency.' '.html_escape($order['total_amount']):html_escape($order['total_amount']).' '.$currency) ?></td><td class="text-right"><?php echo (($position==0)?$currency.' '.html_escape($order['service_charge']):html_escape($order['service_charge']).' '.$currency) ?></td>
										<td class="text-right"><?php echo (($position==0)?$currency.' '.html_escape($order['paid_amount']):html_escape($order['paid_amount']).' '.$currency) ?></td>
										<td class="text-right"><?php echo (($position==0)?$currency.' '.html_escape($order['due_amount']):html_escape($order['due_amount']).' '.$currency) ?></td>
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
<!-- Manage order End -->