<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage Supplier Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_suppiler') ?></h1>
	        <small><?php echo display('manage_your_supplier') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('supplier') ?></a></li>
	            <li class="active"><?php echo display('manage_suppiler') ?></li>
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
                	<?php if($this->permission->check_label('add_supplier')->create()->access()){ ?>
                  	<a href="<?php echo base_url('dashboard/Csupplier')?>" class="btn btn-success m-b-5 m-r-2">
                  		<i class="ti-plus"> </i> <?php echo display('add_supplier')?></a>
                  	<?php }if($this->permission->check_label('supplier_ledger')->read()->access()){ ?>
                   	<a href="<?php echo base_url('dashboard/Csupplier/supplier_ledger_report')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('supplier_ledger')?></a>
               		<?php }?>
                </div>
            </div>
        </div>

		<!-- Manage Supplier -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_suppiler') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th><?php echo display('supplier_id') ?></th>
										<th><?php echo display('supplier_name') ?></th>
										<th><?php echo display('address') ?></th>
										<th><?php echo display('email') ?></th>
										<th><?php echo display('mobile') ?></th>
										<th><?php echo display('details') ?></th>
										<th><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($suppliers_list) {
								?>
								{suppliers_list}
									<tr>
										<td>{supplier_id}</td>
										<td width="15%">
											<a href="<?php echo base_url().'dashboard/Csupplier/supplier_ledger/{supplier_id}'; ?>">
                                                 {supplier_name} <i class="fa fa-user pull-right" aria-hidden="true"></i>
											</a>
										</td>
										<td>{address}</td>
										<td>{email}</td>
										<td>{mobile}</td>
										<td>{details}</td>
										<td>
											<center>
											<?php echo form_open()?>
												<?php if($this->permission->check_label('manage_supplier')->update()->access()){ ?>
												<a href="<?php echo base_url().'dashboard/Csupplier/supplier_update_form/{supplier_id}'; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>">
													<i class="fa fa-pencil" aria-hidden="true"></i>
												</a>
												<?php }if($this->permission->check_label('manage_supplier')->delete()->access()){?>
												<a href="<?php echo base_url().'dashboard/Csupplier/supplier_delete/{supplier_id}'; ?>" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> ">
													<i class="fa fa-trash-o" aria-hidden="true"></i>
												</a>
												<?php } ?>
											<?php echo form_close()?>
											</center>
										</td>
									</tr>
								{/suppliers_list}
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
<!-- Manage Product End -->