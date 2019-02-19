<?php
$post = \App\Http\PostHelper::addAditionalData([$post]);
$post = $post[0];
?>

<div class="shuffle-box" id="shuffle_box">
    <div class="box-image">
        <a class="d-inline-block" href="{{ url($post->storyLink) }}" target="_blank" rel="nofollow"> <img
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
        <a href="{{ url($post->storyLink) }}" target="_blank" rel="nofollow">
            <p class="title">{{ $post->title }}</p>
        </a>
    </div>

    <div class="row share-section shuffle-section">
        <div class="col-md-6 col-sm-6 col-xs-6 vote">
            <ul class="list-inline">
                @if($post->upVoteMatched == 1)
                    <li>
                        <a class="btn btn-xs" onclick="upVote({{$post->id}})">
                            <span id="btn_upVote_{{ $post->id }}" class="shuffle_vote"><i
                                        class="fa fa-chevron-up" id="upvote_icon_{{$post->id}}"></i><span
                                        class="vote-counter" id="vote_count_{{$post->id}}">{{ $votes }}</span></span>
                        </a>
                    </li>
                @else
                    <li>
                        <a class="" onclick="upVote({{$post->id}})">
                            <span id="btn_upVote_{{ $post->id }}" class="shuffle_vote"><i
                                        class="fa fa-chevron-up" id="upvote_icon_{{$post->id}}"></i><span
                                        class="vote-counter" id="vote_count_{{$post->id}}">{{ $post->vote_number }}</span></span>
                        </a>
                    </li>
                @endif
                @if($post->savedStory == 1)
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