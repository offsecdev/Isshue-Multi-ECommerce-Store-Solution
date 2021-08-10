<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Manage Category Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('category_products') ?></h1>
	        <small><?php echo display('all_category_products') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li class="active"><?php echo display('category_products') ?></li>
	        </ol>
	    </div>
	</section>

	<section class="content">
		<!-- Manage Category -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('category_products') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th class="text-center"><?php echo display('categories') ?></th>
										<th class="text-center"><?php echo display('category_products') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php 
								if(!empty($category_products)){
									$i=1;
									foreach($category_products as $category_product){?>
                                        <tr>
                                        	<td><?php echo $i++; ?></td>
                                            <td><?php echo html_escape($category_product['category_name']) ?></td>
                                            <td><?php echo html_escape($category_product['product_count']) ?></td>
                                        </tr>
                                    <?php } 
                                }?>
								</tbody>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Manage Category End -->
<script src="<?php echo MOD_URL.'dashboard/assets/js/category.js';?>"></script>
