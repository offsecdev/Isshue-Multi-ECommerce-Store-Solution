<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Update contact form start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('update_contact_form') ?></h1>
            <small><?php echo display('update_your_contact_form') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('web_settings') ?></a></li>
                <li class="active"><?php echo display('update_contact_form') ?></li>
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

        <!-- Update contact form -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('update_contact_form') ?> </h4>
                        </div>
                    </div>
                  <?php echo form_open_multipart('dashboard/Cweb_setting/update_contact_form/{id}', array('class' => 'form-vertical','id' => 'validate'))?>
                    <div class="panel-body">
                        
                        <div class="form-group row">
                            <label for="first_name" class="col-sm-3 col-form-label"><?php echo display('first_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="first_name" id="first_name" type="text" placeholder="<?php echo display('first_name') ?>" required value="{first_name}">
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="last_name" class="col-sm-3 col-form-label"><?php echo display('last_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="last_name" id="last_name" type="text" placeholder="<?php echo display('last_name') ?>" required value="{last_name}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label"><?php echo display('email') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="email" id="email" type="email" placeholder="<?php echo display('email') ?>" required value="{email}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="message" class="col-sm-3 col-form-label"><?php echo display('message') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="message" id="message " rows="3" placeholder="<?php echo display('message') ?>" required>{message}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-customer" class="btn btn-success btn-large" name="add-customer" value="<?php echo display('save_changes') ?>"/>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Update contact form end -->



