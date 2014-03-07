Dropzone.options.myAwesomeDropzone = {
    success: function(file,response){
        var $jQueryObject = $($.parseHTML(response));
        var filename = $jQueryObject.find("td:first > a:nth-child(2)").text();

        $("#fileslist > tbody > tr").each(function(){
            var $localDom = $(this);;
            var rowname = $localDom.find("td:first > a:nth-child(2)").text();
            if (rowname == filename){
                $(this).hide();
            }
        });
        $("#fileslist > tbody > tr:first").after($(response).hide().fadeIn(1500));
    }
}
$(function(){
    var hash = window.location.hash;
    hash && $('ul.nav a[href="' + hash + '"]').tab('show');

    $('.nav-tabs a').click(function (e) {
        $(this).tab('show');
        var scrollmem = $('body').scrollTop();
        window.location.hash = this.hash;
        $('html,body').scrollTop(scrollmem);
    });
});
$(document).ready(function() {
    $(".fancybox").fancybox();
});
function deleteRow (item, id){
    $.get(("/file-delete/"+id),function(data){
        if (data == "success")
            $(item).parent().parent().fadeOut();
    })

}