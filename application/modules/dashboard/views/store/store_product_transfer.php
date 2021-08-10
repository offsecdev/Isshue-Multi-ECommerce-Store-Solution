<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Store product transfer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('store_product_transfer') ?></h1>
            <small><?php echo display('store_product_transfer') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('store_set') ?></a></li>
                <li class="active"><?php echo display('store_product_transfer') ?></li>
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
                    <?php if($this->permission->check_label('store_add')->create()->access()){ ?>
                    <a href="<?php echo base_url('dashboard/Cstore')?>" class="btn -btn-info color4 color5 m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('add_store')?></a>
                    <?php }if($this->permission->check_label('manage_store')->read()->access()){ ?>
                    <a href="<?php echo base_url('dashboard/Cstore/manage_store')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_store')?></a>
                    <?php }if($this->permission->check_label('manage_store_product')->update()->access()){ ?>
                    <a href="<?php echo base_url('dashboard/Cstore/manage_store_product')?>" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_store_product')?></a>
                    <?php } ?>

                </div>
            </div>
        </div>

        <!-- Store product transfer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('store_product_transfer') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('dashboard/Cstore/insert_store_product', array('class' => 'form-vertical','id' => 'validate'))?>
                    <div class="panel-body">

                    	<div class="form-group row">
                            <label for="store_name" class="col-sm-3 col-form-label"><?php echo display('store_name')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" id="store_id" name="store_id" required="">
                                    <option value=""></option>
                                    {store_list}
                                    <option value="{store_id}">{store_name}</option>
                                    {/store_list}
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="transfer" class="col-sm-3 col-form-label"><?php echo display('transfer_to')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" id="transfer" name="t_store_id" required="" >
                               
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="product_name" class="col-sm-3 col-form-label"><?php echo display('product_name')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" id="product_name" name="product_id" required="">

                                </select>
                            </div>
                        </div>  
                        <div class="form-group row">
                            <label for="variant" class="col-sm-3 col-form-label"><?php echo display('variant')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" id="variant" name="variant_id" required="">
                                                                
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="variant_color" class="col-sm-3 col-form-label"><?php echo display('color')?></label>
                            <div class="col-sm-6">
                                <select class="form-control" id="variant_color" name="variant_color">
                                                                
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="quantity" class="col-sm-3 col-form-label"><?php echo display('quantity')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="quantity" id="quantity" type="number" placeholder="<?php echo display('quantity') ?>"  required="">
                            </div>
                        </div>
                
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-store" class="btn btn-success btn-large" name="add-store" value="<?php echo display('save') ?>" />
                                <input type="submit" id="add-store-another" class="btn btn-success btn-large" name="add-store-another" value="<?php echo display('save_and_add_another') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Store product transfer end -->
<script src="<?php echo MOD_URL.'dashboard/assets/js/store_product_transfer.js'; ?>"></script>
