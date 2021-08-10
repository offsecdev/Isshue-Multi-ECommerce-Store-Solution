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
                <?php if($this->permission->check_label('manage_states')->read()->access()){ ?>
                  <a href="<?php echo base_url('dashboard/cstate')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('states')?></a>
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
		                    <h4><?php echo display('states') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <?php echo form_open('dashboard/cstate/state_add'); ?>

		                <div class="form-group row">
                            <label for="country" class="col-sm-3 col-form-label"><?php echo display('country')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                            	<select name="country" id="country" class="form-control">
                            	<?php if($countries){
                            		foreach ($countries as $country) {  ?>
                            		<option value="<?php echo $country['id']; ?>"><?php echo $country['name']; ?></option>
                            	<?php } } ?>
                            	</select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="state" class="col-sm-3 col-form-label"><?php echo display('state')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                            	<input type="text" name="state" id="state" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
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



