<div id="filter" class="row filter-list collapse m-0">
    <?php if(!isset($removeFilter['time'])) { ?>
    <div class="col-md-3 col-sm-4 col-xs-6 time-filter">
        <div class="filter-title">Upload Date</div>
        <ul class="list-unstyled">
            <li><a id="day" class="time-filter-item">Today</a></li>
            <li><a id="week" class="time-filter-item">This week</a></li>
            <li><a id="month" class="time-filter-item">This month</a></li>
            <li><a id="year" class="time-filter-item">This year</a></li>
        </ul>
    </div>
        <?php }?>
        <?php  if(!isset($removeFilter['topics'])) { ?>
    <div class="col-md-3 col-sm-4 col-xs-6 topics-filter">
        <div class="filter-title">Type</div>
        <ul class="list-unstyled">
            <li><a id="link" class="topics-filter-item">Web</a></li>
            <li><a id="image" class="topics-filter-item">Images</a></li>
            <li><a id="video" class="topics-filter-item">Videos</a></li>
            <li><a id="article" class="topics-filter-item">Articles</a></li>
        </ul>
    </div>
        <?php }?>
        <?php if(!isset($removeFilter['topics'])) { ?>
    <div class="col-md-3 col-sm-4 col-xs-6 topics-filter">
        <div class="filter-title">Type</div>
        <ul class="list-unstyled">
            <li><a id="list" class="topics-filter-item">Lists</a></li>
            <li><a id="poll" class="topics-filter-item">poll</a></li>
            {{--<li><a href="#">Type 1</a></li>--}}
        </ul>
    </div>
        <?php }?>
        <?php if(!isset($removeFilter['other'])) { ?>
    <div class="col-md-3 col-sm-4 col-xs-6 other-filter">
        <div class="filter-title">Other</div>
        <ul class="list-unstyled">
            <li><a id="upvote" class="other-filter-item">Upvote</a></li>
            <li><a id="downvote" class="other-filter-item">Downvote</a></li>
            <li><a id="page-view" class="other-filter-item">Page View</a></li>
            <li><a id="most-comment" class="other-filter-item">Most Comments</a></li>
        </ul>
    </div>
        <?php }?>
<div class="col-xs-12 p-0">
    <hr class="m-0">
</div>
</div>