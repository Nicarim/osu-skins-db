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
    $(".fancybox").fancybox({
        ajax : {cache: false},
        preload : 0
    });
});
function deleteRow (item, id){
    $.get(("/file-delete/"+id),function(data){
        if (data == "success")
            $(item).parent().parent().fadeOut();
    })

}
//skin preview options
$(document).ready(function(){
    var stage = new Kinetic.Stage({
        container: "canvas-container",
        width: 1366,
        height: 768
    });
    //stage.scaleX(0.75);
    //stage.scaleY(0.75);
    //stage.setWidth(stage.width()/1.33269);
    //stage.setHeight(stage.height()/1.33269);

    var layer = new Kinetic.Layer();
    var background = new Image();
    var startX = 0;
    var startY = 0;
    //checking anchor point
    var positions = PositionFromAnchor($("#anchor-position").val(), 1366, 768);
    startX += positions.xValue;
    startY += positions.yValue;
    background.onload = function(){
        var backgroundimg = new Kinetic.Image({
            x: 0,
            y: 0,
            image: background,
            width: 1366,
            height: 768
        });
        layer.add(backgroundimg);
        stage.add(layer);

    };
    background.src = "/previews-content/1/countdown.jpg?" + new Date().now;
    var overlayLayer = new Kinetic.Layer();
    $("#anchor-position").change(function(){
        startX = PositionFromAnchor($(this).val(), 1366, 768).xValue;
        startY = PositionFromAnchor($(this).val(), 1366, 768).yValue;
        console.log(startX + " " + startY);
    });
    $("#filename").change(function(){
        try
        {
            var elementa = new Image();
            elementa.onload = function(){
                var elementimg = new Kinetic.Image({
                    x: startX - (elementa.naturalWidth / 2),
                    y: startY -  (elementa.naturalHeight / 2),
                    image: elementa
                });
                overlayLayer.remove();
                overlayLayer.add(elementimg);
                stage.clear();
                stage.add(layer);
                stage.add(overlayLayer);
            }
            elementa.src = "/skins-content/1/" + $(this).val() + "?" + new Date().now;
        }
        catch(exception){
            console.log("element not found");
        }

    });
    $("#offsetx").change(function(){
        stage.clear();
        overlayLayer.offsetX(startX + parseInt($(this).val()));
        console.log("event fired");
        stage.add(layer);
        stage.add(overlayLayer);
    });
    $("#offsety").change(function(){
        stage.clear();
        overlayLayer.offsetY(startY + parseInt($(this).val()));
        stage.add(layer);
        stage.add(overlayLayer);
    });
});
function PositionFromAnchor(anchorId, valueX, valueY){
    var xPos = 0;
    var yPos = 0;
    switch (anchorId){
        case "top":
            xPos = valueX / 2;
            yPos = 0;
            break;
        case "top-left":
            xPos = 0;
            yPos = 0;
            break;
        case "top-right":
            xPos = valueX;
            yPos = 0;
            break;
        case "middle":
            xPos = valueX / 2;
            yPos = valueY / 2;
            break;
        case "middle-left":
            xPos = 0;
            yPos = valueY / 2;
            break;
        case "middle-right":
            xPos = valueX;
            yPos = valueY / 2;
            break;
        case "bottom":
            xPos = valueX / 2;
            yPos = valueY;
            break;
        case "bottom-left":
            xPos = 0;
            yPos = valueY;
            break;
        case "bottom-right":
            xPos = valueX;
            yPos = valueY;
            break;

    }
    return {
        xValue: xPos,
        yValue: yPos
    }
}