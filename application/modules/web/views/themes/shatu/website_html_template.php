<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php if (!empty($image_large_details)) { ?>
        <meta property="og:type" content="product"/>
        <meta property="og:title" content="<?php echo html_escape($product_name) ?>">
        <meta property="og:image" content="<?php echo base_url() . $image_large_details; ?>"/>
        <meta property="og:description" content="<?php echo strip_tags($product_details); ?>"/>

        <meta property="og:site_name" content="<?php if ($company_info['0']['company_name']) {
            echo html_escape($company_info['0']['company_name']);
        } ?>"/>
        <meta property="og:image:width" content="100"/>
        <meta property="og:image:height" content="100"/>
        <meta property="og:locale" content="en_US"/>
        <!-- twitter cards -->
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:title" content="<?php echo  (!empty($product_name)?$product_name:'') ?>" />
        <meta name="twitter:description" content="<?php echo (!empty($product_details)?character_limiter(strip_tags(htmlspecialchars_decode($product_details)), 200):''); ?>" />
        <meta name="twitter:image" content="<?php echo (!empty($image_thumb)?base_url() . $image_thumb:''); ?>" />
        

    <?php } ?>
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

    <base href="<?php echo base_url(); ?>">
    <link rel="shortcut icon" href="<?php echo base_url() . $Web_settings[0]['favicon']; ?>">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    <link href="<?php echo base_url() . 'assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"' ?>">
    <link href="<?php echo base_url('assets/plugins/animate/animate.min.css" rel="stylesheet"') ?>">
    <!-- font-awesome -->
    <link href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css" rel="stylesheet"') ?>">
    <!-- owl-carousel -->
    <link href="<?php echo base_url('assets/plugins/owl-carousel/owl.carousel.min.css" rel="stylesheet"') ?>">
    <link href="<?php echo base_url('assets/plugins/owl-carousel/owl.theme.default.min.css" rel="stylesheet"') ?>">
    <!-- flag-icon -->
    <link href="<?php echo base_url('assets/plugins/flag-icon/css/flag-icon.min.css') ?>" rel="stylesheet">
    <!-- linearicons -->
    <link href="<?php echo base_url('assets/plugins/linearicons/linearicons.min.css') ?>"rel="stylesheet">
    <!-- nice-select -->
    <link href="<?php echo base_url('assets/plugins/jquery-nice-select/css/nice-select.css') ?>" rel="stylesheet">
    <!-- metismenu -->
    <link href="<?php echo base_url('assets/plugins/metismenu/metisMenu.min.css" rel="stylesheet"') ?>">
    <!-- malihu-scrollbar -->
    <link href="<?php echo base_url('assets/plugins/malihu-scrollbar/jquery.mCustomScrollbar.min.css') ?>" rel="stylesheet">
    <!-- PhotoSwipe -->
    <link href="<?php echo base_url('assets/plugins/PhotoSwipe/photoswipe.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/plugins/PhotoSwipe/default-skin/default-skin.min.css') ?>" rel="stylesheet">
    <!-- slick -->
    <link href="<?php echo base_url('assets/plugins/slick/slick.min.css" rel="stylesheet"') ?>">
    <link href="<?php echo base_url('assets/plugins/slick/slick-theme.min.css" rel="stylesheet"') ?>">
    <!-- magnific-Popup -->
    <link href="<?php echo base_url('assets/plugins/magnific-Popup/magnific-popup.min.css') ?>"
          rel="stylesheet">
    <!-- star-rating -->
    <link href="<?php echo base_url('assets/plugins/star-rating/star-rating.min.css" rel="stylesheet"') ?>">
    <!-- ion.rangeSlider -->
    <link href="<?php echo base_url('assets/plugins/ion.rangeSlider/css/ion.rangeSlider.min.css" rel="stylesheet"') ?>">
    <link href="<?php echo base_url('assets/plugins/ion.rangeSlider/css/ion.rangeSlider.skinFlat.min.css" rel="stylesheet"') ?>">

    <link href="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/css/style.css?v=1" rel="stylesheet"') ?>">
    <link href="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/css/responsive.css" rel="stylesheet"') ?>">
    <link href="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/css/custom.css" rel="stylesheet"') ?>">
    <!-- jQuery -->
    <script src="<?php echo base_url()?>assets/js/jquery.min.js" type="text/javascript"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <!-- JS Form Validation -->
    <script src="<?php echo base_url() ?>assets/js/jquery.validate.min.js" type="text/javascript"></script>
    <!-- Sweetalert -->
    <script src="<?php echo base_url('assets/plugins/sweetalert/sweetalert2.all.js') ?>"></script>
    <!-- Dynamic CSS -->
    <?php $this->load->view('assets/css/color'); ?>

</head>

<?php $this->load->view('web/themes/' . $theme . '/include/admin_header'); ?>
<?php
if(isset($template_lib) && !empty($template_lib)){ 
    echo $content;
     }else{
 echo $this->load->view($module.'/'.$page);
}?>
<?php $this->load->view('web/themes/' . $theme . '/include/admin_footer'); ?>

<script src="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/js/anime.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/metismenu/metisMenu.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/owl-carousel/owl.carousel.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/malihu-scrollbar/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/slick/slick.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/jquery-nice-select/js/jquery.nice-select.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/elevatezoom/jquery.elevateZoom.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/PhotoSwipe/photoswipe.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/PhotoSwipe/photoswipe-ui-default.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/magnific-Popup/jquery.magnific-popup.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/star-rating/star-rating.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/dscountdown/dscountdown.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/theia-sticky-sidebar/ResizeSensor.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/ion.rangeSlider/js/ion.rangeSlider.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/jQuery-slimScroll/jquery.slimscroll.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/prognroll/prognroll.min.js'); ?>"></script>
<script src="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/js/script.js'); ?>"></script>

<script defer src="<?php echo base_url('application/modules/web/views/themes/' . $theme . '/assets/js/shatu_ajax.js?v=' . mt_rand(1, 9)) ?>"></script>
</body>

</html>
