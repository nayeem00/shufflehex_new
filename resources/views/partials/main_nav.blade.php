<div id="mainNav">
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
                    <a href="{{ url('/story') }}"><img class="logo" src="{{ asset('img/logo/shufflehex.png') }}"></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar">
                    <form class="navbar-form navbar-search navbar-left" role="search"  action="{{ route('search.all') }}" method="GET">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" name="search" class="fontAwesome form-control" placeholder="&#xf002; Discover New Content">
                        </div>
                    </form>
                    <ul class="nav navbar-nav">
                        <li ><a href="{{ url('/') }}">Stories<span class="sr-only">(current)</span></a></li>
                        <li><a href="{{ url('/products') }}">Products</a></li>
                        <li><a href="{{ url('/projects') }}">Projects</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Add New&nbsp;&nbsp;</a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('/add') }}">Add Story</a></li>
                                <li><a href="{{ url('/addproject') }}">Add Project</a></li>
                                <li><a href="{{ url('/addproduct') }}">Add Product</a></li>
                            </ul>
                        </li>

                    </ul>
                    <div class="pull-right profile">
                        <ul class="list-unstyled dis-infl">
                            @if (Auth::guest())
                                <li><a class="btn btn-default" href="{{ url('/login') }}">LOG IN</a></li>
                                <li><a class="btn btn-danger mr-l-1" href="{{ url('pages/register') }}">SIGN UP</a></li>
                            @else
                                @if(True)

                                    <li class="dropdown noti-true">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"         aria-expanded="false" onclick="markAsRead({{ count($notifications) }}),markNotificationAsRead({{ count($notifications) }})">
                                            <span class="bell-icon"><i class="fa fa-bell-o"></i>
                                                @if(count($notifications) > 0)
                                                    <sup><span class="notify-active-dot"><i class="fa fa-circle"></i></span></sup>
                                                @endif
                                            </span>

                                        </a>
                                        <ul class="dropdown-menu">
                                            <p class="noti-title">Notifications</p>
                                            @if(count($notifications)>0)
                                            @foreach($notifications as $notification)
                                                <li><a style="padding: 8px;" href="{{ url($notification->story_link) }}">
                                                        <img class="img-responsive nav-img" src="{{ url($notification->user_profile_picture) }}">
                                                        <div class="dis-infl">
                                                            <p>{!! $notification->notification !!}</p>
                                                            <p style="color: #999999;"> {{ $notification->story_title }} </p>
                                                        </div>

                                                    </a>
                                                </li>
                                            @endforeach
                                            @else
                                                <li >
                                                    <p class="text-center">No unread notification available!</p>
                                                </li>
                                            @endif
                                            <li >
                                                <a href="{{ url('/user/notifications') }}" class="all-noti">
                                                    <p>All notification</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                @else
                                    <li class="noti-false">
                                        <a href="#">
                                            <i class="fa fa-bell"></i>
                                        </a>
                                    </li>
                                @endif
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img class="img-responsive nav-img" src="@if (!empty(Auth::user()->mini_profile_picture_link)) {{url(Auth::user()->mini_profile_picture_link)}} @else {{ asset( 'images/user/profilePicture/default/user.png') }} @endif">
                                        <ul class="dropdown-menu">
                                            <li><a href="{{ url('/user/profile') }}">My Profile</a></li>
                                            <li><a href="{{ url('/saved') }}">My Collections</a></li>
                                            <li><a href="{{ url('/story/create') }}">Add Story</a></li>
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
    </div></div>