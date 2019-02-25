@extends('layouts.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/product.css') }}">

@endsection

@section('content')

    {{----------------------------- store current url to session -----------------------}}
    <?php session(['last_page' => url()->current()]);?>
    {{-------------------------------------------------------------------------------------}}

    <div class="box">
        <div class="row box-header m-0">
            <div class="col-md-4 col-sm-5 text-sm-left text-xs-center">
                <h3 class="text-sm-left text-xs-center">All Projects</h3>
            </div>
            <div class="col-md-8  col-sm-7 filter text-sm-right text-xs-center">
                <ul class="list-inline mb-0 text-xs-center m-auto">
                    <li><a @if($page=='trending')style="color: #000;" @endif href="{{ url('projects') }}">TRENDING</a>
                    </li>
                    <li><a @if($page=='newest')style="color: #000;"
                           @endif href="{{ url('projects/newest') }}">NEWEST</a></li>
                    <li><a @if($page=='popular')style="color: #000;"
                           @endif href="{{ url('projects/popular') }}">PUPOLER</a></li>
                    <li><a class="filter-toggle btn text-555" data-toggle="collapse" data-target="#filter"><i
                                    class="fa fa-filter"></i></a></li>
                </ul>
            </div>
        </div>
        @include('partials.filter_row')
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
                    <div class="col-sm-12">
                        <div class="img_box84_84">
                            <a href="{{ url('project/'.$title) }}" target="_blank"><img class="" src="{{ url($post->logo) }}"></a>
                        </div>
                        <div class="img_box84_right mr-40">
                            <h4 class="story-title"><a href="{{ url('project/'.$title) }}"
                                                       target="_blank"> {{ $post->title }}</a></h4>
                            <div class="tagline">
                                <p>{{ $post->tag_line }}</p>
                            </div>
                        </div>
                        <div class="vote-submit-right pull-right" style="margin-left: -40px">
                            @if($upVoteMatched == 1)
                                <a onclick="upVote({{$post->id}})">
                                    <div class="vote-icon"><i class="fa fa-chevron-up text-shufflered" id="upvote_icon_{{$post->id}}"></i></div>
                                    <div class="vote-counter" id="vote_count_{{$post->id}}">{{ $votes }}</div>
                                </a>
                            @else
                                <a onclick="upVote({{$post->id}})">
                                    <div class="vote-icon"><i class="fa fa-chevron-up" id="upvote_icon_{{$post->id}}"></i></div>
                                    <div class="vote-counter" id="vote_count_{{$post->id}}">{{ $votes }}</div>
                                </a>
                            @endif
                        </div>
                    </div>
                    {{--<div class="col-md-10 col-sm-10 col-xs-9 pr-0">--}}
                    {{--<div class="row">--}}
                    {{--<div class="col-md-6 col-sm-6 col-xs-12 vote">--}}
                    {{--<div class="col-md-6 col-sm-6 col-xs-6 col-md-offset-2 p-0 up-btn">--}}

                    {{--</div>--}}
                    {{--@if($savedStory == 1)--}}
                    {{--<div class="col-md-2 col-sm-2 col-xs-2 p-0 saved-btn">--}}
                    {{--<a class="" onclick="saveStory({{ $post->id }})">--}}
                    {{--<span class="saved glyphicon glyphicon-bookmark" id="btn_saveStory_{{ $post->id }}" style="color: green"></span>--}}
                    {{--</a>--}}
                    {{--</div>--}}
                    {{--@else--}}
                    {{--<div class="col-md-2 col-sm-2 col-xs-2 p-0 saved-btn">--}}
                    {{--<a class="" onclick="saveStory({{ $post->id }})">--}}
                    {{--<span class="saved glyphicon glyphicon-bookmark" id="btn_saveStory_{{ $post->id }}"></span>--}}
                    {{--</a>--}}
                    {{--</div>--}}
                    {{--@endif--}}
                    {{--<div class="col-md-2 col-sm-2 col-xs-2 p-0 down-btn">--}}
                    {{--<a>--}}
                    {{--<span class="thumb glyphicon glyphicon-share-alt"></span>--}}
                    {{--</a>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-1 dis-show vote plr-0">--}}
                    {{--<div class="p-0 up-btn">--}}
                    {{--@if($upVoteMatched == 1)--}}
                    {{--<a onclick="upVote({{--}}
                    {{--$post->id--}}
                    {{--}})"><span  id="btn_upVote_{{ $post->id }}" class="thumb-up glyphicon glyphicon-triangle-top" alt="Upvote"></span></a>--}}
                    {{--<span class="vote-counter text-center" id="vote_count_{{ $post->id }}">{{ $votes }}</span>--}}
                    {{--@else--}}
                    {{--<a alt="UpVote" onclick="upVote( {{ $post->id }} )">--}}
                    {{--<span id="btn_upVote_{{ $post->id }}" class="thumb glyphicon glyphicon-triangle-top" ></span>--}}
                    {{--</a>--}}
                    {{--<span class="vote-counter text-center" id="vote_count_{{ $post->id }}">{{ $votes }}</span>--}}
                    {{--@endif--}}
                    {{--</div>--}}
                    {{--</div>--}}
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
                    <form action="{{ route('folderProject.store') }}" method="POST">
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
                        <input type="hidden" name="project_id" class="form-control" id="save_story_post_id">
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
                url: '{{url("/project/upvote")}}',
                data: {_token: CSRF_TOKEN , project_id: post_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if (data.status == 'upvoted') {
                        var element = document.getElementById("upvote_icon_"+post_id);
                        element.classList.add("text-shufflered");
                        $('#vote_count_' + post_id).text(data.voteNumber);
                    } else {
                        var element = document.getElementById("upvote_icon_"+post_id);
                        element.classList.remove("text-shufflered");
                        $('#vote_count_' + post_id).text(data.voteNumber);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if(xhr.status==401) {
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
                    url: '{{url("saveProject")}}',
                    data: {_token: CSRF_TOKEN , project_id: post_id, user_id: user_id},
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

    </script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>


@endsection
