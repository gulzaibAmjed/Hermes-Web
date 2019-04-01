<!DOCTYPE html>
<html>
    <head>
        <!-- notifIt! Includes -->
        <link rel="stylesheet" href="{{asset('/assets/notifIt/css/notifIt.css')}}">
        <script src="{{asset('/assets/notifIt/js/notifIt.js')}}"></script>
        
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Group Hermes</title>
        <link href="{{asset('/assets/front/css/bootstrap.css')}}" rel="stylesheet">
        <link href="{{asset('/assets/front/css/owl.css" rel="stylesheet')}}">
        <link href="{{asset('/assets/front/css/owl.transitions.css')}}" rel="stylesheet">
        <link href="{{asset('/assets/front/css/style.css')}}" rel="stylesheet">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <link href="{{asset('/assets/front/css/responsive.css')}}" rel="stylesheet">
        <!-- Alertify Includes -->
        <link rel="stylesheet" href="{{asset('/assets/alertify/alertify.min.css')}}">
        <link rel="stylesheet" href="{{asset('/assets/alertify/semantic.min.css')}}">
        <!-- messgPlugin Includes -->
        <link rel="stylesheet" href="{{asset('/assets/messgPlugin/messgPlugin.css')}}">

        <!-- loader JavaScript -->
        <script src="{{asset('/assets/front/js/constants.js')}}"></script>
        <script src="{{asset('/assets/front/js/jquery.js')}}"></script>
        <script src="{{asset('/assets/front/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('/assets/front/js/bxslider.js')}}"></script>
        <script src="{{asset('/assets/front/js/owl.js')}}"></script>
        <script src="{{asset('/assets/front/js/wow.js')}}"></script>
        <script src="{{asset('/assets/front/js/validate.js')}}"></script>
        <script src="{{asset('/assets/front/js/script.js')}}"></script>
        <script src="{{asset('/assets/front/js/common.js')}}"></script>
        <script src="{{asset('/assets/front/js/front.js')}}"></script>
        <script src="{{asset('/assets/back/js/admin.js')}}"></script>
        <script src="{{asset('/assets/jquery-loading-overlay-master/src/loadingoverlay.min.js')}}"></script>
        <script src="{{asset('/assets/jquery-loading-overlay-master/src/loadingoverlay.js')}}"></script>

        <script type="text/javascript">
$(document).ajaxStart(function () {
    $.LoadingOverlay("show", {
        image: "",
        fontawesome: "fa fa-spinner fa-spin"
    });
});
$(document).ajaxStop(function () {
    setTimeout(function () {
        $.LoadingOverlay("hide");
    });
});
        </script>

        <!-- =========================== -->
    </head>
    <body>
        <div class="page-wrapper">
            <div class="preloader"></div>

            <!--Developer Section-->
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div class="row clearfix">
                        <!--Sign In-->
                            <div class="dev-login wow zoomIn" data-wow-delay="500" data-wow-duration="2s" data-wow-offset="5">
                                <h3 style="color:white">כניסת אדמין?</h3>
                                <form name="signIn" id="adminSignIn" method="post" action="{{url('/auth/login')}}">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <fieldset class="form-group">
                                        <input class="username" type="text" name="email" id="signEmail" value="" placeholder="אי מייל">
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <input class="user-password" type="password" name="password" id="signPassword" value="" placeholder="סיסמא">
                                    </fieldset>
                                    <div class="clearfix">
                                        <button class="pull-left" type="submit">כניסה</button>
                                        <a href="#" class="pull-right forgot-pass has-popup" data-target="#pwdModal" data-toggle="modal" title="Contact-Now">שכחת סיסמא?</a>
                                    </div>
                                </form>
                            </div>
                </div>
        </div>
        @include('front.forgot');


        <!-- loader JavaScript -->
        <script src="{{asset('/assets/front/js/constants.js')}}"></script>
        <script src="{{asset('/assets/front/js/jquery.js')}}"></script>
        <script src="{{asset('/assets/front/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('/assets/front/js/bxslider.js')}}"></script>
        <script src="{{asset('/assets/front/js/owl.js')}}"></script>
        <script src="{{asset('/assets/front/js/wow.js')}}"></script>
        <script src="{{asset('/assets/front/js/validate.js')}}"></script>
        <script src="{{asset('/assets/front/js/script.js')}}"></script>
        <script src="{{asset('/assets/front/js/common.js')}}"></script>
        <script src="{{asset('/assets/front/js/front.js')}}"></script>
        <script src="{{asset('/assets/back/js/admin.js')}}"></script>
        <script src="{{asset('/assets/jquery-loading-overlay-master/src/loadingoverlay.min.js')}}"></script>
        <script src="{{asset('/assets/jquery-loading-overlay-master/src/loadingoverlay.js')}}"></script>

        <script type="text/javascript">
$(document).ajaxStart(function () {
    $.LoadingOverlay("show", {
        image: "",
        fontawesome: "fa fa-spinner fa-spin"
    });
});
$(document).ajaxStop(function () {
    setTimeout(function () {
        $.LoadingOverlay("hide");
    }, 2000);
});
        </script>
        <!-- Alertify JavaScript -->
        <script src="{{asset('/assets/alertify/alertify.min.js')}}"></script>
        <script type="text/javascript">
alertify.defaults.transition = "zoom";
alertify.defaults.theme.ok = "ui positive button";
alertify.defaults.theme.cancel = "ui black button";
        </script>
        <!-- =========================== -->

    </body>
</html>
<!--End pagewrapper-->
