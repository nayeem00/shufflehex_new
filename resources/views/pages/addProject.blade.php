@extends('layouts.master')
@section('css')
    <title>Add Product</title>
    <!-- Include Editor style. -->
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/list-style.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/add.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/product.css') }}">
       <!-- Bootstrap CSS CDN -->

@endsection
@section('content')

    {{----------------------------- store current url to session -----------------------}}
    <?php session(['last_page' => url()->current()]);?>
    {{-------------------------------------------------------------------------------------}}

    <div class="box">

        <div class="box-header">
            <h3>Add Project</h3>
        </div>

        <div class="add-product">
            <form action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="text" class="form-control" name="title" placeholder="Project's Name">
                </div>
                <div class="form-group">
                    <input type="url" name="link" class="form-control" placeholder="Link">
                </div>

                <div class="form-group">
                    <textarea id="short-desc" name="tag_line" class="form-control" placeholder="Tagline"></textarea>
                </div>
                <div class="form-group">
                    <textarea id="features" class="summernote" name="description"></textarea>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <label class="input-group-btn">
                        <span class="btn btn-primary">
                            Logo&hellip; <input type="file" name="logo" style="display: none;" multiple>
                        </span>
                        </label>
                        <input type="text" class="form-control" readonly>
                    </div>
                    <p class="help-text"><small>500px X 500px logo.</small></p>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <label class="input-group-btn">
                        <span class="btn btn-primary">
                            Screenshots&hellip; <input type="file" name="images[]" style="display: none;" multiple>
                        </span>
                        </label>
                        <input type="text" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <select class="form-control" name="category">
                        <option disabled selected>Category</option>
                        @foreach($categories as $category)
                        <option>{{ $category->category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" name="tags" class="form-control" placeholder="Tags">
                </div>
                <div class="form-group mr-0">
                    <input type="submit" class="btn btn-danger btn-block" value="Submit">
                </div>
            </form>

        </div>

    </div>
@endsection
{{--
<div class="overlay"></div>
--}}
{{--</div>--}}
@section('js')

    <script src="{{ asset('summernote/dist/summernote.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height:150
            });
        });
    </script>
    <script>
        $(function() {

            // We can attach the `fileselect` event to all file inputs on the page
            $(document).on('change', ':file', function() {
                var input = $(this),
                    numFiles = input.get(0).files ? input.get(0).files.length : 1,
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [numFiles, label]);
            });

            // We can watch for our custom `fileselect` event like this
            $(document).ready( function() {
                $(':file').on('fileselect', function(event, numFiles, label) {

                    var input = $(this).parents('.input-group').find(':text'),
                        log = numFiles > 1 ? numFiles + ' files selected' : label;

                    if( input.length ) {
                        input.val(log);
                    } else {
                        if( log ) alert(log);
                    }

                });
            });

        });


    </script>
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
    <!-- Include Editor JS files. -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.1//js/froala_editor.pkgd.min.js"></script>
    <script>
        $(function() {

            $('textarea#froala-editor').froalaEditor()

        });

    </script>
@endsection