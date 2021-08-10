<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Add new gallery start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_image') ?></h1>
            <small><?php echo display('add_new_image') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('image_gallery') ?></a></li>
                <li class="active"><?php echo display('add_image') ?></li>
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
                <?php if($this->permission->check_label('manage_product_image')->read()->access()){ ?>
                  <a href="<?php echo base_url('dashboard/Cgallery/manage_image')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_image')?></a>
                <?php } ?>
                </div>
            </div>
        </div>

        <!-- New image -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_image') ?> </h4>
                        </div>
                    </div>
                  <?php echo form_open_multipart('dashboard/Cgallery/insert_image', array('class' => 'form-vertical','id' => 'validate'))?>
                    <div class="panel-body">

                    	<div class="form-group row">
                            <label for="product_name" class="col-sm-3 col-form-label"><?php echo display('product_name')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="product_id" id="product_name" required>
                                    <option value=""></option>
                                    {product_list}
                                    <option value="{product_id}">{product_name}-({product_model})</option>
                                    {/product_list}
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="image" class="col-sm-3 col-form-label"><?php echo display('image')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="image" id="image" type="file" required="">
                            </div>
                        </div>
                
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-image" class="btn btn-success  btn-large" name="add-image" value="<?php echo display('save') ?>" />
                                <input type="submit" id="add-image-another" class="btn btn-primary btn-large" name="add-image-another" value="<?php echo display('save_and_add_another') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add new gallery end -->



