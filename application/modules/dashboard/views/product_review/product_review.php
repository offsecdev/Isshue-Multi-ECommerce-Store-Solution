<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage Product Review Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_product_review') ?></h1>
	        <small><?php echo display('manage_product_review') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('web_settings') ?></a></li>
	            <li class="active"><?php echo display('manage_product_review') ?></li>
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

		<!-- Manage Product Review -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_product_review') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-center"><?php echo display('sl') ?></th>
										<th class="text-center"><?php echo display('product_name') ?></th>
										<th class="text-center"><?php echo display('reviewer_name') ?></th>
										<th class="text-center"><?php echo display('comments') ?></th>
										<th class="text-center"><?php echo display('rate') ?></th>
										<th class="text-center"><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
								if ($product_review_list) {
									foreach ($product_review_list as $value) {
								?>
									<tr>
										<td class="text-center"><?php echo $value['sl']?></td>
										<td class="text-center"><?php echo html_escape($value['product_name'].' - ('.$value['product_model'].')')?></td>
										<td class="text-center"><?php echo html_escape($value['first_name'].' '.$value['last_name'])?></td>
										<td class="text-center"><?php echo $value['comments']?></td>
										<td class="text-center"><?php echo $value['rate']?></td>
										<td>
											<center>
												<?php
												if($this->permission->check_label('product_review')->update()->access()){
		                                            #----status change start---#
		                                            $status=$value['status'];
		                                        if ($status==1) {
		                                                ?>
                                                <a href="<?php echo  base_url();?>dashboard/Cproduct_review/inactive/<?php echo  $value['product_review_id']?>">
                                                    <button class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?php echo display('inactive')?>"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                </a>
		                                                <?php
		                                            }else{
		                                                ?>
                                                <a href="<?php echo  base_url();?>dashboard/Cproduct_review/active/<?php echo  $value['product_review_id']?>">
                                                    <button class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?php echo display('active')?>"><i class="fa fa-check" aria-hidden="true"></i></button>
                                                </a>
		                                        <?php
		                                        }
		                                        #----status change end---#
		                                   		}
		                                        ?>
		                                        <?php if($this->permission->check_label('product_review')->update()->access()){ ?>
												<a href="<?php echo base_url().'dashboard/Cproduct_review/product_review_update_form/'.$value['product_review_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
												<?php }?>
												<a href="#" class="delete_product_review btn btn-danger btn-sm" name="<?php echo  $value['product_review_id']?>" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											</center>
										</td>
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
<!-- Manage Product Review End -->
<script src="<?php echo MOD_URL.'dashboard/assets/js/product_review.js'; ?>"></script>
