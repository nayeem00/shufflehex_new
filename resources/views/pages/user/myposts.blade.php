@extends('layouts.profileMaster')

@section('css')
@endsection
@section('content')

<div class="profile">
    <div class="box">
        <div class="profile-info">
            <div class="profile-header text-center">
                <div class="profile-img">
                    <img class="img-responsive" src="@if (!empty($user->mini_profile_picture_link)) {{ asset( $user->profile_picture_link) }} @else {{ asset( 'images/user/profilePicture/default/user.png') }} @endif">
                </div>
                <h3>{{ $user->name }}</h3>
                <h3>Elite Points: {{ $user->elite_points }}</h3>
                <p>Email: {{ $user->email }}</p>
            </div>
        </div>
    </div>
</div>

<div class="box">
    <nav class="navbar navbar-default">
      <div class="profile-sidebar-nav">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#profile" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>


        <div class="collapse navbar-collapse tab-bar" id="profile">
          <ul class="nav nav-pills">
                <li role="presentation" class="{{ Request::is('user/profile') ? 'active' : ''}}"><a href="{{ url('/user/profile') }}">Home</a></li>
                <li role="presentation" class="{{ Request::is('user/posts') ? 'active' : ''}}"><a href="{{ url('/user/posts') }}">Posts</a></li>
                <li role="presentation" class="{{ Request::is('user/settings') ? 'active' : ''}}"><a href="{{ url('/user/settings') }}">Settings</a></li>
                <li role="presentation" class="{{ Request::is('user/change_password') ? 'active' : ''}}"><a href="{{ url('/user/change_password') }}">Change Passoword</a></li>
                <li role="presentation" class="{{ Request::is('user/social_info') ? 'active' : ''}}"><a href="{{ url('/user/social_info') }}">Social Info</a></li>
                <li role="presentation" class="{{ Request::is('user/notifications') ? 'active' : ''}}"><a href="{{ url('/user/notifications') }}">Notification</a></li>
          </ul>

        </div>
      </div>
    </nav>

    <div id="profile-content">
        @foreach($posts as $post)

            <?php
$title = preg_replace('/\s+/', '-', $post->title);
$title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
$title = $title . '-' . $post->id;

?>

        <div class="story-item">
                <div class="row">
                    <div class="col-md-10 col-sm-10 col-xs-10">
                        <div class="img-box52_32">
                            <a href="{{ url('story/'.$title) }}"><img class="" src="{{ url($post->related_story_image) }}"></a>
                        </div>
                        <div class="img_box52_right">
                            <h4 class="story-title"><a href="{{ url('story/'.$title) }}"> {{ $post->title }}</a></h4>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 dropdown">
                        <button class="pull-right btn_dropdownV dropdown-toggle btn btn-sm" type="button" data-toggle="dropdown">
                            <span class="fa fa-ellipsis-v" ></span></button>
                        <ul class="dropdown-menu dropdown_menuOption_right">
                            <li><a href="#"><i class="fa fa-pencil"></i>&nbsp;Edit</a></li>
                            <li><a href="#"><i class="fa fa-trash"></i>&nbsp;Delete</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
</div>


    <div class="overlay"></div>
@endsection