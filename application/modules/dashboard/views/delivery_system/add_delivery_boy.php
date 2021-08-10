<!-- Manage store Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('add_delivery_boy') ?></h1>
	        <small><?php echo display('add_delivery_boy') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('add_delivery_boy') ?></a></li>
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
                    <a href="<?php echo base_url('dashboard/Cdelivery_system')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_delivery_boy')?></a>
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
		                    <h4><?php echo display('add_delivery_boy') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <?php echo form_open_multipart('dashboard/Cdelivery_system/add_delivery_boy'); ?>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"><?php echo display('name')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                            	<input type="text" name="name" id="state" required class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mobile" class="col-sm-3 col-form-label"><?php echo display('mobile')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                            	<input type="text" name="mobile" id="mobile" required class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-sm-3 col-form-label"><?php echo display('address')?></label>
                            <div class="col-sm-6">
                            	<textarea name="address" rows="1" id="address" class="form-control"></textarea> 
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="driving_license" class="col-sm-3 col-form-label"><?php echo display('driving_license')?></label>
                            <div class="col-sm-6">
                            	<input type="file" name="driving_license" id="driving_license" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="national_id" class="col-sm-3 col-form-label"><?php echo display('national_id_card')?> 
                            <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                            	<input type="file" name="national_id" id="national_id" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="birth_date" class="col-sm-3 col-form-label"><?php echo display('date_of_birth')?></label>
                            <div class="col-sm-6">
                            	<input type="text" name="birth_date" id="birth_date" class="form-control datepicker">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bank_name" class="col-sm-3 col-form-label"><?php echo display('bank_name')?></label>
                            <div class="col-sm-6">
                            	<input type="text" name="bank_name" id="birth_date" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="account_no" class="col-sm-3 col-form-label"><?php echo display('account_no')?></label>
                            <div class="col-sm-6">
                            	<input type="text" name="account_no" id="account_no" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="account_name" class="col-sm-3 col-form-label"><?php echo display('bank_account_name')?></label>
                            <div class="col-sm-6">
                            	<input type="text" name="account_name" id="account_name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-item" class="btn btn-success btn-large" name="add-item" value="<?php echo display('save') ?>" />
                                <input type="submit" id="add-item-another" class="btn btn-primary btn-large" name="add-item-another" value="<?php echo display('save_and_add_another') ?>" />
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



