@extends('layouts.master')
@section('css')
    <!-- Our Custom CSS -->
    <!-- Bootstrap CSS CDN -->
@endsection

@section('content')

    {{----------------------------- store current url to session -----------------------}}
    <?php session(['last_page' => url()->current()]);?>
    {{-------------------------------------------------------------------------------------}}

    @include('partials.shufflebox')

    <div class="box">
        <div class="row box-header m-0">
            @if(isset($page2) && !empty($page2))
                <div class="col-md-12"><h3>{{ $page2.' '.$page1 }} </h3></div>
            @else
                <div class="col-md-12">
                    <div class="pull-left">
                        <h3>All Stories</h3>
                    </div>
                    <div class="pull-right">
                        <button class="btn" data-toggle="collapse" data-target="#filter">Filter <i
                                    class="fa fa-filter"></i></button>
                    </div>


                </div>

            @endif
        </div>
        <div id="filter" class="row collapse m-0 story-filter">
            <div class="col-md-3 time-filter">
                <h4 class="filter-title">Upload Date</h4>
                <hr>
                <ul class="list-unstyled">
                    <li><a id="day" class="time-filter-item">Today</a></li>
                    <li><a id="week" class="time-filter-item">This week</a></li>
                    <li><a id="month" class="time-filter-item">This month</a></li>
                    <li><a id="year" class="time-filter-item">This year</a></li>
                </ul>
            </div>
            <div class="col-md-3 topics-filter">
                <h4 class="filter-title">Topics</h4>
                <hr>
                <ul class="list-unstyled">
                    <li><a id="link" class="topics-filter-item">Web</a></li>
                    <li><a id="image" class="topics-filter-item">Images</a></li>
                    <li><a id="video" class="topics-filter-item">Videos</a></li>
                    <li><a id="article" class="topics-filter-item">Articles</a></li>
                </ul>
            </div>
            <div class="col-md-3  topics-filter">
                <h4 class="filter-title">Topics</h4>
                <hr>
                <ul class="list-unstyled">
                    <li><a id="list" class="topics-filter-item">Lists</a></li>
                    <li><a id="poll" class="topics-filter-item">poll</a></li>
                    {{--<li><a href="#">Type 1</a></li>--}}
                </ul>
            </div>
            <div class="col-md-3 other-filter">
                <h4 class="filter-title">Other</h4>
                <hr>
                <ul class="list-unstyled">
                    <li><a id="upvote" class="other-filter-item">Upvote</a></li>
                    <li><a id="downvote" class="other-filter-item">Downvote</a></li>
                    <li><a id="page-view" class="other-filter-item">Page View</a></li>
                    <li><a id="most-comment" class="other-filter-item">Most Comments</a></li>
                </ul>
            </div>

        </div>

        <?php
        function time_elapsed_string($datetime, $full = false)
        {
            $now = new DateTime;
            $ago = new DateTime($datetime);
            $diff = $now->diff($ago);

            $diff->w = floor($diff->d / 7);
            $diff->d -= $diff->w * 7;

            $string = array(
                'y' => 'year',
                'm' => 'month',
                'w' => 'week',
                'd' => 'day',
                'h' => 'hour',
                'i' => 'minute',
                's' => 'second',
            );
            foreach ($string as $k => &$v) {
                if ($diff->$k) {
                    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                } else {
                    unset($string[$k]);
                }
            }

            if (!$full) {
                $string = array_slice($string, 0, 1);
            }

            return $string ? implode(', ', $string) . ' ago' : 'just now';
        }
        ?>
        <div class="posts">
            @foreach($posts as $key=>$post)

                <?php
                $upVoteMatched = 0;
                $downVoteMatched = 0;
                $savedStory = 0;
                $votes = 0;
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

                <div class="story-item">
                    <div class="row">

                        <?php
                        $title = preg_replace('/\s+/', '-', $post->title);
                        $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
                        $title = $title . '-' . $post->id;

                        //                    ---------------------------- Time conversion --------------------------------
                        $date = time_elapsed_string($post->created_at, false);
                        ?>
                        {{--<div class="col-md-3 col-sm-3 col-xs-3 pr-0">--}}
                        {{----}}
                        {{--</div>--}}
                        <div class="col-md-12 col-sm-11 col-xs-10 pr-0">
                            <div class="story-img img-box150_84">
                                <a href="{{ url('story/'.$title) }}" target="_blank"><img class=""
                                                                                          src="{{ url($post->story_list_image) }}"></a>
                            </div>
                            <div class="img_box150_right">
                                <h4 class="story-title"><a href="{{ url('story/'.$title) }}"
                                                           target="_blank"> {{ $post->title }}</a></h4>
                                <div class="dis-cls">
                                    <p style="margin-bottom: 5px !important;">
                                        <small>Submitted {{ $date }} by <strong><span><a
                                                            href="{{ url('profile/'.$post->username) }}"
                                                            rel="nofollow">{{ $post->username }}</a></span></strong> in
                                            <strong><span><a
                                                            href="{{ url('category/'.$post->category) }}">{{ $post->category }}</a></span></strong>
                                        </small>
                                    </p>
                                </div>
                                <div class="row dis-n">
                                    <div class="col-md-12 dis-n"><p class="story-domain" style="font-size: 12px"><a
                                                    href="{{ url('source/'.$post->domain) }}">{{ $post->domain }}</a></p>
                                    </div>


                                </div>
                                <div class="row dis-n">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        @if($post->is_link == 1)
                                            <div class="social-counter">
                                            <span><i class="fa fa-facebook-square" aria-hidden="true"
                                                     data-toggle="tooltip"
                                                     title="Facebook Shares"></i> {{$post->fb_count}}</span>
                                                <span style="margin-left: 4px"><i class="fa fa-pinterest" aria-hidden="true"
                                                                                  data-toggle="tooltip"
                                                                                  title="Pinterest Shares"></i> {{$post->pin_count}}</span>


                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12 vote">
                                        <ul class="list-unstyled list-inline pull-right">
                                            <li class="li-vote">
                                                @if($upVoteMatched == 1)
                                                    <a class="" onclick="upVote({{
                                        $post->id
                                        }})"><span id="btn_upVote_{{ $post->id }}"
                                                   class="thumb-up glyphicon glyphicon-triangle-top"
                                                   style="color: green"></span></a>
                                                    <span class="vote-counter text-center">Upvote</span>
                                                    <span class="vote-counter text-center"
                                                          id="vote_count_{{ $post->id }}">{{ $votes }}</span>
                                                @else
                                                    <a class="" onclick="upVote( {{ $post->id }} )">
                                                    <span id="btn_upVote_{{ $post->id }}"
                                                          class="thumb glyphicon glyphicon-triangle-top"></span>
                                                    </a>
                                                    <span class="vote-counter text-center">Upvote</span>
                                                    <span class="vote-counter text-center"
                                                          id="vote_count_{{ $post->id }}">{{ $votes }}</span>
                                                @endif
                                            </li>
                                            <li>
                                                @if($savedStory == 1)
                                                    <div class="p-0 saved-btn">
                                                        <a class="" onclick="saveStory({{ $post->id }})">
                                                        <span class="saved glyphicon glyphicon-bookmark"
                                                              id="btn_saveStory_{{ $post->id }}"
                                                              style="color: green"></span>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="p-0 saved-btn">
                                                        <a class="" onclick="saveStory({{ $post->id }})">
                                                        <span class="saved glyphicon glyphicon-bookmark"
                                                              id="btn_saveStory_{{ $post->id }}"></span>
                                                        </a>
                                                    </div>
                                                @endif
                                            </li>
                                            <li><a href="#" data-toggle="modal" data-target="#story-share"><span
                                                            class="thumb glyphicon glyphicon-share-alt"></span></a></li>
                                        </ul>
                                    </div>
                                </div>

                            </div>


                        </div>
                        <div class="col-sm-1 col-xs-1 dis-show vote plr-0">
                            <div class="p-0 up-btn pull-right">
                                @if($upVoteMatched == 1)
                                    <a onclick="upVote({{
                                $post->id
                                }})"><span id="btn_upVote_{{ $post->id }}"
                                           class="thumb-up glyphicon glyphicon-triangle-top" alt="Upvote"></span></a>
                                    <span class="vote-counter text-center"
                                          id="vote_count_{{ $post->id }}">{{ $votes }}</span>
                                @else
                                    <a alt="UpVote" onclick="upVote( {{ $post->id }} )">
                                    <span id="btn_upVote_{{ $post->id }}"
                                          class="thumb glyphicon glyphicon-triangle-top"></span>
                                    </a>
                                    <span class="vote-counter text-center"
                                          id="vote_count_{{ $post->id }}">{{ $votes }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>

    </div>
    <div class="text-center">
        <label style="font-size: 18px" class="text-danger text-center no-post-available"></label>
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
    <div class="shufflebox-modal modal fade" id="story-share" role="dialog">
        <div class="modal-dialog" role="dialog" style="vertical-align: middle">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title">Share on</h5>
                </div>
                <div class="modal-body text-center">
                    <div class="shufflebox-share" role="group">
                        <a href="#" class="btn btn-default btn-facebook"><i class="fa fa-facebook-square"></i>&nbsp;Facebook</a>
                        <a href="#" class="btn btn-default btn-twitter"><i class="fa fa-twitter-square"></i>&nbsp;Twitter</a>
                        <a href="#" class="btn btn-default btn-tumblr"><i
                                    class="fa fa-tumblr-square"></i>&nbsp;Tumblr</a>
                        <a href="#" class="btn btn-default btn-google"><i class="fa fa-google-plus-square"></i>&nbsp;Google
                            Plus</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" value="10" id="post-count-offset" data-offset="10">

@endsection




@section('js')

    <script src="{{ asset('ChangedDesign/js/filter-story.js') }}"></script>
    <script src="{{ asset('ChangedDesign/js/load-more.js') }}"></script>

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
                        var property = document.getElementById('btn_upVote_' + post_id);
                        property.style.color = "green";
                        $('#vote_count_' + post_id).text(data.voteNumber);
                        var property = document.getElementById('btn_upVote_text_' + post_id);
                        property.style.color = "green";
                    } else {
                        var property = document.getElementById('btn_upVote_' + post_id);
                        property.style.removeProperty('color');
                        $('#vote_count_' + post_id).text(data.voteNumber);
                        var property = document.getElementById('btn_upVote_text_' + post_id);
                        property.style.removeProperty('color');
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if (xhr.status == 401) {
                        window.location.href = '{{url("login")}}';
                    }
                }
            });
        };

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

    </script>
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <script>

        function shuffleNewStory() {
            document.getElementById('wait').style.display = "block";
            $("#shuffle_box").load(location.href + " #shuffle_box");
            document.getElementById('wait').style.display = "none";
        };

    </script>

@endsection
