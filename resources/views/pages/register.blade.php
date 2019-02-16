@extends('layouts.master')

@section('css')
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/add.less') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/login-reg.css') }}">

@endsection
@section('content')
            <div id="account-form">
                <form id="signupForm" method="post" role="form" action="{{ route('register') }}">
                    {{ csrf_field() }}
                    <div class="signup-title">
                        <h3>SIGN UP</h3>
                    </div>
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <input type="text" name="name" id="regName" class="form-control" placeholder="Name" required autofocus>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                        <input type="text" name="username" id="regUsername" class="form-control" placeholder="Username" value="{{ old('username') }}" required autofocus>
                        @if ($errors->has('username'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                    @endif
                    </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input type="email" name="email" id="regEmail" class="form-control" placeholder="Email" required>
                         @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input type="password" name="password" id="loginPassword" class="form-control" placeholder="Password" required>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="password" name="password_confirmation" id="confirmPassword" class="form-control" placeholder="Confirm Password">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="btn-signup" id="btn-signup" value="Signup" class="btn btn-block btn-danger">
                    </div>
                    <div class="form-group">
                        <a class="btn btn-block btn-default" href="{{ url('/pages/signin') }}">Login</a>
                    </div>
                </form>
            </div>

@endsection

@section('js')


<!-- Include Editor JS files. -->

@endsection

