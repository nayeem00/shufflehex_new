@extends('layouts.profileMaster')
@section('css')

@endsection
@section('content')
    <div id="body-content" style="max-width:800px;padding:10px 15px;margin: auto">
        <ul class="nav nav-pills pull-right">
            <li class="">
                <a data-toggle="modal" data-target="#saveNewListModal"><span>Save New Story</span></a>
            </li>
            <li>
                <a class="" data-toggle="modal" data-target="#createNewFolderModal">
                    <span>Create New Folder</span>
                </a>
            </li>
        </ul>
        <div class="saved-box">
            <div class="row box-header">
                <div class="col-md-12">
                    <h3 style="margin-bottom: 5px">Saved Stories</h3>
                </div>
            </div>
            @foreach($folders as $folder)
                <div class="folder-item">
                    <div class="row">
                        <div class="col-md-8 col-xs-9">
                            <div class="folder-title">
                                <a href="{{ url('/folder/'.$folder->id) }} "
                                         id="btn_folderName_{{ $folder->id }}"><i class="fa fa-folder"></i>&nbsp;{{ $folder->folder_name }}</a>
                            </div>

                        </div>
                        <div class="col-md-4 col-xs-3 folder-action pl-38">
                            <div class="pull-right">
                                <a class="btn btn-sm mr-5" onclick="deleteFolder({{ $folder->id }})"><i
                                            class="fa fa-trash"></i></a>
                                <a class="btn btn-sm " data-toggle="modal" data-target="#editFolderModal"
                                   onclick="renameFolder({{ $folder->id }})"><i class="fa fa-pencil"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach


            {{--<div class="container-fluid">--}}
            {{--<div class="saved-stories">--}}
            {{--@foreach($savedPosts as $savedStory)--}}
            {{--<div class="saved-story-item">--}}
            {{--<div class="saved-img pull-left">--}}
            {{--<a href="#"><img class="" src="{{ $savedStory->featured_image }}"></a>--}}
            {{--</div>--}}
            {{--<div>--}}
            {{--<h4>{{ $savedStory->title }}</h4>--}}
            {{--<div class="row">--}}
            {{--<!-- Go to www.addthis.com/dashboard to customize your tools -->--}}
            {{--<div class="addthis_inline_share_toolbox saved_items_share_buttons col-md-10" style="margin-left: 13%;width: 70%;"></div>--}}
            {{--<div class="col-md-2">--}}
            {{--<a href="#" class="pull-right">--}}
            {{--{!! Form::open(array('method'=>'DELETE', 'route'=>array('saveStory.destroy',$savedStory->id)))!!}--}}
            {{--{!! Form::submit('Delete', array('class'=>'btn btn-xs btn-danger','onclick' => 'return confirm("Are you sure want to Delete?");'))!!}--}}
            {{--{!! Form::close()!!}--}}
            {{--</a>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<button class="btn btn-xs btn-default"><i class="fa fa-facebook"></i></button>--}}
            {{--<button class="btn btn-xs btn-default"><i class="fa fa-twitter"></i></button>--}}
            {{--<button class="btn btn-xs btn-default"><i class="fa fa-google-plus"></i></button>--}}

            {{--</div>--}}

            {{--</div>--}}
            {{--@endforeach--}}
            {{--</div>--}}
            {{--</div>--}}

        </div>
    </div>



    <!-- save url modal -->
    <div class="save-page-modal modal fade" id="saveNewListModal" role="dialog">
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
                            <input type="url" name="link" class="form-control" placeholder="Paste URL">
                        </div>
                        <div class="form-group">
                            <select class="selectpicker" data-live-search="true" name="folder_id">
                                @foreach($folders as $folder)
                                    <option value="{{ $folder->id }}"
                                            data-tokens="{{ $folder->folder_name }}">{{ $folder->folder_name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <div class="form-group">
                            <input type="submit" class="btn btn-block btn-danger" value="Save Story">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Create New folder modal -->
    <div class="save-page-modal modal fade" id="createNewFolderModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center"><i class="fa fa-folder"></i> Create New Folder</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('folder.store') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" class="form-control" name="folder_name" placeholder="Folder's Name">
                        </div>
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <div class="form-group">
                            <input type="submit" class="btn btn-block btn-danger" value="Create Folder">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Create New folder modal -->
    <div class="save-page-modal modal fade" id="editFolderModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center"><i class="fa fa-folder"></i> Enter New Name</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" id="updateRenameFolder">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input id="editFolderName" type="text" class="form-control" name="folder_name"
                                   placeholder="Folder's Name">
                        </div>
                        <input type="hidden" name="user_id" id="edit_user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="folder_id" id="edit_folder_id">
                        <div class="form-group">
                            <a class="btn btn-block btn-danger" onclick="updateRenameFolder()">Rename Folder</a>
                            {{--<input type="submit" class="btn btn-block btn-danger" value="Rename Folder">--}}
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


    <script>
        $(document).ready(function () {

//        $('.btn-delete-folder').on('click', function () {
//            $.confirm({
//                title: '',
//                content: '<h4 class="text-center">Are you sure?</h4>',
//                buttons: {
//                    confirm: function () {
//                        $.alert('Confirmed!');
//                    },
//                    cancel: function () {
//
//                    }
//                }
//            });
//        });

            $('.btn-deleteStory').on('click', function () {
                $.confirm({
                    title: '',
                    content: '<h4 class="text-center">Are you sure?</h4>',
                    buttons: {
                        confirm: function () {
                            $.alert('Confirmed!');
                        },
                        cancel: function () {

                        }
                    }
                });
            });
        });

        function renameFolder(folder_id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
//        var property = 'btn_deleteSaveStory_'+post_id;
            console.log(folder_id)
            $.ajax({
                url: ' folder/' + folder_id + '/edit',
                data: {_token: CSRF_TOKEN, folder_id: folder_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    $('#editFolderName').val(data.data.folder_name);
                    $('#edit_folder_id').val(data.data.id);
//                if(data.status == 'saved'){
//                    var property = document.getElementById('btn_saveStory_'+post_id);
//                    property.style.background = "yellowgreen";
//                } else{
//                    var property = document.getElementById('btn_saveStory_'+post_id);
//                    property.style.removeProperty('background');
//                }
                }
            });
        }

        function updateRenameFolder() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var folder_name = $('#editFolderName').val();
            var folder_id = $('#edit_folder_id').val();
            console.log(folder_id)
            url = 'updateFolder';
            $.ajax({
                url: url,
                data: {_token: CSRF_TOKEN, folder_id: folder_id, folder_name: folder_name},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if (data.status == 'updated') {
                        $('#btn_folderName_' + folder_id).text(data.data);
                        $('#editFolderModal').modal('toggle');
                    }
                }
            });
        }

        $('#updateRenameFolder').on('keyup keypress', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var folder_name = $('#editFolderName').val();
                var folder_id = $('#edit_folder_id').val();
                console.log(folder_id)
                url = 'updateFolder';
                $.ajax({
                    url: url,
                    data: {_token: CSRF_TOKEN, folder_id: folder_id, folder_name: folder_name},
                    dataType: 'JSON',
                    success: function (data) {
                        console.log(data);
                        if (data.status == 'updated') {
                            $('#btn_folderName_' + folder_id).text(data.data);
                            $('#editFolderModal').modal('hide');
                        }
                    }
                });
//            return false;
            }
        });

        function deleteFolder(folder_id) {
            console.log(folder_id);
            $.confirm({
                title: '',
                content: '<h4 class="text-center">Are you sure?</h4>',
                buttons: {
                    confirm: function () {
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
//        var property = 'btn_deleteSaveStory_'+post_id;
                        $.ajax({
                            url: 'deleteFolder',
                            data: {_token: CSRF_TOKEN, folder_id: folder_id},
                            dataType: 'JSON',
                            success: function (data) {
                                console.log(data);
                                $('#tr_folder_' + folder_id).remove();
//                            $('#editFolderName').val(data.data.folder_name);
//                            $('#edit_folder_id').val(data.data.id);
//                }
                            }
                        });
                    },
                    cancel: function () {

                    }
                }
            });
        }
    </script>
@endsection