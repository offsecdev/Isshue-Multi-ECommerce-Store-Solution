<!-- dynamic template color  -->
<?php $colors = $this->color_frontends->retrieve_color_editdata('zaima'); 
?>
<style>
    :root {
    /*Prymary color*/
        --primary-color: <?php echo (!empty($colors->color5)?$colors->color5:'#008000');?> !important;
    }
    .color1 {
        background: <?php echo $colors->color1;?> !important;
    }

    .color11 {
        color: <?php echo $colors->color1;?> !important;
    }

    .color2 {
        background: <?php echo $colors->color2;?> !important;
    }
    .color26 {
        border-color: <?php echo $colors->color2;?> !important;
    }

    .color3 {
        background: <?php echo $colors->color3;?> !important;
    }

    .color35 {
        color: <?php echo $colors->color3;?> !important;
    }

    .color36 {
        border-color: <?php echo $colors->color3;?> !important;
    }

    .color4 {
        background: <?php echo $colors->color4;?> !important;
    }
    .color42 {
        color: <?php echo $colors->color4;?> !important;
    }
    .color46 {
        border-color: <?php echo $colors->color4;?> !important;
    }
    .color412:hover {
        background: <?php echo $colors->color4;?> !important;
        border-color: <?php echo $colors->color4;?> !important;
    }
    .color5 {
        background: <?php echo $colors->color5;?> !important;
    }

    .text-white:hover, .text-white:active{
        color: #FFFFFF;
    }

    .widget_title::before, .footer-app-link::before {
        background: <?php echo $colors->color4;?> !important;
    }

    .bg_gray::before {
        background: <?php echo $colors->color4;?> !important;
    }

    .rate-container i {
        color: <?php echo $colors->color4;?> !important;
    }

    .rate-container i:hover {
        color: <?php echo $colors->color2;?> !important;
    }

    .product_review_area .product_review .tab-content .tab-pane a:hover, .product_review_area .product_review .tab-content .tab-pane a.active {
        background: <?php echo $colors->color2;?> !important;
    }

    .product_review_area .product_review .nav .nav-item .nav-link.active, .product_review_area .product_review .nav .nav-item .nav-link:hover {
        background: <?php echo $colors->color3;?> !important;
    }

    .account_area .account_btn {
        color: <?php echo $colors->color3;?> !important;
        border: 1px solid <?php echo $colors->color3;?> !important;
    }

    .main-nav .nav > li > a:hover {
        background-color: <?php echo $colors->color3;?> !important;
    }

    .account_area .account_btn:hover {
        background: <?php echo $colors->color2;?> !important;
    }

    .vertical-menu::after {
        position: absolute;
        top: -8px;
        display: inline-block;
        border-right: 7px solid transparent;
        border-bottom: 7px solid <?php echo $colors->color3;?> !important;
        border-left: 7px solid transparent;
        content: '';
        left: 15px;
    }

    .icon-tips b {
        position: absolute;
        display: block;
        height: 0;
        line-height: 0;
        border-width: 6px;
        border-style: solid;
        bottom: -9px;
        left: 0;
        border-color: <?php echo $colors->color3;?> transparent transparent;
        z-index: 1;
    }

    .box-bottom .btn-add-cart a {
        display: inline-block;
        color: #fff;
        font-size: 12px;
        height: 34px;
        line-height: 34px;
        border-radius: 30px;
        text-align: center;
        position: relative;
        overflow: hidden;
        z-index: 3;
        width: 70%;
        font-weight: 600;
        vertical-align: middle;
        background-color: <?php echo $colors->color3;?> !important;
    }

    .main-nav .nav > li.active > a {
        color: #fff;
        background: <?php echo $colors->color3;?> !important;
    }
     .title-widget span::after {
        border-bottom: <?php echo $colors->color3;?> 38px solid !important;
    }

    .btn-add-cart a {
        background-color: <?php echo $colors->color3;?> !important;
    }
    input.loading {
		background: #fff url(<?php echo base_url('assets/website/image/resize.gif')?>) no-repeat center !important;
	}
</style>