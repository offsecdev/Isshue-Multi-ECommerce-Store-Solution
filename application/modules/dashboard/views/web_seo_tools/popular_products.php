<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage Purchase Start -->
<div class="content-wrapper">
	 <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('seo_tools') ?></h1>
            <small><?php echo display('popular_products') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('web_settings') ?></a></li>
                <li class="active"><?php echo display('popular_products') ?></li>
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

		<!-- Manage Purchase report -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('popular_products') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample4" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th><?php echo display('product') ?></th>
										<th><?php echo display('category') ?></th>
										<th><?php echo display('clicks') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php 
								if (!empty($popular_products)) {
									$sl=1;
									foreach ($popular_products as $item) {
								?>
									<tr>
										<td><?php echo $sl++; ?></td>
										<td><?php echo html_escape($item['product_name'])?></td>
										<td><?php echo html_escape($item['category_name'])?></td>
										<td><?php echo html_escape($item['clicks'])?></td>
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
<!-- Manage Purchase End -->