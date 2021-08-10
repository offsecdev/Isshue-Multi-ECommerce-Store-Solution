<!--Update email setting start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('payment_gateway_setting') ?></h1>
            <small><?php echo display('payment_gateway_setting') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('software_settings') ?></a></li>
                <li class="active"><?php echo display('payment_gateway_setting') ?></li>
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
        <!--Payment setting -->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 m-b-20">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <?php
                    if ($setting_detail) {
                        $i=1;
                        foreach ($setting_detail as $setting) {
                    ?>
                    <li class="<?php if($i == 1){echo "active";}?>"><a href="#tab<?php echo $i?>" data-toggle="tab" aria-expanded="true"><?php echo html_escape($setting['agent'])?></a></li>
                    <?php
                        $i++;
                        }
                    }
                    ?>
                </ul>
                <!-- Tab panels -->
                <div class="tab-content">
                <?php
                if ($setting_detail) {
                    $i=1;
                    foreach ($setting_detail as $setting) {
                ?>
                    <div class="tab-pane fade <?php if($i == 1){echo "active in";}?>" id="tab<?php echo $i?>">
                        <div class="panel-body">
                            
                                    
                                
                            <?php
                            if ($setting['used_id'] == 3){
                            ?>
                            <div class="row">
                                <div class="col-md-9">

                            <?php echo form_open_multipart('dashboard/Csoft_setting/update_payment_gateway_setting/'.$setting['used_id'], array( 'class' => 'form-vertical','id' => 'validate')); ?>

                                <div class="form-group row">
                                    <label for="public_key" class="col-sm-3 col-form-label"><?php echo display('public_key')?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="public_key" id="public_key" type="text" value="<?php echo html_escape($setting['public_key'])?>" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="private_key" class="col-sm-3 col-form-label"><?php echo display('private_key')?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="private_key" id="private_key" type="text" value="<?php echo html_escape($setting['private_key'])?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="status" class="col-sm-3 col-form-label"><?php echo display('status')?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-9">
                                        <select class="form-control width_100p" name="status" id="status" required="" aria-hidden="true" aria-required="true" required>
                                            <option value=""></option>
                                            <option value="1" <?php if($setting['status']==1){echo "selected";}?>><?php echo display('active')?></option>
                                            <option value="2" <?php if($setting['status']==2){echo "selected";}?>><?php echo display('inactive')?></option>
                                          </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="submit" class="col-sm-5 col-form-label"></label>
                                    <div class="col-sm-9 col-sm-offset-3">
                                       <input type="submit" class="btn btn-success btn-large" value="<?php echo display('save_changes')?>">
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                                </div>
                                <div class="col-md-3">
                                    <a class="btn btn-success" href="https://gourl.io/view/registration" target="_blank"><?php echo display('create_account')?></a>
                                </div>
                            </div>

                            <?php 
                            }else  if ($setting['used_id'] == 4) {
                            ?>
                            <div class="row">
                                <div class="col-md-9">

                            <?php echo form_open_multipart('dashboard/Csoft_setting/update_payment_gateway_setting/'.$setting['used_id'], array( 'class' => 'form-vertical','id' => 'validate')); ?>

                                <div class="form-group row">
                                    <label for="shop_id" class="col-sm-3 col-form-label"><?php echo display('shop_id')?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="shop_id" id="shop_id" type="text" value="<?php echo html_escape($setting['shop_id'])?>" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="secret_key" class="col-sm-3 col-form-label"><?php echo display('secret_key')?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="secret_key" id="secret_key" type="text" value="<?php echo html_escape($setting['secret_key'])?>" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="status" class="col-sm-3 col-form-label"><?php echo display('status')?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-9">
                                        <select class="form-control width_100p" name="status" id="status" required="" aria-hidden="true" aria-required="true" >
                                            <option value=""></option>
                                            <option value="1" <?php if($setting['status']==1){echo "selected";}?>><?php echo display('active')?></option>
                                            <option value="2" <?php if($setting['status']==2){echo "selected";}?>><?php echo display('inactive')?></option>
                                          </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="submit" class="col-sm-5 col-form-label"></label>
                                    <div class="col-sm-9 col-sm-offset-3">
                                       <input type="submit" class="btn btn-success btn-large" value="<?php echo display('save_changes')?>">
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                                </div>
                                <div class="col-md-3">
                                    <a class="btn btn-success" href="https://payeer.com/en/account/?register=yes" target="_blank"><?php echo display('create_account')?></a>
                                </div>
                            </div>

                            <?php
                            } else if ($setting['used_id'] == 5){
                            ?>
                            <div class="row">
                                <div class="col-md-9">
                            <?php echo form_open_multipart('dashboard/Csoft_setting/update_payment_gateway_setting/'.html_escape($setting['used_id']), array( 'class' => 'form-vertical','id' => 'validate')); ?>
                                <div class="form-group row">
                                    <label for="paypal_email" class="col-sm-3 col-form-label"><?php echo display('paypal_email')?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="paypal_email" id="paypal_email" type="email" value="<?php echo html_escape($setting['paypal_email'])?>" required>
                                    </div>
                                </div>              

                                <div class="form-group row">
                                    <label for="client_id" class="col-sm-3 col-form-label"><?php echo display('client_id')?></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="client_id" id="client_id" type="text" value="<?php echo html_escape($setting['paypal_client_id'])?>" placeholder="<?php echo display('client_id')?>">
                                        <small class="text-muted"><?php echo display('optional')?></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="currency" class="col-sm-3 col-form-label"><?php echo display('currency')?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-9">
                                        <select class="form-control width_100p" name="currency" id="currency" required="" aria-hidden="true" aria-required="true">
                                            <option value=""></option>
                                            <?php
                                            if ($currency_list) {
                                                foreach ($currency_list as $k => $currency) {
                                            ?>
                                            <option value="<?php echo $k?>" <?php if($setting['currency']== $k){echo "selected";}?>><?php echo html_escape($currency)?></option>
                                            <?php } }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="is_live" class="col-sm-3 col-form-label"><?php echo display('payment')?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-9">
                                        <select class="form-control width_100pi" name="is_live" id="is_live" required="" aria-hidden="true" aria-required="true">
                                            <option value=""></option>
                                            <option value="1" <?php if($setting['is_live']=='1'){echo "selected";}?>>Live</option>
                                            <option value="0" <?php if($setting['is_live']=='0'){echo "selected";}?>>Sandbox</option>
                                          </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="status" class="col-sm-3 col-form-label"><?php echo display('status')?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-9">
                                        <select class="form-control width_100p" name="status" id="status" required="" aria-hidden="true" aria-required="true">
                                            <option value=""></option>
                                            <option value="1" <?php if($setting['status']==1){echo "selected";}?>><?php echo display('active')?></option>
                                            <option value="2" <?php if($setting['status']==2){echo "selected";}?>><?php echo display('inactive')?></option>
                                          </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="submit" class="col-sm-5 col-form-label"></label>
                                    <div class="col-sm-9 col-sm-offset-3">
                                       <input type="submit" class="btn btn-success btn-large" value="<?php echo display('save_changes')?>">
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                                </div>
                                <div class="col-md-3">
                                    <a class="btn btn-success" href="https://www.paypal.com" target="_blank"><?php echo display('create_account')?></a>
                                </div>
                            </div>

                            <?php
                            } else if ($setting['used_id'] == 6){ ?>
                            <div class="row">
                                <div class="col-md-9">
                            <?php echo form_open_multipart('dashboard/Csoft_setting/update_payment_gateway_setting/'.$setting['used_id'], array( 'class' => 'form-vertical','id' => 'validate')); ?>

                                <div class="form-group row">
                                    <label for="sslcommerz_email" class="col-sm-3 col-form-label"><?php echo display('sslcommerz_email')?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="sslcommerz_email" id="sslcommerz_email" type="email" value="<?php echo html_escape($setting['paypal_email'])?>" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="store_id" class="col-sm-3 col-form-label"><?php echo display('store_id')?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="store_id" id="store_id" type="text" value="<?php echo html_escape($setting['shop_id'])?>" placeholder="<?php echo display('store_id')?>" required>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="secret_key" class="col-sm-3 col-form-label"><?php echo display('secret_key')?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="secret_key" id="secret_key" type="text" value="<?php echo html_escape($setting['secret_key'])?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="currency" class="col-sm-3 col-form-label"><?php echo display('currency')?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-9">
                                        <select class="form-control width_100p" name="currency" id="currency" required="" aria-hidden="true" aria-required="true">
                                            <option value=""></option>
                                            <?php
                                            if ($currency_list) {
                                                foreach ($currency_list as $k => $currency) {
                                                    ?>
                                                    <option value="<?php echo $k?>" <?php if($setting['currency']== $k){echo "selected";}?>><?php echo html_escape($currency)?></option>
                                                <?php } }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="is_live" class="col-sm-3 col-form-label"><?php echo display('payment')?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-9">
                                        <select class="form-control width_100pi" name="is_live" id="is_live" required="" aria-hidden="true" aria-required="true">
                                            <option value=""></option>
                                            <option value="1" <?php if($setting['is_live']==1){echo "selected";}?>>Live</option>
                                            <option value="0" <?php if($setting['is_live']==0){echo "selected";}?>>Sandbox</option>
                                          </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="status" class="col-sm-3 col-form-label"><?php echo display('status')?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-9">
                                        <select class="form-control width_100p" name="status" id="status" required="" aria-hidden="true" aria-required="true" >
                                            <option value=""></option>
                                            <option value="1" <?php if($setting['status']==1){echo "selected";}?>><?php echo display('active')?></option>
                                            <option value="2" <?php if($setting['status']==2){echo "selected";}?>><?php echo display('inactive')?></option>
                                          </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="submit" class="col-sm-5 col-form-label"></label>
                                    <div class="col-sm-9 col-sm-offset-3">
                                       <input type="submit" class="btn btn-success btn-large" value="<?php echo display('save_changes')?>">
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                                </div>
                                <div class="col-md-3">
                                    <a class="btn btn-success" href="https://signup.sslcommerz.com/register" target="_blank"><?php echo display('create_account')?></a>
                                </div>
                            </div>

                            <?php } else if ($setting['used_id'] > 6){ ?>


                            <?php 

                            $paysett_html = APPPATH.'modules/'.$setting['module_id'].'/views/back/payment_from.php';
                                if(file_exists($paysett_html)){
                                    include($paysett_html);                                    
                                }else{
                            ?>

                            <div class="row">
                                <div class="col-md-9">
                            <?php echo form_open_multipart('dashboard/Csoft_setting/update_payment_gateway_setting/'.$setting['used_id'], array( 'class' => 'form-vertical','id' => 'validate')); ?>

                                <div class="form-group row">
                                    <label for="public_key" class="col-sm-3 col-form-label"><?php echo display('public_key')?></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="public_key" id="public_key" type="text" value="<?php echo html_escape($setting['public_key'])?>" placeholder="<?php echo display('public_key')?>">

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="private_key" class="col-sm-3 col-form-label"><?php echo display('private_key')?></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="private_key" id="private_key" type="text" value="<?php echo html_escape($setting['private_key'])?>"  placeholder="<?php echo display('private_key')?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="business_email" class="col-sm-3 col-form-label"><?php echo display('email')?> </label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="business_email" id="business_email" type="email" value="<?php echo html_escape($setting['paypal_email'])?>"  placeholder="<?php echo display('email')?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="currency" class="col-sm-3 col-form-label"><?php echo display('currency')?></label>
                                    <div class="col-sm-9">
                                        <select class="form-control width_100p" name="currency" id="currency" aria-hidden="true" aria-required="true">
                                            <option value=""></option>
                                            <?php
                                            if ($currency_list) {
                                                foreach ($currency_list as $k => $currency) {
                                                    ?>
                                                    <option value="<?php echo $k?>" <?php if($setting['currency']== $k){echo "selected";}?>><?php echo html_escape($currency)?></option>
                                                <?php } }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="is_live" class="col-sm-3 col-form-label"><?php echo display('payment')?></label>
                                    <div class="col-sm-9">
                                        <select class="form-control width_100pi" name="is_live" id="is_live" required="" aria-hidden="true" aria-required="true">
                                            <option value=""></option>
                                            <option value="1" <?php if($setting['is_live']==1){echo "selected";}?>>Live</option>
                                            <option value="0" <?php if($setting['is_live']==0){echo "selected";}?>>Sandbox</option>
                                          </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="status" class="col-sm-3 col-form-label"><?php echo display('status')?></label>
                                    <div class="col-sm-9">
                                        <select class="form-control width_100p" name="status" id="status" required="" aria-hidden="true" aria-required="true" >
                                            <option value=""></option>
                                            <option value="1" <?php if($setting['status']==1){echo "selected";}?>><?php echo display('active')?></option>
                                            <option value="2" <?php if($setting['status']==2){echo "selected";}?>><?php echo display('inactive')?></option>
                                          </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="submit" class="col-sm-5 col-form-label"></label>
                                    <div class="col-sm-9 col-sm-offset-3">
                                       <input type="submit" class="btn btn-success btn-large" value="<?php echo display('save_changes')?>">
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                                </div>
                                <div class="col-md-3">
                                    <a class="btn btn-success" href="<?php echo base_url($setting['module_id'].'/'.$setting['module_id'].'back/'.'index') ?>" target="_blank"><?php echo display('payment_report')?></a>
                                </div>
                            </div>
                            <?php } } ?>
                        </div>
                    </div>
                <?php
                    $i++;
                    }
                }
                ?>
                </div>
            </div>
        </div>
    </section>
</div>
<!--Update email setting end -->