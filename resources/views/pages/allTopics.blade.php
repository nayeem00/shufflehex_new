@extends('layouts.storyMaster')
@section('css')
    <!-- Our Custom CSS -->
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <ul class="list-unstyled">
                @foreach($topics as $topic)
                    <li class="list-group-item">
                        <a href="{{ url('/category/'.$topic->category) }}" id="{{ $topic->category }}">
                            <span class="list-icon fa fa-dot-circle-o text-shufflered"></span>{{ $topic->category.'('.$topic->countStory.')' }}</a>
                    </li>
                    @endforeach
            </ul>
        </div>
    </div>
@endsection
@section('js')
@endsection