<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Shufflehex</title>

    <link rel="stylesheet" href="{{ asset('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    {{--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/main.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/style.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/list-style.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/profile.css') }}">

@yield('css')

<?php echo \App\Http\SettingsHelper::getHeadScript()?>
<body>
@include('partials.list-small-window-sidebar')
<div id="wrapper">
@include('partials.top-bar')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 plr-0" >
            @yield('content')

<!-- jQuery CDN -->
    <!--         <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Bootstrap Js CDN -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- jQuery Nicescroll CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.6.8-fix/jquery.nicescroll.min.js"></script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
                <script>
                    $(document).ready(function(){

                        document.getElementById("profile_picture_select").onchange = function() {
                            document.getElementById("profile_picture_upload_form").submit();
                        };
                    });
                </script>


    <?php echo \App\Http\SettingsHelper::getFootScript()?>


</body>
</html>