
window.onload = function ()
{
        // head
        var head = new Image();
        var headNum = Math.floor(Math.random()*3)+1;
        var headName = "head"+ headNum + ".png";
        head.src ="/wiews/user/Javatar/avatarsAtributes/head/"+ headName;

        // eye
        var eyes = new Image();
        var eyesNum = Math.floor(Math.random()*3)+1;
        var eyesName = "eyes"+ eyesNum + ".png";
        eyes.src ="/wiews/user/Javatar/avatarsAtributes/eye/"+ eyesName;
        

        // accessory
        var accessory = new Image();
        var accessoryNum = Math.floor(Math.random()*3)+1;
        var accessoryName = "accessory"+ accessoryNum + ".png";
        accessory.src ="/wiews/user/Javatar/avatarsAtributes/accessory/"+ accessoryName;

        // mouth
        var mouth = new Image();
        var mouthNum = Math.floor(Math.random()*3)+1;
        var mouthName = "mouth"+ mouthNum + ".png";
        mouth.src ="/wiews/user/Javatar/avatarsAtributes/mouth/"+ mouthName;
    
    
    head.onload=function()
    {
        buildAvatar();
    }

    eyes.onload=function()
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
        ctx.globalAlpha= 0.1;

        ctx.globalAlpha.drawImage(head,((200-head.width)/2),25);

        ctx.globalAlpha.drawImage(eyes,((200-eyes.width)/2),50);

        ctx.globalAlpha.drawImage(mouth,((200-mouth.width)/2),75);

        ctx.globalAlpha.drawImage(accessory,((200-accessory.width)/2),50);


        
    }

}
