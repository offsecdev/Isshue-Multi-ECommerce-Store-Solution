<!-- Manage store Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_store') ?></h1>
	        <small><?php echo display('manage_your_store') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('store_set') ?></a></li>
	            <li class="active"><?php echo display('manage_store') ?></li>
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
                <?php if($this->permission->check_label('store_add')->create()->access()){ ?>
                  <a href="<?php echo base_url('dashboard/Cstore')?>" class="btn -btn-info color4 color5 m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_store')?></a>
                <?php } if($this->permission->check_label('store_transfer')->update()->access()){?>
                  <a href="<?php echo base_url('dashboard/Cstore/store_transfer')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('store_transfer')?></a>
                <?php }if($this->permission->check_label('manage_store_product')->update()->access()){?>
                  <a href="<?php echo base_url('dashboard/Cstore/manage_store_product')?>" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_store_product')?></a>
                <?php }?>
                  <button type="button" class="btn btn-danger m-b-5 m-r-2"><?php echo display('you_must_have_a_default_store')?></button>

                </div>
            </div>
        </div>

		<!-- Manage store -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_store') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-center"><?php echo display('sl') ?></th>
										<th class="text-center"><?php echo display('store_name') ?></th>
										<th class="text-center"><?php echo display('store_address') ?></th>
										<th class="width_30p"><?php echo display('default_store') ?></th>
										<th class="text-center"><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
								if ($store_list) {
									foreach ($store_list as $store) {
								?>
									<tr>
										<td class="text-center"><?php echo $store['sl']?></td>
										<td class="text-center"><?php echo html_escape($store['store_name'])?></td>
										<td class="text-center"><?php echo html_escape($store['store_address'])?></td>
										<td>
											<?php echo form_open('dashboard/Cstore/update_status/'.$store['store_id']); ?>

												<select class="form-control width_50p" id="default_status" name="default_status">
			                                       	<option value=""></option>
			                                        <option value="1" <?php if ($store['default_status'] == '1'){echo "selected";}?>>Yes</option>
			                                        <option value="0" <?php if ($store['default_status'] == '0'){echo "selected";}?>>No</option>
			                                    </select>

			                                    <input type="submit" class="btn btn-success inv_updatebtn" value="<?php echo display('update') ?>"/>
											<?php echo form_close(); ?>
										</td>
										<td>
											<center>
												<?php if($this->permission->check_label('manage_store')->update()->access()){?>
												<a href="<?php echo base_url().'dashboard/Cstore/store_update_form/'.$store['store_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
												<?php }if($this->permission->check_label('manage_store')->delete()->access()){ ?>
												<a href="<?php echo base_url('dashboard/Cstore/store_delete/'.$store['store_id'])?>" class="delete_store_product btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
<!-- Manage store End -->



