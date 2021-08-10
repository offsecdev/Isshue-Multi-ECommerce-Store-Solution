<?php $colors = $this->color_frontends->retrieve_color_editdata('shatu'); ?>
    <style>
        .color1 {
            background: <?php echo $colors->color1;?> !important;
        }

        .color11 {
            color: <?php echo $colors->color1;?> !important;
        }

        .color2 {
            background: <?php echo $colors->color2;?> !important;
        }

        .color22 {
            color: <?php echo $colors->color2;?> !important;
        }

        .color3 {
            background: <?php echo $colors->color3;?> !important;
        }

        .color33 {
            color: <?php echo $colors->color3;?> !important;
        }

        .color4 {
            background: <?php echo $colors->color4;?> !important;
        }

        .color44 {
            color: <?php echo $colors->color4;?> !important;
        }
        .color5 {
            background: <?php echo $colors->color5;?> !important;
            border-bottom: 1px solid <?php echo $colors->color5;?>;
        }

        .style-1 .middleBar .form-control, .style-1 .input-group-addon {
            border-color: <?php echo $colors->color3;?> !important;
        }

        .style-1 .main-nav .nav > li > a:hover {
            background: <?php echo $colors->color2;?> !important;
        }

        .style-1 .slider .slick-prev, .style-1 .slider .slick-next {
            background: <?php echo $colors->color3;?> !important;
        }

        .text-uppercase .active {
            background: <?php echo $colors->color1;?> !important;
        }

        .hover_content > .wishlist {
            background: <?php echo $colors->color4;?> !important;
        }

        .wishlist {
            color: <?php echo $colors->color4;?> !important;
        }
        .comparison {
            color: <?php echo $colors->color4;?> !important;
        }

        .posted-in a {
            color: <?php echo $colors->color3;?> !important;
        }

        .hover_content .nav li a {
            background: <?php echo $colors->color4;?> !important;
        }

        .style-1 .pagination > .active > a {
            background: <?php echo $colors->color4;?> !important;
        }

        .star-rating {
            color: <?php echo $colors->color4;?> !important;
        }

        .rating-wrap {
            color: <?php echo $colors->color4;?> !important;
        }

        .hover-box .nav li a {
            background: <?php echo $colors->color4;?> !important;
            border: <?php echo $colors->color4;?> !important;
        }

        .hover-box .nav li a:hover {
            border-color: <?php echo $colors->color4;?> !important;
        }

        .hover-info .nav li:last-child a {
            background: <?php echo $colors->color4;?> !important;
            border: <?php echo $colors->color3;?> !important;
        }

        .product_slider .item .item_info .item_title2 {
            color: <?php echo $colors->color3;?> !important;
        }

        .sec_title {
            background: <?php echo $colors->color3;?> !important;
        }

        .fa-heart-o, .fa-heart, .glyphicon-star {
            color: #fff !important;
        }

        .glyphicon-star {
            color: <?php echo $colors->color4;?> !important;
        }

        .cart-btn {
            background: <?php echo $colors->color3;?> !important;
        }
    </style>