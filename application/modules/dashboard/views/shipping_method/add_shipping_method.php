<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Add new shipping method start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_shipping_method') ?></h1>
            <small><?php echo display('add_shipping_method') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('web_settings') ?></a></li>
                <li class="active"><?php echo display('add_shipping_method') ?></li>
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
                    <?php if($this->permission->check_label('shipping_method')->read()->access()){ ?>
                    <a href="<?php echo base_url('dashboard/Cshipping_method/manage_shipping_method')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_shipping_method')?></a>
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
                            <h4><?php echo display('add_shipping_method') ?> </h4>
                        </div>
                    </div>
                  <?php echo form_open_multipart('dashboard/Cshipping_method/insert_shipping_method', array('class' => 'form-vertical','id' => 'validate'))?>
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="position" class="col-sm-3 col-form-label"><?php echo display('position')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="position" id="position" type="number" placeholder="<?php echo display('position') ?>"  required="">
                            </div>
                        </div>                        

                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"><?php echo display('name')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="method_name" id="name" type="text" placeholder="<?php echo display('name') ?>"  required="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="details" class="col-sm-3 col-form-label"><?php echo display('details')?></label>
                            <div class="col-sm-6">
                                <textarea name="details" class="form-control" placeholder="<?php echo display('details')?>" id="details" row="3" ></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ammount" class="col-sm-3 col-form-label"><?php echo display('ammount')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="charge_amount" id="ammount" type="number" placeholder="<?php echo display('ammount') ?>"  required="">
                            </div>
                        </div>  
                
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-shipping_method" class="btn btn-success btn-large" name="add-shipping_method" value="<?php echo display('save') ?>" />
                                <input type="submit" id="add-shipping_method-another" class="btn btn-primary btn-large" name="add-shipping_method-another" value="<?php echo display('save_and_add_another') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add new shipping method end -->



