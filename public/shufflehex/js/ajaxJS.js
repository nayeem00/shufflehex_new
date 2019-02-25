// function getLinks(menuID) {
//     if (menuID == "") {
//         document.getElementById("link-post").innerHTML = "";
//         return;
//     } else {
//         if (window.XMLHttpRequest) {
//             // code for IE7+, Firefox, Chrome, Opera, Safari
//             xmlhttp = new XMLHttpRequest();
//         } else {
//             // code for IE6, IE5
//             xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
//         }
//         xmlhttp.onreadystatechange = function() {
//             if (this.readyState == 4 && this.status == 200) {
//                 document.getElementById("link-post").innerHTML = this.responseText;
//             }
//         };
//         xmlhttp.open("GET","ajaxGet/getLinkList.php?menu_id="+menuID,true);
//         xmlhttp.send();
//         $("#latest_post").hide();
//     }
// }
function getPromotedLinks() {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("link-post").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET","ajaxGet/getPromotedLinks.php",true);
    xmlhttp.send();
    $("#latest_post").hide()
}
function getLatestLinks(){
    $("#latest_post").fadeIn();
}

