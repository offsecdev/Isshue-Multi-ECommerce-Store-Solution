<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage contact Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_contact') ?></h1>
	        <small><?php echo display('manage_your_contact') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('web_settings') ?></a></li>
	            <li class="active"><?php echo display('manage_contact') ?></li>
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

		<!-- Manage contact -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_contact') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th><?php echo display('first_name') ?></th>
										<th><?php echo display('last_name') ?></th>
										<th><?php echo display('email') ?></th>
										<th><?php echo display('message') ?></th>
										<th><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
								if ($contact_list) {
									$i=1;
								?>
								{contact_list}
									<tr>
										<td><?php echo $i++; ?></td>
										<td>{first_name}</td>
										<td>{last_name}</td>
										<td>{email}</td>
										<td>{message}</td>
										<td>
											<center>
											<?php echo form_open()?>
											<?php if($this->permission->check_label('contact_form')->update()->access()){ ?>
												<a href="<?php echo base_url().'dashboard/Cweb_setting/contact_update_form/{id}'; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
											<?php }if($this->permission->check_label('contact_form')->delete()->access()){ ?>
												<a href="<?php echo base_url('dashboard/Cweb_setting/contact_delete/{id}')?>" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											<?php }?>
											<?php echo form_close()?>
											</center>
										</td>
									</tr>
								{/contact_list}
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
<!-- Manage Contact End -->