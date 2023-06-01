<!-- TODO ajouter l'api fetch pour faie des reherches sur le site -->
<!-- TODO faire en sorte de finir les events en entier (crud sur shop, back + front avec tout ce qu'il faut) -->
<!-- TODO FINIR LES MAILS -->



<?php

require $_SERVER['DOCUMENT_ROOT'] . '/core/sendmail.php';

// $body= "<h2 style='width:50%;height:40px;padding-left:190px;text-align:right;margin:0px;color:#B24909;'>Rénitialisation du mot de passe</h2>
// <p>Bonjour pseudo,<br> Cet e-mail a été créé car une nouvelle connexion au compte pseudo a été établie le 19 septembre 2022 04:03:00 PDT (19 septembre 2022 11:03:00 UTC) depuis :<br>
//     <ul style='list-style:none'>
//         <li>Lieu : <br></li>
//         <li>appareil : <br></li>
//         <li>Navigateur : <br></li>
//         <li>Adresse IP : <br></li>
//     </ul></p>        <p>
//     Si vous êtes à l'origine de cette connexion, pas de problème ! Nous voulions juste vérifier qu'il s'agissait de vous.<br>
// </p>
// <p>
//     Si vous n'êtes pas à l'origine de cette connexion, vous devez immédiatement changer votre mot de passe sur The Arena pour assurer la sécurité de votre compte.
// </p>
// <hr/>
// <div style='height:210px;'>
// <p>blah</p><br>
// <p>blah</p>";
// $header= "<!doctype html>
// <html>
// <head>
// <title></title>
// </head>
// <body>
// <div style='width:800px;background:#fff;border-style:groove;'>
// <div style='width:50%;text-align:left;'><a href='http://localhost:8000' alt='The Arena'> <img
// src=\"cid:logo\" height=60 width=60><img
// src=\"cid:text\" height=60 width=200></a></div>
// <hr width='100%' size='2' color='#ccc'>";

// echo $header.$body;

// die();
sendEmail('turin-ylan@outlook.fr', "test", 4);


$bodyfp = "<div class='div-container'>
<div class='row'>
    
</div>

<div class='row'>
    <a class='btn btn-warning' href='#'>Réinitialiser le mot de passe</a>
</div>
<div class='row'>
    <p>
        Si vous êtes à l'origine de cette connexion, pas de problème ! Nous voulions juste vérifier qu'il s'agissait de vous.<br>
    </p>
    <p>
        Si vous n'êtes pas à l'origine de cette connexion, vous devez immédiatement changer votre mot de passe sur The Arena pour assurer la sécurité de votre compte.
    </p>
</div>
</div>";