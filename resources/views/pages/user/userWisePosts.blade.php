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
    @include('partials.profileHeader')
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