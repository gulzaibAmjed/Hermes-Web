<!DOCTYPE html>

<html>

    <head>

        <meta charset="utf-8">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- <title>Group Hermes | Add Order</title> -->

        @yield('title')

        <!-- Stylesheets -->

        <link href="{{asset('/assets/back/css/bootstrap.css')}}" rel="stylesheet">

        <link href="{{asset('/assets/back/css/style.css')}}" rel="stylesheet">

        <link href="{{asset('/assets/back/css/scrollbar.css')}}" rel="stylesheet">

        <!-- Responsive -->

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

        <meta name="_token" content="{{ csrf_token() }}">

        <link href="{{asset('/assets/back/css/responsive.css')}}" rel="stylesheet">

        <link href="{{asset('/assets/back/css/timepicki.css')}}" rel="stylesheet">

        <!-- Alertify Includes -->

        <link rel="stylesheet" href="{{asset('/assets/alertify/alertify.min.css')}}">

        <link rel="stylesheet" href="{{asset('/assets/alertify/semantic.min.css')}}">

        <!-- notifIt! Includes -->

        <link rel="stylesheet" href="{{asset('/assets/notifIt/css/notifIt.css')}}">

        <link rel="stylesheet" href="{{asset('/assets/back/css/select2.min.css')}}">

        <link rel="stylesheet" href="{{asset('/assets/back/css/fm.datetator.jquery.css')}}">

        <link rel="stylesheet" href="{{asset('/assets/back/css/timeTo.css')}}">

        @yield('styles')
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async='async'></script>
<script>
//    var OneSignal = OneSignal || [];
//    OneSignal.push(["init", {
//      appId: "4573aa0c-dac2-4bba-82fc-3b4129c83666",
//      autoRegister: false, /* Set to true to automatically prompt visitors */
//      subdomainName: 'hermes.onesignal.com',
//      notifyButton: {
//          enable: true /* Set to false to hide */
//      }
//    }]);
var OneSignal = OneSignal || [];
OneSignal.push(["init", {
    /* Your other init options here */
    appId: "4573aa0c-dac2-4bba-82fc-3b4129c83666",
          autoRegister: false, /* Set to true to automatically prompt visitors */
          subdomainName: 'hermes.onesignal.com',
          notifyButton: {
        enable: true, /* Required to use the notify button */
        size: 'medium', /* One of 'small', 'medium', or 'large' */
        theme: 'default', /* One of 'default' (red-white) or 'inverse" (white-red) */
        position: 'bottom-right', /* Either 'bottom-left' or 'bottom-right' */
        offset: {
                    bottom: '100px',
                    left: '0px', /* Only applied if bottom-left */
                    right: '30px' /* Only applied if bottom-right */
                },
        prenotify: true, /* Show an icon with 1 unread message for first-time site visitors */
        showCredit: false, /* Hide the OneSignal logo */
        text: {
            'tip.state.unsubscribed': 'Subscribe to notifications',
            'tip.state.subscribed': "You're subscribed to notifications",
            'tip.state.blocked': "You've blocked notifications",
            'message.prenotify': 'Click to subscribe to notifications',
            'message.action.subscribed': "Thanks for subscribing!",
            'message.action.resubscribed': "You're subscribed to notifications",
            'message.action.unsubscribed': "You won't receive notifications again",
            'dialog.main.title': 'Manage Site Notifications',
            'dialog.main.button.subscribe': 'SUBSCRIBE',
            'dialog.main.button.unsubscribe': 'UNSUBSCRIBE',
            'dialog.blocked.title': 'Unblock Notifications',
            'dialog.blocked.message': "Follow these instructions to allow notifications:"
        }
    }
}]);
OneSignal.push(["sendTags", {email: "{{\Illuminate\Support\Facades\Auth::user()->email}}", role: "{{\Illuminate\Support\Facades\Auth::user()->role}}",id: "{{\Illuminate\Support\Facades\Auth::user()->id}}" }]);
OneSignal.push(function() {
  OneSignal.on('subscriptionChange', function(isSubscribed) {
    if (isSubscribed) {
      OneSignal.getUserId(function(userId) {
            $.ajax({
                type: 'POST',
                url: 'notification/subscription',
                data: {"id": userId},
                success: function (data) {
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
    }
  });
});


</script>



    </head>

  

    <body>

        <div class="page-wrapper">

            <div class="page-container">

                <div class="preloader"></div>

                @include('includes.sidebar')

                <div class="right-content">

                    @include('includes.header')

                    <div class="lower-content scroll-box ">

                        <!--Page Location-->

                        <ul class="page-location clearfix text_align_right" id="page_path">

                            <!-- <li>Add Order</li> <span class="fa fa-angle-left"></span>  -->

                            <li><a href="/dashboard"> &nbsp; עמוד הבית</a></li>

                            @yield('location')

                        </ul>

                        <div class="main-content">

                            <header class="page-title clearfix ">

                                <h3 class="prof-id pull-right">@yield('current-location')</h3>

                            </header>

                            <div class="content-area">

                                @yield('content')

                            </div>

                        </div>

                    </div>

                </div>

            </div>    

        </div>



        <div class="popup-layer"></div>

        <div class="popup-container" id="terms-conditions">



            <div class="pop-box-outer">

                <div class="pop-box terms-popup">

                    <button class="close-popup"></button>



                    <h2>Terms and Conditions</h2>

                    <div id="text">

                        <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>

                        <p>It is a paradisematic country, A small river named Duden flows by their place and suppliesA small river named Duden flows by their place and supplies it with the necessary regelialia.</p>

                        <p>It is a paradisematic country, A small river named Duden flows by their place and suppliesA small river named Duden flows by their place and supplies it with the necessary regelialia.</p>

                        <p>It is a paradisematic country, A small river named Duden flows by their place and supplies.</p>

                    </div>

                </div>

            </div>

        </div>



        <div class="popup-container" id="contact-popup">

            <div class="pop-box-outer">

                <div class="pop-box contact-us contact-form">

                    <button class="close-popup"></button>

                    <h1>Send Us Message</h1>

                    <form  method="post" action="index.php" id="contact-form">

                        <fieldset class="form-group">

                            <input type="text" name="name" value="" placeholder="Full Name">

                        </fieldset>



                        <fieldset class="form-group">

                            <input type="email" name="email" value="" placeholder="E-mail">

                        </fieldset>



                        <fieldset class="form-group">

                            <input type="text" name="subject" value="" placeholder="Subject">

                        </fieldset>



                        <fieldset class="form-group">

                            <textarea name="message" placeholder="Message"></textarea>

                        </fieldset>



                        <button type="submit" class="btn">Send Now</button>

                    </form>



                </div>

            </div>

        </div>



        <script src="{{asset('/assets/front/js/constants.js')}}"></script>

        <script src="{{asset('/assets/back/js/jquery.js')}}"></script>

        <script src="{{asset('/assets/back/js/jquery-ui.js')}}"></script>

        <script src="{{asset('/assets/back/js/bootstrap.min.js')}}"></script>

        <script src="{{asset('/assets/back/js/scrollbar.js')}}"></script>

        <script src="{{asset('/assets/back/js/validate.js')}}"></script>

        <script src="{{asset('/assets/back/js/timepicki.js')}}"></script>

        <script src="{{asset('/assets/back/js/fm.datetator.jquery.js')}}"></script>

        <script src="{{asset('/assets/back/js/fm.datetator-en.jquery.js')}}"></script>

        <!-- notifIt! Includes -->

        <script src="{{asset('/assets/notifIt/js/notifIt.js')}}"></script>

        <script src="{{asset('/assets/back/js/select2.min.js')}}"></script>

        <script src="{{asset('/assets/back/js/script.js')}}"></script>

        <!-- Alertify JavaScript -->

        <script src="{{asset('/assets/alertify/alertify.min.js')}}"></script>

        <script src="{{asset('/assets/front/js/common.js')}}"></script>

        <!-- loader JavaScript -->

        <script src="{{asset('/assets/jquery-loading-overlay-master/src/loadingoverlay.min.js')}}"></script>

        <!-- Map scripts -->

        <script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false&libraries=places'></script>

        <script type="text/javascript" src="{{asset('/assets/back/js/locationpicker.js')}}"></script>

        <script type="text/javascript" src="{{asset('/assets/back/js/gmap.js')}}"></script>

        <script type="text/javascript" src="{{asset('/assets/back/js/jquery.simple.timer.js')}}"></script>

        <script type="text/javascript" src="{{asset('/assets/back/js/jquery.time-to.js')}}"></script>

        <!-- <script src="{{asset('/assets/jquery-loading-overlay-master/src/loadingoverlay.js')}}"></script> -->

        <script type="text/javascript">

                $(document).ajaxStart(function () {

                    $.LoadingOverlay("show", {

                        image: "",

                        fontawesome: "fa fa-spinner fa-spin"

                    });

clearTimeout(refresh);

                });

                $(document).ajaxStop(function () {

                    setTimeout(function () {

                        $.LoadingOverlay("hide");

                    });

                });



        </script>



        @if(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_ADMIN'))

        <script src="{{asset('/assets/back/js/admin.js')}}"></script>

        @elseif(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_CUSTOMER'))

        <script src="{{asset('/assets/back/js/customer.js')}}"></script>

        @elseif(\Auth::user()->role == \Illuminate\Support\Facades\Config::get('constants.USER_ROLE_MANAGER'))

        <script src="{{asset('/assets/back/js/manager.js')}}"></script>

        @endif



        <script type="text/javascript">

            alertify.defaults.transition = "zoom";

            alertify.defaults.theme.ok = "ui positive button";

            alertify.defaults.theme.cancel = "ui black button";

        </script>

        <!-- =========================== -->
        <script>

            //  var d = new Date();

            // $('#timepicker1').timepicki();

            // $('#timepicker1').val("0" + d.getHours() + " : " + d.getMinutes());







            // function setTime(time){



            //     if(time != 'clear'){

            //         var d = new Date();

            //         if((d.getMinutes() + time) > 59){

            //             var value = (d.getMinutes() + time) - 59;

            //             if((d.getHours() + 1) == 24){

            //                 $('#timepicker1').val(00 + " : " + value);

            //             }else{

            //                 $('#timepicker1').val((d.getHours() + 1) + " : " + value);

            //             }

            //         }else{

            //             $('#timepicker1').val( d.getHours() + " : " + (d.getMinutes() + time));

            //         }

            //     }else{

            //         var d = new Date();

            //         $('#timepicker1').val("0" + d.getHours() + " : " + d.getMinutes());

            //     }



            // }



            // Move to login screen if its from logout...



            $('#curr_time').timeTo({

            theme: "none",

            seconds: false

            });

        </script>
        @yield('scripts')

    </body>

</html>