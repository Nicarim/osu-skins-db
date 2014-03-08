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
    var elementa = new Image();
    var elementimg;
    //checking anchor point
    var positions = PositionFromAnchor($("#anchor-position").val(), 1366, 768, 0, 0);
    startX = positions.xValue;
    startY = positions.yValue;
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
        checkAnchorOffset(this);
        drawElement();
        console.log(startX + " " + startY);
    });
    $("#filename").change(function(){
        try
        {
            elementa.onload = function(){
                drawElement();
            }
            elementa.src = "/skins-content/1/" + $(this).val() + "?" + new Date().now;
        }
        catch(exception){
            console.log("element not found");
        }

    });
    function drawElement(){
        checkAnchorOffset($("#anchor-position"))
        elementimg = new Kinetic.Image({
            x: startX - (elementa.naturalWidth / 2),
            y: startY - (elementa.naturalHeight / 2),
            image: elementa
        });
        overlayLayer.destroy();
        overlayLayer = new Kinetic.Layer();
        overlayLayer.add(elementimg);
        stage.clear();
        stage.add(layer);
        stage.add(overlayLayer);
    }
    function checkAnchorOffset(input){
        startX = PositionFromAnchor($(input).val(), 1366, 768, elementa.naturalHeight, elementa.naturalWidth).xValue;
        startY = PositionFromAnchor($(input).val(), 1366, 768, elementa.naturalHeight, elementa.naturalWidth).yValue;
    }
    $("#offsetx").change(function(){
        overlayLayer.offsetX(-(parseInt($(this).val())));
        stage.clear();
        stage.add(layer);
        stage.add(overlayLayer);
    });
    $("#offsety").change(function(){

        overlayLayer.offsetY(-(parseInt($(this).val())));
        stage.clear();
        stage.add(layer);
        stage.add(overlayLayer);
    });
});
function PositionFromAnchor(anchorId, valueX, valueY, elementHeight, elementWidth){
    var xPos = 0;
    var yPos = 0;
    switch (anchorId){
        case "top":
            xPos = (valueX / 2);
            yPos = 0 + (elementHeight / 2);
            break;
        case "top-left":
            xPos = 0 + (elementWidth / 2);
            yPos = 0 + (elementHeight / 2);
            break;
        case "top-right":
            xPos = valueX - (elementWidth / 2);
            yPos = 0 + (elementHeight / 2);
            break;
        case "middle":
            xPos = valueX / 2;
            yPos = valueY / 2;
            break;
        case "middle-left":
            xPos = 0 + (elementWidth / 2);
            yPos = valueY / 2;
            break;
        case "middle-right":
            xPos = valueX - (elementWidth / 2);
            yPos = valueY / 2;
            break;
        case "bottom":
            xPos = valueX / 2;
            yPos = valueY - (elementHeight / 2);
            break;
        case "bottom-left":
            xPos = 0 + (elementWidth / 2);
            yPos = valueY - (elementHeight / 2);
            break;
        case "bottom-right":
            xPos = valueX - (elementWidth / 2);
            yPos = valueY - (elementHeight / 2);
            break;

    }
    return {
        xValue: xPos,
        yValue: yPos
    }
}