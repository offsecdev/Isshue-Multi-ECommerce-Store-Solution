<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Edit supplier page start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('supplier_edit') ?></h1>
            <small><?php echo display('supplier_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('supplier') ?></a></li>
                <li class="active"><?php echo display('supplier_edit') ?></li>
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

        <!-- New supplier -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('supplier_edit') ?> </h4>
                        </div>
                    </div>
                   <?php echo form_open_multipart('dashboard/Csupplier/supplier_update',array( 'id' => 'validate'))?>
                    <div class="panel-body">

                    	<div class="form-group row">
                            <label for="supplier_name" class="col-sm-3 col-form-label"><?php echo display('supplier_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="supplier_name" id="supplier_name" type="text" value="{supplier_name}" placeholder="<?php echo display('supplier_name') ?>" required>
                            </div>
                        </div>

                       	<div class="form-group row">
                            <label for="mobile" class="col-sm-3 col-form-label"><?php echo display('supplier_mobile') ?> </label>
                            <div class="col-sm-6">
                                <input class="form-control" name="mobile" id="mobile" type="number" placeholder="<?php echo display('supplier_mobile') ?>" value="{mobile}" min="0">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="supplier_email" class="col-sm-3 col-form-label"><?php echo display('suppler_email') ?> </label>
                            <div class="col-sm-6">
                                <input class="form-control" name="email" id="supplier_email" type="email" placeholder="<?php echo display('suppler_email') ?>" value="{email}" min="0">
                            </div>
                        </div>
   
                        <div class="form-group row">
                            <label for="address " class="col-sm-3 col-form-label"><?php echo display('supplier_address') ?></label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="address" id="address " rows="3" placeholder="<?php echo display('supplier_address') ?>">{address}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="details" class="col-sm-3 col-form-label"><?php echo display('supplier_details') ?></label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="details" id="details" rows="3" placeholder="<?php echo display('supplier_details') ?>">{details}</textarea>
                            </div>
                        </div>
                        <input type="hidden" name="supplier_id" value="{supplier_id}" />

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                               <input type="submit" id="add-supplier" class="btn btn-success btn-large" name="add-supplier" value="<?php echo display('save_changes') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Edit supplier page end -->



