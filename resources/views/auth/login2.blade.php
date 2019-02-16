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
        #shuffle-loginForm,#shuffle-signForm{
            width: 100%;
        }
        #shuffle-signForm{
            display: none;
        }
    </style>
</head>
<body>
<div id="wrapper">
    @include('partials.topbar')
    <div id="home-body">
        <div class="shuffle-login text-center">

            <form id="shuffle-loginForm" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                        <input id="username" type="text" class="form-control" name="username" placeholder="Username" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('username'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                        @endif
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input id="password" type="password" class="form-control" placeholder="Password" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                </div>


                <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                            </label>
                        </div>
                </div>
<!--                <div class="g-recaptcha" data-sitekey="your_site_key"></div>-->
                <div class="form-group">
                    <input type="submit" class="btn btn-block btn-danger" value="login">
                </div>
                <div class="form-group">
                    <p>Forgot Password - <a href="#">Reset Now</a></p>
                </div>
                <div class="form-group">
                    <a type="button" href="{{ url('/pages/register') }}" class="btn btn-block btn-default">Sign up</a>
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
        $('.post-login').flip({
            trigger:'manual'
        });
    });
    function openSignUpForm() {
        $('#post-signForm').fadeIn();
        $('#post-loginForm').hide();
        $('.post-login').flip(true);
    }
    function backToLogin() {
        $('#post-signForm').hide();
        $('#post-loginForm').fadeIn();
        $('.post-login').flip(true);
    }
</script>
</body>
</html>