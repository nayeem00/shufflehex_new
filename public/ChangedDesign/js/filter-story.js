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
    var filterParam = {
        _token: CSRF_TOKEN,
        timefilter : getFilterParameter('.time-filter'),
        topicsfilter : getFilterParameter('.topics-filter'),
        otherfilter : getFilterParameter('.other-filter')
    };
    console.log(filterParam);

    $.ajax({
        url:"ajax/get_filterd_post",
        type: "POST",
        data:filterParam,
        dataType: "JSON",
        success: function (data) {
            addPosts(data);
        }
    })



}


function addPosts(data) {
    $(".posts").html("");
    $(".no-post-available").html("");
    if(data.sucess == "true"){
        $.each( data.posts, function (index,value) {
            var html = "\n" +
                "<div class=\"story-item \">\n" +
                "    <div class=\"row \">\n" +
                "\n" +
                "        <div class=\"col-md-3 col-sm-3 col-xs-3 pr-0\">\n" +
                "            <div class=\"story-img\">\n" +
                "                <a href=\"{{ url('story/'.$post->id.'/'.$title) }}\" target=\"_blank\"><img class=\"\" src=\""+value.featured_image+"\"></a>\n" +
                "            </div>\n" +
                "        </div>\n" +
                "        <div class=\"col-md-9 col-sm-9 col-xs-8 pr-0\">\n" +
                "\n" +
                "            <h4 class=\"story-title\"><a href=\"{{ url('story/'.$post->id.'/'.$title) }}\" target=\"_blank\">"+value.title+"</a></h4>\n" +
                "            <div class=\"dis-cls\">\n" +
                "                <p><small>Submitted by <strong><span>"+value.username+"</span></strong></small></p>\n" +
                "            </div>\n" +
                "\n" +
                "            <div class=\"row dis-n\">\n" +
                "                <div class=\"col-md-6 dis-n\"><p class=\"story-domain\">"+value.domain+"</p></div>\n" +
                "\n" +
                "                <div class=\"col-md-6 col-sm-6 col-xs-12 vote\">\n" +
                "                    <div class=\"col-md-6 col-sm-6 col-xs-6 col-md-offset-2 p-0 up-btn\">\n" +
                "                        <a class=\"\" onclick=\"upVote("+value.id+")\"><span  id=\"btn_upVote_"+value.id+"\" class=\"thumb-up glyphicon glyphicon-triangle-top\" ></span></a>\n" +
                "                        <span class=\"vote-counter text-center\" >Upvote</span>\n" +
                "                        <span class=\"vote-counter text-center\" id=\"vote_count_"+value.id+"\"></span>\n" +

                "                    </div>\n" +
                "\n" +
                "                    <div class=\"col-md-2 col-sm-2 col-xs-2 p-0 saved-btn\">\n" +
                "                        <a class=\"\" onclick=\"downVote("+value.id+")\">\n" +
                "                            <span class=\"saved glyphicon glyphicon-bookmark\" ></span>\n" +
                "                        </a>\n" +
                "                    </div>\n" +
                "\n" +
                "                    <div class=\"col-md-2 col-sm-2 col-xs-2 p-0 down-btn\">\n" +
                "                        <a onclick=\"downVote("+value.id+")\">\n" +
                "                            <span class=\"thumb glyphicon glyphicon-share-alt\"></span>\n" +
                "                        </a>\n" +
                "                    </div>\n" +
                "                </div>\n" +
                "            </div>\n" +
                "        </div>\n" +
                "        <div class=\"col-xs-1 dis-show vote plr-0\">\n" +
                "            <div class=\"p-0 up-btn\">\n" +
                "                <a onclick=\"upVote("+value.id+")\"><span  id=\"btn_upVote_"+value.id+"\" class=\"thumb-up glyphicon glyphicon-triangle-top\" alt=\"Upvote\"></span></a>\n" +
                "                <span class=\"vote-counter text-center\" id=\"vote_count_"+value.id+"\"></span>\n" +

                "            </div>\n" +
                "        </div>\n" +
                "    </div>\n" +
                "</div>";



            $(html).hide().appendTo(".posts").fadeIn(2000);



        });

    }
    else {
        $(".no-post-available").html("Opps !! No Post Found");
    }
}

