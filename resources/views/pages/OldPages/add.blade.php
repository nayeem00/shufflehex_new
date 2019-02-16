
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shuffle Case</title>

    <link rel="stylesheet/less" type="text/css" href="{{ asset('shufflehex/less/addstory.less') }}">
    @include('partials.assets')
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>

    <style>
        #addNewStory .bootstrap-select{
            width: 100% !important;
        }
        .note-editable{
            min-height: 200px !important;
            width: 100%;
        }
        .note-editor{
            width: 100%;
            text-align: left;
        }
        .btn-codeview{
            display: none;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('#artcleBox').summernote();
        });
    </script>
</head>
<body>
<div id="wrapper">
    @include('partials.topbar')
    <div id="content-body" class="">
        <div class="container">
            <div class="add-story-pills text-center">
                <ul  class="nav nav-pills" style="display: inline-block">
                    <li class="active">
                        <a  href="#linkPane" data-toggle="tab">Add Link</a>
                    </li>
                    <li>
                        <a href="#imagePane" data-toggle="tab">Upload Image</a>
                    </li>
                    <li>
                        <a href="#videoPane" data-toggle="tab">Add Video</a>
                    </li>

                    <li>
                        <a href="#articlePane" data-toggle="tab">Write Article</a>
                    </li>
                    <li>
                        <a href="#listPane" data-toggle="tab">Create List</a>
                    </li>
                    <li>
                        <a href="#pollPane" data-toggle="tab">Create Poll</a>
                    </li>

                </ul>
            </div>
        </div>
        <div id="storyForm" class="container">
            <div class="tab-content clearfix">
                <div id="linkPane" class="tab-pane active">
                    <form id="addNewStory" class="addLinksForm" action="{{ route('post.store') }}" method="POST" role="form">
                        {{ csrf_field() }}
                        <label for="storyTitle">Title</label>
                        <div class="form-group">
                            <input type="text" name="title" id="storyTitle" class="form-control" placeholder="Title">
                        </div>
                        <label for="storyLink">Link</label>
                        <div class="form-group">
                            <input type="text" name="link" id="storyLink" class="form-control" placeholder="Link">
                        </div>
                        <label for="storyCategory">Category</label>
                        <div class="form-group">

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
                            <textarea type="text" name="description" id="storyDesc" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Tags</label>
                            <input type="text" name="tags" id="tags" class="form-control" placeholder="tag1,tag2,tag3">
                        </div>
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <button type="submit" name="storySubmit" id="storySubmit" class="btn-link-submit btn btn-block btn-danger">Submit</button>

                    </form>
                </div>
                <div id="imagePane" class="tab-pane">
                    <form id="addImageStory" class="addLinksForm" action="{{ route('image.store') }}" method="POST"
                          enctype="multipart/form-data" role="form">
                        {{ csrf_field() }}
                        <label for="storyTitle">Title</label>
                        <div class="form-group">
                            <input type="text" name="title" id="storyTitle" class="form-control" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <label>Upload Image</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        Browse… <input type="file" id="imgInp" name="img">
                                    </span>
                                </span>
                                <input type="text" class="form-control" readonly>
                            </div>
                            <img id='img-upload'/>
                        </div>
                        <label for="storyCategory">Category</label>
                        <div class="form-group">

                            <select name="category" id="storyCategory" class="pull-left selectpicker" data-live-search="true"
                                    style="margin-bottom: 15px;">
                                {{--<option>-------</option>--}}
                                @foreach($categories as $category)
                                    <option value="{{ $category->category }}" data-tokens="{{ $category->category }}">{{ $category->category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="storyDesc">Description</label>
                        <div class="form-group">
                            <textarea type="text" name="description" id="storyDesc" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Tags</label>
                            <input type="text" name="tags" id="tags" class="form-control" placeholder="a,ab,abc">
                        </div>
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <button type="submit" name="storySubmit" id="storySubmit" class="btn-link-submit btn btn-block btn-danger">Submit</button>

                    </form>
                </div>
                <div id="videoPane" class="tab-pane">
                    <form id="addVideoStory" class="addLinksForm" action="{{ route('video.store') }}" method="POST" role="form">
                        {{ csrf_field() }}
                        <label for="storyTitle">Title</label>
                        <div class="form-group">
                            <input type="text" name="title" id="storyTitle" class="form-control" placeholder="Title">
                        </div>
                        <label for="storyLink">Link</label>
                        <div class="form-group">
                            <input type="text" name="link" id="storyLink" class="form-control" placeholder="Link">
                        </div>
                        <label for="storyCategory">Category</label>
                        <div class="form-group">

                            <select name="category" id="storyCategory" class="pull-left selectpicker" data-live-search="true"
                                    style="margin-bottom: 15px;">
                                {{--<option>-------</option>--}}
                                @foreach($categories as $category)
                                    <option value="{{ $category->category }}" data-tokens="{{ $category->category }}">{{ $category->category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="storyDesc">Description</label>
                        <div class="form-group">
                            <textarea type="text" name="description" id="storyDesc" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Tags</label>
                            <input type="text" name="tags" id="tags" class="form-control" placeholder="a,ab,abc">
                        </div>
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <button type="submit" name="storySubmit" id="storySubmit" class="btn-link-submit btn btn-block btn-danger">Submit</button>

                    </form>
                </div>
                <div id="articlePane" class="tab-pane">
                    <form id="addNewArticle" class="addLinksForm" action="{{ route('article.store') }}" method="POST" role="form">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="storyTitle">Title</label>
                            <input type="text" name="title" id="storyTitle" class="form-control" placeholder="Title">
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
                            <label>Tags</label>
                            <input type="text" name="tags" id="tags" class="form-control" placeholder="a,ab,abc">
                        </div>
                        <div class="form-group">

                            <label for="storyDesc">Description</label>
                            <textarea name="description" id="artcleBox" rows="5"></textarea>
                            {{--<textarea name="area1" cols="200" id="articleBox" class="form-control" style="width: 100%;">--}}
       {{--Some Initial Content was in this textarea--}}
{{--</textarea>--}}
                        </div>

                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <button type="submit" name="storySubmit" id="storySubmit" class="btn-link-submit btn btn-block btn-danger">Submit</button>

                    </form>
                </div>
                <div id="listPane" class="tab-pane">
                    <h1>List Pane</h1>
                </div>
                <div id="pollPane" class="tab-pane">
                    <h1>Poll Pane</h1>
                </div>

            </div>

        </div>
    </div>
    <footer id="footer" class=" text-center bg-success" >
        <p class="text-center">&copy; 2017</p>
    </footer>
</div>
@include('partials.sidebar')
<script>
    $('.selectpicker').selectpicker();

</script>
{{--<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>--}}
{{--<script type="text/javascript">--}}
    {{--new nicEditor().panelInstance('articleBox');--}}
{{--</script>--}}
<script>
    $(document).ready( function() {
        $(document).on('change', '.btn-file :file', function() {
            var input = $(this),
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [label]);
        });

        $('.btn-file :file').on('fileselect', function(event, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = label;

            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }

        });
//        function readURL(input) {
//            if (input.files && input.files[0]) {
//                var reader = new FileReader();
//
//                reader.onload = function (e) {
//                    $('#img-upload').attr('src', e.target.result);
//                }
//
//                reader.readAsDataURL(input.files[0]);
//            }
//        }

        $("#imgInp").change(function(){
            readURL(this);
        });
    });
</script>
</body>
</html>