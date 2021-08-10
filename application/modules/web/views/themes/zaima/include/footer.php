
<link rel="stylesheet" type="text/css" href="<?php echo THEME_URL.$theme.'/assets/css/footer.css' ?>">
<!--Newsletter-->
<div class="newsletter border-top py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="row align-items-center">
                    <div class="col-12 col-sm-auto mb-4 mb-lg-0">
                        <h5 class="newsletter-title fs-21 mb-0"><i data-feather="send" class="mr-2"></i><?php echo display('subscribe_for_news_and')." ".display('offers') ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <?php echo form_open('#', array('class' => 'row m0 newsletter_form')); ?> 
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="<?php echo display('enter_your_email') ?>" required="" id="sub_email">
                        <div class="input-group-append ml-2">
                            <button class="btn btn-secondary fs-14 text-capitalize color4 color46"  id="smt_btn" type="button"><?php echo display('subscribe') ?></button>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<!--Footer-->
<?php
    $blockitems = [1,0,0,1];
    $mob_footer_block = $Web_settings[0]['mob_footer_block'];
    if(!empty($mob_footer_block)){
        $blockitems = json_decode($mob_footer_block);
    }

 ?>
<footer class="main-footer border-top color2">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-4 col-xl-4 py-3 py-md-5 text-center text-md-left <?php echo ($blockitems[0]=='1'?'d-md-block':'d-none d-md-block') ?>">
                <div class="footer-about">
                    <div class="footer-logo mb-3">
                        <a href="<?php echo base_url() ?>"><img src="<?php echo base_url().$Web_settings[0]['footer_logo'] ?>" class="img-fluid" alt="logo"></a>
                    </div>
                     <p><?php echo htmlspecialchars_decode($Web_settings[0]['footer_details']); ?></p>
                     <address>
                        <p><?php echo display('address') ?>: <?php echo html_escape($company_info[0]['address']); ?></p>
                    </address>

                    <div class="contact_info">
                        <ul class="list-unstyled text-sm">
                            <li><?php echo display('mobile') ?>: <a href="tel:<?php echo html_escape($company_info[0]['mobile']); ?>"><?php echo html_escape($company_info[0]['mobile']); ?></a></li>
                            <li><?php echo display('email') ?>: <a href="mailto:<?php echo html_escape($company_info[0]['email']); ?>"><?php echo html_escape($company_info[0]['email']); ?></a></li>
                            <li><?php echo display('website') ?>: <a
                                href="#"><?php echo html_escape($company_info[0]['website']); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>


             <?php
                    $q=1;
                    if ($footer_block) {
                        foreach ($footer_block as $footer) {?>

                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2 py-3 py-md-5 <?php echo ($blockitems[$q]=='1'?'d-md-block':'d-none d-md-block') ?>">
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
                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 py-3 py-md-5 <?php echo ($blockitems[3]=='1'?'d-md-block':'d-none d-md-block') ?>">
                    <h3 class="link-title fs-17 mb-3 font-weight-600 position-relative footer-app-link"><?php echo display('download_the_app') ?></h3>
                    <p><?php echo display('get_access_to_all_exclusive_offers') ?></p>

                    <a class="market-button google-button d-inline-block mr-2 mb-2 border rounded bg-gray" href="<?php if($Web_settings[0]['apps_url']){ echo htmlspecialchars_decode($Web_settings[0]['apps_url']);}  ?>"><span class="mb-subtitle">Download on the</span><span class="mb-title">Google Play</span></a>
                </div>
            <?php } ?>
        </div>
    </div>
</footer>
<!--Sub footer-->
<div class="sub-footer bg-white py-3 border-top color2">
    <div class="container">
        <div class="row justify-content-end align-items-center">
            <div class="col-md-6 text-center text-md-left">
                <div class="copy"><?php if ($Web_settings[0]['footer_text']) {
                        echo htmlspecialchars_decode($Web_settings[0]['footer_text']);
                    } ?></div>
            </div>
            <div class="col-md-6">
                <?php if (1 == $Web_settings[0]['pay_with_status']) { 
                    if ($pay_withs) {
                    ?>
                <ul class="list-unstyled text-center text-md-right mb-0">
                    <li class="list-inline-item"><h6><?php echo display('pay_with') ?> :</h6></li>
                        <?php
                            foreach ($pay_withs as $pay_with):?>
                                <li class="list-inline-item">
                                    <a href="<?php echo html_escape($pay_with['link']); ?>" target="_blank"><img width="30" height="30" src="<?php echo base_url() ?>my-assets/image/pay_with/<?php echo html_escape($pay_with['image']); ?>" alt="#"></a>
                                </li>
                            <?php endforeach; ?>
                </ul>
                <?php }  } ?>
            </div>
        </div>
    </div>
</div>