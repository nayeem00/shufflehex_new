<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}" />
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/medium-editor-insert-plugin/2.5.0/css/medium-editor-insert-plugin-frontend.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/medium-editor-insert-plugin/2.5.0/css/medium-editor-insert-plugin.min.css" />
    <link rel="stylesheet" href="{{ asset('ChangedDesign/plugins/summernote-0.8.11/summernote.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/plugins/medium-editor/css/medium-editor.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/plugins/medium-editor/css/themes/default.css') }}">
    @yield('css')

    <?php echo \App\Http\SettingsHelper::getHeadScript()?>



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

        <div class="row">





            <div class="col-md-12">
                @yield('content')

            </div>

            <div class="overlay"></div>
        </div>
    </div>

</div>
<div class="go-top">
    <button class="go-top-btn">
        <i class="fa fa-chevron-up"></i>
    </button>
</div>
<?php echo \App\Http\SettingsHelper::getFootScript()?>
@yield('js')
<!-- jQuery CDN -->
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('bootstrap3/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('js/jquery.nicescroll.min.js')}}"></script>
<script src="{{ asset('bootstrap-select-1.13.2/js/bootstrap-select.min.js')}}"></script>
<script src="{{ asset('jquery-confirm/jquery-confirm.min.js') }}"></script>
<script src="{{ asset('ChangedDesign/plugins/medium-editor/js/medium-editor.js') }}"></script>
<script src="{{ asset('ChangedDesign/plugins/summernote-0.8.11/summernote.js') }}"></script>
<script src="{{ asset('ChangedDesign/plugins/summernote-0.8.11/summernote-image-attributes.js') }}"></script>
<script type="text/javascript" src="{{ asset('ChangedDesign/js/text-editor.js') }}"></script>
<script src="{{ asset('toastr/toastr.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.12/handlebars.runtime.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sortable/0.9.13/jquery-sortable-min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery.ui.widget@1.10.3/jquery.ui.widget.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.iframe-transport/1.0.1/jquery.iframe-transport.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/9.28.0/js/jquery.fileupload.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/medium-editor-insert-plugin/2.5.0/js/medium-editor-insert-plugin.min.js"></script>

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            toastr.error('{{$error}}');
        </script>
    @endforeach
@endif
<script>
    $(document).scroll(function() {
        var y = $(this).scrollTop();
        if (y > 10) {
            $('.go-top').fadeIn(100);
        } else {
            $('.go-top').fadeOut(100);
        }
    });
</script>
<script src="{{ asset('js/main.js') }}"></script>
<script>

    $(document).ready(function () {

        $('[data-toggle="tooltip"]').tooltip();

    });

</script>
<script>

    $('.selectpicker').selectpicker();

</script>
@yield('js')

{!! Toastr::message() !!}



</body>

</html>