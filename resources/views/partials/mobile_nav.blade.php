<div id="mobileNav">
    <nav class="navbar navbar-default mobile-navbar">
        <div class="container-fluid">
            <div class="mobile-nav w-100">
                <div class="mobile-nav-list mobile-nav-left pull-left">
                    {{--<a href="#" id="sidebarCollapse" onclick="openSidebarmenu(event)" class="btn-menu-toggle d-inline-block">--}}
                    <a href="#" id="sidebarCollapse" class="btn-menu-toggle d-inline-block">
                        <i class="fa fa-bars"></i>
                    </a>
                    <form class="mobile-nav-search d-inline-block" role="search">
                        <input type="text" class="fontAwesome" placeholder="&#xf002; Discover New">
                    </form>
                </div>
                <div class="mobile-nav-list mobile-nav-right pull-right">
                    <ul class="mobile-nav__link-list list-inline">
                        <li class="dropdown">
                            <a id="mobile_ntf_nav_icon" class="bell-icon" data-toggle="dropdown" onclick="markAsRead({{ count($notifications) }}),markNotificationAsRead({{ count($notifications) }})">
                                <i class="fa fa-bell-o"></i>
                                @if(count($notifications) > 0)
                                    <sup><span class="notify-active-dot"><i class="fa fa-circle"></i></span></sup>
                                @endif
                            </a>
                            <ul class="dropdown-menu notification-list">
                                <p class="noti-title">Notification</p>

                                @foreach($notifications as $notification)
                                    <li>
                                        <a style="padding: 8px;" href="{{ url($notification->story_link) }}">
                                            <img class="img-responsive user-img" src="{{ url($notification->user_profile_picture) }}">
                                            <div class="dis-notification">
                                                <p style="color: #555;">{!! $notification->notification !!}</p>
                                                <p style="color: #999999;"> {{ $notification->story_title }} </p>
                                            </div>

                                        </a>
                                    </li>
                                @endforeach
                                <li class="notification-list-footer">
                                    <a href="{{ url('/user/notifications') }}" class="all-noti">
                                        All notification
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            @if (Auth::guest())
                                <a class="user-no-img" href="{{ url('/login') }}">
                                    <img class="img-circle"
                                         src="@if (!empty(Auth::user()->mini_profile_picture_link)) {{url(Auth::user()->mini_profile_picture_link)}} @else {{ asset( 'images/user/profilePicture/default/user.png') }} @endif">
                                </a>
                            @else
                                <a id="mobile_nav_user_icon" href="#">
                                    <img class="img-circle"
                                         src="@if (!empty(Auth::user()->mini_profile_picture_link)) {{url(Auth::user()->mini_profile_picture_link)}} @else {{ asset( 'images/user/profilePicture/default/user.png') }} @endif">
                                </a>
                            @endif
                        </li>
                    </ul>

                </div>
            </div>

        </div><!-- /.container-fluid -->
    </nav>
    <nav class="navbar" style="display: none">
        <div class="mobile-search-bar">
            <form style="padding: 5px 30px">
                <input class="form-control">

            </form>
        </div>
    </nav>
</div>
