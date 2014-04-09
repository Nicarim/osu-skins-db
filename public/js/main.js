Dropzone.options.myAwesomeDropzone = {
    success: function(file,response){
        var $jQueryObject = $($.parseHTML(response));
        var arrayFiles = [];
        $jQueryObject.find(".element-row").each(function(){
            arrayFiles.push($.trim($(this).html()));
            console.debug($.trim($(this).html()));
        });
        console.debug("---------search------------");
        $("#fileslist > tbody > tr").each(function(index){
            if (index != 0)
            {
                var $localDom = $(this);
                var rowname = $.trim($localDom.find(".element-row").html());
                console.debug(rowname);
                if ($.inArray(rowname, arrayFiles) != -1){
                    console.debug("----DELETED----");
                    console.debug(rowname);
                    $localDom.hide();
                }
            }
        });
        $("#fileslist > tbody > tr:first").after($(response).hide().fadeIn(1500));
        console.debug("---------endofsearch------------");
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
    $(".fancybox").fancybox({
        ajax : {cache: false},
        preload : 0
    });
});
function deleteRow (item, id){
    $.get(("/skins/delete-element/"+id),function(data){
        console.debug(data);
        if (data == "success")
            $(item).parent().parent().fadeOut();
    })

}
//skin preview options
