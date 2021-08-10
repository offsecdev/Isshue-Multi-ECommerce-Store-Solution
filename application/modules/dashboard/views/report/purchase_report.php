<script src="<?php echo MOD_URL.'dashboard/assets/js/print.js'; ?>"></script>
<!-- Purchase Report Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('purchase_report') ?></h1>
	        <small><?php echo display('total_purchase_report')?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('report') ?></a></li>
	            <li class="active"><?php echo display('purchase_report') ?></li>
	        </ol>
	    </div>
	</section>

	<section class="content">
		<div class="row">
            <div class="col-sm-12">
                <div class="column">
                	<?php if($this->permission->check_label('sales_report')->read()->access()){?>
                  	<a href="<?php echo base_url('dashboard/Admin_dashboard/todays_sales_report')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('sales_report')?> </a>
              		<?php } ?>
                </div>
            </div>
        </div>

		<!-- Purchase report -->
		<div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 
		                <?php echo form_open('dashboard/Admin_dashboard/retrieve_dateWise_PurchaseReports',array('class' => 'form-inline'))?>
		                <?php 
date_default_timezone_set(DEF_TIMEZONE); $today = date('Y-m-d'); ?>
		                    <div class="form-group">
		                        <label class="" for="from_date"><?php echo display('start_date') ?></label>
		                        <input type="text" name="from_date" class="form-control datepicker" id="from_date" placeholder="<?php echo display('start_date') ?>"  autocomplete="off" required>
		                    </div> 

		                    <div class="form-group">
		                        <label class="" for="to_date"><?php echo display('end_date') ?></label>
		                        <input type="text" name="to_date" class="form-control datepicker" id="to_date" placeholder="<?php echo display('end_date') ?>" value="<?php echo $today?>" autocomplete="off" required>
		                    </div>  

		                    <button type="submit" class="btn btn-success"><?php echo display('search') ?></button>
		                    <a  class="btn btn-warning" href="#" onclick="printDiv('purchase_div')"><?php echo display('print') ?></a>
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
		                    <h4><?php echo display('purchase_report') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		            	<div id="purchase_div" class="ml_2">
			            	<div class="text-center">
								{company_info}
								<h3> {company_name} </h3>
								<h4 >{address} </h4>
								{/company_info}
								<h4> <?php echo display('print_date') ?>: <?php echo date("d/m/Y h:i:s"); ?> </h4>
							</div>
			                <div class="table-responsive">
			                    <table class="table table-bordered table-striped table-hover">
			                        <thead>
										<tr>
											<th><?php echo display('sales_date') ?></th>
											<th><?php echo display('invoice_no') ?></th>
											<th><?php echo display('supplier_name') ?></th>
											<th><?php echo display('total_ammount') ?></th>
										</tr>
									</thead>
									<tbody>
									<?php if($purchase_report) { ?>
										{purchase_report}
											<tr>
												<td>{prchse_date}</td>
												<td>
													<a href="<?php echo base_url().'dashboard/cpurchase/purchase_details_data/{purchase_id}'; ?>">
														{invoice_no} <i class="fa fa-tasks pull-right" aria-hidden="true"></i>
													</a>
												</td>
												<td>{supplier_name}</td>
												<td class="text-right"><?php echo (($position==0)?"$currency {grand_total_amount}":"{grand_total_amount} $currency") ?></td>
											</tr>
										{/purchase_report}
									<?php } ?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="3" align="right"  class="text-right ft_size_14_i">&nbsp; <b><?php echo display('total_purchase') ?> </b></td>
											<td class="text-right"><b><?php echo (($position==0)?"$currency {purchase_amount}":"{purchase_amount} $currency") ?></b></td>
										</tr>
									</tfoot>
			                    </table>
			                </div>
			            </div>
			            <div class="text-right">
			            <?php 
			            if ($links) {
			            	echo $links;
			            }
			            ?></div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Purchase Report End -->