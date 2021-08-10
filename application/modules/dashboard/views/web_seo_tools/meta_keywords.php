<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Update web setting start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('seo_tools') ?></h1>
            <small><?php echo display('website_meta_keywords') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('web_settings') ?></a></li>
                <li class="active"><?php echo display('website_meta_keywords') ?></li>
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
                                <h4><?php echo display('website_meta_keywords') ?> </h4>
                            </div>
                        </div>
                        <?php echo form_open('dashboard/seo_tools/website_meta_keywords') ?>
                            <div class="panel-body">

                                <div class="form-group row">
                                    <label for="meta_keywords" class="col-sm-3 col-form-label"><?php echo display('meta_keywords')?></label>
                                    <div class="col-sm-6">
                                        <input type="text" name="meta_keywords" value="<?php echo $meta_setting[0]['meta_keyword']; ?>" id="meta_keywords" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="meta_description" class="col-sm-3 col-form-label"><?php echo display('meta_description')?></label>
                                    <div class="col-sm-6">
                                        <textarea name="meta_description" id="meta_description" class="form-control" rows="3"><?php echo $meta_setting[0]['meta_description']; ?></textarea>
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



