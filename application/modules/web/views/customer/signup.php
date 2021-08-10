<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="page-breadcrumbs">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url()?>"><?php echo display('home')?></a></li>
            <li class="active"><?php echo display('sign_up')?></li>
        </ol>
    </div>
</div>
<!--========== End Page Header Area ==========-->

<div class="lost-password">
    
    <?php 
        $message = $this->session->userdata('message');
        if (!empty($message)) {
        ?>
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $message ?>                    
        </div>
        <?php 
        $this->session->unset_userdata('message');
        }
        $error_message = $this->session->userdata('error_message');
        $validation_errors = validation_errors();
        if (!empty($error_message) || !empty($validation_errors)) {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $error_message ?>                    
            <?php echo $validation_errors ?>                    
        </div>
        <?php 
        $this->session->unset_userdata('error_message');
         } ?>


    <h4 class="mb-25 text-center"><?php echo display('create_your_account')?></h4>
        <?php echo form_open(base_url().'user_signup') ?>
        <div class="form-group">
            <label class="control-label" for="first_name"><?php echo display
                ('first_name')?><abbr class="required" title="required">*</abbr></label>
            <input type="text" id="first_name" class="form-control" name="first_name" placeholder="<?php echo display
            ('first_name')?>" required>
        </div>
        <div class="form-group">
            <label class="control-label" for="last_name"><?php echo display('last_name')?><abbr class="required" title="required">*</abbr></label>
            <input type="text" id="last_name" placeholder="<?php echo display('last_name')?>" class="form-control"
                   name="last_name" required>
        </div>
        <div class="form-group">
            <label class="control-label" for="user_email"><?php echo display('email')?><abbr class="required" title="required">*</abbr></label>
            <input type="email" id="user_email" class="form-control"name="email" placeholder="<?php echo display('email')?>" required>
            <p id="email_warning"></p>
        </div>
        <div class="form-group">
            <label class="control-label" for="mobile"><?php echo display('mobile')?><abbr class="required" title="required">*</abbr></label>
            <input type="text" id="mobile" class="form-control" name="phone" placeholder="<?php echo display('mobile')
            ?>" required>
        </div>

        <div class="form-group">
            <label class="control-label" for="user_pw"><?php echo display('password')?> <abbr class="required" title="required">*</abbr></label>
            <input type="password" id="user_pw" class="form-control" name="password" placeholder="<?php echo display('password')?>" required>
        </div>
        <div class="form-group">
            <button type="submit" class="base_button btn btn-warning color4 color46" id="create_account_btn"><?php echo display('create_account')?></button>
            <p class="d-inline-block pull-right mt-8 already_member"><?php echo display('already_member')?><a href="<?php echo base_url('login')?>">
                    <?php echo display('login')?></a></p>
        </div>
    <?php echo form_close(); ?>
</div>
<!--=========for show and hide login dropdown===========-->
<script src="<?php echo MOD_URL.'web/assets/js/signup.js'; ?>"></script>
