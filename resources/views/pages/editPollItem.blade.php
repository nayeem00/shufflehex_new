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
                            <li role="presentation" class="active"><a data-toggle="pill" href="#addLink">Edit List/Poll Item</a></li>
                    </ul>

                </div>

            </div>

        </nav>


        <div class="tab-content w-100">
                <div id="createPoll" class="tab-pane fade active">

                    <div class="add-list">

                        <div class="createList">

                            <form id="addNewList" class="addLinksForm" action="{{ route('poll_item.update',$pollItem->id) }}" method="POST" enctype="multipart/form-data" role="form">

                                {{ method_field('PATCH') }}
                                {{ csrf_field() }}

                                <div class="form-group">

                                    <label for="storyTitle">Item Name</label>

                                    <input name="title" id="storyTitle" class="form-control" placeholder="Item Name"
                                           type="text" value="{{ $pollItem->title }}">

                                </div>

                                <div class="form-group">

                                    <label for="image">Image</label>

                                    <div class="input-group input-file" name="image">

			<span class="input-group-btn">

        		<button class="btn btn-default btn-choose" type="button">Choose</button>

    		</span>

                                        <input type="text" name="image" class="form-control"
                                               placeholder='Change image...'/>

                                        <span class="input-group-btn">

       			 <button class="btn btn-warning btn-reset" type="button">Reset</button>

    		</span>

                                    </div>

                                </div>

                                <div class="form-group">

                                    <label for="storyDesc">Description</label>

                                    <textarea type="text" name="description" id="storyDesc" rows="5"
                                              class="form-control summernote-review">{{ $pollItem->description }}</textarea>

                                </div>

                                <div class="form-group">

                                    <label>Tags</label>

                                    <input name="tags" id="tags" class="form-control" placeholder="tag1,tag2,tag3"
                                           type="text" value="{{ $pollItem->tags }}">

                                </div>

                                {{--<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">--}}

                                <button type="submit" name="storySubmit" id="storySubmit"
                                        class="btn-link-submit btn btn-block btn-danger">Update Item
                                </button>

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



