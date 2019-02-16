<nav id="menu-sidebar" class="animated">
    <div class="nav-side-menu">
        <div class="sidebar-menu-brand w-100 text-center">
            <a class="d-inline-block" href="{{ url('/story') }}"><img class="sidebar-logo img-responsive"
                                                                      src="{{ asset('img/logo/shufflehex.png') }}"></a>
        </div>
        <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

        <div class="menu-list">

            <ul id="menu-content" class="menu-content">
                <li data-toggle="collapse" data-target="#new" class="collapsed">
                    <a href="#"><i class="fa fa-car fa-lg"></i> New <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse" id="new">
                    <li><a href="#">Abc Def</a></li>
                    <li><a href="#">Abc Def</a></li>
                    <li><a href="#">Abc Def</a></li>
                </ul>


                <li>
                    <a href="#">
                        <i class="fa fa-user fa-lg"></i> Profile
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="fa fa-users fa-lg"></i> Users
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
