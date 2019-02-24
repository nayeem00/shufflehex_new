@foreach($posts as $key=>$post)
    @foreach($posts as $post)
        <div class="story-item">
            <div class="row">
                <div class="col-md-12 col-sm-11 col-xs-10 pr-0">
                    <div class="story-img img-box150_84">
                        <a href="{{ url($post->storyLink) }}"><img class=""
                                                                   src="{{ url($post->story_list_image) }}"></a>
                    </div>
                    <div class="img_box150_right">
                        <h4 class="story-title"><a href="{{ url($post->storyLink) }}"> {{ $post->title }}</a>
                        </h4>
                        <?php
                        $description = substr($post->description, 0, 120)

                        ?>
                        <p>{{ $description }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endforeach