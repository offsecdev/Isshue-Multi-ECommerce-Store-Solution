<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Change Password Page Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon"><i class="pe-7s-user-female"></i></div>
        <div class="header-title">
            <h1><?php echo display('change_your_information') ?></h1>
            <small><?php echo display('change_your_profile') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i><?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('profile') ?></a></li>
                <li class="active"><?php echo display('change_your_information') ?></li>
            </ol>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-sm-12 col-md-4">
            </div>
            <div class="col-sm-12 col-md-4 ">
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

                <!-- Login widget --> 
                <div class="login-widget">
                    <div class="panel panel-bd">
                        <div class="panel-heading">
                            <h4><?php echo display('change_your_information') ?></h4>
                        </div>
                         <?php echo form_open_multipart('customer/customer_dashboard/change_password',array('id' => 'validate','class' => 'form-horizontal'))?>
                            <div class="panel-body">
                                <h4 class="text-center"><?php echo display('old_information') ?></h4>
                                <label for="login-email"><?php echo display('email') ?></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                    <input type="email" placeholder="<?php echo display('email') ?>" class="form-control" id="email" name="email" value="" required />  
                                </div>
                                <label for="login-email"><?php echo display('old_password') ?></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input type="password" placeholder="<?php echo display('old_password') ?>" class="form-control" id="old_password" name="old_password" value="" required />
                                </div>
                                <h4 class="text-center"><?php echo display('new_information') ?></h4>
                                <label for="login-email"><?php echo display('new_password') ?></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input type="password" placeholder="<?php echo display('new_password') ?>" class="form-control" id="password" name="password" value="" required />
                                </div>
                                <label for="login-email"><?php echo display('re_type_password') ?></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input type="password" placeholder="<?php echo display('re_type_password') ?>" class="form-control" id="repassword" name="repassword" value="" required />
                                </div>
                            </div>
                            <div class="panel-footer text-center">
                                <div class="login-btn">
                                    <button type="submit" class="btn btn-success btn-block m-b-10"><i class="fa fa-play-circle"></i> <?php echo display('change_password') ?></button>
                                </div>             
                            </div>
                        <?php echo form_close()?>
                    </div>
                </div>
            </div>
        </div> 
    </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->
<!-- Change Password Page End -->