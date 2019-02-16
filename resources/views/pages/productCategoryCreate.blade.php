
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shufflehex</title>
    <link rel="stylesheet" href="{{ asset('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    {{--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/main.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/style.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('ChangedDesign/lessFiles/less/list-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('shufflehex/less/addstory.css') }}">
    @include('partials.assets')
    <style>
        #addNewStory .bootstrap-select{
            width: 100% !important;
        }
    </style>
</head>
<body>
<div id="wrapper">
    @include('partials.topbar')
    <div id="content-body" class="">
        <div id="storyForm" class="container">
            <form id="addNewStory" action="{{ route('productCategory') }}" method="POST" role="form">
                {{ csrf_field() }}
                <label for="storyTitle">Category</label>
                <div class="form-group">
                    <input type="text" name="category" id="storyTitle" class="form-control" placeholder="Category">
                </div>
                <button type="submit" name="storySubmit" id="storySubmit" class="btn btn-block btn-danger">Submit</button>

            </form>
        </div>
    </div>
    <footer id="footer" class=" text-center bg-success" >
        <p class="text-center">&copy; 2017</p>
    </footer>
</div>
@include('partials.sidebar')
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5a64cb7833dd1d0d"></script>
<!-- jQuery CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- jQuery Nicescroll CDN -->
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<!-- jQuery Nicescroll CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.6.8-fix/jquery.nicescroll.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<script>
    $('.selectpicker').selectpicker();

</script>
</body>
</html>