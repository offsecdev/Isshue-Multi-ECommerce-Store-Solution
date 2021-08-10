<!-- Manage store Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('edit_delivery_boy') ?></h1>
	        <small><?php echo display('edit_delivery_boy') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('edit_delivery_boy') ?></a></li>
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
                <?php if($this->permission->check_label('manage_delivery_boy')->read()->access()){ ?>
                    <a href="<?php echo base_url('dashboard/Cdelivery_system/index')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_delivery_boy')?></a>
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
		                    <h4><?php echo display('edit_delivery_boy') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <?php echo form_open_multipart('dashboard/Cdelivery_system/edit_delivery_boy/'.$delivery_boy_info['id']); ?>

                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"><?php echo display('name')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                            	<input type="text" name="name" required value="<?php echo $delivery_boy_info['name'] ?>" id="name" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mobile" class="col-sm-3 col-form-label"><?php echo display('mobile')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                            	<input type="text" name="mobile" required value="<?php echo $delivery_boy_info['mobile'] ?>" id="mobile" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-sm-3 col-form-label"><?php echo display('address')?></label>
                            <div class="col-sm-6">
                            	<textarea name="address" rows="1" id="address" class="form-control"><?php echo $delivery_boy_info['address'] ?></textarea> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="driving_license" class="col-sm-3 col-form-label"><?php echo display('driving_license')?></label>
                            <div class="col-sm-6">
                            	<input type="file" name="driving_license" id="driving_license" class="form-control">
                            	<img class="img img-responsive text-center p_5" src="<?php echo base_url().$delivery_boy_info['driving_license']?>" height="80" width="80">
                            	<input type="hidden" value="<?php echo $delivery_boy_info['driving_license'] ?>" name="old_driving_license">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="national_id" class="col-sm-3 col-form-label"><?php echo display('national_id_card')?> 
                            <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                            	<input type="file" name="national_id" id="national_id" class="form-control">
                            	<img class="img img-responsive text-center p_5" src="<?php echo base_url().$delivery_boy_info['national_id']?>" height="80" width="80">
                            	<input type="hidden" value="<?php echo $delivery_boy_info['national_id'] ?>" name="old_national_id">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="birth_date" class="col-sm-3 col-form-label"><?php echo display('date_of_birth')?></label>
                            <div class="col-sm-6">
                            	<input type="date" name="birth_date" value="<?php echo $delivery_boy_info['birth_date'] ?>" id="birth_date" class="form-control datepicker">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bank_name" class="col-sm-3 col-form-label"><?php echo display('bank_name')?></label>
                            <div class="col-sm-6">
                            	<input type="text" name="bank_name" value="<?php echo $delivery_boy_info['bank_name'] ?>"  id="bank_name" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="account_no" class="col-sm-3 col-form-label"><?php echo display('account_no')?></label>
                            <div class="col-sm-6">
                            	<input type="text" name="account_no" value="<?php echo $delivery_boy_info['account_no'] ?>" id="account_no" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="account_name" class="col-sm-3 col-form-label"><?php echo display('bank_account_name')?></label>
                            <div class="col-sm-6">
                            	<input type="text" name="account_name" value="<?php echo $delivery_boy_info['account_name'] ?>" id="account_name" class="form-control">
                            </div>
                        </div>
                        
	                    <div class="form-group row">
	                    	<label for="radio_7" class="col-sm-3 col-form-label"><?php echo display('status') ?></label>
	                    	
	                        <label class="radio-inline">
						        <input type="radio" class="col-sm-2 col-form-label" name="status" value="1" <?php echo (($delivery_boy_info['status'] == '1')? 'checked' : '') ?> ><strong><?php echo display('active'); ?></strong>
						    </label>
						    <label class="radio-inline">
						        <input type="radio" class="col-sm-2 col-form-label" name="status" value="0" <?php echo (($delivery_boy_info['status'] == '0')? 'checked' : '') ?> > <strong><?php echo display('inactive'); ?> </strong>
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



