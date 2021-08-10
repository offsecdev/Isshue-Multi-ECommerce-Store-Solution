<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!--Edit currency start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('currency_edit') ?></h1>
            <small><?php echo display('currency_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('currency') ?></a></li>
                <li class="active"><?php echo display('currency_edit') ?></li>
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

        <!--Edit currency -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('currency_edit') ?> </h4>
                        </div>
                    </div>
                  <?php echo form_open_multipart('dashboard/Ccurrency/currency_update/{currency_id}',array('class' => 'form-vertical', 'id' => 'validate'))?>
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="currency_name" class="col-sm-3 col-form-label"><?php echo display('currency_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="currency_name" id="currency_name" type="text" placeholder="<?php echo display('currency_name') ?>"  required="" value="{currency_name}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="currency_icon" class="col-sm-3 col-form-label"><?php echo display('currency_icon')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="currency_icon" id="currency_icon" type="text" placeholder="<?php echo display('currency_icon') ?>"  required="" value="{currency_icon}">
                            </div>
                        </div>                        

                        <div class="form-group row">
                            <label for="currency_position" class="col-sm-3 col-form-label"><?php echo display('currency_position')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="currency_position" id="currency_position" required="">
                                    <option value=""></option>
                                    <option value="0" <?php if ($currency_position == 0):echo "selected";endif ?>><?php echo display('left')?></option>
                                    <option value="1" <?php if ($currency_position == 1):echo "selected";endif ?>><?php echo display('right')?></option>
                                </select>
                            </div>
                        </div>              

                        <div class="form-group row">
                            <label for="conversion_rate" class="col-sm-3 col-form-label"><?php echo display('conversion_rate')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="conversion_rate" id="conversion_rate" type="text" placeholder="<?php echo display('conversion_rate') ?>"  required="" value="{convertion_rate}">
                            </div>
                        </div>                        

                        <div class="form-group row">
                            <label for="default_status" class="col-sm-3 col-form-label"><?php echo display('default_status')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="default_status" id="default_status" required="">
                                    <option value=""></option>
                                    <option value="1" <?php if ($default_status == 1):echo "selected";endif ?>><?php echo display('yes')?></option>
                                    <option value="0" <?php if ($default_status == 0):echo "selected";endif ?>><?php echo display('no')?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="update_currency" class="btn btn-success btn-large" name="update_currency" value="<?php echo display('save_changes') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Edit currency end -->



