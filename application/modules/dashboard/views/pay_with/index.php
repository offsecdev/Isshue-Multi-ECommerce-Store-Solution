<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage Category Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_pay_with') ?></h1>
	        <small><?php echo display('manage_pay_with') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li class="active"><?php echo display('manage_pay_with') ?></li>
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
                <?php if($this->permission->check_label('manage_pay_with')->create()->access()){ ?>
                  	<a href="<?php echo base_url('dashboard/Cpay_with/create')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_pay_with')?></a>
                <?php } ?>
                </div>
            </div>
        </div>

		<!-- Manage Category -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_pay_with') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-center"><?php echo display('id') ?></th>
										<th class="text-center"><?php echo display('title') ?></th>
										<th class="text-center"><?php echo display('link') ?></th>
										<th class="text-center"><?php echo display('image') ?></th>
										<th class="text-center"><?php echo display('status') ?></th>
										<th class="text-center"><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
								$i=1;
								if ($pay_with_lists) {
									foreach ($pay_with_lists as $pay_with_list) {
								?>
									<tr>
										<td class="text-center"><?php echo $i++?></td>
										<td class="text-center"><?php echo html_escape($pay_with_list['title'])?></td>
										<td class="text-center"><?php echo html_escape($pay_with_list['link'])?></td>
										<td class="text-center">
											<img width="80" height="50" src="<?php echo base_url().'/my-assets/image/pay_with/'.$pay_with_list['image']?>" alt="">											
												
											</td>
										<?php if(1==$pay_with_list['status']){?>
										<td class="text-center text-success">Active</td>					
									<?php }else{?>
										<td class="text-center text-danger">Inactive</td>					
										<?php }?>
										<td>
											<center>
											<?php echo form_open()?>
											<?php if($this->permission->check_label('manage_pay_with')->update()->access()){ ?>
												<a href="<?php echo base_url().'dashboard/Cpay_with/edit/'.$pay_with_list['id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
											<?php }if($this->permission->check_label('manage_pay_with')->delete()->access()){ ?>
												<a href="<?php echo base_url('dashboard/Cpay_with/delete/'.$pay_with_list['id'])?>" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');"  data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											<?php }?>
											<?php echo form_close()?>
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
<!-- Manage Category End -->
<script src="<?php echo MOD_URL.'dashboard/assets/js/index.js'; ?>"></script>
