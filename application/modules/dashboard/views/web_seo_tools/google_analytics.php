<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Update web setting start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('seo_tools') ?></h1>
            <small><?php echo display('google_analytics') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('web_settings') ?></a></li>
                <li class="active"><?php echo display('google_analytics') ?></li>
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

        <!--Update web setting -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4><?php echo display('google_analytics') ?> </h4>
                            </div>
                        </div>
                        <?php echo form_open('dashboard/seo_tools/google_analytics') ?>
                        <div class="panel-body">
                            <div class="form-group row">
                                <label for="google_analytics" class="col-sm-3 col-form-label"><?php echo display('google_analytics')?></label>
                                <div class="col-sm-6">
                                    <textarea name="google_analytics" id="google_analytics" class="form-control" rows="5"><?php echo $meta_setting[0]['google_analytics']; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-6">
                                    <button type="submit"  class="btn btn-success btn-large" ><?php echo display('save_changes') ?></button>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
    </section>
</div>
<!-- Update web setting end -->



