<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shuffle Case</title>
    <link rel="stylesheet/less" type="text/css" href="{{ asset('shufflehex/less/home.less') }}">
    @include('partials.assets')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <style>
        #home-body{
            background-color: #e8eaed;
            width: 100%;
            height: 100% !important;
            position: relative;
            margin-top: -50px;
            margin-bottom: -50px;
            float: left;
        }
        .shuffle-login{
            background-color: #dadada;
            text-align: center;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1000;
            position: relative;
            max-width: 320px;
            margin: auto;
            box-shadow: 0 0 0 2px grey;
            padding: 2%;
        }
        .shuffle-login input.form-control{
            text-align: center !important;
            height: 38px;
            color: #0a646f;
            box-shadow: 0 0 2px 0 #24343d;
            border-radius: 0;
            font-size: 14px;
            font-weight: 600;
        }
        #shuffle-signForm{
            width: 100%;
        }
    </style>
</head>
<body>
<div id="wrapper">
    @include('partials.topbar')
    <div id="home-body">
        <div class="shuffle-login text-center">
            <form  id="shuffle-signForm" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                        <input id="fullName" type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name') }}" required autofocus>

                        @if ($errors->has('name'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        @endif
                </div>
                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">

                    <input id="username" type="text" class="form-control" name="username" placeholder="Username" value="{{ old('username') }}" required autofocus>

                    @if ($errors->has('name'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                        <input id="email" type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                </div>

                <div class="form-group">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="registerNow" id="registerNow" class="btn btn-block btn-danger" value="Sign up">
                </div>
                <div class="form-group">
                    <a class="btn btn-block btn-default" href="{{ url('/pages/signin') }}">Log in</a>
                </div>
            </form>
        </div>
    </div>
    <footer id="footer" class=" text-center" >
        <p class="text-center">&copy; 2017</p>
    </footer>
</div>
@include('partials.sidebar')
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>-->
<!--<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>-->
<script>
    $(document).ready(function () {
        $('.shuffle-login').flip({
            trigger:'manual'
        });
    });
    function openSignUpForm() {
        $('#shuffle-signForm').fadeIn();
        $('#shuffle-loginForm').hide();
        $('.shuffle-login').flip(true);
    }
    function backToLogin() {
        $('#shuffle-signForm').hide();
        $('#shuffle-loginForm').fadeIn();
        $('.shuffle-login').flip(true);
    }
</script>
</body>
</html>