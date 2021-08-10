<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Add new Account start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('create_accounts') ?></h1>
            <small><?php echo display('create_accounts') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('settings') ?></a></li>
                <li class="active"><?php echo display('create_accounts') ?></li>
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

        <div class="row">
            <div class="col-sm-12">
                <div class="column">
                <?php if($this->permission->check_label('manage_accounts')->read()->access()){ ?>
                  <a href="<?php echo base_url('dashboard/Caccounts/manage_account')?>" class="btn btn-success color4 m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_account')?></a>
                <?php }?>
                </div>
            </div>
        </div>

        
        <!-- New Account -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('create_accounts') ?> </h4>
                        </div>
                    </div>
                  	<?php echo form_open_multipart('dashboard/Caccounts/create_account_data',array('class' => 'form-vertical', 'id' => 'validate'))?>
                    <div class="panel-body">

                    	<div class="form-group row">
                            <label for="account_name" class="col-sm-3 col-form-label"><?php echo display('account_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" name="account_name" placeholder="<?php echo display('account_name') ?>" id="account_name" required="" class="form-control">
                            </div>
                        </div>

                       	<div class="form-group row">
                            <label for="account_type" class="col-sm-3 col-form-label"><?php echo display('account_type') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select name="account_type" class="form-control" id="account_type"> 
	                                <option value="1"><?php echo display('credit_minus') ?> </option>
	                                <option value="2"><?php echo display('debit_plus') ?> </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-deposit" class="btn btn-success color4" name="add-deposit" value="<?php echo display('create_accounts') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add new Account end -->



