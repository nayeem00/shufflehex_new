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
        <div class="panel panel-primary">
            <div class="panel-body">
                <table class="table">
                    <tr >
                        <td>Total Post</td>
                        <td>{{ $posts }}</td>
                    </tr>
                    <tr >
                        <td>Upvotes</td>
                        <td>{{ $upvotes }}</td>
                    </tr>
                    <tr >
                        <td>Downvotes</td>
                        <td>{{ $downvotes }}</td>
                    </tr>
                    <tr >
                        <td>Saved Stories</td>
                        <td>{{ $savedStories }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="overlay"></div>
 @endsection