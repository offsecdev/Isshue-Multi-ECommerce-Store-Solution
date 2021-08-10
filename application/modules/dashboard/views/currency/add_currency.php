<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Add new currency start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_currency') ?></h1>
            <small><?php echo display('add_new_currency') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('currency') ?></a></li>
                <li class="active"><?php echo display('add_currency') ?></li>
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
                <?php if($this->permission->check_label('manage_currency')->read()->access()){ ?>
                    <a href="<?php echo base_url('dashboard/Ccurrency/manage_currency')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_currency')?>
                    </a>
                <?php } ?>
                    <button type="button" class="btn btn-danger m-b-5 m-r-2"><?php echo display('you_must_have_a_default_currency')?></button>
                </div>
            </div>
        </div>

        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_currency') ?> </h4>
                        </div>
                    </div>
                  <?php echo form_open_multipart('dashboard/Ccurrency/insert_currency', array('class' => 'form-vertical','id' => 'validate'))?>
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="currency_name" class="col-sm-3 col-form-label"><?php echo display('currency_name')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="currency_name" id="currency_name" type="text" placeholder="<?php echo display('currency_name') ?>"  required="">
                            </div>
                        </div>                   	

                        <div class="form-group row">
                            <label for="currency_icon" class="col-sm-3 col-form-label"><?php echo display('currency_icon')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="currency_icon" id="currency_icon" type="text" placeholder="<?php echo display('currency_icon') ?>"  required="">
                            </div>
                        </div>                        

                        <div class="form-group row">
                            <label for="currency_position" class="col-sm-3 col-form-label"><?php echo display('currency_position')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="currency_position" id="currency_position" required="">
                                    <option value=""></option>
                                    <option value="0"><?php echo display('left')?></option>
                                    <option value="1"><?php echo display('right')?></option>
                                </select>
                            </div>
                        </div>              

                        <div class="form-group row">
                            <label for="conversion_rate" class="col-sm-3 col-form-label"><?php echo display('conversion_rate')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="conversion_rate" id="conversion_rate" type="text" placeholder="<?php echo display('conversion_rate') ?>"  required="">
                            </div>
                        </div>                        

                        <div class="form-group row">
                            <label for="default_status" class="col-sm-3 col-form-label"><?php echo display('default_status')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="default_status" id="default_status" required="">
                                    <option value=""></option>
                                    <option value="1"><?php echo display('yes')?></option>
                                    <option value="0"><?php echo display('no')?></option>
                                </select>
                                <span class="help-block small"><?php echo display('do_you_want_make_it_default_currency')?></span>
                            </div>
                        </div>
                
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-currency" class="btn btn-success btn-large" name="add-currency" value="<?php echo display('save') ?>" />
                                <input type="submit" id="add-currency-another" class="btn btn-primary btn-large" name="add-currency-another" value="<?php echo display('save_and_add_another') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add new currency end -->



