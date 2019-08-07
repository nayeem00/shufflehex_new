
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
                        <input type="text" name="name" id="regName" class="form-control" placeholder="Name" autofocus>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                        <input type="text" name="username" id="regUsername" class="form-control" placeholder="Username" value="{{ old('username') }}"  autofocus>
                        @if ($errors->has('username'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                    @endif
                    </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input type="email" name="email" id="regEmail" class="form-control" placeholder="Email">
                         @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input type="password" name="password" id="loginPassword" class="form-control" placeholder="Password">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="password" name="password_confirmation" id="confirmPassword" class="form-control" placeholder="Confirm Password">
                    </div>

                    <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                        <div class="g-recaptcha" data-sitekey ="6LfQ57EUAAAAALH8mmY8IxIjxL1vA-vYFIaiBJJ4"></div>
                        @if($errors->has('g-recaptcha-response'))
                            @if ($errors->has('g-recaptcha-response'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                            @endif
                        @endif
                    </div>

                    <div class="form-group">
                        <input type="submit" name="btn-signup" id="btn-signup" value="Signup" class="btn btn-block btn-danger">
                    </div>
                    <div class="form-group">
                        <a class="btn btn-block btn-default" href="{{ url('/login') }}">Login</a>
                    </div>
                    <div class="form-group">
                        {{--<a class="btn btn-block btn-default" href="{{ url('/login/google') }}">Login with google</a>--}}
                        {{--<div id="my-signin2" data-onsuccess="onSignIn"></div>--}}
                    </div>
                </form>
            </div>

@endsection

@section('js')

    <script>
        var googleUser = '';
        function onPageLoad(user) {
            googleUser = user;
            console.log(googleUser);
        }
        function onSignIn(googleUser) {
            var profile = googleUser.getBasicProfile();
            console.log(profile.getName());
            var name = profile.getName();
            var email = profile.getEmail();
            var image = profile.getImageUrl();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'post',
                url: '{{url("loginWithGoogle")}}',
                data: {_token: CSRF_TOKEN, name: name, email: email, image: image},
                dataType: 'JSON',
                success: function (data) {
                    if (data.status==='success'){
                        window.location.href = '{{url("/")}}';
                    }
                }
            });
        }
        function onSuccess(googleUser) {

        }
        function onFailure(error) {
            console.log(error);
        }
        function renderButton() {
            gapi.signin2.render('my-signin2', {
                'scope': 'profile email',
                'width': 240,
                'height': 50,
                'longtitle': true,
                'theme': 'dark',
                'onfailure': onFailure
            });
        }
    </script>

    <script src="https://apis.google.com/js/platform.js?onload=renderButton&render=explicit" async defer></script>
<!-- Include Editor JS files. -->

@endsection

