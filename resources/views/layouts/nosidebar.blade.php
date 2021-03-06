<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="icon" type="image/png" href="{{asset('/images/icons/shufflehex.png')}}">
    <title>Shufflehex</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="{{ asset('bootstrap3/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap-select-1.13.2/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('font-awesome-4.7.0/css/font-awesome.min.css') }}">
    {{--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">--}}
    <link rel="stylesheet" href="{{asset('jquery-confirm/jquery-confirm.min.css')}}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/main.css') }}">
    <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">

    @yield('css')

    <?php echo \App\Http\SettingsHelper::getHeadScript()?>

    @if( (Request::is('login') || Request::is('pages/register')))  )
    <script src="https://www.google.com/recaptcha/api.js"></script>
    @endif
</head>

<body class="master">
{{----------------------------- store current url to session -----------------------}}
<?php session(['last_page' => url()->current()]);?>
{{-------------------------------------------------------------------------------------}}
<div class="page-overlay"></div>
@if( !(Request::is('page404')) )
    @include('partials.menu_sidebar')
    @if (!Auth::guest())
        @include('partials.mobile_user_menu')
    @endif
@endif
<div id="wrapper">
    @if( !(Request::is('page404')) )
        @include('partials.mobile_nav')
        @include('partials.main_nav')
    @endif

    <div class="container">
        @yield('content')
    </div>
</div>
<div class="go-top">
    <button class="go-top-btn">
        <i class="fa fa-chevron-up"></i>
    </button>
</div>
<!-- jQuery CDN -->
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('bootstrap3/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('js/jquery.nicescroll.min.js')}}"></script>
<script src="{{ asset('bootstrap-select-1.13.2/js/bootstrap-select.min.js')}}"></script>
<script src="{{ asset('jquery-confirm/jquery-confirm.min.js') }}"></script>
<script src="{{ asset('toastr/toastr.min.js')}}"></script>

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            toastr.error('{{$error}}');
        </script>
    @endforeach
@endif
<script>
    $(document).scroll(function () {
        var y = $(this).scrollTop();
        if (y > 10) {
            $('.go-top').fadeIn(100);
        } else {
            $('.go-top').fadeOut(100);
        }
    });
</script>
@if( !(Request::is('login') || Request::is('pages/register') || Request::is('page404'))  )
    <script src="{{ asset('js/main.js') }}"></script>
@endif
@yield('js')

{!! Toastr::message() !!}
<?php echo \App\Http\SettingsHelper::getFootScript()?>

</body>

</html>