<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Product Report Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('sales_report_product_wise') ?></h1>
	        <small><?php echo display('sales_report_product_wise') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('report') ?></a></li>
	            <li class="active"><?php echo display('sales_report_product_wise') ?></li>
	        </ol>
	    </div>
	</section>

	<section class="content">
		<div class="row">
            <div class="col-sm-12">
                <div class="column">
                  <a href="<?php echo base_url('Admin_dashboard/all_report')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i><?php echo display('todays_report')?></a>
                  <?php if($this->permission->check_label('sales_report')->read()->access()){ ?>
                  <a href="<?php echo base_url('Admin_dashboard/todays_sales_report')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i><?php echo display('sales_report')?></a>
              	  <?php }?>
              	  <?php if($this->permission->check_label('purchase_report')->read()->access()){ ?>
                  <a href="<?php echo base_url('Admin_dashboard/todays_purchase_report')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i><?php echo display('purchase_report')?></a>
              	  <?php } ?>
                </div>
            </div>
        </div>


		<!-- Product report -->
		<div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 
		                <?php echo form_open('Admin_dashboard/product_sales_search_reports',array('class' => 'form-inline'))?>
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
		                    <h4><?php echo display('sales_report_product_wise') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
		                       <thead>
									<tr>
										<th><?php echo display('sales_date') ?></th>
										<th><?php echo display('product_name') ?></th>
										<th><?php echo display('product_model') ?></th>
										<th><?php echo display('customer_name') ?></th>
										<th><?php echo display('rate') ?></th>
										<th><?php echo display('total_ammount') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($product_report) {
								?>
								{product_report}
									<tr>
										<td>{sales_date}</td>
										<td>{product_name}</td>
										<td>{product_model}</td>
										<td>{customer_name}</td>
										<td class="text-right"><?php echo (($position==0)?"$currency {rate}":"{rate} $currency") ?></td>
										<td class="text-right"><?php echo (($position==0)?"$currency {total_amount}":"{total_amount} $currency") ?></td>
									</tr>
								{/product_report}
								<?php
									}
								?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="5" align="right" class="text-right ft_size_14_i">&nbsp; <b><?php echo display('total_ammount') ?></b></td>
										<td class="text-right"><b><?php echo (($position==0)?"$currency {sub_total}":"{sub_total} $currency") ?></b></td>
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
 <!-- Product Report End -->
