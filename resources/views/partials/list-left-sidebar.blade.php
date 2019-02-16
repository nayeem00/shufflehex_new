<div id="left-sidebar">
    <div id="list-left-sidebar">
        <div class="sibebar-panel">
            <div class="list-group">

                <li class="list-group-item list-group-title">CATEGORIES</li>
                @if(isset($page) && !empty($page) && $page=='Trending')
                    <a id="trending_stories" class="list-group-item active" href="{{ url('/story/trending') }}">
                        <img src="{{ asset('icons/trending-stories.svg') }}">Trending Stories</a>
                @else
                    <a id="trending_stories" class="list-group-item" href="{{ url('/story/trending') }}">
                        <img src="{{ asset('icons/trending-stories.svg') }}">Trending Stories</a>
                @endif
                @if(isset($page) && !empty($page) && $page=='Latest')
                <a id="latest_stories" class="list-group-item active" href="{{ url('/story/latest') }}">
                    <img src="{{ asset('icons/latest-stories.svg') }}">Latest Stories</a>
                @else
                <a id="latest_stories" class="list-group-item" href="{{ url('/story/latest') }}">
                    <img src="{{ asset('icons/latest-stories.svg') }}">Latest Stories</a>
                @endif

                @if(isset($page) && !empty($page) && $page=='Top')
                <a id="top_stories" class="list-group-item active" href="{{ url('/story/top') }}">
                    <img src="{{ asset('icons/top-stories.svg') }}">Top Stories</a>
                @else
                <a id="top_stories" class="list-group-item" href="{{ url('/story/top') }}">
                    <img src="{{ asset('icons/top-stories.svg') }}">Top Stories</a>
                @endif

                @if(isset($page) && !empty($page) && $page=='Popular')
                <a id="popular_stories" class="list-group-item active" href="{{ url('/story/popular') }}">
                    <img src="{{ asset('icons/popular-stories.svg') }}">Popular Stories</a>
                @else
                <a id="popular_stories" class="list-group-item" href="{{ url('/story/popular') }}">
                    <img src="{{ asset('icons/popular-stories.svg') }}">Popular Stories</a>
                @endif
            </div>
        </div>


        <div class="sibebar-panel">
            <div class="sidebar-link-list">
                <div class="list-group">
                    <li class="list-group-item list-group-title">TOPICS</li>
                    @foreach($topics as $topic)
                        @if(isset($category) && !empty($category) && $topic->category==$category)
                            <a href="{{ url('/category/'.$topic->category) }}" id="{{ $topic->category }}"
                               class="list-group-item active">
                                <img src="{{ asset('images/icons/Topic.svg') }}">{{ $topic->category }}</a>
                        @else
                            <a href="{{ url('/category/'.$topic->category) }}" id="{{ $topic->category }}" class="list-group-item">
                                <img src="{{ asset('images/icons/Topic.svg') }}">{{ $topic->category }}</a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
