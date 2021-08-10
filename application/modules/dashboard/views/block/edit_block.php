<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!--Edit block start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('block_edit') ?></h1>
            <small><?php echo display('block_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('web_settings') ?></a></li>
                <li class="active"><?php echo display('block_edit') ?></li>
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

        <!--Edit block -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('block_edit') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('dashboard/Cblock/block_update/{block_id}',array('class' => 'form-vertical', 'id' => 'validate'))?>
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="category" class="col-sm-3 col-form-label"><?php echo display('category')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" id="category" name="block_cat_id" required="">
                                    <option></option>
                                    {category_list}
                                    <option value="{category_id}">{category_name}</option>
                                    {/category_list} 
                                    {category_selected}
                                    <option value="{category_id}" selected="">{category_name}</option>
                                    {/category_selected}
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="block_position" class="col-sm-3 col-form-label"><?php echo display('block_position')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="block_position" id="block_position" type="number" placeholder="<?php echo display('block_position') ?>"  required="" value="{block_position}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="block_image" class="col-sm-3 col-form-label"><?php echo display('image')?> </label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="block_image" id="block_image" type="file" placeholder="<?php echo display('block_image') ?>">

                                <img src="<?php echo base_url();?>{block_image}" height="100" width="100" class="img img-responsive mt_5">
                                <input class="form-control" name ="old_image" id="old_image" type="hidden" value="{block_image}"  >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="block_style" class="col-sm-3 col-form-label"><?php echo display('block_style')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" id="block_style" name="block_style" required="">
                                    <option></option>
                                    <option value="1" <?php if($block_style == 1)echo "selected";?>><?php echo display('1')?></option>
                                    <option value="2" <?php if($block_style == 2)echo "selected";?>><?php echo display('2')?></option>

                                </select>
                            </div>
                        </div>
                
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-block" class="btn btn-success btn-large" name="add-block" value="<?php echo display('update') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Edit block end -->



