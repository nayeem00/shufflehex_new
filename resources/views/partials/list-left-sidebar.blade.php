<div id="left-sidebar">
    <div id="list-left-sidebar">
        <div class="sibebar-panel">
            <div class="sidebar-link-list">
                <ul class="list-group">
                    <li class="list-group-item list-group-title">TRENDING TOPICS</li>
                    @foreach($topics as $topic)
                        @if(isset($category) && !empty($category) && $topic->category==$category)
                            <li class="list-group-item active">
                                <a href="{{ url('/category/'.$topic->category) }}" id="{{ $topic->category }}">
                                <span class="list-icon fa fa-dot-circle-o text-shufflered"></span>{{ $topic->category }}</a>
                            </li>
                        @else
                        <li class="list-group-item">
                            <a href="{{ url('/category/'.$topic->category) }}" id="{{ $topic->category }}">
                                <span class="list-icon fa fa-dot-circle-o text-shufflered"></span>{{ $topic->category }}</a>
                        </li>
                        @endif
                    @endforeach
                    <li class="list-group-item text-center">
                        <a href="{{ url('/topics') }}">See All Topics</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
