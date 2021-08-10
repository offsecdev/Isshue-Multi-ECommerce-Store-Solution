<!--========== Page Header Area ==========-->
<section class="page_header">
<div class="container">
<div class="row m0 page_header_inner">
<h2 class="page_title">{title}</h2>
<ol class="breadcrumb m0 p0">
    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>"><?php echo display('home') ?></a></li>
    <li class="breadcrumb-item active">{title}</li>
</ol>
</div>
</div>
</section>
<!--========== End Page Header Area ==========-->

<!--==== welcome  Area ========-->
<section class="welcome_area">
<div class="container">
<div class="row">
<div class="col-lg-12">
    <div class="row m0 db img_area">
        <?php
        $payment_method = $this->session->userdata('payment_method');
        if ($payment_method == 3) {
            ?>

            <!-- Bitcoin payment start -->
            <script src="<?php echo base_url('bitcoin-plug/cryptobox.js'); ?>"
                    crossorigin="anonymous"></script>
            <?php $this->load->view('../../web/assets/js/payment'); ?>

            <div class="container theme-showcase" role="main">

                <!-- Loading ... -->
                <div class="gourl_loader">

                    <div class="container text-center gourl_loader_button">
                        <a class="m_8_2_4_2" href="" class="btn btn-default btn-lg"><i
                                    class='fa fa-spinner fa-spin'></i> &#160; {coin_name} Box Loading
                            ...</a>
                    </div>

                    <div class="panel panel-danger gourl_cryptobox_error panel_div_st">

                        <div class="panel-heading">
                            <h3 class="panel-title">Error !</h3>
                        </div>

                        <div class="panel-body">
                            <div class="gourl_error_message"></div>
                        </div>

                    </div>

                </div>

                <!-- Area above Payment Box -->

                <div class="gourl_cryptobox_top none">

                    <div class="row">
                        <!-- Box message -->
                        <div class="col-xs-6 col-md-10">
                            {message}
                        </div>

                        <!-- Box Language -->
                        <div class="col-xs-6 col-md-3">
                            <div class="dropdown mb_20" >
                                <button class="btn btn-default dropdown-toggle" type="button"
                                        data-toggle="dropdown">
                                    Language<?php echo " &#160; <span class='small'>" . json_decode(CRYPTOBOX_LOCALISATION, true)[CRYPTOBOX_LANGUAGE]["name"] . "</span>"; ?>
                                    <span class="caret"></span></button>
                                <?php echo display_language_box("en", "gourlcryptolang", false); ?>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Crypto Payment Box -->

                <div class="gourl_cryptobox_unpaid none">

                    <div class="row">
                        <div class="col-md-10">
                            <div class="panel panel-primary">

                                <div class="panel-heading">
                                    <h3 class="panel-title gourl_addr_title">1. <span
                                                class="gourl_texts_coin_address"></span></h3>
                                </div>

                                <div class="panel-body">
                                    <div class="gourl_div">
                                        <a class='gourl_wallet_url' href='#'>
                                            <img class='gourl_qrcode_image' alt='qrcode' data-size='200'
                                                 src='#'></a>
                                    </div>

                                    <div>
                                        <ol>
                                            
                                            <li data-site="circle.com" data-url="https://www.circle.com/"
                                                class="gourl_texts_intro1b"></li>
                                            <li class="gourl_texts_intro2"></li>
                                            <li><b class="gourl_texts_intro3"></b></li>
                                        </ol>
                                    </div>
                                    <br>
                                    <div class="ml_25">
                                        <div class="gourl_texts_send"></div>
                                        <br>
                                        <div><a class="gourl_addr gourl_wallet_url" href="#"></a> &#160; <a
                                                    class="gourl_wallet_url gourl_wallet_open" href="#"><i
                                                        class="fa fa-external-link" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">

                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    <h3 class="panel-title">2. <span
                                                class="gourl_paymentcaptcha_amount"></span></h3>
                                </div>
                                <div class="panel-body">
                                    <span class="gourl_amount"></span> <span class="gourl_coinlabel"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h3 class="panel-title">3. <span
                                                class="gourl_paymentcaptcha_status"></span></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="gourl_paymentcaptcha_statustext"></div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <?php echo form_open('web/Home/submit_checkout#gourlcryptolang'); ?>
                            <input type="hidden" id="cryptobox_refresh_" name="cryptobox_refresh_"
                                   value="1">

                            <button  class="gourl_button_refresh btn btn-default btn-lg m_10_20"></button>

                            <button class="gourl_button_wait btn btn-info btn-lg m_10_20"></button>
                            <?php echo form_close(); ?>
                        </div>

                        <div class="col-md-10">
                            <div class="gourl_texts_btn_wait_hint"></div>
                        </div>
                    </div>
                </div>

                <!-- Successful Result -->

                <div class="gourl_cryptobox_paid none"  >
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-success">

                                <div class="panel-heading">
                                    <div class="gourl_text_div">
                                        <span class="gourl_texts_total"></span>: <span
                                                class="gourl_amount"></span> <span
                                                class="gourl_coinlabel"></span>
                                    </div>
                                    <h3 class="panel-title gourl_paymentcaptcha_title">Result</h3>
                                </div>

                                <div class="panel-body text-center">

                                    <div class="gourl_paidimg ft_left">
                                        <br>
                                        <img class="b_0" src='https://coins.gourl.io/images/paid.png'
                                             alt='Successful'>
                                        <br><br>
                                    </div>

                                    <h3 class="gourl_paymentcaptcha_successful gourl_style">.</h3>

                                    <div class="gourl_paymentcaptcha_date"></div>

                                    <br>
                                    <a href="#"
                                       class="gourl_button_details btn btn-info m_10_20"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Bitcoin payment end -->
            <?php
        }
        if ($payment_method == 4) {
            ?>
            <table class="table table-bordered">
                <tr>
                    <th><?php echo display("customer_id") ?></th>
                    <td class="text-right"><?php echo  html_escape($user_id) ?></td>
                </tr>
                <tr>
                    <th><?php echo display("order_no") ?></th>
                    <td class="text-right"><?php echo  html_escape($m_orderid) ?></td>
                </tr>
                <tr>
                    <th><?php echo display("total_amount") ?></th>
                    <td class="text-right">$<?php echo  html_escape($m_amount) ?></td>
                </tr>
            </table>
            <?php echo form_open('https://payeer.com/merchant/')?>
                <input type="hidden" name="m_shop" value="<?php echo  html_escape($m_shop) ?>">
                <input type="hidden" name="m_orderid" value="<?php echo  html_escape($m_orderid) ?>">
                <input type="hidden" name="m_amount" value="<?php echo  html_escape($m_amount) ?>">
                <input type="hidden" name="m_curr" value="<?php echo  html_escape($m_curr) ?>">
                <input type="hidden" name="m_desc" value="<?php echo  html_escape($m_desc) ?>">
                <input type="hidden" name="m_sign" value="<?php echo  html_escape($sign) ?>">

                <input type="submit" name="m_process" value="Payment Process"
                       class="btn btn-success w-md m-b-5"/>

                <a href="<?php echo base_url('checkout#step-5'); ?>"
                   class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
            <?php echo form_close(); ?>
            <?php
        }
        ?>
    </div>
</div>

</div>
</div>
</section>
<!--==== End welcome Area ====-->