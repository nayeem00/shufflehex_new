@extends('layouts.profileMaster')


@section('css')

@endsection
@section('content')
    <div class="row">
        <div class="profile box">
            <div class="profile-header text-center">
                <div class="profile-img text-center">
                    <img class="img-responsive img-circle m-auto"
                         src="@if (!empty($user->mini_profile_picture_link)) {{ asset( $user->profile_picture_link) }} @else {{ asset( 'images/user/profilePicture/default/user.png') }} @endif">
                </div>
                <div class="changhe-img-form d-inline-block text-center">
                    <form action="{{ route('profilePictureUpload') }}" method="POST" role="form"
                          enctype="multipart/form-data" id="profile_picture_upload_form">
                        {{ csrf_field() }}
                        <label class="profile-picture-upload-label btn btn-sm btn-danger">
                            <i class="fa fa-pencil"></i>&nbsp;Update Profile Picture
                            <input type="file" class="hidden" name="profilePicture" id="profile_picture_select">
                        </label>
                    </form>
                </div>
            </div>
            <div class="profile-info text-center">
                <h3>{{ $user->name }}</h3>
                <h3>Elite Points: {{ $user->elite_points }}</h3>
                <p>Email: {{ $user->email }}</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="profile box">
            @include('partials.userProfileNav')

            <div id="profile-content">
                <div class="panel-body">
                    <form class="form-horizontal" action="{{ route('profile.store') }}" method="POST" role="form">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12">Work at</label>
                            <div class="col-md-9 col-xs-12">
                                <input type="text" name="work_at" class="form-control" placeholder="Company name"
                                       value="{{ $user->work_at }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12">Education </label>
                            <div class="col-md-9 col-xs-12">
                                <input type="text" name="education" class="form-control"
                                       placeholder="School/College/University" value="{{ $user->education }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12">Location</label>
                            <div class="col-md-9 col-xs-12">
                                <input type="text" name="location" class="form-control"
                                       placeholder="City name, Country name" value="{{ $user->location }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12">Languages</label>
                            <div class="col-md-9 col-xs-12">
                                <input type="text" name="lang" class="form-control"
                                       placeholder="Languages (Comma separated)" value="{{ $user->languages }}">
                            </div>
                        </div>

                        <div class="col-md-12 col-xs-12 form-group left-15">
                            <input type="submit" class="btn btn-primary pull-right" value="Update Profile">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="overlay"></div>
@endsection



