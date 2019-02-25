@extends('layouts.profileMaster')


@section('css')
    <!-- Bootstrap CSS CDN -->


    <!-- Our Custom CSS -->


@endsection
@section('content')
    @include('partials.profileHeader')
    <div class="row">
        <div class="profile box">
            @include('partials.userProfileNav')

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
    </div>

@endsection



