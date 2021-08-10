<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage Coupon Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_coupon') ?></h1>
	        <small><?php echo display('manage_your_coupon') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('web_settings') ?></a></li>
	            <li class="active"><?php echo display('manage_coupon') ?></li>
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
                <?php if($this->permission->check_label('coupon')->create()->access()){ ?>
                  <a href="<?php echo base_url('dashboard/Ccoupon')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_coupon')?></a>
                <?php } ?>  
                </div>
            </div>
        </div>

		<!-- Manage Coupon -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_coupon') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-center"><?php echo display('sl') ?></th>
										<th class="text-center"><?php echo display('coupon_name') ?></th>
										<th class="text-center"><?php echo display('coupon_discount_code') ?></th>
										
										<th class="text-center" ><?php echo display('discount_amount') ?></th>
										<th class="text-center" ><?php echo display('discount_percentage') ?></th>
										<th class="text-center" ><?php echo display('start_date') ?></th>
										<th class="text-center" ><?php echo display('end_date') ?></th>
										<th class="text-center" width="15%"><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
								if ($coupon_list) {
									foreach ($coupon_list as $coupon) {
								?>
									<tr>
										<td class="text-center"><?php echo html_escape($coupon['sl'])?></td>
										<td class="text-center"><?php echo html_escape($coupon['coupon_name'])?></td>
										<td class="text-center"><?php echo html_escape($coupon['coupon_discount_code'])?></td>
										
										<td class="text-center"><?php echo html_escape($coupon['discount_amount'])?></td>
										<td class="text-center"><?php echo html_escape($coupon['discount_percentage'])?></td>
										<td class="text-center"><?php echo html_escape($coupon['start_date'])?></td>
										<td class="text-center"><?php echo html_escape($coupon['end_date'])?></td>
										<td>
											<center>
											<?php
											if($this->permission->check_label('coupon')->update()->access()){
		                                    $status=$coupon['status'];
		                                    if ($status==1) {
		                                    ?>
                                                <a href="<?php echo  base_url();?>dashboard/Ccoupon/inactive/<?php echo  $coupon['coupon_id']?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" data-original-title="<?php echo display('inactive')?>"><i class="fa fa-times" aria-hidden="true"></i>
                                                </a>
                                                <?php
                                            }else{
                                                ?>
                                                <a href="<?php echo  base_url();?>dashboard/Ccoupon/active/<?php echo  $coupon['coupon_id']?>" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?php echo display('active')?>"><i class="fa fa-check" aria-hidden="true"></i>
                                                </a>
	                                        <?php
	                                        }
	                                        }
	                                        ?>
	                                        <?php if($this->permission->check_label('coupon')->update()->access()){?>
												<a href="<?php echo base_url().'dashboard/Ccoupon/coupon_update_form/'.$coupon['coupon_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
											<?php }if($this->permission->check_label('coupon')->delete()->access()){ ?>
												<a href="<?php echo base_url('dashboard/Ccoupon/coupon_delete/'.$coupon['coupon_id'])?>" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											<?php } ?>
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
<!-- Manage Coupon End -->
<script src="<?php echo MOD_URL.'dashboard/assets/js/coupon.js'; ?>"></script>
