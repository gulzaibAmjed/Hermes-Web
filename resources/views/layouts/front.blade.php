<!DOCTYPE html>
<html>
    <head>
    <script>
        var langStr = {};
    </script>
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
        <!-- notifIt! Includes -->
        <link rel="stylesheet" href="{{asset('/assets/notifIt/css/notifIt.css')}}">
        <script src="{{asset('/assets/front/js/jquery.js')}}"></script>
    </head>
    <body>

        <div class="page-wrapper">
            <div class="preloader"></div>
            @include('includes.front.header')
            @yield('content')
            @include('includes.front.footer')
        </div>
        @include('front.forgot');

        <script src="{{asset('/assets/front/js/constants.js')}}"></script>
        <script src="{{asset('/assets/front/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('/assets/front/js/bxslider.js')}}"></script>
        <script src="{{asset('/assets/front/js/owl.js')}}"></script>
        <script src="{{asset('/assets/front/js/wow.js')}}"></script>
        <script src="{{asset('/assets/front/js/validate.js')}}"></script>
        <script src="{{asset('/assets/front/js/script.js')}}"></script>
        <script src="{{asset('/assets/front/js/common.js')}}"></script>
        <script src="{{asset('/assets/front/js/front.js')}}"></script>
        <script src="{{asset('/assets/notifIt/js/notifIt.js')}}"></script>
        <!-- loader JavaScript -->
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



/*        function myFunc() {

            notif({
                type: "error",
                msg: "Customize the timeout!",
                position: "center",
                time: 10000
            });
        }*/
        </script>
        <!-- =========================== -->

        <!-- Alertify JavaScript -->
        <script src="{{asset('/assets/alertify/alertify.min.js')}}"></script>
        <script type="text/javascript">
        alertify.defaults.transition = "zoom";
        alertify.defaults.theme.ok = "ui positive button";
        alertify.defaults.theme.cancel = "ui black button";
        </script>
        <!-- =========================== -->

        <!-- messgPlugin JavaScript -->

        <!-- =========================== -->

        <script type="text/javascript">

<?php
if ($errors->all()) {
    $error = $errors->all()[0];
    ?>
                var error = "<?php echo $error ?>";
                notif({
                					msg: "<b>Note:</b> "+ error,
                					position: "center",
                					time: 10000
                				});
    <?php
}
if (\Session::has('message')) {
    ?>
                var message = "<?php echo \Session::get('message') ?>";
                notif({
                					msg: "<b>Note:</b> "+ message,
                					position: "center",
                					time: 10000
                				});
    <?php
}
if (\Session::has('logout')) {
    ?>
                $('#down_to_signin').click();
    <?php
}
?>
        </script>
    </body>
</html>