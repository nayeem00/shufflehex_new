<div class="col-md-12 p-0">
    <div class="pull-left">
        <h1 class="box-title h-22 m-0 text-555">ShuffleHex Stories</h1>
    </div>
    <div class="pull-right">
        <ul class="list-unstyled list-inline mb-0">
            <li>
                @if(isset($page) && !empty($page) && $page=='Trending')
                    <a style="color: #000" href="{{ url('/story/trending') }}">Trending</a>
                @else
                    <a href="{{ url('/story/trending') }}">Trending</a>
                @endif
            </li>
            <li>
                @if(isset($page) && !empty($page) && $page=='Latest')
                    <a style="color: #000" href="{{ url('/story/latest') }}">Latest</a>
                @else
                    <a href="{{ url('/story/latest') }}">Latest</a>
                @endif
            </li>
            <li>
                @if(isset($page) && !empty($page) && $page=='Popular')
                    <a style="color: #000" href="{{ url('/story/popular') }}">Popular</a>
                @else
                    <a href="{{ url('/story/popular') }}">Popular</a>
                @endif
            </li>
            <li>
                @if(isset($page) && !empty($page) && $page=='Top')
                    <a style="color: #000" href="{{ url('/story/top') }}">Top</a>
                @else
                    <a href="{{ url('/story/top') }}">Top</a>
                @endif
            </li>
            <li class="">
                <button class="btn-filter" data-toggle="collapse" data-target="#filter">Filter <i
                            class="fa fa-filter"></i></button>
            </li>
        </ul>
    </div>
</div>