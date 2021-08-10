<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Our Location Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_our_location') ?></h1>
	        <small><?php echo display('manage_our_location') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('web_settings') ?></a></li>
	            <li class="active"><?php echo display('manage_our_location') ?></li>
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
                	<?php if($this->permission->check_label('our_location')->create()->access()){ ?>
                  		<a href="<?php echo base_url('dashboard/Cour_location')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"></i><?php echo display('add_our_location')?></a>
                	<?php } ?>
                </div>
            </div>
        </div>

		<!-- Our Location -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_our_location') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-center"><?php echo display('sl') ?></th>
										<th class="text-center"><?php echo display('language') ?></th>
										<th class="text-center"><?php echo display('headlines') ?></th>
										<th class="text-center"><?php echo display('details') ?></th>
										<th class="text-center"><?php echo display('position') ?></th>
										<th class="text-center"><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
								if ($our_location_list) {
									foreach ($our_location_list as $our_location) {
								?>
									<tr>
										<td class="text-center"><?php echo $our_location['sl']?></td>
										<td class="text-center"><?php echo html_escape($our_location['language_id'])?></td>
										<td class="text-center"><?php echo $our_location['headline']?></td>
										<td class="text-center" width="280"><?php echo character_limiter($our_location['details'], 50);?></td>
										<td class="text-center"><?php echo html_escape($our_location['position'])?></td>
										<td>
											<center>
											<?php if($this->permission->check_label('our_location')->update()->access()){ 
		                                    $status=$our_location['status'];
		                                    if ($status==1) {
		                                    ?>
	                                            <a href="<?php echo  base_url();?>dashboard/Cour_location/inactive/<?php echo  $our_location['position']?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" data-original-title="<?php echo display('inactive')?>">
	                                                <i class="fa fa-times" aria-hidden="true"></i>
	                                            </a>
                                        	<?php } else{
                                                ?>
                                                <a href="<?php echo  base_url();?>dashboard/Cour_location/active/<?php echo  $our_location['position']?>" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?php echo display('active')?>">
                                                	<i class="fa fa-check" aria-hidden="true"></i>
                                                </a>
		                                        <?php 	}	}	?>
		                                    <?php if($this->permission->check_label('our_location')->update()->access()){ ?>
												<a href="<?php echo base_url().'dashboard/Cour_location/our_location_update_form/'.$our_location['position']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>">
													<i class="fa fa-pencil" aria-hidden="true"></i>
												</a>
											<?php }if($this->permission->check_label('our_location')->delete()->access()){ ?>
												<a href="<?php echo base_url('dashboard/Cour_location/our_location_delete/'.$our_location['position'])?>" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo display('delete') ?> ">
													<i class="fa fa-trash-o" aria-hidden="true"></i>
												</a>
											<?php } ?>
											</center>
										</td>
									</tr>
								<?php }  }	?>
								</tbody>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Our Location End -->
<script src="<?php echo MOD_URL.'dashboard/assets/js/our_location.js'; ?>"></script>
