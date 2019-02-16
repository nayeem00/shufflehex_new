<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Shufflehex</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="{{ asset('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    {{--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/main.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/style.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/list-style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link rel="stylesheet" href="{{ asset('ChangedDesign/plugins/summernote-0.8.11/summernote.css') }}">
    @yield('css')



</head>

<body class="master">
<div class="page-overlay"></div>
@if( !(Request::is('page404')) )
    @include('partials.menu_sidebar')
@endif
<div id="wrapper">
	@if( !(Request::is('page404')) )

        @include('partials.mobile_nav')
        @include('partials.main_nav')

	@endif

<div class="container">

	<div class="row">



		<div class="col-md-2 plr-0">

			@if( !(Request::is('login') || Request::is('pages/register') || Request::is('page404'))  )

			    @include('partials.list-left-sidebar')

			@endif

		</div>

		<div class="col-md-8 col-sm-12 plr-2">
			@yield('content')

		</div>

		<div class="col-md-2 plr-0">

			@if( !(Request::is('login') || Request::is('pages/register') || Request::is('page404')) )

			    @include('partials.list-right-sidebar')

			@endif

    </div>

    <div class="overlay"></div>
    </div>
</div>

</div>


@yield('js')
<!-- jQuery CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.6.8-fix/jquery.nicescroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<script src="{{ asset('ChangedDesign/plugins/summernote-0.8.11/summernote.js') }}"></script>
<script src="{{ asset('ChangedDesign/plugins/summernote-0.8.11/summernote-image-attributes.js') }}"></script>
<script type="text/javascript" src="{{ asset('ChangedDesign/js/text-editor.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            toastr.error('{{$error}}');
        </script>
    @endforeach
@endif

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