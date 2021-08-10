<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('update_setting') ?></h1>
            <small><?php echo display('update_your_web_setting') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('software_settings') ?></a></li>
                <li class="active"><?php echo display('update_setting') ?></li>
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

        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('update_setting') ?> </h4>
                        </div>
                    </div>
                  <?php echo form_open_multipart('dashboard/Csoft_setting/update_setting', array('class' => 'form-vertical','id' => 'validate'))?>
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="logo" class="col-sm-3 col-form-label"><?php echo display('logo') ?> </label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="logo" id="logo" type="file">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="logo" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-6">
                                 <img src="<?php echo base_url();?>{logo}" class="img img-responsive" height="100" width="100">
                                <input name ="old_logo" type="hidden" value="{logo}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="invoice_logo" class="col-sm-3 col-form-label"><?php echo display('invoice_logo') ?> </label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="invoice_logo" id="invoice_logo" type="file">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="invoice_logo" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-6">
                                 <img src="<?php echo base_url();?>{invoice_logo}" class="img img-responsive" height="100" width="100">
                                <input name ="old_invoice_logo" type="hidden" value="{invoice_logo}">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="favicon" class="col-sm-3 col-form-label"><?php echo display('favicon') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="favicon" id="favicon" type="file" >
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="favicon" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-6">
                                <img src="<?php echo base_url();?>{favicon}" class="img img-responsive" height="50" width="50">
                                <input name ="old_favicon" type="hidden" value="{favicon}">
                            </div>
                        </div>
                        
                    	<div class="form-group row">
                            <label for="footer_text" class="col-sm-3 col-form-label"><?php echo display('footer_text') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="footer_text" id="footer_text" type="text" placeholder="Foter Text" value="{footer_text}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="country" class="col-sm-3 col-form-label"><?php echo display('country') ?></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="country" id="country">
                                    <option value=""><?php echo display('select_one') ?></option>
                                    <?php if(!empty($country_list)){
                                        foreach ($country_list as $citem) {
                                     ?>
                                    <option value="<?php echo $citem['id']; ?>" <?php if ($citem['id'] == $country_id) {echo "selected";}?>><?php echo $citem['name']; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="language" class="col-sm-3 col-form-label"><?php echo display('language') ?> </label>
                            <div class="col-sm-6">
                               <?php 
                                echo form_dropdown('language', $language, $ses_lang,'class="form-control" id="language" required');
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lrt" class="col-sm-3 col-form-label"><?php echo display('ltr_or_rtr') ?></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="rtr" id="lrt">
                                    <option value=""><?php echo display('select_one') ?></option>
                                    <option value="0" <?php if ($rtr == 0) {echo "selected";}?>><?php echo display('ltr') ?></option>
                                    <option value="1" <?php if ($rtr == 1) {echo "selected";}?>><?php echo display('rtr') ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="captcha" class="col-sm-3 col-form-label"><?php echo display('captcha') ?></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="captcha" id="captcha">
                                    <option value=""><?php echo display('select_one') ?></option>
                                    <option value="1" <?php if ($captcha == '1') {echo "selected";}?>><?php echo display('active') ?></option>
                                    <option value="0" <?php if ($captcha == '0') {echo "selected";}?>><?php echo display('inactive') ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sms_service" class="col-sm-3 col-form-label"><?php echo display('sms_service') ?></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="sms_service" id="sms_service">
                                    <option value=""><?php echo display('select_one') ?></option>
                                    <option value="0" <?php if ($sms_service == 0) {echo "selected";}?>><?php echo display('inactive') ?></option>
                                    <option value="1" <?php if ($sms_service == 1) {echo "selected";}?>><?php echo display('active') ?></option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <a href="<?php echo base_url('dashboard/Csms_setting/sms_configuration') ?>" target="_blank"><?php echo display('sms_configuration') ?></a>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-customer" class="btn btn-success btn-large" name="add-customer" value="<?php echo display('save_changes') ?>" />
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



