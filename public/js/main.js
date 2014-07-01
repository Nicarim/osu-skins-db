Dropzone.options.myAwesomeDropzone = {
    createImageThumbnails: false,
    uploadMultiple: true,
    success: function(file,response){
        var $jQueryObject = $($.parseHTML(response));
        var arrayFiles = [];
        var countElements = true;
        var ElementsCount = 0;
        $jQueryObject.find(".element-filename").each(function(){
            arrayFiles.push($.trim($(this).html()));
            ElementsCount++;
        });
        $("#fileslist > .list-group-item").each(function(index){
            var $localDom = $(this);
            var rowname = $.trim($localDom.find(".element-filename").html());
            if ($.inArray(rowname, arrayFiles) != -1){
                $localDom.hide();
                $localDom.remove();
                countElements = false;
            }
        });
        $("#fileslist").prepend($(response).hide().fadeIn(1500));
        if (countElements)
        {
            var count = parseInt($("#element-count").text());
            $("#element-count").text((count + ElementsCount));
        }
        this.removeFile(file);
        refreshSize();
    }
};
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
        $("#star-skin").slideToggle();
        $.get("/skins/vote/"+$(this).data("skinid"), function(){
            var typeOfStar = startext.text() == "Star";
            startext.text(typeOfStar ? "Unstar" : "Star");
            $("#star-skin").slideToggle();
            if(typeOfStar)
                $("#votes-count").text(parseInt($("#votes-count").text()) + 1);
            else
                $("#votes-count").text(parseInt($("#votes-count").text()) - 1);

        });
    });
    $(document).on('click', '.audio-element', function(event){
        event.preventDefault();
        document.getElementById($(event.target).data("elementid").toString() + "-audio").play();
    });
    $(document).on('click', '.config-element', function(event){
        var preObject = "#" + $(event.target).data("elementid").toString() + "-config";
        event.preventDefault();
        if (isEmpty($(preObject)))
        {
            var url = $(event.target).attr("href");
            $.get(url, function(data){

                $(preObject).text(data);
                $(preObject).slideToggle();
            });
        }
        else
            $(preObject).slideToggle();
    });
    $(document).on('click', '.filter-files', function(event){
        var type = $(event.target).data("type").toString();
        $(".element-row").each(function(){
            var $localDom = $(this);
            var element = $localDom.find("b:first");
            if (element.data("type").toString() == type)
                $localDom.parent().fadeToggle();
        });
        if ($(event.target).css("opacity") == 0.50)
        {
            $(event.target).animate({
                "opacity": 1
            }, 500);
        }
        else
        {
            $(event.target).animate({
                "opacity": 0.50
            }, 500);
        }
    });
    $(document).on('click', '#filesmanager-link', function(event){
        if (isEmpty($("#filesmanager")))
        {
            $.get("/skins/view/" + $(event.target).data("skinid") + "/filesmanager", function(data){
                $("#filesmanager").html(data);
            });
        }
    });
});
function isEmpty (el){
    return !$.trim(el.html())
}
function deleteRow (item, id){
    $.get(("/skins/delete-element/"+id));
    clearSelection();
    $(item).parent().parent().parent().fadeOut(200, function(){
        $(this).remove();
        refreshSize();
        clearSelection();
    });
    var count = parseInt($("#element-count").text());
    $("#element-count").text((count - 1));
}
function clearSelection() {
    if(document.selection && document.selection.empty) {
        document.selection.empty();
    } else if(window.getSelection) {
        var sel = window.getSelection();
        sel.removeAllRanges();
    }
}
function refreshSize()
{
    var overallSize = 0;
    if ($(".element-size").length != 0)
    {
        $(".element-size").each(function(index){
            var size = parseInt($(this).data("elementsize"));
            overallSize += size;
        });
        var sizeReadable = bytesToSize(overallSize, 2);
        $("#skin-size").text(sizeReadable);
    }
    else
        $("#skin-size").text("0 bytes");

}
function bytesToSize(bytes, precision)
{
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (bytes == 0) return 'n/a';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return (bytes / Math.pow(1024, i)).toFixed(precision) + ' ' + sizes[i];
}
//skin preview options
