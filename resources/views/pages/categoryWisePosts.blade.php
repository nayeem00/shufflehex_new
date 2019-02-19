@extends('layouts.master')
@section('css')

    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/list-style.css') }}">
@endsection

@section('content')

    {{----------------------------- store current url to session -----------------------}}
    <?php session(['last_page' => url()->current()]); ?>
    {{-------------------------------------------------------------------------------------}}

    <div class="box">
        <div class="row box-header m-0">
            <div class="col-md-12"><h1 class="font18">{{ $category }}</h1></div>
        </div>
        <?php
        function time_elapsed_string($datetime, $full = false) {
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
        @foreach($posts as $key=>$post)

            <?php
            $upVoteMatched = 0;
            $downVoteMatched = 0;
            $savedStory = 0;
            $votes = 0;
            ?>
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
                @foreach($post->votes as $key=>$vote)
                    <?php
                    $votes += $vote->vote;
                    ?>
                @endforeach
                @foreach($post->saved_stories as $key=>$saved)
                    @if($saved->user_id == Auth::user()->id && $saved->post_id == $post->id)
                        <?php $savedStory = 1;?>
                        @break
                    @endif
                @endforeach
            @endif

            <div class="story-item">
                <div class="row m-0">

                    <?php
                    $title = preg_replace('/\s+/', '-', $post->title);
                    $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
                    $title = $title.'-'.$post->id;

                    //                    ---------------------------- Time conversion --------------------------------
                    $date = time_elapsed_string($post->created_at, false);
                    ?>
                    <div class="col-md-3 col-sm-3 col-xs-3 pr-0">
                        <div class="story-img">
                            <a href="{{ url('story/'.$title) }}" target="_blank"><img class="" src="{{ url($post->story_list_image) }}"></a>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-8 pr-0">

                        <h4 class="story-title"><a href="{{ url('story/'.$title) }}" target="_blank"> {{ $post->title }}</a></h4>
                        <div class="dis-cls">
                            <p><small>Submitted by <strong><span><a href="{{ url('profile/'.$post->username) }}" rel="nofollow">{{ $post->username }}</a></span></strong> in <strong><span><a href="{{ url('category/'.$post->category) }}">{{ $post->category }}</a></span></strong> at {{ $date }}</small></p>
                        </div>

                        <div class="row dis-n">
                            <div class="col-md-6 dis-n"><p class="story-domain"><a href="{{ url('source/'.$post->domain) }}">{{ $post->domain }}</a></p></div>

                            <div class="col-md-6 col-sm-6 col-xs-12 vote">
                                <div class="col-md-6 col-sm-6 col-xs-6 col-md-offset-2 p-0 up-btn">
                                    @if($upVoteMatched == 1)
                                        <a class="" onclick="upVote({{
                                        $post->id
                                        }})"><span  id="btn_upVote_{{ $post->id }}" class="thumb-up glyphicon glyphicon-triangle-top" ></span></a>
                                        <span class="vote-counter text-center" >Upvote</span>
                                        <span class="vote-counter text-center" id="vote_count_{{ $post->id }}">{{ $votes }}</span>
                                    @else
                                        <a class="" onclick="upVote( {{ $post->id }} )">
                                            <span id="btn_upVote_{{ $post->id }}" class="thumb glyphicon glyphicon-triangle-top" ></span>
                                        </a>
                                        <span class="vote-counter text-center" >Upvote</span>
                                        <span class="vote-counter text-center" id="vote_count_{{ $post->id }}">{{ $votes }}</span>
                                    @endif
                                </div>

                                <div class="col-md-2 col-sm-2 col-xs-2 p-0 saved-btn">
                                    <a class="" onclick="downVote({{ $post->id }})">
                                        <span class="saved glyphicon glyphicon-bookmark" ></span>
                                    </a>
                                </div>

                                <div class="col-md-2 col-sm-2 col-xs-2 p-0 down-btn">
                                    <a onclick="downVote({{ $post->id }})">
                                        <span class="thumb glyphicon glyphicon-share-alt"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-1 dis-show vote plr-0">
                        <div class="p-0 up-btn">
                            @if($upVoteMatched == 1)
                                <a onclick="upVote({{
                                $post->id
                                }})"><span  id="btn_upVote_{{ $post->id }}" class="thumb-up glyphicon glyphicon-triangle-top" alt="Upvote"></span></a>
                                <span class="vote-counter text-center" id="vote_count_{{ $post->id }}">{{ $votes }}</span>
                            @else
                                <a alt="UpVote" onclick="upVote( {{ $post->id }} )">
                                    <span id="btn_upVote_{{ $post->id }}" class="thumb glyphicon glyphicon-triangle-top" ></span>
                                </a>
                                <span class="vote-counter text-center" id="vote_count_{{ $post->id }}">{{ $votes }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        @endforeach
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
                                <select class="selectpicker" data-live-search="true" name="folder_id" id="save_story_folder_id">
                                    @foreach($folders as $folder)
                                        <option value="{{ $folder->id }}" data-tokens="{{ $folder->folder_name }}">{{ $folder->folder_name }}</option>
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
                            <button type="button" class="btn btn-block btn-danger" onclick="saveStoryData()">Save Story</button>
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
        function upVote(post_id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var property = 'btn_upVote_'+post_id;
            console.log(post_id);
            $.ajax({
                type:'post',
                url: 'vote',
                data: {_token: CSRF_TOKEN , post_id: post_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if(data.status == 'upvoted'){
                        var property = document.getElementById('btn_downVote_'+post_id);
                        property.style.removeProperty('color');
                        var property = document.getElementById('btn_upVote_'+post_id);
                        property.style.color = "green"
                        $('#vote_count_'+post_id).text(data.voteNumber);
                    } else{
                        var property = document.getElementById('btn_upVote_'+post_id);
                        property.style.removeProperty('color');
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
                        property.style.removeProperty('color');
                        var property = document.getElementById('btn_downVote_'+post_id);
                        property.style.color = "orangered"
                        $('#vote_count_'+post_id).text(data.voteNumber);
                    } else{
                        var property = document.getElementById('btn_downVote_'+post_id);
                        property.style.removeProperty('color');
                        $('#vote_count_'+post_id).text(data.voteNumber);
                    }
                }
            });
        };

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


@endsection