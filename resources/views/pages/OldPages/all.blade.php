<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shuffle Case</title>

    <link rel="stylesheet/less" type="text/css" href="{{ asset('shufflehex/less/allstories.less') }}">
    @include('partials.assets')
    <script type="text/javascript" src="{{ asset('shufflehex/js/ajaxJS.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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
                            <?php
                            $upVoteMatched = 0;
                            $downVoteMatched = 0;
                            $votes=0;
                            ?>
                            @foreach($post->votes as $key=>$vote)
                                @if($vote->user_id == Auth::user()->id && $vote->vote == 1)
                                    <?php $upVoteMatched = 1; ?>
                                    @break
                                @endif
                             @endforeach
                                @foreach($post->votes as $key=>$vote)
                                    @if($vote->user_id == Auth::user()->id && $vote->vote == -1)
                                        <?php $downVoteMatched = 1; ?>
                                        @break
                                    @endif
                                @endforeach
                             @foreach($post->votes as $key=>$vote)
                                 <?php
                                 $votes+= $vote->vote;
                                    ?>
                             @endforeach
                        <div class="link-item">
                            <div class="voting pull-left">
                                <ul class="list-unstyled">
                                    @if($upVoteMatched == 1)
                                    <li style="top: 0;color: #7FFF00"><button type="button" class="btn-vote" id="btn_upVote_{{ $post->id }}"
                                                                onclick="upVote({{
                                    $post->id
                                    }})"><i class="fa fa-arrow-up"></i></button></li>
                                    @else
                                        <li style="top: 0;"><button type="button" class="btn-vote" id="btn_upVote_{{ $post->id }}"
                                                                                  onclick="upVote({{
                                    $post->id
                                    }})"><i class="fa fa-arrow-up"></i></button></li>
                                    @endif

                                    <li class="text-center"><span class="vote-count" id="vote_count_{{ $post->id }}">{{ $votes }}</span></li>
                                    @if($downVoteMatched == 1)
                                    <li style="bottom: 0;color: #7FFF00"><button type="button" class="btn-vote" id="btn_downVote_{{ $post->id }}"
                                                                   onclick="downVote({{
                                    $post->id
                                    }})"><i class="fa
                                    fa-arrow-down"></i></button></li>
                                    @else
                                            <li style="bottom: 0;"><button type="button" class="btn-vote" id="btn_downVote_{{ $post->id }}"
                                                                           onclick="downVote({{
                                    $post->id
                                    }})"><i class="fa
                                    fa-arrow-down"></i></button></li>
                                    @endif
                                </ul>
                            </div>
                            <?php
                            $title = preg_replace('/\s+/', '-', $post->title);
                            $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
                            ?>
                            <div class="link-info">
                                <div class="link-thumb pull-left">
                                    <img class="img-responsive" src="{{ $post->featured_image }}" width="100%">
                                </div>
                                <div class="link-content">
                                    <h4 class="link-title"><a href="post/{{ $post->id }}/{{ $title }}" target="_blank"> {{ $post->title }}</a></h4>
                                    <p class="link-desc"><?=substr($post->description,0, 120); ?></p>

                                    <div style="color: #878787;margin-top: 10px">
                                        <span class="postTime">{{ $post->created_at }}</span>
                                        &nbsp;<span><a href="post/{{ $post->id }}/{{ $title }}" target="_blank">Comments:&nbsp;
                                                <span>{{ count($post->comments) }}</span></a></span>
                                        &nbsp;By <span><a href="#">{{ $post->username }}</a></span>
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
<script>
    function upVote(post_id){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var property = 'btn_upVote_'+post_id;
        console.log(property);
        $.ajax({
            type:'post',
            url: 'vote',
            data: {_token: CSRF_TOKEN , post_id: post_id},
            dataType: 'JSON',
            success: function (data) {
                console.log(data);
                if(data.status == 'upvoted'){
                    var property = document.getElementById('btn_downVote_'+post_id);
                    property.style.color = "#000"
                    var property = document.getElementById('btn_upVote_'+post_id);
                    property.style.color = "#7FFF00"
                    $('#vote_count_'+post_id).text(data.voteNumber);
                } else{
                    var property = document.getElementById('btn_upVote_'+post_id);
                    property.style.color = "#000"
                    $('#vote_count_'+post_id).text(data.voteNumber);
                }
            }
        });
    };

    function downVote(post_id){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var property = 'btn_downVote_'+post_id;
        console.log(property);
        $.ajax({
            type:'post',
            url: 'vote/downVote',
            data: {_token: CSRF_TOKEN , post_id: post_id},
            dataType: 'JSON',
            success: function (data) {
                console.log(data);
                if(data.status == 'downvoted'){
                    var property = document.getElementById('btn_upVote_'+post_id);
                    property.style.color = "#000"
                    var property = document.getElementById('btn_downVote_'+post_id);
                    property.style.color = "#7FFF00"
                    $('#vote_count_'+post_id).text(data.voteNumber);
                } else{
                    var property = document.getElementById('btn_downVote_'+post_id);
                    property.style.color = "#000"
                    $('#vote_count_'+post_id).text(data.voteNumber);
                }
            }
        });
    };
</script>
</body>
</html>