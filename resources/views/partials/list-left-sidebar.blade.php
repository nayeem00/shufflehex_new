<div id="left-sidebar">
    <div id="list-left-sidebar">
        <div class="sibebar-panel">
            <div class="list-group">

                <li class="list-group-item list-group-title">CATEGORIES</li>
                @if(isset($page2) && !empty($page2) && $page2=='Trending')
                    <a id="trending_stories" class="list-group-item active">
                        <img src="{{ asset('icons/trending-stories.svg') }}">Trending Stories</a>
                @else
                    <a id="trending_stories" class="list-group-item">
                        <img src="{{ asset('icons/trending-stories.svg') }}">Trending Stories</a>
                @endif
                @if(isset($page2) && !empty($page2) && $page2=='Latest')
                <a id="latest_stories" class="list-group-item active">
                    <img src="{{ asset('icons/latest-stories.svg') }}">Latest Stories</a>
                @else
                <a id="latest_stories" class="list-group-item">
                    <img src="{{ asset('icons/latest-stories.svg') }}">Latest Stories</a>
                @endif

                @if(isset($page2) && !empty($page2) && $page2=='Top')
                <a id="top_stories" class="list-group-item active">
                    <img src="{{ asset('icons/top-stories.svg') }}">Top Stories</a>
                @else
                <a id="top_stories" class="list-group-item">
                    <img src="{{ asset('icons/top-stories.svg') }}">Top Stories</a>
                @endif

                @if(isset($page2) && !empty($page2) && $page2=='Popular')
                <a id="popular_stories" class="list-group-item active">
                    <img src="{{ asset('icons/popular-stories.svg') }}">Popular Stories</a>
                @else
                <a id="popular_stories" class="list-group-item">
                    <img src="{{ asset('icons/popular-stories.svg') }}">Popular Stories</a>
                @endif
            </div>
        </div>


        <div class="sibebar-panel">
            <div class="sidebar-link-list">
                <div class="list-group">
                    <li class="list-group-item list-group-title">TOPICS</li>

                    @if(isset($page1) && !empty($page1) && $page1=='all')
                    <a href="{{ url('/story') }}" id="all" class="list-group-item active">
                        <img src="{{ asset('img/profile-header-orginal.jpg') }}">ALL</a>
                    @else
                    <a href="{{ url('/story') }}" id="all" class="list-group-item">
                        <img src="{{ asset('img/profile-header-orginal.jpg') }}">ALL</a>
                    @endif

                    @if(isset($page1) && !empty($page1) && $page1=='web')
                    <a href="{{ url('/story/web') }}" id="web" class="list-group-item active">
                        <img src="{{ asset('img/profile-header-orginal.jpg') }}">Web</a>
                    @else
                    <a href="{{ url('/story/web') }}" id="web" class="list-group-item">
                        <img src="{{ asset('img/profile-header-orginal.jpg') }}">Web</a>
                    @endif

                    @if(isset($page1) && !empty($page1) && $page1=='images')
                    <a href="{{ url('/storyimages') }}" id="images" class="list-group-item active">
                        <img src="{{ asset('img/profile-header-orginal.jpg') }}">Images/a>
                    @else
                    <a href="{{ url('/story/images') }}" id="images" class="list-group-item">
                        <img src="{{ asset('img/profile-header-orginal.jpg') }}">Images</a>
                    @endif

                    @if(isset($page1) && !empty($page1) && $page1=='videos')
                    <a href="{{ url('/story/videos') }}" id="videos" class="list-group-item active">
                        <img src="{{ asset('img/profile-header-orginal.jpg') }}">Videos/a>
                    @else
                    <a href="{{ url('/story/videos') }}" id="videos" class="list-group-item">
                        <img src="{{ asset('img/profile-header-orginal.jpg') }}">Videos</a>
                    @endif

                    @if(isset($page1) && !empty($page1) && $page1=='articles')
                    <a href="{{ url('/story/articles') }}" id="articles" class="list-group-item active">
                        <img src="{{ asset('img/profile-header-orginal.jpg') }}">Articles/a>
                    @else
                    <a href="{{ url('/story/articles') }}" id="articles" class="list-group-item">
                        <img src="{{ asset('img/profile-header-orginal.jpg') }}">Articles</a>
                    @endif

                    @if(isset($page1) && !empty($page1) && $page1=='lists')
                    <a href="{{ url('/story/lists') }}" id="lists" class="list-group-item active">
                        <img src="{{ asset('img/profile-header-orginal.jpg') }}">Lists/a>
                    @else
                    <a href="{{ url('/story/lists') }}" id="lists" class="list-group-item">
                        <img src="{{ asset('img/profile-header-orginal.jpg') }}">Lists</a>
                    @endif

                    @if(isset($page1) && !empty($page1) && $page1=='polls')
                    <a href="{{ url('/story/polls') }}" id="polls" class="list-group-item active">
                        <img src="{{ asset('img/profile-header-orginal.jpg') }}">Polls/a>
                    @else
                    <a href="{{ url('/story/polls') }}" id="polls" class="list-group-item">
                        <img src="{{ asset('img/profile-header-orginal.jpg') }}">Polls</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
