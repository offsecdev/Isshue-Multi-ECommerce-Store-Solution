<!-- Manage store Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_time_slot') ?></h1>
	        <small><?php echo display('manage_time_slot') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('manage_time_slot') ?></a></li>
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
                	<?php if($this->permission->check_label('add_time_slot')->create()->access()){ ?>
                  		<a href="<?php echo base_url('dashboard/Cdelivery_system/add_time_slot')?>" class="btn -btn-info color4 color5 m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_time_slot'); ?></a>
                  	<?php } ?>
                </div>
            </div>
        </div>
		<!-- Manage store -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_time_slot') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample3" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-center"><?php echo display('sl') ?></th>
										<th class="text-center"><?php echo display('title') ?></th>
										<th class="text-center"><?php echo display('from_time') ?></th>
										<th class="text-center"><?php echo display('to_time') ?></th>
										<th class="text-center"><?php echo display('last_order_time') ?></th>
										<th class="text-center"><?php echo display('status') ?></th>
										<th class="text-center"><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
								if ($time_slots) {
									$i=$page+1;
									foreach ($time_slots as $time_slot) {
								?>
									<tr>
										<td class="text-center"><?php echo $i++; ?></td>
										<td class="text-center"><?php echo html_escape($time_slot['title'])?></td>
										<td class="text-center"><?php echo html_escape($time_slot['from_time'])?></td>
										<td class="text-center"><?php echo html_escape($time_slot['to_time'])?></td>
										<td class="text-center"><?php echo html_escape($time_slot['last_order_time'])?></td>
										<td class="text-center">
											<?php if ($time_slot['status'] == 1) { ?>
											<span class="label label-success"><?php echo display('active'); ?></span>
											<?php }elseif ($time_slot['status'] == 0){ ?> 
											<span class="label label-danger"><?php echo display('inactive'); ?></span>
											<?php } ?>
										</td>
										<td>
											<center>
												<?php if($this->permission->check_label('manage_time_slot')->update()->access()){ ?>
												<a href="<?php echo base_url().'dashboard/Cdelivery_system/edit_time_slot/'.$time_slot['id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>">
													<i class="fa fa-pencil" aria-hidden="true"></i>
												</a>
												<?php } ?>
												<?php if($this->permission->check_label('manage_time_slot')->delete()->access()){ ?>
												<a href="<?php echo base_url('dashboard/Cdelivery_system/time_slot_delete/'.$time_slot['id'])?>" class="delete_store_product btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo display('delete') ?> ">
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
		                <div class="text-right">
		                	<?php echo htmlspecialchars_decode($links); ?>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Manage store End -->