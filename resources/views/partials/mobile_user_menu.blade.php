<div id="mobile_user_sidebar">
    <div class="user-header w-100 text-center">
        <div class="user_img d-inline-block m-auto">
            <img class="img-circle"
                 src="@if (!empty(Auth::user()->profile_picture_link)) {{url(Auth::user()->profile_picture_link)}} @else {{ asset( 'images/user/profilePicture/default/user.png') }} @endif">
        </div>
        <h3>@<span>{{ Auth::user()->username }}</span></h3>
        <p>Elite Point: <strong>50</strong></p>
    </div>
    <div class="user-links w-100 text-center">
        <ul class="list-unstyled">
            <li><a href="{{ url('/user/profile') }}">My Profile</a></li>
            <li><a href="{{ url('/saved') }}">My Collections</a></li>
            <li><a href="{{ url('/add') }}">Add Story</a></li>
            <li><a href="{{ url('/user/settings') }}">Settings</a></li>
        </ul>
    </div>
    <div class="mobile_user_footer w-100">
        <a href="#">About us</a>
        <a href="#">Privacy Policy</a>
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>

    </div>
</div>