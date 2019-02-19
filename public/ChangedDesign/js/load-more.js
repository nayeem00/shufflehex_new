$(document).ready(function () {
    $(function () {
        var $win = $(window);

        $win.scroll(function () {
            if ($win.scrollTop() == 0)
                console.log("top");
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
    $.ajax({
        url:"ajax/get_more_post",
        type: "POST",
        data:{_token: CSRF_TOKEN, offset:offset},
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