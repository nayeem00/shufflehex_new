@extends('layouts.profileMaster')
@section('css')

@endsection
@section('content')
        <div class="row">
            <div class="col-sm-12">
                <div class="box folder-wise-story m-auto">
                    <div class="folder-header box-header">
                        <h3 class="folder-name"><i class="fa fa-folder"></i>&nbsp;{{ $folder->folder_name }}</h3>
                    </div>
                    <div class="folder-story">
                        @foreach($folderStories as $folderStory)

                            <div class="folder-item">
                                <div class="row">

                                    <?php
                                    $title = preg_replace('/\s+/', '-', $folderStory->title);
                                    $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
                                    ?>
                                        <div class="col-md-10 col-sm-10 col-xs-10">
                                            <div class="folder-img">
                                                <a href="{{ url('post/'.$folderStory->post_id.'/'.$title) }}" target="_blank"><img class="" src="{{ url($folderStory->story_list_image) }}"></a>
                                            </div>
                                            <div class="folder-content">
                                                <h4 class="story-title">
                                                    <a href="{{ url('story/'.$title) }}" target="_blank"> {{ $folderStory->title }}</a>
                                                </h4>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-2">
                                            <a href="#" class="btn-action">
                                                <span class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></span>


                                                {{--{!! Form::open(array('method'=>'DELETE', 'route'=>array('folderStory.destroy',$folderStory->saved_id)))!!}--}}
                                                {{--{!! Form::submit('Delete', array('class'=>'btn btn-xs btn-danger','onclick' => 'return confirm("Are you sure want to Delete?");'))!!}--}}
                                                {{--{!! Form::close()!!}--}}
                                            </a>
                                            <a href="#">
                                                <span class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></span>
                                            </a>
                                        </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>








@endsection
@section('js')

<!--<script src="js/home.js"></script>-->
<script>
    $(document).ready(function () {
        $('.btn-rename').on('click', function () {
            $.confirm({
                title: '',
                content: '' +
                    '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<label>Enter New Name</label>' +
                    '<input type="text" placeholder="Folder Name" class="name form-control" required />' +
                    '</div>' +
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Submit',
                        btnClass: 'btn-blue',
                        action: function () {
                            var name = this.$content.find('.name').val();
                            if (!name) {
                                $.alert('provide a valid name');
                                return false;
                            }
                            $.alert('Your name is ' + name);
                        }
                    },
                    cancel: function () {
                        //close
                    },
                },
                onContentReady: function () {
                    // you can bind to the form
                    var jc = this;
                    this.$content.find('form').on('submit', function (e) { // if the user submits the form by pressing enter in the field.
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    });
                }
            });
        });

        $('.btn-delete').on('click', function () {
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
    function deleteSavedStory(post_id,user_id){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var property = 'btn_deleteSaveStory_'+post_id;
        console.log(post_id);
        console.log(user_id);
        $.ajax({
            type:'post',
            url: 'saveStory/'.post_id,
            data: {_token: CSRF_TOKEN , post_id: post_id, user_id: user_id},
            dataType: 'JSON',
            success: function (data) {
                console.log(data);
                if(data.status == 'saved'){
                    var property = document.getElementById('btn_saveStory_'+post_id);
                    property.style.background = "yellowgreen";
                } else{
                    var property = document.getElementById('btn_saveStory_'+post_id);
                    property.style.removeProperty('background');
                }
            }
        });
    }
</script>
@endsection