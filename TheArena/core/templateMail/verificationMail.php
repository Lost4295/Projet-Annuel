<?php
global $activationCode;
global $email;
    $url = "https://thearena.litecloud.fr/core/auth.php?email=".$email."&activationCode=".$activationCode;
    $bodyv="<div class='div-container'>
        <div class='row'>
            <p>Bonjour,<br> Vous avez créé votre compte sur The Arena et nous vous en remercions. Cependant, vous ne pourrez pas vous connecter
sans que votre compte ait été vérifié. Veuillez cliquer sur le lien ci dessous pour pouvoir activer votre compte.</p>
        </div>
        <div class='row'>
            <a class='btn btn-warning' href=".$url.">Activer votre compte</a>
        </div>
        <div class='row'>
            <p>Vous avez reçu cet e-mail parce que vous avez demandé à activer votre compte pour vous connecter à votre compte The Arena.
Si vous n'avez pas demandé à vous connecter, ignorez cet e-mail.</p>
        </div>
    </div>";?>