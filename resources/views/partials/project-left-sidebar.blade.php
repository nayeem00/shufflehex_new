<div class="project-left-sidebar">
    <div class="project-left-md">
        <div class="project-logo">
            <img class="img-responsive" src="{{ url($post->logo) }}">
        </div>
        <div class="project-info text-center">
            <h1 class="font18 bold-800">{{ $post->title }}</h1>
        </div>
    </div>
    <div class="project-left-sm w-100">
        <div class="row box">
            <div class="col-xs-12">
                <div class="img_box84_84">
                    <img class="img-responsive" src="{{ url($post->logo) }}">
                </div>
                <div class="img_box84_right">
                    <div class="project-info text-left">
                        <h1 class="font18 bold-800 m-0">{{ $post->title }}</h1>
                        <p>
                            <a class="text-999" href="#">
                                <i class="fa fa-tag"></i>&nbsp;<span>{{ $post->category }}</span>
                            </a>
                        </p>

                    </div>
                </div>

            </div>
        </div>
        <div class="row box">
            <a class="btn btn-default btn-block text-shufflered" href="{{ url($post->link) }}" target="_blank"
               rel="nofollow">
                <i class="fa fa-globe"></i>&nbsp;<span>WEBSITE</span>
            </a>
        </div>
    </div>

</div>