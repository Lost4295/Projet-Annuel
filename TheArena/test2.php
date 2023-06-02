<!-- TODO ajouter l'api fetch pour faire des reherches sur le site -->
<!-- TODO faire en sorte de finir les events en entier (crud sur shop, back + front avec tout ce qu'il faut) -->



<body>
    <div>
        <div id="slideSource"
              style="width:150px; height:20px;
                    text-align:center; background:green"
             onclick="fade(this)">
            Take It up
        </div>
        <div id="panel"
              style="width:150px; height:130px;
                    text-align:center; background:red;
                    opacity:1.0;">
            Contents
        </div>
    </div>
</body>
</html>


<script>
function fade(element) {
    var op = 1;  // initial opacity
    var timer = setInterval(function () {
        if (op <= 0.1){
            clearInterval(timer);
            element.style.display = 'none';
        }
        element.style.opacity = op;
        element.style.filter = 'alpha(opacity=' + op * 100 + ")";
        op -= op * 0.1;
    }, 10);
    setTimeout(function() { unfade(element); }, 400);
    console.log("done")

}

function unfade(element) {
    var op = 0.1;  // initial opacity
    element.style.display = 'block';
    var timer = setInterval(function () {
        if (op >= 1){
            clearInterval(timer);
        }
        element.style.opacity = op;
        element.style.filter = 'alpha(opacity=' + op * 100 + ")";
        op += op * 0.1;
    }, 10);
}
</script>