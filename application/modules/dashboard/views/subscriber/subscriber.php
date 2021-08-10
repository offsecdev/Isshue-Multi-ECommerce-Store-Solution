<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage Subscriber Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_subscriber') ?></h1>
	        <small><?php echo display('manage_your_subscriber') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('web_settings') ?></a></li>
	            <li class="active"><?php echo display('manage_subscriber') ?></li>
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


		<!-- Manage Subscriber -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_subscriber') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-center"><?php echo display('sl') ?></th>
										<th class="text-center"><?php echo display('apply_ip') ?></th>
										<th class="text-center"><?php echo display('email') ?></th>
										<th class="text-center"><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
								if ($subscriber_list) {
									foreach ($subscriber_list as $subscriber) {
								?>
									<tr>
										<td class="text-center"><?php echo $subscriber['sl']?></td>
										<td class="text-center"><?php echo html_escape($subscriber['apply_ip'])?></td>
										<td class="text-center"><?php echo html_escape($subscriber['email'])?></td>
										<td>
											<center>
											<?php
											if($this->permission->check_label('subscriber')->update()->access()){
			                                    $status=$subscriber['status'];
			                                    if ($status==1) {
			                                    ?>
	                                                <a href="<?php echo  base_url();?>dashboard/Csubscriber/inactive/<?php echo  $subscriber['subscriber_id']?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" data-original-title="<?php echo display('inactive')?>"><i class="fa fa-times" aria-hidden="true"></i>
	                                                </a>
	                                                <?php
	                                            }else{
	                                                ?>
	                                                <a href="<?php echo  base_url();?>dashboard/Csubscriber/active/<?php echo  $subscriber['subscriber_id']?>" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?php echo display('active')?>"><i class="fa fa-check" aria-hidden="true"></i>
	                                                </a>
		                                        <?php
		                                        }
	                                        }
	                                        ?>
	                                        <?php if($this->permission->check_label('subscriber')->update()->access()){ ?>
												<a href="<?php echo base_url().'dashboard/Csubscriber/subscriber_update_form/'.$subscriber['subscriber_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>">
													<i class="fa fa-pencil" aria-hidden="true"></i>
												</a>
											<?php }if($this->permission->check_label('subscriber')->delete()->access()){ ?>
												<a href="<?php echo base_url('dashboard/Csubscriber/subscriber_delete/'.$subscriber['subscriber_id'])?>" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');"  data-toggle="tooltip" data-placement="right" data-original-title="<?php echo display('delete') ?> ">
													<i class="fa fa-trash-o" aria-hidden="true"></i>
												</a>
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
<!-- Manage Subscriber End -->
<script src="<?php echo MOD_URL.'dashboard/assets/js/subscriber.js'; ?>"></script>

