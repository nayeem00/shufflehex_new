@extends('layouts.storyMaster')
<?php
$actual_link = URL::to('/');
$imageLink = $actual_link."/".$post->featured_image;
?>
@section('meta')
<title>{{ $post->title }}</title>
<meta name="description" content="{{ $post->metaDescription }}"/>
<meta name="keywords" content="{{ $post->tags }}">
<meta name="category" content="{{ $post->category }}">
<meta name="author" content="{{ $postUser->name }}">
<meta name="og:image" content="{{ $imageLink }}"/>
@endsection
@section('css')
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/view-story.css') }}">
@endsection
<?php
$embed = EmbedVideo::make($post->link)->parseUrl();
// Will return Embed class if provider is found. Otherwie will return false - not found. No fancy errors for now.
if ($embed) {
// Set width of the embed.
    $embed->setAttribute(['width' => 600]);

// Print html: '<iframe width="600" height="338" src="//www.youtube.com/embed/uifYHNyH-jA" frameborder="0" allowfullscreen></iframe>'.
    // Height will be set automatically based on provider width/height ratio.
    // Height could be set explicitly via setAttr() method.

}
?>

<?php
$upVoteMatched = 0;
$downVoteMatched = 0;
$savedStory = 0;
$votes = 0;
$date = date('j F Y', strtotime($post->created_at));

?>
@foreach($post->votes as $key=>$vote)
    <?php
    $votes += $vote->vote;
    ?>
@endforeach
@if(isset(Auth::user()->id) && !empty(Auth::user()->id))
    @foreach($post->votes as $key=>$vote)
        @if($vote->user_id == Auth::user()->id && $vote->vote == 1)
            <?php $upVoteMatched = 1;?>
            @break
        @endif
    @endforeach
    @foreach($post->votes as $key=>$vote)
        @if($vote->user_id == Auth::user()->id && $vote->vote == -1)
            <?php $downVoteMatched = 1;?>
            @break
        @endif
    @endforeach
    @foreach($post->saved_stories as $key=>$saved)
        @if($saved->user_id == Auth::user()->id && $saved->post_id == $post->id)
            <?php $savedStory = 1;?>
            @break
        @endif
    @endforeach
@endif
<?php
$title = preg_replace('/\s+/', '-', $post->title);
$title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
$title = $title . '-' . $post->id;
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
@section('content')
    {{----------------------------- store current url to session -----------------------}}
    <?php session(['last_page' => url()->current()]);?>
    {{-------------------------------------------------------------------------------------}}
    <div class="single-story-body">
        <div class="story-heading">
            <h1>{{ $post->title }}</h1>
            <p><span class="small"
                     style="color: #999999">Submitted by <strong>{{ $post->username }}</strong> at {{ $date }}
                    in <strong>{{ $post->category }}</strong></span></p>
        </div>
        <div class="feature-img">
            @if($post->is_video==1)
                <?php
                echo $embed->getHtml();
                ?>
            @else
                <img class="img-responsive" src="{{ url($post->featured_image) }}">
            @endif
            @if(isset($post->domain) && !empty($post->domain))
                <div class="link-source">
                    <span class="pull-left">source: <a href="{{ $post->link }}" target="_blank"
                                                       rel="nofollow">{{ $post->domain }}</a></span>
                </div>
            @endif
        </div>

        <div class="story-content">
            <p>
                {!! $post->description !!}
            </p>
        </div>

        <div class="row">
            <div class="col-md-12">
                @if($post->is_link==1)
                    <a class="btn btn-sm btn-block btn-danger btn-read-more" href="{{ url('view/'.$title) }}" target="_blank"
                       rel="nofollow">Read Full Story</a>
                @endif
            </div>
        </div>
    </div>
    <div class="row box vote-and-share mr-0 ml-0" style="margin-bottom: 15px !important;">
        <div class="col-xs-6">
            <a href="{{'https://twitter.com/intent/tweet?text='.$post->title. ' - '.  $actual_link }}" class="btn btn-default btn-twitter text-twitter" target="_blank" rel="nofollow"><i
                        class="fa fa-twitter"></i></a>
            <a href="{{'https://www.facebook.com/sharer/sharer.php?u='.$actual_link }}" class="btn btn-default btn-facebook text-facebook" target="_blank" rel="nofollow"><i class="fa fa-facebook"></i></a>
        </div>
        <div class="col-xs-6 text-right">
            <ul class="list-inline vote-submit-list mb-0">

                <li>
                    @if($upVoteMatched == 1)
                        <a class="btn text-shufflered" id="upvote_icon_{{$post->id}}" onclick="upVote({{$post->id}})">
                                <span class="shuffle_vote">
                                    <i class="fa fa-chevron-up"></i>
                                </span>
                        </a>
                    @else
                        <a class="btn" id="upvote_icon_{{$post->id}}" onclick="upVote({{$post->id}})">
                                <span class="shuffle_vote">
                                    <i class="fa fa-chevron-up"></i>
                                </span>
                        </a>
                    @endif
                    <span class="vote-counter" id="vote_count_{{$post->id}}">{{ $votes }}</span>
                    @if($downVoteMatched == 1)
                        <a class="btn text-shufflered" id="downvote_icon_{{$post->id}}"
                           onclick="downVote({{$post->id}})">
                                <span class="shuffle_vote">
                                    <i class="fa fa-chevron-down"></i>
                                </span>
                        </a>
                    @else
                        <a class="btn" id="downvote_icon_{{$post->id}}" onclick="downVote({{$post->id}})">
                                <span class="shuffle_vote">
                                    <i class="fa fa-chevron-down"></i>
                                </span>
                        </a>
                    @endif
                </li>

                @if($savedStory == 1)
                    <li>
                        <a class="btn" onclick="saveStory({{$post->id}})">
                                <span class="saved"><i class="fa fa-bookmark text-shufflered" id="btn_saveStory_{{ $post->id }}"></i></span>
                        </a>
                    </li>

                @else
                    <li><a class="btn" onclick="saveStory({{$post->id}})">
                            <span class="saved">
                                <i class="fa fa-bookmark" id="btn_saveStory_{{ $post->id }}"></i>
                            </span>
                        </a>
                    </li>
                @endif
                @if(isset(Auth::user()->id) && !empty(Auth::user()->id))
                    @if($postUser->id == Auth::user()->id)
                        <li class="dropdown">
                            <a href="#" style="background-color: #fff; border: none;" class="btn dropdown-toggle"
                               type="button"
                               data-toggle="dropdown">
                                <i class="fa fa-ellipsis-v"></i></a>
                            <ul class="edit-menu dropdown-menu">
                                <li><a href="{{ url('story/'.$title.'/edit') }}">Edit</a></li>
                                <li><a href="#">Delete</a></li>
                            </ul>
                        </li>
                    @endif
                @endif
            </ul>


        </div>
    </div>

    <div class="box recent-stories vote">
        <div class="box-header">Related Stories</div>
        @foreach($relatedPost as $relPost)
            <?php
            $upVoteMatched = 0;
            $votes = 0;
            ?>
            @foreach($relPost->votes as $key=>$vote)
                <?php
                $votes += $vote->vote;
                ?>
            @endforeach
            @if(isset(Auth::user()->id) && !empty(Auth::user()->id))
                @foreach($relPost->votes as $key=>$vote)
                    @if($vote->user_id == Auth::user()->id && $vote->vote == 1)
                        <?php $upVoteMatched = 1;?>
                        @break
                    @endif
                @endforeach
            @endif
            <?php
            $title = preg_replace('/\s+/', '-', $relPost->title);
            $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
            $title = $title . '-' . $relPost->id;
            ?>
            <div class="row stories-item">
                <div class="col-sm-12 pr-0 pl-0">
                    <div class="img_box57_32">
                        <a href="{{ url('story/'.$title) }}">
                            <img class="img-responsive" src="{{ url($relPost->related_story_image) }}"
                                 alt="Image not found!">
                        </a>
                    </div>
                    <div class="img_box57_right mr-40">
                        <a href="{{ url('story/'.$title) }}"><span class="story-title">{{ $relPost->title }}</span></a>
                    </div>
                    <div class="vote-submit-right text-center pull-right">
                        @if($upVoteMatched == 1)
                            <a class="text-center" onclick="upVote({{ $relPost->id }})">
                                <span class="vote-icon text-shufflered" id="upvote_icon_{{$relPost->id}}">
                                    <i class="fa fa-chevron-up"></i>
                                </span>
                                <span class="vote-counter" id="vote_count_{{$relPost->id}}">{{ $votes }}</span>
                            </a>
                        @else
                            <a class="text-center" onclick="upVote({{ $relPost->id }})">
                                <span class="vote-icon" id="upvote_icon_{{$relPost->id}}">
                                    <i class="fa fa-chevron-up"></i>
                                </span>
                                <span class="vote-counter" id="vote_count_{{$relPost->id}}">{{ $votes }}</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="box about-author">
        <div class="box-header">
            <div class="pull-left">
                <h4>About The Author</h4>
            </div>
            <div class="pull-right">
                <a class="btn btn-danger" href="#">Donate Author</a>
            </div>
        </div>
        <div class="pa-15">
            <div class="author">
                <img class="img-responsive author-img"
                     src="@if (!empty($postUser->mini_profile_picture_link)) {{ asset( $postUser->mini_profile_picture_link) }} @else {{ asset( 'images/user/profilePicture/default/user.png') }} @endif">
                <p class="author-name"><strong>{{ $postUser->name }}</strong></p>
            </div>
            @if(!empty($postUser->work_at))
                <div class="info">
                    <span class="info-icon"><i class="fa fa-briefcase"></i></span>
                    <p class="info-txt">Works at <strong>{{ $postUser->work_at }}</strong></p>
                </div>
            @endif
            @if(!empty($postUser->education))
                <div class="info">
                    <span class="info-icon"><i class="fa fa-graduation-cap "></i></span>
                    <p class="info-txt">Studied at <strong>{{ $postUser->education }}</strong></p>
                </div>
            @endif
            @if(!empty($postUser->location))
                <div class="info">
                    <span class="info-icon"><i class="fa fa-map-marker"></i></span>
                    <p class="info-txt">Lives in <strong>{{ $postUser->location }}</strong></p>
                </div>
            @endif
            @if(!empty($postUser->languages))
                <div class="info">
                    <span class="info-icon"><i class="fa fa-globe"></i></span>
                    <p class="info-txt">Knows <strong>{{ $postUser->languages }}</strong></p>
                </div>
            @endif
            @if(!empty($totalViews))
                <div class="info">
                    <span class="info-icon"><i class="fa fa-eye"></i></span>
                    <p class="info-txt">{{ $totalViews }} Total Stories Views <br>
                        <span class="light-title-sub">{{ $post->views }} views in this post</span>
                    </p>
                </div>
            @endif
        </div>
    </div>

    <div class="comment-section">
        <div class="row comment-box">
            <form id="addNewStory" action="{{ route('comment.store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="form-group">
                    <textarea name="reply" placeholder="Comment..." id="storyDesc" class="form-control"></textarea>
                </div>
                {{--<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">--}}
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <div class="form-group" style="margin-top: 10px">
                    <button type="submit" name="storySubmit" id="storySubmit" class="btn btn-danger pull-right">
                        Comment
                    </button>
                </div>
            </form>
        </div>


        <div class="comment">
            @foreach($post->comments as $comment)
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-10 col-xs-10 col-sm-10">
                                <div class="img-box32_32">
                                    <a href="{{ url('profile/'.$comment->user->username) }}">
                                        <img class="img-circle"
                                             src="@if (!empty($comment->user->mini_profile_picture_link)) {{ asset( $comment->user->profile_picture_link) }} @else {{ asset( 'images/user/profilePicture/default/user.png') }} @endif"
                                             alt="user profile">
                                    </a>
                                </div>
                                <div class="img_box32_right">
                                    <span class="comment-user text-primary"><strong><a
                                                    href="{{ url('profile/'.$comment->user->username) }}"
                                                    rel="nofollow">{{ $comment->username }}</a></strong>&nbsp;
                                        <span class="small text-muted commentTime postTime">
                                            {{ $comment->created_at }}
                                        </span>
                                    </span>
                                </div>

                            </div>
                            <div class="col-md-2 col-xs-2 col-sm-2">
                                <?php $commentVotes = 0;?>
                                @foreach($post->comment_votes as $key=>$vote)
                                    @if($vote->comment_id == $comment->id)
                                        <?php
                                        $commentVotes += $vote->vote;
                                        ?>
                                    @endif
                                @endforeach
                                <?php $upVoteCommentMatched = 0;?>
                                @if(isset(Auth::user()->id) && !empty(Auth::user()->id))
                                    @foreach($post->comment_votes as $key=>$vote)
                                        @if($vote->user_id == Auth::user()->id && $vote->vote == 1 && $vote->comment_id == $comment->id)
                                            <?php $upVoteCommentMatched = 1;?>
                                            @break
                                        @endif
                                    @endforeach
                                @endif

                                @if($upVoteCommentMatched == 1)
                                    <a onclick="upVoteComment({{ $post->id.','.$comment->id }})">
                                        <span class="thumb-up fa fa-chevron-up text-shufflered" id="btn_upVote_comment_{{ $comment->id }}"></span>
                                        <span class="vote-counter text-center"
                                              id="vote_count_comment_{{ $comment->id }}">{{ $commentVotes }}</span></a>
                                @else
                                    <a onclick="upVoteComment({{ $post->id.','.$comment->id }})">
                                        <span class="thumb fa fa-chevron-up" id="btn_upVote_comment_{{ $comment->id }}"></span>
                                        <span class="vote-counter text-center"
                                              id="vote_count_comment_{{ $comment->id }}">{{ $commentVotes }}</span></a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="comment-body">
                            <p>{{ $comment->comment }}</p>
                        </div>
                        <div class="reply">
                            @foreach($post->replies as $reply)
                                @if($comment->id == $reply->comment_id)
                                    <div class="panel panel-success">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-md-10 col-xs-10 col-sm-10">
                                                    <div class="img-box32_32">
                                                        <a href="{{ url('profile/'.$reply->user->username) }}">
                                                            <img class="img-circle"
                                                                 src="@if (!empty($reply->user->mini_profile_picture_link)) {{ asset( $reply->user->profile_picture_link) }} @else {{ asset( 'images/user/profilePicture/default/user.png') }} @endif"
                                                                 alt="user profile">
                                                        </a>
                                                    </div>
                                                    <div class="img_box32_right">
                                                        <span class="reply-user text-primary"><strong><a
                                                                        href="{{ url('profile/'.$reply->user->username) }}"
                                                                        rel="nofollow"> {{ $reply->username }}</a></strong>&nbsp;
                                                        <span class="small text-muted commentTime postTime">
                                                            {{ $reply->created_at }}
                                                        </span>
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-xs-2 col-sm-2">
                                                    <?php $commentReplyVotes = 0;?>
                                                    @foreach($post->comment_reply_votes as $key=>$vote)
                                                        @if($vote->comment_id == $comment->id && $vote->reply_id == $reply->id)
                                                            <?php
                                                            $commentReplyVotes += $vote->vote;
                                                            ?>
                                                        @endif
                                                    @endforeach
                                                    <?php $upVoteCommentReplyMatched = 0;?>
                                                    @if(isset(Auth::user()->id) && !empty(Auth::user()->id))
                                                        @foreach($post->comment_reply_votes as $key=>$vote)
                                                            @if($vote->user_id == Auth::user()->id && $vote->vote == 1 && $vote->comment_id == $comment->id && $vote->reply_id == $reply->id)
                                                                <?php $upVoteCommentReplyMatched = 1;?>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                    @if($upVoteCommentReplyMatched == 1)
                                                        <a onclick="upVoteCommentReply({{ $post->id.','.$comment->id.','.$reply->id }})"><span class="thumb-up fa fa-chevron-up text-shufflered" id="btn_upVote_comment_reply_{{ $reply->id }}"></span>
                                                            <span class="vote-counter text-center"
                                                                  id="vote_count_comment_reply_{{ $reply->id }}">{{ $commentReplyVotes }}</span></a>
                                                    @else
                                                        <a onclick="upVoteCommentReply({{ $post->id.','.$comment->id.','.$reply->id }})"><span class="thumb fa fa-chevron-up" id="btn_upVote_comment_reply_{{ $reply->id }}"></span>
                                                            <span class="vote-counter text-center"
                                                                  id="vote_count_comment_reply_{{ $reply->id }}">{{ $commentReplyVotes }}</span></a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="comment-body" style="max-width: 100%">
                                                <p>{{ $reply->reply }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            <div class="row reply-box">
                                <form id="addNewStory" action="{{ route('reply.store') }}" method="POST" role="form">
                                    {{ csrf_field() }}
                                    <div class="col-md-10 col-sm-10 col-xs-10 form-group">
                                        <textarea name="reply" placeholder="Reply..." id="storyDesc"
                                                  class="form-control" rows="1"></textarea>
                                    </div>
                                    {{--<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">--}}
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
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
    <!-- save url modal -->
    <div class="save-page-modal modal fade" id="saveStoryModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center"><i class="fa fa-plus-circle"></i> Save New Story</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('folderStory.store') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Select a folder to save this story.</label>
                            @if(isset($folders) && !empty($folders))
                                <select class="selectpicker" data-live-search="true" name="folder_id"
                                        id="save_story_folder_id">
                                    @foreach($folders as $folder)
                                        <option value="{{ $folder->id }}"
                                                data-tokens="{{ $folder->folder_name }}">{{ $folder->folder_name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                        <input type="hidden" name="post_id" class="form-control" id="save_story_post_id">
                        @if(isset(Auth::user()->id) && !empty(Auth::user()->id))
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" id="save_story_user_id">
                        @else
                            <input type="hidden" name="user_id" value="" id="save_story_user_id">
                        @endif
                        <div class="form-group">
                            <button type="button" class="btn btn-block btn-danger" onclick="saveStoryData()">Save
                                Story
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection




@section('js')

    <script>
        function upVote(post_id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var property = 'btn_upVote_' + post_id;
            console.log(post_id);
            $.ajax({
                type: 'post',
                url: '{{url("vote")}}',
                data: {_token: CSRF_TOKEN, post_id: post_id},
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
        };

        function downVote(post_id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var property = 'btn_downVote_' + post_id;
            console.log(property);
            $.ajax({
                type: 'post',
                url: '{{url("vote/downVote")}}',
                data: {_token: CSRF_TOKEN, post_id: post_id},
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
                            var element = document.getElementById('btn_saveStory_' + post_id);
                            element.classList.remove("text-shufflered");
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
                        var element = document.getElementById('btn_saveStory_' + post_id);
                        element.classList.add("text-shufflered");
                        $('#saveStoryModal').modal('hide');
                    } else {
                        var element = document.getElementById('btn_saveStory_' + post_id);
                        element.classList.remove("text-shufflered");
                    }
                }
            });
        };

        function upVoteComment(post_id, comment_id) {

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            console.log(post_id);
            $.ajax({
                type: 'post',
                url: '{{url("commentVote")}}',
                data: {_token: CSRF_TOKEN, post_id: post_id, comment_id: comment_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if (data.status == 'upvoted') {
                        console.log('btn_upVote_comment_' + comment_id);
                        var element = document.getElementById('btn_upVote_comment_' + comment_id);
                        element.classList.add("text-shufflered");
                        $('#vote_count_comment_' + comment_id).text(data.voteNumber);
                    } else {
                        var element = document.getElementById('btn_upVote_comment_' + comment_id);
                        element.classList.remove("text-shufflered");
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
                url: '{{url("commentReplyVote")}}',
                data: {_token: CSRF_TOKEN, post_id: post_id, comment_id: comment_id, reply_id: reply_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if (data.status == 'upvoted') {
                        console.log('btn_upVote_comment_reply_' + reply_id);
                        var element = document.getElementById('btn_upVote_comment_reply_' + reply_id);
                        element.classList.add("text-shufflered");
                        $('#vote_count_comment_reply_' + reply_id).text(data.voteNumber);
                    } else {
                        var element = document.getElementById('btn_upVote_comment_reply_' + reply_id);
                        element.classList.remove("text-shufflered");
                        $('#vote_count_comment_reply_' + reply_id).text(data.voteNumber);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if (xhr.status == 401) {
                        window.location.href = '{{url("login")}}';
                    }
                }
            });
        };

    </script>
@endsection