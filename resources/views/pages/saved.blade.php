<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Saved List</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="{{ asset('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    {{--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/main.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/style.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/list-style.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/saved-list.css') }}">

</head>
<body>

<div id="wrapper">
    @include('partials.top-bar')

<div class="container">
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
            {{--<li>--}}
                {{--<a class="" onclick="deleteFolder(1)">--}}
                    {{--<span>Delete</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<a class="" data-toggle="modal" data-target="#editFolderModal" onclick="renameFolder(1)"></i>    <span>Rename</span>--}}
                {{--</a>--}}
            {{--</li>--}}
        </ul>
        <div class="saved-box">
                <div class="row box-header">
                    <div class="col-md-12">
                        <h3>Saved Stories</h3>
                    </div>
                </div>
                @foreach($folders as $folder)
                <div class="folder-item">
                    <div class="row">
                        <div class="col-md-8 col-xs-9 folder-title">
                            <i class="fa fa-folder"></i>&nbsp;
                            <span><a href="{{ url('/folder/'.$folder->id) }} "  id="btn_folderName_{{ $folder->id }}">{{ $folder->folder_name }}</a></span>
                        </div>
                        <div class="col-md-4 col-xs-3 dis-hover dis-n pl-38">
                            <a class="btn btn-danger btn-sm mr-5" onclick="deleteFolder({{ $folder->id }})"><i class="fa fa-trash"></i></a>
                            <a class="btn btn-default btn-sm " data-toggle="modal" data-target="#editFolderModal" onclick="renameFolder({{ $folder->id }})"><i class="fa fa-pencil"></i></a>
                            {{--<a class="btn btn-default btn-xs btn-rename" id="btn_renameFolder_{{ $folder->id }}" onclick="renameFolder({{ $folder->id }})"><i class="fa fa-pencil"></i> Rename</a>--}}
                        </div>

                        <div class="col-md-4 col-xs-3 dis-show plr-0">
                            <a class="btn btn-danger btn-sm mr-5" onclick="deleteFolder({{ $folder->id }})"><i class="fa fa-trash"></i> </a>
                            <a class="btn btn-default btn-sm " data-toggle="modal" data-target="#editFolderModal" onclick="renameFolder({{ $folder->id }})"><i class="fa fa-pencil"></i></a>
                            {{--<a class="btn btn-default btn-xs btn-rename" id="btn_renameFolder_{{ $folder->id }}" onclick="renameFolder({{ $folder->id }})"><i class="fa fa-pencil"></i> Rename</a>--}}
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
                                <option value="{{ $folder->id }}" data-tokens="{{ $folder->folder_name }}">{{ $folder->folder_name }}</option>
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
                        <input id="editFolderName" type="text" class="form-control" name="folder_name" placeholder="Folder's Name">
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

<!-- jQuery CDN -->
<!--         <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Bootstrap Js CDN -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<!-- jQuery Nicescroll CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.6.8-fix/jquery.nicescroll.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>

<script src="js/home.js"></script>
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

    function renameFolder(folder_id){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
//        var property = 'btn_deleteSaveStory_'+post_id;
        console.log(folder_id)
        $.ajax({
            url: ' folder/'+folder_id+'/edit',
            data: {_token: CSRF_TOKEN , folder_id: folder_id},
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
    };

    function updateRenameFolder(){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var folder_name = $('#editFolderName').val();
        var folder_id = $('#edit_folder_id').val();
        console.log(folder_id)
        url = 'updateFolder';
        $.ajax({
            url: url,
            data: {_token: CSRF_TOKEN , folder_id: folder_id , folder_name: folder_name},
            dataType: 'JSON',
            success: function (data) {
                console.log(data);
                if(data.status=='updated'){
                    $('#btn_folderName_'+folder_id).text(data.data);
                    $('#editFolderModal').modal('toggle');
                }
            }
        });
    };
    $('#updateRenameFolder').on('keyup keypress', function(e) {
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
                data: {_token: CSRF_TOKEN , folder_id: folder_id , folder_name: folder_name},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if(data.status=='updated'){
                        $('#btn_folderName_'+folder_id).text(data.data);
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
                        data: {_token: CSRF_TOKEN , folder_id: folder_id},
                        dataType: 'JSON',
                        success: function (data) {
                            console.log(data);
                            $('#tr_folder_'+folder_id).remove();
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
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5a64cb7833dd1d0d"></script>
</body>
</html>
