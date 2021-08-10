<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
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

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
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
    <link rel="shortcut icon" href="<?php echo base_url() . $Web_settings[0]['favicon']; ?>">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    
    <?php
    if ($Soft_settings[0]['rtr'] == 1) {
        ?>
        <!-- Bootstrap rtl -->
        <link href="<?php echo base_url('assets/bootstrap-rtl/bootstrap.rtl.min.css') ?>" rel="stylesheet" type="text/css"/>
        <?php
    }
    ?>
    <!-- animate -->
    <link href="<?php echo base_url('assets/plugins/animate/animate.min.css') ?>" rel="stylesheet">
    <!-- font-awesome -->
    <link href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css" rel="stylesheet"') ?>">
    <!-- flag-icon -->
    <link href="<?php echo base_url('assets/plugins/flag-icon/css/flag-icon.min.css') ?>" rel="stylesheet">
    <!-- linearicons -->
    <link href="<?php echo base_url('assets/plugins/linearicons/linearicons.min.css') ?>"rel="stylesheet">
    <!-- metismenu -->
    <link href="<?php echo base_url('assets/plugins/metismenu/metisMenu.min.css') ?>" rel="stylesheet">
    <!-- malihu-scrollbar -->
    <link href="<?php echo base_url('assets/plugins/malihu-scrollbar/jquery.mCustomScrollbar.min.css') ?>" rel="stylesheet">
    <!-- PhotoSwipe -->
    <link href="<?php echo base_url('assets/plugins/PhotoSwipe/photoswipe.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/plugins/PhotoSwipe/default-skin/default-skin.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/plugins/slick/slick.min.css') ?>"rel="stylesheet">
    <link href="<?php echo base_url('assets/plugins/slick/slick-theme.min.css') ?>"
          rel="stylesheet">
    <!-- magnific-Popup -->
    <link href="<?php echo base_url('assets/plugins/magnific-Popup/magnific-popup.min.css') ?>" rel="stylesheet">
    <!-- star-rating -->
    <link href="<?php echo base_url('assets/plugins/star-rating/star-rating.min.css') ?>"rel="stylesheet">
    <!-- ion.rangeSlider -->
    <link href="<?php echo base_url('assets/plugins/ion.rangeSlider/css/ion.rangeSlider.min.css" rel="stylesheet"') ?>">
    <link href="<?php echo base_url('assets/plugins/ion.rangeSlider/css/ion.rangeSlider.skinFlat.min.css" rel="stylesheet"') ?>">
    <!-- nice-select -->
    <link href="<?php echo base_url('assets/plugins/jquery-nice-select/css/nice-select.css') ?>" rel="stylesheet">

    <link href="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/css/style.css?v=2" rel="stylesheet') ?>">
    
    <?php
    if ($Soft_settings[0]['rtr'] == 1) {
        ?>
        <link href="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/css/style-rtl.css') ?>"
              rel="stylesheet" type="text/css"/>
        <?php
    }
    ?>
    
    <!-- jQuery -->
    <script src="<?php echo base_url()?>assets/js/jquery.min.js" type="text/javascript"></script>
    <!-- Martbd Product comparison js -->
    <script src="<?php echo THEME_URL.'martbd/assets/js/main.js'; ?>"></script>
    <!--Bootstrap-->
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>

    
    <!-- JS form validation -->
    <script src="<?php echo base_url() ?>assets/js/jquery.validate.min.js" type="text/javascript"></script>
    <!-- Sweetalert -->
    <script src="<?php echo base_url('assets/plugins/sweetalert/sweetalert2.all.js') ?>"></script>


    <!--    google analytics -->
    <?php echo htmlspecialchars_decode($Web_settings[0]['google_analytics']); ?>

    <!-- Dynamic CSS -->
    <?php $this->load->view('assets/css/color'); ?>

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

<div class="page-wrapper">
    <header class="main-header color36">
        <nav class="topBar hidden-xs">
            <div class="container">
                <ul class="list-inline pull-left">
                    <li>
                        <span class="text-primary"><?php echo display('have_a_question') ?> </span> <?php echo display('call_us') ?>
                        : <?php echo html_escape($company_info[0]['mobile']) ?></li>
                    <li><a href="#"><i class="fa fa-envelope-o"></i> <?php echo display('email') ?>
                            : <?php echo html_escape($company_info[0]['email']) ?></a></li>
                    <li><a href="<?php  echo base_url('track_my_order'); ?>"><?php echo display('track_my_order');?></li>
                </ul>
                <ul class="topBarNav pull-right">

                    <li>
                        <select id="change_currency" name="change_currency" class='select resizeselect'>
                            <?php
                            $currency_new_id = $this->session->userdata('currency_new_id');
                            if ($currency_info) {
                                foreach ($currency_info as $currency) {
                                    ?>
                                    <option value="<?php echo $currency->currency_id ?>" <?php
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
                    </li>
                    <li>
                        <?php
                        $css = [
                            'class' => 'select resizeselect',
                            'id' => 'change_language'
                        ];
                        $user_lang = $this->session->userdata('language');
                        echo form_dropdown('language', $languages, $user_lang, $css);
                        ?>
                    </li>
                </ul>

            </div>
        </nav>
        <div class="page-wrapper">

            <?php $this->load->view('web/themes/' . $theme . '/include/admin_header'); ?>
            
            <?php
            if(isset($template_lib) && !empty($template_lib)){ 
            echo $content;
             }else{
             echo $this->load->view($module.'/'.$page);
            }?>

            <?php $this->load->view('web/themes/' . $theme . '/include/admin_footer'); ?>

            <input type="hidden" id="request_failed" value="<?php echo display('request_failed') ?>">
            <input type="hidden" id="are_you_sure_want_to_delete"
                   value="<?php echo display("are_you_sure_want_to_delete"); ?>">
            <input type="hidden" id="please_enter_email" value="<?php echo display("please_enter_email") ?>">
            <input type="hidden" id="subscribe_successfully" value="<?php echo display("subscribe_successfully") ?>">
            <input type="hidden" id="failed" value="<?php echo display("failed") ?>">
            <input type="hidden" id="this_email_already_exists"
                   value="<?php echo display("this_email_already_exists") ?>">
        </div>
</div>

<script src="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/js/anime.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/metismenu/metisMenu.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/malihu-scrollbar/jquery.mCustomScrollbar.concat.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/slick/slick.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/elevatezoom/jquery.elevateZoom.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/PhotoSwipe/photoswipe.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/PhotoSwipe/photoswipe-ui-default.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/magnific-Popup/jquery.magnific-popup.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/star-rating/star-rating.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/theia-sticky-sidebar/ResizeSensor.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/ion.rangeSlider/js/ion.rangeSlider.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/jQuery-slimScroll/jquery.slimscroll.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/prognroll/prognroll.min.js') ?>"></script>
<?php if ($Soft_settings[0]['rtr'] == 1) { ?>
<script src="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/js/script-rtl.js') ?>"></script>

<?php } else { ?>
<script src="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/js/script.js') ?>"></script>
<?php } ?>
<script src="<?php echo base_url('assets/plugins/jquery-nice-select/js/jquery.nice-select.min.js') ?>"></script>

<!-- Martbd Theme Ajax js -->
<script src="<?php echo THEME_URL.'martbd/assets/ajaxs/martbd_ajax.js?v=1'; ?>"></script>



<?php echo htmlspecialchars_decode($Web_settings[0]['facebook_messenger']); ?>
</body>
</html>