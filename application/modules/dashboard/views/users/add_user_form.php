<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<link rel="stylesheet" type="text/css" href="<?php echo MOD_URL.'dashboard/assets/css/dashboard.css'; ?>">
<!-- Add User start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_user') ?></h1>
            <small><?php echo display('add_new_user_information') ?></small>
            <ol class="breadcrumb">
                <li><a href="index.html"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('web_settings') ?></a></li>
                <li class="active"><?php echo display('add_user') ?></li>
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
            $validatio_error = validation_errors();
            if (isset($error_message) || $validatio_error) {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $error_message ?>  
            <?php echo $validatio_error ?>                  
        </div>
        <?php 
            $this->session->unset_userdata('error_message');
            }
        ?>

        <div class="row">
            <div class="col-sm-12">
                <div class="column">
                    <?php if($this->permission->check_label('manage_users')->read()->access()){ ?>
                        <a href="<?php echo base_url('dashboard/User/manage_user')?>" class="btn btn-success m-b-5 m-r-2">
                            <i class="ti-align-justify"> </i> <?php echo display('manage_users')?>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- Edit user -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_user') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('dashboard/User/insert_user',array('class' => 'form-vertical','id' => 'validate'))?>
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="first_name" class="col-sm-3 col-form-label"><?php echo display('first_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" tabindex="2" class="form-control" name="first_name" id="first_name" placeholder="<?php echo display('first_name') ?>" required />
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="last_name" class="col-sm-3 col-form-label"><?php echo display('last_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" tabindex="3" class="form-control" name="last_name" id="last_name" placeholder="<?php echo display('last_name') ?>" required />
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label"><?php echo display('email') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                               <input type="email" tabindex="4" class="form-control" name="email" id="email" placeholder="<?php echo display('email') ?>"  required />
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label"><?php echo display('password') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="password" tabindex="5" class="form-control" id="password" name="password" placeholder="<?php echo display('password') ?>" required />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_type" class="col-sm-3 col-form-label"><?php echo display('user_type') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" tabindex="6" name="user_type" id="user_type" required>
                                    <option value="0"><?php echo display('select_one') ?></option>
                                    <option value="1"><?php echo display('admin') ?></option>
                                    <option value="2"><?php echo display('role_user') ?></option>
                                    <option value="4"><?php echo display('store_keeper') ?></option>
                                  </select>
                            </div>
                        </div>

                        <div class="form-group row" id="payment_from_1" >
                            <label for="store" class="col-sm-3 col-form-label"><?php echo display('store') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control width_100p" name="store_id" id="store_id" required="">
								    <option value=""></option>
                                    {store_list}
								    <option value="{store_id}">{store_name}</option>
                                    {/store_list}
								  </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-customer" class="btn btn-primary btn-large" name="add-user" value="<?php echo display('save') ?>" tabindex="7" />
								<input type="submit" value="<?php echo display('save_and_add_another') ?>" name="add-user-another" class="btn btn-success" id="add-customer-another">
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Edit user end -->
<script src="<?php echo MOD_URL.'dashboard/assets/js/add_user_form.js'; ?>"></script>