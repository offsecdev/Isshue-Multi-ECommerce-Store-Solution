<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage Currency Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_currency') ?></h1>
	        <small><?php echo display('manage_your_currency') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('currency') ?></a></li>
	            <li class="active"><?php echo display('manage_currency') ?></li>
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
                <?php if($this->permission->check_label('add_currency')->create()->access()){?>
                  <a href="<?php echo base_url('dashboard/Ccurrency')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_currency')?></a>
                <?php } ?>
                  <button type="button" class="btn btn-danger m-b-5 m-r-2"><?php echo display('you_must_have_a_default_currency')?></button>

                </div>
            </div>
        </div>

		<!-- Manage Currency -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_currency') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-center"><?php echo display('sl') ?></th>
										<th class="text-center"><?php echo display('currency_name') ?></th>
										<th class="text-center"><?php echo display('currency_icon') ?></th>
										<th class="text-center"><?php echo display('currency_position') ?></th>
										<th class="text-center"><?php echo display('conversion_rate') ?></th>
										<th class="text-center"><?php echo display('default_status') ?></th>
										<th class="text-center"><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($currency_list) {
										foreach ($currency_list as $currency) {
								?>
									<tr>
										<td class="text-center"><?php echo html_escape($currency['sl'])?></td>
										<td class="text-center"><?php echo html_escape($currency['currency_name'])?></td>
										<td class="text-center"><?php echo html_escape($currency['currency_icon'])?></td>
										<td class="text-center">
										<?php 
										 	$currency_position = $currency['currency_position'];
											if ($currency_position == 0) {
											 	echo display('left');
											}else{
												echo display('right');
											}
										?>
										</td>
										<td class="text-center"><?php echo html_escape($currency['convertion_rate'])?></td>
										<td class="text-center">
										<?php 
										 	$default_status = $currency['default_status'];
											if ($default_status == 1) {
											 	echo display('yes');
											}else{
												echo display('no');
											}
										?>
										</td>
										<td>
											<center>
											<?php echo form_open()?>
											<?php if($this->permission->check_label('manage_currency')->update()->access()){ ?>
												<a href="<?php echo base_url().'dashboard/Ccurrency/currency_update_form/'.$currency['currency_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
											<?php }if($this->permission->check_label('manage_currency')->delete()->access()){ ?>
												<a href="<?php echo base_url('dashboard/Ccurrency/currency_delete/'.$currency['currency_id'])?>" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Manage Currency End -->
<script src="<?php echo MOD_URL.'dashboard/assets/js/currency.js'; ?>"></script>
