@extends('layouts.master')
@section('css')
    <title>Add Product</title>
    <!-- Include Editor style. -->
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/list-style.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/add.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/product.css') }}">
{{--    <link href="{{ asset('summernote/dist/summernote.css' }}" rel="stylesheet">--}}


@endsection
@section('content')
    {{----------------------------- store current url to session -----------------------}}
    <?php session(['last_page' => url()->current()]);?>
    {{-------------------------------------------------------------------------------------}}
    <div class="box">

        <div class="box-header">
            <h3>Edit Product</h3>
        </div>
        <div class="add-product">
            <form action="{{ route('product.update',$product->id) }}" method="POST" enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="text" class="form-control" name="title" placeholder="Product's Name" value="{{ $product->product_name }}">
                </div>
                <div class="form-group">
                    <div class="input-group input-file">
                        <label class="input-group-btn">
                        <span class="btn btn-primary">
                            Select Images&hellip; <input type="file" name="img[]" style="display: none;" multiple>
                        </span>
                        </label>
                        <input type="text" class="form-control" readonly placeholder="Replace previous images...">
                    </div>
                </div>
                <div class="form-group">

                    <textarea id="short-desc" name="short_desc" class="form-control" placeholder="Short Description">{{ $product->short_desc }}</textarea>

                </div>
                <div class="form-group">
                    <textarea id="features" name="desc" class="summernote">{{ $product->description }}</textarea>
                </div>
                <div class="form-group">
                    <input type="url" name="yt_video_url" class="form-control" placeholder="Youtube Video URL" value="{{ $product->yt_video_url }}">
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="store">
                                <option disabled selected>Select Store</option>
                                @foreach($stores as $store)
                                <option value="{{ $store->store_name }}" @if($store->store_name == $product->store_name) selected @endif>{{ $store->store_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="productId" class="form-control" placeholder="Product ID" value="{{ $product->product_id }}">
                        </div>
                    </div>
                    {{--<div class="row">--}}
                        {{--<div class="col-xs-12">--}}
                            {{--<button type="button" style="float:right; margin-top: 5px" class="btn btn-sm btn-default"><i class="fa fa-plus"></i>&nbsp;Add More</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                </div>
                <div class="form-group">
                    <input type="text" name="price" class="form-control" placeholder="Price (Ex: $25)" value="{{ $product->price }}">
                </div>
                <div class="form-group">
                    <input type="text" name="coupon" class="form-control" placeholder="Coupon" value="{{ $product->coupon }}">
                </div>
                <div class="form-group row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control" name="category">
                            <option disabled="disabled">Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->category }}" @if($category->category == $product->category) selected @endif>{{ $category->category }}</option>
                             @endforeach
                        </select>
                    </div>

                </div>
                <div class="form-group">
                    <input type="text" name="tags" class="form-control" placeholder="Tags" value="{{ $product->tags }}">
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
@endsection