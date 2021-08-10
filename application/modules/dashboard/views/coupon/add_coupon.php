<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Add new coupon start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_coupon') ?></h1>
            <small><?php echo display('add_new_coupon') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('web_settings') ?></a></li>
                <li class="active"><?php echo display('add_coupon') ?></li>
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
                <?php if($this->permission->check_label('coupon')->read()->access()){ ?>
                    <a href="<?php echo base_url('dashboard/Ccoupon/manage_coupon')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_coupon')?></a>
                <?php } ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_coupon') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('dashboard/Ccoupon/insert_coupon', array('class' => 'form-vertical','id' => 'validate'))?>
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="coupon_name" class="col-sm-3 col-form-label"><?php echo display('coupon_name')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="coupon_name" id="coupon_name" type="text" placeholder="<?php echo display('coupon_name') ?>"  required="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="discount_type" class="col-sm-3 col-form-label"><?php echo display('discount_type')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="discount_type" id="discount_type" onchange="dis_type(this)">
                                    <option value="1"><?php echo display('discount_amount')?></option>
                                    <option value="2"><?php echo display('discount_percentage')?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" id="amount">
                            <label for="discount_amount" class="col-sm-3 col-form-label"><?php echo display('discount_amount')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="discount_amount" id="discount_amount" type="number" required="" placeholder="<?php echo display('discount_amount')?>">
                            </div>
                        </div>

                        <div class="form-group row" id="percentage">
                            <label for="discount_percentage" class="col-sm-3 col-form-label"><?php echo display('discount_percentage')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="discount_percentage" id="discount_percentage" type="number" required="" placeholder="<?php echo display('discount_percentage')?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="start_date" class="col-sm-3 col-form-label"><?php echo display('start_date')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control coupon_date datepicker " name ="start_date" id="start_date" type="text" required="" placeholder="<?php echo display('start_date')?>" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="end_date" class="col-sm-3 col-form-label"><?php echo display('end_date')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control coupon_date  datepicker" name ="end_date" id="end_date" type="text" required="" placeholder="<?php echo display('end_date')?>" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-coupon" class="btn btn-success btn-large" name="add-coupon" value="<?php echo display('save') ?>" />
                                <input type="submit" id="add-coupon-another" class="btn btn-primary btn-large" name="add-coupon-another" value="<?php echo display('save_and_add_another') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add new coupon end -->
<script src="<?php echo MOD_URL.'dashboard/assets/js/coupon_add.js'; ?>"></script>
