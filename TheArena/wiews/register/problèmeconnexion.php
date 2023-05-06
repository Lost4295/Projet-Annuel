<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="Ma duper super page" content="Page HTML">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Arena-Connexion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/core/css/bootstrap.css">
    <link rel="stylesheet" href="/core/css/style.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="mx-3 my-2">
                    <a class="navbar-brand" href="/">
                        <img src="/img/logothearena-removebg.png" alt="Logo"  class="d-inline-block align-text-center">
                        <img src="/img/thearenatext-removebg.png" alt="The Arena" class="d-inline-block align-text-center">
                    </a>
                </div>
            </div>
        </div>
        <div class="row mr-5 mt-3">
            <div class="col-6 d-flex flex-column mt-5 justify-content-around align-items-center">
                <div><h2>Quel est votre problème ?</h2><p>Sélectionnez l’une des options ci-contre afin que nous puissions vous aider à vous connecter.</p></div><div> </div>
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col py-2 my-4">
                        <button class="btn btn-secondary btn-lg py-4 px-4" id="b1">J'ai oublié mon mot de passe</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col py-5 my-4">
                        <button class="btn btn-secondary btn-lg py-4 px-4" id="b2">J'ai oublié mon email</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col py-5 my-4">
                        <button class="btn btn-secondary btn-lg py-4 px-4" id="b3" >Mon compte est désactivé</button>
                    </div>
                </div>
            </div>
            <div id="mod1" class="modal">
                <div class="modal-content">
                    <span class="close" id="s1">&times;</span>
                    <p>fhgfbhg 111</p>
                </div>
            </div>
            <div id="mod2" class="modal">
                <div class="modal-content">
                    <span class="close" id="s2">&times;</span>
                    <p>csqfvd 22222222</p>
                </div>
            </div>
            <div id="mod3" class="modal">
                <div class="modal-content">
                    <span class="close" id="s3">&times;</span>
                    <p>bgfhgfhcn 3333333333333</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        var modal1 = document.getElementById("mod1");
        var modal2 = document.getElementById("mod2");
        var modal3 = document.getElementById("mod3");

var btn1 = document.getElementById("b1");
var btn2 = document.getElementById("b2");
var btn3 = document.getElementById("b3");

var span1 = document.getElementById("s1");
var span2 = document.getElementById("s2");
var span3 = document.getElementById("s3");



btn1.onclick = function() {
  modal1.style.display = "block";
}
btn2.onclick = function() {
  modal2.style.display = "block";
}
btn3.onclick = function() {
  modal3.style.display = "block";
}

span1.onclick = function() {
  modal1.style.display = "none";
}
span2.onclick = function() {
  modal2.style.display = "none";
}
span3.onclick = function() {
  modal3.style.display = "none";
}
    </script>
</body>
</html>