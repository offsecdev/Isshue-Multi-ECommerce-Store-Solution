<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_customer') ?></h1>
            <small><?php echo display('add_new_customer') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('customer') ?></a></li>
                <li class="active"><?php echo display('add_customer') ?></li>
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
                    <?php if($this->permission->check_label('manage_customer')->read()->access()){ ?>
                        <a href="<?php echo base_url('dashboard/Ccustomer/manage_customer')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_customer')?></a>
                    <?php } if($this->permission->check_label('customer_ledger')->read()->access()){ ?>
                        <a href="<?php echo base_url('dashboard/Ccustomer/customer_ledger_report')?>" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('customer_ledger')?></a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_customer') ?> </h4>
                        </div>
                    </div>
                  <?php echo form_open('dashboard/Ccustomer/insert_customer', array('class' => 'form-vertical','id' => 'validate'))?>
                    <div class="panel-body">

                    	<div class="form-group row">
                            <label for="customer_name" class="col-sm-3 col-form-label"><?php echo display('customer_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="customer_name" id="customer_name" type="text" placeholder="<?php echo display('customer_name') ?>"  required="">
                            </div>
                        </div>
   
                       	<div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label"><?php echo display('customer_email') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="email" id="email" type="email" placeholder="<?php echo display('customer_email') ?>"  required="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mobile" class="col-sm-3 col-form-label"><?php echo display('customer_mobile') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="mobile" id="mobile" type="number" placeholder="<?php echo display('customer_mobile') ?>"  required="" min="0" data-toggle="tooltip" data-placement="bottom" title="<?php echo display('add_country_code')?>">
                            </div>
                        </div>
   
                        <div class="form-group row">
                            <label for="address " class="col-sm-3 col-form-label"><?php echo display('customer_address') ?></label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="address" id="address " rows="3" placeholder="<?php echo display('customer_address') ?>"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="customer_address_1 " class="col-sm-3 col-form-label"><?php echo display('customer_address_1') ?></label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="customer_address_1" id="customer_address_1 " rows="3" placeholder="<?php echo display('customer_address_1') ?>"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="customer_address_2 " class="col-sm-3 col-form-label"><?php echo display('customer_address_2') ?></label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="customer_address_2" id="customer_address_2 " rows="3" placeholder="<?php echo display('customer_address_2') ?>"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="city " class="col-sm-3 col-form-label"><?php echo display('city') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="city" id="city" type="text" placeholder="<?php echo display('city') ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="country " class="col-sm-3 col-form-label"><?php echo display('country') ?></label>
                            <div class="col-sm-6">
                                <select class="form-control select2 width_100p" id="country" name="country" >
                                    <option value=""><?php echo display('select_one') ?></option>
                                    <?php if ($country_list) { ?>
                                    {country_list}
                                    <option value="{id}">{name}</option>
                                    {/country_list}
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="state " class="col-sm-3 col-form-label"><?php echo display('state') ?></label>
                            <div class="col-sm-6">
                                <select class="form-control select2 width_100p" id="state" name="state">
                                    <option value=""><?php echo display('select_one') ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="zip " class="col-sm-3 col-form-label"><?php echo display('zip') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="zip" id="zip" type="text" placeholder="<?php echo display('zip') ?>" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-customer" class="btn btn-primary btn-large" name="add-customer" value="<?php echo display('save') ?>" />
								<input type="submit" value="<?php echo display('save_and_add_another') ?>" name="add-customer-another" class="btn btn-large btn-success" id="add-customer-another">
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
<script src="<?php echo MOD_URL.'dashboard/assets/js/add_customer_form.js'; ?>"></script>
