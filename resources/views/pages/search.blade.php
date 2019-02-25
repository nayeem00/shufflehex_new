@extends('layouts.master')
@section('css')
    <!-- Bootstrap CSS CDN -->
    <title>Search</title>

@endsection
@section('content')
    <div class="row" style="margin-top: 10px">
        <div class="col-xs-12">
            <form class="w-100" action="{{ route('search.all') }}" method="POST">
                {{ csrf_field() }}
                <div class="input-group w-100">
                    <input type="text" name="search" class="form-control" placeholder="Search for..." value="{{ $searchText }}" id="searchInput" onkeyup="setSearchText()">
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
                </span>
                </div>
            </form>
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">
        <div class="col-sm-12">
            <div class="alert alert-success">Result for "<span id="searchText">{{ $searchText }}</span>"...</div>
        </div>
    </div>
    <div class="row" style="margin-top: 10px">
        <div class="col-sm-12">
            <!-- story -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="search-box">
                        <!-- start loop -->
                        @forelse($stories as $story)
                        <div class="row search-item">
                            <div class="col-xs-12">
                                <div class="img_box57_32">
                                    <a href="{{ url($story->story_link) }}" target="_blank" rel="nofollow">
                                        <img class="img-responsive"
                                             src="{{ url($story->related_story_image) }}"
                                             alt="">
                                    </a>
                                </div>
                                <div class="img_box57_right">
                                    <a href="{{ url($story->story_link) }}" target="_blank" rel="nofollow"><span
                                                class="font16">{{ $story->title }}</span></a>
                                </div>
                            </div>
                        </div>
                            @empty
                                <p class="text-center">No stories found!</p>
                            @endforelse
                    </div>
                </div>
                @if(count($stories)>0)
                <div class="panel-footer p-0 border-radius-none text-center">
                    <a class="btn border-radius-none" href="#"><i class="fa fa-plus-square"></i>&nbsp;See more stories</a>
                </div>
                 @endif
            </div>

            <!-- product -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="search-box">
                        <!-- start loop -->
                        @forelse($products as $product)
                        <div class="row search-item">
                            <div class="col-xs-12">
                                <div class="img_box32_32">
                                    <a href="{{ url($product->product_link) }}" target="_blank" rel="nofollow">
                                        <img class="img-responsive"
                                             src="{{ url($product->related_product_image) }}"
                                             alt="">
                                    </a>
                                </div>
                                <div class="img_box32_right">
                                    <a href="{{ url($product->product_link) }}" target="_blank" rel="nofollow"><span
                                                class="font16">{{ $product->product_name }}</span></a>
                                </div>
                            </div>
                        </div>
                            @empty
                                <p class="text-center">No products found!</p>
                            @endforelse
                    </div>
                </div>
                @if(count($products)>0)
                <div class="panel-footer p-0 border-radius-none text-center">
                    <a class="btn border-radius-none" href="#"><i class="fa fa-plus-square"></i>&nbsp;See more</a>
                </div>
                @endif
            </div>

            <!-- project -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="search-box">
                        <!-- start loop -->
                        @forelse($projects as $project)
                        <div class="row search-item">
                            <div class="col-xs-12">
                                <div class="img_box32_32">
                                    <a href="{{ url($project->project_link) }}" target="_blank" rel="nofollow">
                                        <img class="img-responsive"
                                             src="{{ url($project->small_logo) }}"
                                             alt="No Image found">
                                    </a>
                                </div>
                                <div class="img_box32_right">
                                    <a href="{{ url($project->project_link) }}" target="_blank" rel="nofollow"><span
                                                class="font16">{{ $project->title }}</span></a>
                                </div>
                            </div>
                        </div>
                        @empty
                            <p class="text-center">No projects found!</p>
                        @endforelse
                    </div>
                </div>
                @if(count($projects)>0)
                <div class="panel-footer p-0 border-radius-none text-center">
                    <a class="btn border-radius-none" href="#"><i class="fa fa-plus-square"></i>&nbsp;See more</a>
                </div>
                    @endif
            </div>

        </div>

    </div>
    <script>
        function setSearchText() {
            var searchText = $('#searchInput').val();
            $('#searchText').html(searchText);
        }
    </script>
@endsection