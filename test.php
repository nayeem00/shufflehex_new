<?php
/**
 * Created by PhpStorm.
 * User: Sakil
 * Date: 9/22/2018
 * Time: 5:00 AM
 */
?>
<div class="story-item">
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-3 pr-0">
                        <div class="story-img">
                            <a href="" target="_blank"><img class="" src=""></a>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-8 pr-0">

                        <h4 class="story-title"><a href="" target="_blank"></a></h4>
                        <div class="dis-cls">
                            <p><small>Submitted by <strong><span></span></strong></small></p>
                        </div>

                        <div class="row dis-n">
                            <div class="col-md-6 dis-n"><p class="story-domain"></p></div>

                            <div class="col-md-6 col-sm-6 col-xs-12 vote">
                                <div class="col-md-6 col-sm-6 col-xs-6 col-md-offset-2 p-0 up-btn">
                                        <a class="" onclick="upVote()"><span  id="" class="thumb-up glyphicon glyphicon-triangle-top" ></span></a>
                                        <span class="vote-counter text-center" >Upvote</span>
                                        <span class="vote-counter text-center" id=""></span>
                                </div>

                                <div class="col-md-2 col-sm-2 col-xs-2 p-0 saved-btn">
                                    <a class="" onclick="downVote()">
                                        <span class="saved glyphicon glyphicon-bookmark" ></span>
                                    </a>
                                </div>

                                <div class="col-md-2 col-sm-2 col-xs-2 p-0 down-btn">
                                    <a onclick="downVote(})">
                                        <span class="thumb glyphicon glyphicon-share-alt"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-1 dis-show vote plr-0">
                        <div class="p-0 up-btn">
                                <a onclick="upVote()"><span  id="" class="thumb-up glyphicon glyphicon-triangle-top" alt="Upvote"></span></a>
                                <span class="vote-counter text-center" id=></span>

                        </div>
                    </div>
                </div>
</div>




<div class="story-item">
    <div class="row">

        <div class="col-md-3 col-sm-3 col-xs-3 pr-0">
            <div class="story-img">
                <a href="{{ url('story/'.$post->id.'/'.$title) }}" target="_blank"><img class="" src="{{ $post->featured_image }}"></a>
            </div>
        </div>
        <div class="col-md-9 col-sm-9 col-xs-8 pr-0">

            <h4 class="story-title"><a href="{{ url('story/'.$post->id.'/'.$title) }}" target="_blank"> {{ $post->title }}</a></h4>
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