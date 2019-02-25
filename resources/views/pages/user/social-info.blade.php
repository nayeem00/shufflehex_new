@extends('layouts.profileMaster')


@section('css')

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
                    <label class="col-md-3 col-xs-12">Facebook</label>
                    <div class="col-md-9 col-xs-12">
                        <input type="url" name="facebook" class="form-control" placeholder="Facebook">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-xs-12">Google Plus</label>
                    <div class="col-md-9 col-xs-12">
                        <input type="url" name="googlePlus" class="form-control" placeholder="Google Plus">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-xs-12">LinkedIn</label>
                    <div class="col-md-9 col-xs-12">
                        <input type="url" name="linkedIn" class="form-control" placeholder="LinkedIn">
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