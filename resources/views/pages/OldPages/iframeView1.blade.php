
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shuffle Hex</title>
    @include('partials.assets')
    <style>
        iframe{
            width: 100%;
            height: 100%;
            position: fixed;
            margin-top: 60px;
        }
        .navbar{
            min-height: 60px;
        }
        .ad-img{
            position: relative;
            display: inline-block;
            float: left;
        }
        .ad-img img{
            float: left;
            left: 25%;
            max-height: 60px;
            top: -4px;
        }

    </style>
</head>
<body>


<div id="wrapper">
    <div id="topbar">
        <nav class="navbar navbar-fixed-top text-center">
            <div class="container">
                <a class="navbar-brand" style="margin-top: 5px" href="./">Shuffle HEX</a>
                <div class="ad-img">
                    <img class="img-responsive" src="http://www.netbeopen.com/clients/images/netbeopen-468x80.gif">
                </div>
                <div class="pull-right" style="margin-top: 5px">
                    <button class="fa fa-thumbs-up"></button>
                    <button class="fa fa-thumbs-down"></button>
                    <button type="button" id="menu-icon" class="" onclick="sidebar_open()">
                        <span class="fa fa-bars"></span>
                    </button>
                </div>
            </div>
        </nav>
    </div>
    <div id="content-body" class="">
        <div class="site-view">
            <iframe src="{{ $post->link }}"></iframe>
        </div>
    </div>
    <!--            <footer id="footer" class=" text-center" >-->
    <!--                <p class="text-center">&copy; 2017</p>-->
    <!--            </footer>-->
</div>
@include('partials.sidebar')
</body>
</html>