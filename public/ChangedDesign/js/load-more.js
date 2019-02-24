$(document).ready(function () {
    $(function () {
        var $win = $(window);

        $win.scroll(function () {
            if ($win.scrollTop() == 0){
                var getUrl = window.location;
                var baseUrl = getUrl .protocol + "//" + getUrl.host + "/";
                console.log(getUrl.host);
            }
            else if ($win.height() + $win.scrollTop()
                == $(document).height()) {
                loadMorePost();
            }
        });
    });


})

function loadMorePost() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var offset = $('#post-count-offset').data("offset");
    var pageKey = $('#page-key').data("page");;
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/";
    if(getUrl.host == 'localhost'){
        baseUrl = getUrl .protocol + "//" + 'localhost/shufflehex/public/'
    }
    var requestParam = {
        _token: CSRF_TOKEN,
        offset:offset,
        filterParam : filterParam ,
        pageKey: pageKey
    };
    if(pageKey == 'story-category' || pageKey == 'story-domain'){
        var searchCategory = $('#search-category').data("value");
        requestParam.searchCategory = searchCategory;
    }


    $.ajax({
        url:baseUrl+"ajax/get_more_post",
        type: "POST",
        data:requestParam,
        dataType: "JSON",
        success: function (data) {
            if(data.sucess == "true"){
                $('#post-count-offset').data("offset", data.newOffset);
                $(data.postsData).hide().appendTo(".posts").fadeIn(2000);


            }
            // else {
            //     $(".no-post-available").html("Opps !! You're at the end of this page.")
            // }
        }
    })
}