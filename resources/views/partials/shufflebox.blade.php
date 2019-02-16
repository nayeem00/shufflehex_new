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

<?php
$title = preg_replace('/\s+/', '-', $post->title);
$title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
$title = $title . '-' . $post->id;
?>

<div class="shuffle-box" id="shuffle_box">
	<div class="box-image">
	    <img src="{{ url($post->shuffle_box_image) }}">
	</div>
    <div class="text-center" id="wait" style="display: none">
        <div style="height: 87px"><img src={{ asset('images/preloader/preloader_3.svg') }} width="100" height="87" /></div>
    </div>
    <div class="box-content">
        <a href="{{ $post->link }}" target="_blank" rel="nofollow">
    	<h5>{{ $post->domain }}</h5>
        </a>
    	<a href="{{ url('story/'.$title) }}">
    		<p class="title">{{ $post->title }}</p>
    	</a>
    </div>

    <div class="row dis-n share-section">
        <div class="col-md-6 col-sm-6 col-xs-12 vote">
            <div class="col-md-6 col-sm-6 col-xs-6 p-0 up-btn">
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
                        <span class="vote-counter text-center" id="vote_count_{{ $post->id }}">{{ $votes }}</span>
                    @endif
            </div>
            @if($savedStory == 1)
                <div class="col-md-2 col-sm-2 col-xs-2 p-0 saved-btn">
                    <a class="" onclick="saveStory({{
                        $post->id
                        }})">
                        <span class="saved glyphicon glyphicon-bookmark" id="btn_saveStory_{{ $post->id }}" style="color: green"></span>
                    </a>
                </div>
            @else
                    <div class="col-md-2 col-sm-2 col-xs-2 p-0 saved-btn">
                        <a class="" onclick="saveStory({{
                        $post->id
                        }})">
                            <span class="saved glyphicon glyphicon-bookmark" id="btn_saveStory_{{ $post->id }}"></span>
                        </a>
                    </div>
            @endif
            <div class="col-md-2 col-sm-2 col-xs-2 p-0 down-btn">
                <a type="button" data-toggle="modal" data-target="#share">
                    <span class="thumb glyphicon glyphicon-share-alt"></span>
                </a>
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-xs-6 new-story">
    	    <a class="btn btn-danger btn-sm pull-right" id="shuffle_new_story" onclick="shuffleNewStory()">
    		    <span>SHUFFLE NEW STORY</span>
    	    </a>
        </div>
    </div>



<div class="shufflebox-modal modal fade" id="share" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Share on</h5>
            </div>
            <div class="modal-body text-center">
                <div class="shufflebox-share" role="group">
                    <a href="#" class="btn btn-default btn-facebook"><i class="fab fa-facebook-square"></i>Facebook</a>
                    <a href="#" class="btn btn-default btn-twitter"><i class="fab fa-twitter-square"></i>Twitter</a>
                    <a href="#" class="btn btn-default btn-tumblr"><i class="fab fa-tumblr-square"></i>Tumblr</a>
                    <a href="#" class="btn btn-default btn-google"><i class="fab fa-google-plus-square"></i>GOOGLE PLUS</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>