<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage Brand Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_brand') ?></h1>
	        <small><?php echo display('manage_your_brand') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('brand') ?></a></li>
	            <li class="active"><?php echo display('manage_brand') ?></li>
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
                <?php if($this->permission->check_label('add_brand')->create()->access()){ ?>
                  	<a href="<?php echo base_url('dashboard/Cbrand')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_brand')?></a>
                <?php } ?>
                </div>
            </div>
        </div>

		<!-- Manage Brand -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_brand') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-center"><?php echo display('brand_id') ?></th>
										<th class="text-center"><?php echo display('brand_name') ?></th>
										<th class="text-center"><?php echo display('brand_image') ?></th>
										<th class="text-center"><?php echo display('website') ?></th>
										<th class="text-center"><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($brand_list) {
								?>
								{brand_list}
									<tr>
										<td class="text-center">{brand_id}</td>
										<td class="text-center">{brand_name}</td>
										<td class="text-center"><img src="<?php echo base_url();?>{brand_image}" height="60" width="100"></td>
										<td class="text-center">{website}</td>
										<td>
											<center>
										<?php echo form_open()?>
											<?php if($this->permission->check_label('manage_brand')->update()->access()){ ?>
												<a href="<?php echo base_url().'dashboard/Cbrand/brand_update_form/{brand_id}'; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
											<?php }if($this->permission->check_label('manage_brand')->delete()->access()){ ?>
												<a href="<?php echo base_url('dashboard/Cbrand/brand_delete/{brand_id}')?>" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											<?php } ?>
										<?php echo form_close()?>
											</center>
										</td>
									</tr>
								{/brand_list}
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
<!-- Manage Brand End -->
<script src="<?php echo MOD_URL.'dashboard/assets/js/brand.js'; ?>"></script>
