@extends('layouts.profileMaster')

@section('css')
@endsection
@section('content')
    @include('partials.profileHeader')

    <div class="row">
        <div class="profile box">
            @include('partials.userProfileNav')

    <div id="profile-content">
        @foreach($posts as $post)

            <?php
$title = preg_replace('/\s+/', '-', $post->title);
$title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
$title = $title . '-' . $post->id;

?>

            <div class="user-post-item">
                <div class="row">
                    <div class="col-md-10 col-sm-10 col-xs-10">
                        <div class="post-img img_box57_32">
                            <a href="{{ url('story/'.$title) }}"><img class="img-responsive"
                                                                      src="{{ url($post->related_story_image) }}"></a>
                        </div>
                        <div class="img_box57_right">
                            <h4 class="post-title"><a href="{{ url('story/'.$title) }}"> {{ $post->title }}</a></h4>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 dropdown">
                        <button class="pull-right btn_dropdownV dropdown-toggle btn btn-sm" type="button" data-toggle="dropdown">
                            <span class="fa fa-ellipsis-v" ></span></button>
                        <ul class="dropdown-menu dropdown_menuOption_right">
                            <li><a href="#"><i class="fa fa-pencil"></i>&nbsp;Edit</a></li>
                            <li><a href="#"><i class="fa fa-trash"></i>&nbsp;Delete</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
</div>
    </div>


    <div class="overlay"></div>
@endsection