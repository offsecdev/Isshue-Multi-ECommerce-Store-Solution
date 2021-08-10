<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- /.End of header -->
<?php
$CI =& get_instance();
$theme = $CI->Themes->get_theme();
?>
<link href="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/website/css/custom.css') ?>"
rel="stylesheet">


<div class="checkout">
<nav aria-label="breadcrumb bg-eceeef">
<div class="container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url() ?>"><?php echo display('home') ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo display('checkout') ?></li>
    </ol>
</div>
</nav>

<!-- /.End of page breadcrumbs -->
<?php if ($this->cart->contents()) { ?>
<?php echo form_open('submit_checkout', array('id' => 'validateForm', 'class' => 'checkout-conent'))?>
    <div class="container">
        <h1><?php echo display('checkout') ?></h1>
        <div class="row">
            <div class="col-sm-8">
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
            $validation_errors = validation_errors();
            if (!empty($error_message) || !empty($validation_errors)) {
            ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $validation_errors ?>                    
            </div>
            <?php 
            $this->session->unset_userdata('error_message');
             } ?>

                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-question-circle"></i> <?php echo display('returning_customer') ?>
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"> <?php echo display('click_here_to_login') ?> </a>
                            </h4>
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
                                                <label class="control-label"
                                                       for="login_email"><?php echo display('email') ?><abbr
                                                            class="required" title="required">*</abbr></label>
                                                <input type="text" id="login_email" class="form-control"
                                                       name="user_email">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label" for="login_password"><?php echo
                                                    display('password'); ?>
                                                    <abbr class="required" title="required">*</abbr></label>
                                                <input type="password" id="login_password" class="form-control"
                                                       name="login_password"
                                                       value="<?php echo get_cookie("password"); ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="checkbox checkbox-success">
                                                <input id="remember_me" type="checkbox" name="remember_me"
                                                       value="1">
                                                <label for="remember_me"><?php echo display('remember_me') ?></label>
                                            </div>
                                            <a href="#"
                                               class="btn btn-warning customer_login"><?php echo display('login') ?></a>
                                            <a href="#"
                                               class="lost-pass"><?php echo display('i_have_forgotten_my_password') ?></a>
                                        </div>
                                        <div class="col-sm-12 social_login">
                                            
                                        <?php if((check_module_status('facebooklogin') == 1)){
                                            ?>&nbsp; OR &nbsp;
                                            <a class="btn btn-facebook btn-sm  search text-white" href="<?php echo base_url('facebooklogin/facebooklogin/index/1')?>"><i class="fa fa-facebook mr-2"></i> <?php echo display('facebook_login')?></a>
                                        <?php }?>  
                                        <?php if((check_module_status('linkedinlogin') == 1)){ ?>
                                            &nbsp; OR &nbsp;
                                            <a class="btn btn-linkedin btn-sm  search text-white" href="<?php echo base_url('linkedinlogin/linkedinlogin/login/1')?>"><i class="fa fa-linkedin mr-2"></i> <?php echo display('linkedin_login')?></a>
                                        <?php }?>
                                        <?php if(check_module_status('googlelogin') == 1){ 
                                            ?>&nbsp; OR &nbsp;
                                            <a class="btn btn-google btn-sm  search text-white" href="<?php echo base_url('googlelogin/googlelogin/login')?>"><i class="fa fa-google mr-2"></i> <?php echo display('google_login')?></a>
                                        <?php }?>
                                            
                                        </div>
                                    <?php } else { ?>
                                        <div class="col-sm-12">
                                            <a href="<?php echo base_url('logout') ?>"
                                               class="btn btn-danger"><?php echo display('logout') ?></a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="billing-form">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="billing-title"><?php echo display('billing_address') ?></h3>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group has-error">
                                <label class="control-label" for="first_name"><?php echo display('first_name')
                                    ?><abbr class="required" title="required">*</abbr></label>
                                <input type="text" id="first_name" class="form-control" name="first_name"
                                       placeholder="<?php echo display('first_name') ?>" value="<?php echo $this->session->userdata('first_name') ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="last_name"><?php echo display('last_name')
                                    ?> <abbr class="required" title="required">*</abbr></label>
                                <input type="text" id="last_name" class="form-control" name="last_name"  placeholder="<?php echo display('last_name') ?>" 
                                       value="<?php echo $this->session->userdata('last_name') ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label"
                                       for="company"><?php echo display('company') ?></label>
                                <input type="text" id="company" class="form-control" name="company"
                                       placeholder="<?php echo display('company') ?>"
                                       value="<?php echo $this->session->userdata('company') ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="country"><?php echo display('country') ?><abbr
                                            class="required" title="required">*</abbr> : </label>
                                <select name="country" id="country"
                                        class="form-control form-input custom_select" required>
                                    <option value=""> --- <?php echo display('select_category') ?> ---</option>
                                    <?php
                                    if ($selected_country_info) {
                                        foreach ($selected_country_info as $country) {
                                            ?>
                                            <option value="<?php echo html_escape($country->id) ?>"><?php echo html_escape($country->name) ?> </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="email"><?php echo display('customer_email') ?>
                                    <abbr class="required" title="required">*</abbr></label>
                                <input type="text" id="customer_email" name="customer_email"
                                       class="form-control"
                                       placeholder="<?php echo display('customer_email') ?>"
                                       required
                                       value="<?php echo $this->session->userdata('customer_email') ?>">
                            </div>
                            <?php
                            if ($this->user_auth->is_logged() != 1) {
                                ?>

                                <div class="form-group">
                                    <label class="control-label" for="ac_pass"><?php echo display('password') ?>
                                        <abbr class="required" title="required">*</abbr></label>
                                    <input type="password" name="ac_pass" id="ac_pass"
                                           placeholder="<?php echo display('password') ?>" class="form-control"
                                           required
                                           value="<?php echo $this->session->userdata('ac_pass') ?>">
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="customer_address_1"
                                       class="control-label"><?php echo display('customer_address_1') ?><abbr
                                            class="required" title="required">*</abbr> : </label>
                                <input type="text" placeholder="<?php echo display('customer_address_1') ?>"
                                       name="customer_address_1" id="customer_address_1" class="form-control"
                                       required
                                       value="<?php echo $this->session->userdata('customer_address_1') ?>">
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="customer_address_2"
                                       class="control-label"><?php echo display('customer_address_2') ?>
                                    : </label>
                                <input type="text" name="customer_address_2" id="customer_address_2"
                                       placeholder="<?php echo display('customer_address_2') ?>"
                                       class="form-control"
                                       value="<?php echo $this->session->userdata('customer_address_2') ?>">
                            </div>
                            <div class="form-group">
                                <label for="city" class="control-label"><?php echo display('city') ?> <abbr
                                            class="required" title="required">*</abbr>:</label>
                                <input type="text" name="city" id="city"
                                       placeholder="<?php echo display('city') ?>"
                                       class="form-control" required
                                       value="<?php echo $this->session->userdata('city') ?>">
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="state"><?php echo display('state') ?> <abbr
                                            class="required" title="required">*</abbr>: </label>
                                <select name="state" id="state" class="form-control form-input custom_select"
                                        required>
                                    <option value=""> --- <?php echo display('select_state') ?> ---</option>
                                    <?php
                                    if ($state_list) {
                                        foreach ($state_list as $state) {
                                            ?>
                                            <option value="<?php echo html_escape($state->name) ?>" <?php if ($this->session->userdata('state') == $state->name) {
                                                echo "selected";
                                            } ?>><?php echo html_escape($state->name) ?> </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="zip" class="control-label"><?php echo display('zip') ?>
                                    :</label>
                                <input type="text" name="zip" id="zip"
                                       placeholder="<?php echo display('zip') ?>" class="form-control"
                                       value="<?php echo $this->session->userdata('zip') ?>">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group">
                                <label class="control-label"
                                       for="phone"><?php echo display('customer_mobile') ?> <abbr
                                            class="required" title="required">*</abbr></label>
                                <input type="number" id="customer_mobile" class="form-control"
                                       name="customer_mobile"
                                       placeholder="<?php echo display('customer_mobile') ?>" required
                                       value="<?php echo $this->session->userdata('customer_mobile') ?>"
                                       data-toggle="tooltip" data-placement="bottom"
                                       title="<?php echo display('add_country_code') ?>">
                                <span class="color5 padfont"
                                      ><?php echo display('add_country_code') ?></span>

                            </div>
                        </div>
                    </div>


                    <div class="checkbox checkbox-success">
                        <input type="checkbox" id="privacy_policy" name="privacy_policy" value="1"
                               required="" <?php if ($this->session->userdata('privacy_policy') == 1) {
                            echo "checked";
                        } ?>>
                        <label for="privacy_policy"><?php echo display('privacy_policy') ?></label>
                        <a href="<?php echo base_url('privacy_policy') ?>" target="_blank"><i
                                    class="fa fa-external-link"></i></a>
                    </div>
                    <div class="checkbox checkbox-success">
                        <input type="checkbox" id="diff_ship_adrs" name="diff_ship_adrs" value="1"
                            <?php if ($this->session->userdata('diff_ship_adrs') == 1) {
                                echo "checked";
                            } ?>>
                        <label for="diff_ship_adrs"
                               data-target="#billind-different-address" aria-expanded="false"><?php echo
                            display('ship_to_a_different_address')
                            ?></label>

                    </div>

                    <div class="-collapse <?php if ($this->session->userdata('diff_ship_adrs') == 1) {
                        echo "in";
                    } ?>" id="billind-different-address">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group has-error">
                                    <label class="control-label"
                                           for="ship_first_name"><?php echo display('first_name') ?> <abbr
                                                class="required" title="required">*</abbr></label>
                                    <input type="text" name="ship_first_name" id="ship_first_name"
                                           placeholder="<?php echo display('first_name') ?>"
                                           class="form-control" value="<?php echo $this->session->userdata('ship_first_name') ?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label"
                                           for="ship_last_name"><?php echo display('last_name') ?><abbr
                                                class="required" title="required">*</abbr></label>
                                    <input type="text" name="ship_last_name" id="ship_last_name"
                                           placeholder="<?php echo display('last_name') ?>" class="form-control"
                                           
                                           value="<?php echo $this->session->userdata('ship_last_name') ?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label"
                                           for="c_name2"><?php echo display('company') ?></label>
                                    <input type="text" name="ship_company" id="ship_company"
                                           placeholder="<?php echo display('company') ?>" class="form-control"
                                           value="<?php echo $this->session->userdata('ship_company') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="ship_country"
                                           class="control-label"><?php echo display('country') ?>
                                        <abbr class="required" title="required">*</abbr> : </label>
                                    <select name="ship_country" id="ship_country"
                                            class="form-control form-input custom_select">
                                        <option value=""> --- <?php echo display('select_country') ?>---
                                        </option>
                                        <?php
                                        if ($selected_country_info) {
                                            foreach ($selected_country_info as $country) {
                                                ?>
                                                <option value="<?php echo html_escape($country->id) ?>"><?php echo html_escape($country->name) ?> </option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"
                                           for="ship_customer_email"><?php echo display('customer_email') ?>
                                        <abbr
                                                class="required" title="required">*</abbr></label>
                                    <input type="text" id="ship_customer_email" name="ship_customer_email"
                                           class="form-control"
                                           placeholder="<?php echo display('customer_email') ?>"
                                           value="<?php echo $this->session->userdata('ship_customer_email') ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="ship_address_1"
                                           class="control-label"><?php echo display('customer_address_1') ?>
                                        <abbr
                                                class="required" title="required">*</abbr> :</label>
                                    <input type="text" name="ship_address_1" id="ship_address_1"
                                           placeholder="<?php echo display('customer_address_1') ?>"
                                           class="form-control" 
                                           value="<?php echo $this->session->userdata('ship_address_1') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="ship_address_2"
                                           class="control-label"><?php echo display('customer_address_2') ?>
                                        :</label>
                                    <input type="text" name="ship_address_2" id="ship_address_2"
                                           placeholder="<?php echo display('customer_address_2') ?>"
                                           class="form-control"
                                           value="<?php echo $this->session->userdata('ship_address_2') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="ship_city" class="control-label"><?php echo display('city') ?>
                                        <abbr
                                                class="required" title="required">*</abbr> :</label>
                                    <input type="text" name="ship_city" id="ship_city" class="form-control"
                                           placeholder="<?php echo display('city') ?>"
                                           value="<?php echo $this->session->userdata('ship_city') ?>">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="ship_state"><?php echo display('state') ?>
                                        <abbr class="required" title="required">*</abbr> :</label>
                                    <select name="ship_state" id="ship_state"
                                            class="form-control form-input custom_select">
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
                                    </select></div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="ship_zip"
                                                   class="control-label"><?php echo display('zip') ?>
                                                :</label>
                                            <input type="text" name="ship_zip" id="ship_zip"
                                                   placeholder="<?php echo display('zip') ?>"
                                                   class="form-control"
                                                   value="<?php echo $this->session->userdata('ship_zip') ?>">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="ship_mobile"
                                                   class="control-label"><?php echo display('mobile') ?> <abbr
                                                        class="required" title="required">*</abbr> :</label>
                                            <input type="text" name="ship_mobile" id="ship_mobile"
                                                   placeholder="<?php echo display('mobile') ?>"
                                                   class="form-control" 
                                                   value="<?php echo $this->session->userdata('ship_mobile') ?>"
                                                   data-toggle="tooltip" data-placement="bottom"
                                                   title="<?php echo display('add_country_code') ?>"><span
                                                    class="color5 padfont"><?php echo display('add_country_code') ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label"
                               for="ordre_notes"><?php echo display('add_coment_about_your_order') ?></label>
                        <textarea class="form-control" id="ordre_notes" rows="5" placeholder="<?php echo
                        display('notes_about_your_order') ?>"><?php echo
                            $this->session->userdata('delivery_details') ?></textarea>
                    </div>
                </div>
                <div class="panel panel-default">
                    <h3 class="text-danger" id="coupon_error_text_color"><span id="coupon_error"></span></h3>
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <i class="fa fa-question-circle"></i><?php echo display('use_coupon_code') ?> <a
                                    data-toggle="collapse" data-parent="#accordion"
                                    href="#collapseThree"><?php echo display('enter_your_coupon_here') ?></a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse">
                        <div class="panel-body coupon">
                            <div class="form-inline">
                                <input type="text" class="form-control" id="coupon_code" name="coupon_code"
                                       placeholder="<?php
                                       echo display('enter_your_coupon_here') ?>" >
                                <a href="#" class="btn color2 text-white"
                                   id="coupon_value"><?php echo display('apply_coupon') ?></a>

                            </div>
                        </div>
                    </div>

                    <!--======= End coupon area ======-->
                </div>
            </div>
            <div class="col-sm-4">
                <div class="check-orde">
                    <h4>Your order</h4>
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="product-name"><?php echo display('product') ?></th>
                            <th class="product-total text-right"><?php echo display('total') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1;
                        $cgst = 0;
                        $sgst = 0;
                        $igst = 0;
                        $discount = 0;
                        $coupon_amnt = 0; ?>
                        <?php

                        foreach ($this->cart->contents() as $items):
                            ?>
                            <?php echo form_hidden($i . '[rowid]', $items['rowid']);

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
                            <tr class="cart_item">
                                <td class="product-name"><?php echo html_escape($items['name']); ?>
                                    <strong class="product-sum">× <?php echo html_escape($items['qty']); ?></strong>
                                </td>
                                <td class="product-total text-right">
                                    <span class="woocommerce-Price-amount amount">
                                        <span class="woocommerce-Price-currencySymbol"><?php echo(($position == 0) ? $currency . " " . $this->cart->format_number($items['price'] * $items['qty']) : $this->cart->format_number($items['actual_price'] * $items['qty']) . " " . $currency) ?></span>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>

                        </tbody>
                        <tfoot>

                        <?php
                        $total_tax = $cgst + $sgst + $igst;
                        if ($total_tax > 0) {
                            ?>
                            <tr>
                                <td class="total_tax">
                                    <?php echo display('total_tax') ?>
                                </td>
                                <td class="text-right">
                                    <?php
                                    $total_tax = $cgst + $sgst + $igst;
                                    @$this->_cart_contents['total_tax'] = $total_tax;
                                    echo (($position == 0) ? $currency . " " . number_format($total_tax, 2, '.', ',') : number_format($total_tax, 2, '.', ',') . " " . $currency) ?>
                                </td>
                            </tr>
                            <?php
                        }

                        ?>
                        <tr id="shipCostRow">
                            <td class="cart_ship_name">
                                <span id="set_cart_ship_name"></span>
                            </td>
                            <td class="text-right">

                                <?php

                                echo(($position == 0) ? $currency . ' <span id="set_ship_cost"></span> '
                                    : '<span id="set_ship_cost"></span>' . $currency);
                                ?>
                            </td>
                        </tr>
                        <?php

                        ?>
                        <tr id="couponAmountRow">
                            <td class="coupon_discount">
                                <strong><?php echo display('coupon_discount') ?>:</strong>
                            </td>
                            <td class="text-right">
                                <span id="set_coupon_price"></span>
                                <?php

                                echo(($position == 0) ? $currency . ' <span id="set_coupon_price"></span> '
                                    : '<span id="set_coupon_price"></span>' . $currency);
                                ?>
                            </td>
                        </tr>
                        <?php

                        ?>
                        <tr>
                            <td class="text-right"><strong><?php echo display('total') ?>
                                    :</strong></td>
                            <td class="text-right">
                                <strong>
                                    <?php
                                    $cart_total = $this->cart->total() + $total_tax;
                                    ?>
                                    <span id="total_amount"></span>
                                    <input type="hidden" name="order_total_amount" id="order_total_amount">
                                </strong>
                                <input type="hidden" name="cart_total_amount" id="cart_total_amount"
                                       value="<?php echo html_escape($cart_total); ?>">


                            </td>
                        </tr>
                        </tfoot>
                    </table>

                    <hr>
                    <h3><?php echo display('shipping_method') ?></h3>
                    <p><?php echo display('kindly_select_the_preferred_shipping_method_to_use_on_this_order') ?></p>
                    <?php
                    if ($select_shipping_method) {
                        foreach ($select_shipping_method as $shipping_method) {
                            ?>
                            <p><strong><?php echo html_escape($shipping_method->method_name) ?></strong></p>
                            <div class="radio">
                                <label>
                                    <input type="radio" class="shipping_cost completed" name="shipping_cost"
                                           id="<?php echo html_escape($shipping_method->method_id) ?>"
                                           value="<?php echo html_escape($shipping_method->charge_amount) ?>"
                                           alt="<?php echo display('service_charge') ?>" <?php if ($this->session->userdata('method_id') == $shipping_method->method_id) {
                                        echo "checked";
                                    } ?>>
                                    <?php
                                    $default_currency_id = $this->session->userdata('currency_id');
                                    $currency_new_id = $this->session->userdata('currency_new_id');

                                    if (empty($currency_new_id)) {
                                        $result = $cur_info = $this->db->select('*')
                                            ->from('currency_info')
                                            ->where('default_status', '1')
                                            ->get()
                                            ->row();
                                        $currency_new_id = $result->currency_id;
                                    }

                                    if (!empty($currency_new_id)) {
                                        $cur_info = $this->db->select('*')
                                            ->from('currency_info')
                                            ->where('currency_id', $currency_new_id)
                                            ->get()
                                            ->row();

                                        $target_con_rate = $cur_info->convertion_rate;
                                        $position1 = $cur_info->currency_position;
                                        $currency1 = $cur_info->currency_icon;
                                    }
                                    ?>

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
                    <hr>
                    <h3><?php echo display('payment_method') ?></h3>

                    <div class="payment-block" id="payment">
                        <!-- Cash on delivery payment method -->
                        <div class="radio">
                            <label>
                                <input type="radio" name="payment_method" required
                                       value="1" <?php if ($this->session->userdata('payment_method') == 1) {
                                    echo "checked ='checked'";
                                } ?> checked>

                                <?php echo display('cash_on_delivery') ?>
                            </label>
                        </div>

                        <?php if(!empty($payment_gateways)){
                            foreach ($payment_gateways as $paygateway) { ?>
                            <div class="">
                               <div class="radio">
                                    <label>
                                        <input type="radio" name="payment_method" value="<?php echo $paygateway['used_id']; ?>" <?php echo  (($this->session->userdata('payment_method') == $paygateway['used_id'])?"checked = 'checked'":""); ?>> &nbsp;
                                    <?php  if(!empty($paygateway['image'])) { ?>

                                        <img src="<?php echo base_url($paygateway['image']) ?>" alt="<?php echo ucfirst($paygateway['agent']); ?>">

                                    <?php } else {  ?>
                                        <strong><?php echo ucfirst($paygateway['agent']); ?></strong>
                                    <?php } ?>
                                    </label>
                                </div>
                            </div>
                        <?php  } } ?>

                    </div>
                    <!-- /.End of payment method -->
                    <button type="submit" class="btn btn-warning btn-block" id="payment_method_sumbmit"><?php echo display('confirm_order') ?></button>
                </div>
            </div>
        </div>
    </div>
<?php echo form_close(); ?>
<?php } else { ?>
<div class="container-fluid text-center conbox">
    <img class="oopsimg" src="<?php echo base_url() ?>assets/website/image/oops.png"
         alt="oops image">
    <h1 class="text-center m_2e"><?php echo display('oops_your_cart_is_empty')
        ?></h1>
    <a href="<?php echo base_url() ?>" class="base_button btn btn-success m_1e"><?php echo display
        ('got_to_shop_now') ?></a>
</div>
<?php } ?>
</div>
<input type="hidden" name="coupon_amnt" id="coupon_amnt" value="<?php echo @$this->session->userdata('coupon_amnt')?>">
<input type="hidden" name="coupon_message" id="coupon_message" value="<?php echo @$this->session->userdata('message')?>">
<input type="hidden" name="coupon_error_message" id="coupon_error_message" value="<?php echo @$this->session->userdata('error_message')?>">


