<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('software_update') ?></h1>
            <small><?php echo display('software_update') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('software_settings') ?></a></li>
                <li class="active"><?php echo display('software_update') ?></li>
            </ol>
        </div>
    </section>
    <section class="content">
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
    $error_message = $this->session->userdata('exception');
    if (isset($error_message)) {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $error_message ?>
        </div>
        <?php
        $this->session->unset_userdata('exception');
    }
    ?>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-body">

                    <?php if ($latest_version > $current_version) { ?>
                        <?php echo form_open_multipart("dashboard/autoupdate/update") ?>
                        <div class="row">
                            <div class="form-group col-lg-8 col-sm-offset-2">
                                <blink class="text-success text-center mst_txt"><?php echo @$message_txt ?></blink>
                                <blink class="text-danger text-center mst_txt" ><?php echo @$exception_txt ?></blink>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="alert alert-success text-center latest_version">Latest version
                                            <br>V-<?php echo html_escape($latest_version) ?></div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-danger text-center latest_version">Current version
                                            <br>V-<?php echo html_escape($current_version) ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group col-lg-6 col-sm-offset-3">
                                 <p class="alert update_recommendation" >
                                    Note: Please update your software verion <b>sequenctially</b> if you already missed any updated version!
                                </p>
                                <p class="alert update_recommendation" >
                                    Note: strongly recomanded to backup your <b>SOURCE FILE</b> and <b>DATABASE</b>
                                    before update. <a class="btn btn-success" href="<?php echo base_url('dashboard/backup_restore/download_backup') ?>">Download Database</a>
                                    <br>
                                    <br>
                                    Please Enable <b>Zip </b>, <b>allow_url_fopen = 1</b> status From your Server setting to get update properly.
                                </p>
                                <label>Licence/Purchase key <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="purchase_key">
                            </div>
                            <?php if(!empty($update_list)){
                                $vitems = json_decode($update_list);
                             ?>
                            <div class="form-group col-lg-6 col-sm-offset-3">
                                <label>Available Updates <span class="text-danger">*</span></label>
                                <select name="version" class="form-control">
                                    <option value="">Select</option>
                                    <?php
                                     foreach ($vitems as $vitem) { ?>
                                    <option value="<?php echo $vitem ?>">v<?php echo $vitem ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php } ?>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-success col-sm-offset-5"
                                    onclick="return confirm('are you sure want to update?')"><i class="fa fa-wrench" aria-hidden="true"></i>
                                Update
                            </button>
                        </div>
                        <?php echo form_close() ?>

                    <?php }elseif($latest_version < $current_version) { ?>
                        <div class="row">
                            <div class="form-group col-lg-4 col-sm-offset-4">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="alert alert-success text-center latest_version">Current version
                                            <br>V-<?php echo html_escape($current_version) ?></div>
                                        <h2 class="text-center">Already up to date</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="row">
                            <div class="form-group col-lg-4 col-sm-offset-4">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="alert alert-success text-center latest_version">Current version
                                            <br>V-<?php echo html_escape($current_version) ?></div>
                                        <h2 class="text-center">No Update available</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
    </section>
</div>
