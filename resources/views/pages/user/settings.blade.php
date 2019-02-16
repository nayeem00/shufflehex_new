@extends('layouts.profileMaster')


@section('css')

@endsection
@section('content')

<div class="profile">
    <div class="box">
        <div class="profile-info">
            <div class="profile-header text-center">
                <div class="profile-img">
                    <div class="profile-picture">
                        <img class="img-responsive" src="@if (!empty($user->mini_profile_picture_link)) {{ asset( $user->profile_picture_link) }} @else {{ asset( 'images/user/profilePicture/default/user.png') }} @endif">
                    </div>
                    <form class="form-horizontal" action="{{ route('profilePictureUpload') }}" method="POST" role="form" enctype="multipart/form-data" id="profile_picture_upload_form">
                        {{ csrf_field() }}
                        <label class="profile-picture-upload-label">
                            Update Profile Picture  <input type="file" name="profilePicture" id="profile_picture_select" style="display: none;">
                        </label>
                    </form>
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
        <div class="panel-body">
            <form class="form-horizontal" action="{{ route('profile.store') }}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="col-md-3 col-xs-12">Work at</label>
                    <div class="col-md-9 col-xs-12">
                        <input type="text" name="work_at" class="form-control" placeholder="Company name" value="{{ $user->work_at }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 col-xs-12">Education </label>
                    <div class="col-md-9 col-xs-12">
                        <input type="text" name="education" class="form-control" placeholder="School/College/University" value="{{ $user->education }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-xs-12">Location</label>
                    <div class="col-md-9 col-xs-12">
                        <input type="text" name="location" class="form-control" placeholder="City name, Country name" value="{{ $user->location }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-xs-12">Languages</label>
                    <div class="col-md-9 col-xs-12">
                        <input type="text" name="lang" class="form-control" placeholder="Languages (Comma separated)" value="{{ $user->languages }}">
                    </div>
                </div>

                <div class="col-md-12 col-xs-12 form-group left-15">
                    <input type="submit" class="btn btn-primary pull-right" value="Update Profile">
                </div>
            </form>
        </div>
    </div>
</div>


    <div class="overlay"></div>
@endsection



