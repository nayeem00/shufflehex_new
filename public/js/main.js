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

$('body,html').click(function (e) {
    // $('#menu-sidebar').removeClass('active');
    document.getElementById("menu-sidebar").style.marginLeft = "-250px";
    $('body').removeClass('lock-scroll');

    $('.page-overlay').removeClass('active');
});
