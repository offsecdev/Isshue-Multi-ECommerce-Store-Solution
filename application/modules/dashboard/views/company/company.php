<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Company List Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_company') ?></h1>
	        <small><?php echo display('manage_company') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('software_settings') ?></a></li>
	            <li class="active"><?php echo display('manage_company') ?></li>
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


		<!-- Company List -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_company') ?> </h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
				           		<thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th><?php echo display('company_name') ?></th>
										<th><?php echo display('address') ?></th>
										<th><?php echo display('mobile') ?></th>
										<th><?php echo display('website') ?></th>
										<th><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($company_list) {
								?>
								{company_list}
									<tr>
										<td>{sl}</td>
										<td>{company_name}</td>
										<td>{address}</td>
										<td>{mobile}</td>
										<td class="text-center">{website}</td>
										<td>
											<center>
											<?php echo form_open() ?>
											<?php if($this->permission->check_label('manage_company')->update()->access()){ ?>
												<a href="<?php echo base_url().'dashboard/Company_setup/company_update_form/{company_id}'; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?php echo display('update') ?>">
													<i class="fa fa-pencil" aria-hidden="true"></i>
												</a>
											<?php } ?>
											<?php echo form_close()?>
											</center>
										</td>
									</tr>
								{/company_list}
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
<!-- Company List End -->

