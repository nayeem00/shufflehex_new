@extends('layouts.master')

@section('css')


    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/add.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/poll.css') }}">
    <style>
        .item-form{
            margin-top: 20px;
        }
        #addItemForm .btn-add-more{
            margin: 15px auto;
        }
    </style>
@endsection
@section('content')

    {{----------------------------- store current url to session -----------------------}}
    <?php session(['last_page' => url()->current()]); ?>
    {{-------------------------------------------------------------------------------------}}

    <div class="box poll-details">
        <div class="box-header">
            <h3>{{ $post->title }}</h3>
        </div>
        <div class="plr-20">
            <img class="img-responsive" src="{{ url($post->featured_image) }}">
        </div>

        <div class="poll-content">
            <p> {!! $post->description !!}  </p>
        </div>


        <div id="addItemBlock" style="padding: 10px 20px;">
            <form id="addItemForm" class="addLinksForm" action="{{ route('poll_item.store') }}" method="POST" enctype="multipart/form-data" role="form">
                {{ csrf_field() }}
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <div id="item_form_element"></div>
                <div class="form-group">
                    <a class="btn btn-add-more btn-block btn-default" onclick="AddListItemForm(event)"><i class="fa fa-plus-circle"></i> Add Item </a>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-publish btn-danger btn-block hidden" value="Publish">
                </div>
            </form>

        </div>
        <?php $count = 0;
        //        print_r($post->poll_items->poll_votes);
        //        die();
        ?>
        @foreach($post->poll_items as $item)
            <?php
            $upVoteMatched = 0;
            $downVoteMatched = 0;
            ?>
            @if(isset($item->poll_item_vote->vote) && !empty($item->poll_item_vote->vote) && $item->poll_item_vote->vote== 1)
                <?php
                $upVoteMatched = 1;
                ?>
            @elseif(isset($item->poll_item_vote->vote) && !empty($item->poll_item_vote->vote) && $item->poll_item_vote->vote== -1)
                <?php
                $downVoteMatched = 1;
                ?>

            @endif
            <?php $count++;
            ?>
            <div class="row poll">
                <div class="col-md-1 poll-votes">
                    <div class="button">
                        @if($upVoteMatched == 1)
                            <a class="btn btn-xs btn-default" onclick="upVote({{
                                $item->id
                                }})"><span  id="btn_upVote_{{ $item->id }}" class=".thumb-up glyphicon glyphicon-triangle-top" style="color: green"></span><span class="vote-counter text-center" id="upvote_count_{{ $item->id }}">{{ $item->upvotes }}</span> </a>
                        @else
                            <a class="btn btn-xs btn-default" onclick="upVote({{
                                $item->id
                                }})"><span id="btn_upVote_{{ $item->id }}" class="thumb glyphicon glyphicon-triangle-top" ></span><span class="vote-counter text-center" id="upvote_count_{{ $item->id }}">{{ $item->upvotes }}</span> </a>
                        @endif
                    </div>
                    <div class="button">

                        @if($downVoteMatched == 1)
                            <a class="btn btn-xs btn-default" onclick="downVote({{
                                $item->id
                                }})"><span id="btn_downVote_{{ $item->id }}" class="thumb-down glyphicon glyphicon-triangle-bottom" style="color: orangered"><span class="vote-counter text-center" id="downvote_count_{{ $item->id }}">{{ $item->downvotes }}</span></span> </a>
                        @else
                            <a class="btn btn-xs btn-default " onclick="downVote({{
                                $item->id
                                }})"><span id="btn_downVote_{{ $item->id }}" class="thumb glyphicon glyphicon-triangle-bottom"></span><span class="vote-counter text-center" id="downvote_count_{{ $item->id }}">{{ $item->downvotes }}</span> </a>
                        @endif
                    </div>
                </div>
                <div class="col-md-11 media plr-0">
                    <div class="poll-title">
                        <h4>
                            <a href="{{ $item->link }}">{{ $item->title }}</a>
                        </h4>
                    </div>
                    <div class="img-responsive">
                        <img src="{{ url($item->featured_image) }}" >
                    </div>
                    <div class="poll-desc">
                        <p>{{ $item->description }}</p>
                    </div>
                </div>
            </div>

        @endforeach
    </div>


    <div class="save-page-modal modal fade" id="addPollItemModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center"><i class="fa fa-plus-circle"></i> Save New Story</h4>
                </div>
                <div class="modal-body">
                    <form id="addNewList" class="addLinksForm" action="{{ route('poll_item.store') }}" method="POST" enctype="multipart/form-data" role="form">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="storyTitle">Title</label>
                            <input name="title" id="storyTitle" class="form-control" placeholder="Title" type="text">
                        </div>
                        <div class="form-group">
                            <label for="storyLink">Link</label>
                            <input name="link" id="storyLink" class="form-control" placeholder="Link" type="text">
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <div class="input-group input-file" name="img">
			<span class="input-group-btn">
        		<button class="btn btn-default btn-choose" type="button">Choose</button>
    		</span>
                                <input type="text" name="img" class="form-control" placeholder='Choose a file...' multiple/>
                                <span class="input-group-btn">
       			 <button class="btn btn-warning btn-reset" type="button">Reset</button>
    		</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="storyDesc">Description</label>
                            <textarea type="text" name="description" id="storyDesc" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Tags</label>
                            <input name="tags" id="tags" class="form-control" placeholder="tag1,tag2,tag3" type="text">
                        </div>
                        {{--<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">--}}
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <button type="submit" name="storySubmit" id="storySubmit" class="btn-link-submit btn btn-block btn-danger">Add Item</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
{{--<div class="overlay"></div>--}}
{{--</div>--}}

@section('js')
    <!-- jQuery CDN -->
    <!--         <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Bootstrap Js CDN -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

    <!-- jQuery Nicescroll CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.6.8-fix/jquery.nicescroll.min.js"></script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5a64cb7833dd1d0d"></script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <script>
        $('.selectpicker').selectpicker();
    </script>
    <script>

        function bs_input_file() {

            $(".input-file").before(

                function() {

                    if ( ! $(this).prev().hasClass('input-ghost') ) {

                        var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");

                        element.attr("name",$(this).attr("name"));
                        console.log($(this).attr("name"));
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

    </script>


    <script>
        function upVote(poll_item_id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var property = 'btn_upVote_'+poll_item_id;
            console.log(CSRF_TOKEN);
            $.ajax({
                type:'post',
                url: '{{url("poll_vote")}}',
                data: {_token: CSRF_TOKEN , poll_item_id: poll_item_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if(data.status == 'upvoted'){
                        var property = document.getElementById('btn_downVote_'+poll_item_id);
                        property.style.removeProperty('color');
                        var property = document.getElementById('btn_upVote_'+poll_item_id);
                        property.style.color = "green";
                        $('#upvote_count_'+poll_item_id).text(data.upvote);
                        $('#downvote_count_'+poll_item_id).text(data.downvote);
                    } else{
                        var property = document.getElementById('btn_upVote_'+poll_item_id);
                        property.style.color = "";
                        $('#upvote_count_'+poll_item_id).text(data.upvote);
                        $('#downvote_count_'+poll_item_id).text(data.downvote);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if(xhr.status==401) {
                        window.location.href = '{{url("login")}}';
                    }
                }
            });
        };


        function downVote(poll_item_id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var property = 'btn_upVote_'+poll_item_id;
            console.log(CSRF_TOKEN);
            $.ajax({
                type:'post',
                url: '{{url("poll_downvote")}}',
                data: {_token: CSRF_TOKEN , poll_item_id: poll_item_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if(data.status == 'downvoted'){
                        var property = document.getElementById('btn_upVote_'+poll_item_id);
                        property.style.removeProperty('color');
                        var property = document.getElementById('btn_downVote_'+poll_item_id);
                        property.style.color = "orangered";
                        $('#upvote_count_'+poll_item_id).text(data.upvote);
                        $('#downvote_count_'+poll_item_id).text(data.downvote);
                    } else{
                        var property = document.getElementById('btn_downVote_'+poll_item_id);
                        property.style.color = "";
                        $('#upvote_count_'+poll_item_id).text(data.upvote);
                        $('#downvote_count_'+poll_item_id).text(data.downvote);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if(xhr.status==401) {
                        window.location.href = '{{url("login")}}';
                    }
                }
            });
        };
    </script>


    <script>
        $( document ).ready(function() {
            $("#latest_stories").attr("href", "{{ url('/post/latest/all') }}");
            $("#top_stories").attr("href", "{{ url('/post/top/all') }}");
            $("#popular_stories").attr("href", "{{ url('/post/popular/all') }}");
            $("#trending_stories").attr("href", "{{ url('/post/trending/all') }}");
        });
        // function upVote(post_id){
        //     var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        //     var property = 'btn_upVote_'+post_id;
        //     console.log(post_id);
        //     $.ajax({
        //         type:'post',
        //         url: 'vote',
        //         data: {_token: CSRF_TOKEN , post_id: post_id},
        //         dataType: 'JSON',
        //         success: function (data) {
        //             console.log(data);
        //             if(data.status == 'upvoted'){
        //                 var property = document.getElementById('btn_downVote_'+post_id);
        //                 property.style.removeProperty('color');
        //                 var property = document.getElementById('btn_upVote_'+post_id);
        //                 property.style.color = "green"
        //                 $('#vote_count_'+post_id).text(data.voteNumber);
        //             } else{
        //                 var property = document.getElementById('btn_upVote_'+post_id);
        //                 property.style.removeProperty('color');
        //                 $('#vote_count_'+post_id).text(data.voteNumber);
        //             }
        //         }
        //     });
        // };

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

        function saveStory(post_id){
            var user_id = $('#save_story_user_id').val();
            $('#save_story_post_id').val(post_id);
            console.log(user_id);
            if(user_id==''){
                alert('You are not logged in!');
            }else {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                console.log(post_id);
                $.ajax({
                    type:'post',
                    url: '{{url("saveStory")}}',
                    data: {_token: CSRF_TOKEN , post_id: post_id, user_id: user_id},
                    dataType: 'JSON',
                    success: function (data) {
                        console.log(data);
                        if(data.status == 'showModal'){
                            $('#saveStoryModal').modal('show');
                        } else{
                            var property = document.getElementById('btn_saveStory_'+post_id);
                            property.style.removeProperty('background');
                        }
                    }
                });

            }
        };

        function saveStoryData(){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var user_id = $('#save_story_user_id').val();
            var post_id = $('#save_story_post_id').val();
            var folder_id = $('#save_story_folder_id option:selected').val();
            console.log(folder_id);
            $.ajax({
                type:'post',
                url: '{{url("saveStory")}}',
                data: {_token: CSRF_TOKEN , post_id: post_id, user_id: user_id, folder_id: folder_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if(data.status == 'saved'){
                        var property = document.getElementById('btn_saveStory_'+post_id);
                        property.style.background = "yellowgreen";
                        $('#saveStoryModal').modal('hide');
                    } else{
                        var property = document.getElementById('btn_saveStory_'+post_id);
                        property.style.removeProperty('background');
                    }
                }
            });
        };

    </script>
    <script>

        var itemNumber = 0;
        function AddListItemForm(event) {
            let action = '{{ route('poll_item.store') }}/';
            let post_id = '';
            $('.btn.btn-publish').removeClass('hidden');
            event.preventDefault();
            $('#item_form_element').append('<div class="item-form"><div class="form-group">' +
                '<label for="ItemName">Item Name</label>' +
                '<input name="name[]" id="ItemName" class="form-control" placeholder="Item Name" type="text">' +
                '</div>' +
                '<div class="form-group">' +
                '<label for="image">Image</label>' +
                '<div class="input-group input-file" name="images[]">' +
                '<span class="input-group-btn">' +
                '<button class="btn btn-default btn-choose" type="button" onclick="bs_input_file()">Choose</button>' +
                '</span>' +
                '<input type="text" name="images[]" class="form-control" placeholder="Choose a file..." />' +
                '<span class="input-group-btn">' +
                '<button class="btn btn-warning btn-reset" type="button">Reset</button>' +
                '</span>' +
                '</div>' +
                '</div>' +
                '<div class="form-group">' +
                '<label for="storyDesc">Description</label>' +
                ' <textarea type="text" name="description[]" id="storyDesc" rows="5" class="form-control"></textarea>' +
                '</div></div>');
            itemNumber++;
            $(function() {

                bs_input_file();

            });

        }
    </script>
@endsection

