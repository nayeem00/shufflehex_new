@extends('layouts.profileMaster')


@section('css')

@endsection
@section('content')
    @include('partials.profileHeader')

    <div class="row">
        <div class="profile box">
            @include('partials.userProfileNav')

    <div id="profile-content">
        @foreach($notifications as $notification)
            <div class="notification-item">
                <div class="row m-0">
                    <div class="col-md-11 col-sm-11 col-xs-10">
                        <div class="img_box32_32">
                            <a href="{{ url($notification->user_profile_link) }}"><img class="" src="{{ url($notification->user_profile_picture) }}"></a>
                        </div>
                        <div class="img_box32_right">
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