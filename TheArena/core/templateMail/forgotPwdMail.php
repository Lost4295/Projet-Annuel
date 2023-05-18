<?php require "headerMail.php";
    $body="<div class='div-container'>
        <div class='row'>
            <p>Bonjour,<br> Nous avons bien reçu votre demande de nouveau mot de passe. Afin de procéder à la création d’un nouveau mot de passe, nous vous invitons à cliquer sur le lien ci-dessous :</p>
        </div>

        <div class='row'>
            <a class='btn btn-warning' href='#'>réinitialiser le mot de passe</a>
        </div>
        <div class='row'>
            <p>Si vous n’êtes pas à l'origine de cette action,<br>veuillez contacter immédiatement notre centre de relation client au 01.23.45.67.89 (prix d'un appel local) <br> ou par mail à l'adresse suivante : aaaaaaaaaa@thearena.litecloud.com.</p>
        </div>
    </div>";
 require "footerMail.php"?>