<!-- Manage store Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('edit_delivery_time_slot') ?></h1>
	        <small><?php echo display('edit_delivery_time_slot') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('edit_delivery_time_slot') ?></a></li>
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
                	<?php if($this->permission->check_label('manage_time_slot')->read()->access()){ ?>
                  		<a href="<?php echo base_url('dashboard/Cdelivery_system/manage_time_slot')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_time_slot')?></a>
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
		                    <h4><?php echo display('edit_delivery_time_slot') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <?php echo form_open_multipart('dashboard/Cdelivery_system/edit_time_slot/'.$delivery_time_slot_info['id']); ?>
                        <div class="form-group row">
                            <label for="title" class="col-sm-3 col-form-label"><?php echo display('title')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                            	<input type="text" required name="title" value="<?php echo $delivery_time_slot_info['title'] ?>" id="title" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="from_time" class="col-sm-3 col-form-label"><?php echo display('from_time')?><i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="time" required name="from_time" value="<?php echo $delivery_time_slot_info['from_time'] ?>"  id="from_time" class="form-control"> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="to_time" class="col-sm-3 col-form-label"><?php echo display('to_time')?><i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="time" required name="to_time" value="<?php echo $delivery_time_slot_info['to_time'] ?>" id="to_time" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="last_order_time" class="col-sm-3 col-form-label"><?php echo display('last_order_time')?></label>
                            <div class="col-sm-6">
                                <input type="time" name="last_order_time" value="<?php echo $delivery_time_slot_info['last_order_time'] ?>" id="last_order_time" class="form-control">
                            </div>
                        </div>

	                    <div class="form-group row">
	                    	<label for="radio_7" class="col-sm-3 col-form-label"><?php echo display('status') ?></label>
	                    	
	                        <label class="radio-inline">
						        <input type="radio" class="col-sm-2 col-form-label" name="status" value="1" <?php echo (($delivery_time_slot_info['status'] == '1')? 'checked' : '') ?> ><strong><?php echo display('active'); ?></strong>
						    </label>
						    <label class="radio-inline">
						        <input type="radio" class="col-sm-2 col-form-label" name="status" value="0" <?php echo (($delivery_time_slot_info['status'] == '0')? 'checked' : '') ?> > <strong><?php echo display('inactive'); ?> </strong>
						    </label>
	                    </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="update-item" class="btn btn-success btn-large" name="update-item" value="<?php echo display('update') ?>" />
                            </div>
                        </div>
		                <?php echo form_close(); ?>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Manage store End -->



