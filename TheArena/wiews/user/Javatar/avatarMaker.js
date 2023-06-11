
window.onload = function ()
{
        // head
        var head = new Image();
        var headNum = document.getElementById("head");
        var headName = "head"+ headNum + ".png";
        head.src = headName;

        // eye
        var eyes = new Image();
        var eyesNum = document.getElementById("eyes");
        var eyesName = "eyes"+ eyesNum + ".png";
        eyes.src = eyesName;
        
        //hair
        var hair = new Image();
        var hairNum = document.getElementById("hair");
        var hairName = "hair"+ eyesNum + ".png";
        hair.src = hairName;

        // accessory
        var accessory = new Image();
        var accessoryNum = document.getElementById("accessory");
        var accessoryName = "accessory"+ accessoryNum + ".png";
        accessory.src = accessoryName;

        // mouth
        var mouth = new Image();
        var mouthNum = document.getElementById("mouth");
        var mouthName = "mouth"+ eyesNum + ".png";
        mouth.src = mouthName;
    
    
    head.onload=function()
    {
        buildAvatar();
    }

    eyes.onload=function()
    {
        buildAvatar();
    }

    hair.onload=function()
    {
        buildAvatar();
    }

    accessory.onload=function()
    {
        buildAvatar();
    }

    mouth.onload=function()
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

        ctx.drawImage(hair,((150-hair.width)/2),25);

        ctx.drawImage(eyes,((100-eyes.width)/2),50);

        ctx.drawImage(mouth,((100-mouth.width)/2),75);

        ctx.drawImage(accessory,((100-accessory.width)/2),25);
    }
}