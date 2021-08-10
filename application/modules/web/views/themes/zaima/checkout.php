<?php include_once(dirname(__FILE__).'/functions/functions.php'); ?>
<div class="container pb-5">
    <!--Breadcrumb-->
    <nav aria-label="breadcrumb" class="my-4">
        <ol class="breadcrumb d-inline-flex mb-0">
            <li class="breadcrumb-item align-items-center"><a href="<?php echo base_url() ?>" class="d-flex align-items-center"><i data-feather="home" class="mr-2"></i><?php echo display('home') ?></a></li>
            <li class="breadcrumb-item align-items-center active"><a href="<?php echo base_url('checkout') ?>" class="d-flex align-items-center"><?php echo display('checkout') ?></a></li>
        </ol>
    </nav>

    <?php if (!empty($this->cart->contents())) { ?>
    <?php echo form_open(base_url() . 'submit_checkout', ['id' => 'validateForm', 'class' => 'checkout-conent']) ?>
    <div class="row">
        <div class="col-md-8 mainContent">
            <h3 class="text-center"><?php echo display('checkout') ?></h3 class="text-center">

            <?php 
            $message = $this->session->userdata('message');
            if (!empty($message)) {
            ?>
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $message ?>                    
            </div>
            <?php 
            $this->session->unset_userdata('message');
            }
            $error_message = $this->session->userdata('error_message');
            $validation_errors = validation_errors();
            if (!empty($error_message) || !empty($validation_errors)) {
            ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $error_message ?>                    
                <?php echo $validation_errors ?>                    
            </div>
            <?php 
            $this->session->unset_userdata('error_message');
             } ?>

            <div class="row">
                <div class="col-sm-12">
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title">
                                    <i class="fa fa-question-circle"></i> <?php echo display('returning_customer') ?><a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"> <?php echo display('click_here_to_login') ?> </a>
                                </h5>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <p> <?php echo display('if_you_have_shopped_with_us') ?></p>
                                    <div class="row">
                                        <?php
                                        if ($this->user_auth->is_logged() != 1) {
                                            ?>
                                            
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label" for="login_email"><?php echo display('email') ?><abbr class="required" title="required">*</abbr></label>
                                                    <input type="text" id="login_email" class="form-control" name="user_email">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label" for="login_password"><?php echo
                                                        display('password'); ?>
                                                        <abbr class="required" title="required">*</abbr></label>
                                                    <input type="password" id="login_password" class="form-control" name="login_password" value="<?php echo get_cookie("password"); ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="checkbox checkbox-success">
                                                    <input id="remember_me" type="checkbox" name="remember_me" value="1">
                                                    <label for="remember_me"><?php echo  display('remember_me') ?></label>
                                                </div>
                                                <a href="#" class="btn btn-success color4 color46 customer_login"><?php echo display('login') ?></a>
                                                <a href="<?php echo base_url() . 'forget_password_form'; ?>"
                                                   class="lost-pass"><?php echo display('i_have_forgotten_my_password') ?></a>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 social_login">
                                                <?php if((check_module_status('facebooklogin') == 1)){
                                                    ?>&nbsp; OR &nbsp;
                                                    <a class="btn btn-facebook btn-sm  search text-white" href="<?php echo base_url('facebooklogin/facebooklogin/index/1')?>"><i class="fab fa-facebook-square"></i> <?php echo display('facebook_login')?></a>
                                                <?php }?>  
                                                <?php if((check_module_status('linkedinlogin') == 1)){ ?>
                                                    &nbsp; OR &nbsp;
                                                    <a class="btn btn-linkedin btn-sm  search text-white" href="<?php echo base_url('linkedinlogin/linkedinlogin/login/1')?>"><i class="fab fa-linkedin"></i> <?php echo display('linkedin_login')?></a>
                                                <?php }?>
                                                <?php if(check_module_status('googlelogin') == 1){ 
                                                    ?>&nbsp; OR &nbsp;
                                                    <a class="btn btn-google btn-sm  search text-white" href="<?php echo base_url('googlelogin/googlelogin/login')?>"><i class="fab fa-google"></i> <?php echo display('google_login')?></a>
                                                <?php }?>
                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="col-sm-12">
                                                <a href="<?php echo base_url('logout') ?>"
                                                   class="btn btn-success color3 color36"><?php echo display('logout') ?></a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-sm-12">
                    <h4 class="mb-3 py-3 border-bottom"><?php echo display('billing_address') ?></h4>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="font-weight-500" for="first_name"><?php echo display('first_name') ?><span class="text-danger">*</span></label>
                        <input type="text"  class="form-control"  name="first_name" id="first_name" placeholder="<?php echo display('first_name') ?>" value="<?php echo set_value('first_name', $this->session->userdata('first_name')) ?>" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="font-weight-500" for="last_name"><?php echo display('last_name') ?></label>
                        <input type="text"  class="form-control" name="last_name" id="last_name" placeholder="<?php echo display('last_name') ?>"  value="<?php echo set_value('last_name', $this->session->userdata('last_name')) ?>">
                        <input type="hidden" id="company" name="company" value="">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="font-weight-500" for="customer_email"><?php echo display('customer_email') ?></label>
                        <input type="text" name="customer_email" id="customer_email" placeholder="<?php echo display('customer_email') ?>" class="form-control" value="<?php echo set_value('customer_email', $this->session->userdata('customer_email')) ?>">
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="font-weight-500" for="customer_mobile"><?php echo display('customer_mobile') ?><span class="text-danger">*</span></label>
                        <input type="number" id="customer_mobile" class="form-control" name="customer_mobile" placeholder="<?php echo display('customer_mobile') ?>" required value="<?php echo set_value('customer_mobile', $this->session->userdata('customer_mobile')) ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo display('add_country_code') ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="font-weight-500" for="country"><?php echo display('country') ?><span class="text-danger">*</span></label>
                        <select class="form-control custom-select" name="country" id="country" required>
                            <option value=""> --- <?php echo display('select_country') ?> ---</option>
                            <?php
                                if ($selected_country_info) {
                                    $country_selected = $this->session->userdata('country');
                                    if(empty($country_selected)) {
                                        $country_selected = $Soft_settings[0]['country_id'];
                                    }

                                    foreach ($selected_country_info as $country) { ?>
                                        <option value="<?php echo $country->id ?>" <?php if ($country_selected == $country->id) {
                                            echo "selected";
                                        } ?>><?php echo html_escape($country->name) ?> </option>
                                        <?php
                                    }
                                }
                                ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="font-weight-500" for="customer_address_1"><?php echo display('customer_address_1') ?><span class="text-danger">*</span></label>
                         <input type="text" placeholder="<?php echo display('customer_address_1') ?>" name="customer_address_1" id="customer_address_1" class="form-control" required value="<?php echo set_value('customer_address_1', $this->session->userdata('customer_address_1')) ?>">
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="font-weight-500" for="state"><?php echo display('state') ?><span class="text-danger">*</span></label>
                        <select name="state" id="state" class="form-control" required>
                            <option value=""> --- <?php echo display('select_state') ?> ---</option>
                            <?php
                            if ($state_list) {
                                foreach ($state_list as $state) {
                                    ?>
                                    <option value="<?php echo remove_space($state->name); ?>" <?php if (remove_space($this->session->userdata('state')) == remove_space($state->name)) {
                                        echo "selected";
                                    } ?>><?php echo html_escape($state->name) ?> </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="font-weight-500" for="customer_address_2"><?php echo display('customer_address_2') ?></label>
                        <input type="text" name="customer_address_2" id="customer_address_2" placeholder="<?php echo display('customer_address_2') ?>" class="form-control" value="<?php echo set_value('customer_address_2', $this->session->userdata('customer_address_2')) ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="font-weight-500" for="city"><?php echo display('city') ?><span class="text-danger">*</span></label>
                        <input type="text" name="city" id="city" placeholder="<?php echo display('city') ?>" class="form-control" required value="<?php echo set_value('city', $this->session->userdata('city')) ?>">
                    </div>
                </div>
                 <div class="col-sm-6">
                    <div class="form-group">
                        <label class="font-weight-500" for="zip"><?php echo display('zip') ?></label>
                        <input type="text" name="zip" id="zip" placeholder="<?php echo display('zip') ?>" class="form-control" value="<?php echo set_value('zip', $this->session->userdata('zip')) ?>">
                    </div>
                </div>
            </div>
            <?php
            if ($this->user_auth->is_logged() != 1) {
                ?>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="creat_ac" name="creat_ac" value="1">

                    <label class="custom-control-label" for="creat_ac" data-toggle="collapse" data-target="#account-pass"><?php echo display('create_account') ?></label>
                </div>
                <div class="collapse" id="account-pass">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="font-weight-500" for="ac_pass"><?php echo display('password') ?><span class="text-danger">*</span></label>
                                <input type="text" name="ac_pass" id="ac_pass" placeholder="<?php echo display('password') ?>" class="form-control" required value="<?php echo set_value('ac_pass', $this->session->userdata('ac_pass')) ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>

            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="privacy_policy" name="privacy_policy" value="1" required="" <?php if ($this->session->userdata('privacy_policy') == 1) {
                        echo "checked";
                    } ?>>
                <label class="custom-control-label" for="privacy_policy"><?php echo display('privacy_policy') ?><span class="text-danger">*</span>  <a href="<?php echo base_url('privacy_policy') ?>" target="_blank"><i class="fa fa-external-link"></i></a></label>
            </div>

            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="diff_ship_adrs" name="diff_ship_adrs" value="1" <?php if ($this->session->userdata('diff_ship_adrs') == 1) { echo "checked"; } ?>>
                <label class="custom-control-label" for="diff_ship_adrs"  data-toggle="collapse" data-target="#billind-different-address"><?php echo display('ship_to_a_different_address') ?></label>
            </div>

            <div class="collapse <?php if ($this->session->userdata('diff_ship_adrs') == 1) {
                    echo "in show";
                } ?>" id="billind-different-address">
                    <div class="row">
                        <div class="col-sm-6">

                            <div class="form-group">
                                <label class="font-weight-500" for="ship_first_name"><?php echo display('first_name') ?> <span class="text-danger">*</span></label>
                                <input type="text" name="ship_first_name" id="ship_first_name" placeholder="<?php echo display('first_name') ?>" class="form-control" required value="<?php echo set_value('ship_first_name', $this->session->userdata('ship_first_name')) ?>">
                            </div>

                            <div class="form-group">
                                <label class="font-weight-500" for="ship_customer_email"><?php echo display('customer_email') ?></label>
                                <input type="text" id="ship_customer_email" name="ship_customer_email" class="form-control" placeholder="<?php echo display('customer_email') ?>" value="<?php echo $this->session->userdata('ship_email') ?>">
                            </div>
                            
                            
                            <div class="form-group">
                                <label for="ship_country" class="control-label"><?php echo display('country') ?><span class="text-danger">*</span> </label>
                                <select name="ship_country" id="ship_country" class="form-control">
                                    <option value=""> --- <?php echo display('select_country') ?> ---</option>
                                    <?php
                                    if ($selected_country_info) {
                                        $country_selected = $this->session->userdata('ship_country');
                                        if(empty($country_selected)) {
                                            $country_selected = $Soft_settings[0]['country_id'];
                                        }

                                        foreach ($selected_country_info as $country) {
                                            ?>
                                            <option value="<?php echo html_escape($country->id) ?>" <?php if ($country_selected == $country->id) {
                                                echo "selected";
                                            } ?>><?php echo
                                                html_escape($country->name) ?> </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="ship_state"><?php echo display('state') ?> <span class="text-danger">*</span></label>
                                <select name="ship_state" id="ship_state" class="form-control">
                                    <option value=""> --- <?php echo display('state') ?> ---</option>
                                    <?php
                                    if ($ship_state_list) {
                                        foreach ($ship_state_list as $ship_state) {
                                            ?>
                                            <option value="<?php echo html_escape($ship_state->name) ?>" <?php if ($this->session->userdata('ship_state') == $ship_state->name) {
                                                echo "selected";
                                            } ?>><?php echo html_escape($ship_state->name) ?> </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ship_city" class="font-weight-500"><?php echo display('city') ?> <span class="text-danger">*</span></label>
                                <input type="text" name="ship_city" id="ship_city" class="form-control" placeholder="<?php echo display('city') ?>" required value="<?php echo $this->session->userdata('ship_city') ?>">
                                <input type="hidden" name="ship_company" id="ship_company" value="">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="font-weight-500" for="ship_last_name"><?php echo display('last_name') ?></label>
                                <input type="text" name="ship_last_name" id="ship_last_name" placeholder="<?php echo display('last_name') ?>" class="form-control" value="<?php echo set_value('ship_last_name', $this->session->userdata('ship_last_name')) ?>">
                            </div>
                            <div class="form-group">
                                <label for="ship_mobile" class="font-weight-500"><?php echo display('mobile') ?> <span class="text-danger">*</span></label>
                                <input type="text" name="ship_mobile" id="ship_mobile" placeholder="<?php echo display('add_country_code') ?>" class="form-control" required value="<?php echo $this->session->userdata('ship_mobile') ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo display('add_country_code') ?>">
                            </div>

                            <div class="form-group">
                                <label for="ship_address_1" class="font-weight-500"><?php echo display('customer_address_1') ?> <span class="text-danger">*</span></label>
                                <input type="text" name="ship_address_1" id="ship_address_1" placeholder="<?php echo display('customer_address_1') ?>" class="form-control" required value="<?php echo $this->session->userdata('ship_address_1') ?>">
                            </div>
                            <div class="form-group">
                                <label for="ship_address_2" class="font-weight-500"><?php echo display('customer_address_2') ?> :</label>
                                <input type="text" name="ship_address_2" id="ship_address_2"  placeholder="<?php echo display('customer_address_2') ?>" class="form-control" value="<?php echo $this->session->userdata('ship_address_2') ?>">
                            </div>

                            <div class="form-group">
                                <label for="ship_zip" class="font-weight-500"><?php echo display('zip') ?> :</label>
                                <input type="text" name="ship_zip" id="ship_zip" placeholder="<?php echo display('zip') ?>" class="form-control" value="<?php echo $this->session->userdata('ship_zip') ?>">
                            </div>
                        </div>
                    </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group checkout_comment">
                        <label class="font-weight-500" for="ordre_notes"><?php echo display('add_coment_about_your_order') ?></label>
                        <textarea class="form-control" id="ordre_notes" rows="5" placeholder="<?php echo display('notes_about_your_order') ?>"><?php echo $this->session->userdata('delivery_details') ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="text-danger" id="coupon_error_text_color"><span id="coupon_error"></span></h3>
                    <h5>
                        <i class="fa fa-question-circle"></i><?php echo display('use_coupon_code') ?> <a href="javascript:void(0)" data-toggle="collapse" data-target="#collapseThree"><?php echo display('enter_your_coupon_here') ?></a>

                    </h5>
                    <div id="collapseThree" class="collapse">
                        <div class=" coupon">
                              <div class="form-inline">
                                <input type="text" class="form-control col-md-4" id="coupon_code" name="coupon_code" placeholder="<?php echo display('enter_your_coupon_here') ?>">
                                <a href="#" class="btn col-md-3 color4 color46 text-white"
                                   id="coupon_value"><?php echo display('apply_coupon') ?></a>

                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
        <div class="col-md-4 rightSidebar">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <h2 class="fs-19 pb-3 mb-0"><?php echo display('items_in_your_cart') ?></h2>
                <span class="badge badge-pill badge-soft-success"><?php echo $this->cart->total_items() ?> <?php echo display('items') ?></span>
            </div>
            <div class="card shadow-none" id="card-summary">
                <div class="card-body">
                    <?php 
                        $i = 1;
                        $cgst = 0;
                        $sgst = 0;
                        $igst = 0;
                        $discount = 0;
                        $coupon_amnt = 0; 
                    
                    if ($this->cart->contents()) {
                        $counter = 1;
                        foreach ($this->cart->contents() as $items){

                            form_hidden($i . '[rowid]', $items['rowid']);

                            if (!empty($items['options']['cgst'])) {
                                $cgst = $cgst + ($items['options']['cgst'] * $items['qty']);
                            }

                            if (!empty($items['options']['sgst'])) {
                                $sgst = $sgst + ($items['options']['sgst'] * $items['qty']);
                            }

                            if (!empty($items['options']['igst'])) {
                                $igst = $igst + ($items['options']['igst'] * $items['qty']);
                            }

                            //Calculation for discount
                            if (!empty($items['discount'])) {
                                $discount = $discount + ($items['discount'] * $items['qty']) + $this->session->userdata('coupon_amnt');
                                $this->session->set_userdata('total_discount', $discount);
                            }

                     ?>
                    <div class="row <?php echo (($counter > 1)?'mt-3 delimiter-top':'') ?>">
                        <div class="col-9">
                            <div class="media align-items-center">
                                <img alt="Image placeholder" class="mr-2" src="<?php echo base_url().$items['options']['image'] ?>" width="64">
                                <div class="media-body">
                                    <h5 class="fs-16 mb-1 item_short_name"><?php echo html_escape($items['name']); ?></h5>
                                    <div class="text-black-50 fs-14"><?php echo $items['qty'] ?> x <?php echo(($position1 == 0) ? $currency1 . ' ' . $this->cart->format_number($items['price']*$target_con_rate) : $this->cart->format_number($items['price']*$target_con_rate) . ' ' . $currency1) ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 text-dark text-right">
                            <?php echo(($position1 == 0) ? $currency1 . $this->cart->format_number($items['subtotal']*$target_con_rate) : $this->cart->format_number($items['subtotal']*$target_con_rate) . $currency1) ?>
                        </div>
                    </div>
                    <?php $counter++; } } ?>

                    

                    <ul class="list-unstyled font-weight-500 pb-2 border-top mt-3 pt-3">
                        <li class="d-flex justify-content-between align-items-center" id="shipCostRow"><span class="mr-2 cart_ship_name"><span id="set_cart_ship_name"></span></span><span class="text-right" id="set_ship_cost"></span></li>

                        <?php
                        $total_tax = $cgst + $sgst + $igst;
                        if ($total_tax > 0) {
                            ?>
                            <li class="d-flex justify-content-between align-items-center"><span class="mr-2"><?php echo display('total_tax') ?>:</span><span class="text-right">
                                <?php 
                                @$this->_cart_contents['total_tax'] = $total_tax;
                                echo (($position1 == 0) ? $currency1 . " " . number_format($total_tax, 2, '.', ',') : number_format($total_tax, 2, '.', ',') . " " . $currency1)
                                 ?>

                            </span></li>
                        <?php
                        }
                        ?>
                        <li  id="couponAmountRow" class="d-flex justify-content-between align-items-center"><span class="coupon_discount mr-2"></span>
                            <span class="text-right" id="set_coupon_price">
                            </span></li>
                        <?php $cart_total = $this->cart->total() + $total_tax; ?>
                        <li class="d-flex justify-content-between align-items-center"><span class="mr-2"><?php echo display('sub_total') ?>:</span><span class="text-right" id="total_amount"><?php echo(($position1 == 0) ? $currency1 . " " . number_format($cart_total*$target_con_rate, 2, '.', ',') : number_format($cart_total*$target_con_rate, 2, '.', ',') . " " . $currency1) ?></span>
                            <input type="hidden" name="order_total_amount" id="order_total_amount">
                            <input type="hidden" name="cart_total_amount" id="cart_total_amount" value="<?php echo html_escape($cart_total); ?>">
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card shadow-none mb-0">
                <div class="card-body">
                    <h3 class="fs-18 mb-1"><?php echo display('shipping_method') ?></h3>
                    <p class="fs-14"><?php echo display('kindly_select_the_preferred_shipping_method_to_use_on_this_order') ?></p>

                    <?php
                    if ($select_shipping_method) {
                        foreach ($select_shipping_method as $shipping_method) {
                            ?>
                            <p><strong><?php echo html_escape($shipping_method->method_name) ?></strong></p>
                            <div class="radio">
                                <label>
                                    <input type="radio" class="shipping_cost" name="shipping_cost"
                                           id="<?php echo html_escape($shipping_method->method_id) ?>"
                                           value="<?php echo html_escape($shipping_method->charge_amount) ?>"
                                           alt="<?php echo display('service_charge') ?>" <?php if ($this->session->userdata('method_id') == $shipping_method->method_id) {
                                        echo "checked";
                                    } ?>>

                                    <?php echo html_escape($shipping_method->details) ?> -

                                    <?php
                                    if ($target_con_rate > 1) {
                                        $price = $shipping_method->charge_amount * $target_con_rate;
                                        echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                    }

                                    if ($target_con_rate <= 1) {
                                        $price = $shipping_method->charge_amount * $target_con_rate;
                                        echo(($position1 == 0) ? $currency1 . " " . number_format($price, 2, '.', ',') : number_format($price, 2, '.', ',') . " " . $currency1);
                                    }
                                    ?>
                                </label>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="card shadow-none mb-0">
                <div class="card-body">
                    <h3 class="fs-18 mb-1"><?php echo display('payment_method') ?></h3>

                    <div class="payment-block" id="payment">
                        <!-- Cash on delivery payment method -->
                        <div class="radio">
                            <label>
                                <input type="radio" name="payment_method"
                                       value="1" <?php if ($this->session->userdata('payment_method') == 1) {
                                    echo "checked ='checked'";
                                } ?> checked> &nbsp;
                                <?php echo display('cash_on_delivery') ?>
                            </label>
                        </div>

                        <?php if(!empty($payment_gateways)){
                            foreach ($payment_gateways as $paygateway) { ?>
                            <div class="form-group paymethod_item">
                               <div class="radio">
                                    <label>
                                        <input type="radio" name="payment_method" value="<?php echo $paygateway['used_id']; ?>" <?php echo  (($this->session->userdata('payment_method') == $paygateway['used_id'])?"checked = 'checked'":""); ?>> &nbsp;
                                    <?php  if(!empty($paygateway['image'])) { ?>

                                        <img src="<?php echo base_url($paygateway['image']) ?>" alt="<?php echo ucfirst($paygateway['agent']); ?>" height="32">

                                    <?php } else {  ?>
                                        <strong><?php echo ucfirst($paygateway['agent']); ?></strong>
                                    <?php } ?>
                                    </label>
                                </div>
                            </div>
                        <?php  } } ?>

                    </div>
                    <button type="submit" class="btn btn-success btn-block color4 color46" id="payment_method_sumbmit"><?php echo display('confirm_order') ?></button>
                </div>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
    <?php } else { ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-7">
                <!--Empty cart-->
                <div class="empty-cart text-center font-weight-200 py-5">
                    <svg viewBox="656 573 264 182" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <rect id="bg-line" stroke="none" fill-opacity="0.2" fill="#b5023b" fill-rule="evenodd" x="656" y="624" width="206" height="38" rx="19"></rect>
                    <rect id="bg-line" stroke="none" fill-opacity="0.2" fill="#b5023b" fill-rule="evenodd" x="692" y="665" width="192" height="29" rx="14.5"></rect>
                    <rect id="bg-line" stroke="none" fill-opacity="0.2" fill="#b5023b" fill-rule="evenodd" x="678" y="696" width="192" height="33" rx="16.5"></rect>
                    <g id="shopping-bag" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" transform="translate(721.000000, 630.000000)">
                    <polygon id="Fill-10" fill="#d8074a" points="4 29 120 29 120 0 4 0"></polygon>
                    <polygon id="Fill-14" fill="#b5023b" points="120 29 120 0 115.75 0 103 12.4285714 115.75 29"></polygon>
                    <polygon id="Fill-15" fill="#b5023b" points="4 29 4 0 8.25 0 21 12.4285714 8.25 29"></polygon>
                    <polygon id="Fill-33" fill="#d8074a" points="110 112 121.573723 109.059187 122 29 110 29"></polygon>
                    <polygon id="Fill-35" fill-opacity="0.5" fill="#FFFFFF" points="2 107.846154 10 112 10 31 2 31"></polygon>
                    <path d="M107.709596,112 L15.2883462,112 C11.2635,112 8,108.70905 8,104.648275 L8,29 L115,29 L115,104.648275 C115,108.70905 111.7365,112 107.709596,112" id="Fill-36" fill="#b5023b"></path>
                    <path d="M122,97.4615385 L122,104.230231 C122,108.521154 118.534483,112 114.257931,112 L9.74206897,112 C5.46551724,112 2,108.521154 2,104.230231 L2,58" id="Stroke-4916" stroke="#000000" stroke-width="1" stroke-linecap="round"></path>
                    <polyline id="Stroke-4917" stroke="#000000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" points="2 41.5 2 29 122 29 122 79"></polyline>
                    <path d="M4,50 C4,51.104 3.104,52 2,52 C0.896,52 0,51.104 0,50 C0,48.896 0.896,48 2,48 C3.104,48 4,48.896 4,50" id="Fill-4918" fill="#000000"></path>
                    <path d="M122,87 L122,89" id="Stroke-4919" stroke="#000000" stroke-width="1" stroke-linecap="round"></path>
                    <polygon id="Stroke-4922" stroke="#000000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" points="4 29 120 29 120 0 4 0"></polygon>
                    <path d="M87,46 L87,58.3333333 C87,71.9 75.75,83 62,83 L62,83 C48.25,83 37,71.9 37,58.3333333 L37,46" id="Stroke-4923" stroke="#000000" stroke-width="1" stroke-linecap="round"></path>
                    <path d="M31,45 C31,41.686 33.686,39 37,39 C40.314,39 43,41.686 43,45" id="Stroke-4924" stroke="#000000" stroke-width="1" stroke-linecap="round"></path>
                    <path d="M81,45 C81,41.686 83.686,39 87,39 C90.314,39 93,41.686 93,45" id="Stroke-4925" stroke="#000000" stroke-width="1" stroke-linecap="round"></path>
                    <path d="M8,0 L20,12" id="Stroke-4928" stroke="#000000" stroke-width="1" stroke-linecap="round"></path>
                    <path d="M20,12 L8,29" id="Stroke-4929" stroke="#000000" stroke-width="1" stroke-linecap="round"></path>
                    <path d="M20,12 L20,29" id="Stroke-4930" stroke="#000000" stroke-width="1" stroke-linecap="round"></path>
                    <path d="M115,0 L103,12" id="Stroke-4931" stroke="#000000" stroke-width="1" stroke-linecap="round"></path>
                    <path d="M103,12 L115,29" id="Stroke-4932" stroke="#000000" stroke-width="1" stroke-linecap="round"></path>
                    <path d="M103,12 L103,29" id="Stroke-4933" stroke="#000000" stroke-width="1" stroke-linecap="round"></path>
                    </g>
                    <g id="glow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" transform="translate(768.000000, 615.000000)">
                    <rect id="Rectangle-2" fill="#000000" x="14" y="0" width="2" height="9" rx="1"></rect>
                    <rect fill="#000000" transform="translate(7.601883, 6.142354) rotate(-12.000000) translate(-7.601883, -6.142354) " x="6.60188267" y="3.14235449" width="2" height="6" rx="1"></rect>
                    <rect fill="#000000" transform="translate(1.540235, 7.782080) rotate(-25.000000) translate(-1.540235, -7.782080) " x="0.54023518" y="6.28207994" width="2" height="3" rx="1"></rect>
                    <rect fill="#000000" transform="translate(29.540235, 7.782080) scale(-1, 1) rotate(-25.000000) translate(-29.540235, -7.782080) " x="28.5402352" y="6.28207994" width="2" height="3" rx="1"></rect>
                    <rect fill="#000000" transform="translate(22.601883, 6.142354) scale(-1, 1) rotate(-12.000000) translate(-22.601883, -6.142354) " x="21.6018827" y="3.14235449" width="2" height="6" rx="1"></rect>
                    </g>
                    <polygon id="plus" stroke="none" fill="#7DBFEB" fill-rule="evenodd" points="689.681239 597.614697 689.681239 596 690.771974 596 690.771974 597.614697 692.408077 597.614697 692.408077 598.691161 690.771974 598.691161 690.771974 600.350404 689.681239 600.350404 689.681239 598.691161 688 598.691161 688 597.614697"></polygon>
                    <polygon id="plus" stroke="none" fill="#EEE332" fill-rule="evenodd" points="913.288398 701.226961 913.288398 699 914.773039 699 914.773039 701.226961 917 701.226961 917 702.711602 914.773039 702.711602 914.773039 705 913.288398 705 913.288398 702.711602 911 702.711602 911 701.226961"></polygon>
                    <polygon id="plus" stroke="none" fill="#d8074a" fill-rule="evenodd" points="662.288398 736.226961 662.288398 734 663.773039 734 663.773039 736.226961 666 736.226961 666 737.711602 663.773039 737.711602 663.773039 740 662.288398 740 662.288398 737.711602 660 737.711602 660 736.226961"></polygon>
                    <circle id="oval" stroke="none" fill="#A5D6D3" fill-rule="evenodd" cx="699.5" cy="579.5" r="1.5"></circle>
                    <circle id="oval" stroke="none" fill="#CFC94E" fill-rule="evenodd" cx="712.5" cy="617.5" r="1.5"></circle>
                    <circle id="oval" stroke="none" fill="#8CC8C8" fill-rule="evenodd" cx="692.5" cy="738.5" r="1.5"></circle>
                    <circle id="oval" stroke="none" fill="#3EC08D" fill-rule="evenodd" cx="884.5" cy="657.5" r="1.5"></circle>
                    <circle id="oval" stroke="none" fill="#66739F" fill-rule="evenodd" cx="918.5" cy="681.5" r="1.5"></circle>
                    <circle id="oval" stroke="none" fill="#C48C47" fill-rule="evenodd" cx="903.5" cy="723.5" r="1.5"></circle>
                    <circle id="oval" stroke="none" fill="#A24C65" fill-rule="evenodd" cx="760.5" cy="587.5" r="1.5"></circle>
                    <circle id="oval" stroke="#66739F" stroke-width="1" fill="none" cx="745" cy="603" r="3"></circle>
                    <circle id="oval" stroke="#EFB549" stroke-width="1" fill="none" cx="716" cy="597" r="3"></circle>
                    <circle id="oval" stroke="#b5023b" stroke-width="1" fill="none" cx="681" cy="751" r="3"></circle>
                    <circle id="oval" stroke="#3CBC83" stroke-width="1" fill="none" cx="896" cy="680" r="3"></circle>
                    <polygon id="diamond" stroke="#C46F82" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" fill="none" points="886 705 889 708 886 711 883 708"></polygon>
                    <path d="M736,577 C737.65825,577 739,578.34175 739,580 C739,578.34175 740.34175,577 742,577 C740.34175,577 739,575.65825 739,574 C739,575.65825 737.65825,577 736,577 Z" id="bubble-rounded" stroke="#3CBC83" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" fill="none"></path>
                    </svg>
                    <h3 class="font-weight-200 mb-0 fs-32"><?php echo display('oops_your_cart_is_empty') ?></h3>
                    <p class="fs-18 text-black-50 mb-0 mt-4"><a href="<?php echo base_url() ?>"
                       class="base_button btn btn-success"><?php echo display('continue_shopping') ?></a></p>

                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

<input type="hidden" name="coupon_amnt" id="coupon_amnt" value="<?php echo @$this->session->userdata('coupon_amnt')?>">
<input type="hidden" name="coupon_message" id="coupon_message" value="<?php echo @$this->session->userdata('message')?>">
<input type="hidden" name="coupon_error_message" id="coupon_error_message" value="<?php echo @$this->session->userdata('error_message')?>">



    