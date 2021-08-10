<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="newsletter color3">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-7">
                <h5 class="newsletter-title"><?php echo display('subscribe_for_news_and') ?></h5>
                <strong class="offers color44"><?php echo display('offers') ?></strong>
            </div>
            <div class="col-xs-12 col-sm-5">
                <div id="sub_msg"></div>
                <?php echo form_open(''); ?>
                    <div class="input-group">
                        <input type="email" id="sub_email" class="form-control" placeholder="<?php echo display('enter_your_email') ?>">
                        <span class="input-group-btn">
                            <button class="btn btn-secondary color2" id="smt_btn" type="button"><?php echo display('subscribe') ?></button>
                        </span>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<footer class="big-footer color2">
    <div class="container">
        <div class="page-scroll back-top color4" data-section="#top">
            <i class="lnr lnr-chevron-up"></i>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="footer-box">
                    <div class="footer-logo">
                        <a href="<?php echo base_url() ?>"><img src="<?php echo base_url().$Web_settings[0]['footer_logo'] ?>" class="img-responsive" alt="logo"></a>
                    </div>
                    <p><?php echo htmlspecialchars_decode($Web_settings[0]['footer_details']); ?></p>
                    <address>
                        <p><?php echo display('address') ?>: <?php echo html_escape($company_info[0]['address']); ?></p>
                    </address>
                    <div class="contact_info">
                        <span><?php echo display('mobile') ?>: </span><a href="tel:<?php echo html_escape($company_info[0]['mobile']); ?>"><?php echo html_escape($company_info[0]['mobile']); ?></a>
                    </div>
                    <div class="contact_info">
                        <span><?php echo display('email') ?>: </span><a
                                href="#"><?php echo html_escape($company_info[0]['email']); ?></a>
                    </div>
                    <div class="contact_info">
                        <span><?php echo display('website') ?>: </span><a
                                href="#"><?php echo html_escape($company_info[0]['website']); ?></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-7 col-sm-offset-1 hidden-xs">
                <div class="row footer_inner">
                    <?php
                    $q=1;
                    if ($footer_block) {
                        foreach ($footer_block as $footer) {?>
                    <div class="col-md-4 <?php echo(($q==1)? "hidden-sm":"");?>">
                        <div class="footer-box">
                           <?php echo htmlspecialchars_decode($footer->details); ?>
                    </div>
                    </div>
                        <?php
                            $q++;
                        }
                    }
                    ?>
                    <?php if (1 == $Web_settings[0]['app_link_status']) { ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="footer-title2">
                            <h4 class="color4 download_app"><?php echo display('download_the_app') ?></h4>
                        </div>
                        <div class="app-text">
                            <p><?php echo display('get_access_to_all_exclusive_offers') ?></p>
                        </div>
                        <br>
                        <div class="apps color44">
                            <a href="<?php if($Web_settings[0]['apps_url']){ echo html_escape($Web_settings[0]['apps_url']);}else{ echo "https://play.google.com/store/apps/details?id=com.bdtask.isshues";}  ?>" target="_blank"><img
                                        src="<?php echo base_url() . 'application/modules/web/views/themes/' . $theme . '/assets/img/play-store-1.png' ?>"
                                        class="img-responsive"
                                        alt="image">
                            </a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="subfooter">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="copy-text"><?php if ($Web_settings[0]['footer_text']) {
                        echo htmlspecialchars_decode($Web_settings[0]['footer_text']);
                    } ?></div>
            </div>
            <div class="col-sm-6">
                <?php if (1 == $Web_settings[0]['pay_with_status']) {
                if ($pay_withs) {
                 ?>
                    <ul class="list-inline pull-right">
                        <li><h6 class="color44"><?php echo display('pay_with') ?> :</h6></li>
                        <?php foreach ($pay_withs as $pay_with):?>
                                <li><a href="<?php echo html_escape($pay_with['link']); ?>" target="_blank"><img width="30" height="30" src="<?php echo base_url() ?>my-assets/image/pay_with/<?php echo html_escape($pay_with['image']); ?>" alt="#"></a></li>
                            <?php endforeach; ?>
                    </ul>
                <?php } } ?>
            </div>
        </div>
    </div>
</div>

