@extends('layouts.profileMaster')


@section('css')
    <!-- Bootstrap CSS CDN -->


    <!-- Our Custom CSS -->


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
                <h3>EP: {{ $user->elite_points }}</h3>
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
        <div class="panel-body">
            <form class="form-horizontal" action="{{ route('password-reset') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="col-md-3 col-xs-12">Old Password</label>
                    <div class="col-md-9 col-xs-12">
                        <input type="password" name="oldPassword" class="form-control" placeholder="Old Password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-xs-12">New Password</label>
                    <div class="col-md-9 col-xs-12">
                        <input type="password" name="newPassword" class="form-control" placeholder="New Password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-xs-12">Confirm Password</label>
                    <div class="col-md-9 col-xs-12">
                        <input type="password" name="confirmPassword" class="form-control" placeholder="Confirm Password">
                    </div>
                </div>
                <div class="col-md-12 col-xs-12 form-group left-15">
                    <input type="submit" class="btn btn-primary pull-right" value="Submit">
                </div>
            </form>
        </div>
    </div>
</div>

@endsection



