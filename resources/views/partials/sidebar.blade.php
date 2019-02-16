<div id="sidebar" class="animated">
    <button type="button" id="sidebar-close-btn" class="btn-danger" onclick="sidebar_close()">
        <span class="fa fa-close"></span>
    </button>
    <div class="sidebar-menu">
        <ul class="list-unstyled">

            <li><a href="{{ route('profile.index') }}" class=""><i class="fa fa-eye"></i> View Profile</a></li>

            <li><a href="{{ url('/category/create') }}" class="">Add Category</a></li>
            <li><a href="{{ url('/story/create') }}" class="">Add Story</a></li>
            <li><a href="{{ url('/pages/latest') }}" class="">Latest Stories</a></li>
            <li><a href="{{ url('/pages/top') }}" class="">Top Stories</a></li>
            <li><a href="{{ url('/pages/popular') }}" class="">Popular Stories</a></li>
            <li><a href="{{ route('story.index') }}" class="">List Stories</a></li>
            <li><a href="{{ url('/pages/blog') }}" class="">Blog Posts</a></li>

        </ul>

    </div>
    @if (Auth::guest())
        <div class="sidebar-login-link text-center">
            <a href="{{ url('/pages/signin') }}" style="margin-right: 5px">Sign in</a>
            <a href="{{ url('/pages/register') }}" style="margin-left: 5px">Register</a>
        </div>
    @else
        <div class="sidebar-login-link text-center">
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
                    {{--<a href="{{ route('logout') }}"--}}
                       {{--onclick="event.preventDefault();--}}
                                                     {{--document.getElementById('logout-form').submit();">--}}
                        {{--Logout--}}
                    {{--</a>--}}

                    {{--<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">--}}
                        {{--{{ csrf_field() }}--}}
                    {{--</form>--}}
    @endif
    <div class="sidebar-footer text-center">
        <a href="{{ url('/pages/about') }}">about us</a><span class="seperator">|</span>
        <a href="{{ url('/pages/privacy') }}">privacy policy</a><span class="seperator">|</span>
        <a href="{{ url('/pages/support') }}">support</a>
    </div>
</div>