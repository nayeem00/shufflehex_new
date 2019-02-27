@extends('layouts.storyMaster')
<?php
$actual_link = URL::to('/');
$imageLink = $actual_link."/images/icons/shufflehex_featured.jpg";
$searchUrl = $actual_link."/search?search={search_term}";
?>
@section('meta')
    <title>ShuffleHex.com | Content Discovery Platform</title>
    <meta name="description" content="ShuffleHex is a next generation content discovery platform that pushed recommends of web content to it's users. Users can also save anything from anywhere."/>
    <meta name="og:image" content="{{ $imageLink }}"/>
@endsection
@section('css')
    <!-- Our Custom CSS -->
    <!-- Bootstrap CSS CDN -->
@endsection

@section('content')

    {{----------------------------- store current url to session -----------------------}}
    <?php use App\Http\SettingsHelper;session(['last_page' => url()->current()]);?>
    {{-------------------------------------------------------------------------------------}}

    @include('partials.shufflebox')

    <div class="box">
        <div class="row box-header m-0">

                <div class="col-md-12">
                    <div class="pull-left">
                        <h1 style="margin: 0;"><small>ShuffleHex Stories</small></h1>
                    </div>
                    <div class="pull-right">
                        <button class="btn" data-toggle="collapse" data-target="#filter">Filter <i
                                    class="fa fa-filter"></i></button>
                    </div>


                </div>
        </div>

        <?php if($pageKey == "story-main") { ?>

        @include('partials.filter_row',['posts' => $posts,'removeFilter' => []])
        <?php } else { ?>
        @include('partials.filter_row',['posts' => $posts,'removeFilter' => ["other" => 'other']])
        <?php } ?>

        <div class="posts">
            @include('partials.post_item',['posts' => $posts])
        </div>

    </div>
    <?php $offset = SettingsHelper::getSetting('story_limit') ?>
    <input type="hidden" value="<?= $offset->value?>" id="post-count-offset" data-offset="<?= $offset->value?>">
    <input type="hidden" value="" id="page-key" data-page="<?= $pageKey ?>">
    <div class="text-center">
        <label style="font-size: 14px" class="text-danger text-center no-post-available"></label>
    </div>


    <!-- save url modal -->
    <div class="save-page-modal modal fade" id="saveStoryModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center"><i class="fa fa-plus-circle"></i> Save New Story</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('folderStory.store') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Select a folder to save this story.</label>
                            @if(isset($folders) && !empty($folders))
                                <select class="selectpicker" data-live-search="true" name="folder_id"
                                        id="save_story_folder_id">
                                    @foreach($folders as $folder)
                                        <option value="{{ $folder->id }}"
                                                data-tokens="{{ $folder->folder_name }}">{{ $folder->folder_name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                        <input type="hidden" name="post_id" class="form-control" id="save_story_post_id">
                        @if(isset(Auth::user()->id) && !empty(Auth::user()->id))
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" id="save_story_user_id">
                        @else
                            <input type="hidden" name="user_id" value="" id="save_story_user_id">
                        @endif
                        <div class="form-group">
                            <button type="button" class="btn btn-block btn-danger" onclick="saveStoryData()">Save
                                Story
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection




@section('js')

    <script src="{{ asset('ChangedDesign/js/filter-story.js') }}"></script>
    <script src="{{ asset('ChangedDesign/js/load-more.js') }}"></script>



    <script>
        function upVote(post_id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var property = 'btn_upVote_' + post_id;
            console.log(post_id);
            $.ajax({
                type: 'post',
                url: '{{url("vote")}}',
                data: {_token: CSRF_TOKEN, post_id: post_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if (data.status == 'upvoted') {
                         var element = document.getElementById("upvote_icon_"+post_id);
                        element.classList.add("text-shufflered");
                        $('#vote_count_' + post_id).text(data.voteNumber);
                    } else {
                        var element = document.getElementById("upvote_icon_"+post_id);
                        element.classList.remove("text-shufflered");
                        $('#vote_count_' + post_id).text(data.voteNumber);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if (xhr.status == 401) {
                        window.location.href = '{{url("login")}}';
                    }
                }
            });
        };

        // function downVote(post_id){
        //     var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        //     var property = 'btn_downVote_'+post_id;
        //     console.log(property);
        //     $.ajax({
        //         type:'post',
        //         url: 'vote/downVote',
        //         data: {_token: CSRF_TOKEN , post_id: post_id},
        //         dataType: 'JSON',
        //         success: function (data) {
        //             console.log(data);
        //             if(data.status == 'downvoted'){
        //                 var property = document.getElementById('btn_upVote_'+post_id);
        //                 property.style.removeProperty('color');
        //                 var property = document.getElementById('btn_downVote_'+post_id);
        //                 property.style.color = "orangered"
        //                 $('#vote_count_'+post_id).text(data.voteNumber);
        //             } else{
        //                 var property = document.getElementById('btn_downVote_'+post_id);
        //                 property.style.removeProperty('color');
        //                 $('#vote_count_'+post_id).text(data.voteNumber);
        //             }
        //         }
        //     });
        // };

        function saveStory(post_id) {
            var user_id = $('#save_story_user_id').val();
            $('#save_story_post_id').val(post_id);
            console.log(user_id);
            if (user_id == '') {
                window.location.href = '{{url("login")}}';
            } else {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                console.log(post_id);
                $.ajax({
                    type: 'post',
                    url: '{{url("saveStory")}}',
                    data: {_token: CSRF_TOKEN, post_id: post_id, user_id: user_id},
                    dataType: 'JSON',
                    success: function (data) {
                        console.log(data);
                        if (data.status == 'showModal') {
                            $('#saveStoryModal').modal('show');
                        } else {
                            var property = document.getElementById('btn_saveStory_' + post_id);
                            property.style.removeProperty('color');
                        }
                    }
                });

            }
        };

        function saveStoryData() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var user_id = $('#save_story_user_id').val();
            var post_id = $('#save_story_post_id').val();
            var folder_id = $('#save_story_folder_id option:selected').val();
            console.log(folder_id);
            $.ajax({
                type: 'post',
                url: '{{url("saveStory")}}',
                data: {_token: CSRF_TOKEN, post_id: post_id, user_id: user_id, folder_id: folder_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if (data.status == 'saved') {
                        var property = document.getElementById('btn_saveStory_' + post_id);
                        property.style.color = "green";
                        $('#saveStoryModal').modal('hide');
                    } else {
                        var property = document.getElementById('btn_saveStory_' + post_id);
                        property.style.removeProperty('color');
                    }
                }
            });
        };

    </script>
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <script>

        function shuffleNewStory() {
            document.getElementById('wait').style.display = "block";
            $("#shuffle_box").load(location.href + " #shuffle_box");
            document.getElementById('wait').style.display = "none";
        };

    </script>


        <script type="application/ld+json">
        {
          "@context": "http://schema.org",
          "@type": "WebSite",
          "url": "http://www.shufflehex.com/",
          "name": "ShuffleHex.com | Content Discovery Platform",
          "description": "ShuffleHex is a next generation content discovery platform that pushed recommends of web content to it's users. Users can also save anything from anywhere.",
          "publisher": "ShuffleHex",
          "image": "{{ $imageLink }}",
          "potentialAction": {
            "@type": "SearchAction",
            "target": "{{ $searchUrl }}",
            "query-input": "required name=search" }
            }
        </script>

@endsection
