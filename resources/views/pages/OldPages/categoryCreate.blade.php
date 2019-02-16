
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shuffle Case</title>

    <link rel="stylesheet/less" type="text/css" href="{{ asset('shufflehex/less/addstory.less') }}">
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
            <form id="addNewStory" action="{{ route('category.store') }}" method="POST" role="form">
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
<script>
    $('.selectpicker').selectpicker();

</script>
</body>
</html>