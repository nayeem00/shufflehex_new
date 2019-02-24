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
        <div id="profile-content posts">
            @include('partials.user_post_item',['posts' => $posts]);
        </div>
    </div>
    <div class="overlay"></div>
@endsection