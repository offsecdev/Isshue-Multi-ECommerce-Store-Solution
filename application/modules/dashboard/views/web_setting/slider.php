<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage Slider Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_slider') ?></h1>
	        <small><?php echo display('manage_your_slider') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('web_settings') ?></a></li>
	            <li class="active"><?php echo display('manage_slider') ?></li>
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
                	<?php if($this->permission->check_label('slider')->create()->access()){?>
                  	<a href="<?php echo base_url('dashboard/Cweb_setting/add_slider')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_slider')?></a>
                  	<?php } ?>
                </div>
            </div>
        </div>

		<!-- Manage Slider -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_slider') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th><?php echo display('slider_link') ?></th>
										<th><?php echo display('slider_image') ?></th>
										<th><?php echo display('slider_position') ?></th>
										<th><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
								if ($slider_list) {
								foreach ($slider_list as $slider) {
								?>
									<tr>
										<td><?php echo $slider['sl']?></td>
										<td><?php echo html_escape($slider['slider_link'])?></td>
										<td>
											<img src="<?php echo base_url().$slider['slider_image']?>" class="img img-responsive" height="80" width="80">
										</td>
										<td><?php echo html_escape($slider['slider_position'])?></td>
										<td>
											<center>
											<?php echo form_open()?>
												<?php
												if($this->permission->check_label('slider')->update()->access()){
													$status = html_escape($slider['status']);
													if ($status == 1) {
													?>
														<a href="<?php echo base_url().'dashboard/Cweb_setting/inactive/'.$slider['slider_id']; ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('inactive') ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
													<?php
													}else{
													?>
														<a href="<?php echo base_url().'dashboard/Cweb_setting/active/'.$slider['slider_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('active') ?>"><i class="fa fa-check" aria-hidden="true"></i></a>
													<?php
													}
												}
												?>
												<?php if($this->permission->check_label('slider')->update()->access()){ ?>
												<a href="<?php echo base_url().'dashboard/Cweb_setting/slider_update_form/'.$slider['slider_id']; ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>">
													<i class="fa fa-pencil" aria-hidden="true"></i>
												</a>
												<?php }if($this->permission->check_label('slider')->delete()->redirect()){ ?>
												<a href="<?php echo base_url('dashboard/Cweb_setting/slider_delete/'.$slider['slider_id'])?>" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> ">
													<i class="fa fa-trash-o" aria-hidden="true"></i>
												</a>
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
<!-- Manage Slider End -->