<!-- Manage store Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('states') ?></h1>
	        <small><?php echo display('states') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('states') ?></a></li>
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
                <?php if($this->permission->check_label('add_state')->create()->access()){ ?>
                  	<a href="<?php echo base_url('dashboard/cstate/state_add')?>" class="btn -btn-info color4 color5 m-b-5 m-r-2">
                  		<i class="ti-plus"> </i> <?php echo display('add')." ".display('state'); ?>
              		</a>
              	<?php } ?>

                </div>
            </div>
        </div>
        <div class="row">
        	<div class="panel panel-bd">
        		<div class="panel-body">
                <?php echo form_open('dashboard/cstate', array('method' => 'GET')); ?>
                <div class="col-sm-4">
	                <div class="form-group row">
                        <label for="country" class="col-sm-3 col-form-label"><?php echo display('country')?></label>
                        <div class="col-sm-9">
                        	<select name="country" id="country" class="form-control">
                        		<option value=""></option>
                        	<?php if($countries){
                        		foreach ($countries as $country) {  ?>
                        		<option value="<?php echo $country['id']; ?>" <?php echo (($country['id']==@$_GET['country'])?'selected':'') ?>><?php echo $country['name']; ?></option>
                        	<?php } } ?>
                        	</select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group row">
                        <label for="state" class="col-sm-3 col-form-label"><?php echo display('state')?></label>
                        <div class="col-sm-9">
                        	<input type="text" name="state" id="state" class="form-control" value="<?php echo set_value('state', @$_GET['state']) ?>">
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group row">
                        <button class="btn btn-success" type="submit"><?php echo display('submit') ?></button>
                    </div>
                </div>
                <?php echo form_close(); ?>    
        		</div>
        	</div>
        </div>

		<!-- Manage store -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('states') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample3" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-center"><?php echo display('sl') ?></th>
										<th class="text-center"><?php echo display('country') ?></th>
										<th class="text-center"><?php echo display('state') ?></th>
										<th class="text-center"><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
								if ($states) {
									$i=$page+1;
									foreach ($states as $state) {
								?>
									<tr>
										<td class="text-center"><?php echo $i++; ?></td>
										<td class="text-center"><?php echo html_escape($state['country_name'])?></td>
										<td class="text-center"><?php echo html_escape($state['name'])?></td>
										<td>
											<center>
												<?php if($this->permission->check_label('manage_states')->update()->access()){ ?>
												<a href="<?php echo base_url().'dashboard/cstate/state_edit/'.$state['id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
												<?php }if($this->permission->check_label('manage_states')->delete()->access()){ ?>
												<a href="<?php echo base_url('dashboard/cstate/state_delete/'.$state['id'])?>" class="delete_store_product btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo display('delete') ?> ">
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



