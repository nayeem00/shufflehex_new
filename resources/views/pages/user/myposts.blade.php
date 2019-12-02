@extends('layouts.profileMaster')

@section('css')

    <style>
        .dropdown-menu{
            right: unset;
        }

        .dropdown-menu li{
            text-align: left;
            border-bottom: 1px;
        }
    </style>
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
            <div class="user-post-item user-post-item{{ $post->id }}">
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
                            <li class="edit-post" data-id="{{ $post->id }}"><a><i class="fa fa-pencil" style="color: #4B77BE"></i>&nbsp;Edit</a></li>
                            <li class="delete-post" data-id="{{ $post->id }}"><a><i class="fa fa-trash" style="color: #EF4836"></i>&nbsp;Delete</a></li>
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

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        $(document).ready(function () {
            $('.delete-post').click(function () {
                let id = $(this).data('id');
                swal.fire({
                        html: "The Post will deleted permanently",
                        title: "Are you sure?",
                        showCancelButton: true,
                        confirmButtonColor: '#EF4836',
                        confirmButtonClass: 'btn-danger',
                        confirmButtonText: 'Delete',
                        cancelButtonText: 'Cancel',
                        closeOnConfirm: true,
                        closeOnCancel: true,
                        allowOutsideClick: true,
                        allowEscapeKey: true
                }).then(function(result){
                    if (result.value) {
                        if(deletePost(id)){
                            Swal.fire(
                                'Deleted!',
                                'Your Post has been deleted.',
                                'success'
                            )
                        }else{
                            Swal.fire(
                                'Error!',
                                'Error Deleting Post.',
                                'error'
                            )
                        }

                    }
                 });
            })

        });

        function deletePost(id) {
            var getUrl = window.location;
            var baseUrl = getUrl .protocol + "//" + getUrl.host + "/";
            if(getUrl.host == 'localhost'){
                baseUrl = getUrl .protocol + "//" + 'localhost/shufflehex/public/'
            }
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            returnData = false;
            $.ajax({
                url:baseUrl+"ajax/delete_user_posts",
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    id : id
                },
                dataType: 'json',
                cache: false,
                async:false
            })
                .done(function(response) {
                    if(response.result){
                        returnData = true;
                        $('.user-post-item'+id).slideUp('slow');
                        }
                })
                .fail(function(response) {
                    returnData = false;
                });
            return returnData;
        }
    </script>
@endsection