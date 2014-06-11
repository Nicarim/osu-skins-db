Dropzone.options.myAwesomeDropzone = {
    createImageThumbnails: false,
    success: function(file,response){
        var $jQueryObject = $($.parseHTML(response));
        var arrayFiles = [];
        $jQueryObject.find(".element-row").each(function(){
            arrayFiles.push($.trim($(this).html()));
            console.debug($.trim($(this).html()));
        });
        //console.debug("---------search------------");
        $("#fileslist > tbody > tr").each(function(index){
            if (index != 0)
            {
                var $localDom = $(this);
                var rowname = $.trim($localDom.find(".element-row").html());
                //console.debug(rowname);
                if ($.inArray(rowname, arrayFiles) != -1){
                    //console.debug("----DELETED----");
                    //console.debug(rowname);
                    $localDom.hide();
                }
            }
        });
        $("#fileslist > tbody > tr:first").after($(response).hide().fadeIn(1500));
        //console.debug("---------endofsearch------------");
        this.removeFile(file);
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
    $("#missingElementsCheck").change(function(){
        caller = this;
        $("#fileslist > tbody > tr").each(function(index, value){
            if (caller.checked)
            {
                if (index != 0)
                    $(this).fadeOut();

            }
            else
            {
                if ($(this).data("typeofrow") == "missing")
                {
                    $(this).fadeOut(300, function(){
                        $(this).remove();
                    })
                }
                else if (index != 0)
                    $(this).fadeIn();
            }
        })
        if (caller.checked)
        {
            $.get("/skins/missing/2", function(data){
                $("#fileslist > tbody > tr:first").after(data).fadeIn();
            })
        }

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
