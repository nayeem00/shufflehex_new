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
        <a class="d-inline-block" href="{{ url('story/'.$title) }}" target="_blank" rel="nofollow"> <img
                    class="img-responsive" src="{{ url($post->shuffle_box_image) }}"></a>
    </div>
    <div class="text-center" id="wait" style="display: none">
        <div style="height: 87px"><img src={{ asset('images/preloader/preloader_3.svg') }} width="100" height="87"/>
        </div>
    </div>
    <div class="box-content">
        <a href="{{ $post->link }}" target="_blank" rel="nofollow">
            <h5>{{ $post->domain }}</h5>
        </a>
        <a href="{{ url('story/'.$title) }}" target="_blank" rel="nofollow">
            <p class="title">{{ $post->title }}</p>
        </a>
    </div>

    <div class="row share-section shuffle-section">
        <div class="col-md-6 col-sm-6 col-xs-6 vote">
            <ul class="list-inline">
                @if($upVoteMatched == 1)
                    <li>
                        <a class="btn btn-xs" onclick="upVote({{$post->id}})">
                            <span id="btn_upVote_{{ $post->id }}" class="shuffle_vote"><i
                                        class="fa fa-chevron-up"></i><span
                                        class="vote-counter">{{ $votes }}</span></span>
                        </a>
                    </li>
                @else
                    <li>
                        <a class="" onclick="upVote({{$post->id}})">
                            <span id="btn_upVote_{{ $post->id }}" class="shuffle_vote"><i
                                        class="fa fa-chevron-up"></i><span
                                        class="vote-counter">{{ $votes }}</span></span>
                        </a>
                    </li>
                @endif
                @if($savedStory == 1)
                    <li>
                        <a class="btn btn-xs" onclick="saveStory({{$post->id}})">
                            <span class="saved" id="btn_saveStory_{{ $post->id }}"><i class="fa fa-bookmark"></i></span>
                        </a>
                    </li>

                @else
                    <li><a class="btn btn-xs" onclick="saveStory({{$post->id}})">
                            <span class="saved" id="btn_saveStory_{{ $post->id }}">
                                <i class="fa fa-bookmark"></i>
                            </span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <div class="col-sm-6 col-md-6 col-xs-6 new-story">
            <a class="btn btn-danger btn-sm pull-right" id="shuffle_new_story" onclick="shuffleNewStory()">
                SHUFFLE <span class="hidden-xs">NEW STORY</span>
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
                        <a href="#" class="btn btn-default btn-google"><i class="fab fa-google-plus-square"></i>GOOGLE
                            PLUS</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>