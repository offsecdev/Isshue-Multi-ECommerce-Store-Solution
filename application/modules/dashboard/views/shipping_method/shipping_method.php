<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage Shipping Method Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_shipping_method') ?></h1>
	        <small><?php echo display('manage_shipping_method') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('web_settings') ?></a></li>
	            <li class="active"><?php echo display('manage_shipping_method') ?></li>
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
                	<?php if($this->permission->check_label('shipping_method')->create()->access()){ ?>
                  	<a href="<?php echo base_url('dashboard/Cshipping_method')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_shipping_method')?></a>
                  <?php } ?>
                </div>
            </div>
        </div>

		<!-- Manage Shipping Method -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_shipping_method') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-center"><?php echo display('sl') ?></th>
										<th class="text-center"><?php echo display('name') ?></th>
										<th class="text-center"><?php echo display('details') ?></th>
										<th class="text-center"><?php echo display('ammount') ?></th>
										<th class="text-center"><?php echo display('position') ?></th>
										<th class="text-center"><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
								if ($shipping_method_list) {
									foreach ($shipping_method_list as $value) {
								?>
									<tr>
										<td class="text-center"><?php echo $value['sl']?></td>
										<td class="text-center"><?php echo html_escape($value['method_name'])?></td>
										<td class="text-center"><?php echo html_escape($value['details'])?>
										<td class="text-center"><?php echo html_escape($value['charge_amount'])?></td>
										<td class="text-center"><?php echo html_escape($value['position'])?></td>
										<td>
											<center>
												<?php if($this->permission->check_label('shipping_method')->update()->access()){?>
													<a href="<?php echo base_url().'dashboard/Cshipping_method/shipping_method_update_form/'.html_escape($value['method_id']); ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>">
														<i class="fa fa-pencil" aria-hidden="true"></i>
													</a>
												<?php }if($this->permission->check_label('shipping_method')->delete()->access()){ ?>
												<a href="<?php echo base_url('dashboard/Cshipping_method/shipping_method_delete/'.$value['method_id'])?>" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo display('delete') ?> ">
													<i class="fa fa-trash-o" aria-hidden="true"></i>
												</a>
												<?php } ?>
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
<!-- Manage Shipping Method End -->


