@foreach($posts as $key=>$post)

    <div class="story-item">
        <div class="row">

            <div class="col-md-11 col-sm-11 col-xs-11 pr-0">
                <div class="story-img img-box150_84">
                    <a href="{{ url($post->storyLink) }}" target="_blank"><img class="img-responsive"
                                                                               src="{{ url($post->story_list_image) }}" alt="{{ $post->title }}"></a>
                </div>
                <div class="img_box150_right">
                    <h4 class="story-title"><a href="{{ url($post->storyLink) }}"
                                               target="_blank"> {{ $post->title }}</a></h4>
                    <p class="submitted-line">
                        Submitted {{ $post->creation_time }} by <a
                                href="{{ url('profile/'.$post->username) }}"
                                rel="nofollow">{{ $post->username }}</a> in <a
                                href="{{ url('category/'.$post->category) }}">{{ $post->category }}</a>
                    </p>
                    <p class="story-domain"><a
                                href="{{ url('source/'.$post->domain) }}">{{ $post->domain }}</a></p>
                </div>


            </div>
            <div class=" col-md-1 col-sm-1 col-xs-1 pl-0">
                <div class="p-0 up-btn text-center">
                    @if($post->upvoteMatched == 1)
                        <a class="btn-vote-submit text-center" onclick="upVote({{$post->id}})">
                            <span class="fa fa-chevron-up text-shufflered" id="upvote_icon_{{$post->id}}" alt="Upvote"></span><br>
                            <span class="vote-counter text-center" id="vote_count_{{$post->id}}">{{ $post->vote_number }}</span>
                        </a>

                    @else
                        <a class="btn-vote-submit text-center" onclick="upVote( {{ $post->id }} )">
                            <span class="fa fa-chevron-up" id="upvote_icon_{{$post->id}}"></span><br>
                            <span class="vote-counter text-center" id="vote_count_{{$post->id}}">{{ $post->vote_number }}</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endforeach