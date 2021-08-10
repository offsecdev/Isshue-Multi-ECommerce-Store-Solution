<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Add new customer start -->
<div class="content-wrapper color3">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('update_dashboard_color') ?></h1>
            <small><?php echo display('update_your_software_setting') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('web_settings') ?></a></li>
                <li class="active"><?php echo display('update_setting') ?></li>
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

        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('update_color') ?> </h4>
                        </div>
                    </div>
                  <?php echo form_open_multipart('dashboard/Csoft_setting/update_backend_color', array('class' => 'form-vertical','id' => 'validate'))?>
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="color1" class="col-sm-3 col-form-label"><?php echo display('color1') ?> </label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="color1" value="{color1}" id="color1" type="color">
                                 <small><?php echo display('be_color1')?></small>
                            </div>
                        </div>

                          <div class="form-group row">
                            <label for="color2" class="col-sm-3 col-form-label"><?php echo display('color2') ?> </label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="color2" value="{color2}" id="color2" type="color">
                                <small><?php echo display('be_color2')?></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="color3" class="col-sm-3 col-form-label"><?php echo display('color3') ?> </label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="color3" value="{color3}" id="color3" type="color">
                                 <small><?php echo display('be_color3')?></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="color4" class="col-sm-3 col-form-label"><?php echo display('color4') ?> </label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="color4" value="{color4}" id="color4" type="color">
                                <small><?php echo display('be_color4')?></small>
                                <small></small>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="color5" class="col-sm-3 col-form-label"><?php echo display('color5') ?> </label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="color5" value="{color5}" id="color4" type="color">
                                <small><?php echo display('be_color5')?></small>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-customer" class="btn btn-success btn-large" name="add-customer" value="<?php echo display('save_changes') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add new customer end -->



