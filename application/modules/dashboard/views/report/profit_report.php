<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Profit Report Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('profit_report') ?></h1>
	        <small><?php echo display('total_profit_report')?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('report') ?></a></li>
	            <li class="active"><?php echo display('profit_report') ?></li>
	        </ol>
	    </div>
	</section>

	<section class="content">
		<!-- Profit report -->

		<div class="row">
            <div class="col-sm-12">
                <div class="column">
                  <?php if($this->permission->check_label('sales_report')->read()->access()){ ?>
                  <a href="<?php echo base_url('Admin_dashboard/todays_sales_report')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i><?php echo display('sales_report')?></a>
              	  <?php } ?>
              	  <?php if($this->permission->check_label('transfer_report')->read()->access()){ ?>
                  <a href="<?php echo base_url('Admin_dashboard/transfer_report')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i><?php echo display('transfer_report')?></a>
                  <?php } ?>
                </div>
            </div>
        </div>
        
		<div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 
		                <?php echo form_open('Admin_dashboard/retrieve_dateWise_profit_report',array('class' => 'form-inline'))?>
		                    <div class="form-group">
		                        <label for="from_date"><?php echo display('start_date') ?>:</label>
		                        <input type="text" name="from_date" class="form-control datepicker" id="from_date" placeholder="<?php echo display('start_date') ?>" >
		                    </div> 

		                    <div class="form-group">
		                        <label for="to_date"><?php echo display('end_date') ?>:</label>
		                        <input type="text" name="to_date" class="form-control datepicker" id="to_date" placeholder="<?php echo display('end_date') ?>">
		                    </div>  

		                    <button type="submit" class="btn btn-success"><?php echo display('search') ?></button>
		               <?php echo form_close()?>
		            </div>
		        </div>
		    </div>
	    </div>

		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('profit_report') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
		                        <thead>
									<tr>
										<th><?php echo display('sales_date') ?></th>
										<th><?php echo display('invoice_no') ?></th>
										<th><?php echo display('total_ammount') ?></th>
										<th><?php echo display('total_profit') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if($total_profit_report) {
								?>
									{total_profit_report}
										<tr>
											<td>{prchse_date}</td>
											<td>
												<a href="<?php echo base_url().'Cinvoice/invoice_inserted_data/{invoice_id}'; ?>">
													{invoice}
												</a>
											</td>
											<td class="text-right">
											<?php echo (($position==0)?"$currency {total_sale}":"{total_sale} $currency") ?>
											</td>
											<td  class="text-right"><?php echo (($position==0)?"$currency {total_profit}":"{total_profit} $currency") ?></td>
										</tr>
									{/total_profit_report}
								<?php
									}
								?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="3" align="right"  class="text-right ft_size_14_i">&nbsp; <b><?php echo display('total_profit') ?> </b></td>
										<td  class="text-right" ><b><?php echo (($position==0)?"$currency {profit_ammount}":"{profit_ammount} $currency") ?></b></td>
									</tr>
								</tfoot>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
 <!-- Profit Report End -->