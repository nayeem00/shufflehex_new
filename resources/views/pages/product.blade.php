@extends('layouts.master')
@section('css')
    <!-- Bootstrap CSS CDN -->
    <title>Product</title>

    {{--<!-- Our Custom CSS -->--}}
    {{--    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/list-style.css') }}">--}}

    <link rel="stylesheet" href="{{ asset('xzoom/dist/xzoom.css') }}">
    {{--<link rel="stylesheet" href="{{ asset('xzoom/dist/xzoom.css') }}">--}}
    {{--<link rel="stylesheet/less" href="{{ asset('ChangedDesign/lessFiles/less/style.less') }}">--}}
    {{--<link rel="stylesheet/less" href="{{ asset('ChangedDesign/lessFiles/less/list-style.less') }}">--}}
    {{--<link rel="stylesheet/less" href="{{ asset('ChangedDesign/lessFiles/less/sidebar.less') }}">--}}
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/add.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/product.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/view-story.css') }}">
@endsection
<?php
$upVoteMatched = 0;
$downVoteMatched = 0;
$savedStory = 0;
$votes = 0;
?>

@foreach($post->product_votes as $key=>$vote)
    <?php
$votes += $vote->vote;
?>
@endforeach
@if(isset(Auth::user()->id) && !empty(Auth::user()->id))
    @foreach($post->product_votes as $key=>$vote)
        @if($vote->user_id == Auth::user()->id && $vote->vote == 1)
            <?php $upVoteMatched = 1;?>
            @break
        @endif
    @endforeach
    @foreach($post->product_votes as $key=>$vote)
        @if($vote->user_id == Auth::user()->id && $vote->vote == -1)
            <?php $downVoteMatched = 1;?>
            @break
        @endif
    @endforeach
    @foreach($post->saved_products as $key=>$saved)
        @if($saved->user_id == Auth::user()->id && $saved->product_id == $post->id)
            <?php $savedStory = 1;?>
            @break
        @endif
    @endforeach
@endif

@section('content')

    {{----------------------------- store current url to session -----------------------}}
    <?php session(['last_page' => url()->current()]);?>
    {{-------------------------------------------------------------------------------------}}

    <div class="box product">
        <div class="product-box">
            <div class="row">
                <div class="col-xs-12">
                    <div class="product-name">
                        <h1>{{ $post->product_name }}</h1>
                        <div class="username display-sm-only">
                            <p>Submitted by {{ $post->username }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row m-0">
                <div class="col-md-7 col-sm-12 product-media">
                    <img class="img-responsive xzoom original" src="{{ url($post->product_images[0]) }}"
                         style="max-width:100%;" xoriginal="{{ url($post->product_images[0]) }}"
                />
                    <div class="product-review">
                        <div class="xzoom-thumbs">
                            @foreach($post->product_images as $image)
                                <a href="{{ url($image) }}">
                                    <img class="xzoom-gallery" src="{{ url($image) }}" xpreview="{{ url($image) }}">
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-sm-12">
                    <div class="category">
                        <h2 class="font16 mb-0"><i class="fa fa-tag"></i>&nbsp;{{ $post->category }}</h2>
                    </div>
                    <div class="username display-md-only">
                        <p>Submitted by {{ $post->username }}</p>
                    </div>
                    <div class="product-price"><h3><span>{{ $post->price }}</span></h3></div>
                    <div class="star-rating">
                        <?php
                        $reviewStar = $post->product_review;
                        ?>
                        @for($i=0;$i<5;$i++)
                            @if($reviewStar>=1)
                                    <span class="star-icon star-icon-full">
                            <i class="fa fa-star"></i>
                        </span>
                                    <?php
                                    $reviewStar -= 1;
                                    ?>
                                @elseif($reviewStar<1 && $reviewStar>0)
                                    <span class="star-icon star-icon-half">
                            <i class="fa fa-star-half-o"></i>
                        </span>
                                    <?php
                                    $reviewStar -= $reviewStar;
                                    ?>
                                @else
                        <span class="star-icon star-icon-blank">
                            <i class="fa fa-star-o"></i>
                        </span>
                                @endif
                            @endfor
                        <span style="font-size: 12px">{{ $post->product_review }} &nbsp;@if($post->total_reviews>0)
                                {{ "(".$post->total_reviews." reviews)" }}
                            @else {{ "(0 reviews)" }} @endif</span>
                    </div>


                    <div class="product-action">
                        <a href="{{ url($post->product_url) }}" class="btn btn-danger" target="_blank" rel="nofollow">GO SHOPPING</a>
                    </div>
                </div>
            </div>



            <div class="product-description col-md-12 col-xs-12">
                <p>{!! $post->short_desc !!}</p>
            </div>
            <div class="product-description col-md-12 col-xs-12">
                <p>{!! $post->description !!}</p>
            </div>

            <div class="promo">
                <p><strong>Promo Code</strong>@if(isset($post->coupon) && !empty($post->coupon)){{ $post->coupon }} @else {{ 'promo code not available' }} @endif</p>
                <p><strong>Online Shop</strong>{{ $post->store_name }} </p>
            </div>


            <div class="row vote">
                <div class="col-md-4 col-sm-6 col-xs-6 up-btn">
                    @if($upVoteMatched == 1)
                        <a class="btn btn-xs" onclick="upVote({{
                        $post->id
                        }})"><span  id="btn_upVote_{{ $post->id }}" class="thumb-up glyphicon glyphicon-triangle-top" style="color: green"></span></a>
                        <span id="btn_upVote_text_{{ $post->id }}" class="vote-counter text-center" style="color: green;">Upvote</span>
                        <span  id="vote_count_{{ $post->id }}" class="vote-counter text-center" style="color: green">{{ $votes }}</span>
                    @else
                        <a class="" onclick="upVote({{
                        $post->id
                        }})"><span id="btn_upVote_{{ $post->id }}" class="thumb glyphicon glyphicon-triangle-top" ></span></a>
                        <span id="btn_upVote_text_{{ $post->id }}" class="vote-counter text-center">Upvote</span>
                        <span  id="vote_count_{{ $post->id }}" class="vote-counter text-center">{{ $votes }}</span>
                    @endif

                </div>
                <div class="col-md-4 col-sm-6 col-xs-6 col-md-offset-4 col-sm-offset-4">
                    <div class="col-md-2 col-sm-2 col-xs-2 p-0 down-btn">
                        @if($downVoteMatched == 1)
                            <a class="pull-right" onclick="downVote({{
                            $post->id
                            }})"><span id="btn_downVote_{{ $post->id }}" class="thumb-down glyphicon glyphicon-triangle-bottom" style="color: red"></span> </a>
                        @else
                            <a class="pull-right" onclick="downVote({{
                            $post->id
                            }})"><span id="btn_downVote_{{ $post->id }}" class="thumb glyphicon glyphicon-triangle-bottom"></span></a>
                        @endif
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 p-0 comment-btn text-center">
                            <a class=""><span ><span class="vote-counter text-center" id="vote_count_1"></span></span><i class="fa fa-comment"></i>{{ $totalComments }}</a>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 p-0 saved-btn">
                        @if($savedStory == 1)
                            <a class="pull-right" onclick="saveStory({{
                        $post->id
                        }})"><span><span class="vote-counter text-center"></span></span><i class="fa fa-bookmark saved" id="btn_saveStory_1" style="color: green"></i></a>
                        @else
                            <a class="pull-right" onclick="saveStory({{
                        $post->id
                        }})"><span></span><span class="vote-counter text-center" ></span><i class="fa fa-bookmark" id="btn_saveStory_1"></i></a>
                        @endif
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 p-0 operation-btn dropdown">

                        <button style="background-color: #fff; border: none;" class="pull-right dropdown-toggle" type="button" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-option-horizontal" ></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Edit</a></li>
                            <li><a href="#">Delete</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--first Comment section -->

        <div class="comment-section">
            <div class="row comment-box">
                <form id="addNewStory" action="{{ route('review.store') }}" method="POST" role="form">
                    {{ csrf_field() }}
                    <input type="hidden" name="product_id" value="{{ $post->id }}">
                    <div class="col-sm-12">
                        <div class="w-100">
                            <textarea name="review_comment" placeholder="Leave a review..." id="review_comment"
                                      class="form-control summernote-review"></textarea>
                        </div>


                    </div>
                    <div class="col-sm-12">
                        <div class="comment-rating pull-left">
                            <div class="rating pull-right">
                                <label class="rarting-star-label">
                                    <input type="radio" name="review_star" value="1"/>
                                    <span class="icon"><i class="fa fa-star"></i></span>
                                </label>
                                <label class="rarting-star-label">
                                    <input type="radio" name="review_star" value="2"/>
                                    <span class="icon"><i class="fa fa-star-o"></i></span>
                                    <span class="icon"><i class="fa fa-star-o"></i></span>
                                </label>
                                <label class="rarting-star-label">
                                    <input type="radio" name="review_star" value="3"/>
                                    <span class="icon"><i class="fa fa-star-o"></i></span>
                                    <span class="icon"><i class="fa fa-star-o"></i></span>
                                    <span class="icon"><i class="fa fa-star-o"></i></span>
                                </label>
                                <label class="rarting-star-label">
                                    <input type="radio" name="review_star" value="4"/>
                                    <span class="icon"><i class="fa fa-star-o"></i></span>
                                    <span class="icon"><i class="fa fa-star-o"></i></span>
                                    <span class="icon"><i class="fa fa-star-o"></i></span>
                                    <span class="icon"><i class="fa fa-star-o"></i></span>
                                </label>
                                <label class="rarting-star-label">
                                    <input type="radio" name="review_star" value="5"/>
                                    <span class="icon"><i class="fa fa-star-o"></i></span>
                                    <span class="icon"><i class="fa fa-star-o"></i></span>
                                    <span class="icon"><i class="fa fa-star-o"></i></span>
                                    <span class="icon"><i class="fa fa-star-o"></i></span>
                                    <span class="icon"><i class="fa fa-star-o"></i></span>
                                </label>
                            </div>
                        </div>
                        <div class="pull-right" style="margin-top: 10px">
                            <button type="submit" name="review_submit" id="review_submit"
                                    class="btn btn-danger pull-right">Review
                            </button>
                        </div>

                    </div>

                    {{--<div class="col-md-2 col-sm-2 col-xs-2 dis-show pr-0">--}}
                    {{--<button type="submit" name="storySubmit" id="storySubmit" class="btn btn-danger pull-right">--}}
                    {{--<span class="thumb glyphicon glyphicon-send"></span>--}}
                    {{--</button>--}}
                    {{--</div>--}}
                </form>
            </div>

            <div class="product-comment">
                @foreach($post->product_reviews as $review)

                    <div class="panel panel-comment">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="comment-user">
                                        <div class="comment-user-img">
                                            <a href="#">
                                                <img class="img-responsive"
                                                     src="{{ asset('img/profile-header-orginal.jpg') }}"
                                                     alt="user profile">
                                            </a>
                                        </div>
                                        <div class="comment-user-info">
                                            <div class="comment-username">
                                                <span class="text-555 username">{{ $review->username }}&nbsp;</span>
                                                <span class="small text-muted commentTime postTime">
                                                    {{ date('M d, Y', strtotime($review->created_at)) }}
                                                </span>
                                            </div>
                                            <div class="star-rating">
                                                <span class="star-icon star-icon-blank">
                                                    @for($i=0;$i<5;$i++)
                                                        @if($i<$review->review_stars)
                                                            <span class="star-icon star-icon-full">
                                                                <i class="fa fa-star"></i>
                                                </span>
                                                        @else
                                                            <span class="star-icon star-icon-blank">
                                                    <i class="fa fa-star-o"></i>
                                                </span>
                                                        @endif
                                                    @endfor
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <button class="pull-right btn btn-xs btn-danger">Edit</button>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="comment-body">
                                <div class="comment-text text-555">{!! $review->review_comment !!}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

<!--end comment section -->



@endsection
{{--
<div class="overlay"></div>
--}}
{{--</div>--}}
@section('js')
    <script src="{{ asset('xzoom/dist/xzoom.min.js') }}"></script>
    <script>
        var windowWidth = window.innerWidth;
        $('.xzoom, .xzoom-gallery').xzoom({
            position: 'right',
            lensShape: 'circle',
            lens: false,
            bg: true,
            sourceClass: 'xzoom-hidden'
        });
    </script>

    <script>
        $('.comment-rating :radio').change(function () {
            console.log('New star rating: ' + this.value);
        });
    </script>
    <script>

        $(document).ready(function(){

            $('[data-toggle="tooltip"]').tooltip();

        });
        $('.selectpicker').selectpicker();

        function upVote(post_id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var property = 'btn_upVote_'+post_id;
            console.log(post_id);
            $.ajax({
                type:'post',
                url: '{{url("product/upvote")}}',
                data: {_token: CSRF_TOKEN , product_id: post_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if(data.status == 'upvoted'){
                        $('#vote_count_'+post_id).text(data.voteNumber);

                        var property = document.getElementById('btn_upVote_'+post_id);
                        property.style.color = "green";
                        var property = document.getElementById('btn_upVote_text_'+post_id);
                        property.style.color = "green"
                        var property = document.getElementById('vote_count_'+post_id);
                        property.style.color = "green"
                        var property = document.getElementById('btn_downVote_'+post_id);
                        property.style.removeProperty('color');
                    } else{
                        $('#vote_count_'+post_id).text(data.voteNumber);
                        var property = document.getElementById('btn_upVote_'+post_id);
                        property.style.removeProperty('color');
                        var property = document.getElementById('btn_upVote_text_'+post_id);
                        property.style.removeProperty('color');
                        var property = document.getElementById('vote_count_'+post_id);
                        property.style.removeProperty('color');
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if(xhr.status==401) {
                        window.location.href = '{{url("login")}}';
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
                url: '{{url("product/downvote")}}',
                data: {_token: CSRF_TOKEN , product_id: post_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if(data.status == 'downvoted'){
                        var property = document.getElementById('btn_upVote_'+post_id);
                        property.style.removeProperty('color');
                        var property = document.getElementById('btn_upVote_text_'+post_id);
                        property.style.removeProperty('color');
                        var property = document.getElementById('btn_downVote_'+post_id);
                        property.style.color = "orangered"
                        $('#vote_count_'+post_id).text(data.voteNumber);
                    } else{
                        var property = document.getElementById('btn_downVote_'+post_id);
                        property.style.removeProperty('color');
                        $('#vote_count_'+post_id).text(data.voteNumber);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if(xhr.status==401) {
                        window.location.href = '{{url("login")}}';
                    }
                }
            });
        };

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
                    url: '{{url("saveStory")}}',
                    data: {_token: CSRF_TOKEN , post_id: post_id, user_id: user_id},
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


@endsection