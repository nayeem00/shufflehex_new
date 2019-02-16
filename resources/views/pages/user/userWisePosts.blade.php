@extends('layouts.profileMaster')


@section('css')
    <style>
        .box-public-profile .profile-nav-link {
            margin-bottom: 20px;
            padding: 10px 5px;
            background-color: rgba(173, 173, 173, 0.76);
            color: #2c2929;
            font-size: 18px;
        }
    </style>
@endsection
@section('content')

    <div class="profile">
        <div class="box">
            <div class="profile-info">
                <div class="profile-header text-center">
                    <div class="profile-img">
                        <img class="img-responsive" src="@if (!empty($user->mini_profile_picture_link)) {{ asset( $user->profile_picture_link) }} @else {{ asset( 'images/user/profilePicture/default/user.png') }} @endif">
                    </div>
                    <h1 style="margin-bottom: 2%">{{ $user->name }}</h1>
                    <h3>Elite Points: {{ $user->elite_points }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-public-profile">
        <div class="row">
            <div class="col-xs-12 text-center">
                <h3 class="profile-nav-link m-auto">POSTS</h3>
            </div>
        </div>
        <div id="profile-content">
            @foreach($posts as $post)


                <?php
                $title = preg_replace('/\s+/', '-', $post->title);
                $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
                $title = $title.'-'.$post->id;

                ?>

                <div class="story-item">
                    <div class="row">
                        <div class="col-md-12 col-sm-11 col-xs-10 pr-0">
                            <div class="story-img img-box150_84">
                                <a href="{{ url('story/'.$title) }}"><img class=""
                                                                          src="{{ url($post->story_list_image) }}"></a>
                            </div>
                            <div class="img_box150_right">
                                <h4 class="story-title"><a href="{{ url('story/'.$title) }}"> {{ $post->title }}</a>
                                </h4>
                                <?php
                                $description = substr($post->description, 0, 120)

                                ?>
                                <p>{{ $description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="overlay"></div>
@endsection