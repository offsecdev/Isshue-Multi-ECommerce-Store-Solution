<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Bank List Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('bank_list') ?></h1>
	        <small><?php echo display('bank_list') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('settings') ?></a></li>
	            <li class="active"><?php echo display('bank_list') ?></li>
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
                	<?php if($this->permission->check_label('add_new_bank')->create()->access()){ ?>
                  		<a href="<?php echo base_url('dashboard/Csettings/index')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_new_bank')?></a>
              		<?php }?>
                </div>
            </div>
        </div>

		<!-- Bank List -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('bank_list') ?> </h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
			           			<thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th><?php echo display('bank_name') ?></th>
										<th><?php echo display('account_name') ?></th>
										<th><?php echo display('account_no') ?></th>
										<th><?php echo display('branch') ?></th>
										<th><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php if ($bank_list) { 
										foreach ($bank_list as $bank) {
									?>
									<tr>
										<td><?php echo html_escape($bank['sl'])?></td>
										<td><?php echo html_escape($bank['bank_name'])?></td>
										<td><?php echo html_escape($bank['ac_name'])?></td>
										<td><?php echo html_escape($bank['ac_number'])?></td>
										<td><?php echo html_escape($bank['branch'])?></td>
										<td>
											<a href="<?php echo base_url().'dashboard/Csettings/edit_bank/'.html_escape($bank['bank_id']); ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
										</td>
									</tr>
								<?php } }?>
								</tbody>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Bank List End -->

