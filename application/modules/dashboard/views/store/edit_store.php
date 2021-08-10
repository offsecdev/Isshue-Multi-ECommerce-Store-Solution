<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!--Update store start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('store_edit') ?></h1>
            <small><?php echo display('store_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('store_set') ?></a></li>
                <li class="active"><?php echo display('store_edit') ?></li>
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

        <!--Edit store -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('store_edit') ?> </h4>
                        </div>
                    </div>
                  <?php echo form_open_multipart('dashboard/Cstore/store_update/{store_id}',array('class' => 'form-vertical', 'id' => 'validate'))?>
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="store_name" class="col-sm-3 col-form-label"><?php echo display('store_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="store_name" id="store_name" type="text" placeholder="<?php echo display('store_name') ?>"  required="" value="{store_name}">
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <label for="store_address" class="col-sm-3 col-form-label"><?php echo display('store_address') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="store_address" id="store_address" type="text" placeholder="<?php echo display('store_address') ?>"  required="" value="{store_address}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-3 col-form-label"><?php echo display('default_status')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" id="default_status" required="" name="default_status">
                                    <option value=""></option>
                                    <option value="1" <?php if ($default_status == 1) {echo "selected";}?>><?php echo display('yes')?></option>
                                    <option value="0" <?php if ($default_status == 0) {echo "selected";}?>><?php echo display('no')?></option>
                               </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="update_store" class="btn btn-success btn-large" name="update_store" value="<?php echo display('save_changes') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Update store end -->



