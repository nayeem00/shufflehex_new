<?php
$actual_link = URL::to('/');
$imageLink = $actual_link."/".$post->featured_image;
$title = preg_replace('/\s+/', '-', $post->title);
$title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
$title = $title . '-' . $post->id;
$storyUrl = $actual_link.'/story/'.$title;
$storyImage = $actual_link.'/'.$post->featured_image;
$wordCount = str_word_count($post->description);
?>

<!DOCTYPE html>
<html class=''>
<head>
    <meta charset='UTF-8'>
    <meta name="robots" content="noindex">
    <title>{{ $post->title }}</title>
    <meta name="description" content="{{ $post->metaDescription }}"/>
    <meta name="keywords" content="{{ $post->tags }}">
    <meta name="category" content="{{ $post->category }}">
    <meta name="author" content="{{ $postUser->name }}">
    <meta name="og:image" content="{{ $imageLink }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="icon" type="image/png" href="{{asset('/images/icons/shufflehex.png')}}">
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
    {{--<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css'>--}}
    <link href="{{ asset('ChangedDesign/lessFiles/less/story-view.css') }}" rel="stylesheet">



    <!--    <script src='js/console_runner.js'></script>-->
    <!--    <script src='js/events_runner.js'></script>-->
    <!--    <script src='js/css-live-reload.js'></script>-->
</head>
<body>
<div class="site-wrapper">
    <div id="top-bar">
        <div class="story-view">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#navbar" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="{{ url('/story') }}"><img class="logo"
                                                           src="{{ asset('img/logo/shufflehex.png') }}"></a>
                    </div>

                    <div class="collapse navbar-collapse" id="navbar">
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="{{ url($previous->story_link) }}">
                                    <img class="icon" src="{{ asset('img/back-button.svg') }}">
                                </a>
                            </li>
                            <li>
                                <a href="{{ url($next->story_link) }}">
                                    <img class="icon" src="{{ asset('img/right-arrow-circular-button.svg') }}">
                                </a>
                            </li>
                            <li class="story-list">
                                <p class="title">{{ $post->title }}</p>
                                <p class="username">
                                    <small><a href="{{ url('profile/'.$postUser->username) }}" rel="nofollow"> {{ $postUser->name }}</a></small>
                                </p>
                            </li>
                        </ul>
                        <div class="pull-right story-share-list">
                            <ul class="list-unstyled dis-infl">
                                @if (Auth::guest())
                                    <li><a class="btn btn-default" href="{{ url('/login') }}">LOG IN</a></li>
                                    <li><a class="btn btn-danger mr-l-1" href="{{ url('pages/register') }}">SIGN UP</a>
                                    </li>
                                @else
                                    <li class="btn-cls">
                                        <a href="#">
                                            <i class="fa fa-caret-up"></i>
                                            <p class="">Upvote <span>30</span></p>
                                        </a>
                                    </li>
                                    <li class="btn-cls">
                                        <a href="#">
                                            <p>save</p>
                                        </a>
                                    </li>
                                    <li class="shuffle-btn">
                                        <a href="#">
                                            <p>SHUFFLE FULL STORY</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img class="icon" src="{{ asset('img/facebook.svg') }}">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img class="icon" src="{{ asset('img/twitter.svg') }}">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img class="icon" src="{{ asset('img/google-plus.svg') }}">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img class="icon" src="{{ asset('img/linkedin.svg') }}">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img class="icon" src="{{ asset('img/cancel.svg') }}">
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
        </div>
    </div>
    <div>
        <iframe id="i_frame" is="x-frame-bypass" src="{{ $post->link }}" style="position: absolute; height: 100%; width: 100%; border: none"></iframe>
    </div>


    {{--<iframe src="{{ $post->link }}" style="position: absolute; height: 100%; width: 100%; border: none"></iframe>--}}

</div>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5a64cb7833dd1d0d"></script>
<!-- jQuery CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- jQuery Nicescroll CDN -->
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<!-- jQuery Nicescroll CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.6.8-fix/jquery.nicescroll.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<!--<script src="js/story-view.js"></script>-->
<script src='{{ asset('ChangedDesign/js/stopExecutionTimeOut.js') }}'></script>
<script src="https://unpkg.com/@ungap/custom-elements-builtin"></script>
<script type="module" src="https://unpkg.com/x-frame-bypass"></script>

<script>

    // function onLoadHandler() {
    //     var iframe = document.getElementById('i_frame');
    //     var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
    //
    //     // Check if loading is complete
    //     if (iframeDoc.readyState  == 'complete') {
    //         //iframe.contentWindow.alert("Hello");
    //         iframe.contentWindow.onload = function(){
    //
    //         };
    //     } else {
    //         alert("I am not loaded");
    //     }
    // }
    // if ($('#i_frame').on('load')) {
    //     // Get a handle to the iframe element
    //     var iframe = document.getElementById('i_frame');
    //     var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
    //
    //     // Check if loading is complete
    //     if (iframeDoc.readyState  == 'complete') {
    //         //iframe.contentWindow.alert("Hello");
    //         iframe.contentWindow.onload = function(){
    //
    //         };
    //     } else {
    //         alert("I am not loaded");
    //     }
    // }


    {{--if ($('#i_frame').on('load')){--}}
        {{--var iframe = document.getElementById('i_frame');--}}
        {{--var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;--}}

        {{--// Check if loading is complete--}}
        {{--if (  iframeDoc.readyState  == 'complete' ) {--}}
            {{--//iframe.contentWindow.alert("Hello");--}}
            {{--iframe.contentWindow.onload = function(){--}}
                {{--alert("I am loaded");--}}
            {{--};--}}
    {{--}else {--}}
        {{--alert('not loaded')--}}
{{--var iframe_html = '<iframe id="i_frame" is="x-frame-bypass" src="{{ $post->link }}" style="position: absolute; height: 100%; width: 100%; border: none"></iframe>';--}}
        {{--document.getElementById("iframe_div").innerHTML = iframe_html;--}}
    {{--}--}}
    {{--$('#i_frame').on('load', function() {--}}
        {{--// Get a handle to the iframe element--}}
        {{--var iframe = document.getElementById('i_frame');--}}
        {{--var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;--}}

        {{--// Check if loading is complete--}}
        {{--if (  iframeDoc.readyState  == 'complete' ) {--}}
            {{--//iframe.contentWindow.alert("Hello");--}}
            {{--iframe.contentWindow.onload = function(){--}}
                {{--alert("I am loaded");--}}
            {{--};--}}
            {{--// The loading is complete, call the function we want executed once the iframe is loaded--}}
            {{--afterLoading();--}}
            {{--return;--}}
        {{--}--}}

        {{--// If we are here, it is not loaded. Set things up so we check   the status again in 100 milliseconds--}}
        {{--window.setTimeout(checkIframeLoaded, 100);--}}
    {{--});--}}
    {{--function afterLoading(){--}}
        {{--// alert("I am here");--}}
    {{--}--}}
    {{--checkIframeLoaded();--}}
</script>
</body>
</html>