function markAsRead(countNotification) {
    var url = "markAsRead";
    if(countNotification!==0){
    $.ajax({
        url: url,
        dataType: 'JSON',
        success: function (data) {
        }
    });
    }
}

function markNotificationAsRead(countNotification) {
    var url = "../markAsRead";
    if(countNotification!==0){
    $.ajax({
        url: url,
        dataType: 'JSON',
        success: function (data) {
        }
    });
    }
}

// $('#latest_stories').click(function () {
//     var page_no = $('#page_no').val();
//     var url = './post/latest/'+page_no;
//     window.location.replace(url);
//     // alert(url);
// });
$('#sidebarCollapse').click(function (e) {
    e.stopPropagation();
    $('#menu-sidebar').toggleClass('show-sidebar-menu');
    document.getElementById("menu-sidebar").style.marginLeft = "0";
    $('body').addClass('lock-scroll');
    $('.page-overlay').addClass('active');
});
$('#menu-sidebar').click(function (e) {
    e.stopPropagation();
});
$('#sidebar-close-btn').click(function (e) {
    e.stopPropagation();
    $('#menu-sidebar').removeClass('active');
    document.getElementById("menu-sidebar").style.marginLeft = "-250px";
    $('body').removeClass('lock-scroll');
    // hide overlay
    $('.page-overlay').removeClass('active');
});
$('#menu-content .collapsed').click(function (e) {
    e.preventDefault();
    let submenu = $(this).attr('data-target');
    $(submenu).toggleClass('in');
});
$('#mobile_nav_user_icon').click(function (e) {
    e.stopPropagation();
    $('#mobile_user_sidebar').toggleClass('show-sidebar-menu');
    document.getElementById("mobile_user_sidebar").style.marginRight = "0";
    $('body').addClass('lock-scroll');
    $('.page-overlay').addClass('active');
});
$('#mobile_user_sidebar').click(function (e) {
    e.stopPropagation();
});
$('body,html').click(function (e) {
    $('.page-overlay').removeClass('active');
    document.getElementById("menu-sidebar").style.marginLeft = "-250px";
    document.getElementById("mobile_user_sidebar").style.marginRight = "-250px";
    $('body').removeClass('lock-scroll');


});

$(".go-top-btn").click(function() {
    $("html, body").animate({ scrollTop: 0 }, "slow");
    return false;
});
function openLoginSocialModal($this,event) {
    event.preventDefault();
    let modal = $($this).data('modal');
    $(modal).modal('show').fadeIn(200);
}
$(document).ready(function(){
    setTimeout(function(){
        $('#social_login_modal').modal('show');
    },1000)

});