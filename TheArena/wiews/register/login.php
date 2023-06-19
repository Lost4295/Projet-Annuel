<?php
require $_SERVER['DOCUMENT_ROOT']."/core/functions.php";
noReconnection();
if ($_POST) {
    if (count($_POST) != 2 || empty($_POST["email"])|| empty($_POST["pwd"])) {
        die("Valeurs manquantes ou modifiées.");
    }
    $email=$_POST["email"];
    $password=$_POST["pwd"];
}
if (isset($email)) {
    $connection = connectToDB();
    $queryPrepared = $connection->prepare(" SELECT password, status FROM ".PREFIX."users WHERE email=:email");
    $queryPrepared->execute([
        "email"=>$email
    ]);
    
    $result=$queryPrepared->fetch();
    if (!empty($result)) { //users
        if (password_verify($password, $result['password']) && $result["status"] >= 1) {
            $query = $connection->prepare("SELECT avatar FROM ".PREFIX."users WHERE email=:email");
            $query->execute(['email'=>$email]);
            $avatar=$query->fetch();
            if (empty($avatar["avatar"])) {
                $query = $connection->prepare("UPDATE ".PREFIX."users SET avatar=:avatar WHERE email=:email");
                $query->execute([
                    'avatar'=>encodeImage($_SERVER['DOCUMENT_ROOT'].'/img/placeholder_user.png', 'png'),
                    'email'=>$email
                ]);
            }
            session_regenerate_id();
            $_SESSION['email']=$email;
            $_SESSION['logged']=true;
            $queryPrepared = $connection->prepare("UPDATE " . PREFIX . "users SET last_access_date=:last_access_date WHERE email=:email");
            $queryPrepared->execute([
                "last_access_date" => date("Y-m-d H:i:s", strtotime($user["last_access_date"])),
                "email" => $email
            ]);
            $queryPrepared = $connection->prepare(" SELECT scope FROM ".PREFIX."users WHERE email=:email");
            $queryPrepared->execute([
                "email"=>$email
            ]);
            $scope=$queryPrepared->fetch();
            unsetSessionErrors();
            $_SESSION['message'] = "Bonjour à vous !";
            switch ($scope["scope"]) {
                case SUPADMIN : //super-admin
                    header("Location:/admin");
                    break;
                case ADMIN : //admin
                    header("Location:/admin");
                    break;
                case ORGANIZER : //organisateur
                    header(INDEX);
                    break;
                default : //Joueur
                    header(INDEX);
                    break;
            }
        } else {
            if ($result["status"]==0) {
                $_SESSION["error"]="Erreur : votre compte n'est pas activé. Vérifiez vos mails. Si vous n'avez rien reçu, essayez de passer par le lien <a href='/login/help'>Un problème pour vous connecter ?</a>";
            } else {
                $_SESSION["error"]="Erreur : mot de passe incorrect.";
            }
        }
    } else {
        $_SESSION["error"]="Erreur : mot de passe incorrect.";
    }
}
if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger' role='alert'><ul>";
    //On peut tout mettre à la suite, mais je trouve ça plus compréhensible
    echo "<li>". $_SESSION['error'] . "</li>";
    echo "</ul></div>";
    }
    require $_SERVER['DOCUMENT_ROOT']."/core/header.php";
?>
<form method="post" class="m-5">
    <div class="mb-4">
        <label for="email" class="form-label">Email</label>
        <input
            type="email"
            class="form-control"
            id="email" name="email"
            placeholder="name@example.com"
            required 
            autocomplete="email"/>
    </div>
    <div class="mb-4">
        <label for="pwd" class="form-label">Mot de passe</label>
        <input type="password" class="form-control mb-3" id="pwd" name="pwd" required autocomplete="current-password">
        <a href='/login/help'>Un problème pour vous connecter ?</a>
    </div>
    <div>
        <input type="submit" class="form-control btn btn-primary mb-5" value="Se connecter">
    </div>
</form>
<?php require $_SERVER['DOCUMENT_ROOT']."/core/footer.php"?>
