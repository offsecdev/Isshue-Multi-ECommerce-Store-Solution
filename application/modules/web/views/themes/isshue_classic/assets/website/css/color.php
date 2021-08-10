<!-- dynamic template color  -->
<?php $colors = $this->color_frontends->retrieve_color_editdata('isshue_classic'); ?>
<style>
    .color1 {
        background: <?php echo $colors->color1;?> !important;
    }

    .color2 {
        background: <?php echo $colors->color2;?> !important;
    }

    .color3 {
        background: <?php echo $colors->color3;?> !important;
    }

    .color35 {
        color: <?php echo $colors->color3;?> !important;
    }

    .color4 {
        background: <?php echo $colors->color4;?> !important;
    }

    .color5 {
        color: <?php echo $colors->color4;?> !important;
    }
    .color5_topbar {
        background: <?php echo $colors->color5;?> !important;
    }

    .widget_title::before {
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

    .account_area .account_btn:hover {
        background: <?php echo $colors->color2;?> !important;
    }

    .slider_style .owl-nav .owl-next:hover {
        background: <?php echo $colors->color2;?> !important;
        color: #fff;
    }

    .slider_style .owl-nav .owl-prev, .slider_style .owl-nav .owl-next {
        border-color: 1px solid <?php echo $colors->color2;?> !important;
    }

    .slider_style .owl-nav .owl-prev:hover {
        background: <?php echo $colors->color2;?> !important;
        color: #fff;
    }

    .category_menu a:hover {
        background: <?php echo $colors->color2;?> !important;
        color: #fff;
    }

    .category_menu .cat_sub_menu a:hover {
        background: transparent !important;
    }

    .slider_style .item .item_hover .nav li a {
        color: <?php echo $colors->color2;?> !important;
    }

    .best_sale .single_product .media-body a:hover {
        color: <?php echo $colors->color3;?> !important;
    }

    .price_range .ui-slider .ui-slider-range {
        background: <?php echo $colors->color3;?> !important;
    }

    .header_top .header_top_inner .connect_area .connectus a:hover {
        color: <?php echo $colors->color3;?> !important;
    }

    .category_menu .dropdown-menu ul li .cat_sub_menu a:hover {
        color: <?php echo $colors->color3;?> !important;
    }
    input.loading {
        background: #fff url(<?php echo base_url('assets/website/image/resize.gif')?>) no-repeat center !important;
    }

</style>