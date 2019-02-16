@extends('layouts.master')
@section('css')
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Our Custom CSS -->
    <link rel="stylesheet/less" href="{{ asset('ChangedDesign/lessFiles/less/style.less') }}">
    <link rel="stylesheet/less" href="{{ asset('ChangedDesign/lessFiles/less/list-style.less') }}">
    <link rel="stylesheet/less" href="{{ asset('ChangedDesign/lessFiles/less/sidebar.less') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
@endsection

@section('content')
    <div class="col-md-7 col-sm-12">
        <div class="panel panel-notifications">
            <div class="panel-heading">
                <h3>Notifications</h3>
            </div>
            <div id="notiffication-body" class="panel-body">
                <div class="notification-list">
                    @for($i=0;$i < count(auth()->user()->Notifications);$i++)
                        @if(array_key_exists('comment',auth()->user()->Notifications[$i]->data['data']))
                            <div class="notification-item alert"><a href="{{ url('post/'.auth()->user()->Notifications[$i]->data['data']['post_id'].'/title') }}"><span class="notify-name text-uppercase text-primary">{{ auth()->user()->Notifications[$i]->data['user']['name'] }}</span> <small>commented on your post.</small></a></div>
                        @elseif(array_key_exists('vote',auth()->user()->Notifications[$i]->data['data']) && auth()->user()->Notifications[$i]->data['data']['vote']==1)
                             <div class="notification-item alert"><a href="{{ url('post/'.auth()->user()->Notifications[$i]->data['data']['post_id'].'/title') }}"><span class="notify-name text-uppercase text-primary">{{ auth()->user()->Notifications[$i]->data['user']['name'] }}</span> <small>upvoted your post.</small></a></div>
                        @elseif(array_key_exists('vote',auth()->user()->Notifications[$i]->data['data']) && auth()->user()->Notifications[$i]->data['data']['vote']==-1)
                             <div class="notification-item alert"><a href="{{ url('post/'.auth()->user()->Notifications[$i]->data['data']['post_id'].'/title') }}"><span class="notify-name text-uppercase text-primary">{{ auth()->user()->Notifications[$i]->data['user']['name'] }}</span> <small>downvoted your post.</small></a></div>
                        @endif
                    @endfor
                    {{--<div class="notification-item alert"><a href=""><span class="notify-name text-uppercase text-primary">John Doe</span> <small>Upvoted your list. Sagor luiccha. Anower Luiccha</small></a></div>--}}
                    {{--<div class="notification-item alert"><a href=""><span class="notify-name text-uppercase text-primary">John Doe</span> <small>Upvoted your list. Sagor luiccha. Anower Luiccha</small></a></div>--}}
                    {{--<div class="notification-item alert"><a href=""><span class="notify-name text-uppercase text-primary">John Doe</span> <small>Upvoted your list. Sagor luiccha. Anower Luiccha</small></a></div>--}}
                    {{--<div class="notification-item alert"><a href=""><span class="notify-name text-uppercase text-primary">John Doe</span> <small>Upvoted your list. Sagor luiccha. Anower Luiccha</small></a></div>--}}
                    {{--<div class="notification-item alert"><a href=""><span class="notify-name text-uppercase text-primary">John Doe</span> <small>Upvoted your list. Sagor luiccha. Anower Luiccha</small></a></div>--}}


                </div>
            </div>
        </div>
    </div>
@endsection




@section('js')
    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/2.7.2/less.min.js"></script>
    <!-- jQuery Nicescroll CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.6.8-fix/jquery.nicescroll.min.js"></script>
    <script src="js/home.js"></script>
    <script>
        function upVote(post_id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var property = 'btn_upVote_'+post_id;
            console.log(post_id);
            $.ajax({
                type:'post',
                url: 'vote',
                data: {_token: CSRF_TOKEN , post_id: post_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if(data.status == 'upvoted'){
                        var property = document.getElementById('btn_downVote_'+post_id);
                        property.style.removeProperty('color');
                        var property = document.getElementById('btn_upVote_'+post_id);
                        property.style.color = "green"
                        $('#vote_count_'+post_id).text(data.voteNumber);
                    } else{
                        var property = document.getElementById('btn_upVote_'+post_id);
                        property.style.removeProperty('color');
                        $('#vote_count_'+post_id).text(data.voteNumber);
                    }
                }
            });
        };

        function downVote(post_id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var property = 'btn_downVote_'+post_id;
            console.log(property);
            $.ajax({
                type:'post',
                url: 'vote/downVote',
                data: {_token: CSRF_TOKEN , post_id: post_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if(data.status == 'downvoted'){
                        var property = document.getElementById('btn_upVote_'+post_id);
                        property.style.removeProperty('color');
                        var property = document.getElementById('btn_downVote_'+post_id);
                        property.style.color = "orangered"
                        $('#vote_count_'+post_id).text(data.voteNumber);
                    } else{
                        var property = document.getElementById('btn_downVote_'+post_id);
                        property.style.removeProperty('color');
                        $('#vote_count_'+post_id).text(data.voteNumber);
                    }
                }
            });
        };

        function saveStory(post_id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var property = 'btn_saveStory_'+post_id;
            console.log(post_id);
            $.ajax({
                type:'post',
                url: 'saveStory',
                data: {_token: CSRF_TOKEN , post_id: post_id},
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
        };
    </script>
    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5a64cb7833dd1d0d"></script>

@endsection