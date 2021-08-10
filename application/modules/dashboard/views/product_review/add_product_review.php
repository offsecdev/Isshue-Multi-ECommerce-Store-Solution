<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Add product review start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_product_review') ?></h1>
            <small><?php echo display('add_product_review') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('web_settings') ?></a></li>
                <li class="active"><?php echo display('add_product_review') ?></li>
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
                <?php if($this->permission->check_label('product_review')->read()->access()){ ?>
                  <a href="<?php echo base_url('dashboard/Cproduct_review/manage_product_review')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_product_review')?></a>
                <?php } ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_product_review') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('dashboard/Cproduct_review/insert_product_review', array('class' => 'form-vertical','id' => 'validate'))?>
                    <div class="panel-body">

                    	<div class="form-group row">
                            <label for="product_id" class="col-sm-3 col-form-label"><?php echo display('product_name')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" id="product_id" name="product_id" required="">
                                    <option></option>
                                    {product_list}
                                    <option value="{product_id}">{product_name} - ({product_model})</option>
                                    {/product_list}
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="comments" class="col-sm-3 col-form-label"><?php echo display('comments')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <textarea name="comments" class="form-control" placeholder="<?php echo display('comments')?>" id="comments" required row="3" ></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="rate" class="col-sm-3 col-form-label"><?php echo display('rate')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="rate" id="rate" type="number" placeholder="<?php echo display('rate') ?>" required min="0" max="5">
                            </div>
                        </div>
                
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-product_review" class="btn btn-success btn-large" name="add-product_review" value="<?php echo display('save') ?>" />
                                <input type="submit" id="add-product_review-another" class="btn btn-primary btn-large" name="add-product_review-another" value="<?php echo display('save_and_add_another') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add product review end -->



