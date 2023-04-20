<?php
define('INDEX', 'location:../index.php');
require $_SERVER['DOCUMENT_ROOT']."/core/header.php";
if ($_POST) {
    if (count($_POST) != 2 || empty($_POST["email"])|| empty($_POST["pwd"])) {
        die("Valeurs manquantes ou modifiées.");
    }
    $email=$_POST["email"];
    $password=$_POST["pwd"];
}
if (isset($email)) {
    $connection = connectToDB();
    $queryPrepared = $connection->prepare(" SELECT password FROM zeya_users WHERE email=:email");
    $queryPrepared->execute([
        "email"=>$email
    ]);
    $result=$queryPrepared->fetch();
    if (!empty($result)) { //users
        if (password_verify($password, $result['password'])) {
            $_SESSION['email']=$email;
            $_SESSION['logged']=true;
            $queryPrepared = $connection->prepare(" SELECT scope FROM zeya_users WHERE email=:email");
            $queryPrepared->execute([
                "email"=>$email
            ]);
            $scope=$queryPrepared->fetch();
            unset($_SESSION['error']);
            switch ($scope["scope"]) {
                case 105188 : //super-admin
                    header("location:../wiews/admin/indexadmin.php");
                    break;
                case 550620 : //admin
                    header("location:../wiews/admin/indexadmin.php");
                    break;
                case 245769 : //organisateur
                    header(INDEX);
                    break;
                case 824520 : //joueur/organisateur
                    header(INDEX);
                    break;
                default : //Joueur
                    header(INDEX);
                    break;
            }
        } else {
            $_SESSION["error"]="Erreur : mot de passe incorrect.";
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
?>
<form method="post" class="m-5">
    <div class="mb-4">
        <label for="email" class="form-label">Email</label>
        <input
            type="email"
            class="form-control"
            id="email" name="email"
            placeholder="name@example.com"
            required />
    </div>
    <div class="mb-4">
        <label for="pwd" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="pwd" name="pwd" required>
    </div>
    <div>
        <input type="submit" class="form-control btn btn-primary mb-5" value="Se connecter">
    </div>
</form>
<?php require $_SERVER['DOCUMENT_ROOT']."/core/footer.php"?>
