<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage wearhouse Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_wearhouse') ?></h1>
	        <small><?php echo display('manage_your_wearhouse') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('wearhouse_set') ?></a></li>
	            <li class="active"><?php echo display('manage_wearhouse') ?></li>
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
                
                  <a href="<?php echo base_url('Cwearhouse')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_wearhouse')?></a>

                  <a href="<?php echo base_url('Cwearhouse/wearhouse_transfer')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('wearhouse_transfer')?></a>

                  <a href="<?php echo base_url('Cwearhouse/manage_wearhouse_product')?>" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_wearhouse_product')?></a>

                </div>
            </div>
        </div>

		<!-- Manage wearhouse -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_wearhouse') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-center"><?php echo display('sl') ?></th>
										<th class="text-center"><?php echo display('wearhouse_name') ?></th>
										<th class="text-center"><?php echo display('wearhouse_address') ?></th>
										<th class="text-center"><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($wearhouse_list) {
								?>
								{wearhouse_list}
									<tr>
										<td class="text-center">{sl}</td>
										<td class="text-center">{wearhouse_name}</td>
										<td class="text-center">{wearhouse_address}</td>
										<td>
											<center>
											<?php echo form_open()?>
												<a href="<?php echo base_url().'Cwearhouse/wearhouse_update_form/{wearhouse_id}'; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>

												<a href="<?php echo base_url('Cwearhouse/wearhouse_delete/{wearhouse_id}')?>" class="delete_wearhouse btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											<?php echo form_close()?>
											</center>
										</td>
									</tr>
								{/wearhouse_list}
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
<!-- Manage wearhouse End -->



