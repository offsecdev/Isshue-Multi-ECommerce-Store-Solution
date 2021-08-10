<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_pay_with') ?></h1>
            <small><?php echo display('add_new_category') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('pay_with') ?></a></li>
                <li class="active"><?php echo display('add_pay_with') ?></li>
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
        <?php if (validation_errors()) { ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo validation_errors() ?>
        </div>
        <?php } ?>

        <div class="row">
            <div class="col-sm-12">
                <div class="column">
                <?php if($this->permission->check_label('manage_pay_with')->read()->access()){ ?>    
                    <a href="<?php echo base_url('dashboard/Cpay_with')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_pay_with')?></a>
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
                            <h4><?php echo display('add_pay_with') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('dashboard/Cpay_with/create', array('class' => 'form-vertical','id' => 'validate'))?>
                    <div class="panel-body">

                       <div class="form-group row">
                            <label for="category_name" class="col-sm-3 col-form-label"><?php echo display('title')?><span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="title" id="title" type="text" placeholder="<?php echo display('title') ?>"  required="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="image" class="col-sm-3 col-form-label"><?php echo display('image')?><span class="text-danger">*</span> </label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="image" id="image" type="file">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="link" class="col-sm-3 col-form-label"><?php echo display('link')?> </label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="link" id="link" type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="top_menu" class="col-sm-3 col-form-label"><?php echo display('status')?></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="status" id="status">
                                    <option value=""></option>
                                    <option value="1"><?php echo display('active')?></option>
                                    <option value="0"><?php echo display('inactive')?></option>
                                </select>
                            </div>
                        </div>  
                        <div class="form-group row">
                            <label for="top_menu" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success">Save</button>
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



