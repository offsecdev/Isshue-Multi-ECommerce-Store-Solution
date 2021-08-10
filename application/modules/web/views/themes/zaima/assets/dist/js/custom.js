/* Template Name: Isshue
 Author: Bdtask
 E-mail: bdtask@gmail.com
 Created: September 2020
 Version: 1.0
 Updated: September 2020
 File Description: Main JS file of the template
 */
(function ($) {
    "use strict";
    var bdtask = {
        initialize: function () {
            this.stickyNavbar();
            this.stuckNavbarMenuToggle();
            this.multilevelDropdown();
            this.dropdown();
            this.navbarCollapseHide();
            this.selectAutoWidth();
            this.brandLogo();
            this.featureCategory();
            this.heroSlider();
            this.productGallery();
            this.productGalleryImagePopup();
            this.dataFilter();
            this.toTop();
            this.raty();
            this.tooltip();
            this.togglePassword();
            this.popupYoutube();
            this.theiaStickySidebar();
            this.sidebarFilters();
            this.inputSpinner();
            this.disableDropdownAutohide();
            this.featherIcon();
            this.debitCreditCard();
        },
        stickyNavbar: function () {
            var t = document.querySelector(".navbar-sticky");
            if (null !== t) {
                var r = t.offsetHeight;
                window.addEventListener("scroll", function (e) {
                    400 < e.currentTarget.pageYOffset
                            ? (t.classList.contains("navbar-transparent") || (document.body.style.paddingTop = r + "px"), t.classList.add("navbar-stuck"))
                            : ((document.body.style.paddingTop = ""), t.classList.remove("navbar-stuck"));
                });
            }
        },
        stuckNavbarMenuToggle: function () {
            var e = document.querySelector(".navbar-stuck-toggler"),
                    t = document.querySelector(".navbar-stuck-menu");
            null !== e &&
                    e.addEventListener("click", function (e) {
                        t.classList.toggle("show"), e.preventDefault();
                    });
        },
        multilevelDropdown: function () {
            $(".dropdown-menu a.dropdown-toggle").on("click", function (e) {
                var $el = $(this);
                $el.toggleClass("active-dropdown");
                var $parent = $(this).offsetParent(".dropdown-menu");
                if (!$(this).next().hasClass("show")) {
                    $(this).parents(".dropdown-menu").first().find(".show").removeClass("show");
                }
                var $subMenu = $(this).next(".dropdown-menu");
                $subMenu.toggleClass("show");
                $(this).parent("li").toggleClass("show");
                $(this)
                        .parents("li.nav-item.dropdown.show")
                        .on("hidden.bs.dropdown", function (e) {
                            $(".dropdown-menu .show").removeClass("show");
                            $el.removeClass("active-dropdown");
                        });
                if (!$parent.parent().hasClass("navbar-nav")) {
                    $el.next().css({top: $el[0].offsetTop, left: $parent.outerWidth() - 4});
                }
                return false;
            });
        },
        dropdown: function () {
            $(".dropdown").on("show.bs.dropdown", function (e) {
                $(this).find(".dropdown-menu").first().stop(true, true).slideDown(250);
            });
            $(".dropdown").on("hide.bs.dropdown", function (e) {
                $(this).find(".dropdown-menu").first().stop(true, true).slideUp(250);
            });
        },
        navbarCollapseHide: function () {
            $(".navbar-collapse .collapse-close").on("click", function () {
                $(".navbar-collapse").collapse("hide");
            });
        },
        selectAutoWidth: function () {
            $("#cat_option").html($("#product_cat option:selected").text());
            $("#product_cat").width($("#cat_select").width());
            $("#product_cat").change(function () {
                $("#cat_option").html($("#product_cat option:selected").text());
                $(this).width($("#cat_select").width());
            });
        },
        brandLogo: function () {
            $(".brand-logo").owlCarousel({
                loop: true,
                dots: false,
                margin: 30,
                autoplay: true,
                nav: true,
                navText: ["<i class='ti-angle-left'></i>", "<i class='ti-angle-right'></i>"],
                autoplayTimeout: 2000,
                autoplayHoverPause: true,
                responsive: {0: {items: 1}, 600: {items: 3}, 1000: {items: 4}, 1250: {items: 6}}
            });
        },
        featureCategory: function () {
            $(".feature-category").owlCarousel({
                items: 1,
                loop: true,
                dots: false,
                margin: 30,
                nav: true,
                navText: ["<i class='ti-angle-left'></i>", "<i class='ti-angle-right'></i>"],
                autoplay: false,
            });
        },
        heroSlider: function () {
            var slider_preloader_status = $(".slider_preloader_status");
            var slider_preloader = $(".slider_preloader");
            var header_slider = $(".header-slider");
            slider_preloader_status.fadeOut();
            slider_preloader.delay(350).fadeOut("slow");
            header_slider.removeClass("header-slider-preloader");
            $(".animation-slide").owlCarousel({
                items: 1,
                loop: true,
                autoplay: true,
                dots: true,
                nav: true,
                autoplayTimeout: 7000,
                navText: ["<i data-feather='arrow-left'></i>", "<i data-feather='arrow-right'></i>"],
                animateIn: "fadeIn",
                animateOut: "fadeOut",
                autoplayHoverPause: false,
                touchDrag: true,
                mouseDrag: true,
                autoHeight:true,
                responsive: {0: {nav: false}, 1340: {nav: true}}
            });
            $(".animation-slide").on("translate.owl.carousel", function () {
                $(this).find(".owl-item .slide-text > *").removeClass("fadeInUp animated").css("opacity", "0");
                $(this).find(".owl-item .slide-img").removeClass("fadeInRight animated").css("opacity", "0");
            });
            $(".animation-slide").on("translated.owl.carousel", function () {
                $(this).find(".owl-item.active .slide-text > *").addClass("fadeInUp animated").css("opacity", "1");
                $(this).find(".owl-item.active .slide-img").addClass("fadeInRight animated").css("opacity", "1");
            });
        },
        productGallery: function () {
            
            $(".main-img-slider").slick({slidesToShow: 1, slidesToScroll: 1, infinite: false, arrows: true, speed: 300, lazyLoad: "ondemand", asNavFor: ".thumb-nav"});
            $(".thumb-nav").slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                infinite: false,
                vertical: true,
                centerPadding: "0px",
                asNavFor: ".main-img-slider",
                dots: false,
                centerMode: true,
                draggable: false,
                speed: 200,
                focusOnSelect: true,
                responsive: [
                    {breakpoint: 1200, settings: {slidesToShow: 4, slidesToScroll: 4}},
                    {breakpoint: 1024, settings: {slidesToShow: 5, slidesToScroll: 5}},
                    {breakpoint: 800, settings: {slidesToShow: 3, slidesToScroll: 3}},
                    {breakpoint: 600, settings: {slidesToShow: 2, slidesToScroll: 2}},
                    {breakpoint: 480, settings: {slidesToShow: 3, slidesToScroll: 3}}
                ]
            });
            var zoomOptions = {zoomWindowWidth: 670, zoomWindowHeight: 512};
                $(".main-img-slider .slick-current img").elevateZoom(zoomOptions);
                $(".main-img-slider").on("beforeChange", function (
                        event,
                        slick,
                        currentSlide,
                        nextSlide
                        ) {
                    $.removeData(currentSlide, "elevateZoom");
                    $(".zoomContainer").remove();
                });
                $(".main-img-slider").on("afterChange", function () {
                    $(".main-img-slider .slick-current img").elevateZoom(zoomOptions);
                });


            function filter(key) {
                $(".main-img-slider, .thumb-nav").slick("slickUnfilter");
                if (typeof key === "string") {
                    $(".main-img-slider, .thumb-nav").slick("slickFilter", `div[data-color="${key}"]`);
                }
                $(".main-img-slider, .thumb-nav").slick("refresh");
            }
            $(".main-img-slider").on("afterChange", function (event, slick, currentSlide, nextSlide) {
                $(".thumb-nav .slick-slide").removeClass("slick-current");
                $(".thumb-nav .slick-slide:not(.slick-cloned)").eq(currentSlide).addClass("slick-current");
            });
        },
        productGalleryImagePopup: function () {
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
                        figureEl = thumbElements[i];
                        if (figureEl.nodeType !== 1) {
                            continue;
                        }
                        linkEl = figureEl.children[0];
                        size = linkEl.getAttribute("data-size").split("x");
                        item = {src: linkEl.getAttribute("href"), w: parseInt(size[0], 10), h: parseInt(size[1], 10)};
                        if (figureEl.children.length > 1) {
                            item.title = figureEl.children[1].innerHTML;
                        }
                        if (linkEl.children.length > 0) {
                            item.msrc = linkEl.children[0].getAttribute("src");
                        }
                        item.el = figureEl;
                        items.push(item);
                    }
                    return items;
                };
                var closest = function closest(el, fn) {
                    return el && (fn(el) ? el : closest(el.parentNode, fn));
                };
                var onThumbnailsClick = function (e) {
                    e = e || window.event;
                    e.preventDefault ? e.preventDefault() : (e.returnValue = false);
                    var eTarget = e.target || e.srcElement;
                    var clickedListItem = closest(eTarget, function (el) {
                        return el.tagName && el.tagName.toUpperCase() === "FIGURE";
                    });
                    if (!clickedListItem) {
                        return;
                    }
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
                        openPhotoSwipe(index, clickedGallery);
                    }
                    return false;
                };
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
                var openPhotoSwipe = function (index, galleryElement, disableAnimation, fromURL) {
                    var pswpElement = document.querySelectorAll(".pswp")[0],
                            gallery,
                            options,
                            items;
                    items = parseThumbnailElements(galleryElement);
                    options = {
                        galleryUID: galleryElement.getAttribute("data-pswp-uid"),
                        getThumbBoundsFn: function (index) {
                            var thumbnail = items[index].el.getElementsByTagName("img")[0],
                                    pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                                    rect = thumbnail.getBoundingClientRect();
                            return {x: rect.left, y: rect.top + pageYScroll, w: rect.width};
                        }
                    };
                    if (fromURL) {
                        if (options.galleryPIDs) {
                            for (var j = 0; j < items.length; j++) {
                                if (items[j].pid === index) {
                                    options.index = j;
                                    break;
                                }
                            }
                        } else {
                            options.index = parseInt(index, 10) - 1;
                        }
                    } else {
                        options.index = parseInt(index, 10);
                    }
                    if (isNaN(options.index)) {
                        return;
                    }
                    if (disableAnimation) {
                        options.showAnimationDuration = 0;
                    }
                    gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
                    gallery.init();
                };
                var galleryElements = document.querySelectorAll(gallerySelector);
                for (var i = 0, l = galleryElements.length; i < l; i++) {
                    galleryElements[i].setAttribute("data-pswp-uid", i + 1);
                    galleryElements[i].onclick = onThumbnailsClick;
                }
                var hashData = photoswipeParseHash();
                if (hashData.pid && hashData.gid) {
                    openPhotoSwipe(hashData.pid, galleryElements[hashData.gid - 1], true, true);
                }
            };
            initPhotoSwipeFromDOM(".product-images");
        },
        dataFilter: function () {
            var e = document.querySelector('[data-filter="trigger"]'),
                    n = document.querySelectorAll('[data-filter="target"]');
            null !== e &&
                    e.addEventListener("change", function () {
                        var e = this.options[this.selectedIndex].value.toLowerCase();
                        if ("all" === e)
                            for (var t = 0; t < n.length; t++)
                                n[t].classList.remove("d-none");
                        else {
                            for (var r = 0; r < n.length; r++)
                                n[r].classList.add("d-none");
                            document.querySelector("#" + e).classList.remove("d-none");
                        }
                    });
        },
        toTop: function () {
            $("body").append('<div id="toTop" class="btn-top rounded position-fixed text-center"><i class="ti-upload"></i></div>');
            $(window).scroll(function () {
                if ($(this).scrollTop() !== 0) {
                    $("#toTop").fadeIn();
                } else {
                    $("#toTop").fadeOut();
                }
            });
            $("#toTop").on("click", function () {
                $("html, body").animate({scrollTop: 0}, 600);
                return false;
            });
        },
        raty: function () {
            var theme_url = $("#theme_url").val();
            $.fn.raty.defaults.path = theme_url +"/assets/plugins/raty/lib/images";
            $(function () {
                $("#rating").raty({score: 3});
            });
        },
        tooltip: function () {
            $('[data-toggle="tooltip"]').tooltip();
        },
        togglePassword: function () {
            $(".password + .far").on("click", function () {
                $(this).toggleClass("fa-eye").toggleClass("fa-eye-slash");
                $(".password").togglePassword();
            });
        },
        popupYoutube: function () {
            $(".popup-youtube").magnificPopup({type: "iframe", mainClass: "mfp-fade", removalDelay: 160, preloader: false, fixedContentPos: true});
        },
        theiaStickySidebar: function () {
            $(".leftSidebar, .mainContent, .rightSidebar").theiaStickySidebar({additionalMarginTop: 10});
        },
        sidebarFilters: function () {
            $(".layer, .filters-close").on("click", function () {
                $(".filters-mobile").removeClass("show");
                $(".layer").removeClass("layer-is-visible");
            });
            $(".btn_filters_mobile").on("click", function () {
                $(".filters-mobile").addClass("show");
                $(".layer").addClass("layer-is-visible");
                $(".collapse.in").toggleClass("in");
            });
        },
        inputSpinner: function () {
            $(".num-in span").click(function () {
                var $input = $(this).parents(".num-block").find("input.in-num");
                if ($(this).hasClass("minus")) {
                    var count = parseFloat($input.val()) - 1;
                    count = count < 1 ? 1 : count;
                    if (count < 2) {
                        $(this).addClass("dis");
                    } else {
                        $(this).removeClass("dis");
                    }
                    $input.val(count);
                } else {
                    var count = parseFloat($input.val()) + 1;
                    $input.val(count);
                    if (count > 1) {
                        $(this).parents(".num-block").find(".minus").removeClass("dis");
                    }
                }
                $input.change();
                return false;
            });
        },
        disableDropdownAutohide: function () {
            for (var e = document.querySelectorAll(".disable-autohide .custom-select"), t = 0; t < e.length; t++)
                e[t].addEventListener("click", function (e) {
                    e.stopPropagation();
                });
        },
        featherIcon: function () {
            feather.replace();
        },
        debitCreditCard: function () {
            var e = document.querySelector(".credit-card");
            if (null !== e)
                new Card({form: e, container: ".card-wrapper"});

        }
    };
    $(document).ready(function () {
        bdtask.initialize();
    });
})(jQuery);
