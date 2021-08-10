<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage Wearhouse Product Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_wearhouse_product') ?></h1>
	        <small><?php echo display('manage_wearhouse_product') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('wearhouse_set') ?></a></li>
	            <li class="active"><?php echo display('manage_wearhouse_product') ?></li>
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
                  	<a href="<?php echo base_url('Cwearhouse')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_wearhouse')?></a>
                  	<a href="<?php echo base_url('Cwearhouse/manage_wearhouse')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_wearhouse')?></a>
                  	<a href="<?php echo base_url('Cwearhouse/wearhouse_transfer')?>" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('wearhouse_transfer')?></a>
                </div>
            </div>
        </div>

		<!-- Manage Wearhouse Product -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_wearhouse_product') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-center"><?php echo display('sl') ?></th>
										<th class="text-center"><?php echo display('wearhouse_name') ?></th>
										<th class="text-center"><?php echo display('product_name') ?></th>
										<th class="text-center"><?php echo display('variant') ?></th>
										<th class="text-center"><?php echo display('quantity') ?></th>

									</tr>
								</thead>
								<tbody>
								<?php
								if ($wearhouse_product_list) {
								?>
								{wearhouse_product_list}
									<tr>
										<td class="text-center">{sl}</td>
										<td class="text-center">{wearhouse_name}</td>
										<td class="text-center"><a href="<?php echo base_url('dashboard/Cproduct/product_details/{product_id}')?>">
										{product_name}-({product_model})</a></td>
										<td class="text-center">{variant_name}</td>
										<td class="text-center">{quantity}</td>

									</tr>
								{/wearhouse_product_list}
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
<!-- Manage Wearhouse Product End -->
<script src="<?php echo MOD_URL.'dashboard/assets/js/manage_wearhouse_product.js'; ?>"></script>
