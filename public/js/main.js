Dropzone.options.myAwesomeDropzone = {
    createImageThumbnails: false,
    uploadMultiple: true,
    success: function(file,response){
        var $jQueryObject = $($.parseHTML(response));
        var arrayFiles = [];
        var countElements = true;
        var ElementsCount = 0;
        $jQueryObject.find(".element-row").each(function(){
            arrayFiles.push($.trim($(this).html()));
            console.debug($.trim($(this).html()));
            ElementsCount++;
        });
        $("#fileslist > tbody > tr").each(function(index){
            if (index != 0)
            {
                var $localDom = $(this);
                var rowname = $.trim($localDom.find(".element-row").html());
                if ($.inArray(rowname, arrayFiles) != -1){
                    $localDom.hide();
                    countElements = false;
                }
            }
        });
        $("#fileslist > tbody > tr:first").after($(response).hide().fadeIn(1500))
        if (countElements)
        {
            var count = parseInt($("#element-count").text());
            $("#element-count").text((count + ElementsCount));
        }
        this.removeFile(file);
    },
    queuecomplete: function(){
        refreshSize();
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
    $("#star-skin").click(function(){
        var startext = $("#star-skin > .star-text");
        startext.animate({opacity: 0}, 1000);
        $.get("/skins/vote/"+$(this).data("skinid"), function(){
            var typeOfStar = startext.text() == "Star";
            startext.text(typeOfStar ? "Unstar" : "Star");
            startext.animate({opacity: 1}, 1000);
            if(typeOfStar)
                $("#vote-count").text(parseInt($("#vote-count").text()) - 1);
            else
                $("#vote-count").text(parseInt($("#vote-count").text()) + 1);
        });
    });
});
function deleteRow (item, id){
    $.get(("/skins/delete-element/"+id),function(data){
        console.debug(data);
        //if (data == "success")
    });
    $(item).parent().parent().fadeOut(200, function(){
        $(this).remove();
        refreshSize();
    });
    var count = parseInt($("#element-count").text());
    $("#element-count").text((count - 1));
}
function refreshSize()
{
    var overallSize = 0;
    $("#fileslist > tbody > tr").each(function(index){
        if (index != 0)
        {
            var size = parseInt($(this).find(".element-size").data("elementsize"));
            overallSize += size;
        }
    });
    var sizeReadable = bytesToSize(overallSize, 2);
    $("#skin-size").text(sizeReadable);
}
function bytesToSize(bytes, precision)
{
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (bytes == 0) return 'n/a';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return (bytes / Math.pow(1024, i)).toFixed(precision) + ' ' + sizes[i];
}
//skin preview options
