@extends('layouts.project')
@section('css')
    <!-- Bootstrap CSS CDN -->
    <title>Project</title>
    <!-- Include Editor style. -->
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/add.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/project.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/view-story.css') }}">
    <link rel="stylesheet" href="{{ asset('xzoom/dist/xzoom.css') }}">


@endsection


<?php

$upVoteMatched = 0;
$downVoteMatched = 0;
$savedStory = 0;
$votes = 0;
$countImages = count($post->screenshots);

?>

@foreach($post->project_votes as $key=>$vote)
    <?php
$votes += $vote->vote;
?>
@endforeach
@if(isset(Auth::user()->id) && !empty(Auth::user()->id))
    @foreach($post->project_votes as $key=>$vote)
        @if($vote->user_id == Auth::user()->id && $vote->vote == 1)
            <?php $upVoteMatched = 1;?>
            @break
        @endif
    @endforeach
    @foreach($post->project_votes as $key=>$vote)
        @if($vote->user_id == Auth::user()->id && $vote->vote == -1)
            <?php $downVoteMatched = 1;?>
            @break
        @endif
    @endforeach
    @foreach($post->saved_projects as $key=>$saved)
        @if($saved->user_id == Auth::user()->id && $saved->project_id == $post->id)
            <?php $savedStory = 1;?>
            @break
        @endif
    @endforeach
@endif
@section('content')
    <div class="box project">
        <div class="project-box">
<style>
    #myCarousel .carousel-indicators{
        bottom: -50px !important;
    }
    .carousel-indicators li{
        border: 1px solid gray !important;
    }
    .carousel-indicators li.active{
        background-color: gray !important;
    }
</style>
            {{----------------------------- store current url to session -----------------------}}
            <?php session(['last_page' => url()->current()]);?>
            {{-------------------------------------------------------------------------------------}}

            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->


                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    @for($i=0;$i<$countImages;$i++)
                        <div class="item @if($i==0){{'active'}}@endif">
                            <img src="{{ url($post->screenshots[$i]) }}" style="width:100%;">
                        </div>
                    @endfor
                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
                <ol class="carousel-indicators">
                    @for($i=0;$i<$countImages;$i++)
                        <li data-target="#myCarousel" data-slide-to="{{ $i }}" class="@if($i==0){{'active'}}@endif"></li>
                    @endfor
                </ol>
            </div>
        </div>
    </div>

    <div class="project">
        <div class="project-desc">
            <div class="project-title">
                <h5>TAG LINES</h5>
                <div class="project-description col-md-12 col-xs-12">
                    {{ $post->tag_line }}
                </div>
            </div>
        </div>
    </div>

    <div class="project">
        <div class="project-desc">
            <div class="project-title">
                <h5>DETAILS</h5>
                <div class="project-description col-md-12 col-xs-12">
                    {!! $post->description !!}
                    </div>
            </div>
        </div>
    </div>


<div class="project">
    <div class="project-vote">
        <div class="row vote">
            <div class="col-md-6 share">
                <a href="#" class="btn btn-default btn-twitter"><i class="fa fa-twitter"></i>TWEET</a>
                <a href="#" class="btn btn-default btn-facebook"><i class="fa fa-facebook"></i>SHARE</a>
            </div>
            <div class="col-md-6 col-sm-6 " style="line-height: 30px;">

                <div class="col-md-5 col-sm-5 col-xs-5 up-btn">
                    @if($upVoteMatched == 1)
                        <a class="btn btn-xs" onclick="upVote({{
                        $post->id
                        }})"><span  id="btn_upVote_{{ $post->id }}" class="thumb-up glyphicon glyphicon-triangle-top" style="color: green"></span></a>
                        <span id="btn_upVote_text_{{ $post->id }}" class="vote-counter text-center" style="color: green;">Upvote</span>
                        <span class="vote-counter text-center" id="vote_count_{{ $post->id }}">{{ $votes }}</span>
                    @else
                        <a class="" onclick="upVote({{
                        $post->id
                        }})"><span id="btn_upVote_{{ $post->id }}" class="thumb glyphicon glyphicon-triangle-top" ></span></a>
                        <span id="btn_upVote_text_{{ $post->id }}" class="vote-counter text-center">Upvote</span>
                        <span  id="vote_count_{{ $post->id }}" class="vote-counter text-center">{{ $votes }}</span>
                    @endif

                </div>
                <div class="col-md-7 col-sm-7 col-xs-7">
                    <div class="col-md-2 col-sm-2 col-xs-2 p-0 down-btn">
                        @if($downVoteMatched == 1)
                            <a class="pull-right" onclick="downVote({{
                            $post->id
                            }})"><span id="btn_downVote_{{ $post->id }}" class="thumb-down glyphicon glyphicon-triangle-bottom" style="color: red"></span> </a>
                        @else
                            <a class="pull-right" onclick="downVote({{
                            $post->id
                            }})"><span id="btn_downVote_{{ $post->id }}" class="thumb glyphicon glyphicon-triangle-bottom"></span></a>
                        @endif
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 p-0 comment-btn text-center">
                            <a class=""><span ><span class="vote-counter text-center" id="vote_count_1"></span></span><i class="fa fa-comment"></i>{{ $totalComments }}</a>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 p-0 saved-btn">
                        @if($savedStory == 1)
                            <a class="pull-right" onclick="saveStory({{
                        $post->id
                        }})"><span><span class="vote-counter text-center"></span></span><i class="fa fa-bookmark saved" id="btn_saveStory_1" style="color: green"></i></a>
                        @else
                            <a class="pull-right" onclick="saveStory({{
                        $post->id
                        }})"><span></span><span class="vote-counter text-center" ></span><i class="fa fa-bookmark" id="btn_saveStory_1"></i></a>
                        @endif
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 p-0 operation-btn dropdown">

                        <button style="background-color: #fff; border: none;" class="pull-right dropdown-toggle" type="button" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-option-horizontal" ></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Edit</a></li>
                            <li><a href="#">Delete</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="comment-section">
            <div class="row comment-box">
                <form id="addNewStory" action="{{ route('project_comment.store') }}" method="POST" role="form">
                    {{ csrf_field() }}
                    <div class="col-md-10 col-sm-10 col-xs-10 form-group  pl-0">
                        <textarea name="comment" placeholder="Comment..." id="storyDesc"  class="form-control"></textarea>
                    </div>
                    {{--<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">--}}
                    <input type="hidden" name="project_id" value="{{ $post->id }}">
                    <div class="col-md-2 col-sm-2 col-xs-2 dis-n pr-0">
                        <button type="submit" name="storySubmit" id="storySubmit" class="btn btn-danger pull-right">Comment</button>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 dis-show pr-0">
                        <button type="submit" name="storySubmit" id="storySubmit" class="btn btn-danger pull-right">
                            <span class="thumb glyphicon glyphicon-send"></span>
                        </button>
                    </div>
                </form>
            </div>


            <div class="comment">
                @foreach($post->project_comments as $comment)
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-1 col-md-1">
                                    <a href="#">
                                        <img class="img-circle" src="{{ asset('img/profile-header-orginal.jpg') }}" alt="user profile">
                                    </a>
                                </div>
                                <div class="col-md-11 col-xs-11 pl-0">
                                    <span class="comment-user text-primary"><strong>{{ $comment->username }}</strong>&nbsp;
                                        <span class="small text-muted commentTime postTime">
                                            {{ $comment->created_at }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="comment-body">
                                <p>{{ $comment->comment }}</p>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <?php $commentVotes = 0;?>
                                    @foreach($post->project_comment_votes as $key=>$vote)
                                        @if($vote->comment_id == $comment->id)
                                        <?php
$commentVotes += $vote->vote;
?>
                                            @endif
                                    @endforeach
                                        <?php $upVoteCommentMatched = 0;?>
                                    @if(isset(Auth::user()->id) && !empty(Auth::user()->id))
                                        @foreach($post->project_comment_votes as $key=>$vote)
                                            @if($vote->user_id == Auth::user()->id && $vote->vote == 1 && $vote->comment_id == $comment->id)
                                                <?php $upVoteCommentMatched = 1;?>
                                                @break
                                            @endif
                                        @endforeach
                                    @endif

                                    @if($upVoteCommentMatched == 1)
                                        <a onclick="upVoteComment({{ $post->id.','.$comment->id }})" id="btn_upVote_comment_{{ $comment->id }}"  style="color: green"><span class="thumb-up glyphicon glyphicon-triangle-top"></span>Upvote
                                        <span class="vote-counter text-center" id="vote_count_comment_{{ $comment->id }}">{{ $commentVotes }}</span></a>
                                    @else
                                        <a onclick="upVoteComment({{ $post->id.','.$comment->id }})" id="btn_upVote_comment_{{ $comment->id }}"><span class="thumb glyphicon glyphicon-triangle-top" ></span>Upvote
                                        <span class="vote-counter text-center" id="vote_count_comment_{{ $comment->id }}">{{ $commentVotes }}</span></a>
                                    @endif
                                </div>
                            </div>
                            <div class="reply">
                                @foreach($post->project_replies as $reply)
                                    @if($comment->id == $reply->comment_id)
                                    <div class="panel panel-success">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-xs-1 col-md-1">
                                                    <a href="#">
                                                        <img class="img-circle" src="{{ asset('img/profile-header-orginal.jpg') }}" alt="user profile">
                                                    </a>
                                                </div>
                                                <div class="col-md-11 col-xs-11 pl-0">
                                                    <span class="reply-user text-primary"><strong>{{ $reply->username }}</strong>&nbsp;
                                                        <span class="small text-muted commentTime postTime">
                                                            {{ $reply->created_at }}
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="comment-body" style="max-width: 100%">
                                                <p>{{ $reply->reply }}</p>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <?php $commentReplyVotes = 0;?>
                                                    @foreach($post->project_comment_reply_votes as $key=>$vote)
                                                        @if($vote->comment_id == $comment->id && $vote->reply_id == $reply->id)
                                                            <?php
$commentReplyVotes += $vote->vote;
?>
                                                        @endif
                                                    @endforeach
                                                    <?php $upVoteCommentReplyMatched = 0;?>
                                                    @if(isset(Auth::user()->id) && !empty(Auth::user()->id))
                                                        @foreach($post->project_comment_reply_votes as $key=>$vote)
                                                            @if($vote->user_id == Auth::user()->id && $vote->vote == 1 && $vote->comment_id == $comment->id && $vote->reply_id == $reply->id)
                                                                <?php $upVoteCommentReplyMatched = 1;?>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                    @if($upVoteCommentReplyMatched == 1)
                                                        <a onclick="upVoteCommentReply({{ $post->id.','.$comment->id.','.$reply->id }})" id="btn_upVote_comment_reply_{{ $reply->id }}"  style="color: green"><span class="thumb-up glyphicon glyphicon-triangle-top"></span>Upvote
                                                            <span class="vote-counter text-center" id="vote_count_comment_reply_{{ $reply->id }}">{{ $commentReplyVotes }}</span></a>
                                                    @else
                                                        <a onclick="upVoteCommentReply({{ $post->id.','.$comment->id.','.$reply->id }})" id="btn_upVote_comment_reply_{{ $reply->id }}"><span class="thumb glyphicon glyphicon-triangle-top" ></span>Upvote
                                                            <span class="vote-counter text-center" id="vote_count_comment_reply_{{ $reply->id }}">{{ $commentReplyVotes }}</span></a>
                                                    @endif


                                                    {{--@if(False)--}}

                                                        {{--<a ><span   class="thumb-up glyphicon glyphicon-triangle-top" ></span>Upvote--}}
                                                        {{--<span class="vote-counter text-center" id="vote_count_{{ $post->id }}">{{ $votes }}</span> </a>--}}
                                                    {{--@else--}}
                                                        {{--<a ><span  class="thumb glyphicon glyphicon-triangle-top" ></span>Upvote--}}
                                                            {{--<span class="vote-counter text-center" id="vote_count_{{ $post->id }}">{{ $votes }}</span>--}}
                                                        {{--</a>--}}
                                                    {{--@endif--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach

                                <div class="row reply-box">
                                    <form id="addNewStory" action="{{ route('project_reply.store') }}" method="POST" role="form">
                                        {{ csrf_field() }}
                                        <div class="col-md-10 col-sm-10 col-xs-10 form-group">
                                            <textarea name="reply" placeholder="Reply..." id="storyDesc"  class="form-control" rows="1"></textarea>
                                        </div>
                                        {{--<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">--}}
                                        <input type="hidden" name="project_id" value="{{ $post->id }}">
                                        <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                        <div class="col-md-2 col-sm-2 col-xs-2 dis-n pr-0">
                        <button type="submit" name="storySubmit" id="storySubmit" class="btn btn-danger pull-right">Reply</button>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 dis-show pr-0">
                        <button type="submit" name="storySubmit" id="storySubmit" class="btn btn-danger pull-right">
                            <span class="thumb glyphicon glyphicon-send"></span>
                        </button>
                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>






@endsection
{{--
<div class="overlay"></div>
--}}
{{--</div>--}}
@section('js')
    <script src="{{ asset('xzoom/dist/xzoom.min.js') }}"></script>
    <script>
        $('.xzoom, .xzoom-gallery').xzoom({position: 'right', lensShape: 'square', bg:true, sourceClass: 'xzoom-hidden'});
    </script>
    <!-- Bootstrap Js CDN -->


    <script>

        $(document).ready(function(){

            $('[data-toggle="tooltip"]').tooltip();

        });
        $('.selectpicker').selectpicker();

        function upVote(post_id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var property = 'btn_upVote_'+post_id;
            console.log(post_id);
            $.ajax({
                type:'post',
                url: '{{url("project/upvote")}}',
                data: {_token: CSRF_TOKEN , project_id: post_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if(data.status == 'upvoted'){
                        var property = document.getElementById('btn_upVote_'+post_id);
                        property.style.color = "green";
                        var property = document.getElementById('btn_upVote_text_'+post_id);
                        property.style.color = "green"
                        $('#vote_count_'+post_id).text(data.voteNumber);
                        var property = document.getElementById('btn_downVote_'+post_id);
                        property.style.removeProperty('color');
                    } else{
                        var property = document.getElementById('btn_upVote_'+post_id);
                        property.style.removeProperty('color');
                        var property = document.getElementById('btn_upVote_text_'+post_id);
                        property.style.removeProperty('color');
                        $('#vote_count_'+post_id).text(data.voteNumber);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if(xhr.status==401) {
                        window.location.href = '{{url("login")}}';
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
                url: '{{url("project/downvote")}}',
                data: {_token: CSRF_TOKEN , project_id: post_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if(data.status == 'downvoted'){
                        var property = document.getElementById('btn_upVote_'+post_id);
                        property.style.removeProperty('color');
                        var property = document.getElementById('btn_upVote_text_'+post_id);
                        property.style.removeProperty('color');
                        var property = document.getElementById('btn_downVote_'+post_id);
                        property.style.color = "orangered"
                        $('#vote_count_'+post_id).text(data.voteNumber);
                    } else{
                        var property = document.getElementById('btn_downVote_'+post_id);
                        property.style.removeProperty('color');
                        $('#vote_count_'+post_id).text(data.voteNumber);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if(xhr.status==401) {
                        window.location.href = '{{url("login")}}';
                    }
                }
            });
        };

        function saveStory(post_id){
            var user_id = $('#save_story_user_id').val();
            $('#save_story_post_id').val(post_id);
            console.log(user_id);
            if(user_id==''){
                window.location.href = '{{url("login")}}';
            }else {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                console.log(post_id);
                $.ajax({
                    type:'post',
                    url: '{{url("saveStory")}}',
                    data: {_token: CSRF_TOKEN , post_id: post_id, user_id: user_id},
                    dataType: 'JSON',
                    success: function (data) {
                        console.log(data);
                        if(data.status == 'showModal'){
                            $('#saveStoryModal').modal('show');
                        } else{
                            var property = document.getElementById('btn_saveStory_'+post_id);
                            property.style.removeProperty('color');
                        }
                    }
                });

            }
        };

        function saveStoryData(){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var user_id = $('#save_story_user_id').val();
            var post_id = $('#save_story_post_id').val();
            var folder_id = $('#save_story_folder_id option:selected').val();
            console.log(folder_id);
            $.ajax({
                type:'post',
                url: '{{url("saveStory")}}',
                data: {_token: CSRF_TOKEN , post_id: post_id, user_id: user_id, folder_id: folder_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if(data.status == 'saved'){
                        var property = document.getElementById('btn_saveStory_'+post_id);
                        property.style.color = "green";
                        $('#saveStoryModal').modal('hide');
                    } else{
                        var property = document.getElementById('btn_saveStory_'+post_id);
                        property.style.removeProperty('color');
                    }
                }
            });
        };

        function upVoteComment(post_id,comment_id){

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            console.log(post_id);
            $.ajax({
                type:'post',
                url: '{{url("projectCommentVote")}}',
                data: {_token: CSRF_TOKEN , project_id: post_id, comment_id: comment_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if(data.status == 'upvoted'){
                        console.log('btn_upVote_comment_'+comment_id);
                        var property = document.getElementById('btn_upVote_comment_'+comment_id);
                        property.style.color = "green";
                        // var property = document.getElementById('btn_upVote_text_'+post_id);
                        // property.style.color = "green"
                        $('#vote_count_comment_'+comment_id).text(data.voteNumber);
                    } else{
                        var property = document.getElementById('btn_upVote_comment_'+comment_id);
                        property.style.removeProperty('color');
                        // var property = document.getElementById('btn_upVote_text_'+post_id);
                        // property.style.removeProperty('color');
                        $('#vote_count_comment_'+comment_id).text(data.voteNumber);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if(xhr.status==401) {
                        window.location.href = '{{url("login")}}';
                    }
                }
            });
        };

        function upVoteCommentReply(post_id,comment_id,reply_id){
            console.log(post_id);
            console.log(comment_id);
            console.log(reply_id);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type:'post',
                url: '{{url("projectCommentReplyVote")}}',
                data: {_token: CSRF_TOKEN , project_id: post_id, comment_id: comment_id, reply_id: reply_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if(data.status == 'upvoted'){
                        console.log('btn_upVote_comment_reply_'+reply_id);
                        var property = document.getElementById('btn_upVote_comment_reply_'+reply_id);
                        property.style.color = "green";
                        // var property = document.getElementById('btn_upVote_text_'+post_id);
                        // property.style.color = "green"
                        $('#vote_count_comment_reply_'+reply_id).text(data.voteNumber);
                    } else{
                        var property = document.getElementById('btn_upVote_comment_reply_'+reply_id);
                        property.style.removeProperty('color');
                        // var property = document.getElementById('btn_upVote_text_'+post_id);
                        // property.style.removeProperty('color');
                        $('#vote_count_comment_reply_'+reply_id).text(data.voteNumber);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if(xhr.status==401) {
                        window.location.href = '{{url("login")}}';
                    }
                }
            });
        };
    </script>


@endsection