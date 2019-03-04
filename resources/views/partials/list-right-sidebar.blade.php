<div id="right-sidebar">
    <div id="list-right-sidebar">
        <div class="sibebar-panel">
            <div class="list-group ">
                <li class="list-group-item list-group-title">TRENDING PRODUCTS</li>
                <div class="right-sidebar">
                    @foreach($products as $product)
                    <a id="trending-product" class="list-group-item" href="{{ url($product->product_link) }}">
                        <img src="{{ url($product->related_product_image) }}" alt="{{ $product->product_title }}">{{ $product->product_title }}</a>
                     @endforeach
                </div>

            </div>
        </div>


        <div class="sibebar-panel">
            <div class="sidebar-link-list">
                <div class="list-group">
                    <li class="list-group-item list-group-title">TRENDING PROJECTS</li>
                    <div class="right-sidebar">
                        @foreach($projects as $project)
                            <a id="trending-project" class="list-group-item" href="{{ url($project->project_link) }}">
                                <img src="{{ url($project->small_logo) }}" alt="{{ $project->project_title }}">{{ $project->project_title }}</a>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
