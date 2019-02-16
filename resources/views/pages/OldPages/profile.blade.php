
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shuffle Case</title>

    <link rel="stylesheet/less" type="text/css" href="{{ asset('shufflehex/less/allstories.less') }}">
    @include('partials.assets')
    <script type="text/javascript" src="{{ asset('shufflehex/js/ajaxJS.js') }}"></script>
</head>
<body>
<div id="wrapper">
    @include('partials.topbar')
    <div id="content-body">
        <div class="category-tab">
            <div class="container">
                <!-- tabs -->
                <div class="tabbable">
                    <div class="navbar-cat">
                        <ul class="nav nav-tabs">
                            <li><a href="#latest_post" onclick="getLatestLinks()" data-toggle="tab" >Latest</a></li>
                            <li><a href="#link-post" onClick="getPromotedLinks()" data-toggle="tab">Promoted</a></li>
                        </ul>
                    </div>
                </div>
                <!-- /tabs -->
            </div>
        </div>
        <div id="catPost" class="container">
            <div class="linkList col-md-12 col-sm-12 col-xs-12">
                <div class="tab-content">
                    <div id="latest_post" class="tab-pane active animated fadeIn">
                        @foreach($posts as $key=>$post)
                            <div class="link-item">
                                <div class="voting pull-left">
                                    <ul class="list-unstyled">
                                        <li style="top: 0"><button type="button" class="btn-vote"><i class="fa
                                    fa-arrow-up"></i></button></li>
                                        <li class="text-center"><span class="vote-count">10</span></li>
                                        <li style="bottom: 0;"><button type="button" class="btn-vote"><i class="fa
                                    fa-arrow-down"></i></button></li>
                                    </ul>
                                </div>
                                <div class="link-info">
                                    <div class="link-thumb pull-left">
                                        <img class="img-responsive" src="{{ $post->featured_image }}" width="100%">
                                    </div>
                                    <div class="link-content">
                                        <h4 class="link-title"><a href=" {{ $post->link }}" target="_blank"> {{ $post->title }}</a></h4>
                                        <p class="link-desc"><?=substr($post->description,0, 120); ?></p>
                                        <div style="color: #878787;margin-top: 10px">
                                            <span class="postTime">{{ $post->created_at }}</span>
                                            &nbsp;<span><a href="#">Comments:&nbsp;<span>10</span></span></a></span>
                                            &nbsp;By <span><a href="#">Username</a></span>
                                        </div>

                                    </div>
                                </div>

                            </div>

                        @endforeach
                    </div>
                    <div id="link-post" class="tab-pane animated fadeIn"></div>

                </div>
            </div>
        </div>
    </div>
    <footer id="footer" class=" text-center bg-success" >
        <p class="text-center">&copy; 2017</p>
    </footer>
</div>
@include('partials.sidebar')

</body>
</html>