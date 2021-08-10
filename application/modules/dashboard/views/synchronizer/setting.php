<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Backup and restore start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('Backup_restore') ?></h1>
            <small><?php echo display('ftp_setting') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li class="active"><?php echo display('ftp_setting') ?></li>
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
            $validation_errors = validation_errors();
            if (isset($error_message) || !empty($validation_errors)) {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $error_message ?>                    
            <?php echo $validation_errors; ?>                    
        </div>
        <?php 
            $this->session->unset_userdata('error_message');
            }
        ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="column">
                    <?php if($this->permission->check_label('backup_and_restore')->read()->access()){ ?>
                     <a href="<?php echo base_url('dashboard/backup_restore/index')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('Backup_restore')?></a>
                    <?php } ?>
                <?php if($this->permission->check_label('backup_and_restore')->update()->access()){
                    $localhost=false;
                    if (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1', 'localhost'))) {
                ?>
                  <a href="<?php echo base_url('dashboard/data_synchronizer/form')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('setting')?></a>
                <?php } }if($this->permission->check_label('backup_and_restore')->read()->access()){ ?>
                  <a href="<?php echo base_url('dashboard/data_synchronizer/synchronize')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('synchronize')?></a>
                <?php } ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo (!empty($title)?$title:null) ?></h4>
                        </div>
                    </div>
                    <div class="panel-body">

                        <?php echo form_open("dashboard/data_synchronizer/form") ?>

                            <div class="form-group row">
                                <label for="hostname" class="col-sm-3 col-form-label"><?php echo display('hostname') ?> *</label>
                                <div class="col-sm-9">
                                    <input name="hostname" class="form-control" type="text" placeholder="www.example.com / 192.168.1.1" id="hostname" value="<?php echo (!empty($ftp->hostname)?$ftp->hostname:null) ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="username" class="col-sm-3 col-form-label"><?php echo display('username') ?> *</label>
                                <div class="col-sm-9">
                                    <input name="username" class="form-control" type="text" placeholder="<?php echo display('username') ?>" id="username"  value="<?php echo (!empty($ftp->username)?$ftp->username:null) ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-sm-3 col-form-label"><?php echo display('password') ?> *</label>
                                <div class="col-sm-9">
                                    <input name="password" class="form-control" type="password" placeholder="<?php echo display('password') ?>" id="password"  value="<?php echo (!empty($ftp->password)?$ftp->password:null) ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="port" class="col-sm-3 col-form-label"><?php echo display('ftp_port') ?> *</label>
                                <div class="col-sm-9">
                                    <input name="port" class="form-control" type="text" placeholder="Default Port 21" id="port" value="<?php echo (!empty($ftp->port)?$ftp->port:21) ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="debug" class="col-sm-3 col-form-label"><?php echo display('ftp_debug') ?> *</label>
                                <div class="col-sm-9">
                                    <?php echo form_dropdown('debug', array('false'=>'FALSE', 'true'=>'TRUE'), (!empty($ftp->debug)?$ftp->debug:null), 'class="form-control" id="debug"' ) ?> 
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="project_root" class="col-sm-3 col-form-label"><?php echo display('project_root') ?> *</label>
                                <div class="col-sm-9">
                                    <input name="project_root" class="form-control" type="text" placeholder="./public_html/your_project_name/" id="project_root" value="<?php echo (!empty($ftp->project_root)?$ftp->project_root:null) ?>">
                                </div>
                            </div>
                 
                            <div class="form-group text-right">
                                <button type="reset" class="btn btn-primary w-md m-b-5"><?php echo display('reset') ?></button>
                                <button type="submit" class="btn btn-success w-md m-b-5"><?php echo display('save') ?></button>
                            </div>
                        <?php echo form_close() ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

 