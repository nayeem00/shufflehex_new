@extends('layouts.master')
@section('css')
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/list-style.css') }}">

    @endsection

@section('content')
    <div id="latest-list" class="col-md-7 col-sm-12">
        <div class="row">
            <div class="col-md-1"><span></span></div>
            <div class="col-md-11 plr-1"><h3>Latest Stories</h3></div>
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
            @endif
        <div class="story-item">
                <div class="row">

                    <?php
$title = preg_replace('/\s+/', '-', $post->title);
$title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);

//                    ---------------------------- Time conversion --------------------------------
$date = time_elapsed_string($post->created_at, false);
?>
                    <div class="col-md-3 col-sm-3 col-xs-3 pr-0">
                        <div class="story-img">
                            <a href="{{ url('post/'.$post->id.'/'.$title) }}" target="_blank"><img class="" src="{{ $post->featured_image }}"></a>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-8 pr-0">

                        <h4 class="story-title"><a href="{{ url('post/'.$post->id.'/'.$title) }}" target="_blank"> {{ $post->title }}</a></h4>
                        <div class="dis-cls">
                            <p><small>Submitted by <strong><span>{{ $post->username }}</span></strong></small></p>
                        </div>

                        <div class="row dis-n">
                            <div class="col-md-6 dis-n"><p class="story-domain">{{ $post->domain }}</p></div>

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
    </script>
@endsection