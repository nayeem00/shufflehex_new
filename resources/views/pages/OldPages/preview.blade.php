
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shuffle Case</title>

    <link rel="stylesheet/less" type="text/css" href="{{ asset('shufflehex/less/preview.less') }}">
    @include('partials.assets')
    <script type="text/javascript" src="{{ asset('shufflehex/js/ajaxJS.js') }}"></script>
</head>
<body>
<div id="wrapper">
    @include('partials.topbar')
    <div id="content-body">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-6 col-xs-12">
                    <a href="../../post/{{ $post->id }}" target="_blank"> <h1 class="title">{{ $post->title }}</h1></a>
                    <div class="link-feature-img">
                        <img class="img-responsive" src="{{ $post->featured_image }}">
                    </div>
                    <div class="link-deatils">
                        <p class="link-desc">{!! $post->description !!}</p>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-8 col-xs-12">
                    <form id="addNewStory" action="{{ route('comment.store') }}" method="POST" role="form">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea type="text" name="comment" id="storyDesc" rows="5" cols="10" class="form-control"></textarea>
                        </div>
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <button type="submit" name="storySubmit" id="storySubmit" class="btn btn-danger pull-right">Reply</button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-8 col-xs-12">
                    <div class="comment-box" style="margin: 10px auto">
                        @foreach($post->comments as $comment)
                        <div class="comment">
                            <div class="panel panel-success">
                                <div class="panel-heading" style="padding: 5px;">
                                    <span class="comment-user text-primary"><strong>{{ $comment->username }}</strong>&nbsp;<span
                                                class="small text-muted commentTime postTime">{{ $comment->created_at }}</span></span>
                                </div>
                                <div class="comment-details panel-body">
                                    {{ $comment->comment }}
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>


    </div>
    <footer id="footer" class=" text-center bg-success" >
        <p class="text-center">&copy; 2017</p>
    </footer>
</div>
@include('partials.sidebar')

</body>
</html>