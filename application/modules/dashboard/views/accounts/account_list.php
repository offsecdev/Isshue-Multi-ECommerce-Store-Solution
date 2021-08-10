<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Account List Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_account') ?></h1>
	        <small><?php echo display('manage_account') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('settings') ?></a></li>
	            <li class="active"><?php echo display('manage_account') ?></li>
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
               	<?php if($this->permission->check_label('create_accounts')->create()->access()){ ?>
                  <a href="<?php echo base_url('dashboard/Caccounts/create_account')?>" class="btn btn-success color4 m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('create_accounts')?></a>
                <?php } ?>
                </div>
            </div>
        </div>

		<!-- Account List -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_account') ?> </h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
			           			<thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th><?php echo display('account_name') ?></th>
										<th><?php echo display('account_type') ?></th>
										<th><?php echo display('action') ?></th>
									</tr>
									</thead>
									<tbody>
									<?php
									if ($account_list) {
										foreach ($account_list as $table) {
									?>
										<tr>
											<td><?php echo $table['sl']?></td>
											<td><?php echo html_escape($table['account_name'])?></td>
											<td>
											<?php 
												$account_type= $table['status'];
												if ($account_type == 1) {
													echo display('payment');
												}else{
													echo display('received');
												}
											?>
											</td>
											<td>
												<center>
													<?php if($this->permission->check_label('manage_accounts')->update()->access()){ ?>
														<a href="<?php echo base_url('dashboard/Caccounts/account_edit/'.$table['account_id']); ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="" data-original-title="Update"><i class="fa fa-pencil" aria-hidden="true"></i></a>
													<?php }?>
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
<!-- Account List End -->

