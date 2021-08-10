(function($){
    'use strict'; 
    
    $(window).on('load', function(){
        
        // Hide Loading Box (Preloader)
        $('.preloader').delay(300).fadeOut('slow');
        $('body').delay(300).css({'overflow':'visible'});
        
        // owl slider
        $('.main_slider').owlCarousel({
            loop:true,
            margin: 15,
            nav : true,
            autoplay: true,
            items: 1,
            animateOut: 'fadeOut',
            navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>']
        }); 
        
        // owl slider
        $('.top_deals').owlCarousel({
            nav: true,
            autoplay: true,
            items: 1,
            navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>']
        }); 
        
        // owl slider
        $('.product_slider').owlCarousel({
            margin: 15,
            nav: true,
            autoplay: true,
            items: 5,
            navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
            responsive:{
                0:{
                    items:1
                },
                460:{
                    items:2
                },
                768:{
                    items:3
                },
                992:{
                    items:4
                },
                1150:{
                    items:5
                }
            }
        }); 
        
        // owl slider
        $('.product2_slider').owlCarousel({
            margin: 25,
            nav: true,
            autoplay: true,
            items: 4,
            navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
            responsive:{
                0:{
                    items:1
                },
                460:{
                    items:2
                },
                768:{
                    items:3
                },
                992:{
                    items:4
                }
            }
        }); 
        
        // Owl carousel slider
        $('.category_slider').owlCarousel({
            margin: 10,
            nav:true,
            items: 4, 
            autoplay: true,
            navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
            responsive:{
                0:{
                    items:1
                },
                460:{
                    items:2
                },
                1150:{
                    items:4
                }
            }
        });
        
        // Owl carousel slider
        $('.category2_slider').owlCarousel({
            margin: 20,
            nav:true,
            items: 3, 
            autoplay: true,
            navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
            responsive:{
                0:{
                    items:1
                },
                480:{
                    items:2
                },
                768:{
                    items:1
                },
                992:{
                    items:2
                },
                1200:{
                    items:3
                }
            }
        });
        
        // Client slider Owl carousel 
        $('.client_slider').owlCarousel({
            margin: 10,
            items: 8, 
            autoplay: true,
            navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
            responsive:{
                0:{
                    items:3
                },
                460:{
                    items:4
                },
                992:{
                    items:6
                },
                1150:{
                    items:8
                }
            }
        });
        
        
        // Mobile Menu
        $("#open").on('click',function(){
            $("#mySidenav").animate({width: "280px"});
        });
        $("#close").on('click',function(){
            $("#mySidenav").animate({width: "0"});
        });
        $(".menu-link").on('click',function(){
            $(this).siblings().toggle();
        });

        
        // Select Menu
        $( "#select_language").selectmenu({
            width: 80,
            icons: { button: "ui-icon-caret-1-s"}
        });
        $( "#select_currency").selectmenu({
            width: 60,
            icons: { button: "ui-icon-caret-1-s" }
        });
        $( "#select_category").selectmenu({
            width: 130,
            icons: { button: "ui-icon-caret-1-s" }
        });
        $( "#select_size").selectmenu({
            width: 80,
            icons: { button: "ui-icon-caret-1-s" }
        });
        
        // EasyZoom
        $('.easyzoom').easyZoom();
        
    });
    
    
    // Back to top js
    var offset = 100,
        offset_opacity = 1200,
        scroll_top_duration = 1500,
        $back_to_top = $('.cd-top');

    $(window).on('scroll', function(){
        ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
        if( $(this).scrollTop() > offset_opacity ) { 
            $back_to_top.addClass('cd-fade-out');
        }
    });

    //smooth scroll to top
    $back_to_top.on('click', function(event){
        event.preventDefault();
        $('body,html').animate({
            scrollTop: 0 ,
            }, scroll_top_duration
        );
    });
    
    // Countdown JS
    $('.counter').dsCountDown({
        endDate: new Date("December 13, 2019 11:13:00")
    });
    
    // Sticky Menu
    $(window).on('scroll', function() {
        if ($(window).scrollTop() > 100) {
            $('.header_main').addClass('menu_fixed');
        } else {
            $('.header_main').removeClass('menu_fixed');
        }
    });
        
    // Lightbox 
    lightbox.option({
        'showImageNumberLabel': false,  
    })
    
    //  WoW JS 
    new WOW().init();


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
        
    
})(jQuery);   