<nav class="navbar navbar-default">
    <div class="profile-sidebar-nav">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#profile"
                    aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>


        <div class="collapse navbar-collapse tab-bar" id="profile">
            <ul class="nav nav-pills">
                <li role="presentation" class="{{ Request::is('user/profile') ? 'active' : ''}}"><a
                            href="{{ url('/user/profile') }}">Home</a></li>
                <li role="presentation" class="{{ Request::is('user/posts') ? 'active' : ''}}"><a
                            href="{{ url('/user/posts') }}">Posts</a></li>
                <li role="presentation" class="{{ Request::is('user/settings') ? 'active' : ''}}"><a
                            href="{{ url('/user/settings') }}">Settings</a></li>
                <li role="presentation" class="{{ Request::is('user/change_password') ? 'active' : ''}}"><a
                            href="{{ url('/user/change_password') }}">Change Passoword</a></li>
                <li role="presentation" class="{{ Request::is('user/social_info') ? 'active' : ''}}"><a
                            href="{{ url('/user/social_info') }}">Social Info</a></li>
                <li role="presentation" class="{{ Request::is('user/notifications') ? 'active' : ''}}"><a
                            href="{{ url('/user/notifications') }}">Notification</a></li>
            </ul>

        </div>
    </div>
</nav>