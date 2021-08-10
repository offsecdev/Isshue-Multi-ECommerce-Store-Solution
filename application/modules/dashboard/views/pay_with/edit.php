<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!--Edit customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('pay_with_edit') ?></h1>
            <small><?php echo display('pay_with_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('pay_with') ?></a></li>
                <li class="active"><?php echo display('pay_with_edit') ?></li>
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
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('pay_with_edit') ?> </h4>
                        </div>
                    </div>
                  <?php echo form_open_multipart('dashboard/Cpay_with/edit/{id}',array('class' => 'form-vertical', 'id' => 'validate'))?>
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="title" class="col-sm-3 col-form-label"><?php echo display('title') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="title" id="title" type="text" placeholder="<?php echo display('title') ?>"  required="" value="{title}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="image" class="col-sm-3 col-form-label"><?php echo display('image') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="image" id="image" type="file">
                                <img src="<?php echo base_url().'my-assets/image/pay_with/'.$image?>" height="100" width="100" class="img img-responsive mt_5"> 
                                <input class="form-control" name ="old_image" id="old_image" type="hidden" value="{image}"  >
                            </div>
                        </div>
                       
                         <div class="form-group row">
                    <label for="link" class="col-sm-3 col-form-label"><?php echo display('link')?> </label>
                    <div class="col-sm-6">
                        <input class="form-control" name ="link" id="link" value="<?php echo $link?>" type="text">
                    </div>
                </div>

                       <div class="form-group row">
                            <label for="status" class="col-sm-3 col-form-label"><?php echo display('status') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="status" id="status">
                                    <option value=""></option>
                                    <option value="1" <?php if ($status == 1):echo "selected";endif ?>><?php echo display('active') ?></option>
                                    <option value="0" <?php if ($status == 0):echo "selected";endif ?>><?php echo display('inactive') ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="update" class="btn btn-success btn-large" name="update" value="<?php echo display('save_changes') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Edit customer end -->



