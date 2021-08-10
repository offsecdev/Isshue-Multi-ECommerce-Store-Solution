<!-- Manage store Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('edit_assigned_delivery') ?></h1>
	        <small><?php echo display('edit_assigned_delivery') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('edit_assigned_delivery') ?></a></li>
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
                <?php if ($this->permission->check_label('manage_assigned_delivery')->read()->access()) {?>
                    <a href="<?php echo base_url('dashboard/Cdelivery_system/manage_assigned_delivery')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_assigned_delivery')?></a>
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
		                    <h4><?php echo display('edit_assigned_delivery') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <?php echo form_open('dashboard/Cdelivery_system/edit_assigned_delivery/'.$assigned_delivery_info['delivery_id']); ?>
                        <div class="form-group row">
                            <label for="delivery_boy_id" class="col-sm-3 col-form-label"><?php echo display('delivery_boy')?><i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" required name="delivery_boy_id" id="delivery_boy_id">
                                    <option value=""><?php echo display('select_delivery_boy') ?></option>
                                <?php if($delivery_boys){ foreach ($delivery_boys as $delivery_boy) { ?>
                                    <option value="<?php echo $delivery_boy->id ?>" <?php echo ($delivery_boy->id == $assigned_delivery_info['delivery_boy_id'])?'selected': ''?>><?php echo $delivery_boy->name ;?></option> 
                                <?php } }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="delivery_zone_id" class="col-sm-3 col-form-label"><?php echo display('delivery_zone')?><i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" required name="delivery_zone_id" id="delivery_zone_id">
                                    <option value=""><?php echo display('select_delivery_zone') ?></option>
                                <?php if($delivery_zones){ foreach ($delivery_zones as $delivery_zone) { ?>
                                    <option value="<?php echo $delivery_zone->id ?>" <?php echo ($delivery_zone->id == $assigned_delivery_info['delivery_zone_id'])?'selected': ''?> ><?php echo $delivery_zone->delivery_zone ;?></option>  
                                <?php } }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="time_slot_id" class="col-sm-3 col-form-label"><?php echo display('time_slot')?><i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" required name="time_slot_id" id="time_slot_id">
                                    <option value=""><?php echo display('select_time_slot') ?></option>
                                <?php if($time_slots){ foreach ($time_slots as $time_slot) { ?>
                                    <option value="<?php echo $time_slot->id ?>" <?php echo ($time_slot->id == $assigned_delivery_info['time_slot_id'])?'selected': ''?>><?php echo $time_slot->title ;?></option>  
                                <?php } }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="order_no" class="col-sm-3 col-form-label"><?php echo display('orders')?><i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" required name="order_no[]" id="order_no" multiple>
                                    <option value=""><?php echo display('select_orders') ?></option>
                                <?php if($pending_orders){ foreach ($pending_orders as $pending_order) { ?>
                                    <option value="<?php echo $pending_order->order ?>" <?php echo (in_array($pending_order->order, $delivery_orders)?'selected':'') ?> ><?php echo $pending_order->order?></option> 
                                <?php } }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="completed_at" class="col-sm-3 col-form-label"><?php echo display('completed_at')?></label>
                            <div class="col-sm-6">
                                <input class="form-control" type="datetime-local" value="<?php echo $assigned_delivery_info['completed_at'] ?>" name="completed_at" id="completed_at">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="note" class="col-sm-3 col-form-label"><?php echo display('note')?></label>
                            <div class="col-sm-6">
                                <textarea class="form-control summernote" rows="3" name="note" id="note"><?php echo $assigned_delivery_info['note'] ?></textarea>
                            </div>
                        </div>
	                    <div class="form-group row">
	                    	<label for="radio_7" class="col-sm-3 col-form-label"><?php echo display('status') ?></label>
	                        <label class="radio-inline">
						        <input type="radio" class="col-sm-2 col-form-label" name="status" value="1" <?php echo (($assigned_delivery_info['status'] == '1')? 'checked' : '') ?> ><strong><?php echo display('active'); ?></strong>
						    </label>
						    <label class="radio-inline">
						        <input type="radio" class="col-sm-2 col-form-label" name="status" value="0" <?php echo (($assigned_delivery_info['status'] == '0')? 'checked' : '') ?> > <strong><?php echo display('inactive'); ?> </strong>
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



