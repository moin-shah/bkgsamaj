$(document).ready(function () {
    //Disable cut copy paste
    // $('tbody').bind('cut copy paste', function (e) {
    //     e.preventDefault();
    // });
   
    //Disable mouse right click
    $(".filters").on("contextmenu",function(e){
        return true;
    });
    $("tbody, th, .summary").on("contextmenu",function(e){
        return false;
    });
});