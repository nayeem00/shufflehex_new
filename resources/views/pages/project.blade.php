@extends('layouts.project')
<?php
$actual_link = URL::to('/');
$imageLink = $actual_link."/".$post->logo;
$title = preg_replace('/\s+/', '-', $post->title);
$title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
$title = $title . '-' . $post->id;
$projectUrl = $actual_link.'/project/'.$title;
?>
@section('meta')
    <title>{{ $post->title }} | ShuffleHex.com</title>
    <meta name="description" content="{{ $post->tag_line }}"/>
    <meta name="keywords" content="{{ $post->tags }}">
    <meta name="category" content="{{ $post->category }}">
    <meta name="og:image" content="{{ $imageLink }}"/>
@endsection
@section('css')
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/add.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/project.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/view-story.css') }}">
    <link rel="stylesheet" href="{{ asset('slick1.8/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('slick1.8/slick-theme.css') }}">


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
    <?php session(['last_page' => url()->current()]);?>
    <div class="row box project">
        <div class="col-xs-12">
            <div id="project_carousel" class="slick-slider dis-n">
                @for($i=0;$i<$countImages;$i++)
                    <div>
                        <img class="img-responsive" src="{{ url($post->screenshots[$i]) }}">
                    </div>
                @endfor
            </div>
        </div>
    </div>


    <div class="row box project">
        <div class="col-xs-12">
            <div class="project-title">
                <h5 class="font16 bold-600">TAG LINES</h5>
            </div>
            <div class="project-description">
                <p>{{ $post->tag_line }}</p>
            </div>
        </div>
    </div>
    <div class="row box project">
        <div class="col-xs-12">
            <div class="project-title">
                <h5 class="font16 bold-600">DETAILS</h5>
            </div>
            <div class="project-description">
                {!! $post->description !!}
            </div>
        </div>
    </div>
    <div class="row box vote-and-share">
        <div class="col-xs-6">
            <a href="#" class="btn btn-default btn-twitter text-twitter"><i
                        class="fa fa-twitter"></i></a>
            <a href="#" class="btn btn-default btn-facebook text-facebook"><i class="fa fa-facebook"></i></a>
        </div>
        <div class="col-xs-6 text-right">
            <ul class="list-inline vote-submit-list mb-0">
                <li>
                    @if($upVoteMatched == 1)
                        <a class="btn"  onclick="upVote({{$post->id}})">
                                <span class="shuffle_vote">
                                    <i class="fa fa-chevron-up text-shufflered" id="upvote_icon_{{$post->id}}"></i>
                                </span>
                        </a>
                    @else
                        <a class="btn" onclick="upVote({{$post->id}})">
                                <span class="shuffle_vote">
                                    <i class="fa fa-chevron-up" id="upvote_icon_{{$post->id}}"></i>
                                </span>
                        </a>
                    @endif
                    <span class="vote-counter" id="vote_count_{{$post->id}}">{{ $votes }}</span>
                    @if($downVoteMatched == 1)
                        <a class="btn" onclick="downVote({{$post->id}})">
                                <span class="shuffle_vote">
                                    <i class="fa fa-chevron-down text-shufflered" id="downvote_icon_{{$post->id}}"></i>
                                </span>
                        </a>
                    @else
                        <a class="btn" onclick="downVote({{$post->id}})">
                                <span class="shuffle_vote">
                                    <i class="fa fa-chevron-down" id="downvote_icon_{{$post->id}}"></i>
                                </span>
                        </a>
                    @endif
                </li>
                @if($savedStory == 1)
                    <li>
                        <a class="btn" onclick="saveStory({{$post->id}})">
                                <span class="saved" id="btn_saveStory_{{ $post->id }}"><i
                                            class="fa fa-bookmark"></i></span>
                        </a>
                    </li>

                @else
                    <li><a class="btn" onclick="saveStory({{$post->id}})">
                            <span class="saved" id="btn_saveStory_{{ $post->id }}">
                                <i class="fa fa-bookmark"></i>
                            </span>
                        </a>
                    </li>
                @endif
                <li class="dropdown">
                    <a href="#" style="background-color: #fff; border: none;" class="btn dropdown-toggle"
                       type="button"
                       data-toggle="dropdown">
                        <i class="fa fa-ellipsis-v"></i></a>
                    <ul class="edit-menu dropdown-menu">
                        <li><a href="{{ url('project/'.$title.'/edit') }}">Edit</a></li>
                        <li><a href="#">Delete</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="row box comment-section">
        <div class="comment-box">
            <form id="addNewStory" action="{{ route('project_comment.store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <input type="hidden" name="project_id" value="{{ $post->id }}">
                <div class="form-group">
                    <textarea name="comment" placeholder="Comment..." id="storyDesc" class="form-control"></textarea>
                </div>

                <div class="form-group" style="margin-top: 10px">
                    <button type="submit" name="storySubmit" id="storySubmit" class="btn btn-danger pull-right">
                        Comment
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
                                    <img class="img-circle" src="{{ asset('img/profile-header-orginal.jpg') }}"
                                         alt="user profile">
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
                                    <a onclick="upVoteComment({{ $post->id.','.$comment->id }})"
                                       id="btn_upVote_comment_{{ $comment->id }}" style="color: green"><span
                                                class="thumb-up glyphicon glyphicon-triangle-top"></span>Upvote
                                        <span class="vote-counter text-center"
                                              id="vote_count_comment_{{ $comment->id }}">{{ $commentVotes }}</span></a>
                                @else
                                    <a onclick="upVoteComment({{ $post->id.','.$comment->id }})"
                                       id="btn_upVote_comment_{{ $comment->id }}"><span
                                                class="thumb glyphicon glyphicon-triangle-top"></span>Upvote
                                        <span class="vote-counter text-center"
                                              id="vote_count_comment_{{ $comment->id }}">{{ $commentVotes }}</span></a>
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
                                                        <img class="img-circle"
                                                             src="{{ asset('img/profile-header-orginal.jpg') }}"
                                                             alt="user profile">
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
                                                        <a onclick="upVoteCommentReply({{ $post->id.','.$comment->id.','.$reply->id }})"
                                                           id="btn_upVote_comment_reply_{{ $reply->id }}"
                                                           style="color: green"><span
                                                                    class="thumb-up glyphicon glyphicon-triangle-top"></span>Upvote
                                                            <span class="vote-counter text-center"
                                                                  id="vote_count_comment_reply_{{ $reply->id }}">{{ $commentReplyVotes }}</span></a>
                                                    @else
                                                        <a onclick="upVoteCommentReply({{ $post->id.','.$comment->id.','.$reply->id }})"
                                                           id="btn_upVote_comment_reply_{{ $reply->id }}"><span
                                                                    class="thumb glyphicon glyphicon-triangle-top"></span>Upvote
                                                            <span class="vote-counter text-center"
                                                                  id="vote_count_comment_reply_{{ $reply->id }}">{{ $commentReplyVotes }}</span></a>
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
                                <form id="addNewStory" action="{{ route('project_reply.store') }}" method="POST"
                                      role="form">
                                    {{ csrf_field() }}
                                    <div class="col-md-10 col-sm-10 col-xs-10 form-group">
                                        <textarea name="reply" placeholder="Reply..." id="storyDesc"
                                                  class="form-control" rows="1"></textarea>
                                    </div>
                                    {{--<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">--}}
                                    <input type="hidden" name="project_id" value="{{ $post->id }}">
                                    <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                    <div class="col-md-2 col-sm-2 col-xs-2 dis-n pr-0">
                                        <button type="submit" name="storySubmit" id="storySubmit"
                                                class="btn btn-danger pull-right">Reply
                                        </button>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-2 dis-show pr-0">
                                        <button type="submit" name="storySubmit" id="storySubmit"
                                                class="btn btn-danger pull-right">
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
@section('js')
    <script src="{{ asset('slick1.8/slick.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('.slick-slider').slick({
                dots: true,
                infinite: true,
                speed: 500,
                fade: true,
                autoplay: true,
                cssEase: 'linear'
            });
            setTimeout(function(){
                // document.getElementsByClassName('slick-slider').style.display = 'block';
                $('.slick-slider').css('display', 'block');
            }, 500);

        });
    </script>
    <script>
        function upVote(post_id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var property = 'btn_upVote_' + post_id;
            console.log(post_id);
            $.ajax({
                type: 'post',
                url: '{{url("project/upvote")}}',
                data: {_token: CSRF_TOKEN, project_id: post_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if (data.status == 'upvoted') {
                        var element = document.getElementById("upvote_icon_" + post_id);
                        element.classList.add("text-shufflered");
                        $('#vote_count_' + post_id).text(data.voteNumber);
                        var element = document.getElementById("downvote_icon_" + post_id);
                        element.classList.remove("text-shufflered");
                    } else {
                        var element = document.getElementById("upvote_icon_" + post_id);
                        element.classList.remove("text-shufflered");
                        $('#vote_count_' + post_id).text(data.voteNumber);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if (xhr.status == 401) {
                        window.location.href = '{{url("login")}}';
                    }
                }
            });
        }

        function downVote(post_id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var property = 'btn_downVote_' + post_id;
            console.log(property);
            $.ajax({
                type: 'post',
                url: '{{url("project/downvote")}}',
                data: {_token: CSRF_TOKEN, project_id: post_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if (data.status == 'downvoted') {
                        var element = document.getElementById("upvote_icon_" + post_id);
                        element.classList.remove("text-shufflered");
                        var element = document.getElementById("downvote_icon_" + post_id);
                        element.classList.add("text-shufflered");
                        $('#vote_count_' + post_id).text(data.voteNumber);
                    } else {
                        var element = document.getElementById("downvote_icon_" + post_id);
                        element.classList.remove("text-shufflered");
                        $('#vote_count_' + post_id).text(data.voteNumber);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if (xhr.status == 401) {
                        window.location.href = '{{url("login")}}';
                    }
                }
            });
        };

        function saveStory(post_id) {
            var user_id = $('#save_story_user_id').val();
            $('#save_story_post_id').val(post_id);
            console.log(user_id);
            if (user_id == '') {
                window.location.href = '{{url("login")}}';
            } else {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                console.log(post_id);
                $.ajax({
                    type: 'post',
                    url: '{{url("saveStory")}}',
                    data: {_token: CSRF_TOKEN, post_id: post_id, user_id: user_id},
                    dataType: 'JSON',
                    success: function (data) {
                        console.log(data);
                        if (data.status == 'showModal') {
                            $('#saveStoryModal').modal('show');
                        } else {
                            var property = document.getElementById('btn_saveStory_' + post_id);
                            property.style.removeProperty('color');
                        }
                    }
                });

            }
        };

        function saveStoryData() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var user_id = $('#save_story_user_id').val();
            var post_id = $('#save_story_post_id').val();
            var folder_id = $('#save_story_folder_id option:selected').val();
            console.log(folder_id);
            $.ajax({
                type: 'post',
                url: '{{url("saveStory")}}',
                data: {_token: CSRF_TOKEN, post_id: post_id, user_id: user_id, folder_id: folder_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if (data.status == 'saved') {
                        var property = document.getElementById('btn_saveStory_' + post_id);
                        property.style.color = "green";
                        $('#saveStoryModal').modal('hide');
                    } else {
                        var property = document.getElementById('btn_saveStory_' + post_id);
                        property.style.removeProperty('color');
                    }
                }
            });
        };

        function upVoteComment(post_id, comment_id) {

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            console.log(post_id);
            $.ajax({
                type: 'post',
                url: '{{url("projectCommentVote")}}',
                data: {_token: CSRF_TOKEN, project_id: post_id, comment_id: comment_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if (data.status == 'upvoted') {
                        console.log('btn_upVote_comment_' + comment_id);
                        var property = document.getElementById('btn_upVote_comment_' + comment_id);
                        property.style.color = "green";
                        // var property = document.getElementById('btn_upVote_text_'+post_id);
                        // property.style.color = "green"
                        $('#vote_count_comment_' + comment_id).text(data.voteNumber);
                    } else {
                        var property = document.getElementById('btn_upVote_comment_' + comment_id);
                        property.style.removeProperty('color');
                        // var property = document.getElementById('btn_upVote_text_'+post_id);
                        // property.style.removeProperty('color');
                        $('#vote_count_comment_' + comment_id).text(data.voteNumber);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if (xhr.status == 401) {
                        window.location.href = '{{url("login")}}';
                    }
                }
            });
        };

        function upVoteCommentReply(post_id, comment_id, reply_id) {
            console.log(post_id);
            console.log(comment_id);
            console.log(reply_id);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'post',
                url: '{{url("projectCommentReplyVote")}}',
                data: {_token: CSRF_TOKEN, project_id: post_id, comment_id: comment_id, reply_id: reply_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if (data.status == 'upvoted') {
                        console.log('btn_upVote_comment_reply_' + reply_id);
                        var property = document.getElementById('btn_upVote_comment_reply_' + reply_id);
                        property.style.color = "green";
                        // var property = document.getElementById('btn_upVote_text_'+post_id);
                        // property.style.color = "green"
                        $('#vote_count_comment_reply_' + reply_id).text(data.voteNumber);
                    } else {
                        var property = document.getElementById('btn_upVote_comment_reply_' + reply_id);
                        property.style.removeProperty('color');
                        // var property = document.getElementById('btn_upVote_text_'+post_id);
                        // property.style.removeProperty('color');
                        $('#vote_count_comment_reply_' + reply_id).text(data.voteNumber);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if (xhr.status == 401) {
                        window.location.href = '{{url("login")}}';
                    }
                }
            });
        }
    </script>

    {{------------------------------------ schema for software application -------------------------------}}

        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Thing",
          "name": "{{ $post->title }}",
          "description": "{{ $post->tag_line }}",
          "image": "{{ $imageLink }}",
          "url": "{{ $projectUrl }}"
        }
        </script>
@endsection