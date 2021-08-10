<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Supplier Ledger Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('supplier_ledger') ?></h1>
	        <small><?php echo display('manage_supplier_ledger') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('supplier') ?></a></li>
	            <li class="active"><?php echo display('supplier_ledger') ?></li>
	        </ol>
	    </div>
	</section>

	<!-- Supplier information -->
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
                  <a href="<?php echo base_url('dashboard/Csupplier')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_supplier')?></a>  
                <?php }if($this->permission->check_label('manage_supplier')->read()->access()){ ?>
                  <a href="<?php echo base_url('dashboard/Csupplier/manage_supplier')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_supplier')?></a>
                <?php } ?>

                </div>
            </div>
        </div>

        <!-- Supplier select -->
       	<div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 
		            	<?php echo form_open('dashboard/Csupplier/supplier_ledger_report'); ?>

		                    <div class="form-group row">
	                            <label for="supplier_name" class="col-sm-2 col-form-label"><?php echo display('select_supplier')?>:</label>
	                            <div class="col-sm-6">
	                                <select class="form-control" name="supplier_id" id="supplier_id">
			                        {suppliers_list}
                                        <option value=""></option>
			                        	<option value="{supplier_id}">{supplier_name}</option>
			                        {/suppliers_list}
			                        </select>
	                            </div>
	                            <div class="col-sm-2">
	                            	<button type="submit" class="btn btn-success"><?php echo display('search')?></button>
	                        	</div>
	                        </div>
		               <?php echo form_close(); ?>		            
		            </div>
		        </div>
		    </div>
	    </div>

	    <?php
	    if ($supplier_name) {
	    ?>

		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('supplier_information') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
	  					<div class="ft_left">
							<h4>{supplier_name}</h4>
						</div>
						<div class="ft_right mr_100">
							<table class="table table-striped table-condensed table-bordered">
								<tr><td> <?php echo display('debit_ammount')?> </td> <td > <?php if ($total_debit) { echo (($position==0)?"$currency {total_debit}":"{total_debit} $currency");} ?></td> </tr>
								<tr><td><?php echo display('credit_ammount')?></td> <td class="balance_txt"> <?php if ($total_credit) { echo (($position==0)?"$currency {total_credit}":"{total_credit} $currency");} ?></td> </tr>
								<tr><td><?php echo display('balance_ammount')?> </td> <td class="balance_txt"> <?php if ($total_balance) { echo (($position==0)?"$currency {total_balance}":"{total_balance} $currency");} ?></td> </tr>
							</table>
						</div>
		            </div>
		        </div>
		    </div>
		</div>

		<!-- Manage Supplier -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('supplier_ledger') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-center"><?php echo display('date') ?></th>
										<th class="text-center"><?php echo display('invoice_id') ?></th>
										<th class="text-center"><?php echo display('deposit_id') ?></th>
										<th class="text-center"><?php echo display('description') ?></th>
										<th class="text-center"><?php echo display('debit') ?></th>
										<th class="text-center"><?php echo display('credit') ?></th>
										<th class="text-center"><?php echo display('balance') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
								if ($ledger) {
								?>
								{ledger}
									<tr>
										<td>{final_date}</td>
										<td>
											<a href="<?php echo base_url().'dashboard/Cpurchase/purchase_details_data/{purchase_id}';?>">{invoice_no} <i class="fa fa-tasks pull-right" aria-hidden="true"></i> </a>
										</td>
										<td>{deposit_no}</td>
										<td>{description}</td>
										<td><?php echo (($position==0)?"$currency {debit}":"{debit} $currency") ?></td>
										<td><?php echo (($position==0)?"$currency {credit}":"{credit} $currency") ?></td>
										<td><?php echo (($position==0)?"$currency {balance}":"{balance} $currency") ?></td>
									</tr>
								{/ledger}
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
		<?php
		}
		?>
	</section>
</div>
<!-- Supplier Ledger End 