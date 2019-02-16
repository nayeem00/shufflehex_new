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
        @foreach($notifications as $notification)
            <div class="notification-item">
                <div class="row m-0">
                    <div class="col-md-11 col-sm-11 col-xs-10">
                        <div class="img-box52_32">
                            <a href="{{ url($notification->user_profile_link) }}"><img class="" src="{{ url($notification->user_profile_picture) }}"></a>
                        </div>
                        <div class="img_box52_right">
                            {{--<p class="notification-title"><a href="#">What is Lorem Ipsum?</a></p>--}}
                            <p>
                                <a href="{{ url($notification->story_link) }}"> {!! $notification->notification !!}</a>
                            </p>
                            <p>
                                <a href="{{ url($notification->story_link) }}"> {!! $notification->story_title !!}</a>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-2">
                        <button class="pull-right btn_dropdownV dropdown-toggle btn btn-sm" type="button" data-toggle="dropdown">
                            <span class="fa fa-ellipsis-v" ></span></button>
                        <ul class="dropdown-menu dropdown_menuOption_right">
                            <li><a href="#"><i class="fa fa-trash"></i>&nbsp;Delete</a></li>
                            <li><a href="#"><i class="fa fa-envelope-open"></i>&nbsp;Mark as Read</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    </div>
</div>


    <div class="overlay"></div>
@endsection