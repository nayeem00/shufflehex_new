@extends('layouts.profileMaster')

@section('css')

@endsection
@section('content')
    @include('partials.profileHeader')
    <div class="row">
        <div class="profile box">
            @include('partials.userProfileNav')
            <div id="profile-content">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <td>Total Post</td>
                                <td>{{ $posts }}</td>
                            </tr>
                            <tr>
                                <td>Upvotes</td>
                                <td>{{ $upvotes }}</td>
                            </tr>
                            <tr>
                                <td>Downvotes</td>
                                <td>{{ $downvotes }}</td>
                            </tr>
                            <tr>
                                <td>Saved Stories</td>
                                <td>{{ $savedStories }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="overlay"></div>
@endsection