@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/view-story.css') }}">

    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/add.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/poll.css') }}">
    <style>
        .item-form{
            margin-top: 20px;
        }
        #addItemForm .btn-add-more{
            margin: 15px auto;
        }
    </style>
@endsection
@section('content')

    {{----------------------------- store current url to session -----------------------}}
    <?php session(['last_page' => url()->current()]); ?>
    {{-------------------------------------------------------------------------------------}}

    <div class="box poll-details">
        <div class="box-header">
            <h3 class="font18">{{ $post->title }}</h3>
            <p class="mb-0" style="font-size: 12px"><span>Submitted by <strong><i
                                class="fa fa-user"></i>&nbsp;{{ $post->username }}</strong> at {{ $post->created_at }}
                    in <strong><i class="fa fa-tag"></i>&nbsp;{{ $post->category }}</strong></span></p>
        </div>
        <div class="plr-20">
            <img class="img-responsive" src="{{ url($post->featured_image) }}">
        </div>

        <div class="poll-content">
            <p> {!! $post->description !!}  </p>
        </div>


        <div id="addItemBlock" style="padding: 10px 20px;">
            <form id="addItemForm" class="addLinksForm" action="{{ route('poll_item.store') }}" method="POST" enctype="multipart/form-data" role="form">
                {{ csrf_field() }}
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <div id="item_form_element"></div>
                <div class="form-group">
                    <a class="btn btn-add-more btn-block btn-default" onclick="AddListItemForm(event)"><i class="fa fa-plus-circle"></i> Add Item </a>
                </div>
                <div class="form-group">
                <input type="submit" class="btn btn-publish btn-danger btn-block hidden" value="Publish">
                </div>
            </form>

        </div>
        <?php $count = 0;
        //        print_r($post->poll_items->poll_votes);
        //        die();
        ?>
        @foreach($post->poll_items as $item)
            <?php
            $upVoteMatched = 0;
            $downVoteMatched = 0;
            ?>
            @if(isset($item->poll_item_vote->vote) && !empty($item->poll_item_vote->vote) && $item->poll_item_vote->vote== 1)
                <?php
                $upVoteMatched = 1;
                ?>
            @elseif(isset($item->poll_item_vote->vote) && !empty($item->poll_item_vote->vote) && $item->poll_item_vote->vote== -1)
                    <?php
                    $downVoteMatched = 1;
                    ?>

            @endif
            <?php $count++;
            ?>
            <div class="row poll m-0">
                <div class="col-xs-12">
                    <h3 class="poll-title pull-left">
                        <a class="font16 bold-600" href="{{ $item->link }}">{{ $item->title }}</a>
                    </h3>
                    <div class="pull-right">
                        @if($upVoteMatched == 1)
                            <a class="btn btn-xs btn-vote-submit text-shufflered" onclick="upVote({{ $item->id }})">
                                <i class="fa fa-chevron-up"></i>
                                <span class="vote-counter text-center">{{ $item->upvotes }}</span>
                            </a>
                        @else
                            <a class="btn btn-xs btn-vote-submit" onclick="upVote({{ $item->id }})"><i
                                        class="fa fa-chevron-up"></i>
                                <span class="vote-counter text-center">{{ $item->upvotes }}</span>
                            </a>
                        @endif
                        @if($downVoteMatched == 1)
                            <a class="btn btn-xs btn-vote-submit text-shufflered" onclick="downVote({{ $item->id }})">
                                <i class="fa fa-chevron-down"></i>
                                <span class="vote-counter text-center">{{ $item->downvotes }}</span>
                            </a>
                        @else
                            <a class="btn btn-xs btn-vote-submit" onclick="downVote({{ $item->id }})">
                                <i class="fa fa-chevron-down"></i>
                                <span class="vote-counter text-center">{{ $item->downvotes }}</span>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="poll-img w-100">
                        <img class="img-responsive w-100" src="{{ url($item->featured_image) }}">
                    </div>
                    <div class="poll-desc">
                        <p>{{ $item->description }}</p>
                    </div>
                </div>
            </div>

        @endforeach
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
                            <a class="text-center text-shufflered" onclick="upVote({{ $relPost->id }})">
                                <span class="vote-icon">
                                    <i class="fa fa-chevron-up"></i>
                                </span>
                                <span class="vote-counter">{{ $votes }}</span>
                            </a>
                        @else
                            <a class="text-center" onclick="upVote({{ $relPost->id }})">
                                <span class="vote-icon">
                                    <i class="fa fa-chevron-up"></i>
                                </span>
                                <span class="vote-counter">{{ $votes }}</span>
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
                     src="@if (!empty($user->mini_profile_picture_link)) {{ asset( $user->mini_profile_picture_link) }} @else {{ asset( 'images/user/profilePicture/default/user.png') }} @endif">
                <p class="author-name"><strong>{{ $user->name }}</strong></p>
            </div>
            @if(!empty($user->work_at))
                <div class="info">
                    <span class="info-icon"><i class="fa fa-briefcase"></i></span>
                    <p class="info-txt">Works at <strong>{{ $user->work_at }}</strong></p>
                </div>
            @endif
            @if(!empty($user->education))
                <div class="info">
                    <span class="info-icon"><i class="fa fa-graduation-cap "></i></span>
                    <p class="info-txt">Studied at <strong>{{ $user->education }}</strong></p>
                </div>
            @endif
            @if(!empty($user->location))
                <div class="info">
                    <span class="info-icon"><i class="fa fa-map-marker"></i></span>
                    <p class="info-txt">Lives in <strong>{{ $user->location }}</strong></p>
                </div>
            @endif
            @if(!empty($user->languages))
                <div class="info">
                    <span class="info-icon"><i class="fa fa-globe"></i></span>
                    <p class="info-txt">Knows <strong>{{ $user->languages }}</strong></p>
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
                        <i class="fa fa-send"></i>
                    </button>
                </div>
            </form>
        </div>


        <div class="comment">
            @foreach($post->comments as $comment)
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="img-box32_32">
                                    <a href="#">
                                        <img class="img-circle" src="{{ asset('img/profile-header-orginal.jpg') }}"
                                             alt="user profile">
                                    </a>
                                </div>
                                <div class="img_box32_right">
                                    <span class="comment-user text-primary"><strong>{{ $comment->username }}</strong>&nbsp;
                                        <span class="small text-muted commentTime postTime">
                                            {{ $comment->created_at }}
                                        </span>
                                    </span>
                                </div>

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
                            @foreach($post->replies as $reply)
                                @if($comment->id == $reply->comment_id)
                                    <div class="panel panel-success">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="img-box32_32">
                                                        <a href="#">
                                                            <img class="img-circle"
                                                                 src="{{ asset('img/profile-header-orginal.jpg') }}"
                                                                 alt="user profile">
                                                        </a>
                                                    </div>
                                                    <div class="img_box32_right">
                                                        <span class="reply-user text-primary"><strong>{{ $reply->username }}</strong>&nbsp;
                                                        <span class="small text-muted commentTime postTime">
                                                            {{ $reply->created_at }}
                                                        </span>
                                                    </span>
                                                    </div>

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

    <div class="save-page-modal modal fade" id="addPollItemModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center"><i class="fa fa-plus-circle"></i> Save New Story</h4>
                </div>
                <div class="modal-body">
                    <form id="addNewList" class="addLinksForm" action="{{ route('poll_item.store') }}" method="POST" enctype="multipart/form-data" role="form">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="storyTitle">Title</label>
                            <input name="title" id="storyTitle" class="form-control" placeholder="Title" type="text">
                        </div>
                        <div class="form-group">
                            <label for="storyLink">Link</label>
                            <input name="link" id="storyLink" class="form-control" placeholder="Link" type="text">
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <div class="input-group input-file" name="img">
			<span class="input-group-btn">
        		<button class="btn btn-default btn-choose" type="button">Choose</button>
    		</span>
                                <input type="text" name="img" class="form-control" placeholder='Choose a file...' multiple/>
                                <span class="input-group-btn">
       			 <button class="btn btn-warning btn-reset" type="button">Reset</button>
    		</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="storyDesc">Description</label>
                            <textarea type="text" name="description" id="storyDesc" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Tags</label>
                            <input name="tags" id="tags" class="form-control" placeholder="tag1,tag2,tag3" type="text">
                        </div>
                        {{--<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">--}}
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <button type="submit" name="storySubmit" id="storySubmit" class="btn-link-submit btn btn-block btn-danger">Add Item</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
{{--<div class="overlay"></div>--}}
{{--</div>--}}

@section('js')

    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <script>
        $('.selectpicker').selectpicker();
    </script>
    <script>

        function bs_input_file() {

            $(".input-file").before(

                function() {

                    if ( ! $(this).prev().hasClass('input-ghost') ) {

                        var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");

                        element.attr("name",$(this).attr("name"));
                        console.log($(this).attr("name"));
                        element.change(function(){

                            element.next(element).find('input').val((element.val()).split('\\').pop());

                        });

                        $(this).find("button.btn-choose").click(function(){

                            element.click();

                        });

                        $(this).find("button.btn-reset").click(function(){

                            element.val(null);

                            $(this).parents(".input-file").find('input').val('');

                        });

                        $(this).find('input').css("cursor","pointer");

                        $(this).find('input').mousedown(function() {

                            $(this).parents('.input-file').prev().click();

                            return false;

                        });

                        return element;

                    }

                }

            );

        }

    </script>


    <script>
        function upVote(poll_item_id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var property = 'btn_upVote_'+poll_item_id;
            console.log(CSRF_TOKEN);
            $.ajax({
                type:'post',
                url: '{{url("poll_vote")}}',
                data: {_token: CSRF_TOKEN , poll_item_id: poll_item_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if(data.status == 'upvoted'){
                       var property = document.getElementById('btn_downVote_'+poll_item_id);
                       property.style.removeProperty('color');
                        var property = document.getElementById('btn_upVote_'+poll_item_id);
                        property.style.color = "green";
                        $('#upvote_count_'+poll_item_id).text(data.upvote);
                        $('#downvote_count_'+poll_item_id).text(data.downvote);
                    } else{
                        var property = document.getElementById('btn_upVote_'+poll_item_id);
                        property.style.color = "";
                        $('#upvote_count_'+poll_item_id).text(data.upvote);
                        $('#downvote_count_'+poll_item_id).text(data.downvote);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if(xhr.status==401) {
                        window.location.href = '{{url("login")}}';
                    }
                }
            });
        };


        function downVote(poll_item_id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var property = 'btn_upVote_'+poll_item_id;
            console.log(CSRF_TOKEN);
            $.ajax({
                type:'post',
                url: '{{url("poll_downvote")}}',
                data: {_token: CSRF_TOKEN , poll_item_id: poll_item_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if(data.status == 'downvoted'){
                       var property = document.getElementById('btn_upVote_'+poll_item_id);
                       property.style.removeProperty('color');
                        var property = document.getElementById('btn_downVote_'+poll_item_id);
                        property.style.color = "orangered";
                        $('#upvote_count_'+poll_item_id).text(data.upvote);
                        $('#downvote_count_'+poll_item_id).text(data.downvote);
                    } else{
                        var property = document.getElementById('btn_downVote_'+poll_item_id);
                        property.style.color = "";
                        $('#upvote_count_'+poll_item_id).text(data.upvote);
                        $('#downvote_count_'+poll_item_id).text(data.downvote);
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


    <script>
        $( document ).ready(function() {
            $("#latest_stories").attr("href", "{{ url('/post/latest/all') }}");
            $("#top_stories").attr("href", "{{ url('/post/top/all') }}");
            $("#popular_stories").attr("href", "{{ url('/post/popular/all') }}");
            $("#trending_stories").attr("href", "{{ url('/post/trending/all') }}");
        });
        // function upVote(post_id){
        //     var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        //     var property = 'btn_upVote_'+post_id;
        //     console.log(post_id);
        //     $.ajax({
        //         type:'post',
        //         url: 'vote',
        //         data: {_token: CSRF_TOKEN , post_id: post_id},
        //         dataType: 'JSON',
        //         success: function (data) {
        //             console.log(data);
        //             if(data.status == 'upvoted'){
        //                 var property = document.getElementById('btn_downVote_'+post_id);
        //                 property.style.removeProperty('color');
        //                 var property = document.getElementById('btn_upVote_'+post_id);
        //                 property.style.color = "green"
        //                 $('#vote_count_'+post_id).text(data.voteNumber);
        //             } else{
        //                 var property = document.getElementById('btn_upVote_'+post_id);
        //                 property.style.removeProperty('color');
        //                 $('#vote_count_'+post_id).text(data.voteNumber);
        //             }
        //         }
        //     });
        // };

        // function downVote(post_id){
        //     var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        //     var property = 'btn_downVote_'+post_id;
        //     console.log(property);
        //     $.ajax({
        //         type:'post',
        //         url: 'vote/downVote',
        //         data: {_token: CSRF_TOKEN , post_id: post_id},
        //         dataType: 'JSON',
        //         success: function (data) {
        //             console.log(data);
        //             if(data.status == 'downvoted'){
        //                 var property = document.getElementById('btn_upVote_'+post_id);
        //                 property.style.removeProperty('color');
        //                 var property = document.getElementById('btn_downVote_'+post_id);
        //                 property.style.color = "orangered"
        //                 $('#vote_count_'+post_id).text(data.voteNumber);
        //             } else{
        //                 var property = document.getElementById('btn_downVote_'+post_id);
        //                 property.style.removeProperty('color');
        //                 $('#vote_count_'+post_id).text(data.voteNumber);
        //             }
        //         }
        //     });
        // };

        function saveStory(post_id){
            var user_id = $('#save_story_user_id').val();
            $('#save_story_post_id').val(post_id);
            console.log(user_id);
            if(user_id==''){
                alert('You are not logged in!');
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
                            property.style.removeProperty('background');
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
                        property.style.background = "yellowgreen";
                        $('#saveStoryModal').modal('hide');
                    } else{
                        var property = document.getElementById('btn_saveStory_'+post_id);
                        property.style.removeProperty('background');
                    }
                }
            });
        };

    </script>
    <script>

        var itemNumber = 0;
        function AddListItemForm(event) {
            let action = '{{ route('poll_item.store') }}/';
            let post_id = '';
            $('.btn.btn-publish').removeClass('hidden');
            event.preventDefault();
            $('#item_form_element').append('<div class="item-form"><div class="form-group">' +
                '<label for="ItemName">Item Name</label>' +
                '<input name="name[]" id="ItemName" class="form-control" placeholder="Item Name" type="text">' +
                '</div>' +
                '<div class="form-group">' +
                '<label for="image">Image</label>' +
                '<div class="input-group input-file" name="images[]">' +
                '<span class="input-group-btn">' +
                '<button class="btn btn-default btn-choose" type="button" onclick="bs_input_file()">Choose</button>' +
                '</span>' +
                '<input type="text" name="images[]" class="form-control" placeholder="Choose a file..." />' +
                '<span class="input-group-btn">' +
                '<button class="btn btn-warning btn-reset" type="button">Reset</button>' +
                '</span>' +
                '</div>' +
                '</div>' +
                '<div class="form-group">' +
                '<label for="storyDesc">Description</label>' +
                ' <textarea type="text" name="description[]" id="storyDesc" rows="5" class="form-control"></textarea>' +
                '</div></div>');
            itemNumber++;
            $(function() {

                bs_input_file();

            });

        }
    </script>
@endsection

