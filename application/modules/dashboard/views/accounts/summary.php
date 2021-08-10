<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Inflow Outflow Report Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('account_summary_report') ?></h1>
	        <small><?php echo display('account_summary_report') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('accounts') ?></a></li>
	            <li class="active"><?php echo display('account_summary_report') ?></li>
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
                  <?php if($this->permission->check_label('received')->read()->access()){ ?>
                  	<a href="<?php echo base_url('dashboard/Caccounts')?>" class="btn -btn-info color4 color5 m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_received')?></a>  
                  <?php }if($this->permission->check_label('accounts_summary')->read()->access()){ ?>
                    <a href="<?php echo base_url('dashboard/Caccounts/outflow')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_payment')?></a>
                  <?php } ?>
                </div>
            </div>
        </div>


		<div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 
	                	<?php echo form_open('dashboard/Caccounts/summary_datewise',array('class' => 'form-inline', ))?>
	                		<?php $today = date('m-d-Y'); ?>
							<label class="select"><?php echo display('search_by_date') ?>: <?php echo display('from') ?></label>
								<input type="text" name="from_date"  value="<?php echo html_escape($today); ?>" class="datepicker form-control"/>
							<label class="select"><?php echo display('to') ?></label>
								<input type="text" name="to_date" value="<?php echo html_escape($today); ?>" class="datepicker form-control"/>
			                <label class="select"><?php echo display('account') ?> : </label>
			                <select name="accounts" class="form-control"> 
				                <option> <?php echo display('all') ?> </option>
				                {table_inflow}
				                <option value="{account_table_name}">{account_name}</option>
				                {/table_inflow}
				                {table_outflow}
				                <option value="{account_table_name}">{account_name}</option>
				                {/table_outflow}
			                </select>
							<button type="submit" class="btn btn-success color4"><?php echo display('search') ?></button>
						<?php echo form_close()?>		            
		            </div>
		        </div>
		    </div>
	    </div>

		<!-- Inflow report -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('received_report') ?> </h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
			           			<thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th><?php echo display('accounts_name') ?></th>
										<th><?php echo display('transections') ?></th>
										<th><?php echo display('total_ammount') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($inflow) {
								?>
								{inflow}
									<tr>
										<td>{sl}</td>
										<td>{table}</td>
										<td>{no_transection}</td>
										<td><?php echo ((html_escape($position)==0)?"$currency {sub_total}":"{sub_total} $currency") ?></td>
									</tr>
								{/inflow}
								<?php
									}
								?>
								</tbody>
								<tfoot>
						            <tr>
										<td colspan="3"><?php echo display('total_received_ammount') ?></td>
										<td><?php echo ((html_escape($position)==0)?"$currency {total_inflow}":"{total_inflow} $currency") ?></td>
									</tr>
								</tfoot>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>

		<!-- Outflow report -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('payment_report') ?> </h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample3" class="table table-bordered table-striped table-hover">
				                <thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th><?php echo display('accounts_name') ?></th>
										<th><?php echo display('transections') ?></th>
										<th><?php echo display('total_ammount') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($outflow) {
								?>
								{outflow}
									<tr>
										<td>{sl}</td>
										<td>{table}</td>
										<td>{no_transection}</td>
										<td><?php echo ((html_escape($position)==0)?"$currency {sub_total}":"{sub_total} $currency") ?></td>
									</tr>
								{/outflow}
								<?php
									}
								?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="3"><?php echo display('total_payment_ammount') ?></td>
										<td><?php echo ((html_escape($position)==0)?"$currency {total_outflow}":"{total_outflow} $currency") ?></td>
									</tr>
								</tfoot>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Inflow Outflow Report End -->