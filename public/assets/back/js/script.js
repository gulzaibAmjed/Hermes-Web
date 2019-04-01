(function ($) {

    "use strict";


    //Hide Loading Box (Preloader)
    function handlePreloader() {
        if ($('.preloader').length) {
            $('.preloader').delay(1000).fadeOut(500);
        }
    }


    //Change / Update Page Content Height
    function pageHeight() {
        var windowHeight = $(window).height();
        var windowWidth = $(window).width();
        if ($('.page-container').length && (windowHeight > 700)) {
            var pageContainer = $('.page-container');
            $(pageContainer).css('height', windowHeight - 100);
            $(pageContainer).css('margin', '50px auto');
        }

        else if ($('.page-container').length && (windowHeight > 220)) {
            var pageContainer = $('.page-container');
            $(pageContainer).css('height', windowHeight - 30);
            $(pageContainer).css('margin', '15px auto');
        }

        if ($('#sidebar .nav-bar').length && (windowHeight > 700)) {
            var sideBar = $('#sidebar .nav-bar');
            $(sideBar).css('height', windowHeight - 188);
        }

        else if ($('#sidebar .nav-bar').length && (windowHeight > 220)) {
            var sideBar = $('#sidebar .nav-bar');
            $(sideBar).css('height', windowHeight - 118);
        }

        if ($('.right-content .lower-content').length && (windowHeight > 700)) {
            var scrollContent = $('.right-content .lower-content');
            $(scrollContent).css('height', windowHeight - 188);
        }

        else if ($('.right-content .lower-content').length && (windowHeight > 220)) {
            var scrollContent = $('.right-content .lower-content');
            $(scrollContent).css('height', windowHeight - 118);
        }
    }

    //Add Scroll Bar To Content
    if ($('.scroll-box').length) {
        $(".scroll-box").mCustomScrollbar({scrollInertia: 1});
    }

    if ($('.table-section').length) {
        $(".table-section .scroll-box").mCustomScrollbar({scrollInertia: 1});
    }

    //Navbar Toggle
    if ($('#sidebar .nav-bar').length) {
        $("#sidebar .nav-bar .nav-btn").on('click', function () {

            if ($(this).hasClass('active') != true) {
                $('#sidebar .nav-bar .nav-btn').removeClass('active');

            }

            if ($(this).next('.collapse-me').is(':visible')) {
                $(this).removeClass('active');
                $(this).next('.collapse-me').slideUp(500);
            } else {
                $(this).addClass('active');
                $('#sidebar .nav-bar .collapse-me').slideUp(500);
                $(this).next('.collapse-me').slideDown(500);
            }
        });
    }

    //Sidebar Hide / show
    $('.sidebar-toggle').on('click', function () {
        $('.page-container').toggleClass('sidebar-hidden');
        $('#sidebar').toggleClass('back-side');
        $('.sidebar-toggle').toggleClass('sidebar-altered');
    });

    //Update Profile Form Function
    if ($('.content-area .forms').length) {


        $(".content-area .action-btns .edit").on('click', function () {
            $(this).parents('.form-group').addClass('edit-mode');
            $(this).parents('.form-group').find('.disabled').prop('disabled', false);
        });

        $(".content-area .action-btns .reset").on('click', function () {
            $(this).parents('.form-group').removeClass('edit-mode');
            $(this).parents('.form-group').find('.disabled').prop('disabled', true);
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
            if ($('.add-game-files').length) {
                $('.add-game-files').addClass('terms-checked');
            }
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

    if ($('#agreement').length) {
        if ($('#agreement').is(':checked')) {
            $('.add-game-files').addClass('terms-checked');
        }
    }

    //Photo Upoad Function
    if ($('.add-photo #upload-photo').length) {

        var fileInput = $('.add-photo #upload-photo');

        fileInput.change(function () {
            var filename = $('.add-photo #upload-photo');
            $('.add-photo #upload-text').text(filename.val());
        })
    }

    //Game Upoad Function
    if ($('.add-game-files #upload-file').length) {

        var fileInput = $('.add-game-files #upload-file');

        fileInput.change(function () {
            var filename = $('.add-game-files #upload-file');
            $('.add-game-files #upload-file-text').text(filename.val());
        })
    }

    //Add Music File
    if ($('.game-intro #upload-music').length) {
        var fileInput = $('.game-intro #upload-music');
        fileInput.change(function () {
            var filename = $('.game-intro #upload-music');
            $('.game-intro .add-music-file .music-file-name').text(filename.val());
        })
    }

    //Decline Message Detail
    if ($('.table-section .decline').length) {
        $('.table-section .decline').on('click', function (e) {
            var target = $($(this).attr('href'));
            e.preventDefault();
            $('.table-section .decline-message').slideUp(0);
            $(target).slideDown(700);
        });

        $('.table-section .decline-message .close-btn').on('click', function () {
            $('.table-section .decline-message').slideUp(1000);
        });
    }

    //Select Dropdown
    if ($('.sel-box').length) {
        $(".sel-box .sel-btn").on('click', function () {
            $(this).next('.sel-list').fadeToggle(500);
        });
    }

    //Contact Form Validation
    if ($('#contact-form').length) {
        $('#contact-form').validate({// initialize the plugin
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

    /* ==========================================================================
     When document is ready, do
     ========================================================================== */

    $(document).on('ready', function () {
        pageHeight();
    });


    /* ==========================================================================
     When document is resizing, do
     ========================================================================== */

    $(window).on('resize', function () {
        pageHeight();
    });


    /* ==========================================================================
     When document is loading, do
     ========================================================================== */

    $(window).on('load', function () {
        handlePreloader();
    });


})(window.jQuery);

/* ==========================================================================
 Show or hide details of orders
 ========================================================================== */

function seeDetail(id) {
    $('#' + id).toggle();
}

// function customerDetail(id) {
//     $('#' + id).toggle();
// }

function showFilterDiv() {
    $('#div_filter').toggle();
}

/* ==========================================================================
 Expand div details of orders
 ========================================================================== */

function expandTable() {
    //document.getElementById("div_main").className += "expand_view";
    if (document.getElementById("div_main").className == "expand_view") {
        document.getElementById("div_main").className = "main-content";
        document.getElementById("expand_i").className = "fa fa-expand";
    } else {
        document.getElementById("div_main").className = "expand_view";
        document.getElementById("expand_i").className = "fa fa-compress";
    }
}

$(document).on('click','#search_order',function (event) {
$('form[name="filter"]').submit();
});
$(document).on('submit','form[name="filter"]',function (event) {
   event.preventDefault();
   $.ajax({
        type: 'POST',
        url: 'search',
        data: new FormData($('form[name="filter"]')[0]),
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false,
        success: function (data) {
            // successful request; do something with the data
            var content = '<li>הזמנות</li> <span class="fa fa-angle-left"></span><li><a href="dashboard"> &nbsp; הבית </a></li>';
                console.log(data);
            $('#page_path').html(content);
            // $('.table-section').html(data);
            if (data['response'] == RESPONSE_STATUS_SUCCESS) {
                $('.table-section').html(data['data']);
            }else{
                notif({
                msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר..",
                position: "center",
                time: 10000
            });
            }
        },
        error: function (data) {
            // failed request; give feedback to user
            notif({
                msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר..",
                position: "center",
                time: 10000
            });
        }
    }); 
});

function selectCountry(val) {
$("#search-box").val(val);
$("#suggesstion-box").hide();
}

$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');
    var result = url.search('search');
    var page = url.split('page=')[1];
    if (result > 0) {
        getThings(page,1);
    }else{
        getThings(page);
    }
});

// Function to make view of add order...
function addOrderView(customer_id, isAdmin=0) {
    if(customer_id != 'undefined'){
        var string='id='+customer_id;
    }else{
        var string='';
    }
    $.ajax({
        type: 'GET',
        url: 'orders/create',
        data: string,
        beforeSend: function () {
            // this is where we append a loading image
        },
        success: function (data) {
            // successful request; do something with the data
            if(isAdmin==0){
                var content = '<li>הוסף הזמנה</li> <span class="fa fa-angle-left"></span><li><a href="dashboard"> &nbsp; הבית </a></li>';
                $('#page_path').html(content);
                if (data['response'] == RESPONSE_STATUS_SUCCESS) {
                    $('.content-area').html(data['view']);
                }else{
                    notif({
                        msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר..",
                        position: "center",
                        time: 10000
                    });
                }    
            }else{
                if (data['response'] == RESPONSE_STATUS_SUCCESS) {
                    $('.table-section').html(data['view']);
                }else{
                    notif({
                        msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר..",
                        position: "center",
                        time: 10000
                    });
                }
            }
            

        },
        error: function (data) {
            // failed request; give feedback to user
            notif({
                msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר..",
                position: "center",
                time: 10000
            });
        }
    });
}
