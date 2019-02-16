@extends('layouts.master')

@section('css')
<link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/list-style.css') }}">
<link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/add.css') }}">

@endsection
@section('content')

<div class="list-content col-md-7 col-sm-12">
    <h3>List Created</h3>
    <h4>Add List Items</h4>
    <div class="add-items" style="margin-top: 50px">
        <form id="addNewList" class="addLinksForm" action="http://gpt.website/post" method="POST" role="form">
            <div class="form-group">
                <label for="storyTitle">Item Name</label>
                <input name="title" id="storyTitle" class="form-control" placeholder="Title" type="text">
            </div>
            <div class="form-group">
                <label for="image">Item Image</label>
                <div class="input-group input-file" name="image">
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-choose" type="button">Choose</button>
                            </span>
                    <input type="text" class="form-control" placeholder='Choose a file...' />
                    <span class="input-group-btn">
                                 <button class="btn btn-warning btn-reset" type="button">Reset</button>
                            </span>
                </div>
            </div>
            <div class="form-group">
                <label for="storyDesc">Description</label>
                <textarea type="text" name="description" id="storyDesc" rows="5" class="form-control"></textarea>
            </div>
            <label for="storyLink">Item Link</label>
            <div class="form-group">
                <input name="link" id="storyLink" class="form-control" placeholder="Link" type="text">
            </div>
            <div class="form-group" style="margin-top: 20px">
                <a class="btn btn-block btn-default"><i class="fa fa-plus-circle"></i> Add More</a>
            </div>
            <div class="form-group">
                <button type="submit" name="storySubmit" id="storySubmit" class="btn-link-submit btn btn-block btn-danger">Submit</button>
            </div>
        </form>


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
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<script>
    $('.selectpicker').selectpicker();
</script>
<script src="js/home.js"></script>
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
<!-- Include Editor style. -->

<!-- Include JS file. -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<!-- Include Editor JS files. -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.1//js/froala_editor.pkgd.min.js"></script>
<script>
    $(function() {
        $('textarea#froala-editor').froalaEditor()
    });
</script>

@endsection

