
window.onload = function ()
{
        var head = new Image();
        var headNum = numHead;
        var headName = "head"+ headNum + ".png";
        head.src = headName;
    
    
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