<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Add new block start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_block') ?></h1>
            <small><?php echo display('add_new_block') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('web_settings') ?></a></li>
                <li class="active"><?php echo display('add_block') ?></li>
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
                    <?php if($this->permission->check_label('block')->read()->access()){ ?>
                        <a href="<?php echo base_url('dashboard/Cblock')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_block')?></a>
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
                            <h4><?php echo display('add_block') ?> </h4>
                        </div>
                    </div>
                  <?php echo form_open_multipart('dashboard/Cblock/block_add', array('class' => 'form-vertical','id' => 'validate'))?>
                    <div class="panel-body">

                    	<div class="form-group row">
                            <label for="category" class="col-sm-3 col-form-label"><?php echo display('category')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" id="category" name="block_cat_id" required="">
                                    <option></option>
                                    {category_list}
                                    <option value="{category_id}">{category_name}</option>
                                    {/category_list}
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="block_position" class="col-sm-3 col-form-label"><?php echo display('block_position')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="block_position" id="block_position" type="number" placeholder="<?php echo display('block_position') ?>"  required="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="block_style" class="col-sm-3 col-form-label"><?php echo display('block_style')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" id="block_style" name="block_style" required="">
                                    <option></option>
                                    <option value="1"><?php echo display('1')?></option>
                                    <option value="2"><?php echo display('2')?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="block_image" class="col-sm-3 col-form-label"><?php echo display('image')?> </label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="block_image" id="block_image" type="file" placeholder="<?php echo display('block_image') ?>">
                            </div>
                        </div>
                
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-block" class="btn btn-success btn-large" name="add-block" value="<?php echo display('save') ?>" />
                                <input type="submit" id="add-block-another" class="btn btn-primary btn-large" name="add-block-another" value="<?php echo display('save_and_add_another') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add new block end -->



