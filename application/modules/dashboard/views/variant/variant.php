<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!--Manage Variant Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_variant') ?></h1>
	        <small><?php echo display('manage_variant') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('variant') ?></a></li>
	            <li class="active"><?php echo display('manage_variant') ?></li>
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
                <?php if($this->permission->check_label('add_variant')->create()->access()){ ?>
                  	<a href="<?php echo base_url('dashboard/Cvariant')?>" class="btn btn-success m-b-5 m-r-2">
                  		<i class="ti-plus"> </i> <?php echo display('add_variant')?>
                  	</a>
                <?php } ?>
                </div>
            </div>
        </div>

		<!--Manage Variant -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_variant') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-center"><?php echo display('variant_id') ?></th>
										<th class="text-center"><?php echo display('variant_name') ?></th>
										<th class="text-center"><?php echo display('variant_type') ?></th>
										<th class="text-center"><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($variant_list) {
								?>
								{variant_list}
									<tr>
										<td class="text-center">{variant_id}</td>
										<td class="text-center">{variant_name}</td>
										<td class="text-center">{variant_type}</td>
										<td>
											<center>
											<?php echo form_open()?>
											<?php if($this->permission->check_label('manage_variant')->update()->access()){ ?>
												<a href="<?php echo base_url().'dashboard/Cvariant/variant_update_form/{variant_id}'; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
											<?php }if($this->permission->check_label('manage_variant')->delete()->access()){ ?>
												<a href="<?php echo base_url().'dashboard/Cvariant/variant_delete/{variant_id}'; ?>" class="btn btn-danger btn-sm" name="{variant_id}" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											<?php } ?>
											<?php echo form_close()?>
											</center>
										</td>
									</tr>
								{/variant_list}
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
<!--Manage Variant End -->

