<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('img/logo/shufflehex_title.png') }}" />
    <title>Shufflehex</title>
    <link rel="stylesheet" href="{{ asset('ChangedDesign/css/main.css') }}">

@yield('css')

</head>
<body>
<div id="wrapper">
@include('partials.top-bar')
<div id="body-content">
@include('partials.list-left-sidebar')
@yield('content')
@include('partials.right-sidebar')
</div>
    <div class="overlay"></div>
</div>
@yield('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<script src="{{ asset('js/main.js') }}"></script>


</body>
</html>