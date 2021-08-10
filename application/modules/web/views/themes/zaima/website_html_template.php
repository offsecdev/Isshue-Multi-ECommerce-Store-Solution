<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="<?php if ($company_info['0']['company_name']) {
        echo html_escape($company_info['0']['company_name']);
    } ?>">
    <meta name="description" content="<?php if ($Web_settings[0]['meta_description']) {
        echo html_escape($Web_settings[0]['meta_description']);
    } ?>">
    <meta name="keywords" content="<?php if ($Web_settings[0]['meta_keyword']) {
        echo html_escape($Web_settings[0]['meta_keyword']);
    } ?>">
    <!-- facebook og -->
    <meta property="og:type" content="product"/>
    <meta property="og:title" content="<?php echo  (!empty($product_name)?$product_name:'') ?>">
    <meta property="og:description" content="<?php echo (!empty($product_details)?character_limiter(strip_tags(htmlspecialchars_decode($product_details)), 200):''); ?>">
    <meta property="og:image" content="<?php echo (!empty($image_thumb)?base_url() . $image_thumb:''); ?>"/>
    <meta property="og:url" content="<?php echo  current_url(); ?>">
    <meta property="og:site_name" content="<?php if ($company_info['0']['company_name']) {
        echo html_escape($company_info['0']['company_name']);
    } ?>"/>
    <meta property="og:locale" content="en_US"/>
    <!-- twitter cards -->
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="<?php echo  (!empty($product_name)?$product_name:'') ?>" />
    <meta name="twitter:description" content="<?php echo (!empty($product_details)?character_limiter(strip_tags(htmlspecialchars_decode($product_details)), 200):''); ?>" />
    <meta name="twitter:image" content="<?php echo (!empty($image_thumb)?base_url() . $image_thumb:''); ?>" />

    <title><?php echo (isset($title)) ? $title : "Isshue" ?></title>

    <base href="<?php echo base_url(); ?>">
    <link rel="shortcut icon" href="<?php echo base_url() . $Web_settings[0]['favicon']; ?>">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="<?php echo THEME_URL.$theme.'/assets/plugins/bootstrap/css/bootstrap.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo THEME_URL.$theme.'/assets/dist/css/animation.css'; ?>" rel="stylesheet">
    <link href="<?php echo THEME_URL.$theme.'/assets/plugins/fontawesome/css/all.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo THEME_URL.$theme.'/assets/plugins/pe-icon-7-stroke/css/pe-icon-7-stroke.css'; ?>" rel="stylesheet">
    <link href="<?php echo THEME_URL.$theme.'/assets/plugins/themify-icons/themify-icons.css'; ?>" rel="stylesheet">
    <link href="<?php echo THEME_URL.$theme.'/assets/plugins/OwlCarousel2/css/owl.carousel.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo THEME_URL.$theme.'/assets/plugins/OwlCarousel2/css/owl.theme.default.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo THEME_URL.$theme.'/assets/plugins/slick/slick.css'; ?>" rel="stylesheet">
    <link href="<?php echo THEME_URL.$theme.'/assets/plugins/slick/slick-theme.css'; ?>" rel="stylesheet">
    <link href="<?php echo THEME_URL.$theme.'/assets/plugins/Magnific-Popup/magnific-popup.css'; ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo THEME_URL.$theme.'/assets/plugins/PhotoSwipe/dist/photoswipe.css'; ?>" rel="stylesheet">
    <link href="<?php echo THEME_URL.$theme.'/assets/plugins/PhotoSwipe/dist/default-skin/default-skin.css'; ?>" rel="stylesheet">
    <link href="<?php echo THEME_URL.$theme.'/assets/plugins/raty/lib/jquery.raty.css'; ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo THEME_URL.$theme.'/assets/plugins/ion.rangeSlider/css/ion.rangeSlider.min.css'; ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo THEME_URL.$theme.'/assets/plugins/jquery-ui/smoothness/jquery-ui.min.css';?>">
    <link href="<?php echo THEME_URL.$theme.'/assets/dist/css/style.css'; ?>" rel="stylesheet">

    <!-- jQuery -->
    <script src="<?php echo THEME_URL.$theme.'/assets/plugins/jquery/jquery-3.5.1.min.js'; ?>"></script>

    <script src="<?php echo THEME_URL.$theme.'/assets/dist/js/popper.min.js'; ?>"></script>
    <!--Bootstrap-->
    <script src="<?php echo THEME_URL.$theme.'/assets/plugins/bootstrap/js/bootstrap.min.js'; ?>"></script>
    <!-- JS form validation -->
    <script src="<?php echo base_url() ?>assets/js/jquery.validate.min.js" type="text/javascript"></script>
    <!-- Sweetalert -->
    <script src="<?php echo base_url('assets/plugins/sweetalert/sweetalert2.all.js') ?>"></script>

    <!-- jQuery UI library -->
    <script src="<?php echo THEME_URL.$theme.'/assets/plugins/jquery-ui/jquery-ui.min.js';?>"></script>


    <!--    google analytics -->
    <?php echo htmlspecialchars_decode($Web_settings[0]['google_analytics']); ?>

    <!-- Dynamic CSS -->
    <?php $this->load->view('assets/dist/css/color'); ?>

</head>
<body>
<?php

if (!empty($this->session->userdata('language'))) {
    $language_id = $this->session->userdata('language');

} else {

    $language_id = 'english';
}
?>
<input type ="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">
<input type="hidden" name="customer_id" id="customer_id" value="<?php echo $this->session->userdata('customer_id') ?>">
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="CSRF_TOKEN" value="<?php echo $this->security->get_csrf_hash(); ?>">
<input type="hidden" name="language_id" id="language_id" value="<?php echo $language_id ?>">
<?php if ($this->uri->segment(1) == "contact_us") { ?>
    <input type="hidden" name="map_latitude" id="map_latitude" value="<?php echo @$map_info[0]['map_latitude'] ?>">
    <input type="hidden" name="map_langitude" id="map_langitude" value="<?php echo @$map_info[0]['map_langitude'] ?>">
<?php } ?>
<input type="hidden" name="uri_segment" id="uri_segment" value="<?php echo @$this->uri->segment(1); ?>">
<script src="<?php echo base_url() ?>assets/js/global_js.js" defer type="text/javascript"></script>

<!--Register modal-->
<div class="modal register-modal" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <div class="modal-body">
                <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="accordion" id="accordionExample">
                    <nav class="nav mb-3">
                        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><?php echo display('login') ?></a>
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><?php echo display('sign_up') ?></a>
                    </nav>
                    <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                        <div class="form-title_wrap mb-3">
                            <h4 class="form-title mb-0"><?php echo display('login') ?></h4>
                        </div>
                        <!--Login Form-->
                        <?php echo form_open(base_url() . 'do_login'); ?>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" id="user_login_email" placeholder="<?php echo display('email') ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" id="user_login_password" placeholder="<?php echo display('password') ?>" required>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="remember">
                                    <label class="custom-control-label" for="remember"><?php echo display('remember_me') ?></label>
                                </div>
                                <a href="<?php echo base_url('forget_password_form') ?>" class="forgot d-block text-left"><?php echo display('forget_password') ?></a>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block"><?php echo display('login') ?></button>
                        <?php echo form_close(); ?>
                    </div>
                    <div id="collapseTwo" class="collapse" data-parent="#accordionExample">
                        <div class="form-title_wrap mb-3">
                            <h4 class="form-title mb-0"><?php echo display('sign_up') ?></h4>
                        </div>
                        <!--Register Form-->
                        <?php echo form_open(base_url().'user_signup') ?>
                            <div class="form-group">
                                <input type="text" class="form-control" name="first_name" id="cus_first_name"  placeholder="<?php echo display('first_name')?>" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="last_name"  id="cus_last_name" placeholder="<?php echo display('last_name')?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="email" id="user_email" name="email" class="form-control" placeholder="<?php echo display('email')?>" required>
                                <p id="email_warning"></p>
                            </div>
                            <div class="form-group">
                                <input type="text" id="mobile" name="phone"  class="form-control" placeholder="<?php echo display('mobile'); ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="password" id="user_pw" class="form-control" name="password" placeholder="<?php echo display('password')?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block"><?php echo display('sign_up')?></button>
                        <?php echo form_close(); ?>

                    </div>
                </div>

                <div class="row mt-3">
                     <?php if(check_module_status('googlelogin') == 1){  ?>
                    <div class="col-md-12 form-group">
                        <a class="btn btn-google btn-sm btn-block  search text-white" href="<?php echo base_url('googlelogin/googlelogin/login')?>"><i class="fab fa-google mr-1"></i> <?php echo display('google_login')?></a>
                    </div>
                    <?php }?>
                    <?php if((check_module_status('facebooklogin') == 1)){ ?>
                    <div class="col-md-12 form-group">
                        <a class="btn btn-facebook btn-sm btn-block  search text-white" href="<?php echo base_url('facebooklogin/facebooklogin/index/1')?>"><i class="fab fa-facebook mr-1"></i> <?php echo display('facebook_login')?></a>
                    </div>
                    <?php }?> 
                    <?php if((check_module_status('linkedinlogin') == 1)){ ?>
                    <div class="col-md-12 form-group">
                        <a class="btn btn-linkedin btn-sm btn-block  search text-white" href="<?php echo base_url('linkedinlogin/linkedinlogin/login/1')?>"><i class="fab fa-linkedin mr-1"></i> <?php echo display('linkedin_login')?></a>
                    </div>
                    <?php }?> 
                </div>

            </div>
            <div class="modal-footer d-flex justify-content-center">
                <div class="signup-section"><?php echo display('dont_have_an_account'); ?><a href="#a" class="text-primary" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><?php echo display('sign_up'); ?></a>.</div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('web/themes/' . $theme . '/include/header'); ?>
<?php
if(isset($template_lib) && !empty($template_lib)){ 
echo $content;
 }else{
 echo $this->load->view($module.'/'.$page);
}?>

<?php $this->load->view('web/themes/' . $theme . '/include/footer'); ?>

<script src="<?php echo THEME_URL.$theme.'/assets/plugins/card/dist/card.js'; ?>"></script>
<script src="<?php echo THEME_URL.$theme.'/assets/dist/js/hideShowPassword.min.js'; ?>"></script>
<script src="<?php echo THEME_URL.$theme.'/assets/plugins/slick/slick.min.js'; ?>"></script>
<script src="<?php echo THEME_URL.$theme.'/assets/plugins/Magnific-Popup/jquery.magnific-popup.min.js'; ?>"></script>
<script src="<?php echo THEME_URL.$theme.'/assets/plugins/elevatezoom/jquery.elevateZoom-3.0.8.min.js'; ?>"></script>
<script src="<?php echo THEME_URL.$theme.'/assets/plugins/theia-sticky-sidebar/ResizeSensor.min.js'; ?>"></script>
<script src="<?php echo THEME_URL.$theme.'/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.min.js'; ?>"></script>
<script src="<?php echo THEME_URL.$theme.'/assets/plugins/feather/feather.min.js'; ?>"></script>
<script src="<?php echo THEME_URL.$theme.'/assets/plugins/OwlCarousel2/owl.carousel.min.js'; ?>"></script>
<script src="<?php echo THEME_URL.$theme.'/assets/plugins/raty/lib/jquery.raty.js'; ?>"></script>
<script src="<?php echo THEME_URL.$theme.'/assets/plugins/PhotoSwipe/dist/photoswipe.min.js'; ?>"></script>
<script src="<?php echo THEME_URL.$theme.'/assets/plugins/PhotoSwipe/dist/photoswipe-ui-default.js'; ?>"></script>
<script src="<?php echo THEME_URL.$theme.'/assets/plugins/ion.rangeSlider/js/ion.rangeSlider.min.js'; ?>"></script>
<script src="<?php echo THEME_URL.$theme.'/assets/plugins/jquery.countdown/jquery.countdown.min.js'; ?>"></script>
<script src="<?php echo THEME_URL.$theme.'/assets/dist/js/custom.js'; ?>"></script>

<script src="<?php echo THEME_URL.$theme.'/assets/ajaxs/theme.js?v=1'; ?>"></script>

<?php echo htmlspecialchars_decode($Web_settings[0]['facebook_messenger']); ?>
</body>
</html>