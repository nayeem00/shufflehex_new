$(document).ready(function () {
    function sidebar_close() {
        $('#sidebar').hide().addClass('slideOutLeft').removeClass('slideInRight');
    }
});
// function sidebar_open() {
//     $('#sidebar').css('display','block').addClass('slideInRight');
//     $('#main-body').addClass('main-content-after-sidebar');
// }
// function sidebar_close() {
//     $('#sidebar').fadeOut().removeClass('slideInRight');
//     $('#main-body').removeClass('main-content-after-sidebar');
// }
function sidebar_open() {
    $('#sidebar').show().addClass('slideInRight').removeClass('slideOutRight');
    $('#wrapper').addClass('main-content-after-sidebar');
    $('body').css('overflow-x','hidden');
}
function sidebar_close() {
    $('#sidebar').addClass('slideOutRight').removeClass('slideInRight');
    $('#wrapper').removeClass('main-content-after-sidebar');
    $('body').css('overflow-x','hidden');
}
// jQuery(function() {
//     var postDateTime = 'dd/MM/yyyy HH:mm:ss';
//
//     jQuery(".postTime").each(function (idx, elem) {
//         if (jQuery(elem).is(":input")) {
//             jQuery(elem).val(jQuery.format.prettyDate(jQuery(elem).val(), postDateTime));
//         } else {
//             jQuery(elem).text(jQuery.format.prettyDate(jQuery(elem).text(), postDateTime));
//         }
//     });
// });
jQuery(function() {
    $(".postTime").html(function (index, value) {
        // return moment(value, "YYYY-MM-DDTHH:mm:ss").format("dddd, MMMM Do YYYY, h:mm a");
        // return moment(value, "YYYY-MM-DDTHH:mm:ss").format("dddd, MMMM Do YYYY, h:mm a");
        return moment(value,"YYYY-MM-DDTHH:mm:ss").fromNow();
    });
});
// $(function () {
//     $('.postTime').each(function (index, dateElem) {
//         var $dateElem = $(dateElem);
//         var formatted = moment($dateElem.text(), "YYYY-MM-DD THH:mm:ss").format("dddd, MMMM Do YYYY, h:mm a");
//         $dateElem.text(formatted);
//     });
// })​