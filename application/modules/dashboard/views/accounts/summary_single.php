<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Accounts Summary Report start-->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('accounts_summary_report') ?></h1>
            <small><?php echo display('accounts_summary_report') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('accounts') ?></a></li>
                <li class="active"><?php echo display('accounts_summary_report') ?></li>
            </ol>
        </div>
    </section>

    <section class="content">
    	<div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 
		            	<?php echo form_open('dashboard/Caccounts/summary_datewise/',array('class' => 'form-inline', ))?>
		            		<?php $today = date('m-d-Y'); ?>
							<label class="select"><?php echo display('search_by_date') ?>: <?php echo display('from') ?></label>
							<input type="text" name="from_date"  value="<?php echo html_escape($today); ?>" class="datepicker form-control"/>
							<label class="select"><?php echo display('to') ?></label>
							<input type="text" name="to_date" value="<?php echo html_escape($today); ?>" class="datepicker form-control"/>
	                        <label class="select"><?php echo display('account') ?> : </label>
	                        <select name="accounts" class="form-control">
		                        <option> <?php echo display('all') ?> </option>
		                        {table_inflow}
		                        <option value="{account_table_name}">{account_name}</option>
		                        {/table_inflow}
		                        {table_outflow}
		                        <option value="{account_table_name}">{account_name}</option>
		                        {/table_outflow}
		                        </select>
							<button type="submit" class="btn btn-primary"><?php echo display('search') ?></button>
						<?php echo form_close()?>            
		            </div>
		        </div>
		    </div>
	    </div>

        <!-- New supplier -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('accounts_summary_report') ?></h4>
                        </div>
                    </div>
                 	
                 	<div class="panel-body">
              			<div class="table-responsive">
		                    <table id="dataTableExample3" class="table table-bordered table-striped table-hover">
			              		<thead>
									<tr>
										<th><?php echo display('sl') ?></th>
						                <th><?php echo display('date') ?></th>
										<th><?php echo display('transection_id') ?></th>
										<th><?php echo display('customer_or_supplier') ?></th>
						                <th><?php echo display('description') ?></th>
										<th><?php echo display('total_ammount') ?></th>
						                <th><?php echo display('pay_type') ?></th>
						                <th><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								{accounts}
									<tr>
										<td>{sl}</td>
										<td>{date}</td>
										<td>{transection_id}</td>
						                <td>{customer_id}</td>
										<td>{description}</td>
										<td>{amount}</td>
										<td>{payment_type}</td>
						                <td>
						                    <center>
						                    <?php if($this->permission->check_label('accounts_summary')->read()->access()){ ?>
						                       <a href="<?php echo base_url().'dashboard/Caccounts/inout_edit/{transection_id}/{table}/edit'; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?php echo display('update') ?> "><i class="fa fa-pencil" aria-hidden="true"></i></a>

						                       <a href="<?php echo base_url().'dashboard/Caccounts/inout_edit/{transection_id}/{table}/del'; ?>" class="deletePurchase btn btn-danger btn-sm" name="20170114125203" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
						                    <?php } ?>
						                    </center>
						                </td>
									</tr>
								{/accounts}      
								</tbody>
		                    </table>
		                </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Accounts Summary Report end -->




