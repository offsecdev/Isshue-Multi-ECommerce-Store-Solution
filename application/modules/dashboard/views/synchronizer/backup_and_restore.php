<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Backup and restore start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('Backup_restore') ?></h1>
            <small><?php echo display('Backup_restore') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li class="active"><?php echo display('Backup_restore') ?></li>
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
                    
                <?php if($this->permission->check_label('backup_and_restore')->update()->access()){
                    $localhost=false;
                    if (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1', 'localhost'))) {
                ?>
                  <a href="<?php echo base_url('dashboard/data_synchronizer/form')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('setting')?></a>
                <?php }  } ?>
                <?php if($this->permission->check_label('backup_and_restore')->read()->access()){ ?>
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
                            <h4><?php echo display('Backup_restore') ?></h4>
                        </div>
                    </div>
                    <div class="panel-body">

                        <div id="message" class="alert hide"></div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><?php echo display('database_backup') ?></label>
                            <div class="col-sm-9">  
                                <?php echo (($backup)? "<i class='fa fa-check text-success'></i> ".display('available') : "<i class='fa fa-times text-danger'></i> ".display('not_available')) ?>
                            </div> 
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><?php echo display('file_information') ?></label>
                            <div class="col-sm-9"> 
                                <?php if ($file) { ?>
                                    <ul class="list-unstyled">
                                        <li>
                                            <?php echo display('filename') ?>
                                            <strong><?php echo html_escape($file['name']) ?></strong>
                                        </li>
                                        <li>
                                            <?php echo display('size') ?>
                                            <strong><?php echo html_escape($file['size']) ?></strong>
                                        </li>
                                        <li>
                                            <?php echo display('backup_date') ?>
                                            <strong><?php echo html_escape($file['date']) ?></strong>
                                        </li>
                                    </ul>
                                <?php } else { ?>
                                    <i class='fa fa-times text-danger'></i> <?php echo display('not_available') ?>
                                <?php } ?>
                            </div> 
                        </div>
         

                        <div class="form-group row">
                            <div class="col-sm-4">  
                            <?php echo form_open('dashboard/Backup_restore/process', "id='brFrm'") ?>
                                <?php if (!$backup) { ?>
                                    <input type="hidden" name="input" value="1">
                                    <button type="submit" id="download" class="btn btn-primary w-md m-b-5 btn-block"><i class="fa fa-download"></i> <?php echo display('backup_now') ?> </button>
                                <?php  } else { ?>
                                    <input type="hidden" name="input" value="2">
                                    <button name="restore" type="submit" id="import" class="btn -btn-info color4 color5 w-md m-b-5 btn-block"><i class="fa fa-database"></i> <?php echo display('restore_now') ?></button>

                                    <a href="<?php echo base_url('dashboard/Backup_restore/download') ?>" class="btn btn-success w-md m-b-5 btn-block" onclick="return confirm('<?php echo display("are_you_sure") ?>')"><i class="fa fa-download"></i> <?php echo display('download') ?></a>

                                <?php } ?> 
                                <a href="<?php echo base_url('dashboard/Backup_restore/delete') ?>" class="btn btn-danger w-md m-b-5 btn-block" onclick="return confirm('<?php echo display("are_you_sure") ?>')"><i class="fa fa-trash"></i> <?php echo display('delete') ?></a>
                            <?php echo form_close() ?> 
                            </div>  
                        </div>  

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Backup and restore end -->
<script src="<?php echo MOD_URL.'dashboard/assets/js/backup_and_restore.js'; ?>"></script>
