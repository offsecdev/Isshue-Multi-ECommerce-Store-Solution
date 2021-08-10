<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Add new web footer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_web_footer') ?></h1>
            <small><?php echo display('add_new_web_footer') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('web_settings') ?></a></li>
                <li class="active"><?php echo display('add_web_footer') ?></li>
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
            if (($error_message || $validatio_error)) {
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
                <?php if($this->permission->check_label('web_footer')->read()->access()){ ?>
                  <a href="<?php echo base_url('dashboard/Cweb_footer/manage_web_footer')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_web_footer')?></a>
                <?php }?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_web_footer') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('dashboard/Cweb_footer/insert_web_footer', array('class' => 'form-vertical','id' => 'validate'))?>
                        <div class="panel-body">

                            <div class="form-group row">
                                <label for="headlines" class="col-sm-3 col-form-label"><?php echo display('headlines')?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="headlines" id="headlines" type="text" placeholder="<?php echo display('headlines') ?>"  required="">
                                </div>
                            </div>

                        	<div class="form-group row">
                                  <label for="content4" class="col-sm-3 col-form-label"><?php echo display('details')?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <textarea name="details" class="form-control summernote" placeholder="<?php echo display('details')?>" id="content4" required row="3"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="position" class="col-sm-3 col-form-label"><?php echo display('position')?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="position" id="position" type="number" placeholder="<?php echo display('position') ?>"  required="">
                                </div>
                            </div>
                    
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-6">
                                    <input type="submit" id="add-web_footer" class="btn btn-success btn-large" name="add-web_footer" value="<?php echo display('save') ?>" />
                                    <input type="submit" id="add-web_footer-another" class="btn btn-primary btn-large" name="add-web_footer-another" value="<?php echo display('save_and_add_another') ?>" />
                                </div>
                            </div>
                        </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add new web footer end -->



