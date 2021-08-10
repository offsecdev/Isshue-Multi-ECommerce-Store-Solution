<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo (isset($title)) ? $title : "Isshue Multistore System" ?></title>
        <link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans:ital,wght@0,100;0,300;0,400;0,500;0,700;0,800;0,900;1,100;1,300;1,400;1,500;1,700;1,800;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?php echo base_url((!empty($setting->favicon)?$setting->favicon:'assets/img/icons/favicon.png')) ?>" type="image/x-icon">
        
        <!-- Start Global Mandatory Style -->
        <!-- Bootstrap -->
        <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css"/>
        <!-- Bootstrap rtl -->
        <?php if ($setting['rtr'] == 1) { ?>
        <link href="<?php echo base_url('assets/bootstrap-rtl/bootstrap-rtl.min.css') ?>" rel="stylesheet" type="text/css"/>
        <?php } ?>
        <!-- Pe-icon -->
        <link href="<?php echo base_url('assets/pe-icon-7-stroke/css/pe-icon-7-stroke.css') ?>" rel="stylesheet" type="text/css"/>
        
        <!-- Theme style -->
        <link href="<?php echo base_url('assets/css/custom.min.css') ?>" rel="stylesheet" type="text/css"/>
        <!-- Theme style rtl -->
        <?php if ($setting['rtr'] == 1) { ?>
        <link href="<?php echo base_url('assets/css/custom-rtl.min.css') ?>" rel="stylesheet" type="text/css"/>
        <?php } ?>
        <link href="<?php echo base_url('assets/dist/css/login.css') ?>" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <input type ="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">
        <input type ="hidden" name="CSRF_TOKEN" id="CSRF_TOKEN" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <input type ="hidden" name="language_id" id="language_id" value="<?php echo html_escape(@$language_id) ?>">
        <script src="<?php echo base_url() ?>assets/js/global_js.js" defer type="text/javascript"></script>


        <!-- Content Wrapper -->
        <div class="login-wrapper"> 
            <div class="container-center">
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
                } ?>
                <div class="panel panel-bd">
                    <div class="panel-heading">
                        <div class="view-header">
                            <div class="header-icon">
                                <i class="pe-7s-unlock"></i>
                            </div>
                            <div class="header-title">
                                <h3><?php echo display('login') ?></h3>
                                <small><strong><?php echo display('please_enter_your_login_information') ?></strong></small>
                            </div>
                        </div>
                        <div class="">
                            <!-- alert message -->
                            <?php if ($this->session->flashdata('message') != null) {  ?>
                            <div class="alert alert-info alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?php echo $this->session->flashdata('message'); ?>
                            </div> 
                            <?php } ?>
                            
                            <?php if ($this->session->flashdata('exception') != null) {  ?>
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?php echo $this->session->flashdata('exception'); ?>
                            </div>
                            <?php } ?>
                            
                            <?php if (validation_errors()) {  ?>
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?php echo validation_errors(); ?>
                            </div>
                            <?php } ?> 
                        </div>
                    </div>


                    <div class="panel-body">
                        <div>
                            <div class="recover_message" id="recover_message"></div>
                            <div id="loader" class="text-center"><img class="loader_img" src="<?php echo base_url('my-assets/image/loader.gif') ?>" alt="">
                            </div>
                        </div>
                        <div id="login_form">
                        <?php
                         echo form_open('admin','id="loginForm" novalidate'); ?>

                            <div class="form-group">
                                <label class="control-label" for="email"><?php echo display('email') ?></label>
                                <input type="text" placeholder="<?php echo display('email') ?>" name="email" id="email" class="form-control" value="<?php echo set_value('email'); ?>"> 
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password"><?php echo display('password') ?></label>
                                <input type="password"  placeholder="<?php echo display('password') ?>" name="password" id="password" class="form-control"  value="<?php echo set_value('password'); ?>"> 
                            </div>
                            <?php if($setting['captcha']){ ?>
                            <div class="form-group">
                                <label class="control-label" for="captcha"><?php echo $captcha_image ?></label>
                                <input type="captcha"  placeholder="<?php echo display('captcha') ?>" name="captcha" id="captcha" class="form-control"> 
                            </div>
                            <?php } ?>
                            <div> 
                                <button  type="reset" class="btn btn-info"><?php echo display('reset') ?></button> 
                                <button  type="submit" class="btn btn-success"><?php echo display('login') ?></button> 
                            </div>
                              </div>


                        <div>
                            <button class="btn btn-success" id="login_button"><?php echo display('login') ?></button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-wrapper -->



        <!-- jQuery -->
        <script src="<?php echo base_url('assets/js/jquery.min.js') ?>" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js') ?>" type="text/javascript"></script>

        <script src="<?php echo MOD_URL.'template/assets/js/admin_login_form.js'; ?>"></script>


    </body>
</html>