
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shuffle Case</title>
    <link rel="stylesheet/less" type="text/css" href="{{ asset('shufflehex/less/home.less') }}">
    @include('partials.assets')
    <style>
    </style>
</head>
<body>
<div class="se-pre-con">
    <div class="loader"></div>
</div>
<div id="wrapper">
    @include('partials.topbar')
    <div id="home-body" class="">
        <div class="suffle text-center">
            <button type="button" id="suffle-btn" class="btn btn-lg btn-danger">
                Shuffle
            </button>
        </div>
    </div>
    <footer id="footer" class=" text-center" >
        <p class="text-center">&copy; 2017</p>
    </footer>
</div>
@include('partials.sidebar')
</body>
</html>