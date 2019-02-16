<!--<div id="top-bar">
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="<?=$root?>"><img class="logo" src="<?=$root?>img/logo/shufflehex.png"></a>
                <button type="button" id="openSidebar">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
        </div>
    </nav>
</div>-->

<div id="top-bar">

    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a href="{{ url('/post') }}"><img class="logo" src="{{ asset('img/logo/shufflehex.png') }}"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar">
          <form class="navbar-form navbar-left">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Discover your New Content...">
            </div>
          </form>
          <ul class="nav navbar-nav">
            <li ><a href="#">Stories<span class="sr-only">(current)</span></a></li>
            <li><a href="#">Products</a></li>
            <li><a href="#">Projects</a></li>
            <li><a href="#">Add New</a></li>
          </ul>
        <div class="pull-right profile">
            <ul class="list-unstyled dis-infl">
                    @if (Auth::guest())
                    <li><a class="btn btn-default" href="{{ url('/login') }}">LOG IN</a></li>
                    <li><a class="btn btn-danger mr-l-1" href="{{ url('pages/register') }}">SIGN UP</a></li>
                    @else
                        @if(True)
                            <li class="noti-true">
                                <a href="#" >
                                    <span><i class="fa fa-bell"></i></span>
                                    <span class="noti">8</span>
                                </a>
                            </li>
                        @else
                            <li class="noti-false">
                                <a href="#" >
                                    <i class="fa fa-bell"></i>
                                </a>
                            </li>
                        @endif
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="img-responsive nav-img" src="https://www.attractivepartners.co.uk/wp-content/uploads/2017/06/profile.jpg">
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('/user/profile') }}">My Profile</a></li>
                            <li><a href="{{ url('/saved') }}">My Collections</a></li>
                            <li><a href="{{ url('/post/create') }}">Add Story</a></li>
                            <li><a href="{{ url('/user/settings') }}">Settings</a></li>
                            <li><a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">Logout</a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </ul>
                    </li>

            @endif
                </ul>
        </div>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
</div>