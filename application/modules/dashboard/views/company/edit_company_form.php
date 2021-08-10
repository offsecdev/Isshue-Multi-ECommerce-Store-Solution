<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Edit Company start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('company_edit') ?></h1>
            <small><?php echo display('edit_your_company_information') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('software_settings') ?></a></li>
                <li class="active"><?php echo display('company_edit') ?></li>
            </ol>
        </div>
    </section>

    <section class="content">
        <!-- Edit Company -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('company_edit') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('dashboard/Company_setup/company_update',array('class' => 'form-vertical', 'id' => 'insert_customer'))?>
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="bank_name" class="col-sm-3 col-form-label"><?php echo display('company_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" tabindex="2" class="form-control" name="company_name" value="{company_name}"  placeholder="<?php echo display('company_name') ?>" required />
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="bank_name" class="col-sm-3 col-form-label"><?php echo display('mobile') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" tabindex="3" class="form-control" name="mobile" name="mobile" value="{mobile}"  placeholder="<?php echo display('mobile') ?>" required />
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="bank_name" class="col-sm-3 col-form-label"><?php echo display('address') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <textarea class="form-control input-description" tabindex="1" id="adress" name="address" placeholder="<?php echo display('address') ?>" required>{address}</textarea>
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="bank_name" class="col-sm-3 col-form-label"><?php echo display('email') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="email" tabindex="3" class="form-control" value="{email}" name="email" placeholder="<?php echo display('email') ?>" required />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bank_name" class="col-sm-3 col-form-label"><?php echo display('website') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="url" tabindex="3" class="form-control" value="{website}" name="website" placeholder="<?php echo display('website') ?>" required />
                            </div>
                        </div>

                        <input type="hidden" name="company_id" value="{company_id}" />

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-Customer" class="btn btn-success btn-large" name="add-Customer" value="<?php echo display('save_changes') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Edit Company end -->



