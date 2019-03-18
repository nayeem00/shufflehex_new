<div id="right-sidebar">
    <div id="list-right-sidebar">
        <div class="sibebar-panel">
            <div class="sidebar-link-list">
                <ul class="list-group ">
                    <li class="list-group-item list-group-title">TRENDING PRODUCTS</li>
                    @foreach($products as $product)
                        <li class="list-group-item">
                            <a class="trending-product" href="{{ url($product->product_link) }}">
                                <div class="img_box50_50">
                                    <img class="" src="{{ url($product->related_product_image) }}"
                                         alt="{{ $product->product_title }}">
                                </div>
                                <div class="img_box50_right content-middle">
                                    {{ $product->product_title }}
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="sibebar-panel">
            <div class="sidebar-link-list">
                <ul class="list-group">
                    <li class="list-group-item list-group-title">TRENDING PROJECTS</li>
                    @foreach($projects as $project)
                        <li class="list-group-item">
                            <a class="trending-project" href="{{ url($project->project_link) }}">
                                <div class="img_box50_50">
                                    <img src="{{ url($project->small_logo) }}" alt="{{ $project->project_title }}">
                                </div>
                                <div class="img_box50_right">
                                    <div class="content-middle h-100">
                                        {{ $project->project_title }}
                                    </div>

                                </div>
                            </a>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
    </div>
</div>
