<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!--========== Alert Message ==========-->
<div class="login_page">
    <div class="container">
        <div class="row db m0 login_area">
            <?php
            $message = $this->session->userdata('message');
            if ($message) {
                ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
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
            if ($error_message) {
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
    </div>
</div>
<!--========== Alert Message ==========-->

<!--========== Login Area ==========-->
<div class="login_page">
    <div class="container">
        <div class="row db m0 login_area">
            <div class="img_part">
                <img src="<?php echo base_url() ?>assets/website/image/login.png" alt="Avatar" class="Login Image">
            </div>
           <?php echo form_open(base_url() . 'do_login', ['class' => 'login_content']) ?>
                <div class="user_info">
                    <label><b><?php echo display('email') ?></b></label>
                    <input type="email" placeholder="<?php echo display('email') ?>" name="email" required>
                    <br>
                    <label><b><?php echo display('password') ?></b></label>
                    <input type="password" placeholder="<?php echo display('password') ?>" name="password" required>
                    <br>
                    <input type="checkbox" checked="checked"><span>Remember me</span>
                    <button type="submit" class="base_button"><?php echo display('login') ?></button>
                </div>
                <div class="other_link">
                    <div class="create_account"><a href="<?php echo base_url('signup') ?>" class="base_button"><?php echo display('create_account') ?></a></div>
                </div>
            <?php echo form_close(); ?>

        </div>
    </div>
</div>
<!--========== End Login Area ==========-->

<div class="login_page">
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <div class="row">
                    <div class="col-md-6 form-group">
                         <?php if(check_module_status('googlelogin') == 1){ 
                        ?>
                            <a class="btn btn-google btn-sm btn-block  search text-white" href="<?php echo base_url('googlelogin/googlelogin/login')?>"><i class="fa fa-google mr-1"></i> <?php echo display('google_login')?></a>
                        <?php }?>
                    </div>
                    <div class="col-md-6 form-group">
                        <?php if((check_module_status('facebooklogin') == 1)){
                        ?>
                            <a class="btn btn-facebook btn-sm btn-block  search text-white" href="<?php echo base_url('facebooklogin/facebooklogin/index/1')?>"><i class="fa fa-facebook mr-1"></i> <?php echo display('facebook_login')?></a>
                        <?php }?> 
                    </div>
                    <div class="col-md-6 form-group">
                        <?php if((check_module_status('linkedinlogin') == 1)){ ?>
                            <a class="btn btn-linkedin btn-sm btn-block  search text-white" href="<?php echo base_url('linkedinlogin/linkedinlogin/login/1')?>"><i class="fa fa-linkedin mr-1"></i> <?php echo display('linkedin_login')?></a>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--=========== Newsletter Area ===========-->
<section class="newsletter_area">
    <div class="container">
        <div class="row m0 newsletter_inner bg_gray">
            <div class="col-lg-6 col-xl-5">
                <div class="row m0 newsletter_left_area">
                    <h4><?php echo display('sign_up_for_news_and') ?> <span><?php echo display('offers') ?></span></h4>
                    <h6><?php echo display('you_may_unsubscribe_at_any_time') ?></h6>
                </div>
            </div>
            <div class="col-lg-6 col-xl-7">
                <div id="sub_msg"></div>
                <?php echo form_open('', array('class' => 'row m0 newsletter_form'))?>
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="<?php echo display('enter_your_email') ?>"
                               required="" id="sub_email">
                        <span class="input-group-btn">
                            <button class="btn btn-default subscribe" type="button" id="smt_btn"><i
                                        class="fa fa-search"></i></button>
                        </span>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>
<!--========= End Newsletter Area =========-->
