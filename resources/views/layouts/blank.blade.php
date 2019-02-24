<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Shufflehex</title>
    @yield('css')



</head>

<body class="master">
{{----------------------------- store current url to session -----------------------}}
<?php session(['last_page' => url()->current()]);?>
{{-------------------------------------------------------------------------------------}}

    <div class="container">

        <div class="row">
            <div class="col-md-12">
                @yield('content')
            </div>
        </div>
    </div>

</div>
</body>

</html>