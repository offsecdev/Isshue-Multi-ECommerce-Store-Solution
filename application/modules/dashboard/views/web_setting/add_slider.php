<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Add slider start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_slider') ?></h1>
            <small><?php echo display('update_your_slider') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('web_settings') ?></a></li>
                <li class="active"><?php echo display('add_slider') ?></li>
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


        <div class="row">
            <div class="col-sm-12">
                <div class="column">
                <?php if($this->permission->check_label('slider')->read()->access()){ ?>
                   <a href="<?php echo base_url('dashboard/Cweb_setting/manage_slider')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_slider')?></a>
                <?php } ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_slider') ?> </h4>
                        </div>
                    </div>
                  <?php echo form_open_multipart('dashboard/Cweb_setting/submit_slider', array('class' => 'form-vertical','id' => 'validate'))?>
                    <div class="panel-body">
                        
                        <div class="form-group row">
                            <label for="slider_link" class="col-sm-3 col-form-label"><?php echo display('slider_link') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="slider_link" id="slider_link" type="text" placeholder="<?php echo display('slider_link') ?>" required>
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="slider_image" class="col-sm-3 col-form-label"><?php echo display('slider_image') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="slider_image" id="slider_image" type="file" placeholder="<?php echo display('slider_image') ?>" required>
                                <p>Recommended size: 1350 * 505</p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="slider_position" class="col-sm-3 col-form-label"><?php echo display('slider_position') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="slider_position" id="slider_position" type="number" placeholder="<?php echo display('slider_position') ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="slider_category" class="col-sm-3 col-form-label"><?php echo display('slider_category') ?> <span class="help-block">(For mobile App)</span></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="slider_category" id="slider_category">
                                    <option value=""></option>
                                    <?php foreach ($categories as $cat) { ?>
                                    <option value="<?php echo $cat['category_id'] ?>"><?php echo $cat['category_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-slider" class="btn btn-success btn-large" name="add-slider" value="<?php echo display('save') ?>" />
                                <input type="submit" id="add-slider-another" class="btn btn-primary btn-large" name="add-slider-another" value="<?php echo display('save_and_add_another') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add slider end -->