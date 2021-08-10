<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_variant') ?></h1>
            <small><?php echo display('add_new_variant') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('variant') ?></a></li>
                <li class="active"><?php echo display('add_variant') ?></li>
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
                    <?php if($this->permission->check_label('manage_variant')->read()->redirect()){ ?>
                    <a href="<?php echo base_url('dashboard/Cvariant/manage_variant')?>" class="btn btn-success m-b-5 m-r-2">
                        <i class="ti-align-justify"> </i> <?php echo display('manage_variant')?>
                    </a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_variant') ?> </h4>
                        </div>
                    </div>
                  <?php echo form_open_multipart('dashboard/Cvariant/insert_variant', array('class' => 'form-vertical','id' => 'validate'))?>
                    <div class="panel-body">

                        

                    	<div class="form-group row">
                            <label for="variant_name" class="col-sm-3 col-form-label"><?php echo display('variant_name')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="variant_name" id="variant_name" type="text" placeholder="<?php echo display('variant_name') ?>"  required="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="variant_type" class="col-sm-3 col-form-label"><?php echo display('variant_type')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select name="variant_type" id="variant_type" class="form-control" required="">
                                    <option value=""></option>
                                    <option value="size" ><?php echo display('size')?></option>
                                    <option value="color" ><?php echo display('color')?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" id="color_code_area" style="display: none">
                            <label for="color_code" class="col-sm-3 col-form-label"><?php echo display('color_code') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="color_code" id="color_code" type="color" placeholder="<?php echo display('color_code') ?>"  required="" value="{color_code}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="category_id" class="col-sm-3 col-form-label"><?php echo display('category')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select name="category_id[]" id="category_id" class="form-control" multiple="multiple" required="">
                                    <option value=""></option>
                                    <?php foreach ($categories as $category):?>
                                    <option value="<?php echo html_escape($category['category_id'])?>"><?php echo html_escape($category['category_name']); ?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-variant" class="btn btn-success btn-large" name="add-variant" value="<?php echo display('save') ?>" />
                                <input type="submit" id="add-variant-another" class="btn btn-primary btn-large" name="add-variant-another" value="<?php echo display('save_and_add_another') ?>" />
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

<script src="<?php echo MOD_URL.'dashboard/assets/js/add_variant.js'; ?>"></script>

