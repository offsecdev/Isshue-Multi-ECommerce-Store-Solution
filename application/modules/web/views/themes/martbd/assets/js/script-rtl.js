$(document).ready(function () {
    "use strict";

    /*------------------------------------
     On scroll progress bar
     -------------------------------------- */
    $("body").prognroll({
        height: 2, //Progress bar height
        color: "#f2853f", //Progress bar background color
        custom: false //If you make it true, you can add your custom div and see it's scroll progress on the page
    });
    
    //Back to top
    $('.back-top').on('click', function () {
        $('html,body').animate({
            scrollTop: 0
        }, 700);
    });
    /*------------------------------------
     Sticky Menu
     -------------------------------------- */
    var windows = $(window);
    var stick = $(".header-sticky");
    windows.on('scroll', function () {
        var scroll = windows.scrollTop();
        if (scroll < 245) {
            stick.removeClass("sticky");
        } else {
            stick.addClass("sticky");
        }
    });

    /*------------------------------------
     Select Auto Width
     -------------------------------------- */
    $("#cat_option").html($("#product_cat option:selected").text());
    $("#product_cat").width($("#cat_select").width());

    $("#product_cat").change(function () {
        $("#cat_option").html($("#product_cat option:selected").text());
        $(this).width($("#cat_select").width());
    });
    
    $('.select').niceSelect();

    /*------------------------------------
     Mobile Menu
     -------------------------------------- */

    $("#mobile-menu").metisMenu();

    $("#sidebar").mCustomScrollbar({
        theme: "minimal",
        scrollInertia: 100
    });

    $('#dismiss, .overlay').on('click', function () {
        $('#sidebar').removeClass('active');
        $('.overlay').fadeOut();
    });

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').addClass('active');
        $('.overlay').fadeIn();
    });

    /*------------------------------------
     Products slide
     -------------------------------------- */
    $('.slider')
            .on('init', function (slick) {
                $('.slider').css("overflow", "visible");
            })
            .slick({
                dots: true,
                rtl: true
            });

    /*------------------------------------
     Products slide
     -------------------------------------- */
    $('.products-slide')
            .on('init', function (slick) {
                $('.products-slide').css("overflow", "visible");
            })
            .slick({
                dots: false,
                rtl: true,
                infinite: false,
                slidesToShow: 5,
                slidesToScroll: 1,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 4
                        }
                    },
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    }
                ]
            });
    /*------------------------------------
     Band slider
     -------------------------------------- */
    $('.brand-slider').slick({
        rtl: true
    });

    /*------------------------------------
     Band slider2
     -------------------------------------- */
    $('.brand-slider2').slick({
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        centerMode: true,
        variableWidth: true,
        arrows: false,
        rtl: true
    });
    /*------------------------------------
     Variable Width Slider
     -------------------------------------- */
    $('.variable-width').slick({
        infinite: true,
        speed: 300,
        rtl: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        variableWidth: true,
        arrows: false
    });

    /*------------------------------------
     Tooltip
     -------------------------------------- */
    $('[data-toggle="tooltip"]').tooltip();
    /*------------------------------------
     00. Popup Video
     -------------------------------------- */
    $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });

    /*------------------------------------
     Sidebar Scroll
     -------------------------------------- */
    $('.leftSidebar, .content, .rightSidebar')
            .theiaStickySidebar({
                additionalMarginTop: 30
            });

    /*------------------------------------
     Spinner
     -------------------------------------- */
    $(document).on("click", '.number-spinner .qty', function () {
        var btn = $(this),
                oldValue = btn.closest('.number-spinner').find('input').val().trim(),
                newVal = 0;
        if (btn.attr('data-dir') === 'up') {
            newVal = parseInt(oldValue, 10) + 1;
        } else {
            if (oldValue > 1) {
                newVal = parseInt(oldValue, 10) - 1;
            } else {
                newVal = 1;
            }
        }
        btn.closest('.number-spinner').find('input').val(newVal);
    });
    /*------------------------------------
     Vertical Menu dropdown
     -------------------------------------- */
    // Vertical Menu dropdown min-height
    var $vertical_menu = $('.vertical-menu'),
            vertical_menu_height = $vertical_menu.height(),
            header_height = 0,
            menu_min_height = vertical_menu_height - header_height;


    $vertical_menu.find('.dropdown > .dropdown-menu').each(function () {
        $(this).css('min-height', menu_min_height);
    });

    var $list_group = $('.vertical-menu > .list-group-item > .dropdown-menu'),
            list_group_style = $list_group.attr('style'),
            list_group_height = 0;

    $list_group.css({
        visibility: 'hidden',
        display: 'none'
    });

    list_group_height = $list_group.height() + 15;

    $list_group.attr('style', list_group_style ? list_group_style : '');

    $list_group.find('.dropdown-menu').each(function () {
        $(this).css('min-height', list_group_height);
    });

    $('.vertical-menu').on('mouseleave', function () {
        var $this = $(this);
        $this.removeClass('animated-dropdown');
    });
    $('.vertical-menu .menu-item-has-children').on({
        mouseenter: function () {
            var $this = $(this),
                    $dropdown_menu = $this.find('.dropdown-menu'),
                    $vertical_menu = $this.parents('.vertical-menu'),
                    $departments_menu = $this.parents('.departments-menu-dropdown'),
                    css_properties = {
                        width: 540,
                        opacity: 1
                    },
                    animation_duration = 300,
                    $container = '';

            if ($vertical_menu.length > 0) {
                $container = $vertical_menu;
            } else if ($departments_menu.length > 0) {
                $container = $departments_menu;
            }

            if ($this.hasClass('width-md')) {
                css_properties.width = 540;

                if ($departments_menu.length > 0) {
                    css_properties.width = 600;
                }
            } else if ($this.hasClass('width-lg')) {
                css_properties.width = 900;
            } else if ($this.hasClass('width-sm')) {
                css_properties.width = 450;
            } else {
                css_properties.width = 277;
            }

            $dropdown_menu.css({
                visibility: 'visible',
                display: 'block'
            });

            if (!$container.hasClass('animated-dropdown')) {
                $dropdown_menu.animate(css_properties, animation_duration, function () {
                    $container.addClass('animated-dropdown');
                });
            } else {
                $dropdown_menu.css(css_properties);
            }
        },
        mouseleave: function () {
            $(this).find('.dropdown-menu').css({
                visibility: 'hidden',
                opacity: 0,
                width: 0,
                display: 'none'
            });
        }
    });

    /*------------------------------------
     Product Gallery
     -------------------------------------- */

    var zoomOptions = {
        zoomWindowWidth: 450,
        zoomWindowHeight: 458
    };
    $(".main-img-slider").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: false,
        arrows: true,
        speed: 300,
        rtl: true,
        lazyLoad: 'ondemand',
        asNavFor: '.thumb-nav'
    });
    $(".thumb-nav").slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        infinite: false,
        vertical: true,
        centerPadding: '0px',
        asNavFor: '.main-img-slider',
        dots: false,
        centerMode: true,
        draggable: false,
        speed: 200,
        focusOnSelect: true,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4
                }
            },
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 5
                }
            },
            {
                breakpoint: 800,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            }
        ]
    });

    /*------------------------------------
     Product Gallery image popup
     -------------------------------------- */
    //Photoswipe configuration for product page zoom
    var initPhotoSwipeFromDOM = function (gallerySelector) {
        var parseThumbnailElements = function (el) {
            var thumbElements = el.childNodes,
                    numNodes = thumbElements.length,
                    items = [],
                    figureEl,
                    linkEl,
                    size,
                    item;

            for (var i = 0; i < numNodes; i++) {
                figureEl = thumbElements[i]; // <figure> element

                // include only element nodes
                if (figureEl.nodeType !== 1) {
                    continue;
                }

                linkEl = figureEl.children[0]; // <a> element

                size = linkEl.getAttribute("data-size").split("x");

                // create slide object
                item = {
                    src: linkEl.getAttribute("href"),
                    w: parseInt(size[0], 10),
                    h: parseInt(size[1], 10)
                };

                if (figureEl.children.length > 1) {
                    // <figcaption> content
                    item.title = figureEl.children[1].innerHTML;
                }

                if (linkEl.children.length > 0) {
                    // <img> thumbnail element, retrieving thumbnail url
                    item.msrc = linkEl.children[0].getAttribute("src");
                }

                item.el = figureEl; // save link to element for getThumbBoundsFn
                items.push(item);
            }

            return items;
        };

        // find nearest parent element
        var closest = function closest(el, fn) {
            return el && (fn(el) ? el : closest(el.parentNode, fn));
        };

        // triggers when user clicks on thumbnail
        var onThumbnailsClick = function (e) {
            e = e || window.event;
            e.preventDefault ? e.preventDefault() : (e.returnValue = false);

            var eTarget = e.target || e.srcElement;

            // find root element of slide
            var clickedListItem = closest(eTarget, function (el) {
                return el.tagName && el.tagName.toUpperCase() === "FIGURE";
            });

            if (!clickedListItem) {
                return;
            }

            // find index of clicked item by looping through all child nodes
            // alternatively, you may define index via data- attribute
            var clickedGallery = clickedListItem.parentNode,
                    childNodes = clickedListItem.parentNode.childNodes,
                    numChildNodes = childNodes.length,
                    nodeIndex = 0,
                    index;

            for (var i = 0; i < numChildNodes; i++) {
                if (childNodes[i].nodeType !== 1) {
                    continue;
                }

                if (childNodes[i] === clickedListItem) {
                    index = nodeIndex;
                    break;
                }
                nodeIndex++;
            }

            if (index >= 0) {
                // open PhotoSwipe if valid index found
                openPhotoSwipe(index, clickedGallery);
            }
            return false;
        };

        // parse picture index and gallery index from URL (#&pid=1&gid=2)
        var photoswipeParseHash = function () {
            var hash = window.location.hash.substring(1),
                    params = {};

            if (hash.length < 5) {
                return params;
            }

            var vars = hash.split("&");
            for (var i = 0; i < vars.length; i++) {
                if (!vars[i]) {
                    continue;
                }
                var pair = vars[i].split("=");
                if (pair.length < 2) {
                    continue;
                }
                params[pair[0]] = pair[1];
            }

            if (params.gid) {
                params.gid = parseInt(params.gid, 10);
            }

            return params;
        };

        var openPhotoSwipe = function (
                index,
                galleryElement,
                disableAnimation,
                fromURL
                ) {
            var pswpElement = document.querySelectorAll(".pswp")[0],
                    gallery,
                    options,
                    items;

            items = parseThumbnailElements(galleryElement);

            // define options (if needed)
            options = {
                // define gallery index (for URL)
                galleryUID: galleryElement.getAttribute("data-pswp-uid"),

                getThumbBoundsFn: function (index) {
                    // See Options -> getThumbBoundsFn section of documentation for more info
                    var thumbnail = items[index].el.getElementsByTagName("img")[0], // find thumbnail
                            pageYScroll =
                            window.pageYOffset || document.documentElement.scrollTop,
                            rect = thumbnail.getBoundingClientRect();

                    return {x: rect.left, y: rect.top + pageYScroll, w: rect.width};
                }
            };

            // PhotoSwipe opened from URL
            if (fromURL) {
                if (options.galleryPIDs) {
                    // parse real index when custom PIDs are used
                    // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                    for (var j = 0; j < items.length; j++) {
                        if (items[j].pid == index) {
                            options.index = j;
                            break;
                        }
                    }
                } else {
                    // in URL indexes start from 1
                    options.index = parseInt(index, 10) - 1;
                }
            } else {
                options.index = parseInt(index, 10);
            }

            // exit if index not found
            if (isNaN(options.index)) {
                return;
            }

            if (disableAnimation) {
                options.showAnimationDuration = 0;
            }

            // Pass data to PhotoSwipe and initialize it
            gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
            gallery.init();
        };

        // loop through all gallery elements and bind events
        var galleryElements = document.querySelectorAll(gallerySelector);

        for (var i = 0, l = galleryElements.length; i < l; i++) {
            galleryElements[i].setAttribute("data-pswp-uid", i + 1);
            galleryElements[i].onclick = onThumbnailsClick;
        }

        // Parse URL and open gallery if it contains #&pid=3&gid=1
        var hashData = photoswipeParseHash();
        if (hashData.pid && hashData.gid) {
            openPhotoSwipe(hashData.pid, galleryElements[hashData.gid - 1], true, true);
        }
    };
    // execute above function
    initPhotoSwipeFromDOM('.product-images');



    /*------------------------------------
     Price range slide
     -------------------------------------- */
    $(".price-range").ionRangeSlider({
        type: "double",
        grid: true,
        min: 0,
        max: 200,
        from: 50,
        to: 150,
        prefix: "$"
    });

    /*------------------------------------
     Brand category scro;;
     -------------------------------------- */
    $('.brand-cat-scroll').slimScroll({
        height: '205px',
        color: '#cdcdcd',
        railVisible: true,
        alwaysVisible: true,
        railColor: '#f0f0f0',
        railOpacity: 1,
        position: 'left',
        allowPageScroll: true
    });

    /*------------------------------------
     Calculate
     -------------------------------------- */
    /* Set rates + misc */
    var taxRate = 0.05;
    var shippingRate = 15.0;
    var fadeTime = 300;


    $(".product-removal span").click(function () {
        removeItem(this);
    });

    /* Recalculate cart */
    function recalculateCart() {
        var subtotal = 0;

        /* Sum up row totals */
        $(".product-cart-list").each(function () {
            subtotal += parseFloat(
                    $(this)
                    .children(".total-price")
                    .text()
                    );
        });

        /* Calculate totals */
        var tax = subtotal * taxRate;
        var shipping = subtotal > 0 ? shippingRate : 0;
        var total = subtotal + tax + shipping;

        /* Update totals display */
        $(".totals-value").fadeOut(fadeTime, function () {
            $("#cart-subtotal").html(subtotal.toFixed(2));
            $("#cart-tax").html(tax.toFixed(2));
            $("#cart-shipping").html(shipping.toFixed(2));
            $("#cart-total").html(total.toFixed(2));
            if (total === 0) {
                $(".checkout").fadeOut(fadeTime);
            } else {
                $(".checkout").fadeIn(fadeTime);
            }
            $(".totals-value").fadeIn(fadeTime);
        });
    }

    /* Update quantity */
    function updateQuantity(quantityInput) {
        /* Calculate line price */
        var productRow = $(quantityInput)
                .parent()
                .parent();
        var price = parseFloat(productRow.children(".cart-product-price").text());
        var quantity = $(quantityInput).val();
        var linePrice = price * quantity;

        /* Update line price display and recalc cart totals */
        productRow.children(".total-price").each(function () {
            $(this).fadeOut(fadeTime, function () {
                $(this).text(linePrice.toFixed(2));
                recalculateCart();
                $(this).fadeIn(fadeTime);
            });
        });
    }

    /* Remove item from cart */
    function removeItem(removeButton) {
        /* Remove row from DOM and recalc cart total */
        var productRow = $(removeButton)
                .parent()
                .parent();
        productRow.slideUp(fadeTime, function () {
            productRow.remove();
            recalculateCart();
        });
    }

    /*------------------------------------
     Payment collapse
     -------------------------------------- */
    $('.payment-item label').on('click', function (event) {
        if ($(this).next().hasClass('in')) {
            $(this).next().collapse('show');
        } else

        {
            $(this).parents('.payment-block').find('.collapse').collapse('hide');
            $(this).next().collapse('show');
        }

    });

});

/*------------------------------------
 Image Loader
 -------------------------------------- */
window.addEventListener('load', function () {
    var allimages = document.getElementsByTagName('img');
    for (var i = 0; i < allimages.length; i++) {
        if (allimages[i].getAttribute('data-src')) {
            allimages[i].setAttribute('src', allimages[i].getAttribute('data-src'));
        }
    }
}, false);