<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Edit new bank start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('bank_edit') ?></h1>
            <small><?php echo display('bank_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('settings') ?></a></li>
                <li class="active"><?php echo display('bank_edit') ?></li>
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


        <!-- New bank -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('bank_list') ?></h4>
                        </div>
                    </div>
                   <?php echo form_open_multipart('dashboard/Csettings/update_bank/'.$bank_list[0]['bank_id'],array('class' => 'form-vertical','id' => 'validate' ))?>
                    <div class="panel-body">

                    	<div class="form-group row">
                            <label for="bank_name" class="col-sm-3 col-form-label"><?php echo display('bank_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="bank_name" id="bank_name" required="" placeholder="<?php echo display('bank_name') ?>" value="<?php echo html_escape($bank_list[0]['bank_name'])?>"/>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="account_name" class="col-sm-3 col-form-label"><?php echo display('account_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="ac_name" id="account_name" required="" placeholder="<?php echo display('account_name') ?>" value="<?php echo html_escape($bank_list[0]['ac_name'])?>" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="branch" class="col-sm-3 col-form-label"><?php echo display('branch') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="branch" id="branch" required="" placeholder="<?php echo display('branch') ?>" value="<?php echo html_escape($bank_list[0]['branch'])?>" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="account_no" class="col-sm-3 col-form-label"><?php echo display('account_no') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="ac_number" id="account_no" required="" placeholder="<?php echo display('account_no') ?>" value="<?php echo html_escape($bank_list[0]['ac_number'])?>"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-deposit" class="btn btn-success" name="add-deposit" value="<?php echo display('save_changes') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Edit new bank end -->



