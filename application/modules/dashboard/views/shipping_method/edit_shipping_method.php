<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!--Edit shipping method start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('shipping_method_edit') ?></h1>
            <small><?php echo display('shipping_method_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('web_settings') ?></a></li>
                <li class="active"><?php echo display('shipping_method_edit') ?></li>
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

        <!--Edit shipping method -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('shipping_method_edit') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('dashboard/Cshipping_method/shipping_method_update/{method_id}',array('class' => 'form-vertical', 'id' => 'validate'))?>
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="position" class="col-sm-3 col-form-label"><?php echo display('position')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="position" id="position" type="number" placeholder="<?php echo display('position') ?>"  required="" value="{position}">
                            </div>
                        </div>                        

                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"><?php echo display('name')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="method_name" id="name" type="text" placeholder="<?php echo display('name') ?>"  required="" value="{method_name}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="details" class="col-sm-3 col-form-label"><?php echo display('details')?></label>
                            <div class="col-sm-6">
                                <textarea name="details" class="form-control" placeholder="<?php echo display('details')?>" id="details" row="3" >{details}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ammount" class="col-sm-3 col-form-label"><?php echo display('ammount')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="charge_amount" id="ammount" type="number" placeholder="<?php echo display('ammount') ?>"  required="" value="{charge_amount}">
                            </div>
                        </div>  
                
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-shipping_method" class="btn btn-success btn-large" name="add-shipping_method" value="<?php echo display('update') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Edit shipping method end -->



