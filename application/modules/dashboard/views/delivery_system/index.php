<!-- Manage store Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_delivery_boy') ?></h1>
	        <small><?php echo display('manage_delivery_boy') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('manage_delivery_boy') ?></a></li>
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
                	<?php if($this->permission->check_label('add_delivery_boy')->create()->access()){ ?>
                  	<a href="<?php echo base_url('dashboard/Cdelivery_system/add_delivery_boy')?>" class="btn -btn-info color4 color5 m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_delivery_boy'); ?></a>
                  	<?php }?>
                </div>
            </div>
        </div>
		<!-- Manage store -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_delivery_boy') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample3" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-center"><?php echo display('sl') ?></th>
										<th class="text-center"><?php echo display('name') ?></th>
										<th class="text-center"><?php echo display('mobile') ?></th>
										<th class="text-center"><?php echo display('address') ?></th>
										<th class="text-center"><?php echo display('status') ?></th>
										<th class="text-center"><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
								if ($delivery_boys) {
									$i=$page+1;
									foreach ($delivery_boys as $delivery_boy) {
								?>
									<tr>
										<td class="text-center"><?php echo $i++; ?></td>
										<td class="text-center"><?php echo html_escape($delivery_boy['name'])?></td>
										<td class="text-center"><?php echo html_escape($delivery_boy['mobile'])?></td>
										<td class="text-center"><?php echo html_escape($delivery_boy['address'])?></td>
										<td class="text-center">
											<?php if ($delivery_boy['status'] == 1) { ?>
											<span class="label label-success"><?php echo display('active'); ?></span>
											<?php }elseif ($delivery_boy['status'] == 0){ ?> 
											<span class="label label-danger"><?php echo display('inactive'); ?></span>
											<?php } ?>
										</td>
										<td>
											<center>
												<?php if($this->permission->check_label('manage_delivery_boy')->update()->access()){ ?>
												<a href="<?php echo base_url().'dashboard/Cdelivery_system/edit_delivery_boy/'.$delivery_boy['id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>">
													<i class="fa fa-pencil" aria-hidden="true"></i>
												</a>
												<?php }if($this->permission->check_label('manage_delivery_boy')->delete()->access()){ ?>
												<a href="<?php echo base_url('dashboard/Cdelivery_system/delivery_boy_delete/'.$delivery_boy['id'])?>" class="delete_store_product btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo display('delete') ?> ">
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
		                	<?php echo htmlspecialchars_decode($paginlink); ?>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Manage store End -->



