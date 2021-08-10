<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!--========== Alert Message ==========-->
<div class="container">

    <!--========== Alert Message ==========-->
    <div class="row">
        <div class="col-md-12">
            <div class="lost-password">
                <h4 class="mb-25"><?php echo display('welcome_back_to_login') ?></h4>
                <div>
                    <?php
                   
                    $message = $this->session->userdata('message');
                    if (!empty($message)) {
                        ?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <?php echo $message ?>
                        </div>
                        <?php
                        $this->session->unset_userdata('message');
                    }
                    ?>
                    <?php
                    $error_message = $this->session->userdata('error_message');
                    if (!empty($error_message)) {
                        ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <?php echo $error_message ?>
                        </div>
                        <?php
                        $this->session->unset_userdata('error_message');
                    }
                    ?>
                </div>

                <?php echo form_open(base_url() . 'do_login'); ?>
                <div class="form-group">
                    <label class="control-label" for="user_login_email"><?php echo display('email') ?><abbr class="required"
                                                                                                            title="required">*</abbr></label>
                    <input type="text" id="user_login_email" class="form-control" placeholder="<?php echo display('email') ?>"
                           name="email" required>
                </div>
                <div class="form-group">
                    <label class="control-label" for="user_login_password"><?php echo display('password') ?><abbr class="required"
                                                                                                                  title="required">*</abbr></label>
                    <input type="password" id="user_login_password" class="form-control"
                           placeholder="<?php echo display('password') ?>" name="password" required>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="checkbox_area"><?php echo display('remember_me') ?>
                            <input type="checkbox">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <a href="<?php echo base_url('forget_password_form') ?>"
                           class="pull-right"><?php echo display('i_have_forgot_my_password') ?></a>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-warning"><?php echo display('login') ?></button>
                    <p class="d-inline-block pull-right mt-8"><a
                                href="<?php echo base_url('signup') ?>"> <?php echo display('create_account') ?></a></p>
                </div>
                <?php echo form_close(); ?>

                <div class="row">
                    <br><br>
                    <div class="col-md-6 form-group">

                         <?php if(check_module_status('googlelogin') == 1){ 
                        ?>
                            <a class="btn btn-google btn-sm btn-block  search text-white" href="<?php echo base_url('googlelogin/googlelogin/login')?>"><i class="fa fa-google mr-5"></i> <?php echo display('google_login')?></a>
                        <?php }?>
                    </div>
                    <div class="col-md-6 form-group">
                        <?php if((check_module_status('facebooklogin') == 1)){
                        ?>
                            <a class="btn btn-facebook btn-sm btn-block  search text-white" href="<?php echo base_url('facebooklogin/facebooklogin/index/1')?>"><i class="fa fa-facebook mr-5"></i> <?php echo display('facebook_login')?></a>
                        <?php }?> 
                    </div>
                    <div class="col-md-6 form-group">
                        <?php if((check_module_status('linkedinlogin') == 1)){ ?>
                            <a class="btn btn-linkedin btn-sm btn-block  search text-white" href="<?php echo base_url('linkedinlogin/linkedinlogin/login/1')?>"><i class="fa fa-linkedin mr-5"></i> <?php echo display('linkedin_login')?></a>
                        <?php }?>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>