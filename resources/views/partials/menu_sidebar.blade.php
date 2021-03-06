<nav id="menu-sidebar" class="animated">
    <div class="nav-side-menu">
        <div class="sidebar-menu-brand w-100 text-center">
            <a class="d-inline-block" href="{{ url('/story') }}">
                <img class="sidebar-logo img-responsive" src="{{ asset('img/logo/shufflehex.png') }}"></a>
        </div>
        <div class="menu-list">
            <ul id="menu-content" class="menu-content">
                <li data-toggle="collapse" data-target="#stories-menu" class="collapsed" aria-controls="stories-menu">
                    <a href="#">Stories <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse" id="stories-menu">
                    <li><a href="{{ url('/story/trending') }}">Trending</a></li>
                    <li><a href="{{ url('/story/latest') }}">Latest</a></li>
                    <li><a href="{{ url('/story/top') }}">Top</a></li>
                    <li><a href="{{ url('/story/popular') }}">Popular</a></li>
                </ul>
                <li data-toggle="collapse" data-target="#products-menu" class="collapsed">
                    <a href="#">Products <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse" id="products-menu">
                    <li><a href="#">Trending</a></li>
                    <li><a href="#">Latest</a></li>
                    <li><a href="#">Popular</a></li>
                </ul>
                <li data-toggle="collapse" data-target="#projects-menu" class="collapsed">
                    <a href="#">Projects <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse" id="projects-menu">
                    <li><a href="#">Trending</a></li>
                    <li><a href="#">Latest</a></li>
                    <li><a href="#">Popular</a></li>
                </ul>
                <li><a href="#">Topics</a></li>
                <li data-toggle="collapse" data-target="#add-menu" class="collapsed">
                    <a href="#">Add New <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse" id="add-menu">
                    <li><a href="{{ url('/add') }}">Add Story</a></li>
                    <li><a href="{{ url('/addproject') }}">Add Product</a></li>
                    <li><a href="{{ url('/addproduct') }}">Add Project</a></li>
                </ul>

            </ul>
        </div>
    </div>
</nav>
