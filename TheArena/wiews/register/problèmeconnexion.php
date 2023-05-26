<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="Ma duper super page" content="Page HTML">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/img/logothearena-removebg.png" />
    <title>The Arena-Problème</title>
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
                        <img src="/img/logothearena-removebg.png" alt="Logo" class="d-inline-block align-text-center">
                        <img src="/img/thearenatext-removebg.png" alt="The Arena" class="d-inline-block align-text-center">
                    </a>
                </div>
            </div>
        </div>
        <div class="alert alert-success" id="alert" hidden>
            <span class="closebtn" onclick="disappear();">&times;</span>
            Si votre adresse mail est bien enregistrée, un email vous a été envoyé. Si vous ne recevez pas cet email,
            vérifiez votre dossier de courriers indésirables. Sinon, essayez de recréer un compte.
        </div>
        <div class="row mr-5 mt-3">
            <div class="col-6 d-flex flex-column mt-5 justify-content-around align-items-center">
                <div>
                    <h2>Quel est votre problème ?</h2>
                    <p>Sélectionnez l’une des options ci-contre afin que nous puissions vous aider à vous connecter.</p>
                </div>
                <div> </div>
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col py-2 my-4">
                        <button class="btn btn-secondary btn-lg py-4 px-4" id="b1">J'ai oublié mon mot de passe</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col py-5 my-4">
                        <button class="btn btn-secondary btn-lg py-4 px-4" id="b2">Mon compte est désactivé</button>
                    </div>
                </div>
            </div>
            <div id="mod1" class="modal">
                <div class="modal-content">
                    <span class="close" id="s1">&times;</span>
                    <form action="connectionhandler.php">
                        <p> Merci de renseigner votre adresse email. Nous enverrons un mail à cette adresse pour réinitialiser votre mot de passe.</p>
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse Email</label>
                            <input type="email" class="form-control" id="email" placeholder="name@example.com" name="email" required>
                            <label for="phonenumber" class="form-label">Numéro de téléphone</label>
                            <input type="tel" class="form-control" id="phonenumber" placeholder="Numéro de téléphone" name="phonenumber" required>
                            <input type="hidden" name="action" value="resetPassword">
                            <button type="submit" class="btn btn-primary">Continuer</button>
                        </div>
                    </form>
                </div>
            </div>
            <div id="mod2" class="modal">
                <div class="modal-content">
                    <span class="close" id="s2">&times;</span>
                    <form action="connectionhandler.php">
                        <p> Merci de renseigner votre adresse email. Nous enverrons un mail à cette adresse pour pouvoir activer votre compte.</p>
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse Email</label>
                            <input type="email" class="form-control" id="email" placeholder="name@example.com" name="email" required>
                            <input type="hidden" name="action" value="enableAccount">
                            <button type="submit" class="btn btn-primary">Continuer</button>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var modal1 = document.getElementById("mod1");
        var modal2 = document.getElementById("mod2");

        var btn1 = document.getElementById("b1");
        var btn2 = document.getElementById("b2");

        var span1 = document.getElementById("s1");
        var span2 = document.getElementById("s2");

        btn1.onclick = function() {
            modal1.style.display = "block";
        }
        btn2.onclick = function() {
            modal2.style.display = "block";
        }

        span1.onclick = function() {
            modal1.style.display = "none";
        }
        span2.onclick = function() {
            modal2.style.display = "none";
        }

        function modalGone() {
            modal1.style.display = "none";
            modal2.style.display = "none";
        }

        function disappear() {
            var x = document.getElementById("alert");
            x.style.opacity = "0";
            setTimeout(function() {
                x.style.display = "none";
            }, 600);
        }
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                console.log('Formulaire soumis:', form.id);
                console.log('Données du formulaire:', new FormData(form));
                fetch('/wiews/register/connectionhandler.php', {
                        method: 'POST',
                        body: new FormData(form)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            modalGone();
                            document.getElementById("alert").style.display = "block";
                            document.getElementById("alert").removeAttribute('hidden');
                            setTimeout(function() {
                                document.getElementById("alert").style.opacity = "1";
                            }, 100);
                            setTimeout(disappear, 5000);
                        }
                    })
            });
        });
    </script>
</body>

</html>