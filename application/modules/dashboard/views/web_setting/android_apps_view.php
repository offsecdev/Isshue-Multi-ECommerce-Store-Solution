<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Add new customer start -->
<div class="content-wrapper color3">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('android_apps') ?></h1>
            <small><?php echo display('update_your_android_apps_link') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li class="active"><?php echo display('android_apps') ?></li>
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
                            <h4><?php echo display('android_apps') ?> </h4>
                        </div>
                    </div>
                  <?php echo form_open_multipart('dashboard/Cweb_setting/update_android_apps_update', array('class' => 'form-vertical','id' => 'validate'))?>
                    <div class="panel-body">
                        <div class="form-group row">
                            <label for="color1" class="col-sm-3 col-form-label"><?php echo display('put_your_apps_link') ?> </label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="apps_url" value="{apps_url}" id="apps_url" type="text">
                                 <small><?php echo display('apps_url')?></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="android_apps_url" class="btn btn-success btn-large" name="add-customer" value="<?php echo display('save_changes') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('our_demo') ?> </h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <p class="mob_app_txt">
                            <i class="fa fa-android" aria-hidden="true"></i> Download ISSHUE android apps from play store to check our apps demo. click
                            <a class="btn btn-success color4" href="https://play.google.com/store/apps/details?id=com.bdtask.isshues&site=<?php echo base_url() ?>&valid=Isshue" target="_blank">here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add new customer end -->



