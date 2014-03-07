Dropzone.options.myAwesomeDropzone = {
    success: function(file,response){
        $("#fileslist > tbody > tr").each(function(){
            if (this.innerText == $(response).find("tr:first > td:first > a:nth-child(2)").innerText){
                this.hide();
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