@extends('layouts.master')
@section('css')
    <!-- Bootstrap CSS CDN -->
    <title>404</title>
    <!-- Include Editor style. -->
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/list-style.css') }}">



@endsection


@section('content')

<div class="page-404">
    <h1>404</h1>
    <p class="paragraph">page not found</p>
    <a class="btn btn-xs btn-default" href="{{ url('/story') }}">
        <span>HOMEPAGE</span>
    </a>
</div>

@endsection
@section('js')



@endsection