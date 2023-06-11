
window.onload = function ()
{
        var head = new Image();
        var headNum = document.getElementById("head");
        var headName = "head"+ headNum + ".png";
        head.src = headName;

        var eyes = new Image();
        var eyesNum = document.getElementById("eyes");
        var eyesName = "eyes"+ eyesNum + ".png";
        eyes.src = eyesName;
        
        var hair = new Image();
        var hairNum = document.getElementById("hair");
        var hairName = "hair"+ eyesNum + ".png";
        hair.src = hairName;

        var accessory = new Image();
        var accessoryNum = document.getElementById("accessory");
        var accessoryName = "accessory"+ accessoryNum + ".png";
        accessory.src = accessoryName;

        var mouth = new Image();
        var mouthNum = document.getElementById("mouth");
        var mouthName = "mouth"+ eyesNum + ".png";
        mouth.src = mouthName;
    
    
    head.onload=function()
    {
        buildAvatar();
    }
    function buildAvatar()
    {
        var canvas = document.getElementById("canvas");
        var ctx = canvas.getContext("2d");
        canvas.width = 200;
        canvas.height = 200;

        ctx.drawImage(head,((200-head.width)/2),25);
    }
}