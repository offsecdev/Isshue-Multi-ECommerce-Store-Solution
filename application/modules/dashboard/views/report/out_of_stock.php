<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Stock List Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('out_of_stock') ?></h1>
	        <small><?php echo display('out_of_stock') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('stock') ?></a></li>
	            <li class="active"><?php echo display('out_of_stock') ?></li>
	        </ol>
	    </div>
	</section>

	<section class="content">

		<div class="row">
            <div class="col-sm-12">
                <div class="column">
                	<?php if($this->permission->check_label('stock_report_supplier_wise')->read()->access()){ ?>
                  <a href="<?php echo base_url('dashboard/Creport/stock_report_supplier_wise')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"></i> <?php echo display('stock_report_supplier_wise')?></a>  
                  	<?php }?>
                  	<?php if($this->permission->check_label('stock_report_product_wise')->read()->access()){ ?>
                  <a href="<?php echo base_url('dashboard/Creport/stock_report_product_wise')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"></i> <?php echo display('stock_report_product_wise')?></a>  
	                <?php }?>
                </div>
            </div>
        </div>


		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('out_of_stock') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive mt_10">
		                    <table id="" class="table table-bordered table-striped table-hover">
		                        <thead>
									<tr>
										<th class="text-center"><?php echo display('sl') ?></th>
										<th class="text-center"><?php echo display('product_name') ?></th>
										<th class="text-center"><?php echo display('product_model') ?></th>
										<th class="text-center"><?php echo display('unit') ?></th>
										<th class="text-center"><?php echo display('stock') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($out_of_stock) {
								?>
								{out_of_stock}
									<tr>
										<td>{sl}</td>
										<td>
											<a href="<?php echo base_url().'dashboard/Cproduct/product_details/{product_id}'; ?>">
											{product_name}
											</a>	
										</td>
										<td>{product_model}</td>
										<td>{unit}</td>
										<td>{stock}</td>
									</tr>
								{/out_of_stock}
								<?php
									}
								?>
								</tbody>
		                    </table>
		                </div>
			            
		                <div class="text-center">
		                	 <?php if (isset($link)) { echo $link ;} ?>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Stock List End -->