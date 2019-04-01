(function ($) {

    "use strict";


    //Hide Loading Box (Preloader)
    function handlePreloader() {
        if ($('.preloader').length) {
            $('.preloader').delay(1000).fadeOut(500);
        }
    }


    //Change Main slider Height
    function sliderHeight() {
        var windowHeight = $(window).height();
        var windowWidth = $(window).width();
        if ($('.main-slider').length && (windowWidth > 840)) {
            var topBanner = $('.main-slider').height();
            if (topBanner < windowHeight) {
                $('.main-slider .slide-item,.main-slider .bx-viewport').css('height', windowHeight);
            }
        }
    }

    //Go to Top Button
    if ($('.go-to-top').length) {
        var windowpos = $(window).scrollTop();
        if (windowpos >= 400) {
            $('.go-to-top').fadeIn(300);
        } else {
            $('.go-to-top').fadeOut(300);
        }
    }


    //Hide Loading Box (Preloader)
    function handlePreloader() {
        if ($('.preloader').length) {
            $('.preloader').delay(500).fadeOut(500);
        }
    }


    //Main Slider
    $('.main-slider .slider').bxSlider({
        adaptiveHeight: true,
        auto: true,
        controls: false,
        mode: 'fade',
        pause: 7000,
        speed: 1000,
        pager: false,
        onSlideAfter: function (currentSlideNumber, totalSlideQty, currentSlideHtmlObject) {
            console.log(currentSlideHtmlObject);
            $('.main-slider .active-slide').removeClass('active-slide');
            $('.main-slider .slider .slide-item').eq(currentSlideHtmlObject).addClass('active-slide')
        },
        onSliderLoad: function () {
            $('.main-slider .slider .slide-item').eq().addClass('active-slide')
        }
    });


    //What We Do Slider
    if ($('#what-we-do .slider').length) {
        $('#what-we-do .slider').owlCarousel({
            items: 3,
            loop: true,
            autoplay: true,
            margin: 80,
            nav: false,
            responsive: {
                0: {
                    items: 1
                },
                480: {
                    items: 1
                },
                600: {
                    items: 2
                },
                768: {
                    items: 2
                },
                1024: {
                    items: 3
                },
                1200: {
                    items: 3
                }

            }
        });
    }

    //About Us Image Slider
    if ($('#about-us .image-slider').length) {
        $('#about-us .image-slider').owlCarousel({
            items: 1,
            singleItem: true,
            loop: false,
            autoplay: true,
            margin: 0,
            nav: false,
            singleItem: true,
                    transitionStyle: "fade"
        });
    }

    //Team Members Slider
    if ($('.team-members .slider').length) {
        $('.team-members .slider').owlCarousel({
            items: 3,
            loop: false,
            autoplay: true,
            margin: 50,
            nav: true,
            responsive: {
                0: {
                    items: 1,
                    autoplay: true
                },
                480: {
                    items: 1,
                    autoplay: true
                },
                600: {
                    items: 1,
                    autoplay: true
                },
                768: {
                    items: 2
                },
                1024: {
                    items: 2
                },
                1200: {
                    items: 3
                }

            }
        });
    }


    //Show Member Detail
    if ($('.team-members .member').length) {
        $('.team-members .member .overlay').on('click', function (e) {
            var target = $($(this).attr('href'));
            e.preventDefault();
            $('#about-us .member-detail').slideUp(0);
            $(target).slideDown(700);

            $('html, body').animate({
                scrollTop: $(target).offset().top
            }, 1000);
        });

        $('#about-us .member-detail .close-btn').on('click', function () {
            $('#about-us .member-detail').slideUp(1000);
        });
    }


    //Testimonils Slider
    if ($('#client-testimonials .slider').length) {
        $('#client-testimonials .slider').owlCarousel({
            items: 2,
            loop: true,
            autoplay: true,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                480: {
                    items: 1
                },
                600: {
                    items: 1
                },
                768: {
                    items: 1
                },
                1024: {
                    items: 2
                },
                1200: {
                    items: 2
                }

            }
        });
    }

    //Client Logos / Sponsors Slider
    if ($('#client-logos .slider').length) {
        $('#client-logos .slider').owlCarousel({
            items: 6,
            loop: true,
            autoplay: true,
            margin: 30,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                480: {
                    items: 2
                },
                600: {
                    items: 3
                },
                768: {
                    items: 3
                },
                1024: {
                    items: 5
                },
                1200: {
                    items: 6
                }

            }
        });
    }

    //customer  signin validation
    /*	if($('#signIn').length){
     $('#signIn').validate({ // initialize the plugin
     rules: {
     password: {
     required: true
     },
     email: {
     required: true,
     email: true
     }
     }
     });
     }*/

    /*	//customer  signup validation
     if($('#register').length){
     $('#register').validate({ // initialize the plugin
     rules: {
     company_name: {
     required: true
     },
     email: {
     required: true,
     email: true
     },
     uthrize_name: {
     required: true
     },
     address: {
     required: true
     },
     website: {
     required: true
     },
     password: {
     required: true
     },
     contact_number: {
     required: true
     }
     }
     });
     }*/


    //Contact Form Validation
    if ($('#contact-form-bottom').length) {
        $('#contact-form-bottom').validate({// initialize the plugin
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                message: {
                    required: true
                }
            },
            submitHandler: function (form) {
                notif({
                    type: "info",
                    msg: "Message Sent",
                    position: "center",
                    width: "all",
                    autohide: false,
                    multiline: true
                });
                return true;
            }
        });
    }

    // Scroll Down
    if ($('.scroll-down').length) {
        $(".scroll-down").on('click', function () {
            var target = $($(this).attr('data-id'));
            // animate
            $('html, body').animate({
                scrollTop: $(target).offset().top
            }, 1000);

        });
    }


    // Elements Animation
    if ($('.wow').length) {
        var wow = new WOW({
            mobile: true
        });
        wow.init();
    }

    //Signup Form Hide Show
    if ($('.sign-up').length) {
        $('.sign-up .toggle-btn').on('click', function (e) {
            $(this).toggleClass('in-visible');
            $(this).next('.toggle-box').slideToggle(700);
        });
    }

    // Google Map Settings Small
    if ($('#location-map').length) {
        var map;
        map = new GMaps({
            el: '#location-map',
            zoom: 18,
            scrollwheel: false,
            //Set Latitude and Longitude Here
            lat: -37.817085,
            lng: 144.955631
        });

        //Add map Marker
        map.addMarker({
            lat: -37.817085,
            lng: 144.955631,
            infoWindow: {
                content: '<p style="color:#3b3b3b; font-size:15px;">No.28 - 63739 street lorem ipsum City, Country</p>'
            }

        });
    }

    // Google Map Settings Big
    if ($('#location-map').length) {
        var map;
        map = new GMaps({
            el: '#location-map-big',
            zoom: 18,
            scrollwheel: false,
            //Set Latitude and Longitude Here
            lat: -37.817085,
            lng: 144.955631
        });

        //Add map Marker
        map.addMarker({
            lat: -37.817085,
            lng: 144.955631,
            infoWindow: {
                content: '<p style="color:#3b3b3b; font-size:15px;">No.28 - 63739 street lorem ipsum City, Country</p>'
            }

        });
    }

    //Popup Hide Show
    if ($('.has-popup').length) {
        $('.has-popup').on('click', function (e) {
            e.preventDefault();
            var target = $($(this).attr('data-id'));
            $('.popup-layer').addClass('filled');
            $('html, body').animate({
                scrollTop: $('html').offset().top
            }, 500);
            $(this).prev('input[type="checkbox"]').prop('checked', true);
            $(target).delay(500).addClass('is-visible');
            $(target).delay(500).fadeIn(500);


            var windowHeight = $(window).height();
            target.css('height', windowHeight);

        });

        $('.close-popup').on('click', function (e) {
            $('.popup-container').fadeOut(500);
            $('.popup-container').css('padding-top', '15px');
            $('.popup-container').removeClass('is-visible');
            $('.popup-layer').delay(500).removeClass('filled');
        });
    }

    /* ==========================================================================
     When document is ready, do
     ========================================================================== */

    $(document).on('ready', function () {
        sliderHeight();
    });


    /* ==========================================================================
     When document is resizing, do
     ========================================================================== */

    $(window).on('resize', function () {
        //sliderHeight();
    });


    /* ==========================================================================
     When document is loading, do
     ========================================================================== */

    $(window).on('load', function () {
        handlePreloader();
    });


})(window.jQuery);