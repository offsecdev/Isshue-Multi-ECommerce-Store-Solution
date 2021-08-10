<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php
    $CI =& get_instance();
    ?>
    <meta name="author" content="<?php if ($company_info['0']['company_name']) {
        echo html_escape($company_info['0']['company_name']);
    } ?>">
    <meta name="description" content="<?php if ($Web_settings[0]['meta_description']) {
        echo html_escape($Web_settings[0]['meta_description']);
    } ?>">
    <meta name="keywords" content="<?php if ($Web_settings[0]['meta_keyword']) {
        echo html_escape($Web_settings[0]['meta_keyword']);
    } ?>">

    <title><?php echo (isset($title)) ? $title : "Isshue" ?></title>
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
    
    <base href="<?php echo base_url(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&family=Rakkas&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Favicons -->
    <link rel="icon" type="image/png" href="<?php if (isset($Web_settings[0]['logo'])) {
        echo base_url() . $Web_settings[0]['favicon'];
    } ?>">

    <!-- Bootstrap 4 core CSS -->
    <link href="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/website/vendor/bootstrap/css/bootstrap.min.css')
    ?>" rel="stylesheet">

    <!-- FontAwesome Icon CSS -->
    <link href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css')
    ?>" rel="stylesheet" type="text/css">

    <!-- Jquery UI CSS -->
    <link href="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.css')
    ?>" rel="stylesheet">

    <!-- Owl Carousel CSS -->
    <link href="<?php echo base_url('assets/plugins/owl-carousel/owl.carousel.min.css')
    ?>" rel="stylesheet">

    <!-- Animate CSS -->
    <link href="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/website/vendor/wow-js/animate.css')
    ?>" rel="stylesheet">

    <!-- Lightbox CSS -->
    <link href="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/website/vendor/lightbox/css/lightbox.min.css')
    ?>" rel="stylesheet">
    <!-- magnific-Popup -->
    <link href="<?php echo base_url('assets/plugins/magnific-Popup/magnific-popup.min.css') ?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/website/css/style.css') ?>"
          rel="stylesheet">
    <!-- EasyZoom CSS -->
    <link rel="stylesheet" href="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/website/vendor/easyzoom/easyzoom.min.css')
          ?>">

    <!-- Responsive Style -->
    <link href="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/website/css/responsive.css') ?>"
          rel="stylesheet">

    <!-- Include SmartWizard CSS -->
    <link href="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/website/vendor/SmartWizard-master/dist/css/smart_wizard.css') ?>" rel="stylesheet" type="text/css">

    <!-- Optional SmartWizard theme -->
    <link href="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/website/vendor/SmartWizard-master/dist/css/smart_wizard_theme_dots.css') ?>" rel="stylesheet" type="text/css">
    <!-- jQuery -->
    <script src="<?php echo base_url()?>assets/js/jquery.min.js" type="text/javascript"></script>
    <!-- Bootstrap  -->
    <script src="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/website/vendor/bootstrap/js/tether.min.js') ?>"
            type="text/javascript"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/website/vendor/bootstrap/js/bootstrap.min.js') ?>" type="text/javascript"></script>

    <script type="text/javascript" src="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/website/js/validator.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js') ?>"></script>
    <!-- jquery-ui.min.js -->
    <script src="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.js')?>" type="text/javascript"></script>
    <!-- Sweetalert -->
    <script src="<?php echo base_url('assets/plugins/sweetalert/sweetalert2.all.js') ?>"></script>

    <script defer src="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/website/js/isshue_classic_ajax.js?v=' . mt_rand(1, 9)) ?>"></script>

    <!-- google analytics -->
    <?php echo htmlspecialchars_decode($Web_settings[0]['google_analytics']); ?>
    <!-- Dynamic CSS -->
    <?php $this->load->view('assets/website/css/color'); ?>

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
<input type ="hidden" name="CSRF_TOKEN" id="CSRF_TOKEN" value="<?php echo $this->security->get_csrf_hash(); ?>">
<input type ="hidden" name="language_id" id="language_id" value="<?php echo html_escape($language_id) ?>">
<input type="hidden" name="customer_id" id="customer_id" value="<?php echo $this->session->userdata('customer_id') ?>">
<script src="<?php echo base_url() ?>assets/js/global_js.js" type="text/javascript"></script>

<!--==== Preloader =======-->
<div class="preloader"></div>

<!--========== Header Top Area ==========-->
<div class="header_top color5_topbar">
    <div class="container">
        <div class="row m0 header_top_inner">
            <div class="col-lg-5 hidden-md-down">
                <div class="row connect_area">
                    <div class="connectus">
                        <a href="#"><i class="fa fa-phone"></i><?php echo display('have_a_question') ?> <?php echo display('call_us') ?>
                            : <?php echo html_escape($company_info[0]['mobile']) ?></a>
                    </div>
                    <div class="connectus">
                        <a href="#"><i class="fa fa-envelope-o"></i> <?php echo display('email') ?>
                            : <?php echo html_escape($company_info[0]['email']) ?></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="row changing_area justify-content-end justify-content-center-sm">
                    <div class="l_change">
                        <a class="track_order" href="<?php  echo base_url('track_my_order'); ?>"><?php echo display('track_my_order');?></a>
                    </div>
                    <div class="l_change">
                        <span class="hidden-md-down"><?php echo display('language'); ?>: </span>
                        <?php
                        $user_lang = $this->session->userdata('language');
                        echo form_dropdown('language', $languages, $user_lang, 'id="change_language"');
                        ?>
                    </div>
                    <div class="m_change">
                        <span class="hidden-md-down"><?php echo display('currency') ?>:</span>
                        <select id="change_currency" name="change_currency">
                            <?php
                            $currency_new_id = $this->session->userdata('currency_new_id');
                            if ($currency_info) {
                                foreach ($currency_info as $currency) {
                                    ?>
                                    <option value="<?php echo html_escape($currency->currency_id) ?>" <?php
                                    if (!empty($currency_new_id)) {
                                        if ($currency->currency_id == $currency_new_id) {
                                            echo "selected";
                                        }
                                    } else {
                                        if ($currency->currency_id == $selected_cur_id) {
                                            echo "selected";
                                        }
                                    }
                                    ?>><?php echo html_escape($currency->currency_name) ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <ul class="login_option hidden-lg-up">
                        <li><a href="<?php echo base_url('login') ?>" class="go_btn"><?php echo display('login');
                                ?></a></li>
                        <li><a href="<?php echo base_url('signup') ?>" class="go_btn"><?php echo display('signup');
                                ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="company_name" id="company_name" value="<?php echo html_escape($company_info['0']['company_name']) ?>">
<?php if ($this->uri->segment(1) == "contact_us") { ?>
    <input type="hidden" name="map_latitude" id="map_latitude" value="<?php echo html_escape(@$map_info[0]['map_latitude']) ?>">
    <input type="hidden" name="map_langitude" id="map_langitude" value="<?php echo html_escape(@$map_info[0]['map_langitude']) ?>">
<?php } ?>
<input type="hidden" name="min_value" id="min_value" value="<?php echo html_escape(@$min_value); ?>">
<input type="hidden" name="max_value" id="max_value" value="<?php echo html_escape(@$max_value); ?>">
<input type="hidden" name="uri_segment" id="uri_segment" value="<?php echo @$this->uri->segment(1); ?>">
<!--========== End Header Top Area ==========-->

<?php $this->load->view('web/themes/' . $theme . '/include/admin_header'); ?>

<?php
if(isset($template_lib) && !empty($template_lib)){ 
echo $content;
 }else{
 echo $this->load->view($module.'/'.$page);
}?>

<?php $this->load->view('web/themes/' . $theme . '/include/admin_footer'); ?>


<a href="#0" class="cd-top color4">
    <i class="fa fa-arrow-up"></i>
</a>


<!-- Include SmartWizard JavaScript source -->
<script type="text/javascript" src="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/website/vendor/SmartWizard-master/dist/js/jquery.smartWizard.min.js') ?>"></script>

<!-- Owl Carousel -->
<script src="<?php echo base_url('assets/plugins/owl-carousel/owl.carousel.min.js') ?>" type="text/javascript"></script>

<!-- EasyZoom -->
<script src="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/website/vendor/easyzoom/easyzoom.min.js') ?>"
        type="text/javascript"></script>
<!-- Video Popup -->
<script src="<?php echo base_url('assets/plugins/magnific-Popup/jquery.magnific-popup.min.js') ?>"></script>

<!-- DSCount JS -->
<script src="<?php echo base_url('/assets/plugins/dscountdown/dscountdown.min.js') ?>" type="text/javascript"></script>

<!-- WoW js -->
<script src="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/website/vendor/wow-js/wow.min.js') ?>"></script>

<!-- Lightbox js -->
<script src="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/website/vendor/lightbox/js/lightbox.min.js') ?>"></script>

<!-- Custom scripts for this template -->
<script src="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/website/js/theme.js') ?>"></script>

<?php echo htmlspecialchars_decode($Web_settings[0]['facebook_messenger']); ?>

</body>
</html>
