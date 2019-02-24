var filterParam = null;
$('.time-filter-item').click(function(){
    let thisItem = $(this);
    if(thisItem.hasClass("selected-filter")){
        thisItem.removeClass('selected-filter');
        thisItem.removeClass('text-danger');
    }else{
        removeOtherSelection(".time-filter");
        thisItem.addClass('selected-filter');
        thisItem.addClass('text-danger');
    }
    updateFilterResults();

})

$('.topics-filter-item').click(function(){
    let thisItem = $(this);
    if(thisItem.hasClass("selected-filter")){
        thisItem.removeClass('selected-filter');
        thisItem.removeClass('text-danger');
    }else{
        removeOtherSelection(".topics-filter");
        thisItem.addClass('selected-filter');
        thisItem.addClass('text-danger');
    }
    updateFilterResults();
})

$('.other-filter-item').click(function(){
    let thisItem = $(this);
    if($(this).hasClass("selected-filter")){
        thisItem.removeClass('selected-filter');
        thisItem.removeClass('text-danger');
    }else{
        removeOtherSelection(".other-filter");
        thisItem.addClass('selected-filter');
        thisItem.addClass('text-danger');
    }
    updateFilterResults();
})


function removeOtherSelection(filterClass) {
    $(filterClass+" a").each(function(){
        if($(this).hasClass('selected-filter')){
            $(this).removeClass("selected-filter");
            $(this).removeClass('text-danger');
        }
    })
}
function getFilterParameter(filterClass) {
    // console.log($(filterClass+" a"));
    var temp = "none"
    $(filterClass+" a").each(function(){
        if($(this).hasClass('selected-filter')){
            temp = $(this).attr('id');
        }
    })
    return temp;
}


function updateFilterResults() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    filterParam = {
        timefilter : getFilterParameter('.time-filter'),
        topicsfilter : getFilterParameter('.topics-filter'),
        otherfilter : getFilterParameter('.other-filter')
    };
    var pageKey = $('#page-key').data("page");
    var requestParam = {
        _token: CSRF_TOKEN,
        filterParam : filterParam,
        pageKey : pageKey
    };

    if(pageKey == 'story-category'){
        var searchCategory = $('#search-category').data("value");
        requestParam.searchCategory = searchCategory;
    }
    console.log(filterParam);
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/";
    if(getUrl.host == 'localhost'){
        baseUrl = getUrl .protocol + "//" + 'localhost/shufflehex/public/'
    }
    $.ajax({
        url:baseUrl+"ajax/get_filterd_post",
        type: "POST",
        data:requestParam,
        dataType: "JSON",
        success: function (data) {
            addPosts(data);
        }
    })
}


function addPosts(data) {
    $(".posts").html("");
    $(".no-post-available").html("");
    $('.story-filter').removeClass('in');
    if(data.sucess == "true"){
        $('#post-count-offset').data("offset", data.newOffset);
        $(data.postsData).hide().appendTo(".posts").fadeIn(2000);

    }
    else {
        $(".no-post-available").html("Opps !! No Post Found");
    }
}

