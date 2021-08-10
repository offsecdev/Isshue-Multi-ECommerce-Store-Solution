<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Cheaque Manager Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('cheque_manager') ?></h1>
	        <small><?php echo display('cheque_manager') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('accounts') ?></a></li>
	            <li class="active"><?php echo display('cheque_manager') ?></li>
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
                  <?php if($this->permission->check_label('received')->read()->access()){ ?>
                  	<a href="<?php echo base_url('dashboard/Caccounts')?>" class="btn -btn-info color4 color5 m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_received')?></a>  
                  <?php }if($this->permission->check_label('payment')->read()->access()){ ?>
                    <a href="<?php echo base_url('dashboard/Caccounts/outflow')?>" class="btn btn-success color4 m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_payment')?></a>
                  <?php } ?>
                </div>
            </div>
        </div>


		<!-- Inflow report -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('cheque_manager') ?> </h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
			           			<thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th><?php echo display('date') ?></th>
										<th><?php echo display('cheque_no') ?></th>
										<th><?php echo display('customer_or_supplier') ?></th>
										<th><?php echo display('transection_type') ?></th>
										<th><?php echo display('bank_name') ?></th>
										<th><?php echo display('ammount') ?></th>
										<th><?php echo display('action') ?> </th>
									</tr>
								</thead>
								<tbody>
								<?php
								if ($cheque_manager) {
								?>
								{cheque_manager}
									<tr>
										<td>{sl}</td>
										<td>{date}</td>
										<td>{cheque_no}</td>
						                <td>{name} <i class="fa fa-user pull-right" aria-hidden="true"></i> </td>
						                <td>{transection_type}</td>
										<td>{bank_name}</td>
										<td><?php echo ((html_escape($position)==0)?"$currency {amount}":"{amount} $currency") ?></td>
						                <td>
						                    <center>
						                    <?php if($this->permission->check_label('cheque_manager')->update()->access()){ ?>
					                            <a href="<?php echo base_url().'dashboard/Caccounts/cheque_manager_edit/{transection_id}/{action}'; ?>">{action_value}</a>
					                        <?php }?>
						                    </center>
						                </td>
									</tr>
								{/cheque_manager} 
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
<!-- Cheaque Manager End -->