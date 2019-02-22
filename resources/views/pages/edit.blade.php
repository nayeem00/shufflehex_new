@extends('layouts.addMaster')
@section('css')
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/list-style.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/add.css') }}">
@endsection

@section('content')

    <div class="box saved-stories m-auto" style="max-width: 920px">

        <nav class="navbar navbar-default">

            <div class="profile-sidebar-nav">

                <div class="navbar-header">

                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#add"
                            aria-expanded="false">

                        <span class="sr-only">Toggle navigation</span>

                        <span class="icon-bar"></span>

                        <span class="icon-bar"></span>

                        <span class="icon-bar"></span>

                    </button>

                </div>


                <div class="collapse navbar-collapse tab-bar" id="add">

                    <ul class="nav nav-pills">
                        @if($post->is_link == 1)
                        <li role="presentation" class="active"><a data-toggle="pill" href="#addLink">Edit Link</a></li>
                        @endif
                        @if($post->is_article == 1)
                        <li role="presentation" class="active"><a data-toggle="pill" href="#writeArticle">Edit Article</a></li>
                        @endif
                         @if($post->is_image == 1)
                        <li role="presentation" class="active"><a data-toggle="pill" href="#uploadImage">Edit Image Info</a></li>
                        @endif
                        @if($post->is_video == 1)
                        <li role="presentation" class="active"><a data-toggle="pill" href="#submitVideo">Edit Video</a></li>
                        @endif
                         @if($post->is_list == 1)
                        <li role="presentation" class="active"><a data-toggle="pill" href="#createList">Edit List</a></li>
                        @endif
                        @if($post->is_poll == 1)
                        <li role="presentation" class="active"><a data-toggle="pill" href="#createPoll">Edit Poll</a></li>
                        @endif

                    </ul>

                </div>

            </div>

        </nav>


        <div class="tab-content w-100">
            @if($post->is_link == 1)
            <div id="addLink" class="tab-pane fadeIn w-100 active">

                <div class="add-link">

                    <form id="addNewStory" class="addLinksForm" action="{{ route('story.update',$post->id) }}" method="POST" role="form">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="storyLink">Link</label>
                            <div class="input-group">
                                <input name="link" id="storyLink" type="text" class="form-control" placeholder="Link" value="{{ $post->link }}">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" id="generate"><i
                                                class="fa fa-refresh"></i></button>
                                  </span>
                            </div><!-- /input-group -->
                        </div>

                        <div class="form-group">

                            <label for="storyTitle">Title</label>

                            <input name="title" id="storyTitle" class="form-control" placeholder="Title" type="text" value="{{ $post->title }}">

                        </div>

                        <div class="form-group">
                            <label for="search_category_link">Category</label>
                            <input type="text" name="category" id="search_category_link"
                                   class="form-control fontAwesome search_category"
                                   onclick="getCategory('link')" onkeyup="searchTopic('link')"
                                   placeholder="&#xf002;  Search Category" value="{{ $post->category }}">
                            <div id="get_category_link" class="w-100 get-category">
                                <div class="col-xs-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body p-0">
                                            <ul class="story-cat-list list-unstyled" id="category_list_link">
                                                @foreach($categories as $category)
                                                    <li class="li-cat" id="category__link_{{ $category->id }}"
                                                        onclick='setCategory("{{$category->category }}", "link")'>{{ $category->category }}</li>
                                                @endforeach
                                                <li class="li-cat li-create" id="create_topic_link"
                                                    onclick="createTopic('link')">
                                                    <a class="text-danger"> <i class="fa fa-plus"></i>&nbsp;Create
                                                        Topic</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="form-group">

                            <label for="storyDesc">Description</label>

                            <textarea type="text" name="description" id="storyDesc" rows="5"
                                      class="form-control summernote-full">{{ $post->description }}</textarea>

                        </div>

                        <div class="form-group">

                            <label>Tags</label>

                            <input name="tags" id="tags" class="form-control" placeholder="tag1,tag2,tag3" type="text" value="{{ $post->tags }}">

                        </div>

                        {{--<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">--}}

                        <button type="submit" name="storySubmit" id="storySubmit"
                                class="btn-link-submit btn btn-block btn-danger">Submit
                        </button>


                    </form>

                </div>

            </div>
            @endif
            @if($post->is_article == 1)
            <div id="writeArticle" class="tab-pane fade active">

                <div class="add-article">
                    <form id="addNewArticle" class="addLinksForm" action="{{ route('article.update',$post->id) }}" method="POST"  enctype="multipart/form-data" role="form">

                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}


                        <div class="form-group">

                            <label for="storyTitle">Title</label>

                            <input name="title" id="storyTitle" class="form-control" placeholder="Title" type="text" value="{{ $post->title }}">

                        </div>

                        <div class="form-group">

                            <label for="image">Feature Image</label>

                            <div class="input-group input-file" name="image">

			<span class="input-group-btn">

        		<button class="btn btn-default btn-choose" type="button">Choose</button>

    		</span>

                                <input type="text" name="image" class="form-control" placeholder='Choose a file...'/>

                                <span class="input-group-btn">

       			 <button class="btn btn-warning btn-reset" type="button">Reset</button>

    		</span>

                            </div>

                        </div>

                        <div class="form-group">
                            <label for="search_category_article">Category</label>
                            <input type="text" name="category" id="search_category_article"
                                   class="form-control fontAwesome search_category"
                                   onclick="getCategory('article')" onkeyup="searchTopic('article')"
                                   placeholder="&#xf002;  Search Category">
                            <div id="get_category_article" class="w-100 get-category">
                                <div class="col-xs-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body p-0">
                                            <ul class="story-cat-list list-unstyled" id="category_list_article">
                                                @foreach($categories as $category)
                                                    <li class="li-cat" id="category__article_{{ $category->id }}"
                                                        onclick='setCategory("{{$category->category }}", "article")'>{{ $category->category }}</li>
                                                @endforeach
                                                <li class="li-cat li-create" id="create_topic_article"
                                                    onclick="createTopic('article')">
                                                    <a class="text-danger"> <i class="fa fa-plus"></i>&nbsp;Create
                                                        Topic</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-group article-box">

                            <label>Write Article</label>

                            <textarea id="" name="description" class="summernote-full"></textarea>

                            {{--<textarea style="width:70%;height:200px;" name="area5" id="area5">Some Initial Content was in this textarea </textarea>--}}

                        </div>

                        <div class="form-group">

                            <label>Tags</label>

                            <input name="tags" id="tags" class="form-control" placeholder="tag1, tag2, tag3"
                                   type="text">

                        </div>


                        {{--<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">--}}

                        <button type="submit" name="storySubmit" id="storySubmit"
                                class="btn-link-submit btn btn-block btn-danger">Submit
                        </button>


                    </form>

                </div>

            </div>
             @endif
             @if($post->is_image == 1)
            <div id="uploadImage" class="tab-pane fade active">

                <form id="addImageStory" class="addLinksForm" action="{{ route('image.store') }}" method="POST"
                      enctype="multipart/form-data" role="form">

                    {{ csrf_field() }}

                    <label for="storyTitle">Title</label>

                    <div class="form-group">

                        <input name="title" id="storyTitle" class="form-control" placeholder="Title" type="text">

                    </div>

                    <div class="form-group">

                        <label for="image">Image</label>

                        <div class="input-group input-file" name="image">

			<span class="input-group-btn">

        		<button class="btn btn-default btn-choose" type="button">Choose</button>

    		</span>

                            <input type="text" name="image" class="form-control" placeholder='Choose a file...'/>

                            <span class="input-group-btn">

       			 <button class="btn btn-warning btn-reset" type="button">Reset</button>

    		</span>

                        </div>

                    </div>

                    <div class="form-group">
                        <label for="search_category_image">Category</label>
                        <input type="text" name="category" id="search_category_image"
                               class="form-control fontAwesome search_category"
                               onclick="getCategory('image')" onkeyup="searchTopic('image')"
                               placeholder="&#xf002;  Search Category">
                        <div id="get_category_image" class="w-100 get-category">
                            <div class="col-xs-12">
                                <div class="panel panel-default">
                                    <div class="panel-body p-0">
                                        <ul class="story-cat-list list-unstyled" id="category_list_image">
                                            @foreach($categories as $category)
                                                <li class="li-cat" id="category__image_{{ $category->id }}"
                                                    onclick='setCategory("{{$category->category }}", "image")'>{{ $category->category }}</li>
                                            @endforeach
                                            <li class="li-cat li-create" id="create_topic_image"
                                                onclick="createTopic('image')">
                                                <a class="text-danger"> <i class="fa fa-plus"></i>&nbsp;Create
                                                    Topic</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">

                        <label for="storyDesc">Description</label>

                        <textarea type="text" name="description" id="storyDesc" rows="5"
                                  class="form-control summernote-full"></textarea>

                    </div>

                    <div class="form-group">

                        <label>Tags</label>

                        <input name="tags" id="tags" class="form-control" placeholder="a,ab,abc" type="text">

                    </div>

                    {{--<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">--}}

                    <button type="submit" name="storySubmit" id="storySubmit"
                            class="btn-link-submit btn btn-block btn-danger">Submit
                    </button>


                </form>

            </div>
             @endif
             @if($post->is_video == 1)
            <div id="submitVideo" class="tab-pane fade active">

                <div class="add-video">

                    <form id="addNewVideo" class="addLinksForm" action="{{ route('video.store') }}" method="POST"
                          role="form">

                        {{ csrf_field() }}


                        <label for="storyLink">Youtube Video Link</label>

                        <div class="form-group">

                            <input name="link" id="storyLink" class="form-control" placeholder="Youtube Video Link"
                                   type="text">

                        </div>

                        <div class="form-group">

                            <label for="storyTitle">Title</label>

                            <input name="title" id="storyTitle" class="form-control" placeholder="Title" type="text">

                        </div>


                        <div class="form-group">
                            <label for="search_category_video">Category</label>
                            <input type="text" name="category" id="search_category_video"
                                   class="form-control fontAwesome search_category"
                                   onclick="getCategory('video')" onkeyup="searchTopic('video')"
                                   placeholder="&#xf002;  Search Category">
                            <div id="get_category_video" class="w-100 get-category">
                                <div class="col-xs-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body p-0">
                                            <ul class="story-cat-list list-unstyled" id="category_list_video">
                                                @foreach($categories as $category)
                                                    <li class="li-cat" id="category__video_{{ $category->id }}"
                                                        onclick='setCategory("{{$category->category }}", "video")'>{{ $category->category }}</li>
                                                @endforeach
                                                <li class="li-cat li-create" id="create_topic_video"
                                                    onclick="createTopic('video')">
                                                    <a class="text-danger"> <i class="fa fa-plus"></i>&nbsp;Create
                                                        Topic</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="form-group">

                            <label for="storyDesc">Description</label>

                            <textarea type="text" name="description" id="storyDesc" rows="5"
                                      class="form-control summernote-full"></textarea>

                        </div>

                        <div class="form-group">

                            <label>Tags</label>

                            <input name="tags" id="tags" class="form-control" placeholder="tag1,tag2,tag3" type="text">

                        </div>

                        {{--<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">--}}

                        <button type="submit" name="storySubmit" id="storySubmit"
                                class="btn-link-submit btn btn-block btn-danger">Submit
                        </button>


                    </form>

                </div>

            </div>
             @endif
             @if($post->is_list == 1)
            <div id="createList" class="tab-pane fade active">

                <div class="add-list">

                    <div class="createList">

                        <form id="addNewList" class="addLinksForm" action="{{ route('list.store') }}" method="POST"
                              enctype="multipart/form-data" role="form">

                            {{ csrf_field() }}

                            <div class="form-group">

                                <label for="storyTitle">Title</label>

                                <input name="title" id="storyTitle" class="form-control" placeholder="Title"
                                       type="text">

                            </div>

                            <div class="form-group">

                                <label for="image">Feature Image</label>

                                <div class="input-group input-file" name="image">

			<span class="input-group-btn">

        		<button class="btn btn-default btn-choose" type="button">Choose</button>

    		</span>

                                    <input type="text" name="image" class="form-control"
                                           placeholder='Choose a file...'/>

                                    <span class="input-group-btn">

       			 <button class="btn btn-warning btn-reset" type="button">Reset</button>

    		</span>

                                </div>

                            </div>

                            <div class="form-group">
                                <label for="search_category_list">Category</label>
                                <input type="text" name="category" id="search_category_list"
                                       class="form-control fontAwesome search_category"
                                       onclick="getCategory('list')" onkeyup="searchTopic('list')"
                                       placeholder="&#xf002;  Search Category">
                                <div id="get_category_list" class="w-100 get-category">
                                    <div class="col-xs-12">
                                        <div class="panel panel-default">
                                            <div class="panel-body p-0">
                                                <ul class="story-cat-list list-unstyled" id="category_list_list">
                                                    @foreach($categories as $category)
                                                        <li class="li-cat" id="category__list_{{ $category->id }}"
                                                            onclick='setCategory("{{$category->category }}", "list")'>{{ $category->category }}</li>
                                                    @endforeach
                                                    <li class="li-cat li-create" id="create_topic_list"
                                                        onclick="createTopic('list')">
                                                        <a class="text-danger"> <i class="fa fa-plus"></i>&nbsp;Create
                                                            Topic</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">

                                <label for="storyDesc">Description</label>

                                <textarea type="text" name="description" id="storyDesc" rows="5"
                                          class="form-control summernote-review"></textarea>

                            </div>

                            <div class="form-group">

                                <label>Tags</label>

                                <input name="tags" id="tags" class="form-control" placeholder="tag1,tag2,tag3"
                                       type="text">

                            </div>

                            {{--<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">--}}

                            <button type="submit" name="storySubmit" id="storySubmit"
                                    class="btn-link-submit btn btn-block btn-danger">Add List
                            </button>

                        </form>

                    </div>


                </div>

            </div>
             @endif
             @if($post->is_poll == 1)
            <div id="createPoll" class="tab-pane fade active">

                <div class="add-list">

                    <div class="createList">

                        <form id="addNewList" class="addLinksForm" action="{{ route('poll.store') }}" method="POST"
                              enctype="multipart/form-data" role="form">

                            {{ csrf_field() }}

                            <div class="form-group">

                                <label for="storyTitle">Title</label>

                                <input name="title" id="storyTitle" class="form-control" placeholder="Title"
                                       type="text">

                            </div>

                            <div class="form-group">

                                <label for="image">Feature Image</label>

                                <div class="input-group input-file" name="image">

			<span class="input-group-btn">

        		<button class="btn btn-default btn-choose" type="button">Choose</button>

    		</span>

                                    <input type="text" name="image" class="form-control"
                                           placeholder='Choose a file...'/>

                                    <span class="input-group-btn">

       			 <button class="btn btn-warning btn-reset" type="button">Reset</button>

    		</span>

                                </div>

                            </div>

                            <div class="form-group">
                                <label for="search_category_poll">Category</label>
                                <input type="text" name="category" id="search_category_poll"
                                       class="form-control fontAwesome search_category"
                                       onclick="getCategory('poll')" onkeyup="searchTopic('poll')"
                                       placeholder="&#xf002;  Search Category">
                                <div id="get_category_poll" class="w-100 get-category">
                                    <div class="col-xs-12">
                                        <div class="panel panel-default">
                                            <div class="panel-body p-0">
                                                <ul class="story-cat-list list-unstyled" id="category_list_poll">
                                                    @foreach($categories as $category)
                                                        <li class="li-cat" id="category__poll_{{ $category->id }}"
                                                            onclick='setCategory("{{$category->category }}", "poll")'>{{ $category->category }}</li>
                                                    @endforeach
                                                    <li class="li-cat li-create" id="create_topic_poll"
                                                        onclick="createTopic('poll')">
                                                        <a class="text-danger"> <i class="fa fa-plus"></i>&nbsp;Create
                                                            Topic</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">

                                <label for="storyDesc">Description</label>

                                <textarea type="text" name="description" id="storyDesc" rows="5"
                                          class="form-control summernote-review"></textarea>

                            </div>

                            <div class="form-group">

                                <label>Tags</label>

                                <input name="tags" id="tags" class="form-control" placeholder="tag1,tag2,tag3"
                                       type="text">

                            </div>

                            {{--<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">--}}

                            <button type="submit" name="storySubmit" id="storySubmit"
                                    class="btn-link-submit btn btn-block btn-danger">Add Poll
                            </button>

                        </form>

                    </div>


                </div>

            </div>
             @endif

        </div>

    </div>



@endsection

{{--<div class="overlay"></div>--}}

{{--</div>--}}



@section('js')
    <script>

        function bs_input_file() {

            $(".input-file").before(
                function () {

                    if (!$(this).prev().hasClass('input-ghost')) {

                        var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");

                        element.attr("name", $(this).attr("name"));

                        element.change(function () {

                            element.next(element).find('input').val((element.val()).split('\\').pop());

                        });

                        $(this).find("button.btn-choose").click(function () {

                            element.click();

                        });

                        $(this).find("button.btn-reset").click(function () {

                            element.val(null);

                            $(this).parents(".input-file").find('input').val('');

                        });

                        $(this).find('input').css("cursor", "pointer");

                        $(this).find('input').mousedown(function () {

                            $(this).parents('.input-file').prev().click();

                            return false;

                        });

                        return element;

                    }

                }
            );

        }

        $(function () {

            bs_input_file();

        });

    </script>
    <script>
        function getCategory(field_id) {
            // var story_type = field_id.split("_");
            $('#get_category_' + field_id).show();
            let category = $('#search_category_' + field_id).val();
            if (category === '') {
                $('#create_topic_' + field_id).hide();
            }
        }

        function searchTopic(field_id) {
            let category = $('#search_category_' + field_id).val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'post',
                url: '{{url("searchTopic")}}',
                data: {_token: CSRF_TOKEN, category: category},
                dataType: 'JSON',
                success: function (data) {
                    // console.log(data);
                    var categoryList = "";
                    if (data.status === "partially matched") {
                        var categories = data.categories;
                        // console.log(categories);
                        $.each(categories, function (index, value) {
                            categoryList += '<li class="li-cat" onclick="setCategory(\'' + value.category + '\',\'' + field_id + '\')">' + value.category + '</li>';
                        });
                        categoryList += '<li class="li-cat li-create" id="create_topic_' + field_id + '" onclick="createTopic(\'' + field_id + '\')"><a class="text-danger"> <i class="fa fa-plus"></i>&nbsp;Create Topic</a></li>';
                    } else if (data.status === "fully matched") {
                        var category = data.category;
                        categoryList += '<li class="li-cat" onclick="setCategory(\'' + category.category + ',' + field_id + '\')\">' + category.category + '</li>';
                        $('#create_topic_' + field_id).hide();
                    }
                    $('#category_list_' + field_id).html(categoryList);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if (xhr.status == 401) {
                        window.location.href = '{{url("login")}}';
                    }
                }
            });

        };

        function setCategory(category, field_id) {
            $('#search_category_' + field_id).val(category);
            $('#get-category').hide();
        }

        function createTopic(field_id) {
            // e.preventDefault();
            let category = $('#search_category_' + field_id).val();
            console.log(category);
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'post',
                url: '{{url("createTopic")}}',
                data: {_token: CSRF_TOKEN, category: category},
                dataType: 'JSON',
                success: function (data) {
                    if (data.status === 'Topic created') {
                        $('#get_category_' + field_id).hide();
                    }

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if (xhr.status == 401) {
                        window.location.href = '{{url("login")}}';
                    }
                }
            });

        };

        $(document).click(function (e) {
            if (!$(e.target).is(".search_category")) {
                $('.get-category').hide();
            }
        });

        $('#generate').on('click', function (e) {
            e.preventDefault();
            let link = $('#storyLink').val();
            // console.log(category);
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'post',
                url: '{{url("generate")}}',
                data: {_token: CSRF_TOKEN, link: link},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    $('#storyTitle').val(data.title);
                    // $('#storyDesc').summernote({
                    //     $('#storyDesc').val(data.description);
                    // });
                    $('#storyDesc').summernote('editor.insertText', data.description);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if (xhr.status == 401) {
                        window.location.href = '{{url("login")}}';
                    }
                }
            });

        });
    </script>

@endsection



