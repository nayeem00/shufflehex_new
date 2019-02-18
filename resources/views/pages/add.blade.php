@extends('layouts.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/list-style.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/add.css') }}">
@endsection

@section('content')

        <div class="box saved-stories">

            <nav class="navbar navbar-default">

                <div class="profile-sidebar-nav">

                    <div class="navbar-header">

                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#add" aria-expanded="false">

                        <span class="sr-only">Toggle navigation</span>

                        <span class="icon-bar"></span>

                        <span class="icon-bar"></span>

                        <span class="icon-bar"></span>

                    </button>

                    </div>





                    <div class="collapse navbar-collapse tab-bar" id="add">

                        <ul class="nav nav-pills" >

                            <li role="presentation" class="active"><a data-toggle="pill" href="#addLink">Add Link</a></li>

                            <li role="presentation"><a data-toggle="pill" href="#writeArticle">Write Article</a></li>

                            <li role="presentation"><a data-toggle="pill" href="#uploadImage">Upload Image</a></li>

                            <li role="presentation"><a data-toggle="pill" href="#submitVideo">Submit Video</a></li>

                            <li role="presentation"><a data-toggle="pill" href="#createList">Create List</a></li>

                            <li role="presentation"><a data-toggle="pill" href="#createPoll">Create Poll</a></li>

                        </ul>

                    </div>

                </div>

                </nav>


            <div class="tab-content w-100">

                <div id="addLink" class="tab-pane fadeIn w-100 active">

                    <div class="add-link">

                        <form id="addNewStory" class="addLinksForm" action="{{ route('story.store') }}" method="POST" role="form">

                            {{ csrf_field() }}


                            {{--<select id="ajax-select" class="selectpicker with-ajax" data-live-search="true"></select>--}}
                            {{--<label for="storyLink">Link</label>--}}

                            <div class="form-group">
                                <label for="storyLink">Link</label>
                                <input name="link" id="storyLink" class="form-control" placeholder="Link" type="text">

                            </div>

                            <div class="form-group">

                                <label for="storyTitle">Title</label>

                                <input name="title" id="storyTitle" class="form-control" placeholder="Title" type="text">

                            </div>

                            <div class="form-group">
                                <label for="searchCategory">Category</label>
                                <input type="text" id="searchCategory" value="a" class="form-control"
                                       onkeyup="getCategory(event)">
                                <div id="get-category" class="w-100">
                                    <div class="col-xs-12">
                                        <div class="panel panel-default">
                                            <div class="panel-body p-0">
                                                <ul class="story-cat-list list-unstyled">
                                                    @foreach($categories as $category)
                                                        <li class="li-cat">{{ $category->category }}</li>
                                                    @endforeach
                                                    <li class="li-cat li-create">
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

                                <label for="storyCategory">Category</label>

                                <select name="category" id="storyCategory" class="pull-left selectpicker" data-live-search="true"

                                        style="margin-bottom: 15px;">

                                    {{--<option>-------</option>--}}

                                    @foreach($categories as $category)

                                        <option value="{{ $category->category }}" data-tokens="{{ $category->category }}">{{ $category->category }}</option>

                                    @endforeach

                                </select>

                            </div>



                            <div class="form-group">

                                <label for="storyDesc">Description</label>

                                <textarea type="text" name="description" id="storyDesc" rows="5" class="form-control summernote-full"></textarea>

                            </div>

                            <div class="form-group">

                                <label>Tags</label>

                                <input name="tags" id="tags" class="form-control" placeholder="tag1,tag2,tag3" type="text">

                            </div>

                            {{--<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">--}}

                            <button type="submit" name="storySubmit" id="storySubmit" class="btn-link-submit btn btn-block btn-danger">Submit</button>



                        </form>

                    </div>

                </div>

                <div id="writeArticle" class="tab-pane fade">

                    <div class="add-article">

                        <form id="addNewArticle" class="addLinksForm" action="{{ route('article.store') }}" method="POST" enctype="multipart/form-data" role="form">

                            {{ csrf_field() }}



                            <div class="form-group">

                                <label for="storyTitle">Title</label>

                                <input name="title" id="storyTitle" class="form-control" placeholder="Title" type="text">

                            </div>

                            <div class="form-group">

                                <label for="image">Feature Image</label>

                                <div class="input-group input-file" name="image">

			<span class="input-group-btn">

        		<button class="btn btn-default btn-choose" type="button">Choose</button>

    		</span>

                                    <input type="text" name="image" class="form-control" placeholder='Choose a file...' />

                                    <span class="input-group-btn">

       			 <button class="btn btn-warning btn-reset" type="button">Reset</button>

    		</span>

                                </div>

                            </div>

                            <div class="form-group">

                                <label for="storyCategory">Category</label>

                                <select name="category" id="storyCategory" class="pull-left selectpicker" data-live-search="true" style="margin-bottom: 15px;" tabindex="-98">

                                    @foreach($categories as $category)

                                    <option value="{{ $category->category }}" data-tokens="{{ $category->category }}">{{ $category->category }}</option>

                                @endforeach

                                </select>

                            </div>

                            <div class="form-group article-box">

                                <label>Write Article</label>

                                <textarea id="" name="description" class="summernote-full"></textarea>

                                {{--<textarea style="width:70%;height:200px;" name="area5" id="area5">Some Initial Content was in this textarea </textarea>--}}

                            </div>

                            <div class="form-group">

                                <label>Tags</label>

                                <input name="tags" id="tags" class="form-control" placeholder="tag1, tag2, tag3" type="text">

                            </div>



                            {{--<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">--}}

                            <button type="submit" name="storySubmit" id="storySubmit" class="btn-link-submit btn btn-block btn-danger">Submit</button>



                        </form>

                    </div>

                </div>

                <div id="uploadImage" class="tab-pane fade">

                    <form id="addImageStory" class="addLinksForm" action="{{ route('image.store') }}" method="POST" enctype="multipart/form-data" role="form">

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

                                <input type="text" name="image" class="form-control" placeholder='Choose a file...' />

                                <span class="input-group-btn">

       			 <button class="btn btn-warning btn-reset" type="button">Reset</button>

    		</span>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="storyCategory">Category</label>

                            <select name="category" id="storyCategory" class="pull-left selectpicker" data-live-search="true" style="margin-bottom: 15px;" tabindex="-98">

                                @foreach($categories as $category)

                                    <option value="{{ $category->category }}" data-tokens="{{ $category->category }}">{{ $category->category }}</option>

                                @endforeach

                            </select>

                        </div>

                        <div class="form-group">

                            <label for="storyDesc">Description</label>

                            <textarea type="text" name="description" id="storyDesc" rows="5" class="form-control summernote-full"></textarea>

                        </div>

                        <div class="form-group">

                            <label>Tags</label>

                            <input name="tags" id="tags" class="form-control" placeholder="a,ab,abc" type="text">

                        </div>

                        {{--<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">--}}

                        <button type="submit" name="storySubmit" id="storySubmit" class="btn-link-submit btn btn-block btn-danger">Submit</button>



                    </form>

                </div>

                <div id="submitVideo" class="tab-pane fade">

                    <div class="add-video">

                        <form id="addNewVideo" class="addLinksForm" action="{{ route('video.store') }}" method="POST" role="form">

                            {{ csrf_field() }}



                            <label for="storyLink">Youtube Video Link</label>

                            <div class="form-group">

                                <input name="link" id="storyLink" class="form-control" placeholder="Youtube Video Link" type="text">

                            </div>

                            <div class="form-group">

                                <label for="storyTitle">Title</label>

                                <input name="title" id="storyTitle" class="form-control" placeholder="Title" type="text">

                            </div>



                            <div class="form-group">

                                <label for="storyCategory">Category</label>

                                <select name="category" id="storyCategory" class="pull-left selectpicker" data-live-search="true" style="margin-bottom: 15px;" tabindex="-98">

                                    @foreach($categories as $category)

                                    <option value="{{ $category->category }}" data-tokens="{{ $category->category }}">{{ $category->category }}</option>

                                @endforeach

                                </select>

                            </div>



                            <div class="form-group">

                                <label for="storyDesc">Description</label>

                                <textarea type="text" name="description" id="storyDesc" rows="5" class="form-control summernote-full"></textarea>

                            </div>

                            <div class="form-group">

                                <label>Tags</label>

                                <input name="tags" id="tags" class="form-control" placeholder="tag1,tag2,tag3" type="text">

                            </div>

                            {{--<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">--}}

                            <button type="submit" name="storySubmit" id="storySubmit" class="btn-link-submit btn btn-block btn-danger">Submit</button>



                        </form>

                    </div>

                </div>

                <div id="createList" class="tab-pane fade">

                    <div class="add-list">

                        <div class="createList">

                            <form id="addNewList" class="addLinksForm" action="{{ route('list.store') }}" method="POST" enctype="multipart/form-data" role="form">

                                {{ csrf_field() }}

                                <div class="form-group">

                                    <label for="storyTitle">Title</label>

                                    <input name="title" id="storyTitle" class="form-control" placeholder="Title" type="text">

                                </div>

                                <div class="form-group">

                                    <label for="image">Feature Image</label>

                                    <div class="input-group input-file" name="image">

			<span class="input-group-btn">

        		<button class="btn btn-default btn-choose" type="button">Choose</button>

    		</span>

                                        <input type="text" name="image" class="form-control" placeholder='Choose a file...' />

                                        <span class="input-group-btn">

       			 <button class="btn btn-warning btn-reset" type="button">Reset</button>

    		</span>

                                    </div>

                                </div>

                                <div class="form-group">

                                    <label for="storyCategory">Category</label>

                                    <select name="category" id="storyCategory" class="pull-left selectpicker" data-live-search="true" style="margin-bottom: 15px;" tabindex="-98">

                                        @foreach($categories as $category)

                                            <option value="{{ $category->category }}" data-tokens="{{ $category->category }}">{{ $category->category }}</option>

                                        @endforeach

                                    </select>

                                </div>

                                <div class="form-group">

                                    <label for="storyDesc">Description</label>

                                    <textarea type="text" name="description" id="storyDesc" rows="5" class="form-control summernote-review"></textarea>

                                </div>

                                <div class="form-group">

                                    <label>Tags</label>

                                    <input name="tags" id="tags" class="form-control" placeholder="tag1,tag2,tag3" type="text">

                                </div>

                                {{--<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">--}}

                                <button type="submit" name="storySubmit" id="storySubmit" class="btn-link-submit btn btn-block btn-danger">Add List</button>

                            </form>

                        </div>



                    </div>

                </div>

                <div id="createPoll" class="tab-pane fade">

                    <div class="add-list">

                        <div class="createList">

                            <form id="addNewList" class="addLinksForm" action="{{ route('poll.store') }}" method="POST" enctype="multipart/form-data" role="form">

                                {{ csrf_field() }}

                                <div class="form-group">

                                    <label for="storyTitle">Title</label>

                                    <input name="title" id="storyTitle" class="form-control" placeholder="Title" type="text">

                                </div>

                                <div class="form-group">

                                    <label for="image">Feature Image</label>

                                    <div class="input-group input-file" name="image">

			<span class="input-group-btn">

        		<button class="btn btn-default btn-choose" type="button">Choose</button>

    		</span>

                                        <input type="text" name="image" class="form-control" placeholder='Choose a file...' />

                                        <span class="input-group-btn">

       			 <button class="btn btn-warning btn-reset" type="button">Reset</button>

    		</span>

                                    </div>

                                </div>

                                <div class="form-group">

                                    <label for="storyCategory">Category</label>

                                    <select name="category" id="storyCategory" class="pull-left selectpicker" data-live-search="true" style="margin-bottom: 15px;" tabindex="-98">

                                        @foreach($categories as $category)

                                            <option value="{{ $category->category }}" data-tokens="{{ $category->category }}">{{ $category->category }}</option>

                                        @endforeach

                                    </select>

                                </div>

                                <div class="form-group">

                                    <label for="storyDesc">Description</label>

                                    <textarea type="text" name="description" id="storyDesc" rows="5" class="form-control summernote-review"></textarea>

                                </div>

                                <div class="form-group">

                                    <label>Tags</label>

                                    <input name="tags" id="tags" class="form-control" placeholder="tag1,tag2,tag3" type="text">

                                </div>

                                {{--<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">--}}

                                <button type="submit" name="storySubmit" id="storySubmit" class="btn-link-submit btn btn-block btn-danger">Add Poll</button>

                            </form>

                        </div>



                    </div>

                </div>

            </div>

        </div>



@endsection

    {{--<div class="overlay"></div>--}}

{{--</div>--}}



@section('js')
<script>

    function bs_input_file() {

        $(".input-file").before(

            function() {

                if ( ! $(this).prev().hasClass('input-ghost') ) {

                    var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");

                    element.attr("name",$(this).attr("name"));

                    element.change(function(){

                        element.next(element).find('input').val((element.val()).split('\\').pop());

                    });

                    $(this).find("button.btn-choose").click(function(){

                        element.click();

                    });

                    $(this).find("button.btn-reset").click(function(){

                        element.val(null);

                        $(this).parents(".input-file").find('input').val('');

                    });

                    $(this).find('input').css("cursor","pointer");

                    $(this).find('input').mousedown(function() {

                        $(this).parents('.input-file').prev().click();

                        return false;

                    });

                    return element;

                }

            }

        );

    }

    $(function() {

        bs_input_file();

    });

</script>
    <script>
        function getCategory(event) {
            event.preventDefault();
            let val = $('#searchCategory').val();
            console.log(val);
            if (val === "") {
                $('#get-category').hide();
            } else {
                $('#get-category').show();
            }
        }
    </script>

<!-- Include Editor style. -->



<!-- Include JS file. -->



@endsection



